<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PlanLoanPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { plan_loan: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid plan_loan"><!-- .card -->
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
<?php if ($Page->date->Visible) { // date ?>
    <?php if ($Page->SortUrl($Page->date) == "") { ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><?= $Page->date->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->date->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->date->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->date->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->date->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
    <?php if ($Page->SortUrl($Page->time) == "") { ?>
        <th class="<?= $Page->time->headerCellClass() ?>"><?= $Page->time->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->time->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->time->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->time->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->time->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->time->getSortIcon() ?></span>
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
<?php if ($Page->member_id->Visible) { // member_id ?>
        <!-- member_id -->
        <td<?= $Page->member_id->cellAttributes() ?>>
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <!-- date -->
        <td<?= $Page->date->cellAttributes() ?>>
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <!-- time -->
        <td<?= $Page->time->cellAttributes() ?>>
<span<?= $Page->time->viewAttributes() ?>>
<?= $Page->time->getViewValue() ?></span>
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
