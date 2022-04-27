<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocJuzmatch3Edit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_juzmatch3: currentTable } });
var currentForm, currentPageID;
var fdoc_juzmatch3edit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_juzmatch3edit = new ew.Form("fdoc_juzmatch3edit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fdoc_juzmatch3edit;

    // Add fields
    var fields = currentTable.fields;
    fdoc_juzmatch3edit.addFields([
        ["document_date", [fields.document_date.visible && fields.document_date.required ? ew.Validators.required(fields.document_date.caption) : null], fields.document_date.isInvalid],
        ["years", [fields.years.visible && fields.years.required ? ew.Validators.required(fields.years.caption) : null, ew.Validators.integer], fields.years.isInvalid],
        ["start_date", [fields.start_date.visible && fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(fields.start_date.clientFormatPattern)], fields.start_date.isInvalid],
        ["end_date", [fields.end_date.visible && fields.end_date.required ? ew.Validators.required(fields.end_date.caption) : null, ew.Validators.datetime(fields.end_date.clientFormatPattern)], fields.end_date.isInvalid],
        ["asset_code", [fields.asset_code.visible && fields.asset_code.required ? ew.Validators.required(fields.asset_code.caption) : null], fields.asset_code.isInvalid],
        ["asset_project", [fields.asset_project.visible && fields.asset_project.required ? ew.Validators.required(fields.asset_project.caption) : null], fields.asset_project.isInvalid],
        ["asset_deed", [fields.asset_deed.visible && fields.asset_deed.required ? ew.Validators.required(fields.asset_deed.caption) : null], fields.asset_deed.isInvalid],
        ["asset_area", [fields.asset_area.visible && fields.asset_area.required ? ew.Validators.required(fields.asset_area.caption) : null], fields.asset_area.isInvalid],
        ["appoint_agent_date", [fields.appoint_agent_date.visible && fields.appoint_agent_date.required ? ew.Validators.required(fields.appoint_agent_date.caption) : null, ew.Validators.datetime(fields.appoint_agent_date.clientFormatPattern)], fields.appoint_agent_date.isInvalid],
        ["buyer_name", [fields.buyer_name.visible && fields.buyer_name.required ? ew.Validators.required(fields.buyer_name.caption) : null], fields.buyer_name.isInvalid],
        ["buyer_lname", [fields.buyer_lname.visible && fields.buyer_lname.required ? ew.Validators.required(fields.buyer_lname.caption) : null], fields.buyer_lname.isInvalid],
        ["buyer_email", [fields.buyer_email.visible && fields.buyer_email.required ? ew.Validators.required(fields.buyer_email.caption) : null], fields.buyer_email.isInvalid],
        ["buyer_idcard", [fields.buyer_idcard.visible && fields.buyer_idcard.required ? ew.Validators.required(fields.buyer_idcard.caption) : null], fields.buyer_idcard.isInvalid],
        ["buyer_homeno", [fields.buyer_homeno.visible && fields.buyer_homeno.required ? ew.Validators.required(fields.buyer_homeno.caption) : null], fields.buyer_homeno.isInvalid],
        ["buyer_witness_name", [fields.buyer_witness_name.visible && fields.buyer_witness_name.required ? ew.Validators.required(fields.buyer_witness_name.caption) : null], fields.buyer_witness_name.isInvalid],
        ["buyer_witness_lname", [fields.buyer_witness_lname.visible && fields.buyer_witness_lname.required ? ew.Validators.required(fields.buyer_witness_lname.caption) : null], fields.buyer_witness_lname.isInvalid],
        ["buyer_witness_email", [fields.buyer_witness_email.visible && fields.buyer_witness_email.required ? ew.Validators.required(fields.buyer_witness_email.caption) : null], fields.buyer_witness_email.isInvalid],
        ["investor_name", [fields.investor_name.visible && fields.investor_name.required ? ew.Validators.required(fields.investor_name.caption) : null], fields.investor_name.isInvalid],
        ["investor_lname", [fields.investor_lname.visible && fields.investor_lname.required ? ew.Validators.required(fields.investor_lname.caption) : null], fields.investor_lname.isInvalid],
        ["investor_email", [fields.investor_email.visible && fields.investor_email.required ? ew.Validators.required(fields.investor_email.caption) : null], fields.investor_email.isInvalid],
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
        ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.float], fields.total.isInvalid],
        ["total_txt", [fields.total_txt.visible && fields.total_txt.required ? ew.Validators.required(fields.total_txt.caption) : null], fields.total_txt.isInvalid],
        ["next_pay_date", [fields.next_pay_date.visible && fields.next_pay_date.required ? ew.Validators.required(fields.next_pay_date.caption) : null, ew.Validators.datetime(fields.next_pay_date.clientFormatPattern)], fields.next_pay_date.isInvalid],
        ["next_pay_date_txt", [fields.next_pay_date_txt.visible && fields.next_pay_date_txt.required ? ew.Validators.required(fields.next_pay_date_txt.caption) : null], fields.next_pay_date_txt.isInvalid],
        ["service_price", [fields.service_price.visible && fields.service_price.required ? ew.Validators.required(fields.service_price.caption) : null, ew.Validators.float], fields.service_price.isInvalid],
        ["service_price_txt", [fields.service_price_txt.visible && fields.service_price_txt.required ? ew.Validators.required(fields.service_price_txt.caption) : null], fields.service_price_txt.isInvalid],
        ["provide_service_date", [fields.provide_service_date.visible && fields.provide_service_date.required ? ew.Validators.required(fields.provide_service_date.caption) : null, ew.Validators.datetime(fields.provide_service_date.clientFormatPattern)], fields.provide_service_date.isInvalid],
        ["contact_address", [fields.contact_address.visible && fields.contact_address.required ? ew.Validators.required(fields.contact_address.caption) : null], fields.contact_address.isInvalid],
        ["contact_address2", [fields.contact_address2.visible && fields.contact_address2.required ? ew.Validators.required(fields.contact_address2.caption) : null], fields.contact_address2.isInvalid],
        ["contact_email", [fields.contact_email.visible && fields.contact_email.required ? ew.Validators.required(fields.contact_email.caption) : null], fields.contact_email.isInvalid],
        ["contact_lineid", [fields.contact_lineid.visible && fields.contact_lineid.required ? ew.Validators.required(fields.contact_lineid.caption) : null], fields.contact_lineid.isInvalid],
        ["contact_phone", [fields.contact_phone.visible && fields.contact_phone.required ? ew.Validators.required(fields.contact_phone.caption) : null], fields.contact_phone.isInvalid],
        ["file_idcard", [fields.file_idcard.visible && fields.file_idcard.required ? ew.Validators.fileRequired(fields.file_idcard.caption) : null], fields.file_idcard.isInvalid],
        ["file_house_regis", [fields.file_house_regis.visible && fields.file_house_regis.required ? ew.Validators.fileRequired(fields.file_house_regis.caption) : null], fields.file_house_regis.isInvalid],
        ["file_titledeed", [fields.file_titledeed.visible && fields.file_titledeed.required ? ew.Validators.fileRequired(fields.file_titledeed.caption) : null], fields.file_titledeed.isInvalid],
        ["file_other", [fields.file_other.visible && fields.file_other.required ? ew.Validators.fileRequired(fields.file_other.caption) : null], fields.file_other.isInvalid],
        ["attach_file", [fields.attach_file.visible && fields.attach_file.required ? ew.Validators.required(fields.attach_file.caption) : null], fields.attach_file.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["doc_date", [fields.doc_date.visible && fields.doc_date.required ? ew.Validators.required(fields.doc_date.caption) : null], fields.doc_date.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_juzmatch3edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_juzmatch3edit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fdoc_juzmatch3edit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fdoc_juzmatch3edit");
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
<form name="fdoc_juzmatch3edit" id="fdoc_juzmatch3edit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_juzmatch3">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer_all_booking_asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_all_booking_asset">
<input type="hidden" name="fk_buyer_booking_asset_id" value="<?= HtmlEncode($Page->buyer_booking_asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->years->Visible) { // years ?>
    <div id="r_years"<?= $Page->years->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_years" for="x_years" class="<?= $Page->LeftColumnClass ?>"><?= $Page->years->caption() ?><?= $Page->years->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->years->cellAttributes() ?>>
<span id="el_doc_juzmatch3_years">
<input type="<?= $Page->years->getInputTextType() ?>" name="x_years" id="x_years" data-table="doc_juzmatch3" data-field="x_years" value="<?= $Page->years->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->years->getPlaceHolder()) ?>"<?= $Page->years->editAttributes() ?> aria-describedby="x_years_help">
<?= $Page->years->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->years->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->start_date->Visible) { // start_date ?>
    <div id="r_start_date"<?= $Page->start_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_start_date" for="x_start_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->start_date->caption() ?><?= $Page->start_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->start_date->cellAttributes() ?>>
<span id="el_doc_juzmatch3_start_date">
<input type="<?= $Page->start_date->getInputTextType() ?>" name="x_start_date" id="x_start_date" data-table="doc_juzmatch3" data-field="x_start_date" value="<?= $Page->start_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>"<?= $Page->start_date->editAttributes() ?> aria-describedby="x_start_date_help">
<?= $Page->start_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3edit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_juzmatch3edit", "x_start_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->end_date->Visible) { // end_date ?>
    <div id="r_end_date"<?= $Page->end_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_end_date" for="x_end_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->end_date->caption() ?><?= $Page->end_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->end_date->cellAttributes() ?>>
<span id="el_doc_juzmatch3_end_date">
<input type="<?= $Page->end_date->getInputTextType() ?>" name="x_end_date" id="x_end_date" data-table="doc_juzmatch3" data-field="x_end_date" value="<?= $Page->end_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->end_date->getPlaceHolder()) ?>"<?= $Page->end_date->editAttributes() ?> aria-describedby="x_end_date_help">
<?= $Page->end_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->end_date->getErrorMessage() ?></div>
<?php if (!$Page->end_date->ReadOnly && !$Page->end_date->Disabled && !isset($Page->end_date->EditAttrs["readonly"]) && !isset($Page->end_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3edit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_juzmatch3edit", "x_end_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <div id="r_asset_code"<?= $Page->asset_code->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_asset_code" for="x_asset_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_code->caption() ?><?= $Page->asset_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_code->cellAttributes() ?>>
<span id="el_doc_juzmatch3_asset_code">
<input type="<?= $Page->asset_code->getInputTextType() ?>" name="x_asset_code" id="x_asset_code" data-table="doc_juzmatch3" data-field="x_asset_code" value="<?= $Page->asset_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_code->getPlaceHolder()) ?>"<?= $Page->asset_code->editAttributes() ?> aria-describedby="x_asset_code_help">
<?= $Page->asset_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_project->Visible) { // asset_project ?>
    <div id="r_asset_project"<?= $Page->asset_project->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_asset_project" for="x_asset_project" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_project->caption() ?><?= $Page->asset_project->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_project->cellAttributes() ?>>
<span id="el_doc_juzmatch3_asset_project">
<input type="<?= $Page->asset_project->getInputTextType() ?>" name="x_asset_project" id="x_asset_project" data-table="doc_juzmatch3" data-field="x_asset_project" value="<?= $Page->asset_project->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_project->getPlaceHolder()) ?>"<?= $Page->asset_project->editAttributes() ?> aria-describedby="x_asset_project_help">
<?= $Page->asset_project->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_project->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_deed->Visible) { // asset_deed ?>
    <div id="r_asset_deed"<?= $Page->asset_deed->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_asset_deed" for="x_asset_deed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_deed->caption() ?><?= $Page->asset_deed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_deed->cellAttributes() ?>>
<span id="el_doc_juzmatch3_asset_deed">
<input type="<?= $Page->asset_deed->getInputTextType() ?>" name="x_asset_deed" id="x_asset_deed" data-table="doc_juzmatch3" data-field="x_asset_deed" value="<?= $Page->asset_deed->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_deed->getPlaceHolder()) ?>"<?= $Page->asset_deed->editAttributes() ?> aria-describedby="x_asset_deed_help">
<?= $Page->asset_deed->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_deed->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_area->Visible) { // asset_area ?>
    <div id="r_asset_area"<?= $Page->asset_area->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_asset_area" for="x_asset_area" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_area->caption() ?><?= $Page->asset_area->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_area->cellAttributes() ?>>
<span id="el_doc_juzmatch3_asset_area">
<input type="<?= $Page->asset_area->getInputTextType() ?>" name="x_asset_area" id="x_asset_area" data-table="doc_juzmatch3" data-field="x_asset_area" value="<?= $Page->asset_area->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->asset_area->getPlaceHolder()) ?>"<?= $Page->asset_area->editAttributes() ?> aria-describedby="x_asset_area_help">
<?= $Page->asset_area->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_area->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->appoint_agent_date->Visible) { // appoint_agent_date ?>
    <div id="r_appoint_agent_date"<?= $Page->appoint_agent_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_appoint_agent_date" for="x_appoint_agent_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->appoint_agent_date->caption() ?><?= $Page->appoint_agent_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->appoint_agent_date->cellAttributes() ?>>
<span id="el_doc_juzmatch3_appoint_agent_date">
<input type="<?= $Page->appoint_agent_date->getInputTextType() ?>" name="x_appoint_agent_date" id="x_appoint_agent_date" data-table="doc_juzmatch3" data-field="x_appoint_agent_date" value="<?= $Page->appoint_agent_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->appoint_agent_date->getPlaceHolder()) ?>"<?= $Page->appoint_agent_date->editAttributes() ?> aria-describedby="x_appoint_agent_date_help">
<?= $Page->appoint_agent_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->appoint_agent_date->getErrorMessage() ?></div>
<?php if (!$Page->appoint_agent_date->ReadOnly && !$Page->appoint_agent_date->Disabled && !isset($Page->appoint_agent_date->EditAttrs["readonly"]) && !isset($Page->appoint_agent_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3edit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_juzmatch3edit", "x_appoint_agent_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_name->Visible) { // buyer_name ?>
    <div id="r_buyer_name"<?= $Page->buyer_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_name" for="x_buyer_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_name->caption() ?><?= $Page->buyer_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_name">
<input type="<?= $Page->buyer_name->getInputTextType() ?>" name="x_buyer_name" id="x_buyer_name" data-table="doc_juzmatch3" data-field="x_buyer_name" value="<?= $Page->buyer_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->buyer_name->getPlaceHolder()) ?>"<?= $Page->buyer_name->editAttributes() ?> aria-describedby="x_buyer_name_help">
<?= $Page->buyer_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_lname->Visible) { // buyer_lname ?>
    <div id="r_buyer_lname"<?= $Page->buyer_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_lname" for="x_buyer_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_lname->caption() ?><?= $Page->buyer_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_lname">
<input type="<?= $Page->buyer_lname->getInputTextType() ?>" name="x_buyer_lname" id="x_buyer_lname" data-table="doc_juzmatch3" data-field="x_buyer_lname" value="<?= $Page->buyer_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_lname->getPlaceHolder()) ?>"<?= $Page->buyer_lname->editAttributes() ?> aria-describedby="x_buyer_lname_help">
<?= $Page->buyer_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_email->Visible) { // buyer_email ?>
    <div id="r_buyer_email"<?= $Page->buyer_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_email" for="x_buyer_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_email->caption() ?><?= $Page->buyer_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_email">
<input type="<?= $Page->buyer_email->getInputTextType() ?>" name="x_buyer_email" id="x_buyer_email" data-table="doc_juzmatch3" data-field="x_buyer_email" value="<?= $Page->buyer_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_email->getPlaceHolder()) ?>"<?= $Page->buyer_email->editAttributes() ?> aria-describedby="x_buyer_email_help">
<?= $Page->buyer_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_idcard->Visible) { // buyer_idcard ?>
    <div id="r_buyer_idcard"<?= $Page->buyer_idcard->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_idcard" for="x_buyer_idcard" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_idcard->caption() ?><?= $Page->buyer_idcard->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_idcard">
<input type="<?= $Page->buyer_idcard->getInputTextType() ?>" name="x_buyer_idcard" id="x_buyer_idcard" data-table="doc_juzmatch3" data-field="x_buyer_idcard" value="<?= $Page->buyer_idcard->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_idcard->getPlaceHolder()) ?>"<?= $Page->buyer_idcard->editAttributes() ?> aria-describedby="x_buyer_idcard_help">
<?= $Page->buyer_idcard->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_idcard->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_homeno->Visible) { // buyer_homeno ?>
    <div id="r_buyer_homeno"<?= $Page->buyer_homeno->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_homeno" for="x_buyer_homeno" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_homeno->caption() ?><?= $Page->buyer_homeno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_homeno->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_homeno">
<input type="<?= $Page->buyer_homeno->getInputTextType() ?>" name="x_buyer_homeno" id="x_buyer_homeno" data-table="doc_juzmatch3" data-field="x_buyer_homeno" value="<?= $Page->buyer_homeno->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_homeno->getPlaceHolder()) ?>"<?= $Page->buyer_homeno->editAttributes() ?> aria-describedby="x_buyer_homeno_help">
<?= $Page->buyer_homeno->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_homeno->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_witness_name->Visible) { // buyer_witness_name ?>
    <div id="r_buyer_witness_name"<?= $Page->buyer_witness_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_witness_name" for="x_buyer_witness_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_witness_name->caption() ?><?= $Page->buyer_witness_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_witness_name">
<input type="<?= $Page->buyer_witness_name->getInputTextType() ?>" name="x_buyer_witness_name" id="x_buyer_witness_name" data-table="doc_juzmatch3" data-field="x_buyer_witness_name" value="<?= $Page->buyer_witness_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->buyer_witness_name->getPlaceHolder()) ?>"<?= $Page->buyer_witness_name->editAttributes() ?> aria-describedby="x_buyer_witness_name_help">
<?= $Page->buyer_witness_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_witness_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_witness_lname->Visible) { // buyer_witness_lname ?>
    <div id="r_buyer_witness_lname"<?= $Page->buyer_witness_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_witness_lname" for="x_buyer_witness_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_witness_lname->caption() ?><?= $Page->buyer_witness_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_witness_lname">
<input type="<?= $Page->buyer_witness_lname->getInputTextType() ?>" name="x_buyer_witness_lname" id="x_buyer_witness_lname" data-table="doc_juzmatch3" data-field="x_buyer_witness_lname" value="<?= $Page->buyer_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_witness_lname->getPlaceHolder()) ?>"<?= $Page->buyer_witness_lname->editAttributes() ?> aria-describedby="x_buyer_witness_lname_help">
<?= $Page->buyer_witness_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_witness_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_witness_email->Visible) { // buyer_witness_email ?>
    <div id="r_buyer_witness_email"<?= $Page->buyer_witness_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_buyer_witness_email" for="x_buyer_witness_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_witness_email->caption() ?><?= $Page->buyer_witness_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_buyer_witness_email">
<input type="<?= $Page->buyer_witness_email->getInputTextType() ?>" name="x_buyer_witness_email" id="x_buyer_witness_email" data-table="doc_juzmatch3" data-field="x_buyer_witness_email" value="<?= $Page->buyer_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->buyer_witness_email->getPlaceHolder()) ?>"<?= $Page->buyer_witness_email->editAttributes() ?> aria-describedby="x_buyer_witness_email_help">
<?= $Page->buyer_witness_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_witness_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_name->Visible) { // investor_name ?>
    <div id="r_investor_name"<?= $Page->investor_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_investor_name" for="x_investor_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_name->caption() ?><?= $Page->investor_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_investor_name">
<input type="<?= $Page->investor_name->getInputTextType() ?>" name="x_investor_name" id="x_investor_name" data-table="doc_juzmatch3" data-field="x_investor_name" value="<?= $Page->investor_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_name->getPlaceHolder()) ?>"<?= $Page->investor_name->editAttributes() ?> aria-describedby="x_investor_name_help">
<?= $Page->investor_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_lname->Visible) { // investor_lname ?>
    <div id="r_investor_lname"<?= $Page->investor_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_investor_lname" for="x_investor_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_lname->caption() ?><?= $Page->investor_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch3_investor_lname">
<input type="<?= $Page->investor_lname->getInputTextType() ?>" name="x_investor_lname" id="x_investor_lname" data-table="doc_juzmatch3" data-field="x_investor_lname" value="<?= $Page->investor_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_lname->getPlaceHolder()) ?>"<?= $Page->investor_lname->editAttributes() ?> aria-describedby="x_investor_lname_help">
<?= $Page->investor_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_email->Visible) { // investor_email ?>
    <div id="r_investor_email"<?= $Page->investor_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_investor_email" for="x_investor_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_email->caption() ?><?= $Page->investor_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_investor_email">
<input type="<?= $Page->investor_email->getInputTextType() ?>" name="x_investor_email" id="x_investor_email" data-table="doc_juzmatch3" data-field="x_investor_email" value="<?= $Page->investor_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->investor_email->getPlaceHolder()) ?>"<?= $Page->investor_email->editAttributes() ?> aria-describedby="x_investor_email_help">
<?= $Page->investor_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_name->Visible) { // juzmatch_authority_name ?>
    <div id="r_juzmatch_authority_name"<?= $Page->juzmatch_authority_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority_name" for="x_juzmatch_authority_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_name->caption() ?><?= $Page->juzmatch_authority_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority_name">
<input type="<?= $Page->juzmatch_authority_name->getInputTextType() ?>" name="x_juzmatch_authority_name" id="x_juzmatch_authority_name" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_name" value="<?= $Page->juzmatch_authority_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_name->editAttributes() ?> aria-describedby="x_juzmatch_authority_name_help">
<?= $Page->juzmatch_authority_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_lname->Visible) { // juzmatch_authority_lname ?>
    <div id="r_juzmatch_authority_lname"<?= $Page->juzmatch_authority_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority_lname" for="x_juzmatch_authority_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_lname->caption() ?><?= $Page->juzmatch_authority_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority_lname">
<input type="<?= $Page->juzmatch_authority_lname->getInputTextType() ?>" name="x_juzmatch_authority_lname" id="x_juzmatch_authority_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_lname" value="<?= $Page->juzmatch_authority_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority_lname_help">
<?= $Page->juzmatch_authority_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_email->Visible) { // juzmatch_authority_email ?>
    <div id="r_juzmatch_authority_email"<?= $Page->juzmatch_authority_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority_email" for="x_juzmatch_authority_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_email->caption() ?><?= $Page->juzmatch_authority_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority_email">
<input type="<?= $Page->juzmatch_authority_email->getInputTextType() ?>" name="x_juzmatch_authority_email" id="x_juzmatch_authority_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_email" value="<?= $Page->juzmatch_authority_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_email->editAttributes() ?> aria-describedby="x_juzmatch_authority_email_help">
<?= $Page->juzmatch_authority_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_name->Visible) { // juzmatch_authority_witness_name ?>
    <div id="r_juzmatch_authority_witness_name"<?= $Page->juzmatch_authority_witness_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority_witness_name" for="x_juzmatch_authority_witness_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_name->caption() ?><?= $Page->juzmatch_authority_witness_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority_witness_name">
<input type="<?= $Page->juzmatch_authority_witness_name->getInputTextType() ?>" name="x_juzmatch_authority_witness_name" id="x_juzmatch_authority_witness_name" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_name" value="<?= $Page->juzmatch_authority_witness_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_name->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_name_help">
<?= $Page->juzmatch_authority_witness_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_lname->Visible) { // juzmatch_authority_witness_lname ?>
    <div id="r_juzmatch_authority_witness_lname"<?= $Page->juzmatch_authority_witness_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority_witness_lname" for="x_juzmatch_authority_witness_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_lname->caption() ?><?= $Page->juzmatch_authority_witness_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority_witness_lname">
<input type="<?= $Page->juzmatch_authority_witness_lname->getInputTextType() ?>" name="x_juzmatch_authority_witness_lname" id="x_juzmatch_authority_witness_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_lname" value="<?= $Page->juzmatch_authority_witness_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_lname_help">
<?= $Page->juzmatch_authority_witness_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority_witness_email->Visible) { // juzmatch_authority_witness_email ?>
    <div id="r_juzmatch_authority_witness_email"<?= $Page->juzmatch_authority_witness_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority_witness_email" for="x_juzmatch_authority_witness_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority_witness_email->caption() ?><?= $Page->juzmatch_authority_witness_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority_witness_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority_witness_email">
<input type="<?= $Page->juzmatch_authority_witness_email->getInputTextType() ?>" name="x_juzmatch_authority_witness_email" id="x_juzmatch_authority_witness_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority_witness_email" value="<?= $Page->juzmatch_authority_witness_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority_witness_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority_witness_email->editAttributes() ?> aria-describedby="x_juzmatch_authority_witness_email_help">
<?= $Page->juzmatch_authority_witness_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority_witness_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority2_name->Visible) { // juzmatch_authority2_name ?>
    <div id="r_juzmatch_authority2_name"<?= $Page->juzmatch_authority2_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority2_name" for="x_juzmatch_authority2_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_name->caption() ?><?= $Page->juzmatch_authority2_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority2_name">
<input type="<?= $Page->juzmatch_authority2_name->getInputTextType() ?>" name="x_juzmatch_authority2_name" id="x_juzmatch_authority2_name" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_name" value="<?= $Page->juzmatch_authority2_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_name->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_name->editAttributes() ?> aria-describedby="x_juzmatch_authority2_name_help">
<?= $Page->juzmatch_authority2_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority2_lname->Visible) { // juzmatch_authority2_lname ?>
    <div id="r_juzmatch_authority2_lname"<?= $Page->juzmatch_authority2_lname->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority2_lname" for="x_juzmatch_authority2_lname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_lname->caption() ?><?= $Page->juzmatch_authority2_lname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_lname->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority2_lname">
<input type="<?= $Page->juzmatch_authority2_lname->getInputTextType() ?>" name="x_juzmatch_authority2_lname" id="x_juzmatch_authority2_lname" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_lname" value="<?= $Page->juzmatch_authority2_lname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_lname->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_lname->editAttributes() ?> aria-describedby="x_juzmatch_authority2_lname_help">
<?= $Page->juzmatch_authority2_lname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_lname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->juzmatch_authority2_email->Visible) { // juzmatch_authority2_email ?>
    <div id="r_juzmatch_authority2_email"<?= $Page->juzmatch_authority2_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_juzmatch_authority2_email" for="x_juzmatch_authority2_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->juzmatch_authority2_email->caption() ?><?= $Page->juzmatch_authority2_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->juzmatch_authority2_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_juzmatch_authority2_email">
<input type="<?= $Page->juzmatch_authority2_email->getInputTextType() ?>" name="x_juzmatch_authority2_email" id="x_juzmatch_authority2_email" data-table="doc_juzmatch3" data-field="x_juzmatch_authority2_email" value="<?= $Page->juzmatch_authority2_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->juzmatch_authority2_email->getPlaceHolder()) ?>"<?= $Page->juzmatch_authority2_email->editAttributes() ?> aria-describedby="x_juzmatch_authority2_email_help">
<?= $Page->juzmatch_authority2_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->juzmatch_authority2_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->company_seal_name->Visible) { // company_seal_name ?>
    <div id="r_company_seal_name"<?= $Page->company_seal_name->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_company_seal_name" for="x_company_seal_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_seal_name->caption() ?><?= $Page->company_seal_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_seal_name->cellAttributes() ?>>
<span id="el_doc_juzmatch3_company_seal_name">
<input type="<?= $Page->company_seal_name->getInputTextType() ?>" name="x_company_seal_name" id="x_company_seal_name" data-table="doc_juzmatch3" data-field="x_company_seal_name" value="<?= $Page->company_seal_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->company_seal_name->getPlaceHolder()) ?>"<?= $Page->company_seal_name->editAttributes() ?> aria-describedby="x_company_seal_name_help">
<?= $Page->company_seal_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_seal_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->company_seal_email->Visible) { // company_seal_email ?>
    <div id="r_company_seal_email"<?= $Page->company_seal_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_company_seal_email" for="x_company_seal_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_seal_email->caption() ?><?= $Page->company_seal_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_seal_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_company_seal_email">
<input type="<?= $Page->company_seal_email->getInputTextType() ?>" name="x_company_seal_email" id="x_company_seal_email" data-table="doc_juzmatch3" data-field="x_company_seal_email" value="<?= $Page->company_seal_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->company_seal_email->getPlaceHolder()) ?>"<?= $Page->company_seal_email->editAttributes() ?> aria-describedby="x_company_seal_email_help">
<?= $Page->company_seal_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_seal_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total"<?= $Page->total->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total->cellAttributes() ?>>
<span id="el_doc_juzmatch3_total">
<input type="<?= $Page->total->getInputTextType() ?>" name="x_total" id="x_total" data-table="doc_juzmatch3" data-field="x_total" value="<?= $Page->total->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>"<?= $Page->total->editAttributes() ?> aria-describedby="x_total_help">
<?= $Page->total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total_txt->Visible) { // total_txt ?>
    <div id="r_total_txt"<?= $Page->total_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_total_txt" for="x_total_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total_txt->caption() ?><?= $Page->total_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch3_total_txt">
<input type="<?= $Page->total_txt->getInputTextType() ?>" name="x_total_txt" id="x_total_txt" data-table="doc_juzmatch3" data-field="x_total_txt" value="<?= $Page->total_txt->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->total_txt->getPlaceHolder()) ?>"<?= $Page->total_txt->editAttributes() ?> aria-describedby="x_total_txt_help">
<?= $Page->total_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->next_pay_date->Visible) { // next_pay_date ?>
    <div id="r_next_pay_date"<?= $Page->next_pay_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_next_pay_date" for="x_next_pay_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->next_pay_date->caption() ?><?= $Page->next_pay_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->next_pay_date->cellAttributes() ?>>
<span id="el_doc_juzmatch3_next_pay_date">
<input type="<?= $Page->next_pay_date->getInputTextType() ?>" name="x_next_pay_date" id="x_next_pay_date" data-table="doc_juzmatch3" data-field="x_next_pay_date" value="<?= $Page->next_pay_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->next_pay_date->getPlaceHolder()) ?>"<?= $Page->next_pay_date->editAttributes() ?> aria-describedby="x_next_pay_date_help">
<?= $Page->next_pay_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->next_pay_date->getErrorMessage() ?></div>
<?php if (!$Page->next_pay_date->ReadOnly && !$Page->next_pay_date->Disabled && !isset($Page->next_pay_date->EditAttrs["readonly"]) && !isset($Page->next_pay_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3edit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_juzmatch3edit", "x_next_pay_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->next_pay_date_txt->Visible) { // next_pay_date_txt ?>
    <div id="r_next_pay_date_txt"<?= $Page->next_pay_date_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_next_pay_date_txt" for="x_next_pay_date_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->next_pay_date_txt->caption() ?><?= $Page->next_pay_date_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->next_pay_date_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch3_next_pay_date_txt">
<input type="<?= $Page->next_pay_date_txt->getInputTextType() ?>" name="x_next_pay_date_txt" id="x_next_pay_date_txt" data-table="doc_juzmatch3" data-field="x_next_pay_date_txt" value="<?= $Page->next_pay_date_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->next_pay_date_txt->getPlaceHolder()) ?>"<?= $Page->next_pay_date_txt->editAttributes() ?> aria-describedby="x_next_pay_date_txt_help">
<?= $Page->next_pay_date_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->next_pay_date_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->service_price->Visible) { // service_price ?>
    <div id="r_service_price"<?= $Page->service_price->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_service_price" for="x_service_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->service_price->caption() ?><?= $Page->service_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->service_price->cellAttributes() ?>>
<span id="el_doc_juzmatch3_service_price">
<input type="<?= $Page->service_price->getInputTextType() ?>" name="x_service_price" id="x_service_price" data-table="doc_juzmatch3" data-field="x_service_price" value="<?= $Page->service_price->EditValue ?>" size="30" maxlength="22" placeholder="<?= HtmlEncode($Page->service_price->getPlaceHolder()) ?>"<?= $Page->service_price->editAttributes() ?> aria-describedby="x_service_price_help">
<?= $Page->service_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->service_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->service_price_txt->Visible) { // service_price_txt ?>
    <div id="r_service_price_txt"<?= $Page->service_price_txt->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_service_price_txt" for="x_service_price_txt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->service_price_txt->caption() ?><?= $Page->service_price_txt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->service_price_txt->cellAttributes() ?>>
<span id="el_doc_juzmatch3_service_price_txt">
<input type="<?= $Page->service_price_txt->getInputTextType() ?>" name="x_service_price_txt" id="x_service_price_txt" data-table="doc_juzmatch3" data-field="x_service_price_txt" value="<?= $Page->service_price_txt->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->service_price_txt->getPlaceHolder()) ?>"<?= $Page->service_price_txt->editAttributes() ?> aria-describedby="x_service_price_txt_help">
<?= $Page->service_price_txt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->service_price_txt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->provide_service_date->Visible) { // provide_service_date ?>
    <div id="r_provide_service_date"<?= $Page->provide_service_date->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_provide_service_date" for="x_provide_service_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->provide_service_date->caption() ?><?= $Page->provide_service_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->provide_service_date->cellAttributes() ?>>
<span id="el_doc_juzmatch3_provide_service_date">
<input type="<?= $Page->provide_service_date->getInputTextType() ?>" name="x_provide_service_date" id="x_provide_service_date" data-table="doc_juzmatch3" data-field="x_provide_service_date" value="<?= $Page->provide_service_date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->provide_service_date->getPlaceHolder()) ?>"<?= $Page->provide_service_date->editAttributes() ?> aria-describedby="x_provide_service_date_help">
<?= $Page->provide_service_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->provide_service_date->getErrorMessage() ?></div>
<?php if (!$Page->provide_service_date->ReadOnly && !$Page->provide_service_date->Disabled && !isset($Page->provide_service_date->EditAttrs["readonly"]) && !isset($Page->provide_service_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_juzmatch3edit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_juzmatch3edit", "x_provide_service_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <div id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_contact_address" for="x_contact_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address->caption() ?><?= $Page->contact_address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_doc_juzmatch3_contact_address">
<input type="<?= $Page->contact_address->getInputTextType() ?>" name="x_contact_address" id="x_contact_address" data-table="doc_juzmatch3" data-field="x_contact_address" value="<?= $Page->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address->getPlaceHolder()) ?>"<?= $Page->contact_address->editAttributes() ?> aria-describedby="x_contact_address_help">
<?= $Page->contact_address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_address2->Visible) { // contact_address2 ?>
    <div id="r_contact_address2"<?= $Page->contact_address2->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_contact_address2" for="x_contact_address2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address2->caption() ?><?= $Page->contact_address2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address2->cellAttributes() ?>>
<span id="el_doc_juzmatch3_contact_address2">
<input type="<?= $Page->contact_address2->getInputTextType() ?>" name="x_contact_address2" id="x_contact_address2" data-table="doc_juzmatch3" data-field="x_contact_address2" value="<?= $Page->contact_address2->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address2->getPlaceHolder()) ?>"<?= $Page->contact_address2->editAttributes() ?> aria-describedby="x_contact_address2_help">
<?= $Page->contact_address2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <div id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_contact_email" for="x_contact_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_email->caption() ?><?= $Page->contact_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_doc_juzmatch3_contact_email">
<input type="<?= $Page->contact_email->getInputTextType() ?>" name="x_contact_email" id="x_contact_email" data-table="doc_juzmatch3" data-field="x_contact_email" value="<?= $Page->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_email->getPlaceHolder()) ?>"<?= $Page->contact_email->editAttributes() ?> aria-describedby="x_contact_email_help">
<?= $Page->contact_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_lineid->Visible) { // contact_lineid ?>
    <div id="r_contact_lineid"<?= $Page->contact_lineid->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_contact_lineid" for="x_contact_lineid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_lineid->caption() ?><?= $Page->contact_lineid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_lineid->cellAttributes() ?>>
<span id="el_doc_juzmatch3_contact_lineid">
<input type="<?= $Page->contact_lineid->getInputTextType() ?>" name="x_contact_lineid" id="x_contact_lineid" data-table="doc_juzmatch3" data-field="x_contact_lineid" value="<?= $Page->contact_lineid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_lineid->getPlaceHolder()) ?>"<?= $Page->contact_lineid->editAttributes() ?> aria-describedby="x_contact_lineid_help">
<?= $Page->contact_lineid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_lineid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_phone->Visible) { // contact_phone ?>
    <div id="r_contact_phone"<?= $Page->contact_phone->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_contact_phone" for="x_contact_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_phone->caption() ?><?= $Page->contact_phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_phone->cellAttributes() ?>>
<span id="el_doc_juzmatch3_contact_phone">
<input type="<?= $Page->contact_phone->getInputTextType() ?>" name="x_contact_phone" id="x_contact_phone" data-table="doc_juzmatch3" data-field="x_contact_phone" value="<?= $Page->contact_phone->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_phone->getPlaceHolder()) ?>"<?= $Page->contact_phone->editAttributes() ?> aria-describedby="x_contact_phone_help">
<?= $Page->contact_phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file_idcard->Visible) { // file_idcard ?>
    <div id="r_file_idcard"<?= $Page->file_idcard->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_file_idcard" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_idcard->caption() ?><?= $Page->file_idcard->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_idcard->cellAttributes() ?>>
<span id="el_doc_juzmatch3_file_idcard">
<div id="fd_x_file_idcard" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_idcard->title() ?>" data-table="doc_juzmatch3" data-field="x_file_idcard" name="x_file_idcard" id="x_file_idcard" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_idcard->editAttributes() ?> aria-describedby="x_file_idcard_help"<?= ($Page->file_idcard->ReadOnly || $Page->file_idcard->Disabled) ? " disabled" : "" ?>>
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
        <label id="elh_doc_juzmatch3_file_house_regis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_house_regis->caption() ?><?= $Page->file_house_regis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_house_regis->cellAttributes() ?>>
<span id="el_doc_juzmatch3_file_house_regis">
<div id="fd_x_file_house_regis" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_house_regis->title() ?>" data-table="doc_juzmatch3" data-field="x_file_house_regis" name="x_file_house_regis" id="x_file_house_regis" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_house_regis->editAttributes() ?> aria-describedby="x_file_house_regis_help"<?= ($Page->file_house_regis->ReadOnly || $Page->file_house_regis->Disabled) ? " disabled" : "" ?>>
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
        <label id="elh_doc_juzmatch3_file_titledeed" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_titledeed->caption() ?><?= $Page->file_titledeed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_titledeed->cellAttributes() ?>>
<span id="el_doc_juzmatch3_file_titledeed">
<div id="fd_x_file_titledeed" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_titledeed->title() ?>" data-table="doc_juzmatch3" data-field="x_file_titledeed" name="x_file_titledeed" id="x_file_titledeed" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_titledeed->editAttributes() ?> aria-describedby="x_file_titledeed_help"<?= ($Page->file_titledeed->ReadOnly || $Page->file_titledeed->Disabled) ? " disabled" : "" ?>>
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
        <label id="elh_doc_juzmatch3_file_other" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_other->caption() ?><?= $Page->file_other->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file_other->cellAttributes() ?>>
<span id="el_doc_juzmatch3_file_other">
<div id="fd_x_file_other" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file_other->title() ?>" data-table="doc_juzmatch3" data-field="x_file_other" name="x_file_other" id="x_file_other" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_other->editAttributes() ?> aria-describedby="x_file_other_help"<?= ($Page->file_other->ReadOnly || $Page->file_other->Disabled) ? " disabled" : "" ?>>
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
<?php if ($Page->attach_file->Visible) { // attach_file ?>
    <div id="r_attach_file"<?= $Page->attach_file->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_attach_file" for="x_attach_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->attach_file->caption() ?><?= $Page->attach_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->attach_file->cellAttributes() ?>>
<span id="el_doc_juzmatch3_attach_file">
<input type="<?= $Page->attach_file->getInputTextType() ?>" name="x_attach_file" id="x_attach_file" data-table="doc_juzmatch3" data-field="x_attach_file" value="<?= $Page->attach_file->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->attach_file->getPlaceHolder()) ?>"<?= $Page->attach_file->editAttributes() ?> aria-describedby="x_attach_file_help">
<?= $Page->attach_file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->attach_file->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_doc_juzmatch3_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_doc_juzmatch3_status">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="fdoc_juzmatch3edit_x_status"
        data-table="doc_juzmatch3"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fdoc_juzmatch3edit", function() {
    var options = { name: "x_status", selectId: "fdoc_juzmatch3edit_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdoc_juzmatch3edit.lists.status.lookupOptions.length) {
        options.data = { id: "x_status", form: "fdoc_juzmatch3edit" };
    } else {
        options.ajax = { id: "x_status", form: "fdoc_juzmatch3edit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.doc_juzmatch3.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="doc_juzmatch3" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("doc_juzmatch3");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
