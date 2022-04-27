<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BrandDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { brand: currentTable } });
var currentForm, currentPageID;
var fbranddelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbranddelete = new ew.Form("fbranddelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fbranddelete;
    loadjs.done("fbranddelete");
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
<form name="fbranddelete" id="fbranddelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="brand">
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
<?php if ($Page->brand_name->Visible) { // brand_name ?>
        <th class="<?= $Page->brand_name->headerCellClass() ?>"><span id="elh_brand_brand_name" class="brand_brand_name"><?= $Page->brand_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_name->Visible) { // company_name ?>
        <th class="<?= $Page->company_name->headerCellClass() ?>"><span id="elh_brand_company_name" class="brand_company_name"><?= $Page->company_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><span id="elh_brand_order_by" class="brand_order_by"><?= $Page->order_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><span id="elh_brand_isactive" class="brand_isactive"><?= $Page->isactive->caption() ?></span></th>
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
<?php if ($Page->brand_name->Visible) { // brand_name ?>
        <td<?= $Page->brand_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_brand_name" class="el_brand_brand_name">
<span<?= $Page->brand_name->viewAttributes() ?>>
<?= $Page->brand_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_name->Visible) { // company_name ?>
        <td<?= $Page->company_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_company_name" class="el_brand_company_name">
<span<?= $Page->company_name->viewAttributes() ?>>
<?= $Page->company_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <td<?= $Page->order_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_order_by" class="el_brand_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <td<?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_isactive" class="el_brand_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
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
