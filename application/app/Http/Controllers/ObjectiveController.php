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




    // PROGRESO DE OBJETIVOS

    private function calculateProgressForObjective(Objective $objective)
    {
        // Lógica específica para cada tipo de objetivo (leads, payments, invoices, clients)
        switch ($objective->module) {
            case 'leads':
                switch ($objective->module_target) {
                    case 'leads_created':
                        return $this->calculateCreatedLeadsProgress($objective);
                        break;
                    case 'leads_converted':
                        return $this->calculateConvertedLeadsProgress($objective);
                        break;
                    default:
                        return 0; // Valor predeterminado para leads cuando no se conoce el module_target
                }
                break;
            case 'clients':
                switch ($objective->module_target) {
                    case 'total_clients':
                        return $this->calculateTotalClientsProgress($objective);
                        break;
                    case 'new_clients':
                        return $this->calculateNewClientsProgress($objective);
                        break;
                }
            default:
                return 0; // Valor predeterminado para otros módulos, ajustar según sea necesario
        }
    }
    

    // LEADS

    private function calculateCreatedLeadsProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de leads
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

        // Obtener la cantidad de leads generados en el rango de fechas del objetivo
        $leadsInObjectiveRange = DB::table('leads')
            ->whereBetween('lead_created', [$startDate, $endDate])
            ->count();

        // Calcular el progreso
        $progress = ($leadsInObjectiveRange / $objective->target_value) * 100;

        return $progress;
    }

    private function calculateConvertedLeadsProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de leads convertidos
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

        // Obtener la cantidad de leads convertidos en el rango de fechas del objetivo
        $leadsInObjectiveRange = DB::table('leads')
            ->whereBetween('lead_created', [$startDate, $endDate])
            ->where('lead_status', 2)
            ->count();

        // Calcular el progreso
        $progress = ($leadsInObjectiveRange / $objective->target_value) * 100;

        return $progress;
    }



    // CLIENTES

    private function calculateTotalClientsProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de clientes totales
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

        // Obtener la cantidad de clientes creados en el rango de fechas del objetivo
        $clientsInObjectiveRange = DB::table('clients')
            ->whereBetween('client_created', [$startDate, $endDate])
            ->count();

        // Calcular el progreso
        $progress = ($clientsInObjectiveRange / $objective->target_value) * 100;

        return $progress;
    }

    private function calculateNewClientsProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de nuevos clientes
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

        // Obtener la cantidad de clientes creados en el rango de fechas del objetivo
        $clientsInObjectiveRange = DB::table('clients')
            ->whereBetween('client_created', [$startDate, $endDate])
            ->count();

        // Calcular el progreso
        $progress = ($clientsInObjectiveRange / $objective->target_value) * 100;

        return $progress;
    }




    // CALCULAR MANUALMENTE EL PROGRESO CON BOTÓN

    public function updateProgressForAllObjectives()
    {
        // Obtener todos los objetivos
        $objectives = Objective::all();

        foreach ($objectives as $objective) {
            // Calcular el progreso
            $progress = $this->calculateProgressForObjective($objective);

            // Actualizar el progreso y estado del objetivo
            $objective->progress = $progress;
            $objective->status = $this->calculateStatusForObjective($objective);
            $objective->save();
        }

        return new ReloadResponse(['status' => 'success', 'message' => 'Progress updated for all objectives']);
    }

    
    // Lógica para determinar el estado del objetivo (active o inactive)


    private function calculateStatusForObjective(Objective $objective)
    {

        $today = now();

        if ($today >= $objective->start_date && $today <= $objective->end_date) {
            return 'active';
        } else {
            return 'inactive';
        }
    }
    
}
    

