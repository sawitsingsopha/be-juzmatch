<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch2Add = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch2: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch2add;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch2add = new ew.Form("fdoc_juzmatch2add", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fdoc_juzmatch2add;

    // Add fields
    var fields = currentTable.fields;
    fdoc_juzmatch2add.addFields([
        ["document_date", [fields.document_date.visible && fields.document_date.required ? ew.Validators.required(fields.document_date.caption) : null], fields.document_date.isInvalid],
        ["asset_code", [fields.asset_code.visible && fields.asset_code.required ? ew.Validators.required(fields.asset_code.caption) : null], fields.asset_code.isInvalid],
        ["asset_project", [fields.asset_project.visible && fields.asset_project.required ? ew.Validators.required(fields.asset_project.caption) : null], fields.asset_project.isInvalid],
        ["asset_deed", [fields.asset_deed.visible && fields.asset_deed.required ? ew.Validators.required(fields.asset_deed.caption) : null], fields.asset_deed.isInvalid],
        ["asset_area", [fields.asset_area.visible && fields.asset_area.required ? ew.Validators.required(fields.asset_area.caption) : null], fields.asset_area.isInvalid],
        ["investor_name", [fields.investor_name.visible && fields.investor_name.required ? ew.Validators.required(fields.investor_name.caption) : null], fields.investor_name.isInvalid],
        ["investor_lname", [fields.investor_lname.visible && fields.investor_lname.required ? ew.Validators.required(fields.investor_lname.caption) : null], fields.investor_lname.isInvalid],
        ["investor_email", [fields.investor_email.visible && fields.investor_email.required ? ew.Validators.required(fields.investor_email.caption) : null], fields.investor_email.isInvalid],
        ["investor_idcard", [fields.investor_idcard.visible && fields.investor_idcard.required ? ew.Validators.required(fields.investor_idcard.caption) : null], fields.investor_idcard.isInvalid],
        ["investor_homeno", [fields.investor_homeno.visible && fields.investor_homeno.required ? ew.Validators.required(fields.investor_homeno.caption) : null], fields.investor_homeno.isInvalid],
        ["investment_money", [fields.investment_money.visible && fields.investment_money.required ? ew.Validators.required(fields.investment_money.caption) : null, ew.Validators.float], fields.investment_money.isInvalid],
        ["investment_money_txt", [fields.investment_money_txt.visible && fields.investment_money_txt.required ? ew.Validators.required(fields.investment_money_txt.caption) : null], fields.investment_money_txt.isInvalid],
        ["loan_contact_date", [fields.loan_contact_date.visible && fields.loan_contact_date.required ? ew.Validators.required(fields.loan_contact_date.caption) : null, ew.Validators.datetime(fields.loan_contact_date.clientFormatPattern)], fields.loan_contact_date.isInvalid],
        ["contract_expired", [fields.contract_expired.visible && fields.contract_expired.required ? ew.Validators.required(fields.contract_expired.caption) : null, ew.Validators.datetime(fields.contract_expired.clientFormatPattern)], fields.contract_expired.isInvalid],
        ["first_benefits_month", [fields.first_benefits_month.visible && fields.first_benefits_month.required ? ew.Validators.required(fields.first_benefits_month.caption) : null, ew.Validators.integer], fields.first_benefits_month.isInvalid],
        ["one_installment_amount", [fields.one_installment_amount.visible && fields.one_installment_amount.required ? ew.Validators.required(fields.one_installment_amount.caption) : null, ew.Validators.float], fields.one_installment_amount.isInvalid],
        ["two_installment_amount1", [fields.two_installment_amount1.visible && fields.two_installment_amount1.required ? ew.Validators.required(fields.two_installment_amount1.caption) : null, ew.Validators.float], fields.two_installment_amount1.isInvalid],
        ["two_installment_amount2", [fields.two_installment_amount2.visible && fields.two_installment_amount2.required ? ew.Validators.required(fields.two_installment_amount2.caption) : null, ew.Validators.float], fields.two_installment_amount2.isInvalid],
        ["investor_paid_amount", [fields.investor_paid_amount.visible && fields.investor_paid_amount.required ? ew.Validators.required(fields.investor_paid_amount.caption) : null, ew.Validators.float], fields.investor_paid_amount.isInvalid],
        ["first_benefits_date", [fields.first_benefits_date.visible && fields.first_benefits_date.required ? ew.Validators.required(fields.first_benefits_date.caption) : null, ew.Validators.datetime(fields.first_benefits_date.clientFormatPattern)], fields.first_benefits_date.isInvalid],
        ["one_benefit_amount", [fields.one_benefit_amount.visible && fields.one_benefit_amount.required ? ew.Validators.required(fields.one_benefit_amount.caption) : null, ew.Validators.float], fields.one_benefit_amount.isInvalid],
        ["two_benefit_amount1", [fields.two_benefit_amount1.visible && fields.two_benefit_amount1.required ? ew.Validators.required(fields.two_benefit_amount1.caption) : null, ew.Validators.float], fields.two_benefit_amount1.isInvalid],
        ["two_benefit_amount2", [fields.two_benefit_amount2.visible && fields.two_benefit_amount2.required ? ew.Validators.required(fields.two_benefit_amount2.caption) : null, ew.Validators.float], fields.two_benefit_amount2.isInvalid],
        ["management_agent_date", [fields.management_agent_date.visible && fields.management_agent_date.required ? ew.Validators.required(fields.management_agent_date.caption) : null, ew.Validators.datetime(fields.management_agent_date.clientFormatPattern)], fields.management_agent_date.isInvalid],
        ["begin_date", [fields.begin_date.visible && fields.begin_date.required ? ew.Validators.required(fields.begin_date.caption) : null, ew.Validators.integer], fields.begin_date.isInvalid],
        ["investor_witness_name", [fields.investor_witness_name.visible && fields.investor_witness_name.required ? ew.Validators.required(fields.investor_witness_name.caption) : null], fields.investor_witness_name.isInvalid],
        ["investor_witness_lname", [fields.investor_witness_lname.visible && fields.investor_witness_lname.required ? ew.Validators.required(fields.investor_witness_lname.caption) : null], fields.investor_witness_lname.isInvalid],
        ["investor_witness_email", [fields.investor_witness_email.visible && fields.investor_witness_email.required ? ew.Validators.required(fields.investor_witness_email.caption) : null], fields.investor_witness_email.isInvalid],
        ["juzmatch_authority_name", [fields.juzmatch_authority_name.visible && fields.juzmatch_authority_name.required ? ew.Validators.required(fields.juzmatch_authority_name.caption) : null], fields.juzmatch_authority_name.isInvalid],
        ["juzmatch_authority_lname", [fields.juzmatch_authority_lname.visible && fields.juzmatch_authority_lname.required ? ew.Validators.required(fields.juzmatch_authority_lname.caption) : null], fields.juzmatch_authority_lname.isInvalid],
        ["juzmatch_authority_email", [fields.juzmatch_authority_email.visible && fields.juzmatch_authority_email.required ? ew.Validators.required(fields.juzmatch_authority_email.caption) : null], fields.juzmatch_authority_email.isInvalid],
        ["juzmatch_authority_witness_name", [fields.juzmatch_authority_witness_name.visible && fields.juzmatch_authority_witness_name.required ? ew.Validators.required(fields.juzmatch_authority_witness_name.caption) : null], fields.juzmatch_authority_witness_name.isInvalid],
        ["juzmatch_authority_witness_lname", [fields.juzmatch_authority_witness_lname.visible && fields.juzmatch_authority_witness_lname.required ? ew.Validators.required(fields.juzmatch_authority_witness_lname.caption) : null], fields.juzmatch_authority_witness_lname.isInvalid],
        ["juzmatch_authority_witness_email", [fields.juzmatch_authority_witness_email.visible && fields.juzmatch_authority_witness_email.required ? ew.Validators.required(fields.juzmatch_authority_witness_email.caption) : null], fields.juzmatch_authority_witness_email.isInvalid],
        ["juzmatch_authority2_name", [fields.juzmatch_authority2_name.visible && fields.juzmatch_authority2_name.required ? ew.Validators.required(fields.juzmatch_authority2_name.caption) : null], fields.juzmatch_authority2_name.isInvalid],
        ["juzmatch_authority2_lname", [fields.juzmatch_authority2_lname.visible && fields.juzmatch_authority2_lname.required ? ew.Validators.required(fields.juzmatch_authority2_lname.caption) : null], fields.juzmatch_authority2_lname.isInvalid],
        ["juzmatch_authority2_email", [fields.juzmatch_authority2_email.visible && fields.juzmatch_authority2_email.required ? ew.Validators.required(fields.juzmatch_authority2_email.caption) : null], fields.juzmatch_authority2_email.isInvalid],
        ["company_seal_name", [fields.company_seal_name.visible && fields.company_seal_name.required ? ew.Validators.required(fields.company_seal_name.caption) : null], fields.company_seal_name.isInvalid],
        ["company_seal_email", [fields.company_seal_email.visible && fields.company_seal_email.required ? ew.Validators.required(fields.company_seal_email.caption) : null], fields.company_seal_email.isInvalid],
        ["file_idcard", [fields.file_idcard.visible && fields.file_idcard.required ? ew.Validators.fileRequired(fields.file_idcard.caption) : null], fields.file_idcard.isInvalid],
        ["file_house_regis", [fields.file_house_regis.visible && fields.file_house_regis.required ? ew.Validators.fileRequired(fields.file_house_regis.caption) : null], fields.file_house_regis.isInvalid],
        ["file_other", [fields.file_other.visible && fields.file_other.required ? ew.Validators.fileRequired(fields.file_other.caption) : null], fields.file_other.isInvalid],
        ["contact_address", [fields.contact_address.visible && fields.contact_address.required ? ew.Validators.required(fields.contact_address.caption) : null], fields.contact_address.isInvalid],
        ["contact_address2", [fields.contact_address2.visible && fields.contact_address2.required ? ew.Validators.required(fields.contact_address2.caption) : null], fields.contact_address2.isInvalid],
        ["contact_email", [fields.contact_email.visible && fields.contact_email.required ? ew.Validators.required(fields.contact_email.caption) : null], fields.contact_email.isInvalid],
        ["contact_lineid", [fields.contact_lineid.visible && fields.contact_lineid.required ? ew.Validators.required(fields.contact_lineid.caption) : null], fields.contact_lineid.isInvalid],
        ["contact_phone", [fields.contact_phone.visible && fields.contact_phone.required ? ew.Validators.required(fields.contact_phone.caption) : null], fields.contact_phone.isInvalid],
        ["file_loan", [fields.file_loan.visible && fields.file_loan.required ? ew.Validators.required(fields.file_loan.caption) : null], fields.file_loan.isInvalid],
        ["attach_file", [fields.attach_file.visible && fields.attach_file.required ? ew.Validators.required(fields.attach_file.caption) : null], fields.attach_file.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["doc_date", [fields.doc_date.visible && fields.doc_date.required ? ew.Validators.required(fields.doc_date.caption) : null], fields.doc_date.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_juzmatch2add.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_juzmatch2add.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fdoc_juzmatch2add.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fdoc_juzmatch2add");
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
<form name="fdoc_juzmatch2add" id="fdoc_juzmatch2add" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch2">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "invertor_all_booking") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invertor_all_booking">
<input type="hidden" name="fk_invertor_booking_id" value="<?= HtmlEncode($Page->investor_booking_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <div id="r_asset_code"<?= $Page->asset_code->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_asset_code" for="x_asset_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_code->caption() ?><?= $Page->asset_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_code->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_code">
<input type="<?= $Page->asset_code->getInputTextType() ?>" name="x_asset_code" id="x_asset_code" data-table="doc_juzmatch2" data-field="x_asset_code" value="<?= $Page->asset_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_code->getPlaceHolder()) ?>"<?= $Page->asset_code->editAttributes() ?> aria-describedby="x_asset_code_help">
<?= $Page->asset_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
    <div id="r_asset_project"<?= $Page->asset_project->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_asset_project" for="x_asset_project" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_project->caption() ?><?= $Page->asset_project->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_project->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_project">
<input type="<?= $Page->asset_project->getInputTextType() ?>" name="x_asset_project" id="x_asset_project" data-table="doc_juzmatch2" data-field="x_asset_project" value="<?= $Page->asset_project->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_project->getPlaceHolder()) ?>"<?= $Page->asset_project->editAttributes() ?> aria-describedby="x_asset_project_help">
<?= $Page->asset_project->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_project->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
    <div id="r_asset_deed"<?= $Page->asset_deed->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_asset_deed" for="x_asset_deed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_deed->caption() ?><?= $Page->asset_deed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_deed">
<input type="<?= $Page->asset_deed->getInputTextType() ?>" name="x_asset_deed" id="x_asset_deed" data-table="doc_juzmatch2" data-field="x_asset_deed" value="<?= $Page->asset_deed->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_deed->getPlaceHolder()) ?>"<?= $Page->asset_deed->editAttributes() ?> aria-describedby="x_asset_deed_help">
<?= $Page->asset_deed->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_deed->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
    <div id="r_asset_area"<?= $Page->asset_area->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_asset_area" for="x_asset_area" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_area->caption() ?><?= $Page->asset_area->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_area->cellAttributes() ?>>
<span id="el_doc_juzmatch2_asset_area">
<input type="<?= $Page->asset_area->getInputTextType() ?>" name="x_asset_area" id="x_asset_area" data-table="doc_juzmatch2" data-field="x_asset_area" value="<?= $Page->asset_area->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_area->getPlaceHolder()) ?>"<?= $Page->asset_area->editAttributes() ?> aria-describedby="x_asset_area_help">
<?= $Page->asset_area->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_area->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_name->Visible) { // investor_name ?>
    <div id="r_investor_name"<?= $Page->investor_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_name" for="x_investor_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_name->caption() ?><?= $Page->investor_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_name">
<input type="<?= $Page->investor_name->getInputTextType() ?>" name="x_investor_name" id="x_investor_name" data-table="doc_juzmatch2" data-field="x_investor_name" value="<?= $Page->investor_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_name->getPlaceHolder()) ?>"<?= $Page->investor_name->editAttributes() ?> aria-describedby="x_investor_name_help">
<?= $Page->investor_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
    <div id="r_investor_lname"<?= $Page->investor_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_lname" for="x_investor_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_lname->caption() ?><?= $Page->investor_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_lname">
<input type="<?= $Page->investor_lname->getInputTextType() ?>" name="x_investor_lname" id="x_investor_lname" data-table="doc_juzmatch2" data-field="x_investor_lname" value="<?= $Page->investor_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_lname->getPlaceHolder()) ?>"<?= $Page->investor_lname->editAttributes() ?> aria-describedby="x_investor_lname_help">
<?= $Page->investor_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
    <div id="r_investor_email"<?= $Page->investor_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_email" for="x_investor_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_email->caption() ?><?= $Page->investor_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_email">
<input type="<?= $Page->investor_email->getInputTextType() ?>" name="x_investor_email" id="x_investor_email" data-table="doc_juzmatch2" data-field="x_investor_email" value="<?= $Page->investor_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_email->getPlaceHolder()) ?>"<?= $Page->investor_email->editAttributes() ?> aria-describedby="x_investor_email_help">
<?= $Page->investor_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_idcard->Visible) { // investor_idcard ?>
    <div id="r_investor_idcard"<?= $Page->investor_idcard->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_idcard" for="x_investor_idcard" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_idcard->caption() ?><?= $Page->investor_idcard->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_idcard">
<input type="<?= $Page->investor_idcard->getInputTextType() ?>" name="x_investor_idcard" id="x_investor_idcard" data-table="doc_juzmatch2" data-field="x_investor_idcard" value="<?= $Page->investor_idcard->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_idcard->getPlaceHolder()) ?>"<?= $Page->investor_idcard->editAttributes() ?> aria-describedby="x_investor_idcard_help">
<?= $Page->investor_idcard->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_idcard->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_homeno->Visible) { // investor_homeno ?>
    <div id="r_investor_homeno"<?= $Page->investor_homeno->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_homeno" for="x_investor_homeno" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_homeno->caption() ?><?= $Page->investor_homeno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_homeno->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_homeno">
<input type="<?= $Page->investor_homeno->getInputTextType() ?>" name="x_investor_homeno" id="x_investor_homeno" data-table="doc_juzmatch2" data-field="x_investor_homeno" value="<?= $Page->investor_homeno->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_homeno->getPlaceHolder()) ?>"<?= $Page->investor_homeno->editAttributes() ?> aria-describedby="x_investor_homeno_help">
<?= $Page->investor_homeno->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_homeno->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investment_money->Visible) { // investment_money ?>
    <div id="r_investment_money"<?= $Page->investment_money->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investment_money" for="x_investment_money" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investment_money->caption() ?><?= $Page->investment_money->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investment_money->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investment_money">
<input type="<?= $Page->investment_money->getInputTextType() ?>" name="x_investment_money" id="x_investment_money" data-table="doc_juzmatch2" data-field="x_investment_money" value="<?= $Page->investment_money->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->investment_money->getPlaceHolder()) ?>"<?= $Page->investment_money->editAttributes() ?> aria-describedby="x_investment_money_help">
<?= $Page->investment_money->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investment_money->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investment_money_txt->Visible) { // investment_money_txt ?>
    <div id="r_investment_money_txt"<?= $Page->investment_money_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investment_money_txt" for="x_investment_money_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investment_money_txt->caption() ?><?= $Page->investment_money_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investment_money_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investment_money_txt">
<input type="<?= $Page->investment_money_txt->getInputTextType() ?>" name="x_investment_money_txt" id="x_investment_money_txt" data-table="doc_juzmatch2" data-field="x_investment_money_txt" value="<?= $Page->investment_money_txt->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->investment_money_txt->getPlaceHolder()) ?>"<?= $Page->investment_money_txt->editAttributes() ?> aria-describedby="x_investment_money_txt_help">
<?= $Page->investment_money_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investment_money_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->loan_contact_date->Visible) { // loan_contact_date ?>
    <div id="r_loan_contact_date"<?= $Page->loan_contact_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_loan_contact_date" for="x_loan_contact_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->loan_contact_date->caption() ?><?= $Page->loan_contact_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->loan_contact_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_loan_contact_date">
<input type="<?= $Page->loan_contact_date->getInputTextType() ?>" name="x_loan_contact_date" id="x_loan_contact_date" data-table="doc_juzmatch2" data-field="x_loan_contact_date" value="<?= $Page->loan_contact_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->loan_contact_date->getPlaceHolder()) ?>"<?= $Page->loan_contact_date->editAttributes() ?> aria-describedby="x_loan_contact_date_help">
<?= $Page->loan_contact_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->loan_contact_date->getErrorMessage() ?></div>
<?php if (!$Page->loan_contact_date->ReadOnly && !$Page->loan_contact_date->Disabled && !isset($Page->loan_contact_date->EditAttrs["readonly"]) && !isset($Page->loan_contact_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch2add", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fdoc_juzmatch2add", "x_loan_contact_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contract_expired->Visible) { // contract_expired ?>
    <div id="r_contract_expired"<?= $Page->contract_expired->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_contract_expired" for="x_contract_expired" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contract_expired->caption() ?><?= $Page->contract_expired->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contract_expired->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contract_expired">
<input type="<?= $Page->contract_expired->getInputTextType() ?>" name="x_contract_expired" id="x_contract_expired" data-table="doc_juzmatch2" data-field="x_contract_expired" value="<?= $Page->contract_expired->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->contract_expired->getPlaceHolder()) ?>"<?= $Page->contract_expired->editAttributes() ?> aria-describedby="x_contract_expired_help">
<?= $Page->contract_expired->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contract_expired->getErrorMessage() ?></div>
<?php if (!$Page->contract_expired->ReadOnly && !$Page->contract_expired->Disabled && !isset($Page->contract_expired->EditAttrs["readonly"]) && !isset($Page->contract_expired->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch2add", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fdoc_juzmatch2add", "x_contract_expired", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->first_benefits_month->Visible) { // first_benefits_month ?>
    <div id="r_first_benefits_month"<?= $Page->first_benefits_month->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_first_benefits_month" for="x_first_benefits_month" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_benefits_month->caption() ?><?= $Page->first_benefits_month->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_benefits_month->cellAttributes() ?>>
<span id="el_doc_juzmatch2_first_benefits_month">
<input type="<?= $Page->first_benefits_month->getInputTextType() ?>" name="x_first_benefits_month" id="x_first_benefits_month" data-table="doc_juzmatch2" data-field="x_first_benefits_month" value="<?= $Page->first_benefits_month->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->first_benefits_month->getPlaceHolder()) ?>"<?= $Page->first_benefits_month->editAttributes() ?> aria-describedby="x_first_benefits_month_help">
<?= $Page->first_benefits_month->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_benefits_month->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->one_installment_amount->Visible) { // one_installment_amount ?>
    <div id="r_one_installment_amount"<?= $Page->one_installment_amount->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_one_installment_amount" for="x_one_installment_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->one_installment_amount->caption() ?><?= $Page->one_installment_amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->one_installment_amount->cellAttributes() ?>>
<span id="el_doc_juzmatch2_one_installment_amount">
<input type="<?= $Page->one_installment_amount->getInputTextType() ?>" name="x_one_installment_amount" id="x_one_installment_amount" data-table="doc_juzmatch2" data-field="x_one_installment_amount" value="<?= $Page->one_installment_amount->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->one_installment_amount->getPlaceHolder()) ?>"<?= $Page->one_installment_amount->editAttributes() ?> aria-describedby="x_one_installment_amount_help">
<?= $Page->one_installment_amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->one_installment_amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->two_installment_amount1->Visible) { // two_installment_amount1 ?>
    <div id="r_two_installment_amount1"<?= $Page->two_installment_amount1->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_two_installment_amount1" for="x_two_installment_amount1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->two_installment_amount1->caption() ?><?= $Page->two_installment_amount1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->two_installment_amount1->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_installment_amount1">
<input type="<?= $Page->two_installment_amount1->getInputTextType() ?>" name="x_two_installment_amount1" id="x_two_installment_amount1" data-table="doc_juzmatch2" data-field="x_two_installment_amount1" value="<?= $Page->two_installment_amount1->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->two_installment_amount1->getPlaceHolder()) ?>"<?= $Page->two_installment_amount1->editAttributes() ?> aria-describedby="x_two_installment_amount1_help">
<?= $Page->two_installment_amount1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->two_installment_amount1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->two_installment_amount2->Visible) { // two_installment_amount2 ?>
    <div id="r_two_installment_amount2"<?= $Page->two_installment_amount2->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_two_installment_amount2" for="x_two_installment_amount2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->two_installment_amount2->caption() ?><?= $Page->two_installment_amount2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->two_installment_amount2->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_installment_amount2">
<input type="<?= $Page->two_installment_amount2->getInputTextType() ?>" name="x_two_installment_amount2" id="x_two_installment_amount2" data-table="doc_juzmatch2" data-field="x_two_installment_amount2" value="<?= $Page->two_installment_amount2->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->two_installment_amount2->getPlaceHolder()) ?>"<?= $Page->two_installment_amount2->editAttributes() ?> aria-describedby="x_two_installment_amount2_help">
<?= $Page->two_installment_amount2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->two_installment_amount2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_paid_amount->Visible) { // investor_paid_amount ?>
    <div id="r_investor_paid_amount"<?= $Page->investor_paid_amount->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_paid_amount" for="x_investor_paid_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_paid_amount->caption() ?><?= $Page->investor_paid_amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_paid_amount->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_paid_amount">
<input type="<?= $Page->investor_paid_amount->getInputTextType() ?>" name="x_investor_paid_amount" id="x_investor_paid_amount" data-table="doc_juzmatch2" data-field="x_investor_paid_amount" value="<?= $Page->investor_paid_amount->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->investor_paid_amount->getPlaceHolder()) ?>"<?= $Page->investor_paid_amount->editAttributes() ?> aria-describedby="x_investor_paid_amount_help">
<?= $Page->investor_paid_amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_paid_amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->first_benefits_date->Visible) { // first_benefits_date ?>
    <div id="r_first_benefits_date"<?= $Page->first_benefits_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_first_benefits_date" for="x_first_benefits_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_benefits_date->caption() ?><?= $Page->first_benefits_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_benefits_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_first_benefits_date">
<input type="<?= $Page->first_benefits_date->getInputTextType() ?>" name="x_first_benefits_date" id="x_first_benefits_date" data-table="doc_juzmatch2" data-field="x_first_benefits_date" value="<?= $Page->first_benefits_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->first_benefits_date->getPlaceHolder()) ?>"<?= $Page->first_benefits_date->editAttributes() ?> aria-describedby="x_first_benefits_date_help">
<?= $Page->first_benefits_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_benefits_date->getErrorMessage() ?></div>
<?php if (!$Page->first_benefits_date->ReadOnly && !$Page->first_benefits_date->Disabled && !isset($Page->first_benefits_date->EditAttrs["readonly"]) && !isset($Page->first_benefits_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch2add", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fdoc_juzmatch2add", "x_first_benefits_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->one_benefit_amount->Visible) { // one_benefit_amount ?>
    <div id="r_one_benefit_amount"<?= $Page->one_benefit_amount->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_one_benefit_amount" for="x_one_benefit_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->one_benefit_amount->caption() ?><?= $Page->one_benefit_amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->one_benefit_amount->cellAttributes() ?>>
<span id="el_doc_juzmatch2_one_benefit_amount">
<input type="<?= $Page->one_benefit_amount->getInputTextType() ?>" name="x_one_benefit_amount" id="x_one_benefit_amount" data-table="doc_juzmatch2" data-field="x_one_benefit_amount" value="<?= $Page->one_benefit_amount->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->one_benefit_amount->getPlaceHolder()) ?>"<?= $Page->one_benefit_amount->editAttributes() ?> aria-describedby="x_one_benefit_amount_help">
<?= $Page->one_benefit_amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->one_benefit_amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->two_benefit_amount1->Visible) { // two_benefit_amount1 ?>
    <div id="r_two_benefit_amount1"<?= $Page->two_benefit_amount1->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_two_benefit_amount1" for="x_two_benefit_amount1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->two_benefit_amount1->caption() ?><?= $Page->two_benefit_amount1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->two_benefit_amount1->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_benefit_amount1">
<input type="<?= $Page->two_benefit_amount1->getInputTextType() ?>" name="x_two_benefit_amount1" id="x_two_benefit_amount1" data-table="doc_juzmatch2" data-field="x_two_benefit_amount1" value="<?= $Page->two_benefit_amount1->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->two_benefit_amount1->getPlaceHolder()) ?>"<?= $Page->two_benefit_amount1->editAttributes() ?> aria-describedby="x_two_benefit_amount1_help">
<?= $Page->two_benefit_amount1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->two_benefit_amount1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->two_benefit_amount2->Visible) { // two_benefit_amount2 ?>
    <div id="r_two_benefit_amount2"<?= $Page->two_benefit_amount2->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_two_benefit_amount2" for="x_two_benefit_amount2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->two_benefit_amount2->caption() ?><?= $Page->two_benefit_amount2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->two_benefit_amount2->cellAttributes() ?>>
<span id="el_doc_juzmatch2_two_benefit_amount2">
<input type="<?= $Page->two_benefit_amount2->getInputTextType() ?>" name="x_two_benefit_amount2" id="x_two_benefit_amount2" data-table="doc_juzmatch2" data-field="x_two_benefit_amount2" value="<?= $Page->two_benefit_amount2->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->two_benefit_amount2->getPlaceHolder()) ?>"<?= $Page->two_benefit_amount2->editAttributes() ?> aria-describedby="x_two_benefit_amount2_help">
<?= $Page->two_benefit_amount2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->two_benefit_amount2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->management_agent_date->Visible) { // management_agent_date ?>
    <div id="r_management_agent_date"<?= $Page->management_agent_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_management_agent_date" for="x_management_agent_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->management_agent_date->caption() ?><?= $Page->management_agent_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->management_agent_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_management_agent_date">
<input type="<?= $Page->management_agent_date->getInputTextType() ?>" name="x_management_agent_date" id="x_management_agent_date" data-table="doc_juzmatch2" data-field="x_management_agent_date" value="<?= $Page->management_agent_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->management_agent_date->getPlaceHolder()) ?>"<?= $Page->management_agent_date->editAttributes() ?> aria-describedby="x_management_agent_date_help">
<?= $Page->management_agent_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->management_agent_date->getErrorMessage() ?></div>
<?php if (!$Page->management_agent_date->ReadOnly && !$Page->management_agent_date->Disabled && !isset($Page->management_agent_date->EditAttrs["readonly"]) && !isset($Page->management_agent_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch2add", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fdoc_juzmatch2add", "x_management_agent_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->begin_date->Visible) { // begin_date ?>
    <div id="r_begin_date"<?= $Page->begin_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_begin_date" for="x_begin_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->begin_date->caption() ?><?= $Page->begin_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->begin_date->cellAttributes() ?>>
<span id="el_doc_juzmatch2_begin_date">
<input type="<?= $Page->begin_date->getInputTextType() ?>" name="x_begin_date" id="x_begin_date" data-table="doc_juzmatch2" data-field="x_begin_date" value="<?= $Page->begin_date->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->begin_date->getPlaceHolder()) ?>"<?= $Page->begin_date->editAttributes() ?> aria-describedby="x_begin_date_help">
<?= $Page->begin_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->begin_date->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_witness_name->Visible) { // investor_witness_name ?>
    <div id="r_investor_witness_name"<?= $Page->investor_witness_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_witness_name" for="x_investor_witness_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_witness_name->caption() ?><?= $Page->investor_witness_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_witness_name">
<input type="<?= $Page->investor_witness_name->getInputTextType() ?>" name="x_investor_witness_name" id="x_investor_witness_name" data-table="doc_juzmatch2" data-field="x_investor_witness_name" value="<?= $Page->investor_witness_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->investor_witness_name->getPlaceHolder()) ?>"<?= $Page->investor_witness_name->editAttributes() ?> aria-describedby="x_investor_witness_name_help">
<?= $Page->investor_witness_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_witness_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_witness_lname->Visible) { // investor_witness_lname ?>
    <div id="r_investor_witness_lname"<?= $Page->investor_witness_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_witness_lname" for="x_investor_witness_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_witness_lname->caption() ?><?= $Page->investor_witness_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_witness_lname">
<input type="<?= $Page->investor_witness_lname->getInputTextType() ?>" name="x_investor_witness_lname" id="x_investor_witness_lname" data-table="doc_juzmatch2" data-field="x_investor_witness_lname" value="<?= $Page->investor_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_witness_lname->getPlaceHolder()) ?>"<?= $Page->investor_witness_lname->editAttributes() ?> aria-describedby="x_investor_witness_lname_help">
<?= $Page->investor_witness_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_witness_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_witness_email->Visible) { // investor_witness_email ?>
    <div id="r_investor_witness_email"<?= $Page->investor_witness_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_investor_witness_email" for="x_investor_witness_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_witness_email->caption() ?><?= $Page->investor_witness_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_investor_witness_email">
<input type="<?= $Page->investor_witness_email->getInputTextType() ?>" name="x_investor_witness_email" id="x_investor_witness_email" data-table="doc_juzmatch2" data-field="x_investor_witness_email" value="<?= $Page->investor_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_witness_email->getPlaceHolder()) ?>"<?= $Page->investor_witness_email->editAttributes() ?> aria-describedby="x_investor_witness_email_help">
<?= $Page->investor_witness_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_witness_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_name->Visible) { // juzmatch_authority_name ?>
    <div id="r_juzmatch_authority_name"<?= $Page->juzmatch_authority_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority_name" for="x_juzmatch_authority_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_name->caption() ?><?= $Page->juzmatch_authority_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_name">
<input type="<?= $Page->juzmatch_authority_name->getInputTextType() ?>" name="x_juzmatch_authority_name" id="x_juzmatch_authority_name" data-table="doc_juzmatch2" data-field="x_juzmatch_authority_name" value="<?= $Page->juzmatch_authority_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_name->editAttributes() ?> aria-describedby="x_juzmatch_authority_name_help">
<?= $Page->juzmatch_authority_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
    <div id="r_juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority_lname" for="x_juzmatch_authority_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_lname->caption() ?><?= $Page->juzmatch_authority_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_lname">
<input type="<?= $Page->juzmatch_authority_lname->getInputTextType() ?>" name="x_juzmatch_authority_lname" id="x_juzmatch_authority_lname" data-table="doc_juzmatch2" data-field="x_juzmatch_authority_lname" value="<?= $Page->juzmatch_authority_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority_lname_help">
<?= $Page->juzmatch_authority_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
    <div id="r_juzmatch_authority_email"<?= $Page->juzmatch_authority_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority_email" for="x_juzmatch_authority_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_email->caption() ?><?= $Page->juzmatch_authority_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_email">
<input type="<?= $Page->juzmatch_authority_email->getInputTextType() ?>" name="x_juzmatch_authority_email" id="x_juzmatch_authority_email" data-table="doc_juzmatch2" data-field="x_juzmatch_authority_email" value="<?= $Page->juzmatch_authority_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_email->editAttributes() ?> aria-describedby="x_juzmatch_authority_email_help">
<?= $Page->juzmatch_authority_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_name->Visible) { // juzmatch_authority_witness_name ?>
    <div id="r_juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority_witness_name" for="x_juzmatch_authority_witness_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_name->caption() ?><?= $Page->juzmatch_authority_witness_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_witness_name">
<input type="<?= $Page->juzmatch_authority_witness_name->getInputTextType() ?>" name="x_juzmatch_authority_witness_name" id="x_juzmatch_authority_witness_name" data-table="doc_juzmatch2" data-field="x_juzmatch_authority_witness_name" value="<?= $Page->juzmatch_authority_witness_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_name->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_name_help">
<?= $Page->juzmatch_authority_witness_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
    <div id="r_juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority_witness_lname" for="x_juzmatch_authority_witness_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_lname->caption() ?><?= $Page->juzmatch_authority_witness_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_witness_lname">
<input type="<?= $Page->juzmatch_authority_witness_lname->getInputTextType() ?>" name="x_juzmatch_authority_witness_lname" id="x_juzmatch_authority_witness_lname" data-table="doc_juzmatch2" data-field="x_juzmatch_authority_witness_lname" value="<?= $Page->juzmatch_authority_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_lname_help">
<?= $Page->juzmatch_authority_witness_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
    <div id="r_juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority_witness_email" for="x_juzmatch_authority_witness_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_email->caption() ?><?= $Page->juzmatch_authority_witness_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority_witness_email">
<input type="<?= $Page->juzmatch_authority_witness_email->getInputTextType() ?>" name="x_juzmatch_authority_witness_email" id="x_juzmatch_authority_witness_email" data-table="doc_juzmatch2" data-field="x_juzmatch_authority_witness_email" value="<?= $Page->juzmatch_authority_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_email->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_email_help">
<?= $Page->juzmatch_authority_witness_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
    <div id="r_juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority2_name" for="x_juzmatch_authority2_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_name->caption() ?><?= $Page->juzmatch_authority2_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority2_name">
<input type="<?= $Page->juzmatch_authority2_name->getInputTextType() ?>" name="x_juzmatch_authority2_name" id="x_juzmatch_authority2_name" data-table="doc_juzmatch2" data-field="x_juzmatch_authority2_name" value="<?= $Page->juzmatch_authority2_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_name->editAttributes() ?> aria-describedby="x_juzmatch_authority2_name_help">
<?= $Page->juzmatch_authority2_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
    <div id="r_juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority2_lname" for="x_juzmatch_authority2_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_lname->caption() ?><?= $Page->juzmatch_authority2_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority2_lname">
<input type="<?= $Page->juzmatch_authority2_lname->getInputTextType() ?>" name="x_juzmatch_authority2_lname" id="x_juzmatch_authority2_lname" data-table="doc_juzmatch2" data-field="x_juzmatch_authority2_lname" value="<?= $Page->juzmatch_authority2_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority2_lname_help">
<?= $Page->juzmatch_authority2_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
    <div id="r_juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_juzmatch_authority2_email" for="x_juzmatch_authority2_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_email->caption() ?><?= $Page->juzmatch_authority2_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_juzmatch_authority2_email">
<input type="<?= $Page->juzmatch_authority2_email->getInputTextType() ?>" name="x_juzmatch_authority2_email" id="x_juzmatch_authority2_email" data-table="doc_juzmatch2" data-field="x_juzmatch_authority2_email" value="<?= $Page->juzmatch_authority2_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_email->editAttributes() ?> aria-describedby="x_juzmatch_authority2_email_help">
<?= $Page->juzmatch_authority2_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
    <div id="r_company_seal_name"<?= $Page->company_seal_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_company_seal_name" for="x_company_seal_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_seal_name->caption() ?><?= $Page->company_seal_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el_doc_juzmatch2_company_seal_name">
<input type="<?= $Page->company_seal_name->getInputTextType() ?>" name="x_company_seal_name" id="x_company_seal_name" data-table="doc_juzmatch2" data-field="x_company_seal_name" value="<?= $Page->company_seal_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->company_seal_name->getPlaceHolder()) ?>"<?= $Page->company_seal_name->editAttributes() ?> aria-describedby="x_company_seal_name_help">
<?= $Page->company_seal_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_seal_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
    <div id="r_company_seal_email"<?= $Page->company_seal_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_company_seal_email" for="x_company_seal_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_seal_email->caption() ?><?= $Page->company_seal_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_company_seal_email">
<input type="<?= $Page->company_seal_email->getInputTextType() ?>" name="x_company_seal_email" id="x_company_seal_email" data-table="doc_juzmatch2" data-field="x_company_seal_email" value="<?= $Page->company_seal_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->company_seal_email->getPlaceHolder()) ?>"<?= $Page->company_seal_email->editAttributes() ?> aria-describedby="x_company_seal_email_help">
<?= $Page->company_seal_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_seal_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file_idcard->Visible) { // file_idcard ?>
    <div id="r_file_idcard"<?= $Page->file_idcard->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_file_idcard" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_idcard->caption() ?><?= $Page->file_idcard->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_idcard">
<div id="fd_x_file_idcard" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_idcard->title() ?>" data-table="doc_juzmatch2" data-field="x_file_idcard" name="x_file_idcard" id="x_file_idcard" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_idcard->editAttributes() ?> aria-describedby="x_file_idcard_help"<?= ($Page->file_idcard->ReadOnly || $Page->file_idcard->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_idcard->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_idcard->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_idcard" id= "fn_x_file_idcard" value="<?= $Page->file_idcard->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_idcard" id= "fa_x_file_idcard" value="0">
<input type="hidden" name="fs_x_file_idcard" id= "fs_x_file_idcard" value="250">
<input type="hidden" name="fx_x_file_idcard" id= "fx_x_file_idcard" value="<?= $Page->file_idcard->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_idcard" id= "fm_x_file_idcard" value="<?= $Page->file_idcard->UploadMaxFileSize ?>">
<table id="ft_x_file_idcard" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file_house_regis->Visible) { // file_house_regis ?>
    <div id="r_file_house_regis"<?= $Page->file_house_regis->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_file_house_regis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_house_regis->caption() ?><?= $Page->file_house_regis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_house_regis->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_house_regis">
<div id="fd_x_file_house_regis" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_house_regis->title() ?>" data-table="doc_juzmatch2" data-field="x_file_house_regis" name="x_file_house_regis" id="x_file_house_regis" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_house_regis->editAttributes() ?> aria-describedby="x_file_house_regis_help"<?= ($Page->file_house_regis->ReadOnly || $Page->file_house_regis->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_house_regis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_house_regis->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_house_regis" id= "fn_x_file_house_regis" value="<?= $Page->file_house_regis->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_house_regis" id= "fa_x_file_house_regis" value="0">
<input type="hidden" name="fs_x_file_house_regis" id= "fs_x_file_house_regis" value="250">
<input type="hidden" name="fx_x_file_house_regis" id= "fx_x_file_house_regis" value="<?= $Page->file_house_regis->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_house_regis" id= "fm_x_file_house_regis" value="<?= $Page->file_house_regis->UploadMaxFileSize ?>">
<table id="ft_x_file_house_regis" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file_other->Visible) { // file_other ?>
    <div id="r_file_other"<?= $Page->file_other->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_file_other" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_other->caption() ?><?= $Page->file_other->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_other->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_other">
<div id="fd_x_file_other" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_other->title() ?>" data-table="doc_juzmatch2" data-field="x_file_other" name="x_file_other" id="x_file_other" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_other->editAttributes() ?> aria-describedby="x_file_other_help"<?= ($Page->file_other->ReadOnly || $Page->file_other->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_other->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_other->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_other" id= "fn_x_file_other" value="<?= $Page->file_other->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_other" id= "fa_x_file_other" value="0">
<input type="hidden" name="fs_x_file_other" id= "fs_x_file_other" value="250">
<input type="hidden" name="fx_x_file_other" id= "fx_x_file_other" value="<?= $Page->file_other->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_other" id= "fm_x_file_other" value="<?= $Page->file_other->UploadMaxFileSize ?>">
<table id="ft_x_file_other" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <div id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_contact_address" for="x_contact_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address->caption() ?><?= $Page->contact_address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_address">
<input type="<?= $Page->contact_address->getInputTextType() ?>" name="x_contact_address" id="x_contact_address" data-table="doc_juzmatch2" data-field="x_contact_address" value="<?= $Page->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address->getPlaceHolder()) ?>"<?= $Page->contact_address->editAttributes() ?> aria-describedby="x_contact_address_help">
<?= $Page->contact_address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
    <div id="r_contact_address2"<?= $Page->contact_address2->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_contact_address2" for="x_contact_address2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address2->caption() ?><?= $Page->contact_address2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_address2">
<input type="<?= $Page->contact_address2->getInputTextType() ?>" name="x_contact_address2" id="x_contact_address2" data-table="doc_juzmatch2" data-field="x_contact_address2" value="<?= $Page->contact_address2->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address2->getPlaceHolder()) ?>"<?= $Page->contact_address2->editAttributes() ?> aria-describedby="x_contact_address2_help">
<?= $Page->contact_address2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <div id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_contact_email" for="x_contact_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_email->caption() ?><?= $Page->contact_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_email">
<input type="<?= $Page->contact_email->getInputTextType() ?>" name="x_contact_email" id="x_contact_email" data-table="doc_juzmatch2" data-field="x_contact_email" value="<?= $Page->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_email->getPlaceHolder()) ?>"<?= $Page->contact_email->editAttributes() ?> aria-describedby="x_contact_email_help">
<?= $Page->contact_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
    <div id="r_contact_lineid"<?= $Page->contact_lineid->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_contact_lineid" for="x_contact_lineid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_lineid->caption() ?><?= $Page->contact_lineid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_lineid">
<input type="<?= $Page->contact_lineid->getInputTextType() ?>" name="x_contact_lineid" id="x_contact_lineid" data-table="doc_juzmatch2" data-field="x_contact_lineid" value="<?= $Page->contact_lineid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_lineid->getPlaceHolder()) ?>"<?= $Page->contact_lineid->editAttributes() ?> aria-describedby="x_contact_lineid_help">
<?= $Page->contact_lineid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_lineid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
    <div id="r_contact_phone"<?= $Page->contact_phone->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_contact_phone" for="x_contact_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_phone->caption() ?><?= $Page->contact_phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el_doc_juzmatch2_contact_phone">
<input type="<?= $Page->contact_phone->getInputTextType() ?>" name="x_contact_phone" id="x_contact_phone" data-table="doc_juzmatch2" data-field="x_contact_phone" value="<?= $Page->contact_phone->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_phone->getPlaceHolder()) ?>"<?= $Page->contact_phone->editAttributes() ?> aria-describedby="x_contact_phone_help">
<?= $Page->contact_phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file_loan->Visible) { // file_loan ?>
    <div id="r_file_loan"<?= $Page->file_loan->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_file_loan" for="x_file_loan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_loan->caption() ?><?= $Page->file_loan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_loan->cellAttributes() ?>>
<span id="el_doc_juzmatch2_file_loan">
<input type="<?= $Page->file_loan->getInputTextType() ?>" name="x_file_loan" id="x_file_loan" data-table="doc_juzmatch2" data-field="x_file_loan" value="<?= $Page->file_loan->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->file_loan->getPlaceHolder()) ?>"<?= $Page->file_loan->editAttributes() ?> aria-describedby="x_file_loan_help">
<?= $Page->file_loan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_loan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->attach_file->Visible) { // attach_file ?>
    <div id="r_attach_file"<?= $Page->attach_file->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_attach_file" for="x_attach_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->attach_file->caption() ?><?= $Page->attach_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->attach_file->cellAttributes() ?>>
<span id="el_doc_juzmatch2_attach_file">
<input type="<?= $Page->attach_file->getInputTextType() ?>" name="x_attach_file" id="x_attach_file" data-table="doc_juzmatch2" data-field="x_attach_file" value="<?= $Page->attach_file->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->attach_file->getPlaceHolder()) ?>"<?= $Page->attach_file->editAttributes() ?> aria-describedby="x_attach_file_help">
<?= $Page->attach_file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->attach_file->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_doc_juzmatch2_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_doc_juzmatch2_status">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="fdoc_juzmatch2add_x_status"
        data-table="doc_juzmatch2"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fdoc_juzmatch2add", function() {
    var options = { name: "x_status", selectId: "fdoc_juzmatch2add_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdoc_juzmatch2add.lists.status.lookupOptions.length) {
        options.data = { id: "x_status", form: "fdoc_juzmatch2add" };
    } else {
        options.ajax = { id: "x_status", form: "fdoc_juzmatch2add", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.doc_juzmatch2.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->investor_booking_id->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_investor_booking_id" id="x_investor_booking_id" value="<?= HtmlEncode(strval($Page->investor_booking_id->getSessionValue())) ?>">
    <?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("doc_juzmatch2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
