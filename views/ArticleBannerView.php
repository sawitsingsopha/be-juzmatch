<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleBannerView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article_banner: currentTable } });
var currentForm, currentPageID;
var farticle_bannerview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticle_bannerview = new ew.Form("farticle_bannerview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = farticle_bannerview;
    loadjs.done("farticle_bannerview");
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
<form name="farticle_bannerview" id="farticle_bannerview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article_banner">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->article_title->Visible) { // article_title ?>
    <tr id="r_article_title"<?= $Page->article_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_banner_article_title"><?= $Page->article_title->caption() ?></span></td>
        <td data-name="article_title"<?= $Page->article_title->cellAttributes() ?>>
<span id="el_article_banner_article_title">
<span<?= $Page->article_title->viewAttributes() ?>>
<?= $Page->article_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <tr id="r_image"<?= $Page->image->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_banner_image"><?= $Page->image->caption() ?></span></td>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<span id="el_article_banner_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <tr id="r_order_by"<?= $Page->order_by->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_banner_order_by"><?= $Page->order_by->caption() ?></span></td>
        <td data-name="order_by"<?= $Page->order_by->cellAttributes() ?>>
<span id="el_article_banner_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <tr id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_banner_active_status"><?= $Page->active_status->caption() ?></span></td>
        <td data-name="active_status"<?= $Page->active_status->cellAttributes() ?>>
<span id="el_article_banner_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_banner_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_article_banner_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
