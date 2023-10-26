<div class="col-12">
    <div class="row ">
        <div class="col-12 d-flex scrollable-container ">
            @foreach($payload['objectives'] as $objective)
            <!-- Tarjeta Dinámica -->
            <div class="col-lg-3 col-md-6 click-url cursor-pointer" data-url="{{ _url('/objectives') }}">
                <div class="card">
                    <div class="card-body p-l-15 p-r-15 pb-0">
                        <div class="d-flex p-10 no-block">
                            <span class="align-slef-center">
                                @if($objective->objective_type == 'numeric')
                                <h4 class="m-b-0">{{ $objective->name }}</h4>
                                <p class="objective text-muted p-0 mb-1 mr-4">{{ $objective->description }}</p>
                                <h4 class="m-b-0 mt-2">{{ $objective->progress }}%</h4>
                                <p class="objective-status m-0 p-0 m-b-0 m-t-5 text-wrap">Asignado a:
                                    @if($objective->user_id != null && $objective->franchise_id != null)
                                    {{ $objective->user->first_name }} {{ $objective->user->last_name }}  ({{ $objective->franchise->name }})
                                    @elseif($objective->user_id != null)
                                    {{ $objective->user->first_name }} {{ $objective->user->last_name }}
                                    @elseif($objective->franchise_id != null)
                                    {{ $objective->franchise->name }}
                                    @else
                                    -
                                    @endif
                                @else($objective->objective_type == 'alert')
                                <h4 class="m-b-0">{{ $objective->name }}</h4>
                                <p class="objective text-muted p-0 mb-1 mr-4">Límite: ${{ $objective->target_value }}</p>
                                <h4 class="m-b-0 mt-2">{{ $objective->progress }}%</h4>
                                <p class="objective-status m-0 p-0 m-b-0 m-t-5 text-wrap">Asignado a:
                                    @if($objective->user_id != null && $objective->franchise_id != null)
                                    {{ $objective->user->first_name }} {{ $objective->user->last_name }}  ({{ $objective->franchise->name }})
                                    @elseif($objective->user_id != null)
                                    {{ $objective->user->first_name }} {{ $objective->user->last_name }}
                                    @elseif($objective->franchise_id != null)
                                    {{ $objective->franchise->name }}
                                    @else
                                    -
                                    @endif
                                @endif
                                </p>
                            </span>
                            <div class="align-self-start ml-auto">
                                @if($objective->status == 'active')
                                    <p class="objective-status text-success">Activo</p>
                                @elseif($objective->status == 'inactive')
                                    <p class="objective-status text-warning">Vencido</p>
                                @endif                               
                            </div>
                        </div>
                    </div>
                    @if($objective->objective_type == 'numeric')
                    <div class="progress2">
                        <div class="progress-bar progress-bar-striped 
                            {{ $objective->progress < 25 ? 'bg-danger' : 
                               ($objective->progress > 25 && $objective->progress < 50 ? 'bg-warning' : 
                               ($objective->progress > 50 && $objective->progress < 75 ? 'bg-info' : 
                               ($objective->progress == 100 ? 'bg-success' : ''))) }}" 
                            role="progressbar" 
                            style="width: {{ $objective->progress }}%" 
                            aria-valuenow="{{ $objective->progress }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>  
                    @else
                    <div class="progress2">
                        <div class="progress-bar progress-bar-striped 
                            {{ $objective->progress < 25 ? 'bg-success' : 
                               ($objective->progress > 25 && $objective->progress <= 50 ? 'bg-info' : 
                               ($objective->progress > 50 && $objective->progress <= 75 ? 'bg-warning' : 
                               ($objective->progress > 75 ? 'bg-danger' : ''))) }}"
                            role="progressbar" 
                            style="width: {{ $objective->progress }}%" 
                            aria-valuenow="{{ $objective->progress }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>     
                    @endif    
                </div>
            </div>
            
            @endforeach            
        </div>
        
    </div>
    <!-- Flecha -->
    <i class="ti-angle-double-right arrow"></i>
</div>


<div id="alert-container" class="alert-container"></div>


<script>
    let maxHeight = 0;

$('.card').each(function() {
   if ($(this).height() > maxHeight) { 
      maxHeight = $(this).height(); 
   }
});

$('.card').height(maxHeight);
</script>


{{-- <div class="col-12">
    <div class="row">
        <div class="col-12 d-flex scrollable-container">
            @foreach($payload['objectives'] as $objective)
            <!-- Tarjeta Dinámica -->
            <div class="col-lg-4 col-md-4 col-6 cursor-pointer">
                <div class="card">
                    <div class="col-lg-4 col-md-4 col-6 cursor-pointer pr-0">
                        <div class="d-flex p-10 no-block justify-content-between">
                            <span class="align-slef-center">
                                <h4 class="m-b-0">{{ $objective->name }}</h4>
                                <p class="objective text-muted p-0 mb-1">{{ $objective->description }}</p>
                                <h6 class="text-muted m-b-0">{{ $objective->progress }}%</h6>
                            </span>
                            <span class="align-slef-center">
                                <p>Estado: {{ $objective->status }}</p>
                            </span>
                        </div>
                    </div>
                    <div class="progress2">
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{ $objective->progress }}%" aria-valuenow="{{ $objective->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Flecha -->
    <i class="ti-angle-double-right arrow"></i>
</div> --}}



<!-- Invoice - Due-->






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
