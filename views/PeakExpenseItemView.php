<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseItemView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense_item: currentTable } });
var currentForm, currentPageID;
var fpeak_expense_itemview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expense_itemview = new ew.Form("fpeak_expense_itemview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpeak_expense_itemview;
    loadjs.done("fpeak_expense_itemview");
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
<form name="fpeak_expense_itemview" id="fpeak_expense_itemview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense_item">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->peak_expense_item_id->Visible) { // peak_expense_item_id ?>
    <tr id="r_peak_expense_item_id"<?= $Page->peak_expense_item_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_peak_expense_item_id"><?= $Page->peak_expense_item_id->caption() ?></span></td>
        <td data-name="peak_expense_item_id"<?= $Page->peak_expense_item_id->cellAttributes() ?>>
<span id="el_peak_expense_item_peak_expense_item_id">
<span<?= $Page->peak_expense_item_id->viewAttributes() ?>>
<?= $Page->peak_expense_item_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
    <tr id="r_peak_expense_id"<?= $Page->peak_expense_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_peak_expense_id"><?= $Page->peak_expense_id->caption() ?></span></td>
        <td data-name="peak_expense_id"<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el_peak_expense_item_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<?= $Page->peak_expense_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_expense_item_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->productId->Visible) { // productId ?>
    <tr id="r_productId"<?= $Page->productId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_productId"><?= $Page->productId->caption() ?></span></td>
        <td data-name="productId"<?= $Page->productId->cellAttributes() ?>>
<span id="el_peak_expense_item_productId">
<span<?= $Page->productId->viewAttributes() ?>>
<?= $Page->productId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->productCode->Visible) { // productCode ?>
    <tr id="r_productCode"<?= $Page->productCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_productCode"><?= $Page->productCode->caption() ?></span></td>
        <td data-name="productCode"<?= $Page->productCode->cellAttributes() ?>>
<span id="el_peak_expense_item_productCode">
<span<?= $Page->productCode->viewAttributes() ?>>
<?= $Page->productCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountCode->Visible) { // accountCode ?>
    <tr id="r_accountCode"<?= $Page->accountCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_accountCode"><?= $Page->accountCode->caption() ?></span></td>
        <td data-name="accountCode"<?= $Page->accountCode->cellAttributes() ?>>
<span id="el_peak_expense_item_accountCode">
<span<?= $Page->accountCode->viewAttributes() ?>>
<?= $Page->accountCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_peak_expense_item_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <tr id="r_quantity"<?= $Page->quantity->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_quantity"><?= $Page->quantity->caption() ?></span></td>
        <td data-name="quantity"<?= $Page->quantity->cellAttributes() ?>>
<span id="el_peak_expense_item_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <tr id="r_price"<?= $Page->price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_price"><?= $Page->price->caption() ?></span></td>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el_peak_expense_item_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
    <tr id="r_vatType"<?= $Page->vatType->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_vatType"><?= $Page->vatType->caption() ?></span></td>
        <td data-name="vatType"<?= $Page->vatType->cellAttributes() ?>>
<span id="el_peak_expense_item_vatType">
<span<?= $Page->vatType->viewAttributes() ?>>
<?= $Page->vatType->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
    <tr id="r_withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_withHoldingTaxAmount"><?= $Page->withHoldingTaxAmount->caption() ?></span></td>
        <td data-name="withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el_peak_expense_item_withHoldingTaxAmount">
<span<?= $Page->withHoldingTaxAmount->viewAttributes() ?>>
<?= $Page->withHoldingTaxAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isdelete->Visible) { // isdelete ?>
    <tr id="r_isdelete"<?= $Page->isdelete->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_isdelete"><?= $Page->isdelete->caption() ?></span></td>
        <td data-name="isdelete"<?= $Page->isdelete->cellAttributes() ?>>
<span id="el_peak_expense_item_isdelete">
<span<?= $Page->isdelete->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_isdelete_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isdelete->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isdelete->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isdelete_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_peak_expense_item_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_peak_expense_item_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_peak_expense_item_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <tr id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_udate"><?= $Page->udate->caption() ?></span></td>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el_peak_expense_item_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <tr id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_uuser"><?= $Page->uuser->caption() ?></span></td>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el_peak_expense_item_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <tr id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_expense_item_uip"><?= $Page->uip->caption() ?></span></td>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el_peak_expense_item_uip">
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
