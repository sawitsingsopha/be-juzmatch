<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden: currentTable } });
var currentForm, currentPageID;
var fdoc_credenlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_credenlist = new ew.Form("fdoc_credenlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fdoc_credenlist;
    fdoc_credenlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fdoc_credenlist");
});
var fdoc_credensrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fdoc_credensrch = new ew.Form("fdoc_credensrch", "list");
    currentSearchForm = fdoc_credensrch;

    // Dynamic selection lists

    // Filters
    fdoc_credensrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fdoc_credensrch");
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
<form name="fdoc_credensrch" id="fdoc_credensrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fdoc_credensrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="doc_creden">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdoc_credensrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdoc_credensrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdoc_credensrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdoc_credensrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doc_creden">
<form name="fdoc_credenlist" id="fdoc_credenlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden">
<div id="gmp_doc_creden" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_doc_credenlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->document_id->Visible) { // document_id ?>
        <th data-name="document_id" class="<?= $Page->document_id->headerCellClass() ?>"><div id="elh_doc_creden_document_id" class="doc_creden_document_id"><?= $Page->renderFieldHeader($Page->document_id) ?></div></th>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <th data-name="doc_creden_id" class="<?= $Page->doc_creden_id->headerCellClass() ?>"><div id="elh_doc_creden_doc_creden_id" class="doc_creden_doc_creden_id"><?= $Page->renderFieldHeader($Page->doc_creden_id) ?></div></th>
<?php } ?>
<?php if ($Page->doc_temp_id->Visible) { // doc_temp_id ?>
        <th data-name="doc_temp_id" class="<?= $Page->doc_temp_id->headerCellClass() ?>"><div id="elh_doc_creden_doc_temp_id" class="doc_creden_doc_temp_id"><?= $Page->renderFieldHeader($Page->doc_temp_id) ?></div></th>
<?php } ?>
<?php if ($Page->txid->Visible) { // txid ?>
        <th data-name="txid" class="<?= $Page->txid->headerCellClass() ?>"><div id="elh_doc_creden_txid" class="doc_creden_txid"><?= $Page->renderFieldHeader($Page->txid) ?></div></th>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
        <th data-name="subject" class="<?= $Page->subject->headerCellClass() ?>"><div id="elh_doc_creden_subject" class="doc_creden_subject"><?= $Page->renderFieldHeader($Page->subject) ?></div></th>
<?php } ?>
<?php if ($Page->send_email->Visible) { // send_email ?>
        <th data-name="send_email" class="<?= $Page->send_email->headerCellClass() ?>"><div id="elh_doc_creden_send_email" class="doc_creden_send_email"><?= $Page->renderFieldHeader($Page->send_email) ?></div></th>
<?php } ?>
<?php if ($Page->redirect_url->Visible) { // redirect_url ?>
        <th data-name="redirect_url" class="<?= $Page->redirect_url->headerCellClass() ?>"><div id="elh_doc_creden_redirect_url" class="doc_creden_redirect_url"><?= $Page->renderFieldHeader($Page->redirect_url) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_doc_creden_status" class="doc_creden_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_doc_creden_cdate" class="doc_creden_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_doc_creden_cuser" class="doc_creden_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_doc_creden_cip" class="doc_creden_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_doc_creden_udate" class="doc_creden_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_doc_creden_uuser" class="doc_creden_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_doc_creden_uip" class="doc_creden_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
<?php } ?>
<?php if ($Page->doc_url->Visible) { // doc_url ?>
        <th data-name="doc_url" class="<?= $Page->doc_url->headerCellClass() ?>"><div id="elh_doc_creden_doc_url" class="doc_creden_doc_url"><?= $Page->renderFieldHeader($Page->doc_url) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_doc_creden",
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
    <?php if ($Page->document_id->Visible) { // document_id ?>
        <td data-name="document_id"<?= $Page->document_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_document_id" class="el_doc_creden_document_id">
<span<?= $Page->document_id->viewAttributes() ?>>
<?= $Page->document_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <td data-name="doc_creden_id"<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_doc_creden_id" class="el_doc_creden_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_temp_id->Visible) { // doc_temp_id ?>
        <td data-name="doc_temp_id"<?= $Page->doc_temp_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_doc_temp_id" class="el_doc_creden_doc_temp_id">
<span<?= $Page->doc_temp_id->viewAttributes() ?>>
<?= $Page->doc_temp_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->txid->Visible) { // txid ?>
        <td data-name="txid"<?= $Page->txid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_txid" class="el_doc_creden_txid">
<span<?= $Page->txid->viewAttributes() ?>>
<?= $Page->txid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subject->Visible) { // subject ?>
        <td data-name="subject"<?= $Page->subject->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_subject" class="el_doc_creden_subject">
<span<?= $Page->subject->viewAttributes() ?>>
<?= $Page->subject->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->send_email->Visible) { // send_email ?>
        <td data-name="send_email"<?= $Page->send_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_send_email" class="el_doc_creden_send_email">
<span<?= $Page->send_email->viewAttributes() ?>>
<?= $Page->send_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->redirect_url->Visible) { // redirect_url ?>
        <td data-name="redirect_url"<?= $Page->redirect_url->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_redirect_url" class="el_doc_creden_redirect_url">
<span<?= $Page->redirect_url->viewAttributes() ?>>
<?= $Page->redirect_url->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_status" class="el_doc_creden_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_cdate" class="el_doc_creden_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_cuser" class="el_doc_creden_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_cip" class="el_doc_creden_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_udate" class="el_doc_creden_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_uuser" class="el_doc_creden_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_uip" class="el_doc_creden_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doc_url->Visible) { // doc_url ?>
        <td data-name="doc_url"<?= $Page->doc_url->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_doc_url" class="el_doc_creden_doc_url">
<span<?= $Page->doc_url->viewAttributes() ?>>
<?= $Page->doc_url->getViewValue() ?></span>
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
    ew.addEventHandlers("doc_creden");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
