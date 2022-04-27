<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SubdistrictAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { subdistrict: currentTable } });
var currentForm, currentPageID;
var fsubdistrictadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsubdistrictadd = new ew.Form("fsubdistrictadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fsubdistrictadd;

    // Add fields
    var fields = currentTable.fields;
    fsubdistrictadd.addFields([
        ["subdistrict_code", [fields.subdistrict_code.visible && fields.subdistrict_code.required ? ew.Validators.required(fields.subdistrict_code.caption) : null, ew.Validators.integer], fields.subdistrict_code.isInvalid],
        ["district_id", [fields.district_id.visible && fields.district_id.required ? ew.Validators.required(fields.district_id.caption) : null, ew.Validators.integer], fields.district_id.isInvalid],
        ["province_id", [fields.province_id.visible && fields.province_id.required ? ew.Validators.required(fields.province_id.caption) : null, ew.Validators.integer], fields.province_id.isInvalid],
        ["geo_id", [fields.geo_id.visible && fields.geo_id.required ? ew.Validators.required(fields.geo_id.caption) : null, ew.Validators.integer], fields.geo_id.isInvalid],
        ["subdistrict_name", [fields.subdistrict_name.visible && fields.subdistrict_name.required ? ew.Validators.required(fields.subdistrict_name.caption) : null], fields.subdistrict_name.isInvalid],
        ["subdistrict_name_en", [fields.subdistrict_name_en.visible && fields.subdistrict_name_en.required ? ew.Validators.required(fields.subdistrict_name_en.caption) : null], fields.subdistrict_name_en.isInvalid]
    ]);

    // Form_CustomValidate
    fsubdistrictadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubdistrictadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fsubdistrictadd");
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
<form name="fsubdistrictadd" id="fsubdistrictadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subdistrict">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->subdistrict_code->Visible) { // subdistrict_code ?>
    <div id="r_subdistrict_code"<?= $Page->subdistrict_code->rowAttributes() ?>>
        <label id="elh_subdistrict_subdistrict_code" for="x_subdistrict_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subdistrict_code->caption() ?><?= $Page->subdistrict_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subdistrict_code->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_code">
<input type="<?= $Page->subdistrict_code->getInputTextType() ?>" name="x_subdistrict_code" id="x_subdistrict_code" data-table="subdistrict" data-field="x_subdistrict_code" value="<?= $Page->subdistrict_code->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->subdistrict_code->getPlaceHolder()) ?>"<?= $Page->subdistrict_code->editAttributes() ?> aria-describedby="x_subdistrict_code_help">
<?= $Page->subdistrict_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subdistrict_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
    <div id="r_district_id"<?= $Page->district_id->rowAttributes() ?>>
        <label id="elh_subdistrict_district_id" for="x_district_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->district_id->caption() ?><?= $Page->district_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->district_id->cellAttributes() ?>>
<span id="el_subdistrict_district_id">
<input type="<?= $Page->district_id->getInputTextType() ?>" name="x_district_id" id="x_district_id" data-table="subdistrict" data-field="x_district_id" value="<?= $Page->district_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->district_id->getPlaceHolder()) ?>"<?= $Page->district_id->editAttributes() ?> aria-describedby="x_district_id_help">
<?= $Page->district_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->district_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
    <div id="r_province_id"<?= $Page->province_id->rowAttributes() ?>>
        <label id="elh_subdistrict_province_id" for="x_province_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->province_id->caption() ?><?= $Page->province_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->province_id->cellAttributes() ?>>
<span id="el_subdistrict_province_id">
<input type="<?= $Page->province_id->getInputTextType() ?>" name="x_province_id" id="x_province_id" data-table="subdistrict" data-field="x_province_id" value="<?= $Page->province_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->province_id->getPlaceHolder()) ?>"<?= $Page->province_id->editAttributes() ?> aria-describedby="x_province_id_help">
<?= $Page->province_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->province_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->geo_id->Visible) { // geo_id ?>
    <div id="r_geo_id"<?= $Page->geo_id->rowAttributes() ?>>
        <label id="elh_subdistrict_geo_id" for="x_geo_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->geo_id->caption() ?><?= $Page->geo_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->geo_id->cellAttributes() ?>>
<span id="el_subdistrict_geo_id">
<input type="<?= $Page->geo_id->getInputTextType() ?>" name="x_geo_id" id="x_geo_id" data-table="subdistrict" data-field="x_geo_id" value="<?= $Page->geo_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->geo_id->getPlaceHolder()) ?>"<?= $Page->geo_id->editAttributes() ?> aria-describedby="x_geo_id_help">
<?= $Page->geo_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->geo_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subdistrict_name->Visible) { // subdistrict_name ?>
    <div id="r_subdistrict_name"<?= $Page->subdistrict_name->rowAttributes() ?>>
        <label id="elh_subdistrict_subdistrict_name" for="x_subdistrict_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subdistrict_name->caption() ?><?= $Page->subdistrict_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subdistrict_name->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_name">
<input type="<?= $Page->subdistrict_name->getInputTextType() ?>" name="x_subdistrict_name" id="x_subdistrict_name" data-table="subdistrict" data-field="x_subdistrict_name" value="<?= $Page->subdistrict_name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->subdistrict_name->getPlaceHolder()) ?>"<?= $Page->subdistrict_name->editAttributes() ?> aria-describedby="x_subdistrict_name_help">
<?= $Page->subdistrict_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subdistrict_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subdistrict_name_en->Visible) { // subdistrict_name_en ?>
    <div id="r_subdistrict_name_en"<?= $Page->subdistrict_name_en->rowAttributes() ?>>
        <label id="elh_subdistrict_subdistrict_name_en" for="x_subdistrict_name_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subdistrict_name_en->caption() ?><?= $Page->subdistrict_name_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subdistrict_name_en->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_name_en">
<input type="<?= $Page->subdistrict_name_en->getInputTextType() ?>" name="x_subdistrict_name_en" id="x_subdistrict_name_en" data-table="subdistrict" data-field="x_subdistrict_name_en" value="<?= $Page->subdistrict_name_en->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->subdistrict_name_en->getPlaceHolder()) ?>"<?= $Page->subdistrict_name_en->editAttributes() ?> aria-describedby="x_subdistrict_name_en_help">
<?= $Page->subdistrict_name_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subdistrict_name_en->getErrorMessage() ?></div>
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
    ew.addEventHandlers("subdistrict");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
