<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch2Delete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch2: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch2delete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch2delete = new ew.Form("fdoc_juzmatch2delete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_juzmatch2delete;
    loadjs.done("fdoc_juzmatch2delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdoc_juzmatch2delete" id="fdoc_juzmatch2delete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch2">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->document_date->Visible) { // document_date ?>
        <th class="<?= $Page->document_date->headerCellClass() ?>"><span id="elh_doc_juzmatch2_document_date" class="doc_juzmatch2_document_date"><?= $Page->document_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><span id="elh_doc_juzmatch2_asset_code" class="doc_juzmatch2_asset_code"><?= $Page->asset_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <th class="<?= $Page->asset_project->headerCellClass() ?>"><span id="elh_doc_juzmatch2_asset_project" class="doc_juzmatch2_asset_project"><?= $Page->asset_project->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <th class="<?= $Page->asset_deed->headerCellClass() ?>"><span id="elh_doc_juzmatch2_asset_deed" class="doc_juzmatch2_asset_deed"><?= $Page->asset_deed->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <th class="<?= $Page->asset_area->headerCellClass() ?>"><span id="elh_doc_juzmatch2_asset_area" class="doc_juzmatch2_asset_area"><?= $Page->asset_area->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <th class="<?= $Page->investor_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_lname" class="doc_juzmatch2_investor_lname"><?= $Page->investor_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <th class="<?= $Page->investor_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_email" class="doc_juzmatch2_investor_email"><?= $Page->investor_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
        <th class="<?= $Page->investor_idcard->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_idcard" class="doc_juzmatch2_investor_idcard"><?= $Page->investor_idcard->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
        <th class="<?= $Page->investor_homeno->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_homeno" class="doc_juzmatch2_investor_homeno"><?= $Page->investor_homeno->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
        <th class="<?= $Page->investment_money->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investment_money" class="doc_juzmatch2_investment_money"><?= $Page->investment_money->caption() ?></span></th>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
        <th class="<?= $Page->loan_contact_date->headerCellClass() ?>"><span id="elh_doc_juzmatch2_loan_contact_date" class="doc_juzmatch2_loan_contact_date"><?= $Page->loan_contact_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
        <th class="<?= $Page->contract_expired->headerCellClass() ?>"><span id="elh_doc_juzmatch2_contract_expired" class="doc_juzmatch2_contract_expired"><?= $Page->contract_expired->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
        <th class="<?= $Page->first_benefits_month->headerCellClass() ?>"><span id="elh_doc_juzmatch2_first_benefits_month" class="doc_juzmatch2_first_benefits_month"><?= $Page->first_benefits_month->caption() ?></span></th>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
        <th class="<?= $Page->one_installment_amount->headerCellClass() ?>"><span id="elh_doc_juzmatch2_one_installment_amount" class="doc_juzmatch2_one_installment_amount"><?= $Page->one_installment_amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
        <th class="<?= $Page->two_installment_amount1->headerCellClass() ?>"><span id="elh_doc_juzmatch2_two_installment_amount1" class="doc_juzmatch2_two_installment_amount1"><?= $Page->two_installment_amount1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
        <th class="<?= $Page->two_installment_amount2->headerCellClass() ?>"><span id="elh_doc_juzmatch2_two_installment_amount2" class="doc_juzmatch2_two_installment_amount2"><?= $Page->two_installment_amount2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
        <th class="<?= $Page->investor_paid_amount->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_paid_amount" class="doc_juzmatch2_investor_paid_amount"><?= $Page->investor_paid_amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
        <th class="<?= $Page->first_benefits_date->headerCellClass() ?>"><span id="elh_doc_juzmatch2_first_benefits_date" class="doc_juzmatch2_first_benefits_date"><?= $Page->first_benefits_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
        <th class="<?= $Page->one_benefit_amount->headerCellClass() ?>"><span id="elh_doc_juzmatch2_one_benefit_amount" class="doc_juzmatch2_one_benefit_amount"><?= $Page->one_benefit_amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
        <th class="<?= $Page->two_benefit_amount1->headerCellClass() ?>"><span id="elh_doc_juzmatch2_two_benefit_amount1" class="doc_juzmatch2_two_benefit_amount1"><?= $Page->two_benefit_amount1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
        <th class="<?= $Page->two_benefit_amount2->headerCellClass() ?>"><span id="elh_doc_juzmatch2_two_benefit_amount2" class="doc_juzmatch2_two_benefit_amount2"><?= $Page->two_benefit_amount2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
        <th class="<?= $Page->management_agent_date->headerCellClass() ?>"><span id="elh_doc_juzmatch2_management_agent_date" class="doc_juzmatch2_management_agent_date"><?= $Page->management_agent_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
        <th class="<?= $Page->begin_date->headerCellClass() ?>"><span id="elh_doc_juzmatch2_begin_date" class="doc_juzmatch2_begin_date"><?= $Page->begin_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
        <th class="<?= $Page->investor_witness_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_witness_lname" class="doc_juzmatch2_investor_witness_lname"><?= $Page->investor_witness_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
        <th class="<?= $Page->investor_witness_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_investor_witness_email" class="doc_juzmatch2_investor_witness_email"><?= $Page->investor_witness_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <th class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_lname" class="doc_juzmatch2_juzmatch_authority_lname"><?= $Page->juzmatch_authority_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <th class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_email" class="doc_juzmatch2_juzmatch_authority_email"><?= $Page->juzmatch_authority_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <th class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_witness_lname" class="doc_juzmatch2_juzmatch_authority_witness_lname"><?= $Page->juzmatch_authority_witness_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <th class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_witness_email" class="doc_juzmatch2_juzmatch_authority_witness_email"><?= $Page->juzmatch_authority_witness_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <th class="<?= $Page->juzmatch_authority2_name->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority2_name" class="doc_juzmatch2_juzmatch_authority2_name"><?= $Page->juzmatch_authority2_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <th class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority2_lname" class="doc_juzmatch2_juzmatch_authority2_lname"><?= $Page->juzmatch_authority2_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <th class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_juzmatch_authority2_email" class="doc_juzmatch2_juzmatch_authority2_email"><?= $Page->juzmatch_authority2_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <th class="<?= $Page->company_seal_name->headerCellClass() ?>"><span id="elh_doc_juzmatch2_company_seal_name" class="doc_juzmatch2_company_seal_name"><?= $Page->company_seal_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <th class="<?= $Page->company_seal_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_company_seal_email" class="doc_juzmatch2_company_seal_email"><?= $Page->company_seal_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th class="<?= $Page->contact_address->headerCellClass() ?>"><span id="elh_doc_juzmatch2_contact_address" class="doc_juzmatch2_contact_address"><?= $Page->contact_address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <th class="<?= $Page->contact_address2->headerCellClass() ?>"><span id="elh_doc_juzmatch2_contact_address2" class="doc_juzmatch2_contact_address2"><?= $Page->contact_address2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th class="<?= $Page->contact_email->headerCellClass() ?>"><span id="elh_doc_juzmatch2_contact_email" class="doc_juzmatch2_contact_email"><?= $Page->contact_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <th class="<?= $Page->contact_lineid->headerCellClass() ?>"><span id="elh_doc_juzmatch2_contact_lineid" class="doc_juzmatch2_contact_lineid"><?= $Page->contact_lineid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <th class="<?= $Page->contact_phone->headerCellClass() ?>"><span id="elh_doc_juzmatch2_contact_phone" class="doc_juzmatch2_contact_phone"><?= $Page->contact_phone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <th class="<?= $Page->attach_file->headerCellClass() ?>"><span id="elh_doc_juzmatch2_attach_file" class="doc_juzmatch2_attach_file"><?= $Page->attach_file->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_doc_juzmatch2_status" class="doc_juzmatch2_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_doc_juzmatch2_cdate" class="doc_juzmatch2_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->document_date->Visible) { // document_date ?>
        <td<?= $Page->document_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_document_date" class="el_doc_juzmatch2_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_code" class="el_doc_juzmatch2_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <td<?= $Page->asset_project->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_project" class="el_doc_juzmatch2_asset_project">
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <td<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_deed" class="el_doc_juzmatch2_asset_deed">
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <td<?= $Page->asset_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_asset_area" class="el_doc_juzmatch2_asset_area">
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <td<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_lname" class="el_doc_juzmatch2_investor_lname">
<span<?= $Page->investor_lname->viewAttributes() ?>>
<?= $Page->investor_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <td<?= $Page->investor_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_email" class="el_doc_juzmatch2_investor_email">
<span<?= $Page->investor_email->viewAttributes() ?>>
<?= $Page->investor_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
        <td<?= $Page->investor_idcard->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_idcard" class="el_doc_juzmatch2_investor_idcard">
<span<?= $Page->investor_idcard->viewAttributes() ?>>
<?= $Page->investor_idcard->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
        <td<?= $Page->investor_homeno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_homeno" class="el_doc_juzmatch2_investor_homeno">
<span<?= $Page->investor_homeno->viewAttributes() ?>>
<?= $Page->investor_homeno->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
        <td<?= $Page->investment_money->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investment_money" class="el_doc_juzmatch2_investment_money">
<span<?= $Page->investment_money->viewAttributes() ?>>
<?= $Page->investment_money->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
        <td<?= $Page->loan_contact_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_loan_contact_date" class="el_doc_juzmatch2_loan_contact_date">
<span<?= $Page->loan_contact_date->viewAttributes() ?>>
<?= $Page->loan_contact_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
        <td<?= $Page->contract_expired->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contract_expired" class="el_doc_juzmatch2_contract_expired">
<span<?= $Page->contract_expired->viewAttributes() ?>>
<?= $Page->contract_expired->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
        <td<?= $Page->first_benefits_month->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_first_benefits_month" class="el_doc_juzmatch2_first_benefits_month">
<span<?= $Page->first_benefits_month->viewAttributes() ?>>
<?= $Page->first_benefits_month->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
        <td<?= $Page->one_installment_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_one_installment_amount" class="el_doc_juzmatch2_one_installment_amount">
<span<?= $Page->one_installment_amount->viewAttributes() ?>>
<?= $Page->one_installment_amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
        <td<?= $Page->two_installment_amount1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_installment_amount1" class="el_doc_juzmatch2_two_installment_amount1">
<span<?= $Page->two_installment_amount1->viewAttributes() ?>>
<?= $Page->two_installment_amount1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
        <td<?= $Page->two_installment_amount2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_installment_amount2" class="el_doc_juzmatch2_two_installment_amount2">
<span<?= $Page->two_installment_amount2->viewAttributes() ?>>
<?= $Page->two_installment_amount2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
        <td<?= $Page->investor_paid_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_paid_amount" class="el_doc_juzmatch2_investor_paid_amount">
<span<?= $Page->investor_paid_amount->viewAttributes() ?>>
<?= $Page->investor_paid_amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
        <td<?= $Page->first_benefits_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_first_benefits_date" class="el_doc_juzmatch2_first_benefits_date">
<span<?= $Page->first_benefits_date->viewAttributes() ?>>
<?= $Page->first_benefits_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
        <td<?= $Page->one_benefit_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_one_benefit_amount" class="el_doc_juzmatch2_one_benefit_amount">
<span<?= $Page->one_benefit_amount->viewAttributes() ?>>
<?= $Page->one_benefit_amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
        <td<?= $Page->two_benefit_amount1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_benefit_amount1" class="el_doc_juzmatch2_two_benefit_amount1">
<span<?= $Page->two_benefit_amount1->viewAttributes() ?>>
<?= $Page->two_benefit_amount1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
        <td<?= $Page->two_benefit_amount2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_two_benefit_amount2" class="el_doc_juzmatch2_two_benefit_amount2">
<span<?= $Page->two_benefit_amount2->viewAttributes() ?>>
<?= $Page->two_benefit_amount2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
        <td<?= $Page->management_agent_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_management_agent_date" class="el_doc_juzmatch2_management_agent_date">
<span<?= $Page->management_agent_date->viewAttributes() ?>>
<?= $Page->management_agent_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
        <td<?= $Page->begin_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_begin_date" class="el_doc_juzmatch2_begin_date">
<span<?= $Page->begin_date->viewAttributes() ?>>
<?= $Page->begin_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
        <td<?= $Page->investor_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_witness_lname" class="el_doc_juzmatch2_investor_witness_lname">
<span<?= $Page->investor_witness_lname->viewAttributes() ?>>
<?= $Page->investor_witness_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
        <td<?= $Page->investor_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_investor_witness_email" class="el_doc_juzmatch2_investor_witness_email">
<span<?= $Page->investor_witness_email->viewAttributes() ?>>
<?= $Page->investor_witness_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_lname" class="el_doc_juzmatch2_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_email" class="el_doc_juzmatch2_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_witness_lname" class="el_doc_juzmatch2_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority_witness_email" class="el_doc_juzmatch2_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <td<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority2_name" class="el_doc_juzmatch2_juzmatch_authority2_name">
<span<?= $Page->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority2_lname" class="el_doc_juzmatch2_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_juzmatch_authority2_email" class="el_doc_juzmatch2_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <td<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_company_seal_name" class="el_doc_juzmatch2_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <td<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_company_seal_email" class="el_doc_juzmatch2_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_address" class="el_doc_juzmatch2_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <td<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_address2" class="el_doc_juzmatch2_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_email" class="el_doc_juzmatch2_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <td<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_lineid" class="el_doc_juzmatch2_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <td<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_contact_phone" class="el_doc_juzmatch2_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <td<?= $Page->attach_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_attach_file" class="el_doc_juzmatch2_attach_file">
<span<?= $Page->attach_file->viewAttributes() ?>>
<?= $Page->attach_file->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_status" class="el_doc_juzmatch2_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch2_cdate" class="el_doc_juzmatch2_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
