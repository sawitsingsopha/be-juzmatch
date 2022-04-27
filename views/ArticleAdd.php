<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article: currentTable } });
var currentForm, currentPageID;
var farticleadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticleadd = new ew.Form("farticleadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = farticleadd;

    // Add fields
    var fields = currentTable.fields;
    farticleadd.addFields([
        ["article_category_id", [fields.article_category_id.visible && fields.article_category_id.required ? ew.Validators.required(fields.article_category_id.caption) : null], fields.article_category_id.isInvalid],
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["title_en", [fields.title_en.visible && fields.title_en.required ? ew.Validators.required(fields.title_en.caption) : null], fields.title_en.isInvalid],
        ["detail", [fields.detail.visible && fields.detail.required ? ew.Validators.required(fields.detail.caption) : null], fields.detail.isInvalid],
        ["detail_en", [fields.detail_en.visible && fields.detail_en.required ? ew.Validators.required(fields.detail_en.caption) : null], fields.detail_en.isInvalid],
        ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["tag", [fields.tag.visible && fields.tag.required ? ew.Validators.required(fields.tag.caption) : null], fields.tag.isInvalid],
        ["highlight", [fields.highlight.visible && fields.highlight.required ? ew.Validators.required(fields.highlight.caption) : null], fields.highlight.isInvalid],
        ["active_status", [fields.active_status.visible && fields.active_status.required ? ew.Validators.required(fields.active_status.caption) : null], fields.active_status.isInvalid],
        ["meta_title", [fields.meta_title.visible && fields.meta_title.required ? ew.Validators.required(fields.meta_title.caption) : null], fields.meta_title.isInvalid],
        ["meta_title_en", [fields.meta_title_en.visible && fields.meta_title_en.required ? ew.Validators.required(fields.meta_title_en.caption) : null], fields.meta_title_en.isInvalid],
        ["meta_description", [fields.meta_description.visible && fields.meta_description.required ? ew.Validators.required(fields.meta_description.caption) : null], fields.meta_description.isInvalid],
        ["meta_description_en", [fields.meta_description_en.visible && fields.meta_description_en.required ? ew.Validators.required(fields.meta_description_en.caption) : null], fields.meta_description_en.isInvalid],
        ["meta_keyword", [fields.meta_keyword.visible && fields.meta_keyword.required ? ew.Validators.required(fields.meta_keyword.caption) : null], fields.meta_keyword.isInvalid],
        ["meta_keyword_en", [fields.meta_keyword_en.visible && fields.meta_keyword_en.required ? ew.Validators.required(fields.meta_keyword_en.caption) : null], fields.meta_keyword_en.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    farticleadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farticleadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    farticleadd.lists.article_category_id = <?= $Page->article_category_id->toClientList($Page) ?>;
    farticleadd.lists.highlight = <?= $Page->highlight->toClientList($Page) ?>;
    farticleadd.lists.active_status = <?= $Page->active_status->toClientList($Page) ?>;
    loadjs.done("farticleadd");
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
<form name="farticleadd" id="farticleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->article_category_id->Visible) { // article_category_id ?>
    <div id="r_article_category_id"<?= $Page->article_category_id->rowAttributes() ?>>
        <label id="elh_article_article_category_id" for="x_article_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->article_category_id->caption() ?><?= $Page->article_category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->article_category_id->cellAttributes() ?>>
<span id="el_article_article_category_id">
    <select
        id="x_article_category_id"
        name="x_article_category_id"
        class="form-select ew-select<?= $Page->article_category_id->isInvalidClass() ?>"
        data-select2-id="farticleadd_x_article_category_id"
        data-table="article"
        data-field="x_article_category_id"
        data-value-separator="<?= $Page->article_category_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->article_category_id->getPlaceHolder()) ?>"
        <?= $Page->article_category_id->editAttributes() ?>>
        <?= $Page->article_category_id->selectOptionListHtml("x_article_category_id") ?>
    </select>
    <?= $Page->article_category_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->article_category_id->getErrorMessage() ?></div>
<?= $Page->article_category_id->Lookup->getParamTag($Page, "p_x_article_category_id") ?>
<script>
loadjs.ready("farticleadd", function() {
    var options = { name: "x_article_category_id", selectId: "farticleadd_x_article_category_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (farticleadd.lists.article_category_id.lookupOptions.length) {
        options.data = { id: "x_article_category_id", form: "farticleadd" };
    } else {
        options.ajax = { id: "x_article_category_id", form: "farticleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.article.fields.article_category_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_article__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span id="el_article__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="article" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <div id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <label id="elh_article_title_en" for="x_title_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title_en->caption() ?><?= $Page->title_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->title_en->cellAttributes() ?>>
<span id="el_article_title_en">
<input type="<?= $Page->title_en->getInputTextType() ?>" name="x_title_en" id="x_title_en" data-table="article" data-field="x_title_en" value="<?= $Page->title_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title_en->getPlaceHolder()) ?>"<?= $Page->title_en->editAttributes() ?> aria-describedby="x_title_en_help">
<?= $Page->title_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <div id="r_detail"<?= $Page->detail->rowAttributes() ?>>
        <label id="elh_article_detail" for="x_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detail->caption() ?><?= $Page->detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detail->cellAttributes() ?>>
<span id="el_article_detail">
<textarea data-table="article" data-field="x_detail" name="x_detail" id="x_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detail->getPlaceHolder()) ?>"<?= $Page->detail->editAttributes() ?> aria-describedby="x_detail_help"><?= $Page->detail->EditValue ?></textarea>
<?= $Page->detail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detail_en->Visible) { // detail_en ?>
    <div id="r_detail_en"<?= $Page->detail_en->rowAttributes() ?>>
        <label id="elh_article_detail_en" for="x_detail_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detail_en->caption() ?><?= $Page->detail_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detail_en->cellAttributes() ?>>
<span id="el_article_detail_en">
<textarea data-table="article" data-field="x_detail_en" name="x_detail_en" id="x_detail_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detail_en->getPlaceHolder()) ?>"<?= $Page->detail_en->editAttributes() ?> aria-describedby="x_detail_en_help"><?= $Page->detail_en->EditValue ?></textarea>
<?= $Page->detail_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detail_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_article_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_article_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->image->title() ?>" data-table="article" data-field="x_image" name="x_image" id="x_image" lang="<?= CurrentLanguageID() ?>"<?= $Page->image->editAttributes() ?> aria-describedby="x_image_help"<?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->image->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?= $Page->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="0">
<input type="hidden" name="fs_x_image" id= "fs_x_image" value="255">
<input type="hidden" name="fx_x_image" id= "fx_x_image" value="<?= $Page->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image" id= "fm_x_image" value="<?= $Page->image->UploadMaxFileSize ?>">
<table id="ft_x_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <div id="r_order_by"<?= $Page->order_by->rowAttributes() ?>>
        <label id="elh_article_order_by" for="x_order_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_by->caption() ?><?= $Page->order_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->order_by->cellAttributes() ?>>
<span id="el_article_order_by">
<input type="<?= $Page->order_by->getInputTextType() ?>" name="x_order_by" id="x_order_by" data-table="article" data-field="x_order_by" value="<?= $Page->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->order_by->getPlaceHolder()) ?>"<?= $Page->order_by->editAttributes() ?> aria-describedby="x_order_by_help">
<?= $Page->order_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->order_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
    <div id="r_tag"<?= $Page->tag->rowAttributes() ?>>
        <label id="elh_article_tag" for="x_tag" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tag->caption() ?><?= $Page->tag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tag->cellAttributes() ?>>
<span id="el_article_tag">
<input type="<?= $Page->tag->getInputTextType() ?>" name="x_tag" id="x_tag" data-table="article" data-field="x_tag" value="<?= $Page->tag->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tag->getPlaceHolder()) ?>"<?= $Page->tag->editAttributes() ?> aria-describedby="x_tag_help">
<?= $Page->tag->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tag->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->highlight->Visible) { // highlight ?>
    <div id="r_highlight"<?= $Page->highlight->rowAttributes() ?>>
        <label id="elh_article_highlight" class="<?= $Page->LeftColumnClass ?>"><?= $Page->highlight->caption() ?><?= $Page->highlight->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->highlight->cellAttributes() ?>>
<span id="el_article_highlight">
<template id="tp_x_highlight">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="article" data-field="x_highlight" name="x_highlight" id="x_highlight"<?= $Page->highlight->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_highlight" class="ew-item-list"></div>
<selection-list hidden
    id="x_highlight"
    name="x_highlight"
    value="<?= HtmlEncode($Page->highlight->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_highlight"
    data-bs-target="dsl_x_highlight"
    data-repeatcolumn="5"
    class="form-control<?= $Page->highlight->isInvalidClass() ?>"
    data-table="article"
    data-field="x_highlight"
    data-value-separator="<?= $Page->highlight->displayValueSeparatorAttribute() ?>"
    <?= $Page->highlight->editAttributes() ?>></selection-list>
<?= $Page->highlight->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->highlight->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <div id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <label id="elh_article_active_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active_status->caption() ?><?= $Page->active_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->active_status->cellAttributes() ?>>
<span id="el_article_active_status">
<template id="tp_x_active_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="article" data-field="x_active_status" name="x_active_status" id="x_active_status"<?= $Page->active_status->editAttributes() ?>>
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
    data-table="article"
    data-field="x_active_status"
    data-value-separator="<?= $Page->active_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->active_status->editAttributes() ?>></selection-list>
<?= $Page->active_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta_title->Visible) { // meta_title ?>
    <div id="r_meta_title"<?= $Page->meta_title->rowAttributes() ?>>
        <label id="elh_article_meta_title" for="x_meta_title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta_title->caption() ?><?= $Page->meta_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta_title->cellAttributes() ?>>
<span id="el_article_meta_title">
<input type="<?= $Page->meta_title->getInputTextType() ?>" name="x_meta_title" id="x_meta_title" data-table="article" data-field="x_meta_title" value="<?= $Page->meta_title->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->meta_title->getPlaceHolder()) ?>"<?= $Page->meta_title->editAttributes() ?> aria-describedby="x_meta_title_help">
<?= $Page->meta_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta_title_en->Visible) { // meta_title_en ?>
    <div id="r_meta_title_en"<?= $Page->meta_title_en->rowAttributes() ?>>
        <label id="elh_article_meta_title_en" for="x_meta_title_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta_title_en->caption() ?><?= $Page->meta_title_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta_title_en->cellAttributes() ?>>
<span id="el_article_meta_title_en">
<input type="<?= $Page->meta_title_en->getInputTextType() ?>" name="x_meta_title_en" id="x_meta_title_en" data-table="article" data-field="x_meta_title_en" value="<?= $Page->meta_title_en->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->meta_title_en->getPlaceHolder()) ?>"<?= $Page->meta_title_en->editAttributes() ?> aria-describedby="x_meta_title_en_help">
<?= $Page->meta_title_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta_title_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta_description->Visible) { // meta_description ?>
    <div id="r_meta_description"<?= $Page->meta_description->rowAttributes() ?>>
        <label id="elh_article_meta_description" for="x_meta_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta_description->caption() ?><?= $Page->meta_description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta_description->cellAttributes() ?>>
<span id="el_article_meta_description">
<input type="<?= $Page->meta_description->getInputTextType() ?>" name="x_meta_description" id="x_meta_description" data-table="article" data-field="x_meta_description" value="<?= $Page->meta_description->EditValue ?>" size="30" maxlength="160" placeholder="<?= HtmlEncode($Page->meta_description->getPlaceHolder()) ?>"<?= $Page->meta_description->editAttributes() ?> aria-describedby="x_meta_description_help">
<?= $Page->meta_description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta_description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta_description_en->Visible) { // meta_description_en ?>
    <div id="r_meta_description_en"<?= $Page->meta_description_en->rowAttributes() ?>>
        <label id="elh_article_meta_description_en" for="x_meta_description_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta_description_en->caption() ?><?= $Page->meta_description_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta_description_en->cellAttributes() ?>>
<span id="el_article_meta_description_en">
<input type="<?= $Page->meta_description_en->getInputTextType() ?>" name="x_meta_description_en" id="x_meta_description_en" data-table="article" data-field="x_meta_description_en" value="<?= $Page->meta_description_en->EditValue ?>" size="30" maxlength="160" placeholder="<?= HtmlEncode($Page->meta_description_en->getPlaceHolder()) ?>"<?= $Page->meta_description_en->editAttributes() ?> aria-describedby="x_meta_description_en_help">
<?= $Page->meta_description_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta_description_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta_keyword->Visible) { // meta_keyword ?>
    <div id="r_meta_keyword"<?= $Page->meta_keyword->rowAttributes() ?>>
        <label id="elh_article_meta_keyword" for="x_meta_keyword" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta_keyword->caption() ?><?= $Page->meta_keyword->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta_keyword->cellAttributes() ?>>
<span id="el_article_meta_keyword">
<textarea data-table="article" data-field="x_meta_keyword" name="x_meta_keyword" id="x_meta_keyword" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->meta_keyword->getPlaceHolder()) ?>"<?= $Page->meta_keyword->editAttributes() ?> aria-describedby="x_meta_keyword_help"><?= $Page->meta_keyword->EditValue ?></textarea>
<?= $Page->meta_keyword->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta_keyword->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta_keyword_en->Visible) { // meta_keyword_en ?>
    <div id="r_meta_keyword_en"<?= $Page->meta_keyword_en->rowAttributes() ?>>
        <label id="elh_article_meta_keyword_en" for="x_meta_keyword_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta_keyword_en->caption() ?><?= $Page->meta_keyword_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta_keyword_en->cellAttributes() ?>>
<span id="el_article_meta_keyword_en">
<textarea data-table="article" data-field="x_meta_keyword_en" name="x_meta_keyword_en" id="x_meta_keyword_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->meta_keyword_en->getPlaceHolder()) ?>"<?= $Page->meta_keyword_en->editAttributes() ?> aria-describedby="x_meta_keyword_en_help"><?= $Page->meta_keyword_en->EditValue ?></textarea>
<?= $Page->meta_keyword_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta_keyword_en->getErrorMessage() ?></div>
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
    ew.addEventHandlers("article");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
