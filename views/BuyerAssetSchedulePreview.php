<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetSchedulePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { buyer_asset_schedule: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid buyer_asset_schedule"><!-- .card -->
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
<?php if ($Page->num_installment->Visible) { // num_installment ?>
    <?php if ($Page->SortUrl($Page->num_installment) == "") { ?>
        <th class="<?= $Page->num_installment->headerCellClass() ?>"><?= $Page->num_installment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->num_installment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->num_installment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->num_installment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->num_installment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->num_installment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
    <?php if ($Page->SortUrl($Page->installment_per_price) == "") { ?>
        <th class="<?= $Page->installment_per_price->headerCellClass() ?>"><?= $Page->installment_per_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->installment_per_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->installment_per_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->installment_per_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->installment_per_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->installment_per_price->getSortIcon() ?></span>
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
<?php if ($Page->expired_date->Visible) { // expired_date ?>
    <?php if ($Page->SortUrl($Page->expired_date) == "") { ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><?= $Page->expired_date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->expired_date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->expired_date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->expired_date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->expired_date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->expired_date->getSortIcon() ?></span>
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
<?php if ($Page->num_installment->Visible) { // num_installment ?>
        <!-- num_installment -->
        <td<?= $Page->num_installment->cellAttributes() ?>>
<span<?= $Page->num_installment->viewAttributes() ?>>
<?= $Page->num_installment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->installment_per_price->Visible) { // installment_per_price ?>
        <!-- installment_per_price -->
        <td<?= $Page->installment_per_price->cellAttributes() ?>>
<span<?= $Page->installment_per_price->viewAttributes() ?>>
<?= $Page->installment_per_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pay_number->Visible) { // pay_number ?>
        <!-- pay_number -->
        <td<?= $Page->pay_number->cellAttributes() ?>>
<span<?= $Page->pay_number->viewAttributes() ?>>
<?= $Page->pay_number->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
        <!-- expired_date -->
        <td<?= $Page->expired_date->cellAttributes() ?>>
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <!-- date_payment -->
        <td<?= $Page->date_payment->cellAttributes() ?>>
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_payment->Visible) { // status_payment ?>
        <!-- status_payment -->
        <td<?= $Page->status_payment->cellAttributes() ?>>
<span<?= $Page->status_payment->viewAttributes() ?>>
<?= $Page->status_payment->getViewValue() ?></span>
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
