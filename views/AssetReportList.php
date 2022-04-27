<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetReportList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { assetReport: currentTable } });
var currentForm, currentPageID;
var fassetReportlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fassetReportlist = new ew.Form("fassetReportlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fassetReportlist;
    fassetReportlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fassetReportlist");
});
var fassetReportsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fassetReportsrch = new ew.Form("fassetReportsrch", "list");
    currentSearchForm = fassetReportsrch;

    // Add fields
    var fields = currentTable.fields;
    fassetReportsrch.addFields([
        ["asset_code", [], fields.asset_code.isInvalid],
        ["_title", [], fields._title.isInvalid],
        ["brand_name", [], fields.brand_name.isInvalid],
        ["full_address", [], fields.full_address.isInvalid],
        ["asset_status", [], fields.asset_status.isInvalid],
        ["price", [], fields.price.isInvalid],
        ["booking_name", [], fields.booking_name.isInvalid],
        ["date_booking", [ew.Validators.datetime(fields.date_booking.clientFormatPattern)], fields.date_booking.isInvalid],
        ["y_date_booking", [ew.Validators.between], false],
        ["booking_price", [ew.Validators.float], fields.booking_price.isInvalid],
        ["due_date", [ew.Validators.datetime(fields.due_date.clientFormatPattern)], fields.due_date.isInvalid],
        ["y_due_date", [ew.Validators.between], false],
        ["status_payment", [], fields.status_payment.isInvalid],
        ["date_payment", [ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["y_date_payment", [ew.Validators.between], false]
    ]);

    // Validate form
    fassetReportsrch.validate = function () {
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
    fassetReportsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fassetReportsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fassetReportsrch.lists.asset_status = <?= $Page->asset_status->toClientList($Page) ?>;
    fassetReportsrch.lists.status_payment = <?= $Page->status_payment->toClientList($Page) ?>;

    // Filters
    fassetReportsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fassetReportsrch");
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.ready("head", ew.PATH_BASE + "js/preview.min.js", "preview");
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
<form name="fassetReportsrch" id="fassetReportsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fassetReportsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="assetReport">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
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
        <div id="el_assetReport_asset_code" class="ew-search-field">
<input type="<?= $Page->asset_code->getInputTextType() ?>" name="x_asset_code" id="x_asset_code" data-table="assetReport" data-field="x_asset_code" value="<?= $Page->asset_code->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->asset_code->getPlaceHolder()) ?>"<?= $Page->asset_code->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->asset_code->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_assetReport__title" class="ew-search-field">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="assetReport" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage(false) ?></div>
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
        <div id="el_assetReport_asset_status" class="ew-search-field">
    <select
        id="x_asset_status"
        name="x_asset_status"
        class="form-select ew-select<?= $Page->asset_status->isInvalidClass() ?>"
        data-select2-id="fassetReportsrch_x_asset_status"
        data-table="assetReport"
        data-field="x_asset_status"
        data-value-separator="<?= $Page->asset_status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_status->getPlaceHolder()) ?>"
        <?= $Page->asset_status->editAttributes() ?>>
        <?= $Page->asset_status->selectOptionListHtml("x_asset_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->asset_status->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fassetReportsrch", function() {
    var options = { name: "x_asset_status", selectId: "fassetReportsrch_x_asset_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetReportsrch.lists.asset_status.lookupOptions.length) {
        options.data = { id: "x_asset_status", form: "fassetReportsrch" };
    } else {
        options.ajax = { id: "x_asset_status", form: "fassetReportsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.assetReport.fields.asset_status.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
<?php
if (!$Page->date_booking->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_date_booking" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->date_booking->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_date_booking" class="ew-search-caption ew-label"><?= $Page->date_booking->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_date_booking" id="z_date_booking" value="BETWEEN">
</div>
        </div>
        <div id="el_assetReport_date_booking" class="ew-search-field">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="x_date_booking" id="x_date_booking" data-table="assetReport" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage(false) ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetReportsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetReportsrch", "x_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_assetReport_date_booking" class="ew-search-field2">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="y_date_booking" id="y_date_booking" data-table="assetReport" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage(false) ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetReportsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetReportsrch", "y_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
<?php
if (!$Page->booking_price->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_booking_price" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->booking_price->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_booking_price" class="ew-search-caption ew-label"><?= $Page->booking_price->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_booking_price" id="z_booking_price" value="=">
</div>
        </div>
        <div id="el_assetReport_booking_price" class="ew-search-field">
<input type="<?= $Page->booking_price->getInputTextType() ?>" name="x_booking_price" id="x_booking_price" data-table="assetReport" data-field="x_booking_price" value="<?= $Page->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->booking_price->getPlaceHolder()) ?>"<?= $Page->booking_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->booking_price->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
<?php
if (!$Page->due_date->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_due_date" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->due_date->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_due_date" class="ew-search-caption ew-label"><?= $Page->due_date->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_due_date" id="z_due_date" value="BETWEEN">
</div>
        </div>
        <div id="el_assetReport_due_date" class="ew-search-field">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="x_due_date" id="x_due_date" data-table="assetReport" data-field="x_due_date" value="<?= $Page->due_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage(false) ?></div>
<?php if (!$Page->due_date->ReadOnly && !$Page->due_date->Disabled && !isset($Page->due_date->EditAttrs["readonly"]) && !isset($Page->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetReportsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetReportsrch", "x_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_assetReport_due_date" class="ew-search-field2">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="y_due_date" id="y_due_date" data-table="assetReport" data-field="x_due_date" value="<?= $Page->due_date->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage(false) ?></div>
<?php if (!$Page->due_date->ReadOnly && !$Page->due_date->Disabled && !isset($Page->due_date->EditAttrs["readonly"]) && !isset($Page->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetReportsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetReportsrch", "y_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
<?php
if (!$Page->status_payment->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status_payment" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->status_payment->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_status_payment" class="ew-search-caption ew-label"><?= $Page->status_payment->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_payment" id="z_status_payment" value="=">
</div>
        </div>
        <div id="el_assetReport_status_payment" class="ew-search-field">
    <select
        id="x_status_payment"
        name="x_status_payment"
        class="form-select ew-select<?= $Page->status_payment->isInvalidClass() ?>"
        data-select2-id="fassetReportsrch_x_status_payment"
        data-table="assetReport"
        data-field="x_status_payment"
        data-value-separator="<?= $Page->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_payment->getPlaceHolder()) ?>"
        <?= $Page->status_payment->editAttributes() ?>>
        <?= $Page->status_payment->selectOptionListHtml("x_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status_payment->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fassetReportsrch", function() {
    var options = { name: "x_status_payment", selectId: "fassetReportsrch_x_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fassetReportsrch.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x_status_payment", form: "fassetReportsrch" };
    } else {
        options.ajax = { id: "x_status_payment", form: "fassetReportsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.assetReport.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
<?php
if (!$Page->date_payment->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_date_payment" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->date_payment->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_date_payment" class="ew-search-caption ew-label"><?= $Page->date_payment->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_date_payment" id="z_date_payment" value="BETWEEN">
</div>
        </div>
        <div id="el_assetReport_date_payment" class="ew-search-field">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="x_date_payment" id="x_date_payment" data-table="assetReport" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage(false) ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetReportsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetReportsrch", "x_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_assetReport_date_payment" class="ew-search-field2">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="y_date_payment" id="y_date_payment" data-table="assetReport" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage(false) ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fassetReportsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fassetReportsrch", "y_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fassetReportsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fassetReportsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fassetReportsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fassetReportsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> assetReport">
<form name="fassetReportlist" id="fassetReportlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="assetReport">
<div id="gmp_assetReport" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_assetReportlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Page->asset_code->headerCellClass() ?>"><div id="elh_assetReport_asset_code" class="assetReport_asset_code"><?= $Page->renderFieldHeader($Page->asset_code) ?></div></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_assetReport__title" class="assetReport__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->brand_name->Visible) { // brand_name ?>
        <th data-name="brand_name" class="<?= $Page->brand_name->headerCellClass() ?>"><div id="elh_assetReport_brand_name" class="assetReport_brand_name"><?= $Page->renderFieldHeader($Page->brand_name) ?></div></th>
<?php } ?>
<?php if ($Page->full_address->Visible) { // full_address ?>
        <th data-name="full_address" class="<?= $Page->full_address->headerCellClass() ?>"><div id="elh_assetReport_full_address" class="assetReport_full_address"><?= $Page->renderFieldHeader($Page->full_address) ?></div></th>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
        <th data-name="asset_status" class="<?= $Page->asset_status->headerCellClass() ?>"><div id="elh_assetReport_asset_status" class="assetReport_asset_status"><?= $Page->renderFieldHeader($Page->asset_status) ?></div></th>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
        <th data-name="price" class="<?= $Page->price->headerCellClass() ?>"><div id="elh_assetReport_price" class="assetReport_price"><?= $Page->renderFieldHeader($Page->price) ?></div></th>
<?php } ?>
<?php if ($Page->booking_name->Visible) { // booking_name ?>
        <th data-name="booking_name" class="<?= $Page->booking_name->headerCellClass() ?>"><div id="elh_assetReport_booking_name" class="assetReport_booking_name"><?= $Page->renderFieldHeader($Page->booking_name) ?></div></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Page->date_booking->headerCellClass() ?>"><div id="elh_assetReport_date_booking" class="assetReport_date_booking"><?= $Page->renderFieldHeader($Page->date_booking) ?></div></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th data-name="booking_price" class="<?= $Page->booking_price->headerCellClass() ?>"><div id="elh_assetReport_booking_price" class="assetReport_booking_price"><?= $Page->renderFieldHeader($Page->booking_price) ?></div></th>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <th data-name="due_date" class="<?= $Page->due_date->headerCellClass() ?>"><div id="elh_assetReport_due_date" class="assetReport_due_date"><?= $Page->renderFieldHeader($Page->due_date) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_assetReport_status_payment" class="assetReport_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_assetReport_date_payment" class="assetReport_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_assetReport",
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
    <?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_asset_code" class="el_assetReport_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport__title" class="el_assetReport__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->brand_name->Visible) { // brand_name ?>
        <td data-name="brand_name"<?= $Page->brand_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_brand_name" class="el_assetReport_brand_name">
<span<?= $Page->brand_name->viewAttributes() ?>>
<?= $Page->brand_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->full_address->Visible) { // full_address ?>
        <td data-name="full_address"<?= $Page->full_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_full_address" class="el_assetReport_full_address">
<span<?= $Page->full_address->viewAttributes() ?>>
<?= $Page->full_address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_status->Visible) { // asset_status ?>
        <td data-name="asset_status"<?= $Page->asset_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_asset_status" class="el_assetReport_asset_status">
<span<?= $Page->asset_status->viewAttributes() ?>>
<?= $Page->asset_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->price->Visible) { // price ?>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_price" class="el_assetReport_price">
<span<?= $Page->price->viewAttributes() ?> style="white-space: nowrap;">
<?= "฿ ".number_format($Page->price->getViewValue(), 2) ?></span>

</span>
</td>
    <?php } ?>
    <?php if ($Page->booking_name->Visible) { // booking_name ?>
        <td data-name="booking_name"<?= $Page->booking_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_booking_name" class="el_assetReport_booking_name">
<span<?= $Page->booking_name->viewAttributes() ?>>
<?= $Page->booking_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_date_booking" class="el_assetReport_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_booking_price" class="el_assetReport_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date->Visible) { // due_date ?>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_due_date" class="el_assetReport_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_status_payment" class="el_assetReport_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_assetReport_date_payment" class="el_assetReport_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
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
        container: "gmp_assetReport",
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
    ew.addEventHandlers("assetReport");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
