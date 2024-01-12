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

    public function datacenterNuevo()
    {

        $dailySales = $this->datacenterRepository->getDailySales(now()->format('Y-m-d'));
        $monthlySales = $this->datacenterRepository->getMonthlySales(now()->format('Y-m'));
        $yearlySales = $this->datacenterRepository->getYearlySales(now()->format('Y'));
        $averageTicket = $this->datacenterRepository->getAverageTicket(now()->format('Y'));
        $yearlySales2023 = $this->datacenterRepository->getYearlySales(2023);
        $averageTicket = $this->datacenterRepository->getAverageTicket(2023);
        $totalSalesCount = $this->datacenterRepository->getTotalSalesCount();
        $gmv = $this->datacenterRepository->getGMV(2023);

        return view ('pages.datacenter.datacenterNuevo', compact ('dailySales', 'monthlySales', 'yearlySales', 'averageTicket', 'yearlySales2023', 'averageTicket', 'totalSalesCount', 'gmv'));
    }


    
}




