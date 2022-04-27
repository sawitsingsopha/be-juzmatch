<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("BuyerAssetReadyBuyGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fbuyer_asset_ready_buygrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_ready_buygrid = new ew.Form("fbuyer_asset_ready_buygrid", "grid");
    fbuyer_asset_ready_buygrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { buyer_asset_ready_buy: currentTable } });
    var fields = currentTable.fields;
    fbuyer_asset_ready_buygrid.addFields([
        ["price_payment", [fields.price_payment.visible && fields.price_payment.required ? ew.Validators.required(fields.price_payment.caption) : null, ew.Validators.float], fields.price_payment.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["duedate", [fields.duedate.visible && fields.duedate.required ? ew.Validators.required(fields.duedate.caption) : null, ew.Validators.datetime(fields.duedate.clientFormatPattern)], fields.duedate.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fbuyer_asset_ready_buygrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["price_payment",false],["pay_number",false],["status_payment",false],["date_payment",false],["duedate",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fbuyer_asset_ready_buygrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_asset_ready_buygrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_asset_ready_buygrid.lists.status_payment = <?= $Grid->status_payment->toClientList($Grid) ?>;
    loadjs.done("fbuyer_asset_ready_buygrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_asset_ready_buy">
<div id="fbuyer_asset_ready_buygrid" class="ew-form ew-list-form">
<div id="gmp_buyer_asset_ready_buy" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_buyer_asset_ready_buygrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->price_payment->Visible) { // price_payment ?>
        <th data-name="price_payment" class="<?= $Grid->price_payment->headerCellClass() ?>"><div id="elh_buyer_asset_ready_buy_price_payment" class="buyer_asset_ready_buy_price_payment"><?= $Grid->renderFieldHeader($Grid->price_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Grid->pay_number->headerCellClass() ?>"><div id="elh_buyer_asset_ready_buy_pay_number" class="buyer_asset_ready_buy_pay_number"><?= $Grid->renderFieldHeader($Grid->pay_number) ?></div></th>
<?php } ?>
<?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Grid->status_payment->headerCellClass() ?>"><div id="elh_buyer_asset_ready_buy_status_payment" class="buyer_asset_ready_buy_status_payment"><?= $Grid->renderFieldHeader($Grid->status_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Grid->date_payment->headerCellClass() ?>"><div id="elh_buyer_asset_ready_buy_date_payment" class="buyer_asset_ready_buy_date_payment"><?= $Grid->renderFieldHeader($Grid->date_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->duedate->Visible) { // due date ?>
        <th data-name="duedate" class="<?= $Grid->duedate->headerCellClass() ?>"><div id="elh_buyer_asset_ready_buy_duedate" class="buyer_asset_ready_buy_duedate"><?= $Grid->renderFieldHeader($Grid->duedate) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_buyer_asset_ready_buy_cdate" class="buyer_asset_ready_buy_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_buyer_asset_ready_buy",
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
    <?php if ($Grid->price_payment->Visible) { // price_payment ?>
        <td data-name="price_payment"<?= $Grid->price_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_price_payment" class="el_buyer_asset_ready_buy_price_payment">
<input type="<?= $Grid->price_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_price_payment" id="x<?= $Grid->RowIndex ?>_price_payment" data-table="buyer_asset_ready_buy" data-field="x_price_payment" value="<?= $Grid->price_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->price_payment->getPlaceHolder()) ?>"<?= $Grid->price_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->price_payment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_price_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_price_payment" id="o<?= $Grid->RowIndex ?>_price_payment" value="<?= HtmlEncode($Grid->price_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_price_payment" class="el_buyer_asset_ready_buy_price_payment">
<input type="<?= $Grid->price_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_price_payment" id="x<?= $Grid->RowIndex ?>_price_payment" data-table="buyer_asset_ready_buy" data-field="x_price_payment" value="<?= $Grid->price_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->price_payment->getPlaceHolder()) ?>"<?= $Grid->price_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->price_payment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_price_payment" class="el_buyer_asset_ready_buy_price_payment">
<span<?= $Grid->price_payment->viewAttributes() ?>>
<?= $Grid->price_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_price_payment" data-hidden="1" name="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_price_payment" id="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_price_payment" value="<?= HtmlEncode($Grid->price_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_price_payment" data-hidden="1" name="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_price_payment" id="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_price_payment" value="<?= HtmlEncode($Grid->price_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Grid->pay_number->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_pay_number" class="el_buyer_asset_ready_buy_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_asset_ready_buy" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_pay_number" class="el_buyer_asset_ready_buy_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_asset_ready_buy" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_pay_number" class="el_buyer_asset_ready_buy_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<?= $Grid->pay_number->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_pay_number" data-hidden="1" name="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_pay_number" id="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_pay_number" data-hidden="1" name="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_pay_number" id="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Grid->status_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_status_payment" class="el_buyer_asset_ready_buy_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_ready_buygrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_asset_ready_buy"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_ready_buygrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_asset_ready_buygrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_ready_buygrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_ready_buygrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_ready_buygrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_ready_buy.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_status_payment" class="el_buyer_asset_ready_buy_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_ready_buygrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_asset_ready_buy"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_ready_buygrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_asset_ready_buygrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_ready_buygrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_ready_buygrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_ready_buygrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_ready_buy.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_status_payment" class="el_buyer_asset_ready_buy_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<?= $Grid->status_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_status_payment" data-hidden="1" name="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_status_payment" id="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_status_payment" data-hidden="1" name="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_status_payment" id="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Grid->date_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_date_payment" class="el_buyer_asset_ready_buy_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_asset_ready_buy" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_ready_buygrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_date_payment" class="el_buyer_asset_ready_buy_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_asset_ready_buy" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_ready_buygrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_date_payment" class="el_buyer_asset_ready_buy_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<?= $Grid->date_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_date_payment" data-hidden="1" name="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_date_payment" id="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_date_payment" data-hidden="1" name="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_date_payment" id="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->duedate->Visible) { // due date ?>
        <td data-name="duedate"<?= $Grid->duedate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_duedate" class="el_buyer_asset_ready_buy_duedate">
<input type="<?= $Grid->duedate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_duedate" id="x<?= $Grid->RowIndex ?>_duedate" data-table="buyer_asset_ready_buy" data-field="x_duedate" value="<?= $Grid->duedate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->duedate->getPlaceHolder()) ?>"<?= $Grid->duedate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->duedate->getErrorMessage() ?></div>
<?php if (!$Grid->duedate->ReadOnly && !$Grid->duedate->Disabled && !isset($Grid->duedate->EditAttrs["readonly"]) && !isset($Grid->duedate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_ready_buygrid", "x<?= $Grid->RowIndex ?>_duedate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_duedate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_duedate" id="o<?= $Grid->RowIndex ?>_duedate" value="<?= HtmlEncode($Grid->duedate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_duedate" class="el_buyer_asset_ready_buy_duedate">
<input type="<?= $Grid->duedate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_duedate" id="x<?= $Grid->RowIndex ?>_duedate" data-table="buyer_asset_ready_buy" data-field="x_duedate" value="<?= $Grid->duedate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->duedate->getPlaceHolder()) ?>"<?= $Grid->duedate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->duedate->getErrorMessage() ?></div>
<?php if (!$Grid->duedate->ReadOnly && !$Grid->duedate->Disabled && !isset($Grid->duedate->EditAttrs["readonly"]) && !isset($Grid->duedate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_ready_buygrid", "x<?= $Grid->RowIndex ?>_duedate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_duedate" class="el_buyer_asset_ready_buy_duedate">
<span<?= $Grid->duedate->viewAttributes() ?>>
<?= $Grid->duedate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_duedate" data-hidden="1" name="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_duedate" id="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_duedate" value="<?= HtmlEncode($Grid->duedate->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_duedate" data-hidden="1" name="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_duedate" id="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_duedate" value="<?= HtmlEncode($Grid->duedate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_ready_buy_cdate" class="el_buyer_asset_ready_buy_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_cdate" data-hidden="1" name="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_cdate" id="fbuyer_asset_ready_buygrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_cdate" data-hidden="1" name="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_cdate" id="fbuyer_asset_ready_buygrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fbuyer_asset_ready_buygrid","load"], () => fbuyer_asset_ready_buygrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_buyer_asset_ready_buy", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->price_payment->Visible) { // price_payment ?>
        <td data-name="price_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_price_payment" class="el_buyer_asset_ready_buy_price_payment">
<input type="<?= $Grid->price_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_price_payment" id="x<?= $Grid->RowIndex ?>_price_payment" data-table="buyer_asset_ready_buy" data-field="x_price_payment" value="<?= $Grid->price_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->price_payment->getPlaceHolder()) ?>"<?= $Grid->price_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->price_payment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_price_payment" class="el_buyer_asset_ready_buy_price_payment">
<span<?= $Grid->price_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->price_payment->getDisplayValue($Grid->price_payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_price_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_price_payment" id="x<?= $Grid->RowIndex ?>_price_payment" value="<?= HtmlEncode($Grid->price_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_price_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_price_payment" id="o<?= $Grid->RowIndex ?>_price_payment" value="<?= HtmlEncode($Grid->price_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_pay_number" class="el_buyer_asset_ready_buy_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_asset_ready_buy" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_pay_number" class="el_buyer_asset_ready_buy_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pay_number->getDisplayValue($Grid->pay_number->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_pay_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_status_payment" class="el_buyer_asset_ready_buy_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_ready_buygrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_asset_ready_buy"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_ready_buygrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_asset_ready_buygrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_ready_buygrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_ready_buygrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_ready_buygrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_ready_buy.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_status_payment" class="el_buyer_asset_ready_buy_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_payment->getDisplayValue($Grid->status_payment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_status_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_payment" id="x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_date_payment" class="el_buyer_asset_ready_buy_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_asset_ready_buy" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_ready_buygrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_date_payment" class="el_buyer_asset_ready_buy_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_payment->getDisplayValue($Grid->date_payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_date_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->duedate->Visible) { // due date ?>
        <td data-name="duedate">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_duedate" class="el_buyer_asset_ready_buy_duedate">
<input type="<?= $Grid->duedate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_duedate" id="x<?= $Grid->RowIndex ?>_duedate" data-table="buyer_asset_ready_buy" data-field="x_duedate" value="<?= $Grid->duedate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->duedate->getPlaceHolder()) ?>"<?= $Grid->duedate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->duedate->getErrorMessage() ?></div>
<?php if (!$Grid->duedate->ReadOnly && !$Grid->duedate->Disabled && !isset($Grid->duedate->EditAttrs["readonly"]) && !isset($Grid->duedate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_ready_buygrid", "x<?= $Grid->RowIndex ?>_duedate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_duedate" class="el_buyer_asset_ready_buy_duedate">
<span<?= $Grid->duedate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->duedate->getDisplayValue($Grid->duedate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_duedate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_duedate" id="x<?= $Grid->RowIndex ?>_duedate" value="<?= HtmlEncode($Grid->duedate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_duedate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_duedate" id="o<?= $Grid->RowIndex ?>_duedate" value="<?= HtmlEncode($Grid->duedate->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_ready_buy_cdate" class="el_buyer_asset_ready_buy_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_ready_buy" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fbuyer_asset_ready_buygrid","load"], () => fbuyer_asset_ready_buygrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fbuyer_asset_ready_buygrid">
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
    ew.addEventHandlers("buyer_asset_ready_buy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
