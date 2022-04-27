<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SubdistrictView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { subdistrict: currentTable } });
var currentForm, currentPageID;
var fsubdistrictview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsubdistrictview = new ew.Form("fsubdistrictview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fsubdistrictview;
    loadjs.done("fsubdistrictview");
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
<form name="fsubdistrictview" id="fsubdistrictview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subdistrict">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->subdistrict_id->Visible) { // subdistrict_id ?>
    <tr id="r_subdistrict_id"<?= $Page->subdistrict_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_subdistrict_id"><?= $Page->subdistrict_id->caption() ?></span></td>
        <td data-name="subdistrict_id"<?= $Page->subdistrict_id->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_id">
<span<?= $Page->subdistrict_id->viewAttributes() ?>>
<?= $Page->subdistrict_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subdistrict_code->Visible) { // subdistrict_code ?>
    <tr id="r_subdistrict_code"<?= $Page->subdistrict_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_subdistrict_code"><?= $Page->subdistrict_code->caption() ?></span></td>
        <td data-name="subdistrict_code"<?= $Page->subdistrict_code->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_code">
<span<?= $Page->subdistrict_code->viewAttributes() ?>>
<?= $Page->subdistrict_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
    <tr id="r_district_id"<?= $Page->district_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_district_id"><?= $Page->district_id->caption() ?></span></td>
        <td data-name="district_id"<?= $Page->district_id->cellAttributes() ?>>
<span id="el_subdistrict_district_id">
<span<?= $Page->district_id->viewAttributes() ?>>
<?= $Page->district_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
    <tr id="r_province_id"<?= $Page->province_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_province_id"><?= $Page->province_id->caption() ?></span></td>
        <td data-name="province_id"<?= $Page->province_id->cellAttributes() ?>>
<span id="el_subdistrict_province_id">
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->geo_id->Visible) { // geo_id ?>
    <tr id="r_geo_id"<?= $Page->geo_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_geo_id"><?= $Page->geo_id->caption() ?></span></td>
        <td data-name="geo_id"<?= $Page->geo_id->cellAttributes() ?>>
<span id="el_subdistrict_geo_id">
<span<?= $Page->geo_id->viewAttributes() ?>>
<?= $Page->geo_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subdistrict_name->Visible) { // subdistrict_name ?>
    <tr id="r_subdistrict_name"<?= $Page->subdistrict_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_subdistrict_name"><?= $Page->subdistrict_name->caption() ?></span></td>
        <td data-name="subdistrict_name"<?= $Page->subdistrict_name->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_name">
<span<?= $Page->subdistrict_name->viewAttributes() ?>>
<?= $Page->subdistrict_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subdistrict_name_en->Visible) { // subdistrict_name_en ?>
    <tr id="r_subdistrict_name_en"<?= $Page->subdistrict_name_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_subdistrict_subdistrict_name_en"><?= $Page->subdistrict_name_en->caption() ?></span></td>
        <td data-name="subdistrict_name_en"<?= $Page->subdistrict_name_en->cellAttributes() ?>>
<span id="el_subdistrict_subdistrict_name_en">
<span<?= $Page->subdistrict_name_en->viewAttributes() ?>>
<?= $Page->subdistrict_name_en->getViewValue() ?></span>
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
