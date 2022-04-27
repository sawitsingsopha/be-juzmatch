<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article: currentTable } });
var currentForm, currentPageID;
var farticledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticledelete = new ew.Form("farticledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = farticledelete;
    loadjs.done("farticledelete");
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
<form name="farticledelete" id="farticledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article">
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
<?php if ($Page->article_category_id->Visible) { // article_category_id ?>
        <th class="<?= $Page->article_category_id->headerCellClass() ?>"><span id="elh_article_article_category_id" class="article_article_category_id"><?= $Page->article_category_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><span id="elh_article__title" class="article__title"><?= $Page->_title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><span id="elh_article_image" class="article_image"><?= $Page->image->caption() ?></span></th>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><span id="elh_article_order_by" class="article_order_by"><?= $Page->order_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->highlight->Visible) { // highlight ?>
        <th class="<?= $Page->highlight->headerCellClass() ?>"><span id="elh_article_highlight" class="article_highlight"><?= $Page->highlight->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_article_cdate" class="article_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->article_category_id->Visible) { // article_category_id ?>
        <td<?= $Page->article_category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_article_category_id" class="el_article_article_category_id">
<span<?= $Page->article_category_id->viewAttributes() ?>>
<?= $Page->article_category_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <td<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article__title" class="el_article__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <td<?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_image" class="el_article_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <td<?= $Page->order_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_order_by" class="el_article_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->highlight->Visible) { // highlight ?>
        <td<?= $Page->highlight->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_highlight" class="el_article_highlight">
<span<?= $Page->highlight->viewAttributes() ?>>
<?= $Page->highlight->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_cdate" class="el_article_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
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
