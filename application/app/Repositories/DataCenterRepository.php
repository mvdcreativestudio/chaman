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

    public function getTotalSalesCount($startDate = null, $endDate = null)
    {
        $query = Sale::query();
    
        if (!is_null($startDate) && !is_null($endDate)) {
            $query->whereBetween('fecha_creacion', [$startDate, $endDate]);
        }
    
        return $query->count();
    }
    

    public function getTotalSalesCountForPeriod($period)
    {
    switch ($period) {
        case 'thisYear':
            return $this->getTotalSalesCount(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'));
        case 'thisMonth':
            return $this->getTotalSalesCount(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'));
        case 'today':
            return $this->getTotalSalesCount(now()->format('Y-m-d'), now()->format('Y-m-d'));
        case 'yesterday':
            return $this->getTotalSalesCount(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'));
        default:
            break;
        }
    }


    /**
     * Obtener el Ticket Medio (Promedio de venta por transacción)
     *
     * @param string $year
     * @return float
     */
    public function getAverageTicket($startDate = null, $endDate = null) {
        // Si no se proporcionan fechas, asume el año actual
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }
    
        // Si solo se proporciona startDate, asume que endDate es igual a startDate
        if (!is_null($startDate) && is_null($endDate)) {
            $endDate = $startDate;
        }
    
        // Construir la consulta para sumar las ventas
        $totalSales = $this->sales->whereBetween('fecha_creacion', [$startDate, $endDate])->sum('total');
    
        // Construir la consulta para contar las transacciones
        $totalTransactions = $this->sales->whereBetween('fecha_creacion', [$startDate, $endDate])->count();
    
        // Calcular el ticket promedio
        if ($totalTransactions > 0) {
            $averageTicket = $totalSales / $totalTransactions;
        } else {
            $averageTicket = 0; // Manejar el caso de no tener transacciones
        }
    
        // Formatear el promedio
        $formattedAverageTicket = number_format($averageTicket, 0, '', '.');
    
        return $formattedAverageTicket;
    }

    public function getAverageTicketForPeriod($period) {
        switch ($period) {
            case 'thisYear':
                return $this->getAverageTicket();
            case 'thisMonth':
                return $this->getAverageTicket(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'));
            case 'thisWeek':
                return $this->getAverageTicket(now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d'));
            case 'today':
                return $this->getAverageTicket(now()->format('Y-m-d'));
            case 'yesterday':
                return $this->getAverageTicket(now()->subDay()->format('Y-m-d'));
            default:
                break;
        }
    }
     
    

    public function getGMV($startDate = null, $endDate = null) {
        // Si no se proporcionan fechas, asume el año actual
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }
    
        // Si solo se proporciona startDate, asume que endDate es igual a startDate
        if (!is_null($startDate) && is_null($endDate)) {
            $endDate = $startDate;
        }
    
        // Construir la consulta
        $query = $this->sales->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        // Obtener la suma total de ventas
        $totalSales = $query->sum('total');
    
        // Formatear el total de ventas
        $formattedTotalSales = number_format($totalSales, 0, '', '.');

    
        // Devolver los resultados
        return [
            'gmv' => $formattedTotalSales,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
    
    public function getGMVForPeriod($period) {
        switch ($period) {
            case 'thisYear':
                return $this->getGMV();
            case 'thisMonth':
                return $this->getGMV(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'));
            case 'today':
                return $this->getGMV(now()->format('Y-m-d'));
            case 'yesterday':
                return $this->getGMV(now()->subDay()->format('Y-m-d'));
            default:
                break;
        }
    }
    
    
    

    

}
