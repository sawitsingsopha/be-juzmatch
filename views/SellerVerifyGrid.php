<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("SellerVerifyGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fseller_verifygrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fseller_verifygrid = new ew.Form("fseller_verifygrid", "grid");
    fseller_verifygrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { seller_verify: currentTable } });
    var fields = currentTable.fields;
    fseller_verifygrid.addFields([
        ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null], fields.category_id.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fseller_verifygrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["category_id[]",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fseller_verifygrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fseller_verifygrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fseller_verifygrid.lists.category_id = <?= $Grid->category_id->toClientList($Grid) ?>;
    loadjs.done("fseller_verifygrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> seller_verify">
<div id="fseller_verifygrid" class="ew-form ew-list-form">
<div id="gmp_seller_verify" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_seller_verifygrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->category_id->Visible) { // category_id ?>
        <th data-name="category_id" class="<?= $Grid->category_id->headerCellClass() ?>"><div id="elh_seller_verify_category_id" class="seller_verify_category_id"><?= $Grid->renderFieldHeader($Grid->category_id) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_seller_verify_cdate" class="seller_verify_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_seller_verify",
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
    <?php if ($Grid->category_id->Visible) { // category_id ?>
        <td data-name="category_id"<?= $Grid->category_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_seller_verify_category_id" class="el_seller_verify_category_id">
<template id="tp_x<?= $Grid->RowIndex ?>_category_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="seller_verify" data-field="x_category_id" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id"<?= $Grid->category_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_category_id" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_category_id[]"
    name="x<?= $Grid->RowIndex ?>_category_id[]"
    value="<?= HtmlEncode($Grid->category_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_category_id"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_category_id"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->category_id->isInvalidClass() ?>"
    data-table="seller_verify"
    data-field="x_category_id"
    data-value-separator="<?= $Grid->category_id->displayValueSeparatorAttribute() ?>"
    <?= $Grid->category_id->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->category_id->getErrorMessage() ?></div>
<?= $Grid->category_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_category_id") ?>
</span>
<input type="hidden" data-table="seller_verify" data-field="x_category_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_category_id[]" id="o<?= $Grid->RowIndex ?>_category_id[]" value="<?= HtmlEncode($Grid->category_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_seller_verify_category_id" class="el_seller_verify_category_id">
<template id="tp_x<?= $Grid->RowIndex ?>_category_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="seller_verify" data-field="x_category_id" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id"<?= $Grid->category_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_category_id" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_category_id[]"
    name="x<?= $Grid->RowIndex ?>_category_id[]"
    value="<?= HtmlEncode($Grid->category_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_category_id"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_category_id"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->category_id->isInvalidClass() ?>"
    data-table="seller_verify"
    data-field="x_category_id"
    data-value-separator="<?= $Grid->category_id->displayValueSeparatorAttribute() ?>"
    <?= $Grid->category_id->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->category_id->getErrorMessage() ?></div>
<?= $Grid->category_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_category_id") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_seller_verify_category_id" class="el_seller_verify_category_id">
<span<?= $Grid->category_id->viewAttributes() ?>>
<?= $Grid->category_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="seller_verify" data-field="x_category_id" data-hidden="1" name="fseller_verifygrid$x<?= $Grid->RowIndex ?>_category_id" id="fseller_verifygrid$x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->FormValue) ?>">
<input type="hidden" data-table="seller_verify" data-field="x_category_id" data-hidden="1" name="fseller_verifygrid$o<?= $Grid->RowIndex ?>_category_id[]" id="fseller_verifygrid$o<?= $Grid->RowIndex ?>_category_id[]" value="<?= HtmlEncode($Grid->category_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="seller_verify" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_seller_verify_cdate" class="el_seller_verify_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="seller_verify" data-field="x_cdate" data-hidden="1" name="fseller_verifygrid$x<?= $Grid->RowIndex ?>_cdate" id="fseller_verifygrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="seller_verify" data-field="x_cdate" data-hidden="1" name="fseller_verifygrid$o<?= $Grid->RowIndex ?>_cdate" id="fseller_verifygrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fseller_verifygrid","load"], () => fseller_verifygrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_seller_verify", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->category_id->Visible) { // category_id ?>
        <td data-name="category_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_seller_verify_category_id" class="el_seller_verify_category_id">
<template id="tp_x<?= $Grid->RowIndex ?>_category_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="seller_verify" data-field="x_category_id" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id"<?= $Grid->category_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_category_id" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_category_id[]"
    name="x<?= $Grid->RowIndex ?>_category_id[]"
    value="<?= HtmlEncode($Grid->category_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x<?= $Grid->RowIndex ?>_category_id"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_category_id"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->category_id->isInvalidClass() ?>"
    data-table="seller_verify"
    data-field="x_category_id"
    data-value-separator="<?= $Grid->category_id->displayValueSeparatorAttribute() ?>"
    <?= $Grid->category_id->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->category_id->getErrorMessage() ?></div>
<?= $Grid->category_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_category_id") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_seller_verify_category_id" class="el_seller_verify_category_id">
<span<?= $Grid->category_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->category_id->getDisplayValue($Grid->category_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="seller_verify" data-field="x_category_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_category_id" id="x<?= $Grid->RowIndex ?>_category_id" value="<?= HtmlEncode($Grid->category_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="seller_verify" data-field="x_category_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_category_id[]" id="o<?= $Grid->RowIndex ?>_category_id[]" value="<?= HtmlEncode($Grid->category_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_seller_verify_cdate" class="el_seller_verify_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="seller_verify" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="seller_verify" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fseller_verifygrid","load"], () => fseller_verifygrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fseller_verifygrid">
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
    ew.addEventHandlers("seller_verify");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
