<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakProductList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_product: currentTable } });
var currentForm, currentPageID;
var fpeak_productlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_productlist = new ew.Form("fpeak_productlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpeak_productlist;
    fpeak_productlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpeak_productlist");
});
var fpeak_productsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpeak_productsrch = new ew.Form("fpeak_productsrch", "list");
    currentSearchForm = fpeak_productsrch;

    // Dynamic selection lists

    // Filters
    fpeak_productsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpeak_productsrch");
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
<form name="fpeak_productsrch" id="fpeak_productsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpeak_productsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="peak_product">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpeak_productsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpeak_productsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpeak_productsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpeak_productsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> peak_product">
<form name="fpeak_productlist" id="fpeak_productlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_product">
<div id="gmp_peak_product" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_peak_productlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_peak_product_id" class="peak_product_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
        <th data-name="productid" class="<?= $Page->productid->headerCellClass() ?>"><div id="elh_peak_product_productid" class="peak_product_productid"><?= $Page->renderFieldHeader($Page->productid) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_peak_product_name" class="peak_product_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th data-name="code" class="<?= $Page->code->headerCellClass() ?>"><div id="elh_peak_product_code" class="peak_product_code"><?= $Page->renderFieldHeader($Page->code) ?></div></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Page->type->headerCellClass() ?>"><div id="elh_peak_product_type" class="peak_product_type"><?= $Page->renderFieldHeader($Page->type) ?></div></th>
