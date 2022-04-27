<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for asset
 */
class Asset extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-4 col-form-label ew-label";
    public $RightColumnClass = "col-sm-8";
    public $OffsetColumnClass = "col-sm-8 offset-sm-4";
    public $TableLeftColumnClass = "w-col-4";

    // Audit trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Export
    public $ExportDoc;

    // Fields
    public $asset_id;
    public $_title;
    public $title_en;
    public $brand_id;
    public $asset_short_detail;
    public $asset_short_detail_en;
    public $detail;
    public $detail_en;
    public $asset_code;
    public $asset_status;
    public $latitude;
    public $longitude;
    public $num_buildings;
    public $num_unit;
    public $num_floors;
    public $floors;
    public $asset_year_developer;
    public $num_parking_spaces;
    public $num_bathrooms;
    public $num_bedrooms;
    public $address;
    public $address_en;
    public $province_id;
    public $amphur_id;
    public $district_id;
    public $postcode;
    public $floor_plan;
    public $layout_unit;
    public $asset_website;
    public $asset_review;
    public $isactive;
    public $is_recommend;
    public $order_by;
    public $type_pay;
    public $type_pay_2;
    public $price_mark;
    public $holding_property;
    public $common_fee;
    public $usable_area;
    public $usable_area_price;
    public $land_size;
    public $land_size_price;
    public $commission;
    public $transfer_day_expenses_with_business_tax;
    public $transfer_day_expenses_without_business_tax;
    public $price;
    public $discount;
    public $price_special;
    public $reservation_price_model_a;
    public $minimum_down_payment_model_a;
    public $down_price_min_a;
    public $down_price_model_a;
    public $factor_monthly_installment_over_down;
    public $fee_a;
    public $monthly_payment_buyer;
    public $annual_interest_buyer_model_a;
    public $monthly_expenses_a;
    public $average_rent_a;
    public $average_down_payment_a;
    public $transfer_day_expenses_without_business_tax_max_min;
    public $transfer_day_expenses_with_business_tax_max_min;
    public $bank_appraisal_price;
    public $mark_up_price;
    public $required_gap;
    public $minimum_down_payment;
    public $price_down_max;
    public $discount_max;
    public $price_down_special_max;
    public $usable_area_price_max;
    public $land_size_price_max;
    public $reservation_price_max;
    public $minimum_down_payment_max;
    public $down_price_max;
    public $down_price;
    public $factor_monthly_installment_over_down_max;
    public $fee_max;
    public $monthly_payment_max;
    public $annual_interest_buyer;
    public $monthly_expense_max;
    public $average_rent_max;
    public $average_down_payment_max;
    public $min_down;
    public $remaining_down;
    public $factor_financing;
    public $credit_limit_down;
    public $price_down_min;
    public $discount_min;
    public $price_down_special_min;
    public $usable_area_price_min;
    public $land_size_price_min;
    public $reservation_price_min;
    public $minimum_down_payment_min;
    public $down_price_min;
    public $remaining_credit_limit_down;
    public $fee_min;
    public $monthly_payment_min;
    public $annual_interest_buyer_model_min;
    public $interest_downpayment_financing;
    public $monthly_expenses_min;
    public $average_rent_min;
    public $average_down_payment_min;
    public $installment_down_payment_loan;
    public $count_view;
    public $count_favorite;
    public $price_invertor;
    public $installment_price;
    public $installment_all;
    public $master_calculator;
    public $expired_date;
    public $tag;
    public $cdate;
    public $cuser;
    public $cip;
    public $uip;
    public $udate;
    public $uuser;
    public $update_expired_key;
    public $update_expired_status;
    public $update_expired_date;
    public $update_expired_ip;
    public $is_cancel_contract;
    public $cancel_contract_reason;
    public $cancel_contract_reason_detail;
    public $cancel_contract_date;
    public $cancel_contract_user;
    public $cancel_contract_ip;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'asset';
        $this->TableName = 'asset';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`asset`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = true; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // asset_id
        $this->asset_id = new DbField(
            'asset',
            'asset',
            'x_asset_id',
            'asset_id',
            '`asset_id`',
            '`asset_id`',
            3,
            11,
            -1,
            false,
            '`asset_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->asset_id->InputTextType = "text";
        $this->asset_id->IsAutoIncrement = true; // Autoincrement field
        $this->asset_id->IsPrimaryKey = true; // Primary key field
        $this->asset_id->IsForeignKey = true; // Foreign key field
        $this->asset_id->Sortable = false; // Allow sort
        $this->asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_id'] = &$this->asset_id;

        // title
        $this->_title = new DbField(
            'asset',
            'asset',
            'x__title',
            'title',
            '`title`',
            '`title`',
            200,
            255,
            -1,
            false,
            '`title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_title->InputTextType = "text";
        $this->_title->Nullable = false; // NOT NULL field
        $this->_title->Required = true; // Required field
        $this->Fields['title'] = &$this->_title;

        // title_en
        $this->title_en = new DbField(
            'asset',
            'asset',
            'x_title_en',
            'title_en',
            '`title_en`',
            '`title_en`',
            200,
            255,
            -1,
            false,
            '`title_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->title_en->InputTextType = "text";
        $this->title_en->Required = true; // Required field
        $this->Fields['title_en'] = &$this->title_en;

        // brand_id
        $this->brand_id = new DbField(
            'asset',
            'asset',
            'x_brand_id',
            'brand_id',
            '`brand_id`',
            '`brand_id`',
            3,
            11,
            -1,
            false,
            '`brand_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->brand_id->InputTextType = "text";
        $this->brand_id->Nullable = false; // NOT NULL field
        $this->brand_id->Required = true; // Required field
        $this->brand_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->brand_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->brand_id->Lookup = new Lookup('brand_id', 'brand', false, 'brand_id', ["brand_name","","",""], [], [], [], [], [], [], '`brand_name` ASC', '', "`brand_name`");
        $this->brand_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['brand_id'] = &$this->brand_id;

        // asset_short_detail
        $this->asset_short_detail = new DbField(
            'asset',
            'asset',
            'x_asset_short_detail',
            'asset_short_detail',
            '`asset_short_detail`',
            '`asset_short_detail`',
            201,
            65535,
            -1,
            false,
            '`asset_short_detail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->asset_short_detail->InputTextType = "text";
        $this->asset_short_detail->Sortable = false; // Allow sort
        $this->Fields['asset_short_detail'] = &$this->asset_short_detail;

        // asset_short_detail_en
        $this->asset_short_detail_en = new DbField(
            'asset',
            'asset',
            'x_asset_short_detail_en',
            'asset_short_detail_en',
            '`asset_short_detail_en`',
            '`asset_short_detail_en`',
            201,
            65535,
            -1,
            false,
            '`asset_short_detail_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->asset_short_detail_en->InputTextType = "text";
        $this->asset_short_detail_en->Sortable = false; // Allow sort
        $this->Fields['asset_short_detail_en'] = &$this->asset_short_detail_en;

        // detail
        $this->detail = new DbField(
            'asset',
            'asset',
            'x_detail',
            'detail',
            '`detail`',
            '`detail`',
            201,
            65535,
            -1,
            false,
            '`detail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->detail->InputTextType = "text";
        $this->detail->Required = true; // Required field
        $this->Fields['detail'] = &$this->detail;

        // detail_en
        $this->detail_en = new DbField(
            'asset',
            'asset',
            'x_detail_en',
            'detail_en',
            '`detail_en`',
            '`detail_en`',
            201,
            65535,
            -1,
            false,
            '`detail_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->detail_en->InputTextType = "text";
        $this->detail_en->Required = true; // Required field
        $this->Fields['detail_en'] = &$this->detail_en;

        // asset_code
        $this->asset_code = new DbField(
            'asset',
            'asset',
            'x_asset_code',
            'asset_code',
            '`asset_code`',
            '`asset_code`',
            200,
            255,
            -1,
            false,
            '`asset_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_code->InputTextType = "text";
        $this->Fields['asset_code'] = &$this->asset_code;

        // asset_status
        $this->asset_status = new DbField(
            'asset',
            'asset',
            'x_asset_status',
            'asset_status',
            '`asset_status`',
            '`asset_status`',
            3,
            11,
            -1,
            false,
            '`asset_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->asset_status->InputTextType = "text";
        $this->asset_status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->asset_status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->asset_status->Lookup = new Lookup('asset_status', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->asset_status->OptionCount = 8;
        $this->asset_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_status'] = &$this->asset_status;

        // latitude
        $this->latitude = new DbField(
            'asset',
            'asset',
            'x_latitude',
            'latitude',
            '`latitude`',
            '`latitude`',
            200,
            255,
            -1,
            false,
            '`latitude`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->latitude->InputTextType = "text";
        $this->latitude->Required = true; // Required field
        $this->Fields['latitude'] = &$this->latitude;

        // longitude
        $this->longitude = new DbField(
            'asset',
            'asset',
            'x_longitude',
            'longitude',
            '`longitude`',
            '`longitude`',
            200,
            255,
            -1,
            false,
            '`longitude`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->longitude->InputTextType = "text";
        $this->longitude->Required = true; // Required field
        $this->Fields['longitude'] = &$this->longitude;

        // num_buildings
        $this->num_buildings = new DbField(
            'asset',
            'asset',
            'x_num_buildings',
            'num_buildings',
            '`num_buildings`',
            '`num_buildings`',
            3,
            11,
            -1,
            false,
            '`num_buildings`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_buildings->InputTextType = "text";
        $this->num_buildings->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['num_buildings'] = &$this->num_buildings;

        // num_unit
        $this->num_unit = new DbField(
            'asset',
            'asset',
            'x_num_unit',
            'num_unit',
            '`num_unit`',
            '`num_unit`',
            3,
            11,
            -1,
            false,
            '`num_unit`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_unit->InputTextType = "text";
        $this->num_unit->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['num_unit'] = &$this->num_unit;

        // num_floors
        $this->num_floors = new DbField(
            'asset',
            'asset',
            'x_num_floors',
            'num_floors',
            '`num_floors`',
            '`num_floors`',
            3,
            11,
            -1,
            false,
            '`num_floors`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_floors->InputTextType = "text";
        $this->num_floors->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['num_floors'] = &$this->num_floors;

        // floors
        $this->floors = new DbField(
            'asset',
            'asset',
            'x_floors',
            'floors',
            '`floors`',
            '`floors`',
            3,
            11,
            -1,
            false,
            '`floors`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->floors->InputTextType = "text";
        $this->floors->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['floors'] = &$this->floors;

        // asset_year_developer
        $this->asset_year_developer = new DbField(
            'asset',
            'asset',
            'x_asset_year_developer',
            'asset_year_developer',
            '`asset_year_developer`',
            '`asset_year_developer`',
            3,
            11,
            -1,
            false,
            '`asset_year_developer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_year_developer->InputTextType = "text";
        $this->asset_year_developer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_year_developer'] = &$this->asset_year_developer;

        // num_parking_spaces
        $this->num_parking_spaces = new DbField(
            'asset',
            'asset',
            'x_num_parking_spaces',
            'num_parking_spaces',
            '`num_parking_spaces`',
            '`num_parking_spaces`',
            200,
            255,
            -1,
            false,
            '`num_parking_spaces`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_parking_spaces->InputTextType = "text";
        $this->num_parking_spaces->Required = true; // Required field
        $this->Fields['num_parking_spaces'] = &$this->num_parking_spaces;

        // num_bathrooms
        $this->num_bathrooms = new DbField(
            'asset',
            'asset',
            'x_num_bathrooms',
            'num_bathrooms',
            '`num_bathrooms`',
            '`num_bathrooms`',
            200,
            255,
            -1,
            false,
            '`num_bathrooms`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_bathrooms->InputTextType = "text";
        $this->num_bathrooms->Required = true; // Required field
        $this->Fields['num_bathrooms'] = &$this->num_bathrooms;

        // num_bedrooms
        $this->num_bedrooms = new DbField(
            'asset',
            'asset',
            'x_num_bedrooms',
            'num_bedrooms',
            '`num_bedrooms`',
            '`num_bedrooms`',
            200,
            255,
            -1,
            false,
            '`num_bedrooms`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_bedrooms->InputTextType = "text";
        $this->num_bedrooms->Required = true; // Required field
        $this->Fields['num_bedrooms'] = &$this->num_bedrooms;

        // address
        $this->address = new DbField(
            'asset',
            'asset',
            'x_address',
            'address',
            '`address`',
            '`address`',
            201,
            65535,
            -1,
            false,
            '`address`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->address->InputTextType = "text";
        $this->address->Required = true; // Required field
        $this->Fields['address'] = &$this->address;

        // address_en
        $this->address_en = new DbField(
            'asset',
            'asset',
            'x_address_en',
            'address_en',
            '`address_en`',
            '`address_en`',
            201,
            65535,
            -1,
            false,
            '`address_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->address_en->InputTextType = "text";
        $this->address_en->Required = true; // Required field
        $this->Fields['address_en'] = &$this->address_en;

        // province_id
        $this->province_id = new DbField(
            'asset',
            'asset',
            'x_province_id',
            'province_id',
            '`province_id`',
            '`province_id`',
            3,
            11,
            -1,
            false,
            '`province_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->province_id->InputTextType = "text";
        $this->province_id->Required = true; // Required field
        $this->province_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->province_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->province_id->Lookup = new Lookup('province_id', 'province', false, 'province_id', ["province_name","","",""], [], ["x_amphur_id"], [], [], [], [], '`province_name` ASC', '', "`province_name`");
        $this->province_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['province_id'] = &$this->province_id;

        // amphur_id
        $this->amphur_id = new DbField(
            'asset',
            'asset',
            'x_amphur_id',
            'amphur_id',
            '`amphur_id`',
            '`amphur_id`',
            3,
            11,
            -1,
            false,
            '`amphur_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->amphur_id->InputTextType = "text";
        $this->amphur_id->Required = true; // Required field
        $this->amphur_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->amphur_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->amphur_id->Lookup = new Lookup('amphur_id', 'amphur', false, 'amphur_id', ["amphur_name","","",""], ["x_province_id"], ["x_district_id"], ["province_id"], ["x_province_id"], [], [], '`amphur_name` ASC', '', "`amphur_name`");
        $this->amphur_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['amphur_id'] = &$this->amphur_id;

        // district_id
        $this->district_id = new DbField(
            'asset',
            'asset',
            'x_district_id',
            'district_id',
            '`district_id`',
            '`district_id`',
            3,
            11,
            -1,
            false,
            '`district_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->district_id->InputTextType = "text";
        $this->district_id->Required = true; // Required field
        $this->district_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->district_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->district_id->Lookup = new Lookup('district_id', 'subdistrict', false, 'subdistrict_id', ["subdistrict_name","","",""], ["x_amphur_id"], [], ["district_id"], ["x_district_id"], [], [], '`subdistrict_name` ASC', '', "`subdistrict_name`");
        $this->district_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['district_id'] = &$this->district_id;

        // postcode
        $this->postcode = new DbField(
            'asset',
            'asset',
            'x_postcode',
            'postcode',
            '`postcode`',
            '`postcode`',
            3,
            11,
            -1,
            false,
            '`postcode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->postcode->InputTextType = "text";
        $this->postcode->Required = true; // Required field
        $this->postcode->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['postcode'] = &$this->postcode;

        // floor_plan
        $this->floor_plan = new DbField(
            'asset',
            'asset',
            'x_floor_plan',
            'floor_plan',
            '`floor_plan`',
            '`floor_plan`',
            200,
            255,
            -1,
            true,
            '`floor_plan`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->floor_plan->InputTextType = "text";
        $this->floor_plan->UploadAllowedFileExt = "jpg,jpeg,png";
        $this->floor_plan->UploadMaxFileSize = 300000;
        $this->floor_plan->UploadPath = './upload/floor_plan';
        $this->Fields['floor_plan'] = &$this->floor_plan;

        // layout_unit
        $this->layout_unit = new DbField(
            'asset',
            'asset',
            'x_layout_unit',
            'layout_unit',
            '`layout_unit`',
            '`layout_unit`',
            200,
            255,
            -1,
            true,
            '`layout_unit`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->layout_unit->InputTextType = "text";
        $this->layout_unit->UploadAllowedFileExt = "jpg,jpeg,png";
        $this->layout_unit->UploadMaxFileSize = 300000;
        $this->layout_unit->UploadPath = './upload/layout_unit';
        $this->Fields['layout_unit'] = &$this->layout_unit;

        // asset_website
        $this->asset_website = new DbField(
            'asset',
            'asset',
            'x_asset_website',
            'asset_website',
            '`asset_website`',
            '`asset_website`',
            201,
            65535,
            -1,
            false,
            '`asset_website`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->asset_website->InputTextType = "text";
        $this->Fields['asset_website'] = &$this->asset_website;

        // asset_review
        $this->asset_review = new DbField(
            'asset',
            'asset',
            'x_asset_review',
            'asset_review',
            '`asset_review`',
            '`asset_review`',
            201,
            65535,
            -1,
            false,
            '`asset_review`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->asset_review->InputTextType = "text";
        $this->Fields['asset_review'] = &$this->asset_review;

        // isactive
        $this->isactive = new DbField(
            'asset',
            'asset',
            'x_isactive',
            'isactive',
            '`isactive`',
            '`isactive`',
            3,
            11,
            -1,
            false,
            '`isactive`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->isactive->InputTextType = "text";
        $this->isactive->Lookup = new Lookup('isactive', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->isactive->OptionCount = 2;
        $this->isactive->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isactive'] = &$this->isactive;

        // is_recommend
        $this->is_recommend = new DbField(
            'asset',
            'asset',
            'x_is_recommend',
            'is_recommend',
            '`is_recommend`',
            '`is_recommend`',
            3,
            11,
            -1,
            false,
            '`is_recommend`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->is_recommend->InputTextType = "text";
        $this->is_recommend->Nullable = false; // NOT NULL field
        $this->is_recommend->Required = true; // Required field
        $this->is_recommend->Lookup = new Lookup('is_recommend', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->is_recommend->OptionCount = 2;
        $this->is_recommend->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['is_recommend'] = &$this->is_recommend;

        // order_by
        $this->order_by = new DbField(
            'asset',
            'asset',
            'x_order_by',
            'order_by',
            '`order_by`',
            '`order_by`',
            3,
            11,
            -1,
            false,
            '`order_by`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->order_by->InputTextType = "text";
        $this->order_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['order_by'] = &$this->order_by;

        // type_pay
        $this->type_pay = new DbField(
            'asset',
            'asset',
            'x_type_pay',
            'type_pay',
            '`type_pay`',
            '`type_pay`',
            3,
            11,
            -1,
            false,
            '`type_pay`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->type_pay->InputTextType = "text";
        $this->type_pay->Lookup = new Lookup('type_pay', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->type_pay->OptionCount = 1;
        $this->type_pay->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type_pay'] = &$this->type_pay;

        // type_pay_2
        $this->type_pay_2 = new DbField(
            'asset',
            'asset',
            'x_type_pay_2',
            'type_pay_2',
            '`type_pay_2`',
            '`type_pay_2`',
            3,
            11,
            -1,
            false,
            '`type_pay_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->type_pay_2->InputTextType = "text";
        $this->type_pay_2->Lookup = new Lookup('type_pay_2', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->type_pay_2->OptionCount = 1;
        $this->type_pay_2->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type_pay_2'] = &$this->type_pay_2;

        // price_mark
        $this->price_mark = new DbField(
            'asset',
            'asset',
            'x_price_mark',
            'price_mark',
            '`price_mark`',
            '`price_mark`',
            4,
            12,
            -1,
            false,
            '`price_mark`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_mark->InputTextType = "text";
        $this->price_mark->Required = true; // Required field
        $this->price_mark->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_mark'] = &$this->price_mark;

        // holding_property
        $this->holding_property = new DbField(
            'asset',
            'asset',
            'x_holding_property',
            'holding_property',
            '`holding_property`',
            '`holding_property`',
            3,
            11,
            -1,
            false,
            '`holding_property`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->holding_property->InputTextType = "text";
        $this->holding_property->Lookup = new Lookup('holding_property', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->holding_property->OptionCount = 1;
        $this->holding_property->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['holding_property'] = &$this->holding_property;

        // common_fee
        $this->common_fee = new DbField(
            'asset',
            'asset',
            'x_common_fee',
            'common_fee',
            '`common_fee`',
            '`common_fee`',
            4,
            12,
            -1,
            false,
            '`common_fee`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->common_fee->InputTextType = "text";
        $this->common_fee->Required = true; // Required field
        $this->common_fee->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['common_fee'] = &$this->common_fee;

        // usable_area
        $this->usable_area = new DbField(
            'asset',
            'asset',
            'x_usable_area',
            'usable_area',
            '`usable_area`',
            '`usable_area`',
            200,
            255,
            -1,
            false,
            '`usable_area`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->usable_area->InputTextType = "text";
        $this->Fields['usable_area'] = &$this->usable_area;

        // usable_area_price
        $this->usable_area_price = new DbField(
            'asset',
            'asset',
            'x_usable_area_price',
            'usable_area_price',
            '`usable_area_price`',
            '`usable_area_price`',
            4,
            12,
            -1,
            false,
            '`usable_area_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->usable_area_price->InputTextType = "text";
        $this->usable_area_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['usable_area_price'] = &$this->usable_area_price;

        // land_size
        $this->land_size = new DbField(
            'asset',
            'asset',
            'x_land_size',
            'land_size',
            '`land_size`',
            '`land_size`',
            200,
            255,
            -1,
            false,
            '`land_size`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->land_size->InputTextType = "text";
        $this->Fields['land_size'] = &$this->land_size;

        // land_size_price
        $this->land_size_price = new DbField(
            'asset',
            'asset',
            'x_land_size_price',
            'land_size_price',
            '`land_size_price`',
            '`land_size_price`',
            4,
            12,
            -1,
            false,
            '`land_size_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->land_size_price->InputTextType = "text";
        $this->land_size_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['land_size_price'] = &$this->land_size_price;

        // commission
        $this->commission = new DbField(
            'asset',
            'asset',
            'x_commission',
            'commission',
            '`commission`',
            '`commission`',
            4,
            12,
            -1,
            false,
            '`commission`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->commission->InputTextType = "text";
        $this->commission->Required = true; // Required field
        $this->commission->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['commission'] = &$this->commission;

        // transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax = new DbField(
            'asset',
            'asset',
            'x_transfer_day_expenses_with_business_tax',
            'transfer_day_expenses_with_business_tax',
            '`transfer_day_expenses_with_business_tax`',
            '`transfer_day_expenses_with_business_tax`',
            4,
            12,
            -1,
            false,
            '`transfer_day_expenses_with_business_tax`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transfer_day_expenses_with_business_tax->InputTextType = "text";
        $this->transfer_day_expenses_with_business_tax->Required = true; // Required field
        $this->transfer_day_expenses_with_business_tax->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['transfer_day_expenses_with_business_tax'] = &$this->transfer_day_expenses_with_business_tax;

        // transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax = new DbField(
            'asset',
            'asset',
            'x_transfer_day_expenses_without_business_tax',
            'transfer_day_expenses_without_business_tax',
            '`transfer_day_expenses_without_business_tax`',
            '`transfer_day_expenses_without_business_tax`',
            4,
            12,
            -1,
            false,
            '`transfer_day_expenses_without_business_tax`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transfer_day_expenses_without_business_tax->InputTextType = "text";
        $this->transfer_day_expenses_without_business_tax->Required = true; // Required field
        $this->transfer_day_expenses_without_business_tax->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['transfer_day_expenses_without_business_tax'] = &$this->transfer_day_expenses_without_business_tax;

        // price
        $this->price = new DbField(
            'asset',
            'asset',
            'x_price',
            'price',
            '`price`',
            '`price`',
            5,
            22,
            -1,
            false,
            '`price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price->InputTextType = "text";
        $this->price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price'] = &$this->price;

        // discount
        $this->discount = new DbField(
            'asset',
            'asset',
            'x_discount',
            'discount',
            '`discount`',
            '`discount`',
            4,
            12,
            -1,
            false,
            '`discount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->discount->InputTextType = "text";
        $this->discount->Required = true; // Required field
        $this->discount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['discount'] = &$this->discount;

        // price_special
        $this->price_special = new DbField(
            'asset',
            'asset',
            'x_price_special',
            'price_special',
            '`price_special`',
            '`price_special`',
            4,
            12,
            -1,
            false,
            '`price_special`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_special->InputTextType = "text";
        $this->price_special->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_special'] = &$this->price_special;

        // reservation_price_model_a
        $this->reservation_price_model_a = new DbField(
            'asset',
            'asset',
            'x_reservation_price_model_a',
            'reservation_price_model_a',
            '`reservation_price_model_a`',
            '`reservation_price_model_a`',
            4,
            12,
            -1,
            false,
            '`reservation_price_model_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reservation_price_model_a->InputTextType = "text";
        $this->reservation_price_model_a->Required = true; // Required field
        $this->reservation_price_model_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['reservation_price_model_a'] = &$this->reservation_price_model_a;

        // minimum_down_payment_model_a
        $this->minimum_down_payment_model_a = new DbField(
            'asset',
            'asset',
            'x_minimum_down_payment_model_a',
            'minimum_down_payment_model_a',
            '`minimum_down_payment_model_a`',
            '`minimum_down_payment_model_a`',
            4,
            12,
            -1,
            false,
            '`minimum_down_payment_model_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->minimum_down_payment_model_a->InputTextType = "text";
        $this->minimum_down_payment_model_a->Required = true; // Required field
        $this->minimum_down_payment_model_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['minimum_down_payment_model_a'] = &$this->minimum_down_payment_model_a;

        // down_price_min_a
        $this->down_price_min_a = new DbField(
            'asset',
            'asset',
            'x_down_price_min_a',
            'down_price_min_a',
            '`down_price_min_a`',
            '`down_price_min_a`',
            4,
            12,
            -1,
            false,
            '`down_price_min_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_price_min_a->InputTextType = "text";
        $this->down_price_min_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_price_min_a'] = &$this->down_price_min_a;

        // down_price_model_a
        $this->down_price_model_a = new DbField(
            'asset',
            'asset',
            'x_down_price_model_a',
            'down_price_model_a',
            '`down_price_model_a`',
            '`down_price_model_a`',
            4,
            12,
            -1,
            false,
            '`down_price_model_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_price_model_a->InputTextType = "text";
        $this->down_price_model_a->Required = true; // Required field
        $this->down_price_model_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_price_model_a'] = &$this->down_price_model_a;

        // factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down = new DbField(
            'asset',
            'asset',
            'x_factor_monthly_installment_over_down',
            'factor_monthly_installment_over_down',
            '`factor_monthly_installment_over_down`',
            '`factor_monthly_installment_over_down`',
            4,
            12,
            -1,
            false,
            '`factor_monthly_installment_over_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->factor_monthly_installment_over_down->InputTextType = "text";
        $this->factor_monthly_installment_over_down->Required = true; // Required field
        $this->factor_monthly_installment_over_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['factor_monthly_installment_over_down'] = &$this->factor_monthly_installment_over_down;

        // fee_a
        $this->fee_a = new DbField(
            'asset',
            'asset',
            'x_fee_a',
            'fee_a',
            '`fee_a`',
            '`fee_a`',
            4,
            12,
            -1,
            false,
            '`fee_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fee_a->InputTextType = "text";
        $this->fee_a->Required = true; // Required field
        $this->fee_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['fee_a'] = &$this->fee_a;

        // monthly_payment_buyer
        $this->monthly_payment_buyer = new DbField(
            'asset',
            'asset',
            'x_monthly_payment_buyer',
            'monthly_payment_buyer',
            '`monthly_payment_buyer`',
            '`monthly_payment_buyer`',
            4,
            12,
            -1,
            false,
            '`monthly_payment_buyer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_payment_buyer->InputTextType = "text";
        $this->monthly_payment_buyer->Required = true; // Required field
        $this->monthly_payment_buyer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_payment_buyer'] = &$this->monthly_payment_buyer;

        // annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a = new DbField(
            'asset',
            'asset',
            'x_annual_interest_buyer_model_a',
            'annual_interest_buyer_model_a',
            '`annual_interest_buyer_model_a`',
            '`annual_interest_buyer_model_a`',
            4,
            12,
            -1,
            false,
            '`annual_interest_buyer_model_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->annual_interest_buyer_model_a->InputTextType = "text";
        $this->annual_interest_buyer_model_a->Required = true; // Required field
        $this->annual_interest_buyer_model_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['annual_interest_buyer_model_a'] = &$this->annual_interest_buyer_model_a;

        // monthly_expenses_a
        $this->monthly_expenses_a = new DbField(
            'asset',
            'asset',
            'x_monthly_expenses_a',
            'monthly_expenses_a',
            '`monthly_expenses_a`',
            '`monthly_expenses_a`',
            4,
            12,
            -1,
            false,
            '`monthly_expenses_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_expenses_a->InputTextType = "text";
        $this->monthly_expenses_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_expenses_a'] = &$this->monthly_expenses_a;

        // average_rent_a
        $this->average_rent_a = new DbField(
            'asset',
            'asset',
            'x_average_rent_a',
            'average_rent_a',
            '`average_rent_a`',
            '`average_rent_a`',
            4,
            12,
            -1,
            false,
            '`average_rent_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->average_rent_a->InputTextType = "text";
        $this->average_rent_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['average_rent_a'] = &$this->average_rent_a;

        // average_down_payment_a
        $this->average_down_payment_a = new DbField(
            'asset',
            'asset',
            'x_average_down_payment_a',
            'average_down_payment_a',
            '`average_down_payment_a`',
            '`average_down_payment_a`',
            4,
            12,
            -1,
            false,
            '`average_down_payment_a`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->average_down_payment_a->InputTextType = "text";
        $this->average_down_payment_a->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['average_down_payment_a'] = &$this->average_down_payment_a;

        // transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min = new DbField(
            'asset',
            'asset',
            'x_transfer_day_expenses_without_business_tax_max_min',
            'transfer_day_expenses_without_business_tax_max_min',
            '`transfer_day_expenses_without_business_tax_max_min`',
            '`transfer_day_expenses_without_business_tax_max_min`',
            4,
            12,
            -1,
            false,
            '`transfer_day_expenses_without_business_tax_max_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transfer_day_expenses_without_business_tax_max_min->InputTextType = "text";
        $this->transfer_day_expenses_without_business_tax_max_min->Required = true; // Required field
        $this->transfer_day_expenses_without_business_tax_max_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['transfer_day_expenses_without_business_tax_max_min'] = &$this->transfer_day_expenses_without_business_tax_max_min;

        // transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min = new DbField(
            'asset',
            'asset',
            'x_transfer_day_expenses_with_business_tax_max_min',
            'transfer_day_expenses_with_business_tax_max_min',
            '`transfer_day_expenses_with_business_tax_max_min`',
            '`transfer_day_expenses_with_business_tax_max_min`',
            4,
            12,
            -1,
            false,
            '`transfer_day_expenses_with_business_tax_max_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transfer_day_expenses_with_business_tax_max_min->InputTextType = "text";
        $this->transfer_day_expenses_with_business_tax_max_min->Required = true; // Required field
        $this->transfer_day_expenses_with_business_tax_max_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['transfer_day_expenses_with_business_tax_max_min'] = &$this->transfer_day_expenses_with_business_tax_max_min;

        // bank_appraisal_price
        $this->bank_appraisal_price = new DbField(
            'asset',
            'asset',
            'x_bank_appraisal_price',
            'bank_appraisal_price',
            '`bank_appraisal_price`',
            '`bank_appraisal_price`',
            4,
            12,
            -1,
            false,
            '`bank_appraisal_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->bank_appraisal_price->InputTextType = "text";
        $this->bank_appraisal_price->Required = true; // Required field
        $this->bank_appraisal_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['bank_appraisal_price'] = &$this->bank_appraisal_price;

        // mark_up_price
        $this->mark_up_price = new DbField(
            'asset',
            'asset',
            'x_mark_up_price',
            'mark_up_price',
            '`mark_up_price`',
            '`mark_up_price`',
            4,
            12,
            -1,
            false,
            '`mark_up_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->mark_up_price->InputTextType = "text";
        $this->mark_up_price->Required = true; // Required field
        $this->mark_up_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['mark_up_price'] = &$this->mark_up_price;

        // required_gap
        $this->required_gap = new DbField(
            'asset',
            'asset',
            'x_required_gap',
            'required_gap',
            '`required_gap`',
            '`required_gap`',
            4,
            12,
            -1,
            false,
            '`required_gap`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->required_gap->InputTextType = "text";
        $this->required_gap->Required = true; // Required field
        $this->required_gap->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['required_gap'] = &$this->required_gap;

        // minimum_down_payment
        $this->minimum_down_payment = new DbField(
            'asset',
            'asset',
            'x_minimum_down_payment',
            'minimum_down_payment',
            '`minimum_down_payment`',
            '`minimum_down_payment`',
            4,
            12,
            -1,
            false,
            '`minimum_down_payment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->minimum_down_payment->InputTextType = "text";
        $this->minimum_down_payment->Required = true; // Required field
        $this->minimum_down_payment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['minimum_down_payment'] = &$this->minimum_down_payment;

        // price_down_max
        $this->price_down_max = new DbField(
            'asset',
            'asset',
            'x_price_down_max',
            'price_down_max',
            '`price_down_max`',
            '`price_down_max`',
            5,
            22,
            -1,
            false,
            '`price_down_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_down_max->InputTextType = "text";
        $this->price_down_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_down_max'] = &$this->price_down_max;

        // discount_max
        $this->discount_max = new DbField(
            'asset',
            'asset',
            'x_discount_max',
            'discount_max',
            '`discount_max`',
            '`discount_max`',
            4,
            12,
            -1,
            false,
            '`discount_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->discount_max->InputTextType = "text";
        $this->discount_max->Required = true; // Required field
        $this->discount_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['discount_max'] = &$this->discount_max;

        // price_down_special_max
        $this->price_down_special_max = new DbField(
            'asset',
            'asset',
            'x_price_down_special_max',
            'price_down_special_max',
            '`price_down_special_max`',
            '`price_down_special_max`',
            5,
            22,
            -1,
            false,
            '`price_down_special_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_down_special_max->InputTextType = "text";
        $this->price_down_special_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_down_special_max'] = &$this->price_down_special_max;

        // usable_area_price_max
        $this->usable_area_price_max = new DbField(
            'asset',
            'asset',
            'x_usable_area_price_max',
            'usable_area_price_max',
            '`usable_area_price_max`',
            '`usable_area_price_max`',
            4,
            12,
            -1,
            false,
            '`usable_area_price_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->usable_area_price_max->InputTextType = "text";
        $this->usable_area_price_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['usable_area_price_max'] = &$this->usable_area_price_max;

        // land_size_price_max
        $this->land_size_price_max = new DbField(
            'asset',
            'asset',
            'x_land_size_price_max',
            'land_size_price_max',
            '`land_size_price_max`',
            '`land_size_price_max`',
            4,
            12,
            -1,
            false,
            '`land_size_price_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->land_size_price_max->InputTextType = "text";
        $this->land_size_price_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['land_size_price_max'] = &$this->land_size_price_max;

        // reservation_price_max
        $this->reservation_price_max = new DbField(
            'asset',
            'asset',
            'x_reservation_price_max',
            'reservation_price_max',
            '`reservation_price_max`',
            '`reservation_price_max`',
            4,
            12,
            -1,
            false,
            '`reservation_price_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reservation_price_max->InputTextType = "text";
        $this->reservation_price_max->Required = true; // Required field
        $this->reservation_price_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['reservation_price_max'] = &$this->reservation_price_max;

        // minimum_down_payment_max
        $this->minimum_down_payment_max = new DbField(
            'asset',
            'asset',
            'x_minimum_down_payment_max',
            'minimum_down_payment_max',
            '`minimum_down_payment_max`',
            '`minimum_down_payment_max`',
            4,
            12,
            -1,
            false,
            '`minimum_down_payment_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->minimum_down_payment_max->InputTextType = "text";
        $this->minimum_down_payment_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['minimum_down_payment_max'] = &$this->minimum_down_payment_max;

        // down_price_max
        $this->down_price_max = new DbField(
            'asset',
            'asset',
            'x_down_price_max',
            'down_price_max',
            '`down_price_max`',
            '`down_price_max`',
            4,
            12,
            -1,
            false,
            '`down_price_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_price_max->InputTextType = "text";
        $this->down_price_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_price_max'] = &$this->down_price_max;

        // down_price
        $this->down_price = new DbField(
            'asset',
            'asset',
            'x_down_price',
            'down_price',
            '`down_price`',
            '`down_price`',
            4,
            12,
            -1,
            false,
            '`down_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_price->InputTextType = "text";
        $this->down_price->Required = true; // Required field
        $this->down_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_price'] = &$this->down_price;

        // factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max = new DbField(
            'asset',
            'asset',
            'x_factor_monthly_installment_over_down_max',
            'factor_monthly_installment_over_down_max',
            '`factor_monthly_installment_over_down_max`',
            '`factor_monthly_installment_over_down_max`',
            4,
            12,
            -1,
            false,
            '`factor_monthly_installment_over_down_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->factor_monthly_installment_over_down_max->InputTextType = "text";
        $this->factor_monthly_installment_over_down_max->Required = true; // Required field
        $this->factor_monthly_installment_over_down_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['factor_monthly_installment_over_down_max'] = &$this->factor_monthly_installment_over_down_max;

        // fee_max
        $this->fee_max = new DbField(
            'asset',
            'asset',
            'x_fee_max',
            'fee_max',
            '`fee_max`',
            '`fee_max`',
            3,
            11,
            -1,
            false,
            '`fee_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fee_max->InputTextType = "text";
        $this->fee_max->Required = true; // Required field
        $this->fee_max->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['fee_max'] = &$this->fee_max;

        // monthly_payment_max
        $this->monthly_payment_max = new DbField(
            'asset',
            'asset',
            'x_monthly_payment_max',
            'monthly_payment_max',
            '`monthly_payment_max`',
            '`monthly_payment_max`',
            4,
            12,
            -1,
            false,
            '`monthly_payment_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_payment_max->InputTextType = "text";
        $this->monthly_payment_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_payment_max'] = &$this->monthly_payment_max;

        // annual_interest_buyer
        $this->annual_interest_buyer = new DbField(
            'asset',
            'asset',
            'x_annual_interest_buyer',
            'annual_interest_buyer',
            '`annual_interest_buyer`',
            '`annual_interest_buyer`',
            4,
            12,
            -1,
            false,
            '`annual_interest_buyer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->annual_interest_buyer->InputTextType = "text";
        $this->annual_interest_buyer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['annual_interest_buyer'] = &$this->annual_interest_buyer;

        // monthly_expense_max
        $this->monthly_expense_max = new DbField(
            'asset',
            'asset',
            'x_monthly_expense_max',
            'monthly_expense_max',
            '`monthly_expense_max`',
            '`monthly_expense_max`',
            4,
            12,
            -1,
            false,
            '`monthly_expense_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_expense_max->InputTextType = "text";
        $this->monthly_expense_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_expense_max'] = &$this->monthly_expense_max;

        // average_rent_max
        $this->average_rent_max = new DbField(
            'asset',
            'asset',
            'x_average_rent_max',
            'average_rent_max',
            '`average_rent_max`',
            '`average_rent_max`',
            4,
            12,
            -1,
            false,
            '`average_rent_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->average_rent_max->InputTextType = "text";
        $this->average_rent_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['average_rent_max'] = &$this->average_rent_max;

        // average_down_payment_max
        $this->average_down_payment_max = new DbField(
            'asset',
            'asset',
            'x_average_down_payment_max',
            'average_down_payment_max',
            '`average_down_payment_max`',
            '`average_down_payment_max`',
            4,
            12,
            -1,
            false,
            '`average_down_payment_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->average_down_payment_max->InputTextType = "text";
        $this->average_down_payment_max->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['average_down_payment_max'] = &$this->average_down_payment_max;

        // min_down
        $this->min_down = new DbField(
            'asset',
            'asset',
            'x_min_down',
            'min_down',
            '`min_down`',
            '`min_down`',
            4,
            12,
            -1,
            false,
            '`min_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->min_down->InputTextType = "text";
        $this->min_down->Required = true; // Required field
        $this->min_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['min_down'] = &$this->min_down;

        // remaining_down
        $this->remaining_down = new DbField(
            'asset',
            'asset',
            'x_remaining_down',
            'remaining_down',
            '`remaining_down`',
            '`remaining_down`',
            4,
            12,
            -1,
            false,
            '`remaining_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remaining_down->InputTextType = "text";
        $this->remaining_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remaining_down'] = &$this->remaining_down;

        // factor_financing
        $this->factor_financing = new DbField(
            'asset',
            'asset',
            'x_factor_financing',
            'factor_financing',
            '`factor_financing`',
            '`factor_financing`',
            4,
            12,
            -1,
            false,
            '`factor_financing`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->factor_financing->InputTextType = "text";
        $this->factor_financing->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['factor_financing'] = &$this->factor_financing;

        // credit_limit_down
        $this->credit_limit_down = new DbField(
            'asset',
            'asset',
            'x_credit_limit_down',
            'credit_limit_down',
            '`credit_limit_down`',
            '`credit_limit_down`',
            4,
            12,
            -1,
            false,
            '`credit_limit_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->credit_limit_down->InputTextType = "text";
        $this->credit_limit_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['credit_limit_down'] = &$this->credit_limit_down;

        // price_down_min
        $this->price_down_min = new DbField(
            'asset',
            'asset',
            'x_price_down_min',
            'price_down_min',
            '`price_down_min`',
            '`price_down_min`',
            5,
            22,
            -1,
            false,
            '`price_down_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_down_min->InputTextType = "text";
        $this->price_down_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_down_min'] = &$this->price_down_min;

        // discount_min
        $this->discount_min = new DbField(
            'asset',
            'asset',
            'x_discount_min',
            'discount_min',
            '`discount_min`',
            '`discount_min`',
            4,
            12,
            -1,
            false,
            '`discount_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->discount_min->InputTextType = "text";
        $this->discount_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['discount_min'] = &$this->discount_min;

        // price_down_special_min
        $this->price_down_special_min = new DbField(
            'asset',
            'asset',
            'x_price_down_special_min',
            'price_down_special_min',
            '`price_down_special_min`',
            '`price_down_special_min`',
            5,
            22,
            -1,
            false,
            '`price_down_special_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_down_special_min->InputTextType = "text";
        $this->price_down_special_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_down_special_min'] = &$this->price_down_special_min;

        // usable_area_price_min
        $this->usable_area_price_min = new DbField(
            'asset',
            'asset',
            'x_usable_area_price_min',
            'usable_area_price_min',
            '`usable_area_price_min`',
            '`usable_area_price_min`',
            4,
            12,
            -1,
            false,
            '`usable_area_price_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->usable_area_price_min->InputTextType = "text";
        $this->usable_area_price_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['usable_area_price_min'] = &$this->usable_area_price_min;

        // land_size_price_min
        $this->land_size_price_min = new DbField(
            'asset',
            'asset',
            'x_land_size_price_min',
            'land_size_price_min',
            '`land_size_price_min`',
            '`land_size_price_min`',
            4,
            12,
            -1,
            false,
            '`land_size_price_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->land_size_price_min->InputTextType = "text";
        $this->land_size_price_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['land_size_price_min'] = &$this->land_size_price_min;

        // reservation_price_min
        $this->reservation_price_min = new DbField(
            'asset',
            'asset',
            'x_reservation_price_min',
            'reservation_price_min',
            '`reservation_price_min`',
            '`reservation_price_min`',
            4,
            12,
            -1,
            false,
            '`reservation_price_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reservation_price_min->InputTextType = "text";
        $this->reservation_price_min->Required = true; // Required field
        $this->reservation_price_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['reservation_price_min'] = &$this->reservation_price_min;

        // minimum_down_payment_min
        $this->minimum_down_payment_min = new DbField(
            'asset',
            'asset',
            'x_minimum_down_payment_min',
            'minimum_down_payment_min',
            '`minimum_down_payment_min`',
            '`minimum_down_payment_min`',
            4,
            12,
            -1,
            false,
            '`minimum_down_payment_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->minimum_down_payment_min->InputTextType = "text";
        $this->minimum_down_payment_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['minimum_down_payment_min'] = &$this->minimum_down_payment_min;

        // down_price_min
        $this->down_price_min = new DbField(
            'asset',
            'asset',
            'x_down_price_min',
            'down_price_min',
            '`down_price_min`',
            '`down_price_min`',
            4,
            12,
            -1,
            false,
            '`down_price_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_price_min->InputTextType = "text";
        $this->down_price_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_price_min'] = &$this->down_price_min;

        // remaining_credit_limit_down
        $this->remaining_credit_limit_down = new DbField(
            'asset',
            'asset',
            'x_remaining_credit_limit_down',
            'remaining_credit_limit_down',
            '`remaining_credit_limit_down`',
            '`remaining_credit_limit_down`',
            4,
            12,
            -1,
            false,
            '`remaining_credit_limit_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remaining_credit_limit_down->InputTextType = "text";
        $this->remaining_credit_limit_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remaining_credit_limit_down'] = &$this->remaining_credit_limit_down;

        // fee_min
        $this->fee_min = new DbField(
            'asset',
            'asset',
            'x_fee_min',
            'fee_min',
            '`fee_min`',
            '`fee_min`',
            3,
            11,
            -1,
            false,
            '`fee_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fee_min->InputTextType = "text";
        $this->fee_min->Required = true; // Required field
        $this->fee_min->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['fee_min'] = &$this->fee_min;

        // monthly_payment_min
        $this->monthly_payment_min = new DbField(
            'asset',
            'asset',
            'x_monthly_payment_min',
            'monthly_payment_min',
            '`monthly_payment_min`',
            '`monthly_payment_min`',
            4,
            12,
            -1,
            false,
            '`monthly_payment_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_payment_min->InputTextType = "text";
        $this->monthly_payment_min->Required = true; // Required field
        $this->monthly_payment_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_payment_min'] = &$this->monthly_payment_min;

        // annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min = new DbField(
            'asset',
            'asset',
            'x_annual_interest_buyer_model_min',
            'annual_interest_buyer_model_min',
            '`annual_interest_buyer_model_min`',
            '`annual_interest_buyer_model_min`',
            4,
            12,
            -1,
            false,
            '`annual_interest_buyer_model_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->annual_interest_buyer_model_min->InputTextType = "text";
        $this->annual_interest_buyer_model_min->Required = true; // Required field
        $this->annual_interest_buyer_model_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['annual_interest_buyer_model_min'] = &$this->annual_interest_buyer_model_min;

        // interest_down-payment_financing
        $this->interest_downpayment_financing = new DbField(
            'asset',
            'asset',
            'x_interest_downpayment_financing',
            'interest_down-payment_financing',
            '`interest_down-payment_financing`',
            '`interest_down-payment_financing`',
            4,
            12,
            -1,
            false,
            '`interest_down-payment_financing`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->interest_downpayment_financing->InputTextType = "text";
        $this->interest_downpayment_financing->Required = true; // Required field
        $this->interest_downpayment_financing->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['interest_down-payment_financing'] = &$this->interest_downpayment_financing;

        // monthly_expenses_min
        $this->monthly_expenses_min = new DbField(
            'asset',
            'asset',
            'x_monthly_expenses_min',
            'monthly_expenses_min',
            '`monthly_expenses_min`',
            '`monthly_expenses_min`',
            4,
            12,
            -1,
            false,
            '`monthly_expenses_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_expenses_min->InputTextType = "text";
        $this->monthly_expenses_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_expenses_min'] = &$this->monthly_expenses_min;

        // average_rent_min
        $this->average_rent_min = new DbField(
            'asset',
            'asset',
            'x_average_rent_min',
            'average_rent_min',
            '`average_rent_min`',
            '`average_rent_min`',
            4,
            12,
            -1,
            false,
            '`average_rent_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->average_rent_min->InputTextType = "text";
        $this->average_rent_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['average_rent_min'] = &$this->average_rent_min;

        // average_down_payment_min
        $this->average_down_payment_min = new DbField(
            'asset',
            'asset',
            'x_average_down_payment_min',
            'average_down_payment_min',
            '`average_down_payment_min`',
            '`average_down_payment_min`',
            4,
            12,
            -1,
            false,
            '`average_down_payment_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->average_down_payment_min->InputTextType = "text";
        $this->average_down_payment_min->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['average_down_payment_min'] = &$this->average_down_payment_min;

        // installment_down_payment_loan
        $this->installment_down_payment_loan = new DbField(
            'asset',
            'asset',
            'x_installment_down_payment_loan',
            'installment_down_payment_loan',
            '`installment_down_payment_loan`',
            '`installment_down_payment_loan`',
            4,
            12,
            -1,
            false,
            '`installment_down_payment_loan`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment_down_payment_loan->InputTextType = "text";
        $this->installment_down_payment_loan->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['installment_down_payment_loan'] = &$this->installment_down_payment_loan;

        // count_view
        $this->count_view = new DbField(
            'asset',
            'asset',
            'x_count_view',
            'count_view',
            '`count_view`',
            '`count_view`',
            19,
            11,
            -1,
            false,
            '`count_view`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_view->InputTextType = "text";
        $this->count_view->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_view'] = &$this->count_view;

        // count_favorite
        $this->count_favorite = new DbField(
            'asset',
            'asset',
            'x_count_favorite',
            'count_favorite',
            '`count_favorite`',
            '`count_favorite`',
            19,
            11,
            -1,
            false,
            '`count_favorite`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->count_favorite->InputTextType = "text";
        $this->count_favorite->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['count_favorite'] = &$this->count_favorite;

        // price_invertor
        $this->price_invertor = new DbField(
            'asset',
            'asset',
            'x_price_invertor',
            'price_invertor',
            '`price_invertor`',
            '`price_invertor`',
            4,
            12,
            -1,
            false,
            '`price_invertor`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_invertor->InputTextType = "text";
        $this->price_invertor->Required = true; // Required field
        $this->price_invertor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_invertor'] = &$this->price_invertor;

        // installment_price
        $this->installment_price = new DbField(
            'asset',
            'asset',
            'x_installment_price',
            'installment_price',
            '`installment_price`',
            '`installment_price`',
            4,
            12,
            -1,
            false,
            '`installment_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment_price->InputTextType = "text";
        $this->installment_price->Sortable = false; // Allow sort
        $this->installment_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['installment_price'] = &$this->installment_price;

        // installment_all
        $this->installment_all = new DbField(
            'asset',
            'asset',
            'x_installment_all',
            'installment_all',
            '`installment_all`',
            '`installment_all`',
            3,
            11,
            -1,
            false,
            '`installment_all`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment_all->InputTextType = "text";
        $this->installment_all->Sortable = false; // Allow sort
        $this->installment_all->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['installment_all'] = &$this->installment_all;

        // master_calculator
        $this->master_calculator = new DbField(
            'asset',
            'asset',
            'x_master_calculator',
            'master_calculator',
            '`master_calculator`',
            '`master_calculator`',
            3,
            11,
            -1,
            false,
            '`master_calculator`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->master_calculator->InputTextType = "text";
        $this->master_calculator->Required = true; // Required field
        $this->master_calculator->Sortable = false; // Allow sort
        $this->master_calculator->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['master_calculator'] = &$this->master_calculator;

        // expired_date
        $this->expired_date = new DbField(
            'asset',
            'asset',
            'x_expired_date',
            'expired_date',
            '`expired_date`',
            CastDateFieldForLike("`expired_date`", 111, "DB"),
            135,
            19,
            111,
            false,
            '`expired_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->expired_date->InputTextType = "text";
        $this->expired_date->Required = true; // Required field
        $this->expired_date->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['expired_date'] = &$this->expired_date;

        // tag
        $this->tag = new DbField(
            'asset',
            'asset',
            'x_tag',
            'tag',
            '`tag`',
            '`tag`',
            201,
            16777215,
            -1,
            false,
            '`tag`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->tag->InputTextType = "text";
        $this->tag->Sortable = false; // Allow sort
        $this->Fields['tag'] = &$this->tag;

        // cdate
        $this->cdate = new DbField(
            'asset',
            'asset',
            'x_cdate',
            'cdate',
            '`cdate`',
            CastDateFieldForLike("`cdate`", 111, "DB"),
            135,
            19,
            111,
            false,
            '`cdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cdate->InputTextType = "text";
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'asset',
            'asset',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            3,
            11,
            -1,
            false,
            '`cuser`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cuser->InputTextType = "text";
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'asset',
            'asset',
            'x_cip',
            'cip',
            '`cip`',
            '`cip`',
            200,
            255,
            -1,
            false,
            '`cip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cip->InputTextType = "text";
        $this->Fields['cip'] = &$this->cip;

        // uip
        $this->uip = new DbField(
            'asset',
            'asset',
            'x_uip',
            'uip',
            '`uip`',
            '`uip`',
            200,
            255,
            -1,
            false,
            '`uip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->uip->InputTextType = "text";
        $this->Fields['uip'] = &$this->uip;

        // udate
        $this->udate = new DbField(
            'asset',
            'asset',
            'x_udate',
            'udate',
            '`udate`',
            CastDateFieldForLike("`udate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`udate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->udate->InputTextType = "text";
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uuser
        $this->uuser = new DbField(
            'asset',
            'asset',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            3,
            11,
            -1,
            false,
            '`uuser`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->uuser->InputTextType = "text";
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // update_expired_key
        $this->update_expired_key = new DbField(
            'asset',
            'asset',
            'x_update_expired_key',
            'update_expired_key',
            '`update_expired_key`',
            '`update_expired_key`',
            200,
            255,
            -1,
            false,
            '`update_expired_key`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->update_expired_key->InputTextType = "text";
        $this->update_expired_key->Sortable = false; // Allow sort
        $this->Fields['update_expired_key'] = &$this->update_expired_key;

        // update_expired_status
        $this->update_expired_status = new DbField(
            'asset',
            'asset',
            'x_update_expired_status',
            'update_expired_status',
            '`update_expired_status`',
            '`update_expired_status`',
            3,
            11,
            -1,
            false,
            '`update_expired_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->update_expired_status->InputTextType = "text";
        $this->update_expired_status->Sortable = false; // Allow sort
        $this->update_expired_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['update_expired_status'] = &$this->update_expired_status;

        // update_expired_date
        $this->update_expired_date = new DbField(
            'asset',
            'asset',
            'x_update_expired_date',
            'update_expired_date',
            '`update_expired_date`',
            CastDateFieldForLike("`update_expired_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`update_expired_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->update_expired_date->InputTextType = "text";
        $this->update_expired_date->Sortable = false; // Allow sort
        $this->update_expired_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['update_expired_date'] = &$this->update_expired_date;

        // update_expired_ip
        $this->update_expired_ip = new DbField(
            'asset',
            'asset',
            'x_update_expired_ip',
            'update_expired_ip',
            '`update_expired_ip`',
            '`update_expired_ip`',
            200,
            100,
            -1,
            false,
            '`update_expired_ip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->update_expired_ip->InputTextType = "text";
        $this->update_expired_ip->Sortable = false; // Allow sort
        $this->Fields['update_expired_ip'] = &$this->update_expired_ip;

        // is_cancel_contract
        $this->is_cancel_contract = new DbField(
            'asset',
            'asset',
            'x_is_cancel_contract',
            'is_cancel_contract',
            '`is_cancel_contract`',
            '`is_cancel_contract`',
            16,
            1,
            -1,
            false,
            '`is_cancel_contract`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->is_cancel_contract->InputTextType = "text";
        $this->is_cancel_contract->Nullable = false; // NOT NULL field
        $this->is_cancel_contract->Sortable = false; // Allow sort
        $this->is_cancel_contract->DataType = DATATYPE_BOOLEAN;
        $this->is_cancel_contract->Lookup = new Lookup('is_cancel_contract', 'asset', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->is_cancel_contract->OptionCount = 2;
        $this->is_cancel_contract->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['is_cancel_contract'] = &$this->is_cancel_contract;

        // cancel_contract_reason
        $this->cancel_contract_reason = new DbField(
            'asset',
            'asset',
            'x_cancel_contract_reason',
            'cancel_contract_reason',
            '`cancel_contract_reason`',
            '`cancel_contract_reason`',
            200,
            255,
            -1,
            false,
            '`cancel_contract_reason`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cancel_contract_reason->InputTextType = "text";
        $this->cancel_contract_reason->Sortable = false; // Allow sort
        $this->Fields['cancel_contract_reason'] = &$this->cancel_contract_reason;

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail = new DbField(
            'asset',
            'asset',
            'x_cancel_contract_reason_detail',
            'cancel_contract_reason_detail',
            '`cancel_contract_reason_detail`',
            '`cancel_contract_reason_detail`',
            201,
            65535,
            -1,
            false,
            '`cancel_contract_reason_detail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->cancel_contract_reason_detail->InputTextType = "text";
        $this->cancel_contract_reason_detail->Sortable = false; // Allow sort
        $this->Fields['cancel_contract_reason_detail'] = &$this->cancel_contract_reason_detail;

        // cancel_contract_date
        $this->cancel_contract_date = new DbField(
            'asset',
            'asset',
            'x_cancel_contract_date',
            'cancel_contract_date',
            '`cancel_contract_date`',
            CastDateFieldForLike("`cancel_contract_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`cancel_contract_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cancel_contract_date->InputTextType = "text";
        $this->cancel_contract_date->Sortable = false; // Allow sort
        $this->cancel_contract_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['cancel_contract_date'] = &$this->cancel_contract_date;

        // cancel_contract_user
        $this->cancel_contract_user = new DbField(
            'asset',
            'asset',
            'x_cancel_contract_user',
            'cancel_contract_user',
            '`cancel_contract_user`',
            '`cancel_contract_user`',
            3,
            11,
            -1,
            false,
            '`cancel_contract_user`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cancel_contract_user->InputTextType = "text";
        $this->cancel_contract_user->Sortable = false; // Allow sort
        $this->cancel_contract_user->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cancel_contract_user'] = &$this->cancel_contract_user;

        // cancel_contract_ip
        $this->cancel_contract_ip = new DbField(
            'asset',
            'asset',
            'x_cancel_contract_ip',
            'cancel_contract_ip',
            '`cancel_contract_ip`',
            '`cancel_contract_ip`',
            200,
            50,
            -1,
            false,
            '`cancel_contract_ip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cancel_contract_ip->InputTextType = "text";
        $this->cancel_contract_ip->Sortable = false; // Allow sort
        $this->Fields['cancel_contract_ip'] = &$this->cancel_contract_ip;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Multiple column sort
    public function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($ctrl) {
                $orderBy = $this->getSessionOrderBy();
                $arOrderBy = !empty($orderBy) ? explode(", ", $orderBy) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderBy = implode(", ", $arOrderBy);
                $this->setSessionOrderBy($orderBy); // Save to Session
            } else {
                $this->setSessionOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if (!$ctrl) {
                $fld->setSort("");
            }
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "sale_asset") {
            if ($this->asset_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "sale_asset") {
            if ($this->asset_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "sale_asset":
                $key = $keys["asset_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->asset_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`asset_id`=" . QuotedValue($keys["asset_id"], $masterTable->asset_id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "sale_asset":
                return "`asset_id`=" . QuotedValue($masterTable->asset_id->DbValue, $this->asset_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "asset_facilities") {
            $detailUrl = Container("asset_facilities")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "asset_pros_detail") {
            $detailUrl = Container("asset_pros_detail")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "asset_banner") {
            $detailUrl = Container("asset_banner")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "asset_category") {
            $detailUrl = Container("asset_category")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "asset_warning") {
            $detailUrl = Container("asset_warning")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "assetlist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`asset`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->asset_id->setDbValue($conn->lastInsertId());
            $rs['asset_id'] = $this->asset_id->DbValue;
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailOnAdd($rs);
            }
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // Cascade Update detail table 'asset_facilities'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['asset_id']) && $rsold['asset_id'] != $rs['asset_id'])) { // Update detail field 'asset_id'
            $cascadeUpdate = true;
            $rscascade['asset_id'] = $rs['asset_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("asset_facilities")->loadRs("`asset_id` = " . QuotedValue($rsold['asset_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'asset_facilities_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("asset_facilities")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("asset_facilities")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("asset_facilities")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'asset_pros_detail'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['asset_id']) && $rsold['asset_id'] != $rs['asset_id'])) { // Update detail field 'asset_id'
            $cascadeUpdate = true;
            $rscascade['asset_id'] = $rs['asset_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("asset_pros_detail")->loadRs("`asset_id` = " . QuotedValue($rsold['asset_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'asset_pros_detail_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("asset_pros_detail")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("asset_pros_detail")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("asset_pros_detail")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'asset_banner'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['asset_id']) && $rsold['asset_id'] != $rs['asset_id'])) { // Update detail field 'asset_id'
            $cascadeUpdate = true;
            $rscascade['asset_id'] = $rs['asset_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("asset_banner")->loadRs("`asset_id` = " . QuotedValue($rsold['asset_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'asset_banner_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("asset_banner")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("asset_banner")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("asset_banner")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'asset_category'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['asset_id']) && $rsold['asset_id'] != $rs['asset_id'])) { // Update detail field 'asset_id'
            $cascadeUpdate = true;
            $rscascade['asset_id'] = $rs['asset_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("asset_category")->loadRs("`asset_id` = " . QuotedValue($rsold['asset_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'asset_category_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("asset_category")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("asset_category")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("asset_category")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'asset_warning'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['asset_id']) && $rsold['asset_id'] != $rs['asset_id'])) { // Update detail field 'asset_id'
            $cascadeUpdate = true;
            $rscascade['asset_id'] = $rs['asset_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("asset_warning")->loadRs("`asset_id` = " . QuotedValue($rsold['asset_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'asset_warning_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("asset_warning")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("asset_warning")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("asset_warning")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'asset_id';
            if (!array_key_exists($fldname, $rsaudit)) {
                $rsaudit[$fldname] = $rsold[$fldname];
            }
            $this->writeAuditTrailOnEdit($rsold, $rsaudit);
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('asset_id', $rs)) {
                AddFilter($where, QuotedName('asset_id', $this->Dbid) . '=' . QuotedValue($rs['asset_id'], $this->asset_id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;

        // Cascade delete detail table 'asset_facilities'
        $dtlrows = Container("asset_facilities")->loadRs("`asset_id` = " . QuotedValue($rs['asset_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("asset_facilities")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("asset_facilities")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("asset_facilities")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'asset_pros_detail'
        $dtlrows = Container("asset_pros_detail")->loadRs("`asset_id` = " . QuotedValue($rs['asset_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("asset_pros_detail")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("asset_pros_detail")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("asset_pros_detail")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'asset_banner'
        $dtlrows = Container("asset_banner")->loadRs("`asset_id` = " . QuotedValue($rs['asset_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("asset_banner")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("asset_banner")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("asset_banner")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'asset_category'
        $dtlrows = Container("asset_category")->loadRs("`asset_id` = " . QuotedValue($rs['asset_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("asset_category")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("asset_category")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("asset_category")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'asset_warning'
        $dtlrows = Container("asset_warning")->loadRs("`asset_id` = " . QuotedValue($rs['asset_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("asset_warning")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("asset_warning")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("asset_warning")->rowDeleted($dtlrow);
            }
        }
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        if ($success && $this->AuditTrailOnDelete) {
            $this->writeAuditTrailOnDelete($rs);
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->asset_id->DbValue = $row['asset_id'];
        $this->_title->DbValue = $row['title'];
        $this->title_en->DbValue = $row['title_en'];
        $this->brand_id->DbValue = $row['brand_id'];
        $this->asset_short_detail->DbValue = $row['asset_short_detail'];
        $this->asset_short_detail_en->DbValue = $row['asset_short_detail_en'];
        $this->detail->DbValue = $row['detail'];
        $this->detail_en->DbValue = $row['detail_en'];
        $this->asset_code->DbValue = $row['asset_code'];
        $this->asset_status->DbValue = $row['asset_status'];
        $this->latitude->DbValue = $row['latitude'];
        $this->longitude->DbValue = $row['longitude'];
        $this->num_buildings->DbValue = $row['num_buildings'];
        $this->num_unit->DbValue = $row['num_unit'];
        $this->num_floors->DbValue = $row['num_floors'];
        $this->floors->DbValue = $row['floors'];
        $this->asset_year_developer->DbValue = $row['asset_year_developer'];
        $this->num_parking_spaces->DbValue = $row['num_parking_spaces'];
        $this->num_bathrooms->DbValue = $row['num_bathrooms'];
        $this->num_bedrooms->DbValue = $row['num_bedrooms'];
        $this->address->DbValue = $row['address'];
        $this->address_en->DbValue = $row['address_en'];
        $this->province_id->DbValue = $row['province_id'];
        $this->amphur_id->DbValue = $row['amphur_id'];
        $this->district_id->DbValue = $row['district_id'];
        $this->postcode->DbValue = $row['postcode'];
        $this->floor_plan->Upload->DbValue = $row['floor_plan'];
        $this->layout_unit->Upload->DbValue = $row['layout_unit'];
        $this->asset_website->DbValue = $row['asset_website'];
        $this->asset_review->DbValue = $row['asset_review'];
        $this->isactive->DbValue = $row['isactive'];
        $this->is_recommend->DbValue = $row['is_recommend'];
        $this->order_by->DbValue = $row['order_by'];
        $this->type_pay->DbValue = $row['type_pay'];
        $this->type_pay_2->DbValue = $row['type_pay_2'];
        $this->price_mark->DbValue = $row['price_mark'];
        $this->holding_property->DbValue = $row['holding_property'];
        $this->common_fee->DbValue = $row['common_fee'];
        $this->usable_area->DbValue = $row['usable_area'];
        $this->usable_area_price->DbValue = $row['usable_area_price'];
        $this->land_size->DbValue = $row['land_size'];
        $this->land_size_price->DbValue = $row['land_size_price'];
        $this->commission->DbValue = $row['commission'];
        $this->transfer_day_expenses_with_business_tax->DbValue = $row['transfer_day_expenses_with_business_tax'];
        $this->transfer_day_expenses_without_business_tax->DbValue = $row['transfer_day_expenses_without_business_tax'];
        $this->price->DbValue = $row['price'];
        $this->discount->DbValue = $row['discount'];
        $this->price_special->DbValue = $row['price_special'];
        $this->reservation_price_model_a->DbValue = $row['reservation_price_model_a'];
        $this->minimum_down_payment_model_a->DbValue = $row['minimum_down_payment_model_a'];
        $this->down_price_min_a->DbValue = $row['down_price_min_a'];
        $this->down_price_model_a->DbValue = $row['down_price_model_a'];
        $this->factor_monthly_installment_over_down->DbValue = $row['factor_monthly_installment_over_down'];
        $this->fee_a->DbValue = $row['fee_a'];
        $this->monthly_payment_buyer->DbValue = $row['monthly_payment_buyer'];
        $this->annual_interest_buyer_model_a->DbValue = $row['annual_interest_buyer_model_a'];
        $this->monthly_expenses_a->DbValue = $row['monthly_expenses_a'];
        $this->average_rent_a->DbValue = $row['average_rent_a'];
        $this->average_down_payment_a->DbValue = $row['average_down_payment_a'];
        $this->transfer_day_expenses_without_business_tax_max_min->DbValue = $row['transfer_day_expenses_without_business_tax_max_min'];
        $this->transfer_day_expenses_with_business_tax_max_min->DbValue = $row['transfer_day_expenses_with_business_tax_max_min'];
        $this->bank_appraisal_price->DbValue = $row['bank_appraisal_price'];
        $this->mark_up_price->DbValue = $row['mark_up_price'];
        $this->required_gap->DbValue = $row['required_gap'];
        $this->minimum_down_payment->DbValue = $row['minimum_down_payment'];
        $this->price_down_max->DbValue = $row['price_down_max'];
        $this->discount_max->DbValue = $row['discount_max'];
        $this->price_down_special_max->DbValue = $row['price_down_special_max'];
        $this->usable_area_price_max->DbValue = $row['usable_area_price_max'];
        $this->land_size_price_max->DbValue = $row['land_size_price_max'];
        $this->reservation_price_max->DbValue = $row['reservation_price_max'];
        $this->minimum_down_payment_max->DbValue = $row['minimum_down_payment_max'];
        $this->down_price_max->DbValue = $row['down_price_max'];
        $this->down_price->DbValue = $row['down_price'];
        $this->factor_monthly_installment_over_down_max->DbValue = $row['factor_monthly_installment_over_down_max'];
        $this->fee_max->DbValue = $row['fee_max'];
        $this->monthly_payment_max->DbValue = $row['monthly_payment_max'];
        $this->annual_interest_buyer->DbValue = $row['annual_interest_buyer'];
        $this->monthly_expense_max->DbValue = $row['monthly_expense_max'];
        $this->average_rent_max->DbValue = $row['average_rent_max'];
        $this->average_down_payment_max->DbValue = $row['average_down_payment_max'];
        $this->min_down->DbValue = $row['min_down'];
        $this->remaining_down->DbValue = $row['remaining_down'];
        $this->factor_financing->DbValue = $row['factor_financing'];
        $this->credit_limit_down->DbValue = $row['credit_limit_down'];
        $this->price_down_min->DbValue = $row['price_down_min'];
        $this->discount_min->DbValue = $row['discount_min'];
        $this->price_down_special_min->DbValue = $row['price_down_special_min'];
        $this->usable_area_price_min->DbValue = $row['usable_area_price_min'];
        $this->land_size_price_min->DbValue = $row['land_size_price_min'];
        $this->reservation_price_min->DbValue = $row['reservation_price_min'];
        $this->minimum_down_payment_min->DbValue = $row['minimum_down_payment_min'];
        $this->down_price_min->DbValue = $row['down_price_min'];
        $this->remaining_credit_limit_down->DbValue = $row['remaining_credit_limit_down'];
        $this->fee_min->DbValue = $row['fee_min'];
        $this->monthly_payment_min->DbValue = $row['monthly_payment_min'];
        $this->annual_interest_buyer_model_min->DbValue = $row['annual_interest_buyer_model_min'];
        $this->interest_downpayment_financing->DbValue = $row['interest_down-payment_financing'];
        $this->monthly_expenses_min->DbValue = $row['monthly_expenses_min'];
        $this->average_rent_min->DbValue = $row['average_rent_min'];
        $this->average_down_payment_min->DbValue = $row['average_down_payment_min'];
        $this->installment_down_payment_loan->DbValue = $row['installment_down_payment_loan'];
        $this->count_view->DbValue = $row['count_view'];
        $this->count_favorite->DbValue = $row['count_favorite'];
        $this->price_invertor->DbValue = $row['price_invertor'];
        $this->installment_price->DbValue = $row['installment_price'];
        $this->installment_all->DbValue = $row['installment_all'];
        $this->master_calculator->DbValue = $row['master_calculator'];
        $this->expired_date->DbValue = $row['expired_date'];
        $this->tag->DbValue = $row['tag'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->uip->DbValue = $row['uip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->update_expired_key->DbValue = $row['update_expired_key'];
        $this->update_expired_status->DbValue = $row['update_expired_status'];
        $this->update_expired_date->DbValue = $row['update_expired_date'];
        $this->update_expired_ip->DbValue = $row['update_expired_ip'];
        $this->is_cancel_contract->DbValue = $row['is_cancel_contract'];
        $this->cancel_contract_reason->DbValue = $row['cancel_contract_reason'];
        $this->cancel_contract_reason_detail->DbValue = $row['cancel_contract_reason_detail'];
        $this->cancel_contract_date->DbValue = $row['cancel_contract_date'];
        $this->cancel_contract_user->DbValue = $row['cancel_contract_user'];
        $this->cancel_contract_ip->DbValue = $row['cancel_contract_ip'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->floor_plan->OldUploadPath = './upload/floor_plan';
        $oldFiles = EmptyValue($row['floor_plan']) ? [] : [$row['floor_plan']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->floor_plan->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->floor_plan->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $this->layout_unit->OldUploadPath = './upload/layout_unit';
        $oldFiles = EmptyValue($row['layout_unit']) ? [] : [$row['layout_unit']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->layout_unit->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->layout_unit->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`asset_id` = @asset_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->asset_id->CurrentValue : $this->asset_id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->asset_id->CurrentValue = $keys[0];
            } else {
                $this->asset_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('asset_id', $row) ? $row['asset_id'] : null;
        } else {
            $val = $this->asset_id->OldValue !== null ? $this->asset_id->OldValue : $this->asset_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@asset_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("assetlist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "assetview") {
            return $Language->phrase("View");
        } elseif ($pageName == "assetedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "assetadd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "AssetView";
            case Config("API_ADD_ACTION"):
                return "AssetAdd";
            case Config("API_EDIT_ACTION"):
                return "AssetEdit";
            case Config("API_DELETE_ACTION"):
                return "AssetDelete";
            case Config("API_LIST_ACTION"):
                return "AssetList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "assetlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("assetview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("assetview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "assetadd?" . $this->getUrlParm($parm);
        } else {
            $url = "assetadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("assetedit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("assetedit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("assetadd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("assetadd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("assetdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "sale_asset" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"asset_id\":" . JsonEncode($this->asset_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->asset_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->asset_id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-sort-url="' . $sortUrl . '" data-sort-type="2"';
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("asset_id") ?? Route("asset_id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->asset_id->CurrentValue = $key;
            } else {
                $this->asset_id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->asset_id->setDbValue($row['asset_id']);
        $this->_title->setDbValue($row['title']);
        $this->title_en->setDbValue($row['title_en']);
        $this->brand_id->setDbValue($row['brand_id']);
        $this->asset_short_detail->setDbValue($row['asset_short_detail']);
        $this->asset_short_detail_en->setDbValue($row['asset_short_detail_en']);
        $this->detail->setDbValue($row['detail']);
        $this->detail_en->setDbValue($row['detail_en']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->asset_status->setDbValue($row['asset_status']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->num_buildings->setDbValue($row['num_buildings']);
        $this->num_unit->setDbValue($row['num_unit']);
        $this->num_floors->setDbValue($row['num_floors']);
        $this->floors->setDbValue($row['floors']);
        $this->asset_year_developer->setDbValue($row['asset_year_developer']);
        $this->num_parking_spaces->setDbValue($row['num_parking_spaces']);
        $this->num_bathrooms->setDbValue($row['num_bathrooms']);
        $this->num_bedrooms->setDbValue($row['num_bedrooms']);
        $this->address->setDbValue($row['address']);
        $this->address_en->setDbValue($row['address_en']);
        $this->province_id->setDbValue($row['province_id']);
        $this->amphur_id->setDbValue($row['amphur_id']);
        $this->district_id->setDbValue($row['district_id']);
        $this->postcode->setDbValue($row['postcode']);
        $this->floor_plan->Upload->DbValue = $row['floor_plan'];
        $this->layout_unit->Upload->DbValue = $row['layout_unit'];
        $this->asset_website->setDbValue($row['asset_website']);
        $this->asset_review->setDbValue($row['asset_review']);
        $this->isactive->setDbValue($row['isactive']);
        $this->is_recommend->setDbValue($row['is_recommend']);
        $this->order_by->setDbValue($row['order_by']);
        $this->type_pay->setDbValue($row['type_pay']);
        $this->type_pay_2->setDbValue($row['type_pay_2']);
        $this->price_mark->setDbValue($row['price_mark']);
        $this->holding_property->setDbValue($row['holding_property']);
        $this->common_fee->setDbValue($row['common_fee']);
        $this->usable_area->setDbValue($row['usable_area']);
        $this->usable_area_price->setDbValue($row['usable_area_price']);
        $this->land_size->setDbValue($row['land_size']);
        $this->land_size_price->setDbValue($row['land_size_price']);
        $this->commission->setDbValue($row['commission']);
        $this->transfer_day_expenses_with_business_tax->setDbValue($row['transfer_day_expenses_with_business_tax']);
        $this->transfer_day_expenses_without_business_tax->setDbValue($row['transfer_day_expenses_without_business_tax']);
        $this->price->setDbValue($row['price']);
        $this->discount->setDbValue($row['discount']);
        $this->price_special->setDbValue($row['price_special']);
        $this->reservation_price_model_a->setDbValue($row['reservation_price_model_a']);
        $this->minimum_down_payment_model_a->setDbValue($row['minimum_down_payment_model_a']);
        $this->down_price_min_a->setDbValue($row['down_price_min_a']);
        $this->down_price_model_a->setDbValue($row['down_price_model_a']);
        $this->factor_monthly_installment_over_down->setDbValue($row['factor_monthly_installment_over_down']);
        $this->fee_a->setDbValue($row['fee_a']);
        $this->monthly_payment_buyer->setDbValue($row['monthly_payment_buyer']);
        $this->annual_interest_buyer_model_a->setDbValue($row['annual_interest_buyer_model_a']);
        $this->monthly_expenses_a->setDbValue($row['monthly_expenses_a']);
        $this->average_rent_a->setDbValue($row['average_rent_a']);
        $this->average_down_payment_a->setDbValue($row['average_down_payment_a']);
        $this->transfer_day_expenses_without_business_tax_max_min->setDbValue($row['transfer_day_expenses_without_business_tax_max_min']);
        $this->transfer_day_expenses_with_business_tax_max_min->setDbValue($row['transfer_day_expenses_with_business_tax_max_min']);
        $this->bank_appraisal_price->setDbValue($row['bank_appraisal_price']);
        $this->mark_up_price->setDbValue($row['mark_up_price']);
        $this->required_gap->setDbValue($row['required_gap']);
        $this->minimum_down_payment->setDbValue($row['minimum_down_payment']);
        $this->price_down_max->setDbValue($row['price_down_max']);
        $this->discount_max->setDbValue($row['discount_max']);
        $this->price_down_special_max->setDbValue($row['price_down_special_max']);
        $this->usable_area_price_max->setDbValue($row['usable_area_price_max']);
        $this->land_size_price_max->setDbValue($row['land_size_price_max']);
        $this->reservation_price_max->setDbValue($row['reservation_price_max']);
        $this->minimum_down_payment_max->setDbValue($row['minimum_down_payment_max']);
        $this->down_price_max->setDbValue($row['down_price_max']);
        $this->down_price->setDbValue($row['down_price']);
        $this->factor_monthly_installment_over_down_max->setDbValue($row['factor_monthly_installment_over_down_max']);
        $this->fee_max->setDbValue($row['fee_max']);
        $this->monthly_payment_max->setDbValue($row['monthly_payment_max']);
        $this->annual_interest_buyer->setDbValue($row['annual_interest_buyer']);
        $this->monthly_expense_max->setDbValue($row['monthly_expense_max']);
        $this->average_rent_max->setDbValue($row['average_rent_max']);
        $this->average_down_payment_max->setDbValue($row['average_down_payment_max']);
        $this->min_down->setDbValue($row['min_down']);
        $this->remaining_down->setDbValue($row['remaining_down']);
        $this->factor_financing->setDbValue($row['factor_financing']);
        $this->credit_limit_down->setDbValue($row['credit_limit_down']);
        $this->price_down_min->setDbValue($row['price_down_min']);
        $this->discount_min->setDbValue($row['discount_min']);
        $this->price_down_special_min->setDbValue($row['price_down_special_min']);
        $this->usable_area_price_min->setDbValue($row['usable_area_price_min']);
        $this->land_size_price_min->setDbValue($row['land_size_price_min']);
        $this->reservation_price_min->setDbValue($row['reservation_price_min']);
        $this->minimum_down_payment_min->setDbValue($row['minimum_down_payment_min']);
        $this->down_price_min->setDbValue($row['down_price_min']);
        $this->remaining_credit_limit_down->setDbValue($row['remaining_credit_limit_down']);
        $this->fee_min->setDbValue($row['fee_min']);
        $this->monthly_payment_min->setDbValue($row['monthly_payment_min']);
        $this->annual_interest_buyer_model_min->setDbValue($row['annual_interest_buyer_model_min']);
        $this->interest_downpayment_financing->setDbValue($row['interest_down-payment_financing']);
        $this->monthly_expenses_min->setDbValue($row['monthly_expenses_min']);
        $this->average_rent_min->setDbValue($row['average_rent_min']);
        $this->average_down_payment_min->setDbValue($row['average_down_payment_min']);
        $this->installment_down_payment_loan->setDbValue($row['installment_down_payment_loan']);
        $this->count_view->setDbValue($row['count_view']);
        $this->count_favorite->setDbValue($row['count_favorite']);
        $this->price_invertor->setDbValue($row['price_invertor']);
        $this->installment_price->setDbValue($row['installment_price']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->master_calculator->setDbValue($row['master_calculator']);
        $this->expired_date->setDbValue($row['expired_date']);
        $this->tag->setDbValue($row['tag']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->update_expired_key->setDbValue($row['update_expired_key']);
        $this->update_expired_status->setDbValue($row['update_expired_status']);
        $this->update_expired_date->setDbValue($row['update_expired_date']);
        $this->update_expired_ip->setDbValue($row['update_expired_ip']);
        $this->is_cancel_contract->setDbValue($row['is_cancel_contract']);
        $this->cancel_contract_reason->setDbValue($row['cancel_contract_reason']);
        $this->cancel_contract_reason_detail->setDbValue($row['cancel_contract_reason_detail']);
        $this->cancel_contract_date->setDbValue($row['cancel_contract_date']);
        $this->cancel_contract_user->setDbValue($row['cancel_contract_user']);
        $this->cancel_contract_ip->setDbValue($row['cancel_contract_ip']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // asset_id

        // title

        // title_en

        // brand_id

        // asset_short_detail
        $this->asset_short_detail->CellCssStyle = "white-space: nowrap;";

        // asset_short_detail_en
        $this->asset_short_detail_en->CellCssStyle = "white-space: nowrap;";

        // detail

        // detail_en

        // asset_code

        // asset_status

        // latitude

        // longitude

        // num_buildings

        // num_unit

        // num_floors

        // floors

        // asset_year_developer

        // num_parking_spaces

        // num_bathrooms

        // num_bedrooms

        // address

        // address_en

        // province_id

        // amphur_id

        // district_id

        // postcode

        // floor_plan

        // layout_unit

        // asset_website

        // asset_review

        // isactive

        // is_recommend

        // order_by

        // type_pay

        // type_pay_2

        // price_mark

        // holding_property

        // common_fee

        // usable_area

        // usable_area_price

        // land_size

        // land_size_price

        // commission

        // transfer_day_expenses_with_business_tax

        // transfer_day_expenses_without_business_tax

        // price

        // discount

        // price_special

        // reservation_price_model_a

        // minimum_down_payment_model_a

        // down_price_min_a

        // down_price_model_a

        // factor_monthly_installment_over_down

        // fee_a

        // monthly_payment_buyer

        // annual_interest_buyer_model_a

        // monthly_expenses_a

        // average_rent_a

        // average_down_payment_a

        // transfer_day_expenses_without_business_tax_max_min

        // transfer_day_expenses_with_business_tax_max_min

        // bank_appraisal_price

        // mark_up_price

        // required_gap

        // minimum_down_payment

        // price_down_max

        // discount_max

        // price_down_special_max

        // usable_area_price_max

        // land_size_price_max

        // reservation_price_max

        // minimum_down_payment_max

        // down_price_max

        // down_price

        // factor_monthly_installment_over_down_max

        // fee_max

        // monthly_payment_max

        // annual_interest_buyer

        // monthly_expense_max

        // average_rent_max

        // average_down_payment_max

        // min_down

        // remaining_down

        // factor_financing

        // credit_limit_down

        // price_down_min

        // discount_min

        // price_down_special_min

        // usable_area_price_min

        // land_size_price_min

        // reservation_price_min

        // minimum_down_payment_min

        // down_price_min

        // remaining_credit_limit_down

        // fee_min

        // monthly_payment_min

        // annual_interest_buyer_model_min

        // interest_down-payment_financing

        // monthly_expenses_min

        // average_rent_min

        // average_down_payment_min

        // installment_down_payment_loan

        // count_view

        // count_favorite

        // price_invertor

        // installment_price
        $this->installment_price->CellCssStyle = "white-space: nowrap;";

        // installment_all
        $this->installment_all->CellCssStyle = "white-space: nowrap;";

        // master_calculator
        $this->master_calculator->CellCssStyle = "white-space: nowrap;";

        // expired_date

        // tag
        $this->tag->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // uip

        // udate

        // uuser

        // update_expired_key
        $this->update_expired_key->CellCssStyle = "white-space: nowrap;";

        // update_expired_status
        $this->update_expired_status->CellCssStyle = "white-space: nowrap;";

        // update_expired_date
        $this->update_expired_date->CellCssStyle = "white-space: nowrap;";

        // update_expired_ip
        $this->update_expired_ip->CellCssStyle = "white-space: nowrap;";

        // is_cancel_contract
        $this->is_cancel_contract->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_reason
        $this->cancel_contract_reason->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_date
        $this->cancel_contract_date->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_user
        $this->cancel_contract_user->CellCssStyle = "white-space: nowrap;";

        // cancel_contract_ip
        $this->cancel_contract_ip->CellCssStyle = "white-space: nowrap;";

        // asset_id
        $this->asset_id->ViewValue = $this->asset_id->CurrentValue;
        $this->asset_id->ViewCustomAttributes = "";

        // title
        $this->_title->ViewValue = $this->_title->CurrentValue;
        $this->_title->ViewCustomAttributes = "";

        // title_en
        $this->title_en->ViewValue = $this->title_en->CurrentValue;
        $this->title_en->ViewCustomAttributes = "";

        // brand_id
        $curVal = strval($this->brand_id->CurrentValue);
        if ($curVal != "") {
            $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
            if ($this->brand_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`brand_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`isactive` =1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->brand_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->brand_id->Lookup->renderViewRow($rswrk[0]);
                    $this->brand_id->ViewValue = $this->brand_id->displayValue($arwrk);
                } else {
                    $this->brand_id->ViewValue = FormatNumber($this->brand_id->CurrentValue, $this->brand_id->formatPattern());
                }
            }
        } else {
            $this->brand_id->ViewValue = null;
        }
        $this->brand_id->ViewCustomAttributes = "";

        // asset_short_detail
        $this->asset_short_detail->ViewValue = $this->asset_short_detail->CurrentValue;
        $this->asset_short_detail->ViewCustomAttributes = "";

        // asset_short_detail_en
        $this->asset_short_detail_en->ViewValue = $this->asset_short_detail_en->CurrentValue;
        $this->asset_short_detail_en->ViewCustomAttributes = "";

        // detail
        $this->detail->ViewValue = $this->detail->CurrentValue;
        $this->detail->ViewCustomAttributes = "";

        // detail_en
        $this->detail_en->ViewValue = $this->detail_en->CurrentValue;
        $this->detail_en->ViewCustomAttributes = "";

        // asset_code
        $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
        $this->asset_code->ViewCustomAttributes = "";

        // asset_status
        if (strval($this->asset_status->CurrentValue) != "") {
            $this->asset_status->ViewValue = $this->asset_status->optionCaption($this->asset_status->CurrentValue);
        } else {
            $this->asset_status->ViewValue = null;
        }
        $this->asset_status->ViewCustomAttributes = "";

        // latitude
        $this->latitude->ViewValue = $this->latitude->CurrentValue;
        $this->latitude->ViewCustomAttributes = "";

        // longitude
        $this->longitude->ViewValue = $this->longitude->CurrentValue;
        $this->longitude->ViewCustomAttributes = "";

        // num_buildings
        $this->num_buildings->ViewValue = $this->num_buildings->CurrentValue;
        $this->num_buildings->ViewValue = FormatNumber($this->num_buildings->ViewValue, $this->num_buildings->formatPattern());
        $this->num_buildings->ViewCustomAttributes = "";

        // num_unit
        $this->num_unit->ViewValue = $this->num_unit->CurrentValue;
        $this->num_unit->ViewValue = FormatNumber($this->num_unit->ViewValue, $this->num_unit->formatPattern());
        $this->num_unit->ViewCustomAttributes = "";

        // num_floors
        $this->num_floors->ViewValue = $this->num_floors->CurrentValue;
        $this->num_floors->ViewValue = FormatNumber($this->num_floors->ViewValue, $this->num_floors->formatPattern());
        $this->num_floors->ViewCustomAttributes = "";

        // floors
        $this->floors->ViewValue = $this->floors->CurrentValue;
        $this->floors->ViewValue = FormatNumber($this->floors->ViewValue, $this->floors->formatPattern());
        $this->floors->ViewCustomAttributes = "";

        // asset_year_developer
        $this->asset_year_developer->ViewValue = $this->asset_year_developer->CurrentValue;
        $this->asset_year_developer->ViewCustomAttributes = "";

        // num_parking_spaces
        $this->num_parking_spaces->ViewValue = $this->num_parking_spaces->CurrentValue;
        $this->num_parking_spaces->ViewCustomAttributes = "";

        // num_bathrooms
        $this->num_bathrooms->ViewValue = $this->num_bathrooms->CurrentValue;
        $this->num_bathrooms->ViewCustomAttributes = "";

        // num_bedrooms
        $this->num_bedrooms->ViewValue = $this->num_bedrooms->CurrentValue;
        $this->num_bedrooms->ViewCustomAttributes = "";

        // address
        $this->address->ViewValue = $this->address->CurrentValue;
        $this->address->ViewCustomAttributes = "";

        // address_en
        $this->address_en->ViewValue = $this->address_en->CurrentValue;
        $this->address_en->ViewCustomAttributes = "";

        // province_id
        $curVal = strval($this->province_id->CurrentValue);
        if ($curVal != "") {
            $this->province_id->ViewValue = $this->province_id->lookupCacheOption($curVal);
            if ($this->province_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`province_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->province_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->province_id->Lookup->renderViewRow($rswrk[0]);
                    $this->province_id->ViewValue = $this->province_id->displayValue($arwrk);
                } else {
                    $this->province_id->ViewValue = FormatNumber($this->province_id->CurrentValue, $this->province_id->formatPattern());
                }
            }
        } else {
            $this->province_id->ViewValue = null;
        }
        $this->province_id->ViewCustomAttributes = "";

        // amphur_id
        $curVal = strval($this->amphur_id->CurrentValue);
        if ($curVal != "") {
            $this->amphur_id->ViewValue = $this->amphur_id->lookupCacheOption($curVal);
            if ($this->amphur_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`amphur_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->amphur_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->amphur_id->Lookup->renderViewRow($rswrk[0]);
                    $this->amphur_id->ViewValue = $this->amphur_id->displayValue($arwrk);
                } else {
                    $this->amphur_id->ViewValue = FormatNumber($this->amphur_id->CurrentValue, $this->amphur_id->formatPattern());
                }
            }
        } else {
            $this->amphur_id->ViewValue = null;
        }
        $this->amphur_id->ViewCustomAttributes = "";

        // district_id
        $curVal = strval($this->district_id->CurrentValue);
        if ($curVal != "") {
            $this->district_id->ViewValue = $this->district_id->lookupCacheOption($curVal);
            if ($this->district_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`subdistrict_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->district_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->district_id->Lookup->renderViewRow($rswrk[0]);
                    $this->district_id->ViewValue = $this->district_id->displayValue($arwrk);
                } else {
                    $this->district_id->ViewValue = FormatNumber($this->district_id->CurrentValue, $this->district_id->formatPattern());
                }
            }
        } else {
            $this->district_id->ViewValue = null;
        }
        $this->district_id->ViewCustomAttributes = "";

        // postcode
        $this->postcode->ViewValue = $this->postcode->CurrentValue;
        $this->postcode->ViewCustomAttributes = "";

        // floor_plan
        $this->floor_plan->UploadPath = './upload/floor_plan';
        if (!EmptyValue($this->floor_plan->Upload->DbValue)) {
            $this->floor_plan->ImageWidth = 100;
            $this->floor_plan->ImageHeight = 100;
            $this->floor_plan->ImageAlt = $this->floor_plan->alt();
            $this->floor_plan->ImageCssClass = "ew-image";
            $this->floor_plan->ViewValue = $this->floor_plan->Upload->DbValue;
        } else {
            $this->floor_plan->ViewValue = "";
        }
        $this->floor_plan->ViewCustomAttributes = "";

        // layout_unit
        $this->layout_unit->UploadPath = './upload/layout_unit';
        if (!EmptyValue($this->layout_unit->Upload->DbValue)) {
            $this->layout_unit->ImageWidth = 100;
            $this->layout_unit->ImageHeight = 100;
            $this->layout_unit->ImageAlt = $this->layout_unit->alt();
            $this->layout_unit->ImageCssClass = "ew-image";
            $this->layout_unit->ViewValue = $this->layout_unit->Upload->DbValue;
        } else {
            $this->layout_unit->ViewValue = "";
        }
        $this->layout_unit->ViewCustomAttributes = "";

        // asset_website
        $this->asset_website->ViewValue = $this->asset_website->CurrentValue;
        $this->asset_website->ViewCustomAttributes = "";

        // asset_review
        $this->asset_review->ViewValue = $this->asset_review->CurrentValue;
        $this->asset_review->ViewCustomAttributes = "";

        // isactive
        if (strval($this->isactive->CurrentValue) != "") {
            $this->isactive->ViewValue = $this->isactive->optionCaption($this->isactive->CurrentValue);
        } else {
            $this->isactive->ViewValue = null;
        }
        $this->isactive->ViewCustomAttributes = "";

        // is_recommend
        if (strval($this->is_recommend->CurrentValue) != "") {
            $this->is_recommend->ViewValue = $this->is_recommend->optionCaption($this->is_recommend->CurrentValue);
        } else {
            $this->is_recommend->ViewValue = null;
        }
        $this->is_recommend->ViewCustomAttributes = "";

        // order_by
        $this->order_by->ViewValue = $this->order_by->CurrentValue;
        $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
        $this->order_by->ViewCustomAttributes = "";

        // type_pay
        if (strval($this->type_pay->CurrentValue) != "") {
            $this->type_pay->ViewValue = new OptionValues();
            $arwrk = explode(",", strval($this->type_pay->CurrentValue));
            $cnt = count($arwrk);
            for ($ari = 0; $ari < $cnt; $ari++)
                $this->type_pay->ViewValue->add($this->type_pay->optionCaption(trim($arwrk[$ari])));
        } else {
            $this->type_pay->ViewValue = null;
        }
        $this->type_pay->ViewCustomAttributes = "";

        // type_pay_2
        if (strval($this->type_pay_2->CurrentValue) != "") {
            $this->type_pay_2->ViewValue = new OptionValues();
            $arwrk = explode(",", strval($this->type_pay_2->CurrentValue));
            $cnt = count($arwrk);
            for ($ari = 0; $ari < $cnt; $ari++)
                $this->type_pay_2->ViewValue->add($this->type_pay_2->optionCaption(trim($arwrk[$ari])));
        } else {
            $this->type_pay_2->ViewValue = null;
        }
        $this->type_pay_2->ViewCustomAttributes = "";

        // price_mark
        $this->price_mark->ViewValue = $this->price_mark->CurrentValue;
        $this->price_mark->ViewValue = FormatCurrency($this->price_mark->ViewValue, $this->price_mark->formatPattern());
        $this->price_mark->ViewCustomAttributes = "";

        // holding_property
        if (strval($this->holding_property->CurrentValue) != "") {
            $this->holding_property->ViewValue = new OptionValues();
            $arwrk = explode(",", strval($this->holding_property->CurrentValue));
            $cnt = count($arwrk);
            for ($ari = 0; $ari < $cnt; $ari++)
                $this->holding_property->ViewValue->add($this->holding_property->optionCaption(trim($arwrk[$ari])));
        } else {
            $this->holding_property->ViewValue = null;
        }
        $this->holding_property->ViewCustomAttributes = "";

        // common_fee
        $this->common_fee->ViewValue = $this->common_fee->CurrentValue;
        $this->common_fee->ViewValue = FormatCurrency($this->common_fee->ViewValue, $this->common_fee->formatPattern());
        $this->common_fee->ViewCustomAttributes = "";

        // usable_area
        $this->usable_area->ViewValue = $this->usable_area->CurrentValue;
        $this->usable_area->ViewCustomAttributes = "";

        // usable_area_price
        $this->usable_area_price->ViewValue = $this->usable_area_price->CurrentValue;
        $this->usable_area_price->ViewValue = FormatNumber($this->usable_area_price->ViewValue, $this->usable_area_price->formatPattern());
        $this->usable_area_price->ViewCustomAttributes = "";

        // land_size
        $this->land_size->ViewValue = $this->land_size->CurrentValue;
        $this->land_size->ViewCustomAttributes = "";

        // land_size_price
        $this->land_size_price->ViewValue = $this->land_size_price->CurrentValue;
        $this->land_size_price->ViewValue = FormatNumber($this->land_size_price->ViewValue, $this->land_size_price->formatPattern());
        $this->land_size_price->ViewCustomAttributes = "";

        // commission
        $this->commission->ViewValue = $this->commission->CurrentValue;
        $this->commission->ViewValue = FormatPercent($this->commission->ViewValue, $this->commission->formatPattern());
        $this->commission->ViewCustomAttributes = "";

        // transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax->ViewValue = $this->transfer_day_expenses_with_business_tax->CurrentValue;
        $this->transfer_day_expenses_with_business_tax->ViewValue = FormatPercent($this->transfer_day_expenses_with_business_tax->ViewValue, $this->transfer_day_expenses_with_business_tax->formatPattern());
        $this->transfer_day_expenses_with_business_tax->ViewCustomAttributes = "";

        // transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax->ViewValue = $this->transfer_day_expenses_without_business_tax->CurrentValue;
        $this->transfer_day_expenses_without_business_tax->ViewValue = FormatPercent($this->transfer_day_expenses_without_business_tax->ViewValue, $this->transfer_day_expenses_without_business_tax->formatPattern());
        $this->transfer_day_expenses_without_business_tax->ViewCustomAttributes = "";

        // price
        $this->price->ViewValue = $this->price->CurrentValue;
        $this->price->ViewValue = FormatCurrency($this->price->ViewValue, $this->price->formatPattern());
        $this->price->ViewCustomAttributes = "";

        // discount
        $this->discount->ViewValue = $this->discount->CurrentValue;
        $this->discount->ViewValue = FormatCurrency($this->discount->ViewValue, $this->discount->formatPattern());
        $this->discount->ViewCustomAttributes = "";

        // price_special
        $this->price_special->ViewValue = $this->price_special->CurrentValue;
        $this->price_special->ViewValue = FormatCurrency($this->price_special->ViewValue, $this->price_special->formatPattern());
        $this->price_special->ViewCustomAttributes = "";

        // reservation_price_model_a
        $this->reservation_price_model_a->ViewValue = $this->reservation_price_model_a->CurrentValue;
        $this->reservation_price_model_a->ViewValue = FormatCurrency($this->reservation_price_model_a->ViewValue, $this->reservation_price_model_a->formatPattern());
        $this->reservation_price_model_a->ViewCustomAttributes = "";

        // minimum_down_payment_model_a
        $this->minimum_down_payment_model_a->ViewValue = $this->minimum_down_payment_model_a->CurrentValue;
        $this->minimum_down_payment_model_a->ViewValue = FormatPercent($this->minimum_down_payment_model_a->ViewValue, $this->minimum_down_payment_model_a->formatPattern());
        $this->minimum_down_payment_model_a->ViewCustomAttributes = "";

        // down_price_min_a
        $this->down_price_min_a->ViewValue = $this->down_price_min_a->CurrentValue;
        $this->down_price_min_a->ViewValue = FormatCurrency($this->down_price_min_a->ViewValue, $this->down_price_min_a->formatPattern());
        $this->down_price_min_a->ViewCustomAttributes = "";

        // down_price_model_a
        $this->down_price_model_a->ViewValue = $this->down_price_model_a->CurrentValue;
        $this->down_price_model_a->ViewValue = FormatCurrency($this->down_price_model_a->ViewValue, $this->down_price_model_a->formatPattern());
        $this->down_price_model_a->ViewCustomAttributes = "";

        // factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down->ViewValue = $this->factor_monthly_installment_over_down->CurrentValue;
        $this->factor_monthly_installment_over_down->ViewValue = FormatPercent($this->factor_monthly_installment_over_down->ViewValue, $this->factor_monthly_installment_over_down->formatPattern());
        $this->factor_monthly_installment_over_down->ViewCustomAttributes = "";

        // fee_a
        $this->fee_a->ViewValue = $this->fee_a->CurrentValue;
        $this->fee_a->ViewValue = FormatNumber($this->fee_a->ViewValue, $this->fee_a->formatPattern());
        $this->fee_a->ViewCustomAttributes = "";

        // monthly_payment_buyer
        $this->monthly_payment_buyer->ViewValue = $this->monthly_payment_buyer->CurrentValue;
        $this->monthly_payment_buyer->ViewValue = FormatCurrency($this->monthly_payment_buyer->ViewValue, $this->monthly_payment_buyer->formatPattern());
        $this->monthly_payment_buyer->ViewCustomAttributes = "";

        // annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a->ViewValue = $this->annual_interest_buyer_model_a->CurrentValue;
        $this->annual_interest_buyer_model_a->ViewValue = FormatPercent($this->annual_interest_buyer_model_a->ViewValue, $this->annual_interest_buyer_model_a->formatPattern());
        $this->annual_interest_buyer_model_a->ViewCustomAttributes = "";

        // monthly_expenses_a
        $this->monthly_expenses_a->ViewValue = $this->monthly_expenses_a->CurrentValue;
        $this->monthly_expenses_a->ViewValue = FormatCurrency($this->monthly_expenses_a->ViewValue, $this->monthly_expenses_a->formatPattern());
        $this->monthly_expenses_a->ViewCustomAttributes = "";

        // average_rent_a
        $this->average_rent_a->ViewValue = $this->average_rent_a->CurrentValue;
        $this->average_rent_a->ViewValue = FormatCurrency($this->average_rent_a->ViewValue, $this->average_rent_a->formatPattern());
        $this->average_rent_a->ViewCustomAttributes = "";

        // average_down_payment_a
        $this->average_down_payment_a->ViewValue = $this->average_down_payment_a->CurrentValue;
        $this->average_down_payment_a->ViewValue = FormatCurrency($this->average_down_payment_a->ViewValue, $this->average_down_payment_a->formatPattern());
        $this->average_down_payment_a->ViewCustomAttributes = "";

        // transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min->ViewValue = $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue;
        $this->transfer_day_expenses_without_business_tax_max_min->ViewValue = FormatPercent($this->transfer_day_expenses_without_business_tax_max_min->ViewValue, $this->transfer_day_expenses_without_business_tax_max_min->formatPattern());
        $this->transfer_day_expenses_without_business_tax_max_min->ViewCustomAttributes = "";

        // transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min->ViewValue = $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue;
        $this->transfer_day_expenses_with_business_tax_max_min->ViewValue = FormatPercent($this->transfer_day_expenses_with_business_tax_max_min->ViewValue, $this->transfer_day_expenses_with_business_tax_max_min->formatPattern());
        $this->transfer_day_expenses_with_business_tax_max_min->ViewCustomAttributes = "";

        // bank_appraisal_price
        $this->bank_appraisal_price->ViewValue = $this->bank_appraisal_price->CurrentValue;
        $this->bank_appraisal_price->ViewValue = FormatCurrency($this->bank_appraisal_price->ViewValue, $this->bank_appraisal_price->formatPattern());
        $this->bank_appraisal_price->ViewCustomAttributes = "";

        // mark_up_price
        $this->mark_up_price->ViewValue = $this->mark_up_price->CurrentValue;
        $this->mark_up_price->ViewValue = FormatPercent($this->mark_up_price->ViewValue, $this->mark_up_price->formatPattern());
        $this->mark_up_price->ViewCustomAttributes = "";

        // required_gap
        $this->required_gap->ViewValue = $this->required_gap->CurrentValue;
        $this->required_gap->ViewValue = FormatPercent($this->required_gap->ViewValue, $this->required_gap->formatPattern());
        $this->required_gap->ViewCustomAttributes = "";

        // minimum_down_payment
        $this->minimum_down_payment->ViewValue = $this->minimum_down_payment->CurrentValue;
        $this->minimum_down_payment->ViewValue = FormatCurrency($this->minimum_down_payment->ViewValue, $this->minimum_down_payment->formatPattern());
        $this->minimum_down_payment->ViewCustomAttributes = "";

        // price_down_max
        $this->price_down_max->ViewValue = $this->price_down_max->CurrentValue;
        $this->price_down_max->ViewValue = FormatCurrency($this->price_down_max->ViewValue, $this->price_down_max->formatPattern());
        $this->price_down_max->ViewCustomAttributes = "";

        // discount_max
        $this->discount_max->ViewValue = $this->discount_max->CurrentValue;
        $this->discount_max->ViewValue = FormatCurrency($this->discount_max->ViewValue, $this->discount_max->formatPattern());
        $this->discount_max->ViewCustomAttributes = "";

        // price_down_special_max
        $this->price_down_special_max->ViewValue = $this->price_down_special_max->CurrentValue;
        $this->price_down_special_max->ViewValue = FormatNumber($this->price_down_special_max->ViewValue, $this->price_down_special_max->formatPattern());
        $this->price_down_special_max->ViewCustomAttributes = "";

        // usable_area_price_max
        $this->usable_area_price_max->ViewValue = $this->usable_area_price_max->CurrentValue;
        $this->usable_area_price_max->ViewValue = FormatCurrency($this->usable_area_price_max->ViewValue, $this->usable_area_price_max->formatPattern());
        $this->usable_area_price_max->ViewCustomAttributes = "";

        // land_size_price_max
        $this->land_size_price_max->ViewValue = $this->land_size_price_max->CurrentValue;
        $this->land_size_price_max->ViewValue = FormatCurrency($this->land_size_price_max->ViewValue, $this->land_size_price_max->formatPattern());
        $this->land_size_price_max->ViewCustomAttributes = "";

        // reservation_price_max
        $this->reservation_price_max->ViewValue = $this->reservation_price_max->CurrentValue;
        $this->reservation_price_max->ViewValue = FormatCurrency($this->reservation_price_max->ViewValue, $this->reservation_price_max->formatPattern());
        $this->reservation_price_max->ViewCustomAttributes = "";

        // minimum_down_payment_max
        $this->minimum_down_payment_max->ViewValue = $this->minimum_down_payment_max->CurrentValue;
        $this->minimum_down_payment_max->ViewValue = FormatPercent($this->minimum_down_payment_max->ViewValue, $this->minimum_down_payment_max->formatPattern());
        $this->minimum_down_payment_max->ViewCustomAttributes = "";

        // down_price_max
        $this->down_price_max->ViewValue = $this->down_price_max->CurrentValue;
        $this->down_price_max->ViewValue = FormatCurrency($this->down_price_max->ViewValue, $this->down_price_max->formatPattern());
        $this->down_price_max->ViewCustomAttributes = "";

        // down_price
        $this->down_price->ViewValue = $this->down_price->CurrentValue;
        $this->down_price->ViewValue = FormatCurrency($this->down_price->ViewValue, $this->down_price->formatPattern());
        $this->down_price->ViewCustomAttributes = "";

        // factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max->ViewValue = $this->factor_monthly_installment_over_down_max->CurrentValue;
        $this->factor_monthly_installment_over_down_max->ViewValue = FormatNumber($this->factor_monthly_installment_over_down_max->ViewValue, $this->factor_monthly_installment_over_down_max->formatPattern());
        $this->factor_monthly_installment_over_down_max->ViewCustomAttributes = "";

        // fee_max
        $this->fee_max->ViewValue = $this->fee_max->CurrentValue;
        $this->fee_max->ViewValue = FormatNumber($this->fee_max->ViewValue, $this->fee_max->formatPattern());
        $this->fee_max->ViewCustomAttributes = "";

        // monthly_payment_max
        $this->monthly_payment_max->ViewValue = $this->monthly_payment_max->CurrentValue;
        $this->monthly_payment_max->ViewValue = FormatCurrency($this->monthly_payment_max->ViewValue, $this->monthly_payment_max->formatPattern());
        $this->monthly_payment_max->ViewCustomAttributes = "";

        // annual_interest_buyer
        $this->annual_interest_buyer->ViewValue = $this->annual_interest_buyer->CurrentValue;
        $this->annual_interest_buyer->ViewValue = FormatPercent($this->annual_interest_buyer->ViewValue, $this->annual_interest_buyer->formatPattern());
        $this->annual_interest_buyer->ViewCustomAttributes = "";

        // monthly_expense_max
        $this->monthly_expense_max->ViewValue = $this->monthly_expense_max->CurrentValue;
        $this->monthly_expense_max->ViewValue = FormatCurrency($this->monthly_expense_max->ViewValue, $this->monthly_expense_max->formatPattern());
        $this->monthly_expense_max->ViewCustomAttributes = "";

        // average_rent_max
        $this->average_rent_max->ViewValue = $this->average_rent_max->CurrentValue;
        $this->average_rent_max->ViewValue = FormatCurrency($this->average_rent_max->ViewValue, $this->average_rent_max->formatPattern());
        $this->average_rent_max->ViewCustomAttributes = "";

        // average_down_payment_max
        $this->average_down_payment_max->ViewValue = $this->average_down_payment_max->CurrentValue;
        $this->average_down_payment_max->ViewValue = FormatCurrency($this->average_down_payment_max->ViewValue, $this->average_down_payment_max->formatPattern());
        $this->average_down_payment_max->ViewCustomAttributes = "";

        // min_down
        $this->min_down->ViewValue = $this->min_down->CurrentValue;
        $this->min_down->ViewValue = FormatPercent($this->min_down->ViewValue, $this->min_down->formatPattern());
        $this->min_down->ViewCustomAttributes = "";

        // remaining_down
        $this->remaining_down->ViewValue = $this->remaining_down->CurrentValue;
        $this->remaining_down->ViewValue = FormatPercent($this->remaining_down->ViewValue, $this->remaining_down->formatPattern());
        $this->remaining_down->ViewCustomAttributes = "";

        // factor_financing
        $this->factor_financing->ViewValue = $this->factor_financing->CurrentValue;
        $this->factor_financing->ViewValue = FormatPercent($this->factor_financing->ViewValue, $this->factor_financing->formatPattern());
        $this->factor_financing->ViewCustomAttributes = "";

        // credit_limit_down
        $this->credit_limit_down->ViewValue = $this->credit_limit_down->CurrentValue;
        $this->credit_limit_down->ViewValue = FormatCurrency($this->credit_limit_down->ViewValue, $this->credit_limit_down->formatPattern());
        $this->credit_limit_down->ViewCustomAttributes = "";

        // price_down_min
        $this->price_down_min->ViewValue = $this->price_down_min->CurrentValue;
        $this->price_down_min->ViewValue = FormatCurrency($this->price_down_min->ViewValue, $this->price_down_min->formatPattern());
        $this->price_down_min->ViewCustomAttributes = "";

        // discount_min
        $this->discount_min->ViewValue = $this->discount_min->CurrentValue;
        $this->discount_min->ViewValue = FormatCurrency($this->discount_min->ViewValue, $this->discount_min->formatPattern());
        $this->discount_min->ViewCustomAttributes = "";

        // price_down_special_min
        $this->price_down_special_min->ViewValue = $this->price_down_special_min->CurrentValue;
        $this->price_down_special_min->ViewValue = FormatCurrency($this->price_down_special_min->ViewValue, $this->price_down_special_min->formatPattern());
        $this->price_down_special_min->ViewCustomAttributes = "";

        // usable_area_price_min
        $this->usable_area_price_min->ViewValue = $this->usable_area_price_min->CurrentValue;
        $this->usable_area_price_min->ViewValue = FormatNumber($this->usable_area_price_min->ViewValue, $this->usable_area_price_min->formatPattern());
        $this->usable_area_price_min->ViewCustomAttributes = "";

        // land_size_price_min
        $this->land_size_price_min->ViewValue = $this->land_size_price_min->CurrentValue;
        $this->land_size_price_min->ViewValue = FormatPercent($this->land_size_price_min->ViewValue, $this->land_size_price_min->formatPattern());
        $this->land_size_price_min->ViewCustomAttributes = "";

        // reservation_price_min
        $this->reservation_price_min->ViewValue = $this->reservation_price_min->CurrentValue;
        $this->reservation_price_min->ViewValue = FormatCurrency($this->reservation_price_min->ViewValue, $this->reservation_price_min->formatPattern());
        $this->reservation_price_min->ViewCustomAttributes = "";

        // minimum_down_payment_min
        $this->minimum_down_payment_min->ViewValue = $this->minimum_down_payment_min->CurrentValue;
        $this->minimum_down_payment_min->ViewValue = FormatPercent($this->minimum_down_payment_min->ViewValue, $this->minimum_down_payment_min->formatPattern());
        $this->minimum_down_payment_min->ViewCustomAttributes = "";

        // down_price_min
        $this->down_price_min->ViewValue = $this->down_price_min->CurrentValue;
        $this->down_price_min->ViewValue = FormatCurrency($this->down_price_min->ViewValue, $this->down_price_min->formatPattern());
        $this->down_price_min->ViewCustomAttributes = "";

        // remaining_credit_limit_down
        $this->remaining_credit_limit_down->ViewValue = $this->remaining_credit_limit_down->CurrentValue;
        $this->remaining_credit_limit_down->ViewValue = FormatCurrency($this->remaining_credit_limit_down->ViewValue, $this->remaining_credit_limit_down->formatPattern());
        $this->remaining_credit_limit_down->ViewCustomAttributes = "";

        // fee_min
        $this->fee_min->ViewValue = $this->fee_min->CurrentValue;
        $this->fee_min->ViewValue = FormatNumber($this->fee_min->ViewValue, $this->fee_min->formatPattern());
        $this->fee_min->ViewCustomAttributes = "";

        // monthly_payment_min
        $this->monthly_payment_min->ViewValue = $this->monthly_payment_min->CurrentValue;
        $this->monthly_payment_min->ViewValue = FormatCurrency($this->monthly_payment_min->ViewValue, $this->monthly_payment_min->formatPattern());
        $this->monthly_payment_min->ViewCustomAttributes = "";

        // annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min->ViewValue = $this->annual_interest_buyer_model_min->CurrentValue;
        $this->annual_interest_buyer_model_min->ViewValue = FormatPercent($this->annual_interest_buyer_model_min->ViewValue, $this->annual_interest_buyer_model_min->formatPattern());
        $this->annual_interest_buyer_model_min->ViewCustomAttributes = "";

        // interest_down-payment_financing
        $this->interest_downpayment_financing->ViewValue = $this->interest_downpayment_financing->CurrentValue;
        $this->interest_downpayment_financing->ViewValue = FormatPercent($this->interest_downpayment_financing->ViewValue, $this->interest_downpayment_financing->formatPattern());
        $this->interest_downpayment_financing->ViewCustomAttributes = "";

        // monthly_expenses_min
        $this->monthly_expenses_min->ViewValue = $this->monthly_expenses_min->CurrentValue;
        $this->monthly_expenses_min->ViewValue = FormatNumber($this->monthly_expenses_min->ViewValue, $this->monthly_expenses_min->formatPattern());
        $this->monthly_expenses_min->ViewCustomAttributes = "";

        // average_rent_min
        $this->average_rent_min->ViewValue = $this->average_rent_min->CurrentValue;
        $this->average_rent_min->ViewValue = FormatNumber($this->average_rent_min->ViewValue, $this->average_rent_min->formatPattern());
        $this->average_rent_min->ViewCustomAttributes = "";

        // average_down_payment_min
        $this->average_down_payment_min->ViewValue = $this->average_down_payment_min->CurrentValue;
        $this->average_down_payment_min->ViewValue = FormatNumber($this->average_down_payment_min->ViewValue, $this->average_down_payment_min->formatPattern());
        $this->average_down_payment_min->ViewCustomAttributes = "";

        // installment_down_payment_loan
        $this->installment_down_payment_loan->ViewValue = $this->installment_down_payment_loan->CurrentValue;
        $this->installment_down_payment_loan->ViewValue = FormatNumber($this->installment_down_payment_loan->ViewValue, $this->installment_down_payment_loan->formatPattern());
        $this->installment_down_payment_loan->ViewCustomAttributes = "";

        // count_view
        $this->count_view->ViewValue = $this->count_view->CurrentValue;
        $this->count_view->ViewValue = FormatNumber($this->count_view->ViewValue, $this->count_view->formatPattern());
        $this->count_view->ViewCustomAttributes = "";

        // count_favorite
        $this->count_favorite->ViewValue = $this->count_favorite->CurrentValue;
        $this->count_favorite->ViewValue = FormatNumber($this->count_favorite->ViewValue, $this->count_favorite->formatPattern());
        $this->count_favorite->ViewCustomAttributes = "";

        // price_invertor
        $this->price_invertor->ViewValue = $this->price_invertor->CurrentValue;
        $this->price_invertor->ViewValue = FormatCurrency($this->price_invertor->ViewValue, $this->price_invertor->formatPattern());
        $this->price_invertor->ViewCustomAttributes = "";

        // installment_price
        $this->installment_price->ViewValue = $this->installment_price->CurrentValue;
        $this->installment_price->ViewValue = FormatNumber($this->installment_price->ViewValue, $this->installment_price->formatPattern());
        $this->installment_price->ViewCustomAttributes = "";

        // installment_all
        $this->installment_all->ViewValue = $this->installment_all->CurrentValue;
        $this->installment_all->ViewValue = FormatNumber($this->installment_all->ViewValue, $this->installment_all->formatPattern());
        $this->installment_all->ViewCustomAttributes = "";

        // master_calculator
        $this->master_calculator->ViewValue = $this->master_calculator->CurrentValue;
        $this->master_calculator->ViewValue = FormatNumber($this->master_calculator->ViewValue, $this->master_calculator->formatPattern());
        $this->master_calculator->ViewCustomAttributes = "";

        // expired_date
        $this->expired_date->ViewValue = $this->expired_date->CurrentValue;
        $this->expired_date->ViewValue = FormatDateTime($this->expired_date->ViewValue, $this->expired_date->formatPattern());
        $this->expired_date->ViewCustomAttributes = "";

        // tag
        $this->tag->ViewValue = $this->tag->CurrentValue;
        $this->tag->ViewCustomAttributes = "";

        // cdate
        $this->cdate->ViewValue = $this->cdate->CurrentValue;
        $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
        $this->cdate->ViewCustomAttributes = "";

        // cuser
        $this->cuser->ViewValue = $this->cuser->CurrentValue;
        $this->cuser->ViewValue = FormatNumber($this->cuser->ViewValue, $this->cuser->formatPattern());
        $this->cuser->ViewCustomAttributes = "";

        // cip
        $this->cip->ViewValue = $this->cip->CurrentValue;
        $this->cip->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
        $this->uuser->ViewCustomAttributes = "";

        // update_expired_key
        $this->update_expired_key->ViewValue = $this->update_expired_key->CurrentValue;
        $this->update_expired_key->ViewCustomAttributes = "";

        // update_expired_status
        $this->update_expired_status->ViewValue = $this->update_expired_status->CurrentValue;
        $this->update_expired_status->ViewValue = FormatNumber($this->update_expired_status->ViewValue, $this->update_expired_status->formatPattern());
        $this->update_expired_status->ViewCustomAttributes = "";

        // update_expired_date
        $this->update_expired_date->ViewValue = $this->update_expired_date->CurrentValue;
        $this->update_expired_date->ViewValue = FormatDateTime($this->update_expired_date->ViewValue, $this->update_expired_date->formatPattern());
        $this->update_expired_date->ViewCustomAttributes = "";

        // update_expired_ip
        $this->update_expired_ip->ViewValue = $this->update_expired_ip->CurrentValue;
        $this->update_expired_ip->ViewCustomAttributes = "";

        // is_cancel_contract
        if (ConvertToBool($this->is_cancel_contract->CurrentValue)) {
            $this->is_cancel_contract->ViewValue = $this->is_cancel_contract->tagCaption(1) != "" ? $this->is_cancel_contract->tagCaption(1) : "Yes";
        } else {
            $this->is_cancel_contract->ViewValue = $this->is_cancel_contract->tagCaption(2) != "" ? $this->is_cancel_contract->tagCaption(2) : "No";
        }
        $this->is_cancel_contract->ViewCustomAttributes = "";

        // cancel_contract_reason
        $this->cancel_contract_reason->ViewValue = $this->cancel_contract_reason->CurrentValue;
        $this->cancel_contract_reason->ViewCustomAttributes = "";

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail->ViewValue = $this->cancel_contract_reason_detail->CurrentValue;
        $this->cancel_contract_reason_detail->ViewCustomAttributes = "";

        // cancel_contract_date
        $this->cancel_contract_date->ViewValue = $this->cancel_contract_date->CurrentValue;
        $this->cancel_contract_date->ViewValue = FormatDateTime($this->cancel_contract_date->ViewValue, $this->cancel_contract_date->formatPattern());
        $this->cancel_contract_date->ViewCustomAttributes = "";

        // cancel_contract_user
        $this->cancel_contract_user->ViewValue = $this->cancel_contract_user->CurrentValue;
        $this->cancel_contract_user->ViewValue = FormatNumber($this->cancel_contract_user->ViewValue, $this->cancel_contract_user->formatPattern());
        $this->cancel_contract_user->ViewCustomAttributes = "";

        // cancel_contract_ip
        $this->cancel_contract_ip->ViewValue = $this->cancel_contract_ip->CurrentValue;
        $this->cancel_contract_ip->ViewCustomAttributes = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // title
        $this->_title->LinkCustomAttributes = "";
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // title_en
        $this->title_en->LinkCustomAttributes = "";
        $this->title_en->HrefValue = "";
        $this->title_en->TooltipValue = "";

        // brand_id
        $this->brand_id->LinkCustomAttributes = "";
        $this->brand_id->HrefValue = "";
        $this->brand_id->TooltipValue = "";

        // asset_short_detail
        $this->asset_short_detail->LinkCustomAttributes = "";
        $this->asset_short_detail->HrefValue = "";
        $this->asset_short_detail->TooltipValue = "";

        // asset_short_detail_en
        $this->asset_short_detail_en->LinkCustomAttributes = "";
        $this->asset_short_detail_en->HrefValue = "";
        $this->asset_short_detail_en->TooltipValue = "";

        // detail
        $this->detail->LinkCustomAttributes = "";
        $this->detail->HrefValue = "";
        $this->detail->TooltipValue = "";

        // detail_en
        $this->detail_en->LinkCustomAttributes = "";
        $this->detail_en->HrefValue = "";
        $this->detail_en->TooltipValue = "";

        // asset_code
        $this->asset_code->LinkCustomAttributes = "";
        $this->asset_code->HrefValue = "";
        $this->asset_code->TooltipValue = "";

        // asset_status
        $this->asset_status->LinkCustomAttributes = "";
        $this->asset_status->HrefValue = "";
        $this->asset_status->TooltipValue = "";

        // latitude
        $this->latitude->LinkCustomAttributes = "";
        $this->latitude->HrefValue = "";
        $this->latitude->TooltipValue = "";

        // longitude
        $this->longitude->LinkCustomAttributes = "";
        $this->longitude->HrefValue = "";
        $this->longitude->TooltipValue = "";

        // num_buildings
        $this->num_buildings->LinkCustomAttributes = "";
        $this->num_buildings->HrefValue = "";
        $this->num_buildings->TooltipValue = "";

        // num_unit
        $this->num_unit->LinkCustomAttributes = "";
        $this->num_unit->HrefValue = "";
        $this->num_unit->TooltipValue = "";

        // num_floors
        $this->num_floors->LinkCustomAttributes = "";
        $this->num_floors->HrefValue = "";
        $this->num_floors->TooltipValue = "";

        // floors
        $this->floors->LinkCustomAttributes = "";
        $this->floors->HrefValue = "";
        $this->floors->TooltipValue = "";

        // asset_year_developer
        $this->asset_year_developer->LinkCustomAttributes = "";
        $this->asset_year_developer->HrefValue = "";
        $this->asset_year_developer->TooltipValue = "";

        // num_parking_spaces
        $this->num_parking_spaces->LinkCustomAttributes = "";
        $this->num_parking_spaces->HrefValue = "";
        $this->num_parking_spaces->TooltipValue = "";

        // num_bathrooms
        $this->num_bathrooms->LinkCustomAttributes = "";
        $this->num_bathrooms->HrefValue = "";
        $this->num_bathrooms->TooltipValue = "";

        // num_bedrooms
        $this->num_bedrooms->LinkCustomAttributes = "";
        $this->num_bedrooms->HrefValue = "";
        $this->num_bedrooms->TooltipValue = "";

        // address
        $this->address->LinkCustomAttributes = "";
        $this->address->HrefValue = "";
        $this->address->TooltipValue = "";

        // address_en
        $this->address_en->LinkCustomAttributes = "";
        $this->address_en->HrefValue = "";
        $this->address_en->TooltipValue = "";

        // province_id
        $this->province_id->LinkCustomAttributes = "";
        $this->province_id->HrefValue = "";
        $this->province_id->TooltipValue = "";

        // amphur_id
        $this->amphur_id->LinkCustomAttributes = "";
        $this->amphur_id->HrefValue = "";
        $this->amphur_id->TooltipValue = "";

        // district_id
        $this->district_id->LinkCustomAttributes = "";
        $this->district_id->HrefValue = "";
        $this->district_id->TooltipValue = "";

        // postcode
        $this->postcode->LinkCustomAttributes = "";
        $this->postcode->HrefValue = "";
        $this->postcode->TooltipValue = "";

        // floor_plan
        $this->floor_plan->LinkCustomAttributes = "";
        $this->floor_plan->UploadPath = './upload/floor_plan';
        if (!EmptyValue($this->floor_plan->Upload->DbValue)) {
            $this->floor_plan->HrefValue = GetFileUploadUrl($this->floor_plan, $this->floor_plan->htmlDecode($this->floor_plan->Upload->DbValue)); // Add prefix/suffix
            $this->floor_plan->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->floor_plan->HrefValue = FullUrl($this->floor_plan->HrefValue, "href");
            }
        } else {
            $this->floor_plan->HrefValue = "";
        }
        $this->floor_plan->ExportHrefValue = $this->floor_plan->UploadPath . $this->floor_plan->Upload->DbValue;
        $this->floor_plan->TooltipValue = "";
        if ($this->floor_plan->UseColorbox) {
            if (EmptyValue($this->floor_plan->TooltipValue)) {
                $this->floor_plan->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->floor_plan->LinkAttrs["data-rel"] = "asset_x_floor_plan";
            $this->floor_plan->LinkAttrs->appendClass("ew-lightbox");
        }

        // layout_unit
        $this->layout_unit->LinkCustomAttributes = "";
        $this->layout_unit->UploadPath = './upload/layout_unit';
        if (!EmptyValue($this->layout_unit->Upload->DbValue)) {
            $this->layout_unit->HrefValue = GetFileUploadUrl($this->layout_unit, $this->layout_unit->htmlDecode($this->layout_unit->Upload->DbValue)); // Add prefix/suffix
            $this->layout_unit->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->layout_unit->HrefValue = FullUrl($this->layout_unit->HrefValue, "href");
            }
        } else {
            $this->layout_unit->HrefValue = "";
        }
        $this->layout_unit->ExportHrefValue = $this->layout_unit->UploadPath . $this->layout_unit->Upload->DbValue;
        $this->layout_unit->TooltipValue = "";
        if ($this->layout_unit->UseColorbox) {
            if (EmptyValue($this->layout_unit->TooltipValue)) {
                $this->layout_unit->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->layout_unit->LinkAttrs["data-rel"] = "asset_x_layout_unit";
            $this->layout_unit->LinkAttrs->appendClass("ew-lightbox");
        }

        // asset_website
        $this->asset_website->LinkCustomAttributes = "";
        $this->asset_website->HrefValue = "";
        $this->asset_website->TooltipValue = "";

        // asset_review
        $this->asset_review->LinkCustomAttributes = "";
        $this->asset_review->HrefValue = "";
        $this->asset_review->TooltipValue = "";

        // isactive
        $this->isactive->LinkCustomAttributes = "";
        $this->isactive->HrefValue = "";
        $this->isactive->TooltipValue = "";

        // is_recommend
        $this->is_recommend->LinkCustomAttributes = "";
        $this->is_recommend->HrefValue = "";
        $this->is_recommend->TooltipValue = "";

        // order_by
        $this->order_by->LinkCustomAttributes = "";
        $this->order_by->HrefValue = "";
        $this->order_by->TooltipValue = "";

        // type_pay
        $this->type_pay->LinkCustomAttributes = "";
        $this->type_pay->HrefValue = "";
        $this->type_pay->TooltipValue = "";

        // type_pay_2
        $this->type_pay_2->LinkCustomAttributes = "";
        $this->type_pay_2->HrefValue = "";
        $this->type_pay_2->TooltipValue = "";

        // price_mark
        $this->price_mark->LinkCustomAttributes = "";
        $this->price_mark->HrefValue = "";
        $this->price_mark->TooltipValue = "";

        // holding_property
        $this->holding_property->LinkCustomAttributes = "";
        $this->holding_property->HrefValue = "";
        $this->holding_property->TooltipValue = "";

        // common_fee
        $this->common_fee->LinkCustomAttributes = "";
        $this->common_fee->HrefValue = "";
        $this->common_fee->TooltipValue = "";

        // usable_area
        $this->usable_area->LinkCustomAttributes = "";
        $this->usable_area->HrefValue = "";
        $this->usable_area->TooltipValue = "";

        // usable_area_price
        $this->usable_area_price->LinkCustomAttributes = "";
        $this->usable_area_price->HrefValue = "";
        $this->usable_area_price->TooltipValue = "";

        // land_size
        $this->land_size->LinkCustomAttributes = "";
        $this->land_size->HrefValue = "";
        $this->land_size->TooltipValue = "";

        // land_size_price
        $this->land_size_price->LinkCustomAttributes = "";
        $this->land_size_price->HrefValue = "";
        $this->land_size_price->TooltipValue = "";

        // commission
        $this->commission->LinkCustomAttributes = "";
        $this->commission->HrefValue = "";
        $this->commission->TooltipValue = "";

        // transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax->LinkCustomAttributes = "";
        $this->transfer_day_expenses_with_business_tax->HrefValue = "";
        $this->transfer_day_expenses_with_business_tax->TooltipValue = "";

        // transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax->LinkCustomAttributes = "";
        $this->transfer_day_expenses_without_business_tax->HrefValue = "";
        $this->transfer_day_expenses_without_business_tax->TooltipValue = "";

        // price
        $this->price->LinkCustomAttributes = "";
        $this->price->HrefValue = "";
        $this->price->TooltipValue = "";

        // discount
        $this->discount->LinkCustomAttributes = "";
        $this->discount->HrefValue = "";
        $this->discount->TooltipValue = "";

        // price_special
        $this->price_special->LinkCustomAttributes = "";
        $this->price_special->HrefValue = "";
        $this->price_special->TooltipValue = "";

        // reservation_price_model_a
        $this->reservation_price_model_a->LinkCustomAttributes = "";
        $this->reservation_price_model_a->HrefValue = "";
        $this->reservation_price_model_a->TooltipValue = "";

        // minimum_down_payment_model_a
        $this->minimum_down_payment_model_a->LinkCustomAttributes = "";
        $this->minimum_down_payment_model_a->HrefValue = "";
        $this->minimum_down_payment_model_a->TooltipValue = "";

        // down_price_min_a
        $this->down_price_min_a->LinkCustomAttributes = "";
        $this->down_price_min_a->HrefValue = "";
        $this->down_price_min_a->TooltipValue = "";

        // down_price_model_a
        $this->down_price_model_a->LinkCustomAttributes = "";
        $this->down_price_model_a->HrefValue = "";
        $this->down_price_model_a->TooltipValue = "";

        // factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down->LinkCustomAttributes = "";
        $this->factor_monthly_installment_over_down->HrefValue = "";
        $this->factor_monthly_installment_over_down->TooltipValue = "";

        // fee_a
        $this->fee_a->LinkCustomAttributes = "";
        $this->fee_a->HrefValue = "";
        $this->fee_a->TooltipValue = "";

        // monthly_payment_buyer
        $this->monthly_payment_buyer->LinkCustomAttributes = "";
        $this->monthly_payment_buyer->HrefValue = "";
        $this->monthly_payment_buyer->TooltipValue = "";

        // annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a->LinkCustomAttributes = "";
        $this->annual_interest_buyer_model_a->HrefValue = "";
        $this->annual_interest_buyer_model_a->TooltipValue = "";

        // monthly_expenses_a
        $this->monthly_expenses_a->LinkCustomAttributes = "";
        $this->monthly_expenses_a->HrefValue = "";
        $this->monthly_expenses_a->TooltipValue = "";

        // average_rent_a
        $this->average_rent_a->LinkCustomAttributes = "";
        $this->average_rent_a->HrefValue = "";
        $this->average_rent_a->TooltipValue = "";

        // average_down_payment_a
        $this->average_down_payment_a->LinkCustomAttributes = "";
        $this->average_down_payment_a->HrefValue = "";
        $this->average_down_payment_a->TooltipValue = "";

        // transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min->LinkCustomAttributes = "";
        $this->transfer_day_expenses_without_business_tax_max_min->HrefValue = "";
        $this->transfer_day_expenses_without_business_tax_max_min->TooltipValue = "";

        // transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min->LinkCustomAttributes = "";
        $this->transfer_day_expenses_with_business_tax_max_min->HrefValue = "";
        $this->transfer_day_expenses_with_business_tax_max_min->TooltipValue = "";

        // bank_appraisal_price
        $this->bank_appraisal_price->LinkCustomAttributes = "";
        $this->bank_appraisal_price->HrefValue = "";
        $this->bank_appraisal_price->TooltipValue = "";

        // mark_up_price
        $this->mark_up_price->LinkCustomAttributes = "";
        $this->mark_up_price->HrefValue = "";
        $this->mark_up_price->TooltipValue = "";

        // required_gap
        $this->required_gap->LinkCustomAttributes = "";
        $this->required_gap->HrefValue = "";
        $this->required_gap->TooltipValue = "";

        // minimum_down_payment
        $this->minimum_down_payment->LinkCustomAttributes = "";
        $this->minimum_down_payment->HrefValue = "";
        $this->minimum_down_payment->TooltipValue = "";

        // price_down_max
        $this->price_down_max->LinkCustomAttributes = "";
        $this->price_down_max->HrefValue = "";
        $this->price_down_max->TooltipValue = "";

        // discount_max
        $this->discount_max->LinkCustomAttributes = "";
        $this->discount_max->HrefValue = "";
        $this->discount_max->TooltipValue = "";

        // price_down_special_max
        $this->price_down_special_max->LinkCustomAttributes = "";
        $this->price_down_special_max->HrefValue = "";
        $this->price_down_special_max->TooltipValue = "";

        // usable_area_price_max
        $this->usable_area_price_max->LinkCustomAttributes = "";
        $this->usable_area_price_max->HrefValue = "";
        $this->usable_area_price_max->TooltipValue = "";

        // land_size_price_max
        $this->land_size_price_max->LinkCustomAttributes = "";
        $this->land_size_price_max->HrefValue = "";
        $this->land_size_price_max->TooltipValue = "";

        // reservation_price_max
        $this->reservation_price_max->LinkCustomAttributes = "";
        $this->reservation_price_max->HrefValue = "";
        $this->reservation_price_max->TooltipValue = "";

        // minimum_down_payment_max
        $this->minimum_down_payment_max->LinkCustomAttributes = "";
        $this->minimum_down_payment_max->HrefValue = "";
        $this->minimum_down_payment_max->TooltipValue = "";

        // down_price_max
        $this->down_price_max->LinkCustomAttributes = "";
        $this->down_price_max->HrefValue = "";
        $this->down_price_max->TooltipValue = "";

        // down_price
        $this->down_price->LinkCustomAttributes = "";
        $this->down_price->HrefValue = "";
        $this->down_price->TooltipValue = "";

        // factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max->LinkCustomAttributes = "";
        $this->factor_monthly_installment_over_down_max->HrefValue = "";
        $this->factor_monthly_installment_over_down_max->TooltipValue = "";

        // fee_max
        $this->fee_max->LinkCustomAttributes = "";
        $this->fee_max->HrefValue = "";
        $this->fee_max->TooltipValue = "";

        // monthly_payment_max
        $this->monthly_payment_max->LinkCustomAttributes = "";
        $this->monthly_payment_max->HrefValue = "";
        $this->monthly_payment_max->TooltipValue = "";

        // annual_interest_buyer
        $this->annual_interest_buyer->LinkCustomAttributes = "";
        $this->annual_interest_buyer->HrefValue = "";
        $this->annual_interest_buyer->TooltipValue = "";

        // monthly_expense_max
        $this->monthly_expense_max->LinkCustomAttributes = "";
        $this->monthly_expense_max->HrefValue = "";
        $this->monthly_expense_max->TooltipValue = "";

        // average_rent_max
        $this->average_rent_max->LinkCustomAttributes = "";
        $this->average_rent_max->HrefValue = "";
        $this->average_rent_max->TooltipValue = "";

        // average_down_payment_max
        $this->average_down_payment_max->LinkCustomAttributes = "";
        $this->average_down_payment_max->HrefValue = "";
        $this->average_down_payment_max->TooltipValue = "";

        // min_down
        $this->min_down->LinkCustomAttributes = "";
        $this->min_down->HrefValue = "";
        $this->min_down->TooltipValue = "";

        // remaining_down
        $this->remaining_down->LinkCustomAttributes = "";
        $this->remaining_down->HrefValue = "";
        $this->remaining_down->TooltipValue = "";

        // factor_financing
        $this->factor_financing->LinkCustomAttributes = "";
        $this->factor_financing->HrefValue = "";
        $this->factor_financing->TooltipValue = "";

        // credit_limit_down
        $this->credit_limit_down->LinkCustomAttributes = "";
        $this->credit_limit_down->HrefValue = "";
        $this->credit_limit_down->TooltipValue = "";

        // price_down_min
        $this->price_down_min->LinkCustomAttributes = "";
        $this->price_down_min->HrefValue = "";
        $this->price_down_min->TooltipValue = "";

        // discount_min
        $this->discount_min->LinkCustomAttributes = "";
        $this->discount_min->HrefValue = "";
        $this->discount_min->TooltipValue = "";

        // price_down_special_min
        $this->price_down_special_min->LinkCustomAttributes = "";
        $this->price_down_special_min->HrefValue = "";
        $this->price_down_special_min->TooltipValue = "";

        // usable_area_price_min
        $this->usable_area_price_min->LinkCustomAttributes = "";
        $this->usable_area_price_min->HrefValue = "";
        $this->usable_area_price_min->TooltipValue = "";

        // land_size_price_min
        $this->land_size_price_min->LinkCustomAttributes = "";
        $this->land_size_price_min->HrefValue = "";
        $this->land_size_price_min->TooltipValue = "";

        // reservation_price_min
        $this->reservation_price_min->LinkCustomAttributes = "";
        $this->reservation_price_min->HrefValue = "";
        $this->reservation_price_min->TooltipValue = "";

        // minimum_down_payment_min
        $this->minimum_down_payment_min->LinkCustomAttributes = "";
        $this->minimum_down_payment_min->HrefValue = "";
        $this->minimum_down_payment_min->TooltipValue = "";

        // down_price_min
        $this->down_price_min->LinkCustomAttributes = "";
        $this->down_price_min->HrefValue = "";
        $this->down_price_min->TooltipValue = "";

        // remaining_credit_limit_down
        $this->remaining_credit_limit_down->LinkCustomAttributes = "";
        $this->remaining_credit_limit_down->HrefValue = "";
        $this->remaining_credit_limit_down->TooltipValue = "";

        // fee_min
        $this->fee_min->LinkCustomAttributes = "";
        $this->fee_min->HrefValue = "";
        $this->fee_min->TooltipValue = "";

        // monthly_payment_min
        $this->monthly_payment_min->LinkCustomAttributes = "";
        $this->monthly_payment_min->HrefValue = "";
        $this->monthly_payment_min->TooltipValue = "";

        // annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min->LinkCustomAttributes = "";
        $this->annual_interest_buyer_model_min->HrefValue = "";
        $this->annual_interest_buyer_model_min->TooltipValue = "";

        // interest_down-payment_financing
        $this->interest_downpayment_financing->LinkCustomAttributes = "";
        $this->interest_downpayment_financing->HrefValue = "";
        $this->interest_downpayment_financing->TooltipValue = "";

        // monthly_expenses_min
        $this->monthly_expenses_min->LinkCustomAttributes = "";
        $this->monthly_expenses_min->HrefValue = "";
        $this->monthly_expenses_min->TooltipValue = "";

        // average_rent_min
        $this->average_rent_min->LinkCustomAttributes = "";
        $this->average_rent_min->HrefValue = "";
        $this->average_rent_min->TooltipValue = "";

        // average_down_payment_min
        $this->average_down_payment_min->LinkCustomAttributes = "";
        $this->average_down_payment_min->HrefValue = "";
        $this->average_down_payment_min->TooltipValue = "";

        // installment_down_payment_loan
        $this->installment_down_payment_loan->LinkCustomAttributes = "";
        $this->installment_down_payment_loan->HrefValue = "";
        $this->installment_down_payment_loan->TooltipValue = "";

        // count_view
        $this->count_view->LinkCustomAttributes = "";
        $this->count_view->HrefValue = "";
        $this->count_view->TooltipValue = "";

        // count_favorite
        $this->count_favorite->LinkCustomAttributes = "";
        $this->count_favorite->HrefValue = "";
        $this->count_favorite->TooltipValue = "";

        // price_invertor
        $this->price_invertor->LinkCustomAttributes = "";
        $this->price_invertor->HrefValue = "";
        $this->price_invertor->TooltipValue = "";

        // installment_price
        $this->installment_price->LinkCustomAttributes = "";
        $this->installment_price->HrefValue = "";
        $this->installment_price->TooltipValue = "";

        // installment_all
        $this->installment_all->LinkCustomAttributes = "";
        $this->installment_all->HrefValue = "";
        $this->installment_all->TooltipValue = "";

        // master_calculator
        $this->master_calculator->LinkCustomAttributes = "";
        $this->master_calculator->HrefValue = "";
        $this->master_calculator->TooltipValue = "";

        // expired_date
        $this->expired_date->LinkCustomAttributes = "";
        $this->expired_date->HrefValue = "";
        $this->expired_date->TooltipValue = "";

        // tag
        $this->tag->LinkCustomAttributes = "";
        $this->tag->HrefValue = "";
        $this->tag->TooltipValue = "";

        // cdate
        $this->cdate->LinkCustomAttributes = "";
        $this->cdate->HrefValue = "";
        $this->cdate->TooltipValue = "";

        // cuser
        $this->cuser->LinkCustomAttributes = "";
        $this->cuser->HrefValue = "";
        $this->cuser->TooltipValue = "";

        // cip
        $this->cip->LinkCustomAttributes = "";
        $this->cip->HrefValue = "";
        $this->cip->TooltipValue = "";

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

        // update_expired_key
        $this->update_expired_key->LinkCustomAttributes = "";
        $this->update_expired_key->HrefValue = "";
        $this->update_expired_key->TooltipValue = "";

        // update_expired_status
        $this->update_expired_status->LinkCustomAttributes = "";
        $this->update_expired_status->HrefValue = "";
        $this->update_expired_status->TooltipValue = "";

        // update_expired_date
        $this->update_expired_date->LinkCustomAttributes = "";
        $this->update_expired_date->HrefValue = "";
        $this->update_expired_date->TooltipValue = "";

        // update_expired_ip
        $this->update_expired_ip->LinkCustomAttributes = "";
        $this->update_expired_ip->HrefValue = "";
        $this->update_expired_ip->TooltipValue = "";

        // is_cancel_contract
        $this->is_cancel_contract->LinkCustomAttributes = "";
        $this->is_cancel_contract->HrefValue = "";
        $this->is_cancel_contract->TooltipValue = "";

        // cancel_contract_reason
        $this->cancel_contract_reason->LinkCustomAttributes = "";
        $this->cancel_contract_reason->HrefValue = "";
        $this->cancel_contract_reason->TooltipValue = "";

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail->LinkCustomAttributes = "";
        $this->cancel_contract_reason_detail->HrefValue = "";
        $this->cancel_contract_reason_detail->TooltipValue = "";

        // cancel_contract_date
        $this->cancel_contract_date->LinkCustomAttributes = "";
        $this->cancel_contract_date->HrefValue = "";
        $this->cancel_contract_date->TooltipValue = "";

        // cancel_contract_user
        $this->cancel_contract_user->LinkCustomAttributes = "";
        $this->cancel_contract_user->HrefValue = "";
        $this->cancel_contract_user->TooltipValue = "";

        // cancel_contract_ip
        $this->cancel_contract_ip->LinkCustomAttributes = "";
        $this->cancel_contract_ip->HrefValue = "";
        $this->cancel_contract_ip->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // asset_id
        $this->asset_id->setupEditAttributes();
        $this->asset_id->EditCustomAttributes = "";
        $this->asset_id->EditValue = $this->asset_id->CurrentValue;
        $this->asset_id->ViewCustomAttributes = "";

        // title
        $this->_title->setupEditAttributes();
        $this->_title->EditCustomAttributes = "";
        if (!$this->_title->Raw) {
            $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
        }
        $this->_title->EditValue = $this->_title->CurrentValue;
        $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

        // title_en
        $this->title_en->setupEditAttributes();
        $this->title_en->EditCustomAttributes = "";
        if (!$this->title_en->Raw) {
            $this->title_en->CurrentValue = HtmlDecode($this->title_en->CurrentValue);
        }
        $this->title_en->EditValue = $this->title_en->CurrentValue;
        $this->title_en->PlaceHolder = RemoveHtml($this->title_en->caption());

        // brand_id
        $this->brand_id->setupEditAttributes();
        $this->brand_id->EditCustomAttributes = "";
        $this->brand_id->PlaceHolder = RemoveHtml($this->brand_id->caption());

        // asset_short_detail
        $this->asset_short_detail->setupEditAttributes();
        $this->asset_short_detail->EditCustomAttributes = "";
        $this->asset_short_detail->EditValue = $this->asset_short_detail->CurrentValue;
        $this->asset_short_detail->PlaceHolder = RemoveHtml($this->asset_short_detail->caption());

        // asset_short_detail_en
        $this->asset_short_detail_en->setupEditAttributes();
        $this->asset_short_detail_en->EditCustomAttributes = "";
        $this->asset_short_detail_en->EditValue = $this->asset_short_detail_en->CurrentValue;
        $this->asset_short_detail_en->PlaceHolder = RemoveHtml($this->asset_short_detail_en->caption());

        // detail
        $this->detail->setupEditAttributes();
        $this->detail->EditCustomAttributes = "";
        $this->detail->EditValue = $this->detail->CurrentValue;
        $this->detail->PlaceHolder = RemoveHtml($this->detail->caption());

        // detail_en
        $this->detail_en->setupEditAttributes();
        $this->detail_en->EditCustomAttributes = "";
        $this->detail_en->EditValue = $this->detail_en->CurrentValue;
        $this->detail_en->PlaceHolder = RemoveHtml($this->detail_en->caption());

        // asset_code
        $this->asset_code->setupEditAttributes();
        $this->asset_code->EditCustomAttributes = "";
        $this->asset_code->EditValue = $this->asset_code->CurrentValue;
        $this->asset_code->ViewCustomAttributes = "";

        // asset_status
        $this->asset_status->setupEditAttributes();
        $this->asset_status->EditCustomAttributes = "";
        $this->asset_status->EditValue = $this->asset_status->options(true);
        $this->asset_status->PlaceHolder = RemoveHtml($this->asset_status->caption());

        // latitude
        $this->latitude->setupEditAttributes();
        $this->latitude->EditCustomAttributes = "";
        if (!$this->latitude->Raw) {
            $this->latitude->CurrentValue = HtmlDecode($this->latitude->CurrentValue);
        }
        $this->latitude->EditValue = $this->latitude->CurrentValue;
        $this->latitude->PlaceHolder = RemoveHtml($this->latitude->caption());

        // longitude
        $this->longitude->setupEditAttributes();
        $this->longitude->EditCustomAttributes = "";
        if (!$this->longitude->Raw) {
            $this->longitude->CurrentValue = HtmlDecode($this->longitude->CurrentValue);
        }
        $this->longitude->EditValue = $this->longitude->CurrentValue;
        $this->longitude->PlaceHolder = RemoveHtml($this->longitude->caption());

        // num_buildings
        $this->num_buildings->setupEditAttributes();
        $this->num_buildings->EditCustomAttributes = "";
        $this->num_buildings->EditValue = $this->num_buildings->CurrentValue;
        $this->num_buildings->PlaceHolder = RemoveHtml($this->num_buildings->caption());
        if (strval($this->num_buildings->EditValue) != "" && is_numeric($this->num_buildings->EditValue)) {
            $this->num_buildings->EditValue = FormatNumber($this->num_buildings->EditValue, null);
        }

        // num_unit
        $this->num_unit->setupEditAttributes();
        $this->num_unit->EditCustomAttributes = "";
        $this->num_unit->EditValue = $this->num_unit->CurrentValue;
        $this->num_unit->PlaceHolder = RemoveHtml($this->num_unit->caption());
        if (strval($this->num_unit->EditValue) != "" && is_numeric($this->num_unit->EditValue)) {
            $this->num_unit->EditValue = FormatNumber($this->num_unit->EditValue, null);
        }

        // num_floors
        $this->num_floors->setupEditAttributes();
        $this->num_floors->EditCustomAttributes = "";
        $this->num_floors->EditValue = $this->num_floors->CurrentValue;
        $this->num_floors->PlaceHolder = RemoveHtml($this->num_floors->caption());
        if (strval($this->num_floors->EditValue) != "" && is_numeric($this->num_floors->EditValue)) {
            $this->num_floors->EditValue = FormatNumber($this->num_floors->EditValue, null);
        }

        // floors
        $this->floors->setupEditAttributes();
        $this->floors->EditCustomAttributes = "";
        $this->floors->EditValue = $this->floors->CurrentValue;
        $this->floors->PlaceHolder = RemoveHtml($this->floors->caption());
        if (strval($this->floors->EditValue) != "" && is_numeric($this->floors->EditValue)) {
            $this->floors->EditValue = FormatNumber($this->floors->EditValue, null);
        }

        // asset_year_developer
        $this->asset_year_developer->setupEditAttributes();
        $this->asset_year_developer->EditCustomAttributes = "";
        $this->asset_year_developer->EditValue = $this->asset_year_developer->CurrentValue;
        $this->asset_year_developer->PlaceHolder = RemoveHtml($this->asset_year_developer->caption());
        if (strval($this->asset_year_developer->EditValue) != "" && is_numeric($this->asset_year_developer->EditValue)) {
            $this->asset_year_developer->EditValue = $this->asset_year_developer->EditValue;
        }

        // num_parking_spaces
        $this->num_parking_spaces->setupEditAttributes();
        $this->num_parking_spaces->EditCustomAttributes = "";
        if (!$this->num_parking_spaces->Raw) {
            $this->num_parking_spaces->CurrentValue = HtmlDecode($this->num_parking_spaces->CurrentValue);
        }
        $this->num_parking_spaces->EditValue = $this->num_parking_spaces->CurrentValue;
        $this->num_parking_spaces->PlaceHolder = RemoveHtml($this->num_parking_spaces->caption());

        // num_bathrooms
        $this->num_bathrooms->setupEditAttributes();
        $this->num_bathrooms->EditCustomAttributes = "";
        if (!$this->num_bathrooms->Raw) {
            $this->num_bathrooms->CurrentValue = HtmlDecode($this->num_bathrooms->CurrentValue);
        }
        $this->num_bathrooms->EditValue = $this->num_bathrooms->CurrentValue;
        $this->num_bathrooms->PlaceHolder = RemoveHtml($this->num_bathrooms->caption());

        // num_bedrooms
        $this->num_bedrooms->setupEditAttributes();
        $this->num_bedrooms->EditCustomAttributes = "";
        if (!$this->num_bedrooms->Raw) {
            $this->num_bedrooms->CurrentValue = HtmlDecode($this->num_bedrooms->CurrentValue);
        }
        $this->num_bedrooms->EditValue = $this->num_bedrooms->CurrentValue;
        $this->num_bedrooms->PlaceHolder = RemoveHtml($this->num_bedrooms->caption());

        // address
        $this->address->setupEditAttributes();
        $this->address->EditCustomAttributes = "";
        $this->address->EditValue = $this->address->CurrentValue;
        $this->address->PlaceHolder = RemoveHtml($this->address->caption());

        // address_en
        $this->address_en->setupEditAttributes();
        $this->address_en->EditCustomAttributes = "";
        $this->address_en->EditValue = $this->address_en->CurrentValue;
        $this->address_en->PlaceHolder = RemoveHtml($this->address_en->caption());

        // province_id
        $this->province_id->setupEditAttributes();
        $this->province_id->EditCustomAttributes = "";
        $this->province_id->PlaceHolder = RemoveHtml($this->province_id->caption());

        // amphur_id
        $this->amphur_id->setupEditAttributes();
        $this->amphur_id->EditCustomAttributes = "";
        $this->amphur_id->PlaceHolder = RemoveHtml($this->amphur_id->caption());

        // district_id
        $this->district_id->setupEditAttributes();
        $this->district_id->EditCustomAttributes = "";
        $this->district_id->PlaceHolder = RemoveHtml($this->district_id->caption());

        // postcode
        $this->postcode->setupEditAttributes();
        $this->postcode->EditCustomAttributes = "";
        $this->postcode->EditValue = $this->postcode->CurrentValue;
        $this->postcode->PlaceHolder = RemoveHtml($this->postcode->caption());
        if (strval($this->postcode->EditValue) != "" && is_numeric($this->postcode->EditValue)) {
            $this->postcode->EditValue = $this->postcode->EditValue;
        }

        // floor_plan
        $this->floor_plan->setupEditAttributes();
        $this->floor_plan->EditCustomAttributes = "";
        $this->floor_plan->UploadPath = './upload/floor_plan';
        if (!EmptyValue($this->floor_plan->Upload->DbValue)) {
            $this->floor_plan->ImageWidth = 100;
            $this->floor_plan->ImageHeight = 100;
            $this->floor_plan->ImageAlt = $this->floor_plan->alt();
            $this->floor_plan->ImageCssClass = "ew-image";
            $this->floor_plan->EditValue = $this->floor_plan->Upload->DbValue;
        } else {
            $this->floor_plan->EditValue = "";
        }
        if (!EmptyValue($this->floor_plan->CurrentValue)) {
            $this->floor_plan->Upload->FileName = $this->floor_plan->CurrentValue;
        }

        // layout_unit
        $this->layout_unit->setupEditAttributes();
        $this->layout_unit->EditCustomAttributes = "";
        $this->layout_unit->UploadPath = './upload/layout_unit';
        if (!EmptyValue($this->layout_unit->Upload->DbValue)) {
            $this->layout_unit->ImageWidth = 100;
            $this->layout_unit->ImageHeight = 100;
            $this->layout_unit->ImageAlt = $this->layout_unit->alt();
            $this->layout_unit->ImageCssClass = "ew-image";
            $this->layout_unit->EditValue = $this->layout_unit->Upload->DbValue;
        } else {
            $this->layout_unit->EditValue = "";
        }
        if (!EmptyValue($this->layout_unit->CurrentValue)) {
            $this->layout_unit->Upload->FileName = $this->layout_unit->CurrentValue;
        }

        // asset_website
        $this->asset_website->setupEditAttributes();
        $this->asset_website->EditCustomAttributes = "";
        $this->asset_website->EditValue = $this->asset_website->CurrentValue;
        $this->asset_website->PlaceHolder = RemoveHtml($this->asset_website->caption());

        // asset_review
        $this->asset_review->setupEditAttributes();
        $this->asset_review->EditCustomAttributes = "";
        $this->asset_review->EditValue = $this->asset_review->CurrentValue;
        $this->asset_review->PlaceHolder = RemoveHtml($this->asset_review->caption());

        // isactive
        $this->isactive->EditCustomAttributes = "";
        $this->isactive->EditValue = $this->isactive->options(false);
        $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

        // is_recommend
        $this->is_recommend->EditCustomAttributes = "";
        $this->is_recommend->EditValue = $this->is_recommend->options(false);
        $this->is_recommend->PlaceHolder = RemoveHtml($this->is_recommend->caption());

        // order_by
        $this->order_by->setupEditAttributes();
        $this->order_by->EditCustomAttributes = "";
        $this->order_by->EditValue = $this->order_by->CurrentValue;
        $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());
        if (strval($this->order_by->EditValue) != "" && is_numeric($this->order_by->EditValue)) {
            $this->order_by->EditValue = FormatNumber($this->order_by->EditValue, null);
        }

        // type_pay
        $this->type_pay->EditCustomAttributes = "";
        $this->type_pay->EditValue = $this->type_pay->options(false);
        $this->type_pay->PlaceHolder = RemoveHtml($this->type_pay->caption());

        // type_pay_2
        $this->type_pay_2->EditCustomAttributes = "";
        $this->type_pay_2->EditValue = $this->type_pay_2->options(false);
        $this->type_pay_2->PlaceHolder = RemoveHtml($this->type_pay_2->caption());

        // price_mark
        $this->price_mark->setupEditAttributes();
        $this->price_mark->EditCustomAttributes = "";
        $this->price_mark->EditValue = $this->price_mark->CurrentValue;
        $this->price_mark->PlaceHolder = RemoveHtml($this->price_mark->caption());
        if (strval($this->price_mark->EditValue) != "" && is_numeric($this->price_mark->EditValue)) {
            $this->price_mark->EditValue = FormatNumber($this->price_mark->EditValue, null);
        }

        // holding_property
        $this->holding_property->EditCustomAttributes = "";
        $this->holding_property->EditValue = $this->holding_property->options(false);
        $this->holding_property->PlaceHolder = RemoveHtml($this->holding_property->caption());

        // common_fee
        $this->common_fee->setupEditAttributes();
        $this->common_fee->EditCustomAttributes = "";
        $this->common_fee->EditValue = $this->common_fee->CurrentValue;
        $this->common_fee->PlaceHolder = RemoveHtml($this->common_fee->caption());
        if (strval($this->common_fee->EditValue) != "" && is_numeric($this->common_fee->EditValue)) {
            $this->common_fee->EditValue = FormatNumber($this->common_fee->EditValue, null);
        }

        // usable_area
        $this->usable_area->setupEditAttributes();
        $this->usable_area->EditCustomAttributes = "";
        if (!$this->usable_area->Raw) {
            $this->usable_area->CurrentValue = HtmlDecode($this->usable_area->CurrentValue);
        }
        $this->usable_area->EditValue = $this->usable_area->CurrentValue;
        $this->usable_area->PlaceHolder = RemoveHtml($this->usable_area->caption());

        // usable_area_price
        $this->usable_area_price->setupEditAttributes();
        $this->usable_area_price->EditCustomAttributes = "";
        $this->usable_area_price->EditValue = $this->usable_area_price->CurrentValue;
        $this->usable_area_price->PlaceHolder = RemoveHtml($this->usable_area_price->caption());
        if (strval($this->usable_area_price->EditValue) != "" && is_numeric($this->usable_area_price->EditValue)) {
            $this->usable_area_price->EditValue = FormatNumber($this->usable_area_price->EditValue, null);
        }

        // land_size
        $this->land_size->setupEditAttributes();
        $this->land_size->EditCustomAttributes = "";
        if (!$this->land_size->Raw) {
            $this->land_size->CurrentValue = HtmlDecode($this->land_size->CurrentValue);
        }
        $this->land_size->EditValue = $this->land_size->CurrentValue;
        $this->land_size->PlaceHolder = RemoveHtml($this->land_size->caption());

        // land_size_price
        $this->land_size_price->setupEditAttributes();
        $this->land_size_price->EditCustomAttributes = "";
        $this->land_size_price->EditValue = $this->land_size_price->CurrentValue;
        $this->land_size_price->PlaceHolder = RemoveHtml($this->land_size_price->caption());
        if (strval($this->land_size_price->EditValue) != "" && is_numeric($this->land_size_price->EditValue)) {
            $this->land_size_price->EditValue = FormatNumber($this->land_size_price->EditValue, null);
        }

        // commission
        $this->commission->setupEditAttributes();
        $this->commission->EditCustomAttributes = "";
        $this->commission->EditValue = $this->commission->CurrentValue;
        $this->commission->PlaceHolder = RemoveHtml($this->commission->caption());
        if (strval($this->commission->EditValue) != "" && is_numeric($this->commission->EditValue)) {
            $this->commission->EditValue = FormatNumber($this->commission->EditValue, null);
        }

        // transfer_day_expenses_with_business_tax
        $this->transfer_day_expenses_with_business_tax->setupEditAttributes();
        $this->transfer_day_expenses_with_business_tax->EditCustomAttributes = "";
        $this->transfer_day_expenses_with_business_tax->EditValue = $this->transfer_day_expenses_with_business_tax->CurrentValue;
        $this->transfer_day_expenses_with_business_tax->PlaceHolder = RemoveHtml($this->transfer_day_expenses_with_business_tax->caption());
        if (strval($this->transfer_day_expenses_with_business_tax->EditValue) != "" && is_numeric($this->transfer_day_expenses_with_business_tax->EditValue)) {
            $this->transfer_day_expenses_with_business_tax->EditValue = FormatNumber($this->transfer_day_expenses_with_business_tax->EditValue, null);
        }

        // transfer_day_expenses_without_business_tax
        $this->transfer_day_expenses_without_business_tax->setupEditAttributes();
        $this->transfer_day_expenses_without_business_tax->EditCustomAttributes = "";
        $this->transfer_day_expenses_without_business_tax->EditValue = $this->transfer_day_expenses_without_business_tax->CurrentValue;
        $this->transfer_day_expenses_without_business_tax->PlaceHolder = RemoveHtml($this->transfer_day_expenses_without_business_tax->caption());
        if (strval($this->transfer_day_expenses_without_business_tax->EditValue) != "" && is_numeric($this->transfer_day_expenses_without_business_tax->EditValue)) {
            $this->transfer_day_expenses_without_business_tax->EditValue = FormatNumber($this->transfer_day_expenses_without_business_tax->EditValue, null);
        }

        // price
        $this->price->setupEditAttributes();
        $this->price->EditCustomAttributes = "";
        $this->price->EditValue = $this->price->CurrentValue;
        $this->price->PlaceHolder = RemoveHtml($this->price->caption());
        if (strval($this->price->EditValue) != "" && is_numeric($this->price->EditValue)) {
            $this->price->EditValue = FormatNumber($this->price->EditValue, null);
        }

        // discount
        $this->discount->setupEditAttributes();
        $this->discount->EditCustomAttributes = "";
        $this->discount->EditValue = $this->discount->CurrentValue;
        $this->discount->PlaceHolder = RemoveHtml($this->discount->caption());
        if (strval($this->discount->EditValue) != "" && is_numeric($this->discount->EditValue)) {
            $this->discount->EditValue = FormatNumber($this->discount->EditValue, null);
        }

        // price_special
        $this->price_special->setupEditAttributes();
        $this->price_special->EditCustomAttributes = "";
        $this->price_special->EditValue = $this->price_special->CurrentValue;
        $this->price_special->PlaceHolder = RemoveHtml($this->price_special->caption());
        if (strval($this->price_special->EditValue) != "" && is_numeric($this->price_special->EditValue)) {
            $this->price_special->EditValue = FormatNumber($this->price_special->EditValue, null);
        }

        // reservation_price_model_a
        $this->reservation_price_model_a->setupEditAttributes();
        $this->reservation_price_model_a->EditCustomAttributes = "";
        $this->reservation_price_model_a->EditValue = $this->reservation_price_model_a->CurrentValue;
        $this->reservation_price_model_a->PlaceHolder = RemoveHtml($this->reservation_price_model_a->caption());
        if (strval($this->reservation_price_model_a->EditValue) != "" && is_numeric($this->reservation_price_model_a->EditValue)) {
            $this->reservation_price_model_a->EditValue = FormatNumber($this->reservation_price_model_a->EditValue, null);
        }

        // minimum_down_payment_model_a
        $this->minimum_down_payment_model_a->setupEditAttributes();
        $this->minimum_down_payment_model_a->EditCustomAttributes = "";
        $this->minimum_down_payment_model_a->EditValue = $this->minimum_down_payment_model_a->CurrentValue;
        $this->minimum_down_payment_model_a->PlaceHolder = RemoveHtml($this->minimum_down_payment_model_a->caption());
        if (strval($this->minimum_down_payment_model_a->EditValue) != "" && is_numeric($this->minimum_down_payment_model_a->EditValue)) {
            $this->minimum_down_payment_model_a->EditValue = FormatNumber($this->minimum_down_payment_model_a->EditValue, null);
        }

        // down_price_min_a
        $this->down_price_min_a->setupEditAttributes();
        $this->down_price_min_a->EditCustomAttributes = "";
        $this->down_price_min_a->EditValue = $this->down_price_min_a->CurrentValue;
        $this->down_price_min_a->PlaceHolder = RemoveHtml($this->down_price_min_a->caption());
        if (strval($this->down_price_min_a->EditValue) != "" && is_numeric($this->down_price_min_a->EditValue)) {
            $this->down_price_min_a->EditValue = FormatNumber($this->down_price_min_a->EditValue, null);
        }

        // down_price_model_a
        $this->down_price_model_a->setupEditAttributes();
        $this->down_price_model_a->EditCustomAttributes = "";
        $this->down_price_model_a->EditValue = $this->down_price_model_a->CurrentValue;
        $this->down_price_model_a->PlaceHolder = RemoveHtml($this->down_price_model_a->caption());
        if (strval($this->down_price_model_a->EditValue) != "" && is_numeric($this->down_price_model_a->EditValue)) {
            $this->down_price_model_a->EditValue = FormatNumber($this->down_price_model_a->EditValue, null);
        }

        // factor_monthly_installment_over_down
        $this->factor_monthly_installment_over_down->setupEditAttributes();
        $this->factor_monthly_installment_over_down->EditCustomAttributes = "";
        $this->factor_monthly_installment_over_down->EditValue = $this->factor_monthly_installment_over_down->CurrentValue;
        $this->factor_monthly_installment_over_down->PlaceHolder = RemoveHtml($this->factor_monthly_installment_over_down->caption());
        if (strval($this->factor_monthly_installment_over_down->EditValue) != "" && is_numeric($this->factor_monthly_installment_over_down->EditValue)) {
            $this->factor_monthly_installment_over_down->EditValue = FormatNumber($this->factor_monthly_installment_over_down->EditValue, null);
        }

        // fee_a
        $this->fee_a->setupEditAttributes();
        $this->fee_a->EditCustomAttributes = "";
        $this->fee_a->EditValue = $this->fee_a->CurrentValue;
        $this->fee_a->PlaceHolder = RemoveHtml($this->fee_a->caption());
        if (strval($this->fee_a->EditValue) != "" && is_numeric($this->fee_a->EditValue)) {
            $this->fee_a->EditValue = FormatNumber($this->fee_a->EditValue, null);
        }

        // monthly_payment_buyer
        $this->monthly_payment_buyer->setupEditAttributes();
        $this->monthly_payment_buyer->EditCustomAttributes = "";
        $this->monthly_payment_buyer->EditValue = $this->monthly_payment_buyer->CurrentValue;
        $this->monthly_payment_buyer->PlaceHolder = RemoveHtml($this->monthly_payment_buyer->caption());
        if (strval($this->monthly_payment_buyer->EditValue) != "" && is_numeric($this->monthly_payment_buyer->EditValue)) {
            $this->monthly_payment_buyer->EditValue = FormatNumber($this->monthly_payment_buyer->EditValue, null);
        }

        // annual_interest_buyer_model_a
        $this->annual_interest_buyer_model_a->setupEditAttributes();
        $this->annual_interest_buyer_model_a->EditCustomAttributes = "";
        $this->annual_interest_buyer_model_a->EditValue = $this->annual_interest_buyer_model_a->CurrentValue;
        $this->annual_interest_buyer_model_a->PlaceHolder = RemoveHtml($this->annual_interest_buyer_model_a->caption());
        if (strval($this->annual_interest_buyer_model_a->EditValue) != "" && is_numeric($this->annual_interest_buyer_model_a->EditValue)) {
            $this->annual_interest_buyer_model_a->EditValue = FormatNumber($this->annual_interest_buyer_model_a->EditValue, null);
        }

        // monthly_expenses_a
        $this->monthly_expenses_a->setupEditAttributes();
        $this->monthly_expenses_a->EditCustomAttributes = "";
        $this->monthly_expenses_a->EditValue = $this->monthly_expenses_a->CurrentValue;
        $this->monthly_expenses_a->PlaceHolder = RemoveHtml($this->monthly_expenses_a->caption());
        if (strval($this->monthly_expenses_a->EditValue) != "" && is_numeric($this->monthly_expenses_a->EditValue)) {
            $this->monthly_expenses_a->EditValue = FormatNumber($this->monthly_expenses_a->EditValue, null);
        }

        // average_rent_a
        $this->average_rent_a->setupEditAttributes();
        $this->average_rent_a->EditCustomAttributes = "";
        $this->average_rent_a->EditValue = $this->average_rent_a->CurrentValue;
        $this->average_rent_a->PlaceHolder = RemoveHtml($this->average_rent_a->caption());
        if (strval($this->average_rent_a->EditValue) != "" && is_numeric($this->average_rent_a->EditValue)) {
            $this->average_rent_a->EditValue = FormatNumber($this->average_rent_a->EditValue, null);
        }

        // average_down_payment_a
        $this->average_down_payment_a->setupEditAttributes();
        $this->average_down_payment_a->EditCustomAttributes = "";
        $this->average_down_payment_a->EditValue = $this->average_down_payment_a->CurrentValue;
        $this->average_down_payment_a->PlaceHolder = RemoveHtml($this->average_down_payment_a->caption());
        if (strval($this->average_down_payment_a->EditValue) != "" && is_numeric($this->average_down_payment_a->EditValue)) {
            $this->average_down_payment_a->EditValue = FormatNumber($this->average_down_payment_a->EditValue, null);
        }

        // transfer_day_expenses_without_business_tax_max_min
        $this->transfer_day_expenses_without_business_tax_max_min->setupEditAttributes();
        $this->transfer_day_expenses_without_business_tax_max_min->EditCustomAttributes = "";
        $this->transfer_day_expenses_without_business_tax_max_min->EditValue = $this->transfer_day_expenses_without_business_tax_max_min->CurrentValue;
        $this->transfer_day_expenses_without_business_tax_max_min->PlaceHolder = RemoveHtml($this->transfer_day_expenses_without_business_tax_max_min->caption());
        if (strval($this->transfer_day_expenses_without_business_tax_max_min->EditValue) != "" && is_numeric($this->transfer_day_expenses_without_business_tax_max_min->EditValue)) {
            $this->transfer_day_expenses_without_business_tax_max_min->EditValue = FormatNumber($this->transfer_day_expenses_without_business_tax_max_min->EditValue, null);
        }

        // transfer_day_expenses_with_business_tax_max_min
        $this->transfer_day_expenses_with_business_tax_max_min->setupEditAttributes();
        $this->transfer_day_expenses_with_business_tax_max_min->EditCustomAttributes = "";
        $this->transfer_day_expenses_with_business_tax_max_min->EditValue = $this->transfer_day_expenses_with_business_tax_max_min->CurrentValue;
        $this->transfer_day_expenses_with_business_tax_max_min->PlaceHolder = RemoveHtml($this->transfer_day_expenses_with_business_tax_max_min->caption());
        if (strval($this->transfer_day_expenses_with_business_tax_max_min->EditValue) != "" && is_numeric($this->transfer_day_expenses_with_business_tax_max_min->EditValue)) {
            $this->transfer_day_expenses_with_business_tax_max_min->EditValue = FormatNumber($this->transfer_day_expenses_with_business_tax_max_min->EditValue, null);
        }

        // bank_appraisal_price
        $this->bank_appraisal_price->setupEditAttributes();
        $this->bank_appraisal_price->EditCustomAttributes = "";
        $this->bank_appraisal_price->EditValue = $this->bank_appraisal_price->CurrentValue;
        $this->bank_appraisal_price->PlaceHolder = RemoveHtml($this->bank_appraisal_price->caption());
        if (strval($this->bank_appraisal_price->EditValue) != "" && is_numeric($this->bank_appraisal_price->EditValue)) {
            $this->bank_appraisal_price->EditValue = FormatNumber($this->bank_appraisal_price->EditValue, null);
        }

        // mark_up_price
        $this->mark_up_price->setupEditAttributes();
        $this->mark_up_price->EditCustomAttributes = "";
        $this->mark_up_price->EditValue = $this->mark_up_price->CurrentValue;
        $this->mark_up_price->PlaceHolder = RemoveHtml($this->mark_up_price->caption());
        if (strval($this->mark_up_price->EditValue) != "" && is_numeric($this->mark_up_price->EditValue)) {
            $this->mark_up_price->EditValue = FormatNumber($this->mark_up_price->EditValue, null);
        }

        // required_gap
        $this->required_gap->setupEditAttributes();
        $this->required_gap->EditCustomAttributes = "";
        $this->required_gap->EditValue = $this->required_gap->CurrentValue;
        $this->required_gap->PlaceHolder = RemoveHtml($this->required_gap->caption());
        if (strval($this->required_gap->EditValue) != "" && is_numeric($this->required_gap->EditValue)) {
            $this->required_gap->EditValue = FormatNumber($this->required_gap->EditValue, null);
        }

        // minimum_down_payment
        $this->minimum_down_payment->setupEditAttributes();
        $this->minimum_down_payment->EditCustomAttributes = "";
        $this->minimum_down_payment->EditValue = $this->minimum_down_payment->CurrentValue;
        $this->minimum_down_payment->PlaceHolder = RemoveHtml($this->minimum_down_payment->caption());
        if (strval($this->minimum_down_payment->EditValue) != "" && is_numeric($this->minimum_down_payment->EditValue)) {
            $this->minimum_down_payment->EditValue = FormatNumber($this->minimum_down_payment->EditValue, null);
        }

        // price_down_max
        $this->price_down_max->setupEditAttributes();
        $this->price_down_max->EditCustomAttributes = "";
        $this->price_down_max->EditValue = $this->price_down_max->CurrentValue;
        $this->price_down_max->PlaceHolder = RemoveHtml($this->price_down_max->caption());
        if (strval($this->price_down_max->EditValue) != "" && is_numeric($this->price_down_max->EditValue)) {
            $this->price_down_max->EditValue = FormatNumber($this->price_down_max->EditValue, null);
        }

        // discount_max
        $this->discount_max->setupEditAttributes();
        $this->discount_max->EditCustomAttributes = "";
        $this->discount_max->EditValue = $this->discount_max->CurrentValue;
        $this->discount_max->PlaceHolder = RemoveHtml($this->discount_max->caption());
        if (strval($this->discount_max->EditValue) != "" && is_numeric($this->discount_max->EditValue)) {
            $this->discount_max->EditValue = FormatNumber($this->discount_max->EditValue, null);
        }

        // price_down_special_max
        $this->price_down_special_max->setupEditAttributes();
        $this->price_down_special_max->EditCustomAttributes = "";
        $this->price_down_special_max->EditValue = $this->price_down_special_max->CurrentValue;
        $this->price_down_special_max->PlaceHolder = RemoveHtml($this->price_down_special_max->caption());
        if (strval($this->price_down_special_max->EditValue) != "" && is_numeric($this->price_down_special_max->EditValue)) {
            $this->price_down_special_max->EditValue = FormatNumber($this->price_down_special_max->EditValue, null);
        }

        // usable_area_price_max
        $this->usable_area_price_max->setupEditAttributes();
        $this->usable_area_price_max->EditCustomAttributes = "";
        $this->usable_area_price_max->EditValue = $this->usable_area_price_max->CurrentValue;
        $this->usable_area_price_max->PlaceHolder = RemoveHtml($this->usable_area_price_max->caption());
        if (strval($this->usable_area_price_max->EditValue) != "" && is_numeric($this->usable_area_price_max->EditValue)) {
            $this->usable_area_price_max->EditValue = FormatNumber($this->usable_area_price_max->EditValue, null);
        }

        // land_size_price_max
        $this->land_size_price_max->setupEditAttributes();
        $this->land_size_price_max->EditCustomAttributes = "";
        $this->land_size_price_max->EditValue = $this->land_size_price_max->CurrentValue;
        $this->land_size_price_max->PlaceHolder = RemoveHtml($this->land_size_price_max->caption());
        if (strval($this->land_size_price_max->EditValue) != "" && is_numeric($this->land_size_price_max->EditValue)) {
            $this->land_size_price_max->EditValue = FormatNumber($this->land_size_price_max->EditValue, null);
        }

        // reservation_price_max
        $this->reservation_price_max->setupEditAttributes();
        $this->reservation_price_max->EditCustomAttributes = "";
        $this->reservation_price_max->EditValue = $this->reservation_price_max->CurrentValue;
        $this->reservation_price_max->PlaceHolder = RemoveHtml($this->reservation_price_max->caption());
        if (strval($this->reservation_price_max->EditValue) != "" && is_numeric($this->reservation_price_max->EditValue)) {
            $this->reservation_price_max->EditValue = FormatNumber($this->reservation_price_max->EditValue, null);
        }

        // minimum_down_payment_max
        $this->minimum_down_payment_max->setupEditAttributes();
        $this->minimum_down_payment_max->EditCustomAttributes = "";
        $this->minimum_down_payment_max->EditValue = $this->minimum_down_payment_max->CurrentValue;
        $this->minimum_down_payment_max->PlaceHolder = RemoveHtml($this->minimum_down_payment_max->caption());
        if (strval($this->minimum_down_payment_max->EditValue) != "" && is_numeric($this->minimum_down_payment_max->EditValue)) {
            $this->minimum_down_payment_max->EditValue = FormatNumber($this->minimum_down_payment_max->EditValue, null);
        }

        // down_price_max
        $this->down_price_max->setupEditAttributes();
        $this->down_price_max->EditCustomAttributes = "";
        $this->down_price_max->EditValue = $this->down_price_max->CurrentValue;
        $this->down_price_max->PlaceHolder = RemoveHtml($this->down_price_max->caption());
        if (strval($this->down_price_max->EditValue) != "" && is_numeric($this->down_price_max->EditValue)) {
            $this->down_price_max->EditValue = FormatNumber($this->down_price_max->EditValue, null);
        }

        // down_price
        $this->down_price->setupEditAttributes();
        $this->down_price->EditCustomAttributes = "";
        $this->down_price->EditValue = $this->down_price->CurrentValue;
        $this->down_price->PlaceHolder = RemoveHtml($this->down_price->caption());
        if (strval($this->down_price->EditValue) != "" && is_numeric($this->down_price->EditValue)) {
            $this->down_price->EditValue = FormatNumber($this->down_price->EditValue, null);
        }

        // factor_monthly_installment_over_down_max
        $this->factor_monthly_installment_over_down_max->setupEditAttributes();
        $this->factor_monthly_installment_over_down_max->EditCustomAttributes = "";
        $this->factor_monthly_installment_over_down_max->EditValue = $this->factor_monthly_installment_over_down_max->CurrentValue;
        $this->factor_monthly_installment_over_down_max->PlaceHolder = RemoveHtml($this->factor_monthly_installment_over_down_max->caption());
        if (strval($this->factor_monthly_installment_over_down_max->EditValue) != "" && is_numeric($this->factor_monthly_installment_over_down_max->EditValue)) {
            $this->factor_monthly_installment_over_down_max->EditValue = FormatNumber($this->factor_monthly_installment_over_down_max->EditValue, null);
        }

        // fee_max
        $this->fee_max->setupEditAttributes();
        $this->fee_max->EditCustomAttributes = "";
        $this->fee_max->EditValue = $this->fee_max->CurrentValue;
        $this->fee_max->PlaceHolder = RemoveHtml($this->fee_max->caption());
        if (strval($this->fee_max->EditValue) != "" && is_numeric($this->fee_max->EditValue)) {
            $this->fee_max->EditValue = FormatNumber($this->fee_max->EditValue, null);
        }

        // monthly_payment_max
        $this->monthly_payment_max->setupEditAttributes();
        $this->monthly_payment_max->EditCustomAttributes = "";
        $this->monthly_payment_max->EditValue = $this->monthly_payment_max->CurrentValue;
        $this->monthly_payment_max->PlaceHolder = RemoveHtml($this->monthly_payment_max->caption());
        if (strval($this->monthly_payment_max->EditValue) != "" && is_numeric($this->monthly_payment_max->EditValue)) {
            $this->monthly_payment_max->EditValue = FormatNumber($this->monthly_payment_max->EditValue, null);
        }

        // annual_interest_buyer
        $this->annual_interest_buyer->setupEditAttributes();
        $this->annual_interest_buyer->EditCustomAttributes = "";
        $this->annual_interest_buyer->EditValue = $this->annual_interest_buyer->CurrentValue;
        $this->annual_interest_buyer->PlaceHolder = RemoveHtml($this->annual_interest_buyer->caption());
        if (strval($this->annual_interest_buyer->EditValue) != "" && is_numeric($this->annual_interest_buyer->EditValue)) {
            $this->annual_interest_buyer->EditValue = FormatNumber($this->annual_interest_buyer->EditValue, null);
        }

        // monthly_expense_max
        $this->monthly_expense_max->setupEditAttributes();
        $this->monthly_expense_max->EditCustomAttributes = "";
        $this->monthly_expense_max->EditValue = $this->monthly_expense_max->CurrentValue;
        $this->monthly_expense_max->PlaceHolder = RemoveHtml($this->monthly_expense_max->caption());
        if (strval($this->monthly_expense_max->EditValue) != "" && is_numeric($this->monthly_expense_max->EditValue)) {
            $this->monthly_expense_max->EditValue = FormatNumber($this->monthly_expense_max->EditValue, null);
        }

        // average_rent_max
        $this->average_rent_max->setupEditAttributes();
        $this->average_rent_max->EditCustomAttributes = "";
        $this->average_rent_max->EditValue = $this->average_rent_max->CurrentValue;
        $this->average_rent_max->PlaceHolder = RemoveHtml($this->average_rent_max->caption());
        if (strval($this->average_rent_max->EditValue) != "" && is_numeric($this->average_rent_max->EditValue)) {
            $this->average_rent_max->EditValue = FormatNumber($this->average_rent_max->EditValue, null);
        }

        // average_down_payment_max
        $this->average_down_payment_max->setupEditAttributes();
        $this->average_down_payment_max->EditCustomAttributes = "";
        $this->average_down_payment_max->EditValue = $this->average_down_payment_max->CurrentValue;
        $this->average_down_payment_max->PlaceHolder = RemoveHtml($this->average_down_payment_max->caption());
        if (strval($this->average_down_payment_max->EditValue) != "" && is_numeric($this->average_down_payment_max->EditValue)) {
            $this->average_down_payment_max->EditValue = FormatNumber($this->average_down_payment_max->EditValue, null);
        }

        // min_down
        $this->min_down->setupEditAttributes();
        $this->min_down->EditCustomAttributes = "";
        $this->min_down->EditValue = $this->min_down->CurrentValue;
        $this->min_down->PlaceHolder = RemoveHtml($this->min_down->caption());
        if (strval($this->min_down->EditValue) != "" && is_numeric($this->min_down->EditValue)) {
            $this->min_down->EditValue = FormatNumber($this->min_down->EditValue, null);
        }

        // remaining_down
        $this->remaining_down->setupEditAttributes();
        $this->remaining_down->EditCustomAttributes = "";
        $this->remaining_down->EditValue = $this->remaining_down->CurrentValue;
        $this->remaining_down->PlaceHolder = RemoveHtml($this->remaining_down->caption());
        if (strval($this->remaining_down->EditValue) != "" && is_numeric($this->remaining_down->EditValue)) {
            $this->remaining_down->EditValue = FormatNumber($this->remaining_down->EditValue, null);
        }

        // factor_financing
        $this->factor_financing->setupEditAttributes();
        $this->factor_financing->EditCustomAttributes = "";
        $this->factor_financing->EditValue = $this->factor_financing->CurrentValue;
        $this->factor_financing->PlaceHolder = RemoveHtml($this->factor_financing->caption());
        if (strval($this->factor_financing->EditValue) != "" && is_numeric($this->factor_financing->EditValue)) {
            $this->factor_financing->EditValue = FormatNumber($this->factor_financing->EditValue, null);
        }

        // credit_limit_down
        $this->credit_limit_down->setupEditAttributes();
        $this->credit_limit_down->EditCustomAttributes = "";
        $this->credit_limit_down->EditValue = $this->credit_limit_down->CurrentValue;
        $this->credit_limit_down->PlaceHolder = RemoveHtml($this->credit_limit_down->caption());
        if (strval($this->credit_limit_down->EditValue) != "" && is_numeric($this->credit_limit_down->EditValue)) {
            $this->credit_limit_down->EditValue = FormatNumber($this->credit_limit_down->EditValue, null);
        }

        // price_down_min
        $this->price_down_min->setupEditAttributes();
        $this->price_down_min->EditCustomAttributes = "";
        $this->price_down_min->EditValue = $this->price_down_min->CurrentValue;
        $this->price_down_min->PlaceHolder = RemoveHtml($this->price_down_min->caption());
        if (strval($this->price_down_min->EditValue) != "" && is_numeric($this->price_down_min->EditValue)) {
            $this->price_down_min->EditValue = FormatNumber($this->price_down_min->EditValue, null);
        }

        // discount_min
        $this->discount_min->setupEditAttributes();
        $this->discount_min->EditCustomAttributes = "";
        $this->discount_min->EditValue = $this->discount_min->CurrentValue;
        $this->discount_min->PlaceHolder = RemoveHtml($this->discount_min->caption());
        if (strval($this->discount_min->EditValue) != "" && is_numeric($this->discount_min->EditValue)) {
            $this->discount_min->EditValue = FormatNumber($this->discount_min->EditValue, null);
        }

        // price_down_special_min
        $this->price_down_special_min->setupEditAttributes();
        $this->price_down_special_min->EditCustomAttributes = "";
        $this->price_down_special_min->EditValue = $this->price_down_special_min->CurrentValue;
        $this->price_down_special_min->PlaceHolder = RemoveHtml($this->price_down_special_min->caption());
        if (strval($this->price_down_special_min->EditValue) != "" && is_numeric($this->price_down_special_min->EditValue)) {
            $this->price_down_special_min->EditValue = FormatNumber($this->price_down_special_min->EditValue, null);
        }

        // usable_area_price_min
        $this->usable_area_price_min->setupEditAttributes();
        $this->usable_area_price_min->EditCustomAttributes = "";
        $this->usable_area_price_min->EditValue = $this->usable_area_price_min->CurrentValue;
        $this->usable_area_price_min->PlaceHolder = RemoveHtml($this->usable_area_price_min->caption());
        if (strval($this->usable_area_price_min->EditValue) != "" && is_numeric($this->usable_area_price_min->EditValue)) {
            $this->usable_area_price_min->EditValue = FormatNumber($this->usable_area_price_min->EditValue, null);
        }

        // land_size_price_min
        $this->land_size_price_min->setupEditAttributes();
        $this->land_size_price_min->EditCustomAttributes = "";
        $this->land_size_price_min->EditValue = $this->land_size_price_min->CurrentValue;
        $this->land_size_price_min->PlaceHolder = RemoveHtml($this->land_size_price_min->caption());
        if (strval($this->land_size_price_min->EditValue) != "" && is_numeric($this->land_size_price_min->EditValue)) {
            $this->land_size_price_min->EditValue = FormatNumber($this->land_size_price_min->EditValue, null);
        }

        // reservation_price_min
        $this->reservation_price_min->setupEditAttributes();
        $this->reservation_price_min->EditCustomAttributes = "";
        $this->reservation_price_min->EditValue = $this->reservation_price_min->CurrentValue;
        $this->reservation_price_min->PlaceHolder = RemoveHtml($this->reservation_price_min->caption());
        if (strval($this->reservation_price_min->EditValue) != "" && is_numeric($this->reservation_price_min->EditValue)) {
            $this->reservation_price_min->EditValue = FormatNumber($this->reservation_price_min->EditValue, null);
        }

        // minimum_down_payment_min
        $this->minimum_down_payment_min->setupEditAttributes();
        $this->minimum_down_payment_min->EditCustomAttributes = "";
        $this->minimum_down_payment_min->EditValue = $this->minimum_down_payment_min->CurrentValue;
        $this->minimum_down_payment_min->PlaceHolder = RemoveHtml($this->minimum_down_payment_min->caption());
        if (strval($this->minimum_down_payment_min->EditValue) != "" && is_numeric($this->minimum_down_payment_min->EditValue)) {
            $this->minimum_down_payment_min->EditValue = FormatNumber($this->minimum_down_payment_min->EditValue, null);
        }

        // down_price_min
        $this->down_price_min->setupEditAttributes();
        $this->down_price_min->EditCustomAttributes = "";
        $this->down_price_min->EditValue = $this->down_price_min->CurrentValue;
        $this->down_price_min->PlaceHolder = RemoveHtml($this->down_price_min->caption());
        if (strval($this->down_price_min->EditValue) != "" && is_numeric($this->down_price_min->EditValue)) {
            $this->down_price_min->EditValue = FormatNumber($this->down_price_min->EditValue, null);
        }

        // remaining_credit_limit_down
        $this->remaining_credit_limit_down->setupEditAttributes();
        $this->remaining_credit_limit_down->EditCustomAttributes = "";
        $this->remaining_credit_limit_down->EditValue = $this->remaining_credit_limit_down->CurrentValue;
        $this->remaining_credit_limit_down->PlaceHolder = RemoveHtml($this->remaining_credit_limit_down->caption());
        if (strval($this->remaining_credit_limit_down->EditValue) != "" && is_numeric($this->remaining_credit_limit_down->EditValue)) {
            $this->remaining_credit_limit_down->EditValue = FormatNumber($this->remaining_credit_limit_down->EditValue, null);
        }

        // fee_min
        $this->fee_min->setupEditAttributes();
        $this->fee_min->EditCustomAttributes = "";
        $this->fee_min->EditValue = $this->fee_min->CurrentValue;
        $this->fee_min->PlaceHolder = RemoveHtml($this->fee_min->caption());
        if (strval($this->fee_min->EditValue) != "" && is_numeric($this->fee_min->EditValue)) {
            $this->fee_min->EditValue = FormatNumber($this->fee_min->EditValue, null);
        }

        // monthly_payment_min
        $this->monthly_payment_min->setupEditAttributes();
        $this->monthly_payment_min->EditCustomAttributes = "";
        $this->monthly_payment_min->EditValue = $this->monthly_payment_min->CurrentValue;
        $this->monthly_payment_min->PlaceHolder = RemoveHtml($this->monthly_payment_min->caption());
        if (strval($this->monthly_payment_min->EditValue) != "" && is_numeric($this->monthly_payment_min->EditValue)) {
            $this->monthly_payment_min->EditValue = FormatNumber($this->monthly_payment_min->EditValue, null);
        }

        // annual_interest_buyer_model_min
        $this->annual_interest_buyer_model_min->setupEditAttributes();
        $this->annual_interest_buyer_model_min->EditCustomAttributes = "";
        $this->annual_interest_buyer_model_min->EditValue = $this->annual_interest_buyer_model_min->CurrentValue;
        $this->annual_interest_buyer_model_min->PlaceHolder = RemoveHtml($this->annual_interest_buyer_model_min->caption());
        if (strval($this->annual_interest_buyer_model_min->EditValue) != "" && is_numeric($this->annual_interest_buyer_model_min->EditValue)) {
            $this->annual_interest_buyer_model_min->EditValue = FormatNumber($this->annual_interest_buyer_model_min->EditValue, null);
        }

        // interest_down-payment_financing
        $this->interest_downpayment_financing->setupEditAttributes();
        $this->interest_downpayment_financing->EditCustomAttributes = "";
        $this->interest_downpayment_financing->EditValue = $this->interest_downpayment_financing->CurrentValue;
        $this->interest_downpayment_financing->PlaceHolder = RemoveHtml($this->interest_downpayment_financing->caption());
        if (strval($this->interest_downpayment_financing->EditValue) != "" && is_numeric($this->interest_downpayment_financing->EditValue)) {
            $this->interest_downpayment_financing->EditValue = FormatNumber($this->interest_downpayment_financing->EditValue, null);
        }

        // monthly_expenses_min
        $this->monthly_expenses_min->setupEditAttributes();
        $this->monthly_expenses_min->EditCustomAttributes = "";
        $this->monthly_expenses_min->EditValue = $this->monthly_expenses_min->CurrentValue;
        $this->monthly_expenses_min->PlaceHolder = RemoveHtml($this->monthly_expenses_min->caption());
        if (strval($this->monthly_expenses_min->EditValue) != "" && is_numeric($this->monthly_expenses_min->EditValue)) {
            $this->monthly_expenses_min->EditValue = FormatNumber($this->monthly_expenses_min->EditValue, null);
        }

        // average_rent_min
        $this->average_rent_min->setupEditAttributes();
        $this->average_rent_min->EditCustomAttributes = "";
        $this->average_rent_min->EditValue = $this->average_rent_min->CurrentValue;
        $this->average_rent_min->PlaceHolder = RemoveHtml($this->average_rent_min->caption());
        if (strval($this->average_rent_min->EditValue) != "" && is_numeric($this->average_rent_min->EditValue)) {
            $this->average_rent_min->EditValue = FormatNumber($this->average_rent_min->EditValue, null);
        }

        // average_down_payment_min
        $this->average_down_payment_min->setupEditAttributes();
        $this->average_down_payment_min->EditCustomAttributes = "";
        $this->average_down_payment_min->EditValue = $this->average_down_payment_min->CurrentValue;
        $this->average_down_payment_min->PlaceHolder = RemoveHtml($this->average_down_payment_min->caption());
        if (strval($this->average_down_payment_min->EditValue) != "" && is_numeric($this->average_down_payment_min->EditValue)) {
            $this->average_down_payment_min->EditValue = FormatNumber($this->average_down_payment_min->EditValue, null);
        }

        // installment_down_payment_loan
        $this->installment_down_payment_loan->setupEditAttributes();
        $this->installment_down_payment_loan->EditCustomAttributes = "";
        $this->installment_down_payment_loan->EditValue = $this->installment_down_payment_loan->CurrentValue;
        $this->installment_down_payment_loan->PlaceHolder = RemoveHtml($this->installment_down_payment_loan->caption());
        if (strval($this->installment_down_payment_loan->EditValue) != "" && is_numeric($this->installment_down_payment_loan->EditValue)) {
            $this->installment_down_payment_loan->EditValue = FormatNumber($this->installment_down_payment_loan->EditValue, null);
        }

        // count_view
        $this->count_view->setupEditAttributes();
        $this->count_view->EditCustomAttributes = "";
        $this->count_view->EditValue = $this->count_view->CurrentValue;
        $this->count_view->EditValue = FormatNumber($this->count_view->EditValue, $this->count_view->formatPattern());
        $this->count_view->ViewCustomAttributes = "";

        // count_favorite
        $this->count_favorite->setupEditAttributes();
        $this->count_favorite->EditCustomAttributes = "";
        $this->count_favorite->EditValue = $this->count_favorite->CurrentValue;
        $this->count_favorite->EditValue = FormatNumber($this->count_favorite->EditValue, $this->count_favorite->formatPattern());
        $this->count_favorite->ViewCustomAttributes = "";

        // price_invertor
        $this->price_invertor->setupEditAttributes();
        $this->price_invertor->EditCustomAttributes = "";
        $this->price_invertor->EditValue = $this->price_invertor->CurrentValue;
        $this->price_invertor->PlaceHolder = RemoveHtml($this->price_invertor->caption());
        if (strval($this->price_invertor->EditValue) != "" && is_numeric($this->price_invertor->EditValue)) {
            $this->price_invertor->EditValue = FormatNumber($this->price_invertor->EditValue, null);
        }

        // installment_price
        $this->installment_price->setupEditAttributes();
        $this->installment_price->EditCustomAttributes = "";
        $this->installment_price->EditValue = $this->installment_price->CurrentValue;
        $this->installment_price->PlaceHolder = RemoveHtml($this->installment_price->caption());
        if (strval($this->installment_price->EditValue) != "" && is_numeric($this->installment_price->EditValue)) {
            $this->installment_price->EditValue = FormatNumber($this->installment_price->EditValue, null);
        }

        // installment_all
        $this->installment_all->setupEditAttributes();
        $this->installment_all->EditCustomAttributes = "";
        $this->installment_all->EditValue = $this->installment_all->CurrentValue;
        $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
        if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
            $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
        }

        // master_calculator
        $this->master_calculator->setupEditAttributes();
        $this->master_calculator->EditCustomAttributes = "";
        $this->master_calculator->EditValue = $this->master_calculator->CurrentValue;
        $this->master_calculator->PlaceHolder = RemoveHtml($this->master_calculator->caption());
        if (strval($this->master_calculator->EditValue) != "" && is_numeric($this->master_calculator->EditValue)) {
            $this->master_calculator->EditValue = FormatNumber($this->master_calculator->EditValue, null);
        }

        // expired_date
        $this->expired_date->setupEditAttributes();
        $this->expired_date->EditCustomAttributes = "";
        $this->expired_date->EditValue = FormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
        $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

        // tag
        $this->tag->setupEditAttributes();
        $this->tag->EditCustomAttributes = "";
        $this->tag->EditValue = $this->tag->CurrentValue;
        $this->tag->PlaceHolder = RemoveHtml($this->tag->caption());

        // cdate

        // cuser

        // cip

        // uip

        // udate

        // uuser

        // update_expired_key
        $this->update_expired_key->setupEditAttributes();
        $this->update_expired_key->EditCustomAttributes = "";
        if (!$this->update_expired_key->Raw) {
            $this->update_expired_key->CurrentValue = HtmlDecode($this->update_expired_key->CurrentValue);
        }
        $this->update_expired_key->EditValue = $this->update_expired_key->CurrentValue;
        $this->update_expired_key->PlaceHolder = RemoveHtml($this->update_expired_key->caption());

        // update_expired_status
        $this->update_expired_status->setupEditAttributes();
        $this->update_expired_status->EditCustomAttributes = "";
        $this->update_expired_status->EditValue = $this->update_expired_status->CurrentValue;
        $this->update_expired_status->PlaceHolder = RemoveHtml($this->update_expired_status->caption());
        if (strval($this->update_expired_status->EditValue) != "" && is_numeric($this->update_expired_status->EditValue)) {
            $this->update_expired_status->EditValue = FormatNumber($this->update_expired_status->EditValue, null);
        }

        // update_expired_date
        $this->update_expired_date->setupEditAttributes();
        $this->update_expired_date->EditCustomAttributes = "";
        $this->update_expired_date->EditValue = FormatDateTime($this->update_expired_date->CurrentValue, $this->update_expired_date->formatPattern());
        $this->update_expired_date->PlaceHolder = RemoveHtml($this->update_expired_date->caption());

        // update_expired_ip
        $this->update_expired_ip->setupEditAttributes();
        $this->update_expired_ip->EditCustomAttributes = "";
        if (!$this->update_expired_ip->Raw) {
            $this->update_expired_ip->CurrentValue = HtmlDecode($this->update_expired_ip->CurrentValue);
        }
        $this->update_expired_ip->EditValue = $this->update_expired_ip->CurrentValue;
        $this->update_expired_ip->PlaceHolder = RemoveHtml($this->update_expired_ip->caption());

        // is_cancel_contract
        $this->is_cancel_contract->EditCustomAttributes = "";
        $this->is_cancel_contract->EditValue = $this->is_cancel_contract->options(false);
        $this->is_cancel_contract->PlaceHolder = RemoveHtml($this->is_cancel_contract->caption());

        // cancel_contract_reason
        $this->cancel_contract_reason->setupEditAttributes();
        $this->cancel_contract_reason->EditCustomAttributes = "";
        if (!$this->cancel_contract_reason->Raw) {
            $this->cancel_contract_reason->CurrentValue = HtmlDecode($this->cancel_contract_reason->CurrentValue);
        }
        $this->cancel_contract_reason->EditValue = $this->cancel_contract_reason->CurrentValue;
        $this->cancel_contract_reason->PlaceHolder = RemoveHtml($this->cancel_contract_reason->caption());

        // cancel_contract_reason_detail
        $this->cancel_contract_reason_detail->setupEditAttributes();
        $this->cancel_contract_reason_detail->EditCustomAttributes = "";
        $this->cancel_contract_reason_detail->EditValue = $this->cancel_contract_reason_detail->CurrentValue;
        $this->cancel_contract_reason_detail->PlaceHolder = RemoveHtml($this->cancel_contract_reason_detail->caption());

        // cancel_contract_date
        $this->cancel_contract_date->setupEditAttributes();
        $this->cancel_contract_date->EditCustomAttributes = "";
        $this->cancel_contract_date->EditValue = FormatDateTime($this->cancel_contract_date->CurrentValue, $this->cancel_contract_date->formatPattern());
        $this->cancel_contract_date->PlaceHolder = RemoveHtml($this->cancel_contract_date->caption());

        // cancel_contract_user
        $this->cancel_contract_user->setupEditAttributes();
        $this->cancel_contract_user->EditCustomAttributes = "";
        $this->cancel_contract_user->EditValue = $this->cancel_contract_user->CurrentValue;
        $this->cancel_contract_user->PlaceHolder = RemoveHtml($this->cancel_contract_user->caption());
        if (strval($this->cancel_contract_user->EditValue) != "" && is_numeric($this->cancel_contract_user->EditValue)) {
            $this->cancel_contract_user->EditValue = FormatNumber($this->cancel_contract_user->EditValue, null);
        }

        // cancel_contract_ip
        $this->cancel_contract_ip->setupEditAttributes();
        $this->cancel_contract_ip->EditCustomAttributes = "";
        if (!$this->cancel_contract_ip->Raw) {
            $this->cancel_contract_ip->CurrentValue = HtmlDecode($this->cancel_contract_ip->CurrentValue);
        }
        $this->cancel_contract_ip->EditValue = $this->cancel_contract_ip->CurrentValue;
        $this->cancel_contract_ip->PlaceHolder = RemoveHtml($this->cancel_contract_ip->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->title_en);
                    $doc->exportCaption($this->brand_id);
                    $doc->exportCaption($this->detail);
                    $doc->exportCaption($this->detail_en);
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->asset_status);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->num_buildings);
                    $doc->exportCaption($this->num_unit);
                    $doc->exportCaption($this->num_floors);
                    $doc->exportCaption($this->floors);
                    $doc->exportCaption($this->asset_year_developer);
                    $doc->exportCaption($this->num_parking_spaces);
                    $doc->exportCaption($this->num_bathrooms);
                    $doc->exportCaption($this->num_bedrooms);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->address_en);
                    $doc->exportCaption($this->province_id);
                    $doc->exportCaption($this->amphur_id);
                    $doc->exportCaption($this->district_id);
                    $doc->exportCaption($this->postcode);
                    $doc->exportCaption($this->floor_plan);
                    $doc->exportCaption($this->layout_unit);
                    $doc->exportCaption($this->asset_website);
                    $doc->exportCaption($this->asset_review);
                    $doc->exportCaption($this->isactive);
                    $doc->exportCaption($this->is_recommend);
                    $doc->exportCaption($this->order_by);
                    $doc->exportCaption($this->type_pay);
                    $doc->exportCaption($this->type_pay_2);
                    $doc->exportCaption($this->price_mark);
                    $doc->exportCaption($this->holding_property);
                    $doc->exportCaption($this->common_fee);
                    $doc->exportCaption($this->usable_area);
                    $doc->exportCaption($this->usable_area_price);
                    $doc->exportCaption($this->land_size);
                    $doc->exportCaption($this->land_size_price);
                    $doc->exportCaption($this->commission);
                    $doc->exportCaption($this->transfer_day_expenses_with_business_tax);
                    $doc->exportCaption($this->transfer_day_expenses_without_business_tax);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->discount);
                    $doc->exportCaption($this->price_special);
                    $doc->exportCaption($this->reservation_price_model_a);
                    $doc->exportCaption($this->minimum_down_payment_model_a);
                    $doc->exportCaption($this->down_price_min_a);
                    $doc->exportCaption($this->down_price_model_a);
                    $doc->exportCaption($this->factor_monthly_installment_over_down);
                    $doc->exportCaption($this->fee_a);
                    $doc->exportCaption($this->monthly_payment_buyer);
                    $doc->exportCaption($this->annual_interest_buyer_model_a);
                    $doc->exportCaption($this->monthly_expenses_a);
                    $doc->exportCaption($this->average_rent_a);
                    $doc->exportCaption($this->average_down_payment_a);
                    $doc->exportCaption($this->transfer_day_expenses_without_business_tax_max_min);
                    $doc->exportCaption($this->transfer_day_expenses_with_business_tax_max_min);
                    $doc->exportCaption($this->bank_appraisal_price);
                    $doc->exportCaption($this->mark_up_price);
                    $doc->exportCaption($this->required_gap);
                    $doc->exportCaption($this->minimum_down_payment);
                    $doc->exportCaption($this->price_down_max);
                    $doc->exportCaption($this->discount_max);
                    $doc->exportCaption($this->price_down_special_max);
                    $doc->exportCaption($this->usable_area_price_max);
                    $doc->exportCaption($this->land_size_price_max);
                    $doc->exportCaption($this->reservation_price_max);
                    $doc->exportCaption($this->minimum_down_payment_max);
                    $doc->exportCaption($this->down_price_max);
                    $doc->exportCaption($this->down_price);
                    $doc->exportCaption($this->factor_monthly_installment_over_down_max);
                    $doc->exportCaption($this->fee_max);
                    $doc->exportCaption($this->monthly_payment_max);
                    $doc->exportCaption($this->annual_interest_buyer);
                    $doc->exportCaption($this->monthly_expense_max);
                    $doc->exportCaption($this->average_rent_max);
                    $doc->exportCaption($this->average_down_payment_max);
                    $doc->exportCaption($this->min_down);
                    $doc->exportCaption($this->remaining_down);
                    $doc->exportCaption($this->factor_financing);
                    $doc->exportCaption($this->credit_limit_down);
                    $doc->exportCaption($this->price_down_min);
                    $doc->exportCaption($this->discount_min);
                    $doc->exportCaption($this->price_down_special_min);
                    $doc->exportCaption($this->usable_area_price_min);
                    $doc->exportCaption($this->land_size_price_min);
                    $doc->exportCaption($this->reservation_price_min);
                    $doc->exportCaption($this->minimum_down_payment_min);
                    $doc->exportCaption($this->down_price_min);
                    $doc->exportCaption($this->remaining_credit_limit_down);
                    $doc->exportCaption($this->fee_min);
                    $doc->exportCaption($this->monthly_payment_min);
                    $doc->exportCaption($this->annual_interest_buyer_model_min);
                    $doc->exportCaption($this->interest_downpayment_financing);
                    $doc->exportCaption($this->monthly_expenses_min);
                    $doc->exportCaption($this->average_rent_min);
                    $doc->exportCaption($this->average_down_payment_min);
                    $doc->exportCaption($this->installment_down_payment_loan);
                    $doc->exportCaption($this->count_view);
                    $doc->exportCaption($this->count_favorite);
                    $doc->exportCaption($this->price_invertor);
                    $doc->exportCaption($this->expired_date);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->title_en);
                    $doc->exportCaption($this->brand_id);
                    $doc->exportCaption($this->asset_short_detail);
                    $doc->exportCaption($this->asset_short_detail_en);
                    $doc->exportCaption($this->detail);
                    $doc->exportCaption($this->detail_en);
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->asset_status);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->num_buildings);
                    $doc->exportCaption($this->num_unit);
                    $doc->exportCaption($this->num_floors);
                    $doc->exportCaption($this->floors);
                    $doc->exportCaption($this->asset_year_developer);
                    $doc->exportCaption($this->num_parking_spaces);
                    $doc->exportCaption($this->num_bathrooms);
                    $doc->exportCaption($this->num_bedrooms);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->address_en);
                    $doc->exportCaption($this->province_id);
                    $doc->exportCaption($this->amphur_id);
                    $doc->exportCaption($this->district_id);
                    $doc->exportCaption($this->postcode);
                    $doc->exportCaption($this->floor_plan);
                    $doc->exportCaption($this->layout_unit);
                    $doc->exportCaption($this->asset_website);
                    $doc->exportCaption($this->asset_review);
                    $doc->exportCaption($this->isactive);
                    $doc->exportCaption($this->is_recommend);
                    $doc->exportCaption($this->order_by);
                    $doc->exportCaption($this->type_pay);
                    $doc->exportCaption($this->type_pay_2);
                    $doc->exportCaption($this->price_mark);
                    $doc->exportCaption($this->holding_property);
                    $doc->exportCaption($this->common_fee);
                    $doc->exportCaption($this->usable_area);
                    $doc->exportCaption($this->usable_area_price);
                    $doc->exportCaption($this->land_size);
                    $doc->exportCaption($this->land_size_price);
                    $doc->exportCaption($this->commission);
                    $doc->exportCaption($this->transfer_day_expenses_with_business_tax);
                    $doc->exportCaption($this->transfer_day_expenses_without_business_tax);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->discount);
                    $doc->exportCaption($this->price_special);
                    $doc->exportCaption($this->reservation_price_model_a);
                    $doc->exportCaption($this->minimum_down_payment_model_a);
                    $doc->exportCaption($this->down_price_min_a);
                    $doc->exportCaption($this->down_price_model_a);
                    $doc->exportCaption($this->factor_monthly_installment_over_down);
                    $doc->exportCaption($this->fee_a);
                    $doc->exportCaption($this->monthly_payment_buyer);
                    $doc->exportCaption($this->annual_interest_buyer_model_a);
                    $doc->exportCaption($this->monthly_expenses_a);
                    $doc->exportCaption($this->average_rent_a);
                    $doc->exportCaption($this->average_down_payment_a);
                    $doc->exportCaption($this->transfer_day_expenses_without_business_tax_max_min);
                    $doc->exportCaption($this->transfer_day_expenses_with_business_tax_max_min);
                    $doc->exportCaption($this->bank_appraisal_price);
                    $doc->exportCaption($this->mark_up_price);
                    $doc->exportCaption($this->required_gap);
                    $doc->exportCaption($this->minimum_down_payment);
                    $doc->exportCaption($this->price_down_max);
                    $doc->exportCaption($this->discount_max);
                    $doc->exportCaption($this->price_down_special_max);
                    $doc->exportCaption($this->usable_area_price_max);
                    $doc->exportCaption($this->land_size_price_max);
                    $doc->exportCaption($this->reservation_price_max);
                    $doc->exportCaption($this->minimum_down_payment_max);
                    $doc->exportCaption($this->down_price_max);
                    $doc->exportCaption($this->down_price);
                    $doc->exportCaption($this->factor_monthly_installment_over_down_max);
                    $doc->exportCaption($this->fee_max);
                    $doc->exportCaption($this->monthly_payment_max);
                    $doc->exportCaption($this->annual_interest_buyer);
                    $doc->exportCaption($this->monthly_expense_max);
                    $doc->exportCaption($this->average_rent_max);
                    $doc->exportCaption($this->average_down_payment_max);
                    $doc->exportCaption($this->min_down);
                    $doc->exportCaption($this->remaining_down);
                    $doc->exportCaption($this->factor_financing);
                    $doc->exportCaption($this->credit_limit_down);
                    $doc->exportCaption($this->price_down_min);
                    $doc->exportCaption($this->discount_min);
                    $doc->exportCaption($this->price_down_special_min);
                    $doc->exportCaption($this->usable_area_price_min);
                    $doc->exportCaption($this->land_size_price_min);
                    $doc->exportCaption($this->reservation_price_min);
                    $doc->exportCaption($this->minimum_down_payment_min);
                    $doc->exportCaption($this->down_price_min);
                    $doc->exportCaption($this->remaining_credit_limit_down);
                    $doc->exportCaption($this->fee_min);
                    $doc->exportCaption($this->monthly_payment_min);
                    $doc->exportCaption($this->annual_interest_buyer_model_min);
                    $doc->exportCaption($this->interest_downpayment_financing);
                    $doc->exportCaption($this->monthly_expenses_min);
                    $doc->exportCaption($this->average_rent_min);
                    $doc->exportCaption($this->average_down_payment_min);
                    $doc->exportCaption($this->installment_down_payment_loan);
                    $doc->exportCaption($this->count_view);
                    $doc->exportCaption($this->count_favorite);
                    $doc->exportCaption($this->price_invertor);
                    $doc->exportCaption($this->expired_date);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->_title);
                        $doc->exportField($this->title_en);
                        $doc->exportField($this->brand_id);
                        $doc->exportField($this->detail);
                        $doc->exportField($this->detail_en);
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->asset_status);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->num_buildings);
                        $doc->exportField($this->num_unit);
                        $doc->exportField($this->num_floors);
                        $doc->exportField($this->floors);
                        $doc->exportField($this->asset_year_developer);
                        $doc->exportField($this->num_parking_spaces);
                        $doc->exportField($this->num_bathrooms);
                        $doc->exportField($this->num_bedrooms);
                        $doc->exportField($this->address);
                        $doc->exportField($this->address_en);
                        $doc->exportField($this->province_id);
                        $doc->exportField($this->amphur_id);
                        $doc->exportField($this->district_id);
                        $doc->exportField($this->postcode);
                        $doc->exportField($this->floor_plan);
                        $doc->exportField($this->layout_unit);
                        $doc->exportField($this->asset_website);
                        $doc->exportField($this->asset_review);
                        $doc->exportField($this->isactive);
                        $doc->exportField($this->is_recommend);
                        $doc->exportField($this->order_by);
                        $doc->exportField($this->type_pay);
                        $doc->exportField($this->type_pay_2);
                        $doc->exportField($this->price_mark);
                        $doc->exportField($this->holding_property);
                        $doc->exportField($this->common_fee);
                        $doc->exportField($this->usable_area);
                        $doc->exportField($this->usable_area_price);
                        $doc->exportField($this->land_size);
                        $doc->exportField($this->land_size_price);
                        $doc->exportField($this->commission);
                        $doc->exportField($this->transfer_day_expenses_with_business_tax);
                        $doc->exportField($this->transfer_day_expenses_without_business_tax);
                        $doc->exportField($this->price);
                        $doc->exportField($this->discount);
                        $doc->exportField($this->price_special);
                        $doc->exportField($this->reservation_price_model_a);
                        $doc->exportField($this->minimum_down_payment_model_a);
                        $doc->exportField($this->down_price_min_a);
                        $doc->exportField($this->down_price_model_a);
                        $doc->exportField($this->factor_monthly_installment_over_down);
                        $doc->exportField($this->fee_a);
                        $doc->exportField($this->monthly_payment_buyer);
                        $doc->exportField($this->annual_interest_buyer_model_a);
                        $doc->exportField($this->monthly_expenses_a);
                        $doc->exportField($this->average_rent_a);
                        $doc->exportField($this->average_down_payment_a);
                        $doc->exportField($this->transfer_day_expenses_without_business_tax_max_min);
                        $doc->exportField($this->transfer_day_expenses_with_business_tax_max_min);
                        $doc->exportField($this->bank_appraisal_price);
                        $doc->exportField($this->mark_up_price);
                        $doc->exportField($this->required_gap);
                        $doc->exportField($this->minimum_down_payment);
                        $doc->exportField($this->price_down_max);
                        $doc->exportField($this->discount_max);
                        $doc->exportField($this->price_down_special_max);
                        $doc->exportField($this->usable_area_price_max);
                        $doc->exportField($this->land_size_price_max);
                        $doc->exportField($this->reservation_price_max);
                        $doc->exportField($this->minimum_down_payment_max);
                        $doc->exportField($this->down_price_max);
                        $doc->exportField($this->down_price);
                        $doc->exportField($this->factor_monthly_installment_over_down_max);
                        $doc->exportField($this->fee_max);
                        $doc->exportField($this->monthly_payment_max);
                        $doc->exportField($this->annual_interest_buyer);
                        $doc->exportField($this->monthly_expense_max);
                        $doc->exportField($this->average_rent_max);
                        $doc->exportField($this->average_down_payment_max);
                        $doc->exportField($this->min_down);
                        $doc->exportField($this->remaining_down);
                        $doc->exportField($this->factor_financing);
                        $doc->exportField($this->credit_limit_down);
                        $doc->exportField($this->price_down_min);
                        $doc->exportField($this->discount_min);
                        $doc->exportField($this->price_down_special_min);
                        $doc->exportField($this->usable_area_price_min);
                        $doc->exportField($this->land_size_price_min);
                        $doc->exportField($this->reservation_price_min);
                        $doc->exportField($this->minimum_down_payment_min);
                        $doc->exportField($this->down_price_min);
                        $doc->exportField($this->remaining_credit_limit_down);
                        $doc->exportField($this->fee_min);
                        $doc->exportField($this->monthly_payment_min);
                        $doc->exportField($this->annual_interest_buyer_model_min);
                        $doc->exportField($this->interest_downpayment_financing);
                        $doc->exportField($this->monthly_expenses_min);
                        $doc->exportField($this->average_rent_min);
                        $doc->exportField($this->average_down_payment_min);
                        $doc->exportField($this->installment_down_payment_loan);
                        $doc->exportField($this->count_view);
                        $doc->exportField($this->count_favorite);
                        $doc->exportField($this->price_invertor);
                        $doc->exportField($this->expired_date);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->_title);
                        $doc->exportField($this->title_en);
                        $doc->exportField($this->brand_id);
                        $doc->exportField($this->asset_short_detail);
                        $doc->exportField($this->asset_short_detail_en);
                        $doc->exportField($this->detail);
                        $doc->exportField($this->detail_en);
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->asset_status);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->num_buildings);
                        $doc->exportField($this->num_unit);
                        $doc->exportField($this->num_floors);
                        $doc->exportField($this->floors);
                        $doc->exportField($this->asset_year_developer);
                        $doc->exportField($this->num_parking_spaces);
                        $doc->exportField($this->num_bathrooms);
                        $doc->exportField($this->num_bedrooms);
                        $doc->exportField($this->address);
                        $doc->exportField($this->address_en);
                        $doc->exportField($this->province_id);
                        $doc->exportField($this->amphur_id);
                        $doc->exportField($this->district_id);
                        $doc->exportField($this->postcode);
                        $doc->exportField($this->floor_plan);
                        $doc->exportField($this->layout_unit);
                        $doc->exportField($this->asset_website);
                        $doc->exportField($this->asset_review);
                        $doc->exportField($this->isactive);
                        $doc->exportField($this->is_recommend);
                        $doc->exportField($this->order_by);
                        $doc->exportField($this->type_pay);
                        $doc->exportField($this->type_pay_2);
                        $doc->exportField($this->price_mark);
                        $doc->exportField($this->holding_property);
                        $doc->exportField($this->common_fee);
                        $doc->exportField($this->usable_area);
                        $doc->exportField($this->usable_area_price);
                        $doc->exportField($this->land_size);
                        $doc->exportField($this->land_size_price);
                        $doc->exportField($this->commission);
                        $doc->exportField($this->transfer_day_expenses_with_business_tax);
                        $doc->exportField($this->transfer_day_expenses_without_business_tax);
                        $doc->exportField($this->price);
                        $doc->exportField($this->discount);
                        $doc->exportField($this->price_special);
                        $doc->exportField($this->reservation_price_model_a);
                        $doc->exportField($this->minimum_down_payment_model_a);
                        $doc->exportField($this->down_price_min_a);
                        $doc->exportField($this->down_price_model_a);
                        $doc->exportField($this->factor_monthly_installment_over_down);
                        $doc->exportField($this->fee_a);
                        $doc->exportField($this->monthly_payment_buyer);
                        $doc->exportField($this->annual_interest_buyer_model_a);
                        $doc->exportField($this->monthly_expenses_a);
                        $doc->exportField($this->average_rent_a);
                        $doc->exportField($this->average_down_payment_a);
                        $doc->exportField($this->transfer_day_expenses_without_business_tax_max_min);
                        $doc->exportField($this->transfer_day_expenses_with_business_tax_max_min);
                        $doc->exportField($this->bank_appraisal_price);
                        $doc->exportField($this->mark_up_price);
                        $doc->exportField($this->required_gap);
                        $doc->exportField($this->minimum_down_payment);
                        $doc->exportField($this->price_down_max);
                        $doc->exportField($this->discount_max);
                        $doc->exportField($this->price_down_special_max);
                        $doc->exportField($this->usable_area_price_max);
                        $doc->exportField($this->land_size_price_max);
                        $doc->exportField($this->reservation_price_max);
                        $doc->exportField($this->minimum_down_payment_max);
                        $doc->exportField($this->down_price_max);
                        $doc->exportField($this->down_price);
                        $doc->exportField($this->factor_monthly_installment_over_down_max);
                        $doc->exportField($this->fee_max);
                        $doc->exportField($this->monthly_payment_max);
                        $doc->exportField($this->annual_interest_buyer);
                        $doc->exportField($this->monthly_expense_max);
                        $doc->exportField($this->average_rent_max);
                        $doc->exportField($this->average_down_payment_max);
                        $doc->exportField($this->min_down);
                        $doc->exportField($this->remaining_down);
                        $doc->exportField($this->factor_financing);
                        $doc->exportField($this->credit_limit_down);
                        $doc->exportField($this->price_down_min);
                        $doc->exportField($this->discount_min);
                        $doc->exportField($this->price_down_special_min);
                        $doc->exportField($this->usable_area_price_min);
                        $doc->exportField($this->land_size_price_min);
                        $doc->exportField($this->reservation_price_min);
                        $doc->exportField($this->minimum_down_payment_min);
                        $doc->exportField($this->down_price_min);
                        $doc->exportField($this->remaining_credit_limit_down);
                        $doc->exportField($this->fee_min);
                        $doc->exportField($this->monthly_payment_min);
                        $doc->exportField($this->annual_interest_buyer_model_min);
                        $doc->exportField($this->interest_downpayment_financing);
                        $doc->exportField($this->monthly_expenses_min);
                        $doc->exportField($this->average_rent_min);
                        $doc->exportField($this->average_down_payment_min);
                        $doc->exportField($this->installment_down_payment_loan);
                        $doc->exportField($this->count_view);
                        $doc->exportField($this->count_favorite);
                        $doc->exportField($this->price_invertor);
                        $doc->exportField($this->expired_date);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'floor_plan') {
            $fldName = "floor_plan";
            $fileNameFld = "floor_plan";
        } elseif ($fldparm == 'layout_unit') {
            $fldName = "layout_unit";
            $fileNameFld = "layout_unit";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->asset_id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Write Audit Trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        $table = 'asset';
        $usr = CurrentUserID();
        WriteAuditLog($usr, $typ, $table, "", "", "", "");
    }

    // Write Audit Trail (add page)
    public function writeAuditTrailOnAdd(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnAdd) {
            return;
        }
        $table = 'asset';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['asset_id'];

        // Write Audit Trail
        $usr = CurrentUserID();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") {
                    $newvalue = $Language->phrase("PasswordMask"); // Password Field
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) {
                    if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                        $newvalue = $rs[$fldname];
                    } else {
                        $newvalue = "[MEMO]"; // Memo Field
                    }
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) {
                    $newvalue = "[XML]"; // XML Field
                } else {
                    $newvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "A", $table, $fldname, $key, "", $newvalue);
            }
        }
    }

    // Write Audit Trail (edit page)
    public function writeAuditTrailOnEdit(&$rsold, &$rsnew)
    {
        global $Language;
        if (!$this->AuditTrailOnEdit) {
            return;
        }
        $table = 'asset';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['asset_id'];

        // Write Audit Trail
        $usr = CurrentUserID();
        foreach (array_keys($rsnew) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && array_key_exists($fldname, $rsold) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->DataType == DATATYPE_DATE) { // DateTime field
                    $modified = (FormatDateTime($rsold[$fldname], 0) != FormatDateTime($rsnew[$fldname], 0));
                } else {
                    $modified = !CompareValue($rsold[$fldname], $rsnew[$fldname]);
                }
                if ($modified) {
                    if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                        $oldvalue = $Language->phrase("PasswordMask");
                        $newvalue = $Language->phrase("PasswordMask");
                    } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) { // Memo field
                        if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                            $oldvalue = $rsold[$fldname];
                            $newvalue = $rsnew[$fldname];
                        } else {
                            $oldvalue = "[MEMO]";
                            $newvalue = "[MEMO]";
                        }
                    } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) { // XML field
                        $oldvalue = "[XML]";
                        $newvalue = "[XML]";
                    } else {
                        $oldvalue = $rsold[$fldname];
                        $newvalue = $rsnew[$fldname];
                    }
                    WriteAuditLog($usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
                }
            }
        }
    }

    // Write Audit Trail (delete page)
    public function writeAuditTrailOnDelete(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnDelete) {
            return;
        }
        $table = 'asset';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['asset_id'];

        // Write Audit Trail
        $curUser = CurrentUserID();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") {
                    $oldvalue = $Language->phrase("PasswordMask"); // Password Field
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) {
                    if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                        $oldvalue = $rs[$fldname];
                    } else {
                        $oldvalue = "[MEMO]"; // Memo field
                    }
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) {
                    $oldvalue = "[XML]"; // XML field
                } else {
                    $oldvalue = $rs[$fldname];
                }
                WriteAuditLog($curUser, "D", $table, $fldname, $key, $oldvalue, "");
            }
        }
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {

            // print_r($rsnew);
            // isset($rsnew);

            if (!isset($rsnew['type_pay'])) {
                $rsnew['type_pay'] = 0;
            }

            // echo $rsnew['type_pay'];
            
            if (!isset($rsnew['type_pay_2'])) {
                $rsnew['type_pay_2'] = 0;
            }

            // echo $rsnew['type_pay_2'];

            // Enter your code here
            // To cancel, set return value to false

            // Juzmath

            // asset code

            // ��ѡ��� 1 �繻�����������Ѿ��Ŵ asset
            // - J = Juzmatch
            // - S = Seller
            // - B = Buyer

            // ��ѡ��� 2-7 ���ѹ����Ѿ��Ŵ asset
            // Format �� YYMMDD

            // ��ѡ��� 8-10 �ѹ�Ţ 001-999

            // ������ҧ
            // J210901001
            $sql_code_asset = "SELECT * FROM `web_config` WHERE param = 'CODE_ASSET_PREFIX_JUZMATCH' LIMIT 0,1";
            $rs_code_asset = ExecuteRow($sql_code_asset);
            $sql_num_code = "SELECT * FROM `run_number_asset_juzmatch` WHERE 1";
            $rs_num_code = ExecuteRow($sql_num_code);

            $format = '000';
            $count_juzmatch_code = $rs_num_code['num'];
            $code_prefix = $rs_code_asset['value'];
            $ans = substr($format,strlen($count_juzmatch_code)).$count_juzmatch_code;
            $code_all = $code_prefix.date('ymd').$ans;
            $sql_set_count_code = "UPDATE `run_number_asset_juzmatch` SET `num`= num+1 WHERE 1";
            $rs_set_count_code = ExecuteStatement($sql_set_count_code);
            $rsnew['asset_code'] = $code_all;
            
            return false;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
        //! เน€เธฃเธตเธขเธ API เธชเนเธ E-Mail เนเธเนเธเน€เธ•เธทเธญเธ seller เธ—เธฃเธฑเธเธขเนเธ—เธตเนเธเธฃเธฐเธเธฒเธจเธฅเธเธเธฒเธขเนเธฅเนเธง 
        //? 1 check status_live
        //? 2 call api :/seller/asset_comfirmed เน€เธเธทเนเธญ Send E-Mail And Push Noti

        if (!isset($rsnew['type_pay'])) {
            $rsnew['type_pay'] = 0;
        }

        // echo $rsnew['type_pay'];
        
        if (!isset($rsnew['type_pay_2'])) {
            $rsnew['type_pay_2'] = 0;
        }

        if (!isset($rsold['type_pay'])) {
            $rsold['type_pay'] = 0;
        }

        // echo $rsnew['type_pay'];
        
        if (!isset($rsold['type_pay_2'])) {
            $rsold['type_pay_2'] = 0;
        }

        // print_r($rsold);
        // echo "<hr>";
        // print_r($rsnew);

        if ($rsnew['asset_status'] == 2) { // live
            $sql_check = "SELECT * FROM `sale_asset` WHERE asset_id = ".$rsold['asset_id']." AND status_live = 0";
            $rs_check = ExecuteRow($sql_check);

            // print_r($rs_check);
            if (count($rs_check) <= 0) {
                return false;
            } else {
                // print_r($rs_check);
                // print_r($rsold);
                $member_id = $rs_check['member_id'];
                $asset_id = $rs_check['asset_id'];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://uatapi.juzmatch.com/seller/asset_comfirmed',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "member_id": '.$member_id.',
                    "asset_id": '.$asset_id.'
                }',
                    CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $sql_set_status_live = "UPDATE `sale_asset` SET `status_live` = 1 WHERE `asset_id` =".$rsold['asset_id'];
                ExecuteStatement($sql_set_status_live);
                // print_r($sql_set_status_live);
                // print_r($rs_set_status_live);
                return true;
            }
        }else if ($rsnew['asset_status'] == 3) { // match
            $sql_check = "SELECT * FROM `buyer_booking_asset` WHERE asset_id = ".$rsold['asset_id']." AND status_expire = 0 ORDER BY buyer_booking_asset_id DESC LIMIT 0,1";
            $rs_check = ExecuteRow($sql_check);

            // check prefix_asset_code
            $asset_id = $rsold['asset_id'];
            $member_id = $rs_check['member_id'];
            $sql_prefix_asset_code = "SELECT LEFT(asset_code, 1) AS asset_code_first,asset_code FROM asset WHERE asset_id = $asset_id";
            $res_prefix_asset_code = ExecuteRow($sql_prefix_asset_code);
            $new_prefix_asset_code = $res_prefix_asset_code['asset_code_first']; // J,B,S

            if ($new_prefix_asset_code == "B") {
                // update buyer booking

                $sql_update_booking_asset = "UPDATE `buyer_booking_asset` SET `date_booking` = NOW(),`due_date` = NOW() + INTERVAL 6 HOUR WHERE `asset_id` =".$rsold['asset_id']." AND `member_id` = ".$member_id." AND	status_expire = 0";
                // echo $sql_update_booking_asset;
                ExecuteStatement($sql_update_booking_asset);

                // push notification to buyer
                // send email to buyer
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://uatapi.juzmatch.com/buyer/asset_comfirmed',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "member_id": '.$member_id.',
                    "asset_id": '.$asset_id.'
                }',
                    CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                return true;
            }else{
                return true;
            }
        } else {
            return true;
        }
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
