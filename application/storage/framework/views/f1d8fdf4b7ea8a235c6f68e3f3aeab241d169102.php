<?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--each row-->
<tr id="lead_<?php echo e($lead->lead_id); ?>">
    <?php if(config('visibility.leads_col_checkboxes')): ?>
    <td class="leads_col_checkbox checkitem" id="leads_col_checkbox_<?php echo e($lead->lead_id); ?>">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-leads-<?php echo e($lead->lead_id); ?>"
                name="ids[<?php echo e($lead->lead_id); ?>]"
                class="listcheckbox listcheckbox-leads filled-in chk-col-light-blue"
                data-actions-container-class="leads-checkbox-actions-container">
            <label for="listcheckbox-leads-<?php echo e($lead->lead_id); ?>"></label>
        </span>
    </td>
    <?php endif; ?>
    <td class="leads_col_title" id="leads_col_title_<?php echo e($lead->lead_id); ?>">
        <a class="show-modal-button reset-card-modal-form js-ajax-ux-request" data-toggle="modal"
            href="javascript:void(0)" data-target="#cardModal" data-url="<?php echo e(urlResource('/leads/'.$lead->lead_id)); ?>"
            data-loading-target="main-top-nav-bar" id="table_lead_title_<?php echo e($lead->lead_id); ?>">
            <?php echo e(str_limit($lead->lead_title, 20)); ?></a>
    </td>
    <td class="leads_col_contact" id="leads_col_contact_<?php echo e($lead->lead_id); ?>">
        <?php echo e(str_limit($lead->full_name, 15)); ?>

    </td>
    <td class="leads_col_date" id="leads_col_date_<?php echo e($lead->lead_id); ?>">
        <?php echo e(runtimeDate($lead->lead_created)); ?>

    </td>
    <td class="leads_col_company" id="leads_col_company_<?php echo e($lead->lead_id); ?>">
        <?php echo e(str_limit($lead->category_name ?? '---', 15)); ?>

    </td>
    <td class="leads_col_assigned" id="leads_col_assigned_<?php echo e($lead->lead_id); ?>">
        <!--assigned users-->
        <?php if(count($lead->assigned ?? []) > 0): ?>
        <?php $__currentLoopData = $lead->assigned->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <img src="<?php echo e($user->avatar); ?>" data-toggle="tooltip" title="<?php echo e($user->first_name); ?>" data-placement="top"
            alt="<?php echo e($user->first_name); ?>" class="img-circle avatar-xsmall">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <span>---</span>
        <?php endif; ?>
        <!--assigned users-->
        <!--more users-->
        <?php if(count($lead->assigned ?? []) > 2): ?>
        <?php $more_users_title = __('lang.assigned_users'); $users = $lead->assigned; ?>
        <?php echo $__env->make('misc.more-users', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <!--more users-->
    </td>
    <td class="leads_col_stage" id="leads_col_stage_<?php echo e($lead->lead_id); ?>">
        <span class="label <?php echo e(bootstrapColors($lead->leadstatus->leadstatus_color ?? '', 'label')); ?>">
            <!--notes: alternatve lang for lead status will need to be added manally by end user in lang files-->
            <?php echo e(runtimeLang($lead->leadstatus->leadstatus_title ?? '')); ?></span>

            <!--archived-->
        <?php if($lead->lead_active_state == 'archived' && runtimeArchivingOptions()): ?>
        <span class="label label-icons label-icons-default" data-toggle="tooltip" data-placement="top"
            title="<?php echo app('translator')->get('lang.archived'); ?>"><i class="ti-archive"></i></span>
        <?php endif; ?>
    </td>
    <td class="leads_col_value" id="leads_col_value_<?php echo e($lead->lead_id); ?>">
        <?php echo e(runtimeMoneyFormat($lead->lead_value)); ?>

    </td>
    <td class="leads_col_action actions_column" id="leads_col_action_<?php echo e($lead->lead_id); ?>">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <?php if(config('visibility.action_buttons_delete')): ?>
            <!--[delete]-->
            <?php if($lead->permission_delete_lead): ?>
            <button type="button" title="<?php echo e(cleanLang(__('lang.delete'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="<?php echo e(cleanLang(__('lang.delete_item'))); ?>"
                data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>" data-ajax-type="DELETE"
                data-url="<?php echo e(url('/')); ?>/leads/<?php echo e($lead->lead_id); ?>">
                <i class="sl-icon-trash"></i>
            </button>
            <?php else: ?>
            <!--optionally show disabled button?-->
            <span class="btn btn-outline-default btn-circle btn-sm disabled  <?php echo e(runtimePlaceholdeActionsButtons()); ?>"
                data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.actions_not_available'))); ?>"><i
                    class="sl-icon-trash"></i></span>
            <?php endif; ?>
            <?php endif; ?>
            <!--send email-->
            <button type="button" title="<?php echo app('translator')->get('lang.send_email'); ?>"
                class="data-toggle-action-tooltip btn btn-outline-warning btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(url('/appwebmail/compose?view=modal&webmail_template_type=leads&resource_type=lead&resource_id='.$lead->lead_id)); ?>"
                data-loading-target="commonModalBody" data-modal-title="<?php echo app('translator')->get('lang.send_email'); ?>"
                data-action-url="<?php echo e(url('/appwebmail/send')); ?>" data-action-method="POST" data-modal-size="modal-xl"
                data-action-ajax-loading-target="leads-td-container">
                <i class="ti-email display-inline-block m-t-3"></i>
            </button>
            <!--view-->
            <button type="button" title="<?php echo e(cleanLang(__('lang.view'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm show-modal-button reset-card-modal-form js-ajax-ux-request"
                data-toggle="modal" data-target="#cardModal" data-url="<?php echo e(urlResource('/leads/'.$lead->lead_id)); ?>"
                data-loading-target="main-top-nav-bar">
                <i class="ti-new-window"></i>
            </button>
        </span>
        <!--action button-->
        <!--more button (team)-->
        <?php if(config('visibility.action_buttons_edit')): ?>
        <span class="list-table-action dropdown font-size-inherit">
            <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                title="<?php echo e(cleanLang(__('lang.more'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                <i class="ti-more"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="listTableAction">
                <!--change category-->
                <?php if($lead->permission_edit_lead): ?>
                <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                    href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                    data-modal-title="<?php echo e(cleanLang(__('lang.change_category'))); ?>"
                    data-url="<?php echo e(url('/leads/change-category')); ?>"
                    data-action-url="<?php echo e(urlResource('/leads/change-category?id='.$lead->lead_id)); ?>"
                    data-loading-target="actionsModalBody" data-action-method="POST">
                    <?php echo e(cleanLang(__('lang.change_category'))); ?></a>
                <!--change status-->
                <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                    href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                    data-modal-title="<?php echo e(cleanLang(__('lang.change_status'))); ?>"
                    data-url="<?php echo e(urlResource('/leads/'.$lead->lead_id.'/change-status')); ?>"
                    data-action-url="<?php echo e(urlResource('/leads/'.$lead->lead_id.'/change-status')); ?>"
                    data-loading-target="actionsModalBody" data-action-method="POST">
                    <?php echo e(cleanLang(__('lang.change_status'))); ?></a>

                <!--archive-->
                <?php if($lead->lead_active_state == 'active' && runtimeArchivingOptions()): ?>
                <a class="dropdown-item confirm-action-info"
                    data-confirm-title="<?php echo e(cleanLang(__('lang.archive_lead'))); ?>"
                    data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>" data-ajax-type="PUT"
                    data-url="<?php echo e(urlResource('/leads/'.$lead->lead_id.'/archive')); ?>">
                    <?php echo e(cleanLang(__('lang.archive'))); ?>

                </a>
                <?php endif; ?>

                <!--activate-->
                <?php if($lead->lead_active_state == 'archived' && runtimeArchivingOptions()): ?>
                <a class="dropdown-item confirm-action-info"
                    data-confirm-title="<?php echo e(cleanLang(__('lang.restore_lead'))); ?>"
                    data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>" data-ajax-type="PUT"
                    data-url="<?php echo e(urlResource('/leads/'.$lead->lead_id.'/activate')); ?>">
                    <?php echo e(cleanLang(__('lang.restore'))); ?>

                </a>
                <?php endif; ?>


                <?php else: ?>
                <span class="small">--- no options avaiable</span>
                <?php endif; ?>
            </div>
        </span>
        <?php endif; ?>
        <!--more button-->
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--each row--><?php /**PATH C:\laragon\www\application\resources\views/pages/leads/components/table/ajax.blade.php ENDPATH**/ ?>