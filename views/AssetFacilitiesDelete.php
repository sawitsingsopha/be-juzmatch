<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetFacilitiesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_facilities: currentTable } });
var currentForm, currentPageID;
var fasset_facilitiesdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_facilitiesdelete = new ew.Form("fasset_facilitiesdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fasset_facilitiesdelete;
    loadjs.done("fasset_facilitiesdelete");
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
<form name="fasset_facilitiesdelete" id="fasset_facilitiesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_facilities">
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
<?php if ($Page->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
        <th class="<?= $Page->master_facilities_group_id->headerCellClass() ?>"><span id="elh_asset_facilities_master_facilities_group_id" class="asset_facilities_master_facilities_group_id"><?= $Page->master_facilities_group_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->master_facilities_id->Visible) { // master_facilities_id ?>
        <th class="<?= $Page->master_facilities_id->headerCellClass() ?>"><span id="elh_asset_facilities_master_facilities_id" class="asset_facilities_master_facilities_id"><?= $Page->master_facilities_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><span id="elh_asset_facilities_isactive" class="asset_facilities_isactive"><?= $Page->isactive->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_asset_facilities_cdate" class="asset_facilities_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
        <td<?= $Page->master_facilities_group_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_facilities_master_facilities_group_id" class="el_asset_facilities_master_facilities_group_id">
<span<?= $Page->master_facilities_group_id->viewAttributes() ?>>
<?= $Page->master_facilities_group_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->master_facilities_id->Visible) { // master_facilities_id ?>
        <td<?= $Page->master_facilities_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_facilities_master_facilities_id" class="el_asset_facilities_master_facilities_id">
<span<?= $Page->master_facilities_id->viewAttributes() ?>>
<?= $Page->master_facilities_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <td<?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_facilities_isactive" class="el_asset_facilities_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_facilities_cdate" class="el_asset_facilities_cdate">
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
