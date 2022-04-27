<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AmphurList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { amphur: currentTable } });
var currentForm, currentPageID;
var famphurlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    famphurlist = new ew.Form("famphurlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = famphurlist;
    famphurlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("famphurlist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> amphur">
<form name="famphurlist" id="famphurlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="amphur">
<div id="gmp_amphur" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_amphurlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
        <th data-name="amphur_id" class="<?= $Page->amphur_id->headerCellClass() ?>"><div id="elh_amphur_amphur_id" class="amphur_amphur_id"><?= $Page->renderFieldHeader($Page->amphur_id) ?></div></th>
<?php } ?>
<?php if ($Page->amphur_code->Visible) { // amphur_code ?>
        <th data-name="amphur_code" class="<?= $Page->amphur_code->headerCellClass() ?>"><div id="elh_amphur_amphur_code" class="amphur_amphur_code"><?= $Page->renderFieldHeader($Page->amphur_code) ?></div></th>
<?php } ?>
<?php if ($Page->amphur_name->Visible) { // amphur_name ?>
        <th data-name="amphur_name" class="<?= $Page->amphur_name->headerCellClass() ?>"><div id="elh_amphur_amphur_name" class="amphur_amphur_name"><?= $Page->renderFieldHeader($Page->amphur_name) ?></div></th>
<?php } ?>
<?php if ($Page->amphur_name_en->Visible) { // amphur_name_en ?>
        <th data-name="amphur_name_en" class="<?= $Page->amphur_name_en->headerCellClass() ?>"><div id="elh_amphur_amphur_name_en" class="amphur_amphur_name_en"><?= $Page->renderFieldHeader($Page->amphur_name_en) ?></div></th>
<?php } ?>
<?php if ($Page->geo_id->Visible) { // geo_id ?>
        <th data-name="geo_id" class="<?= $Page->geo_id->headerCellClass() ?>"><div id="elh_amphur_geo_id" class="amphur_geo_id"><?= $Page->renderFieldHeader($Page->geo_id) ?></div></th>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <th data-name="province_id" class="<?= $Page->province_id->headerCellClass() ?>"><div id="elh_amphur_province_id" class="amphur_province_id"><?= $Page->renderFieldHeader($Page->province_id) ?></div></th>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
        <th data-name="postcode" class="<?= $Page->postcode->headerCellClass() ?>"><div id="elh_amphur_postcode" class="amphur_postcode"><?= $Page->renderFieldHeader($Page->postcode) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_amphur",
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
    <?php if ($Page->amphur_id->Visible) { // amphur_id ?>
        <td data-name="amphur_id"<?= $Page->amphur_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_amphur_id" class="el_amphur_amphur_id">
<span<?= $Page->amphur_id->viewAttributes() ?>>
<?= $Page->amphur_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amphur_code->Visible) { // amphur_code ?>
        <td data-name="amphur_code"<?= $Page->amphur_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_amphur_code" class="el_amphur_amphur_code">
<span<?= $Page->amphur_code->viewAttributes() ?>>
<?= $Page->amphur_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amphur_name->Visible) { // amphur_name ?>
        <td data-name="amphur_name"<?= $Page->amphur_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_amphur_name" class="el_amphur_amphur_name">
<span<?= $Page->amphur_name->viewAttributes() ?>>
<?= $Page->amphur_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amphur_name_en->Visible) { // amphur_name_en ?>
        <td data-name="amphur_name_en"<?= $Page->amphur_name_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_amphur_name_en" class="el_amphur_amphur_name_en">
<span<?= $Page->amphur_name_en->viewAttributes() ?>>
<?= $Page->amphur_name_en->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->geo_id->Visible) { // geo_id ?>
        <td data-name="geo_id"<?= $Page->geo_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_geo_id" class="el_amphur_geo_id">
<span<?= $Page->geo_id->viewAttributes() ?>>
<?= $Page->geo_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->province_id->Visible) { // province_id ?>
        <td data-name="province_id"<?= $Page->province_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_province_id" class="el_amphur_province_id">
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->postcode->Visible) { // postcode ?>
        <td data-name="postcode"<?= $Page->postcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_amphur_postcode" class="el_amphur_postcode">
<span<?= $Page->postcode->viewAttributes() ?>>
<?= $Page->postcode->getViewValue() ?></span>
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
    ew.addEventHandlers("amphur");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
