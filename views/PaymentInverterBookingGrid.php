<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("PaymentInverterBookingGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fpayment_inverter_bookinggrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpayment_inverter_bookinggrid = new ew.Form("fpayment_inverter_bookinggrid", "grid");
    fpayment_inverter_bookinggrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { payment_inverter_booking: currentTable } });
    var fields = currentTable.fields;
    fpayment_inverter_bookinggrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["payment", [fields.payment.visible && fields.payment.required ? ew.Validators.required(fields.payment.caption) : null], fields.payment.isInvalid],
        ["payment_number", [fields.payment_number.visible && fields.payment_number.required ? ew.Validators.required(fields.payment_number.caption) : null], fields.payment_number.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid]
    ]);

    // Check empty row
    fpayment_inverter_bookinggrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["payment",false],["payment_number",false],["status",false],["status_expire",false],["status_expire_reason",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fpayment_inverter_bookinggrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpayment_inverter_bookinggrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpayment_inverter_bookinggrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    fpayment_inverter_bookinggrid.lists.status = <?= $Grid->status->toClientList($Grid) ?>;
    fpayment_inverter_bookinggrid.lists.status_expire = <?= $Grid->status_expire->toClientList($Grid) ?>;
    loadjs.done("fpayment_inverter_bookinggrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> payment_inverter_booking">
<div id="fpayment_inverter_bookinggrid" class="ew-form ew-list-form">
<div id="gmp_payment_inverter_booking" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_payment_inverter_bookinggrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_payment_inverter_booking_asset_id" class="payment_inverter_booking_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->payment->Visible) { // payment ?>
        <th data-name="payment" class="<?= $Grid->payment->headerCellClass() ?>"><div id="elh_payment_inverter_booking_payment" class="payment_inverter_booking_payment"><?= $Grid->renderFieldHeader($Grid->payment) ?></div></th>
<?php } ?>
<?php if ($Grid->payment_number->Visible) { // payment_number ?>
        <th data-name="payment_number" class="<?= $Grid->payment_number->headerCellClass() ?>"><div id="elh_payment_inverter_booking_payment_number" class="payment_inverter_booking_payment_number"><?= $Grid->renderFieldHeader($Grid->payment_number) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_payment_inverter_booking_status" class="payment_inverter_booking_status"><?= $Grid->renderFieldHeader($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Grid->status_expire->headerCellClass() ?>"><div id="elh_payment_inverter_booking_status_expire" class="payment_inverter_booking_status_expire"><?= $Grid->renderFieldHeader($Grid->status_expire) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Grid->status_expire_reason->headerCellClass() ?>"><div id="elh_payment_inverter_booking_status_expire_reason" class="payment_inverter_booking_status_expire_reason"><?= $Grid->renderFieldHeader($Grid->status_expire_reason) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_payment_inverter_booking",
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
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_asset_id" name="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode(FormatNumber($Grid->asset_id->CurrentValue, $Grid->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="payment_inverter_booking"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fpayment_inverter_bookinggrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpayment_inverter_bookinggrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fpayment_inverter_bookinggrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fpayment_inverter_bookinggrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.payment_inverter_booking.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_asset_id" id="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_asset_id" id="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->payment->Visible) { // payment ?>
        <td data-name="payment"<?= $Grid->payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_payment" class="el_payment_inverter_booking_payment">
<input type="<?= $Grid->payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_payment" id="x<?= $Grid->RowIndex ?>_payment" data-table="payment_inverter_booking" data-field="x_payment" value="<?= $Grid->payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->payment->getPlaceHolder()) ?>"<?= $Grid->payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment" id="o<?= $Grid->RowIndex ?>_payment" value="<?= HtmlEncode($Grid->payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_payment" class="el_payment_inverter_booking_payment">
<span<?= $Grid->payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment->getDisplayValue($Grid->payment->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment" id="x<?= $Grid->RowIndex ?>_payment" value="<?= HtmlEncode($Grid->payment->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_payment" class="el_payment_inverter_booking_payment">
<span<?= $Grid->payment->viewAttributes() ?>>
<?= $Grid->payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_payment" id="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_payment" value="<?= HtmlEncode($Grid->payment->FormValue) ?>">
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_payment" id="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_payment" value="<?= HtmlEncode($Grid->payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->payment_number->Visible) { // payment_number ?>
        <td data-name="payment_number"<?= $Grid->payment_number->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_payment_number" class="el_payment_inverter_booking_payment_number">
<input type="<?= $Grid->payment_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_payment_number" id="x<?= $Grid->RowIndex ?>_payment_number" data-table="payment_inverter_booking" data-field="x_payment_number" value="<?= $Grid->payment_number->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->payment_number->getPlaceHolder()) ?>"<?= $Grid->payment_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment_number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_number" id="o<?= $Grid->RowIndex ?>_payment_number" value="<?= HtmlEncode($Grid->payment_number->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_payment_number" class="el_payment_inverter_booking_payment_number">
<span<?= $Grid->payment_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment_number->getDisplayValue($Grid->payment_number->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment_number" id="x<?= $Grid->RowIndex ?>_payment_number" value="<?= HtmlEncode($Grid->payment_number->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_payment_number" class="el_payment_inverter_booking_payment_number">
<span<?= $Grid->payment_number->viewAttributes() ?>>
<?= $Grid->payment_number->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_payment_number" id="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_payment_number" value="<?= HtmlEncode($Grid->payment_number->FormValue) ?>">
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_payment_number" id="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_payment_number" value="<?= HtmlEncode($Grid->payment_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status"<?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status" class="el_payment_inverter_booking_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_status"
        data-table="payment_inverter_booking"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fpayment_inverter_bookinggrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpayment_inverter_bookinggrid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fpayment_inverter_bookinggrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fpayment_inverter_bookinggrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.payment_inverter_booking.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status" class="el_payment_inverter_booking_status">
<span<?= $Grid->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status->getDisplayValue($Grid->status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status" class="el_payment_inverter_booking_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_status" id="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_status" id="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Grid->status_expire->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status_expire" class="el_payment_inverter_booking_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="payment_inverter_booking" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
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
    data-table="payment_inverter_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status_expire" class="el_payment_inverter_booking_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="payment_inverter_booking" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
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
    data-table="payment_inverter_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status_expire" class="el_payment_inverter_booking_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<?= $Grid->status_expire->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire" data-hidden="1" name="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire" id="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire" data-hidden="1" name="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire" id="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Grid->status_expire_reason->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status_expire_reason" class="el_payment_inverter_booking_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="payment_inverter_booking" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status_expire_reason" class="el_payment_inverter_booking_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="payment_inverter_booking" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_payment_inverter_booking_status_expire_reason" class="el_payment_inverter_booking_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<?= $Grid->status_expire_reason->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire_reason" data-hidden="1" name="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire_reason" id="fpayment_inverter_bookinggrid$x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire_reason" data-hidden="1" name="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire_reason" id="fpayment_inverter_bookinggrid$o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
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
loadjs.ready(["fpayment_inverter_bookinggrid","load"], () => fpayment_inverter_bookinggrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_payment_inverter_booking", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_asset_id" name="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode(FormatNumber($Grid->asset_id->CurrentValue, $Grid->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="payment_inverter_booking"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fpayment_inverter_bookinggrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpayment_inverter_bookinggrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fpayment_inverter_bookinggrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fpayment_inverter_bookinggrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.payment_inverter_booking.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_asset_id" class="el_payment_inverter_booking_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->payment->Visible) { // payment ?>
        <td data-name="payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_payment_inverter_booking_payment" class="el_payment_inverter_booking_payment">
<input type="<?= $Grid->payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_payment" id="x<?= $Grid->RowIndex ?>_payment" data-table="payment_inverter_booking" data-field="x_payment" value="<?= $Grid->payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->payment->getPlaceHolder()) ?>"<?= $Grid->payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_payment" class="el_payment_inverter_booking_payment">
<span<?= $Grid->payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment->getDisplayValue($Grid->payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment" id="x<?= $Grid->RowIndex ?>_payment" value="<?= HtmlEncode($Grid->payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment" id="o<?= $Grid->RowIndex ?>_payment" value="<?= HtmlEncode($Grid->payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->payment_number->Visible) { // payment_number ?>
        <td data-name="payment_number">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_payment_inverter_booking_payment_number" class="el_payment_inverter_booking_payment_number">
<input type="<?= $Grid->payment_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_payment_number" id="x<?= $Grid->RowIndex ?>_payment_number" data-table="payment_inverter_booking" data-field="x_payment_number" value="<?= $Grid->payment_number->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->payment_number->getPlaceHolder()) ?>"<?= $Grid->payment_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->payment_number->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_payment_number" class="el_payment_inverter_booking_payment_number">
<span<?= $Grid->payment_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->payment_number->getDisplayValue($Grid->payment_number->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_payment_number" id="x<?= $Grid->RowIndex ?>_payment_number" value="<?= HtmlEncode($Grid->payment_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_payment_number" id="o<?= $Grid->RowIndex ?>_payment_number" value="<?= HtmlEncode($Grid->payment_number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_payment_inverter_booking_status" class="el_payment_inverter_booking_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_status"
        data-table="payment_inverter_booking"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fpayment_inverter_bookinggrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "fpayment_inverter_bookinggrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpayment_inverter_bookinggrid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "fpayment_inverter_bookinggrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "fpayment_inverter_bookinggrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.payment_inverter_booking.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_status" class="el_payment_inverter_booking_status">
<span<?= $Grid->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status->getDisplayValue($Grid->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_payment_inverter_booking_status_expire" class="el_payment_inverter_booking_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="payment_inverter_booking" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
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
    data-table="payment_inverter_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_status_expire" class="el_payment_inverter_booking_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_expire->getDisplayValue($Grid->status_expire->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_payment_inverter_booking_status_expire_reason" class="el_payment_inverter_booking_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="payment_inverter_booking" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_payment_inverter_booking_status_expire_reason" class="el_payment_inverter_booking_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_expire_reason->getDisplayValue($Grid->status_expire_reason->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire_reason" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fpayment_inverter_bookinggrid","load"], () => fpayment_inverter_bookinggrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fpayment_inverter_bookinggrid">
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
    ew.addEventHandlers("payment_inverter_booking");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Grid->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_payment_inverter_booking",
        width: "100%",
        height: "500px"
    });
});
</script>
<?php } ?>
<?php } ?>
