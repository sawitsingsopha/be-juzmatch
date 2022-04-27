<?php

namespace PHPMaker2022\juzmatch;

// Page object
$PeakContactView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { peak_contact: currentTable } });
var currentForm, currentPageID;
var fpeak_contactview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpeak_contactview = new ew.Form("fpeak_contactview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpeak_contactview;
    loadjs.done("fpeak_contactview");
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
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpeak_contactview" id="fpeak_contactview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="peak_contact">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_peak_contact_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
    <tr id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_create_date"><?= $Page->create_date->caption() ?></span></td>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el_peak_contact_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_status->Visible) { // request_status ?>
    <tr id="r_request_status"<?= $Page->request_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_request_status"><?= $Page->request_status->caption() ?></span></td>
        <td data-name="request_status"<?= $Page->request_status->cellAttributes() ?>>
<span id="el_peak_contact_request_status">
<span<?= $Page->request_status->viewAttributes() ?>>
<?= $Page->request_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_date->Visible) { // request_date ?>
    <tr id="r_request_date"<?= $Page->request_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_request_date"><?= $Page->request_date->caption() ?></span></td>
        <td data-name="request_date"<?= $Page->request_date->cellAttributes() ?>>
<span id="el_peak_contact_request_date">
<span<?= $Page->request_date->viewAttributes() ?>>
<?= $Page->request_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->request_message->Visible) { // request_message ?>
    <tr id="r_request_message"<?= $Page->request_message->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_request_message"><?= $Page->request_message->caption() ?></span></td>
        <td data-name="request_message"<?= $Page->request_message->cellAttributes() ?>>
<span id="el_peak_contact_request_message">
<span<?= $Page->request_message->viewAttributes() ?>>
<?= $Page->request_message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_id->Visible) { // contact_id ?>
    <tr id="r_contact_id"<?= $Page->contact_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_id"><?= $Page->contact_id->caption() ?></span></td>
        <td data-name="contact_id"<?= $Page->contact_id->cellAttributes() ?>>
<span id="el_peak_contact_contact_id">
<span<?= $Page->contact_id->viewAttributes() ?>>
<?= $Page->contact_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_code->Visible) { // contact_code ?>
    <tr id="r_contact_code"<?= $Page->contact_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_code"><?= $Page->contact_code->caption() ?></span></td>
        <td data-name="contact_code"<?= $Page->contact_code->cellAttributes() ?>>
<span id="el_peak_contact_contact_code">
<span<?= $Page->contact_code->viewAttributes() ?>>
<?= $Page->contact_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_name->Visible) { // contact_name ?>
    <tr id="r_contact_name"<?= $Page->contact_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_name"><?= $Page->contact_name->caption() ?></span></td>
        <td data-name="contact_name"<?= $Page->contact_name->cellAttributes() ?>>
<span id="el_peak_contact_contact_name">
<span<?= $Page->contact_name->viewAttributes() ?>>
<?= $Page->contact_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_type->Visible) { // contact_type ?>
    <tr id="r_contact_type"<?= $Page->contact_type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_type"><?= $Page->contact_type->caption() ?></span></td>
        <td data-name="contact_type"<?= $Page->contact_type->cellAttributes() ?>>
<span id="el_peak_contact_contact_type">
<span<?= $Page->contact_type->viewAttributes() ?>>
<?= $Page->contact_type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_taxnumber->Visible) { // contact_taxnumber ?>
    <tr id="r_contact_taxnumber"<?= $Page->contact_taxnumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_taxnumber"><?= $Page->contact_taxnumber->caption() ?></span></td>
        <td data-name="contact_taxnumber"<?= $Page->contact_taxnumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_taxnumber">
<span<?= $Page->contact_taxnumber->viewAttributes() ?>>
<?= $Page->contact_taxnumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_branchcode->Visible) { // contact_branchcode ?>
    <tr id="r_contact_branchcode"<?= $Page->contact_branchcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_branchcode"><?= $Page->contact_branchcode->caption() ?></span></td>
        <td data-name="contact_branchcode"<?= $Page->contact_branchcode->cellAttributes() ?>>
<span id="el_peak_contact_contact_branchcode">
<span<?= $Page->contact_branchcode->viewAttributes() ?>>
<?= $Page->contact_branchcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_address->Visible) { // contact_address ?>
    <tr id="r_contact_address"<?= $Page->contact_address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_address"><?= $Page->contact_address->caption() ?></span></td>
        <td data-name="contact_address"<?= $Page->contact_address->cellAttributes() ?>>
<span id="el_peak_contact_contact_address">
<span<?= $Page->contact_address->viewAttributes() ?>>
<?= $Page->contact_address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_subdistrict->Visible) { // contact_subdistrict ?>
    <tr id="r_contact_subdistrict"<?= $Page->contact_subdistrict->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_subdistrict"><?= $Page->contact_subdistrict->caption() ?></span></td>
        <td data-name="contact_subdistrict"<?= $Page->contact_subdistrict->cellAttributes() ?>>
<span id="el_peak_contact_contact_subdistrict">
<span<?= $Page->contact_subdistrict->viewAttributes() ?>>
<?= $Page->contact_subdistrict->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_district->Visible) { // contact_district ?>
    <tr id="r_contact_district"<?= $Page->contact_district->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_district"><?= $Page->contact_district->caption() ?></span></td>
        <td data-name="contact_district"<?= $Page->contact_district->cellAttributes() ?>>
<span id="el_peak_contact_contact_district">
<span<?= $Page->contact_district->viewAttributes() ?>>
<?= $Page->contact_district->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_province->Visible) { // contact_province ?>
    <tr id="r_contact_province"<?= $Page->contact_province->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_province"><?= $Page->contact_province->caption() ?></span></td>
        <td data-name="contact_province"<?= $Page->contact_province->cellAttributes() ?>>
<span id="el_peak_contact_contact_province">
<span<?= $Page->contact_province->viewAttributes() ?>>
<?= $Page->contact_province->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_country->Visible) { // contact_country ?>
    <tr id="r_contact_country"<?= $Page->contact_country->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_country"><?= $Page->contact_country->caption() ?></span></td>
        <td data-name="contact_country"<?= $Page->contact_country->cellAttributes() ?>>
<span id="el_peak_contact_contact_country">
<span<?= $Page->contact_country->viewAttributes() ?>>
<?= $Page->contact_country->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_postcode->Visible) { // contact_postcode ?>
    <tr id="r_contact_postcode"<?= $Page->contact_postcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_postcode"><?= $Page->contact_postcode->caption() ?></span></td>
        <td data-name="contact_postcode"<?= $Page->contact_postcode->cellAttributes() ?>>
<span id="el_peak_contact_contact_postcode">
<span<?= $Page->contact_postcode->viewAttributes() ?>>
<?= $Page->contact_postcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_callcenternumber->Visible) { // contact_callcenternumber ?>
    <tr id="r_contact_callcenternumber"<?= $Page->contact_callcenternumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_callcenternumber"><?= $Page->contact_callcenternumber->caption() ?></span></td>
        <td data-name="contact_callcenternumber"<?= $Page->contact_callcenternumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_callcenternumber">
<span<?= $Page->contact_callcenternumber->viewAttributes() ?>>
<?= $Page->contact_callcenternumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_faxnumber->Visible) { // contact_faxnumber ?>
    <tr id="r_contact_faxnumber"<?= $Page->contact_faxnumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_faxnumber"><?= $Page->contact_faxnumber->caption() ?></span></td>
        <td data-name="contact_faxnumber"<?= $Page->contact_faxnumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_faxnumber">
<span<?= $Page->contact_faxnumber->viewAttributes() ?>>
<?= $Page->contact_faxnumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_email->Visible) { // contact_email ?>
    <tr id="r_contact_email"<?= $Page->contact_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_email"><?= $Page->contact_email->caption() ?></span></td>
        <td data-name="contact_email"<?= $Page->contact_email->cellAttributes() ?>>
<span id="el_peak_contact_contact_email">
<span<?= $Page->contact_email->viewAttributes() ?>>
<?= $Page->contact_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_website->Visible) { // contact_website ?>
    <tr id="r_contact_website"<?= $Page->contact_website->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_website"><?= $Page->contact_website->caption() ?></span></td>
        <td data-name="contact_website"<?= $Page->contact_website->cellAttributes() ?>>
<span id="el_peak_contact_contact_website">
<span<?= $Page->contact_website->viewAttributes() ?>>
<?= $Page->contact_website->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_contactfirstname->Visible) { // contact_contactfirstname ?>
    <tr id="r_contact_contactfirstname"<?= $Page->contact_contactfirstname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_contactfirstname"><?= $Page->contact_contactfirstname->caption() ?></span></td>
        <td data-name="contact_contactfirstname"<?= $Page->contact_contactfirstname->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactfirstname">
<span<?= $Page->contact_contactfirstname->viewAttributes() ?>>
<?= $Page->contact_contactfirstname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_contactlastname->Visible) { // contact_contactlastname ?>
    <tr id="r_contact_contactlastname"<?= $Page->contact_contactlastname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_contactlastname"><?= $Page->contact_contactlastname->caption() ?></span></td>
        <td data-name="contact_contactlastname"<?= $Page->contact_contactlastname->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactlastname">
<span<?= $Page->contact_contactlastname->viewAttributes() ?>>
<?= $Page->contact_contactlastname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_contactnickname->Visible) { // contact_contactnickname ?>
    <tr id="r_contact_contactnickname"<?= $Page->contact_contactnickname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_contactnickname"><?= $Page->contact_contactnickname->caption() ?></span></td>
        <td data-name="contact_contactnickname"<?= $Page->contact_contactnickname->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactnickname">
<span<?= $Page->contact_contactnickname->viewAttributes() ?>>
<?= $Page->contact_contactnickname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_contactpostition->Visible) { // contact_contactpostition ?>
    <tr id="r_contact_contactpostition"<?= $Page->contact_contactpostition->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_contactpostition"><?= $Page->contact_contactpostition->caption() ?></span></td>
        <td data-name="contact_contactpostition"<?= $Page->contact_contactpostition->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactpostition">
<span<?= $Page->contact_contactpostition->viewAttributes() ?>>
<?= $Page->contact_contactpostition->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_contactphonenumber->Visible) { // contact_contactphonenumber ?>
    <tr id="r_contact_contactphonenumber"<?= $Page->contact_contactphonenumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_contactphonenumber"><?= $Page->contact_contactphonenumber->caption() ?></span></td>
        <td data-name="contact_contactphonenumber"<?= $Page->contact_contactphonenumber->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactphonenumber">
<span<?= $Page->contact_contactphonenumber->viewAttributes() ?>>
<?= $Page->contact_contactphonenumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_contactcontactemail->Visible) { // contact_contactcontactemail ?>
    <tr id="r_contact_contactcontactemail"<?= $Page->contact_contactcontactemail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_contactcontactemail"><?= $Page->contact_contactcontactemail->caption() ?></span></td>
        <td data-name="contact_contactcontactemail"<?= $Page->contact_contactcontactemail->cellAttributes() ?>>
<span id="el_peak_contact_contact_contactcontactemail">
<span<?= $Page->contact_contactcontactemail->viewAttributes() ?>>
<?= $Page->contact_contactcontactemail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_purchaseaccount->Visible) { // contact_purchaseaccount ?>
    <tr id="r_contact_purchaseaccount"<?= $Page->contact_purchaseaccount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_purchaseaccount"><?= $Page->contact_purchaseaccount->caption() ?></span></td>
        <td data-name="contact_purchaseaccount"<?= $Page->contact_purchaseaccount->cellAttributes() ?>>
<span id="el_peak_contact_contact_purchaseaccount">
<span<?= $Page->contact_purchaseaccount->viewAttributes() ?>>
<?= $Page->contact_purchaseaccount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_sellaccount->Visible) { // contact_sellaccount ?>
    <tr id="r_contact_sellaccount"<?= $Page->contact_sellaccount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_contact_sellaccount"><?= $Page->contact_sellaccount->caption() ?></span></td>
        <td data-name="contact_sellaccount"<?= $Page->contact_sellaccount->cellAttributes() ?>>
<span id="el_peak_contact_contact_sellaccount">
<span<?= $Page->contact_sellaccount->viewAttributes() ?>>
<?= $Page->contact_sellaccount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->member_id->Visible) { // member_id ?>
    <tr id="r_member_id"<?= $Page->member_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_peak_contact_member_id"><?= $Page->member_id->caption() ?></span></td>
        <td data-name="member_id"<?= $Page->member_id->cellAttributes() ?>>
<span id="el_peak_contact_member_id">
<span<?= $Page->member_id->viewAttributes() ?>>
<?= $Page->member_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
