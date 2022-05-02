<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch2: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch2list;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch2list = new ew.Form("fdoc_juzmatch2list", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fdoc_juzmatch2list;
    fdoc_juzmatch2list.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fdoc_juzmatch2list");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "invertor_all_booking") {
    if ($Page->MasterRecordExists) {
        include_once "views/InvertorAllBookingMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> doc_juzmatch2">
<form name="fdoc_juzmatch2list" id="fdoc_juzmatch2list" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch2">
<?php if ($Page->getCurrentMasterTable() == "invertor_all_booking" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invertor_all_booking">
<input type="hidden" name="fk_invertor_booking_id" value="<?= HtmlEncode($Page->investor_booking_id->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_doc_juzmatch2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_doc_juzmatch2list" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="document_date" class="<?= $Page->document_date->headerCellClass() ?>"><div id="elh_doc_juzmatch2_document_date" class="doc_juzmatch2_document_date"><?= $Page->renderFieldHeader($Page->document_date) ?></div></th>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th data-name="asset_code" class="<?= $Page->asset_code->headerCellClass() ?>"><div id="elh_doc_juzmatch2_asset_code" class="doc_juzmatch2_asset_code"><?= $Page->renderFieldHeader($Page->asset_code) ?></div></th>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <th data-name="asset_project" class="<?= $Page->asset_project->headerCellClass() ?>"><div id="elh_doc_juzmatch2_asset_project" class="doc_juzmatch2_asset_project"><?= $Page->renderFieldHeader($Page->asset_project) ?></div></th>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <th data-name="asset_deed" class="<?= $Page->asset_deed->headerCellClass() ?>"><div id="elh_doc_juzmatch2_asset_deed" class="doc_juzmatch2_asset_deed"><?= $Page->renderFieldHeader($Page->asset_deed) ?></div></th>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <th data-name="asset_area" class="<?= $Page->asset_area->headerCellClass() ?>"><div id="elh_doc_juzmatch2_asset_area" class="doc_juzmatch2_asset_area"><?= $Page->renderFieldHeader($Page->asset_area) ?></div></th>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <th data-name="investor_lname" class="<?= $Page->investor_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_lname" class="doc_juzmatch2_investor_lname"><?= $Page->renderFieldHeader($Page->investor_lname) ?></div></th>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <th data-name="investor_email" class="<?= $Page->investor_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_email" class="doc_juzmatch2_investor_email"><?= $Page->renderFieldHeader($Page->investor_email) ?></div></th>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
        <th data-name="investor_idcard" class="<?= $Page->investor_idcard->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_idcard" class="doc_juzmatch2_investor_idcard"><?= $Page->renderFieldHeader($Page->investor_idcard) ?></div></th>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
        <th data-name="investor_homeno" class="<?= $Page->investor_homeno->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_homeno" class="doc_juzmatch2_investor_homeno"><?= $Page->renderFieldHeader($Page->investor_homeno) ?></div></th>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
        <th data-name="investment_money" class="<?= $Page->investment_money->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investment_money" class="doc_juzmatch2_investment_money"><?= $Page->renderFieldHeader($Page->investment_money) ?></div></th>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
        <th data-name="loan_contact_date" class="<?= $Page->loan_contact_date->headerCellClass() ?>"><div id="elh_doc_juzmatch2_loan_contact_date" class="doc_juzmatch2_loan_contact_date"><?= $Page->renderFieldHeader($Page->loan_contact_date) ?></div></th>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
        <th data-name="contract_expired" class="<?= $Page->contract_expired->headerCellClass() ?>"><div id="elh_doc_juzmatch2_contract_expired" class="doc_juzmatch2_contract_expired"><?= $Page->renderFieldHeader($Page->contract_expired) ?></div></th>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
        <th data-name="first_benefits_month" class="<?= $Page->first_benefits_month->headerCellClass() ?>"><div id="elh_doc_juzmatch2_first_benefits_month" class="doc_juzmatch2_first_benefits_month"><?= $Page->renderFieldHeader($Page->first_benefits_month) ?></div></th>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
        <th data-name="one_installment_amount" class="<?= $Page->one_installment_amount->headerCellClass() ?>"><div id="elh_doc_juzmatch2_one_installment_amount" class="doc_juzmatch2_one_installment_amount"><?= $Page->renderFieldHeader($Page->one_installment_amount) ?></div></th>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
        <th data-name="two_installment_amount1" class="<?= $Page->two_installment_amount1->headerCellClass() ?>"><div id="elh_doc_juzmatch2_two_installment_amount1" class="doc_juzmatch2_two_installment_amount1"><?= $Page->renderFieldHeader($Page->two_installment_amount1) ?></div></th>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
        <th data-name="two_installment_amount2" class="<?= $Page->two_installment_amount2->headerCellClass() ?>"><div id="elh_doc_juzmatch2_two_installment_amount2" class="doc_juzmatch2_two_installment_amount2"><?= $Page->renderFieldHeader($Page->two_installment_amount2) ?></div></th>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
        <th data-name="investor_paid_amount" class="<?= $Page->investor_paid_amount->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_paid_amount" class="doc_juzmatch2_investor_paid_amount"><?= $Page->renderFieldHeader($Page->investor_paid_amount) ?></div></th>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
        <th data-name="first_benefits_date" class="<?= $Page->first_benefits_date->headerCellClass() ?>"><div id="elh_doc_juzmatch2_first_benefits_date" class="doc_juzmatch2_first_benefits_date"><?= $Page->renderFieldHeader($Page->first_benefits_date) ?></div></th>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
        <th data-name="one_benefit_amount" class="<?= $Page->one_benefit_amount->headerCellClass() ?>"><div id="elh_doc_juzmatch2_one_benefit_amount" class="doc_juzmatch2_one_benefit_amount"><?= $Page->renderFieldHeader($Page->one_benefit_amount) ?></div></th>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
        <th data-name="two_benefit_amount1" class="<?= $Page->two_benefit_amount1->headerCellClass() ?>"><div id="elh_doc_juzmatch2_two_benefit_amount1" class="doc_juzmatch2_two_benefit_amount1"><?= $Page->renderFieldHeader($Page->two_benefit_amount1) ?></div></th>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
        <th data-name="two_benefit_amount2" class="<?= $Page->two_benefit_amount2->headerCellClass() ?>"><div id="elh_doc_juzmatch2_two_benefit_amount2" class="doc_juzmatch2_two_benefit_amount2"><?= $Page->renderFieldHeader($Page->two_benefit_amount2) ?></div></th>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
        <th data-name="management_agent_date" class="<?= $Page->management_agent_date->headerCellClass() ?>"><div id="elh_doc_juzmatch2_management_agent_date" class="doc_juzmatch2_management_agent_date"><?= $Page->renderFieldHeader($Page->management_agent_date) ?></div></th>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
        <th data-name="begin_date" class="<?= $Page->begin_date->headerCellClass() ?>"><div id="elh_doc_juzmatch2_begin_date" class="doc_juzmatch2_begin_date"><?= $Page->renderFieldHeader($Page->begin_date) ?></div></th>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
        <th data-name="investor_witness_lname" class="<?= $Page->investor_witness_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_witness_lname" class="doc_juzmatch2_investor_witness_lname"><?= $Page->renderFieldHeader($Page->investor_witness_lname) ?></div></th>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
        <th data-name="investor_witness_email" class="<?= $Page->investor_witness_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_investor_witness_email" class="doc_juzmatch2_investor_witness_email"><?= $Page->renderFieldHeader($Page->investor_witness_email) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <th data-name="juzmatch_authority_lname" class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority_lname" class="doc_juzmatch2_juzmatch_authority_lname"><?= $Page->renderFieldHeader($Page->juzmatch_authority_lname) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <th data-name="juzmatch_authority_email" class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority_email" class="doc_juzmatch2_juzmatch_authority_email"><?= $Page->renderFieldHeader($Page->juzmatch_authority_email) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <th data-name="juzmatch_authority_witness_lname" class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority_witness_lname" class="doc_juzmatch2_juzmatch_authority_witness_lname"><?= $Page->renderFieldHeader($Page->juzmatch_authority_witness_lname) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <th data-name="juzmatch_authority_witness_email" class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority_witness_email" class="doc_juzmatch2_juzmatch_authority_witness_email"><?= $Page->renderFieldHeader($Page->juzmatch_authority_witness_email) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <th data-name="juzmatch_authority2_name" class="<?= $Page->juzmatch_authority2_name->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority2_name" class="doc_juzmatch2_juzmatch_authority2_name"><?= $Page->renderFieldHeader($Page->juzmatch_authority2_name) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <th data-name="juzmatch_authority2_lname" class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority2_lname" class="doc_juzmatch2_juzmatch_authority2_lname"><?= $Page->renderFieldHeader($Page->juzmatch_authority2_lname) ?></div></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <th data-name="juzmatch_authority2_email" class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_juzmatch_authority2_email" class="doc_juzmatch2_juzmatch_authority2_email"><?= $Page->renderFieldHeader($Page->juzmatch_authority2_email) ?></div></th>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <th data-name="company_seal_name" class="<?= $Page->company_seal_name->headerCellClass() ?>"><div id="elh_doc_juzmatch2_company_seal_name" class="doc_juzmatch2_company_seal_name"><?= $Page->renderFieldHeader($Page->company_seal_name) ?></div></th>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <th data-name="company_seal_email" class="<?= $Page->company_seal_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_company_seal_email" class="doc_juzmatch2_company_seal_email"><?= $Page->renderFieldHeader($Page->company_seal_email) ?></div></th>
<?php } ?>
<?php if ($Page->file_loan->Visible) { // file_loan ?>
        <th data-name="file_loan" class="<?= $Page->file_loan->headerCellClass() ?>"><div id="elh_doc_juzmatch2_file_loan" class="doc_juzmatch2_file_loan"><?= $Page->renderFieldHeader($Page->file_loan) ?></div></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th data-name="contact_address" class="<?= $Page->contact_address->headerCellClass() ?>"><div id="elh_doc_juzmatch2_contact_address" class="doc_juzmatch2_contact_address"><?= $Page->renderFieldHeader($Page->contact_address) ?></div></th>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <th data-name="contact_address2" class="<?= $Page->contact_address2->headerCellClass() ?>"><div id="elh_doc_juzmatch2_contact_address2" class="doc_juzmatch2_contact_address2"><?= $Page->renderFieldHeader($Page->contact_address2) ?></div></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th data-name="contact_email" class="<?= $Page->contact_email->headerCellClass() ?>"><div id="elh_doc_juzmatch2_contact_email" class="doc_juzmatch2_contact_email"><?= $Page->renderFieldHeader($Page->contact_email) ?></div></th>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <th data-name="contact_lineid" class="<?= $Page->contact_lineid->headerCellClass() ?>"><div id="elh_doc_juzmatch2_contact_lineid" class="doc_juzmatch2_contact_lineid"><?= $Page->renderFieldHeader($Page->contact_lineid) ?></div></th>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <th data-name="contact_phone" class="<?= $Page->contact_phone->headerCellClass() ?>"><div id="elh_doc_juzmatch2_contact_phone" class="doc_juzmatch2_contact_phone"><?= $Page->renderFieldHeader($Page->contact_phone) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_doc_juzmatch2_cdate" class="doc_juzmatch2_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_doc_juzmatch2",
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
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_document_date" class="el_doc_juzmatch2_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_code" class="el_doc_juzmatch2_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_project->Visible) { // asset_project ?>
        <td data-name="asset_project"<?= $Page->asset_project->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_project" class="el_doc_juzmatch2_asset_project">
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <td data-name="asset_deed"<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_deed" class="el_doc_juzmatch2_asset_deed">
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->asset_area->Visible) { // asset_area ?>
        <td data-name="asset_area"<?= $Page->asset_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_area" class="el_doc_juzmatch2_asset_area">
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <td data-name="investor_lname"<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_lname" class="el_doc_juzmatch2_investor_lname">
<span<?= $Page->investor_lname->viewAttributes() ?>>
<?= $Page->investor_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_email->Visible) { // investor_email ?>
        <td data-name="investor_email"<?= $Page->investor_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_email" class="el_doc_juzmatch2_investor_email">
<span<?= $Page->investor_email->viewAttributes() ?>>
<?= $Page->investor_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
        <td data-name="investor_idcard"<?= $Page->investor_idcard->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_idcard" class="el_doc_juzmatch2_investor_idcard">
<span<?= $Page->investor_idcard->viewAttributes() ?>>
<?= $Page->investor_idcard->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
        <td data-name="investor_homeno"<?= $Page->investor_homeno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_homeno" class="el_doc_juzmatch2_investor_homeno">
<span<?= $Page->investor_homeno->viewAttributes() ?>>
<?= $Page->investor_homeno->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investment_money->Visible) { // investment_money ?>
        <td data-name="investment_money"<?= $Page->investment_money->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investment_money" class="el_doc_juzmatch2_investment_money">
<span<?= $Page->investment_money->viewAttributes() ?>>
<?= $Page->investment_money->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
        <td data-name="loan_contact_date"<?= $Page->loan_contact_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_loan_contact_date" class="el_doc_juzmatch2_loan_contact_date">
<span<?= $Page->loan_contact_date->viewAttributes() ?>>
<?= $Page->loan_contact_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contract_expired->Visible) { // contract_expired ?>
        <td data-name="contract_expired"<?= $Page->contract_expired->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contract_expired" class="el_doc_juzmatch2_contract_expired">
<span<?= $Page->contract_expired->viewAttributes() ?>>
<?= $Page->contract_expired->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
        <td data-name="first_benefits_month"<?= $Page->first_benefits_month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_first_benefits_month" class="el_doc_juzmatch2_first_benefits_month">
<span<?= $Page->first_benefits_month->viewAttributes() ?>>
<?= $Page->first_benefits_month->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
        <td data-name="one_installment_amount"<?= $Page->one_installment_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_one_installment_amount" class="el_doc_juzmatch2_one_installment_amount">
<span<?= $Page->one_installment_amount->viewAttributes() ?>>
<?= $Page->one_installment_amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
        <td data-name="two_installment_amount1"<?= $Page->two_installment_amount1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_installment_amount1" class="el_doc_juzmatch2_two_installment_amount1">
<span<?= $Page->two_installment_amount1->viewAttributes() ?>>
<?= $Page->two_installment_amount1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
        <td data-name="two_installment_amount2"<?= $Page->two_installment_amount2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_installment_amount2" class="el_doc_juzmatch2_two_installment_amount2">
<span<?= $Page->two_installment_amount2->viewAttributes() ?>>
<?= $Page->two_installment_amount2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
        <td data-name="investor_paid_amount"<?= $Page->investor_paid_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_paid_amount" class="el_doc_juzmatch2_investor_paid_amount">
<span<?= $Page->investor_paid_amount->viewAttributes() ?>>
<?= $Page->investor_paid_amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
        <td data-name="first_benefits_date"<?= $Page->first_benefits_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_first_benefits_date" class="el_doc_juzmatch2_first_benefits_date">
<span<?= $Page->first_benefits_date->viewAttributes() ?>>
<?= $Page->first_benefits_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
        <td data-name="one_benefit_amount"<?= $Page->one_benefit_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_one_benefit_amount" class="el_doc_juzmatch2_one_benefit_amount">
<span<?= $Page->one_benefit_amount->viewAttributes() ?>>
<?= $Page->one_benefit_amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
        <td data-name="two_benefit_amount1"<?= $Page->two_benefit_amount1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_benefit_amount1" class="el_doc_juzmatch2_two_benefit_amount1">
<span<?= $Page->two_benefit_amount1->viewAttributes() ?>>
<?= $Page->two_benefit_amount1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
        <td data-name="two_benefit_amount2"<?= $Page->two_benefit_amount2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_benefit_amount2" class="el_doc_juzmatch2_two_benefit_amount2">
<span<?= $Page->two_benefit_amount2->viewAttributes() ?>>
<?= $Page->two_benefit_amount2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
        <td data-name="management_agent_date"<?= $Page->management_agent_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_management_agent_date" class="el_doc_juzmatch2_management_agent_date">
<span<?= $Page->management_agent_date->viewAttributes() ?>>
<?= $Page->management_agent_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->begin_date->Visible) { // begin_date ?>
        <td data-name="begin_date"<?= $Page->begin_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_begin_date" class="el_doc_juzmatch2_begin_date">
<span<?= $Page->begin_date->viewAttributes() ?>>
<?= $Page->begin_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
        <td data-name="investor_witness_lname"<?= $Page->investor_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_witness_lname" class="el_doc_juzmatch2_investor_witness_lname">
<span<?= $Page->investor_witness_lname->viewAttributes() ?>>
<?= $Page->investor_witness_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
        <td data-name="investor_witness_email"<?= $Page->investor_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_witness_email" class="el_doc_juzmatch2_investor_witness_email">
<span<?= $Page->investor_witness_email->viewAttributes() ?>>
<?= $Page->investor_witness_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td data-name="juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_lname" class="el_doc_juzmatch2_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td data-name="juzmatch_authority_email"<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_email" class="el_doc_juzmatch2_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td data-name="juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_witness_lname" class="el_doc_juzmatch2_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td data-name="juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_witness_email" class="el_doc_juzmatch2_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <td data-name="juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority2_name" class="el_doc_juzmatch2_juzmatch_authority2_name">
<span<?= $Page->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td data-name="juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority2_lname" class="el_doc_juzmatch2_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td data-name="juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority2_email" class="el_doc_juzmatch2_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <td data-name="company_seal_name"<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_company_seal_name" class="el_doc_juzmatch2_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <td data-name="company_seal_email"<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_company_seal_email" class="el_doc_juzmatch2_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->file_loan->Visible) { // file_loan ?>
        <td data-name="file_loan"<?= $Page->file_loan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_file_loan" class="el_doc_juzmatch2_file_loan">
<span<?= $Page->file_loan->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_loan, $Page->file_loan->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td data-name="contact_address"<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_address" class="el_doc_juzmatch2_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <td data-name="contact_address2"<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_address2" class="el_doc_juzmatch2_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td data-name="contact_email"<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_email" class="el_doc_juzmatch2_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <td data-name="contact_lineid"<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_lineid" class="el_doc_juzmatch2_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <td data-name="contact_phone"<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_phone" class="el_doc_juzmatch2_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_cdate" class="el_doc_juzmatch2_cdate">
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
    ew.addEventHandlers("doc_juzmatch2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
