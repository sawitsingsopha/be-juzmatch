<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerVerifyEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_verify: currentTable } });
var currentForm, currentPageID;
var fbuyer_verifyedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_verifyedit = new ew.Form("fbuyer_verifyedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbuyer_verifyedit;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_verifyedit.addFields([
        ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null], fields.category_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["installment_min", [fields.installment_min.visible && fields.installment_min.required ? ew.Validators.required(fields.installment_min.caption) : null, ew.Validators.float], fields.installment_min.isInvalid],
        ["installment_max", [fields.installment_max.visible && fields.installment_max.required ? ew.Validators.required(fields.installment_max.caption) : null, ew.Validators.float], fields.installment_max.isInvalid],
        ["num_bedroom", [fields.num_bedroom.visible && fields.num_bedroom.required ? ew.Validators.required(fields.num_bedroom.caption) : null], fields.num_bedroom.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null], fields.latitude.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null], fields.longitude.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid]
    ]);

    // Form_CustomValidate
    fbuyer_verifyedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_verifyedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbuyer_verifyedit.lists.num_bedroom = <?= $Page->num_bedroom->toClientList($Page) ?>;
    loadjs.done("fbuyer_verifyedit");
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
<form name="fbuyer_verifyedit" id="fbuyer_verifyedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_verify">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->category_id->Visible) { // category_id ?>
    <div id="r_category_id"<?= $Page->category_id->rowAttributes() ?>>
        <label id="elh_buyer_verify_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_id->caption() ?><?= $Page->category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_id->cellAttributes() ?>>
<span id="el_buyer_verify_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->category_id->getDisplayValue($Page->category_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_verify" data-field="x_category_id" data-hidden="1" name="x_category_id" id="x_category_id" value="<?= HtmlEncode($Page->category_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_buyer_verify_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_verify_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_verify" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_min->Visible) { // installment_min ?>
    <div id="r_installment_min"<?= $Page->installment_min->rowAttributes() ?>>
        <label id="elh_buyer_verify_installment_min" for="x_installment_min" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_min->caption() ?><?= $Page->installment_min->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_min->cellAttributes() ?>>
<span id="el_buyer_verify_installment_min">
<input type="<?= $Page->installment_min->getInputTextType() ?>" name="x_installment_min" id="x_installment_min" data-table="buyer_verify" data-field="x_installment_min" value="<?= $Page->installment_min->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_min->getPlaceHolder()) ?>"<?= $Page->installment_min->editAttributes() ?> aria-describedby="x_installment_min_help">
<?= $Page->installment_min->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_min->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_max->Visible) { // installment_max ?>
    <div id="r_installment_max"<?= $Page->installment_max->rowAttributes() ?>>
        <label id="elh_buyer_verify_installment_max" for="x_installment_max" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_max->caption() ?><?= $Page->installment_max->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_max->cellAttributes() ?>>
<span id="el_buyer_verify_installment_max">
<input type="<?= $Page->installment_max->getInputTextType() ?>" name="x_installment_max" id="x_installment_max" data-table="buyer_verify" data-field="x_installment_max" value="<?= $Page->installment_max->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_max->getPlaceHolder()) ?>"<?= $Page->installment_max->editAttributes() ?> aria-describedby="x_installment_max_help">
<?= $Page->installment_max->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_max->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->num_bedroom->Visible) { // num_bedroom ?>
    <div id="r_num_bedroom"<?= $Page->num_bedroom->rowAttributes() ?>>
        <label id="elh_buyer_verify_num_bedroom" class="<?= $Page->LeftColumnClass ?>"><?= $Page->num_bedroom->caption() ?><?= $Page->num_bedroom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->num_bedroom->cellAttributes() ?>>
<span id="el_buyer_verify_num_bedroom">
<template id="tp_x_num_bedroom">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="buyer_verify" data-field="x_num_bedroom" name="x_num_bedroom" id="x_num_bedroom"<?= $Page->num_bedroom->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_num_bedroom" class="ew-item-list"></div>
<selection-list hidden
    id="x_num_bedroom[]"
    name="x_num_bedroom[]"
    value="<?= HtmlEncode($Page->num_bedroom->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_num_bedroom"
    data-bs-target="dsl_x_num_bedroom"
    data-repeatcolumn="5"
    class="form-control<?= $Page->num_bedroom->isInvalidClass() ?>"
    data-table="buyer_verify"
    data-field="x_num_bedroom"
    data-value-separator="<?= $Page->num_bedroom->displayValueSeparatorAttribute() ?>"
    <?= $Page->num_bedroom->editAttributes() ?>></selection-list>
<?= $Page->num_bedroom->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->num_bedroom->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <div id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <label id="elh_buyer_verify_latitude" for="x_latitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->latitude->caption() ?><?= $Page->latitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->latitude->cellAttributes() ?>>
<span id="el_buyer_verify_latitude">
<input type="<?= $Page->latitude->getInputTextType() ?>" name="x_latitude" id="x_latitude" data-table="buyer_verify" data-field="x_latitude" value="<?= $Page->latitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->latitude->getPlaceHolder()) ?>"<?= $Page->latitude->editAttributes() ?> aria-describedby="x_latitude_help">
<?= $Page->latitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->latitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <div id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <label id="elh_buyer_verify_longitude" for="x_longitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->longitude->caption() ?><?= $Page->longitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->longitude->cellAttributes() ?>>
<span id="el_buyer_verify_longitude">
<input type="<?= $Page->longitude->getInputTextType() ?>" name="x_longitude" id="x_longitude" data-table="buyer_verify" data-field="x_longitude" value="<?= $Page->longitude->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->longitude->getPlaceHolder()) ?>"<?= $Page->longitude->editAttributes() ?> aria-describedby="x_longitude_help">
<?= $Page->longitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->longitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="buyer_verify" data-field="x_buyer_verify_id" data-hidden="1" name="x_buyer_verify_id" id="x_buyer_verify_id" value="<?= HtmlEncode($Page->buyer_verify_id->CurrentValue) ?>">
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
    ew.addEventHandlers("buyer_verify");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
