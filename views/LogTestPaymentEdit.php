<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogTestPaymentEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_test_payment: currentTable } });
var currentForm, currentPageID;
var flog_test_paymentedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_test_paymentedit = new ew.Form("flog_test_paymentedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = flog_test_paymentedit;

    // Add fields
    var fields = currentTable.fields;
    flog_test_paymentedit.addFields([
        ["log_test_payment_id", [fields.log_test_payment_id.visible && fields.log_test_payment_id.required ? ew.Validators.required(fields.log_test_payment_id.caption) : null], fields.log_test_payment_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null, ew.Validators.integer], fields.member_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null, ew.Validators.integer], fields.asset_id.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null, ew.Validators.integer], fields.type.isInvalid],
        ["date_booking", [fields.date_booking.visible && fields.date_booking.required ? ew.Validators.required(fields.date_booking.caption) : null, ew.Validators.datetime(fields.date_booking.clientFormatPattern)], fields.date_booking.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["due_date", [fields.due_date.visible && fields.due_date.required ? ew.Validators.required(fields.due_date.caption) : null, ew.Validators.datetime(fields.due_date.clientFormatPattern)], fields.due_date.isInvalid],
        ["booking_price", [fields.booking_price.visible && fields.booking_price.required ? ew.Validators.required(fields.booking_price.caption) : null, ew.Validators.float], fields.booking_price.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null, ew.Validators.integer], fields.status_payment.isInvalid],
        ["transaction_datetime", [fields.transaction_datetime.visible && fields.transaction_datetime.required ? ew.Validators.required(fields.transaction_datetime.caption) : null, ew.Validators.datetime(fields.transaction_datetime.clientFormatPattern)], fields.transaction_datetime.isInvalid],
        ["payment_scheme", [fields.payment_scheme.visible && fields.payment_scheme.required ? ew.Validators.required(fields.payment_scheme.caption) : null], fields.payment_scheme.isInvalid],
        ["transaction_ref", [fields.transaction_ref.visible && fields.transaction_ref.required ? ew.Validators.required(fields.transaction_ref.caption) : null], fields.transaction_ref.isInvalid],
        ["channel_response_desc", [fields.channel_response_desc.visible && fields.channel_response_desc.required ? ew.Validators.required(fields.channel_response_desc.caption) : null], fields.channel_response_desc.isInvalid],
        ["res_status", [fields.res_status.visible && fields.res_status.required ? ew.Validators.required(fields.res_status.caption) : null], fields.res_status.isInvalid],
        ["res_referenceNo", [fields.res_referenceNo.visible && fields.res_referenceNo.required ? ew.Validators.required(fields.res_referenceNo.caption) : null], fields.res_referenceNo.isInvalid],
        ["res_paidAgent", [fields.res_paidAgent.visible && fields.res_paidAgent.required ? ew.Validators.required(fields.res_paidAgent.caption) : null], fields.res_paidAgent.isInvalid],
        ["res_paidChannel", [fields.res_paidChannel.visible && fields.res_paidChannel.required ? ew.Validators.required(fields.res_paidChannel.caption) : null], fields.res_paidChannel.isInvalid],
        ["res_maskedPan", [fields.res_maskedPan.visible && fields.res_maskedPan.required ? ew.Validators.required(fields.res_maskedPan.caption) : null], fields.res_maskedPan.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null, ew.Validators.integer], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null, ew.Validators.integer], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null, ew.Validators.datetime(fields.udate.clientFormatPattern)], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null, ew.Validators.integer], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    flog_test_paymentedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flog_test_paymentedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("flog_test_paymentedit");
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
<form name="flog_test_paymentedit" id="flog_test_paymentedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_test_payment">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->log_test_payment_id->Visible) { // log_test_payment_id ?>
    <div id="r_log_test_payment_id"<?= $Page->log_test_payment_id->rowAttributes() ?>>
        <label id="elh_log_test_payment_log_test_payment_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->log_test_payment_id->caption() ?><?= $Page->log_test_payment_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->log_test_payment_id->cellAttributes() ?>>
<span id="el_log_test_payment_log_test_payment_id">
<span<?= $Page->log_test_payment_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->log_test_payment_id->getDisplayValue($Page->log_test_payment_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="log_test_payment" data-field="x_log_test_payment_id" data-hidden="1" name="x_log_test_payment_id" id="x_log_test_payment_id" value="<?= HtmlEncode($Page->log_test_payment_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_log_test_payment_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_log_test_payment_member_id">
<input type="<?= $Page->member_id->getInputTextType() ?>" name="x_member_id" id="x_member_id" data-table="log_test_payment" data-field="x_member_id" value="<?= $Page->member_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"<?= $Page->member_id->editAttributes() ?> aria-describedby="x_member_id_help">
<?= $Page->member_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_log_test_payment_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_log_test_payment_asset_id">
<input type="<?= $Page->asset_id->getInputTextType() ?>" name="x_asset_id" id="x_asset_id" data-table="log_test_payment" data-field="x_asset_id" value="<?= $Page->asset_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"<?= $Page->asset_id->editAttributes() ?> aria-describedby="x_asset_id_help">
<?= $Page->asset_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_log_test_payment_type" for="x_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_log_test_payment_type">
<input type="<?= $Page->type->getInputTextType() ?>" name="x_type" id="x_type" data-table="log_test_payment" data-field="x_type" value="<?= $Page->type->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"<?= $Page->type->editAttributes() ?> aria-describedby="x_type_help">
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <div id="r_date_booking"<?= $Page->date_booking->rowAttributes() ?>>
        <label id="elh_log_test_payment_date_booking" for="x_date_booking" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_booking->caption() ?><?= $Page->date_booking->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_booking->cellAttributes() ?>>
<span id="el_log_test_payment_date_booking">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="x_date_booking" id="x_date_booking" data-table="log_test_payment" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?> aria-describedby="x_date_booking_help">
<?= $Page->date_booking->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage() ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_test_paymentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_test_paymentedit", "x_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <div id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <label id="elh_log_test_payment_date_payment" for="x_date_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_payment->caption() ?><?= $Page->date_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_log_test_payment_date_payment">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="x_date_payment" id="x_date_payment" data-table="log_test_payment" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?> aria-describedby="x_date_payment_help">
<?= $Page->date_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage() ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_test_paymentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_test_paymentedit", "x_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <div id="r_due_date"<?= $Page->due_date->rowAttributes() ?>>
        <label id="elh_log_test_payment_due_date" for="x_due_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date->caption() ?><?= $Page->due_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date->cellAttributes() ?>>
<span id="el_log_test_payment_due_date">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="x_due_date" id="x_due_date" data-table="log_test_payment" data-field="x_due_date" value="<?= $Page->due_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?> aria-describedby="x_due_date_help">
<?= $Page->due_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage() ?></div>
<?php if (!$Page->due_date->ReadOnly && !$Page->due_date->Disabled && !isset($Page->due_date->EditAttrs["readonly"]) && !isset($Page->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_test_paymentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_test_paymentedit", "x_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <div id="r_booking_price"<?= $Page->booking_price->rowAttributes() ?>>
        <label id="elh_log_test_payment_booking_price" for="x_booking_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->booking_price->caption() ?><?= $Page->booking_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->booking_price->cellAttributes() ?>>
<span id="el_log_test_payment_booking_price">
<input type="<?= $Page->booking_price->getInputTextType() ?>" name="x_booking_price" id="x_booking_price" data-table="log_test_payment" data-field="x_booking_price" value="<?= $Page->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->booking_price->getPlaceHolder()) ?>"<?= $Page->booking_price->editAttributes() ?> aria-describedby="x_booking_price_help">
<?= $Page->booking_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->booking_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <div id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <label id="elh_log_test_payment_pay_number" for="x_pay_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number->caption() ?><?= $Page->pay_number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_log_test_payment_pay_number">
<input type="<?= $Page->pay_number->getInputTextType() ?>" name="x_pay_number" id="x_pay_number" data-table="log_test_payment" data-field="x_pay_number" value="<?= $Page->pay_number->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->pay_number->getPlaceHolder()) ?>"<?= $Page->pay_number->editAttributes() ?> aria-describedby="x_pay_number_help">
<?= $Page->pay_number->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pay_number->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <div id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <label id="elh_log_test_payment_status_payment" for="x_status_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_payment->caption() ?><?= $Page->status_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_log_test_payment_status_payment">
<input type="<?= $Page->status_payment->getInputTextType() ?>" name="x_status_payment" id="x_status_payment" data-table="log_test_payment" data-field="x_status_payment" value="<?= $Page->status_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->status_payment->getPlaceHolder()) ?>"<?= $Page->status_payment->editAttributes() ?> aria-describedby="x_status_payment_help">
<?= $Page->status_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_payment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->transaction_datetime->Visible) { // transaction_datetime ?>
    <div id="r_transaction_datetime"<?= $Page->transaction_datetime->rowAttributes() ?>>
        <label id="elh_log_test_payment_transaction_datetime" for="x_transaction_datetime" class="<?= $Page->LeftColumnClass ?>"><?= $Page->transaction_datetime->caption() ?><?= $Page->transaction_datetime->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->transaction_datetime->cellAttributes() ?>>
<span id="el_log_test_payment_transaction_datetime">
<input type="<?= $Page->transaction_datetime->getInputTextType() ?>" name="x_transaction_datetime" id="x_transaction_datetime" data-table="log_test_payment" data-field="x_transaction_datetime" value="<?= $Page->transaction_datetime->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->transaction_datetime->getPlaceHolder()) ?>"<?= $Page->transaction_datetime->editAttributes() ?> aria-describedby="x_transaction_datetime_help">
<?= $Page->transaction_datetime->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->transaction_datetime->getErrorMessage() ?></div>
<?php if (!$Page->transaction_datetime->ReadOnly && !$Page->transaction_datetime->Disabled && !isset($Page->transaction_datetime->EditAttrs["readonly"]) && !isset($Page->transaction_datetime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_test_paymentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_test_paymentedit", "x_transaction_datetime", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_scheme->Visible) { // payment_scheme ?>
    <div id="r_payment_scheme"<?= $Page->payment_scheme->rowAttributes() ?>>
        <label id="elh_log_test_payment_payment_scheme" for="x_payment_scheme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment_scheme->caption() ?><?= $Page->payment_scheme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->payment_scheme->cellAttributes() ?>>
<span id="el_log_test_payment_payment_scheme">
<input type="<?= $Page->payment_scheme->getInputTextType() ?>" name="x_payment_scheme" id="x_payment_scheme" data-table="log_test_payment" data-field="x_payment_scheme" value="<?= $Page->payment_scheme->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->payment_scheme->getPlaceHolder()) ?>"<?= $Page->payment_scheme->editAttributes() ?> aria-describedby="x_payment_scheme_help">
<?= $Page->payment_scheme->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->payment_scheme->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->transaction_ref->Visible) { // transaction_ref ?>
    <div id="r_transaction_ref"<?= $Page->transaction_ref->rowAttributes() ?>>
        <label id="elh_log_test_payment_transaction_ref" for="x_transaction_ref" class="<?= $Page->LeftColumnClass ?>"><?= $Page->transaction_ref->caption() ?><?= $Page->transaction_ref->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->transaction_ref->cellAttributes() ?>>
<span id="el_log_test_payment_transaction_ref">
<input type="<?= $Page->transaction_ref->getInputTextType() ?>" name="x_transaction_ref" id="x_transaction_ref" data-table="log_test_payment" data-field="x_transaction_ref" value="<?= $Page->transaction_ref->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->transaction_ref->getPlaceHolder()) ?>"<?= $Page->transaction_ref->editAttributes() ?> aria-describedby="x_transaction_ref_help">
<?= $Page->transaction_ref->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->transaction_ref->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->channel_response_desc->Visible) { // channel_response_desc ?>
    <div id="r_channel_response_desc"<?= $Page->channel_response_desc->rowAttributes() ?>>
        <label id="elh_log_test_payment_channel_response_desc" for="x_channel_response_desc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->channel_response_desc->caption() ?><?= $Page->channel_response_desc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->channel_response_desc->cellAttributes() ?>>
<span id="el_log_test_payment_channel_response_desc">
<input type="<?= $Page->channel_response_desc->getInputTextType() ?>" name="x_channel_response_desc" id="x_channel_response_desc" data-table="log_test_payment" data-field="x_channel_response_desc" value="<?= $Page->channel_response_desc->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->channel_response_desc->getPlaceHolder()) ?>"<?= $Page->channel_response_desc->editAttributes() ?> aria-describedby="x_channel_response_desc_help">
<?= $Page->channel_response_desc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->channel_response_desc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->res_status->Visible) { // res_status ?>
    <div id="r_res_status"<?= $Page->res_status->rowAttributes() ?>>
        <label id="elh_log_test_payment_res_status" for="x_res_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->res_status->caption() ?><?= $Page->res_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->res_status->cellAttributes() ?>>
<span id="el_log_test_payment_res_status">
<input type="<?= $Page->res_status->getInputTextType() ?>" name="x_res_status" id="x_res_status" data-table="log_test_payment" data-field="x_res_status" value="<?= $Page->res_status->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->res_status->getPlaceHolder()) ?>"<?= $Page->res_status->editAttributes() ?> aria-describedby="x_res_status_help">
<?= $Page->res_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->res_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->res_referenceNo->Visible) { // res_referenceNo ?>
    <div id="r_res_referenceNo"<?= $Page->res_referenceNo->rowAttributes() ?>>
        <label id="elh_log_test_payment_res_referenceNo" for="x_res_referenceNo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->res_referenceNo->caption() ?><?= $Page->res_referenceNo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->res_referenceNo->cellAttributes() ?>>
<span id="el_log_test_payment_res_referenceNo">
<input type="<?= $Page->res_referenceNo->getInputTextType() ?>" name="x_res_referenceNo" id="x_res_referenceNo" data-table="log_test_payment" data-field="x_res_referenceNo" value="<?= $Page->res_referenceNo->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->res_referenceNo->getPlaceHolder()) ?>"<?= $Page->res_referenceNo->editAttributes() ?> aria-describedby="x_res_referenceNo_help">
<?= $Page->res_referenceNo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->res_referenceNo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->res_paidAgent->Visible) { // res_paidAgent ?>
    <div id="r_res_paidAgent"<?= $Page->res_paidAgent->rowAttributes() ?>>
        <label id="elh_log_test_payment_res_paidAgent" for="x_res_paidAgent" class="<?= $Page->LeftColumnClass ?>"><?= $Page->res_paidAgent->caption() ?><?= $Page->res_paidAgent->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->res_paidAgent->cellAttributes() ?>>
<span id="el_log_test_payment_res_paidAgent">
<input type="<?= $Page->res_paidAgent->getInputTextType() ?>" name="x_res_paidAgent" id="x_res_paidAgent" data-table="log_test_payment" data-field="x_res_paidAgent" value="<?= $Page->res_paidAgent->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->res_paidAgent->getPlaceHolder()) ?>"<?= $Page->res_paidAgent->editAttributes() ?> aria-describedby="x_res_paidAgent_help">
<?= $Page->res_paidAgent->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->res_paidAgent->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->res_paidChannel->Visible) { // res_paidChannel ?>
    <div id="r_res_paidChannel"<?= $Page->res_paidChannel->rowAttributes() ?>>
        <label id="elh_log_test_payment_res_paidChannel" for="x_res_paidChannel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->res_paidChannel->caption() ?><?= $Page->res_paidChannel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->res_paidChannel->cellAttributes() ?>>
<span id="el_log_test_payment_res_paidChannel">
<input type="<?= $Page->res_paidChannel->getInputTextType() ?>" name="x_res_paidChannel" id="x_res_paidChannel" data-table="log_test_payment" data-field="x_res_paidChannel" value="<?= $Page->res_paidChannel->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->res_paidChannel->getPlaceHolder()) ?>"<?= $Page->res_paidChannel->editAttributes() ?> aria-describedby="x_res_paidChannel_help">
<?= $Page->res_paidChannel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->res_paidChannel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->res_maskedPan->Visible) { // res_maskedPan ?>
    <div id="r_res_maskedPan"<?= $Page->res_maskedPan->rowAttributes() ?>>
        <label id="elh_log_test_payment_res_maskedPan" for="x_res_maskedPan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->res_maskedPan->caption() ?><?= $Page->res_maskedPan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->res_maskedPan->cellAttributes() ?>>
<span id="el_log_test_payment_res_maskedPan">
<input type="<?= $Page->res_maskedPan->getInputTextType() ?>" name="x_res_maskedPan" id="x_res_maskedPan" data-table="log_test_payment" data-field="x_res_maskedPan" value="<?= $Page->res_maskedPan->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->res_maskedPan->getPlaceHolder()) ?>"<?= $Page->res_maskedPan->editAttributes() ?> aria-describedby="x_res_maskedPan_help">
<?= $Page->res_maskedPan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->res_maskedPan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <div id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <label id="elh_log_test_payment_status_expire" for="x_status_expire" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire->caption() ?><?= $Page->status_expire->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_log_test_payment_status_expire">
<input type="<?= $Page->status_expire->getInputTextType() ?>" name="x_status_expire" id="x_status_expire" data-table="log_test_payment" data-field="x_status_expire" value="<?= $Page->status_expire->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->status_expire->getPlaceHolder()) ?>"<?= $Page->status_expire->editAttributes() ?> aria-describedby="x_status_expire_help">
<?= $Page->status_expire->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_expire->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
    <div id="r_status_expire_reason"<?= $Page->status_expire_reason->rowAttributes() ?>>
        <label id="elh_log_test_payment_status_expire_reason" for="x_status_expire_reason" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire_reason->caption() ?><?= $Page->status_expire_reason->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_log_test_payment_status_expire_reason">
<input type="<?= $Page->status_expire_reason->getInputTextType() ?>" name="x_status_expire_reason" id="x_status_expire_reason" data-table="log_test_payment" data-field="x_status_expire_reason" value="<?= $Page->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status_expire_reason->getPlaceHolder()) ?>"<?= $Page->status_expire_reason->editAttributes() ?> aria-describedby="x_status_expire_reason_help">
<?= $Page->status_expire_reason->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_expire_reason->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_log_test_payment_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_log_test_payment_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="log_test_payment" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_test_paymentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_test_paymentedit", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_log_test_payment_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_log_test_payment_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="log_test_payment" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_log_test_payment_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_log_test_payment_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="log_test_payment" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <div id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <label id="elh_log_test_payment_udate" for="x_udate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->udate->caption() ?><?= $Page->udate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->udate->cellAttributes() ?>>
<span id="el_log_test_payment_udate">
<input type="<?= $Page->udate->getInputTextType() ?>" name="x_udate" id="x_udate" data-table="log_test_payment" data-field="x_udate" value="<?= $Page->udate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->udate->getPlaceHolder()) ?>"<?= $Page->udate->editAttributes() ?> aria-describedby="x_udate_help">
<?= $Page->udate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->udate->getErrorMessage() ?></div>
<?php if (!$Page->udate->ReadOnly && !$Page->udate->Disabled && !isset($Page->udate->EditAttrs["readonly"]) && !isset($Page->udate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_test_paymentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_test_paymentedit", "x_udate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <div id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <label id="elh_log_test_payment_uuser" for="x_uuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuser->caption() ?><?= $Page->uuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uuser->cellAttributes() ?>>
<span id="el_log_test_payment_uuser">
<input type="<?= $Page->uuser->getInputTextType() ?>" name="x_uuser" id="x_uuser" data-table="log_test_payment" data-field="x_uuser" value="<?= $Page->uuser->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->uuser->getPlaceHolder()) ?>"<?= $Page->uuser->editAttributes() ?> aria-describedby="x_uuser_help">
<?= $Page->uuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <div id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <label id="elh_log_test_payment_uip" for="x_uip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uip->caption() ?><?= $Page->uip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uip->cellAttributes() ?>>
<span id="el_log_test_payment_uip">
<input type="<?= $Page->uip->getInputTextType() ?>" name="x_uip" id="x_uip" data-table="log_test_payment" data-field="x_uip" value="<?= $Page->uip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->uip->getPlaceHolder()) ?>"<?= $Page->uip->editAttributes() ?> aria-describedby="x_uip_help">
<?= $Page->uip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uip->getErrorMessage() ?></div>
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
    ew.addEventHandlers("log_test_payment");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
