@extends('layout.wrapper') @section('content')


    <!-- Action buttons modals -->
    @include('pages.objectives.modals.add-new-objective')
    <!-- Action buttons modals -->

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row page-titles">
            <!-- Page Title & Bread Crumbs -->
            @include('misc.heading-crumbs')
            <!-- Page Title & Bread Crumbs -->

            <!-- action buttons -->
            @include('pages.objectives.misc.list-page-actions')
             <!-- action buttons -->
        </div>

        <div class="text-right {{ $page['list_page_actions_size'] ?? '' }} {{ $page['list_page_container_class'] ?? '' }}" id="list-page-actions-container">
            @if(session('success'))
                <!-- Success message -->
                <div class="alert alert-success text-left">
                    {{ session('success') }}
                </div>
                <!-- Success message -->
            @endif

        
        </div>

        <div class="mt-5">
            <div class="card objectivesTable" id="objectives-table-wrapper">
                <div class="card-body">
                    <div class="table-responsive">
                        @if(count($objectives ?? []) > 0)
                            <!-- Objectives table -->
                            <table id="objectives-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Objetivo</th>
                                        <th>Asignado a</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($objectives as $objective)
                                        <!-- Objective row -->
                                        <tr>
                                            <td>{{ $objective->id }}</td>                                            
                                            <td><a href="/objective-detail">{{ $objective->name }}</a></td>
                                            <td>
                                                <!-- Module type -->
                                                @if($objective->module == 'leads') Leads
                                                @elseif($objective->module == 'sales') Facturación
                                                @elseif($objective->module == 'clients') Clientes
                                                @elseif($objective->module == 'expenses') Gastos
                                                @else -
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Target value -->
                                                @if($objective->module_target == 'sales_created' || $objective->module_target == 'sales_converted' || $objective->module_target == 'reduce_expenses')
                                                    ${{ number_format($objective->target_value, 0, ',', '.') }}
                                                @else
                                                    {{ $objective->target_value }}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Assigned user/franchise -->
                                                @if($objective->user)
                                                    {{ $objective->user->first_name . ' ' . $objective->user->last_name }}
                                                    @if($objective->objective) ({{ $objective->objective->name }}) @endif
                                                @elseif($objective->objective)
                                                    {{ $objective->objective->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Action buttons -->
                                                <span class="list-table-action dropdown font-size-inherit">
                                                    <!-- Edit button -->
                                                    <a href="javascript:void(0);" 
                                                        class="btn btn-outline-success btn-circle btn-sm edit-objective-button" 
                                                        title="{{ cleanLang(__('lang.edit')) }}" 
                                                        data-id="{{ $objective->id }}" 
                                                        data-name="{{ $objective->name }}" 
                                                        data-address="{{ $objective->address }}" 
                                                        data-phone="{{ $objective->phone }}"
                                                        data-toggle="modal"
                                                        data-target="#editObjectiveModal">
                                                    <i class="sl-icon-note"></i>
                                                    </a>
                                                    <!-- Status button -->
                                                    <a href="{{ url('/objective/destroy/'.$objective->id) }}" class="btn btn-outline-danger btn-circle btn-sm">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                </span>
                                                <!-- Action buttons -->
                                            </td>
                                        </tr>
                                        <!-- Objective row -->
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Objectives table -->
                        @else
                            <!-- No results found -->
                            @include('notifications.no-results-found')
                            <!-- No results found -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
@endsection











