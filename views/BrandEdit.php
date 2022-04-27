<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BrandEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { brand: currentTable } });
var currentForm, currentPageID;
var fbrandedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbrandedit = new ew.Form("fbrandedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbrandedit;

    // Add fields
    var fields = currentTable.fields;
    fbrandedit.addFields([
        ["brand_name", [fields.brand_name.visible && fields.brand_name.required ? ew.Validators.required(fields.brand_name.caption) : null], fields.brand_name.isInvalid],
        ["brand_name_en", [fields.brand_name_en.visible && fields.brand_name_en.required ? ew.Validators.required(fields.brand_name_en.caption) : null], fields.brand_name_en.isInvalid],
        ["company_name", [fields.company_name.visible && fields.company_name.required ? ew.Validators.required(fields.company_name.caption) : null], fields.company_name.isInvalid],
        ["company_name_en", [fields.company_name_en.visible && fields.company_name_en.required ? ew.Validators.required(fields.company_name_en.caption) : null], fields.company_name_en.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fbrandedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbrandedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbrandedit.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    loadjs.done("fbrandedit");
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
<form name="fbrandedit" id="fbrandedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="brand">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->brand_name->Visible) { // brand_name ?>
    <div id="r_brand_name"<?= $Page->brand_name->rowAttributes() ?>>
        <label id="elh_brand_brand_name" for="x_brand_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->brand_name->caption() ?><?= $Page->brand_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->brand_name->cellAttributes() ?>>
<span id="el_brand_brand_name">
<input type="<?= $Page->brand_name->getInputTextType() ?>" name="x_brand_name" id="x_brand_name" data-table="brand" data-field="x_brand_name" value="<?= $Page->brand_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->brand_name->getPlaceHolder()) ?>"<?= $Page->brand_name->editAttributes() ?> aria-describedby="x_brand_name_help">
<?= $Page->brand_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->brand_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->brand_name_en->Visible) { // brand_name_en ?>
    <div id="r_brand_name_en"<?= $Page->brand_name_en->rowAttributes() ?>>
        <label id="elh_brand_brand_name_en" for="x_brand_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->brand_name_en->caption() ?><?= $Page->brand_name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->brand_name_en->cellAttributes() ?>>
<span id="el_brand_brand_name_en">
<input type="<?= $Page->brand_name_en->getInputTextType() ?>" name="x_brand_name_en" id="x_brand_name_en" data-table="brand" data-field="x_brand_name_en" value="<?= $Page->brand_name_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->brand_name_en->getPlaceHolder()) ?>"<?= $Page->brand_name_en->editAttributes() ?> aria-describedby="x_brand_name_en_help">
<?= $Page->brand_name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->brand_name_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->company_name->Visible) { // company_name ?>
    <div id="r_company_name"<?= $Page->company_name->rowAttributes() ?>>
        <label id="elh_brand_company_name" for="x_company_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_name->caption() ?><?= $Page->company_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_name->cellAttributes() ?>>
<span id="el_brand_company_name">
<input type="<?= $Page->company_name->getInputTextType() ?>" name="x_company_name" id="x_company_name" data-table="brand" data-field="x_company_name" value="<?= $Page->company_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->company_name->getPlaceHolder()) ?>"<?= $Page->company_name->editAttributes() ?> aria-describedby="x_company_name_help">
<?= $Page->company_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->company_name_en->Visible) { // company_name_en ?>
    <div id="r_company_name_en"<?= $Page->company_name_en->rowAttributes() ?>>
        <label id="elh_brand_company_name_en" for="x_company_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->company_name_en->caption() ?><?= $Page->company_name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->company_name_en->cellAttributes() ?>>
<span id="el_brand_company_name_en">
<input type="<?= $Page->company_name_en->getInputTextType() ?>" name="x_company_name_en" id="x_company_name_en" data-table="brand" data-field="x_company_name_en" value="<?= $Page->company_name_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->company_name_en->getPlaceHolder()) ?>"<?= $Page->company_name_en->editAttributes() ?> aria-describedby="x_company_name_en_help">
<?= $Page->company_name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->company_name_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <div id="r_order_by"<?= $Page->order_by->rowAttributes() ?>>
        <label id="elh_brand_order_by" for="x_order_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_by->caption() ?><?= $Page->order_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->order_by->cellAttributes() ?>>
<span id="el_brand_order_by">
<input type="<?= $Page->order_by->getInputTextType() ?>" name="x_order_by" id="x_order_by" data-table="brand" data-field="x_order_by" value="<?= $Page->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->order_by->getPlaceHolder()) ?>"<?= $Page->order_by->editAttributes() ?> aria-describedby="x_order_by_help">
<?= $Page->order_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->order_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_brand_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_brand_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="brand" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x_isactive"
    name="x_isactive"
    value="<?= HtmlEncode($Page->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_isactive"
    data-bs-target="dsl_x_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Page->isactive->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_isactive"
    data-value-separator="<?= $Page->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Page->isactive->editAttributes() ?>></selection-list>
<?= $Page->isactive->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isactive->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="brand" data-field="x_brand_id" data-hidden="1" name="x_brand_id" id="x_brand_id" value="<?= HtmlEncode($Page->brand_id->CurrentValue) ?>">
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
    ew.addEventHandlers("brand");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
