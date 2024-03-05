<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\Client;
use App\Repositories\ExpenseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class DatacenterRepository {

    protected $sales;
    protected $clients;
    protected $expenses;

    /**
     * Inject dependencies
     */
    public function __construct(Sale $sales, Client $clients, ExpenseRepository $expenses) {
        $this->sales = $sales;
        $this->clients = $clients;
        $this->expenses = $expenses;
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
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesCount($startDate, $endDate, $rucFranquicia);   
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
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesPendingCount($startDate, $endDate, $rucFranquicia);   
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
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesPaidCount($startDate, $endDate, $rucFranquicia);                
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
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesCancelledCount($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }



    public function getTotalSalesPending($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        // Si no se proporcionan fechas, asume el año actual
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }

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
                return $this->getTotalSalesPending(now()->startOfYear()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                return $this->getTotalSalesPending($startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesPending(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesPending($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }
    

    public function getTotalSalesPaid($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        // Si no se proporcionan fechas, asume el año actual
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }

        if (!is_null($startDate) && !is_null($endDate)) {
            $query
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                ->where('estado', 'Pagado');
        }

        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
        
        return number_format($query->sum('total'), 0, '.', '.');

    }

    public function getTotalSalesPaidForPeriod($period, $rucFranquicia = null)
    {
        switch($period) {
            case 'thisYear':
                return $this->getTotalSalesPaid(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesPaid(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesPaid(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesPaid($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function getTotalSalesParcialPayment($startDate = null, $endDate = null, $rucFranquicia = null)
    {
        $query = Sale::query();

        // Si no se proporcionan fechas, asume el año actual
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }

        if (!is_null($startDate) && !is_null($endDate)) {
            $query
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                ->where('estado', 'Pago Parcial');
        }

        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
        
        return number_format($query->sum('total'), 0, '.', '.');

    }

    public function getTotalSalesParcialPaymentForPeriod($period, $rucFranquicia = null)
    {
        switch($period) {
            case 'thisYear':
                return $this->getTotalSalesParcialPayment(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTotalSalesParcialPayment(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTotalSalesParcialPayment(now()->format('Y-m-d'), now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTotalSalesParcialPayment($startDate, $endDate, $rucFranquicia);   
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
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getAverageTicket($startDate, $endDate, $rucFranquicia);   
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
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->where('estado', '!=', 'Anulada'); 

    
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

    public function getARPU($startDate = null, $endDate = null, $rucFranquicia = null) {
        // Establecer rango de fechas si no se proporcionan
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
    
        // Si solo se proporciona la fecha de inicio, usarla como fecha de finalización también
        if (!is_null($startDate) && is_null($endDate)) {
            $endDate = $startDate;
        }
    
        // Calcular ingresos totales en el rango de fechas
        $totalRevenueQuery = Sale::query()
            ->select(DB::raw('SUM(total) as total_revenue'))
            ->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $totalRevenueQuery->where('ruc_franquicia', $rucFranquicia);
        }
    
        $totalRevenue = $totalRevenueQuery->first()->total_revenue;
    
        // Calcular el número total de usuarios únicos en el rango de fechas
        $uniqueUsersCountQuery = Sale::query()
            ->select(DB::raw('COUNT(DISTINCT cliente_id) as unique_users'))
            ->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        if (!is_null($rucFranquicia)) {
            $uniqueUsersCountQuery->where('ruc_franquicia', $rucFranquicia);
        }
    
        $uniqueUsersCount = $uniqueUsersCountQuery->first()->unique_users;
    
        // Calcular ARPU: Ingresos Totales / Número de Usuarios Únicos
        $ARPU = $uniqueUsersCount > 0 ? $totalRevenue / $uniqueUsersCount : 0;
    
        return number_format($ARPU, 0, ',', '.');


    }

    public function getARPUForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getARPU(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getARPU(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getARPU(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getARPU($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
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
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getGMV($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function getMonthlyGMV($year, $rucFranquicia = null) {
        $monthlyGMV = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');
    
            $query = $this->sales
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->where('estado', '!=', 'Anulada'); 
            if (!is_null($rucFranquicia)) {
                $query->where('ruc_franquicia', $rucFranquicia);
            }
    
            $monthlyGMV[] = $query->sum('total');
        }
        return $monthlyGMV;
    }

    public function getSalesByVendor($startDate = null, $endDate = null, $rucFranquicia = null) {
        // Construir la consulta inicial para obtener los totales de ventas por franquicia
        $query = $this->sales->select('franchises.name as franquicia', $this->sales->raw('SUM(sales.total) as total_ventas_franquicia'))
                      ->join('franchises', 'sales.ruc_franquicia', '=', 'franchises.ruc')
                      ->whereBetween('sales.fecha_creacion', [$startDate, $endDate])
                      ->groupBy('sales.ruc_franquicia', 'franchises.name');
                      
        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        // Ejecutar la consulta y obtener los resultados
        $rows = $query->get();
    
        // Calcular el total de ventas de todas las franquicias
        $total_ventas = 0;
    
        foreach ($rows as $row) {
            $total_ventas += $row['total_ventas_franquicia'];
        }
    
        // Calcular el porcentaje de ventas para cada franquicia
        $results = [];
    
        foreach ($rows as $row) {
            $porcentaje_ventas = ($row['total_ventas_franquicia'] / $total_ventas) * 100;
            // Agregar el nombre de la franquicia y su porcentaje de ventas al array de resultados
            $results[] = [
                'name' => $row['franquicia'],
                'percentage' => $porcentaje_ventas
            ];
        }
    
        return $results;
    }


    public function getSalesByVendorForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getSalesByVendor(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getSalesByVendor(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getSalesByVendor(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getSalesByVendor($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    // CAC

    public function getCac($startDate = null, $endDate = null, $rucFranquicia = null) {
        $currentDate = Carbon::now();
    
        // Establecer el rango de fechas completo si no se proporcionan
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = $currentDate->format('Y-m-d'); // Asegurarse de no ir más allá de la fecha actual
        }
    
        // Ajustar el rango para cubrir el mes completo si se selecciona un solo día
        if ($startDate == $endDate) {
            $startOfMonth = Carbon::parse($startDate)->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::parse($endDate)->endOfMonth()->format('Y-m-d');
        } else {
            $startOfMonth = $startDate;
            $endOfMonth = min($endDate, $currentDate->format('Y-m-d')); // No ir más allá de la fecha actual
        }
    
        // Obtener el gasto total de marketing para el rango de fechas
        $totalMarketingExpenses = $this->expenses->getTotalMarketingExpenses($startOfMonth, $endOfMonth, $rucFranquicia);
    
        // Calcular la cantidad de días en el rango seleccionado hasta la fecha actual
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endOfMonth); // Asegurarse de que no superamos la fecha actual
        $daysInPeriod = $end->diffInDays($start) + 1; // +1 para incluir ambos extremos
    
        // Calcular el gasto diario promedio de marketing basado en el rango completo
        $dailyMarketingExpense = $daysInPeriod > 0 ? $totalMarketingExpenses / $daysInPeriod : 0;
    
        // Obtener el total de clientes nuevos en el período seleccionado
        $totalNewClients = $this->clients->whereBetween('client_created', [$startDate, $endDate])
                                          ->when($rucFranquicia, function ($query) use ($rucFranquicia) {
                                              return $query->where('franchise_id', $rucFranquicia);
                                          })
                                          ->count();
    
        // Calcular el CAC para el período seleccionado
        $cac = $totalNewClients > 0 ? ($dailyMarketingExpense * $daysInPeriod) / $totalNewClients : 0;
    
        return [
            'marketingExpenses' => $totalMarketingExpenses,
            'dailyMarketingExpense' => $dailyMarketingExpense,
            'cac' => number_format($cac, 2, ',', '.'),
            'totalClients' => $totalNewClients,
        ];
    }
    

    public function getCACForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getCac(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getCac(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getCac(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getCac($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function calculateFrequency($startDate = null, $endDate = null, $rucFranquicia = null) {
        // Si no se especifican fechas, usar el rango desde el inicio del año hasta la fecha actual
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
    
        // Iniciar la consulta para obtener todas las ventas en el rango de fechas
        $query = Sale::query()
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->select('cliente_id', \DB::raw('count(*) as total_ventas'), \DB::raw('MONTH(fecha_creacion) as month'), \DB::raw('YEAR(fecha_creacion) as year'))
            ->groupBy('cliente_id', 'month', 'year');
    
        // Filtrar por franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        // Ejecutar la consulta
        $ventas = $query->get();
    
        // Agrupar las ventas por mes y año
        $ventasPorMes = $ventas->groupBy(['year', 'month']);
    
        // Calcular el promedio de compras por usuario activo por mes
        $totalCompras = 0;
        $totalClientesUnicos = 0;
        foreach ($ventasPorMes as $year => $months) {
            foreach ($months as $month => $ventas) {
                // Contar clientes únicos por mes
                $clientesUnicos = $ventas->unique('cliente_id')->count();
                $totalClientesUnicos += $clientesUnicos;
    
                // Sumar todas las ventas para calcular el promedio después
                $totalComprasMes = $ventas->sum('total_ventas');
                $totalCompras += $totalComprasMes;
            }
        }
    
        // Calcular la frecuencia como el promedio de compras por cliente único
        $frequency = $totalClientesUnicos > 0 ? $totalCompras / $totalClientesUnicos : 0;
    
        return number_format($frequency, 2, ',', '.');

    }



    public function calculateFrequencyForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->calculateFrequency(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->calculateFrequency(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->calculateFrequency(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->calculateFrequency($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }
    
    public function getMAU($startDate = null, $endDate = null, $rucFranquicia = null) {
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
    
        $query = Sale::query()
            ->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        if (!is_null($rucFranquicia)) {
            $query->where('ruc_franquicia', $rucFranquicia);
        }
    
        $ventas = $query->get();
    
        // Obtener los cliente_id únicos de las ventas
        $clientesUnicos = $ventas->unique('cliente_id')->pluck('cliente_id');
    
        // Contar el número de clientes únicos en la tabla clients
        $totalClientesUnicos = Client::whereIn('cliente_id', $clientesUnicos)
            ->count();
    
        return $totalClientesUnicos;
    }
    

    public function getMAUForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getMAU(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getMAU(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getMAU(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getMAU($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function getNewUsers($startDate = null, $endDate = null, $rucFranquicia = null) {
        // Si no se especifican fechas, usar el rango desde el inicio del año hasta la fecha actual
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
    
        // Construir la consulta para contar clientes creados en el rango de fechas
        // Asumimos que la tabla de clientes se puede acceder a través de un modelo llamado Client
        $query = Client::whereBetween('client_created', [$startDate, $endDate]);
    
        // Aplicar filtro por RUC de franquicia si se proporciona
        // Esto asume que hay una relación entre los clientes y las franquicias que permite filtrar por RUC
        // Podría necesitar ajustes dependiendo de cómo estén estructuradas tus tablas y relaciones
        if (!is_null($rucFranquicia)) {
            $query->whereHas('franchise', function($q) use ($rucFranquicia) {
                $q->where('ruc', $rucFranquicia);
            });
        }
    
        // Contar el número total de clientes que cumplen con los criterios
        $newUsersCount = $query->count();
    
        return $newUsersCount;
    }
    
    public function getNewUsersForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getNewUsers(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getNewUsers(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getNewUsers(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getNewUsers($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function getCHURN($startDate = null, $endDate = null, $rucFranquicia = null) {
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
    
        if (!is_null($startDate) && is_null($endDate)) {
            $endDate = $startDate;
        }
    
        // Obtener todos los cliente_id que hicieron compras en el período
        $activeClientsQuery = Sale::select('cliente_id')
            ->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        if (!is_null($rucFranquicia)) {
            $activeClientsQuery->where('ruc_franquicia', $rucFranquicia);
        }
    
        $activeClients = $activeClientsQuery->distinct()->pluck('cliente_id');
    
        // Calcular el total de clientes activos
        $totalActiveClients = $activeClients->count();
    
        // Obtener todos los cliente_id que NO hicieron compras en el período
        $inactiveClients = Client::whereNotIn('cliente_id', $activeClients)
            ->count();
    
        // Calcular el CHURN
        $churnRate = $totalActiveClients > 0 ? ($inactiveClients / $totalActiveClients) * 100 : 0;
    
        return number_format($churnRate, 0, ',', '.');
    }

    public function getCHURNForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getCHURN(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getCHURN(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getCHURN(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getCHURN($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function getInactiveClients($startDate = null, $endDate = null, $rucFranquicia = null) {
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
    
        // Obtener los client_id de clientes que hicieron compras en el período especificado
        $activeClientIdsQuery = Sale::select('cliente_id')
            ->whereBetween('fecha_creacion', [$startDate, $endDate]);
    
        if (!is_null($rucFranquicia)) {
            $activeClientIdsQuery->where('ruc_franquicia', $rucFranquicia);
        }
    
        $activeClientIds = $activeClientIdsQuery->distinct()->pluck('cliente_id');
    
        // Obtener todos los client_id de clientes
        $allClientIdsQuery = Client::select('client_id');
    
        if (!is_null($rucFranquicia)) {
            $allClientIdsQuery->where('franchise_ruc', $rucFranquicia);
        }
    
        $allClientIds = $allClientIdsQuery->pluck('client_id');
    
        // Obtener los client_id de clientes inactivos
        $inactiveClientIds = $allClientIds->diff($activeClientIds);
    
        // Contar el número de clientes inactivos
        $inactiveClientCount = $inactiveClientIds->count();
    
        return $inactiveClientCount;
    }
     
    

    public function getInactiveClientsForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getInactiveClients(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getInactiveClients(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getInactiveClients(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getInactiveClients($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }
    
    public function getTopSpendingClients($startDate = null, $endDate = null, $rucFranquicia = null) {
        // Establecer rango de fechas si no se proporcionan (año actual por defecto)
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = now()->endOfYear()->format('Y-m-d');
        }
    
        // Si solo se proporciona startDate, asume que endDate es igual a startDate
        if (!is_null($startDate) && is_null($endDate)) {
            $endDate = $startDate;
        }
    
        // Construir la consulta inicial
        $query = Sale::join('clients', 'sales.cliente_id', '=', 'clients.cliente_id')
        ->select(
            'clients.cliente_id',
            'clients.franchise_ruc',
            'clients.client_company_name', // Incluir el nombre de la compañía del cliente
            DB::raw('SUM(sales.total) as total_spent') // Suma de total como total_spent
        )
        ->whereBetween('sales.fecha_creacion', [$startDate, $endDate])
        ->groupBy('clients.cliente_id', 'clients.franchise_ruc', 'clients.client_company_name') // Asegurarse de agrupar también por client_company_name
        ->orderBy('total_spent', 'desc')
        ->limit(10); // Limitar a los 10 primeros resultados

        // Filtrar por RUC de franquicia si se proporciona
        if (!is_null($rucFranquicia)) {
        $query->where('clients.franchise_ruc', $rucFranquicia);
        }

        // Obtener los resultados
        $results = $query->get();

        // Formatear los resultados
        $formattedResults = $results->map(function ($item) {
        $item->total_spent = number_format($item->total_spent, 0, '', '.'); // Aplicar formato a total_spent
        return $item;
        });

        return $formattedResults;
    }
    
    public function getTopSpendingClientsForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getTopSpendingClients(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getTopSpendingClients(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getTopSpendingClients(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getTopSpendingClients($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }

    public function getROI($startDate = null, $endDate = null, $rucFranquicia = null) {
        $currentDate = Carbon::now();
    
        // Establecer el rango de fechas completo si no se proporcionan
        if (is_null($startDate) || is_null($endDate)) {
            $startDate = now()->startOfYear()->format('Y-m-d');
            $endDate = $currentDate->format('Y-m-d');
        }
    
        // Ajustar el rango para cubrir el mes completo si se selecciona un solo día
        if ($startDate == $endDate) {
            $startDate = Carbon::parse($startDate)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->endOfMonth()->format('Y-m-d');
        } else {
            $startDate = Carbon::parse($startDate)->format('Y-m-d'); // Asegura que solo se use la fecha
            $endDate = Carbon::parse(min($endDate, $currentDate->format('Y-m-d')))->format('Y-m-d'); // Usa solo la fecha y limita al día actual
        }
    
        // Obtener el gasto total para el rango de fechas
        $totalExpenses = $this->expenses->getTotalExpenses($startDate, $endDate, $rucFranquicia);
    
        // Calcular la cantidad de días en el rango seleccionado hasta la fecha actual
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $daysInPeriod = $end->diffInDays($start) + 1; // +1 para incluir ambos extremos
    
        // Calcular el gasto diario promedio basado en el rango completo
        $dailyExpense = $daysInPeriod > 0 ? $totalExpenses / $daysInPeriod : 0;
    
        // Obtener el total de ingresos para el rango de fechas
        $totalRevenue = $this->sales->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->when($rucFranquicia, function ($query) use ($rucFranquicia) {
                return $query->where('ruc_franquicia', $rucFranquicia);
            })
            ->sum('total');
    
        // Calcular el ROI
        if ($totalExpenses > 0) {
            $roi = (($totalRevenue - $totalExpenses) / $totalExpenses) * 100; // Multiplicado por 100 para convertir a porcentaje
        } else {
            $roi = 0;
        }
    
        return [
            'totalExpenses' => $totalExpenses,
            'dailyExpense' => $dailyExpense,
            'totalRevenue' => $totalRevenue,
            'roi' => number_format($roi, 2, '.', '') // Asegúrate de usar el formato decimal correcto según tu localización
        ];
    }
    

    public function getROIForPeriod($period, $rucFranquicia = null) {
        switch ($period) {
            case 'thisYear':
                return $this->getROI(now()->startOfYear()->format('Y-m-d'), now()->endOfYear()->format('Y-m-d'), $rucFranquicia);
            case 'thisMonth':
                return $this->getROI(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'), $rucFranquicia);
            case 'today':
                return $this->getROI(now()->format('Y-m-d'), $rucFranquicia);
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = now()->subDay()->endOfDay()->format('Y-m-d H:i:s');
                return $this->getROI($startDate, $endDate, $rucFranquicia);   
            default:
                break;
        }
    }
}
