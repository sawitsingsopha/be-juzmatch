<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AddressEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { address: currentTable } });
var currentForm, currentPageID;
var faddressedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    faddressedit = new ew.Form("faddressedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = faddressedit;

    // Add fields
    var fields = currentTable.fields;
    faddressedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["province_id", [fields.province_id.visible && fields.province_id.required ? ew.Validators.required(fields.province_id.caption) : null], fields.province_id.isInvalid],
        ["amphur_id", [fields.amphur_id.visible && fields.amphur_id.required ? ew.Validators.required(fields.amphur_id.caption) : null], fields.amphur_id.isInvalid],
        ["district_id", [fields.district_id.visible && fields.district_id.required ? ew.Validators.required(fields.district_id.caption) : null], fields.district_id.isInvalid],
        ["postcode", [fields.postcode.visible && fields.postcode.required ? ew.Validators.required(fields.postcode.caption) : null], fields.postcode.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    faddressedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    faddressedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    faddressedit.lists.province_id = <?= $Page->province_id->toClientList($Page) ?>;
    faddressedit.lists.amphur_id = <?= $Page->amphur_id->toClientList($Page) ?>;
    faddressedit.lists.district_id = <?= $Page->district_id->toClientList($Page) ?>;
    loadjs.done("faddressedit");
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
<form name="faddressedit" id="faddressedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="address">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "member") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="member">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_address_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_address_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="address" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_address_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_address_address">
<textarea data-table="address" data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help"><?= $Page->address->EditValue ?></textarea>
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
    <div id="r_province_id"<?= $Page->province_id->rowAttributes() ?>>
        <label id="elh_address_province_id" for="x_province_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->province_id->caption() ?><?= $Page->province_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->province_id->cellAttributes() ?>>
<span id="el_address_province_id">
<?php $Page->province_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_province_id"
        name="x_province_id"
        class="form-select ew-select<?= $Page->province_id->isInvalidClass() ?>"
        data-select2-id="faddressedit_x_province_id"
        data-table="address"
        data-field="x_province_id"
        data-value-separator="<?= $Page->province_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->province_id->getPlaceHolder()) ?>"
        <?= $Page->province_id->editAttributes() ?>>
        <?= $Page->province_id->selectOptionListHtml("x_province_id") ?>
    </select>
    <?= $Page->province_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->province_id->getErrorMessage() ?></div>
<?= $Page->province_id->Lookup->getParamTag($Page, "p_x_province_id") ?>
<script>
loadjs.ready("faddressedit", function() {
    var options = { name: "x_province_id", selectId: "faddressedit_x_province_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressedit.lists.province_id.lookupOptions.length) {
        options.data = { id: "x_province_id", form: "faddressedit" };
    } else {
        options.ajax = { id: "x_province_id", form: "faddressedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.province_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
    <div id="r_amphur_id"<?= $Page->amphur_id->rowAttributes() ?>>
        <label id="elh_address_amphur_id" for="x_amphur_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amphur_id->caption() ?><?= $Page->amphur_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amphur_id->cellAttributes() ?>>
<span id="el_address_amphur_id">
<?php $Page->amphur_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_amphur_id"
        name="x_amphur_id"
        class="form-select ew-select<?= $Page->amphur_id->isInvalidClass() ?>"
        data-select2-id="faddressedit_x_amphur_id"
        data-table="address"
        data-field="x_amphur_id"
        data-value-separator="<?= $Page->amphur_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->amphur_id->getPlaceHolder()) ?>"
        <?= $Page->amphur_id->editAttributes() ?>>
        <?= $Page->amphur_id->selectOptionListHtml("x_amphur_id") ?>
    </select>
    <?= $Page->amphur_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->amphur_id->getErrorMessage() ?></div>
<?= $Page->amphur_id->Lookup->getParamTag($Page, "p_x_amphur_id") ?>
<script>
loadjs.ready("faddressedit", function() {
    var options = { name: "x_amphur_id", selectId: "faddressedit_x_amphur_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressedit.lists.amphur_id.lookupOptions.length) {
        options.data = { id: "x_amphur_id", form: "faddressedit" };
    } else {
        options.ajax = { id: "x_amphur_id", form: "faddressedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.amphur_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
    <div id="r_district_id"<?= $Page->district_id->rowAttributes() ?>>
        <label id="elh_address_district_id" for="x_district_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->district_id->caption() ?><?= $Page->district_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->district_id->cellAttributes() ?>>
<span id="el_address_district_id">
    <select
        id="x_district_id"
        name="x_district_id"
        class="form-select ew-select<?= $Page->district_id->isInvalidClass() ?>"
        data-select2-id="faddressedit_x_district_id"
        data-table="address"
        data-field="x_district_id"
        data-value-separator="<?= $Page->district_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->district_id->getPlaceHolder()) ?>"
        <?= $Page->district_id->editAttributes() ?>>
        <?= $Page->district_id->selectOptionListHtml("x_district_id") ?>
    </select>
    <?= $Page->district_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->district_id->getErrorMessage() ?></div>
<?= $Page->district_id->Lookup->getParamTag($Page, "p_x_district_id") ?>
<script>
loadjs.ready("faddressedit", function() {
    var options = { name: "x_district_id", selectId: "faddressedit_x_district_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (faddressedit.lists.district_id.lookupOptions.length) {
        options.data = { id: "x_district_id", form: "faddressedit" };
    } else {
        options.ajax = { id: "x_district_id", form: "faddressedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.address.fields.district_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
    <div id="r_postcode"<?= $Page->postcode->rowAttributes() ?>>
        <label id="elh_address_postcode" for="x_postcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->postcode->caption() ?><?= $Page->postcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->postcode->cellAttributes() ?>>
<span id="el_address_postcode">
<input type="<?= $Page->postcode->getInputTextType() ?>" name="x_postcode" id="x_postcode" data-table="address" data-field="x_postcode" value="<?= $Page->postcode->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->postcode->getPlaceHolder()) ?>"<?= $Page->postcode->editAttributes() ?> aria-describedby="x_postcode_help">
<?= $Page->postcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->postcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="address" data-field="x_address_id" data-hidden="1" name="x_address_id" id="x_address_id" value="<?= HtmlEncode($Page->address_id->CurrentValue) ?>">
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
    ew.addEventHandlers("address");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
