<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetConfigScheduleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_config_schedule: currentTable } });
var currentForm, currentPageID;
var fasset_config_scheduledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_config_scheduledelete = new ew.Form("fasset_config_scheduledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fasset_config_scheduledelete;
    loadjs.done("fasset_config_scheduledelete");
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
<form name="fasset_config_scheduledelete" id="fasset_config_scheduledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_config_schedule">
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
        <th class="<?= $Page->installment_all->headerCellClass() ?>"><span id="elh_asset_config_schedule_installment_all" class="asset_config_schedule_installment_all"><?= $Page->installment_all->caption() ?></span></th>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <th class="<?= $Page->installment_price_per->headerCellClass() ?>"><span id="elh_asset_config_schedule_installment_price_per" class="asset_config_schedule_installment_price_per"><?= $Page->installment_price_per->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <th class="<?= $Page->date_start_installment->headerCellClass() ?>"><span id="elh_asset_config_schedule_date_start_installment" class="asset_config_schedule_date_start_installment"><?= $Page->date_start_installment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
        <th class="<?= $Page->status_approve->headerCellClass() ?>"><span id="elh_asset_config_schedule_status_approve" class="asset_config_schedule_status_approve"><?= $Page->status_approve->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_asset_config_schedule_cdate" class="asset_config_schedule_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_asset_config_schedule_installment_all" class="el_asset_config_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <td<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_config_schedule_installment_price_per" class="el_asset_config_schedule_installment_price_per">
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <td<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_config_schedule_date_start_installment" class="el_asset_config_schedule_date_start_installment">
<span<?= $Page->date_start_installment->viewAttributes() ?>>
<?= $Page->date_start_installment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
        <td<?= $Page->status_approve->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_config_schedule_status_approve" class="el_asset_config_schedule_status_approve">
<span<?= $Page->status_approve->viewAttributes() ?>>
<?= $Page->status_approve->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_config_schedule_cdate" class="el_asset_config_schedule_cdate">
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
