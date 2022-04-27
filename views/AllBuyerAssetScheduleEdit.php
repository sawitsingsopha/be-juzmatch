<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllBuyerAssetScheduleEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_buyer_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fall_buyer_asset_scheduleedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_buyer_asset_scheduleedit = new ew.Form("fall_buyer_asset_scheduleedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fall_buyer_asset_scheduleedit;

    // Add fields
    var fields = currentTable.fields;
    fall_buyer_asset_scheduleedit.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["num_installment", [fields.num_installment.visible && fields.num_installment.required ? ew.Validators.required(fields.num_installment.caption) : null, ew.Validators.integer], fields.num_installment.isInvalid],
        ["installment_per_price", [fields.installment_per_price.visible && fields.installment_per_price.required ? ew.Validators.required(fields.installment_per_price.caption) : null, ew.Validators.float], fields.installment_per_price.isInvalid],
        ["interest", [fields.interest.visible && fields.interest.required ? ew.Validators.required(fields.interest.caption) : null, ew.Validators.float], fields.interest.isInvalid],
        ["principal", [fields.principal.visible && fields.principal.required ? ew.Validators.required(fields.principal.caption) : null, ew.Validators.float], fields.principal.isInvalid],
        ["remaining_principal", [fields.remaining_principal.visible && fields.remaining_principal.required ? ew.Validators.required(fields.remaining_principal.caption) : null, ew.Validators.float], fields.remaining_principal.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null], fields.date_payment.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fall_buyer_asset_scheduleedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fall_buyer_asset_scheduleedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fall_buyer_asset_scheduleedit");
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
<form name="fall_buyer_asset_scheduleedit" id="fall_buyer_asset_scheduleedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_buyer_asset_schedule">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "all_buyer_config_asset_schedule") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="all_buyer_config_asset_schedule">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "number_deals_available") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="number_deals_available">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "number_of_accrued") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="number_of_accrued">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "number_of_unpaid_units") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="number_of_unpaid_units">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "outstanding_amount") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="outstanding_amount">
<input type="hidden" name="fk_buyer_config_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_config_asset_schedule_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
    <div id="r_num_installment"<?= $Page->num_installment->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_num_installment" for="x_num_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->num_installment->caption() ?><?= $Page->num_installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->num_installment->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_num_installment">
<input type="<?= $Page->num_installment->getInputTextType() ?>" name="x_num_installment" id="x_num_installment" data-table="all_buyer_asset_schedule" data-field="x_num_installment" value="<?= $Page->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->num_installment->getPlaceHolder()) ?>"<?= $Page->num_installment->editAttributes() ?> aria-describedby="x_num_installment_help">
<?= $Page->num_installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->num_installment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
    <div id="r_installment_per_price"<?= $Page->installment_per_price->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_installment_per_price" for="x_installment_per_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_per_price->caption() ?><?= $Page->installment_per_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_per_price->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_installment_per_price">
<input type="<?= $Page->installment_per_price->getInputTextType() ?>" name="x_installment_per_price" id="x_installment_per_price" data-table="all_buyer_asset_schedule" data-field="x_installment_per_price" value="<?= $Page->installment_per_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_per_price->getPlaceHolder()) ?>"<?= $Page->installment_per_price->editAttributes() ?> aria-describedby="x_installment_per_price_help">
<?= $Page->installment_per_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_per_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->interest->Visible) { // interest ?>
    <div id="r_interest"<?= $Page->interest->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_interest" for="x_interest" class="<?= $Page->LeftColumnClass ?>"><?= $Page->interest->caption() ?><?= $Page->interest->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->interest->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_interest">
<input type="<?= $Page->interest->getInputTextType() ?>" name="x_interest" id="x_interest" data-table="all_buyer_asset_schedule" data-field="x_interest" value="<?= $Page->interest->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->interest->getPlaceHolder()) ?>"<?= $Page->interest->editAttributes() ?> aria-describedby="x_interest_help">
<?= $Page->interest->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->interest->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->principal->Visible) { // principal ?>
    <div id="r_principal"<?= $Page->principal->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_principal" for="x_principal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->principal->caption() ?><?= $Page->principal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->principal->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_principal">
<input type="<?= $Page->principal->getInputTextType() ?>" name="x_principal" id="x_principal" data-table="all_buyer_asset_schedule" data-field="x_principal" value="<?= $Page->principal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->principal->getPlaceHolder()) ?>"<?= $Page->principal->editAttributes() ?> aria-describedby="x_principal_help">
<?= $Page->principal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->principal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remaining_principal->Visible) { // remaining_principal ?>
    <div id="r_remaining_principal"<?= $Page->remaining_principal->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_remaining_principal" for="x_remaining_principal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remaining_principal->caption() ?><?= $Page->remaining_principal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remaining_principal->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_remaining_principal">
<input type="<?= $Page->remaining_principal->getInputTextType() ?>" name="x_remaining_principal" id="x_remaining_principal" data-table="all_buyer_asset_schedule" data-field="x_remaining_principal" value="<?= $Page->remaining_principal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->remaining_principal->getPlaceHolder()) ?>"<?= $Page->remaining_principal->editAttributes() ?> aria-describedby="x_remaining_principal_help">
<?= $Page->remaining_principal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remaining_principal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <div id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_pay_number" for="x_pay_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number->caption() ?><?= $Page->pay_number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_pay_number">
<span<?= $Page->pay_number->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pay_number->getDisplayValue($Page->pay_number->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_pay_number" data-hidden="1" name="x_pay_number" id="x_pay_number" value="<?= HtmlEncode($Page->pay_number->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
    <div id="r_expired_date"<?= $Page->expired_date->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_expired_date" for="x_expired_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expired_date->caption() ?><?= $Page->expired_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expired_date->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_expired_date">
<input type="<?= $Page->expired_date->getInputTextType() ?>" name="x_expired_date" id="x_expired_date" data-table="all_buyer_asset_schedule" data-field="x_expired_date" value="<?= $Page->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->expired_date->getPlaceHolder()) ?>"<?= $Page->expired_date->editAttributes() ?> aria-describedby="x_expired_date_help">
<?= $Page->expired_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expired_date->getErrorMessage() ?></div>
<?php if (!$Page->expired_date->ReadOnly && !$Page->expired_date->Disabled && !isset($Page->expired_date->EditAttrs["readonly"]) && !isset($Page->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_buyer_asset_scheduleedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_buyer_asset_scheduleedit", "x_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <div id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_date_payment" for="x_date_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_payment->caption() ?><?= $Page->date_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_date_payment">
<span<?= $Page->date_payment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date_payment->getDisplayValue($Page->date_payment->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_date_payment" data-hidden="1" name="x_date_payment" id="x_date_payment" value="<?= HtmlEncode($Page->date_payment->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <div id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_status_payment" for="x_status_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_payment->caption() ?><?= $Page->status_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_status_payment">
<span<?= $Page->status_payment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status_payment->getDisplayValue($Page->status_payment->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_status_payment" data-hidden="1" name="x_status_payment" id="x_status_payment" value="<?= HtmlEncode($Page->status_payment->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="all_buyer_asset_schedule" data-field="x_buyer_asset_schedule_id" data-hidden="1" name="x_buyer_asset_schedule_id" id="x_buyer_asset_schedule_id" value="<?= HtmlEncode($Page->buyer_asset_schedule_id->CurrentValue) ?>">
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
    ew.addEventHandlers("all_buyer_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
