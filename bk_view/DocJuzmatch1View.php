<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch1View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch1: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch1view;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch1view = new ew.Form("fdoc_juzmatch1view", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fdoc_juzmatch1view;
    loadjs.done("fdoc_juzmatch1view");
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
<form name="fdoc_juzmatch1view" id="fdoc_juzmatch1view" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch1">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->document_date->Visible) { // document_date ?>
    <tr id="r_document_date"<?= $Page->document_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_document_date"><?= $Page->document_date->caption() ?></span></td>
        <td data-name="document_date"<?= $Page->document_date->cellAttributes() ?>>
<span id="el_doc_juzmatch1_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <tr id="r_asset_code"<?= $Page->asset_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_asset_code"><?= $Page->asset_code->caption() ?></span></td>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
    <tr id="r_asset_deed"<?= $Page->asset_deed->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_asset_deed"><?= $Page->asset_deed->caption() ?></span></td>
        <td data-name="asset_deed"<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_deed">
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
    <tr id="r_asset_project"<?= $Page->asset_project->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_asset_project"><?= $Page->asset_project->caption() ?></span></td>
        <td data-name="asset_project"<?= $Page->asset_project->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_project">
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
    <tr id="r_asset_area"<?= $Page->asset_area->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_asset_area"><?= $Page->asset_area->caption() ?></span></td>
        <td data-name="asset_area"<?= $Page->asset_area->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_area">
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_name->Visible) { // buyer_name ?>
    <tr id="r_buyer_name"<?= $Page->buyer_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_name"><?= $Page->buyer_name->caption() ?></span></td>
        <td data-name="buyer_name"<?= $Page->buyer_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_name">
<span<?= $Page->buyer_name->viewAttributes() ?>>
<?= $Page->buyer_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
    <tr id="r_buyer_lname"<?= $Page->buyer_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_lname"><?= $Page->buyer_lname->caption() ?></span></td>
        <td data-name="buyer_lname"<?= $Page->buyer_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_lname">
<span<?= $Page->buyer_lname->viewAttributes() ?>>
<?= $Page->buyer_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
    <tr id="r_buyer_email"<?= $Page->buyer_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_email"><?= $Page->buyer_email->caption() ?></span></td>
        <td data-name="buyer_email"<?= $Page->buyer_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_email">
<span<?= $Page->buyer_email->viewAttributes() ?>>
<?= $Page->buyer_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
    <tr id="r_buyer_idcard"<?= $Page->buyer_idcard->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_idcard"><?= $Page->buyer_idcard->caption() ?></span></td>
        <td data-name="buyer_idcard"<?= $Page->buyer_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_idcard">
<span<?= $Page->buyer_idcard->viewAttributes() ?>>
<?= $Page->buyer_idcard->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
    <tr id="r_buyer_homeno"<?= $Page->buyer_homeno->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_homeno"><?= $Page->buyer_homeno->caption() ?></span></td>
        <td data-name="buyer_homeno"<?= $Page->buyer_homeno->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_homeno">
<span<?= $Page->buyer_homeno->viewAttributes() ?>>
<?= $Page->buyer_homeno->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_witness_name->Visible) { // buyer_witness_name ?>
    <tr id="r_buyer_witness_name"<?= $Page->buyer_witness_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_witness_name"><?= $Page->buyer_witness_name->caption() ?></span></td>
        <td data-name="buyer_witness_name"<?= $Page->buyer_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_witness_name">
<span<?= $Page->buyer_witness_name->viewAttributes() ?>>
<?= $Page->buyer_witness_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
    <tr id="r_buyer_witness_lname"<?= $Page->buyer_witness_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_witness_lname"><?= $Page->buyer_witness_lname->caption() ?></span></td>
        <td data-name="buyer_witness_lname"<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_witness_lname">
<span<?= $Page->buyer_witness_lname->viewAttributes() ?>>
<?= $Page->buyer_witness_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
    <tr id="r_buyer_witness_email"<?= $Page->buyer_witness_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_buyer_witness_email"><?= $Page->buyer_witness_email->caption() ?></span></td>
        <td data-name="buyer_witness_email"<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_witness_email">
<span<?= $Page->buyer_witness_email->viewAttributes() ?>>
<?= $Page->buyer_witness_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_name->Visible) { // juzmatch_authority_name ?>
    <tr id="r_juzmatch_authority_name"<?= $Page->juzmatch_authority_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_name"><?= $Page->juzmatch_authority_name->caption() ?></span></td>
        <td data-name="juzmatch_authority_name"<?= $Page->juzmatch_authority_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_name">
<span<?= $Page->juzmatch_authority_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
    <tr id="r_juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_lname"><?= $Page->juzmatch_authority_lname->caption() ?></span></td>
        <td data-name="juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
    <tr id="r_juzmatch_authority_email"<?= $Page->juzmatch_authority_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_email"><?= $Page->juzmatch_authority_email->caption() ?></span></td>
        <td data-name="juzmatch_authority_email"<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_name->Visible) { // juzmatch_authority_witness_name ?>
    <tr id="r_juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_witness_name"><?= $Page->juzmatch_authority_witness_name->caption() ?></span></td>
        <td data-name="juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_witness_name">
<span<?= $Page->juzmatch_authority_witness_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
    <tr id="r_juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_witness_lname"><?= $Page->juzmatch_authority_witness_lname->caption() ?></span></td>
        <td data-name="juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
    <tr id="r_juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_witness_email"><?= $Page->juzmatch_authority_witness_email->caption() ?></span></td>
        <td data-name="juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
    <tr id="r_juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority2_name"><?= $Page->juzmatch_authority2_name->caption() ?></span></td>
        <td data-name="juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority2_name">
<span<?= $Page->juzmatch_authority2_name->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
    <tr id="r_juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority2_lname"><?= $Page->juzmatch_authority2_lname->caption() ?></span></td>
        <td data-name="juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
    <tr id="r_juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_juzmatch_authority2_email"><?= $Page->juzmatch_authority2_email->caption() ?></span></td>
        <td data-name="juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
    <tr id="r_company_seal_name"<?= $Page->company_seal_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_company_seal_name"><?= $Page->company_seal_name->caption() ?></span></td>
        <td data-name="company_seal_name"<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
    <tr id="r_company_seal_email"<?= $Page->company_seal_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_company_seal_email"><?= $Page->company_seal_email->caption() ?></span></td>
        <td data-name="company_seal_email"<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->service_price->Visible) { // service_price ?>
    <tr id="r_service_price"<?= $Page->service_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_service_price"><?= $Page->service_price->caption() ?></span></td>
        <td data-name="service_price"<?= $Page->service_price->cellAttributes() ?>>
<span id="el_doc_juzmatch1_service_price">
<span<?= $Page->service_price->viewAttributes() ?>>
<?= $Page->service_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
    <tr id="r_service_price_txt"<?= $Page->service_price_txt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_service_price_txt"><?= $Page->service_price_txt->caption() ?></span></td>
        <td data-name="service_price_txt"<?= $Page->service_price_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch1_service_price_txt">
<span<?= $Page->service_price_txt->viewAttributes() ?>>
<?= $Page->service_price_txt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
    <tr id="r_first_down"<?= $Page->first_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_first_down"><?= $Page->first_down->caption() ?></span></td>
        <td data-name="first_down"<?= $Page->first_down->cellAttributes() ?>>
<span id="el_doc_juzmatch1_first_down">
<span<?= $Page->first_down->viewAttributes() ?>>
<?= $Page->first_down->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
    <tr id="r_first_down_txt"<?= $Page->first_down_txt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_first_down_txt"><?= $Page->first_down_txt->caption() ?></span></td>
        <td data-name="first_down_txt"<?= $Page->first_down_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch1_first_down_txt">
<span<?= $Page->first_down_txt->viewAttributes() ?>>
<?= $Page->first_down_txt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
    <tr id="r_second_down"<?= $Page->second_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_second_down"><?= $Page->second_down->caption() ?></span></td>
        <td data-name="second_down"<?= $Page->second_down->cellAttributes() ?>>
<span id="el_doc_juzmatch1_second_down">
<span<?= $Page->second_down->viewAttributes() ?>>
<?= $Page->second_down->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
    <tr id="r_second_down_txt"<?= $Page->second_down_txt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_second_down_txt"><?= $Page->second_down_txt->caption() ?></span></td>
        <td data-name="second_down_txt"<?= $Page->second_down_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch1_second_down_txt">
<span<?= $Page->second_down_txt->viewAttributes() ?>>
<?= $Page->second_down_txt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <tr id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_contact_address"><?= $Page->contact_address->caption() ?></span></td>
        <td data-name="contact_address"<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
    <tr id="r_contact_address2"<?= $Page->contact_address2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_contact_address2"><?= $Page->contact_address2->caption() ?></span></td>
        <td data-name="contact_address2"<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <tr id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_contact_email"><?= $Page->contact_email->caption() ?></span></td>
        <td data-name="contact_email"<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
    <tr id="r_contact_lineid"<?= $Page->contact_lineid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_contact_lineid"><?= $Page->contact_lineid->caption() ?></span></td>
        <td data-name="contact_lineid"<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
    <tr id="r_contact_phone"<?= $Page->contact_phone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_contact_phone"><?= $Page->contact_phone->caption() ?></span></td>
        <td data-name="contact_phone"<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_idcard->Visible) { // file_idcard ?>
    <tr id="r_file_idcard"<?= $Page->file_idcard->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_file_idcard"><?= $Page->file_idcard->caption() ?></span></td>
        <td data-name="file_idcard"<?= $Page->file_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_idcard">
<span<?= $Page->file_idcard->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_idcard, $Page->file_idcard->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_house_regis->Visible) { // file_house_regis ?>
    <tr id="r_file_house_regis"<?= $Page->file_house_regis->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_file_house_regis"><?= $Page->file_house_regis->caption() ?></span></td>
        <td data-name="file_house_regis"<?= $Page->file_house_regis->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_house_regis">
<span<?= $Page->file_house_regis->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_house_regis, $Page->file_house_regis->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_titledeed->Visible) { // file_titledeed ?>
    <tr id="r_file_titledeed"<?= $Page->file_titledeed->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_file_titledeed"><?= $Page->file_titledeed->caption() ?></span></td>
        <td data-name="file_titledeed"<?= $Page->file_titledeed->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_titledeed">
<span<?= $Page->file_titledeed->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_titledeed, $Page->file_titledeed->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_other->Visible) { // file_other ?>
    <tr id="r_file_other"<?= $Page->file_other->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_file_other"><?= $Page->file_other->caption() ?></span></td>
        <td data-name="file_other"<?= $Page->file_other->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_other">
<span<?= $Page->file_other->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_other, $Page->file_other->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_juzmatch1_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_juzmatch1_cdate">
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
