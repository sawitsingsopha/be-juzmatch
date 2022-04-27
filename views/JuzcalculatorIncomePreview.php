<?php

namespace PHPMaker2022\juzmatch;

// Page object
$JuzcalculatorIncomePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { juzcalculator_income: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid juzcalculator_income"><!-- .card -->
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
<?php if ($Page->income_title->Visible) { // income_title ?>
    <?php if ($Page->SortUrl($Page->income_title) == "") { ?>
        <th class="<?= $Page->income_title->headerCellClass() ?>"><?= $Page->income_title->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->income_title->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->income_title->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->income_title->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->income_title->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->income_title->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
    <?php if ($Page->SortUrl($Page->income) == "") { ?>
        <th class="<?= $Page->income->headerCellClass() ?>"><?= $Page->income->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->income->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->income->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->income->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->income->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->income->getSortIcon() ?></span>
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
<?php if ($Page->income_title->Visible) { // income_title ?>
        <!-- income_title -->
        <td<?= $Page->income_title->cellAttributes() ?>>
<span<?= $Page->income_title->viewAttributes() ?>>
<?= $Page->income_title->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
        <!-- income -->
        <td<?= $Page->income->cellAttributes() ?>>
<span<?= $Page->income->viewAttributes() ?>>
<?= $Page->income->getViewValue() ?></span>
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
