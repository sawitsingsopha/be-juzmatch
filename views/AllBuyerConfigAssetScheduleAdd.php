<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllBuyerConfigAssetScheduleAdd = &$Page;

// ดึงค่าจอง
if(isset($_GET['fk_asset_id'])) {
    $asset_id = $_GET['fk_asset_id'];
    $sql_booking = "SELECT * FROM `buyer_booking_asset` WHERE asset_id = ".$asset_id." AND status_payment = 2 LIMIT 0,1";
    $res_booking = ExecuteRow($sql_booking);
    $booking_price = $res_booking['booking_price'];

    // set booking_price
    $Page->booking_price->EditValue = $booking_price;
}

// ดึงค่าเงินดาวน์
if(isset($_GET['fk_asset_id'])) {
    $asset_id = $_GET['fk_asset_id'];
    $sql_down_payment = "SELECT `buyer_asset_rent_id`, `asset_id`, `member_id`, `one_time_status`, `half_price_1`, `status_pay_half_price_1`, `half_price_2`, `status_pay_half_price_2`, (CASE WHEN one_time_status = 0 THEN half_price_1+half_price_2 WHEN one_time_status = 1 THEN half_price_1 END) as sum_half_price FROM `buyer_asset_rent` WHERE asset_id = ".$asset_id." ORDER BY buyer_asset_rent_id DESC LIMIT 0,1";
    $res_down_payment = ExecuteRow($sql_down_payment);
    $down_price = $res_down_payment['sum_half_price'];

    // set booking_price
    $Page->down_price->EditValue = $down_price;
}

// จำนวนงวด
$Page->installment_all->EditValue = 36;

if(isset($_GET['installment'])) {
    $installment = $_GET['installment'];

    // จำนวนงวด
    $Page->installment_all->EditValue = $installment;
}

// ดอกเบี้ยรายปี
$Page->annual_interest->EditValue = 4.5;

// จำนวนวันต่อเดือนของเดือนแรก (Default เดือนปัจจุบัน)
$mydate=getdate(date("U"));
$lates_date_of_mount = cal_days_in_month(CAL_GREGORIAN, $mydate['mon'], $mydate['year']);
$Page->number_days_in_first_month->EditValue = $lates_date_of_mount;
?>

<style>
    .ew-form{width: 100% !important;}
    .card {
        width: 100%;
        height: auto;
        padding: 20px 30px;
        margin-bottom: 12px;
        border-radius: 12px;
        -webkit-box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 15%);
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 15%);
        border: 2px solid #006aec;
    }
    p{
        margin-bottom: 0;
        display: inline;
        margin-left: 5px;
        font-weight: 700;
    }
    .ew-table-last-col,.ew-add-blank-row{
        display: none;
    }

    th[data-name="pay_number"],
    td[data-name="pay_number"],
    th[data-name="date_payment"],
    td[data-name="date_payment"],
    th[data-name="status_payment"],
    td[data-name="status_payment"]
    {
        display: none;
    }
</style>

