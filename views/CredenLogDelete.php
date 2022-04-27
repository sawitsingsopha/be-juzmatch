<?php

namespace PHPMaker2022\juzmatch;

// Page object
$CredenLogDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { creden_log: currentTable } });
var currentForm, currentPageID;
var fcreden_logdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcreden_logdelete = new ew.Form("fcreden_logdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fcreden_logdelete;
    loadjs.done("fcreden_logdelete");
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
<form name="fcreden_logdelete" id="fcreden_logdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="creden_log">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_creden_log_id" class="creden_log_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_creden_log_cdate" class="creden_log_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_creden_log_cuser" class="creden_log_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_creden_log_cip" class="creden_log_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->__request->Visible) { // request ?>
        <th class="<?= $Page->__request->headerCellClass() ?>"><span id="elh_creden_log___request" class="creden_log___request"><?= $Page->__request->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_response->Visible) { // response ?>
        <th class="<?= $Page->_response->headerCellClass() ?>"><span id="elh_creden_log__response" class="creden_log__response"><?= $Page->_response->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_creden_log_id" class="el_creden_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_creden_log_cdate" class="el_creden_log_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_creden_log_cuser" class="el_creden_log_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_creden_log_cip" class="el_creden_log_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->__request->Visible) { // request ?>
        <td<?= $Page->__request->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_creden_log___request" class="el_creden_log___request">
<span<?= $Page->__request->viewAttributes() ?>>
<?= $Page->__request->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_response->Visible) { // response ?>
        <td<?= $Page->_response->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_creden_log__response" class="el_creden_log__response">
<span<?= $Page->_response->viewAttributes() ?>>
<?= $Page->_response->getViewValue() ?></span>
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
