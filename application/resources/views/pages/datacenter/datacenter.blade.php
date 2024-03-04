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

<div class="row col-12 pt-4">
    <div class="col-lg-3 col-md-6 col-12">
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
    
    <div class="col-lg-3 col-md-6 col-12">
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
    
    <div class="col-lg-3 col-md-6 col-12">
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

{{-- Second Row --}}

<div class="row col-12">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15 text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0 gmv">{{ $gmv }}</h2>
                        <h6 class="text-muted m-b-0">Ingresos netos</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15 text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesPaid">${{ $totalSalesPaid }}</h2>
                        <h6 class="text-muted m-b-0">Vendido contado</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15 text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesPending">{{ $totalSalesPending }}</h2>
                        <h6 class="text-muted m-b-0">Vendido a crédito</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-warning w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15 text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesParcialPayment">{{ $totalSalesParcialPayment }}</h2>
                        <h6 class="text-muted m-b-0">Vendido con pago parcial</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-danger w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    
</div>


{{-- Second Row --}}

<div class="row col-12">

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body p-l-15 p-r-15 text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0 averageTicket">{{ $averageTicket }}</h2>
                        <h6 class="text-muted m-b-0">Ticket Medio</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card cac-card">
            <div class="card-body p-l-15 p-r-15 text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="cac">{{ $cac }}</h2>
                        <h6 class="text-muted m-b-0">Costo de adquisición</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-danger w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-self-center">
                        <h2 class="m-b-0" id="roi">{{ $roi['roi'] }}%</h2>
                        <h6 class="text-muted m-b-0">ROI</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar {{ $roi['roi'] >= 0 ? 'bg-success' : 'bg-danger' }} w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="frequency">{{ $frequency }}</h2>
                        <h6 class="text-muted m-b-0">Freq. de compra</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-secondary w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    
</div>


{{-- Third Row --}}

<div class="row col-12">
    

    <div class="col-lg-2 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="mau">{{ $mau }}</h2>
                        <h6 class="text-muted m-b-0">Clientes activos</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="inactive-clients">{{ $inactiveClients }}</h2>
                        <h6 class="text-muted m-b-0">Clientes inactivos</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="new-users">{{ $newUsers }}</h2>
                        <h6 class="text-muted m-b-0">Nuevos clientes</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="arpu">{{ $arpu }}</h2>
                        <h6 class="text-muted m-b-0">ARPU</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="churn">{{ $churn }}</h2>
                        <h6 class="text-muted m-b-0">CHURN</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-1" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

{{-- Fourth Row --}}
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

{{-- Fifth Row --}}

<div class="row col-12">

    <div class="table-responsive col-6">
        <div class="mb-4">
            <h5>Mejores clientes</h5>
        </div>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre Cliente</th>
                    <th>RUC Franquicia</th>
                    <th>Total Gastado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topSpendingClients as $client)
                    <tr>
                        <td>{{ $client->client_company_name }}</td>
                        <td>{{ $client->franchise_ruc }}</td>
                        <td>${{ $client->total_spent }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay datos disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-responsive col-6">
        <div class="mb-4">
            <h5>Mejores clientes</h5>
        </div>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre Cliente</th>
                    <th>RUC Franquicia</th>
                    <th>Total Gastado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topSpendingClients as $client)
                    <tr>
                        <td>{{ $client->client_company_name }}</td>
                        <td>{{ $client->franchise_ruc }}</td>
                        <td>${{ $client->total_spent }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay datos disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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

    function initializeEmptyVendorChart() {
            var ctx = document.getElementById('chart-vendors').getContext('2d');
            if (vendorChart) {
                vendorChart.destroy();
            }
            vendorChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [], // Sin etiquetas de datos
                    datasets: [{
                        label: 'No hay datos disponibles',
                        data: [], // Sin datos
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
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
        $('#gmv-timeframe').on('change', function() {
            var selectedTimeframe = $(this).val();
            if (selectedTimeframe === 'custom') {
                $('#custom-date-range').show();
            } else {
                $('#custom-date-range').hide();
            }
            handleFilterChange();
        });

        $('#franchise-selector, #start-date, #end-date').on('change', handleFilterChange);

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
                url: '{{ route("datacenter.filter") }}',
                type: 'GET',
                data: data,
                success: function(response) {
                    console.log("Datos recibidos para actualizar:", response.data);
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
                    $('#churn').text(response.data.churn);
                    $('#inactive-clients').text(response.data.inactiveClients);
                    $('#roi').text(response.data.roi.roi + '%');
                    $('#totalSalesPaid').text('$' + response.data.totalSalesPaid);
                    $('#totalSalesParcialPayment').text('$' + response.data.totalSalesParcialPayment);


                    // Actualiza la gráfica de vendedores si los datos están disponibles
                    if (response.data.salesByVendor && response.data.salesByVendor.length > 0) {
                        updateVendorChart(response.data.salesByVendor);
                    } else {
                        initializeEmptyVendorChart(); // Asegúrate de definir esta función
                        console.log("No se encontraron datos de ventas por vendedor.");
                    }

                    // Actualizar la tabla de mejores clientes
                    var $tableBody = $('.table-responsive .table tbody');
                    $tableBody.empty(); // Vaciar la tabla existente

                    if (response.data.topSpendingClients && response.data.topSpendingClients.length > 0) {
                        response.data.topSpendingClients.forEach(function(client) {
                            var newRow = '<tr>' +
                                '<td>' + client.client_company_name + '</td>' +
                                '<td>' + client.franchise_ruc + '</td>' +
                                '<td>$' + client.total_spent + '</td>' +
                                '</tr>';
                            $tableBody.append(newRow);
                        });
                    } else {
                        $tableBody.append('<tr><td colspan="4">No hay datos disponibles</td></tr>');
                    }

                    var selectedFranchise = $('#franchise-selector').val();
                    if (selectedFranchise === "") {
                        $('.cac-card').show();
                        $('.franchises-sales-card').show();
                    } else {
                        $('.cac-card').hide();
                        $('.franchises-sales-card').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        function updateTitle() {
            var selectedFranchiseName = $('#franchise-selector option:selected').data('name') || 'Todas las franquicias';
            $('#franchise-name').text(selectedFranchiseName);
        }

        $('#franchise-selector').on('change', function() {
            updateTitle();
        });

        updateTitle();
        handleFilterChange();
    });
</script>

        
        



@endsection