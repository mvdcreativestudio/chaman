<?php

namespace App\Cronjobs;

use App\Http\Controllers\ExternalAPIController;

class SyncExternalAPICron {

    public function __invoke() {
        $controller = new ExternalAPIController();;
        // $controller->getClientes();
        // $controller->getProductos();
        // $controller->getProveedores();
        $controller->getVentas();
    }
}
