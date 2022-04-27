<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense: currentTable } });
var currentForm, currentPageID;
var fpeak_expenselist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expenselist = new ew.Form("fpeak_expenselist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpeak_expenselist;
    fpeak_expenselist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpeak_expenselist");
});
var fpeak_expensesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpeak_expensesrch = new ew.Form("fpeak_expensesrch", "list");
    currentSearchForm = fpeak_expensesrch;

    // Dynamic selection lists

    // Filters
    fpeak_expensesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpeak_expensesrch");
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.ready("head", ew.PATH_BASE + "js/preview.min.js", "preview");
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fpeak_expensesrch" id="fpeak_expensesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpeak_expensesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="peak_expense">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpeak_expensesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpeak_expensesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpeak_expensesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpeak_expensesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> peak_expense">
<form name="fpeak_expenselist" id="fpeak_expenselist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense">
<div id="gmp_peak_expense" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_peak_expenselist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <th data-name="peak_expense_id" class="<?= $Page->peak_expense_id->headerCellClass() ?>"><div id="elh_peak_expense_peak_expense_id" class="peak_expense_peak_expense_id"><?= $Page->renderFieldHeader($Page->peak_expense_id) ?></div></th>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_peak_expense_id" class="peak_expense_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th data-name="code" class="<?= $Page->code->headerCellClass() ?>"><div id="elh_peak_expense_code" class="peak_expense_code"><?= $Page->renderFieldHeader($Page->code) ?></div></th>
<?php } ?>
<?php if ($Page->issuedDate->Visible) { // issuedDate ?>
        <th data-name="issuedDate" class="<?= $Page->issuedDate->headerCellClass() ?>"><div id="elh_peak_expense_issuedDate" class="peak_expense_issuedDate"><?= $Page->renderFieldHeader($Page->issuedDate) ?></div></th>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <th data-name="dueDate" class="<?= $Page->dueDate->headerCellClass() ?>"><div id="elh_peak_expense_dueDate" class="peak_expense_dueDate"><?= $Page->renderFieldHeader($Page->dueDate) ?></div></th>
<?php } ?>
<?php if ($Page->contactId->Visible) { // contactId ?>
        <th data-name="contactId" class="<?= $Page->contactId->headerCellClass() ?>"><div id="elh_peak_expense_contactId" class="peak_expense_contactId"><?= $Page->renderFieldHeader($Page->contactId) ?></div></th>
<?php } ?>
<?php if ($Page->contactCode->Visible) { // contactCode ?>
        <th data-name="contactCode" class="<?= $Page->contactCode->headerCellClass() ?>"><div id="elh_peak_expense_contactCode" class="peak_expense_contactCode"><?= $Page->renderFieldHeader($Page->contactCode) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_peak_expense_status" class="peak_expense_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->isTaxInvoice->Visible) { // isTaxInvoice ?>
        <th data-name="isTaxInvoice" class="<?= $Page->isTaxInvoice->headerCellClass() ?>"><div id="elh_peak_expense_isTaxInvoice" class="peak_expense_isTaxInvoice"><?= $Page->renderFieldHeader($Page->isTaxInvoice) ?></div></th>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <th data-name="preTaxAmount" class="<?= $Page->preTaxAmount->headerCellClass() ?>"><div id="elh_peak_expense_preTaxAmount" class="peak_expense_preTaxAmount"><?= $Page->renderFieldHeader($Page->preTaxAmount) ?></div></th>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <th data-name="vatAmount" class="<?= $Page->vatAmount->headerCellClass() ?>"><div id="elh_peak_expense_vatAmount" class="peak_expense_vatAmount"><?= $Page->renderFieldHeader($Page->vatAmount) ?></div></th>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
        <th data-name="netAmount" class="<?= $Page->netAmount->headerCellClass() ?>"><div id="elh_peak_expense_netAmount" class="peak_expense_netAmount"><?= $Page->renderFieldHeader($Page->netAmount) ?></div></th>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <th data-name="whtAmount" class="<?= $Page->whtAmount->headerCellClass() ?>"><div id="elh_peak_expense_whtAmount" class="peak_expense_whtAmount"><?= $Page->renderFieldHeader($Page->whtAmount) ?></div></th>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <th data-name="paymentAmount" class="<?= $Page->paymentAmount->headerCellClass() ?>"><div id="elh_peak_expense_paymentAmount" class="peak_expense_paymentAmount"><?= $Page->renderFieldHeader($Page->paymentAmount) ?></div></th>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <th data-name="remainAmount" class="<?= $Page->remainAmount->headerCellClass() ?>"><div id="elh_peak_expense_remainAmount" class="peak_expense_remainAmount"><?= $Page->renderFieldHeader($Page->remainAmount) ?></div></th>
<?php } ?>
<?php if ($Page->taxStatus->Visible) { // taxStatus ?>
        <th data-name="taxStatus" class="<?= $Page->taxStatus->headerCellClass() ?>"><div id="elh_peak_expense_taxStatus" class="peak_expense_taxStatus"><?= $Page->renderFieldHeader($Page->taxStatus) ?></div></th>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <th data-name="paymentDate" class="<?= $Page->paymentDate->headerCellClass() ?>"><div id="elh_peak_expense_paymentDate" class="peak_expense_paymentDate"><?= $Page->renderFieldHeader($Page->paymentDate) ?></div></th>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <th data-name="withHoldingTaxAmount" class="<?= $Page->withHoldingTaxAmount->headerCellClass() ?>"><div id="elh_peak_expense_withHoldingTaxAmount" class="peak_expense_withHoldingTaxAmount"><?= $Page->renderFieldHeader($Page->withHoldingTaxAmount) ?></div></th>
<?php } ?>
<?php if ($Page->paymentGroupId->Visible) { // paymentGroupId ?>
        <th data-name="paymentGroupId" class="<?= $Page->paymentGroupId->headerCellClass() ?>"><div id="elh_peak_expense_paymentGroupId" class="peak_expense_paymentGroupId"><?= $Page->renderFieldHeader($Page->paymentGroupId) ?></div></th>
<?php } ?>
<?php if ($Page->paymentTotal->Visible) { // paymentTotal ?>
        <th data-name="paymentTotal" class="<?= $Page->paymentTotal->headerCellClass() ?>"><div id="elh_peak_expense_paymentTotal" class="peak_expense_paymentTotal"><?= $Page->renderFieldHeader($Page->paymentTotal) ?></div></th>
<?php } ?>
<?php if ($Page->paymentMethodId->Visible) { // paymentMethodId ?>
        <th data-name="paymentMethodId" class="<?= $Page->paymentMethodId->headerCellClass() ?>"><div id="elh_peak_expense_paymentMethodId" class="peak_expense_paymentMethodId"><?= $Page->renderFieldHeader($Page->paymentMethodId) ?></div></th>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <th data-name="paymentMethodCode" class="<?= $Page->paymentMethodCode->headerCellClass() ?>"><div id="elh_peak_expense_paymentMethodCode" class="peak_expense_paymentMethodCode"><?= $Page->renderFieldHeader($Page->paymentMethodCode) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_peak_expense_amount" class="peak_expense_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
        <th data-name="journals_id" class="<?= $Page->journals_id->headerCellClass() ?>"><div id="elh_peak_expense_journals_id" class="peak_expense_journals_id"><?= $Page->renderFieldHeader($Page->journals_id) ?></div></th>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
        <th data-name="journals_code" class="<?= $Page->journals_code->headerCellClass() ?>"><div id="elh_peak_expense_journals_code" class="peak_expense_journals_code"><?= $Page->renderFieldHeader($Page->journals_code) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_peak_expense_cdate" class="peak_expense_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_peak_expense_cuser" class="peak_expense_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_peak_expense_cip" class="peak_expense_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_peak_expense_udate" class="peak_expense_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_peak_expense_uuser" class="peak_expense_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_peak_expense_uip" class="peak_expense_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
<?php } ?>
<?php if ($Page->sync_detail_date->Visible) { // sync_detail_date ?>
        <th data-name="sync_detail_date" class="<?= $Page->sync_detail_date->headerCellClass() ?>"><div id="elh_peak_expense_sync_detail_date" class="peak_expense_sync_detail_date"><?= $Page->renderFieldHeader($Page->sync_detail_date) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_peak_expense",
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
    <?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <td data-name="peak_expense_id"<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_peak_expense_id" class="el_peak_expense_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<?= $Page->peak_expense_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_id" class="el_peak_expense_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->code->Visible) { // code ?>
        <td data-name="code"<?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_code" class="el_peak_expense_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->issuedDate->Visible) { // issuedDate ?>
        <td data-name="issuedDate"<?= $Page->issuedDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_issuedDate" class="el_peak_expense_issuedDate">
<span<?= $Page->issuedDate->viewAttributes() ?>>
<?= $Page->issuedDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dueDate->Visible) { // dueDate ?>
        <td data-name="dueDate"<?= $Page->dueDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_dueDate" class="el_peak_expense_dueDate">
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contactId->Visible) { // contactId ?>
        <td data-name="contactId"<?= $Page->contactId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_contactId" class="el_peak_expense_contactId">
<span<?= $Page->contactId->viewAttributes() ?>>
<?= $Page->contactId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contactCode->Visible) { // contactCode ?>
        <td data-name="contactCode"<?= $Page->contactCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_contactCode" class="el_peak_expense_contactCode">
<span<?= $Page->contactCode->viewAttributes() ?>>
<?= $Page->contactCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_status" class="el_peak_expense_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isTaxInvoice->Visible) { // isTaxInvoice ?>
        <td data-name="isTaxInvoice"<?= $Page->isTaxInvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_isTaxInvoice" class="el_peak_expense_isTaxInvoice">
<span<?= $Page->isTaxInvoice->viewAttributes() ?>>
<?= $Page->isTaxInvoice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <td data-name="preTaxAmount"<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_preTaxAmount" class="el_peak_expense_preTaxAmount">
<span<?= $Page->preTaxAmount->viewAttributes() ?>>
<?= $Page->preTaxAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <td data-name="vatAmount"<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_vatAmount" class="el_peak_expense_vatAmount">
<span<?= $Page->vatAmount->viewAttributes() ?>>
<?= $Page->vatAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->netAmount->Visible) { // netAmount ?>
        <td data-name="netAmount"<?= $Page->netAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_netAmount" class="el_peak_expense_netAmount">
<span<?= $Page->netAmount->viewAttributes() ?>>
<?= $Page->netAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <td data-name="whtAmount"<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_whtAmount" class="el_peak_expense_whtAmount">
<span<?= $Page->whtAmount->viewAttributes() ?>>
<?= $Page->whtAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <td data-name="paymentAmount"<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentAmount" class="el_peak_expense_paymentAmount">
<span<?= $Page->paymentAmount->viewAttributes() ?>>
<?= $Page->paymentAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <td data-name="remainAmount"<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_remainAmount" class="el_peak_expense_remainAmount">
<span<?= $Page->remainAmount->viewAttributes() ?>>
<?= $Page->remainAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->taxStatus->Visible) { // taxStatus ?>
        <td data-name="taxStatus"<?= $Page->taxStatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_taxStatus" class="el_peak_expense_taxStatus">
<span<?= $Page->taxStatus->viewAttributes() ?>>
<?= $Page->taxStatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <td data-name="paymentDate"<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentDate" class="el_peak_expense_paymentDate">
<span<?= $Page->paymentDate->viewAttributes() ?>>
<?= $Page->paymentDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <td data-name="withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_withHoldingTaxAmount" class="el_peak_expense_withHoldingTaxAmount">
<span<?= $Page->withHoldingTaxAmount->viewAttributes() ?>>
<?= $Page->withHoldingTaxAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentGroupId->Visible) { // paymentGroupId ?>
        <td data-name="paymentGroupId"<?= $Page->paymentGroupId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentGroupId" class="el_peak_expense_paymentGroupId">
<span<?= $Page->paymentGroupId->viewAttributes() ?>>
<?= $Page->paymentGroupId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentTotal->Visible) { // paymentTotal ?>
        <td data-name="paymentTotal"<?= $Page->paymentTotal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentTotal" class="el_peak_expense_paymentTotal">
<span<?= $Page->paymentTotal->viewAttributes() ?>>
<?= $Page->paymentTotal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentMethodId->Visible) { // paymentMethodId ?>
        <td data-name="paymentMethodId"<?= $Page->paymentMethodId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentMethodId" class="el_peak_expense_paymentMethodId">
<span<?= $Page->paymentMethodId->viewAttributes() ?>>
<?= $Page->paymentMethodId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <td data-name="paymentMethodCode"<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_paymentMethodCode" class="el_peak_expense_paymentMethodCode">
<span<?= $Page->paymentMethodCode->viewAttributes() ?>>
<?= $Page->paymentMethodCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_amount" class="el_peak_expense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->journals_id->Visible) { // journals_id ?>
        <td data-name="journals_id"<?= $Page->journals_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_journals_id" class="el_peak_expense_journals_id">
<span<?= $Page->journals_id->viewAttributes() ?>>
<?= $Page->journals_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->journals_code->Visible) { // journals_code ?>
        <td data-name="journals_code"<?= $Page->journals_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_journals_code" class="el_peak_expense_journals_code">
<span<?= $Page->journals_code->viewAttributes() ?>>
<?= $Page->journals_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_cdate" class="el_peak_expense_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_cuser" class="el_peak_expense_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_cip" class="el_peak_expense_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_udate" class="el_peak_expense_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_uuser" class="el_peak_expense_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_uip" class="el_peak_expense_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sync_detail_date->Visible) { // sync_detail_date ?>
        <td data-name="sync_detail_date"<?= $Page->sync_detail_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_sync_detail_date" class="el_peak_expense_sync_detail_date">
<span<?= $Page->sync_detail_date->viewAttributes() ?>>
<?= $Page->sync_detail_date->getViewValue() ?></span>
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
    ew.addEventHandlers("peak_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
