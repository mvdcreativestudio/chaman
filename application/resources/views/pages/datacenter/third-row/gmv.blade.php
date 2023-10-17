<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>


<div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-30 no-block">
                    <h5 class="card-title m-b-0 align-self-center list-inline font-12 label label-info label-rounded">GMV</h5>
                    <div class="ml-auto">
                        {{ cleanLang(__('lang.this_year')) }}
                    </div>
                </div>
                <div id="chart1"></div>
 <!-- Script para renderizar el gráfico -->
 <script>
     document.addEventListener('DOMContentLoaded', function () {
         // Datos de ejemplo (puedes reemplazarlos con tus propios datos)
         var chartData = {
             columns: [
                 ['E-Commerce', 30, 200, 100, 400, 150, 250],
                 ['Fisica', 50, 20, 10, 40, 15, 25]
             ],
             type: 'pie'
         };
         // Configuración del gráfico
         var chartConfig = {
             bindto: '#chart1', // ID del contenedor del gráfico
             data: chartData
             // Puedes personalizar más opciones según la documentación de C3: https://c3js.org/gettingstarted.html
         };
         // Renderizar el gráfico
         var chart = c3.generate(chartConfig);
     });
 </script>
                
            </div>
        </div>
    </div> --}}

    <!-- Column -->
<div class="col-lg-4 col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex m-b-30 no-block">
                <h5 class="card-title m-b-0 align-self-center">{{ cleanLang(__('lang.gmv')) }}</h5>
                <div class="ml-auto">
                    {{ cleanLang(__('lang.this_year')) }}
                </div>
            </div>
            <div id="gmvWidget"></div>
            <ul class="list-inline m-t-30 text-center font-12">
                <li class="p-b-10"><span class="label label-primary label-rounded"><i class="fa fa-circle text-primary"></i> B2B</span></li>
                <li class="p-b-10"><span class="label label-info label-rounded"><i class="fa fa-circle text-info"></i> B2C</span></li>
            </ul>
        </div>
    </div>
</div>

<!--[DYNAMIC INLINE SCRIPT]  Backend Variables to Javascript Variables-->
<script>
    // Datos ficticios para GMV B2B y B2C
    var gmvData = {
        series: [2000, 5000] // Por ejemplo, 2000 para B2B y 5000 para B2C
    };

    // Opciones para el gráfico donut
    var gmvOptions = {
        donut: true,
        donutWidth: 60,
        startAngle: 270,
        total: 7000, // Suma total de B2B y B2C
        showLabel: true,
        labelInterpolationFnc: function(value) {
            if (value == 2000) {
                return 'B2B';
            } else {
                return 'B2C';
            }
        }
    };

    // Crear el gráfico
    new Chartist.Pie('#gmvWidget', gmvData, gmvOptions);
</script>
