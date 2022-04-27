<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvertorBookingDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { invertor_booking: currentTable } });
var currentForm, currentPageID;
var finvertor_bookingdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvertor_bookingdelete = new ew.Form("finvertor_bookingdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = finvertor_bookingdelete;
    loadjs.done("finvertor_bookingdelete");
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
<form name="finvertor_bookingdelete" id="finvertor_bookingdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invertor_booking">
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
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><span id="elh_invertor_booking_asset_id" class="invertor_booking_asset_id"><?= $Page->asset_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th class="<?= $Page->date_booking->headerCellClass() ?>"><span id="elh_invertor_booking_date_booking" class="invertor_booking_date_booking"><?= $Page->date_booking->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th class="<?= $Page->status_expire->headerCellClass() ?>"><span id="elh_invertor_booking_status_expire" class="invertor_booking_status_expire"><?= $Page->status_expire->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th class="<?= $Page->status_expire_reason->headerCellClass() ?>"><span id="elh_invertor_booking_status_expire_reason" class="invertor_booking_status_expire_reason"><?= $Page->status_expire_reason->caption() ?></span></th>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
        <th class="<?= $Page->payment_status->headerCellClass() ?>"><span id="elh_invertor_booking_payment_status" class="invertor_booking_payment_status"><?= $Page->payment_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <th class="<?= $Page->is_email->headerCellClass() ?>"><span id="elh_invertor_booking_is_email" class="invertor_booking_is_email"><?= $Page->is_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <th class="<?= $Page->receipt_status->headerCellClass() ?>"><span id="elh_invertor_booking_receipt_status" class="invertor_booking_receipt_status"><?= $Page->receipt_status->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
        <td<?= $Page->payment_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<span<?= $Page->payment_status->viewAttributes() ?>>
<?= $Page->payment_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <td<?= $Page->is_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_is_email" class="el_invertor_booking_is_email">
<span<?= $Page->is_email->viewAttributes() ?>>
<?= $Page->is_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <td<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<span<?= $Page->receipt_status->viewAttributes() ?>>
<?= $Page->receipt_status->getViewValue() ?></span>
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
