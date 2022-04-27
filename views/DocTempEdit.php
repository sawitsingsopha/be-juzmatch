<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocTempEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_temp: currentTable } });
var currentForm, currentPageID;
var fdoc_tempedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_tempedit = new ew.Form("fdoc_tempedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fdoc_tempedit;

    // Add fields
    var fields = currentTable.fields;
    fdoc_tempedit.addFields([
        ["doc_temp_type", [fields.doc_temp_type.visible && fields.doc_temp_type.required ? ew.Validators.required(fields.doc_temp_type.caption) : null], fields.doc_temp_type.isInvalid],
        ["doc_temp_name", [fields.doc_temp_name.visible && fields.doc_temp_name.required ? ew.Validators.required(fields.doc_temp_name.caption) : null], fields.doc_temp_name.isInvalid],
        ["doc_temp_file", [fields.doc_temp_file.visible && fields.doc_temp_file.required ? ew.Validators.fileRequired(fields.doc_temp_file.caption) : null], fields.doc_temp_file.isInvalid],
        ["active_status", [fields.active_status.visible && fields.active_status.required ? ew.Validators.required(fields.active_status.caption) : null], fields.active_status.isInvalid],
        ["esign_page1", [fields.esign_page1.visible && fields.esign_page1.required ? ew.Validators.required(fields.esign_page1.caption) : null, ew.Validators.integer], fields.esign_page1.isInvalid],
        ["esign_page2", [fields.esign_page2.visible && fields.esign_page2.required ? ew.Validators.required(fields.esign_page2.caption) : null, ew.Validators.integer], fields.esign_page2.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_tempedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_tempedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fdoc_tempedit.lists.doc_temp_type = <?= $Page->doc_temp_type->toClientList($Page) ?>;
    fdoc_tempedit.lists.active_status = <?= $Page->active_status->toClientList($Page) ?>;
    loadjs.done("fdoc_tempedit");
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
<form name="fdoc_tempedit" id="fdoc_tempedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_temp">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->doc_temp_type->Visible) { // doc_temp_type ?>
    <div id="r_doc_temp_type"<?= $Page->doc_temp_type->rowAttributes() ?>>
        <label id="elh_doc_temp_doc_temp_type" for="x_doc_temp_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_temp_type->caption() ?><?= $Page->doc_temp_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_temp_type->cellAttributes() ?>>
<span id="el_doc_temp_doc_temp_type">
    <select
        id="x_doc_temp_type"
        name="x_doc_temp_type"
        class="form-select ew-select<?= $Page->doc_temp_type->isInvalidClass() ?>"
        data-select2-id="fdoc_tempedit_x_doc_temp_type"
        data-table="doc_temp"
        data-field="x_doc_temp_type"
        data-value-separator="<?= $Page->doc_temp_type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->doc_temp_type->getPlaceHolder()) ?>"
        <?= $Page->doc_temp_type->editAttributes() ?>>
        <?= $Page->doc_temp_type->selectOptionListHtml("x_doc_temp_type") ?>
    </select>
    <?= $Page->doc_temp_type->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->doc_temp_type->getErrorMessage() ?></div>
<script>
loadjs.ready("fdoc_tempedit", function() {
    var options = { name: "x_doc_temp_type", selectId: "fdoc_tempedit_x_doc_temp_type" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdoc_tempedit.lists.doc_temp_type.lookupOptions.length) {
        options.data = { id: "x_doc_temp_type", form: "fdoc_tempedit" };
    } else {
        options.ajax = { id: "x_doc_temp_type", form: "fdoc_tempedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.doc_temp.fields.doc_temp_type.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_temp_name->Visible) { // doc_temp_name ?>
    <div id="r_doc_temp_name"<?= $Page->doc_temp_name->rowAttributes() ?>>
        <label id="elh_doc_temp_doc_temp_name" for="x_doc_temp_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_temp_name->caption() ?><?= $Page->doc_temp_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_temp_name->cellAttributes() ?>>
<span id="el_doc_temp_doc_temp_name">
<input type="<?= $Page->doc_temp_name->getInputTextType() ?>" name="x_doc_temp_name" id="x_doc_temp_name" data-table="doc_temp" data-field="x_doc_temp_name" value="<?= $Page->doc_temp_name->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->doc_temp_name->getPlaceHolder()) ?>"<?= $Page->doc_temp_name->editAttributes() ?> aria-describedby="x_doc_temp_name_help">
<?= $Page->doc_temp_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_temp_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->doc_temp_file->Visible) { // doc_temp_file ?>
    <div id="r_doc_temp_file"<?= $Page->doc_temp_file->rowAttributes() ?>>
        <label id="elh_doc_temp_doc_temp_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->doc_temp_file->caption() ?><?= $Page->doc_temp_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->doc_temp_file->cellAttributes() ?>>
<span id="el_doc_temp_doc_temp_file">
<div id="fd_x_doc_temp_file" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->doc_temp_file->title() ?>" data-table="doc_temp" data-field="x_doc_temp_file" name="x_doc_temp_file" id="x_doc_temp_file" lang="<?= CurrentLanguageID() ?>"<?= $Page->doc_temp_file->editAttributes() ?> aria-describedby="x_doc_temp_file_help"<?= ($Page->doc_temp_file->ReadOnly || $Page->doc_temp_file->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->doc_temp_file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->doc_temp_file->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_doc_temp_file" id= "fn_x_doc_temp_file" value="<?= $Page->doc_temp_file->Upload->FileName ?>">
<input type="hidden" name="fa_x_doc_temp_file" id= "fa_x_doc_temp_file" value="<?= (Post("fa_x_doc_temp_file") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_doc_temp_file" id= "fs_x_doc_temp_file" value="250">
<input type="hidden" name="fx_x_doc_temp_file" id= "fx_x_doc_temp_file" value="<?= $Page->doc_temp_file->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_doc_temp_file" id= "fm_x_doc_temp_file" value="<?= $Page->doc_temp_file->UploadMaxFileSize ?>">
<table id="ft_x_doc_temp_file" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <div id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <label id="elh_doc_temp_active_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active_status->caption() ?><?= $Page->active_status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->active_status->cellAttributes() ?>>
<span id="el_doc_temp_active_status">
<template id="tp_x_active_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="doc_temp" data-field="x_active_status" name="x_active_status" id="x_active_status"<?= $Page->active_status->editAttributes() ?>>
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
    data-table="doc_temp"
    data-field="x_active_status"
    data-value-separator="<?= $Page->active_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->active_status->editAttributes() ?>></selection-list>
<?= $Page->active_status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active_status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->esign_page1->Visible) { // esign_page1 ?>
    <div id="r_esign_page1"<?= $Page->esign_page1->rowAttributes() ?>>
        <label id="elh_doc_temp_esign_page1" for="x_esign_page1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->esign_page1->caption() ?><?= $Page->esign_page1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->esign_page1->cellAttributes() ?>>
<span id="el_doc_temp_esign_page1">
<input type="<?= $Page->esign_page1->getInputTextType() ?>" name="x_esign_page1" id="x_esign_page1" data-table="doc_temp" data-field="x_esign_page1" value="<?= $Page->esign_page1->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->esign_page1->getPlaceHolder()) ?>"<?= $Page->esign_page1->editAttributes() ?> aria-describedby="x_esign_page1_help">
<?= $Page->esign_page1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->esign_page1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->esign_page2->Visible) { // esign_page2 ?>
    <div id="r_esign_page2"<?= $Page->esign_page2->rowAttributes() ?>>
        <label id="elh_doc_temp_esign_page2" for="x_esign_page2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->esign_page2->caption() ?><?= $Page->esign_page2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->esign_page2->cellAttributes() ?>>
<span id="el_doc_temp_esign_page2">
<input type="<?= $Page->esign_page2->getInputTextType() ?>" name="x_esign_page2" id="x_esign_page2" data-table="doc_temp" data-field="x_esign_page2" value="<?= $Page->esign_page2->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->esign_page2->getPlaceHolder()) ?>"<?= $Page->esign_page2->editAttributes() ?> aria-describedby="x_esign_page2_help">
<?= $Page->esign_page2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->esign_page2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="doc_temp" data-field="x_doc_temp_id" data-hidden="1" name="x_doc_temp_id" id="x_doc_temp_id" value="<?= HtmlEncode($Page->doc_temp_id->CurrentValue) ?>">
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
    ew.addEventHandlers("doc_temp");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
    let esign_page2 = $("#r_esign_page2").hide();
    esign_page2.hide();
    let x_doc_temp_type = $('#x_doc_temp_type').val();
    if (x_doc_temp_type == 2) {
        esign_page2.show();
    } else {
        esign_page2.hide();
    }

    $('#x_doc_temp_type').on('change', function()
    {
        if (this.value == 2) {
            esign_page2.show();
        } else {
            esign_page2.hide();
        }
    });

});
</script>
