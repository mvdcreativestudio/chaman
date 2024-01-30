<?php

namespace App\Repositories;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


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
    public function getDailySales($date, $rucFranquicia = null) {
        $query = $this->sales->whereDate('fecha_creacion', $date);
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        $totalSales = $query->sum('total');
        
        // Formatear el número: sin decimales y con punto como separador de miles
        return number_format($totalSales, 0, '', '.');
    }
    
    

    /**
     * Obtener ventas en un mes
     *
     * @param string $month
     * @return float
     */
    public function getMonthlySales($month, $rucFranquicia = null) {
        $query = $this->sales->whereMonth('fecha_creacion', Carbon::parse($month)->month);
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        $totalSales = $query->sum('total');
    
        // Formatear el número: sin decimales y con punto como separador de miles
        return number_format($totalSales, 0, '', '.');
    }
    
    /**
     * Obtener ventas en un año
     *
     * @param string $year
     * @return float
     */
    public function getYearlySales($year, $rucFranquicia = null) {
        $query = $this->sales->whereYear('fecha_creacion', Carbon::parse($year)->year);
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        $totalSales = $query->sum('total');
    
        // Formatear el número: sin decimales y con punto como separador de miles
        return number_format($totalSales, 0, '', '.');
    }

    public function getTotalSales($rucFranquicia = null) {
        // Crear una nueva consulta
        $query = $this->sales->newQuery();
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        // Realizar la suma
        $totalSales = $query->sum('total');
    
        // Formatear el número
        return number_format($totalSales, 0, '', '.');
    }
    

    /** Obtener ventas totales */

    public function getTotalSalesCount($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();
    
        // Filtrar por rango de fechas si se proporcionan
        if (!is_null($startDate) && !is_null($endDate)) {
            $query->whereBetween('fecha_creacion', [$startDate, $endDate]);
        }
    
        // // Filtrar por estado 'Pagado'
        // $query->where('estado', 'Pagado');
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        return $query->count();
    }
    
    

    public function getTotalSalesCountForPeriod($period, $rucFranquicia = null)
    {
        switch ($period) {
            case 'thisYear':
                return $this->getTotalSalesCount(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesCount(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesCount(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                return $this->getTotalSalesCount(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'), $rucFranquicia);
            default:
                // Manejar otros casos o lanzar una excepción
                break;
        }
    }


    public function getTotalSalesPendingCount($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        if (!is_null($startDate) && !is_null($endDate)) {
            $query
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                ->where('estado', 'No Pagado');
        }

        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }

        return $query->count();
    }

    public function getTotalSalesPendingCountForPeriod($period, $rucFranquicia = null)
    {
        switch($period) {
            case 'thisYear':
                return $this->getTotalSalesPendingCount(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesPendingCount(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesPendingCount(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                return $this->getTotalSalesPendingCount(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'), $rucFranquicia);
            default:
                break;
        }
    }


    public function getTotalSalesPaidCount($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        if (!is_null($startDate) && !is_null($endDate)) {
            $query
                ->whereBetween('fecha_creacion', [$startDate, $endDate]);
        }

        $query->where('estado', 'Pagado');

        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }

        return $query->count();
    }

    public function getTotalSalesPaidCountForPeriod($period, $rucFranquicia = null)
    {
        switch($period) {
            case 'thisYear':
                return $this->getTotalSalesPaidCount(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesPaidCount(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesPaidCount(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                return $this->getTotalSalesPaidCount(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'), $rucFranquicia);
            default:
                break;
        }
    }

    public function getTotalSalesCancelledCount($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        if (!is_null($startDate) && !is_null($endDate)) {
            $query
                ->whereBetween('fecha_creacion', [$startDate, $endDate]);
        }

        $query->where('estado', 'Anulada');


        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }

        return $query->count();
    }

    public function getTotalSalesCancelledCountForPeriod($period, $rucFranquicia = null)
    {
        switch($period) {
            case 'thisYear':
                return $this->getTotalSalesCancelledCount(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesCancelledCount(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesCancelledCount(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                return $this->getTotalSalesCancelledCount(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'), $rucFranquicia);
            default:
                break;
        }
    }



    public function getTotalSalesPending($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        if (!is_null($startDate) && !is_null($endDate)) {
            $query
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                ->where('estado', 'No Pagado');
        }

        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
        
        return number_format($query->sum('total'), 0, '.', '.');

    }

    public function getTotalSalesPendingForPeriod($period, $rucFranquicia = null)
    {
        switch($period) {
            case 'thisYear':
                return $this->getTotalSalesPending(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesPending(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesPending(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                return $this->getTotalSalesPending(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'), $rucFranquicia);
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
    public function getAverageTicket($startDate = null, $endDate = null, $rucFranquicia = null) {
        // Si no se proporcionan fechas, asume el año actual
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }
    
        // Si solo se proporciona startDate, asume que endDate es igual a startDate
        if (!is_null($startDate) && is_null($endDate)) {
            $endDate = $startDate;
        }
    
        // Construir la consulta con filtro opcional por RUC de franquicia
        $query = $this->sales->whereBetween('fecha_creacion', [$startDate, $endDate]);
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }

        // Sumar las ventas y contar las transacciones
        $totalSales = $query->sum('total');
        $totalTransactions = $query->count();
    
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

    public function getAverageTicketForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getAverageTicket(null, null, $rucFranquicia);
            case 'thisMonth':
                return $this->getAverageTicket(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'thisWeek':
                return $this->getAverageTicket(now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getAverageTicket(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                return $this->getAverageTicket(now()->subDay()->format('Y-m-d'), $rucFranquicia);
            default:
                break;
        }
    }
     
    

    public function getGMV($startDate = null, $endDate = null, $rucFranquicia = null) {
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
        $query = $this->sales
            ->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
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
    
    
    public function getGMVForPeriod($period, $rucFranquicia) {
        switch ($period) {
            case 'thisYear':
                return $this->getGMV(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getGMV(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getGMV(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $yesterdayDate = now()->subDay()->format('Y-m-d');
                return $this->getGMV($yesterdayDate, $yesterdayDate, $rucFranquicia);
            default:
                break;
        }
    }

    public function getMonthlyGMV($year, $rucFranquicia = null) {
        $monthlyGMV = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');
    
            $query = $this->sales->whereBetween('fecha_creacion', [$startDate, $endDate]);
            if (!is_null($rucFranquicia)) {
                $query->where('ruc_franquicia', $rucFranquicia);
            }
    
            $monthlyGMV[] = $query->sum('total');
        }
        return $monthlyGMV;
    }

    
    

    
    
    

    

}
