<?php

namespace PHPMaker2022\juzmatch;

// Page object
$Log2c2pAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_2c2p: currentTable } });
var currentForm, currentPageID;
var flog_2c2padd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_2c2padd = new ew.Form("flog_2c2padd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = flog_2c2padd;

    // Add fields
    var fields = currentTable.fields;
    flog_2c2padd.addFields([
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null, ew.Validators.integer], fields.type.isInvalid],
        ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
        ["ip", [fields.ip.visible && fields.ip.required ? ew.Validators.required(fields.ip.caption) : null], fields.ip.isInvalid],
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null, ew.Validators.integer], fields.member_id.isInvalid],
        ["__request", [fields.__request.visible && fields.__request.required ? ew.Validators.required(fields.__request.caption) : null], fields.__request.isInvalid],
        ["_response", [fields._response.visible && fields._response.required ? ew.Validators.required(fields._response.caption) : null], fields._response.isInvalid],
        ["refid", [fields.refid.visible && fields.refid.required ? ew.Validators.required(fields.refid.caption) : null], fields.refid.isInvalid]
    ]);

    // Form_CustomValidate
    flog_2c2padd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flog_2c2padd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("flog_2c2padd");
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
<form name="flog_2c2padd" id="flog_2c2padd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_2c2p">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_log_2c2p_type" for="x_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_log_2c2p_type">
<input type="<?= $Page->type->getInputTextType() ?>" name="x_type" id="x_type" data-table="log_2c2p" data-field="x_type" value="<?= $Page->type->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"<?= $Page->type->editAttributes() ?> aria-describedby="x_type_help">
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date"<?= $Page->date->rowAttributes() ?>>
        <label id="elh_log_2c2p_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date->cellAttributes() ?>>
<span id="el_log_2c2p_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="log_2c2p" data-field="x_date" value="<?= $Page->date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_2c2padd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_2c2padd", "x_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
    <div id="r_ip"<?= $Page->ip->rowAttributes() ?>>
        <label id="elh_log_2c2p_ip" for="x_ip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ip->caption() ?><?= $Page->ip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ip->cellAttributes() ?>>
<span id="el_log_2c2p_ip">
<input type="<?= $Page->ip->getInputTextType() ?>" name="x_ip" id="x_ip" data-table="log_2c2p" data-field="x_ip" value="<?= $Page->ip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ip->getPlaceHolder()) ?>"<?= $Page->ip->editAttributes() ?> aria-describedby="x_ip_help">
<?= $Page->ip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_log_2c2p_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_log_2c2p_member_id">
<input type="<?= $Page->member_id->getInputTextType() ?>" name="x_member_id" id="x_member_id" data-table="log_2c2p" data-field="x_member_id" value="<?= $Page->member_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"<?= $Page->member_id->editAttributes() ?> aria-describedby="x_member_id_help">
<?= $Page->member_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->__request->Visible) { // request ?>
    <div id="r___request"<?= $Page->__request->rowAttributes() ?>>
        <label id="elh_log_2c2p___request" for="x___request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->__request->caption() ?><?= $Page->__request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->__request->cellAttributes() ?>>
<span id="el_log_2c2p___request">
<textarea data-table="log_2c2p" data-field="x___request" name="x___request" id="x___request" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->__request->getPlaceHolder()) ?>"<?= $Page->__request->editAttributes() ?> aria-describedby="x___request_help"><?= $Page->__request->EditValue ?></textarea>
<?= $Page->__request->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->__request->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_response->Visible) { // response ?>
    <div id="r__response"<?= $Page->_response->rowAttributes() ?>>
        <label id="elh_log_2c2p__response" for="x__response" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_response->caption() ?><?= $Page->_response->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_response->cellAttributes() ?>>
<span id="el_log_2c2p__response">
<textarea data-table="log_2c2p" data-field="x__response" name="x__response" id="x__response" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_response->getPlaceHolder()) ?>"<?= $Page->_response->editAttributes() ?> aria-describedby="x__response_help"><?= $Page->_response->EditValue ?></textarea>
<?= $Page->_response->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_response->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
    <div id="r_refid"<?= $Page->refid->rowAttributes() ?>>
        <label id="elh_log_2c2p_refid" for="x_refid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->refid->caption() ?><?= $Page->refid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->refid->cellAttributes() ?>>
<span id="el_log_2c2p_refid">
<input type="<?= $Page->refid->getInputTextType() ?>" name="x_refid" id="x_refid" data-table="log_2c2p" data-field="x_refid" value="<?= $Page->refid->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->refid->getPlaceHolder()) ?>"<?= $Page->refid->editAttributes() ?> aria-describedby="x_refid_help">
<?= $Page->refid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->refid->getErrorMessage() ?></div>
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
    ew.addEventHandlers("log_2c2p");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
