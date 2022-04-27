<?php

namespace PHPMaker2022\juzmatch;

// Page object
$CancelTheLease = &$Page;
?>
<?php
$Page->showMessage();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// Array
// (
//     [csrf_name] => csrf6200db9b9d2ce
//     [csrf_value] => 6f1d8dddc1e6488b54c6efd5fb2af9ee
//     [asset_id] => 30
//     [reason_check] => Array
//         (
//             [0] => 1
//         )

//     [reason_other] => dfdfh
// )

$asset_id = $_POST['asset_id'];
$reason_check_arr = $_POST['reason_check'];
$reason_other = $_POST['reason_other'];

// echo $asset_id;
// echo "<br>";
// print_r($reason_check_arr);
// echo "<br>";
// echo $reason_other;


$reason_val_arr = [];

for ($i = 0; $i < count($reason_check_arr); $i++) {
    $sql = "SELECT * FROM reason_terminate_contract WHERE reason_id =" . $reason_check_arr[$i];
    $rs_arr = ExecuteRow($sql);
    // print_r($rs_arr['reason_text']);
    $reason_val_arr[] = $rs_arr['reason_text'];
}

// print_r($reason_val_arr);
$reason_str = implode(', ', $reason_val_arr);
// echo $reason_str;


// clone Old Asset to New asset //////////////////////////////////////////////////////////////
$sql_clone_asset = "INSERT INTO asset(title, title_en, brand_id, asset_short_detail, asset_short_detail_en, detail, detail_en, latitude, longitude, tag, price_mark, type_pay, type_pay_2, price, price_special, price_down_max, price_down_special_max, price_down_min, price_down_special_min, bank_appraisal_price, mark_up_price, required_gap, minimum_down_payment, minimum_down_payment_model_a, usable_area_price, land_size_price, installment_price, discount, down_price, down_price_model_a, factor_monthly_installment_over_down, fee_a, commission, reservation_price_max, reservation_price_model_a, monthly_payment_buyer, annual_interest_buyer_model_a, annual_interest_buyer, asset_year_developer, land_size, usable_area, common_fee, transfer_day_expenses_without_business_tax, transfer_day_expenses_with_business_tax, holding_property, num_buildings, num_unit, num_floors, floors, num_parking_spaces, num_bathrooms, num_bedrooms, master_calculator, isactive, is_recommend, expired_date, fee_max, fee_min, monthly_expenses_a, average_rent_a, average_down_payment_a, monthly_expense_max, average_rent_max, average_down_payment_max, monthly_expenses_min, average_rent_min, average_down_payment_min, installment_down_payment_loan, discount_max, minimum_down_payment_max, down_price_max, min_down, remaining_down, address, address_en, district_id, amphur_id, province_id, postcode, factor_financing, credit_limit_down, reservation_price_min, minimum_down_payment_min, down_price_min, discount_min, down_price_min_a, remaining_credit_limit_down, monthly_payment_min, annual_interest_buyer_model_min, `interest_down-payment_financing`, installment_all, floor_plan, layout_unit, asset_website, asset_review, price_invertor, transfer_day_expenses_without_business_tax_max_min, transfer_day_expenses_with_business_tax_max_min, usable_area_price_max, land_size_price_max, usable_area_price_min, land_size_price_min, factor_monthly_installment_over_down_max, monthly_payment_max)
SELECT title, title_en, brand_id, asset_short_detail, asset_short_detail_en, detail, detail_en, latitude, longitude, tag, price_mark, type_pay, type_pay_2, price, price_special, price_down_max, price_down_special_max, price_down_min, price_down_special_min, bank_appraisal_price, mark_up_price, required_gap, minimum_down_payment, minimum_down_payment_model_a, usable_area_price, land_size_price, installment_price, discount, down_price, down_price_model_a, factor_monthly_installment_over_down, fee_a, commission, reservation_price_max, reservation_price_model_a, monthly_payment_buyer, annual_interest_buyer_model_a, annual_interest_buyer, asset_year_developer, land_size, usable_area, common_fee, transfer_day_expenses_without_business_tax, transfer_day_expenses_with_business_tax, holding_property, num_buildings, num_unit, num_floors, floors, num_parking_spaces, num_bathrooms, num_bedrooms, master_calculator, isactive, is_recommend, expired_date, fee_max, fee_min, monthly_expenses_a, average_rent_a, average_down_payment_a, monthly_expense_max, average_rent_max, average_down_payment_max, monthly_expenses_min, average_rent_min, average_down_payment_min, installment_down_payment_loan, discount_max, minimum_down_payment_max, down_price_max, min_down, remaining_down, address, address_en, district_id, amphur_id, province_id, postcode, factor_financing, credit_limit_down, reservation_price_min, minimum_down_payment_min, down_price_min, discount_min, down_price_min_a, remaining_credit_limit_down, monthly_payment_min, annual_interest_buyer_model_min, `interest_down-payment_financing`, installment_all, floor_plan, layout_unit, asset_website, asset_review, price_invertor, transfer_day_expenses_without_business_tax_max_min, transfer_day_expenses_with_business_tax_max_min, usable_area_price_max, land_size_price_max, usable_area_price_min, land_size_price_min, factor_monthly_installment_over_down_max, monthly_payment_max
FROM asset
WHERE asset_id =" . $asset_id;
$res_update_asset = ExecuteStatement($sql_clone_asset);
// END clone Old Asset to New asset //////////////////////////////////////////////////////////

