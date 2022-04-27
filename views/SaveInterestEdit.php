<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveInterestEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { save_interest: currentTable } });
var currentForm, currentPageID;
var fsave_interestedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_interestedit = new ew.Form("fsave_interestedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fsave_interestedit;

    // Add fields
    var fields = currentTable.fields;
    fsave_interestedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["lat", [fields.lat.visible && fields.lat.required ? ew.Validators.required(fields.lat.caption) : null], fields.lat.isInvalid],
        ["lng", [fields.lng.visible && fields.lng.required ? ew.Validators.required(fields.lng.caption) : null], fields.lng.isInvalid],
        ["photo", [fields.photo.visible && fields.photo.required ? ew.Validators.required(fields.photo.caption) : null], fields.photo.isInvalid],
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["website", [fields.website.visible && fields.website.required ? ew.Validators.required(fields.website.caption) : null], fields.website.isInvalid],
        ["rating", [fields.rating.visible && fields.rating.required ? ew.Validators.required(fields.rating.caption) : null], fields.rating.isInvalid]
    ]);

    // Form_CustomValidate
    fsave_interestedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsave_interestedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fsave_interestedit");
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
<form name="fsave_interestedit" id="fsave_interestedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="save_interest">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_save_interest_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_save_interest_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->member_id->getDisplayValue($Page->member_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="save_interest" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_save_interest__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span id="el_save_interest__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="save_interest" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
    <div id="r_lat"<?= $Page->lat->rowAttributes() ?>>
        <label id="elh_save_interest_lat" for="x_lat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lat->caption() ?><?= $Page->lat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lat->cellAttributes() ?>>
<span id="el_save_interest_lat">
<input type="<?= $Page->lat->getInputTextType() ?>" name="x_lat" id="x_lat" data-table="save_interest" data-field="x_lat" value="<?= $Page->lat->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->lat->getPlaceHolder()) ?>"<?= $Page->lat->editAttributes() ?> aria-describedby="x_lat_help">
<?= $Page->lat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lng->Visible) { // lng ?>
    <div id="r_lng"<?= $Page->lng->rowAttributes() ?>>
        <label id="elh_save_interest_lng" for="x_lng" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lng->caption() ?><?= $Page->lng->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lng->cellAttributes() ?>>
<span id="el_save_interest_lng">
<input type="<?= $Page->lng->getInputTextType() ?>" name="x_lng" id="x_lng" data-table="save_interest" data-field="x_lng" value="<?= $Page->lng->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->lng->getPlaceHolder()) ?>"<?= $Page->lng->editAttributes() ?> aria-describedby="x_lng_help">
<?= $Page->lng->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lng->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <div id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <label id="elh_save_interest_photo" for="x_photo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->photo->caption() ?><?= $Page->photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->photo->cellAttributes() ?>>
<span id="el_save_interest_photo">
<textarea data-table="save_interest" data-field="x_photo" name="x_photo" id="x_photo" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->photo->getPlaceHolder()) ?>"<?= $Page->photo->editAttributes() ?> aria-describedby="x_photo_help"><?= $Page->photo->EditValue ?></textarea>
<?= $Page->photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->photo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_save_interest_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_save_interest_address">
<textarea data-table="save_interest" data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help"><?= $Page->address->EditValue ?></textarea>
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website"<?= $Page->website->rowAttributes() ?>>
        <label id="elh_save_interest_website" for="x_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->website->cellAttributes() ?>>
<span id="el_save_interest_website">
<textarea data-table="save_interest" data-field="x_website" name="x_website" id="x_website" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>"<?= $Page->website->editAttributes() ?> aria-describedby="x_website_help"><?= $Page->website->EditValue ?></textarea>
<?= $Page->website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
    <div id="r_rating"<?= $Page->rating->rowAttributes() ?>>
        <label id="elh_save_interest_rating" for="x_rating" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rating->caption() ?><?= $Page->rating->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rating->cellAttributes() ?>>
<span id="el_save_interest_rating">
<input type="<?= $Page->rating->getInputTextType() ?>" name="x_rating" id="x_rating" data-table="save_interest" data-field="x_rating" value="<?= $Page->rating->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->rating->getPlaceHolder()) ?>"<?= $Page->rating->editAttributes() ?> aria-describedby="x_rating_help">
<?= $Page->rating->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rating->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="save_interest" data-field="x_save_interest_id" data-hidden="1" name="x_save_interest_id" id="x_save_interest_id" value="<?= HtmlEncode($Page->save_interest_id->CurrentValue) ?>">
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
    ew.addEventHandlers("save_interest");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
