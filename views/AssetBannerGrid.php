<?php

namespace PHPMaker2022\juzmatch;

// Set up and run Grid object
$Grid = Container("AssetBannerGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fasset_bannergrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_bannergrid = new ew.Form("fasset_bannergrid", "grid");
    fasset_bannergrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { asset_banner: currentTable } });
    var fields = currentTable.fields;
    fasset_bannergrid.addFields([
        ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid]
    ]);

    // Check empty row
    fasset_bannergrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["image",false],["order_by",false],["isactive",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fasset_bannergrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_bannergrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_bannergrid.lists.isactive = <?= $Grid->isactive->toClientList($Grid) ?>;
    loadjs.done("fasset_bannergrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_banner">
<div id="fasset_bannergrid" class="ew-form ew-list-form">
<div id="gmp_asset_banner" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_asset_bannergrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Grid->image->headerCellClass() ?>"><div id="elh_asset_banner_image" class="asset_banner_image"><?= $Grid->renderFieldHeader($Grid->image) ?></div></th>
<?php } ?>
<?php if ($Grid->order_by->Visible) { // order_by ?>
        <th data-name="order_by" class="<?= $Grid->order_by->headerCellClass() ?>"><div id="elh_asset_banner_order_by" class="asset_banner_order_by"><?= $Grid->renderFieldHeader($Grid->order_by) ?></div></th>
<?php } ?>
<?php if ($Grid->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Grid->isactive->headerCellClass() ?>"><div id="elh_asset_banner_isactive" class="asset_banner_isactive"><?= $Grid->renderFieldHeader($Grid->isactive) ?></div></th>
<?php } ?>
<?php if ($Grid->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Grid->cdate->headerCellClass() ?>"><div id="elh_asset_banner_cdate" class="asset_banner_cdate"><?= $Grid->renderFieldHeader($Grid->cdate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_asset_banner",
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
    <?php if ($Grid->image->Visible) { // image ?>
        <td data-name="image"<?= $Grid->image->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_banner_image" class="el_asset_banner_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Grid->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x<?= $Grid->RowIndex ?>_image" id="x<?= $Grid->RowIndex ?>_image" lang="<?= CurrentLanguageID() ?>"<?= $Grid->image->editAttributes() ?><?= ($Grid->image->ReadOnly || $Grid->image->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_image" id= "fs_x<?= $Grid->RowIndex ?>_image" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_image" id= "fx_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_image" id= "fm_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_banner_image" class="el_asset_banner_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x<?= $Grid->RowIndex ?>_image" id="x<?= $Grid->RowIndex ?>_image" lang="<?= CurrentLanguageID() ?>"<?= $Grid->image->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_image" id= "fs_x<?= $Grid->RowIndex ?>_image" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_image" id= "fx_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_image" id= "fm_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="asset_banner" data-field="x_image" data-hidden="1" name="o<?= $Grid->RowIndex ?>_image" id="o<?= $Grid->RowIndex ?>_image" value="<?= HtmlEncode($Grid->image->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_image" class="el_asset_banner_image">
<span>
<?= GetFileViewTag($Grid->image, $Grid->image->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_image" class="el_asset_banner_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x<?= $Grid->RowIndex ?>_image" id="x<?= $Grid->RowIndex ?>_image" lang="<?= CurrentLanguageID() ?>"<?= $Grid->image->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_image") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_image" id= "fs_x<?= $Grid->RowIndex ?>_image" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_image" id= "fx_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_image" id= "fm_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_image" class="el_asset_banner_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x<?= $Grid->RowIndex ?>_image" id="x<?= $Grid->RowIndex ?>_image" lang="<?= CurrentLanguageID() ?>"<?= $Grid->image->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_image") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_image" id= "fs_x<?= $Grid->RowIndex ?>_image" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_image" id= "fx_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_image" id= "fm_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->order_by->Visible) { // order_by ?>
        <td data-name="order_by"<?= $Grid->order_by->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_order_by" class="el_asset_banner_order_by">
<input type="<?= $Grid->order_by->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" data-table="asset_banner" data-field="x_order_by" value="<?= $Grid->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->order_by->getPlaceHolder()) ?>"<?= $Grid->order_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->order_by->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_banner" data-field="x_order_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_order_by" id="o<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_order_by" class="el_asset_banner_order_by">
<input type="<?= $Grid->order_by->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" data-table="asset_banner" data-field="x_order_by" value="<?= $Grid->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->order_by->getPlaceHolder()) ?>"<?= $Grid->order_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->order_by->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_order_by" class="el_asset_banner_order_by">
<span<?= $Grid->order_by->viewAttributes() ?>>
<?= $Grid->order_by->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_banner" data-field="x_order_by" data-hidden="1" name="fasset_bannergrid$x<?= $Grid->RowIndex ?>_order_by" id="fasset_bannergrid$x<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->FormValue) ?>">
<input type="hidden" data-table="asset_banner" data-field="x_order_by" data-hidden="1" name="fasset_bannergrid$o<?= $Grid->RowIndex ?>_order_by" id="fasset_bannergrid$o<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive"<?= $Grid->isactive->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_isactive" class="el_asset_banner_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_banner" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_isactive"
    name="x<?= $Grid->RowIndex ?>_isactive"
    value="<?= HtmlEncode($Grid->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_isactive"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->isactive->isInvalidClass() ?>"
    data-table="asset_banner"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="asset_banner" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_isactive" class="el_asset_banner_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_banner" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_isactive"
    name="x<?= $Grid->RowIndex ?>_isactive"
    value="<?= HtmlEncode($Grid->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_isactive"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->isactive->isInvalidClass() ?>"
    data-table="asset_banner"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_isactive" class="el_asset_banner_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<?= $Grid->isactive->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_banner" data-field="x_isactive" data-hidden="1" name="fasset_bannergrid$x<?= $Grid->RowIndex ?>_isactive" id="fasset_bannergrid$x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<input type="hidden" data-table="asset_banner" data-field="x_isactive" data-hidden="1" name="fasset_bannergrid$o<?= $Grid->RowIndex ?>_isactive" id="fasset_bannergrid$o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Grid->cdate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="asset_banner" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_asset_banner_cdate" class="el_asset_banner_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<?= $Grid->cdate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="asset_banner" data-field="x_cdate" data-hidden="1" name="fasset_bannergrid$x<?= $Grid->RowIndex ?>_cdate" id="fasset_bannergrid$x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<input type="hidden" data-table="asset_banner" data-field="x_cdate" data-hidden="1" name="fasset_bannergrid$o<?= $Grid->RowIndex ?>_cdate" id="fasset_bannergrid$o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
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
loadjs.ready(["fasset_bannergrid","load"], () => fasset_bannergrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_asset_banner", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->image->Visible) { // image ?>
        <td data-name="image">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_banner_image" class="el_asset_banner_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Grid->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x<?= $Grid->RowIndex ?>_image" id="x<?= $Grid->RowIndex ?>_image" lang="<?= CurrentLanguageID() ?>"<?= $Grid->image->editAttributes() ?><?= ($Grid->image->ReadOnly || $Grid->image->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_image" id= "fs_x<?= $Grid->RowIndex ?>_image" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_image" id= "fx_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_image" id= "fm_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_banner_image" class="el_asset_banner_image">
<div id="fd_x<?= $Grid->RowIndex ?>_image">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x<?= $Grid->RowIndex ?>_image" id="x<?= $Grid->RowIndex ?>_image" lang="<?= CurrentLanguageID() ?>"<?= $Grid->image->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_image" id= "fn_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_image" id= "fa_x<?= $Grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_image" id= "fs_x<?= $Grid->RowIndex ?>_image" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_image" id= "fx_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_image" id= "fm_x<?= $Grid->RowIndex ?>_image" value="<?= $Grid->image->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="asset_banner" data-field="x_image" data-hidden="1" name="o<?= $Grid->RowIndex ?>_image" id="o<?= $Grid->RowIndex ?>_image" value="<?= HtmlEncode($Grid->image->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->order_by->Visible) { // order_by ?>
        <td data-name="order_by">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_banner_order_by" class="el_asset_banner_order_by">
<input type="<?= $Grid->order_by->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" data-table="asset_banner" data-field="x_order_by" value="<?= $Grid->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->order_by->getPlaceHolder()) ?>"<?= $Grid->order_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->order_by->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_banner_order_by" class="el_asset_banner_order_by">
<span<?= $Grid->order_by->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->order_by->getDisplayValue($Grid->order_by->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_banner" data-field="x_order_by" data-hidden="1" name="x<?= $Grid->RowIndex ?>_order_by" id="x<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_banner" data-field="x_order_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_order_by" id="o<?= $Grid->RowIndex ?>_order_by" value="<?= HtmlEncode($Grid->order_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isactive->Visible) { // isactive ?>
        <td data-name="isactive">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_asset_banner_isactive" class="el_asset_banner_isactive">
<template id="tp_x<?= $Grid->RowIndex ?>_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_banner" data-field="x_isactive" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive"<?= $Grid->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_isactive"
    name="x<?= $Grid->RowIndex ?>_isactive"
    value="<?= HtmlEncode($Grid->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_isactive"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->isactive->isInvalidClass() ?>"
    data-table="asset_banner"
    data-field="x_isactive"
    data-value-separator="<?= $Grid->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Grid->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->isactive->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_asset_banner_isactive" class="el_asset_banner_isactive">
<span<?= $Grid->isactive->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->isactive->getDisplayValue($Grid->isactive->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_banner" data-field="x_isactive" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isactive" id="x<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_banner" data-field="x_isactive" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isactive" id="o<?= $Grid->RowIndex ?>_isactive" value="<?= HtmlEncode($Grid->isactive->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cdate->Visible) { // cdate ?>
        <td data-name="cdate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_asset_banner_cdate" class="el_asset_banner_cdate">
<span<?= $Grid->cdate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cdate->getDisplayValue($Grid->cdate->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="asset_banner" data-field="x_cdate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cdate" id="x<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="asset_banner" data-field="x_cdate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cdate" id="o<?= $Grid->RowIndex ?>_cdate" value="<?= HtmlEncode($Grid->cdate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fasset_bannergrid","load"], () => fasset_bannergrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fasset_bannergrid">
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
    ew.addEventHandlers("asset_banner");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
