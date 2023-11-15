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
                        <input type="text" class="form-control datepicker" id="date_range" name="date_range" autocomplete="off" placeholder="Selecciona el rango de fechas" required>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $('#date_range').daterangepicker({
            autoUpdateInput: false,
            autoApply: true,
            drops: 'up',
            locale: {
                applyLabel: "Aplicar",  // Aquí está el cambio
                cancelLabel: 'Limpiar'
            }
        });
        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
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
</script>


<script>
    $(document).ready(function() {

        $('#module').change(function() {
            updateModuleTargetOptions();
            setModuleTargetValue();
        });

        function updateModuleTargetOptions() {
            const moduleValue = $('#module').val();
            let options = '';

            if (moduleValue === "leads") {
                options = `
                    <option value="leads_created">Leads Creados</option>
                    <option value="leads_converted">Leads Convertidos</option>
                `;
            } else if (moduleValue === "sales") {
                options = `
                    <option value="sales_created">Ventas Creadas</option>
                    <option value="sales_converted">Ventas Convertidas</option>
                `;
            } else if (moduleValue === "expenses") {
                options = `
                    <option value="reduce_expenses">Reducir Gastos</option>
                `;
            } else {
                $('#module_target_dropdown').hide();
                return;
            }

            $('#module_target').html(options);
            $('#module_target_dropdown').show();
        }

        function setModuleTargetValue() {
            const moduleValue = $('#module').val();
            const targetValue = $('#module_target').val();
            
            if (moduleValue === "leads") {
                if (["leads_created", "leads_converted"].includes(targetValue)) {
                    $('#module_target').val(targetValue);
                } else {
                    $('#module_target').val(null);
                }
            } else if (moduleValue === "sales") {
                if (["sales_created", "sales_converted"].includes(targetValue)) {
                    $('#module_target').val(targetValue);
                } else {
                    $('#module_target').val(null);
                }
            } else if (moduleValue === "expenses") {
                if (["reduce_expenses"].includes(targetValue)) {
                    $('#module_target').val(targetValue);
                } else {
                    $('#module_target').val(null);
                }
            } else {
                $('#module_target').val(null);
            }
        }

    });
</script>

{{-- <script>
    $(document).ready(function() {
    
    // Listener para el envío del formulario
    $('#objectiveForm').on('submit', function(e) {
        e.preventDefault(); // Evita el envío normal del formulario

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Suponiendo que tu respuesta tenga un campo 'status' para verificar si la operación fue exitosa
                if (response.status === 'success') {
                    NX.notification({
                        message: 'Usuario agregado con éxito',
                        type: 'success'
                    });
                } else {
                    // Aquí puedes manejar otros tipos de respuestas, como errores
                    NX.notification({
                        message: 'Hubo un error al agregar el usuario',
                        type: 'warning'
                    });
                }
            },
            error: function() {
                // Este bloque se ejecutará si hay un error en la solicitud AJAX en sí (por ejemplo, problemas de red)
                NX.notification({
                    message: 'Error de conexión. Intente nuevamente.',
                    type: 'warning'
                });
            }
        });
    });
    
});

</script> --}}






