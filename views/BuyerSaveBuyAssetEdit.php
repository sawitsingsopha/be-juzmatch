<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerSaveBuyAssetEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { buyer_save_buy_asset: currentTable } });
var currentForm, currentPageID;
var fbuyer_save_buy_assetedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbuyer_save_buy_assetedit = new ew.Form("fbuyer_save_buy_assetedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbuyer_save_buy_assetedit;

    // Add fields
    var fields = currentTable.fields;
    fbuyer_save_buy_assetedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asser_id", [fields.asser_id.visible && fields.asser_id.required ? ew.Validators.required(fields.asser_id.caption) : null], fields.asser_id.isInvalid]
    ]);

    // Form_CustomValidate
    fbuyer_save_buy_assetedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbuyer_save_buy_assetedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fbuyer_save_buy_assetedit");
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
<form name="fbuyer_save_buy_assetedit" id="fbuyer_save_buy_assetedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="buyer_save_buy_asset">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_buyer_save_buy_asset_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_buyer_save_buy_asset_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_save_buy_asset" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asser_id->Visible) { // asser_id ?>
    <div id="r_asser_id"<?= $Page->asser_id->rowAttributes() ?>>
        <label id="elh_buyer_save_buy_asset_asser_id" for="x_asser_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asser_id->caption() ?><?= $Page->asser_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asser_id->cellAttributes() ?>>
<span id="el_buyer_save_buy_asset_asser_id">
<span<?= $Page->asser_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asser_id->getDisplayValue($Page->asser_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="buyer_save_buy_asset" data-field="x_asser_id" data-hidden="1" name="x_asser_id" id="x_asser_id" value="<?= HtmlEncode($Page->asser_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="buyer_save_buy_asset" data-field="x_buyer_save_buy_asset_id" data-hidden="1" name="x_buyer_save_buy_asset_id" id="x_buyer_save_buy_asset_id" value="<?= HtmlEncode($Page->buyer_save_buy_asset_id->CurrentValue) ?>">
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
    ew.addEventHandlers("buyer_save_buy_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
