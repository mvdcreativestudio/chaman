<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DatacenterRepository;
use App\Models\Franchise;

class DatacenterController extends Controller
{

    protected $datacenterRepository;

    public function __construct(DatacenterRepository $datacenterRepository)
    {
        $this->datacenterRepository = $datacenterRepository;
    }

    
    public function index()
    {
        // Puedes agregar lógica aquí si es necesario
        return view('pages.datacenter.datacenter');

    }

    public function getFilteredData(Request $request)
    {
        $period = $request->input('timeframe');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $rucFranquicia = $request->input('rucFranquicia');
        $year = now()->year;
        $monthlyGMV = $this->datacenterRepository->getMonthlyGMV($year, $rucFranquicia);



        if ($period == 'custom') {
            $gmvData = $this->datacenterRepository->getGMV($startDate, $endDate, $rucFranquicia);
            $averageTicketData = $this->datacenterRepository->getAverageTicket($startDate, $endDate);
            $totalSalesCount = $this->datacenterRepository->getTotalSalesCount($startDate, $endDate, $rucFranquicia);
            $totalSalesPendingCount = $this->datacenterRepository->getTotalSalesPendingCount($startDate, $endDate, $rucFranquicia);
            $totalSalesPending = $this->datacenterRepository->getTotalSalesPending($startDate, $endDate, $rucFranquicia);
        } else {
            $gmvData = $this->datacenterRepository->getGMVForPeriod($period, $rucFranquicia);
            $averageTicketData = $this->datacenterRepository->getAverageTicketForPeriod($period);
            $totalSalesCount = $this->datacenterRepository->getTotalSalesCountForPeriod($period, $rucFranquicia);
            $totalSalesPendingCount = $this->datacenterRepository->getTotalSalesPendingCountForPeriod($period, $rucFranquicia);
            $totalSalesPending = $this->datacenterRepository->getTotalSalesPendingForPeriod($period, $rucFranquicia);
            
        }
    
        // Preparar los datos para la respuesta
        $data = [
            'gmv' => $gmvData['gmv'],
            'averageTicket' => $averageTicketData,
            'totalSalesCount' => $totalSalesCount,
            'totalSalesPendingCount' => $totalSalesPendingCount,
            'totalSalesPending' => $totalSalesPending,
            'monthlyGMV' => $monthlyGMV,

        ];
    
        return response()->json(['data' => $data]);
    }
    

    public function datacenterNuevo()
    {

        $franchises = Franchise::all();
        $dailySales = $this->datacenterRepository->getDailySales(now()->format('Y-m-d'));
        $monthlySales = $this->datacenterRepository->getMonthlySales(now()->format('Y-m'));
        $yearlySales = $this->datacenterRepository->getYearlySales(now()->format('Y'));
        $averageTicket = $this->datacenterRepository->getAverageTicket(now()->format('Y'));
        $yearlySales2023 = $this->datacenterRepository->getYearlySales(2023);
        $averageTicket = $this->datacenterRepository->getAverageTicket(2023);
        $totalSalesCount = $this->datacenterRepository->getTotalSalesCount();
        $totalSalesPendingCount = $this->datacenterRepository->getTotalSalesPendingCount();
        $totalSalesPending = $this->datacenterRepository->getTotalSalesPending();
        $gmvData = $this->datacenterRepository->getGMV(2023);
        $gmv = $gmvData['gmv'];

        return view ('pages.datacenter.datacenterNuevo', compact ('franchises','dailySales', 'monthlySales', 'yearlySales', 'averageTicket', 'yearlySales2023', 'averageTicket', 'totalSalesCount', 'gmv', 'totalSalesPendingCount', 'totalSalesPending'));
    }


    
}




