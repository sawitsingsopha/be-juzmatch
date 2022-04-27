<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberScbDetailLogList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member_scb_detail_log: currentTable } });
var currentForm, currentPageID;
var fmember_scb_detail_loglist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmember_scb_detail_loglist = new ew.Form("fmember_scb_detail_loglist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fmember_scb_detail_loglist;
    fmember_scb_detail_loglist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fmember_scb_detail_loglist");
});
var fmember_scb_detail_logsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fmember_scb_detail_logsrch = new ew.Form("fmember_scb_detail_logsrch", "list");
    currentSearchForm = fmember_scb_detail_logsrch;

    // Dynamic selection lists

    // Filters
    fmember_scb_detail_logsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmember_scb_detail_logsrch");
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
<form name="fmember_scb_detail_logsrch" id="fmember_scb_detail_logsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fmember_scb_detail_logsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="member_scb_detail_log">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fmember_scb_detail_logsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fmember_scb_detail_logsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fmember_scb_detail_logsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fmember_scb_detail_logsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> member_scb_detail_log">
<form name="fmember_scb_detail_loglist" id="fmember_scb_detail_loglist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member_scb_detail_log">
<div id="gmp_member_scb_detail_log" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_member_scb_detail_loglist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->member_scb_detail_log_id->Visible) { // member_scb_detail_log_id ?>
        <th data-name="member_scb_detail_log_id" class="<?= $Page->member_scb_detail_log_id->headerCellClass() ?>"><div id="elh_member_scb_detail_log_member_scb_detail_log_id" class="member_scb_detail_log_member_scb_detail_log_id"><?= $Page->renderFieldHeader($Page->member_scb_detail_log_id) ?></div></th>
<?php } ?>
<?php if ($Page->member_scb_id->Visible) { // member_scb_id ?>
        <th data-name="member_scb_id" class="<?= $Page->member_scb_id->headerCellClass() ?>"><div id="elh_member_scb_detail_log_member_scb_id" class="member_scb_detail_log_member_scb_id"><?= $Page->renderFieldHeader($Page->member_scb_id) ?></div></th>
<?php } ?>
<?php if ($Page->paid_amt->Visible) { // paid_amt ?>
        <th data-name="paid_amt" class="<?= $Page->paid_amt->headerCellClass() ?>"><div id="elh_member_scb_detail_log_paid_amt" class="member_scb_detail_log_paid_amt"><?= $Page->renderFieldHeader($Page->paid_amt) ?></div></th>
<?php } ?>
<?php if ($Page->pay_date->Visible) { // pay_date ?>
        <th data-name="pay_date" class="<?= $Page->pay_date->headerCellClass() ?>"><div id="elh_member_scb_detail_log_pay_date" class="member_scb_detail_log_pay_date"><?= $Page->renderFieldHeader($Page->pay_date) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_member_scb_detail_log_cdate" class="member_scb_detail_log_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_member_scb_detail_log_cip" class="member_scb_detail_log_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_member_scb_detail_log_cuser" class="member_scb_detail_log_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_member_scb_detail_log",
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
    <?php if ($Page->member_scb_detail_log_id->Visible) { // member_scb_detail_log_id ?>
        <td data-name="member_scb_detail_log_id"<?= $Page->member_scb_detail_log_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_member_scb_detail_log_id" class="el_member_scb_detail_log_member_scb_detail_log_id">
<span<?= $Page->member_scb_detail_log_id->viewAttributes() ?>>
<?= $Page->member_scb_detail_log_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_scb_id->Visible) { // member_scb_id ?>
        <td data-name="member_scb_id"<?= $Page->member_scb_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_member_scb_id" class="el_member_scb_detail_log_member_scb_id">
<span<?= $Page->member_scb_id->viewAttributes() ?>>
<?= $Page->member_scb_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paid_amt->Visible) { // paid_amt ?>
        <td data-name="paid_amt"<?= $Page->paid_amt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_paid_amt" class="el_member_scb_detail_log_paid_amt">
<span<?= $Page->paid_amt->viewAttributes() ?>>
<?= $Page->paid_amt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_date->Visible) { // pay_date ?>
        <td data-name="pay_date"<?= $Page->pay_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_pay_date" class="el_member_scb_detail_log_pay_date">
<span<?= $Page->pay_date->viewAttributes() ?>>
<?= $Page->pay_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_cdate" class="el_member_scb_detail_log_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_cip" class="el_member_scb_detail_log_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_member_scb_detail_log_cuser" class="el_member_scb_detail_log_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
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
    ew.addEventHandlers("member_scb_detail_log");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
