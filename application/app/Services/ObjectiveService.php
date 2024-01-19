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
                        return 0; 
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
        $userId = $objective->user_id;
        $franchiseId = $objective->franchise_id;
    
        // Obtener la cantidad de leads generados en el rango de fechas del objetivo
        $leadsInObjectiveRange = DB::table('leads')
            ->whereBetween('lead_created', [$startDate, $endDate])
            ->where(function ($query) use ($userId, $franchiseId) {
                $query->where('lead_creatorid', $userId)
                      ->orWhere(function ($query) use ($franchiseId) {
                          $query->whereIn('lead_creatorid', function ($query) use ($franchiseId) {
                              $query->select('id')
                                    ->from('users')
                                    ->where('franchise_id', $franchiseId);
                          });
                      });
            })
            ->count();
    
        // Calcular el progreso
        $progress = round(($leadsInObjectiveRange / $objective->target_value) * 100);
    
        return min($progress, 100);
    }
    

    private function calculateConvertedLeadsProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de leads convertidos
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;
        $userId = $objective->user_id;
        $franchiseId = $objective->franchise_id;
    
        // Obtener la cantidad de leads convertidos en el rango de fechas del objetivo
        $leadsInObjectiveRange = DB::table('leads')
            ->whereBetween('lead_created', [$startDate, $endDate])
            ->where('lead_status', 2)
            ->where(function ($query) use ($userId, $franchiseId) {
                $query->where('lead_creatorid', $userId)
                      ->orWhere(function ($query) use ($franchiseId) {
                          $query->whereIn('lead_creatorid', function ($query) use ($franchiseId) {
                              $query->select('id')
                                    ->from('users')
                                    ->where('franchise_id', $franchiseId);
                          });
                      });
            })
            ->count();
    
        // Calcular el progreso
        $progress = round(($leadsInObjectiveRange / $objective->target_value) * 100);
    
        return min($progress, 100);
    }
    

    // VENTAS

    private function calculateCreatedSalesProgress(Objective $objective)
    {
    // Lógica específica para calcular el progreso para objetivos de ventas
    $startDate = $objective->start_date;
    $endDate = $objective->end_date;
    $userId = $objective->user_id;
    $franchiseId = $objective->franchise_id;

    // Obtener la cantidad de ventas generadas en el rango de fechas del objetivo
    $salesInObjectiveRange = DB::table('invoices')
        ->whereBetween('bill_created', [$startDate, $endDate])
        ->where(function ($query) use ($userId, $franchiseId) {
            if ($userId) {
                $query->where('bill_creatorid', $userId);
            }
            if ($franchiseId) {
                $query->orWhere(function ($subQuery) use ($franchiseId) {
                    $subQuery->whereIn('bill_creatorid', function ($subQuery) use ($franchiseId) {
                        $subQuery->select('id')
                                 ->from('users')
                                 ->where('franchise_id', $franchiseId);
                    });
                });
            }
        })
        ->count();

    // Calcular el progreso
    $progress = round(($salesInObjectiveRange / $objective->target_value) * 100);

    return min($progress, 100);
    }



    private function calculateConvertedSalesProgress(Objective $objective)
    {
    // Lógica específica para calcular el progreso para objetivos de ventas convertidas
    $startDate = $objective->start_date;
    $endDate = $objective->end_date;
    $userId = $objective->user_id;
    $franchiseId = $objective->franchise_id;

    // Obtener la cantidad de ventas convertidas en el rango de fechas del objetivo
    $salesInObjectiveRange = DB::table('invoices')
        ->whereBetween('bill_created', [$startDate, $endDate])
        ->where('bill_status', 'paid')
        ->where(function ($query) use ($userId, $franchiseId) {
            if ($userId) {
                $query->where('bill_creatorid', $userId);
            }
            if ($franchiseId) {
                $query->orWhere(function ($subQuery) use ($franchiseId) {
                    $subQuery->whereIn('bill_creatorid', function ($subQuery) use ($franchiseId) {
                        $subQuery->select('id')
                                 ->from('users')
                                 ->where('franchise_id', $franchiseId);
                    });
                });
            }
        })
        ->count();

    // Calcular el progreso
    $progress = round(($salesInObjectiveRange / $objective->target_value) * 100);

    return min($progress, 100);
    }


    // GASTOS

    private function calculateExpensesReductionProgress(Objective $objective)
    {
        // Lógica específica para calcular el progreso para objetivos de gastos reducidos
        $startDate = $objective->start_date;
        $endDate = $objective->end_date;
        $userId = $objective->user_id;
        $franchiseId = $objective->franchise_id;
    
        // Obtener la suma total de gastos en el rango de fechas del objetivo
        $totalExpensesInObjectiveRange = DB::table('expenses')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->where(function ($query) use ($userId, $franchiseId) {
                if ($userId) {
                    $query->where('expense_creatorid', $userId);
                }
                if ($franchiseId) {
                    $query->orWhere(function ($subQuery) use ($franchiseId) {
                        $subQuery->whereIn('expense_creatorid', function ($subQuery) use ($franchiseId) {
                            $subQuery->select('id')
                                     ->from('users')
                                     ->where('franchise_id', $franchiseId);
                        });
                    });
                }
            })
            ->sum('expense_amount'); 
        
        // Calcular el progreso
        $progress = ($totalExpensesInObjectiveRange / $objective->target_value) * 100;
    
        return $progress;
    }
    

    
    // Lógica para determinar el estado del objetivo (active o inactive)

    public function calculateStatusForObjective(Objective $objective)
    {

        $today = today();

        if ($today >= $objective->start_date && $today <= $objective->end_date) {
            return 'active';
        } else {
            return 'inactive';
        }
    }

}
