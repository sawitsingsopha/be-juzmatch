<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden: currentTable } });
var currentForm, currentPageID;
var fdoc_credenadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_credenadd = new ew.Form("fdoc_credenadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fdoc_credenadd;

    // Add fields
    var fields = currentTable.fields;
    fdoc_credenadd.addFields([
        ["document_id", [fields.document_id.visible && fields.document_id.required ? ew.Validators.required(fields.document_id.caption) : null], fields.document_id.isInvalid],
        ["doc_temp_id", [fields.doc_temp_id.visible && fields.doc_temp_id.required ? ew.Validators.required(fields.doc_temp_id.caption) : null, ew.Validators.integer], fields.doc_temp_id.isInvalid],
        ["txid", [fields.txid.visible && fields.txid.required ? ew.Validators.required(fields.txid.caption) : null], fields.txid.isInvalid],
        ["subject", [fields.subject.visible && fields.subject.required ? ew.Validators.required(fields.subject.caption) : null], fields.subject.isInvalid],
        ["send_email", [fields.send_email.visible && fields.send_email.required ? ew.Validators.required(fields.send_email.caption) : null], fields.send_email.isInvalid],
        ["redirect_url", [fields.redirect_url.visible && fields.redirect_url.required ? ew.Validators.required(fields.redirect_url.caption) : null], fields.redirect_url.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null, ew.Validators.integer], fields.status.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null, ew.Validators.datetime(fields.udate.clientFormatPattern)], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["doc_url", [fields.doc_url.visible && fields.doc_url.required ? ew.Validators.required(fields.doc_url.caption) : null], fields.doc_url.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_credenadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_credenadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fdoc_credenadd");
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
<form name="fdoc_credenadd" id="fdoc_credenadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->document_id->Visible) { // document_id ?>
    <div id="r_document_id"<?= $Page->document_id->rowAttributes() ?>>
        <label id="elh_doc_creden_document_id" for="x_document_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->document_id->caption() ?><?= $Page->document_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->document_id->cellAttributes() ?>>
<span id="el_doc_creden_document_id">
<input type="<?= $Page->document_id->getInputTextType() ?>" name="x_document_id" id="x_document_id" data-table="doc_creden" data-field="x_document_id" value="<?= $Page->document_id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->document_id->getPlaceHolder()) ?>"<?= $Page->document_id->editAttributes() ?> aria-describedby="x_document_id_help">
<?= $Page->document_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->document_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_temp_id->Visible) { // doc_temp_id ?>
    <div id="r_doc_temp_id"<?= $Page->doc_temp_id->rowAttributes() ?>>
        <label id="elh_doc_creden_doc_temp_id" for="x_doc_temp_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_temp_id->caption() ?><?= $Page->doc_temp_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_temp_id->cellAttributes() ?>>
<span id="el_doc_creden_doc_temp_id">
<input type="<?= $Page->doc_temp_id->getInputTextType() ?>" name="x_doc_temp_id" id="x_doc_temp_id" data-table="doc_creden" data-field="x_doc_temp_id" value="<?= $Page->doc_temp_id->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->doc_temp_id->getPlaceHolder()) ?>"<?= $Page->doc_temp_id->editAttributes() ?> aria-describedby="x_doc_temp_id_help">
<?= $Page->doc_temp_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_temp_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->txid->Visible) { // txid ?>
    <div id="r_txid"<?= $Page->txid->rowAttributes() ?>>
        <label id="elh_doc_creden_txid" for="x_txid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->txid->caption() ?><?= $Page->txid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->txid->cellAttributes() ?>>
<span id="el_doc_creden_txid">
<input type="<?= $Page->txid->getInputTextType() ?>" name="x_txid" id="x_txid" data-table="doc_creden" data-field="x_txid" value="<?= $Page->txid->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->txid->getPlaceHolder()) ?>"<?= $Page->txid->editAttributes() ?> aria-describedby="x_txid_help">
<?= $Page->txid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->txid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
    <div id="r_subject"<?= $Page->subject->rowAttributes() ?>>
        <label id="elh_doc_creden_subject" for="x_subject" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subject->caption() ?><?= $Page->subject->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subject->cellAttributes() ?>>
<span id="el_doc_creden_subject">
<input type="<?= $Page->subject->getInputTextType() ?>" name="x_subject" id="x_subject" data-table="doc_creden" data-field="x_subject" value="<?= $Page->subject->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->subject->getPlaceHolder()) ?>"<?= $Page->subject->editAttributes() ?> aria-describedby="x_subject_help">
<?= $Page->subject->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subject->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->send_email->Visible) { // send_email ?>
    <div id="r_send_email"<?= $Page->send_email->rowAttributes() ?>>
        <label id="elh_doc_creden_send_email" for="x_send_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->send_email->caption() ?><?= $Page->send_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->send_email->cellAttributes() ?>>
<span id="el_doc_creden_send_email">
<input type="<?= $Page->send_email->getInputTextType() ?>" name="x_send_email" id="x_send_email" data-table="doc_creden" data-field="x_send_email" value="<?= $Page->send_email->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->send_email->getPlaceHolder()) ?>"<?= $Page->send_email->editAttributes() ?> aria-describedby="x_send_email_help">
<?= $Page->send_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->send_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->redirect_url->Visible) { // redirect_url ?>
    <div id="r_redirect_url"<?= $Page->redirect_url->rowAttributes() ?>>
        <label id="elh_doc_creden_redirect_url" for="x_redirect_url" class="<?= $Page->LeftColumnClass ?>"><?= $Page->redirect_url->caption() ?><?= $Page->redirect_url->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->redirect_url->cellAttributes() ?>>
<span id="el_doc_creden_redirect_url">
<input type="<?= $Page->redirect_url->getInputTextType() ?>" name="x_redirect_url" id="x_redirect_url" data-table="doc_creden" data-field="x_redirect_url" value="<?= $Page->redirect_url->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->redirect_url->getPlaceHolder()) ?>"<?= $Page->redirect_url->editAttributes() ?> aria-describedby="x_redirect_url_help">
<?= $Page->redirect_url->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->redirect_url->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_doc_creden_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_doc_creden_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="doc_creden" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_doc_creden_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_creden_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="doc_creden" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_credenadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_credenadd", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_doc_creden_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_doc_creden_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="doc_creden" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_doc_creden_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_doc_creden_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="doc_creden" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <div id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <label id="elh_doc_creden_udate" for="x_udate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->udate->caption() ?><?= $Page->udate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->udate->cellAttributes() ?>>
<span id="el_doc_creden_udate">
<input type="<?= $Page->udate->getInputTextType() ?>" name="x_udate" id="x_udate" data-table="doc_creden" data-field="x_udate" value="<?= $Page->udate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->udate->getPlaceHolder()) ?>"<?= $Page->udate->editAttributes() ?> aria-describedby="x_udate_help">
<?= $Page->udate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->udate->getErrorMessage() ?></div>
<?php if (!$Page->udate->ReadOnly && !$Page->udate->Disabled && !isset($Page->udate->EditAttrs["readonly"]) && !isset($Page->udate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_credenadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_credenadd", "x_udate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <div id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <label id="elh_doc_creden_uuser" for="x_uuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuser->caption() ?><?= $Page->uuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uuser->cellAttributes() ?>>
<span id="el_doc_creden_uuser">
<input type="<?= $Page->uuser->getInputTextType() ?>" name="x_uuser" id="x_uuser" data-table="doc_creden" data-field="x_uuser" value="<?= $Page->uuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->uuser->getPlaceHolder()) ?>"<?= $Page->uuser->editAttributes() ?> aria-describedby="x_uuser_help">
<?= $Page->uuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <div id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <label id="elh_doc_creden_uip" for="x_uip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uip->caption() ?><?= $Page->uip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uip->cellAttributes() ?>>
<span id="el_doc_creden_uip">
<input type="<?= $Page->uip->getInputTextType() ?>" name="x_uip" id="x_uip" data-table="doc_creden" data-field="x_uip" value="<?= $Page->uip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->uip->getPlaceHolder()) ?>"<?= $Page->uip->editAttributes() ?> aria-describedby="x_uip_help">
<?= $Page->uip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_url->Visible) { // doc_url ?>
    <div id="r_doc_url"<?= $Page->doc_url->rowAttributes() ?>>
        <label id="elh_doc_creden_doc_url" for="x_doc_url" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_url->caption() ?><?= $Page->doc_url->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_url->cellAttributes() ?>>
<span id="el_doc_creden_doc_url">
<input type="<?= $Page->doc_url->getInputTextType() ?>" name="x_doc_url" id="x_doc_url" data-table="doc_creden" data-field="x_doc_url" value="<?= $Page->doc_url->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->doc_url->getPlaceHolder()) ?>"<?= $Page->doc_url->editAttributes() ?> aria-describedby="x_doc_url_help">
<?= $Page->doc_url->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_url->getErrorMessage() ?></div>
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
    ew.addEventHandlers("doc_creden");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
