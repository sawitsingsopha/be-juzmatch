<?php

namespace PHPMaker2022\juzmatch;

// Page object
$JuzcalculatorList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { juzcalculator: currentTable } });
var currentForm, currentPageID;
var fjuzcalculatorlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fjuzcalculatorlist = new ew.Form("fjuzcalculatorlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fjuzcalculatorlist;
    fjuzcalculatorlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fjuzcalculatorlist");
});
var fjuzcalculatorsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fjuzcalculatorsrch = new ew.Form("fjuzcalculatorsrch", "list");
    currentSearchForm = fjuzcalculatorsrch;

    // Add fields
    var fields = currentTable.fields;
    fjuzcalculatorsrch.addFields([
        ["income_all", [ew.Validators.float], fields.income_all.isInvalid],
        ["outcome_all", [ew.Validators.float], fields.outcome_all.isInvalid],
        ["rent_price", [ew.Validators.float], fields.rent_price.isInvalid],
        ["asset_price", [ew.Validators.float], fields.asset_price.isInvalid],
        ["cdate", [ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["y_cdate", [ew.Validators.between], false]
    ]);

    // Validate form
    fjuzcalculatorsrch.validate = function () {
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
    fjuzcalculatorsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fjuzcalculatorsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists

    // Filters
    fjuzcalculatorsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fjuzcalculatorsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "buyer") {
    if ($Page->MasterRecordExists) {
        include_once "views/BuyerMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fjuzcalculatorsrch" id="fjuzcalculatorsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fjuzcalculatorsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="juzcalculator">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->income_all->Visible) { // income_all ?>
<?php
if (!$Page->income_all->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_income_all" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->income_all->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_income_all" class="ew-search-caption ew-label"><?= $Page->income_all->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_income_all" id="z_income_all" value="=">
</div>
        </div>
        <div id="el_juzcalculator_income_all" class="ew-search-field">
<input type="<?= $Page->income_all->getInputTextType() ?>" name="x_income_all" id="x_income_all" data-table="juzcalculator" data-field="x_income_all" value="<?= $Page->income_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->income_all->getPlaceHolder()) ?>"<?= $Page->income_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->income_all->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->outcome_all->Visible) { // outcome_all ?>
<?php
if (!$Page->outcome_all->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_outcome_all" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->outcome_all->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_outcome_all" class="ew-search-caption ew-label"><?= $Page->outcome_all->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_outcome_all" id="z_outcome_all" value="=">
</div>
        </div>
        <div id="el_juzcalculator_outcome_all" class="ew-search-field">
<input type="<?= $Page->outcome_all->getInputTextType() ?>" name="x_outcome_all" id="x_outcome_all" data-table="juzcalculator" data-field="x_outcome_all" value="<?= $Page->outcome_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->outcome_all->getPlaceHolder()) ?>"<?= $Page->outcome_all->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->outcome_all->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->rent_price->Visible) { // rent_price ?>
<?php
if (!$Page->rent_price->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_rent_price" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->rent_price->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_rent_price" class="ew-search-caption ew-label"><?= $Page->rent_price->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_rent_price" id="z_rent_price" value="=">
</div>
        </div>
        <div id="el_juzcalculator_rent_price" class="ew-search-field">
<input type="<?= $Page->rent_price->getInputTextType() ?>" name="x_rent_price" id="x_rent_price" data-table="juzcalculator" data-field="x_rent_price" value="<?= $Page->rent_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rent_price->getPlaceHolder()) ?>"<?= $Page->rent_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->rent_price->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
<?php
if (!$Page->asset_price->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_price" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_price->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_price" class="ew-search-caption ew-label"><?= $Page->asset_price->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_asset_price" id="z_asset_price" value="=">
</div>
        </div>
        <div id="el_juzcalculator_asset_price" class="ew-search-field">
<input type="<?= $Page->asset_price->getInputTextType() ?>" name="x_asset_price" id="x_asset_price" data-table="juzcalculator" data-field="x_asset_price" value="<?= $Page->asset_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->asset_price->getPlaceHolder()) ?>"<?= $Page->asset_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->asset_price->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
<?php
if (!$Page->cdate->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cdate" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->cdate->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cdate" class="ew-search-caption ew-label"><?= $Page->cdate->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_cdate" id="z_cdate" value="BETWEEN">
</div>
        </div>
        <div id="el_juzcalculator_cdate" class="ew-search-field">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="juzcalculator" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="45" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fjuzcalculatorsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fjuzcalculatorsrch", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_juzcalculator_cdate" class="ew-search-field2">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="y_cdate" id="y_cdate" data-table="juzcalculator" data-field="x_cdate" value="<?= $Page->cdate->EditValue2 ?>" maxlength="45" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fjuzcalculatorsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fjuzcalculatorsrch", "y_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> juzcalculator">
<form name="fjuzcalculatorlist" id="fjuzcalculatorlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="juzcalculator">
<?php if ($Page->getCurrentMasterTable() == "buyer" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_juzcalculator" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_juzcalculatorlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->income_all->Visible) { // income_all ?>
        <th data-name="income_all" class="<?= $Page->income_all->headerCellClass() ?>"><div id="elh_juzcalculator_income_all" class="juzcalculator_income_all"><?= $Page->renderFieldHeader($Page->income_all) ?></div></th>
<?php } ?>
<?php if ($Page->outcome_all->Visible) { // outcome_all ?>
        <th data-name="outcome_all" class="<?= $Page->outcome_all->headerCellClass() ?>"><div id="elh_juzcalculator_outcome_all" class="juzcalculator_outcome_all"><?= $Page->renderFieldHeader($Page->outcome_all) ?></div></th>
<?php } ?>
<?php if ($Page->rent_price->Visible) { // rent_price ?>
        <th data-name="rent_price" class="<?= $Page->rent_price->headerCellClass() ?>"><div id="elh_juzcalculator_rent_price" class="juzcalculator_rent_price"><?= $Page->renderFieldHeader($Page->rent_price) ?></div></th>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <th data-name="asset_price" class="<?= $Page->asset_price->headerCellClass() ?>"><div id="elh_juzcalculator_asset_price" class="juzcalculator_asset_price"><?= $Page->renderFieldHeader($Page->asset_price) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_juzcalculator_cdate" class="juzcalculator_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_juzcalculator",
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
    <?php if ($Page->income_all->Visible) { // income_all ?>
        <td data-name="income_all"<?= $Page->income_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_juzcalculator_income_all" class="el_juzcalculator_income_all">
<span<?= $Page->income_all->viewAttributes() ?>>
<?= $Page->income_all->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->outcome_all->Visible) { // outcome_all ?>
        <td data-name="outcome_all"<?= $Page->outcome_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_juzcalculator_outcome_all" class="el_juzcalculator_outcome_all">
<span<?= $Page->outcome_all->viewAttributes() ?>>
<?= $Page->outcome_all->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rent_price->Visible) { // rent_price ?>
        <td data-name="rent_price"<?= $Page->rent_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_juzcalculator_rent_price" class="el_juzcalculator_rent_price">
<span<?= $Page->rent_price->viewAttributes() ?>>
<?= $Page->rent_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_price->Visible) { // asset_price ?>
        <td data-name="asset_price"<?= $Page->asset_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_juzcalculator_asset_price" class="el_juzcalculator_asset_price">
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_juzcalculator_cdate" class="el_juzcalculator_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
        container: "gmp_juzcalculator",
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
    ew.addEventHandlers("juzcalculator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
