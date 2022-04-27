<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PaymentInverterBookingEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { payment_inverter_booking: currentTable } });
var currentForm, currentPageID;
var fpayment_inverter_bookingedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpayment_inverter_bookingedit = new ew.Form("fpayment_inverter_bookingedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpayment_inverter_bookingedit;

    // Add fields
    var fields = currentTable.fields;
    fpayment_inverter_bookingedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["payment", [fields.payment.visible && fields.payment.required ? ew.Validators.required(fields.payment.caption) : null], fields.payment.isInvalid],
        ["payment_number", [fields.payment_number.visible && fields.payment_number.required ? ew.Validators.required(fields.payment_number.caption) : null], fields.payment_number.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fpayment_inverter_bookingedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpayment_inverter_bookingedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpayment_inverter_bookingedit.lists.status_expire = <?= $Page->status_expire->toClientList($Page) ?>;
    loadjs.done("fpayment_inverter_bookingedit");
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
<form name="fpayment_inverter_bookingedit" id="fpayment_inverter_bookingedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="payment_inverter_booking">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "invertor_booking") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invertor_booking">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "invertor_all_booking") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invertor_all_booking">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_payment_inverter_booking_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_payment_inverter_booking_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_payment_inverter_booking_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_payment_inverter_booking_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment->Visible) { // payment ?>
    <div id="r_payment"<?= $Page->payment->rowAttributes() ?>>
        <label id="elh_payment_inverter_booking_payment" for="x_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment->caption() ?><?= $Page->payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->payment->cellAttributes() ?>>
<span id="el_payment_inverter_booking_payment">
<span<?= $Page->payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->payment->getDisplayValue($Page->payment->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment" data-hidden="1" name="x_payment" id="x_payment" value="<?= HtmlEncode($Page->payment->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_number->Visible) { // payment_number ?>
    <div id="r_payment_number"<?= $Page->payment_number->rowAttributes() ?>>
        <label id="elh_payment_inverter_booking_payment_number" for="x_payment_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment_number->caption() ?><?= $Page->payment_number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->payment_number->cellAttributes() ?>>
<span id="el_payment_inverter_booking_payment_number">
<span<?= $Page->payment_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->payment_number->getDisplayValue($Page->payment_number->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_number" data-hidden="1" name="x_payment_number" id="x_payment_number" value="<?= HtmlEncode($Page->payment_number->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_payment_inverter_booking_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_payment_inverter_booking_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="payment_inverter_booking" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <div id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <label id="elh_payment_inverter_booking_status_expire" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire->caption() ?><?= $Page->status_expire->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_payment_inverter_booking_status_expire">
<template id="tp_x_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="payment_inverter_booking" data-field="x_status_expire" name="x_status_expire" id="x_status_expire"<?= $Page->status_expire->editAttributes() ?>>
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
    data-table="payment_inverter_booking"
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
        <label id="elh_payment_inverter_booking_status_expire_reason" for="x_status_expire_reason" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire_reason->caption() ?><?= $Page->status_expire_reason->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_payment_inverter_booking_status_expire_reason">
<input type="<?= $Page->status_expire_reason->getInputTextType() ?>" name="x_status_expire_reason" id="x_status_expire_reason" data-table="payment_inverter_booking" data-field="x_status_expire_reason" value="<?= $Page->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status_expire_reason->getPlaceHolder()) ?>"<?= $Page->status_expire_reason->editAttributes() ?> aria-describedby="x_status_expire_reason_help">
<?= $Page->status_expire_reason->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_expire_reason->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="payment_inverter_booking" data-field="x_payment_inverter_booking_id" data-hidden="1" name="x_payment_inverter_booking_id" id="x_payment_inverter_booking_id" value="<?= HtmlEncode($Page->payment_inverter_booking_id->CurrentValue) ?>">
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
    ew.addEventHandlers("payment_inverter_booking");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
