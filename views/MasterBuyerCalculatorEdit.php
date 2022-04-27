<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MasterBuyerCalculatorEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { master_buyer_calculator: currentTable } });
var currentForm, currentPageID;
var fmaster_buyer_calculatoredit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmaster_buyer_calculatoredit = new ew.Form("fmaster_buyer_calculatoredit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fmaster_buyer_calculatoredit;

    // Add fields
    var fields = currentTable.fields;
    fmaster_buyer_calculatoredit.addFields([
        ["buyer_monthly_payment", [fields.buyer_monthly_payment.visible && fields.buyer_monthly_payment.required ? ew.Validators.required(fields.buyer_monthly_payment.caption) : null, ew.Validators.float], fields.buyer_monthly_payment.isInvalid],
        ["buyer_monthly_annual_interest", [fields.buyer_monthly_annual_interest.visible && fields.buyer_monthly_annual_interest.required ? ew.Validators.required(fields.buyer_monthly_annual_interest.caption) : null, ew.Validators.float], fields.buyer_monthly_annual_interest.isInvalid],
        ["buyer_dsr_ratio", [fields.buyer_dsr_ratio.visible && fields.buyer_dsr_ratio.required ? ew.Validators.required(fields.buyer_dsr_ratio.caption) : null, ew.Validators.float], fields.buyer_dsr_ratio.isInvalid],
        ["buyer_down_payment", [fields.buyer_down_payment.visible && fields.buyer_down_payment.required ? ew.Validators.required(fields.buyer_down_payment.caption) : null, ew.Validators.float], fields.buyer_down_payment.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["udata", [fields.udata.visible && fields.udata.required ? ew.Validators.required(fields.udata.caption) : null], fields.udata.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid]
    ]);

    // Form_CustomValidate
    fmaster_buyer_calculatoredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmaster_buyer_calculatoredit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fmaster_buyer_calculatoredit");
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
<form name="fmaster_buyer_calculatoredit" id="fmaster_buyer_calculatoredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="master_buyer_calculator">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->buyer_monthly_payment->Visible) { // buyer_monthly_payment ?>
    <div id="r_buyer_monthly_payment"<?= $Page->buyer_monthly_payment->rowAttributes() ?>>
        <label id="elh_master_buyer_calculator_buyer_monthly_payment" for="x_buyer_monthly_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_monthly_payment->caption() ?><?= $Page->buyer_monthly_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_monthly_payment->cellAttributes() ?>>
<span id="el_master_buyer_calculator_buyer_monthly_payment">
<input type="<?= $Page->buyer_monthly_payment->getInputTextType() ?>" name="x_buyer_monthly_payment" id="x_buyer_monthly_payment" data-table="master_buyer_calculator" data-field="x_buyer_monthly_payment" value="<?= $Page->buyer_monthly_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->buyer_monthly_payment->getPlaceHolder()) ?>"<?= $Page->buyer_monthly_payment->editAttributes() ?> aria-describedby="x_buyer_monthly_payment_help">
<?= $Page->buyer_monthly_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_monthly_payment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_monthly_annual_interest->Visible) { // buyer_monthly_annual_interest ?>
    <div id="r_buyer_monthly_annual_interest"<?= $Page->buyer_monthly_annual_interest->rowAttributes() ?>>
        <label id="elh_master_buyer_calculator_buyer_monthly_annual_interest" for="x_buyer_monthly_annual_interest" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_monthly_annual_interest->caption() ?><?= $Page->buyer_monthly_annual_interest->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_monthly_annual_interest->cellAttributes() ?>>
<span id="el_master_buyer_calculator_buyer_monthly_annual_interest">
<input type="<?= $Page->buyer_monthly_annual_interest->getInputTextType() ?>" name="x_buyer_monthly_annual_interest" id="x_buyer_monthly_annual_interest" data-table="master_buyer_calculator" data-field="x_buyer_monthly_annual_interest" value="<?= $Page->buyer_monthly_annual_interest->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->buyer_monthly_annual_interest->getPlaceHolder()) ?>"<?= $Page->buyer_monthly_annual_interest->editAttributes() ?> aria-describedby="x_buyer_monthly_annual_interest_help">
<?= $Page->buyer_monthly_annual_interest->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_monthly_annual_interest->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_dsr_ratio->Visible) { // buyer_dsr_ratio ?>
    <div id="r_buyer_dsr_ratio"<?= $Page->buyer_dsr_ratio->rowAttributes() ?>>
        <label id="elh_master_buyer_calculator_buyer_dsr_ratio" for="x_buyer_dsr_ratio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_dsr_ratio->caption() ?><?= $Page->buyer_dsr_ratio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_dsr_ratio->cellAttributes() ?>>
<span id="el_master_buyer_calculator_buyer_dsr_ratio">
<input type="<?= $Page->buyer_dsr_ratio->getInputTextType() ?>" name="x_buyer_dsr_ratio" id="x_buyer_dsr_ratio" data-table="master_buyer_calculator" data-field="x_buyer_dsr_ratio" value="<?= $Page->buyer_dsr_ratio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->buyer_dsr_ratio->getPlaceHolder()) ?>"<?= $Page->buyer_dsr_ratio->editAttributes() ?> aria-describedby="x_buyer_dsr_ratio_help">
<?= $Page->buyer_dsr_ratio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_dsr_ratio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buyer_down_payment->Visible) { // buyer_down_payment ?>
    <div id="r_buyer_down_payment"<?= $Page->buyer_down_payment->rowAttributes() ?>>
        <label id="elh_master_buyer_calculator_buyer_down_payment" for="x_buyer_down_payment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buyer_down_payment->caption() ?><?= $Page->buyer_down_payment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->buyer_down_payment->cellAttributes() ?>>
<span id="el_master_buyer_calculator_buyer_down_payment">
<input type="<?= $Page->buyer_down_payment->getInputTextType() ?>" name="x_buyer_down_payment" id="x_buyer_down_payment" data-table="master_buyer_calculator" data-field="x_buyer_down_payment" value="<?= $Page->buyer_down_payment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->buyer_down_payment->getPlaceHolder()) ?>"<?= $Page->buyer_down_payment->editAttributes() ?> aria-describedby="x_buyer_down_payment_help">
<?= $Page->buyer_down_payment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buyer_down_payment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="master_buyer_calculator" data-field="x_master_buyer_calculator_id" data-hidden="1" name="x_master_buyer_calculator_id" id="x_master_buyer_calculator_id" value="<?= HtmlEncode($Page->master_buyer_calculator_id->CurrentValue) ?>">
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
    ew.addEventHandlers("master_buyer_calculator");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
