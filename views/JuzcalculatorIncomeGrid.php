<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("JuzcalculatorIncomeGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fjuzcalculator_incomegrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fjuzcalculator_incomegrid = new ew.Form("fjuzcalculator_incomegrid", "grid");
    fjuzcalculator_incomegrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { juzcalculator_income: currentTable } });
    var fields = currentTable.fields;
    fjuzcalculator_incomegrid.addFields([
        ["income_title", [fields.income_title.visible && fields.income_title.required ? ew.Validators.required(fields.income_title.caption) : null], fields.income_title.isInvalid],
        ["income", [fields.income.visible && fields.income.required ? ew.Validators.required(fields.income.caption) : null, ew.Validators.float], fields.income.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fjuzcalculator_incomegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["income_title",false],["income",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fjuzcalculator_incomegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fjuzcalculator_incomegrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fjuzcalculator_incomegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> juzcalculator_income">
<div id="fjuzcalculator_incomegrid" class="ew-form ew-list-form">
<div id="gmp_juzcalculator_income" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_juzcalculator_incomegrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->income_title->Visible) { // income_title ?>
        <th data-name="income_title" class="<?= $Grid->income_title->headerCellClass() ?>"><div id="elh_juzcalculator_income_income_title" class="juzcalculator_income_income_title"><?= $Grid->renderFieldHeader($Grid->income_title) ?></div></th>
<?php } ?>
<?php if ($Grid->income->Visible) { // income ?>
        <th data-name="income" class="<?= $Grid->income->headerCellClass() ?>"><div id="elh_juzcalculator_income_income" class="juzcalculator_income_income"><?= $Grid->renderFieldHeader($Grid->income) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_juzcalculator_income_cdate" class="juzcalculator_income_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_juzcalculator_income",
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
    <?php if ($Grid->income_title->Visible) { // income_title ?>
        <td data-name="income_title"<?= $Grid->income_title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_income_title" class="el_juzcalculator_income_income_title">
<input type="<?= $Grid->income_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income_title" id="x<?= $Grid->RowIndex ?>_income_title" data-table="juzcalculator_income" data-field="x_income_title" value="<?= $Grid->income_title->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->income_title->getPlaceHolder()) ?>"<?= $Grid->income_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income_title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_income_title" id="o<?= $Grid->RowIndex ?>_income_title" value="<?= HtmlEncode($Grid->income_title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_income_title" class="el_juzcalculator_income_income_title">
<input type="<?= $Grid->income_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income_title" id="x<?= $Grid->RowIndex ?>_income_title" data-table="juzcalculator_income" data-field="x_income_title" value="<?= $Grid->income_title->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->income_title->getPlaceHolder()) ?>"<?= $Grid->income_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income_title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_income_title" class="el_juzcalculator_income_income_title">
<span<?= $Grid->income_title->viewAttributes() ?>>
<?= $Grid->income_title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income_title" data-hidden="1" name="fjuzcalculator_incomegrid$x<?= $Grid->RowIndex ?>_income_title" id="fjuzcalculator_incomegrid$x<?= $Grid->RowIndex ?>_income_title" value="<?= HtmlEncode($Grid->income_title->FormValue) ?>">
<input type="hidden" data-table="juzcalculator_income" data-field="x_income_title" data-hidden="1" name="fjuzcalculator_incomegrid$o<?= $Grid->RowIndex ?>_income_title" id="fjuzcalculator_incomegrid$o<?= $Grid->RowIndex ?>_income_title" value="<?= HtmlEncode($Grid->income_title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->income->Visible) { // income ?>
        <td data-name="income"<?= $Grid->income->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_income" class="el_juzcalculator_income_income">
<input type="<?= $Grid->income->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income" id="x<?= $Grid->RowIndex ?>_income" data-table="juzcalculator_income" data-field="x_income" value="<?= $Grid->income->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->income->getPlaceHolder()) ?>"<?= $Grid->income->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income" data-hidden="1" name="o<?= $Grid->RowIndex ?>_income" id="o<?= $Grid->RowIndex ?>_income" value="<?= HtmlEncode($Grid->income->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_income" class="el_juzcalculator_income_income">
<input type="<?= $Grid->income->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income" id="x<?= $Grid->RowIndex ?>_income" data-table="juzcalculator_income" data-field="x_income" value="<?= $Grid->income->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->income->getPlaceHolder()) ?>"<?= $Grid->income->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_income" class="el_juzcalculator_income_income">
<span<?= $Grid->income->viewAttributes() ?>>
<?= $Grid->income->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income" data-hidden="1" name="fjuzcalculator_incomegrid$x<?= $Grid->RowIndex ?>_income" id="fjuzcalculator_incomegrid$x<?= $Grid->RowIndex ?>_income" value="<?= HtmlEncode($Grid->income->FormValue) ?>">
<input type="hidden" data-table="juzcalculator_income" data-field="x_income" data-hidden="1" name="fjuzcalculator_incomegrid$o<?= $Grid->RowIndex ?>_income" id="fjuzcalculator_incomegrid$o<?= $Grid->RowIndex ?>_income" value="<?= HtmlEncode($Grid->income->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_juzcalculator_income_cdate" class="el_juzcalculator_income_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_cdate" data-hidden="1" name="fjuzcalculator_incomegrid$x<?= $Grid->RowIndex ?>_cdate" id="fjuzcalculator_incomegrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="juzcalculator_income" data-field="x_cdate" data-hidden="1" name="fjuzcalculator_incomegrid$o<?= $Grid->RowIndex ?>_cdate" id="fjuzcalculator_incomegrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fjuzcalculator_incomegrid","load"], () => fjuzcalculator_incomegrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_juzcalculator_income", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->income_title->Visible) { // income_title ?>
        <td data-name="income_title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_juzcalculator_income_income_title" class="el_juzcalculator_income_income_title">
<input type="<?= $Grid->income_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income_title" id="x<?= $Grid->RowIndex ?>_income_title" data-table="juzcalculator_income" data-field="x_income_title" value="<?= $Grid->income_title->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->income_title->getPlaceHolder()) ?>"<?= $Grid->income_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income_title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_income_income_title" class="el_juzcalculator_income_income_title">
<span<?= $Grid->income_title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->income_title->getDisplayValue($Grid->income_title->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income_title" data-hidden="1" name="x<?= $Grid->RowIndex ?>_income_title" id="x<?= $Grid->RowIndex ?>_income_title" value="<?= HtmlEncode($Grid->income_title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_income_title" id="o<?= $Grid->RowIndex ?>_income_title" value="<?= HtmlEncode($Grid->income_title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->income->Visible) { // income ?>
        <td data-name="income">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_juzcalculator_income_income" class="el_juzcalculator_income_income">
<input type="<?= $Grid->income->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_income" id="x<?= $Grid->RowIndex ?>_income" data-table="juzcalculator_income" data-field="x_income" value="<?= $Grid->income->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->income->getPlaceHolder()) ?>"<?= $Grid->income->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->income->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_income_income" class="el_juzcalculator_income_income">
<span<?= $Grid->income->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->income->getDisplayValue($Grid->income->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income" data-hidden="1" name="x<?= $Grid->RowIndex ?>_income" id="x<?= $Grid->RowIndex ?>_income" value="<?= HtmlEncode($Grid->income->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_income" data-hidden="1" name="o<?= $Grid->RowIndex ?>_income" id="o<?= $Grid->RowIndex ?>_income" value="<?= HtmlEncode($Grid->income->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_juzcalculator_income_cdate" class="el_juzcalculator_income_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="juzcalculator_income" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="juzcalculator_income" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fjuzcalculator_incomegrid","load"], () => fjuzcalculator_incomegrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fjuzcalculator_incomegrid">
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
    ew.addEventHandlers("juzcalculator_income");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
