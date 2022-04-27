<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("InvertorBookingGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var finvertor_bookinggrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvertor_bookinggrid = new ew.Form("finvertor_bookinggrid", "grid");
    finvertor_bookinggrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { invertor_booking: currentTable } });
    var fields = currentTable.fields;
    finvertor_bookinggrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["date_booking", [fields.date_booking.visible && fields.date_booking.required ? ew.Validators.required(fields.date_booking.caption) : null, ew.Validators.datetime(fields.date_booking.clientFormatPattern)], fields.date_booking.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid],
        ["payment_status", [fields.payment_status.visible && fields.payment_status.required ? ew.Validators.required(fields.payment_status.caption) : null], fields.payment_status.isInvalid],
        ["is_email", [fields.is_email.visible && fields.is_email.required ? ew.Validators.required(fields.is_email.caption) : null, ew.Validators.integer], fields.is_email.isInvalid],
        ["receipt_status", [fields.receipt_status.visible && fields.receipt_status.required ? ew.Validators.required(fields.receipt_status.caption) : null, ew.Validators.integer], fields.receipt_status.isInvalid]
    ]);

    // Check empty row
    finvertor_bookinggrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["date_booking",false],["status_expire",false],["status_expire_reason",false],["payment_status",false],["is_email",false],["receipt_status",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    finvertor_bookinggrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvertor_bookinggrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    finvertor_bookinggrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    finvertor_bookinggrid.lists.status_expire = <?= $Grid->status_expire->toClientList($Grid) ?>;
    finvertor_bookinggrid.lists.payment_status = <?= $Grid->payment_status->toClientList($Grid) ?>;
    loadjs.done("finvertor_bookinggrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invertor_booking">
<div id="finvertor_bookinggrid" class="ew-form ew-list-form">
<div id="gmp_invertor_booking" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_invertor_bookinggrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_invertor_booking_asset_id" class="invertor_booking_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Grid->date_booking->headerCellClass() ?>"><div id="elh_invertor_booking_date_booking" class="invertor_booking_date_booking"><?= $Grid->renderFieldHeader($Grid->date_booking) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Grid->status_expire->headerCellClass() ?>"><div id="elh_invertor_booking_status_expire" class="invertor_booking_status_expire"><?= $Grid->renderFieldHeader($Grid->status_expire) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Grid->status_expire_reason->headerCellClass() ?>"><div id="elh_invertor_booking_status_expire_reason" class="invertor_booking_status_expire_reason"><?= $Grid->renderFieldHeader($Grid->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Grid->payment_status->Visible) { // payment_status ?>
        <th data-name="payment_status" class="<?= $Grid->payment_status->headerCellClass() ?>"><div id="elh_invertor_booking_payment_status" class="invertor_booking_payment_status"><?= $Grid->renderFieldHeader($Grid->payment_status) ?></div></th>
<?php } ?>
<?php if ($Grid->is_email->Visible) { // is_email ?>
        <th data-name="is_email" class="<?= $Grid->is_email->headerCellClass() ?>"><div id="elh_invertor_booking_is_email" class="invertor_booking_is_email"><?= $Grid->renderFieldHeader($Grid->is_email) ?></div></th>
<?php } ?>
<?php if ($Grid->receipt_status->Visible) { // receipt_status ?>
        <th data-name="receipt_status" class="<?= $Grid->receipt_status->headerCellClass() ?>"><div id="elh_invertor_booking_receipt_status" class="invertor_booking_receipt_status"><?= $Grid->renderFieldHeader($Grid->receipt_status) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_invertor_booking",
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
<span id="el<?= $Grid->RowCount ?>_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="finvertor_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="invertor_booking"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("finvertor_bookinggrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "finvertor_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finvertor_bookinggrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finvertor_bookinggrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finvertor_bookinggrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.invertor_booking.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_asset_id" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_asset_id" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Grid->date_booking->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<input type="<?= $Grid->date_booking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" data-table="invertor_booking" data-field="x_date_booking" value="<?= $Grid->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_booking->getPlaceHolder()) ?>"<?= $Grid->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_booking->getErrorMessage() ?></div>
<?php if (!$Grid->date_booking->ReadOnly && !$Grid->date_booking->Disabled && !isset($Grid->date_booking->EditAttrs["readonly"]) && !isset($Grid->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvertor_bookinggrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("finvertor_bookinggrid", "x<?= $Grid->RowIndex ?>_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_date_booking" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_booking" id="o<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<input type="<?= $Grid->date_booking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" data-table="invertor_booking" data-field="x_date_booking" value="<?= $Grid->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_booking->getPlaceHolder()) ?>"<?= $Grid->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_booking->getErrorMessage() ?></div>
<?php if (!$Grid->date_booking->ReadOnly && !$Grid->date_booking->Disabled && !isset($Grid->date_booking->EditAttrs["readonly"]) && !isset($Grid->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvertor_bookinggrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("finvertor_bookinggrid", "x<?= $Grid->RowIndex ?>_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<span<?= $Grid->date_booking->viewAttributes() ?>>
<?= $Grid->date_booking->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_date_booking" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_date_booking" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_date_booking" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_date_booking" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Grid->status_expire->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_expire" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_expire"
    name="x<?= $Grid->RowIndex ?>_status_expire"
    value="<?= HtmlEncode($Grid->status_expire->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_expire"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status_expire"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_expire->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_expire" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_expire"
    name="x<?= $Grid->RowIndex ?>_status_expire"
    value="<?= HtmlEncode($Grid->status_expire->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_expire"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status_expire"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_expire->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<?= $Grid->status_expire->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Grid->status_expire_reason->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="invertor_booking" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="invertor_booking" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<?= $Grid->status_expire_reason->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire_reason" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire_reason" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire_reason" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire_reason" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->payment_status->Visible) { // payment_status ?>
        <td data-name="payment_status"<?= $Grid->payment_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<template id="tp_x<?= $Grid->RowIndex ?>_payment_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_payment_status" name="x<?= $Grid->RowIndex ?>_payment_status" id="x<?= $Grid->RowIndex ?>_payment_status"<?= $Grid->payment_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_payment_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_payment_status"
    name="x<?= $Grid->RowIndex ?>_payment_status"
    value="<?= HtmlEncode($Grid->payment_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_payment_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_payment_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->payment_status->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_payment_status"
    data-value-separator="<?= $Grid->payment_status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->payment_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->payment_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_payment_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_status" id="o<?= $Grid->RowIndex ?>_payment_status" value="<?= HtmlEncode($Grid->payment_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<template id="tp_x<?= $Grid->RowIndex ?>_payment_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_payment_status" name="x<?= $Grid->RowIndex ?>_payment_status" id="x<?= $Grid->RowIndex ?>_payment_status"<?= $Grid->payment_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_payment_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_payment_status"
    name="x<?= $Grid->RowIndex ?>_payment_status"
    value="<?= HtmlEncode($Grid->payment_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_payment_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_payment_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->payment_status->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_payment_status"
    data-value-separator="<?= $Grid->payment_status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->payment_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->payment_status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<span<?= $Grid->payment_status->viewAttributes() ?>>
<?= $Grid->payment_status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_payment_status" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_payment_status" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_payment_status" value="<?= HtmlEncode($Grid->payment_status->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_payment_status" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_payment_status" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_payment_status" value="<?= HtmlEncode($Grid->payment_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->is_email->Visible) { // is_email ?>
        <td data-name="is_email"<?= $Grid->is_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_is_email" class="el_invertor_booking_is_email">
<input type="<?= $Grid->is_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_is_email" id="x<?= $Grid->RowIndex ?>_is_email" data-table="invertor_booking" data-field="x_is_email" value="<?= $Grid->is_email->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->is_email->getPlaceHolder()) ?>"<?= $Grid->is_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->is_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_is_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_is_email" id="o<?= $Grid->RowIndex ?>_is_email" value="<?= HtmlEncode($Grid->is_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_is_email" class="el_invertor_booking_is_email">
<input type="<?= $Grid->is_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_is_email" id="x<?= $Grid->RowIndex ?>_is_email" data-table="invertor_booking" data-field="x_is_email" value="<?= $Grid->is_email->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->is_email->getPlaceHolder()) ?>"<?= $Grid->is_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->is_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_is_email" class="el_invertor_booking_is_email">
<span<?= $Grid->is_email->viewAttributes() ?>>
<?= $Grid->is_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_is_email" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_is_email" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_is_email" value="<?= HtmlEncode($Grid->is_email->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_is_email" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_is_email" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_is_email" value="<?= HtmlEncode($Grid->is_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->receipt_status->Visible) { // receipt_status ?>
        <td data-name="receipt_status"<?= $Grid->receipt_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<input type="<?= $Grid->receipt_status->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receipt_status" id="x<?= $Grid->RowIndex ?>_receipt_status" data-table="invertor_booking" data-field="x_receipt_status" value="<?= $Grid->receipt_status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->receipt_status->getPlaceHolder()) ?>"<?= $Grid->receipt_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receipt_status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_receipt_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receipt_status" id="o<?= $Grid->RowIndex ?>_receipt_status" value="<?= HtmlEncode($Grid->receipt_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<input type="<?= $Grid->receipt_status->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receipt_status" id="x<?= $Grid->RowIndex ?>_receipt_status" data-table="invertor_booking" data-field="x_receipt_status" value="<?= $Grid->receipt_status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->receipt_status->getPlaceHolder()) ?>"<?= $Grid->receipt_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receipt_status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<span<?= $Grid->receipt_status->viewAttributes() ?>>
<?= $Grid->receipt_status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invertor_booking" data-field="x_receipt_status" data-hidden="1" name="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_receipt_status" id="finvertor_bookinggrid$x<?= $Grid->RowIndex ?>_receipt_status" value="<?= HtmlEncode($Grid->receipt_status->FormValue) ?>">
<input type="hidden" data-table="invertor_booking" data-field="x_receipt_status" data-hidden="1" name="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_receipt_status" id="finvertor_bookinggrid$o<?= $Grid->RowIndex ?>_receipt_status" value="<?= HtmlEncode($Grid->receipt_status->OldValue) ?>">
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
loadjs.ready(["finvertor_bookinggrid","load"], () => finvertor_bookinggrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_invertor_booking", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="finvertor_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="invertor_booking"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("finvertor_bookinggrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "finvertor_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finvertor_bookinggrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finvertor_bookinggrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finvertor_bookinggrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.invertor_booking.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<input type="<?= $Grid->date_booking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" data-table="invertor_booking" data-field="x_date_booking" value="<?= $Grid->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_booking->getPlaceHolder()) ?>"<?= $Grid->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_booking->getErrorMessage() ?></div>
<?php if (!$Grid->date_booking->ReadOnly && !$Grid->date_booking->Disabled && !isset($Grid->date_booking->EditAttrs["readonly"]) && !isset($Grid->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvertor_bookinggrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("finvertor_bookinggrid", "x<?= $Grid->RowIndex ?>_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<span<?= $Grid->date_booking->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_booking->getDisplayValue($Grid->date_booking->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_date_booking" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_date_booking" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_booking" id="o<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_expire" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_expire"
    name="x<?= $Grid->RowIndex ?>_status_expire"
    value="<?= HtmlEncode($Grid->status_expire->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_expire"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_status_expire"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_expire->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_expire->getDisplayValue($Grid->status_expire->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="invertor_booking" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_expire_reason->getDisplayValue($Grid->status_expire_reason->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire_reason" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->payment_status->Visible) { // payment_status ?>
        <td data-name="payment_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<template id="tp_x<?= $Grid->RowIndex ?>_payment_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_payment_status" name="x<?= $Grid->RowIndex ?>_payment_status" id="x<?= $Grid->RowIndex ?>_payment_status"<?= $Grid->payment_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_payment_status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_payment_status"
    name="x<?= $Grid->RowIndex ?>_payment_status"
    value="<?= HtmlEncode($Grid->payment_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_payment_status"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_payment_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->payment_status->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_payment_status"
    data-value-separator="<?= $Grid->payment_status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->payment_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->payment_status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<span<?= $Grid->payment_status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->payment_status->getDisplayValue($Grid->payment_status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_payment_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment_status" id="x<?= $Grid->RowIndex ?>_payment_status" value="<?= HtmlEncode($Grid->payment_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_payment_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_status" id="o<?= $Grid->RowIndex ?>_payment_status" value="<?= HtmlEncode($Grid->payment_status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->is_email->Visible) { // is_email ?>
        <td data-name="is_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invertor_booking_is_email" class="el_invertor_booking_is_email">
<input type="<?= $Grid->is_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_is_email" id="x<?= $Grid->RowIndex ?>_is_email" data-table="invertor_booking" data-field="x_is_email" value="<?= $Grid->is_email->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->is_email->getPlaceHolder()) ?>"<?= $Grid->is_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->is_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_is_email" class="el_invertor_booking_is_email">
<span<?= $Grid->is_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->is_email->getDisplayValue($Grid->is_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_is_email" data-hidden="1" name="x<?= $Grid->RowIndex ?>_is_email" id="x<?= $Grid->RowIndex ?>_is_email" value="<?= HtmlEncode($Grid->is_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_is_email" data-hidden="1" name="o<?= $Grid->RowIndex ?>_is_email" id="o<?= $Grid->RowIndex ?>_is_email" value="<?= HtmlEncode($Grid->is_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->receipt_status->Visible) { // receipt_status ?>
        <td data-name="receipt_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<input type="<?= $Grid->receipt_status->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_receipt_status" id="x<?= $Grid->RowIndex ?>_receipt_status" data-table="invertor_booking" data-field="x_receipt_status" value="<?= $Grid->receipt_status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->receipt_status->getPlaceHolder()) ?>"<?= $Grid->receipt_status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->receipt_status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<span<?= $Grid->receipt_status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->receipt_status->getDisplayValue($Grid->receipt_status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_receipt_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_receipt_status" id="x<?= $Grid->RowIndex ?>_receipt_status" value="<?= HtmlEncode($Grid->receipt_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invertor_booking" data-field="x_receipt_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receipt_status" id="o<?= $Grid->RowIndex ?>_receipt_status" value="<?= HtmlEncode($Grid->receipt_status->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["finvertor_bookinggrid","load"], () => finvertor_bookinggrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="finvertor_bookinggrid">
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
    ew.addEventHandlers("invertor_booking");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
