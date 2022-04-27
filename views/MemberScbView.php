<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberScbView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member_scb: currentTable } });
var currentForm, currentPageID;
var fmember_scbview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmember_scbview = new ew.Form("fmember_scbview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fmember_scbview;
    loadjs.done("fmember_scbview");
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
<form name="fmember_scbview" id="fmember_scbview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member_scb">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_member_scb_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <tr id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_asset_id"><?= $Page->asset_id->caption() ?></span></td>
        <td data-name="asset_id"<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_member_scb_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reference_id->Visible) { // reference_id ?>
    <tr id="r_reference_id"<?= $Page->reference_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_reference_id"><?= $Page->reference_id->caption() ?></span></td>
        <td data-name="reference_id"<?= $Page->reference_id->cellAttributes() ?>>
<span id="el_member_scb_reference_id">
<span<?= $Page->reference_id->viewAttributes() ?>>
<?= $Page->reference_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reference_url->Visible) { // reference_url ?>
    <tr id="r_reference_url"<?= $Page->reference_url->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_reference_url"><?= $Page->reference_url->caption() ?></span></td>
        <td data-name="reference_url"<?= $Page->reference_url->cellAttributes() ?>>
<span id="el_member_scb_reference_url">
<span<?= $Page->reference_url->viewAttributes() ?>>
<?= $Page->reference_url->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->refreshtoken->Visible) { // refreshtoken ?>
    <tr id="r_refreshtoken"<?= $Page->refreshtoken->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_refreshtoken"><?= $Page->refreshtoken->caption() ?></span></td>
        <td data-name="refreshtoken"<?= $Page->refreshtoken->cellAttributes() ?>>
<span id="el_member_scb_refreshtoken">
<span<?= $Page->refreshtoken->viewAttributes() ?>>
<?= $Page->refreshtoken->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->auth_code->Visible) { // auth_code ?>
    <tr id="r_auth_code"<?= $Page->auth_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_auth_code"><?= $Page->auth_code->caption() ?></span></td>
        <td data-name="auth_code"<?= $Page->auth_code->cellAttributes() ?>>
<span id="el_member_scb_auth_code">
<span<?= $Page->auth_code->viewAttributes() ?>>
<?= $Page->auth_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
    <tr id="r__token"<?= $Page->_token->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb__token"><?= $Page->_token->caption() ?></span></td>
        <td data-name="_token"<?= $Page->_token->cellAttributes() ?>>
<span id="el_member_scb__token">
<span<?= $Page->_token->viewAttributes() ?>>
<?= $Page->_token->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <tr id="r_state"<?= $Page->state->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_state"><?= $Page->state->caption() ?></span></td>
        <td data-name="state"<?= $Page->state->cellAttributes() ?>>
<span id="el_member_scb_state">
<span<?= $Page->state->viewAttributes() ?>>
<?= $Page->state->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_member_scb_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->at_expire_in->Visible) { // at_expire_in ?>
    <tr id="r_at_expire_in"<?= $Page->at_expire_in->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_at_expire_in"><?= $Page->at_expire_in->caption() ?></span></td>
        <td data-name="at_expire_in"<?= $Page->at_expire_in->cellAttributes() ?>>
<span id="el_member_scb_at_expire_in">
<span<?= $Page->at_expire_in->viewAttributes() ?>>
<?= $Page->at_expire_in->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rt_expire_in->Visible) { // rt_expire_in ?>
    <tr id="r_rt_expire_in"<?= $Page->rt_expire_in->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_rt_expire_in"><?= $Page->rt_expire_in->caption() ?></span></td>
        <td data-name="rt_expire_in"<?= $Page->rt_expire_in->cellAttributes() ?>>
<span id="el_member_scb_rt_expire_in">
<span<?= $Page->rt_expire_in->viewAttributes() ?>>
<?= $Page->rt_expire_in->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->decision_status->Visible) { // decision_status ?>
    <tr id="r_decision_status"<?= $Page->decision_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_decision_status"><?= $Page->decision_status->caption() ?></span></td>
        <td data-name="decision_status"<?= $Page->decision_status->cellAttributes() ?>>
<span id="el_member_scb_decision_status">
<span<?= $Page->decision_status->viewAttributes() ?>>
<?= $Page->decision_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->decision_timestamp->Visible) { // decision_timestamp ?>
    <tr id="r_decision_timestamp"<?= $Page->decision_timestamp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_decision_timestamp"><?= $Page->decision_timestamp->caption() ?></span></td>
        <td data-name="decision_timestamp"<?= $Page->decision_timestamp->cellAttributes() ?>>
<span id="el_member_scb_decision_timestamp">
<span<?= $Page->decision_timestamp->viewAttributes() ?>>
<?= $Page->decision_timestamp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deposit_amount->Visible) { // deposit_amount ?>
    <tr id="r_deposit_amount"<?= $Page->deposit_amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_deposit_amount"><?= $Page->deposit_amount->caption() ?></span></td>
        <td data-name="deposit_amount"<?= $Page->deposit_amount->cellAttributes() ?>>
<span id="el_member_scb_deposit_amount">
<span<?= $Page->deposit_amount->viewAttributes() ?>>
<?= $Page->deposit_amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <tr id="r_due_date"<?= $Page->due_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_due_date"><?= $Page->due_date->caption() ?></span></td>
        <td data-name="due_date"<?= $Page->due_date->cellAttributes() ?>>
<span id="el_member_scb_due_date">
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rental_fee->Visible) { // rental_fee ?>
    <tr id="r_rental_fee"<?= $Page->rental_fee->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_rental_fee"><?= $Page->rental_fee->caption() ?></span></td>
        <td data-name="rental_fee"<?= $Page->rental_fee->cellAttributes() ?>>
<span id="el_member_scb_rental_fee">
<span<?= $Page->rental_fee->viewAttributes() ?>>
<?= $Page->rental_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_member_scb_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fullName->Visible) { // fullName ?>
    <tr id="r_fullName"<?= $Page->fullName->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_fullName"><?= $Page->fullName->caption() ?></span></td>
        <td data-name="fullName"<?= $Page->fullName->cellAttributes() ?>>
<span id="el_member_scb_fullName">
<span<?= $Page->fullName->viewAttributes() ?>>
<?= $Page->fullName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->age->Visible) { // age ?>
    <tr id="r_age"<?= $Page->age->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_age"><?= $Page->age->caption() ?></span></td>
        <td data-name="age"<?= $Page->age->cellAttributes() ?>>
<span id="el_member_scb_age">
<span<?= $Page->age->viewAttributes() ?>>
<?= $Page->age->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->maritalStatus->Visible) { // maritalStatus ?>
    <tr id="r_maritalStatus"<?= $Page->maritalStatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_maritalStatus"><?= $Page->maritalStatus->caption() ?></span></td>
        <td data-name="maritalStatus"<?= $Page->maritalStatus->cellAttributes() ?>>
<span id="el_member_scb_maritalStatus">
<span<?= $Page->maritalStatus->viewAttributes() ?>>
<?= $Page->maritalStatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->noOfChildren->Visible) { // noOfChildren ?>
    <tr id="r_noOfChildren"<?= $Page->noOfChildren->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_noOfChildren"><?= $Page->noOfChildren->caption() ?></span></td>
        <td data-name="noOfChildren"<?= $Page->noOfChildren->cellAttributes() ?>>
<span id="el_member_scb_noOfChildren">
<span<?= $Page->noOfChildren->viewAttributes() ?>>
<?= $Page->noOfChildren->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->educationLevel->Visible) { // educationLevel ?>
    <tr id="r_educationLevel"<?= $Page->educationLevel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_educationLevel"><?= $Page->educationLevel->caption() ?></span></td>
        <td data-name="educationLevel"<?= $Page->educationLevel->cellAttributes() ?>>
<span id="el_member_scb_educationLevel">
<span<?= $Page->educationLevel->viewAttributes() ?>>
<?= $Page->educationLevel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->workplace->Visible) { // workplace ?>
    <tr id="r_workplace"<?= $Page->workplace->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_workplace"><?= $Page->workplace->caption() ?></span></td>
        <td data-name="workplace"<?= $Page->workplace->cellAttributes() ?>>
<span id="el_member_scb_workplace">
<span<?= $Page->workplace->viewAttributes() ?>>
<?= $Page->workplace->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->occupation->Visible) { // occupation ?>
    <tr id="r_occupation"<?= $Page->occupation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_occupation"><?= $Page->occupation->caption() ?></span></td>
        <td data-name="occupation"<?= $Page->occupation->cellAttributes() ?>>
<span id="el_member_scb_occupation">
<span<?= $Page->occupation->viewAttributes() ?>>
<?= $Page->occupation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jobPosition->Visible) { // jobPosition ?>
    <tr id="r_jobPosition"<?= $Page->jobPosition->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_jobPosition"><?= $Page->jobPosition->caption() ?></span></td>
        <td data-name="jobPosition"<?= $Page->jobPosition->cellAttributes() ?>>
<span id="el_member_scb_jobPosition">
<span<?= $Page->jobPosition->viewAttributes() ?>>
<?= $Page->jobPosition->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->submissionDate->Visible) { // submissionDate ?>
    <tr id="r_submissionDate"<?= $Page->submissionDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_submissionDate"><?= $Page->submissionDate->caption() ?></span></td>
        <td data-name="submissionDate"<?= $Page->submissionDate->cellAttributes() ?>>
<span id="el_member_scb_submissionDate">
<span<?= $Page->submissionDate->viewAttributes() ?>>
<?= $Page->submissionDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bankruptcy_tendency->Visible) { // bankruptcy_tendency ?>
    <tr id="r_bankruptcy_tendency"<?= $Page->bankruptcy_tendency->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_bankruptcy_tendency"><?= $Page->bankruptcy_tendency->caption() ?></span></td>
        <td data-name="bankruptcy_tendency"<?= $Page->bankruptcy_tendency->cellAttributes() ?>>
<span id="el_member_scb_bankruptcy_tendency">
<span<?= $Page->bankruptcy_tendency->viewAttributes() ?>>
<?= $Page->bankruptcy_tendency->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->blacklist_tendency->Visible) { // blacklist_tendency ?>
    <tr id="r_blacklist_tendency"<?= $Page->blacklist_tendency->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_blacklist_tendency"><?= $Page->blacklist_tendency->caption() ?></span></td>
        <td data-name="blacklist_tendency"<?= $Page->blacklist_tendency->cellAttributes() ?>>
<span id="el_member_scb_blacklist_tendency">
<span<?= $Page->blacklist_tendency->viewAttributes() ?>>
<?= $Page->blacklist_tendency->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->money_laundering_tendency->Visible) { // money_laundering_tendency ?>
    <tr id="r_money_laundering_tendency"<?= $Page->money_laundering_tendency->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_money_laundering_tendency"><?= $Page->money_laundering_tendency->caption() ?></span></td>
        <td data-name="money_laundering_tendency"<?= $Page->money_laundering_tendency->cellAttributes() ?>>
<span id="el_member_scb_money_laundering_tendency">
<span<?= $Page->money_laundering_tendency->viewAttributes() ?>>
<?= $Page->money_laundering_tendency->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mobile_fraud_behavior->Visible) { // mobile_fraud_behavior ?>
    <tr id="r_mobile_fraud_behavior"<?= $Page->mobile_fraud_behavior->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_mobile_fraud_behavior"><?= $Page->mobile_fraud_behavior->caption() ?></span></td>
        <td data-name="mobile_fraud_behavior"<?= $Page->mobile_fraud_behavior->cellAttributes() ?>>
<span id="el_member_scb_mobile_fraud_behavior">
<span<?= $Page->mobile_fraud_behavior->viewAttributes() ?>>
<?= $Page->mobile_fraud_behavior->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->face_similarity_score->Visible) { // face_similarity_score ?>
    <tr id="r_face_similarity_score"<?= $Page->face_similarity_score->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_face_similarity_score"><?= $Page->face_similarity_score->caption() ?></span></td>
        <td data-name="face_similarity_score"<?= $Page->face_similarity_score->cellAttributes() ?>>
<span id="el_member_scb_face_similarity_score">
<span<?= $Page->face_similarity_score->viewAttributes() ?>>
<?= $Page->face_similarity_score->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->identification_verification_matched_flag->Visible) { // identification_verification_matched_flag ?>
    <tr id="r_identification_verification_matched_flag"<?= $Page->identification_verification_matched_flag->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_identification_verification_matched_flag"><?= $Page->identification_verification_matched_flag->caption() ?></span></td>
        <td data-name="identification_verification_matched_flag"<?= $Page->identification_verification_matched_flag->cellAttributes() ?>>
<span id="el_member_scb_identification_verification_matched_flag">
<span<?= $Page->identification_verification_matched_flag->viewAttributes() ?>>
<?= $Page->identification_verification_matched_flag->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bankstatement_confident_score->Visible) { // bankstatement_confident_score ?>
    <tr id="r_bankstatement_confident_score"<?= $Page->bankstatement_confident_score->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_bankstatement_confident_score"><?= $Page->bankstatement_confident_score->caption() ?></span></td>
        <td data-name="bankstatement_confident_score"<?= $Page->bankstatement_confident_score->cellAttributes() ?>>
<span id="el_member_scb_bankstatement_confident_score">
<span<?= $Page->bankstatement_confident_score->viewAttributes() ?>>
<?= $Page->bankstatement_confident_score->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estimated_monthly_income->Visible) { // estimated_monthly_income ?>
    <tr id="r_estimated_monthly_income"<?= $Page->estimated_monthly_income->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_estimated_monthly_income"><?= $Page->estimated_monthly_income->caption() ?></span></td>
        <td data-name="estimated_monthly_income"<?= $Page->estimated_monthly_income->cellAttributes() ?>>
<span id="el_member_scb_estimated_monthly_income">
<span<?= $Page->estimated_monthly_income->viewAttributes() ?>>
<?= $Page->estimated_monthly_income->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estimated_monthly_debt->Visible) { // estimated_monthly_debt ?>
    <tr id="r_estimated_monthly_debt"<?= $Page->estimated_monthly_debt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_estimated_monthly_debt"><?= $Page->estimated_monthly_debt->caption() ?></span></td>
        <td data-name="estimated_monthly_debt"<?= $Page->estimated_monthly_debt->cellAttributes() ?>>
<span id="el_member_scb_estimated_monthly_debt">
<span<?= $Page->estimated_monthly_debt->viewAttributes() ?>>
<?= $Page->estimated_monthly_debt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->income_stability->Visible) { // income_stability ?>
    <tr id="r_income_stability"<?= $Page->income_stability->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_income_stability"><?= $Page->income_stability->caption() ?></span></td>
        <td data-name="income_stability"<?= $Page->income_stability->cellAttributes() ?>>
<span id="el_member_scb_income_stability">
<span<?= $Page->income_stability->viewAttributes() ?>>
<?= $Page->income_stability->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->customer_grade->Visible) { // customer_grade ?>
    <tr id="r_customer_grade"<?= $Page->customer_grade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_customer_grade"><?= $Page->customer_grade->caption() ?></span></td>
        <td data-name="customer_grade"<?= $Page->customer_grade->cellAttributes() ?>>
<span id="el_member_scb_customer_grade">
<span<?= $Page->customer_grade->viewAttributes() ?>>
<?= $Page->customer_grade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->color_sign->Visible) { // color_sign ?>
    <tr id="r_color_sign"<?= $Page->color_sign->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_color_sign"><?= $Page->color_sign->caption() ?></span></td>
        <td data-name="color_sign"<?= $Page->color_sign->cellAttributes() ?>>
<span id="el_member_scb_color_sign">
<span<?= $Page->color_sign->viewAttributes() ?>>
<?= $Page->color_sign->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rental_period->Visible) { // rental_period ?>
    <tr id="r_rental_period"<?= $Page->rental_period->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_rental_period"><?= $Page->rental_period->caption() ?></span></td>
        <td data-name="rental_period"<?= $Page->rental_period->cellAttributes() ?>>
<span id="el_member_scb_rental_period">
<span<?= $Page->rental_period->viewAttributes() ?>>
<?= $Page->rental_period->getViewValue() ?></span>
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
