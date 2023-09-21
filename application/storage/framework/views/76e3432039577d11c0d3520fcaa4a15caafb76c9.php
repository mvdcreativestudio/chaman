<?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--each row-->
<tr id="source_<?php echo e($source->leadsources_id); ?>">
    <td class="sources_col_date">
        <?php echo e($source->leadsources_title); ?>

    </td>
    <td class="sources_col_name"><?php echo e(runtimeDate($source->leadsources_created)); ?></td>
    <td class="sources_col_created_by">
        <img src="<?php echo e(getUsersAvatar($source->avatar_directory, $source->avatar_filename)); ?>" alt="user"
            class="img-circle avatar-xsmall">
        <?php echo e($source->first_name ?? runtimeUnkownUser()); ?>

    </td>
    <td class="sources_col_action actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <button type="button"
            title="<?php echo e(cleanLang(__('lang.edit'))); ?>" class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(url('/settings/sources/'.$source->leadsources_id.'/edit')); ?>"
                data-loading-target="commonModalBody" data-modal-title="<?php echo e(cleanLang(__('lang.edit_lead_source'))); ?>"
                data-action-url="<?php echo e(url('/settings/sources/'.$source->leadsources_id)); ?>" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="sources-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <button type="button" title="<?php echo e(cleanLang(__('lang.delete'))); ?>" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger" data-confirm-title="<?php echo e(cleanLang(__('lang.delete_item'))); ?>" data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>" data-ajax-type="DELETE"
                data-url="<?php echo e(url('/')); ?>/settings/sources/<?php echo e($source->leadsources_id); ?>">
                <i class="sl-icon-trash"></i>
            </button>
        </span>
        <!--action button-->
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--each row--><?php /**PATH C:\laragon\www\Chaman\application\resources\views/pages/settings/sections/sources/table/ajax.blade.php ENDPATH**/ ?>