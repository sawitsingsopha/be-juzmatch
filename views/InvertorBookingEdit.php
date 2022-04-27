<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvertorBookingEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { invertor_booking: currentTable } });
var currentForm, currentPageID;
var finvertor_bookingedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvertor_bookingedit = new ew.Form("finvertor_bookingedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = finvertor_bookingedit;

    // Add fields
    var fields = currentTable.fields;
    finvertor_bookingedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["date_booking", [fields.date_booking.visible && fields.date_booking.required ? ew.Validators.required(fields.date_booking.caption) : null, ew.Validators.datetime(fields.date_booking.clientFormatPattern)], fields.date_booking.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid],
        ["payment_status", [fields.payment_status.visible && fields.payment_status.required ? ew.Validators.required(fields.payment_status.caption) : null], fields.payment_status.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["is_email", [fields.is_email.visible && fields.is_email.required ? ew.Validators.required(fields.is_email.caption) : null, ew.Validators.integer], fields.is_email.isInvalid],
        ["receipt_status", [fields.receipt_status.visible && fields.receipt_status.required ? ew.Validators.required(fields.receipt_status.caption) : null, ew.Validators.integer], fields.receipt_status.isInvalid]
    ]);

    // Form_CustomValidate
    finvertor_bookingedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvertor_bookingedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    finvertor_bookingedit.lists.status_expire = <?= $Page->status_expire->toClientList($Page) ?>;
    finvertor_bookingedit.lists.payment_status = <?= $Page->payment_status->toClientList($Page) ?>;
    loadjs.done("finvertor_bookingedit");
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
<form name="finvertor_bookingedit" id="finvertor_bookingedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invertor_booking">
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
        <label id="elh_invertor_booking_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_invertor_booking_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_invertor_booking_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_invertor_booking_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="invertor_booking" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <div id="r_date_booking"<?= $Page->date_booking->rowAttributes() ?>>
        <label id="elh_invertor_booking_date_booking" for="x_date_booking" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_booking->caption() ?><?= $Page->date_booking->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_booking->cellAttributes() ?>>
<span id="el_invertor_booking_date_booking">
<input type="<?= $Page->date_booking->getInputTextType() ?>" name="x_date_booking" id="x_date_booking" data-table="invertor_booking" data-field="x_date_booking" value="<?= $Page->date_booking->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_booking->getPlaceHolder()) ?>"<?= $Page->date_booking->editAttributes() ?> aria-describedby="x_date_booking_help">
<?= $Page->date_booking->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_booking->getErrorMessage() ?></div>
<?php if (!$Page->date_booking->ReadOnly && !$Page->date_booking->Disabled && !isset($Page->date_booking->EditAttrs["readonly"]) && !isset($Page->date_booking->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvertor_bookingedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(111) ?>",
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
    ew.createDateTimePicker("finvertor_bookingedit", "x_date_booking", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <div id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <label id="elh_invertor_booking_status_expire" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire->caption() ?><?= $Page->status_expire->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_invertor_booking_status_expire">
<template id="tp_x_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_status_expire" name="x_status_expire" id="x_status_expire"<?= $Page->status_expire->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status_expire" class="ew-item-list"></div>
<selection-list hidden
    id="x_status_expire"
    name="x_status_expire"
    value="<?= HtmlEncode($Page->status_expire->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_expire"
    data-bs-target="dsl_x_status_expire"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_expire->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_status_expire"
    data-value-separator="<?= $Page->status_expire->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_expire->editAttributes() ?>></selection-list>
<?= $Page->status_expire->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_expire->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
    <div id="r_status_expire_reason"<?= $Page->status_expire_reason->rowAttributes() ?>>
        <label id="elh_invertor_booking_status_expire_reason" for="x_status_expire_reason" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire_reason->caption() ?><?= $Page->status_expire_reason->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_invertor_booking_status_expire_reason">
<input type="<?= $Page->status_expire_reason->getInputTextType() ?>" name="x_status_expire_reason" id="x_status_expire_reason" data-table="invertor_booking" data-field="x_status_expire_reason" value="<?= $Page->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status_expire_reason->getPlaceHolder()) ?>"<?= $Page->status_expire_reason->editAttributes() ?> aria-describedby="x_status_expire_reason_help">
<?= $Page->status_expire_reason->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_expire_reason->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_status->Visible) { // payment_status ?>
    <div id="r_payment_status"<?= $Page->payment_status->rowAttributes() ?>>
        <label id="elh_invertor_booking_payment_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment_status->caption() ?><?= $Page->payment_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->payment_status->cellAttributes() ?>>
<span id="el_invertor_booking_payment_status">
<template id="tp_x_payment_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="invertor_booking" data-field="x_payment_status" name="x_payment_status" id="x_payment_status"<?= $Page->payment_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_payment_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_payment_status"
    name="x_payment_status"
    value="<?= HtmlEncode($Page->payment_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_payment_status"
    data-bs-target="dsl_x_payment_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->payment_status->isInvalidClass() ?>"
    data-table="invertor_booking"
    data-field="x_payment_status"
    data-value-separator="<?= $Page->payment_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->payment_status->editAttributes() ?>></selection-list>
<?= $Page->payment_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->payment_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
    <div id="r_is_email"<?= $Page->is_email->rowAttributes() ?>>
        <label id="elh_invertor_booking_is_email" for="x_is_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_email->caption() ?><?= $Page->is_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->is_email->cellAttributes() ?>>
<span id="el_invertor_booking_is_email">
<input type="<?= $Page->is_email->getInputTextType() ?>" name="x_is_email" id="x_is_email" data-table="invertor_booking" data-field="x_is_email" value="<?= $Page->is_email->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->is_email->getPlaceHolder()) ?>"<?= $Page->is_email->editAttributes() ?> aria-describedby="x_is_email_help">
<?= $Page->is_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
    <div id="r_receipt_status"<?= $Page->receipt_status->rowAttributes() ?>>
        <label id="elh_invertor_booking_receipt_status" for="x_receipt_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt_status->caption() ?><?= $Page->receipt_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receipt_status->cellAttributes() ?>>
<span id="el_invertor_booking_receipt_status">
<input type="<?= $Page->receipt_status->getInputTextType() ?>" name="x_receipt_status" id="x_receipt_status" data-table="invertor_booking" data-field="x_receipt_status" value="<?= $Page->receipt_status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->receipt_status->getPlaceHolder()) ?>"<?= $Page->receipt_status->editAttributes() ?> aria-describedby="x_receipt_status_help">
<?= $Page->receipt_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="invertor_booking" data-field="x_invertor_booking_id" data-hidden="1" name="x_invertor_booking_id" id="x_invertor_booking_id" value="<?= HtmlEncode($Page->invertor_booking_id->CurrentValue) ?>">
<?php
    if (in_array("payment_inverter_booking", explode(",", $Page->getCurrentDetailTable())) && $payment_inverter_booking->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("payment_inverter_booking", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PaymentInverterBookingGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("invertor_booking");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
