<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for home page
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;
use App\Http\Responses\Home\HomeResponse;
use App\Repositories\EventRepository;
use App\Repositories\EventTrackingRepository;
use App\Repositories\LeadRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\StatsRepository;
use App\Repositories\TaskRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\DatacenterRepository;
use App\Services\ObjectiveService;
use App\Models\Franchise;


class Home extends Controller {

    private $page = array();

    protected $statsrepo;
    protected $eventsrepo;
    protected $trackingrepo;
    protected $projectrepo;
    protected $taskrepo;
    protected $leadrepo;
    protected $objectiverepo;
    protected $objectiveService;
    protected $datacenterrepo;


    public function __construct(
        StatsRepository $statsrepo,
        EventRepository $eventsrepo,
        EventTrackingRepository $trackingrepo,
        ProjectRepository $projectrepo,
        TaskRepository $taskrepo,
        LeadRepository $leadrepo,
        ObjectiveRepository $objectiverepo,
        ObjectiveService $objectiveService,
        DatacenterRepository $datacenterrepo
    ) {

        //parent
        parent::__construct();

        $this->statsrepo = $statsrepo;
        $this->eventsrepo = $eventsrepo;
        $this->trackingrepo = $trackingrepo;
        $this->projectrepo = $projectrepo;
        $this->taskrepo = $taskrepo;
        $this->leadrepo = $leadrepo;
        $this->objectiverepo = $objectiverepo;
        $this->objectiveService = $objectiveService;
        $this->datacenterrepo = $datacenterrepo;

        //authenticated
        $this->middleware('auth');

        $this->middleware('homeMiddlewareIndex')->only([
            'index',
        ]);
    }

