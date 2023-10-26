@if(config('system.settings_projects_permissions_basis') == 'category_based')
    <div class="alert alert-info">@lang('lang.projects_assigned_auto')</div>
    <div class="alert alert-info">@lang('lang.you_can_change_in_settings')</div>
@else
    @if(in_array(request()->input('user_role_type'), ['admin_role', 'franchise_admin_role']))
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.assigned')) }}</label>
        <div class="col-sm-12 col-lg-9">
            <select name="assigned" id="assigned"
                class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                multiple="multiple" tabindex="-1" aria-hidden="true">

                <!--array of assigned-->
                @if(isset($page['section']) && $page['section'] == 'edit' && isset($project->assigned)) <!-- Change from $lead->assigned to $project->assigned -->
                @foreach($project->assigned as $user) <!-- Change from $lead->assigned to $project->assigned -->
                @php $assigned[] = $user->id; @endphp
                @endforeach
                @endif
                <!--/#array of assigned-->

                <!--users list-->
                @php 
                $users_to_show = config('system.team_members');
                
                if (request()->input('user_role_type') == 'franchise_admin_role') {
                    $users_to_show = $users_to_show->filter(function ($user) {
                        return $user->franchise_id == auth()->user()->franchise_id;
                    });
                }
                @endphp

                @foreach($users_to_show as $user)
                <option value="{{ $user->id }}" {{ in_array($user->id ?? '', $assigned ?? []) ? 'selected' : '' }}>
                    {{ $user->full_name }}
                </option>
                @endforeach
                <!--/#users list-->
            </select>
        </div>
    </div>
    @endif
@endif
