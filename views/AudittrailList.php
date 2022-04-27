<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AudittrailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { audittrail: currentTable } });
var currentForm, currentPageID;
var faudittraillist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    faudittraillist = new ew.Form("faudittraillist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = faudittraillist;
    faudittraillist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("faudittraillist");
});
var faudittrailsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    faudittrailsrch = new ew.Form("faudittrailsrch", "list");
    currentSearchForm = faudittrailsrch;

    // Add fields
    var fields = currentTable.fields;
    faudittrailsrch.addFields([
        ["datetime", [ew.Validators.datetime(fields.datetime.clientFormatPattern)], fields.datetime.isInvalid],
        ["y_datetime", [ew.Validators.between], false],
        ["script", [], fields.script.isInvalid],
        ["user", [], fields.user.isInvalid],
        ["_action", [], fields._action.isInvalid],
        ["_table", [], fields._table.isInvalid],
        ["field", [], fields.field.isInvalid]
    ]);

    // Validate form
    faudittrailsrch.validate = function () {
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
    faudittrailsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    faudittrailsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    faudittrailsrch.lists.user = <?= $Page->user->toClientList($Page) ?>;
    faudittrailsrch.lists._action = <?= $Page->_action->toClientList($Page) ?>;

    // Filters
    faudittrailsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("faudittrailsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
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
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="faudittrailsrch" id="faudittrailsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="faudittrailsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="audittrail">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->datetime->Visible) { // datetime ?>
<?php
if (!$Page->datetime->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_datetime" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->datetime->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_datetime" class="ew-search-caption ew-label"><?= $Page->datetime->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_datetime" id="z_datetime" value="BETWEEN">
</div>
        </div>
        <div id="el_audittrail_datetime" class="ew-search-field">
<input type="<?= $Page->datetime->getInputTextType() ?>" name="x_datetime" id="x_datetime" data-table="audittrail" data-field="x_datetime" value="<?= $Page->datetime->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->datetime->getPlaceHolder()) ?>"<?= $Page->datetime->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->datetime->getErrorMessage(false) ?></div>
<?php if (!$Page->datetime->ReadOnly && !$Page->datetime->Disabled && !isset($Page->datetime->EditAttrs["readonly"]) && !isset($Page->datetime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["faudittrailsrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
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
    ew.createDateTimePicker("faudittrailsrch", "x_datetime", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_audittrail_datetime" class="ew-search-field2">
<input type="<?= $Page->datetime->getInputTextType() ?>" name="y_datetime" id="y_datetime" data-table="audittrail" data-field="x_datetime" value="<?= $Page->datetime->EditValue2 ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->datetime->getPlaceHolder()) ?>"<?= $Page->datetime->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->datetime->getErrorMessage(false) ?></div>
<?php if (!$Page->datetime->ReadOnly && !$Page->datetime->Disabled && !isset($Page->datetime->EditAttrs["readonly"]) && !isset($Page->datetime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["faudittrailsrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
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
    ew.createDateTimePicker("faudittrailsrch", "y_datetime", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
<?php
if (!$Page->user->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_user" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->user->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_user" class="ew-search-caption ew-label"><?= $Page->user->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_user" id="z_user" value="LIKE">
</div>
        </div>
        <div id="el_audittrail_user" class="ew-search-field">
    <select
        id="x_user"
        name="x_user"
        class="form-select ew-select<?= $Page->user->isInvalidClass() ?>"
        data-select2-id="faudittrailsrch_x_user"
        data-table="audittrail"
        data-field="x_user"
        data-value-separator="<?= $Page->user->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user->getPlaceHolder()) ?>"
        <?= $Page->user->editAttributes() ?>>
        <?= $Page->user->selectOptionListHtml("x_user") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user->getErrorMessage(false) ?></div>
<?= $Page->user->Lookup->getParamTag($Page, "p_x_user") ?>
<script>
loadjs.ready("faudittrailsrch", function() {
    var options = { name: "x_user", selectId: "faudittrailsrch_x_user" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faudittrailsrch.lists.user.lookupOptions.length) {
        options.data = { id: "x_user", form: "faudittrailsrch" };
    } else {
        options.ajax = { id: "x_user", form: "faudittrailsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.audittrail.fields.user.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
<?php
if (!$Page->_action->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs__action" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->_action->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x__action" class="ew-search-caption ew-label"><?= $Page->_action->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__action" id="z__action" value="LIKE">
</div>
        </div>
        <div id="el_audittrail__action" class="ew-search-field">
    <select
        id="x__action"
        name="x__action"
        class="form-select ew-select<?= $Page->_action->isInvalidClass() ?>"
        data-select2-id="faudittrailsrch_x__action"
        data-table="audittrail"
        data-field="x__action"
        data-value-separator="<?= $Page->_action->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_action->getPlaceHolder()) ?>"
        <?= $Page->_action->editAttributes() ?>>
        <?= $Page->_action->selectOptionListHtml("x__action") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->_action->getErrorMessage(false) ?></div>
<script>
loadjs.ready("faudittrailsrch", function() {
    var options = { name: "x__action", selectId: "faudittrailsrch_x__action" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faudittrailsrch.lists._action.lookupOptions.length) {
        options.data = { id: "x__action", form: "faudittrailsrch" };
    } else {
        options.ajax = { id: "x__action", form: "faudittrailsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.audittrail.fields._action.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->_table->Visible) { // table ?>
<?php
if (!$Page->_table->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs__table" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->_table->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x__table" class="ew-search-caption ew-label"><?= $Page->_table->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__table" id="z__table" value="LIKE">
</div>
        </div>
        <div id="el_audittrail__table" class="ew-search-field">
<input type="<?= $Page->_table->getInputTextType() ?>" name="x__table" id="x__table" data-table="audittrail" data-field="x__table" value="<?= $Page->_table->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_table->getPlaceHolder()) ?>"<?= $Page->_table->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_table->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->field->Visible) { // field ?>
<?php
if (!$Page->field->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_field" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->field->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_field" class="ew-search-caption ew-label"><?= $Page->field->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_field" id="z_field" value="LIKE">
</div>
        </div>
        <div id="el_audittrail_field" class="ew-search-field">
<input type="<?= $Page->field->getInputTextType() ?>" name="x_field" id="x_field" data-table="audittrail" data-field="x_field" value="<?= $Page->field->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->field->getPlaceHolder()) ?>"<?= $Page->field->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->field->getErrorMessage(false) ?></div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> audittrail">
<form name="faudittraillist" id="faudittraillist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="audittrail">
<div id="gmp_audittrail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_audittraillist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->datetime->Visible) { // datetime ?>
        <th data-name="datetime" class="<?= $Page->datetime->headerCellClass() ?>"><div id="elh_audittrail_datetime" class="audittrail_datetime"><?= $Page->renderFieldHeader($Page->datetime) ?></div></th>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
        <th data-name="script" class="<?= $Page->script->headerCellClass() ?>"><div id="elh_audittrail_script" class="audittrail_script"><?= $Page->renderFieldHeader($Page->script) ?></div></th>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
        <th data-name="user" class="<?= $Page->user->headerCellClass() ?>"><div id="elh_audittrail_user" class="audittrail_user"><?= $Page->renderFieldHeader($Page->user) ?></div></th>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
        <th data-name="_action" class="<?= $Page->_action->headerCellClass() ?>"><div id="elh_audittrail__action" class="audittrail__action"><?= $Page->renderFieldHeader($Page->_action) ?></div></th>
<?php } ?>
<?php if ($Page->_table->Visible) { // table ?>
        <th data-name="_table" class="<?= $Page->_table->headerCellClass() ?>"><div id="elh_audittrail__table" class="audittrail__table"><?= $Page->renderFieldHeader($Page->_table) ?></div></th>
<?php } ?>
<?php if ($Page->field->Visible) { // field ?>
        <th data-name="field" class="<?= $Page->field->headerCellClass() ?>"><div id="elh_audittrail_field" class="audittrail_field"><?= $Page->renderFieldHeader($Page->field) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_audittrail",
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
    <?php if ($Page->datetime->Visible) { // datetime ?>
        <td data-name="datetime"<?= $Page->datetime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_audittrail_datetime" class="el_audittrail_datetime">
<span<?= $Page->datetime->viewAttributes() ?>>
<?= $Page->datetime->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->script->Visible) { // script ?>
        <td data-name="script"<?= $Page->script->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_audittrail_script" class="el_audittrail_script">
<span<?= $Page->script->viewAttributes() ?>>
<?= $Page->script->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user->Visible) { // user ?>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_audittrail_user" class="el_audittrail_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_action->Visible) { // action ?>
        <td data-name="_action"<?= $Page->_action->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_audittrail__action" class="el_audittrail__action">
<span<?= $Page->_action->viewAttributes() ?>>
<?= $Page->_action->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_table->Visible) { // table ?>
        <td data-name="_table"<?= $Page->_table->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_audittrail__table" class="el_audittrail__table">
<span<?= $Page->_table->viewAttributes() ?>>
<?= $Page->_table->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->field->Visible) { // field ?>
        <td data-name="field"<?= $Page->field->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_audittrail_field" class="el_audittrail_field">
<span<?= $Page->field->viewAttributes() ?>>
<?= $Page->field->getViewValue() ?></span>
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
        container: "gmp_audittrail",
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
    ew.addEventHandlers("audittrail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
