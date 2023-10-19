<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>


<div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-30 no-block">
                    <h5 class="card-title m-b-0 align-self-center list-inline font-18 label label-info label-rounded">Carritos Abandonados</h5>
                    <div class="ml-auto">
                        {{ cleanLang(__('lang.this_year')) }}
                    </div>
                </div>
                <div id="chart-carrito-abandonado"></div>
 <!-- Script para renderizar el gráfico -->
 <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Generar nombres de meses del 1/1 al 1/10
    var months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct'];

    // Generar datos aleatorios para carritos abandonados (entre 100 y 900) para cada mes
    var carritosAbandonados = [];
    for (var j = 0; j < 10; j++) {
        var carritosMes = Math.floor(Math.random() * (900 - 100 + 1)) + 100;
        carritosAbandonados.push(carritosMes);
    }

    var chartData = {
        x: 'x',
        columns: [
            ['x'].concat(months), // Utiliza los nombres de los meses en el eje x
            ['Carritos Abandonados'].concat(carritosAbandonados)
        ],
        type: 'bar' // Cambia el tipo de gráfico a 'bar' para mostrar los nombres de los meses
    };

    // Configuración del gráfico
    var chartConfig = {
        bindto: '#chart-carrito-abandonado', // ID del contenedor del gráfico
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