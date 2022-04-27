<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { asset: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid asset"><!-- .card -->
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
<?php if ($Page->_title->Visible) { // title ?>
    <?php if ($Page->SortUrl($Page->_title) == "") { ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><?= $Page->_title->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->_title->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->_title->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_title->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_title->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
    <?php if ($Page->SortUrl($Page->brand_id) == "") { ?>
        <th class="<?= $Page->brand_id->headerCellClass() ?>"><?= $Page->brand_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->brand_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->brand_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->brand_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->brand_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->brand_id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <?php if ($Page->SortUrl($Page->asset_code) == "") { ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><?= $Page->asset_code->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_code->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_code->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_code->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_code->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_code->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
    <?php if ($Page->SortUrl($Page->asset_status) == "") { ?>
        <th class="<?= $Page->asset_status->headerCellClass() ?>"><?= $Page->asset_status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_status->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_status->getSortIcon() ?></span>
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
<?php if ($Page->price_mark->Visible) { // price_mark ?>
    <?php if ($Page->SortUrl($Page->price_mark) == "") { ?>
        <th class="<?= $Page->price_mark->headerCellClass() ?>"><?= $Page->price_mark->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->price_mark->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->price_mark->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->price_mark->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->price_mark->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->price_mark->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
    <?php if ($Page->SortUrl($Page->usable_area) == "") { ?>
        <th class="<?= $Page->usable_area->headerCellClass() ?>"><?= $Page->usable_area->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usable_area->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->usable_area->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usable_area->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usable_area->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usable_area->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
    <?php if ($Page->SortUrl($Page->land_size) == "") { ?>
        <th class="<?= $Page->land_size->headerCellClass() ?>"><?= $Page->land_size->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->land_size->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->land_size->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->land_size->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->land_size->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->land_size->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
    <?php if ($Page->SortUrl($Page->count_view) == "") { ?>
        <th class="<?= $Page->count_view->headerCellClass() ?>"><?= $Page->count_view->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->count_view->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->count_view->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->count_view->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->count_view->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->count_view->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->count_favorite->Visible) { // count_favorite ?>
    <?php if ($Page->SortUrl($Page->count_favorite) == "") { ?>
        <th class="<?= $Page->count_favorite->headerCellClass() ?>"><?= $Page->count_favorite->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->count_favorite->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->count_favorite->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->count_favorite->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->count_favorite->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->count_favorite->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
    <?php if ($Page->SortUrl($Page->expired_date) == "") { ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><?= $Page->expired_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->expired_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->expired_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->expired_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->expired_date->getSortIcon() ?></span>
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
<?php if ($Page->_title->Visible) { // title ?>
        <!-- title -->
        <td<?= $Page->_title->cellAttributes() ?>>
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <!-- brand_id -->
        <td<?= $Page->brand_id->cellAttributes() ?>>
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
        <!-- asset_code -->
        <td<?= $Page->asset_code->cellAttributes() ?>>
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
        <!-- asset_status -->
        <td<?= $Page->asset_status->cellAttributes() ?>>
<span<?= $Page->asset_status->viewAttributes() ?>>
<?= $Page->asset_status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
        <!-- isactive -->
        <td<?= $Page->isactive->cellAttributes() ?>>
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->price_mark->Visible) { // price_mark ?>
        <!-- price_mark -->
        <td<?= $Page->price_mark->cellAttributes() ?>>
<span<?= $Page->price_mark->viewAttributes() ?>>
<?= $Page->price_mark->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
        <!-- usable_area -->
        <td<?= $Page->usable_area->cellAttributes() ?>>
<span<?= $Page->usable_area->viewAttributes() ?>>
<?= $Page->usable_area->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
        <!-- land_size -->
        <td<?= $Page->land_size->cellAttributes() ?>>
<span<?= $Page->land_size->viewAttributes() ?>>
<?= $Page->land_size->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
        <!-- count_view -->
        <td<?= $Page->count_view->cellAttributes() ?>>
<span<?= $Page->count_view->viewAttributes() ?>>
<?= $Page->count_view->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->count_favorite->Visible) { // count_favorite ?>
        <!-- count_favorite -->
        <td<?= $Page->count_favorite->cellAttributes() ?>>
<span<?= $Page->count_favorite->viewAttributes() ?>>
<?= $Page->count_favorite->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <!-- expired_date -->
        <td<?= $Page->expired_date->cellAttributes() ?>>
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
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
