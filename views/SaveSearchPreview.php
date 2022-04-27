<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveSearchPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { save_search: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid save_search"><!-- .card -->
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
<?php if ($Page->category_id->Visible) { // category_id ?>
    <?php if ($Page->SortUrl($Page->category_id) == "") { ?>
        <th class="<?= $Page->category_id->headerCellClass() ?>"><?= $Page->category_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->category_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->category_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->category_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->category_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->category_id->getSortIcon() ?></span>
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
<?php if ($Page->min_installment->Visible) { // min_installment ?>
    <?php if ($Page->SortUrl($Page->min_installment) == "") { ?>
        <th class="<?= $Page->min_installment->headerCellClass() ?>"><?= $Page->min_installment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->min_installment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->min_installment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->min_installment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->min_installment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->min_installment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
    <?php if ($Page->SortUrl($Page->max_installment) == "") { ?>
        <th class="<?= $Page->max_installment->headerCellClass() ?>"><?= $Page->max_installment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->max_installment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->max_installment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->max_installment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->max_installment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->max_installment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->min_down->Visible) { // min_down ?>
    <?php if ($Page->SortUrl($Page->min_down) == "") { ?>
        <th class="<?= $Page->min_down->headerCellClass() ?>"><?= $Page->min_down->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->min_down->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->min_down->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->min_down->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->min_down->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->min_down->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->max_down->Visible) { // max_down ?>
    <?php if ($Page->SortUrl($Page->max_down) == "") { ?>
        <th class="<?= $Page->max_down->headerCellClass() ?>"><?= $Page->max_down->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->max_down->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->max_down->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->max_down->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->max_down->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->max_down->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->min_price->Visible) { // min_price ?>
    <?php if ($Page->SortUrl($Page->min_price) == "") { ?>
        <th class="<?= $Page->min_price->headerCellClass() ?>"><?= $Page->min_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->min_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->min_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->min_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->min_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->min_price->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->max_price->Visible) { // max_price ?>
    <?php if ($Page->SortUrl($Page->max_price) == "") { ?>
        <th class="<?= $Page->max_price->headerCellClass() ?>"><?= $Page->max_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->max_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->max_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->max_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->max_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->max_price->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usable_area_min->Visible) { // usable_area_min ?>
    <?php if ($Page->SortUrl($Page->usable_area_min) == "") { ?>
        <th class="<?= $Page->usable_area_min->headerCellClass() ?>"><?= $Page->usable_area_min->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usable_area_min->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->usable_area_min->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usable_area_min->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usable_area_min->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usable_area_min->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usable_area_max->Visible) { // usable_area_max ?>
    <?php if ($Page->SortUrl($Page->usable_area_max) == "") { ?>
        <th class="<?= $Page->usable_area_max->headerCellClass() ?>"><?= $Page->usable_area_max->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usable_area_max->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->usable_area_max->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usable_area_max->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usable_area_max->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usable_area_max->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->land_size_area_min->Visible) { // land_size_area_min ?>
    <?php if ($Page->SortUrl($Page->land_size_area_min) == "") { ?>
        <th class="<?= $Page->land_size_area_min->headerCellClass() ?>"><?= $Page->land_size_area_min->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->land_size_area_min->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->land_size_area_min->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->land_size_area_min->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->land_size_area_min->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->land_size_area_min->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->land_size_area_max->Visible) { // land_size_area_max ?>
    <?php if ($Page->SortUrl($Page->land_size_area_max) == "") { ?>
        <th class="<?= $Page->land_size_area_max->headerCellClass() ?>"><?= $Page->land_size_area_max->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->land_size_area_max->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->land_size_area_max->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->land_size_area_max->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->land_size_area_max->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->land_size_area_max->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bedroom->Visible) { // bedroom ?>
    <?php if ($Page->SortUrl($Page->bedroom) == "") { ?>
        <th class="<?= $Page->bedroom->headerCellClass() ?>"><?= $Page->bedroom->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bedroom->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->bedroom->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->bedroom->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->bedroom->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->bedroom->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <?php if ($Page->SortUrl($Page->latitude) == "") { ?>
        <th class="<?= $Page->latitude->headerCellClass() ?>"><?= $Page->latitude->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->latitude->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->latitude->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->latitude->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->latitude->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->latitude->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <?php if ($Page->SortUrl($Page->longitude) == "") { ?>
        <th class="<?= $Page->longitude->headerCellClass() ?>"><?= $Page->longitude->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->longitude->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->longitude->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->longitude->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->longitude->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->longitude->getSortIcon() ?></span>
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
<?php if ($Page->category_id->Visible) { // category_id ?>
        <!-- category_id -->
        <td<?= $Page->category_id->cellAttributes() ?>>
<span<?= $Page->category_id->viewAttributes() ?>>
<?= $Page->category_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
        <!-- brand_id -->
        <td<?= $Page->brand_id->cellAttributes() ?>>
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->min_installment->Visible) { // min_installment ?>
        <!-- min_installment -->
        <td<?= $Page->min_installment->cellAttributes() ?>>
<span<?= $Page->min_installment->viewAttributes() ?>>
<?= $Page->min_installment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->max_installment->Visible) { // max_installment ?>
        <!-- max_installment -->
        <td<?= $Page->max_installment->cellAttributes() ?>>
<span<?= $Page->max_installment->viewAttributes() ?>>
<?= $Page->max_installment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->min_down->Visible) { // min_down ?>
        <!-- min_down -->
        <td<?= $Page->min_down->cellAttributes() ?>>
<span<?= $Page->min_down->viewAttributes() ?>>
<?= $Page->min_down->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->max_down->Visible) { // max_down ?>
        <!-- max_down -->
        <td<?= $Page->max_down->cellAttributes() ?>>
<span<?= $Page->max_down->viewAttributes() ?>>
<?= $Page->max_down->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->min_price->Visible) { // min_price ?>
        <!-- min_price -->
        <td<?= $Page->min_price->cellAttributes() ?>>
<span<?= $Page->min_price->viewAttributes() ?>>
<?= $Page->min_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->max_price->Visible) { // max_price ?>
        <!-- max_price -->
        <td<?= $Page->max_price->cellAttributes() ?>>
<span<?= $Page->max_price->viewAttributes() ?>>
<?= $Page->max_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usable_area_min->Visible) { // usable_area_min ?>
        <!-- usable_area_min -->
        <td<?= $Page->usable_area_min->cellAttributes() ?>>
<span<?= $Page->usable_area_min->viewAttributes() ?>>
<?= $Page->usable_area_min->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usable_area_max->Visible) { // usable_area_max ?>
        <!-- usable_area_max -->
        <td<?= $Page->usable_area_max->cellAttributes() ?>>
<span<?= $Page->usable_area_max->viewAttributes() ?>>
<?= $Page->usable_area_max->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->land_size_area_min->Visible) { // land_size_area_min ?>
        <!-- land_size_area_min -->
        <td<?= $Page->land_size_area_min->cellAttributes() ?>>
<span<?= $Page->land_size_area_min->viewAttributes() ?>>
<?= $Page->land_size_area_min->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->land_size_area_max->Visible) { // land_size_area_max ?>
        <!-- land_size_area_max -->
        <td<?= $Page->land_size_area_max->cellAttributes() ?>>
<span<?= $Page->land_size_area_max->viewAttributes() ?>>
<?= $Page->land_size_area_max->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bedroom->Visible) { // bedroom ?>
        <!-- bedroom -->
        <td<?= $Page->bedroom->cellAttributes() ?>>
<span<?= $Page->bedroom->viewAttributes() ?>>
<?= $Page->bedroom->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
        <!-- latitude -->
        <td<?= $Page->latitude->cellAttributes() ?>>
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
        <!-- longitude -->
        <td<?= $Page->longitude->cellAttributes() ?>>
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
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
