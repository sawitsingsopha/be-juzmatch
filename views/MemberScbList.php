<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberScbList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member_scb: currentTable } });
var currentForm, currentPageID;
var fmember_scblist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmember_scblist = new ew.Form("fmember_scblist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fmember_scblist;
    fmember_scblist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fmember_scblist");
});
var fmember_scbsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fmember_scbsrch = new ew.Form("fmember_scbsrch", "list");
    currentSearchForm = fmember_scbsrch;

    // Add fields
    var fields = currentTable.fields;
    fmember_scbsrch.addFields([
        ["member_id", [], fields.member_id.isInvalid],
        ["asset_id", [], fields.asset_id.isInvalid],
        ["reference_id", [], fields.reference_id.isInvalid],
        ["reference_url", [], fields.reference_url.isInvalid],
        ["state", [], fields.state.isInvalid],
        ["status", [], fields.status.isInvalid],
        ["decision_status", [], fields.decision_status.isInvalid],
        ["cdate", [ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["y_cdate", [ew.Validators.between], false],
        ["fullName", [], fields.fullName.isInvalid],
        ["age", [], fields.age.isInvalid],
        ["maritalStatus", [], fields.maritalStatus.isInvalid],
        ["noOfChildren", [], fields.noOfChildren.isInvalid],
        ["educationLevel", [], fields.educationLevel.isInvalid],
        ["workplace", [], fields.workplace.isInvalid],
        ["occupation", [], fields.occupation.isInvalid],
        ["jobPosition", [], fields.jobPosition.isInvalid],
        ["submissionDate", [], fields.submissionDate.isInvalid],
        ["bankruptcy_tendency", [], fields.bankruptcy_tendency.isInvalid],
        ["blacklist_tendency", [], fields.blacklist_tendency.isInvalid],
        ["money_laundering_tendency", [], fields.money_laundering_tendency.isInvalid],
        ["mobile_fraud_behavior", [], fields.mobile_fraud_behavior.isInvalid],
        ["face_similarity_score", [], fields.face_similarity_score.isInvalid],
        ["identification_verification_matched_flag", [], fields.identification_verification_matched_flag.isInvalid],
        ["bankstatement_confident_score", [], fields.bankstatement_confident_score.isInvalid],
        ["estimated_monthly_income", [], fields.estimated_monthly_income.isInvalid],
        ["estimated_monthly_debt", [], fields.estimated_monthly_debt.isInvalid],
        ["income_stability", [], fields.income_stability.isInvalid],
        ["customer_grade", [], fields.customer_grade.isInvalid],
        ["color_sign", [], fields.color_sign.isInvalid],
        ["rental_period", [], fields.rental_period.isInvalid]
    ]);

    // Validate form
    fmember_scbsrch.validate = function () {
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
    fmember_scbsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmember_scbsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fmember_scbsrch.lists.member_id = <?= $Page->member_id->toClientList($Page) ?>;
    fmember_scbsrch.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;

    // Filters
    fmember_scbsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmember_scbsrch");
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
<form name="fmember_scbsrch" id="fmember_scbsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fmember_scbsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="member_scb">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
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
        <div id="el_member_scb_member_id" class="ew-search-field">
    <select
        id="x_member_id"
        name="x_member_id"
        class="form-control ew-select<?= $Page->member_id->isInvalidClass() ?>"
        data-select2-id="fmember_scbsrch_x_member_id"
        data-table="member_scb"
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
loadjs.ready("fmember_scbsrch", function() {
    var options = { name: "x_member_id", selectId: "fmember_scbsrch_x_member_id" };
    if (fmember_scbsrch.lists.member_id.lookupOptions.length) {
        options.data = { id: "x_member_id", form: "fmember_scbsrch" };
    } else {
        options.ajax = { id: "x_member_id", form: "fmember_scbsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.member_scb.fields.member_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_member_scb_asset_id" class="ew-search-field">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-control ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fmember_scbsrch_x_asset_id"
        data-table="member_scb"
        data-field="x_asset_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->asset_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"
        <?= $Page->asset_id->editAttributes() ?>>
        <?= $Page->asset_id->selectOptionListHtml("x_asset_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage(false) ?></div>
<?= $Page->asset_id->Lookup->getParamTag($Page, "p_x_asset_id") ?>
<script>
loadjs.ready("fmember_scbsrch", function() {
    var options = { name: "x_asset_id", selectId: "fmember_scbsrch_x_asset_id" };
    if (fmember_scbsrch.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fmember_scbsrch" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fmember_scbsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.member_scb.fields.asset_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
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
        <div id="el_member_scb_cdate" class="ew-search-field">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="member_scb" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmember_scbsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fmember_scbsrch", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_member_scb_cdate" class="ew-search-field2">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="y_cdate" id="y_cdate" data-table="member_scb" data-field="x_cdate" value="<?= $Page->cdate->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage(false) ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmember_scbsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fmember_scbsrch", "y_cdate", jQuery.extend(true, {"useCurrent":false}, options));
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fmember_scbsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fmember_scbsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fmember_scbsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fmember_scbsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> member_scb">
<form name="fmember_scblist" id="fmember_scblist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member_scb">
<div id="gmp_member_scb" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_member_scblist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Page->member_id->headerCellClass() ?>"><div id="elh_member_scb_member_id" class="member_scb_member_id"><?= $Page->renderFieldHeader($Page->member_id) ?></div></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_member_scb_asset_id" class="member_scb_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->reference_id->Visible) { // reference_id ?>
        <th data-name="reference_id" class="<?= $Page->reference_id->headerCellClass() ?>"><div id="elh_member_scb_reference_id" class="member_scb_reference_id"><?= $Page->renderFieldHeader($Page->reference_id) ?></div></th>
<?php } ?>
<?php if ($Page->reference_url->Visible) { // reference_url ?>
        <th data-name="reference_url" class="<?= $Page->reference_url->headerCellClass() ?>"><div id="elh_member_scb_reference_url" class="member_scb_reference_url"><?= $Page->renderFieldHeader($Page->reference_url) ?></div></th>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
        <th data-name="state" class="<?= $Page->state->headerCellClass() ?>"><div id="elh_member_scb_state" class="member_scb_state"><?= $Page->renderFieldHeader($Page->state) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_member_scb_status" class="member_scb_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->decision_status->Visible) { // decision_status ?>
        <th data-name="decision_status" class="<?= $Page->decision_status->headerCellClass() ?>"><div id="elh_member_scb_decision_status" class="member_scb_decision_status"><?= $Page->renderFieldHeader($Page->decision_status) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_member_scb_cdate" class="member_scb_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->fullName->Visible) { // fullName ?>
        <th data-name="fullName" class="<?= $Page->fullName->headerCellClass() ?>"><div id="elh_member_scb_fullName" class="member_scb_fullName"><?= $Page->renderFieldHeader($Page->fullName) ?></div></th>
<?php } ?>
<?php if ($Page->age->Visible) { // age ?>
        <th data-name="age" class="<?= $Page->age->headerCellClass() ?>"><div id="elh_member_scb_age" class="member_scb_age"><?= $Page->renderFieldHeader($Page->age) ?></div></th>
<?php } ?>
<?php if ($Page->maritalStatus->Visible) { // maritalStatus ?>
        <th data-name="maritalStatus" class="<?= $Page->maritalStatus->headerCellClass() ?>"><div id="elh_member_scb_maritalStatus" class="member_scb_maritalStatus"><?= $Page->renderFieldHeader($Page->maritalStatus) ?></div></th>
<?php } ?>
<?php if ($Page->noOfChildren->Visible) { // noOfChildren ?>
        <th data-name="noOfChildren" class="<?= $Page->noOfChildren->headerCellClass() ?>"><div id="elh_member_scb_noOfChildren" class="member_scb_noOfChildren"><?= $Page->renderFieldHeader($Page->noOfChildren) ?></div></th>
<?php } ?>
<?php if ($Page->educationLevel->Visible) { // educationLevel ?>
        <th data-name="educationLevel" class="<?= $Page->educationLevel->headerCellClass() ?>"><div id="elh_member_scb_educationLevel" class="member_scb_educationLevel"><?= $Page->renderFieldHeader($Page->educationLevel) ?></div></th>
<?php } ?>
<?php if ($Page->workplace->Visible) { // workplace ?>
        <th data-name="workplace" class="<?= $Page->workplace->headerCellClass() ?>"><div id="elh_member_scb_workplace" class="member_scb_workplace"><?= $Page->renderFieldHeader($Page->workplace) ?></div></th>
<?php } ?>
<?php if ($Page->occupation->Visible) { // occupation ?>
        <th data-name="occupation" class="<?= $Page->occupation->headerCellClass() ?>"><div id="elh_member_scb_occupation" class="member_scb_occupation"><?= $Page->renderFieldHeader($Page->occupation) ?></div></th>
<?php } ?>
<?php if ($Page->jobPosition->Visible) { // jobPosition ?>
        <th data-name="jobPosition" class="<?= $Page->jobPosition->headerCellClass() ?>"><div id="elh_member_scb_jobPosition" class="member_scb_jobPosition"><?= $Page->renderFieldHeader($Page->jobPosition) ?></div></th>
<?php } ?>
<?php if ($Page->submissionDate->Visible) { // submissionDate ?>
        <th data-name="submissionDate" class="<?= $Page->submissionDate->headerCellClass() ?>"><div id="elh_member_scb_submissionDate" class="member_scb_submissionDate"><?= $Page->renderFieldHeader($Page->submissionDate) ?></div></th>
<?php } ?>
<?php if ($Page->bankruptcy_tendency->Visible) { // bankruptcy_tendency ?>
        <th data-name="bankruptcy_tendency" class="<?= $Page->bankruptcy_tendency->headerCellClass() ?>"><div id="elh_member_scb_bankruptcy_tendency" class="member_scb_bankruptcy_tendency"><?= $Page->renderFieldHeader($Page->bankruptcy_tendency) ?></div></th>
<?php } ?>
<?php if ($Page->blacklist_tendency->Visible) { // blacklist_tendency ?>
        <th data-name="blacklist_tendency" class="<?= $Page->blacklist_tendency->headerCellClass() ?>"><div id="elh_member_scb_blacklist_tendency" class="member_scb_blacklist_tendency"><?= $Page->renderFieldHeader($Page->blacklist_tendency) ?></div></th>
<?php } ?>
<?php if ($Page->money_laundering_tendency->Visible) { // money_laundering_tendency ?>
        <th data-name="money_laundering_tendency" class="<?= $Page->money_laundering_tendency->headerCellClass() ?>"><div id="elh_member_scb_money_laundering_tendency" class="member_scb_money_laundering_tendency"><?= $Page->renderFieldHeader($Page->money_laundering_tendency) ?></div></th>
<?php } ?>
<?php if ($Page->mobile_fraud_behavior->Visible) { // mobile_fraud_behavior ?>
        <th data-name="mobile_fraud_behavior" class="<?= $Page->mobile_fraud_behavior->headerCellClass() ?>"><div id="elh_member_scb_mobile_fraud_behavior" class="member_scb_mobile_fraud_behavior"><?= $Page->renderFieldHeader($Page->mobile_fraud_behavior) ?></div></th>
<?php } ?>
<?php if ($Page->face_similarity_score->Visible) { // face_similarity_score ?>
        <th data-name="face_similarity_score" class="<?= $Page->face_similarity_score->headerCellClass() ?>"><div id="elh_member_scb_face_similarity_score" class="member_scb_face_similarity_score"><?= $Page->renderFieldHeader($Page->face_similarity_score) ?></div></th>
<?php } ?>
<?php if ($Page->identification_verification_matched_flag->Visible) { // identification_verification_matched_flag ?>
        <th data-name="identification_verification_matched_flag" class="<?= $Page->identification_verification_matched_flag->headerCellClass() ?>"><div id="elh_member_scb_identification_verification_matched_flag" class="member_scb_identification_verification_matched_flag"><?= $Page->renderFieldHeader($Page->identification_verification_matched_flag) ?></div></th>
<?php } ?>
<?php if ($Page->bankstatement_confident_score->Visible) { // bankstatement_confident_score ?>
        <th data-name="bankstatement_confident_score" class="<?= $Page->bankstatement_confident_score->headerCellClass() ?>"><div id="elh_member_scb_bankstatement_confident_score" class="member_scb_bankstatement_confident_score"><?= $Page->renderFieldHeader($Page->bankstatement_confident_score) ?></div></th>
<?php } ?>
<?php if ($Page->estimated_monthly_income->Visible) { // estimated_monthly_income ?>
        <th data-name="estimated_monthly_income" class="<?= $Page->estimated_monthly_income->headerCellClass() ?>"><div id="elh_member_scb_estimated_monthly_income" class="member_scb_estimated_monthly_income"><?= $Page->renderFieldHeader($Page->estimated_monthly_income) ?></div></th>
<?php } ?>
<?php if ($Page->estimated_monthly_debt->Visible) { // estimated_monthly_debt ?>
        <th data-name="estimated_monthly_debt" class="<?= $Page->estimated_monthly_debt->headerCellClass() ?>"><div id="elh_member_scb_estimated_monthly_debt" class="member_scb_estimated_monthly_debt"><?= $Page->renderFieldHeader($Page->estimated_monthly_debt) ?></div></th>
<?php } ?>
<?php if ($Page->income_stability->Visible) { // income_stability ?>
        <th data-name="income_stability" class="<?= $Page->income_stability->headerCellClass() ?>"><div id="elh_member_scb_income_stability" class="member_scb_income_stability"><?= $Page->renderFieldHeader($Page->income_stability) ?></div></th>
<?php } ?>
<?php if ($Page->customer_grade->Visible) { // customer_grade ?>
        <th data-name="customer_grade" class="<?= $Page->customer_grade->headerCellClass() ?>"><div id="elh_member_scb_customer_grade" class="member_scb_customer_grade"><?= $Page->renderFieldHeader($Page->customer_grade) ?></div></th>
<?php } ?>
<?php if ($Page->color_sign->Visible) { // color_sign ?>
        <th data-name="color_sign" class="<?= $Page->color_sign->headerCellClass() ?>"><div id="elh_member_scb_color_sign" class="member_scb_color_sign"><?= $Page->renderFieldHeader($Page->color_sign) ?></div></th>
<?php } ?>
<?php if ($Page->rental_period->Visible) { // rental_period ?>
        <th data-name="rental_period" class="<?= $Page->rental_period->headerCellClass() ?>"><div id="elh_member_scb_rental_period" class="member_scb_rental_period"><?= $Page->renderFieldHeader($Page->rental_period) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_member_scb",
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
    <?php if ($Page->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_member_id" class="el_member_scb_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_asset_id" class="el_member_scb_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->reference_id->Visible) { // reference_id ?>
        <td data-name="reference_id"<?= $Page->reference_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_reference_id" class="el_member_scb_reference_id">
<span<?= $Page->reference_id->viewAttributes() ?>>
<?= $Page->reference_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->reference_url->Visible) { // reference_url ?>
        <td data-name="reference_url"<?= $Page->reference_url->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_reference_url" class="el_member_scb_reference_url">
<span<?= $Page->reference_url->viewAttributes() ?>>
<?= $Page->reference_url->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->state->Visible) { // state ?>
        <td data-name="state"<?= $Page->state->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_state" class="el_member_scb_state">
<span<?= $Page->state->viewAttributes() ?>>
<?= $Page->state->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_status" class="el_member_scb_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->decision_status->Visible) { // decision_status ?>
        <td data-name="decision_status"<?= $Page->decision_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_decision_status" class="el_member_scb_decision_status">
<span<?= $Page->decision_status->viewAttributes() ?>>
<?= $Page->decision_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_cdate" class="el_member_scb_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fullName->Visible) { // fullName ?>
        <td data-name="fullName"<?= $Page->fullName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_fullName" class="el_member_scb_fullName">
<span<?= $Page->fullName->viewAttributes() ?>>
<?= $Page->fullName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->age->Visible) { // age ?>
        <td data-name="age"<?= $Page->age->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_age" class="el_member_scb_age">
<span<?= $Page->age->viewAttributes() ?>>
<?= $Page->age->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->maritalStatus->Visible) { // maritalStatus ?>
        <td data-name="maritalStatus"<?= $Page->maritalStatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_maritalStatus" class="el_member_scb_maritalStatus">
<span<?= $Page->maritalStatus->viewAttributes() ?>>
<?= $Page->maritalStatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->noOfChildren->Visible) { // noOfChildren ?>
        <td data-name="noOfChildren"<?= $Page->noOfChildren->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_noOfChildren" class="el_member_scb_noOfChildren">
<span<?= $Page->noOfChildren->viewAttributes() ?>>
<?= $Page->noOfChildren->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->educationLevel->Visible) { // educationLevel ?>
        <td data-name="educationLevel"<?= $Page->educationLevel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_educationLevel" class="el_member_scb_educationLevel">
<span<?= $Page->educationLevel->viewAttributes() ?>>
<?= $Page->educationLevel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->workplace->Visible) { // workplace ?>
        <td data-name="workplace"<?= $Page->workplace->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_workplace" class="el_member_scb_workplace">
<span<?= $Page->workplace->viewAttributes() ?>>
<?= $Page->workplace->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->occupation->Visible) { // occupation ?>
        <td data-name="occupation"<?= $Page->occupation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_occupation" class="el_member_scb_occupation">
<span<?= $Page->occupation->viewAttributes() ?>>
<?= $Page->occupation->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jobPosition->Visible) { // jobPosition ?>
        <td data-name="jobPosition"<?= $Page->jobPosition->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_jobPosition" class="el_member_scb_jobPosition">
<span<?= $Page->jobPosition->viewAttributes() ?>>
<?= $Page->jobPosition->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->submissionDate->Visible) { // submissionDate ?>
        <td data-name="submissionDate"<?= $Page->submissionDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_submissionDate" class="el_member_scb_submissionDate">
<span<?= $Page->submissionDate->viewAttributes() ?>>
<?= $Page->submissionDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bankruptcy_tendency->Visible) { // bankruptcy_tendency ?>
        <td data-name="bankruptcy_tendency"<?= $Page->bankruptcy_tendency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_bankruptcy_tendency" class="el_member_scb_bankruptcy_tendency">
<span<?= $Page->bankruptcy_tendency->viewAttributes() ?>>
<?= $Page->bankruptcy_tendency->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->blacklist_tendency->Visible) { // blacklist_tendency ?>
        <td data-name="blacklist_tendency"<?= $Page->blacklist_tendency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_blacklist_tendency" class="el_member_scb_blacklist_tendency">
<span<?= $Page->blacklist_tendency->viewAttributes() ?>>
<?= $Page->blacklist_tendency->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->money_laundering_tendency->Visible) { // money_laundering_tendency ?>
        <td data-name="money_laundering_tendency"<?= $Page->money_laundering_tendency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_money_laundering_tendency" class="el_member_scb_money_laundering_tendency">
<span<?= $Page->money_laundering_tendency->viewAttributes() ?>>
<?= $Page->money_laundering_tendency->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mobile_fraud_behavior->Visible) { // mobile_fraud_behavior ?>
        <td data-name="mobile_fraud_behavior"<?= $Page->mobile_fraud_behavior->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_mobile_fraud_behavior" class="el_member_scb_mobile_fraud_behavior">
<span<?= $Page->mobile_fraud_behavior->viewAttributes() ?>>
<?= $Page->mobile_fraud_behavior->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->face_similarity_score->Visible) { // face_similarity_score ?>
        <td data-name="face_similarity_score"<?= $Page->face_similarity_score->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_face_similarity_score" class="el_member_scb_face_similarity_score">
<span<?= $Page->face_similarity_score->viewAttributes() ?>>
<?= $Page->face_similarity_score->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->identification_verification_matched_flag->Visible) { // identification_verification_matched_flag ?>
        <td data-name="identification_verification_matched_flag"<?= $Page->identification_verification_matched_flag->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_identification_verification_matched_flag" class="el_member_scb_identification_verification_matched_flag">
<span<?= $Page->identification_verification_matched_flag->viewAttributes() ?>>
<?= $Page->identification_verification_matched_flag->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bankstatement_confident_score->Visible) { // bankstatement_confident_score ?>
        <td data-name="bankstatement_confident_score"<?= $Page->bankstatement_confident_score->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_bankstatement_confident_score" class="el_member_scb_bankstatement_confident_score">
<span<?= $Page->bankstatement_confident_score->viewAttributes() ?>>
<?= $Page->bankstatement_confident_score->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estimated_monthly_income->Visible) { // estimated_monthly_income ?>
        <td data-name="estimated_monthly_income"<?= $Page->estimated_monthly_income->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_estimated_monthly_income" class="el_member_scb_estimated_monthly_income">
<span<?= $Page->estimated_monthly_income->viewAttributes() ?>>
<?= $Page->estimated_monthly_income->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estimated_monthly_debt->Visible) { // estimated_monthly_debt ?>
        <td data-name="estimated_monthly_debt"<?= $Page->estimated_monthly_debt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_estimated_monthly_debt" class="el_member_scb_estimated_monthly_debt">
<span<?= $Page->estimated_monthly_debt->viewAttributes() ?>>
<?= $Page->estimated_monthly_debt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->income_stability->Visible) { // income_stability ?>
        <td data-name="income_stability"<?= $Page->income_stability->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_income_stability" class="el_member_scb_income_stability">
<span<?= $Page->income_stability->viewAttributes() ?>>
<?= $Page->income_stability->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->customer_grade->Visible) { // customer_grade ?>
        <td data-name="customer_grade"<?= $Page->customer_grade->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_customer_grade" class="el_member_scb_customer_grade">
<span<?= $Page->customer_grade->viewAttributes() ?>>
<?= $Page->customer_grade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->color_sign->Visible) { // color_sign ?>
        <td data-name="color_sign"<?= $Page->color_sign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_color_sign" class="el_member_scb_color_sign">
<span<?= $Page->color_sign->viewAttributes() ?>>
<?= $Page->color_sign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rental_period->Visible) { // rental_period ?>
        <td data-name="rental_period"<?= $Page->rental_period->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_rental_period" class="el_member_scb_rental_period">
<span<?= $Page->rental_period->viewAttributes() ?>>
<?= $Page->rental_period->getViewValue() ?></span>
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
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("member_scb");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
