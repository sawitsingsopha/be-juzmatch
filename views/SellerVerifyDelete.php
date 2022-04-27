<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SellerVerifyDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { seller_verify: currentTable } });
var currentForm, currentPageID;
var fseller_verifydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fseller_verifydelete = new ew.Form("fseller_verifydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fseller_verifydelete;
    loadjs.done("fseller_verifydelete");
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
<form name="fseller_verifydelete" id="fseller_verifydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="seller_verify">
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
<?php if ($Page->category_id->Visible) { // category_id ?>
        <th class="<?= $Page->category_id->headerCellClass() ?>"><span id="elh_seller_verify_category_id" class="seller_verify_category_id"><?= $Page->category_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_seller_verify_cdate" class="seller_verify_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->category_id->Visible) { // category_id ?>
        <td<?= $Page->category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_seller_verify_category_id" class="el_seller_verify_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<?= $Page->category_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_seller_verify_cdate" class="el_seller_verify_cdate">
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
