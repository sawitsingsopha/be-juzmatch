<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogSendEmailEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_send_email: currentTable } });
var currentForm, currentPageID;
var flog_send_emailedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_send_emailedit = new ew.Form("flog_send_emailedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = flog_send_emailedit;

    // Add fields
    var fields = currentTable.fields;
    flog_send_emailedit.addFields([
        ["log_email_id", [fields.log_email_id.visible && fields.log_email_id.required ? ew.Validators.required(fields.log_email_id.caption) : null], fields.log_email_id.isInvalid],
        ["cc", [fields.cc.visible && fields.cc.required ? ew.Validators.required(fields.cc.caption) : null], fields.cc.isInvalid],
        ["subject", [fields.subject.visible && fields.subject.required ? ew.Validators.required(fields.subject.caption) : null], fields.subject.isInvalid],
        ["body", [fields.body.visible && fields.body.required ? ew.Validators.required(fields.body.caption) : null], fields.body.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null, ew.Validators.integer], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["email_from", [fields.email_from.visible && fields.email_from.required ? ew.Validators.required(fields.email_from.caption) : null], fields.email_from.isInvalid],
        ["email_to", [fields.email_to.visible && fields.email_to.required ? ew.Validators.required(fields.email_to.caption) : null], fields.email_to.isInvalid]
    ]);

    // Form_CustomValidate
    flog_send_emailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flog_send_emailedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("flog_send_emailedit");
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
<form name="flog_send_emailedit" id="flog_send_emailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_send_email">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->log_email_id->Visible) { // log_email_id ?>
    <div id="r_log_email_id"<?= $Page->log_email_id->rowAttributes() ?>>
        <label id="elh_log_send_email_log_email_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->log_email_id->caption() ?><?= $Page->log_email_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->log_email_id->cellAttributes() ?>>
<span id="el_log_send_email_log_email_id">
<span<?= $Page->log_email_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->log_email_id->getDisplayValue($Page->log_email_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="log_send_email" data-field="x_log_email_id" data-hidden="1" name="x_log_email_id" id="x_log_email_id" value="<?= HtmlEncode($Page->log_email_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cc->Visible) { // cc ?>
    <div id="r_cc"<?= $Page->cc->rowAttributes() ?>>
        <label id="elh_log_send_email_cc" for="x_cc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cc->caption() ?><?= $Page->cc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cc->cellAttributes() ?>>
<span id="el_log_send_email_cc">
<input type="<?= $Page->cc->getInputTextType() ?>" name="x_cc" id="x_cc" data-table="log_send_email" data-field="x_cc" value="<?= $Page->cc->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->cc->getPlaceHolder()) ?>"<?= $Page->cc->editAttributes() ?> aria-describedby="x_cc_help">
<?= $Page->cc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
    <div id="r_subject"<?= $Page->subject->rowAttributes() ?>>
        <label id="elh_log_send_email_subject" for="x_subject" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subject->caption() ?><?= $Page->subject->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subject->cellAttributes() ?>>
<span id="el_log_send_email_subject">
<input type="<?= $Page->subject->getInputTextType() ?>" name="x_subject" id="x_subject" data-table="log_send_email" data-field="x_subject" value="<?= $Page->subject->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->subject->getPlaceHolder()) ?>"<?= $Page->subject->editAttributes() ?> aria-describedby="x_subject_help">
<?= $Page->subject->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subject->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->body->Visible) { // body ?>
    <div id="r_body"<?= $Page->body->rowAttributes() ?>>
        <label id="elh_log_send_email_body" for="x_body" class="<?= $Page->LeftColumnClass ?>"><?= $Page->body->caption() ?><?= $Page->body->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->body->cellAttributes() ?>>
<span id="el_log_send_email_body">
<textarea data-table="log_send_email" data-field="x_body" name="x_body" id="x_body" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->body->getPlaceHolder()) ?>"<?= $Page->body->editAttributes() ?> aria-describedby="x_body_help"><?= $Page->body->EditValue ?></textarea>
<?= $Page->body->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->body->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_log_send_email_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_log_send_email_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="log_send_email" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_send_emailedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flog_send_emailedit", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_log_send_email_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_log_send_email_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="log_send_email" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_log_send_email_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_log_send_email_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="log_send_email" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_from->Visible) { // email_from ?>
    <div id="r_email_from"<?= $Page->email_from->rowAttributes() ?>>
        <label id="elh_log_send_email_email_from" for="x_email_from" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email_from->caption() ?><?= $Page->email_from->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email_from->cellAttributes() ?>>
<span id="el_log_send_email_email_from">
<input type="<?= $Page->email_from->getInputTextType() ?>" name="x_email_from" id="x_email_from" data-table="log_send_email" data-field="x_email_from" value="<?= $Page->email_from->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->email_from->getPlaceHolder()) ?>"<?= $Page->email_from->editAttributes() ?> aria-describedby="x_email_from_help">
<?= $Page->email_from->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email_from->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_to->Visible) { // email_to ?>
    <div id="r_email_to"<?= $Page->email_to->rowAttributes() ?>>
        <label id="elh_log_send_email_email_to" for="x_email_to" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email_to->caption() ?><?= $Page->email_to->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email_to->cellAttributes() ?>>
<span id="el_log_send_email_email_to">
<input type="<?= $Page->email_to->getInputTextType() ?>" name="x_email_to" id="x_email_to" data-table="log_send_email" data-field="x_email_to" value="<?= $Page->email_to->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->email_to->getPlaceHolder()) ?>"<?= $Page->email_to->editAttributes() ?> aria-describedby="x_email_to_help">
<?= $Page->email_to->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email_to->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("log_send_email");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
