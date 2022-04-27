<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogTestPaymentView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_test_payment: currentTable } });
var currentForm, currentPageID;
var flog_test_paymentview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_test_paymentview = new ew.Form("flog_test_paymentview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = flog_test_paymentview;
    loadjs.done("flog_test_paymentview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="flog_test_paymentview" id="flog_test_paymentview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_test_payment">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->log_test_payment_id->Visible) { // log_test_payment_id ?>
    <tr id="r_log_test_payment_id"<?= $Page->log_test_payment_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_log_test_payment_id"><?= $Page->log_test_payment_id->caption() ?></span></td>
        <td data-name="log_test_payment_id"<?= $Page->log_test_payment_id->cellAttributes() ?>>
<span id="el_log_test_payment_log_test_payment_id">
<span<?= $Page->log_test_payment_id->viewAttributes() ?>>
<?= $Page->log_test_payment_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_log_test_payment_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_log_test_payment_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type"<?= $Page->type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<span id="el_log_test_payment_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <tr id="r_date_booking"<?= $Page->date_booking->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_date_booking"><?= $Page->date_booking->caption() ?></span></td>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el_log_test_payment_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <tr id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_date_payment"><?= $Page->date_payment->caption() ?></span></td>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_log_test_payment_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <tr id="r_due_date"<?= $Page->due_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_due_date"><?= $Page->due_date->caption() ?></span></td>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el_log_test_payment_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <tr id="r_booking_price"<?= $Page->booking_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_booking_price"><?= $Page->booking_price->caption() ?></span></td>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el_log_test_payment_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <tr id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_pay_number"><?= $Page->pay_number->caption() ?></span></td>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_log_test_payment_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <tr id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_status_payment"><?= $Page->status_payment->caption() ?></span></td>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_log_test_payment_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
    <tr id="r_transaction_datetime"<?= $Page->transaction_datetime->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_transaction_datetime"><?= $Page->transaction_datetime->caption() ?></span></td>
        <td data-name="transaction_datetime"<?= $Page->transaction_datetime->cellAttributes() ?>>
<span id="el_log_test_payment_transaction_datetime">
<span<?= $Page->transaction_datetime->viewAttributes() ?>>
<?= $Page->transaction_datetime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
    <tr id="r_payment_scheme"<?= $Page->payment_scheme->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_payment_scheme"><?= $Page->payment_scheme->caption() ?></span></td>
        <td data-name="payment_scheme"<?= $Page->payment_scheme->cellAttributes() ?>>
<span id="el_log_test_payment_payment_scheme">
<span<?= $Page->payment_scheme->viewAttributes() ?>>
<?= $Page->payment_scheme->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
    <tr id="r_transaction_ref"<?= $Page->transaction_ref->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_transaction_ref"><?= $Page->transaction_ref->caption() ?></span></td>
        <td data-name="transaction_ref"<?= $Page->transaction_ref->cellAttributes() ?>>
<span id="el_log_test_payment_transaction_ref">
<span<?= $Page->transaction_ref->viewAttributes() ?>>
<?= $Page->transaction_ref->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
    <tr id="r_channel_response_desc"<?= $Page->channel_response_desc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_channel_response_desc"><?= $Page->channel_response_desc->caption() ?></span></td>
        <td data-name="channel_response_desc"<?= $Page->channel_response_desc->cellAttributes() ?>>
<span id="el_log_test_payment_channel_response_desc">
<span<?= $Page->channel_response_desc->viewAttributes() ?>>
<?= $Page->channel_response_desc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->res_status->Visible) { // res_status ?>
    <tr id="r_res_status"<?= $Page->res_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_res_status"><?= $Page->res_status->caption() ?></span></td>
        <td data-name="res_status"<?= $Page->res_status->cellAttributes() ?>>
<span id="el_log_test_payment_res_status">
<span<?= $Page->res_status->viewAttributes() ?>>
<?= $Page->res_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
    <tr id="r_res_referenceNo"<?= $Page->res_referenceNo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_res_referenceNo"><?= $Page->res_referenceNo->caption() ?></span></td>
        <td data-name="res_referenceNo"<?= $Page->res_referenceNo->cellAttributes() ?>>
<span id="el_log_test_payment_res_referenceNo">
<span<?= $Page->res_referenceNo->viewAttributes() ?>>
<?= $Page->res_referenceNo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
    <tr id="r_res_paidAgent"<?= $Page->res_paidAgent->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_res_paidAgent"><?= $Page->res_paidAgent->caption() ?></span></td>
        <td data-name="res_paidAgent"<?= $Page->res_paidAgent->cellAttributes() ?>>
<span id="el_log_test_payment_res_paidAgent">
<span<?= $Page->res_paidAgent->viewAttributes() ?>>
<?= $Page->res_paidAgent->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
    <tr id="r_res_paidChannel"<?= $Page->res_paidChannel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_res_paidChannel"><?= $Page->res_paidChannel->caption() ?></span></td>
        <td data-name="res_paidChannel"<?= $Page->res_paidChannel->cellAttributes() ?>>
<span id="el_log_test_payment_res_paidChannel">
<span<?= $Page->res_paidChannel->viewAttributes() ?>>
<?= $Page->res_paidChannel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
    <tr id="r_res_maskedPan"<?= $Page->res_maskedPan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_res_maskedPan"><?= $Page->res_maskedPan->caption() ?></span></td>
        <td data-name="res_maskedPan"<?= $Page->res_maskedPan->cellAttributes() ?>>
<span id="el_log_test_payment_res_maskedPan">
<span<?= $Page->res_maskedPan->viewAttributes() ?>>
<?= $Page->res_maskedPan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <tr id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_status_expire"><?= $Page->status_expire->caption() ?></span></td>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_log_test_payment_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
    <tr id="r_status_expire_reason"<?= $Page->status_expire_reason->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_status_expire_reason"><?= $Page->status_expire_reason->caption() ?></span></td>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_log_test_payment_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_log_test_payment_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_log_test_payment_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_log_test_payment_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <tr id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_udate"><?= $Page->udate->caption() ?></span></td>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el_log_test_payment_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <tr id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_uuser"><?= $Page->uuser->caption() ?></span></td>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el_log_test_payment_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <tr id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_test_payment_uip"><?= $Page->uip->caption() ?></span></td>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el_log_test_payment_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
