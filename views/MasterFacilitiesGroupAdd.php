<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MasterFacilitiesGroupAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { master_facilities_group: currentTable } });
var currentForm, currentPageID;
var fmaster_facilities_groupadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmaster_facilities_groupadd = new ew.Form("fmaster_facilities_groupadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fmaster_facilities_groupadd;

    // Add fields
    var fields = currentTable.fields;
    fmaster_facilities_groupadd.addFields([
        ["master_facilities_group_id", [fields.master_facilities_group_id.visible && fields.master_facilities_group_id.required ? ew.Validators.required(fields.master_facilities_group_id.caption) : null], fields.master_facilities_group_id.isInvalid],
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["title_en", [fields.title_en.visible && fields.title_en.required ? ew.Validators.required(fields.title_en.caption) : null], fields.title_en.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fmaster_facilities_groupadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmaster_facilities_groupadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fmaster_facilities_groupadd.lists.master_facilities_group_id = <?= $Page->master_facilities_group_id->toClientList($Page) ?>;
    fmaster_facilities_groupadd.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    loadjs.done("fmaster_facilities_groupadd");
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
<form name="fmaster_facilities_groupadd" id="fmaster_facilities_groupadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="master_facilities_group">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->master_facilities_group_id->Visible) { // master_facilities_group_id ?>
    <div id="r_master_facilities_group_id"<?= $Page->master_facilities_group_id->rowAttributes() ?>>
        <label id="elh_master_facilities_group_master_facilities_group_id" for="x_master_facilities_group_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->master_facilities_group_id->caption() ?><?= $Page->master_facilities_group_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->master_facilities_group_id->cellAttributes() ?>></div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_master_facilities_group__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span id="el_master_facilities_group__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="master_facilities_group" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <div id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <label id="elh_master_facilities_group_title_en" for="x_title_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title_en->caption() ?><?= $Page->title_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->title_en->cellAttributes() ?>>
<span id="el_master_facilities_group_title_en">
<input type="<?= $Page->title_en->getInputTextType() ?>" name="x_title_en" id="x_title_en" data-table="master_facilities_group" data-field="x_title_en" value="<?= $Page->title_en->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->title_en->getPlaceHolder()) ?>"<?= $Page->title_en->editAttributes() ?> aria-describedby="x_title_en_help">
<?= $Page->title_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_master_facilities_group_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_master_facilities_group_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="master_facilities_group" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
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
    data-table="master_facilities_group"
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
    ew.addEventHandlers("master_facilities_group");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
