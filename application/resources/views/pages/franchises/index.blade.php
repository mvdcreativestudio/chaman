@extends('layout.wrapper') @section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- main content -->
<div class="container-fluid">

    <div class="text-right">
        <button type="button"
            class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            id="toggleFranchiseFormButton">
            <i class="ti-plus"></i>
        </button>

    </div>
    
    
    <div id="franchiseFormContainer" style="display:none;">
        <div class="mt-5">
            <h2>Registro de Nueva Franquicia</h2>
                <form action="/franchise/create" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Introduce el nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección:</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Introduce la dirección" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Introduce el teléfono" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>     
        </div>
    </div>
    
    <div class="mt-5">
        <div class="card count-{{ @count($franchises ?? []) }}" id="franchises-table-wrapper">
            <div class="card-body">
                <div class="table-responsive list-table-wrapper">
                    @if (@count($franchises ?? []) > 0)
                    <table id="franchises-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($franchises as $franchise)
                            <tr>
                                <td>{{ $franchise->id }}</td>
                                <td>{{ $franchise->name }}</td>
                                <td>{{ $franchise->address }}</td>
                                <td>{{ $franchise->phone }}</td>
                                <td>
                                    <!--action button-->
                                    <a href="/franchise/{{ $franchise->id }}/edit" class="btn btn-outline-success btn-circle btn-sm" title="{{ cleanLang(__('lang.edit')) }}"><i class="sl-icon-note"></i></a>
                                    <button type="button" title="{{ cleanLang(__('lang.delete')) }}" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                                    data-confirm-title="{{ cleanLang(__('lang.delete_franchise')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                                    data-url="{{ url('/franchise/'.$franchise->id) }}"><i class="sl-icon-trash"></i></button>
                                    <!--/action button-->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <!--nothing found-->
                    @include('notifications.no-results-found')
                    <!--nothing found-->
                    @endif
                </div>
            </div>
        </div>
    
    
    
        
    </div>


</div>


<!--main content -->

<script>
    $(document).ready(function(){
        $('#toggleFranchiseFormButton').click(function(){
            $('#franchiseFormContainer').slideToggle();
        });
    });
</script>
@endsection


