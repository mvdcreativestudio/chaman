@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

    <!--admin dashboard-->
    {{-- <!-- Toggle Switch para mostrar/ocultar datos -->
    <div class="switch-container">
        <label class="switch">
            <input type="checkbox" id="toggle-data" checked>
            <span class="slider rounded"></span>
        </label>
        <label for="toggle-data" class="switch-label">Gráfica Ingresos vs Gastos</label>
    </div> --}}
    @if(auth()->user()->is_team)
    @if(auth()->user()->is_admin)
    @include('pages.home.admin.wrapper')
    @else
    @include('pages.home.team.wrapper')
    @endif
    @endif

    @if(auth()->user()->is_client)
    @include('pages.home.client.wrapper')
    @endif



</div>
<!--main content -->
@endsection



{{-- SCRIPT PARA SWITCHES DE ELEMENTOS <script>
    $(document).ready(function () {
        // Manejar el cambio de estado del switch
        $("#toggle-data").change(function () {
            var isChecked = this.checked;
            
            // Lógica para mostrar u ocultar los datos en wrapper.blade.php
            if (isChecked) {
                $(".element-content").slideDown(); // Mostrar todos los datos
            } else {
                $(".element-content").slideUp(); // Ocultar todos los datos
            }
        });
    });
</script> --}}