<div class="table-responsive">
    @if (@count($roles ?? []) > 0)
    <table id="demo-foo-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
        <thead>
            <tr>
                <th class="roles_col_name text-center">{{ cleanLang(__('lang.name')) }}</th>
                <th class="roles_col_users text-center">{{ cleanLang(__('lang.active_users')) }}</th>
                <th class="roles_col_type text-center">{{ cleanLang(__('lang.type')) }}</th>
                <th class="roles_col_status text-center">{{ cleanLang(__('lang.status')) }}</th>
                <th class="roles_col_franchise text-center">Vinculable a Franquicia</th>
                <th class="roles_col_franchise_admin text-center">Administrador de Franquicia</th>
                <th class="roles_col_action text-center"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
            </tr>
        </thead>
        <tbody id="roles-td-container">
            <!--ajax content here-->
            @include('pages.settings.sections.roles.table.ajax')
            <!--ajax content here-->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="20">
                    <!--load more button-->
                    @include('misc.load-more-button')
                    <!--load more button-->
                </td>
            </tr>
        </tfoot>
    </table>
    @endif
    @if (@count($roles ?? []) == 0)
    <!--nothing found-->
    @include('notifications.no-results-found')
    <!--nothing found-->
    @endif

</div>