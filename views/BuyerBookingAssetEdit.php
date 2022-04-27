<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerBookingAssetEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_booking_asset: currentTable } });
var currentForm, currentPageID;
var fbuyer_booking_assetedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_booking_assetedit = new ew.Form("fbuyer_booking_assetedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbuyer_booking_assetedit;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_booking_assetedit.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["booking_price", [fields.booking_price.visible && fields.booking_price.required ? ew.Validators.required(fields.booking_price.caption) : null, ew.Validators.float], fields.booking_price.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["date_booking", [fields.date_booking.visible && fields.date_booking.required ? ew.Validators.required(fields.date_booking.caption) : null], fields.date_booking.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null], fields.date_payment.isInvalid],
        ["due_date", [fields.due_date.visible && fields.due_date.required ? ew.Validators.required(fields.due_date.caption) : null, ew.Validators.datetime(fields.due_date.clientFormatPattern)], fields.due_date.isInvalid],
        ["status_expire", [fields.status_expire.visible && fields.status_expire.required ? ew.Validators.required(fields.status_expire.caption) : null], fields.status_expire.isInvalid],
        ["status_expire_reason", [fields.status_expire_reason.visible && fields.status_expire_reason.required ? ew.Validators.required(fields.status_expire_reason.caption) : null], fields.status_expire_reason.isInvalid]
    ]);

    // Form_CustomValidate
    fbuyer_booking_assetedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_booking_assetedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_booking_assetedit.lists.status_expire = <?= $Page->status_expire->toClientList($Page) ?>;
    loadjs.done("fbuyer_booking_assetedit");
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
<form name="fbuyer_booking_assetedit" id="fbuyer_booking_assetedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_booking_asset">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_booking_asset_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_booking_asset_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <div id="r_booking_price"<?= $Page->booking_price->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_booking_price" for="x_booking_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->booking_price->caption() ?><?= $Page->booking_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->booking_price->cellAttributes() ?>>
<span id="el_buyer_booking_asset_booking_price">
<input type="<?= $Page->booking_price->getInputTextType() ?>" name="x_booking_price" id="x_booking_price" data-table="buyer_booking_asset" data-field="x_booking_price" value="<?= $Page->booking_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->booking_price->getPlaceHolder()) ?>"<?= $Page->booking_price->editAttributes() ?> aria-describedby="x_booking_price_help">
<?= $Page->booking_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->booking_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <div id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_pay_number" for="x_pay_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number->caption() ?><?= $Page->pay_number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_buyer_booking_asset_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pay_number->getDisplayValue($Page->pay_number->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_pay_number" data-hidden="1" name="x_pay_number" id="x_pay_number" value="<?= HtmlEncode($Page->pay_number->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <div id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_status_payment" for="x_status_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_payment->caption() ?><?= $Page->status_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_buyer_booking_asset_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status_payment->getDisplayValue($Page->status_payment->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_status_payment" data-hidden="1" name="x_status_payment" id="x_status_payment" value="<?= HtmlEncode($Page->status_payment->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <div id="r_date_booking"<?= $Page->date_booking->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_date_booking" for="x_date_booking" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_booking->caption() ?><?= $Page->date_booking->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_booking->cellAttributes() ?>>
<span id="el_buyer_booking_asset_date_booking">
<span<?= $Page->date_booking->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date_booking->getDisplayValue($Page->date_booking->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_booking" data-hidden="1" name="x_date_booking" id="x_date_booking" value="<?= HtmlEncode($Page->date_booking->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <div id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_date_payment" for="x_date_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_payment->caption() ?><?= $Page->date_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_buyer_booking_asset_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date_payment->getDisplayValue($Page->date_payment->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_booking_asset" data-field="x_date_payment" data-hidden="1" name="x_date_payment" id="x_date_payment" value="<?= HtmlEncode($Page->date_payment->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <div id="r_due_date"<?= $Page->due_date->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_due_date" for="x_due_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date->caption() ?><?= $Page->due_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date->cellAttributes() ?>>
<span id="el_buyer_booking_asset_due_date">
<input type="<?= $Page->due_date->getInputTextType() ?>" name="x_due_date" id="x_due_date" data-table="buyer_booking_asset" data-field="x_due_date" value="<?= $Page->due_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date->getPlaceHolder()) ?>"<?= $Page->due_date->editAttributes() ?> aria-describedby="x_due_date_help">
<?= $Page->due_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date->getErrorMessage() ?></div>
<?php if (!$Page->due_date->ReadOnly && !$Page->due_date->Disabled && !isset($Page->due_date->EditAttrs["readonly"]) && !isset($Page->due_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_booking_assetedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_booking_assetedit", "x_due_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <div id="r_status_expire"<?= $Page->status_expire->rowAttributes() ?>>
        <label id="elh_buyer_booking_asset_status_expire" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire->caption() ?><?= $Page->status_expire->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire->cellAttributes() ?>>
<span id="el_buyer_booking_asset_status_expire">
<template id="tp_x_status_expire">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="buyer_booking_asset" data-field="x_status_expire" name="x_status_expire" id="x_status_expire"<?= $Page->status_expire->editAttributes() ?>>
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
    data-table="buyer_booking_asset"
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
        <label id="elh_buyer_booking_asset_status_expire_reason" for="x_status_expire_reason" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_expire_reason->caption() ?><?= $Page->status_expire_reason->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_expire_reason->cellAttributes() ?>>
<span id="el_buyer_booking_asset_status_expire_reason">
<input type="<?= $Page->status_expire_reason->getInputTextType() ?>" name="x_status_expire_reason" id="x_status_expire_reason" data-table="buyer_booking_asset" data-field="x_status_expire_reason" value="<?= $Page->status_expire_reason->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status_expire_reason->getPlaceHolder()) ?>"<?= $Page->status_expire_reason->editAttributes() ?> aria-describedby="x_status_expire_reason_help">
<?= $Page->status_expire_reason->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_expire_reason->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="buyer_booking_asset" data-field="x_buyer_booking_asset_id" data-hidden="1" name="x_buyer_booking_asset_id" id="x_buyer_booking_asset_id" value="<?= HtmlEncode($Page->buyer_booking_asset_id->CurrentValue) ?>">
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
    ew.addEventHandlers("buyer_booking_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
