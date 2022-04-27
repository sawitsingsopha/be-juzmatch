<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SettingLangAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { setting_lang: currentTable } });
var currentForm, currentPageID;
var fsetting_langadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsetting_langadd = new ew.Form("fsetting_langadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fsetting_langadd;

    // Add fields
    var fields = currentTable.fields;
    fsetting_langadd.addFields([
        ["lang_en", [fields.lang_en.visible && fields.lang_en.required ? ew.Validators.required(fields.lang_en.caption) : null], fields.lang_en.isInvalid],
        ["lang", [fields.lang.visible && fields.lang.required ? ew.Validators.required(fields.lang.caption) : null], fields.lang.isInvalid],
        ["_param", [fields._param.visible && fields._param.required ? ew.Validators.required(fields._param.caption) : null], fields._param.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null, ew.Validators.datetime(fields.udate.clientFormatPattern)], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fsetting_langadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsetting_langadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fsetting_langadd");
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
<form name="fsetting_langadd" id="fsetting_langadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="setting_lang">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->lang_en->Visible) { // lang_en ?>
    <div id="r_lang_en"<?= $Page->lang_en->rowAttributes() ?>>
        <label id="elh_setting_lang_lang_en" for="x_lang_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lang_en->caption() ?><?= $Page->lang_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lang_en->cellAttributes() ?>>
<span id="el_setting_lang_lang_en">
<input type="<?= $Page->lang_en->getInputTextType() ?>" name="x_lang_en" id="x_lang_en" data-table="setting_lang" data-field="x_lang_en" value="<?= $Page->lang_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lang_en->getPlaceHolder()) ?>"<?= $Page->lang_en->editAttributes() ?> aria-describedby="x_lang_en_help">
<?= $Page->lang_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lang_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lang->Visible) { // lang ?>
    <div id="r_lang"<?= $Page->lang->rowAttributes() ?>>
        <label id="elh_setting_lang_lang" for="x_lang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lang->caption() ?><?= $Page->lang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lang->cellAttributes() ?>>
<span id="el_setting_lang_lang">
<input type="<?= $Page->lang->getInputTextType() ?>" name="x_lang" id="x_lang" data-table="setting_lang" data-field="x_lang" value="<?= $Page->lang->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lang->getPlaceHolder()) ?>"<?= $Page->lang->editAttributes() ?> aria-describedby="x_lang_help">
<?= $Page->lang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_param->Visible) { // param ?>
    <div id="r__param"<?= $Page->_param->rowAttributes() ?>>
        <label id="elh_setting_lang__param" for="x__param" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_param->caption() ?><?= $Page->_param->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_param->cellAttributes() ?>>
<span id="el_setting_lang__param">
<input type="<?= $Page->_param->getInputTextType() ?>" name="x__param" id="x__param" data-table="setting_lang" data-field="x__param" value="<?= $Page->_param->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_param->getPlaceHolder()) ?>"<?= $Page->_param->editAttributes() ?> aria-describedby="x__param_help">
<?= $Page->_param->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_param->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_setting_lang_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_setting_lang_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="setting_lang" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <div id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <label id="elh_setting_lang_udate" for="x_udate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->udate->caption() ?><?= $Page->udate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->udate->cellAttributes() ?>>
<span id="el_setting_lang_udate">
<input type="<?= $Page->udate->getInputTextType() ?>" name="x_udate" id="x_udate" data-table="setting_lang" data-field="x_udate" value="<?= $Page->udate->EditValue ?>" placeholder="<?= HtmlEncode($Page->udate->getPlaceHolder()) ?>"<?= $Page->udate->editAttributes() ?> aria-describedby="x_udate_help">
<?= $Page->udate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->udate->getErrorMessage() ?></div>
<?php if (!$Page->udate->ReadOnly && !$Page->udate->Disabled && !isset($Page->udate->EditAttrs["readonly"]) && !isset($Page->udate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsetting_langadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("fsetting_langadd", "x_udate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <div id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <label id="elh_setting_lang_uip" for="x_uip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uip->caption() ?><?= $Page->uip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uip->cellAttributes() ?>>
<span id="el_setting_lang_uip">
<input type="<?= $Page->uip->getInputTextType() ?>" name="x_uip" id="x_uip" data-table="setting_lang" data-field="x_uip" value="<?= $Page->uip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->uip->getPlaceHolder()) ?>"<?= $Page->uip->editAttributes() ?> aria-describedby="x_uip_help">
<?= $Page->uip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <div id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <label id="elh_setting_lang_uuser" for="x_uuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuser->caption() ?><?= $Page->uuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uuser->cellAttributes() ?>>
<span id="el_setting_lang_uuser">
<input type="<?= $Page->uuser->getInputTextType() ?>" name="x_uuser" id="x_uuser" data-table="setting_lang" data-field="x_uuser" value="<?= $Page->uuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->uuser->getPlaceHolder()) ?>"<?= $Page->uuser->editAttributes() ?> aria-describedby="x_uuser_help">
<?= $Page->uuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuser->getErrorMessage() ?></div>
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
    ew.addEventHandlers("setting_lang");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
