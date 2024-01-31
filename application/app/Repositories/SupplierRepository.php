<?php


namespace App\Repositories;

use App\Models\Suppliers;
use Carbon\Carbon;
use Log;

class SupplierRepository {

    protected $suppliers;

    public function getAllSuppliers() {
        return Suppliers::all();
    }
    

}