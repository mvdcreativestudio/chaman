<div class="modal" id="associateModal" tabindex="-1" role="dialog" aria-labelledby="associateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="associateModalLabel">Asociar Número de Teléfono a Franquicia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('whatsapp.associate.phone') }}" method="POST">
                @csrf
                <div class="modal-body">
                <input type="hidden" name="phone_id" id="modalPhoneId">
                <input type="hidden" name="phone_number" id="modalPhoneNumber">
                    <div class="form-group">
                        <label for="franchiseList">Seleccione una Franquicia</label>
                        <select name="franchise_id" id="franchiseList" class="form-control">
                            @foreach($franchises as $franchise)
                                <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Asociar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(document).on('click', '.associate-btn', function() {
            var phoneId = $(this).data('phoneid');
            var phoneNumber = $(this).data('phonenumber');
            $('#modalPhoneId').val(phoneId);
            $('#modalPhoneNumber').val(phoneNumber);
        });
    });
</script>