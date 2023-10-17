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
     <!-- Datos aleatorios para las filas de la tabla -->
     <!-- Puedes generar estos datos de manera dinámica en tu servidor o en JavaScript -->
     <tr>
         <td>Cliente1</td>
         <td>Familia1</td>
         <td>Categoria1</td>
         <td>100</td>
         <td>$2.198</td>
         <td>Vendedor1</td>
     </tr>
     <tr>
         <td>Cliente2</td>
         <td>Familia2</td>
         <td>Categoria2</td>
         <td>200</td>
         <td>$2.198</td>
         <td>Vendedor2</td>
     </tr>
     <tr>
         <td>Cliente3</td>
         <td>Familia3</td>
         <td>Categoria3</td>
         <td>300</td>
         <td>$2.198</td>
         <td>Vendedor3</td>
     </tr>
     <tr>
         <td>Cliente4</td>
         <td>Familia4</td>
         <td>Categoria4</td>
         <td>400</td>
         <td>$2.198</td>
         <td>Vendedor4</td>
     </tr>
     <tr>
         <td>Cliente5</td>
         <td>Familia5</td>
         <td>Categoria5</td>
         <td>500</td>
         <td>$2.198</td>
         <td>Vendedor5</td>
     </tr>
     <tr>
         <td>Cliente6</td>
         <td>Familia6</td>
         <td>Categoria6</td>
         <td>600</td>
         <td>$2.198</td>
         <td>Vendedor6</td>
     </tr>
     <tr>
         <td>Cliente7</td>
         <td>Familia7</td>
         <td>Categoria7</td>
         <td>700</td>
         <td>$2.198</td>
         <td>Vendedor7</td>
     </tr>
     <tr>
         <td>Cliente8</td>
         <td>Familia8</td>
         <td>Categoria8</td>
         <td>800</td>
         <td>$2.198</td>
         <td>Vendedor8</td>
     </tr>
     <tr>
         <td>Cliente9</td>
         <td>Familia9</td>
         <td>Categoria9</td>
         <td>900</td>
         <td>$2.198</td>
         <td>Vendedor9</td>
     </tr>
     <tr>
         <td>Cliente10</td>
         <td>Familia10</td>
         <td>Categoria10</td>
         <td>1000</td>
         <td>$2.198</td>
         <td>Vendedor10</td>
     </tr>
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