<?php } ?>
<?php if ($Page->purchaseValue->Visible) { // purchaseValue ?>
        <th data-name="purchaseValue" class="<?= $Page->purchaseValue->headerCellClass() ?>"><div id="elh_peak_product_purchaseValue" class="peak_product_purchaseValue"><?= $Page->renderFieldHeader($Page->purchaseValue) ?></div></th>
<?php } ?>
<?php if ($Page->purchaseVatType->Visible) { // purchaseVatType ?>
        <th data-name="purchaseVatType" class="<?= $Page->purchaseVatType->headerCellClass() ?>"><div id="elh_peak_product_purchaseVatType" class="peak_product_purchaseVatType"><?= $Page->renderFieldHeader($Page->purchaseVatType) ?></div></th>
<?php } ?>
<?php if ($Page->purchaseAccount->Visible) { // purchaseAccount ?>
        <th data-name="purchaseAccount" class="<?= $Page->purchaseAccount->headerCellClass() ?>"><div id="elh_peak_product_purchaseAccount" class="peak_product_purchaseAccount"><?= $Page->renderFieldHeader($Page->purchaseAccount) ?></div></th>
<?php } ?>
<?php if ($Page->sellValue->Visible) { // sellValue ?>
        <th data-name="sellValue" class="<?= $Page->sellValue->headerCellClass() ?>"><div id="elh_peak_product_sellValue" class="peak_product_sellValue"><?= $Page->renderFieldHeader($Page->sellValue) ?></div></th>
<?php } ?>
<?php if ($Page->sellVatType->Visible) { // sellVatType ?>
        <th data-name="sellVatType" class="<?= $Page->sellVatType->headerCellClass() ?>"><div id="elh_peak_product_sellVatType" class="peak_product_sellVatType"><?= $Page->renderFieldHeader($Page->sellVatType) ?></div></th>
<?php } ?>
<?php if ($Page->sellAccount->Visible) { // sellAccount ?>
        <th data-name="sellAccount" class="<?= $Page->sellAccount->headerCellClass() ?>"><div id="elh_peak_product_sellAccount" class="peak_product_sellAccount"><?= $Page->renderFieldHeader($Page->sellAccount) ?></div></th>
<?php } ?>
<?php if ($Page->carryingBalanceValue->Visible) { // carryingBalanceValue ?>
        <th data-name="carryingBalanceValue" class="<?= $Page->carryingBalanceValue->headerCellClass() ?>"><div id="elh_peak_product_carryingBalanceValue" class="peak_product_carryingBalanceValue"><?= $Page->renderFieldHeader($Page->carryingBalanceValue) ?></div></th>
<?php } ?>
<?php if ($Page->carryingBalanceAmount->Visible) { // carryingBalanceAmount ?>
        <th data-name="carryingBalanceAmount" class="<?= $Page->carryingBalanceAmount->headerCellClass() ?>"><div id="elh_peak_product_carryingBalanceAmount" class="peak_product_carryingBalanceAmount"><?= $Page->renderFieldHeader($Page->carryingBalanceAmount) ?></div></th>
<?php } ?>
<?php if ($Page->remainingBalanceAmount->Visible) { // remainingBalanceAmount ?>
        <th data-name="remainingBalanceAmount" class="<?= $Page->remainingBalanceAmount->headerCellClass() ?>"><div id="elh_peak_product_remainingBalanceAmount" class="peak_product_remainingBalanceAmount"><?= $Page->renderFieldHeader($Page->remainingBalanceAmount) ?></div></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th data-name="create_date" class="<?= $Page->create_date->headerCellClass() ?>"><div id="elh_peak_product_create_date" class="peak_product_create_date"><?= $Page->renderFieldHeader($Page->create_date) ?></div></th>
<?php } ?>
<?php if ($Page->update_date->Visible) { // update_date ?>
        <th data-name="update_date" class="<?= $Page->update_date->headerCellClass() ?>"><div id="elh_peak_product_update_date" class="peak_product_update_date"><?= $Page->renderFieldHeader($Page->update_date) ?></div></th>
<?php } ?>
<?php if ($Page->post_message->Visible) { // post_message ?>
        <th data-name="post_message" class="<?= $Page->post_message->headerCellClass() ?>"><div id="elh_peak_product_post_message" class="peak_product_post_message"><?= $Page->renderFieldHeader($Page->post_message) ?></div></th>
<?php } ?>
<?php if ($Page->post_try_cnt->Visible) { // post_try_cnt ?>
        <th data-name="post_try_cnt" class="<?= $Page->post_try_cnt->headerCellClass() ?>"><div id="elh_peak_product_post_try_cnt" class="peak_product_post_try_cnt"><?= $Page->renderFieldHeader($Page->post_try_cnt) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_peak_product",
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
<span id="el<?= $Page->RowCount ?>_peak_product_id" class="el_peak_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->productid->Visible) { // productid ?>
        <td data-name="productid"<?= $Page->productid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_productid" class="el_peak_product_productid">
<span<?= $Page->productid->viewAttributes() ?>>
<?= $Page->productid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_name" class="el_peak_product_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->code->Visible) { // code ?>
        <td data-name="code"<?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_code" class="el_peak_product_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_type" class="el_peak_product_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->purchaseValue->Visible) { // purchaseValue ?>
        <td data-name="purchaseValue"<?= $Page->purchaseValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_purchaseValue" class="el_peak_product_purchaseValue">
<span<?= $Page->purchaseValue->viewAttributes() ?>>
<?= $Page->purchaseValue->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->purchaseVatType->Visible) { // purchaseVatType ?>
        <td data-name="purchaseVatType"<?= $Page->purchaseVatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_purchaseVatType" class="el_peak_product_purchaseVatType">
<span<?= $Page->purchaseVatType->viewAttributes() ?>>
<?= $Page->purchaseVatType->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->purchaseAccount->Visible) { // purchaseAccount ?>
        <td data-name="purchaseAccount"<?= $Page->purchaseAccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_purchaseAccount" class="el_peak_product_purchaseAccount">
<span<?= $Page->purchaseAccount->viewAttributes() ?>>
<?= $Page->purchaseAccount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sellValue->Visible) { // sellValue ?>
        <td data-name="sellValue"<?= $Page->sellValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_sellValue" class="el_peak_product_sellValue">
<span<?= $Page->sellValue->viewAttributes() ?>>
<?= $Page->sellValue->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sellVatType->Visible) { // sellVatType ?>
        <td data-name="sellVatType"<?= $Page->sellVatType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_sellVatType" class="el_peak_product_sellVatType">
<span<?= $Page->sellVatType->viewAttributes() ?>>
<?= $Page->sellVatType->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sellAccount->Visible) { // sellAccount ?>
        <td data-name="sellAccount"<?= $Page->sellAccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_sellAccount" class="el_peak_product_sellAccount">
<span<?= $Page->sellAccount->viewAttributes() ?>>
<?= $Page->sellAccount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->carryingBalanceValue->Visible) { // carryingBalanceValue ?>
        <td data-name="carryingBalanceValue"<?= $Page->carryingBalanceValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_carryingBalanceValue" class="el_peak_product_carryingBalanceValue">
<span<?= $Page->carryingBalanceValue->viewAttributes() ?>>
<?= $Page->carryingBalanceValue->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->carryingBalanceAmount->Visible) { // carryingBalanceAmount ?>
        <td data-name="carryingBalanceAmount"<?= $Page->carryingBalanceAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_carryingBalanceAmount" class="el_peak_product_carryingBalanceAmount">
<span<?= $Page->carryingBalanceAmount->viewAttributes() ?>>
<?= $Page->carryingBalanceAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->remainingBalanceAmount->Visible) { // remainingBalanceAmount ?>
        <td data-name="remainingBalanceAmount"<?= $Page->remainingBalanceAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_remainingBalanceAmount" class="el_peak_product_remainingBalanceAmount">
<span<?= $Page->remainingBalanceAmount->viewAttributes() ?>>
<?= $Page->remainingBalanceAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->create_date->Visible) { // create_date ?>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_create_date" class="el_peak_product_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->update_date->Visible) { // update_date ?>
        <td data-name="update_date"<?= $Page->update_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_update_date" class="el_peak_product_update_date">
<span<?= $Page->update_date->viewAttributes() ?>>
<?= $Page->update_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->post_message->Visible) { // post_message ?>
        <td data-name="post_message"<?= $Page->post_message->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_post_message" class="el_peak_product_post_message">
<span<?= $Page->post_message->viewAttributes() ?>>
<?= $Page->post_message->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->post_try_cnt->Visible) { // post_try_cnt ?>
        <td data-name="post_try_cnt"<?= $Page->post_try_cnt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_product_post_try_cnt" class="el_peak_product_post_try_cnt">
<span<?= $Page->post_try_cnt->viewAttributes() ?>>
<?= $Page->post_try_cnt->getViewValue() ?></span>
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
    ew.addEventHandlers("peak_product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
