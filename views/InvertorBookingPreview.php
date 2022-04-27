<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvertorBookingPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { invertor_booking: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid invertor_booking"><!-- .card -->
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
<?php if ($Page->payment_status->Visible) { // payment_status ?>
    <?php if ($Page->SortUrl($Page->payment_status) == "") { ?>
        <th class="<?= $Page->payment_status->headerCellClass() ?>"><?= $Page->payment_status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->payment_status->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->payment_status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->payment_status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->payment_status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->payment_status->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
    <?php if ($Page->SortUrl($Page->is_email) == "") { ?>
        <th class="<?= $Page->is_email->headerCellClass() ?>"><?= $Page->is_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->is_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->is_email->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->is_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->is_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->is_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
    <?php if ($Page->SortUrl($Page->receipt_status) == "") { ?>
        <th class="<?= $Page->receipt_status->headerCellClass() ?>"><?= $Page->receipt_status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->receipt_status->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->receipt_status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->receipt_status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->receipt_status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->receipt_status->getSortIcon() ?></span>
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
<?php if ($Page->date_booking->Visible) { // date_booking ?>
        <!-- date_booking -->
        <td<?= $Page->date_booking->cellAttributes() ?>>
<span<?= $Page->date_booking->viewAttributes() ?>>
<?= $Page->date_booking->getViewValue() ?></span>
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
<?php if ($Page->payment_status->Visible) { // payment_status ?>
        <!-- payment_status -->
        <td<?= $Page->payment_status->cellAttributes() ?>>
<span<?= $Page->payment_status->viewAttributes() ?>>
<?= $Page->payment_status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->is_email->Visible) { // is_email ?>
        <!-- is_email -->
        <td<?= $Page->is_email->cellAttributes() ?>>
<span<?= $Page->is_email->viewAttributes() ?>>
<?= $Page->is_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->receipt_status->Visible) { // receipt_status ?>
        <!-- receipt_status -->
        <td<?= $Page->receipt_status->cellAttributes() ?>>
<span<?= $Page->receipt_status->viewAttributes() ?>>
<?= $Page->receipt_status->getViewValue() ?></span>
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
