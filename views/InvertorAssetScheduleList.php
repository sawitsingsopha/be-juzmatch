<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvertorAssetScheduleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { invertor_asset_schedule: currentTable } });
var currentForm, currentPageID;
var finvertor_asset_schedulelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvertor_asset_schedulelist = new ew.Form("finvertor_asset_schedulelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = finvertor_asset_schedulelist;
    finvertor_asset_schedulelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("finvertor_asset_schedulelist");
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
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invertor_asset_schedule">
<form name="finvertor_asset_schedulelist" id="finvertor_asset_schedulelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invertor_asset_schedule">
<div id="gmp_invertor_asset_schedule" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_invertor_asset_schedulelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->invertor_asset_schedule_id->Visible) { // invertor_asset_schedule_id ?>
        <th data-name="invertor_asset_schedule_id" class="<?= $Page->invertor_asset_schedule_id->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_invertor_asset_schedule_id" class="invertor_asset_schedule_invertor_asset_schedule_id"><?= $Page->renderFieldHeader($Page->invertor_asset_schedule_id) ?></div></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th data-name="asset_id" class="<?= $Page->asset_id->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_asset_id" class="invertor_asset_schedule_asset_id"><?= $Page->renderFieldHeader($Page->asset_id) ?></div></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th data-name="member_id" class="<?= $Page->member_id->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_member_id" class="invertor_asset_schedule_member_id"><?= $Page->renderFieldHeader($Page->member_id) ?></div></th>
<?php } ?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <th data-name="num_installment" class="<?= $Page->num_installment->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_num_installment" class="invertor_asset_schedule_num_installment"><?= $Page->renderFieldHeader($Page->num_installment) ?></div></th>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <th data-name="installment_per_price" class="<?= $Page->installment_per_price->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_installment_per_price" class="invertor_asset_schedule_installment_per_price"><?= $Page->renderFieldHeader($Page->installment_per_price) ?></div></th>
<?php } ?>
<?php if ($Page->receive_per_installment->Visible) { // receive_per_installment ?>
        <th data-name="receive_per_installment" class="<?= $Page->receive_per_installment->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_receive_per_installment" class="invertor_asset_schedule_receive_per_installment"><?= $Page->renderFieldHeader($Page->receive_per_installment) ?></div></th>
<?php } ?>
<?php if ($Page->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <th data-name="receive_per_installment_invertor" class="<?= $Page->receive_per_installment_invertor->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_receive_per_installment_invertor" class="invertor_asset_schedule_receive_per_installment_invertor"><?= $Page->renderFieldHeader($Page->receive_per_installment_invertor) ?></div></th>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <th data-name="pay_number" class="<?= $Page->pay_number->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_pay_number" class="invertor_asset_schedule_pay_number"><?= $Page->renderFieldHeader($Page->pay_number) ?></div></th>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <th data-name="expired_date" class="<?= $Page->expired_date->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_expired_date" class="invertor_asset_schedule_expired_date"><?= $Page->renderFieldHeader($Page->expired_date) ?></div></th>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <th data-name="date_payment" class="<?= $Page->date_payment->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_date_payment" class="invertor_asset_schedule_date_payment"><?= $Page->renderFieldHeader($Page->date_payment) ?></div></th>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <th data-name="status_payment" class="<?= $Page->status_payment->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_status_payment" class="invertor_asset_schedule_status_payment"><?= $Page->renderFieldHeader($Page->status_payment) ?></div></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th data-name="cuser" class="<?= $Page->cuser->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_cuser" class="invertor_asset_schedule_cuser"><?= $Page->renderFieldHeader($Page->cuser) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_cdate" class="invertor_asset_schedule_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th data-name="cip" class="<?= $Page->cip->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_cip" class="invertor_asset_schedule_cip"><?= $Page->renderFieldHeader($Page->cip) ?></div></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th data-name="uuser" class="<?= $Page->uuser->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_uuser" class="invertor_asset_schedule_uuser"><?= $Page->renderFieldHeader($Page->uuser) ?></div></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th data-name="udate" class="<?= $Page->udate->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_udate" class="invertor_asset_schedule_udate"><?= $Page->renderFieldHeader($Page->udate) ?></div></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th data-name="uip" class="<?= $Page->uip->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_uip" class="invertor_asset_schedule_uip"><?= $Page->renderFieldHeader($Page->uip) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
        <th data-name="transaction_datetime" class="<?= $Page->transaction_datetime->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_transaction_datetime" class="invertor_asset_schedule_transaction_datetime"><?= $Page->renderFieldHeader($Page->transaction_datetime) ?></div></th>
<?php } ?>
<?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
        <th data-name="payment_scheme" class="<?= $Page->payment_scheme->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_payment_scheme" class="invertor_asset_schedule_payment_scheme"><?= $Page->renderFieldHeader($Page->payment_scheme) ?></div></th>
<?php } ?>
<?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
        <th data-name="transaction_ref" class="<?= $Page->transaction_ref->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_transaction_ref" class="invertor_asset_schedule_transaction_ref"><?= $Page->renderFieldHeader($Page->transaction_ref) ?></div></th>
<?php } ?>
<?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
        <th data-name="channel_response_desc" class="<?= $Page->channel_response_desc->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_channel_response_desc" class="invertor_asset_schedule_channel_response_desc"><?= $Page->renderFieldHeader($Page->channel_response_desc) ?></div></th>
