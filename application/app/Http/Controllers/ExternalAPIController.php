<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ExternalAPIController extends Controller
{
    private $baseUri = 'https://facturacion.chamanuruguay.uy/';
    private $token = '717efb612e1c30cb29f9a3b4d64abfdec9e45874';

    private function apiRequest($endpoint) {
        $response = Http::withHeaders([
            'X-Orion-osectoken' => $this->token
        ])->get($this->baseUri . $endpoint);

        return $response->json();
    }

    public function getClientes() {
        $response = $this->apiRequest('RUT218168420010@crmAPI/Consultas/clientes?todos=1');
    
        if ($response['error'] == 0 && isset($response['items'])) {
            foreach ($response['items'] as $item) {
                \App\Models\Client::updateOrCreate(
                    [
                        'franchise_ruc' => $item['rucFranquicia'] ?? null,
                    ],
                    [
                        'client_company_name' => $item['nombre'] ?? null,
                        'client_phone' => $item['celular'] ?? null,
                        'client_billing_street' => $item['direccion'] ?? null,
                        'client_billing_city' => $item['ciudad'] ?? null,
                        'client_billing_state' => $item['departamento'] ?? null,
                        'client_billing_country' => $item['pais'] ?? null,
                        'client_creatorid' => auth()->id(),
                        'client_created' => now(),
                        'client_updated' => now(),
                    ]
                );
            }
        }
    
        return response()->json($response);
    }    

    public function getProductos() {
        $response = $this->apiRequest('RUT218168420010@crmAPI/Consultas/productos?todos=1');
    
        if ($response['error'] == 0 && isset($response['items'])) {
            foreach ($response['items'] as $item) {
                \App\Models\Item::updateOrCreate(
                    [
                        'item_id' => $item['codigo'] ?? null,
                    ],
                    [
                        'item_description' => $item['nombre'] ?? null,
                        'item_rate' => $item['precio'] ?? 0,
                        'item_creatorid' => auth()->id(),
                        'item_created' => now(),
                        'item_updated' => now(),
                    ]
                );
            }
        }
    
        return response()->json($response);
    }
    

    public function getProveedores() {
        return $this->apiRequest('RUT218168420010@crmAPI/Consultas/proveedores');
    }

    public function getVentas() {
        return $this->apiRequest('RUT218168420010@crmAPI/Consultas/ventas');
    }
}
