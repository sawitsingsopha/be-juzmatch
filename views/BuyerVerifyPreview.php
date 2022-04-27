<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerVerifyPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { buyer_verify: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid buyer_verify"><!-- .card -->
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
<?php if ($Page->installment_min->Visible) { // installment_min ?>
    <?php if ($Page->SortUrl($Page->installment_min) == "") { ?>
        <th class="<?= $Page->installment_min->headerCellClass() ?>"><?= $Page->installment_min->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->installment_min->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->installment_min->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->installment_min->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->installment_min->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->installment_min->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->installment_max->Visible) { // installment_max ?>
    <?php if ($Page->SortUrl($Page->installment_max) == "") { ?>
        <th class="<?= $Page->installment_max->headerCellClass() ?>"><?= $Page->installment_max->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->installment_max->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->installment_max->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->installment_max->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->installment_max->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->installment_max->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->num_bedroom->Visible) { // num_bedroom ?>
    <?php if ($Page->SortUrl($Page->num_bedroom) == "") { ?>
        <th class="<?= $Page->num_bedroom->headerCellClass() ?>"><?= $Page->num_bedroom->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->num_bedroom->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->num_bedroom->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->num_bedroom->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->num_bedroom->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->num_bedroom->getSortIcon() ?></span>
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
<?php if ($Page->installment_min->Visible) { // installment_min ?>
        <!-- installment_min -->
        <td<?= $Page->installment_min->cellAttributes() ?>>
<span<?= $Page->installment_min->viewAttributes() ?>>
<?= $Page->installment_min->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->installment_max->Visible) { // installment_max ?>
        <!-- installment_max -->
        <td<?= $Page->installment_max->cellAttributes() ?>>
<span<?= $Page->installment_max->viewAttributes() ?>>
<?= $Page->installment_max->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->num_bedroom->Visible) { // num_bedroom ?>
        <!-- num_bedroom -->
        <td<?= $Page->num_bedroom->cellAttributes() ?>>
<span<?= $Page->num_bedroom->viewAttributes() ?>>
<?= $Page->num_bedroom->getViewValue() ?></span>
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
