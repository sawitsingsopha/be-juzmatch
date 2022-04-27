<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AssetFacilitiesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fasset_facilitiesgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_facilitiesgrid = new ew.Form("fasset_facilitiesgrid", "grid");
    fasset_facilitiesgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { asset_facilities: currentTable } });
    var fields = currentTable.fields;
    fasset_facilitiesgrid.addFields([
        ["master_facilities_group_id", [fields.master_facilities_group_id.visible && fields.master_facilities_group_id.required ? ew.Validators.required(fields.master_facilities_group_id.caption) : null], fields.master_facilities_group_id.isInvalid],
        ["master_facilities_id", [fields.master_facilities_id.visible && fields.master_facilities_id.required ? ew.Validators.required(fields.master_facilities_id.caption) : null], fields.master_facilities_id.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fasset_facilitiesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["master_facilities_group_id",false],["master_facilities_id",false],["isactive",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fasset_facilitiesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_facilitiesgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_facilitiesgrid.lists.master_facilities_group_id = <?= $Grid->master_facilities_group_id->toClientList($Grid) ?>;
    fasset_facilitiesgrid.lists.master_facilities_id = <?= $Grid->master_facilities_id->toClientList($Grid) ?>;
    fasset_facilitiesgrid.lists.isactive = <?= $Grid->isactive->toClientList($Grid) ?>;
    loadjs.done("fasset_facilitiesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_facilities">
<div id="fasset_facilitiesgrid" class="ew-form ew-list-form">
<div id="gmp_asset_facilities" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_asset_facilitiesgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
        <th data-name="master_facilities_group_id" class="<?= $Grid->master_facilities_group_id->headerCellClass() ?>"><div id="elh_asset_facilities_master_facilities_group_id" class="asset_facilities_master_facilities_group_id"><?= $Grid->renderFieldHeader($Grid->master_facilities_group_id) ?></div></th>
<?php } ?>
<?php if ($Grid->master_facilities_id->Visible) { // master_facilities_id ?>
        <th data-name="master_facilities_id" class="<?= $Grid->master_facilities_id->headerCellClass() ?>"><div id="elh_asset_facilities_master_facilities_id" class="asset_facilities_master_facilities_id"><?= $Grid->renderFieldHeader($Grid->master_facilities_id) ?></div></th>
<?php } ?>
<?php if ($Grid->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Grid->isactive->headerCellClass() ?>"><div id="elh_asset_facilities_isactive" class="asset_facilities_isactive"><?= $Grid->renderFieldHeader($Grid->isactive) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_asset_facilities_cdate" class="asset_facilities_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_asset_facilities",
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
    <?php if ($Grid->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
        <td data-name="master_facilities_group_id"<?= $Grid->master_facilities_group_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_master_facilities_group_id" class="el_asset_facilities_master_facilities_group_id">
<?php $Grid->master_facilities_group_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        name="x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        class="form-select ew-select<?= $Grid->master_facilities_group_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_group_id"
        data-value-separator="<?= $Grid->master_facilities_group_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->master_facilities_group_id->getPlaceHolder()) ?>"
        <?= $Grid->master_facilities_group_id->editAttributes() ?>>
        <?= $Grid->master_facilities_group_id->selectOptionListHtml("x{$Grid->RowIndex}_master_facilities_group_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->master_facilities_group_id->getErrorMessage() ?></div>
<?= $Grid->master_facilities_group_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_master_facilities_group_id") ?>
<script>
loadjs.ready("fasset_facilitiesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", selectId: "fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_group_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesgrid.lists.master_facilities_group_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", form: "fasset_facilitiesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", form: "fasset_facilitiesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_group_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_group_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_master_facilities_group_id" id="o<?= $Grid->RowIndex ?>_master_facilities_group_id" value="<?= HtmlEncode($Grid->master_facilities_group_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_master_facilities_group_id" class="el_asset_facilities_master_facilities_group_id">
<?php $Grid->master_facilities_group_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        name="x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        class="form-select ew-select<?= $Grid->master_facilities_group_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_group_id"
        data-value-separator="<?= $Grid->master_facilities_group_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->master_facilities_group_id->getPlaceHolder()) ?>"
        <?= $Grid->master_facilities_group_id->editAttributes() ?>>
        <?= $Grid->master_facilities_group_id->selectOptionListHtml("x{$Grid->RowIndex}_master_facilities_group_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->master_facilities_group_id->getErrorMessage() ?></div>
<?= $Grid->master_facilities_group_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_master_facilities_group_id") ?>
<script>
loadjs.ready("fasset_facilitiesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", selectId: "fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_group_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesgrid.lists.master_facilities_group_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", form: "fasset_facilitiesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", form: "fasset_facilitiesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_group_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_master_facilities_group_id" class="el_asset_facilities_master_facilities_group_id">
<span<?= $Grid->master_facilities_group_id->viewAttributes() ?>>
<?= $Grid->master_facilities_group_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_group_id" data-hidden="1" name="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_master_facilities_group_id" id="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_master_facilities_group_id" value="<?= HtmlEncode($Grid->master_facilities_group_id->FormValue) ?>">
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_group_id" data-hidden="1" name="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_master_facilities_group_id" id="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_master_facilities_group_id" value="<?= HtmlEncode($Grid->master_facilities_group_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->master_facilities_id->Visible) { // master_facilities_id ?>
        <td data-name="master_facilities_id"<?= $Grid->master_facilities_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_master_facilities_id" class="el_asset_facilities_master_facilities_id">
    <select
        id="x<?= $Grid->RowIndex ?>_master_facilities_id"
        name="x<?= $Grid->RowIndex ?>_master_facilities_id"
        class="form-select ew-select<?= $Grid->master_facilities_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_id"
        data-value-separator="<?= $Grid->master_facilities_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->master_facilities_id->getPlaceHolder()) ?>"
        <?= $Grid->master_facilities_id->editAttributes() ?>>
        <?= $Grid->master_facilities_id->selectOptionListHtml("x{$Grid->RowIndex}_master_facilities_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->master_facilities_id->getErrorMessage() ?></div>
<?= $Grid->master_facilities_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_master_facilities_id") ?>
<script>
loadjs.ready("fasset_facilitiesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_master_facilities_id", selectId: "fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesgrid.lists.master_facilities_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_master_facilities_id", form: "fasset_facilitiesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_master_facilities_id", form: "fasset_facilitiesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_master_facilities_id" id="o<?= $Grid->RowIndex ?>_master_facilities_id" value="<?= HtmlEncode($Grid->master_facilities_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_master_facilities_id" class="el_asset_facilities_master_facilities_id">
    <select
        id="x<?= $Grid->RowIndex ?>_master_facilities_id"
        name="x<?= $Grid->RowIndex ?>_master_facilities_id"
        class="form-select ew-select<?= $Grid->master_facilities_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_id"
        data-value-separator="<?= $Grid->master_facilities_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->master_facilities_id->getPlaceHolder()) ?>"
        <?= $Grid->master_facilities_id->editAttributes() ?>>
        <?= $Grid->master_facilities_id->selectOptionListHtml("x{$Grid->RowIndex}_master_facilities_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->master_facilities_id->getErrorMessage() ?></div>
<?= $Grid->master_facilities_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_master_facilities_id") ?>
<script>
loadjs.ready("fasset_facilitiesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_master_facilities_id", selectId: "fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesgrid.lists.master_facilities_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_master_facilities_id", form: "fasset_facilitiesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_master_facilities_id", form: "fasset_facilitiesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_master_facilities_id" class="el_asset_facilities_master_facilities_id">
<span<?= $Grid->master_facilities_id->viewAttributes() ?>>
<?= $Grid->master_facilities_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_id" data-hidden="1" name="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_master_facilities_id" id="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_master_facilities_id" value="<?= HtmlEncode($Grid->master_facilities_id->FormValue) ?>">
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_id" data-hidden="1" name="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_master_facilities_id" id="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_master_facilities_id" value="<?= HtmlEncode($Grid->master_facilities_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive"<?= $Grid->isactive->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_isactive" class="el_asset_facilities_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_facilities" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
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
    data-table="asset_facilities"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_isactive" class="el_asset_facilities_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_facilities" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
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
    data-table="asset_facilities"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_isactive" class="el_asset_facilities_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<?= $Grid->isactive->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_facilities" data-field="x_isactive" data-hidden="1" name="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_isactive" id="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<input type="hidden" data-table="asset_facilities" data-field="x_isactive" data-hidden="1" name="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_isactive" id="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset_facilities" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_facilities_cdate" class="el_asset_facilities_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_facilities" data-field="x_cdate" data-hidden="1" name="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_cdate" id="fasset_facilitiesgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="asset_facilities" data-field="x_cdate" data-hidden="1" name="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_cdate" id="fasset_facilitiesgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fasset_facilitiesgrid","load"], () => fasset_facilitiesgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_asset_facilities", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
        <td data-name="master_facilities_group_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_facilities_master_facilities_group_id" class="el_asset_facilities_master_facilities_group_id">
<?php $Grid->master_facilities_group_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        name="x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        class="form-select ew-select<?= $Grid->master_facilities_group_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_group_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_group_id"
        data-value-separator="<?= $Grid->master_facilities_group_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->master_facilities_group_id->getPlaceHolder()) ?>"
        <?= $Grid->master_facilities_group_id->editAttributes() ?>>
        <?= $Grid->master_facilities_group_id->selectOptionListHtml("x{$Grid->RowIndex}_master_facilities_group_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->master_facilities_group_id->getErrorMessage() ?></div>
<?= $Grid->master_facilities_group_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_master_facilities_group_id") ?>
<script>
loadjs.ready("fasset_facilitiesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", selectId: "fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_group_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesgrid.lists.master_facilities_group_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", form: "fasset_facilitiesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_master_facilities_group_id", form: "fasset_facilitiesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_group_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_facilities_master_facilities_group_id" class="el_asset_facilities_master_facilities_group_id">
<span<?= $Grid->master_facilities_group_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->master_facilities_group_id->getDisplayValue($Grid->master_facilities_group_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_group_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_master_facilities_group_id" id="x<?= $Grid->RowIndex ?>_master_facilities_group_id" value="<?= HtmlEncode($Grid->master_facilities_group_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_group_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_master_facilities_group_id" id="o<?= $Grid->RowIndex ?>_master_facilities_group_id" value="<?= HtmlEncode($Grid->master_facilities_group_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->master_facilities_id->Visible) { // master_facilities_id ?>
        <td data-name="master_facilities_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_facilities_master_facilities_id" class="el_asset_facilities_master_facilities_id">
    <select
        id="x<?= $Grid->RowIndex ?>_master_facilities_id"
        name="x<?= $Grid->RowIndex ?>_master_facilities_id"
        class="form-select ew-select<?= $Grid->master_facilities_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_id"
        data-value-separator="<?= $Grid->master_facilities_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->master_facilities_id->getPlaceHolder()) ?>"
        <?= $Grid->master_facilities_id->editAttributes() ?>>
        <?= $Grid->master_facilities_id->selectOptionListHtml("x{$Grid->RowIndex}_master_facilities_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->master_facilities_id->getErrorMessage() ?></div>
<?= $Grid->master_facilities_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_master_facilities_id") ?>
<script>
loadjs.ready("fasset_facilitiesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_master_facilities_id", selectId: "fasset_facilitiesgrid_x<?= $Grid->RowIndex ?>_master_facilities_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesgrid.lists.master_facilities_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_master_facilities_id", form: "fasset_facilitiesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_master_facilities_id", form: "fasset_facilitiesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_facilities_master_facilities_id" class="el_asset_facilities_master_facilities_id">
<span<?= $Grid->master_facilities_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->master_facilities_id->getDisplayValue($Grid->master_facilities_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_master_facilities_id" id="x<?= $Grid->RowIndex ?>_master_facilities_id" value="<?= HtmlEncode($Grid->master_facilities_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_facilities" data-field="x_master_facilities_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_master_facilities_id" id="o<?= $Grid->RowIndex ?>_master_facilities_id" value="<?= HtmlEncode($Grid->master_facilities_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_facilities_isactive" class="el_asset_facilities_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_facilities" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
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
    data-table="asset_facilities"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_facilities_isactive" class="el_asset_facilities_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->isactive->getDisplayValue($Grid->isactive->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_isactive" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_facilities" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_facilities_cdate" class="el_asset_facilities_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_facilities" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_facilities" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fasset_facilitiesgrid","load"], () => fasset_facilitiesgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fasset_facilitiesgrid">
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
    ew.addEventHandlers("asset_facilities");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
