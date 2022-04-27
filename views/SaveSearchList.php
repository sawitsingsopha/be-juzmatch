<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveSearchList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { save_search: currentTable } });
var currentForm, currentPageID;
var fsave_searchlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_searchlist = new ew.Form("fsave_searchlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fsave_searchlist;
    fsave_searchlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fsave_searchlist");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "buyer") {
    if ($Page->MasterRecordExists) {
        include_once "views/BuyerMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> save_search">
<form name="fsave_searchlist" id="fsave_searchlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="save_search">
<?php if ($Page->getCurrentMasterTable() == "buyer" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_save_search" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_save_searchlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->category_id->Visible) { // category_id ?>
        <th data-name="category_id" class="<?= $Page->category_id->headerCellClass() ?>"><div id="elh_save_search_category_id" class="save_search_category_id"><?= $Page->renderFieldHeader($Page->category_id) ?></div></th>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <th data-name="brand_id" class="<?= $Page->brand_id->headerCellClass() ?>"><div id="elh_save_search_brand_id" class="save_search_brand_id"><?= $Page->renderFieldHeader($Page->brand_id) ?></div></th>
<?php } ?>
<?php if ($Page->min_installment->Visible) { // min_installment ?>
        <th data-name="min_installment" class="<?= $Page->min_installment->headerCellClass() ?>"><div id="elh_save_search_min_installment" class="save_search_min_installment"><?= $Page->renderFieldHeader($Page->min_installment) ?></div></th>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
        <th data-name="max_installment" class="<?= $Page->max_installment->headerCellClass() ?>"><div id="elh_save_search_max_installment" class="save_search_max_installment"><?= $Page->renderFieldHeader($Page->max_installment) ?></div></th>
<?php } ?>
<?php if ($Page->min_down->Visible) { // min_down ?>
        <th data-name="min_down" class="<?= $Page->min_down->headerCellClass() ?>"><div id="elh_save_search_min_down" class="save_search_min_down"><?= $Page->renderFieldHeader($Page->min_down) ?></div></th>
<?php } ?>
<?php if ($Page->max_down->Visible) { // max_down ?>
        <th data-name="max_down" class="<?= $Page->max_down->headerCellClass() ?>"><div id="elh_save_search_max_down" class="save_search_max_down"><?= $Page->renderFieldHeader($Page->max_down) ?></div></th>
<?php } ?>
<?php if ($Page->min_price->Visible) { // min_price ?>
        <th data-name="min_price" class="<?= $Page->min_price->headerCellClass() ?>"><div id="elh_save_search_min_price" class="save_search_min_price"><?= $Page->renderFieldHeader($Page->min_price) ?></div></th>
<?php } ?>
<?php if ($Page->max_price->Visible) { // max_price ?>
        <th data-name="max_price" class="<?= $Page->max_price->headerCellClass() ?>"><div id="elh_save_search_max_price" class="save_search_max_price"><?= $Page->renderFieldHeader($Page->max_price) ?></div></th>
<?php } ?>
<?php if ($Page->usable_area_min->Visible) { // usable_area_min ?>
        <th data-name="usable_area_min" class="<?= $Page->usable_area_min->headerCellClass() ?>"><div id="elh_save_search_usable_area_min" class="save_search_usable_area_min"><?= $Page->renderFieldHeader($Page->usable_area_min) ?></div></th>
<?php } ?>
<?php if ($Page->usable_area_max->Visible) { // usable_area_max ?>
        <th data-name="usable_area_max" class="<?= $Page->usable_area_max->headerCellClass() ?>"><div id="elh_save_search_usable_area_max" class="save_search_usable_area_max"><?= $Page->renderFieldHeader($Page->usable_area_max) ?></div></th>
<?php } ?>
<?php if ($Page->land_size_area_min->Visible) { // land_size_area_min ?>
        <th data-name="land_size_area_min" class="<?= $Page->land_size_area_min->headerCellClass() ?>"><div id="elh_save_search_land_size_area_min" class="save_search_land_size_area_min"><?= $Page->renderFieldHeader($Page->land_size_area_min) ?></div></th>
<?php } ?>
<?php if ($Page->land_size_area_max->Visible) { // land_size_area_max ?>
        <th data-name="land_size_area_max" class="<?= $Page->land_size_area_max->headerCellClass() ?>"><div id="elh_save_search_land_size_area_max" class="save_search_land_size_area_max"><?= $Page->renderFieldHeader($Page->land_size_area_max) ?></div></th>
<?php } ?>
<?php if ($Page->bedroom->Visible) { // bedroom ?>
        <th data-name="bedroom" class="<?= $Page->bedroom->headerCellClass() ?>"><div id="elh_save_search_bedroom" class="save_search_bedroom"><?= $Page->renderFieldHeader($Page->bedroom) ?></div></th>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
        <th data-name="latitude" class="<?= $Page->latitude->headerCellClass() ?>"><div id="elh_save_search_latitude" class="save_search_latitude"><?= $Page->renderFieldHeader($Page->latitude) ?></div></th>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
        <th data-name="longitude" class="<?= $Page->longitude->headerCellClass() ?>"><div id="elh_save_search_longitude" class="save_search_longitude"><?= $Page->renderFieldHeader($Page->longitude) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_save_search_cdate" class="save_search_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_save_search",
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
    <?php if ($Page->category_id->Visible) { // category_id ?>
        <td data-name="category_id"<?= $Page->category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_category_id" class="el_save_search_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<?= $Page->category_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->brand_id->Visible) { // brand_id ?>
        <td data-name="brand_id"<?= $Page->brand_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_brand_id" class="el_save_search_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->min_installment->Visible) { // min_installment ?>
        <td data-name="min_installment"<?= $Page->min_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_min_installment" class="el_save_search_min_installment">
<span<?= $Page->min_installment->viewAttributes() ?>>
<?= $Page->min_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->max_installment->Visible) { // max_installment ?>
        <td data-name="max_installment"<?= $Page->max_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_max_installment" class="el_save_search_max_installment">
<span<?= $Page->max_installment->viewAttributes() ?>>
<?= $Page->max_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->min_down->Visible) { // min_down ?>
        <td data-name="min_down"<?= $Page->min_down->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_min_down" class="el_save_search_min_down">
<span<?= $Page->min_down->viewAttributes() ?>>
<?= $Page->min_down->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->max_down->Visible) { // max_down ?>
        <td data-name="max_down"<?= $Page->max_down->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_max_down" class="el_save_search_max_down">
<span<?= $Page->max_down->viewAttributes() ?>>
<?= $Page->max_down->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->min_price->Visible) { // min_price ?>
        <td data-name="min_price"<?= $Page->min_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_min_price" class="el_save_search_min_price">
<span<?= $Page->min_price->viewAttributes() ?>>
<?= $Page->min_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->max_price->Visible) { // max_price ?>
        <td data-name="max_price"<?= $Page->max_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_max_price" class="el_save_search_max_price">
<span<?= $Page->max_price->viewAttributes() ?>>
<?= $Page->max_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usable_area_min->Visible) { // usable_area_min ?>
        <td data-name="usable_area_min"<?= $Page->usable_area_min->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_usable_area_min" class="el_save_search_usable_area_min">
<span<?= $Page->usable_area_min->viewAttributes() ?>>
<?= $Page->usable_area_min->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usable_area_max->Visible) { // usable_area_max ?>
        <td data-name="usable_area_max"<?= $Page->usable_area_max->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_usable_area_max" class="el_save_search_usable_area_max">
<span<?= $Page->usable_area_max->viewAttributes() ?>>
<?= $Page->usable_area_max->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->land_size_area_min->Visible) { // land_size_area_min ?>
        <td data-name="land_size_area_min"<?= $Page->land_size_area_min->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_land_size_area_min" class="el_save_search_land_size_area_min">
<span<?= $Page->land_size_area_min->viewAttributes() ?>>
<?= $Page->land_size_area_min->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->land_size_area_max->Visible) { // land_size_area_max ?>
        <td data-name="land_size_area_max"<?= $Page->land_size_area_max->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_land_size_area_max" class="el_save_search_land_size_area_max">
<span<?= $Page->land_size_area_max->viewAttributes() ?>>
<?= $Page->land_size_area_max->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bedroom->Visible) { // bedroom ?>
        <td data-name="bedroom"<?= $Page->bedroom->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_bedroom" class="el_save_search_bedroom">
<span<?= $Page->bedroom->viewAttributes() ?>>
<?= $Page->bedroom->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->latitude->Visible) { // latitude ?>
        <td data-name="latitude"<?= $Page->latitude->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_latitude" class="el_save_search_latitude">
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->longitude->Visible) { // longitude ?>
        <td data-name="longitude"<?= $Page->longitude->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_longitude" class="el_save_search_longitude">
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_search_cdate" class="el_save_search_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
    ew.addEventHandlers("save_search");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
