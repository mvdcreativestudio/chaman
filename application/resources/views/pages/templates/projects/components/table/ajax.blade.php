@foreach($projects as $project)
<!--each row-->
<tr id="projects_{{ $project->project_id }}">
    <td class="projects_col_title">
        <a href="{{ url('templates/projects/'.$project->project_id) }}">{{ str_limit($project->project_title ??'---', 30) }}</a>
    </td>
    <td class="projects_col_date">
        {{ runtimeDate($project->project_created) }}
    </td>
    <td class="projects_col_category">
        {{ $project->category_name }}
    </td>
    @if (request('user_role_type') == 'admin_role' || request('user_role_type') == 'franchise_admin_role')
    <td class="projects_col_createby">
        <img src="{{ getUsersAvatar($project->avatar_directory, $project->avatar_filename) }}" alt="user"
        class="img-circle avatar-xsmall"> {{ str_limit($project->first_name ?? runtimeUnkownUser(), 8) }}
    </td>
    @endif
    @if (request('user_role_type') == 'admin_role')
    <td>
        {{ $project->franchise->name ?? '---'  }}
    </td>
    @endif
    <td class="projects_col_action actions_column">
        <span class="list-table-action dropdown font-size-inherit">
            @if(request()->input('user_role_type') == 'admin_role' || 
                (request()->input('user_role_type') == 'franchise_admin_role' && $project->franchise_id == auth()->user()->franchise_id) || 
                (request()->input('user_role_type') == 'common_role' && $project->project_creatorid == auth()->id()))
                <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                    class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                    data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                    data-ajax-type="DELETE" data-url="{{ url('/') }}/templates/projects/{{ $project->project_id }}">
                    <i class="sl-icon-trash"></i>
                </button>
                <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                    class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                    data-toggle="modal" data-target="#commonModal"
                    data-url="{{ urlResource('/templates/projects/'.$project->project_id.'/edit') }}" data-loading-target="commonModalBody"
                    data-modal-title="{{ cleanLang(__('lang.edit_project')) }}" data-action-url="{{ urlResource('/templates/projects/'.$project->project_id) }}"
                    data-action-method="PUT" data-action-ajax-class="js-ajax-ux-request"
                    data-action-ajax-loading-target="templates-td-container">
                    <i class="sl-icon-note"></i>
                </button>
            @endif
        </span>
    </td>
</tr>
@endforeach
<!--each row-->