<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { all_buyer_config_asset_schedule: currentTable } });
var currentForm, currentPageID;
var fall_buyer_config_asset_scheduleadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fall_buyer_config_asset_scheduleadd = new ew.Form("fall_buyer_config_asset_scheduleadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fall_buyer_config_asset_scheduleadd;

    // Add fields
    var fields = currentTable.fields;
    fall_buyer_config_asset_scheduleadd.addFields([
        ["member_id", [fields.member_id.visible && fields.member_id.required ? ew.Validators.required(fields.member_id.caption) : null], fields.member_id.isInvalid],
        ["asset_id", [fields.asset_id.visible && fields.asset_id.required ? ew.Validators.required(fields.asset_id.caption) : null], fields.asset_id.isInvalid],
        ["installment_all", [fields.installment_all.visible && fields.installment_all.required ? ew.Validators.required(fields.installment_all.caption) : null, ew.Validators.integer], fields.installment_all.isInvalid],
        ["asset_price", [fields.asset_price.visible && fields.asset_price.required ? ew.Validators.required(fields.asset_price.caption) : null, ew.Validators.float], fields.asset_price.isInvalid],
        ["booking_price", [fields.booking_price.visible && fields.booking_price.required ? ew.Validators.required(fields.booking_price.caption) : null, ew.Validators.float], fields.booking_price.isInvalid],
        ["down_price", [fields.down_price.visible && fields.down_price.required ? ew.Validators.required(fields.down_price.caption) : null, ew.Validators.float], fields.down_price.isInvalid],
        ["installment_price_per", [fields.installment_price_per.visible && fields.installment_price_per.required ? ew.Validators.required(fields.installment_price_per.caption) : null, ew.Validators.float], fields.installment_price_per.isInvalid],
        ["annual_interest", [fields.annual_interest.visible && fields.annual_interest.required ? ew.Validators.required(fields.annual_interest.caption) : null, ew.Validators.float], fields.annual_interest.isInvalid],
        ["number_days_pay_first_month", [fields.number_days_pay_first_month.visible && fields.number_days_pay_first_month.required ? ew.Validators.required(fields.number_days_pay_first_month.caption) : null, ew.Validators.integer], fields.number_days_pay_first_month.isInvalid],
        ["number_days_in_first_month", [fields.number_days_in_first_month.visible && fields.number_days_in_first_month.required ? ew.Validators.required(fields.number_days_in_first_month.caption) : null, ew.Validators.integer], fields.number_days_in_first_month.isInvalid],
        ["move_in_on_20th", [fields.move_in_on_20th.visible && fields.move_in_on_20th.required ? ew.Validators.required(fields.move_in_on_20th.caption) : null], fields.move_in_on_20th.isInvalid],
        ["date_start_installment", [fields.date_start_installment.visible && fields.date_start_installment.required ? ew.Validators.required(fields.date_start_installment.caption) : null, ew.Validators.datetime(fields.date_start_installment.clientFormatPattern)], fields.date_start_installment.isInvalid],
        ["status_approve", [fields.status_approve.visible && fields.status_approve.required ? ew.Validators.required(fields.status_approve.caption) : null], fields.status_approve.isInvalid],
        ["cdate", [fields.cdate.visible && fields.cdate.required ? ew.Validators.required(fields.cdate.caption) : null], fields.cdate.isInvalid],
        ["cuser", [fields.cuser.visible && fields.cuser.required ? ew.Validators.required(fields.cuser.caption) : null], fields.cuser.isInvalid],
        ["cip", [fields.cip.visible && fields.cip.required ? ew.Validators.required(fields.cip.caption) : null], fields.cip.isInvalid],
        ["udate", [fields.udate.visible && fields.udate.required ? ew.Validators.required(fields.udate.caption) : null], fields.udate.isInvalid],
        ["uuser", [fields.uuser.visible && fields.uuser.required ? ew.Validators.required(fields.uuser.caption) : null], fields.uuser.isInvalid],
        ["uip", [fields.uip.visible && fields.uip.required ? ew.Validators.required(fields.uip.caption) : null], fields.uip.isInvalid]
    ]);

    // Form_CustomValidate
    fall_buyer_config_asset_scheduleadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fall_buyer_config_asset_scheduleadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fall_buyer_config_asset_scheduleadd.lists.member_id = <?= $Page->member_id->toClientList($Page) ?>;
    fall_buyer_config_asset_scheduleadd.lists.asset_id = <?= $Page->asset_id->toClientList($Page) ?>;
    fall_buyer_config_asset_scheduleadd.lists.move_in_on_20th = <?= $Page->move_in_on_20th->toClientList($Page) ?>;
    fall_buyer_config_asset_scheduleadd.lists.status_approve = <?= $Page->status_approve->toClientList($Page) ?>;
    loadjs.done("fall_buyer_config_asset_scheduleadd");
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
<form name="fall_buyer_config_asset_scheduleadd" id="fall_buyer_config_asset_scheduleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="all_buyer_config_asset_schedule">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "buyer_all_booking_asset") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="buyer_all_booking_asset">
<input type="hidden" name="fk_asset_id" value="<?= HtmlEncode($Page->asset_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->member_id->Visible) { // member_id ?>
    <div id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_member_id" for="x_member_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->member_id->caption() ?><?= $Page->member_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->member_id->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_member_id">
    <select
        readonly
        id="x_member_id"
        name="x_member_id"
        class="form-select ew-select<?= $Page->member_id->isInvalidClass() ?>"
        data-select2-id="fall_buyer_config_asset_scheduleadd_x_member_id"
        data-table="all_buyer_config_asset_schedule"
        data-field="x_member_id"
        data-value-separator="<?= $Page->member_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->member_id->getPlaceHolder()) ?>"
        <?= $Page->member_id->editAttributes() ?>>
        <?= $Page->member_id->selectOptionListHtml("x_member_id") ?>
    </select>
    <?= $Page->member_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->member_id->getErrorMessage() ?></div>
<?= $Page->member_id->Lookup->getParamTag($Page, "p_x_member_id") ?>
<script>
loadjs.ready("fall_buyer_config_asset_scheduleadd", function() {
    var options = { name: "x_member_id", selectId: "fall_buyer_config_asset_scheduleadd_x_member_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_config_asset_scheduleadd.lists.member_id.lookupOptions.length) {
        options.data = { id: "x_member_id", form: "fall_buyer_config_asset_scheduleadd" };
    } else {
        options.ajax = { id: "x_member_id", form: "fall_buyer_config_asset_scheduleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_config_asset_schedule.fields.member_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <div id="r_asset_id"<?= $Page->asset_id->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_asset_id" for="x_asset_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_id->caption() ?><?= $Page->asset_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_id->cellAttributes() ?>>
<?php if ($Page->asset_id->getSessionValue() != "") { ?>
<span id="el_all_buyer_config_asset_schedule_asset_id">
<span<?= $Page->asset_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->asset_id->getDisplayValue($Page->asset_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_asset_id" name="x_asset_id" value="<?= HtmlEncode(FormatNumber($Page->asset_id->CurrentValue, $Page->asset_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_all_buyer_config_asset_schedule_asset_id">
    <select
        id="x_asset_id"
        name="x_asset_id"
        class="form-select ew-select<?= $Page->asset_id->isInvalidClass() ?>"
        data-select2-id="fall_buyer_config_asset_scheduleadd_x_asset_id"
        data-table="all_buyer_config_asset_schedule"
        data-field="x_asset_id"
        data-value-separator="<?= $Page->asset_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->asset_id->getPlaceHolder()) ?>"
        <?= $Page->asset_id->editAttributes() ?>>
        <?= $Page->asset_id->selectOptionListHtml("x_asset_id") ?>
    </select>
    <?= $Page->asset_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->asset_id->getErrorMessage() ?></div>
<?= $Page->asset_id->Lookup->getParamTag($Page, "p_x_asset_id") ?>
<script>
loadjs.ready("fall_buyer_config_asset_scheduleadd", function() {
    var options = { name: "x_asset_id", selectId: "fall_buyer_config_asset_scheduleadd_x_asset_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_config_asset_scheduleadd.lists.asset_id.lookupOptions.length) {
        options.data = { id: "x_asset_id", form: "fall_buyer_config_asset_scheduleadd" };
    } else {
        options.ajax = { id: "x_asset_id", form: "fall_buyer_config_asset_scheduleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_config_asset_schedule.fields.asset_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_all->Visible) { // installment_all ?>
    <div id="r_installment_all"<?= $Page->installment_all->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_installment_all" for="x_installment_all" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_all->caption() ?><?= $Page->installment_all->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_all->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_installment_all">
<input type="<?= $Page->installment_all->getInputTextType() ?>" style="max-width: 120px;" name="x_installment_all" id="x_installment_all" data-table="all_buyer_config_asset_schedule" data-field="x_installment_all" value="<?= $Page->installment_all->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_all->getPlaceHolder()) ?>"<?= $Page->installment_all->editAttributes() ?> aria-describedby="x_installment_all_help">
<p>งวด</p>
&nbsp;
&nbsp;
&nbsp;
<button type="button" id="config_installment" class="btn btn-primary">ตั้งค่างวดใหม่</button>
<?= $Page->installment_all->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_all->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
    <div id="r_asset_price"<?= $Page->asset_price->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_asset_price" for="x_asset_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asset_price->caption() ?><?= $Page->asset_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->asset_price->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_asset_price">
<input type="<?= $Page->asset_price->getInputTextType() ?>" name="x_asset_price" id="x_asset_price" data-table="all_buyer_config_asset_schedule" data-field="x_asset_price" value="<?= $Page->asset_price->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->asset_price->getPlaceHolder()) ?>"<?= $Page->asset_price->editAttributes() ?> aria-describedby="x_asset_price_help">
<p>฿</p>
<?= $Page->asset_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asset_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <div id="r_booking_price"<?= $Page->booking_price->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_booking_price" for="x_booking_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->booking_price->caption() ?><?= $Page->booking_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->booking_price->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_booking_price">
<input readonly type="<?= $Page->booking_price->getInputTextType() ?>" name="x_booking_price" id="x_booking_price" data-table="all_buyer_config_asset_schedule" data-field="x_booking_price" value="<?= $Page->booking_price->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->booking_price->getPlaceHolder()) ?>"<?= $Page->booking_price->editAttributes() ?> aria-describedby="x_booking_price_help">
<p>฿</p>
<?= $Page->booking_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->booking_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
    <div id="r_down_price"<?= $Page->down_price->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_down_price" for="x_down_price" class="<?= $Page->LeftColumnClass ?>"><?= $Page->down_price->caption() ?><?= $Page->down_price->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->down_price->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_down_price">
<input readonly type="<?= $Page->down_price->getInputTextType() ?>" name="x_down_price" id="x_down_price" data-table="all_buyer_config_asset_schedule" data-field="x_down_price" value="<?= $Page->down_price->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->down_price->getPlaceHolder()) ?>"<?= $Page->down_price->editAttributes() ?> aria-describedby="x_down_price_help">
<p>฿</p>
<?= $Page->down_price->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->down_price->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
    <div id="r_installment_price_per"<?= $Page->installment_price_per->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_installment_price_per" for="x_installment_price_per" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment_price_per->caption() ?><?= $Page->installment_price_per->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment_price_per->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_installment_price_per">
<input type="<?= $Page->installment_price_per->getInputTextType() ?>" name="x_installment_price_per" id="x_installment_price_per" data-table="all_buyer_config_asset_schedule" data-field="x_installment_price_per" value="<?= $Page->installment_price_per->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment_price_per->getPlaceHolder()) ?>"<?= $Page->installment_price_per->editAttributes() ?> aria-describedby="x_installment_price_per_help">
<p>฿</p>
<?= $Page->installment_price_per->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment_price_per->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->annual_interest->Visible) { // annual_interest ?>
    <div id="r_annual_interest"<?= $Page->annual_interest->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_annual_interest" for="x_annual_interest" class="<?= $Page->LeftColumnClass ?>"><?= $Page->annual_interest->caption() ?><?= $Page->annual_interest->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->annual_interest->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_annual_interest">
<input type="<?= $Page->annual_interest->getInputTextType() ?>" style="max-width: 120px;" name="x_annual_interest" id="x_annual_interest" data-table="all_buyer_config_asset_schedule" data-field="x_annual_interest" value="<?= $Page->annual_interest->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->annual_interest->getPlaceHolder()) ?>"<?= $Page->annual_interest->editAttributes() ?> aria-describedby="x_annual_interest_help">
<p>%</p>
<?= $Page->annual_interest->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->annual_interest->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
    <div id="r_move_in_on_20th"<?= $Page->move_in_on_20th->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_move_in_on_20th" class="<?= $Page->LeftColumnClass ?>"><?= $Page->move_in_on_20th->caption() ?><?= $Page->move_in_on_20th->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->move_in_on_20th->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_move_in_on_20th">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->move_in_on_20th->isInvalidClass() ?>" data-table="all_buyer_config_asset_schedule" data-field="x_move_in_on_20th" name="x_move_in_on_20th[]" id="x_move_in_on_20th_317805" value="1"<?= ConvertToBool($Page->move_in_on_20th->CurrentValue) ? " checked" : "" ?><?= $Page->move_in_on_20th->editAttributes() ?> aria-describedby="x_move_in_on_20th_help">
    <div class="invalid-feedback"><?= $Page->move_in_on_20th->getErrorMessage() ?></div>
</div>
<?= $Page->move_in_on_20th->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>

<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
    <div id="r_number_days_pay_first_month"<?= $Page->number_days_pay_first_month->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_number_days_pay_first_month" for="x_number_days_pay_first_month" class="<?= $Page->LeftColumnClass ?>"><?= $Page->number_days_pay_first_month->caption() ?><?= $Page->number_days_pay_first_month->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->number_days_pay_first_month->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_number_days_pay_first_month">
<input type="<?= $Page->number_days_pay_first_month->getInputTextType() ?>" style="max-width: 120px;" name="x_number_days_pay_first_month" id="x_number_days_pay_first_month" data-table="all_buyer_config_asset_schedule" data-field="x_number_days_pay_first_month" value="<?= $Page->number_days_pay_first_month->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->number_days_pay_first_month->getPlaceHolder()) ?>"<?= $Page->number_days_pay_first_month->editAttributes() ?> aria-describedby="x_number_days_pay_first_month_help">
<p>วัน</p>
<?= $Page->number_days_pay_first_month->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->number_days_pay_first_month->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
    <div id="r_number_days_in_first_month"<?= $Page->number_days_in_first_month->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_number_days_in_first_month" for="x_number_days_in_first_month" class="<?= $Page->LeftColumnClass ?>"><?= $Page->number_days_in_first_month->caption() ?><?= $Page->number_days_in_first_month->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->number_days_in_first_month->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_number_days_in_first_month">
<input type="<?= $Page->number_days_in_first_month->getInputTextType() ?>" style="max-width: 120px;" name="x_number_days_in_first_month" id="x_number_days_in_first_month" data-table="all_buyer_config_asset_schedule" data-field="x_number_days_in_first_month" value="<?= $Page->number_days_in_first_month->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->number_days_in_first_month->getPlaceHolder()) ?>"<?= $Page->number_days_in_first_month->editAttributes() ?> aria-describedby="x_number_days_in_first_month_help">
<p>วัน</p>
<?= $Page->number_days_in_first_month->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->number_days_in_first_month->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>

<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
    <div id="r_date_start_installment"<?= $Page->date_start_installment->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_date_start_installment" for="x_date_start_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_start_installment->caption() ?><?= $Page->date_start_installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date_start_installment->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_date_start_installment">
<input type="<?= $Page->date_start_installment->getInputTextType() ?>" name="x_date_start_installment" id="x_date_start_installment" data-table="all_buyer_config_asset_schedule" data-field="x_date_start_installment" value="<?= $Page->date_start_installment->EditValue ?>" placeholder="<?= HtmlEncode($Page->date_start_installment->getPlaceHolder()) ?>"<?= $Page->date_start_installment->editAttributes() ?> aria-describedby="x_date_start_installment_help">
<?= $Page->date_start_installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_start_installment->getErrorMessage() ?></div>
<?php if (!$Page->date_start_installment->ReadOnly && !$Page->date_start_installment->Disabled && !isset($Page->date_start_installment->EditAttrs["readonly"]) && !isset($Page->date_start_installment->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fall_buyer_config_asset_scheduleadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fall_buyer_config_asset_scheduleadd", "x_date_start_installment", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
    <div id="r_status_approve"<?= $Page->status_approve->rowAttributes() ?>>
        <label id="elh_all_buyer_config_asset_schedule_status_approve" for="x_status_approve" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_approve->caption() ?><?= $Page->status_approve->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_approve->cellAttributes() ?>>
<span id="el_all_buyer_config_asset_schedule_status_approve">
    <select
        id="x_status_approve"
        name="x_status_approve"
        class="form-select ew-select<?= $Page->status_approve->isInvalidClass() ?>"
        data-select2-id="fall_buyer_config_asset_scheduleadd_x_status_approve"
        data-table="all_buyer_config_asset_schedule"
        data-field="x_status_approve"
        data-value-separator="<?= $Page->status_approve->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status_approve->getPlaceHolder()) ?>"
        <?= $Page->status_approve->editAttributes() ?>>
        <?= $Page->status_approve->selectOptionListHtml("x_status_approve") ?>
    </select>
    <?= $Page->status_approve->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status_approve->getErrorMessage() ?></div>
<script>
loadjs.ready("fall_buyer_config_asset_scheduleadd", function() {
    var options = { name: "x_status_approve", selectId: "fall_buyer_config_asset_scheduleadd_x_status_approve" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fall_buyer_config_asset_scheduleadd.lists.status_approve.lookupOptions.length) {
        options.data = { id: "x_status_approve", form: "fall_buyer_config_asset_scheduleadd" };
    } else {
        options.ajax = { id: "x_status_approve", form: "fall_buyer_config_asset_scheduleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.all_buyer_config_asset_schedule.fields.status_approve.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->

<script>
loadjs.ready("load", function () {
    $('#config_installment').on('click', function() {
        console.log("ตั้งค่างวดใหม่");
        // Retrieve the id from the hidden field.
        let installment = $('input[name="x_installment_all"]').val();

        // Construct URLSearchParams object instance from current URL querystring.
        var queryParams = new URLSearchParams(window.location.search);
        var pathname = window.location.pathname;
        var origin   = window.location.origin;
        
        // Set new or modify existing parameter value. 
        queryParams.set("installment", installment);
        
        console.log(origin+pathname+"?"+queryParams.toString());
        // console.log(decodeURIComponent(origin+"/"+pathname+"/"+queryParams.toString()));
        const newUrl = new URLSearchParams(origin+pathname+"?"+queryParams.toString());
        // Replace current querystring with the new one.
        history.replaceState(null, null, "?"+queryParams.toString());
        location.reload();
        // https://uatbackend.juzmatch.com/allbuyerconfigassetscheduleadd?showdetail=all_buyer_asset_schedule&showmaster=buyer_all_booking_asset&fk_asset_id=172&installment=60
        // https://uatbackend.juzmatch.com/allbuyerconfigassetscheduleadd?showdetail=all_buyer_asset_schedule&showmaster=buyer_all_booking_asset&fk_asset_id=172
    });
});
</script>


<?php
    if (in_array("all_buyer_asset_schedule", explode(",", $Page->getCurrentDetailTable())) && $all_buyer_asset_schedule->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("all_buyer_asset_schedule", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AllBuyerAssetScheduleGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("all_buyer_config_asset_schedule");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
