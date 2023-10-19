<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>


<div class="col-lg-8  col-md-12 element-content">
        <div class="card">
            <div class="card-body">
            <div class="d-flex m-b-30 justify-content-between">
            <h5 class="card-title m-b-0 align-self-center list-inline font-18 label label-info label-rounded">Ticket Medio</h5>
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
        // Nombres de los meses de enero a octubre
        var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre'];

        // Datos de ejemplo (puedes reemplazarlos con tus propios datos)
        var chartData = {
            x: 'x',
            columns: [
                ['x'].concat(months), // Utiliza los nombres de los meses en el eje x
                ['E-Commerce', 30, 200, 100, 281, 150, 250, 310, 410, 560, 640], // Datos de GMV E-Commerce
                ['Física', 35, 190, 98, 262, 154, 250, 330, 420, 570, 660] // Datos de GMV Física
            ],
            type: 'bar'
        };

        // Configuración del gráfico
        var chartConfig = {
            bindto: '#chart', // ID del contenedor del gráfico
            data: chartData,
            axis: {
                x: {
                    type: 'category' // Configura el eje x como una categoría
                }
            }
            // Puedes personalizar más opciones según la documentación de C3: https://c3js.org/gettingstarted.html
        };

        // Renderizar el gráfico
        var chart = c3.generate(chartConfig);
    });

 </script>
                
            </div>
        </div>
    </div>


    <!--[DYNAMIC INLINE SCRIPT] - Backend Variables to Javascript Variables-->
    