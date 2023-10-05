<?php


namespace App\Http\Responses\Objective;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }
    
        // Establece un mensaje de alerta para la próxima página
        session()->flash('success', 'Objetivo creado correctamente');
    
        // Redirige al usuario
        return redirect('/objectives');



    
        // redirige al usuario
        return redirect('/objectives');
    }
    
}
