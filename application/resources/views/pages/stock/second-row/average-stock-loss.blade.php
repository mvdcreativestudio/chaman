<div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-30 no-block">
                <h5 class="card-title m-b-0 align-self-center list-inline font-12 label label-info label-rounded">Promedio de Pérdida de Stock</h5>
                    <div class="ml-auto">
                        {{ cleanLang(__('lang.this_year')) }}
                    </div>
                </div>
                <div id="chart-pps"></div>
 <!-- Script para renderizar el gráfico -->
 <script>
     document.addEventListener('DOMContentLoaded', function () {
         // Datos de ejemplo (puedes reemplazarlos con tus propios datos)
         var chartData = {
             columns: [
                 ['Datos 1', 30, 200, 100, 400, 150, 250],
                 ['Datos 2', 50, 20, 10, 40, 15, 25]
             ],
             type: 'pie'
         };
         // Configuración del gráfico
         var chartConfig = {
             bindto: '#chart-pps', // ID del contenedor del gráfico
             data: chartData
             // Puedes personalizar más opciones según la documentación de C3: https://c3js.org/gettingstarted.html
         };
         // Renderizar el gráfico
         var chart = c3.generate(chartConfig);
     });
 </script>
               
            </div>
        </div>
    </div>