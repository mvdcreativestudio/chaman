<div class="modal" id="franchiseModal" tabindex="-1" role="dialog" aria-labelledby="franchiseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="franchiseModalLabel" data-add-title="Registro de Nueva Franquicia" data-edit-title="Editar Franquicia">Registro de Nueva Franquicia</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
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
                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="franchiseModalActionButton" data-add-text="Registrar" data-edit-text="Actualizar">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
