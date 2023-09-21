<!--only for estimate-->
<?php if($bill->bill_type == 'estimate'): ?>
<tr class="estimation-notes-template lineitem_<?php echo e($lineitem->lineitem_id ?? ''); ?>">
    <td colspan="8" class="estimation-notes">
        <div class="x-wrapper estimation-notes-text">
            <?php echo $lineitem->item_notes_estimatation ?? ''; ?>

        </div>
    </td>
</tr>
<?php endif; ?><?php /**PATH C:\laragon\www\Chaman\application\resources\views/pages/bill/components/elements/line-estimation-notes.blade.php ENDPATH**/ ?>