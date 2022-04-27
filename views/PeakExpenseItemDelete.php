<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseItemDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense_item: currentTable } });
var currentForm, currentPageID;
var fpeak_expense_itemdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expense_itemdelete = new ew.Form("fpeak_expense_itemdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpeak_expense_itemdelete;
    loadjs.done("fpeak_expense_itemdelete");
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
<form name="fpeak_expense_itemdelete" id="fpeak_expense_itemdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense_item">
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
<?php if ($Page->peak_expense_item_id->Visible) { // peak_expense_item_id ?>
        <th class="<?= $Page->peak_expense_item_id->headerCellClass() ?>"><span id="elh_peak_expense_item_peak_expense_item_id" class="peak_expense_item_peak_expense_item_id"><?= $Page->peak_expense_item_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <th class="<?= $Page->peak_expense_id->headerCellClass() ?>"><span id="elh_peak_expense_item_peak_expense_id" class="peak_expense_item_peak_expense_id"><?= $Page->peak_expense_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_peak_expense_item_id" class="peak_expense_item_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->productId->Visible) { // productId ?>
        <th class="<?= $Page->productId->headerCellClass() ?>"><span id="elh_peak_expense_item_productId" class="peak_expense_item_productId"><?= $Page->productId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->productCode->Visible) { // productCode ?>
        <th class="<?= $Page->productCode->headerCellClass() ?>"><span id="elh_peak_expense_item_productCode" class="peak_expense_item_productCode"><?= $Page->productCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->accountCode->Visible) { // accountCode ?>
        <th class="<?= $Page->accountCode->headerCellClass() ?>"><span id="elh_peak_expense_item_accountCode" class="peak_expense_item_accountCode"><?= $Page->accountCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><span id="elh_peak_expense_item_quantity" class="peak_expense_item_quantity"><?= $Page->quantity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th class="<?= $Page->price->headerCellClass() ?>"><span id="elh_peak_expense_item_price" class="peak_expense_item_price"><?= $Page->price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
        <th class="<?= $Page->vatType->headerCellClass() ?>"><span id="elh_peak_expense_item_vatType" class="peak_expense_item_vatType"><?= $Page->vatType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <th class="<?= $Page->withHoldingTaxAmount->headerCellClass() ?>"><span id="elh_peak_expense_item_withHoldingTaxAmount" class="peak_expense_item_withHoldingTaxAmount"><?= $Page->withHoldingTaxAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isdelete->Visible) { // isdelete ?>
        <th class="<?= $Page->isdelete->headerCellClass() ?>"><span id="elh_peak_expense_item_isdelete" class="peak_expense_item_isdelete"><?= $Page->isdelete->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_peak_expense_item_cdate" class="peak_expense_item_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_peak_expense_item_cuser" class="peak_expense_item_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_peak_expense_item_cip" class="peak_expense_item_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_peak_expense_item_udate" class="peak_expense_item_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_peak_expense_item_uuser" class="peak_expense_item_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_peak_expense_item_uip" class="peak_expense_item_uip"><?= $Page->uip->caption() ?></span></th>
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
<?php if ($Page->peak_expense_item_id->Visible) { // peak_expense_item_id ?>
        <td<?= $Page->peak_expense_item_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_peak_expense_item_id" class="el_peak_expense_item_peak_expense_item_id">
<span<?= $Page->peak_expense_item_id->viewAttributes() ?>>
<?= $Page->peak_expense_item_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <td<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_peak_expense_id" class="el_peak_expense_item_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<?= $Page->peak_expense_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_id" class="el_peak_expense_item_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->productId->Visible) { // productId ?>
        <td<?= $Page->productId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_productId" class="el_peak_expense_item_productId">
<span<?= $Page->productId->viewAttributes() ?>>
<?= $Page->productId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->productCode->Visible) { // productCode ?>
        <td<?= $Page->productCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_productCode" class="el_peak_expense_item_productCode">
<span<?= $Page->productCode->viewAttributes() ?>>
<?= $Page->productCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->accountCode->Visible) { // accountCode ?>
        <td<?= $Page->accountCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_accountCode" class="el_peak_expense_item_accountCode">
<span<?= $Page->accountCode->viewAttributes() ?>>
<?= $Page->accountCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <td<?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_quantity" class="el_peak_expense_item_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <td<?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_price" class="el_peak_expense_item_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
        <td<?= $Page->vatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_vatType" class="el_peak_expense_item_vatType">
<span<?= $Page->vatType->viewAttributes() ?>>
<?= $Page->vatType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <td<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_withHoldingTaxAmount" class="el_peak_expense_item_withHoldingTaxAmount">
<span<?= $Page->withHoldingTaxAmount->viewAttributes() ?>>
<?= $Page->withHoldingTaxAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isdelete->Visible) { // isdelete ?>
        <td<?= $Page->isdelete->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_isdelete" class="el_peak_expense_item_isdelete">
<span<?= $Page->isdelete->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_isdelete_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isdelete->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isdelete->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isdelete_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_cdate" class="el_peak_expense_item_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_cuser" class="el_peak_expense_item_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_cip" class="el_peak_expense_item_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_udate" class="el_peak_expense_item_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_uuser" class="el_peak_expense_item_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_uip" class="el_peak_expense_item_uip">
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
