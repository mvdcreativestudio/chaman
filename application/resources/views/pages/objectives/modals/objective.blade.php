<div class="modal" id="objectiveModal" tabindex="-1" role="dialog" aria-labelledby="objectiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="objectiveModalLabel" data-add-title="Crear Nuevo Objetivo" data-edit-title="Editar Objetivo">Crear Nuevo Objetivo</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/objective/create') }}" method="post" id="objectiveForm">
                    @csrf <!-- Token de seguridad para formularios en Laravel -->

                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Introduce el nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Describe el objetivo" required>
                    </div>

                    <div class="form-group">
                        <label for="module">Módulo:</label>
                        <select class="form-control" id="module" name="module">
                            <option value="" selected disabled>Seleccione un módulo</option>
                            <option value="leads">Leads</option>
                            <option value="sales">Ventas</option>
                            <option value="clients">Clientes</option>
                            <option value="expenses">Gastos</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="module_target_dropdown" style="display: none;">
                        <label for="module_target">Opción:</label>
                        <select class="form-control" id="module_target" name="module_target"></select>
                    </div>
                    
                    

                    <div class="form-group">
                        <label for="target_value">Valor Objetivo:</label>
                        <input type="number" class="form-control" id="target_value" name="target_value" placeholder="Introduce el valor objetivo" required>
                    </div>

                    <div class="form-group">
                        <label for="assign_to">Asignar a:</label>
                        <select class="form-control" id="assign_to" name="assign_to">
                            <option value="">-- Seleccione --</option>
                            <option value="franchise">Franquicia</option>
                            <option value="user">Usuario</option>
                        </select>
                    </div>

                    <div class="form-group" id="user_dropdown" style="display: none;">
                        <label for="user_id">Usuario:</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">Seleccione un usuario</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group" id="franchise_dropdown" style="display: none;">
                        <label for="franchise_id">Franquicia:</label>
                        <select class="form-control" id="franchise_id" name="franchise_id">
                            <option value="">Seleccione una franquicia</option>
                            @foreach(\App\Models\Franchise::all() as $franchise)
                                <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_range">Selecciona el Rango de Fechas:</label>
                        <input type="text" class="form-control datepicker" id="date_range" name="date_range" placeholder="Selecciona el rango de fechas" required>
                    </div>
                    

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="objectiveModalActionButton" data-add-text="Crear" data-edit-text="Actualizar">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

