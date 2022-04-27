<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetProsDetailAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_pros_detail: currentTable } });
var currentForm, currentPageID;
var fasset_pros_detailadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_pros_detailadd = new ew.Form("fasset_pros_detailadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fasset_pros_detailadd;

    // Add fields
    var fields = currentTable.fields;
    fasset_pros_detailadd.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["detail", [fields.detail.visible && fields.detail.required ? ew.Validators.required(fields.detail.caption) : null], fields.detail.isInvalid],
        ["detail_en", [fields.detail_en.visible && fields.detail_en.required ? ew.Validators.required(fields.detail_en.caption) : null], fields.detail_en.isInvalid],
        ["group_type", [fields.group_type.visible && fields.group_type.required ? ew.Validators.required(fields.group_type.caption) : null], fields.group_type.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null], fields.latitude.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null], fields.longitude.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fasset_pros_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_pros_detailadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_pros_detailadd.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fasset_pros_detailadd.lists.group_type = <?= $Page->group_type->toClientList($Page) ?>;
    fasset_pros_detailadd.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    loadjs.done("fasset_pros_detailadd");
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
<form name="fasset_pros_detailadd" id="fasset_pros_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_pros_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<?php if ($Page->asset_id->getSessionValue() != "") { ?>
<span id="el_asset_pros_detail_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_asset_id" name="x_asset_id" value="<?= HtmlEncode(FormatNumber($Page->asset_id->CurrentValue, $Page->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_asset_pros_detail_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_pros_detailadd_x_asset_id"
        data-table="asset_pros_detail"
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
loadjs.ready("fasset_pros_detailadd", function() {
    var options = { name: "x_asset_id", selectId: "fasset_pros_detailadd_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_pros_detailadd.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fasset_pros_detailadd" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fasset_pros_detailadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_pros_detail.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <div id="r_detail"<?= $Page->detail->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_detail" for="x_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detail->caption() ?><?= $Page->detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detail->cellAttributes() ?>>
<span id="el_asset_pros_detail_detail">
<textarea data-table="asset_pros_detail" data-field="x_detail" name="x_detail" id="x_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detail->getPlaceHolder()) ?>"<?= $Page->detail->editAttributes() ?> aria-describedby="x_detail_help"><?= $Page->detail->EditValue ?></textarea>
<?= $Page->detail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detail_en->Visible) { // detail_en ?>
    <div id="r_detail_en"<?= $Page->detail_en->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_detail_en" for="x_detail_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detail_en->caption() ?><?= $Page->detail_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detail_en->cellAttributes() ?>>
<span id="el_asset_pros_detail_detail_en">
<textarea data-table="asset_pros_detail" data-field="x_detail_en" name="x_detail_en" id="x_detail_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detail_en->getPlaceHolder()) ?>"<?= $Page->detail_en->editAttributes() ?> aria-describedby="x_detail_en_help"><?= $Page->detail_en->EditValue ?></textarea>
<?= $Page->detail_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detail_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->group_type->Visible) { // group_type ?>
    <div id="r_group_type"<?= $Page->group_type->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_group_type" for="x_group_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->group_type->caption() ?><?= $Page->group_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->group_type->cellAttributes() ?>>
<span id="el_asset_pros_detail_group_type">
    <select
        id="x_group_type"
        name="x_group_type"
        class="form-select ew-select<?= $Page->group_type->isInvalidClass() ?>"
        data-select2-id="fasset_pros_detailadd_x_group_type"
        data-table="asset_pros_detail"
        data-field="x_group_type"
        data-value-separator="<?= $Page->group_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->group_type->getPlaceHolder()) ?>"
        <?= $Page->group_type->editAttributes() ?>>
        <?= $Page->group_type->selectOptionListHtml("x_group_type") ?>
    </select>
    <?= $Page->group_type->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->group_type->getErrorMessage() ?></div>
<script>
loadjs.ready("fasset_pros_detailadd", function() {
    var options = { name: "x_group_type", selectId: "fasset_pros_detailadd_x_group_type" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_pros_detailadd.lists.group_type.lookupOptions.length) {
        options.data = { id: "x_group_type", form: "fasset_pros_detailadd" };
    } else {
        options.ajax = { id: "x_group_type", form: "fasset_pros_detailadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_pros_detail.fields.group_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <div id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_latitude" for="x_latitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->latitude->caption() ?><?= $Page->latitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->latitude->cellAttributes() ?>>
<span id="el_asset_pros_detail_latitude">
<input type="<?= $Page->latitude->getInputTextType() ?>" name="x_latitude" id="x_latitude" data-table="asset_pros_detail" data-field="x_latitude" value="<?= $Page->latitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->latitude->getPlaceHolder()) ?>"<?= $Page->latitude->editAttributes() ?> aria-describedby="x_latitude_help">
<?= $Page->latitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->latitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <div id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_longitude" for="x_longitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->longitude->caption() ?><?= $Page->longitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->longitude->cellAttributes() ?>>
<span id="el_asset_pros_detail_longitude">
<input type="<?= $Page->longitude->getInputTextType() ?>" name="x_longitude" id="x_longitude" data-table="asset_pros_detail" data-field="x_longitude" value="<?= $Page->longitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->longitude->getPlaceHolder()) ?>"<?= $Page->longitude->editAttributes() ?> aria-describedby="x_longitude_help">
<?= $Page->longitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->longitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_asset_pros_detail_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_asset_pros_detail_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_pros_detail" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
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
    data-table="asset_pros_detail"
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
    ew.addEventHandlers("asset_pros_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
