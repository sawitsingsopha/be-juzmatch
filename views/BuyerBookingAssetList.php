<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerBookingAssetList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_booking_asset: currentTable } });
var currentForm, currentPageID;
var fbuyer_booking_assetlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_booking_assetlist = new ew.Form("fbuyer_booking_assetlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fbuyer_booking_assetlist;
    fbuyer_booking_assetlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fbuyer_booking_assetlist");
});
var fbuyer_booking_assetsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fbuyer_booking_assetsrch = new ew.Form("fbuyer_booking_assetsrch", "list");
    currentSearchForm = fbuyer_booking_assetsrch;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_booking_assetsrch.addFields([
        ["asset_id", [], fields.asset_id.isInvalid],
        ["booking_price", [ew.Validators.float], fields.booking_price.isInvalid],
        ["pay_number", [], fields.pay_number.isInvalid],
        ["status_payment", [], fields.status_payment.isInvalid],
        ["date_booking", [ew.Validators.datetime(fields.date_booking.clientFormatPattern)], fields.date_booking.isInvalid],
        ["y_date_booking", [ew.Validators.between], false],
        ["date_payment", [ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["y_date_payment", [ew.Validators.between], false],
        ["due_date", [ew.Validators.datetime(fields.due_date.clientFormatPattern)], fields.due_date.isInvalid],
        ["y_due_date", [ew.Validators.between], false],
        ["status_expire", [], fields.status_expire.isInvalid],
        ["status_expire_reason", [], fields.status_expire_reason.isInvalid],
        ["cdate", [ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["y_cdate", [ew.Validators.between], false]
    ]);

    // Validate form
    fbuyer_booking_assetsrch.validate = function () {
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
    fbuyer_booking_assetsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_booking_assetsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_booking_assetsrch.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fbuyer_booking_assetsrch.lists.status_payment = <?= $Page->status_payment->toClientList($Page) ?>;

    // Filters
    fbuyer_booking_assetsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fbuyer_booking_assetsrch");
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
<form name="fbuyer_booking_assetsrch" id="fbuyer_booking_assetsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fbuyer_booking_assetsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="buyer_booking_asset">
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
        <div id="el_buyer_booking_asset_asset_id" class="ew-search-field">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_booking_assetsrch_x_asset_id"
        data-table="buyer_booking_asset"
        data-field="x_asset_id"
        data-value-separator="<?= $Page->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"
        <?= $Page->asset_id->editAttributes() ?>>
        <?= $Page->asset_id->selectOptionListHtml("x_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage(false) ?></div>
<?= $Page->asset_id->Lookup->getParamTag($Page, "p_x_asset_id") ?>
<script>
loadjs.ready("fbuyer_booking_assetsrch", function() {
    var options = { name: "x_asset_id", selectId: "fbuyer_booking_assetsrch_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_booking_assetsrch.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fbuyer_booking_assetsrch" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fbuyer_booking_assetsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_booking_asset.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
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
        <div id="el_buyer_booking_asset_booking_price" class="ew-search-field">
<input type="<?= $Page->booking_price->getInputTextType() ?>" name="x_booking_price" id="x_booking_price" data-table="buyer_booking_asset" data-field="x_booking_price" value="<?= $Page->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->booking_price->getPlaceHolder()) ?>"<?= $Page->booking_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->booking_price->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
<?php
if (!$Page->pay_number->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_pay_number" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->pay_number->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_pay_number" class="ew-search-caption ew-label"><?= $Page->pay_number->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_pay_number" id="z_pay_number" value="LIKE">
</div>
        </div>
        <div id="el_buyer_booking_asset_pay_number" class="ew-search-field">
<input type="<?= $Page->pay_number->getInputTextType() ?>" name="x_pay_number" id="x_pay_number" data-table="buyer_booking_asset" data-field="x_pay_number" value="<?= $Page->pay_number->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->pay_number->getPlaceHolder()) ?>"<?= $Page->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pay_number->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
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
        <div id="el_buyer_booking_asset_status_payment" class="ew-search-field">
    <select
        id="x_status_payment"
        name="x_status_payment"
        class="form-select ew-select<?= $Page->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_booking_assetsrch_x_status_payment"
        data-table="buyer_booking_asset"
        data-field="x_status_payment"
        data-value-separator="<?= $Page->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_payment->getPlaceHolder()) ?>"
        <?= $Page->status_payment->editAttributes() ?>>
        <?= $Page->status_payment->selectOptionListHtml("x_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status_payment->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fbuyer_booking_assetsrch", function() {
    var options = { name: "x_status_payment", selectId: "fbuyer_booking_assetsrch_x_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_booking_assetsrch.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x_status_payment", form: "fbuyer_booking_assetsrch" };
    } else {
        options.ajax = { id: "x_status_payment", form: "fbuyer_booking_assetsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_booking_asset.fields.status_payment.selectOptions);
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
        <div id="el_buyer_booking_asset_date_booking" class="ew-search-field">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="x_date_booking" id="x_date_booking" data-table="buyer_booking_asset" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage(false) ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "x_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_buyer_booking_asset_date_booking" class="ew-search-field2">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="y_date_booking" id="y_date_booking" data-table="buyer_booking_asset" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage(false) ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "y_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
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
        <div id="el_buyer_booking_asset_date_payment" class="ew-search-field">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="x_date_payment" id="x_date_payment" data-table="buyer_booking_asset" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage(false) ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "x_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_buyer_booking_asset_date_payment" class="ew-search-field2">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="y_date_payment" id="y_date_payment" data-table="buyer_booking_asset" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage(false) ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "y_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
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
        <div id="el_buyer_booking_asset_due_date" class="ew-search-field">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="x_due_date" id="x_due_date" data-table="buyer_booking_asset" data-field="x_due_date" value="<?= $Page->due_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage(false) ?></div>
<?php if (!$Page->due_date->ReadOnly && !$Page->due_date->Disabled && !isset($Page->due_date->EditAttrs["readonly"]) && !isset($Page->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "x_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_buyer_booking_asset_due_date" class="ew-search-field2">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="y_due_date" id="y_due_date" data-table="buyer_booking_asset" data-field="x_due_date" value="<?= $Page->due_date->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage(false) ?></div>
<?php if (!$Page->due_date->ReadOnly && !$Page->due_date->Disabled && !isset($Page->due_date->EditAttrs["readonly"]) && !isset($Page->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "y_due_date", jQuery.extend(true, {"useCurrent":false}, options));
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
        <div id="el_buyer_booking_asset_cdate" class="ew-search-field">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="buyer_booking_asset" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_buyer_booking_asset_cdate" class="ew-search-field2">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="y_cdate" id="y_cdate" data-table="buyer_booking_asset" data-field="x_cdate" value="<?= $Page->cdate->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetsrch", "y_cdate", jQuery.extend(true, {"useCurrent":false}, options));
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fbuyer_booking_assetsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fbuyer_booking_assetsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fbuyer_booking_assetsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fbuyer_booking_assetsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_booking_asset">
<form name="fbuyer_booking_assetlist" id="fbuyer_booking_assetlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_booking_asset">
<?php if ($Page->getCurrentMasterTable() == "buyer" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_buyer_booking_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_buyer_booking_assetlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_buyer_booking_asset_asset_id" class="buyer_booking_asset_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <th data-name="booking_price" class="<?= $Page->booking_price->headerCellClass() ?>"><div id="elh_buyer_booking_asset_booking_price" class="buyer_booking_asset_booking_price"><?= $Page->renderFieldHeader($Page->booking_price) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Page->pay_number->headerCellClass() ?>"><div id="elh_buyer_booking_asset_pay_number" class="buyer_booking_asset_pay_number"><?= $Page->renderFieldHeader($Page->pay_number) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_buyer_booking_asset_status_payment" class="buyer_booking_asset_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Page->date_booking->headerCellClass() ?>"><div id="elh_buyer_booking_asset_date_booking" class="buyer_booking_asset_date_booking"><?= $Page->renderFieldHeader($Page->date_booking) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_buyer_booking_asset_date_payment" class="buyer_booking_asset_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <th data-name="due_date" class="<?= $Page->due_date->headerCellClass() ?>"><div id="elh_buyer_booking_asset_due_date" class="buyer_booking_asset_due_date"><?= $Page->renderFieldHeader($Page->due_date) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Page->status_expire->headerCellClass() ?>"><div id="elh_buyer_booking_asset_status_expire" class="buyer_booking_asset_status_expire"><?= $Page->renderFieldHeader($Page->status_expire) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Page->status_expire_reason->headerCellClass() ?>"><div id="elh_buyer_booking_asset_status_expire_reason" class="buyer_booking_asset_status_expire_reason"><?= $Page->renderFieldHeader($Page->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_buyer_booking_asset_cdate" class="buyer_booking_asset_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_buyer_booking_asset",
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
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_asset_id" class="el_buyer_booking_asset_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->booking_price->Visible) { // booking_price ?>
        <td data-name="booking_price"<?= $Page->booking_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_booking_price" class="el_buyer_booking_asset_booking_price">
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_pay_number" class="el_buyer_booking_asset_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_status_payment" class="el_buyer_booking_asset_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_date_booking" class="el_buyer_booking_asset_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_date_payment" class="el_buyer_booking_asset_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date->Visible) { // due_date ?>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_due_date" class="el_buyer_booking_asset_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_status_expire" class="el_buyer_booking_asset_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_status_expire_reason" class="el_buyer_booking_asset_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_booking_asset_cdate" class="el_buyer_booking_asset_cdate">
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
        container: "gmp_buyer_booking_asset",
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
    ew.addEventHandlers("buyer_booking_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