<?php } ?>
<?php if ($Page->res_status->Visible) { // res_status ?>
        <th data-name="res_status" class="<?= $Page->res_status->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_res_status" class="invertor_asset_schedule_res_status"><?= $Page->renderFieldHeader($Page->res_status) ?></div></th>
<?php } ?>
<?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
        <th data-name="res_referenceNo" class="<?= $Page->res_referenceNo->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_res_referenceNo" class="invertor_asset_schedule_res_referenceNo"><?= $Page->renderFieldHeader($Page->res_referenceNo) ?></div></th>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <th data-name="installment_all" class="<?= $Page->installment_all->headerCellClass() ?>"><div id="elh_invertor_asset_schedule_installment_all" class="invertor_asset_schedule_installment_all"><?= $Page->renderFieldHeader($Page->installment_all) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_invertor_asset_schedule",
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
    <?php if ($Page->invertor_asset_schedule_id->Visible) { // invertor_asset_schedule_id ?>
        <td data-name="invertor_asset_schedule_id"<?= $Page->invertor_asset_schedule_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_invertor_asset_schedule_id" class="el_invertor_asset_schedule_invertor_asset_schedule_id">
<span<?= $Page->invertor_asset_schedule_id->viewAttributes() ?>>
<?= $Page->invertor_asset_schedule_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_asset_id" class="el_invertor_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->member_id->Visible) { // member_id ?>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_member_id" class="el_invertor_asset_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->num_installment->Visible) { // num_installment ?>
        <td data-name="num_installment"<?= $Page->num_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_num_installment" class="el_invertor_asset_schedule_num_installment">
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <td data-name="installment_per_price"<?= $Page->installment_per_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_installment_per_price" class="el_invertor_asset_schedule_installment_per_price">
<span<?= $Page->installment_per_price->viewAttributes() ?>>
<?= $Page->installment_per_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receive_per_installment->Visible) { // receive_per_installment ?>
        <td data-name="receive_per_installment"<?= $Page->receive_per_installment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_receive_per_installment" class="el_invertor_asset_schedule_receive_per_installment">
<span<?= $Page->receive_per_installment->viewAttributes() ?>>
<?= $Page->receive_per_installment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
        <td data-name="receive_per_installment_invertor"<?= $Page->receive_per_installment_invertor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_receive_per_installment_invertor" class="el_invertor_asset_schedule_receive_per_installment_invertor">
<span<?= $Page->receive_per_installment_invertor->viewAttributes() ?>>
<?= $Page->receive_per_installment_invertor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pay_number->Visible) { // pay_number ?>
        <td data-name="pay_number"<?= $Page->pay_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_pay_number" class="el_invertor_asset_schedule_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expired_date->Visible) { // expired_date ?>
        <td data-name="expired_date"<?= $Page->expired_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_expired_date" class="el_invertor_asset_schedule_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_payment->Visible) { // date_payment ?>
        <td data-name="date_payment"<?= $Page->date_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_date_payment" class="el_invertor_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_payment->Visible) { // status_payment ?>
        <td data-name="status_payment"<?= $Page->status_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_status_payment" class="el_invertor_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuser->Visible) { // cuser ?>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_cuser" class="el_invertor_asset_schedule_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_cdate" class="el_invertor_asset_schedule_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cip->Visible) { // cip ?>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_cip" class="el_invertor_asset_schedule_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uuser->Visible) { // uuser ?>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_uuser" class="el_invertor_asset_schedule_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->udate->Visible) { // udate ?>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_udate" class="el_invertor_asset_schedule_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uip->Visible) { // uip ?>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_uip" class="el_invertor_asset_schedule_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
        <td data-name="transaction_datetime"<?= $Page->transaction_datetime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_transaction_datetime" class="el_invertor_asset_schedule_transaction_datetime">
<span<?= $Page->transaction_datetime->viewAttributes() ?>>
<?= $Page->transaction_datetime->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
        <td data-name="payment_scheme"<?= $Page->payment_scheme->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_payment_scheme" class="el_invertor_asset_schedule_payment_scheme">
<span<?= $Page->payment_scheme->viewAttributes() ?>>
<?= $Page->payment_scheme->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
        <td data-name="transaction_ref"<?= $Page->transaction_ref->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_transaction_ref" class="el_invertor_asset_schedule_transaction_ref">
<span<?= $Page->transaction_ref->viewAttributes() ?>>
<?= $Page->transaction_ref->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
        <td data-name="channel_response_desc"<?= $Page->channel_response_desc->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_channel_response_desc" class="el_invertor_asset_schedule_channel_response_desc">
<span<?= $Page->channel_response_desc->viewAttributes() ?>>
<?= $Page->channel_response_desc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_status->Visible) { // res_status ?>
        <td data-name="res_status"<?= $Page->res_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_res_status" class="el_invertor_asset_schedule_res_status">
<span<?= $Page->res_status->viewAttributes() ?>>
<?= $Page->res_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
        <td data-name="res_referenceNo"<?= $Page->res_referenceNo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_res_referenceNo" class="el_invertor_asset_schedule_res_referenceNo">
<span<?= $Page->res_referenceNo->viewAttributes() ?>>
<?= $Page->res_referenceNo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->installment_all->Visible) { // installment_all ?>
        <td data-name="installment_all"<?= $Page->installment_all->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invertor_asset_schedule_installment_all" class="el_invertor_asset_schedule_installment_all">
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
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
    ew.addEventHandlers("invertor_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
