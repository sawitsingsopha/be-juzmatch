<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenSignerEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_signer: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_signeredit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_signeredit = new ew.Form("fdoc_creden_signeredit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fdoc_creden_signeredit;

    // Add fields
    var fields = currentTable.fields;
    fdoc_creden_signeredit.addFields([
        ["doc_creden_signer_id", [fields.doc_creden_signer_id.visible && fields.doc_creden_signer_id.required ? ew.Validators.required(fields.doc_creden_signer_id.caption) : null], fields.doc_creden_signer_id.isInvalid],
        ["doc_creden_id", [fields.doc_creden_id.visible && fields.doc_creden_id.required ? ew.Validators.required(fields.doc_creden_id.caption) : null, ew.Validators.integer], fields.doc_creden_id.isInvalid],
        ["doc_creden_signer_no", [fields.doc_creden_signer_no.visible && fields.doc_creden_signer_no.required ? ew.Validators.required(fields.doc_creden_signer_no.caption) : null], fields.doc_creden_signer_no.isInvalid],
        ["doc_creden_signer_link", [fields.doc_creden_signer_link.visible && fields.doc_creden_signer_link.required ? ew.Validators.required(fields.doc_creden_signer_link.caption) : null], fields.doc_creden_signer_link.isInvalid],
        ["doc_creden_signer_session", [fields.doc_creden_signer_session.visible && fields.doc_creden_signer_session.required ? ew.Validators.required(fields.doc_creden_signer_session.caption) : null], fields.doc_creden_signer_session.isInvalid],
        ["doc_creden_signer_name", [fields.doc_creden_signer_name.visible && fields.doc_creden_signer_name.required ? ew.Validators.required(fields.doc_creden_signer_name.caption) : null], fields.doc_creden_signer_name.isInvalid],
        ["doc_creden_signer_email", [fields.doc_creden_signer_email.visible && fields.doc_creden_signer_email.required ? ew.Validators.required(fields.doc_creden_signer_email.caption) : null], fields.doc_creden_signer_email.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null, ew.Validators.integer], fields.status.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null, ew.Validators.datetime(fields.udate.clientFormatPattern)], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_creden_signeredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_creden_signeredit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fdoc_creden_signeredit");
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
<form name="fdoc_creden_signeredit" id="fdoc_creden_signeredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_signer">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->doc_creden_signer_id->Visible) { // doc_creden_signer_id ?>
    <div id="r_doc_creden_signer_id"<?= $Page->doc_creden_signer_id->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_signer_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_signer_id->caption() ?><?= $Page->doc_creden_signer_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_signer_id->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_id">
<span<?= $Page->doc_creden_signer_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->doc_creden_signer_id->getDisplayValue($Page->doc_creden_signer_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="doc_creden_signer" data-field="x_doc_creden_signer_id" data-hidden="1" name="x_doc_creden_signer_id" id="x_doc_creden_signer_id" value="<?= HtmlEncode($Page->doc_creden_signer_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
    <div id="r_doc_creden_id"<?= $Page->doc_creden_id->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_id" for="x_doc_creden_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_id->caption() ?><?= $Page->doc_creden_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_id">
<input type="<?= $Page->doc_creden_id->getInputTextType() ?>" name="x_doc_creden_id" id="x_doc_creden_id" data-table="doc_creden_signer" data-field="x_doc_creden_id" value="<?= $Page->doc_creden_id->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->doc_creden_id->getPlaceHolder()) ?>"<?= $Page->doc_creden_id->editAttributes() ?> aria-describedby="x_doc_creden_id_help">
<?= $Page->doc_creden_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_creden_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_creden_signer_no->Visible) { // doc_creden_signer_no ?>
    <div id="r_doc_creden_signer_no"<?= $Page->doc_creden_signer_no->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_signer_no" for="x_doc_creden_signer_no" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_signer_no->caption() ?><?= $Page->doc_creden_signer_no->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_signer_no->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_no">
<input type="<?= $Page->doc_creden_signer_no->getInputTextType() ?>" name="x_doc_creden_signer_no" id="x_doc_creden_signer_no" data-table="doc_creden_signer" data-field="x_doc_creden_signer_no" value="<?= $Page->doc_creden_signer_no->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->doc_creden_signer_no->getPlaceHolder()) ?>"<?= $Page->doc_creden_signer_no->editAttributes() ?> aria-describedby="x_doc_creden_signer_no_help">
<?= $Page->doc_creden_signer_no->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_creden_signer_no->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_creden_signer_link->Visible) { // doc_creden_signer_link ?>
    <div id="r_doc_creden_signer_link"<?= $Page->doc_creden_signer_link->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_signer_link" for="x_doc_creden_signer_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_signer_link->caption() ?><?= $Page->doc_creden_signer_link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_signer_link->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_link">
<input type="<?= $Page->doc_creden_signer_link->getInputTextType() ?>" name="x_doc_creden_signer_link" id="x_doc_creden_signer_link" data-table="doc_creden_signer" data-field="x_doc_creden_signer_link" value="<?= $Page->doc_creden_signer_link->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->doc_creden_signer_link->getPlaceHolder()) ?>"<?= $Page->doc_creden_signer_link->editAttributes() ?> aria-describedby="x_doc_creden_signer_link_help">
<?= $Page->doc_creden_signer_link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_creden_signer_link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_creden_signer_session->Visible) { // doc_creden_signer_session ?>
    <div id="r_doc_creden_signer_session"<?= $Page->doc_creden_signer_session->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_signer_session" for="x_doc_creden_signer_session" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_signer_session->caption() ?><?= $Page->doc_creden_signer_session->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_signer_session->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_session">
<input type="<?= $Page->doc_creden_signer_session->getInputTextType() ?>" name="x_doc_creden_signer_session" id="x_doc_creden_signer_session" data-table="doc_creden_signer" data-field="x_doc_creden_signer_session" value="<?= $Page->doc_creden_signer_session->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->doc_creden_signer_session->getPlaceHolder()) ?>"<?= $Page->doc_creden_signer_session->editAttributes() ?> aria-describedby="x_doc_creden_signer_session_help">
<?= $Page->doc_creden_signer_session->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_creden_signer_session->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_creden_signer_name->Visible) { // doc_creden_signer_name ?>
    <div id="r_doc_creden_signer_name"<?= $Page->doc_creden_signer_name->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_signer_name" for="x_doc_creden_signer_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_signer_name->caption() ?><?= $Page->doc_creden_signer_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_signer_name->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_name">
<input type="<?= $Page->doc_creden_signer_name->getInputTextType() ?>" name="x_doc_creden_signer_name" id="x_doc_creden_signer_name" data-table="doc_creden_signer" data-field="x_doc_creden_signer_name" value="<?= $Page->doc_creden_signer_name->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->doc_creden_signer_name->getPlaceHolder()) ?>"<?= $Page->doc_creden_signer_name->editAttributes() ?> aria-describedby="x_doc_creden_signer_name_help">
<?= $Page->doc_creden_signer_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_creden_signer_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_creden_signer_email->Visible) { // doc_creden_signer_email ?>
    <div id="r_doc_creden_signer_email"<?= $Page->doc_creden_signer_email->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_doc_creden_signer_email" for="x_doc_creden_signer_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_creden_signer_email->caption() ?><?= $Page->doc_creden_signer_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_creden_signer_email->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_email">
<input type="<?= $Page->doc_creden_signer_email->getInputTextType() ?>" name="x_doc_creden_signer_email" id="x_doc_creden_signer_email" data-table="doc_creden_signer" data-field="x_doc_creden_signer_email" value="<?= $Page->doc_creden_signer_email->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->doc_creden_signer_email->getPlaceHolder()) ?>"<?= $Page->doc_creden_signer_email->editAttributes() ?> aria-describedby="x_doc_creden_signer_email_help">
<?= $Page->doc_creden_signer_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_creden_signer_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_doc_creden_signer_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="doc_creden_signer" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_creden_signer_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="doc_creden_signer" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_creden_signeredit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_creden_signeredit", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_doc_creden_signer_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="doc_creden_signer" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_doc_creden_signer_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="doc_creden_signer" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <div id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_udate" for="x_udate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->udate->caption() ?><?= $Page->udate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->udate->cellAttributes() ?>>
<span id="el_doc_creden_signer_udate">
<input type="<?= $Page->udate->getInputTextType() ?>" name="x_udate" id="x_udate" data-table="doc_creden_signer" data-field="x_udate" value="<?= $Page->udate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->udate->getPlaceHolder()) ?>"<?= $Page->udate->editAttributes() ?> aria-describedby="x_udate_help">
<?= $Page->udate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->udate->getErrorMessage() ?></div>
<?php if (!$Page->udate->ReadOnly && !$Page->udate->Disabled && !isset($Page->udate->EditAttrs["readonly"]) && !isset($Page->udate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_creden_signeredit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_creden_signeredit", "x_udate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <div id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_uuser" for="x_uuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuser->caption() ?><?= $Page->uuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uuser->cellAttributes() ?>>
<span id="el_doc_creden_signer_uuser">
<input type="<?= $Page->uuser->getInputTextType() ?>" name="x_uuser" id="x_uuser" data-table="doc_creden_signer" data-field="x_uuser" value="<?= $Page->uuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->uuser->getPlaceHolder()) ?>"<?= $Page->uuser->editAttributes() ?> aria-describedby="x_uuser_help">
<?= $Page->uuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <div id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <label id="elh_doc_creden_signer_uip" for="x_uip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uip->caption() ?><?= $Page->uip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uip->cellAttributes() ?>>
<span id="el_doc_creden_signer_uip">
<input type="<?= $Page->uip->getInputTextType() ?>" name="x_uip" id="x_uip" data-table="doc_creden_signer" data-field="x_uip" value="<?= $Page->uip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->uip->getPlaceHolder()) ?>"<?= $Page->uip->editAttributes() ?> aria-describedby="x_uip_help">
<?= $Page->uip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uip->getErrorMessage() ?></div>
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
    ew.addEventHandlers("doc_creden_signer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
