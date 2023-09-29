<?php

namespace App\Http\Responses\Franchise;

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
        session()->flash('success', 'Franquicia actualizada correctamente');
    
        // Redirige al usuario
        return redirect('/franchises');
    }
}
