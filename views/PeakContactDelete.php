<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakContactDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_contact: currentTable } });
var currentForm, currentPageID;
var fpeak_contactdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_contactdelete = new ew.Form("fpeak_contactdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpeak_contactdelete;
    loadjs.done("fpeak_contactdelete");
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
<form name="fpeak_contactdelete" id="fpeak_contactdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_contact">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_peak_contact_id" class="peak_contact_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th class="<?= $Page->create_date->headerCellClass() ?>"><span id="elh_peak_contact_create_date" class="peak_contact_create_date"><?= $Page->create_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
        <th class="<?= $Page->request_status->headerCellClass() ?>"><span id="elh_peak_contact_request_status" class="peak_contact_request_status"><?= $Page->request_status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
        <th class="<?= $Page->request_date->headerCellClass() ?>"><span id="elh_peak_contact_request_date" class="peak_contact_request_date"><?= $Page->request_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_id->Visible) { // contact_id ?>
        <th class="<?= $Page->contact_id->headerCellClass() ?>"><span id="elh_peak_contact_contact_id" class="peak_contact_contact_id"><?= $Page->contact_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_code->Visible) { // contact_code ?>
        <th class="<?= $Page->contact_code->headerCellClass() ?>"><span id="elh_peak_contact_contact_code" class="peak_contact_contact_code"><?= $Page->contact_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
        <th class="<?= $Page->contact_name->headerCellClass() ?>"><span id="elh_peak_contact_contact_name" class="peak_contact_contact_name"><?= $Page->contact_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_type->Visible) { // contact_type ?>
        <th class="<?= $Page->contact_type->headerCellClass() ?>"><span id="elh_peak_contact_contact_type" class="peak_contact_contact_type"><?= $Page->contact_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_taxnumber->Visible) { // contact_taxnumber ?>
        <th class="<?= $Page->contact_taxnumber->headerCellClass() ?>"><span id="elh_peak_contact_contact_taxnumber" class="peak_contact_contact_taxnumber"><?= $Page->contact_taxnumber->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_branchcode->Visible) { // contact_branchcode ?>
        <th class="<?= $Page->contact_branchcode->headerCellClass() ?>"><span id="elh_peak_contact_contact_branchcode" class="peak_contact_contact_branchcode"><?= $Page->contact_branchcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <th class="<?= $Page->contact_address->headerCellClass() ?>"><span id="elh_peak_contact_contact_address" class="peak_contact_contact_address"><?= $Page->contact_address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_subdistrict->Visible) { // contact_subdistrict ?>
        <th class="<?= $Page->contact_subdistrict->headerCellClass() ?>"><span id="elh_peak_contact_contact_subdistrict" class="peak_contact_contact_subdistrict"><?= $Page->contact_subdistrict->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_district->Visible) { // contact_district ?>
        <th class="<?= $Page->contact_district->headerCellClass() ?>"><span id="elh_peak_contact_contact_district" class="peak_contact_contact_district"><?= $Page->contact_district->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_province->Visible) { // contact_province ?>
        <th class="<?= $Page->contact_province->headerCellClass() ?>"><span id="elh_peak_contact_contact_province" class="peak_contact_contact_province"><?= $Page->contact_province->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_country->Visible) { // contact_country ?>
        <th class="<?= $Page->contact_country->headerCellClass() ?>"><span id="elh_peak_contact_contact_country" class="peak_contact_contact_country"><?= $Page->contact_country->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_postcode->Visible) { // contact_postcode ?>
        <th class="<?= $Page->contact_postcode->headerCellClass() ?>"><span id="elh_peak_contact_contact_postcode" class="peak_contact_contact_postcode"><?= $Page->contact_postcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_callcenternumber->Visible) { // contact_callcenternumber ?>
        <th class="<?= $Page->contact_callcenternumber->headerCellClass() ?>"><span id="elh_peak_contact_contact_callcenternumber" class="peak_contact_contact_callcenternumber"><?= $Page->contact_callcenternumber->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_faxnumber->Visible) { // contact_faxnumber ?>
        <th class="<?= $Page->contact_faxnumber->headerCellClass() ?>"><span id="elh_peak_contact_contact_faxnumber" class="peak_contact_contact_faxnumber"><?= $Page->contact_faxnumber->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <th class="<?= $Page->contact_email->headerCellClass() ?>"><span id="elh_peak_contact_contact_email" class="peak_contact_contact_email"><?= $Page->contact_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_website->Visible) { // contact_website ?>
        <th class="<?= $Page->contact_website->headerCellClass() ?>"><span id="elh_peak_contact_contact_website" class="peak_contact_contact_website"><?= $Page->contact_website->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_contactfirstname->Visible) { // contact_contactfirstname ?>
        <th class="<?= $Page->contact_contactfirstname->headerCellClass() ?>"><span id="elh_peak_contact_contact_contactfirstname" class="peak_contact_contact_contactfirstname"><?= $Page->contact_contactfirstname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_contactlastname->Visible) { // contact_contactlastname ?>
        <th class="<?= $Page->contact_contactlastname->headerCellClass() ?>"><span id="elh_peak_contact_contact_contactlastname" class="peak_contact_contact_contactlastname"><?= $Page->contact_contactlastname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_contactnickname->Visible) { // contact_contactnickname ?>
        <th class="<?= $Page->contact_contactnickname->headerCellClass() ?>"><span id="elh_peak_contact_contact_contactnickname" class="peak_contact_contact_contactnickname"><?= $Page->contact_contactnickname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_contactpostition->Visible) { // contact_contactpostition ?>
        <th class="<?= $Page->contact_contactpostition->headerCellClass() ?>"><span id="elh_peak_contact_contact_contactpostition" class="peak_contact_contact_contactpostition"><?= $Page->contact_contactpostition->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_contactphonenumber->Visible) { // contact_contactphonenumber ?>
        <th class="<?= $Page->contact_contactphonenumber->headerCellClass() ?>"><span id="elh_peak_contact_contact_contactphonenumber" class="peak_contact_contact_contactphonenumber"><?= $Page->contact_contactphonenumber->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_contactcontactemail->Visible) { // contact_contactcontactemail ?>
        <th class="<?= $Page->contact_contactcontactemail->headerCellClass() ?>"><span id="elh_peak_contact_contact_contactcontactemail" class="peak_contact_contact_contactcontactemail"><?= $Page->contact_contactcontactemail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_purchaseaccount->Visible) { // contact_purchaseaccount ?>
        <th class="<?= $Page->contact_purchaseaccount->headerCellClass() ?>"><span id="elh_peak_contact_contact_purchaseaccount" class="peak_contact_contact_purchaseaccount"><?= $Page->contact_purchaseaccount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_sellaccount->Visible) { // contact_sellaccount ?>
        <th class="<?= $Page->contact_sellaccount->headerCellClass() ?>"><span id="elh_peak_contact_contact_sellaccount" class="peak_contact_contact_sellaccount"><?= $Page->contact_sellaccount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <th class="<?= $Page->member_id->headerCellClass() ?>"><span id="elh_peak_contact_member_id" class="peak_contact_member_id"><?= $Page->member_id->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_id" class="el_peak_contact_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <td<?= $Page->create_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_create_date" class="el_peak_contact_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
        <td<?= $Page->request_status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_request_status" class="el_peak_contact_request_status">
<span<?= $Page->request_status->viewAttributes() ?>>
<?= $Page->request_status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
        <td<?= $Page->request_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_request_date" class="el_peak_contact_request_date">
<span<?= $Page->request_date->viewAttributes() ?>>
<?= $Page->request_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_id->Visible) { // contact_id ?>
        <td<?= $Page->contact_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_id" class="el_peak_contact_contact_id">
<span<?= $Page->contact_id->viewAttributes() ?>>
<?= $Page->contact_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_code->Visible) { // contact_code ?>
        <td<?= $Page->contact_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_code" class="el_peak_contact_contact_code">
<span<?= $Page->contact_code->viewAttributes() ?>>
<?= $Page->contact_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
        <td<?= $Page->contact_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_name" class="el_peak_contact_contact_name">
<span<?= $Page->contact_name->viewAttributes() ?>>
<?= $Page->contact_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_type->Visible) { // contact_type ?>
        <td<?= $Page->contact_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_type" class="el_peak_contact_contact_type">
<span<?= $Page->contact_type->viewAttributes() ?>>
<?= $Page->contact_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_taxnumber->Visible) { // contact_taxnumber ?>
        <td<?= $Page->contact_taxnumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_taxnumber" class="el_peak_contact_contact_taxnumber">
<span<?= $Page->contact_taxnumber->viewAttributes() ?>>
<?= $Page->contact_taxnumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_branchcode->Visible) { // contact_branchcode ?>
        <td<?= $Page->contact_branchcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_branchcode" class="el_peak_contact_contact_branchcode">
<span<?= $Page->contact_branchcode->viewAttributes() ?>>
<?= $Page->contact_branchcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
        <td<?= $Page->contact_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_address" class="el_peak_contact_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_subdistrict->Visible) { // contact_subdistrict ?>
        <td<?= $Page->contact_subdistrict->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_subdistrict" class="el_peak_contact_contact_subdistrict">
<span<?= $Page->contact_subdistrict->viewAttributes() ?>>
<?= $Page->contact_subdistrict->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_district->Visible) { // contact_district ?>
        <td<?= $Page->contact_district->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_district" class="el_peak_contact_contact_district">
<span<?= $Page->contact_district->viewAttributes() ?>>
<?= $Page->contact_district->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_province->Visible) { // contact_province ?>
        <td<?= $Page->contact_province->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_province" class="el_peak_contact_contact_province">
<span<?= $Page->contact_province->viewAttributes() ?>>
<?= $Page->contact_province->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_country->Visible) { // contact_country ?>
        <td<?= $Page->contact_country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_country" class="el_peak_contact_contact_country">
<span<?= $Page->contact_country->viewAttributes() ?>>
<?= $Page->contact_country->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_postcode->Visible) { // contact_postcode ?>
        <td<?= $Page->contact_postcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_postcode" class="el_peak_contact_contact_postcode">
<span<?= $Page->contact_postcode->viewAttributes() ?>>
<?= $Page->contact_postcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_callcenternumber->Visible) { // contact_callcenternumber ?>
        <td<?= $Page->contact_callcenternumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_callcenternumber" class="el_peak_contact_contact_callcenternumber">
<span<?= $Page->contact_callcenternumber->viewAttributes() ?>>
<?= $Page->contact_callcenternumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_faxnumber->Visible) { // contact_faxnumber ?>
        <td<?= $Page->contact_faxnumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_faxnumber" class="el_peak_contact_contact_faxnumber">
<span<?= $Page->contact_faxnumber->viewAttributes() ?>>
<?= $Page->contact_faxnumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
        <td<?= $Page->contact_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_email" class="el_peak_contact_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_website->Visible) { // contact_website ?>
        <td<?= $Page->contact_website->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_website" class="el_peak_contact_contact_website">
<span<?= $Page->contact_website->viewAttributes() ?>>
<?= $Page->contact_website->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_contactfirstname->Visible) { // contact_contactfirstname ?>
        <td<?= $Page->contact_contactfirstname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactfirstname" class="el_peak_contact_contact_contactfirstname">
<span<?= $Page->contact_contactfirstname->viewAttributes() ?>>
<?= $Page->contact_contactfirstname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_contactlastname->Visible) { // contact_contactlastname ?>
        <td<?= $Page->contact_contactlastname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactlastname" class="el_peak_contact_contact_contactlastname">
<span<?= $Page->contact_contactlastname->viewAttributes() ?>>
<?= $Page->contact_contactlastname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_contactnickname->Visible) { // contact_contactnickname ?>
        <td<?= $Page->contact_contactnickname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactnickname" class="el_peak_contact_contact_contactnickname">
<span<?= $Page->contact_contactnickname->viewAttributes() ?>>
<?= $Page->contact_contactnickname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_contactpostition->Visible) { // contact_contactpostition ?>
        <td<?= $Page->contact_contactpostition->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactpostition" class="el_peak_contact_contact_contactpostition">
<span<?= $Page->contact_contactpostition->viewAttributes() ?>>
<?= $Page->contact_contactpostition->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_contactphonenumber->Visible) { // contact_contactphonenumber ?>
        <td<?= $Page->contact_contactphonenumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactphonenumber" class="el_peak_contact_contact_contactphonenumber">
<span<?= $Page->contact_contactphonenumber->viewAttributes() ?>>
<?= $Page->contact_contactphonenumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_contactcontactemail->Visible) { // contact_contactcontactemail ?>
        <td<?= $Page->contact_contactcontactemail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_contactcontactemail" class="el_peak_contact_contact_contactcontactemail">
<span<?= $Page->contact_contactcontactemail->viewAttributes() ?>>
<?= $Page->contact_contactcontactemail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_purchaseaccount->Visible) { // contact_purchaseaccount ?>
        <td<?= $Page->contact_purchaseaccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_purchaseaccount" class="el_peak_contact_contact_purchaseaccount">
<span<?= $Page->contact_purchaseaccount->viewAttributes() ?>>
<?= $Page->contact_purchaseaccount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_sellaccount->Visible) { // contact_sellaccount ?>
        <td<?= $Page->contact_sellaccount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_contact_sellaccount" class="el_peak_contact_contact_sellaccount">
<span<?= $Page->contact_sellaccount->viewAttributes() ?>>
<?= $Page->contact_sellaccount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
        <td<?= $Page->member_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_peak_contact_member_id" class="el_peak_contact_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
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
