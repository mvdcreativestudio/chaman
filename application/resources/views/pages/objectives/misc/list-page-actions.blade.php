<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right {{ $page['list_page_actions_size'] ?? '' }} {{ $page['list_page_container_class'] ?? '' }}"
    id="list-page-actions-container">
    <div id="list-page-actions">
        
        <!--ADD NEW ITEM-->
        
        <button type="button" class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request {{ $page['add_button_classes'] ?? '' }}" data-toggle="modal" data-target="#objectiveModal">
                    <i class="ti-plus"></i>
                </button>
        

    </div>
</div>