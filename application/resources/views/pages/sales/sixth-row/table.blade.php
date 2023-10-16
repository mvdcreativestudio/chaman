<div class="card-body">

<div class="table-responsive list-table-wrapper">
            
            <table id="clients-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <th class="clients_col_id">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_client_id" href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=client_id&sortorder=asc') }}">Cliente<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        <th class="clients_col_company">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_client_company_name"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=client_company_name&sortorder=asc') }}">Familia<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        
                        
                        <th class="clients_col_projects">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_count_projects"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=count_projects&sortorder=asc') }}">Categoria<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        
                        <th class="clients_col_invoices">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_sum_invoices"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=sum_invoices&sortorder=asc') }}">Cantidad<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        
                        
                        <th class="clients_col_category">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_category" href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=category&sortorder=asc') }}">Precio Total<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <th class="clients_col_category">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_category" href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=category&sortorder=asc') }}">Vendedor<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        
                    
                    </tr>
                </thead>
                <tbody id="clients-td-container">
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            
                        </td>
                    </tr>
                </tfoot>
            </table>
        
        </div>
</div>