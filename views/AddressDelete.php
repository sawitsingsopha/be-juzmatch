<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AddressDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { address: currentTable } });
var currentForm, currentPageID;
var faddressdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    faddressdelete = new ew.Form("faddressdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = faddressdelete;
    loadjs.done("faddressdelete");
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
<form name="faddressdelete" id="faddressdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="address">
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
<?php if ($Page->address->Visible) { // address ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><span id="elh_address_address" class="address_address"><?= $Page->address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <th class="<?= $Page->province_id->headerCellClass() ?>"><span id="elh_address_province_id" class="address_province_id"><?= $Page->province_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
        <th class="<?= $Page->amphur_id->headerCellClass() ?>"><span id="elh_address_amphur_id" class="address_amphur_id"><?= $Page->amphur_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
        <th class="<?= $Page->district_id->headerCellClass() ?>"><span id="elh_address_district_id" class="address_district_id"><?= $Page->district_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
        <th class="<?= $Page->postcode->headerCellClass() ?>"><span id="elh_address_postcode" class="address_postcode"><?= $Page->postcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_address_cdate" class="address_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->address->Visible) { // address ?>
        <td<?= $Page->address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_address_address" class="el_address_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <td<?= $Page->province_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_address_province_id" class="el_address_province_id">
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
        <td<?= $Page->amphur_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_address_amphur_id" class="el_address_amphur_id">
<span<?= $Page->amphur_id->viewAttributes() ?>>
<?= $Page->amphur_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
        <td<?= $Page->district_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_address_district_id" class="el_address_district_id">
<span<?= $Page->district_id->viewAttributes() ?>>
<?= $Page->district_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
        <td<?= $Page->postcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_address_postcode" class="el_address_postcode">
<span<?= $Page->postcode->viewAttributes() ?>>
<?= $Page->postcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_address_cdate" class="el_address_cdate">
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
