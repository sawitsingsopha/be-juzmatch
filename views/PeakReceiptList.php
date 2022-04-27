<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt: currentTable } });
var currentForm, currentPageID;
var fpeak_receiptlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receiptlist = new ew.Form("fpeak_receiptlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpeak_receiptlist;
    fpeak_receiptlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpeak_receiptlist");
});
var fpeak_receiptsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpeak_receiptsrch = new ew.Form("fpeak_receiptsrch", "list");
    currentSearchForm = fpeak_receiptsrch;

    // Dynamic selection lists

    // Filters
    fpeak_receiptsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpeak_receiptsrch");
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
<form name="fpeak_receiptsrch" id="fpeak_receiptsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpeak_receiptsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="peak_receipt">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpeak_receiptsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpeak_receiptsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpeak_receiptsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpeak_receiptsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> peak_receipt">
<form name="fpeak_receiptlist" id="fpeak_receiptlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt">
<div id="gmp_peak_receipt" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_peak_receiptlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_peak_receipt_id" class="peak_receipt_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th data-name="create_date" class="<?= $Page->create_date->headerCellClass() ?>"><div id="elh_peak_receipt_create_date" class="peak_receipt_create_date"><?= $Page->renderFieldHeader($Page->create_date) ?></div></th>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
        <th data-name="request_status" class="<?= $Page->request_status->headerCellClass() ?>"><div id="elh_peak_receipt_request_status" class="peak_receipt_request_status"><?= $Page->renderFieldHeader($Page->request_status) ?></div></th>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
        <th data-name="request_date" class="<?= $Page->request_date->headerCellClass() ?>"><div id="elh_peak_receipt_request_date" class="peak_receipt_request_date"><?= $Page->renderFieldHeader($Page->request_date) ?></div></th>
