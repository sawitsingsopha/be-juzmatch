<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveLogSearchNonmemberDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { save_log_search_nonmember: currentTable } });
var currentForm, currentPageID;
var fsave_log_search_nonmemberdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_log_search_nonmemberdelete = new ew.Form("fsave_log_search_nonmemberdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fsave_log_search_nonmemberdelete;
    loadjs.done("fsave_log_search_nonmemberdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsave_log_search_nonmemberdelete" id="fsave_log_search_nonmemberdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="save_log_search_nonmember">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->save_log_search_nonmember_id->Visible) { // save_log_search_nonmember_id ?>
        <th class="<?= $Page->save_log_search_nonmember_id->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_save_log_search_nonmember_id" class="save_log_search_nonmember_save_log_search_nonmember_id"><?= $Page->save_log_search_nonmember_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
        <th class="<?= $Page->category_id->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_category_id" class="save_log_search_nonmember_category_id"><?= $Page->category_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->min_installment->Visible) { // min_installment ?>
        <th class="<?= $Page->min_installment->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_min_installment" class="save_log_search_nonmember_min_installment"><?= $Page->min_installment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
        <th class="<?= $Page->max_installment->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_max_installment" class="save_log_search_nonmember_max_installment"><?= $Page->max_installment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->attribute_detail_id->Visible) { // attribute_detail_id ?>
        <th class="<?= $Page->attribute_detail_id->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_attribute_detail_id" class="save_log_search_nonmember_attribute_detail_id"><?= $Page->attribute_detail_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_cdate" class="save_log_search_nonmember_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_cip" class="save_log_search_nonmember_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_cuser" class="save_log_search_nonmember_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
        <th class="<?= $Page->first_name->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_first_name" class="save_log_search_nonmember_first_name"><?= $Page->first_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
        <th class="<?= $Page->last_name->headerCellClass() ?>"><span id="elh_save_log_search_nonmember_last_name" class="save_log_search_nonmember_last_name"><?= $Page->last_name->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->save_log_search_nonmember_id->Visible) { // save_log_search_nonmember_id ?>
        <td<?= $Page->save_log_search_nonmember_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_save_log_search_nonmember_id" class="el_save_log_search_nonmember_save_log_search_nonmember_id">
<span<?= $Page->save_log_search_nonmember_id->viewAttributes() ?>>
<?= $Page->save_log_search_nonmember_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
        <td<?= $Page->category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_category_id" class="el_save_log_search_nonmember_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<?= $Page->category_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->min_installment->Visible) { // min_installment ?>
        <td<?= $Page->min_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_min_installment" class="el_save_log_search_nonmember_min_installment">
<span<?= $Page->min_installment->viewAttributes() ?>>
<?= $Page->min_installment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
        <td<?= $Page->max_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_max_installment" class="el_save_log_search_nonmember_max_installment">
<span<?= $Page->max_installment->viewAttributes() ?>>
<?= $Page->max_installment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->attribute_detail_id->Visible) { // attribute_detail_id ?>
        <td<?= $Page->attribute_detail_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_attribute_detail_id" class="el_save_log_search_nonmember_attribute_detail_id">
<span<?= $Page->attribute_detail_id->viewAttributes() ?>>
<?= $Page->attribute_detail_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_cdate" class="el_save_log_search_nonmember_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_cip" class="el_save_log_search_nonmember_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_cuser" class="el_save_log_search_nonmember_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
        <td<?= $Page->first_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_first_name" class="el_save_log_search_nonmember_first_name">
<span<?= $Page->first_name->viewAttributes() ?>>
<?= $Page->first_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
        <td<?= $Page->last_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_log_search_nonmember_last_name" class="el_save_log_search_nonmember_last_name">
<span<?= $Page->last_name->viewAttributes() ?>>
<?= $Page->last_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
