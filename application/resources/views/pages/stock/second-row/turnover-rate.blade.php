<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>


<div class="col-lg-8  col-md-12 element-content">
        <div class="card">
            <div class="card-body">
            <div class="d-flex m-b-30 justify-content-between">
                <h5 class="card-title m-b-0 align-self-center pb-4">Tasa de rotación</h5>
                <div class="align-self-center">
                    <h6 class="card-title m-b-0 d-inline-block mr-2">Sucursal:</h6>
                    <select id="sucursal-select" class="form-control d-inline-block" style="width: auto;">
                        <option value="1">Sucursal 1</option>
                        <option value="2">Sucursal 2</option>
                        <option value="3">Sucursal 3</option>
                        <option value="4">Sucursal 4</option>
                        <option value="5">Sucursal 5</option>
                    </select>
                </div>
            </div>
                <div id="chart"></div>
 <!-- Script para renderizar el gráfico -->
 <script>
     document.addEventListener('DOMContentLoaded', function () {
         // Datos de ejemplo (puedes reemplazarlos con tus propios datos)
         var chartData = {
             columns: [
                 ['Datos 1', 30, 200, 100, 400, 150, 250],
                 ['Datos 2', 50, 20, 10, 40, 15, 25]
             ],
             type: 'bar'
         };
         // Configuración del gráfico
         var chartConfig = {
             bindto: '#chart', // ID del contenedor del gráfico
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