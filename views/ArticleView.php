<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article: currentTable } });
var currentForm, currentPageID;
var farticleview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticleview = new ew.Form("farticleview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = farticleview;
    loadjs.done("farticleview");
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
<form name="farticleview" id="farticleview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->article_category_id->Visible) { // article_category_id ?>
    <tr id="r_article_category_id"<?= $Page->article_category_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_article_category_id"><?= $Page->article_category_id->caption() ?></span></td>
        <td data-name="article_category_id"<?= $Page->article_category_id->cellAttributes() ?>>
<span id="el_article_article_category_id">
<span<?= $Page->article_category_id->viewAttributes() ?>>
<?= $Page->article_category_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <tr id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article__title"><?= $Page->_title->caption() ?></span></td>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el_article__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <tr id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_title_en"><?= $Page->title_en->caption() ?></span></td>
        <td data-name="title_en"<?= $Page->title_en->cellAttributes() ?>>
<span id="el_article_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <tr id="r_detail"<?= $Page->detail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_detail"><?= $Page->detail->caption() ?></span></td>
        <td data-name="detail"<?= $Page->detail->cellAttributes() ?>>
<span id="el_article_detail">
<span<?= $Page->detail->viewAttributes() ?>>
<?= $Page->detail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detail_en->Visible) { // detail_en ?>
    <tr id="r_detail_en"<?= $Page->detail_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_detail_en"><?= $Page->detail_en->caption() ?></span></td>
        <td data-name="detail_en"<?= $Page->detail_en->cellAttributes() ?>>
<span id="el_article_detail_en">
<span<?= $Page->detail_en->viewAttributes() ?>>
<?= $Page->detail_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <tr id="r_image"<?= $Page->image->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_image"><?= $Page->image->caption() ?></span></td>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<span id="el_article_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <tr id="r_order_by"<?= $Page->order_by->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_order_by"><?= $Page->order_by->caption() ?></span></td>
        <td data-name="order_by"<?= $Page->order_by->cellAttributes() ?>>
<span id="el_article_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tag->Visible) { // tag ?>
    <tr id="r_tag"<?= $Page->tag->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_tag"><?= $Page->tag->caption() ?></span></td>
        <td data-name="tag"<?= $Page->tag->cellAttributes() ?>>
<span id="el_article_tag">
<span<?= $Page->tag->viewAttributes() ?>>
<?= $Page->tag->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->highlight->Visible) { // highlight ?>
    <tr id="r_highlight"<?= $Page->highlight->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_highlight"><?= $Page->highlight->caption() ?></span></td>
        <td data-name="highlight"<?= $Page->highlight->cellAttributes() ?>>
<span id="el_article_highlight">
<span<?= $Page->highlight->viewAttributes() ?>>
<?= $Page->highlight->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
    <tr id="r_count_view"<?= $Page->count_view->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_count_view"><?= $Page->count_view->caption() ?></span></td>
        <td data-name="count_view"<?= $Page->count_view->cellAttributes() ?>>
<span id="el_article_count_view">
<span<?= $Page->count_view->viewAttributes() ?>>
<?= $Page->count_view->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_share_facebook->Visible) { // count_share_facebook ?>
    <tr id="r_count_share_facebook"<?= $Page->count_share_facebook->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_count_share_facebook"><?= $Page->count_share_facebook->caption() ?></span></td>
        <td data-name="count_share_facebook"<?= $Page->count_share_facebook->cellAttributes() ?>>
<span id="el_article_count_share_facebook">
<span<?= $Page->count_share_facebook->viewAttributes() ?>>
<?= $Page->count_share_facebook->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_share_line->Visible) { // count_share_line ?>
    <tr id="r_count_share_line"<?= $Page->count_share_line->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_count_share_line"><?= $Page->count_share_line->caption() ?></span></td>
        <td data-name="count_share_line"<?= $Page->count_share_line->cellAttributes() ?>>
<span id="el_article_count_share_line">
<span<?= $Page->count_share_line->viewAttributes() ?>>
<?= $Page->count_share_line->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_share_twitter->Visible) { // count_share_twitter ?>
    <tr id="r_count_share_twitter"<?= $Page->count_share_twitter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_count_share_twitter"><?= $Page->count_share_twitter->caption() ?></span></td>
        <td data-name="count_share_twitter"<?= $Page->count_share_twitter->cellAttributes() ?>>
<span id="el_article_count_share_twitter">
<span<?= $Page->count_share_twitter->viewAttributes() ?>>
<?= $Page->count_share_twitter->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_share_email->Visible) { // count_share_email ?>
    <tr id="r_count_share_email"<?= $Page->count_share_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_count_share_email"><?= $Page->count_share_email->caption() ?></span></td>
        <td data-name="count_share_email"<?= $Page->count_share_email->cellAttributes() ?>>
<span id="el_article_count_share_email">
<span<?= $Page->count_share_email->viewAttributes() ?>>
<?= $Page->count_share_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
    <tr id="r_active_status"<?= $Page->active_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_active_status"><?= $Page->active_status->caption() ?></span></td>
        <td data-name="active_status"<?= $Page->active_status->cellAttributes() ?>>
<span id="el_article_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta_title->Visible) { // meta_title ?>
    <tr id="r_meta_title"<?= $Page->meta_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_meta_title"><?= $Page->meta_title->caption() ?></span></td>
        <td data-name="meta_title"<?= $Page->meta_title->cellAttributes() ?>>
<span id="el_article_meta_title">
<span<?= $Page->meta_title->viewAttributes() ?>>
<?= $Page->meta_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta_title_en->Visible) { // meta_title_en ?>
    <tr id="r_meta_title_en"<?= $Page->meta_title_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_meta_title_en"><?= $Page->meta_title_en->caption() ?></span></td>
        <td data-name="meta_title_en"<?= $Page->meta_title_en->cellAttributes() ?>>
<span id="el_article_meta_title_en">
<span<?= $Page->meta_title_en->viewAttributes() ?>>
<?= $Page->meta_title_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta_description->Visible) { // meta_description ?>
    <tr id="r_meta_description"<?= $Page->meta_description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_meta_description"><?= $Page->meta_description->caption() ?></span></td>
        <td data-name="meta_description"<?= $Page->meta_description->cellAttributes() ?>>
<span id="el_article_meta_description">
<span<?= $Page->meta_description->viewAttributes() ?>>
<?= $Page->meta_description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta_description_en->Visible) { // meta_description_en ?>
    <tr id="r_meta_description_en"<?= $Page->meta_description_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_meta_description_en"><?= $Page->meta_description_en->caption() ?></span></td>
        <td data-name="meta_description_en"<?= $Page->meta_description_en->cellAttributes() ?>>
<span id="el_article_meta_description_en">
<span<?= $Page->meta_description_en->viewAttributes() ?>>
<?= $Page->meta_description_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta_keyword->Visible) { // meta_keyword ?>
    <tr id="r_meta_keyword"<?= $Page->meta_keyword->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_meta_keyword"><?= $Page->meta_keyword->caption() ?></span></td>
        <td data-name="meta_keyword"<?= $Page->meta_keyword->cellAttributes() ?>>
<span id="el_article_meta_keyword">
<span<?= $Page->meta_keyword->viewAttributes() ?>>
<?= $Page->meta_keyword->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta_keyword_en->Visible) { // meta_keyword_en ?>
    <tr id="r_meta_keyword_en"<?= $Page->meta_keyword_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_meta_keyword_en"><?= $Page->meta_keyword_en->caption() ?></span></td>
        <td data-name="meta_keyword_en"<?= $Page->meta_keyword_en->cellAttributes() ?>>
<span id="el_article_meta_keyword_en">
<span<?= $Page->meta_keyword_en->viewAttributes() ?>>
<?= $Page->meta_keyword_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_article_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_article_cdate">
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
