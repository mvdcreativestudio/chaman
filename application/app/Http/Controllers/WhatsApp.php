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

class WhatsApp extends Controller {

    protected $baseUrl = 'https://graph.facebook.com/v18.0';
    protected $token = 'EAAPQO0GzAMgBOwO7xaDsNRe6vO6TLCZCmWqavUVJrPsUheV1atom3K6e8vTD698MoPFPZA7UZCEYrLwlCTshhs2WWFGqpU8qJgFZCgy0pllA1HgilE9Dw6WZAnaUTSMQxRcFyLZAxNW3mnTmsKOh0ZAyxsbmK1DdS6eiZBbeECks8eiFkDFhgofBTIbDhbbd8MXU'; // Token de acceso

    
    /**
     * Obtiene las cuentas de WhatsApp Business asociadas al negocio.
     * 
     * @param string $businessId El ID del negocio en Facebook.
     * @return \Illuminate\Http\Response
    */

    public function getOwnedWhatsAppBusinessAccounts($businessId)
    {
        $url = "{$this->baseUrl}/{$businessId}/owned_whatsapp_business_accounts"; // Tambien puede ser client_whatsapp_business_accounts
        $response = Http::withToken($this->token)
                        ->withHeaders(['Content-Type' => 'application/json'])
                        ->get($url);

        if ($response->successful()) {
            return response()->json($response->json());
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
     * Envía un mensaje de WhatsApp usando un phoneNumberId.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
    */
    public function sendMessage(Request $request)
    {
        $phoneNumberId = '163376956858600';
        $to = '543413342827';
        $message = 'HOlaaaaaaaaaaa';

        $url = "{$this->baseUrl}/{$phoneNumberId}/messages";
        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'body' => $message
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
