<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("BuyerAssetScheduleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fbuyer_asset_schedulegrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_schedulegrid = new ew.Form("fbuyer_asset_schedulegrid", "grid");
    fbuyer_asset_schedulegrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { buyer_asset_schedule: currentTable } });
    var fields = currentTable.fields;
    fbuyer_asset_schedulegrid.addFields([
        ["num_installment", [fields.num_installment.visible && fields.num_installment.required ? ew.Validators.required(fields.num_installment.caption) : null, ew.Validators.integer], fields.num_installment.isInvalid],
        ["installment_per_price", [fields.installment_per_price.visible && fields.installment_per_price.required ? ew.Validators.required(fields.installment_per_price.caption) : null, ew.Validators.float], fields.installment_per_price.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fbuyer_asset_schedulegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["num_installment",false],["installment_per_price",false],["pay_number",false],["expired_date",false],["date_payment",false],["status_payment",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fbuyer_asset_schedulegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_asset_schedulegrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_asset_schedulegrid.lists.status_payment = <?= $Grid->status_payment->toClientList($Grid) ?>;
    loadjs.done("fbuyer_asset_schedulegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_asset_schedule">
<div id="fbuyer_asset_schedulegrid" class="ew-form ew-list-form">
<div id="gmp_buyer_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_buyer_asset_schedulegrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <th data-name="num_installment" class="<?= $Grid->num_installment->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_num_installment" class="buyer_asset_schedule_num_installment"><?= $Grid->renderFieldHeader($Grid->num_installment) ?></div></th>
<?php } ?>
<?php if ($Grid->installment_per_price->Visible) { // installment_per_price ?>
        <th data-name="installment_per_price" class="<?= $Grid->installment_per_price->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_installment_per_price" class="buyer_asset_schedule_installment_per_price"><?= $Grid->renderFieldHeader($Grid->installment_per_price) ?></div></th>
<?php } ?>
<?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Grid->pay_number->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_pay_number" class="buyer_asset_schedule_pay_number"><?= $Grid->renderFieldHeader($Grid->pay_number) ?></div></th>
<?php } ?>
<?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Grid->expired_date->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_expired_date" class="buyer_asset_schedule_expired_date"><?= $Grid->renderFieldHeader($Grid->expired_date) ?></div></th>
<?php } ?>
<?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Grid->date_payment->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_date_payment" class="buyer_asset_schedule_date_payment"><?= $Grid->renderFieldHeader($Grid->date_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Grid->status_payment->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_status_payment" class="buyer_asset_schedule_status_payment"><?= $Grid->renderFieldHeader($Grid->status_payment) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_cdate" class="buyer_asset_schedule_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_buyer_asset_schedule",
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
    <?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment"<?= $Grid->num_installment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="buyer_asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_installment" id="o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="buyer_asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<span<?= $Grid->num_installment->viewAttributes() ?>>
<?= $Grid->num_installment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_num_installment" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_num_installment" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price"<?= $Grid->installment_per_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<input type="<?= $Grid->installment_per_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" data-table="buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Grid->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_per_price->getPlaceHolder()) ?>"<?= $Grid->installment_per_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_per_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_per_price" id="o<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<input type="<?= $Grid->installment_per_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" data-table="buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Grid->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_per_price->getPlaceHolder()) ?>"<?= $Grid->installment_per_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_per_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<span<?= $Grid->installment_per_price->viewAttributes() ?>>
<?= $Grid->installment_per_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_installment_per_price" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_installment_per_price" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Grid->pay_number->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_asset_schedule" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_asset_schedule" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<?= $Grid->pay_number->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_pay_number" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_pay_number" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Grid->expired_date->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="buyer_asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="buyer_asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<?= $Grid->expired_date->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_expired_date" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_expired_date" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Grid->date_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<?= $Grid->date_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_date_payment" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_date_payment" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Grid->status_payment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<?= $Grid->status_payment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_status_payment" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_status_payment" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_asset_schedule_cdate" class="el_buyer_asset_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" id="fbuyer_asset_schedulegrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" id="fbuyer_asset_schedulegrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fbuyer_asset_schedulegrid","load"], () => fbuyer_asset_schedulegrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_buyer_asset_schedule", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<input type="<?= $Grid->num_installment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" data-table="buyer_asset_schedule" data-field="x_num_installment" value="<?= $Grid->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->num_installment->getPlaceHolder()) ?>"<?= $Grid->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->num_installment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<span<?= $Grid->num_installment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->num_installment->getDisplayValue($Grid->num_installment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_num_installment" id="x<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_num_installment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_num_installment" id="o<?= $Grid->RowIndex ?>_num_installment" value="<?= HtmlEncode($Grid->num_installment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<input type="<?= $Grid->installment_per_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" data-table="buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Grid->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->installment_per_price->getPlaceHolder()) ?>"<?= $Grid->installment_per_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->installment_per_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<span<?= $Grid->installment_per_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->installment_per_price->getDisplayValue($Grid->installment_per_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_installment_per_price" id="x<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_installment_per_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_installment_per_price" id="o<?= $Grid->RowIndex ?>_installment_per_price" value="<?= HtmlEncode($Grid->installment_per_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<input type="<?= $Grid->pay_number->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" data-table="buyer_asset_schedule" data-field="x_pay_number" value="<?= $Grid->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->pay_number->getPlaceHolder()) ?>"<?= $Grid->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pay_number->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<span<?= $Grid->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pay_number->getDisplayValue($Grid->pay_number->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pay_number" id="x<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pay_number" id="o<?= $Grid->RowIndex ?>_pay_number" value="<?= HtmlEncode($Grid->pay_number->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<input type="<?= $Grid->expired_date->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" data-table="buyer_asset_schedule" data-field="x_expired_date" value="<?= $Grid->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Grid->expired_date->getPlaceHolder()) ?>"<?= $Grid->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->expired_date->getErrorMessage() ?></div>
<?php if (!$Grid->expired_date->ReadOnly && !$Grid->expired_date->Disabled && !isset($Grid->expired_date->EditAttrs["readonly"]) && !isset($Grid->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<span<?= $Grid->expired_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->expired_date->getDisplayValue($Grid->expired_date->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="x<?= $Grid->RowIndex ?>_expired_date" id="x<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_expired_date" data-hidden="1" name="o<?= $Grid->RowIndex ?>_expired_date" id="o<?= $Grid->RowIndex ?>_expired_date" value="<?= HtmlEncode($Grid->expired_date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<input type="<?= $Grid->date_payment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" data-table="buyer_asset_schedule" data-field="x_date_payment" value="<?= $Grid->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Grid->date_payment->getPlaceHolder()) ?>"<?= $Grid->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->date_payment->getErrorMessage() ?></div>
<?php if (!$Grid->date_payment->ReadOnly && !$Grid->date_payment->Disabled && !isset($Grid->date_payment->EditAttrs["readonly"]) && !isset($Grid->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulegrid", "x<?= $Grid->RowIndex ?>_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<span<?= $Grid->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->date_payment->getDisplayValue($Grid->date_payment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_date_payment" id="x<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_date_payment" id="o<?= $Grid->RowIndex ?>_date_payment" value="<?= HtmlEncode($Grid->date_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
    <select
        id="x<?= $Grid->RowIndex ?>_status_payment"
        name="x<?= $Grid->RowIndex ?>_status_payment"
        class="form-select ew-select<?= $Grid->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment"
        data-table="buyer_asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Grid->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_payment->getPlaceHolder()) ?>"
        <?= $Grid->status_payment->editAttributes() ?>>
        <?= $Grid->status_payment->selectOptionListHtml("x{$Grid->RowIndex}_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_schedulegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_payment", selectId: "fbuyer_asset_schedulegrid_x<?= $Grid->RowIndex ?>_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_schedulegrid.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_schedulegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_payment", form: "fbuyer_asset_schedulegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
<span<?= $Grid->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_payment->getDisplayValue($Grid->status_payment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_payment" id="x<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_payment" id="o<?= $Grid->RowIndex ?>_status_payment" value="<?= HtmlEncode($Grid->status_payment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_buyer_asset_schedule_cdate" class="el_buyer_asset_schedule_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_asset_schedule" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fbuyer_asset_schedulegrid","load"], () => fbuyer_asset_schedulegrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fbuyer_asset_schedulegrid">
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
    ew.addEventHandlers("buyer_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
