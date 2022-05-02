<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch1Preview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { doc_juzmatch1: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid doc_juzmatch1"><!-- .card -->
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
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
    <?php if ($Page->SortUrl($Page->buyer_lname) == "") { ?>
        <th class="<?= $Page->buyer_lname->headerCellClass() ?>"><?= $Page->buyer_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->buyer_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->buyer_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->buyer_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->buyer_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->buyer_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
    <?php if ($Page->SortUrl($Page->buyer_email) == "") { ?>
        <th class="<?= $Page->buyer_email->headerCellClass() ?>"><?= $Page->buyer_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->buyer_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->buyer_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->buyer_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->buyer_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->buyer_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
    <?php if ($Page->SortUrl($Page->buyer_idcard) == "") { ?>
        <th class="<?= $Page->buyer_idcard->headerCellClass() ?>"><?= $Page->buyer_idcard->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->buyer_idcard->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->buyer_idcard->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->buyer_idcard->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->buyer_idcard->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->buyer_idcard->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
    <?php if ($Page->SortUrl($Page->buyer_homeno) == "") { ?>
        <th class="<?= $Page->buyer_homeno->headerCellClass() ?>"><?= $Page->buyer_homeno->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->buyer_homeno->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->buyer_homeno->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->buyer_homeno->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->buyer_homeno->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->buyer_homeno->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
    <?php if ($Page->SortUrl($Page->buyer_witness_lname) == "") { ?>
        <th class="<?= $Page->buyer_witness_lname->headerCellClass() ?>"><?= $Page->buyer_witness_lname->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->buyer_witness_lname->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->buyer_witness_lname->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->buyer_witness_lname->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->buyer_witness_lname->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->buyer_witness_lname->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
    <?php if ($Page->SortUrl($Page->buyer_witness_email) == "") { ?>
        <th class="<?= $Page->buyer_witness_email->headerCellClass() ?>"><?= $Page->buyer_witness_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->buyer_witness_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->buyer_witness_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->buyer_witness_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->buyer_witness_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->buyer_witness_email->getSortIcon() ?></span>
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
<?php if ($Page->service_price->Visible) { // service_price ?>
    <?php if ($Page->SortUrl($Page->service_price) == "") { ?>
        <th class="<?= $Page->service_price->headerCellClass() ?>"><?= $Page->service_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->service_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->service_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->service_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->service_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->service_price->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
    <?php if ($Page->SortUrl($Page->service_price_txt) == "") { ?>
        <th class="<?= $Page->service_price_txt->headerCellClass() ?>"><?= $Page->service_price_txt->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->service_price_txt->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->service_price_txt->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->service_price_txt->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->service_price_txt->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->service_price_txt->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
    <?php if ($Page->SortUrl($Page->first_down) == "") { ?>
        <th class="<?= $Page->first_down->headerCellClass() ?>"><?= $Page->first_down->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->first_down->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->first_down->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->first_down->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->first_down->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->first_down->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
    <?php if ($Page->SortUrl($Page->first_down_txt) == "") { ?>
        <th class="<?= $Page->first_down_txt->headerCellClass() ?>"><?= $Page->first_down_txt->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->first_down_txt->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->first_down_txt->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->first_down_txt->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->first_down_txt->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->first_down_txt->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
    <?php if ($Page->SortUrl($Page->second_down) == "") { ?>
        <th class="<?= $Page->second_down->headerCellClass() ?>"><?= $Page->second_down->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->second_down->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->second_down->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->second_down->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->second_down->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->second_down->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
    <?php if ($Page->SortUrl($Page->second_down_txt) == "") { ?>
        <th class="<?= $Page->second_down_txt->headerCellClass() ?>"><?= $Page->second_down_txt->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->second_down_txt->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->second_down_txt->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->second_down_txt->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->second_down_txt->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->second_down_txt->getSortIcon() ?></span>
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
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <!-- asset_deed -->
        <td<?= $Page->asset_deed->cellAttributes() ?>>
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <!-- asset_project -->
        <td<?= $Page->asset_project->cellAttributes() ?>>
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <!-- asset_area -->
        <td<?= $Page->asset_area->cellAttributes() ?>>
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <!-- buyer_lname -->
        <td<?= $Page->buyer_lname->cellAttributes() ?>>
<span<?= $Page->buyer_lname->viewAttributes() ?>>
<?= $Page->buyer_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <!-- buyer_email -->
        <td<?= $Page->buyer_email->cellAttributes() ?>>
<span<?= $Page->buyer_email->viewAttributes() ?>>
<?= $Page->buyer_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <!-- buyer_idcard -->
        <td<?= $Page->buyer_idcard->cellAttributes() ?>>
<span<?= $Page->buyer_idcard->viewAttributes() ?>>
<?= $Page->buyer_idcard->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <!-- buyer_homeno -->
        <td<?= $Page->buyer_homeno->cellAttributes() ?>>
<span<?= $Page->buyer_homeno->viewAttributes() ?>>
<?= $Page->buyer_homeno->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <!-- buyer_witness_lname -->
        <td<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span<?= $Page->buyer_witness_lname->viewAttributes() ?>>
<?= $Page->buyer_witness_lname->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <!-- buyer_witness_email -->
        <td<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span<?= $Page->buyer_witness_email->viewAttributes() ?>>
<?= $Page->buyer_witness_email->getViewValue() ?></span>
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
<?php if ($Page->service_price->Visible) { // service_price ?>
        <!-- service_price -->
        <td<?= $Page->service_price->cellAttributes() ?>>
<span<?= $Page->service_price->viewAttributes() ?>>
<?= $Page->service_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
        <!-- service_price_txt -->
        <td<?= $Page->service_price_txt->cellAttributes() ?>>
<span<?= $Page->service_price_txt->viewAttributes() ?>>
<?= $Page->service_price_txt->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
        <!-- first_down -->
        <td<?= $Page->first_down->cellAttributes() ?>>
<span<?= $Page->first_down->viewAttributes() ?>>
<?= $Page->first_down->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
        <!-- first_down_txt -->
        <td<?= $Page->first_down_txt->cellAttributes() ?>>
<span<?= $Page->first_down_txt->viewAttributes() ?>>
<?= $Page->first_down_txt->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
        <!-- second_down -->
        <td<?= $Page->second_down->cellAttributes() ?>>
<span<?= $Page->second_down->viewAttributes() ?>>
<?= $Page->second_down->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
        <!-- second_down_txt -->
        <td<?= $Page->second_down_txt->cellAttributes() ?>>
<span<?= $Page->second_down_txt->viewAttributes() ?>>
<?= $Page->second_down_txt->getViewValue() ?></span>
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
