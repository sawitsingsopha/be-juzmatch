<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for member_scb
 */
class MemberScb extends DbTable
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

    // Export
    public $ExportDoc;

    // Fields
    public $member_scb_id;
    public $member_id;
    public $asset_id;
    public $reference_id;
    public $reference_url;
    public $refreshtoken;
    public $auth_code;
    public $_token;
    public $state;
    public $status;
    public $at_expire_in;
    public $rt_expire_in;
    public $decision_status;
    public $decision_timestamp;
    public $deposit_amount;
    public $due_date;
    public $rental_fee;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;
    public $fullName;
    public $age;
    public $maritalStatus;
    public $noOfChildren;
    public $educationLevel;
    public $workplace;
    public $occupation;
    public $jobPosition;
    public $submissionDate;
    public $bankruptcy_tendency;
    public $blacklist_tendency;
    public $money_laundering_tendency;
    public $mobile_fraud_behavior;
    public $face_similarity_score;
    public $identification_verification_matched_flag;
    public $bankstatement_confident_score;
    public $estimated_monthly_income;
    public $estimated_monthly_debt;
    public $income_stability;
    public $customer_grade;
    public $color_sign;
    public $rental_period;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'member_scb';
        $this->TableName = 'member_scb';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`member_scb`";
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
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // member_scb_id
        $this->member_scb_id = new DbField(
            'member_scb',
            'member_scb',
            'x_member_scb_id',
            'member_scb_id',
            '`member_scb_id`',
            '`member_scb_id`',
            3,
            11,
            -1,
            false,
            '`member_scb_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->member_scb_id->InputTextType = "text";
        $this->member_scb_id->IsAutoIncrement = true; // Autoincrement field
        $this->member_scb_id->IsPrimaryKey = true; // Primary key field
        $this->member_scb_id->Sortable = false; // Allow sort
        $this->member_scb_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_scb_id'] = &$this->member_scb_id;

        // member_id
        $this->member_id = new DbField(
            'member_scb',
            'member_scb',
            'x_member_id',
            'member_id',
            '`member_id`',
            '`member_id`',
            3,
            11,
            -1,
            false,
            '`member_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->member_id->InputTextType = "text";
        $this->member_id->Required = true; // Required field
        $this->member_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->member_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '`first_name` ASC', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // asset_id
        $this->asset_id = new DbField(
            'member_scb',
            'member_scb',
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
            'SELECT'
        );
        $this->asset_id->InputTextType = "text";
        $this->asset_id->Required = true; // Required field
        $this->asset_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->asset_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->asset_id->Lookup = new Lookup('asset_id', 'asset', false, 'asset_id', ["title","asset_code","",""], [], [], [], [], [], [], '`title` ASC', '', "CONCAT(COALESCE(`title`, ''),'" . ValueSeparator(1, $this->asset_id) . "',COALESCE(`asset_code`,''))");
        $this->asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_id'] = &$this->asset_id;

        // reference_id
        $this->reference_id = new DbField(
            'member_scb',
            'member_scb',
            'x_reference_id',
            'reference_id',
            '`reference_id`',
            '`reference_id`',
            200,
            255,
            -1,
            false,
            '`reference_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reference_id->InputTextType = "text";
        $this->Fields['reference_id'] = &$this->reference_id;

        // reference_url
        $this->reference_url = new DbField(
            'member_scb',
            'member_scb',
            'x_reference_url',
            'reference_url',
            '`reference_url`',
            '`reference_url`',
            201,
            65535,
            -1,
            false,
            '`reference_url`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->reference_url->InputTextType = "text";
        $this->Fields['reference_url'] = &$this->reference_url;

        // refreshtoken
        $this->refreshtoken = new DbField(
            'member_scb',
            'member_scb',
            'x_refreshtoken',
            'refreshtoken',
            '`refreshtoken`',
            '`refreshtoken`',
            201,
            65535,
            -1,
            false,
            '`refreshtoken`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->refreshtoken->InputTextType = "text";
        $this->refreshtoken->Nullable = false; // NOT NULL field
        $this->refreshtoken->Required = true; // Required field
        $this->Fields['refreshtoken'] = &$this->refreshtoken;

        // auth_code
        $this->auth_code = new DbField(
            'member_scb',
            'member_scb',
            'x_auth_code',
            'auth_code',
            '`auth_code`',
            '`auth_code`',
            201,
            65535,
            -1,
            false,
            '`auth_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->auth_code->InputTextType = "text";
        $this->auth_code->Nullable = false; // NOT NULL field
        $this->auth_code->Required = true; // Required field
        $this->Fields['auth_code'] = &$this->auth_code;

        // token
        $this->_token = new DbField(
            'member_scb',
            'member_scb',
            'x__token',
            'token',
            '`token`',
            '`token`',
            201,
            65535,
            -1,
            false,
            '`token`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->_token->InputTextType = "text";
        $this->Fields['token'] = &$this->_token;

        // state
        $this->state = new DbField(
            'member_scb',
            'member_scb',
            'x_state',
            'state',
            '`state`',
            '`state`',
            201,
            65535,
            -1,
            false,
            '`state`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->state->InputTextType = "text";
        $this->Fields['state'] = &$this->state;

        // status
        $this->status = new DbField(
            'member_scb',
            'member_scb',
            'x_status',
            'status',
            '`status`',
            '`status`',
            200,
            255,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->status->InputTextType = "text";
        $this->Fields['status'] = &$this->status;

        // at_expire_in
        $this->at_expire_in = new DbField(
            'member_scb',
            'member_scb',
            'x_at_expire_in',
            'at_expire_in',
            '`at_expire_in`',
            '`at_expire_in`',
            201,
            65535,
            -1,
            false,
            '`at_expire_in`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->at_expire_in->InputTextType = "text";
        $this->at_expire_in->Nullable = false; // NOT NULL field
        $this->at_expire_in->Required = true; // Required field
        $this->Fields['at_expire_in'] = &$this->at_expire_in;

        // rt_expire_in
        $this->rt_expire_in = new DbField(
            'member_scb',
            'member_scb',
            'x_rt_expire_in',
            'rt_expire_in',
            '`rt_expire_in`',
            '`rt_expire_in`',
            201,
            65535,
            -1,
            false,
            '`rt_expire_in`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->rt_expire_in->InputTextType = "text";
        $this->rt_expire_in->Nullable = false; // NOT NULL field
        $this->rt_expire_in->Required = true; // Required field
        $this->Fields['rt_expire_in'] = &$this->rt_expire_in;

        // decision_status
        $this->decision_status = new DbField(
            'member_scb',
            'member_scb',
            'x_decision_status',
            'decision_status',
            '`decision_status`',
            '`decision_status`',
            200,
            50,
            -1,
            false,
            '`decision_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->decision_status->InputTextType = "text";
        $this->Fields['decision_status'] = &$this->decision_status;

        // decision_timestamp
        $this->decision_timestamp = new DbField(
            'member_scb',
            'member_scb',
            'x_decision_timestamp',
            'decision_timestamp',
            '`decision_timestamp`',
            CastDateFieldForLike("`decision_timestamp`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`decision_timestamp`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->decision_timestamp->InputTextType = "text";
        $this->decision_timestamp->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['decision_timestamp'] = &$this->decision_timestamp;

        // deposit_amount
        $this->deposit_amount = new DbField(
            'member_scb',
            'member_scb',
            'x_deposit_amount',
            'deposit_amount',
            '`deposit_amount`',
            '`deposit_amount`',
            5,
            22,
            -1,
            false,
            '`deposit_amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->deposit_amount->InputTextType = "text";
        $this->deposit_amount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['deposit_amount'] = &$this->deposit_amount;

        // due_date
        $this->due_date = new DbField(
            'member_scb',
            'member_scb',
            'x_due_date',
            'due_date',
            '`due_date`',
            CastDateFieldForLike("`due_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`due_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->due_date->InputTextType = "text";
        $this->due_date->Required = true; // Required field
        $this->due_date->Sortable = false; // Allow sort
        $this->due_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['due_date'] = &$this->due_date;

        // rental_fee
        $this->rental_fee = new DbField(
            'member_scb',
            'member_scb',
            'x_rental_fee',
            'rental_fee',
            '`rental_fee`',
            '`rental_fee`',
            5,
            22,
            -1,
            false,
            '`rental_fee`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->rental_fee->InputTextType = "text";
        $this->rental_fee->Sortable = false; // Allow sort
        $this->rental_fee->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['rental_fee'] = &$this->rental_fee;

        // cdate
        $this->cdate = new DbField(
            'member_scb',
            'member_scb',
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
            'member_scb',
            'member_scb',
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
            'member_scb',
            'member_scb',
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

        // udate
        $this->udate = new DbField(
            'member_scb',
            'member_scb',
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
            'member_scb',
            'member_scb',
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

        // uip
        $this->uip = new DbField(
            'member_scb',
            'member_scb',
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

        // fullName
        $this->fullName = new DbField(
            'member_scb',
            'member_scb',
            'x_fullName',
            'fullName',
            '`fullName`',
            '`fullName`',
            200,
            255,
            -1,
            false,
            '`fullName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fullName->InputTextType = "text";
        $this->Fields['fullName'] = &$this->fullName;

        // age
        $this->age = new DbField(
            'member_scb',
            'member_scb',
            'x_age',
            'age',
            '`age`',
            '`age`',
            3,
            11,
            -1,
            false,
            '`age`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->age->InputTextType = "text";
        $this->age->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['age'] = &$this->age;

        // maritalStatus
        $this->maritalStatus = new DbField(
            'member_scb',
            'member_scb',
            'x_maritalStatus',
            'maritalStatus',
            '`maritalStatus`',
            '`maritalStatus`',
            200,
            255,
            -1,
            false,
            '`maritalStatus`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->maritalStatus->InputTextType = "text";
        $this->Fields['maritalStatus'] = &$this->maritalStatus;

        // noOfChildren
        $this->noOfChildren = new DbField(
            'member_scb',
            'member_scb',
            'x_noOfChildren',
            'noOfChildren',
            '`noOfChildren`',
            '`noOfChildren`',
            200,
            255,
            -1,
            false,
            '`noOfChildren`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->noOfChildren->InputTextType = "text";
        $this->Fields['noOfChildren'] = &$this->noOfChildren;

        // educationLevel
        $this->educationLevel = new DbField(
            'member_scb',
            'member_scb',
            'x_educationLevel',
            'educationLevel',
            '`educationLevel`',
            '`educationLevel`',
            200,
            255,
            -1,
            false,
            '`educationLevel`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->educationLevel->InputTextType = "text";
        $this->Fields['educationLevel'] = &$this->educationLevel;

        // workplace
        $this->workplace = new DbField(
            'member_scb',
            'member_scb',
            'x_workplace',
            'workplace',
            '`workplace`',
            '`workplace`',
            200,
            255,
            -1,
            false,
            '`workplace`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->workplace->InputTextType = "text";
        $this->Fields['workplace'] = &$this->workplace;

        // occupation
        $this->occupation = new DbField(
            'member_scb',
            'member_scb',
            'x_occupation',
            'occupation',
            '`occupation`',
            '`occupation`',
            200,
            255,
            -1,
            false,
            '`occupation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->occupation->InputTextType = "text";
        $this->Fields['occupation'] = &$this->occupation;

        // jobPosition
        $this->jobPosition = new DbField(
            'member_scb',
            'member_scb',
            'x_jobPosition',
            'jobPosition',
            '`jobPosition`',
            '`jobPosition`',
            200,
            255,
            -1,
            false,
            '`jobPosition`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->jobPosition->InputTextType = "text";
        $this->Fields['jobPosition'] = &$this->jobPosition;

        // submissionDate
        $this->submissionDate = new DbField(
            'member_scb',
            'member_scb',
            'x_submissionDate',
            'submissionDate',
            '`submissionDate`',
            CastDateFieldForLike("`submissionDate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`submissionDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->submissionDate->InputTextType = "text";
        $this->submissionDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['submissionDate'] = &$this->submissionDate;

        // bankruptcy_tendency
        $this->bankruptcy_tendency = new DbField(
            'member_scb',
            'member_scb',
            'x_bankruptcy_tendency',
            'bankruptcy_tendency',
            '`bankruptcy_tendency`',
            '`bankruptcy_tendency`',
            200,
            255,
            -1,
            false,
            '`bankruptcy_tendency`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->bankruptcy_tendency->InputTextType = "text";
        $this->Fields['bankruptcy_tendency'] = &$this->bankruptcy_tendency;

        // blacklist_tendency
        $this->blacklist_tendency = new DbField(
            'member_scb',
            'member_scb',
            'x_blacklist_tendency',
            'blacklist_tendency',
            '`blacklist_tendency`',
            '`blacklist_tendency`',
            200,
            255,
            -1,
            false,
            '`blacklist_tendency`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->blacklist_tendency->InputTextType = "text";
        $this->Fields['blacklist_tendency'] = &$this->blacklist_tendency;

        // money_laundering_tendency
        $this->money_laundering_tendency = new DbField(
            'member_scb',
            'member_scb',
            'x_money_laundering_tendency',
            'money_laundering_tendency',
            '`money_laundering_tendency`',
            '`money_laundering_tendency`',
            200,
            255,
            -1,
            false,
            '`money_laundering_tendency`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->money_laundering_tendency->InputTextType = "text";
        $this->Fields['money_laundering_tendency'] = &$this->money_laundering_tendency;

        // mobile_fraud_behavior
        $this->mobile_fraud_behavior = new DbField(
            'member_scb',
            'member_scb',
            'x_mobile_fraud_behavior',
            'mobile_fraud_behavior',
            '`mobile_fraud_behavior`',
            '`mobile_fraud_behavior`',
            200,
            255,
            -1,
            false,
            '`mobile_fraud_behavior`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->mobile_fraud_behavior->InputTextType = "text";
        $this->Fields['mobile_fraud_behavior'] = &$this->mobile_fraud_behavior;

        // face_similarity_score
        $this->face_similarity_score = new DbField(
            'member_scb',
            'member_scb',
            'x_face_similarity_score',
            'face_similarity_score',
            '`face_similarity_score`',
            '`face_similarity_score`',
            200,
            255,
            -1,
            false,
            '`face_similarity_score`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->face_similarity_score->InputTextType = "text";
        $this->Fields['face_similarity_score'] = &$this->face_similarity_score;

        // identification_verification_matched_flag
        $this->identification_verification_matched_flag = new DbField(
            'member_scb',
            'member_scb',
            'x_identification_verification_matched_flag',
            'identification_verification_matched_flag',
            '`identification_verification_matched_flag`',
            '`identification_verification_matched_flag`',
            200,
            255,
            -1,
            false,
            '`identification_verification_matched_flag`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->identification_verification_matched_flag->InputTextType = "text";
        $this->Fields['identification_verification_matched_flag'] = &$this->identification_verification_matched_flag;

        // bankstatement_confident_score
        $this->bankstatement_confident_score = new DbField(
            'member_scb',
            'member_scb',
            'x_bankstatement_confident_score',
            'bankstatement_confident_score',
            '`bankstatement_confident_score`',
            '`bankstatement_confident_score`',
            200,
            255,
            -1,
            false,
            '`bankstatement_confident_score`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->bankstatement_confident_score->InputTextType = "text";
        $this->Fields['bankstatement_confident_score'] = &$this->bankstatement_confident_score;

        // estimated_monthly_income
        $this->estimated_monthly_income = new DbField(
            'member_scb',
            'member_scb',
            'x_estimated_monthly_income',
            'estimated_monthly_income',
            '`estimated_monthly_income`',
            '`estimated_monthly_income`',
            200,
            255,
            -1,
            false,
            '`estimated_monthly_income`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->estimated_monthly_income->InputTextType = "text";
        $this->Fields['estimated_monthly_income'] = &$this->estimated_monthly_income;

        // estimated_monthly_debt
        $this->estimated_monthly_debt = new DbField(
            'member_scb',
            'member_scb',
            'x_estimated_monthly_debt',
            'estimated_monthly_debt',
            '`estimated_monthly_debt`',
            '`estimated_monthly_debt`',
            200,
            255,
            -1,
            false,
            '`estimated_monthly_debt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->estimated_monthly_debt->InputTextType = "text";
        $this->Fields['estimated_monthly_debt'] = &$this->estimated_monthly_debt;

        // income_stability
        $this->income_stability = new DbField(
            'member_scb',
            'member_scb',
            'x_income_stability',
            'income_stability',
            '`income_stability`',
            '`income_stability`',
            200,
            255,
            -1,
            false,
            '`income_stability`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->income_stability->InputTextType = "text";
        $this->Fields['income_stability'] = &$this->income_stability;

        // customer_grade
        $this->customer_grade = new DbField(
            'member_scb',
            'member_scb',
            'x_customer_grade',
            'customer_grade',
            '`customer_grade`',
            '`customer_grade`',
            200,
            255,
            -1,
            false,
            '`customer_grade`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->customer_grade->InputTextType = "text";
        $this->Fields['customer_grade'] = &$this->customer_grade;

        // color_sign
        $this->color_sign = new DbField(
            'member_scb',
            'member_scb',
            'x_color_sign',
            'color_sign',
            '`color_sign`',
            '`color_sign`',
            200,
            255,
            -1,
            false,
            '`color_sign`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->color_sign->InputTextType = "text";
        $this->Fields['color_sign'] = &$this->color_sign;

        // rental_period
        $this->rental_period = new DbField(
            'member_scb',
            'member_scb',
            'x_rental_period',
            'rental_period',
            '`rental_period`',
            '`rental_period`',
            3,
            11,
            -1,
            false,
            '`rental_period`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->rental_period->InputTextType = "text";
        $this->rental_period->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['rental_period'] = &$this->rental_period;

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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`member_scb`";
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
            $this->member_scb_id->setDbValue($conn->lastInsertId());
            $rs['member_scb_id'] = $this->member_scb_id->DbValue;
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
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
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
            if (array_key_exists('member_scb_id', $rs)) {
                AddFilter($where, QuotedName('member_scb_id', $this->Dbid) . '=' . QuotedValue($rs['member_scb_id'], $this->member_scb_id->DataType, $this->Dbid));
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
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->member_scb_id->DbValue = $row['member_scb_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->reference_id->DbValue = $row['reference_id'];
        $this->reference_url->DbValue = $row['reference_url'];
        $this->refreshtoken->DbValue = $row['refreshtoken'];
        $this->auth_code->DbValue = $row['auth_code'];
        $this->_token->DbValue = $row['token'];
        $this->state->DbValue = $row['state'];
        $this->status->DbValue = $row['status'];
        $this->at_expire_in->DbValue = $row['at_expire_in'];
        $this->rt_expire_in->DbValue = $row['rt_expire_in'];
        $this->decision_status->DbValue = $row['decision_status'];
        $this->decision_timestamp->DbValue = $row['decision_timestamp'];
        $this->deposit_amount->DbValue = $row['deposit_amount'];
        $this->due_date->DbValue = $row['due_date'];
        $this->rental_fee->DbValue = $row['rental_fee'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->fullName->DbValue = $row['fullName'];
        $this->age->DbValue = $row['age'];
        $this->maritalStatus->DbValue = $row['maritalStatus'];
        $this->noOfChildren->DbValue = $row['noOfChildren'];
        $this->educationLevel->DbValue = $row['educationLevel'];
        $this->workplace->DbValue = $row['workplace'];
        $this->occupation->DbValue = $row['occupation'];
        $this->jobPosition->DbValue = $row['jobPosition'];
        $this->submissionDate->DbValue = $row['submissionDate'];
        $this->bankruptcy_tendency->DbValue = $row['bankruptcy_tendency'];
        $this->blacklist_tendency->DbValue = $row['blacklist_tendency'];
        $this->money_laundering_tendency->DbValue = $row['money_laundering_tendency'];
        $this->mobile_fraud_behavior->DbValue = $row['mobile_fraud_behavior'];
        $this->face_similarity_score->DbValue = $row['face_similarity_score'];
        $this->identification_verification_matched_flag->DbValue = $row['identification_verification_matched_flag'];
        $this->bankstatement_confident_score->DbValue = $row['bankstatement_confident_score'];
        $this->estimated_monthly_income->DbValue = $row['estimated_monthly_income'];
        $this->estimated_monthly_debt->DbValue = $row['estimated_monthly_debt'];
        $this->income_stability->DbValue = $row['income_stability'];
        $this->customer_grade->DbValue = $row['customer_grade'];
        $this->color_sign->DbValue = $row['color_sign'];
        $this->rental_period->DbValue = $row['rental_period'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`member_scb_id` = @member_scb_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->member_scb_id->CurrentValue : $this->member_scb_id->OldValue;
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
                $this->member_scb_id->CurrentValue = $keys[0];
            } else {
                $this->member_scb_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('member_scb_id', $row) ? $row['member_scb_id'] : null;
        } else {
            $val = $this->member_scb_id->OldValue !== null ? $this->member_scb_id->OldValue : $this->member_scb_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@member_scb_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("memberscblist");
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
        if ($pageName == "memberscbview") {
            return $Language->phrase("View");
        } elseif ($pageName == "memberscbedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "memberscbadd") {
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
                return "MemberScbView";
            case Config("API_ADD_ACTION"):
                return "MemberScbAdd";
            case Config("API_EDIT_ACTION"):
                return "MemberScbEdit";
            case Config("API_DELETE_ACTION"):
                return "MemberScbDelete";
            case Config("API_LIST_ACTION"):
                return "MemberScbList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "memberscblist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("memberscbview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("memberscbview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "memberscbadd?" . $this->getUrlParm($parm);
        } else {
            $url = "memberscbadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("memberscbedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("memberscbadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("memberscbdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"member_scb_id\":" . JsonEncode($this->member_scb_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->member_scb_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->member_scb_id->CurrentValue);
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
            if (($keyValue = Param("member_scb_id") ?? Route("member_scb_id")) !== null) {
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
                $this->member_scb_id->CurrentValue = $key;
            } else {
                $this->member_scb_id->OldValue = $key;
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
        $this->member_scb_id->setDbValue($row['member_scb_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->reference_id->setDbValue($row['reference_id']);
        $this->reference_url->setDbValue($row['reference_url']);
        $this->refreshtoken->setDbValue($row['refreshtoken']);
        $this->auth_code->setDbValue($row['auth_code']);
        $this->_token->setDbValue($row['token']);
        $this->state->setDbValue($row['state']);
        $this->status->setDbValue($row['status']);
        $this->at_expire_in->setDbValue($row['at_expire_in']);
        $this->rt_expire_in->setDbValue($row['rt_expire_in']);
        $this->decision_status->setDbValue($row['decision_status']);
        $this->decision_timestamp->setDbValue($row['decision_timestamp']);
        $this->deposit_amount->setDbValue($row['deposit_amount']);
        $this->due_date->setDbValue($row['due_date']);
        $this->rental_fee->setDbValue($row['rental_fee']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->fullName->setDbValue($row['fullName']);
        $this->age->setDbValue($row['age']);
        $this->maritalStatus->setDbValue($row['maritalStatus']);
        $this->noOfChildren->setDbValue($row['noOfChildren']);
        $this->educationLevel->setDbValue($row['educationLevel']);
        $this->workplace->setDbValue($row['workplace']);
        $this->occupation->setDbValue($row['occupation']);
        $this->jobPosition->setDbValue($row['jobPosition']);
        $this->submissionDate->setDbValue($row['submissionDate']);
        $this->bankruptcy_tendency->setDbValue($row['bankruptcy_tendency']);
        $this->blacklist_tendency->setDbValue($row['blacklist_tendency']);
        $this->money_laundering_tendency->setDbValue($row['money_laundering_tendency']);
        $this->mobile_fraud_behavior->setDbValue($row['mobile_fraud_behavior']);
        $this->face_similarity_score->setDbValue($row['face_similarity_score']);
        $this->identification_verification_matched_flag->setDbValue($row['identification_verification_matched_flag']);
        $this->bankstatement_confident_score->setDbValue($row['bankstatement_confident_score']);
        $this->estimated_monthly_income->setDbValue($row['estimated_monthly_income']);
        $this->estimated_monthly_debt->setDbValue($row['estimated_monthly_debt']);
        $this->income_stability->setDbValue($row['income_stability']);
        $this->customer_grade->setDbValue($row['customer_grade']);
        $this->color_sign->setDbValue($row['color_sign']);
        $this->rental_period->setDbValue($row['rental_period']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // member_scb_id
        $this->member_scb_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // asset_id

        // reference_id

        // reference_url

        // refreshtoken

        // auth_code

        // token

        // state

        // status

        // at_expire_in

        // rt_expire_in

        // decision_status

        // decision_timestamp

        // deposit_amount

        // due_date

        // rental_fee

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // fullName

        // age

        // maritalStatus

        // noOfChildren

        // educationLevel

        // workplace

        // occupation

        // jobPosition

        // submissionDate

        // bankruptcy_tendency

        // blacklist_tendency

        // money_laundering_tendency

        // mobile_fraud_behavior

        // face_similarity_score

        // identification_verification_matched_flag

        // bankstatement_confident_score

        // estimated_monthly_income

        // estimated_monthly_debt

        // income_stability

        // customer_grade

        // color_sign

        // rental_period

        // member_scb_id
        $this->member_scb_id->ViewValue = $this->member_scb_id->CurrentValue;
        $this->member_scb_id->ViewCustomAttributes = "";

        // member_id
        $curVal = strval($this->member_id->CurrentValue);
        if ($curVal != "") {
            $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
            if ($this->member_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`isactive` = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->member_id->Lookup->renderViewRow($rswrk[0]);
                    $this->member_id->ViewValue = $this->member_id->displayValue($arwrk);
                } else {
                    $this->member_id->ViewValue = FormatNumber($this->member_id->CurrentValue, $this->member_id->formatPattern());
                }
            }
        } else {
            $this->member_id->ViewValue = null;
        }
        $this->member_id->ViewCustomAttributes = "";

        // asset_id
        $curVal = strval($this->asset_id->CurrentValue);
        if ($curVal != "") {
            $this->asset_id->ViewValue = $this->asset_id->lookupCacheOption($curVal);
            if ($this->asset_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`asset_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->asset_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                    $this->asset_id->ViewValue = $this->asset_id->displayValue($arwrk);
                } else {
                    $this->asset_id->ViewValue = FormatNumber($this->asset_id->CurrentValue, $this->asset_id->formatPattern());
                }
            }
        } else {
            $this->asset_id->ViewValue = null;
        }
        $this->asset_id->ViewCustomAttributes = "";

        // reference_id
        $this->reference_id->ViewValue = $this->reference_id->CurrentValue;
        $this->reference_id->ViewCustomAttributes = "";

        // reference_url
        $this->reference_url->ViewValue = $this->reference_url->CurrentValue;
        $this->reference_url->ViewCustomAttributes = "";

        // refreshtoken
        $this->refreshtoken->ViewValue = $this->refreshtoken->CurrentValue;
        $this->refreshtoken->ViewCustomAttributes = "";

        // auth_code
        $this->auth_code->ViewValue = $this->auth_code->CurrentValue;
        $this->auth_code->ViewCustomAttributes = "";

        // token
        $this->_token->ViewValue = $this->_token->CurrentValue;
        $this->_token->ViewCustomAttributes = "";

        // state
        $this->state->ViewValue = $this->state->CurrentValue;
        $this->state->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // at_expire_in
        $this->at_expire_in->ViewValue = $this->at_expire_in->CurrentValue;
        $this->at_expire_in->ViewCustomAttributes = "";

        // rt_expire_in
        $this->rt_expire_in->ViewValue = $this->rt_expire_in->CurrentValue;
        $this->rt_expire_in->ViewCustomAttributes = "";

        // decision_status
        $this->decision_status->ViewValue = $this->decision_status->CurrentValue;
        $this->decision_status->ViewCustomAttributes = "";

        // decision_timestamp
        $this->decision_timestamp->ViewValue = $this->decision_timestamp->CurrentValue;
        $this->decision_timestamp->ViewValue = FormatDateTime($this->decision_timestamp->ViewValue, $this->decision_timestamp->formatPattern());
        $this->decision_timestamp->ViewCustomAttributes = "";

        // deposit_amount
        $this->deposit_amount->ViewValue = $this->deposit_amount->CurrentValue;
        $this->deposit_amount->ViewValue = FormatNumber($this->deposit_amount->ViewValue, $this->deposit_amount->formatPattern());
        $this->deposit_amount->ViewCustomAttributes = "";

        // due_date
        $this->due_date->ViewValue = $this->due_date->CurrentValue;
        $this->due_date->ViewValue = FormatDateTime($this->due_date->ViewValue, $this->due_date->formatPattern());
        $this->due_date->ViewCustomAttributes = "";

        // rental_fee
        $this->rental_fee->ViewValue = $this->rental_fee->CurrentValue;
        $this->rental_fee->ViewValue = FormatNumber($this->rental_fee->ViewValue, $this->rental_fee->formatPattern());
        $this->rental_fee->ViewCustomAttributes = "";

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

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
        $this->uuser->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // fullName
        $this->fullName->ViewValue = $this->fullName->CurrentValue;
        $this->fullName->ViewCustomAttributes = "";

        // age
        $this->age->ViewValue = $this->age->CurrentValue;
        $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
        $this->age->ViewCustomAttributes = "";

        // maritalStatus
        $this->maritalStatus->ViewValue = $this->maritalStatus->CurrentValue;
        $this->maritalStatus->ViewCustomAttributes = "";

        // noOfChildren
        $this->noOfChildren->ViewValue = $this->noOfChildren->CurrentValue;
        $this->noOfChildren->ViewCustomAttributes = "";

        // educationLevel
        $this->educationLevel->ViewValue = $this->educationLevel->CurrentValue;
        $this->educationLevel->ViewCustomAttributes = "";

        // workplace
        $this->workplace->ViewValue = $this->workplace->CurrentValue;
        $this->workplace->ViewCustomAttributes = "";

        // occupation
        $this->occupation->ViewValue = $this->occupation->CurrentValue;
        $this->occupation->ViewCustomAttributes = "";

        // jobPosition
        $this->jobPosition->ViewValue = $this->jobPosition->CurrentValue;
        $this->jobPosition->ViewCustomAttributes = "";

        // submissionDate
        $this->submissionDate->ViewValue = $this->submissionDate->CurrentValue;
        $this->submissionDate->ViewValue = FormatDateTime($this->submissionDate->ViewValue, $this->submissionDate->formatPattern());
        $this->submissionDate->ViewCustomAttributes = "";

        // bankruptcy_tendency
        $this->bankruptcy_tendency->ViewValue = $this->bankruptcy_tendency->CurrentValue;
        $this->bankruptcy_tendency->ViewCustomAttributes = "";

        // blacklist_tendency
        $this->blacklist_tendency->ViewValue = $this->blacklist_tendency->CurrentValue;
        $this->blacklist_tendency->ViewCustomAttributes = "";

        // money_laundering_tendency
        $this->money_laundering_tendency->ViewValue = $this->money_laundering_tendency->CurrentValue;
        $this->money_laundering_tendency->ViewCustomAttributes = "";

        // mobile_fraud_behavior
        $this->mobile_fraud_behavior->ViewValue = $this->mobile_fraud_behavior->CurrentValue;
        $this->mobile_fraud_behavior->ViewCustomAttributes = "";

        // face_similarity_score
        $this->face_similarity_score->ViewValue = $this->face_similarity_score->CurrentValue;
        $this->face_similarity_score->ViewCustomAttributes = "";

        // identification_verification_matched_flag
        $this->identification_verification_matched_flag->ViewValue = $this->identification_verification_matched_flag->CurrentValue;
        $this->identification_verification_matched_flag->ViewCustomAttributes = "";

        // bankstatement_confident_score
        $this->bankstatement_confident_score->ViewValue = $this->bankstatement_confident_score->CurrentValue;
        $this->bankstatement_confident_score->ViewCustomAttributes = "";

        // estimated_monthly_income
        $this->estimated_monthly_income->ViewValue = $this->estimated_monthly_income->CurrentValue;
        $this->estimated_monthly_income->ViewCustomAttributes = "";

        // estimated_monthly_debt
        $this->estimated_monthly_debt->ViewValue = $this->estimated_monthly_debt->CurrentValue;
        $this->estimated_monthly_debt->ViewCustomAttributes = "";

        // income_stability
        $this->income_stability->ViewValue = $this->income_stability->CurrentValue;
        $this->income_stability->ViewCustomAttributes = "";

        // customer_grade
        $this->customer_grade->ViewValue = $this->customer_grade->CurrentValue;
        $this->customer_grade->ViewCustomAttributes = "";

        // color_sign
        $this->color_sign->ViewValue = $this->color_sign->CurrentValue;
        $this->color_sign->ViewCustomAttributes = "";

        // rental_period
        $this->rental_period->ViewValue = $this->rental_period->CurrentValue;
        $this->rental_period->ViewValue = FormatNumber($this->rental_period->ViewValue, $this->rental_period->formatPattern());
        $this->rental_period->ViewCustomAttributes = "";

        // member_scb_id
        $this->member_scb_id->LinkCustomAttributes = "";
        $this->member_scb_id->HrefValue = "";
        $this->member_scb_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // reference_id
        $this->reference_id->LinkCustomAttributes = "";
        $this->reference_id->HrefValue = "";
        $this->reference_id->TooltipValue = "";

        // reference_url
        $this->reference_url->LinkCustomAttributes = "";
        $this->reference_url->HrefValue = "";
        $this->reference_url->TooltipValue = "";

        // refreshtoken
        $this->refreshtoken->LinkCustomAttributes = "";
        $this->refreshtoken->HrefValue = "";
        $this->refreshtoken->TooltipValue = "";

        // auth_code
        $this->auth_code->LinkCustomAttributes = "";
        $this->auth_code->HrefValue = "";
        $this->auth_code->TooltipValue = "";

        // token
        $this->_token->LinkCustomAttributes = "";
        $this->_token->HrefValue = "";
        $this->_token->TooltipValue = "";

        // state
        $this->state->LinkCustomAttributes = "";
        $this->state->HrefValue = "";
        $this->state->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // at_expire_in
        $this->at_expire_in->LinkCustomAttributes = "";
        $this->at_expire_in->HrefValue = "";
        $this->at_expire_in->TooltipValue = "";

        // rt_expire_in
        $this->rt_expire_in->LinkCustomAttributes = "";
        $this->rt_expire_in->HrefValue = "";
        $this->rt_expire_in->TooltipValue = "";

        // decision_status
        $this->decision_status->LinkCustomAttributes = "";
        $this->decision_status->HrefValue = "";
        $this->decision_status->TooltipValue = "";

        // decision_timestamp
        $this->decision_timestamp->LinkCustomAttributes = "";
        $this->decision_timestamp->HrefValue = "";
        $this->decision_timestamp->TooltipValue = "";

        // deposit_amount
        $this->deposit_amount->LinkCustomAttributes = "";
        $this->deposit_amount->HrefValue = "";
        $this->deposit_amount->TooltipValue = "";

        // due_date
        $this->due_date->LinkCustomAttributes = "";
        $this->due_date->HrefValue = "";
        $this->due_date->TooltipValue = "";

        // rental_fee
        $this->rental_fee->LinkCustomAttributes = "";
        $this->rental_fee->HrefValue = "";
        $this->rental_fee->TooltipValue = "";

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

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // fullName
        $this->fullName->LinkCustomAttributes = "";
        $this->fullName->HrefValue = "";
        $this->fullName->TooltipValue = "";

        // age
        $this->age->LinkCustomAttributes = "";
        $this->age->HrefValue = "";
        $this->age->TooltipValue = "";

        // maritalStatus
        $this->maritalStatus->LinkCustomAttributes = "";
        $this->maritalStatus->HrefValue = "";
        $this->maritalStatus->TooltipValue = "";

        // noOfChildren
        $this->noOfChildren->LinkCustomAttributes = "";
        $this->noOfChildren->HrefValue = "";
        $this->noOfChildren->TooltipValue = "";

        // educationLevel
        $this->educationLevel->LinkCustomAttributes = "";
        $this->educationLevel->HrefValue = "";
        $this->educationLevel->TooltipValue = "";

        // workplace
        $this->workplace->LinkCustomAttributes = "";
        $this->workplace->HrefValue = "";
        $this->workplace->TooltipValue = "";

        // occupation
        $this->occupation->LinkCustomAttributes = "";
        $this->occupation->HrefValue = "";
        $this->occupation->TooltipValue = "";

        // jobPosition
        $this->jobPosition->LinkCustomAttributes = "";
        $this->jobPosition->HrefValue = "";
        $this->jobPosition->TooltipValue = "";

        // submissionDate
        $this->submissionDate->LinkCustomAttributes = "";
        $this->submissionDate->HrefValue = "";
        $this->submissionDate->TooltipValue = "";

        // bankruptcy_tendency
        $this->bankruptcy_tendency->LinkCustomAttributes = "";
        $this->bankruptcy_tendency->HrefValue = "";
        $this->bankruptcy_tendency->TooltipValue = "";

        // blacklist_tendency
        $this->blacklist_tendency->LinkCustomAttributes = "";
        $this->blacklist_tendency->HrefValue = "";
        $this->blacklist_tendency->TooltipValue = "";

        // money_laundering_tendency
        $this->money_laundering_tendency->LinkCustomAttributes = "";
        $this->money_laundering_tendency->HrefValue = "";
        $this->money_laundering_tendency->TooltipValue = "";

        // mobile_fraud_behavior
        $this->mobile_fraud_behavior->LinkCustomAttributes = "";
        $this->mobile_fraud_behavior->HrefValue = "";
        $this->mobile_fraud_behavior->TooltipValue = "";

        // face_similarity_score
        $this->face_similarity_score->LinkCustomAttributes = "";
        $this->face_similarity_score->HrefValue = "";
        $this->face_similarity_score->TooltipValue = "";

        // identification_verification_matched_flag
        $this->identification_verification_matched_flag->LinkCustomAttributes = "";
        $this->identification_verification_matched_flag->HrefValue = "";
        $this->identification_verification_matched_flag->TooltipValue = "";

        // bankstatement_confident_score
        $this->bankstatement_confident_score->LinkCustomAttributes = "";
        $this->bankstatement_confident_score->HrefValue = "";
        $this->bankstatement_confident_score->TooltipValue = "";

        // estimated_monthly_income
        $this->estimated_monthly_income->LinkCustomAttributes = "";
        $this->estimated_monthly_income->HrefValue = "";
        $this->estimated_monthly_income->TooltipValue = "";

        // estimated_monthly_debt
        $this->estimated_monthly_debt->LinkCustomAttributes = "";
        $this->estimated_monthly_debt->HrefValue = "";
        $this->estimated_monthly_debt->TooltipValue = "";

        // income_stability
        $this->income_stability->LinkCustomAttributes = "";
        $this->income_stability->HrefValue = "";
        $this->income_stability->TooltipValue = "";

        // customer_grade
        $this->customer_grade->LinkCustomAttributes = "";
        $this->customer_grade->HrefValue = "";
        $this->customer_grade->TooltipValue = "";

        // color_sign
        $this->color_sign->LinkCustomAttributes = "";
        $this->color_sign->HrefValue = "";
        $this->color_sign->TooltipValue = "";

        // rental_period
        $this->rental_period->LinkCustomAttributes = "";
        $this->rental_period->HrefValue = "";
        $this->rental_period->TooltipValue = "";

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

        // member_scb_id
        $this->member_scb_id->setupEditAttributes();
        $this->member_scb_id->EditCustomAttributes = "";
        $this->member_scb_id->EditValue = $this->member_scb_id->CurrentValue;
        $this->member_scb_id->ViewCustomAttributes = "";

        // member_id
        $this->member_id->setupEditAttributes();
        $this->member_id->EditCustomAttributes = "";
        $curVal = strval($this->member_id->CurrentValue);
        if ($curVal != "") {
            $this->member_id->EditValue = $this->member_id->lookupCacheOption($curVal);
            if ($this->member_id->EditValue === null) { // Lookup from database
                $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`isactive` = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->member_id->Lookup->renderViewRow($rswrk[0]);
                    $this->member_id->EditValue = $this->member_id->displayValue($arwrk);
                } else {
                    $this->member_id->EditValue = FormatNumber($this->member_id->CurrentValue, $this->member_id->formatPattern());
                }
            }
        } else {
            $this->member_id->EditValue = null;
        }
        $this->member_id->ViewCustomAttributes = "";

        // asset_id
        $this->asset_id->setupEditAttributes();
        $this->asset_id->EditCustomAttributes = "";
        $curVal = strval($this->asset_id->CurrentValue);
        if ($curVal != "") {
            $this->asset_id->EditValue = $this->asset_id->lookupCacheOption($curVal);
            if ($this->asset_id->EditValue === null) { // Lookup from database
                $filterWrk = "`asset_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->asset_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                    $this->asset_id->EditValue = $this->asset_id->displayValue($arwrk);
                } else {
                    $this->asset_id->EditValue = FormatNumber($this->asset_id->CurrentValue, $this->asset_id->formatPattern());
                }
            }
        } else {
            $this->asset_id->EditValue = null;
        }
        $this->asset_id->ViewCustomAttributes = "";

        // reference_id
        $this->reference_id->setupEditAttributes();
        $this->reference_id->EditCustomAttributes = "";
        if (!$this->reference_id->Raw) {
            $this->reference_id->CurrentValue = HtmlDecode($this->reference_id->CurrentValue);
        }
        $this->reference_id->EditValue = $this->reference_id->CurrentValue;
        $this->reference_id->PlaceHolder = RemoveHtml($this->reference_id->caption());

        // reference_url
        $this->reference_url->setupEditAttributes();
        $this->reference_url->EditCustomAttributes = "";
        $this->reference_url->EditValue = $this->reference_url->CurrentValue;
        $this->reference_url->PlaceHolder = RemoveHtml($this->reference_url->caption());

        // refreshtoken
        $this->refreshtoken->setupEditAttributes();
        $this->refreshtoken->EditCustomAttributes = "";
        $this->refreshtoken->EditValue = $this->refreshtoken->CurrentValue;
        $this->refreshtoken->PlaceHolder = RemoveHtml($this->refreshtoken->caption());

        // auth_code
        $this->auth_code->setupEditAttributes();
        $this->auth_code->EditCustomAttributes = "";
        $this->auth_code->EditValue = $this->auth_code->CurrentValue;
        $this->auth_code->PlaceHolder = RemoveHtml($this->auth_code->caption());

        // token
        $this->_token->setupEditAttributes();
        $this->_token->EditCustomAttributes = "";
        $this->_token->EditValue = $this->_token->CurrentValue;
        $this->_token->PlaceHolder = RemoveHtml($this->_token->caption());

        // state
        $this->state->setupEditAttributes();
        $this->state->EditCustomAttributes = "";
        $this->state->EditValue = $this->state->CurrentValue;
        $this->state->PlaceHolder = RemoveHtml($this->state->caption());

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // at_expire_in
        $this->at_expire_in->setupEditAttributes();
        $this->at_expire_in->EditCustomAttributes = "";
        $this->at_expire_in->EditValue = $this->at_expire_in->CurrentValue;
        $this->at_expire_in->PlaceHolder = RemoveHtml($this->at_expire_in->caption());

        // rt_expire_in
        $this->rt_expire_in->setupEditAttributes();
        $this->rt_expire_in->EditCustomAttributes = "";
        $this->rt_expire_in->EditValue = $this->rt_expire_in->CurrentValue;
        $this->rt_expire_in->PlaceHolder = RemoveHtml($this->rt_expire_in->caption());

        // decision_status
        $this->decision_status->setupEditAttributes();
        $this->decision_status->EditCustomAttributes = "";
        if (!$this->decision_status->Raw) {
            $this->decision_status->CurrentValue = HtmlDecode($this->decision_status->CurrentValue);
        }
        $this->decision_status->EditValue = $this->decision_status->CurrentValue;
        $this->decision_status->PlaceHolder = RemoveHtml($this->decision_status->caption());

        // decision_timestamp
        $this->decision_timestamp->setupEditAttributes();
        $this->decision_timestamp->EditCustomAttributes = "";
        $this->decision_timestamp->EditValue = FormatDateTime($this->decision_timestamp->CurrentValue, $this->decision_timestamp->formatPattern());
        $this->decision_timestamp->PlaceHolder = RemoveHtml($this->decision_timestamp->caption());

        // deposit_amount
        $this->deposit_amount->setupEditAttributes();
        $this->deposit_amount->EditCustomAttributes = "";
        $this->deposit_amount->EditValue = $this->deposit_amount->CurrentValue;
        $this->deposit_amount->PlaceHolder = RemoveHtml($this->deposit_amount->caption());
        if (strval($this->deposit_amount->EditValue) != "" && is_numeric($this->deposit_amount->EditValue)) {
            $this->deposit_amount->EditValue = FormatNumber($this->deposit_amount->EditValue, null);
        }

        // due_date
        $this->due_date->setupEditAttributes();
        $this->due_date->EditCustomAttributes = "";
        $this->due_date->EditValue = FormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern());
        $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());

        // rental_fee
        $this->rental_fee->setupEditAttributes();
        $this->rental_fee->EditCustomAttributes = "";
        $this->rental_fee->EditValue = $this->rental_fee->CurrentValue;
        $this->rental_fee->PlaceHolder = RemoveHtml($this->rental_fee->caption());
        if (strval($this->rental_fee->EditValue) != "" && is_numeric($this->rental_fee->EditValue)) {
            $this->rental_fee->EditValue = FormatNumber($this->rental_fee->EditValue, null);
        }

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // fullName
        $this->fullName->setupEditAttributes();
        $this->fullName->EditCustomAttributes = "";
        if (!$this->fullName->Raw) {
            $this->fullName->CurrentValue = HtmlDecode($this->fullName->CurrentValue);
        }
        $this->fullName->EditValue = $this->fullName->CurrentValue;
        $this->fullName->PlaceHolder = RemoveHtml($this->fullName->caption());

        // age
        $this->age->setupEditAttributes();
        $this->age->EditCustomAttributes = "";
        $this->age->EditValue = $this->age->CurrentValue;
        $this->age->PlaceHolder = RemoveHtml($this->age->caption());
        if (strval($this->age->EditValue) != "" && is_numeric($this->age->EditValue)) {
            $this->age->EditValue = FormatNumber($this->age->EditValue, null);
        }

        // maritalStatus
        $this->maritalStatus->setupEditAttributes();
        $this->maritalStatus->EditCustomAttributes = "";
        if (!$this->maritalStatus->Raw) {
            $this->maritalStatus->CurrentValue = HtmlDecode($this->maritalStatus->CurrentValue);
        }
        $this->maritalStatus->EditValue = $this->maritalStatus->CurrentValue;
        $this->maritalStatus->PlaceHolder = RemoveHtml($this->maritalStatus->caption());

        // noOfChildren
        $this->noOfChildren->setupEditAttributes();
        $this->noOfChildren->EditCustomAttributes = "";
        if (!$this->noOfChildren->Raw) {
            $this->noOfChildren->CurrentValue = HtmlDecode($this->noOfChildren->CurrentValue);
        }
        $this->noOfChildren->EditValue = $this->noOfChildren->CurrentValue;
        $this->noOfChildren->PlaceHolder = RemoveHtml($this->noOfChildren->caption());

        // educationLevel
        $this->educationLevel->setupEditAttributes();
        $this->educationLevel->EditCustomAttributes = "";
        if (!$this->educationLevel->Raw) {
            $this->educationLevel->CurrentValue = HtmlDecode($this->educationLevel->CurrentValue);
        }
        $this->educationLevel->EditValue = $this->educationLevel->CurrentValue;
        $this->educationLevel->PlaceHolder = RemoveHtml($this->educationLevel->caption());

        // workplace
        $this->workplace->setupEditAttributes();
        $this->workplace->EditCustomAttributes = "";
        if (!$this->workplace->Raw) {
            $this->workplace->CurrentValue = HtmlDecode($this->workplace->CurrentValue);
        }
        $this->workplace->EditValue = $this->workplace->CurrentValue;
        $this->workplace->PlaceHolder = RemoveHtml($this->workplace->caption());

        // occupation
        $this->occupation->setupEditAttributes();
        $this->occupation->EditCustomAttributes = "";
        if (!$this->occupation->Raw) {
            $this->occupation->CurrentValue = HtmlDecode($this->occupation->CurrentValue);
        }
        $this->occupation->EditValue = $this->occupation->CurrentValue;
        $this->occupation->PlaceHolder = RemoveHtml($this->occupation->caption());

        // jobPosition
        $this->jobPosition->setupEditAttributes();
        $this->jobPosition->EditCustomAttributes = "";
        if (!$this->jobPosition->Raw) {
            $this->jobPosition->CurrentValue = HtmlDecode($this->jobPosition->CurrentValue);
        }
        $this->jobPosition->EditValue = $this->jobPosition->CurrentValue;
        $this->jobPosition->PlaceHolder = RemoveHtml($this->jobPosition->caption());

        // submissionDate
        $this->submissionDate->setupEditAttributes();
        $this->submissionDate->EditCustomAttributes = "";
        $this->submissionDate->EditValue = FormatDateTime($this->submissionDate->CurrentValue, $this->submissionDate->formatPattern());
        $this->submissionDate->PlaceHolder = RemoveHtml($this->submissionDate->caption());

        // bankruptcy_tendency
        $this->bankruptcy_tendency->setupEditAttributes();
        $this->bankruptcy_tendency->EditCustomAttributes = "";
        if (!$this->bankruptcy_tendency->Raw) {
            $this->bankruptcy_tendency->CurrentValue = HtmlDecode($this->bankruptcy_tendency->CurrentValue);
        }
        $this->bankruptcy_tendency->EditValue = $this->bankruptcy_tendency->CurrentValue;
        $this->bankruptcy_tendency->PlaceHolder = RemoveHtml($this->bankruptcy_tendency->caption());

        // blacklist_tendency
        $this->blacklist_tendency->setupEditAttributes();
        $this->blacklist_tendency->EditCustomAttributes = "";
        if (!$this->blacklist_tendency->Raw) {
            $this->blacklist_tendency->CurrentValue = HtmlDecode($this->blacklist_tendency->CurrentValue);
        }
        $this->blacklist_tendency->EditValue = $this->blacklist_tendency->CurrentValue;
        $this->blacklist_tendency->PlaceHolder = RemoveHtml($this->blacklist_tendency->caption());

        // money_laundering_tendency
        $this->money_laundering_tendency->setupEditAttributes();
        $this->money_laundering_tendency->EditCustomAttributes = "";
        if (!$this->money_laundering_tendency->Raw) {
            $this->money_laundering_tendency->CurrentValue = HtmlDecode($this->money_laundering_tendency->CurrentValue);
        }
        $this->money_laundering_tendency->EditValue = $this->money_laundering_tendency->CurrentValue;
        $this->money_laundering_tendency->PlaceHolder = RemoveHtml($this->money_laundering_tendency->caption());

        // mobile_fraud_behavior
        $this->mobile_fraud_behavior->setupEditAttributes();
        $this->mobile_fraud_behavior->EditCustomAttributes = "";
        if (!$this->mobile_fraud_behavior->Raw) {
            $this->mobile_fraud_behavior->CurrentValue = HtmlDecode($this->mobile_fraud_behavior->CurrentValue);
        }
        $this->mobile_fraud_behavior->EditValue = $this->mobile_fraud_behavior->CurrentValue;
        $this->mobile_fraud_behavior->PlaceHolder = RemoveHtml($this->mobile_fraud_behavior->caption());

        // face_similarity_score
        $this->face_similarity_score->setupEditAttributes();
        $this->face_similarity_score->EditCustomAttributes = "";
        if (!$this->face_similarity_score->Raw) {
            $this->face_similarity_score->CurrentValue = HtmlDecode($this->face_similarity_score->CurrentValue);
        }
        $this->face_similarity_score->EditValue = $this->face_similarity_score->CurrentValue;
        $this->face_similarity_score->PlaceHolder = RemoveHtml($this->face_similarity_score->caption());

        // identification_verification_matched_flag
        $this->identification_verification_matched_flag->setupEditAttributes();
        $this->identification_verification_matched_flag->EditCustomAttributes = "";
        if (!$this->identification_verification_matched_flag->Raw) {
            $this->identification_verification_matched_flag->CurrentValue = HtmlDecode($this->identification_verification_matched_flag->CurrentValue);
        }
        $this->identification_verification_matched_flag->EditValue = $this->identification_verification_matched_flag->CurrentValue;
        $this->identification_verification_matched_flag->PlaceHolder = RemoveHtml($this->identification_verification_matched_flag->caption());

        // bankstatement_confident_score
        $this->bankstatement_confident_score->setupEditAttributes();
        $this->bankstatement_confident_score->EditCustomAttributes = "";
        if (!$this->bankstatement_confident_score->Raw) {
            $this->bankstatement_confident_score->CurrentValue = HtmlDecode($this->bankstatement_confident_score->CurrentValue);
        }
        $this->bankstatement_confident_score->EditValue = $this->bankstatement_confident_score->CurrentValue;
        $this->bankstatement_confident_score->PlaceHolder = RemoveHtml($this->bankstatement_confident_score->caption());

        // estimated_monthly_income
        $this->estimated_monthly_income->setupEditAttributes();
        $this->estimated_monthly_income->EditCustomAttributes = "";
        if (!$this->estimated_monthly_income->Raw) {
            $this->estimated_monthly_income->CurrentValue = HtmlDecode($this->estimated_monthly_income->CurrentValue);
        }
        $this->estimated_monthly_income->EditValue = $this->estimated_monthly_income->CurrentValue;
        $this->estimated_monthly_income->PlaceHolder = RemoveHtml($this->estimated_monthly_income->caption());

        // estimated_monthly_debt
        $this->estimated_monthly_debt->setupEditAttributes();
        $this->estimated_monthly_debt->EditCustomAttributes = "";
        if (!$this->estimated_monthly_debt->Raw) {
            $this->estimated_monthly_debt->CurrentValue = HtmlDecode($this->estimated_monthly_debt->CurrentValue);
        }
        $this->estimated_monthly_debt->EditValue = $this->estimated_monthly_debt->CurrentValue;
        $this->estimated_monthly_debt->PlaceHolder = RemoveHtml($this->estimated_monthly_debt->caption());

        // income_stability
        $this->income_stability->setupEditAttributes();
        $this->income_stability->EditCustomAttributes = "";
        if (!$this->income_stability->Raw) {
            $this->income_stability->CurrentValue = HtmlDecode($this->income_stability->CurrentValue);
        }
        $this->income_stability->EditValue = $this->income_stability->CurrentValue;
        $this->income_stability->PlaceHolder = RemoveHtml($this->income_stability->caption());

        // customer_grade
        $this->customer_grade->setupEditAttributes();
        $this->customer_grade->EditCustomAttributes = "";
        if (!$this->customer_grade->Raw) {
            $this->customer_grade->CurrentValue = HtmlDecode($this->customer_grade->CurrentValue);
        }
        $this->customer_grade->EditValue = $this->customer_grade->CurrentValue;
        $this->customer_grade->PlaceHolder = RemoveHtml($this->customer_grade->caption());

        // color_sign
        $this->color_sign->setupEditAttributes();
        $this->color_sign->EditCustomAttributes = "";
        if (!$this->color_sign->Raw) {
            $this->color_sign->CurrentValue = HtmlDecode($this->color_sign->CurrentValue);
        }
        $this->color_sign->EditValue = $this->color_sign->CurrentValue;
        $this->color_sign->PlaceHolder = RemoveHtml($this->color_sign->caption());

        // rental_period
        $this->rental_period->setupEditAttributes();
        $this->rental_period->EditCustomAttributes = "";
        $this->rental_period->EditValue = $this->rental_period->CurrentValue;
        $this->rental_period->PlaceHolder = RemoveHtml($this->rental_period->caption());
        if (strval($this->rental_period->EditValue) != "" && is_numeric($this->rental_period->EditValue)) {
            $this->rental_period->EditValue = FormatNumber($this->rental_period->EditValue, null);
        }

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
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->reference_id);
                    $doc->exportCaption($this->reference_url);
                    $doc->exportCaption($this->refreshtoken);
                    $doc->exportCaption($this->auth_code);
                    $doc->exportCaption($this->_token);
                    $doc->exportCaption($this->state);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->at_expire_in);
                    $doc->exportCaption($this->rt_expire_in);
                    $doc->exportCaption($this->decision_status);
                    $doc->exportCaption($this->decision_timestamp);
                    $doc->exportCaption($this->deposit_amount);
                    $doc->exportCaption($this->due_date);
                    $doc->exportCaption($this->rental_fee);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->fullName);
                    $doc->exportCaption($this->age);
                    $doc->exportCaption($this->maritalStatus);
                    $doc->exportCaption($this->noOfChildren);
                    $doc->exportCaption($this->educationLevel);
                    $doc->exportCaption($this->workplace);
                    $doc->exportCaption($this->occupation);
                    $doc->exportCaption($this->jobPosition);
                    $doc->exportCaption($this->submissionDate);
                    $doc->exportCaption($this->bankruptcy_tendency);
                    $doc->exportCaption($this->blacklist_tendency);
                    $doc->exportCaption($this->money_laundering_tendency);
                    $doc->exportCaption($this->mobile_fraud_behavior);
                    $doc->exportCaption($this->face_similarity_score);
                    $doc->exportCaption($this->identification_verification_matched_flag);
                    $doc->exportCaption($this->bankstatement_confident_score);
                    $doc->exportCaption($this->estimated_monthly_income);
                    $doc->exportCaption($this->estimated_monthly_debt);
                    $doc->exportCaption($this->income_stability);
                    $doc->exportCaption($this->customer_grade);
                    $doc->exportCaption($this->color_sign);
                    $doc->exportCaption($this->rental_period);
                } else {
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->reference_id);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->decision_status);
                    $doc->exportCaption($this->decision_timestamp);
                    $doc->exportCaption($this->deposit_amount);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->fullName);
                    $doc->exportCaption($this->age);
                    $doc->exportCaption($this->maritalStatus);
                    $doc->exportCaption($this->noOfChildren);
                    $doc->exportCaption($this->educationLevel);
                    $doc->exportCaption($this->workplace);
                    $doc->exportCaption($this->occupation);
                    $doc->exportCaption($this->jobPosition);
                    $doc->exportCaption($this->submissionDate);
                    $doc->exportCaption($this->bankruptcy_tendency);
                    $doc->exportCaption($this->blacklist_tendency);
                    $doc->exportCaption($this->money_laundering_tendency);
                    $doc->exportCaption($this->mobile_fraud_behavior);
                    $doc->exportCaption($this->face_similarity_score);
                    $doc->exportCaption($this->identification_verification_matched_flag);
                    $doc->exportCaption($this->bankstatement_confident_score);
                    $doc->exportCaption($this->estimated_monthly_income);
                    $doc->exportCaption($this->estimated_monthly_debt);
                    $doc->exportCaption($this->income_stability);
                    $doc->exportCaption($this->customer_grade);
                    $doc->exportCaption($this->color_sign);
                    $doc->exportCaption($this->rental_period);
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
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->reference_id);
                        $doc->exportField($this->reference_url);
                        $doc->exportField($this->refreshtoken);
                        $doc->exportField($this->auth_code);
                        $doc->exportField($this->_token);
                        $doc->exportField($this->state);
                        $doc->exportField($this->status);
                        $doc->exportField($this->at_expire_in);
                        $doc->exportField($this->rt_expire_in);
                        $doc->exportField($this->decision_status);
                        $doc->exportField($this->decision_timestamp);
                        $doc->exportField($this->deposit_amount);
                        $doc->exportField($this->due_date);
                        $doc->exportField($this->rental_fee);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->fullName);
                        $doc->exportField($this->age);
                        $doc->exportField($this->maritalStatus);
                        $doc->exportField($this->noOfChildren);
                        $doc->exportField($this->educationLevel);
                        $doc->exportField($this->workplace);
                        $doc->exportField($this->occupation);
                        $doc->exportField($this->jobPosition);
                        $doc->exportField($this->submissionDate);
                        $doc->exportField($this->bankruptcy_tendency);
                        $doc->exportField($this->blacklist_tendency);
                        $doc->exportField($this->money_laundering_tendency);
                        $doc->exportField($this->mobile_fraud_behavior);
                        $doc->exportField($this->face_similarity_score);
                        $doc->exportField($this->identification_verification_matched_flag);
                        $doc->exportField($this->bankstatement_confident_score);
                        $doc->exportField($this->estimated_monthly_income);
                        $doc->exportField($this->estimated_monthly_debt);
                        $doc->exportField($this->income_stability);
                        $doc->exportField($this->customer_grade);
                        $doc->exportField($this->color_sign);
                        $doc->exportField($this->rental_period);
                    } else {
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->reference_id);
                        $doc->exportField($this->status);
                        $doc->exportField($this->decision_status);
                        $doc->exportField($this->decision_timestamp);
                        $doc->exportField($this->deposit_amount);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->fullName);
                        $doc->exportField($this->age);
                        $doc->exportField($this->maritalStatus);
                        $doc->exportField($this->noOfChildren);
                        $doc->exportField($this->educationLevel);
                        $doc->exportField($this->workplace);
                        $doc->exportField($this->occupation);
                        $doc->exportField($this->jobPosition);
                        $doc->exportField($this->submissionDate);
                        $doc->exportField($this->bankruptcy_tendency);
                        $doc->exportField($this->blacklist_tendency);
                        $doc->exportField($this->money_laundering_tendency);
                        $doc->exportField($this->mobile_fraud_behavior);
                        $doc->exportField($this->face_similarity_score);
                        $doc->exportField($this->identification_verification_matched_flag);
                        $doc->exportField($this->bankstatement_confident_score);
                        $doc->exportField($this->estimated_monthly_income);
                        $doc->exportField($this->estimated_monthly_debt);
                        $doc->exportField($this->income_stability);
                        $doc->exportField($this->customer_grade);
                        $doc->exportField($this->color_sign);
                        $doc->exportField($this->rental_period);
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
        // No binary fields
        return false;
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
        // Enter your code here
        // To cancel, set return value to false
        return true;
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
