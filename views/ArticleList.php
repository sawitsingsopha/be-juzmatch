<?php

namespace PHPMaker2022\juzmatch;

// Page object
$ArticleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { article: currentTable } });
var currentForm, currentPageID;
var farticlelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    farticlelist = new ew.Form("farticlelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = farticlelist;
    farticlelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("farticlelist");
});
var farticlesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    farticlesrch = new ew.Form("farticlesrch", "list");
    currentSearchForm = farticlesrch;

    // Add fields
    var fields = currentTable.fields;
    farticlesrch.addFields([
        ["article_category_id", [], fields.article_category_id.isInvalid],
        ["_title", [], fields._title.isInvalid],
        ["image", [], fields.image.isInvalid],
        ["order_by", [], fields.order_by.isInvalid],
        ["highlight", [], fields.highlight.isInvalid],
        ["cdate", [], fields.cdate.isInvalid]
    ]);

    // Validate form
    farticlesrch.validate = function () {
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
    farticlesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farticlesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    farticlesrch.lists.article_category_id = <?= $Page->article_category_id->toClientList($Page) ?>;
    farticlesrch.lists.highlight = <?= $Page->highlight->toClientList($Page) ?>;

    // Filters
    farticlesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farticlesrch");
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
<form name="farticlesrch" id="farticlesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farticlesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="article">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->article_category_id->Visible) { // article_category_id ?>
<?php
if (!$Page->article_category_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_article_category_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->article_category_id->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_article_category_id" class="ew-search-caption ew-label"><?= $Page->article_category_id->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_article_category_id" id="z_article_category_id" value="=">
</div>
        </div>
        <div id="el_article_article_category_id" class="ew-search-field">
    <select
        id="x_article_category_id"
        name="x_article_category_id"
        class="form-select ew-select<?= $Page->article_category_id->isInvalidClass() ?>"
        data-select2-id="farticlesrch_x_article_category_id"
        data-table="article"
        data-field="x_article_category_id"
        data-value-separator="<?= $Page->article_category_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->article_category_id->getPlaceHolder()) ?>"
        <?= $Page->article_category_id->editAttributes() ?>>
        <?= $Page->article_category_id->selectOptionListHtml("x_article_category_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->article_category_id->getErrorMessage(false) ?></div>
<?= $Page->article_category_id->Lookup->getParamTag($Page, "p_x_article_category_id") ?>
<script>
loadjs.ready("farticlesrch", function() {
    var options = { name: "x_article_category_id", selectId: "farticlesrch_x_article_category_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (farticlesrch.lists.article_category_id.lookupOptions.length) {
        options.data = { id: "x_article_category_id", form: "farticlesrch" };
    } else {
        options.ajax = { id: "x_article_category_id", form: "farticlesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.article.fields.article_category_id.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
<?php
if (!$Page->_title->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs__title" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->_title->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x__title" class="ew-search-caption ew-label"><?= $Page->_title->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__title" id="z__title" value="LIKE">
</div>
        </div>
        <div id="el_article__title" class="ew-search-field">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="article" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->highlight->Visible) { // highlight ?>
<?php
if (!$Page->highlight->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_highlight" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->highlight->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->highlight->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_highlight" id="z_highlight" value="=">
</div>
        </div>
        <div id="el_article_highlight" class="ew-search-field">
<template id="tp_x_highlight">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="article" data-field="x_highlight" name="x_highlight" id="x_highlight"<?= $Page->highlight->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_highlight" class="ew-item-list"></div>
<selection-list hidden
    id="x_highlight"
    name="x_highlight"
    value="<?= HtmlEncode($Page->highlight->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_highlight"
    data-bs-target="dsl_x_highlight"
    data-repeatcolumn="5"
    class="form-control<?= $Page->highlight->isInvalidClass() ?>"
    data-table="article"
    data-field="x_highlight"
    data-value-separator="<?= $Page->highlight->displayValueSeparatorAttribute() ?>"
    <?= $Page->highlight->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->highlight->getErrorMessage(false) ?></div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> article">
<form name="farticlelist" id="farticlelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="article">
<div id="gmp_article" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_articlelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->article_category_id->Visible) { // article_category_id ?>
        <th data-name="article_category_id" class="<?= $Page->article_category_id->headerCellClass() ?>"><div id="elh_article_article_category_id" class="article_article_category_id"><?= $Page->renderFieldHeader($Page->article_category_id) ?></div></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_article__title" class="article__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Page->image->headerCellClass() ?>"><div id="elh_article_image" class="article_image"><?= $Page->renderFieldHeader($Page->image) ?></div></th>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
        <th data-name="order_by" class="<?= $Page->order_by->headerCellClass() ?>"><div id="elh_article_order_by" class="article_order_by"><?= $Page->renderFieldHeader($Page->order_by) ?></div></th>
<?php } ?>
<?php if ($Page->highlight->Visible) { // highlight ?>
        <th data-name="highlight" class="<?= $Page->highlight->headerCellClass() ?>"><div id="elh_article_highlight" class="article_highlight"><?= $Page->renderFieldHeader($Page->highlight) ?></div></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th data-name="cdate" class="<?= $Page->cdate->headerCellClass() ?>"><div id="elh_article_cdate" class="article_cdate"><?= $Page->renderFieldHeader($Page->cdate) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_article",
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
    <?php if ($Page->article_category_id->Visible) { // article_category_id ?>
        <td data-name="article_category_id"<?= $Page->article_category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_article_category_id" class="el_article_article_category_id">
<span<?= $Page->article_category_id->viewAttributes() ?>>
<?= $Page->article_category_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article__title" class="el_article__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->image->Visible) { // image ?>
        <td data-name="image"<?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_image" class="el_article_image">
<span>
<?= GetFileViewTag($Page->image, $Page->image->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->order_by->Visible) { // order_by ?>
        <td data-name="order_by"<?= $Page->order_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_order_by" class="el_article_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->highlight->Visible) { // highlight ?>
        <td data-name="highlight"<?= $Page->highlight->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_highlight" class="el_article_highlight">
<span<?= $Page->highlight->viewAttributes() ?>>
<?= $Page->highlight->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cdate->Visible) { // cdate ?>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_article_cdate" class="el_article_cdate">
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
        container: "gmp_article",
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
    ew.addEventHandlers("article");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
