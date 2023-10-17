<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>


<div class="col-lg-8  col-md-12 element-content">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-30">
                    <h5 class="card-title m-b-0 align-self-center list-inline font-12 label label-info label-rounded">GMV</h5>
                    <div class="ml-auto align-self-center">
                        
                    </div>
                </div>
                <div id="chart"></div>
 <!-- Script para renderizar el gráfico -->
 
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Generar fechas del 1/10 al 31/12
        var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre'];

        // Generar datos aleatorios para GMV E-Commerce y GMV Físico (entre 3,000,000 y 6,000,000)
        var randomGMVECommerce = [];
        var randomGMVFisico = [];
        var randomGMVTotal = [];

        for (var j = 0; j < 10; j++) {
            var gmvECommerce = Math.floor(Math.random() * (6000000 - 3000000 + 1)) + 3000000;
            var gmvFisico = Math.floor(Math.random() * (6000000 - 3000000 + 1)) + 3000000;
            randomGMVECommerce.push(gmvECommerce);
            randomGMVFisico.push(gmvFisico);
            randomGMVTotal.push(gmvECommerce + gmvFisico);
        }

        var chartData = {
            x: 'x',
            columns: [
                ['x'].concat(months),
                ['E-Commerce'].concat(randomGMVECommerce),
                ['Física'].concat(randomGMVFisico),
                ['GMV'].concat(randomGMVTotal)
            ],
            types: {
                'E-Commerce': 'area',
                'Física': 'area',
                'Anual': 'area-spline'
            },
            groups: [['E-Commerce', 'Física']]
        };

        var chartConfig = {
            bindto: '#chart',
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

        var chart = c3.generate(chartConfig);
    });
</script>
                
            </div>
        </div>
    </div>


    <!--[DYNAMIC INLINE SCRIPT] - Backend Variables to Javascript Variables-->
    