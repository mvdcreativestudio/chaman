"use strict";

$(document).ready(function(){
    $('.confirm-action-danger').on('click', function(e){
        e.preventDefault();

        let url = $(this).data('url');
        let ajaxType = 'POST'; // Seteamos directamente a POST

        if(confirm($(this).data('confirm-text'))) {
            $.ajax({
                url: url,
                type: ajaxType,
                data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') }, // Añadimos el _method DELETE y el token CSRF
                success: function(response) {
                    if(response.status == 'success') {
                        alert('Franchise deleted successfully!');
                        // Aquí podrías, por ejemplo, eliminar la fila de la tabla correspondiente al registro eliminado.
                    } else {
                        alert(response.message);
                    }
                },
                error: function(error) {
                    alert('Error deleting franchise!');
                }
            });
        }
    });

    // FUNCIONES MODAL TEAM MEMBER
    $(document).on('change', '#isFranchisedSwitch', function() {
        let isFranchisedSwitch = $('#isFranchisedSwitch');
        let franchiseDropdownContainer = $('#franchiseDropdown');
        if (isFranchisedSwitch.is(':checked')) {
            franchiseDropdownContainer.show();
        } else {
            franchiseDropdownContainer.hide();
        }
    });

    window.loadFranchisesToDropdown = () => { // La exporto como ventana para poder usarla en el modal creado con Ajax.
        const button = $('.btn-add-circle');
        const franchises = JSON.parse(button.attr('data-franchises'));
        const franchiseDropdown = $('#franchise_id');
    
        franchiseDropdown.empty();  // Limpia las opciones actuales
    
        franchiseDropdown.append($('<option></option>'));  // Añade una opción vacía
    
        $.each(franchises, function(index, franchise) {
            var option = $('<option></option>').val(franchise.id).text(franchise.name);
            franchiseDropdown.append(option);
        });
    }
    // FUNCIONES MODAL TEAM MEMBER

    // FUNCIONES MODAL FRANCHISE
    $('#toggleFranchiseFormButton').click(function() {
        $('#franchiseFormContainer').slideToggle();
        setModalToAddMode();
    });

    $('.edit-franchise-button').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const address = $(this).data('address');
        const phone = $(this).data('phone');

        $('#franchiseForm').attr('action', `/franchise/update/${id}`);
        $('#franchiseId').val(id);
        $('#name').val(name);
        $('#address').val(address);
        $('#phone').val(phone);

        setModalToEditMode();

        $('#franchiseModal').modal('show');
    });

    $('#usersModal .btn-close').on('click', function() {
        $('#usersModal').modal('hide');
    });

    $('#franchiseModal .btn-close').on('click', function() {
        $('#franchiseModal').modal('hide');
    });


    function setModalToAddMode() {
        $('#franchiseModalLabel').text($('#franchiseModalLabel').data('add-title'));
        $('#franchiseModalActionButton').text($('#franchiseModalActionButton').data('add-text'));
        $('#franchiseForm').attr('action', '/franchise/create');
    }

    function setModalToEditMode() {
        $('#franchiseModalLabel').text($('#franchiseModalLabel').data('edit-title'));
        $('#franchiseModalActionButton').text($('#franchiseModalActionButton').data('edit-text'));
    }
    // FUNCIONES MODAL FRANCHISE
});
