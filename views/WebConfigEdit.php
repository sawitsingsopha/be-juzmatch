<?php

namespace PHPMaker2022\juzmatch;

// Page object
$WebConfigEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { web_config: currentTable } });
var currentForm, currentPageID;
var fweb_configedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fweb_configedit = new ew.Form("fweb_configedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fweb_configedit;

    // Add fields
    var fields = currentTable.fields;
    fweb_configedit.addFields([
        ["_param", [fields._param.visible && fields._param.required ? ew.Validators.required(fields._param.caption) : null], fields._param.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null], fields.value.isInvalid],
        ["remark", [fields.remark.visible && fields.remark.required ? ew.Validators.required(fields.remark.caption) : null], fields.remark.isInvalid]
    ]);

    // Form_CustomValidate
    fweb_configedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fweb_configedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fweb_configedit");
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
<form name="fweb_configedit" id="fweb_configedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="web_config">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->_param->Visible) { // param ?>
    <div id="r__param"<?= $Page->_param->rowAttributes() ?>>
        <label id="elh_web_config__param" for="x__param" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_param->caption() ?><?= $Page->_param->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_param->cellAttributes() ?>>
<span id="el_web_config__param">
<span<?= $Page->_param->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_param->getDisplayValue($Page->_param->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="web_config" data-field="x__param" data-hidden="1" name="x__param" id="x__param" value="<?= HtmlEncode($Page->_param->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_web_config_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_web_config_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="web_config" data-field="x_value" value="<?= $Page->value->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remark->Visible) { // remark ?>
    <div id="r_remark"<?= $Page->remark->rowAttributes() ?>>
        <label id="elh_web_config_remark" for="x_remark" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remark->caption() ?><?= $Page->remark->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remark->cellAttributes() ?>>
<span id="el_web_config_remark">
<textarea data-table="web_config" data-field="x_remark" name="x_remark" id="x_remark" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->remark->getPlaceHolder()) ?>"<?= $Page->remark->editAttributes() ?> aria-describedby="x_remark_help"><?= $Page->remark->EditValue ?></textarea>
<?= $Page->remark->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remark->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="web_config" data-field="x_web_config_id" data-hidden="1" name="x_web_config_id" id="x_web_config_id" value="<?= HtmlEncode($Page->web_config_id->CurrentValue) ?>">
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
    ew.addEventHandlers("web_config");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
