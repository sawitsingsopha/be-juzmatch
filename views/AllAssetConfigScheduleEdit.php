<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllAssetConfigScheduleEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_asset_config_schedule: currentTable } });
var currentForm, currentPageID;
var fall_asset_config_scheduleedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_asset_config_scheduleedit = new ew.Form("fall_asset_config_scheduleedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fall_asset_config_scheduleedit;

    // Add fields
    var fields = currentTable.fields;
    fall_asset_config_scheduleedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["installment_all", [fields.installment_all.visible && fields.installment_all.required ? ew.Validators.required(fields.installment_all.caption) : null, ew.Validators.integer], fields.installment_all.isInvalid],
        ["installment_price_per", [fields.installment_price_per.visible && fields.installment_price_per.required ? ew.Validators.required(fields.installment_price_per.caption) : null, ew.Validators.float], fields.installment_price_per.isInvalid],
        ["date_start_installment", [fields.date_start_installment.visible && fields.date_start_installment.required ? ew.Validators.required(fields.date_start_installment.caption) : null, ew.Validators.datetime(fields.date_start_installment.clientFormatPattern)], fields.date_start_installment.isInvalid],
        ["status_approve", [fields.status_approve.visible && fields.status_approve.required ? ew.Validators.required(fields.status_approve.caption) : null], fields.status_approve.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid]
    ]);

    // Form_CustomValidate
    fall_asset_config_scheduleedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fall_asset_config_scheduleedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fall_asset_config_scheduleedit.lists.status_approve = <?= $Page->status_approve->toClientList($Page) ?>;
    loadjs.done("fall_asset_config_scheduleedit");
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
<form name="fall_asset_config_scheduleedit" id="fall_asset_config_scheduleedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_asset_config_schedule">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "invertor_all_booking") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invertor_all_booking">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_all_asset_config_schedule_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_all_asset_config_schedule_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="all_asset_config_schedule" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
    <div id="r_installment_all"<?= $Page->installment_all->rowAttributes() ?>>
        <label id="elh_all_asset_config_schedule_installment_all" for="x_installment_all" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_all->caption() ?><?= $Page->installment_all->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_all->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_installment_all">
<input type="<?= $Page->installment_all->getInputTextType() ?>" name="x_installment_all" id="x_installment_all" data-table="all_asset_config_schedule" data-field="x_installment_all" value="<?= $Page->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_all->getPlaceHolder()) ?>"<?= $Page->installment_all->editAttributes() ?> aria-describedby="x_installment_all_help">
<?= $Page->installment_all->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_all->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
    <div id="r_installment_price_per"<?= $Page->installment_price_per->rowAttributes() ?>>
        <label id="elh_all_asset_config_schedule_installment_price_per" for="x_installment_price_per" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_price_per->caption() ?><?= $Page->installment_price_per->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_installment_price_per">
<input type="<?= $Page->installment_price_per->getInputTextType() ?>" name="x_installment_price_per" id="x_installment_price_per" data-type="currency" data-table="all_asset_config_schedule" data-field="x_installment_price_per" value="<?= $Page->installment_price_per->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_price_per->getPlaceHolder()) ?>"<?= $Page->installment_price_per->editAttributes() ?> aria-describedby="x_installment_price_per_help">
<?= $Page->installment_price_per->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_price_per->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
    <div id="r_date_start_installment"<?= $Page->date_start_installment->rowAttributes() ?>>
        <label id="elh_all_asset_config_schedule_date_start_installment" for="x_date_start_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_start_installment->caption() ?><?= $Page->date_start_installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_date_start_installment">
<input type="<?= $Page->date_start_installment->getInputTextType() ?>" name="x_date_start_installment" id="x_date_start_installment" data-table="all_asset_config_schedule" data-field="x_date_start_installment" value="<?= $Page->date_start_installment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_start_installment->getPlaceHolder()) ?>"<?= $Page->date_start_installment->editAttributes() ?> aria-describedby="x_date_start_installment_help">
<?= $Page->date_start_installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_start_installment->getErrorMessage() ?></div>
<?php if (!$Page->date_start_installment->ReadOnly && !$Page->date_start_installment->Disabled && !isset($Page->date_start_installment->EditAttrs["readonly"]) && !isset($Page->date_start_installment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_asset_config_scheduleedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fall_asset_config_scheduleedit", "x_date_start_installment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
    <div id="r_status_approve"<?= $Page->status_approve->rowAttributes() ?>>
        <label id="elh_all_asset_config_schedule_status_approve" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_approve->caption() ?><?= $Page->status_approve->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_approve->cellAttributes() ?>>
<span id="el_all_asset_config_schedule_status_approve">
<template id="tp_x_status_approve">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="all_asset_config_schedule" data-field="x_status_approve" name="x_status_approve" id="x_status_approve"<?= $Page->status_approve->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status_approve" class="ew-item-list"></div>
<selection-list hidden
    id="x_status_approve"
    name="x_status_approve"
    value="<?= HtmlEncode($Page->status_approve->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_approve"
    data-bs-target="dsl_x_status_approve"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_approve->isInvalidClass() ?>"
    data-table="all_asset_config_schedule"
    data-field="x_status_approve"
    data-value-separator="<?= $Page->status_approve->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_approve->editAttributes() ?>></selection-list>
<?= $Page->status_approve->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_approve->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="all_asset_config_schedule" data-field="x_asset_config_schedule_id" data-hidden="1" name="x_asset_config_schedule_id" id="x_asset_config_schedule_id" value="<?= HtmlEncode($Page->asset_config_schedule_id->CurrentValue) ?>">
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
    ew.addEventHandlers("all_asset_config_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
