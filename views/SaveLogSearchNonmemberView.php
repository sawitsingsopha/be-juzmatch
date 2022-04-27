<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveLogSearchNonmemberView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { save_log_search_nonmember: currentTable } });
var currentForm, currentPageID;
var fsave_log_search_nonmemberview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_log_search_nonmemberview = new ew.Form("fsave_log_search_nonmemberview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fsave_log_search_nonmemberview;
    loadjs.done("fsave_log_search_nonmemberview");
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
<form name="fsave_log_search_nonmemberview" id="fsave_log_search_nonmemberview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="save_log_search_nonmember">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->save_log_search_nonmember_id->Visible) { // save_log_search_nonmember_id ?>
    <tr id="r_save_log_search_nonmember_id"<?= $Page->save_log_search_nonmember_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_save_log_search_nonmember_id"><?= $Page->save_log_search_nonmember_id->caption() ?></span></td>
        <td data-name="save_log_search_nonmember_id"<?= $Page->save_log_search_nonmember_id->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_save_log_search_nonmember_id">
<span<?= $Page->save_log_search_nonmember_id->viewAttributes() ?>>
<?= $Page->save_log_search_nonmember_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
    <tr id="r_category_id"<?= $Page->category_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_category_id"><?= $Page->category_id->caption() ?></span></td>
        <td data-name="category_id"<?= $Page->category_id->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<?= $Page->category_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->min_installment->Visible) { // min_installment ?>
    <tr id="r_min_installment"<?= $Page->min_installment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_min_installment"><?= $Page->min_installment->caption() ?></span></td>
        <td data-name="min_installment"<?= $Page->min_installment->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_min_installment">
<span<?= $Page->min_installment->viewAttributes() ?>>
<?= $Page->min_installment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
    <tr id="r_max_installment"<?= $Page->max_installment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_max_installment"><?= $Page->max_installment->caption() ?></span></td>
        <td data-name="max_installment"<?= $Page->max_installment->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_max_installment">
<span<?= $Page->max_installment->viewAttributes() ?>>
<?= $Page->max_installment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->attribute_detail_id->Visible) { // attribute_detail_id ?>
    <tr id="r_attribute_detail_id"<?= $Page->attribute_detail_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_attribute_detail_id"><?= $Page->attribute_detail_id->caption() ?></span></td>
        <td data-name="attribute_detail_id"<?= $Page->attribute_detail_id->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_attribute_detail_id">
<span<?= $Page->attribute_detail_id->viewAttributes() ?>>
<?= $Page->attribute_detail_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <tr id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_latitude"><?= $Page->latitude->caption() ?></span></td>
        <td data-name="latitude"<?= $Page->latitude->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_latitude">
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <tr id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_longitude"><?= $Page->longitude->caption() ?></span></td>
        <td data-name="longitude"<?= $Page->longitude->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_longitude">
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_save_log_search_nonmember__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <tr id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_phone"><?= $Page->phone->caption() ?></span></td>
        <td data-name="phone"<?= $Page->phone->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cip->Visible) { // cip ?>
    <tr id="r_cip"<?= $Page->cip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_cip"><?= $Page->cip->caption() ?></span></td>
        <td data-name="cip"<?= $Page->cip->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_cip">
<span<?= $Page->cip->viewAttributes() ?>>
<?= $Page->cip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuser->Visible) { // cuser ?>
    <tr id="r_cuser"<?= $Page->cuser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_cuser"><?= $Page->cuser->caption() ?></span></td>
        <td data-name="cuser"<?= $Page->cuser->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_cuser">
<span<?= $Page->cuser->viewAttributes() ?>>
<?= $Page->cuser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
    <tr id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_first_name"><?= $Page->first_name->caption() ?></span></td>
        <td data-name="first_name"<?= $Page->first_name->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_first_name">
<span<?= $Page->first_name->viewAttributes() ?>>
<?= $Page->first_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <tr id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_save_log_search_nonmember_last_name"><?= $Page->last_name->caption() ?></span></td>
        <td data-name="last_name"<?= $Page->last_name->cellAttributes() ?>>
<span id="el_save_log_search_nonmember_last_name">
<span<?= $Page->last_name->viewAttributes() ?>>
<?= $Page->last_name->getViewValue() ?></span>
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
