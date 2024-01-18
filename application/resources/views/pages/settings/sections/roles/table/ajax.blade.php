@foreach($roles as $role)
<!--each row-->
<tr id="role_{{ $role->role_id }}">
    <td class="roles_col_name text-center">
        {{ $role->role_name }}
        <!--default-->
        @if($role->role_system == 'yes')
        <span class="sl-icon-star text-warning p-l-5" data-toggle="tooltip"
            title="{{ cleanLang(__('lang.system_default')) }}"></span>
        @endif
    </td>
    <td class="roles_col_users text-center">
        {{ $role->count_users }}
    </td>
    <td class="roles_col_type text-center">
        {{ $role->role_type }}
    </td>
    <td class="roles_col_status text-center">
        @if($role->role_system == 'yes')
        <span class="label label-outline-default">{{ cleanLang(__('lang.default')) }}</span>
        @else
        ---
        @endif
    </td>
    <td class="roles_col_franchise_status text-center">
        @if($role->franchise_role)
            <span class="label col-2 text-center label-success">Si</span>
        @else
            <span class="label col-2 text-center label-danger">No</span>
        @endif
    </td>
    <td class="roles_col_franchise_admin_status text-center">
        @if($role->franchise_admin_role)
            <span class="label col-2 text-center label-success">Si</span>
        @else
            <span class="label col-2 text-center label-danger">No</span>
        @endif
    </td>
    <td class="roles_col_action actions_column text-center">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            @if($role->role_id != 1)
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ url('/settings/roles/'.$role->role_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_user_role')) }}"
                data-action-url="{{ url('/settings/roles/'.$role->role_id) }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="roles-td-container">
                <i class="sl-icon-note"></i>
            </button>

            <!--homepage-->
            <button type="button" title="{{ cleanLang(__('lang.edit_home_page_setting')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ url('/settings/roles/'.$role->role_id.'/homepage') }}"
                data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_home_page_setting')) }}"
                data-action-url="{{ url('/settings/roles/'.$role->role_id.'/homepage') }}" data-action-method="PUT"
                data-action-ajax-cl     ass="" data-action-ajax-loading-target="roles-td-container">
                <i class="ti-home"></i>
            </button>
            @else
            <!--optionally show disabled button?-->
            <span class="btn btn-outline-default btn-circle btn-sm disabled {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                    class="sl-icon-note"></i></span>
            <span class="btn btn-outline-default btn-circle btn-sm disabled {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                    class="ti-home"></i></span>
            @endif
            @if($role->franchise_admin_role)
                <button type="button" title="{{ cleanLang(__('lang.set_as_non_franchise_admin')) }}"
                    data-role-id="{{ $role->role_id }}" 
                    onclick="toggleFranchiseAdmin(this); console.log('AAAAAAAAA')" 
                    class="toggleFranchiseAdminBtn data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm">
                    <i class="ti-close"></i>
                </button>
            @else
                <button type="button" title="{{ cleanLang(__('lang.set_as_franchise_admin')) }}"
                    data-role-id="{{ $role->role_id }}"
                    onclick="toggleFranchiseAdmin(this);" 
                    class="toggleFranchiseAdminBtn data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm">
                    <i class="ti-check"></i>
                </button>
            @endif
            @if($role->franchise_role)
                <button type="button" title="{{ cleanLang(__('lang.remove_franchise_role')) }}"
                    data-role-id="{{ $role->role_id }}" 
                    onclick="toggleFranchiseRole(this);" 
                    class="toggleFranchiseRoleBtn data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm">
                    <i class="ti-close"></i>
                </button>
            @else
            <button type="button" title="{{ cleanLang(__('lang.set_as_franchise_role')) }}"
                data-role-id="{{ $role->role_id }}"
                onclick="toggleFranchiseRole(this);" 
                class="toggleFranchiseRoleBtn data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm">
                <i class="ti-check"></i>
            </button>
        @endif
            @if($role->role_system == 'no')
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_user_role')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/') }}/settings/roles/{{ $role->role_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            @else
            <!--optionally show disabled button?-->
            <span class="btn btn-outline-default btn-circle btn-sm disabled {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                    class="sl-icon-trash"></i></span>
            @endif
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->

<script>
    function toggleFranchiseAdmin(buttonElement) {

        // Obtener el ID del rol desde el atributo data-role-id del botón
        const roleId = $(buttonElement).data('role-id');

        // Realizar la solicitud AJAX
        $.ajax({
            url: '/settings/roles/set-as-franchise-admin/' + roleId,
            type: 'POST',
            data: { _method: 'POST', _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    // Manejar cualquier error que pueda surgir
                    location.reload();
                }
            }
        });
    } 
    
    function toggleFranchiseRole(buttonElement) {

    // Obtener el ID del rol desde el atributo data-role-id del botón
    const roleId = $(buttonElement).data('role-id');

    // Realizar la solicitud AJAX
    $.ajax({
        url: '/settings/roles/set-franchise-role/' + roleId,
        type: 'GET',
        data: { _method: 'GET', _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            if (response.status === 'success') {
                location.reload();
            } else {
                // Manejar cualquier error que pueda surgir
                location.reload();
            }
        }
    });
}   
</script>
