<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data abstraction for objectives
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Objective;
use Carbon\Carbon;
use Log;

class ObjectiveRepository {

    protected $objectives;

    public function __construct(Objective $objectives) {
        $this->objectives = $objectives;
    }

    /**
     * Obtengo todos los Objetivos de la base de datos
     * @return Collection
     */
    public function getAll() {
        return $this->objectives->get();
    }

    /**
     * Obtener objetivos activos primero y luego inactivos para dashboard
     * @return Collection
     */
    public function getActiveInactive() {
        return $this->objectives->orderBy('status', 'asc')->get();
    }


    /**
     * Obtengo una Objetivo específico de la Base de Datos
     * @param int $id El ID de la Objetivo
     * @return object
     */
    public function get($id = '') {

        // Hago la consulta
        $objectives = $this->objectives->newQuery();

        // Valido
        if (!is_numeric($id)) {
            return false;
        }

        $objectives->where('id', $id);

        return $objectives->first();
    }

    /**
     * Chequea si un Objetivo existe
     * @param int $id El ID del Objetivo
     * @return bool
     */
    public function exists($id = '') {

        // Hago la consulta
        $objectives = $this->objectives->newQuery();

        // Valido
        if (!is_numeric($id)) {
            Log::error("validation error - invalid params", ['process' => '[ObjectiveRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        // Checkeo
        $objectives->where('id', '=', $id);
        return $objectives->exists();
    }

    /**
     * Crea un nuevo Objetivo
     * @param string $returning return id|obj
     * @return bool
     */
    public function create($data) {
        // Carga el nuevo Objetivo
        $objective = new $this->objectives;
        $objective->name = $data['name'];
        $objective->description = $data['description'];
        $objective->module = $data['module'];
        $objective->target_value = $data['target_value'];
        $objective->user_id = $data['user_id'];
        $objective->franchise_id = $data['franchise_id'];
    
        // Descomponemos el rango de fechas en fechas individuales
        $date_range = explode(' - ', $data['date_range']);
        $objective->start_date = Carbon::createFromFormat('m/d/Y', $date_range[0]);
        $objective->end_date = Carbon::createFromFormat('m/d/Y', $date_range[1]);
    
        // Calcula el estado (active o inactive) en función de la fecha actual
        $today = now();
    
        if ($today >= $objective->start_date && $today <= $objective->end_date) {
            $objective->status = 'active';
        } else {
            $objective->status = 'inactive';
        }
    
        // Guarda y retorna un booleano
        return $objective->save();
    }
    
    
    /**
     * Actualiza una Objetivo existente
     * @param int $id El ID del Objetivo
     * @return bool|object
     */
    public function update($id) {

        // find the objective
        $objective = $this->objectives->find($id);

        if (!$objective) {
            Log::error("objective not found", ['process' => '[ObjectiveRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        // Actualiza los campos
        $objective->name = request('name');
        $objective->module = request('module');
        $objective->target_value = request('target_value');
        $objective->user_id = request('user_id');
        $objective->franchise_id = request('franchise_id');


        // Guarda
        if ($objective->save()) {
            return $objective;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[ObjectiveRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }


    public function destroy($id) {
        // Encuentra el objetivo por ID
        $objective = $this->objectives->find($id);
    
        if ($objective) {
            // Elimina el objetivo
            $result = $objective->delete();
    
            if ($result) {
                return true; // Éxito al eliminar el objetivo
            } else {
                Log::error("record could not be deleted", [
                    'process' => '[ObjectiveRepository]',
                    config('app.debug_ref'),
                    'function' => __function__,
                    'file' => basename(__FILE__),
                    'line' => __line__,
                    'path' => __file__
                ]);
                return false; // Error al eliminar el objetivo
            }
        } else {
            Log::error("record not found", [
                'process' => '[ObjectiveRepository]',
                config('app.debug_ref'),
                'function' => __function__,
                'file' => basename(__FILE__),
                'line' => __line__,
                'path' => __file__
            ]);
            return false; // El objetivo no fue encontrado
        }
    }
    


     
}

