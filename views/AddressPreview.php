<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AddressPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { address: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid address"><!-- .card -->
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
<?php if ($Page->address->Visible) { // address ?>
    <?php if ($Page->SortUrl($Page->address) == "") { ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><?= $Page->address->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->address->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->address->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->address->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->address->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
    <?php if ($Page->SortUrl($Page->province_id) == "") { ?>
        <th class="<?= $Page->province_id->headerCellClass() ?>"><?= $Page->province_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->province_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->province_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->province_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->province_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->province_id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
    <?php if ($Page->SortUrl($Page->amphur_id) == "") { ?>
        <th class="<?= $Page->amphur_id->headerCellClass() ?>"><?= $Page->amphur_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->amphur_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->amphur_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->amphur_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->amphur_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->amphur_id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
    <?php if ($Page->SortUrl($Page->district_id) == "") { ?>
        <th class="<?= $Page->district_id->headerCellClass() ?>"><?= $Page->district_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->district_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->district_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->district_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->district_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->district_id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
    <?php if ($Page->SortUrl($Page->postcode) == "") { ?>
        <th class="<?= $Page->postcode->headerCellClass() ?>"><?= $Page->postcode->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->postcode->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->postcode->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->postcode->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->postcode->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->postcode->getSortIcon() ?></span>
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
<?php if ($Page->address->Visible) { // address ?>
        <!-- address -->
        <td<?= $Page->address->cellAttributes() ?>>
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
        <!-- province_id -->
        <td<?= $Page->province_id->cellAttributes() ?>>
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
        <!-- amphur_id -->
        <td<?= $Page->amphur_id->cellAttributes() ?>>
<span<?= $Page->amphur_id->viewAttributes() ?>>
<?= $Page->amphur_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
        <!-- district_id -->
        <td<?= $Page->district_id->cellAttributes() ?>>
<span<?= $Page->district_id->viewAttributes() ?>>
<?= $Page->district_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
        <!-- postcode -->
        <td<?= $Page->postcode->cellAttributes() ?>>
<span<?= $Page->postcode->viewAttributes() ?>>
<?= $Page->postcode->getViewValue() ?></span>
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
