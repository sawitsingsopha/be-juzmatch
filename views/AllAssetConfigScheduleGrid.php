<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AllAssetConfigScheduleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fall_asset_config_schedulegrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_asset_config_schedulegrid = new ew.Form("fall_asset_config_schedulegrid", "grid");
    fall_asset_config_schedulegrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { all_asset_config_schedule: currentTable } });
    var fields = currentTable.fields;
    fall_asset_config_schedulegrid.addFields([
        ["installment_all", [fields.installment_all.visible && fields.installment_all.required ? ew.Validators.required(fields.installment_all.caption) : null, ew.Validators.integer], fields.installment_all.isInvalid],
        ["installment_price_per", [fields.installment_price_per.visible && fields.installment_price_per.required ? ew.Validators.required(fields.installment_price_per.caption) : null, ew.Validators.float], fields.installment_price_per.isInvalid],
        ["date_start_installment", [fields.date_start_installment.visible && fields.date_start_installment.required ? ew.Validators.required(fields.date_start_installment.caption) : null, ew.Validators.datetime(fields.date_start_installment.clientFormatPattern)], fields.date_start_installment.isInvalid],
        ["status_approve", [fields.status_approve.visible && fields.status_approve.required ? ew.Validators.required(fields.status_approve.caption) : null], fields.status_approve.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fall_asset_config_schedulegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["installment_all",false],["installment_price_per",false],["date_start_installment",false],["status_approve",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fall_asset_config_schedulegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fall_asset_config_schedulegrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fall_asset_config_schedulegrid.lists.status_approve = <?= $Grid->status_approve->toClientList($Grid) ?>;
    loadjs.done("fall_asset_config_schedulegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> all_asset_config_schedule">
<div id="fall_asset_config_schedulegrid" class="ew-form ew-list-form">
<div id="gmp_all_asset_config_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_all_asset_config_schedulegrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->installment_all->Visible) { // installment_all ?>
        <th data-name="installment_all" class="<?= $Grid->installment_all->headerCellClass() ?>"><div id="elh_all_asset_config_schedule_installment_all" class="all_asset_config_schedule_installment_all"><?= $Grid->renderFieldHeader($Grid->installment_all) ?></div></th>
<?php } ?>
<?php if ($Grid->installment_price_per->Visible) { // installment_price_per ?>
        <th data-name="installment_price_per" class="<?= $Grid->installment_price_per->headerCellClass() ?>"><div id="elh_all_asset_config_schedule_installment_price_per" class="all_asset_config_schedule_installment_price_per"><?= $Grid->renderFieldHeader($Grid->installment_price_per) ?></div></th>
<?php } ?>
<?php if ($Grid->date_start_installment->Visible) { // date_start_installment ?>
        <th data-name="date_start_installment" class="<?= $Grid->date_start_installment->headerCellClass() ?>"><div id="elh_all_asset_config_schedule_date_start_installment" class="all_asset_config_schedule_date_start_installment"><?= $Grid->renderFieldHeader($Grid->date_start_installment) ?></div></th>
<?php } ?>
<?php if ($Grid->status_approve->Visible) { // status_approve ?>
        <th data-name="status_approve" class="<?= $Grid->status_approve->headerCellClass() ?>"><div id="elh_all_asset_config_schedule_status_approve" class="all_asset_config_schedule_status_approve"><?= $Grid->renderFieldHeader($Grid->status_approve) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_all_asset_config_schedule_cdate" class="all_asset_config_schedule_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_all_asset_config_schedule",
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
    <?php if ($Grid->installment_all->Visible) { // installment_all ?>
        <td data-name="installment_all"<?= $Grid->installment_all->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_installment_all" class="el_all_asset_config_schedule_installment_all">
<input type="<?= $Grid->installment_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" data-table="all_asset_config_schedule" data-field="x_installment_all" value="<?= $Grid->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_all->getPlaceHolder()) ?>"<?= $Grid->installment_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_all->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_all" id="o<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_installment_all" class="el_all_asset_config_schedule_installment_all">
<input type="<?= $Grid->installment_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" data-table="all_asset_config_schedule" data-field="x_installment_all" value="<?= $Grid->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_all->getPlaceHolder()) ?>"<?= $Grid->installment_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_all->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_installment_all" class="el_all_asset_config_schedule_installment_all">
<span<?= $Grid->installment_all->viewAttributes() ?>>
<?= $Grid->installment_all->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_all" data-hidden="1" name="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_installment_all" id="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->FormValue) ?>">
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_all" data-hidden="1" name="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_installment_all" id="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->installment_price_per->Visible) { // installment_price_per ?>
        <td data-name="installment_price_per"<?= $Grid->installment_price_per->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_installment_price_per" class="el_all_asset_config_schedule_installment_price_per">
<input type="<?= $Grid->installment_price_per->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_price_per" id="x<?= $Grid->RowIndex ?>_installment_price_per" data-table="all_asset_config_schedule" data-field="x_installment_price_per" value="<?= $Grid->installment_price_per->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_price_per->getPlaceHolder()) ?>"<?= $Grid->installment_price_per->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_price_per->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_price_per" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_price_per" id="o<?= $Grid->RowIndex ?>_installment_price_per" value="<?= HtmlEncode($Grid->installment_price_per->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_installment_price_per" class="el_all_asset_config_schedule_installment_price_per">
<input type="<?= $Grid->installment_price_per->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_price_per" id="x<?= $Grid->RowIndex ?>_installment_price_per" data-table="all_asset_config_schedule" data-field="x_installment_price_per" value="<?= $Grid->installment_price_per->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_price_per->getPlaceHolder()) ?>"<?= $Grid->installment_price_per->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_price_per->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_installment_price_per" class="el_all_asset_config_schedule_installment_price_per">
<span<?= $Grid->installment_price_per->viewAttributes() ?>>
<?= $Grid->installment_price_per->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_price_per" data-hidden="1" name="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_installment_price_per" id="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_installment_price_per" value="<?= HtmlEncode($Grid->installment_price_per->FormValue) ?>">
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_price_per" data-hidden="1" name="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_installment_price_per" id="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_installment_price_per" value="<?= HtmlEncode($Grid->installment_price_per->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_start_installment->Visible) { // date_start_installment ?>
        <td data-name="date_start_installment"<?= $Grid->date_start_installment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_date_start_installment" class="el_all_asset_config_schedule_date_start_installment">
<input type="<?= $Grid->date_start_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_start_installment" id="x<?= $Grid->RowIndex ?>_date_start_installment" data-table="all_asset_config_schedule" data-field="x_date_start_installment" value="<?= $Grid->date_start_installment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_start_installment->getPlaceHolder()) ?>"<?= $Grid->date_start_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_start_installment->getErrorMessage() ?></div>
<?php if (!$Grid->date_start_installment->ReadOnly && !$Grid->date_start_installment->Disabled && !isset($Grid->date_start_installment->EditAttrs["readonly"]) && !isset($Grid->date_start_installment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_asset_config_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_asset_config_schedulegrid", "x<?= $Grid->RowIndex ?>_date_start_installment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_date_start_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_start_installment" id="o<?= $Grid->RowIndex ?>_date_start_installment" value="<?= HtmlEncode($Grid->date_start_installment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_date_start_installment" class="el_all_asset_config_schedule_date_start_installment">
<input type="<?= $Grid->date_start_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_start_installment" id="x<?= $Grid->RowIndex ?>_date_start_installment" data-table="all_asset_config_schedule" data-field="x_date_start_installment" value="<?= $Grid->date_start_installment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_start_installment->getPlaceHolder()) ?>"<?= $Grid->date_start_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_start_installment->getErrorMessage() ?></div>
<?php if (!$Grid->date_start_installment->ReadOnly && !$Grid->date_start_installment->Disabled && !isset($Grid->date_start_installment->EditAttrs["readonly"]) && !isset($Grid->date_start_installment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_asset_config_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_asset_config_schedulegrid", "x<?= $Grid->RowIndex ?>_date_start_installment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_date_start_installment" class="el_all_asset_config_schedule_date_start_installment">
<span<?= $Grid->date_start_installment->viewAttributes() ?>>
<?= $Grid->date_start_installment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_date_start_installment" data-hidden="1" name="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_date_start_installment" id="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_date_start_installment" value="<?= HtmlEncode($Grid->date_start_installment->FormValue) ?>">
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_date_start_installment" data-hidden="1" name="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_date_start_installment" id="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_date_start_installment" value="<?= HtmlEncode($Grid->date_start_installment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_approve->Visible) { // status_approve ?>
        <td data-name="status_approve"<?= $Grid->status_approve->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_status_approve" class="el_all_asset_config_schedule_status_approve">
<template id="tp_x<?= $Grid->RowIndex ?>_status_approve">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="all_asset_config_schedule" data-field="x_status_approve" name="x<?= $Grid->RowIndex ?>_status_approve" id="x<?= $Grid->RowIndex ?>_status_approve"<?= $Grid->status_approve->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_approve" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_approve"
    name="x<?= $Grid->RowIndex ?>_status_approve"
    value="<?= HtmlEncode($Grid->status_approve->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_approve"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status_approve"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_approve->isInvalidClass() ?>"
    data-table="all_asset_config_schedule"
    data-field="x_status_approve"
    data-value-separator="<?= $Grid->status_approve->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_approve->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_approve->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_status_approve" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_approve" id="o<?= $Grid->RowIndex ?>_status_approve" value="<?= HtmlEncode($Grid->status_approve->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_status_approve" class="el_all_asset_config_schedule_status_approve">
<template id="tp_x<?= $Grid->RowIndex ?>_status_approve">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="all_asset_config_schedule" data-field="x_status_approve" name="x<?= $Grid->RowIndex ?>_status_approve" id="x<?= $Grid->RowIndex ?>_status_approve"<?= $Grid->status_approve->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_approve" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_approve"
    name="x<?= $Grid->RowIndex ?>_status_approve"
    value="<?= HtmlEncode($Grid->status_approve->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_approve"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status_approve"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_approve->isInvalidClass() ?>"
    data-table="all_asset_config_schedule"
    data-field="x_status_approve"
    data-value-separator="<?= $Grid->status_approve->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_approve->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_approve->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_status_approve" class="el_all_asset_config_schedule_status_approve">
<span<?= $Grid->status_approve->viewAttributes() ?>>
<?= $Grid->status_approve->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_status_approve" data-hidden="1" name="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_status_approve" id="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_status_approve" value="<?= HtmlEncode($Grid->status_approve->FormValue) ?>">
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_status_approve" data-hidden="1" name="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_status_approve" id="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_status_approve" value="<?= HtmlEncode($Grid->status_approve->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_all_asset_config_schedule_cdate" class="el_all_asset_config_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_cdate" data-hidden="1" name="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" id="fall_asset_config_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_cdate" data-hidden="1" name="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" id="fall_asset_config_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fall_asset_config_schedulegrid","load"], () => fall_asset_config_schedulegrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_all_asset_config_schedule", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->installment_all->Visible) { // installment_all ?>
        <td data-name="installment_all">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_asset_config_schedule_installment_all" class="el_all_asset_config_schedule_installment_all">
<input type="<?= $Grid->installment_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" data-table="all_asset_config_schedule" data-field="x_installment_all" value="<?= $Grid->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_all->getPlaceHolder()) ?>"<?= $Grid->installment_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_all->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_asset_config_schedule_installment_all" class="el_all_asset_config_schedule_installment_all">
<span<?= $Grid->installment_all->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->installment_all->getDisplayValue($Grid->installment_all->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_all" data-hidden="1" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_all" id="o<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->installment_price_per->Visible) { // installment_price_per ?>
        <td data-name="installment_price_per">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_asset_config_schedule_installment_price_per" class="el_all_asset_config_schedule_installment_price_per">
<input type="<?= $Grid->installment_price_per->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_price_per" id="x<?= $Grid->RowIndex ?>_installment_price_per" data-table="all_asset_config_schedule" data-field="x_installment_price_per" value="<?= $Grid->installment_price_per->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_price_per->getPlaceHolder()) ?>"<?= $Grid->installment_price_per->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_price_per->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_asset_config_schedule_installment_price_per" class="el_all_asset_config_schedule_installment_price_per">
<span<?= $Grid->installment_price_per->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->installment_price_per->getDisplayValue($Grid->installment_price_per->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_price_per" data-hidden="1" name="x<?= $Grid->RowIndex ?>_installment_price_per" id="x<?= $Grid->RowIndex ?>_installment_price_per" value="<?= HtmlEncode($Grid->installment_price_per->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_installment_price_per" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_price_per" id="o<?= $Grid->RowIndex ?>_installment_price_per" value="<?= HtmlEncode($Grid->installment_price_per->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_start_installment->Visible) { // date_start_installment ?>
        <td data-name="date_start_installment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_asset_config_schedule_date_start_installment" class="el_all_asset_config_schedule_date_start_installment">
<input type="<?= $Grid->date_start_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_start_installment" id="x<?= $Grid->RowIndex ?>_date_start_installment" data-table="all_asset_config_schedule" data-field="x_date_start_installment" value="<?= $Grid->date_start_installment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_start_installment->getPlaceHolder()) ?>"<?= $Grid->date_start_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_start_installment->getErrorMessage() ?></div>
<?php if (!$Grid->date_start_installment->ReadOnly && !$Grid->date_start_installment->Disabled && !isset($Grid->date_start_installment->EditAttrs["readonly"]) && !isset($Grid->date_start_installment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_asset_config_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_asset_config_schedulegrid", "x<?= $Grid->RowIndex ?>_date_start_installment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_asset_config_schedule_date_start_installment" class="el_all_asset_config_schedule_date_start_installment">
<span<?= $Grid->date_start_installment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_start_installment->getDisplayValue($Grid->date_start_installment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_date_start_installment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_start_installment" id="x<?= $Grid->RowIndex ?>_date_start_installment" value="<?= HtmlEncode($Grid->date_start_installment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_date_start_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_start_installment" id="o<?= $Grid->RowIndex ?>_date_start_installment" value="<?= HtmlEncode($Grid->date_start_installment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_approve->Visible) { // status_approve ?>
        <td data-name="status_approve">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_all_asset_config_schedule_status_approve" class="el_all_asset_config_schedule_status_approve">
<template id="tp_x<?= $Grid->RowIndex ?>_status_approve">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="all_asset_config_schedule" data-field="x_status_approve" name="x<?= $Grid->RowIndex ?>_status_approve" id="x<?= $Grid->RowIndex ?>_status_approve"<?= $Grid->status_approve->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_approve" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_approve"
    name="x<?= $Grid->RowIndex ?>_status_approve"
    value="<?= HtmlEncode($Grid->status_approve->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_approve"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status_approve"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_approve->isInvalidClass() ?>"
    data-table="all_asset_config_schedule"
    data-field="x_status_approve"
    data-value-separator="<?= $Grid->status_approve->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_approve->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_approve->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_all_asset_config_schedule_status_approve" class="el_all_asset_config_schedule_status_approve">
<span<?= $Grid->status_approve->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_approve->getDisplayValue($Grid->status_approve->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_status_approve" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_approve" id="x<?= $Grid->RowIndex ?>_status_approve" value="<?= HtmlEncode($Grid->status_approve->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_status_approve" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_approve" id="o<?= $Grid->RowIndex ?>_status_approve" value="<?= HtmlEncode($Grid->status_approve->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_all_asset_config_schedule_cdate" class="el_all_asset_config_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fall_asset_config_schedulegrid","load"], () => fall_asset_config_schedulegrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fall_asset_config_schedulegrid">
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
    ew.addEventHandlers("all_asset_config_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    var rowCount = $('#tbl_all_asset_config_schedulelist >tbody >tr').length;
    if(rowCount >= 1){
        $(".ew-add-edit-option").remove()
    }
});
</script>
<?php } ?>
