<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvestorVerifyEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { investor_verify: currentTable } });
var currentForm, currentPageID;
var finvestor_verifyedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvestor_verifyedit = new ew.Form("finvestor_verifyedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = finvestor_verifyedit;

    // Add fields
    var fields = currentTable.fields;
    finvestor_verifyedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["firstname", [fields.firstname.visible && fields.firstname.required ? ew.Validators.required(fields.firstname.caption) : null], fields.firstname.isInvalid],
        ["lastname", [fields.lastname.visible && fields.lastname.required ? ew.Validators.required(fields.lastname.caption) : null], fields.lastname.isInvalid],
        ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["investment", [fields.investment.visible && fields.investment.required ? ew.Validators.required(fields.investment.caption) : null, ew.Validators.float], fields.investment.isInvalid],
        ["credit_limit", [fields.credit_limit.visible && fields.credit_limit.required ? ew.Validators.required(fields.credit_limit.caption) : null, ew.Validators.float], fields.credit_limit.isInvalid],
        ["monthly_payments", [fields.monthly_payments.visible && fields.monthly_payments.required ? ew.Validators.required(fields.monthly_payments.caption) : null, ew.Validators.float], fields.monthly_payments.isInvalid],
        ["highest_rental_price", [fields.highest_rental_price.visible && fields.highest_rental_price.required ? ew.Validators.required(fields.highest_rental_price.caption) : null, ew.Validators.float], fields.highest_rental_price.isInvalid],
        ["transfer", [fields.transfer.visible && fields.transfer.required ? ew.Validators.required(fields.transfer.caption) : null], fields.transfer.isInvalid],
        ["total_invertor_year", [fields.total_invertor_year.visible && fields.total_invertor_year.required ? ew.Validators.required(fields.total_invertor_year.caption) : null, ew.Validators.float], fields.total_invertor_year.isInvalid],
        ["invert_payoff_day", [fields.invert_payoff_day.visible && fields.invert_payoff_day.required ? ew.Validators.required(fields.invert_payoff_day.caption) : null, ew.Validators.float], fields.invert_payoff_day.isInvalid],
        ["type_invertor", [fields.type_invertor.visible && fields.type_invertor.required ? ew.Validators.required(fields.type_invertor.caption) : null], fields.type_invertor.isInvalid],
        ["invest_amount", [fields.invest_amount.visible && fields.invest_amount.required ? ew.Validators.required(fields.invest_amount.caption) : null, ew.Validators.float], fields.invest_amount.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    finvestor_verifyedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvestor_verifyedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    finvestor_verifyedit.lists.transfer = <?= $Page->transfer->toClientList($Page) ?>;
    finvestor_verifyedit.lists.type_invertor = <?= $Page->type_invertor->toClientList($Page) ?>;
    loadjs.done("finvestor_verifyedit");
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
<form name="finvestor_verifyedit" id="finvestor_verifyedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="investor_verify">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "investor") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="investor">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_investor_verify_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_investor_verify_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="investor_verify" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
    <div id="r_firstname"<?= $Page->firstname->rowAttributes() ?>>
        <label id="elh_investor_verify_firstname" for="x_firstname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->firstname->caption() ?><?= $Page->firstname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->firstname->cellAttributes() ?>>
<span id="el_investor_verify_firstname">
<input type="<?= $Page->firstname->getInputTextType() ?>" name="x_firstname" id="x_firstname" data-table="investor_verify" data-field="x_firstname" value="<?= $Page->firstname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->firstname->getPlaceHolder()) ?>"<?= $Page->firstname->editAttributes() ?> aria-describedby="x_firstname_help">
<?= $Page->firstname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->firstname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <div id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <label id="elh_investor_verify_lastname" for="x_lastname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastname->caption() ?><?= $Page->lastname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastname->cellAttributes() ?>>
<span id="el_investor_verify_lastname">
<input type="<?= $Page->lastname->getInputTextType() ?>" name="x_lastname" id="x_lastname" data-table="investor_verify" data-field="x_lastname" value="<?= $Page->lastname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lastname->getPlaceHolder()) ?>"<?= $Page->lastname->editAttributes() ?> aria-describedby="x_lastname_help">
<?= $Page->lastname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_investor_verify_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<span id="el_investor_verify_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="investor_verify" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>"<?= $Page->phone->editAttributes() ?> aria-describedby="x_phone_help">
<?= $Page->phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_investor_verify__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_investor_verify__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="investor_verify" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investment->Visible) { // investment ?>
    <div id="r_investment"<?= $Page->investment->rowAttributes() ?>>
        <label id="elh_investor_verify_investment" for="x_investment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investment->caption() ?><?= $Page->investment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investment->cellAttributes() ?>>
<span id="el_investor_verify_investment">
<input type="<?= $Page->investment->getInputTextType() ?>" name="x_investment" id="x_investment" data-table="investor_verify" data-field="x_investment" value="<?= $Page->investment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->investment->getPlaceHolder()) ?>"<?= $Page->investment->editAttributes() ?> aria-describedby="x_investment_help">
<?= $Page->investment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->credit_limit->Visible) { // credit_limit ?>
    <div id="r_credit_limit"<?= $Page->credit_limit->rowAttributes() ?>>
        <label id="elh_investor_verify_credit_limit" for="x_credit_limit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->credit_limit->caption() ?><?= $Page->credit_limit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->credit_limit->cellAttributes() ?>>
<span id="el_investor_verify_credit_limit">
<input type="<?= $Page->credit_limit->getInputTextType() ?>" name="x_credit_limit" id="x_credit_limit" data-table="investor_verify" data-field="x_credit_limit" value="<?= $Page->credit_limit->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->credit_limit->getPlaceHolder()) ?>"<?= $Page->credit_limit->editAttributes() ?> aria-describedby="x_credit_limit_help">
<?= $Page->credit_limit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->credit_limit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monthly_payments->Visible) { // monthly_payments ?>
    <div id="r_monthly_payments"<?= $Page->monthly_payments->rowAttributes() ?>>
        <label id="elh_investor_verify_monthly_payments" for="x_monthly_payments" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monthly_payments->caption() ?><?= $Page->monthly_payments->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monthly_payments->cellAttributes() ?>>
<span id="el_investor_verify_monthly_payments">
<input type="<?= $Page->monthly_payments->getInputTextType() ?>" name="x_monthly_payments" id="x_monthly_payments" data-table="investor_verify" data-field="x_monthly_payments" value="<?= $Page->monthly_payments->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monthly_payments->getPlaceHolder()) ?>"<?= $Page->monthly_payments->editAttributes() ?> aria-describedby="x_monthly_payments_help">
<?= $Page->monthly_payments->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monthly_payments->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->highest_rental_price->Visible) { // highest_rental_price ?>
    <div id="r_highest_rental_price"<?= $Page->highest_rental_price->rowAttributes() ?>>
        <label id="elh_investor_verify_highest_rental_price" for="x_highest_rental_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->highest_rental_price->caption() ?><?= $Page->highest_rental_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->highest_rental_price->cellAttributes() ?>>
<span id="el_investor_verify_highest_rental_price">
<input type="<?= $Page->highest_rental_price->getInputTextType() ?>" name="x_highest_rental_price" id="x_highest_rental_price" data-table="investor_verify" data-field="x_highest_rental_price" value="<?= $Page->highest_rental_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->highest_rental_price->getPlaceHolder()) ?>"<?= $Page->highest_rental_price->editAttributes() ?> aria-describedby="x_highest_rental_price_help">
<?= $Page->highest_rental_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->highest_rental_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->transfer->Visible) { // transfer ?>
    <div id="r_transfer"<?= $Page->transfer->rowAttributes() ?>>
        <label id="elh_investor_verify_transfer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->transfer->caption() ?><?= $Page->transfer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->transfer->cellAttributes() ?>>
<span id="el_investor_verify_transfer">
<template id="tp_x_transfer">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="investor_verify" data-field="x_transfer" name="x_transfer" id="x_transfer"<?= $Page->transfer->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_transfer" class="ew-item-list"></div>
<selection-list hidden
    id="x_transfer"
    name="x_transfer"
    value="<?= HtmlEncode($Page->transfer->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_transfer"
    data-bs-target="dsl_x_transfer"
    data-repeatcolumn="5"
    class="form-control<?= $Page->transfer->isInvalidClass() ?>"
    data-table="investor_verify"
    data-field="x_transfer"
    data-value-separator="<?= $Page->transfer->displayValueSeparatorAttribute() ?>"
    <?= $Page->transfer->editAttributes() ?>></selection-list>
<?= $Page->transfer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->transfer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total_invertor_year->Visible) { // total_invertor_year ?>
    <div id="r_total_invertor_year"<?= $Page->total_invertor_year->rowAttributes() ?>>
        <label id="elh_investor_verify_total_invertor_year" for="x_total_invertor_year" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total_invertor_year->caption() ?><?= $Page->total_invertor_year->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total_invertor_year->cellAttributes() ?>>
<span id="el_investor_verify_total_invertor_year">
<input type="<?= $Page->total_invertor_year->getInputTextType() ?>" name="x_total_invertor_year" id="x_total_invertor_year" data-table="investor_verify" data-field="x_total_invertor_year" value="<?= $Page->total_invertor_year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->total_invertor_year->getPlaceHolder()) ?>"<?= $Page->total_invertor_year->editAttributes() ?> aria-describedby="x_total_invertor_year_help">
<?= $Page->total_invertor_year->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total_invertor_year->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invert_payoff_day->Visible) { // invert_payoff_day ?>
    <div id="r_invert_payoff_day"<?= $Page->invert_payoff_day->rowAttributes() ?>>
        <label id="elh_investor_verify_invert_payoff_day" for="x_invert_payoff_day" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invert_payoff_day->caption() ?><?= $Page->invert_payoff_day->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invert_payoff_day->cellAttributes() ?>>
<span id="el_investor_verify_invert_payoff_day">
<input type="<?= $Page->invert_payoff_day->getInputTextType() ?>" name="x_invert_payoff_day" id="x_invert_payoff_day" data-table="investor_verify" data-field="x_invert_payoff_day" value="<?= $Page->invert_payoff_day->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invert_payoff_day->getPlaceHolder()) ?>"<?= $Page->invert_payoff_day->editAttributes() ?> aria-describedby="x_invert_payoff_day_help">
<?= $Page->invert_payoff_day->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invert_payoff_day->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type_invertor->Visible) { // type_invertor ?>
    <div id="r_type_invertor"<?= $Page->type_invertor->rowAttributes() ?>>
        <label id="elh_investor_verify_type_invertor" for="x_type_invertor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type_invertor->caption() ?><?= $Page->type_invertor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type_invertor->cellAttributes() ?>>
<span id="el_investor_verify_type_invertor">
    <select
        id="x_type_invertor"
        name="x_type_invertor"
        class="form-select ew-select<?= $Page->type_invertor->isInvalidClass() ?>"
        data-select2-id="finvestor_verifyedit_x_type_invertor"
        data-table="investor_verify"
        data-field="x_type_invertor"
        data-value-separator="<?= $Page->type_invertor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->type_invertor->getPlaceHolder()) ?>"
        <?= $Page->type_invertor->editAttributes() ?>>
        <?= $Page->type_invertor->selectOptionListHtml("x_type_invertor") ?>
    </select>
    <?= $Page->type_invertor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->type_invertor->getErrorMessage() ?></div>
<script>
loadjs.ready("finvestor_verifyedit", function() {
    var options = { name: "x_type_invertor", selectId: "finvestor_verifyedit_x_type_invertor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (finvestor_verifyedit.lists.type_invertor.lookupOptions.length) {
        options.data = { id: "x_type_invertor", form: "finvestor_verifyedit" };
    } else {
        options.ajax = { id: "x_type_invertor", form: "finvestor_verifyedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.investor_verify.fields.type_invertor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invest_amount->Visible) { // invest_amount ?>
    <div id="r_invest_amount"<?= $Page->invest_amount->rowAttributes() ?>>
        <label id="elh_investor_verify_invest_amount" for="x_invest_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invest_amount->caption() ?><?= $Page->invest_amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invest_amount->cellAttributes() ?>>
<span id="el_investor_verify_invest_amount">
<input type="<?= $Page->invest_amount->getInputTextType() ?>" name="x_invest_amount" id="x_invest_amount" data-table="investor_verify" data-field="x_invest_amount" value="<?= $Page->invest_amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invest_amount->getPlaceHolder()) ?>"<?= $Page->invest_amount->editAttributes() ?> aria-describedby="x_invest_amount_help">
<?= $Page->invest_amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invest_amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="investor_verify" data-field="x_juzcalculator_id" data-hidden="1" name="x_juzcalculator_id" id="x_juzcalculator_id" value="<?= HtmlEncode($Page->juzcalculator_id->CurrentValue) ?>">
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
    ew.addEventHandlers("investor_verify");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
