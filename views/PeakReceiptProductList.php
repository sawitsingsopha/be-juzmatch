<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptProductList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt_product: currentTable } });
var currentForm, currentPageID;
var fpeak_receipt_productlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receipt_productlist = new ew.Form("fpeak_receipt_productlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpeak_receipt_productlist;
    fpeak_receipt_productlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpeak_receipt_productlist");
});
var fpeak_receipt_productsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpeak_receipt_productsrch = new ew.Form("fpeak_receipt_productsrch", "list");
    currentSearchForm = fpeak_receipt_productsrch;

    // Dynamic selection lists

    // Filters
    fpeak_receipt_productsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpeak_receipt_productsrch");
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
<form name="fpeak_receipt_productsrch" id="fpeak_receipt_productsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpeak_receipt_productsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="peak_receipt_product">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpeak_receipt_productsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpeak_receipt_productsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpeak_receipt_productsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpeak_receipt_productsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> peak_receipt_product">
<form name="fpeak_receipt_productlist" id="fpeak_receipt_productlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt_product">
<div id="gmp_peak_receipt_product" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_peak_receipt_productlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_peak_receipt_product_id" class="peak_receipt_product_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->peak_receipt_id->Visible) { // peak_receipt_id ?>
        <th data-name="peak_receipt_id" class="<?= $Page->peak_receipt_id->headerCellClass() ?>"><div id="elh_peak_receipt_product_peak_receipt_id" class="peak_receipt_product_peak_receipt_id"><?= $Page->renderFieldHeader($Page->peak_receipt_id) ?></div></th>
<?php } ?>
<?php if ($Page->products_id->Visible) { // products_id ?>
        <th data-name="products_id" class="<?= $Page->products_id->headerCellClass() ?>"><div id="elh_peak_receipt_product_products_id" class="peak_receipt_product_products_id"><?= $Page->renderFieldHeader($Page->products_id) ?></div></th>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
        <th data-name="productid" class="<?= $Page->productid->headerCellClass() ?>"><div id="elh_peak_receipt_product_productid" class="peak_receipt_product_productid"><?= $Page->renderFieldHeader($Page->productid) ?></div></th>
<?php } ?>
<?php if ($Page->productcode->Visible) { // productcode ?>
        <th data-name="productcode" class="<?= $Page->productcode->headerCellClass() ?>"><div id="elh_peak_receipt_product_productcode" class="peak_receipt_product_productcode"><?= $Page->renderFieldHeader($Page->productcode) ?></div></th>
<?php } ?>
<?php if ($Page->producttemplate->Visible) { // producttemplate ?>
        <th data-name="producttemplate" class="<?= $Page->producttemplate->headerCellClass() ?>"><div id="elh_peak_receipt_product_producttemplate" class="peak_receipt_product_producttemplate"><?= $Page->renderFieldHeader($Page->producttemplate) ?></div></th>
<?php } ?>
<?php if ($Page->accountcode->Visible) { // accountcode ?>
        <th data-name="accountcode" class="<?= $Page->accountcode->headerCellClass() ?>"><div id="elh_peak_receipt_product_accountcode" class="peak_receipt_product_accountcode"><?= $Page->renderFieldHeader($Page->accountcode) ?></div></th>
<?php } ?>
<?php if ($Page->accountSubId->Visible) { // accountSubId ?>
        <th data-name="accountSubId" class="<?= $Page->accountSubId->headerCellClass() ?>"><div id="elh_peak_receipt_product_accountSubId" class="peak_receipt_product_accountSubId"><?= $Page->renderFieldHeader($Page->accountSubId) ?></div></th>
<?php } ?>
<?php if ($Page->accountSubCode->Visible) { // accountSubCode ?>
        <th data-name="accountSubCode" class="<?= $Page->accountSubCode->headerCellClass() ?>"><div id="elh_peak_receipt_product_accountSubCode" class="peak_receipt_product_accountSubCode"><?= $Page->renderFieldHeader($Page->accountSubCode) ?></div></th>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
        <th data-name="quantity" class="<?= $Page->quantity->headerCellClass() ?>"><div id="elh_peak_receipt_product_quantity" class="peak_receipt_product_quantity"><?= $Page->renderFieldHeader($Page->quantity) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_peak_receipt_product_price" class="peak_receipt_product_price"><?= $Page->renderFieldHeader($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->discount->Visible) { // discount ?>
        <th data-name="discount" class="<?= $Page->discount->headerCellClass() ?>"><div id="elh_peak_receipt_product_discount" class="peak_receipt_product_discount"><?= $Page->renderFieldHeader($Page->discount) ?></div></th>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
        <th data-name="vatType" class="<?= $Page->vatType->headerCellClass() ?>"><div id="elh_peak_receipt_product_vatType" class="peak_receipt_product_vatType"><?= $Page->renderFieldHeader($Page->vatType) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_peak_receipt_product",
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
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_id" class="el_peak_receipt_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->peak_receipt_id->Visible) { // peak_receipt_id ?>
        <td data-name="peak_receipt_id"<?= $Page->peak_receipt_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_peak_receipt_id" class="el_peak_receipt_product_peak_receipt_id">
<span<?= $Page->peak_receipt_id->viewAttributes() ?>>
<?= $Page->peak_receipt_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->products_id->Visible) { // products_id ?>
        <td data-name="products_id"<?= $Page->products_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_products_id" class="el_peak_receipt_product_products_id">
<span<?= $Page->products_id->viewAttributes() ?>>
<?= $Page->products_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->productid->Visible) { // productid ?>
        <td data-name="productid"<?= $Page->productid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_productid" class="el_peak_receipt_product_productid">
<span<?= $Page->productid->viewAttributes() ?>>
<?= $Page->productid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->productcode->Visible) { // productcode ?>
        <td data-name="productcode"<?= $Page->productcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_productcode" class="el_peak_receipt_product_productcode">
<span<?= $Page->productcode->viewAttributes() ?>>
<?= $Page->productcode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->producttemplate->Visible) { // producttemplate ?>
        <td data-name="producttemplate"<?= $Page->producttemplate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_producttemplate" class="el_peak_receipt_product_producttemplate">
<span<?= $Page->producttemplate->viewAttributes() ?>>
<?= $Page->producttemplate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->accountcode->Visible) { // accountcode ?>
        <td data-name="accountcode"<?= $Page->accountcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_accountcode" class="el_peak_receipt_product_accountcode">
<span<?= $Page->accountcode->viewAttributes() ?>>
<?= $Page->accountcode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->accountSubId->Visible) { // accountSubId ?>
        <td data-name="accountSubId"<?= $Page->accountSubId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_accountSubId" class="el_peak_receipt_product_accountSubId">
<span<?= $Page->accountSubId->viewAttributes() ?>>
<?= $Page->accountSubId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->accountSubCode->Visible) { // accountSubCode ?>
        <td data-name="accountSubCode"<?= $Page->accountSubCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_accountSubCode" class="el_peak_receipt_product_accountSubCode">
<span<?= $Page->accountSubCode->viewAttributes() ?>>
<?= $Page->accountSubCode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->quantity->Visible) { // quantity ?>
        <td data-name="quantity"<?= $Page->quantity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_quantity" class="el_peak_receipt_product_quantity">
<span<?= $Page->quantity->viewAttributes() ?>>
<?= $Page->quantity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_price" class="el_peak_receipt_product_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->discount->Visible) { // discount ?>
        <td data-name="discount"<?= $Page->discount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_discount" class="el_peak_receipt_product_discount">
<span<?= $Page->discount->viewAttributes() ?>>
<?= $Page->discount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vatType->Visible) { // vatType ?>
        <td data-name="vatType"<?= $Page->vatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_receipt_product_vatType" class="el_peak_receipt_product_vatType">
<span<?= $Page->vatType->viewAttributes() ?>>
<?= $Page->vatType->getViewValue() ?></span>
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
    ew.addEventHandlers("peak_receipt_product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