    /**
     * Display the home page
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $page = $this->pageSettings();

        $payload = [];

        //Team Dashboards
        if (auth()->user()->type == 'team') {
            //admin user
            if (auth()->user()->is_admin) {
                //get payload
                $payload = $this->adminDashboard();
            }
            //team uder
            if (!auth()->user()->is_admin) {
                //get payload
                $payload = $this->teamDashboard();
            }
        }

        //Client Dashboards
        if (auth()->user()->type == 'client') {
            //get payload
            $payload = $this->clientDashboard();

        }

        //[AFFILIATE]
        if (config('settings.custom_modules.cs_affiliate')) {
            if (auth()->user()->type == 'cs_affiliate') {
                //get payload
                $payload = $this->csAffiliateDashboard();
                return view('pages/cs_affiliates/home/home', compact('page', 'payload'));
            }
        }

        //page
        $payload['page'] = $page;
        
        //process reponse
        return new HomeResponse($payload);

    }

    /**
     * [AFFILIATE]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function csAffiliateDashboard() {

        //get events
        $events = \App\Models\Custom\CSEvent::Where('cs_event_affliateid', auth()->id())->orderBy('cs_event_id', 'DESC')
            ->take(100)
            ->get();

        //get projects
        $projects = \App\Models\Custom\CSAffiliateProject::leftJoin('projects', 'projects.project_id', '=', 'cs_affiliate_projects.cs_affiliate_project_projectid')
            ->selectRaw('*')
            ->Where('cs_affiliate_project_affiliateid', auth()->id())
            ->where('cs_affiliate_project_status', 'active')
            ->orderBy('cs_affiliate_project_id', 'DESC')
            ->take(100)
            ->get();

        //Profits - today
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $profits['today'] = \App\Models\Custom\CSAffiliateEarning::where('cs_affiliate_earning_commission_approval_date', $today)
            ->where('cs_affiliate_earning_affiliateid', auth()->id())
            ->where('cs_affiliate_earning_status', 'paid')
            ->sum('cs_affiliate_earning_amount');

        //Profits - today
        $start = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
        $profits['this_month'] = \App\Models\Custom\CSAffiliateEarning::where('cs_affiliate_earning_commission_approval_date', '>=', $start)
            ->where('cs_affiliate_earning_commission_approval_date', '<=', $end)
            ->where('cs_affiliate_earning_status', 'paid')
            ->where('cs_affiliate_earning_affiliateid', auth()->id())
            ->sum('cs_affiliate_earning_amount');

        //Profits - all time
        $profits['all_time'] = \App\Models\Custom\CSAffiliateEarning::where('cs_affiliate_earning_affiliateid', auth()->id())
            ->where('cs_affiliate_earning_status', 'paid')
            ->sum('cs_affiliate_earning_amount');

        //Profits - pending
        $profits['pending'] = \App\Models\Custom\CSAffiliateEarning::where('cs_affiliate_earning_affiliateid', auth()->id())
            ->where('cs_affiliate_earning_status', 'unpaid')
            ->sum('cs_affiliate_earning_amount');

        $payload = [
            'events' => $events,
            'projects' => $projects,
            'profits' => $profits,
        ];

        return $payload;

    }

    /**
     * display team dashboard
     * @return \Illuminate\Http\Response
     */
    public function teamDashboard() {
        
        $userFranchiseId = auth()->user()->franchise_id;

        // Obtener el RUC de la franquicia
        $franchiseRUC = Franchise::where('id', $userFranchiseId)->pluck('ruc')->first();

        //payload
        $payload = [];

        //[projects][all]
        $payload['projects'] = [
            'pending' => $this->statsrepo->countProjects([
                'status' => 'pending',
                'assigned' => auth()->id(),
            ]),
        ];

        //tasks]
        $payload['tasks'] = [
            'new' => $this->statsrepo->countTasks([
                'status' => 'new',
                'assigned' => auth()->id(),
            ]),
            'pending' => $this->statsrepo->countTasks([
                'status' => 'pending',
                'assigned' => auth()->id(),
            ]),
            'completed' => $this->statsrepo->countTasks([
                'status' => 'completed',
                'assigned' => auth()->id(),
            ]),
        ];

         //[objectives]
 
         $objectives = $this->objectiverepo->getActiveInactive();

         // Obtener el franchise id del usuario autenticado
        $userFranchiseId = auth()->user()->franchise_id;


        // Filtrar objetivos por franchise id
        $objectives = $this->objectiverepo->getAll(['franchise_id' => $userFranchiseId]);

        $payload['objectives'] = $objectives;

 
         //[payments]
         $payload['payments'] = [
             'today' => $this->statsrepo->sumCountPayments([
                 'type' => 'sum',
                 'date' => \Carbon\Carbon::now()->format('Y-m-d'),
             ]),
             'this_month' => $this->statsrepo->sumCountPayments([
                 'type' => 'sum',
                 'start_date' => \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),
                 'end_date' => \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d'),
             ]),
             'this_year' => $this->statsrepo->sumCountPayments([
                 'type' => 'sum',
                 'start_date' => \Carbon\Carbon::now()->startOfYear()->format('Y-m-d'),
                 'end_date' => \Carbon\Carbon::now()->endOfYear()->format('Y-m-d'),
             ]),
             'total' => $this->statsrepo->sumCountPayments([
                 'type' => 'sum',
             ]),
         ];
 
 
         //[invoices]
         $payload['invoices'] = [
             'due' => $this->statsrepo->sumCountInvoices([
                 'type' => 'sum',
                 'status' => 'due',
             ]),
             'overdue' => $this->statsrepo->sumCountInvoices([
                 'type' => 'sum',
                 'status' => 'overdue',
             ]),
         ];
 
 
         //[income][yearly]
         $payload['income'] = $this->statsrepo->sumYearlyIncome([
             'period' => 'this_year',
         ]);
 
         //[expense][yearly]
         $payload['expenses'] = $this->statsrepo->sumYearlyExpenses([
             'period' => 'this_year',
         ]);
 
         //[projects][all]
         $payload['all_projects'] = [
             'not_started' => $this->statsrepo->countProjects([
                 'status' => 'not_started',
             ]),
             'in_progress' => $this->statsrepo->countProjects([
                 'status' =>
                 'in_progress',
             ]),
             'on_hold' => $this->statsrepo->countProjects([
                 'status' => 'on_hold',
             ]),
             'completed' => $this->statsrepo->countProjects([
                 'status' => 'completed',
             ]),
         ];
 
