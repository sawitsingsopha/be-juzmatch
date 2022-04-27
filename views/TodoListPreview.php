<?php

namespace PHPMaker2022\juzmatch;

// Page object
$TodoListPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { todo_list: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid todo_list"><!-- .card -->
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
<?php if ($Page->_title->Visible) { // title ?>
    <?php if ($Page->SortUrl($Page->_title) == "") { ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><?= $Page->_title->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->_title->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->_title->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_title->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_title->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <?php if ($Page->SortUrl($Page->detail) == "") { ?>
        <th class="<?= $Page->detail->headerCellClass() ?>"><?= $Page->detail->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->detail->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->detail->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->detail->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->detail->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->detail->getSortIcon() ?></span>
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
<?php if ($Page->order_by->Visible) { // order_by ?>
    <?php if ($Page->SortUrl($Page->order_by) == "") { ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><?= $Page->order_by->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->order_by->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->order_by->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->order_by->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->order_by->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->order_by->getSortIcon() ?></span>
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
<?php if ($Page->_title->Visible) { // title ?>
        <!-- title -->
        <td<?= $Page->_title->cellAttributes() ?>>
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
        <!-- detail -->
        <td<?= $Page->detail->cellAttributes() ?>>
<span<?= $Page->detail->viewAttributes() ?>>
<?= $Page->detail->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <!-- order_by -->
        <td<?= $Page->order_by->cellAttributes() ?>>
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
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
