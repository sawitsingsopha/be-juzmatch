<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaleAssetPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sale_asset: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid sale_asset"><!-- .card -->
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
    <?php if ($Page->SortUrl($Page->asset_id) == "") { ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><?= $Page->asset_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->asset_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->asset_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->asset_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->asset_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->asset_id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_live->Visible) { // status_live ?>
    <?php if ($Page->SortUrl($Page->status_live) == "") { ?>
        <th class="<?= $Page->status_live->headerCellClass() ?>"><?= $Page->status_live->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_live->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_live->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_live->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_live->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_live->getSortIcon() ?></span>
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <!-- asset_id -->
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_live->Visible) { // status_live ?>
        <!-- status_live -->
        <td<?= $Page->status_live->cellAttributes() ?>>
<span<?= $Page->status_live->viewAttributes() ?>>
<?= $Page->status_live->getViewValue() ?></span>
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
