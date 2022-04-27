<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AssetProsDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fasset_pros_detailgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_pros_detailgrid = new ew.Form("fasset_pros_detailgrid", "grid");
    fasset_pros_detailgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { asset_pros_detail: currentTable } });
    var fields = currentTable.fields;
    fasset_pros_detailgrid.addFields([
        ["detail", [fields.detail.visible && fields.detail.required ? ew.Validators.required(fields.detail.caption) : null], fields.detail.isInvalid],
        ["group_type", [fields.group_type.visible && fields.group_type.required ? ew.Validators.required(fields.group_type.caption) : null], fields.group_type.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null], fields.latitude.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null], fields.longitude.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fasset_pros_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["detail",false],["group_type",false],["latitude",false],["longitude",false],["isactive",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fasset_pros_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_pros_detailgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_pros_detailgrid.lists.group_type = <?= $Grid->group_type->toClientList($Grid) ?>;
    fasset_pros_detailgrid.lists.isactive = <?= $Grid->isactive->toClientList($Grid) ?>;
    loadjs.done("fasset_pros_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_pros_detail">
<div id="fasset_pros_detailgrid" class="ew-form ew-list-form">
<div id="gmp_asset_pros_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_asset_pros_detailgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->detail->Visible) { // detail ?>
        <th data-name="detail" class="<?= $Grid->detail->headerCellClass() ?>"><div id="elh_asset_pros_detail_detail" class="asset_pros_detail_detail"><?= $Grid->renderFieldHeader($Grid->detail) ?></div></th>
<?php } ?>
<?php if ($Grid->group_type->Visible) { // group_type ?>
        <th data-name="group_type" class="<?= $Grid->group_type->headerCellClass() ?>"><div id="elh_asset_pros_detail_group_type" class="asset_pros_detail_group_type"><?= $Grid->renderFieldHeader($Grid->group_type) ?></div></th>
<?php } ?>
<?php if ($Grid->latitude->Visible) { // latitude ?>
        <th data-name="latitude" class="<?= $Grid->latitude->headerCellClass() ?>"><div id="elh_asset_pros_detail_latitude" class="asset_pros_detail_latitude"><?= $Grid->renderFieldHeader($Grid->latitude) ?></div></th>
<?php } ?>
<?php if ($Grid->longitude->Visible) { // longitude ?>
        <th data-name="longitude" class="<?= $Grid->longitude->headerCellClass() ?>"><div id="elh_asset_pros_detail_longitude" class="asset_pros_detail_longitude"><?= $Grid->renderFieldHeader($Grid->longitude) ?></div></th>
<?php } ?>
<?php if ($Grid->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Grid->isactive->headerCellClass() ?>"><div id="elh_asset_pros_detail_isactive" class="asset_pros_detail_isactive"><?= $Grid->renderFieldHeader($Grid->isactive) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_asset_pros_detail_cdate" class="asset_pros_detail_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_asset_pros_detail",
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
    <?php if ($Grid->detail->Visible) { // detail ?>
        <td data-name="detail"<?= $Grid->detail->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_detail" class="el_asset_pros_detail_detail">
<textarea data-table="asset_pros_detail" data-field="x_detail" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->detail->getPlaceHolder()) ?>"<?= $Grid->detail->editAttributes() ?>><?= $Grid->detail->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->detail->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_detail" id="o<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_detail" class="el_asset_pros_detail_detail">
<textarea data-table="asset_pros_detail" data-field="x_detail" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->detail->getPlaceHolder()) ?>"<?= $Grid->detail->editAttributes() ?>><?= $Grid->detail->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->detail->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_detail" class="el_asset_pros_detail_detail">
<span<?= $Grid->detail->viewAttributes() ?>>
<?= $Grid->detail->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_detail" data-hidden="1" name="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_detail" id="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->FormValue) ?>">
<input type="hidden" data-table="asset_pros_detail" data-field="x_detail" data-hidden="1" name="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_detail" id="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->group_type->Visible) { // group_type ?>
        <td data-name="group_type"<?= $Grid->group_type->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_group_type" class="el_asset_pros_detail_group_type">
    <select
        id="x<?= $Grid->RowIndex ?>_group_type"
        name="x<?= $Grid->RowIndex ?>_group_type"
        class="form-select ew-select<?= $Grid->group_type->isInvalidClass() ?>"
        data-select2-id="fasset_pros_detailgrid_x<?= $Grid->RowIndex ?>_group_type"
        data-table="asset_pros_detail"
        data-field="x_group_type"
        data-value-separator="<?= $Grid->group_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->group_type->getPlaceHolder()) ?>"
        <?= $Grid->group_type->editAttributes() ?>>
        <?= $Grid->group_type->selectOptionListHtml("x{$Grid->RowIndex}_group_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->group_type->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_pros_detailgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_group_type", selectId: "fasset_pros_detailgrid_x<?= $Grid->RowIndex ?>_group_type" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_pros_detailgrid.lists.group_type.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_group_type", form: "fasset_pros_detailgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_group_type", form: "fasset_pros_detailgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_pros_detail.fields.group_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_group_type" data-hidden="1" name="o<?= $Grid->RowIndex ?>_group_type" id="o<?= $Grid->RowIndex ?>_group_type" value="<?= HtmlEncode($Grid->group_type->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_group_type" class="el_asset_pros_detail_group_type">
    <select
        id="x<?= $Grid->RowIndex ?>_group_type"
        name="x<?= $Grid->RowIndex ?>_group_type"
        class="form-select ew-select<?= $Grid->group_type->isInvalidClass() ?>"
        data-select2-id="fasset_pros_detailgrid_x<?= $Grid->RowIndex ?>_group_type"
        data-table="asset_pros_detail"
        data-field="x_group_type"
        data-value-separator="<?= $Grid->group_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->group_type->getPlaceHolder()) ?>"
        <?= $Grid->group_type->editAttributes() ?>>
        <?= $Grid->group_type->selectOptionListHtml("x{$Grid->RowIndex}_group_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->group_type->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_pros_detailgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_group_type", selectId: "fasset_pros_detailgrid_x<?= $Grid->RowIndex ?>_group_type" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_pros_detailgrid.lists.group_type.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_group_type", form: "fasset_pros_detailgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_group_type", form: "fasset_pros_detailgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_pros_detail.fields.group_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_group_type" class="el_asset_pros_detail_group_type">
<span<?= $Grid->group_type->viewAttributes() ?>>
<?= $Grid->group_type->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_group_type" data-hidden="1" name="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_group_type" id="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_group_type" value="<?= HtmlEncode($Grid->group_type->FormValue) ?>">
<input type="hidden" data-table="asset_pros_detail" data-field="x_group_type" data-hidden="1" name="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_group_type" id="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_group_type" value="<?= HtmlEncode($Grid->group_type->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->latitude->Visible) { // latitude ?>
        <td data-name="latitude"<?= $Grid->latitude->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_latitude" class="el_asset_pros_detail_latitude">
<input type="<?= $Grid->latitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" data-table="asset_pros_detail" data-field="x_latitude" value="<?= $Grid->latitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->latitude->getPlaceHolder()) ?>"<?= $Grid->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->latitude->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_latitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_latitude" id="o<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_latitude" class="el_asset_pros_detail_latitude">
<input type="<?= $Grid->latitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" data-table="asset_pros_detail" data-field="x_latitude" value="<?= $Grid->latitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->latitude->getPlaceHolder()) ?>"<?= $Grid->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->latitude->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_latitude" class="el_asset_pros_detail_latitude">
<span<?= $Grid->latitude->viewAttributes() ?>>
<?= $Grid->latitude->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_latitude" data-hidden="1" name="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_latitude" id="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->FormValue) ?>">
<input type="hidden" data-table="asset_pros_detail" data-field="x_latitude" data-hidden="1" name="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_latitude" id="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->longitude->Visible) { // longitude ?>
        <td data-name="longitude"<?= $Grid->longitude->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_longitude" class="el_asset_pros_detail_longitude">
<input type="<?= $Grid->longitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" data-table="asset_pros_detail" data-field="x_longitude" value="<?= $Grid->longitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->longitude->getPlaceHolder()) ?>"<?= $Grid->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->longitude->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_longitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_longitude" id="o<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_longitude" class="el_asset_pros_detail_longitude">
<input type="<?= $Grid->longitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" data-table="asset_pros_detail" data-field="x_longitude" value="<?= $Grid->longitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->longitude->getPlaceHolder()) ?>"<?= $Grid->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->longitude->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_longitude" class="el_asset_pros_detail_longitude">
<span<?= $Grid->longitude->viewAttributes() ?>>
<?= $Grid->longitude->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_longitude" data-hidden="1" name="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_longitude" id="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->FormValue) ?>">
<input type="hidden" data-table="asset_pros_detail" data-field="x_longitude" data-hidden="1" name="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_longitude" id="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive"<?= $Grid->isactive->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_isactive" class="el_asset_pros_detail_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_pros_detail" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
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
    data-table="asset_pros_detail"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_isactive" class="el_asset_pros_detail_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_pros_detail" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
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
    data-table="asset_pros_detail"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_isactive" class="el_asset_pros_detail_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<?= $Grid->isactive->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_isactive" data-hidden="1" name="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_isactive" id="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<input type="hidden" data-table="asset_pros_detail" data-field="x_isactive" data-hidden="1" name="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_isactive" id="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_pros_detail_cdate" class="el_asset_pros_detail_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_cdate" data-hidden="1" name="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_cdate" id="fasset_pros_detailgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="asset_pros_detail" data-field="x_cdate" data-hidden="1" name="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_cdate" id="fasset_pros_detailgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fasset_pros_detailgrid","load"], () => fasset_pros_detailgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_asset_pros_detail", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->detail->Visible) { // detail ?>
        <td data-name="detail">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_pros_detail_detail" class="el_asset_pros_detail_detail">
<textarea data-table="asset_pros_detail" data-field="x_detail" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->detail->getPlaceHolder()) ?>"<?= $Grid->detail->editAttributes() ?>><?= $Grid->detail->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->detail->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_pros_detail_detail" class="el_asset_pros_detail_detail">
<span<?= $Grid->detail->viewAttributes() ?>>
<?= $Grid->detail->ViewValue ?></span>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_detail" data-hidden="1" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_detail" id="o<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->group_type->Visible) { // group_type ?>
        <td data-name="group_type">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_pros_detail_group_type" class="el_asset_pros_detail_group_type">
    <select
        id="x<?= $Grid->RowIndex ?>_group_type"
        name="x<?= $Grid->RowIndex ?>_group_type"
        class="form-select ew-select<?= $Grid->group_type->isInvalidClass() ?>"
        data-select2-id="fasset_pros_detailgrid_x<?= $Grid->RowIndex ?>_group_type"
        data-table="asset_pros_detail"
        data-field="x_group_type"
        data-value-separator="<?= $Grid->group_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->group_type->getPlaceHolder()) ?>"
        <?= $Grid->group_type->editAttributes() ?>>
        <?= $Grid->group_type->selectOptionListHtml("x{$Grid->RowIndex}_group_type") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->group_type->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_pros_detailgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_group_type", selectId: "fasset_pros_detailgrid_x<?= $Grid->RowIndex ?>_group_type" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_pros_detailgrid.lists.group_type.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_group_type", form: "fasset_pros_detailgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_group_type", form: "fasset_pros_detailgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_pros_detail.fields.group_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_pros_detail_group_type" class="el_asset_pros_detail_group_type">
<span<?= $Grid->group_type->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->group_type->getDisplayValue($Grid->group_type->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_group_type" data-hidden="1" name="x<?= $Grid->RowIndex ?>_group_type" id="x<?= $Grid->RowIndex ?>_group_type" value="<?= HtmlEncode($Grid->group_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_group_type" data-hidden="1" name="o<?= $Grid->RowIndex ?>_group_type" id="o<?= $Grid->RowIndex ?>_group_type" value="<?= HtmlEncode($Grid->group_type->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->latitude->Visible) { // latitude ?>
        <td data-name="latitude">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_pros_detail_latitude" class="el_asset_pros_detail_latitude">
<input type="<?= $Grid->latitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" data-table="asset_pros_detail" data-field="x_latitude" value="<?= $Grid->latitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->latitude->getPlaceHolder()) ?>"<?= $Grid->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->latitude->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_pros_detail_latitude" class="el_asset_pros_detail_latitude">
<span<?= $Grid->latitude->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->latitude->getDisplayValue($Grid->latitude->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_latitude" data-hidden="1" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_latitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_latitude" id="o<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->longitude->Visible) { // longitude ?>
        <td data-name="longitude">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_pros_detail_longitude" class="el_asset_pros_detail_longitude">
<input type="<?= $Grid->longitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" data-table="asset_pros_detail" data-field="x_longitude" value="<?= $Grid->longitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->longitude->getPlaceHolder()) ?>"<?= $Grid->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->longitude->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_pros_detail_longitude" class="el_asset_pros_detail_longitude">
<span<?= $Grid->longitude->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->longitude->getDisplayValue($Grid->longitude->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_longitude" data-hidden="1" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_longitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_longitude" id="o<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_pros_detail_isactive" class="el_asset_pros_detail_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_pros_detail" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
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
    data-table="asset_pros_detail"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_pros_detail_isactive" class="el_asset_pros_detail_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->isactive->getDisplayValue($Grid->isactive->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_isactive" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_pros_detail_cdate" class="el_asset_pros_detail_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_pros_detail" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_pros_detail" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fasset_pros_detailgrid","load"], () => fasset_pros_detailgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fasset_pros_detailgrid">
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
    ew.addEventHandlers("asset_pros_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
