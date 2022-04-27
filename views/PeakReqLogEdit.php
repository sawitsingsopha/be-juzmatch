<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakReqLogEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_req_log: currentTable } });
var currentForm, currentPageID;
var fpeak_req_logedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_req_logedit = new ew.Form("fpeak_req_logedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpeak_req_logedit;

    // Add fields
    var fields = currentTable.fields;
    fpeak_req_logedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["req_date", [fields.req_date.visible && fields.req_date.required ? ew.Validators.required(fields.req_date.caption) : null, ew.Validators.datetime(fields.req_date.clientFormatPattern)], fields.req_date.isInvalid],
        ["req_config", [fields.req_config.visible && fields.req_config.required ? ew.Validators.required(fields.req_config.caption) : null], fields.req_config.isInvalid],
        ["req_response", [fields.req_response.visible && fields.req_response.required ? ew.Validators.required(fields.req_response.caption) : null], fields.req_response.isInvalid],
        ["error_message", [fields.error_message.visible && fields.error_message.required ? ew.Validators.required(fields.error_message.caption) : null], fields.error_message.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_req_logedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_req_logedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fpeak_req_logedit");
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
<form name="fpeak_req_logedit" id="fpeak_req_logedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_req_log">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_peak_req_log_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_req_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="peak_req_log" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->req_date->Visible) { // req_date ?>
    <div id="r_req_date"<?= $Page->req_date->rowAttributes() ?>>
        <label id="elh_peak_req_log_req_date" for="x_req_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->req_date->caption() ?><?= $Page->req_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->req_date->cellAttributes() ?>>
<span id="el_peak_req_log_req_date">
<input type="<?= $Page->req_date->getInputTextType() ?>" name="x_req_date" id="x_req_date" data-table="peak_req_log" data-field="x_req_date" value="<?= $Page->req_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->req_date->getPlaceHolder()) ?>"<?= $Page->req_date->editAttributes() ?> aria-describedby="x_req_date_help">
<?= $Page->req_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->req_date->getErrorMessage() ?></div>
<?php if (!$Page->req_date->ReadOnly && !$Page->req_date->Disabled && !isset($Page->req_date->EditAttrs["readonly"]) && !isset($Page->req_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_req_logedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_req_logedit", "x_req_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->req_config->Visible) { // req_config ?>
    <div id="r_req_config"<?= $Page->req_config->rowAttributes() ?>>
        <label id="elh_peak_req_log_req_config" for="x_req_config" class="<?= $Page->LeftColumnClass ?>"><?= $Page->req_config->caption() ?><?= $Page->req_config->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->req_config->cellAttributes() ?>>
<span id="el_peak_req_log_req_config">
<textarea data-table="peak_req_log" data-field="x_req_config" name="x_req_config" id="x_req_config" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->req_config->getPlaceHolder()) ?>"<?= $Page->req_config->editAttributes() ?> aria-describedby="x_req_config_help"><?= $Page->req_config->EditValue ?></textarea>
<?= $Page->req_config->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->req_config->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->req_response->Visible) { // req_response ?>
    <div id="r_req_response"<?= $Page->req_response->rowAttributes() ?>>
        <label id="elh_peak_req_log_req_response" for="x_req_response" class="<?= $Page->LeftColumnClass ?>"><?= $Page->req_response->caption() ?><?= $Page->req_response->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->req_response->cellAttributes() ?>>
<span id="el_peak_req_log_req_response">
<textarea data-table="peak_req_log" data-field="x_req_response" name="x_req_response" id="x_req_response" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->req_response->getPlaceHolder()) ?>"<?= $Page->req_response->editAttributes() ?> aria-describedby="x_req_response_help"><?= $Page->req_response->EditValue ?></textarea>
<?= $Page->req_response->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->req_response->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->error_message->Visible) { // error_message ?>
    <div id="r_error_message"<?= $Page->error_message->rowAttributes() ?>>
        <label id="elh_peak_req_log_error_message" for="x_error_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->error_message->caption() ?><?= $Page->error_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->error_message->cellAttributes() ?>>
<span id="el_peak_req_log_error_message">
<textarea data-table="peak_req_log" data-field="x_error_message" name="x_error_message" id="x_error_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->error_message->getPlaceHolder()) ?>"<?= $Page->error_message->editAttributes() ?> aria-describedby="x_error_message_help"><?= $Page->error_message->EditValue ?></textarea>
<?= $Page->error_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->error_message->getErrorMessage() ?></div>
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
    ew.addEventHandlers("peak_req_log");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
