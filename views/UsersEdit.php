<?php

namespace PHPMaker2022\juzmatch;

// Page object
$UsersEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentForm, currentPageID;
var fusersedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fusersedit = new ew.Form("fusersedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fusersedit;

    // Add fields
    var fields = currentTable.fields;
    fusersedit.addFields([
        ["user_level_id", [fields.user_level_id.visible && fields.user_level_id.required ? ew.Validators.required(fields.user_level_id.caption) : null], fields.user_level_id.isInvalid],
        ["user_name", [fields.user_name.visible && fields.user_name.required ? ew.Validators.required(fields.user_name.caption) : null], fields.user_name.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null, ew.Validators.passwordStrength], fields._password.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["first_name", [fields.first_name.visible && fields.first_name.required ? ew.Validators.required(fields.first_name.caption) : null], fields.first_name.isInvalid],
        ["last_name", [fields.last_name.visible && fields.last_name.required ? ew.Validators.required(fields.last_name.caption) : null], fields.last_name.isInvalid],
        ["telephone", [fields.telephone.visible && fields.telephone.required ? ew.Validators.required(fields.telephone.caption) : null, ew.Validators.integer], fields.telephone.isInvalid],
        ["image", [fields.image.visible && fields.image.required ? ew.Validators.fileRequired(fields.image.caption) : null], fields.image.isInvalid],
        ["active_status", [fields.active_status.visible && fields.active_status.required ? ew.Validators.required(fields.active_status.caption) : null], fields.active_status.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fusersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fusersedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fusersedit.lists.user_level_id = <?= $Page->user_level_id->toClientList($Page) ?>;
    fusersedit.lists.active_status = <?= $Page->active_status->toClientList($Page) ?>;
    loadjs.done("fusersedit");
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
<form name="fusersedit" id="fusersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->user_level_id->Visible) { // user_level_id ?>
    <div id="r_user_level_id"<?= $Page->user_level_id->rowAttributes() ?>>
        <label id="elh_users_user_level_id" for="x_user_level_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_level_id->caption() ?><?= $Page->user_level_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_level_id->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_user_level_id">
<span class="form-control-plaintext"><?= $Page->user_level_id->getDisplayValue($Page->user_level_id->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_users_user_level_id">
    <select
        id="x_user_level_id"
        name="x_user_level_id"
        class="form-select ew-select<?= $Page->user_level_id->isInvalidClass() ?>"
        data-select2-id="fusersedit_x_user_level_id"
        data-table="users"
        data-field="x_user_level_id"
        data-value-separator="<?= $Page->user_level_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_level_id->getPlaceHolder()) ?>"
        <?= $Page->user_level_id->editAttributes() ?>>
        <?= $Page->user_level_id->selectOptionListHtml("x_user_level_id") ?>
    </select>
    <?= $Page->user_level_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->user_level_id->getErrorMessage() ?></div>
<?= $Page->user_level_id->Lookup->getParamTag($Page, "p_x_user_level_id") ?>
<script>
loadjs.ready("fusersedit", function() {
    var options = { name: "x_user_level_id", selectId: "fusersedit_x_user_level_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersedit.lists.user_level_id.lookupOptions.length) {
        options.data = { id: "x_user_level_id", form: "fusersedit" };
    } else {
        options.ajax = { id: "x_user_level_id", form: "fusersedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.user_level_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_name->Visible) { // user_name ?>
    <div id="r_user_name"<?= $Page->user_name->rowAttributes() ?>>
        <label id="elh_users_user_name" for="x_user_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_name->caption() ?><?= $Page->user_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_name->cellAttributes() ?>>
<span id="el_users_user_name">
<input type="<?= $Page->user_name->getInputTextType() ?>" name="x_user_name" id="x_user_name" data-table="users" data-field="x_user_name" value="<?= $Page->user_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->user_name->getPlaceHolder()) ?>"<?= $Page->user_name->editAttributes() ?> aria-describedby="x_user_name_help">
<?= $Page->user_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_users__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_users__password">
<div class="input-group" id="ig__password">
    <input type="password" autocomplete="new-password" data-password-strength="pst__password" data-table="users" data-field="x__password" name="x__password" id="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password" data-ew-action="password"><i class="fas fa-eye"></i></button>
    <button type="button" class="btn btn-default ew-password-generator rounded-end" title="<?= HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x__password" data-password-confirm="c__password" data-password-strength="pst__password"><?= $Language->phrase("GeneratePassword") ?></button>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst__password">
    <div class="progress-bar" role="progressbar"></div>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
    <div id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <label id="elh_users_first_name" for="x_first_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_name->caption() ?><?= $Page->first_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_name->cellAttributes() ?>>
<span id="el_users_first_name">
<input type="<?= $Page->first_name->getInputTextType() ?>" name="x_first_name" id="x_first_name" data-table="users" data-field="x_first_name" value="<?= $Page->first_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->first_name->getPlaceHolder()) ?>"<?= $Page->first_name->editAttributes() ?> aria-describedby="x_first_name_help">
<?= $Page->first_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <div id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <label id="elh_users_last_name" for="x_last_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_name->caption() ?><?= $Page->last_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_name->cellAttributes() ?>>
<span id="el_users_last_name">
<input type="<?= $Page->last_name->getInputTextType() ?>" name="x_last_name" id="x_last_name" data-table="users" data-field="x_last_name" value="<?= $Page->last_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->last_name->getPlaceHolder()) ?>"<?= $Page->last_name->editAttributes() ?> aria-describedby="x_last_name_help">
<?= $Page->last_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telephone->Visible) { // telephone ?>
    <div id="r_telephone"<?= $Page->telephone->rowAttributes() ?>>
        <label id="elh_users_telephone" for="x_telephone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telephone->caption() ?><?= $Page->telephone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telephone->cellAttributes() ?>>
<span id="el_users_telephone">
<input type="<?= $Page->telephone->getInputTextType() ?>" name="x_telephone" id="x_telephone" data-table="users" data-field="x_telephone" value="<?= $Page->telephone->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->telephone->getPlaceHolder()) ?>"<?= $Page->telephone->editAttributes() ?> aria-describedby="x_telephone_help">
<?= $Page->telephone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telephone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image"<?= $Page->image->rowAttributes() ?>>
        <label id="elh_users_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->image->cellAttributes() ?>>
<span id="el_users_image">
<div id="fd_x_image" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->image->title() ?>" data-table="users" data-field="x_image" name="x_image" id="x_image" lang="<?= CurrentLanguageID() ?>"<?= $Page->image->editAttributes() ?> aria-describedby="x_image_help"<?= ($Page->image->ReadOnly || $Page->image->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->image->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?= $Page->image->Upload->FileName ?>">
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="<?= (Post("fa_x_image") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_image" id= "fs_x_image" value="255">
<input type="hidden" name="fx_x_image" id= "fx_x_image" value="<?= $Page->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image" id= "fm_x_image" value="<?= $Page->image->UploadMaxFileSize ?>">
<table id="ft_x_image" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <div id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <label id="elh_users_active_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active_status->caption() ?><?= $Page->active_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->active_status->cellAttributes() ?>>
<span id="el_users_active_status">
<template id="tp_x_active_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_active_status" name="x_active_status" id="x_active_status"<?= $Page->active_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_active_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_active_status"
    name="x_active_status"
    value="<?= HtmlEncode($Page->active_status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_active_status"
    data-bs-target="dsl_x_active_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->active_status->isInvalidClass() ?>"
    data-table="users"
    data-field="x_active_status"
    data-value-separator="<?= $Page->active_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->active_status->editAttributes() ?>></selection-list>
<?= $Page->active_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="users" data-field="x_users_id" data-hidden="1" name="x_users_id" id="x_users_id" value="<?= HtmlEncode($Page->users_id->CurrentValue) ?>">
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
