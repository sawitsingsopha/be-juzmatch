<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogSendEmailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_send_email: currentTable } });
var currentForm, currentPageID;
var flog_send_emailview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_send_emailview = new ew.Form("flog_send_emailview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = flog_send_emailview;
    loadjs.done("flog_send_emailview");
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
<form name="flog_send_emailview" id="flog_send_emailview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_send_email">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->log_email_id->Visible) { // log_email_id ?>
    <tr id="r_log_email_id"<?= $Page->log_email_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_log_email_id"><?= $Page->log_email_id->caption() ?></span></td>
        <td data-name="log_email_id"<?= $Page->log_email_id->cellAttributes() ?>>
<span id="el_log_send_email_log_email_id">
<span<?= $Page->log_email_id->viewAttributes() ?>>
<?= $Page->log_email_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cc->Visible) { // cc ?>
    <tr id="r_cc"<?= $Page->cc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_cc"><?= $Page->cc->caption() ?></span></td>
        <td data-name="cc"<?= $Page->cc->cellAttributes() ?>>
<span id="el_log_send_email_cc">
<span<?= $Page->cc->viewAttributes() ?>>
<?= $Page->cc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
    <tr id="r_subject"<?= $Page->subject->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_subject"><?= $Page->subject->caption() ?></span></td>
        <td data-name="subject"<?= $Page->subject->cellAttributes() ?>>
<span id="el_log_send_email_subject">
<span<?= $Page->subject->viewAttributes() ?>>
<?= $Page->subject->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->body->Visible) { // body ?>
    <tr id="r_body"<?= $Page->body->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_body"><?= $Page->body->caption() ?></span></td>
        <td data-name="body"<?= $Page->body->cellAttributes() ?>>
<span id="el_log_send_email_body">
<span<?= $Page->body->viewAttributes() ?>>
<?= $Page->body->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_log_send_email_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_log_send_email_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_log_send_email_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_from->Visible) { // email_from ?>
    <tr id="r_email_from"<?= $Page->email_from->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_email_from"><?= $Page->email_from->caption() ?></span></td>
        <td data-name="email_from"<?= $Page->email_from->cellAttributes() ?>>
<span id="el_log_send_email_email_from">
<span<?= $Page->email_from->viewAttributes() ?>>
<?= $Page->email_from->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_to->Visible) { // email_to ?>
    <tr id="r_email_to"<?= $Page->email_to->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_send_email_email_to"><?= $Page->email_to->caption() ?></span></td>
        <td data-name="email_to"<?= $Page->email_to->cellAttributes() ?>>
<span id="el_log_send_email_email_to">
<span<?= $Page->email_to->viewAttributes() ?>>
<?= $Page->email_to->getViewValue() ?></span>
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
