<?php

namespace PHPMaker2022\juzmatch;

// Page object
$JuzcalculatorOutcomePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { juzcalculator_outcome: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid juzcalculator_outcome"><!-- .card -->
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
<?php if ($Page->outcome_title->Visible) { // outcome_title ?>
    <?php if ($Page->SortUrl($Page->outcome_title) == "") { ?>
        <th class="<?= $Page->outcome_title->headerCellClass() ?>"><?= $Page->outcome_title->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->outcome_title->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->outcome_title->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->outcome_title->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->outcome_title->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->outcome_title->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->outcome->Visible) { // outcome ?>
    <?php if ($Page->SortUrl($Page->outcome) == "") { ?>
        <th class="<?= $Page->outcome->headerCellClass() ?>"><?= $Page->outcome->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->outcome->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->outcome->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->outcome->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->outcome->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->outcome->getSortIcon() ?></span>
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
<?php if ($Page->outcome_title->Visible) { // outcome_title ?>
        <!-- outcome_title -->
        <td<?= $Page->outcome_title->cellAttributes() ?>>
<span<?= $Page->outcome_title->viewAttributes() ?>>
<?= $Page->outcome_title->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->outcome->Visible) { // outcome ?>
        <!-- outcome -->
        <td<?= $Page->outcome->cellAttributes() ?>>
<span<?= $Page->outcome->viewAttributes() ?>>
<?= $Page->outcome->getViewValue() ?></span>
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
