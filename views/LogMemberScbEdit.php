<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogMemberScbEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_member_scb: currentTable } });
var currentForm, currentPageID;
var flog_member_scbedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_member_scbedit = new ew.Form("flog_member_scbedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = flog_member_scbedit;

    // Add fields
    var fields = currentTable.fields;
    flog_member_scbedit.addFields([
        ["log_member_scb_id", [fields.log_member_scb_id.visible && fields.log_member_scb_id.required ? ew.Validators.required(fields.log_member_scb_id.caption) : null], fields.log_member_scb_id.isInvalid],
        ["reference_id", [fields.reference_id.visible && fields.reference_id.required ? ew.Validators.required(fields.reference_id.caption) : null], fields.reference_id.isInvalid],
        ["reference_url", [fields.reference_url.visible && fields.reference_url.required ? ew.Validators.required(fields.reference_url.caption) : null], fields.reference_url.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null, ew.Validators.integer], fields.member_id.isInvalid],
        ["refreshtoken", [fields.refreshtoken.visible && fields.refreshtoken.required ? ew.Validators.required(fields.refreshtoken.caption) : null], fields.refreshtoken.isInvalid],
        ["auth_code", [fields.auth_code.visible && fields.auth_code.required ? ew.Validators.required(fields.auth_code.caption) : null], fields.auth_code.isInvalid],
        ["_token", [fields._token.visible && fields._token.required ? ew.Validators.required(fields._token.caption) : null], fields._token.isInvalid],
        ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null], fields.state.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null, ew.Validators.integer], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["at_expire_in", [fields.at_expire_in.visible && fields.at_expire_in.required ? ew.Validators.required(fields.at_expire_in.caption) : null], fields.at_expire_in.isInvalid],
        ["rt_expire_in", [fields.rt_expire_in.visible && fields.rt_expire_in.required ? ew.Validators.required(fields.rt_expire_in.caption) : null], fields.rt_expire_in.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null, ew.Validators.integer], fields.asset_id.isInvalid],
        ["decision_status", [fields.decision_status.visible && fields.decision_status.required ? ew.Validators.required(fields.decision_status.caption) : null], fields.decision_status.isInvalid],
        ["decision_timestamp", [fields.decision_timestamp.visible && fields.decision_timestamp.required ? ew.Validators.required(fields.decision_timestamp.caption) : null, ew.Validators.datetime(fields.decision_timestamp.clientFormatPattern)], fields.decision_timestamp.isInvalid],
        ["deposit_amount", [fields.deposit_amount.visible && fields.deposit_amount.required ? ew.Validators.required(fields.deposit_amount.caption) : null, ew.Validators.float], fields.deposit_amount.isInvalid],
        ["due_date", [fields.due_date.visible && fields.due_date.required ? ew.Validators.required(fields.due_date.caption) : null, ew.Validators.integer], fields.due_date.isInvalid],
        ["rental_fee", [fields.rental_fee.visible && fields.rental_fee.required ? ew.Validators.required(fields.rental_fee.caption) : null, ew.Validators.float], fields.rental_fee.isInvalid],
        ["fullName", [fields.fullName.visible && fields.fullName.required ? ew.Validators.required(fields.fullName.caption) : null], fields.fullName.isInvalid],
        ["age", [fields.age.visible && fields.age.required ? ew.Validators.required(fields.age.caption) : null, ew.Validators.integer], fields.age.isInvalid],
        ["maritalStatus", [fields.maritalStatus.visible && fields.maritalStatus.required ? ew.Validators.required(fields.maritalStatus.caption) : null], fields.maritalStatus.isInvalid],
        ["noOfChildren", [fields.noOfChildren.visible && fields.noOfChildren.required ? ew.Validators.required(fields.noOfChildren.caption) : null], fields.noOfChildren.isInvalid],
        ["educationLevel", [fields.educationLevel.visible && fields.educationLevel.required ? ew.Validators.required(fields.educationLevel.caption) : null], fields.educationLevel.isInvalid],
        ["workplace", [fields.workplace.visible && fields.workplace.required ? ew.Validators.required(fields.workplace.caption) : null], fields.workplace.isInvalid],
        ["occupation", [fields.occupation.visible && fields.occupation.required ? ew.Validators.required(fields.occupation.caption) : null], fields.occupation.isInvalid],
        ["jobPosition", [fields.jobPosition.visible && fields.jobPosition.required ? ew.Validators.required(fields.jobPosition.caption) : null], fields.jobPosition.isInvalid],
        ["submissionDate", [fields.submissionDate.visible && fields.submissionDate.required ? ew.Validators.required(fields.submissionDate.caption) : null, ew.Validators.datetime(fields.submissionDate.clientFormatPattern)], fields.submissionDate.isInvalid],
        ["bankruptcy_tendency", [fields.bankruptcy_tendency.visible && fields.bankruptcy_tendency.required ? ew.Validators.required(fields.bankruptcy_tendency.caption) : null], fields.bankruptcy_tendency.isInvalid],
        ["blacklist_tendency", [fields.blacklist_tendency.visible && fields.blacklist_tendency.required ? ew.Validators.required(fields.blacklist_tendency.caption) : null], fields.blacklist_tendency.isInvalid],
        ["money_laundering_tendency", [fields.money_laundering_tendency.visible && fields.money_laundering_tendency.required ? ew.Validators.required(fields.money_laundering_tendency.caption) : null], fields.money_laundering_tendency.isInvalid],
        ["mobile_fraud_behavior", [fields.mobile_fraud_behavior.visible && fields.mobile_fraud_behavior.required ? ew.Validators.required(fields.mobile_fraud_behavior.caption) : null], fields.mobile_fraud_behavior.isInvalid],
        ["face_similarity_score", [fields.face_similarity_score.visible && fields.face_similarity_score.required ? ew.Validators.required(fields.face_similarity_score.caption) : null], fields.face_similarity_score.isInvalid],
        ["identification_verification_matched_flag", [fields.identification_verification_matched_flag.visible && fields.identification_verification_matched_flag.required ? ew.Validators.required(fields.identification_verification_matched_flag.caption) : null], fields.identification_verification_matched_flag.isInvalid],
        ["bankstatement_confident_score", [fields.bankstatement_confident_score.visible && fields.bankstatement_confident_score.required ? ew.Validators.required(fields.bankstatement_confident_score.caption) : null], fields.bankstatement_confident_score.isInvalid],
        ["estimated_monthly_income", [fields.estimated_monthly_income.visible && fields.estimated_monthly_income.required ? ew.Validators.required(fields.estimated_monthly_income.caption) : null], fields.estimated_monthly_income.isInvalid],
        ["estimated_monthly_debt", [fields.estimated_monthly_debt.visible && fields.estimated_monthly_debt.required ? ew.Validators.required(fields.estimated_monthly_debt.caption) : null], fields.estimated_monthly_debt.isInvalid],
        ["income_stability", [fields.income_stability.visible && fields.income_stability.required ? ew.Validators.required(fields.income_stability.caption) : null], fields.income_stability.isInvalid],
        ["customer_grade", [fields.customer_grade.visible && fields.customer_grade.required ? ew.Validators.required(fields.customer_grade.caption) : null], fields.customer_grade.isInvalid],
        ["color_sign", [fields.color_sign.visible && fields.color_sign.required ? ew.Validators.required(fields.color_sign.caption) : null], fields.color_sign.isInvalid],
        ["rental_period", [fields.rental_period.visible && fields.rental_period.required ? ew.Validators.required(fields.rental_period.caption) : null, ew.Validators.integer], fields.rental_period.isInvalid]
    ]);

    // Form_CustomValidate
    flog_member_scbedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flog_member_scbedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("flog_member_scbedit");
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
<form name="flog_member_scbedit" id="flog_member_scbedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_member_scb">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->log_member_scb_id->Visible) { // log_member_scb_id ?>
    <div id="r_log_member_scb_id"<?= $Page->log_member_scb_id->rowAttributes() ?>>
        <label id="elh_log_member_scb_log_member_scb_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->log_member_scb_id->caption() ?><?= $Page->log_member_scb_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->log_member_scb_id->cellAttributes() ?>>
<span id="el_log_member_scb_log_member_scb_id">
<span<?= $Page->log_member_scb_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->log_member_scb_id->getDisplayValue($Page->log_member_scb_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="log_member_scb" data-field="x_log_member_scb_id" data-hidden="1" name="x_log_member_scb_id" id="x_log_member_scb_id" value="<?= HtmlEncode($Page->log_member_scb_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->reference_id->Visible) { // reference_id ?>
    <div id="r_reference_id"<?= $Page->reference_id->rowAttributes() ?>>
        <label id="elh_log_member_scb_reference_id" for="x_reference_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->reference_id->caption() ?><?= $Page->reference_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->reference_id->cellAttributes() ?>>
<span id="el_log_member_scb_reference_id">
<input type="<?= $Page->reference_id->getInputTextType() ?>" name="x_reference_id" id="x_reference_id" data-table="log_member_scb" data-field="x_reference_id" value="<?= $Page->reference_id->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->reference_id->getPlaceHolder()) ?>"<?= $Page->reference_id->editAttributes() ?> aria-describedby="x_reference_id_help">
<?= $Page->reference_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->reference_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->reference_url->Visible) { // reference_url ?>
    <div id="r_reference_url"<?= $Page->reference_url->rowAttributes() ?>>
        <label id="elh_log_member_scb_reference_url" for="x_reference_url" class="<?= $Page->LeftColumnClass ?>"><?= $Page->reference_url->caption() ?><?= $Page->reference_url->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->reference_url->cellAttributes() ?>>
<span id="el_log_member_scb_reference_url">
<textarea data-table="log_member_scb" data-field="x_reference_url" name="x_reference_url" id="x_reference_url" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->reference_url->getPlaceHolder()) ?>"<?= $Page->reference_url->editAttributes() ?> aria-describedby="x_reference_url_help"><?= $Page->reference_url->EditValue ?></textarea>
<?= $Page->reference_url->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->reference_url->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_log_member_scb_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_log_member_scb_member_id">
<input type="<?= $Page->member_id->getInputTextType() ?>" name="x_member_id" id="x_member_id" data-table="log_member_scb" data-field="x_member_id" value="<?= $Page->member_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"<?= $Page->member_id->editAttributes() ?> aria-describedby="x_member_id_help">
<?= $Page->member_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->refreshtoken->Visible) { // refreshtoken ?>
    <div id="r_refreshtoken"<?= $Page->refreshtoken->rowAttributes() ?>>
        <label id="elh_log_member_scb_refreshtoken" for="x_refreshtoken" class="<?= $Page->LeftColumnClass ?>"><?= $Page->refreshtoken->caption() ?><?= $Page->refreshtoken->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->refreshtoken->cellAttributes() ?>>
<span id="el_log_member_scb_refreshtoken">
<textarea data-table="log_member_scb" data-field="x_refreshtoken" name="x_refreshtoken" id="x_refreshtoken" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->refreshtoken->getPlaceHolder()) ?>"<?= $Page->refreshtoken->editAttributes() ?> aria-describedby="x_refreshtoken_help"><?= $Page->refreshtoken->EditValue ?></textarea>
<?= $Page->refreshtoken->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->refreshtoken->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->auth_code->Visible) { // auth_code ?>
    <div id="r_auth_code"<?= $Page->auth_code->rowAttributes() ?>>
        <label id="elh_log_member_scb_auth_code" for="x_auth_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->auth_code->caption() ?><?= $Page->auth_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->auth_code->cellAttributes() ?>>
<span id="el_log_member_scb_auth_code">
<textarea data-table="log_member_scb" data-field="x_auth_code" name="x_auth_code" id="x_auth_code" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->auth_code->getPlaceHolder()) ?>"<?= $Page->auth_code->editAttributes() ?> aria-describedby="x_auth_code_help"><?= $Page->auth_code->EditValue ?></textarea>
<?= $Page->auth_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->auth_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
    <div id="r__token"<?= $Page->_token->rowAttributes() ?>>
        <label id="elh_log_member_scb__token" for="x__token" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_token->caption() ?><?= $Page->_token->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_token->cellAttributes() ?>>
