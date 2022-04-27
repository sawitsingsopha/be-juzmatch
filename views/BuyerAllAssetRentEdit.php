<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAllAssetRentEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_all_asset_rent: currentTable } });
var currentForm, currentPageID;
var fbuyer_all_asset_rentedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_all_asset_rentedit = new ew.Form("fbuyer_all_asset_rentedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbuyer_all_asset_rentedit;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_all_asset_rentedit.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["one_time_status", [fields.one_time_status.visible && fields.one_time_status.required ? ew.Validators.required(fields.one_time_status.caption) : null], fields.one_time_status.isInvalid],
        ["half_price_1", [fields.half_price_1.visible && fields.half_price_1.required ? ew.Validators.required(fields.half_price_1.caption) : null], fields.half_price_1.isInvalid],
        ["pay_number_half_price_1", [fields.pay_number_half_price_1.visible && fields.pay_number_half_price_1.required ? ew.Validators.required(fields.pay_number_half_price_1.caption) : null], fields.pay_number_half_price_1.isInvalid],
        ["status_pay_half_price_1", [fields.status_pay_half_price_1.visible && fields.status_pay_half_price_1.required ? ew.Validators.required(fields.status_pay_half_price_1.caption) : null], fields.status_pay_half_price_1.isInvalid],
        ["date_pay_half_price_1", [fields.date_pay_half_price_1.visible && fields.date_pay_half_price_1.required ? ew.Validators.required(fields.date_pay_half_price_1.caption) : null], fields.date_pay_half_price_1.isInvalid],
        ["due_date_pay_half_price_1", [fields.due_date_pay_half_price_1.visible && fields.due_date_pay_half_price_1.required ? ew.Validators.required(fields.due_date_pay_half_price_1.caption) : null, ew.Validators.datetime(fields.due_date_pay_half_price_1.clientFormatPattern)], fields.due_date_pay_half_price_1.isInvalid],
        ["half_price_2", [fields.half_price_2.visible && fields.half_price_2.required ? ew.Validators.required(fields.half_price_2.caption) : null], fields.half_price_2.isInvalid],
        ["pay_number_half_price_2", [fields.pay_number_half_price_2.visible && fields.pay_number_half_price_2.required ? ew.Validators.required(fields.pay_number_half_price_2.caption) : null], fields.pay_number_half_price_2.isInvalid],
        ["status_pay_half_price_2", [fields.status_pay_half_price_2.visible && fields.status_pay_half_price_2.required ? ew.Validators.required(fields.status_pay_half_price_2.caption) : null], fields.status_pay_half_price_2.isInvalid],
        ["date_pay_half_price_2", [fields.date_pay_half_price_2.visible && fields.date_pay_half_price_2.required ? ew.Validators.required(fields.date_pay_half_price_2.caption) : null], fields.date_pay_half_price_2.isInvalid],
        ["due_date_pay_half_price_2", [fields.due_date_pay_half_price_2.visible && fields.due_date_pay_half_price_2.required ? ew.Validators.required(fields.due_date_pay_half_price_2.caption) : null, ew.Validators.datetime(fields.due_date_pay_half_price_2.clientFormatPattern)], fields.due_date_pay_half_price_2.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid]
    ]);

    // Form_CustomValidate
    fbuyer_all_asset_rentedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_all_asset_rentedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fbuyer_all_asset_rentedit");
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
<form name="fbuyer_all_asset_rentedit" id="fbuyer_all_asset_rentedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_all_asset_rent">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer_all_booking_asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_all_booking_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
    <div id="r_one_time_status"<?= $Page->one_time_status->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_one_time_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->one_time_status->caption() ?><?= $Page->one_time_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->one_time_status->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_one_time_status">
<span<?= $Page->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->one_time_status->EditValue ?>" disabled<?php if (ConvertToBool($Page->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_one_time_status" data-hidden="1" name="x_one_time_status" id="x_one_time_status" value="<?= HtmlEncode($Page->one_time_status->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
    <div id="r_half_price_1"<?= $Page->half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_half_price_1" for="x_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->half_price_1->caption() ?><?= $Page->half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_half_price_1">
