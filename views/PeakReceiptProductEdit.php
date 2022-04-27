<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReceiptProductEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_receipt_product: currentTable } });
var currentForm, currentPageID;
var fpeak_receipt_productedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_receipt_productedit = new ew.Form("fpeak_receipt_productedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpeak_receipt_productedit;

    // Add fields
    var fields = currentTable.fields;
    fpeak_receipt_productedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["peak_receipt_id", [fields.peak_receipt_id.visible && fields.peak_receipt_id.required ? ew.Validators.required(fields.peak_receipt_id.caption) : null, ew.Validators.integer], fields.peak_receipt_id.isInvalid],
        ["products_id", [fields.products_id.visible && fields.products_id.required ? ew.Validators.required(fields.products_id.caption) : null], fields.products_id.isInvalid],
        ["productid", [fields.productid.visible && fields.productid.required ? ew.Validators.required(fields.productid.caption) : null], fields.productid.isInvalid],
        ["productcode", [fields.productcode.visible && fields.productcode.required ? ew.Validators.required(fields.productcode.caption) : null], fields.productcode.isInvalid],
        ["producttemplate", [fields.producttemplate.visible && fields.producttemplate.required ? ew.Validators.required(fields.producttemplate.caption) : null], fields.producttemplate.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["accountcode", [fields.accountcode.visible && fields.accountcode.required ? ew.Validators.required(fields.accountcode.caption) : null], fields.accountcode.isInvalid],
        ["accountSubId", [fields.accountSubId.visible && fields.accountSubId.required ? ew.Validators.required(fields.accountSubId.caption) : null], fields.accountSubId.isInvalid],
        ["accountSubCode", [fields.accountSubCode.visible && fields.accountSubCode.required ? ew.Validators.required(fields.accountSubCode.caption) : null], fields.accountSubCode.isInvalid],
        ["quantity", [fields.quantity.visible && fields.quantity.required ? ew.Validators.required(fields.quantity.caption) : null, ew.Validators.float], fields.quantity.isInvalid],
        ["price", [fields.price.visible && fields.price.required ? ew.Validators.required(fields.price.caption) : null, ew.Validators.float], fields.price.isInvalid],
        ["discount", [fields.discount.visible && fields.discount.required ? ew.Validators.required(fields.discount.caption) : null, ew.Validators.float], fields.discount.isInvalid],
        ["vatType", [fields.vatType.visible && fields.vatType.required ? ew.Validators.required(fields.vatType.caption) : null], fields.vatType.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_receipt_productedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_receipt_productedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fpeak_receipt_productedit");
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
<form name="fpeak_receipt_productedit" id="fpeak_receipt_productedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_receipt_product">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_receipt_product_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="peak_receipt_product" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->peak_receipt_id->Visible) { // peak_receipt_id ?>
    <div id="r_peak_receipt_id"<?= $Page->peak_receipt_id->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_peak_receipt_id" for="x_peak_receipt_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->peak_receipt_id->caption() ?><?= $Page->peak_receipt_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->peak_receipt_id->cellAttributes() ?>>
<span id="el_peak_receipt_product_peak_receipt_id">
<input type="<?= $Page->peak_receipt_id->getInputTextType() ?>" name="x_peak_receipt_id" id="x_peak_receipt_id" data-table="peak_receipt_product" data-field="x_peak_receipt_id" value="<?= $Page->peak_receipt_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->peak_receipt_id->getPlaceHolder()) ?>"<?= $Page->peak_receipt_id->editAttributes() ?> aria-describedby="x_peak_receipt_id_help">
<?= $Page->peak_receipt_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->peak_receipt_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->products_id->Visible) { // products_id ?>
    <div id="r_products_id"<?= $Page->products_id->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_products_id" for="x_products_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->products_id->caption() ?><?= $Page->products_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->products_id->cellAttributes() ?>>
<span id="el_peak_receipt_product_products_id">
<input type="<?= $Page->products_id->getInputTextType() ?>" name="x_products_id" id="x_products_id" data-table="peak_receipt_product" data-field="x_products_id" value="<?= $Page->products_id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->products_id->getPlaceHolder()) ?>"<?= $Page->products_id->editAttributes() ?> aria-describedby="x_products_id_help">
<?= $Page->products_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->products_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->productid->Visible) { // productid ?>
    <div id="r_productid"<?= $Page->productid->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_productid" for="x_productid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->productid->caption() ?><?= $Page->productid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->productid->cellAttributes() ?>>
<span id="el_peak_receipt_product_productid">
<input type="<?= $Page->productid->getInputTextType() ?>" name="x_productid" id="x_productid" data-table="peak_receipt_product" data-field="x_productid" value="<?= $Page->productid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->productid->getPlaceHolder()) ?>"<?= $Page->productid->editAttributes() ?> aria-describedby="x_productid_help">
<?= $Page->productid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->productid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->productcode->Visible) { // productcode ?>
    <div id="r_productcode"<?= $Page->productcode->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_productcode" for="x_productcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->productcode->caption() ?><?= $Page->productcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->productcode->cellAttributes() ?>>
<span id="el_peak_receipt_product_productcode">
<input type="<?= $Page->productcode->getInputTextType() ?>" name="x_productcode" id="x_productcode" data-table="peak_receipt_product" data-field="x_productcode" value="<?= $Page->productcode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->productcode->getPlaceHolder()) ?>"<?= $Page->productcode->editAttributes() ?> aria-describedby="x_productcode_help">
<?= $Page->productcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->productcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->producttemplate->Visible) { // producttemplate ?>
    <div id="r_producttemplate"<?= $Page->producttemplate->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_producttemplate" for="x_producttemplate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->producttemplate->caption() ?><?= $Page->producttemplate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->producttemplate->cellAttributes() ?>>
<span id="el_peak_receipt_product_producttemplate">
<input type="<?= $Page->producttemplate->getInputTextType() ?>" name="x_producttemplate" id="x_producttemplate" data-table="peak_receipt_product" data-field="x_producttemplate" value="<?= $Page->producttemplate->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->producttemplate->getPlaceHolder()) ?>"<?= $Page->producttemplate->editAttributes() ?> aria-describedby="x_producttemplate_help">
<?= $Page->producttemplate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->producttemplate->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_peak_receipt_product_description">
<textarea data-table="peak_receipt_product" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->accountcode->Visible) { // accountcode ?>
    <div id="r_accountcode"<?= $Page->accountcode->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_accountcode" for="x_accountcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->accountcode->caption() ?><?= $Page->accountcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->accountcode->cellAttributes() ?>>
<span id="el_peak_receipt_product_accountcode">
<input type="<?= $Page->accountcode->getInputTextType() ?>" name="x_accountcode" id="x_accountcode" data-table="peak_receipt_product" data-field="x_accountcode" value="<?= $Page->accountcode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->accountcode->getPlaceHolder()) ?>"<?= $Page->accountcode->editAttributes() ?> aria-describedby="x_accountcode_help">
<?= $Page->accountcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->accountcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->accountSubId->Visible) { // accountSubId ?>
    <div id="r_accountSubId"<?= $Page->accountSubId->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_accountSubId" for="x_accountSubId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->accountSubId->caption() ?><?= $Page->accountSubId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->accountSubId->cellAttributes() ?>>
<span id="el_peak_receipt_product_accountSubId">
<input type="<?= $Page->accountSubId->getInputTextType() ?>" name="x_accountSubId" id="x_accountSubId" data-table="peak_receipt_product" data-field="x_accountSubId" value="<?= $Page->accountSubId->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->accountSubId->getPlaceHolder()) ?>"<?= $Page->accountSubId->editAttributes() ?> aria-describedby="x_accountSubId_help">
<?= $Page->accountSubId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->accountSubId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->accountSubCode->Visible) { // accountSubCode ?>
    <div id="r_accountSubCode"<?= $Page->accountSubCode->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_accountSubCode" for="x_accountSubCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->accountSubCode->caption() ?><?= $Page->accountSubCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->accountSubCode->cellAttributes() ?>>
<span id="el_peak_receipt_product_accountSubCode">
<input type="<?= $Page->accountSubCode->getInputTextType() ?>" name="x_accountSubCode" id="x_accountSubCode" data-table="peak_receipt_product" data-field="x_accountSubCode" value="<?= $Page->accountSubCode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->accountSubCode->getPlaceHolder()) ?>"<?= $Page->accountSubCode->editAttributes() ?> aria-describedby="x_accountSubCode_help">
<?= $Page->accountSubCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->accountSubCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->quantity->Visible) { // quantity ?>
    <div id="r_quantity"<?= $Page->quantity->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_quantity" for="x_quantity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->quantity->caption() ?><?= $Page->quantity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->quantity->cellAttributes() ?>>
<span id="el_peak_receipt_product_quantity">
<input type="<?= $Page->quantity->getInputTextType() ?>" name="x_quantity" id="x_quantity" data-table="peak_receipt_product" data-field="x_quantity" value="<?= $Page->quantity->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->quantity->getPlaceHolder()) ?>"<?= $Page->quantity->editAttributes() ?> aria-describedby="x_quantity_help">
<?= $Page->quantity->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->quantity->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <div id="r_price"<?= $Page->price->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_price" for="x_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price->caption() ?><?= $Page->price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->price->cellAttributes() ?>>
<span id="el_peak_receipt_product_price">
<input type="<?= $Page->price->getInputTextType() ?>" name="x_price" id="x_price" data-table="peak_receipt_product" data-field="x_price" value="<?= $Page->price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->price->getPlaceHolder()) ?>"<?= $Page->price->editAttributes() ?> aria-describedby="x_price_help">
<?= $Page->price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->discount->Visible) { // discount ?>
    <div id="r_discount"<?= $Page->discount->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_discount" for="x_discount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->discount->caption() ?><?= $Page->discount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->discount->cellAttributes() ?>>
<span id="el_peak_receipt_product_discount">
<input type="<?= $Page->discount->getInputTextType() ?>" name="x_discount" id="x_discount" data-table="peak_receipt_product" data-field="x_discount" value="<?= $Page->discount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->discount->getPlaceHolder()) ?>"<?= $Page->discount->editAttributes() ?> aria-describedby="x_discount_help">
<?= $Page->discount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->discount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vatType->Visible) { // vatType ?>
    <div id="r_vatType"<?= $Page->vatType->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_vatType" for="x_vatType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vatType->caption() ?><?= $Page->vatType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vatType->cellAttributes() ?>>
<span id="el_peak_receipt_product_vatType">
<input type="<?= $Page->vatType->getInputTextType() ?>" name="x_vatType" id="x_vatType" data-table="peak_receipt_product" data-field="x_vatType" value="<?= $Page->vatType->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->vatType->getPlaceHolder()) ?>"<?= $Page->vatType->editAttributes() ?> aria-describedby="x_vatType_help">
<?= $Page->vatType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vatType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_peak_receipt_product_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<span id="el_peak_receipt_product_note">
<textarea data-table="peak_receipt_product" data-field="x_note" name="x_note" id="x_note" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->note->getPlaceHolder()) ?>"<?= $Page->note->editAttributes() ?> aria-describedby="x_note_help"><?= $Page->note->EditValue ?></textarea>
<?= $Page->note->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->note->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("peak_receipt_product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
