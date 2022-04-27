<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetAllFacilitiesViewList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_all_facilities_view: currentTable } });
var currentForm, currentPageID;
var fasset_all_facilities_viewlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_all_facilities_viewlist = new ew.Form("fasset_all_facilities_viewlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fasset_all_facilities_viewlist;
    fasset_all_facilities_viewlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fasset_all_facilities_viewlist");
});
var fasset_all_facilities_viewsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fasset_all_facilities_viewsrch = new ew.Form("fasset_all_facilities_viewsrch", "list");
    currentSearchForm = fasset_all_facilities_viewsrch;

    // Add fields
    var fields = currentTable.fields;
    fasset_all_facilities_viewsrch.addFields([
        ["group_title", [], fields.group_title.isInvalid],
        ["group_title_en", [], fields.group_title_en.isInvalid],
        ["_title", [], fields._title.isInvalid],
        ["title_en", [], fields.title_en.isInvalid]
    ]);

    // Validate form
    fasset_all_facilities_viewsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fasset_all_facilities_viewsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_all_facilities_viewsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists

    // Filters
    fasset_all_facilities_viewsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fasset_all_facilities_viewsrch");
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
<form name="fasset_all_facilities_viewsrch" id="fasset_all_facilities_viewsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fasset_all_facilities_viewsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="asset_all_facilities_view">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->group_title->Visible) { // group_title ?>
<?php
if (!$Page->group_title->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_group_title" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->group_title->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_group_title" class="ew-search-caption ew-label"><?= $Page->group_title->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_group_title" id="z_group_title" value="LIKE">
</div>
        </div>
        <div id="el_asset_all_facilities_view_group_title" class="ew-search-field">
<input type="<?= $Page->group_title->getInputTextType() ?>" name="x_group_title" id="x_group_title" data-table="asset_all_facilities_view" data-field="x_group_title" value="<?= $Page->group_title->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->group_title->getPlaceHolder()) ?>"<?= $Page->group_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->group_title->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->group_title_en->Visible) { // group_title_en ?>
<?php
if (!$Page->group_title_en->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_group_title_en" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->group_title_en->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_group_title_en" class="ew-search-caption ew-label"><?= $Page->group_title_en->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_group_title_en" id="z_group_title_en" value="LIKE">
</div>
        </div>
        <div id="el_asset_all_facilities_view_group_title_en" class="ew-search-field">
<input type="<?= $Page->group_title_en->getInputTextType() ?>" name="x_group_title_en" id="x_group_title_en" data-table="asset_all_facilities_view" data-field="x_group_title_en" value="<?= $Page->group_title_en->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->group_title_en->getPlaceHolder()) ?>"<?= $Page->group_title_en->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->group_title_en->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fasset_all_facilities_viewsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fasset_all_facilities_viewsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fasset_all_facilities_viewsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fasset_all_facilities_viewsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_all_facilities_view">
<form name="fasset_all_facilities_viewlist" id="fasset_all_facilities_viewlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_all_facilities_view">
<div id="gmp_asset_all_facilities_view" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_asset_all_facilities_viewlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->group_title->Visible) { // group_title ?>
        <th data-name="group_title" class="<?= $Page->group_title->headerCellClass() ?>"><div id="elh_asset_all_facilities_view_group_title" class="asset_all_facilities_view_group_title"><?= $Page->renderFieldHeader($Page->group_title) ?></div></th>
<?php } ?>
<?php if ($Page->group_title_en->Visible) { // group_title_en ?>
        <th data-name="group_title_en" class="<?= $Page->group_title_en->headerCellClass() ?>"><div id="elh_asset_all_facilities_view_group_title_en" class="asset_all_facilities_view_group_title_en"><?= $Page->renderFieldHeader($Page->group_title_en) ?></div></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_asset_all_facilities_view__title" class="asset_all_facilities_view__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
        <th data-name="title_en" class="<?= $Page->title_en->headerCellClass() ?>"><div id="elh_asset_all_facilities_view_title_en" class="asset_all_facilities_view_title_en"><?= $Page->renderFieldHeader($Page->title_en) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_asset_all_facilities_view",
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
    <?php if ($Page->group_title->Visible) { // group_title ?>
        <td data-name="group_title"<?= $Page->group_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_all_facilities_view_group_title" class="el_asset_all_facilities_view_group_title">
<span<?= $Page->group_title->viewAttributes() ?>>
<?= $Page->group_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->group_title_en->Visible) { // group_title_en ?>
        <td data-name="group_title_en"<?= $Page->group_title_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_all_facilities_view_group_title_en" class="el_asset_all_facilities_view_group_title_en">
<span<?= $Page->group_title_en->viewAttributes() ?>>
<?= $Page->group_title_en->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_all_facilities_view__title" class="el_asset_all_facilities_view__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->title_en->Visible) { // title_en ?>
        <td data-name="title_en"<?= $Page->title_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_all_facilities_view_title_en" class="el_asset_all_facilities_view_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
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
    ew.addEventHandlers("asset_all_facilities_view");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
