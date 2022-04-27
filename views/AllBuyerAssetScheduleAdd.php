<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllBuyerAssetScheduleAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_buyer_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fall_buyer_asset_scheduleadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_buyer_asset_scheduleadd = new ew.Form("fall_buyer_asset_scheduleadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fall_buyer_asset_scheduleadd;

    // Add fields
    var fields = currentTable.fields;
    fall_buyer_asset_scheduleadd.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["num_installment", [fields.num_installment.visible && fields.num_installment.required ? ew.Validators.required(fields.num_installment.caption) : null, ew.Validators.integer], fields.num_installment.isInvalid],
        ["installment_per_price", [fields.installment_per_price.visible && fields.installment_per_price.required ? ew.Validators.required(fields.installment_per_price.caption) : null, ew.Validators.float], fields.installment_per_price.isInvalid],
        ["interest", [fields.interest.visible && fields.interest.required ? ew.Validators.required(fields.interest.caption) : null, ew.Validators.float], fields.interest.isInvalid],
        ["principal", [fields.principal.visible && fields.principal.required ? ew.Validators.required(fields.principal.caption) : null, ew.Validators.float], fields.principal.isInvalid],
        ["remaining_principal", [fields.remaining_principal.visible && fields.remaining_principal.required ? ew.Validators.required(fields.remaining_principal.caption) : null, ew.Validators.float], fields.remaining_principal.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fall_buyer_asset_scheduleadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fall_buyer_asset_scheduleadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fall_buyer_asset_scheduleadd.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fall_buyer_asset_scheduleadd.lists.member_id = <?= $Page->member_id->toClientList($Page) ?>;
    fall_buyer_asset_scheduleadd.lists.status_payment = <?= $Page->status_payment->toClientList($Page) ?>;
    loadjs.done("fall_buyer_asset_scheduleadd");
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
<form name="fall_buyer_asset_scheduleadd" id="fall_buyer_asset_scheduleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_buyer_asset_schedule">
<input type="hidden" name="action" id="action" value="insert">
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
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fall_buyer_asset_scheduleadd_x_asset_id"
        data-table="all_buyer_asset_schedule"
        data-field="x_asset_id"
        data-value-separator="<?= $Page->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"
        <?= $Page->asset_id->editAttributes() ?>>
        <?= $Page->asset_id->selectOptionListHtml("x_asset_id") ?>
    </select>
    <?= $Page->asset_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage() ?></div>
<?= $Page->asset_id->Lookup->getParamTag($Page, "p_x_asset_id") ?>
<script>
loadjs.ready("fall_buyer_asset_scheduleadd", function() {
    var options = { name: "x_asset_id", selectId: "fall_buyer_asset_scheduleadd_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_asset_scheduleadd.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fall_buyer_asset_scheduleadd" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fall_buyer_asset_scheduleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_asset_schedule.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_member_id">
    <select
        id="x_member_id"
        name="x_member_id"
        class="form-select ew-select<?= $Page->member_id->isInvalidClass() ?>"
        data-select2-id="fall_buyer_asset_scheduleadd_x_member_id"
        data-table="all_buyer_asset_schedule"
        data-field="x_member_id"
        data-value-separator="<?= $Page->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"
        <?= $Page->member_id->editAttributes() ?>>
        <?= $Page->member_id->selectOptionListHtml("x_member_id") ?>
    </select>
    <?= $Page->member_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
<?= $Page->member_id->Lookup->getParamTag($Page, "p_x_member_id") ?>
<script>
loadjs.ready("fall_buyer_asset_scheduleadd", function() {
    var options = { name: "x_member_id", selectId: "fall_buyer_asset_scheduleadd_x_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_asset_scheduleadd.lists.member_id.lookupOptions.length) {
        options.data = { id: "x_member_id", form: "fall_buyer_asset_scheduleadd" };
    } else {
        options.ajax = { id: "x_member_id", form: "fall_buyer_asset_scheduleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_asset_schedule.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
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
<input type="<?= $Page->pay_number->getInputTextType() ?>" name="x_pay_number" id="x_pay_number" data-table="all_buyer_asset_schedule" data-field="x_pay_number" value="<?= $Page->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pay_number->getPlaceHolder()) ?>"<?= $Page->pay_number->editAttributes() ?> aria-describedby="x_pay_number_help">
<?= $Page->pay_number->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pay_number->getErrorMessage() ?></div>
</span>
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
loadjs.ready(["fall_buyer_asset_scheduleadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_buyer_asset_scheduleadd", "x_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
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
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="x_date_payment" id="x_date_payment" data-table="all_buyer_asset_schedule" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?> aria-describedby="x_date_payment_help">
<?= $Page->date_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage() ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_buyer_asset_scheduleadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_buyer_asset_scheduleadd", "x_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <div id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <label id="elh_all_buyer_asset_schedule_status_payment" for="x_status_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_payment->caption() ?><?= $Page->status_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_all_buyer_asset_schedule_status_payment">
    <select
        id="x_status_payment"
        name="x_status_payment"
        class="form-select ew-select<?= $Page->status_payment->isInvalidClass() ?>"
        data-select2-id="fall_buyer_asset_scheduleadd_x_status_payment"
        data-table="all_buyer_asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Page->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_payment->getPlaceHolder()) ?>"
        <?= $Page->status_payment->editAttributes() ?>>
        <?= $Page->status_payment->selectOptionListHtml("x_status_payment") ?>
    </select>
    <?= $Page->status_payment->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fall_buyer_asset_scheduleadd", function() {
    var options = { name: "x_status_payment", selectId: "fall_buyer_asset_scheduleadd_x_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_asset_scheduleadd.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x_status_payment", form: "fall_buyer_asset_scheduleadd" };
    } else {
        options.ajax = { id: "x_status_payment", form: "fall_buyer_asset_scheduleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->buyer_config_asset_schedule_id->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_buyer_config_asset_schedule_id" id="x_buyer_config_asset_schedule_id" value="<?= HtmlEncode(strval($Page->buyer_config_asset_schedule_id->getSessionValue())) ?>">
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
    ew.addEventHandlers("all_buyer_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
