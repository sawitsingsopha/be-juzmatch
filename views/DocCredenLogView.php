<?php

namespace PHPMaker2022\juzmatch;

// Page object
$DocCredenLogView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { doc_creden_log: currentTable } });
var currentForm, currentPageID;
var fdoc_creden_logview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fdoc_creden_logview = new ew.Form("fdoc_creden_logview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fdoc_creden_logview;
    loadjs.done("fdoc_creden_logview");
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
<form name="fdoc_creden_logview" id="fdoc_creden_logview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="doc_creden_log">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_doc_creden_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->__request->Visible) { // request ?>
    <tr id="r___request"<?= $Page->__request->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log___request"><?= $Page->__request->caption() ?></span></td>
        <td data-name="__request"<?= $Page->__request->cellAttributes() ?>>
<span id="el_doc_creden_log___request">
<span<?= $Page->__request->viewAttributes() ?>>
<?= $Page->__request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_response->Visible) { // response ?>
    <tr id="r__response"<?= $Page->_response->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log__response"><?= $Page->_response->caption() ?></span></td>
        <td data-name="_response"<?= $Page->_response->cellAttributes() ?>>
<span id="el_doc_creden_log__response">
<span<?= $Page->_response->viewAttributes() ?>>
<?= $Page->_response->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_doc_creden_log_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->url->Visible) { // url ?>
    <tr id="r_url"<?= $Page->url->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log_url"><?= $Page->url->caption() ?></span></td>
        <td data-name="url"<?= $Page->url->cellAttributes() ?>>
<span id="el_doc_creden_log_url">
<span<?= $Page->url->viewAttributes() ?>>
<?= $Page->url->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pdfbase64->Visible) { // pdfbase64 ?>
    <tr id="r_pdfbase64"<?= $Page->pdfbase64->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log_pdfbase64"><?= $Page->pdfbase64->caption() ?></span></td>
        <td data-name="pdfbase64"<?= $Page->pdfbase64->cellAttributes() ?>>
<span id="el_doc_creden_log_pdfbase64">
<span<?= $Page->pdfbase64->viewAttributes() ?>>
<?= $Page->pdfbase64->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_header->Visible) { // request_header ?>
    <tr id="r_request_header"<?= $Page->request_header->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_doc_creden_log_request_header"><?= $Page->request_header->caption() ?></span></td>
        <td data-name="request_header"<?= $Page->request_header->cellAttributes() ?>>
<span id="el_doc_creden_log_request_header">
<span<?= $Page->request_header->viewAttributes() ?>>
<?= $Page->request_header->getViewValue() ?></span>
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
