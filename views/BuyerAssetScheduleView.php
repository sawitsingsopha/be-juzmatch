<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetScheduleView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fbuyer_asset_scheduleview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_scheduleview = new ew.Form("fbuyer_asset_scheduleview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fbuyer_asset_scheduleview;
    loadjs.done("fbuyer_asset_scheduleview");
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
<form name="fbuyer_asset_scheduleview" id="fbuyer_asset_scheduleview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset_schedule">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
    <tr id="r_num_installment"<?= $Page->num_installment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_num_installment"><?= $Page->num_installment->caption() ?></span></td>
        <td data-name="num_installment"<?= $Page->num_installment->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_num_installment">
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
    <tr id="r_installment_per_price"<?= $Page->installment_per_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_installment_per_price"><?= $Page->installment_per_price->caption() ?></span></td>
        <td data-name="installment_per_price"<?= $Page->installment_per_price->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_installment_per_price">
<span<?= $Page->installment_per_price->viewAttributes() ?>>
<?= $Page->installment_per_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <tr id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_pay_number"><?= $Page->pay_number->caption() ?></span></td>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
    <tr id="r_expired_date"<?= $Page->expired_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_expired_date"><?= $Page->expired_date->caption() ?></span></td>
        <td data-name="expired_date"<?= $Page->expired_date->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <tr id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_date_payment"><?= $Page->date_payment->caption() ?></span></td>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <tr id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_status_payment"><?= $Page->status_payment->caption() ?></span></td>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_buyer_asset_schedule_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_buyer_asset_schedule_cdate">
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
