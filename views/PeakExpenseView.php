<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense: currentTable } });
var currentForm, currentPageID;
var fpeak_expenseview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expenseview = new ew.Form("fpeak_expenseview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpeak_expenseview;
    loadjs.done("fpeak_expenseview");
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
<form name="fpeak_expenseview" id="fpeak_expenseview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
    <tr id="r_peak_expense_id"<?= $Page->peak_expense_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_peak_expense_id"><?= $Page->peak_expense_id->caption() ?></span></td>
        <td data-name="peak_expense_id"<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el_peak_expense_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<?= $Page->peak_expense_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code"<?= $Page->code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code"<?= $Page->code->cellAttributes() ?>>
<span id="el_peak_expense_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->issuedDate->Visible) { // issuedDate ?>
    <tr id="r_issuedDate"<?= $Page->issuedDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_issuedDate"><?= $Page->issuedDate->caption() ?></span></td>
        <td data-name="issuedDate"<?= $Page->issuedDate->cellAttributes() ?>>
<span id="el_peak_expense_issuedDate">
<span<?= $Page->issuedDate->viewAttributes() ?>>
<?= $Page->issuedDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
    <tr id="r_dueDate"<?= $Page->dueDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_dueDate"><?= $Page->dueDate->caption() ?></span></td>
        <td data-name="dueDate"<?= $Page->dueDate->cellAttributes() ?>>
<span id="el_peak_expense_dueDate">
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contactId->Visible) { // contactId ?>
    <tr id="r_contactId"<?= $Page->contactId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_contactId"><?= $Page->contactId->caption() ?></span></td>
        <td data-name="contactId"<?= $Page->contactId->cellAttributes() ?>>
<span id="el_peak_expense_contactId">
<span<?= $Page->contactId->viewAttributes() ?>>
<?= $Page->contactId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contactCode->Visible) { // contactCode ?>
    <tr id="r_contactCode"<?= $Page->contactCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_contactCode"><?= $Page->contactCode->caption() ?></span></td>
        <td data-name="contactCode"<?= $Page->contactCode->cellAttributes() ?>>
<span id="el_peak_expense_contactCode">
<span<?= $Page->contactCode->viewAttributes() ?>>
<?= $Page->contactCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_peak_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isTaxInvoice->Visible) { // isTaxInvoice ?>
    <tr id="r_isTaxInvoice"<?= $Page->isTaxInvoice->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_isTaxInvoice"><?= $Page->isTaxInvoice->caption() ?></span></td>
        <td data-name="isTaxInvoice"<?= $Page->isTaxInvoice->cellAttributes() ?>>
<span id="el_peak_expense_isTaxInvoice">
<span<?= $Page->isTaxInvoice->viewAttributes() ?>>
<?= $Page->isTaxInvoice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
    <tr id="r_preTaxAmount"<?= $Page->preTaxAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_preTaxAmount"><?= $Page->preTaxAmount->caption() ?></span></td>
        <td data-name="preTaxAmount"<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el_peak_expense_preTaxAmount">
<span<?= $Page->preTaxAmount->viewAttributes() ?>>
<?= $Page->preTaxAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
    <tr id="r_vatAmount"<?= $Page->vatAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_vatAmount"><?= $Page->vatAmount->caption() ?></span></td>
        <td data-name="vatAmount"<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el_peak_expense_vatAmount">
<span<?= $Page->vatAmount->viewAttributes() ?>>
<?= $Page->vatAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
    <tr id="r_netAmount"<?= $Page->netAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_netAmount"><?= $Page->netAmount->caption() ?></span></td>
        <td data-name="netAmount"<?= $Page->netAmount->cellAttributes() ?>>
<span id="el_peak_expense_netAmount">
<span<?= $Page->netAmount->viewAttributes() ?>>
<?= $Page->netAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
    <tr id="r_whtAmount"<?= $Page->whtAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_whtAmount"><?= $Page->whtAmount->caption() ?></span></td>
        <td data-name="whtAmount"<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el_peak_expense_whtAmount">
<span<?= $Page->whtAmount->viewAttributes() ?>>
<?= $Page->whtAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
    <tr id="r_paymentAmount"<?= $Page->paymentAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_paymentAmount"><?= $Page->paymentAmount->caption() ?></span></td>
        <td data-name="paymentAmount"<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el_peak_expense_paymentAmount">
<span<?= $Page->paymentAmount->viewAttributes() ?>>
<?= $Page->paymentAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
    <tr id="r_remainAmount"<?= $Page->remainAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_remainAmount"><?= $Page->remainAmount->caption() ?></span></td>
        <td data-name="remainAmount"<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el_peak_expense_remainAmount">
<span<?= $Page->remainAmount->viewAttributes() ?>>
<?= $Page->remainAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->onlineViewLink->Visible) { // onlineViewLink ?>
    <tr id="r_onlineViewLink"<?= $Page->onlineViewLink->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_onlineViewLink"><?= $Page->onlineViewLink->caption() ?></span></td>
        <td data-name="onlineViewLink"<?= $Page->onlineViewLink->cellAttributes() ?>>
<span id="el_peak_expense_onlineViewLink">
<span<?= $Page->onlineViewLink->viewAttributes() ?>>
<?= $Page->onlineViewLink->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->taxStatus->Visible) { // taxStatus ?>
    <tr id="r_taxStatus"<?= $Page->taxStatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_taxStatus"><?= $Page->taxStatus->caption() ?></span></td>
        <td data-name="taxStatus"<?= $Page->taxStatus->cellAttributes() ?>>
<span id="el_peak_expense_taxStatus">
<span<?= $Page->taxStatus->viewAttributes() ?>>
<?= $Page->taxStatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
    <tr id="r_paymentDate"<?= $Page->paymentDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_paymentDate"><?= $Page->paymentDate->caption() ?></span></td>
        <td data-name="paymentDate"<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el_peak_expense_paymentDate">
<span<?= $Page->paymentDate->viewAttributes() ?>>
<?= $Page->paymentDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
    <tr id="r_withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_withHoldingTaxAmount"><?= $Page->withHoldingTaxAmount->caption() ?></span></td>
        <td data-name="withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el_peak_expense_withHoldingTaxAmount">
<span<?= $Page->withHoldingTaxAmount->viewAttributes() ?>>
<?= $Page->withHoldingTaxAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentGroupId->Visible) { // paymentGroupId ?>
    <tr id="r_paymentGroupId"<?= $Page->paymentGroupId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_paymentGroupId"><?= $Page->paymentGroupId->caption() ?></span></td>
        <td data-name="paymentGroupId"<?= $Page->paymentGroupId->cellAttributes() ?>>
<span id="el_peak_expense_paymentGroupId">
<span<?= $Page->paymentGroupId->viewAttributes() ?>>
<?= $Page->paymentGroupId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentTotal->Visible) { // paymentTotal ?>
    <tr id="r_paymentTotal"<?= $Page->paymentTotal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_paymentTotal"><?= $Page->paymentTotal->caption() ?></span></td>
        <td data-name="paymentTotal"<?= $Page->paymentTotal->cellAttributes() ?>>
<span id="el_peak_expense_paymentTotal">
<span<?= $Page->paymentTotal->viewAttributes() ?>>
<?= $Page->paymentTotal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentMethodId->Visible) { // paymentMethodId ?>
    <tr id="r_paymentMethodId"<?= $Page->paymentMethodId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_paymentMethodId"><?= $Page->paymentMethodId->caption() ?></span></td>
        <td data-name="paymentMethodId"<?= $Page->paymentMethodId->cellAttributes() ?>>
<span id="el_peak_expense_paymentMethodId">
<span<?= $Page->paymentMethodId->viewAttributes() ?>>
<?= $Page->paymentMethodId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
    <tr id="r_paymentMethodCode"<?= $Page->paymentMethodCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_paymentMethodCode"><?= $Page->paymentMethodCode->caption() ?></span></td>
        <td data-name="paymentMethodCode"<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el_peak_expense_paymentMethodCode">
<span<?= $Page->paymentMethodCode->viewAttributes() ?>>
<?= $Page->paymentMethodCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <tr id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_amount"><?= $Page->amount->caption() ?></span></td>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el_peak_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
    <tr id="r_journals_id"<?= $Page->journals_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_journals_id"><?= $Page->journals_id->caption() ?></span></td>
        <td data-name="journals_id"<?= $Page->journals_id->cellAttributes() ?>>
<span id="el_peak_expense_journals_id">
<span<?= $Page->journals_id->viewAttributes() ?>>
<?= $Page->journals_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
    <tr id="r_journals_code"<?= $Page->journals_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_journals_code"><?= $Page->journals_code->caption() ?></span></td>
        <td data-name="journals_code"<?= $Page->journals_code->cellAttributes() ?>>
<span id="el_peak_expense_journals_code">
<span<?= $Page->journals_code->viewAttributes() ?>>
<?= $Page->journals_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_peak_expense_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_peak_expense_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_peak_expense_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <tr id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_udate"><?= $Page->udate->caption() ?></span></td>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el_peak_expense_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <tr id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_uuser"><?= $Page->uuser->caption() ?></span></td>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el_peak_expense_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <tr id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_uip"><?= $Page->uip->caption() ?></span></td>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el_peak_expense_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sync_detail_date->Visible) { // sync_detail_date ?>
    <tr id="r_sync_detail_date"<?= $Page->sync_detail_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_sync_detail_date"><?= $Page->sync_detail_date->caption() ?></span></td>
        <td data-name="sync_detail_date"<?= $Page->sync_detail_date->cellAttributes() ?>>
<span id="el_peak_expense_sync_detail_date">
<span<?= $Page->sync_detail_date->viewAttributes() ?>>
<?= $Page->sync_detail_date->getViewValue() ?></span>
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