// get prefix asset_code from old asset //////////////////////////////////////////////////////
$sql_prefix_asset_code = "SELECT LEFT(asset_code, 1) AS asset_code_first,asset_code FROM asset WHERE asset_id = $asset_id";
$res_prefix_asset_code = ExecuteRow($sql_prefix_asset_code);
$new_prefix_asset_code = $res_prefix_asset_code['asset_code_first']; // J,B,S

$asset_code = 0;

if ($new_prefix_asset_code == "J") {
    $sql_num_code = "SELECT * FROM `run_number_asset_juzmatch` WHERE 1";
    $rs_num_code = ExecuteRow($sql_num_code);
    $format = '000';
    $count_juzmatch_code = $rs_num_code['num'];
    $code_prefix = "J";
    $ans = substr($format, strlen($count_juzmatch_code)) . $count_juzmatch_code;
    $code_all = $code_prefix . date('ymd') . $ans;
    $sql_set_count_code = "UPDATE `run_number_asset_juzmatch` SET `num`= num+1 WHERE 1";
    $rs_set_count_code = ExecuteStatement($sql_set_count_code);
    $asset_code = $code_all;
} elseif ($new_prefix_asset_code == "B") {
    $sql_num_code = "SELECT * FROM `run_number_asset_buyer` WHERE 1";
    $rs_num_code = ExecuteRow($sql_num_code);
    $format = '000';
    $count_juzmatch_code = $rs_num_code['num'];
    $code_prefix = "B";
    $ans = substr($format, strlen($count_juzmatch_code)) . $count_juzmatch_code;
    $code_all = $code_prefix . date('ymd') . $ans;
    $sql_set_count_code = "UPDATE `run_number_asset_buyer` SET `num`= num+1 WHERE 1";
    $rs_set_count_code = ExecuteStatement($sql_set_count_code);
    $asset_code = $code_all;
} elseif ($new_prefix_asset_code == "S") {
    $sql_num_code = "SELECT * FROM `run_number_asset_seller` WHERE 1";
    $rs_num_code = ExecuteRow($sql_num_code);
    $format = '000';
    $count_juzmatch_code = $rs_num_code['num'];
    $code_prefix = "S";
    $ans = substr($format, strlen($count_juzmatch_code)) . $count_juzmatch_code;
    $code_all = $code_prefix . date('ymd') . $ans;
    $sql_set_count_code = "UPDATE `run_number_asset_seller` SET `num`= num+1 WHERE 1";
    $rs_set_count_code = ExecuteStatement($sql_set_count_code);
    $asset_code = $code_all;
}
//END get prefix asset_code from old asset ///////////////////////////////////////////////////

// get new asset_id //////////////////////////////////////////////////////////////////////////
$sql_new_asset_id = "SELECT MAX(asset_id) as asset_id FROM `asset`";
$res_new_asset_id = ExecuteRow($sql_new_asset_id);
$new_asset_id = $res_new_asset_id['asset_id'];
// END get new asset_id ///////////////////////////////////////////////////////////////////////

