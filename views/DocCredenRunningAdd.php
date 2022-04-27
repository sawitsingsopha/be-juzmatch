<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenRunningAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_running: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_runningadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_runningadd = new ew.Form("fdoc_creden_runningadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fdoc_creden_runningadd;

    // Add fields
    var fields = currentTable.fields;
    fdoc_creden_runningadd.addFields([
        ["year", [fields.year.visible && fields.year.required ? ew.Validators.required(fields.year.caption) : null, ew.Validators.integer], fields.year.isInvalid],
        ["month", [fields.month.visible && fields.month.required ? ew.Validators.required(fields.month.caption) : null, ew.Validators.integer], fields.month.isInvalid],
        ["running", [fields.running.visible && fields.running.required ? ew.Validators.required(fields.running.caption) : null, ew.Validators.integer], fields.running.isInvalid]
    ]);

    // Form_CustomValidate
    fdoc_creden_runningadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdoc_creden_runningadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fdoc_creden_runningadd");
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
<form name="fdoc_creden_runningadd" id="fdoc_creden_runningadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_running">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->year->Visible) { // year ?>
    <div id="r_year"<?= $Page->year->rowAttributes() ?>>
        <label id="elh_doc_creden_running_year" for="x_year" class="<?= $Page->LeftColumnClass ?>"><?= $Page->year->caption() ?><?= $Page->year->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->year->cellAttributes() ?>>
<span id="el_doc_creden_running_year">
<input type="<?= $Page->year->getInputTextType() ?>" name="x_year" id="x_year" data-table="doc_creden_running" data-field="x_year" value="<?= $Page->year->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->year->getPlaceHolder()) ?>"<?= $Page->year->editAttributes() ?> aria-describedby="x_year_help">
<?= $Page->year->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->year->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->month->Visible) { // month ?>
    <div id="r_month"<?= $Page->month->rowAttributes() ?>>
        <label id="elh_doc_creden_running_month" for="x_month" class="<?= $Page->LeftColumnClass ?>"><?= $Page->month->caption() ?><?= $Page->month->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->month->cellAttributes() ?>>
<span id="el_doc_creden_running_month">
<input type="<?= $Page->month->getInputTextType() ?>" name="x_month" id="x_month" data-table="doc_creden_running" data-field="x_month" value="<?= $Page->month->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->month->getPlaceHolder()) ?>"<?= $Page->month->editAttributes() ?> aria-describedby="x_month_help">
<?= $Page->month->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->month->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->running->Visible) { // running ?>
    <div id="r_running"<?= $Page->running->rowAttributes() ?>>
        <label id="elh_doc_creden_running_running" for="x_running" class="<?= $Page->LeftColumnClass ?>"><?= $Page->running->caption() ?><?= $Page->running->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->running->cellAttributes() ?>>
<span id="el_doc_creden_running_running">
<input type="<?= $Page->running->getInputTextType() ?>" name="x_running" id="x_running" data-table="doc_creden_running" data-field="x_running" value="<?= $Page->running->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->running->getPlaceHolder()) ?>"<?= $Page->running->editAttributes() ?> aria-describedby="x_running_help">
<?= $Page->running->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->running->getErrorMessage() ?></div>
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
    ew.addEventHandlers("doc_creden_running");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
