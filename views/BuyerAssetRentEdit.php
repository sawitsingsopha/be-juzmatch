<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetRentEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_asset_rent: currentTable } });
var currentForm, currentPageID;
var fbuyer_asset_rentedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_asset_rentedit = new ew.Form("fbuyer_asset_rentedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbuyer_asset_rentedit;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_asset_rentedit.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["one_time_status", [fields.one_time_status.visible && fields.one_time_status.required ? ew.Validators.required(fields.one_time_status.caption) : null], fields.one_time_status.isInvalid],
        ["half_price_1", [fields.half_price_1.visible && fields.half_price_1.required ? ew.Validators.required(fields.half_price_1.caption) : null, ew.Validators.float], fields.half_price_1.isInvalid],
        ["status_pay_half_price_1", [fields.status_pay_half_price_1.visible && fields.status_pay_half_price_1.required ? ew.Validators.required(fields.status_pay_half_price_1.caption) : null], fields.status_pay_half_price_1.isInvalid],
        ["pay_number_half_price_1", [fields.pay_number_half_price_1.visible && fields.pay_number_half_price_1.required ? ew.Validators.required(fields.pay_number_half_price_1.caption) : null], fields.pay_number_half_price_1.isInvalid],
        ["date_pay_half_price_1", [fields.date_pay_half_price_1.visible && fields.date_pay_half_price_1.required ? ew.Validators.required(fields.date_pay_half_price_1.caption) : null, ew.Validators.datetime(fields.date_pay_half_price_1.clientFormatPattern)], fields.date_pay_half_price_1.isInvalid],
        ["due_date_pay_half_price_1", [fields.due_date_pay_half_price_1.visible && fields.due_date_pay_half_price_1.required ? ew.Validators.required(fields.due_date_pay_half_price_1.caption) : null, ew.Validators.datetime(fields.due_date_pay_half_price_1.clientFormatPattern)], fields.due_date_pay_half_price_1.isInvalid],
        ["half_price_2", [fields.half_price_2.visible && fields.half_price_2.required ? ew.Validators.required(fields.half_price_2.caption) : null, ew.Validators.float], fields.half_price_2.isInvalid],
        ["status_pay_half_price_2", [fields.status_pay_half_price_2.visible && fields.status_pay_half_price_2.required ? ew.Validators.required(fields.status_pay_half_price_2.caption) : null], fields.status_pay_half_price_2.isInvalid],
        ["pay_number_half_price_2", [fields.pay_number_half_price_2.visible && fields.pay_number_half_price_2.required ? ew.Validators.required(fields.pay_number_half_price_2.caption) : null], fields.pay_number_half_price_2.isInvalid],
        ["date_pay_half_price_2", [fields.date_pay_half_price_2.visible && fields.date_pay_half_price_2.required ? ew.Validators.required(fields.date_pay_half_price_2.caption) : null, ew.Validators.datetime(fields.date_pay_half_price_2.clientFormatPattern)], fields.date_pay_half_price_2.isInvalid],
        ["due_date_pay_half_price_2", [fields.due_date_pay_half_price_2.visible && fields.due_date_pay_half_price_2.required ? ew.Validators.required(fields.due_date_pay_half_price_2.caption) : null, ew.Validators.datetime(fields.due_date_pay_half_price_2.clientFormatPattern)], fields.due_date_pay_half_price_2.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid]
    ]);

    // Form_CustomValidate
    fbuyer_asset_rentedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_asset_rentedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_asset_rentedit.lists.one_time_status = <?= $Page->one_time_status->toClientList($Page) ?>;
    fbuyer_asset_rentedit.lists.status_pay_half_price_1 = <?= $Page->status_pay_half_price_1->toClientList($Page) ?>;
    fbuyer_asset_rentedit.lists.status_pay_half_price_2 = <?= $Page->status_pay_half_price_2->toClientList($Page) ?>;
    loadjs.done("fbuyer_asset_rentedit");
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
<form name="fbuyer_asset_rentedit" id="fbuyer_asset_rentedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_asset_rent">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer_asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_buyer_asset_rent_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_asset_rent" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_asset_rent_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_asset_rent" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
    <div id="r_one_time_status"<?= $Page->one_time_status->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_one_time_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->one_time_status->caption() ?><?= $Page->one_time_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->one_time_status->cellAttributes() ?>>
