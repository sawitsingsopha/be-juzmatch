<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetProsDetailDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_pros_detail: currentTable } });
var currentForm, currentPageID;
var fasset_pros_detaildelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_pros_detaildelete = new ew.Form("fasset_pros_detaildelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fasset_pros_detaildelete;
    loadjs.done("fasset_pros_detaildelete");
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
<form name="fasset_pros_detaildelete" id="fasset_pros_detaildelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_pros_detail">
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
<?php if ($Page->detail->Visible) { // detail ?>
        <th class="<?= $Page->detail->headerCellClass() ?>"><span id="elh_asset_pros_detail_detail" class="asset_pros_detail_detail"><?= $Page->detail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->group_type->Visible) { // group_type ?>
        <th class="<?= $Page->group_type->headerCellClass() ?>"><span id="elh_asset_pros_detail_group_type" class="asset_pros_detail_group_type"><?= $Page->group_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
        <th class="<?= $Page->latitude->headerCellClass() ?>"><span id="elh_asset_pros_detail_latitude" class="asset_pros_detail_latitude"><?= $Page->latitude->caption() ?></span></th>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
        <th class="<?= $Page->longitude->headerCellClass() ?>"><span id="elh_asset_pros_detail_longitude" class="asset_pros_detail_longitude"><?= $Page->longitude->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><span id="elh_asset_pros_detail_isactive" class="asset_pros_detail_isactive"><?= $Page->isactive->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_asset_pros_detail_cdate" class="asset_pros_detail_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->detail->Visible) { // detail ?>
        <td<?= $Page->detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_pros_detail_detail" class="el_asset_pros_detail_detail">
<span<?= $Page->detail->viewAttributes() ?>>
<?= $Page->detail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->group_type->Visible) { // group_type ?>
        <td<?= $Page->group_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_pros_detail_group_type" class="el_asset_pros_detail_group_type">
<span<?= $Page->group_type->viewAttributes() ?>>
<?= $Page->group_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
        <td<?= $Page->latitude->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_pros_detail_latitude" class="el_asset_pros_detail_latitude">
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
        <td<?= $Page->longitude->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_pros_detail_longitude" class="el_asset_pros_detail_longitude">
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <td<?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_pros_detail_isactive" class="el_asset_pros_detail_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_pros_detail_cdate" class="el_asset_pros_detail_cdate">
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
