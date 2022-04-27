<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveLogSearchNonmemberEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { save_log_search_nonmember: currentTable } });
var currentForm, currentPageID;
var fsave_log_search_nonmemberedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_log_search_nonmemberedit = new ew.Form("fsave_log_search_nonmemberedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fsave_log_search_nonmemberedit;

    // Add fields
    var fields = currentTable.fields;
    fsave_log_search_nonmemberedit.addFields([
        ["save_log_search_nonmember_id", [fields.save_log_search_nonmember_id.visible && fields.save_log_search_nonmember_id.required ? ew.Validators.required(fields.save_log_search_nonmember_id.caption) : null], fields.save_log_search_nonmember_id.isInvalid],
        ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null, ew.Validators.integer], fields.category_id.isInvalid],
        ["min_installment", [fields.min_installment.visible && fields.min_installment.required ? ew.Validators.required(fields.min_installment.caption) : null, ew.Validators.float], fields.min_installment.isInvalid],
        ["max_installment", [fields.max_installment.visible && fields.max_installment.required ? ew.Validators.required(fields.max_installment.caption) : null, ew.Validators.float], fields.max_installment.isInvalid],
        ["attribute_detail_id", [fields.attribute_detail_id.visible && fields.attribute_detail_id.required ? ew.Validators.required(fields.attribute_detail_id.caption) : null, ew.Validators.integer], fields.attribute_detail_id.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null], fields.latitude.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null], fields.longitude.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["first_name", [fields.first_name.visible && fields.first_name.required ? ew.Validators.required(fields.first_name.caption) : null], fields.first_name.isInvalid],
        ["last_name", [fields.last_name.visible && fields.last_name.required ? ew.Validators.required(fields.last_name.caption) : null], fields.last_name.isInvalid]
    ]);

    // Form_CustomValidate
    fsave_log_search_nonmemberedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsave_log_search_nonmemberedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fsave_log_search_nonmemberedit");
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
<form name="fsave_log_search_nonmemberedit" id="fsave_log_search_nonmemberedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="save_log_search_nonmember">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->save_log_search_nonmember_id->Visible) { // save_log_search_nonmember_id ?>
    <div id="r_save_log_search_nonmember_id"<?= $Page->save_log_search_nonmember_id->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_save_log_search_nonmember_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->save_log_search_nonmember_id->caption() ?><?= $Page->save_log_search_nonmember_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->save_log_search_nonmember_id->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_save_log_search_nonmember_id">
