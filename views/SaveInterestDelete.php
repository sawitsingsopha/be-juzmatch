<?php

namespace PHPMaker2022\juzmatch;

// Page object
$SaveInterestDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { save_interest: currentTable } });
var currentForm, currentPageID;
var fsave_interestdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsave_interestdelete = new ew.Form("fsave_interestdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fsave_interestdelete;
    loadjs.done("fsave_interestdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsave_interestdelete" id="fsave_interestdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="save_interest">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->_title->Visible) { // title ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><span id="elh_save_interest__title" class="save_interest__title"><?= $Page->_title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
        <th class="<?= $Page->lat->headerCellClass() ?>"><span id="elh_save_interest_lat" class="save_interest_lat"><?= $Page->lat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lng->Visible) { // lng ?>
        <th class="<?= $Page->lng->headerCellClass() ?>"><span id="elh_save_interest_lng" class="save_interest_lng"><?= $Page->lng->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
        <th class="<?= $Page->rating->headerCellClass() ?>"><span id="elh_save_interest_rating" class="save_interest_rating"><?= $Page->rating->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <th class="<?= $Page->cdate->headerCellClass() ?>"><span id="elh_save_interest_cdate" class="save_interest_cdate"><?= $Page->cdate->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->_title->Visible) { // title ?>
        <td<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_interest__title" class="el_save_interest__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
        <td<?= $Page->lat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_interest_lat" class="el_save_interest_lat">
<span<?= $Page->lat->viewAttributes() ?>>
<?= $Page->lat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lng->Visible) { // lng ?>
        <td<?= $Page->lng->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_interest_lng" class="el_save_interest_lng">
<span<?= $Page->lng->viewAttributes() ?>>
<?= $Page->lng->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
        <td<?= $Page->rating->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_interest_rating" class="el_save_interest_rating">
<span<?= $Page->rating->viewAttributes() ?>>
<?= $Page->rating->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
        <td<?= $Page->cdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_save_interest_cdate" class="el_save_interest_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
