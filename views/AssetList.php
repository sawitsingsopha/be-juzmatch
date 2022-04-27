<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetList = &$Page;
?>

<style>
    th[data-name="details"],
    td[data-name="details"]{
        display:none;
    }
</style>

<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset: currentTable } });
var currentForm, currentPageID;
var fassetlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fassetlist = new ew.Form("fassetlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fassetlist;
    fassetlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fassetlist");
});
var fassetsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fassetsrch = new ew.Form("fassetsrch", "list");
    currentSearchForm = fassetsrch;

    // Add fields
    var fields = currentTable.fields;
    fassetsrch.addFields([
        ["_title", [], fields._title.isInvalid],
        ["brand_id", [], fields.brand_id.isInvalid],
        ["asset_code", [], fields.asset_code.isInvalid],
        ["asset_status", [], fields.asset_status.isInvalid],
        ["isactive", [], fields.isactive.isInvalid],
        ["price_mark", [], fields.price_mark.isInvalid],
        ["usable_area", [], fields.usable_area.isInvalid],
        ["land_size", [], fields.land_size.isInvalid],
        ["count_view", [], fields.count_view.isInvalid],
        ["count_favorite", [], fields.count_favorite.isInvalid],
        ["expired_date", [ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["y_expired_date", [ew.Validators.between], false],
        ["cdate", [ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["y_cdate", [ew.Validators.between], false]
    ]);

    // Validate form
    fassetsrch.validate = function () {
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
    fassetsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fassetsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fassetsrch.lists.brand_id = <?= $Page->brand_id->toClientList($Page) ?>;
    fassetsrch.lists.asset_status = <?= $Page->asset_status->toClientList($Page) ?>;
    fassetsrch.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;

    // Filters
    fassetsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fassetsrch");
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

<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "sale_asset") {
    if ($Page->MasterRecordExists) {
        include_once "views/SaleAssetMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fassetsrch" id="fassetsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fassetsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="asset">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->_title->Visible) { // title ?>
<?php
if (!$Page->_title->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs__title" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->_title->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x__title" class="ew-search-caption ew-label"><?= $Page->_title->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__title" id="z__title" value="LIKE">
</div>
        </div>
        <div id="el_asset__title" class="ew-search-field">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="asset" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
<?php
if (!$Page->brand_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_brand_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->brand_id->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_brand_id" class="ew-search-caption ew-label"><?= $Page->brand_id->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_brand_id" id="z_brand_id" value="=">
</div>
        </div>
        <div id="el_asset_brand_id" class="ew-search-field">
    <select
        id="x_brand_id"
        name="x_brand_id"
        class="form-select ew-select<?= $Page->brand_id->isInvalidClass() ?>"
        data-select2-id="fassetsrch_x_brand_id"
        data-table="asset"
        data-field="x_brand_id"
        data-value-separator="<?= $Page->brand_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->brand_id->getPlaceHolder()) ?>"
        <?= $Page->brand_id->editAttributes() ?>>
        <?= $Page->brand_id->selectOptionListHtml("x_brand_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->brand_id->getErrorMessage(false) ?></div>
<?= $Page->brand_id->Lookup->getParamTag($Page, "p_x_brand_id") ?>
<script>
loadjs.ready("fassetsrch", function() {
    var options = { name: "x_brand_id", selectId: "fassetsrch_x_brand_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetsrch.lists.brand_id.lookupOptions.length) {
        options.data = { id: "x_brand_id", form: "fassetsrch" };
    } else {
        options.ajax = { id: "x_brand_id", form: "fassetsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.brand_id.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
<?php
if (!$Page->asset_code->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_code" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_code->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_code" class="ew-search-caption ew-label"><?= $Page->asset_code->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_asset_code" id="z_asset_code" value="LIKE">
</div>
        </div>
        <div id="el_asset_asset_code" class="ew-search-field">
<input type="<?= $Page->asset_code->getInputTextType() ?>" name="x_asset_code" id="x_asset_code" data-table="asset" data-field="x_asset_code" value="<?= $Page->asset_code->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->asset_code->getPlaceHolder()) ?>"<?= $Page->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->asset_code->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
<?php
if (!$Page->asset_status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_asset_status" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->asset_status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_asset_status" class="ew-search-caption ew-label"><?= $Page->asset_status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_asset_status" id="z_asset_status" value="=">
</div>
        </div>
        <div id="el_asset_asset_status" class="ew-search-field">
    <select
        id="x_asset_status"
        name="x_asset_status"
        class="form-select ew-select<?= $Page->asset_status->isInvalidClass() ?>"
        data-select2-id="fassetsrch_x_asset_status"
        data-table="asset"
        data-field="x_asset_status"
        data-value-separator="<?= $Page->asset_status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_status->getPlaceHolder()) ?>"
        <?= $Page->asset_status->editAttributes() ?>>
        <?= $Page->asset_status->selectOptionListHtml("x_asset_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->asset_status->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fassetsrch", function() {
    var options = { name: "x_asset_status", selectId: "fassetsrch_x_asset_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetsrch.lists.asset_status.lookupOptions.length) {
        options.data = { id: "x_asset_status", form: "fassetsrch" };
    } else {
        options.ajax = { id: "x_asset_status", form: "fassetsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset.fields.asset_status.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
<?php
if (!$Page->isactive->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_isactive" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->isactive->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->isactive->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_isactive" id="z_isactive" value="=">
</div>
        </div>
        <div id="el_asset_isactive" class="ew-search-field">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x_isactive"
    name="x_isactive"
    value="<?= HtmlEncode($Page->isactive->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_isactive"
    data-bs-target="dsl_x_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Page->isactive->isInvalidClass() ?>"
    data-table="asset"
    data-field="x_isactive"
    data-value-separator="<?= $Page->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Page->isactive->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->isactive->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
<?php
if (!$Page->usable_area->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_usable_area" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->usable_area->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_usable_area" class="ew-search-caption ew-label"><?= $Page->usable_area->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_usable_area" id="z_usable_area" value="LIKE">
</div>
        </div>
        <div id="el_asset_usable_area" class="ew-search-field">
<input type="<?= $Page->usable_area->getInputTextType() ?>" name="x_usable_area" id="x_usable_area" data-table="asset" data-field="x_usable_area" value="<?= $Page->usable_area->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->usable_area->getPlaceHolder()) ?>"<?= $Page->usable_area->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->usable_area->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
<?php
if (!$Page->land_size->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_land_size" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->land_size->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_land_size" class="ew-search-caption ew-label"><?= $Page->land_size->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_land_size" id="z_land_size" value="LIKE">
</div>
        </div>
        <div id="el_asset_land_size" class="ew-search-field">
<input type="<?= $Page->land_size->getInputTextType() ?>" name="x_land_size" id="x_land_size" data-table="asset" data-field="x_land_size" value="<?= $Page->land_size->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->land_size->getPlaceHolder()) ?>"<?= $Page->land_size->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->land_size->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
<?php
if (!$Page->expired_date->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expired_date" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expired_date->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_expired_date" class="ew-search-caption ew-label"><?= $Page->expired_date->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_expired_date" id="z_expired_date" value="BETWEEN">
</div>
        </div>
        <div id="el_asset_expired_date" class="ew-search-field">
<input type="<?= $Page->expired_date->getInputTextType() ?>" name="x_expired_date" id="x_expired_date" data-table="asset" data-field="x_expired_date" value="<?= $Page->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->expired_date->getPlaceHolder()) ?>"<?= $Page->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expired_date->getErrorMessage(false) ?></div>
<?php if (!$Page->expired_date->ReadOnly && !$Page->expired_date->Disabled && !isset($Page->expired_date->EditAttrs["readonly"]) && !isset($Page->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetsrch", "x_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_asset_expired_date" class="ew-search-field2">
<input type="<?= $Page->expired_date->getInputTextType() ?>" name="y_expired_date" id="y_expired_date" data-table="asset" data-field="x_expired_date" value="<?= $Page->expired_date->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->expired_date->getPlaceHolder()) ?>"<?= $Page->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expired_date->getErrorMessage(false) ?></div>
<?php if (!$Page->expired_date->ReadOnly && !$Page->expired_date->Disabled && !isset($Page->expired_date->EditAttrs["readonly"]) && !isset($Page->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetsrch", "y_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
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
        <div id="el_asset_cdate" class="ew-search-field">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="asset" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetsrch", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_asset_cdate" class="ew-search-field2">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="y_cdate" id="y_cdate" data-table="asset" data-field="x_cdate" value="<?= $Page->cdate->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetsrch", "y_cdate", jQuery.extend(true, {"useCurrent":false}, options));
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> asset">
<form name="fassetlist" id="fassetlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset">
<?php if ($Page->getCurrentMasterTable() == "sale_asset" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sale_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_assetlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_asset__title" class="asset__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <th data-name="brand_id" class="<?= $Page->brand_id->headerCellClass() ?>"><div id="elh_asset_brand_id" class="asset_brand_id"><?= $Page->renderFieldHeader($Page->brand_id) ?></div></th>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Page->asset_code->headerCellClass() ?>"><div id="elh_asset_asset_code" class="asset_asset_code"><?= $Page->renderFieldHeader($Page->asset_code) ?></div></th>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
        <th data-name="asset_status" class="<?= $Page->asset_status->headerCellClass() ?>"><div id="elh_asset_asset_status" class="asset_asset_status"><?= $Page->renderFieldHeader($Page->asset_status) ?></div></th>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <th data-name="isactive" class="<?= $Page->isactive->headerCellClass() ?>"><div id="elh_asset_isactive" class="asset_isactive"><?= $Page->renderFieldHeader($Page->isactive) ?></div></th>
<?php } ?>
<?php if ($Page->price_mark->Visible) { // price_mark ?>
        <th data-name="price_mark" class="<?= $Page->price_mark->headerCellClass() ?>"><div id="elh_asset_price_mark" class="asset_price_mark"><?= $Page->renderFieldHeader($Page->price_mark) ?></div></th>
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
        <th data-name="usable_area" class="<?= $Page->usable_area->headerCellClass() ?>"><div id="elh_asset_usable_area" class="asset_usable_area"><?= $Page->renderFieldHeader($Page->usable_area) ?></div></th>
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
        <th data-name="land_size" class="<?= $Page->land_size->headerCellClass() ?>"><div id="elh_asset_land_size" class="asset_land_size"><?= $Page->renderFieldHeader($Page->land_size) ?></div></th>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
        <th data-name="count_view" class="<?= $Page->count_view->headerCellClass() ?>"><div id="elh_asset_count_view" class="asset_count_view"><?= $Page->renderFieldHeader($Page->count_view) ?></div></th>
<?php } ?>
<?php if ($Page->count_favorite->Visible) { // count_favorite ?>
        <th data-name="count_favorite" class="<?= $Page->count_favorite->headerCellClass() ?>"><div id="elh_asset_count_favorite" class="asset_count_favorite"><?= $Page->renderFieldHeader($Page->count_favorite) ?></div></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Page->expired_date->headerCellClass() ?>"><div id="elh_asset_expired_date" class="asset_expired_date"><?= $Page->renderFieldHeader($Page->expired_date) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_asset_cdate" class="asset_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_asset",
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
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset__title" class="el_asset__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->brand_id->Visible) { // brand_id ?>
        <td data-name="brand_id"<?= $Page->brand_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_brand_id" class="el_asset_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_asset_code" class="el_asset_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_status->Visible) { // asset_status ?>
        <td data-name="asset_status"<?= $Page->asset_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_asset_status" class="el_asset_asset_status">
<span<?= $Page->asset_status->viewAttributes() ?>>
<?= $Page->asset_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isactive->Visible) { // isactive ?>
        <td data-name="isactive"<?= $Page->isactive->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_isactive" class="el_asset_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price_mark->Visible) { // price_mark ?>
        <td data-name="price_mark"<?= $Page->price_mark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_price_mark" class="el_asset_price_mark">
<span<?= $Page->price_mark->viewAttributes() ?>>
<?= $Page->price_mark->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usable_area->Visible) { // usable_area ?>
        <td data-name="usable_area"<?= $Page->usable_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_usable_area" class="el_asset_usable_area">
<span<?= $Page->usable_area->viewAttributes() ?>>
<?= $Page->usable_area->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->land_size->Visible) { // land_size ?>
        <td data-name="land_size"<?= $Page->land_size->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_land_size" class="el_asset_land_size">
<span<?= $Page->land_size->viewAttributes() ?>>
<?= $Page->land_size->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->count_view->Visible) { // count_view ?>
        <td data-name="count_view"<?= $Page->count_view->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_count_view" class="el_asset_count_view">
<span<?= $Page->count_view->viewAttributes() ?>>
<?= $Page->count_view->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->count_favorite->Visible) { // count_favorite ?>
        <td data-name="count_favorite"<?= $Page->count_favorite->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_count_favorite" class="el_asset_count_favorite">
<span<?= $Page->count_favorite->viewAttributes() ?>>
<?= $Page->count_favorite->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_expired_date" class="el_asset_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_asset_cdate" class="el_asset_cdate">
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
        container: "gmp_asset",
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
    ew.addEventHandlers("asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
