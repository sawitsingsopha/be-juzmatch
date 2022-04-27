<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakProductAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_product: currentTable } });
var currentForm, currentPageID;
var fpeak_productadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_productadd = new ew.Form("fpeak_productadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fpeak_productadd;

    // Add fields
    var fields = currentTable.fields;
    fpeak_productadd.addFields([
        ["productid", [fields.productid.visible && fields.productid.required ? ew.Validators.required(fields.productid.caption) : null], fields.productid.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null, ew.Validators.integer], fields.type.isInvalid],
        ["purchaseValue", [fields.purchaseValue.visible && fields.purchaseValue.required ? ew.Validators.required(fields.purchaseValue.caption) : null, ew.Validators.float], fields.purchaseValue.isInvalid],
        ["purchaseVatType", [fields.purchaseVatType.visible && fields.purchaseVatType.required ? ew.Validators.required(fields.purchaseVatType.caption) : null, ew.Validators.integer], fields.purchaseVatType.isInvalid],
        ["purchaseAccount", [fields.purchaseAccount.visible && fields.purchaseAccount.required ? ew.Validators.required(fields.purchaseAccount.caption) : null], fields.purchaseAccount.isInvalid],
        ["sellValue", [fields.sellValue.visible && fields.sellValue.required ? ew.Validators.required(fields.sellValue.caption) : null, ew.Validators.float], fields.sellValue.isInvalid],
        ["sellVatType", [fields.sellVatType.visible && fields.sellVatType.required ? ew.Validators.required(fields.sellVatType.caption) : null, ew.Validators.integer], fields.sellVatType.isInvalid],
        ["sellAccount", [fields.sellAccount.visible && fields.sellAccount.required ? ew.Validators.required(fields.sellAccount.caption) : null], fields.sellAccount.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["carryingBalanceValue", [fields.carryingBalanceValue.visible && fields.carryingBalanceValue.required ? ew.Validators.required(fields.carryingBalanceValue.caption) : null, ew.Validators.float], fields.carryingBalanceValue.isInvalid],
        ["carryingBalanceAmount", [fields.carryingBalanceAmount.visible && fields.carryingBalanceAmount.required ? ew.Validators.required(fields.carryingBalanceAmount.caption) : null, ew.Validators.float], fields.carryingBalanceAmount.isInvalid],
        ["remainingBalanceAmount", [fields.remainingBalanceAmount.visible && fields.remainingBalanceAmount.required ? ew.Validators.required(fields.remainingBalanceAmount.caption) : null, ew.Validators.float], fields.remainingBalanceAmount.isInvalid],
        ["create_date", [fields.create_date.visible && fields.create_date.required ? ew.Validators.required(fields.create_date.caption) : null, ew.Validators.datetime(fields.create_date.clientFormatPattern)], fields.create_date.isInvalid],
        ["update_date", [fields.update_date.visible && fields.update_date.required ? ew.Validators.required(fields.update_date.caption) : null, ew.Validators.datetime(fields.update_date.clientFormatPattern)], fields.update_date.isInvalid],
        ["post_message", [fields.post_message.visible && fields.post_message.required ? ew.Validators.required(fields.post_message.caption) : null, ew.Validators.integer], fields.post_message.isInvalid],
        ["post_try_cnt", [fields.post_try_cnt.visible && fields.post_try_cnt.required ? ew.Validators.required(fields.post_try_cnt.caption) : null, ew.Validators.integer], fields.post_try_cnt.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_productadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_productadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fpeak_productadd");
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
<form name="fpeak_productadd" id="fpeak_productadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_product">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->productid->Visible) { // productid ?>
    <div id="r_productid"<?= $Page->productid->rowAttributes() ?>>
        <label id="elh_peak_product_productid" for="x_productid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->productid->caption() ?><?= $Page->productid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->productid->cellAttributes() ?>>
<span id="el_peak_product_productid">
<input type="<?= $Page->productid->getInputTextType() ?>" name="x_productid" id="x_productid" data-table="peak_product" data-field="x_productid" value="<?= $Page->productid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->productid->getPlaceHolder()) ?>"<?= $Page->productid->editAttributes() ?> aria-describedby="x_productid_help">
<?= $Page->productid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->productid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_peak_product_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_peak_product_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="peak_product" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code"<?= $Page->code->rowAttributes() ?>>
        <label id="elh_peak_product_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code->cellAttributes() ?>>
<span id="el_peak_product_code">
<input type="<?= $Page->code->getInputTextType() ?>" name="x_code" id="x_code" data-table="peak_product" data-field="x_code" value="<?= $Page->code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_peak_product_type" for="x_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_peak_product_type">
<input type="<?= $Page->type->getInputTextType() ?>" name="x_type" id="x_type" data-table="peak_product" data-field="x_type" value="<?= $Page->type->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"<?= $Page->type->editAttributes() ?> aria-describedby="x_type_help">
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->purchaseValue->Visible) { // purchaseValue ?>
    <div id="r_purchaseValue"<?= $Page->purchaseValue->rowAttributes() ?>>
        <label id="elh_peak_product_purchaseValue" for="x_purchaseValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->purchaseValue->caption() ?><?= $Page->purchaseValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->purchaseValue->cellAttributes() ?>>
<span id="el_peak_product_purchaseValue">
<input type="<?= $Page->purchaseValue->getInputTextType() ?>" name="x_purchaseValue" id="x_purchaseValue" data-table="peak_product" data-field="x_purchaseValue" value="<?= $Page->purchaseValue->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->purchaseValue->getPlaceHolder()) ?>"<?= $Page->purchaseValue->editAttributes() ?> aria-describedby="x_purchaseValue_help">
<?= $Page->purchaseValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->purchaseValue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->purchaseVatType->Visible) { // purchaseVatType ?>
    <div id="r_purchaseVatType"<?= $Page->purchaseVatType->rowAttributes() ?>>
        <label id="elh_peak_product_purchaseVatType" for="x_purchaseVatType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->purchaseVatType->caption() ?><?= $Page->purchaseVatType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->purchaseVatType->cellAttributes() ?>>
<span id="el_peak_product_purchaseVatType">
<input type="<?= $Page->purchaseVatType->getInputTextType() ?>" name="x_purchaseVatType" id="x_purchaseVatType" data-table="peak_product" data-field="x_purchaseVatType" value="<?= $Page->purchaseVatType->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->purchaseVatType->getPlaceHolder()) ?>"<?= $Page->purchaseVatType->editAttributes() ?> aria-describedby="x_purchaseVatType_help">
<?= $Page->purchaseVatType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->purchaseVatType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->purchaseAccount->Visible) { // purchaseAccount ?>
    <div id="r_purchaseAccount"<?= $Page->purchaseAccount->rowAttributes() ?>>
        <label id="elh_peak_product_purchaseAccount" for="x_purchaseAccount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->purchaseAccount->caption() ?><?= $Page->purchaseAccount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->purchaseAccount->cellAttributes() ?>>
<span id="el_peak_product_purchaseAccount">
<input type="<?= $Page->purchaseAccount->getInputTextType() ?>" name="x_purchaseAccount" id="x_purchaseAccount" data-table="peak_product" data-field="x_purchaseAccount" value="<?= $Page->purchaseAccount->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->purchaseAccount->getPlaceHolder()) ?>"<?= $Page->purchaseAccount->editAttributes() ?> aria-describedby="x_purchaseAccount_help">
<?= $Page->purchaseAccount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->purchaseAccount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sellValue->Visible) { // sellValue ?>
    <div id="r_sellValue"<?= $Page->sellValue->rowAttributes() ?>>
        <label id="elh_peak_product_sellValue" for="x_sellValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sellValue->caption() ?><?= $Page->sellValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sellValue->cellAttributes() ?>>
<span id="el_peak_product_sellValue">
<input type="<?= $Page->sellValue->getInputTextType() ?>" name="x_sellValue" id="x_sellValue" data-table="peak_product" data-field="x_sellValue" value="<?= $Page->sellValue->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->sellValue->getPlaceHolder()) ?>"<?= $Page->sellValue->editAttributes() ?> aria-describedby="x_sellValue_help">
<?= $Page->sellValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sellValue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sellVatType->Visible) { // sellVatType ?>
    <div id="r_sellVatType"<?= $Page->sellVatType->rowAttributes() ?>>
        <label id="elh_peak_product_sellVatType" for="x_sellVatType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sellVatType->caption() ?><?= $Page->sellVatType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sellVatType->cellAttributes() ?>>
<span id="el_peak_product_sellVatType">
<input type="<?= $Page->sellVatType->getInputTextType() ?>" name="x_sellVatType" id="x_sellVatType" data-table="peak_product" data-field="x_sellVatType" value="<?= $Page->sellVatType->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->sellVatType->getPlaceHolder()) ?>"<?= $Page->sellVatType->editAttributes() ?> aria-describedby="x_sellVatType_help">
<?= $Page->sellVatType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sellVatType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sellAccount->Visible) { // sellAccount ?>
    <div id="r_sellAccount"<?= $Page->sellAccount->rowAttributes() ?>>
        <label id="elh_peak_product_sellAccount" for="x_sellAccount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sellAccount->caption() ?><?= $Page->sellAccount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sellAccount->cellAttributes() ?>>
<span id="el_peak_product_sellAccount">
<input type="<?= $Page->sellAccount->getInputTextType() ?>" name="x_sellAccount" id="x_sellAccount" data-table="peak_product" data-field="x_sellAccount" value="<?= $Page->sellAccount->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->sellAccount->getPlaceHolder()) ?>"<?= $Page->sellAccount->editAttributes() ?> aria-describedby="x_sellAccount_help">
<?= $Page->sellAccount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sellAccount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_peak_product_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_peak_product_description">
<textarea data-table="peak_product" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->carryingBalanceValue->Visible) { // carryingBalanceValue ?>
    <div id="r_carryingBalanceValue"<?= $Page->carryingBalanceValue->rowAttributes() ?>>
        <label id="elh_peak_product_carryingBalanceValue" for="x_carryingBalanceValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->carryingBalanceValue->caption() ?><?= $Page->carryingBalanceValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->carryingBalanceValue->cellAttributes() ?>>
<span id="el_peak_product_carryingBalanceValue">
<input type="<?= $Page->carryingBalanceValue->getInputTextType() ?>" name="x_carryingBalanceValue" id="x_carryingBalanceValue" data-table="peak_product" data-field="x_carryingBalanceValue" value="<?= $Page->carryingBalanceValue->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->carryingBalanceValue->getPlaceHolder()) ?>"<?= $Page->carryingBalanceValue->editAttributes() ?> aria-describedby="x_carryingBalanceValue_help">
<?= $Page->carryingBalanceValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->carryingBalanceValue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->carryingBalanceAmount->Visible) { // carryingBalanceAmount ?>
    <div id="r_carryingBalanceAmount"<?= $Page->carryingBalanceAmount->rowAttributes() ?>>
        <label id="elh_peak_product_carryingBalanceAmount" for="x_carryingBalanceAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->carryingBalanceAmount->caption() ?><?= $Page->carryingBalanceAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->carryingBalanceAmount->cellAttributes() ?>>
<span id="el_peak_product_carryingBalanceAmount">
<input type="<?= $Page->carryingBalanceAmount->getInputTextType() ?>" name="x_carryingBalanceAmount" id="x_carryingBalanceAmount" data-table="peak_product" data-field="x_carryingBalanceAmount" value="<?= $Page->carryingBalanceAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->carryingBalanceAmount->getPlaceHolder()) ?>"<?= $Page->carryingBalanceAmount->editAttributes() ?> aria-describedby="x_carryingBalanceAmount_help">
<?= $Page->carryingBalanceAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->carryingBalanceAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remainingBalanceAmount->Visible) { // remainingBalanceAmount ?>
    <div id="r_remainingBalanceAmount"<?= $Page->remainingBalanceAmount->rowAttributes() ?>>
        <label id="elh_peak_product_remainingBalanceAmount" for="x_remainingBalanceAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remainingBalanceAmount->caption() ?><?= $Page->remainingBalanceAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remainingBalanceAmount->cellAttributes() ?>>
<span id="el_peak_product_remainingBalanceAmount">
<input type="<?= $Page->remainingBalanceAmount->getInputTextType() ?>" name="x_remainingBalanceAmount" id="x_remainingBalanceAmount" data-table="peak_product" data-field="x_remainingBalanceAmount" value="<?= $Page->remainingBalanceAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->remainingBalanceAmount->getPlaceHolder()) ?>"<?= $Page->remainingBalanceAmount->editAttributes() ?> aria-describedby="x_remainingBalanceAmount_help">
<?= $Page->remainingBalanceAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remainingBalanceAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
    <div id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <label id="elh_peak_product_create_date" for="x_create_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->create_date->caption() ?><?= $Page->create_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->create_date->cellAttributes() ?>>
<span id="el_peak_product_create_date">
<input type="<?= $Page->create_date->getInputTextType() ?>" name="x_create_date" id="x_create_date" data-table="peak_product" data-field="x_create_date" value="<?= $Page->create_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->create_date->getPlaceHolder()) ?>"<?= $Page->create_date->editAttributes() ?> aria-describedby="x_create_date_help">
<?= $Page->create_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->create_date->getErrorMessage() ?></div>
<?php if (!$Page->create_date->ReadOnly && !$Page->create_date->Disabled && !isset($Page->create_date->EditAttrs["readonly"]) && !isset($Page->create_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_productadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_productadd", "x_create_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->update_date->Visible) { // update_date ?>
    <div id="r_update_date"<?= $Page->update_date->rowAttributes() ?>>
        <label id="elh_peak_product_update_date" for="x_update_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->update_date->caption() ?><?= $Page->update_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->update_date->cellAttributes() ?>>
<span id="el_peak_product_update_date">
<input type="<?= $Page->update_date->getInputTextType() ?>" name="x_update_date" id="x_update_date" data-table="peak_product" data-field="x_update_date" value="<?= $Page->update_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->update_date->getPlaceHolder()) ?>"<?= $Page->update_date->editAttributes() ?> aria-describedby="x_update_date_help">
<?= $Page->update_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->update_date->getErrorMessage() ?></div>
<?php if (!$Page->update_date->ReadOnly && !$Page->update_date->Disabled && !isset($Page->update_date->EditAttrs["readonly"]) && !isset($Page->update_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_productadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_productadd", "x_update_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->post_message->Visible) { // post_message ?>
    <div id="r_post_message"<?= $Page->post_message->rowAttributes() ?>>
        <label id="elh_peak_product_post_message" for="x_post_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->post_message->caption() ?><?= $Page->post_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->post_message->cellAttributes() ?>>
<span id="el_peak_product_post_message">
<input type="<?= $Page->post_message->getInputTextType() ?>" name="x_post_message" id="x_post_message" data-table="peak_product" data-field="x_post_message" value="<?= $Page->post_message->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->post_message->getPlaceHolder()) ?>"<?= $Page->post_message->editAttributes() ?> aria-describedby="x_post_message_help">
<?= $Page->post_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->post_message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->post_try_cnt->Visible) { // post_try_cnt ?>
    <div id="r_post_try_cnt"<?= $Page->post_try_cnt->rowAttributes() ?>>
        <label id="elh_peak_product_post_try_cnt" for="x_post_try_cnt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->post_try_cnt->caption() ?><?= $Page->post_try_cnt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->post_try_cnt->cellAttributes() ?>>
<span id="el_peak_product_post_try_cnt">
<input type="<?= $Page->post_try_cnt->getInputTextType() ?>" name="x_post_try_cnt" id="x_post_try_cnt" data-table="peak_product" data-field="x_post_try_cnt" value="<?= $Page->post_try_cnt->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->post_try_cnt->getPlaceHolder()) ?>"<?= $Page->post_try_cnt->editAttributes() ?> aria-describedby="x_post_try_cnt_help">
<?= $Page->post_try_cnt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->post_try_cnt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("peak_product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
