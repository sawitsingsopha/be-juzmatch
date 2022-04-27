<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MasterBuyerCalculatorDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { master_buyer_calculator: currentTable } });
var currentForm, currentPageID;
var fmaster_buyer_calculatordelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmaster_buyer_calculatordelete = new ew.Form("fmaster_buyer_calculatordelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fmaster_buyer_calculatordelete;
    loadjs.done("fmaster_buyer_calculatordelete");
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
<form name="fmaster_buyer_calculatordelete" id="fmaster_buyer_calculatordelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="master_buyer_calculator">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->buyer_monthly_payment->Visible) { // buyer_monthly_payment ?>
        <th class="<?= $Page->buyer_monthly_payment->headerCellClass() ?>"><span id="elh_master_buyer_calculator_buyer_monthly_payment" class="master_buyer_calculator_buyer_monthly_payment"><?= $Page->buyer_monthly_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_monthly_annual_interest->Visible) { // buyer_monthly_annual_interest ?>
        <th class="<?= $Page->buyer_monthly_annual_interest->headerCellClass() ?>"><span id="elh_master_buyer_calculator_buyer_monthly_annual_interest" class="master_buyer_calculator_buyer_monthly_annual_interest"><?= $Page->buyer_monthly_annual_interest->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_dsr_ratio->Visible) { // buyer_dsr_ratio ?>
        <th class="<?= $Page->buyer_dsr_ratio->headerCellClass() ?>"><span id="elh_master_buyer_calculator_buyer_dsr_ratio" class="master_buyer_calculator_buyer_dsr_ratio"><?= $Page->buyer_dsr_ratio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buyer_down_payment->Visible) { // buyer_down_payment ?>
        <th class="<?= $Page->buyer_down_payment->headerCellClass() ?>"><span id="elh_master_buyer_calculator_buyer_down_payment" class="master_buyer_calculator_buyer_down_payment"><?= $Page->buyer_down_payment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_master_buyer_calculator_cdate" class="master_buyer_calculator_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->buyer_monthly_payment->Visible) { // buyer_monthly_payment ?>
        <td<?= $Page->buyer_monthly_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_monthly_payment" class="el_master_buyer_calculator_buyer_monthly_payment">
<span<?= $Page->buyer_monthly_payment->viewAttributes() ?>>
<?= $Page->buyer_monthly_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_monthly_annual_interest->Visible) { // buyer_monthly_annual_interest ?>
        <td<?= $Page->buyer_monthly_annual_interest->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_monthly_annual_interest" class="el_master_buyer_calculator_buyer_monthly_annual_interest">
<span<?= $Page->buyer_monthly_annual_interest->viewAttributes() ?>>
<?= $Page->buyer_monthly_annual_interest->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_dsr_ratio->Visible) { // buyer_dsr_ratio ?>
        <td<?= $Page->buyer_dsr_ratio->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_dsr_ratio" class="el_master_buyer_calculator_buyer_dsr_ratio">
<span<?= $Page->buyer_dsr_ratio->viewAttributes() ?>>
<?= $Page->buyer_dsr_ratio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buyer_down_payment->Visible) { // buyer_down_payment ?>
        <td<?= $Page->buyer_down_payment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_buyer_down_payment" class="el_master_buyer_calculator_buyer_down_payment">
<span<?= $Page->buyer_down_payment->viewAttributes() ?>>
<?= $Page->buyer_down_payment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_master_buyer_calculator_cdate" class="el_master_buyer_calculator_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
