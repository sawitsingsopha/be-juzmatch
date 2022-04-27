<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenSignerView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_signer: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_signerview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_signerview = new ew.Form("fdoc_creden_signerview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fdoc_creden_signerview;
    loadjs.done("fdoc_creden_signerview");
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
<form name="fdoc_creden_signerview" id="fdoc_creden_signerview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_signer">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->doc_creden_signer_id->Visible) { // doc_creden_signer_id ?>
    <tr id="r_doc_creden_signer_id"<?= $Page->doc_creden_signer_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_signer_id"><?= $Page->doc_creden_signer_id->caption() ?></span></td>
        <td data-name="doc_creden_signer_id"<?= $Page->doc_creden_signer_id->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_id">
<span<?= $Page->doc_creden_signer_id->viewAttributes() ?>>
<?= $Page->doc_creden_signer_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_creden_id->Visible) { // doc_creden_id ?>
    <tr id="r_doc_creden_id"<?= $Page->doc_creden_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_id"><?= $Page->doc_creden_id->caption() ?></span></td>
        <td data-name="doc_creden_id"<?= $Page->doc_creden_id->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_id">
<span<?= $Page->doc_creden_id->viewAttributes() ?>>
<?= $Page->doc_creden_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_creden_signer_no->Visible) { // doc_creden_signer_no ?>
    <tr id="r_doc_creden_signer_no"<?= $Page->doc_creden_signer_no->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_signer_no"><?= $Page->doc_creden_signer_no->caption() ?></span></td>
        <td data-name="doc_creden_signer_no"<?= $Page->doc_creden_signer_no->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_no">
<span<?= $Page->doc_creden_signer_no->viewAttributes() ?>>
<?= $Page->doc_creden_signer_no->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_creden_signer_link->Visible) { // doc_creden_signer_link ?>
    <tr id="r_doc_creden_signer_link"<?= $Page->doc_creden_signer_link->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_signer_link"><?= $Page->doc_creden_signer_link->caption() ?></span></td>
        <td data-name="doc_creden_signer_link"<?= $Page->doc_creden_signer_link->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_link">
<span<?= $Page->doc_creden_signer_link->viewAttributes() ?>>
<?= $Page->doc_creden_signer_link->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_creden_signer_session->Visible) { // doc_creden_signer_session ?>
    <tr id="r_doc_creden_signer_session"<?= $Page->doc_creden_signer_session->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_signer_session"><?= $Page->doc_creden_signer_session->caption() ?></span></td>
        <td data-name="doc_creden_signer_session"<?= $Page->doc_creden_signer_session->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_session">
<span<?= $Page->doc_creden_signer_session->viewAttributes() ?>>
<?= $Page->doc_creden_signer_session->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_creden_signer_name->Visible) { // doc_creden_signer_name ?>
    <tr id="r_doc_creden_signer_name"<?= $Page->doc_creden_signer_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_signer_name"><?= $Page->doc_creden_signer_name->caption() ?></span></td>
        <td data-name="doc_creden_signer_name"<?= $Page->doc_creden_signer_name->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_name">
<span<?= $Page->doc_creden_signer_name->viewAttributes() ?>>
<?= $Page->doc_creden_signer_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->doc_creden_signer_email->Visible) { // doc_creden_signer_email ?>
    <tr id="r_doc_creden_signer_email"<?= $Page->doc_creden_signer_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_doc_creden_signer_email"><?= $Page->doc_creden_signer_email->caption() ?></span></td>
        <td data-name="doc_creden_signer_email"<?= $Page->doc_creden_signer_email->cellAttributes() ?>>
<span id="el_doc_creden_signer_doc_creden_signer_email">
<span<?= $Page->doc_creden_signer_email->viewAttributes() ?>>
<?= $Page->doc_creden_signer_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_doc_creden_signer_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_creden_signer_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_doc_creden_signer_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_doc_creden_signer_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <tr id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_udate"><?= $Page->udate->caption() ?></span></td>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el_doc_creden_signer_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <tr id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_uuser"><?= $Page->uuser->caption() ?></span></td>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el_doc_creden_signer_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <tr id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_signer_uip"><?= $Page->uip->caption() ?></span></td>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el_doc_creden_signer_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
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
