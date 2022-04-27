<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptProductDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt_product: currentTable } });
var currentForm, currentPageID;
var fpeak_receipt_productdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receipt_productdelete = new ew.Form("fpeak_receipt_productdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpeak_receipt_productdelete;
    loadjs.done("fpeak_receipt_productdelete");
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
<form name="fpeak_receipt_productdelete" id="fpeak_receipt_productdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt_product">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_peak_receipt_product_id" class="peak_receipt_product_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->peak_receipt_id->Visible) { // peak_receipt_id ?>
        <th class="<?= $Page->peak_receipt_id->headerCellClass() ?>"><span id="elh_peak_receipt_product_peak_receipt_id" class="peak_receipt_product_peak_receipt_id"><?= $Page->peak_receipt_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->products_id->Visible) { // products_id ?>
        <th class="<?= $Page->products_id->headerCellClass() ?>"><span id="elh_peak_receipt_product_products_id" class="peak_receipt_product_products_id"><?= $Page->products_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
        <th class="<?= $Page->productid->headerCellClass() ?>"><span id="elh_peak_receipt_product_productid" class="peak_receipt_product_productid"><?= $Page->productid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->productcode->Visible) { // productcode ?>
        <th class="<?= $Page->productcode->headerCellClass() ?>"><span id="elh_peak_receipt_product_productcode" class="peak_receipt_product_productcode"><?= $Page->productcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->producttemplate->Visible) { // producttemplate ?>
        <th class="<?= $Page->producttemplate->headerCellClass() ?>"><span id="elh_peak_receipt_product_producttemplate" class="peak_receipt_product_producttemplate"><?= $Page->producttemplate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->accountcode->Visible) { // accountcode ?>
        <th class="<?= $Page->accountcode->headerCellClass() ?>"><span id="elh_peak_receipt_product_accountcode" class="peak_receipt_product_accountcode"><?= $Page->accountcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->accountSubId->Visible) { // accountSubId ?>
        <th class="<?= $Page->accountSubId->headerCellClass() ?>"><span id="elh_peak_receipt_product_accountSubId" class="peak_receipt_product_accountSubId"><?= $Page->accountSubId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->accountSubCode->Visible) { // accountSubCode ?>
        <th class="<?= $Page->accountSubCode->headerCellClass() ?>"><span id="elh_peak_receipt_product_accountSubCode" class="peak_receipt_product_accountSubCode"><?= $Page->accountSubCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th class="<?= $Page->quantity->headerCellClass() ?>"><span id="elh_peak_receipt_product_quantity" class="peak_receipt_product_quantity"><?= $Page->quantity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th class="<?= $Page->price->headerCellClass() ?>"><span id="elh_peak_receipt_product_price" class="peak_receipt_product_price"><?= $Page->price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->discount->Visible) { // discount ?>
        <th class="<?= $Page->discount->headerCellClass() ?>"><span id="elh_peak_receipt_product_discount" class="peak_receipt_product_discount"><?= $Page->discount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
        <th class="<?= $Page->vatType->headerCellClass() ?>"><span id="elh_peak_receipt_product_vatType" class="peak_receipt_product_vatType"><?= $Page->vatType->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_id" class="el_peak_receipt_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->peak_receipt_id->Visible) { // peak_receipt_id ?>
        <td<?= $Page->peak_receipt_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_peak_receipt_id" class="el_peak_receipt_product_peak_receipt_id">
<span<?= $Page->peak_receipt_id->viewAttributes() ?>>
<?= $Page->peak_receipt_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->products_id->Visible) { // products_id ?>
        <td<?= $Page->products_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_products_id" class="el_peak_receipt_product_products_id">
<span<?= $Page->products_id->viewAttributes() ?>>
<?= $Page->products_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
        <td<?= $Page->productid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_productid" class="el_peak_receipt_product_productid">
<span<?= $Page->productid->viewAttributes() ?>>
<?= $Page->productid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->productcode->Visible) { // productcode ?>
        <td<?= $Page->productcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_productcode" class="el_peak_receipt_product_productcode">
<span<?= $Page->productcode->viewAttributes() ?>>
<?= $Page->productcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->producttemplate->Visible) { // producttemplate ?>
        <td<?= $Page->producttemplate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_producttemplate" class="el_peak_receipt_product_producttemplate">
<span<?= $Page->producttemplate->viewAttributes() ?>>
<?= $Page->producttemplate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->accountcode->Visible) { // accountcode ?>
        <td<?= $Page->accountcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_accountcode" class="el_peak_receipt_product_accountcode">
<span<?= $Page->accountcode->viewAttributes() ?>>
<?= $Page->accountcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->accountSubId->Visible) { // accountSubId ?>
        <td<?= $Page->accountSubId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_accountSubId" class="el_peak_receipt_product_accountSubId">
<span<?= $Page->accountSubId->viewAttributes() ?>>
<?= $Page->accountSubId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->accountSubCode->Visible) { // accountSubCode ?>
        <td<?= $Page->accountSubCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_accountSubCode" class="el_peak_receipt_product_accountSubCode">
<span<?= $Page->accountSubCode->viewAttributes() ?>>
<?= $Page->accountSubCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <td<?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_quantity" class="el_peak_receipt_product_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <td<?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_price" class="el_peak_receipt_product_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->discount->Visible) { // discount ?>
        <td<?= $Page->discount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_discount" class="el_peak_receipt_product_discount">
<span<?= $Page->discount->viewAttributes() ?>>
<?= $Page->discount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
        <td<?= $Page->vatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_vatType" class="el_peak_receipt_product_vatType">
<span<?= $Page->vatType->viewAttributes() ?>>
<?= $Page->vatType->getViewValue() ?></span>
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
