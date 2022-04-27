<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset: currentTable } });
var currentForm, currentPageID;
var fbuyer_assetlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_assetlist = new ew.Form("fbuyer_assetlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fbuyer_assetlist;
    fbuyer_assetlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fbuyer_assetlist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_asset">
<form name="fbuyer_assetlist" id="fbuyer_assetlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset">
<?php if ($Page->getCurrentMasterTable() == "buyer" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_buyer_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_buyer_assetlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_buyer_asset_asset_id" class="buyer_asset_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th data-name="booking_price" class="<?= $Page->booking_price->headerCellClass() ?>"><div id="elh_buyer_asset_booking_price" class="buyer_asset_booking_price"><?= $Page->renderFieldHeader($Page->booking_price) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Page->pay_number->headerCellClass() ?>"><div id="elh_buyer_asset_pay_number" class="buyer_asset_pay_number"><?= $Page->renderFieldHeader($Page->pay_number) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_buyer_asset_status_payment" class="buyer_asset_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Page->date_booking->headerCellClass() ?>"><div id="elh_buyer_asset_date_booking" class="buyer_asset_date_booking"><?= $Page->renderFieldHeader($Page->date_booking) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_buyer_asset_date_payment" class="buyer_asset_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <th data-name="due_date" class="<?= $Page->due_date->headerCellClass() ?>"><div id="elh_buyer_asset_due_date" class="buyer_asset_due_date"><?= $Page->renderFieldHeader($Page->due_date) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_buyer_asset_cdate" class="buyer_asset_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Page->status_expire->headerCellClass() ?>"><div id="elh_buyer_asset_status_expire" class="buyer_asset_status_expire"><?= $Page->renderFieldHeader($Page->status_expire) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Page->status_expire_reason->headerCellClass() ?>"><div id="elh_buyer_asset_status_expire_reason" class="buyer_asset_status_expire_reason"><?= $Page->renderFieldHeader($Page->status_expire_reason) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_buyer_asset",
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
<span id="el<?= $Page->RowCount ?>_buyer_asset_asset_id" class="el_buyer_asset_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_booking_price" class="el_buyer_asset_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_pay_number" class="el_buyer_asset_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_status_payment" class="el_buyer_asset_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_date_booking" class="el_buyer_asset_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_date_payment" class="el_buyer_asset_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date->Visible) { // due_date ?>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_due_date" class="el_buyer_asset_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_cdate" class="el_buyer_asset_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_status_expire" class="el_buyer_asset_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_status_expire_reason" class="el_buyer_asset_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
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
        container: "gmp_buyer_asset",
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
    ew.addEventHandlers("buyer_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
