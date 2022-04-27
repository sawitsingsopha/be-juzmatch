<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt: currentTable } });
var currentForm, currentPageID;
var fpeak_receiptdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receiptdelete = new ew.Form("fpeak_receiptdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpeak_receiptdelete;
    loadjs.done("fpeak_receiptdelete");
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
<form name="fpeak_receiptdelete" id="fpeak_receiptdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_peak_receipt_id" class="peak_receipt_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th class="<?= $Page->create_date->headerCellClass() ?>"><span id="elh_peak_receipt_create_date" class="peak_receipt_create_date"><?= $Page->create_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
        <th class="<?= $Page->request_status->headerCellClass() ?>"><span id="elh_peak_receipt_request_status" class="peak_receipt_request_status"><?= $Page->request_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
        <th class="<?= $Page->request_date->headerCellClass() ?>"><span id="elh_peak_receipt_request_date" class="peak_receipt_request_date"><?= $Page->request_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->issueddate->Visible) { // issueddate ?>
        <th class="<?= $Page->issueddate->headerCellClass() ?>"><span id="elh_peak_receipt_issueddate" class="peak_receipt_issueddate"><?= $Page->issueddate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->duedate->Visible) { // duedate ?>
        <th class="<?= $Page->duedate->headerCellClass() ?>"><span id="elh_peak_receipt_duedate" class="peak_receipt_duedate"><?= $Page->duedate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contactcode->Visible) { // contactcode ?>
        <th class="<?= $Page->contactcode->headerCellClass() ?>"><span id="elh_peak_receipt_contactcode" class="peak_receipt_contactcode"><?= $Page->contactcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->istaxinvoice->Visible) { // istaxinvoice ?>
        <th class="<?= $Page->istaxinvoice->headerCellClass() ?>"><span id="elh_peak_receipt_istaxinvoice" class="peak_receipt_istaxinvoice"><?= $Page->istaxinvoice->caption() ?></span></th>
<?php } ?>
<?php if ($Page->taxstatus->Visible) { // taxstatus ?>
        <th class="<?= $Page->taxstatus->headerCellClass() ?>"><span id="elh_peak_receipt_taxstatus" class="peak_receipt_taxstatus"><?= $Page->taxstatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentdate->Visible) { // paymentdate ?>
        <th class="<?= $Page->paymentdate->headerCellClass() ?>"><span id="elh_peak_receipt_paymentdate" class="peak_receipt_paymentdate"><?= $Page->paymentdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentmethodid->Visible) { // paymentmethodid ?>
        <th class="<?= $Page->paymentmethodid->headerCellClass() ?>"><span id="elh_peak_receipt_paymentmethodid" class="peak_receipt_paymentmethodid"><?= $Page->paymentmethodid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <th class="<?= $Page->paymentMethodCode->headerCellClass() ?>"><span id="elh_peak_receipt_paymentMethodCode" class="peak_receipt_paymentMethodCode"><?= $Page->paymentMethodCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><span id="elh_peak_receipt_amount" class="peak_receipt_amount"><?= $Page->amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->remark->Visible) { // remark ?>
        <th class="<?= $Page->remark->headerCellClass() ?>"><span id="elh_peak_receipt_remark" class="peak_receipt_remark"><?= $Page->remark->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt_id->Visible) { // receipt_id ?>
        <th class="<?= $Page->receipt_id->headerCellClass() ?>"><span id="elh_peak_receipt_receipt_id" class="peak_receipt_receipt_id"><?= $Page->receipt_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt_code->Visible) { // receipt_code ?>
        <th class="<?= $Page->receipt_code->headerCellClass() ?>"><span id="elh_peak_receipt_receipt_code" class="peak_receipt_receipt_code"><?= $Page->receipt_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <th class="<?= $Page->receipt_status->headerCellClass() ?>"><span id="elh_peak_receipt_receipt_status" class="peak_receipt_receipt_status"><?= $Page->receipt_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <th class="<?= $Page->preTaxAmount->headerCellClass() ?>"><span id="elh_peak_receipt_preTaxAmount" class="peak_receipt_preTaxAmount"><?= $Page->preTaxAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <th class="<?= $Page->vatAmount->headerCellClass() ?>"><span id="elh_peak_receipt_vatAmount" class="peak_receipt_vatAmount"><?= $Page->vatAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
        <th class="<?= $Page->netAmount->headerCellClass() ?>"><span id="elh_peak_receipt_netAmount" class="peak_receipt_netAmount"><?= $Page->netAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <th class="<?= $Page->whtAmount->headerCellClass() ?>"><span id="elh_peak_receipt_whtAmount" class="peak_receipt_whtAmount"><?= $Page->whtAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <th class="<?= $Page->paymentAmount->headerCellClass() ?>"><span id="elh_peak_receipt_paymentAmount" class="peak_receipt_paymentAmount"><?= $Page->paymentAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <th class="<?= $Page->remainAmount->headerCellClass() ?>"><span id="elh_peak_receipt_remainAmount" class="peak_receipt_remainAmount"><?= $Page->remainAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->remainWhtAmount->Visible) { // remainWhtAmount ?>
        <th class="<?= $Page->remainWhtAmount->headerCellClass() ?>"><span id="elh_peak_receipt_remainWhtAmount" class="peak_receipt_remainWhtAmount"><?= $Page->remainWhtAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isPartialReceipt->Visible) { // isPartialReceipt ?>
        <th class="<?= $Page->isPartialReceipt->headerCellClass() ?>"><span id="elh_peak_receipt_isPartialReceipt" class="peak_receipt_isPartialReceipt"><?= $Page->isPartialReceipt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
        <th class="<?= $Page->journals_id->headerCellClass() ?>"><span id="elh_peak_receipt_journals_id" class="peak_receipt_journals_id"><?= $Page->journals_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
        <th class="<?= $Page->journals_code->headerCellClass() ?>"><span id="elh_peak_receipt_journals_code" class="peak_receipt_journals_code"><?= $Page->journals_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
        <th class="<?= $Page->refid->headerCellClass() ?>"><span id="elh_peak_receipt_refid" class="peak_receipt_refid"><?= $Page->refid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->transition_type->Visible) { // transition_type ?>
        <th class="<?= $Page->transition_type->headerCellClass() ?>"><span id="elh_peak_receipt_transition_type" class="peak_receipt_transition_type"><?= $Page->transition_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <th class="<?= $Page->is_email->headerCellClass() ?>"><span id="elh_peak_receipt_is_email" class="peak_receipt_is_email"><?= $Page->is_email->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_id" class="el_peak_receipt_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <td<?= $Page->create_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_create_date" class="el_peak_receipt_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
        <td<?= $Page->request_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_request_status" class="el_peak_receipt_request_status">
<span<?= $Page->request_status->viewAttributes() ?>>
<?= $Page->request_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
        <td<?= $Page->request_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_request_date" class="el_peak_receipt_request_date">
<span<?= $Page->request_date->viewAttributes() ?>>
<?= $Page->request_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->issueddate->Visible) { // issueddate ?>
        <td<?= $Page->issueddate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_issueddate" class="el_peak_receipt_issueddate">
<span<?= $Page->issueddate->viewAttributes() ?>>
<?= $Page->issueddate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->duedate->Visible) { // duedate ?>
        <td<?= $Page->duedate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_duedate" class="el_peak_receipt_duedate">
<span<?= $Page->duedate->viewAttributes() ?>>
<?= $Page->duedate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contactcode->Visible) { // contactcode ?>
        <td<?= $Page->contactcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_contactcode" class="el_peak_receipt_contactcode">
<span<?= $Page->contactcode->viewAttributes() ?>>
<?= $Page->contactcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->istaxinvoice->Visible) { // istaxinvoice ?>
        <td<?= $Page->istaxinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_istaxinvoice" class="el_peak_receipt_istaxinvoice">
<span<?= $Page->istaxinvoice->viewAttributes() ?>>
<?= $Page->istaxinvoice->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->taxstatus->Visible) { // taxstatus ?>
        <td<?= $Page->taxstatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_taxstatus" class="el_peak_receipt_taxstatus">
<span<?= $Page->taxstatus->viewAttributes() ?>>
<?= $Page->taxstatus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentdate->Visible) { // paymentdate ?>
        <td<?= $Page->paymentdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentdate" class="el_peak_receipt_paymentdate">
<span<?= $Page->paymentdate->viewAttributes() ?>>
<?= $Page->paymentdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentmethodid->Visible) { // paymentmethodid ?>
        <td<?= $Page->paymentmethodid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentmethodid" class="el_peak_receipt_paymentmethodid">
<span<?= $Page->paymentmethodid->viewAttributes() ?>>
<?= $Page->paymentmethodid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <td<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentMethodCode" class="el_peak_receipt_paymentMethodCode">
<span<?= $Page->paymentMethodCode->viewAttributes() ?>>
<?= $Page->paymentMethodCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <td<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_amount" class="el_peak_receipt_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->remark->Visible) { // remark ?>
        <td<?= $Page->remark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_remark" class="el_peak_receipt_remark">
<span<?= $Page->remark->viewAttributes() ?>>
<?= $Page->remark->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt_id->Visible) { // receipt_id ?>
        <td<?= $Page->receipt_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_receipt_id" class="el_peak_receipt_receipt_id">
<span<?= $Page->receipt_id->viewAttributes() ?>>
<?= $Page->receipt_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt_code->Visible) { // receipt_code ?>
        <td<?= $Page->receipt_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_receipt_code" class="el_peak_receipt_receipt_code">
<span<?= $Page->receipt_code->viewAttributes() ?>>
<?= $Page->receipt_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <td<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_receipt_status" class="el_peak_receipt_receipt_status">
<span<?= $Page->receipt_status->viewAttributes() ?>>
<?= $Page->receipt_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <td<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_preTaxAmount" class="el_peak_receipt_preTaxAmount">
<span<?= $Page->preTaxAmount->viewAttributes() ?>>
<?= $Page->preTaxAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <td<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_vatAmount" class="el_peak_receipt_vatAmount">
<span<?= $Page->vatAmount->viewAttributes() ?>>
<?= $Page->vatAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
        <td<?= $Page->netAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_netAmount" class="el_peak_receipt_netAmount">
<span<?= $Page->netAmount->viewAttributes() ?>>
<?= $Page->netAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <td<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_whtAmount" class="el_peak_receipt_whtAmount">
<span<?= $Page->whtAmount->viewAttributes() ?>>
<?= $Page->whtAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <td<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentAmount" class="el_peak_receipt_paymentAmount">
<span<?= $Page->paymentAmount->viewAttributes() ?>>
<?= $Page->paymentAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <td<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_remainAmount" class="el_peak_receipt_remainAmount">
<span<?= $Page->remainAmount->viewAttributes() ?>>
<?= $Page->remainAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->remainWhtAmount->Visible) { // remainWhtAmount ?>
        <td<?= $Page->remainWhtAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_remainWhtAmount" class="el_peak_receipt_remainWhtAmount">
<span<?= $Page->remainWhtAmount->viewAttributes() ?>>
<?= $Page->remainWhtAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isPartialReceipt->Visible) { // isPartialReceipt ?>
        <td<?= $Page->isPartialReceipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_isPartialReceipt" class="el_peak_receipt_isPartialReceipt">
<span<?= $Page->isPartialReceipt->viewAttributes() ?>>
<?= $Page->isPartialReceipt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
        <td<?= $Page->journals_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_journals_id" class="el_peak_receipt_journals_id">
<span<?= $Page->journals_id->viewAttributes() ?>>
<?= $Page->journals_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
        <td<?= $Page->journals_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_journals_code" class="el_peak_receipt_journals_code">
<span<?= $Page->journals_code->viewAttributes() ?>>
<?= $Page->journals_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
        <td<?= $Page->refid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_refid" class="el_peak_receipt_refid">
<span<?= $Page->refid->viewAttributes() ?>>
<?= $Page->refid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->transition_type->Visible) { // transition_type ?>
        <td<?= $Page->transition_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_transition_type" class="el_peak_receipt_transition_type">
<span<?= $Page->transition_type->viewAttributes() ?>>
<?= $Page->transition_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <td<?= $Page->is_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_is_email" class="el_peak_receipt_is_email">
<span<?= $Page->is_email->viewAttributes() ?>>
<?= $Page->is_email->getViewValue() ?></span>
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
