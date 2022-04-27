<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllAssetConfigScheduleView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_asset_config_schedule: currentTable } });
var currentForm, currentPageID;
var fall_asset_config_scheduleview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_asset_config_scheduleview = new ew.Form("fall_asset_config_scheduleview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fall_asset_config_scheduleview;
    loadjs.done("fall_asset_config_scheduleview");
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
<form name="fall_asset_config_scheduleview" id="fall_asset_config_scheduleview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_asset_config_schedule">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
    <tr id="r_installment_all"<?= $Page->installment_all->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_installment_all"><?= $Page->installment_all->caption() ?></span></td>
        <td data-name="installment_all"<?= $Page->installment_all->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
    <tr id="r_installment_price_per"<?= $Page->installment_price_per->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_installment_price_per"><?= $Page->installment_price_per->caption() ?></span></td>
        <td data-name="installment_price_per"<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_installment_price_per">
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
    <tr id="r_date_start_installment"<?= $Page->date_start_installment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_date_start_installment"><?= $Page->date_start_installment->caption() ?></span></td>
        <td data-name="date_start_installment"<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_date_start_installment">
<span<?= $Page->date_start_installment->viewAttributes() ?>>
<?= $Page->date_start_installment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
    <tr id="r_status_approve"<?= $Page->status_approve->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_status_approve"><?= $Page->status_approve->caption() ?></span></td>
        <td data-name="status_approve"<?= $Page->status_approve->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_status_approve">
<span<?= $Page->status_approve->viewAttributes() ?>>
<?= $Page->status_approve->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_all_asset_config_schedule_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
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
