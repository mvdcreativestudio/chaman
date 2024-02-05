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
                    // Definimos las condiciones de búsqueda y los datos para actualizar o crear
                    $searchConditions = [
                        'client_id' => $item['cliente_id'] ?? null, // Asume que 'id' es el campo en tu base de datos para el ID del cliente
                        'franchise_ruc' => $item['rucFranquicia'] ?? null,
                    ];
    
                    $dataToUpdateOrCreate = [
                        'client_rut' => $item['rut'] ?? null,
                        'client_cedula' => $item['cedula'] ?? null,
                        'client_pasaporte' => $item['pasaporte'] ?? null,
                        'client_documentoExt' => $item['documentoExt'] ?? null,
                        'client_razon_social' => $item['razon_social'] ?? null,
                        'client_company_name' => $item['nombre'] ?? null,
                        'client_phone' => $item['celular'] ?? $item['telefono'] ?? null,
                        'client_billing_street' => $item['direccion'] ?? null,
                        'client_billing_city' => $item['ciudad'] ?? null,
                        'client_billing_state' => $item['departamento'] ?? null,
                        'client_billing_country' => $item['pais'] ?? null,
                        'client_creatorid' => auth()->id(),
                        'client_created' => now(),
                        'client_updated' => now(),
                    ];
    
                    // Utilizamos updateOrCreate para buscar por condiciones, actualizar si existe, o crear un nuevo registro
                    \App\Models\Client::updateOrCreate($searchConditions, $dataToUpdateOrCreate);
                    
                } catch (\Exception $e) {
                    \Log::error('Error al procesar el cliente con RUC ' . ($item['rucFranquicia'] ?? 'desconocido') . ' e ID ' . ($item['cliente_id'] ?? 'desconocido') . ': ' . $e->getMessage());
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
        $importedDataCount = 0;
        $discardedDataCount = 0;
        $discardedDataReasons = [];
    
        while (true) {
            $response = $this->apiRequest("RUT218168420010@crmAPI/Consultas/ventas?pagina=$page");
    
            if ($response['error'] == 0 && isset($response['items']) && !empty($response['items'])) {
                foreach ($response['items'] as $item) {
                    // Definimos las condiciones para buscar una venta existente
                    $conditions = [
                        'fecha_creacion' => $item['fecha_creacion'] ?? null,
                        'cliente_id' => $item['cliente_id'] ?? null,
                    ];
    
                    // Utilizamos el método firstOrNew para obtener un registro existente o crear uno nuevo basado en las condiciones
                    $venta = \App\Models\Sale::firstOrNew($conditions);
    
                    // Actualizamos los atributos de la venta con los datos del API
                    $venta->lineas = $item['lineas'] ?? null;
                    $venta->impuestos = $item['impuestos'] ?? null;
                    $venta->subtotal = $item['subtotal'] ?? null;
                    $venta->total = $item['total'] ?? null;
                    $venta->moneda = $item['moneda'] ?? null;
                    $venta->moneda_id = $item['moneda_id'] ?? null;
                    $venta->estado = $item['estado'] ?? null;
                    $venta->fecha_emision = $item['fecha_emision'] ?? null;
                    $venta->pagos = $item['pagos'] ?? null;
                    $venta->ruc_franquicia = $item['rucFranquicia'] ?? null;
                    $venta->accion = $item['accion'] ?? null;
                    $venta->cliente_id = $item['cliente_id'] ?? null;
    
                    // Guardamos el registro en la base de datos
                    $venta->save();
    
                    if ($venta->wasRecentlyCreated) {
                        $importedDataCount++;
                    } else {
                        $discardedDataCount++;
                        $discardedDataReasons[] = "Venta descartada: Ya existe una venta con fecha_creacion y cliente_id similares.";
                    }
                }
                $page++;
            } else {
                break;
            }
        }
    
        $result = [
            'Datos Importados' => $importedDataCount,
            'Datos Descartados' => $discardedDataCount,
            'Motivos del descarte' => $discardedDataReasons,
        ];
    
        return response()->json($result);
    }
    
    
    
    

    public function showSales() {
        $sales = \App\Models\Sale::all();

        return view('pages.api.sales', compact('sales'));
    }
}
