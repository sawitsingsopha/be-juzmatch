<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakContactAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_contact: currentTable } });
var currentForm, currentPageID;
var fpeak_contactadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_contactadd = new ew.Form("fpeak_contactadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fpeak_contactadd;

    // Add fields
    var fields = currentTable.fields;
    fpeak_contactadd.addFields([
        ["create_date", [fields.create_date.visible && fields.create_date.required ? ew.Validators.required(fields.create_date.caption) : null, ew.Validators.datetime(fields.create_date.clientFormatPattern)], fields.create_date.isInvalid],
        ["request_status", [fields.request_status.visible && fields.request_status.required ? ew.Validators.required(fields.request_status.caption) : null, ew.Validators.integer], fields.request_status.isInvalid],
        ["request_date", [fields.request_date.visible && fields.request_date.required ? ew.Validators.required(fields.request_date.caption) : null, ew.Validators.datetime(fields.request_date.clientFormatPattern)], fields.request_date.isInvalid],
        ["request_message", [fields.request_message.visible && fields.request_message.required ? ew.Validators.required(fields.request_message.caption) : null], fields.request_message.isInvalid],
        ["contact_id", [fields.contact_id.visible && fields.contact_id.required ? ew.Validators.required(fields.contact_id.caption) : null], fields.contact_id.isInvalid],
        ["contact_code", [fields.contact_code.visible && fields.contact_code.required ? ew.Validators.required(fields.contact_code.caption) : null], fields.contact_code.isInvalid],
        ["contact_name", [fields.contact_name.visible && fields.contact_name.required ? ew.Validators.required(fields.contact_name.caption) : null], fields.contact_name.isInvalid],
        ["contact_type", [fields.contact_type.visible && fields.contact_type.required ? ew.Validators.required(fields.contact_type.caption) : null, ew.Validators.integer], fields.contact_type.isInvalid],
        ["contact_taxnumber", [fields.contact_taxnumber.visible && fields.contact_taxnumber.required ? ew.Validators.required(fields.contact_taxnumber.caption) : null], fields.contact_taxnumber.isInvalid],
        ["contact_branchcode", [fields.contact_branchcode.visible && fields.contact_branchcode.required ? ew.Validators.required(fields.contact_branchcode.caption) : null], fields.contact_branchcode.isInvalid],
        ["contact_address", [fields.contact_address.visible && fields.contact_address.required ? ew.Validators.required(fields.contact_address.caption) : null], fields.contact_address.isInvalid],
        ["contact_subdistrict", [fields.contact_subdistrict.visible && fields.contact_subdistrict.required ? ew.Validators.required(fields.contact_subdistrict.caption) : null], fields.contact_subdistrict.isInvalid],
        ["contact_district", [fields.contact_district.visible && fields.contact_district.required ? ew.Validators.required(fields.contact_district.caption) : null], fields.contact_district.isInvalid],
        ["contact_province", [fields.contact_province.visible && fields.contact_province.required ? ew.Validators.required(fields.contact_province.caption) : null], fields.contact_province.isInvalid],
        ["contact_country", [fields.contact_country.visible && fields.contact_country.required ? ew.Validators.required(fields.contact_country.caption) : null], fields.contact_country.isInvalid],
        ["contact_postcode", [fields.contact_postcode.visible && fields.contact_postcode.required ? ew.Validators.required(fields.contact_postcode.caption) : null], fields.contact_postcode.isInvalid],
        ["contact_callcenternumber", [fields.contact_callcenternumber.visible && fields.contact_callcenternumber.required ? ew.Validators.required(fields.contact_callcenternumber.caption) : null], fields.contact_callcenternumber.isInvalid],
        ["contact_faxnumber", [fields.contact_faxnumber.visible && fields.contact_faxnumber.required ? ew.Validators.required(fields.contact_faxnumber.caption) : null], fields.contact_faxnumber.isInvalid],
        ["contact_email", [fields.contact_email.visible && fields.contact_email.required ? ew.Validators.required(fields.contact_email.caption) : null], fields.contact_email.isInvalid],
        ["contact_website", [fields.contact_website.visible && fields.contact_website.required ? ew.Validators.required(fields.contact_website.caption) : null], fields.contact_website.isInvalid],
        ["contact_contactfirstname", [fields.contact_contactfirstname.visible && fields.contact_contactfirstname.required ? ew.Validators.required(fields.contact_contactfirstname.caption) : null], fields.contact_contactfirstname.isInvalid],
        ["contact_contactlastname", [fields.contact_contactlastname.visible && fields.contact_contactlastname.required ? ew.Validators.required(fields.contact_contactlastname.caption) : null], fields.contact_contactlastname.isInvalid],
        ["contact_contactnickname", [fields.contact_contactnickname.visible && fields.contact_contactnickname.required ? ew.Validators.required(fields.contact_contactnickname.caption) : null], fields.contact_contactnickname.isInvalid],
        ["contact_contactpostition", [fields.contact_contactpostition.visible && fields.contact_contactpostition.required ? ew.Validators.required(fields.contact_contactpostition.caption) : null], fields.contact_contactpostition.isInvalid],
        ["contact_contactphonenumber", [fields.contact_contactphonenumber.visible && fields.contact_contactphonenumber.required ? ew.Validators.required(fields.contact_contactphonenumber.caption) : null], fields.contact_contactphonenumber.isInvalid],
        ["contact_contactcontactemail", [fields.contact_contactcontactemail.visible && fields.contact_contactcontactemail.required ? ew.Validators.required(fields.contact_contactcontactemail.caption) : null], fields.contact_contactcontactemail.isInvalid],
        ["contact_purchaseaccount", [fields.contact_purchaseaccount.visible && fields.contact_purchaseaccount.required ? ew.Validators.required(fields.contact_purchaseaccount.caption) : null], fields.contact_purchaseaccount.isInvalid],
        ["contact_sellaccount", [fields.contact_sellaccount.visible && fields.contact_sellaccount.required ? ew.Validators.required(fields.contact_sellaccount.caption) : null], fields.contact_sellaccount.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null, ew.Validators.integer], fields.member_id.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_contactadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_contactadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fpeak_contactadd");
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
<form name="fpeak_contactadd" id="fpeak_contactadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_contact">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->create_date->Visible) { // create_date ?>
    <div id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <label id="elh_peak_contact_create_date" for="x_create_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->create_date->caption() ?><?= $Page->create_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->create_date->cellAttributes() ?>>
<span id="el_peak_contact_create_date">
<input type="<?= $Page->create_date->getInputTextType() ?>" name="x_create_date" id="x_create_date" data-table="peak_contact" data-field="x_create_date" value="<?= $Page->create_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->create_date->getPlaceHolder()) ?>"<?= $Page->create_date->editAttributes() ?> aria-describedby="x_create_date_help">
<?= $Page->create_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->create_date->getErrorMessage() ?></div>
<?php if (!$Page->create_date->ReadOnly && !$Page->create_date->Disabled && !isset($Page->create_date->EditAttrs["readonly"]) && !isset($Page->create_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_contactadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_contactadd", "x_create_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
    <div id="r_request_status"<?= $Page->request_status->rowAttributes() ?>>
        <label id="elh_peak_contact_request_status" for="x_request_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_status->caption() ?><?= $Page->request_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_status->cellAttributes() ?>>
<span id="el_peak_contact_request_status">
<input type="<?= $Page->request_status->getInputTextType() ?>" name="x_request_status" id="x_request_status" data-table="peak_contact" data-field="x_request_status" value="<?= $Page->request_status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->request_status->getPlaceHolder()) ?>"<?= $Page->request_status->editAttributes() ?> aria-describedby="x_request_status_help">
<?= $Page->request_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
    <div id="r_request_date"<?= $Page->request_date->rowAttributes() ?>>
        <label id="elh_peak_contact_request_date" for="x_request_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_date->caption() ?><?= $Page->request_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_date->cellAttributes() ?>>
<span id="el_peak_contact_request_date">
<input type="<?= $Page->request_date->getInputTextType() ?>" name="x_request_date" id="x_request_date" data-table="peak_contact" data-field="x_request_date" value="<?= $Page->request_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->request_date->getPlaceHolder()) ?>"<?= $Page->request_date->editAttributes() ?> aria-describedby="x_request_date_help">
<?= $Page->request_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_date->getErrorMessage() ?></div>
<?php if (!$Page->request_date->ReadOnly && !$Page->request_date->Disabled && !isset($Page->request_date->EditAttrs["readonly"]) && !isset($Page->request_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_contactadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_contactadd", "x_request_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_message->Visible) { // request_message ?>
    <div id="r_request_message"<?= $Page->request_message->rowAttributes() ?>>
        <label id="elh_peak_contact_request_message" for="x_request_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_message->caption() ?><?= $Page->request_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_message->cellAttributes() ?>>
<span id="el_peak_contact_request_message">
<textarea data-table="peak_contact" data-field="x_request_message" name="x_request_message" id="x_request_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->request_message->getPlaceHolder()) ?>"<?= $Page->request_message->editAttributes() ?> aria-describedby="x_request_message_help"><?= $Page->request_message->EditValue ?></textarea>
<?= $Page->request_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_id->Visible) { // contact_id ?>
    <div id="r_contact_id"<?= $Page->contact_id->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_id" for="x_contact_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_id->caption() ?><?= $Page->contact_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_id->cellAttributes() ?>>
<span id="el_peak_contact_contact_id">
<input type="<?= $Page->contact_id->getInputTextType() ?>" name="x_contact_id" id="x_contact_id" data-table="peak_contact" data-field="x_contact_id" value="<?= $Page->contact_id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_id->getPlaceHolder()) ?>"<?= $Page->contact_id->editAttributes() ?> aria-describedby="x_contact_id_help">
<?= $Page->contact_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_code->Visible) { // contact_code ?>
    <div id="r_contact_code"<?= $Page->contact_code->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_code" for="x_contact_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_code->caption() ?><?= $Page->contact_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_code->cellAttributes() ?>>
<span id="el_peak_contact_contact_code">
<input type="<?= $Page->contact_code->getInputTextType() ?>" name="x_contact_code" id="x_contact_code" data-table="peak_contact" data-field="x_contact_code" value="<?= $Page->contact_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_code->getPlaceHolder()) ?>"<?= $Page->contact_code->editAttributes() ?> aria-describedby="x_contact_code_help">
<?= $Page->contact_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
    <div id="r_contact_name"<?= $Page->contact_name->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_name" for="x_contact_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_name->caption() ?><?= $Page->contact_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_name->cellAttributes() ?>>
<span id="el_peak_contact_contact_name">
<input type="<?= $Page->contact_name->getInputTextType() ?>" name="x_contact_name" id="x_contact_name" data-table="peak_contact" data-field="x_contact_name" value="<?= $Page->contact_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_name->getPlaceHolder()) ?>"<?= $Page->contact_name->editAttributes() ?> aria-describedby="x_contact_name_help">
<?= $Page->contact_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_type->Visible) { // contact_type ?>
    <div id="r_contact_type"<?= $Page->contact_type->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_type" for="x_contact_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_type->caption() ?><?= $Page->contact_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_type->cellAttributes() ?>>
<span id="el_peak_contact_contact_type">
<input type="<?= $Page->contact_type->getInputTextType() ?>" name="x_contact_type" id="x_contact_type" data-table="peak_contact" data-field="x_contact_type" value="<?= $Page->contact_type->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->contact_type->getPlaceHolder()) ?>"<?= $Page->contact_type->editAttributes() ?> aria-describedby="x_contact_type_help">
<?= $Page->contact_type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_taxnumber->Visible) { // contact_taxnumber ?>
    <div id="r_contact_taxnumber"<?= $Page->contact_taxnumber->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_taxnumber" for="x_contact_taxnumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_taxnumber->caption() ?><?= $Page->contact_taxnumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_taxnumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_taxnumber">
<input type="<?= $Page->contact_taxnumber->getInputTextType() ?>" name="x_contact_taxnumber" id="x_contact_taxnumber" data-table="peak_contact" data-field="x_contact_taxnumber" value="<?= $Page->contact_taxnumber->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_taxnumber->getPlaceHolder()) ?>"<?= $Page->contact_taxnumber->editAttributes() ?> aria-describedby="x_contact_taxnumber_help">
<?= $Page->contact_taxnumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_taxnumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_branchcode->Visible) { // contact_branchcode ?>
    <div id="r_contact_branchcode"<?= $Page->contact_branchcode->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_branchcode" for="x_contact_branchcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_branchcode->caption() ?><?= $Page->contact_branchcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_branchcode->cellAttributes() ?>>
<span id="el_peak_contact_contact_branchcode">
<input type="<?= $Page->contact_branchcode->getInputTextType() ?>" name="x_contact_branchcode" id="x_contact_branchcode" data-table="peak_contact" data-field="x_contact_branchcode" value="<?= $Page->contact_branchcode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_branchcode->getPlaceHolder()) ?>"<?= $Page->contact_branchcode->editAttributes() ?> aria-describedby="x_contact_branchcode_help">
<?= $Page->contact_branchcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_branchcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <div id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_address" for="x_contact_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_address->caption() ?><?= $Page->contact_address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_peak_contact_contact_address">
<input type="<?= $Page->contact_address->getInputTextType() ?>" name="x_contact_address" id="x_contact_address" data-table="peak_contact" data-field="x_contact_address" value="<?= $Page->contact_address->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_address->getPlaceHolder()) ?>"<?= $Page->contact_address->editAttributes() ?> aria-describedby="x_contact_address_help">
<?= $Page->contact_address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_subdistrict->Visible) { // contact_subdistrict ?>
    <div id="r_contact_subdistrict"<?= $Page->contact_subdistrict->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_subdistrict" for="x_contact_subdistrict" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_subdistrict->caption() ?><?= $Page->contact_subdistrict->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_subdistrict->cellAttributes() ?>>
<span id="el_peak_contact_contact_subdistrict">
<input type="<?= $Page->contact_subdistrict->getInputTextType() ?>" name="x_contact_subdistrict" id="x_contact_subdistrict" data-table="peak_contact" data-field="x_contact_subdistrict" value="<?= $Page->contact_subdistrict->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_subdistrict->getPlaceHolder()) ?>"<?= $Page->contact_subdistrict->editAttributes() ?> aria-describedby="x_contact_subdistrict_help">
<?= $Page->contact_subdistrict->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_subdistrict->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_district->Visible) { // contact_district ?>
    <div id="r_contact_district"<?= $Page->contact_district->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_district" for="x_contact_district" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_district->caption() ?><?= $Page->contact_district->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_district->cellAttributes() ?>>
<span id="el_peak_contact_contact_district">
<input type="<?= $Page->contact_district->getInputTextType() ?>" name="x_contact_district" id="x_contact_district" data-table="peak_contact" data-field="x_contact_district" value="<?= $Page->contact_district->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_district->getPlaceHolder()) ?>"<?= $Page->contact_district->editAttributes() ?> aria-describedby="x_contact_district_help">
<?= $Page->contact_district->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_district->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_province->Visible) { // contact_province ?>
    <div id="r_contact_province"<?= $Page->contact_province->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_province" for="x_contact_province" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_province->caption() ?><?= $Page->contact_province->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_province->cellAttributes() ?>>
<span id="el_peak_contact_contact_province">
<input type="<?= $Page->contact_province->getInputTextType() ?>" name="x_contact_province" id="x_contact_province" data-table="peak_contact" data-field="x_contact_province" value="<?= $Page->contact_province->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_province->getPlaceHolder()) ?>"<?= $Page->contact_province->editAttributes() ?> aria-describedby="x_contact_province_help">
<?= $Page->contact_province->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_province->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_country->Visible) { // contact_country ?>
    <div id="r_contact_country"<?= $Page->contact_country->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_country" for="x_contact_country" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_country->caption() ?><?= $Page->contact_country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_country->cellAttributes() ?>>
<span id="el_peak_contact_contact_country">
<input type="<?= $Page->contact_country->getInputTextType() ?>" name="x_contact_country" id="x_contact_country" data-table="peak_contact" data-field="x_contact_country" value="<?= $Page->contact_country->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_country->getPlaceHolder()) ?>"<?= $Page->contact_country->editAttributes() ?> aria-describedby="x_contact_country_help">
<?= $Page->contact_country->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_country->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_postcode->Visible) { // contact_postcode ?>
    <div id="r_contact_postcode"<?= $Page->contact_postcode->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_postcode" for="x_contact_postcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_postcode->caption() ?><?= $Page->contact_postcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_postcode->cellAttributes() ?>>
<span id="el_peak_contact_contact_postcode">
<input type="<?= $Page->contact_postcode->getInputTextType() ?>" name="x_contact_postcode" id="x_contact_postcode" data-table="peak_contact" data-field="x_contact_postcode" value="<?= $Page->contact_postcode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_postcode->getPlaceHolder()) ?>"<?= $Page->contact_postcode->editAttributes() ?> aria-describedby="x_contact_postcode_help">
<?= $Page->contact_postcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_postcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_callcenternumber->Visible) { // contact_callcenternumber ?>
    <div id="r_contact_callcenternumber"<?= $Page->contact_callcenternumber->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_callcenternumber" for="x_contact_callcenternumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_callcenternumber->caption() ?><?= $Page->contact_callcenternumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_callcenternumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_callcenternumber">
<input type="<?= $Page->contact_callcenternumber->getInputTextType() ?>" name="x_contact_callcenternumber" id="x_contact_callcenternumber" data-table="peak_contact" data-field="x_contact_callcenternumber" value="<?= $Page->contact_callcenternumber->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_callcenternumber->getPlaceHolder()) ?>"<?= $Page->contact_callcenternumber->editAttributes() ?> aria-describedby="x_contact_callcenternumber_help">
<?= $Page->contact_callcenternumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_callcenternumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_faxnumber->Visible) { // contact_faxnumber ?>
    <div id="r_contact_faxnumber"<?= $Page->contact_faxnumber->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_faxnumber" for="x_contact_faxnumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_faxnumber->caption() ?><?= $Page->contact_faxnumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_faxnumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_faxnumber">
<input type="<?= $Page->contact_faxnumber->getInputTextType() ?>" name="x_contact_faxnumber" id="x_contact_faxnumber" data-table="peak_contact" data-field="x_contact_faxnumber" value="<?= $Page->contact_faxnumber->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_faxnumber->getPlaceHolder()) ?>"<?= $Page->contact_faxnumber->editAttributes() ?> aria-describedby="x_contact_faxnumber_help">
<?= $Page->contact_faxnumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_faxnumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <div id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_email" for="x_contact_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_email->caption() ?><?= $Page->contact_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_peak_contact_contact_email">
<input type="<?= $Page->contact_email->getInputTextType() ?>" name="x_contact_email" id="x_contact_email" data-table="peak_contact" data-field="x_contact_email" value="<?= $Page->contact_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_email->getPlaceHolder()) ?>"<?= $Page->contact_email->editAttributes() ?> aria-describedby="x_contact_email_help">
<?= $Page->contact_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_website->Visible) { // contact_website ?>
    <div id="r_contact_website"<?= $Page->contact_website->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_website" for="x_contact_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_website->caption() ?><?= $Page->contact_website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_website->cellAttributes() ?>>
<span id="el_peak_contact_contact_website">
<input type="<?= $Page->contact_website->getInputTextType() ?>" name="x_contact_website" id="x_contact_website" data-table="peak_contact" data-field="x_contact_website" value="<?= $Page->contact_website->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_website->getPlaceHolder()) ?>"<?= $Page->contact_website->editAttributes() ?> aria-describedby="x_contact_website_help">
<?= $Page->contact_website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_contactfirstname->Visible) { // contact_contactfirstname ?>
    <div id="r_contact_contactfirstname"<?= $Page->contact_contactfirstname->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_contactfirstname" for="x_contact_contactfirstname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_contactfirstname->caption() ?><?= $Page->contact_contactfirstname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_contactfirstname->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactfirstname">
<input type="<?= $Page->contact_contactfirstname->getInputTextType() ?>" name="x_contact_contactfirstname" id="x_contact_contactfirstname" data-table="peak_contact" data-field="x_contact_contactfirstname" value="<?= $Page->contact_contactfirstname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_contactfirstname->getPlaceHolder()) ?>"<?= $Page->contact_contactfirstname->editAttributes() ?> aria-describedby="x_contact_contactfirstname_help">
<?= $Page->contact_contactfirstname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_contactfirstname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_contactlastname->Visible) { // contact_contactlastname ?>
    <div id="r_contact_contactlastname"<?= $Page->contact_contactlastname->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_contactlastname" for="x_contact_contactlastname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_contactlastname->caption() ?><?= $Page->contact_contactlastname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_contactlastname->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactlastname">
<input type="<?= $Page->contact_contactlastname->getInputTextType() ?>" name="x_contact_contactlastname" id="x_contact_contactlastname" data-table="peak_contact" data-field="x_contact_contactlastname" value="<?= $Page->contact_contactlastname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_contactlastname->getPlaceHolder()) ?>"<?= $Page->contact_contactlastname->editAttributes() ?> aria-describedby="x_contact_contactlastname_help">
<?= $Page->contact_contactlastname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_contactlastname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_contactnickname->Visible) { // contact_contactnickname ?>
    <div id="r_contact_contactnickname"<?= $Page->contact_contactnickname->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_contactnickname" for="x_contact_contactnickname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_contactnickname->caption() ?><?= $Page->contact_contactnickname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_contactnickname->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactnickname">
<input type="<?= $Page->contact_contactnickname->getInputTextType() ?>" name="x_contact_contactnickname" id="x_contact_contactnickname" data-table="peak_contact" data-field="x_contact_contactnickname" value="<?= $Page->contact_contactnickname->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_contactnickname->getPlaceHolder()) ?>"<?= $Page->contact_contactnickname->editAttributes() ?> aria-describedby="x_contact_contactnickname_help">
<?= $Page->contact_contactnickname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_contactnickname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_contactpostition->Visible) { // contact_contactpostition ?>
    <div id="r_contact_contactpostition"<?= $Page->contact_contactpostition->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_contactpostition" for="x_contact_contactpostition" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_contactpostition->caption() ?><?= $Page->contact_contactpostition->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_contactpostition->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactpostition">
<input type="<?= $Page->contact_contactpostition->getInputTextType() ?>" name="x_contact_contactpostition" id="x_contact_contactpostition" data-table="peak_contact" data-field="x_contact_contactpostition" value="<?= $Page->contact_contactpostition->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_contactpostition->getPlaceHolder()) ?>"<?= $Page->contact_contactpostition->editAttributes() ?> aria-describedby="x_contact_contactpostition_help">
<?= $Page->contact_contactpostition->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_contactpostition->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_contactphonenumber->Visible) { // contact_contactphonenumber ?>
    <div id="r_contact_contactphonenumber"<?= $Page->contact_contactphonenumber->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_contactphonenumber" for="x_contact_contactphonenumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_contactphonenumber->caption() ?><?= $Page->contact_contactphonenumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_contactphonenumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactphonenumber">
<input type="<?= $Page->contact_contactphonenumber->getInputTextType() ?>" name="x_contact_contactphonenumber" id="x_contact_contactphonenumber" data-table="peak_contact" data-field="x_contact_contactphonenumber" value="<?= $Page->contact_contactphonenumber->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_contactphonenumber->getPlaceHolder()) ?>"<?= $Page->contact_contactphonenumber->editAttributes() ?> aria-describedby="x_contact_contactphonenumber_help">
<?= $Page->contact_contactphonenumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_contactphonenumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_contactcontactemail->Visible) { // contact_contactcontactemail ?>
    <div id="r_contact_contactcontactemail"<?= $Page->contact_contactcontactemail->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_contactcontactemail" for="x_contact_contactcontactemail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_contactcontactemail->caption() ?><?= $Page->contact_contactcontactemail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_contactcontactemail->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactcontactemail">
<input type="<?= $Page->contact_contactcontactemail->getInputTextType() ?>" name="x_contact_contactcontactemail" id="x_contact_contactcontactemail" data-table="peak_contact" data-field="x_contact_contactcontactemail" value="<?= $Page->contact_contactcontactemail->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_contactcontactemail->getPlaceHolder()) ?>"<?= $Page->contact_contactcontactemail->editAttributes() ?> aria-describedby="x_contact_contactcontactemail_help">
<?= $Page->contact_contactcontactemail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_contactcontactemail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_purchaseaccount->Visible) { // contact_purchaseaccount ?>
    <div id="r_contact_purchaseaccount"<?= $Page->contact_purchaseaccount->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_purchaseaccount" for="x_contact_purchaseaccount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_purchaseaccount->caption() ?><?= $Page->contact_purchaseaccount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_purchaseaccount->cellAttributes() ?>>
<span id="el_peak_contact_contact_purchaseaccount">
<input type="<?= $Page->contact_purchaseaccount->getInputTextType() ?>" name="x_contact_purchaseaccount" id="x_contact_purchaseaccount" data-table="peak_contact" data-field="x_contact_purchaseaccount" value="<?= $Page->contact_purchaseaccount->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_purchaseaccount->getPlaceHolder()) ?>"<?= $Page->contact_purchaseaccount->editAttributes() ?> aria-describedby="x_contact_purchaseaccount_help">
<?= $Page->contact_purchaseaccount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_purchaseaccount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_sellaccount->Visible) { // contact_sellaccount ?>
    <div id="r_contact_sellaccount"<?= $Page->contact_sellaccount->rowAttributes() ?>>
        <label id="elh_peak_contact_contact_sellaccount" for="x_contact_sellaccount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contact_sellaccount->caption() ?><?= $Page->contact_sellaccount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contact_sellaccount->cellAttributes() ?>>
<span id="el_peak_contact_contact_sellaccount">
<input type="<?= $Page->contact_sellaccount->getInputTextType() ?>" name="x_contact_sellaccount" id="x_contact_sellaccount" data-table="peak_contact" data-field="x_contact_sellaccount" value="<?= $Page->contact_sellaccount->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contact_sellaccount->getPlaceHolder()) ?>"<?= $Page->contact_sellaccount->editAttributes() ?> aria-describedby="x_contact_sellaccount_help">
<?= $Page->contact_sellaccount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_sellaccount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_peak_contact_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_peak_contact_member_id">
<input type="<?= $Page->member_id->getInputTextType() ?>" name="x_member_id" id="x_member_id" data-table="peak_contact" data-field="x_member_id" value="<?= $Page->member_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"<?= $Page->member_id->editAttributes() ?> aria-describedby="x_member_id_help">
<?= $Page->member_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("peak_contact");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
