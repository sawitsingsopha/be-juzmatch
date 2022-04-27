<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AllBuyerConfigAssetSchedulePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { all_buyer_config_asset_schedule: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid all_buyer_config_asset_schedule"><!-- .card -->
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
<?php if ($Page->booking_price->Visible) { // booking_price ?>
    <?php if ($Page->SortUrl($Page->booking_price) == "") { ?>
        <th class="<?= $Page->booking_price->headerCellClass() ?>"><?= $Page->booking_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->booking_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->booking_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->booking_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->booking_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->booking_price->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
    <?php if ($Page->SortUrl($Page->down_price) == "") { ?>
        <th class="<?= $Page->down_price->headerCellClass() ?>"><?= $Page->down_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->down_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->down_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->down_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->down_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->down_price->getSortIcon() ?></span>
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
<?php if ($Page->annual_interest->Visible) { // annual_interest ?>
    <?php if ($Page->SortUrl($Page->annual_interest) == "") { ?>
        <th class="<?= $Page->annual_interest->headerCellClass() ?>"><?= $Page->annual_interest->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->annual_interest->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->annual_interest->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->annual_interest->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->annual_interest->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->annual_interest->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
    <?php if ($Page->SortUrl($Page->number_days_pay_first_month) == "") { ?>
        <th class="<?= $Page->number_days_pay_first_month->headerCellClass() ?>"><?= $Page->number_days_pay_first_month->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->number_days_pay_first_month->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->number_days_pay_first_month->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->number_days_pay_first_month->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->number_days_pay_first_month->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->number_days_pay_first_month->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
    <?php if ($Page->SortUrl($Page->number_days_in_first_month) == "") { ?>
        <th class="<?= $Page->number_days_in_first_month->headerCellClass() ?>"><?= $Page->number_days_in_first_month->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->number_days_in_first_month->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->number_days_in_first_month->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->number_days_in_first_month->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->number_days_in_first_month->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->number_days_in_first_month->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
    <?php if ($Page->SortUrl($Page->move_in_on_20th) == "") { ?>
        <th class="<?= $Page->move_in_on_20th->headerCellClass() ?>"><?= $Page->move_in_on_20th->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->move_in_on_20th->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->move_in_on_20th->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->move_in_on_20th->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->move_in_on_20th->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->move_in_on_20th->getSortIcon() ?></span>
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
<?php if ($Page->asset_price->Visible) { // asset_price ?>
        <!-- asset_price -->
        <td<?= $Page->asset_price->cellAttributes() ?>>
<span<?= $Page->asset_price->viewAttributes() ?>>
<?= $Page->asset_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <!-- booking_price -->
        <td<?= $Page->booking_price->cellAttributes() ?>>
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
        <!-- down_price -->
        <td<?= $Page->down_price->cellAttributes() ?>>
<span<?= $Page->down_price->viewAttributes() ?>>
<?= $Page->down_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->installment_price_per->Visible) { // installment_price_per ?>
        <!-- installment_price_per -->
        <td<?= $Page->installment_price_per->cellAttributes() ?>>
<span<?= $Page->installment_price_per->viewAttributes() ?>>
<?= $Page->installment_price_per->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->annual_interest->Visible) { // annual_interest ?>
        <!-- annual_interest -->
        <td<?= $Page->annual_interest->cellAttributes() ?>>
<span<?= $Page->annual_interest->viewAttributes() ?>>
<?= $Page->annual_interest->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->number_days_pay_first_month->Visible) { // number_days_pay_first_month ?>
        <!-- number_days_pay_first_month -->
        <td<?= $Page->number_days_pay_first_month->cellAttributes() ?>>
<span<?= $Page->number_days_pay_first_month->viewAttributes() ?>>
<?= $Page->number_days_pay_first_month->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->number_days_in_first_month->Visible) { // number_days_in_first_month ?>
        <!-- number_days_in_first_month -->
        <td<?= $Page->number_days_in_first_month->cellAttributes() ?>>
<span<?= $Page->number_days_in_first_month->viewAttributes() ?>>
<?= $Page->number_days_in_first_month->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->move_in_on_20th->Visible) { // move_in_on_20th ?>
        <!-- move_in_on_20th -->
        <td<?= $Page->move_in_on_20th->cellAttributes() ?>>
<span<?= $Page->move_in_on_20th->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_move_in_on_20th_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->move_in_on_20th->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->move_in_on_20th->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_move_in_on_20th_<?= $Page->RowCount ?>"></label>
</div></span>
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
