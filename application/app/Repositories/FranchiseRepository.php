<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data abstraction for franchises
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Franchise;
use Log;

class FranchiseRepository {

    protected $franchises;

    public function __construct(Franchise $franchises) {
        $this->franchises = $franchises;
    }

    /**
     * Obtengo todas las franquicias de la base de datos
     * @return Collection
     */
    public function getAll() {
        return $this->franchises->all();
    }


    /**
     * Obtengo una Franquicia específica de la Base de Datos
     * @param int $id El ID de la Franquicia
     * @return object
     */
    public function get($id = '') {

        // Hago la consulta
        $franchises = $this->franchises->newQuery();

        // Valido
        if (!is_numeric($id)) {
            return false;
        }

        $franchises->where('id', $id);

        return $franchises->first();
    }

    /**
     * Chequea si una Franquicia existe
     * @param int $id El ID de la Franquicia
     * @return bool
     */
    public function exists($id = '') {

        // Hago la consulta
        $franchises = $this->franchises->newQuery();

        // Valido
        if (!is_numeric($id)) {
            Log::error("validation error - invalid params", ['process' => '[FranchiseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        // Checkeo
        $franchises->where('id', '=', $id);
        return $franchises->exists();
    }

    /**
     * Crea una nueva Franquicia
     * @param string $returning return id|obj
     * @return bool
     */
    public function create($data) {
        // Carga la nueva Franquicia
        $franchise = new $this->franchises;
        $franchise->name = $data['name'];
        $franchise->address = $data['address'];
        $franchise->phone = $data['phone'];
    
        // Guarda y retorna un booleano
        return $franchise->save();
    }
    
    

    /**
     * Actualiza una franquicia existente
     * @param int $id El ID de la Franquicia
     * @return bool|object
     */
    public function update($id) {

        // find the franchise
        $franchise = $this->franchises->find($id);

        if (!$franchise) {
            Log::error("franchise not found", ['process' => '[FranchiseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        // Actualiza los campos
        $franchise->name = request('name');
        $franchise->address = request('address');
        $franchise->phone = request('phone');

        // Guarda
        if ($franchise->save()) {
            return $franchise;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[FranchiseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * Cambia el estado de is_disabled de una franquicia
     * @param int $id El ID de la Franquicia
     * @return bool|object
     */
    public function toggleDisableStatus($id) {
        $franchise = $this->get($id);
        
        if (!$franchise) {
            return false;
        }
    
        // Cambia el atributo is_disabled a su opuesto (a futuro se agregara más logica para controlar lo que pasaría al deshabilitar una franquicia)
        $franchise->is_disabled = !$franchise->is_disabled;
        return $franchise->save();
    }
    
}

