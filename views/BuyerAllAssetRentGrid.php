<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("BuyerAllAssetRentGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fbuyer_all_asset_rentgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_all_asset_rentgrid = new ew.Form("fbuyer_all_asset_rentgrid", "grid");
    fbuyer_all_asset_rentgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { buyer_all_asset_rent: currentTable } });
    var fields = currentTable.fields;
    fbuyer_all_asset_rentgrid.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["one_time_status", [fields.one_time_status.visible && fields.one_time_status.required ? ew.Validators.required(fields.one_time_status.caption) : null], fields.one_time_status.isInvalid],
        ["half_price_1", [fields.half_price_1.visible && fields.half_price_1.required ? ew.Validators.required(fields.half_price_1.caption) : null], fields.half_price_1.isInvalid],
        ["status_pay_half_price_1", [fields.status_pay_half_price_1.visible && fields.status_pay_half_price_1.required ? ew.Validators.required(fields.status_pay_half_price_1.caption) : null], fields.status_pay_half_price_1.isInvalid],
        ["due_date_pay_half_price_1", [fields.due_date_pay_half_price_1.visible && fields.due_date_pay_half_price_1.required ? ew.Validators.required(fields.due_date_pay_half_price_1.caption) : null, ew.Validators.datetime(fields.due_date_pay_half_price_1.clientFormatPattern)], fields.due_date_pay_half_price_1.isInvalid],
        ["half_price_2", [fields.half_price_2.visible && fields.half_price_2.required ? ew.Validators.required(fields.half_price_2.caption) : null], fields.half_price_2.isInvalid],
        ["status_pay_half_price_2", [fields.status_pay_half_price_2.visible && fields.status_pay_half_price_2.required ? ew.Validators.required(fields.status_pay_half_price_2.caption) : null], fields.status_pay_half_price_2.isInvalid],
        ["due_date_pay_half_price_2", [fields.due_date_pay_half_price_2.visible && fields.due_date_pay_half_price_2.required ? ew.Validators.required(fields.due_date_pay_half_price_2.caption) : null, ew.Validators.datetime(fields.due_date_pay_half_price_2.clientFormatPattern)], fields.due_date_pay_half_price_2.isInvalid]
    ]);

    // Check empty row
    fbuyer_all_asset_rentgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["asset_id",false],["member_id",false],["one_time_status[]",true],["half_price_1",false],["status_pay_half_price_1",false],["due_date_pay_half_price_1",false],["half_price_2",false],["status_pay_half_price_2",false],["due_date_pay_half_price_2",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fbuyer_all_asset_rentgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_all_asset_rentgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_all_asset_rentgrid.lists.asset_id = <?= $Grid->asset_id->toClientList($Grid) ?>;
    fbuyer_all_asset_rentgrid.lists.member_id = <?= $Grid->member_id->toClientList($Grid) ?>;
    fbuyer_all_asset_rentgrid.lists.one_time_status = <?= $Grid->one_time_status->toClientList($Grid) ?>;
    fbuyer_all_asset_rentgrid.lists.status_pay_half_price_1 = <?= $Grid->status_pay_half_price_1->toClientList($Grid) ?>;
    fbuyer_all_asset_rentgrid.lists.status_pay_half_price_2 = <?= $Grid->status_pay_half_price_2->toClientList($Grid) ?>;
    loadjs.done("fbuyer_all_asset_rentgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_all_asset_rent">
<div id="fbuyer_all_asset_rentgrid" class="ew-form ew-list-form">
<div id="gmp_buyer_all_asset_rent" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_buyer_all_asset_rentgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Grid->asset_id->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_asset_id" class="buyer_all_asset_rent_asset_id"><?= $Grid->renderFieldHeader($Grid->asset_id) ?></div></th>
<?php } ?>
<?php if ($Grid->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Grid->member_id->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_member_id" class="buyer_all_asset_rent_member_id"><?= $Grid->renderFieldHeader($Grid->member_id) ?></div></th>
<?php } ?>
<?php if ($Grid->one_time_status->Visible) { // one_time_status ?>
        <th data-name="one_time_status" class="<?= $Grid->one_time_status->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_one_time_status" class="buyer_all_asset_rent_one_time_status"><?= $Grid->renderFieldHeader($Grid->one_time_status) ?></div></th>
<?php } ?>
<?php if ($Grid->half_price_1->Visible) { // half_price_1 ?>
        <th data-name="half_price_1" class="<?= $Grid->half_price_1->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_half_price_1" class="buyer_all_asset_rent_half_price_1"><?= $Grid->renderFieldHeader($Grid->half_price_1) ?></div></th>
<?php } ?>
<?php if ($Grid->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <th data-name="status_pay_half_price_1" class="<?= $Grid->status_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_status_pay_half_price_1" class="buyer_all_asset_rent_status_pay_half_price_1"><?= $Grid->renderFieldHeader($Grid->status_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Grid->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <th data-name="due_date_pay_half_price_1" class="<?= $Grid->due_date_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_due_date_pay_half_price_1" class="buyer_all_asset_rent_due_date_pay_half_price_1"><?= $Grid->renderFieldHeader($Grid->due_date_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Grid->half_price_2->Visible) { // half_price_2 ?>
        <th data-name="half_price_2" class="<?= $Grid->half_price_2->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_half_price_2" class="buyer_all_asset_rent_half_price_2"><?= $Grid->renderFieldHeader($Grid->half_price_2) ?></div></th>
<?php } ?>
<?php if ($Grid->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <th data-name="status_pay_half_price_2" class="<?= $Grid->status_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_status_pay_half_price_2" class="buyer_all_asset_rent_status_pay_half_price_2"><?= $Grid->renderFieldHeader($Grid->status_pay_half_price_2) ?></div></th>
<?php } ?>
<?php if ($Grid->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <th data-name="due_date_pay_half_price_2" class="<?= $Grid->due_date_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_due_date_pay_half_price_2" class="buyer_all_asset_rent_due_date_pay_half_price_2"><?= $Grid->renderFieldHeader($Grid->due_date_pay_half_price_2) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_buyer_all_asset_rent",
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
<?php if ($Grid->asset_id->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_asset_id" name="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode(FormatNumber($Grid->asset_id->CurrentValue, $Grid->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="buyer_all_asset_rent"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<?= $Grid->asset_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_asset_id" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_asset_id" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Grid->member_id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_member_id" class="el_buyer_all_asset_rent_member_id">
    <select
        id="x<?= $Grid->RowIndex ?>_member_id"
        name="x<?= $Grid->RowIndex ?>_member_id"
        class="form-select ew-select<?= $Grid->member_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_member_id"
        data-table="buyer_all_asset_rent"
        data-field="x_member_id"
        data-value-separator="<?= $Grid->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->member_id->getPlaceHolder()) ?>"
        <?= $Grid->member_id->editAttributes() ?>>
        <?= $Grid->member_id->selectOptionListHtml("x{$Grid->RowIndex}_member_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->member_id->getErrorMessage() ?></div>
<?= $Grid->member_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_member_id") ?>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_member_id", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.member_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_member_id" id="o<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_member_id" class="el_buyer_all_asset_rent_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->member_id->getDisplayValue($Grid->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_member_id" id="x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_member_id" class="el_buyer_all_asset_rent_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<?= $Grid->member_id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_member_id" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_member_id" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->one_time_status->Visible) { // one_time_status ?>
        <td data-name="one_time_status"<?= $Grid->one_time_status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_one_time_status" class="el_buyer_all_asset_rent_one_time_status">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->one_time_status->isInvalidClass() ?>" data-table="buyer_all_asset_rent" data-field="x_one_time_status" name="x<?= $Grid->RowIndex ?>_one_time_status[]" id="x<?= $Grid->RowIndex ?>_one_time_status_918047" value="1"<?= ConvertToBool($Grid->one_time_status->CurrentValue) ? " checked" : "" ?><?= $Grid->one_time_status->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->one_time_status->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_one_time_status[]" id="o<?= $Grid->RowIndex ?>_one_time_status[]" value="<?= HtmlEncode($Grid->one_time_status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_one_time_status" class="el_buyer_all_asset_rent_one_time_status">
<span<?= $Grid->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->one_time_status->EditValue ?>" disabled<?php if (ConvertToBool($Grid->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_one_time_status" id="x<?= $Grid->RowIndex ?>_one_time_status" value="<?= HtmlEncode($Grid->one_time_status->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_one_time_status" class="el_buyer_all_asset_rent_one_time_status">
<span<?= $Grid->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->one_time_status->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_one_time_status" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_one_time_status" value="<?= HtmlEncode($Grid->one_time_status->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_one_time_status[]" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_one_time_status[]" value="<?= HtmlEncode($Grid->one_time_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->half_price_1->Visible) { // half_price_1 ?>
        <td data-name="half_price_1"<?= $Grid->half_price_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_half_price_1" class="el_buyer_all_asset_rent_half_price_1">
<input type="<?= $Grid->half_price_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_half_price_1" id="x<?= $Grid->RowIndex ?>_half_price_1" data-table="buyer_all_asset_rent" data-field="x_half_price_1" value="<?= $Grid->half_price_1->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->half_price_1->getPlaceHolder()) ?>"<?= $Grid->half_price_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->half_price_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_half_price_1" id="o<?= $Grid->RowIndex ?>_half_price_1" value="<?= HtmlEncode($Grid->half_price_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_half_price_1" class="el_buyer_all_asset_rent_half_price_1">
<span<?= $Grid->half_price_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->half_price_1->getDisplayValue($Grid->half_price_1->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_half_price_1" id="x<?= $Grid->RowIndex ?>_half_price_1" value="<?= HtmlEncode($Grid->half_price_1->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_half_price_1" class="el_buyer_all_asset_rent_half_price_1">
<span<?= $Grid->half_price_1->viewAttributes() ?>>
<?= $Grid->half_price_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_half_price_1" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_half_price_1" value="<?= HtmlEncode($Grid->half_price_1->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_half_price_1" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_half_price_1" value="<?= HtmlEncode($Grid->half_price_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <td data-name="status_pay_half_price_1"<?= $Grid->status_pay_half_price_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_1" class="el_buyer_all_asset_rent_status_pay_half_price_1">
    <select
        id="x<?= $Grid->RowIndex ?>_status_pay_half_price_1"
        name="x<?= $Grid->RowIndex ?>_status_pay_half_price_1"
        class="form-select ew-select<?= $Grid->status_pay_half_price_1->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_1"
        data-table="buyer_all_asset_rent"
        data-field="x_status_pay_half_price_1"
        data-value-separator="<?= $Grid->status_pay_half_price_1->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_pay_half_price_1->getPlaceHolder()) ?>"
        <?= $Grid->status_pay_half_price_1->editAttributes() ?>>
        <?= $Grid->status_pay_half_price_1->selectOptionListHtml("x{$Grid->RowIndex}_status_pay_half_price_1") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_pay_half_price_1->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_pay_half_price_1", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_1" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.status_pay_half_price_1.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_1", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_1", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.status_pay_half_price_1.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_pay_half_price_1" id="o<?= $Grid->RowIndex ?>_status_pay_half_price_1" value="<?= HtmlEncode($Grid->status_pay_half_price_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_1" class="el_buyer_all_asset_rent_status_pay_half_price_1">
<span<?= $Grid->status_pay_half_price_1->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_pay_half_price_1->getDisplayValue($Grid->status_pay_half_price_1->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_pay_half_price_1" id="x<?= $Grid->RowIndex ?>_status_pay_half_price_1" value="<?= HtmlEncode($Grid->status_pay_half_price_1->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_1" class="el_buyer_all_asset_rent_status_pay_half_price_1">
<span<?= $Grid->status_pay_half_price_1->viewAttributes() ?>>
<?= $Grid->status_pay_half_price_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_status_pay_half_price_1" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_status_pay_half_price_1" value="<?= HtmlEncode($Grid->status_pay_half_price_1->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_status_pay_half_price_1" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_status_pay_half_price_1" value="<?= HtmlEncode($Grid->status_pay_half_price_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <td data-name="due_date_pay_half_price_1"<?= $Grid->due_date_pay_half_price_1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_1" class="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<input type="<?= $Grid->due_date_pay_half_price_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" value="<?= $Grid->due_date_pay_half_price_1->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date_pay_half_price_1->getPlaceHolder()) ?>"<?= $Grid->due_date_pay_half_price_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date_pay_half_price_1->getErrorMessage() ?></div>
<?php if (!$Grid->due_date_pay_half_price_1->ReadOnly && !$Grid->due_date_pay_half_price_1->Disabled && !isset($Grid->due_date_pay_half_price_1->EditAttrs["readonly"]) && !isset($Grid->due_date_pay_half_price_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentgrid", "x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" value="<?= HtmlEncode($Grid->due_date_pay_half_price_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_1" class="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<input type="<?= $Grid->due_date_pay_half_price_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" value="<?= $Grid->due_date_pay_half_price_1->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date_pay_half_price_1->getPlaceHolder()) ?>"<?= $Grid->due_date_pay_half_price_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date_pay_half_price_1->getErrorMessage() ?></div>
<?php if (!$Grid->due_date_pay_half_price_1->ReadOnly && !$Grid->due_date_pay_half_price_1->Disabled && !isset($Grid->due_date_pay_half_price_1->EditAttrs["readonly"]) && !isset($Grid->due_date_pay_half_price_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentgrid", "x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_1" class="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<span<?= $Grid->due_date_pay_half_price_1->viewAttributes() ?>>
<?= $Grid->due_date_pay_half_price_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" value="<?= HtmlEncode($Grid->due_date_pay_half_price_1->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" value="<?= HtmlEncode($Grid->due_date_pay_half_price_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->half_price_2->Visible) { // half_price_2 ?>
        <td data-name="half_price_2"<?= $Grid->half_price_2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_half_price_2" class="el_buyer_all_asset_rent_half_price_2">
<input type="<?= $Grid->half_price_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_half_price_2" id="x<?= $Grid->RowIndex ?>_half_price_2" data-table="buyer_all_asset_rent" data-field="x_half_price_2" value="<?= $Grid->half_price_2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->half_price_2->getPlaceHolder()) ?>"<?= $Grid->half_price_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->half_price_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_half_price_2" id="o<?= $Grid->RowIndex ?>_half_price_2" value="<?= HtmlEncode($Grid->half_price_2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_half_price_2" class="el_buyer_all_asset_rent_half_price_2">
<span<?= $Grid->half_price_2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->half_price_2->getDisplayValue($Grid->half_price_2->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_half_price_2" id="x<?= $Grid->RowIndex ?>_half_price_2" value="<?= HtmlEncode($Grid->half_price_2->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_half_price_2" class="el_buyer_all_asset_rent_half_price_2">
<span<?= $Grid->half_price_2->viewAttributes() ?>>
<?= $Grid->half_price_2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_half_price_2" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_half_price_2" value="<?= HtmlEncode($Grid->half_price_2->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_half_price_2" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_half_price_2" value="<?= HtmlEncode($Grid->half_price_2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <td data-name="status_pay_half_price_2"<?= $Grid->status_pay_half_price_2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_2" class="el_buyer_all_asset_rent_status_pay_half_price_2">
    <select
        id="x<?= $Grid->RowIndex ?>_status_pay_half_price_2"
        name="x<?= $Grid->RowIndex ?>_status_pay_half_price_2"
        class="form-select ew-select<?= $Grid->status_pay_half_price_2->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_2"
        data-table="buyer_all_asset_rent"
        data-field="x_status_pay_half_price_2"
        data-value-separator="<?= $Grid->status_pay_half_price_2->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_pay_half_price_2->getPlaceHolder()) ?>"
        <?= $Grid->status_pay_half_price_2->editAttributes() ?>>
        <?= $Grid->status_pay_half_price_2->selectOptionListHtml("x{$Grid->RowIndex}_status_pay_half_price_2") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_pay_half_price_2->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_pay_half_price_2", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_2" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.status_pay_half_price_2.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_2", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_2", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.status_pay_half_price_2.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_pay_half_price_2" id="o<?= $Grid->RowIndex ?>_status_pay_half_price_2" value="<?= HtmlEncode($Grid->status_pay_half_price_2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_2" class="el_buyer_all_asset_rent_status_pay_half_price_2">
<span<?= $Grid->status_pay_half_price_2->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_pay_half_price_2->getDisplayValue($Grid->status_pay_half_price_2->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_pay_half_price_2" id="x<?= $Grid->RowIndex ?>_status_pay_half_price_2" value="<?= HtmlEncode($Grid->status_pay_half_price_2->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_2" class="el_buyer_all_asset_rent_status_pay_half_price_2">
<span<?= $Grid->status_pay_half_price_2->viewAttributes() ?>>
<?= $Grid->status_pay_half_price_2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_status_pay_half_price_2" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_status_pay_half_price_2" value="<?= HtmlEncode($Grid->status_pay_half_price_2->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_status_pay_half_price_2" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_status_pay_half_price_2" value="<?= HtmlEncode($Grid->status_pay_half_price_2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <td data-name="due_date_pay_half_price_2"<?= $Grid->due_date_pay_half_price_2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_2" class="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<input type="<?= $Grid->due_date_pay_half_price_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" value="<?= $Grid->due_date_pay_half_price_2->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date_pay_half_price_2->getPlaceHolder()) ?>"<?= $Grid->due_date_pay_half_price_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date_pay_half_price_2->getErrorMessage() ?></div>
<?php if (!$Grid->due_date_pay_half_price_2->ReadOnly && !$Grid->due_date_pay_half_price_2->Disabled && !isset($Grid->due_date_pay_half_price_2->EditAttrs["readonly"]) && !isset($Grid->due_date_pay_half_price_2->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentgrid", "x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" value="<?= HtmlEncode($Grid->due_date_pay_half_price_2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_2" class="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<input type="<?= $Grid->due_date_pay_half_price_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" value="<?= $Grid->due_date_pay_half_price_2->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date_pay_half_price_2->getPlaceHolder()) ?>"<?= $Grid->due_date_pay_half_price_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date_pay_half_price_2->getErrorMessage() ?></div>
<?php if (!$Grid->due_date_pay_half_price_2->ReadOnly && !$Grid->due_date_pay_half_price_2->Disabled && !isset($Grid->due_date_pay_half_price_2->EditAttrs["readonly"]) && !isset($Grid->due_date_pay_half_price_2->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentgrid", "x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_2" class="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<span<?= $Grid->due_date_pay_half_price_2->viewAttributes() ?>>
<?= $Grid->due_date_pay_half_price_2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" data-hidden="1" name="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="fbuyer_all_asset_rentgrid$x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" value="<?= HtmlEncode($Grid->due_date_pay_half_price_2->FormValue) ?>">
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" data-hidden="1" name="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="fbuyer_all_asset_rentgrid$o<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" value="<?= HtmlEncode($Grid->due_date_pay_half_price_2->OldValue) ?>">
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
loadjs.ready(["fbuyer_all_asset_rentgrid","load"], () => fbuyer_all_asset_rentgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_buyer_all_asset_rent", "data-rowtype" => ROWTYPE_ADD]);
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
<?php if ($Grid->asset_id->getSessionValue() != "") { ?>
<span id="el$rowindex$_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_asset_id" name="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode(FormatNumber($Grid->asset_id->CurrentValue, $Grid->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
    <select
        id="x<?= $Grid->RowIndex ?>_asset_id"
        name="x<?= $Grid->RowIndex ?>_asset_id"
        class="form-select ew-select<?= $Grid->asset_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_asset_id"
        data-table="buyer_all_asset_rent"
        data-field="x_asset_id"
        data-value-separator="<?= $Grid->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->asset_id->getPlaceHolder()) ?>"
        <?= $Grid->asset_id->editAttributes() ?>>
        <?= $Grid->asset_id->selectOptionListHtml("x{$Grid->RowIndex}_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->asset_id->getErrorMessage() ?></div>
<?= $Grid->asset_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_asset_id") ?>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_asset_id", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_asset_id", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
<span<?= $Grid->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->asset_id->getDisplayValue($Grid->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_asset_id" id="x<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_asset_id" id="o<?= $Grid->RowIndex ?>_asset_id" value="<?= HtmlEncode($Grid->asset_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->member_id->Visible) { // member_id ?>
        <td data-name="member_id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_member_id" class="el_buyer_all_asset_rent_member_id">
    <select
        id="x<?= $Grid->RowIndex ?>_member_id"
        name="x<?= $Grid->RowIndex ?>_member_id"
        class="form-select ew-select<?= $Grid->member_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_member_id"
        data-table="buyer_all_asset_rent"
        data-field="x_member_id"
        data-value-separator="<?= $Grid->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->member_id->getPlaceHolder()) ?>"
        <?= $Grid->member_id->editAttributes() ?>>
        <?= $Grid->member_id->selectOptionListHtml("x{$Grid->RowIndex}_member_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->member_id->getErrorMessage() ?></div>
<?= $Grid->member_id->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_member_id") ?>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_member_id", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.member_id.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_member_id", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_member_id" class="el_buyer_all_asset_rent_member_id">
<span<?= $Grid->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->member_id->getDisplayValue($Grid->member_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_member_id" id="x<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_member_id" id="o<?= $Grid->RowIndex ?>_member_id" value="<?= HtmlEncode($Grid->member_id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->one_time_status->Visible) { // one_time_status ?>
        <td data-name="one_time_status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_one_time_status" class="el_buyer_all_asset_rent_one_time_status">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->one_time_status->isInvalidClass() ?>" data-table="buyer_all_asset_rent" data-field="x_one_time_status" name="x<?= $Grid->RowIndex ?>_one_time_status[]" id="x<?= $Grid->RowIndex ?>_one_time_status_512539" value="1"<?= ConvertToBool($Grid->one_time_status->CurrentValue) ? " checked" : "" ?><?= $Grid->one_time_status->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->one_time_status->getErrorMessage() ?></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_one_time_status" class="el_buyer_all_asset_rent_one_time_status">
<span<?= $Grid->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->one_time_status->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_one_time_status" id="x<?= $Grid->RowIndex ?>_one_time_status" value="<?= HtmlEncode($Grid->one_time_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_one_time_status[]" id="o<?= $Grid->RowIndex ?>_one_time_status[]" value="<?= HtmlEncode($Grid->one_time_status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->half_price_1->Visible) { // half_price_1 ?>
        <td data-name="half_price_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_half_price_1" class="el_buyer_all_asset_rent_half_price_1">
<input type="<?= $Grid->half_price_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_half_price_1" id="x<?= $Grid->RowIndex ?>_half_price_1" data-table="buyer_all_asset_rent" data-field="x_half_price_1" value="<?= $Grid->half_price_1->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->half_price_1->getPlaceHolder()) ?>"<?= $Grid->half_price_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->half_price_1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_half_price_1" class="el_buyer_all_asset_rent_half_price_1">
<span<?= $Grid->half_price_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->half_price_1->getDisplayValue($Grid->half_price_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_half_price_1" id="x<?= $Grid->RowIndex ?>_half_price_1" value="<?= HtmlEncode($Grid->half_price_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_half_price_1" id="o<?= $Grid->RowIndex ?>_half_price_1" value="<?= HtmlEncode($Grid->half_price_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <td data-name="status_pay_half_price_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_status_pay_half_price_1" class="el_buyer_all_asset_rent_status_pay_half_price_1">
    <select
        id="x<?= $Grid->RowIndex ?>_status_pay_half_price_1"
        name="x<?= $Grid->RowIndex ?>_status_pay_half_price_1"
        class="form-select ew-select<?= $Grid->status_pay_half_price_1->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_1"
        data-table="buyer_all_asset_rent"
        data-field="x_status_pay_half_price_1"
        data-value-separator="<?= $Grid->status_pay_half_price_1->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_pay_half_price_1->getPlaceHolder()) ?>"
        <?= $Grid->status_pay_half_price_1->editAttributes() ?>>
        <?= $Grid->status_pay_half_price_1->selectOptionListHtml("x{$Grid->RowIndex}_status_pay_half_price_1") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_pay_half_price_1->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_pay_half_price_1", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_1" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.status_pay_half_price_1.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_1", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_1", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.status_pay_half_price_1.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_status_pay_half_price_1" class="el_buyer_all_asset_rent_status_pay_half_price_1">
<span<?= $Grid->status_pay_half_price_1->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_pay_half_price_1->getDisplayValue($Grid->status_pay_half_price_1->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_pay_half_price_1" id="x<?= $Grid->RowIndex ?>_status_pay_half_price_1" value="<?= HtmlEncode($Grid->status_pay_half_price_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_pay_half_price_1" id="o<?= $Grid->RowIndex ?>_status_pay_half_price_1" value="<?= HtmlEncode($Grid->status_pay_half_price_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <td data-name="due_date_pay_half_price_1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_due_date_pay_half_price_1" class="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<input type="<?= $Grid->due_date_pay_half_price_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" value="<?= $Grid->due_date_pay_half_price_1->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date_pay_half_price_1->getPlaceHolder()) ?>"<?= $Grid->due_date_pay_half_price_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date_pay_half_price_1->getErrorMessage() ?></div>
<?php if (!$Grid->due_date_pay_half_price_1->ReadOnly && !$Grid->due_date_pay_half_price_1->Disabled && !isset($Grid->due_date_pay_half_price_1->EditAttrs["readonly"]) && !isset($Grid->due_date_pay_half_price_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentgrid", "x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_due_date_pay_half_price_1" class="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<span<?= $Grid->due_date_pay_half_price_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->due_date_pay_half_price_1->getDisplayValue($Grid->due_date_pay_half_price_1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" value="<?= HtmlEncode($Grid->due_date_pay_half_price_1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" id="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_1" value="<?= HtmlEncode($Grid->due_date_pay_half_price_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->half_price_2->Visible) { // half_price_2 ?>
        <td data-name="half_price_2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_half_price_2" class="el_buyer_all_asset_rent_half_price_2">
<input type="<?= $Grid->half_price_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_half_price_2" id="x<?= $Grid->RowIndex ?>_half_price_2" data-table="buyer_all_asset_rent" data-field="x_half_price_2" value="<?= $Grid->half_price_2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->half_price_2->getPlaceHolder()) ?>"<?= $Grid->half_price_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->half_price_2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_half_price_2" class="el_buyer_all_asset_rent_half_price_2">
<span<?= $Grid->half_price_2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->half_price_2->getDisplayValue($Grid->half_price_2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_half_price_2" id="x<?= $Grid->RowIndex ?>_half_price_2" value="<?= HtmlEncode($Grid->half_price_2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_half_price_2" id="o<?= $Grid->RowIndex ?>_half_price_2" value="<?= HtmlEncode($Grid->half_price_2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <td data-name="status_pay_half_price_2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_status_pay_half_price_2" class="el_buyer_all_asset_rent_status_pay_half_price_2">
    <select
        id="x<?= $Grid->RowIndex ?>_status_pay_half_price_2"
        name="x<?= $Grid->RowIndex ?>_status_pay_half_price_2"
        class="form-select ew-select<?= $Grid->status_pay_half_price_2->isInvalidClass() ?>"
        data-select2-id="fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_2"
        data-table="buyer_all_asset_rent"
        data-field="x_status_pay_half_price_2"
        data-value-separator="<?= $Grid->status_pay_half_price_2->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->status_pay_half_price_2->getPlaceHolder()) ?>"
        <?= $Grid->status_pay_half_price_2->editAttributes() ?>>
        <?= $Grid->status_pay_half_price_2->selectOptionListHtml("x{$Grid->RowIndex}_status_pay_half_price_2") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->status_pay_half_price_2->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_all_asset_rentgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_status_pay_half_price_2", selectId: "fbuyer_all_asset_rentgrid_x<?= $Grid->RowIndex ?>_status_pay_half_price_2" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_all_asset_rentgrid.lists.status_pay_half_price_2.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_2", form: "fbuyer_all_asset_rentgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_status_pay_half_price_2", form: "fbuyer_all_asset_rentgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.status_pay_half_price_2.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_status_pay_half_price_2" class="el_buyer_all_asset_rent_status_pay_half_price_2">
<span<?= $Grid->status_pay_half_price_2->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_pay_half_price_2->getDisplayValue($Grid->status_pay_half_price_2->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_pay_half_price_2" id="x<?= $Grid->RowIndex ?>_status_pay_half_price_2" value="<?= HtmlEncode($Grid->status_pay_half_price_2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status_pay_half_price_2" id="o<?= $Grid->RowIndex ?>_status_pay_half_price_2" value="<?= HtmlEncode($Grid->status_pay_half_price_2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <td data-name="due_date_pay_half_price_2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_buyer_all_asset_rent_due_date_pay_half_price_2" class="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<input type="<?= $Grid->due_date_pay_half_price_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" value="<?= $Grid->due_date_pay_half_price_2->EditValue ?>" placeholder="<?= HtmlEncode($Grid->due_date_pay_half_price_2->getPlaceHolder()) ?>"<?= $Grid->due_date_pay_half_price_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->due_date_pay_half_price_2->getErrorMessage() ?></div>
<?php if (!$Grid->due_date_pay_half_price_2->ReadOnly && !$Grid->due_date_pay_half_price_2->Disabled && !isset($Grid->due_date_pay_half_price_2->EditAttrs["readonly"]) && !isset($Grid->due_date_pay_half_price_2->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentgrid", "x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_buyer_all_asset_rent_due_date_pay_half_price_2" class="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<span<?= $Grid->due_date_pay_half_price_2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->due_date_pay_half_price_2->getDisplayValue($Grid->due_date_pay_half_price_2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="x<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" value="<?= HtmlEncode($Grid->due_date_pay_half_price_2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" id="o<?= $Grid->RowIndex ?>_due_date_pay_half_price_2" value="<?= HtmlEncode($Grid->due_date_pay_half_price_2->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fbuyer_all_asset_rentgrid","load"], () => fbuyer_all_asset_rentgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fbuyer_all_asset_rentgrid">
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
    ew.addEventHandlers("buyer_all_asset_rent");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    var rowCount = $('#tbl_buyer_all_asset_rentlist >tbody >tr').length;
    if(rowCount >= 1){
        $(".ew-add-edit-option").remove()
    }
});
</script>
<?php } ?>
