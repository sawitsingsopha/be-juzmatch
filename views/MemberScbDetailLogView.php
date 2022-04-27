<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberScbDetailLogView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member_scb_detail_log: currentTable } });
var currentForm, currentPageID;
var fmember_scb_detail_logview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmember_scb_detail_logview = new ew.Form("fmember_scb_detail_logview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fmember_scb_detail_logview;
    loadjs.done("fmember_scb_detail_logview");
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
<form name="fmember_scb_detail_logview" id="fmember_scb_detail_logview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member_scb_detail_log">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->member_scb_detail_log_id->Visible) { // member_scb_detail_log_id ?>
    <tr id="r_member_scb_detail_log_id"<?= $Page->member_scb_detail_log_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_member_scb_detail_log_id"><?= $Page->member_scb_detail_log_id->caption() ?></span></td>
        <td data-name="member_scb_detail_log_id"<?= $Page->member_scb_detail_log_id->cellAttributes() ?>>
<span id="el_member_scb_detail_log_member_scb_detail_log_id">
<span<?= $Page->member_scb_detail_log_id->viewAttributes() ?>>
<?= $Page->member_scb_detail_log_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_scb_id->Visible) { // member_scb_id ?>
    <tr id="r_member_scb_id"<?= $Page->member_scb_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_member_scb_id"><?= $Page->member_scb_id->caption() ?></span></td>
        <td data-name="member_scb_id"<?= $Page->member_scb_id->cellAttributes() ?>>
<span id="el_member_scb_detail_log_member_scb_id">
<span<?= $Page->member_scb_id->viewAttributes() ?>>
<?= $Page->member_scb_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paid_amt->Visible) { // paid_amt ?>
    <tr id="r_paid_amt"<?= $Page->paid_amt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_paid_amt"><?= $Page->paid_amt->caption() ?></span></td>
        <td data-name="paid_amt"<?= $Page->paid_amt->cellAttributes() ?>>
<span id="el_member_scb_detail_log_paid_amt">
<span<?= $Page->paid_amt->viewAttributes() ?>>
<?= $Page->paid_amt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pay_date->Visible) { // pay_date ?>
    <tr id="r_pay_date"<?= $Page->pay_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_pay_date"><?= $Page->pay_date->caption() ?></span></td>
        <td data-name="pay_date"<?= $Page->pay_date->cellAttributes() ?>>
<span id="el_member_scb_detail_log_pay_date">
<span<?= $Page->pay_date->viewAttributes() ?>>
<?= $Page->pay_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_member_scb_detail_log_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_member_scb_detail_log_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_scb_detail_log_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_member_scb_detail_log_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
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
