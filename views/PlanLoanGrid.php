<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("PlanLoanGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fplan_loangrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fplan_loangrid = new ew.Form("fplan_loangrid", "grid");
    fplan_loangrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { plan_loan: currentTable } });
    var fields = currentTable.fields;
    fplan_loangrid.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
        ["time", [fields.time.visible && fields.time.required ? ew.Validators.required(fields.time.caption) : null, ew.Validators.time(fields.time.clientFormatPattern)], fields.time.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fplan_loangrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["member_id",false],["date",false],["time",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fplan_loangrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fplan_loangrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fplan_loangrid.lists.member_id = <?= $Grid->member_id->toClientList($Grid) ?>;
    loadjs.done("fplan_loangrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> plan_loan">
<div id="fplan_loangrid" class="ew-form ew-list-form">
<div id="gmp_plan_loan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_plan_loangrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Grid->member_id->headerCellClass() ?>"><div id="elh_plan_loan_member_id" class="plan_loan_member_id"><?= $Grid->renderFieldHeader($Grid->member_id) ?></div></th>
<?php } ?>
<?php if ($Grid->date->Visible) { // date ?>
        <th data-name="date" class="<?= $Grid->date->headerCellClass() ?>"><div id="elh_plan_loan_date" class="plan_loan_date"><?= $Grid->renderFieldHeader($Grid->date) ?></div></th>
<?php } ?>
<?php if ($Grid->time->Visible) { // time ?>
        <th data-name="time" class="<?= $Grid->time->headerCellClass() ?>"><div id="elh_plan_loan_time" class="plan_loan_time"><?= $Grid->renderFieldHeader($Grid->time) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_plan_loan_cdate" class="plan_loan_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_plan_loan",
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
    <?php if ($Grid->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Grid->member_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->member_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_member_id" class="el_plan_loan_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->member_id->getDisplayValue($Grid->member_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_member_id" name="x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode(FormatNumber($Grid->member_id->CurrentValue, $Grid->member_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_member_id" class="el_plan_loan_member_id">
    <select
        id="x<?= $Grid->RowIndex ?>_member_id"
        name="x<?= $Grid->RowIndex ?>_member_id"
        class="form-select ew-select<?= $Grid->member_id->isInvalidClass() ?>"
        data-select2-id="fplan_loangrid_x<?= $Grid->RowIndex ?>_member_id"
        data-table="plan_loan"
        data-field="x_member_id"
        data-value-separator="<?= $Grid->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->member_id->getPlaceHolder()) ?>"
        <?= $Grid->member_id->editAttributes() ?>>
        <?= $Grid->member_id->selectOptionListHtml("x{$Grid->RowIndex}_member_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->member_id->getErrorMessage() ?></div>
<?= $Grid->member_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_member_id") ?>
<script>
loadjs.ready("fplan_loangrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_member_id", selectId: "fplan_loangrid_x<?= $Grid->RowIndex ?>_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplan_loangrid.lists.member_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fplan_loangrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fplan_loangrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plan_loan.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="plan_loan" data-field="x_member_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_member_id" id="o<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_member_id" class="el_plan_loan_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->member_id->getDisplayValue($Grid->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_member_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_member_id" id="x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_member_id" class="el_plan_loan_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<?= $Grid->member_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plan_loan" data-field="x_member_id" data-hidden="1" name="fplan_loangrid$x<?= $Grid->RowIndex ?>_member_id" id="fplan_loangrid$x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->FormValue) ?>">
<input type="hidden" data-table="plan_loan" data-field="x_member_id" data-hidden="1" name="fplan_loangrid$o<?= $Grid->RowIndex ?>_member_id" id="fplan_loangrid$o<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date->Visible) { // date ?>
        <td data-name="date"<?= $Grid->date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_date" class="el_plan_loan_date">
<input type="<?= $Grid->date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date" id="x<?= $Grid->RowIndex ?>_date" data-table="plan_loan" data-field="x_date" value="<?= $Grid->date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date->getPlaceHolder()) ?>"<?= $Grid->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date->getErrorMessage() ?></div>
<?php if (!$Grid->date->ReadOnly && !$Grid->date->Disabled && !isset($Grid->date->EditAttrs["readonly"]) && !isset($Grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplan_loangrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fplan_loangrid", "x<?= $Grid->RowIndex ?>_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date" id="o<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_date" class="el_plan_loan_date">
<input type="<?= $Grid->date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date" id="x<?= $Grid->RowIndex ?>_date" data-table="plan_loan" data-field="x_date" value="<?= $Grid->date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date->getPlaceHolder()) ?>"<?= $Grid->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date->getErrorMessage() ?></div>
<?php if (!$Grid->date->ReadOnly && !$Grid->date->Disabled && !isset($Grid->date->EditAttrs["readonly"]) && !isset($Grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplan_loangrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fplan_loangrid", "x<?= $Grid->RowIndex ?>_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_date" class="el_plan_loan_date">
<span<?= $Grid->date->viewAttributes() ?>>
<?= $Grid->date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plan_loan" data-field="x_date" data-hidden="1" name="fplan_loangrid$x<?= $Grid->RowIndex ?>_date" id="fplan_loangrid$x<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->FormValue) ?>">
<input type="hidden" data-table="plan_loan" data-field="x_date" data-hidden="1" name="fplan_loangrid$o<?= $Grid->RowIndex ?>_date" id="fplan_loangrid$o<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->time->Visible) { // time ?>
        <td data-name="time"<?= $Grid->time->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_time" class="el_plan_loan_time">
<input type="<?= $Grid->time->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_time" id="x<?= $Grid->RowIndex ?>_time" data-table="plan_loan" data-field="x_time" value="<?= $Grid->time->EditValue ?>" placeholder="<?= HtmlEncode($Grid->time->getPlaceHolder()) ?>"<?= $Grid->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->time->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_time" data-hidden="1" name="o<?= $Grid->RowIndex ?>_time" id="o<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_time" class="el_plan_loan_time">
<input type="<?= $Grid->time->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_time" id="x<?= $Grid->RowIndex ?>_time" data-table="plan_loan" data-field="x_time" value="<?= $Grid->time->EditValue ?>" placeholder="<?= HtmlEncode($Grid->time->getPlaceHolder()) ?>"<?= $Grid->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->time->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_time" class="el_plan_loan_time">
<span<?= $Grid->time->viewAttributes() ?>>
<?= $Grid->time->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plan_loan" data-field="x_time" data-hidden="1" name="fplan_loangrid$x<?= $Grid->RowIndex ?>_time" id="fplan_loangrid$x<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->FormValue) ?>">
<input type="hidden" data-table="plan_loan" data-field="x_time" data-hidden="1" name="fplan_loangrid$o<?= $Grid->RowIndex ?>_time" id="fplan_loangrid$o<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="plan_loan" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_plan_loan_cdate" class="el_plan_loan_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plan_loan" data-field="x_cdate" data-hidden="1" name="fplan_loangrid$x<?= $Grid->RowIndex ?>_cdate" id="fplan_loangrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="plan_loan" data-field="x_cdate" data-hidden="1" name="fplan_loangrid$o<?= $Grid->RowIndex ?>_cdate" id="fplan_loangrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fplan_loangrid","load"], () => fplan_loangrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_plan_loan", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->member_id->Visible) { // member_id ?>
        <td data-name="member_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->member_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_plan_loan_member_id" class="el_plan_loan_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->member_id->getDisplayValue($Grid->member_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_member_id" name="x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode(FormatNumber($Grid->member_id->CurrentValue, $Grid->member_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_plan_loan_member_id" class="el_plan_loan_member_id">
    <select
        id="x<?= $Grid->RowIndex ?>_member_id"
        name="x<?= $Grid->RowIndex ?>_member_id"
        class="form-select ew-select<?= $Grid->member_id->isInvalidClass() ?>"
        data-select2-id="fplan_loangrid_x<?= $Grid->RowIndex ?>_member_id"
        data-table="plan_loan"
        data-field="x_member_id"
        data-value-separator="<?= $Grid->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->member_id->getPlaceHolder()) ?>"
        <?= $Grid->member_id->editAttributes() ?>>
        <?= $Grid->member_id->selectOptionListHtml("x{$Grid->RowIndex}_member_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->member_id->getErrorMessage() ?></div>
<?= $Grid->member_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_member_id") ?>
<script>
loadjs.ready("fplan_loangrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_member_id", selectId: "fplan_loangrid_x<?= $Grid->RowIndex ?>_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplan_loangrid.lists.member_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fplan_loangrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fplan_loangrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plan_loan.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_plan_loan_member_id" class="el_plan_loan_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->member_id->getDisplayValue($Grid->member_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_member_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_member_id" id="x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="plan_loan" data-field="x_member_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_member_id" id="o<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date->Visible) { // date ?>
        <td data-name="date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_plan_loan_date" class="el_plan_loan_date">
<input type="<?= $Grid->date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date" id="x<?= $Grid->RowIndex ?>_date" data-table="plan_loan" data-field="x_date" value="<?= $Grid->date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date->getPlaceHolder()) ?>"<?= $Grid->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date->getErrorMessage() ?></div>
<?php if (!$Grid->date->ReadOnly && !$Grid->date->Disabled && !isset($Grid->date->EditAttrs["readonly"]) && !isset($Grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplan_loangrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fplan_loangrid", "x<?= $Grid->RowIndex ?>_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_plan_loan_date" class="el_plan_loan_date">
<span<?= $Grid->date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date->getDisplayValue($Grid->date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date" id="x<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="plan_loan" data-field="x_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date" id="o<?= $Grid->RowIndex ?>_date" value="<?= HtmlEncode($Grid->date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->time->Visible) { // time ?>
        <td data-name="time">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_plan_loan_time" class="el_plan_loan_time">
<input type="<?= $Grid->time->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_time" id="x<?= $Grid->RowIndex ?>_time" data-table="plan_loan" data-field="x_time" value="<?= $Grid->time->EditValue ?>" placeholder="<?= HtmlEncode($Grid->time->getPlaceHolder()) ?>"<?= $Grid->time->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->time->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_plan_loan_time" class="el_plan_loan_time">
<span<?= $Grid->time->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->time->getDisplayValue($Grid->time->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_time" data-hidden="1" name="x<?= $Grid->RowIndex ?>_time" id="x<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="plan_loan" data-field="x_time" data-hidden="1" name="o<?= $Grid->RowIndex ?>_time" id="o<?= $Grid->RowIndex ?>_time" value="<?= HtmlEncode($Grid->time->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_plan_loan_cdate" class="el_plan_loan_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="plan_loan" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="plan_loan" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fplan_loangrid","load"], () => fplan_loangrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fplan_loangrid">
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
    ew.addEventHandlers("plan_loan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
