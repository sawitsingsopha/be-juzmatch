<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogTestPaymentList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_test_payment: currentTable } });
var currentForm, currentPageID;
var flog_test_paymentlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_test_paymentlist = new ew.Form("flog_test_paymentlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = flog_test_paymentlist;
    flog_test_paymentlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("flog_test_paymentlist");
});
var flog_test_paymentsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    flog_test_paymentsrch = new ew.Form("flog_test_paymentsrch", "list");
    currentSearchForm = flog_test_paymentsrch;

    // Dynamic selection lists

    // Filters
    flog_test_paymentsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("flog_test_paymentsrch");
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
<form name="flog_test_paymentsrch" id="flog_test_paymentsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="flog_test_paymentsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="log_test_payment">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="flog_test_paymentsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="flog_test_paymentsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="flog_test_paymentsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="flog_test_paymentsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> log_test_payment">
<form name="flog_test_paymentlist" id="flog_test_paymentlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_test_payment">
<div id="gmp_log_test_payment" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_log_test_paymentlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->log_test_payment_id->Visible) { // log_test_payment_id ?>
        <th data-name="log_test_payment_id" class="<?= $Page->log_test_payment_id->headerCellClass() ?>"><div id="elh_log_test_payment_log_test_payment_id" class="log_test_payment_log_test_payment_id"><?= $Page->renderFieldHeader($Page->log_test_payment_id) ?></div></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Page->member_id->headerCellClass() ?>"><div id="elh_log_test_payment_member_id" class="log_test_payment_member_id"><?= $Page->renderFieldHeader($Page->member_id) ?></div></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_log_test_payment_asset_id" class="log_test_payment_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Page->type->headerCellClass() ?>"><div id="elh_log_test_payment_type" class="log_test_payment_type"><?= $Page->renderFieldHeader($Page->type) ?></div></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Page->date_booking->headerCellClass() ?>"><div id="elh_log_test_payment_date_booking" class="log_test_payment_date_booking"><?= $Page->renderFieldHeader($Page->date_booking) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_log_test_payment_date_payment" class="log_test_payment_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <th data-name="due_date" class="<?= $Page->due_date->headerCellClass() ?>"><div id="elh_log_test_payment_due_date" class="log_test_payment_due_date"><?= $Page->renderFieldHeader($Page->due_date) ?></div></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th data-name="booking_price" class="<?= $Page->booking_price->headerCellClass() ?>"><div id="elh_log_test_payment_booking_price" class="log_test_payment_booking_price"><?= $Page->renderFieldHeader($Page->booking_price) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Page->pay_number->headerCellClass() ?>"><div id="elh_log_test_payment_pay_number" class="log_test_payment_pay_number"><?= $Page->renderFieldHeader($Page->pay_number) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_log_test_payment_status_payment" class="log_test_payment_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
        <th data-name="transaction_datetime" class="<?= $Page->transaction_datetime->headerCellClass() ?>"><div id="elh_log_test_payment_transaction_datetime" class="log_test_payment_transaction_datetime"><?= $Page->renderFieldHeader($Page->transaction_datetime) ?></div></th>
<?php } ?>
<?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
        <th data-name="payment_scheme" class="<?= $Page->payment_scheme->headerCellClass() ?>"><div id="elh_log_test_payment_payment_scheme" class="log_test_payment_payment_scheme"><?= $Page->renderFieldHeader($Page->payment_scheme) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
        <th data-name="transaction_ref" class="<?= $Page->transaction_ref->headerCellClass() ?>"><div id="elh_log_test_payment_transaction_ref" class="log_test_payment_transaction_ref"><?= $Page->renderFieldHeader($Page->transaction_ref) ?></div></th>
<?php } ?>
<?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
        <th data-name="channel_response_desc" class="<?= $Page->channel_response_desc->headerCellClass() ?>"><div id="elh_log_test_payment_channel_response_desc" class="log_test_payment_channel_response_desc"><?= $Page->renderFieldHeader($Page->channel_response_desc) ?></div></th>
<?php } ?>
<?php if ($Page->res_status->Visible) { // res_status ?>
        <th data-name="res_status" class="<?= $Page->res_status->headerCellClass() ?>"><div id="elh_log_test_payment_res_status" class="log_test_payment_res_status"><?= $Page->renderFieldHeader($Page->res_status) ?></div></th>
<?php } ?>
<?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
        <th data-name="res_referenceNo" class="<?= $Page->res_referenceNo->headerCellClass() ?>"><div id="elh_log_test_payment_res_referenceNo" class="log_test_payment_res_referenceNo"><?= $Page->renderFieldHeader($Page->res_referenceNo) ?></div></th>
<?php } ?>
<?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
        <th data-name="res_paidAgent" class="<?= $Page->res_paidAgent->headerCellClass() ?>"><div id="elh_log_test_payment_res_paidAgent" class="log_test_payment_res_paidAgent"><?= $Page->renderFieldHeader($Page->res_paidAgent) ?></div></th>
