<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetRentList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset_rent: currentTable } });
var currentForm, currentPageID;
var fbuyer_asset_rentlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_rentlist = new ew.Form("fbuyer_asset_rentlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fbuyer_asset_rentlist;
    fbuyer_asset_rentlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fbuyer_asset_rentlist");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "buyer_asset") {
    if ($Page->MasterRecordExists) {
        include_once "views/BuyerAssetMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_asset_rent">
<form name="fbuyer_asset_rentlist" id="fbuyer_asset_rentlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset_rent">
<?php if ($Page->getCurrentMasterTable() == "buyer_asset" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_buyer_asset_rent" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_buyer_asset_rentlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_buyer_asset_rent_asset_id" class="buyer_asset_rent_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <th data-name="one_time_status" class="<?= $Page->one_time_status->headerCellClass() ?>"><div id="elh_buyer_asset_rent_one_time_status" class="buyer_asset_rent_one_time_status"><?= $Page->renderFieldHeader($Page->one_time_status) ?></div></th>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <th data-name="half_price_1" class="<?= $Page->half_price_1->headerCellClass() ?>"><div id="elh_buyer_asset_rent_half_price_1" class="buyer_asset_rent_half_price_1"><?= $Page->renderFieldHeader($Page->half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <th data-name="status_pay_half_price_1" class="<?= $Page->status_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_asset_rent_status_pay_half_price_1" class="buyer_asset_rent_status_pay_half_price_1"><?= $Page->renderFieldHeader($Page->status_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
        <th data-name="pay_number_half_price_1" class="<?= $Page->pay_number_half_price_1->headerCellClass() ?>"><div id="elh_buyer_asset_rent_pay_number_half_price_1" class="buyer_asset_rent_pay_number_half_price_1"><?= $Page->renderFieldHeader($Page->pay_number_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
        <th data-name="date_pay_half_price_1" class="<?= $Page->date_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_asset_rent_date_pay_half_price_1" class="buyer_asset_rent_date_pay_half_price_1"><?= $Page->renderFieldHeader($Page->date_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <th data-name="due_date_pay_half_price_1" class="<?= $Page->due_date_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_asset_rent_due_date_pay_half_price_1" class="buyer_asset_rent_due_date_pay_half_price_1"><?= $Page->renderFieldHeader($Page->due_date_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <th data-name="half_price_2" class="<?= $Page->half_price_2->headerCellClass() ?>"><div id="elh_buyer_asset_rent_half_price_2" class="buyer_asset_rent_half_price_2"><?= $Page->renderFieldHeader($Page->half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <th data-name="status_pay_half_price_2" class="<?= $Page->status_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_asset_rent_status_pay_half_price_2" class="buyer_asset_rent_status_pay_half_price_2"><?= $Page->renderFieldHeader($Page->status_pay_half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
        <th data-name="pay_number_half_price_2" class="<?= $Page->pay_number_half_price_2->headerCellClass() ?>"><div id="elh_buyer_asset_rent_pay_number_half_price_2" class="buyer_asset_rent_pay_number_half_price_2"><?= $Page->renderFieldHeader($Page->pay_number_half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
        <th data-name="date_pay_half_price_2" class="<?= $Page->date_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_asset_rent_date_pay_half_price_2" class="buyer_asset_rent_date_pay_half_price_2"><?= $Page->renderFieldHeader($Page->date_pay_half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <th data-name="due_date_pay_half_price_2" class="<?= $Page->due_date_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_asset_rent_due_date_pay_half_price_2" class="buyer_asset_rent_due_date_pay_half_price_2"><?= $Page->renderFieldHeader($Page->due_date_pay_half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_buyer_asset_rent_cdate" class="buyer_asset_rent_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_buyer_asset_rent",
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
    <?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_asset_id" class="el_buyer_asset_rent_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <td data-name="one_time_status"<?= $Page->one_time_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_one_time_status" class="el_buyer_asset_rent_one_time_status">
<span<?= $Page->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->one_time_status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <td data-name="half_price_1"<?= $Page->half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_half_price_1" class="el_buyer_asset_rent_half_price_1">
<span<?= $Page->half_price_1->viewAttributes() ?>>
<?= $Page->half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <td data-name="status_pay_half_price_1"<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_status_pay_half_price_1" class="el_buyer_asset_rent_status_pay_half_price_1">
<span<?= $Page->status_pay_half_price_1->viewAttributes() ?>>
<?= $Page->status_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
        <td data-name="pay_number_half_price_1"<?= $Page->pay_number_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_pay_number_half_price_1" class="el_buyer_asset_rent_pay_number_half_price_1">
<span<?= $Page->pay_number_half_price_1->viewAttributes() ?>>
<?= $Page->pay_number_half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
        <td data-name="date_pay_half_price_1"<?= $Page->date_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_date_pay_half_price_1" class="el_buyer_asset_rent_date_pay_half_price_1">
<span<?= $Page->date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <td data-name="due_date_pay_half_price_1"<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_due_date_pay_half_price_1" class="el_buyer_asset_rent_due_date_pay_half_price_1">
<span<?= $Page->due_date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <td data-name="half_price_2"<?= $Page->half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_half_price_2" class="el_buyer_asset_rent_half_price_2">
<span<?= $Page->half_price_2->viewAttributes() ?>>
<?= $Page->half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <td data-name="status_pay_half_price_2"<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_status_pay_half_price_2" class="el_buyer_asset_rent_status_pay_half_price_2">
<span<?= $Page->status_pay_half_price_2->viewAttributes() ?>>
<?= $Page->status_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
        <td data-name="pay_number_half_price_2"<?= $Page->pay_number_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_pay_number_half_price_2" class="el_buyer_asset_rent_pay_number_half_price_2">
<span<?= $Page->pay_number_half_price_2->viewAttributes() ?>>
<?= $Page->pay_number_half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
        <td data-name="date_pay_half_price_2"<?= $Page->date_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_date_pay_half_price_2" class="el_buyer_asset_rent_date_pay_half_price_2">
<span<?= $Page->date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->date_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <td data-name="due_date_pay_half_price_2"<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_due_date_pay_half_price_2" class="el_buyer_asset_rent_due_date_pay_half_price_2">
<span<?= $Page->due_date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_rent_cdate" class="el_buyer_asset_rent_cdate">
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
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_buyer_asset_rent",
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
    ew.addEventHandlers("buyer_asset_rent");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
