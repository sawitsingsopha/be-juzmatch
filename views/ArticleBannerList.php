<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleBannerList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article_banner: currentTable } });
var currentForm, currentPageID;
var farticle_bannerlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticle_bannerlist = new ew.Form("farticle_bannerlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = farticle_bannerlist;
    farticle_bannerlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("farticle_bannerlist");
});
var farticle_bannersrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    farticle_bannersrch = new ew.Form("farticle_bannersrch", "list");
    currentSearchForm = farticle_bannersrch;

    // Add fields
    var fields = currentTable.fields;
    farticle_bannersrch.addFields([
        ["article_title", [], fields.article_title.isInvalid],
        ["image", [], fields.image.isInvalid],
        ["order_by", [], fields.order_by.isInvalid],
        ["active_status", [], fields.active_status.isInvalid],
        ["cdate", [], fields.cdate.isInvalid]
    ]);

    // Validate form
    farticle_bannersrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    farticle_bannersrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farticle_bannersrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    farticle_bannersrch.lists.active_status = <?= $Page->active_status->toClientList($Page) ?>;

    // Filters
    farticle_bannersrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farticle_bannersrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="farticle_bannersrch" id="farticle_bannersrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farticle_bannersrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="article_banner">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->article_title->Visible) { // article_title ?>
<?php
if (!$Page->article_title->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_article_title" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->article_title->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_article_title" class="ew-search-caption ew-label"><?= $Page->article_title->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_article_title" id="z_article_title" value="LIKE">
</div>
        </div>
        <div id="el_article_banner_article_title" class="ew-search-field">
<input type="<?= $Page->article_title->getInputTextType() ?>" name="x_article_title" id="x_article_title" data-table="article_banner" data-field="x_article_title" value="<?= $Page->article_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->article_title->getPlaceHolder()) ?>"<?= $Page->article_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->article_title->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
<?php
if (!$Page->active_status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_active_status" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->active_status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->active_status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_active_status" id="z_active_status" value="=">
</div>
        </div>
        <div id="el_article_banner_active_status" class="ew-search-field">
<template id="tp_x_active_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="article_banner" data-field="x_active_status" name="x_active_status" id="x_active_status"<?= $Page->active_status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_active_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_active_status"
    name="x_active_status"
    value="<?= HtmlEncode($Page->active_status->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_active_status"
    data-bs-target="dsl_x_active_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->active_status->isInvalidClass() ?>"
    data-table="article_banner"
    data-field="x_active_status"
    data-value-separator="<?= $Page->active_status->displayValueSeparatorAttribute() ?>"
    <?= $Page->active_status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->active_status->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> article_banner">
<form name="farticle_bannerlist" id="farticle_bannerlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article_banner">
<div id="gmp_article_banner" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_article_bannerlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->article_title->Visible) { // article_title ?>
        <th data-name="article_title" class="<?= $Page->article_title->headerCellClass() ?>"><div id="elh_article_banner_article_title" class="article_banner_article_title"><?= $Page->renderFieldHeader($Page->article_title) ?></div></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Page->image->headerCellClass() ?>"><div id="elh_article_banner_image" class="article_banner_image"><?= $Page->renderFieldHeader($Page->image) ?></div></th>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <th data-name="order_by" class="<?= $Page->order_by->headerCellClass() ?>"><div id="elh_article_banner_order_by" class="article_banner_order_by"><?= $Page->renderFieldHeader($Page->order_by) ?></div></th>
<?php } ?>
<?php if ($Page->active_status->Visible) { // active_status ?>
        <th data-name="active_status" class="<?= $Page->active_status->headerCellClass() ?>"><div id="elh_article_banner_active_status" class="article_banner_active_status"><?= $Page->renderFieldHeader($Page->active_status) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_article_banner_cdate" class="article_banner_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_article_banner",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->article_title->Visible) { // article_title ?>
        <td data-name="article_title"<?= $Page->article_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_banner_article_title" class="el_article_banner_article_title">
<span<?= $Page->article_title->viewAttributes() ?>>
<?= $Page->article_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->image->Visible) { // image ?>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_banner_image" class="el_article_banner_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->order_by->Visible) { // order_by ?>
        <td data-name="order_by"<?= $Page->order_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_banner_order_by" class="el_article_banner_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->active_status->Visible) { // active_status ?>
        <td data-name="active_status"<?= $Page->active_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_banner_active_status" class="el_article_banner_active_status">
<span<?= $Page->active_status->viewAttributes() ?>>
<?= $Page->active_status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_banner_cdate" class="el_article_banner_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_article_banner",
        width: "100%",
        height: "500px"
    });
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("article_banner");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
