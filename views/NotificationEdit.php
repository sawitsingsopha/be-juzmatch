<?php

namespace PHPMaker2022\juzmatch;

// Page object
$NotificationEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { notification: currentTable } });
var currentForm, currentPageID;
var fnotificationedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fnotificationedit = new ew.Form("fnotificationedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fnotificationedit;

    // Add fields
    var fields = currentTable.fields;
    fnotificationedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["title_en", [fields.title_en.visible && fields.title_en.required ? ew.Validators.required(fields.title_en.caption) : null], fields.title_en.isInvalid],
        ["detail", [fields.detail.visible && fields.detail.required ? ew.Validators.required(fields.detail.caption) : null], fields.detail.isInvalid],
        ["detail_en", [fields.detail_en.visible && fields.detail_en.required ? ew.Validators.required(fields.detail_en.caption) : null], fields.detail_en.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["is_read", [fields.is_read.visible && fields.is_read.required ? ew.Validators.required(fields.is_read.caption) : null, ew.Validators.integer], fields.is_read.isInvalid]
    ]);

    // Form_CustomValidate
    fnotificationedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnotificationedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fnotificationedit");
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
<form name="fnotificationedit" id="fnotificationedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="notification">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_notification_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_notification_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="notification" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_notification__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span id="el_notification__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="notification" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <div id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <label id="elh_notification_title_en" for="x_title_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title_en->caption() ?><?= $Page->title_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->title_en->cellAttributes() ?>>
<span id="el_notification_title_en">
<input type="<?= $Page->title_en->getInputTextType() ?>" name="x_title_en" id="x_title_en" data-table="notification" data-field="x_title_en" value="<?= $Page->title_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->title_en->getPlaceHolder()) ?>"<?= $Page->title_en->editAttributes() ?> aria-describedby="x_title_en_help">
<?= $Page->title_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <div id="r_detail"<?= $Page->detail->rowAttributes() ?>>
        <label id="elh_notification_detail" for="x_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detail->caption() ?><?= $Page->detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detail->cellAttributes() ?>>
<span id="el_notification_detail">
<textarea data-table="notification" data-field="x_detail" name="x_detail" id="x_detail" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detail->getPlaceHolder()) ?>"<?= $Page->detail->editAttributes() ?> aria-describedby="x_detail_help"><?= $Page->detail->EditValue ?></textarea>
<?= $Page->detail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detail_en->Visible) { // detail_en ?>
    <div id="r_detail_en"<?= $Page->detail_en->rowAttributes() ?>>
        <label id="elh_notification_detail_en" for="x_detail_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detail_en->caption() ?><?= $Page->detail_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detail_en->cellAttributes() ?>>
<span id="el_notification_detail_en">
<textarea data-table="notification" data-field="x_detail_en" name="x_detail_en" id="x_detail_en" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detail_en->getPlaceHolder()) ?>"<?= $Page->detail_en->editAttributes() ?> aria-describedby="x_detail_en_help"><?= $Page->detail_en->EditValue ?></textarea>
<?= $Page->detail_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detail_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_read->Visible) { // is_read ?>
    <div id="r_is_read"<?= $Page->is_read->rowAttributes() ?>>
        <label id="elh_notification_is_read" for="x_is_read" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_read->caption() ?><?= $Page->is_read->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->is_read->cellAttributes() ?>>
<span id="el_notification_is_read">
<input type="<?= $Page->is_read->getInputTextType() ?>" name="x_is_read" id="x_is_read" data-table="notification" data-field="x_is_read" value="<?= $Page->is_read->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->is_read->getPlaceHolder()) ?>"<?= $Page->is_read->editAttributes() ?> aria-describedby="x_is_read_help">
<?= $Page->is_read->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_read->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="notification" data-field="x_notification_id" data-hidden="1" name="x_notification_id" id="x_notification_id" value="<?= HtmlEncode($Page->notification_id->CurrentValue) ?>">
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
    ew.addEventHandlers("notification");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
