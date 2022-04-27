<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MpayReqLogView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mpay_req_log: currentTable } });
var currentForm, currentPageID;
var fmpay_req_logview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmpay_req_logview = new ew.Form("fmpay_req_logview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fmpay_req_logview;
    loadjs.done("fmpay_req_logview");
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
<form name="fmpay_req_logview" id="fmpay_req_logview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mpay_req_log">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mpay_req_log_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_mpay_req_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->req_date->Visible) { // req_date ?>
    <tr id="r_req_date"<?= $Page->req_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mpay_req_log_req_date"><?= $Page->req_date->caption() ?></span></td>
        <td data-name="req_date"<?= $Page->req_date->cellAttributes() ?>>
<span id="el_mpay_req_log_req_date">
<span<?= $Page->req_date->viewAttributes() ?>>
<?= $Page->req_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->req_config->Visible) { // req_config ?>
    <tr id="r_req_config"<?= $Page->req_config->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mpay_req_log_req_config"><?= $Page->req_config->caption() ?></span></td>
        <td data-name="req_config"<?= $Page->req_config->cellAttributes() ?>>
<span id="el_mpay_req_log_req_config">
<span<?= $Page->req_config->viewAttributes() ?>>
<?= $Page->req_config->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->req_response->Visible) { // req_response ?>
    <tr id="r_req_response"<?= $Page->req_response->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mpay_req_log_req_response"><?= $Page->req_response->caption() ?></span></td>
        <td data-name="req_response"<?= $Page->req_response->cellAttributes() ?>>
<span id="el_mpay_req_log_req_response">
<span<?= $Page->req_response->viewAttributes() ?>>
<?= $Page->req_response->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->error_message->Visible) { // error_message ?>
    <tr id="r_error_message"<?= $Page->error_message->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mpay_req_log_error_message"><?= $Page->error_message->caption() ?></span></td>
        <td data-name="error_message"<?= $Page->error_message->cellAttributes() ?>>
<span id="el_mpay_req_log_error_message">
<span<?= $Page->error_message->viewAttributes() ?>>
<?= $Page->error_message->getViewValue() ?></span>
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
