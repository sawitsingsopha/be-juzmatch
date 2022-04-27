<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetStockReportList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { assetStockReport: currentTable } });
var currentForm, currentPageID;
var fassetStockReportlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fassetStockReportlist = new ew.Form("fassetStockReportlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fassetStockReportlist;
    fassetStockReportlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fassetStockReportlist");
});
var fassetStockReportsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fassetStockReportsrch = new ew.Form("fassetStockReportsrch", "list");
    currentSearchForm = fassetStockReportsrch;

    // Add fields
    var fields = currentTable.fields;
    fassetStockReportsrch.addFields([
        ["asset_code", [], fields.asset_code.isInvalid],
        ["_title", [], fields._title.isInvalid],
        ["brand_name", [], fields.brand_name.isInvalid],
        ["full_address", [], fields.full_address.isInvalid],
        ["cdate", [ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["y_cdate", [ew.Validators.between], false],
        ["asset_status", [], fields.asset_status.isInvalid],
        ["price", [], fields.price.isInvalid],
        ["consignment_period", [], fields.consignment_period.isInvalid],
        ["member_favorite", [], fields.member_favorite.isInvalid],
        ["member_appointment", [], fields.member_appointment.isInvalid],
        ["member_appointment_done", [], fields.member_appointment_done.isInvalid]
    ]);

    // Validate form
    fassetStockReportsrch.validate = function () {
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
    fassetStockReportsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fassetStockReportsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fassetStockReportsrch.lists.asset_status = <?= $Page->asset_status->toClientList($Page) ?>;

    // Filters
    fassetStockReportsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fassetStockReportsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if ($Security->canImport()) { ?>
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
<?php } ?>

<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fassetStockReportsrch" id="fassetStockReportsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fassetStockReportsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="assetStockReport">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
<?php
if (!$Page->asset_code->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_code" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_code->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_code" class="ew-search-caption ew-label"><?= $Page->asset_code->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_asset_code" id="z_asset_code" value="LIKE">
</div>
        </div>
        <div id="el_assetStockReport_asset_code" class="ew-search-field">
<input type="<?= $Page->asset_code->getInputTextType() ?>" name="x_asset_code" id="x_asset_code" data-table="assetStockReport" data-field="x_asset_code" value="<?= $Page->asset_code->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->asset_code->getPlaceHolder()) ?>"<?= $Page->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->asset_code->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
<?php
if (!$Page->_title->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs__title" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->_title->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x__title" class="ew-search-caption ew-label"><?= $Page->_title->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__title" id="z__title" value="LIKE">
</div>
        </div>
        <div id="el_assetStockReport__title" class="ew-search-field">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="assetStockReport" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
<?php
if (!$Page->cdate->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cdate" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->cdate->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cdate" class="ew-search-caption ew-label"><?= $Page->cdate->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_cdate" id="z_cdate" value="BETWEEN">
</div>
        </div>
        <div id="el_assetStockReport_cdate" class="ew-search-field">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="assetStockReport" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetStockReportsrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fassetStockReportsrch", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_assetStockReport_cdate" class="ew-search-field2">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="y_cdate" id="y_cdate" data-table="assetStockReport" data-field="x_cdate" value="<?= $Page->cdate->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetStockReportsrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fassetStockReportsrch", "y_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
<?php
if (!$Page->asset_status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_status" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_status" class="ew-search-caption ew-label"><?= $Page->asset_status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_asset_status" id="z_asset_status" value="=">
</div>
        </div>
        <div id="el_assetStockReport_asset_status" class="ew-search-field">
    <select
        id="x_asset_status"
        name="x_asset_status"
        class="form-select ew-select<?= $Page->asset_status->isInvalidClass() ?>"
        data-select2-id="fassetStockReportsrch_x_asset_status"
        data-table="assetStockReport"
        data-field="x_asset_status"
        data-value-separator="<?= $Page->asset_status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_status->getPlaceHolder()) ?>"
        <?= $Page->asset_status->editAttributes() ?>>
        <?= $Page->asset_status->selectOptionListHtml("x_asset_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->asset_status->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fassetStockReportsrch", function() {
    var options = { name: "x_asset_status", selectId: "fassetStockReportsrch_x_asset_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetStockReportsrch.lists.asset_status.lookupOptions.length) {
        options.data = { id: "x_asset_status", form: "fassetStockReportsrch" };
    } else {
        options.ajax = { id: "x_asset_status", form: "fassetStockReportsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.assetStockReport.fields.asset_status.selectOptions);
    ew.createSelect(options);
});
</script>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fassetStockReportsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fassetStockReportsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fassetStockReportsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fassetStockReportsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> assetStockReport">
<form name="fassetStockReportlist" id="fassetStockReportlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="assetStockReport">
<div id="gmp_assetStockReport" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_assetStockReportlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Page->asset_code->headerCellClass() ?>"><div id="elh_assetStockReport_asset_code" class="assetStockReport_asset_code"><?= $Page->renderFieldHeader($Page->asset_code) ?></div></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_assetStockReport__title" class="assetStockReport__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->brand_name->Visible) { // brand_name ?>
        <th data-name="brand_name" class="<?= $Page->brand_name->headerCellClass() ?>"><div id="elh_assetStockReport_brand_name" class="assetStockReport_brand_name"><?= $Page->renderFieldHeader($Page->brand_name) ?></div></th>
<?php } ?>
<?php if ($Page->full_address->Visible) { // full_address ?>
        <th data-name="full_address" class="<?= $Page->full_address->headerCellClass() ?>"><div id="elh_assetStockReport_full_address" class="assetStockReport_full_address"><?= $Page->renderFieldHeader($Page->full_address) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_assetStockReport_cdate" class="assetStockReport_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
        <th data-name="asset_status" class="<?= $Page->asset_status->headerCellClass() ?>"><div id="elh_assetStockReport_asset_status" class="assetStockReport_asset_status"><?= $Page->renderFieldHeader($Page->asset_status) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_assetStockReport_price" class="assetStockReport_price"><?= $Page->renderFieldHeader($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->consignment_period->Visible) { // consignment_period ?>
        <th data-name="consignment_period" class="<?= $Page->consignment_period->headerCellClass() ?>"><div id="elh_assetStockReport_consignment_period" class="assetStockReport_consignment_period"><?= $Page->renderFieldHeader($Page->consignment_period) ?></div></th>
<?php } ?>
<?php if ($Page->member_favorite->Visible) { // member_favorite ?>
        <th data-name="member_favorite" class="<?= $Page->member_favorite->headerCellClass() ?>"><div id="elh_assetStockReport_member_favorite" class="assetStockReport_member_favorite"><?= $Page->renderFieldHeader($Page->member_favorite) ?></div></th>
<?php } ?>
<?php if ($Page->member_appointment->Visible) { // member_appointment ?>
        <th data-name="member_appointment" class="<?= $Page->member_appointment->headerCellClass() ?>"><div id="elh_assetStockReport_member_appointment" class="assetStockReport_member_appointment"><?= $Page->renderFieldHeader($Page->member_appointment) ?></div></th>
<?php } ?>
<?php if ($Page->member_appointment_done->Visible) { // member_appointment_done ?>
        <th data-name="member_appointment_done" class="<?= $Page->member_appointment_done->headerCellClass() ?>"><div id="elh_assetStockReport_member_appointment_done" class="assetStockReport_member_appointment_done"><?= $Page->renderFieldHeader($Page->member_appointment_done) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_assetStockReport",
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
    <?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_asset_code" class="el_assetStockReport_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport__title" class="el_assetStockReport__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->brand_name->Visible) { // brand_name ?>
        <td data-name="brand_name"<?= $Page->brand_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_brand_name" class="el_assetStockReport_brand_name">
<span<?= $Page->brand_name->viewAttributes() ?>>
<?= $Page->brand_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->full_address->Visible) { // full_address ?>
        <td data-name="full_address"<?= $Page->full_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_full_address" class="el_assetStockReport_full_address">
<span<?= $Page->full_address->viewAttributes() ?>>
<?= $Page->full_address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_cdate" class="el_assetStockReport_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_status->Visible) { // asset_status ?>
        <td data-name="asset_status"<?= $Page->asset_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_asset_status" class="el_assetStockReport_asset_status">
<span<?= $Page->asset_status->viewAttributes() ?>>
<?= $Page->asset_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_price" class="el_assetStockReport_price">
<span<?= $Page->price->viewAttributes() ?> style="white-space: nowrap;">
<?= "฿ ".number_format($Page->price->getViewValue(), 2) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->consignment_period->Visible) { // consignment_period ?>
        <td data-name="consignment_period"<?= $Page->consignment_period->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_consignment_period" class="el_assetStockReport_consignment_period">
<span<?= $Page->consignment_period->viewAttributes() ?>>
<?= $Page->consignment_period->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_favorite->Visible) { // member_favorite ?>
        <td data-name="member_favorite"<?= $Page->member_favorite->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_member_favorite" class="el_assetStockReport_member_favorite">
<span<?= $Page->member_favorite->viewAttributes() ?>>
<?= $Page->member_favorite->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_appointment->Visible) { // member_appointment ?>
        <td data-name="member_appointment"<?= $Page->member_appointment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_member_appointment" class="el_assetStockReport_member_appointment">
<span<?= $Page->member_appointment->viewAttributes() ?>>
<?= $Page->member_appointment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_appointment_done->Visible) { // member_appointment_done ?>
        <td data-name="member_appointment_done"<?= $Page->member_appointment_done->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetStockReport_member_appointment_done" class="el_assetStockReport_member_appointment_done">
<span<?= $Page->member_appointment_done->viewAttributes() ?>>
<?= $Page->member_appointment_done->getViewValue() ?></span>
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
        container: "gmp_assetStockReport",
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
    ew.addEventHandlers("assetStockReport");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
