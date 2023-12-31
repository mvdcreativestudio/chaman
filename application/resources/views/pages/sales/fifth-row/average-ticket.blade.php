<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>


<div class="col-lg-8  col-md-12 element-content">
    <div class="card">
        <div class="card-body">
            <div class="d-flex m-b-30">
                <h5 class="card-title m-b-0 align-self-center">Ticket Medio</h5>
                <div class="ml-auto align-self-center">
                    
                </div>
            </div>
            <div id="chart"></div>
                            
        </div>
    </div>
</div>
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
            color: {
                pattern: ['#006C9C', '#003768'] // Colores de las líneas del gráfico
            },
            bar: {
                width: {
                    ratio: 0.6 // Configura el ancho de las barras
                }
            },
            data: chartData,
            axis: {
                x: {
                    type: 'category'
                }
            }

            // Puedes personalizar más opciones según la documentación de C3: https://c3js.org/gettingstarted.html
        };

        // Renderizar el gráfico
        var chart = c3.generate(chartConfig);
    });

 </script>



    <!--[DYNAMIC INLINE SCRIPT] - Backend Variables to Javascript Variables-->
    