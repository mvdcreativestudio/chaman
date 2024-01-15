@extends('layout.wrapper')

@section('title', 'Nuevo Datacenter')

@section ('content')

{{-- Selector de períodos --}}
<div class="d-flex mt-4">
    <div class="col-3">
        <form id="gmv-selector-form" class="form-inline">
            <div class="form-group mb-2">
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
        </form>
        
    </div>
</div>

{{-- First Row --}}

<div class="d-flex col-12 pt-4">
    <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=due') }}">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0" id="totalSalesCount">{{ $totalSalesCount }}</h2>
                        <h6 class="text-muted m-b-0">Cantidad de Ordenes</h6>
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
    
    <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=overdue') }}">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">NaN</h2>
                        <h6 class="text-muted m-b-0">ARPU</h6>
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
    
    <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=due') }}">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">NaN</h2>
                        <h6 class="text-muted m-b-0">Credito en la Calle</h6>
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
    
    <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=due') }}">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">NaN</h2>
                        <h6 class="text-muted m-b-0">CLV</h6>
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
</div>

<div class="d-flex col-12 pt-4">    
    
    <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=due') }}">
        <div class="general-app-widget" >
              <div class="chart-sparkline" >
                    <div class="layer" >
                    </div>
                    <svg class="layer2" width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.599609 30.9996C0.599609 47.7891 14.2102 61.3996 30.9996 61.3996C47.7891 61.3996 61.3996 47.7891 61.3996 30.9996C61.3996 14.2102 47.7891 0.599609 30.9996 0.599609" stroke="#5BE584" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="number-percent-rand" > 98% </div>
              </div>
              <div class="text" >
                    <div class="number-long-rand gmv" > ${{ $gmv }} </div>

                    <div class="conversion" >GMV</div>
              </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ url('invoices/search?ref=list&filter_bill_status[]=due') }}">
        <div class="general-app-widget" >
              <div class="chart-sparkline" >
                    <div class="layer" >
                    </div>
                    <svg class="layer2" width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.599609 30.9996C0.599609 47.7891 14.2102 61.3996 30.9996 61.3996C47.7891 61.3996 61.3996 47.7891 61.3996 30.9996C61.3996 14.2102 47.7891 0.599609 30.9996 0.599609" stroke="#5BE584" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="number-percent-rand" > 98% </div>
              </div>
              <div class="text" >
                    <div class="number-long-rand averageTicket" > ${{ $averageTicket }} </div>
                    <div class="conversion" >Ticket Medio</div>
              </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $('#gmv-selector-form').on('change', '#gmv-timeframe', function() {
            var selectedTimeframe = $(this).val();
    
            var data = {};
            if (selectedTimeframe === 'custom') {
                $('#custom-date-range').show();
                data.startDate = $('#start-date').val();
                data.endDate = $('#end-date').val();
            } else {
                $('#custom-date-range').hide();
                data.timeframe = selectedTimeframe;
            }
            console.log(data);
            $.ajax({
                url: '{{ route('datacenter.filter') }}',
                type: 'GET',
                data: data,
                success: function(response) {
                    if(response && response.data) {
                        console.log(response.data);
                        $('.gmv').text('$' + response.data.gmv);
                        $('.averageTicket').text('$' + response.data.averageTicket);
                        $('#totalSalesCount').text(response.data.totalSalesCount);
                    } else {
                        console.error('No data in response', response);
                }
            }
            });
        });
    
        // Manejar cambios en las fechas personalizadas
        $('#custom-date-range input').on('change', function() {
            $('#gmv-selector-form').trigger('change');
        });
    });
</script>
    




@endsection