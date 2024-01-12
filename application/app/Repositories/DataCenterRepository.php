<?php

namespace App\Repositories;

use App\Models\Sale;
use Carbon\Carbon;

class DatacenterRepository {

    protected $sales;

    /**
     * Inject dependencies
     */
    public function __construct(Sale $sales) {
        $this->sales = $sales;
    }

    /**
     * Obtener ventas en un día
     *
     * @param string $date
     * @return float
     */
    public function getDailySales($date) {
        return $this->sales->whereDate('fecha_creacion', $date)->sum('total');
    }

    /**
     * Obtener ventas en un mes
     *
     * @param string $month
     * @return float
     */
    public function getMonthlySales($month) {
        return $this->sales->whereMonth('fecha_creacion', Carbon::parse($month)->month)->sum('total');
    }

    /**
     * Obtener ventas en un año
     *
     * @param string $year
     * @return float
     */
    public function getYearlySales($year) {
        return $this->sales->whereYear('fecha_creacion', $year)->sum('total');
    }

    /** Obtener ventas totales */

    public function getTotalSalesCount()
    {
        return Sale::count();
    }

    /**
     * Obtener el Ticket Medio (Promedio de venta por transacción)
     *
     * @param string $year
     * @return float
     */
    public function getAverageTicket($year) {
        $totalSales = $this->sales->whereYear('fecha_creacion', $year)->sum('total');
        $totalTransactions = $this->sales->whereYear('fecha_creacion', $year)->count();
    
        // Verificar si hay transacciones antes de dividir
        if ($totalTransactions > 0) {
            $averageTicket = $totalSales / $totalTransactions;
        } else {
            $averageTicket = 0; // O manejarlo de la manera que prefieras
        }
    
        // Formatear el promedio
        $formattedAverageTicket = number_format($averageTicket, 0, '', '.');
    
        return $formattedAverageTicket;
    }
    

    public function getGMV($year) {
        $totalSales = $this->sales->whereYear('fecha_creacion', $year)->sum('total');
    

        $formattedTotalSales = number_format($totalSales, 0, '', '.');
    
        return $formattedTotalSales;
    }

    

}
