<?php

namespace App\Http\Controllers;

use App\Repositories\ObjectiveRepository;
use App\Http\Responses\Objective\CreateResponse;
use App\Http\Responses\Objective\UpdateResponse;
use App\Http\Responses\Objective\ToggleResponse;
use App\Http\Responses\Objective\ReloadResponse;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ObjectiveController extends Controller {

    protected $objectiveRepo;

    public function __construct(ObjectiveRepository $objectiveRepo) {
        $this->objectiveRepo = $objectiveRepo;
        // $this->middleware('objectiveAccess');
    }

    public function getAll() {
        $objectives = $this->objectiveRepo->getAll();
        return response()->json(['data' => $objectives], 200);
    }

    public function get($id) {
        $objective = $this->objectiveRepo->get($id);
        if ($objective) {
            return response()->json(['status' => 'success', 'data' => $objective], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Objective not found'], 404);
        }
    }

    public function exists($id) {
        if ($this->objectiveRepo->exists($id)) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Objective not found'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->all();
        $objective = $this->objectiveRepo->create($data);
        if ($objective) {
            return new CreateResponse(['objective' => $objective]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to create objective'], 500);
        }
    }
    
    public function update($id) {
        $objective = $this->objectiveRepo->update($id);
    
        if ($objective) {
            return new UpdateResponse(['objective' => $objective]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update objective'], 500);
        }
    }

    public function index()
    {
        $objectives = $this->objectiveRepo->getAll();
        $page = array(
            'heading' => "Objetivos",
            'crumbs' => ['Objetivos']
        );
        return view('pages/objectives/wrapper', ['objectives' => $objectives, 'page' => $page]);
    }

    public function toggleDisable($id) {
        $objective = $this->objectiveRepo->toggleDisableStatus($id);

        if ($objective) {
            return new ToggleResponse(['objective' => $objective]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to toggle objective status'], 500);
        }
    }    


    public function destroy($id) {
        // Chequea si el objetivo existe
        $objective = $this->objectiveRepo->get($id);
    
        if ($objective) {
            // Elimina el objetivo
            $result = $this->objectiveRepo->destroy($id);
    
            if ($result) {
                // Redirige a la página de objetivos después de eliminar con éxito
                return redirect('/objectives')->with('success', 'Objetivo eliminado correctamente');
            } else {
                return response()->json(['status' => 'error', 'message' => 'No se pudo eliminar el objetivo'], 500);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Objetivo no encontrado'], 404);
        }
    }


    public function show($id) {
        $objective = \App\Models\Objective::find($id);

         // Si el objective no existe
         if (!$objective) {
            abort(403, 'Permiso denegado');
        }

        switch (request()->input('user_role_type')) {
            case 'admin_role':
                // Para admin_role, incluye la info de usuario y franquicia
                break;
            case 'franchise_admin_role':
                // Carga la información del usuario
                if ($objective->franchise_id != auth()->user()->franchise_id) {
                    abort(403, 'Permission Denied');
                }            
                break;
            case 'common_role':
                // No carga información adicional
                if ($objective->bill_creatorid != auth()->user()->id) {
                    abort(403, 'Permission Denied');
                }
                break;
        }
    }

    public function updateProgressForAllObjectives() {
        $objectives = Objective::all();
        foreach ($objectives as $objective) {
            $objective->calculateProgressForObjective();
        }
        return back()->with('success', 'Objetivos actualizados correctamente');
    }

    
    


    
}
    

