@extends('layout.wrapper')

@section('title', 'Nuevo Datacenter')

@section ('content')

<!-- OBJETIVOS -->
@include('pages.home.team.widgets.first-row.goals')

<!-- VENTAS EN TIEMPO REAL -->

{{-- Selector de períodos y franquicias --}}
<div class="d-flex mt-0">
    <div class="col-12 col-md-3">
        <form id="gmv-selector-form" class="form-inline">
            <div class="form-group mb-2 mr-2">
                <select id="gmv-timeframe" class="form-control">
                    <option value="thisYear">Este Año</option>
                    <option value="thisMonth">Este Mes</option>
                    <option value="today">Hoy</option>
                    <option value="yesterday">Ayer</option>
                </select>
            </div>
            <div id="custom-date-range" class="form-group mb-2" style="display: none;">
                <input type="date" id="start-date" class="form-control mx-sm-2">
                <input type="date" id="end-date" class="form-control mx-sm-2">
            </div>
            <div class="form-group mb-2">
                <select id="franchise-selector" class="form-control">

                        @if (Auth()->user()->role_id == 1)
                            <option value="" selected data-name="Todas las franquicias">Todas las franquicias</option>
                            @foreach($franchises as $franchise)
                                <option value="{{ $franchise->ruc }}" data-name="{{ $franchise->name }}">{{ $franchise->name }}</option>
                            @endforeach
                        @else 
                            <option value="{{ Auth()->user()->franchise->ruc }}">{{ Auth()->user()->franchise->name }}</option>
                        @endif
                </select>
            </div>
        </form>
    </div>
</div>

<div class="row col-12">
    <!-- Todays Payments -->
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">${{ $payload['sales']['yesterdaySales'] }}</h2>
                        <h6 class="text-muted m-b-0">Ingresos Ayer</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Payments - This month-->
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">${{ $payload['sales']['thisMonthSales'] }}</h2>
                        <h6 class="text-muted m-b-0">Ingresos Este Mes</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Payments - This month-->
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">${{ $payload['sales']['thisYearSales'] }}</h2>
                        <h6 class="text-muted m-b-0">Ingresos Este Año</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Payments - This month-->
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">${{ $payload['sales']['totalSales'] }}</h2>
                        <h6 class="text-muted m-b-0">Ingresos Totales</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

{{-- First Row --}}

<div class="row col-12 pt-4">
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesCount">{{ $payload['sales']['totalSalesCount'] }}</h2>
                        <h6 class="text-muted m-b-0">Ordenes</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-success icon-Coin"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesPaidCount">{{ $payload['sales']['totalSalesPaidCount'] }}</h2>
                        <h6 class="text-muted m-b-0">Pagas</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Coin"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesPendingCount">{{ $payload['sales']['totalSalesPendingCount'] }}</h2>
                        <h6 class="text-muted m-b-0">Crédito</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-warning icon-Coin"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-warning w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesCancelledCount">{{ $payload['sales']['totalSalesCancelledCount'] }}</h2>
                        <h6 class="text-muted m-b-0">Anuladas</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-danger icon-Coin"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-danger w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
       
    
</div>

<div class="row col-12 pt-4">    
    
    <div class="col-lg-3 col-md-6 mb-2">
        <div class="general-app-widget" >
              {{-- <div class="chart-sparkline" >
                    <div class="layer" >
                    </div>
                    <svg class="layer2" width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.599609 30.9996C0.599609 47.7891 14.2102 61.3996 30.9996 61.3996C47.7891 61.3996 61.3996 47.7891 61.3996 30.9996C61.3996 14.2102 47.7891 0.599609 30.9996 0.599609" stroke="#5BE584" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="number-percent-rand" > 98% </div>
              </div> --}}
              <div class="text" >
                    <div class="number-long-rand gmv" > ${{ $payload['sales']['gmv'] }} </div>

                    <div class="conversion" >GMV</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-2">
        <div class="general-app-widget" >
              {{-- <div class="chart-sparkline" >
                    <div class="layer" >
                    </div>
                    <svg class="layer2" width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.599609 30.9996C0.599609 47.7891 14.2102 61.3996 30.9996 61.3996C47.7891 61.3996 61.3996 47.7891 61.3996 30.9996C61.3996 14.2102 47.7891 0.599609 30.9996 0.599609" stroke="#5BE584" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="number-percent-rand" > 98% </div>
              </div> --}}
              <div class="text" >
                    <div class="number-long-rand averageTicket" > ${{ $payload['sales']['averageTicket'] }} </div>
                    <div class="conversion" >Ticket Medio</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-2" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=due') }}">
        <div class="general-app-widget" >
              {{-- <div class="chart-sparkline" >
                    <div class="layer" >
                    </div>
                    <svg class="layer2" width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.599609 30.9996C0.599609 47.7891 14.2102 61.3996 30.9996 61.3996C47.7891 61.3996 61.3996 47.7891 61.3996 30.9996C61.3996 14.2102 47.7891 0.599609 30.9996 0.599609" stroke="#5BE584" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="number-percent-rand" > 98% </div>
              </div> --}}
              <div class="text" >
                    <div class="number-long-rand" id="totalSalesPending"> ${{ $payload['sales']['totalSalesPending'] }} </div>
                    <div class="conversion" >Crédito en la calle</div>
              </div>
        </div>
    </div>

