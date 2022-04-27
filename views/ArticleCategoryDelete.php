<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleCategoryDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article_category: currentTable } });
var currentForm, currentPageID;
var farticle_categorydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticle_categorydelete = new ew.Form("farticle_categorydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = farticle_categorydelete;
    loadjs.done("farticle_categorydelete");
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
<form name="farticle_categorydelete" id="farticle_categorydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article_category">
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
<?php if ($Page->article_title->Visible) { // article_title ?>
        <th class="<?= $Page->article_title->headerCellClass() ?>"><span id="elh_article_category_article_title" class="article_category_article_title"><?= $Page->article_title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->article_title_en->Visible) { // article_title_en ?>
        <th class="<?= $Page->article_title_en->headerCellClass() ?>"><span id="elh_article_category_article_title_en" class="article_category_article_title_en"><?= $Page->article_title_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><span id="elh_article_category_order_by" class="article_category_order_by"><?= $Page->order_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
        <th class="<?= $Page->active_status->headerCellClass() ?>"><span id="elh_article_category_active_status" class="article_category_active_status"><?= $Page->active_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_article_category_cdate" class="article_category_cdate"><?= $Page->cdate->caption() ?></span></th>
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
<?php if ($Page->article_title->Visible) { // article_title ?>
        <td<?= $Page->article_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_category_article_title" class="el_article_category_article_title">
<span<?= $Page->article_title->viewAttributes() ?>>
<?= $Page->article_title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->article_title_en->Visible) { // article_title_en ?>
        <td<?= $Page->article_title_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_category_article_title_en" class="el_article_category_article_title_en">
<span<?= $Page->article_title_en->viewAttributes() ?>>
<?= $Page->article_title_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <td<?= $Page->order_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_category_order_by" class="el_article_category_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
        <td<?= $Page->active_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_category_active_status" class="el_article_category_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_category_cdate" class="el_article_category_cdate">
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
