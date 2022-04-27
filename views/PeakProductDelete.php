<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakProductDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_product: currentTable } });
var currentForm, currentPageID;
var fpeak_productdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_productdelete = new ew.Form("fpeak_productdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpeak_productdelete;
    loadjs.done("fpeak_productdelete");
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
<form name="fpeak_productdelete" id="fpeak_productdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_product">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_peak_product_id" class="peak_product_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
        <th class="<?= $Page->productid->headerCellClass() ?>"><span id="elh_peak_product_productid" class="peak_product_productid"><?= $Page->productid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_peak_product_name" class="peak_product_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_peak_product_code" class="peak_product_code"><?= $Page->code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_peak_product_type" class="peak_product_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->purchaseValue->Visible) { // purchaseValue ?>
        <th class="<?= $Page->purchaseValue->headerCellClass() ?>"><span id="elh_peak_product_purchaseValue" class="peak_product_purchaseValue"><?= $Page->purchaseValue->caption() ?></span></th>
<?php } ?>
<?php if ($Page->purchaseVatType->Visible) { // purchaseVatType ?>
        <th class="<?= $Page->purchaseVatType->headerCellClass() ?>"><span id="elh_peak_product_purchaseVatType" class="peak_product_purchaseVatType"><?= $Page->purchaseVatType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->purchaseAccount->Visible) { // purchaseAccount ?>
        <th class="<?= $Page->purchaseAccount->headerCellClass() ?>"><span id="elh_peak_product_purchaseAccount" class="peak_product_purchaseAccount"><?= $Page->purchaseAccount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sellValue->Visible) { // sellValue ?>
        <th class="<?= $Page->sellValue->headerCellClass() ?>"><span id="elh_peak_product_sellValue" class="peak_product_sellValue"><?= $Page->sellValue->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sellVatType->Visible) { // sellVatType ?>
        <th class="<?= $Page->sellVatType->headerCellClass() ?>"><span id="elh_peak_product_sellVatType" class="peak_product_sellVatType"><?= $Page->sellVatType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sellAccount->Visible) { // sellAccount ?>
        <th class="<?= $Page->sellAccount->headerCellClass() ?>"><span id="elh_peak_product_sellAccount" class="peak_product_sellAccount"><?= $Page->sellAccount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->carryingBalanceValue->Visible) { // carryingBalanceValue ?>
        <th class="<?= $Page->carryingBalanceValue->headerCellClass() ?>"><span id="elh_peak_product_carryingBalanceValue" class="peak_product_carryingBalanceValue"><?= $Page->carryingBalanceValue->caption() ?></span></th>
<?php } ?>
<?php if ($Page->carryingBalanceAmount->Visible) { // carryingBalanceAmount ?>
        <th class="<?= $Page->carryingBalanceAmount->headerCellClass() ?>"><span id="elh_peak_product_carryingBalanceAmount" class="peak_product_carryingBalanceAmount"><?= $Page->carryingBalanceAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->remainingBalanceAmount->Visible) { // remainingBalanceAmount ?>
        <th class="<?= $Page->remainingBalanceAmount->headerCellClass() ?>"><span id="elh_peak_product_remainingBalanceAmount" class="peak_product_remainingBalanceAmount"><?= $Page->remainingBalanceAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th class="<?= $Page->create_date->headerCellClass() ?>"><span id="elh_peak_product_create_date" class="peak_product_create_date"><?= $Page->create_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->update_date->Visible) { // update_date ?>
        <th class="<?= $Page->update_date->headerCellClass() ?>"><span id="elh_peak_product_update_date" class="peak_product_update_date"><?= $Page->update_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->post_message->Visible) { // post_message ?>
        <th class="<?= $Page->post_message->headerCellClass() ?>"><span id="elh_peak_product_post_message" class="peak_product_post_message"><?= $Page->post_message->caption() ?></span></th>
<?php } ?>
<?php if ($Page->post_try_cnt->Visible) { // post_try_cnt ?>
        <th class="<?= $Page->post_try_cnt->headerCellClass() ?>"><span id="elh_peak_product_post_try_cnt" class="peak_product_post_try_cnt"><?= $Page->post_try_cnt->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_peak_product_id" class="el_peak_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
        <td<?= $Page->productid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_productid" class="el_peak_product_productid">
<span<?= $Page->productid->viewAttributes() ?>>
<?= $Page->productid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_name" class="el_peak_product_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <td<?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_code" class="el_peak_product_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_type" class="el_peak_product_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->purchaseValue->Visible) { // purchaseValue ?>
        <td<?= $Page->purchaseValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_purchaseValue" class="el_peak_product_purchaseValue">
<span<?= $Page->purchaseValue->viewAttributes() ?>>
<?= $Page->purchaseValue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->purchaseVatType->Visible) { // purchaseVatType ?>
        <td<?= $Page->purchaseVatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_purchaseVatType" class="el_peak_product_purchaseVatType">
<span<?= $Page->purchaseVatType->viewAttributes() ?>>
<?= $Page->purchaseVatType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->purchaseAccount->Visible) { // purchaseAccount ?>
        <td<?= $Page->purchaseAccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_purchaseAccount" class="el_peak_product_purchaseAccount">
<span<?= $Page->purchaseAccount->viewAttributes() ?>>
<?= $Page->purchaseAccount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sellValue->Visible) { // sellValue ?>
        <td<?= $Page->sellValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_sellValue" class="el_peak_product_sellValue">
<span<?= $Page->sellValue->viewAttributes() ?>>
<?= $Page->sellValue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sellVatType->Visible) { // sellVatType ?>
        <td<?= $Page->sellVatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_sellVatType" class="el_peak_product_sellVatType">
<span<?= $Page->sellVatType->viewAttributes() ?>>
<?= $Page->sellVatType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sellAccount->Visible) { // sellAccount ?>
        <td<?= $Page->sellAccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_sellAccount" class="el_peak_product_sellAccount">
<span<?= $Page->sellAccount->viewAttributes() ?>>
<?= $Page->sellAccount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->carryingBalanceValue->Visible) { // carryingBalanceValue ?>
        <td<?= $Page->carryingBalanceValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_carryingBalanceValue" class="el_peak_product_carryingBalanceValue">
<span<?= $Page->carryingBalanceValue->viewAttributes() ?>>
<?= $Page->carryingBalanceValue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->carryingBalanceAmount->Visible) { // carryingBalanceAmount ?>
        <td<?= $Page->carryingBalanceAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_carryingBalanceAmount" class="el_peak_product_carryingBalanceAmount">
<span<?= $Page->carryingBalanceAmount->viewAttributes() ?>>
<?= $Page->carryingBalanceAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->remainingBalanceAmount->Visible) { // remainingBalanceAmount ?>
        <td<?= $Page->remainingBalanceAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_remainingBalanceAmount" class="el_peak_product_remainingBalanceAmount">
<span<?= $Page->remainingBalanceAmount->viewAttributes() ?>>
<?= $Page->remainingBalanceAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <td<?= $Page->create_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_create_date" class="el_peak_product_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->update_date->Visible) { // update_date ?>
        <td<?= $Page->update_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_update_date" class="el_peak_product_update_date">
<span<?= $Page->update_date->viewAttributes() ?>>
<?= $Page->update_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->post_message->Visible) { // post_message ?>
        <td<?= $Page->post_message->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_post_message" class="el_peak_product_post_message">
<span<?= $Page->post_message->viewAttributes() ?>>
<?= $Page->post_message->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->post_try_cnt->Visible) { // post_try_cnt ?>
        <td<?= $Page->post_try_cnt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_post_try_cnt" class="el_peak_product_post_try_cnt">
<span<?= $Page->post_try_cnt->viewAttributes() ?>>
<?= $Page->post_try_cnt->getViewValue() ?></span>
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
