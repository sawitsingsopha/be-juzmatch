<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerBookingAssetView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_booking_asset: currentTable } });
var currentForm, currentPageID;
var fbuyer_booking_assetview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_booking_assetview = new ew.Form("fbuyer_booking_assetview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fbuyer_booking_assetview;
    loadjs.done("fbuyer_booking_assetview");
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
<form name="fbuyer_booking_assetview" id="fbuyer_booking_assetview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_booking_asset">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_booking_asset_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <tr id="r_booking_price"<?= $Page->booking_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_booking_price"><?= $Page->booking_price->caption() ?></span></td>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el_buyer_booking_asset_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <tr id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_pay_number"><?= $Page->pay_number->caption() ?></span></td>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_buyer_booking_asset_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <tr id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_status_payment"><?= $Page->status_payment->caption() ?></span></td>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_buyer_booking_asset_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <tr id="r_date_booking"<?= $Page->date_booking->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_date_booking"><?= $Page->date_booking->caption() ?></span></td>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el_buyer_booking_asset_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <tr id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_date_payment"><?= $Page->date_payment->caption() ?></span></td>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_buyer_booking_asset_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <tr id="r_due_date"<?= $Page->due_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_due_date"><?= $Page->due_date->caption() ?></span></td>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el_buyer_booking_asset_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <tr id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_status_expire"><?= $Page->status_expire->caption() ?></span></td>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_buyer_booking_asset_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
    <tr id="r_status_expire_reason"<?= $Page->status_expire_reason->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_status_expire_reason"><?= $Page->status_expire_reason->caption() ?></span></td>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_buyer_booking_asset_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_booking_asset_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_buyer_booking_asset_cdate">
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
