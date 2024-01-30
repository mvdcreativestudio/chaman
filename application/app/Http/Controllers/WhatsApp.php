<?php
/** --------------------------------------------------------------------------------
 * Este controlador maneja toda la lógica de envío de mensajes de Whatsapp de la aplicación
 *
 * @package    Sumeria Apps
 * @author     Santiago Paradelo
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\SumeriaSetting;
use App\Models\PhoneNumber;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Josantonius\MimeType\MimeType;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class WhatsApp extends Controller {

    protected $baseUrl = 'https://graph.facebook.com/v17.0';
    protected $token;

    /**
     * Constructor del controlador WhatsApp.
    */
    public function __construct()
    {
        //core controller instantation
        parent::__construct();

        $this->middleware('auth')->except(['webhook', 'recibe']);

        $this->token = SumeriaSetting::where('setting_name', 'admin_token')->value('setting_value');
    }

    /**
     * Actualiza o crea el ID del negocio (business_id) de Meta en la configuración.
     * 
     * @param Request $request La solicitud HTTP que contiene el ID del negocio.
     * @return \Illuminate\Http\RedirectResponse Redirige de vuelta al formulario con un mensaje de éxito o error.
     */
    public function updateMetaBusinessId(Request $request)
    {
        $validatedData = $request->validate([
            'meta_business_id' => 'required|string',
        ]);

        SumeriaSetting::updateOrCreate(
            [
                'setting_name' => 'meta_business_id'
            ],
            [
                'setting_value' => $validatedData['meta_business_id'],
                'setting_type' => 'token',
            ]
        );

        return back()->with('success', 'ID del Negocio actualizado correctamente.');
    }

    /**
     * Actualiza o crea el ID del negocio (business_id) de Meta en la configuración.
     * 
     * @param Request $request La solicitud HTTP que contiene el ID del negocio.
     * @return \Illuminate\Http\RedirectResponse Redirige de vuelta al formulario con un mensaje de éxito o error.
     */
    public function updateAdminToken(Request $request)
    {
        $request->validate(['admin_token' => 'required|string']);

        // Actualizar el token en la base de datos
        SumeriaSetting::updateOrCreate(
            [
                'setting_name' => 'admin_token'
            ],
            [
                'setting_value' => $request->admin_token,
                'setting_type' => 'token',
            ]
        );

        return redirect()->back()->with('success', 'Token actualizado con éxito');
    }

    
    public function associatePhoneNumberWithFranchise(Request $request)
    {   
        $request->validate([
            'franchise_id' => 'required|exists:franchises,id',
            'phone_id' => 'required|string',
            'phone_number' => 'required|string',
        ]);
    
        PhoneNumber::updateOrCreate(
            ['phone_id' => $request->phone_id],
            [
                'phone_number' => str_replace(['-', ' ', '+'], '', $request->phone_number),
                'is_franchise' => true,
                'franchise_id' => $request->franchise_id,
            ]
        );
    
        return back()->with('success', 'Número de teléfono asociado exitosamente con la franquicia.');
    }
    


    public function disassociatePhoneNumber(Request $request, $phone_id)
    {
        $phoneNumber = PhoneNumber::where('phone_id', $phone_id)->where('is_franchise', true)->first();
    
        if ($phoneNumber) {
            $phoneNumber->update([
                'is_franchise' => false,
                'franchise_id' => null,
            ]);
            return back()->with('success', 'Número de teléfono desasociado con éxito.');
        } else {
            return back()->with('error', 'No se encontró el número de teléfono asociado con una franquicia.');
        }
    }    
    
    /**
     * Obtiene las cuentas de WhatsApp Business asociadas al negocio.
     * 
     * @param string $businessId El ID del negocio en Facebook.
     * @return \Illuminate\Http\Response
    */

    public function getOwnedWhatsAppBusinessAccounts()
    {

        $businessId = SumeriaSetting::where('setting_name', 'meta_business_id')->value('setting_value');
        
        // Verificar si businessId existe
        if (!$businessId) {
            return response()->json(['error' => 'No se encontró el ID del negocio en las configuraciones.'], 404);
        }

        $url = "{$this->baseUrl}/{$businessId}/owned_whatsapp_business_accounts"; // Tambien puede ser client_whatsapp_business_accounts
        $response = Http::withToken($this->token)
                        ->withHeaders(['Content-Type' => 'application/json'])
                        ->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData['data'] ?? [];
        } else {
            // Manejo de errores
            return response()->json(['error' => $response->body()], $response->status());
        }
    }

    /**
     * Obtiene los numeros de telefono asociados a una cuenta de WhatsApp Business.
     * 
     * @param string $businessId El ID del negocio en Facebook.
     * @return \Illuminate\Http\Response
    */

    public function getPhoneNumbers($whatsAppBusinessAccountId) {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/{$whatsAppBusinessAccountId}/phone_numbers");

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']; // Retorna los números de teléfono asociados
        } else {
            // Manejo de errores
            return response()->json(['error' => $response->body()], $response->status());
        }
    }

    /**
    * Obtiene las cuentas de WhatsApp Business y sus números de teléfono asociados.
    *
    * @return array|Illuminate\Http\JsonResponse
    */
    public function getWhatsAppBusinessData()
    {
        $businessId = SumeriaSetting::where('setting_name', 'meta_business_id')->value('setting_value');
        
        if (!$businessId) {
            return []; // Devuelve un array vacío si no hay businessId
        }
    
        $accounts = $this->getOwnedWhatsAppBusinessAccounts($businessId);
    
        if (!is_array($accounts)) {
            return []; // Devuelve un array vacío si hay un error en la solicitud
        }
    
        foreach ($accounts as $key => $account) {
            $phoneNumbers = $this->getPhoneNumbers($account['id']);
    
            if (!is_array($phoneNumbers)) {
                $phoneNumbers = []; // Asegúrate de que phoneNumbers sea siempre un array
            }
    
            $accounts[$key]['phone_numbers'] = $phoneNumbers;
        }
    
        return $accounts;
    }

    /**
     * Carga un archivo multimedia a los servidores de WhatsApp y devuelve el ID de medios.
     *
     * @param Request $request
     * @return string|null El ID de medios o null en caso de error.
     */
    public function uploadMedia(Request $request)
    {
        $phoneNumberId = $request->input('phone_number_id');
        $file = $request->file('media'); // El archivo multimedia

        if (!$file) {
            return null;
        }

        $url = "{$this->baseUrl}/{$phoneNumberId}/media";

        $response = Http::withToken($this->token)
                        ->attach('file', file_get_contents($file), $file->getClientOriginalName())
                        ->post($url);

        if ($response->successful()) {
            return $response->json()['id'] ?? null;
        } else {
            // Manejo de errores
            return null;
        }
    }

    /**
     * Envía un mensaje de texto de WhatsApp.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $phoneNumberId = $request->input('phone_number_id');
        $to = $request->input('to');
        $message = $request->input('message');

        $url = "{$this->baseUrl}/{$phoneNumberId}/messages";
        $data = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'body' => $message
            ],
        ];

        $response = Http::withToken($this->token)
                        ->withHeaders(['Content-Type' => 'application/json'])
                        ->post($url, $data);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            // Manejo de errores
            return response()->json(['error' => $response->body()], $response->status());
        }
    }

    /**
     * Carga y envía un mensaje multimedia de WhatsApp.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendMediaMessage(Request $request)
    {
        $phoneNumberId = $request->input('phone_number_id');
        $to = $request->input('to');
        $type = $request->input('type');
        $mediaId = $this->uploadMedia($request);

        if (!$mediaId) {
            return response()->json(['error' => 'Error al cargar el archivo multimedia'], 500);
        }

        $url = "{$this->baseUrl}/{$phoneNumberId}/messages";
        $data = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => $type,
            $type => ['id' => $mediaId]
        ];

        $response = Http::withToken($this->token)
                        ->withHeaders(['Content-Type' => 'application/json'])
                        ->post($url, $data);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            // Manejo de errores
            return response()->json(['error' => $response->body()], $response->status());
        }
    }

    /**
     * Webhook encargado de recibir los mensajes enviados y recibidos de WhatsApp.
     *
    */
    public function webhook()
    {
        $token = 'SumeriaWPApp';
    
        $hub_challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : '';

        $hub_verify_token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';

        if ($token === $hub_verify_token) {
            echo $hub_challenge;
            exit;
        }
    }

    /**
     * Descarga un archivo multimedia de WhatsApp.
     *
     * @param string $mediaId El ID del archivo multimedia.
     * @param string $extension La extensión del archivo multimedia.
     * @return string|null
    */
    public function downloadMedia($mediaId, $extension)
    {
        $tempUrl = $this->getMediaUrl($mediaId);
        file_put_contents("WPRES.txt", "Temp URL: " . $tempUrl . "\n", FILE_APPEND);
    
        if ($tempUrl) {
            $ch = curl_init($tempUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'curl/7.64.1');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer " . $this->token
            ]);
    
            $data = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
    
            if ($error) {
                file_put_contents("WPRES.txt", "Error en cURL: " . $error . "\n", FILE_APPEND);
                return null;
            }
    
            if ($data) {
                $path = 'whatsapp_media/' . $mediaId . $extension; 
                Storage::disk('public')->put($path, $data);
                $publicPath = 'storage/' . $path;
                return $publicPath;
            } else {
                file_put_contents("WPRES.txt", "No se recibieron datos\n", FILE_APPEND);
                return null;
            }
        }
    
        return null;
    }
    
    /**
     * Obtiene la URL de descarga de un archivo multimedia de WhatsApp.
     *
     * @param string $mediaId El ID del archivo multimedia.
     * @return string|null
    */
    protected function getMediaUrl($mediaId)
    {
        try {
            $response = Http::withToken($this->token)->get("{$this->baseUrl}/$mediaId");
            if ($response->successful()) {
                file_put_contents("WPRES.txt", "Image Response: " . $response . "\n", FILE_APPEND);
                $data = $response->json();
                return $data['url'] ?? null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Obtiene la extensión de un archivo multimedia en función de su MIME type.
     * 
     * @param string $mimeType El MIME type del archivo multimedia.
     * @return string La extensión del archivo multimedia.
    */
    private function getExtensionFromMimeType($mimeType)
    {
        file_put_contents("WPRES.txt", "MIME Type: " . $mimeType . "\n", FILE_APPEND);
    
        $mime = new MimeType();
        $extension = $mime->getExtension($mimeType);    
    
        if ($extension) {
            return '.' . $extension;
        } else {
            return '';
        }
    }

    /**
     * Procesa los mensajes recibidos de WhatsApp.
     *
     * @return void
    */
    public function recibe()
    {
        try {
            $response = file_get_contents('php://input');
        
            if ($response == null) {
                file_put_contents("WPRES.txt", "No response received\n", FILE_APPEND);
                exit;
            }

            file_put_contents("WPRES.txt", $response . "\n", FILE_APPEND);
            
            $decoded_response = json_decode($response, true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
                file_put_contents("WPRES.txt", 'JSON decode error' . "\n", FILE_APPEND);
                exit;
            }
    
            // Obtener el tipo de mensaje
            $messageType = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['type'];

            // Obtener el ID del receptor y del remitente
            $receiverPhoneNumberId = $decoded_response['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'] ?? null;
            $senderPhoneNumberId = $decoded_response['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];

            // Buscar o crear el PhoneNumber para el receptor y el remitente
            $receiverPhone = PhoneNumber::firstOrCreate(['phone_id' => $receiverPhoneNumberId], [
                'phone_number' => $decoded_response['entry'][0]['changes'][0]['value']['metadata']['display_phone_number'],
                'phone_number_owner' => $decoded_response['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'],
            ]);
    
            $senderPhone = PhoneNumber::firstOrCreate(['phone_id' => $senderPhoneNumberId], [
                'phone_number_owner' => $decoded_response['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'],
                'phone_number' => $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['from'],
            ]);

            if ($messageType == 'text') {
                $this->processTextMessage($decoded_response, $senderPhone, $receiverPhone);
            } elseif ($messageType == 'image') {
                $this->processImageMessage($decoded_response, $senderPhone, $receiverPhone);
            } elseif ($messageType == 'audio') {
                $this->processAudioMessage($decoded_response, $senderPhone, $receiverPhone);
            } elseif ($messageType == 'document') {
                $this->processDocumentMessage($decoded_response, $senderPhone, $receiverPhone);
            } elseif ($messageType == 'video') {
                $this->processVideoMessage($decoded_response, $senderPhone, $receiverPhone);
            } elseif ($messageType == 'sticker') {
                $this->processStickerMessage($decoded_response, $senderPhone, $receiverPhone);
            }

        } catch (\Exception $e) {
            file_put_contents("WPRES.txt", "Error: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    /**
     * Procesa los mensajes de texto recibidos de WhatsApp.
     *
     * @param array $decoded_response El arreglo decodificado de la respuesta de WhatsApp.
     * @param PhoneNumber $senderPhone El PhoneNumber del remitente.
     * @param PhoneNumber $receiverPhone El PhoneNumber del receptor.
     * @return void
    */
    private function processTextMessage($decoded_response, $senderPhone, $receiverPhone)
    {
        $created = date("Y-m-d H:i:s", $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']);
        $messageBody = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];

        // Crear un nuevo mensaje de texto
        Message::create([
            'from_phone_id' => $senderPhone->id,
            'to_phone_id' => $receiverPhone->id,
            'message_source' => 'whatsapp',
            'message_type' => 'text',
            'message_text' => $messageBody,
            'created_at' => $created,
        ]);

        $franchise_id = auth()->user();
        file_put_contents("WPRES.txt", "Franchise ID: " . $franchise_id . "\n", FILE_APPEND);

        event(new MessageSent($senderPhone->id, $receiverPhone->id, auth()->user()->franchise_id));
        file_put_contents("WPRES.txt", "Message sent event fired\n", FILE_APPEND);
    }

    /**
     * Procesa los mensajes de imagenes recibidas de WhatsApp.
     *
     * @param array $decoded_response El arreglo decodificado de la respuesta de WhatsApp.
     * @param PhoneNumber $senderPhone El PhoneNumber del remitente.
     * @param PhoneNumber $receiverPhone El PhoneNumber del receptor.
     * @return void
    */
    private function processImageMessage($decoded_response, $senderPhone, $receiverPhone)
    {
        $created = date("Y-m-d H:i:s", $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']);
        $imageData = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['image'];
        $imageId = $imageData['id'];
        $imageCaption = $imageData['caption'] ?? '';
        $imageMimeType = $imageData['mime_type'];
    
        file_put_contents("WPRES.txt", "Image ID: " . $imageId . "\n", FILE_APPEND);
    
        $extension = $this->getExtensionFromMimeType($imageMimeType);
        $imageUrl = $this->downloadMedia($imageId, $extension);
        file_put_contents("WPRES.txt", "Image URL: " . $imageUrl . "\n", FILE_APPEND);
    
        if ($imageUrl) {
            Message::create([
                'from_phone_id' => $senderPhone->id,
                'to_phone_id' => $receiverPhone->id,
                'message_source' => 'whatsapp',
                'image_url' => $imageUrl,
                'message_text' => $imageCaption,
                'message_type' => 'image',
                'created_at' => $created,
            ]);
        } else {
            return response()->json(['error' => 'No se crear el mensaje de imagen'], 500);
        }

        event(new MessageSent($senderPhone->id, $receiverPhone->id, auth()->user()->franchise_id));
    }
    
    
    /**
     * Procesa los mensajes de audios recibidos de WhatsApp.
     *
     * @param array $decoded_response El arreglo decodificado de la respuesta de WhatsApp.
     * @param PhoneNumber $senderPhone El PhoneNumber del remitente.
     * @param PhoneNumber $receiverPhone El PhoneNumber del receptor.
     * @return void
    */
    private function processAudioMessage($decoded_response, $senderPhone, $receiverPhone)
    {
        $created = date("Y-m-d H:i:s", $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']);
        $audioData = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['audio'];
        $audioId = $audioData['id'];
        $audioMimeType = $audioData['mime_type'];

        file_put_contents("WPRES.txt", "Audio ID: " . $audioId . "\n", FILE_APPEND);

        $extension = $this->getExtensionFromMimeType($audioMimeType);
        
        $audioUrl = $this->downloadMedia($audioId, $extension);
        file_put_contents("WPRES.txt", "Audio URL: " . $audioUrl . "\n", FILE_APPEND);

        $audioCaption = $audioData['caption'] ?? '';

        if ($audioUrl) {
            Message::create([
                'from_phone_id' => $senderPhone->id,
                'to_phone_id' => $receiverPhone->id,
                'message_text' => $audioCaption,
                'message_source' => 'whatsapp',
                'audio_url' => $audioUrl,
                'message_type' => 'audio',
                'created_at' => $created,
            ]);
        } else {
            return response()->json(['error' => 'No se pudo crear el mensaje de audio'], 500);
        }

        event(new MessageSent($senderPhone->id, $receiverPhone->id, auth()->user()->franchise_id));
    }

    /**
     * Procesa los mensajes de documentos recibidos de WhatsApp.
     *
     * @param array $decoded_response El arreglo decodificado de la respuesta de WhatsApp.
     * @param PhoneNumber $senderPhone El PhoneNumber del remitente.
     * @param PhoneNumber $receiverPhone El PhoneNumber del receptor.
     * @return void
    */
    private function processDocumentMessage($decoded_response, $senderPhone, $receiverPhone)
    {
        $created = date("Y-m-d H:i:s", $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']);
        $documentData = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['document'];
        $documentId = $documentData['id'];
        $documentMimeType = $documentData['mime_type'];

        file_put_contents("WPRES.txt", "Document ID: " . $documentId . "\n", FILE_APPEND);

        $extension = $this->getExtensionFromMimeType($documentMimeType);

        $documentUrl = $this->downloadMedia($documentId, $extension);
        file_put_contents("WPRES.txt", "Document URL: " . $documentUrl . "\n", FILE_APPEND);

        $documentCaption = $documentData['caption'] ?? '';

        if ($documentUrl) {
            if ($documentMimeType == 'audio/mpeg') {
                Message::create([
                    'from_phone_id' => $senderPhone->id,
                    'to_phone_id' => $receiverPhone->id,
                    'message_source' => 'whatsapp',
                    'audio_url' => $documentUrl,
                    'message_text' => $documentCaption,
                    'message_type' => 'audio',
                    'created_at' => $created,
                ]);
            } else {
                Message::create([
                    'from_phone_id' => $senderPhone->id,
                    'to_phone_id' => $receiverPhone->id,
                    'message_source' => 'whatsapp',
                    'document_url' => $documentUrl,
                    'message_text' => $documentCaption,
                    'message_type' => 'document',
                    'created_at' => $created,
                ]);
            }
        } else {
            return response()->json(['error' => 'No se pudo crear el mensaje de documento'], 500);
        }

        event(new MessageSent($senderPhone->id, $receiverPhone->id, auth()->user()->franchise_id));
    }

    /**
     * Procesa los mensajes de videos recibidos de WhatsApp.
     *
     * @param array $decoded_response El arreglo decodificado de la respuesta de WhatsApp.
     * @param PhoneNumber $senderPhone El PhoneNumber del remitente.
     * @param PhoneNumber $receiverPhone El PhoneNumber del receptor.
     * @return void
    */
    private function processVideoMessage($decoded_response, $senderPhone, $receiverPhone)
    {
        $created = date("Y-m-d H:i:s", $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']);
        $videoData = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['video'];
        $videoId = $videoData['id'];
        $videoMimeType = $videoData['mime_type'];

        file_put_contents("WPRES.txt", "Video ID: " . $videoId . "\n", FILE_APPEND);

        $extension = $this->getExtensionFromMimeType($videoMimeType);

        $videoUrl = $this->downloadMedia($videoId, $extension);
        file_put_contents("WPRES.txt", "Video URL: " . $videoUrl . "\n", FILE_APPEND);

        $videoCaption = $videoData['caption'] ?? '';

        if ($videoUrl) {
            Message::create([
                'from_phone_id' => $senderPhone->id,
                'to_phone_id' => $receiverPhone->id,
                'message_source' => 'whatsapp',
                'video_url' => $videoUrl,
                'message_text' => $videoCaption,
                'message_type' => 'video',
                'created_at' => $created,
            ]);
        } else {
            return response()->json(['error' => 'No se pudo crear el mensaje de video'], 500);
        }

        event(new MessageSent($senderPhone->id, $receiverPhone->id, auth()->user()->franchise_id));
    }

    /**
     * Procesa los mensajes de stickers recibidos de WhatsApp.
     *
     * @param array $decoded_response El arreglo decodificado de la respuesta de WhatsApp.
     * @param PhoneNumber $senderPhone El PhoneNumber del remitente.
     * @param PhoneNumber $receiverPhone El PhoneNumber del receptor.
     * @return void
    */
    private function processStickerMessage($decoded_response, $senderPhone, $receiverPhone)
    {
        $created = date("Y-m-d H:i:s", $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']);
        $stickerData = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0]['sticker'];
        $stickerId = $stickerData['id'];
        $stickerMimeType = $stickerData['mime_type'];

        file_put_contents("WPRES.txt", "Sticker ID: " . $stickerId . "\n", FILE_APPEND);

        $extension = $this->getExtensionFromMimeType($stickerMimeType);
        
        $stickerUrl = $this->downloadMedia($stickerId, $extension);
        file_put_contents("WPRES.txt", "Sticker URL: " . $stickerUrl . "\n", FILE_APPEND);

        if ($stickerUrl) {
            Message::create([
                'from_phone_id' => $senderPhone->id,
                'to_phone_id' => $receiverPhone->id,
                'message_source' => 'whatsapp',
                'sticker_url' => $stickerUrl,
                'message_type' => 'sticker',
                'created_at' => $created,
            ]);
        } else {
            return response()->json(['error' => 'No se pudo crear el mensaje de sticker'], 500);
        }

        event(new MessageSent($senderPhone->id, $receiverPhone->id, auth()->user()->franchise_id));
    }


}
