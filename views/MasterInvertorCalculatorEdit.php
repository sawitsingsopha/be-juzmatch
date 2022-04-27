<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MasterInvertorCalculatorEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { master_invertor_calculator: currentTable } });
var currentForm, currentPageID;
var fmaster_invertor_calculatoredit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmaster_invertor_calculatoredit = new ew.Form("fmaster_invertor_calculatoredit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fmaster_invertor_calculatoredit;

    // Add fields
    var fields = currentTable.fields;
    fmaster_invertor_calculatoredit.addFields([
        ["investor_contract_period", [fields.investor_contract_period.visible && fields.investor_contract_period.required ? ew.Validators.required(fields.investor_contract_period.caption) : null, ew.Validators.float], fields.investor_contract_period.isInvalid],
        ["investor_mortgage_without_house", [fields.investor_mortgage_without_house.visible && fields.investor_mortgage_without_house.required ? ew.Validators.required(fields.investor_mortgage_without_house.caption) : null, ew.Validators.float], fields.investor_mortgage_without_house.isInvalid],
        ["invertor_mortgage_with_house", [fields.invertor_mortgage_with_house.visible && fields.invertor_mortgage_with_house.required ? ew.Validators.required(fields.invertor_mortgage_with_house.caption) : null, ew.Validators.float], fields.invertor_mortgage_with_house.isInvalid],
        ["invertor_mortgage_cash_without", [fields.invertor_mortgage_cash_without.visible && fields.invertor_mortgage_cash_without.required ? ew.Validators.required(fields.invertor_mortgage_cash_without.caption) : null, ew.Validators.float], fields.invertor_mortgage_cash_without.isInvalid],
        ["invertor_mortgage_cash_with", [fields.invertor_mortgage_cash_with.visible && fields.invertor_mortgage_cash_with.required ? ew.Validators.required(fields.invertor_mortgage_cash_with.caption) : null, ew.Validators.float], fields.invertor_mortgage_cash_with.isInvalid],
        ["invertor_dsr_ratio", [fields.invertor_dsr_ratio.visible && fields.invertor_dsr_ratio.required ? ew.Validators.required(fields.invertor_dsr_ratio.caption) : null, ew.Validators.float], fields.invertor_dsr_ratio.isInvalid],
        ["invertor_monthly_payment", [fields.invertor_monthly_payment.visible && fields.invertor_monthly_payment.required ? ew.Validators.required(fields.invertor_monthly_payment.caption) : null, ew.Validators.float], fields.invertor_monthly_payment.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid]
    ]);

    // Form_CustomValidate
    fmaster_invertor_calculatoredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmaster_invertor_calculatoredit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fmaster_invertor_calculatoredit");
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
<form name="fmaster_invertor_calculatoredit" id="fmaster_invertor_calculatoredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="master_invertor_calculator">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->investor_contract_period->Visible) { // investor_contract_period ?>
    <div id="r_investor_contract_period"<?= $Page->investor_contract_period->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_investor_contract_period" for="x_investor_contract_period" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_contract_period->caption() ?><?= $Page->investor_contract_period->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_contract_period->cellAttributes() ?>>
<span id="el_master_invertor_calculator_investor_contract_period">
<input type="<?= $Page->investor_contract_period->getInputTextType() ?>" name="x_investor_contract_period" id="x_investor_contract_period" data-table="master_invertor_calculator" data-field="x_investor_contract_period" value="<?= $Page->investor_contract_period->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->investor_contract_period->getPlaceHolder()) ?>"<?= $Page->investor_contract_period->editAttributes() ?> aria-describedby="x_investor_contract_period_help">
<?= $Page->investor_contract_period->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_contract_period->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->investor_mortgage_without_house->Visible) { // investor_mortgage_without_house ?>
    <div id="r_investor_mortgage_without_house"<?= $Page->investor_mortgage_without_house->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_investor_mortgage_without_house" for="x_investor_mortgage_without_house" class="<?= $Page->LeftColumnClass ?>"><?= $Page->investor_mortgage_without_house->caption() ?><?= $Page->investor_mortgage_without_house->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->investor_mortgage_without_house->cellAttributes() ?>>
<span id="el_master_invertor_calculator_investor_mortgage_without_house">
<input type="<?= $Page->investor_mortgage_without_house->getInputTextType() ?>" name="x_investor_mortgage_without_house" id="x_investor_mortgage_without_house" data-table="master_invertor_calculator" data-field="x_investor_mortgage_without_house" value="<?= $Page->investor_mortgage_without_house->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->investor_mortgage_without_house->getPlaceHolder()) ?>"<?= $Page->investor_mortgage_without_house->editAttributes() ?> aria-describedby="x_investor_mortgage_without_house_help">
<?= $Page->investor_mortgage_without_house->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->investor_mortgage_without_house->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invertor_mortgage_with_house->Visible) { // invertor_mortgage_with_house ?>
    <div id="r_invertor_mortgage_with_house"<?= $Page->invertor_mortgage_with_house->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_invertor_mortgage_with_house" for="x_invertor_mortgage_with_house" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invertor_mortgage_with_house->caption() ?><?= $Page->invertor_mortgage_with_house->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invertor_mortgage_with_house->cellAttributes() ?>>
<span id="el_master_invertor_calculator_invertor_mortgage_with_house">
<input type="<?= $Page->invertor_mortgage_with_house->getInputTextType() ?>" name="x_invertor_mortgage_with_house" id="x_invertor_mortgage_with_house" data-table="master_invertor_calculator" data-field="x_invertor_mortgage_with_house" value="<?= $Page->invertor_mortgage_with_house->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invertor_mortgage_with_house->getPlaceHolder()) ?>"<?= $Page->invertor_mortgage_with_house->editAttributes() ?> aria-describedby="x_invertor_mortgage_with_house_help">
<?= $Page->invertor_mortgage_with_house->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invertor_mortgage_with_house->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invertor_mortgage_cash_without->Visible) { // invertor_mortgage_cash_without ?>
    <div id="r_invertor_mortgage_cash_without"<?= $Page->invertor_mortgage_cash_without->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_invertor_mortgage_cash_without" for="x_invertor_mortgage_cash_without" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invertor_mortgage_cash_without->caption() ?><?= $Page->invertor_mortgage_cash_without->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invertor_mortgage_cash_without->cellAttributes() ?>>
<span id="el_master_invertor_calculator_invertor_mortgage_cash_without">
<input type="<?= $Page->invertor_mortgage_cash_without->getInputTextType() ?>" name="x_invertor_mortgage_cash_without" id="x_invertor_mortgage_cash_without" data-table="master_invertor_calculator" data-field="x_invertor_mortgage_cash_without" value="<?= $Page->invertor_mortgage_cash_without->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invertor_mortgage_cash_without->getPlaceHolder()) ?>"<?= $Page->invertor_mortgage_cash_without->editAttributes() ?> aria-describedby="x_invertor_mortgage_cash_without_help">
<?= $Page->invertor_mortgage_cash_without->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invertor_mortgage_cash_without->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invertor_mortgage_cash_with->Visible) { // invertor_mortgage_cash_with ?>
    <div id="r_invertor_mortgage_cash_with"<?= $Page->invertor_mortgage_cash_with->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_invertor_mortgage_cash_with" for="x_invertor_mortgage_cash_with" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invertor_mortgage_cash_with->caption() ?><?= $Page->invertor_mortgage_cash_with->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invertor_mortgage_cash_with->cellAttributes() ?>>
<span id="el_master_invertor_calculator_invertor_mortgage_cash_with">
<input type="<?= $Page->invertor_mortgage_cash_with->getInputTextType() ?>" name="x_invertor_mortgage_cash_with" id="x_invertor_mortgage_cash_with" data-table="master_invertor_calculator" data-field="x_invertor_mortgage_cash_with" value="<?= $Page->invertor_mortgage_cash_with->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invertor_mortgage_cash_with->getPlaceHolder()) ?>"<?= $Page->invertor_mortgage_cash_with->editAttributes() ?> aria-describedby="x_invertor_mortgage_cash_with_help">
<?= $Page->invertor_mortgage_cash_with->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invertor_mortgage_cash_with->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invertor_dsr_ratio->Visible) { // invertor_dsr_ratio ?>
    <div id="r_invertor_dsr_ratio"<?= $Page->invertor_dsr_ratio->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_invertor_dsr_ratio" for="x_invertor_dsr_ratio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invertor_dsr_ratio->caption() ?><?= $Page->invertor_dsr_ratio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invertor_dsr_ratio->cellAttributes() ?>>
<span id="el_master_invertor_calculator_invertor_dsr_ratio">
<input type="<?= $Page->invertor_dsr_ratio->getInputTextType() ?>" name="x_invertor_dsr_ratio" id="x_invertor_dsr_ratio" data-table="master_invertor_calculator" data-field="x_invertor_dsr_ratio" value="<?= $Page->invertor_dsr_ratio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invertor_dsr_ratio->getPlaceHolder()) ?>"<?= $Page->invertor_dsr_ratio->editAttributes() ?> aria-describedby="x_invertor_dsr_ratio_help">
<?= $Page->invertor_dsr_ratio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invertor_dsr_ratio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->invertor_monthly_payment->Visible) { // invertor_monthly_payment ?>
    <div id="r_invertor_monthly_payment"<?= $Page->invertor_monthly_payment->rowAttributes() ?>>
        <label id="elh_master_invertor_calculator_invertor_monthly_payment" for="x_invertor_monthly_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invertor_monthly_payment->caption() ?><?= $Page->invertor_monthly_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invertor_monthly_payment->cellAttributes() ?>>
<span id="el_master_invertor_calculator_invertor_monthly_payment">
<input type="<?= $Page->invertor_monthly_payment->getInputTextType() ?>" name="x_invertor_monthly_payment" id="x_invertor_monthly_payment" data-table="master_invertor_calculator" data-field="x_invertor_monthly_payment" value="<?= $Page->invertor_monthly_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->invertor_monthly_payment->getPlaceHolder()) ?>"<?= $Page->invertor_monthly_payment->editAttributes() ?> aria-describedby="x_invertor_monthly_payment_help">
<?= $Page->invertor_monthly_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invertor_monthly_payment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="master_invertor_calculator" data-field="x_master_invertor_calculator_id" data-hidden="1" name="x_master_invertor_calculator_id" id="x_master_invertor_calculator_id" value="<?= HtmlEncode($Page->master_invertor_calculator_id->CurrentValue) ?>">
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
    ew.addEventHandlers("master_invertor_calculator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
