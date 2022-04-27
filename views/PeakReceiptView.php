<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt: currentTable } });
var currentForm, currentPageID;
var fpeak_receiptview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receiptview = new ew.Form("fpeak_receiptview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpeak_receiptview;
    loadjs.done("fpeak_receiptview");
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
<form name="fpeak_receiptview" id="fpeak_receiptview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_receipt_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
    <tr id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_create_date"><?= $Page->create_date->caption() ?></span></td>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el_peak_receipt_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
    <tr id="r_request_status"<?= $Page->request_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_request_status"><?= $Page->request_status->caption() ?></span></td>
        <td data-name="request_status"<?= $Page->request_status->cellAttributes() ?>>
<span id="el_peak_receipt_request_status">
<span<?= $Page->request_status->viewAttributes() ?>>
<?= $Page->request_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
    <tr id="r_request_date"<?= $Page->request_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_request_date"><?= $Page->request_date->caption() ?></span></td>
        <td data-name="request_date"<?= $Page->request_date->cellAttributes() ?>>
<span id="el_peak_receipt_request_date">
<span<?= $Page->request_date->viewAttributes() ?>>
<?= $Page->request_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_message->Visible) { // request_message ?>
    <tr id="r_request_message"<?= $Page->request_message->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_request_message"><?= $Page->request_message->caption() ?></span></td>
        <td data-name="request_message"<?= $Page->request_message->cellAttributes() ?>>
<span id="el_peak_receipt_request_message">
<span<?= $Page->request_message->viewAttributes() ?>>
<?= $Page->request_message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->issueddate->Visible) { // issueddate ?>
    <tr id="r_issueddate"<?= $Page->issueddate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_issueddate"><?= $Page->issueddate->caption() ?></span></td>
        <td data-name="issueddate"<?= $Page->issueddate->cellAttributes() ?>>
<span id="el_peak_receipt_issueddate">
<span<?= $Page->issueddate->viewAttributes() ?>>
<?= $Page->issueddate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->duedate->Visible) { // duedate ?>
    <tr id="r_duedate"<?= $Page->duedate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_duedate"><?= $Page->duedate->caption() ?></span></td>
        <td data-name="duedate"<?= $Page->duedate->cellAttributes() ?>>
<span id="el_peak_receipt_duedate">
<span<?= $Page->duedate->viewAttributes() ?>>
<?= $Page->duedate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contactcode->Visible) { // contactcode ?>
    <tr id="r_contactcode"<?= $Page->contactcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_contactcode"><?= $Page->contactcode->caption() ?></span></td>
        <td data-name="contactcode"<?= $Page->contactcode->cellAttributes() ?>>
<span id="el_peak_receipt_contactcode">
<span<?= $Page->contactcode->viewAttributes() ?>>
<?= $Page->contactcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
    <tr id="r_tag"<?= $Page->tag->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_tag"><?= $Page->tag->caption() ?></span></td>
        <td data-name="tag"<?= $Page->tag->cellAttributes() ?>>
<span id="el_peak_receipt_tag">
<span<?= $Page->tag->viewAttributes() ?>>
<?= $Page->tag->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->istaxinvoice->Visible) { // istaxinvoice ?>
    <tr id="r_istaxinvoice"<?= $Page->istaxinvoice->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_istaxinvoice"><?= $Page->istaxinvoice->caption() ?></span></td>
        <td data-name="istaxinvoice"<?= $Page->istaxinvoice->cellAttributes() ?>>
<span id="el_peak_receipt_istaxinvoice">
<span<?= $Page->istaxinvoice->viewAttributes() ?>>
<?= $Page->istaxinvoice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->taxstatus->Visible) { // taxstatus ?>
    <tr id="r_taxstatus"<?= $Page->taxstatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_taxstatus"><?= $Page->taxstatus->caption() ?></span></td>
        <td data-name="taxstatus"<?= $Page->taxstatus->cellAttributes() ?>>
<span id="el_peak_receipt_taxstatus">
<span<?= $Page->taxstatus->viewAttributes() ?>>
<?= $Page->taxstatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentdate->Visible) { // paymentdate ?>
    <tr id="r_paymentdate"<?= $Page->paymentdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_paymentdate"><?= $Page->paymentdate->caption() ?></span></td>
        <td data-name="paymentdate"<?= $Page->paymentdate->cellAttributes() ?>>
<span id="el_peak_receipt_paymentdate">
<span<?= $Page->paymentdate->viewAttributes() ?>>
<?= $Page->paymentdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentmethodid->Visible) { // paymentmethodid ?>
    <tr id="r_paymentmethodid"<?= $Page->paymentmethodid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_paymentmethodid"><?= $Page->paymentmethodid->caption() ?></span></td>
        <td data-name="paymentmethodid"<?= $Page->paymentmethodid->cellAttributes() ?>>
<span id="el_peak_receipt_paymentmethodid">
<span<?= $Page->paymentmethodid->viewAttributes() ?>>
<?= $Page->paymentmethodid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
    <tr id="r_paymentMethodCode"<?= $Page->paymentMethodCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_paymentMethodCode"><?= $Page->paymentMethodCode->caption() ?></span></td>
        <td data-name="paymentMethodCode"<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el_peak_receipt_paymentMethodCode">
<span<?= $Page->paymentMethodCode->viewAttributes() ?>>
<?= $Page->paymentMethodCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <tr id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_amount"><?= $Page->amount->caption() ?></span></td>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el_peak_receipt_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remark->Visible) { // remark ?>
    <tr id="r_remark"<?= $Page->remark->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_remark"><?= $Page->remark->caption() ?></span></td>
        <td data-name="remark"<?= $Page->remark->cellAttributes() ?>>
<span id="el_peak_receipt_remark">
<span<?= $Page->remark->viewAttributes() ?>>
<?= $Page->remark->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt_id->Visible) { // receipt_id ?>
    <tr id="r_receipt_id"<?= $Page->receipt_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_receipt_id"><?= $Page->receipt_id->caption() ?></span></td>
        <td data-name="receipt_id"<?= $Page->receipt_id->cellAttributes() ?>>
<span id="el_peak_receipt_receipt_id">
<span<?= $Page->receipt_id->viewAttributes() ?>>
<?= $Page->receipt_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt_code->Visible) { // receipt_code ?>
    <tr id="r_receipt_code"<?= $Page->receipt_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_receipt_code"><?= $Page->receipt_code->caption() ?></span></td>
        <td data-name="receipt_code"<?= $Page->receipt_code->cellAttributes() ?>>
<span id="el_peak_receipt_receipt_code">
<span<?= $Page->receipt_code->viewAttributes() ?>>
<?= $Page->receipt_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
    <tr id="r_receipt_status"<?= $Page->receipt_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_receipt_status"><?= $Page->receipt_status->caption() ?></span></td>
        <td data-name="receipt_status"<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el_peak_receipt_receipt_status">
<span<?= $Page->receipt_status->viewAttributes() ?>>
<?= $Page->receipt_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
    <tr id="r_preTaxAmount"<?= $Page->preTaxAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_preTaxAmount"><?= $Page->preTaxAmount->caption() ?></span></td>
        <td data-name="preTaxAmount"<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el_peak_receipt_preTaxAmount">
<span<?= $Page->preTaxAmount->viewAttributes() ?>>
<?= $Page->preTaxAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
    <tr id="r_vatAmount"<?= $Page->vatAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_vatAmount"><?= $Page->vatAmount->caption() ?></span></td>
        <td data-name="vatAmount"<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el_peak_receipt_vatAmount">
<span<?= $Page->vatAmount->viewAttributes() ?>>
<?= $Page->vatAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
    <tr id="r_netAmount"<?= $Page->netAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_netAmount"><?= $Page->netAmount->caption() ?></span></td>
        <td data-name="netAmount"<?= $Page->netAmount->cellAttributes() ?>>
<span id="el_peak_receipt_netAmount">
<span<?= $Page->netAmount->viewAttributes() ?>>
<?= $Page->netAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
    <tr id="r_whtAmount"<?= $Page->whtAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_whtAmount"><?= $Page->whtAmount->caption() ?></span></td>
        <td data-name="whtAmount"<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el_peak_receipt_whtAmount">
<span<?= $Page->whtAmount->viewAttributes() ?>>
<?= $Page->whtAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
    <tr id="r_paymentAmount"<?= $Page->paymentAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_paymentAmount"><?= $Page->paymentAmount->caption() ?></span></td>
        <td data-name="paymentAmount"<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el_peak_receipt_paymentAmount">
<span<?= $Page->paymentAmount->viewAttributes() ?>>
<?= $Page->paymentAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
    <tr id="r_remainAmount"<?= $Page->remainAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_remainAmount"><?= $Page->remainAmount->caption() ?></span></td>
        <td data-name="remainAmount"<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el_peak_receipt_remainAmount">
<span<?= $Page->remainAmount->viewAttributes() ?>>
<?= $Page->remainAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remainWhtAmount->Visible) { // remainWhtAmount ?>
    <tr id="r_remainWhtAmount"<?= $Page->remainWhtAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_remainWhtAmount"><?= $Page->remainWhtAmount->caption() ?></span></td>
        <td data-name="remainWhtAmount"<?= $Page->remainWhtAmount->cellAttributes() ?>>
<span id="el_peak_receipt_remainWhtAmount">
<span<?= $Page->remainWhtAmount->viewAttributes() ?>>
<?= $Page->remainWhtAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->onlineViewLink->Visible) { // onlineViewLink ?>
    <tr id="r_onlineViewLink"<?= $Page->onlineViewLink->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_onlineViewLink"><?= $Page->onlineViewLink->caption() ?></span></td>
        <td data-name="onlineViewLink"<?= $Page->onlineViewLink->cellAttributes() ?>>
<span id="el_peak_receipt_onlineViewLink">
<span<?= $Page->onlineViewLink->viewAttributes() ?>>
<?= $Page->onlineViewLink->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isPartialReceipt->Visible) { // isPartialReceipt ?>
    <tr id="r_isPartialReceipt"<?= $Page->isPartialReceipt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_isPartialReceipt"><?= $Page->isPartialReceipt->caption() ?></span></td>
        <td data-name="isPartialReceipt"<?= $Page->isPartialReceipt->cellAttributes() ?>>
<span id="el_peak_receipt_isPartialReceipt">
<span<?= $Page->isPartialReceipt->viewAttributes() ?>>
<?= $Page->isPartialReceipt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
    <tr id="r_journals_id"<?= $Page->journals_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_journals_id"><?= $Page->journals_id->caption() ?></span></td>
        <td data-name="journals_id"<?= $Page->journals_id->cellAttributes() ?>>
<span id="el_peak_receipt_journals_id">
<span<?= $Page->journals_id->viewAttributes() ?>>
<?= $Page->journals_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
    <tr id="r_journals_code"<?= $Page->journals_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_journals_code"><?= $Page->journals_code->caption() ?></span></td>
        <td data-name="journals_code"<?= $Page->journals_code->cellAttributes() ?>>
<span id="el_peak_receipt_journals_code">
<span<?= $Page->journals_code->viewAttributes() ?>>
<?= $Page->journals_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
    <tr id="r_refid"<?= $Page->refid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_refid"><?= $Page->refid->caption() ?></span></td>
        <td data-name="refid"<?= $Page->refid->cellAttributes() ?>>
<span id="el_peak_receipt_refid">
<span<?= $Page->refid->viewAttributes() ?>>
<?= $Page->refid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transition_type->Visible) { // transition_type ?>
    <tr id="r_transition_type"<?= $Page->transition_type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_transition_type"><?= $Page->transition_type->caption() ?></span></td>
        <td data-name="transition_type"<?= $Page->transition_type->cellAttributes() ?>>
<span id="el_peak_receipt_transition_type">
<span<?= $Page->transition_type->viewAttributes() ?>>
<?= $Page->transition_type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
    <tr id="r_is_email"<?= $Page->is_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_is_email"><?= $Page->is_email->caption() ?></span></td>
        <td data-name="is_email"<?= $Page->is_email->cellAttributes() ?>>
<span id="el_peak_receipt_is_email">
<span<?= $Page->is_email->viewAttributes() ?>>
<?= $Page->is_email->getViewValue() ?></span>
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
