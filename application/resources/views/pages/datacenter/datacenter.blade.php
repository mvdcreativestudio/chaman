@extends('layout.wrapper')

@section('title', 'Nuevo Datacenter')

@section ('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


{{-- Selector de períodos y franquicias --}}
<div class="d-flex mt-4">
    <div class="col-6">
        <form id="gmv-selector-form" class="form-inline">
            <div class="form-group mb-2 mr-2">
                <select id="gmv-timeframe" class="form-control">
                    <option value="thisYear">Este Año</option>
                    <option value="thisMonth">Este Mes</option>
                    <option value="yesterday">Ayer</option>
                    <option value="custom">Personalizado</option>
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


{{-- First Row --}}

<div class="d-flex col-12 pt-4">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesCount">{{ $totalSalesCount }}</h2>
                        <h6 class="text-muted m-b-0">Ventas totales</h6>
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
    
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesPaidCount">NA</h2>
                        <h6 class="text-muted m-b-0">Ventas contado</h6>
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
    
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesPendingCount">{{ $totalSalesPendingCount }}</h2>
                        <h6 class="text-muted m-b-0">Ventas a crédito</h6>
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
    
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesCancelledCount">{{ $totalSalesCancelledCount }}</h2>
                        <h6 class="text-muted m-b-0">Ventas anuladas</h6>
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

<div class="d-flex col-12 pt-4">    
    
    <div class="col-lg-3 col-md-6">
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
                    <div class="number-long-rand gmv" > ${{ $gmv }} </div>

                    <div class="conversion" >Ingresos netos</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
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
                    <div class="number-long-rand averageTicket" > ${{ $averageTicket }} </div>
                    <div class="conversion" >Ticket Medio</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
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
                    <div class="number-long-rand" id="totalSalesPending"> ${{ $totalSalesPending }} </div>
                    <div class="conversion" >Vendido a crédito</div>
              </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="general-app-widget cac-card" >
              {{-- <div class="chart-sparkline" >
                    <div class="layer" >
                    </div>
                    <svg class="layer2" width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.599609 30.9996C0.599609 47.7891 14.2102 61.3996 30.9996 61.3996C47.7891 61.3996 61.3996 47.7891 61.3996 30.9996C61.3996 14.2102 47.7891 0.599609 30.9996 0.599609" stroke="#5BE584" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="number-percent-rand" > 98% </div>
              </div> --}}
              <div class="text" >
                    <div class="number-long-rand" id="cac"> ${{ $cac }} </div>
                    <div class="conversion" >Costo de adquisición de cliente</div>
              </div>
        </div>
    </div>
</div>

<div class="d-flex col-12 pt-4">    
    <div class="col-lg-3 col-md-6">
        <div class="general-app-widget">
              <div class="text" >
                    <div class="number-long-rand" id="frequency"> {{ $frequency }} </div>
                    <div class="conversion">Frecuencia de Compra / Usuario</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="general-app-widget">
              <div class="text" >
                    <div class="number-long-rand" id="mau"> {{ $mau }} </div>
                    <div class="conversion">Usuarios únicos activos</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="general-app-widget">
              <div class="text" >
                    <div class="number-long-rand" id="new-users"> {{ $newUsers }} </div>
                    <div class="conversion">Nuevos usuarios</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="general-app-widget">
              <div class="text" >
                    <div class="number-long-rand" id="arpu"> {{ $arpu }} </div>
                    <div class="conversion">ARPU - Ingresos / Cant. de usuarios</div>
              </div>
        </div>
    </div>
</div>

{{-- Second Row --}}
<div class="row">
    <div class="col-md-7 element-content mt-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-30 justify-content-between">
                    <h5 class="card-title m-b-0 align-self-center">Ingresos netos mensuales - <span id="franchise-name"></span></h5>
                </div>
                <div id="chart-gmv"></div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role->role_id == 1)
    <div class="col-md-5 element-content mt-4">
        <div class="card  franchises-sales-card">
            <div class="card-body">
                <div class="d-flex m-b-30 justify-content-between">
                    <h5 class="card-title m-b-0 align-self-center">Venta por franquicia</h5>
                </div>
                <canvas id="chart-vendors" width="300"></canvas>
            </div>
        </div>
    </div>
