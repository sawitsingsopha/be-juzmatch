<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("InverterAssetGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var finverter_assetgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finverter_assetgrid = new ew.Form("finverter_assetgrid", "grid");
    finverter_assetgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { inverter_asset: currentTable } });
    var fields = currentTable.fields;
    finverter_assetgrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null, ew.Validators.integer], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid],
        ["res_paidAgent", [fields.res_paidAgent.visible && fields.res_paidAgent.required ? ew.Validators.required(fields.res_paidAgent.caption) : null], fields.res_paidAgent.isInvalid],
        ["res_paidChannel", [fields.res_paidChannel.visible && fields.res_paidChannel.required ? ew.Validators.required(fields.res_paidChannel.caption) : null], fields.res_paidChannel.isInvalid],
        ["res_maskedPan", [fields.res_maskedPan.visible && fields.res_maskedPan.required ? ew.Validators.required(fields.res_maskedPan.caption) : null], fields.res_maskedPan.isInvalid]
    ]);

    // Check empty row
    finverter_assetgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["status_expire",false],["status_expire_reason",false],["res_paidAgent",false],["res_paidChannel",false],["res_maskedPan",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    finverter_assetgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finverter_assetgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    finverter_assetgrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    loadjs.done("finverter_assetgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> inverter_asset">
<div id="finverter_assetgrid" class="ew-form ew-list-form">
<div id="gmp_inverter_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_inverter_assetgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_inverter_asset_asset_id" class="inverter_asset_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Grid->status_expire->headerCellClass() ?>"><div id="elh_inverter_asset_status_expire" class="inverter_asset_status_expire"><?= $Grid->renderFieldHeader($Grid->status_expire) ?></div></th>
<?php } ?>
<?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Grid->status_expire_reason->headerCellClass() ?>"><div id="elh_inverter_asset_status_expire_reason" class="inverter_asset_status_expire_reason"><?= $Grid->renderFieldHeader($Grid->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Grid->res_paidAgent->Visible) { // res_paidAgent ?>
        <th data-name="res_paidAgent" class="<?= $Grid->res_paidAgent->headerCellClass() ?>"><div id="elh_inverter_asset_res_paidAgent" class="inverter_asset_res_paidAgent"><?= $Grid->renderFieldHeader($Grid->res_paidAgent) ?></div></th>
<?php } ?>
<?php if ($Grid->res_paidChannel->Visible) { // res_paidChannel ?>
        <th data-name="res_paidChannel" class="<?= $Grid->res_paidChannel->headerCellClass() ?>"><div id="elh_inverter_asset_res_paidChannel" class="inverter_asset_res_paidChannel"><?= $Grid->renderFieldHeader($Grid->res_paidChannel) ?></div></th>
<?php } ?>
<?php if ($Grid->res_maskedPan->Visible) { // res_maskedPan ?>
        <th data-name="res_maskedPan" class="<?= $Grid->res_maskedPan->headerCellClass() ?>"><div id="elh_inverter_asset_res_maskedPan" class="inverter_asset_res_maskedPan"><?= $Grid->renderFieldHeader($Grid->res_maskedPan) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_inverter_asset",
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
<span id="el<?= $Grid->RowCount ?>_inverter_asset_asset_id" class="el_inverter_asset_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="finverter_assetgrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="inverter_asset"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("finverter_assetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "finverter_assetgrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finverter_assetgrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finverter_assetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finverter_assetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.inverter_asset.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_asset_id" class="el_inverter_asset_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_asset_id" class="el_inverter_asset_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="inverter_asset" data-field="x_asset_id" data-hidden="1" name="finverter_assetgrid$x<?= $Grid->RowIndex ?>_asset_id" id="finverter_assetgrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="inverter_asset" data-field="x_asset_id" data-hidden="1" name="finverter_assetgrid$o<?= $Grid->RowIndex ?>_asset_id" id="finverter_assetgrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Grid->status_expire->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_status_expire" class="el_inverter_asset_status_expire">
<input type="<?= $Grid->status_expire->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" data-table="inverter_asset" data-field="x_status_expire" value="<?= $Grid->status_expire->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->status_expire->getPlaceHolder()) ?>"<?= $Grid->status_expire->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_status_expire" class="el_inverter_asset_status_expire">
<input type="<?= $Grid->status_expire->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" data-table="inverter_asset" data-field="x_status_expire" value="<?= $Grid->status_expire->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->status_expire->getPlaceHolder()) ?>"<?= $Grid->status_expire->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_status_expire" class="el_inverter_asset_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<?= $Grid->status_expire->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire" data-hidden="1" name="finverter_assetgrid$x<?= $Grid->RowIndex ?>_status_expire" id="finverter_assetgrid$x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire" data-hidden="1" name="finverter_assetgrid$o<?= $Grid->RowIndex ?>_status_expire" id="finverter_assetgrid$o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Grid->status_expire_reason->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_status_expire_reason" class="el_inverter_asset_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="inverter_asset" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_status_expire_reason" class="el_inverter_asset_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="inverter_asset" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_status_expire_reason" class="el_inverter_asset_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<?= $Grid->status_expire_reason->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire_reason" data-hidden="1" name="finverter_assetgrid$x<?= $Grid->RowIndex ?>_status_expire_reason" id="finverter_assetgrid$x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire_reason" data-hidden="1" name="finverter_assetgrid$o<?= $Grid->RowIndex ?>_status_expire_reason" id="finverter_assetgrid$o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->res_paidAgent->Visible) { // res_paidAgent ?>
        <td data-name="res_paidAgent"<?= $Grid->res_paidAgent->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_paidAgent" class="el_inverter_asset_res_paidAgent">
<input type="<?= $Grid->res_paidAgent->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_paidAgent" id="x<?= $Grid->RowIndex ?>_res_paidAgent" data-table="inverter_asset" data-field="x_res_paidAgent" value="<?= $Grid->res_paidAgent->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_paidAgent->getPlaceHolder()) ?>"<?= $Grid->res_paidAgent->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_paidAgent->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidAgent" data-hidden="1" name="o<?= $Grid->RowIndex ?>_res_paidAgent" id="o<?= $Grid->RowIndex ?>_res_paidAgent" value="<?= HtmlEncode($Grid->res_paidAgent->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_paidAgent" class="el_inverter_asset_res_paidAgent">
<input type="<?= $Grid->res_paidAgent->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_paidAgent" id="x<?= $Grid->RowIndex ?>_res_paidAgent" data-table="inverter_asset" data-field="x_res_paidAgent" value="<?= $Grid->res_paidAgent->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_paidAgent->getPlaceHolder()) ?>"<?= $Grid->res_paidAgent->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_paidAgent->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_paidAgent" class="el_inverter_asset_res_paidAgent">
<span<?= $Grid->res_paidAgent->viewAttributes() ?>>
<?= $Grid->res_paidAgent->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidAgent" data-hidden="1" name="finverter_assetgrid$x<?= $Grid->RowIndex ?>_res_paidAgent" id="finverter_assetgrid$x<?= $Grid->RowIndex ?>_res_paidAgent" value="<?= HtmlEncode($Grid->res_paidAgent->FormValue) ?>">
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidAgent" data-hidden="1" name="finverter_assetgrid$o<?= $Grid->RowIndex ?>_res_paidAgent" id="finverter_assetgrid$o<?= $Grid->RowIndex ?>_res_paidAgent" value="<?= HtmlEncode($Grid->res_paidAgent->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->res_paidChannel->Visible) { // res_paidChannel ?>
        <td data-name="res_paidChannel"<?= $Grid->res_paidChannel->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_paidChannel" class="el_inverter_asset_res_paidChannel">
<input type="<?= $Grid->res_paidChannel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_paidChannel" id="x<?= $Grid->RowIndex ?>_res_paidChannel" data-table="inverter_asset" data-field="x_res_paidChannel" value="<?= $Grid->res_paidChannel->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_paidChannel->getPlaceHolder()) ?>"<?= $Grid->res_paidChannel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_paidChannel->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidChannel" data-hidden="1" name="o<?= $Grid->RowIndex ?>_res_paidChannel" id="o<?= $Grid->RowIndex ?>_res_paidChannel" value="<?= HtmlEncode($Grid->res_paidChannel->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_paidChannel" class="el_inverter_asset_res_paidChannel">
<input type="<?= $Grid->res_paidChannel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_paidChannel" id="x<?= $Grid->RowIndex ?>_res_paidChannel" data-table="inverter_asset" data-field="x_res_paidChannel" value="<?= $Grid->res_paidChannel->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_paidChannel->getPlaceHolder()) ?>"<?= $Grid->res_paidChannel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_paidChannel->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_paidChannel" class="el_inverter_asset_res_paidChannel">
<span<?= $Grid->res_paidChannel->viewAttributes() ?>>
<?= $Grid->res_paidChannel->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidChannel" data-hidden="1" name="finverter_assetgrid$x<?= $Grid->RowIndex ?>_res_paidChannel" id="finverter_assetgrid$x<?= $Grid->RowIndex ?>_res_paidChannel" value="<?= HtmlEncode($Grid->res_paidChannel->FormValue) ?>">
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidChannel" data-hidden="1" name="finverter_assetgrid$o<?= $Grid->RowIndex ?>_res_paidChannel" id="finverter_assetgrid$o<?= $Grid->RowIndex ?>_res_paidChannel" value="<?= HtmlEncode($Grid->res_paidChannel->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->res_maskedPan->Visible) { // res_maskedPan ?>
        <td data-name="res_maskedPan"<?= $Grid->res_maskedPan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_maskedPan" class="el_inverter_asset_res_maskedPan">
<input type="<?= $Grid->res_maskedPan->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_maskedPan" id="x<?= $Grid->RowIndex ?>_res_maskedPan" data-table="inverter_asset" data-field="x_res_maskedPan" value="<?= $Grid->res_maskedPan->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_maskedPan->getPlaceHolder()) ?>"<?= $Grid->res_maskedPan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_maskedPan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_res_maskedPan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_res_maskedPan" id="o<?= $Grid->RowIndex ?>_res_maskedPan" value="<?= HtmlEncode($Grid->res_maskedPan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_maskedPan" class="el_inverter_asset_res_maskedPan">
<input type="<?= $Grid->res_maskedPan->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_maskedPan" id="x<?= $Grid->RowIndex ?>_res_maskedPan" data-table="inverter_asset" data-field="x_res_maskedPan" value="<?= $Grid->res_maskedPan->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_maskedPan->getPlaceHolder()) ?>"<?= $Grid->res_maskedPan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_maskedPan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_inverter_asset_res_maskedPan" class="el_inverter_asset_res_maskedPan">
<span<?= $Grid->res_maskedPan->viewAttributes() ?>>
<?= $Grid->res_maskedPan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="inverter_asset" data-field="x_res_maskedPan" data-hidden="1" name="finverter_assetgrid$x<?= $Grid->RowIndex ?>_res_maskedPan" id="finverter_assetgrid$x<?= $Grid->RowIndex ?>_res_maskedPan" value="<?= HtmlEncode($Grid->res_maskedPan->FormValue) ?>">
<input type="hidden" data-table="inverter_asset" data-field="x_res_maskedPan" data-hidden="1" name="finverter_assetgrid$o<?= $Grid->RowIndex ?>_res_maskedPan" id="finverter_assetgrid$o<?= $Grid->RowIndex ?>_res_maskedPan" value="<?= HtmlEncode($Grid->res_maskedPan->OldValue) ?>">
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
loadjs.ready(["finverter_assetgrid","load"], () => finverter_assetgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_inverter_asset", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_inverter_asset_asset_id" class="el_inverter_asset_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="finverter_assetgrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="inverter_asset"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("finverter_assetgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "finverter_assetgrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finverter_assetgrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finverter_assetgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "finverter_assetgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.inverter_asset.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_inverter_asset_asset_id" class="el_inverter_asset_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="inverter_asset" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_inverter_asset_status_expire" class="el_inverter_asset_status_expire">
<input type="<?= $Grid->status_expire->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" data-table="inverter_asset" data-field="x_status_expire" value="<?= $Grid->status_expire->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->status_expire->getPlaceHolder()) ?>"<?= $Grid->status_expire->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_inverter_asset_status_expire" class="el_inverter_asset_status_expire">
<span<?= $Grid->status_expire->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_expire->getDisplayValue($Grid->status_expire->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire" id="x<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire" id="o<?= $Grid->RowIndex ?>_status_expire" value="<?= HtmlEncode($Grid->status_expire->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_inverter_asset_status_expire_reason" class="el_inverter_asset_status_expire_reason">
<input type="<?= $Grid->status_expire_reason->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" data-table="inverter_asset" data-field="x_status_expire_reason" value="<?= $Grid->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->status_expire_reason->getPlaceHolder()) ?>"<?= $Grid->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status_expire_reason->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_inverter_asset_status_expire_reason" class="el_inverter_asset_status_expire_reason">
<span<?= $Grid->status_expire_reason->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status_expire_reason->getDisplayValue($Grid->status_expire_reason->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire_reason" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_expire_reason" id="x<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="inverter_asset" data-field="x_status_expire_reason" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_expire_reason" id="o<?= $Grid->RowIndex ?>_status_expire_reason" value="<?= HtmlEncode($Grid->status_expire_reason->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->res_paidAgent->Visible) { // res_paidAgent ?>
        <td data-name="res_paidAgent">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_inverter_asset_res_paidAgent" class="el_inverter_asset_res_paidAgent">
<input type="<?= $Grid->res_paidAgent->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_paidAgent" id="x<?= $Grid->RowIndex ?>_res_paidAgent" data-table="inverter_asset" data-field="x_res_paidAgent" value="<?= $Grid->res_paidAgent->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_paidAgent->getPlaceHolder()) ?>"<?= $Grid->res_paidAgent->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_paidAgent->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_inverter_asset_res_paidAgent" class="el_inverter_asset_res_paidAgent">
<span<?= $Grid->res_paidAgent->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->res_paidAgent->getDisplayValue($Grid->res_paidAgent->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidAgent" data-hidden="1" name="x<?= $Grid->RowIndex ?>_res_paidAgent" id="x<?= $Grid->RowIndex ?>_res_paidAgent" value="<?= HtmlEncode($Grid->res_paidAgent->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidAgent" data-hidden="1" name="o<?= $Grid->RowIndex ?>_res_paidAgent" id="o<?= $Grid->RowIndex ?>_res_paidAgent" value="<?= HtmlEncode($Grid->res_paidAgent->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->res_paidChannel->Visible) { // res_paidChannel ?>
        <td data-name="res_paidChannel">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_inverter_asset_res_paidChannel" class="el_inverter_asset_res_paidChannel">
<input type="<?= $Grid->res_paidChannel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_paidChannel" id="x<?= $Grid->RowIndex ?>_res_paidChannel" data-table="inverter_asset" data-field="x_res_paidChannel" value="<?= $Grid->res_paidChannel->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_paidChannel->getPlaceHolder()) ?>"<?= $Grid->res_paidChannel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_paidChannel->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_inverter_asset_res_paidChannel" class="el_inverter_asset_res_paidChannel">
<span<?= $Grid->res_paidChannel->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->res_paidChannel->getDisplayValue($Grid->res_paidChannel->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidChannel" data-hidden="1" name="x<?= $Grid->RowIndex ?>_res_paidChannel" id="x<?= $Grid->RowIndex ?>_res_paidChannel" value="<?= HtmlEncode($Grid->res_paidChannel->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="inverter_asset" data-field="x_res_paidChannel" data-hidden="1" name="o<?= $Grid->RowIndex ?>_res_paidChannel" id="o<?= $Grid->RowIndex ?>_res_paidChannel" value="<?= HtmlEncode($Grid->res_paidChannel->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->res_maskedPan->Visible) { // res_maskedPan ?>
        <td data-name="res_maskedPan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_inverter_asset_res_maskedPan" class="el_inverter_asset_res_maskedPan">
<input type="<?= $Grid->res_maskedPan->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_res_maskedPan" id="x<?= $Grid->RowIndex ?>_res_maskedPan" data-table="inverter_asset" data-field="x_res_maskedPan" value="<?= $Grid->res_maskedPan->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->res_maskedPan->getPlaceHolder()) ?>"<?= $Grid->res_maskedPan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->res_maskedPan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_inverter_asset_res_maskedPan" class="el_inverter_asset_res_maskedPan">
<span<?= $Grid->res_maskedPan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->res_maskedPan->getDisplayValue($Grid->res_maskedPan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="inverter_asset" data-field="x_res_maskedPan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_res_maskedPan" id="x<?= $Grid->RowIndex ?>_res_maskedPan" value="<?= HtmlEncode($Grid->res_maskedPan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="inverter_asset" data-field="x_res_maskedPan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_res_maskedPan" id="o<?= $Grid->RowIndex ?>_res_maskedPan" value="<?= HtmlEncode($Grid->res_maskedPan->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["finverter_assetgrid","load"], () => finverter_assetgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="finverter_assetgrid">
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
    ew.addEventHandlers("inverter_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
