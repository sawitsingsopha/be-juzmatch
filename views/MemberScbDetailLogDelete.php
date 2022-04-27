<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberScbDetailLogDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member_scb_detail_log: currentTable } });
var currentForm, currentPageID;
var fmember_scb_detail_logdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmember_scb_detail_logdelete = new ew.Form("fmember_scb_detail_logdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fmember_scb_detail_logdelete;
    loadjs.done("fmember_scb_detail_logdelete");
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
<form name="fmember_scb_detail_logdelete" id="fmember_scb_detail_logdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member_scb_detail_log">
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
<?php if ($Page->member_scb_detail_log_id->Visible) { // member_scb_detail_log_id ?>
        <th class="<?= $Page->member_scb_detail_log_id->headerCellClass() ?>"><span id="elh_member_scb_detail_log_member_scb_detail_log_id" class="member_scb_detail_log_member_scb_detail_log_id"><?= $Page->member_scb_detail_log_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->member_scb_id->Visible) { // member_scb_id ?>
        <th class="<?= $Page->member_scb_id->headerCellClass() ?>"><span id="elh_member_scb_detail_log_member_scb_id" class="member_scb_detail_log_member_scb_id"><?= $Page->member_scb_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paid_amt->Visible) { // paid_amt ?>
        <th class="<?= $Page->paid_amt->headerCellClass() ?>"><span id="elh_member_scb_detail_log_paid_amt" class="member_scb_detail_log_paid_amt"><?= $Page->paid_amt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pay_date->Visible) { // pay_date ?>
        <th class="<?= $Page->pay_date->headerCellClass() ?>"><span id="elh_member_scb_detail_log_pay_date" class="member_scb_detail_log_pay_date"><?= $Page->pay_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_member_scb_detail_log_cdate" class="member_scb_detail_log_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_member_scb_detail_log_cip" class="member_scb_detail_log_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_member_scb_detail_log_cuser" class="member_scb_detail_log_cuser"><?= $Page->cuser->caption() ?></span></th>
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
<?php if ($Page->member_scb_detail_log_id->Visible) { // member_scb_detail_log_id ?>
        <td<?= $Page->member_scb_detail_log_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_member_scb_detail_log_id" class="el_member_scb_detail_log_member_scb_detail_log_id">
<span<?= $Page->member_scb_detail_log_id->viewAttributes() ?>>
<?= $Page->member_scb_detail_log_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->member_scb_id->Visible) { // member_scb_id ?>
        <td<?= $Page->member_scb_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_member_scb_id" class="el_member_scb_detail_log_member_scb_id">
<span<?= $Page->member_scb_id->viewAttributes() ?>>
<?= $Page->member_scb_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paid_amt->Visible) { // paid_amt ?>
        <td<?= $Page->paid_amt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_paid_amt" class="el_member_scb_detail_log_paid_amt">
<span<?= $Page->paid_amt->viewAttributes() ?>>
<?= $Page->paid_amt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pay_date->Visible) { // pay_date ?>
        <td<?= $Page->pay_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_pay_date" class="el_member_scb_detail_log_pay_date">
<span<?= $Page->pay_date->viewAttributes() ?>>
<?= $Page->pay_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_cdate" class="el_member_scb_detail_log_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_cip" class="el_member_scb_detail_log_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_cuser" class="el_member_scb_detail_log_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
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
