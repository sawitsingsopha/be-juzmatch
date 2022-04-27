<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch2View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch2: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch2view;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch2view = new ew.Form("fdoc_juzmatch2view", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fdoc_juzmatch2view;
    loadjs.done("fdoc_juzmatch2view");
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
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdoc_juzmatch2view" id="fdoc_juzmatch2view" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch2">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->document_date->Visible) { // document_date ?>
    <tr id="r_document_date"<?= $Page->document_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_document_date"><?= $Page->document_date->caption() ?></span></td>
        <td data-name="document_date"<?= $Page->document_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <tr id="r_asset_code"<?= $Page->asset_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_asset_code"><?= $Page->asset_code->caption() ?></span></td>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
    <tr id="r_asset_project"<?= $Page->asset_project->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_asset_project"><?= $Page->asset_project->caption() ?></span></td>
        <td data-name="asset_project"<?= $Page->asset_project->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_project">
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
    <tr id="r_asset_deed"<?= $Page->asset_deed->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_asset_deed"><?= $Page->asset_deed->caption() ?></span></td>
        <td data-name="asset_deed"<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_deed">
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
    <tr id="r_asset_area"<?= $Page->asset_area->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_asset_area"><?= $Page->asset_area->caption() ?></span></td>
        <td data-name="asset_area"<?= $Page->asset_area->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_area">
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_name->Visible) { // investor_name ?>
    <tr id="r_investor_name"<?= $Page->investor_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_name"><?= $Page->investor_name->caption() ?></span></td>
        <td data-name="investor_name"<?= $Page->investor_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_name">
<span<?= $Page->investor_name->viewAttributes() ?>>
<?= $Page->investor_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
    <tr id="r_investor_lname"<?= $Page->investor_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_lname"><?= $Page->investor_lname->caption() ?></span></td>
        <td data-name="investor_lname"<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_lname">
<span<?= $Page->investor_lname->viewAttributes() ?>>
<?= $Page->investor_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
    <tr id="r_investor_email"<?= $Page->investor_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_email"><?= $Page->investor_email->caption() ?></span></td>
        <td data-name="investor_email"<?= $Page->investor_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_email">
<span<?= $Page->investor_email->viewAttributes() ?>>
<?= $Page->investor_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
    <tr id="r_investor_idcard"<?= $Page->investor_idcard->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_idcard"><?= $Page->investor_idcard->caption() ?></span></td>
        <td data-name="investor_idcard"<?= $Page->investor_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_idcard">
<span<?= $Page->investor_idcard->viewAttributes() ?>>
<?= $Page->investor_idcard->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
    <tr id="r_investor_homeno"<?= $Page->investor_homeno->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_homeno"><?= $Page->investor_homeno->caption() ?></span></td>
        <td data-name="investor_homeno"<?= $Page->investor_homeno->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_homeno">
<span<?= $Page->investor_homeno->viewAttributes() ?>>
<?= $Page->investor_homeno->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
    <tr id="r_investment_money"<?= $Page->investment_money->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investment_money"><?= $Page->investment_money->caption() ?></span></td>
        <td data-name="investment_money"<?= $Page->investment_money->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investment_money">
<span<?= $Page->investment_money->viewAttributes() ?>>
<?= $Page->investment_money->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investment_money_txt->Visible) { // investment_money_txt ?>
    <tr id="r_investment_money_txt"<?= $Page->investment_money_txt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investment_money_txt"><?= $Page->investment_money_txt->caption() ?></span></td>
        <td data-name="investment_money_txt"<?= $Page->investment_money_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investment_money_txt">
<span<?= $Page->investment_money_txt->viewAttributes() ?>>
<?= $Page->investment_money_txt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
    <tr id="r_loan_contact_date"<?= $Page->loan_contact_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_loan_contact_date"><?= $Page->loan_contact_date->caption() ?></span></td>
        <td data-name="loan_contact_date"<?= $Page->loan_contact_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_loan_contact_date">
<span<?= $Page->loan_contact_date->viewAttributes() ?>>
<?= $Page->loan_contact_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
    <tr id="r_contract_expired"<?= $Page->contract_expired->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_contract_expired"><?= $Page->contract_expired->caption() ?></span></td>
        <td data-name="contract_expired"<?= $Page->contract_expired->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contract_expired">
<span<?= $Page->contract_expired->viewAttributes() ?>>
<?= $Page->contract_expired->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
    <tr id="r_first_benefits_month"<?= $Page->first_benefits_month->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_first_benefits_month"><?= $Page->first_benefits_month->caption() ?></span></td>
        <td data-name="first_benefits_month"<?= $Page->first_benefits_month->cellAttributes() ?>>
<span id="el_doc_juzmatch2_first_benefits_month">
<span<?= $Page->first_benefits_month->viewAttributes() ?>>
<?= $Page->first_benefits_month->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
    <tr id="r_one_installment_amount"<?= $Page->one_installment_amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_one_installment_amount"><?= $Page->one_installment_amount->caption() ?></span></td>
        <td data-name="one_installment_amount"<?= $Page->one_installment_amount->cellAttributes() ?>>
<span id="el_doc_juzmatch2_one_installment_amount">
<span<?= $Page->one_installment_amount->viewAttributes() ?>>
<?= $Page->one_installment_amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
    <tr id="r_two_installment_amount1"<?= $Page->two_installment_amount1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_two_installment_amount1"><?= $Page->two_installment_amount1->caption() ?></span></td>
        <td data-name="two_installment_amount1"<?= $Page->two_installment_amount1->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_installment_amount1">
<span<?= $Page->two_installment_amount1->viewAttributes() ?>>
<?= $Page->two_installment_amount1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
    <tr id="r_two_installment_amount2"<?= $Page->two_installment_amount2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_two_installment_amount2"><?= $Page->two_installment_amount2->caption() ?></span></td>
        <td data-name="two_installment_amount2"<?= $Page->two_installment_amount2->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_installment_amount2">
<span<?= $Page->two_installment_amount2->viewAttributes() ?>>
<?= $Page->two_installment_amount2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
    <tr id="r_investor_paid_amount"<?= $Page->investor_paid_amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_paid_amount"><?= $Page->investor_paid_amount->caption() ?></span></td>
        <td data-name="investor_paid_amount"<?= $Page->investor_paid_amount->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_paid_amount">
<span<?= $Page->investor_paid_amount->viewAttributes() ?>>
<?= $Page->investor_paid_amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
    <tr id="r_first_benefits_date"<?= $Page->first_benefits_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_first_benefits_date"><?= $Page->first_benefits_date->caption() ?></span></td>
        <td data-name="first_benefits_date"<?= $Page->first_benefits_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_first_benefits_date">
<span<?= $Page->first_benefits_date->viewAttributes() ?>>
<?= $Page->first_benefits_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
    <tr id="r_one_benefit_amount"<?= $Page->one_benefit_amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_one_benefit_amount"><?= $Page->one_benefit_amount->caption() ?></span></td>
        <td data-name="one_benefit_amount"<?= $Page->one_benefit_amount->cellAttributes() ?>>
<span id="el_doc_juzmatch2_one_benefit_amount">
<span<?= $Page->one_benefit_amount->viewAttributes() ?>>
<?= $Page->one_benefit_amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
    <tr id="r_two_benefit_amount1"<?= $Page->two_benefit_amount1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_two_benefit_amount1"><?= $Page->two_benefit_amount1->caption() ?></span></td>
        <td data-name="two_benefit_amount1"<?= $Page->two_benefit_amount1->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_benefit_amount1">
<span<?= $Page->two_benefit_amount1->viewAttributes() ?>>
<?= $Page->two_benefit_amount1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
    <tr id="r_two_benefit_amount2"<?= $Page->two_benefit_amount2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_two_benefit_amount2"><?= $Page->two_benefit_amount2->caption() ?></span></td>
        <td data-name="two_benefit_amount2"<?= $Page->two_benefit_amount2->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_benefit_amount2">
<span<?= $Page->two_benefit_amount2->viewAttributes() ?>>
<?= $Page->two_benefit_amount2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
    <tr id="r_management_agent_date"<?= $Page->management_agent_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_management_agent_date"><?= $Page->management_agent_date->caption() ?></span></td>
        <td data-name="management_agent_date"<?= $Page->management_agent_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_management_agent_date">
<span<?= $Page->management_agent_date->viewAttributes() ?>>
<?= $Page->management_agent_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
    <tr id="r_begin_date"<?= $Page->begin_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_begin_date"><?= $Page->begin_date->caption() ?></span></td>
        <td data-name="begin_date"<?= $Page->begin_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_begin_date">
<span<?= $Page->begin_date->viewAttributes() ?>>
<?= $Page->begin_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_witness_name->Visible) { // investor_witness_name ?>
    <tr id="r_investor_witness_name"<?= $Page->investor_witness_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_witness_name"><?= $Page->investor_witness_name->caption() ?></span></td>
        <td data-name="investor_witness_name"<?= $Page->investor_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_witness_name">
<span<?= $Page->investor_witness_name->viewAttributes() ?>>
<?= $Page->investor_witness_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
    <tr id="r_investor_witness_lname"<?= $Page->investor_witness_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_witness_lname"><?= $Page->investor_witness_lname->caption() ?></span></td>
        <td data-name="investor_witness_lname"<?= $Page->investor_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_witness_lname">
<span<?= $Page->investor_witness_lname->viewAttributes() ?>>
<?= $Page->investor_witness_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
    <tr id="r_investor_witness_email"<?= $Page->investor_witness_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_investor_witness_email"><?= $Page->investor_witness_email->caption() ?></span></td>
        <td data-name="investor_witness_email"<?= $Page->investor_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_witness_email">
<span<?= $Page->investor_witness_email->viewAttributes() ?>>
<?= $Page->investor_witness_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_name->Visible) { // juzmatch_authority_name ?>
    <tr id="r_juzmatch_authority_name"<?= $Page->juzmatch_authority_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_name"><?= $Page->juzmatch_authority_name->caption() ?></span></td>
        <td data-name="juzmatch_authority_name"<?= $Page->juzmatch_authority_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_name">
<span<?= $Page->juzmatch_authority_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
    <tr id="r_juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_lname"><?= $Page->juzmatch_authority_lname->caption() ?></span></td>
        <td data-name="juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
    <tr id="r_juzmatch_authority_email"<?= $Page->juzmatch_authority_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_email"><?= $Page->juzmatch_authority_email->caption() ?></span></td>
        <td data-name="juzmatch_authority_email"<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_name->Visible) { // juzmatch_authority_witness_name ?>
    <tr id="r_juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_witness_name"><?= $Page->juzmatch_authority_witness_name->caption() ?></span></td>
        <td data-name="juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_witness_name">
<span<?= $Page->juzmatch_authority_witness_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
    <tr id="r_juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_witness_lname"><?= $Page->juzmatch_authority_witness_lname->caption() ?></span></td>
        <td data-name="juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
    <tr id="r_juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority_witness_email"><?= $Page->juzmatch_authority_witness_email->caption() ?></span></td>
        <td data-name="juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
    <tr id="r_juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority2_name"><?= $Page->juzmatch_authority2_name->caption() ?></span></td>
        <td data-name="juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority2_name">
<span<?= $Page->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
    <tr id="r_juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority2_lname"><?= $Page->juzmatch_authority2_lname->caption() ?></span></td>
        <td data-name="juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
    <tr id="r_juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_juzmatch_authority2_email"><?= $Page->juzmatch_authority2_email->caption() ?></span></td>
        <td data-name="juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
    <tr id="r_company_seal_name"<?= $Page->company_seal_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_company_seal_name"><?= $Page->company_seal_name->caption() ?></span></td>
        <td data-name="company_seal_name"<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
    <tr id="r_company_seal_email"<?= $Page->company_seal_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_company_seal_email"><?= $Page->company_seal_email->caption() ?></span></td>
        <td data-name="company_seal_email"<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_idcard->Visible) { // file_idcard ?>
    <tr id="r_file_idcard"<?= $Page->file_idcard->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_file_idcard"><?= $Page->file_idcard->caption() ?></span></td>
        <td data-name="file_idcard"<?= $Page->file_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_idcard">
<span<?= $Page->file_idcard->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_idcard, $Page->file_idcard->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_house_regis->Visible) { // file_house_regis ?>
    <tr id="r_file_house_regis"<?= $Page->file_house_regis->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_file_house_regis"><?= $Page->file_house_regis->caption() ?></span></td>
        <td data-name="file_house_regis"<?= $Page->file_house_regis->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_house_regis">
<span<?= $Page->file_house_regis->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_house_regis, $Page->file_house_regis->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_other->Visible) { // file_other ?>
    <tr id="r_file_other"<?= $Page->file_other->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_file_other"><?= $Page->file_other->caption() ?></span></td>
        <td data-name="file_other"<?= $Page->file_other->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_other">
<span<?= $Page->file_other->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_other, $Page->file_other->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <tr id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_contact_address"><?= $Page->contact_address->caption() ?></span></td>
        <td data-name="contact_address"<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
    <tr id="r_contact_address2"<?= $Page->contact_address2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_contact_address2"><?= $Page->contact_address2->caption() ?></span></td>
        <td data-name="contact_address2"<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <tr id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_contact_email"><?= $Page->contact_email->caption() ?></span></td>
        <td data-name="contact_email"<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
    <tr id="r_contact_lineid"<?= $Page->contact_lineid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_contact_lineid"><?= $Page->contact_lineid->caption() ?></span></td>
        <td data-name="contact_lineid"<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
    <tr id="r_contact_phone"<?= $Page->contact_phone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_contact_phone"><?= $Page->contact_phone->caption() ?></span></td>
        <td data-name="contact_phone"<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_loan->Visible) { // file_loan ?>
    <tr id="r_file_loan"<?= $Page->file_loan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_file_loan"><?= $Page->file_loan->caption() ?></span></td>
        <td data-name="file_loan"<?= $Page->file_loan->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_loan">
<span<?= $Page->file_loan->viewAttributes() ?>>
<?= $Page->file_loan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
    <tr id="r_attach_file"<?= $Page->attach_file->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_attach_file"><?= $Page->attach_file->caption() ?></span></td>
        <td data-name="attach_file"<?= $Page->attach_file->cellAttributes() ?>>
<span id="el_doc_juzmatch2_attach_file">
<span<?= $Page->attach_file->viewAttributes() ?>>
<?= $Page->attach_file->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_doc_juzmatch2_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch2_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_juzmatch2_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
