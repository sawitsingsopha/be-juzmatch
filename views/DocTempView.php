<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocTempView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_temp: currentTable } });
var currentForm, currentPageID;
var fdoc_tempview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_tempview = new ew.Form("fdoc_tempview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fdoc_tempview;
    loadjs.done("fdoc_tempview");
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
<form name="fdoc_tempview" id="fdoc_tempview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_temp">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->doc_temp_type->Visible) { // doc_temp_type ?>
    <tr id="r_doc_temp_type"<?= $Page->doc_temp_type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_doc_temp_type"><?= $Page->doc_temp_type->caption() ?></span></td>
        <td data-name="doc_temp_type"<?= $Page->doc_temp_type->cellAttributes() ?>>
<span id="el_doc_temp_doc_temp_type">
<span<?= $Page->doc_temp_type->viewAttributes() ?>>
<?= $Page->doc_temp_type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_temp_name->Visible) { // doc_temp_name ?>
    <tr id="r_doc_temp_name"<?= $Page->doc_temp_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_doc_temp_name"><?= $Page->doc_temp_name->caption() ?></span></td>
        <td data-name="doc_temp_name"<?= $Page->doc_temp_name->cellAttributes() ?>>
<span id="el_doc_temp_doc_temp_name">
<span<?= $Page->doc_temp_name->viewAttributes() ?>>
<?= $Page->doc_temp_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_temp_file->Visible) { // doc_temp_file ?>
    <tr id="r_doc_temp_file"<?= $Page->doc_temp_file->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_doc_temp_file"><?= $Page->doc_temp_file->caption() ?></span></td>
        <td data-name="doc_temp_file"<?= $Page->doc_temp_file->cellAttributes() ?>>
<span id="el_doc_temp_doc_temp_file">
<span<?= $Page->doc_temp_file->viewAttributes() ?>>
<?= GetFileViewTag($Page->doc_temp_file, $Page->doc_temp_file->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <tr id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_active_status"><?= $Page->active_status->caption() ?></span></td>
        <td data-name="active_status"<?= $Page->active_status->cellAttributes() ?>>
<span id="el_doc_temp_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->esign_page1->Visible) { // esign_page1 ?>
    <tr id="r_esign_page1"<?= $Page->esign_page1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_esign_page1"><?= $Page->esign_page1->caption() ?></span></td>
        <td data-name="esign_page1"<?= $Page->esign_page1->cellAttributes() ?>>
<span id="el_doc_temp_esign_page1">
<span<?= $Page->esign_page1->viewAttributes() ?>>
<?= $Page->esign_page1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->esign_page2->Visible) { // esign_page2 ?>
    <tr id="r_esign_page2"<?= $Page->esign_page2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_esign_page2"><?= $Page->esign_page2->caption() ?></span></td>
        <td data-name="esign_page2"<?= $Page->esign_page2->cellAttributes() ?>>
<span id="el_doc_temp_esign_page2">
<span<?= $Page->esign_page2->viewAttributes() ?>>
<?= $Page->esign_page2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_temp_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_temp_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
