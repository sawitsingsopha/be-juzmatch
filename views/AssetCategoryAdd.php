<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetCategoryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_category: currentTable } });
var currentForm, currentPageID;
var fasset_categoryadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_categoryadd = new ew.Form("fasset_categoryadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fasset_categoryadd;

    // Add fields
    var fields = currentTable.fields;
    fasset_categoryadd.addFields([
        ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null], fields.category_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid]
    ]);

    // Form_CustomValidate
    fasset_categoryadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_categoryadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_categoryadd.lists.category_id = <?= $Page->category_id->toClientList($Page) ?>;
    fasset_categoryadd.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    loadjs.done("fasset_categoryadd");
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
<form name="fasset_categoryadd" id="fasset_categoryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_category">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "category") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="category">
<input type="hidden" name="fk_category_id" value="<?= HtmlEncode($Page->category_id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->category_id->Visible) { // category_id ?>
    <div id="r_category_id"<?= $Page->category_id->rowAttributes() ?>>
        <label id="elh_asset_category_category_id" for="x_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_id->caption() ?><?= $Page->category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_id->cellAttributes() ?>>
<?php if ($Page->category_id->getSessionValue() != "") { ?>
<span id="el_asset_category_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->category_id->getDisplayValue($Page->category_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_category_id" name="x_category_id" value="<?= HtmlEncode(FormatNumber($Page->category_id->CurrentValue, $Page->category_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_asset_category_category_id">
    <select
        id="x_category_id"
        name="x_category_id"
        class="form-select ew-select<?= $Page->category_id->isInvalidClass() ?>"
        data-select2-id="fasset_categoryadd_x_category_id"
        data-table="asset_category"
        data-field="x_category_id"
        data-value-separator="<?= $Page->category_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->category_id->getPlaceHolder()) ?>"
        <?= $Page->category_id->editAttributes() ?>>
        <?= $Page->category_id->selectOptionListHtml("x_category_id") ?>
    </select>
    <?= $Page->category_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->category_id->getErrorMessage() ?></div>
<?= $Page->category_id->Lookup->getParamTag($Page, "p_x_category_id") ?>
<script>
loadjs.ready("fasset_categoryadd", function() {
    var options = { name: "x_category_id", selectId: "fasset_categoryadd_x_category_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_categoryadd.lists.category_id.lookupOptions.length) {
        options.data = { id: "x_category_id", form: "fasset_categoryadd" };
    } else {
        options.ajax = { id: "x_category_id", form: "fasset_categoryadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_category.fields.category_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_asset_category_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<?php if ($Page->asset_id->getSessionValue() != "") { ?>
<span id="el_asset_category_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_asset_id" name="x_asset_id" value="<?= HtmlEncode(FormatNumber($Page->asset_id->CurrentValue, $Page->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_asset_category_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_categoryadd_x_asset_id"
        data-table="asset_category"
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
loadjs.ready("fasset_categoryadd", function() {
    var options = { name: "x_asset_id", selectId: "fasset_categoryadd_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_categoryadd.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fasset_categoryadd" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fasset_categoryadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_category.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
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
    ew.addEventHandlers("asset_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
