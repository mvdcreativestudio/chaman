<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DatacenterRepository;

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
    
        if ($period == 'custom') {
            $gmvData = $this->datacenterRepository->getGMV($startDate, $endDate);
            $averageTicketData = $this->datacenterRepository->getAverageTicket($startDate, $endDate);
            $totalSalesCount = $this->datacenterRepository->getTotalSalesCount($startDate, $endDate);
        } else {
            $gmvData = $this->datacenterRepository->getGMVForPeriod($period);
            $averageTicketData = $this->datacenterRepository->getAverageTicketForPeriod($period);
            $totalSalesCount = $this->datacenterRepository->getTotalSalesCountForPeriod($period);
        }
    
        // Preparar los datos para la respuesta
        $data = [
            'gmv' => $gmvData['gmv'],
            'averageTicket' => $averageTicketData,
            'totalSalesCount' => $totalSalesCount
        ];
    
        return response()->json(['data' => $data]);
    }
    

    
       


    public function datacenterNuevo()
    {

        $dailySales = $this->datacenterRepository->getDailySales(now()->format('Y-m-d'));
        $monthlySales = $this->datacenterRepository->getMonthlySales(now()->format('Y-m'));
        $yearlySales = $this->datacenterRepository->getYearlySales(now()->format('Y'));
        $averageTicket = $this->datacenterRepository->getAverageTicket(now()->format('Y'));
        $yearlySales2023 = $this->datacenterRepository->getYearlySales(2023);
        $averageTicket = $this->datacenterRepository->getAverageTicket(2023);
        $totalSalesCount = $this->datacenterRepository->getTotalSalesCount();
        $gmvData = $this->datacenterRepository->getGMV(2023);
        $gmv = $gmvData['gmv'];


        return view ('pages.datacenter.datacenterNuevo', compact ('dailySales', 'monthlySales', 'yearlySales', 'averageTicket', 'yearlySales2023', 'averageTicket', 'totalSalesCount', 'gmv'));
    }


    
}




