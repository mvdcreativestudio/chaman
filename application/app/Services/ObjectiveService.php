<?php 

namespace App\Services;

use App\Models\Objective;  // Asumiendo que tienes un modelo de Objective
use DB;

class ObjectiveService {

    public function calculateProgressForObjective(Objective $objective)
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

            case 'sales':
                switch ($objective->module_target) {
                    case 'sales_created':
                        return $this->calculateCreatedSalesProgress($objective);
                        break;
                    case 'sales_converted':
                        return $this->calculateConvertedSalesProgress($objective);
                        break;
                }
                break;
            case 'expenses':
                switch ($objective->module_target) {
                    case 'reduce_expenses':
                        return $this->calculateExpensesReductionProgress($objective);
                        break;
                }
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



    // VENTAS

    private function calculateCreatedSalesProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de ventas
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

        // Obtener la cantidad de ventas generadas en el rango de fechas del objetivo
        $salesInObjectiveRange = DB::table('invoices')
            ->whereBetween('bill_created', [$startDate, $endDate])
            ->count();

        // Calcular el progreso
        $progress = ($salesInObjectiveRange / $objective->target_value) * 100;

        return $progress;
    }

    private function calculateConvertedSalesProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de ventas convertidas
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

        // Obtener la cantidad de ventas convertidas en el rango de fechas del objetivo
        $salesInObjectiveRange = DB::table('invoices')
            ->whereBetween('bill_created', [$startDate, $endDate])
            ->where('bill_status', 'paid')
            ->count();

        // Calcular el progreso
        $progress = ($salesInObjectiveRange / $objective->target_value) * 100;

        return $progress;
    }

    // GASTOS

    private function calculateExpensesReductionProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de gastos reducidos
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;

    // Obtener la suma total de gastos en el rango de fechas del objetivo
        $totalExpensesInObjectiveRange = DB::table('expenses')
        ->whereBetween('expense_date', [$startDate, $endDate])
        ->sum('expense_amount'); 
    
        
        // Calcular el progreso
        $progress = ($totalExpensesInObjectiveRange / $objective->target_value) * 100;

        return $progress;
        
    }

    
    // Lógica para determinar el estado del objetivo (active o inactive)

    public function calculateStatusForObjective(Objective $objective)
    {

        $today = now();

        if ($today >= $objective->start_date && $today <= $objective->end_date) {
            return 'active';
        } else {
            return 'inactive';
        }
    }

    // Puedes agregar otras funciones relacionadas con la lógica de objetivos aquí

}
