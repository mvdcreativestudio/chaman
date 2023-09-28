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

    /**
     * The franchises repository instance.
     */
    protected $franchises;

    /**
     * Inject dependencies
     */
    public function __construct(Franchise $franchises) {
        $this->franchises = $franchises;
    }

    /**
     * Get all franchises from the database
     * @return Collection
     */
    public function getAll() {
        return $this->franchises->all();
    }


    /**
     * get a single franchise from the database
     * @param int $id record id
     * @return object
     */
    public function get($id = '') {

        // new query
        $franchises = $this->franchises->newQuery();

        // validation
        if (!is_numeric($id)) {
            return false;
        }

        $franchises->where('id', $id);

        return $franchises->first();
    }

    /**
     * check if a franchise exists
     * @param int $id The franchise id
     * @return bool
     */
    public function exists($id = '') {

        // new query
        $franchises = $this->franchises->newQuery();

        // validation
        if (!is_numeric($id)) {
            Log::error("validation error - invalid params", ['process' => '[FranchiseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        // check
        $franchises->where('id', '=', $id);
        return $franchises->exists();
    }

    /**
     * Create a new franchise
     * @param string $returning return id|obj
     * @return bool
     */
    public function create($data) {
        //save new franchise
        $franchise = new $this->franchises;
        $franchise->name = $data['name'];
        $franchise->address = $data['address'];
        $franchise->phone = $data['phone'];
    
        //save and return boolean
        return $franchise->save();
    }
    
    

    /**
     * Update an existing franchise
     * @param int $id The franchise id
     * @return bool|object
     */
    public function update($id) {

        // find the franchise
        $franchise = $this->franchises->find($id);
        if (!$franchise) {
            Log::error("franchise not found", ['process' => '[FranchiseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        // update fields
        $franchise->name = request('name');
        $franchise->address = request('address');
        $franchise->phone = request('phone');

        // save
        if ($franchise->save()) {
            return $franchise;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[FranchiseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }
}

