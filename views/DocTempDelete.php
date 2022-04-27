<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocTempDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_temp: currentTable } });
var currentForm, currentPageID;
var fdoc_tempdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_tempdelete = new ew.Form("fdoc_tempdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_tempdelete;
    loadjs.done("fdoc_tempdelete");
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
<form name="fdoc_tempdelete" id="fdoc_tempdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_temp">
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
<?php if ($Page->doc_temp_type->Visible) { // doc_temp_type ?>
        <th class="<?= $Page->doc_temp_type->headerCellClass() ?>"><span id="elh_doc_temp_doc_temp_type" class="doc_temp_doc_temp_type"><?= $Page->doc_temp_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_temp_name->Visible) { // doc_temp_name ?>
        <th class="<?= $Page->doc_temp_name->headerCellClass() ?>"><span id="elh_doc_temp_doc_temp_name" class="doc_temp_doc_temp_name"><?= $Page->doc_temp_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_temp_file->Visible) { // doc_temp_file ?>
        <th class="<?= $Page->doc_temp_file->headerCellClass() ?>"><span id="elh_doc_temp_doc_temp_file" class="doc_temp_doc_temp_file"><?= $Page->doc_temp_file->caption() ?></span></th>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
        <th class="<?= $Page->active_status->headerCellClass() ?>"><span id="elh_doc_temp_active_status" class="doc_temp_active_status"><?= $Page->active_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->esign_page1->Visible) { // esign_page1 ?>
        <th class="<?= $Page->esign_page1->headerCellClass() ?>"><span id="elh_doc_temp_esign_page1" class="doc_temp_esign_page1"><?= $Page->esign_page1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->esign_page2->Visible) { // esign_page2 ?>
        <th class="<?= $Page->esign_page2->headerCellClass() ?>"><span id="elh_doc_temp_esign_page2" class="doc_temp_esign_page2"><?= $Page->esign_page2->caption() ?></span></th>
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
<?php if ($Page->doc_temp_type->Visible) { // doc_temp_type ?>
        <td<?= $Page->doc_temp_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_doc_temp_type" class="el_doc_temp_doc_temp_type">
<span<?= $Page->doc_temp_type->viewAttributes() ?>>
<?= $Page->doc_temp_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_temp_name->Visible) { // doc_temp_name ?>
        <td<?= $Page->doc_temp_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_doc_temp_name" class="el_doc_temp_doc_temp_name">
<span<?= $Page->doc_temp_name->viewAttributes() ?>>
<?= $Page->doc_temp_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_temp_file->Visible) { // doc_temp_file ?>
        <td<?= $Page->doc_temp_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_doc_temp_file" class="el_doc_temp_doc_temp_file">
<span<?= $Page->doc_temp_file->viewAttributes() ?>>
<?= GetFileViewTag($Page->doc_temp_file, $Page->doc_temp_file->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
        <td<?= $Page->active_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_active_status" class="el_doc_temp_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->esign_page1->Visible) { // esign_page1 ?>
        <td<?= $Page->esign_page1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_esign_page1" class="el_doc_temp_esign_page1">
<span<?= $Page->esign_page1->viewAttributes() ?>>
<?= $Page->esign_page1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->esign_page2->Visible) { // esign_page2 ?>
        <td<?= $Page->esign_page2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_esign_page2" class="el_doc_temp_esign_page2">
<span<?= $Page->esign_page2->viewAttributes() ?>>
<?= $Page->esign_page2->getViewValue() ?></span>
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
