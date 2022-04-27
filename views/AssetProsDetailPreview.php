<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetProsDetailPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { asset_pros_detail: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid asset_pros_detail"><!-- .card -->
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
<?php if ($Page->detail->Visible) { // detail ?>
    <?php if ($Page->SortUrl($Page->detail) == "") { ?>
        <th class="<?= $Page->detail->headerCellClass() ?>"><?= $Page->detail->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->detail->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->detail->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->detail->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->detail->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->detail->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->group_type->Visible) { // group_type ?>
    <?php if ($Page->SortUrl($Page->group_type) == "") { ?>
        <th class="<?= $Page->group_type->headerCellClass() ?>"><?= $Page->group_type->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->group_type->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->group_type->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->group_type->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->group_type->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->group_type->getSortIcon() ?></span>
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
<?php if ($Page->detail->Visible) { // detail ?>
        <!-- detail -->
        <td<?= $Page->detail->cellAttributes() ?>>
<span<?= $Page->detail->viewAttributes() ?>>
<?= $Page->detail->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->group_type->Visible) { // group_type ?>
        <!-- group_type -->
        <td<?= $Page->group_type->cellAttributes() ?>>
<span<?= $Page->group_type->viewAttributes() ?>>
<?= $Page->group_type->getViewValue() ?></span>
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
