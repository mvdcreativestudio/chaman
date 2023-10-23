@extends('layout.wrapper') @section('content')

<!-- action button -->
@include('pages.objectives.modals.add-new-objective')
@include('pages.objectives.modals.edit-objective')
<!-- action button -->

<!-- main content -->
<div class="container-fluid">


    <div class="row page-titles">
            
            <!-- Page Title & Bread Crumbs -->
            @include('misc.heading-crumbs')
            <!--Page Title & Bread Crumbs -->
    </div>

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
                data-toggle="modal" data-target="#objectiveModal">
                <i class="ti-plus"></i>
            </button>
        </div>
    </div>

    <div class="mt-5">
        <div class="card" id="objectives-table-wrapper">
            <div class="card-body">
                <div class="table-responsive">
                    @if (@count($objectives ?? []) > 0)
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
                            <tr>
                                <td>{{ $objective->id }}</td>
                                <td>{{ $objective->name }}</td>
                                <td>
                                    @if($objective->module == 'leads')
                                        Leads
                                    @elseif($objective->module == 'sales')
                                        Facturación
                                    @elseif($objective->module == 'clients')
                                        Clientes
                                    @elseif($objective->module == 'expenses')
                                        Gastos
                                    @else 
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($objective->module_target == 'sales_created' || $objective->module_target == 'sales_converted' || $objective->module_target == 'reduce_expenses')
                                    ${{ number_format($objective->target_value, 0, ',', '.') }}
                                    @else
                                        {{ $objective->target_value}}
                                    @endif
                                </td>
                                <td>
                                    @if ($objective->user)
                                        {{ $objective->user->first_name . ' ' . $objective->user->last_name }}
                                        @if ($objective->franchise)
                                            ({{ $objective->franchise->name }})
                                        @endif
                                    @elseif ($objective->franchise)
                                        {{ $objective->franchise->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <!--action buttons-->
                                    <span class="list-table-action dropdown font-size-inherit">
                                        <!-- Edit button -->
                                        <a href="javascript:void(0);" 
                                        class="btn btn-outline-success btn-circle btn-sm edit-objective-button" 
                                        title="{{ cleanLang(__('lang.edit')) }}" 
                                        data-id="{{ $objective->id }}" 
                                        data-name="{{ $objective->name }}" 
                                        data-module="{{ $objective->module }}" 
                                        data-target_value="{{ $objective->target_value }}"
                                        data-user="{{ $objective->user }}"
                                        data-franchise="{{ $objective->franchise }}"
                                        data-toggle="modal" 
                                        data-target="#editObjectiveModal">
                                        <i class="sl-icon-note"></i>
                                        </a>
                                        <!-- Status button -->
                                            <a href="{{ url('/objective/destroy/'.$objective->id) }}" class="btn btn-outline-danger btn-circle btn-sm">
                                                <i class="ti-close"></i>
                                            </a>
                                    </span>
                                    <!--action buttons-->
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

<style>
    #list-page-actions-container {
        display: flex;
    }
    #list-page-actions-container .alert {
        width: 97%;
    }
    #list-page-actions-container #list-page-actions {
        width: 3%;
        margin-left: auto;
    }

    div#objectives-table-wrapper * {
        font-size: 14px;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

function showUsersModal(event) {
    const users = JSON.parse(event.currentTarget.getAttribute('data-users'));
    let userList = document.getElementById('usersList');
    userList.innerHTML = ''; 

    users.forEach(function(user) {
        let row = document.createElement('tr');
        
        let nameCell = document.createElement('td');
        nameCell.textContent = user.first_name;
        
        let emailCell = document.createElement('td');
        emailCell.textContent = user.email;

        let roleCell = document.createElement('td');
        roleCell.textContent = user.role.role_name;
        
        let actionCell = document.createElement('td');
        let disassociateButton = document.createElement('button');
        disassociateButton.classList.add('btn', 'btn-danger', 'btn-outline-danger', 'btn-circle', 'btn-sm');
        disassociateButton.innerHTML = '<i class="ti-close" title="{{ cleanLang(__("lang.remove")) }}"></i>';

        disassociateButton.addEventListener("click", function() {
            const userId = user.id; // Asegúrate de que tienes el ID del usuario disponible aquí
            const url = `/objective/remove-objective/${userId}`;

            fetch(url, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        actionCell.appendChild(disassociateButton);

        nameCell.classList.add('text-center');
        actionCell.classList.add('text-center');
        emailCell.classList.add('text-center');
        roleCell.classList.add('text-center');
        
        row.appendChild(nameCell);
        row.appendChild(emailCell);
        row.appendChild(roleCell);
        row.appendChild(actionCell);
        
        userList.appendChild(row);
    });

    $('#usersModal').modal('show');
}

let userCounts = document.querySelectorAll('.objective-users-count');
userCounts.forEach(link => link.addEventListener('click', showUsersModal));

});
</script>

<script>
    $(document).ready(function() {
    // Listener para el clic en el botón de edición
    $('.edit-objective-button').on('click', function() {
        // Obtén los datos del botón
        var id = $(this).data('id');
        var name = $(this).data('name');
        var module = $(this).data('module');
        var targetValue = $(this).data('target_value');
        var user = $(this).data('user');
        var franchise = $(this).data('franchise');

        // Llena los campos del modal de edición
        $('#editObjectiveModal #id').val(id);
        $('#editObjectiveModal #name').val(name);
        $('#editObjectiveModal #module').val(module);
        $('#editObjectiveModal #target_value').val(targetValue);
        $('#editObjectiveModal #user').val(user);
        $('#editObjectiveModal #franchise').val(franchise);

        // Abre el modal de edición
        $('#editObjectiveModal').modal('show');
    });
});

</script>
