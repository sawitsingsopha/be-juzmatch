<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakExpenseEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_expense: currentTable } });
var currentForm, currentPageID;
var fpeak_expenseedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_expenseedit = new ew.Form("fpeak_expenseedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpeak_expenseedit;

    // Add fields
    var fields = currentTable.fields;
    fpeak_expenseedit.addFields([
        ["peak_expense_id", [fields.peak_expense_id.visible && fields.peak_expense_id.required ? ew.Validators.required(fields.peak_expense_id.caption) : null], fields.peak_expense_id.isInvalid],
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["issuedDate", [fields.issuedDate.visible && fields.issuedDate.required ? ew.Validators.required(fields.issuedDate.caption) : null, ew.Validators.datetime(fields.issuedDate.clientFormatPattern)], fields.issuedDate.isInvalid],
        ["dueDate", [fields.dueDate.visible && fields.dueDate.required ? ew.Validators.required(fields.dueDate.caption) : null, ew.Validators.datetime(fields.dueDate.clientFormatPattern)], fields.dueDate.isInvalid],
        ["contactId", [fields.contactId.visible && fields.contactId.required ? ew.Validators.required(fields.contactId.caption) : null], fields.contactId.isInvalid],
        ["contactCode", [fields.contactCode.visible && fields.contactCode.required ? ew.Validators.required(fields.contactCode.caption) : null], fields.contactCode.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["isTaxInvoice", [fields.isTaxInvoice.visible && fields.isTaxInvoice.required ? ew.Validators.required(fields.isTaxInvoice.caption) : null, ew.Validators.integer], fields.isTaxInvoice.isInvalid],
        ["preTaxAmount", [fields.preTaxAmount.visible && fields.preTaxAmount.required ? ew.Validators.required(fields.preTaxAmount.caption) : null, ew.Validators.float], fields.preTaxAmount.isInvalid],
        ["vatAmount", [fields.vatAmount.visible && fields.vatAmount.required ? ew.Validators.required(fields.vatAmount.caption) : null, ew.Validators.float], fields.vatAmount.isInvalid],
        ["netAmount", [fields.netAmount.visible && fields.netAmount.required ? ew.Validators.required(fields.netAmount.caption) : null, ew.Validators.float], fields.netAmount.isInvalid],
        ["whtAmount", [fields.whtAmount.visible && fields.whtAmount.required ? ew.Validators.required(fields.whtAmount.caption) : null, ew.Validators.float], fields.whtAmount.isInvalid],
        ["paymentAmount", [fields.paymentAmount.visible && fields.paymentAmount.required ? ew.Validators.required(fields.paymentAmount.caption) : null, ew.Validators.float], fields.paymentAmount.isInvalid],
        ["remainAmount", [fields.remainAmount.visible && fields.remainAmount.required ? ew.Validators.required(fields.remainAmount.caption) : null, ew.Validators.float], fields.remainAmount.isInvalid],
        ["onlineViewLink", [fields.onlineViewLink.visible && fields.onlineViewLink.required ? ew.Validators.required(fields.onlineViewLink.caption) : null], fields.onlineViewLink.isInvalid],
        ["taxStatus", [fields.taxStatus.visible && fields.taxStatus.required ? ew.Validators.required(fields.taxStatus.caption) : null, ew.Validators.integer], fields.taxStatus.isInvalid],
        ["paymentDate", [fields.paymentDate.visible && fields.paymentDate.required ? ew.Validators.required(fields.paymentDate.caption) : null, ew.Validators.datetime(fields.paymentDate.clientFormatPattern)], fields.paymentDate.isInvalid],
        ["withHoldingTaxAmount", [fields.withHoldingTaxAmount.visible && fields.withHoldingTaxAmount.required ? ew.Validators.required(fields.withHoldingTaxAmount.caption) : null], fields.withHoldingTaxAmount.isInvalid],
        ["paymentGroupId", [fields.paymentGroupId.visible && fields.paymentGroupId.required ? ew.Validators.required(fields.paymentGroupId.caption) : null, ew.Validators.integer], fields.paymentGroupId.isInvalid],
        ["paymentTotal", [fields.paymentTotal.visible && fields.paymentTotal.required ? ew.Validators.required(fields.paymentTotal.caption) : null, ew.Validators.float], fields.paymentTotal.isInvalid],
        ["paymentMethodId", [fields.paymentMethodId.visible && fields.paymentMethodId.required ? ew.Validators.required(fields.paymentMethodId.caption) : null], fields.paymentMethodId.isInvalid],
        ["paymentMethodCode", [fields.paymentMethodCode.visible && fields.paymentMethodCode.required ? ew.Validators.required(fields.paymentMethodCode.caption) : null], fields.paymentMethodCode.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.float], fields.amount.isInvalid],
        ["journals_id", [fields.journals_id.visible && fields.journals_id.required ? ew.Validators.required(fields.journals_id.caption) : null], fields.journals_id.isInvalid],
        ["journals_code", [fields.journals_code.visible && fields.journals_code.required ? ew.Validators.required(fields.journals_code.caption) : null], fields.journals_code.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null, ew.Validators.datetime(fields.udate.clientFormatPattern)], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid],
        ["sync_detail_date", [fields.sync_detail_date.visible && fields.sync_detail_date.required ? ew.Validators.required(fields.sync_detail_date.caption) : null, ew.Validators.datetime(fields.sync_detail_date.clientFormatPattern)], fields.sync_detail_date.isInvalid]
    ]);

    // Form_CustomValidate
    fpeak_expenseedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpeak_expenseedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fpeak_expenseedit");
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
<form name="fpeak_expenseedit" id="fpeak_expenseedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_expense">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->peak_expense_id->Visible) { // peak_expense_id ?>
    <div id="r_peak_expense_id"<?= $Page->peak_expense_id->rowAttributes() ?>>
        <label id="elh_peak_expense_peak_expense_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->peak_expense_id->caption() ?><?= $Page->peak_expense_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->peak_expense_id->cellAttributes() ?>>
<span id="el_peak_expense_peak_expense_id">
<span<?= $Page->peak_expense_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->peak_expense_id->getDisplayValue($Page->peak_expense_id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="peak_expense" data-field="x_peak_expense_id" data-hidden="1" name="x_peak_expense_id" id="x_peak_expense_id" value="<?= HtmlEncode($Page->peak_expense_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_peak_expense_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_expense_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="peak_expense" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code"<?= $Page->code->rowAttributes() ?>>
        <label id="elh_peak_expense_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code->cellAttributes() ?>>
<span id="el_peak_expense_code">
<input type="<?= $Page->code->getInputTextType() ?>" name="x_code" id="x_code" data-table="peak_expense" data-field="x_code" value="<?= $Page->code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->issuedDate->Visible) { // issuedDate ?>
    <div id="r_issuedDate"<?= $Page->issuedDate->rowAttributes() ?>>
        <label id="elh_peak_expense_issuedDate" for="x_issuedDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->issuedDate->caption() ?><?= $Page->issuedDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->issuedDate->cellAttributes() ?>>
<span id="el_peak_expense_issuedDate">
<input type="<?= $Page->issuedDate->getInputTextType() ?>" name="x_issuedDate" id="x_issuedDate" data-table="peak_expense" data-field="x_issuedDate" value="<?= $Page->issuedDate->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->issuedDate->getPlaceHolder()) ?>"<?= $Page->issuedDate->editAttributes() ?> aria-describedby="x_issuedDate_help">
<?= $Page->issuedDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->issuedDate->getErrorMessage() ?></div>
<?php if (!$Page->issuedDate->ReadOnly && !$Page->issuedDate->Disabled && !isset($Page->issuedDate->EditAttrs["readonly"]) && !isset($Page->issuedDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expenseedit", "x_issuedDate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
    <div id="r_dueDate"<?= $Page->dueDate->rowAttributes() ?>>
        <label id="elh_peak_expense_dueDate" for="x_dueDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dueDate->caption() ?><?= $Page->dueDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dueDate->cellAttributes() ?>>
<span id="el_peak_expense_dueDate">
<input type="<?= $Page->dueDate->getInputTextType() ?>" name="x_dueDate" id="x_dueDate" data-table="peak_expense" data-field="x_dueDate" value="<?= $Page->dueDate->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->dueDate->getPlaceHolder()) ?>"<?= $Page->dueDate->editAttributes() ?> aria-describedby="x_dueDate_help">
<?= $Page->dueDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dueDate->getErrorMessage() ?></div>
<?php if (!$Page->dueDate->ReadOnly && !$Page->dueDate->Disabled && !isset($Page->dueDate->EditAttrs["readonly"]) && !isset($Page->dueDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expenseedit", "x_dueDate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contactId->Visible) { // contactId ?>
    <div id="r_contactId"<?= $Page->contactId->rowAttributes() ?>>
        <label id="elh_peak_expense_contactId" for="x_contactId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contactId->caption() ?><?= $Page->contactId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contactId->cellAttributes() ?>>
<span id="el_peak_expense_contactId">
<input type="<?= $Page->contactId->getInputTextType() ?>" name="x_contactId" id="x_contactId" data-table="peak_expense" data-field="x_contactId" value="<?= $Page->contactId->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contactId->getPlaceHolder()) ?>"<?= $Page->contactId->editAttributes() ?> aria-describedby="x_contactId_help">
<?= $Page->contactId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contactId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contactCode->Visible) { // contactCode ?>
    <div id="r_contactCode"<?= $Page->contactCode->rowAttributes() ?>>
        <label id="elh_peak_expense_contactCode" for="x_contactCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contactCode->caption() ?><?= $Page->contactCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contactCode->cellAttributes() ?>>
<span id="el_peak_expense_contactCode">
<input type="<?= $Page->contactCode->getInputTextType() ?>" name="x_contactCode" id="x_contactCode" data-table="peak_expense" data-field="x_contactCode" value="<?= $Page->contactCode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->contactCode->getPlaceHolder()) ?>"<?= $Page->contactCode->editAttributes() ?> aria-describedby="x_contactCode_help">
<?= $Page->contactCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contactCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_peak_expense_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_peak_expense_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="peak_expense" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isTaxInvoice->Visible) { // isTaxInvoice ?>
    <div id="r_isTaxInvoice"<?= $Page->isTaxInvoice->rowAttributes() ?>>
        <label id="elh_peak_expense_isTaxInvoice" for="x_isTaxInvoice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isTaxInvoice->caption() ?><?= $Page->isTaxInvoice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isTaxInvoice->cellAttributes() ?>>
<span id="el_peak_expense_isTaxInvoice">
<input type="<?= $Page->isTaxInvoice->getInputTextType() ?>" name="x_isTaxInvoice" id="x_isTaxInvoice" data-table="peak_expense" data-field="x_isTaxInvoice" value="<?= $Page->isTaxInvoice->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->isTaxInvoice->getPlaceHolder()) ?>"<?= $Page->isTaxInvoice->editAttributes() ?> aria-describedby="x_isTaxInvoice_help">
<?= $Page->isTaxInvoice->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isTaxInvoice->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->preTaxAmount->Visible) { // preTaxAmount ?>
    <div id="r_preTaxAmount"<?= $Page->preTaxAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_preTaxAmount" for="x_preTaxAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->preTaxAmount->caption() ?><?= $Page->preTaxAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->preTaxAmount->cellAttributes() ?>>
<span id="el_peak_expense_preTaxAmount">
<input type="<?= $Page->preTaxAmount->getInputTextType() ?>" name="x_preTaxAmount" id="x_preTaxAmount" data-table="peak_expense" data-field="x_preTaxAmount" value="<?= $Page->preTaxAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->preTaxAmount->getPlaceHolder()) ?>"<?= $Page->preTaxAmount->editAttributes() ?> aria-describedby="x_preTaxAmount_help">
<?= $Page->preTaxAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->preTaxAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vatAmount->Visible) { // vatAmount ?>
    <div id="r_vatAmount"<?= $Page->vatAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_vatAmount" for="x_vatAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vatAmount->caption() ?><?= $Page->vatAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vatAmount->cellAttributes() ?>>
<span id="el_peak_expense_vatAmount">
<input type="<?= $Page->vatAmount->getInputTextType() ?>" name="x_vatAmount" id="x_vatAmount" data-table="peak_expense" data-field="x_vatAmount" value="<?= $Page->vatAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->vatAmount->getPlaceHolder()) ?>"<?= $Page->vatAmount->editAttributes() ?> aria-describedby="x_vatAmount_help">
<?= $Page->vatAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vatAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->netAmount->Visible) { // netAmount ?>
    <div id="r_netAmount"<?= $Page->netAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_netAmount" for="x_netAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->netAmount->caption() ?><?= $Page->netAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->netAmount->cellAttributes() ?>>
<span id="el_peak_expense_netAmount">
<input type="<?= $Page->netAmount->getInputTextType() ?>" name="x_netAmount" id="x_netAmount" data-table="peak_expense" data-field="x_netAmount" value="<?= $Page->netAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->netAmount->getPlaceHolder()) ?>"<?= $Page->netAmount->editAttributes() ?> aria-describedby="x_netAmount_help">
<?= $Page->netAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->netAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->whtAmount->Visible) { // whtAmount ?>
    <div id="r_whtAmount"<?= $Page->whtAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_whtAmount" for="x_whtAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->whtAmount->caption() ?><?= $Page->whtAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->whtAmount->cellAttributes() ?>>
<span id="el_peak_expense_whtAmount">
<input type="<?= $Page->whtAmount->getInputTextType() ?>" name="x_whtAmount" id="x_whtAmount" data-table="peak_expense" data-field="x_whtAmount" value="<?= $Page->whtAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->whtAmount->getPlaceHolder()) ?>"<?= $Page->whtAmount->editAttributes() ?> aria-describedby="x_whtAmount_help">
<?= $Page->whtAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->whtAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentAmount->Visible) { // paymentAmount ?>
    <div id="r_paymentAmount"<?= $Page->paymentAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_paymentAmount" for="x_paymentAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentAmount->caption() ?><?= $Page->paymentAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentAmount->cellAttributes() ?>>
<span id="el_peak_expense_paymentAmount">
<input type="<?= $Page->paymentAmount->getInputTextType() ?>" name="x_paymentAmount" id="x_paymentAmount" data-table="peak_expense" data-field="x_paymentAmount" value="<?= $Page->paymentAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->paymentAmount->getPlaceHolder()) ?>"<?= $Page->paymentAmount->editAttributes() ?> aria-describedby="x_paymentAmount_help">
<?= $Page->paymentAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->remainAmount->Visible) { // remainAmount ?>
    <div id="r_remainAmount"<?= $Page->remainAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_remainAmount" for="x_remainAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->remainAmount->caption() ?><?= $Page->remainAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->remainAmount->cellAttributes() ?>>
<span id="el_peak_expense_remainAmount">
<input type="<?= $Page->remainAmount->getInputTextType() ?>" name="x_remainAmount" id="x_remainAmount" data-table="peak_expense" data-field="x_remainAmount" value="<?= $Page->remainAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->remainAmount->getPlaceHolder()) ?>"<?= $Page->remainAmount->editAttributes() ?> aria-describedby="x_remainAmount_help">
<?= $Page->remainAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->remainAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->onlineViewLink->Visible) { // onlineViewLink ?>
    <div id="r_onlineViewLink"<?= $Page->onlineViewLink->rowAttributes() ?>>
        <label id="elh_peak_expense_onlineViewLink" for="x_onlineViewLink" class="<?= $Page->LeftColumnClass ?>"><?= $Page->onlineViewLink->caption() ?><?= $Page->onlineViewLink->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->onlineViewLink->cellAttributes() ?>>
<span id="el_peak_expense_onlineViewLink">
<textarea data-table="peak_expense" data-field="x_onlineViewLink" name="x_onlineViewLink" id="x_onlineViewLink" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->onlineViewLink->getPlaceHolder()) ?>"<?= $Page->onlineViewLink->editAttributes() ?> aria-describedby="x_onlineViewLink_help"><?= $Page->onlineViewLink->EditValue ?></textarea>
<?= $Page->onlineViewLink->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->onlineViewLink->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->taxStatus->Visible) { // taxStatus ?>
    <div id="r_taxStatus"<?= $Page->taxStatus->rowAttributes() ?>>
        <label id="elh_peak_expense_taxStatus" for="x_taxStatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->taxStatus->caption() ?><?= $Page->taxStatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->taxStatus->cellAttributes() ?>>
<span id="el_peak_expense_taxStatus">
<input type="<?= $Page->taxStatus->getInputTextType() ?>" name="x_taxStatus" id="x_taxStatus" data-table="peak_expense" data-field="x_taxStatus" value="<?= $Page->taxStatus->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->taxStatus->getPlaceHolder()) ?>"<?= $Page->taxStatus->editAttributes() ?> aria-describedby="x_taxStatus_help">
<?= $Page->taxStatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->taxStatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
    <div id="r_paymentDate"<?= $Page->paymentDate->rowAttributes() ?>>
        <label id="elh_peak_expense_paymentDate" for="x_paymentDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentDate->caption() ?><?= $Page->paymentDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el_peak_expense_paymentDate">
<input type="<?= $Page->paymentDate->getInputTextType() ?>" name="x_paymentDate" id="x_paymentDate" data-table="peak_expense" data-field="x_paymentDate" value="<?= $Page->paymentDate->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->paymentDate->getPlaceHolder()) ?>"<?= $Page->paymentDate->editAttributes() ?> aria-describedby="x_paymentDate_help">
<?= $Page->paymentDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentDate->getErrorMessage() ?></div>
<?php if (!$Page->paymentDate->ReadOnly && !$Page->paymentDate->Disabled && !isset($Page->paymentDate->EditAttrs["readonly"]) && !isset($Page->paymentDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expenseedit", "x_paymentDate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->withHoldingTaxAmount->Visible) { // withHoldingTaxAmount ?>
    <div id="r_withHoldingTaxAmount"<?= $Page->withHoldingTaxAmount->rowAttributes() ?>>
        <label id="elh_peak_expense_withHoldingTaxAmount" for="x_withHoldingTaxAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->withHoldingTaxAmount->caption() ?><?= $Page->withHoldingTaxAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->withHoldingTaxAmount->cellAttributes() ?>>
<span id="el_peak_expense_withHoldingTaxAmount">
<input type="<?= $Page->withHoldingTaxAmount->getInputTextType() ?>" name="x_withHoldingTaxAmount" id="x_withHoldingTaxAmount" data-table="peak_expense" data-field="x_withHoldingTaxAmount" value="<?= $Page->withHoldingTaxAmount->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->withHoldingTaxAmount->getPlaceHolder()) ?>"<?= $Page->withHoldingTaxAmount->editAttributes() ?> aria-describedby="x_withHoldingTaxAmount_help">
<?= $Page->withHoldingTaxAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->withHoldingTaxAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentGroupId->Visible) { // paymentGroupId ?>
    <div id="r_paymentGroupId"<?= $Page->paymentGroupId->rowAttributes() ?>>
        <label id="elh_peak_expense_paymentGroupId" for="x_paymentGroupId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentGroupId->caption() ?><?= $Page->paymentGroupId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentGroupId->cellAttributes() ?>>
<span id="el_peak_expense_paymentGroupId">
<input type="<?= $Page->paymentGroupId->getInputTextType() ?>" name="x_paymentGroupId" id="x_paymentGroupId" data-table="peak_expense" data-field="x_paymentGroupId" value="<?= $Page->paymentGroupId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->paymentGroupId->getPlaceHolder()) ?>"<?= $Page->paymentGroupId->editAttributes() ?> aria-describedby="x_paymentGroupId_help">
<?= $Page->paymentGroupId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentGroupId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentTotal->Visible) { // paymentTotal ?>
    <div id="r_paymentTotal"<?= $Page->paymentTotal->rowAttributes() ?>>
        <label id="elh_peak_expense_paymentTotal" for="x_paymentTotal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentTotal->caption() ?><?= $Page->paymentTotal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentTotal->cellAttributes() ?>>
<span id="el_peak_expense_paymentTotal">
<input type="<?= $Page->paymentTotal->getInputTextType() ?>" name="x_paymentTotal" id="x_paymentTotal" data-table="peak_expense" data-field="x_paymentTotal" value="<?= $Page->paymentTotal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->paymentTotal->getPlaceHolder()) ?>"<?= $Page->paymentTotal->editAttributes() ?> aria-describedby="x_paymentTotal_help">
<?= $Page->paymentTotal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentTotal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentMethodId->Visible) { // paymentMethodId ?>
    <div id="r_paymentMethodId"<?= $Page->paymentMethodId->rowAttributes() ?>>
        <label id="elh_peak_expense_paymentMethodId" for="x_paymentMethodId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentMethodId->caption() ?><?= $Page->paymentMethodId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentMethodId->cellAttributes() ?>>
<span id="el_peak_expense_paymentMethodId">
<input type="<?= $Page->paymentMethodId->getInputTextType() ?>" name="x_paymentMethodId" id="x_paymentMethodId" data-table="peak_expense" data-field="x_paymentMethodId" value="<?= $Page->paymentMethodId->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->paymentMethodId->getPlaceHolder()) ?>"<?= $Page->paymentMethodId->editAttributes() ?> aria-describedby="x_paymentMethodId_help">
<?= $Page->paymentMethodId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentMethodId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentMethodCode->Visible) { // paymentMethodCode ?>
    <div id="r_paymentMethodCode"<?= $Page->paymentMethodCode->rowAttributes() ?>>
        <label id="elh_peak_expense_paymentMethodCode" for="x_paymentMethodCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentMethodCode->caption() ?><?= $Page->paymentMethodCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentMethodCode->cellAttributes() ?>>
<span id="el_peak_expense_paymentMethodCode">
<input type="<?= $Page->paymentMethodCode->getInputTextType() ?>" name="x_paymentMethodCode" id="x_paymentMethodCode" data-table="peak_expense" data-field="x_paymentMethodCode" value="<?= $Page->paymentMethodCode->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->paymentMethodCode->getPlaceHolder()) ?>"<?= $Page->paymentMethodCode->editAttributes() ?> aria-describedby="x_paymentMethodCode_help">
<?= $Page->paymentMethodCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentMethodCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_peak_expense_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<span id="el_peak_expense_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="peak_expense" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->journals_id->Visible) { // journals_id ?>
    <div id="r_journals_id"<?= $Page->journals_id->rowAttributes() ?>>
        <label id="elh_peak_expense_journals_id" for="x_journals_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->journals_id->caption() ?><?= $Page->journals_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->journals_id->cellAttributes() ?>>
<span id="el_peak_expense_journals_id">
<input type="<?= $Page->journals_id->getInputTextType() ?>" name="x_journals_id" id="x_journals_id" data-table="peak_expense" data-field="x_journals_id" value="<?= $Page->journals_id->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->journals_id->getPlaceHolder()) ?>"<?= $Page->journals_id->editAttributes() ?> aria-describedby="x_journals_id_help">
<?= $Page->journals_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->journals_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->journals_code->Visible) { // journals_code ?>
    <div id="r_journals_code"<?= $Page->journals_code->rowAttributes() ?>>
        <label id="elh_peak_expense_journals_code" for="x_journals_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->journals_code->caption() ?><?= $Page->journals_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->journals_code->cellAttributes() ?>>
<span id="el_peak_expense_journals_code">
<input type="<?= $Page->journals_code->getInputTextType() ?>" name="x_journals_code" id="x_journals_code" data-table="peak_expense" data-field="x_journals_code" value="<?= $Page->journals_code->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->journals_code->getPlaceHolder()) ?>"<?= $Page->journals_code->editAttributes() ?> aria-describedby="x_journals_code_help">
<?= $Page->journals_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->journals_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_peak_expense_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_peak_expense_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="peak_expense" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expenseedit", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_peak_expense_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_peak_expense_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="peak_expense" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_peak_expense_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_peak_expense_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="peak_expense" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <div id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <label id="elh_peak_expense_udate" for="x_udate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->udate->caption() ?><?= $Page->udate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->udate->cellAttributes() ?>>
<span id="el_peak_expense_udate">
<input type="<?= $Page->udate->getInputTextType() ?>" name="x_udate" id="x_udate" data-table="peak_expense" data-field="x_udate" value="<?= $Page->udate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->udate->getPlaceHolder()) ?>"<?= $Page->udate->editAttributes() ?> aria-describedby="x_udate_help">
<?= $Page->udate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->udate->getErrorMessage() ?></div>
<?php if (!$Page->udate->ReadOnly && !$Page->udate->Disabled && !isset($Page->udate->EditAttrs["readonly"]) && !isset($Page->udate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expenseedit", "x_udate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <div id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <label id="elh_peak_expense_uuser" for="x_uuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uuser->caption() ?><?= $Page->uuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uuser->cellAttributes() ?>>
<span id="el_peak_expense_uuser">
<input type="<?= $Page->uuser->getInputTextType() ?>" name="x_uuser" id="x_uuser" data-table="peak_expense" data-field="x_uuser" value="<?= $Page->uuser->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->uuser->getPlaceHolder()) ?>"<?= $Page->uuser->editAttributes() ?> aria-describedby="x_uuser_help">
<?= $Page->uuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uuser->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <div id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <label id="elh_peak_expense_uip" for="x_uip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uip->caption() ?><?= $Page->uip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uip->cellAttributes() ?>>
<span id="el_peak_expense_uip">
<input type="<?= $Page->uip->getInputTextType() ?>" name="x_uip" id="x_uip" data-table="peak_expense" data-field="x_uip" value="<?= $Page->uip->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->uip->getPlaceHolder()) ?>"<?= $Page->uip->editAttributes() ?> aria-describedby="x_uip_help">
<?= $Page->uip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sync_detail_date->Visible) { // sync_detail_date ?>
    <div id="r_sync_detail_date"<?= $Page->sync_detail_date->rowAttributes() ?>>
        <label id="elh_peak_expense_sync_detail_date" for="x_sync_detail_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sync_detail_date->caption() ?><?= $Page->sync_detail_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sync_detail_date->cellAttributes() ?>>
<span id="el_peak_expense_sync_detail_date">
<input type="<?= $Page->sync_detail_date->getInputTextType() ?>" name="x_sync_detail_date" id="x_sync_detail_date" data-table="peak_expense" data-field="x_sync_detail_date" value="<?= $Page->sync_detail_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->sync_detail_date->getPlaceHolder()) ?>"<?= $Page->sync_detail_date->editAttributes() ?> aria-describedby="x_sync_detail_date_help">
<?= $Page->sync_detail_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sync_detail_date->getErrorMessage() ?></div>
<?php if (!$Page->sync_detail_date->ReadOnly && !$Page->sync_detail_date->Disabled && !isset($Page->sync_detail_date->EditAttrs["readonly"]) && !isset($Page->sync_detail_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpeak_expenseedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpeak_expenseedit", "x_sync_detail_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
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
    ew.addEventHandlers("peak_expense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
