<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("SaveSearchGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsave_searchgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_searchgrid = new ew.Form("fsave_searchgrid", "grid");
    fsave_searchgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { save_search: currentTable } });
    var fields = currentTable.fields;
    fsave_searchgrid.addFields([
        ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null], fields.category_id.isInvalid],
        ["brand_id", [fields.brand_id.visible && fields.brand_id.required ? ew.Validators.required(fields.brand_id.caption) : null], fields.brand_id.isInvalid],
        ["min_installment", [fields.min_installment.visible && fields.min_installment.required ? ew.Validators.required(fields.min_installment.caption) : null], fields.min_installment.isInvalid],
        ["max_installment", [fields.max_installment.visible && fields.max_installment.required ? ew.Validators.required(fields.max_installment.caption) : null], fields.max_installment.isInvalid],
        ["min_down", [fields.min_down.visible && fields.min_down.required ? ew.Validators.required(fields.min_down.caption) : null], fields.min_down.isInvalid],
        ["max_down", [fields.max_down.visible && fields.max_down.required ? ew.Validators.required(fields.max_down.caption) : null], fields.max_down.isInvalid],
        ["min_price", [fields.min_price.visible && fields.min_price.required ? ew.Validators.required(fields.min_price.caption) : null], fields.min_price.isInvalid],
        ["max_price", [fields.max_price.visible && fields.max_price.required ? ew.Validators.required(fields.max_price.caption) : null], fields.max_price.isInvalid],
        ["usable_area_min", [fields.usable_area_min.visible && fields.usable_area_min.required ? ew.Validators.required(fields.usable_area_min.caption) : null], fields.usable_area_min.isInvalid],
        ["usable_area_max", [fields.usable_area_max.visible && fields.usable_area_max.required ? ew.Validators.required(fields.usable_area_max.caption) : null], fields.usable_area_max.isInvalid],
        ["land_size_area_min", [fields.land_size_area_min.visible && fields.land_size_area_min.required ? ew.Validators.required(fields.land_size_area_min.caption) : null], fields.land_size_area_min.isInvalid],
        ["land_size_area_max", [fields.land_size_area_max.visible && fields.land_size_area_max.required ? ew.Validators.required(fields.land_size_area_max.caption) : null], fields.land_size_area_max.isInvalid],
        ["bedroom", [fields.bedroom.visible && fields.bedroom.required ? ew.Validators.required(fields.bedroom.caption) : null], fields.bedroom.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null, ew.Validators.float], fields.latitude.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null, ew.Validators.float], fields.longitude.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fsave_searchgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["category_id",false],["brand_id[]",false],["min_installment",false],["max_installment",false],["min_down",false],["max_down",false],["min_price",false],["max_price",false],["usable_area_min",false],["usable_area_max",false],["land_size_area_min",false],["land_size_area_max",false],["bedroom[]",false],["latitude",false],["longitude",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsave_searchgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsave_searchgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fsave_searchgrid.lists.category_id = <?= $Grid->category_id->toClientList($Grid) ?>;
    fsave_searchgrid.lists.brand_id = <?= $Grid->brand_id->toClientList($Grid) ?>;
    fsave_searchgrid.lists.bedroom = <?= $Grid->bedroom->toClientList($Grid) ?>;
    loadjs.done("fsave_searchgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> save_search">
<div id="fsave_searchgrid" class="ew-form ew-list-form">
<div id="gmp_save_search" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_save_searchgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->category_id->Visible) { // category_id ?>
        <th data-name="category_id" class="<?= $Grid->category_id->headerCellClass() ?>"><div id="elh_save_search_category_id" class="save_search_category_id"><?= $Grid->renderFieldHeader($Grid->category_id) ?></div></th>
<?php } ?>
<?php if ($Grid->brand_id->Visible) { // brand_id ?>
        <th data-name="brand_id" class="<?= $Grid->brand_id->headerCellClass() ?>"><div id="elh_save_search_brand_id" class="save_search_brand_id"><?= $Grid->renderFieldHeader($Grid->brand_id) ?></div></th>
<?php } ?>
<?php if ($Grid->min_installment->Visible) { // min_installment ?>
        <th data-name="min_installment" class="<?= $Grid->min_installment->headerCellClass() ?>"><div id="elh_save_search_min_installment" class="save_search_min_installment"><?= $Grid->renderFieldHeader($Grid->min_installment) ?></div></th>
<?php } ?>
<?php if ($Grid->max_installment->Visible) { // max_installment ?>
        <th data-name="max_installment" class="<?= $Grid->max_installment->headerCellClass() ?>"><div id="elh_save_search_max_installment" class="save_search_max_installment"><?= $Grid->renderFieldHeader($Grid->max_installment) ?></div></th>
<?php } ?>
<?php if ($Grid->min_down->Visible) { // min_down ?>
        <th data-name="min_down" class="<?= $Grid->min_down->headerCellClass() ?>"><div id="elh_save_search_min_down" class="save_search_min_down"><?= $Grid->renderFieldHeader($Grid->min_down) ?></div></th>
<?php } ?>
<?php if ($Grid->max_down->Visible) { // max_down ?>
        <th data-name="max_down" class="<?= $Grid->max_down->headerCellClass() ?>"><div id="elh_save_search_max_down" class="save_search_max_down"><?= $Grid->renderFieldHeader($Grid->max_down) ?></div></th>
<?php } ?>
<?php if ($Grid->min_price->Visible) { // min_price ?>
        <th data-name="min_price" class="<?= $Grid->min_price->headerCellClass() ?>"><div id="elh_save_search_min_price" class="save_search_min_price"><?= $Grid->renderFieldHeader($Grid->min_price) ?></div></th>
<?php } ?>
<?php if ($Grid->max_price->Visible) { // max_price ?>
        <th data-name="max_price" class="<?= $Grid->max_price->headerCellClass() ?>"><div id="elh_save_search_max_price" class="save_search_max_price"><?= $Grid->renderFieldHeader($Grid->max_price) ?></div></th>
<?php } ?>
<?php if ($Grid->usable_area_min->Visible) { // usable_area_min ?>
        <th data-name="usable_area_min" class="<?= $Grid->usable_area_min->headerCellClass() ?>"><div id="elh_save_search_usable_area_min" class="save_search_usable_area_min"><?= $Grid->renderFieldHeader($Grid->usable_area_min) ?></div></th>
<?php } ?>
<?php if ($Grid->usable_area_max->Visible) { // usable_area_max ?>
        <th data-name="usable_area_max" class="<?= $Grid->usable_area_max->headerCellClass() ?>"><div id="elh_save_search_usable_area_max" class="save_search_usable_area_max"><?= $Grid->renderFieldHeader($Grid->usable_area_max) ?></div></th>
<?php } ?>
<?php if ($Grid->land_size_area_min->Visible) { // land_size_area_min ?>
        <th data-name="land_size_area_min" class="<?= $Grid->land_size_area_min->headerCellClass() ?>"><div id="elh_save_search_land_size_area_min" class="save_search_land_size_area_min"><?= $Grid->renderFieldHeader($Grid->land_size_area_min) ?></div></th>
<?php } ?>
<?php if ($Grid->land_size_area_max->Visible) { // land_size_area_max ?>
        <th data-name="land_size_area_max" class="<?= $Grid->land_size_area_max->headerCellClass() ?>"><div id="elh_save_search_land_size_area_max" class="save_search_land_size_area_max"><?= $Grid->renderFieldHeader($Grid->land_size_area_max) ?></div></th>
<?php } ?>
<?php if ($Grid->bedroom->Visible) { // bedroom ?>
        <th data-name="bedroom" class="<?= $Grid->bedroom->headerCellClass() ?>"><div id="elh_save_search_bedroom" class="save_search_bedroom"><?= $Grid->renderFieldHeader($Grid->bedroom) ?></div></th>
<?php } ?>
<?php if ($Grid->latitude->Visible) { // latitude ?>
        <th data-name="latitude" class="<?= $Grid->latitude->headerCellClass() ?>"><div id="elh_save_search_latitude" class="save_search_latitude"><?= $Grid->renderFieldHeader($Grid->latitude) ?></div></th>
<?php } ?>
<?php if ($Grid->longitude->Visible) { // longitude ?>
        <th data-name="longitude" class="<?= $Grid->longitude->headerCellClass() ?>"><div id="elh_save_search_longitude" class="save_search_longitude"><?= $Grid->renderFieldHeader($Grid->longitude) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_save_search_cdate" class="save_search_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_save_search",
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
    <?php if ($Grid->category_id->Visible) { // category_id ?>
        <td data-name="category_id"<?= $Grid->category_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_category_id" class="el_save_search_category_id">
<?php
$onchange = $Grid->category_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->category_id->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->category_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_category_id" class="ew-auto-suggest">
    <input type="<?= $Grid->category_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_category_id" id="sv_x<?= $Grid->RowIndex ?>_category_id" value="<?= RemoveHtml($Grid->category_id->EditValue) ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->category_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->category_id->getPlaceHolder()) ?>"<?= $Grid->category_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="save_search" data-field="x_category_id" data-input="sv_x<?= $Grid->RowIndex ?>_category_id" data-value-separator="<?= $Grid->category_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->category_id->getErrorMessage() ?></div>
<script>
loadjs.ready("fsave_searchgrid", function() {
    fsave_searchgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_category_id","forceSelect":false}, ew.vars.tables.save_search.fields.category_id.autoSuggestOptions));
});
</script>
<?= $Grid->category_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_category_id") ?>
</span>
<input type="hidden" data-table="save_search" data-field="x_category_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_category_id" id="o<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_category_id" class="el_save_search_category_id">
<?php
$onchange = $Grid->category_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->category_id->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->category_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_category_id" class="ew-auto-suggest">
    <input type="<?= $Grid->category_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_category_id" id="sv_x<?= $Grid->RowIndex ?>_category_id" value="<?= RemoveHtml($Grid->category_id->EditValue) ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->category_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->category_id->getPlaceHolder()) ?>"<?= $Grid->category_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="save_search" data-field="x_category_id" data-input="sv_x<?= $Grid->RowIndex ?>_category_id" data-value-separator="<?= $Grid->category_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->category_id->getErrorMessage() ?></div>
<script>
loadjs.ready("fsave_searchgrid", function() {
    fsave_searchgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_category_id","forceSelect":false}, ew.vars.tables.save_search.fields.category_id.autoSuggestOptions));
});
</script>
<?= $Grid->category_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_category_id") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_category_id" class="el_save_search_category_id">
<span<?= $Grid->category_id->viewAttributes() ?>>
<?= $Grid->category_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_category_id" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_category_id" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_category_id" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_category_id" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->brand_id->Visible) { // brand_id ?>
        <td data-name="brand_id"<?= $Grid->brand_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_brand_id" class="el_save_search_brand_id">
<template id="tp_x<?= $Grid->RowIndex ?>_brand_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="save_search" data-field="x_brand_id" name="x<?= $Grid->RowIndex ?>_brand_id" id="x<?= $Grid->RowIndex ?>_brand_id"<?= $Grid->brand_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_brand_id" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_brand_id[]"
    name="x<?= $Grid->RowIndex ?>_brand_id[]"
    value="<?= HtmlEncode($Grid->brand_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_brand_id"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_brand_id"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->brand_id->isInvalidClass() ?>"
    data-table="save_search"
    data-field="x_brand_id"
    data-value-separator="<?= $Grid->brand_id->displayValueSeparatorAttribute() ?>"
    <?= $Grid->brand_id->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->brand_id->getErrorMessage() ?></div>
<?= $Grid->brand_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_brand_id") ?>
</span>
<input type="hidden" data-table="save_search" data-field="x_brand_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_brand_id[]" id="o<?= $Grid->RowIndex ?>_brand_id[]" value="<?= HtmlEncode($Grid->brand_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_brand_id" class="el_save_search_brand_id">
<template id="tp_x<?= $Grid->RowIndex ?>_brand_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="save_search" data-field="x_brand_id" name="x<?= $Grid->RowIndex ?>_brand_id" id="x<?= $Grid->RowIndex ?>_brand_id"<?= $Grid->brand_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_brand_id" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_brand_id[]"
    name="x<?= $Grid->RowIndex ?>_brand_id[]"
    value="<?= HtmlEncode($Grid->brand_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_brand_id"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_brand_id"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->brand_id->isInvalidClass() ?>"
    data-table="save_search"
    data-field="x_brand_id"
    data-value-separator="<?= $Grid->brand_id->displayValueSeparatorAttribute() ?>"
    <?= $Grid->brand_id->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->brand_id->getErrorMessage() ?></div>
<?= $Grid->brand_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_brand_id") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_brand_id" class="el_save_search_brand_id">
<span<?= $Grid->brand_id->viewAttributes() ?>>
<?= $Grid->brand_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_brand_id" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_brand_id" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_brand_id" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_brand_id[]" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_brand_id[]" value="<?= HtmlEncode($Grid->brand_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->min_installment->Visible) { // min_installment ?>
        <td data-name="min_installment"<?= $Grid->min_installment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_installment" class="el_save_search_min_installment">
<input type="<?= $Grid->min_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_installment" id="x<?= $Grid->RowIndex ?>_min_installment" data-table="save_search" data-field="x_min_installment" value="<?= $Grid->min_installment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_installment->getPlaceHolder()) ?>"<?= $Grid->min_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_installment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_min_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_min_installment" id="o<?= $Grid->RowIndex ?>_min_installment" value="<?= HtmlEncode($Grid->min_installment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_installment" class="el_save_search_min_installment">
<input type="<?= $Grid->min_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_installment" id="x<?= $Grid->RowIndex ?>_min_installment" data-table="save_search" data-field="x_min_installment" value="<?= $Grid->min_installment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_installment->getPlaceHolder()) ?>"<?= $Grid->min_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_installment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_installment" class="el_save_search_min_installment">
<span<?= $Grid->min_installment->viewAttributes() ?>>
<?= $Grid->min_installment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_min_installment" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_min_installment" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_min_installment" value="<?= HtmlEncode($Grid->min_installment->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_min_installment" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_min_installment" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_min_installment" value="<?= HtmlEncode($Grid->min_installment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->max_installment->Visible) { // max_installment ?>
        <td data-name="max_installment"<?= $Grid->max_installment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_installment" class="el_save_search_max_installment">
<input type="<?= $Grid->max_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_installment" id="x<?= $Grid->RowIndex ?>_max_installment" data-table="save_search" data-field="x_max_installment" value="<?= $Grid->max_installment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_installment->getPlaceHolder()) ?>"<?= $Grid->max_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_installment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_max_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_max_installment" id="o<?= $Grid->RowIndex ?>_max_installment" value="<?= HtmlEncode($Grid->max_installment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_installment" class="el_save_search_max_installment">
<input type="<?= $Grid->max_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_installment" id="x<?= $Grid->RowIndex ?>_max_installment" data-table="save_search" data-field="x_max_installment" value="<?= $Grid->max_installment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_installment->getPlaceHolder()) ?>"<?= $Grid->max_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_installment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_installment" class="el_save_search_max_installment">
<span<?= $Grid->max_installment->viewAttributes() ?>>
<?= $Grid->max_installment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_max_installment" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_max_installment" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_max_installment" value="<?= HtmlEncode($Grid->max_installment->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_max_installment" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_max_installment" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_max_installment" value="<?= HtmlEncode($Grid->max_installment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->min_down->Visible) { // min_down ?>
        <td data-name="min_down"<?= $Grid->min_down->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_down" class="el_save_search_min_down">
<input type="<?= $Grid->min_down->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_down" id="x<?= $Grid->RowIndex ?>_min_down" data-table="save_search" data-field="x_min_down" value="<?= $Grid->min_down->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_down->getPlaceHolder()) ?>"<?= $Grid->min_down->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_down->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_min_down" data-hidden="1" name="o<?= $Grid->RowIndex ?>_min_down" id="o<?= $Grid->RowIndex ?>_min_down" value="<?= HtmlEncode($Grid->min_down->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_down" class="el_save_search_min_down">
<input type="<?= $Grid->min_down->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_down" id="x<?= $Grid->RowIndex ?>_min_down" data-table="save_search" data-field="x_min_down" value="<?= $Grid->min_down->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_down->getPlaceHolder()) ?>"<?= $Grid->min_down->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_down->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_down" class="el_save_search_min_down">
<span<?= $Grid->min_down->viewAttributes() ?>>
<?= $Grid->min_down->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_min_down" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_min_down" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_min_down" value="<?= HtmlEncode($Grid->min_down->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_min_down" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_min_down" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_min_down" value="<?= HtmlEncode($Grid->min_down->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->max_down->Visible) { // max_down ?>
        <td data-name="max_down"<?= $Grid->max_down->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_down" class="el_save_search_max_down">
<input type="<?= $Grid->max_down->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_down" id="x<?= $Grid->RowIndex ?>_max_down" data-table="save_search" data-field="x_max_down" value="<?= $Grid->max_down->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_down->getPlaceHolder()) ?>"<?= $Grid->max_down->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_down->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_max_down" data-hidden="1" name="o<?= $Grid->RowIndex ?>_max_down" id="o<?= $Grid->RowIndex ?>_max_down" value="<?= HtmlEncode($Grid->max_down->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_down" class="el_save_search_max_down">
<input type="<?= $Grid->max_down->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_down" id="x<?= $Grid->RowIndex ?>_max_down" data-table="save_search" data-field="x_max_down" value="<?= $Grid->max_down->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_down->getPlaceHolder()) ?>"<?= $Grid->max_down->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_down->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_down" class="el_save_search_max_down">
<span<?= $Grid->max_down->viewAttributes() ?>>
<?= $Grid->max_down->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_max_down" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_max_down" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_max_down" value="<?= HtmlEncode($Grid->max_down->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_max_down" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_max_down" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_max_down" value="<?= HtmlEncode($Grid->max_down->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->min_price->Visible) { // min_price ?>
        <td data-name="min_price"<?= $Grid->min_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_price" class="el_save_search_min_price">
<input type="<?= $Grid->min_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_price" id="x<?= $Grid->RowIndex ?>_min_price" data-table="save_search" data-field="x_min_price" value="<?= $Grid->min_price->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_price->getPlaceHolder()) ?>"<?= $Grid->min_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_min_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_min_price" id="o<?= $Grid->RowIndex ?>_min_price" value="<?= HtmlEncode($Grid->min_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_price" class="el_save_search_min_price">
<input type="<?= $Grid->min_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_price" id="x<?= $Grid->RowIndex ?>_min_price" data-table="save_search" data-field="x_min_price" value="<?= $Grid->min_price->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_price->getPlaceHolder()) ?>"<?= $Grid->min_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_min_price" class="el_save_search_min_price">
<span<?= $Grid->min_price->viewAttributes() ?>>
<?= $Grid->min_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_min_price" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_min_price" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_min_price" value="<?= HtmlEncode($Grid->min_price->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_min_price" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_min_price" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_min_price" value="<?= HtmlEncode($Grid->min_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->max_price->Visible) { // max_price ?>
        <td data-name="max_price"<?= $Grid->max_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_price" class="el_save_search_max_price">
<input type="<?= $Grid->max_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_price" id="x<?= $Grid->RowIndex ?>_max_price" data-table="save_search" data-field="x_max_price" value="<?= $Grid->max_price->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_price->getPlaceHolder()) ?>"<?= $Grid->max_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_max_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_max_price" id="o<?= $Grid->RowIndex ?>_max_price" value="<?= HtmlEncode($Grid->max_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_price" class="el_save_search_max_price">
<input type="<?= $Grid->max_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_price" id="x<?= $Grid->RowIndex ?>_max_price" data-table="save_search" data-field="x_max_price" value="<?= $Grid->max_price->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_price->getPlaceHolder()) ?>"<?= $Grid->max_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_max_price" class="el_save_search_max_price">
<span<?= $Grid->max_price->viewAttributes() ?>>
<?= $Grid->max_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_max_price" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_max_price" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_max_price" value="<?= HtmlEncode($Grid->max_price->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_max_price" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_max_price" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_max_price" value="<?= HtmlEncode($Grid->max_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usable_area_min->Visible) { // usable_area_min ?>
        <td data-name="usable_area_min"<?= $Grid->usable_area_min->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_usable_area_min" class="el_save_search_usable_area_min">
<input type="<?= $Grid->usable_area_min->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area_min" id="x<?= $Grid->RowIndex ?>_usable_area_min" data-table="save_search" data-field="x_usable_area_min" value="<?= $Grid->usable_area_min->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->usable_area_min->getPlaceHolder()) ?>"<?= $Grid->usable_area_min->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area_min->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_usable_area_min" data-hidden="1" name="o<?= $Grid->RowIndex ?>_usable_area_min" id="o<?= $Grid->RowIndex ?>_usable_area_min" value="<?= HtmlEncode($Grid->usable_area_min->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_usable_area_min" class="el_save_search_usable_area_min">
<input type="<?= $Grid->usable_area_min->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area_min" id="x<?= $Grid->RowIndex ?>_usable_area_min" data-table="save_search" data-field="x_usable_area_min" value="<?= $Grid->usable_area_min->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->usable_area_min->getPlaceHolder()) ?>"<?= $Grid->usable_area_min->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area_min->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_usable_area_min" class="el_save_search_usable_area_min">
<span<?= $Grid->usable_area_min->viewAttributes() ?>>
<?= $Grid->usable_area_min->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_usable_area_min" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_usable_area_min" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_usable_area_min" value="<?= HtmlEncode($Grid->usable_area_min->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_usable_area_min" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_usable_area_min" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_usable_area_min" value="<?= HtmlEncode($Grid->usable_area_min->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usable_area_max->Visible) { // usable_area_max ?>
        <td data-name="usable_area_max"<?= $Grid->usable_area_max->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_usable_area_max" class="el_save_search_usable_area_max">
<input type="<?= $Grid->usable_area_max->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area_max" id="x<?= $Grid->RowIndex ?>_usable_area_max" data-table="save_search" data-field="x_usable_area_max" value="<?= $Grid->usable_area_max->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->usable_area_max->getPlaceHolder()) ?>"<?= $Grid->usable_area_max->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area_max->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_usable_area_max" data-hidden="1" name="o<?= $Grid->RowIndex ?>_usable_area_max" id="o<?= $Grid->RowIndex ?>_usable_area_max" value="<?= HtmlEncode($Grid->usable_area_max->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_usable_area_max" class="el_save_search_usable_area_max">
<input type="<?= $Grid->usable_area_max->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area_max" id="x<?= $Grid->RowIndex ?>_usable_area_max" data-table="save_search" data-field="x_usable_area_max" value="<?= $Grid->usable_area_max->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->usable_area_max->getPlaceHolder()) ?>"<?= $Grid->usable_area_max->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area_max->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_usable_area_max" class="el_save_search_usable_area_max">
<span<?= $Grid->usable_area_max->viewAttributes() ?>>
<?= $Grid->usable_area_max->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_usable_area_max" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_usable_area_max" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_usable_area_max" value="<?= HtmlEncode($Grid->usable_area_max->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_usable_area_max" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_usable_area_max" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_usable_area_max" value="<?= HtmlEncode($Grid->usable_area_max->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->land_size_area_min->Visible) { // land_size_area_min ?>
        <td data-name="land_size_area_min"<?= $Grid->land_size_area_min->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_land_size_area_min" class="el_save_search_land_size_area_min">
<input type="<?= $Grid->land_size_area_min->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size_area_min" id="x<?= $Grid->RowIndex ?>_land_size_area_min" data-table="save_search" data-field="x_land_size_area_min" value="<?= $Grid->land_size_area_min->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->land_size_area_min->getPlaceHolder()) ?>"<?= $Grid->land_size_area_min->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size_area_min->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_min" data-hidden="1" name="o<?= $Grid->RowIndex ?>_land_size_area_min" id="o<?= $Grid->RowIndex ?>_land_size_area_min" value="<?= HtmlEncode($Grid->land_size_area_min->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_land_size_area_min" class="el_save_search_land_size_area_min">
<input type="<?= $Grid->land_size_area_min->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size_area_min" id="x<?= $Grid->RowIndex ?>_land_size_area_min" data-table="save_search" data-field="x_land_size_area_min" value="<?= $Grid->land_size_area_min->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->land_size_area_min->getPlaceHolder()) ?>"<?= $Grid->land_size_area_min->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size_area_min->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_land_size_area_min" class="el_save_search_land_size_area_min">
<span<?= $Grid->land_size_area_min->viewAttributes() ?>>
<?= $Grid->land_size_area_min->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_min" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_land_size_area_min" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_land_size_area_min" value="<?= HtmlEncode($Grid->land_size_area_min->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_land_size_area_min" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_land_size_area_min" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_land_size_area_min" value="<?= HtmlEncode($Grid->land_size_area_min->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->land_size_area_max->Visible) { // land_size_area_max ?>
        <td data-name="land_size_area_max"<?= $Grid->land_size_area_max->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_land_size_area_max" class="el_save_search_land_size_area_max">
<input type="<?= $Grid->land_size_area_max->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size_area_max" id="x<?= $Grid->RowIndex ?>_land_size_area_max" data-table="save_search" data-field="x_land_size_area_max" value="<?= $Grid->land_size_area_max->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->land_size_area_max->getPlaceHolder()) ?>"<?= $Grid->land_size_area_max->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size_area_max->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_max" data-hidden="1" name="o<?= $Grid->RowIndex ?>_land_size_area_max" id="o<?= $Grid->RowIndex ?>_land_size_area_max" value="<?= HtmlEncode($Grid->land_size_area_max->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_land_size_area_max" class="el_save_search_land_size_area_max">
<input type="<?= $Grid->land_size_area_max->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size_area_max" id="x<?= $Grid->RowIndex ?>_land_size_area_max" data-table="save_search" data-field="x_land_size_area_max" value="<?= $Grid->land_size_area_max->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->land_size_area_max->getPlaceHolder()) ?>"<?= $Grid->land_size_area_max->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size_area_max->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_land_size_area_max" class="el_save_search_land_size_area_max">
<span<?= $Grid->land_size_area_max->viewAttributes() ?>>
<?= $Grid->land_size_area_max->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_max" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_land_size_area_max" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_land_size_area_max" value="<?= HtmlEncode($Grid->land_size_area_max->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_land_size_area_max" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_land_size_area_max" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_land_size_area_max" value="<?= HtmlEncode($Grid->land_size_area_max->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bedroom->Visible) { // bedroom ?>
        <td data-name="bedroom"<?= $Grid->bedroom->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_bedroom" class="el_save_search_bedroom">
<template id="tp_x<?= $Grid->RowIndex ?>_bedroom">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="save_search" data-field="x_bedroom" name="x<?= $Grid->RowIndex ?>_bedroom" id="x<?= $Grid->RowIndex ?>_bedroom"<?= $Grid->bedroom->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_bedroom" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_bedroom[]"
    name="x<?= $Grid->RowIndex ?>_bedroom[]"
    value="<?= HtmlEncode($Grid->bedroom->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_bedroom"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_bedroom"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->bedroom->isInvalidClass() ?>"
    data-table="save_search"
    data-field="x_bedroom"
    data-value-separator="<?= $Grid->bedroom->displayValueSeparatorAttribute() ?>"
    <?= $Grid->bedroom->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->bedroom->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_bedroom" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bedroom[]" id="o<?= $Grid->RowIndex ?>_bedroom[]" value="<?= HtmlEncode($Grid->bedroom->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_bedroom" class="el_save_search_bedroom">
<template id="tp_x<?= $Grid->RowIndex ?>_bedroom">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="save_search" data-field="x_bedroom" name="x<?= $Grid->RowIndex ?>_bedroom" id="x<?= $Grid->RowIndex ?>_bedroom"<?= $Grid->bedroom->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_bedroom" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_bedroom[]"
    name="x<?= $Grid->RowIndex ?>_bedroom[]"
    value="<?= HtmlEncode($Grid->bedroom->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_bedroom"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_bedroom"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->bedroom->isInvalidClass() ?>"
    data-table="save_search"
    data-field="x_bedroom"
    data-value-separator="<?= $Grid->bedroom->displayValueSeparatorAttribute() ?>"
    <?= $Grid->bedroom->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->bedroom->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_bedroom" class="el_save_search_bedroom">
<span<?= $Grid->bedroom->viewAttributes() ?>>
<?= $Grid->bedroom->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_bedroom" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_bedroom" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_bedroom" value="<?= HtmlEncode($Grid->bedroom->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_bedroom" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_bedroom[]" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_bedroom[]" value="<?= HtmlEncode($Grid->bedroom->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->latitude->Visible) { // latitude ?>
        <td data-name="latitude"<?= $Grid->latitude->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_latitude" class="el_save_search_latitude">
<input type="<?= $Grid->latitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" data-table="save_search" data-field="x_latitude" value="<?= $Grid->latitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->latitude->getPlaceHolder()) ?>"<?= $Grid->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->latitude->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_latitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_latitude" id="o<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_latitude" class="el_save_search_latitude">
<input type="<?= $Grid->latitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" data-table="save_search" data-field="x_latitude" value="<?= $Grid->latitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->latitude->getPlaceHolder()) ?>"<?= $Grid->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->latitude->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_latitude" class="el_save_search_latitude">
<span<?= $Grid->latitude->viewAttributes() ?>>
<?= $Grid->latitude->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_latitude" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_latitude" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_latitude" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_latitude" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->longitude->Visible) { // longitude ?>
        <td data-name="longitude"<?= $Grid->longitude->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_longitude" class="el_save_search_longitude">
<input type="<?= $Grid->longitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" data-table="save_search" data-field="x_longitude" value="<?= $Grid->longitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->longitude->getPlaceHolder()) ?>"<?= $Grid->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->longitude->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="save_search" data-field="x_longitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_longitude" id="o<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_longitude" class="el_save_search_longitude">
<input type="<?= $Grid->longitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" data-table="save_search" data-field="x_longitude" value="<?= $Grid->longitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->longitude->getPlaceHolder()) ?>"<?= $Grid->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->longitude->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_longitude" class="el_save_search_longitude">
<span<?= $Grid->longitude->viewAttributes() ?>>
<?= $Grid->longitude->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_longitude" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_longitude" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_longitude" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_longitude" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="save_search" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_save_search_cdate" class="el_save_search_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="save_search" data-field="x_cdate" data-hidden="1" name="fsave_searchgrid$x<?= $Grid->RowIndex ?>_cdate" id="fsave_searchgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="save_search" data-field="x_cdate" data-hidden="1" name="fsave_searchgrid$o<?= $Grid->RowIndex ?>_cdate" id="fsave_searchgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fsave_searchgrid","load"], () => fsave_searchgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_save_search", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->category_id->Visible) { // category_id ?>
        <td data-name="category_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_category_id" class="el_save_search_category_id">
<?php
$onchange = $Grid->category_id->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->category_id->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->category_id->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_category_id" class="ew-auto-suggest">
    <input type="<?= $Grid->category_id->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_category_id" id="sv_x<?= $Grid->RowIndex ?>_category_id" value="<?= RemoveHtml($Grid->category_id->EditValue) ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->category_id->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->category_id->getPlaceHolder()) ?>"<?= $Grid->category_id->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="save_search" data-field="x_category_id" data-input="sv_x<?= $Grid->RowIndex ?>_category_id" data-value-separator="<?= $Grid->category_id->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->category_id->getErrorMessage() ?></div>
<script>
loadjs.ready("fsave_searchgrid", function() {
    fsave_searchgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_category_id","forceSelect":false}, ew.vars.tables.save_search.fields.category_id.autoSuggestOptions));
});
</script>
<?= $Grid->category_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_category_id") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_category_id" class="el_save_search_category_id">
<span<?= $Grid->category_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->category_id->getDisplayValue($Grid->category_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_category_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_category_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_category_id" id="o<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->brand_id->Visible) { // brand_id ?>
        <td data-name="brand_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_brand_id" class="el_save_search_brand_id">
<template id="tp_x<?= $Grid->RowIndex ?>_brand_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="save_search" data-field="x_brand_id" name="x<?= $Grid->RowIndex ?>_brand_id" id="x<?= $Grid->RowIndex ?>_brand_id"<?= $Grid->brand_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_brand_id" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_brand_id[]"
    name="x<?= $Grid->RowIndex ?>_brand_id[]"
    value="<?= HtmlEncode($Grid->brand_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_brand_id"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_brand_id"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->brand_id->isInvalidClass() ?>"
    data-table="save_search"
    data-field="x_brand_id"
    data-value-separator="<?= $Grid->brand_id->displayValueSeparatorAttribute() ?>"
    <?= $Grid->brand_id->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->brand_id->getErrorMessage() ?></div>
<?= $Grid->brand_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_brand_id") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_brand_id" class="el_save_search_brand_id">
<span<?= $Grid->brand_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->brand_id->getDisplayValue($Grid->brand_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_brand_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_brand_id" id="x<?= $Grid->RowIndex ?>_brand_id" value="<?= HtmlEncode($Grid->brand_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_brand_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_brand_id[]" id="o<?= $Grid->RowIndex ?>_brand_id[]" value="<?= HtmlEncode($Grid->brand_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->min_installment->Visible) { // min_installment ?>
        <td data-name="min_installment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_min_installment" class="el_save_search_min_installment">
<input type="<?= $Grid->min_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_installment" id="x<?= $Grid->RowIndex ?>_min_installment" data-table="save_search" data-field="x_min_installment" value="<?= $Grid->min_installment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_installment->getPlaceHolder()) ?>"<?= $Grid->min_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_installment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_min_installment" class="el_save_search_min_installment">
<span<?= $Grid->min_installment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->min_installment->getDisplayValue($Grid->min_installment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_min_installment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_min_installment" id="x<?= $Grid->RowIndex ?>_min_installment" value="<?= HtmlEncode($Grid->min_installment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_min_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_min_installment" id="o<?= $Grid->RowIndex ?>_min_installment" value="<?= HtmlEncode($Grid->min_installment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->max_installment->Visible) { // max_installment ?>
        <td data-name="max_installment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_max_installment" class="el_save_search_max_installment">
<input type="<?= $Grid->max_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_installment" id="x<?= $Grid->RowIndex ?>_max_installment" data-table="save_search" data-field="x_max_installment" value="<?= $Grid->max_installment->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_installment->getPlaceHolder()) ?>"<?= $Grid->max_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_installment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_max_installment" class="el_save_search_max_installment">
<span<?= $Grid->max_installment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->max_installment->getDisplayValue($Grid->max_installment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_max_installment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_max_installment" id="x<?= $Grid->RowIndex ?>_max_installment" value="<?= HtmlEncode($Grid->max_installment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_max_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_max_installment" id="o<?= $Grid->RowIndex ?>_max_installment" value="<?= HtmlEncode($Grid->max_installment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->min_down->Visible) { // min_down ?>
        <td data-name="min_down">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_min_down" class="el_save_search_min_down">
<input type="<?= $Grid->min_down->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_down" id="x<?= $Grid->RowIndex ?>_min_down" data-table="save_search" data-field="x_min_down" value="<?= $Grid->min_down->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_down->getPlaceHolder()) ?>"<?= $Grid->min_down->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_down->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_min_down" class="el_save_search_min_down">
<span<?= $Grid->min_down->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->min_down->getDisplayValue($Grid->min_down->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_min_down" data-hidden="1" name="x<?= $Grid->RowIndex ?>_min_down" id="x<?= $Grid->RowIndex ?>_min_down" value="<?= HtmlEncode($Grid->min_down->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_min_down" data-hidden="1" name="o<?= $Grid->RowIndex ?>_min_down" id="o<?= $Grid->RowIndex ?>_min_down" value="<?= HtmlEncode($Grid->min_down->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->max_down->Visible) { // max_down ?>
        <td data-name="max_down">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_max_down" class="el_save_search_max_down">
<input type="<?= $Grid->max_down->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_down" id="x<?= $Grid->RowIndex ?>_max_down" data-table="save_search" data-field="x_max_down" value="<?= $Grid->max_down->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_down->getPlaceHolder()) ?>"<?= $Grid->max_down->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_down->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_max_down" class="el_save_search_max_down">
<span<?= $Grid->max_down->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->max_down->getDisplayValue($Grid->max_down->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_max_down" data-hidden="1" name="x<?= $Grid->RowIndex ?>_max_down" id="x<?= $Grid->RowIndex ?>_max_down" value="<?= HtmlEncode($Grid->max_down->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_max_down" data-hidden="1" name="o<?= $Grid->RowIndex ?>_max_down" id="o<?= $Grid->RowIndex ?>_max_down" value="<?= HtmlEncode($Grid->max_down->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->min_price->Visible) { // min_price ?>
        <td data-name="min_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_min_price" class="el_save_search_min_price">
<input type="<?= $Grid->min_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_min_price" id="x<?= $Grid->RowIndex ?>_min_price" data-table="save_search" data-field="x_min_price" value="<?= $Grid->min_price->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->min_price->getPlaceHolder()) ?>"<?= $Grid->min_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->min_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_min_price" class="el_save_search_min_price">
<span<?= $Grid->min_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->min_price->getDisplayValue($Grid->min_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_min_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_min_price" id="x<?= $Grid->RowIndex ?>_min_price" value="<?= HtmlEncode($Grid->min_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_min_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_min_price" id="o<?= $Grid->RowIndex ?>_min_price" value="<?= HtmlEncode($Grid->min_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->max_price->Visible) { // max_price ?>
        <td data-name="max_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_max_price" class="el_save_search_max_price">
<input type="<?= $Grid->max_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_max_price" id="x<?= $Grid->RowIndex ?>_max_price" data-table="save_search" data-field="x_max_price" value="<?= $Grid->max_price->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->max_price->getPlaceHolder()) ?>"<?= $Grid->max_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->max_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_max_price" class="el_save_search_max_price">
<span<?= $Grid->max_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->max_price->getDisplayValue($Grid->max_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_max_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_max_price" id="x<?= $Grid->RowIndex ?>_max_price" value="<?= HtmlEncode($Grid->max_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_max_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_max_price" id="o<?= $Grid->RowIndex ?>_max_price" value="<?= HtmlEncode($Grid->max_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->usable_area_min->Visible) { // usable_area_min ?>
        <td data-name="usable_area_min">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_usable_area_min" class="el_save_search_usable_area_min">
<input type="<?= $Grid->usable_area_min->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area_min" id="x<?= $Grid->RowIndex ?>_usable_area_min" data-table="save_search" data-field="x_usable_area_min" value="<?= $Grid->usable_area_min->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->usable_area_min->getPlaceHolder()) ?>"<?= $Grid->usable_area_min->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area_min->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_usable_area_min" class="el_save_search_usable_area_min">
<span<?= $Grid->usable_area_min->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->usable_area_min->getDisplayValue($Grid->usable_area_min->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_usable_area_min" data-hidden="1" name="x<?= $Grid->RowIndex ?>_usable_area_min" id="x<?= $Grid->RowIndex ?>_usable_area_min" value="<?= HtmlEncode($Grid->usable_area_min->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_usable_area_min" data-hidden="1" name="o<?= $Grid->RowIndex ?>_usable_area_min" id="o<?= $Grid->RowIndex ?>_usable_area_min" value="<?= HtmlEncode($Grid->usable_area_min->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->usable_area_max->Visible) { // usable_area_max ?>
        <td data-name="usable_area_max">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_usable_area_max" class="el_save_search_usable_area_max">
<input type="<?= $Grid->usable_area_max->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usable_area_max" id="x<?= $Grid->RowIndex ?>_usable_area_max" data-table="save_search" data-field="x_usable_area_max" value="<?= $Grid->usable_area_max->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->usable_area_max->getPlaceHolder()) ?>"<?= $Grid->usable_area_max->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usable_area_max->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_usable_area_max" class="el_save_search_usable_area_max">
<span<?= $Grid->usable_area_max->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->usable_area_max->getDisplayValue($Grid->usable_area_max->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_usable_area_max" data-hidden="1" name="x<?= $Grid->RowIndex ?>_usable_area_max" id="x<?= $Grid->RowIndex ?>_usable_area_max" value="<?= HtmlEncode($Grid->usable_area_max->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_usable_area_max" data-hidden="1" name="o<?= $Grid->RowIndex ?>_usable_area_max" id="o<?= $Grid->RowIndex ?>_usable_area_max" value="<?= HtmlEncode($Grid->usable_area_max->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->land_size_area_min->Visible) { // land_size_area_min ?>
        <td data-name="land_size_area_min">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_land_size_area_min" class="el_save_search_land_size_area_min">
<input type="<?= $Grid->land_size_area_min->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size_area_min" id="x<?= $Grid->RowIndex ?>_land_size_area_min" data-table="save_search" data-field="x_land_size_area_min" value="<?= $Grid->land_size_area_min->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->land_size_area_min->getPlaceHolder()) ?>"<?= $Grid->land_size_area_min->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size_area_min->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_land_size_area_min" class="el_save_search_land_size_area_min">
<span<?= $Grid->land_size_area_min->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->land_size_area_min->getDisplayValue($Grid->land_size_area_min->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_min" data-hidden="1" name="x<?= $Grid->RowIndex ?>_land_size_area_min" id="x<?= $Grid->RowIndex ?>_land_size_area_min" value="<?= HtmlEncode($Grid->land_size_area_min->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_min" data-hidden="1" name="o<?= $Grid->RowIndex ?>_land_size_area_min" id="o<?= $Grid->RowIndex ?>_land_size_area_min" value="<?= HtmlEncode($Grid->land_size_area_min->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->land_size_area_max->Visible) { // land_size_area_max ?>
        <td data-name="land_size_area_max">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_land_size_area_max" class="el_save_search_land_size_area_max">
<input type="<?= $Grid->land_size_area_max->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_land_size_area_max" id="x<?= $Grid->RowIndex ?>_land_size_area_max" data-table="save_search" data-field="x_land_size_area_max" value="<?= $Grid->land_size_area_max->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->land_size_area_max->getPlaceHolder()) ?>"<?= $Grid->land_size_area_max->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->land_size_area_max->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_land_size_area_max" class="el_save_search_land_size_area_max">
<span<?= $Grid->land_size_area_max->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->land_size_area_max->getDisplayValue($Grid->land_size_area_max->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_max" data-hidden="1" name="x<?= $Grid->RowIndex ?>_land_size_area_max" id="x<?= $Grid->RowIndex ?>_land_size_area_max" value="<?= HtmlEncode($Grid->land_size_area_max->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_land_size_area_max" data-hidden="1" name="o<?= $Grid->RowIndex ?>_land_size_area_max" id="o<?= $Grid->RowIndex ?>_land_size_area_max" value="<?= HtmlEncode($Grid->land_size_area_max->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bedroom->Visible) { // bedroom ?>
        <td data-name="bedroom">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_bedroom" class="el_save_search_bedroom">
<template id="tp_x<?= $Grid->RowIndex ?>_bedroom">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="save_search" data-field="x_bedroom" name="x<?= $Grid->RowIndex ?>_bedroom" id="x<?= $Grid->RowIndex ?>_bedroom"<?= $Grid->bedroom->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_bedroom" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_bedroom[]"
    name="x<?= $Grid->RowIndex ?>_bedroom[]"
    value="<?= HtmlEncode($Grid->bedroom->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_bedroom"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_bedroom"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->bedroom->isInvalidClass() ?>"
    data-table="save_search"
    data-field="x_bedroom"
    data-value-separator="<?= $Grid->bedroom->displayValueSeparatorAttribute() ?>"
    <?= $Grid->bedroom->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->bedroom->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_bedroom" class="el_save_search_bedroom">
<span<?= $Grid->bedroom->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->bedroom->getDisplayValue($Grid->bedroom->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_bedroom" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bedroom" id="x<?= $Grid->RowIndex ?>_bedroom" value="<?= HtmlEncode($Grid->bedroom->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_bedroom" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bedroom[]" id="o<?= $Grid->RowIndex ?>_bedroom[]" value="<?= HtmlEncode($Grid->bedroom->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->latitude->Visible) { // latitude ?>
        <td data-name="latitude">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_latitude" class="el_save_search_latitude">
<input type="<?= $Grid->latitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" data-table="save_search" data-field="x_latitude" value="<?= $Grid->latitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->latitude->getPlaceHolder()) ?>"<?= $Grid->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->latitude->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_latitude" class="el_save_search_latitude">
<span<?= $Grid->latitude->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->latitude->getDisplayValue($Grid->latitude->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_latitude" data-hidden="1" name="x<?= $Grid->RowIndex ?>_latitude" id="x<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_latitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_latitude" id="o<?= $Grid->RowIndex ?>_latitude" value="<?= HtmlEncode($Grid->latitude->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->longitude->Visible) { // longitude ?>
        <td data-name="longitude">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_save_search_longitude" class="el_save_search_longitude">
<input type="<?= $Grid->longitude->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" data-table="save_search" data-field="x_longitude" value="<?= $Grid->longitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->longitude->getPlaceHolder()) ?>"<?= $Grid->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->longitude->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_save_search_longitude" class="el_save_search_longitude">
<span<?= $Grid->longitude->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->longitude->getDisplayValue($Grid->longitude->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_longitude" data-hidden="1" name="x<?= $Grid->RowIndex ?>_longitude" id="x<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_longitude" data-hidden="1" name="o<?= $Grid->RowIndex ?>_longitude" id="o<?= $Grid->RowIndex ?>_longitude" value="<?= HtmlEncode($Grid->longitude->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_save_search_cdate" class="el_save_search_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_search" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="save_search" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsave_searchgrid","load"], () => fsave_searchgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fsave_searchgrid">
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
    ew.addEventHandlers("save_search");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
