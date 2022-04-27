<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvestorVerifyList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { investor_verify: currentTable } });
var currentForm, currentPageID;
var finvestor_verifylist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvestor_verifylist = new ew.Form("finvestor_verifylist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = finvestor_verifylist;
    finvestor_verifylist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("finvestor_verifylist");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "investor") {
    if ($Page->MasterRecordExists) {
        include_once "views/InvestorMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> investor_verify">
<form name="finvestor_verifylist" id="finvestor_verifylist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="investor_verify">
<?php if ($Page->getCurrentMasterTable() == "investor" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="investor">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_investor_verify" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_investor_verifylist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->investment->Visible) { // investment ?>
        <th data-name="investment" class="<?= $Page->investment->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_investment" class="investor_verify_investment"><?= $Page->renderFieldHeader($Page->investment) ?></div></th>
<?php } ?>
<?php if ($Page->credit_limit->Visible) { // credit_limit ?>
        <th data-name="credit_limit" class="<?= $Page->credit_limit->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_credit_limit" class="investor_verify_credit_limit"><?= $Page->renderFieldHeader($Page->credit_limit) ?></div></th>
<?php } ?>
<?php if ($Page->monthly_payments->Visible) { // monthly_payments ?>
        <th data-name="monthly_payments" class="<?= $Page->monthly_payments->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_monthly_payments" class="investor_verify_monthly_payments"><?= $Page->renderFieldHeader($Page->monthly_payments) ?></div></th>
<?php } ?>
<?php if ($Page->highest_rental_price->Visible) { // highest_rental_price ?>
        <th data-name="highest_rental_price" class="<?= $Page->highest_rental_price->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_highest_rental_price" class="investor_verify_highest_rental_price"><?= $Page->renderFieldHeader($Page->highest_rental_price) ?></div></th>
<?php } ?>
<?php if ($Page->transfer->Visible) { // transfer ?>
        <th data-name="transfer" class="<?= $Page->transfer->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_transfer" class="investor_verify_transfer"><?= $Page->renderFieldHeader($Page->transfer) ?></div></th>
<?php } ?>
<?php if ($Page->total_invertor_year->Visible) { // total_invertor_year ?>
        <th data-name="total_invertor_year" class="<?= $Page->total_invertor_year->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_total_invertor_year" class="investor_verify_total_invertor_year"><?= $Page->renderFieldHeader($Page->total_invertor_year) ?></div></th>
<?php } ?>
<?php if ($Page->invert_payoff_day->Visible) { // invert_payoff_day ?>
        <th data-name="invert_payoff_day" class="<?= $Page->invert_payoff_day->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_invert_payoff_day" class="investor_verify_invert_payoff_day"><?= $Page->renderFieldHeader($Page->invert_payoff_day) ?></div></th>
<?php } ?>
<?php if ($Page->type_invertor->Visible) { // type_invertor ?>
        <th data-name="type_invertor" class="<?= $Page->type_invertor->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_type_invertor" class="investor_verify_type_invertor"><?= $Page->renderFieldHeader($Page->type_invertor) ?></div></th>
<?php } ?>
<?php if ($Page->invest_amount->Visible) { // invest_amount ?>
        <th data-name="invest_amount" class="<?= $Page->invest_amount->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_invest_amount" class="investor_verify_invest_amount"><?= $Page->renderFieldHeader($Page->invest_amount) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_investor_verify_cdate" class="investor_verify_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_investor_verify",
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
    <?php if ($Page->investment->Visible) { // investment ?>
        <td data-name="investment"<?= $Page->investment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_investment" class="el_investor_verify_investment">
<span<?= $Page->investment->viewAttributes() ?>>
<?= $Page->investment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->credit_limit->Visible) { // credit_limit ?>
        <td data-name="credit_limit"<?= $Page->credit_limit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_credit_limit" class="el_investor_verify_credit_limit">
<span<?= $Page->credit_limit->viewAttributes() ?>>
<?= $Page->credit_limit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monthly_payments->Visible) { // monthly_payments ?>
        <td data-name="monthly_payments"<?= $Page->monthly_payments->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_monthly_payments" class="el_investor_verify_monthly_payments">
<span<?= $Page->monthly_payments->viewAttributes() ?>>
<?= $Page->monthly_payments->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->highest_rental_price->Visible) { // highest_rental_price ?>
        <td data-name="highest_rental_price"<?= $Page->highest_rental_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_highest_rental_price" class="el_investor_verify_highest_rental_price">
<span<?= $Page->highest_rental_price->viewAttributes() ?>>
<?= $Page->highest_rental_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transfer->Visible) { // transfer ?>
        <td data-name="transfer"<?= $Page->transfer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_transfer" class="el_investor_verify_transfer">
<span<?= $Page->transfer->viewAttributes() ?>>
<?= $Page->transfer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->total_invertor_year->Visible) { // total_invertor_year ?>
        <td data-name="total_invertor_year"<?= $Page->total_invertor_year->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_total_invertor_year" class="el_investor_verify_total_invertor_year">
<span<?= $Page->total_invertor_year->viewAttributes() ?>>
<?= $Page->total_invertor_year->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->invert_payoff_day->Visible) { // invert_payoff_day ?>
        <td data-name="invert_payoff_day"<?= $Page->invert_payoff_day->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_invert_payoff_day" class="el_investor_verify_invert_payoff_day">
<span<?= $Page->invert_payoff_day->viewAttributes() ?>>
<?= $Page->invert_payoff_day->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->type_invertor->Visible) { // type_invertor ?>
        <td data-name="type_invertor"<?= $Page->type_invertor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_type_invertor" class="el_investor_verify_type_invertor">
<span<?= $Page->type_invertor->viewAttributes() ?>>
<?= $Page->type_invertor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->invest_amount->Visible) { // invest_amount ?>
        <td data-name="invest_amount"<?= $Page->invest_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_invest_amount" class="el_investor_verify_invest_amount">
<span<?= $Page->invest_amount->viewAttributes() ?>>
<?= $Page->invest_amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_verify_cdate" class="el_investor_verify_cdate">
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
        container: "gmp_investor_verify",
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
    ew.addEventHandlers("investor_verify");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
