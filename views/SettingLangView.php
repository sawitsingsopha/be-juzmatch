<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SettingLangView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { setting_lang: currentTable } });
var currentForm, currentPageID;
var fsetting_langview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsetting_langview = new ew.Form("fsetting_langview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fsetting_langview;
    loadjs.done("fsetting_langview");
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
<form name="fsetting_langview" id="fsetting_langview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="setting_lang">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->setting_lang_id->Visible) { // setting_lang_id ?>
    <tr id="r_setting_lang_id"<?= $Page->setting_lang_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_setting_lang_id"><?= $Page->setting_lang_id->caption() ?></span></td>
        <td data-name="setting_lang_id"<?= $Page->setting_lang_id->cellAttributes() ?>>
<span id="el_setting_lang_setting_lang_id">
<span<?= $Page->setting_lang_id->viewAttributes() ?>>
<?= $Page->setting_lang_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lang_en->Visible) { // lang_en ?>
    <tr id="r_lang_en"<?= $Page->lang_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_lang_en"><?= $Page->lang_en->caption() ?></span></td>
        <td data-name="lang_en"<?= $Page->lang_en->cellAttributes() ?>>
<span id="el_setting_lang_lang_en">
<span<?= $Page->lang_en->viewAttributes() ?>>
<?= $Page->lang_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lang->Visible) { // lang ?>
    <tr id="r_lang"<?= $Page->lang->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_lang"><?= $Page->lang->caption() ?></span></td>
        <td data-name="lang"<?= $Page->lang->cellAttributes() ?>>
<span id="el_setting_lang_lang">
<span<?= $Page->lang->viewAttributes() ?>>
<?= $Page->lang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_param->Visible) { // param ?>
    <tr id="r__param"<?= $Page->_param->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang__param"><?= $Page->_param->caption() ?></span></td>
        <td data-name="_param"<?= $Page->_param->cellAttributes() ?>>
<span id="el_setting_lang__param">
<span<?= $Page->_param->viewAttributes() ?>>
<?= $Page->_param->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_setting_lang_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
    <tr id="r_udate"<?= $Page->udate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_udate"><?= $Page->udate->caption() ?></span></td>
        <td data-name="udate"<?= $Page->udate->cellAttributes() ?>>
<span id="el_setting_lang_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
    <tr id="r_uip"<?= $Page->uip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_uip"><?= $Page->uip->caption() ?></span></td>
        <td data-name="uip"<?= $Page->uip->cellAttributes() ?>>
<span id="el_setting_lang_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
    <tr id="r_uuser"<?= $Page->uuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_lang_uuser"><?= $Page->uuser->caption() ?></span></td>
        <td data-name="uuser"<?= $Page->uuser->cellAttributes() ?>>
<span id="el_setting_lang_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
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
