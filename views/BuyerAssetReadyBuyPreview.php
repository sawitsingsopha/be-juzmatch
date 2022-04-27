<?php

namespace PHPMaker2022\juzmatch;

// Page object
$BuyerAssetReadyBuyPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { buyer_asset_ready_buy: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid buyer_asset_ready_buy"><!-- .card -->
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
<?php if ($Page->price_payment->Visible) { // price_payment ?>
    <?php if ($Page->SortUrl($Page->price_payment) == "") { ?>
        <th class="<?= $Page->price_payment->headerCellClass() ?>"><?= $Page->price_payment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->price_payment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->price_payment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->price_payment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->price_payment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->price_payment->getSortIcon() ?></span>
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
<?php if ($Page->duedate->Visible) { // due date ?>
    <?php if ($Page->SortUrl($Page->duedate) == "") { ?>
        <th class="<?= $Page->duedate->headerCellClass() ?>"><?= $Page->duedate->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->duedate->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->duedate->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->duedate->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->duedate->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->duedate->getSortIcon() ?></span>
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
<?php if ($Page->price_payment->Visible) { // price_payment ?>
        <!-- price_payment -->
        <td<?= $Page->price_payment->cellAttributes() ?>>
<span<?= $Page->price_payment->viewAttributes() ?>>
<?= $Page->price_payment->getViewValue() ?></span>
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
<?php if ($Page->date_payment->Visible) { // date_payment ?>
        <!-- date_payment -->
        <td<?= $Page->date_payment->cellAttributes() ?>>
<span<?= $Page->date_payment->viewAttributes() ?>>
<?= $Page->date_payment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->duedate->Visible) { // due date ?>
        <!-- due date -->
        <td<?= $Page->duedate->cellAttributes() ?>>
<span<?= $Page->duedate->viewAttributes() ?>>
<?= $Page->duedate->getViewValue() ?></span>
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
