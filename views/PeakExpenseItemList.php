<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseItemList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense_item: currentTable } });
var currentForm, currentPageID;
var fpeak_expense_itemlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expense_itemlist = new ew.Form("fpeak_expense_itemlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpeak_expense_itemlist;
    fpeak_expense_itemlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpeak_expense_itemlist");
});
var fpeak_expense_itemsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpeak_expense_itemsrch = new ew.Form("fpeak_expense_itemsrch", "list");
    currentSearchForm = fpeak_expense_itemsrch;

    // Dynamic selection lists

    // Filters
    fpeak_expense_itemsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpeak_expense_itemsrch");
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
<form name="fpeak_expense_itemsrch" id="fpeak_expense_itemsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpeak_expense_itemsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="peak_expense_item">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpeak_expense_itemsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpeak_expense_itemsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpeak_expense_itemsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpeak_expense_itemsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> peak_expense_item">
<form name="fpeak_expense_itemlist" id="fpeak_expense_itemlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense_item">
<div id="gmp_peak_expense_item" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_peak_expense_itemlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->peak_expense_item_id->Visible) { // peak_expense_item_id ?>
        <th data-name="peak_expense_item_id" class="<?= $Page->peak_expense_item_id->headerCellClass() ?>"><div id="elh_peak_expense_item_peak_expense_item_id" class="peak_expense_item_peak_expense_item_id"><?= $Page->renderFieldHeader($Page->peak_expense_item_id) ?></div></th>
<?php } ?>
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <th data-name="peak_expense_id" class="<?= $Page->peak_expense_id->headerCellClass() ?>"><div id="elh_peak_expense_item_peak_expense_id" class="peak_expense_item_peak_expense_id"><?= $Page->renderFieldHeader($Page->peak_expense_id) ?></div></th>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_peak_expense_item_id" class="peak_expense_item_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->productId->Visible) { // productId ?>
        <th data-name="productId" class="<?= $Page->productId->headerCellClass() ?>"><div id="elh_peak_expense_item_productId" class="peak_expense_item_productId"><?= $Page->renderFieldHeader($Page->productId) ?></div></th>
<?php } ?>
<?php if ($Page->productCode->Visible) { // productCode ?>
        <th data-name="productCode" class="<?= $Page->productCode->headerCellClass() ?>"><div id="elh_peak_expense_item_productCode" class="peak_expense_item_productCode"><?= $Page->renderFieldHeader($Page->productCode) ?></div></th>
<?php } ?>
<?php if ($Page->accountCode->Visible) { // accountCode ?>
        <th data-name="accountCode" class="<?= $Page->accountCode->headerCellClass() ?>"><div id="elh_peak_expense_item_accountCode" class="peak_expense_item_accountCode"><?= $Page->renderFieldHeader($Page->accountCode) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_peak_expense_item_quantity" class="peak_expense_item_quantity"><?= $Page->renderFieldHeader($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_peak_expense_item_price" class="peak_expense_item_price"><?= $Page->renderFieldHeader($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
        <th data-name="vatType" class="<?= $Page->vatType->headerCellClass() ?>"><div id="elh_peak_expense_item_vatType" class="peak_expense_item_vatType"><?= $Page->renderFieldHeader($Page->vatType) ?></div></th>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <th data-name="withHoldingTaxAmount" class="<?= $Page->withHoldingTaxAmount->headerCellClass() ?>"><div id="elh_peak_expense_item_withHoldingTaxAmount" class="peak_expense_item_withHoldingTaxAmount"><?= $Page->renderFieldHeader($Page->withHoldingTaxAmount) ?></div></th>
<?php } ?>
<?php if ($Page->isdelete->Visible) { // isdelete ?>
        <th data-name="isdelete" class="<?= $Page->isdelete->headerCellClass() ?>"><div id="elh_peak_expense_item_isdelete" class="peak_expense_item_isdelete"><?= $Page->renderFieldHeader($Page->isdelete) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_peak_expense_item_cdate" class="peak_expense_item_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_peak_expense_item_cuser" class="peak_expense_item_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_peak_expense_item_cip" class="peak_expense_item_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_peak_expense_item_udate" class="peak_expense_item_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_peak_expense_item_uuser" class="peak_expense_item_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_peak_expense_item_uip" class="peak_expense_item_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_peak_expense_item",
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
    <?php if ($Page->peak_expense_item_id->Visible) { // peak_expense_item_id ?>
        <td data-name="peak_expense_item_id"<?= $Page->peak_expense_item_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_peak_expense_item_id" class="el_peak_expense_item_peak_expense_item_id">
<span<?= $Page->peak_expense_item_id->viewAttributes() ?>>
<?= $Page->peak_expense_item_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
        <td data-name="peak_expense_id"<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_peak_expense_id" class="el_peak_expense_item_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<?= $Page->peak_expense_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_id" class="el_peak_expense_item_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->productId->Visible) { // productId ?>
        <td data-name="productId"<?= $Page->productId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_productId" class="el_peak_expense_item_productId">
<span<?= $Page->productId->viewAttributes() ?>>
<?= $Page->productId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->productCode->Visible) { // productCode ?>
        <td data-name="productCode"<?= $Page->productCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_productCode" class="el_peak_expense_item_productCode">
<span<?= $Page->productCode->viewAttributes() ?>>
<?= $Page->productCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->accountCode->Visible) { // accountCode ?>
        <td data-name="accountCode"<?= $Page->accountCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_accountCode" class="el_peak_expense_item_accountCode">
<span<?= $Page->accountCode->viewAttributes() ?>>
<?= $Page->accountCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity"<?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_quantity" class="el_peak_expense_item_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_price" class="el_peak_expense_item_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vatType->Visible) { // vatType ?>
        <td data-name="vatType"<?= $Page->vatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_vatType" class="el_peak_expense_item_vatType">
<span<?= $Page->vatType->viewAttributes() ?>>
<?= $Page->vatType->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
        <td data-name="withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_withHoldingTaxAmount" class="el_peak_expense_item_withHoldingTaxAmount">
<span<?= $Page->withHoldingTaxAmount->viewAttributes() ?>>
<?= $Page->withHoldingTaxAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isdelete->Visible) { // isdelete ?>
        <td data-name="isdelete"<?= $Page->isdelete->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_isdelete" class="el_peak_expense_item_isdelete">
<span<?= $Page->isdelete->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_isdelete_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isdelete->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isdelete->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isdelete_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_cdate" class="el_peak_expense_item_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_cuser" class="el_peak_expense_item_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_cip" class="el_peak_expense_item_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_udate" class="el_peak_expense_item_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_uuser" class="el_peak_expense_item_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_expense_item_uip" class="el_peak_expense_item_uip">
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
    ew.addEventHandlers("peak_expense_item");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
