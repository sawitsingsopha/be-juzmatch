<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AssetScheduleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fasset_schedulegrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_schedulegrid = new ew.Form("fasset_schedulegrid", "grid");
    fasset_schedulegrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { asset_schedule: currentTable } });
    var fields = currentTable.fields;
    fasset_schedulegrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["num_installment", [fields.num_installment.visible && fields.num_installment.required ? ew.Validators.required(fields.num_installment.caption) : null, ew.Validators.integer], fields.num_installment.isInvalid],
        ["receive_per_installment_invertor", [fields.receive_per_installment_invertor.visible && fields.receive_per_installment_invertor.required ? ew.Validators.required(fields.receive_per_installment_invertor.caption) : null, ew.Validators.float], fields.receive_per_installment_invertor.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["installment_all", [fields.installment_all.visible && fields.installment_all.required ? ew.Validators.required(fields.installment_all.caption) : null, ew.Validators.integer], fields.installment_all.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Check empty row
    fasset_schedulegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["num_installment",false],["receive_per_installment_invertor",false],["expired_date",false],["date_payment",false],["status_payment",false],["installment_all",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fasset_schedulegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_schedulegrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_schedulegrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    fasset_schedulegrid.lists.status_payment = <?= $Grid->status_payment->toClientList($Grid) ?>;
    loadjs.done("fasset_schedulegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_schedule">
<div id="fasset_schedulegrid" class="ew-form ew-list-form">
<div id="gmp_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_asset_schedulegrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_asset_schedule_asset_id" class="asset_schedule_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <th data-name="num_installment" class="<?= $Grid->num_installment->headerCellClass() ?>"><div id="elh_asset_schedule_num_installment" class="asset_schedule_num_installment"><?= $Grid->renderFieldHeader($Grid->num_installment) ?></div></th>
<?php } ?>
<?php if ($Grid->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <th data-name="receive_per_installment_invertor" class="<?= $Grid->receive_per_installment_invertor->headerCellClass() ?>"><div id="elh_asset_schedule_receive_per_installment_invertor" class="asset_schedule_receive_per_installment_invertor"><?= $Grid->renderFieldHeader($Grid->receive_per_installment_invertor) ?></div></th>
<?php } ?>
<?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Grid->expired_date->headerCellClass() ?>"><div id="elh_asset_schedule_expired_date" class="asset_schedule_expired_date"><?= $Grid->renderFieldHeader($Grid->expired_date) ?></div></th>
<?php } ?>
<?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Grid->date_payment->headerCellClass() ?>"><div id="elh_asset_schedule_date_payment" class="asset_schedule_date_payment"><?= $Grid->renderFieldHeader($Grid->date_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Grid->status_payment->headerCellClass() ?>"><div id="elh_asset_schedule_status_payment" class="asset_schedule_status_payment"><?= $Grid->renderFieldHeader($Grid->status_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->installment_all->Visible) { // installment_all ?>
        <th data-name="installment_all" class="<?= $Grid->installment_all->headerCellClass() ?>"><div id="elh_asset_schedule_installment_all" class="asset_schedule_installment_all"><?= $Grid->renderFieldHeader($Grid->installment_all) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_asset_schedule_cdate" class="asset_schedule_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
<?php } ?>
<?php if ($Grid->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Grid->uip->headerCellClass() ?>"><div id="elh_asset_schedule_uip" class="asset_schedule_uip"><?= $Grid->renderFieldHeader($Grid->uip) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_asset_schedule",
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
    <?php if ($Grid->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Grid->asset_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->asset_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_asset_id" name="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode(FormatNumber($Grid->asset_id->CurrentValue, $Grid->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_schedulegrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="asset_schedule"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fasset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fasset_schedulegrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_schedulegrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_schedule.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_asset_id" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_asset_id" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment"<?= $Grid->num_installment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_num_installment" class="el_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_num_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_installment" id="o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_num_installment" class="el_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_num_installment" class="el_asset_schedule_num_installment">
<span<?= $Grid->num_installment->viewAttributes() ?>>
<?= $Grid->num_installment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_num_installment" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_num_installment" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_num_installment" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_num_installment" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <td data-name="receive_per_installment_invertor"<?= $Grid->receive_per_installment_invertor->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_receive_per_installment_invertor" class="el_asset_schedule_receive_per_installment_invertor">
<input type="<?= $Grid->receive_per_installment_invertor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" value="<?= $Grid->receive_per_installment_invertor->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->receive_per_installment_invertor->getPlaceHolder()) ?>"<?= $Grid->receive_per_installment_invertor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receive_per_installment_invertor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="o<?= $Grid->RowIndex ?>_receive_per_installment_invertor" value="<?= HtmlEncode($Grid->receive_per_installment_invertor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_receive_per_installment_invertor" class="el_asset_schedule_receive_per_installment_invertor">
<input type="<?= $Grid->receive_per_installment_invertor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" value="<?= $Grid->receive_per_installment_invertor->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->receive_per_installment_invertor->getPlaceHolder()) ?>"<?= $Grid->receive_per_installment_invertor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receive_per_installment_invertor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_receive_per_installment_invertor" class="el_asset_schedule_receive_per_installment_invertor">
<span<?= $Grid->receive_per_installment_invertor->viewAttributes() ?>>
<?= $Grid->receive_per_installment_invertor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" value="<?= HtmlEncode($Grid->receive_per_installment_invertor->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_receive_per_installment_invertor" value="<?= HtmlEncode($Grid->receive_per_installment_invertor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Grid->expired_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_expired_date" class="el_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_expired_date" class="el_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_expired_date" class="el_asset_schedule_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<?= $Grid->expired_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_expired_date" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_expired_date" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_expired_date" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_expired_date" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Grid->date_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_date_payment" class="el_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_date_payment" class="el_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_date_payment" class="el_asset_schedule_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<?= $Grid->date_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_date_payment" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_date_payment" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_date_payment" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_date_payment" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Grid->status_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_status_payment" class="el_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fasset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fasset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fasset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fasset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_status_payment" class="el_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fasset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fasset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fasset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fasset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_status_payment" class="el_asset_schedule_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<?= $Grid->status_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_status_payment" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_status_payment" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_status_payment" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_status_payment" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->installment_all->Visible) { // installment_all ?>
        <td data-name="installment_all"<?= $Grid->installment_all->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_installment_all" class="el_asset_schedule_installment_all">
<input type="<?= $Grid->installment_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" data-table="asset_schedule" data-field="x_installment_all" value="<?= $Grid->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_all->getPlaceHolder()) ?>"<?= $Grid->installment_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_all->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_installment_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_all" id="o<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_installment_all" class="el_asset_schedule_installment_all">
<input type="<?= $Grid->installment_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" data-table="asset_schedule" data-field="x_installment_all" value="<?= $Grid->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_all->getPlaceHolder()) ?>"<?= $Grid->installment_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_all->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_installment_all" class="el_asset_schedule_installment_all">
<span<?= $Grid->installment_all->viewAttributes() ?>>
<?= $Grid->installment_all->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_installment_all" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_installment_all" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_installment_all" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_installment_all" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_cdate" class="el_asset_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_cdate" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_cdate" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Grid->uip->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset_schedule" data-field="x_uip" data-hidden="1" name="o<?= $Grid->RowIndex ?>_uip" id="o<?= $Grid->RowIndex ?>_uip" value="<?= HtmlEncode($Grid->uip->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_schedule_uip" class="el_asset_schedule_uip">
<span<?= $Grid->uip->viewAttributes() ?>>
<?= $Grid->uip->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_schedule" data-field="x_uip" data-hidden="1" name="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_uip" id="fasset_schedulegrid$x<?= $Grid->RowIndex ?>_uip" value="<?= HtmlEncode($Grid->uip->FormValue) ?>">
<input type="hidden" data-table="asset_schedule" data-field="x_uip" data-hidden="1" name="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_uip" id="fasset_schedulegrid$o<?= $Grid->RowIndex ?>_uip" value="<?= HtmlEncode($Grid->uip->OldValue) ?>">
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
loadjs.ready(["fasset_schedulegrid","load"], () => fasset_schedulegrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_asset_schedule", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->asset_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_asset_id" name="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode(FormatNumber($Grid->asset_id->CurrentValue, $Grid->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_schedulegrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="asset_schedule"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fasset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fasset_schedulegrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_schedulegrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_schedule.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_asset_id" class="el_asset_schedule_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_schedule_num_installment" class="el_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_num_installment" class="el_asset_schedule_num_installment">
<span<?= $Grid->num_installment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->num_installment->getDisplayValue($Grid->num_installment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_num_installment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_num_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_installment" id="o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <td data-name="receive_per_installment_invertor">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_schedule_receive_per_installment_invertor" class="el_asset_schedule_receive_per_installment_invertor">
<input type="<?= $Grid->receive_per_installment_invertor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" value="<?= $Grid->receive_per_installment_invertor->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->receive_per_installment_invertor->getPlaceHolder()) ?>"<?= $Grid->receive_per_installment_invertor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receive_per_installment_invertor->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_receive_per_installment_invertor" class="el_asset_schedule_receive_per_installment_invertor">
<span<?= $Grid->receive_per_installment_invertor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->receive_per_installment_invertor->getDisplayValue($Grid->receive_per_installment_invertor->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" data-hidden="1" name="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="x<?= $Grid->RowIndex ?>_receive_per_installment_invertor" value="<?= HtmlEncode($Grid->receive_per_installment_invertor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receive_per_installment_invertor" id="o<?= $Grid->RowIndex ?>_receive_per_installment_invertor" value="<?= HtmlEncode($Grid->receive_per_installment_invertor->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_schedule_expired_date" class="el_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_expired_date" class="el_asset_schedule_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->expired_date->getDisplayValue($Grid->expired_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_expired_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_schedule_date_payment" class="el_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_date_payment" class="el_asset_schedule_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_payment->getDisplayValue($Grid->date_payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_date_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_schedule_status_payment" class="el_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fasset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fasset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fasset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fasset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_status_payment" class="el_asset_schedule_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_payment->getDisplayValue($Grid->status_payment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_status_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_payment" id="x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->installment_all->Visible) { // installment_all ?>
        <td data-name="installment_all">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_schedule_installment_all" class="el_asset_schedule_installment_all">
<input type="<?= $Grid->installment_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" data-table="asset_schedule" data-field="x_installment_all" value="<?= $Grid->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_all->getPlaceHolder()) ?>"<?= $Grid->installment_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_all->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_installment_all" class="el_asset_schedule_installment_all">
<span<?= $Grid->installment_all->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->installment_all->getDisplayValue($Grid->installment_all->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_installment_all" data-hidden="1" name="x<?= $Grid->RowIndex ?>_installment_all" id="x<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_installment_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_all" id="o<?= $Grid->RowIndex ?>_installment_all" value="<?= HtmlEncode($Grid->installment_all->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_cdate" class="el_asset_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->uip->Visible) { // uip ?>
        <td data-name="uip">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_schedule_uip" class="el_asset_schedule_uip">
<span<?= $Grid->uip->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->uip->getDisplayValue($Grid->uip->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_uip" data-hidden="1" name="x<?= $Grid->RowIndex ?>_uip" id="x<?= $Grid->RowIndex ?>_uip" value="<?= HtmlEncode($Grid->uip->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_schedule" data-field="x_uip" data-hidden="1" name="o<?= $Grid->RowIndex ?>_uip" id="o<?= $Grid->RowIndex ?>_uip" value="<?= HtmlEncode($Grid->uip->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fasset_schedulegrid","load"], () => fasset_schedulegrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fasset_schedulegrid">
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
    ew.addEventHandlers("asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
