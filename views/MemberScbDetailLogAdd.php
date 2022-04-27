<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberScbDetailLogAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member_scb_detail_log: currentTable } });
var currentForm, currentPageID;
var fmember_scb_detail_logadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmember_scb_detail_logadd = new ew.Form("fmember_scb_detail_logadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fmember_scb_detail_logadd;

    // Add fields
    var fields = currentTable.fields;
    fmember_scb_detail_logadd.addFields([
        ["member_scb_id", [fields.member_scb_id.visible && fields.member_scb_id.required ? ew.Validators.required(fields.member_scb_id.caption) : null, ew.Validators.integer], fields.member_scb_id.isInvalid],
        ["paid_amt", [fields.paid_amt.visible && fields.paid_amt.required ? ew.Validators.required(fields.paid_amt.caption) : null, ew.Validators.float], fields.paid_amt.isInvalid],
        ["pay_date", [fields.pay_date.visible && fields.pay_date.required ? ew.Validators.required(fields.pay_date.caption) : null, ew.Validators.datetime(fields.pay_date.clientFormatPattern)], fields.pay_date.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null, ew.Validators.datetime(fields.cdate.clientFormatPattern)], fields.cdate.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid]
    ]);

    // Form_CustomValidate
    fmember_scb_detail_logadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmember_scb_detail_logadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fmember_scb_detail_logadd");
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
<form name="fmember_scb_detail_logadd" id="fmember_scb_detail_logadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member_scb_detail_log">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->member_scb_id->Visible) { // member_scb_id ?>
    <div id="r_member_scb_id"<?= $Page->member_scb_id->rowAttributes() ?>>
        <label id="elh_member_scb_detail_log_member_scb_id" for="x_member_scb_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_scb_id->caption() ?><?= $Page->member_scb_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_scb_id->cellAttributes() ?>>
<span id="el_member_scb_detail_log_member_scb_id">
<input type="<?= $Page->member_scb_id->getInputTextType() ?>" name="x_member_scb_id" id="x_member_scb_id" data-table="member_scb_detail_log" data-field="x_member_scb_id" value="<?= $Page->member_scb_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->member_scb_id->getPlaceHolder()) ?>"<?= $Page->member_scb_id->editAttributes() ?> aria-describedby="x_member_scb_id_help">
<?= $Page->member_scb_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->member_scb_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paid_amt->Visible) { // paid_amt ?>
    <div id="r_paid_amt"<?= $Page->paid_amt->rowAttributes() ?>>
        <label id="elh_member_scb_detail_log_paid_amt" for="x_paid_amt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paid_amt->caption() ?><?= $Page->paid_amt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paid_amt->cellAttributes() ?>>
<span id="el_member_scb_detail_log_paid_amt">
<input type="<?= $Page->paid_amt->getInputTextType() ?>" name="x_paid_amt" id="x_paid_amt" data-table="member_scb_detail_log" data-field="x_paid_amt" value="<?= $Page->paid_amt->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->paid_amt->getPlaceHolder()) ?>"<?= $Page->paid_amt->editAttributes() ?> aria-describedby="x_paid_amt_help">
<?= $Page->paid_amt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paid_amt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pay_date->Visible) { // pay_date ?>
    <div id="r_pay_date"<?= $Page->pay_date->rowAttributes() ?>>
        <label id="elh_member_scb_detail_log_pay_date" for="x_pay_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pay_date->caption() ?><?= $Page->pay_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pay_date->cellAttributes() ?>>
<span id="el_member_scb_detail_log_pay_date">
<input type="<?= $Page->pay_date->getInputTextType() ?>" name="x_pay_date" id="x_pay_date" data-table="member_scb_detail_log" data-field="x_pay_date" value="<?= $Page->pay_date->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->pay_date->getPlaceHolder()) ?>"<?= $Page->pay_date->editAttributes() ?> aria-describedby="x_pay_date_help">
<?= $Page->pay_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pay_date->getErrorMessage() ?></div>
<?php if (!$Page->pay_date->ReadOnly && !$Page->pay_date->Disabled && !isset($Page->pay_date->EditAttrs["readonly"]) && !isset($Page->pay_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmember_scb_detail_logadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fmember_scb_detail_logadd", "x_pay_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <div id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <label id="elh_member_scb_detail_log_cdate" for="x_cdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cdate->caption() ?><?= $Page->cdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cdate->cellAttributes() ?>>
<span id="el_member_scb_detail_log_cdate">
<input type="<?= $Page->cdate->getInputTextType() ?>" name="x_cdate" id="x_cdate" data-table="member_scb_detail_log" data-field="x_cdate" value="<?= $Page->cdate->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->cdate->getPlaceHolder()) ?>"<?= $Page->cdate->editAttributes() ?> aria-describedby="x_cdate_help">
<?= $Page->cdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cdate->getErrorMessage() ?></div>
<?php if (!$Page->cdate->ReadOnly && !$Page->cdate->Disabled && !isset($Page->cdate->EditAttrs["readonly"]) && !isset($Page->cdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmember_scb_detail_logadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fmember_scb_detail_logadd", "x_cdate", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <div id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <label id="elh_member_scb_detail_log_cip" for="x_cip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cip->caption() ?><?= $Page->cip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cip->cellAttributes() ?>>
<span id="el_member_scb_detail_log_cip">
<input type="<?= $Page->cip->getInputTextType() ?>" name="x_cip" id="x_cip" data-table="member_scb_detail_log" data-field="x_cip" value="<?= $Page->cip->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->cip->getPlaceHolder()) ?>"<?= $Page->cip->editAttributes() ?> aria-describedby="x_cip_help">
<?= $Page->cip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <div id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <label id="elh_member_scb_detail_log_cuser" for="x_cuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuser->caption() ?><?= $Page->cuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuser->cellAttributes() ?>>
<span id="el_member_scb_detail_log_cuser">
<input type="<?= $Page->cuser->getInputTextType() ?>" name="x_cuser" id="x_cuser" data-table="member_scb_detail_log" data-field="x_cuser" value="<?= $Page->cuser->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cuser->getPlaceHolder()) ?>"<?= $Page->cuser->editAttributes() ?> aria-describedby="x_cuser_help">
<?= $Page->cuser->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuser->getErrorMessage() ?></div>
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
    ew.addEventHandlers("member_scb_detail_log");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
