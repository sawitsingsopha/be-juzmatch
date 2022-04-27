<?php

namespace PHPMaker2022\juzmatch;

// Page object
$JuzcalculatorPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { juzcalculator: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid juzcalculator"><!-- .card -->
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
<?php if ($Page->income_all->Visible) { // income_all ?>
    <?php if ($Page->SortUrl($Page->income_all) == "") { ?>
        <th class="<?= $Page->income_all->headerCellClass() ?>"><?= $Page->income_all->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->income_all->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->income_all->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->income_all->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->income_all->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->income_all->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->outcome_all->Visible) { // outcome_all ?>
    <?php if ($Page->SortUrl($Page->outcome_all) == "") { ?>
        <th class="<?= $Page->outcome_all->headerCellClass() ?>"><?= $Page->outcome_all->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->outcome_all->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->outcome_all->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->outcome_all->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->outcome_all->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->outcome_all->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->rent_price->Visible) { // rent_price ?>
    <?php if ($Page->SortUrl($Page->rent_price) == "") { ?>
        <th class="<?= $Page->rent_price->headerCellClass() ?>"><?= $Page->rent_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->rent_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->rent_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->rent_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->rent_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->rent_price->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
    <?php if ($Page->SortUrl($Page->asset_price) == "") { ?>
        <th class="<?= $Page->asset_price->headerCellClass() ?>"><?= $Page->asset_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_price->getSortIcon() ?></span>
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
<?php if ($Page->income_all->Visible) { // income_all ?>
        <!-- income_all -->
        <td<?= $Page->income_all->cellAttributes() ?>>
<span<?= $Page->income_all->viewAttributes() ?>>
<?= $Page->income_all->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->outcome_all->Visible) { // outcome_all ?>
        <!-- outcome_all -->
        <td<?= $Page->outcome_all->cellAttributes() ?>>
<span<?= $Page->outcome_all->viewAttributes() ?>>
<?= $Page->outcome_all->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->rent_price->Visible) { // rent_price ?>
        <!-- rent_price -->
        <td<?= $Page->rent_price->cellAttributes() ?>>
<span<?= $Page->rent_price->viewAttributes() ?>>
<?= $Page->rent_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <!-- asset_price -->
        <td<?= $Page->asset_price->cellAttributes() ?>>
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
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
