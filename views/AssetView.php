<?php

namespace PHPMaker2022\juzmatch;

// Page object
$AssetView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { asset: currentTable } });
var currentForm, currentPageID;
var fassetview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fassetview = new ew.Form("fassetview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fassetview;
    loadjs.done("fassetview");
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
<form name="fassetview" id="fassetview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="asset">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->_title->Visible) { // title ?>
    <tr id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset__title"><?= $Page->_title->caption() ?></span></td>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el_asset__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title_en->Visible) { // title_en ?>
    <tr id="r_title_en"<?= $Page->title_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_title_en"><?= $Page->title_en->caption() ?></span></td>
        <td data-name="title_en"<?= $Page->title_en->cellAttributes() ?>>
<span id="el_asset_title_en">
<span<?= $Page->title_en->viewAttributes() ?>>
<?= $Page->title_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
    <tr id="r_brand_id"<?= $Page->brand_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_brand_id"><?= $Page->brand_id->caption() ?></span></td>
        <td data-name="brand_id"<?= $Page->brand_id->cellAttributes() ?>>
<span id="el_asset_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<?= $Page->brand_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detail->Visible) { // detail ?>
    <tr id="r_detail"<?= $Page->detail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_detail"><?= $Page->detail->caption() ?></span></td>
        <td data-name="detail"<?= $Page->detail->cellAttributes() ?>>
<span id="el_asset_detail">
<span<?= $Page->detail->viewAttributes() ?>>
<?= $Page->detail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detail_en->Visible) { // detail_en ?>
    <tr id="r_detail_en"<?= $Page->detail_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_detail_en"><?= $Page->detail_en->caption() ?></span></td>
        <td data-name="detail_en"<?= $Page->detail_en->cellAttributes() ?>>
<span id="el_asset_detail_en">
<span<?= $Page->detail_en->viewAttributes() ?>>
<?= $Page->detail_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_code->Visible) { // asset_code ?>
    <tr id="r_asset_code"<?= $Page->asset_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_asset_code"><?= $Page->asset_code->caption() ?></span></td>
        <td data-name="asset_code"<?= $Page->asset_code->cellAttributes() ?>>
<span id="el_asset_asset_code">
<span<?= $Page->asset_code->viewAttributes() ?>>
<?= $Page->asset_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_status->Visible) { // asset_status ?>
    <tr id="r_asset_status"<?= $Page->asset_status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_asset_status"><?= $Page->asset_status->caption() ?></span></td>
        <td data-name="asset_status"<?= $Page->asset_status->cellAttributes() ?>>
<span id="el_asset_asset_status">
<span<?= $Page->asset_status->viewAttributes() ?>>
<?= $Page->asset_status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <tr id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_latitude"><?= $Page->latitude->caption() ?></span></td>
        <td data-name="latitude"<?= $Page->latitude->cellAttributes() ?>>
<span id="el_asset_latitude">
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <tr id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_longitude"><?= $Page->longitude->caption() ?></span></td>
        <td data-name="longitude"<?= $Page->longitude->cellAttributes() ?>>
<span id="el_asset_longitude">
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_buildings->Visible) { // num_buildings ?>
    <tr id="r_num_buildings"<?= $Page->num_buildings->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_num_buildings"><?= $Page->num_buildings->caption() ?></span></td>
        <td data-name="num_buildings"<?= $Page->num_buildings->cellAttributes() ?>>
<span id="el_asset_num_buildings">
<span<?= $Page->num_buildings->viewAttributes() ?>>
<?= $Page->num_buildings->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_unit->Visible) { // num_unit ?>
    <tr id="r_num_unit"<?= $Page->num_unit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_num_unit"><?= $Page->num_unit->caption() ?></span></td>
        <td data-name="num_unit"<?= $Page->num_unit->cellAttributes() ?>>
<span id="el_asset_num_unit">
<span<?= $Page->num_unit->viewAttributes() ?>>
<?= $Page->num_unit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_floors->Visible) { // num_floors ?>
    <tr id="r_num_floors"<?= $Page->num_floors->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_num_floors"><?= $Page->num_floors->caption() ?></span></td>
        <td data-name="num_floors"<?= $Page->num_floors->cellAttributes() ?>>
<span id="el_asset_num_floors">
<span<?= $Page->num_floors->viewAttributes() ?>>
<?= $Page->num_floors->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->floors->Visible) { // floors ?>
    <tr id="r_floors"<?= $Page->floors->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_floors"><?= $Page->floors->caption() ?></span></td>
        <td data-name="floors"<?= $Page->floors->cellAttributes() ?>>
<span id="el_asset_floors">
<span<?= $Page->floors->viewAttributes() ?>>
<?= $Page->floors->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_year_developer->Visible) { // asset_year_developer ?>
    <tr id="r_asset_year_developer"<?= $Page->asset_year_developer->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_asset_year_developer"><?= $Page->asset_year_developer->caption() ?></span></td>
        <td data-name="asset_year_developer"<?= $Page->asset_year_developer->cellAttributes() ?>>
<span id="el_asset_asset_year_developer">
<span<?= $Page->asset_year_developer->viewAttributes() ?>>
<?= $Page->asset_year_developer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_parking_spaces->Visible) { // num_parking_spaces ?>
    <tr id="r_num_parking_spaces"<?= $Page->num_parking_spaces->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_num_parking_spaces"><?= $Page->num_parking_spaces->caption() ?></span></td>
        <td data-name="num_parking_spaces"<?= $Page->num_parking_spaces->cellAttributes() ?>>
<span id="el_asset_num_parking_spaces">
<span<?= $Page->num_parking_spaces->viewAttributes() ?>>
<?= $Page->num_parking_spaces->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_bathrooms->Visible) { // num_bathrooms ?>
    <tr id="r_num_bathrooms"<?= $Page->num_bathrooms->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_num_bathrooms"><?= $Page->num_bathrooms->caption() ?></span></td>
        <td data-name="num_bathrooms"<?= $Page->num_bathrooms->cellAttributes() ?>>
<span id="el_asset_num_bathrooms">
<span<?= $Page->num_bathrooms->viewAttributes() ?>>
<?= $Page->num_bathrooms->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->num_bedrooms->Visible) { // num_bedrooms ?>
    <tr id="r_num_bedrooms"<?= $Page->num_bedrooms->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_num_bedrooms"><?= $Page->num_bedrooms->caption() ?></span></td>
        <td data-name="num_bedrooms"<?= $Page->num_bedrooms->cellAttributes() ?>>
<span id="el_asset_num_bedrooms">
<span<?= $Page->num_bedrooms->viewAttributes() ?>>
<?= $Page->num_bedrooms->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <tr id="r_address"<?= $Page->address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_address"><?= $Page->address->caption() ?></span></td>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el_asset_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address_en->Visible) { // address_en ?>
    <tr id="r_address_en"<?= $Page->address_en->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_address_en"><?= $Page->address_en->caption() ?></span></td>
        <td data-name="address_en"<?= $Page->address_en->cellAttributes() ?>>
<span id="el_asset_address_en">
<span<?= $Page->address_en->viewAttributes() ?>>
<?= $Page->address_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->province_id->Visible) { // province_id ?>
    <tr id="r_province_id"<?= $Page->province_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_province_id"><?= $Page->province_id->caption() ?></span></td>
        <td data-name="province_id"<?= $Page->province_id->cellAttributes() ?>>
<span id="el_asset_province_id">
<span<?= $Page->province_id->viewAttributes() ?>>
<?= $Page->province_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amphur_id->Visible) { // amphur_id ?>
    <tr id="r_amphur_id"<?= $Page->amphur_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_amphur_id"><?= $Page->amphur_id->caption() ?></span></td>
        <td data-name="amphur_id"<?= $Page->amphur_id->cellAttributes() ?>>
<span id="el_asset_amphur_id">
<span<?= $Page->amphur_id->viewAttributes() ?>>
<?= $Page->amphur_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->district_id->Visible) { // district_id ?>
    <tr id="r_district_id"<?= $Page->district_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_district_id"><?= $Page->district_id->caption() ?></span></td>
        <td data-name="district_id"<?= $Page->district_id->cellAttributes() ?>>
<span id="el_asset_district_id">
<span<?= $Page->district_id->viewAttributes() ?>>
<?= $Page->district_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->postcode->Visible) { // postcode ?>
    <tr id="r_postcode"<?= $Page->postcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_postcode"><?= $Page->postcode->caption() ?></span></td>
        <td data-name="postcode"<?= $Page->postcode->cellAttributes() ?>>
<span id="el_asset_postcode">
<span<?= $Page->postcode->viewAttributes() ?>>
<?= $Page->postcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->floor_plan->Visible) { // floor_plan ?>
    <tr id="r_floor_plan"<?= $Page->floor_plan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_floor_plan"><?= $Page->floor_plan->caption() ?></span></td>
        <td data-name="floor_plan"<?= $Page->floor_plan->cellAttributes() ?>>
<span id="el_asset_floor_plan">
<span>
<?= GetFileViewTag($Page->floor_plan, $Page->floor_plan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->layout_unit->Visible) { // layout_unit ?>
    <tr id="r_layout_unit"<?= $Page->layout_unit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_layout_unit"><?= $Page->layout_unit->caption() ?></span></td>
        <td data-name="layout_unit"<?= $Page->layout_unit->cellAttributes() ?>>
<span id="el_asset_layout_unit">
<span>
<?= GetFileViewTag($Page->layout_unit, $Page->layout_unit->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_website->Visible) { // asset_website ?>
    <tr id="r_asset_website"<?= $Page->asset_website->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_asset_website"><?= $Page->asset_website->caption() ?></span></td>
        <td data-name="asset_website"<?= $Page->asset_website->cellAttributes() ?>>
<span id="el_asset_asset_website">
<span<?= $Page->asset_website->viewAttributes() ?>>
<?= $Page->asset_website->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asset_review->Visible) { // asset_review ?>
    <tr id="r_asset_review"<?= $Page->asset_review->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_asset_review"><?= $Page->asset_review->caption() ?></span></td>
        <td data-name="asset_review"<?= $Page->asset_review->cellAttributes() ?>>
<span id="el_asset_asset_review">
<span<?= $Page->asset_review->viewAttributes() ?>>
<?= $Page->asset_review->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isactive->Visible) { // isactive ?>
    <tr id="r_isactive"<?= $Page->isactive->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_isactive"><?= $Page->isactive->caption() ?></span></td>
        <td data-name="isactive"<?= $Page->isactive->cellAttributes() ?>>
<span id="el_asset_isactive">
<span<?= $Page->isactive->viewAttributes() ?>>
<?= $Page->isactive->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_recommend->Visible) { // is_recommend ?>
    <tr id="r_is_recommend"<?= $Page->is_recommend->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_is_recommend"><?= $Page->is_recommend->caption() ?></span></td>
        <td data-name="is_recommend"<?= $Page->is_recommend->cellAttributes() ?>>
<span id="el_asset_is_recommend">
<span<?= $Page->is_recommend->viewAttributes() ?>>
<?= $Page->is_recommend->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->order_by->Visible) { // order_by ?>
    <tr id="r_order_by"<?= $Page->order_by->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_order_by"><?= $Page->order_by->caption() ?></span></td>
        <td data-name="order_by"<?= $Page->order_by->cellAttributes() ?>>
<span id="el_asset_order_by">
<span<?= $Page->order_by->viewAttributes() ?>>
<?= $Page->order_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type_pay->Visible) { // type_pay ?>
    <tr id="r_type_pay"<?= $Page->type_pay->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_type_pay"><?= $Page->type_pay->caption() ?></span></td>
        <td data-name="type_pay"<?= $Page->type_pay->cellAttributes() ?>>
<span id="el_asset_type_pay">
<span<?= $Page->type_pay->viewAttributes() ?>>
<?= $Page->type_pay->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type_pay_2->Visible) { // type_pay_2 ?>
    <tr id="r_type_pay_2"<?= $Page->type_pay_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_type_pay_2"><?= $Page->type_pay_2->caption() ?></span></td>
        <td data-name="type_pay_2"<?= $Page->type_pay_2->cellAttributes() ?>>
<span id="el_asset_type_pay_2">
<span<?= $Page->type_pay_2->viewAttributes() ?>>
<?= $Page->type_pay_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_mark->Visible) { // price_mark ?>
    <tr id="r_price_mark"<?= $Page->price_mark->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_mark"><?= $Page->price_mark->caption() ?></span></td>
        <td data-name="price_mark"<?= $Page->price_mark->cellAttributes() ?>>
<span id="el_asset_price_mark">
<span<?= $Page->price_mark->viewAttributes() ?>>
<?= $Page->price_mark->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->holding_property->Visible) { // holding_property ?>
    <tr id="r_holding_property"<?= $Page->holding_property->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_holding_property"><?= $Page->holding_property->caption() ?></span></td>
        <td data-name="holding_property"<?= $Page->holding_property->cellAttributes() ?>>
<span id="el_asset_holding_property">
<span<?= $Page->holding_property->viewAttributes() ?>>
<?= $Page->holding_property->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->common_fee->Visible) { // common_fee ?>
    <tr id="r_common_fee"<?= $Page->common_fee->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_common_fee"><?= $Page->common_fee->caption() ?></span></td>
        <td data-name="common_fee"<?= $Page->common_fee->cellAttributes() ?>>
<span id="el_asset_common_fee">
<span<?= $Page->common_fee->viewAttributes() ?>>
<?= $Page->common_fee->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usable_area->Visible) { // usable_area ?>
    <tr id="r_usable_area"<?= $Page->usable_area->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_usable_area"><?= $Page->usable_area->caption() ?></span></td>
        <td data-name="usable_area"<?= $Page->usable_area->cellAttributes() ?>>
<span id="el_asset_usable_area">
<span<?= $Page->usable_area->viewAttributes() ?>>
<?= $Page->usable_area->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usable_area_price->Visible) { // usable_area_price ?>
    <tr id="r_usable_area_price"<?= $Page->usable_area_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_usable_area_price"><?= $Page->usable_area_price->caption() ?></span></td>
        <td data-name="usable_area_price"<?= $Page->usable_area_price->cellAttributes() ?>>
<span id="el_asset_usable_area_price">
<span<?= $Page->usable_area_price->viewAttributes() ?>>
<?="฿". $Page->usable_area_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->land_size->Visible) { // land_size ?>
    <tr id="r_land_size"<?= $Page->land_size->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_land_size"><?= $Page->land_size->caption() ?></span></td>
        <td data-name="land_size"<?= $Page->land_size->cellAttributes() ?>>
<span id="el_asset_land_size">
<span<?= $Page->land_size->viewAttributes() ?>>
<?= $Page->land_size->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->land_size_price->Visible) { // land_size_price ?>
    <tr id="r_land_size_price"<?= $Page->land_size_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_land_size_price"><?= $Page->land_size_price->caption() ?></span></td>
        <td data-name="land_size_price"<?= $Page->land_size_price->cellAttributes() ?>>
<span id="el_asset_land_size_price">
<span<?= $Page->land_size_price->viewAttributes() ?>>
<?="฿". $Page->land_size_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->commission->Visible) { // commission ?>
    <tr id="r_commission"<?= $Page->commission->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_commission"><?= $Page->commission->caption() ?></span></td>
        <td data-name="commission"<?= $Page->commission->cellAttributes() ?>>
<span id="el_asset_commission">
<span<?= $Page->commission->viewAttributes() ?>>
<?= $Page->commission->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transfer_day_expenses_with_business_tax->Visible) { // transfer_day_expenses_with_business_tax ?>
    <tr id="r_transfer_day_expenses_with_business_tax"<?= $Page->transfer_day_expenses_with_business_tax->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_transfer_day_expenses_with_business_tax"><?= $Page->transfer_day_expenses_with_business_tax->caption() ?></span></td>
        <td data-name="transfer_day_expenses_with_business_tax"<?= $Page->transfer_day_expenses_with_business_tax->cellAttributes() ?>>
<span id="el_asset_transfer_day_expenses_with_business_tax">
<span<?= $Page->transfer_day_expenses_with_business_tax->viewAttributes() ?>>
<?= $Page->transfer_day_expenses_with_business_tax->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transfer_day_expenses_without_business_tax->Visible) { // transfer_day_expenses_without_business_tax ?>
    <tr id="r_transfer_day_expenses_without_business_tax"<?= $Page->transfer_day_expenses_without_business_tax->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_transfer_day_expenses_without_business_tax"><?= $Page->transfer_day_expenses_without_business_tax->caption() ?></span></td>
        <td data-name="transfer_day_expenses_without_business_tax"<?= $Page->transfer_day_expenses_without_business_tax->cellAttributes() ?>>
<span id="el_asset_transfer_day_expenses_without_business_tax">
<span<?= $Page->transfer_day_expenses_without_business_tax->viewAttributes() ?>>
<?= $Page->transfer_day_expenses_without_business_tax->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price->Visible) { // price ?>
    <tr id="r_price"<?= $Page->price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price"><?= $Page->price->caption() ?></span></td>
        <td data-name="price"<?= $Page->price->cellAttributes() ?>>
<span id="el_asset_price">
<span<?= $Page->price->viewAttributes() ?>>
<?= $Page->price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->discount->Visible) { // discount ?>
    <tr id="r_discount"<?= $Page->discount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_discount"><?= $Page->discount->caption() ?></span></td>
        <td data-name="discount"<?= $Page->discount->cellAttributes() ?>>
<span id="el_asset_discount">
<span<?= $Page->discount->viewAttributes() ?>>
<?= $Page->discount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_special->Visible) { // price_special ?>
    <tr id="r_price_special"<?= $Page->price_special->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_special"><?= $Page->price_special->caption() ?></span></td>
        <td data-name="price_special"<?= $Page->price_special->cellAttributes() ?>>
<span id="el_asset_price_special">
<span<?= $Page->price_special->viewAttributes() ?>>
<?= $Page->price_special->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reservation_price_model_a->Visible) { // reservation_price_model_a ?>
    <tr id="r_reservation_price_model_a"<?= $Page->reservation_price_model_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_reservation_price_model_a"><?= $Page->reservation_price_model_a->caption() ?></span></td>
        <td data-name="reservation_price_model_a"<?= $Page->reservation_price_model_a->cellAttributes() ?>>
<span id="el_asset_reservation_price_model_a">
<span<?= $Page->reservation_price_model_a->viewAttributes() ?>>
<?= $Page->reservation_price_model_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->minimum_down_payment_model_a->Visible) { // minimum_down_payment_model_a ?>
    <tr id="r_minimum_down_payment_model_a"<?= $Page->minimum_down_payment_model_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_minimum_down_payment_model_a"><?= $Page->minimum_down_payment_model_a->caption() ?></span></td>
        <td data-name="minimum_down_payment_model_a"<?= $Page->minimum_down_payment_model_a->cellAttributes() ?>>
<span id="el_asset_minimum_down_payment_model_a">
<span<?= $Page->minimum_down_payment_model_a->viewAttributes() ?>>
<?= $Page->minimum_down_payment_model_a->CurrentValue ."%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->down_price_min_a->Visible) { // down_price_min_a ?>
    <tr id="r_down_price_min_a"<?= $Page->down_price_min_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_down_price_min_a"><?= $Page->down_price_min_a->caption() ?></span></td>
        <td data-name="down_price_min_a"<?= $Page->down_price_min_a->cellAttributes() ?>>
<span id="el_asset_down_price_min_a">
<span<?= $Page->down_price_min_a->viewAttributes() ?>>
<?= $Page->down_price_min_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->down_price_model_a->Visible) { // down_price_model_a ?>
    <tr id="r_down_price_model_a"<?= $Page->down_price_model_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_down_price_model_a"><?= $Page->down_price_model_a->caption() ?></span></td>
        <td data-name="down_price_model_a"<?= $Page->down_price_model_a->cellAttributes() ?>>
<span id="el_asset_down_price_model_a">
<span<?= $Page->down_price_model_a->viewAttributes() ?>>
<?= $Page->down_price_model_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->factor_monthly_installment_over_down->Visible) { // factor_monthly_installment_over_down ?>
    <tr id="r_factor_monthly_installment_over_down"<?= $Page->factor_monthly_installment_over_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_factor_monthly_installment_over_down"><?= $Page->factor_monthly_installment_over_down->caption() ?></span></td>
        <td data-name="factor_monthly_installment_over_down"<?= $Page->factor_monthly_installment_over_down->cellAttributes() ?>>
<span id="el_asset_factor_monthly_installment_over_down">
<span<?= $Page->factor_monthly_installment_over_down->viewAttributes() ?>>
<?= $Page->factor_monthly_installment_over_down->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fee_a->Visible) { // fee_a ?>
    <tr id="r_fee_a"<?= $Page->fee_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_fee_a"><?= $Page->fee_a->caption() ?></span></td>
        <td data-name="fee_a"<?= $Page->fee_a->cellAttributes() ?>>
<span id="el_asset_fee_a">
<span<?= $Page->fee_a->viewAttributes() ?>>
<?= $Page->fee_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_payment_buyer->Visible) { // monthly_payment_buyer ?>
    <tr id="r_monthly_payment_buyer"<?= $Page->monthly_payment_buyer->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_monthly_payment_buyer"><?= $Page->monthly_payment_buyer->caption() ?></span></td>
        <td data-name="monthly_payment_buyer"<?= $Page->monthly_payment_buyer->cellAttributes() ?>>
<span id="el_asset_monthly_payment_buyer">
<span<?= $Page->monthly_payment_buyer->viewAttributes() ?>>
<?= $Page->monthly_payment_buyer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->annual_interest_buyer_model_a->Visible) { // annual_interest_buyer_model_a ?>
    <tr id="r_annual_interest_buyer_model_a"<?= $Page->annual_interest_buyer_model_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_annual_interest_buyer_model_a"><?= $Page->annual_interest_buyer_model_a->caption() ?></span></td>
        <td data-name="annual_interest_buyer_model_a"<?= $Page->annual_interest_buyer_model_a->cellAttributes() ?>>
<span id="el_asset_annual_interest_buyer_model_a">
<span<?= $Page->annual_interest_buyer_model_a->viewAttributes() ?>>
<?= $Page->annual_interest_buyer_model_a->CurrentValue . "%"?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_expenses_a->Visible) { // monthly_expenses_a ?>
    <tr id="r_monthly_expenses_a"<?= $Page->monthly_expenses_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_monthly_expenses_a"><?= $Page->monthly_expenses_a->caption() ?></span></td>
        <td data-name="monthly_expenses_a"<?= $Page->monthly_expenses_a->cellAttributes() ?>>
<span id="el_asset_monthly_expenses_a">
<span<?= $Page->monthly_expenses_a->viewAttributes() ?>>
<?= $Page->monthly_expenses_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->average_rent_a->Visible) { // average_rent_a ?>
    <tr id="r_average_rent_a"<?= $Page->average_rent_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_average_rent_a"><?= $Page->average_rent_a->caption() ?></span></td>
        <td data-name="average_rent_a"<?= $Page->average_rent_a->cellAttributes() ?>>
<span id="el_asset_average_rent_a">
<span<?= $Page->average_rent_a->viewAttributes() ?>>
<?= $Page->average_rent_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->average_down_payment_a->Visible) { // average_down_payment_a ?>
    <tr id="r_average_down_payment_a"<?= $Page->average_down_payment_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_average_down_payment_a"><?= $Page->average_down_payment_a->caption() ?></span></td>
        <td data-name="average_down_payment_a"<?= $Page->average_down_payment_a->cellAttributes() ?>>
<span id="el_asset_average_down_payment_a">
<span<?= $Page->average_down_payment_a->viewAttributes() ?>>
<?= $Page->average_down_payment_a->getViewValue()?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transfer_day_expenses_without_business_tax_max_min->Visible) { // transfer_day_expenses_without_business_tax_max_min ?>
    <tr id="r_transfer_day_expenses_without_business_tax_max_min"<?= $Page->transfer_day_expenses_without_business_tax_max_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_transfer_day_expenses_without_business_tax_max_min"><?= $Page->transfer_day_expenses_without_business_tax_max_min->caption() ?></span></td>
        <td data-name="transfer_day_expenses_without_business_tax_max_min"<?= $Page->transfer_day_expenses_without_business_tax_max_min->cellAttributes() ?>>
<span id="el_asset_transfer_day_expenses_without_business_tax_max_min">
<span<?= $Page->transfer_day_expenses_without_business_tax_max_min->viewAttributes() ?>>
<?= $Page->transfer_day_expenses_without_business_tax_max_min->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->transfer_day_expenses_with_business_tax_max_min->Visible) { // transfer_day_expenses_with_business_tax_max_min ?>
    <tr id="r_transfer_day_expenses_with_business_tax_max_min"<?= $Page->transfer_day_expenses_with_business_tax_max_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_transfer_day_expenses_with_business_tax_max_min"><?= $Page->transfer_day_expenses_with_business_tax_max_min->caption() ?></span></td>
        <td data-name="transfer_day_expenses_with_business_tax_max_min"<?= $Page->transfer_day_expenses_with_business_tax_max_min->cellAttributes() ?>>
<span id="el_asset_transfer_day_expenses_with_business_tax_max_min">
<span<?= $Page->transfer_day_expenses_with_business_tax_max_min->viewAttributes() ?>>
<?= $Page->transfer_day_expenses_with_business_tax_max_min->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bank_appraisal_price->Visible) { // bank_appraisal_price ?>
    <tr id="r_bank_appraisal_price"<?= $Page->bank_appraisal_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_bank_appraisal_price"><?= $Page->bank_appraisal_price->caption() ?></span></td>
        <td data-name="bank_appraisal_price"<?= $Page->bank_appraisal_price->cellAttributes() ?>>
<span id="el_asset_bank_appraisal_price">
<span<?= $Page->bank_appraisal_price->viewAttributes() ?>>
<?= $Page->bank_appraisal_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mark_up_price->Visible) { // mark_up_price ?>
    <tr id="r_mark_up_price"<?= $Page->mark_up_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_mark_up_price"><?= $Page->mark_up_price->caption() ?></span></td>
        <td data-name="mark_up_price"<?= $Page->mark_up_price->cellAttributes() ?>>
<span id="el_asset_mark_up_price">
<span<?= $Page->mark_up_price->viewAttributes() ?>>
<?= $Page->mark_up_price->CurrentValue . "%"?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->required_gap->Visible) { // required_gap ?>
    <tr id="r_required_gap"<?= $Page->required_gap->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_required_gap"><?= $Page->required_gap->caption() ?></span></td>
        <td data-name="required_gap"<?= $Page->required_gap->cellAttributes() ?>>
<span id="el_asset_required_gap">
<span<?= $Page->required_gap->viewAttributes() ?>>
<?= $Page->required_gap->CurrentValue . "%"?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->minimum_down_payment->Visible) { // minimum_down_payment ?>
    <tr id="r_minimum_down_payment"<?= $Page->minimum_down_payment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_minimum_down_payment"><?= $Page->minimum_down_payment->caption() ?></span></td>
        <td data-name="minimum_down_payment"<?= $Page->minimum_down_payment->cellAttributes() ?>>
<span id="el_asset_minimum_down_payment">
<span<?= $Page->minimum_down_payment->viewAttributes() ?>>
<?= $Page->minimum_down_payment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_down_max->Visible) { // price_down_max ?>
    <tr id="r_price_down_max"<?= $Page->price_down_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_down_max"><?= $Page->price_down_max->caption() ?></span></td>
        <td data-name="price_down_max"<?= $Page->price_down_max->cellAttributes() ?>>
<span id="el_asset_price_down_max">
<span<?= $Page->price_down_max->viewAttributes() ?>>
<?= $Page->price_down_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->discount_max->Visible) { // discount_max ?>
    <tr id="r_discount_max"<?= $Page->discount_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_discount_max"><?= $Page->discount_max->caption() ?></span></td>
        <td data-name="discount_max"<?= $Page->discount_max->cellAttributes() ?>>
<span id="el_asset_discount_max">
<span<?= $Page->discount_max->viewAttributes() ?>>
<?= $Page->discount_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_down_special_max->Visible) { // price_down_special_max ?>
    <tr id="r_price_down_special_max"<?= $Page->price_down_special_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_down_special_max"><?= $Page->price_down_special_max->caption() ?></span></td>
        <td data-name="price_down_special_max"<?= $Page->price_down_special_max->cellAttributes() ?>>
<span id="el_asset_price_down_special_max">
<span<?= $Page->price_down_special_max->viewAttributes() ?>>
<?= $Page->price_down_special_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usable_area_price_max->Visible) { // usable_area_price_max ?>
    <tr id="r_usable_area_price_max"<?= $Page->usable_area_price_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_usable_area_price_max"><?= $Page->usable_area_price_max->caption() ?></span></td>
        <td data-name="usable_area_price_max"<?= $Page->usable_area_price_max->cellAttributes() ?>>
<span id="el_asset_usable_area_price_max">
<span<?= $Page->usable_area_price_max->viewAttributes() ?>>
<?= $Page->usable_area_price_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->land_size_price_max->Visible) { // land_size_price_max ?>
    <tr id="r_land_size_price_max"<?= $Page->land_size_price_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_land_size_price_max"><?= $Page->land_size_price_max->caption() ?></span></td>
        <td data-name="land_size_price_max"<?= $Page->land_size_price_max->cellAttributes() ?>>
<span id="el_asset_land_size_price_max">
<span<?= $Page->land_size_price_max->viewAttributes() ?>>
<?= $Page->land_size_price_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reservation_price_max->Visible) { // reservation_price_max ?>
    <tr id="r_reservation_price_max"<?= $Page->reservation_price_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_reservation_price_max"><?= $Page->reservation_price_max->caption() ?></span></td>
        <td data-name="reservation_price_max"<?= $Page->reservation_price_max->cellAttributes() ?>>
<span id="el_asset_reservation_price_max">
<span<?= $Page->reservation_price_max->viewAttributes() ?>>
<?= $Page->reservation_price_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->minimum_down_payment_max->Visible) { // minimum_down_payment_max ?>
    <tr id="r_minimum_down_payment_max"<?= $Page->minimum_down_payment_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_minimum_down_payment_max"><?= $Page->minimum_down_payment_max->caption() ?></span></td>
        <td data-name="minimum_down_payment_max"<?= $Page->minimum_down_payment_max->cellAttributes() ?>>
<span id="el_asset_minimum_down_payment_max">
<span<?= $Page->minimum_down_payment_max->viewAttributes() ?>>
<?= $Page->minimum_down_payment_max->CurrentValue. "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->down_price_max->Visible) { // down_price_max ?>
    <tr id="r_down_price_max"<?= $Page->down_price_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_down_price_max"><?= $Page->down_price_max->caption() ?></span></td>
        <td data-name="down_price_max"<?= $Page->down_price_max->cellAttributes() ?>>
<span id="el_asset_down_price_max">
<span<?= $Page->down_price_max->viewAttributes() ?>>
<?= $Page->down_price_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->down_price->Visible) { // down_price ?>
    <tr id="r_down_price"<?= $Page->down_price->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_down_price"><?= $Page->down_price->caption() ?></span></td>
        <td data-name="down_price"<?= $Page->down_price->cellAttributes() ?>>
<span id="el_asset_down_price">
<span<?= $Page->down_price->viewAttributes() ?>>
<?= $Page->down_price->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->factor_monthly_installment_over_down_max->Visible) { // factor_monthly_installment_over_down_max ?>
    <tr id="r_factor_monthly_installment_over_down_max"<?= $Page->factor_monthly_installment_over_down_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_factor_monthly_installment_over_down_max"><?= $Page->factor_monthly_installment_over_down_max->caption() ?></span></td>
        <td data-name="factor_monthly_installment_over_down_max"<?= $Page->factor_monthly_installment_over_down_max->cellAttributes() ?>>
<span id="el_asset_factor_monthly_installment_over_down_max">
<span<?= $Page->factor_monthly_installment_over_down_max->viewAttributes() ?>>
<?= $Page->factor_monthly_installment_over_down_max->getViewValue()."%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fee_max->Visible) { // fee_max ?>
    <tr id="r_fee_max"<?= $Page->fee_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_fee_max"><?= $Page->fee_max->caption() ?></span></td>
        <td data-name="fee_max"<?= $Page->fee_max->cellAttributes() ?>>
<span id="el_asset_fee_max">
<span<?= $Page->fee_max->viewAttributes() ?>>
<?= $Page->fee_max->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_payment_max->Visible) { // monthly_payment_max ?>
    <tr id="r_monthly_payment_max"<?= $Page->monthly_payment_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_monthly_payment_max"><?= $Page->monthly_payment_max->caption() ?></span></td>
        <td data-name="monthly_payment_max"<?= $Page->monthly_payment_max->cellAttributes() ?>>
<span id="el_asset_monthly_payment_max">
<span<?= $Page->monthly_payment_max->viewAttributes() ?>>
<?= $Page->monthly_payment_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->annual_interest_buyer->Visible) { // annual_interest_buyer ?>
    <tr id="r_annual_interest_buyer"<?= $Page->annual_interest_buyer->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_annual_interest_buyer"><?= $Page->annual_interest_buyer->caption() ?></span></td>
        <td data-name="annual_interest_buyer"<?= $Page->annual_interest_buyer->cellAttributes() ?>>
<span id="el_asset_annual_interest_buyer">
<span<?= $Page->annual_interest_buyer->viewAttributes() ?>>
<?= $Page->annual_interest_buyer->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_expense_max->Visible) { // monthly_expense_max ?>
    <tr id="r_monthly_expense_max"<?= $Page->monthly_expense_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_monthly_expense_max"><?= $Page->monthly_expense_max->caption() ?></span></td>
        <td data-name="monthly_expense_max"<?= $Page->monthly_expense_max->cellAttributes() ?>>
<span id="el_asset_monthly_expense_max">
<span<?= $Page->monthly_expense_max->viewAttributes() ?>>
<?= $Page->monthly_expense_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->average_rent_max->Visible) { // average_rent_max ?>
    <tr id="r_average_rent_max"<?= $Page->average_rent_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_average_rent_max"><?= $Page->average_rent_max->caption() ?></span></td>
        <td data-name="average_rent_max"<?= $Page->average_rent_max->cellAttributes() ?>>
<span id="el_asset_average_rent_max">
<span<?= $Page->average_rent_max->viewAttributes() ?>>
<?= $Page->average_rent_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->average_down_payment_max->Visible) { // average_down_payment_max ?>
    <tr id="r_average_down_payment_max"<?= $Page->average_down_payment_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_average_down_payment_max"><?= $Page->average_down_payment_max->caption() ?></span></td>
        <td data-name="average_down_payment_max"<?= $Page->average_down_payment_max->cellAttributes() ?>>
<span id="el_asset_average_down_payment_max">
<span<?= $Page->average_down_payment_max->viewAttributes() ?>>
<?= $Page->average_down_payment_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->min_down->Visible) { // min_down ?>
    <tr id="r_min_down"<?= $Page->min_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_min_down"><?= $Page->min_down->caption() ?></span></td>
        <td data-name="min_down"<?= $Page->min_down->cellAttributes() ?>>
<span id="el_asset_min_down">
<span<?= $Page->min_down->viewAttributes() ?>>
<?= $Page->min_down->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remaining_down->Visible) { // remaining_down ?>
    <tr id="r_remaining_down"<?= $Page->remaining_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_remaining_down"><?= $Page->remaining_down->caption() ?></span></td>
        <td data-name="remaining_down"<?= $Page->remaining_down->cellAttributes() ?>>
<span id="el_asset_remaining_down">
<span<?= $Page->remaining_down->viewAttributes() ?>>
<?= $Page->remaining_down->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->factor_financing->Visible) { // factor_financing ?>
    <tr id="r_factor_financing"<?= $Page->factor_financing->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_factor_financing"><?= $Page->factor_financing->caption() ?></span></td>
        <td data-name="factor_financing"<?= $Page->factor_financing->cellAttributes() ?>>
<span id="el_asset_factor_financing">
<span<?= $Page->factor_financing->viewAttributes() ?>>
<?= $Page->factor_financing->CurrentValue . "%"?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->credit_limit_down->Visible) { // credit_limit_down ?>
    <tr id="r_credit_limit_down"<?= $Page->credit_limit_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_credit_limit_down"><?= $Page->credit_limit_down->caption() ?></span></td>
        <td data-name="credit_limit_down"<?= $Page->credit_limit_down->cellAttributes() ?>>
<span id="el_asset_credit_limit_down">
<span<?= $Page->credit_limit_down->viewAttributes() ?>>
<?= $Page->credit_limit_down->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_down_min->Visible) { // price_down_min ?>
    <tr id="r_price_down_min"<?= $Page->price_down_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_down_min"><?= $Page->price_down_min->caption() ?></span></td>
        <td data-name="price_down_min"<?= $Page->price_down_min->cellAttributes() ?>>
<span id="el_asset_price_down_min">
<span<?= $Page->price_down_min->viewAttributes() ?>>
<?= $Page->price_down_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->discount_min->Visible) { // discount_min ?>
    <tr id="r_discount_min"<?= $Page->discount_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_discount_min"><?= $Page->discount_min->caption() ?></span></td>
        <td data-name="discount_min"<?= $Page->discount_min->cellAttributes() ?>>
<span id="el_asset_discount_min">
<span<?= $Page->discount_min->viewAttributes() ?>>
<?= $Page->discount_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_down_special_min->Visible) { // price_down_special_min ?>
    <tr id="r_price_down_special_min"<?= $Page->price_down_special_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_down_special_min"><?= $Page->price_down_special_min->caption() ?></span></td>
        <td data-name="price_down_special_min"<?= $Page->price_down_special_min->cellAttributes() ?>>
<span id="el_asset_price_down_special_min">
<span<?= $Page->price_down_special_min->viewAttributes() ?>>
<?= $Page->price_down_special_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usable_area_price_min->Visible) { // usable_area_price_min ?>
    <tr id="r_usable_area_price_min"<?= $Page->usable_area_price_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_usable_area_price_min"><?= $Page->usable_area_price_min->caption() ?></span></td>
        <td data-name="usable_area_price_min"<?= $Page->usable_area_price_min->cellAttributes() ?>>
<span id="el_asset_usable_area_price_min">
<span<?= $Page->usable_area_price_min->viewAttributes() ?>>
<?= "฿" .$Page->usable_area_price_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->land_size_price_min->Visible) { // land_size_price_min ?>
    <tr id="r_land_size_price_min"<?= $Page->land_size_price_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_land_size_price_min"><?= $Page->land_size_price_min->caption() ?></span></td>
        <td data-name="land_size_price_min"<?= $Page->land_size_price_min->cellAttributes() ?>>
<span id="el_asset_land_size_price_min">
<span<?= $Page->land_size_price_min->viewAttributes() ?>>
<?= "฿" . number_format($Page->land_size_price_min->CurrentValue)?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reservation_price_min->Visible) { // reservation_price_min ?>
    <tr id="r_reservation_price_min"<?= $Page->reservation_price_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_reservation_price_min"><?= $Page->reservation_price_min->caption() ?></span></td>
        <td data-name="reservation_price_min"<?= $Page->reservation_price_min->cellAttributes() ?>>
<span id="el_asset_reservation_price_min">
<span<?= $Page->reservation_price_min->viewAttributes() ?>>
<?= $Page->reservation_price_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->minimum_down_payment_min->Visible) { // minimum_down_payment_min ?>
    <tr id="r_minimum_down_payment_min"<?= $Page->minimum_down_payment_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_minimum_down_payment_min"><?= $Page->minimum_down_payment_min->caption() ?></span></td>
        <td data-name="minimum_down_payment_min"<?= $Page->minimum_down_payment_min->cellAttributes() ?>>
<span id="el_asset_minimum_down_payment_min">
<span<?= $Page->minimum_down_payment_min->viewAttributes() ?>>
<?= $Page->minimum_down_payment_min->CurrentValue ."%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->down_price_min->Visible) { // down_price_min ?>
    <tr id="r_down_price_min"<?= $Page->down_price_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_down_price_min"><?= $Page->down_price_min->caption() ?></span></td>
        <td data-name="down_price_min"<?= $Page->down_price_min->cellAttributes() ?>>
<span id="el_asset_down_price_min">
<span<?= $Page->down_price_min->viewAttributes() ?>>
<?= $Page->down_price_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->remaining_credit_limit_down->Visible) { // remaining_credit_limit_down ?>
    <tr id="r_remaining_credit_limit_down"<?= $Page->remaining_credit_limit_down->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_remaining_credit_limit_down"><?= $Page->remaining_credit_limit_down->caption() ?></span></td>
        <td data-name="remaining_credit_limit_down"<?= $Page->remaining_credit_limit_down->cellAttributes() ?>>
<span id="el_asset_remaining_credit_limit_down">
<span<?= $Page->remaining_credit_limit_down->viewAttributes() ?>>
<?= $Page->remaining_credit_limit_down->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fee_min->Visible) { // fee_min ?>
    <tr id="r_fee_min"<?= $Page->fee_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_fee_min"><?= $Page->fee_min->caption() ?></span></td>
        <td data-name="fee_min"<?= $Page->fee_min->cellAttributes() ?>>
<span id="el_asset_fee_min">
<span<?= $Page->fee_min->viewAttributes() ?>>
<?= $Page->fee_min->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_payment_min->Visible) { // monthly_payment_min ?>
    <tr id="r_monthly_payment_min"<?= $Page->monthly_payment_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_monthly_payment_min"><?= $Page->monthly_payment_min->caption() ?></span></td>
        <td data-name="monthly_payment_min"<?= $Page->monthly_payment_min->cellAttributes() ?>>
<span id="el_asset_monthly_payment_min">
<span<?= $Page->monthly_payment_min->viewAttributes() ?>>
<?= $Page->monthly_payment_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->annual_interest_buyer_model_min->Visible) { // annual_interest_buyer_model_min ?>
    <tr id="r_annual_interest_buyer_model_min"<?= $Page->annual_interest_buyer_model_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_annual_interest_buyer_model_min"><?= $Page->annual_interest_buyer_model_min->caption() ?></span></td>
        <td data-name="annual_interest_buyer_model_min"<?= $Page->annual_interest_buyer_model_min->cellAttributes() ?>>
<span id="el_asset_annual_interest_buyer_model_min">
<span<?= $Page->annual_interest_buyer_model_min->viewAttributes() ?>>
<?= $Page->annual_interest_buyer_model_min->CurrentValue . "%" ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->interest_downpayment_financing->Visible) { // interest_down-payment_financing ?>
    <tr id="r_interest_downpayment_financing"<?= $Page->interest_downpayment_financing->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_interest_downpayment_financing"><?= $Page->interest_downpayment_financing->caption() ?></span></td>
        <td data-name="interest_downpayment_financing"<?= $Page->interest_downpayment_financing->cellAttributes() ?>>
<span id="el_asset_interest_downpayment_financing">
<span<?= $Page->interest_downpayment_financing->viewAttributes() ?>>
<?= $Page->interest_downpayment_financing->CurrentValue . "%"?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monthly_expenses_min->Visible) { // monthly_expenses_min ?>
    <tr id="r_monthly_expenses_min"<?= $Page->monthly_expenses_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_monthly_expenses_min"><?= $Page->monthly_expenses_min->caption() ?></span></td>
        <td data-name="monthly_expenses_min"<?= $Page->monthly_expenses_min->cellAttributes() ?>>
<span id="el_asset_monthly_expenses_min">
<span<?= $Page->monthly_expenses_min->viewAttributes() ?>>
<?="฿" . $Page->monthly_expenses_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->average_rent_min->Visible) { // average_rent_min ?>
    <tr id="r_average_rent_min"<?= $Page->average_rent_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_average_rent_min"><?= $Page->average_rent_min->caption() ?></span></td>
        <td data-name="average_rent_min"<?= $Page->average_rent_min->cellAttributes() ?>>
<span id="el_asset_average_rent_min">
<span<?= $Page->average_rent_min->viewAttributes() ?>>
<?="฿". $Page->average_rent_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->average_down_payment_min->Visible) { // average_down_payment_min ?>
    <tr id="r_average_down_payment_min"<?= $Page->average_down_payment_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_average_down_payment_min"><?= $Page->average_down_payment_min->caption() ?></span></td>
        <td data-name="average_down_payment_min"<?= $Page->average_down_payment_min->cellAttributes() ?>>
<span id="el_asset_average_down_payment_min">
<span<?= $Page->average_down_payment_min->viewAttributes() ?>>
<?="฿". $Page->average_down_payment_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment_down_payment_loan->Visible) { // installment_down_payment_loan ?>
    <tr id="r_installment_down_payment_loan"<?= $Page->installment_down_payment_loan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_installment_down_payment_loan"><?= $Page->installment_down_payment_loan->caption() ?></span></td>
        <td data-name="installment_down_payment_loan"<?= $Page->installment_down_payment_loan->cellAttributes() ?>>
<span id="el_asset_installment_down_payment_loan">
<span<?= $Page->installment_down_payment_loan->viewAttributes() ?>>
<?="฿". $Page->installment_down_payment_loan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_view->Visible) { // count_view ?>
    <tr id="r_count_view"<?= $Page->count_view->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_count_view"><?= $Page->count_view->caption() ?></span></td>
        <td data-name="count_view"<?= $Page->count_view->cellAttributes() ?>>
<span id="el_asset_count_view">
<span<?= $Page->count_view->viewAttributes() ?>>
<?= $Page->count_view->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->count_favorite->Visible) { // count_favorite ?>
    <tr id="r_count_favorite"<?= $Page->count_favorite->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_count_favorite"><?= $Page->count_favorite->caption() ?></span></td>
        <td data-name="count_favorite"<?= $Page->count_favorite->cellAttributes() ?>>
<span id="el_asset_count_favorite">
<span<?= $Page->count_favorite->viewAttributes() ?>>
<?= $Page->count_favorite->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->price_invertor->Visible) { // price_invertor ?>
    <tr id="r_price_invertor"<?= $Page->price_invertor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_price_invertor"><?= $Page->price_invertor->caption() ?></span></td>
        <td data-name="price_invertor"<?= $Page->price_invertor->cellAttributes() ?>>
<span id="el_asset_price_invertor">
<span<?= $Page->price_invertor->viewAttributes() ?>>
<?= $Page->price_invertor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expired_date->Visible) { // expired_date ?>
    <tr id="r_expired_date"<?= $Page->expired_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_expired_date"><?= $Page->expired_date->caption() ?></span></td>
        <td data-name="expired_date"<?= $Page->expired_date->cellAttributes() ?>>
<span id="el_asset_expired_date">
<span<?= $Page->expired_date->viewAttributes() ?>>
<?= $Page->expired_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cdate->Visible) { // cdate ?>
    <tr id="r_cdate"<?= $Page->cdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_asset_cdate"><?= $Page->cdate->caption() ?></span></td>
        <td data-name="cdate"<?= $Page->cdate->cellAttributes() ?>>
<span id="el_asset_cdate">
<span<?= $Page->cdate->viewAttributes() ?>>
<?= $Page->cdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav<?= $Page->DetailPages->containerClasses() ?>" id="details_Page"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navClasses() ?>" role="tablist"><!-- .nav -->
<?php
    if (in_array("asset_facilities", explode(",", $Page->getCurrentDetailTable())) && $asset_facilities->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("asset_facilities") ?><?= $Page->DetailPages->activeClasses("asset_facilities") ?>" data-bs-target="#tab_asset_facilities" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_asset_facilities" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("asset_facilities")) ?>"><?= $Language->tablePhrase("asset_facilities", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("asset_pros_detail", explode(",", $Page->getCurrentDetailTable())) && $asset_pros_detail->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("asset_pros_detail") ?><?= $Page->DetailPages->activeClasses("asset_pros_detail") ?>" data-bs-target="#tab_asset_pros_detail" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_asset_pros_detail" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("asset_pros_detail")) ?>"><?= $Language->tablePhrase("asset_pros_detail", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("asset_banner", explode(",", $Page->getCurrentDetailTable())) && $asset_banner->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("asset_banner") ?><?= $Page->DetailPages->activeClasses("asset_banner") ?>" data-bs-target="#tab_asset_banner" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_asset_banner" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("asset_banner")) ?>"><?= $Language->tablePhrase("asset_banner", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("asset_category", explode(",", $Page->getCurrentDetailTable())) && $asset_category->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("asset_category") ?><?= $Page->DetailPages->activeClasses("asset_category") ?>" data-bs-target="#tab_asset_category" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_asset_category" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("asset_category")) ?>"><?= $Language->tablePhrase("asset_category", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("asset_warning", explode(",", $Page->getCurrentDetailTable())) && $asset_warning->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("asset_warning") ?><?= $Page->DetailPages->activeClasses("asset_warning") ?>" data-bs-target="#tab_asset_warning" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_asset_warning" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("asset_warning")) ?>"><?= $Language->tablePhrase("asset_warning", "TblCaption") ?></button></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="<?= $Page->DetailPages->tabContentClasses() ?>"><!-- .tab-content -->
<?php
    if (in_array("asset_facilities", explode(",", $Page->getCurrentDetailTable())) && $asset_facilities->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("asset_facilities") ?><?= $Page->DetailPages->activeClasses("asset_facilities") ?>" id="tab_asset_facilities" role="tabpanel"><!-- page* -->
<?php include_once "AssetFacilitiesGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("asset_pros_detail", explode(",", $Page->getCurrentDetailTable())) && $asset_pros_detail->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("asset_pros_detail") ?><?= $Page->DetailPages->activeClasses("asset_pros_detail") ?>" id="tab_asset_pros_detail" role="tabpanel"><!-- page* -->
<?php include_once "AssetProsDetailGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("asset_banner", explode(",", $Page->getCurrentDetailTable())) && $asset_banner->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("asset_banner") ?><?= $Page->DetailPages->activeClasses("asset_banner") ?>" id="tab_asset_banner" role="tabpanel"><!-- page* -->
<?php include_once "AssetBannerGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("asset_category", explode(",", $Page->getCurrentDetailTable())) && $asset_category->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("asset_category") ?><?= $Page->DetailPages->activeClasses("asset_category") ?>" id="tab_asset_category" role="tabpanel"><!-- page* -->
<?php include_once "AssetCategoryGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("asset_warning", explode(",", $Page->getCurrentDetailTable())) && $asset_warning->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("asset_warning") ?><?= $Page->DetailPages->activeClasses("asset_warning") ?>" id="tab_asset_warning" role="tabpanel"><!-- page* -->
<?php include_once "AssetWarningGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
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
