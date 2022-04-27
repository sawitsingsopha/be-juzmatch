<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleCategoryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article_category: currentTable } });
var currentForm, currentPageID;
var farticle_categoryadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticle_categoryadd = new ew.Form("farticle_categoryadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = farticle_categoryadd;

    // Add fields
    var fields = currentTable.fields;
    farticle_categoryadd.addFields([
        ["article_title", [fields.article_title.visible && fields.article_title.required ? ew.Validators.required(fields.article_title.caption) : null], fields.article_title.isInvalid],
        ["article_title_en", [fields.article_title_en.visible && fields.article_title_en.required ? ew.Validators.required(fields.article_title_en.caption) : null], fields.article_title_en.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["active_status", [fields.active_status.visible && fields.active_status.required ? ew.Validators.required(fields.active_status.caption) : null], fields.active_status.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    farticle_categoryadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farticle_categoryadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    farticle_categoryadd.lists.active_status = <?= $Page->active_status->toClientList($Page) ?>;
    loadjs.done("farticle_categoryadd");
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
<form name="farticle_categoryadd" id="farticle_categoryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article_category">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->article_title->Visible) { // article_title ?>
    <div id="r_article_title"<?= $Page->article_title->rowAttributes() ?>>
        <label id="elh_article_category_article_title" for="x_article_title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->article_title->caption() ?><?= $Page->article_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->article_title->cellAttributes() ?>>
<span id="el_article_category_article_title">
<input type="<?= $Page->article_title->getInputTextType() ?>" name="x_article_title" id="x_article_title" data-table="article_category" data-field="x_article_title" value="<?= $Page->article_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->article_title->getPlaceHolder()) ?>"<?= $Page->article_title->editAttributes() ?> aria-describedby="x_article_title_help">
<?= $Page->article_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->article_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->article_title_en->Visible) { // article_title_en ?>
    <div id="r_article_title_en"<?= $Page->article_title_en->rowAttributes() ?>>
        <label id="elh_article_category_article_title_en" for="x_article_title_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->article_title_en->caption() ?><?= $Page->article_title_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->article_title_en->cellAttributes() ?>>
<span id="el_article_category_article_title_en">
<input type="<?= $Page->article_title_en->getInputTextType() ?>" name="x_article_title_en" id="x_article_title_en" data-table="article_category" data-field="x_article_title_en" value="<?= $Page->article_title_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->article_title_en->getPlaceHolder()) ?>"<?= $Page->article_title_en->editAttributes() ?> aria-describedby="x_article_title_en_help">
<?= $Page->article_title_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->article_title_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <div id="r_order_by"<?= $Page->order_by->rowAttributes() ?>>
        <label id="elh_article_category_order_by" for="x_order_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_by->caption() ?><?= $Page->order_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->order_by->cellAttributes() ?>>
<span id="el_article_category_order_by">
<input type="<?= $Page->order_by->getInputTextType() ?>" name="x_order_by" id="x_order_by" data-table="article_category" data-field="x_order_by" value="<?= $Page->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->order_by->getPlaceHolder()) ?>"<?= $Page->order_by->editAttributes() ?> aria-describedby="x_order_by_help">
<?= $Page->order_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->order_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <div id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <label id="elh_article_category_active_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active_status->caption() ?><?= $Page->active_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->active_status->cellAttributes() ?>>
<span id="el_article_category_active_status">
<template id="tp_x_active_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="article_category" data-field="x_active_status" name="x_active_status" id="x_active_status"<?= $Page->active_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_active_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_active_status"
    name="x_active_status"
    value="<?= HtmlEncode($Page->active_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_active_status"
    data-bs-target="dsl_x_active_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->active_status->isInvalidClass() ?>"
    data-table="article_category"
    data-field="x_active_status"
    data-value-separator="<?= $Page->active_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->active_status->editAttributes() ?>></selection-list>
<?= $Page->active_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active_status->getErrorMessage() ?></div>
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
    ew.addEventHandlers("article_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
