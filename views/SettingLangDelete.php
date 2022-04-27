<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SettingLangDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { setting_lang: currentTable } });
var currentForm, currentPageID;
var fsetting_langdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsetting_langdelete = new ew.Form("fsetting_langdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fsetting_langdelete;
    loadjs.done("fsetting_langdelete");
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
<form name="fsetting_langdelete" id="fsetting_langdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="setting_lang">
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
<?php if ($Page->setting_lang_id->Visible) { // setting_lang_id ?>
        <th class="<?= $Page->setting_lang_id->headerCellClass() ?>"><span id="elh_setting_lang_setting_lang_id" class="setting_lang_setting_lang_id"><?= $Page->setting_lang_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lang_en->Visible) { // lang_en ?>
        <th class="<?= $Page->lang_en->headerCellClass() ?>"><span id="elh_setting_lang_lang_en" class="setting_lang_lang_en"><?= $Page->lang_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lang->Visible) { // lang ?>
        <th class="<?= $Page->lang->headerCellClass() ?>"><span id="elh_setting_lang_lang" class="setting_lang_lang"><?= $Page->lang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_param->Visible) { // param ?>
        <th class="<?= $Page->_param->headerCellClass() ?>"><span id="elh_setting_lang__param" class="setting_lang__param"><?= $Page->_param->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <th class="<?= $Page->cip->headerCellClass() ?>"><span id="elh_setting_lang_cip" class="setting_lang_cip"><?= $Page->cip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <th class="<?= $Page->udate->headerCellClass() ?>"><span id="elh_setting_lang_udate" class="setting_lang_udate"><?= $Page->udate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <th class="<?= $Page->uip->headerCellClass() ?>"><span id="elh_setting_lang_uip" class="setting_lang_uip"><?= $Page->uip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <th class="<?= $Page->uuser->headerCellClass() ?>"><span id="elh_setting_lang_uuser" class="setting_lang_uuser"><?= $Page->uuser->caption() ?></span></th>
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
<?php if ($Page->setting_lang_id->Visible) { // setting_lang_id ?>
        <td<?= $Page->setting_lang_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_setting_lang_id" class="el_setting_lang_setting_lang_id">
<span<?= $Page->setting_lang_id->viewAttributes() ?>>
<?= $Page->setting_lang_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lang_en->Visible) { // lang_en ?>
        <td<?= $Page->lang_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_lang_en" class="el_setting_lang_lang_en">
<span<?= $Page->lang_en->viewAttributes() ?>>
<?= $Page->lang_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lang->Visible) { // lang ?>
        <td<?= $Page->lang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_lang" class="el_setting_lang_lang">
<span<?= $Page->lang->viewAttributes() ?>>
<?= $Page->lang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_param->Visible) { // param ?>
        <td<?= $Page->_param->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang__param" class="el_setting_lang__param">
<span<?= $Page->_param->viewAttributes() ?>>
<?= $Page->_param->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
        <td<?= $Page->cip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_cip" class="el_setting_lang_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->udate->Visible) { // udate ?>
        <td<?= $Page->udate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_udate" class="el_setting_lang_udate">
<span<?= $Page->udate->viewAttributes() ?>>
<?= $Page->udate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uip->Visible) { // uip ?>
        <td<?= $Page->uip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_uip" class="el_setting_lang_uip">
<span<?= $Page->uip->viewAttributes() ?>>
<?= $Page->uip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuser->Visible) { // uuser ?>
        <td<?= $Page->uuser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_setting_lang_uuser" class="el_setting_lang_uuser">
<span<?= $Page->uuser->viewAttributes() ?>>
<?= $Page->uuser->getViewValue() ?></span>
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
