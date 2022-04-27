<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogNotificationView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_notification: currentTable } });
var currentForm, currentPageID;
var flog_notificationview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_notificationview = new ew.Form("flog_notificationview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = flog_notificationview;
    loadjs.done("flog_notificationview");
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
<form name="flog_notificationview" id="flog_notificationview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_notification">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->log_notification_id->Visible) { // log_notification_id ?>
    <tr id="r_log_notification_id"<?= $Page->log_notification_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_log_notification_id"><?= $Page->log_notification_id->caption() ?></span></td>
        <td data-name="log_notification_id"<?= $Page->log_notification_id->cellAttributes() ?>>
<span id="el_log_notification_log_notification_id">
<span<?= $Page->log_notification_id->viewAttributes() ?>>
<?= $Page->log_notification_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_log_notification_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <tr id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification__title"><?= $Page->_title->caption() ?></span></td>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el_log_notification__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <tr id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_title_en"><?= $Page->title_en->caption() ?></span></td>
        <td data-name="title_en"<?= $Page->title_en->cellAttributes() ?>>
<span id="el_log_notification_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <tr id="r_detail"<?= $Page->detail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_detail"><?= $Page->detail->caption() ?></span></td>
        <td data-name="detail"<?= $Page->detail->cellAttributes() ?>>
<span id="el_log_notification_detail">
<span<?= $Page->detail->viewAttributes() ?>>
<?= $Page->detail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detail_en->Visible) { // detail_en ?>
    <tr id="r_detail_en"<?= $Page->detail_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_detail_en"><?= $Page->detail_en->caption() ?></span></td>
        <td data-name="detail_en"<?= $Page->detail_en->cellAttributes() ?>>
<span id="el_log_notification_detail_en">
<span<?= $Page->detail_en->viewAttributes() ?>>
<?= $Page->detail_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_log_notification_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_log_notification_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_notification_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_log_notification_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
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
