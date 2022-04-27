<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense: currentTable } });
var currentForm, currentPageID;
var fpeak_expensedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expensedelete = new ew.Form("fpeak_expensedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpeak_expensedelete;
    loadjs.done("fpeak_expensedelete");
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
<form name="fpeak_expensedelete" id="fpeak_expensedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense">
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
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <th class="<?= $Page->peak_expense_id->headerCellClass() ?>"><span id="elh_peak_expense_peak_expense_id" class="peak_expense_peak_expense_id"><?= $Page->peak_expense_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_peak_expense_id" class="peak_expense_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_peak_expense_code" class="peak_expense_code"><?= $Page->code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->issuedDate->Visible) { // issuedDate ?>
        <th class="<?= $Page->issuedDate->headerCellClass() ?>"><span id="elh_peak_expense_issuedDate" class="peak_expense_issuedDate"><?= $Page->issuedDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <th class="<?= $Page->dueDate->headerCellClass() ?>"><span id="elh_peak_expense_dueDate" class="peak_expense_dueDate"><?= $Page->dueDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contactId->Visible) { // contactId ?>
        <th class="<?= $Page->contactId->headerCellClass() ?>"><span id="elh_peak_expense_contactId" class="peak_expense_contactId"><?= $Page->contactId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contactCode->Visible) { // contactCode ?>
        <th class="<?= $Page->contactCode->headerCellClass() ?>"><span id="elh_peak_expense_contactCode" class="peak_expense_contactCode"><?= $Page->contactCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_peak_expense_status" class="peak_expense_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isTaxInvoice->Visible) { // isTaxInvoice ?>
        <th class="<?= $Page->isTaxInvoice->headerCellClass() ?>"><span id="elh_peak_expense_isTaxInvoice" class="peak_expense_isTaxInvoice"><?= $Page->isTaxInvoice->caption() ?></span></th>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <th class="<?= $Page->preTaxAmount->headerCellClass() ?>"><span id="elh_peak_expense_preTaxAmount" class="peak_expense_preTaxAmount"><?= $Page->preTaxAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <th class="<?= $Page->vatAmount->headerCellClass() ?>"><span id="elh_peak_expense_vatAmount" class="peak_expense_vatAmount"><?= $Page->vatAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
        <th class="<?= $Page->netAmount->headerCellClass() ?>"><span id="elh_peak_expense_netAmount" class="peak_expense_netAmount"><?= $Page->netAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <th class="<?= $Page->whtAmount->headerCellClass() ?>"><span id="elh_peak_expense_whtAmount" class="peak_expense_whtAmount"><?= $Page->whtAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <th class="<?= $Page->paymentAmount->headerCellClass() ?>"><span id="elh_peak_expense_paymentAmount" class="peak_expense_paymentAmount"><?= $Page->paymentAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <th class="<?= $Page->remainAmount->headerCellClass() ?>"><span id="elh_peak_expense_remainAmount" class="peak_expense_remainAmount"><?= $Page->remainAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->taxStatus->Visible) { // taxStatus ?>
        <th class="<?= $Page->taxStatus->headerCellClass() ?>"><span id="elh_peak_expense_taxStatus" class="peak_expense_taxStatus"><?= $Page->taxStatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <th class="<?= $Page->paymentDate->headerCellClass() ?>"><span id="elh_peak_expense_paymentDate" class="peak_expense_paymentDate"><?= $Page->paymentDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <th class="<?= $Page->withHoldingTaxAmount->headerCellClass() ?>"><span id="elh_peak_expense_withHoldingTaxAmount" class="peak_expense_withHoldingTaxAmount"><?= $Page->withHoldingTaxAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentGroupId->Visible) { // paymentGroupId ?>
        <th class="<?= $Page->paymentGroupId->headerCellClass() ?>"><span id="elh_peak_expense_paymentGroupId" class="peak_expense_paymentGroupId"><?= $Page->paymentGroupId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentTotal->Visible) { // paymentTotal ?>
        <th class="<?= $Page->paymentTotal->headerCellClass() ?>"><span id="elh_peak_expense_paymentTotal" class="peak_expense_paymentTotal"><?= $Page->paymentTotal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentMethodId->Visible) { // paymentMethodId ?>
        <th class="<?= $Page->paymentMethodId->headerCellClass() ?>"><span id="elh_peak_expense_paymentMethodId" class="peak_expense_paymentMethodId"><?= $Page->paymentMethodId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <th class="<?= $Page->paymentMethodCode->headerCellClass() ?>"><span id="elh_peak_expense_paymentMethodCode" class="peak_expense_paymentMethodCode"><?= $Page->paymentMethodCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><span id="elh_peak_expense_amount" class="peak_expense_amount"><?= $Page->amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
        <th class="<?= $Page->journals_id->headerCellClass() ?>"><span id="elh_peak_expense_journals_id" class="peak_expense_journals_id"><?= $Page->journals_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
        <th class="<?= $Page->journals_code->headerCellClass() ?>"><span id="elh_peak_expense_journals_code" class="peak_expense_journals_code"><?= $Page->journals_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_peak_expense_cdate" class="peak_expense_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_peak_expense_cuser" class="peak_expense_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_peak_expense_cip" class="peak_expense_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_peak_expense_udate" class="peak_expense_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_peak_expense_uuser" class="peak_expense_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_peak_expense_uip" class="peak_expense_uip"><?= $Page->uip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sync_detail_date->Visible) { // sync_detail_date ?>
        <th class="<?= $Page->sync_detail_date->headerCellClass() ?>"><span id="elh_peak_expense_sync_detail_date" class="peak_expense_sync_detail_date"><?= $Page->sync_detail_date->caption() ?></span></th>
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
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <td<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_peak_expense_id" class="el_peak_expense_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<?= $Page->peak_expense_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_id" class="el_peak_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <td<?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_code" class="el_peak_expense_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->issuedDate->Visible) { // issuedDate ?>
        <td<?= $Page->issuedDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_issuedDate" class="el_peak_expense_issuedDate">
<span<?= $Page->issuedDate->viewAttributes() ?>>
<?= $Page->issuedDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <td<?= $Page->dueDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_dueDate" class="el_peak_expense_dueDate">
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contactId->Visible) { // contactId ?>
        <td<?= $Page->contactId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_contactId" class="el_peak_expense_contactId">
<span<?= $Page->contactId->viewAttributes() ?>>
<?= $Page->contactId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contactCode->Visible) { // contactCode ?>
        <td<?= $Page->contactCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_contactCode" class="el_peak_expense_contactCode">
<span<?= $Page->contactCode->viewAttributes() ?>>
<?= $Page->contactCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_status" class="el_peak_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isTaxInvoice->Visible) { // isTaxInvoice ?>
        <td<?= $Page->isTaxInvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_isTaxInvoice" class="el_peak_expense_isTaxInvoice">
<span<?= $Page->isTaxInvoice->viewAttributes() ?>>
<?= $Page->isTaxInvoice->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <td<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_preTaxAmount" class="el_peak_expense_preTaxAmount">
<span<?= $Page->preTaxAmount->viewAttributes() ?>>
<?= $Page->preTaxAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <td<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_vatAmount" class="el_peak_expense_vatAmount">
<span<?= $Page->vatAmount->viewAttributes() ?>>
<?= $Page->vatAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
        <td<?= $Page->netAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_netAmount" class="el_peak_expense_netAmount">
<span<?= $Page->netAmount->viewAttributes() ?>>
<?= $Page->netAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <td<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_whtAmount" class="el_peak_expense_whtAmount">
<span<?= $Page->whtAmount->viewAttributes() ?>>
<?= $Page->whtAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <td<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentAmount" class="el_peak_expense_paymentAmount">
<span<?= $Page->paymentAmount->viewAttributes() ?>>
<?= $Page->paymentAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <td<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_remainAmount" class="el_peak_expense_remainAmount">
<span<?= $Page->remainAmount->viewAttributes() ?>>
<?= $Page->remainAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->taxStatus->Visible) { // taxStatus ?>
        <td<?= $Page->taxStatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_taxStatus" class="el_peak_expense_taxStatus">
<span<?= $Page->taxStatus->viewAttributes() ?>>
<?= $Page->taxStatus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <td<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentDate" class="el_peak_expense_paymentDate">
<span<?= $Page->paymentDate->viewAttributes() ?>>
<?= $Page->paymentDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <td<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_withHoldingTaxAmount" class="el_peak_expense_withHoldingTaxAmount">
<span<?= $Page->withHoldingTaxAmount->viewAttributes() ?>>
<?= $Page->withHoldingTaxAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentGroupId->Visible) { // paymentGroupId ?>
        <td<?= $Page->paymentGroupId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentGroupId" class="el_peak_expense_paymentGroupId">
<span<?= $Page->paymentGroupId->viewAttributes() ?>>
<?= $Page->paymentGroupId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentTotal->Visible) { // paymentTotal ?>
        <td<?= $Page->paymentTotal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentTotal" class="el_peak_expense_paymentTotal">
<span<?= $Page->paymentTotal->viewAttributes() ?>>
<?= $Page->paymentTotal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentMethodId->Visible) { // paymentMethodId ?>
        <td<?= $Page->paymentMethodId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentMethodId" class="el_peak_expense_paymentMethodId">
<span<?= $Page->paymentMethodId->viewAttributes() ?>>
<?= $Page->paymentMethodId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <td<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentMethodCode" class="el_peak_expense_paymentMethodCode">
<span<?= $Page->paymentMethodCode->viewAttributes() ?>>
<?= $Page->paymentMethodCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <td<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_amount" class="el_peak_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
        <td<?= $Page->journals_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_journals_id" class="el_peak_expense_journals_id">
<span<?= $Page->journals_id->viewAttributes() ?>>
<?= $Page->journals_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
        <td<?= $Page->journals_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_journals_code" class="el_peak_expense_journals_code">
<span<?= $Page->journals_code->viewAttributes() ?>>
<?= $Page->journals_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_cdate" class="el_peak_expense_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_cuser" class="el_peak_expense_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_cip" class="el_peak_expense_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_udate" class="el_peak_expense_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_uuser" class="el_peak_expense_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_uip" class="el_peak_expense_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sync_detail_date->Visible) { // sync_detail_date ?>
        <td<?= $Page->sync_detail_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_sync_detail_date" class="el_peak_expense_sync_detail_date">
<span<?= $Page->sync_detail_date->viewAttributes() ?>>
<?= $Page->sync_detail_date->getViewValue() ?></span>
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
