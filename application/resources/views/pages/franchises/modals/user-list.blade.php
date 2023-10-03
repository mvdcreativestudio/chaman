<div class="modal" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="display: flex; width: auto;">
        <div class="modal-content" style="display: flex; width: auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="usersModalLabel">Lista de Usuarios</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Rol</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="usersList">
                        <!-- Aquí se agregan los usuarios dinámicamente -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>