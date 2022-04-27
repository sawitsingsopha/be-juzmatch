<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptProductView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt_product: currentTable } });
var currentForm, currentPageID;
var fpeak_receipt_productview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receipt_productview = new ew.Form("fpeak_receipt_productview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpeak_receipt_productview;
    loadjs.done("fpeak_receipt_productview");
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
<form name="fpeak_receipt_productview" id="fpeak_receipt_productview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt_product">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_receipt_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->peak_receipt_id->Visible) { // peak_receipt_id ?>
    <tr id="r_peak_receipt_id"<?= $Page->peak_receipt_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_peak_receipt_id"><?= $Page->peak_receipt_id->caption() ?></span></td>
        <td data-name="peak_receipt_id"<?= $Page->peak_receipt_id->cellAttributes() ?>>
<span id="el_peak_receipt_product_peak_receipt_id">
<span<?= $Page->peak_receipt_id->viewAttributes() ?>>
<?= $Page->peak_receipt_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->products_id->Visible) { // products_id ?>
    <tr id="r_products_id"<?= $Page->products_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_products_id"><?= $Page->products_id->caption() ?></span></td>
        <td data-name="products_id"<?= $Page->products_id->cellAttributes() ?>>
<span id="el_peak_receipt_product_products_id">
<span<?= $Page->products_id->viewAttributes() ?>>
<?= $Page->products_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
    <tr id="r_productid"<?= $Page->productid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_productid"><?= $Page->productid->caption() ?></span></td>
        <td data-name="productid"<?= $Page->productid->cellAttributes() ?>>
<span id="el_peak_receipt_product_productid">
<span<?= $Page->productid->viewAttributes() ?>>
<?= $Page->productid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->productcode->Visible) { // productcode ?>
    <tr id="r_productcode"<?= $Page->productcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_productcode"><?= $Page->productcode->caption() ?></span></td>
        <td data-name="productcode"<?= $Page->productcode->cellAttributes() ?>>
<span id="el_peak_receipt_product_productcode">
<span<?= $Page->productcode->viewAttributes() ?>>
<?= $Page->productcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->producttemplate->Visible) { // producttemplate ?>
    <tr id="r_producttemplate"<?= $Page->producttemplate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_producttemplate"><?= $Page->producttemplate->caption() ?></span></td>
        <td data-name="producttemplate"<?= $Page->producttemplate->cellAttributes() ?>>
<span id="el_peak_receipt_product_producttemplate">
<span<?= $Page->producttemplate->viewAttributes() ?>>
<?= $Page->producttemplate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_peak_receipt_product_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountcode->Visible) { // accountcode ?>
    <tr id="r_accountcode"<?= $Page->accountcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_accountcode"><?= $Page->accountcode->caption() ?></span></td>
        <td data-name="accountcode"<?= $Page->accountcode->cellAttributes() ?>>
<span id="el_peak_receipt_product_accountcode">
<span<?= $Page->accountcode->viewAttributes() ?>>
<?= $Page->accountcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountSubId->Visible) { // accountSubId ?>
    <tr id="r_accountSubId"<?= $Page->accountSubId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_accountSubId"><?= $Page->accountSubId->caption() ?></span></td>
        <td data-name="accountSubId"<?= $Page->accountSubId->cellAttributes() ?>>
<span id="el_peak_receipt_product_accountSubId">
<span<?= $Page->accountSubId->viewAttributes() ?>>
<?= $Page->accountSubId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountSubCode->Visible) { // accountSubCode ?>
    <tr id="r_accountSubCode"<?= $Page->accountSubCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_accountSubCode"><?= $Page->accountSubCode->caption() ?></span></td>
        <td data-name="accountSubCode"<?= $Page->accountSubCode->cellAttributes() ?>>
<span id="el_peak_receipt_product_accountSubCode">
<span<?= $Page->accountSubCode->viewAttributes() ?>>
<?= $Page->accountSubCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <tr id="r_quantity"<?= $Page->quantity->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_quantity"><?= $Page->quantity->caption() ?></span></td>
        <td data-name="quantity"<?= $Page->quantity->cellAttributes() ?>>
<span id="el_peak_receipt_product_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <tr id="r_price"<?= $Page->price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_price"><?= $Page->price->caption() ?></span></td>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el_peak_receipt_product_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->discount->Visible) { // discount ?>
    <tr id="r_discount"<?= $Page->discount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_discount"><?= $Page->discount->caption() ?></span></td>
        <td data-name="discount"<?= $Page->discount->cellAttributes() ?>>
<span id="el_peak_receipt_product_discount">
<span<?= $Page->discount->viewAttributes() ?>>
<?= $Page->discount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
    <tr id="r_vatType"<?= $Page->vatType->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_vatType"><?= $Page->vatType->caption() ?></span></td>
        <td data-name="vatType"<?= $Page->vatType->cellAttributes() ?>>
<span id="el_peak_receipt_product_vatType">
<span<?= $Page->vatType->viewAttributes() ?>>
<?= $Page->vatType->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <tr id="r_note"<?= $Page->note->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_receipt_product_note"><?= $Page->note->caption() ?></span></td>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el_peak_receipt_product_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
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
