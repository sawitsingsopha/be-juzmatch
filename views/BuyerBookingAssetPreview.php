<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerBookingAssetPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { buyer_booking_asset: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid buyer_booking_asset"><!-- .card -->
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
<?php if ($Page->pay_number->Visible) { // pay_number ?>
    <?php if ($Page->SortUrl($Page->pay_number) == "") { ?>
        <th class="<?= $Page->pay_number->headerCellClass() ?>"><?= $Page->pay_number->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pay_number->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->pay_number->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->pay_number->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->pay_number->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->pay_number->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
    <?php if ($Page->SortUrl($Page->status_payment) == "") { ?>
        <th class="<?= $Page->status_payment->headerCellClass() ?>"><?= $Page->status_payment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_payment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_payment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_payment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_payment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_payment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
    <?php if ($Page->SortUrl($Page->date_booking) == "") { ?>
        <th class="<?= $Page->date_booking->headerCellClass() ?>"><?= $Page->date_booking->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->date_booking->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->date_booking->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->date_booking->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->date_booking->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->date_booking->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
    <?php if ($Page->SortUrl($Page->date_payment) == "") { ?>
        <th class="<?= $Page->date_payment->headerCellClass() ?>"><?= $Page->date_payment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->date_payment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->date_payment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->date_payment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->date_payment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->date_payment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
    <?php if ($Page->SortUrl($Page->due_date) == "") { ?>
        <th class="<?= $Page->due_date->headerCellClass() ?>"><?= $Page->due_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->due_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->due_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->due_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->due_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->due_date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
    <?php if ($Page->SortUrl($Page->status_expire) == "") { ?>
        <th class="<?= $Page->status_expire->headerCellClass() ?>"><?= $Page->status_expire->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_expire->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_expire->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_expire->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_expire->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_expire->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
    <?php if ($Page->SortUrl($Page->status_expire_reason) == "") { ?>
        <th class="<?= $Page->status_expire_reason->headerCellClass() ?>"><?= $Page->status_expire_reason->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_expire_reason->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status_expire_reason->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_expire_reason->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_expire_reason->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_expire_reason->getSortIcon() ?></span>
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
<?php if ($Page->asset_id->Visible) { // asset_id ?>
        <!-- asset_id -->
        <td<?= $Page->asset_id->cellAttributes() ?>>
<span<?= $Page->asset_id->viewAttributes() ?>>
<?= $Page->asset_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->booking_price->Visible) { // booking_price ?>
        <!-- booking_price -->
        <td<?= $Page->booking_price->cellAttributes() ?>>
<span<?= $Page->booking_price->viewAttributes() ?>>
<?= $Page->booking_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <!-- pay_number -->
        <td<?= $Page->pay_number->cellAttributes() ?>>
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <!-- status_payment -->
        <td<?= $Page->status_payment->cellAttributes() ?>>
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <!-- date_booking -->
        <td<?= $Page->date_booking->cellAttributes() ?>>
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <!-- date_payment -->
        <td<?= $Page->date_payment->cellAttributes() ?>>
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->due_date->Visible) { // due_date ?>
        <!-- due_date -->
        <td<?= $Page->due_date->cellAttributes() ?>>
<span<?= $Page->due_date->viewAttributes() ?>>
<?= $Page->due_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_expire->Visible) { // status_expire ?>
        <!-- status_expire -->
        <td<?= $Page->status_expire->cellAttributes() ?>>
<span<?= $Page->status_expire->viewAttributes() ?>>
<?= $Page->status_expire->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_expire_reason->Visible) { // status_expire_reason ?>
        <!-- status_expire_reason -->
        <td<?= $Page->status_expire_reason->cellAttributes() ?>>
<span<?= $Page->status_expire_reason->viewAttributes() ?>>
<?= $Page->status_expire_reason->getViewValue() ?></span>
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
