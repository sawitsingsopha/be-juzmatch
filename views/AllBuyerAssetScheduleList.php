<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllBuyerAssetScheduleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_buyer_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fall_buyer_asset_schedulelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_buyer_asset_schedulelist = new ew.Form("fall_buyer_asset_schedulelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fall_buyer_asset_schedulelist;
    fall_buyer_asset_schedulelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fall_buyer_asset_schedulelist");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if ($Security->canImport()) { ?>
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
<?php } ?>


<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "all_buyer_config_asset_schedule") {
    if ($Page->MasterRecordExists) {
        include_once "views/AllBuyerConfigAssetScheduleMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "number_deals_available") {
    if ($Page->MasterRecordExists) {
        include_once "views/NumberDealsAvailableMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "number_of_accrued") {
    if ($Page->MasterRecordExists) {
        include_once "views/NumberOfAccruedMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "number_of_unpaid_units") {
    if ($Page->MasterRecordExists) {
        include_once "views/NumberOfUnpaidUnitsMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "outstanding_amount") {
    if ($Page->MasterRecordExists) {
        include_once "views/OutstandingAmountMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> all_buyer_asset_schedule">
<form name="fall_buyer_asset_schedulelist" id="fall_buyer_asset_schedulelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_buyer_asset_schedule">
<?php if ($Page->getCurrentMasterTable() == "all_buyer_config_asset_schedule" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="all_buyer_config_asset_schedule">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "number_deals_available" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="number_deals_available">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "number_of_accrued" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="number_of_accrued">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "number_of_unpaid_units" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="number_of_unpaid_units">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "outstanding_amount" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="outstanding_amount">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_all_buyer_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_all_buyer_asset_schedulelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <th data-name="num_installment" class="<?= $Page->num_installment->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_num_installment" class="all_buyer_asset_schedule_num_installment"><?= $Page->renderFieldHeader($Page->num_installment) ?></div></th>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <th data-name="installment_per_price" class="<?= $Page->installment_per_price->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_installment_per_price" class="all_buyer_asset_schedule_installment_per_price"><?= $Page->renderFieldHeader($Page->installment_per_price) ?></div></th>
<?php } ?>
<?php if ($Page->interest->Visible) { // interest ?>
        <th data-name="interest" class="<?= $Page->interest->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_interest" class="all_buyer_asset_schedule_interest"><?= $Page->renderFieldHeader($Page->interest) ?></div></th>
<?php } ?>
<?php if ($Page->principal->Visible) { // principal ?>
        <th data-name="principal" class="<?= $Page->principal->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_principal" class="all_buyer_asset_schedule_principal"><?= $Page->renderFieldHeader($Page->principal) ?></div></th>
<?php } ?>
<?php if ($Page->remaining_principal->Visible) { // remaining_principal ?>
        <th data-name="remaining_principal" class="<?= $Page->remaining_principal->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_remaining_principal" class="all_buyer_asset_schedule_remaining_principal"><?= $Page->renderFieldHeader($Page->remaining_principal) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Page->pay_number->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_pay_number" class="all_buyer_asset_schedule_pay_number"><?= $Page->renderFieldHeader($Page->pay_number) ?></div></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Page->expired_date->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_expired_date" class="all_buyer_asset_schedule_expired_date"><?= $Page->renderFieldHeader($Page->expired_date) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_date_payment" class="all_buyer_asset_schedule_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_status_payment" class="all_buyer_asset_schedule_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_all_buyer_asset_schedule_cdate" class="all_buyer_asset_schedule_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_all_buyer_asset_schedule",
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
    <?php if ($Page->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment"<?= $Page->num_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_num_installment" class="el_all_buyer_asset_schedule_num_installment">
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price"<?= $Page->installment_per_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_installment_per_price" class="el_all_buyer_asset_schedule_installment_per_price">
<span<?= $Page->installment_per_price->viewAttributes() ?>>
<?= $Page->installment_per_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->interest->Visible) { // interest ?>
        <td data-name="interest"<?= $Page->interest->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_interest" class="el_all_buyer_asset_schedule_interest">
<span<?= $Page->interest->viewAttributes() ?>>
<?= $Page->interest->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->principal->Visible) { // principal ?>
        <td data-name="principal"<?= $Page->principal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_principal" class="el_all_buyer_asset_schedule_principal">
<span<?= $Page->principal->viewAttributes() ?>>
<?= $Page->principal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remaining_principal->Visible) { // remaining_principal ?>
        <td data-name="remaining_principal"<?= $Page->remaining_principal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_remaining_principal" class="el_all_buyer_asset_schedule_remaining_principal">
<span<?= $Page->remaining_principal->viewAttributes() ?>>
<?= $Page->remaining_principal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_pay_number" class="el_all_buyer_asset_schedule_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_expired_date" class="el_all_buyer_asset_schedule_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_date_payment" class="el_all_buyer_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_status_payment" class="el_all_buyer_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_all_buyer_asset_schedule_cdate" class="el_all_buyer_asset_schedule_cdate">
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
    ew.addEventHandlers("all_buyer_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    var rowCount = $('#tbl_buyer_all_asset_rentlist >tbody >tr').length;
    if(rowCount >= 1){
        $(".ew-add-edit-option").remove()
    }

    $(".ew-list-other-options").hide();

	$('th[data-name="view"]').hide();
	$('td[data-name="view"]').hide();
	$('th[data-name="edit"]').hide();
	$('td[data-name="edit"]').hide();

});
</script>
<?php } ?>