<?php } ?>
<?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
        <th data-name="res_paidChannel" class="<?= $Page->res_paidChannel->headerCellClass() ?>"><div id="elh_log_test_payment_res_paidChannel" class="log_test_payment_res_paidChannel"><?= $Page->renderFieldHeader($Page->res_paidChannel) ?></div></th>
<?php } ?>
<?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
        <th data-name="res_maskedPan" class="<?= $Page->res_maskedPan->headerCellClass() ?>"><div id="elh_log_test_payment_res_maskedPan" class="log_test_payment_res_maskedPan"><?= $Page->renderFieldHeader($Page->res_maskedPan) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Page->status_expire->headerCellClass() ?>"><div id="elh_log_test_payment_status_expire" class="log_test_payment_status_expire"><?= $Page->renderFieldHeader($Page->status_expire) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Page->status_expire_reason->headerCellClass() ?>"><div id="elh_log_test_payment_status_expire_reason" class="log_test_payment_status_expire_reason"><?= $Page->renderFieldHeader($Page->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_log_test_payment_cdate" class="log_test_payment_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_log_test_payment_cuser" class="log_test_payment_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_log_test_payment_cip" class="log_test_payment_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_log_test_payment_udate" class="log_test_payment_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_log_test_payment_uuser" class="log_test_payment_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_log_test_payment_uip" class="log_test_payment_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_log_test_payment",
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
    <?php if ($Page->log_test_payment_id->Visible) { // log_test_payment_id ?>
        <td data-name="log_test_payment_id"<?= $Page->log_test_payment_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_log_test_payment_id" class="el_log_test_payment_log_test_payment_id">
<span<?= $Page->log_test_payment_id->viewAttributes() ?>>
<?= $Page->log_test_payment_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_member_id" class="el_log_test_payment_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_asset_id" class="el_log_test_payment_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_type" class="el_log_test_payment_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_date_booking" class="el_log_test_payment_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_date_payment" class="el_log_test_payment_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date->Visible) { // due_date ?>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_due_date" class="el_log_test_payment_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_booking_price" class="el_log_test_payment_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_pay_number" class="el_log_test_payment_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_status_payment" class="el_log_test_payment_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
        <td data-name="transaction_datetime"<?= $Page->transaction_datetime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_transaction_datetime" class="el_log_test_payment_transaction_datetime">
<span<?= $Page->transaction_datetime->viewAttributes() ?>>
<?= $Page->transaction_datetime->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
        <td data-name="payment_scheme"<?= $Page->payment_scheme->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_payment_scheme" class="el_log_test_payment_payment_scheme">
<span<?= $Page->payment_scheme->viewAttributes() ?>>
<?= $Page->payment_scheme->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
        <td data-name="transaction_ref"<?= $Page->transaction_ref->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_transaction_ref" class="el_log_test_payment_transaction_ref">
<span<?= $Page->transaction_ref->viewAttributes() ?>>
<?= $Page->transaction_ref->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
        <td data-name="channel_response_desc"<?= $Page->channel_response_desc->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_channel_response_desc" class="el_log_test_payment_channel_response_desc">
<span<?= $Page->channel_response_desc->viewAttributes() ?>>
<?= $Page->channel_response_desc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_status->Visible) { // res_status ?>
        <td data-name="res_status"<?= $Page->res_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_status" class="el_log_test_payment_res_status">
<span<?= $Page->res_status->viewAttributes() ?>>
<?= $Page->res_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
        <td data-name="res_referenceNo"<?= $Page->res_referenceNo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_referenceNo" class="el_log_test_payment_res_referenceNo">
<span<?= $Page->res_referenceNo->viewAttributes() ?>>
<?= $Page->res_referenceNo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
        <td data-name="res_paidAgent"<?= $Page->res_paidAgent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_paidAgent" class="el_log_test_payment_res_paidAgent">
<span<?= $Page->res_paidAgent->viewAttributes() ?>>
<?= $Page->res_paidAgent->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
        <td data-name="res_paidChannel"<?= $Page->res_paidChannel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_paidChannel" class="el_log_test_payment_res_paidChannel">
<span<?= $Page->res_paidChannel->viewAttributes() ?>>
<?= $Page->res_paidChannel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
        <td data-name="res_maskedPan"<?= $Page->res_maskedPan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_res_maskedPan" class="el_log_test_payment_res_maskedPan">
<span<?= $Page->res_maskedPan->viewAttributes() ?>>
<?= $Page->res_maskedPan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_status_expire" class="el_log_test_payment_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_status_expire_reason" class="el_log_test_payment_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_cdate" class="el_log_test_payment_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_cuser" class="el_log_test_payment_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_cip" class="el_log_test_payment_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_udate" class="el_log_test_payment_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_uuser" class="el_log_test_payment_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_test_payment_uip" class="el_log_test_payment_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
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
    ew.addEventHandlers("log_test_payment");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
