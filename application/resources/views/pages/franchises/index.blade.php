@extends('layout.wrapper') @section('content')

<!-- action button -->
@include('pages.franchises.modals.add-edit-inc')
@include('pages.franchises.modals.user-list')
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
                data-toggle="modal" data-target="#franchiseModal">
                <i class="ti-plus"></i>
            </button>
        </div>
    </div>

    <div class="mt-5">
        <div class="card" id="franchises-table-wrapper">
            <div class="card-body">
                <div class="table-responsive">
                    @if (@count($franchises ?? []) > 0)
                    <table id="franchises-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                        <thead>
                            <tr>
                                <th class="team_col_first_name">
                                    <a class="js-ajax-ux-request js-list-sorting" href="javascript:void(0)">Nombre</a>
                                </th>
                                <th class="team_col_position">
                                    <a class="js-ajax-ux-request js-list-sorting" href="javascript:void(0)">Dirección</a>
                                </th>
                                <th class="team_col_role">
                                    <a class="js-ajax-ux-request js-list-sorting" href="javascript:void(0)">Teléfono</a>
                                </th>
                                <th class="team_col_email">
                                    <a class="js-ajax-ux-request js-list-sorting" href="javascript:void(0)">Estado</a>
                                </th>
                                <th class="team_col_franchise">
                                    <a class="js-ajax-ux-request js-list-sorting" href="javascript:void(0)">Usuarios</a>
                                </th>
                                <th class="team_col_phone">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($franchises as $franchise)
                            <tr>
                                <td class="team_col_first_name">{{ $franchise->name }}</td>
                                <td class="team_col_position">{{ $franchise->address }}</td>
                                <td class="team_col_role">{{ $franchise->phone }}</td>
                                <td class="team_col_email">
                                    @if ($franchise->is_disabled)
                                        <span class="text-danger">Inactiva</span>
                                    @else
                                        <span class="text-success">Activa</span>
                                    @endif
                                </td>
                                <td class="team_col_franchise">
                                    <a href="javascript:void(0);" 
                                    class="franchise-users-count" 
                                    title="Mostrar Usuarios" 
                                    data-users="{{ json_encode($franchise->users) }}">
                                        <i class="ti-user"></i> {{ count($franchise->users) }}
                                    </a>
                                </td>
                                <td class="team_col_phone">
                                    <!--action buttons-->
                                    <span class="list-table-action dropdown font-size-inherit">
                                        <!-- Edit button -->
                                        <a href="javascript:void(0);" 
                                        class="btn btn-outline-success btn-circle btn-sm edit-franchise-button" 
                                        title="{{ cleanLang(__('lang.edit')) }}" 
                                        data-id="{{ $franchise->id }}" 
                                        data-name="{{ $franchise->name }}" 
                                        data-address="{{ $franchise->address }}" 
                                        data-phone="{{ $franchise->phone }}">
                                            <i class="sl-icon-note"></i>
                                        </a>
                                        <!-- Status button -->
                                        @if ($franchise->is_disabled)
                                            <a href="{{ url('/franchise/toggle/'.$franchise->id) }}" class="btn btn-outline-success btn-circle btn-sm">
                                                <i class="ti-check"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('/franchise/toggle/'.$franchise->id) }}" class="btn btn-outline-danger btn-circle btn-sm">
                                                <i class="ti-close"></i>
                                            </a>
                                        @endif
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

    div#franchises-table-wrapper * {
        font-size: 14px;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

function showUsersModal(event) {
    const users = JSON.parse(event.currentTarget.getAttribute('data-users'));
    let userList = document.getElementById('usersList');
    userList.innerHTML = ''; 

    try {
        users.forEach(function(user) {
            let row = document.createElement('tr');
            
            let nameCell = document.createElement('td');
            nameCell.textContent = user.first_name;
            
            let emailCell = document.createElement('td');
            emailCell.textContent = user.email;

            let roleCell = document.createElement('td');
            roleCell.textContent = user.role?.role_name;
            
            let actionCell = document.createElement('td');
            let disassociateButton = document.createElement('button');
            disassociateButton.classList.add('btn', 'btn-danger', 'btn-outline-danger', 'btn-circle', 'btn-sm');
            disassociateButton.innerHTML = '<i class="ti-close" title="{{ cleanLang(__("lang.remove")) }}"></i>';

            disassociateButton.addEventListener("click", function() {
                const userId = user.id; // Asegúrate de que tienes el ID del usuario disponible aquí
                const url = `/franchise/remove-franchise/${userId}`;

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
    } catch (e) {
        console.log(e)
    }
    
    $('#usersModal').modal('show');
}

let userCounts = document.querySelectorAll('.franchise-users-count');
userCounts.forEach(link => link.addEventListener('click', showUsersModal));

});
</script>
