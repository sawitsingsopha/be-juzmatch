<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch3Delete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch3: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch3delete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch3delete = new ew.Form("fdoc_juzmatch3delete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_juzmatch3delete;
    loadjs.done("fdoc_juzmatch3delete");
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
<form name="fdoc_juzmatch3delete" id="fdoc_juzmatch3delete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch3">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_doc_juzmatch3_id" class="doc_juzmatch3_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->document_date->Visible) { // document_date ?>
        <th class="<?= $Page->document_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_document_date" class="doc_juzmatch3_document_date"><?= $Page->document_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <th class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch3_juzmatch_authority_lname" class="doc_juzmatch3_juzmatch_authority_lname"><?= $Page->juzmatch_authority_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <th class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_juzmatch_authority_email" class="doc_juzmatch3_juzmatch_authority_email"><?= $Page->juzmatch_authority_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <th class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch3_juzmatch_authority_witness_lname" class="doc_juzmatch3_juzmatch_authority_witness_lname"><?= $Page->juzmatch_authority_witness_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <th class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_juzmatch_authority_witness_email" class="doc_juzmatch3_juzmatch_authority_witness_email"><?= $Page->juzmatch_authority_witness_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <th class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch3_juzmatch_authority2_lname" class="doc_juzmatch3_juzmatch_authority2_lname"><?= $Page->juzmatch_authority2_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <th class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_juzmatch_authority2_email" class="doc_juzmatch3_juzmatch_authority2_email"><?= $Page->juzmatch_authority2_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <th class="<?= $Page->investor_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch3_investor_lname" class="doc_juzmatch3_investor_lname"><?= $Page->investor_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <th class="<?= $Page->buyer_witness_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_witness_lname" class="doc_juzmatch3_buyer_witness_lname"><?= $Page->buyer_witness_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <th class="<?= $Page->buyer_witness_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_witness_email" class="doc_juzmatch3_buyer_witness_email"><?= $Page->buyer_witness_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <th class="<?= $Page->buyer_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_email" class="doc_juzmatch3_buyer_email"><?= $Page->buyer_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_name->Visible) { // buyer_name ?>
        <th class="<?= $Page->buyer_name->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_name" class="doc_juzmatch3_buyer_name"><?= $Page->buyer_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <th class="<?= $Page->buyer_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_lname" class="doc_juzmatch3_buyer_lname"><?= $Page->buyer_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <th class="<?= $Page->buyer_idcard->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_idcard" class="doc_juzmatch3_buyer_idcard"><?= $Page->buyer_idcard->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <th class="<?= $Page->buyer_homeno->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_homeno" class="doc_juzmatch3_buyer_homeno"><?= $Page->buyer_homeno->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><span id="elh_doc_juzmatch3_total" class="doc_juzmatch3_total"><?= $Page->total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total_txt->Visible) { // total_txt ?>
        <th class="<?= $Page->total_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch3_total_txt" class="doc_juzmatch3_total_txt"><?= $Page->total_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
        <th class="<?= $Page->first_down->headerCellClass() ?>"><span id="elh_doc_juzmatch3_first_down" class="doc_juzmatch3_first_down"><?= $Page->first_down->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
        <th class="<?= $Page->first_down_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch3_first_down_txt" class="doc_juzmatch3_first_down_txt"><?= $Page->first_down_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
        <th class="<?= $Page->second_down->headerCellClass() ?>"><span id="elh_doc_juzmatch3_second_down" class="doc_juzmatch3_second_down"><?= $Page->second_down->caption() ?></span></th>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
        <th class="<?= $Page->second_down_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch3_second_down_txt" class="doc_juzmatch3_second_down_txt"><?= $Page->second_down_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th class="<?= $Page->contact_address->headerCellClass() ?>"><span id="elh_doc_juzmatch3_contact_address" class="doc_juzmatch3_contact_address"><?= $Page->contact_address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <th class="<?= $Page->contact_address2->headerCellClass() ?>"><span id="elh_doc_juzmatch3_contact_address2" class="doc_juzmatch3_contact_address2"><?= $Page->contact_address2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th class="<?= $Page->contact_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_contact_email" class="doc_juzmatch3_contact_email"><?= $Page->contact_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <th class="<?= $Page->contact_lineid->headerCellClass() ?>"><span id="elh_doc_juzmatch3_contact_lineid" class="doc_juzmatch3_contact_lineid"><?= $Page->contact_lineid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <th class="<?= $Page->contact_phone->headerCellClass() ?>"><span id="elh_doc_juzmatch3_contact_phone" class="doc_juzmatch3_contact_phone"><?= $Page->contact_phone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <th class="<?= $Page->attach_file->headerCellClass() ?>"><span id="elh_doc_juzmatch3_attach_file" class="doc_juzmatch3_attach_file"><?= $Page->attach_file->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_doc_juzmatch3_status" class="doc_juzmatch3_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <th class="<?= $Page->doc_creden_id->headerCellClass() ?>"><span id="elh_doc_juzmatch3_doc_creden_id" class="doc_juzmatch3_doc_creden_id"><?= $Page->doc_creden_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_doc_juzmatch3_cdate" class="doc_juzmatch3_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_doc_juzmatch3_cuser" class="doc_juzmatch3_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_doc_juzmatch3_cip" class="doc_juzmatch3_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_doc_juzmatch3_udate" class="doc_juzmatch3_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_doc_juzmatch3_uuser" class="doc_juzmatch3_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_doc_juzmatch3_uip" class="doc_juzmatch3_uip"><?= $Page->uip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <th class="<?= $Page->company_seal_name->headerCellClass() ?>"><span id="elh_doc_juzmatch3_company_seal_name" class="doc_juzmatch3_company_seal_name"><?= $Page->company_seal_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <th class="<?= $Page->company_seal_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_company_seal_email" class="doc_juzmatch3_company_seal_email"><?= $Page->company_seal_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><span id="elh_doc_juzmatch3_asset_code" class="doc_juzmatch3_asset_code"><?= $Page->asset_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <th class="<?= $Page->asset_project->headerCellClass() ?>"><span id="elh_doc_juzmatch3_asset_project" class="doc_juzmatch3_asset_project"><?= $Page->asset_project->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <th class="<?= $Page->asset_deed->headerCellClass() ?>"><span id="elh_doc_juzmatch3_asset_deed" class="doc_juzmatch3_asset_deed"><?= $Page->asset_deed->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <th class="<?= $Page->asset_area->headerCellClass() ?>"><span id="elh_doc_juzmatch3_asset_area" class="doc_juzmatch3_asset_area"><?= $Page->asset_area->caption() ?></span></th>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <th class="<?= $Page->start_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_start_date" class="doc_juzmatch3_start_date"><?= $Page->start_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <th class="<?= $Page->end_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_end_date" class="doc_juzmatch3_end_date"><?= $Page->end_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <th class="<?= $Page->appoint_agent_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_appoint_agent_date" class="doc_juzmatch3_appoint_agent_date"><?= $Page->appoint_agent_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->provide_service_date->Visible) { // provide_service_date ?>
        <th class="<?= $Page->provide_service_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_provide_service_date" class="doc_juzmatch3_provide_service_date"><?= $Page->provide_service_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->service_price->Visible) { // service_price ?>
        <th class="<?= $Page->service_price->headerCellClass() ?>"><span id="elh_doc_juzmatch3_service_price" class="doc_juzmatch3_service_price"><?= $Page->service_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
        <th class="<?= $Page->service_price_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch3_service_price_txt" class="doc_juzmatch3_service_price_txt"><?= $Page->service_price_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->years->Visible) { // years ?>
        <th class="<?= $Page->years->headerCellClass() ?>"><span id="elh_doc_juzmatch3_years" class="doc_juzmatch3_years"><?= $Page->years->caption() ?></span></th>
<?php } ?>
<?php if ($Page->next_pay_date->Visible) { // next_pay_date ?>
        <th class="<?= $Page->next_pay_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_next_pay_date" class="doc_juzmatch3_next_pay_date"><?= $Page->next_pay_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <th class="<?= $Page->next_pay_date_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch3_next_pay_date_txt" class="doc_juzmatch3_next_pay_date_txt"><?= $Page->next_pay_date_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_date->Visible) { // doc_date ?>
        <th class="<?= $Page->doc_date->headerCellClass() ?>"><span id="elh_doc_juzmatch3_doc_date" class="doc_juzmatch3_doc_date"><?= $Page->doc_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <th class="<?= $Page->investor_email->headerCellClass() ?>"><span id="elh_doc_juzmatch3_investor_email" class="doc_juzmatch3_investor_email"><?= $Page->investor_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_booking_asset_id->Visible) { // buyer_booking_asset_id ?>
        <th class="<?= $Page->buyer_booking_asset_id->headerCellClass() ?>"><span id="elh_doc_juzmatch3_buyer_booking_asset_id" class="doc_juzmatch3_buyer_booking_asset_id"><?= $Page->buyer_booking_asset_id->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_id" class="el_doc_juzmatch3_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->document_date->Visible) { // document_date ?>
        <td<?= $Page->document_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_document_date" class="el_doc_juzmatch3_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_lname" class="el_doc_juzmatch3_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_email" class="el_doc_juzmatch3_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_lname" class="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority_witness_email" class="el_doc_juzmatch3_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority2_lname" class="el_doc_juzmatch3_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_juzmatch_authority2_email" class="el_doc_juzmatch3_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
        <td<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_investor_lname" class="el_doc_juzmatch3_investor_lname">
<span<?= $Page->investor_lname->viewAttributes() ?>>
<?= $Page->investor_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <td<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_witness_lname" class="el_doc_juzmatch3_buyer_witness_lname">
<span<?= $Page->buyer_witness_lname->viewAttributes() ?>>
<?= $Page->buyer_witness_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <td<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_witness_email" class="el_doc_juzmatch3_buyer_witness_email">
<span<?= $Page->buyer_witness_email->viewAttributes() ?>>
<?= $Page->buyer_witness_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <td<?= $Page->buyer_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_email" class="el_doc_juzmatch3_buyer_email">
<span<?= $Page->buyer_email->viewAttributes() ?>>
<?= $Page->buyer_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_name->Visible) { // buyer_name ?>
        <td<?= $Page->buyer_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_name" class="el_doc_juzmatch3_buyer_name">
<span<?= $Page->buyer_name->viewAttributes() ?>>
<?= $Page->buyer_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <td<?= $Page->buyer_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_lname" class="el_doc_juzmatch3_buyer_lname">
<span<?= $Page->buyer_lname->viewAttributes() ?>>
<?= $Page->buyer_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <td<?= $Page->buyer_idcard->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_idcard" class="el_doc_juzmatch3_buyer_idcard">
<span<?= $Page->buyer_idcard->viewAttributes() ?>>
<?= $Page->buyer_idcard->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <td<?= $Page->buyer_homeno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_homeno" class="el_doc_juzmatch3_buyer_homeno">
<span<?= $Page->buyer_homeno->viewAttributes() ?>>
<?= $Page->buyer_homeno->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <td<?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_total" class="el_doc_juzmatch3_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->total_txt->Visible) { // total_txt ?>
        <td<?= $Page->total_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_total_txt" class="el_doc_juzmatch3_total_txt">
<span<?= $Page->total_txt->viewAttributes() ?>>
<?= $Page->total_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
        <td<?= $Page->first_down->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_first_down" class="el_doc_juzmatch3_first_down">
<span<?= $Page->first_down->viewAttributes() ?>>
<?= $Page->first_down->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
        <td<?= $Page->first_down_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_first_down_txt" class="el_doc_juzmatch3_first_down_txt">
<span<?= $Page->first_down_txt->viewAttributes() ?>>
<?= $Page->first_down_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
        <td<?= $Page->second_down->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_second_down" class="el_doc_juzmatch3_second_down">
<span<?= $Page->second_down->viewAttributes() ?>>
<?= $Page->second_down->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
        <td<?= $Page->second_down_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_second_down_txt" class="el_doc_juzmatch3_second_down_txt">
<span<?= $Page->second_down_txt->viewAttributes() ?>>
<?= $Page->second_down_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_address" class="el_doc_juzmatch3_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <td<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_address2" class="el_doc_juzmatch3_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_email" class="el_doc_juzmatch3_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <td<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_lineid" class="el_doc_juzmatch3_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <td<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_contact_phone" class="el_doc_juzmatch3_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <td<?= $Page->attach_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_attach_file" class="el_doc_juzmatch3_attach_file">
<span<?= $Page->attach_file->viewAttributes() ?>>
<?= $Page->attach_file->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_status" class="el_doc_juzmatch3_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <td<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_doc_creden_id" class="el_doc_juzmatch3_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_cdate" class="el_doc_juzmatch3_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_cuser" class="el_doc_juzmatch3_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_cip" class="el_doc_juzmatch3_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_udate" class="el_doc_juzmatch3_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_uuser" class="el_doc_juzmatch3_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_uip" class="el_doc_juzmatch3_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <td<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_company_seal_name" class="el_doc_juzmatch3_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <td<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_company_seal_email" class="el_doc_juzmatch3_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <td<?= $Page->asset_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_code" class="el_doc_juzmatch3_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
        <td<?= $Page->asset_project->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_project" class="el_doc_juzmatch3_asset_project">
<span<?= $Page->asset_project->viewAttributes() ?>>
<?= $Page->asset_project->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
        <td<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_deed" class="el_doc_juzmatch3_asset_deed">
<span<?= $Page->asset_deed->viewAttributes() ?>>
<?= $Page->asset_deed->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
        <td<?= $Page->asset_area->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_asset_area" class="el_doc_juzmatch3_asset_area">
<span<?= $Page->asset_area->viewAttributes() ?>>
<?= $Page->asset_area->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
        <td<?= $Page->start_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_start_date" class="el_doc_juzmatch3_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
        <td<?= $Page->end_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_end_date" class="el_doc_juzmatch3_end_date">
<span<?= $Page->end_date->viewAttributes() ?>>
<?= $Page->end_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->appoint_agent_date->Visible) { // appoint_agent_date ?>
        <td<?= $Page->appoint_agent_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_appoint_agent_date" class="el_doc_juzmatch3_appoint_agent_date">
<span<?= $Page->appoint_agent_date->viewAttributes() ?>>
<?= $Page->appoint_agent_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->provide_service_date->Visible) { // provide_service_date ?>
        <td<?= $Page->provide_service_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_provide_service_date" class="el_doc_juzmatch3_provide_service_date">
<span<?= $Page->provide_service_date->viewAttributes() ?>>
<?= $Page->provide_service_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->service_price->Visible) { // service_price ?>
        <td<?= $Page->service_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_service_price" class="el_doc_juzmatch3_service_price">
<span<?= $Page->service_price->viewAttributes() ?>>
<?= $Page->service_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
        <td<?= $Page->service_price_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_service_price_txt" class="el_doc_juzmatch3_service_price_txt">
<span<?= $Page->service_price_txt->viewAttributes() ?>>
<?= $Page->service_price_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->years->Visible) { // years ?>
        <td<?= $Page->years->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_years" class="el_doc_juzmatch3_years">
<span<?= $Page->years->viewAttributes() ?>>
<?= $Page->years->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->next_pay_date->Visible) { // next_pay_date ?>
        <td<?= $Page->next_pay_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_next_pay_date" class="el_doc_juzmatch3_next_pay_date">
<span<?= $Page->next_pay_date->viewAttributes() ?>>
<?= $Page->next_pay_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
        <td<?= $Page->next_pay_date_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_next_pay_date_txt" class="el_doc_juzmatch3_next_pay_date_txt">
<span<?= $Page->next_pay_date_txt->viewAttributes() ?>>
<?= $Page->next_pay_date_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_date->Visible) { // doc_date ?>
        <td<?= $Page->doc_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_doc_date" class="el_doc_juzmatch3_doc_date">
<span<?= $Page->doc_date->viewAttributes() ?>>
<?= $Page->doc_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
        <td<?= $Page->investor_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_investor_email" class="el_doc_juzmatch3_investor_email">
<span<?= $Page->investor_email->viewAttributes() ?>>
<?= $Page->investor_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_booking_asset_id->Visible) { // buyer_booking_asset_id ?>
        <td<?= $Page->buyer_booking_asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch3_buyer_booking_asset_id" class="el_doc_juzmatch3_buyer_booking_asset_id">
<span<?= $Page->buyer_booking_asset_id->viewAttributes() ?>>
<?= $Page->buyer_booking_asset_id->getViewValue() ?></span>
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