<span id="el_buyer_asset_rent_one_time_status">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->one_time_status->isInvalidClass() ?>" data-table="buyer_asset_rent" data-field="x_one_time_status" name="x_one_time_status[]" id="x_one_time_status_595695" value="1"<?= ConvertToBool($Page->one_time_status->CurrentValue) ? " checked" : "" ?><?= $Page->one_time_status->editAttributes() ?> aria-describedby="x_one_time_status_help">
    <div class="invalid-feedback"><?= $Page->one_time_status->getErrorMessage() ?></div>
</div>
<?= $Page->one_time_status->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
    <div id="r_half_price_1"<?= $Page->half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_half_price_1" for="x_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->half_price_1->caption() ?><?= $Page->half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->half_price_1->cellAttributes() ?>>
<span id="el_buyer_asset_rent_half_price_1">
<input type="<?= $Page->half_price_1->getInputTextType() ?>" name="x_half_price_1" id="x_half_price_1" data-table="buyer_asset_rent" data-field="x_half_price_1" value="<?= $Page->half_price_1->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->half_price_1->getPlaceHolder()) ?>"<?= $Page->half_price_1->editAttributes() ?> aria-describedby="x_half_price_1_help">
<?= $Page->half_price_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->half_price_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
    <div id="r_status_pay_half_price_1"<?= $Page->status_pay_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_status_pay_half_price_1" for="x_status_pay_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_pay_half_price_1->caption() ?><?= $Page->status_pay_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_asset_rent_status_pay_half_price_1">
    <select
        id="x_status_pay_half_price_1"
        name="x_status_pay_half_price_1"
        class="form-select ew-select<?= $Page->status_pay_half_price_1->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_rentedit_x_status_pay_half_price_1"
        data-table="buyer_asset_rent"
        data-field="x_status_pay_half_price_1"
        data-value-separator="<?= $Page->status_pay_half_price_1->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_pay_half_price_1->getPlaceHolder()) ?>"
        <?= $Page->status_pay_half_price_1->editAttributes() ?>>
        <?= $Page->status_pay_half_price_1->selectOptionListHtml("x_status_pay_half_price_1") ?>
    </select>
    <?= $Page->status_pay_half_price_1->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status_pay_half_price_1->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_rentedit", function() {
    var options = { name: "x_status_pay_half_price_1", selectId: "fbuyer_asset_rentedit_x_status_pay_half_price_1" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_rentedit.lists.status_pay_half_price_1.lookupOptions.length) {
        options.data = { id: "x_status_pay_half_price_1", form: "fbuyer_asset_rentedit" };
    } else {
        options.ajax = { id: "x_status_pay_half_price_1", form: "fbuyer_asset_rentedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_rent.fields.status_pay_half_price_1.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number_half_price_1->Visible) { // pay_number_half_price_1 ?>
    <div id="r_pay_number_half_price_1"<?= $Page->pay_number_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_pay_number_half_price_1" for="x_pay_number_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number_half_price_1->caption() ?><?= $Page->pay_number_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number_half_price_1->cellAttributes() ?>>
<span id="el_buyer_asset_rent_pay_number_half_price_1">
<input type="<?= $Page->pay_number_half_price_1->getInputTextType() ?>" name="x_pay_number_half_price_1" id="x_pay_number_half_price_1" data-table="buyer_asset_rent" data-field="x_pay_number_half_price_1" value="<?= $Page->pay_number_half_price_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pay_number_half_price_1->getPlaceHolder()) ?>"<?= $Page->pay_number_half_price_1->editAttributes() ?> aria-describedby="x_pay_number_half_price_1_help">
<?= $Page->pay_number_half_price_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pay_number_half_price_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_pay_half_price_1->Visible) { // date_pay_half_price_1 ?>
    <div id="r_date_pay_half_price_1"<?= $Page->date_pay_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_date_pay_half_price_1" for="x_date_pay_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_pay_half_price_1->caption() ?><?= $Page->date_pay_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_asset_rent_date_pay_half_price_1">
<input type="<?= $Page->date_pay_half_price_1->getInputTextType() ?>" name="x_date_pay_half_price_1" id="x_date_pay_half_price_1" data-table="buyer_asset_rent" data-field="x_date_pay_half_price_1" value="<?= $Page->date_pay_half_price_1->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_pay_half_price_1->getPlaceHolder()) ?>"<?= $Page->date_pay_half_price_1->editAttributes() ?> aria-describedby="x_date_pay_half_price_1_help">
<?= $Page->date_pay_half_price_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_pay_half_price_1->getErrorMessage() ?></div>
<?php if (!$Page->date_pay_half_price_1->ReadOnly && !$Page->date_pay_half_price_1->Disabled && !isset($Page->date_pay_half_price_1->EditAttrs["readonly"]) && !isset($Page->date_pay_half_price_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_rentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_rentedit", "x_date_pay_half_price_1", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
    <div id="r_due_date_pay_half_price_1"<?= $Page->due_date_pay_half_price_1->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_due_date_pay_half_price_1" for="x_due_date_pay_half_price_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date_pay_half_price_1->caption() ?><?= $Page->due_date_pay_half_price_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span id="el_buyer_asset_rent_due_date_pay_half_price_1">
<input type="<?= $Page->due_date_pay_half_price_1->getInputTextType() ?>" name="x_due_date_pay_half_price_1" id="x_due_date_pay_half_price_1" data-table="buyer_asset_rent" data-field="x_due_date_pay_half_price_1" value="<?= $Page->due_date_pay_half_price_1->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date_pay_half_price_1->getPlaceHolder()) ?>"<?= $Page->due_date_pay_half_price_1->editAttributes() ?> aria-describedby="x_due_date_pay_half_price_1_help">
<?= $Page->due_date_pay_half_price_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date_pay_half_price_1->getErrorMessage() ?></div>
<?php if (!$Page->due_date_pay_half_price_1->ReadOnly && !$Page->due_date_pay_half_price_1->Disabled && !isset($Page->due_date_pay_half_price_1->EditAttrs["readonly"]) && !isset($Page->due_date_pay_half_price_1->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_rentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_rentedit", "x_due_date_pay_half_price_1", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
    <div id="r_half_price_2"<?= $Page->half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_half_price_2" for="x_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->half_price_2->caption() ?><?= $Page->half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->half_price_2->cellAttributes() ?>>
<span id="el_buyer_asset_rent_half_price_2">
<input type="<?= $Page->half_price_2->getInputTextType() ?>" name="x_half_price_2" id="x_half_price_2" data-table="buyer_asset_rent" data-field="x_half_price_2" value="<?= $Page->half_price_2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->half_price_2->getPlaceHolder()) ?>"<?= $Page->half_price_2->editAttributes() ?> aria-describedby="x_half_price_2_help">
<?= $Page->half_price_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->half_price_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
    <div id="r_status_pay_half_price_2"<?= $Page->status_pay_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_status_pay_half_price_2" for="x_status_pay_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_pay_half_price_2->caption() ?><?= $Page->status_pay_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_asset_rent_status_pay_half_price_2">
    <select
        id="x_status_pay_half_price_2"
        name="x_status_pay_half_price_2"
        class="form-select ew-select<?= $Page->status_pay_half_price_2->isInvalidClass() ?>"
        data-select2-id="fbuyer_asset_rentedit_x_status_pay_half_price_2"
        data-table="buyer_asset_rent"
        data-field="x_status_pay_half_price_2"
        data-value-separator="<?= $Page->status_pay_half_price_2->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_pay_half_price_2->getPlaceHolder()) ?>"
        <?= $Page->status_pay_half_price_2->editAttributes() ?>>
        <?= $Page->status_pay_half_price_2->selectOptionListHtml("x_status_pay_half_price_2") ?>
    </select>
    <?= $Page->status_pay_half_price_2->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status_pay_half_price_2->getErrorMessage() ?></div>
<script>
loadjs.ready("fbuyer_asset_rentedit", function() {
    var options = { name: "x_status_pay_half_price_2", selectId: "fbuyer_asset_rentedit_x_status_pay_half_price_2" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_asset_rentedit.lists.status_pay_half_price_2.lookupOptions.length) {
        options.data = { id: "x_status_pay_half_price_2", form: "fbuyer_asset_rentedit" };
    } else {
        options.ajax = { id: "x_status_pay_half_price_2", form: "fbuyer_asset_rentedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_asset_rent.fields.status_pay_half_price_2.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_number_half_price_2->Visible) { // pay_number_half_price_2 ?>
    <div id="r_pay_number_half_price_2"<?= $Page->pay_number_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_pay_number_half_price_2" for="x_pay_number_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_number_half_price_2->caption() ?><?= $Page->pay_number_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_number_half_price_2->cellAttributes() ?>>
<span id="el_buyer_asset_rent_pay_number_half_price_2">
<input type="<?= $Page->pay_number_half_price_2->getInputTextType() ?>" name="x_pay_number_half_price_2" id="x_pay_number_half_price_2" data-table="buyer_asset_rent" data-field="x_pay_number_half_price_2" value="<?= $Page->pay_number_half_price_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pay_number_half_price_2->getPlaceHolder()) ?>"<?= $Page->pay_number_half_price_2->editAttributes() ?> aria-describedby="x_pay_number_half_price_2_help">
<?= $Page->pay_number_half_price_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pay_number_half_price_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_pay_half_price_2->Visible) { // date_pay_half_price_2 ?>
    <div id="r_date_pay_half_price_2"<?= $Page->date_pay_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_date_pay_half_price_2" for="x_date_pay_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_pay_half_price_2->caption() ?><?= $Page->date_pay_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_asset_rent_date_pay_half_price_2">
<input type="<?= $Page->date_pay_half_price_2->getInputTextType() ?>" name="x_date_pay_half_price_2" id="x_date_pay_half_price_2" data-table="buyer_asset_rent" data-field="x_date_pay_half_price_2" value="<?= $Page->date_pay_half_price_2->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_pay_half_price_2->getPlaceHolder()) ?>"<?= $Page->date_pay_half_price_2->editAttributes() ?> aria-describedby="x_date_pay_half_price_2_help">
<?= $Page->date_pay_half_price_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_pay_half_price_2->getErrorMessage() ?></div>
<?php if (!$Page->date_pay_half_price_2->ReadOnly && !$Page->date_pay_half_price_2->Disabled && !isset($Page->date_pay_half_price_2->EditAttrs["readonly"]) && !isset($Page->date_pay_half_price_2->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_rentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_rentedit", "x_date_pay_half_price_2", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
    <div id="r_due_date_pay_half_price_2"<?= $Page->due_date_pay_half_price_2->rowAttributes() ?>>
        <label id="elh_buyer_asset_rent_due_date_pay_half_price_2" for="x_due_date_pay_half_price_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due_date_pay_half_price_2->caption() ?><?= $Page->due_date_pay_half_price_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span id="el_buyer_asset_rent_due_date_pay_half_price_2">
<input type="<?= $Page->due_date_pay_half_price_2->getInputTextType() ?>" name="x_due_date_pay_half_price_2" id="x_due_date_pay_half_price_2" data-table="buyer_asset_rent" data-field="x_due_date_pay_half_price_2" value="<?= $Page->due_date_pay_half_price_2->EditValue ?>" placeholder="<?= HtmlEncode($Page->due_date_pay_half_price_2->getPlaceHolder()) ?>"<?= $Page->due_date_pay_half_price_2->editAttributes() ?> aria-describedby="x_due_date_pay_half_price_2_help">
<?= $Page->due_date_pay_half_price_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due_date_pay_half_price_2->getErrorMessage() ?></div>
<?php if (!$Page->due_date_pay_half_price_2->ReadOnly && !$Page->due_date_pay_half_price_2->Disabled && !isset($Page->due_date_pay_half_price_2->EditAttrs["readonly"]) && !isset($Page->due_date_pay_half_price_2->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbuyer_asset_rentedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fbuyer_asset_rentedit", "x_due_date_pay_half_price_2", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="buyer_asset_rent" data-field="x_buyer_asset_rent_id" data-hidden="1" name="x_buyer_asset_rent_id" id="x_buyer_asset_rent_id" value="<?= HtmlEncode($Page->buyer_asset_rent_id->CurrentValue) ?>">
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
    ew.addEventHandlers("buyer_asset_rent");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
