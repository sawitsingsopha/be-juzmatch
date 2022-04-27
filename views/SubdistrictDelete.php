<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SubdistrictDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { subdistrict: currentTable } });
var currentForm, currentPageID;
var fsubdistrictdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsubdistrictdelete = new ew.Form("fsubdistrictdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fsubdistrictdelete;
    loadjs.done("fsubdistrictdelete");
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
<form name="fsubdistrictdelete" id="fsubdistrictdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subdistrict">
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
<?php if ($Page->subdistrict_id->Visible) { // subdistrict_id ?>
        <th class="<?= $Page->subdistrict_id->headerCellClass() ?>"><span id="elh_subdistrict_subdistrict_id" class="subdistrict_subdistrict_id"><?= $Page->subdistrict_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subdistrict_code->Visible) { // subdistrict_code ?>
        <th class="<?= $Page->subdistrict_code->headerCellClass() ?>"><span id="elh_subdistrict_subdistrict_code" class="subdistrict_subdistrict_code"><?= $Page->subdistrict_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
        <th class="<?= $Page->district_id->headerCellClass() ?>"><span id="elh_subdistrict_district_id" class="subdistrict_district_id"><?= $Page->district_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <th class="<?= $Page->province_id->headerCellClass() ?>"><span id="elh_subdistrict_province_id" class="subdistrict_province_id"><?= $Page->province_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->geo_id->Visible) { // geo_id ?>
        <th class="<?= $Page->geo_id->headerCellClass() ?>"><span id="elh_subdistrict_geo_id" class="subdistrict_geo_id"><?= $Page->geo_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subdistrict_name->Visible) { // subdistrict_name ?>
        <th class="<?= $Page->subdistrict_name->headerCellClass() ?>"><span id="elh_subdistrict_subdistrict_name" class="subdistrict_subdistrict_name"><?= $Page->subdistrict_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subdistrict_name_en->Visible) { // subdistrict_name_en ?>
        <th class="<?= $Page->subdistrict_name_en->headerCellClass() ?>"><span id="elh_subdistrict_subdistrict_name_en" class="subdistrict_subdistrict_name_en"><?= $Page->subdistrict_name_en->caption() ?></span></th>
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
<?php if ($Page->subdistrict_id->Visible) { // subdistrict_id ?>
        <td<?= $Page->subdistrict_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_subdistrict_id" class="el_subdistrict_subdistrict_id">
<span<?= $Page->subdistrict_id->viewAttributes() ?>>
<?= $Page->subdistrict_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subdistrict_code->Visible) { // subdistrict_code ?>
        <td<?= $Page->subdistrict_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_subdistrict_code" class="el_subdistrict_subdistrict_code">
<span<?= $Page->subdistrict_code->viewAttributes() ?>>
<?= $Page->subdistrict_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
        <td<?= $Page->district_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_district_id" class="el_subdistrict_district_id">
<span<?= $Page->district_id->viewAttributes() ?>>
<?= $Page->district_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <td<?= $Page->province_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_province_id" class="el_subdistrict_province_id">
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->geo_id->Visible) { // geo_id ?>
        <td<?= $Page->geo_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_geo_id" class="el_subdistrict_geo_id">
<span<?= $Page->geo_id->viewAttributes() ?>>
<?= $Page->geo_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subdistrict_name->Visible) { // subdistrict_name ?>
        <td<?= $Page->subdistrict_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_subdistrict_name" class="el_subdistrict_subdistrict_name">
<span<?= $Page->subdistrict_name->viewAttributes() ?>>
<?= $Page->subdistrict_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subdistrict_name_en->Visible) { // subdistrict_name_en ?>
        <td<?= $Page->subdistrict_name_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subdistrict_subdistrict_name_en" class="el_subdistrict_subdistrict_name_en">
<span<?= $Page->subdistrict_name_en->viewAttributes() ?>>
<?= $Page->subdistrict_name_en->getViewValue() ?></span>
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
