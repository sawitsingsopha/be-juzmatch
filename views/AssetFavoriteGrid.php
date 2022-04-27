<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AssetFavoriteGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fasset_favoritegrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_favoritegrid = new ew.Form("fasset_favoritegrid", "grid");
    fasset_favoritegrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { asset_favorite: currentTable } });
    var fields = currentTable.fields;
    fasset_favoritegrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["isfavorite", [fields.isfavorite.visible && fields.isfavorite.required ? ew.Validators.required(fields.isfavorite.caption) : null], fields.isfavorite.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fasset_favoritegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["isfavorite",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fasset_favoritegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_favoritegrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_favoritegrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    fasset_favoritegrid.lists.isfavorite = <?= $Grid->isfavorite->toClientList($Grid) ?>;
    loadjs.done("fasset_favoritegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_favorite">
<div id="fasset_favoritegrid" class="ew-form ew-list-form">
<div id="gmp_asset_favorite" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_asset_favoritegrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_asset_favorite_asset_id" class="asset_favorite_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->isfavorite->Visible) { // isfavorite ?>
        <th data-name="isfavorite" class="<?= $Grid->isfavorite->headerCellClass() ?>"><div id="elh_asset_favorite_isfavorite" class="asset_favorite_isfavorite"><?= $Grid->renderFieldHeader($Grid->isfavorite) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_asset_favorite_cdate" class="asset_favorite_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_asset_favorite",
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
<span id="el<?= $Grid->RowCount ?>_asset_favorite_asset_id" class="el_asset_favorite_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_favoritegrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="asset_favorite"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fasset_favoritegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fasset_favoritegrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_favoritegrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_favoritegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_favoritegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_favorite.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset_favorite" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_favorite_asset_id" class="el_asset_favorite_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_favorite" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_favorite_asset_id" class="el_asset_favorite_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_favorite" data-field="x_asset_id" data-hidden="1" name="fasset_favoritegrid$x<?= $Grid->RowIndex ?>_asset_id" id="fasset_favoritegrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="asset_favorite" data-field="x_asset_id" data-hidden="1" name="fasset_favoritegrid$o<?= $Grid->RowIndex ?>_asset_id" id="fasset_favoritegrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isfavorite->Visible) { // isfavorite ?>
        <td data-name="isfavorite"<?= $Grid->isfavorite->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_favorite_isfavorite" class="el_asset_favorite_isfavorite">
    <select
        id="x<?= $Grid->RowIndex ?>_isfavorite"
        name="x<?= $Grid->RowIndex ?>_isfavorite"
        class="form-select ew-select<?= $Grid->isfavorite->isInvalidClass() ?>"
        data-select2-id="fasset_favoritegrid_x<?= $Grid->RowIndex ?>_isfavorite"
        data-table="asset_favorite"
        data-field="x_isfavorite"
        data-value-separator="<?= $Grid->isfavorite->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->isfavorite->getPlaceHolder()) ?>"
        <?= $Grid->isfavorite->editAttributes() ?>>
        <?= $Grid->isfavorite->selectOptionListHtml("x{$Grid->RowIndex}_isfavorite") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->isfavorite->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_favoritegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_isfavorite", selectId: "fasset_favoritegrid_x<?= $Grid->RowIndex ?>_isfavorite" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_favoritegrid.lists.isfavorite.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_isfavorite", form: "fasset_favoritegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_isfavorite", form: "fasset_favoritegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_favorite.fields.isfavorite.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="asset_favorite" data-field="x_isfavorite" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isfavorite" id="o<?= $Grid->RowIndex ?>_isfavorite" value="<?= HtmlEncode($Grid->isfavorite->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_favorite_isfavorite" class="el_asset_favorite_isfavorite">
    <select
        id="x<?= $Grid->RowIndex ?>_isfavorite"
        name="x<?= $Grid->RowIndex ?>_isfavorite"
        class="form-select ew-select<?= $Grid->isfavorite->isInvalidClass() ?>"
        data-select2-id="fasset_favoritegrid_x<?= $Grid->RowIndex ?>_isfavorite"
        data-table="asset_favorite"
        data-field="x_isfavorite"
        data-value-separator="<?= $Grid->isfavorite->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->isfavorite->getPlaceHolder()) ?>"
        <?= $Grid->isfavorite->editAttributes() ?>>
        <?= $Grid->isfavorite->selectOptionListHtml("x{$Grid->RowIndex}_isfavorite") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->isfavorite->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_favoritegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_isfavorite", selectId: "fasset_favoritegrid_x<?= $Grid->RowIndex ?>_isfavorite" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_favoritegrid.lists.isfavorite.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_isfavorite", form: "fasset_favoritegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_isfavorite", form: "fasset_favoritegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_favorite.fields.isfavorite.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_favorite_isfavorite" class="el_asset_favorite_isfavorite">
<span<?= $Grid->isfavorite->viewAttributes() ?>>
<?= $Grid->isfavorite->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_favorite" data-field="x_isfavorite" data-hidden="1" name="fasset_favoritegrid$x<?= $Grid->RowIndex ?>_isfavorite" id="fasset_favoritegrid$x<?= $Grid->RowIndex ?>_isfavorite" value="<?= HtmlEncode($Grid->isfavorite->FormValue) ?>">
<input type="hidden" data-table="asset_favorite" data-field="x_isfavorite" data-hidden="1" name="fasset_favoritegrid$o<?= $Grid->RowIndex ?>_isfavorite" id="fasset_favoritegrid$o<?= $Grid->RowIndex ?>_isfavorite" value="<?= HtmlEncode($Grid->isfavorite->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset_favorite" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_favorite_cdate" class="el_asset_favorite_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_favorite" data-field="x_cdate" data-hidden="1" name="fasset_favoritegrid$x<?= $Grid->RowIndex ?>_cdate" id="fasset_favoritegrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="asset_favorite" data-field="x_cdate" data-hidden="1" name="fasset_favoritegrid$o<?= $Grid->RowIndex ?>_cdate" id="fasset_favoritegrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fasset_favoritegrid","load"], () => fasset_favoritegrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_asset_favorite", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_asset_favorite_asset_id" class="el_asset_favorite_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_favoritegrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="asset_favorite"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fasset_favoritegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fasset_favoritegrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_favoritegrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_favoritegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fasset_favoritegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_favorite.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_favorite_asset_id" class="el_asset_favorite_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_favorite" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_favorite" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isfavorite->Visible) { // isfavorite ?>
        <td data-name="isfavorite">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_favorite_isfavorite" class="el_asset_favorite_isfavorite">
    <select
        id="x<?= $Grid->RowIndex ?>_isfavorite"
        name="x<?= $Grid->RowIndex ?>_isfavorite"
        class="form-select ew-select<?= $Grid->isfavorite->isInvalidClass() ?>"
        data-select2-id="fasset_favoritegrid_x<?= $Grid->RowIndex ?>_isfavorite"
        data-table="asset_favorite"
        data-field="x_isfavorite"
        data-value-separator="<?= $Grid->isfavorite->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->isfavorite->getPlaceHolder()) ?>"
        <?= $Grid->isfavorite->editAttributes() ?>>
        <?= $Grid->isfavorite->selectOptionListHtml("x{$Grid->RowIndex}_isfavorite") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->isfavorite->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_favoritegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_isfavorite", selectId: "fasset_favoritegrid_x<?= $Grid->RowIndex ?>_isfavorite" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_favoritegrid.lists.isfavorite.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_isfavorite", form: "fasset_favoritegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_isfavorite", form: "fasset_favoritegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_favorite.fields.isfavorite.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_favorite_isfavorite" class="el_asset_favorite_isfavorite">
<span<?= $Grid->isfavorite->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->isfavorite->getDisplayValue($Grid->isfavorite->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_favorite" data-field="x_isfavorite" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isfavorite" id="x<?= $Grid->RowIndex ?>_isfavorite" value="<?= HtmlEncode($Grid->isfavorite->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_favorite" data-field="x_isfavorite" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isfavorite" id="o<?= $Grid->RowIndex ?>_isfavorite" value="<?= HtmlEncode($Grid->isfavorite->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_favorite_cdate" class="el_asset_favorite_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_favorite" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_favorite" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fasset_favoritegrid","load"], () => fasset_favoritegrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fasset_favoritegrid">
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
    ew.addEventHandlers("asset_favorite");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