// Update new asset data //////////////////////////////////////////////////////////////////////
//? asset_code,
//? asset_status,
//? count_view,
//? count_favorite,
//? order_by,
//? cuser,
//? cdate,
//? cip,
//? uip,
//? udate,
//? uuser,
// update_expired_key,
// update_expired_status,
// update_expired_date,
// update_expired_ip,

$sql_update_new_asset_data = "UPDATE asset SET asset_code = '" . $asset_code . "',asset_status=2,count_view=0,count_favorite=0,order_by=" . ($new_asset_id + 1) . ",cuser='" . CurrentUserID() . "',cdate='" . CurrentDateTime() . "',cip='" . CurrentUserIP() . "',uip='" . CurrentUserIP() . "',udate='" . CurrentDateTime() . "',uuser='" . CurrentUserID() . "' WHERE asset_id = " . $new_asset_id . "";
$res_update_asset = ExecuteStatement($sql_update_new_asset_data);
// print_r($res_update_asset); = 1

// END Update new asset data ////////////////////////////////////////////////////////////////////

// Update sale asset กรณีเป็นทรัพย์ของ seller //////////////////////////////////////////////////////
$sql_check_saller_asset = "SELECT `sale_asset_id`, `asset_id`, `member_id`, `status_live` FROM `sale_asset` WHERE asset_id =" . $asset_id;
$res_check_saller_asset = ExecuteRow($sql_check_saller_asset);
if (count($res_check_saller_asset) <= 0) {
} else {
    $sql_set_count_code = "UPDATE `sale_asset` SET `asset_id`='" . $new_asset_id . "' WHERE asset_id=" . $asset_id;
    ExecuteStatement($sql_set_count_code);
}
// END Update sale asset กรณีเป็นทรัพย์ของ seller //////////////////////////////////////////////////

// clone asset category /////////////////////////////////////////////////////////////////////////
$sql_clone_asset_category = "INSERT INTO `asset_category`(`category_id`, `asset_id`)
SELECT `category_id`, '" . $new_asset_id . "'
FROM asset_category
WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_clone_asset_category);
// END clone asset category /////////////////////////////////////////////////////////////////////

// clone asset banner ///////////////////////////////////////////////////////////////////////////
$sql_clone_asset_banner = "INSERT INTO `asset_banner`(`asset_id`, `image`, `isactive`, `order_by`,cuser,cdate,cip,uip,udate,uuser)
SELECT '" . $new_asset_id . "', `image`, `isactive`, `order_by`,'" . CurrentUserID() . "','" . CurrentDateTime() . "','" . CurrentUserIP() . "','" . CurrentUserIP() . "','" . CurrentDateTime() . "','" . CurrentUserID() . "'
FROM asset_banner
WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_clone_asset_banner);
// END clone asset banner //////////////////////////////////////////////////////////////////////

// clone asset_facilities //////////////////////////////////////////////////////////////////////
$sql_clone_asset_facilities = "INSERT INTO `asset_facilities`(`asset_id`, `master_facilities_group_id`, `master_facilities_id`, `isactive`, `cdate`, `cip`, `cuser`, `udate`, `uip`, `uuser`)
SELECT '" . $new_asset_id . "', `master_facilities_group_id`, `master_facilities_id`, `isactive`, '" . CurrentDateTime() . "','" . CurrentUserIP() . "','" . CurrentUserID() . "','" . CurrentDateTime() . "','" . CurrentUserIP() . "','" . CurrentUserID() . "'
FROM asset_facilities
WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_clone_asset_facilities);
// END clone asset_facilities //////////////////////////////////////////////////////////////////

// clone asset_pros ////////////////////////////////////////////////////////////////////////////
$sql_clone_asset_pros = "INSERT INTO `asset_pros_detail`(`asset_pros_id`, `asset_id`, `detail`, `detail_en`, `cdate`, `cuser`, `cip`, `udate`, `uuser`, `uip`, `isactive`, `group_type`, `latitude`, `longitude`)
SELECT NULL, '" . $new_asset_id . "', `detail`, `detail_en`,'" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "','" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "', `isactive`, `group_type`, `latitude`, `longitude`
FROM asset_pros_detail
WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_clone_asset_pros);
// END clone asset_pros ///////////////////////////////////////////////////////////////////////

