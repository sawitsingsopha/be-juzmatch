<?php

namespace PHPMaker2022\juzmatch;

// Page object
$InvestorList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { investor: currentTable } });
var currentForm, currentPageID;
var finvestorlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    finvestorlist = new ew.Form("finvestorlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = finvestorlist;
    finvestorlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("finvestorlist");
});
var finvestorsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    finvestorsrch = new ew.Form("finvestorsrch", "list");
    currentSearchForm = finvestorsrch;

    // Add fields
    var fields = currentTable.fields;
    finvestorsrch.addFields([
        ["first_name", [], fields.first_name.isInvalid],
        ["last_name", [], fields.last_name.isInvalid],
        ["idcardnumber", [], fields.idcardnumber.isInvalid],
        ["_email", [], fields._email.isInvalid],
        ["phone", [], fields.phone.isInvalid]
    ]);

    // Validate form
    finvestorsrch.validate = function () {
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
    finvestorsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvestorsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists

    // Filters
    finvestorsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("finvestorsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if ($Security->canImport()) { ?>
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
<?php } ?>

<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="finvestorsrch" id="finvestorsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="finvestorsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="investor">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->first_name->Visible) { // first_name ?>
<?php
if (!$Page->first_name->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_first_name" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->first_name->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_first_name" class="ew-search-caption ew-label"><?= $Page->first_name->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_first_name" id="z_first_name" value="LIKE">
</div>
        </div>
        <div id="el_investor_first_name" class="ew-search-field">
<input type="<?= $Page->first_name->getInputTextType() ?>" name="x_first_name" id="x_first_name" data-table="investor" data-field="x_first_name" value="<?= $Page->first_name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->first_name->getPlaceHolder()) ?>"<?= $Page->first_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->first_name->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
<?php
if (!$Page->last_name->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_last_name" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->last_name->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_last_name" class="ew-search-caption ew-label"><?= $Page->last_name->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_last_name" id="z_last_name" value="LIKE">
</div>
        </div>
        <div id="el_investor_last_name" class="ew-search-field">
<input type="<?= $Page->last_name->getInputTextType() ?>" name="x_last_name" id="x_last_name" data-table="investor" data-field="x_last_name" value="<?= $Page->last_name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->last_name->getPlaceHolder()) ?>"<?= $Page->last_name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->last_name->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->idcardnumber->Visible) { // idcardnumber ?>
<?php
if (!$Page->idcardnumber->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idcardnumber" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->idcardnumber->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_idcardnumber" class="ew-search-caption ew-label"><?= $Page->idcardnumber->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_idcardnumber" id="z_idcardnumber" value="LIKE">
</div>
        </div>
        <div id="el_investor_idcardnumber" class="ew-search-field">
<input type="<?= $Page->idcardnumber->getInputTextType() ?>" name="x_idcardnumber" id="x_idcardnumber" data-table="investor" data-field="x_idcardnumber" value="<?= $Page->idcardnumber->EditValue ?>" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->idcardnumber->getPlaceHolder()) ?>"<?= $Page->idcardnumber->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idcardnumber->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
<?php
if (!$Page->_email->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs__email" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->_email->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x__email" class="ew-search-caption ew-label"><?= $Page->_email->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__email" id="z__email" value="LIKE">
</div>
        </div>
        <div id="el_investor__email" class="ew-search-field">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="investor" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
<?php
if (!$Page->phone->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_phone" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->phone->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_phone" class="ew-search-caption ew-label"><?= $Page->phone->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_phone" id="z_phone" value="LIKE">
</div>
        </div>
        <div id="el_investor_phone" class="ew-search-field">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="investor" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>"<?= $Page->phone->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage(false) ?></div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> investor">
<form name="finvestorlist" id="finvestorlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="investor">
<div id="gmp_investor" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_investorlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->first_name->Visible) { // first_name ?>
        <th data-name="first_name" class="<?= $Page->first_name->headerCellClass() ?>"><div id="elh_investor_first_name" class="investor_first_name"><?= $Page->renderFieldHeader($Page->first_name) ?></div></th>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
        <th data-name="last_name" class="<?= $Page->last_name->headerCellClass() ?>"><div id="elh_investor_last_name" class="investor_last_name"><?= $Page->renderFieldHeader($Page->last_name) ?></div></th>
<?php } ?>
<?php if ($Page->idcardnumber->Visible) { // idcardnumber ?>
        <th data-name="idcardnumber" class="<?= $Page->idcardnumber->headerCellClass() ?>"><div id="elh_investor_idcardnumber" class="investor_idcardnumber"><?= $Page->renderFieldHeader($Page->idcardnumber) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_investor__email" class="investor__email"><?= $Page->renderFieldHeader($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
        <th data-name="phone" class="<?= $Page->phone->headerCellClass() ?>"><div id="elh_investor_phone" class="investor_phone"><?= $Page->renderFieldHeader($Page->phone) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_investor",
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
    <?php if ($Page->first_name->Visible) { // first_name ?>
        <td data-name="first_name"<?= $Page->first_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_first_name" class="el_investor_first_name">
<span<?= $Page->first_name->viewAttributes() ?>>
<?= $Page->first_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->last_name->Visible) { // last_name ?>
        <td data-name="last_name"<?= $Page->last_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_last_name" class="el_investor_last_name">
<span<?= $Page->last_name->viewAttributes() ?>>
<?= $Page->last_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcardnumber->Visible) { // idcardnumber ?>
        <td data-name="idcardnumber"<?= $Page->idcardnumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_idcardnumber" class="el_investor_idcardnumber">
<span<?= $Page->idcardnumber->viewAttributes() ?>>
<?= $Page->idcardnumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor__email" class="el_investor__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->phone->Visible) { // phone ?>
        <td data-name="phone"<?= $Page->phone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_investor_phone" class="el_investor_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
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
        container: "gmp_investor",
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
    ew.addEventHandlers("investor");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
