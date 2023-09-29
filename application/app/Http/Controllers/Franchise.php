<?php

namespace App\Http\Controllers;

use App\Repositories\FranchiseRepository;
use App\Http\Responses\Franchise\CreateResponse;
use App\Http\Responses\Franchise\UpdateResponse;
use App\Http\Responses\Franchise\ToggleResponse;
use Illuminate\Http\Request;

class Franchise extends Controller {

    protected $franchiseRepo;

    public function __construct(FranchiseRepository $franchiseRepo) {
        $this->franchiseRepo = $franchiseRepo;
        $this->middleware('franchiseAccess');
    }

    public function getAll(FranchiseRepository $franchiseRepo) {
        $franchises = $franchiseRepo->getAll();
        return response()->json(['data' => $franchises], 200);
    }

    public function get($id) {
        $franchise = $this->franchiseRepo->get($id);
        if ($franchise) {
            return response()->json(['status' => 'success', 'data' => $franchise], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Franchise not found'], 404);
        }
    }

    public function exists($id) {
        if ($this->franchiseRepo->exists($id)) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Franchise not found'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->all();
        $franchise = $this->franchiseRepo->create($data);
        if ($franchise) {
            return new CreateResponse(['franchise' => $franchise]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to create franchise'], 500);
        }
    }
    
    public function update($id) {
        $franchise = $this->franchiseRepo->update($id);
    
        if ($franchise) {
            return new UpdateResponse(['franchise' => $franchise]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update franchise'], 500);
        }
    }    

    public function index()
    {
        $franchises = $this->franchiseRepo->getAll();
        return view('pages/franchises/index', ['franchises' => $franchises]);
    }

    public function toggleDisable($id) {
        $franchise = $this->franchiseRepo->toggleDisableStatus($id);

        if ($franchise) {
            return new ToggleResponse(['franchise' => $franchise]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to toggle franchise status'], 500);
        }
    }    
}
