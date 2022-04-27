<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvertorAllBookingView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { invertor_all_booking: currentTable } });
var currentForm, currentPageID;
var finvertor_all_bookingview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvertor_all_bookingview = new ew.Form("finvertor_all_bookingview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = finvertor_all_bookingview;
    loadjs.done("finvertor_all_bookingview");
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
<form name="finvertor_all_bookingview" id="finvertor_all_bookingview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invertor_all_booking">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->invertor_booking_id->Visible) { // invertor_booking_id ?>
    <tr id="r_invertor_booking_id"<?= $Page->invertor_booking_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_invertor_booking_id"><?= $Page->invertor_booking_id->caption() ?></span></td>
        <td data-name="invertor_booking_id"<?= $Page->invertor_booking_id->cellAttributes() ?>>
<span id="el_invertor_all_booking_invertor_booking_id">
<span<?= $Page->invertor_booking_id->viewAttributes() ?>>
<?= $Page->invertor_booking_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_invertor_all_booking_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_invertor_all_booking_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <tr id="r_date_booking"<?= $Page->date_booking->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_date_booking"><?= $Page->date_booking->caption() ?></span></td>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el_invertor_all_booking_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <tr id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_status_expire"><?= $Page->status_expire->caption() ?></span></td>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_invertor_all_booking_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
    <tr id="r_status_expire_reason"<?= $Page->status_expire_reason->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_status_expire_reason"><?= $Page->status_expire_reason->caption() ?></span></td>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_invertor_all_booking_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
    <tr id="r_payment_status"<?= $Page->payment_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_payment_status"><?= $Page->payment_status->caption() ?></span></td>
        <td data-name="payment_status"<?= $Page->payment_status->cellAttributes() ?>>
<span id="el_invertor_all_booking_payment_status">
<span<?= $Page->payment_status->viewAttributes() ?>>
<?= $Page->payment_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invertor_all_booking_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_invertor_all_booking_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("payment_inverter_booking", explode(",", $Page->getCurrentDetailTable())) && $payment_inverter_booking->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("payment_inverter_booking", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PaymentInverterBookingGrid.php" ?>
<?php } ?>
<?php
    if (in_array("all_asset_config_schedule", explode(",", $Page->getCurrentDetailTable())) && $all_asset_config_schedule->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("all_asset_config_schedule", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AllAssetConfigScheduleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("all_asset_schedule", explode(",", $Page->getCurrentDetailTable())) && $all_asset_schedule->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("all_asset_schedule", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AllAssetScheduleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("doc_juzmatch2", explode(",", $Page->getCurrentDetailTable())) && $doc_juzmatch2->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("doc_juzmatch2", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "DocJuzmatch2Grid.php" ?>
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
