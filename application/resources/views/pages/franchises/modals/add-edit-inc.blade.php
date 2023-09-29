<!-- Modal Structure -->
<div class="modal" id="franchiseModal" tabindex="-1" role="dialog" aria-labelledby="franchiseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="franchiseModalLabel" data-add-title="Registro de Nueva Franquicia" data-edit-title="Editar Franquicia">Registro de Nueva Franquicia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/franchise/create" method="post" id="franchiseForm">
                    @csrf <!-- Token de seguridad para formularios en Laravel -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-12 col-lg-3 text-left control-label col-form-label">Nombre:</label>
                        <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Introduce el nombre" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-12 col-lg-3 text-left control-label col-form-label">Dirección:</label>
                        <div class="col-sm-12 col-lg-9">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Introduce la dirección" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-12 col-lg-3 text-left control-label col-form-label">Teléfono:</label>
                        <div class="col-sm-12 col-lg-9">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Introduce el teléfono" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="franchiseModalActionButton" data-add-text="Registrar" data-edit-text="Actualizar">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        // Despliego el form
        $('#toggleFranchiseFormButton').click(function(){
            $('#franchiseFormContainer').slideToggle();
            // Setteo el modal a modo add
            setModalToAddMode();
        });

        // Funcion encargada del edit
        $('.edit-franchise-button').click(function(){
            const id = $(this).data('id');
            const name = $(this).data('name');
            const address = $(this).data('address');
            const phone = $(this).data('phone');

            // Cambio el action del form a editar
            $('#franchiseForm').attr('action', `/franchise/update/${id}`);
            // Hago populate de los campos
            $('#franchiseId').val(id);
            $('#name').val(name);
            $('#address').val(address);
            $('#phone').val(phone);

            // Cambio el modo del modal a edit
            setModalToEditMode();

            // Muestro el modal
            $('#franchiseModal').modal('show');
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
    });
</script>