<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerConfigAssetScheduleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_config_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fbuyer_config_asset_schedulelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_config_asset_schedulelist = new ew.Form("fbuyer_config_asset_schedulelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fbuyer_config_asset_schedulelist;
    fbuyer_config_asset_schedulelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fbuyer_config_asset_schedulelist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_config_asset_schedule">
<form name="fbuyer_config_asset_schedulelist" id="fbuyer_config_asset_schedulelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_config_asset_schedule">
<?php if ($Page->getCurrentMasterTable() == "buyer_asset" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_buyer_config_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_buyer_config_asset_schedulelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <th data-name="installment_all" class="<?= $Page->installment_all->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_installment_all" class="buyer_config_asset_schedule_installment_all"><?= $Page->renderFieldHeader($Page->installment_all) ?></div></th>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <th data-name="installment_price_per" class="<?= $Page->installment_price_per->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_installment_price_per" class="buyer_config_asset_schedule_installment_price_per"><?= $Page->renderFieldHeader($Page->installment_price_per) ?></div></th>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <th data-name="date_start_installment" class="<?= $Page->date_start_installment->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_date_start_installment" class="buyer_config_asset_schedule_date_start_installment"><?= $Page->renderFieldHeader($Page->date_start_installment) ?></div></th>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
        <th data-name="status_approve" class="<?= $Page->status_approve->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_buyer_config_asset_schedule_status_approve" class="buyer_config_asset_schedule_status_approve"><?= $Page->renderFieldHeader($Page->status_approve) ?></div></th>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <th data-name="asset_price" class="<?= $Page->asset_price->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_asset_price" class="buyer_config_asset_schedule_asset_price"><?= $Page->renderFieldHeader($Page->asset_price) ?></div></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th data-name="booking_price" class="<?= $Page->booking_price->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_booking_price" class="buyer_config_asset_schedule_booking_price"><?= $Page->renderFieldHeader($Page->booking_price) ?></div></th>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
        <th data-name="down_price" class="<?= $Page->down_price->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_down_price" class="buyer_config_asset_schedule_down_price"><?= $Page->renderFieldHeader($Page->down_price) ?></div></th>
<?php } ?>
<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <th data-name="move_in_on_20th" class="<?= $Page->move_in_on_20th->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_move_in_on_20th" class="buyer_config_asset_schedule_move_in_on_20th"><?= $Page->renderFieldHeader($Page->move_in_on_20th) ?></div></th>
<?php } ?>
<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <th data-name="number_days_pay_first_month" class="<?= $Page->number_days_pay_first_month->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_number_days_pay_first_month" class="buyer_config_asset_schedule_number_days_pay_first_month"><?= $Page->renderFieldHeader($Page->number_days_pay_first_month) ?></div></th>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <th data-name="number_days_in_first_month" class="<?= $Page->number_days_in_first_month->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_number_days_in_first_month" class="buyer_config_asset_schedule_number_days_in_first_month"><?= $Page->renderFieldHeader($Page->number_days_in_first_month) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_buyer_config_asset_schedule_cdate" class="buyer_config_asset_schedule_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_buyer_config_asset_schedule",
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
    <?php if ($Page->installment_all->Visible) { // installment_all ?>
        <td data-name="installment_all"<?= $Page->installment_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_installment_all" class="el_buyer_config_asset_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <td data-name="installment_price_per"<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_installment_price_per" class="el_buyer_config_asset_schedule_installment_price_per">
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <td data-name="date_start_installment"<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_date_start_installment" class="el_buyer_config_asset_schedule_date_start_installment">
<span<?= $Page->date_start_installment->viewAttributes() ?>>
<?= $Page->date_start_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_approve->Visible) { // status_approve ?>
        <td data-name="status_approve"<?= $Page->status_approve->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_status_approve" class="el_buyer_config_asset_schedule_status_approve">
<span<?= $Page->status_approve->viewAttributes() ?>>
<?= $Page->status_approve->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_price->Visible) { // asset_price ?>
        <td data-name="asset_price"<?= $Page->asset_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_asset_price" class="el_buyer_config_asset_schedule_asset_price">
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_booking_price" class="el_buyer_config_asset_schedule_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->down_price->Visible) { // down_price ?>
        <td data-name="down_price"<?= $Page->down_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_down_price" class="el_buyer_config_asset_schedule_down_price">
<span<?= $Page->down_price->viewAttributes() ?>>
<?= $Page->down_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <td data-name="move_in_on_20th"<?= $Page->move_in_on_20th->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_move_in_on_20th" class="el_buyer_config_asset_schedule_move_in_on_20th">
<span<?= $Page->move_in_on_20th->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_move_in_on_20th_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->move_in_on_20th->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->move_in_on_20th->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_move_in_on_20th_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <td data-name="number_days_pay_first_month"<?= $Page->number_days_pay_first_month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_number_days_pay_first_month" class="el_buyer_config_asset_schedule_number_days_pay_first_month">
<span<?= $Page->number_days_pay_first_month->viewAttributes() ?>>
<?= $Page->number_days_pay_first_month->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <td data-name="number_days_in_first_month"<?= $Page->number_days_in_first_month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_number_days_in_first_month" class="el_buyer_config_asset_schedule_number_days_in_first_month">
<span<?= $Page->number_days_in_first_month->viewAttributes() ?>>
<?= $Page->number_days_in_first_month->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_config_asset_schedule_cdate" class="el_buyer_config_asset_schedule_cdate">
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
        container: "gmp_buyer_config_asset_schedule",
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
    ew.addEventHandlers("buyer_config_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