</div>

{{-- Second Row --}}

<div class="col-md-7 col-12 element-content mt-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex m-b-30 justify-content-between">
                <h5 class="card-title m-b-0 align-self-center">GMV</h5>

            </div>
            <div id="chart-gmv"></div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
        function updateChart(data) {
        var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        var monthlyGMV = data.monthlyGMV.map(function(value) {
            return parseFloat(value) || 0;
        });

        var chartData = {
            x: 'x',
            columns: [
                ['x'].concat(months),
                ['GMV'].concat(monthlyGMV)
            ],
            types: {
                'GMV': 'bar'
            }
        };

        var chartConfig = {
            bindto: '#chart-gmv',
            data: chartData,
            axis: {
                x: {
                    type: 'category'
                },
                y: {
                    tick: {
                        format: d3.format("$,")
                    }
                }
            }
        };
        console.log("Datos procesados para la gráfica asedas:", chartData); // Agregar esta línea


        c3.generate(chartConfig);
    }

    function fetchGMVData() {
        var selectedFranchise = $('#franchise-selector').val();
        var selectedTimeframe = $('#gmv-timeframe').val();
        $.ajax({
            url: 'datacenter/filter',
            type: 'GET',
            data: {
                timeframe: selectedTimeframe,
                rucFranquicia: selectedFranchise
            },
            success: function(response) {
                console.log("Datos recibidos:", response); 
                if (response && response.data) {
                    updateChart(response.data);
                } else {
                    console.error('Datos no encontrados en la respuesta', response);
                }
            },
            error: function(error) {
                console.error('Error al obtener datos de GMV:', error);
            }
        });
    }
    $('#franchise-selector').on('change', fetchGMVData);
    $('#timeframe-selector').on('change', fetchGMVData);

    fetchGMVData();

    console.log("Script 1 cargado");
});


</script>




<script>
$(document).ready(function() {
    function handleFilterChange() {
        var selectedTimeframe = $('#gmv-timeframe').val();
        var selectedFranchise = $('#franchise-selector').val();

        var data = {
            rucFranquicia: selectedFranchise
        };

        if (selectedTimeframe === 'custom') {
            $('#custom-date-range').show();
            data.startDate = $('#start-date').val();
            data.endDate = $('#end-date').val();
        } else if (selectedTimeframe === 'yesterday') {
            $('#custom-date-range').hide();
            // Ajusta las fechas para incluir la hora completa de "ayer"
            var yesterdayStart = new Date();
            yesterdayStart.setDate(yesterdayStart.getDate() - 1);
            yesterdayStart.setHours(0, 0, 0, 0); // Comienza a las 00:00:00
            var startDate = yesterdayStart.toISOString().slice(0, 19).replace('T', ' ');

            var yesterdayEnd = new Date();
            yesterdayEnd.setDate(yesterdayEnd.getDate() - 1);
            yesterdayEnd.setHours(23, 59, 59, 999); // Termina a las 23:59:59
            var endDate = yesterdayEnd.toISOString().slice(0, 19).replace('T', ' ');

            data.startDate = startDate;
            data.endDate = endDate;
            data.timeframe = selectedTimeframe;
        } else {
            $('#custom-date-range').hide();
            data.timeframe = selectedTimeframe;
        }

        console.log("Enviando solicitud AJAX con los siguientes datos:", data);

        $.ajax({
            url: '{{ route('datacenter.filter') }}',
            type: 'GET',
            data: data,
            success: function(response) {
                console.log("Respuesta recibida:", response);
                // Actualización de la UI basada en la respuesta
            },
            error: function(error) {
                console.error('Error al obtener datos de GMV:', error);
            }
        });
    }

    // Evento de cambio para el selector de períodos y franquicias
    $('#gmv-selector-form').on('change', '#gmv-timeframe, #franchise-selector', handleFilterChange);

    // Inicializa la UI al cargar
    handleFilterChange();
});


</script>
    




@endsection