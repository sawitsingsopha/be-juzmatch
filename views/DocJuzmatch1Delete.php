<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch1Delete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch1: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch1delete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch1delete = new ew.Form("fdoc_juzmatch1delete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_juzmatch1delete;
    loadjs.done("fdoc_juzmatch1delete");
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
<form name="fdoc_juzmatch1delete" id="fdoc_juzmatch1delete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch1">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_doc_juzmatch1_id" class="doc_juzmatch1_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->document_date->Visible) { // document_date ?>
        <th class="<?= $Page->document_date->headerCellClass() ?>"><span id="elh_doc_juzmatch1_document_date" class="doc_juzmatch1_document_date"><?= $Page->document_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <th class="<?= $Page->juzmatch_authority_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_lname" class="doc_juzmatch1_juzmatch_authority_lname"><?= $Page->juzmatch_authority_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <th class="<?= $Page->juzmatch_authority_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_email" class="doc_juzmatch1_juzmatch_authority_email"><?= $Page->juzmatch_authority_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <th class="<?= $Page->juzmatch_authority_witness_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_witness_lname" class="doc_juzmatch1_juzmatch_authority_witness_lname"><?= $Page->juzmatch_authority_witness_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <th class="<?= $Page->juzmatch_authority_witness_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_juzmatch_authority_witness_email" class="doc_juzmatch1_juzmatch_authority_witness_email"><?= $Page->juzmatch_authority_witness_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <th class="<?= $Page->juzmatch_authority2_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch1_juzmatch_authority2_lname" class="doc_juzmatch1_juzmatch_authority2_lname"><?= $Page->juzmatch_authority2_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <th class="<?= $Page->juzmatch_authority2_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_juzmatch_authority2_email" class="doc_juzmatch1_juzmatch_authority2_email"><?= $Page->juzmatch_authority2_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <th class="<?= $Page->buyer_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch1_buyer_lname" class="doc_juzmatch1_buyer_lname"><?= $Page->buyer_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <th class="<?= $Page->buyer_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_buyer_email" class="doc_juzmatch1_buyer_email"><?= $Page->buyer_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <th class="<?= $Page->buyer_witness_lname->headerCellClass() ?>"><span id="elh_doc_juzmatch1_buyer_witness_lname" class="doc_juzmatch1_buyer_witness_lname"><?= $Page->buyer_witness_lname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <th class="<?= $Page->buyer_witness_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_buyer_witness_email" class="doc_juzmatch1_buyer_witness_email"><?= $Page->buyer_witness_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <th class="<?= $Page->buyer_idcard->headerCellClass() ?>"><span id="elh_doc_juzmatch1_buyer_idcard" class="doc_juzmatch1_buyer_idcard"><?= $Page->buyer_idcard->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <th class="<?= $Page->buyer_homeno->headerCellClass() ?>"><span id="elh_doc_juzmatch1_buyer_homeno" class="doc_juzmatch1_buyer_homeno"><?= $Page->buyer_homeno->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><span id="elh_doc_juzmatch1_total" class="doc_juzmatch1_total"><?= $Page->total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total_txt->Visible) { // total_txt ?>
        <th class="<?= $Page->total_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch1_total_txt" class="doc_juzmatch1_total_txt"><?= $Page->total_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
        <th class="<?= $Page->first_down->headerCellClass() ?>"><span id="elh_doc_juzmatch1_first_down" class="doc_juzmatch1_first_down"><?= $Page->first_down->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
        <th class="<?= $Page->first_down_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch1_first_down_txt" class="doc_juzmatch1_first_down_txt"><?= $Page->first_down_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
        <th class="<?= $Page->second_down->headerCellClass() ?>"><span id="elh_doc_juzmatch1_second_down" class="doc_juzmatch1_second_down"><?= $Page->second_down->caption() ?></span></th>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
        <th class="<?= $Page->second_down_txt->headerCellClass() ?>"><span id="elh_doc_juzmatch1_second_down_txt" class="doc_juzmatch1_second_down_txt"><?= $Page->second_down_txt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bank->Visible) { // bank ?>
        <th class="<?= $Page->bank->headerCellClass() ?>"><span id="elh_doc_juzmatch1_bank" class="doc_juzmatch1_bank"><?= $Page->bank->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bank_account_name->Visible) { // bank_account_name ?>
        <th class="<?= $Page->bank_account_name->headerCellClass() ?>"><span id="elh_doc_juzmatch1_bank_account_name" class="doc_juzmatch1_bank_account_name"><?= $Page->bank_account_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bank_account->Visible) { // bank_account ?>
        <th class="<?= $Page->bank_account->headerCellClass() ?>"><span id="elh_doc_juzmatch1_bank_account" class="doc_juzmatch1_bank_account"><?= $Page->bank_account->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th class="<?= $Page->contact_address->headerCellClass() ?>"><span id="elh_doc_juzmatch1_contact_address" class="doc_juzmatch1_contact_address"><?= $Page->contact_address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <th class="<?= $Page->contact_address2->headerCellClass() ?>"><span id="elh_doc_juzmatch1_contact_address2" class="doc_juzmatch1_contact_address2"><?= $Page->contact_address2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th class="<?= $Page->contact_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_contact_email" class="doc_juzmatch1_contact_email"><?= $Page->contact_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <th class="<?= $Page->contact_lineid->headerCellClass() ?>"><span id="elh_doc_juzmatch1_contact_lineid" class="doc_juzmatch1_contact_lineid"><?= $Page->contact_lineid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <th class="<?= $Page->contact_phone->headerCellClass() ?>"><span id="elh_doc_juzmatch1_contact_phone" class="doc_juzmatch1_contact_phone"><?= $Page->contact_phone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <th class="<?= $Page->attach_file->headerCellClass() ?>"><span id="elh_doc_juzmatch1_attach_file" class="doc_juzmatch1_attach_file"><?= $Page->attach_file->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_doc_juzmatch1_status" class="doc_juzmatch1_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <th class="<?= $Page->doc_creden_id->headerCellClass() ?>"><span id="elh_doc_juzmatch1_doc_creden_id" class="doc_juzmatch1_doc_creden_id"><?= $Page->doc_creden_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_doc_juzmatch1_cdate" class="doc_juzmatch1_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_doc_juzmatch1_cuser" class="doc_juzmatch1_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_doc_juzmatch1_cip" class="doc_juzmatch1_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_doc_juzmatch1_udate" class="doc_juzmatch1_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_doc_juzmatch1_uuser" class="doc_juzmatch1_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_doc_juzmatch1_uip" class="doc_juzmatch1_uip"><?= $Page->uip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <th class="<?= $Page->company_seal_name->headerCellClass() ?>"><span id="elh_doc_juzmatch1_company_seal_name" class="doc_juzmatch1_company_seal_name"><?= $Page->company_seal_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <th class="<?= $Page->company_seal_email->headerCellClass() ?>"><span id="elh_doc_juzmatch1_company_seal_email" class="doc_juzmatch1_company_seal_email"><?= $Page->company_seal_email->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_id" class="el_doc_juzmatch1_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->document_date->Visible) { // document_date ?>
        <td<?= $Page->document_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_document_date" class="el_doc_juzmatch1_document_date">
<span<?= $Page->document_date->viewAttributes() ?>>
<?= $Page->document_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
        <td<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_juzmatch_authority_lname" class="el_doc_juzmatch1_juzmatch_authority_lname">
<span<?= $Page->juzmatch_authority_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
        <td<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_juzmatch_authority_email" class="el_doc_juzmatch1_juzmatch_authority_email">
<span<?= $Page->juzmatch_authority_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
        <td<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_juzmatch_authority_witness_lname" class="el_doc_juzmatch1_juzmatch_authority_witness_lname">
<span<?= $Page->juzmatch_authority_witness_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
        <td<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_juzmatch_authority_witness_email" class="el_doc_juzmatch1_juzmatch_authority_witness_email">
<span<?= $Page->juzmatch_authority_witness_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority_witness_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
        <td<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_juzmatch_authority2_lname" class="el_doc_juzmatch1_juzmatch_authority2_lname">
<span<?= $Page->juzmatch_authority2_lname->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
        <td<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_juzmatch_authority2_email" class="el_doc_juzmatch1_juzmatch_authority2_email">
<span<?= $Page->juzmatch_authority2_email->viewAttributes() ?>>
<?= $Page->juzmatch_authority2_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
        <td<?= $Page->buyer_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_buyer_lname" class="el_doc_juzmatch1_buyer_lname">
<span<?= $Page->buyer_lname->viewAttributes() ?>>
<?= $Page->buyer_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
        <td<?= $Page->buyer_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_buyer_email" class="el_doc_juzmatch1_buyer_email">
<span<?= $Page->buyer_email->viewAttributes() ?>>
<?= $Page->buyer_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
        <td<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_buyer_witness_lname" class="el_doc_juzmatch1_buyer_witness_lname">
<span<?= $Page->buyer_witness_lname->viewAttributes() ?>>
<?= $Page->buyer_witness_lname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
        <td<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_buyer_witness_email" class="el_doc_juzmatch1_buyer_witness_email">
<span<?= $Page->buyer_witness_email->viewAttributes() ?>>
<?= $Page->buyer_witness_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
        <td<?= $Page->buyer_idcard->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_buyer_idcard" class="el_doc_juzmatch1_buyer_idcard">
<span<?= $Page->buyer_idcard->viewAttributes() ?>>
<?= $Page->buyer_idcard->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
        <td<?= $Page->buyer_homeno->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_buyer_homeno" class="el_doc_juzmatch1_buyer_homeno">
<span<?= $Page->buyer_homeno->viewAttributes() ?>>
<?= $Page->buyer_homeno->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <td<?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_total" class="el_doc_juzmatch1_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->total_txt->Visible) { // total_txt ?>
        <td<?= $Page->total_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_total_txt" class="el_doc_juzmatch1_total_txt">
<span<?= $Page->total_txt->viewAttributes() ?>>
<?= $Page->total_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_down->Visible) { // first_down ?>
        <td<?= $Page->first_down->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_first_down" class="el_doc_juzmatch1_first_down">
<span<?= $Page->first_down->viewAttributes() ?>>
<?= $Page->first_down->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
        <td<?= $Page->first_down_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_first_down_txt" class="el_doc_juzmatch1_first_down_txt">
<span<?= $Page->first_down_txt->viewAttributes() ?>>
<?= $Page->first_down_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->second_down->Visible) { // second_down ?>
        <td<?= $Page->second_down->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_second_down" class="el_doc_juzmatch1_second_down">
<span<?= $Page->second_down->viewAttributes() ?>>
<?= $Page->second_down->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
        <td<?= $Page->second_down_txt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_second_down_txt" class="el_doc_juzmatch1_second_down_txt">
<span<?= $Page->second_down_txt->viewAttributes() ?>>
<?= $Page->second_down_txt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bank->Visible) { // bank ?>
        <td<?= $Page->bank->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_bank" class="el_doc_juzmatch1_bank">
<span<?= $Page->bank->viewAttributes() ?>>
<?= $Page->bank->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bank_account_name->Visible) { // bank_account_name ?>
        <td<?= $Page->bank_account_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_bank_account_name" class="el_doc_juzmatch1_bank_account_name">
<span<?= $Page->bank_account_name->viewAttributes() ?>>
<?= $Page->bank_account_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bank_account->Visible) { // bank_account ?>
        <td<?= $Page->bank_account->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_bank_account" class="el_doc_juzmatch1_bank_account">
<span<?= $Page->bank_account->viewAttributes() ?>>
<?= $Page->bank_account->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_contact_address" class="el_doc_juzmatch1_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
        <td<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_contact_address2" class="el_doc_juzmatch1_contact_address2">
<span<?= $Page->contact_address2->viewAttributes() ?>>
<?= $Page->contact_address2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_contact_email" class="el_doc_juzmatch1_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
        <td<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_contact_lineid" class="el_doc_juzmatch1_contact_lineid">
<span<?= $Page->contact_lineid->viewAttributes() ?>>
<?= $Page->contact_lineid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
        <td<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_contact_phone" class="el_doc_juzmatch1_contact_phone">
<span<?= $Page->contact_phone->viewAttributes() ?>>
<?= $Page->contact_phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
        <td<?= $Page->attach_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_attach_file" class="el_doc_juzmatch1_attach_file">
<span<?= $Page->attach_file->viewAttributes() ?>>
<?= $Page->attach_file->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_status" class="el_doc_juzmatch1_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <td<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_doc_creden_id" class="el_doc_juzmatch1_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_cdate" class="el_doc_juzmatch1_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_cuser" class="el_doc_juzmatch1_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_cip" class="el_doc_juzmatch1_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_udate" class="el_doc_juzmatch1_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_uuser" class="el_doc_juzmatch1_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_uip" class="el_doc_juzmatch1_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
        <td<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_company_seal_name" class="el_doc_juzmatch1_company_seal_name">
<span<?= $Page->company_seal_name->viewAttributes() ?>>
<?= $Page->company_seal_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
        <td<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_juzmatch1_company_seal_email" class="el_doc_juzmatch1_company_seal_email">
<span<?= $Page->company_seal_email->viewAttributes() ?>>
<?= $Page->company_seal_email->getViewValue() ?></span>
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
