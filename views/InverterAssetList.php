<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InverterAssetList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { inverter_asset: currentTable } });
var currentForm, currentPageID;
var finverter_assetlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finverter_assetlist = new ew.Form("finverter_assetlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = finverter_assetlist;
    finverter_assetlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("finverter_assetlist");
});
var finverter_assetsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    finverter_assetsrch = new ew.Form("finverter_assetsrch", "list");
    currentSearchForm = finverter_assetsrch;

    // Dynamic selection lists

    // Filters
    finverter_assetsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("finverter_assetsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "investor") {
    if ($Page->MasterRecordExists) {
        include_once "views/InvestorMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="finverter_assetsrch" id="finverter_assetsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="finverter_assetsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="inverter_asset">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="finverter_assetsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="finverter_assetsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="finverter_assetsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="finverter_assetsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> inverter_asset">
<form name="finverter_assetlist" id="finverter_assetlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="inverter_asset">
<?php if ($Page->getCurrentMasterTable() == "investor" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="investor">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_inverter_asset" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_inverter_assetlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_inverter_asset_asset_id" class="inverter_asset_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Page->status_expire->headerCellClass() ?>"><div id="elh_inverter_asset_status_expire" class="inverter_asset_status_expire"><?= $Page->renderFieldHeader($Page->status_expire) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Page->status_expire_reason->headerCellClass() ?>"><div id="elh_inverter_asset_status_expire_reason" class="inverter_asset_status_expire_reason"><?= $Page->renderFieldHeader($Page->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
        <th data-name="res_paidAgent" class="<?= $Page->res_paidAgent->headerCellClass() ?>"><div id="elh_inverter_asset_res_paidAgent" class="inverter_asset_res_paidAgent"><?= $Page->renderFieldHeader($Page->res_paidAgent) ?></div></th>
<?php } ?>
<?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
        <th data-name="res_paidChannel" class="<?= $Page->res_paidChannel->headerCellClass() ?>"><div id="elh_inverter_asset_res_paidChannel" class="inverter_asset_res_paidChannel"><?= $Page->renderFieldHeader($Page->res_paidChannel) ?></div></th>
<?php } ?>
<?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
        <th data-name="res_maskedPan" class="<?= $Page->res_maskedPan->headerCellClass() ?>"><div id="elh_inverter_asset_res_maskedPan" class="inverter_asset_res_maskedPan"><?= $Page->renderFieldHeader($Page->res_maskedPan) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_inverter_asset",
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
<span id="el<?= $Page->RowCount ?>_inverter_asset_asset_id" class="el_inverter_asset_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inverter_asset_status_expire" class="el_inverter_asset_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inverter_asset_status_expire_reason" class="el_inverter_asset_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
        <td data-name="res_paidAgent"<?= $Page->res_paidAgent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inverter_asset_res_paidAgent" class="el_inverter_asset_res_paidAgent">
<span<?= $Page->res_paidAgent->viewAttributes() ?>>
<?= $Page->res_paidAgent->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
        <td data-name="res_paidChannel"<?= $Page->res_paidChannel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inverter_asset_res_paidChannel" class="el_inverter_asset_res_paidChannel">
<span<?= $Page->res_paidChannel->viewAttributes() ?>>
<?= $Page->res_paidChannel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
        <td data-name="res_maskedPan"<?= $Page->res_maskedPan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_inverter_asset_res_maskedPan" class="el_inverter_asset_res_maskedPan">
<span<?= $Page->res_maskedPan->viewAttributes() ?>>
<?= $Page->res_maskedPan->getViewValue() ?></span>
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
        container: "gmp_inverter_asset",
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
    ew.addEventHandlers("inverter_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
