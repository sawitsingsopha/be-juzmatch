<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenRunningView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_running: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_runningview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_runningview = new ew.Form("fdoc_creden_runningview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fdoc_creden_runningview;
    loadjs.done("fdoc_creden_runningview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdoc_creden_runningview" id="fdoc_creden_runningview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_running">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->year->Visible) { // year ?>
    <tr id="r_year"<?= $Page->year->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_running_year"><?= $Page->year->caption() ?></span></td>
        <td data-name="year"<?= $Page->year->cellAttributes() ?>>
<span id="el_doc_creden_running_year">
<span<?= $Page->year->viewAttributes() ?>>
<?= $Page->year->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->month->Visible) { // month ?>
    <tr id="r_month"<?= $Page->month->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_running_month"><?= $Page->month->caption() ?></span></td>
        <td data-name="month"<?= $Page->month->cellAttributes() ?>>
<span id="el_doc_creden_running_month">
<span<?= $Page->month->viewAttributes() ?>>
<?= $Page->month->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->running->Visible) { // running ?>
    <tr id="r_running"<?= $Page->running->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_running_running"><?= $Page->running->caption() ?></span></td>
        <td data-name="running"<?= $Page->running->cellAttributes() ?>>
<span id="el_doc_creden_running_running">
<span<?= $Page->running->viewAttributes() ?>>
<?= $Page->running->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
