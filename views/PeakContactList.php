<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakContactList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_contact: currentTable } });
var currentForm, currentPageID;
var fpeak_contactlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_contactlist = new ew.Form("fpeak_contactlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpeak_contactlist;
    fpeak_contactlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpeak_contactlist");
});
var fpeak_contactsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpeak_contactsrch = new ew.Form("fpeak_contactsrch", "list");
    currentSearchForm = fpeak_contactsrch;

    // Dynamic selection lists

    // Filters
    fpeak_contactsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpeak_contactsrch");
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
<form name="fpeak_contactsrch" id="fpeak_contactsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpeak_contactsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="peak_contact">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpeak_contactsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpeak_contactsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpeak_contactsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpeak_contactsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> peak_contact">
<form name="fpeak_contactlist" id="fpeak_contactlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_contact">
<div id="gmp_peak_contact" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_peak_contactlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_peak_contact_id" class="peak_contact_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th data-name="create_date" class="<?= $Page->create_date->headerCellClass() ?>"><div id="elh_peak_contact_create_date" class="peak_contact_create_date"><?= $Page->renderFieldHeader($Page->create_date) ?></div></th>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
        <th data-name="request_status" class="<?= $Page->request_status->headerCellClass() ?>"><div id="elh_peak_contact_request_status" class="peak_contact_request_status"><?= $Page->renderFieldHeader($Page->request_status) ?></div></th>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
        <th data-name="request_date" class="<?= $Page->request_date->headerCellClass() ?>"><div id="elh_peak_contact_request_date" class="peak_contact_request_date"><?= $Page->renderFieldHeader($Page->request_date) ?></div></th>
