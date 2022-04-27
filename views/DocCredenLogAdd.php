<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenLogAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_log: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_logadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_logadd = new ew.Form("fdoc_creden_logadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fdoc_creden_logadd;

    // Add fields
    var fields = currentTable.fields;
    fdoc_creden_logadd.addFields([
        ["__request", [fields.__request.visible && fields.__request.required ? ew.Validators.required(fields.__request.caption) : null], fields.__request.isInvalid],
        ["_response", [fields._response.visible && fields._response.required ? ew.Validators.required(fields._response.caption) : null], fields._response.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["url", [fields.url.visible && fields.url.required ? ew.Validators.required(fields.url.caption) : null], fields.url.isInvalid],
        ["pdfbase64", [fields.pdfbase64.visible && fields.pdfbase64.required ? ew.Validators.required(fields.pdfbase64.caption) : null], fields.pdfbase64.isInvalid],
        ["request_header", [fields.request_header.visible && fields.request_header.required ? ew.Validators.required(fields.request_header.caption) : null], fields.request_header.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_creden_logadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_creden_logadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fdoc_creden_logadd");
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
<form name="fdoc_creden_logadd" id="fdoc_creden_logadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_log">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->__request->Visible) { // request ?>
    <div id="r___request"<?= $Page->__request->rowAttributes() ?>>
        <label id="elh_doc_creden_log___request" for="x___request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->__request->caption() ?><?= $Page->__request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->__request->cellAttributes() ?>>
<span id="el_doc_creden_log___request">
<textarea data-table="doc_creden_log" data-field="x___request" name="x___request" id="x___request" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->__request->getPlaceHolder()) ?>"<?= $Page->__request->editAttributes() ?> aria-describedby="x___request_help"><?= $Page->__request->EditValue ?></textarea>
<?= $Page->__request->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->__request->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_response->Visible) { // response ?>
    <div id="r__response"<?= $Page->_response->rowAttributes() ?>>
        <label id="elh_doc_creden_log__response" for="x__response" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_response->caption() ?><?= $Page->_response->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_response->cellAttributes() ?>>
<span id="el_doc_creden_log__response">
<textarea data-table="doc_creden_log" data-field="x__response" name="x__response" id="x__response" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_response->getPlaceHolder()) ?>"<?= $Page->_response->editAttributes() ?> aria-describedby="x__response_help"><?= $Page->_response->EditValue ?></textarea>
<?= $Page->_response->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_response->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_doc_creden_log_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_creden_log_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="doc_creden_log" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdoc_creden_logadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdoc_creden_logadd", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->url->Visible) { // url ?>
    <div id="r_url"<?= $Page->url->rowAttributes() ?>>
        <label id="elh_doc_creden_log_url" for="x_url" class="<?= $Page->LeftColumnClass ?>"><?= $Page->url->caption() ?><?= $Page->url->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->url->cellAttributes() ?>>
<span id="el_doc_creden_log_url">
<input type="<?= $Page->url->getInputTextType() ?>" name="x_url" id="x_url" data-table="doc_creden_log" data-field="x_url" value="<?= $Page->url->EditValue ?>" size="30" maxlength="500" placeholder="<?= HtmlEncode($Page->url->getPlaceHolder()) ?>"<?= $Page->url->editAttributes() ?> aria-describedby="x_url_help">
<?= $Page->url->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->url->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pdfbase64->Visible) { // pdfbase64 ?>
    <div id="r_pdfbase64"<?= $Page->pdfbase64->rowAttributes() ?>>
        <label id="elh_doc_creden_log_pdfbase64" for="x_pdfbase64" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pdfbase64->caption() ?><?= $Page->pdfbase64->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pdfbase64->cellAttributes() ?>>
<span id="el_doc_creden_log_pdfbase64">
<textarea data-table="doc_creden_log" data-field="x_pdfbase64" name="x_pdfbase64" id="x_pdfbase64" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->pdfbase64->getPlaceHolder()) ?>"<?= $Page->pdfbase64->editAttributes() ?> aria-describedby="x_pdfbase64_help"><?= $Page->pdfbase64->EditValue ?></textarea>
<?= $Page->pdfbase64->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pdfbase64->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->request_header->Visible) { // request_header ?>
    <div id="r_request_header"<?= $Page->request_header->rowAttributes() ?>>
        <label id="elh_doc_creden_log_request_header" for="x_request_header" class="<?= $Page->LeftColumnClass ?>"><?= $Page->request_header->caption() ?><?= $Page->request_header->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->request_header->cellAttributes() ?>>
<span id="el_doc_creden_log_request_header">
<textarea data-table="doc_creden_log" data-field="x_request_header" name="x_request_header" id="x_request_header" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->request_header->getPlaceHolder()) ?>"<?= $Page->request_header->editAttributes() ?> aria-describedby="x_request_header_help"><?= $Page->request_header->EditValue ?></textarea>
<?= $Page->request_header->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->request_header->getErrorMessage() ?></div>
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
    ew.addEventHandlers("doc_creden_log");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
