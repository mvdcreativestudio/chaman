<?php

namespace App\Http\Responses\Objective;

use Illuminate\Contracts\Support\Responsable;

class UpdateResponse implements Responsable {

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
        session()->flash('success', 'Objetivo actualizado correctamente');
    
        // Redirige al usuario
        return redirect('/objectives');
    }
}
