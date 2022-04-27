<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetScheduleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fbuyer_asset_schedulelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_schedulelist = new ew.Form("fbuyer_asset_schedulelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fbuyer_asset_schedulelist;
    fbuyer_asset_schedulelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fbuyer_asset_schedulelist");
});
var fbuyer_asset_schedulesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fbuyer_asset_schedulesrch = new ew.Form("fbuyer_asset_schedulesrch", "list");
    currentSearchForm = fbuyer_asset_schedulesrch;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_asset_schedulesrch.addFields([
        ["num_installment", [ew.Validators.integer], fields.num_installment.isInvalid],
        ["installment_per_price", [ew.Validators.float], fields.installment_per_price.isInvalid],
        ["pay_number", [], fields.pay_number.isInvalid],
        ["expired_date", [ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["y_expired_date", [ew.Validators.between], false],
        ["date_payment", [ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["y_date_payment", [ew.Validators.between], false],
        ["status_payment", [], fields.status_payment.isInvalid],
        ["cdate", [], fields.cdate.isInvalid]
    ]);

    // Validate form
    fbuyer_asset_schedulesrch.validate = function () {
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
    fbuyer_asset_schedulesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_asset_schedulesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_asset_schedulesrch.lists.status_payment = <?= $Page->status_payment->toClientList($Page) ?>;

    // Filters
    fbuyer_asset_schedulesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fbuyer_asset_schedulesrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "buyer_asset") {
    if ($Page->MasterRecordExists) {
        include_once "views/BuyerAssetMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "buyer_config_asset_schedule") {
    if ($Page->MasterRecordExists) {
        include_once "views/BuyerConfigAssetScheduleMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fbuyer_asset_schedulesrch" id="fbuyer_asset_schedulesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fbuyer_asset_schedulesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="buyer_asset_schedule">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
<?php
if (!$Page->num_installment->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_num_installment" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->num_installment->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_num_installment" class="ew-search-caption ew-label"><?= $Page->num_installment->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_num_installment" id="z_num_installment" value="=">
</div>
        </div>
        <div id="el_buyer_asset_schedule_num_installment" class="ew-search-field">
<input type="<?= $Page->num_installment->getInputTextType() ?>" name="x_num_installment" id="x_num_installment" data-table="buyer_asset_schedule" data-field="x_num_installment" value="<?= $Page->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->num_installment->getPlaceHolder()) ?>"<?= $Page->num_installment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->num_installment->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
<?php
if (!$Page->installment_per_price->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_installment_per_price" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->installment_per_price->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_installment_per_price" class="ew-search-caption ew-label"><?= $Page->installment_per_price->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_installment_per_price" id="z_installment_per_price" value="=">
</div>
        </div>
        <div id="el_buyer_asset_schedule_installment_per_price" class="ew-search-field">
<input type="<?= $Page->installment_per_price->getInputTextType() ?>" name="x_installment_per_price" id="x_installment_per_price" data-table="buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Page->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_per_price->getPlaceHolder()) ?>"<?= $Page->installment_per_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->installment_per_price->getErrorMessage(false) ?></div>
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
        <div id="el_buyer_asset_schedule_pay_number" class="ew-search-field">
<input type="<?= $Page->pay_number->getInputTextType() ?>" name="x_pay_number" id="x_pay_number" data-table="buyer_asset_schedule" data-field="x_pay_number" value="<?= $Page->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pay_number->getPlaceHolder()) ?>"<?= $Page->pay_number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pay_number->getErrorMessage(false) ?></div>
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
        <div id="el_buyer_asset_schedule_expired_date" class="ew-search-field">
<input type="<?= $Page->expired_date->getInputTextType() ?>" name="x_expired_date" id="x_expired_date" data-table="buyer_asset_schedule" data-field="x_expired_date" value="<?= $Page->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->expired_date->getPlaceHolder()) ?>"<?= $Page->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expired_date->getErrorMessage(false) ?></div>
<?php if (!$Page->expired_date->ReadOnly && !$Page->expired_date->Disabled && !isset($Page->expired_date->EditAttrs["readonly"]) && !isset($Page->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulesrch", "x_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_buyer_asset_schedule_expired_date" class="ew-search-field2">
<input type="<?= $Page->expired_date->getInputTextType() ?>" name="y_expired_date" id="y_expired_date" data-table="buyer_asset_schedule" data-field="x_expired_date" value="<?= $Page->expired_date->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->expired_date->getPlaceHolder()) ?>"<?= $Page->expired_date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expired_date->getErrorMessage(false) ?></div>
<?php if (!$Page->expired_date->ReadOnly && !$Page->expired_date->Disabled && !isset($Page->expired_date->EditAttrs["readonly"]) && !isset($Page->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulesrch", "y_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
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
        <div id="el_buyer_asset_schedule_date_payment" class="ew-search-field">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="x_date_payment" id="x_date_payment" data-table="buyer_asset_schedule" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage(false) ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulesrch", "x_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_buyer_asset_schedule_date_payment" class="ew-search-field2">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="y_date_payment" id="y_date_payment" data-table="buyer_asset_schedule" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage(false) ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_schedulesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_schedulesrch", "y_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
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
        <div id="el_buyer_asset_schedule_status_payment" class="ew-search-field">
    <select
        id="x_status_payment"
        name="x_status_payment"
        class="form-select ew-select<?= $Page->status_payment->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_schedulesrch_x_status_payment"
        data-table="buyer_asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Page->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_payment->getPlaceHolder()) ?>"
        <?= $Page->status_payment->editAttributes() ?>>
        <?= $Page->status_payment->selectOptionListHtml("x_status_payment") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status_payment->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fbuyer_asset_schedulesrch", function() {
    var options = { name: "x_status_payment", selectId: "fbuyer_asset_schedulesrch_x_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_schedulesrch.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x_status_payment", form: "fbuyer_asset_schedulesrch" };
    } else {
        options.ajax = { id: "x_status_payment", form: "fbuyer_asset_schedulesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_schedule.fields.status_payment.selectOptions);
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_asset_schedule">
<form name="fbuyer_asset_schedulelist" id="fbuyer_asset_schedulelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset_schedule">
<?php if ($Page->getCurrentMasterTable() == "buyer_asset" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "buyer_config_asset_schedule" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_config_asset_schedule">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_buyer_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_buyer_asset_schedulelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <th data-name="num_installment" class="<?= $Page->num_installment->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_num_installment" class="buyer_asset_schedule_num_installment"><?= $Page->renderFieldHeader($Page->num_installment) ?></div></th>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <th data-name="installment_per_price" class="<?= $Page->installment_per_price->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_installment_per_price" class="buyer_asset_schedule_installment_per_price"><?= $Page->renderFieldHeader($Page->installment_per_price) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Page->pay_number->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_pay_number" class="buyer_asset_schedule_pay_number"><?= $Page->renderFieldHeader($Page->pay_number) ?></div></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Page->expired_date->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_expired_date" class="buyer_asset_schedule_expired_date"><?= $Page->renderFieldHeader($Page->expired_date) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_date_payment" class="buyer_asset_schedule_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_status_payment" class="buyer_asset_schedule_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_buyer_asset_schedule_cdate" class="buyer_asset_schedule_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_buyer_asset_schedule",
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
    <?php if ($Page->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment"<?= $Page->num_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_num_installment" class="el_buyer_asset_schedule_num_installment">
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price"<?= $Page->installment_per_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_installment_per_price" class="el_buyer_asset_schedule_installment_per_price">
<span<?= $Page->installment_per_price->viewAttributes() ?>>
<?= $Page->installment_per_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_pay_number" class="el_buyer_asset_schedule_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_expired_date" class="el_buyer_asset_schedule_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_date_payment" class="el_buyer_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_status_payment" class="el_buyer_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_asset_schedule_cdate" class="el_buyer_asset_schedule_cdate">
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
        container: "gmp_buyer_asset_schedule",
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
    ew.addEventHandlers("buyer_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
