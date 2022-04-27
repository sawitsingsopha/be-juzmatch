<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AddressGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var faddressgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    faddressgrid = new ew.Form("faddressgrid", "grid");
    faddressgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { address: currentTable } });
    var fields = currentTable.fields;
    faddressgrid.addFields([
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["province_id", [fields.province_id.visible && fields.province_id.required ? ew.Validators.required(fields.province_id.caption) : null], fields.province_id.isInvalid],
        ["amphur_id", [fields.amphur_id.visible && fields.amphur_id.required ? ew.Validators.required(fields.amphur_id.caption) : null], fields.amphur_id.isInvalid],
        ["district_id", [fields.district_id.visible && fields.district_id.required ? ew.Validators.required(fields.district_id.caption) : null], fields.district_id.isInvalid],
        ["postcode", [fields.postcode.visible && fields.postcode.required ? ew.Validators.required(fields.postcode.caption) : null], fields.postcode.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    faddressgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["address",false],["province_id",false],["amphur_id",false],["district_id",false],["postcode",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    faddressgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    faddressgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    faddressgrid.lists.province_id = <?= $Grid->province_id->toClientList($Grid) ?>;
    faddressgrid.lists.amphur_id = <?= $Grid->amphur_id->toClientList($Grid) ?>;
    faddressgrid.lists.district_id = <?= $Grid->district_id->toClientList($Grid) ?>;
    loadjs.done("faddressgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> address">
<div id="faddressgrid" class="ew-form ew-list-form">
<div id="gmp_address" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_addressgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->address->Visible) { // address ?>
        <th data-name="address" class="<?= $Grid->address->headerCellClass() ?>"><div id="elh_address_address" class="address_address"><?= $Grid->renderFieldHeader($Grid->address) ?></div></th>
<?php } ?>
<?php if ($Grid->province_id->Visible) { // province_id ?>
        <th data-name="province_id" class="<?= $Grid->province_id->headerCellClass() ?>"><div id="elh_address_province_id" class="address_province_id"><?= $Grid->renderFieldHeader($Grid->province_id) ?></div></th>
<?php } ?>
<?php if ($Grid->amphur_id->Visible) { // amphur_id ?>
        <th data-name="amphur_id" class="<?= $Grid->amphur_id->headerCellClass() ?>"><div id="elh_address_amphur_id" class="address_amphur_id"><?= $Grid->renderFieldHeader($Grid->amphur_id) ?></div></th>
<?php } ?>
<?php if ($Grid->district_id->Visible) { // district_id ?>
        <th data-name="district_id" class="<?= $Grid->district_id->headerCellClass() ?>"><div id="elh_address_district_id" class="address_district_id"><?= $Grid->renderFieldHeader($Grid->district_id) ?></div></th>
<?php } ?>
<?php if ($Grid->postcode->Visible) { // postcode ?>
        <th data-name="postcode" class="<?= $Grid->postcode->headerCellClass() ?>"><div id="elh_address_postcode" class="address_postcode"><?= $Grid->renderFieldHeader($Grid->postcode) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_address_cdate" class="address_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_address",
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
    <?php if ($Grid->address->Visible) { // address ?>
        <td data-name="address"<?= $Grid->address->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_address_address" class="el_address_address">
<textarea data-table="address" data-field="x_address" name="x<?= $Grid->RowIndex ?>_address" id="x<?= $Grid->RowIndex ?>_address" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->address->getPlaceHolder()) ?>"<?= $Grid->address->editAttributes() ?>><?= $Grid->address->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->address->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="address" data-field="x_address" data-hidden="1" name="o<?= $Grid->RowIndex ?>_address" id="o<?= $Grid->RowIndex ?>_address" value="<?= HtmlEncode($Grid->address->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_address_address" class="el_address_address">
<textarea data-table="address" data-field="x_address" name="x<?= $Grid->RowIndex ?>_address" id="x<?= $Grid->RowIndex ?>_address" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->address->getPlaceHolder()) ?>"<?= $Grid->address->editAttributes() ?>><?= $Grid->address->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->address->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_address_address" class="el_address_address">
<span<?= $Grid->address->viewAttributes() ?>>
<?= $Grid->address->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="address" data-field="x_address" data-hidden="1" name="faddressgrid$x<?= $Grid->RowIndex ?>_address" id="faddressgrid$x<?= $Grid->RowIndex ?>_address" value="<?= HtmlEncode($Grid->address->FormValue) ?>">
<input type="hidden" data-table="address" data-field="x_address" data-hidden="1" name="faddressgrid$o<?= $Grid->RowIndex ?>_address" id="faddressgrid$o<?= $Grid->RowIndex ?>_address" value="<?= HtmlEncode($Grid->address->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->province_id->Visible) { // province_id ?>
        <td data-name="province_id"<?= $Grid->province_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_address_province_id" class="el_address_province_id">
<?php $Grid->province_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_province_id"
        name="x<?= $Grid->RowIndex ?>_province_id"
        class="form-select ew-select<?= $Grid->province_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_province_id"
        data-table="address"
        data-field="x_province_id"
        data-value-separator="<?= $Grid->province_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->province_id->getPlaceHolder()) ?>"
        <?= $Grid->province_id->editAttributes() ?>>
        <?= $Grid->province_id->selectOptionListHtml("x{$Grid->RowIndex}_province_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->province_id->getErrorMessage() ?></div>
<?= $Grid->province_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_province_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_province_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_province_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.province_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_province_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_province_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.province_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="address" data-field="x_province_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_province_id" id="o<?= $Grid->RowIndex ?>_province_id" value="<?= HtmlEncode($Grid->province_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_address_province_id" class="el_address_province_id">
<?php $Grid->province_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_province_id"
        name="x<?= $Grid->RowIndex ?>_province_id"
        class="form-select ew-select<?= $Grid->province_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_province_id"
        data-table="address"
        data-field="x_province_id"
        data-value-separator="<?= $Grid->province_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->province_id->getPlaceHolder()) ?>"
        <?= $Grid->province_id->editAttributes() ?>>
        <?= $Grid->province_id->selectOptionListHtml("x{$Grid->RowIndex}_province_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->province_id->getErrorMessage() ?></div>
<?= $Grid->province_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_province_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_province_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_province_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.province_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_province_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_province_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.province_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_address_province_id" class="el_address_province_id">
<span<?= $Grid->province_id->viewAttributes() ?>>
<?= $Grid->province_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="address" data-field="x_province_id" data-hidden="1" name="faddressgrid$x<?= $Grid->RowIndex ?>_province_id" id="faddressgrid$x<?= $Grid->RowIndex ?>_province_id" value="<?= HtmlEncode($Grid->province_id->FormValue) ?>">
<input type="hidden" data-table="address" data-field="x_province_id" data-hidden="1" name="faddressgrid$o<?= $Grid->RowIndex ?>_province_id" id="faddressgrid$o<?= $Grid->RowIndex ?>_province_id" value="<?= HtmlEncode($Grid->province_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amphur_id->Visible) { // amphur_id ?>
        <td data-name="amphur_id"<?= $Grid->amphur_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_address_amphur_id" class="el_address_amphur_id">
<?php $Grid->amphur_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_amphur_id"
        name="x<?= $Grid->RowIndex ?>_amphur_id"
        class="form-select ew-select<?= $Grid->amphur_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_amphur_id"
        data-table="address"
        data-field="x_amphur_id"
        data-value-separator="<?= $Grid->amphur_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->amphur_id->getPlaceHolder()) ?>"
        <?= $Grid->amphur_id->editAttributes() ?>>
        <?= $Grid->amphur_id->selectOptionListHtml("x{$Grid->RowIndex}_amphur_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->amphur_id->getErrorMessage() ?></div>
<?= $Grid->amphur_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_amphur_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_amphur_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_amphur_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.amphur_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_amphur_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_amphur_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.amphur_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="address" data-field="x_amphur_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amphur_id" id="o<?= $Grid->RowIndex ?>_amphur_id" value="<?= HtmlEncode($Grid->amphur_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_address_amphur_id" class="el_address_amphur_id">
<?php $Grid->amphur_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_amphur_id"
        name="x<?= $Grid->RowIndex ?>_amphur_id"
        class="form-select ew-select<?= $Grid->amphur_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_amphur_id"
        data-table="address"
        data-field="x_amphur_id"
        data-value-separator="<?= $Grid->amphur_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->amphur_id->getPlaceHolder()) ?>"
        <?= $Grid->amphur_id->editAttributes() ?>>
        <?= $Grid->amphur_id->selectOptionListHtml("x{$Grid->RowIndex}_amphur_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->amphur_id->getErrorMessage() ?></div>
<?= $Grid->amphur_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_amphur_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_amphur_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_amphur_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.amphur_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_amphur_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_amphur_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.amphur_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_address_amphur_id" class="el_address_amphur_id">
<span<?= $Grid->amphur_id->viewAttributes() ?>>
<?= $Grid->amphur_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="address" data-field="x_amphur_id" data-hidden="1" name="faddressgrid$x<?= $Grid->RowIndex ?>_amphur_id" id="faddressgrid$x<?= $Grid->RowIndex ?>_amphur_id" value="<?= HtmlEncode($Grid->amphur_id->FormValue) ?>">
<input type="hidden" data-table="address" data-field="x_amphur_id" data-hidden="1" name="faddressgrid$o<?= $Grid->RowIndex ?>_amphur_id" id="faddressgrid$o<?= $Grid->RowIndex ?>_amphur_id" value="<?= HtmlEncode($Grid->amphur_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->district_id->Visible) { // district_id ?>
        <td data-name="district_id"<?= $Grid->district_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_address_district_id" class="el_address_district_id">
    <select
        id="x<?= $Grid->RowIndex ?>_district_id"
        name="x<?= $Grid->RowIndex ?>_district_id"
        class="form-select ew-select<?= $Grid->district_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_district_id"
        data-table="address"
        data-field="x_district_id"
        data-value-separator="<?= $Grid->district_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->district_id->getPlaceHolder()) ?>"
        <?= $Grid->district_id->editAttributes() ?>>
        <?= $Grid->district_id->selectOptionListHtml("x{$Grid->RowIndex}_district_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->district_id->getErrorMessage() ?></div>
<?= $Grid->district_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_district_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_district_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_district_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.district_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_district_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_district_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.district_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="address" data-field="x_district_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_district_id" id="o<?= $Grid->RowIndex ?>_district_id" value="<?= HtmlEncode($Grid->district_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_address_district_id" class="el_address_district_id">
    <select
        id="x<?= $Grid->RowIndex ?>_district_id"
        name="x<?= $Grid->RowIndex ?>_district_id"
        class="form-select ew-select<?= $Grid->district_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_district_id"
        data-table="address"
        data-field="x_district_id"
        data-value-separator="<?= $Grid->district_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->district_id->getPlaceHolder()) ?>"
        <?= $Grid->district_id->editAttributes() ?>>
        <?= $Grid->district_id->selectOptionListHtml("x{$Grid->RowIndex}_district_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->district_id->getErrorMessage() ?></div>
<?= $Grid->district_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_district_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_district_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_district_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.district_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_district_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_district_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.district_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_address_district_id" class="el_address_district_id">
<span<?= $Grid->district_id->viewAttributes() ?>>
<?= $Grid->district_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="address" data-field="x_district_id" data-hidden="1" name="faddressgrid$x<?= $Grid->RowIndex ?>_district_id" id="faddressgrid$x<?= $Grid->RowIndex ?>_district_id" value="<?= HtmlEncode($Grid->district_id->FormValue) ?>">
<input type="hidden" data-table="address" data-field="x_district_id" data-hidden="1" name="faddressgrid$o<?= $Grid->RowIndex ?>_district_id" id="faddressgrid$o<?= $Grid->RowIndex ?>_district_id" value="<?= HtmlEncode($Grid->district_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->postcode->Visible) { // postcode ?>
        <td data-name="postcode"<?= $Grid->postcode->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_address_postcode" class="el_address_postcode">
<input type="<?= $Grid->postcode->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_postcode" id="x<?= $Grid->RowIndex ?>_postcode" data-table="address" data-field="x_postcode" value="<?= $Grid->postcode->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->postcode->getPlaceHolder()) ?>"<?= $Grid->postcode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->postcode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="address" data-field="x_postcode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_postcode" id="o<?= $Grid->RowIndex ?>_postcode" value="<?= HtmlEncode($Grid->postcode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_address_postcode" class="el_address_postcode">
<input type="<?= $Grid->postcode->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_postcode" id="x<?= $Grid->RowIndex ?>_postcode" data-table="address" data-field="x_postcode" value="<?= $Grid->postcode->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->postcode->getPlaceHolder()) ?>"<?= $Grid->postcode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->postcode->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_address_postcode" class="el_address_postcode">
<span<?= $Grid->postcode->viewAttributes() ?>>
<?= $Grid->postcode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="address" data-field="x_postcode" data-hidden="1" name="faddressgrid$x<?= $Grid->RowIndex ?>_postcode" id="faddressgrid$x<?= $Grid->RowIndex ?>_postcode" value="<?= HtmlEncode($Grid->postcode->FormValue) ?>">
<input type="hidden" data-table="address" data-field="x_postcode" data-hidden="1" name="faddressgrid$o<?= $Grid->RowIndex ?>_postcode" id="faddressgrid$o<?= $Grid->RowIndex ?>_postcode" value="<?= HtmlEncode($Grid->postcode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="address" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_address_cdate" class="el_address_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="address" data-field="x_cdate" data-hidden="1" name="faddressgrid$x<?= $Grid->RowIndex ?>_cdate" id="faddressgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="address" data-field="x_cdate" data-hidden="1" name="faddressgrid$o<?= $Grid->RowIndex ?>_cdate" id="faddressgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["faddressgrid","load"], () => faddressgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_address", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->address->Visible) { // address ?>
        <td data-name="address">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_address_address" class="el_address_address">
<textarea data-table="address" data-field="x_address" name="x<?= $Grid->RowIndex ?>_address" id="x<?= $Grid->RowIndex ?>_address" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->address->getPlaceHolder()) ?>"<?= $Grid->address->editAttributes() ?>><?= $Grid->address->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->address->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_address_address" class="el_address_address">
<span<?= $Grid->address->viewAttributes() ?>>
<?= $Grid->address->ViewValue ?></span>
</span>
<input type="hidden" data-table="address" data-field="x_address" data-hidden="1" name="x<?= $Grid->RowIndex ?>_address" id="x<?= $Grid->RowIndex ?>_address" value="<?= HtmlEncode($Grid->address->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="address" data-field="x_address" data-hidden="1" name="o<?= $Grid->RowIndex ?>_address" id="o<?= $Grid->RowIndex ?>_address" value="<?= HtmlEncode($Grid->address->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->province_id->Visible) { // province_id ?>
        <td data-name="province_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_address_province_id" class="el_address_province_id">
<?php $Grid->province_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_province_id"
        name="x<?= $Grid->RowIndex ?>_province_id"
        class="form-select ew-select<?= $Grid->province_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_province_id"
        data-table="address"
        data-field="x_province_id"
        data-value-separator="<?= $Grid->province_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->province_id->getPlaceHolder()) ?>"
        <?= $Grid->province_id->editAttributes() ?>>
        <?= $Grid->province_id->selectOptionListHtml("x{$Grid->RowIndex}_province_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->province_id->getErrorMessage() ?></div>
<?= $Grid->province_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_province_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_province_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_province_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.province_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_province_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_province_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.province_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_address_province_id" class="el_address_province_id">
<span<?= $Grid->province_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->province_id->getDisplayValue($Grid->province_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="address" data-field="x_province_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_province_id" id="x<?= $Grid->RowIndex ?>_province_id" value="<?= HtmlEncode($Grid->province_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="address" data-field="x_province_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_province_id" id="o<?= $Grid->RowIndex ?>_province_id" value="<?= HtmlEncode($Grid->province_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->amphur_id->Visible) { // amphur_id ?>
        <td data-name="amphur_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_address_amphur_id" class="el_address_amphur_id">
<?php $Grid->amphur_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_amphur_id"
        name="x<?= $Grid->RowIndex ?>_amphur_id"
        class="form-select ew-select<?= $Grid->amphur_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_amphur_id"
        data-table="address"
        data-field="x_amphur_id"
        data-value-separator="<?= $Grid->amphur_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->amphur_id->getPlaceHolder()) ?>"
        <?= $Grid->amphur_id->editAttributes() ?>>
        <?= $Grid->amphur_id->selectOptionListHtml("x{$Grid->RowIndex}_amphur_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->amphur_id->getErrorMessage() ?></div>
<?= $Grid->amphur_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_amphur_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_amphur_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_amphur_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.amphur_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_amphur_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_amphur_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.amphur_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_address_amphur_id" class="el_address_amphur_id">
<span<?= $Grid->amphur_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->amphur_id->getDisplayValue($Grid->amphur_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="address" data-field="x_amphur_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amphur_id" id="x<?= $Grid->RowIndex ?>_amphur_id" value="<?= HtmlEncode($Grid->amphur_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="address" data-field="x_amphur_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amphur_id" id="o<?= $Grid->RowIndex ?>_amphur_id" value="<?= HtmlEncode($Grid->amphur_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->district_id->Visible) { // district_id ?>
        <td data-name="district_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_address_district_id" class="el_address_district_id">
    <select
        id="x<?= $Grid->RowIndex ?>_district_id"
        name="x<?= $Grid->RowIndex ?>_district_id"
        class="form-select ew-select<?= $Grid->district_id->isInvalidClass() ?>"
        data-select2-id="faddressgrid_x<?= $Grid->RowIndex ?>_district_id"
        data-table="address"
        data-field="x_district_id"
        data-value-separator="<?= $Grid->district_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->district_id->getPlaceHolder()) ?>"
        <?= $Grid->district_id->editAttributes() ?>>
        <?= $Grid->district_id->selectOptionListHtml("x{$Grid->RowIndex}_district_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->district_id->getErrorMessage() ?></div>
<?= $Grid->district_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_district_id") ?>
<script>
loadjs.ready("faddressgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_district_id", selectId: "faddressgrid_x<?= $Grid->RowIndex ?>_district_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressgrid.lists.district_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_district_id", form: "faddressgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_district_id", form: "faddressgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.district_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_address_district_id" class="el_address_district_id">
<span<?= $Grid->district_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->district_id->getDisplayValue($Grid->district_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="address" data-field="x_district_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_district_id" id="x<?= $Grid->RowIndex ?>_district_id" value="<?= HtmlEncode($Grid->district_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="address" data-field="x_district_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_district_id" id="o<?= $Grid->RowIndex ?>_district_id" value="<?= HtmlEncode($Grid->district_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->postcode->Visible) { // postcode ?>
        <td data-name="postcode">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_address_postcode" class="el_address_postcode">
<input type="<?= $Grid->postcode->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_postcode" id="x<?= $Grid->RowIndex ?>_postcode" data-table="address" data-field="x_postcode" value="<?= $Grid->postcode->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->postcode->getPlaceHolder()) ?>"<?= $Grid->postcode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->postcode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_address_postcode" class="el_address_postcode">
<span<?= $Grid->postcode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->postcode->getDisplayValue($Grid->postcode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="address" data-field="x_postcode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_postcode" id="x<?= $Grid->RowIndex ?>_postcode" value="<?= HtmlEncode($Grid->postcode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="address" data-field="x_postcode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_postcode" id="o<?= $Grid->RowIndex ?>_postcode" value="<?= HtmlEncode($Grid->postcode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_address_cdate" class="el_address_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="address" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="address" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["faddressgrid","load"], () => faddressgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="faddressgrid">
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
    ew.addEventHandlers("address");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
