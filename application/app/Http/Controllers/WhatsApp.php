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
use App\Models\FranchisePhone;

class WhatsApp extends Controller {

    protected $baseUrl = 'https://graph.facebook.com/v17.0';
    protected $token;

    /**
     * Constructor del controlador WhatsApp.
    */
    public function __construct()
    {
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

        FranchisePhone::updateOrCreate(
            ['phone_id' => $request->phone_id],
            [
                'franchise_id' => $request->franchise_id,
                'phone_number' => $request->phone_number
            ]
        );

        return back()->with('success', 'Número de teléfono asociado exitosamente con la franquicia.');
    }


    public function disassociatePhoneNumber(Request $request, $phone_id)
    {
        $result = FranchisePhone::where('phone_id', $phone_id)->delete();

        if ($result) {
            return back()->with('success', 'Número de teléfono desasociado con éxito.');
        } else {
            return back()->with('error', 'No se pudo desasociar el número de teléfono.');
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
     * Envía un mensaje de WhatsApp usando un phoneNumberId.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
    */
    public function sendMessage(Request $request)
    {
        $phoneNumberId = '153911164477477';
        $to = '543413342827';
        $message = 'Este es mi mensajito de prueba :)';

        $url = "{$this->baseUrl}/{$phoneNumberId}/messages";
        $data = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => 'template',
            'template' => [
                'name' => 'hello_world',
                'language' => [
                    'code' => 'en_US'
                ],
            ]
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

    public function recibe()
    {
        $response = file_get_contents('php://input');
    
        if ($response == null) {
            file_put_contents("prueba.txt", "No response received\n", FILE_APPEND);
            exit;
        }   
    
        $decoded_response = json_decode($response, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            file_put_contents("prueba.txt", 'JSON decode error: ' . json_last_error_msg() . "\n", FILE_APPEND);
            exit;
        }
    
        $message = $decoded_response['entry'][0]['changes'][0]['value']['messages'][0] ?? null;
    
        if ($message === null) {
            file_put_contents("prueba.txt", 'Invalid data structure' . "\n", FILE_APPEND);
            exit;
        }
    
        $message_received = "Telefono: " . $message['from']
                            . "\nFecha: " . $message['timestamp']
                            . "\nMensaje: " . $message['text']['body'];
    
        file_put_contents("prueba.txt", $message_received . "\n", FILE_APPEND);
    }

}
