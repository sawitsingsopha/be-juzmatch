<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("TodoListGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ftodo_listgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftodo_listgrid = new ew.Form("ftodo_listgrid", "grid");
    ftodo_listgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { todo_list: currentTable } });
    var fields = currentTable.fields;
    ftodo_listgrid.addFields([
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["detail", [fields.detail.visible && fields.detail.required ? ew.Validators.required(fields.detail.caption) : null], fields.detail.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    ftodo_listgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["_title",false],["detail",false],["status",false],["order_by",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ftodo_listgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftodo_listgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftodo_listgrid.lists.status = <?= $Grid->status->toClientList($Grid) ?>;
    loadjs.done("ftodo_listgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> todo_list">
<div id="ftodo_listgrid" class="ew-form ew-list-form">
<div id="gmp_todo_list" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_todo_listgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Grid->_title->headerCellClass() ?>"><div id="elh_todo_list__title" class="todo_list__title"><?= $Grid->renderFieldHeader($Grid->_title) ?></div></th>
<?php } ?>
<?php if ($Grid->detail->Visible) { // detail ?>
        <th data-name="detail" class="<?= $Grid->detail->headerCellClass() ?>"><div id="elh_todo_list_detail" class="todo_list_detail"><?= $Grid->renderFieldHeader($Grid->detail) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_todo_list_status" class="todo_list_status"><?= $Grid->renderFieldHeader($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->order_by->Visible) { // order_by ?>
        <th data-name="order_by" class="<?= $Grid->order_by->headerCellClass() ?>"><div id="elh_todo_list_order_by" class="todo_list_order_by"><?= $Grid->renderFieldHeader($Grid->order_by) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_todo_list_cdate" class="todo_list_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_todo_list",
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
    <?php if ($Grid->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Grid->_title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list__title" class="el_todo_list__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="todo_list" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="todo_list" data-field="x__title" data-hidden="1" name="o<?= $Grid->RowIndex ?>__title" id="o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list__title" class="el_todo_list__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="todo_list" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list__title" class="el_todo_list__title">
<span<?= $Grid->_title->viewAttributes() ?>>
<?= $Grid->_title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="todo_list" data-field="x__title" data-hidden="1" name="ftodo_listgrid$x<?= $Grid->RowIndex ?>__title" id="ftodo_listgrid$x<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->FormValue) ?>">
<input type="hidden" data-table="todo_list" data-field="x__title" data-hidden="1" name="ftodo_listgrid$o<?= $Grid->RowIndex ?>__title" id="ftodo_listgrid$o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->detail->Visible) { // detail ?>
        <td data-name="detail"<?= $Grid->detail->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_detail" class="el_todo_list_detail">
<textarea data-table="todo_list" data-field="x_detail" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->detail->getPlaceHolder()) ?>"<?= $Grid->detail->editAttributes() ?>><?= $Grid->detail->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->detail->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="todo_list" data-field="x_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_detail" id="o<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_detail" class="el_todo_list_detail">
<textarea data-table="todo_list" data-field="x_detail" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->detail->getPlaceHolder()) ?>"<?= $Grid->detail->editAttributes() ?>><?= $Grid->detail->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->detail->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_detail" class="el_todo_list_detail">
<span<?= $Grid->detail->viewAttributes() ?>>
<?= $Grid->detail->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="todo_list" data-field="x_detail" data-hidden="1" name="ftodo_listgrid$x<?= $Grid->RowIndex ?>_detail" id="ftodo_listgrid$x<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->FormValue) ?>">
<input type="hidden" data-table="todo_list" data-field="x_detail" data-hidden="1" name="ftodo_listgrid$o<?= $Grid->RowIndex ?>_detail" id="ftodo_listgrid$o<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status"<?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_status" class="el_todo_list_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="ftodo_listgrid_x<?= $Grid->RowIndex ?>_status"
        data-table="todo_list"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("ftodo_listgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "ftodo_listgrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftodo_listgrid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "ftodo_listgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "ftodo_listgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.todo_list.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="todo_list" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_status" class="el_todo_list_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="ftodo_listgrid_x<?= $Grid->RowIndex ?>_status"
        data-table="todo_list"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("ftodo_listgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "ftodo_listgrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftodo_listgrid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "ftodo_listgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "ftodo_listgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.todo_list.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_status" class="el_todo_list_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="todo_list" data-field="x_status" data-hidden="1" name="ftodo_listgrid$x<?= $Grid->RowIndex ?>_status" id="ftodo_listgrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="todo_list" data-field="x_status" data-hidden="1" name="ftodo_listgrid$o<?= $Grid->RowIndex ?>_status" id="ftodo_listgrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->order_by->Visible) { // order_by ?>
        <td data-name="order_by"<?= $Grid->order_by->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_order_by" class="el_todo_list_order_by">
<input type="<?= $Grid->order_by->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" data-table="todo_list" data-field="x_order_by" value="<?= $Grid->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->order_by->getPlaceHolder()) ?>"<?= $Grid->order_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->order_by->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="todo_list" data-field="x_order_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_order_by" id="o<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_order_by" class="el_todo_list_order_by">
<input type="<?= $Grid->order_by->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" data-table="todo_list" data-field="x_order_by" value="<?= $Grid->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->order_by->getPlaceHolder()) ?>"<?= $Grid->order_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->order_by->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_order_by" class="el_todo_list_order_by">
<span<?= $Grid->order_by->viewAttributes() ?>>
<?= $Grid->order_by->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="todo_list" data-field="x_order_by" data-hidden="1" name="ftodo_listgrid$x<?= $Grid->RowIndex ?>_order_by" id="ftodo_listgrid$x<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->FormValue) ?>">
<input type="hidden" data-table="todo_list" data-field="x_order_by" data-hidden="1" name="ftodo_listgrid$o<?= $Grid->RowIndex ?>_order_by" id="ftodo_listgrid$o<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="todo_list" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_todo_list_cdate" class="el_todo_list_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="todo_list" data-field="x_cdate" data-hidden="1" name="ftodo_listgrid$x<?= $Grid->RowIndex ?>_cdate" id="ftodo_listgrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="todo_list" data-field="x_cdate" data-hidden="1" name="ftodo_listgrid$o<?= $Grid->RowIndex ?>_cdate" id="ftodo_listgrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["ftodo_listgrid","load"], () => ftodo_listgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_todo_list", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->_title->Visible) { // title ?>
        <td data-name="_title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_todo_list__title" class="el_todo_list__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="todo_list" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_todo_list__title" class="el_todo_list__title">
<span<?= $Grid->_title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_title->getDisplayValue($Grid->_title->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="todo_list" data-field="x__title" data-hidden="1" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="todo_list" data-field="x__title" data-hidden="1" name="o<?= $Grid->RowIndex ?>__title" id="o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->detail->Visible) { // detail ?>
        <td data-name="detail">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_todo_list_detail" class="el_todo_list_detail">
<textarea data-table="todo_list" data-field="x_detail" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->detail->getPlaceHolder()) ?>"<?= $Grid->detail->editAttributes() ?>><?= $Grid->detail->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->detail->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_todo_list_detail" class="el_todo_list_detail">
<span<?= $Grid->detail->viewAttributes() ?>>
<?= $Grid->detail->ViewValue ?></span>
</span>
<input type="hidden" data-table="todo_list" data-field="x_detail" data-hidden="1" name="x<?= $Grid->RowIndex ?>_detail" id="x<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="todo_list" data-field="x_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_detail" id="o<?= $Grid->RowIndex ?>_detail" value="<?= HtmlEncode($Grid->detail->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_todo_list_status" class="el_todo_list_status">
    <select
        id="x<?= $Grid->RowIndex ?>_status"
        name="x<?= $Grid->RowIndex ?>_status"
        class="form-select ew-select<?= $Grid->status->isInvalidClass() ?>"
        data-select2-id="ftodo_listgrid_x<?= $Grid->RowIndex ?>_status"
        data-table="todo_list"
        data-field="x_status"
        data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>"
        <?= $Grid->status->editAttributes() ?>>
        <?= $Grid->status->selectOptionListHtml("x{$Grid->RowIndex}_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
<script>
loadjs.ready("ftodo_listgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status", selectId: "ftodo_listgrid_x<?= $Grid->RowIndex ?>_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftodo_listgrid.lists.status.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status", form: "ftodo_listgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status", form: "ftodo_listgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.todo_list.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_todo_list_status" class="el_todo_list_status">
<span<?= $Grid->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status->getDisplayValue($Grid->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="todo_list" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="todo_list" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->order_by->Visible) { // order_by ?>
        <td data-name="order_by">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_todo_list_order_by" class="el_todo_list_order_by">
<input type="<?= $Grid->order_by->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" data-table="todo_list" data-field="x_order_by" value="<?= $Grid->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->order_by->getPlaceHolder()) ?>"<?= $Grid->order_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->order_by->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_todo_list_order_by" class="el_todo_list_order_by">
<span<?= $Grid->order_by->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->order_by->getDisplayValue($Grid->order_by->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="todo_list" data-field="x_order_by" data-hidden="1" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="todo_list" data-field="x_order_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_order_by" id="o<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_todo_list_cdate" class="el_todo_list_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="todo_list" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="todo_list" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ftodo_listgrid","load"], () => ftodo_listgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ftodo_listgrid">
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
    ew.addEventHandlers("todo_list");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
