<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("BuyerBookingAssetGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fbuyer_booking_assetgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_booking_assetgrid = new ew.Form("fbuyer_booking_assetgrid", "grid");
    fbuyer_booking_assetgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { buyer_booking_asset: currentTable } });
    var fields = currentTable.fields;
    fbuyer_booking_assetgrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["booking_price", [fields.booking_price.visible && fields.booking_price.required ? ew.Validators.required(fields.booking_price.caption) : null, ew.Validators.float], fields.booking_price.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["date_booking", [fields.date_booking.visible && fields.date_booking.required ? ew.Validators.required(fields.date_booking.caption) : null], fields.date_booking.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null], fields.date_payment.isInvalid],
        ["due_date", [fields.due_date.visible && fields.due_date.required ? ew.Validators.required(fields.due_date.caption) : null, ew.Validators.datetime(fields.due_date.clientFormatPattern)], fields.due_date.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fbuyer_booking_assetgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["booking_price",false],["pay_number",false],["status_payment",false],["date_booking",false],["date_payment",false],["due_date",false],["status_expire",false],["status_expire_reason",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fbuyer_booking_assetgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_booking_assetgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_booking_assetgrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    fbuyer_booking_assetgrid.lists.status_payment = <?= $Grid->status_payment->toClientList($Grid) ?>;
    fbuyer_booking_assetgrid.lists.status_expire = <?= $Grid->status_expire->toClientList($Grid) ?>;
    loadjs.done("fbuyer_booking_assetgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_booking_asset">
<div id="fbuyer_booking_assetgrid" class="ew-form ew-list-form">
<div id="gmp_buyer_booking_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_buyer_booking_assetgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_buyer_booking_asset_asset_id" class="buyer_booking_asset_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->booking_price->Visible) { // booking_price ?>
        <th data-name="booking_price" class="<?= $Grid->booking_price->headerCellClass() ?>"><div id="elh_buyer_booking_asset_booking_price" class="buyer_booking_asset_booking_price"><?= $Grid->renderFieldHeader($Grid->booking_price) ?></div></th>
<?php } ?>
<?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Grid->pay_number->headerCellClass() ?>"><div id="elh_buyer_booking_asset_pay_number" class="buyer_booking_asset_pay_number"><?= $Grid->renderFieldHeader($Grid->pay_number) ?></div></th>
<?php } ?>
<?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Grid->status_payment->headerCellClass() ?>"><div id="elh_buyer_booking_asset_status_payment" class="buyer_booking_asset_status_payment"><?= $Grid->renderFieldHeader($Grid->status_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Grid->date_booking->headerCellClass() ?>"><div id="elh_buyer_booking_asset_date_booking" class="buyer_booking_asset_date_booking"><?= $Grid->renderFieldHeader($Grid->date_booking) ?></div></th>
<?php } ?>
<?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Grid->date_payment->headerCellClass() ?>"><div id="elh_buyer_booking_asset_date_payment" class="buyer_booking_asset_date_payment"><?= $Grid->renderFieldHeader($Grid->date_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->due_date->Visible) { // due_date ?>
        <th data-name="due_date" class="<?= $Grid->due_date->headerCellClass() ?>"><div id="elh_buyer_booking_asset_due_date" class="buyer_booking_asset_due_date"><?= $Grid->renderFieldHeader($Grid->due_date) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Grid->status_expire->headerCellClass() ?>"><div id="elh_buyer_booking_asset_status_expire" class="buyer_booking_asset_status_expire"><?= $Grid->renderFieldHeader($Grid->status_expire) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Grid->status_expire_reason->headerCellClass() ?>"><div id="elh_buyer_booking_asset_status_expire_reason" class="buyer_booking_asset_status_expire_reason"><?= $Grid->renderFieldHeader($Grid->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_buyer_booking_asset_cdate" class="buyer_booking_asset_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_buyer_booking_asset",
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
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_asset_id" class="el_buyer_booking_asset_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="buyer_booking_asset"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fbuyer_booking_assetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_booking_assetgrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_booking_assetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_booking_assetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_booking_asset.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_asset_id" class="el_buyer_booking_asset_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_asset_id" class="el_buyer_booking_asset_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_asset_id" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_asset_id" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price"<?= $Grid->booking_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_booking_price" class="el_buyer_booking_asset_booking_price">
<input type="<?= $Grid->booking_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_booking_price" id="x<?= $Grid->RowIndex ?>_booking_price" data-table="buyer_booking_asset" data-field="x_booking_price" value="<?= $Grid->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->booking_price->getPlaceHolder()) ?>"<?= $Grid->booking_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->booking_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_booking_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_booking_price" id="o<?= $Grid->RowIndex ?>_booking_price" value="<?= HtmlEncode($Grid->booking_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_booking_price" class="el_buyer_booking_asset_booking_price">
<input type="<?= $Grid->booking_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_booking_price" id="x<?= $Grid->RowIndex ?>_booking_price" data-table="buyer_booking_asset" data-field="x_booking_price" value="<?= $Grid->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->booking_price->getPlaceHolder()) ?>"<?= $Grid->booking_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->booking_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_booking_price" class="el_buyer_booking_asset_booking_price">
<span<?= $Grid->booking_price->viewAttributes() ?>>
<?= $Grid->booking_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_booking_price" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_booking_price" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_booking_price" value="<?= HtmlEncode($Grid->booking_price->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_booking_price" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_booking_price" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_booking_price" value="<?= HtmlEncode($Grid->booking_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Grid->pay_number->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_pay_number" class="el_buyer_booking_asset_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_booking_asset" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_pay_number" class="el_buyer_booking_asset_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pay_number->getDisplayValue($Grid->pay_number->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_pay_number" class="el_buyer_booking_asset_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<?= $Grid->pay_number->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_pay_number" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_pay_number" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Grid->status_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_payment" class="el_buyer_booking_asset_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_booking_asset"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_booking_assetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_booking_assetgrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_booking_assetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_booking_assetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_booking_asset.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_payment" class="el_buyer_booking_asset_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_payment->getDisplayValue($Grid->status_payment->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_payment" id="x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_payment" class="el_buyer_booking_asset_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<?= $Grid->status_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_status_payment" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_status_payment" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Grid->date_booking->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_date_booking" class="el_buyer_booking_asset_date_booking">
<input type="<?= $Grid->date_booking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" data-table="buyer_booking_asset" data-field="x_date_booking" value="<?= $Grid->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_booking->getPlaceHolder()) ?>"<?= $Grid->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_booking->getErrorMessage() ?></div>
<?php if (!$Grid->date_booking->ReadOnly && !$Grid->date_booking->Disabled && !isset($Grid->date_booking->EditAttrs["readonly"]) && !isset($Grid->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_booking" id="o<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_date_booking" class="el_buyer_booking_asset_date_booking">
<span<?= $Grid->date_booking->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_booking->getDisplayValue($Grid->date_booking->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_date_booking" class="el_buyer_booking_asset_date_booking">
<span<?= $Grid->date_booking->viewAttributes() ?>>
<?= $Grid->date_booking->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_date_booking" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_date_booking" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Grid->date_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_date_payment" class="el_buyer_booking_asset_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_booking_asset" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_date_payment" class="el_buyer_booking_asset_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_payment->getDisplayValue($Grid->date_payment->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_date_payment" class="el_buyer_booking_asset_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<?= $Grid->date_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_date_payment" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_date_payment" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->due_date->Visible) { // due_date ?>
        <td data-name="due_date"<?= $Grid->due_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_due_date" class="el_buyer_booking_asset_due_date">
<input type="<?= $Grid->due_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date" id="x<?= $Grid->RowIndex ?>_due_date" data-table="buyer_booking_asset" data-field="x_due_date" value="<?= $Grid->due_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date->getPlaceHolder()) ?>"<?= $Grid->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date->getErrorMessage() ?></div>
<?php if (!$Grid->due_date->ReadOnly && !$Grid->due_date->Disabled && !isset($Grid->due_date->EditAttrs["readonly"]) && !isset($Grid->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_due_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_due_date" id="o<?= $Grid->RowIndex ?>_due_date" value="<?= HtmlEncode($Grid->due_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_due_date" class="el_buyer_booking_asset_due_date">
<input type="<?= $Grid->due_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date" id="x<?= $Grid->RowIndex ?>_due_date" data-table="buyer_booking_asset" data-field="x_due_date" value="<?= $Grid->due_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date->getPlaceHolder()) ?>"<?= $Grid->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date->getErrorMessage() ?></div>
<?php if (!$Grid->due_date->ReadOnly && !$Grid->due_date->Disabled && !isset($Grid->due_date->EditAttrs["readonly"]) && !isset($Grid->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_due_date" class="el_buyer_booking_asset_due_date">
<span<?= $Grid->due_date->viewAttributes() ?>>
<?= $Grid->due_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_due_date" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_due_date" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_due_date" value="<?= HtmlEncode($Grid->due_date->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_due_date" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_due_date" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_due_date" value="<?= HtmlEncode($Grid->due_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Grid->status_expire->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_expire" class="el_buyer_booking_asset_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="buyer_booking_asset" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
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
    data-table="buyer_booking_asset"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_expire" class="el_buyer_booking_asset_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="buyer_booking_asset" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
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
    data-table="buyer_booking_asset"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_expire" class="el_buyer_booking_asset_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<?= $Grid->status_expire->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_status_expire" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_status_expire" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Grid->status_expire_reason->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_expire_reason" class="el_buyer_booking_asset_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="buyer_booking_asset" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_expire_reason" class="el_buyer_booking_asset_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="buyer_booking_asset" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_status_expire_reason" class="el_buyer_booking_asset_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<?= $Grid->status_expire_reason->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire_reason" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_status_expire_reason" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire_reason" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_status_expire_reason" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_booking_asset_cdate" class="el_buyer_booking_asset_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_cdate" data-hidden="1" name="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_cdate" id="fbuyer_booking_assetgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="buyer_booking_asset" data-field="x_cdate" data-hidden="1" name="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_cdate" id="fbuyer_booking_assetgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fbuyer_booking_assetgrid","load"], () => fbuyer_booking_assetgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_buyer_booking_asset", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_buyer_booking_asset_asset_id" class="el_buyer_booking_asset_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="buyer_booking_asset"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fbuyer_booking_assetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_booking_assetgrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_booking_assetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_booking_assetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_booking_asset.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_asset_id" class="el_buyer_booking_asset_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_booking_price" class="el_buyer_booking_asset_booking_price">
<input type="<?= $Grid->booking_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_booking_price" id="x<?= $Grid->RowIndex ?>_booking_price" data-table="buyer_booking_asset" data-field="x_booking_price" value="<?= $Grid->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->booking_price->getPlaceHolder()) ?>"<?= $Grid->booking_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->booking_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_booking_price" class="el_buyer_booking_asset_booking_price">
<span<?= $Grid->booking_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->booking_price->getDisplayValue($Grid->booking_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_booking_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_booking_price" id="x<?= $Grid->RowIndex ?>_booking_price" value="<?= HtmlEncode($Grid->booking_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_booking_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_booking_price" id="o<?= $Grid->RowIndex ?>_booking_price" value="<?= HtmlEncode($Grid->booking_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_pay_number" class="el_buyer_booking_asset_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_booking_asset" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_pay_number" class="el_buyer_booking_asset_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pay_number->getDisplayValue($Grid->pay_number->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_status_payment" class="el_buyer_booking_asset_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_booking_asset"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_booking_assetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_booking_assetgrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_booking_assetgrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_booking_assetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_booking_assetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_booking_asset.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_status_payment" class="el_buyer_booking_asset_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_payment->getDisplayValue($Grid->status_payment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_payment" id="x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_date_booking" class="el_buyer_booking_asset_date_booking">
<input type="<?= $Grid->date_booking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" data-table="buyer_booking_asset" data-field="x_date_booking" value="<?= $Grid->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_booking->getPlaceHolder()) ?>"<?= $Grid->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_booking->getErrorMessage() ?></div>
<?php if (!$Grid->date_booking->ReadOnly && !$Grid->date_booking->Disabled && !isset($Grid->date_booking->EditAttrs["readonly"]) && !isset($Grid->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_date_booking" class="el_buyer_booking_asset_date_booking">
<span<?= $Grid->date_booking->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_booking->getDisplayValue($Grid->date_booking->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_booking" id="x<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_booking" id="o<?= $Grid->RowIndex ?>_date_booking" value="<?= HtmlEncode($Grid->date_booking->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_date_payment" class="el_buyer_booking_asset_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_booking_asset" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_date_payment" class="el_buyer_booking_asset_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_payment->getDisplayValue($Grid->date_payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->due_date->Visible) { // due_date ?>
        <td data-name="due_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_due_date" class="el_buyer_booking_asset_due_date">
<input type="<?= $Grid->due_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date" id="x<?= $Grid->RowIndex ?>_due_date" data-table="buyer_booking_asset" data-field="x_due_date" value="<?= $Grid->due_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date->getPlaceHolder()) ?>"<?= $Grid->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date->getErrorMessage() ?></div>
<?php if (!$Grid->due_date->ReadOnly && !$Grid->due_date->Disabled && !isset($Grid->due_date->EditAttrs["readonly"]) && !isset($Grid->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetgrid", "x<?= $Grid->RowIndex ?>_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_due_date" class="el_buyer_booking_asset_due_date">
<span<?= $Grid->due_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->due_date->getDisplayValue($Grid->due_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_due_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_due_date" id="x<?= $Grid->RowIndex ?>_due_date" value="<?= HtmlEncode($Grid->due_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_due_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_due_date" id="o<?= $Grid->RowIndex ?>_due_date" value="<?= HtmlEncode($Grid->due_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_status_expire" class="el_buyer_booking_asset_status_expire">
<template id="tp_x<?= $Grid->RowIndex ?>_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="buyer_booking_asset" data-field="x_status_expire" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire"<?= $Grid->status_expire->editAttributes() ?>>
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
    data-table="buyer_booking_asset"
    data-field="x_status_expire"
    data-value-separator="<?= $Grid->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_status_expire" class="el_buyer_booking_asset_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_expire->getDisplayValue($Grid->status_expire->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_booking_asset_status_expire_reason" class="el_buyer_booking_asset_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="buyer_booking_asset" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_status_expire_reason" class="el_buyer_booking_asset_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_expire_reason->getDisplayValue($Grid->status_expire_reason->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire_reason" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_buyer_booking_asset_cdate" class="el_buyer_booking_asset_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fbuyer_booking_assetgrid","load"], () => fbuyer_booking_assetgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fbuyer_booking_assetgrid">
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
    ew.addEventHandlers("buyer_booking_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
