<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllBuyerConfigAssetScheduleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_buyer_config_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fall_buyer_config_asset_scheduledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_buyer_config_asset_scheduledelete = new ew.Form("fall_buyer_config_asset_scheduledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fall_buyer_config_asset_scheduledelete;
    loadjs.done("fall_buyer_config_asset_scheduledelete");
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
<form name="fall_buyer_config_asset_scheduledelete" id="fall_buyer_config_asset_scheduledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_buyer_config_asset_schedule">
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
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <th class="<?= $Page->installment_all->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_installment_all" class="all_buyer_config_asset_schedule_installment_all"><?= $Page->installment_all->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <th class="<?= $Page->asset_price->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_asset_price" class="all_buyer_config_asset_schedule_asset_price"><?= $Page->asset_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th class="<?= $Page->booking_price->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_booking_price" class="all_buyer_config_asset_schedule_booking_price"><?= $Page->booking_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
        <th class="<?= $Page->down_price->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_down_price" class="all_buyer_config_asset_schedule_down_price"><?= $Page->down_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <th class="<?= $Page->installment_price_per->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_installment_price_per" class="all_buyer_config_asset_schedule_installment_price_per"><?= $Page->installment_price_per->caption() ?></span></th>
<?php } ?>
<?php if ($Page->annual_interest->Visible) { // annual_interest ?>
        <th class="<?= $Page->annual_interest->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_annual_interest" class="all_buyer_config_asset_schedule_annual_interest"><?= $Page->annual_interest->caption() ?></span></th>
<?php } ?>
<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <th class="<?= $Page->number_days_pay_first_month->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_number_days_pay_first_month" class="all_buyer_config_asset_schedule_number_days_pay_first_month"><?= $Page->number_days_pay_first_month->caption() ?></span></th>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <th class="<?= $Page->number_days_in_first_month->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_number_days_in_first_month" class="all_buyer_config_asset_schedule_number_days_in_first_month"><?= $Page->number_days_in_first_month->caption() ?></span></th>
<?php } ?>
<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <th class="<?= $Page->move_in_on_20th->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_move_in_on_20th" class="all_buyer_config_asset_schedule_move_in_on_20th"><?= $Page->move_in_on_20th->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <th class="<?= $Page->date_start_installment->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_date_start_installment" class="all_buyer_config_asset_schedule_date_start_installment"><?= $Page->date_start_installment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
        <th class="<?= $Page->status_approve->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_status_approve" class="all_buyer_config_asset_schedule_status_approve"><?= $Page->status_approve->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_all_buyer_config_asset_schedule_cdate" class="all_buyer_config_asset_schedule_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <td<?= $Page->installment_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_installment_all" class="el_all_buyer_config_asset_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <td<?= $Page->asset_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_asset_price" class="el_all_buyer_config_asset_schedule_asset_price">
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_booking_price" class="el_all_buyer_config_asset_schedule_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
        <td<?= $Page->down_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_down_price" class="el_all_buyer_config_asset_schedule_down_price">
<span<?= $Page->down_price->viewAttributes() ?>>
<?= $Page->down_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <td<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_installment_price_per" class="el_all_buyer_config_asset_schedule_installment_price_per">
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->annual_interest->Visible) { // annual_interest ?>
        <td<?= $Page->annual_interest->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_annual_interest" class="el_all_buyer_config_asset_schedule_annual_interest">
<span<?= $Page->annual_interest->viewAttributes() ?>>
<?= $Page->annual_interest->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <td<?= $Page->number_days_pay_first_month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_number_days_pay_first_month" class="el_all_buyer_config_asset_schedule_number_days_pay_first_month">
<span<?= $Page->number_days_pay_first_month->viewAttributes() ?>>
<?= $Page->number_days_pay_first_month->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <td<?= $Page->number_days_in_first_month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_number_days_in_first_month" class="el_all_buyer_config_asset_schedule_number_days_in_first_month">
<span<?= $Page->number_days_in_first_month->viewAttributes() ?>>
<?= $Page->number_days_in_first_month->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <td<?= $Page->move_in_on_20th->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_move_in_on_20th" class="el_all_buyer_config_asset_schedule_move_in_on_20th">
<span<?= $Page->move_in_on_20th->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_move_in_on_20th_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->move_in_on_20th->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->move_in_on_20th->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_move_in_on_20th_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <td<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_date_start_installment" class="el_all_buyer_config_asset_schedule_date_start_installment">
<span<?= $Page->date_start_installment->viewAttributes() ?>>
<?= $Page->date_start_installment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
        <td<?= $Page->status_approve->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_status_approve" class="el_all_buyer_config_asset_schedule_status_approve">
<span<?= $Page->status_approve->viewAttributes() ?>>
<?= $Page->status_approve->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_config_asset_schedule_cdate" class="el_all_buyer_config_asset_schedule_cdate">
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
