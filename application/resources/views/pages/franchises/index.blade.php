@extends('layout.wrapper') @section('content')

<!-- action button -->
@include('pages.franchises.modals.add-edit-inc')
<!-- action button -->

<!-- main content -->
<div class="container-fluid">

    <div class="text-right {{ $page['list_page_actions_size'] ?? '' }} {{ $page['list_page_container_class'] ?? '' }}"
        id="list-page-actions-container"
        >
        @if(session('success'))
        <div class="alert alert-success text-left">
            {{ session('success') }}
        </div>
        @endif
        <div id="list-page-actions">
            <button type="button"
                class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form {{ $page['add_button_classes'] ?? '' }}"
                data-toggle="modal" data-target="#franchiseModal">
                <i class="ti-plus"></i>
            </button>
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
                                <th>Estado</th>
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
                                    @if ($franchise->is_disabled)
                                        <span class="text-danger">Inactiva</span>
                                    @else
                                        <span class="text-success">Activa</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0);" 
                                    class="btn btn-outline-success btn-circle btn-sm edit-franchise-button" 
                                    title="{{ cleanLang(__('lang.edit')) }}" 
                                    data-id="{{ $franchise->id }}" 
                                    data-name="{{ $franchise->name }}" 
                                    data-address="{{ $franchise->address }}" 
                                    data-phone="{{ $franchise->phone }}">
                                        <i class="sl-icon-note"></i>
                                    </a>

                                    @if ($franchise->is_disabled)
                                        <a href="{{ url('/franchise/toggle/'.$franchise->id) }}" class="btn btn-outline-success btn-circle btn-sm">
                                            <i class="ti-check"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('/franchise/toggle/'.$franchise->id) }}" class="btn btn-outline-danger btn-circle btn-sm">
                                            <i class="ti-close"></i>
                                        </a>
                                    @endif
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
@endsection

