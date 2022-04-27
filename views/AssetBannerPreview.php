<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetBannerPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { asset_banner: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid asset_banner"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table table-bordered table-hover table-sm ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->image->Visible) { // image ?>
    <?php if ($Page->SortUrl($Page->image) == "") { ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><?= $Page->image->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->image->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->image->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->image->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->image->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <?php if ($Page->SortUrl($Page->order_by) == "") { ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><?= $Page->order_by->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->order_by->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->order_by->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->order_by->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->order_by->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <?php if ($Page->SortUrl($Page->isactive) == "") { ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><?= $Page->isactive->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->isactive->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->isactive->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->isactive->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->isactive->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->isactive->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <?php if ($Page->SortUrl($Page->cdate) == "") { ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><?= $Page->cdate->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->cdate->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->cdate->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cdate->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cdate->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->image->Visible) { // image ?>
        <!-- image -->
        <td<?= $Page->image->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <!-- order_by -->
        <td<?= $Page->order_by->cellAttributes() ?>>
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <!-- isactive -->
        <td<?= $Page->isactive->cellAttributes() ?>>
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <!-- cdate -->
        <td<?= $Page->cdate->cellAttributes() ?>>
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
