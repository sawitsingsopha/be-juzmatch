<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerConfigAssetScheduleView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_config_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fbuyer_config_asset_scheduleview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_config_asset_scheduleview = new ew.Form("fbuyer_config_asset_scheduleview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fbuyer_config_asset_scheduleview;
    loadjs.done("fbuyer_config_asset_scheduleview");
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
<form name="fbuyer_config_asset_scheduleview" id="fbuyer_config_asset_scheduleview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_config_asset_schedule">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
    <tr id="r_installment_all"<?= $Page->installment_all->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_installment_all"><?= $Page->installment_all->caption() ?></span></td>
        <td data-name="installment_all"<?= $Page->installment_all->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
    <tr id="r_installment_price_per"<?= $Page->installment_price_per->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_installment_price_per"><?= $Page->installment_price_per->caption() ?></span></td>
        <td data-name="installment_price_per"<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_installment_price_per">
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
    <tr id="r_date_start_installment"<?= $Page->date_start_installment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_date_start_installment"><?= $Page->date_start_installment->caption() ?></span></td>
        <td data-name="date_start_installment"<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_date_start_installment">
<span<?= $Page->date_start_installment->viewAttributes() ?>>
<?= $Page->date_start_installment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
    <tr id="r_asset_price"<?= $Page->asset_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_asset_price"><?= $Page->asset_price->caption() ?></span></td>
        <td data-name="asset_price"<?= $Page->asset_price->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_asset_price">
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <tr id="r_booking_price"<?= $Page->booking_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_booking_price"><?= $Page->booking_price->caption() ?></span></td>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
    <tr id="r_down_price"<?= $Page->down_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_down_price"><?= $Page->down_price->caption() ?></span></td>
        <td data-name="down_price"<?= $Page->down_price->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_down_price">
<span<?= $Page->down_price->viewAttributes() ?>>
<?= $Page->down_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
    <tr id="r_move_in_on_20th"<?= $Page->move_in_on_20th->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_move_in_on_20th"><?= $Page->move_in_on_20th->caption() ?></span></td>
        <td data-name="move_in_on_20th"<?= $Page->move_in_on_20th->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_move_in_on_20th">
<span<?= $Page->move_in_on_20th->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_move_in_on_20th_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->move_in_on_20th->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->move_in_on_20th->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_move_in_on_20th_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
    <tr id="r_number_days_pay_first_month"<?= $Page->number_days_pay_first_month->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_number_days_pay_first_month"><?= $Page->number_days_pay_first_month->caption() ?></span></td>
        <td data-name="number_days_pay_first_month"<?= $Page->number_days_pay_first_month->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_number_days_pay_first_month">
<span<?= $Page->number_days_pay_first_month->viewAttributes() ?>>
<?= $Page->number_days_pay_first_month->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
    <tr id="r_number_days_in_first_month"<?= $Page->number_days_in_first_month->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_number_days_in_first_month"><?= $Page->number_days_in_first_month->caption() ?></span></td>
        <td data-name="number_days_in_first_month"<?= $Page->number_days_in_first_month->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_number_days_in_first_month">
<span<?= $Page->number_days_in_first_month->viewAttributes() ?>>
<?= $Page->number_days_in_first_month->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_config_asset_schedule_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_buyer_config_asset_schedule_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("buyer_asset_schedule", explode(",", $Page->getCurrentDetailTable())) && $buyer_asset_schedule->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("buyer_asset_schedule", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "BuyerAssetScheduleGrid.php" ?>
<?php } ?>
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
