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
});
