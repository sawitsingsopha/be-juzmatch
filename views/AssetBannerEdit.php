<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetBannerEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_banner: currentTable } });
var currentForm, currentPageID;
var fasset_banneredit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_banneredit = new ew.Form("fasset_banneredit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fasset_banneredit;

    // Add fields
    var fields = currentTable.fields;
    fasset_banneredit.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
        ["order_by", [fields.order_by.visible && fields.order_by.required ? ew.Validators.required(fields.order_by.caption) : null, ew.Validators.integer], fields.order_by.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fasset_banneredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_banneredit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_banneredit.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fasset_banneredit.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    loadjs.done("fasset_banneredit");
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
<form name="fasset_banneredit" id="fasset_banneredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_banner">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_asset_banner_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<?php if ($Page->asset_id->getSessionValue() != "") { ?>
<span id="el_asset_banner_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_asset_id" name="x_asset_id" value="<?= HtmlEncode(FormatNumber($Page->asset_id->CurrentValue, $Page->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_asset_banner_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_banneredit_x_asset_id"
        data-table="asset_banner"
        data-field="x_asset_id"
        data-value-separator="<?= $Page->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"
        <?= $Page->asset_id->editAttributes() ?>>
        <?= $Page->asset_id->selectOptionListHtml("x_asset_id") ?>
    </select>
    <?= $Page->asset_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage() ?></div>
<?= $Page->asset_id->Lookup->getParamTag($Page, "p_x_asset_id") ?>
<script>
loadjs.ready("fasset_banneredit", function() {
    var options = { name: "x_asset_id", selectId: "fasset_banneredit_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_banneredit.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fasset_banneredit" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fasset_banneredit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_banner.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_asset_banner_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_asset_banner_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->image->title() ?>" data-table="asset_banner" data-field="x_image" name="x_image" id="x_image" lang="<?= CurrentLanguageID() ?>"<?= $Page->image->editAttributes() ?> aria-describedby="x_image_help"<?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>>
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
        <label id="elh_asset_banner_order_by" for="x_order_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->order_by->caption() ?><?= $Page->order_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->order_by->cellAttributes() ?>>
<span id="el_asset_banner_order_by">
<input type="<?= $Page->order_by->getInputTextType() ?>" name="x_order_by" id="x_order_by" data-table="asset_banner" data-field="x_order_by" value="<?= $Page->order_by->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->order_by->getPlaceHolder()) ?>"<?= $Page->order_by->editAttributes() ?> aria-describedby="x_order_by_help">
<?= $Page->order_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->order_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_asset_banner_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_asset_banner_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_banner" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
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
    data-table="asset_banner"
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
    <input type="hidden" data-table="asset_banner" data-field="x_asset_banner_id" data-hidden="1" name="x_asset_banner_id" id="x_asset_banner_id" value="<?= HtmlEncode($Page->asset_banner_id->CurrentValue) ?>">
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
    ew.addEventHandlers("asset_banner");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
