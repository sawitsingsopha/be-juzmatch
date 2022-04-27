<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenSignerDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_signer: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_signerdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_signerdelete = new ew.Form("fdoc_creden_signerdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_creden_signerdelete;
    loadjs.done("fdoc_creden_signerdelete");
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
<form name="fdoc_creden_signerdelete" id="fdoc_creden_signerdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_signer">
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
<?php if ($Page->doc_creden_signer_id->Visible) { // doc_creden_signer_id ?>
        <th class="<?= $Page->doc_creden_signer_id->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_signer_id" class="doc_creden_signer_doc_creden_signer_id"><?= $Page->doc_creden_signer_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <th class="<?= $Page->doc_creden_id->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_id" class="doc_creden_signer_doc_creden_id"><?= $Page->doc_creden_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_no->Visible) { // doc_creden_signer_no ?>
        <th class="<?= $Page->doc_creden_signer_no->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_signer_no" class="doc_creden_signer_doc_creden_signer_no"><?= $Page->doc_creden_signer_no->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_link->Visible) { // doc_creden_signer_link ?>
        <th class="<?= $Page->doc_creden_signer_link->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_signer_link" class="doc_creden_signer_doc_creden_signer_link"><?= $Page->doc_creden_signer_link->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_session->Visible) { // doc_creden_signer_session ?>
        <th class="<?= $Page->doc_creden_signer_session->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_signer_session" class="doc_creden_signer_doc_creden_signer_session"><?= $Page->doc_creden_signer_session->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_name->Visible) { // doc_creden_signer_name ?>
        <th class="<?= $Page->doc_creden_signer_name->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_signer_name" class="doc_creden_signer_doc_creden_signer_name"><?= $Page->doc_creden_signer_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_signer_email->Visible) { // doc_creden_signer_email ?>
        <th class="<?= $Page->doc_creden_signer_email->headerCellClass() ?>"><span id="elh_doc_creden_signer_doc_creden_signer_email" class="doc_creden_signer_doc_creden_signer_email"><?= $Page->doc_creden_signer_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_doc_creden_signer_status" class="doc_creden_signer_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_doc_creden_signer_cdate" class="doc_creden_signer_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_doc_creden_signer_cuser" class="doc_creden_signer_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_doc_creden_signer_cip" class="doc_creden_signer_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_doc_creden_signer_udate" class="doc_creden_signer_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_doc_creden_signer_uuser" class="doc_creden_signer_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_doc_creden_signer_uip" class="doc_creden_signer_uip"><?= $Page->uip->caption() ?></span></th>
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
<?php if ($Page->doc_creden_signer_id->Visible) { // doc_creden_signer_id ?>
        <td<?= $Page->doc_creden_signer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_id" class="el_doc_creden_signer_doc_creden_signer_id">
<span<?= $Page->doc_creden_signer_id->viewAttributes() ?>>
<?= $Page->doc_creden_signer_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <td<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_id" class="el_doc_creden_signer_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_signer_no->Visible) { // doc_creden_signer_no ?>
        <td<?= $Page->doc_creden_signer_no->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_no" class="el_doc_creden_signer_doc_creden_signer_no">
<span<?= $Page->doc_creden_signer_no->viewAttributes() ?>>
<?= $Page->doc_creden_signer_no->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_signer_link->Visible) { // doc_creden_signer_link ?>
        <td<?= $Page->doc_creden_signer_link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_link" class="el_doc_creden_signer_doc_creden_signer_link">
<span<?= $Page->doc_creden_signer_link->viewAttributes() ?>>
<?= $Page->doc_creden_signer_link->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_signer_session->Visible) { // doc_creden_signer_session ?>
        <td<?= $Page->doc_creden_signer_session->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_session" class="el_doc_creden_signer_doc_creden_signer_session">
<span<?= $Page->doc_creden_signer_session->viewAttributes() ?>>
<?= $Page->doc_creden_signer_session->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_signer_name->Visible) { // doc_creden_signer_name ?>
        <td<?= $Page->doc_creden_signer_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_name" class="el_doc_creden_signer_doc_creden_signer_name">
<span<?= $Page->doc_creden_signer_name->viewAttributes() ?>>
<?= $Page->doc_creden_signer_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_signer_email->Visible) { // doc_creden_signer_email ?>
        <td<?= $Page->doc_creden_signer_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_doc_creden_signer_email" class="el_doc_creden_signer_doc_creden_signer_email">
<span<?= $Page->doc_creden_signer_email->viewAttributes() ?>>
<?= $Page->doc_creden_signer_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_status" class="el_doc_creden_signer_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_cdate" class="el_doc_creden_signer_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_cuser" class="el_doc_creden_signer_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_cip" class="el_doc_creden_signer_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_udate" class="el_doc_creden_signer_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_uuser" class="el_doc_creden_signer_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_signer_uip" class="el_doc_creden_signer_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
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
