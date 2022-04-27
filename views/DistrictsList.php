<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DistrictsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { districts: currentTable } });
var currentForm, currentPageID;
var fdistrictslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdistrictslist = new ew.Form("fdistrictslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fdistrictslist;
    fdistrictslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fdistrictslist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> districts">
<form name="fdistrictslist" id="fdistrictslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="districts">
<div id="gmp_districts" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_districtslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->district_id->Visible) { // district_id ?>
        <th data-name="district_id" class="<?= $Page->district_id->headerCellClass() ?>"><div id="elh_districts_district_id" class="districts_district_id"><?= $Page->renderFieldHeader($Page->district_id) ?></div></th>
<?php } ?>
<?php if ($Page->district_code->Visible) { // district_code ?>
        <th data-name="district_code" class="<?= $Page->district_code->headerCellClass() ?>"><div id="elh_districts_district_code" class="districts_district_code"><?= $Page->renderFieldHeader($Page->district_code) ?></div></th>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <th data-name="province_id" class="<?= $Page->province_id->headerCellClass() ?>"><div id="elh_districts_province_id" class="districts_province_id"><?= $Page->renderFieldHeader($Page->province_id) ?></div></th>
<?php } ?>
<?php if ($Page->geo_id->Visible) { // geo_id ?>
        <th data-name="geo_id" class="<?= $Page->geo_id->headerCellClass() ?>"><div id="elh_districts_geo_id" class="districts_geo_id"><?= $Page->renderFieldHeader($Page->geo_id) ?></div></th>
<?php } ?>
<?php if ($Page->district_name->Visible) { // district_name ?>
        <th data-name="district_name" class="<?= $Page->district_name->headerCellClass() ?>"><div id="elh_districts_district_name" class="districts_district_name"><?= $Page->renderFieldHeader($Page->district_name) ?></div></th>
<?php } ?>
<?php if ($Page->district_name_en->Visible) { // district_name_en ?>
        <th data-name="district_name_en" class="<?= $Page->district_name_en->headerCellClass() ?>"><div id="elh_districts_district_name_en" class="districts_district_name_en"><?= $Page->renderFieldHeader($Page->district_name_en) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_districts",
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
    <?php if ($Page->district_id->Visible) { // district_id ?>
        <td data-name="district_id"<?= $Page->district_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_districts_district_id" class="el_districts_district_id">
<span<?= $Page->district_id->viewAttributes() ?>>
<?= $Page->district_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->district_code->Visible) { // district_code ?>
        <td data-name="district_code"<?= $Page->district_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_districts_district_code" class="el_districts_district_code">
<span<?= $Page->district_code->viewAttributes() ?>>
<?= $Page->district_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->province_id->Visible) { // province_id ?>
        <td data-name="province_id"<?= $Page->province_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_districts_province_id" class="el_districts_province_id">
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->geo_id->Visible) { // geo_id ?>
        <td data-name="geo_id"<?= $Page->geo_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_districts_geo_id" class="el_districts_geo_id">
<span<?= $Page->geo_id->viewAttributes() ?>>
<?= $Page->geo_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->district_name->Visible) { // district_name ?>
        <td data-name="district_name"<?= $Page->district_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_districts_district_name" class="el_districts_district_name">
<span<?= $Page->district_name->viewAttributes() ?>>
<?= $Page->district_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->district_name_en->Visible) { // district_name_en ?>
        <td data-name="district_name_en"<?= $Page->district_name_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_districts_district_name_en" class="el_districts_district_name_en">
<span<?= $Page->district_name_en->viewAttributes() ?>>
<?= $Page->district_name_en->getViewValue() ?></span>
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
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_districts",
        width: "100%",
        height: "500px"
    });
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("districts");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
