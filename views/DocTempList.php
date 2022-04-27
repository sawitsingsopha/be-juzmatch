<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocTempList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_temp: currentTable } });
var currentForm, currentPageID;
var fdoc_templist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_templist = new ew.Form("fdoc_templist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fdoc_templist;
    fdoc_templist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fdoc_templist");
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.ready("head", ew.PATH_BASE + "js/preview.min.js", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doc_temp">
<form name="fdoc_templist" id="fdoc_templist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_temp">
<div id="gmp_doc_temp" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_doc_templist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->doc_temp_type->Visible) { // doc_temp_type ?>
        <th data-name="doc_temp_type" class="<?= $Page->doc_temp_type->headerCellClass() ?>"><div id="elh_doc_temp_doc_temp_type" class="doc_temp_doc_temp_type"><?= $Page->renderFieldHeader($Page->doc_temp_type) ?></div></th>
<?php } ?>
<?php if ($Page->doc_temp_name->Visible) { // doc_temp_name ?>
        <th data-name="doc_temp_name" class="<?= $Page->doc_temp_name->headerCellClass() ?>"><div id="elh_doc_temp_doc_temp_name" class="doc_temp_doc_temp_name"><?= $Page->renderFieldHeader($Page->doc_temp_name) ?></div></th>
<?php } ?>
<?php if ($Page->doc_temp_file->Visible) { // doc_temp_file ?>
        <th data-name="doc_temp_file" class="<?= $Page->doc_temp_file->headerCellClass() ?>"><div id="elh_doc_temp_doc_temp_file" class="doc_temp_doc_temp_file"><?= $Page->renderFieldHeader($Page->doc_temp_file) ?></div></th>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
        <th data-name="active_status" class="<?= $Page->active_status->headerCellClass() ?>"><div id="elh_doc_temp_active_status" class="doc_temp_active_status"><?= $Page->renderFieldHeader($Page->active_status) ?></div></th>
<?php } ?>
<?php if ($Page->esign_page1->Visible) { // esign_page1 ?>
        <th data-name="esign_page1" class="<?= $Page->esign_page1->headerCellClass() ?>"><div id="elh_doc_temp_esign_page1" class="doc_temp_esign_page1"><?= $Page->renderFieldHeader($Page->esign_page1) ?></div></th>
<?php } ?>
<?php if ($Page->esign_page2->Visible) { // esign_page2 ?>
        <th data-name="esign_page2" class="<?= $Page->esign_page2->headerCellClass() ?>"><div id="elh_doc_temp_esign_page2" class="doc_temp_esign_page2"><?= $Page->renderFieldHeader($Page->esign_page2) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_doc_temp",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->doc_temp_type->Visible) { // doc_temp_type ?>
        <td data-name="doc_temp_type"<?= $Page->doc_temp_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_doc_temp_type" class="el_doc_temp_doc_temp_type">
<span<?= $Page->doc_temp_type->viewAttributes() ?>>
<?= $Page->doc_temp_type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_temp_name->Visible) { // doc_temp_name ?>
        <td data-name="doc_temp_name"<?= $Page->doc_temp_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_doc_temp_name" class="el_doc_temp_doc_temp_name">
<span<?= $Page->doc_temp_name->viewAttributes() ?>>
<?= $Page->doc_temp_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_temp_file->Visible) { // doc_temp_file ?>
        <td data-name="doc_temp_file"<?= $Page->doc_temp_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_doc_temp_file" class="el_doc_temp_doc_temp_file">
<span<?= $Page->doc_temp_file->viewAttributes() ?>>
<?= GetFileViewTag($Page->doc_temp_file, $Page->doc_temp_file->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->active_status->Visible) { // active_status ?>
        <td data-name="active_status"<?= $Page->active_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_active_status" class="el_doc_temp_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->esign_page1->Visible) { // esign_page1 ?>
        <td data-name="esign_page1"<?= $Page->esign_page1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_esign_page1" class="el_doc_temp_esign_page1">
<span<?= $Page->esign_page1->viewAttributes() ?>>
<?= $Page->esign_page1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->esign_page2->Visible) { // esign_page2 ?>
        <td data-name="esign_page2"<?= $Page->esign_page2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_temp_esign_page2" class="el_doc_temp_esign_page2">
<span<?= $Page->esign_page2->viewAttributes() ?>>
<?= $Page->esign_page2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("doc_temp");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
