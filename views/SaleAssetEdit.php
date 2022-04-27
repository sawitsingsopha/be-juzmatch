<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaleAssetEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sale_asset: currentTable } });
var currentForm, currentPageID;
var fsale_assetedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsale_assetedit = new ew.Form("fsale_assetedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fsale_assetedit;

    // Add fields
    var fields = currentTable.fields;
    fsale_assetedit.addFields([
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["status_live", [fields.status_live.visible && fields.status_live.required ? ew.Validators.required(fields.status_live.caption) : null, ew.Validators.integer], fields.status_live.isInvalid]
    ]);

    // Form_CustomValidate
    fsale_assetedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsale_assetedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fsale_assetedit");
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
<form name="fsale_assetedit" id="fsale_assetedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sale_asset">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "seller") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="seller">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_sale_asset_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<span id="el_sale_asset_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="sale_asset" data-field="x_asset_id" data-hidden="1" name="x_asset_id" id="x_asset_id" value="<?= HtmlEncode($Page->asset_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_sale_asset_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_sale_asset_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="sale_asset" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_live->Visible) { // status_live ?>
    <div id="r_status_live"<?= $Page->status_live->rowAttributes() ?>>
        <label id="elh_sale_asset_status_live" for="x_status_live" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_live->caption() ?><?= $Page->status_live->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_live->cellAttributes() ?>>
<span id="el_sale_asset_status_live">
<input type="<?= $Page->status_live->getInputTextType() ?>" name="x_status_live" id="x_status_live" data-table="sale_asset" data-field="x_status_live" value="<?= $Page->status_live->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->status_live->getPlaceHolder()) ?>"<?= $Page->status_live->editAttributes() ?> aria-describedby="x_status_live_help">
<?= $Page->status_live->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_live->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sale_asset" data-field="x_sale_asset_id" data-hidden="1" name="x_sale_asset_id" id="x_sale_asset_id" value="<?= HtmlEncode($Page->sale_asset_id->CurrentValue) ?>">
<?php
    if (in_array("appointment", explode(",", $Page->getCurrentDetailTable())) && $appointment->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("appointment", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AppointmentGrid.php" ?>
<?php } ?>
<?php
    if (in_array("asset_warning", explode(",", $Page->getCurrentDetailTable())) && $asset_warning->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("asset_warning", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AssetWarningGrid.php" ?>
<?php } ?>
<?php
    if (in_array("asset", explode(",", $Page->getCurrentDetailTable())) && $asset->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("asset", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AssetGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("sale_asset");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
