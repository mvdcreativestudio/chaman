<?php

namespace App\Http\Controllers;

use App\Repositories\ObjectiveRepository;
use App\Http\Responses\Objective\CreateResponse;
use App\Http\Responses\Objective\UpdateResponse;
use App\Http\Responses\Objective\ToggleResponse;
use Illuminate\Http\Request;

class Objective extends Controller {

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




    // PROGRESO DE OBJETIVOS

    // LEADS

    public function calculateLeadsProgress($objectiveId)
    {
    $objective = $this->objectiveRepo->get($objectiveId);

    if (!$objective) {
        return response()->json(['status' => 'error', 'message' => 'Objective not found'], 404);
    }

    // Obtener el rango de fechas del objetivo
    $startDate = $objective->start_date;
    $endDate = $objective->end_date;

    // Obtener la cantidad de leads generados en el rango de fechas del objetivo
    $leadsInObjectiveRange = $objective->leads()
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Calcular el progreso
    $progress = ($leadsInObjectiveRange / $objective->target_value) * 100;

    return response()->json(['status' => 'success', 'progress' => $progress], 200);
    }

    

    public function updateObjectiveStatus($objectiveId)
    {
    $objective = $this->objectiveRepo->get($objectiveId);

    if (!$objective) {
        return response()->json(['status' => 'error', 'message' => 'Objective not found'], 404);
    }

    // Obtener la cantidad actual de leads generados en el mes actual
    $currentMonthLeads = $objective->leads()
        ->whereMonth('created_at', now()->month)
        ->count();

    // Calcular el progreso
    $progress = ($currentMonthLeads / $objective->target_value) * 100;

    // Actualizar el estado del objetivo
    $objective->status = $progress > 100 ? 'completed' : 'active';
    $objective->save();

    return response()->json(['status' => 'success', 'message' => 'Objective status updated'], 200);
    }


    
    
}
