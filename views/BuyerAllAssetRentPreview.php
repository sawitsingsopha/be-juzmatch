<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAllAssetRentPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { buyer_all_asset_rent: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid buyer_all_asset_rent"><!-- .card -->
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
<?php if ($Page->member_id->Visible) { // member_id ?>
    <?php if ($Page->SortUrl($Page->member_id) == "") { ?>
        <th class="<?= $Page->member_id->headerCellClass() ?>"><?= $Page->member_id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->member_id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->member_id->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->member_id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->member_id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->member_id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
    <?php if ($Page->SortUrl($Page->one_time_status) == "") { ?>
        <th class="<?= $Page->one_time_status->headerCellClass() ?>"><?= $Page->one_time_status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->one_time_status->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->one_time_status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->one_time_status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->one_time_status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->one_time_status->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
    <?php if ($Page->SortUrl($Page->half_price_1) == "") { ?>
        <th class="<?= $Page->half_price_1->headerCellClass() ?>"><?= $Page->half_price_1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->half_price_1->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->half_price_1->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->half_price_1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->half_price_1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->half_price_1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
    <?php if ($Page->SortUrl($Page->status_pay_half_price_1) == "") { ?>
        <th class="<?= $Page->status_pay_half_price_1->headerCellClass() ?>"><?= $Page->status_pay_half_price_1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_pay_half_price_1->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_pay_half_price_1->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_pay_half_price_1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_pay_half_price_1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_pay_half_price_1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
    <?php if ($Page->SortUrl($Page->due_date_pay_half_price_1) == "") { ?>
        <th class="<?= $Page->due_date_pay_half_price_1->headerCellClass() ?>"><?= $Page->due_date_pay_half_price_1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->due_date_pay_half_price_1->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->due_date_pay_half_price_1->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->due_date_pay_half_price_1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->due_date_pay_half_price_1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->due_date_pay_half_price_1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
    <?php if ($Page->SortUrl($Page->half_price_2) == "") { ?>
        <th class="<?= $Page->half_price_2->headerCellClass() ?>"><?= $Page->half_price_2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->half_price_2->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->half_price_2->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->half_price_2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->half_price_2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->half_price_2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
    <?php if ($Page->SortUrl($Page->status_pay_half_price_2) == "") { ?>
        <th class="<?= $Page->status_pay_half_price_2->headerCellClass() ?>"><?= $Page->status_pay_half_price_2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_pay_half_price_2->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_pay_half_price_2->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_pay_half_price_2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_pay_half_price_2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_pay_half_price_2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
    <?php if ($Page->SortUrl($Page->due_date_pay_half_price_2) == "") { ?>
        <th class="<?= $Page->due_date_pay_half_price_2->headerCellClass() ?>"><?= $Page->due_date_pay_half_price_2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->due_date_pay_half_price_2->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->due_date_pay_half_price_2->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->due_date_pay_half_price_2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->due_date_pay_half_price_2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->due_date_pay_half_price_2->getSortIcon() ?></span>
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
<?php if ($Page->member_id->Visible) { // member_id ?>
        <!-- member_id -->
        <td<?= $Page->member_id->cellAttributes() ?>>
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->one_time_status->Visible) { // one_time_status ?>
        <!-- one_time_status -->
        <td<?= $Page->one_time_status->cellAttributes() ?>>
<span<?= $Page->one_time_status->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_one_time_status_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->one_time_status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->one_time_status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_one_time_status_<?= $Page->RowCount ?>"></label>
</div></span>
</td>
<?php } ?>
<?php if ($Page->half_price_1->Visible) { // half_price_1 ?>
        <!-- half_price_1 -->
        <td<?= $Page->half_price_1->cellAttributes() ?>>
<span<?= $Page->half_price_1->viewAttributes() ?>>
<?= $Page->half_price_1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_pay_half_price_1->Visible) { // status_pay_half_price_1 ?>
        <!-- status_pay_half_price_1 -->
        <td<?= $Page->status_pay_half_price_1->cellAttributes() ?>>
<span<?= $Page->status_pay_half_price_1->viewAttributes() ?>>
<?= $Page->status_pay_half_price_1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_1->Visible) { // due_date_pay_half_price_1 ?>
        <!-- due_date_pay_half_price_1 -->
        <td<?= $Page->due_date_pay_half_price_1->cellAttributes() ?>>
<span<?= $Page->due_date_pay_half_price_1->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->half_price_2->Visible) { // half_price_2 ?>
        <!-- half_price_2 -->
        <td<?= $Page->half_price_2->cellAttributes() ?>>
<span<?= $Page->half_price_2->viewAttributes() ?>>
<?= $Page->half_price_2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_pay_half_price_2->Visible) { // status_pay_half_price_2 ?>
        <!-- status_pay_half_price_2 -->
        <td<?= $Page->status_pay_half_price_2->cellAttributes() ?>>
<span<?= $Page->status_pay_half_price_2->viewAttributes() ?>>
<?= $Page->status_pay_half_price_2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->due_date_pay_half_price_2->Visible) { // due_date_pay_half_price_2 ?>
        <!-- due_date_pay_half_price_2 -->
        <td<?= $Page->due_date_pay_half_price_2->cellAttributes() ?>>
<span<?= $Page->due_date_pay_half_price_2->viewAttributes() ?>>
<?= $Page->due_date_pay_half_price_2->getViewValue() ?></span>
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