<?php } ?>
<?php if ($Page->contact_id->Visible) { // contact_id ?>
        <th data-name="contact_id" class="<?= $Page->contact_id->headerCellClass() ?>"><div id="elh_peak_contact_contact_id" class="peak_contact_contact_id"><?= $Page->renderFieldHeader($Page->contact_id) ?></div></th>
<?php } ?>
<?php if ($Page->contact_code->Visible) { // contact_code ?>
        <th data-name="contact_code" class="<?= $Page->contact_code->headerCellClass() ?>"><div id="elh_peak_contact_contact_code" class="peak_contact_contact_code"><?= $Page->renderFieldHeader($Page->contact_code) ?></div></th>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
        <th data-name="contact_name" class="<?= $Page->contact_name->headerCellClass() ?>"><div id="elh_peak_contact_contact_name" class="peak_contact_contact_name"><?= $Page->renderFieldHeader($Page->contact_name) ?></div></th>
<?php } ?>
<?php if ($Page->contact_type->Visible) { // contact_type ?>
        <th data-name="contact_type" class="<?= $Page->contact_type->headerCellClass() ?>"><div id="elh_peak_contact_contact_type" class="peak_contact_contact_type"><?= $Page->renderFieldHeader($Page->contact_type) ?></div></th>
<?php } ?>
<?php if ($Page->contact_taxnumber->Visible) { // contact_taxnumber ?>
        <th data-name="contact_taxnumber" class="<?= $Page->contact_taxnumber->headerCellClass() ?>"><div id="elh_peak_contact_contact_taxnumber" class="peak_contact_contact_taxnumber"><?= $Page->renderFieldHeader($Page->contact_taxnumber) ?></div></th>
<?php } ?>
<?php if ($Page->contact_branchcode->Visible) { // contact_branchcode ?>
        <th data-name="contact_branchcode" class="<?= $Page->contact_branchcode->headerCellClass() ?>"><div id="elh_peak_contact_contact_branchcode" class="peak_contact_contact_branchcode"><?= $Page->renderFieldHeader($Page->contact_branchcode) ?></div></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th data-name="contact_address" class="<?= $Page->contact_address->headerCellClass() ?>"><div id="elh_peak_contact_contact_address" class="peak_contact_contact_address"><?= $Page->renderFieldHeader($Page->contact_address) ?></div></th>
<?php } ?>
<?php if ($Page->contact_subdistrict->Visible) { // contact_subdistrict ?>
        <th data-name="contact_subdistrict" class="<?= $Page->contact_subdistrict->headerCellClass() ?>"><div id="elh_peak_contact_contact_subdistrict" class="peak_contact_contact_subdistrict"><?= $Page->renderFieldHeader($Page->contact_subdistrict) ?></div></th>
<?php } ?>
<?php if ($Page->contact_district->Visible) { // contact_district ?>
        <th data-name="contact_district" class="<?= $Page->contact_district->headerCellClass() ?>"><div id="elh_peak_contact_contact_district" class="peak_contact_contact_district"><?= $Page->renderFieldHeader($Page->contact_district) ?></div></th>
<?php } ?>
<?php if ($Page->contact_province->Visible) { // contact_province ?>
        <th data-name="contact_province" class="<?= $Page->contact_province->headerCellClass() ?>"><div id="elh_peak_contact_contact_province" class="peak_contact_contact_province"><?= $Page->renderFieldHeader($Page->contact_province) ?></div></th>
<?php } ?>
<?php if ($Page->contact_country->Visible) { // contact_country ?>
        <th data-name="contact_country" class="<?= $Page->contact_country->headerCellClass() ?>"><div id="elh_peak_contact_contact_country" class="peak_contact_contact_country"><?= $Page->renderFieldHeader($Page->contact_country) ?></div></th>
<?php } ?>
<?php if ($Page->contact_postcode->Visible) { // contact_postcode ?>
        <th data-name="contact_postcode" class="<?= $Page->contact_postcode->headerCellClass() ?>"><div id="elh_peak_contact_contact_postcode" class="peak_contact_contact_postcode"><?= $Page->renderFieldHeader($Page->contact_postcode) ?></div></th>
<?php } ?>
<?php if ($Page->contact_callcenternumber->Visible) { // contact_callcenternumber ?>
        <th data-name="contact_callcenternumber" class="<?= $Page->contact_callcenternumber->headerCellClass() ?>"><div id="elh_peak_contact_contact_callcenternumber" class="peak_contact_contact_callcenternumber"><?= $Page->renderFieldHeader($Page->contact_callcenternumber) ?></div></th>
<?php } ?>
<?php if ($Page->contact_faxnumber->Visible) { // contact_faxnumber ?>
        <th data-name="contact_faxnumber" class="<?= $Page->contact_faxnumber->headerCellClass() ?>"><div id="elh_peak_contact_contact_faxnumber" class="peak_contact_contact_faxnumber"><?= $Page->renderFieldHeader($Page->contact_faxnumber) ?></div></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th data-name="contact_email" class="<?= $Page->contact_email->headerCellClass() ?>"><div id="elh_peak_contact_contact_email" class="peak_contact_contact_email"><?= $Page->renderFieldHeader($Page->contact_email) ?></div></th>
<?php } ?>
<?php if ($Page->contact_website->Visible) { // contact_website ?>
        <th data-name="contact_website" class="<?= $Page->contact_website->headerCellClass() ?>"><div id="elh_peak_contact_contact_website" class="peak_contact_contact_website"><?= $Page->renderFieldHeader($Page->contact_website) ?></div></th>
<?php } ?>
<?php if ($Page->contact_contactfirstname->Visible) { // contact_contactfirstname ?>
        <th data-name="contact_contactfirstname" class="<?= $Page->contact_contactfirstname->headerCellClass() ?>"><div id="elh_peak_contact_contact_contactfirstname" class="peak_contact_contact_contactfirstname"><?= $Page->renderFieldHeader($Page->contact_contactfirstname) ?></div></th>
<?php } ?>
<?php if ($Page->contact_contactlastname->Visible) { // contact_contactlastname ?>
        <th data-name="contact_contactlastname" class="<?= $Page->contact_contactlastname->headerCellClass() ?>"><div id="elh_peak_contact_contact_contactlastname" class="peak_contact_contact_contactlastname"><?= $Page->renderFieldHeader($Page->contact_contactlastname) ?></div></th>
<?php } ?>
<?php if ($Page->contact_contactnickname->Visible) { // contact_contactnickname ?>
        <th data-name="contact_contactnickname" class="<?= $Page->contact_contactnickname->headerCellClass() ?>"><div id="elh_peak_contact_contact_contactnickname" class="peak_contact_contact_contactnickname"><?= $Page->renderFieldHeader($Page->contact_contactnickname) ?></div></th>
<?php } ?>
<?php if ($Page->contact_contactpostition->Visible) { // contact_contactpostition ?>
        <th data-name="contact_contactpostition" class="<?= $Page->contact_contactpostition->headerCellClass() ?>"><div id="elh_peak_contact_contact_contactpostition" class="peak_contact_contact_contactpostition"><?= $Page->renderFieldHeader($Page->contact_contactpostition) ?></div></th>
<?php } ?>
<?php if ($Page->contact_contactphonenumber->Visible) { // contact_contactphonenumber ?>
        <th data-name="contact_contactphonenumber" class="<?= $Page->contact_contactphonenumber->headerCellClass() ?>"><div id="elh_peak_contact_contact_contactphonenumber" class="peak_contact_contact_contactphonenumber"><?= $Page->renderFieldHeader($Page->contact_contactphonenumber) ?></div></th>
<?php } ?>
<?php if ($Page->contact_contactcontactemail->Visible) { // contact_contactcontactemail ?>
        <th data-name="contact_contactcontactemail" class="<?= $Page->contact_contactcontactemail->headerCellClass() ?>"><div id="elh_peak_contact_contact_contactcontactemail" class="peak_contact_contact_contactcontactemail"><?= $Page->renderFieldHeader($Page->contact_contactcontactemail) ?></div></th>
<?php } ?>
<?php if ($Page->contact_purchaseaccount->Visible) { // contact_purchaseaccount ?>
        <th data-name="contact_purchaseaccount" class="<?= $Page->contact_purchaseaccount->headerCellClass() ?>"><div id="elh_peak_contact_contact_purchaseaccount" class="peak_contact_contact_purchaseaccount"><?= $Page->renderFieldHeader($Page->contact_purchaseaccount) ?></div></th>
<?php } ?>
<?php if ($Page->contact_sellaccount->Visible) { // contact_sellaccount ?>
        <th data-name="contact_sellaccount" class="<?= $Page->contact_sellaccount->headerCellClass() ?>"><div id="elh_peak_contact_contact_sellaccount" class="peak_contact_contact_sellaccount"><?= $Page->renderFieldHeader($Page->contact_sellaccount) ?></div></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Page->member_id->headerCellClass() ?>"><div id="elh_peak_contact_member_id" class="peak_contact_member_id"><?= $Page->renderFieldHeader($Page->member_id) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_peak_contact",
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_id" class="el_peak_contact_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->create_date->Visible) { // create_date ?>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_create_date" class="el_peak_contact_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->request_status->Visible) { // request_status ?>
        <td data-name="request_status"<?= $Page->request_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_request_status" class="el_peak_contact_request_status">
<span<?= $Page->request_status->viewAttributes() ?>>
<?= $Page->request_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->request_date->Visible) { // request_date ?>
        <td data-name="request_date"<?= $Page->request_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_request_date" class="el_peak_contact_request_date">
<span<?= $Page->request_date->viewAttributes() ?>>
<?= $Page->request_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_id->Visible) { // contact_id ?>
        <td data-name="contact_id"<?= $Page->contact_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_id" class="el_peak_contact_contact_id">
<span<?= $Page->contact_id->viewAttributes() ?>>
<?= $Page->contact_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_code->Visible) { // contact_code ?>
        <td data-name="contact_code"<?= $Page->contact_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_code" class="el_peak_contact_contact_code">
<span<?= $Page->contact_code->viewAttributes() ?>>
<?= $Page->contact_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_name->Visible) { // contact_name ?>
        <td data-name="contact_name"<?= $Page->contact_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_name" class="el_peak_contact_contact_name">
<span<?= $Page->contact_name->viewAttributes() ?>>
<?= $Page->contact_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_type->Visible) { // contact_type ?>
        <td data-name="contact_type"<?= $Page->contact_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_type" class="el_peak_contact_contact_type">
<span<?= $Page->contact_type->viewAttributes() ?>>
<?= $Page->contact_type->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_taxnumber->Visible) { // contact_taxnumber ?>
        <td data-name="contact_taxnumber"<?= $Page->contact_taxnumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_taxnumber" class="el_peak_contact_contact_taxnumber">
<span<?= $Page->contact_taxnumber->viewAttributes() ?>>
<?= $Page->contact_taxnumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_branchcode->Visible) { // contact_branchcode ?>
        <td data-name="contact_branchcode"<?= $Page->contact_branchcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_branchcode" class="el_peak_contact_contact_branchcode">
<span<?= $Page->contact_branchcode->viewAttributes() ?>>
<?= $Page->contact_branchcode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td data-name="contact_address"<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_address" class="el_peak_contact_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_subdistrict->Visible) { // contact_subdistrict ?>
        <td data-name="contact_subdistrict"<?= $Page->contact_subdistrict->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_subdistrict" class="el_peak_contact_contact_subdistrict">
<span<?= $Page->contact_subdistrict->viewAttributes() ?>>
<?= $Page->contact_subdistrict->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_district->Visible) { // contact_district ?>
        <td data-name="contact_district"<?= $Page->contact_district->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_district" class="el_peak_contact_contact_district">
<span<?= $Page->contact_district->viewAttributes() ?>>
<?= $Page->contact_district->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_province->Visible) { // contact_province ?>
        <td data-name="contact_province"<?= $Page->contact_province->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_province" class="el_peak_contact_contact_province">
<span<?= $Page->contact_province->viewAttributes() ?>>
<?= $Page->contact_province->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_country->Visible) { // contact_country ?>
        <td data-name="contact_country"<?= $Page->contact_country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_country" class="el_peak_contact_contact_country">
<span<?= $Page->contact_country->viewAttributes() ?>>
<?= $Page->contact_country->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_postcode->Visible) { // contact_postcode ?>
        <td data-name="contact_postcode"<?= $Page->contact_postcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_postcode" class="el_peak_contact_contact_postcode">
<span<?= $Page->contact_postcode->viewAttributes() ?>>
<?= $Page->contact_postcode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_callcenternumber->Visible) { // contact_callcenternumber ?>
        <td data-name="contact_callcenternumber"<?= $Page->contact_callcenternumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_callcenternumber" class="el_peak_contact_contact_callcenternumber">
<span<?= $Page->contact_callcenternumber->viewAttributes() ?>>
<?= $Page->contact_callcenternumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_faxnumber->Visible) { // contact_faxnumber ?>
        <td data-name="contact_faxnumber"<?= $Page->contact_faxnumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_faxnumber" class="el_peak_contact_contact_faxnumber">
<span<?= $Page->contact_faxnumber->viewAttributes() ?>>
<?= $Page->contact_faxnumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td data-name="contact_email"<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_email" class="el_peak_contact_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_website->Visible) { // contact_website ?>
        <td data-name="contact_website"<?= $Page->contact_website->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_website" class="el_peak_contact_contact_website">
<span<?= $Page->contact_website->viewAttributes() ?>>
<?= $Page->contact_website->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_contactfirstname->Visible) { // contact_contactfirstname ?>
        <td data-name="contact_contactfirstname"<?= $Page->contact_contactfirstname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactfirstname" class="el_peak_contact_contact_contactfirstname">
<span<?= $Page->contact_contactfirstname->viewAttributes() ?>>
<?= $Page->contact_contactfirstname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_contactlastname->Visible) { // contact_contactlastname ?>
        <td data-name="contact_contactlastname"<?= $Page->contact_contactlastname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactlastname" class="el_peak_contact_contact_contactlastname">
<span<?= $Page->contact_contactlastname->viewAttributes() ?>>
<?= $Page->contact_contactlastname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_contactnickname->Visible) { // contact_contactnickname ?>
        <td data-name="contact_contactnickname"<?= $Page->contact_contactnickname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactnickname" class="el_peak_contact_contact_contactnickname">
<span<?= $Page->contact_contactnickname->viewAttributes() ?>>
<?= $Page->contact_contactnickname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_contactpostition->Visible) { // contact_contactpostition ?>
        <td data-name="contact_contactpostition"<?= $Page->contact_contactpostition->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactpostition" class="el_peak_contact_contact_contactpostition">
<span<?= $Page->contact_contactpostition->viewAttributes() ?>>
<?= $Page->contact_contactpostition->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_contactphonenumber->Visible) { // contact_contactphonenumber ?>
        <td data-name="contact_contactphonenumber"<?= $Page->contact_contactphonenumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactphonenumber" class="el_peak_contact_contact_contactphonenumber">
<span<?= $Page->contact_contactphonenumber->viewAttributes() ?>>
<?= $Page->contact_contactphonenumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_contactcontactemail->Visible) { // contact_contactcontactemail ?>
        <td data-name="contact_contactcontactemail"<?= $Page->contact_contactcontactemail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactcontactemail" class="el_peak_contact_contact_contactcontactemail">
<span<?= $Page->contact_contactcontactemail->viewAttributes() ?>>
<?= $Page->contact_contactcontactemail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_purchaseaccount->Visible) { // contact_purchaseaccount ?>
        <td data-name="contact_purchaseaccount"<?= $Page->contact_purchaseaccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_purchaseaccount" class="el_peak_contact_contact_purchaseaccount">
<span<?= $Page->contact_purchaseaccount->viewAttributes() ?>>
<?= $Page->contact_purchaseaccount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_sellaccount->Visible) { // contact_sellaccount ?>
        <td data-name="contact_sellaccount"<?= $Page->contact_sellaccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_sellaccount" class="el_peak_contact_contact_sellaccount">
<span<?= $Page->contact_sellaccount->viewAttributes() ?>>
<?= $Page->contact_sellaccount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_member_id" class="el_peak_contact_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
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
    ew.addEventHandlers("peak_contact");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
