<?php

namespace App\Http\Responses\Objective;

use Illuminate\Contracts\Support\Responsable;

class ReloadResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    public function toResponse($request) {

        // Setteo la data al array
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }
    
        // Mando mensaje de todo ok :)
        session()->flash('success', 'Objetivos recargados correctamente');
    
        // Redirige al usuario
        return redirect('/home');
    }
}