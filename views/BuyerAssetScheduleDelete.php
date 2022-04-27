<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetScheduleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fbuyer_asset_scheduledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_scheduledelete = new ew.Form("fbuyer_asset_scheduledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fbuyer_asset_scheduledelete;
    loadjs.done("fbuyer_asset_scheduledelete");
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
<form name="fbuyer_asset_scheduledelete" id="fbuyer_asset_scheduledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset_schedule">
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
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <th class="<?= $Page->num_installment->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_num_installment" class="buyer_asset_schedule_num_installment"><?= $Page->num_installment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <th class="<?= $Page->installment_per_price->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_installment_per_price" class="buyer_asset_schedule_installment_per_price"><?= $Page->installment_per_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th class="<?= $Page->pay_number->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_pay_number" class="buyer_asset_schedule_pay_number"><?= $Page->pay_number->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_expired_date" class="buyer_asset_schedule_expired_date"><?= $Page->expired_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th class="<?= $Page->date_payment->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_date_payment" class="buyer_asset_schedule_date_payment"><?= $Page->date_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th class="<?= $Page->status_payment->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_status_payment" class="buyer_asset_schedule_status_payment"><?= $Page->status_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_buyer_asset_schedule_cdate" class="buyer_asset_schedule_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <td<?= $Page->num_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <td<?= $Page->installment_per_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<span<?= $Page->installment_per_price->viewAttributes() ?>>
<?= $Page->installment_per_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_cdate" class="el_buyer_asset_schedule_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
