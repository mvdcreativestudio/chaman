<?php

namespace App\Http\Responses\Franchise;

use Illuminate\Contracts\Support\Responsable;

class ToggleResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    public function toResponse($request) {

        // Setteo los datos desde el array
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Muestro un mensaje de exito :)
        if ($franchise) {
            session()->flash('warning', 'Franquicia desactivada correctamente');
        } else {
            session()->flash('success', 'Franquicia activada correctamente');
        }

        // Redirijo al usuario
        return redirect('/franchises');
    }
}
