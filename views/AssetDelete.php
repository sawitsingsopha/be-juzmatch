<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset: currentTable } });
var currentForm, currentPageID;
var fassetdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fassetdelete = new ew.Form("fassetdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fassetdelete;
    loadjs.done("fassetdelete");
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
<form name="fassetdelete" id="fassetdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset">
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
<?php if ($Page->_title->Visible) { // title ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><span id="elh_asset__title" class="asset__title"><?= $Page->_title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <th class="<?= $Page->brand_id->headerCellClass() ?>"><span id="elh_asset_brand_id" class="asset_brand_id"><?= $Page->brand_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><span id="elh_asset_asset_code" class="asset_asset_code"><?= $Page->asset_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
        <th class="<?= $Page->asset_status->headerCellClass() ?>"><span id="elh_asset_asset_status" class="asset_asset_status"><?= $Page->asset_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><span id="elh_asset_isactive" class="asset_isactive"><?= $Page->isactive->caption() ?></span></th>
<?php } ?>
<?php if ($Page->price_mark->Visible) { // price_mark ?>
        <th class="<?= $Page->price_mark->headerCellClass() ?>"><span id="elh_asset_price_mark" class="asset_price_mark"><?= $Page->price_mark->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
        <th class="<?= $Page->usable_area->headerCellClass() ?>"><span id="elh_asset_usable_area" class="asset_usable_area"><?= $Page->usable_area->caption() ?></span></th>
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
        <th class="<?= $Page->land_size->headerCellClass() ?>"><span id="elh_asset_land_size" class="asset_land_size"><?= $Page->land_size->caption() ?></span></th>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
        <th class="<?= $Page->count_view->headerCellClass() ?>"><span id="elh_asset_count_view" class="asset_count_view"><?= $Page->count_view->caption() ?></span></th>
<?php } ?>
<?php if ($Page->count_favorite->Visible) { // count_favorite ?>
        <th class="<?= $Page->count_favorite->headerCellClass() ?>"><span id="elh_asset_count_favorite" class="asset_count_favorite"><?= $Page->count_favorite->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><span id="elh_asset_expired_date" class="asset_expired_date"><?= $Page->expired_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_asset_cdate" class="asset_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->_title->Visible) { // title ?>
        <td<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset__title" class="el_asset__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <td<?= $Page->brand_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_brand_id" class="el_asset_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_asset_code" class="el_asset_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
        <td<?= $Page->asset_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_asset_status" class="el_asset_asset_status">
<span<?= $Page->asset_status->viewAttributes() ?>>
<?= $Page->asset_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <td<?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_isactive" class="el_asset_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->price_mark->Visible) { // price_mark ?>
        <td<?= $Page->price_mark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_price_mark" class="el_asset_price_mark">
<span<?= $Page->price_mark->viewAttributes() ?>>
<?= $Page->price_mark->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
        <td<?= $Page->usable_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_usable_area" class="el_asset_usable_area">
<span<?= $Page->usable_area->viewAttributes() ?>>
<?= $Page->usable_area->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
        <td<?= $Page->land_size->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_land_size" class="el_asset_land_size">
<span<?= $Page->land_size->viewAttributes() ?>>
<?= $Page->land_size->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
        <td<?= $Page->count_view->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_count_view" class="el_asset_count_view">
<span<?= $Page->count_view->viewAttributes() ?>>
<?= $Page->count_view->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->count_favorite->Visible) { // count_favorite ?>
        <td<?= $Page->count_favorite->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_count_favorite" class="el_asset_count_favorite">
<span<?= $Page->count_favorite->viewAttributes() ?>>
<?= $Page->count_favorite->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_expired_date" class="el_asset_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_cdate" class="el_asset_cdate">
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
