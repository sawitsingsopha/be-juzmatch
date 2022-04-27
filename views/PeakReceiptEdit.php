<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt: currentTable } });
var currentForm, currentPageID;
var fpeak_receiptedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receiptedit = new ew.Form("fpeak_receiptedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpeak_receiptedit;

    // Add fields
    var fields = currentTable.fields;
    fpeak_receiptedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["create_date", [fields.create_date.visible && fields.create_date.required ? ew.Validators.required(fields.create_date.caption) : null, ew.Validators.datetime(fields.create_date.clientFormatPattern)], fields.create_date.isInvalid],
        ["request_status", [fields.request_status.visible && fields.request_status.required ? ew.Validators.required(fields.request_status.caption) : null, ew.Validators.integer], fields.request_status.isInvalid],
        ["request_date", [fields.request_date.visible && fields.request_date.required ? ew.Validators.required(fields.request_date.caption) : null, ew.Validators.datetime(fields.request_date.clientFormatPattern)], fields.request_date.isInvalid],
        ["request_message", [fields.request_message.visible && fields.request_message.required ? ew.Validators.required(fields.request_message.caption) : null], fields.request_message.isInvalid],
        ["issueddate", [fields.issueddate.visible && fields.issueddate.required ? ew.Validators.required(fields.issueddate.caption) : null, ew.Validators.datetime(fields.issueddate.clientFormatPattern)], fields.issueddate.isInvalid],
        ["duedate", [fields.duedate.visible && fields.duedate.required ? ew.Validators.required(fields.duedate.caption) : null, ew.Validators.datetime(fields.duedate.clientFormatPattern)], fields.duedate.isInvalid],
        ["contactcode", [fields.contactcode.visible && fields.contactcode.required ? ew.Validators.required(fields.contactcode.caption) : null], fields.contactcode.isInvalid],
        ["tag", [fields.tag.visible && fields.tag.required ? ew.Validators.required(fields.tag.caption) : null], fields.tag.isInvalid],
        ["istaxinvoice", [fields.istaxinvoice.visible && fields.istaxinvoice.required ? ew.Validators.required(fields.istaxinvoice.caption) : null, ew.Validators.integer], fields.istaxinvoice.isInvalid],
        ["taxstatus", [fields.taxstatus.visible && fields.taxstatus.required ? ew.Validators.required(fields.taxstatus.caption) : null, ew.Validators.integer], fields.taxstatus.isInvalid],
        ["paymentdate", [fields.paymentdate.visible && fields.paymentdate.required ? ew.Validators.required(fields.paymentdate.caption) : null, ew.Validators.datetime(fields.paymentdate.clientFormatPattern)], fields.paymentdate.isInvalid],
        ["paymentmethodid", [fields.paymentmethodid.visible && fields.paymentmethodid.required ? ew.Validators.required(fields.paymentmethodid.caption) : null], fields.paymentmethodid.isInvalid],
        ["paymentMethodCode", [fields.paymentMethodCode.visible && fields.paymentMethodCode.required ? ew.Validators.required(fields.paymentMethodCode.caption) : null], fields.paymentMethodCode.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.float], fields.amount.isInvalid],
        ["remark", [fields.remark.visible && fields.remark.required ? ew.Validators.required(fields.remark.caption) : null], fields.remark.isInvalid],
        ["receipt_id", [fields.receipt_id.visible && fields.receipt_id.required ? ew.Validators.required(fields.receipt_id.caption) : null], fields.receipt_id.isInvalid],
        ["receipt_code", [fields.receipt_code.visible && fields.receipt_code.required ? ew.Validators.required(fields.receipt_code.caption) : null], fields.receipt_code.isInvalid],
        ["receipt_status", [fields.receipt_status.visible && fields.receipt_status.required ? ew.Validators.required(fields.receipt_status.caption) : null], fields.receipt_status.isInvalid],
        ["preTaxAmount", [fields.preTaxAmount.visible && fields.preTaxAmount.required ? ew.Validators.required(fields.preTaxAmount.caption) : null, ew.Validators.float], fields.preTaxAmount.isInvalid],
        ["vatAmount", [fields.vatAmount.visible && fields.vatAmount.required ? ew.Validators.required(fields.vatAmount.caption) : null, ew.Validators.float], fields.vatAmount.isInvalid],
        ["netAmount", [fields.netAmount.visible && fields.netAmount.required ? ew.Validators.required(fields.netAmount.caption) : null, ew.Validators.float], fields.netAmount.isInvalid],
        ["whtAmount", [fields.whtAmount.visible && fields.whtAmount.required ? ew.Validators.required(fields.whtAmount.caption) : null, ew.Validators.float], fields.whtAmount.isInvalid],
        ["paymentAmount", [fields.paymentAmount.visible && fields.paymentAmount.required ? ew.Validators.required(fields.paymentAmount.caption) : null, ew.Validators.float], fields.paymentAmount.isInvalid],
        ["remainAmount", [fields.remainAmount.visible && fields.remainAmount.required ? ew.Validators.required(fields.remainAmount.caption) : null, ew.Validators.float], fields.remainAmount.isInvalid],
        ["remainWhtAmount", [fields.remainWhtAmount.visible && fields.remainWhtAmount.required ? ew.Validators.required(fields.remainWhtAmount.caption) : null, ew.Validators.float], fields.remainWhtAmount.isInvalid],
        ["onlineViewLink", [fields.onlineViewLink.visible && fields.onlineViewLink.required ? ew.Validators.required(fields.onlineViewLink.caption) : null], fields.onlineViewLink.isInvalid],
        ["isPartialReceipt", [fields.isPartialReceipt.visible && fields.isPartialReceipt.required ? ew.Validators.required(fields.isPartialReceipt.caption) : null, ew.Validators.integer], fields.isPartialReceipt.isInvalid],
        ["journals_id", [fields.journals_id.visible && fields.journals_id.required ? ew.Validators.required(fields.journals_id.caption) : null], fields.journals_id.isInvalid],
        ["journals_code", [fields.journals_code.visible && fields.journals_code.required ? ew.Validators.required(fields.journals_code.caption) : null], fields.journals_code.isInvalid],
        ["refid", [fields.refid.visible && fields.refid.required ? ew.Validators.required(fields.refid.caption) : null, ew.Validators.integer], fields.refid.isInvalid],
        ["transition_type", [fields.transition_type.visible && fields.transition_type.required ? ew.Validators.required(fields.transition_type.caption) : null, ew.Validators.integer], fields.transition_type.isInvalid],
        ["is_email", [fields.is_email.visible && fields.is_email.required ? ew.Validators.required(fields.is_email.caption) : null, ew.Validators.integer], fields.is_email.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_receiptedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_receiptedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fpeak_receiptedit");
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
<form name="fpeak_receiptedit" id="fpeak_receiptedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_peak_receipt_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_receipt_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="peak_receipt" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
    <div id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <label id="elh_peak_receipt_create_date" for="x_create_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->create_date->caption() ?><?= $Page->create_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->create_date->cellAttributes() ?>>
<span id="el_peak_receipt_create_date">
<input type="<?= $Page->create_date->getInputTextType() ?>" name="x_create_date" id="x_create_date" data-table="peak_receipt" data-field="x_create_date" value="<?= $Page->create_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->create_date->getPlaceHolder()) ?>"<?= $Page->create_date->editAttributes() ?> aria-describedby="x_create_date_help">
<?= $Page->create_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->create_date->getErrorMessage() ?></div>
<?php if (!$Page->create_date->ReadOnly && !$Page->create_date->Disabled && !isset($Page->create_date->EditAttrs["readonly"]) && !isset($Page->create_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_receiptedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_receiptedit", "x_create_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
    <div id="r_request_status"<?= $Page->request_status->rowAttributes() ?>>
        <label id="elh_peak_receipt_request_status" for="x_request_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_status->caption() ?><?= $Page->request_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_status->cellAttributes() ?>>
<span id="el_peak_receipt_request_status">
<input type="<?= $Page->request_status->getInputTextType() ?>" name="x_request_status" id="x_request_status" data-table="peak_receipt" data-field="x_request_status" value="<?= $Page->request_status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->request_status->getPlaceHolder()) ?>"<?= $Page->request_status->editAttributes() ?> aria-describedby="x_request_status_help">
<?= $Page->request_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
    <div id="r_request_date"<?= $Page->request_date->rowAttributes() ?>>
        <label id="elh_peak_receipt_request_date" for="x_request_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_date->caption() ?><?= $Page->request_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_date->cellAttributes() ?>>
<span id="el_peak_receipt_request_date">
<input type="<?= $Page->request_date->getInputTextType() ?>" name="x_request_date" id="x_request_date" data-table="peak_receipt" data-field="x_request_date" value="<?= $Page->request_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->request_date->getPlaceHolder()) ?>"<?= $Page->request_date->editAttributes() ?> aria-describedby="x_request_date_help">
<?= $Page->request_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_date->getErrorMessage() ?></div>
<?php if (!$Page->request_date->ReadOnly && !$Page->request_date->Disabled && !isset($Page->request_date->EditAttrs["readonly"]) && !isset($Page->request_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_receiptedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_receiptedit", "x_request_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_message->Visible) { // request_message ?>
    <div id="r_request_message"<?= $Page->request_message->rowAttributes() ?>>
        <label id="elh_peak_receipt_request_message" for="x_request_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_message->caption() ?><?= $Page->request_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_message->cellAttributes() ?>>
<span id="el_peak_receipt_request_message">
<textarea data-table="peak_receipt" data-field="x_request_message" name="x_request_message" id="x_request_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->request_message->getPlaceHolder()) ?>"<?= $Page->request_message->editAttributes() ?> aria-describedby="x_request_message_help"><?= $Page->request_message->EditValue ?></textarea>
<?= $Page->request_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->issueddate->Visible) { // issueddate ?>
    <div id="r_issueddate"<?= $Page->issueddate->rowAttributes() ?>>
        <label id="elh_peak_receipt_issueddate" for="x_issueddate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->issueddate->caption() ?><?= $Page->issueddate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->issueddate->cellAttributes() ?>>
<span id="el_peak_receipt_issueddate">
<input type="<?= $Page->issueddate->getInputTextType() ?>" name="x_issueddate" id="x_issueddate" data-table="peak_receipt" data-field="x_issueddate" value="<?= $Page->issueddate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->issueddate->getPlaceHolder()) ?>"<?= $Page->issueddate->editAttributes() ?> aria-describedby="x_issueddate_help">
<?= $Page->issueddate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->issueddate->getErrorMessage() ?></div>
<?php if (!$Page->issueddate->ReadOnly && !$Page->issueddate->Disabled && !isset($Page->issueddate->EditAttrs["readonly"]) && !isset($Page->issueddate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_receiptedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_receiptedit", "x_issueddate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->duedate->Visible) { // duedate ?>
    <div id="r_duedate"<?= $Page->duedate->rowAttributes() ?>>
        <label id="elh_peak_receipt_duedate" for="x_duedate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->duedate->caption() ?><?= $Page->duedate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->duedate->cellAttributes() ?>>
<span id="el_peak_receipt_duedate">
<input type="<?= $Page->duedate->getInputTextType() ?>" name="x_duedate" id="x_duedate" data-table="peak_receipt" data-field="x_duedate" value="<?= $Page->duedate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->duedate->getPlaceHolder()) ?>"<?= $Page->duedate->editAttributes() ?> aria-describedby="x_duedate_help">
<?= $Page->duedate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->duedate->getErrorMessage() ?></div>
<?php if (!$Page->duedate->ReadOnly && !$Page->duedate->Disabled && !isset($Page->duedate->EditAttrs["readonly"]) && !isset($Page->duedate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_receiptedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_receiptedit", "x_duedate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contactcode->Visible) { // contactcode ?>
    <div id="r_contactcode"<?= $Page->contactcode->rowAttributes() ?>>
        <label id="elh_peak_receipt_contactcode" for="x_contactcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contactcode->caption() ?><?= $Page->contactcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contactcode->cellAttributes() ?>>
<span id="el_peak_receipt_contactcode">
<input type="<?= $Page->contactcode->getInputTextType() ?>" name="x_contactcode" id="x_contactcode" data-table="peak_receipt" data-field="x_contactcode" value="<?= $Page->contactcode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contactcode->getPlaceHolder()) ?>"<?= $Page->contactcode->editAttributes() ?> aria-describedby="x_contactcode_help">
<?= $Page->contactcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contactcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
    <div id="r_tag"<?= $Page->tag->rowAttributes() ?>>
        <label id="elh_peak_receipt_tag" for="x_tag" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tag->caption() ?><?= $Page->tag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tag->cellAttributes() ?>>
<span id="el_peak_receipt_tag">
<textarea data-table="peak_receipt" data-field="x_tag" name="x_tag" id="x_tag" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->tag->getPlaceHolder()) ?>"<?= $Page->tag->editAttributes() ?> aria-describedby="x_tag_help"><?= $Page->tag->EditValue ?></textarea>
<?= $Page->tag->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tag->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->istaxinvoice->Visible) { // istaxinvoice ?>
    <div id="r_istaxinvoice"<?= $Page->istaxinvoice->rowAttributes() ?>>
        <label id="elh_peak_receipt_istaxinvoice" for="x_istaxinvoice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->istaxinvoice->caption() ?><?= $Page->istaxinvoice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->istaxinvoice->cellAttributes() ?>>
<span id="el_peak_receipt_istaxinvoice">
<input type="<?= $Page->istaxinvoice->getInputTextType() ?>" name="x_istaxinvoice" id="x_istaxinvoice" data-table="peak_receipt" data-field="x_istaxinvoice" value="<?= $Page->istaxinvoice->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->istaxinvoice->getPlaceHolder()) ?>"<?= $Page->istaxinvoice->editAttributes() ?> aria-describedby="x_istaxinvoice_help">
<?= $Page->istaxinvoice->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->istaxinvoice->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->taxstatus->Visible) { // taxstatus ?>
    <div id="r_taxstatus"<?= $Page->taxstatus->rowAttributes() ?>>
        <label id="elh_peak_receipt_taxstatus" for="x_taxstatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->taxstatus->caption() ?><?= $Page->taxstatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->taxstatus->cellAttributes() ?>>
<span id="el_peak_receipt_taxstatus">
<input type="<?= $Page->taxstatus->getInputTextType() ?>" name="x_taxstatus" id="x_taxstatus" data-table="peak_receipt" data-field="x_taxstatus" value="<?= $Page->taxstatus->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->taxstatus->getPlaceHolder()) ?>"<?= $Page->taxstatus->editAttributes() ?> aria-describedby="x_taxstatus_help">
<?= $Page->taxstatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->taxstatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentdate->Visible) { // paymentdate ?>
    <div id="r_paymentdate"<?= $Page->paymentdate->rowAttributes() ?>>
        <label id="elh_peak_receipt_paymentdate" for="x_paymentdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentdate->caption() ?><?= $Page->paymentdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentdate->cellAttributes() ?>>
<span id="el_peak_receipt_paymentdate">
<input type="<?= $Page->paymentdate->getInputTextType() ?>" name="x_paymentdate" id="x_paymentdate" data-table="peak_receipt" data-field="x_paymentdate" value="<?= $Page->paymentdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->paymentdate->getPlaceHolder()) ?>"<?= $Page->paymentdate->editAttributes() ?> aria-describedby="x_paymentdate_help">
<?= $Page->paymentdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentdate->getErrorMessage() ?></div>
<?php if (!$Page->paymentdate->ReadOnly && !$Page->paymentdate->Disabled && !isset($Page->paymentdate->EditAttrs["readonly"]) && !isset($Page->paymentdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_receiptedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_receiptedit", "x_paymentdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentmethodid->Visible) { // paymentmethodid ?>
    <div id="r_paymentmethodid"<?= $Page->paymentmethodid->rowAttributes() ?>>
        <label id="elh_peak_receipt_paymentmethodid" for="x_paymentmethodid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentmethodid->caption() ?><?= $Page->paymentmethodid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentmethodid->cellAttributes() ?>>
<span id="el_peak_receipt_paymentmethodid">
<input type="<?= $Page->paymentmethodid->getInputTextType() ?>" name="x_paymentmethodid" id="x_paymentmethodid" data-table="peak_receipt" data-field="x_paymentmethodid" value="<?= $Page->paymentmethodid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->paymentmethodid->getPlaceHolder()) ?>"<?= $Page->paymentmethodid->editAttributes() ?> aria-describedby="x_paymentmethodid_help">
<?= $Page->paymentmethodid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentmethodid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
    <div id="r_paymentMethodCode"<?= $Page->paymentMethodCode->rowAttributes() ?>>
        <label id="elh_peak_receipt_paymentMethodCode" for="x_paymentMethodCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentMethodCode->caption() ?><?= $Page->paymentMethodCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el_peak_receipt_paymentMethodCode">
<input type="<?= $Page->paymentMethodCode->getInputTextType() ?>" name="x_paymentMethodCode" id="x_paymentMethodCode" data-table="peak_receipt" data-field="x_paymentMethodCode" value="<?= $Page->paymentMethodCode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->paymentMethodCode->getPlaceHolder()) ?>"<?= $Page->paymentMethodCode->editAttributes() ?> aria-describedby="x_paymentMethodCode_help">
<?= $Page->paymentMethodCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentMethodCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_peak_receipt_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<span id="el_peak_receipt_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="peak_receipt" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remark->Visible) { // remark ?>
    <div id="r_remark"<?= $Page->remark->rowAttributes() ?>>
        <label id="elh_peak_receipt_remark" for="x_remark" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remark->caption() ?><?= $Page->remark->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remark->cellAttributes() ?>>
<span id="el_peak_receipt_remark">
<input type="<?= $Page->remark->getInputTextType() ?>" name="x_remark" id="x_remark" data-table="peak_receipt" data-field="x_remark" value="<?= $Page->remark->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->remark->getPlaceHolder()) ?>"<?= $Page->remark->editAttributes() ?> aria-describedby="x_remark_help">
<?= $Page->remark->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remark->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_id->Visible) { // receipt_id ?>
    <div id="r_receipt_id"<?= $Page->receipt_id->rowAttributes() ?>>
        <label id="elh_peak_receipt_receipt_id" for="x_receipt_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt_id->caption() ?><?= $Page->receipt_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt_id->cellAttributes() ?>>
<span id="el_peak_receipt_receipt_id">
<input type="<?= $Page->receipt_id->getInputTextType() ?>" name="x_receipt_id" id="x_receipt_id" data-table="peak_receipt" data-field="x_receipt_id" value="<?= $Page->receipt_id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->receipt_id->getPlaceHolder()) ?>"<?= $Page->receipt_id->editAttributes() ?> aria-describedby="x_receipt_id_help">
<?= $Page->receipt_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_code->Visible) { // receipt_code ?>
    <div id="r_receipt_code"<?= $Page->receipt_code->rowAttributes() ?>>
        <label id="elh_peak_receipt_receipt_code" for="x_receipt_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt_code->caption() ?><?= $Page->receipt_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt_code->cellAttributes() ?>>
<span id="el_peak_receipt_receipt_code">
<input type="<?= $Page->receipt_code->getInputTextType() ?>" name="x_receipt_code" id="x_receipt_code" data-table="peak_receipt" data-field="x_receipt_code" value="<?= $Page->receipt_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->receipt_code->getPlaceHolder()) ?>"<?= $Page->receipt_code->editAttributes() ?> aria-describedby="x_receipt_code_help">
<?= $Page->receipt_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
    <div id="r_receipt_status"<?= $Page->receipt_status->rowAttributes() ?>>
        <label id="elh_peak_receipt_receipt_status" for="x_receipt_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt_status->caption() ?><?= $Page->receipt_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el_peak_receipt_receipt_status">
<input type="<?= $Page->receipt_status->getInputTextType() ?>" name="x_receipt_status" id="x_receipt_status" data-table="peak_receipt" data-field="x_receipt_status" value="<?= $Page->receipt_status->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->receipt_status->getPlaceHolder()) ?>"<?= $Page->receipt_status->editAttributes() ?> aria-describedby="x_receipt_status_help">
<?= $Page->receipt_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
    <div id="r_preTaxAmount"<?= $Page->preTaxAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_preTaxAmount" for="x_preTaxAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->preTaxAmount->caption() ?><?= $Page->preTaxAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el_peak_receipt_preTaxAmount">
<input type="<?= $Page->preTaxAmount->getInputTextType() ?>" name="x_preTaxAmount" id="x_preTaxAmount" data-table="peak_receipt" data-field="x_preTaxAmount" value="<?= $Page->preTaxAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->preTaxAmount->getPlaceHolder()) ?>"<?= $Page->preTaxAmount->editAttributes() ?> aria-describedby="x_preTaxAmount_help">
<?= $Page->preTaxAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->preTaxAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
    <div id="r_vatAmount"<?= $Page->vatAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_vatAmount" for="x_vatAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vatAmount->caption() ?><?= $Page->vatAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el_peak_receipt_vatAmount">
<input type="<?= $Page->vatAmount->getInputTextType() ?>" name="x_vatAmount" id="x_vatAmount" data-table="peak_receipt" data-field="x_vatAmount" value="<?= $Page->vatAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vatAmount->getPlaceHolder()) ?>"<?= $Page->vatAmount->editAttributes() ?> aria-describedby="x_vatAmount_help">
<?= $Page->vatAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vatAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
    <div id="r_netAmount"<?= $Page->netAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_netAmount" for="x_netAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->netAmount->caption() ?><?= $Page->netAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->netAmount->cellAttributes() ?>>
<span id="el_peak_receipt_netAmount">
<input type="<?= $Page->netAmount->getInputTextType() ?>" name="x_netAmount" id="x_netAmount" data-table="peak_receipt" data-field="x_netAmount" value="<?= $Page->netAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->netAmount->getPlaceHolder()) ?>"<?= $Page->netAmount->editAttributes() ?> aria-describedby="x_netAmount_help">
<?= $Page->netAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->netAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
    <div id="r_whtAmount"<?= $Page->whtAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_whtAmount" for="x_whtAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->whtAmount->caption() ?><?= $Page->whtAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el_peak_receipt_whtAmount">
<input type="<?= $Page->whtAmount->getInputTextType() ?>" name="x_whtAmount" id="x_whtAmount" data-table="peak_receipt" data-field="x_whtAmount" value="<?= $Page->whtAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->whtAmount->getPlaceHolder()) ?>"<?= $Page->whtAmount->editAttributes() ?> aria-describedby="x_whtAmount_help">
<?= $Page->whtAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->whtAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
    <div id="r_paymentAmount"<?= $Page->paymentAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_paymentAmount" for="x_paymentAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentAmount->caption() ?><?= $Page->paymentAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el_peak_receipt_paymentAmount">
<input type="<?= $Page->paymentAmount->getInputTextType() ?>" name="x_paymentAmount" id="x_paymentAmount" data-table="peak_receipt" data-field="x_paymentAmount" value="<?= $Page->paymentAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->paymentAmount->getPlaceHolder()) ?>"<?= $Page->paymentAmount->editAttributes() ?> aria-describedby="x_paymentAmount_help">
<?= $Page->paymentAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
    <div id="r_remainAmount"<?= $Page->remainAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_remainAmount" for="x_remainAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remainAmount->caption() ?><?= $Page->remainAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el_peak_receipt_remainAmount">
<input type="<?= $Page->remainAmount->getInputTextType() ?>" name="x_remainAmount" id="x_remainAmount" data-table="peak_receipt" data-field="x_remainAmount" value="<?= $Page->remainAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->remainAmount->getPlaceHolder()) ?>"<?= $Page->remainAmount->editAttributes() ?> aria-describedby="x_remainAmount_help">
<?= $Page->remainAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remainAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remainWhtAmount->Visible) { // remainWhtAmount ?>
    <div id="r_remainWhtAmount"<?= $Page->remainWhtAmount->rowAttributes() ?>>
        <label id="elh_peak_receipt_remainWhtAmount" for="x_remainWhtAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remainWhtAmount->caption() ?><?= $Page->remainWhtAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remainWhtAmount->cellAttributes() ?>>
<span id="el_peak_receipt_remainWhtAmount">
<input type="<?= $Page->remainWhtAmount->getInputTextType() ?>" name="x_remainWhtAmount" id="x_remainWhtAmount" data-table="peak_receipt" data-field="x_remainWhtAmount" value="<?= $Page->remainWhtAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->remainWhtAmount->getPlaceHolder()) ?>"<?= $Page->remainWhtAmount->editAttributes() ?> aria-describedby="x_remainWhtAmount_help">
<?= $Page->remainWhtAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remainWhtAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->onlineViewLink->Visible) { // onlineViewLink ?>
    <div id="r_onlineViewLink"<?= $Page->onlineViewLink->rowAttributes() ?>>
        <label id="elh_peak_receipt_onlineViewLink" for="x_onlineViewLink" class="<?= $Page->LeftColumnClass ?>"><?= $Page->onlineViewLink->caption() ?><?= $Page->onlineViewLink->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->onlineViewLink->cellAttributes() ?>>
<span id="el_peak_receipt_onlineViewLink">
<textarea data-table="peak_receipt" data-field="x_onlineViewLink" name="x_onlineViewLink" id="x_onlineViewLink" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->onlineViewLink->getPlaceHolder()) ?>"<?= $Page->onlineViewLink->editAttributes() ?> aria-describedby="x_onlineViewLink_help"><?= $Page->onlineViewLink->EditValue ?></textarea>
<?= $Page->onlineViewLink->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->onlineViewLink->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isPartialReceipt->Visible) { // isPartialReceipt ?>
    <div id="r_isPartialReceipt"<?= $Page->isPartialReceipt->rowAttributes() ?>>
        <label id="elh_peak_receipt_isPartialReceipt" for="x_isPartialReceipt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isPartialReceipt->caption() ?><?= $Page->isPartialReceipt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isPartialReceipt->cellAttributes() ?>>
<span id="el_peak_receipt_isPartialReceipt">
<input type="<?= $Page->isPartialReceipt->getInputTextType() ?>" name="x_isPartialReceipt" id="x_isPartialReceipt" data-table="peak_receipt" data-field="x_isPartialReceipt" value="<?= $Page->isPartialReceipt->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->isPartialReceipt->getPlaceHolder()) ?>"<?= $Page->isPartialReceipt->editAttributes() ?> aria-describedby="x_isPartialReceipt_help">
<?= $Page->isPartialReceipt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isPartialReceipt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
    <div id="r_journals_id"<?= $Page->journals_id->rowAttributes() ?>>
        <label id="elh_peak_receipt_journals_id" for="x_journals_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->journals_id->caption() ?><?= $Page->journals_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->journals_id->cellAttributes() ?>>
<span id="el_peak_receipt_journals_id">
<input type="<?= $Page->journals_id->getInputTextType() ?>" name="x_journals_id" id="x_journals_id" data-table="peak_receipt" data-field="x_journals_id" value="<?= $Page->journals_id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->journals_id->getPlaceHolder()) ?>"<?= $Page->journals_id->editAttributes() ?> aria-describedby="x_journals_id_help">
<?= $Page->journals_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->journals_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
    <div id="r_journals_code"<?= $Page->journals_code->rowAttributes() ?>>
        <label id="elh_peak_receipt_journals_code" for="x_journals_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->journals_code->caption() ?><?= $Page->journals_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->journals_code->cellAttributes() ?>>
<span id="el_peak_receipt_journals_code">
<input type="<?= $Page->journals_code->getInputTextType() ?>" name="x_journals_code" id="x_journals_code" data-table="peak_receipt" data-field="x_journals_code" value="<?= $Page->journals_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->journals_code->getPlaceHolder()) ?>"<?= $Page->journals_code->editAttributes() ?> aria-describedby="x_journals_code_help">
<?= $Page->journals_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->journals_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
    <div id="r_refid"<?= $Page->refid->rowAttributes() ?>>
        <label id="elh_peak_receipt_refid" for="x_refid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->refid->caption() ?><?= $Page->refid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->refid->cellAttributes() ?>>
<span id="el_peak_receipt_refid">
<input type="<?= $Page->refid->getInputTextType() ?>" name="x_refid" id="x_refid" data-table="peak_receipt" data-field="x_refid" value="<?= $Page->refid->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->refid->getPlaceHolder()) ?>"<?= $Page->refid->editAttributes() ?> aria-describedby="x_refid_help">
<?= $Page->refid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->refid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->transition_type->Visible) { // transition_type ?>
    <div id="r_transition_type"<?= $Page->transition_type->rowAttributes() ?>>
        <label id="elh_peak_receipt_transition_type" for="x_transition_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->transition_type->caption() ?><?= $Page->transition_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->transition_type->cellAttributes() ?>>
<span id="el_peak_receipt_transition_type">
<input type="<?= $Page->transition_type->getInputTextType() ?>" name="x_transition_type" id="x_transition_type" data-table="peak_receipt" data-field="x_transition_type" value="<?= $Page->transition_type->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->transition_type->getPlaceHolder()) ?>"<?= $Page->transition_type->editAttributes() ?> aria-describedby="x_transition_type_help">
<?= $Page->transition_type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->transition_type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
    <div id="r_is_email"<?= $Page->is_email->rowAttributes() ?>>
        <label id="elh_peak_receipt_is_email" for="x_is_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_email->caption() ?><?= $Page->is_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->is_email->cellAttributes() ?>>
<span id="el_peak_receipt_is_email">
<input type="<?= $Page->is_email->getInputTextType() ?>" name="x_is_email" id="x_is_email" data-table="peak_receipt" data-field="x_is_email" value="<?= $Page->is_email->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->is_email->getPlaceHolder()) ?>"<?= $Page->is_email->editAttributes() ?> aria-describedby="x_is_email_help">
<?= $Page->is_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_email->getErrorMessage() ?></div>
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
    ew.addEventHandlers("peak_receipt");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
