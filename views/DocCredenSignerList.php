<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenSignerList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_signer: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_signerlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_signerlist = new ew.Form("fdoc_creden_signerlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fdoc_creden_signerlist;
    fdoc_creden_signerlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fdoc_creden_signerlist");
});
var fdoc_creden_signersrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fdoc_creden_signersrch = new ew.Form("fdoc_creden_signersrch", "list");
    currentSearchForm = fdoc_creden_signersrch;

    // Dynamic selection lists

    // Filters
    fdoc_creden_signersrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fdoc_creden_signersrch");
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
<form name="fdoc_creden_signersrch" id="fdoc_creden_signersrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fdoc_creden_signersrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="doc_creden_signer">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdoc_creden_signersrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdoc_creden_signersrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdoc_creden_signersrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdoc_creden_signersrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doc_creden_signer">
<form name="fdoc_creden_signerlist" id="fdoc_creden_signerlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_signer">
<div id="gmp_doc_creden_signer" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_doc_creden_signerlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->doc_creden_signer_id->Visible) { // doc_creden_signer_id ?>
        <th data-name="doc_creden_signer_id" class="<?= $Page->doc_creden_signer_id->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_signer_id" class="doc_creden_signer_doc_creden_signer_id"><?= $Page->renderFieldHeader($Page->doc_creden_signer_id) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <th data-name="doc_creden_id" class="<?= $Page->doc_creden_id->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_id" class="doc_creden_signer_doc_creden_id"><?= $Page->renderFieldHeader($Page->doc_creden_id) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_no->Visible) { // doc_creden_signer_no ?>
        <th data-name="doc_creden_signer_no" class="<?= $Page->doc_creden_signer_no->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_signer_no" class="doc_creden_signer_doc_creden_signer_no"><?= $Page->renderFieldHeader($Page->doc_creden_signer_no) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_link->Visible) { // doc_creden_signer_link ?>
        <th data-name="doc_creden_signer_link" class="<?= $Page->doc_creden_signer_link->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_signer_link" class="doc_creden_signer_doc_creden_signer_link"><?= $Page->renderFieldHeader($Page->doc_creden_signer_link) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_session->Visible) { // doc_creden_signer_session ?>
        <th data-name="doc_creden_signer_session" class="<?= $Page->doc_creden_signer_session->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_signer_session" class="doc_creden_signer_doc_creden_signer_session"><?= $Page->renderFieldHeader($Page->doc_creden_signer_session) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_name->Visible) { // doc_creden_signer_name ?>
        <th data-name="doc_creden_signer_name" class="<?= $Page->doc_creden_signer_name->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_signer_name" class="doc_creden_signer_doc_creden_signer_name"><?= $Page->renderFieldHeader($Page->doc_creden_signer_name) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_email->Visible) { // doc_creden_signer_email ?>
        <th data-name="doc_creden_signer_email" class="<?= $Page->doc_creden_signer_email->headerCellClass() ?>"><div id="elh_doc_creden_signer_doc_creden_signer_email" class="doc_creden_signer_doc_creden_signer_email"><?= $Page->renderFieldHeader($Page->doc_creden_signer_email) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_doc_creden_signer_status" class="doc_creden_signer_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_doc_creden_signer_cdate" class="doc_creden_signer_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_doc_creden_signer_cuser" class="doc_creden_signer_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_doc_creden_signer_cip" class="doc_creden_signer_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_doc_creden_signer_udate" class="doc_creden_signer_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_doc_creden_signer_uuser" class="doc_creden_signer_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_doc_creden_signer_uip" class="doc_creden_signer_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_doc_creden_signer",
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
    <?php if ($Page->doc_creden_signer_id->Visible) { // doc_creden_signer_id ?>
        <td data-name="doc_creden_signer_id"<?= $Page->doc_creden_signer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_id" class="el_doc_creden_signer_doc_creden_signer_id">
<span<?= $Page->doc_creden_signer_id->viewAttributes() ?>>
<?= $Page->doc_creden_signer_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <td data-name="doc_creden_id"<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_id" class="el_doc_creden_signer_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_signer_no->Visible) { // doc_creden_signer_no ?>
        <td data-name="doc_creden_signer_no"<?= $Page->doc_creden_signer_no->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_no" class="el_doc_creden_signer_doc_creden_signer_no">
<span<?= $Page->doc_creden_signer_no->viewAttributes() ?>>
<?= $Page->doc_creden_signer_no->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_signer_link->Visible) { // doc_creden_signer_link ?>
        <td data-name="doc_creden_signer_link"<?= $Page->doc_creden_signer_link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_link" class="el_doc_creden_signer_doc_creden_signer_link">
<span<?= $Page->doc_creden_signer_link->viewAttributes() ?>>
<?= $Page->doc_creden_signer_link->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_signer_session->Visible) { // doc_creden_signer_session ?>
        <td data-name="doc_creden_signer_session"<?= $Page->doc_creden_signer_session->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_session" class="el_doc_creden_signer_doc_creden_signer_session">
<span<?= $Page->doc_creden_signer_session->viewAttributes() ?>>
<?= $Page->doc_creden_signer_session->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_signer_name->Visible) { // doc_creden_signer_name ?>
        <td data-name="doc_creden_signer_name"<?= $Page->doc_creden_signer_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_name" class="el_doc_creden_signer_doc_creden_signer_name">
<span<?= $Page->doc_creden_signer_name->viewAttributes() ?>>
<?= $Page->doc_creden_signer_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_signer_email->Visible) { // doc_creden_signer_email ?>
        <td data-name="doc_creden_signer_email"<?= $Page->doc_creden_signer_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_email" class="el_doc_creden_signer_doc_creden_signer_email">
<span<?= $Page->doc_creden_signer_email->viewAttributes() ?>>
<?= $Page->doc_creden_signer_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_status" class="el_doc_creden_signer_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_cdate" class="el_doc_creden_signer_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_cuser" class="el_doc_creden_signer_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_cip" class="el_doc_creden_signer_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_udate" class="el_doc_creden_signer_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_uuser" class="el_doc_creden_signer_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_uip" class="el_doc_creden_signer_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
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
    ew.addEventHandlers("doc_creden_signer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
