<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAllAssetRentView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_all_asset_rent: currentTable } });
var currentForm, currentPageID;
var fbuyer_all_asset_rentview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_all_asset_rentview = new ew.Form("fbuyer_all_asset_rentview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fbuyer_all_asset_rentview;
    loadjs.done("fbuyer_all_asset_rentview");
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
<form name="fbuyer_all_asset_rentview" id="fbuyer_all_asset_rentview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_all_asset_rent">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
    <tr id="r_one_time_status"<?= $Page->one_time_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_one_time_status"><?= $Page->one_time_status->caption() ?></span></td>
        <td data-name="one_time_status"<?= $Page->one_time_status->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_one_time_status">
<span<?= $Page->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->one_time_status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
    <tr id="r_half_price_1"<?= $Page->half_price_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_half_price_1"><?= $Page->half_price_1->caption() ?></span></td>
        <td data-name="half_price_1"<?= $Page->half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_half_price_1">
<span<?= $Page->half_price_1->viewAttributes() ?>>
<?= $Page->half_price_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
    <tr id="r_pay_number_half_price_1"<?= $Page->pay_number_half_price_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_pay_number_half_price_1"><?= $Page->pay_number_half_price_1->caption() ?></span></td>
        <td data-name="pay_number_half_price_1"<?= $Page->pay_number_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_pay_number_half_price_1">
<span<?= $Page->pay_number_half_price_1->viewAttributes() ?>>
<?= $Page->pay_number_half_price_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
    <tr id="r_status_pay_half_price_1"<?= $Page->status_pay_half_price_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_status_pay_half_price_1"><?= $Page->status_pay_half_price_1->caption() ?></span></td>
        <td data-name="status_pay_half_price_1"<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_status_pay_half_price_1">
<span<?= $Page->status_pay_half_price_1->viewAttributes() ?>>
<?= $Page->status_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
    <tr id="r_date_pay_half_price_1"<?= $Page->date_pay_half_price_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_date_pay_half_price_1"><?= $Page->date_pay_half_price_1->caption() ?></span></td>
        <td data-name="date_pay_half_price_1"<?= $Page->date_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_date_pay_half_price_1">
<span<?= $Page->date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
    <tr id="r_due_date_pay_half_price_1"<?= $Page->due_date_pay_half_price_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_due_date_pay_half_price_1"><?= $Page->due_date_pay_half_price_1->caption() ?></span></td>
        <td data-name="due_date_pay_half_price_1"<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<span<?= $Page->due_date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
    <tr id="r_half_price_2"<?= $Page->half_price_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_half_price_2"><?= $Page->half_price_2->caption() ?></span></td>
        <td data-name="half_price_2"<?= $Page->half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_half_price_2">
<span<?= $Page->half_price_2->viewAttributes() ?>>
<?= $Page->half_price_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
    <tr id="r_pay_number_half_price_2"<?= $Page->pay_number_half_price_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_pay_number_half_price_2"><?= $Page->pay_number_half_price_2->caption() ?></span></td>
        <td data-name="pay_number_half_price_2"<?= $Page->pay_number_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_pay_number_half_price_2">
<span<?= $Page->pay_number_half_price_2->viewAttributes() ?>>
<?= $Page->pay_number_half_price_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
    <tr id="r_status_pay_half_price_2"<?= $Page->status_pay_half_price_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_status_pay_half_price_2"><?= $Page->status_pay_half_price_2->caption() ?></span></td>
        <td data-name="status_pay_half_price_2"<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_status_pay_half_price_2">
<span<?= $Page->status_pay_half_price_2->viewAttributes() ?>>
<?= $Page->status_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
    <tr id="r_date_pay_half_price_2"<?= $Page->date_pay_half_price_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_date_pay_half_price_2"><?= $Page->date_pay_half_price_2->caption() ?></span></td>
        <td data-name="date_pay_half_price_2"<?= $Page->date_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_date_pay_half_price_2">
<span<?= $Page->date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->date_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
    <tr id="r_due_date_pay_half_price_2"<?= $Page->due_date_pay_half_price_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_due_date_pay_half_price_2"><?= $Page->due_date_pay_half_price_2->caption() ?></span></td>
        <td data-name="due_date_pay_half_price_2"<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<span<?= $Page->due_date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_all_asset_rent_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
