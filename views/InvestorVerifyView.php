<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvestorVerifyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { investor_verify: currentTable } });
var currentForm, currentPageID;
var finvestor_verifyview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvestor_verifyview = new ew.Form("finvestor_verifyview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = finvestor_verifyview;
    loadjs.done("finvestor_verifyview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="finvestor_verifyview" id="finvestor_verifyview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="investor_verify">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->investment->Visible) { // investment ?>
    <tr id="r_investment"<?= $Page->investment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_investment"><?= $Page->investment->caption() ?></span></td>
        <td data-name="investment"<?= $Page->investment->cellAttributes() ?>>
<span id="el_investor_verify_investment">
<span<?= $Page->investment->viewAttributes() ?>>
<?= $Page->investment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->credit_limit->Visible) { // credit_limit ?>
    <tr id="r_credit_limit"<?= $Page->credit_limit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_credit_limit"><?= $Page->credit_limit->caption() ?></span></td>
        <td data-name="credit_limit"<?= $Page->credit_limit->cellAttributes() ?>>
<span id="el_investor_verify_credit_limit">
<span<?= $Page->credit_limit->viewAttributes() ?>>
<?= $Page->credit_limit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_payments->Visible) { // monthly_payments ?>
    <tr id="r_monthly_payments"<?= $Page->monthly_payments->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_monthly_payments"><?= $Page->monthly_payments->caption() ?></span></td>
        <td data-name="monthly_payments"<?= $Page->monthly_payments->cellAttributes() ?>>
<span id="el_investor_verify_monthly_payments">
<span<?= $Page->monthly_payments->viewAttributes() ?>>
<?= $Page->monthly_payments->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->highest_rental_price->Visible) { // highest_rental_price ?>
    <tr id="r_highest_rental_price"<?= $Page->highest_rental_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_highest_rental_price"><?= $Page->highest_rental_price->caption() ?></span></td>
        <td data-name="highest_rental_price"<?= $Page->highest_rental_price->cellAttributes() ?>>
<span id="el_investor_verify_highest_rental_price">
<span<?= $Page->highest_rental_price->viewAttributes() ?>>
<?= $Page->highest_rental_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transfer->Visible) { // transfer ?>
    <tr id="r_transfer"<?= $Page->transfer->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_transfer"><?= $Page->transfer->caption() ?></span></td>
        <td data-name="transfer"<?= $Page->transfer->cellAttributes() ?>>
<span id="el_investor_verify_transfer">
<span<?= $Page->transfer->viewAttributes() ?>>
<?= $Page->transfer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->total_invertor_year->Visible) { // total_invertor_year ?>
    <tr id="r_total_invertor_year"<?= $Page->total_invertor_year->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_total_invertor_year"><?= $Page->total_invertor_year->caption() ?></span></td>
        <td data-name="total_invertor_year"<?= $Page->total_invertor_year->cellAttributes() ?>>
<span id="el_investor_verify_total_invertor_year">
<span<?= $Page->total_invertor_year->viewAttributes() ?>>
<?= $Page->total_invertor_year->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->invert_payoff_day->Visible) { // invert_payoff_day ?>
    <tr id="r_invert_payoff_day"<?= $Page->invert_payoff_day->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_invert_payoff_day"><?= $Page->invert_payoff_day->caption() ?></span></td>
        <td data-name="invert_payoff_day"<?= $Page->invert_payoff_day->cellAttributes() ?>>
<span id="el_investor_verify_invert_payoff_day">
<span<?= $Page->invert_payoff_day->viewAttributes() ?>>
<?= $Page->invert_payoff_day->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type_invertor->Visible) { // type_invertor ?>
    <tr id="r_type_invertor"<?= $Page->type_invertor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_type_invertor"><?= $Page->type_invertor->caption() ?></span></td>
        <td data-name="type_invertor"<?= $Page->type_invertor->cellAttributes() ?>>
<span id="el_investor_verify_type_invertor">
<span<?= $Page->type_invertor->viewAttributes() ?>>
<?= $Page->type_invertor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->invest_amount->Visible) { // invest_amount ?>
    <tr id="r_invest_amount"<?= $Page->invest_amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_invest_amount"><?= $Page->invest_amount->caption() ?></span></td>
        <td data-name="invest_amount"<?= $Page->invest_amount->cellAttributes() ?>>
<span id="el_investor_verify_invest_amount">
<span<?= $Page->invest_amount->viewAttributes() ?>>
<?= $Page->invest_amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_investor_verify_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_investor_verify_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_investor_verify_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <tr id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_udate"><?= $Page->udate->caption() ?></span></td>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el_investor_verify_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <tr id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_uuser"><?= $Page->uuser->caption() ?></span></td>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el_investor_verify_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <tr id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_investor_verify_uip"><?= $Page->uip->caption() ?></span></td>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el_investor_verify_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