@endif

    
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
            console.log("Datos procesados para la gráfica:", chartData); // Agregar esta línea
    
    
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
                    console.log("Datos recibidos:", response); // Agregar esta línea
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
    });
    
    
    </script>
    
    
    <script>
    
    var vendorChart;
    
    function updateVendorChart(vendorData) {
        var ctx = document.getElementById('chart-vendors').getContext('2d');
        
        // Destruir la instancia anterior del gráfico si existe
        if (vendorChart) {
            vendorChart.destroy();
        }
        
        // Ordenar los datos de las franquicias de mayor a menor porcentaje
        var sortedVendorData = vendorData.sort((a, b) => b.percentage - a.percentage);
    
        // Preparar los datasets para cada franquicia, ahora ordenados
        var datasets = sortedVendorData.map(data => ({
            label: data.name, // Nombre de la franquicia
            data: [data.percentage], // Los datos deben ser un array, incluso si es un solo valor
            backgroundColor: generateRandomColor(), // Generar un color para cada franquicia
            borderColor: generateRandomColor(),
            borderWidth: 0
        }));
    
        // Crear el nuevo gráfico con múltiples datasets
        vendorChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Porcentaje de venta"], // Etiqueta genérica para el eje X
                datasets: datasets
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#181818'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                            return label + ': ' + value.toLocaleString(undefined, {minimumFractionDigits: 3}) + '%'; 
                        }
                    }
                }
            }
        });
    }
    
    // Función para generar un solo color aleatorio
    function generateRandomColor() {
        return 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.7)';
    }
    
    </script>
     
    
    <script>
        $(document).ready(function() {
        // Mostrar/Ocultar campos de fecha personalizada basado en la selección del usuario
                $('#gmv-timeframe').on('change', function() {
                var selectedTimeframe = $(this).val();
                if (selectedTimeframe === 'custom') {
                    $('#custom-date-range').show();
                } else {
                    $('#custom-date-range').hide();
                }
                handleFilterChange();
            });
        
            // Manejar cambios en las fechas personalizadas y en otros selectores
            $('#franchise-selector, #start-date, #end-date').on('change', handleFilterChange);
        
            // Función para manejar el cambio en los filtros y actualizar los datos
            function handleFilterChange() {
                var selectedTimeframe = $('#gmv-timeframe').val();
                var selectedFranchise = $('#franchise-selector').val();
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();
        
                var data = {
                    rucFranquicia: selectedFranchise,
                    timeframe: selectedTimeframe,
                    startDate: startDate,
                    endDate: endDate
                };
        
                $.ajax({
                    url: '{{ route("datacenter.filter") }}', // Asegúrate de que esta ruta esté definida correctamente en tus rutas de Laravel
                    type: 'GET',
                    data: data,
                    success: function(response) {
                        console.log("Datos recibidos para actualizar:", response.data);
                        // Actualizar los datos del dashboard
                        $('.gmv').text('$' + response.data.gmv);
                        $('.averageTicket').text('$' + response.data.averageTicket);
                        $('#totalSalesCount').text(response.data.totalSalesCount);
                        $('#totalSalesPendingCount').text(response.data.totalSalesPendingCount);
                        $('#totalSalesPending').text('$' + response.data.totalSalesPending);
                        $('#totalSalesPaidCount').text(response.data.totalSalesPaidCount);
                        $('#totalSalesCancelledCount').text(response.data.totalSalesCancelledCount);
                        $('#cac').text('$' + response.data.cac.cac);
                        $('#frequency').text(response.data.frequency);
                        $('#mau').text(response.data.mau);
                        $('#new-users').text(response.data.newUsers);
                        $('#arpu').text('$' + response.data.arpu);
        
                        // Actualiza la gráfica de vendedores si los datos están disponibles
                        if (response.data.salesByVendor && response.data.salesByVendor.length > 0) {
                            updateVendorChart(response.data.salesByVendor);
                        } else {
                            console.log("No se encontraron datos de ventas por vendedor.");
                        }
    
                        var selectedFranchise = $('#franchise-selector').val();
                        if(selectedFranchise === "") {
                            // No hay franquicia específica seleccionada (Todas las franquicias)
                            $('.cac-card').show();
                            $('.franchises-sales-card').show();
                        } else {
                            // Una franquicia específica está seleccionada
                            $('.cac-card').hide();
                            $('.franchises-sales-card').hide();
                        }
    
                        
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        
    // Función para actualizar el título basado en la franquicia seleccionada
        function updateTitle() {
            var selectedFranchiseName = $('#franchise-selector option:selected').data('name') || 'Todas las franquicias';
            $('#franchise-name').text(selectedFranchiseName);
        }
    
        // Evento de cambio para el selector de franquicias
        $('#franchise-selector').on('change', function() {
            updateTitle();
        });
    
        // Llamada inicial para establecer el título correcto al cargar la página
        updateTitle();
        handleFilterChange();
        });
    </script>
        
        



@endsection