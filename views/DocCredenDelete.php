<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden: currentTable } });
var currentForm, currentPageID;
var fdoc_credendelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_credendelete = new ew.Form("fdoc_credendelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fdoc_credendelete;
    loadjs.done("fdoc_credendelete");
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
<form name="fdoc_credendelete" id="fdoc_credendelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden">
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
<?php if ($Page->document_id->Visible) { // document_id ?>
        <th class="<?= $Page->document_id->headerCellClass() ?>"><span id="elh_doc_creden_document_id" class="doc_creden_document_id"><?= $Page->document_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <th class="<?= $Page->doc_creden_id->headerCellClass() ?>"><span id="elh_doc_creden_doc_creden_id" class="doc_creden_doc_creden_id"><?= $Page->doc_creden_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_temp_id->Visible) { // doc_temp_id ?>
        <th class="<?= $Page->doc_temp_id->headerCellClass() ?>"><span id="elh_doc_creden_doc_temp_id" class="doc_creden_doc_temp_id"><?= $Page->doc_temp_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->txid->Visible) { // txid ?>
        <th class="<?= $Page->txid->headerCellClass() ?>"><span id="elh_doc_creden_txid" class="doc_creden_txid"><?= $Page->txid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
        <th class="<?= $Page->subject->headerCellClass() ?>"><span id="elh_doc_creden_subject" class="doc_creden_subject"><?= $Page->subject->caption() ?></span></th>
<?php } ?>
<?php if ($Page->send_email->Visible) { // send_email ?>
        <th class="<?= $Page->send_email->headerCellClass() ?>"><span id="elh_doc_creden_send_email" class="doc_creden_send_email"><?= $Page->send_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->redirect_url->Visible) { // redirect_url ?>
        <th class="<?= $Page->redirect_url->headerCellClass() ?>"><span id="elh_doc_creden_redirect_url" class="doc_creden_redirect_url"><?= $Page->redirect_url->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_doc_creden_status" class="doc_creden_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_doc_creden_cdate" class="doc_creden_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <th class="<?= $Page->cuser->headerCellClass() ?>"><span id="elh_doc_creden_cuser" class="doc_creden_cuser"><?= $Page->cuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_doc_creden_cip" class="doc_creden_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_doc_creden_udate" class="doc_creden_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_doc_creden_uuser" class="doc_creden_uuser"><?= $Page->uuser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_doc_creden_uip" class="doc_creden_uip"><?= $Page->uip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->doc_url->Visible) { // doc_url ?>
        <th class="<?= $Page->doc_url->headerCellClass() ?>"><span id="elh_doc_creden_doc_url" class="doc_creden_doc_url"><?= $Page->doc_url->caption() ?></span></th>
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
<?php if ($Page->document_id->Visible) { // document_id ?>
        <td<?= $Page->document_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_document_id" class="el_doc_creden_document_id">
<span<?= $Page->document_id->viewAttributes() ?>>
<?= $Page->document_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
        <td<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_doc_creden_id" class="el_doc_creden_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_temp_id->Visible) { // doc_temp_id ?>
        <td<?= $Page->doc_temp_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_doc_temp_id" class="el_doc_creden_doc_temp_id">
<span<?= $Page->doc_temp_id->viewAttributes() ?>>
<?= $Page->doc_temp_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->txid->Visible) { // txid ?>
        <td<?= $Page->txid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_txid" class="el_doc_creden_txid">
<span<?= $Page->txid->viewAttributes() ?>>
<?= $Page->txid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subject->Visible) { // subject ?>
        <td<?= $Page->subject->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_subject" class="el_doc_creden_subject">
<span<?= $Page->subject->viewAttributes() ?>>
<?= $Page->subject->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->send_email->Visible) { // send_email ?>
        <td<?= $Page->send_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_send_email" class="el_doc_creden_send_email">
<span<?= $Page->send_email->viewAttributes() ?>>
<?= $Page->send_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->redirect_url->Visible) { // redirect_url ?>
        <td<?= $Page->redirect_url->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_redirect_url" class="el_doc_creden_redirect_url">
<span<?= $Page->redirect_url->viewAttributes() ?>>
<?= $Page->redirect_url->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_status" class="el_doc_creden_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_cdate" class="el_doc_creden_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
        <td<?= $Page->cuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_cuser" class="el_doc_creden_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_cip" class="el_doc_creden_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_udate" class="el_doc_creden_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_uuser" class="el_doc_creden_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_uip" class="el_doc_creden_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->doc_url->Visible) { // doc_url ?>
        <td<?= $Page->doc_url->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_doc_creden_doc_url" class="el_doc_creden_doc_url">
<span<?= $Page->doc_url->viewAttributes() ?>>
<?= $Page->doc_url->getViewValue() ?></span>
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
