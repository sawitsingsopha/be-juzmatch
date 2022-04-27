<?php

namespace PHPMaker2022\juzmatch;

// Page object
$Log2c2pDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_2c2p: currentTable } });
var currentForm, currentPageID;
var flog_2c2pdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_2c2pdelete = new ew.Form("flog_2c2pdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = flog_2c2pdelete;
    loadjs.done("flog_2c2pdelete");
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
<form name="flog_2c2pdelete" id="flog_2c2pdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_2c2p">
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
<?php if ($Page->log_2c2p_id->Visible) { // log_2c2p_id ?>
        <th class="<?= $Page->log_2c2p_id->headerCellClass() ?>"><span id="elh_log_2c2p_log_2c2p_id" class="log_2c2p_log_2c2p_id"><?= $Page->log_2c2p_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_log_2c2p_type" class="log_2c2p_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_log_2c2p_date" class="log_2c2p_date"><?= $Page->date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
        <th class="<?= $Page->ip->headerCellClass() ?>"><span id="elh_log_2c2p_ip" class="log_2c2p_ip"><?= $Page->ip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th class="<?= $Page->member_id->headerCellClass() ?>"><span id="elh_log_2c2p_member_id" class="log_2c2p_member_id"><?= $Page->member_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
        <th class="<?= $Page->refid->headerCellClass() ?>"><span id="elh_log_2c2p_refid" class="log_2c2p_refid"><?= $Page->refid->caption() ?></span></th>
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
<?php if ($Page->log_2c2p_id->Visible) { // log_2c2p_id ?>
        <td<?= $Page->log_2c2p_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_2c2p_log_2c2p_id" class="el_log_2c2p_log_2c2p_id">
<span<?= $Page->log_2c2p_id->viewAttributes() ?>>
<?= $Page->log_2c2p_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_2c2p_type" class="el_log_2c2p_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_2c2p_date" class="el_log_2c2p_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
        <td<?= $Page->ip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_2c2p_ip" class="el_log_2c2p_ip">
<span<?= $Page->ip->viewAttributes() ?>>
<?= $Page->ip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <td<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_2c2p_member_id" class="el_log_2c2p_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->refid->Visible) { // refid ?>
        <td<?= $Page->refid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_2c2p_refid" class="el_log_2c2p_refid">
<span<?= $Page->refid->viewAttributes() ?>>
<?= $Page->refid->getViewValue() ?></span>
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