<span id="el_log_member_scb__token">
<textarea data-table="log_member_scb" data-field="x__token" name="x__token" id="x__token" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_token->getPlaceHolder()) ?>"<?= $Page->_token->editAttributes() ?> aria-describedby="x__token_help"><?= $Page->_token->EditValue ?></textarea>
<?= $Page->_token->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_token->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div id="r_state"<?= $Page->state->rowAttributes() ?>>
        <label id="elh_log_member_scb_state" for="x_state" class="<?= $Page->LeftColumnClass ?>"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->state->cellAttributes() ?>>
<span id="el_log_member_scb_state">
<textarea data-table="log_member_scb" data-field="x_state" name="x_state" id="x_state" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>"<?= $Page->state->editAttributes() ?> aria-describedby="x_state_help"><?= $Page->state->EditValue ?></textarea>
<?= $Page->state->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_log_member_scb_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_log_member_scb_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="log_member_scb" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_member_scbedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("flog_member_scbedit", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_log_member_scb_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_log_member_scb_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="log_member_scb" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_log_member_scb_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_log_member_scb_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="log_member_scb" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_log_member_scb_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_log_member_scb_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="log_member_scb" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->at_expire_in->Visible) { // at_expire_in ?>
    <div id="r_at_expire_in"<?= $Page->at_expire_in->rowAttributes() ?>>
        <label id="elh_log_member_scb_at_expire_in" for="x_at_expire_in" class="<?= $Page->LeftColumnClass ?>"><?= $Page->at_expire_in->caption() ?><?= $Page->at_expire_in->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->at_expire_in->cellAttributes() ?>>
<span id="el_log_member_scb_at_expire_in">
<textarea data-table="log_member_scb" data-field="x_at_expire_in" name="x_at_expire_in" id="x_at_expire_in" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->at_expire_in->getPlaceHolder()) ?>"<?= $Page->at_expire_in->editAttributes() ?> aria-describedby="x_at_expire_in_help"><?= $Page->at_expire_in->EditValue ?></textarea>
<?= $Page->at_expire_in->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->at_expire_in->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rt_expire_in->Visible) { // rt_expire_in ?>
    <div id="r_rt_expire_in"<?= $Page->rt_expire_in->rowAttributes() ?>>
        <label id="elh_log_member_scb_rt_expire_in" for="x_rt_expire_in" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rt_expire_in->caption() ?><?= $Page->rt_expire_in->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rt_expire_in->cellAttributes() ?>>
<span id="el_log_member_scb_rt_expire_in">
<textarea data-table="log_member_scb" data-field="x_rt_expire_in" name="x_rt_expire_in" id="x_rt_expire_in" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->rt_expire_in->getPlaceHolder()) ?>"<?= $Page->rt_expire_in->editAttributes() ?> aria-describedby="x_rt_expire_in_help"><?= $Page->rt_expire_in->EditValue ?></textarea>
<?= $Page->rt_expire_in->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rt_expire_in->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_log_member_scb_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_log_member_scb_asset_id">
<input type="<?= $Page->asset_id->getInputTextType() ?>" name="x_asset_id" id="x_asset_id" data-table="log_member_scb" data-field="x_asset_id" value="<?= $Page->asset_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"<?= $Page->asset_id->editAttributes() ?> aria-describedby="x_asset_id_help">
<?= $Page->asset_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->decision_status->Visible) { // decision_status ?>
    <div id="r_decision_status"<?= $Page->decision_status->rowAttributes() ?>>
        <label id="elh_log_member_scb_decision_status" for="x_decision_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->decision_status->caption() ?><?= $Page->decision_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->decision_status->cellAttributes() ?>>
<span id="el_log_member_scb_decision_status">
<input type="<?= $Page->decision_status->getInputTextType() ?>" name="x_decision_status" id="x_decision_status" data-table="log_member_scb" data-field="x_decision_status" value="<?= $Page->decision_status->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->decision_status->getPlaceHolder()) ?>"<?= $Page->decision_status->editAttributes() ?> aria-describedby="x_decision_status_help">
<?= $Page->decision_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->decision_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->decision_timestamp->Visible) { // decision_timestamp ?>
    <div id="r_decision_timestamp"<?= $Page->decision_timestamp->rowAttributes() ?>>
        <label id="elh_log_member_scb_decision_timestamp" for="x_decision_timestamp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->decision_timestamp->caption() ?><?= $Page->decision_timestamp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->decision_timestamp->cellAttributes() ?>>
<span id="el_log_member_scb_decision_timestamp">
<input type="<?= $Page->decision_timestamp->getInputTextType() ?>" name="x_decision_timestamp" id="x_decision_timestamp" data-table="log_member_scb" data-field="x_decision_timestamp" value="<?= $Page->decision_timestamp->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->decision_timestamp->getPlaceHolder()) ?>"<?= $Page->decision_timestamp->editAttributes() ?> aria-describedby="x_decision_timestamp_help">
<?= $Page->decision_timestamp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->decision_timestamp->getErrorMessage() ?></div>
<?php if (!$Page->decision_timestamp->ReadOnly && !$Page->decision_timestamp->Disabled && !isset($Page->decision_timestamp->EditAttrs["readonly"]) && !isset($Page->decision_timestamp->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_member_scbedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("flog_member_scbedit", "x_decision_timestamp", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deposit_amount->Visible) { // deposit_amount ?>
    <div id="r_deposit_amount"<?= $Page->deposit_amount->rowAttributes() ?>>
        <label id="elh_log_member_scb_deposit_amount" for="x_deposit_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deposit_amount->caption() ?><?= $Page->deposit_amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->deposit_amount->cellAttributes() ?>>
<span id="el_log_member_scb_deposit_amount">
<input type="<?= $Page->deposit_amount->getInputTextType() ?>" name="x_deposit_amount" id="x_deposit_amount" data-table="log_member_scb" data-field="x_deposit_amount" value="<?= $Page->deposit_amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->deposit_amount->getPlaceHolder()) ?>"<?= $Page->deposit_amount->editAttributes() ?> aria-describedby="x_deposit_amount_help">
<?= $Page->deposit_amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deposit_amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <div id="r_due_date"<?= $Page->due_date->rowAttributes() ?>>
        <label id="elh_log_member_scb_due_date" for="x_due_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date->caption() ?><?= $Page->due_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date->cellAttributes() ?>>
<span id="el_log_member_scb_due_date">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="x_due_date" id="x_due_date" data-table="log_member_scb" data-field="x_due_date" value="<?= $Page->due_date->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?> aria-describedby="x_due_date_help">
<?= $Page->due_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rental_fee->Visible) { // rental_fee ?>
    <div id="r_rental_fee"<?= $Page->rental_fee->rowAttributes() ?>>
        <label id="elh_log_member_scb_rental_fee" for="x_rental_fee" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_fee->caption() ?><?= $Page->rental_fee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_fee->cellAttributes() ?>>
<span id="el_log_member_scb_rental_fee">
<input type="<?= $Page->rental_fee->getInputTextType() ?>" name="x_rental_fee" id="x_rental_fee" data-table="log_member_scb" data-field="x_rental_fee" value="<?= $Page->rental_fee->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rental_fee->getPlaceHolder()) ?>"<?= $Page->rental_fee->editAttributes() ?> aria-describedby="x_rental_fee_help">
<?= $Page->rental_fee->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rental_fee->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fullName->Visible) { // fullName ?>
    <div id="r_fullName"<?= $Page->fullName->rowAttributes() ?>>
        <label id="elh_log_member_scb_fullName" for="x_fullName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fullName->caption() ?><?= $Page->fullName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fullName->cellAttributes() ?>>
<span id="el_log_member_scb_fullName">
<input type="<?= $Page->fullName->getInputTextType() ?>" name="x_fullName" id="x_fullName" data-table="log_member_scb" data-field="x_fullName" value="<?= $Page->fullName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fullName->getPlaceHolder()) ?>"<?= $Page->fullName->editAttributes() ?> aria-describedby="x_fullName_help">
<?= $Page->fullName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fullName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->age->Visible) { // age ?>
    <div id="r_age"<?= $Page->age->rowAttributes() ?>>
        <label id="elh_log_member_scb_age" for="x_age" class="<?= $Page->LeftColumnClass ?>"><?= $Page->age->caption() ?><?= $Page->age->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->age->cellAttributes() ?>>
<span id="el_log_member_scb_age">
<input type="<?= $Page->age->getInputTextType() ?>" name="x_age" id="x_age" data-table="log_member_scb" data-field="x_age" value="<?= $Page->age->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->age->getPlaceHolder()) ?>"<?= $Page->age->editAttributes() ?> aria-describedby="x_age_help">
<?= $Page->age->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->age->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->maritalStatus->Visible) { // maritalStatus ?>
    <div id="r_maritalStatus"<?= $Page->maritalStatus->rowAttributes() ?>>
        <label id="elh_log_member_scb_maritalStatus" for="x_maritalStatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->maritalStatus->caption() ?><?= $Page->maritalStatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->maritalStatus->cellAttributes() ?>>
<span id="el_log_member_scb_maritalStatus">
<input type="<?= $Page->maritalStatus->getInputTextType() ?>" name="x_maritalStatus" id="x_maritalStatus" data-table="log_member_scb" data-field="x_maritalStatus" value="<?= $Page->maritalStatus->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->maritalStatus->getPlaceHolder()) ?>"<?= $Page->maritalStatus->editAttributes() ?> aria-describedby="x_maritalStatus_help">
<?= $Page->maritalStatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->maritalStatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->noOfChildren->Visible) { // noOfChildren ?>
    <div id="r_noOfChildren"<?= $Page->noOfChildren->rowAttributes() ?>>
        <label id="elh_log_member_scb_noOfChildren" for="x_noOfChildren" class="<?= $Page->LeftColumnClass ?>"><?= $Page->noOfChildren->caption() ?><?= $Page->noOfChildren->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->noOfChildren->cellAttributes() ?>>
<span id="el_log_member_scb_noOfChildren">
<input type="<?= $Page->noOfChildren->getInputTextType() ?>" name="x_noOfChildren" id="x_noOfChildren" data-table="log_member_scb" data-field="x_noOfChildren" value="<?= $Page->noOfChildren->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->noOfChildren->getPlaceHolder()) ?>"<?= $Page->noOfChildren->editAttributes() ?> aria-describedby="x_noOfChildren_help">
<?= $Page->noOfChildren->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->noOfChildren->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->educationLevel->Visible) { // educationLevel ?>
    <div id="r_educationLevel"<?= $Page->educationLevel->rowAttributes() ?>>
        <label id="elh_log_member_scb_educationLevel" for="x_educationLevel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->educationLevel->caption() ?><?= $Page->educationLevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->educationLevel->cellAttributes() ?>>
<span id="el_log_member_scb_educationLevel">
<input type="<?= $Page->educationLevel->getInputTextType() ?>" name="x_educationLevel" id="x_educationLevel" data-table="log_member_scb" data-field="x_educationLevel" value="<?= $Page->educationLevel->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->educationLevel->getPlaceHolder()) ?>"<?= $Page->educationLevel->editAttributes() ?> aria-describedby="x_educationLevel_help">
<?= $Page->educationLevel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->educationLevel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->workplace->Visible) { // workplace ?>
    <div id="r_workplace"<?= $Page->workplace->rowAttributes() ?>>
        <label id="elh_log_member_scb_workplace" for="x_workplace" class="<?= $Page->LeftColumnClass ?>"><?= $Page->workplace->caption() ?><?= $Page->workplace->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->workplace->cellAttributes() ?>>
<span id="el_log_member_scb_workplace">
<input type="<?= $Page->workplace->getInputTextType() ?>" name="x_workplace" id="x_workplace" data-table="log_member_scb" data-field="x_workplace" value="<?= $Page->workplace->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->workplace->getPlaceHolder()) ?>"<?= $Page->workplace->editAttributes() ?> aria-describedby="x_workplace_help">
<?= $Page->workplace->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->workplace->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->occupation->Visible) { // occupation ?>
    <div id="r_occupation"<?= $Page->occupation->rowAttributes() ?>>
        <label id="elh_log_member_scb_occupation" for="x_occupation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->occupation->caption() ?><?= $Page->occupation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->occupation->cellAttributes() ?>>
<span id="el_log_member_scb_occupation">
<input type="<?= $Page->occupation->getInputTextType() ?>" name="x_occupation" id="x_occupation" data-table="log_member_scb" data-field="x_occupation" value="<?= $Page->occupation->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->occupation->getPlaceHolder()) ?>"<?= $Page->occupation->editAttributes() ?> aria-describedby="x_occupation_help">
<?= $Page->occupation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->occupation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jobPosition->Visible) { // jobPosition ?>
    <div id="r_jobPosition"<?= $Page->jobPosition->rowAttributes() ?>>
        <label id="elh_log_member_scb_jobPosition" for="x_jobPosition" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jobPosition->caption() ?><?= $Page->jobPosition->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jobPosition->cellAttributes() ?>>
<span id="el_log_member_scb_jobPosition">
<input type="<?= $Page->jobPosition->getInputTextType() ?>" name="x_jobPosition" id="x_jobPosition" data-table="log_member_scb" data-field="x_jobPosition" value="<?= $Page->jobPosition->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jobPosition->getPlaceHolder()) ?>"<?= $Page->jobPosition->editAttributes() ?> aria-describedby="x_jobPosition_help">
<?= $Page->jobPosition->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jobPosition->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submissionDate->Visible) { // submissionDate ?>
    <div id="r_submissionDate"<?= $Page->submissionDate->rowAttributes() ?>>
        <label id="elh_log_member_scb_submissionDate" for="x_submissionDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->submissionDate->caption() ?><?= $Page->submissionDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->submissionDate->cellAttributes() ?>>
<span id="el_log_member_scb_submissionDate">
<input type="<?= $Page->submissionDate->getInputTextType() ?>" name="x_submissionDate" id="x_submissionDate" data-table="log_member_scb" data-field="x_submissionDate" value="<?= $Page->submissionDate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->submissionDate->getPlaceHolder()) ?>"<?= $Page->submissionDate->editAttributes() ?> aria-describedby="x_submissionDate_help">
<?= $Page->submissionDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->submissionDate->getErrorMessage() ?></div>
<?php if (!$Page->submissionDate->ReadOnly && !$Page->submissionDate->Disabled && !isset($Page->submissionDate->EditAttrs["readonly"]) && !isset($Page->submissionDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_member_scbedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("flog_member_scbedit", "x_submissionDate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bankruptcy_tendency->Visible) { // bankruptcy_tendency ?>
    <div id="r_bankruptcy_tendency"<?= $Page->bankruptcy_tendency->rowAttributes() ?>>
        <label id="elh_log_member_scb_bankruptcy_tendency" for="x_bankruptcy_tendency" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bankruptcy_tendency->caption() ?><?= $Page->bankruptcy_tendency->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bankruptcy_tendency->cellAttributes() ?>>
<span id="el_log_member_scb_bankruptcy_tendency">
<input type="<?= $Page->bankruptcy_tendency->getInputTextType() ?>" name="x_bankruptcy_tendency" id="x_bankruptcy_tendency" data-table="log_member_scb" data-field="x_bankruptcy_tendency" value="<?= $Page->bankruptcy_tendency->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bankruptcy_tendency->getPlaceHolder()) ?>"<?= $Page->bankruptcy_tendency->editAttributes() ?> aria-describedby="x_bankruptcy_tendency_help">
<?= $Page->bankruptcy_tendency->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bankruptcy_tendency->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->blacklist_tendency->Visible) { // blacklist_tendency ?>
    <div id="r_blacklist_tendency"<?= $Page->blacklist_tendency->rowAttributes() ?>>
        <label id="elh_log_member_scb_blacklist_tendency" for="x_blacklist_tendency" class="<?= $Page->LeftColumnClass ?>"><?= $Page->blacklist_tendency->caption() ?><?= $Page->blacklist_tendency->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->blacklist_tendency->cellAttributes() ?>>
<span id="el_log_member_scb_blacklist_tendency">
<input type="<?= $Page->blacklist_tendency->getInputTextType() ?>" name="x_blacklist_tendency" id="x_blacklist_tendency" data-table="log_member_scb" data-field="x_blacklist_tendency" value="<?= $Page->blacklist_tendency->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->blacklist_tendency->getPlaceHolder()) ?>"<?= $Page->blacklist_tendency->editAttributes() ?> aria-describedby="x_blacklist_tendency_help">
<?= $Page->blacklist_tendency->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->blacklist_tendency->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->money_laundering_tendency->Visible) { // money_laundering_tendency ?>
    <div id="r_money_laundering_tendency"<?= $Page->money_laundering_tendency->rowAttributes() ?>>
        <label id="elh_log_member_scb_money_laundering_tendency" for="x_money_laundering_tendency" class="<?= $Page->LeftColumnClass ?>"><?= $Page->money_laundering_tendency->caption() ?><?= $Page->money_laundering_tendency->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->money_laundering_tendency->cellAttributes() ?>>
<span id="el_log_member_scb_money_laundering_tendency">
<input type="<?= $Page->money_laundering_tendency->getInputTextType() ?>" name="x_money_laundering_tendency" id="x_money_laundering_tendency" data-table="log_member_scb" data-field="x_money_laundering_tendency" value="<?= $Page->money_laundering_tendency->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->money_laundering_tendency->getPlaceHolder()) ?>"<?= $Page->money_laundering_tendency->editAttributes() ?> aria-describedby="x_money_laundering_tendency_help">
<?= $Page->money_laundering_tendency->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->money_laundering_tendency->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mobile_fraud_behavior->Visible) { // mobile_fraud_behavior ?>
    <div id="r_mobile_fraud_behavior"<?= $Page->mobile_fraud_behavior->rowAttributes() ?>>
        <label id="elh_log_member_scb_mobile_fraud_behavior" for="x_mobile_fraud_behavior" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mobile_fraud_behavior->caption() ?><?= $Page->mobile_fraud_behavior->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mobile_fraud_behavior->cellAttributes() ?>>
<span id="el_log_member_scb_mobile_fraud_behavior">
<input type="<?= $Page->mobile_fraud_behavior->getInputTextType() ?>" name="x_mobile_fraud_behavior" id="x_mobile_fraud_behavior" data-table="log_member_scb" data-field="x_mobile_fraud_behavior" value="<?= $Page->mobile_fraud_behavior->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->mobile_fraud_behavior->getPlaceHolder()) ?>"<?= $Page->mobile_fraud_behavior->editAttributes() ?> aria-describedby="x_mobile_fraud_behavior_help">
<?= $Page->mobile_fraud_behavior->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mobile_fraud_behavior->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->face_similarity_score->Visible) { // face_similarity_score ?>
    <div id="r_face_similarity_score"<?= $Page->face_similarity_score->rowAttributes() ?>>
        <label id="elh_log_member_scb_face_similarity_score" for="x_face_similarity_score" class="<?= $Page->LeftColumnClass ?>"><?= $Page->face_similarity_score->caption() ?><?= $Page->face_similarity_score->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->face_similarity_score->cellAttributes() ?>>
<span id="el_log_member_scb_face_similarity_score">
<input type="<?= $Page->face_similarity_score->getInputTextType() ?>" name="x_face_similarity_score" id="x_face_similarity_score" data-table="log_member_scb" data-field="x_face_similarity_score" value="<?= $Page->face_similarity_score->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->face_similarity_score->getPlaceHolder()) ?>"<?= $Page->face_similarity_score->editAttributes() ?> aria-describedby="x_face_similarity_score_help">
<?= $Page->face_similarity_score->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->face_similarity_score->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->identification_verification_matched_flag->Visible) { // identification_verification_matched_flag ?>
    <div id="r_identification_verification_matched_flag"<?= $Page->identification_verification_matched_flag->rowAttributes() ?>>
        <label id="elh_log_member_scb_identification_verification_matched_flag" for="x_identification_verification_matched_flag" class="<?= $Page->LeftColumnClass ?>"><?= $Page->identification_verification_matched_flag->caption() ?><?= $Page->identification_verification_matched_flag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->identification_verification_matched_flag->cellAttributes() ?>>
<span id="el_log_member_scb_identification_verification_matched_flag">
<input type="<?= $Page->identification_verification_matched_flag->getInputTextType() ?>" name="x_identification_verification_matched_flag" id="x_identification_verification_matched_flag" data-table="log_member_scb" data-field="x_identification_verification_matched_flag" value="<?= $Page->identification_verification_matched_flag->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->identification_verification_matched_flag->getPlaceHolder()) ?>"<?= $Page->identification_verification_matched_flag->editAttributes() ?> aria-describedby="x_identification_verification_matched_flag_help">
<?= $Page->identification_verification_matched_flag->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->identification_verification_matched_flag->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bankstatement_confident_score->Visible) { // bankstatement_confident_score ?>
    <div id="r_bankstatement_confident_score"<?= $Page->bankstatement_confident_score->rowAttributes() ?>>
        <label id="elh_log_member_scb_bankstatement_confident_score" for="x_bankstatement_confident_score" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bankstatement_confident_score->caption() ?><?= $Page->bankstatement_confident_score->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bankstatement_confident_score->cellAttributes() ?>>
<span id="el_log_member_scb_bankstatement_confident_score">
<input type="<?= $Page->bankstatement_confident_score->getInputTextType() ?>" name="x_bankstatement_confident_score" id="x_bankstatement_confident_score" data-table="log_member_scb" data-field="x_bankstatement_confident_score" value="<?= $Page->bankstatement_confident_score->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bankstatement_confident_score->getPlaceHolder()) ?>"<?= $Page->bankstatement_confident_score->editAttributes() ?> aria-describedby="x_bankstatement_confident_score_help">
<?= $Page->bankstatement_confident_score->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bankstatement_confident_score->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estimated_monthly_income->Visible) { // estimated_monthly_income ?>
    <div id="r_estimated_monthly_income"<?= $Page->estimated_monthly_income->rowAttributes() ?>>
        <label id="elh_log_member_scb_estimated_monthly_income" for="x_estimated_monthly_income" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estimated_monthly_income->caption() ?><?= $Page->estimated_monthly_income->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estimated_monthly_income->cellAttributes() ?>>
<span id="el_log_member_scb_estimated_monthly_income">
<input type="<?= $Page->estimated_monthly_income->getInputTextType() ?>" name="x_estimated_monthly_income" id="x_estimated_monthly_income" data-table="log_member_scb" data-field="x_estimated_monthly_income" value="<?= $Page->estimated_monthly_income->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->estimated_monthly_income->getPlaceHolder()) ?>"<?= $Page->estimated_monthly_income->editAttributes() ?> aria-describedby="x_estimated_monthly_income_help">
<?= $Page->estimated_monthly_income->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estimated_monthly_income->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estimated_monthly_debt->Visible) { // estimated_monthly_debt ?>
    <div id="r_estimated_monthly_debt"<?= $Page->estimated_monthly_debt->rowAttributes() ?>>
        <label id="elh_log_member_scb_estimated_monthly_debt" for="x_estimated_monthly_debt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estimated_monthly_debt->caption() ?><?= $Page->estimated_monthly_debt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estimated_monthly_debt->cellAttributes() ?>>
<span id="el_log_member_scb_estimated_monthly_debt">
<input type="<?= $Page->estimated_monthly_debt->getInputTextType() ?>" name="x_estimated_monthly_debt" id="x_estimated_monthly_debt" data-table="log_member_scb" data-field="x_estimated_monthly_debt" value="<?= $Page->estimated_monthly_debt->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->estimated_monthly_debt->getPlaceHolder()) ?>"<?= $Page->estimated_monthly_debt->editAttributes() ?> aria-describedby="x_estimated_monthly_debt_help">
<?= $Page->estimated_monthly_debt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estimated_monthly_debt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->income_stability->Visible) { // income_stability ?>
    <div id="r_income_stability"<?= $Page->income_stability->rowAttributes() ?>>
        <label id="elh_log_member_scb_income_stability" for="x_income_stability" class="<?= $Page->LeftColumnClass ?>"><?= $Page->income_stability->caption() ?><?= $Page->income_stability->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->income_stability->cellAttributes() ?>>
<span id="el_log_member_scb_income_stability">
<input type="<?= $Page->income_stability->getInputTextType() ?>" name="x_income_stability" id="x_income_stability" data-table="log_member_scb" data-field="x_income_stability" value="<?= $Page->income_stability->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->income_stability->getPlaceHolder()) ?>"<?= $Page->income_stability->editAttributes() ?> aria-describedby="x_income_stability_help">
<?= $Page->income_stability->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->income_stability->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->customer_grade->Visible) { // customer_grade ?>
    <div id="r_customer_grade"<?= $Page->customer_grade->rowAttributes() ?>>
        <label id="elh_log_member_scb_customer_grade" for="x_customer_grade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->customer_grade->caption() ?><?= $Page->customer_grade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->customer_grade->cellAttributes() ?>>
<span id="el_log_member_scb_customer_grade">
<input type="<?= $Page->customer_grade->getInputTextType() ?>" name="x_customer_grade" id="x_customer_grade" data-table="log_member_scb" data-field="x_customer_grade" value="<?= $Page->customer_grade->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->customer_grade->getPlaceHolder()) ?>"<?= $Page->customer_grade->editAttributes() ?> aria-describedby="x_customer_grade_help">
<?= $Page->customer_grade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->customer_grade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->color_sign->Visible) { // color_sign ?>
    <div id="r_color_sign"<?= $Page->color_sign->rowAttributes() ?>>
        <label id="elh_log_member_scb_color_sign" for="x_color_sign" class="<?= $Page->LeftColumnClass ?>"><?= $Page->color_sign->caption() ?><?= $Page->color_sign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->color_sign->cellAttributes() ?>>
<span id="el_log_member_scb_color_sign">
<input type="<?= $Page->color_sign->getInputTextType() ?>" name="x_color_sign" id="x_color_sign" data-table="log_member_scb" data-field="x_color_sign" value="<?= $Page->color_sign->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->color_sign->getPlaceHolder()) ?>"<?= $Page->color_sign->editAttributes() ?> aria-describedby="x_color_sign_help">
<?= $Page->color_sign->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->color_sign->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rental_period->Visible) { // rental_period ?>
    <div id="r_rental_period"<?= $Page->rental_period->rowAttributes() ?>>
        <label id="elh_log_member_scb_rental_period" for="x_rental_period" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_period->caption() ?><?= $Page->rental_period->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_period->cellAttributes() ?>>
<span id="el_log_member_scb_rental_period">
<input type="<?= $Page->rental_period->getInputTextType() ?>" name="x_rental_period" id="x_rental_period" data-table="log_member_scb" data-field="x_rental_period" value="<?= $Page->rental_period->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rental_period->getPlaceHolder()) ?>"<?= $Page->rental_period->editAttributes() ?> aria-describedby="x_rental_period_help">
<?= $Page->rental_period->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rental_period->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("log_member_scb");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
