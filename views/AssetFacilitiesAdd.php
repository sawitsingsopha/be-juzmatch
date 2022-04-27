<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetFacilitiesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_facilities: currentTable } });
var currentForm, currentPageID;
var fasset_facilitiesadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_facilitiesadd = new ew.Form("fasset_facilitiesadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fasset_facilitiesadd;

    // Add fields
    var fields = currentTable.fields;
    fasset_facilitiesadd.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["master_facilities_group_id", [fields.master_facilities_group_id.visible && fields.master_facilities_group_id.required ? ew.Validators.required(fields.master_facilities_group_id.caption) : null], fields.master_facilities_group_id.isInvalid],
        ["master_facilities_id", [fields.master_facilities_id.visible && fields.master_facilities_id.required ? ew.Validators.required(fields.master_facilities_id.caption) : null], fields.master_facilities_id.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fasset_facilitiesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_facilitiesadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_facilitiesadd.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fasset_facilitiesadd.lists.master_facilities_group_id = <?= $Page->master_facilities_group_id->toClientList($Page) ?>;
    fasset_facilitiesadd.lists.master_facilities_id = <?= $Page->master_facilities_id->toClientList($Page) ?>;
    fasset_facilitiesadd.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    loadjs.done("fasset_facilitiesadd");
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
<form name="fasset_facilitiesadd" id="fasset_facilitiesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_facilities">
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
        <label id="elh_asset_facilities_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<?php if ($Page->asset_id->getSessionValue() != "") { ?>
<span id="el_asset_facilities_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_asset_id" name="x_asset_id" value="<?= HtmlEncode(FormatNumber($Page->asset_id->CurrentValue, $Page->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_asset_facilities_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesadd_x_asset_id"
        data-table="asset_facilities"
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
loadjs.ready("fasset_facilitiesadd", function() {
    var options = { name: "x_asset_id", selectId: "fasset_facilitiesadd_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesadd.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fasset_facilitiesadd" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fasset_facilitiesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
    <div id="r_master_facilities_group_id"<?= $Page->master_facilities_group_id->rowAttributes() ?>>
        <label id="elh_asset_facilities_master_facilities_group_id" for="x_master_facilities_group_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->master_facilities_group_id->caption() ?><?= $Page->master_facilities_group_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->master_facilities_group_id->cellAttributes() ?>>
<span id="el_asset_facilities_master_facilities_group_id">
<?php $Page->master_facilities_group_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_master_facilities_group_id"
        name="x_master_facilities_group_id"
        class="form-select ew-select<?= $Page->master_facilities_group_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesadd_x_master_facilities_group_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_group_id"
        data-value-separator="<?= $Page->master_facilities_group_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->master_facilities_group_id->getPlaceHolder()) ?>"
        <?= $Page->master_facilities_group_id->editAttributes() ?>>
        <?= $Page->master_facilities_group_id->selectOptionListHtml("x_master_facilities_group_id") ?>
    </select>
    <?= $Page->master_facilities_group_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->master_facilities_group_id->getErrorMessage() ?></div>
<?= $Page->master_facilities_group_id->Lookup->getParamTag($Page, "p_x_master_facilities_group_id") ?>
<script>
loadjs.ready("fasset_facilitiesadd", function() {
    var options = { name: "x_master_facilities_group_id", selectId: "fasset_facilitiesadd_x_master_facilities_group_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesadd.lists.master_facilities_group_id.lookupOptions.length) {
        options.data = { id: "x_master_facilities_group_id", form: "fasset_facilitiesadd" };
    } else {
        options.ajax = { id: "x_master_facilities_group_id", form: "fasset_facilitiesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_group_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->master_facilities_id->Visible) { // master_facilities_id ?>
    <div id="r_master_facilities_id"<?= $Page->master_facilities_id->rowAttributes() ?>>
        <label id="elh_asset_facilities_master_facilities_id" for="x_master_facilities_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->master_facilities_id->caption() ?><?= $Page->master_facilities_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->master_facilities_id->cellAttributes() ?>>
<span id="el_asset_facilities_master_facilities_id">
    <select
        id="x_master_facilities_id"
        name="x_master_facilities_id"
        class="form-select ew-select<?= $Page->master_facilities_id->isInvalidClass() ?>"
        data-select2-id="fasset_facilitiesadd_x_master_facilities_id"
        data-table="asset_facilities"
        data-field="x_master_facilities_id"
        data-value-separator="<?= $Page->master_facilities_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->master_facilities_id->getPlaceHolder()) ?>"
        <?= $Page->master_facilities_id->editAttributes() ?>>
        <?= $Page->master_facilities_id->selectOptionListHtml("x_master_facilities_id") ?>
    </select>
    <?= $Page->master_facilities_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->master_facilities_id->getErrorMessage() ?></div>
<?= $Page->master_facilities_id->Lookup->getParamTag($Page, "p_x_master_facilities_id") ?>
<script>
loadjs.ready("fasset_facilitiesadd", function() {
    var options = { name: "x_master_facilities_id", selectId: "fasset_facilitiesadd_x_master_facilities_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_facilitiesadd.lists.master_facilities_id.lookupOptions.length) {
        options.data = { id: "x_master_facilities_id", form: "fasset_facilitiesadd" };
    } else {
        options.ajax = { id: "x_master_facilities_id", form: "fasset_facilitiesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_facilities.fields.master_facilities_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_asset_facilities_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_asset_facilities_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="asset_facilities" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
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
    data-table="asset_facilities"
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
    ew.addEventHandlers("asset_facilities");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