// clone buyer booking ////////////////////////////////////////////////////////////////////////
$sql_clone_buyer_booking = "INSERT INTO `buyer_booking_asset`(`member_id`, `asset_id`, `booking_price`, `type`, `date_booking`, `due_date`, `date_payment`, `pay_number`, `status_payment`, `transaction_datetime`, `payment_scheme`, `transaction_ref`, `channel_response_desc`, `res_status`, `res_referenceNo`, `res_paidAgent`, `res_paidChannel`, `res_maskedPan`, `status_expire`, `status_expire_reason`, `cdate`, `cuser`, `cip`, `udate`, `uuser`, `uip`, `receipt_status`, `is_email`)
SELECT NULL, '" . $new_asset_id . "', `booking_price`, `type`, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, `status_expire`, NULL,'" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "','" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "', 0, 0
FROM buyer_booking_asset
WHERE asset_id = " . $asset_id . " AND status_expire = 0 AND status_payment = 2";
ExecuteStatement($sql_clone_buyer_booking);
// END clone buyer booking ////////////////////////////////////////////////////////////////////

// clone buyer_asset_rent /////////////////////////////////////////////////////////////////////
$sql_clone_buyer_down = "INSERT INTO `buyer_asset_rent`(`asset_id`, `member_id`, `one_time_status`, `half_price_1`, `pay_number_half_price_1`, `status_pay_half_price_1`, `date_pay_half_price_1`, `due_date_pay_half_price_1`, `transaction_datetime1`, `payment_scheme1`, `transaction_ref1`, `res_status1`, `channel_response_desc1`, `res_referenceNo1`, `res_paidAgent1`, `res_paidChannel1`, `res_maskedPan1`, `half_price_2`, `status_pay_half_price_2`, `pay_number_half_price_2`, `date_pay_half_price_2`, `due_date_pay_half_price_2`, `transaction_datetime2`, `payment_scheme2`, `transaction_ref2`, `channel_response_desc2`, `res_status2`, `res_referenceNo2`, `res_paidAgent2`, `res_paidChannel2`, `res_maskedPan2`, `status_approve`, `cdate`, `cuser`, `cip`, `udate`, `uuser`, `uip`, `is_email1`, `is_email2`, `receipt_status1`, `receipt_status2`)
SELECT '" . $new_asset_id . "', NULL, `one_time_status`, `half_price_1`, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, `half_price_2`, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0,'" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "','" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "', 0, 0, 0, 0
FROM buyer_asset_rent
WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_clone_buyer_down);
// END clone buyer_asset_rent ////////////////////////////////////////////////////////////////

// clone buyer_config_asset_schedule /////////////////////////////////////////////////////////
$sql_clone_buyer_config_asset_schedule = "INSERT INTO `buyer_config_asset_schedule`(`member_id`, `asset_id`, `installment_all`, `installment_price_per`, `date_start_installment`, `status_approve`, `asset_price`, `booking_price`, `down_price`, `move_in_on_20th`, `number_days_pay_first_month`, `number_days_in_first_month`, `cdate`, `cuser`, `cip`, `udate`, `uuser`, `uip`, `annual_interest`)
SELECT NULL, '" . $new_asset_id . "', `installment_all`, `installment_price_per`, NULL, 0, `asset_price`, `booking_price`, `down_price`, `move_in_on_20th`, `number_days_pay_first_month`, `number_days_in_first_month`,'" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "','" . CurrentDateTime() . "','" . CurrentUserID() . "','" . CurrentUserIP() . "', `annual_interest`
FROM buyer_config_asset_schedule
WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_clone_buyer_config_asset_schedule);
// END clone buyer_config_asset_schedule /////////////////////////////////////////////////////

