<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAllAssetRentList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_all_asset_rent: currentTable } });
var currentForm, currentPageID;
var fbuyer_all_asset_rentlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_all_asset_rentlist = new ew.Form("fbuyer_all_asset_rentlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fbuyer_all_asset_rentlist;
    fbuyer_all_asset_rentlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Dynamic selection lists
    fbuyer_all_asset_rentlist.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fbuyer_all_asset_rentlist.lists.member_id = <?= $Page->member_id->toClientList($Page) ?>;
    fbuyer_all_asset_rentlist.lists.one_time_status = <?= $Page->one_time_status->toClientList($Page) ?>;
    fbuyer_all_asset_rentlist.lists.status_pay_half_price_1 = <?= $Page->status_pay_half_price_1->toClientList($Page) ?>;
    fbuyer_all_asset_rentlist.lists.status_pay_half_price_2 = <?= $Page->status_pay_half_price_2->toClientList($Page) ?>;
    loadjs.done("fbuyer_all_asset_rentlist");
});
var fbuyer_all_asset_rentsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fbuyer_all_asset_rentsrch = new ew.Form("fbuyer_all_asset_rentsrch", "list");
    currentSearchForm = fbuyer_all_asset_rentsrch;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_all_asset_rentsrch.addFields([
        ["asset_id", [], fields.asset_id.isInvalid],
        ["member_id", [], fields.member_id.isInvalid],
        ["one_time_status", [], fields.one_time_status.isInvalid],
        ["half_price_1", [], fields.half_price_1.isInvalid],
        ["status_pay_half_price_1", [], fields.status_pay_half_price_1.isInvalid],
        ["due_date_pay_half_price_1", [], fields.due_date_pay_half_price_1.isInvalid],
        ["y_due_date_pay_half_price_1", [ew.Validators.between], false],
        ["half_price_2", [], fields.half_price_2.isInvalid],
        ["status_pay_half_price_2", [], fields.status_pay_half_price_2.isInvalid],
        ["due_date_pay_half_price_2", [], fields.due_date_pay_half_price_2.isInvalid],
        ["y_due_date_pay_half_price_2", [ew.Validators.between], false]
    ]);

    // Validate form
    fbuyer_all_asset_rentsrch.validate = function () {
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
    fbuyer_all_asset_rentsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_all_asset_rentsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_all_asset_rentsrch.lists.one_time_status = <?= $Page->one_time_status->toClientList($Page) ?>;

    // Filters
    fbuyer_all_asset_rentsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fbuyer_all_asset_rentsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "buyer_all_booking_asset") {
    if ($Page->MasterRecordExists) {
        include_once "views/BuyerAllBookingAssetMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fbuyer_all_asset_rentsrch" id="fbuyer_all_asset_rentsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fbuyer_all_asset_rentsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="buyer_all_asset_rent">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
<?php
if (!$Page->one_time_status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_one_time_status" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->one_time_status->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_one_time_status"
            name="x_one_time_status[]"
            class="form-control ew-select<?= $Page->one_time_status->isInvalidClass() ?>"
            data-select2-id="fbuyer_all_asset_rentsrch_x_one_time_status"
            data-table="buyer_all_asset_rent"
            data-field="x_one_time_status"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->one_time_status->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->one_time_status->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->one_time_status->getPlaceHolder()) ?>"
            <?= $Page->one_time_status->editAttributes() ?>>
            <?= $Page->one_time_status->selectOptionListHtml("x_one_time_status", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->one_time_status->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fbuyer_all_asset_rentsrch", function() {
            var options = {
                name: "x_one_time_status",
                selectId: "fbuyer_all_asset_rentsrch_x_one_time_status",
                ajax: { id: "x_one_time_status", form: "fbuyer_all_asset_rentsrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.buyer_all_asset_rent.fields.one_time_status.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> buyer_all_asset_rent">
<form name="fbuyer_all_asset_rentlist" id="fbuyer_all_asset_rentlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_all_asset_rent">
<?php if ($Page->getCurrentMasterTable() == "buyer_all_booking_asset" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_all_booking_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_buyer_all_asset_rent" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_buyer_all_asset_rentlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_asset_id" class="buyer_all_asset_rent_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Page->member_id->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_member_id" class="buyer_all_asset_rent_member_id"><?= $Page->renderFieldHeader($Page->member_id) ?></div></th>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <th data-name="one_time_status" class="<?= $Page->one_time_status->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_one_time_status" class="buyer_all_asset_rent_one_time_status"><?= $Page->renderFieldHeader($Page->one_time_status) ?></div></th>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <th data-name="half_price_1" class="<?= $Page->half_price_1->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_half_price_1" class="buyer_all_asset_rent_half_price_1"><?= $Page->renderFieldHeader($Page->half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <th data-name="status_pay_half_price_1" class="<?= $Page->status_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_status_pay_half_price_1" class="buyer_all_asset_rent_status_pay_half_price_1"><?= $Page->renderFieldHeader($Page->status_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <th data-name="due_date_pay_half_price_1" class="<?= $Page->due_date_pay_half_price_1->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_due_date_pay_half_price_1" class="buyer_all_asset_rent_due_date_pay_half_price_1"><?= $Page->renderFieldHeader($Page->due_date_pay_half_price_1) ?></div></th>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <th data-name="half_price_2" class="<?= $Page->half_price_2->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_half_price_2" class="buyer_all_asset_rent_half_price_2"><?= $Page->renderFieldHeader($Page->half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <th data-name="status_pay_half_price_2" class="<?= $Page->status_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_status_pay_half_price_2" class="buyer_all_asset_rent_status_pay_half_price_2"><?= $Page->renderFieldHeader($Page->status_pay_half_price_2) ?></div></th>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <th data-name="due_date_pay_half_price_2" class="<?= $Page->due_date_pay_half_price_2->headerCellClass() ?>"><div id="elh_buyer_all_asset_rent_due_date_pay_half_price_2" class="buyer_all_asset_rent_due_date_pay_half_price_2"><?= $Page->renderFieldHeader($Page->due_date_pay_half_price_2) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_buyer_all_asset_rent",
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
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_asset_id" class="el_buyer_all_asset_rent_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_member_id" class="el_buyer_all_asset_rent_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <td data-name="one_time_status"<?= $Page->one_time_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_one_time_status" class="el_buyer_all_asset_rent_one_time_status">
<span<?= $Page->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->one_time_status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <td data-name="half_price_1"<?= $Page->half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_half_price_1" class="el_buyer_all_asset_rent_half_price_1">
<span<?= $Page->half_price_1->viewAttributes() ?>>
<?= $Page->half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <td data-name="status_pay_half_price_1"<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_1" class="el_buyer_all_asset_rent_status_pay_half_price_1">
<span<?= $Page->status_pay_half_price_1->viewAttributes() ?>>
<?= $Page->status_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <td data-name="due_date_pay_half_price_1"<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_1" class="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<span<?= $Page->due_date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <td data-name="half_price_2"<?= $Page->half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_half_price_2" class="el_buyer_all_asset_rent_half_price_2">
<span<?= $Page->half_price_2->viewAttributes() ?>>
<?= $Page->half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <td data-name="status_pay_half_price_2"<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_status_pay_half_price_2" class="el_buyer_all_asset_rent_status_pay_half_price_2">
<span<?= $Page->status_pay_half_price_2->viewAttributes() ?>>
<?= $Page->status_pay_half_price_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <td data-name="due_date_pay_half_price_2"<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_buyer_all_asset_rent_due_date_pay_half_price_2" class="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<span<?= $Page->due_date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_2->getViewValue() ?></span>
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
        container: "gmp_buyer_all_asset_rent",
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
    ew.addEventHandlers("buyer_all_asset_rent");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    var rowCount = $('#tbl_buyer_all_asset_rentlist >tbody >tr').length;
    if(rowCount >= 1){
        $(".ew-add-edit-option").remove()
    }
});
</script>
<?php } ?>
