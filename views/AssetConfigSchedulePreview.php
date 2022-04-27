<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetConfigSchedulePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { asset_config_schedule: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid asset_config_schedule"><!-- .card -->
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
<?php if ($Page->installment_all->Visible) { // installment_all ?>
    <?php if ($Page->SortUrl($Page->installment_all) == "") { ?>
        <th class="<?= $Page->installment_all->headerCellClass() ?>"><?= $Page->installment_all->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->installment_all->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->installment_all->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->installment_all->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->installment_all->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->installment_all->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
    <?php if ($Page->SortUrl($Page->installment_price_per) == "") { ?>
        <th class="<?= $Page->installment_price_per->headerCellClass() ?>"><?= $Page->installment_price_per->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->installment_price_per->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->installment_price_per->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->installment_price_per->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->installment_price_per->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->installment_price_per->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
    <?php if ($Page->SortUrl($Page->date_start_installment) == "") { ?>
        <th class="<?= $Page->date_start_installment->headerCellClass() ?>"><?= $Page->date_start_installment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->date_start_installment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->date_start_installment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->date_start_installment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->date_start_installment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->date_start_installment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
    <?php if ($Page->SortUrl($Page->status_approve) == "") { ?>
        <th class="<?= $Page->status_approve->headerCellClass() ?>"><?= $Page->status_approve->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_approve->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_approve->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_approve->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_approve->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_approve->getSortIcon() ?></span>
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
<?php if ($Page->installment_all->Visible) { // installment_all ?>
        <!-- installment_all -->
        <td<?= $Page->installment_all->cellAttributes() ?>>
<span<?= $Page->installment_all->viewAttributes() ?>>
<?= $Page->installment_all->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <!-- installment_price_per -->
        <td<?= $Page->installment_price_per->cellAttributes() ?>>
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->date_start_installment->Visible) { // date_start_installment ?>
        <!-- date_start_installment -->
        <td<?= $Page->date_start_installment->cellAttributes() ?>>
<span<?= $Page->date_start_installment->viewAttributes() ?>>
<?= $Page->date_start_installment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_approve->Visible) { // status_approve ?>
        <!-- status_approve -->
        <td<?= $Page->status_approve->cellAttributes() ?>>
<span<?= $Page->status_approve->viewAttributes() ?>>
<?= $Page->status_approve->getViewValue() ?></span>
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
