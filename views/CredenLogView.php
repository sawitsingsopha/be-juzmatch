<?php

namespace PHPMaker2022\juzmatch;

// Page object
$CredenLogView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { creden_log: currentTable } });
var currentForm, currentPageID;
var fcreden_logview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcreden_logview = new ew.Form("fcreden_logview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fcreden_logview;
    loadjs.done("fcreden_logview");
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
<form name="fcreden_logview" id="fcreden_logview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="creden_log">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_creden_log_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_creden_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_creden_log_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_creden_log_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_creden_log_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_creden_log_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_creden_log_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_creden_log_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->__request->Visible) { // request ?>
    <tr id="r___request"<?= $Page->__request->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_creden_log___request"><?= $Page->__request->caption() ?></span></td>
        <td data-name="__request"<?= $Page->__request->cellAttributes() ?>>
<span id="el_creden_log___request">
<span<?= $Page->__request->viewAttributes() ?>>
<?= $Page->__request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_response->Visible) { // response ?>
    <tr id="r__response"<?= $Page->_response->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_creden_log__response"><?= $Page->_response->caption() ?></span></td>
        <td data-name="_response"<?= $Page->_response->cellAttributes() ?>>
<span id="el_creden_log__response">
<span<?= $Page->_response->viewAttributes() ?>>
<?= $Page->_response->getViewValue() ?></span>
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
