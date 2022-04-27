<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenRunningDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_running: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_runningdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_runningdelete = new ew.Form("fdoc_creden_runningdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_creden_runningdelete;
    loadjs.done("fdoc_creden_runningdelete");
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
<form name="fdoc_creden_runningdelete" id="fdoc_creden_runningdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_running">
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
<?php if ($Page->year->Visible) { // year ?>
        <th class="<?= $Page->year->headerCellClass() ?>"><span id="elh_doc_creden_running_year" class="doc_creden_running_year"><?= $Page->year->caption() ?></span></th>
<?php } ?>
<?php if ($Page->month->Visible) { // month ?>
        <th class="<?= $Page->month->headerCellClass() ?>"><span id="elh_doc_creden_running_month" class="doc_creden_running_month"><?= $Page->month->caption() ?></span></th>
<?php } ?>
<?php if ($Page->running->Visible) { // running ?>
        <th class="<?= $Page->running->headerCellClass() ?>"><span id="elh_doc_creden_running_running" class="doc_creden_running_running"><?= $Page->running->caption() ?></span></th>
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
<?php if ($Page->year->Visible) { // year ?>
        <td<?= $Page->year->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_running_year" class="el_doc_creden_running_year">
<span<?= $Page->year->viewAttributes() ?>>
<?= $Page->year->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->month->Visible) { // month ?>
        <td<?= $Page->month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_running_month" class="el_doc_creden_running_month">
<span<?= $Page->month->viewAttributes() ?>>
<?= $Page->month->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->running->Visible) { // running ?>
        <td<?= $Page->running->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_running_running" class="el_doc_creden_running_running">
<span<?= $Page->running->viewAttributes() ?>>
<?= $Page->running->getViewValue() ?></span>
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
