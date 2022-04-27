<?php

namespace PHPMaker2022\juzmatch;

// Page object
$JuzcalculatorEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { juzcalculator: currentTable } });
var currentForm, currentPageID;
var fjuzcalculatoredit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fjuzcalculatoredit = new ew.Form("fjuzcalculatoredit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fjuzcalculatoredit;

    // Add fields
    var fields = currentTable.fields;
    fjuzcalculatoredit.addFields([
        ["income_all", [fields.income_all.visible && fields.income_all.required ? ew.Validators.required(fields.income_all.caption) : null, ew.Validators.float], fields.income_all.isInvalid],
        ["outcome_all", [fields.outcome_all.visible && fields.outcome_all.required ? ew.Validators.required(fields.outcome_all.caption) : null, ew.Validators.float], fields.outcome_all.isInvalid],
        ["rent_price", [fields.rent_price.visible && fields.rent_price.required ? ew.Validators.required(fields.rent_price.caption) : null, ew.Validators.float], fields.rent_price.isInvalid],
        ["asset_price", [fields.asset_price.visible && fields.asset_price.required ? ew.Validators.required(fields.asset_price.caption) : null, ew.Validators.float], fields.asset_price.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fjuzcalculatoredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fjuzcalculatoredit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fjuzcalculatoredit");
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
<form name="fjuzcalculatoredit" id="fjuzcalculatoredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="juzcalculator">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer">
<input type="hidden" name="fk_member_id" value="<?= HtmlEncode($Page->member_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->income_all->Visible) { // income_all ?>
    <div id="r_income_all"<?= $Page->income_all->rowAttributes() ?>>
        <label id="elh_juzcalculator_income_all" for="x_income_all" class="<?= $Page->LeftColumnClass ?>"><?= $Page->income_all->caption() ?><?= $Page->income_all->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->income_all->cellAttributes() ?>>
<span id="el_juzcalculator_income_all">
<input type="<?= $Page->income_all->getInputTextType() ?>" name="x_income_all" id="x_income_all" data-table="juzcalculator" data-field="x_income_all" value="<?= $Page->income_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->income_all->getPlaceHolder()) ?>"<?= $Page->income_all->editAttributes() ?> aria-describedby="x_income_all_help">
<?= $Page->income_all->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->income_all->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->outcome_all->Visible) { // outcome_all ?>
    <div id="r_outcome_all"<?= $Page->outcome_all->rowAttributes() ?>>
        <label id="elh_juzcalculator_outcome_all" for="x_outcome_all" class="<?= $Page->LeftColumnClass ?>"><?= $Page->outcome_all->caption() ?><?= $Page->outcome_all->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->outcome_all->cellAttributes() ?>>
<span id="el_juzcalculator_outcome_all">
<input type="<?= $Page->outcome_all->getInputTextType() ?>" name="x_outcome_all" id="x_outcome_all" data-table="juzcalculator" data-field="x_outcome_all" value="<?= $Page->outcome_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->outcome_all->getPlaceHolder()) ?>"<?= $Page->outcome_all->editAttributes() ?> aria-describedby="x_outcome_all_help">
<?= $Page->outcome_all->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->outcome_all->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rent_price->Visible) { // rent_price ?>
    <div id="r_rent_price"<?= $Page->rent_price->rowAttributes() ?>>
        <label id="elh_juzcalculator_rent_price" for="x_rent_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rent_price->caption() ?><?= $Page->rent_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rent_price->cellAttributes() ?>>
<span id="el_juzcalculator_rent_price">
<input type="<?= $Page->rent_price->getInputTextType() ?>" name="x_rent_price" id="x_rent_price" data-table="juzcalculator" data-field="x_rent_price" value="<?= $Page->rent_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rent_price->getPlaceHolder()) ?>"<?= $Page->rent_price->editAttributes() ?> aria-describedby="x_rent_price_help">
<?= $Page->rent_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rent_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
    <div id="r_asset_price"<?= $Page->asset_price->rowAttributes() ?>>
        <label id="elh_juzcalculator_asset_price" for="x_asset_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_price->caption() ?><?= $Page->asset_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_price->cellAttributes() ?>>
<span id="el_juzcalculator_asset_price">
<input type="<?= $Page->asset_price->getInputTextType() ?>" name="x_asset_price" id="x_asset_price" data-table="juzcalculator" data-field="x_asset_price" value="<?= $Page->asset_price->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->asset_price->getPlaceHolder()) ?>"<?= $Page->asset_price->editAttributes() ?> aria-describedby="x_asset_price_help">
<?= $Page->asset_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="juzcalculator" data-field="x_juzcalculator_id" data-hidden="1" name="x_juzcalculator_id" id="x_juzcalculator_id" value="<?= HtmlEncode($Page->juzcalculator_id->CurrentValue) ?>">
<?php
    if (in_array("juzcalculator_income", explode(",", $Page->getCurrentDetailTable())) && $juzcalculator_income->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("juzcalculator_income", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "JuzcalculatorIncomeGrid.php" ?>
<?php } ?>
<?php
    if (in_array("juzcalculator_outcome", explode(",", $Page->getCurrentDetailTable())) && $juzcalculator_outcome->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("juzcalculator_outcome", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "JuzcalculatorOutcomeGrid.php" ?>
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
    ew.addEventHandlers("juzcalculator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
