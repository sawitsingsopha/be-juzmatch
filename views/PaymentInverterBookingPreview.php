<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PaymentInverterBookingPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { payment_inverter_booking: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid payment_inverter_booking"><!-- .card -->
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
<?php if ($Page->payment->Visible) { // payment ?>
    <?php if ($Page->SortUrl($Page->payment) == "") { ?>
        <th class="<?= $Page->payment->headerCellClass() ?>"><?= $Page->payment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->payment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->payment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->payment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->payment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->payment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->payment_number->Visible) { // payment_number ?>
    <?php if ($Page->SortUrl($Page->payment_number) == "") { ?>
        <th class="<?= $Page->payment_number->headerCellClass() ?>"><?= $Page->payment_number->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->payment_number->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->payment_number->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->payment_number->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->payment_number->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->payment_number->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <?php if ($Page->SortUrl($Page->status) == "") { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><?= $Page->status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->status->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status->getSortIcon() ?></span>
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
<?php if ($Page->payment->Visible) { // payment ?>
        <!-- payment -->
        <td<?= $Page->payment->cellAttributes() ?>>
<span<?= $Page->payment->viewAttributes() ?>>
<?= $Page->payment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->payment_number->Visible) { // payment_number ?>
        <!-- payment_number -->
        <td<?= $Page->payment_number->cellAttributes() ?>>
<span<?= $Page->payment_number->viewAttributes() ?>>
<?= $Page->payment_number->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
