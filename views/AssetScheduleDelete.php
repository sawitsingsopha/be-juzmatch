<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetScheduleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_schedule: currentTable } });
var currentForm, currentPageID;
var fasset_scheduledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_scheduledelete = new ew.Form("fasset_scheduledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fasset_scheduledelete;
    loadjs.done("fasset_scheduledelete");
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
<form name="fasset_scheduledelete" id="fasset_scheduledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_schedule">
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><span id="elh_asset_schedule_asset_id" class="asset_schedule_asset_id"><?= $Page->asset_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <th class="<?= $Page->num_installment->headerCellClass() ?>"><span id="elh_asset_schedule_num_installment" class="asset_schedule_num_installment"><?= $Page->num_installment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <th class="<?= $Page->receive_per_installment_invertor->headerCellClass() ?>"><span id="elh_asset_schedule_receive_per_installment_invertor" class="asset_schedule_receive_per_installment_invertor"><?= $Page->receive_per_installment_invertor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><span id="elh_asset_schedule_expired_date" class="asset_schedule_expired_date"><?= $Page->expired_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th class="<?= $Page->date_payment->headerCellClass() ?>"><span id="elh_asset_schedule_date_payment" class="asset_schedule_date_payment"><?= $Page->date_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th class="<?= $Page->status_payment->headerCellClass() ?>"><span id="elh_asset_schedule_status_payment" class="asset_schedule_status_payment"><?= $Page->status_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <th class="<?= $Page->installment_all->headerCellClass() ?>"><span id="elh_asset_schedule_installment_all" class="asset_schedule_installment_all"><?= $Page->installment_all->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_asset_schedule_cdate" class="asset_schedule_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_asset_schedule_uip" class="asset_schedule_uip"><?= $Page->uip->caption() ?></span></th>
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <td<?= $Page->num_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_num_installment" class="el_asset_schedule_num_installment">
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <td<?= $Page->receive_per_installment_invertor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_receive_per_installment_invertor" class="el_asset_schedule_receive_per_installment_invertor">
<span<?= $Page->receive_per_installment_invertor->viewAttributes() ?>>
<?= $Page->receive_per_installment_invertor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_expired_date" class="el_asset_schedule_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_date_payment" class="el_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_status_payment" class="el_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <td<?= $Page->installment_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_installment_all" class="el_asset_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_cdate" class="el_asset_schedule_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_schedule_uip" class="el_asset_schedule_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
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
