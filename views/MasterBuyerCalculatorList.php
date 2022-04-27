<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MasterBuyerCalculatorList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { master_buyer_calculator: currentTable } });
var currentForm, currentPageID;
var fmaster_buyer_calculatorlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmaster_buyer_calculatorlist = new ew.Form("fmaster_buyer_calculatorlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fmaster_buyer_calculatorlist;
    fmaster_buyer_calculatorlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fmaster_buyer_calculatorlist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> master_buyer_calculator">
<form name="fmaster_buyer_calculatorlist" id="fmaster_buyer_calculatorlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="master_buyer_calculator">
<div id="gmp_master_buyer_calculator" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_master_buyer_calculatorlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->buyer_monthly_payment->Visible) { // buyer_monthly_payment ?>
        <th data-name="buyer_monthly_payment" class="<?= $Page->buyer_monthly_payment->headerCellClass() ?>"><div id="elh_master_buyer_calculator_buyer_monthly_payment" class="master_buyer_calculator_buyer_monthly_payment"><?= $Page->renderFieldHeader($Page->buyer_monthly_payment) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_monthly_annual_interest->Visible) { // buyer_monthly_annual_interest ?>
        <th data-name="buyer_monthly_annual_interest" class="<?= $Page->buyer_monthly_annual_interest->headerCellClass() ?>"><div id="elh_master_buyer_calculator_buyer_monthly_annual_interest" class="master_buyer_calculator_buyer_monthly_annual_interest"><?= $Page->renderFieldHeader($Page->buyer_monthly_annual_interest) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_dsr_ratio->Visible) { // buyer_dsr_ratio ?>
        <th data-name="buyer_dsr_ratio" class="<?= $Page->buyer_dsr_ratio->headerCellClass() ?>"><div id="elh_master_buyer_calculator_buyer_dsr_ratio" class="master_buyer_calculator_buyer_dsr_ratio"><?= $Page->renderFieldHeader($Page->buyer_dsr_ratio) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_down_payment->Visible) { // buyer_down_payment ?>
        <th data-name="buyer_down_payment" class="<?= $Page->buyer_down_payment->headerCellClass() ?>"><div id="elh_master_buyer_calculator_buyer_down_payment" class="master_buyer_calculator_buyer_down_payment"><?= $Page->renderFieldHeader($Page->buyer_down_payment) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_master_buyer_calculator_cdate" class="master_buyer_calculator_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_master_buyer_calculator",
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
    <?php if ($Page->buyer_monthly_payment->Visible) { // buyer_monthly_payment ?>
        <td data-name="buyer_monthly_payment"<?= $Page->buyer_monthly_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_monthly_payment" class="el_master_buyer_calculator_buyer_monthly_payment">
<span<?= $Page->buyer_monthly_payment->viewAttributes() ?>>
<?= $Page->buyer_monthly_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_monthly_annual_interest->Visible) { // buyer_monthly_annual_interest ?>
        <td data-name="buyer_monthly_annual_interest"<?= $Page->buyer_monthly_annual_interest->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_monthly_annual_interest" class="el_master_buyer_calculator_buyer_monthly_annual_interest">
<span<?= $Page->buyer_monthly_annual_interest->viewAttributes() ?>>
<?= $Page->buyer_monthly_annual_interest->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_dsr_ratio->Visible) { // buyer_dsr_ratio ?>
        <td data-name="buyer_dsr_ratio"<?= $Page->buyer_dsr_ratio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_dsr_ratio" class="el_master_buyer_calculator_buyer_dsr_ratio">
<span<?= $Page->buyer_dsr_ratio->viewAttributes() ?>>
<?= $Page->buyer_dsr_ratio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_down_payment->Visible) { // buyer_down_payment ?>
        <td data-name="buyer_down_payment"<?= $Page->buyer_down_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_down_payment" class="el_master_buyer_calculator_buyer_down_payment">
<span<?= $Page->buyer_down_payment->viewAttributes() ?>>
<?= $Page->buyer_down_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_cdate" class="el_master_buyer_calculator_cdate">
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
        container: "gmp_master_buyer_calculator",
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
    ew.addEventHandlers("master_buyer_calculator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
