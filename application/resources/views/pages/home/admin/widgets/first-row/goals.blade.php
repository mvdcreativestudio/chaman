<!-- Contenedor padre -->
<div class="col-12">
    <div class="row">
        <div class="col-12 d-flex scrollable-container">
            <!-- Tarjeta 1 -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer pl-0">
                <div class="card">
                    <div class="card-body p-l-15 p-r-15">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">Objetivo 1</h4>
                                <h6 class="text-muted m-b-0">38%</h6>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 2 -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer">
                <div class="card">
                    <div class="card-body p-l-15 p-r-15">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">Objetivo 2</h4>
                                <h6 class="text-muted m-b-0">25%</h6>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer pr-0">
                <div class="card">
                    <div class="card-body p-l-15 p-r-0">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">Objetivo 3</h4>
                                <h6 class="text-muted m-b-0">79%</h6>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 79%" aria-valuenow="79" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 4 -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer">
                <div class="card">
                    <div class="card-body p-l-15 p-r-15">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">Objetivo 4</h4>
                                <h6 class="text-muted m-b-0">50%</h6>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 5 -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer">
                <div class="card">
                    <div class="card-body p-l-15 p-r-15">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">Objetivo 5</h4>
                                <h6 class="text-muted m-b-0">50%</h6>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 10%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 6 -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer pr-0">
                <div class="card">
                    <div class="card-body p-l-15 p-r-0">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">Objetivo 6</h4>
                                <h6 class="text-muted m-b-0">50%</h6>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 95%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Flecha -->
    <i class="ti-angle-double-right arrow"></i>
</div>



<!-- Script para hacer scroll horizontal -->
<script>
// Script para mostrar/ocultar flecha según el desplazamiento
const container = document.querySelector('.scrollable-container');
const arrow = document.querySelector('.arrow');

const updateArrowVisibility = () => {
    if (container.scrollLeft + container.clientWidth < container.scrollWidth) {
        arrow.style.display = 'block';
    } else {
        arrow.style.display = 'none';
    }
}

// Inicializa la visibilidad
updateArrowVisibility();

// Escucha el evento de desplazamiento
container.addEventListener('scroll', updateArrowVisibility);

// Script para hacer scroll horizontal
let isDown = false;
let startX;
let scrollLeft;

container.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
});

container.addEventListener('mouseleave', () => {
    isDown = false;
});

container.addEventListener('mouseup', () => {
    isDown = false;
});

container.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX);
    container.scrollLeft = scrollLeft - walk;
});



</script>
