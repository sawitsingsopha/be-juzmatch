<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseItemAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense_item: currentTable } });
var currentForm, currentPageID;
var fpeak_expense_itemadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expense_itemadd = new ew.Form("fpeak_expense_itemadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fpeak_expense_itemadd;

    // Add fields
    var fields = currentTable.fields;
    fpeak_expense_itemadd.addFields([
        ["peak_expense_id", [fields.peak_expense_id.visible && fields.peak_expense_id.required ? ew.Validators.required(fields.peak_expense_id.caption) : null, ew.Validators.integer], fields.peak_expense_id.isInvalid],
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["productId", [fields.productId.visible && fields.productId.required ? ew.Validators.required(fields.productId.caption) : null], fields.productId.isInvalid],
        ["productCode", [fields.productCode.visible && fields.productCode.required ? ew.Validators.required(fields.productCode.caption) : null], fields.productCode.isInvalid],
        ["accountCode", [fields.accountCode.visible && fields.accountCode.required ? ew.Validators.required(fields.accountCode.caption) : null], fields.accountCode.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["quantity", [fields.quantity.visible && fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.float], fields.quantity.isInvalid],
        ["price", [fields.price.visible && fields.price.required ? ew.Validators.required(fields.price.caption) : null, ew.Validators.float], fields.price.isInvalid],
        ["vatType", [fields.vatType.visible && fields.vatType.required ? ew.Validators.required(fields.vatType.caption) : null, ew.Validators.integer], fields.vatType.isInvalid],
        ["withHoldingTaxAmount", [fields.withHoldingTaxAmount.visible && fields.withHoldingTaxAmount.required ? ew.Validators.required(fields.withHoldingTaxAmount.caption) : null], fields.withHoldingTaxAmount.isInvalid],
        ["isdelete", [fields.isdelete.visible && fields.isdelete.required ? ew.Validators.required(fields.isdelete.caption) : null], fields.isdelete.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null, ew.Validators.datetime(fields.udate.clientFormatPattern)], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_expense_itemadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_expense_itemadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpeak_expense_itemadd.lists.isdelete = <?= $Page->isdelete->toClientList($Page) ?>;
    loadjs.done("fpeak_expense_itemadd");
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
<form name="fpeak_expense_itemadd" id="fpeak_expense_itemadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense_item">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
    <div id="r_peak_expense_id"<?= $Page->peak_expense_id->rowAttributes() ?>>
        <label id="elh_peak_expense_item_peak_expense_id" for="x_peak_expense_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->peak_expense_id->caption() ?><?= $Page->peak_expense_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el_peak_expense_item_peak_expense_id">
<input type="<?= $Page->peak_expense_id->getInputTextType() ?>" name="x_peak_expense_id" id="x_peak_expense_id" data-table="peak_expense_item" data-field="x_peak_expense_id" value="<?= $Page->peak_expense_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->peak_expense_id->getPlaceHolder()) ?>"<?= $Page->peak_expense_id->editAttributes() ?> aria-describedby="x_peak_expense_id_help">
<?= $Page->peak_expense_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->peak_expense_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_peak_expense_item_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_expense_item_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="peak_expense_item" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->productId->Visible) { // productId ?>
    <div id="r_productId"<?= $Page->productId->rowAttributes() ?>>
        <label id="elh_peak_expense_item_productId" for="x_productId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->productId->caption() ?><?= $Page->productId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->productId->cellAttributes() ?>>
<span id="el_peak_expense_item_productId">
<input type="<?= $Page->productId->getInputTextType() ?>" name="x_productId" id="x_productId" data-table="peak_expense_item" data-field="x_productId" value="<?= $Page->productId->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->productId->getPlaceHolder()) ?>"<?= $Page->productId->editAttributes() ?> aria-describedby="x_productId_help">
<?= $Page->productId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->productId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->productCode->Visible) { // productCode ?>
    <div id="r_productCode"<?= $Page->productCode->rowAttributes() ?>>
        <label id="elh_peak_expense_item_productCode" for="x_productCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->productCode->caption() ?><?= $Page->productCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->productCode->cellAttributes() ?>>
<span id="el_peak_expense_item_productCode">
<input type="<?= $Page->productCode->getInputTextType() ?>" name="x_productCode" id="x_productCode" data-table="peak_expense_item" data-field="x_productCode" value="<?= $Page->productCode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->productCode->getPlaceHolder()) ?>"<?= $Page->productCode->editAttributes() ?> aria-describedby="x_productCode_help">
<?= $Page->productCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->productCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->accountCode->Visible) { // accountCode ?>
    <div id="r_accountCode"<?= $Page->accountCode->rowAttributes() ?>>
        <label id="elh_peak_expense_item_accountCode" for="x_accountCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->accountCode->caption() ?><?= $Page->accountCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->accountCode->cellAttributes() ?>>
<span id="el_peak_expense_item_accountCode">
<input type="<?= $Page->accountCode->getInputTextType() ?>" name="x_accountCode" id="x_accountCode" data-table="peak_expense_item" data-field="x_accountCode" value="<?= $Page->accountCode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->accountCode->getPlaceHolder()) ?>"<?= $Page->accountCode->editAttributes() ?> aria-describedby="x_accountCode_help">
<?= $Page->accountCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->accountCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_peak_expense_item_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_peak_expense_item_description">
<textarea data-table="peak_expense_item" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity"<?= $Page->quantity->rowAttributes() ?>>
        <label id="elh_peak_expense_item_quantity" for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantity->caption() ?><?= $Page->quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->quantity->cellAttributes() ?>>
<span id="el_peak_expense_item_quantity">
<input type="<?= $Page->quantity->getInputTextType() ?>" name="x_quantity" id="x_quantity" data-table="peak_expense_item" data-field="x_quantity" value="<?= $Page->quantity->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>"<?= $Page->quantity->editAttributes() ?> aria-describedby="x_quantity_help">
<?= $Page->quantity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <div id="r_price"<?= $Page->price->rowAttributes() ?>>
        <label id="elh_peak_expense_item_price" for="x_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price->caption() ?><?= $Page->price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->price->cellAttributes() ?>>
<span id="el_peak_expense_item_price">
<input type="<?= $Page->price->getInputTextType() ?>" name="x_price" id="x_price" data-table="peak_expense_item" data-field="x_price" value="<?= $Page->price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>"<?= $Page->price->editAttributes() ?> aria-describedby="x_price_help">
<?= $Page->price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
    <div id="r_vatType"<?= $Page->vatType->rowAttributes() ?>>
        <label id="elh_peak_expense_item_vatType" for="x_vatType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vatType->caption() ?><?= $Page->vatType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vatType->cellAttributes() ?>>
<span id="el_peak_expense_item_vatType">
<input type="<?= $Page->vatType->getInputTextType() ?>" name="x_vatType" id="x_vatType" data-table="peak_expense_item" data-field="x_vatType" value="<?= $Page->vatType->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vatType->getPlaceHolder()) ?>"<?= $Page->vatType->editAttributes() ?> aria-describedby="x_vatType_help">
<?= $Page->vatType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vatType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
    <div id="r_withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_item_withHoldingTaxAmount" for="x_withHoldingTaxAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->withHoldingTaxAmount->caption() ?><?= $Page->withHoldingTaxAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el_peak_expense_item_withHoldingTaxAmount">
<input type="<?= $Page->withHoldingTaxAmount->getInputTextType() ?>" name="x_withHoldingTaxAmount" id="x_withHoldingTaxAmount" data-table="peak_expense_item" data-field="x_withHoldingTaxAmount" value="<?= $Page->withHoldingTaxAmount->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->withHoldingTaxAmount->getPlaceHolder()) ?>"<?= $Page->withHoldingTaxAmount->editAttributes() ?> aria-describedby="x_withHoldingTaxAmount_help">
<?= $Page->withHoldingTaxAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->withHoldingTaxAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isdelete->Visible) { // isdelete ?>
    <div id="r_isdelete"<?= $Page->isdelete->rowAttributes() ?>>
        <label id="elh_peak_expense_item_isdelete" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isdelete->caption() ?><?= $Page->isdelete->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isdelete->cellAttributes() ?>>
<span id="el_peak_expense_item_isdelete">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->isdelete->isInvalidClass() ?>" data-table="peak_expense_item" data-field="x_isdelete" name="x_isdelete[]" id="x_isdelete_826195" value="1"<?= ConvertToBool($Page->isdelete->CurrentValue) ? " checked" : "" ?><?= $Page->isdelete->editAttributes() ?> aria-describedby="x_isdelete_help">
    <div class="invalid-feedback"><?= $Page->isdelete->getErrorMessage() ?></div>
</div>
<?= $Page->isdelete->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_peak_expense_item_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_peak_expense_item_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="peak_expense_item" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expense_itemadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expense_itemadd", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_peak_expense_item_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_peak_expense_item_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="peak_expense_item" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_peak_expense_item_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_peak_expense_item_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="peak_expense_item" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <div id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <label id="elh_peak_expense_item_udate" for="x_udate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->udate->caption() ?><?= $Page->udate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->udate->cellAttributes() ?>>
<span id="el_peak_expense_item_udate">
<input type="<?= $Page->udate->getInputTextType() ?>" name="x_udate" id="x_udate" data-table="peak_expense_item" data-field="x_udate" value="<?= $Page->udate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->udate->getPlaceHolder()) ?>"<?= $Page->udate->editAttributes() ?> aria-describedby="x_udate_help">
<?= $Page->udate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->udate->getErrorMessage() ?></div>
<?php if (!$Page->udate->ReadOnly && !$Page->udate->Disabled && !isset($Page->udate->EditAttrs["readonly"]) && !isset($Page->udate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expense_itemadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expense_itemadd", "x_udate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <div id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <label id="elh_peak_expense_item_uuser" for="x_uuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuser->caption() ?><?= $Page->uuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uuser->cellAttributes() ?>>
<span id="el_peak_expense_item_uuser">
<input type="<?= $Page->uuser->getInputTextType() ?>" name="x_uuser" id="x_uuser" data-table="peak_expense_item" data-field="x_uuser" value="<?= $Page->uuser->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->uuser->getPlaceHolder()) ?>"<?= $Page->uuser->editAttributes() ?> aria-describedby="x_uuser_help">
<?= $Page->uuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <div id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <label id="elh_peak_expense_item_uip" for="x_uip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uip->caption() ?><?= $Page->uip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uip->cellAttributes() ?>>
<span id="el_peak_expense_item_uip">
<input type="<?= $Page->uip->getInputTextType() ?>" name="x_uip" id="x_uip" data-table="peak_expense_item" data-field="x_uip" value="<?= $Page->uip->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->uip->getPlaceHolder()) ?>"<?= $Page->uip->editAttributes() ?> aria-describedby="x_uip_help">
<?= $Page->uip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uip->getErrorMessage() ?></div>
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
    ew.addEventHandlers("peak_expense_item");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
