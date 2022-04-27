<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ReasonTerminateContractView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { reason_terminate_contract: currentTable } });
var currentForm, currentPageID;
var freason_terminate_contractview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    freason_terminate_contractview = new ew.Form("freason_terminate_contractview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = freason_terminate_contractview;
    loadjs.done("freason_terminate_contractview");
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
<form name="freason_terminate_contractview" id="freason_terminate_contractview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="reason_terminate_contract">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->reason_id->Visible) { // reason_id ?>
    <tr id="r_reason_id"<?= $Page->reason_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reason_terminate_contract_reason_id"><?= $Page->reason_id->caption() ?></span></td>
        <td data-name="reason_id"<?= $Page->reason_id->cellAttributes() ?>>
<span id="el_reason_terminate_contract_reason_id">
<span<?= $Page->reason_id->viewAttributes() ?>>
<?= $Page->reason_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reason_text->Visible) { // reason_text ?>
    <tr id="r_reason_text"<?= $Page->reason_text->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_reason_terminate_contract_reason_text"><?= $Page->reason_text->caption() ?></span></td>
        <td data-name="reason_text"<?= $Page->reason_text->cellAttributes() ?>>
<span id="el_reason_terminate_contract_reason_text">
<span<?= $Page->reason_text->viewAttributes() ?>>
<?= $Page->reason_text->getViewValue() ?></span>
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
