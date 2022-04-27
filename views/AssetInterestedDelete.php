<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetInterestedDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_interested: currentTable } });
var currentForm, currentPageID;
var fasset_interesteddelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_interesteddelete = new ew.Form("fasset_interesteddelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fasset_interesteddelete;
    loadjs.done("fasset_interesteddelete");
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
<form name="fasset_interesteddelete" id="fasset_interesteddelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_interested">
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
<?php if ($Page->asset_interested_id->Visible) { // asset_interested_id ?>
        <th class="<?= $Page->asset_interested_id->headerCellClass() ?>"><span id="elh_asset_interested_asset_interested_id" class="asset_interested_asset_interested_id"><?= $Page->asset_interested_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><span id="elh_asset_interested_asset_id" class="asset_interested_asset_id"><?= $Page->asset_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->master_asset_interested_id->Visible) { // master_asset_interested_id ?>
        <th class="<?= $Page->master_asset_interested_id->headerCellClass() ?>"><span id="elh_asset_interested_master_asset_interested_id" class="asset_interested_master_asset_interested_id"><?= $Page->master_asset_interested_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_asset_interested_cdate" class="asset_interested_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->asset_interested_id->Visible) { // asset_interested_id ?>
        <td<?= $Page->asset_interested_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_interested_asset_interested_id" class="el_asset_interested_asset_interested_id">
<span<?= $Page->asset_interested_id->viewAttributes() ?>>
<?= $Page->asset_interested_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_interested_asset_id" class="el_asset_interested_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->master_asset_interested_id->Visible) { // master_asset_interested_id ?>
        <td<?= $Page->master_asset_interested_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_interested_master_asset_interested_id" class="el_asset_interested_master_asset_interested_id">
<span<?= $Page->master_asset_interested_id->viewAttributes() ?>>
<?= $Page->master_asset_interested_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_interested_cdate" class="el_asset_interested_cdate">
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
