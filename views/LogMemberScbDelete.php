<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogMemberScbDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_member_scb: currentTable } });
var currentForm, currentPageID;
var flog_member_scbdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_member_scbdelete = new ew.Form("flog_member_scbdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = flog_member_scbdelete;
    loadjs.done("flog_member_scbdelete");
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
<form name="flog_member_scbdelete" id="flog_member_scbdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_member_scb">
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
<?php if ($Page->log_member_scb_id->Visible) { // log_member_scb_id ?>
        <th class="<?= $Page->log_member_scb_id->headerCellClass() ?>"><span id="elh_log_member_scb_log_member_scb_id" class="log_member_scb_log_member_scb_id"><?= $Page->log_member_scb_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->reference_id->Visible) { // reference_id ?>
        <th class="<?= $Page->reference_id->headerCellClass() ?>"><span id="elh_log_member_scb_reference_id" class="log_member_scb_reference_id"><?= $Page->reference_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th class="<?= $Page->member_id->headerCellClass() ?>"><span id="elh_log_member_scb_member_id" class="log_member_scb_member_id"><?= $Page->member_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_log_member_scb_cdate" class="log_member_scb_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_log_member_scb_cuser" class="log_member_scb_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_log_member_scb_cip" class="log_member_scb_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_log_member_scb_status" class="log_member_scb_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><span id="elh_log_member_scb_asset_id" class="log_member_scb_asset_id"><?= $Page->asset_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->decision_status->Visible) { // decision_status ?>
        <th class="<?= $Page->decision_status->headerCellClass() ?>"><span id="elh_log_member_scb_decision_status" class="log_member_scb_decision_status"><?= $Page->decision_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->decision_timestamp->Visible) { // decision_timestamp ?>
        <th class="<?= $Page->decision_timestamp->headerCellClass() ?>"><span id="elh_log_member_scb_decision_timestamp" class="log_member_scb_decision_timestamp"><?= $Page->decision_timestamp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deposit_amount->Visible) { // deposit_amount ?>
        <th class="<?= $Page->deposit_amount->headerCellClass() ?>"><span id="elh_log_member_scb_deposit_amount" class="log_member_scb_deposit_amount"><?= $Page->deposit_amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <th class="<?= $Page->due_date->headerCellClass() ?>"><span id="elh_log_member_scb_due_date" class="log_member_scb_due_date"><?= $Page->due_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rental_fee->Visible) { // rental_fee ?>
        <th class="<?= $Page->rental_fee->headerCellClass() ?>"><span id="elh_log_member_scb_rental_fee" class="log_member_scb_rental_fee"><?= $Page->rental_fee->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fullName->Visible) { // fullName ?>
        <th class="<?= $Page->fullName->headerCellClass() ?>"><span id="elh_log_member_scb_fullName" class="log_member_scb_fullName"><?= $Page->fullName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->age->Visible) { // age ?>
        <th class="<?= $Page->age->headerCellClass() ?>"><span id="elh_log_member_scb_age" class="log_member_scb_age"><?= $Page->age->caption() ?></span></th>
<?php } ?>
<?php if ($Page->maritalStatus->Visible) { // maritalStatus ?>
        <th class="<?= $Page->maritalStatus->headerCellClass() ?>"><span id="elh_log_member_scb_maritalStatus" class="log_member_scb_maritalStatus"><?= $Page->maritalStatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->noOfChildren->Visible) { // noOfChildren ?>
        <th class="<?= $Page->noOfChildren->headerCellClass() ?>"><span id="elh_log_member_scb_noOfChildren" class="log_member_scb_noOfChildren"><?= $Page->noOfChildren->caption() ?></span></th>
<?php } ?>
<?php if ($Page->educationLevel->Visible) { // educationLevel ?>
        <th class="<?= $Page->educationLevel->headerCellClass() ?>"><span id="elh_log_member_scb_educationLevel" class="log_member_scb_educationLevel"><?= $Page->educationLevel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->workplace->Visible) { // workplace ?>
        <th class="<?= $Page->workplace->headerCellClass() ?>"><span id="elh_log_member_scb_workplace" class="log_member_scb_workplace"><?= $Page->workplace->caption() ?></span></th>
<?php } ?>
<?php if ($Page->occupation->Visible) { // occupation ?>
        <th class="<?= $Page->occupation->headerCellClass() ?>"><span id="elh_log_member_scb_occupation" class="log_member_scb_occupation"><?= $Page->occupation->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jobPosition->Visible) { // jobPosition ?>
        <th class="<?= $Page->jobPosition->headerCellClass() ?>"><span id="elh_log_member_scb_jobPosition" class="log_member_scb_jobPosition"><?= $Page->jobPosition->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submissionDate->Visible) { // submissionDate ?>
        <th class="<?= $Page->submissionDate->headerCellClass() ?>"><span id="elh_log_member_scb_submissionDate" class="log_member_scb_submissionDate"><?= $Page->submissionDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bankruptcy_tendency->Visible) { // bankruptcy_tendency ?>
        <th class="<?= $Page->bankruptcy_tendency->headerCellClass() ?>"><span id="elh_log_member_scb_bankruptcy_tendency" class="log_member_scb_bankruptcy_tendency"><?= $Page->bankruptcy_tendency->caption() ?></span></th>
<?php } ?>
<?php if ($Page->blacklist_tendency->Visible) { // blacklist_tendency ?>
        <th class="<?= $Page->blacklist_tendency->headerCellClass() ?>"><span id="elh_log_member_scb_blacklist_tendency" class="log_member_scb_blacklist_tendency"><?= $Page->blacklist_tendency->caption() ?></span></th>
<?php } ?>
<?php if ($Page->money_laundering_tendency->Visible) { // money_laundering_tendency ?>
        <th class="<?= $Page->money_laundering_tendency->headerCellClass() ?>"><span id="elh_log_member_scb_money_laundering_tendency" class="log_member_scb_money_laundering_tendency"><?= $Page->money_laundering_tendency->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mobile_fraud_behavior->Visible) { // mobile_fraud_behavior ?>
        <th class="<?= $Page->mobile_fraud_behavior->headerCellClass() ?>"><span id="elh_log_member_scb_mobile_fraud_behavior" class="log_member_scb_mobile_fraud_behavior"><?= $Page->mobile_fraud_behavior->caption() ?></span></th>
<?php } ?>
<?php if ($Page->face_similarity_score->Visible) { // face_similarity_score ?>
        <th class="<?= $Page->face_similarity_score->headerCellClass() ?>"><span id="elh_log_member_scb_face_similarity_score" class="log_member_scb_face_similarity_score"><?= $Page->face_similarity_score->caption() ?></span></th>
<?php } ?>
<?php if ($Page->identification_verification_matched_flag->Visible) { // identification_verification_matched_flag ?>
        <th class="<?= $Page->identification_verification_matched_flag->headerCellClass() ?>"><span id="elh_log_member_scb_identification_verification_matched_flag" class="log_member_scb_identification_verification_matched_flag"><?= $Page->identification_verification_matched_flag->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bankstatement_confident_score->Visible) { // bankstatement_confident_score ?>
        <th class="<?= $Page->bankstatement_confident_score->headerCellClass() ?>"><span id="elh_log_member_scb_bankstatement_confident_score" class="log_member_scb_bankstatement_confident_score"><?= $Page->bankstatement_confident_score->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estimated_monthly_income->Visible) { // estimated_monthly_income ?>
        <th class="<?= $Page->estimated_monthly_income->headerCellClass() ?>"><span id="elh_log_member_scb_estimated_monthly_income" class="log_member_scb_estimated_monthly_income"><?= $Page->estimated_monthly_income->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estimated_monthly_debt->Visible) { // estimated_monthly_debt ?>
        <th class="<?= $Page->estimated_monthly_debt->headerCellClass() ?>"><span id="elh_log_member_scb_estimated_monthly_debt" class="log_member_scb_estimated_monthly_debt"><?= $Page->estimated_monthly_debt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->income_stability->Visible) { // income_stability ?>
        <th class="<?= $Page->income_stability->headerCellClass() ?>"><span id="elh_log_member_scb_income_stability" class="log_member_scb_income_stability"><?= $Page->income_stability->caption() ?></span></th>
<?php } ?>
<?php if ($Page->customer_grade->Visible) { // customer_grade ?>
        <th class="<?= $Page->customer_grade->headerCellClass() ?>"><span id="elh_log_member_scb_customer_grade" class="log_member_scb_customer_grade"><?= $Page->customer_grade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->color_sign->Visible) { // color_sign ?>
        <th class="<?= $Page->color_sign->headerCellClass() ?>"><span id="elh_log_member_scb_color_sign" class="log_member_scb_color_sign"><?= $Page->color_sign->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rental_period->Visible) { // rental_period ?>
        <th class="<?= $Page->rental_period->headerCellClass() ?>"><span id="elh_log_member_scb_rental_period" class="log_member_scb_rental_period"><?= $Page->rental_period->caption() ?></span></th>
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
<?php if ($Page->log_member_scb_id->Visible) { // log_member_scb_id ?>
        <td<?= $Page->log_member_scb_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_log_member_scb_id" class="el_log_member_scb_log_member_scb_id">
<span<?= $Page->log_member_scb_id->viewAttributes() ?>>
<?= $Page->log_member_scb_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->reference_id->Visible) { // reference_id ?>
        <td<?= $Page->reference_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_reference_id" class="el_log_member_scb_reference_id">
<span<?= $Page->reference_id->viewAttributes() ?>>
<?= $Page->reference_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <td<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_member_id" class="el_log_member_scb_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_cdate" class="el_log_member_scb_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_cuser" class="el_log_member_scb_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_cip" class="el_log_member_scb_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_status" class="el_log_member_scb_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_asset_id" class="el_log_member_scb_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->decision_status->Visible) { // decision_status ?>
        <td<?= $Page->decision_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_decision_status" class="el_log_member_scb_decision_status">
<span<?= $Page->decision_status->viewAttributes() ?>>
<?= $Page->decision_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->decision_timestamp->Visible) { // decision_timestamp ?>
        <td<?= $Page->decision_timestamp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_decision_timestamp" class="el_log_member_scb_decision_timestamp">
<span<?= $Page->decision_timestamp->viewAttributes() ?>>
<?= $Page->decision_timestamp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deposit_amount->Visible) { // deposit_amount ?>
        <td<?= $Page->deposit_amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_deposit_amount" class="el_log_member_scb_deposit_amount">
<span<?= $Page->deposit_amount->viewAttributes() ?>>
<?= $Page->deposit_amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <td<?= $Page->due_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_due_date" class="el_log_member_scb_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rental_fee->Visible) { // rental_fee ?>
        <td<?= $Page->rental_fee->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_rental_fee" class="el_log_member_scb_rental_fee">
<span<?= $Page->rental_fee->viewAttributes() ?>>
<?= $Page->rental_fee->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fullName->Visible) { // fullName ?>
        <td<?= $Page->fullName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_fullName" class="el_log_member_scb_fullName">
<span<?= $Page->fullName->viewAttributes() ?>>
<?= $Page->fullName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->age->Visible) { // age ?>
        <td<?= $Page->age->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_age" class="el_log_member_scb_age">
<span<?= $Page->age->viewAttributes() ?>>
<?= $Page->age->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->maritalStatus->Visible) { // maritalStatus ?>
        <td<?= $Page->maritalStatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_maritalStatus" class="el_log_member_scb_maritalStatus">
<span<?= $Page->maritalStatus->viewAttributes() ?>>
<?= $Page->maritalStatus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->noOfChildren->Visible) { // noOfChildren ?>
        <td<?= $Page->noOfChildren->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_noOfChildren" class="el_log_member_scb_noOfChildren">
<span<?= $Page->noOfChildren->viewAttributes() ?>>
<?= $Page->noOfChildren->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->educationLevel->Visible) { // educationLevel ?>
        <td<?= $Page->educationLevel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_educationLevel" class="el_log_member_scb_educationLevel">
<span<?= $Page->educationLevel->viewAttributes() ?>>
<?= $Page->educationLevel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->workplace->Visible) { // workplace ?>
        <td<?= $Page->workplace->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_workplace" class="el_log_member_scb_workplace">
<span<?= $Page->workplace->viewAttributes() ?>>
<?= $Page->workplace->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->occupation->Visible) { // occupation ?>
        <td<?= $Page->occupation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_occupation" class="el_log_member_scb_occupation">
<span<?= $Page->occupation->viewAttributes() ?>>
<?= $Page->occupation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jobPosition->Visible) { // jobPosition ?>
        <td<?= $Page->jobPosition->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_jobPosition" class="el_log_member_scb_jobPosition">
<span<?= $Page->jobPosition->viewAttributes() ?>>
<?= $Page->jobPosition->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->submissionDate->Visible) { // submissionDate ?>
        <td<?= $Page->submissionDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_submissionDate" class="el_log_member_scb_submissionDate">
<span<?= $Page->submissionDate->viewAttributes() ?>>
<?= $Page->submissionDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bankruptcy_tendency->Visible) { // bankruptcy_tendency ?>
        <td<?= $Page->bankruptcy_tendency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_bankruptcy_tendency" class="el_log_member_scb_bankruptcy_tendency">
<span<?= $Page->bankruptcy_tendency->viewAttributes() ?>>
<?= $Page->bankruptcy_tendency->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->blacklist_tendency->Visible) { // blacklist_tendency ?>
        <td<?= $Page->blacklist_tendency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_blacklist_tendency" class="el_log_member_scb_blacklist_tendency">
<span<?= $Page->blacklist_tendency->viewAttributes() ?>>
<?= $Page->blacklist_tendency->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->money_laundering_tendency->Visible) { // money_laundering_tendency ?>
        <td<?= $Page->money_laundering_tendency->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_money_laundering_tendency" class="el_log_member_scb_money_laundering_tendency">
<span<?= $Page->money_laundering_tendency->viewAttributes() ?>>
<?= $Page->money_laundering_tendency->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mobile_fraud_behavior->Visible) { // mobile_fraud_behavior ?>
        <td<?= $Page->mobile_fraud_behavior->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_mobile_fraud_behavior" class="el_log_member_scb_mobile_fraud_behavior">
<span<?= $Page->mobile_fraud_behavior->viewAttributes() ?>>
<?= $Page->mobile_fraud_behavior->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->face_similarity_score->Visible) { // face_similarity_score ?>
        <td<?= $Page->face_similarity_score->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_face_similarity_score" class="el_log_member_scb_face_similarity_score">
<span<?= $Page->face_similarity_score->viewAttributes() ?>>
<?= $Page->face_similarity_score->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->identification_verification_matched_flag->Visible) { // identification_verification_matched_flag ?>
        <td<?= $Page->identification_verification_matched_flag->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_identification_verification_matched_flag" class="el_log_member_scb_identification_verification_matched_flag">
<span<?= $Page->identification_verification_matched_flag->viewAttributes() ?>>
<?= $Page->identification_verification_matched_flag->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bankstatement_confident_score->Visible) { // bankstatement_confident_score ?>
        <td<?= $Page->bankstatement_confident_score->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_bankstatement_confident_score" class="el_log_member_scb_bankstatement_confident_score">
<span<?= $Page->bankstatement_confident_score->viewAttributes() ?>>
<?= $Page->bankstatement_confident_score->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estimated_monthly_income->Visible) { // estimated_monthly_income ?>
        <td<?= $Page->estimated_monthly_income->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_estimated_monthly_income" class="el_log_member_scb_estimated_monthly_income">
<span<?= $Page->estimated_monthly_income->viewAttributes() ?>>
<?= $Page->estimated_monthly_income->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estimated_monthly_debt->Visible) { // estimated_monthly_debt ?>
        <td<?= $Page->estimated_monthly_debt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_estimated_monthly_debt" class="el_log_member_scb_estimated_monthly_debt">
<span<?= $Page->estimated_monthly_debt->viewAttributes() ?>>
<?= $Page->estimated_monthly_debt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->income_stability->Visible) { // income_stability ?>
        <td<?= $Page->income_stability->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_income_stability" class="el_log_member_scb_income_stability">
<span<?= $Page->income_stability->viewAttributes() ?>>
<?= $Page->income_stability->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->customer_grade->Visible) { // customer_grade ?>
        <td<?= $Page->customer_grade->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_customer_grade" class="el_log_member_scb_customer_grade">
<span<?= $Page->customer_grade->viewAttributes() ?>>
<?= $Page->customer_grade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->color_sign->Visible) { // color_sign ?>
        <td<?= $Page->color_sign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_color_sign" class="el_log_member_scb_color_sign">
<span<?= $Page->color_sign->viewAttributes() ?>>
<?= $Page->color_sign->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rental_period->Visible) { // rental_period ?>
        <td<?= $Page->rental_period->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_member_scb_rental_period" class="el_log_member_scb_rental_period">
<span<?= $Page->rental_period->viewAttributes() ?>>
<?= $Page->rental_period->getViewValue() ?></span>
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
