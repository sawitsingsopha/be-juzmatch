<?php

namespace PHPMaker2022\juzmatch;

// Page object
$LogSendEmailDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_send_email: currentTable } });
var currentForm, currentPageID;
var flog_send_emaildelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_send_emaildelete = new ew.Form("flog_send_emaildelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = flog_send_emaildelete;
    loadjs.done("flog_send_emaildelete");
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
<form name="flog_send_emaildelete" id="flog_send_emaildelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_send_email">
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
<?php if ($Page->log_email_id->Visible) { // log_email_id ?>
        <th class="<?= $Page->log_email_id->headerCellClass() ?>"><span id="elh_log_send_email_log_email_id" class="log_send_email_log_email_id"><?= $Page->log_email_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cc->Visible) { // cc ?>
        <th class="<?= $Page->cc->headerCellClass() ?>"><span id="elh_log_send_email_cc" class="log_send_email_cc"><?= $Page->cc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
        <th class="<?= $Page->subject->headerCellClass() ?>"><span id="elh_log_send_email_subject" class="log_send_email_subject"><?= $Page->subject->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_log_send_email_cdate" class="log_send_email_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_log_send_email_cuser" class="log_send_email_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_log_send_email_cip" class="log_send_email_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->email_from->Visible) { // email_from ?>
        <th class="<?= $Page->email_from->headerCellClass() ?>"><span id="elh_log_send_email_email_from" class="log_send_email_email_from"><?= $Page->email_from->caption() ?></span></th>
<?php } ?>
<?php if ($Page->email_to->Visible) { // email_to ?>
        <th class="<?= $Page->email_to->headerCellClass() ?>"><span id="elh_log_send_email_email_to" class="log_send_email_email_to"><?= $Page->email_to->caption() ?></span></th>
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
<?php if ($Page->log_email_id->Visible) { // log_email_id ?>
        <td<?= $Page->log_email_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_log_email_id" class="el_log_send_email_log_email_id">
<span<?= $Page->log_email_id->viewAttributes() ?>>
<?= $Page->log_email_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cc->Visible) { // cc ?>
        <td<?= $Page->cc->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_cc" class="el_log_send_email_cc">
<span<?= $Page->cc->viewAttributes() ?>>
<?= $Page->cc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
        <td<?= $Page->subject->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_subject" class="el_log_send_email_subject">
<span<?= $Page->subject->viewAttributes() ?>>
<?= $Page->subject->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_cdate" class="el_log_send_email_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_cuser" class="el_log_send_email_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_cip" class="el_log_send_email_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->email_from->Visible) { // email_from ?>
        <td<?= $Page->email_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_email_from" class="el_log_send_email_email_from">
<span<?= $Page->email_from->viewAttributes() ?>>
<?= $Page->email_from->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->email_to->Visible) { // email_to ?>
        <td<?= $Page->email_to->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_send_email_email_to" class="el_log_send_email_email_to">
<span<?= $Page->email_to->viewAttributes() ?>>
<?= $Page->email_to->getViewValue() ?></span>
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
