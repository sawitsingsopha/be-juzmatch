<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch3List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch3: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch3list;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch3list = new ew.Form("fdoc_juzmatch3list", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fdoc_juzmatch3list;
    fdoc_juzmatch3list.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fdoc_juzmatch3list");
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doc_juzmatch3">
<form name="fdoc_juzmatch3list" id="fdoc_juzmatch3list" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch3">
<?php if ($Page->getCurrentMasterTable() == "buyer_all_booking_asset" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_all_booking_asset">
<input type="hidden" name="fk_buyer_booking_asset_id" value="<?= HtmlEncode($Page->buyer_booking_asset_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_doc_juzmatch3" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_doc_juzmatch3list" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->document_date->Visible) { // document_date ?>
        <th data-name="document_date" class="<?= $Page->document_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_document_date" class="doc_juzmatch3_document_date"><?= $Page->renderFieldHeader($Page->document_date) ?></div></th>
<?php } ?>
<?php if ($Page->years->Visible) { // years ?>
        <th data-name="years" class="<?= $Page->years->headerCellClass() ?>"><div id="elh_doc_juzmatch3_years" class="doc_juzmatch3_years"><?= $Page->renderFieldHeader($Page->years) ?></div></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th data-name="start_date" class="<?= $Page->start_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_start_date" class="doc_juzmatch3_start_date"><?= $Page->renderFieldHeader($Page->start_date) ?></div></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th data-name="end_date" class="<?= $Page->end_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_end_date" class="doc_juzmatch3_end_date"><?= $Page->renderFieldHeader($Page->end_date) ?></div></th>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Page->asset_code->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_code" class="doc_juzmatch3_asset_code"><?= $Page->renderFieldHeader($Page->asset_code) ?></div></th>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <th data-name="asset_project" class="<?= $Page->asset_project->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_project" class="doc_juzmatch3_asset_project"><?= $Page->renderFieldHeader($Page->asset_project) ?></div></th>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <th data-name="asset_deed" class="<?= $Page->asset_deed->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_deed" class="doc_juzmatch3_asset_deed"><?= $Page->renderFieldHeader($Page->asset_deed) ?></div></th>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <th data-name="asset_area" class="<?= $Page->asset_area->headerCellClass() ?>"><div id="elh_doc_juzmatch3_asset_area" class="doc_juzmatch3_asset_area"><?= $Page->renderFieldHeader($Page->asset_area) ?></div></th>
<?php } ?>
<?php if ($Page->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <th data-name="appoint_agent_date" class="<?= $Page->appoint_agent_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_appoint_agent_date" class="doc_juzmatch3_appoint_agent_date"><?= $Page->renderFieldHeader($Page->appoint_agent_date) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <th data-name="buyer_lname" class="<?= $Page->buyer_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_lname" class="doc_juzmatch3_buyer_lname"><?= $Page->renderFieldHeader($Page->buyer_lname) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <th data-name="buyer_email" class="<?= $Page->buyer_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_email" class="doc_juzmatch3_buyer_email"><?= $Page->renderFieldHeader($Page->buyer_email) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <th data-name="buyer_idcard" class="<?= $Page->buyer_idcard->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_idcard" class="doc_juzmatch3_buyer_idcard"><?= $Page->renderFieldHeader($Page->buyer_idcard) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <th data-name="buyer_homeno" class="<?= $Page->buyer_homeno->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_homeno" class="doc_juzmatch3_buyer_homeno"><?= $Page->renderFieldHeader($Page->buyer_homeno) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <th data-name="buyer_witness_lname" class="<?= $Page->buyer_witness_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_witness_lname" class="doc_juzmatch3_buyer_witness_lname"><?= $Page->renderFieldHeader($Page->buyer_witness_lname) ?></div></th>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <th data-name="buyer_witness_email" class="<?= $Page->buyer_witness_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_buyer_witness_email" class="doc_juzmatch3_buyer_witness_email"><?= $Page->renderFieldHeader($Page->buyer_witness_email) ?></div></th>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <th data-name="investor_lname" class="<?= $Page->investor_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_investor_lname" class="doc_juzmatch3_investor_lname"><?= $Page->renderFieldHeader($Page->investor_lname) ?></div></th>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <th data-name="investor_email" class="<?= $Page->investor_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_investor_email" class="doc_juzmatch3_investor_email"><?= $Page->renderFieldHeader($Page->investor_email) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <th data-name="juzmatch_authority_lname" class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_lname" class="doc_juzmatch3_juzmatch_authority_lname"><?= $Page->renderFieldHeader($Page->juzmatch_authority_lname) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <th data-name="juzmatch_authority_email" class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_email" class="doc_juzmatch3_juzmatch_authority_email"><?= $Page->renderFieldHeader($Page->juzmatch_authority_email) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <th data-name="juzmatch_authority_witness_lname" class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_witness_lname" class="doc_juzmatch3_juzmatch_authority_witness_lname"><?= $Page->renderFieldHeader($Page->juzmatch_authority_witness_lname) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <th data-name="juzmatch_authority_witness_email" class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority_witness_email" class="doc_juzmatch3_juzmatch_authority_witness_email"><?= $Page->renderFieldHeader($Page->juzmatch_authority_witness_email) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <th data-name="juzmatch_authority2_name" class="<?= $Page->juzmatch_authority2_name->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority2_name" class="doc_juzmatch3_juzmatch_authority2_name"><?= $Page->renderFieldHeader($Page->juzmatch_authority2_name) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <th data-name="juzmatch_authority2_lname" class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority2_lname" class="doc_juzmatch3_juzmatch_authority2_lname"><?= $Page->renderFieldHeader($Page->juzmatch_authority2_lname) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <th data-name="juzmatch_authority2_email" class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_juzmatch_authority2_email" class="doc_juzmatch3_juzmatch_authority2_email"><?= $Page->renderFieldHeader($Page->juzmatch_authority2_email) ?></div></th>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <th data-name="company_seal_name" class="<?= $Page->company_seal_name->headerCellClass() ?>"><div id="elh_doc_juzmatch3_company_seal_name" class="doc_juzmatch3_company_seal_name"><?= $Page->renderFieldHeader($Page->company_seal_name) ?></div></th>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <th data-name="company_seal_email" class="<?= $Page->company_seal_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_company_seal_email" class="doc_juzmatch3_company_seal_email"><?= $Page->renderFieldHeader($Page->company_seal_email) ?></div></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Page->total->headerCellClass() ?>"><div id="elh_doc_juzmatch3_total" class="doc_juzmatch3_total"><?= $Page->renderFieldHeader($Page->total) ?></div></th>
<?php } ?>
<?php if ($Page->total_txt->Visible) { // total_txt ?>
        <th data-name="total_txt" class="<?= $Page->total_txt->headerCellClass() ?>"><div id="elh_doc_juzmatch3_total_txt" class="doc_juzmatch3_total_txt"><?= $Page->renderFieldHeader($Page->total_txt) ?></div></th>
<?php } ?>
<?php if ($Page->next_pay_date->Visible) { // next_pay_date ?>
        <th data-name="next_pay_date" class="<?= $Page->next_pay_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_next_pay_date" class="doc_juzmatch3_next_pay_date"><?= $Page->renderFieldHeader($Page->next_pay_date) ?></div></th>
<?php } ?>
<?php if ($Page->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <th data-name="next_pay_date_txt" class="<?= $Page->next_pay_date_txt->headerCellClass() ?>"><div id="elh_doc_juzmatch3_next_pay_date_txt" class="doc_juzmatch3_next_pay_date_txt"><?= $Page->renderFieldHeader($Page->next_pay_date_txt) ?></div></th>
<?php } ?>
<?php if ($Page->service_price->Visible) { // service_price ?>
        <th data-name="service_price" class="<?= $Page->service_price->headerCellClass() ?>"><div id="elh_doc_juzmatch3_service_price" class="doc_juzmatch3_service_price"><?= $Page->renderFieldHeader($Page->service_price) ?></div></th>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
        <th data-name="service_price_txt" class="<?= $Page->service_price_txt->headerCellClass() ?>"><div id="elh_doc_juzmatch3_service_price_txt" class="doc_juzmatch3_service_price_txt"><?= $Page->renderFieldHeader($Page->service_price_txt) ?></div></th>
<?php } ?>
<?php if ($Page->provide_service_date->Visible) { // provide_service_date ?>
        <th data-name="provide_service_date" class="<?= $Page->provide_service_date->headerCellClass() ?>"><div id="elh_doc_juzmatch3_provide_service_date" class="doc_juzmatch3_provide_service_date"><?= $Page->renderFieldHeader($Page->provide_service_date) ?></div></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th data-name="contact_address" class="<?= $Page->contact_address->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_address" class="doc_juzmatch3_contact_address"><?= $Page->renderFieldHeader($Page->contact_address) ?></div></th>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <th data-name="contact_address2" class="<?= $Page->contact_address2->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_address2" class="doc_juzmatch3_contact_address2"><?= $Page->renderFieldHeader($Page->contact_address2) ?></div></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th data-name="contact_email" class="<?= $Page->contact_email->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_email" class="doc_juzmatch3_contact_email"><?= $Page->renderFieldHeader($Page->contact_email) ?></div></th>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <th data-name="contact_lineid" class="<?= $Page->contact_lineid->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_lineid" class="doc_juzmatch3_contact_lineid"><?= $Page->renderFieldHeader($Page->contact_lineid) ?></div></th>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <th data-name="contact_phone" class="<?= $Page->contact_phone->headerCellClass() ?>"><div id="elh_doc_juzmatch3_contact_phone" class="doc_juzmatch3_contact_phone"><?= $Page->renderFieldHeader($Page->contact_phone) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_doc_juzmatch3_cdate" class="doc_juzmatch3_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_doc_juzmatch3",
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
    <?php if ($Page->document_date->Visible) { // document_date ?>
        <td data-name="document_date"<?= $Page->document_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_document_date" class="el_doc_juzmatch3_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->years->Visible) { // years ?>
        <td data-name="years"<?= $Page->years->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<span<?= $Page->years->viewAttributes() ?>>
<?= $Page->years->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->start_date->Visible) { // start_date ?>
        <td data-name="start_date"<?= $Page->start_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->end_date->Visible) { // end_date ?>
        <td data-name="end_date"<?= $Page->end_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_project->Visible) { // asset_project ?>
        <td data-name="asset_project"<?= $Page->asset_project->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <td data-name="asset_deed"<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_area->Visible) { // asset_area ?>
        <td data-name="asset_area"<?= $Page->asset_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <td data-name="appoint_agent_date"<?= $Page->appoint_agent_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<span<?= $Page->appoint_agent_date->viewAttributes() ?>>
<?= $Page->appoint_agent_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <td data-name="buyer_lname"<?= $Page->buyer_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<span<?= $Page->buyer_lname->viewAttributes() ?>>
<?= $Page->buyer_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <td data-name="buyer_email"<?= $Page->buyer_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<span<?= $Page->buyer_email->viewAttributes() ?>>
<?= $Page->buyer_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <td data-name="buyer_idcard"<?= $Page->buyer_idcard->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<span<?= $Page->buyer_idcard->viewAttributes() ?>>
<?= $Page->buyer_idcard->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <td data-name="buyer_homeno"<?= $Page->buyer_homeno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<span<?= $Page->buyer_homeno->viewAttributes() ?>>
<?= $Page->buyer_homeno->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <td data-name="buyer_witness_lname"<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<span<?= $Page->buyer_witness_lname->viewAttributes() ?>>
<?= $Page->buyer_witness_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <td data-name="buyer_witness_email"<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<span<?= $Page->buyer_witness_email->viewAttributes() ?>>
<?= $Page->buyer_witness_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <td data-name="investor_lname"<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<span<?= $Page->investor_lname->viewAttributes() ?>>
<?= $Page->investor_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_email->Visible) { // investor_email ?>
        <td data-name="investor_email"<?= $Page->investor_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<span<?= $Page->investor_email->viewAttributes() ?>>
<?= $Page->investor_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td data-name="juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td data-name="juzmatch_authority_email"<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td data-name="juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td data-name="juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <td data-name="juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority2_name" class="el_doc_juzmatch3_juzmatch_authority2_name">
<span<?= $Page->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td data-name="juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td data-name="juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <td data-name="company_seal_name"<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <td data-name="company_seal_email"<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total"<?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->total_txt->Visible) { // total_txt ?>
        <td data-name="total_txt"<?= $Page->total_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<span<?= $Page->total_txt->viewAttributes() ?>>
<?= $Page->total_txt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->next_pay_date->Visible) { // next_pay_date ?>
        <td data-name="next_pay_date"<?= $Page->next_pay_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<span<?= $Page->next_pay_date->viewAttributes() ?>>
<?= $Page->next_pay_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <td data-name="next_pay_date_txt"<?= $Page->next_pay_date_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<span<?= $Page->next_pay_date_txt->viewAttributes() ?>>
<?= $Page->next_pay_date_txt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->service_price->Visible) { // service_price ?>
        <td data-name="service_price"<?= $Page->service_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<span<?= $Page->service_price->viewAttributes() ?>>
<?= $Page->service_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
        <td data-name="service_price_txt"<?= $Page->service_price_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<span<?= $Page->service_price_txt->viewAttributes() ?>>
<?= $Page->service_price_txt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->provide_service_date->Visible) { // provide_service_date ?>
        <td data-name="provide_service_date"<?= $Page->provide_service_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<span<?= $Page->provide_service_date->viewAttributes() ?>>
<?= $Page->provide_service_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td data-name="contact_address"<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <td data-name="contact_address2"<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td data-name="contact_email"<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <td data-name="contact_lineid"<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <td data-name="contact_phone"<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_cdate" class="el_doc_juzmatch3_cdate">
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
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("doc_juzmatch3");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
