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
                try {
                    \App\Models\Client::createOrUpdate(
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
                } catch (\Exception $e) {
                    \Log::error('Error al procesar el cliente con RUC ' . ($item['rucFranquicia'] ?? 'desconocido') . ': ' . $e->getMessage());
                }
                
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
                        'codigo' => $item['codigo'],
                        'rucFranquicia' => $item['rucFranquicia'],
                    ],
                    [
                        'nombre' => $item['nombre'],
                        'item_rate' => $item['precio'] ?? 0,
                        'stock' => $item['stock'],
                        'categoria' => $item['categoria'],
                        'accion' => $item['accion'],
                        'item_description' => $item['descripcion'],
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
        $response = $this->apiRequest('RUT218168420010@crmAPI/Consultas/proveedores?todos=1');
    
        if ($response['error'] == 0 && isset($response['items'])) {
            foreach ($response['items'] as $item) {
                \App\Models\Suppliers::updateOrCreate(
                    [
                        'razon_social' => $item['razon_social'],
                        'rucFranquicia' => $item['rucFranquicia'],
                    ],
                    [
                        'nombre' => $item['nombre'],
                        'direccion' => $item['direccion'] ?? '-',
                        'telefono' => $item['telefono'] ?? '-',
                        'celular' => $item['celular'] ?? '-',
                        'email' => $item['email'] ?? '-',
                        'ciudad' => $item['ciudad'] ?? '-',
                        'departamento' => $item['departamento'] ?? '-',
                        'pais' => $item['pais'] ?? '-',
                        'accion' => $item['accion'],
                    ]
                );
            }
        }
    
        return response()->json($response);
    }

    // public function getVentas() {
    //     $response = $this->apiRequest('RUT218168420010@crmAPI/Consultas/ventas?todos=1&pagina=1');

    //     if ($response['error'] == 0 && isset($response['items'])) {
    //         foreach ($response['items'] as $item) {
    //             \App\Models\Sale::updateOrCreate(
    //                 [
    //                     'lineas' => $item['lineas'] ?? null,
    //                     'impuestos' => $item['impuestos'] ?? null,
    //                     'subtotal' => $item['subtotal'] ?? null,
    //                     'total' => $item['total'] ?? null,
    //                     'moneda' => $item['moneda'] ?? null,
    //                     'moneda_id' => $item['moneda_id'] ?? null,
    //                     'estado' => $item['estado'] ?? null,
    //                     'fecha_creacion' => $item['fecha_creacion'] ?? null,
    //                     'fecha_emision' => $item['fecha_emision'] ?? null,
    //                     'pagos' => $item['pagos'] ?? null,
    //                     'ruc_franquicia' => $item['rucFranquicia'] ?? null,
    //                     'accion' => $item['accion'] ?? null,
    //                     'cliente_id' => $item['cliente_id'] ?? null,
    //                 ]
    //             );
    //         }
    //     }

    //     return $this->apiRequest('RUT218168420010@crmAPI/Consultas/ventas?todos=1&pagina=1');
    // }


    public function getVentas() {
        $page = 1;
        $allVentas = [];
        $continueFetching = true;
    
        while ($continueFetching) {
            $response = $this->apiRequest("RUT218168420010@crmAPI/Consultas/ventas?todos=1&pagina=$page");
    
            if ($response['error'] == 0 && isset($response['items']) && !empty($response['items'])) {
                foreach ($response['items'] as $item) {
                    \App\Models\Sale::updateOrCreate(
                        [
                            'lineas' => $item['lineas'] ?? null,
                            'impuestos' => $item['impuestos'] ?? null,
                            'subtotal' => $item['subtotal'] ?? null,
                            'total' => $item['total'] ?? null,
                            'moneda' => $item['moneda'] ?? null,
                            'moneda_id' => $item['moneda_id'] ?? null,
                            'estado' => $item['estado'] ?? null,
                            'fecha_creacion' => $item['fecha_creacion'] ?? null,
                            'fecha_emision' => $item['fecha_emision'] ?? null,
                            'pagos' => $item['pagos'] ?? null,
                            'ruc_franquicia' => $item['rucFranquicia'] ?? null,
                            'accion' => $item['accion'] ?? null,
                            'cliente_id' => $item['cliente_id'] ?? null,
                        ]
                    );
                    $allVentas[] = $item; // Agregar el item a la lista total
                }
                $page++; // Incrementar para la siguiente página
            } else {
                $continueFetching = false; // No hay más páginas o hay un error
            }
        }
    
        return $allVentas; // Devuelve todas las ventas de todas las páginas
    }

    
    

    public function showSales() {
        $sales = \App\Models\Sale::all();

        return view('pages.api.sales', compact('sales'));
    }
}
