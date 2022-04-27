<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member: currentTable } });
var currentForm, currentPageID;
var fmemberedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmemberedit = new ew.Form("fmemberedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fmemberedit;

    // Add fields
    var fields = currentTable.fields;
    fmemberedit.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["first_name", [fields.first_name.visible && fields.first_name.required ? ew.Validators.required(fields.first_name.caption) : null], fields.first_name.isInvalid],
        ["last_name", [fields.last_name.visible && fields.last_name.required ? ew.Validators.required(fields.last_name.caption) : null], fields.last_name.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
        ["facebook_id", [fields.facebook_id.visible && fields.facebook_id.required ? ew.Validators.required(fields.facebook_id.caption) : null], fields.facebook_id.isInvalid],
        ["line_id", [fields.line_id.visible && fields.line_id.required ? ew.Validators.required(fields.line_id.caption) : null], fields.line_id.isInvalid],
        ["google_id", [fields.google_id.visible && fields.google_id.required ? ew.Validators.required(fields.google_id.caption) : null], fields.google_id.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
        ["isactive", [fields.isactive.visible && fields.isactive.required ? ew.Validators.required(fields.isactive.caption) : null], fields.isactive.isInvalid],
        ["isbuyer", [fields.isbuyer.visible && fields.isbuyer.required ? ew.Validators.required(fields.isbuyer.caption) : null], fields.isbuyer.isInvalid],
        ["isinvertor", [fields.isinvertor.visible && fields.isinvertor.required ? ew.Validators.required(fields.isinvertor.caption) : null], fields.isinvertor.isInvalid],
        ["issale", [fields.issale.visible && fields.issale.required ? ew.Validators.required(fields.issale.caption) : null], fields.issale.isInvalid],
        ["isnotification", [fields.isnotification.visible && fields.isnotification.required ? ew.Validators.required(fields.isnotification.caption) : null], fields.isnotification.isInvalid],
        ["image_profile", [fields.image_profile.visible && fields.image_profile.required ? ew.Validators.fileRequired(fields.image_profile.caption) : null], fields.image_profile.isInvalid]
    ]);

    // Form_CustomValidate
    fmemberedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmemberedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fmemberedit.lists.isactive = <?= $Page->isactive->toClientList($Page) ?>;
    fmemberedit.lists.isbuyer = <?= $Page->isbuyer->toClientList($Page) ?>;
    fmemberedit.lists.isinvertor = <?= $Page->isinvertor->toClientList($Page) ?>;
    fmemberedit.lists.issale = <?= $Page->issale->toClientList($Page) ?>;
    fmemberedit.lists.isnotification = <?= $Page->isnotification->toClientList($Page) ?>;
    loadjs.done("fmemberedit");
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
<form name="fmemberedit" id="fmemberedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_member_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_member_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->member_id->getDisplayValue($Page->member_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="member" data-field="x_member_id" data-hidden="1" name="x_member_id" id="x_member_id" value="<?= HtmlEncode($Page->member_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
    <div id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <label id="elh_member_first_name" for="x_first_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_name->caption() ?><?= $Page->first_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_name->cellAttributes() ?>>
<span id="el_member_first_name">
<input type="<?= $Page->first_name->getInputTextType() ?>" name="x_first_name" id="x_first_name" data-table="member" data-field="x_first_name" value="<?= $Page->first_name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->first_name->getPlaceHolder()) ?>"<?= $Page->first_name->editAttributes() ?> aria-describedby="x_first_name_help">
<?= $Page->first_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <div id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <label id="elh_member_last_name" for="x_last_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_name->caption() ?><?= $Page->last_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_name->cellAttributes() ?>>
<span id="el_member_last_name">
<input type="<?= $Page->last_name->getInputTextType() ?>" name="x_last_name" id="x_last_name" data-table="member" data-field="x_last_name" value="<?= $Page->last_name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->last_name->getPlaceHolder()) ?>"<?= $Page->last_name->editAttributes() ?> aria-describedby="x_last_name_help">
<?= $Page->last_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_member__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_member__email">
<span<?= $Page->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_email->getDisplayValue($Page->_email->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="member" data-field="x__email" data-hidden="1" name="x__email" id="x__email" value="<?= HtmlEncode($Page->_email->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_member_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<span id="el_member_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->phone->getDisplayValue($Page->phone->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="member" data-field="x_phone" data-hidden="1" name="x_phone" id="x_phone" value="<?= HtmlEncode($Page->phone->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->facebook_id->Visible) { // facebook_id ?>
    <div id="r_facebook_id"<?= $Page->facebook_id->rowAttributes() ?>>
        <label id="elh_member_facebook_id" for="x_facebook_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->facebook_id->caption() ?><?= $Page->facebook_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->facebook_id->cellAttributes() ?>>
<span id="el_member_facebook_id">
<span<?= $Page->facebook_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->facebook_id->getDisplayValue($Page->facebook_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="member" data-field="x_facebook_id" data-hidden="1" name="x_facebook_id" id="x_facebook_id" value="<?= HtmlEncode($Page->facebook_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->line_id->Visible) { // line_id ?>
    <div id="r_line_id"<?= $Page->line_id->rowAttributes() ?>>
        <label id="elh_member_line_id" for="x_line_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->line_id->caption() ?><?= $Page->line_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->line_id->cellAttributes() ?>>
<span id="el_member_line_id">
<span<?= $Page->line_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->line_id->getDisplayValue($Page->line_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="member" data-field="x_line_id" data-hidden="1" name="x_line_id" id="x_line_id" value="<?= HtmlEncode($Page->line_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->google_id->Visible) { // google_id ?>
    <div id="r_google_id"<?= $Page->google_id->rowAttributes() ?>>
        <label id="elh_member_google_id" for="x_google_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->google_id->caption() ?><?= $Page->google_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->google_id->cellAttributes() ?>>
<span id="el_member_google_id">
<span<?= $Page->google_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->google_id->getDisplayValue($Page->google_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="member" data-field="x_google_id" data-hidden="1" name="x_google_id" id="x_google_id" value="<?= HtmlEncode($Page->google_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_member_type" for="x_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_member_type">
<span<?= $Page->type->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->type->getDisplayValue($Page->type->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="member" data-field="x_type" data-hidden="1" name="x_type" id="x_type" value="<?= HtmlEncode($Page->type->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <div id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <label id="elh_member_isactive" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isactive->caption() ?><?= $Page->isactive->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isactive->cellAttributes() ?>>
<span id="el_member_isactive">
<template id="tp_x_isactive">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="member" data-field="x_isactive" name="x_isactive" id="x_isactive"<?= $Page->isactive->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_isactive" class="ew-item-list"></div>
<selection-list hidden
    id="x_isactive"
    name="x_isactive"
    value="<?= HtmlEncode($Page->isactive->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_isactive"
    data-bs-target="dsl_x_isactive"
    data-repeatcolumn="5"
    class="form-control<?= $Page->isactive->isInvalidClass() ?>"
    data-table="member"
    data-field="x_isactive"
    data-value-separator="<?= $Page->isactive->displayValueSeparatorAttribute() ?>"
    <?= $Page->isactive->editAttributes() ?>></selection-list>
<?= $Page->isactive->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isactive->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isbuyer->Visible) { // isbuyer ?>
    <div id="r_isbuyer"<?= $Page->isbuyer->rowAttributes() ?>>
        <label id="elh_member_isbuyer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isbuyer->caption() ?><?= $Page->isbuyer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isbuyer->cellAttributes() ?>>
<span id="el_member_isbuyer">
<template id="tp_x_isbuyer">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="member" data-field="x_isbuyer" name="x_isbuyer" id="x_isbuyer"<?= $Page->isbuyer->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_isbuyer" class="ew-item-list"></div>
<selection-list hidden
    id="x_isbuyer[]"
    name="x_isbuyer[]"
    value="<?= HtmlEncode($Page->isbuyer->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_isbuyer"
    data-bs-target="dsl_x_isbuyer"
    data-repeatcolumn="5"
    class="form-control<?= $Page->isbuyer->isInvalidClass() ?>"
    data-table="member"
    data-field="x_isbuyer"
    data-value-separator="<?= $Page->isbuyer->displayValueSeparatorAttribute() ?>"
    <?= $Page->isbuyer->editAttributes() ?>></selection-list>
<?= $Page->isbuyer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isbuyer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isinvertor->Visible) { // isinvertor ?>
    <div id="r_isinvertor"<?= $Page->isinvertor->rowAttributes() ?>>
        <label id="elh_member_isinvertor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isinvertor->caption() ?><?= $Page->isinvertor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isinvertor->cellAttributes() ?>>
<span id="el_member_isinvertor">
<template id="tp_x_isinvertor">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="member" data-field="x_isinvertor" name="x_isinvertor" id="x_isinvertor"<?= $Page->isinvertor->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_isinvertor" class="ew-item-list"></div>
<selection-list hidden
    id="x_isinvertor[]"
    name="x_isinvertor[]"
    value="<?= HtmlEncode($Page->isinvertor->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_isinvertor"
    data-bs-target="dsl_x_isinvertor"
    data-repeatcolumn="5"
    class="form-control<?= $Page->isinvertor->isInvalidClass() ?>"
    data-table="member"
    data-field="x_isinvertor"
    data-value-separator="<?= $Page->isinvertor->displayValueSeparatorAttribute() ?>"
    <?= $Page->isinvertor->editAttributes() ?>></selection-list>
<?= $Page->isinvertor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isinvertor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->issale->Visible) { // issale ?>
    <div id="r_issale"<?= $Page->issale->rowAttributes() ?>>
        <label id="elh_member_issale" class="<?= $Page->LeftColumnClass ?>"><?= $Page->issale->caption() ?><?= $Page->issale->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->issale->cellAttributes() ?>>
<span id="el_member_issale">
<template id="tp_x_issale">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="member" data-field="x_issale" name="x_issale" id="x_issale"<?= $Page->issale->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_issale" class="ew-item-list"></div>
<selection-list hidden
    id="x_issale[]"
    name="x_issale[]"
    value="<?= HtmlEncode($Page->issale->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_issale"
    data-bs-target="dsl_x_issale"
    data-repeatcolumn="5"
    class="form-control<?= $Page->issale->isInvalidClass() ?>"
    data-table="member"
    data-field="x_issale"
    data-value-separator="<?= $Page->issale->displayValueSeparatorAttribute() ?>"
    <?= $Page->issale->editAttributes() ?>></selection-list>
<?= $Page->issale->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->issale->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isnotification->Visible) { // isnotification ?>
    <div id="r_isnotification"<?= $Page->isnotification->rowAttributes() ?>>
        <label id="elh_member_isnotification" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isnotification->caption() ?><?= $Page->isnotification->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isnotification->cellAttributes() ?>>
<span id="el_member_isnotification">
<template id="tp_x_isnotification">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="member" data-field="x_isnotification" name="x_isnotification" id="x_isnotification"<?= $Page->isnotification->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_isnotification" class="ew-item-list"></div>
<selection-list hidden
    id="x_isnotification[]"
    name="x_isnotification[]"
    value="<?= HtmlEncode($Page->isnotification->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_isnotification"
    data-bs-target="dsl_x_isnotification"
    data-repeatcolumn="5"
    class="form-control<?= $Page->isnotification->isInvalidClass() ?>"
    data-table="member"
    data-field="x_isnotification"
    data-value-separator="<?= $Page->isnotification->displayValueSeparatorAttribute() ?>"
    <?= $Page->isnotification->editAttributes() ?>></selection-list>
<?= $Page->isnotification->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isnotification->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image_profile->Visible) { // image_profile ?>
    <div id="r_image_profile"<?= $Page->image_profile->rowAttributes() ?>>
        <label id="elh_member_image_profile" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image_profile->caption() ?><?= $Page->image_profile->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image_profile->cellAttributes() ?>>
<span id="el_member_image_profile">
<div id="fd_x_image_profile" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->image_profile->title() ?>" data-table="member" data-field="x_image_profile" name="x_image_profile" id="x_image_profile" lang="<?= CurrentLanguageID() ?>"<?= $Page->image_profile->editAttributes() ?> aria-describedby="x_image_profile_help"<?= ($Page->image_profile->ReadOnly || $Page->image_profile->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->image_profile->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image_profile->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_image_profile" id= "fn_x_image_profile" value="<?= $Page->image_profile->Upload->FileName ?>">
<input type="hidden" name="fa_x_image_profile" id= "fa_x_image_profile" value="<?= (Post("fa_x_image_profile") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_image_profile" id= "fs_x_image_profile" value="255">
<input type="hidden" name="fx_x_image_profile" id= "fx_x_image_profile" value="<?= $Page->image_profile->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image_profile" id= "fm_x_image_profile" value="<?= $Page->image_profile->UploadMaxFileSize ?>">
<table id="ft_x_image_profile" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("address", explode(",", $Page->getCurrentDetailTable())) && $address->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("address", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AddressGrid.php" ?>
<?php } ?>
<?php
    if (in_array("asset_favorite", explode(",", $Page->getCurrentDetailTable())) && $asset_favorite->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("asset_favorite", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AssetFavoriteGrid.php" ?>
<?php } ?>
<?php
    if (in_array("appointment", explode(",", $Page->getCurrentDetailTable())) && $appointment->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("appointment", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AppointmentGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("member");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
