<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch2Preview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { doc_juzmatch2: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid doc_juzmatch2"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table table-bordered table-hover table-sm ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->document_date->Visible) { // document_date ?>
    <?php if ($Page->SortUrl($Page->document_date) == "") { ?>
        <th class="<?= $Page->document_date->headerCellClass() ?>"><?= $Page->document_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->document_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->document_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->document_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->document_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->document_date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <?php if ($Page->SortUrl($Page->asset_code) == "") { ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><?= $Page->asset_code->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_code->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_code->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_code->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_code->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
    <?php if ($Page->SortUrl($Page->asset_project) == "") { ?>
        <th class="<?= $Page->asset_project->headerCellClass() ?>"><?= $Page->asset_project->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_project->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_project->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_project->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_project->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_project->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
    <?php if ($Page->SortUrl($Page->asset_deed) == "") { ?>
        <th class="<?= $Page->asset_deed->headerCellClass() ?>"><?= $Page->asset_deed->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_deed->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_deed->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_deed->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_deed->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_deed->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
    <?php if ($Page->SortUrl($Page->asset_area) == "") { ?>
        <th class="<?= $Page->asset_area->headerCellClass() ?>"><?= $Page->asset_area->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_area->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_area->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_area->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_area->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_area->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
    <?php if ($Page->SortUrl($Page->investor_lname) == "") { ?>
        <th class="<?= $Page->investor_lname->headerCellClass() ?>"><?= $Page->investor_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
    <?php if ($Page->SortUrl($Page->investor_email) == "") { ?>
        <th class="<?= $Page->investor_email->headerCellClass() ?>"><?= $Page->investor_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
    <?php if ($Page->SortUrl($Page->investor_idcard) == "") { ?>
        <th class="<?= $Page->investor_idcard->headerCellClass() ?>"><?= $Page->investor_idcard->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_idcard->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_idcard->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_idcard->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_idcard->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_idcard->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
    <?php if ($Page->SortUrl($Page->investor_homeno) == "") { ?>
        <th class="<?= $Page->investor_homeno->headerCellClass() ?>"><?= $Page->investor_homeno->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_homeno->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_homeno->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_homeno->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_homeno->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_homeno->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
    <?php if ($Page->SortUrl($Page->investment_money) == "") { ?>
        <th class="<?= $Page->investment_money->headerCellClass() ?>"><?= $Page->investment_money->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investment_money->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investment_money->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investment_money->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investment_money->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investment_money->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
    <?php if ($Page->SortUrl($Page->loan_contact_date) == "") { ?>
        <th class="<?= $Page->loan_contact_date->headerCellClass() ?>"><?= $Page->loan_contact_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->loan_contact_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->loan_contact_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->loan_contact_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->loan_contact_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->loan_contact_date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
    <?php if ($Page->SortUrl($Page->contract_expired) == "") { ?>
        <th class="<?= $Page->contract_expired->headerCellClass() ?>"><?= $Page->contract_expired->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contract_expired->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->contract_expired->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contract_expired->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contract_expired->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contract_expired->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
    <?php if ($Page->SortUrl($Page->first_benefits_month) == "") { ?>
        <th class="<?= $Page->first_benefits_month->headerCellClass() ?>"><?= $Page->first_benefits_month->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->first_benefits_month->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->first_benefits_month->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->first_benefits_month->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->first_benefits_month->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->first_benefits_month->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
    <?php if ($Page->SortUrl($Page->one_installment_amount) == "") { ?>
        <th class="<?= $Page->one_installment_amount->headerCellClass() ?>"><?= $Page->one_installment_amount->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->one_installment_amount->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->one_installment_amount->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->one_installment_amount->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->one_installment_amount->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->one_installment_amount->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
    <?php if ($Page->SortUrl($Page->two_installment_amount1) == "") { ?>
        <th class="<?= $Page->two_installment_amount1->headerCellClass() ?>"><?= $Page->two_installment_amount1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->two_installment_amount1->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->two_installment_amount1->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->two_installment_amount1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->two_installment_amount1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->two_installment_amount1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
    <?php if ($Page->SortUrl($Page->two_installment_amount2) == "") { ?>
        <th class="<?= $Page->two_installment_amount2->headerCellClass() ?>"><?= $Page->two_installment_amount2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->two_installment_amount2->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->two_installment_amount2->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->two_installment_amount2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->two_installment_amount2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->two_installment_amount2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
    <?php if ($Page->SortUrl($Page->investor_paid_amount) == "") { ?>
        <th class="<?= $Page->investor_paid_amount->headerCellClass() ?>"><?= $Page->investor_paid_amount->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_paid_amount->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_paid_amount->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_paid_amount->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_paid_amount->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_paid_amount->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
    <?php if ($Page->SortUrl($Page->first_benefits_date) == "") { ?>
        <th class="<?= $Page->first_benefits_date->headerCellClass() ?>"><?= $Page->first_benefits_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->first_benefits_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->first_benefits_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->first_benefits_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->first_benefits_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->first_benefits_date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
    <?php if ($Page->SortUrl($Page->one_benefit_amount) == "") { ?>
        <th class="<?= $Page->one_benefit_amount->headerCellClass() ?>"><?= $Page->one_benefit_amount->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->one_benefit_amount->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->one_benefit_amount->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->one_benefit_amount->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->one_benefit_amount->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->one_benefit_amount->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
    <?php if ($Page->SortUrl($Page->two_benefit_amount1) == "") { ?>
        <th class="<?= $Page->two_benefit_amount1->headerCellClass() ?>"><?= $Page->two_benefit_amount1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->two_benefit_amount1->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->two_benefit_amount1->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->two_benefit_amount1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->two_benefit_amount1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->two_benefit_amount1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
    <?php if ($Page->SortUrl($Page->two_benefit_amount2) == "") { ?>
        <th class="<?= $Page->two_benefit_amount2->headerCellClass() ?>"><?= $Page->two_benefit_amount2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->two_benefit_amount2->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->two_benefit_amount2->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->two_benefit_amount2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->two_benefit_amount2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->two_benefit_amount2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
    <?php if ($Page->SortUrl($Page->management_agent_date) == "") { ?>
        <th class="<?= $Page->management_agent_date->headerCellClass() ?>"><?= $Page->management_agent_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->management_agent_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->management_agent_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->management_agent_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->management_agent_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->management_agent_date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
    <?php if ($Page->SortUrl($Page->begin_date) == "") { ?>
        <th class="<?= $Page->begin_date->headerCellClass() ?>"><?= $Page->begin_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->begin_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->begin_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->begin_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->begin_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->begin_date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
    <?php if ($Page->SortUrl($Page->investor_witness_lname) == "") { ?>
        <th class="<?= $Page->investor_witness_lname->headerCellClass() ?>"><?= $Page->investor_witness_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_witness_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_witness_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_witness_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_witness_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_witness_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
    <?php if ($Page->SortUrl($Page->investor_witness_email) == "") { ?>
        <th class="<?= $Page->investor_witness_email->headerCellClass() ?>"><?= $Page->investor_witness_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investor_witness_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investor_witness_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investor_witness_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investor_witness_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investor_witness_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority_lname) == "") { ?>
        <th class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><?= $Page->juzmatch_authority_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority_email) == "") { ?>
        <th class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><?= $Page->juzmatch_authority_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority_witness_lname) == "") { ?>
        <th class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><?= $Page->juzmatch_authority_witness_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority_witness_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority_witness_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority_witness_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority_witness_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority_witness_email) == "") { ?>
        <th class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><?= $Page->juzmatch_authority_witness_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority_witness_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority_witness_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority_witness_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority_witness_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority2_name) == "") { ?>
        <th class="<?= $Page->juzmatch_authority2_name->headerCellClass() ?>"><?= $Page->juzmatch_authority2_name->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority2_name->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority2_name->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority2_name->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority2_name->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority2_name->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority2_lname) == "") { ?>
        <th class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><?= $Page->juzmatch_authority2_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority2_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority2_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority2_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority2_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
    <?php if ($Page->SortUrl($Page->juzmatch_authority2_email) == "") { ?>
        <th class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><?= $Page->juzmatch_authority2_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->juzmatch_authority2_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->juzmatch_authority2_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->juzmatch_authority2_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->juzmatch_authority2_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
    <?php if ($Page->SortUrl($Page->company_seal_name) == "") { ?>
        <th class="<?= $Page->company_seal_name->headerCellClass() ?>"><?= $Page->company_seal_name->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->company_seal_name->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->company_seal_name->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->company_seal_name->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->company_seal_name->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->company_seal_name->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
    <?php if ($Page->SortUrl($Page->company_seal_email) == "") { ?>
        <th class="<?= $Page->company_seal_email->headerCellClass() ?>"><?= $Page->company_seal_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->company_seal_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->company_seal_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->company_seal_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->company_seal_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->company_seal_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <?php if ($Page->SortUrl($Page->contact_address) == "") { ?>
        <th class="<?= $Page->contact_address->headerCellClass() ?>"><?= $Page->contact_address->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contact_address->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->contact_address->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contact_address->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contact_address->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contact_address->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
    <?php if ($Page->SortUrl($Page->contact_address2) == "") { ?>
        <th class="<?= $Page->contact_address2->headerCellClass() ?>"><?= $Page->contact_address2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contact_address2->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->contact_address2->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contact_address2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contact_address2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contact_address2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <?php if ($Page->SortUrl($Page->contact_email) == "") { ?>
        <th class="<?= $Page->contact_email->headerCellClass() ?>"><?= $Page->contact_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contact_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->contact_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contact_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contact_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contact_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
    <?php if ($Page->SortUrl($Page->contact_lineid) == "") { ?>
        <th class="<?= $Page->contact_lineid->headerCellClass() ?>"><?= $Page->contact_lineid->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contact_lineid->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->contact_lineid->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contact_lineid->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contact_lineid->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contact_lineid->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
    <?php if ($Page->SortUrl($Page->contact_phone) == "") { ?>
        <th class="<?= $Page->contact_phone->headerCellClass() ?>"><?= $Page->contact_phone->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contact_phone->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->contact_phone->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->contact_phone->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contact_phone->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contact_phone->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
    <?php if ($Page->SortUrl($Page->attach_file) == "") { ?>
        <th class="<?= $Page->attach_file->headerCellClass() ?>"><?= $Page->attach_file->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->attach_file->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->attach_file->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->attach_file->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->attach_file->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->attach_file->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <?php if ($Page->SortUrl($Page->status) == "") { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><?= $Page->status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <?php if ($Page->SortUrl($Page->cdate) == "") { ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><?= $Page->cdate->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->cdate->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->cdate->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cdate->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cdate->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->document_date->Visible) { // document_date ?>
        <!-- document_date -->
        <td<?= $Page->document_date->cellAttributes() ?>>
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <!-- asset_code -->
        <td<?= $Page->asset_code->cellAttributes() ?>>
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <!-- asset_project -->
        <td<?= $Page->asset_project->cellAttributes() ?>>
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <!-- asset_deed -->
        <td<?= $Page->asset_deed->cellAttributes() ?>>
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <!-- asset_area -->
        <td<?= $Page->asset_area->cellAttributes() ?>>
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <!-- investor_lname -->
        <td<?= $Page->investor_lname->cellAttributes() ?>>
<span<?= $Page->investor_lname->viewAttributes() ?>>
<?= $Page->investor_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <!-- investor_email -->
        <td<?= $Page->investor_email->cellAttributes() ?>>
<span<?= $Page->investor_email->viewAttributes() ?>>
<?= $Page->investor_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
        <!-- investor_idcard -->
        <td<?= $Page->investor_idcard->cellAttributes() ?>>
<span<?= $Page->investor_idcard->viewAttributes() ?>>
<?= $Page->investor_idcard->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
        <!-- investor_homeno -->
        <td<?= $Page->investor_homeno->cellAttributes() ?>>
<span<?= $Page->investor_homeno->viewAttributes() ?>>
<?= $Page->investor_homeno->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
        <!-- investment_money -->
        <td<?= $Page->investment_money->cellAttributes() ?>>
<span<?= $Page->investment_money->viewAttributes() ?>>
<?= $Page->investment_money->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
        <!-- loan_contact_date -->
        <td<?= $Page->loan_contact_date->cellAttributes() ?>>
<span<?= $Page->loan_contact_date->viewAttributes() ?>>
<?= $Page->loan_contact_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
        <!-- contract_expired -->
        <td<?= $Page->contract_expired->cellAttributes() ?>>
<span<?= $Page->contract_expired->viewAttributes() ?>>
<?= $Page->contract_expired->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
        <!-- first_benefits_month -->
        <td<?= $Page->first_benefits_month->cellAttributes() ?>>
<span<?= $Page->first_benefits_month->viewAttributes() ?>>
<?= $Page->first_benefits_month->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
        <!-- one_installment_amount -->
        <td<?= $Page->one_installment_amount->cellAttributes() ?>>
<span<?= $Page->one_installment_amount->viewAttributes() ?>>
<?= $Page->one_installment_amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
        <!-- two_installment_amount1 -->
        <td<?= $Page->two_installment_amount1->cellAttributes() ?>>
<span<?= $Page->two_installment_amount1->viewAttributes() ?>>
<?= $Page->two_installment_amount1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
        <!-- two_installment_amount2 -->
        <td<?= $Page->two_installment_amount2->cellAttributes() ?>>
<span<?= $Page->two_installment_amount2->viewAttributes() ?>>
<?= $Page->two_installment_amount2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
        <!-- investor_paid_amount -->
        <td<?= $Page->investor_paid_amount->cellAttributes() ?>>
<span<?= $Page->investor_paid_amount->viewAttributes() ?>>
<?= $Page->investor_paid_amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
        <!-- first_benefits_date -->
        <td<?= $Page->first_benefits_date->cellAttributes() ?>>
<span<?= $Page->first_benefits_date->viewAttributes() ?>>
<?= $Page->first_benefits_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
        <!-- one_benefit_amount -->
        <td<?= $Page->one_benefit_amount->cellAttributes() ?>>
<span<?= $Page->one_benefit_amount->viewAttributes() ?>>
<?= $Page->one_benefit_amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
        <!-- two_benefit_amount1 -->
        <td<?= $Page->two_benefit_amount1->cellAttributes() ?>>
<span<?= $Page->two_benefit_amount1->viewAttributes() ?>>
<?= $Page->two_benefit_amount1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
        <!-- two_benefit_amount2 -->
        <td<?= $Page->two_benefit_amount2->cellAttributes() ?>>
<span<?= $Page->two_benefit_amount2->viewAttributes() ?>>
<?= $Page->two_benefit_amount2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
        <!-- management_agent_date -->
        <td<?= $Page->management_agent_date->cellAttributes() ?>>
<span<?= $Page->management_agent_date->viewAttributes() ?>>
<?= $Page->management_agent_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
        <!-- begin_date -->
        <td<?= $Page->begin_date->cellAttributes() ?>>
<span<?= $Page->begin_date->viewAttributes() ?>>
<?= $Page->begin_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
        <!-- investor_witness_lname -->
        <td<?= $Page->investor_witness_lname->cellAttributes() ?>>
<span<?= $Page->investor_witness_lname->viewAttributes() ?>>
<?= $Page->investor_witness_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
        <!-- investor_witness_email -->
        <td<?= $Page->investor_witness_email->cellAttributes() ?>>
<span<?= $Page->investor_witness_email->viewAttributes() ?>>
<?= $Page->investor_witness_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <!-- juzmatch_authority_lname -->
        <td<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <!-- juzmatch_authority_email -->
        <td<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <!-- juzmatch_authority_witness_lname -->
        <td<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <!-- juzmatch_authority_witness_email -->
        <td<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
        <!-- juzmatch_authority2_name -->
        <td<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_name->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <!-- juzmatch_authority2_lname -->
        <td<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <!-- juzmatch_authority2_email -->
        <td<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <!-- company_seal_name -->
        <td<?= $Page->company_seal_name->cellAttributes() ?>>
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <!-- company_seal_email -->
        <td<?= $Page->company_seal_email->cellAttributes() ?>>
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <!-- contact_address -->
        <td<?= $Page->contact_address->cellAttributes() ?>>
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <!-- contact_address2 -->
        <td<?= $Page->contact_address2->cellAttributes() ?>>
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <!-- contact_email -->
        <td<?= $Page->contact_email->cellAttributes() ?>>
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <!-- contact_lineid -->
        <td<?= $Page->contact_lineid->cellAttributes() ?>>
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <!-- contact_phone -->
        <td<?= $Page->contact_phone->cellAttributes() ?>>
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <!-- attach_file -->
        <td<?= $Page->attach_file->cellAttributes() ?>>
<span<?= $Page->attach_file->viewAttributes() ?>>
<?= $Page->attach_file->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <!-- cdate -->
        <td<?= $Page->cdate->cellAttributes() ?>>
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
