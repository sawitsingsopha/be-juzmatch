<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvestorVerifyPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { investor_verify: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid investor_verify"><!-- .card -->
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
<?php if ($Page->investment->Visible) { // investment ?>
    <?php if ($Page->SortUrl($Page->investment) == "") { ?>
        <th class="<?= $Page->investment->headerCellClass() ?>"><?= $Page->investment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->investment->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->investment->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->investment->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->investment->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->investment->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->credit_limit->Visible) { // credit_limit ?>
    <?php if ($Page->SortUrl($Page->credit_limit) == "") { ?>
        <th class="<?= $Page->credit_limit->headerCellClass() ?>"><?= $Page->credit_limit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->credit_limit->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->credit_limit->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->credit_limit->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->credit_limit->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->credit_limit->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->monthly_payments->Visible) { // monthly_payments ?>
    <?php if ($Page->SortUrl($Page->monthly_payments) == "") { ?>
        <th class="<?= $Page->monthly_payments->headerCellClass() ?>"><?= $Page->monthly_payments->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->monthly_payments->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->monthly_payments->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->monthly_payments->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->monthly_payments->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->monthly_payments->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->highest_rental_price->Visible) { // highest_rental_price ?>
    <?php if ($Page->SortUrl($Page->highest_rental_price) == "") { ?>
        <th class="<?= $Page->highest_rental_price->headerCellClass() ?>"><?= $Page->highest_rental_price->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->highest_rental_price->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->highest_rental_price->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->highest_rental_price->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->highest_rental_price->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->highest_rental_price->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->transfer->Visible) { // transfer ?>
    <?php if ($Page->SortUrl($Page->transfer) == "") { ?>
        <th class="<?= $Page->transfer->headerCellClass() ?>"><?= $Page->transfer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->transfer->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->transfer->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->transfer->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->transfer->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->transfer->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->total_invertor_year->Visible) { // total_invertor_year ?>
    <?php if ($Page->SortUrl($Page->total_invertor_year) == "") { ?>
        <th class="<?= $Page->total_invertor_year->headerCellClass() ?>"><?= $Page->total_invertor_year->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->total_invertor_year->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->total_invertor_year->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->total_invertor_year->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->total_invertor_year->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->total_invertor_year->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->invert_payoff_day->Visible) { // invert_payoff_day ?>
    <?php if ($Page->SortUrl($Page->invert_payoff_day) == "") { ?>
        <th class="<?= $Page->invert_payoff_day->headerCellClass() ?>"><?= $Page->invert_payoff_day->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->invert_payoff_day->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->invert_payoff_day->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->invert_payoff_day->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->invert_payoff_day->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->invert_payoff_day->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->type_invertor->Visible) { // type_invertor ?>
    <?php if ($Page->SortUrl($Page->type_invertor) == "") { ?>
        <th class="<?= $Page->type_invertor->headerCellClass() ?>"><?= $Page->type_invertor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->type_invertor->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->type_invertor->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->type_invertor->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->type_invertor->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->type_invertor->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->invest_amount->Visible) { // invest_amount ?>
    <?php if ($Page->SortUrl($Page->invest_amount) == "") { ?>
        <th class="<?= $Page->invest_amount->headerCellClass() ?>"><?= $Page->invest_amount->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->invest_amount->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->invest_amount->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->invest_amount->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->invest_amount->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->invest_amount->getSortIcon() ?></span>
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
<?php if ($Page->investment->Visible) { // investment ?>
        <!-- investment -->
        <td<?= $Page->investment->cellAttributes() ?>>
<span<?= $Page->investment->viewAttributes() ?>>
<?= $Page->investment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->credit_limit->Visible) { // credit_limit ?>
        <!-- credit_limit -->
        <td<?= $Page->credit_limit->cellAttributes() ?>>
<span<?= $Page->credit_limit->viewAttributes() ?>>
<?= $Page->credit_limit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->monthly_payments->Visible) { // monthly_payments ?>
        <!-- monthly_payments -->
        <td<?= $Page->monthly_payments->cellAttributes() ?>>
<span<?= $Page->monthly_payments->viewAttributes() ?>>
<?= $Page->monthly_payments->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->highest_rental_price->Visible) { // highest_rental_price ?>
        <!-- highest_rental_price -->
        <td<?= $Page->highest_rental_price->cellAttributes() ?>>
<span<?= $Page->highest_rental_price->viewAttributes() ?>>
<?= $Page->highest_rental_price->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->transfer->Visible) { // transfer ?>
        <!-- transfer -->
        <td<?= $Page->transfer->cellAttributes() ?>>
<span<?= $Page->transfer->viewAttributes() ?>>
<?= $Page->transfer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->total_invertor_year->Visible) { // total_invertor_year ?>
        <!-- total_invertor_year -->
        <td<?= $Page->total_invertor_year->cellAttributes() ?>>
<span<?= $Page->total_invertor_year->viewAttributes() ?>>
<?= $Page->total_invertor_year->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->invert_payoff_day->Visible) { // invert_payoff_day ?>
        <!-- invert_payoff_day -->
        <td<?= $Page->invert_payoff_day->cellAttributes() ?>>
<span<?= $Page->invert_payoff_day->viewAttributes() ?>>
<?= $Page->invert_payoff_day->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->type_invertor->Visible) { // type_invertor ?>
        <!-- type_invertor -->
        <td<?= $Page->type_invertor->cellAttributes() ?>>
<span<?= $Page->type_invertor->viewAttributes() ?>>
<?= $Page->type_invertor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->invest_amount->Visible) { // invest_amount ?>
        <!-- invest_amount -->
        <td<?= $Page->invest_amount->cellAttributes() ?>>
<span<?= $Page->invest_amount->viewAttributes() ?>>
<?= $Page->invest_amount->getViewValue() ?></span>
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
