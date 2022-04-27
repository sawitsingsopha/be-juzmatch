<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogTestPaymentDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_test_payment: currentTable } });
var currentForm, currentPageID;
var flog_test_paymentdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_test_paymentdelete = new ew.Form("flog_test_paymentdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = flog_test_paymentdelete;
    loadjs.done("flog_test_paymentdelete");
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
<form name="flog_test_paymentdelete" id="flog_test_paymentdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_test_payment">
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
<?php if ($Page->log_test_payment_id->Visible) { // log_test_payment_id ?>
        <th class="<?= $Page->log_test_payment_id->headerCellClass() ?>"><span id="elh_log_test_payment_log_test_payment_id" class="log_test_payment_log_test_payment_id"><?= $Page->log_test_payment_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th class="<?= $Page->member_id->headerCellClass() ?>"><span id="elh_log_test_payment_member_id" class="log_test_payment_member_id"><?= $Page->member_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><span id="elh_log_test_payment_asset_id" class="log_test_payment_asset_id"><?= $Page->asset_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_log_test_payment_type" class="log_test_payment_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th class="<?= $Page->date_booking->headerCellClass() ?>"><span id="elh_log_test_payment_date_booking" class="log_test_payment_date_booking"><?= $Page->date_booking->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th class="<?= $Page->date_payment->headerCellClass() ?>"><span id="elh_log_test_payment_date_payment" class="log_test_payment_date_payment"><?= $Page->date_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <th class="<?= $Page->due_date->headerCellClass() ?>"><span id="elh_log_test_payment_due_date" class="log_test_payment_due_date"><?= $Page->due_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th class="<?= $Page->booking_price->headerCellClass() ?>"><span id="elh_log_test_payment_booking_price" class="log_test_payment_booking_price"><?= $Page->booking_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th class="<?= $Page->pay_number->headerCellClass() ?>"><span id="elh_log_test_payment_pay_number" class="log_test_payment_pay_number"><?= $Page->pay_number->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th class="<?= $Page->status_payment->headerCellClass() ?>"><span id="elh_log_test_payment_status_payment" class="log_test_payment_status_payment"><?= $Page->status_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
        <th class="<?= $Page->transaction_datetime->headerCellClass() ?>"><span id="elh_log_test_payment_transaction_datetime" class="log_test_payment_transaction_datetime"><?= $Page->transaction_datetime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
        <th class="<?= $Page->payment_scheme->headerCellClass() ?>"><span id="elh_log_test_payment_payment_scheme" class="log_test_payment_payment_scheme"><?= $Page->payment_scheme->caption() ?></span></th>
<?php } ?>
<?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
        <th class="<?= $Page->transaction_ref->headerCellClass() ?>"><span id="elh_log_test_payment_transaction_ref" class="log_test_payment_transaction_ref"><?= $Page->transaction_ref->caption() ?></span></th>
<?php } ?>
<?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
        <th class="<?= $Page->channel_response_desc->headerCellClass() ?>"><span id="elh_log_test_payment_channel_response_desc" class="log_test_payment_channel_response_desc"><?= $Page->channel_response_desc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->res_status->Visible) { // res_status ?>
        <th class="<?= $Page->res_status->headerCellClass() ?>"><span id="elh_log_test_payment_res_status" class="log_test_payment_res_status"><?= $Page->res_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
        <th class="<?= $Page->res_referenceNo->headerCellClass() ?>"><span id="elh_log_test_payment_res_referenceNo" class="log_test_payment_res_referenceNo"><?= $Page->res_referenceNo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
        <th class="<?= $Page->res_paidAgent->headerCellClass() ?>"><span id="elh_log_test_payment_res_paidAgent" class="log_test_payment_res_paidAgent"><?= $Page->res_paidAgent->caption() ?></span></th>
<?php } ?>
<?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
        <th class="<?= $Page->res_paidChannel->headerCellClass() ?>"><span id="elh_log_test_payment_res_paidChannel" class="log_test_payment_res_paidChannel"><?= $Page->res_paidChannel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
        <th class="<?= $Page->res_maskedPan->headerCellClass() ?>"><span id="elh_log_test_payment_res_maskedPan" class="log_test_payment_res_maskedPan"><?= $Page->res_maskedPan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th class="<?= $Page->status_expire->headerCellClass() ?>"><span id="elh_log_test_payment_status_expire" class="log_test_payment_status_expire"><?= $Page->status_expire->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th class="<?= $Page->status_expire_reason->headerCellClass() ?>"><span id="elh_log_test_payment_status_expire_reason" class="log_test_payment_status_expire_reason"><?= $Page->status_expire_reason->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_log_test_payment_cdate" class="log_test_payment_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_log_test_payment_cuser" class="log_test_payment_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_log_test_payment_cip" class="log_test_payment_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_log_test_payment_udate" class="log_test_payment_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_log_test_payment_uuser" class="log_test_payment_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_log_test_payment_uip" class="log_test_payment_uip"><?= $Page->uip->caption() ?></span></th>
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
<?php if ($Page->log_test_payment_id->Visible) { // log_test_payment_id ?>
        <td<?= $Page->log_test_payment_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_log_test_payment_id" class="el_log_test_payment_log_test_payment_id">
<span<?= $Page->log_test_payment_id->viewAttributes() ?>>
<?= $Page->log_test_payment_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <td<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_member_id" class="el_log_test_payment_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_asset_id" class="el_log_test_payment_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_type" class="el_log_test_payment_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_date_booking" class="el_log_test_payment_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_date_payment" class="el_log_test_payment_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <td<?= $Page->due_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_due_date" class="el_log_test_payment_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_booking_price" class="el_log_test_payment_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_pay_number" class="el_log_test_payment_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_status_payment" class="el_log_test_payment_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
        <td<?= $Page->transaction_datetime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_transaction_datetime" class="el_log_test_payment_transaction_datetime">
<span<?= $Page->transaction_datetime->viewAttributes() ?>>
<?= $Page->transaction_datetime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
        <td<?= $Page->payment_scheme->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_payment_scheme" class="el_log_test_payment_payment_scheme">
<span<?= $Page->payment_scheme->viewAttributes() ?>>
<?= $Page->payment_scheme->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
        <td<?= $Page->transaction_ref->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_transaction_ref" class="el_log_test_payment_transaction_ref">
<span<?= $Page->transaction_ref->viewAttributes() ?>>
<?= $Page->transaction_ref->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
        <td<?= $Page->channel_response_desc->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_channel_response_desc" class="el_log_test_payment_channel_response_desc">
<span<?= $Page->channel_response_desc->viewAttributes() ?>>
<?= $Page->channel_response_desc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->res_status->Visible) { // res_status ?>
        <td<?= $Page->res_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_status" class="el_log_test_payment_res_status">
<span<?= $Page->res_status->viewAttributes() ?>>
<?= $Page->res_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
        <td<?= $Page->res_referenceNo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_referenceNo" class="el_log_test_payment_res_referenceNo">
<span<?= $Page->res_referenceNo->viewAttributes() ?>>
<?= $Page->res_referenceNo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
        <td<?= $Page->res_paidAgent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_paidAgent" class="el_log_test_payment_res_paidAgent">
<span<?= $Page->res_paidAgent->viewAttributes() ?>>
<?= $Page->res_paidAgent->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
        <td<?= $Page->res_paidChannel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_paidChannel" class="el_log_test_payment_res_paidChannel">
<span<?= $Page->res_paidChannel->viewAttributes() ?>>
<?= $Page->res_paidChannel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
        <td<?= $Page->res_maskedPan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_maskedPan" class="el_log_test_payment_res_maskedPan">
<span<?= $Page->res_maskedPan->viewAttributes() ?>>
<?= $Page->res_maskedPan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_status_expire" class="el_log_test_payment_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_status_expire_reason" class="el_log_test_payment_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_cdate" class="el_log_test_payment_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_cuser" class="el_log_test_payment_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_cip" class="el_log_test_payment_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_udate" class="el_log_test_payment_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_uuser" class="el_log_test_payment_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_uip" class="el_log_test_payment_uip">
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
