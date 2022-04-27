<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerSaveBuyAssetAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_save_buy_asset: currentTable } });
var currentForm, currentPageID;
var fbuyer_save_buy_assetadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_save_buy_assetadd = new ew.Form("fbuyer_save_buy_assetadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fbuyer_save_buy_assetadd;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_save_buy_assetadd.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asser_id", [fields.asser_id.visible && fields.asser_id.required ? ew.Validators.required(fields.asser_id.caption) : null], fields.asser_id.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid]
    ]);

    // Form_CustomValidate
    fbuyer_save_buy_assetadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_save_buy_assetadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_save_buy_assetadd.lists.member_id = <?= $Page->member_id->toClientList($Page) ?>;
    fbuyer_save_buy_assetadd.lists.asser_id = <?= $Page->asser_id->toClientList($Page) ?>;
    loadjs.done("fbuyer_save_buy_assetadd");
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
<form name="fbuyer_save_buy_assetadd" id="fbuyer_save_buy_assetadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_save_buy_asset">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_buyer_save_buy_asset_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_save_buy_asset_member_id">
    <select
        id="x_member_id"
        name="x_member_id"
        class="form-select ew-select<?= $Page->member_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_save_buy_assetadd_x_member_id"
        data-table="buyer_save_buy_asset"
        data-field="x_member_id"
        data-value-separator="<?= $Page->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"
        <?= $Page->member_id->editAttributes() ?>>
        <?= $Page->member_id->selectOptionListHtml("x_member_id") ?>
    </select>
    <?= $Page->member_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
<?= $Page->member_id->Lookup->getParamTag($Page, "p_x_member_id") ?>
<script>
loadjs.ready("fbuyer_save_buy_assetadd", function() {
    var options = { name: "x_member_id", selectId: "fbuyer_save_buy_assetadd_x_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_save_buy_assetadd.lists.member_id.lookupOptions.length) {
        options.data = { id: "x_member_id", form: "fbuyer_save_buy_assetadd" };
    } else {
        options.ajax = { id: "x_member_id", form: "fbuyer_save_buy_assetadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_save_buy_asset.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asser_id->Visible) { // asser_id ?>
    <div id="r_asser_id"<?= $Page->asser_id->rowAttributes() ?>>
        <label id="elh_buyer_save_buy_asset_asser_id" for="x_asser_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asser_id->caption() ?><?= $Page->asser_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asser_id->cellAttributes() ?>>
<span id="el_buyer_save_buy_asset_asser_id">
    <select
        id="x_asser_id"
        name="x_asser_id"
        class="form-select ew-select<?= $Page->asser_id->isInvalidClass() ?>"
        data-select2-id="fbuyer_save_buy_assetadd_x_asser_id"
        data-table="buyer_save_buy_asset"
        data-field="x_asser_id"
        data-value-separator="<?= $Page->asser_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asser_id->getPlaceHolder()) ?>"
        <?= $Page->asser_id->editAttributes() ?>>
        <?= $Page->asser_id->selectOptionListHtml("x_asser_id") ?>
    </select>
    <?= $Page->asser_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->asser_id->getErrorMessage() ?></div>
<?= $Page->asser_id->Lookup->getParamTag($Page, "p_x_asser_id") ?>
<script>
loadjs.ready("fbuyer_save_buy_assetadd", function() {
    var options = { name: "x_asser_id", selectId: "fbuyer_save_buy_assetadd_x_asser_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbuyer_save_buy_assetadd.lists.asser_id.lookupOptions.length) {
        options.data = { id: "x_asser_id", form: "fbuyer_save_buy_assetadd" };
    } else {
        options.ajax = { id: "x_asser_id", form: "fbuyer_save_buy_assetadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.buyer_save_buy_asset.fields.asser_id.selectOptions);
    ew.createSelect(options);
});
</script>
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
    ew.addEventHandlers("buyer_save_buy_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
