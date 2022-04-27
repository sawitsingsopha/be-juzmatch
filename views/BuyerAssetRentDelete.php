<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetRentDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset_rent: currentTable } });
var currentForm, currentPageID;
var fbuyer_asset_rentdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_rentdelete = new ew.Form("fbuyer_asset_rentdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fbuyer_asset_rentdelete;
    loadjs.done("fbuyer_asset_rentdelete");
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
<form name="fbuyer_asset_rentdelete" id="fbuyer_asset_rentdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset_rent">
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><span id="elh_buyer_asset_rent_asset_id" class="buyer_asset_rent_asset_id"><?= $Page->asset_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <th class="<?= $Page->one_time_status->headerCellClass() ?>"><span id="elh_buyer_asset_rent_one_time_status" class="buyer_asset_rent_one_time_status"><?= $Page->one_time_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <th class="<?= $Page->half_price_1->headerCellClass() ?>"><span id="elh_buyer_asset_rent_half_price_1" class="buyer_asset_rent_half_price_1"><?= $Page->half_price_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <th class="<?= $Page->status_pay_half_price_1->headerCellClass() ?>"><span id="elh_buyer_asset_rent_status_pay_half_price_1" class="buyer_asset_rent_status_pay_half_price_1"><?= $Page->status_pay_half_price_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
        <th class="<?= $Page->pay_number_half_price_1->headerCellClass() ?>"><span id="elh_buyer_asset_rent_pay_number_half_price_1" class="buyer_asset_rent_pay_number_half_price_1"><?= $Page->pay_number_half_price_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
        <th class="<?= $Page->date_pay_half_price_1->headerCellClass() ?>"><span id="elh_buyer_asset_rent_date_pay_half_price_1" class="buyer_asset_rent_date_pay_half_price_1"><?= $Page->date_pay_half_price_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <th class="<?= $Page->due_date_pay_half_price_1->headerCellClass() ?>"><span id="elh_buyer_asset_rent_due_date_pay_half_price_1" class="buyer_asset_rent_due_date_pay_half_price_1"><?= $Page->due_date_pay_half_price_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <th class="<?= $Page->half_price_2->headerCellClass() ?>"><span id="elh_buyer_asset_rent_half_price_2" class="buyer_asset_rent_half_price_2"><?= $Page->half_price_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <th class="<?= $Page->status_pay_half_price_2->headerCellClass() ?>"><span id="elh_buyer_asset_rent_status_pay_half_price_2" class="buyer_asset_rent_status_pay_half_price_2"><?= $Page->status_pay_half_price_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
        <th class="<?= $Page->pay_number_half_price_2->headerCellClass() ?>"><span id="elh_buyer_asset_rent_pay_number_half_price_2" class="buyer_asset_rent_pay_number_half_price_2"><?= $Page->pay_number_half_price_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
        <th class="<?= $Page->date_pay_half_price_2->headerCellClass() ?>"><span id="elh_buyer_asset_rent_date_pay_half_price_2" class="buyer_asset_rent_date_pay_half_price_2"><?= $Page->date_pay_half_price_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <th class="<?= $Page->due_date_pay_half_price_2->headerCellClass() ?>"><span id="elh_buyer_asset_rent_due_date_pay_half_price_2" class="buyer_asset_rent_due_date_pay_half_price_2"><?= $Page->due_date_pay_half_price_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_buyer_asset_rent_cdate" class="buyer_asset_rent_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_asset_id" class="el_buyer_asset_rent_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <td<?= $Page->one_time_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_one_time_status" class="el_buyer_asset_rent_one_time_status">
<span<?= $Page->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->one_time_status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <td<?= $Page->half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_half_price_1" class="el_buyer_asset_rent_half_price_1">
<span<?= $Page->half_price_1->viewAttributes() ?>>
<?= $Page->half_price_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <td<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_status_pay_half_price_1" class="el_buyer_asset_rent_status_pay_half_price_1">
<span<?= $Page->status_pay_half_price_1->viewAttributes() ?>>
<?= $Page->status_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
        <td<?= $Page->pay_number_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_pay_number_half_price_1" class="el_buyer_asset_rent_pay_number_half_price_1">
<span<?= $Page->pay_number_half_price_1->viewAttributes() ?>>
<?= $Page->pay_number_half_price_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
        <td<?= $Page->date_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_date_pay_half_price_1" class="el_buyer_asset_rent_date_pay_half_price_1">
<span<?= $Page->date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <td<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_due_date_pay_half_price_1" class="el_buyer_asset_rent_due_date_pay_half_price_1">
<span<?= $Page->due_date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <td<?= $Page->half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_half_price_2" class="el_buyer_asset_rent_half_price_2">
<span<?= $Page->half_price_2->viewAttributes() ?>>
<?= $Page->half_price_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <td<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_status_pay_half_price_2" class="el_buyer_asset_rent_status_pay_half_price_2">
<span<?= $Page->status_pay_half_price_2->viewAttributes() ?>>
<?= $Page->status_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
        <td<?= $Page->pay_number_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_pay_number_half_price_2" class="el_buyer_asset_rent_pay_number_half_price_2">
<span<?= $Page->pay_number_half_price_2->viewAttributes() ?>>
<?= $Page->pay_number_half_price_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
        <td<?= $Page->date_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_date_pay_half_price_2" class="el_buyer_asset_rent_date_pay_half_price_2">
<span<?= $Page->date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->date_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <td<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_due_date_pay_half_price_2" class="el_buyer_asset_rent_due_date_pay_half_price_2">
<span<?= $Page->due_date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_cdate" class="el_buyer_asset_rent_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
