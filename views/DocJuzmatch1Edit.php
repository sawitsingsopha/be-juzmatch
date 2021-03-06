<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch1Edit = &$Page;
?>



<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch1: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch1edit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch1edit = new ew.Form("fdoc_juzmatch1edit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fdoc_juzmatch1edit;

    // Add fields
    var fields = currentTable.fields;
    fdoc_juzmatch1edit.addFields([
        ["document_date", [fields.document_date.visible && fields.document_date.required ? ew.Validators.required(fields.document_date.caption) : null], fields.document_date.isInvalid],
        ["asset_code", [fields.asset_code.visible && fields.asset_code.required ? ew.Validators.required(fields.asset_code.caption) : null], fields.asset_code.isInvalid],
        ["asset_deed", [fields.asset_deed.visible && fields.asset_deed.required ? ew.Validators.required(fields.asset_deed.caption) : null], fields.asset_deed.isInvalid],
        ["asset_project", [fields.asset_project.visible && fields.asset_project.required ? ew.Validators.required(fields.asset_project.caption) : null], fields.asset_project.isInvalid],
        ["asset_area", [fields.asset_area.visible && fields.asset_area.required ? ew.Validators.required(fields.asset_area.caption) : null], fields.asset_area.isInvalid],
        ["buyer_name", [fields.buyer_name.visible && fields.buyer_name.required ? ew.Validators.required(fields.buyer_name.caption) : null], fields.buyer_name.isInvalid],
        ["buyer_lname", [fields.buyer_lname.visible && fields.buyer_lname.required ? ew.Validators.required(fields.buyer_lname.caption) : null], fields.buyer_lname.isInvalid],
        ["buyer_email", [fields.buyer_email.visible && fields.buyer_email.required ? ew.Validators.required(fields.buyer_email.caption) : null], fields.buyer_email.isInvalid],
        ["buyer_idcard", [fields.buyer_idcard.visible && fields.buyer_idcard.required ? ew.Validators.required(fields.buyer_idcard.caption) : null], fields.buyer_idcard.isInvalid],
        ["buyer_homeno", [fields.buyer_homeno.visible && fields.buyer_homeno.required ? ew.Validators.required(fields.buyer_homeno.caption) : null], fields.buyer_homeno.isInvalid],
        ["buyer_witness_name", [fields.buyer_witness_name.visible && fields.buyer_witness_name.required ? ew.Validators.required(fields.buyer_witness_name.caption) : null], fields.buyer_witness_name.isInvalid],
        ["buyer_witness_lname", [fields.buyer_witness_lname.visible && fields.buyer_witness_lname.required ? ew.Validators.required(fields.buyer_witness_lname.caption) : null], fields.buyer_witness_lname.isInvalid],
        ["buyer_witness_email", [fields.buyer_witness_email.visible && fields.buyer_witness_email.required ? ew.Validators.required(fields.buyer_witness_email.caption) : null], fields.buyer_witness_email.isInvalid],
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
        ["service_price", [fields.service_price.visible && fields.service_price.required ? ew.Validators.required(fields.service_price.caption) : null, ew.Validators.float], fields.service_price.isInvalid],
        ["service_price_txt", [fields.service_price_txt.visible && fields.service_price_txt.required ? ew.Validators.required(fields.service_price_txt.caption) : null], fields.service_price_txt.isInvalid],
        ["first_down", [fields.first_down.visible && fields.first_down.required ? ew.Validators.required(fields.first_down.caption) : null, ew.Validators.float], fields.first_down.isInvalid],
        ["first_down_txt", [fields.first_down_txt.visible && fields.first_down_txt.required ? ew.Validators.required(fields.first_down_txt.caption) : null], fields.first_down_txt.isInvalid],
        ["second_down", [fields.second_down.visible && fields.second_down.required ? ew.Validators.required(fields.second_down.caption) : null, ew.Validators.float], fields.second_down.isInvalid],
        ["second_down_txt", [fields.second_down_txt.visible && fields.second_down_txt.required ? ew.Validators.required(fields.second_down_txt.caption) : null], fields.second_down_txt.isInvalid],
        ["contact_address", [fields.contact_address.visible && fields.contact_address.required ? ew.Validators.required(fields.contact_address.caption) : null], fields.contact_address.isInvalid],
        ["contact_address2", [fields.contact_address2.visible && fields.contact_address2.required ? ew.Validators.required(fields.contact_address2.caption) : null], fields.contact_address2.isInvalid],
        ["contact_email", [fields.contact_email.visible && fields.contact_email.required ? ew.Validators.required(fields.contact_email.caption) : null], fields.contact_email.isInvalid],
        ["contact_lineid", [fields.contact_lineid.visible && fields.contact_lineid.required ? ew.Validators.required(fields.contact_lineid.caption) : null], fields.contact_lineid.isInvalid],
        ["contact_phone", [fields.contact_phone.visible && fields.contact_phone.required ? ew.Validators.required(fields.contact_phone.caption) : null], fields.contact_phone.isInvalid],
        ["file_idcard", [fields.file_idcard.visible && fields.file_idcard.required ? ew.Validators.fileRequired(fields.file_idcard.caption) : null], fields.file_idcard.isInvalid],
        ["file_house_regis", [fields.file_house_regis.visible && fields.file_house_regis.required ? ew.Validators.fileRequired(fields.file_house_regis.caption) : null], fields.file_house_regis.isInvalid],
        ["file_titledeed", [fields.file_titledeed.visible && fields.file_titledeed.required ? ew.Validators.fileRequired(fields.file_titledeed.caption) : null], fields.file_titledeed.isInvalid],
        ["file_other", [fields.file_other.visible && fields.file_other.required ? ew.Validators.fileRequired(fields.file_other.caption) : null], fields.file_other.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_juzmatch1edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        console.log(fobj);
        return true;
    }

    // Use JavaScript validation or not
    fdoc_juzmatch1edit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fdoc_juzmatch1edit");
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
<form name="fdoc_juzmatch1edit" id="fdoc_juzmatch1edit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch1">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer_all_booking_asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_all_booking_asset">
<input type="hidden" name="fk_buyer_booking_asset_id" value="<?= HtmlEncode($Page->buyer_booking_asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<style>
.card {
    width: 100%;
    height: auto;
    padding: 20px 30px;
    margin-bottom: 12px;
    border-radius: 12px;
    -webkit-box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 15%);
    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 15%);
    border: 2px solid #006aec;
}
label.error{
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #DC3545;
}
.form-control.error{
    border-color: #DC3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23DC3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23DC3545' stroke='none'/%3e%3c/svg%3e);
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
</style>

<div class="card">

<div class="row">
<div class="col-12 col-xl-6">
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <div id="r_asset_code"<?= $Page->asset_code->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_asset_code" for="x_asset_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_code->caption() ?><?= $Page->asset_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_code->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_code">
<input type="<?= $Page->asset_code->getInputTextType() ?>" name="x_asset_code" id="x_asset_code" data-table="doc_juzmatch1" data-field="x_asset_code" value="<?= $Page->asset_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_code->getPlaceHolder()) ?>"<?= $Page->asset_code->editAttributes() ?> aria-describedby="x_asset_code_help">
<?= $Page->asset_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
    <div id="r_asset_deed"<?= $Page->asset_deed->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_asset_deed" for="x_asset_deed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_deed->caption() ?><?= $Page->asset_deed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_deed">
<input type="<?= $Page->asset_deed->getInputTextType() ?>" name="x_asset_deed" id="x_asset_deed" data-table="doc_juzmatch1" data-field="x_asset_deed" value="<?= $Page->asset_deed->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_deed->getPlaceHolder()) ?>"<?= $Page->asset_deed->editAttributes() ?> aria-describedby="x_asset_deed_help">
<?= $Page->asset_deed->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_deed->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->asset_project->Visible) { // asset_project ?>
    <div id="r_asset_project"<?= $Page->asset_project->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_asset_project" for="x_asset_project" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_project->caption() ?><?= $Page->asset_project->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_project->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_project">
<input type="<?= $Page->asset_project->getInputTextType() ?>" name="x_asset_project" id="x_asset_project" data-table="doc_juzmatch1" data-field="x_asset_project" value="<?= $Page->asset_project->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_project->getPlaceHolder()) ?>"<?= $Page->asset_project->editAttributes() ?> aria-describedby="x_asset_project_help">
<?= $Page->asset_project->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_project->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">

<?php if ($Page->asset_area->Visible) { // asset_area ?>
    <div id="r_asset_area"<?= $Page->asset_area->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_asset_area" for="x_asset_area" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_area->caption() ?><?= $Page->asset_area->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_area->cellAttributes() ?>>
<span id="el_doc_juzmatch1_asset_area">
<input type="<?= $Page->asset_area->getInputTextType() ?>" name="x_asset_area" id="x_asset_area" data-table="doc_juzmatch1" data-field="x_asset_area" value="<?= $Page->asset_area->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_area->getPlaceHolder()) ?>"<?= $Page->asset_area->editAttributes() ?> aria-describedby="x_asset_area_help">
<?= $Page->asset_area->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_area->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>


<div class="row">
<div class="col-12 col-xl-6">
<!-- </div>
<div class="card"> -->

<?php if ($Page->service_price->Visible) { // service_price ?>
    <div id="r_service_price"<?= $Page->service_price->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_service_price" for="x_service_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->service_price->caption() ?><?= $Page->service_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->service_price->cellAttributes() ?>>
<span id="el_doc_juzmatch1_service_price">
<input type="<?= $Page->service_price->getInputTextType() ?>" name="x_service_price" id="x_service_price" data-table="doc_juzmatch1" data-field="x_service_price" value="<?= $Page->service_price->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->service_price->getPlaceHolder()) ?>"<?= $Page->service_price->editAttributes() ?> aria-describedby="x_service_price_help">
<?= $Page->service_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->service_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">


<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
    <div id="r_service_price_txt"<?= $Page->service_price_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_service_price_txt" for="x_service_price_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->service_price_txt->caption() ?><?= $Page->service_price_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->service_price_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch1_service_price_txt">
<input type="<?= $Page->service_price_txt->getInputTextType() ?>" name="x_service_price_txt" id="x_service_price_txt" data-table="doc_juzmatch1" data-field="x_service_price_txt" value="<?= $Page->service_price_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->service_price_txt->getPlaceHolder()) ?>"<?= $Page->service_price_txt->editAttributes() ?> aria-describedby="x_service_price_txt_help">
<?= $Page->service_price_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->service_price_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->first_down->Visible) { // first_down ?>
    <div id="r_first_down"<?= $Page->first_down->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_first_down" for="x_first_down" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_down->caption() ?><?= $Page->first_down->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_down->cellAttributes() ?>>
<span id="el_doc_juzmatch1_first_down">
<input type="<?= $Page->first_down->getInputTextType() ?>" name="x_first_down" id="x_first_down" data-table="doc_juzmatch1" data-field="x_first_down" value="<?= $Page->first_down->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->first_down->getPlaceHolder()) ?>"<?= $Page->first_down->editAttributes() ?> aria-describedby="x_first_down_help">
<?= $Page->first_down->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_down->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">

<?php if ($Page->first_down_txt->Visible) { // first_down_txt ?>
    <div id="r_first_down_txt"<?= $Page->first_down_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_first_down_txt" for="x_first_down_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_down_txt->caption() ?><?= $Page->first_down_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_down_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch1_first_down_txt">
<input type="<?= $Page->first_down_txt->getInputTextType() ?>" name="x_first_down_txt" id="x_first_down_txt" data-table="doc_juzmatch1" data-field="x_first_down_txt" value="<?= $Page->first_down_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->first_down_txt->getPlaceHolder()) ?>"<?= $Page->first_down_txt->editAttributes() ?> aria-describedby="x_first_down_txt_help">
<?= $Page->first_down_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_down_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>


</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->second_down->Visible) { // second_down ?>
    <div id="r_second_down"<?= $Page->second_down->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_second_down" for="x_second_down" class="<?= $Page->LeftColumnClass ?>"><?= $Page->second_down->caption() ?><?= $Page->second_down->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->second_down->cellAttributes() ?>>
<span id="el_doc_juzmatch1_second_down">
<input type="<?= $Page->second_down->getInputTextType() ?>" name="x_second_down" id="x_second_down" data-table="doc_juzmatch1" data-field="x_second_down" value="<?= $Page->second_down->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->second_down->getPlaceHolder()) ?>"<?= $Page->second_down->editAttributes() ?> aria-describedby="x_second_down_help">
<?= $Page->second_down->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->second_down->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">


<?php if ($Page->second_down_txt->Visible) { // second_down_txt ?>
    <div id="r_second_down_txt"<?= $Page->second_down_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_second_down_txt" for="x_second_down_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->second_down_txt->caption() ?><?= $Page->second_down_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->second_down_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch1_second_down_txt">
<input type="<?= $Page->second_down_txt->getInputTextType() ?>" name="x_second_down_txt" id="x_second_down_txt" data-table="doc_juzmatch1" data-field="x_second_down_txt" value="<?= $Page->second_down_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->second_down_txt->getPlaceHolder()) ?>"<?= $Page->second_down_txt->editAttributes() ?> aria-describedby="x_second_down_txt_help">
<?= $Page->second_down_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->second_down_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <div id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_contact_address" for="x_contact_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address->caption() ?><?= $Page->contact_address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_address">
<input type="<?= $Page->contact_address->getInputTextType() ?>" name="x_contact_address" id="x_contact_address" data-table="doc_juzmatch1" data-field="x_contact_address" value="<?= $Page->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address->getPlaceHolder()) ?>"<?= $Page->contact_address->editAttributes() ?> aria-describedby="x_contact_address_help">
<?= $Page->contact_address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">


<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
    <div id="r_contact_address2"<?= $Page->contact_address2->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_contact_address2" for="x_contact_address2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address2->caption() ?><?= $Page->contact_address2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_address2">
<input type="<?= $Page->contact_address2->getInputTextType() ?>" name="x_contact_address2" id="x_contact_address2" data-table="doc_juzmatch1" data-field="x_contact_address2" value="<?= $Page->contact_address2->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address2->getPlaceHolder()) ?>"<?= $Page->contact_address2->editAttributes() ?> aria-describedby="x_contact_address2_help">
<?= $Page->contact_address2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <div id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_contact_email" for="x_contact_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_email->caption() ?><?= $Page->contact_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_email">
<input type="<?= $Page->contact_email->getInputTextType() ?>" name="x_contact_email" id="x_contact_email" data-table="doc_juzmatch1" data-field="x_contact_email" value="<?= $Page->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_email->getPlaceHolder()) ?>"<?= $Page->contact_email->editAttributes() ?> aria-describedby="x_contact_email_help">
<?= $Page->contact_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>


</div>
<div class="col-12 col-xl-6">


<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
    <div id="r_contact_lineid"<?= $Page->contact_lineid->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_contact_lineid" for="x_contact_lineid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_lineid->caption() ?><?= $Page->contact_lineid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_lineid">
<input type="<?= $Page->contact_lineid->getInputTextType() ?>" name="x_contact_lineid" id="x_contact_lineid" data-table="doc_juzmatch1" data-field="x_contact_lineid" value="<?= $Page->contact_lineid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_lineid->getPlaceHolder()) ?>"<?= $Page->contact_lineid->editAttributes() ?> aria-describedby="x_contact_lineid_help">
<?= $Page->contact_lineid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_lineid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
    <div id="r_contact_phone"<?= $Page->contact_phone->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_contact_phone" for="x_contact_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_phone->caption() ?><?= $Page->contact_phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el_doc_juzmatch1_contact_phone">
<input type="<?= $Page->contact_phone->getInputTextType() ?>" name="x_contact_phone" id="x_contact_phone" data-table="doc_juzmatch1" data-field="x_contact_phone" value="<?= $Page->contact_phone->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_phone->getPlaceHolder()) ?>"<?= $Page->contact_phone->editAttributes() ?> aria-describedby="x_contact_phone_help">
<?= $Page->contact_phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>
<div class="col-12 col-xl-6">

<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
    <div id="r_buyer_homeno"<?= $Page->buyer_homeno->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_homeno" for="x_buyer_homeno" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_homeno->caption() ?><?= $Page->buyer_homeno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_homeno->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_homeno">
<input type="<?= $Page->buyer_homeno->getInputTextType() ?>" name="x_buyer_homeno" id="x_buyer_homeno" data-table="doc_juzmatch1" data-field="x_buyer_homeno" value="<?= $Page->buyer_homeno->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_homeno->getPlaceHolder()) ?>"<?= $Page->buyer_homeno->editAttributes() ?> aria-describedby="x_buyer_homeno_help">
<?= $Page->buyer_homeno->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_homeno->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>

</div>




<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->buyer_name->Visible) { // buyer_name ?>
    <div id="r_buyer_name"<?= $Page->buyer_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_name" for="x_buyer_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_name->caption() ?><?= $Page->buyer_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_name">
<input type="<?= $Page->buyer_name->getInputTextType() ?>" name="x_buyer_name" id="x_buyer_name" data-table="doc_juzmatch1" data-field="x_buyer_name" value="<?= $Page->buyer_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->buyer_name->getPlaceHolder()) ?>"<?= $Page->buyer_name->editAttributes() ?> aria-describedby="x_buyer_name_help">
<?= $Page->buyer_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">


<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
    <div id="r_buyer_lname"<?= $Page->buyer_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_lname" for="x_buyer_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_lname->caption() ?><?= $Page->buyer_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_lname">
<input type="<?= $Page->buyer_lname->getInputTextType() ?>" name="x_buyer_lname" id="x_buyer_lname" data-table="doc_juzmatch1" data-field="x_buyer_lname" value="<?= $Page->buyer_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_lname->getPlaceHolder()) ?>"<?= $Page->buyer_lname->editAttributes() ?> aria-describedby="x_buyer_lname_help">
<?= $Page->buyer_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
    <div id="r_buyer_email"<?= $Page->buyer_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_email" for="x_buyer_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_email->caption() ?><?= $Page->buyer_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_email">
<input type="<?= $Page->buyer_email->getInputTextType() ?>" name="x_buyer_email" id="x_buyer_email" data-table="doc_juzmatch1" data-field="x_buyer_email" value="<?= $Page->buyer_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_email->getPlaceHolder()) ?>"<?= $Page->buyer_email->editAttributes() ?> aria-describedby="x_buyer_email_help">
<?= $Page->buyer_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>





<div class="col-12 col-xl-6">
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
    <div id="r_buyer_idcard"<?= $Page->buyer_idcard->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_idcard" for="x_buyer_idcard" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_idcard->caption() ?><?= $Page->buyer_idcard->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_idcard">
<input type="<?= $Page->buyer_idcard->getInputTextType() ?>" name="x_buyer_idcard" id="x_buyer_idcard" data-table="doc_juzmatch1" data-field="x_buyer_idcard" value="<?= $Page->buyer_idcard->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_idcard->getPlaceHolder()) ?>"<?= $Page->buyer_idcard->editAttributes() ?> aria-describedby="x_buyer_idcard_help">
<?= $Page->buyer_idcard->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_idcard->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>

</div>
















<div class="card">


<div class="row">

<div class="col-12 col-xl-6">
<?php if ($Page->buyer_witness_name->Visible) { // buyer_witness_name ?>
    <div id="r_buyer_witness_name"<?= $Page->buyer_witness_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_witness_name" for="x_buyer_witness_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_witness_name->caption() ?><?= $Page->buyer_witness_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_witness_name">
<input type="<?= $Page->buyer_witness_name->getInputTextType() ?>" name="x_buyer_witness_name" id="x_buyer_witness_name" data-table="doc_juzmatch1" data-field="x_buyer_witness_name" value="<?= $Page->buyer_witness_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->buyer_witness_name->getPlaceHolder()) ?>"<?= $Page->buyer_witness_name->editAttributes() ?> aria-describedby="x_buyer_witness_name_help">
<?= $Page->buyer_witness_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_witness_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>

<div class="col-12 col-xl-6">

<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
    <div id="r_buyer_witness_lname"<?= $Page->buyer_witness_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_witness_lname" for="x_buyer_witness_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_witness_lname->caption() ?><?= $Page->buyer_witness_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_witness_lname">
<input type="<?= $Page->buyer_witness_lname->getInputTextType() ?>" name="x_buyer_witness_lname" id="x_buyer_witness_lname" data-table="doc_juzmatch1" data-field="x_buyer_witness_lname" value="<?= $Page->buyer_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_witness_lname->getPlaceHolder()) ?>"<?= $Page->buyer_witness_lname->editAttributes() ?> aria-describedby="x_buyer_witness_lname_help">
<?= $Page->buyer_witness_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_witness_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>

<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
    <div id="r_buyer_witness_email"<?= $Page->buyer_witness_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_buyer_witness_email" for="x_buyer_witness_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_witness_email->caption() ?><?= $Page->buyer_witness_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_buyer_witness_email">
<input type="<?= $Page->buyer_witness_email->getInputTextType() ?>" name="x_buyer_witness_email" id="x_buyer_witness_email" data-table="doc_juzmatch1" data-field="x_buyer_witness_email" value="<?= $Page->buyer_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_witness_email->getPlaceHolder()) ?>"<?= $Page->buyer_witness_email->editAttributes() ?> aria-describedby="x_buyer_witness_email_help">
<?= $Page->buyer_witness_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_witness_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

<!-- </div>
<div class="card"> -->

</div>
<div class="col-12 col-xl-6">
</div>
</div>
</div>
















<div class="card">

<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->juzmatch_authority_name->Visible) { // juzmatch_authority_name ?>
    <div id="r_juzmatch_authority_name"<?= $Page->juzmatch_authority_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority_name" for="x_juzmatch_authority_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_name->caption() ?><?= $Page->juzmatch_authority_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_name">
<input type="<?= $Page->juzmatch_authority_name->getInputTextType() ?>" name="x_juzmatch_authority_name" id="x_juzmatch_authority_name" data-table="doc_juzmatch1" data-field="x_juzmatch_authority_name" value="<?= $Page->juzmatch_authority_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_name->editAttributes() ?> aria-describedby="x_juzmatch_authority_name_help">
<?= $Page->juzmatch_authority_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">


<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
    <div id="r_juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority_lname" for="x_juzmatch_authority_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_lname->caption() ?><?= $Page->juzmatch_authority_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_lname">
<input type="<?= $Page->juzmatch_authority_lname->getInputTextType() ?>" name="x_juzmatch_authority_lname" id="x_juzmatch_authority_lname" data-table="doc_juzmatch1" data-field="x_juzmatch_authority_lname" value="<?= $Page->juzmatch_authority_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority_lname_help">
<?= $Page->juzmatch_authority_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
    <div id="r_juzmatch_authority_email"<?= $Page->juzmatch_authority_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority_email" for="x_juzmatch_authority_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_email->caption() ?><?= $Page->juzmatch_authority_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_email">
<input type="<?= $Page->juzmatch_authority_email->getInputTextType() ?>" name="x_juzmatch_authority_email" id="x_juzmatch_authority_email" data-table="doc_juzmatch1" data-field="x_juzmatch_authority_email" value="<?= $Page->juzmatch_authority_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_email->editAttributes() ?> aria-describedby="x_juzmatch_authority_email_help">
<?= $Page->juzmatch_authority_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>


</div>
</div>
</div>


<div class="card">
<div class="row">
<div class="col-12 col-xl-6">
<?php if ($Page->juzmatch_authority_witness_name->Visible) { // juzmatch_authority_witness_name ?>
    <div id="r_juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority_witness_name" for="x_juzmatch_authority_witness_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_name->caption() ?><?= $Page->juzmatch_authority_witness_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_witness_name">
<input type="<?= $Page->juzmatch_authority_witness_name->getInputTextType() ?>" name="x_juzmatch_authority_witness_name" id="x_juzmatch_authority_witness_name" data-table="doc_juzmatch1" data-field="x_juzmatch_authority_witness_name" value="<?= $Page->juzmatch_authority_witness_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_name->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_name_help">
<?= $Page->juzmatch_authority_witness_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
<div class="col-12 col-xl-6">
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
    <div id="r_juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority_witness_lname" for="x_juzmatch_authority_witness_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_lname->caption() ?><?= $Page->juzmatch_authority_witness_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_witness_lname">
<input type="<?= $Page->juzmatch_authority_witness_lname->getInputTextType() ?>" name="x_juzmatch_authority_witness_lname" id="x_juzmatch_authority_witness_lname" data-table="doc_juzmatch1" data-field="x_juzmatch_authority_witness_lname" value="<?= $Page->juzmatch_authority_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_lname_help">
<?= $Page->juzmatch_authority_witness_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
    <div id="r_juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority_witness_email" for="x_juzmatch_authority_witness_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_email->caption() ?><?= $Page->juzmatch_authority_witness_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority_witness_email">
<input type="<?= $Page->juzmatch_authority_witness_email->getInputTextType() ?>" name="x_juzmatch_authority_witness_email" id="x_juzmatch_authority_witness_email" data-table="doc_juzmatch1" data-field="x_juzmatch_authority_witness_email" value="<?= $Page->juzmatch_authority_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_email->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_email_help">
<?= $Page->juzmatch_authority_witness_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
</div>

<div class="card">
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
    <div id="r_juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority2_name" for="x_juzmatch_authority2_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_name->caption() ?><?= $Page->juzmatch_authority2_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority2_name">
<input type="<?= $Page->juzmatch_authority2_name->getInputTextType() ?>" name="x_juzmatch_authority2_name" id="x_juzmatch_authority2_name" data-table="doc_juzmatch1" data-field="x_juzmatch_authority2_name" value="<?= $Page->juzmatch_authority2_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_name->editAttributes() ?> aria-describedby="x_juzmatch_authority2_name_help">
<?= $Page->juzmatch_authority2_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>
<div class="col-12 col-xl-6">
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
    <div id="r_juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority2_lname" for="x_juzmatch_authority2_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_lname->caption() ?><?= $Page->juzmatch_authority2_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority2_lname">
<input type="<?= $Page->juzmatch_authority2_lname->getInputTextType() ?>" name="x_juzmatch_authority2_lname" id="x_juzmatch_authority2_lname" data-table="doc_juzmatch1" data-field="x_juzmatch_authority2_lname" value="<?= $Page->juzmatch_authority2_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority2_lname_help">
<?= $Page->juzmatch_authority2_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
<div class="row">
<div class="col-12 col-xl-6">

<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
    <div id="r_juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_juzmatch_authority2_email" for="x_juzmatch_authority2_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_email->caption() ?><?= $Page->juzmatch_authority2_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_juzmatch_authority2_email">
<input type="<?= $Page->juzmatch_authority2_email->getInputTextType() ?>" name="x_juzmatch_authority2_email" id="x_juzmatch_authority2_email" data-table="doc_juzmatch1" data-field="x_juzmatch_authority2_email" value="<?= $Page->juzmatch_authority2_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_email->editAttributes() ?> aria-describedby="x_juzmatch_authority2_email_help">
<?= $Page->juzmatch_authority2_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div>
</div>
</div>


<div class="card">
<div class="row">
<div class="col-12 col-xl-6">
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
    <div id="r_company_seal_name"<?= $Page->company_seal_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_company_seal_name" for="x_company_seal_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_seal_name->caption() ?><?= $Page->company_seal_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el_doc_juzmatch1_company_seal_name">
<input type="<?= $Page->company_seal_name->getInputTextType() ?>" name="x_company_seal_name" id="x_company_seal_name" data-table="doc_juzmatch1" data-field="x_company_seal_name" value="<?= $Page->company_seal_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->company_seal_name->getPlaceHolder()) ?>"<?= $Page->company_seal_name->editAttributes() ?> aria-describedby="x_company_seal_name_help">
<?= $Page->company_seal_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_seal_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

<div class="col-12 col-xl-6">
</div>

<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
    <div id="r_company_seal_email"<?= $Page->company_seal_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_company_seal_email" for="x_company_seal_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_seal_email->caption() ?><?= $Page->company_seal_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el_doc_juzmatch1_company_seal_email">
<input type="<?= $Page->company_seal_email->getInputTextType() ?>" name="x_company_seal_email" id="x_company_seal_email" data-table="doc_juzmatch1" data-field="x_company_seal_email" value="<?= $Page->company_seal_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->company_seal_email->getPlaceHolder()) ?>"<?= $Page->company_seal_email->editAttributes() ?> aria-describedby="x_company_seal_email_help">
<?= $Page->company_seal_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_seal_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div>
</div>


<div class="card">

<?php if ($Page->file_idcard->Visible) { // file_idcard ?>
    <div id="r_file_idcard"<?= $Page->file_idcard->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_file_idcard" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_idcard->caption() ?><?= $Page->file_idcard->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_idcard">
<div id="fd_x_file_idcard" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_idcard->title() ?>" data-table="doc_juzmatch1" data-field="x_file_idcard" name="x_file_idcard" id="x_file_idcard" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_idcard->editAttributes() ?> aria-describedby="x_file_idcard_help"<?= ($Page->file_idcard->ReadOnly || $Page->file_idcard->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_idcard->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_idcard->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_idcard" id= "fn_x_file_idcard" value="<?= $Page->file_idcard->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_idcard" id= "fa_x_file_idcard" value="<?= (Post("fa_x_file_idcard") == "0") ? "0" : "1" ?>">
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
        <label id="elh_doc_juzmatch1_file_house_regis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_house_regis->caption() ?><?= $Page->file_house_regis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_house_regis->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_house_regis">
<div id="fd_x_file_house_regis" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_house_regis->title() ?>" data-table="doc_juzmatch1" data-field="x_file_house_regis" name="x_file_house_regis" id="x_file_house_regis" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_house_regis->editAttributes() ?> aria-describedby="x_file_house_regis_help"<?= ($Page->file_house_regis->ReadOnly || $Page->file_house_regis->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_house_regis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_house_regis->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_house_regis" id= "fn_x_file_house_regis" value="<?= $Page->file_house_regis->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_house_regis" id= "fa_x_file_house_regis" value="<?= (Post("fa_x_file_house_regis") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_file_house_regis" id= "fs_x_file_house_regis" value="250">
<input type="hidden" name="fx_x_file_house_regis" id= "fx_x_file_house_regis" value="<?= $Page->file_house_regis->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_house_regis" id= "fm_x_file_house_regis" value="<?= $Page->file_house_regis->UploadMaxFileSize ?>">
<table id="ft_x_file_house_regis" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>

<?php if ($Page->file_titledeed->Visible) { // file_titledeed ?>
    <div id="r_file_titledeed"<?= $Page->file_titledeed->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_file_titledeed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_titledeed->caption() ?><?= $Page->file_titledeed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_titledeed->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_titledeed">
<div id="fd_x_file_titledeed" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_titledeed->title() ?>" data-table="doc_juzmatch1" data-field="x_file_titledeed" name="x_file_titledeed" id="x_file_titledeed" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_titledeed->editAttributes() ?> aria-describedby="x_file_titledeed_help"<?= ($Page->file_titledeed->ReadOnly || $Page->file_titledeed->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_titledeed->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_titledeed->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_titledeed" id= "fn_x_file_titledeed" value="<?= $Page->file_titledeed->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_titledeed" id= "fa_x_file_titledeed" value="<?= (Post("fa_x_file_titledeed") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_file_titledeed" id= "fs_x_file_titledeed" value="250">
<input type="hidden" name="fx_x_file_titledeed" id= "fx_x_file_titledeed" value="<?= $Page->file_titledeed->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_titledeed" id= "fm_x_file_titledeed" value="<?= $Page->file_titledeed->UploadMaxFileSize ?>">
<table id="ft_x_file_titledeed" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>




<?php if ($Page->file_other->Visible) { // file_other ?>
    <div id="r_file_other"<?= $Page->file_other->rowAttributes() ?>>
        <label id="elh_doc_juzmatch1_file_other" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_other->caption() ?><?= $Page->file_other->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_other->cellAttributes() ?>>
<span id="el_doc_juzmatch1_file_other">
<div id="fd_x_file_other" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_other->title() ?>" data-table="doc_juzmatch1" data-field="x_file_other" name="x_file_other" id="x_file_other" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_other->editAttributes() ?> aria-describedby="x_file_other_help"<?= ($Page->file_other->ReadOnly || $Page->file_other->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file_other->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_other->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_other" id= "fn_x_file_other" value="<?= $Page->file_other->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_other" id= "fa_x_file_other" value="<?= (Post("fa_x_file_other") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_file_other" id= "fs_x_file_other" value="250">
<input type="hidden" name="fx_x_file_other" id= "fx_x_file_other" value="<?= $Page->file_other->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_other" id= "fm_x_file_other" value="<?= $Page->file_other->UploadMaxFileSize ?>">
<table id="ft_x_file_other" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>

</div>
</div><!-- /page* -->
    <input type="hidden" data-table="doc_juzmatch1" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">

    <?php
        $doc_juzmatch1_id = $Page->id->CurrentValue;

        $sql_signer_list = "SELECT doc_juzmatch1.id, doc_creden.doc_creden_id,doc_creden.redirect_url,doc_creden.doc_url,doc_creden.status,doc_creden_signer.doc_creden_signer_id, doc_creden_signer.doc_creden_signer_name, doc_creden_signer.doc_creden_signer_email, doc_creden_signer.doc_creden_signer_link FROM `doc_juzmatch1` LEFT JOIN doc_creden ON doc_creden.doc_creden_id = doc_juzmatch1.doc_creden_id LEFT JOIN doc_creden_signer ON doc_creden.doc_creden_id = doc_creden_signer.doc_creden_id WHERE doc_juzmatch1.id =".$doc_juzmatch1_id." AND doc_juzmatch1.doc_creden_id IS NOT NULL";
        $res_count_signer_list = ExecuteRows($sql_signer_list);
        // $count_email_signer_3 = $res_count_signer_list['count'];
        // echo "<pre>";
        // print_r($res_count_signer_list);
        // echo "<pre>";
        $class_hs_btn = "";
        if ($res_count_signer_list[0]['status'] == 2) {
            $class_hs_btn = "d-none";
        }
    ?>

    <?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn <?=$class_hs_btn?>" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<!-- Table -->

<div class="row <?=$class_hs_btn?>"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>">
    <a class="btn btn-primary ew-btn" name="download_simpledoc" id="download_simpledoc" onclick="download_simpledoc(1,<?=$Page->id->CurrentValue?>)"  type="button">?????????????????????????????????????????????????????????????????????</a>
    <a class="btn btn-default ew-btn" name="postdoc" id="postdoc" onclick="postdoc(1,<?=$Page->id->CurrentValue?>)" type="button">??????????????? Creden eSign</a>
    </div><!-- /buttons offset -->
    </div><!-- /buttons .row -->


<?php if(count($res_count_signer_list)<=0){
}else{
?>

<table id="tbllist" class="table table-bordered table-hover table-sm ew-table table-head-fixed ew-fixed-header-table">
    <!-- .ew-table -->
    <thead style="color: white; text-align: center;">
        <tr class="ew-table-header">
            <th class="ew-list-option-header text-nowrap" data-name="sequence">
                <span id="elh_sequence" class="sequence">???????????????</span>
            </th>
            <th data-name="name" class="ew-table-header-cell">
                <span id="elh_sequence" class="sequence">????????????-?????????????????????</span>
            </th>
            <th data-name="image" class="ew-table-header-cell">
                <span id="elh_sequence" class="sequence">??????????????????</span>
            </th>
            <th data-name="image" class="ew-table-header-cell">
            <span id="elh_sequence" class="sequence">??????????????????????????????????????????????????????</span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $num = 1;
        for ($i=0; $i <count($res_count_signer_list) ; $i++) { 
        ?>
            <tr data-rowindex="1" id="" data-rowtype="1">
                <td class="ew-list-option-body text-nowrap" data-name="sequence">
                    <span id="sequence" class="sequence"><?=$num?>.</span>
                </td>
                <td data-name="name">
                    <span id="name" class="el_name">
                        <span><?=$res_count_signer_list[$i]['doc_creden_signer_name']?></span>
                    </span>
                </td>
                <td data-name="order_by">
                    <span id="order_by" class="el_order_by">
                        <span><?=$res_count_signer_list[$i]['doc_creden_signer_email']?></span>
                    </span>
                </td>
                <td data-name="order_by">
                    <span id="order_by" class="el_order_by">
                        <a href="<?=$res_count_signer_list[$i]['doc_creden_signer_link']?>" target="_blank">???????????????????????????????????????????????????????????????</a>
                    </span>
                </td>
            </tr>
        <?php $num++; }?>
    </tbody>
</table>

<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <a class="btn btn-primary ew-btn" name="doc_url" id="doc_url" type="button" href="<?=$res_count_signer_list[0]['doc_url']?>" target="_blank">?????????????????????????????????????????????</a>
        <a class="btn btn-default ew-btn" name="canceldoc" id="canceldoc" type="button" onclick="canceldoc(1,<?=$Page->id->CurrentValue?>)">?????????????????????????????????????????????</a>
    </div><!-- /buttons offset -->
</div>
<?php
}
?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("doc_juzmatch1");


});
</script>

<script>

loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
    <?php 
        if (@$res_count_signer_list[0]['status'] == 2) {
        ?>
            $('input').prop( "disabled", true );
            $('.delete').hide();
        <?php
        }
    ?>

    $("#download_simpledoc").click(function () {
        $('.form-control').removeClass('error');
        $('label.error').remove();
        $("#fdoc_juzmatch1edit").valid();

        // //used
        // var myForm = document.getElementById("fdoc_juzmatch1edit");
        // clearValidation(myForm);
    });

    $("#postdoc").click(function () {
        $('.form-control').removeClass('error');
        $('label.error').remove();
        $("#fdoc_juzmatch1edit").valid();

        // //used
        // var myForm = document.getElementById("fdoc_juzmatch1edit");
        // clearValidation(myForm);
    });

});
</script>


<script>
    // the loader html
    var sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

    var api_url = "http://127.0.0.1:3000/";
    // var api_url = "https://uatapi.juzmatch.com/";
    
    function download_simpledoc(type,doc_id){
        // $('.form-control').removeClass('error');
        // $('label.error').remove();
        console.log('download_simpledoc');
        let validator = $("#fdoc_juzmatch1edit").validate({
            // in 'rules' user have to specify all the constraints for respective fields
            ignore: [],
            rules : {
                x_buyer_name: "required",
                x_buyer_lname: "required",
                x_buyer_email: "required",
                x_buyer_witness_name: "required",
                x_buyer_witness_lname: "required",
                x_buyer_witness_email: "required",
                x_juzmatch_authority_name: "required",
                x_juzmatch_authority_lname: "required",
                x_juzmatch_authority_email: "required",
                x_juzmatch_authority2_name: "required",
                x_juzmatch_authority2_lname: "required",
                x_juzmatch_authority2_email: "required",
                x_juzmatch_authority_witness_name: "required",
                x_juzmatch_authority_witness_lname: "required",
                x_juzmatch_authority_witness_email: "required",
                x_company_seal_name: "required",
                x_company_seal_email: "required",
                fn_x_file_idcard: "required",
                fn_x_file_house_regis: "required",
                fn_x_file_titledeed: "required",
            }
        });
        validator.resetForm();

        // console.log($("#fdoc_juzmatch1edit").valid())
        if ($("#fdoc_juzmatch1edit").valid()) {
            Swal.fire({
                title: '???????????????????????????????????????????????????????????????????????????????????????',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                    swal.showLoading();
                    $.ajax({
                        type: "GET",
                        url: api_url+'creden/sampledoc?doctype='+type+'&id='+doc_id,
                        dataType: 'json',
                        beforeSend: function() {
                            swal.fire({
                                html: '<h5>Loading...</h5>',
                                showConfirmButton: false,
                                onRender: function() {
                                    // there will only ever be one sweet alert open.
                                    $('.swal2-content').prepend(sweet_loader);
                                }
                            });
                        },
                        success: function(data){
                            swal.close();
                            console.log(data);
                            if (data.code == 200) {
                                let res = data.result;
                                if (res.message.code == "ENOENT") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error code : ' + res.message.code,
                                        text: res.message.path,
                                    })
                                } else {
                                    if (res.pdf == "") {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error : ' + res.message,
                                            // text: res.message.path,
                                        })
                                    } else {
                                        window.open(res.pdf, '_blank');
                                    }
                                }
                            } else {
                                Swal.fire({
                                icon: 'error',
                                title: 'Error' + data.code,
                                text: data.message,
                                })
                            }
                        }
                    });

                }
            })    
        } else {
            Swal.fire({
                icon: 'warning',
                title: '??????????????????????????????????????????????????????????????????????????????????????????',
            })
        }
    }

    function postdoc(type,doc_id){
        $('.form-control').removeClass('error');
        $('label.error').remove();
        // console.log(type,doc_id);
        $("#fdoc_juzmatch1edit").validate({
            // in 'rules' user have to specify all the constraints for respective fields
            ignore: [],
            rules : {
                x_asset_code: "required", 
                x_asset_deed: "required", 
                x_asset_project: "required", 
                x_asset_area: "required",
                x_buyer_name: "required", 
                x_buyer_lname: "required", 
                x_buyer_email: "required", 
                x_buyer_idcard: "required",
                x_buyer_homeno: "required",
                x_buyer_witness_name: "required",
                x_buyer_witness_lname: "required",
                x_buyer_witness_email: "required",
                x_juzmatch_authority_name: "required",
                x_juzmatch_authority_lname: "required",
                x_juzmatch_authority_email: "required",
                x_juzmatch_authority_witness_name: "required",
                x_juzmatch_authority_witness_lname: "required",
                x_juzmatch_authority_witness_email: "required",
                x_juzmatch_authority2_name: "required",
                x_juzmatch_authority2_lname: "required",
                x_juzmatch_authority2_email: "required",
                x_company_seal_name: "required",
                x_company_seal_email: "required",
                x_service_price: "required",
                x_service_price_txt: "required",
                x_first_down: "required",
                x_first_down_txt: "required",
                x_second_down: "required",
                x_second_down_txt: "required",
                x_contact_address: "required",
                x_contact_address2: "required",
                x_contact_email: "required",
                x_contact_lineid: "required",
                x_contact_phone: "required",
                fn_x_file_idcard: "required",
                fn_x_file_house_regis: "required",
                fn_x_file_titledeed: "required",
            }
        });


        if ($("#fdoc_juzmatch1edit").valid()) {
            Swal.fire({
                title: '?????????????????? ??????????????? Creden eSign',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                    $.ajax({
                        type: "GET",
                        url: api_url+'creden/postdoc?doctype='+type+'&id='+doc_id,
                        dataType: 'json',
                        beforeSend: function() {
                            swal.fire({
                                html: '<h5>Loading...</h5>',
                                showConfirmButton: false,
                                onRender: function() {
                                    // there will only ever be one sweet alert open.
                                    $('.swal2-content').prepend(sweet_loader);
                                }
                            });
                        },
                        success: function(data){
                            console.log(data);
                            if (data.code == 200) {
                                let res = data.result;
                                if (res.message.code == "ENOENT") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error code : ' + res.message.code,
                                        text: res.message.path,
                                    })
                                } else {
                                    // if (res.pdf == "") {
                                    //     Swal.fire({
                                    //         icon: 'error',
                                    //         title: 'Error code : 404',
                                    //         text: res.message,
                                    //     })
                                    // } else {
                                        Swal.fire({
                                        title: res.message,
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    // }
                                }
                            } else {
                                Swal.fire({
                                icon: 'error',
                                title: 'Error' + data.code,
                                text: data.message,
                                })
                            }
                        }
                    });
                }
            })
        } else {
            Swal.fire({
                icon: 'warning',
                title: '??????????????????????????????????????????????????????????????????????????????????????????',
            })
        }
    }

    function canceldoc(type,doc_id){
        // console.log(type,doc_id);
        Swal.fire({
            title: '???????????????????????????????????????????????????',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                    $.ajax({
                        type: "GET",
                        url: api_url+'creden/canceldoc?doctype='+type+'&id='+doc_id,
                        dataType: 'json',
                        beforeSend: function() {
                            swal.fire({
                                html: '<h5>Loading...</h5>',
                                showConfirmButton: false,
                                onRender: function() {
                                    // there will only ever be one sweet alert open.
                                    $('.swal2-content').prepend(sweet_loader);
                                }
                            });
                        },
                        success: function(data){
                            console.log(data);
                            if (data.code == 200) {
                                let res = data.result;
                                if (res.message.code == "ENOENT") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error code : ' + res.message.code,
                                        text: res.message.path,
                                    })
                                } else {
                                    Swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }
                            } else {
                                Swal.fire({
                                icon: 'error',
                                title: 'Error' + data.code,
                                text: data.message,
                                })
                            }
                        }
                    });
                }
            })
    }

    function clearValidation(formElement){
        //Internal $.validator is exposed through $(form).validate()
        var validator = $(formElement).validate();
        //Iterate through named elements inside of the form, and mark them as error free
        $('[name]',formElement).each(function(){
            validator.successList.push(this);//mark as error free
            validator.showErrors();//remove error messages if present
        });
        validator.resetForm();//remove error class on name elements and clear history
        validator.reset();//remove all error and success data
    }
</script>


<style>
    tbody.files .template-download td span.preview,
    tbody.files .template-download td span.size{
        
        display: none;
    }

    <?php 
    if (@$res_count_signer_list[0]['status'] == 2) {
    ?>
    button.delete{
        display: none !important;
    }
    <?php 
    }
    ?>

</style>