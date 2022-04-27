<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("InvestorVerifyGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var finvestor_verifygrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvestor_verifygrid = new ew.Form("finvestor_verifygrid", "grid");
    finvestor_verifygrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { investor_verify: currentTable } });
    var fields = currentTable.fields;
    finvestor_verifygrid.addFields([
        ["investment", [fields.investment.visible && fields.investment.required ? ew.Validators.required(fields.investment.caption) : null, ew.Validators.float], fields.investment.isInvalid],
        ["credit_limit", [fields.credit_limit.visible && fields.credit_limit.required ? ew.Validators.required(fields.credit_limit.caption) : null, ew.Validators.float], fields.credit_limit.isInvalid],
        ["monthly_payments", [fields.monthly_payments.visible && fields.monthly_payments.required ? ew.Validators.required(fields.monthly_payments.caption) : null, ew.Validators.float], fields.monthly_payments.isInvalid],
        ["highest_rental_price", [fields.highest_rental_price.visible && fields.highest_rental_price.required ? ew.Validators.required(fields.highest_rental_price.caption) : null, ew.Validators.float], fields.highest_rental_price.isInvalid],
        ["transfer", [fields.transfer.visible && fields.transfer.required ? ew.Validators.required(fields.transfer.caption) : null], fields.transfer.isInvalid],
        ["total_invertor_year", [fields.total_invertor_year.visible && fields.total_invertor_year.required ? ew.Validators.required(fields.total_invertor_year.caption) : null, ew.Validators.float], fields.total_invertor_year.isInvalid],
        ["invert_payoff_day", [fields.invert_payoff_day.visible && fields.invert_payoff_day.required ? ew.Validators.required(fields.invert_payoff_day.caption) : null, ew.Validators.float], fields.invert_payoff_day.isInvalid],
        ["type_invertor", [fields.type_invertor.visible && fields.type_invertor.required ? ew.Validators.required(fields.type_invertor.caption) : null], fields.type_invertor.isInvalid],
        ["invest_amount", [fields.invest_amount.visible && fields.invest_amount.required ? ew.Validators.required(fields.invest_amount.caption) : null, ew.Validators.float], fields.invest_amount.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    finvestor_verifygrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["investment",false],["credit_limit",false],["monthly_payments",false],["highest_rental_price",false],["transfer",false],["total_invertor_year",false],["invert_payoff_day",false],["type_invertor",false],["invest_amount",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    finvestor_verifygrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvestor_verifygrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    finvestor_verifygrid.lists.transfer = <?= $Grid->transfer->toClientList($Grid) ?>;
    finvestor_verifygrid.lists.type_invertor = <?= $Grid->type_invertor->toClientList($Grid) ?>;
    loadjs.done("finvestor_verifygrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> investor_verify">
<div id="finvestor_verifygrid" class="ew-form ew-list-form">
<div id="gmp_investor_verify" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_investor_verifygrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->investment->Visible) { // investment ?>
        <th data-name="investment" class="<?= $Grid->investment->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_investment" class="investor_verify_investment"><?= $Grid->renderFieldHeader($Grid->investment) ?></div></th>
<?php } ?>
<?php if ($Grid->credit_limit->Visible) { // credit_limit ?>
        <th data-name="credit_limit" class="<?= $Grid->credit_limit->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_credit_limit" class="investor_verify_credit_limit"><?= $Grid->renderFieldHeader($Grid->credit_limit) ?></div></th>
<?php } ?>
<?php if ($Grid->monthly_payments->Visible) { // monthly_payments ?>
        <th data-name="monthly_payments" class="<?= $Grid->monthly_payments->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_monthly_payments" class="investor_verify_monthly_payments"><?= $Grid->renderFieldHeader($Grid->monthly_payments) ?></div></th>
<?php } ?>
<?php if ($Grid->highest_rental_price->Visible) { // highest_rental_price ?>
        <th data-name="highest_rental_price" class="<?= $Grid->highest_rental_price->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_highest_rental_price" class="investor_verify_highest_rental_price"><?= $Grid->renderFieldHeader($Grid->highest_rental_price) ?></div></th>
<?php } ?>
<?php if ($Grid->transfer->Visible) { // transfer ?>
        <th data-name="transfer" class="<?= $Grid->transfer->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_transfer" class="investor_verify_transfer"><?= $Grid->renderFieldHeader($Grid->transfer) ?></div></th>
<?php } ?>
<?php if ($Grid->total_invertor_year->Visible) { // total_invertor_year ?>
        <th data-name="total_invertor_year" class="<?= $Grid->total_invertor_year->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_total_invertor_year" class="investor_verify_total_invertor_year"><?= $Grid->renderFieldHeader($Grid->total_invertor_year) ?></div></th>
<?php } ?>
<?php if ($Grid->invert_payoff_day->Visible) { // invert_payoff_day ?>
        <th data-name="invert_payoff_day" class="<?= $Grid->invert_payoff_day->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_invert_payoff_day" class="investor_verify_invert_payoff_day"><?= $Grid->renderFieldHeader($Grid->invert_payoff_day) ?></div></th>
<?php } ?>
<?php if ($Grid->type_invertor->Visible) { // type_invertor ?>
        <th data-name="type_invertor" class="<?= $Grid->type_invertor->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_type_invertor" class="investor_verify_type_invertor"><?= $Grid->renderFieldHeader($Grid->type_invertor) ?></div></th>
<?php } ?>
<?php if ($Grid->invest_amount->Visible) { // invest_amount ?>
        <th data-name="invest_amount" class="<?= $Grid->invest_amount->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_investor_verify_invest_amount" class="investor_verify_invest_amount"><?= $Grid->renderFieldHeader($Grid->invest_amount) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_investor_verify_cdate" class="investor_verify_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_investor_verify",
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
    <?php if ($Grid->investment->Visible) { // investment ?>
        <td data-name="investment"<?= $Grid->investment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_investment" class="el_investor_verify_investment">
<input type="<?= $Grid->investment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investment" id="x<?= $Grid->RowIndex ?>_investment" data-table="investor_verify" data-field="x_investment" value="<?= $Grid->investment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->investment->getPlaceHolder()) ?>"<?= $Grid->investment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_investment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_investment" id="o<?= $Grid->RowIndex ?>_investment" value="<?= HtmlEncode($Grid->investment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_investment" class="el_investor_verify_investment">
<input type="<?= $Grid->investment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investment" id="x<?= $Grid->RowIndex ?>_investment" data-table="investor_verify" data-field="x_investment" value="<?= $Grid->investment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->investment->getPlaceHolder()) ?>"<?= $Grid->investment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_investment" class="el_investor_verify_investment">
<span<?= $Grid->investment->viewAttributes() ?>>
<?= $Grid->investment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_investment" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_investment" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_investment" value="<?= HtmlEncode($Grid->investment->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_investment" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_investment" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_investment" value="<?= HtmlEncode($Grid->investment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->credit_limit->Visible) { // credit_limit ?>
        <td data-name="credit_limit"<?= $Grid->credit_limit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_credit_limit" class="el_investor_verify_credit_limit">
<input type="<?= $Grid->credit_limit->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_credit_limit" id="x<?= $Grid->RowIndex ?>_credit_limit" data-table="investor_verify" data-field="x_credit_limit" value="<?= $Grid->credit_limit->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->credit_limit->getPlaceHolder()) ?>"<?= $Grid->credit_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->credit_limit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_credit_limit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_credit_limit" id="o<?= $Grid->RowIndex ?>_credit_limit" value="<?= HtmlEncode($Grid->credit_limit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_credit_limit" class="el_investor_verify_credit_limit">
<input type="<?= $Grid->credit_limit->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_credit_limit" id="x<?= $Grid->RowIndex ?>_credit_limit" data-table="investor_verify" data-field="x_credit_limit" value="<?= $Grid->credit_limit->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->credit_limit->getPlaceHolder()) ?>"<?= $Grid->credit_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->credit_limit->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_credit_limit" class="el_investor_verify_credit_limit">
<span<?= $Grid->credit_limit->viewAttributes() ?>>
<?= $Grid->credit_limit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_credit_limit" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_credit_limit" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_credit_limit" value="<?= HtmlEncode($Grid->credit_limit->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_credit_limit" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_credit_limit" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_credit_limit" value="<?= HtmlEncode($Grid->credit_limit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->monthly_payments->Visible) { // monthly_payments ?>
        <td data-name="monthly_payments"<?= $Grid->monthly_payments->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_monthly_payments" class="el_investor_verify_monthly_payments">
<input type="<?= $Grid->monthly_payments->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monthly_payments" id="x<?= $Grid->RowIndex ?>_monthly_payments" data-table="investor_verify" data-field="x_monthly_payments" value="<?= $Grid->monthly_payments->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monthly_payments->getPlaceHolder()) ?>"<?= $Grid->monthly_payments->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monthly_payments->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_monthly_payments" data-hidden="1" name="o<?= $Grid->RowIndex ?>_monthly_payments" id="o<?= $Grid->RowIndex ?>_monthly_payments" value="<?= HtmlEncode($Grid->monthly_payments->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_monthly_payments" class="el_investor_verify_monthly_payments">
<input type="<?= $Grid->monthly_payments->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monthly_payments" id="x<?= $Grid->RowIndex ?>_monthly_payments" data-table="investor_verify" data-field="x_monthly_payments" value="<?= $Grid->monthly_payments->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monthly_payments->getPlaceHolder()) ?>"<?= $Grid->monthly_payments->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monthly_payments->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_monthly_payments" class="el_investor_verify_monthly_payments">
<span<?= $Grid->monthly_payments->viewAttributes() ?>>
<?= $Grid->monthly_payments->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_monthly_payments" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_monthly_payments" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_monthly_payments" value="<?= HtmlEncode($Grid->monthly_payments->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_monthly_payments" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_monthly_payments" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_monthly_payments" value="<?= HtmlEncode($Grid->monthly_payments->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->highest_rental_price->Visible) { // highest_rental_price ?>
        <td data-name="highest_rental_price"<?= $Grid->highest_rental_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_highest_rental_price" class="el_investor_verify_highest_rental_price">
<input type="<?= $Grid->highest_rental_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_highest_rental_price" id="x<?= $Grid->RowIndex ?>_highest_rental_price" data-table="investor_verify" data-field="x_highest_rental_price" value="<?= $Grid->highest_rental_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->highest_rental_price->getPlaceHolder()) ?>"<?= $Grid->highest_rental_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->highest_rental_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_highest_rental_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_highest_rental_price" id="o<?= $Grid->RowIndex ?>_highest_rental_price" value="<?= HtmlEncode($Grid->highest_rental_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_highest_rental_price" class="el_investor_verify_highest_rental_price">
<input type="<?= $Grid->highest_rental_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_highest_rental_price" id="x<?= $Grid->RowIndex ?>_highest_rental_price" data-table="investor_verify" data-field="x_highest_rental_price" value="<?= $Grid->highest_rental_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->highest_rental_price->getPlaceHolder()) ?>"<?= $Grid->highest_rental_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->highest_rental_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_highest_rental_price" class="el_investor_verify_highest_rental_price">
<span<?= $Grid->highest_rental_price->viewAttributes() ?>>
<?= $Grid->highest_rental_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_highest_rental_price" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_highest_rental_price" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_highest_rental_price" value="<?= HtmlEncode($Grid->highest_rental_price->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_highest_rental_price" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_highest_rental_price" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_highest_rental_price" value="<?= HtmlEncode($Grid->highest_rental_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->transfer->Visible) { // transfer ?>
        <td data-name="transfer"<?= $Grid->transfer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_transfer" class="el_investor_verify_transfer">
<template id="tp_x<?= $Grid->RowIndex ?>_transfer">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="investor_verify" data-field="x_transfer" name="x<?= $Grid->RowIndex ?>_transfer" id="x<?= $Grid->RowIndex ?>_transfer"<?= $Grid->transfer->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_transfer" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_transfer"
    name="x<?= $Grid->RowIndex ?>_transfer"
    value="<?= HtmlEncode($Grid->transfer->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_transfer"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_transfer"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->transfer->isInvalidClass() ?>"
    data-table="investor_verify"
    data-field="x_transfer"
    data-value-separator="<?= $Grid->transfer->displayValueSeparatorAttribute() ?>"
    <?= $Grid->transfer->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->transfer->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_transfer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_transfer" id="o<?= $Grid->RowIndex ?>_transfer" value="<?= HtmlEncode($Grid->transfer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_transfer" class="el_investor_verify_transfer">
<template id="tp_x<?= $Grid->RowIndex ?>_transfer">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="investor_verify" data-field="x_transfer" name="x<?= $Grid->RowIndex ?>_transfer" id="x<?= $Grid->RowIndex ?>_transfer"<?= $Grid->transfer->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_transfer" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_transfer"
    name="x<?= $Grid->RowIndex ?>_transfer"
    value="<?= HtmlEncode($Grid->transfer->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_transfer"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_transfer"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->transfer->isInvalidClass() ?>"
    data-table="investor_verify"
    data-field="x_transfer"
    data-value-separator="<?= $Grid->transfer->displayValueSeparatorAttribute() ?>"
    <?= $Grid->transfer->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->transfer->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_transfer" class="el_investor_verify_transfer">
<span<?= $Grid->transfer->viewAttributes() ?>>
<?= $Grid->transfer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_transfer" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_transfer" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_transfer" value="<?= HtmlEncode($Grid->transfer->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_transfer" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_transfer" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_transfer" value="<?= HtmlEncode($Grid->transfer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->total_invertor_year->Visible) { // total_invertor_year ?>
        <td data-name="total_invertor_year"<?= $Grid->total_invertor_year->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_total_invertor_year" class="el_investor_verify_total_invertor_year">
<input type="<?= $Grid->total_invertor_year->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total_invertor_year" id="x<?= $Grid->RowIndex ?>_total_invertor_year" data-table="investor_verify" data-field="x_total_invertor_year" value="<?= $Grid->total_invertor_year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->total_invertor_year->getPlaceHolder()) ?>"<?= $Grid->total_invertor_year->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total_invertor_year->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_total_invertor_year" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total_invertor_year" id="o<?= $Grid->RowIndex ?>_total_invertor_year" value="<?= HtmlEncode($Grid->total_invertor_year->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_total_invertor_year" class="el_investor_verify_total_invertor_year">
<input type="<?= $Grid->total_invertor_year->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total_invertor_year" id="x<?= $Grid->RowIndex ?>_total_invertor_year" data-table="investor_verify" data-field="x_total_invertor_year" value="<?= $Grid->total_invertor_year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->total_invertor_year->getPlaceHolder()) ?>"<?= $Grid->total_invertor_year->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total_invertor_year->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_total_invertor_year" class="el_investor_verify_total_invertor_year">
<span<?= $Grid->total_invertor_year->viewAttributes() ?>>
<?= $Grid->total_invertor_year->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_total_invertor_year" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_total_invertor_year" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_total_invertor_year" value="<?= HtmlEncode($Grid->total_invertor_year->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_total_invertor_year" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_total_invertor_year" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_total_invertor_year" value="<?= HtmlEncode($Grid->total_invertor_year->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->invert_payoff_day->Visible) { // invert_payoff_day ?>
        <td data-name="invert_payoff_day"<?= $Grid->invert_payoff_day->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_invert_payoff_day" class="el_investor_verify_invert_payoff_day">
<input type="<?= $Grid->invert_payoff_day->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_invert_payoff_day" id="x<?= $Grid->RowIndex ?>_invert_payoff_day" data-table="investor_verify" data-field="x_invert_payoff_day" value="<?= $Grid->invert_payoff_day->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->invert_payoff_day->getPlaceHolder()) ?>"<?= $Grid->invert_payoff_day->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->invert_payoff_day->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_invert_payoff_day" data-hidden="1" name="o<?= $Grid->RowIndex ?>_invert_payoff_day" id="o<?= $Grid->RowIndex ?>_invert_payoff_day" value="<?= HtmlEncode($Grid->invert_payoff_day->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_invert_payoff_day" class="el_investor_verify_invert_payoff_day">
<input type="<?= $Grid->invert_payoff_day->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_invert_payoff_day" id="x<?= $Grid->RowIndex ?>_invert_payoff_day" data-table="investor_verify" data-field="x_invert_payoff_day" value="<?= $Grid->invert_payoff_day->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->invert_payoff_day->getPlaceHolder()) ?>"<?= $Grid->invert_payoff_day->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->invert_payoff_day->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_invert_payoff_day" class="el_investor_verify_invert_payoff_day">
<span<?= $Grid->invert_payoff_day->viewAttributes() ?>>
<?= $Grid->invert_payoff_day->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_invert_payoff_day" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_invert_payoff_day" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_invert_payoff_day" value="<?= HtmlEncode($Grid->invert_payoff_day->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_invert_payoff_day" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_invert_payoff_day" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_invert_payoff_day" value="<?= HtmlEncode($Grid->invert_payoff_day->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->type_invertor->Visible) { // type_invertor ?>
        <td data-name="type_invertor"<?= $Grid->type_invertor->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_type_invertor" class="el_investor_verify_type_invertor">
    <select
        id="x<?= $Grid->RowIndex ?>_type_invertor"
        name="x<?= $Grid->RowIndex ?>_type_invertor"
        class="form-select ew-select<?= $Grid->type_invertor->isInvalidClass() ?>"
        data-select2-id="finvestor_verifygrid_x<?= $Grid->RowIndex ?>_type_invertor"
        data-table="investor_verify"
        data-field="x_type_invertor"
        data-value-separator="<?= $Grid->type_invertor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->type_invertor->getPlaceHolder()) ?>"
        <?= $Grid->type_invertor->editAttributes() ?>>
        <?= $Grid->type_invertor->selectOptionListHtml("x{$Grid->RowIndex}_type_invertor") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->type_invertor->getErrorMessage() ?></div>
<script>
loadjs.ready("finvestor_verifygrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_type_invertor", selectId: "finvestor_verifygrid_x<?= $Grid->RowIndex ?>_type_invertor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finvestor_verifygrid.lists.type_invertor.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_type_invertor", form: "finvestor_verifygrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_type_invertor", form: "finvestor_verifygrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.investor_verify.fields.type_invertor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_type_invertor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_type_invertor" id="o<?= $Grid->RowIndex ?>_type_invertor" value="<?= HtmlEncode($Grid->type_invertor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_type_invertor" class="el_investor_verify_type_invertor">
    <select
        id="x<?= $Grid->RowIndex ?>_type_invertor"
        name="x<?= $Grid->RowIndex ?>_type_invertor"
        class="form-select ew-select<?= $Grid->type_invertor->isInvalidClass() ?>"
        data-select2-id="finvestor_verifygrid_x<?= $Grid->RowIndex ?>_type_invertor"
        data-table="investor_verify"
        data-field="x_type_invertor"
        data-value-separator="<?= $Grid->type_invertor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->type_invertor->getPlaceHolder()) ?>"
        <?= $Grid->type_invertor->editAttributes() ?>>
        <?= $Grid->type_invertor->selectOptionListHtml("x{$Grid->RowIndex}_type_invertor") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->type_invertor->getErrorMessage() ?></div>
<script>
loadjs.ready("finvestor_verifygrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_type_invertor", selectId: "finvestor_verifygrid_x<?= $Grid->RowIndex ?>_type_invertor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finvestor_verifygrid.lists.type_invertor.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_type_invertor", form: "finvestor_verifygrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_type_invertor", form: "finvestor_verifygrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.investor_verify.fields.type_invertor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_type_invertor" class="el_investor_verify_type_invertor">
<span<?= $Grid->type_invertor->viewAttributes() ?>>
<?= $Grid->type_invertor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_type_invertor" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_type_invertor" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_type_invertor" value="<?= HtmlEncode($Grid->type_invertor->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_type_invertor" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_type_invertor" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_type_invertor" value="<?= HtmlEncode($Grid->type_invertor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->invest_amount->Visible) { // invest_amount ?>
        <td data-name="invest_amount"<?= $Grid->invest_amount->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_invest_amount" class="el_investor_verify_invest_amount">
<input type="<?= $Grid->invest_amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_invest_amount" id="x<?= $Grid->RowIndex ?>_invest_amount" data-table="investor_verify" data-field="x_invest_amount" value="<?= $Grid->invest_amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->invest_amount->getPlaceHolder()) ?>"<?= $Grid->invest_amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->invest_amount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_invest_amount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_invest_amount" id="o<?= $Grid->RowIndex ?>_invest_amount" value="<?= HtmlEncode($Grid->invest_amount->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_invest_amount" class="el_investor_verify_invest_amount">
<input type="<?= $Grid->invest_amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_invest_amount" id="x<?= $Grid->RowIndex ?>_invest_amount" data-table="investor_verify" data-field="x_invest_amount" value="<?= $Grid->invest_amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->invest_amount->getPlaceHolder()) ?>"<?= $Grid->invest_amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->invest_amount->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_invest_amount" class="el_investor_verify_invest_amount">
<span<?= $Grid->invest_amount->viewAttributes() ?>>
<?= $Grid->invest_amount->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_invest_amount" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_invest_amount" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_invest_amount" value="<?= HtmlEncode($Grid->invest_amount->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_invest_amount" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_invest_amount" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_invest_amount" value="<?= HtmlEncode($Grid->invest_amount->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="investor_verify" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_investor_verify_cdate" class="el_investor_verify_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="investor_verify" data-field="x_cdate" data-hidden="1" name="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_cdate" id="finvestor_verifygrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="investor_verify" data-field="x_cdate" data-hidden="1" name="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_cdate" id="finvestor_verifygrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["finvestor_verifygrid","load"], () => finvestor_verifygrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_investor_verify", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->investment->Visible) { // investment ?>
        <td data-name="investment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_investment" class="el_investor_verify_investment">
<input type="<?= $Grid->investment->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_investment" id="x<?= $Grid->RowIndex ?>_investment" data-table="investor_verify" data-field="x_investment" value="<?= $Grid->investment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->investment->getPlaceHolder()) ?>"<?= $Grid->investment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->investment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_investment" class="el_investor_verify_investment">
<span<?= $Grid->investment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->investment->getDisplayValue($Grid->investment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_investment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_investment" id="x<?= $Grid->RowIndex ?>_investment" value="<?= HtmlEncode($Grid->investment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_investment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_investment" id="o<?= $Grid->RowIndex ?>_investment" value="<?= HtmlEncode($Grid->investment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->credit_limit->Visible) { // credit_limit ?>
        <td data-name="credit_limit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_credit_limit" class="el_investor_verify_credit_limit">
<input type="<?= $Grid->credit_limit->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_credit_limit" id="x<?= $Grid->RowIndex ?>_credit_limit" data-table="investor_verify" data-field="x_credit_limit" value="<?= $Grid->credit_limit->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->credit_limit->getPlaceHolder()) ?>"<?= $Grid->credit_limit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->credit_limit->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_credit_limit" class="el_investor_verify_credit_limit">
<span<?= $Grid->credit_limit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->credit_limit->getDisplayValue($Grid->credit_limit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_credit_limit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_credit_limit" id="x<?= $Grid->RowIndex ?>_credit_limit" value="<?= HtmlEncode($Grid->credit_limit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_credit_limit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_credit_limit" id="o<?= $Grid->RowIndex ?>_credit_limit" value="<?= HtmlEncode($Grid->credit_limit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->monthly_payments->Visible) { // monthly_payments ?>
        <td data-name="monthly_payments">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_monthly_payments" class="el_investor_verify_monthly_payments">
<input type="<?= $Grid->monthly_payments->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monthly_payments" id="x<?= $Grid->RowIndex ?>_monthly_payments" data-table="investor_verify" data-field="x_monthly_payments" value="<?= $Grid->monthly_payments->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monthly_payments->getPlaceHolder()) ?>"<?= $Grid->monthly_payments->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monthly_payments->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_monthly_payments" class="el_investor_verify_monthly_payments">
<span<?= $Grid->monthly_payments->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->monthly_payments->getDisplayValue($Grid->monthly_payments->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_monthly_payments" data-hidden="1" name="x<?= $Grid->RowIndex ?>_monthly_payments" id="x<?= $Grid->RowIndex ?>_monthly_payments" value="<?= HtmlEncode($Grid->monthly_payments->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_monthly_payments" data-hidden="1" name="o<?= $Grid->RowIndex ?>_monthly_payments" id="o<?= $Grid->RowIndex ?>_monthly_payments" value="<?= HtmlEncode($Grid->monthly_payments->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->highest_rental_price->Visible) { // highest_rental_price ?>
        <td data-name="highest_rental_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_highest_rental_price" class="el_investor_verify_highest_rental_price">
<input type="<?= $Grid->highest_rental_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_highest_rental_price" id="x<?= $Grid->RowIndex ?>_highest_rental_price" data-table="investor_verify" data-field="x_highest_rental_price" value="<?= $Grid->highest_rental_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->highest_rental_price->getPlaceHolder()) ?>"<?= $Grid->highest_rental_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->highest_rental_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_highest_rental_price" class="el_investor_verify_highest_rental_price">
<span<?= $Grid->highest_rental_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->highest_rental_price->getDisplayValue($Grid->highest_rental_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_highest_rental_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_highest_rental_price" id="x<?= $Grid->RowIndex ?>_highest_rental_price" value="<?= HtmlEncode($Grid->highest_rental_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_highest_rental_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_highest_rental_price" id="o<?= $Grid->RowIndex ?>_highest_rental_price" value="<?= HtmlEncode($Grid->highest_rental_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->transfer->Visible) { // transfer ?>
        <td data-name="transfer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_transfer" class="el_investor_verify_transfer">
<template id="tp_x<?= $Grid->RowIndex ?>_transfer">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="investor_verify" data-field="x_transfer" name="x<?= $Grid->RowIndex ?>_transfer" id="x<?= $Grid->RowIndex ?>_transfer"<?= $Grid->transfer->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_transfer" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_transfer"
    name="x<?= $Grid->RowIndex ?>_transfer"
    value="<?= HtmlEncode($Grid->transfer->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_transfer"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_transfer"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->transfer->isInvalidClass() ?>"
    data-table="investor_verify"
    data-field="x_transfer"
    data-value-separator="<?= $Grid->transfer->displayValueSeparatorAttribute() ?>"
    <?= $Grid->transfer->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->transfer->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_transfer" class="el_investor_verify_transfer">
<span<?= $Grid->transfer->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->transfer->getDisplayValue($Grid->transfer->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_transfer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_transfer" id="x<?= $Grid->RowIndex ?>_transfer" value="<?= HtmlEncode($Grid->transfer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_transfer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_transfer" id="o<?= $Grid->RowIndex ?>_transfer" value="<?= HtmlEncode($Grid->transfer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->total_invertor_year->Visible) { // total_invertor_year ?>
        <td data-name="total_invertor_year">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_total_invertor_year" class="el_investor_verify_total_invertor_year">
<input type="<?= $Grid->total_invertor_year->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total_invertor_year" id="x<?= $Grid->RowIndex ?>_total_invertor_year" data-table="investor_verify" data-field="x_total_invertor_year" value="<?= $Grid->total_invertor_year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->total_invertor_year->getPlaceHolder()) ?>"<?= $Grid->total_invertor_year->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total_invertor_year->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_total_invertor_year" class="el_investor_verify_total_invertor_year">
<span<?= $Grid->total_invertor_year->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->total_invertor_year->getDisplayValue($Grid->total_invertor_year->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_total_invertor_year" data-hidden="1" name="x<?= $Grid->RowIndex ?>_total_invertor_year" id="x<?= $Grid->RowIndex ?>_total_invertor_year" value="<?= HtmlEncode($Grid->total_invertor_year->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_total_invertor_year" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total_invertor_year" id="o<?= $Grid->RowIndex ?>_total_invertor_year" value="<?= HtmlEncode($Grid->total_invertor_year->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->invert_payoff_day->Visible) { // invert_payoff_day ?>
        <td data-name="invert_payoff_day">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_invert_payoff_day" class="el_investor_verify_invert_payoff_day">
<input type="<?= $Grid->invert_payoff_day->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_invert_payoff_day" id="x<?= $Grid->RowIndex ?>_invert_payoff_day" data-table="investor_verify" data-field="x_invert_payoff_day" value="<?= $Grid->invert_payoff_day->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->invert_payoff_day->getPlaceHolder()) ?>"<?= $Grid->invert_payoff_day->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->invert_payoff_day->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_invert_payoff_day" class="el_investor_verify_invert_payoff_day">
<span<?= $Grid->invert_payoff_day->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->invert_payoff_day->getDisplayValue($Grid->invert_payoff_day->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_invert_payoff_day" data-hidden="1" name="x<?= $Grid->RowIndex ?>_invert_payoff_day" id="x<?= $Grid->RowIndex ?>_invert_payoff_day" value="<?= HtmlEncode($Grid->invert_payoff_day->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_invert_payoff_day" data-hidden="1" name="o<?= $Grid->RowIndex ?>_invert_payoff_day" id="o<?= $Grid->RowIndex ?>_invert_payoff_day" value="<?= HtmlEncode($Grid->invert_payoff_day->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->type_invertor->Visible) { // type_invertor ?>
        <td data-name="type_invertor">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_type_invertor" class="el_investor_verify_type_invertor">
    <select
        id="x<?= $Grid->RowIndex ?>_type_invertor"
        name="x<?= $Grid->RowIndex ?>_type_invertor"
        class="form-select ew-select<?= $Grid->type_invertor->isInvalidClass() ?>"
        data-select2-id="finvestor_verifygrid_x<?= $Grid->RowIndex ?>_type_invertor"
        data-table="investor_verify"
        data-field="x_type_invertor"
        data-value-separator="<?= $Grid->type_invertor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->type_invertor->getPlaceHolder()) ?>"
        <?= $Grid->type_invertor->editAttributes() ?>>
        <?= $Grid->type_invertor->selectOptionListHtml("x{$Grid->RowIndex}_type_invertor") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->type_invertor->getErrorMessage() ?></div>
<script>
loadjs.ready("finvestor_verifygrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_type_invertor", selectId: "finvestor_verifygrid_x<?= $Grid->RowIndex ?>_type_invertor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finvestor_verifygrid.lists.type_invertor.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_type_invertor", form: "finvestor_verifygrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_type_invertor", form: "finvestor_verifygrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.investor_verify.fields.type_invertor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_type_invertor" class="el_investor_verify_type_invertor">
<span<?= $Grid->type_invertor->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->type_invertor->getDisplayValue($Grid->type_invertor->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_type_invertor" data-hidden="1" name="x<?= $Grid->RowIndex ?>_type_invertor" id="x<?= $Grid->RowIndex ?>_type_invertor" value="<?= HtmlEncode($Grid->type_invertor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_type_invertor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_type_invertor" id="o<?= $Grid->RowIndex ?>_type_invertor" value="<?= HtmlEncode($Grid->type_invertor->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->invest_amount->Visible) { // invest_amount ?>
        <td data-name="invest_amount">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_investor_verify_invest_amount" class="el_investor_verify_invest_amount">
<input type="<?= $Grid->invest_amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_invest_amount" id="x<?= $Grid->RowIndex ?>_invest_amount" data-table="investor_verify" data-field="x_invest_amount" value="<?= $Grid->invest_amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->invest_amount->getPlaceHolder()) ?>"<?= $Grid->invest_amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->invest_amount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_invest_amount" class="el_investor_verify_invest_amount">
<span<?= $Grid->invest_amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->invest_amount->getDisplayValue($Grid->invest_amount->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_invest_amount" data-hidden="1" name="x<?= $Grid->RowIndex ?>_invest_amount" id="x<?= $Grid->RowIndex ?>_invest_amount" value="<?= HtmlEncode($Grid->invest_amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_invest_amount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_invest_amount" id="o<?= $Grid->RowIndex ?>_invest_amount" value="<?= HtmlEncode($Grid->invest_amount->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_investor_verify_cdate" class="el_investor_verify_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="investor_verify" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["finvestor_verifygrid","load"], () => finvestor_verifygrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="finvestor_verifygrid">
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
    ew.addEventHandlers("investor_verify");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