         //[projects][ny]
         $payload['my_projects'] = [
             'not_started' => $this->statsrepo->countProjects([
                 'status' => 'not_started',
                 'assigned' => auth()->id(),
             ]),
             'in_progress' => $this->statsrepo->countProjects([
                 'status' => 'in_progress',
                 'assigned' => auth()->id(),
             ]),
             'on_hold' => $this->statsrepo->countProjects([
                 'status' => 'on_hold',
                 'assigned' => auth()->id(),
             ]),
             'completed' => $this->statsrepo->countProjects([
                 'status' => 'completed',
                 'assigned' => auth()->id(),
             ]),
         ];
 
         //filter
         $payload['all_events'] = $this->eventsrepo->search([
             'pagination' => 20,
             'filter' => 'timeline_visible',
         ]);
 
         //[leads] - alltime
         $data = $this->widgetLeads('alltime');
         $payload['leads_stats'] = json_encode($data['stats']);
         $payload['leads_key_colors'] = json_encode($data['leads_key_colors']);
         $payload['leads_chart_center_title'] = $data['leads_chart_center_title'];
 
         //filter payments-today
         $payload['filter_payment_today'] = \Carbon\Carbon::now()->format('Y-m-d');
 
         //filter payments - this month
         $payload['filter_payment_month_start'] = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
         $payload['filter_payment_month_end'] = \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d');
 
         $payload['filter_payment_this_year'] = [
             'start_date' => \Carbon\Carbon::now()->startOfYear()->format('Y-m-d'),
             'end_date' => \Carbon\Carbon::now()->endOfYear()->format('Y-m-d'),
         ];
 
         $payload['filter_payment_total'] = [
             'start_date' => null,  // Deja la fecha de inicio como null para obtener todos los registros históricamente.
             'end_date' => null,    // Deja la fecha de finalización como null para obtener todos los registros históricamente.
         ];
         
         foreach ($payload['objectives'] as $objective) {
             // Calcular el progreso
             $progress = $this->objectiveService->calculateProgressForObjective($objective);
     
             // Actualizar el progreso y estado del objetivo
             $objective->progress = $progress;
             $objective->status = $this->objectiveService->calculateStatusForObjective($objective);
             $objective->save();
         }

         $today = \Carbon\Carbon::now()->format('Y-m-d');

         $dailySales = $this->datacenterrepo->getDailySales(now()->format('Y-m-d'));
         $monthlySales = $this->datacenterrepo->getMonthlySales(now()->format('Y-m'));
         $yearlySales = $this->datacenterrepo->getYearlySales(now()->format('Y'));
         $averageTicket = $this->datacenterrepo->getAverageTicket(now()->format('Y'));
         $yearlySales2023 = $this->datacenterrepo->getYearlySales(2023);
         $averageTicket2023 = $this->datacenterrepo->getAverageTicket(2023);
         $totalSalesCount = $this->datacenterrepo->getTotalSalesCount();
         $totalSalesPendingCount = $this->datacenterrepo->getTotalSalesPendingCount();
         $totalSalesPending = $this->datacenterrepo->getTotalSalesPending();
         $gmvData = $this->datacenterrepo->getGMV(2023);
         $gmv = $gmvData['gmv'];

         $yesterdaySales = $this->datacenterrepo->getDailySales(\Carbon\Carbon::now()->subDays(1)->format('Y-m-d'), $franchiseRUC);
         $thisMonthSales = $this->datacenterrepo->getMonthlySales(\Carbon\Carbon::now()->format('Y-m'), $franchiseRUC);
         $thisYearSales = $this->datacenterrepo->getYearlySales(\Carbon\Carbon::now()->format('Y'), $franchiseRUC);
         $totalSales = $this->datacenterrepo->getTotalSales($franchiseRUC);
     
         // Agregar los datos de ventas al payload
         $payload['sales'] = [
             'dailySales' => $dailySales,
             'monthlySales' => $monthlySales,
             'yearlySales' => $yearlySales,
             'averageTicket' => $averageTicket,
             'yearlySales2023' => $yearlySales2023,
             'averageTicket2023' => $averageTicket2023,
             'totalSalesCount' => $totalSalesCount,
             'totalSalesPendingCount' => $totalSalesPendingCount,
             'totalSalesPending' => $totalSalesPending,
             'gmv' => $gmv,
             'yesterdaySales' => $yesterdaySales,
             'thisMonthSales' => $thisMonthSales,
             'thisYearSales' => $thisYearSales,
             'totalSales' => $totalSales,
         ];

         // datos

          