<span<?= $Page->half_price_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->half_price_1->getDisplayValue($Page->half_price_1->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_1" data-hidden="1" name="x_half_price_1" id="x_half_price_1" value="<?= HtmlEncode($Page->half_price_1->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
    <div id="r_pay_number_half_price_1"<?= $Page->pay_number_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_pay_number_half_price_1" for="x_pay_number_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number_half_price_1->caption() ?><?= $Page->pay_number_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_pay_number_half_price_1">
<span<?= $Page->pay_number_half_price_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pay_number_half_price_1->getDisplayValue($Page->pay_number_half_price_1->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_pay_number_half_price_1" data-hidden="1" name="x_pay_number_half_price_1" id="x_pay_number_half_price_1" value="<?= HtmlEncode($Page->pay_number_half_price_1->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
    <div id="r_status_pay_half_price_1"<?= $Page->status_pay_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_status_pay_half_price_1" for="x_status_pay_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_pay_half_price_1->caption() ?><?= $Page->status_pay_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_status_pay_half_price_1">
<span<?= $Page->status_pay_half_price_1->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status_pay_half_price_1->getDisplayValue($Page->status_pay_half_price_1->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_1" data-hidden="1" name="x_status_pay_half_price_1" id="x_status_pay_half_price_1" value="<?= HtmlEncode($Page->status_pay_half_price_1->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
    <div id="r_date_pay_half_price_1"<?= $Page->date_pay_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_date_pay_half_price_1" for="x_date_pay_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_pay_half_price_1->caption() ?><?= $Page->date_pay_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_date_pay_half_price_1">
<span<?= $Page->date_pay_half_price_1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date_pay_half_price_1->getDisplayValue($Page->date_pay_half_price_1->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_date_pay_half_price_1" data-hidden="1" name="x_date_pay_half_price_1" id="x_date_pay_half_price_1" value="<?= HtmlEncode($Page->date_pay_half_price_1->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
    <div id="r_due_date_pay_half_price_1"<?= $Page->due_date_pay_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_due_date_pay_half_price_1" for="x_due_date_pay_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date_pay_half_price_1->caption() ?><?= $Page->due_date_pay_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_due_date_pay_half_price_1">
<input type="<?= $Page->due_date_pay_half_price_1->getInputTextType() ?>" name="x_due_date_pay_half_price_1" id="x_due_date_pay_half_price_1" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_1" value="<?= $Page->due_date_pay_half_price_1->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date_pay_half_price_1->getPlaceHolder()) ?>"<?= $Page->due_date_pay_half_price_1->editAttributes() ?> aria-describedby="x_due_date_pay_half_price_1_help">
<?= $Page->due_date_pay_half_price_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date_pay_half_price_1->getErrorMessage() ?></div>
<?php if (!$Page->due_date_pay_half_price_1->ReadOnly && !$Page->due_date_pay_half_price_1->Disabled && !isset($Page->due_date_pay_half_price_1->EditAttrs["readonly"]) && !isset($Page->due_date_pay_half_price_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentedit", "x_due_date_pay_half_price_1", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
    <div id="r_half_price_2"<?= $Page->half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_half_price_2" for="x_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->half_price_2->caption() ?><?= $Page->half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_half_price_2">
<span<?= $Page->half_price_2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->half_price_2->getDisplayValue($Page->half_price_2->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_half_price_2" data-hidden="1" name="x_half_price_2" id="x_half_price_2" value="<?= HtmlEncode($Page->half_price_2->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
    <div id="r_pay_number_half_price_2"<?= $Page->pay_number_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_pay_number_half_price_2" for="x_pay_number_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number_half_price_2->caption() ?><?= $Page->pay_number_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_pay_number_half_price_2">
<span<?= $Page->pay_number_half_price_2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pay_number_half_price_2->getDisplayValue($Page->pay_number_half_price_2->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_pay_number_half_price_2" data-hidden="1" name="x_pay_number_half_price_2" id="x_pay_number_half_price_2" value="<?= HtmlEncode($Page->pay_number_half_price_2->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
    <div id="r_status_pay_half_price_2"<?= $Page->status_pay_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_status_pay_half_price_2" for="x_status_pay_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_pay_half_price_2->caption() ?><?= $Page->status_pay_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_status_pay_half_price_2">
<span<?= $Page->status_pay_half_price_2->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status_pay_half_price_2->getDisplayValue($Page->status_pay_half_price_2->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_status_pay_half_price_2" data-hidden="1" name="x_status_pay_half_price_2" id="x_status_pay_half_price_2" value="<?= HtmlEncode($Page->status_pay_half_price_2->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
    <div id="r_date_pay_half_price_2"<?= $Page->date_pay_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_date_pay_half_price_2" for="x_date_pay_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_pay_half_price_2->caption() ?><?= $Page->date_pay_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_date_pay_half_price_2">
<span<?= $Page->date_pay_half_price_2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->date_pay_half_price_2->getDisplayValue($Page->date_pay_half_price_2->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="buyer_all_asset_rent" data-field="x_date_pay_half_price_2" data-hidden="1" name="x_date_pay_half_price_2" id="x_date_pay_half_price_2" value="<?= HtmlEncode($Page->date_pay_half_price_2->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
    <div id="r_due_date_pay_half_price_2"<?= $Page->due_date_pay_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_all_asset_rent_due_date_pay_half_price_2" for="x_due_date_pay_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date_pay_half_price_2->caption() ?><?= $Page->due_date_pay_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_all_asset_rent_due_date_pay_half_price_2">
<input type="<?= $Page->due_date_pay_half_price_2->getInputTextType() ?>" name="x_due_date_pay_half_price_2" id="x_due_date_pay_half_price_2" data-table="buyer_all_asset_rent" data-field="x_due_date_pay_half_price_2" value="<?= $Page->due_date_pay_half_price_2->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date_pay_half_price_2->getPlaceHolder()) ?>"<?= $Page->due_date_pay_half_price_2->editAttributes() ?> aria-describedby="x_due_date_pay_half_price_2_help">
<?= $Page->due_date_pay_half_price_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date_pay_half_price_2->getErrorMessage() ?></div>
<?php if (!$Page->due_date_pay_half_price_2->ReadOnly && !$Page->due_date_pay_half_price_2->Disabled && !isset($Page->due_date_pay_half_price_2->EditAttrs["readonly"]) && !isset($Page->due_date_pay_half_price_2->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_all_asset_rentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_all_asset_rentedit", "x_due_date_pay_half_price_2", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="buyer_all_asset_rent" data-field="x_buyer_asset_rent_id" data-hidden="1" name="x_buyer_asset_rent_id" id="x_buyer_asset_rent_id" value="<?= HtmlEncode($Page->buyer_asset_rent_id->CurrentValue) ?>">
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
    ew.addEventHandlers("buyer_all_asset_rent");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
