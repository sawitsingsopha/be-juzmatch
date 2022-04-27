<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("JuzcalculatorGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fjuzcalculatorgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fjuzcalculatorgrid = new ew.Form("fjuzcalculatorgrid", "grid");
    fjuzcalculatorgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { juzcalculator: currentTable } });
    var fields = currentTable.fields;
    fjuzcalculatorgrid.addFields([
        ["income_all", [fields.income_all.visible && fields.income_all.required ? ew.Validators.required(fields.income_all.caption) : null, ew.Validators.float], fields.income_all.isInvalid],
        ["outcome_all", [fields.outcome_all.visible && fields.outcome_all.required ? ew.Validators.required(fields.outcome_all.caption) : null, ew.Validators.float], fields.outcome_all.isInvalid],
        ["rent_price", [fields.rent_price.visible && fields.rent_price.required ? ew.Validators.required(fields.rent_price.caption) : null, ew.Validators.float], fields.rent_price.isInvalid],
        ["asset_price", [fields.asset_price.visible && fields.asset_price.required ? ew.Validators.required(fields.asset_price.caption) : null, ew.Validators.float], fields.asset_price.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fjuzcalculatorgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["income_all",false],["outcome_all",false],["rent_price",false],["asset_price",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fjuzcalculatorgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fjuzcalculatorgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fjuzcalculatorgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> juzcalculator">
<div id="fjuzcalculatorgrid" class="ew-form ew-list-form">
<div id="gmp_juzcalculator" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_juzcalculatorgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->income_all->Visible) { // income_all ?>
        <th data-name="income_all" class="<?= $Grid->income_all->headerCellClass() ?>"><div id="elh_juzcalculator_income_all" class="juzcalculator_income_all"><?= $Grid->renderFieldHeader($Grid->income_all) ?></div></th>
<?php } ?>
<?php if ($Grid->outcome_all->Visible) { // outcome_all ?>
        <th data-name="outcome_all" class="<?= $Grid->outcome_all->headerCellClass() ?>"><div id="elh_juzcalculator_outcome_all" class="juzcalculator_outcome_all"><?= $Grid->renderFieldHeader($Grid->outcome_all) ?></div></th>
<?php } ?>
<?php if ($Grid->rent_price->Visible) { // rent_price ?>
        <th data-name="rent_price" class="<?= $Grid->rent_price->headerCellClass() ?>"><div id="elh_juzcalculator_rent_price" class="juzcalculator_rent_price"><?= $Grid->renderFieldHeader($Grid->rent_price) ?></div></th>
<?php } ?>
<?php if ($Grid->asset_price->Visible) { // asset_price ?>
        <th data-name="asset_price" class="<?= $Grid->asset_price->headerCellClass() ?>"><div id="elh_juzcalculator_asset_price" class="juzcalculator_asset_price"><?= $Grid->renderFieldHeader($Grid->asset_price) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_juzcalculator_cdate" class="juzcalculator_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_juzcalculator",
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
    <?php if ($Grid->income_all->Visible) { // income_all ?>
        <td data-name="income_all"<?= $Grid->income_all->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_all" class="el_juzcalculator_income_all">
<input type="<?= $Grid->income_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income_all" id="x<?= $Grid->RowIndex ?>_income_all" data-table="juzcalculator" data-field="x_income_all" value="<?= $Grid->income_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->income_all->getPlaceHolder()) ?>"<?= $Grid->income_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income_all->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_income_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_income_all" id="o<?= $Grid->RowIndex ?>_income_all" value="<?= HtmlEncode($Grid->income_all->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_all" class="el_juzcalculator_income_all">
<input type="<?= $Grid->income_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income_all" id="x<?= $Grid->RowIndex ?>_income_all" data-table="juzcalculator" data-field="x_income_all" value="<?= $Grid->income_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->income_all->getPlaceHolder()) ?>"<?= $Grid->income_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income_all->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_all" class="el_juzcalculator_income_all">
<span<?= $Grid->income_all->viewAttributes() ?>>
<?= $Grid->income_all->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator" data-field="x_income_all" data-hidden="1" name="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_income_all" id="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_income_all" value="<?= HtmlEncode($Grid->income_all->FormValue) ?>">
<input type="hidden" data-table="juzcalculator" data-field="x_income_all" data-hidden="1" name="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_income_all" id="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_income_all" value="<?= HtmlEncode($Grid->income_all->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->outcome_all->Visible) { // outcome_all ?>
        <td data-name="outcome_all"<?= $Grid->outcome_all->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_outcome_all" class="el_juzcalculator_outcome_all">
<input type="<?= $Grid->outcome_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_outcome_all" id="x<?= $Grid->RowIndex ?>_outcome_all" data-table="juzcalculator" data-field="x_outcome_all" value="<?= $Grid->outcome_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->outcome_all->getPlaceHolder()) ?>"<?= $Grid->outcome_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->outcome_all->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_outcome_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_outcome_all" id="o<?= $Grid->RowIndex ?>_outcome_all" value="<?= HtmlEncode($Grid->outcome_all->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_outcome_all" class="el_juzcalculator_outcome_all">
<input type="<?= $Grid->outcome_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_outcome_all" id="x<?= $Grid->RowIndex ?>_outcome_all" data-table="juzcalculator" data-field="x_outcome_all" value="<?= $Grid->outcome_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->outcome_all->getPlaceHolder()) ?>"<?= $Grid->outcome_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->outcome_all->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_outcome_all" class="el_juzcalculator_outcome_all">
<span<?= $Grid->outcome_all->viewAttributes() ?>>
<?= $Grid->outcome_all->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator" data-field="x_outcome_all" data-hidden="1" name="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_outcome_all" id="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_outcome_all" value="<?= HtmlEncode($Grid->outcome_all->FormValue) ?>">
<input type="hidden" data-table="juzcalculator" data-field="x_outcome_all" data-hidden="1" name="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_outcome_all" id="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_outcome_all" value="<?= HtmlEncode($Grid->outcome_all->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->rent_price->Visible) { // rent_price ?>
        <td data-name="rent_price"<?= $Grid->rent_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_rent_price" class="el_juzcalculator_rent_price">
<input type="<?= $Grid->rent_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rent_price" id="x<?= $Grid->RowIndex ?>_rent_price" data-table="juzcalculator" data-field="x_rent_price" value="<?= $Grid->rent_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->rent_price->getPlaceHolder()) ?>"<?= $Grid->rent_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rent_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_rent_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rent_price" id="o<?= $Grid->RowIndex ?>_rent_price" value="<?= HtmlEncode($Grid->rent_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_rent_price" class="el_juzcalculator_rent_price">
<input type="<?= $Grid->rent_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rent_price" id="x<?= $Grid->RowIndex ?>_rent_price" data-table="juzcalculator" data-field="x_rent_price" value="<?= $Grid->rent_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->rent_price->getPlaceHolder()) ?>"<?= $Grid->rent_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rent_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_rent_price" class="el_juzcalculator_rent_price">
<span<?= $Grid->rent_price->viewAttributes() ?>>
<?= $Grid->rent_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator" data-field="x_rent_price" data-hidden="1" name="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_rent_price" id="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_rent_price" value="<?= HtmlEncode($Grid->rent_price->FormValue) ?>">
<input type="hidden" data-table="juzcalculator" data-field="x_rent_price" data-hidden="1" name="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_rent_price" id="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_rent_price" value="<?= HtmlEncode($Grid->rent_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->asset_price->Visible) { // asset_price ?>
        <td data-name="asset_price"<?= $Grid->asset_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_asset_price" class="el_juzcalculator_asset_price">
<input type="<?= $Grid->asset_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_price" id="x<?= $Grid->RowIndex ?>_asset_price" data-table="juzcalculator" data-field="x_asset_price" value="<?= $Grid->asset_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->asset_price->getPlaceHolder()) ?>"<?= $Grid->asset_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_asset_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_price" id="o<?= $Grid->RowIndex ?>_asset_price" value="<?= HtmlEncode($Grid->asset_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_asset_price" class="el_juzcalculator_asset_price">
<input type="<?= $Grid->asset_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_price" id="x<?= $Grid->RowIndex ?>_asset_price" data-table="juzcalculator" data-field="x_asset_price" value="<?= $Grid->asset_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->asset_price->getPlaceHolder()) ?>"<?= $Grid->asset_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_asset_price" class="el_juzcalculator_asset_price">
<span<?= $Grid->asset_price->viewAttributes() ?>>
<?= $Grid->asset_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator" data-field="x_asset_price" data-hidden="1" name="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_asset_price" id="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_asset_price" value="<?= HtmlEncode($Grid->asset_price->FormValue) ?>">
<input type="hidden" data-table="juzcalculator" data-field="x_asset_price" data-hidden="1" name="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_asset_price" id="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_asset_price" value="<?= HtmlEncode($Grid->asset_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="juzcalculator" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_cdate" class="el_juzcalculator_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator" data-field="x_cdate" data-hidden="1" name="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_cdate" id="fjuzcalculatorgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="juzcalculator" data-field="x_cdate" data-hidden="1" name="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_cdate" id="fjuzcalculatorgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fjuzcalculatorgrid","load"], () => fjuzcalculatorgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_juzcalculator", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->income_all->Visible) { // income_all ?>
        <td data-name="income_all">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_juzcalculator_income_all" class="el_juzcalculator_income_all">
<input type="<?= $Grid->income_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income_all" id="x<?= $Grid->RowIndex ?>_income_all" data-table="juzcalculator" data-field="x_income_all" value="<?= $Grid->income_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->income_all->getPlaceHolder()) ?>"<?= $Grid->income_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income_all->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_income_all" class="el_juzcalculator_income_all">
<span<?= $Grid->income_all->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->income_all->getDisplayValue($Grid->income_all->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_income_all" data-hidden="1" name="x<?= $Grid->RowIndex ?>_income_all" id="x<?= $Grid->RowIndex ?>_income_all" value="<?= HtmlEncode($Grid->income_all->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator" data-field="x_income_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_income_all" id="o<?= $Grid->RowIndex ?>_income_all" value="<?= HtmlEncode($Grid->income_all->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->outcome_all->Visible) { // outcome_all ?>
        <td data-name="outcome_all">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_juzcalculator_outcome_all" class="el_juzcalculator_outcome_all">
<input type="<?= $Grid->outcome_all->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_outcome_all" id="x<?= $Grid->RowIndex ?>_outcome_all" data-table="juzcalculator" data-field="x_outcome_all" value="<?= $Grid->outcome_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->outcome_all->getPlaceHolder()) ?>"<?= $Grid->outcome_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->outcome_all->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_outcome_all" class="el_juzcalculator_outcome_all">
<span<?= $Grid->outcome_all->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->outcome_all->getDisplayValue($Grid->outcome_all->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_outcome_all" data-hidden="1" name="x<?= $Grid->RowIndex ?>_outcome_all" id="x<?= $Grid->RowIndex ?>_outcome_all" value="<?= HtmlEncode($Grid->outcome_all->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator" data-field="x_outcome_all" data-hidden="1" name="o<?= $Grid->RowIndex ?>_outcome_all" id="o<?= $Grid->RowIndex ?>_outcome_all" value="<?= HtmlEncode($Grid->outcome_all->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->rent_price->Visible) { // rent_price ?>
        <td data-name="rent_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_juzcalculator_rent_price" class="el_juzcalculator_rent_price">
<input type="<?= $Grid->rent_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rent_price" id="x<?= $Grid->RowIndex ?>_rent_price" data-table="juzcalculator" data-field="x_rent_price" value="<?= $Grid->rent_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->rent_price->getPlaceHolder()) ?>"<?= $Grid->rent_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rent_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_rent_price" class="el_juzcalculator_rent_price">
<span<?= $Grid->rent_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->rent_price->getDisplayValue($Grid->rent_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_rent_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_rent_price" id="x<?= $Grid->RowIndex ?>_rent_price" value="<?= HtmlEncode($Grid->rent_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator" data-field="x_rent_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rent_price" id="o<?= $Grid->RowIndex ?>_rent_price" value="<?= HtmlEncode($Grid->rent_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->asset_price->Visible) { // asset_price ?>
        <td data-name="asset_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_juzcalculator_asset_price" class="el_juzcalculator_asset_price">
<input type="<?= $Grid->asset_price->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_asset_price" id="x<?= $Grid->RowIndex ?>_asset_price" data-table="juzcalculator" data-field="x_asset_price" value="<?= $Grid->asset_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->asset_price->getPlaceHolder()) ?>"<?= $Grid->asset_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->asset_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_asset_price" class="el_juzcalculator_asset_price">
<span<?= $Grid->asset_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->asset_price->getDisplayValue($Grid->asset_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_asset_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_price" id="x<?= $Grid->RowIndex ?>_asset_price" value="<?= HtmlEncode($Grid->asset_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator" data-field="x_asset_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_price" id="o<?= $Grid->RowIndex ?>_asset_price" value="<?= HtmlEncode($Grid->asset_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_cdate" class="el_juzcalculator_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fjuzcalculatorgrid","load"], () => fjuzcalculatorgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fjuzcalculatorgrid">
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
    ew.addEventHandlers("juzcalculator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
