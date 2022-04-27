<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AssetGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fassetgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fassetgrid = new ew.Form("fassetgrid", "grid");
    fassetgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { asset: currentTable } });
    var fields = currentTable.fields;
    fassetgrid.addFields([
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["brand_id", [fields.brand_id.visible && fields.brand_id.required ? ew.Validators.required(fields.brand_id.caption) : null], fields.brand_id.isInvalid],
        ["asset_code", [fields.asset_code.visible && fields.asset_code.required ? ew.Validators.required(fields.asset_code.caption) : null], fields.asset_code.isInvalid],
        ["asset_status", [fields.asset_status.visible && fields.asset_status.required ? ew.Validators.required(fields.asset_status.caption) : null], fields.asset_status.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["price_mark", [fields.price_mark.visible && fields.price_mark.required ? ew.Validators.required(fields.price_mark.caption) : null, ew.Validators.float], fields.price_mark.isInvalid],
        ["usable_area", [fields.usable_area.visible && fields.usable_area.required ? ew.Validators.required(fields.usable_area.caption) : null], fields.usable_area.isInvalid],
        ["land_size", [fields.land_size.visible && fields.land_size.required ? ew.Validators.required(fields.land_size.caption) : null], fields.land_size.isInvalid],
        ["count_view", [fields.count_view.visible && fields.count_view.required ? ew.Validators.required(fields.count_view.caption) : null], fields.count_view.isInvalid],
        ["count_favorite", [fields.count_favorite.visible && fields.count_favorite.required ? ew.Validators.required(fields.count_favorite.caption) : null], fields.count_favorite.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fassetgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["_title",false],["brand_id",false],["asset_code",false],["asset_status",false],["isactive",false],["price_mark",false],["usable_area",false],["land_size",false],["count_view",false],["count_favorite",false],["expired_date",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fassetgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fassetgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fassetgrid.lists.brand_id = <?= $Grid->brand_id->toClientList($Grid) ?>;
    fassetgrid.lists.asset_status = <?= $Grid->asset_status->toClientList($Grid) ?>;
    fassetgrid.lists.isactive = <?= $Grid->isactive->toClientList($Grid) ?>;
    loadjs.done("fassetgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset">
<div id="fassetgrid" class="ew-form ew-list-form">
<div id="gmp_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_assetgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Grid->_title->headerCellClass() ?>"><div id="elh_asset__title" class="asset__title"><?= $Grid->renderFieldHeader($Grid->_title) ?></div></th>
<?php } ?>
<?php if ($Grid->brand_id->Visible) { // brand_id ?>
        <th data-name="brand_id" class="<?= $Grid->brand_id->headerCellClass() ?>"><div id="elh_asset_brand_id" class="asset_brand_id"><?= $Grid->renderFieldHeader($Grid->brand_id) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Grid->asset_code->headerCellClass() ?>"><div id="elh_asset_asset_code" class="asset_asset_code"><?= $Grid->renderFieldHeader($Grid->asset_code) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_status->Visible) { // asset_status ?>
        <th data-name="asset_status" class="<?= $Grid->asset_status->headerCellClass() ?>"><div id="elh_asset_asset_status" class="asset_asset_status"><?= $Grid->renderFieldHeader($Grid->asset_status) ?></div></th>
<?php } ?>
<?php if ($Grid->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Grid->isactive->headerCellClass() ?>"><div id="elh_asset_isactive" class="asset_isactive"><?= $Grid->renderFieldHeader($Grid->isactive) ?></div></th>
<?php } ?>
<?php if ($Grid->price_mark->Visible) { // price_mark ?>
        <th data-name="price_mark" class="<?= $Grid->price_mark->headerCellClass() ?>"><div id="elh_asset_price_mark" class="asset_price_mark"><?= $Grid->renderFieldHeader($Grid->price_mark) ?></div></th>
<?php } ?>
<?php if ($Grid->usable_area->Visible) { // usable_area ?>
        <th data-name="usable_area" class="<?= $Grid->usable_area->headerCellClass() ?>"><div id="elh_asset_usable_area" class="asset_usable_area"><?= $Grid->renderFieldHeader($Grid->usable_area) ?></div></th>
<?php } ?>
<?php if ($Grid->land_size->Visible) { // land_size ?>
        <th data-name="land_size" class="<?= $Grid->land_size->headerCellClass() ?>"><div id="elh_asset_land_size" class="asset_land_size"><?= $Grid->renderFieldHeader($Grid->land_size) ?></div></th>
<?php } ?>
<?php if ($Grid->count_view->Visible) { // count_view ?>
        <th data-name="count_view" class="<?= $Grid->count_view->headerCellClass() ?>"><div id="elh_asset_count_view" class="asset_count_view"><?= $Grid->renderFieldHeader($Grid->count_view) ?></div></th>
<?php } ?>
<?php if ($Grid->count_favorite->Visible) { // count_favorite ?>
        <th data-name="count_favorite" class="<?= $Grid->count_favorite->headerCellClass() ?>"><div id="elh_asset_count_favorite" class="asset_count_favorite"><?= $Grid->renderFieldHeader($Grid->count_favorite) ?></div></th>
<?php } ?>
<?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Grid->expired_date->headerCellClass() ?>"><div id="elh_asset_expired_date" class="asset_expired_date"><?= $Grid->renderFieldHeader($Grid->expired_date) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_asset_cdate" class="asset_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif ($Grid->isGridAdd() && !$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isAdd() || $Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row attributes
        $Grid->RowAttrs->merge([
            "data-rowindex" => $Grid->RowCount,
            "id" => "r" . $Grid->RowCount . "_asset",
            "data-rowtype" => $Grid->RowType,
            "class" => ($Grid->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Grid->isAdd() && $Grid->RowType == ROWTYPE_ADD || $Grid->isEdit() && $Grid->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Grid->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Grid->_title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset__title" class="el_asset__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="asset" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x__title" data-hidden="1" name="o<?= $Grid->RowIndex ?>__title" id="o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset__title" class="el_asset__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="asset" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset__title" class="el_asset__title">
<span<?= $Grid->_title->viewAttributes() ?>>
<?= $Grid->_title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x__title" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>__title" id="fassetgrid$x<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x__title" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>__title" id="fassetgrid$o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->brand_id->Visible) { // brand_id ?>
        <td data-name="brand_id"<?= $Grid->brand_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_brand_id" class="el_asset_brand_id">
    <select
        id="x<?= $Grid->RowIndex ?>_brand_id"
        name="x<?= $Grid->RowIndex ?>_brand_id"
        class="form-select ew-select<?= $Grid->brand_id->isInvalidClass() ?>"
        data-select2-id="fassetgrid_x<?= $Grid->RowIndex ?>_brand_id"
        data-table="asset"
        data-field="x_brand_id"
        data-value-separator="<?= $Grid->brand_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->brand_id->getPlaceHolder()) ?>"
        <?= $Grid->brand_id->editAttributes() ?>>
        <?= $Grid->brand_id->selectOptionListHtml("x{$Grid->RowIndex}_brand_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->brand_id->getErrorMessage() ?></div>
<?= $Grid->brand_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_brand_id") ?>
<script>
loadjs.ready("fassetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_brand_id", selectId: "fassetgrid_x<?= $Grid->RowIndex ?>_brand_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetgrid.lists.brand_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_brand_id", form: "fassetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_brand_id", form: "fassetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.brand_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset" data-field="x_brand_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_brand_id" id="o<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_brand_id" class="el_asset_brand_id">
    <select
        id="x<?= $Grid->RowIndex ?>_brand_id"
        name="x<?= $Grid->RowIndex ?>_brand_id"
        class="form-select ew-select<?= $Grid->brand_id->isInvalidClass() ?>"
        data-select2-id="fassetgrid_x<?= $Grid->RowIndex ?>_brand_id"
        data-table="asset"
        data-field="x_brand_id"
        data-value-separator="<?= $Grid->brand_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->brand_id->getPlaceHolder()) ?>"
        <?= $Grid->brand_id->editAttributes() ?>>
        <?= $Grid->brand_id->selectOptionListHtml("x{$Grid->RowIndex}_brand_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->brand_id->getErrorMessage() ?></div>
<?= $Grid->brand_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_brand_id") ?>
<script>
loadjs.ready("fassetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_brand_id", selectId: "fassetgrid_x<?= $Grid->RowIndex ?>_brand_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetgrid.lists.brand_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_brand_id", form: "fassetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_brand_id", form: "fassetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.brand_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_brand_id" class="el_asset_brand_id">
<span<?= $Grid->brand_id->viewAttributes() ?>>
<?= $Grid->brand_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_brand_id" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_brand_id" id="fassetgrid$x<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_brand_id" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_brand_id" id="fassetgrid$o<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Grid->asset_code->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_asset_code" class="el_asset_asset_code">
<input type="<?= $Grid->asset_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" data-table="asset" data-field="x_asset_code" value="<?= $Grid->asset_code->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->asset_code->getPlaceHolder()) ?>"<?= $Grid->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_code->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_asset_code" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_code" id="o<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_asset_code" class="el_asset_asset_code">
<span<?= $Grid->asset_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_code->getDisplayValue($Grid->asset_code->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_asset_code" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_asset_code" class="el_asset_asset_code">
<span<?= $Grid->asset_code->viewAttributes() ?>>
<?= $Grid->asset_code->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_asset_code" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_asset_code" id="fassetgrid$x<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_asset_code" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_asset_code" id="fassetgrid$o<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_status->Visible) { // asset_status ?>
        <td data-name="asset_status"<?= $Grid->asset_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_asset_status" class="el_asset_asset_status">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_status"
        name="x<?= $Grid->RowIndex ?>_asset_status"
        class="form-select ew-select<?= $Grid->asset_status->isInvalidClass() ?>"
        data-select2-id="fassetgrid_x<?= $Grid->RowIndex ?>_asset_status"
        data-table="asset"
        data-field="x_asset_status"
        data-value-separator="<?= $Grid->asset_status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_status->getPlaceHolder()) ?>"
        <?= $Grid->asset_status->editAttributes() ?>>
        <?= $Grid->asset_status->selectOptionListHtml("x{$Grid->RowIndex}_asset_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_status->getErrorMessage() ?></div>
<script>
loadjs.ready("fassetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_status", selectId: "fassetgrid_x<?= $Grid->RowIndex ?>_asset_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetgrid.lists.asset_status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_status", form: "fassetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_status", form: "fassetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.asset_status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset" data-field="x_asset_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_status" id="o<?= $Grid->RowIndex ?>_asset_status" value="<?= HtmlEncode($Grid->asset_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_asset_status" class="el_asset_asset_status">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_status"
        name="x<?= $Grid->RowIndex ?>_asset_status"
        class="form-select ew-select<?= $Grid->asset_status->isInvalidClass() ?>"
        data-select2-id="fassetgrid_x<?= $Grid->RowIndex ?>_asset_status"
        data-table="asset"
        data-field="x_asset_status"
        data-value-separator="<?= $Grid->asset_status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_status->getPlaceHolder()) ?>"
        <?= $Grid->asset_status->editAttributes() ?>>
        <?= $Grid->asset_status->selectOptionListHtml("x{$Grid->RowIndex}_asset_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_status->getErrorMessage() ?></div>
<script>
loadjs.ready("fassetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_status", selectId: "fassetgrid_x<?= $Grid->RowIndex ?>_asset_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetgrid.lists.asset_status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_status", form: "fassetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_status", form: "fassetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.asset_status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_asset_status" class="el_asset_asset_status">
<span<?= $Grid->asset_status->viewAttributes() ?>>
<?= $Grid->asset_status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_asset_status" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_asset_status" id="fassetgrid$x<?= $Grid->RowIndex ?>_asset_status" value="<?= HtmlEncode($Grid->asset_status->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_asset_status" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_asset_status" id="fassetgrid$o<?= $Grid->RowIndex ?>_asset_status" value="<?= HtmlEncode($Grid->asset_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive"<?= $Grid->isactive->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_isactive" class="el_asset_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_isactive"
    name="x<?= $Grid->RowIndex ?>_isactive"
    value="<?= HtmlEncode($Grid->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_isactive"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->isactive->isInvalidClass() ?>"
    data-table="asset"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_isactive" class="el_asset_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_isactive"
    name="x<?= $Grid->RowIndex ?>_isactive"
    value="<?= HtmlEncode($Grid->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_isactive"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->isactive->isInvalidClass() ?>"
    data-table="asset"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_isactive" class="el_asset_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<?= $Grid->isactive->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_isactive" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_isactive" id="fassetgrid$x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_isactive" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_isactive" id="fassetgrid$o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->price_mark->Visible) { // price_mark ?>
        <td data-name="price_mark"<?= $Grid->price_mark->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_price_mark" class="el_asset_price_mark">
<input type="<?= $Grid->price_mark->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_price_mark" id="x<?= $Grid->RowIndex ?>_price_mark" data-table="asset" data-field="x_price_mark" value="<?= $Grid->price_mark->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->price_mark->getPlaceHolder()) ?>"<?= $Grid->price_mark->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->price_mark->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_price_mark" data-hidden="1" name="o<?= $Grid->RowIndex ?>_price_mark" id="o<?= $Grid->RowIndex ?>_price_mark" value="<?= HtmlEncode($Grid->price_mark->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_price_mark" class="el_asset_price_mark">
<input type="<?= $Grid->price_mark->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_price_mark" id="x<?= $Grid->RowIndex ?>_price_mark" data-table="asset" data-field="x_price_mark" value="<?= $Grid->price_mark->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->price_mark->getPlaceHolder()) ?>"<?= $Grid->price_mark->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->price_mark->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_price_mark" class="el_asset_price_mark">
<span<?= $Grid->price_mark->viewAttributes() ?>>
<?= $Grid->price_mark->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_price_mark" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_price_mark" id="fassetgrid$x<?= $Grid->RowIndex ?>_price_mark" value="<?= HtmlEncode($Grid->price_mark->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_price_mark" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_price_mark" id="fassetgrid$o<?= $Grid->RowIndex ?>_price_mark" value="<?= HtmlEncode($Grid->price_mark->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usable_area->Visible) { // usable_area ?>
        <td data-name="usable_area"<?= $Grid->usable_area->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_usable_area" class="el_asset_usable_area">
<input type="<?= $Grid->usable_area->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area" id="x<?= $Grid->RowIndex ?>_usable_area" data-table="asset" data-field="x_usable_area" value="<?= $Grid->usable_area->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->usable_area->getPlaceHolder()) ?>"<?= $Grid->usable_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_usable_area" data-hidden="1" name="o<?= $Grid->RowIndex ?>_usable_area" id="o<?= $Grid->RowIndex ?>_usable_area" value="<?= HtmlEncode($Grid->usable_area->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_usable_area" class="el_asset_usable_area">
<input type="<?= $Grid->usable_area->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area" id="x<?= $Grid->RowIndex ?>_usable_area" data-table="asset" data-field="x_usable_area" value="<?= $Grid->usable_area->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->usable_area->getPlaceHolder()) ?>"<?= $Grid->usable_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_usable_area" class="el_asset_usable_area">
<span<?= $Grid->usable_area->viewAttributes() ?>>
<?= $Grid->usable_area->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_usable_area" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_usable_area" id="fassetgrid$x<?= $Grid->RowIndex ?>_usable_area" value="<?= HtmlEncode($Grid->usable_area->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_usable_area" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_usable_area" id="fassetgrid$o<?= $Grid->RowIndex ?>_usable_area" value="<?= HtmlEncode($Grid->usable_area->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->land_size->Visible) { // land_size ?>
        <td data-name="land_size"<?= $Grid->land_size->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_land_size" class="el_asset_land_size">
<input type="<?= $Grid->land_size->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size" id="x<?= $Grid->RowIndex ?>_land_size" data-table="asset" data-field="x_land_size" value="<?= $Grid->land_size->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->land_size->getPlaceHolder()) ?>"<?= $Grid->land_size->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_land_size" data-hidden="1" name="o<?= $Grid->RowIndex ?>_land_size" id="o<?= $Grid->RowIndex ?>_land_size" value="<?= HtmlEncode($Grid->land_size->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_land_size" class="el_asset_land_size">
<input type="<?= $Grid->land_size->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size" id="x<?= $Grid->RowIndex ?>_land_size" data-table="asset" data-field="x_land_size" value="<?= $Grid->land_size->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->land_size->getPlaceHolder()) ?>"<?= $Grid->land_size->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_land_size" class="el_asset_land_size">
<span<?= $Grid->land_size->viewAttributes() ?>>
<?= $Grid->land_size->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_land_size" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_land_size" id="fassetgrid$x<?= $Grid->RowIndex ?>_land_size" value="<?= HtmlEncode($Grid->land_size->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_land_size" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_land_size" id="fassetgrid$o<?= $Grid->RowIndex ?>_land_size" value="<?= HtmlEncode($Grid->land_size->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->count_view->Visible) { // count_view ?>
        <td data-name="count_view"<?= $Grid->count_view->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_count_view" class="el_asset_count_view">
<input type="<?= $Grid->count_view->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_count_view" id="x<?= $Grid->RowIndex ?>_count_view" data-table="asset" data-field="x_count_view" value="<?= $Grid->count_view->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->count_view->getPlaceHolder()) ?>"<?= $Grid->count_view->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->count_view->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_count_view" data-hidden="1" name="o<?= $Grid->RowIndex ?>_count_view" id="o<?= $Grid->RowIndex ?>_count_view" value="<?= HtmlEncode($Grid->count_view->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_count_view" class="el_asset_count_view">
<span<?= $Grid->count_view->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->count_view->getDisplayValue($Grid->count_view->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_count_view" data-hidden="1" name="x<?= $Grid->RowIndex ?>_count_view" id="x<?= $Grid->RowIndex ?>_count_view" value="<?= HtmlEncode($Grid->count_view->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_count_view" class="el_asset_count_view">
<span<?= $Grid->count_view->viewAttributes() ?>>
<?= $Grid->count_view->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_count_view" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_count_view" id="fassetgrid$x<?= $Grid->RowIndex ?>_count_view" value="<?= HtmlEncode($Grid->count_view->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_count_view" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_count_view" id="fassetgrid$o<?= $Grid->RowIndex ?>_count_view" value="<?= HtmlEncode($Grid->count_view->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->count_favorite->Visible) { // count_favorite ?>
        <td data-name="count_favorite"<?= $Grid->count_favorite->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_count_favorite" class="el_asset_count_favorite">
<input type="<?= $Grid->count_favorite->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_count_favorite" id="x<?= $Grid->RowIndex ?>_count_favorite" data-table="asset" data-field="x_count_favorite" value="<?= $Grid->count_favorite->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->count_favorite->getPlaceHolder()) ?>"<?= $Grid->count_favorite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->count_favorite->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset" data-field="x_count_favorite" data-hidden="1" name="o<?= $Grid->RowIndex ?>_count_favorite" id="o<?= $Grid->RowIndex ?>_count_favorite" value="<?= HtmlEncode($Grid->count_favorite->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_count_favorite" class="el_asset_count_favorite">
<span<?= $Grid->count_favorite->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->count_favorite->getDisplayValue($Grid->count_favorite->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_count_favorite" data-hidden="1" name="x<?= $Grid->RowIndex ?>_count_favorite" id="x<?= $Grid->RowIndex ?>_count_favorite" value="<?= HtmlEncode($Grid->count_favorite->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_count_favorite" class="el_asset_count_favorite">
<span<?= $Grid->count_favorite->viewAttributes() ?>>
<?= $Grid->count_favorite->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_count_favorite" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_count_favorite" id="fassetgrid$x<?= $Grid->RowIndex ?>_count_favorite" value="<?= HtmlEncode($Grid->count_favorite->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_count_favorite" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_count_favorite" id="fassetgrid$o<?= $Grid->RowIndex ?>_count_favorite" value="<?= HtmlEncode($Grid->count_favorite->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Grid->expired_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_expired_date" class="el_asset_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="asset" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetgrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="asset" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_expired_date" class="el_asset_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="asset" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetgrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_expired_date" class="el_asset_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<?= $Grid->expired_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_expired_date" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_expired_date" id="fassetgrid$x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_expired_date" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_expired_date" id="fassetgrid$o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_cdate" class="el_asset_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset" data-field="x_cdate" data-hidden="1" name="fassetgrid$x<?= $Grid->RowIndex ?>_cdate" id="fassetgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="asset" data-field="x_cdate" data-hidden="1" name="fassetgrid$o<?= $Grid->RowIndex ?>_cdate" id="fassetgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fassetgrid","load"], () => fassetgrid.updateLists(<?= $Grid->RowIndex ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
    $Grid->RowIndex = '$rowindex$';
    $Grid->loadRowValues();

    // Set row properties
    $Grid->resetAttributes();
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_asset", "data-rowtype" => ROWTYPE_ADD]);
    $Grid->RowAttrs->appendClass("ew-template");

    // Reset previous form error if any
    $Grid->resetFormError();

    // Render row
    $Grid->RowType = ROWTYPE_ADD;
    $Grid->renderRow();

    // Render list options
    $Grid->renderListOptions();
    $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->_title->Visible) { // title ?>
        <td data-name="_title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset__title" class="el_asset__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="asset" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset__title" class="el_asset__title">
<span<?= $Grid->_title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_title->getDisplayValue($Grid->_title->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x__title" data-hidden="1" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x__title" data-hidden="1" name="o<?= $Grid->RowIndex ?>__title" id="o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->brand_id->Visible) { // brand_id ?>
        <td data-name="brand_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_brand_id" class="el_asset_brand_id">
    <select
        id="x<?= $Grid->RowIndex ?>_brand_id"
        name="x<?= $Grid->RowIndex ?>_brand_id"
        class="form-select ew-select<?= $Grid->brand_id->isInvalidClass() ?>"
        data-select2-id="fassetgrid_x<?= $Grid->RowIndex ?>_brand_id"
        data-table="asset"
        data-field="x_brand_id"
        data-value-separator="<?= $Grid->brand_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->brand_id->getPlaceHolder()) ?>"
        <?= $Grid->brand_id->editAttributes() ?>>
        <?= $Grid->brand_id->selectOptionListHtml("x{$Grid->RowIndex}_brand_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->brand_id->getErrorMessage() ?></div>
<?= $Grid->brand_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_brand_id") ?>
<script>
loadjs.ready("fassetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_brand_id", selectId: "fassetgrid_x<?= $Grid->RowIndex ?>_brand_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetgrid.lists.brand_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_brand_id", form: "fassetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_brand_id", form: "fassetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.brand_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_brand_id" class="el_asset_brand_id">
<span<?= $Grid->brand_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->brand_id->getDisplayValue($Grid->brand_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset" data-field="x_brand_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_brand_id" id="x<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_brand_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_brand_id" id="o<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_asset_code" class="el_asset_asset_code">
<input type="<?= $Grid->asset_code->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" data-table="asset" data-field="x_asset_code" value="<?= $Grid->asset_code->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->asset_code->getPlaceHolder()) ?>"<?= $Grid->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_code->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_asset_code" class="el_asset_asset_code">
<span<?= $Grid->asset_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_code->getDisplayValue($Grid->asset_code->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_asset_code" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_code" id="x<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_asset_code" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_code" id="o<?= $Grid->RowIndex ?>_asset_code" value="<?= HtmlEncode($Grid->asset_code->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_status->Visible) { // asset_status ?>
        <td data-name="asset_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_asset_status" class="el_asset_asset_status">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_status"
        name="x<?= $Grid->RowIndex ?>_asset_status"
        class="form-select ew-select<?= $Grid->asset_status->isInvalidClass() ?>"
        data-select2-id="fassetgrid_x<?= $Grid->RowIndex ?>_asset_status"
        data-table="asset"
        data-field="x_asset_status"
        data-value-separator="<?= $Grid->asset_status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_status->getPlaceHolder()) ?>"
        <?= $Grid->asset_status->editAttributes() ?>>
        <?= $Grid->asset_status->selectOptionListHtml("x{$Grid->RowIndex}_asset_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_status->getErrorMessage() ?></div>
<script>
loadjs.ready("fassetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_status", selectId: "fassetgrid_x<?= $Grid->RowIndex ?>_asset_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetgrid.lists.asset_status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_status", form: "fassetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_status", form: "fassetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.asset_status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_asset_status" class="el_asset_asset_status">
<span<?= $Grid->asset_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_status->getDisplayValue($Grid->asset_status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset" data-field="x_asset_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_status" id="x<?= $Grid->RowIndex ?>_asset_status" value="<?= HtmlEncode($Grid->asset_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_asset_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_status" id="o<?= $Grid->RowIndex ?>_asset_status" value="<?= HtmlEncode($Grid->asset_status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_isactive" class="el_asset_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_isactive"
    name="x<?= $Grid->RowIndex ?>_isactive"
    value="<?= HtmlEncode($Grid->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_isactive"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->isactive->isInvalidClass() ?>"
    data-table="asset"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_isactive" class="el_asset_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->isactive->getDisplayValue($Grid->isactive->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset" data-field="x_isactive" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->price_mark->Visible) { // price_mark ?>
        <td data-name="price_mark">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_price_mark" class="el_asset_price_mark">
<input type="<?= $Grid->price_mark->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_price_mark" id="x<?= $Grid->RowIndex ?>_price_mark" data-table="asset" data-field="x_price_mark" value="<?= $Grid->price_mark->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->price_mark->getPlaceHolder()) ?>"<?= $Grid->price_mark->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->price_mark->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_price_mark" class="el_asset_price_mark">
<span<?= $Grid->price_mark->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->price_mark->getDisplayValue($Grid->price_mark->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_price_mark" data-hidden="1" name="x<?= $Grid->RowIndex ?>_price_mark" id="x<?= $Grid->RowIndex ?>_price_mark" value="<?= HtmlEncode($Grid->price_mark->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_price_mark" data-hidden="1" name="o<?= $Grid->RowIndex ?>_price_mark" id="o<?= $Grid->RowIndex ?>_price_mark" value="<?= HtmlEncode($Grid->price_mark->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->usable_area->Visible) { // usable_area ?>
        <td data-name="usable_area">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_usable_area" class="el_asset_usable_area">
<input type="<?= $Grid->usable_area->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area" id="x<?= $Grid->RowIndex ?>_usable_area" data-table="asset" data-field="x_usable_area" value="<?= $Grid->usable_area->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->usable_area->getPlaceHolder()) ?>"<?= $Grid->usable_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_usable_area" class="el_asset_usable_area">
<span<?= $Grid->usable_area->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->usable_area->getDisplayValue($Grid->usable_area->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_usable_area" data-hidden="1" name="x<?= $Grid->RowIndex ?>_usable_area" id="x<?= $Grid->RowIndex ?>_usable_area" value="<?= HtmlEncode($Grid->usable_area->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_usable_area" data-hidden="1" name="o<?= $Grid->RowIndex ?>_usable_area" id="o<?= $Grid->RowIndex ?>_usable_area" value="<?= HtmlEncode($Grid->usable_area->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->land_size->Visible) { // land_size ?>
        <td data-name="land_size">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_land_size" class="el_asset_land_size">
<input type="<?= $Grid->land_size->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size" id="x<?= $Grid->RowIndex ?>_land_size" data-table="asset" data-field="x_land_size" value="<?= $Grid->land_size->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->land_size->getPlaceHolder()) ?>"<?= $Grid->land_size->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_land_size" class="el_asset_land_size">
<span<?= $Grid->land_size->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->land_size->getDisplayValue($Grid->land_size->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_land_size" data-hidden="1" name="x<?= $Grid->RowIndex ?>_land_size" id="x<?= $Grid->RowIndex ?>_land_size" value="<?= HtmlEncode($Grid->land_size->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_land_size" data-hidden="1" name="o<?= $Grid->RowIndex ?>_land_size" id="o<?= $Grid->RowIndex ?>_land_size" value="<?= HtmlEncode($Grid->land_size->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->count_view->Visible) { // count_view ?>
        <td data-name="count_view">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_count_view" class="el_asset_count_view">
<input type="<?= $Grid->count_view->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_count_view" id="x<?= $Grid->RowIndex ?>_count_view" data-table="asset" data-field="x_count_view" value="<?= $Grid->count_view->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->count_view->getPlaceHolder()) ?>"<?= $Grid->count_view->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->count_view->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_count_view" class="el_asset_count_view">
<span<?= $Grid->count_view->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->count_view->getDisplayValue($Grid->count_view->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_count_view" data-hidden="1" name="x<?= $Grid->RowIndex ?>_count_view" id="x<?= $Grid->RowIndex ?>_count_view" value="<?= HtmlEncode($Grid->count_view->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_count_view" data-hidden="1" name="o<?= $Grid->RowIndex ?>_count_view" id="o<?= $Grid->RowIndex ?>_count_view" value="<?= HtmlEncode($Grid->count_view->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->count_favorite->Visible) { // count_favorite ?>
        <td data-name="count_favorite">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_count_favorite" class="el_asset_count_favorite">
<input type="<?= $Grid->count_favorite->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_count_favorite" id="x<?= $Grid->RowIndex ?>_count_favorite" data-table="asset" data-field="x_count_favorite" value="<?= $Grid->count_favorite->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->count_favorite->getPlaceHolder()) ?>"<?= $Grid->count_favorite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->count_favorite->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_count_favorite" class="el_asset_count_favorite">
<span<?= $Grid->count_favorite->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->count_favorite->getDisplayValue($Grid->count_favorite->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_count_favorite" data-hidden="1" name="x<?= $Grid->RowIndex ?>_count_favorite" id="x<?= $Grid->RowIndex ?>_count_favorite" value="<?= HtmlEncode($Grid->count_favorite->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_count_favorite" data-hidden="1" name="o<?= $Grid->RowIndex ?>_count_favorite" id="o<?= $Grid->RowIndex ?>_count_favorite" value="<?= HtmlEncode($Grid->count_favorite->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_expired_date" class="el_asset_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="asset" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetgrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_expired_date" class="el_asset_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->expired_date->getDisplayValue($Grid->expired_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_expired_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_cdate" class="el_asset_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fassetgrid","load"], () => fassetgrid.updateLists(<?= $Grid->RowIndex ?>, true));
</script>
    </tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fassetgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
