<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvertorBookingList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { invertor_booking: currentTable } });
var currentForm, currentPageID;
var finvertor_bookinglist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvertor_bookinglist = new ew.Form("finvertor_bookinglist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = finvertor_bookinglist;
    finvertor_bookinglist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("finvertor_bookinglist");
});
var finvertor_bookingsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    finvertor_bookingsrch = new ew.Form("finvertor_bookingsrch", "list");
    currentSearchForm = finvertor_bookingsrch;

    // Add fields
    var fields = currentTable.fields;
    finvertor_bookingsrch.addFields([
        ["asset_id", [], fields.asset_id.isInvalid],
        ["date_booking", [ew.Validators.datetime(fields.date_booking.clientFormatPattern)], fields.date_booking.isInvalid],
        ["y_date_booking", [ew.Validators.between], false],
        ["status_expire", [], fields.status_expire.isInvalid],
        ["status_expire_reason", [], fields.status_expire_reason.isInvalid],
        ["payment_status", [], fields.payment_status.isInvalid],
        ["is_email", [], fields.is_email.isInvalid],
        ["receipt_status", [], fields.receipt_status.isInvalid]
    ]);

    // Validate form
    finvertor_bookingsrch.validate = function () {
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
    finvertor_bookingsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvertor_bookingsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    finvertor_bookingsrch.lists.status_expire = <?= $Page->status_expire->toClientList($Page) ?>;
    finvertor_bookingsrch.lists.payment_status = <?= $Page->payment_status->toClientList($Page) ?>;

    // Filters
    finvertor_bookingsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("finvertor_bookingsrch");
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
<form name="finvertor_bookingsrch" id="finvertor_bookingsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="finvertor_bookingsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="invertor_booking">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
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
        <div id="el_invertor_booking_date_booking" class="ew-search-field">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="x_date_booking" id="x_date_booking" data-table="invertor_booking" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage(false) ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvertor_bookingsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("finvertor_bookingsrch", "x_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_invertor_booking_date_booking" class="ew-search-field2">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="y_date_booking" id="y_date_booking" data-table="invertor_booking" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage(false) ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvertor_bookingsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("finvertor_bookingsrch", "y_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
<?php
if (!$Page->status_expire->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status_expire" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->status_expire->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->status_expire->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_expire" id="z_status_expire" value="=">
</div>
        </div>
        <div id="el_invertor_booking_status_expire" class="ew-search-field">
<template id="tp_x_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_status_expire" name="x_status_expire" id="x_status_expire"<?= $Page->status_expire->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status_expire" class="ew-item-list"></div>
<selection-list hidden
    id="x_status_expire"
    name="x_status_expire"
    value="<?= HtmlEncode($Page->status_expire->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_expire"
    data-bs-target="dsl_x_status_expire"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_expire->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Page->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_expire->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->status_expire->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
<?php
if (!$Page->status_expire_reason->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status_expire_reason" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->status_expire_reason->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_status_expire_reason" class="ew-search-caption ew-label"><?= $Page->status_expire_reason->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_status_expire_reason" id="z_status_expire_reason" value="LIKE">
</div>
        </div>
        <div id="el_invertor_booking_status_expire_reason" class="ew-search-field">
<input type="<?= $Page->status_expire_reason->getInputTextType() ?>" name="x_status_expire_reason" id="x_status_expire_reason" data-table="invertor_booking" data-field="x_status_expire_reason" value="<?= $Page->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status_expire_reason->getPlaceHolder()) ?>"<?= $Page->status_expire_reason->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->status_expire_reason->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
<?php
if (!$Page->payment_status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_payment_status" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->payment_status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->payment_status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_payment_status" id="z_payment_status" value="=">
</div>
        </div>
        <div id="el_invertor_booking_payment_status" class="ew-search-field">
<template id="tp_x_payment_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_payment_status" name="x_payment_status" id="x_payment_status"<?= $Page->payment_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_payment_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_payment_status"
    name="x_payment_status"
    value="<?= HtmlEncode($Page->payment_status->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_payment_status"
    data-bs-target="dsl_x_payment_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->payment_status->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_payment_status"
    data-value-separator="<?= $Page->payment_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->payment_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->payment_status->getErrorMessage(false) ?></div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invertor_booking">
<form name="finvertor_bookinglist" id="finvertor_bookinglist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invertor_booking">
<?php if ($Page->getCurrentMasterTable() == "investor" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="investor">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_invertor_booking" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_invertor_bookinglist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_invertor_booking_asset_id" class="invertor_booking_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <th data-name="date_booking" class="<?= $Page->date_booking->headerCellClass() ?>"><div id="elh_invertor_booking_date_booking" class="invertor_booking_date_booking"><?= $Page->renderFieldHeader($Page->date_booking) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <th data-name="status_expire" class="<?= $Page->status_expire->headerCellClass() ?>"><div id="elh_invertor_booking_status_expire" class="invertor_booking_status_expire"><?= $Page->renderFieldHeader($Page->status_expire) ?></div></th>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <th data-name="status_expire_reason" class="<?= $Page->status_expire_reason->headerCellClass() ?>"><div id="elh_invertor_booking_status_expire_reason" class="invertor_booking_status_expire_reason"><?= $Page->renderFieldHeader($Page->status_expire_reason) ?></div></th>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
        <th data-name="payment_status" class="<?= $Page->payment_status->headerCellClass() ?>"><div id="elh_invertor_booking_payment_status" class="invertor_booking_payment_status"><?= $Page->renderFieldHeader($Page->payment_status) ?></div></th>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <th data-name="is_email" class="<?= $Page->is_email->headerCellClass() ?>"><div id="elh_invertor_booking_is_email" class="invertor_booking_is_email"><?= $Page->renderFieldHeader($Page->is_email) ?></div></th>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <th data-name="receipt_status" class="<?= $Page->receipt_status->headerCellClass() ?>"><div id="elh_invertor_booking_receipt_status" class="invertor_booking_receipt_status"><?= $Page->renderFieldHeader($Page->receipt_status) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_invertor_booking",
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
<span id="el<?= $Page->RowCount ?>_invertor_booking_asset_id" class="el_invertor_booking_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_booking->Visible) { // date_booking ?>
        <td data-name="date_booking"<?= $Page->date_booking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_date_booking" class="el_invertor_booking_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire->Visible) { // status_expire ?>
        <td data-name="status_expire"<?= $Page->status_expire->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_status_expire" class="el_invertor_booking_status_expire">
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <td data-name="status_expire_reason"<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_status_expire_reason" class="el_invertor_booking_status_expire_reason">
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payment_status->Visible) { // payment_status ?>
        <td data-name="payment_status"<?= $Page->payment_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_payment_status" class="el_invertor_booking_payment_status">
<span<?= $Page->payment_status->viewAttributes() ?>>
<?= $Page->payment_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_email->Visible) { // is_email ?>
        <td data-name="is_email"<?= $Page->is_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_is_email" class="el_invertor_booking_is_email">
<span<?= $Page->is_email->viewAttributes() ?>>
<?= $Page->is_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <td data-name="receipt_status"<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_booking_receipt_status" class="el_invertor_booking_receipt_status">
<span<?= $Page->receipt_status->viewAttributes() ?>>
<?= $Page->receipt_status->getViewValue() ?></span>
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
        container: "gmp_invertor_booking",
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
    ew.addEventHandlers("invertor_booking");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
