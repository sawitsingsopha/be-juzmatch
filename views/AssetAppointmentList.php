<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetAppointmentList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_appointment: currentTable } });
var currentForm, currentPageID;
var fasset_appointmentlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_appointmentlist = new ew.Form("fasset_appointmentlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fasset_appointmentlist;
    fasset_appointmentlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fasset_appointmentlist");
});
var fasset_appointmentsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fasset_appointmentsrch = new ew.Form("fasset_appointmentsrch", "list");
    currentSearchForm = fasset_appointmentsrch;

    // Add fields
    var fields = currentTable.fields;
    fasset_appointmentsrch.addFields([
        ["asset_id", [], fields.asset_id.isInvalid],
        ["member_id", [], fields.member_id.isInvalid],
        ["date", [ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
        ["y_date", [ew.Validators.between], false],
        ["time", [], fields.time.isInvalid],
        ["status", [], fields.status.isInvalid]
    ]);

    // Validate form
    fasset_appointmentsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fasset_appointmentsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_appointmentsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_appointmentsrch.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fasset_appointmentsrch.lists.member_id = <?= $Page->member_id->toClientList($Page) ?>;
    fasset_appointmentsrch.lists.status = <?= $Page->status->toClientList($Page) ?>;

    // Filters
    fasset_appointmentsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fasset_appointmentsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if ($Security->canImport()) { ?>
    <?php if (!$Page->isExport()) { ?>
    <div class="btn-toolbar ew-toolbar">
    <?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
    <?php $Page->ExportOptions->render("body") ?>
    <?php } ?>
    <?php if ($Page->ImportOptions->visible()) { ?>
    <?php $Page->ImportOptions->render("body") ?>
    <?php } ?>
    <?php if ($Page->SearchOptions->visible()) { ?>
    <?php $Page->SearchOptions->render("body") ?>
    <?php } ?>
    <?php if ($Page->FilterOptions->visible()) { ?>
    <?php $Page->FilterOptions->render("body") ?>
    <?php } ?>
    </div>
    <?php } ?>
<?php } ?>

<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fasset_appointmentsrch" id="fasset_appointmentsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fasset_appointmentsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="asset_appointment">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
<?php
if (!$Page->asset_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_id->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_id" class="ew-search-caption ew-label"><?= $Page->asset_id->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_asset_id" id="z_asset_id" value="=">
</div>
        </div>
        <div id="el_asset_appointment_asset_id" class="ew-search-field">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_appointmentsrch_x_asset_id"
        data-table="asset_appointment"
        data-field="x_asset_id"
        data-value-separator="<?= $Page->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"
        <?= $Page->asset_id->editAttributes() ?>>
        <?= $Page->asset_id->selectOptionListHtml("x_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage(false) ?></div>
<?= $Page->asset_id->Lookup->getParamTag($Page, "p_x_asset_id") ?>
<script>
loadjs.ready("fasset_appointmentsrch", function() {
    var options = { name: "x_asset_id", selectId: "fasset_appointmentsrch_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_appointmentsrch.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fasset_appointmentsrch" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fasset_appointmentsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_appointment.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
<?php
if (!$Page->member_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_member_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->member_id->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_member_id" class="ew-search-caption ew-label"><?= $Page->member_id->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_member_id" id="z_member_id" value="=">
</div>
        </div>
        <div id="el_asset_appointment_member_id" class="ew-search-field">
    <select
        id="x_member_id"
        name="x_member_id"
        class="form-control ew-select<?= $Page->member_id->isInvalidClass() ?>"
        data-select2-id="fasset_appointmentsrch_x_member_id"
        data-table="asset_appointment"
        data-field="x_member_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->member_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"
        <?= $Page->member_id->editAttributes() ?>>
        <?= $Page->member_id->selectOptionListHtml("x_member_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->member_id->getErrorMessage(false) ?></div>
<?= $Page->member_id->Lookup->getParamTag($Page, "p_x_member_id") ?>
<script>
loadjs.ready("fasset_appointmentsrch", function() {
    var options = { name: "x_member_id", selectId: "fasset_appointmentsrch_x_member_id" };
    if (fasset_appointmentsrch.lists.member_id.lookupOptions.length) {
        options.data = { id: "x_member_id", form: "fasset_appointmentsrch" };
    } else {
        options.ajax = { id: "x_member_id", form: "fasset_appointmentsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.asset_appointment.fields.member_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
<?php
if (!$Page->date->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_date" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->date->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_date" class="ew-search-caption ew-label"><?= $Page->date->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_date" id="z_date" value="BETWEEN">
</div>
        </div>
        <div id="el_asset_appointment_date" class="ew-search-field">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="asset_appointment" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>"<?= $Page->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage(false) ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_appointmentsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_appointmentsrch", "x_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_asset_appointment_date" class="ew-search-field2">
<input type="<?= $Page->date->getInputTextType() ?>" name="y_date" id="y_date" data-table="asset_appointment" data-field="x_date" value="<?= $Page->date->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>"<?= $Page->date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage(false) ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_appointmentsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_appointmentsrch", "y_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
<?php
if (!$Page->status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_status" class="ew-search-caption ew-label"><?= $Page->status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</div>
        </div>
        <div id="el_asset_appointment_status" class="ew-search-field">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="fasset_appointmentsrch_x_status"
        data-table="asset_appointment"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fasset_appointmentsrch", function() {
    var options = { name: "x_status", selectId: "fasset_appointmentsrch_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_appointmentsrch.lists.status.lookupOptions.length) {
        options.data = { id: "x_status", form: "fasset_appointmentsrch" };
    } else {
        options.ajax = { id: "x_status", form: "fasset_appointmentsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_appointment.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset_appointment">
<form name="fasset_appointmentlist" id="fasset_appointmentlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_appointment">
<div id="gmp_asset_appointment" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_asset_appointmentlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_asset_appointment_asset_id" class="asset_appointment_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Page->member_id->headerCellClass() ?>"><div id="elh_asset_appointment_member_id" class="asset_appointment_member_id"><?= $Page->renderFieldHeader($Page->member_id) ?></div></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th data-name="date" class="<?= $Page->date->headerCellClass() ?>"><div id="elh_asset_appointment_date" class="asset_appointment_date"><?= $Page->renderFieldHeader($Page->date) ?></div></th>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <th data-name="time" class="<?= $Page->time->headerCellClass() ?>"><div id="elh_asset_appointment_time" class="asset_appointment_time"><?= $Page->renderFieldHeader($Page->time) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_asset_appointment_status" class="asset_appointment_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_asset_appointment",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_appointment_asset_id" class="el_asset_appointment_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_appointment_member_id" class="el_asset_appointment_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date->Visible) { // date ?>
        <td data-name="date"<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_appointment_date" class="el_asset_appointment_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->time->Visible) { // time ?>
        <td data-name="time"<?= $Page->time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_appointment_time" class="el_asset_appointment_time">
<span<?= $Page->time->viewAttributes() ?>>
<?= $Page->time->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_appointment_status" class="el_asset_appointment_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_asset_appointment",
        width: "100%",
        height: "500px"
    });
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("asset_appointment");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
