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
                            <option value="leads">Leads</option>
                            <option value="invoices">Invoices</option>
                            <option value="payments">Payments</option>
                            <option value="clients">Clients</option>
                            <option value="expenses">Expenses</option>
                        </select>
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


    <!-- Date Ranger Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    applyLabel: "Aplicar",  // Aquí está el cambio
                    cancelLabel: 'Limpiar'
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

    <!-- Fin Date Ranger Picker -->

    <!-- Seleccionar Objetivo -->

<script>
    $(document).ready(function() {
    // Listener para el cambio en el desplegable "Asignar a"
    $('#assign_to').change(function() {
        toggleDropdowns();

        if($(this).val() === "franchise") {
            loadFranchises(); // Carga franquicias via AJAX
        } else if ($(this).val() === "user") {
            loadUsers(); // Carga usuarios via AJAX
        }
    });
});

// Muestra u oculta los desplegables en función del desplegable "assign_to"
function toggleDropdowns() {
    if ($('#assign_to').val() === "franchise") {
        $('#franchise_dropdown').show();
        $('#user_dropdown').hide();
    } else if ($('#assign_to').val() === "user") {
        $('#user_dropdown').show();
        $('#franchise_dropdown').hide();
    } else {
        $('#franchise_dropdown').hide();
        $('#user_dropdown').hide();
    }
}

// Ejemplo de función AJAX para cargar franquicias
function loadFranchises() {
    $.get('/path/to/franchises/endpoint', function(data) {
        let options = '<option value="">Seleccione una franquicia</option>';
        data.forEach(franchise => {
            options += `<option value="${franchise.id}">${franchise.name}</option>`;
        });
        $('#franchise_id').html(options);
    });
}

// Ejemplo de función AJAX para cargar usuarios
function loadUsers() {
    $.get('/path/to/users/endpoint', function(data) {
        let options = '<option value="">Seleccione un usuario</option>';
        data.forEach(user => {
            options += `<option value="${user.id}">${user.first_name} ${user.last_name}</option>`;
        });
        $('#user_id').html(options);
    });
}

</script>
