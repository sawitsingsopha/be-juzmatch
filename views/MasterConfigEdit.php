<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MasterConfigEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { master_config: currentTable } });
var currentForm, currentPageID;
var fmaster_configedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmaster_configedit = new ew.Form("fmaster_configedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fmaster_configedit;

    // Add fields
    var fields = currentTable.fields;
    fmaster_configedit.addFields([
        ["price_booking_invertor", [fields.price_booking_invertor.visible && fields.price_booking_invertor.required ? ew.Validators.required(fields.price_booking_invertor.caption) : null, ew.Validators.float], fields.price_booking_invertor.isInvalid],
        ["price_booking_buyer", [fields.price_booking_buyer.visible && fields.price_booking_buyer.required ? ew.Validators.required(fields.price_booking_buyer.caption) : null, ew.Validators.float], fields.price_booking_buyer.isInvalid],
        ["down_payment_buyer", [fields.down_payment_buyer.visible && fields.down_payment_buyer.required ? ew.Validators.required(fields.down_payment_buyer.caption) : null, ew.Validators.float], fields.down_payment_buyer.isInvalid],
        ["code_asset_seller", [fields.code_asset_seller.visible && fields.code_asset_seller.required ? ew.Validators.required(fields.code_asset_seller.caption) : null], fields.code_asset_seller.isInvalid],
        ["code_asset_buyer", [fields.code_asset_buyer.visible && fields.code_asset_buyer.required ? ew.Validators.required(fields.code_asset_buyer.caption) : null], fields.code_asset_buyer.isInvalid],
        ["code_asset_juzmatch", [fields.code_asset_juzmatch.visible && fields.code_asset_juzmatch.required ? ew.Validators.required(fields.code_asset_juzmatch.caption) : null], fields.code_asset_juzmatch.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fmaster_configedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmaster_configedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fmaster_configedit");
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
<form name="fmaster_configedit" id="fmaster_configedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="master_config">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->price_booking_invertor->Visible) { // price_booking_invertor ?>
    <div id="r_price_booking_invertor"<?= $Page->price_booking_invertor->rowAttributes() ?>>
        <label id="elh_master_config_price_booking_invertor" for="x_price_booking_invertor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price_booking_invertor->caption() ?><?= $Page->price_booking_invertor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->price_booking_invertor->cellAttributes() ?>>
<span id="el_master_config_price_booking_invertor">
<input type="<?= $Page->price_booking_invertor->getInputTextType() ?>" name="x_price_booking_invertor" id="x_price_booking_invertor" data-table="master_config" data-field="x_price_booking_invertor" value="<?= $Page->price_booking_invertor->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->price_booking_invertor->getPlaceHolder()) ?>"<?= $Page->price_booking_invertor->editAttributes() ?> aria-describedby="x_price_booking_invertor_help">
<?= $Page->price_booking_invertor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->price_booking_invertor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->price_booking_buyer->Visible) { // price_booking_buyer ?>
    <div id="r_price_booking_buyer"<?= $Page->price_booking_buyer->rowAttributes() ?>>
        <label id="elh_master_config_price_booking_buyer" for="x_price_booking_buyer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->price_booking_buyer->caption() ?><?= $Page->price_booking_buyer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->price_booking_buyer->cellAttributes() ?>>
<span id="el_master_config_price_booking_buyer">
<input type="<?= $Page->price_booking_buyer->getInputTextType() ?>" name="x_price_booking_buyer" id="x_price_booking_buyer" data-table="master_config" data-field="x_price_booking_buyer" value="<?= $Page->price_booking_buyer->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->price_booking_buyer->getPlaceHolder()) ?>"<?= $Page->price_booking_buyer->editAttributes() ?> aria-describedby="x_price_booking_buyer_help">
<?= $Page->price_booking_buyer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->price_booking_buyer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->down_payment_buyer->Visible) { // down_payment_buyer ?>
    <div id="r_down_payment_buyer"<?= $Page->down_payment_buyer->rowAttributes() ?>>
        <label id="elh_master_config_down_payment_buyer" for="x_down_payment_buyer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->down_payment_buyer->caption() ?><?= $Page->down_payment_buyer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->down_payment_buyer->cellAttributes() ?>>
<span id="el_master_config_down_payment_buyer">
<input type="<?= $Page->down_payment_buyer->getInputTextType() ?>" name="x_down_payment_buyer" id="x_down_payment_buyer" data-table="master_config" data-field="x_down_payment_buyer" value="<?= $Page->down_payment_buyer->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->down_payment_buyer->getPlaceHolder()) ?>"<?= $Page->down_payment_buyer->editAttributes() ?> aria-describedby="x_down_payment_buyer_help">
<?= $Page->down_payment_buyer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->down_payment_buyer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code_asset_seller->Visible) { // code_asset_seller ?>
    <div id="r_code_asset_seller"<?= $Page->code_asset_seller->rowAttributes() ?>>
        <label id="elh_master_config_code_asset_seller" for="x_code_asset_seller" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code_asset_seller->caption() ?><?= $Page->code_asset_seller->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code_asset_seller->cellAttributes() ?>>
<span id="el_master_config_code_asset_seller">
<input type="<?= $Page->code_asset_seller->getInputTextType() ?>" name="x_code_asset_seller" id="x_code_asset_seller" data-table="master_config" data-field="x_code_asset_seller" value="<?= $Page->code_asset_seller->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_asset_seller->getPlaceHolder()) ?>"<?= $Page->code_asset_seller->editAttributes() ?> aria-describedby="x_code_asset_seller_help">
<?= $Page->code_asset_seller->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code_asset_seller->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code_asset_buyer->Visible) { // code_asset_buyer ?>
    <div id="r_code_asset_buyer"<?= $Page->code_asset_buyer->rowAttributes() ?>>
        <label id="elh_master_config_code_asset_buyer" for="x_code_asset_buyer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code_asset_buyer->caption() ?><?= $Page->code_asset_buyer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code_asset_buyer->cellAttributes() ?>>
<span id="el_master_config_code_asset_buyer">
<input type="<?= $Page->code_asset_buyer->getInputTextType() ?>" name="x_code_asset_buyer" id="x_code_asset_buyer" data-table="master_config" data-field="x_code_asset_buyer" value="<?= $Page->code_asset_buyer->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_asset_buyer->getPlaceHolder()) ?>"<?= $Page->code_asset_buyer->editAttributes() ?> aria-describedby="x_code_asset_buyer_help">
<?= $Page->code_asset_buyer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code_asset_buyer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code_asset_juzmatch->Visible) { // code_asset_juzmatch ?>
    <div id="r_code_asset_juzmatch"<?= $Page->code_asset_juzmatch->rowAttributes() ?>>
        <label id="elh_master_config_code_asset_juzmatch" for="x_code_asset_juzmatch" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code_asset_juzmatch->caption() ?><?= $Page->code_asset_juzmatch->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code_asset_juzmatch->cellAttributes() ?>>
<span id="el_master_config_code_asset_juzmatch">
<input type="<?= $Page->code_asset_juzmatch->getInputTextType() ?>" name="x_code_asset_juzmatch" id="x_code_asset_juzmatch" data-table="master_config" data-field="x_code_asset_juzmatch" value="<?= $Page->code_asset_juzmatch->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->code_asset_juzmatch->getPlaceHolder()) ?>"<?= $Page->code_asset_juzmatch->editAttributes() ?> aria-describedby="x_code_asset_juzmatch_help">
<?= $Page->code_asset_juzmatch->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code_asset_juzmatch->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="master_config" data-field="x_master_config_id" data-hidden="1" name="x_master_config_id" id="x_master_config_id" value="<?= HtmlEncode($Page->master_config_id->CurrentValue) ?>">
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
    ew.addEventHandlers("master_config");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
