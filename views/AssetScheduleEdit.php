<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetScheduleEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_schedule: currentTable } });
var currentForm, currentPageID;
var fasset_scheduleedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_scheduleedit = new ew.Form("fasset_scheduleedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fasset_scheduleedit;

    // Add fields
    var fields = currentTable.fields;
    fasset_scheduleedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["num_installment", [fields.num_installment.visible && fields.num_installment.required ? ew.Validators.required(fields.num_installment.caption) : null, ew.Validators.integer], fields.num_installment.isInvalid],
        ["receive_per_installment_invertor", [fields.receive_per_installment_invertor.visible && fields.receive_per_installment_invertor.required ? ew.Validators.required(fields.receive_per_installment_invertor.caption) : null, ew.Validators.float], fields.receive_per_installment_invertor.isInvalid],
        ["pay_number", [fields.pay_number.visible && fields.pay_number.required ? ew.Validators.required(fields.pay_number.caption) : null], fields.pay_number.isInvalid],
        ["expired_date", [fields.expired_date.visible && fields.expired_date.required ? ew.Validators.required(fields.expired_date.caption) : null, ew.Validators.datetime(fields.expired_date.clientFormatPattern)], fields.expired_date.isInvalid],
        ["date_payment", [fields.date_payment.visible && fields.date_payment.required ? ew.Validators.required(fields.date_payment.caption) : null, ew.Validators.datetime(fields.date_payment.clientFormatPattern)], fields.date_payment.isInvalid],
        ["status_payment", [fields.status_payment.visible && fields.status_payment.required ? ew.Validators.required(fields.status_payment.caption) : null], fields.status_payment.isInvalid],
        ["installment_all", [fields.installment_all.visible && fields.installment_all.required ? ew.Validators.required(fields.installment_all.caption) : null, ew.Validators.integer], fields.installment_all.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fasset_scheduleedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_scheduleedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_scheduleedit.lists.status_payment = <?= $Page->status_payment->toClientList($Page) ?>;
    loadjs.done("fasset_scheduleedit");
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
<form name="fasset_scheduleedit" id="fasset_scheduleedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_schedule">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "inverter_asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="inverter_asset">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_asset_schedule_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_asset_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_asset_schedule_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="asset_schedule" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->num_installment->Visible) { // num_installment ?>
    <div id="r_num_installment"<?= $Page->num_installment->rowAttributes() ?>>
        <label id="elh_asset_schedule_num_installment" for="x_num_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->num_installment->caption() ?><?= $Page->num_installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->num_installment->cellAttributes() ?>>
<span id="el_asset_schedule_num_installment">
<input type="<?= $Page->num_installment->getInputTextType() ?>" name="x_num_installment" id="x_num_installment" data-table="asset_schedule" data-field="x_num_installment" value="<?= $Page->num_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->num_installment->getPlaceHolder()) ?>"<?= $Page->num_installment->editAttributes() ?> aria-describedby="x_num_installment_help">
<?= $Page->num_installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->num_installment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receive_per_installment_invertor->Visible) { // receive_per_installment_invertor ?>
    <div id="r_receive_per_installment_invertor"<?= $Page->receive_per_installment_invertor->rowAttributes() ?>>
        <label id="elh_asset_schedule_receive_per_installment_invertor" for="x_receive_per_installment_invertor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receive_per_installment_invertor->caption() ?><?= $Page->receive_per_installment_invertor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receive_per_installment_invertor->cellAttributes() ?>>
<span id="el_asset_schedule_receive_per_installment_invertor">
<input type="<?= $Page->receive_per_installment_invertor->getInputTextType() ?>" name="x_receive_per_installment_invertor" id="x_receive_per_installment_invertor" data-table="asset_schedule" data-field="x_receive_per_installment_invertor" value="<?= $Page->receive_per_installment_invertor->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->receive_per_installment_invertor->getPlaceHolder()) ?>"<?= $Page->receive_per_installment_invertor->editAttributes() ?> aria-describedby="x_receive_per_installment_invertor_help">
<?= $Page->receive_per_installment_invertor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receive_per_installment_invertor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <div id="r_pay_number"<?= $Page->pay_number->rowAttributes() ?>>
        <label id="elh_asset_schedule_pay_number" for="x_pay_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number->caption() ?><?= $Page->pay_number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number->cellAttributes() ?>>
<span id="el_asset_schedule_pay_number">
<input type="<?= $Page->pay_number->getInputTextType() ?>" name="x_pay_number" id="x_pay_number" data-table="asset_schedule" data-field="x_pay_number" value="<?= $Page->pay_number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pay_number->getPlaceHolder()) ?>"<?= $Page->pay_number->editAttributes() ?> aria-describedby="x_pay_number_help">
<?= $Page->pay_number->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pay_number->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
    <div id="r_expired_date"<?= $Page->expired_date->rowAttributes() ?>>
        <label id="elh_asset_schedule_expired_date" for="x_expired_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expired_date->caption() ?><?= $Page->expired_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expired_date->cellAttributes() ?>>
<span id="el_asset_schedule_expired_date">
<input type="<?= $Page->expired_date->getInputTextType() ?>" name="x_expired_date" id="x_expired_date" data-table="asset_schedule" data-field="x_expired_date" value="<?= $Page->expired_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->expired_date->getPlaceHolder()) ?>"<?= $Page->expired_date->editAttributes() ?> aria-describedby="x_expired_date_help">
<?= $Page->expired_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expired_date->getErrorMessage() ?></div>
<?php if (!$Page->expired_date->ReadOnly && !$Page->expired_date->Disabled && !isset($Page->expired_date->EditAttrs["readonly"]) && !isset($Page->expired_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_scheduleedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_scheduleedit", "x_expired_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <div id="r_date_payment"<?= $Page->date_payment->rowAttributes() ?>>
        <label id="elh_asset_schedule_date_payment" for="x_date_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_payment->caption() ?><?= $Page->date_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_payment->cellAttributes() ?>>
<span id="el_asset_schedule_date_payment">
<input type="<?= $Page->date_payment->getInputTextType() ?>" name="x_date_payment" id="x_date_payment" data-table="asset_schedule" data-field="x_date_payment" value="<?= $Page->date_payment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_payment->getPlaceHolder()) ?>"<?= $Page->date_payment->editAttributes() ?> aria-describedby="x_date_payment_help">
<?= $Page->date_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_payment->getErrorMessage() ?></div>
<?php if (!$Page->date_payment->ReadOnly && !$Page->date_payment->Disabled && !isset($Page->date_payment->EditAttrs["readonly"]) && !isset($Page->date_payment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fasset_scheduleedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fasset_scheduleedit", "x_date_payment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <div id="r_status_payment"<?= $Page->status_payment->rowAttributes() ?>>
        <label id="elh_asset_schedule_status_payment" for="x_status_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_payment->caption() ?><?= $Page->status_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_payment->cellAttributes() ?>>
<span id="el_asset_schedule_status_payment">
    <select
        id="x_status_payment"
        name="x_status_payment"
        class="form-select ew-select<?= $Page->status_payment->isInvalidClass() ?>"
        data-select2-id="fasset_scheduleedit_x_status_payment"
        data-table="asset_schedule"
        data-field="x_status_payment"
        data-value-separator="<?= $Page->status_payment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_payment->getPlaceHolder()) ?>"
        <?= $Page->status_payment->editAttributes() ?>>
        <?= $Page->status_payment->selectOptionListHtml("x_status_payment") ?>
    </select>
    <?= $Page->status_payment->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status_payment->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_scheduleedit", function() {
    var options = { name: "x_status_payment", selectId: "fasset_scheduleedit_x_status_payment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_scheduleedit.lists.status_payment.lookupOptions.length) {
        options.data = { id: "x_status_payment", form: "fasset_scheduleedit" };
    } else {
        options.ajax = { id: "x_status_payment", form: "fasset_scheduleedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_schedule.fields.status_payment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
    <div id="r_installment_all"<?= $Page->installment_all->rowAttributes() ?>>
        <label id="elh_asset_schedule_installment_all" for="x_installment_all" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_all->caption() ?><?= $Page->installment_all->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_all->cellAttributes() ?>>
<span id="el_asset_schedule_installment_all">
<input type="<?= $Page->installment_all->getInputTextType() ?>" name="x_installment_all" id="x_installment_all" data-table="asset_schedule" data-field="x_installment_all" value="<?= $Page->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_all->getPlaceHolder()) ?>"<?= $Page->installment_all->editAttributes() ?> aria-describedby="x_installment_all_help">
<?= $Page->installment_all->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_all->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="asset_schedule" data-field="x_asset_schedule_id" data-hidden="1" name="x_asset_schedule_id" id="x_asset_schedule_id" value="<?= HtmlEncode($Page->asset_schedule_id->CurrentValue) ?>">
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
    ew.addEventHandlers("asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