// get buyer_config_asset_schedule_id //////////////////////////////////////////////////////////////////////////
$sql_old_buyer_config_asset_schedule_id = "SELECT buyer_config_asset_schedule_id FROM `buyer_config_asset_schedule` WHERE asset_id = " . $asset_id;
$res_old_buyer_config_asset_schedule_id = ExecuteRow($sql_old_buyer_config_asset_schedule_id);
$old_buyer_config_asset_schedule_id = $res_old_buyer_config_asset_schedule_id['buyer_config_asset_schedule_id'];
// END get buyer_config_asset_schedule_id ///////////////////////////////////////////////////////////////////////

// get new buyer_config_asset_schedule //////////////////////////////////////////////////////////////////////////
$sql_new_buyer_config_asset_schedule_id = "SELECT MAX(buyer_config_asset_schedule_id) as buyer_config_asset_schedule_id FROM `buyer_config_asset_schedule`";
$res_new_buyer_config_asset_schedule_id = ExecuteRow($sql_new_buyer_config_asset_schedule_id);
$new_buyer_config_asset_schedule_id = $res_new_buyer_config_asset_schedule_id['buyer_config_asset_schedule_id'];
// END get new buyer_config_asset_schedule ///////////////////////////////////////////////////////////////////////

// clone buyer_asset_schedule /////////////////////////////////////////////////////////
$sql_clone_buyer_asset_schedule = "INSERT INTO `buyer_asset_schedule`(`buyer_config_asset_schedule_id`, `asset_id`, `member_id`, `num_installment`, `installment_all`, `installment_per_price`, `interest`, `principal`, `remaining_principal`, `receive_per_installment`, `receive_per_installment_invertor`, `pay_number`, `expired_date`, `date_payment`, `status_payment`, `transaction_datetime`, `payment_scheme`, `transaction_ref`, `channel_response_desc`, `res_status`, `res_referenceNo`, `cuser`, `cdate`, `cip`, `uuser`, `udate`, `uip`, `res_paidAgent`, `res_paidChannel`, `res_maskedPan`, `is_email`, `receipt_status`)
SELECT '" . $new_buyer_config_asset_schedule_id . "', NULL, NULL, `num_installment`, `installment_all`, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL,'" . CurrentUserID() . "','" . CurrentDateTime() . "','" . CurrentUserIP() . "','" . CurrentUserID() . "','" . CurrentDateTime() . "','" . CurrentUserIP() . "', NULL, NULL, NULL, 0, 0
FROM buyer_asset_schedule
WHERE buyer_config_asset_schedule_id = " . $old_buyer_config_asset_schedule_id;
ExecuteStatement($sql_clone_buyer_asset_schedule);
// END clone buyer_asset_schedule /////////////////////////////////////////////////////

// Update Old Asset cancel contract /////////////////////////////////////////////////////////
$sql_update_asset = "UPDATE asset SET is_cancel_contract = 1,cancel_contract_reason='" . $reason_str . "',cancel_contract_reason_detail='" . $reason_other . "',cancel_contract_date='" . CurrentDateTime() . "',cancel_contract_user='" . CurrentUserID() . "',cancel_contract_ip='" . CurrentUserIP() . "' WHERE asset_id =" . $asset_id;
$res_update_asset = ExecuteStatement($sql_update_asset);
// print_r($res_update_asset); = 1

// Update investor booking
$sql_update_investor_booking = "UPDATE `invertor_booking` SET `asset_id` = '". $new_asset_id."' WHERE invertor_booking.asset_id = ".$asset_id;
ExecuteStatement($sql_update_investor_booking);

// Update payment investor booking
$sql_update_payment_investor_booking = "UPDATE `payment_inverter_booking` SET `asset_id` = '". $new_asset_id."' WHERE payment_inverter_booking.asset_id = ".$asset_id;
ExecuteStatement($sql_update_payment_investor_booking);


// Update asset schedule
$sql_update_asset_schedule = "UPDATE asset_schedule SET asset_id = '" . $new_asset_id . "' WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_update_asset_schedule);

// Update investor asset schedule
$sql_update_investor_asset_schedule = "UPDATE invertor_asset_schedule SET asset_id = '" . $new_asset_id . "' WHERE asset_id = " . $asset_id;
ExecuteStatement($sql_update_investor_asset_schedule);


header('Location: https://uatbackend.juzmatch.com/buyerallbookingassetlist');
?>
<table class="table table-striped table-sm ew-view-table">
</table>
<?= GetDebugMessage() ?>
