<?php

namespace PHPMaker2022\juzmatch;

// Page object
$CategoryEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { category: currentTable } });
var currentForm, currentPageID;
var fcategoryedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcategoryedit = new ew.Form("fcategoryedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fcategoryedit;

    // Add fields
    var fields = currentTable.fields;
    fcategoryedit.addFields([
        ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null], fields.category_id.isInvalid],
        ["category_name", [fields.category_name.visible && fields.category_name.required ? ew.Validators.required(fields.category_name.caption) : null], fields.category_name.isInvalid],
        ["category_name_en", [fields.category_name_en.visible && fields.category_name_en.required ? ew.Validators.required(fields.category_name_en.caption) : null], fields.category_name_en.isInvalid],
        ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fcategoryedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcategoryedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fcategoryedit.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    loadjs.done("fcategoryedit");
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
<form name="fcategoryedit" id="fcategoryedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="category">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->category_id->Visible) { // category_id ?>
    <div id="r_category_id"<?= $Page->category_id->rowAttributes() ?>>
        <label id="elh_category_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_id->caption() ?><?= $Page->category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_id->cellAttributes() ?>>
<span id="el_category_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->category_id->getDisplayValue($Page->category_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="category" data-field="x_category_id" data-hidden="1" name="x_category_id" id="x_category_id" value="<?= HtmlEncode($Page->category_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->category_name->Visible) { // category_name ?>
    <div id="r_category_name"<?= $Page->category_name->rowAttributes() ?>>
        <label id="elh_category_category_name" for="x_category_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_name->caption() ?><?= $Page->category_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_name->cellAttributes() ?>>
<span id="el_category_category_name">
<input type="<?= $Page->category_name->getInputTextType() ?>" name="x_category_name" id="x_category_name" data-table="category" data-field="x_category_name" value="<?= $Page->category_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->category_name->getPlaceHolder()) ?>"<?= $Page->category_name->editAttributes() ?> aria-describedby="x_category_name_help">
<?= $Page->category_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->category_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->category_name_en->Visible) { // category_name_en ?>
    <div id="r_category_name_en"<?= $Page->category_name_en->rowAttributes() ?>>
        <label id="elh_category_category_name_en" for="x_category_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_name_en->caption() ?><?= $Page->category_name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_name_en->cellAttributes() ?>>
<span id="el_category_category_name_en">
<input type="<?= $Page->category_name_en->getInputTextType() ?>" name="x_category_name_en" id="x_category_name_en" data-table="category" data-field="x_category_name_en" value="<?= $Page->category_name_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->category_name_en->getPlaceHolder()) ?>"<?= $Page->category_name_en->editAttributes() ?> aria-describedby="x_category_name_en_help">
<?= $Page->category_name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->category_name_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_category_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_category_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->image->title() ?>" data-table="category" data-field="x_image" name="x_image" id="x_image" lang="<?= CurrentLanguageID() ?>"<?= $Page->image->editAttributes() ?> aria-describedby="x_image_help"<?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->image->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?= $Page->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="<?= (Post("fa_x_image") == "0") ? "0" : "1" ?>">
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
        <label id="elh_category_order_by" for="x_order_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_by->caption() ?><?= $Page->order_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->order_by->cellAttributes() ?>>
<span id="el_category_order_by">
<input type="<?= $Page->order_by->getInputTextType() ?>" name="x_order_by" id="x_order_by" data-table="category" data-field="x_order_by" value="<?= $Page->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->order_by->getPlaceHolder()) ?>"<?= $Page->order_by->editAttributes() ?> aria-describedby="x_order_by_help">
<?= $Page->order_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->order_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_category_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_category_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="category" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
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
    data-table="category"
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
<?php
    if (in_array("asset_category", explode(",", $Page->getCurrentDetailTable())) && $asset_category->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("asset_category", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AssetCategoryGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
