<?php

namespace PHPMaker2022\juzmatch;

// Page object
$MemberView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { member: currentTable } });
var currentForm, currentPageID;
var fmemberview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmemberview = new ew.Form("fmemberview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fmemberview;
    loadjs.done("fmemberview");
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
<form name="fmemberview" id="fmemberview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="member">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->first_name->Visible) { // first_name ?>
    <tr id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_first_name"><?= $Page->first_name->caption() ?></span></td>
        <td data-name="first_name"<?= $Page->first_name->cellAttributes() ?>>
<span id="el_member_first_name">
<span<?= $Page->first_name->viewAttributes() ?>>
<?= $Page->first_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <tr id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_last_name"><?= $Page->last_name->caption() ?></span></td>
        <td data-name="last_name"<?= $Page->last_name->cellAttributes() ?>>
<span id="el_member_last_name">
<span<?= $Page->last_name->viewAttributes() ?>>
<?= $Page->last_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcardnumber->Visible) { // idcardnumber ?>
    <tr id="r_idcardnumber"<?= $Page->idcardnumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_idcardnumber"><?= $Page->idcardnumber->caption() ?></span></td>
        <td data-name="idcardnumber"<?= $Page->idcardnumber->cellAttributes() ?>>
<span id="el_member_idcardnumber">
<span<?= $Page->idcardnumber->viewAttributes() ?>>
<?= $Page->idcardnumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_member__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <tr id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_phone"><?= $Page->phone->caption() ?></span></td>
        <td data-name="phone"<?= $Page->phone->cellAttributes() ?>>
<span id="el_member_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type"<?= $Page->type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<span id="el_member_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <tr id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_isactive"><?= $Page->isactive->caption() ?></span></td>
        <td data-name="isactive"<?= $Page->isactive->cellAttributes() ?>>
<span id="el_member_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isbuyer->Visible) { // isbuyer ?>
    <tr id="r_isbuyer"<?= $Page->isbuyer->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_isbuyer"><?= $Page->isbuyer->caption() ?></span></td>
        <td data-name="isbuyer"<?= $Page->isbuyer->cellAttributes() ?>>
<span id="el_member_isbuyer">
<span<?= $Page->isbuyer->viewAttributes() ?>>
<?= $Page->isbuyer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isinvertor->Visible) { // isinvertor ?>
    <tr id="r_isinvertor"<?= $Page->isinvertor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_isinvertor"><?= $Page->isinvertor->caption() ?></span></td>
        <td data-name="isinvertor"<?= $Page->isinvertor->cellAttributes() ?>>
<span id="el_member_isinvertor">
<span<?= $Page->isinvertor->viewAttributes() ?>>
<?= $Page->isinvertor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->issale->Visible) { // issale ?>
    <tr id="r_issale"<?= $Page->issale->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_issale"><?= $Page->issale->caption() ?></span></td>
        <td data-name="issale"<?= $Page->issale->cellAttributes() ?>>
<span id="el_member_issale">
<span<?= $Page->issale->viewAttributes() ?>>
<?= $Page->issale->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isnotification->Visible) { // isnotification ?>
    <tr id="r_isnotification"<?= $Page->isnotification->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_isnotification"><?= $Page->isnotification->caption() ?></span></td>
        <td data-name="isnotification"<?= $Page->isnotification->cellAttributes() ?>>
<span id="el_member_isnotification">
<span<?= $Page->isnotification->viewAttributes() ?>>
<?= $Page->isnotification->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image_profile->Visible) { // image_profile ?>
    <tr id="r_image_profile"<?= $Page->image_profile->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_image_profile"><?= $Page->image_profile->caption() ?></span></td>
        <td data-name="image_profile"<?= $Page->image_profile->cellAttributes() ?>>
<span id="el_member_image_profile">
<span>
<?= GetFileViewTag($Page->image_profile, $Page->image_profile->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_member_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_member_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("address", explode(",", $Page->getCurrentDetailTable())) && $address->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("address", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AddressGrid.php" ?>
<?php } ?>
<?php
    if (in_array("asset_favorite", explode(",", $Page->getCurrentDetailTable())) && $asset_favorite->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("asset_favorite", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AssetFavoriteGrid.php" ?>
<?php } ?>
<?php
    if (in_array("appointment", explode(",", $Page->getCurrentDetailTable())) && $appointment->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("appointment", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AppointmentGrid.php" ?>
<?php } ?>
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
