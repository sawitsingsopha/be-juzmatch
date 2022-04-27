<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetInterestedAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset_interested: currentTable } });
var currentForm, currentPageID;
var fasset_interestedadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fasset_interestedadd = new ew.Form("fasset_interestedadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fasset_interestedadd;

    // Add fields
    var fields = currentTable.fields;
    fasset_interestedadd.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["master_asset_interested_id", [fields.master_asset_interested_id.visible && fields.master_asset_interested_id.required ? ew.Validators.required(fields.master_asset_interested_id.caption) : null], fields.master_asset_interested_id.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fasset_interestedadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fasset_interestedadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fasset_interestedadd.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fasset_interestedadd.lists.master_asset_interested_id = <?= $Page->master_asset_interested_id->toClientList($Page) ?>;
    loadjs.done("fasset_interestedadd");
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
<form name="fasset_interestedadd" id="fasset_interestedadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset_interested">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_asset_interested_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_asset_interested_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fasset_interestedadd_x_asset_id"
        data-table="asset_interested"
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
loadjs.ready("fasset_interestedadd", function() {
    var options = { name: "x_asset_id", selectId: "fasset_interestedadd_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_interestedadd.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fasset_interestedadd" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fasset_interestedadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_interested.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->master_asset_interested_id->Visible) { // master_asset_interested_id ?>
    <div id="r_master_asset_interested_id"<?= $Page->master_asset_interested_id->rowAttributes() ?>>
        <label id="elh_asset_interested_master_asset_interested_id" for="x_master_asset_interested_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->master_asset_interested_id->caption() ?><?= $Page->master_asset_interested_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->master_asset_interested_id->cellAttributes() ?>>
<span id="el_asset_interested_master_asset_interested_id">
    <select
        id="x_master_asset_interested_id"
        name="x_master_asset_interested_id"
        class="form-select ew-select<?= $Page->master_asset_interested_id->isInvalidClass() ?>"
        data-select2-id="fasset_interestedadd_x_master_asset_interested_id"
        data-table="asset_interested"
        data-field="x_master_asset_interested_id"
        data-value-separator="<?= $Page->master_asset_interested_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->master_asset_interested_id->getPlaceHolder()) ?>"
        <?= $Page->master_asset_interested_id->editAttributes() ?>>
        <?= $Page->master_asset_interested_id->selectOptionListHtml("x_master_asset_interested_id") ?>
    </select>
    <?= $Page->master_asset_interested_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->master_asset_interested_id->getErrorMessage() ?></div>
<?= $Page->master_asset_interested_id->Lookup->getParamTag($Page, "p_x_master_asset_interested_id") ?>
<script>
loadjs.ready("fasset_interestedadd", function() {
    var options = { name: "x_master_asset_interested_id", selectId: "fasset_interestedadd_x_master_asset_interested_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fasset_interestedadd.lists.master_asset_interested_id.lookupOptions.length) {
        options.data = { id: "x_master_asset_interested_id", form: "fasset_interestedadd" };
    } else {
        options.ajax = { id: "x_master_asset_interested_id", form: "fasset_interestedadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.asset_interested.fields.master_asset_interested_id.selectOptions);
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
    ew.addEventHandlers("asset_interested");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
