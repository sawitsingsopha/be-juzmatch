<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakProductView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_product: currentTable } });
var currentForm, currentPageID;
var fpeak_productview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_productview = new ew.Form("fpeak_productview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpeak_productview;
    loadjs.done("fpeak_productview");
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
<form name="fpeak_productview" id="fpeak_productview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_product">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
    <tr id="r_productid"<?= $Page->productid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_productid"><?= $Page->productid->caption() ?></span></td>
        <td data-name="productid"<?= $Page->productid->cellAttributes() ?>>
<span id="el_peak_product_productid">
<span<?= $Page->productid->viewAttributes() ?>>
<?= $Page->productid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name"<?= $Page->name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el_peak_product_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code"<?= $Page->code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code"<?= $Page->code->cellAttributes() ?>>
<span id="el_peak_product_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type"<?= $Page->type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<span id="el_peak_product_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->purchaseValue->Visible) { // purchaseValue ?>
    <tr id="r_purchaseValue"<?= $Page->purchaseValue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_purchaseValue"><?= $Page->purchaseValue->caption() ?></span></td>
        <td data-name="purchaseValue"<?= $Page->purchaseValue->cellAttributes() ?>>
<span id="el_peak_product_purchaseValue">
<span<?= $Page->purchaseValue->viewAttributes() ?>>
<?= $Page->purchaseValue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->purchaseVatType->Visible) { // purchaseVatType ?>
    <tr id="r_purchaseVatType"<?= $Page->purchaseVatType->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_purchaseVatType"><?= $Page->purchaseVatType->caption() ?></span></td>
        <td data-name="purchaseVatType"<?= $Page->purchaseVatType->cellAttributes() ?>>
<span id="el_peak_product_purchaseVatType">
<span<?= $Page->purchaseVatType->viewAttributes() ?>>
<?= $Page->purchaseVatType->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->purchaseAccount->Visible) { // purchaseAccount ?>
    <tr id="r_purchaseAccount"<?= $Page->purchaseAccount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_purchaseAccount"><?= $Page->purchaseAccount->caption() ?></span></td>
        <td data-name="purchaseAccount"<?= $Page->purchaseAccount->cellAttributes() ?>>
<span id="el_peak_product_purchaseAccount">
<span<?= $Page->purchaseAccount->viewAttributes() ?>>
<?= $Page->purchaseAccount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sellValue->Visible) { // sellValue ?>
    <tr id="r_sellValue"<?= $Page->sellValue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_sellValue"><?= $Page->sellValue->caption() ?></span></td>
        <td data-name="sellValue"<?= $Page->sellValue->cellAttributes() ?>>
<span id="el_peak_product_sellValue">
<span<?= $Page->sellValue->viewAttributes() ?>>
<?= $Page->sellValue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sellVatType->Visible) { // sellVatType ?>
    <tr id="r_sellVatType"<?= $Page->sellVatType->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_sellVatType"><?= $Page->sellVatType->caption() ?></span></td>
        <td data-name="sellVatType"<?= $Page->sellVatType->cellAttributes() ?>>
<span id="el_peak_product_sellVatType">
<span<?= $Page->sellVatType->viewAttributes() ?>>
<?= $Page->sellVatType->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sellAccount->Visible) { // sellAccount ?>
    <tr id="r_sellAccount"<?= $Page->sellAccount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_sellAccount"><?= $Page->sellAccount->caption() ?></span></td>
        <td data-name="sellAccount"<?= $Page->sellAccount->cellAttributes() ?>>
<span id="el_peak_product_sellAccount">
<span<?= $Page->sellAccount->viewAttributes() ?>>
<?= $Page->sellAccount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_peak_product_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->carryingBalanceValue->Visible) { // carryingBalanceValue ?>
    <tr id="r_carryingBalanceValue"<?= $Page->carryingBalanceValue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_carryingBalanceValue"><?= $Page->carryingBalanceValue->caption() ?></span></td>
        <td data-name="carryingBalanceValue"<?= $Page->carryingBalanceValue->cellAttributes() ?>>
<span id="el_peak_product_carryingBalanceValue">
<span<?= $Page->carryingBalanceValue->viewAttributes() ?>>
<?= $Page->carryingBalanceValue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->carryingBalanceAmount->Visible) { // carryingBalanceAmount ?>
    <tr id="r_carryingBalanceAmount"<?= $Page->carryingBalanceAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_carryingBalanceAmount"><?= $Page->carryingBalanceAmount->caption() ?></span></td>
        <td data-name="carryingBalanceAmount"<?= $Page->carryingBalanceAmount->cellAttributes() ?>>
<span id="el_peak_product_carryingBalanceAmount">
<span<?= $Page->carryingBalanceAmount->viewAttributes() ?>>
<?= $Page->carryingBalanceAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remainingBalanceAmount->Visible) { // remainingBalanceAmount ?>
    <tr id="r_remainingBalanceAmount"<?= $Page->remainingBalanceAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_remainingBalanceAmount"><?= $Page->remainingBalanceAmount->caption() ?></span></td>
        <td data-name="remainingBalanceAmount"<?= $Page->remainingBalanceAmount->cellAttributes() ?>>
<span id="el_peak_product_remainingBalanceAmount">
<span<?= $Page->remainingBalanceAmount->viewAttributes() ?>>
<?= $Page->remainingBalanceAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
    <tr id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_create_date"><?= $Page->create_date->caption() ?></span></td>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el_peak_product_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->update_date->Visible) { // update_date ?>
    <tr id="r_update_date"<?= $Page->update_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_update_date"><?= $Page->update_date->caption() ?></span></td>
        <td data-name="update_date"<?= $Page->update_date->cellAttributes() ?>>
<span id="el_peak_product_update_date">
<span<?= $Page->update_date->viewAttributes() ?>>
<?= $Page->update_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->post_message->Visible) { // post_message ?>
    <tr id="r_post_message"<?= $Page->post_message->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_post_message"><?= $Page->post_message->caption() ?></span></td>
        <td data-name="post_message"<?= $Page->post_message->cellAttributes() ?>>
<span id="el_peak_product_post_message">
<span<?= $Page->post_message->viewAttributes() ?>>
<?= $Page->post_message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->post_try_cnt->Visible) { // post_try_cnt ?>
    <tr id="r_post_try_cnt"<?= $Page->post_try_cnt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_product_post_try_cnt"><?= $Page->post_try_cnt->caption() ?></span></td>
        <td data-name="post_try_cnt"<?= $Page->post_try_cnt->cellAttributes() ?>>
<span id="el_peak_product_post_try_cnt">
<span<?= $Page->post_try_cnt->viewAttributes() ?>>
<?= $Page->post_try_cnt->getViewValue() ?></span>
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