        //filter
        request()->merge([
            'eventtracking_userid' => auth()->id(),
        ]);
        $payload['all_events'] = $this->trackingrepo->search(20);

        //filter
        request()->merge([
            'filter_assigned' => [auth()->id()],
        ]);
        $payload['my_projects'] = $this->projectrepo->search('', ['limit' => 30]);

        //return payload
        return $payload;

    }

    /**
     * display client dashboard
     * @return \Illuminate\Http\Response
     */
    public function clientDashboard() {

        //payload
        $payload = [];

        //[invoices]
        $payload['invoices'] = [
            'due' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'due',
                'client_id' => auth()->user()->clientid,
            ]),
            'overdue' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'overdue',
                'client_id' => auth()->user()->clientid,
            ]),
        ];

        //[projects][all]
        $payload['projects'] = [
            'pending' => $this->statsrepo->countProjects([
                'status' => 'pending',
                'client_id' => auth()->user()->clientid,
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
                'client_id' => auth()->user()->clientid,
            ]),
        ];

        //filter
        request()->merge([
            'eventtracking_userid' => auth()->id(),
        ]);
        $payload['all_events'] = $this->trackingrepo->search(20);

        //filter
        request()->merge([
            'filter_project_clientid' => auth()->user()->clientid,
        ]);
        $payload['my_projects'] = $this->projectrepo->search('', ['limit' => 30]);

        //return payload
        return $payload;

    }

    /**
     * display admin User
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard() {

        //payload
        $payload = [];

        //[objectives]

        $objectives = $this->objectiverepo->getActiveInactive();
        $payload['objectives'] = $objectives;


        //[payments]
        $payload['payments'] = [
            'today' => $this->statsrepo->sumCountPayments([
                'type' => 'sum',
                'date' => \Carbon\Carbon::now()->format('Y-m-d'),
            ]),
            'this_month' => $this->statsrepo->sumCountPayments([
                'type' => 'sum',
                'start_date' => \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d'),
            ]),
            'this_year' => $this->statsrepo->sumCountPayments([
                'type' => 'sum',
                'start_date' => \Carbon\Carbon::now()->startOfYear()->format('Y-m-d'),
                'end_date' => \Carbon\Carbon::now()->endOfYear()->format('Y-m-d'),
            ]),
            'total' => $this->statsrepo->sumCountPayments([
                'type' => 'sum',
            ]),
        ];


        //[invoices]
        $payload['invoices'] = [
            'due' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'due',
            ]),
            'overdue' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'overdue',
            ]),
            'current' => $this->statsrepo->sumCountInvoices([
                'type' => 'sum',
                'status' => 'current',
            ]),
        ];


        //[income][yearly]
        $payload['income'] = $this->statsrepo->sumYearlyIncome([
            'period' => 'this_year',
        ]);

        //[expense][yearly]
        $payload['expenses'] = $this->statsrepo->sumYearlyExpenses([
            'period' => 'this_year',
        ]);

        //[projects][all]
        $payload['all_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'status' => 'not_started',
            ]),
            'in_progress' => $this->statsrepo->countProjects([
                'status' =>
                'in_progress',
            ]),
            'on_hold' => $this->statsrepo->countProjects([
                'status' => 'on_hold',
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
            ]),
        ];

        //[projects][ny]
        $payload['my_projects'] = [
            'not_started' => $this->statsrepo->countProjects([
                'status' => 'not_started',
                'assigned' => auth()->id(),
            ]),
            'in_progress' => $this->statsrepo->countProjects([
                'status' => 'in_progress',
                'assigned' => auth()->id(),
            ]),
            'on_hold' => $this->statsrepo->countProjects([
                'status' => 'on_hold',
                'assigned' => auth()->id(),
            ]),
            'completed' => $this->statsrepo->countProjects([
                'status' => 'completed',
                'assigned' => auth()->id(),
            ]),
        ];

        //filter
        $payload['all_events'] = $this->eventsrepo->search([
            'pagination' => 20,
            'filter' => 'timeline_visible',
        ]);

        //[leads] - alltime
        $data = $this->widgetLeads('alltime');
        $payload['leads_stats'] = json_encode($data['stats']);
        $payload['leads_key_colors'] = json_encode($data['leads_key_colors']);
        $payload['leads_chart_center_title'] = $data['leads_chart_center_title'];

        //filter payments-today
        $payload['filter_payment_today'] = \Carbon\Carbon::now()->format('Y-m-d');

        //filter payments - this month
        $payload['filter_payment_month_start'] = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $payload['filter_payment_month_end'] = \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d');

        $payload['filter_payment_this_year'] = [
            'start_date' => \Carbon\Carbon::now()->startOfYear()->format('Y-m-d'),
            'end_date' => \Carbon\Carbon::now()->endOfYear()->format('Y-m-d'),
        ];

        $payload['filter_payment_total'] = [
            'start_date' => null,  // Deja la fecha de inicio como null para obtener todos los registros históricamente.
            'end_date' => null,    // Deja la fecha de finalización como null para obtener todos los registros históricamente.
        ];
        
        foreach ($payload['objectives'] as $objective) {
            // Calcular el progreso
            $progress = $this->objectiveService->calculateProgressForObjective($objective);
    
            // Actualizar el progreso y estado del objetivo
            $objective->progress = $progress;
            $objective->status = $this->objectiveService->calculateStatusForObjective($objective);
            $objective->save();
        }

        $dailySales = $this->datacenterrepo->getDailySales(now()->format('Y-m-d'));
        $monthlySales = $this->datacenterrepo->getMonthlySales(now()->format('Y-m'));
        $yearlySales = $this->datacenterrepo->getYearlySales(now()->format('Y'));
        $averageTicket = $this->datacenterrepo->getAverageTicket(now()->format('Y'));
        $yearlySales2023 = $this->datacenterrepo->getYearlySales(2023);
        $averageTicket2023 = $this->datacenterrepo->getAverageTicket(2023);
        $totalSalesCount = $this->datacenterrepo->getTotalSalesCount();
        $totalSalesPendingCount = $this->datacenterrepo->getTotalSalesPendingCount();
        $totalSalesPending = $this->datacenterrepo->getTotalSalesPending();
        $gmvData = $this->datacenterrepo->getGMV(2023);
        $gmv = $gmvData['gmv'];
    

        // Agregar los datos de ventas al payload
        $payload['sales'] = [
            'dailySales' => $dailySales,
            'monthlySales' => $monthlySales,
            'yearlySales' => $yearlySales,
            'averageTicket' => $averageTicket,
            'yearlySales2023' => $yearlySales2023,
            'averageTicket2023' => $averageTicket2023,
            'totalSalesCount' => $totalSalesCount,
            'totalSalesPendingCount' => $totalSalesPendingCount,
            'totalSalesPending' => $totalSalesPending,
            'gmv' => $gmv,
        ];


        //return payload
        return $payload;

    }

    /**
     * create a leads widget
     * [UPCOMING] call this via ajax for dynamically changing dashboad filters
     * @param string $filter [alltime|...]  //add as we go
     * @return \Illuminate\Http\Response
     */
    public function widgetLeads($filter) {

        $payload['stats'] = [];
        $payload['leads_key_colors'] = [];
        $payload['leads_chart_center_title'] = __('lang.leads');

        $counter = 0;

        //do this for each lead category
        foreach (config('home.lead_statuses') as $status) {

            //count all leads
            if ($filter = 'alltime') {
                $count = $this->statsrepo->countLeads(
                    [
                        'status' => $status['id'],
                    ]);
            }

            //add to array
            $payload['stats'][] = [
                $status['title'], $count,
            ];

            //add to counter
            $counter += $count;

            $payload['leads_key_colors'][] = $status['colorcode'];

        }

        // no lead in system - display something (No Leads - 100%) in chart
        if ($counter == 0) {
            $payload['stats'][] = [
                'No Leads', 1,
            ];
            $payload['leads_key_colors'][] = "#eff4f5";
            $payload['leads_chart_center_title'] = __('lang.no_leads');
        }

        return $payload;
    }
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        $page = [
            'crumbs' => [
                __('lang.home'),
            ],
            'crumbs_special_class' => 'main-pages-crumbs',
            'page' => 'home',
            'meta_title' => __('lang.home'),
            'heading' => __('lang.home'),
            'mainmenu_home' => 'active',
            'add_button_classes' => '',
        ];

        return $page;
    }

}
