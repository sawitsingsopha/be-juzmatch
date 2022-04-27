<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetAttributeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_attribute: currentTable } });
var currentForm, currentPageID;
var fasset_attributelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_attributelist = new ew.Form("fasset_attributelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fasset_attributelist;
    fasset_attributelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fasset_attributelist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_attribute">
<form name="fasset_attributelist" id="fasset_attributelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_attribute">
<div id="gmp_asset_attribute" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_asset_attributelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->asset_attribute_id->Visible) { // asset_attribute_id ?>
        <th data-name="asset_attribute_id" class="<?= $Page->asset_attribute_id->headerCellClass() ?>"><div id="elh_asset_attribute_asset_attribute_id" class="asset_attribute_asset_attribute_id"><?= $Page->renderFieldHeader($Page->asset_attribute_id) ?></div></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_asset_attribute_asset_id" class="asset_attribute_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->attribute_id->Visible) { // attribute_id ?>
        <th data-name="attribute_id" class="<?= $Page->attribute_id->headerCellClass() ?>"><div id="elh_asset_attribute_attribute_id" class="asset_attribute_attribute_id"><?= $Page->renderFieldHeader($Page->attribute_id) ?></div></th>
<?php } ?>
<?php if ($Page->attribute_detail_id->Visible) { // attribute_detail_id ?>
        <th data-name="attribute_detail_id" class="<?= $Page->attribute_detail_id->headerCellClass() ?>"><div id="elh_asset_attribute_attribute_detail_id" class="asset_attribute_attribute_detail_id"><?= $Page->renderFieldHeader($Page->attribute_detail_id) ?></div></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Page->isactive->headerCellClass() ?>"><div id="elh_asset_attribute_isactive" class="asset_attribute_isactive"><?= $Page->renderFieldHeader($Page->isactive) ?></div></th>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <th data-name="order_by" class="<?= $Page->order_by->headerCellClass() ?>"><div id="elh_asset_attribute_order_by" class="asset_attribute_order_by"><?= $Page->renderFieldHeader($Page->order_by) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_asset_attribute_cdate" class="asset_attribute_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_asset_attribute_cuser" class="asset_attribute_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_asset_attribute_cip" class="asset_attribute_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_asset_attribute_udate" class="asset_attribute_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_asset_attribute_uip" class="asset_attribute_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_asset_attribute_uuser" class="asset_attribute_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_asset_attribute",
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
    <?php if ($Page->asset_attribute_id->Visible) { // asset_attribute_id ?>
        <td data-name="asset_attribute_id"<?= $Page->asset_attribute_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_asset_attribute_id" class="el_asset_attribute_asset_attribute_id">
<span<?= $Page->asset_attribute_id->viewAttributes() ?>>
<?= $Page->asset_attribute_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_asset_id" class="el_asset_attribute_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->attribute_id->Visible) { // attribute_id ?>
        <td data-name="attribute_id"<?= $Page->attribute_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_attribute_id" class="el_asset_attribute_attribute_id">
<span<?= $Page->attribute_id->viewAttributes() ?>>
<?= $Page->attribute_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->attribute_detail_id->Visible) { // attribute_detail_id ?>
        <td data-name="attribute_detail_id"<?= $Page->attribute_detail_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_attribute_detail_id" class="el_asset_attribute_attribute_detail_id">
<span<?= $Page->attribute_detail_id->viewAttributes() ?>>
<?= $Page->attribute_detail_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isactive->Visible) { // isactive ?>
        <td data-name="isactive"<?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_isactive" class="el_asset_attribute_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->order_by->Visible) { // order_by ?>
        <td data-name="order_by"<?= $Page->order_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_order_by" class="el_asset_attribute_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_cdate" class="el_asset_attribute_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_cuser" class="el_asset_attribute_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_cip" class="el_asset_attribute_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_udate" class="el_asset_attribute_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_uip" class="el_asset_attribute_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_attribute_uuser" class="el_asset_attribute_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
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
    ew.addEventHandlers("asset_attribute");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