<?php } ?>
<?php if ($Page->issueddate->Visible) { // issueddate ?>
        <th data-name="issueddate" class="<?= $Page->issueddate->headerCellClass() ?>"><div id="elh_peak_receipt_issueddate" class="peak_receipt_issueddate"><?= $Page->renderFieldHeader($Page->issueddate) ?></div></th>
<?php } ?>
<?php if ($Page->duedate->Visible) { // duedate ?>
        <th data-name="duedate" class="<?= $Page->duedate->headerCellClass() ?>"><div id="elh_peak_receipt_duedate" class="peak_receipt_duedate"><?= $Page->renderFieldHeader($Page->duedate) ?></div></th>
<?php } ?>
<?php if ($Page->contactcode->Visible) { // contactcode ?>
        <th data-name="contactcode" class="<?= $Page->contactcode->headerCellClass() ?>"><div id="elh_peak_receipt_contactcode" class="peak_receipt_contactcode"><?= $Page->renderFieldHeader($Page->contactcode) ?></div></th>
<?php } ?>
<?php if ($Page->istaxinvoice->Visible) { // istaxinvoice ?>
        <th data-name="istaxinvoice" class="<?= $Page->istaxinvoice->headerCellClass() ?>"><div id="elh_peak_receipt_istaxinvoice" class="peak_receipt_istaxinvoice"><?= $Page->renderFieldHeader($Page->istaxinvoice) ?></div></th>
<?php } ?>
<?php if ($Page->taxstatus->Visible) { // taxstatus ?>
        <th data-name="taxstatus" class="<?= $Page->taxstatus->headerCellClass() ?>"><div id="elh_peak_receipt_taxstatus" class="peak_receipt_taxstatus"><?= $Page->renderFieldHeader($Page->taxstatus) ?></div></th>
<?php } ?>
<?php if ($Page->paymentdate->Visible) { // paymentdate ?>
        <th data-name="paymentdate" class="<?= $Page->paymentdate->headerCellClass() ?>"><div id="elh_peak_receipt_paymentdate" class="peak_receipt_paymentdate"><?= $Page->renderFieldHeader($Page->paymentdate) ?></div></th>
<?php } ?>
<?php if ($Page->paymentmethodid->Visible) { // paymentmethodid ?>
        <th data-name="paymentmethodid" class="<?= $Page->paymentmethodid->headerCellClass() ?>"><div id="elh_peak_receipt_paymentmethodid" class="peak_receipt_paymentmethodid"><?= $Page->renderFieldHeader($Page->paymentmethodid) ?></div></th>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <th data-name="paymentMethodCode" class="<?= $Page->paymentMethodCode->headerCellClass() ?>"><div id="elh_peak_receipt_paymentMethodCode" class="peak_receipt_paymentMethodCode"><?= $Page->renderFieldHeader($Page->paymentMethodCode) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_peak_receipt_amount" class="peak_receipt_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->remark->Visible) { // remark ?>
        <th data-name="remark" class="<?= $Page->remark->headerCellClass() ?>"><div id="elh_peak_receipt_remark" class="peak_receipt_remark"><?= $Page->renderFieldHeader($Page->remark) ?></div></th>
<?php } ?>
<?php if ($Page->receipt_id->Visible) { // receipt_id ?>
        <th data-name="receipt_id" class="<?= $Page->receipt_id->headerCellClass() ?>"><div id="elh_peak_receipt_receipt_id" class="peak_receipt_receipt_id"><?= $Page->renderFieldHeader($Page->receipt_id) ?></div></th>
<?php } ?>
<?php if ($Page->receipt_code->Visible) { // receipt_code ?>
        <th data-name="receipt_code" class="<?= $Page->receipt_code->headerCellClass() ?>"><div id="elh_peak_receipt_receipt_code" class="peak_receipt_receipt_code"><?= $Page->renderFieldHeader($Page->receipt_code) ?></div></th>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <th data-name="receipt_status" class="<?= $Page->receipt_status->headerCellClass() ?>"><div id="elh_peak_receipt_receipt_status" class="peak_receipt_receipt_status"><?= $Page->renderFieldHeader($Page->receipt_status) ?></div></th>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <th data-name="preTaxAmount" class="<?= $Page->preTaxAmount->headerCellClass() ?>"><div id="elh_peak_receipt_preTaxAmount" class="peak_receipt_preTaxAmount"><?= $Page->renderFieldHeader($Page->preTaxAmount) ?></div></th>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <th data-name="vatAmount" class="<?= $Page->vatAmount->headerCellClass() ?>"><div id="elh_peak_receipt_vatAmount" class="peak_receipt_vatAmount"><?= $Page->renderFieldHeader($Page->vatAmount) ?></div></th>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
        <th data-name="netAmount" class="<?= $Page->netAmount->headerCellClass() ?>"><div id="elh_peak_receipt_netAmount" class="peak_receipt_netAmount"><?= $Page->renderFieldHeader($Page->netAmount) ?></div></th>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <th data-name="whtAmount" class="<?= $Page->whtAmount->headerCellClass() ?>"><div id="elh_peak_receipt_whtAmount" class="peak_receipt_whtAmount"><?= $Page->renderFieldHeader($Page->whtAmount) ?></div></th>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <th data-name="paymentAmount" class="<?= $Page->paymentAmount->headerCellClass() ?>"><div id="elh_peak_receipt_paymentAmount" class="peak_receipt_paymentAmount"><?= $Page->renderFieldHeader($Page->paymentAmount) ?></div></th>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <th data-name="remainAmount" class="<?= $Page->remainAmount->headerCellClass() ?>"><div id="elh_peak_receipt_remainAmount" class="peak_receipt_remainAmount"><?= $Page->renderFieldHeader($Page->remainAmount) ?></div></th>
<?php } ?>
<?php if ($Page->remainWhtAmount->Visible) { // remainWhtAmount ?>
        <th data-name="remainWhtAmount" class="<?= $Page->remainWhtAmount->headerCellClass() ?>"><div id="elh_peak_receipt_remainWhtAmount" class="peak_receipt_remainWhtAmount"><?= $Page->renderFieldHeader($Page->remainWhtAmount) ?></div></th>
<?php } ?>
<?php if ($Page->isPartialReceipt->Visible) { // isPartialReceipt ?>
        <th data-name="isPartialReceipt" class="<?= $Page->isPartialReceipt->headerCellClass() ?>"><div id="elh_peak_receipt_isPartialReceipt" class="peak_receipt_isPartialReceipt"><?= $Page->renderFieldHeader($Page->isPartialReceipt) ?></div></th>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
        <th data-name="journals_id" class="<?= $Page->journals_id->headerCellClass() ?>"><div id="elh_peak_receipt_journals_id" class="peak_receipt_journals_id"><?= $Page->renderFieldHeader($Page->journals_id) ?></div></th>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
        <th data-name="journals_code" class="<?= $Page->journals_code->headerCellClass() ?>"><div id="elh_peak_receipt_journals_code" class="peak_receipt_journals_code"><?= $Page->renderFieldHeader($Page->journals_code) ?></div></th>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
        <th data-name="refid" class="<?= $Page->refid->headerCellClass() ?>"><div id="elh_peak_receipt_refid" class="peak_receipt_refid"><?= $Page->renderFieldHeader($Page->refid) ?></div></th>
<?php } ?>
<?php if ($Page->transition_type->Visible) { // transition_type ?>
        <th data-name="transition_type" class="<?= $Page->transition_type->headerCellClass() ?>"><div id="elh_peak_receipt_transition_type" class="peak_receipt_transition_type"><?= $Page->renderFieldHeader($Page->transition_type) ?></div></th>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <th data-name="is_email" class="<?= $Page->is_email->headerCellClass() ?>"><div id="elh_peak_receipt_is_email" class="peak_receipt_is_email"><?= $Page->renderFieldHeader($Page->is_email) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_peak_receipt",
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_id" class="el_peak_receipt_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->create_date->Visible) { // create_date ?>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_create_date" class="el_peak_receipt_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->request_status->Visible) { // request_status ?>
        <td data-name="request_status"<?= $Page->request_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_request_status" class="el_peak_receipt_request_status">
<span<?= $Page->request_status->viewAttributes() ?>>
<?= $Page->request_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->request_date->Visible) { // request_date ?>
        <td data-name="request_date"<?= $Page->request_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_request_date" class="el_peak_receipt_request_date">
<span<?= $Page->request_date->viewAttributes() ?>>
<?= $Page->request_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->issueddate->Visible) { // issueddate ?>
        <td data-name="issueddate"<?= $Page->issueddate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_issueddate" class="el_peak_receipt_issueddate">
<span<?= $Page->issueddate->viewAttributes() ?>>
<?= $Page->issueddate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->duedate->Visible) { // duedate ?>
        <td data-name="duedate"<?= $Page->duedate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_duedate" class="el_peak_receipt_duedate">
<span<?= $Page->duedate->viewAttributes() ?>>
<?= $Page->duedate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contactcode->Visible) { // contactcode ?>
        <td data-name="contactcode"<?= $Page->contactcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_contactcode" class="el_peak_receipt_contactcode">
<span<?= $Page->contactcode->viewAttributes() ?>>
<?= $Page->contactcode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->istaxinvoice->Visible) { // istaxinvoice ?>
        <td data-name="istaxinvoice"<?= $Page->istaxinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_istaxinvoice" class="el_peak_receipt_istaxinvoice">
<span<?= $Page->istaxinvoice->viewAttributes() ?>>
<?= $Page->istaxinvoice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->taxstatus->Visible) { // taxstatus ?>
        <td data-name="taxstatus"<?= $Page->taxstatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_taxstatus" class="el_peak_receipt_taxstatus">
<span<?= $Page->taxstatus->viewAttributes() ?>>
<?= $Page->taxstatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentdate->Visible) { // paymentdate ?>
        <td data-name="paymentdate"<?= $Page->paymentdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentdate" class="el_peak_receipt_paymentdate">
<span<?= $Page->paymentdate->viewAttributes() ?>>
<?= $Page->paymentdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentmethodid->Visible) { // paymentmethodid ?>
        <td data-name="paymentmethodid"<?= $Page->paymentmethodid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentmethodid" class="el_peak_receipt_paymentmethodid">
<span<?= $Page->paymentmethodid->viewAttributes() ?>>
<?= $Page->paymentmethodid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
        <td data-name="paymentMethodCode"<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentMethodCode" class="el_peak_receipt_paymentMethodCode">
<span<?= $Page->paymentMethodCode->viewAttributes() ?>>
<?= $Page->paymentMethodCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_amount" class="el_peak_receipt_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remark->Visible) { // remark ?>
        <td data-name="remark"<?= $Page->remark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_remark" class="el_peak_receipt_remark">
<span<?= $Page->remark->viewAttributes() ?>>
<?= $Page->remark->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt_id->Visible) { // receipt_id ?>
        <td data-name="receipt_id"<?= $Page->receipt_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_receipt_id" class="el_peak_receipt_receipt_id">
<span<?= $Page->receipt_id->viewAttributes() ?>>
<?= $Page->receipt_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt_code->Visible) { // receipt_code ?>
        <td data-name="receipt_code"<?= $Page->receipt_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_receipt_code" class="el_peak_receipt_receipt_code">
<span<?= $Page->receipt_code->viewAttributes() ?>>
<?= $Page->receipt_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <td data-name="receipt_status"<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_receipt_status" class="el_peak_receipt_receipt_status">
<span<?= $Page->receipt_status->viewAttributes() ?>>
<?= $Page->receipt_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
        <td data-name="preTaxAmount"<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_preTaxAmount" class="el_peak_receipt_preTaxAmount">
<span<?= $Page->preTaxAmount->viewAttributes() ?>>
<?= $Page->preTaxAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vatAmount->Visible) { // vatAmount ?>
        <td data-name="vatAmount"<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_vatAmount" class="el_peak_receipt_vatAmount">
<span<?= $Page->vatAmount->viewAttributes() ?>>
<?= $Page->vatAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->netAmount->Visible) { // netAmount ?>
        <td data-name="netAmount"<?= $Page->netAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_netAmount" class="el_peak_receipt_netAmount">
<span<?= $Page->netAmount->viewAttributes() ?>>
<?= $Page->netAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->whtAmount->Visible) { // whtAmount ?>
        <td data-name="whtAmount"<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_whtAmount" class="el_peak_receipt_whtAmount">
<span<?= $Page->whtAmount->viewAttributes() ?>>
<?= $Page->whtAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
        <td data-name="paymentAmount"<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_paymentAmount" class="el_peak_receipt_paymentAmount">
<span<?= $Page->paymentAmount->viewAttributes() ?>>
<?= $Page->paymentAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remainAmount->Visible) { // remainAmount ?>
        <td data-name="remainAmount"<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_remainAmount" class="el_peak_receipt_remainAmount">
<span<?= $Page->remainAmount->viewAttributes() ?>>
<?= $Page->remainAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remainWhtAmount->Visible) { // remainWhtAmount ?>
        <td data-name="remainWhtAmount"<?= $Page->remainWhtAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_remainWhtAmount" class="el_peak_receipt_remainWhtAmount">
<span<?= $Page->remainWhtAmount->viewAttributes() ?>>
<?= $Page->remainWhtAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isPartialReceipt->Visible) { // isPartialReceipt ?>
        <td data-name="isPartialReceipt"<?= $Page->isPartialReceipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_isPartialReceipt" class="el_peak_receipt_isPartialReceipt">
<span<?= $Page->isPartialReceipt->viewAttributes() ?>>
<?= $Page->isPartialReceipt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->journals_id->Visible) { // journals_id ?>
        <td data-name="journals_id"<?= $Page->journals_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_journals_id" class="el_peak_receipt_journals_id">
<span<?= $Page->journals_id->viewAttributes() ?>>
<?= $Page->journals_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->journals_code->Visible) { // journals_code ?>
        <td data-name="journals_code"<?= $Page->journals_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_journals_code" class="el_peak_receipt_journals_code">
<span<?= $Page->journals_code->viewAttributes() ?>>
<?= $Page->journals_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->refid->Visible) { // refid ?>
        <td data-name="refid"<?= $Page->refid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_refid" class="el_peak_receipt_refid">
<span<?= $Page->refid->viewAttributes() ?>>
<?= $Page->refid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transition_type->Visible) { // transition_type ?>
        <td data-name="transition_type"<?= $Page->transition_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_transition_type" class="el_peak_receipt_transition_type">
<span<?= $Page->transition_type->viewAttributes() ?>>
<?= $Page->transition_type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_email->Visible) { // is_email ?>
        <td data-name="is_email"<?= $Page->is_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_is_email" class="el_peak_receipt_is_email">
<span<?= $Page->is_email->viewAttributes() ?>>
<?= $Page->is_email->getViewValue() ?></span>
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
    ew.addEventHandlers("peak_receipt");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
