<?php

namespace App\Http\Controllers;

use App\Repositories\FranchiseRepository;
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
        $franchise = $this->franchiseRepo->create();
        if ($franchise) {
            return response()->json(['status' => 'success', 'data' => $franchise], 201);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to create franchise'], 500);
        }
    }

    public function update($id, Request $request) {
        $franchise = $this->franchiseRepo->update($id);
        if ($franchise) {
            return response()->json(['status' => 'success', 'data' => $franchise], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update franchise'], 500);
        }
    }

    public function index()
    {
        return view('pages/franchises/index');
    }
}
