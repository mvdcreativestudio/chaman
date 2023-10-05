<?php

namespace App\Http\Responses\Objective;

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
            session()->flash('warning', 'Objetivo desactivado correctamente');
        } else {
            session()->flash('success', 'Objetivo activado correctamente');
        }

        // Redirijo al usuario
        return redirect('/objectives');
    }
}