<span<?= $Page->save_log_search_nonmember_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->save_log_search_nonmember_id->getDisplayValue($Page->save_log_search_nonmember_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="save_log_search_nonmember" data-field="x_save_log_search_nonmember_id" data-hidden="1" name="x_save_log_search_nonmember_id" id="x_save_log_search_nonmember_id" value="<?= HtmlEncode($Page->save_log_search_nonmember_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
    <div id="r_category_id"<?= $Page->category_id->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_category_id" for="x_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_id->caption() ?><?= $Page->category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_id->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_category_id">
<input type="<?= $Page->category_id->getInputTextType() ?>" name="x_category_id" id="x_category_id" data-table="save_log_search_nonmember" data-field="x_category_id" value="<?= $Page->category_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->category_id->getPlaceHolder()) ?>"<?= $Page->category_id->editAttributes() ?> aria-describedby="x_category_id_help">
<?= $Page->category_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->category_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->min_installment->Visible) { // min_installment ?>
    <div id="r_min_installment"<?= $Page->min_installment->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_min_installment" for="x_min_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->min_installment->caption() ?><?= $Page->min_installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->min_installment->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_min_installment">
<input type="<?= $Page->min_installment->getInputTextType() ?>" name="x_min_installment" id="x_min_installment" data-table="save_log_search_nonmember" data-field="x_min_installment" value="<?= $Page->min_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->min_installment->getPlaceHolder()) ?>"<?= $Page->min_installment->editAttributes() ?> aria-describedby="x_min_installment_help">
<?= $Page->min_installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->min_installment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
    <div id="r_max_installment"<?= $Page->max_installment->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_max_installment" for="x_max_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->max_installment->caption() ?><?= $Page->max_installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->max_installment->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_max_installment">
<input type="<?= $Page->max_installment->getInputTextType() ?>" name="x_max_installment" id="x_max_installment" data-table="save_log_search_nonmember" data-field="x_max_installment" value="<?= $Page->max_installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->max_installment->getPlaceHolder()) ?>"<?= $Page->max_installment->editAttributes() ?> aria-describedby="x_max_installment_help">
<?= $Page->max_installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->max_installment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->attribute_detail_id->Visible) { // attribute_detail_id ?>
    <div id="r_attribute_detail_id"<?= $Page->attribute_detail_id->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_attribute_detail_id" for="x_attribute_detail_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->attribute_detail_id->caption() ?><?= $Page->attribute_detail_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->attribute_detail_id->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_attribute_detail_id">
<input type="<?= $Page->attribute_detail_id->getInputTextType() ?>" name="x_attribute_detail_id" id="x_attribute_detail_id" data-table="save_log_search_nonmember" data-field="x_attribute_detail_id" value="<?= $Page->attribute_detail_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->attribute_detail_id->getPlaceHolder()) ?>"<?= $Page->attribute_detail_id->editAttributes() ?> aria-describedby="x_attribute_detail_id_help">
<?= $Page->attribute_detail_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->attribute_detail_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <div id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_latitude" for="x_latitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->latitude->caption() ?><?= $Page->latitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->latitude->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_latitude">
<textarea data-table="save_log_search_nonmember" data-field="x_latitude" name="x_latitude" id="x_latitude" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->latitude->getPlaceHolder()) ?>"<?= $Page->latitude->editAttributes() ?> aria-describedby="x_latitude_help"><?= $Page->latitude->EditValue ?></textarea>
<?= $Page->latitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->latitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <div id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_longitude" for="x_longitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->longitude->caption() ?><?= $Page->longitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->longitude->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_longitude">
<textarea data-table="save_log_search_nonmember" data-field="x_longitude" name="x_longitude" id="x_longitude" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->longitude->getPlaceHolder()) ?>"<?= $Page->longitude->editAttributes() ?> aria-describedby="x_longitude_help"><?= $Page->longitude->EditValue ?></textarea>
<?= $Page->longitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->longitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_save_log_search_nonmember__email">
<textarea data-table="save_log_search_nonmember" data-field="x__email" name="x__email" id="x__email" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help"><?= $Page->_email->EditValue ?></textarea>
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_phone">
<textarea data-table="save_log_search_nonmember" data-field="x_phone" name="x_phone" id="x_phone" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>"<?= $Page->phone->editAttributes() ?> aria-describedby="x_phone_help"><?= $Page->phone->EditValue ?></textarea>
<?= $Page->phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="save_log_search_nonmember" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsave_log_search_nonmemberedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsave_log_search_nonmemberedit", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="save_log_search_nonmember" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="save_log_search_nonmember" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
    <div id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_first_name" for="x_first_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_name->caption() ?><?= $Page->first_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_name->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_first_name">
<input type="<?= $Page->first_name->getInputTextType() ?>" name="x_first_name" id="x_first_name" data-table="save_log_search_nonmember" data-field="x_first_name" value="<?= $Page->first_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->first_name->getPlaceHolder()) ?>"<?= $Page->first_name->editAttributes() ?> aria-describedby="x_first_name_help">
<?= $Page->first_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <div id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <label id="elh_save_log_search_nonmember_last_name" for="x_last_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_name->caption() ?><?= $Page->last_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_name->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_last_name">
<input type="<?= $Page->last_name->getInputTextType() ?>" name="x_last_name" id="x_last_name" data-table="save_log_search_nonmember" data-field="x_last_name" value="<?= $Page->last_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->last_name->getPlaceHolder()) ?>"<?= $Page->last_name->editAttributes() ?> aria-describedby="x_last_name_help">
<?= $Page->last_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_name->getErrorMessage() ?></div>
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
    ew.addEventHandlers("save_log_search_nonmember");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
