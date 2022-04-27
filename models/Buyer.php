<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for buyer
 */
class Buyer extends DbTable
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
    public $member_id;
    public $first_name;
    public $last_name;
    public $idcardnumber;
    public $_email;
    public $phone;
    public $facebook_id;
    public $line_id;
    public $google_id;
    public $last_login;
    public $_password;
    public $type;
    public $isactive;
    public $isbuyer;
    public $isinvertor;
    public $issale;
    public $isnotification;
    public $reset_password_date;
    public $reset_password_ip;
    public $reset_password_email_code;
    public $reset_password_email_date;
    public $reset_password_email_ip;
    public $resetTimestamp;
    public $resetKeyTimestamp;
    public $reset_password_code;
    public $code_phone;
    public $image_profile;
    public $customer_id;
    public $verify_key;
    public $verify_status;
    public $verify_date;
    public $verify_ip;
    public $pipedrive_people_id;
    public $cdate;
    public $cip;
    public $cuser;
    public $udate;
    public $uip;
    public $uuser;
    public $verify_phone_status;
    public $verify_phone_date;
    public $verify_phone_ip;
    public $is_peak_contact;
    public $last_change_password;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'buyer';
        $this->TableName = 'buyer';
        $this->TableType = 'LINKTABLE';

        // Update Table
        $this->UpdateTable = "`member`";
        $this->Dbid = 'juzmatch1';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
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

        // member_id
        $this->member_id = new DbField(
            'buyer',
            'buyer',
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
            'TEXT'
        );
        $this->member_id->InputTextType = "text";
        $this->member_id->IsAutoIncrement = true; // Autoincrement field
        $this->member_id->IsPrimaryKey = true; // Primary key field
        $this->member_id->IsForeignKey = true; // Foreign key field
        $this->member_id->Sortable = false; // Allow sort
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // first_name
        $this->first_name = new DbField(
            'buyer',
            'buyer',
            'x_first_name',
            'first_name',
            '`first_name`',
            '`first_name`',
            200,
            100,
            -1,
            false,
            '`first_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->first_name->InputTextType = "text";
        $this->Fields['first_name'] = &$this->first_name;

        // last_name
        $this->last_name = new DbField(
            'buyer',
            'buyer',
            'x_last_name',
            'last_name',
            '`last_name`',
            '`last_name`',
            200,
            100,
            -1,
            false,
            '`last_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->last_name->InputTextType = "text";
        $this->Fields['last_name'] = &$this->last_name;

        // idcardnumber
        $this->idcardnumber = new DbField(
            'buyer',
            'buyer',
            'x_idcardnumber',
            'idcardnumber',
            '`idcardnumber`',
            '`idcardnumber`',
            200,
            250,
            -1,
            false,
            '`idcardnumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->idcardnumber->InputTextType = "text";
        $this->Fields['idcardnumber'] = &$this->idcardnumber;

        // email
        $this->_email = new DbField(
            'buyer',
            'buyer',
            'x__email',
            'email',
            '`email`',
            '`email`',
            200,
            255,
            -1,
            false,
            '`email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_email->InputTextType = "text";
        $this->Fields['email'] = &$this->_email;

        // phone
        $this->phone = new DbField(
            'buyer',
            'buyer',
            'x_phone',
            'phone',
            '`phone`',
            '`phone`',
            200,
            255,
            -1,
            false,
            '`phone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->phone->InputTextType = "text";
        $this->Fields['phone'] = &$this->phone;

        // facebook_id
        $this->facebook_id = new DbField(
            'buyer',
            'buyer',
            'x_facebook_id',
            'facebook_id',
            '`facebook_id`',
            '`facebook_id`',
            200,
            255,
            -1,
            false,
            '`facebook_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->facebook_id->InputTextType = "text";
        $this->Fields['facebook_id'] = &$this->facebook_id;

        // line_id
        $this->line_id = new DbField(
            'buyer',
            'buyer',
            'x_line_id',
            'line_id',
            '`line_id`',
            '`line_id`',
            200,
            255,
            -1,
            false,
            '`line_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->line_id->InputTextType = "text";
        $this->Fields['line_id'] = &$this->line_id;

        // google_id
        $this->google_id = new DbField(
            'buyer',
            'buyer',
            'x_google_id',
            'google_id',
            '`google_id`',
            '`google_id`',
            200,
            255,
            -1,
            false,
            '`google_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->google_id->InputTextType = "text";
        $this->Fields['google_id'] = &$this->google_id;

        // last_login
        $this->last_login = new DbField(
            'buyer',
            'buyer',
            'x_last_login',
            'last_login',
            '`last_login`',
            CastDateFieldForLike("`last_login`", 0, "juzmatch1"),
            135,
            19,
            0,
            false,
            '`last_login`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->last_login->InputTextType = "text";
        $this->last_login->Sortable = false; // Allow sort
        $this->last_login->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['last_login'] = &$this->last_login;

        // password
        $this->_password = new DbField(
            'buyer',
            'buyer',
            'x__password',
            'password',
            '`password`',
            '`password`',
            200,
            255,
            -1,
            false,
            '`password`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'PASSWORD'
        );
        $this->_password->InputTextType = "text";
        $this->_password->Sortable = false; // Allow sort
        $this->Fields['password'] = &$this->_password;

        // type
        $this->type = new DbField(
            'buyer',
            'buyer',
            'x_type',
            'type',
            '`type`',
            '`type`',
            3,
            11,
            -1,
            false,
            '`type`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->type->InputTextType = "text";
        $this->type->Nullable = false; // NOT NULL field
        $this->type->Required = true; // Required field
        $this->type->Sortable = false; // Allow sort
        $this->type->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->type->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->type->Lookup = new Lookup('type', 'buyer', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->type->OptionCount = 4;
        $this->type->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type'] = &$this->type;

        // isactive
        $this->isactive = new DbField(
            'buyer',
            'buyer',
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
        $this->isactive->Sortable = false; // Allow sort
        $this->isactive->Lookup = new Lookup('isactive', 'buyer', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->isactive->OptionCount = 2;
        $this->isactive->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isactive'] = &$this->isactive;

        // isbuyer
        $this->isbuyer = new DbField(
            'buyer',
            'buyer',
            'x_isbuyer',
            'isbuyer',
            '`isbuyer`',
            '`isbuyer`',
            3,
            11,
            -1,
            false,
            '`isbuyer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->isbuyer->InputTextType = "text";
        $this->isbuyer->Sortable = false; // Allow sort
        $this->isbuyer->Lookup = new Lookup('isbuyer', 'buyer', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->isbuyer->OptionCount = 2;
        $this->isbuyer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isbuyer'] = &$this->isbuyer;

        // isinvertor
        $this->isinvertor = new DbField(
            'buyer',
            'buyer',
            'x_isinvertor',
            'isinvertor',
            '`isinvertor`',
            '`isinvertor`',
            3,
            11,
            -1,
            false,
            '`isinvertor`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->isinvertor->InputTextType = "text";
        $this->isinvertor->Sortable = false; // Allow sort
        $this->isinvertor->Lookup = new Lookup('isinvertor', 'buyer', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->isinvertor->OptionCount = 2;
        $this->isinvertor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isinvertor'] = &$this->isinvertor;

        // issale
        $this->issale = new DbField(
            'buyer',
            'buyer',
            'x_issale',
            'issale',
            '`issale`',
            '`issale`',
            3,
            11,
            -1,
            false,
            '`issale`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->issale->InputTextType = "text";
        $this->issale->Sortable = false; // Allow sort
        $this->issale->Lookup = new Lookup('issale', 'buyer', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->issale->OptionCount = 2;
        $this->issale->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['issale'] = &$this->issale;

        // isnotification
        $this->isnotification = new DbField(
            'buyer',
            'buyer',
            'x_isnotification',
            'isnotification',
            '`isnotification`',
            '`isnotification`',
            3,
            11,
            -1,
            false,
            '`isnotification`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->isnotification->InputTextType = "text";
        $this->isnotification->Sortable = false; // Allow sort
        $this->isnotification->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isnotification'] = &$this->isnotification;

        // reset_password_date
        $this->reset_password_date = new DbField(
            'buyer',
            'buyer',
            'x_reset_password_date',
            'reset_password_date',
            '`reset_password_date`',
            CastDateFieldForLike("`reset_password_date`", 0, "juzmatch1"),
            135,
            19,
            0,
            false,
            '`reset_password_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reset_password_date->InputTextType = "text";
        $this->reset_password_date->Nullable = false; // NOT NULL field
        $this->reset_password_date->Required = true; // Required field
        $this->reset_password_date->Sortable = false; // Allow sort
        $this->reset_password_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['reset_password_date'] = &$this->reset_password_date;

        // reset_password_ip
        $this->reset_password_ip = new DbField(
            'buyer',
            'buyer',
            'x_reset_password_ip',
            'reset_password_ip',
            '`reset_password_ip`',
            '`reset_password_ip`',
            200,
            255,
            -1,
            false,
            '`reset_password_ip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reset_password_ip->InputTextType = "text";
        $this->reset_password_ip->Nullable = false; // NOT NULL field
        $this->reset_password_ip->Required = true; // Required field
        $this->reset_password_ip->Sortable = false; // Allow sort
        $this->Fields['reset_password_ip'] = &$this->reset_password_ip;

        // reset_password_email_code
        $this->reset_password_email_code = new DbField(
            'buyer',
            'buyer',
            'x_reset_password_email_code',
            'reset_password_email_code',
            '`reset_password_email_code`',
            '`reset_password_email_code`',
            201,
            65535,
            -1,
            false,
            '`reset_password_email_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->reset_password_email_code->InputTextType = "text";
        $this->reset_password_email_code->Nullable = false; // NOT NULL field
        $this->reset_password_email_code->Required = true; // Required field
        $this->reset_password_email_code->Sortable = false; // Allow sort
        $this->Fields['reset_password_email_code'] = &$this->reset_password_email_code;

        // reset_password_email_date
        $this->reset_password_email_date = new DbField(
            'buyer',
            'buyer',
            'x_reset_password_email_date',
            'reset_password_email_date',
            '`reset_password_email_date`',
            CastDateFieldForLike("`reset_password_email_date`", 0, "juzmatch1"),
            135,
            19,
            0,
            false,
            '`reset_password_email_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reset_password_email_date->InputTextType = "text";
        $this->reset_password_email_date->Nullable = false; // NOT NULL field
        $this->reset_password_email_date->Required = true; // Required field
        $this->reset_password_email_date->Sortable = false; // Allow sort
        $this->reset_password_email_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['reset_password_email_date'] = &$this->reset_password_email_date;

        // reset_password_email_ip
        $this->reset_password_email_ip = new DbField(
            'buyer',
            'buyer',
            'x_reset_password_email_ip',
            'reset_password_email_ip',
            '`reset_password_email_ip`',
            '`reset_password_email_ip`',
            200,
            255,
            -1,
            false,
            '`reset_password_email_ip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->reset_password_email_ip->InputTextType = "text";
        $this->reset_password_email_ip->Nullable = false; // NOT NULL field
        $this->reset_password_email_ip->Required = true; // Required field
        $this->reset_password_email_ip->Sortable = false; // Allow sort
        $this->Fields['reset_password_email_ip'] = &$this->reset_password_email_ip;

        // resetTimestamp
        $this->resetTimestamp = new DbField(
            'buyer',
            'buyer',
            'x_resetTimestamp',
            'resetTimestamp',
            '`resetTimestamp`',
            '`resetTimestamp`',
            201,
            65535,
            -1,
            false,
            '`resetTimestamp`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->resetTimestamp->InputTextType = "text";
        $this->resetTimestamp->Nullable = false; // NOT NULL field
        $this->resetTimestamp->Required = true; // Required field
        $this->Fields['resetTimestamp'] = &$this->resetTimestamp;

        // resetKeyTimestamp
        $this->resetKeyTimestamp = new DbField(
            'buyer',
            'buyer',
            'x_resetKeyTimestamp',
            'resetKeyTimestamp',
            '`resetKeyTimestamp`',
            '`resetKeyTimestamp`',
            201,
            65535,
            -1,
            false,
            '`resetKeyTimestamp`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->resetKeyTimestamp->InputTextType = "text";
        $this->resetKeyTimestamp->Nullable = false; // NOT NULL field
        $this->resetKeyTimestamp->Required = true; // Required field
        $this->Fields['resetKeyTimestamp'] = &$this->resetKeyTimestamp;

        // reset_password_code
        $this->reset_password_code = new DbField(
            'buyer',
            'buyer',
            'x_reset_password_code',
            'reset_password_code',
            '`reset_password_code`',
            '`reset_password_code`',
            201,
            65535,
            -1,
            false,
            '`reset_password_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->reset_password_code->InputTextType = "text";
        $this->reset_password_code->Nullable = false; // NOT NULL field
        $this->reset_password_code->Required = true; // Required field
        $this->Fields['reset_password_code'] = &$this->reset_password_code;

        // code_phone
        $this->code_phone = new DbField(
            'buyer',
            'buyer',
            'x_code_phone',
            'code_phone',
            '`code_phone`',
            '`code_phone`',
            200,
            50,
            -1,
            false,
            '`code_phone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->code_phone->InputTextType = "text";
        $this->code_phone->Nullable = false; // NOT NULL field
        $this->code_phone->Required = true; // Required field
        $this->code_phone->Sortable = false; // Allow sort
        $this->Fields['code_phone'] = &$this->code_phone;

        // image_profile
        $this->image_profile = new DbField(
            'buyer',
            'buyer',
            'x_image_profile',
            'image_profile',
            '`image_profile`',
            '`image_profile`',
            200,
            255,
            -1,
            true,
            '`image_profile`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->image_profile->InputTextType = "text";
        $this->image_profile->Nullable = false; // NOT NULL field
        $this->image_profile->Required = true; // Required field
        $this->image_profile->UploadPath = "./upload/image_profile";
        $this->Fields['image_profile'] = &$this->image_profile;

        // customer_id
        $this->customer_id = new DbField(
            'buyer',
            'buyer',
            'x_customer_id',
            'customer_id',
            '`customer_id`',
            '`customer_id`',
            200,
            255,
            -1,
            false,
            '`customer_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->customer_id->InputTextType = "text";
        $this->customer_id->Nullable = false; // NOT NULL field
        $this->customer_id->Required = true; // Required field
        $this->Fields['customer_id'] = &$this->customer_id;

        // verify_key
        $this->verify_key = new DbField(
            'buyer',
            'buyer',
            'x_verify_key',
            'verify_key',
            '`verify_key`',
            '`verify_key`',
            200,
            255,
            -1,
            false,
            '`verify_key`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_key->InputTextType = "text";
        $this->Fields['verify_key'] = &$this->verify_key;

        // verify_status
        $this->verify_status = new DbField(
            'buyer',
            'buyer',
            'x_verify_status',
            'verify_status',
            '`verify_status`',
            '`verify_status`',
            3,
            11,
            -1,
            false,
            '`verify_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_status->InputTextType = "text";
        $this->verify_status->Nullable = false; // NOT NULL field
        $this->verify_status->Required = true; // Required field
        $this->verify_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['verify_status'] = &$this->verify_status;

        // verify_date
        $this->verify_date = new DbField(
            'buyer',
            'buyer',
            'x_verify_date',
            'verify_date',
            '`verify_date`',
            CastDateFieldForLike("`verify_date`", 0, "juzmatch1"),
            135,
            19,
            0,
            false,
            '`verify_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_date->InputTextType = "text";
        $this->verify_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['verify_date'] = &$this->verify_date;

        // verify_ip
        $this->verify_ip = new DbField(
            'buyer',
            'buyer',
            'x_verify_ip',
            'verify_ip',
            '`verify_ip`',
            '`verify_ip`',
            200,
            50,
            -1,
            false,
            '`verify_ip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_ip->InputTextType = "text";
        $this->Fields['verify_ip'] = &$this->verify_ip;

        // pipedrive_people_id
        $this->pipedrive_people_id = new DbField(
            'buyer',
            'buyer',
            'x_pipedrive_people_id',
            'pipedrive_people_id',
            '`pipedrive_people_id`',
            '`pipedrive_people_id`',
            3,
            11,
            -1,
            false,
            '`pipedrive_people_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->pipedrive_people_id->InputTextType = "text";
        $this->pipedrive_people_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['pipedrive_people_id'] = &$this->pipedrive_people_id;

        // cdate
        $this->cdate = new DbField(
            'buyer',
            'buyer',
            'x_cdate',
            'cdate',
            '`cdate`',
            CastDateFieldForLike("`cdate`", 117, "juzmatch1"),
            135,
            19,
            117,
            false,
            '`cdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cdate->InputTextType = "text";
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(117), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cip
        $this->cip = new DbField(
            'buyer',
            'buyer',
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
        $this->cip->Sortable = false; // Allow sort
        $this->Fields['cip'] = &$this->cip;

        // cuser
        $this->cuser = new DbField(
            'buyer',
            'buyer',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            200,
            255,
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
        $this->cuser->Sortable = false; // Allow sort
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // udate
        $this->udate = new DbField(
            'buyer',
            'buyer',
            'x_udate',
            'udate',
            '`udate`',
            CastDateFieldForLike("`udate`", 0, "juzmatch1"),
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
        $this->udate->Sortable = false; // Allow sort
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uip
        $this->uip = new DbField(
            'buyer',
            'buyer',
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
        $this->uip->Sortable = false; // Allow sort
        $this->Fields['uip'] = &$this->uip;

        // uuser
        $this->uuser = new DbField(
            'buyer',
            'buyer',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            200,
            255,
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
        $this->uuser->Sortable = false; // Allow sort
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // verify_phone_status
        $this->verify_phone_status = new DbField(
            'buyer',
            'buyer',
            'x_verify_phone_status',
            'verify_phone_status',
            '`verify_phone_status`',
            '`verify_phone_status`',
            3,
            11,
            -1,
            false,
            '`verify_phone_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_phone_status->InputTextType = "text";
        $this->verify_phone_status->Nullable = false; // NOT NULL field
        $this->verify_phone_status->Sortable = false; // Allow sort
        $this->verify_phone_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['verify_phone_status'] = &$this->verify_phone_status;

        // verify_phone_date
        $this->verify_phone_date = new DbField(
            'buyer',
            'buyer',
            'x_verify_phone_date',
            'verify_phone_date',
            '`verify_phone_date`',
            CastDateFieldForLike("`verify_phone_date`", 0, "juzmatch1"),
            135,
            19,
            0,
            false,
            '`verify_phone_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_phone_date->InputTextType = "text";
        $this->verify_phone_date->Sortable = false; // Allow sort
        $this->verify_phone_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['verify_phone_date'] = &$this->verify_phone_date;

        // verify_phone_ip
        $this->verify_phone_ip = new DbField(
            'buyer',
            'buyer',
            'x_verify_phone_ip',
            'verify_phone_ip',
            '`verify_phone_ip`',
            '`verify_phone_ip`',
            200,
            100,
            -1,
            false,
            '`verify_phone_ip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->verify_phone_ip->InputTextType = "text";
        $this->verify_phone_ip->Sortable = false; // Allow sort
        $this->Fields['verify_phone_ip'] = &$this->verify_phone_ip;

        // is_peak_contact
        $this->is_peak_contact = new DbField(
            'buyer',
            'buyer',
            'x_is_peak_contact',
            'is_peak_contact',
            '`is_peak_contact`',
            '`is_peak_contact`',
            3,
            11,
            -1,
            false,
            '`is_peak_contact`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->is_peak_contact->InputTextType = "text";
        $this->is_peak_contact->Nullable = false; // NOT NULL field
        $this->is_peak_contact->Sortable = false; // Allow sort
        $this->is_peak_contact->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['is_peak_contact'] = &$this->is_peak_contact;

        // last_change_password
        $this->last_change_password = new DbField(
            'buyer',
            'buyer',
            'x_last_change_password',
            'last_change_password',
            '`last_change_password`',
            CastDateFieldForLike("`last_change_password`", 0, "juzmatch1"),
            135,
            19,
            0,
            false,
            '`last_change_password`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->last_change_password->InputTextType = "text";
        $this->last_change_password->Sortable = false; // Allow sort
        $this->last_change_password->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['last_change_password'] = &$this->last_change_password;

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
        if ($this->getCurrentDetailTable() == "buyer_verify") {
            $detailUrl = Container("buyer_verify")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "save_search") {
            $detailUrl = Container("save_search")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "juzcalculator") {
            $detailUrl = Container("juzcalculator")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "appointment") {
            $detailUrl = Container("appointment")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "buyer_booking_asset") {
            $detailUrl = Container("buyer_booking_asset")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "buyer_asset") {
            $detailUrl = Container("buyer_asset")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "buyerlist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`member`";
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
        $this->DefaultFilter = "`isbuyer`=1";
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
            $this->member_id->setDbValue($conn->lastInsertId());
            $rs['member_id'] = $this->member_id->DbValue;
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
        // Cascade Update detail table 'buyer_verify'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("buyer_verify")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'buyer_verify_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("buyer_verify")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("buyer_verify")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("buyer_verify")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'save_search'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("save_search")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'save_search_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("save_search")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("save_search")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("save_search")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'juzcalculator'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("juzcalculator")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'juzcalculator_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("juzcalculator")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("juzcalculator")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("juzcalculator")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'appointment'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("appointment")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'appointment_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("appointment")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("appointment")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("appointment")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'buyer_booking_asset'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("buyer_booking_asset")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'buyer_booking_asset_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("buyer_booking_asset")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("buyer_booking_asset")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("buyer_booking_asset")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'buyer_asset'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("buyer_asset")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'juzmatch1'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'buyer_booking_asset_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("buyer_asset")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("buyer_asset")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("buyer_asset")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
            if (array_key_exists('member_id', $rs)) {
                AddFilter($where, QuotedName('member_id', $this->Dbid) . '=' . QuotedValue($rs['member_id'], $this->member_id->DataType, $this->Dbid));
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

        // Cascade delete detail table 'buyer_verify'
        $dtlrows = Container("buyer_verify")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("buyer_verify")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("buyer_verify")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("buyer_verify")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'save_search'
        $dtlrows = Container("save_search")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("save_search")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("save_search")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("save_search")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'juzcalculator'
        $dtlrows = Container("juzcalculator")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("juzcalculator")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("juzcalculator")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("juzcalculator")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'appointment'
        $dtlrows = Container("appointment")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("appointment")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("appointment")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("appointment")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'buyer_booking_asset'
        $dtlrows = Container("buyer_booking_asset")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("buyer_booking_asset")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("buyer_booking_asset")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("buyer_booking_asset")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'buyer_asset'
        $dtlrows = Container("buyer_asset")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "juzmatch1"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("buyer_asset")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("buyer_asset")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("buyer_asset")->rowDeleted($dtlrow);
            }
        }
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
        $this->member_id->DbValue = $row['member_id'];
        $this->first_name->DbValue = $row['first_name'];
        $this->last_name->DbValue = $row['last_name'];
        $this->idcardnumber->DbValue = $row['idcardnumber'];
        $this->_email->DbValue = $row['email'];
        $this->phone->DbValue = $row['phone'];
        $this->facebook_id->DbValue = $row['facebook_id'];
        $this->line_id->DbValue = $row['line_id'];
        $this->google_id->DbValue = $row['google_id'];
        $this->last_login->DbValue = $row['last_login'];
        $this->_password->DbValue = $row['password'];
        $this->type->DbValue = $row['type'];
        $this->isactive->DbValue = $row['isactive'];
        $this->isbuyer->DbValue = $row['isbuyer'];
        $this->isinvertor->DbValue = $row['isinvertor'];
        $this->issale->DbValue = $row['issale'];
        $this->isnotification->DbValue = $row['isnotification'];
        $this->reset_password_date->DbValue = $row['reset_password_date'];
        $this->reset_password_ip->DbValue = $row['reset_password_ip'];
        $this->reset_password_email_code->DbValue = $row['reset_password_email_code'];
        $this->reset_password_email_date->DbValue = $row['reset_password_email_date'];
        $this->reset_password_email_ip->DbValue = $row['reset_password_email_ip'];
        $this->resetTimestamp->DbValue = $row['resetTimestamp'];
        $this->resetKeyTimestamp->DbValue = $row['resetKeyTimestamp'];
        $this->reset_password_code->DbValue = $row['reset_password_code'];
        $this->code_phone->DbValue = $row['code_phone'];
        $this->image_profile->Upload->DbValue = $row['image_profile'];
        $this->customer_id->DbValue = $row['customer_id'];
        $this->verify_key->DbValue = $row['verify_key'];
        $this->verify_status->DbValue = $row['verify_status'];
        $this->verify_date->DbValue = $row['verify_date'];
        $this->verify_ip->DbValue = $row['verify_ip'];
        $this->pipedrive_people_id->DbValue = $row['pipedrive_people_id'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cip->DbValue = $row['cip'];
        $this->cuser->DbValue = $row['cuser'];
        $this->udate->DbValue = $row['udate'];
        $this->uip->DbValue = $row['uip'];
        $this->uuser->DbValue = $row['uuser'];
        $this->verify_phone_status->DbValue = $row['verify_phone_status'];
        $this->verify_phone_date->DbValue = $row['verify_phone_date'];
        $this->verify_phone_ip->DbValue = $row['verify_phone_ip'];
        $this->is_peak_contact->DbValue = $row['is_peak_contact'];
        $this->last_change_password->DbValue = $row['last_change_password'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->image_profile->OldUploadPath = "./upload/image_profile";
        $oldFiles = EmptyValue($row['image_profile']) ? [] : [$row['image_profile']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->image_profile->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->image_profile->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`member_id` = @member_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->member_id->CurrentValue : $this->member_id->OldValue;
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
                $this->member_id->CurrentValue = $keys[0];
            } else {
                $this->member_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('member_id', $row) ? $row['member_id'] : null;
        } else {
            $val = $this->member_id->OldValue !== null ? $this->member_id->OldValue : $this->member_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@member_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("buyerlist");
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
        if ($pageName == "buyerview") {
            return $Language->phrase("View");
        } elseif ($pageName == "buyeredit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "buyeradd") {
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
                return "BuyerView";
            case Config("API_ADD_ACTION"):
                return "BuyerAdd";
            case Config("API_EDIT_ACTION"):
                return "BuyerEdit";
            case Config("API_DELETE_ACTION"):
                return "BuyerDelete";
            case Config("API_LIST_ACTION"):
                return "BuyerList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "buyerlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("buyerview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyerview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "buyeradd?" . $this->getUrlParm($parm);
        } else {
            $url = "buyeradd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("buyeredit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyeredit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("buyeradd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyeradd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("buyerdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"member_id\":" . JsonEncode($this->member_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->member_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->member_id->CurrentValue);
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
            if (($keyValue = Param("member_id") ?? Route("member_id")) !== null) {
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
                $this->member_id->CurrentValue = $key;
            } else {
                $this->member_id->OldValue = $key;
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
        $this->member_id->setDbValue($row['member_id']);
        $this->first_name->setDbValue($row['first_name']);
        $this->last_name->setDbValue($row['last_name']);
        $this->idcardnumber->setDbValue($row['idcardnumber']);
        $this->_email->setDbValue($row['email']);
        $this->phone->setDbValue($row['phone']);
        $this->facebook_id->setDbValue($row['facebook_id']);
        $this->line_id->setDbValue($row['line_id']);
        $this->google_id->setDbValue($row['google_id']);
        $this->last_login->setDbValue($row['last_login']);
        $this->_password->setDbValue($row['password']);
        $this->type->setDbValue($row['type']);
        $this->isactive->setDbValue($row['isactive']);
        $this->isbuyer->setDbValue($row['isbuyer']);
        $this->isinvertor->setDbValue($row['isinvertor']);
        $this->issale->setDbValue($row['issale']);
        $this->isnotification->setDbValue($row['isnotification']);
        $this->reset_password_date->setDbValue($row['reset_password_date']);
        $this->reset_password_ip->setDbValue($row['reset_password_ip']);
        $this->reset_password_email_code->setDbValue($row['reset_password_email_code']);
        $this->reset_password_email_date->setDbValue($row['reset_password_email_date']);
        $this->reset_password_email_ip->setDbValue($row['reset_password_email_ip']);
        $this->resetTimestamp->setDbValue($row['resetTimestamp']);
        $this->resetKeyTimestamp->setDbValue($row['resetKeyTimestamp']);
        $this->reset_password_code->setDbValue($row['reset_password_code']);
        $this->code_phone->setDbValue($row['code_phone']);
        $this->image_profile->Upload->DbValue = $row['image_profile'];
        $this->customer_id->setDbValue($row['customer_id']);
        $this->verify_key->setDbValue($row['verify_key']);
        $this->verify_status->setDbValue($row['verify_status']);
        $this->verify_date->setDbValue($row['verify_date']);
        $this->verify_ip->setDbValue($row['verify_ip']);
        $this->pipedrive_people_id->setDbValue($row['pipedrive_people_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->cuser->setDbValue($row['cuser']);
        $this->udate->setDbValue($row['udate']);
        $this->uip->setDbValue($row['uip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->verify_phone_status->setDbValue($row['verify_phone_status']);
        $this->verify_phone_date->setDbValue($row['verify_phone_date']);
        $this->verify_phone_ip->setDbValue($row['verify_phone_ip']);
        $this->is_peak_contact->setDbValue($row['is_peak_contact']);
        $this->last_change_password->setDbValue($row['last_change_password']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // member_id
        $this->member_id->CellCssStyle = "white-space: nowrap;";

        // first_name

        // last_name

        // idcardnumber

        // email

        // phone

        // facebook_id

        // line_id

        // google_id

        // last_login
        $this->last_login->CellCssStyle = "white-space: nowrap;";

        // password

        // type

        // isactive

        // isbuyer

        // isinvertor

        // issale

        // isnotification
        $this->isnotification->CellCssStyle = "white-space: nowrap;";

        // reset_password_date

        // reset_password_ip

        // reset_password_email_code

        // reset_password_email_date

        // reset_password_email_ip

        // resetTimestamp

        // resetKeyTimestamp

        // reset_password_code

        // code_phone
        $this->code_phone->CellCssStyle = "white-space: nowrap;";

        // image_profile

        // customer_id

        // verify_key

        // verify_status

        // verify_date

        // verify_ip

        // pipedrive_people_id

        // cdate

        // cip

        // cuser

        // udate

        // uip

        // uuser

        // verify_phone_status

        // verify_phone_date

        // verify_phone_ip

        // is_peak_contact
        $this->is_peak_contact->CellCssStyle = "white-space: nowrap;";

        // last_change_password
        $this->last_change_password->CellCssStyle = "white-space: nowrap;";

        // member_id
        $this->member_id->ViewValue = $this->member_id->CurrentValue;
        $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
        $this->member_id->ViewCustomAttributes = "";

        // first_name
        $this->first_name->ViewValue = $this->first_name->CurrentValue;
        $this->first_name->ViewCustomAttributes = "";

        // last_name
        $this->last_name->ViewValue = $this->last_name->CurrentValue;
        $this->last_name->ViewCustomAttributes = "";

        // idcardnumber
        $this->idcardnumber->ViewValue = $this->idcardnumber->CurrentValue;
        $this->idcardnumber->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // phone
        $this->phone->ViewValue = $this->phone->CurrentValue;
        $this->phone->ViewCustomAttributes = "";

        // facebook_id
        $this->facebook_id->ViewValue = $this->facebook_id->CurrentValue;
        $this->facebook_id->ViewCustomAttributes = "";

        // line_id
        $this->line_id->ViewValue = $this->line_id->CurrentValue;
        $this->line_id->ViewCustomAttributes = "";

        // google_id
        $this->google_id->ViewValue = $this->google_id->CurrentValue;
        $this->google_id->ViewCustomAttributes = "";

        // last_login
        $this->last_login->ViewValue = $this->last_login->CurrentValue;
        $this->last_login->ViewValue = FormatDateTime($this->last_login->ViewValue, $this->last_login->formatPattern());
        $this->last_login->ViewCustomAttributes = "";

        // password
        $this->_password->ViewValue = $Language->phrase("PasswordMask");
        $this->_password->ViewCustomAttributes = "";

        // type
        if (strval($this->type->CurrentValue) != "") {
            $this->type->ViewValue = $this->type->optionCaption($this->type->CurrentValue);
        } else {
            $this->type->ViewValue = null;
        }
        $this->type->ViewCustomAttributes = "";

        // isactive
        if (strval($this->isactive->CurrentValue) != "") {
            $this->isactive->ViewValue = $this->isactive->optionCaption($this->isactive->CurrentValue);
        } else {
            $this->isactive->ViewValue = null;
        }
        $this->isactive->ViewCustomAttributes = "";

        // isbuyer
        if (strval($this->isbuyer->CurrentValue) != "") {
            $this->isbuyer->ViewValue = $this->isbuyer->optionCaption($this->isbuyer->CurrentValue);
        } else {
            $this->isbuyer->ViewValue = null;
        }
        $this->isbuyer->ViewCustomAttributes = "";

        // isinvertor
        if (strval($this->isinvertor->CurrentValue) != "") {
            $this->isinvertor->ViewValue = $this->isinvertor->optionCaption($this->isinvertor->CurrentValue);
        } else {
            $this->isinvertor->ViewValue = null;
        }
        $this->isinvertor->ViewCustomAttributes = "";

        // issale
        if (strval($this->issale->CurrentValue) != "") {
            $this->issale->ViewValue = $this->issale->optionCaption($this->issale->CurrentValue);
        } else {
            $this->issale->ViewValue = null;
        }
        $this->issale->ViewCustomAttributes = "";

        // isnotification
        $this->isnotification->ViewValue = $this->isnotification->CurrentValue;
        $this->isnotification->ViewValue = FormatNumber($this->isnotification->ViewValue, $this->isnotification->formatPattern());
        $this->isnotification->ViewCustomAttributes = "";

        // reset_password_date
        $this->reset_password_date->ViewValue = $this->reset_password_date->CurrentValue;
        $this->reset_password_date->ViewValue = FormatDateTime($this->reset_password_date->ViewValue, $this->reset_password_date->formatPattern());
        $this->reset_password_date->ViewCustomAttributes = "";

        // reset_password_ip
        $this->reset_password_ip->ViewValue = $this->reset_password_ip->CurrentValue;
        $this->reset_password_ip->ViewCustomAttributes = "";

        // reset_password_email_code
        $this->reset_password_email_code->ViewValue = $this->reset_password_email_code->CurrentValue;
        $this->reset_password_email_code->ViewCustomAttributes = "";

        // reset_password_email_date
        $this->reset_password_email_date->ViewValue = $this->reset_password_email_date->CurrentValue;
        $this->reset_password_email_date->ViewValue = FormatDateTime($this->reset_password_email_date->ViewValue, $this->reset_password_email_date->formatPattern());
        $this->reset_password_email_date->ViewCustomAttributes = "";

        // reset_password_email_ip
        $this->reset_password_email_ip->ViewValue = $this->reset_password_email_ip->CurrentValue;
        $this->reset_password_email_ip->ViewCustomAttributes = "";

        // resetTimestamp
        $this->resetTimestamp->ViewValue = $this->resetTimestamp->CurrentValue;
        $this->resetTimestamp->ViewCustomAttributes = "";

        // resetKeyTimestamp
        $this->resetKeyTimestamp->ViewValue = $this->resetKeyTimestamp->CurrentValue;
        $this->resetKeyTimestamp->ViewCustomAttributes = "";

        // reset_password_code
        $this->reset_password_code->ViewValue = $this->reset_password_code->CurrentValue;
        $this->reset_password_code->ViewCustomAttributes = "";

        // code_phone
        $this->code_phone->ViewValue = $this->code_phone->CurrentValue;
        $this->code_phone->ViewCustomAttributes = "";

        // image_profile
        $this->image_profile->UploadPath = "./upload/image_profile";
        if (!EmptyValue($this->image_profile->Upload->DbValue)) {
            $this->image_profile->ImageWidth = 100;
            $this->image_profile->ImageHeight = 0;
            $this->image_profile->ImageAlt = $this->image_profile->alt();
            $this->image_profile->ImageCssClass = "ew-image";
            $this->image_profile->ViewValue = $this->image_profile->Upload->DbValue;
        } else {
            $this->image_profile->ViewValue = "";
        }
        $this->image_profile->ViewCustomAttributes = "";

        // customer_id
        $this->customer_id->ViewValue = $this->customer_id->CurrentValue;
        $this->customer_id->ViewCustomAttributes = "";

        // verify_key
        $this->verify_key->ViewValue = $this->verify_key->CurrentValue;
        $this->verify_key->ViewCustomAttributes = "";

        // verify_status
        $this->verify_status->ViewValue = $this->verify_status->CurrentValue;
        $this->verify_status->ViewValue = FormatNumber($this->verify_status->ViewValue, $this->verify_status->formatPattern());
        $this->verify_status->ViewCustomAttributes = "";

        // verify_date
        $this->verify_date->ViewValue = $this->verify_date->CurrentValue;
        $this->verify_date->ViewValue = FormatDateTime($this->verify_date->ViewValue, $this->verify_date->formatPattern());
        $this->verify_date->ViewCustomAttributes = "";

        // verify_ip
        $this->verify_ip->ViewValue = $this->verify_ip->CurrentValue;
        $this->verify_ip->ViewCustomAttributes = "";

        // pipedrive_people_id
        $this->pipedrive_people_id->ViewValue = $this->pipedrive_people_id->CurrentValue;
        $this->pipedrive_people_id->ViewValue = FormatNumber($this->pipedrive_people_id->ViewValue, $this->pipedrive_people_id->formatPattern());
        $this->pipedrive_people_id->ViewCustomAttributes = "";

        // cdate
        $this->cdate->ViewValue = $this->cdate->CurrentValue;
        $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
        $this->cdate->ViewCustomAttributes = "";

        // cip
        $this->cip->ViewValue = $this->cip->CurrentValue;
        $this->cip->ViewCustomAttributes = "";

        // cuser
        $this->cuser->ViewValue = $this->cuser->CurrentValue;
        $this->cuser->ViewCustomAttributes = "";

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewCustomAttributes = "";

        // verify_phone_status
        $this->verify_phone_status->ViewValue = $this->verify_phone_status->CurrentValue;
        $this->verify_phone_status->ViewValue = FormatNumber($this->verify_phone_status->ViewValue, $this->verify_phone_status->formatPattern());
        $this->verify_phone_status->ViewCustomAttributes = "";

        // verify_phone_date
        $this->verify_phone_date->ViewValue = $this->verify_phone_date->CurrentValue;
        $this->verify_phone_date->ViewValue = FormatDateTime($this->verify_phone_date->ViewValue, $this->verify_phone_date->formatPattern());
        $this->verify_phone_date->ViewCustomAttributes = "";

        // verify_phone_ip
        $this->verify_phone_ip->ViewValue = $this->verify_phone_ip->CurrentValue;
        $this->verify_phone_ip->ViewCustomAttributes = "";

        // is_peak_contact
        $this->is_peak_contact->ViewValue = $this->is_peak_contact->CurrentValue;
        $this->is_peak_contact->ViewValue = FormatNumber($this->is_peak_contact->ViewValue, $this->is_peak_contact->formatPattern());
        $this->is_peak_contact->ViewCustomAttributes = "";

        // last_change_password
        $this->last_change_password->ViewValue = $this->last_change_password->CurrentValue;
        $this->last_change_password->ViewValue = FormatDateTime($this->last_change_password->ViewValue, $this->last_change_password->formatPattern());
        $this->last_change_password->ViewCustomAttributes = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // first_name
        $this->first_name->LinkCustomAttributes = "";
        $this->first_name->HrefValue = "";
        $this->first_name->TooltipValue = "";

        // last_name
        $this->last_name->LinkCustomAttributes = "";
        $this->last_name->HrefValue = "";
        $this->last_name->TooltipValue = "";

        // idcardnumber
        $this->idcardnumber->LinkCustomAttributes = "";
        $this->idcardnumber->HrefValue = "";
        $this->idcardnumber->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // phone
        $this->phone->LinkCustomAttributes = "";
        $this->phone->HrefValue = "";
        $this->phone->TooltipValue = "";

        // facebook_id
        $this->facebook_id->LinkCustomAttributes = "";
        $this->facebook_id->HrefValue = "";
        $this->facebook_id->TooltipValue = "";

        // line_id
        $this->line_id->LinkCustomAttributes = "";
        $this->line_id->HrefValue = "";
        $this->line_id->TooltipValue = "";

        // google_id
        $this->google_id->LinkCustomAttributes = "";
        $this->google_id->HrefValue = "";
        $this->google_id->TooltipValue = "";

        // last_login
        $this->last_login->LinkCustomAttributes = "";
        $this->last_login->HrefValue = "";
        $this->last_login->TooltipValue = "";

        // password
        $this->_password->LinkCustomAttributes = "";
        $this->_password->HrefValue = "";
        $this->_password->TooltipValue = "";

        // type
        $this->type->LinkCustomAttributes = "";
        $this->type->HrefValue = "";
        $this->type->TooltipValue = "";

        // isactive
        $this->isactive->LinkCustomAttributes = "";
        $this->isactive->HrefValue = "";
        $this->isactive->TooltipValue = "";

        // isbuyer
        $this->isbuyer->LinkCustomAttributes = "";
        $this->isbuyer->HrefValue = "";
        $this->isbuyer->TooltipValue = "";

        // isinvertor
        $this->isinvertor->LinkCustomAttributes = "";
        $this->isinvertor->HrefValue = "";
        $this->isinvertor->TooltipValue = "";

        // issale
        $this->issale->LinkCustomAttributes = "";
        $this->issale->HrefValue = "";
        $this->issale->TooltipValue = "";

        // isnotification
        $this->isnotification->LinkCustomAttributes = "";
        $this->isnotification->HrefValue = "";
        $this->isnotification->TooltipValue = "";

        // reset_password_date
        $this->reset_password_date->LinkCustomAttributes = "";
        $this->reset_password_date->HrefValue = "";
        $this->reset_password_date->TooltipValue = "";

        // reset_password_ip
        $this->reset_password_ip->LinkCustomAttributes = "";
        $this->reset_password_ip->HrefValue = "";
        $this->reset_password_ip->TooltipValue = "";

        // reset_password_email_code
        $this->reset_password_email_code->LinkCustomAttributes = "";
        $this->reset_password_email_code->HrefValue = "";
        $this->reset_password_email_code->TooltipValue = "";

        // reset_password_email_date
        $this->reset_password_email_date->LinkCustomAttributes = "";
        $this->reset_password_email_date->HrefValue = "";
        $this->reset_password_email_date->TooltipValue = "";

        // reset_password_email_ip
        $this->reset_password_email_ip->LinkCustomAttributes = "";
        $this->reset_password_email_ip->HrefValue = "";
        $this->reset_password_email_ip->TooltipValue = "";

        // resetTimestamp
        $this->resetTimestamp->LinkCustomAttributes = "";
        $this->resetTimestamp->HrefValue = "";
        $this->resetTimestamp->TooltipValue = "";

        // resetKeyTimestamp
        $this->resetKeyTimestamp->LinkCustomAttributes = "";
        $this->resetKeyTimestamp->HrefValue = "";
        $this->resetKeyTimestamp->TooltipValue = "";

        // reset_password_code
        $this->reset_password_code->LinkCustomAttributes = "";
        $this->reset_password_code->HrefValue = "";
        $this->reset_password_code->TooltipValue = "";

        // code_phone
        $this->code_phone->LinkCustomAttributes = "";
        $this->code_phone->HrefValue = "";
        $this->code_phone->TooltipValue = "";

        // image_profile
        $this->image_profile->LinkCustomAttributes = "";
        $this->image_profile->UploadPath = "./upload/image_profile";
        if (!EmptyValue($this->image_profile->Upload->DbValue)) {
            $this->image_profile->HrefValue = GetFileUploadUrl($this->image_profile, $this->image_profile->htmlDecode($this->image_profile->Upload->DbValue)); // Add prefix/suffix
            $this->image_profile->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->image_profile->HrefValue = FullUrl($this->image_profile->HrefValue, "href");
            }
        } else {
            $this->image_profile->HrefValue = "";
        }
        $this->image_profile->ExportHrefValue = $this->image_profile->UploadPath . $this->image_profile->Upload->DbValue;
        $this->image_profile->TooltipValue = "";
        if ($this->image_profile->UseColorbox) {
            if (EmptyValue($this->image_profile->TooltipValue)) {
                $this->image_profile->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->image_profile->LinkAttrs["data-rel"] = "buyer_x_image_profile";
            $this->image_profile->LinkAttrs->appendClass("ew-lightbox");
        }

        // customer_id
        $this->customer_id->LinkCustomAttributes = "";
        $this->customer_id->HrefValue = "";
        $this->customer_id->TooltipValue = "";

        // verify_key
        $this->verify_key->LinkCustomAttributes = "";
        $this->verify_key->HrefValue = "";
        $this->verify_key->TooltipValue = "";

        // verify_status
        $this->verify_status->LinkCustomAttributes = "";
        $this->verify_status->HrefValue = "";
        $this->verify_status->TooltipValue = "";

        // verify_date
        $this->verify_date->LinkCustomAttributes = "";
        $this->verify_date->HrefValue = "";
        $this->verify_date->TooltipValue = "";

        // verify_ip
        $this->verify_ip->LinkCustomAttributes = "";
        $this->verify_ip->HrefValue = "";
        $this->verify_ip->TooltipValue = "";

        // pipedrive_people_id
        $this->pipedrive_people_id->LinkCustomAttributes = "";
        $this->pipedrive_people_id->HrefValue = "";
        $this->pipedrive_people_id->TooltipValue = "";

        // cdate
        $this->cdate->LinkCustomAttributes = "";
        $this->cdate->HrefValue = "";
        $this->cdate->TooltipValue = "";

        // cip
        $this->cip->LinkCustomAttributes = "";
        $this->cip->HrefValue = "";
        $this->cip->TooltipValue = "";

        // cuser
        $this->cuser->LinkCustomAttributes = "";
        $this->cuser->HrefValue = "";
        $this->cuser->TooltipValue = "";

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

        // verify_phone_status
        $this->verify_phone_status->LinkCustomAttributes = "";
        $this->verify_phone_status->HrefValue = "";
        $this->verify_phone_status->TooltipValue = "";

        // verify_phone_date
        $this->verify_phone_date->LinkCustomAttributes = "";
        $this->verify_phone_date->HrefValue = "";
        $this->verify_phone_date->TooltipValue = "";

        // verify_phone_ip
        $this->verify_phone_ip->LinkCustomAttributes = "";
        $this->verify_phone_ip->HrefValue = "";
        $this->verify_phone_ip->TooltipValue = "";

        // is_peak_contact
        $this->is_peak_contact->LinkCustomAttributes = "";
        $this->is_peak_contact->HrefValue = "";
        $this->is_peak_contact->TooltipValue = "";

        // last_change_password
        $this->last_change_password->LinkCustomAttributes = "";
        $this->last_change_password->HrefValue = "";
        $this->last_change_password->TooltipValue = "";

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

        // member_id
        $this->member_id->setupEditAttributes();
        $this->member_id->EditCustomAttributes = "";
        $this->member_id->EditValue = $this->member_id->CurrentValue;
        $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, $this->member_id->formatPattern());
        $this->member_id->ViewCustomAttributes = "";

        // first_name
        $this->first_name->setupEditAttributes();
        $this->first_name->EditCustomAttributes = "";
        if (!$this->first_name->Raw) {
            $this->first_name->CurrentValue = HtmlDecode($this->first_name->CurrentValue);
        }
        $this->first_name->EditValue = $this->first_name->CurrentValue;
        $this->first_name->PlaceHolder = RemoveHtml($this->first_name->caption());

        // last_name
        $this->last_name->setupEditAttributes();
        $this->last_name->EditCustomAttributes = "";
        if (!$this->last_name->Raw) {
            $this->last_name->CurrentValue = HtmlDecode($this->last_name->CurrentValue);
        }
        $this->last_name->EditValue = $this->last_name->CurrentValue;
        $this->last_name->PlaceHolder = RemoveHtml($this->last_name->caption());

        // idcardnumber
        $this->idcardnumber->setupEditAttributes();
        $this->idcardnumber->EditCustomAttributes = "";
        if (!$this->idcardnumber->Raw) {
            $this->idcardnumber->CurrentValue = HtmlDecode($this->idcardnumber->CurrentValue);
        }
        $this->idcardnumber->EditValue = $this->idcardnumber->CurrentValue;
        $this->idcardnumber->PlaceHolder = RemoveHtml($this->idcardnumber->caption());

        // email
        $this->_email->setupEditAttributes();
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // phone
        $this->phone->setupEditAttributes();
        $this->phone->EditCustomAttributes = "";
        if (!$this->phone->Raw) {
            $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
        }
        $this->phone->EditValue = $this->phone->CurrentValue;
        $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

        // facebook_id
        $this->facebook_id->setupEditAttributes();
        $this->facebook_id->EditCustomAttributes = "";
        if (!$this->facebook_id->Raw) {
            $this->facebook_id->CurrentValue = HtmlDecode($this->facebook_id->CurrentValue);
        }
        $this->facebook_id->EditValue = $this->facebook_id->CurrentValue;
        $this->facebook_id->PlaceHolder = RemoveHtml($this->facebook_id->caption());

        // line_id
        $this->line_id->setupEditAttributes();
        $this->line_id->EditCustomAttributes = "";
        if (!$this->line_id->Raw) {
            $this->line_id->CurrentValue = HtmlDecode($this->line_id->CurrentValue);
        }
        $this->line_id->EditValue = $this->line_id->CurrentValue;
        $this->line_id->PlaceHolder = RemoveHtml($this->line_id->caption());

        // google_id
        $this->google_id->setupEditAttributes();
        $this->google_id->EditCustomAttributes = "";
        if (!$this->google_id->Raw) {
            $this->google_id->CurrentValue = HtmlDecode($this->google_id->CurrentValue);
        }
        $this->google_id->EditValue = $this->google_id->CurrentValue;
        $this->google_id->PlaceHolder = RemoveHtml($this->google_id->caption());

        // last_login
        $this->last_login->setupEditAttributes();
        $this->last_login->EditCustomAttributes = "";
        $this->last_login->EditValue = FormatDateTime($this->last_login->CurrentValue, $this->last_login->formatPattern());
        $this->last_login->PlaceHolder = RemoveHtml($this->last_login->caption());

        // password
        $this->_password->setupEditAttributes();
        $this->_password->EditCustomAttributes = "";
        $this->_password->EditValue = $Language->phrase("PasswordMask"); // Show as masked password
        $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

        // type
        $this->type->setupEditAttributes();
        $this->type->EditCustomAttributes = "";
        $this->type->EditValue = $this->type->options(true);
        $this->type->PlaceHolder = RemoveHtml($this->type->caption());

        // isactive
        $this->isactive->EditCustomAttributes = "";
        $this->isactive->EditValue = $this->isactive->options(false);
        $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

        // isbuyer
        $this->isbuyer->setupEditAttributes();
        $this->isbuyer->EditCustomAttributes = "";
        if (strval($this->isbuyer->CurrentValue) != "") {
            $this->isbuyer->EditValue = $this->isbuyer->optionCaption($this->isbuyer->CurrentValue);
        } else {
            $this->isbuyer->EditValue = null;
        }
        $this->isbuyer->ViewCustomAttributes = "";

        // isinvertor
        $this->isinvertor->setupEditAttributes();
        $this->isinvertor->EditCustomAttributes = "";
        if (strval($this->isinvertor->CurrentValue) != "") {
            $this->isinvertor->EditValue = $this->isinvertor->optionCaption($this->isinvertor->CurrentValue);
        } else {
            $this->isinvertor->EditValue = null;
        }
        $this->isinvertor->ViewCustomAttributes = "";

        // issale
        $this->issale->setupEditAttributes();
        $this->issale->EditCustomAttributes = "";
        if (strval($this->issale->CurrentValue) != "") {
            $this->issale->EditValue = $this->issale->optionCaption($this->issale->CurrentValue);
        } else {
            $this->issale->EditValue = null;
        }
        $this->issale->ViewCustomAttributes = "";

        // isnotification
        $this->isnotification->setupEditAttributes();
        $this->isnotification->EditCustomAttributes = "";
        $this->isnotification->EditValue = $this->isnotification->CurrentValue;
        $this->isnotification->PlaceHolder = RemoveHtml($this->isnotification->caption());
        if (strval($this->isnotification->EditValue) != "" && is_numeric($this->isnotification->EditValue)) {
            $this->isnotification->EditValue = FormatNumber($this->isnotification->EditValue, null);
        }

        // reset_password_date
        $this->reset_password_date->setupEditAttributes();
        $this->reset_password_date->EditCustomAttributes = "";
        $this->reset_password_date->EditValue = FormatDateTime($this->reset_password_date->CurrentValue, $this->reset_password_date->formatPattern());
        $this->reset_password_date->PlaceHolder = RemoveHtml($this->reset_password_date->caption());

        // reset_password_ip
        $this->reset_password_ip->setupEditAttributes();
        $this->reset_password_ip->EditCustomAttributes = "";
        if (!$this->reset_password_ip->Raw) {
            $this->reset_password_ip->CurrentValue = HtmlDecode($this->reset_password_ip->CurrentValue);
        }
        $this->reset_password_ip->EditValue = $this->reset_password_ip->CurrentValue;
        $this->reset_password_ip->PlaceHolder = RemoveHtml($this->reset_password_ip->caption());

        // reset_password_email_code
        $this->reset_password_email_code->setupEditAttributes();
        $this->reset_password_email_code->EditCustomAttributes = "";
        $this->reset_password_email_code->EditValue = $this->reset_password_email_code->CurrentValue;
        $this->reset_password_email_code->PlaceHolder = RemoveHtml($this->reset_password_email_code->caption());

        // reset_password_email_date
        $this->reset_password_email_date->setupEditAttributes();
        $this->reset_password_email_date->EditCustomAttributes = "";
        $this->reset_password_email_date->EditValue = FormatDateTime($this->reset_password_email_date->CurrentValue, $this->reset_password_email_date->formatPattern());
        $this->reset_password_email_date->PlaceHolder = RemoveHtml($this->reset_password_email_date->caption());

        // reset_password_email_ip
        $this->reset_password_email_ip->setupEditAttributes();
        $this->reset_password_email_ip->EditCustomAttributes = "";
        if (!$this->reset_password_email_ip->Raw) {
            $this->reset_password_email_ip->CurrentValue = HtmlDecode($this->reset_password_email_ip->CurrentValue);
        }
        $this->reset_password_email_ip->EditValue = $this->reset_password_email_ip->CurrentValue;
        $this->reset_password_email_ip->PlaceHolder = RemoveHtml($this->reset_password_email_ip->caption());

        // resetTimestamp
        $this->resetTimestamp->setupEditAttributes();
        $this->resetTimestamp->EditCustomAttributes = "";
        $this->resetTimestamp->EditValue = $this->resetTimestamp->CurrentValue;
        $this->resetTimestamp->PlaceHolder = RemoveHtml($this->resetTimestamp->caption());

        // resetKeyTimestamp
        $this->resetKeyTimestamp->setupEditAttributes();
        $this->resetKeyTimestamp->EditCustomAttributes = "";
        $this->resetKeyTimestamp->EditValue = $this->resetKeyTimestamp->CurrentValue;
        $this->resetKeyTimestamp->PlaceHolder = RemoveHtml($this->resetKeyTimestamp->caption());

        // reset_password_code
        $this->reset_password_code->setupEditAttributes();
        $this->reset_password_code->EditCustomAttributes = "";
        $this->reset_password_code->EditValue = $this->reset_password_code->CurrentValue;
        $this->reset_password_code->PlaceHolder = RemoveHtml($this->reset_password_code->caption());

        // code_phone
        $this->code_phone->setupEditAttributes();
        $this->code_phone->EditCustomAttributes = "";
        if (!$this->code_phone->Raw) {
            $this->code_phone->CurrentValue = HtmlDecode($this->code_phone->CurrentValue);
        }
        $this->code_phone->EditValue = $this->code_phone->CurrentValue;
        $this->code_phone->PlaceHolder = RemoveHtml($this->code_phone->caption());

        // image_profile
        $this->image_profile->setupEditAttributes();
        $this->image_profile->EditCustomAttributes = "";
        $this->image_profile->UploadPath = "./upload/image_profile";
        if (!EmptyValue($this->image_profile->Upload->DbValue)) {
            $this->image_profile->ImageWidth = 100;
            $this->image_profile->ImageHeight = 0;
            $this->image_profile->ImageAlt = $this->image_profile->alt();
            $this->image_profile->ImageCssClass = "ew-image";
            $this->image_profile->EditValue = $this->image_profile->Upload->DbValue;
        } else {
            $this->image_profile->EditValue = "";
        }
        if (!EmptyValue($this->image_profile->CurrentValue)) {
            $this->image_profile->Upload->FileName = $this->image_profile->CurrentValue;
        }

        // customer_id
        $this->customer_id->setupEditAttributes();
        $this->customer_id->EditCustomAttributes = "";
        if (!$this->customer_id->Raw) {
            $this->customer_id->CurrentValue = HtmlDecode($this->customer_id->CurrentValue);
        }
        $this->customer_id->EditValue = $this->customer_id->CurrentValue;
        $this->customer_id->PlaceHolder = RemoveHtml($this->customer_id->caption());

        // verify_key
        $this->verify_key->setupEditAttributes();
        $this->verify_key->EditCustomAttributes = "";
        if (!$this->verify_key->Raw) {
            $this->verify_key->CurrentValue = HtmlDecode($this->verify_key->CurrentValue);
        }
        $this->verify_key->EditValue = $this->verify_key->CurrentValue;
        $this->verify_key->PlaceHolder = RemoveHtml($this->verify_key->caption());

        // verify_status
        $this->verify_status->setupEditAttributes();
        $this->verify_status->EditCustomAttributes = "";
        $this->verify_status->EditValue = $this->verify_status->CurrentValue;
        $this->verify_status->PlaceHolder = RemoveHtml($this->verify_status->caption());
        if (strval($this->verify_status->EditValue) != "" && is_numeric($this->verify_status->EditValue)) {
            $this->verify_status->EditValue = FormatNumber($this->verify_status->EditValue, null);
        }

        // verify_date
        $this->verify_date->setupEditAttributes();
        $this->verify_date->EditCustomAttributes = "";
        $this->verify_date->EditValue = FormatDateTime($this->verify_date->CurrentValue, $this->verify_date->formatPattern());
        $this->verify_date->PlaceHolder = RemoveHtml($this->verify_date->caption());

        // verify_ip
        $this->verify_ip->setupEditAttributes();
        $this->verify_ip->EditCustomAttributes = "";
        if (!$this->verify_ip->Raw) {
            $this->verify_ip->CurrentValue = HtmlDecode($this->verify_ip->CurrentValue);
        }
        $this->verify_ip->EditValue = $this->verify_ip->CurrentValue;
        $this->verify_ip->PlaceHolder = RemoveHtml($this->verify_ip->caption());

        // pipedrive_people_id
        $this->pipedrive_people_id->setupEditAttributes();
        $this->pipedrive_people_id->EditCustomAttributes = "";
        $this->pipedrive_people_id->EditValue = $this->pipedrive_people_id->CurrentValue;
        $this->pipedrive_people_id->PlaceHolder = RemoveHtml($this->pipedrive_people_id->caption());
        if (strval($this->pipedrive_people_id->EditValue) != "" && is_numeric($this->pipedrive_people_id->EditValue)) {
            $this->pipedrive_people_id->EditValue = FormatNumber($this->pipedrive_people_id->EditValue, null);
        }

        // cdate

        // cip

        // cuser

        // udate

        // uip

        // uuser

        // verify_phone_status
        $this->verify_phone_status->setupEditAttributes();
        $this->verify_phone_status->EditCustomAttributes = "";
        $this->verify_phone_status->EditValue = $this->verify_phone_status->CurrentValue;
        $this->verify_phone_status->PlaceHolder = RemoveHtml($this->verify_phone_status->caption());
        if (strval($this->verify_phone_status->EditValue) != "" && is_numeric($this->verify_phone_status->EditValue)) {
            $this->verify_phone_status->EditValue = FormatNumber($this->verify_phone_status->EditValue, null);
        }

        // verify_phone_date
        $this->verify_phone_date->setupEditAttributes();
        $this->verify_phone_date->EditCustomAttributes = "";
        $this->verify_phone_date->EditValue = FormatDateTime($this->verify_phone_date->CurrentValue, $this->verify_phone_date->formatPattern());
        $this->verify_phone_date->PlaceHolder = RemoveHtml($this->verify_phone_date->caption());

        // verify_phone_ip
        $this->verify_phone_ip->setupEditAttributes();
        $this->verify_phone_ip->EditCustomAttributes = "";
        if (!$this->verify_phone_ip->Raw) {
            $this->verify_phone_ip->CurrentValue = HtmlDecode($this->verify_phone_ip->CurrentValue);
        }
        $this->verify_phone_ip->EditValue = $this->verify_phone_ip->CurrentValue;
        $this->verify_phone_ip->PlaceHolder = RemoveHtml($this->verify_phone_ip->caption());

        // is_peak_contact
        $this->is_peak_contact->setupEditAttributes();
        $this->is_peak_contact->EditCustomAttributes = "";
        $this->is_peak_contact->EditValue = $this->is_peak_contact->CurrentValue;
        $this->is_peak_contact->PlaceHolder = RemoveHtml($this->is_peak_contact->caption());
        if (strval($this->is_peak_contact->EditValue) != "" && is_numeric($this->is_peak_contact->EditValue)) {
            $this->is_peak_contact->EditValue = FormatNumber($this->is_peak_contact->EditValue, null);
        }

        // last_change_password
        $this->last_change_password->setupEditAttributes();
        $this->last_change_password->EditCustomAttributes = "";
        $this->last_change_password->EditValue = FormatDateTime($this->last_change_password->CurrentValue, $this->last_change_password->formatPattern());
        $this->last_change_password->PlaceHolder = RemoveHtml($this->last_change_password->caption());

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
                    $doc->exportCaption($this->first_name);
                    $doc->exportCaption($this->last_name);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->phone);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->isactive);
                    $doc->exportCaption($this->image_profile);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->first_name);
                    $doc->exportCaption($this->last_name);
                    $doc->exportCaption($this->idcardnumber);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->phone);
                    $doc->exportCaption($this->last_login);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->isactive);
                    $doc->exportCaption($this->cdate);
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
                        $doc->exportField($this->first_name);
                        $doc->exportField($this->last_name);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->phone);
                        $doc->exportField($this->type);
                        $doc->exportField($this->isactive);
                        $doc->exportField($this->image_profile);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->first_name);
                        $doc->exportField($this->last_name);
                        $doc->exportField($this->idcardnumber);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->phone);
                        $doc->exportField($this->last_login);
                        $doc->exportField($this->type);
                        $doc->exportField($this->isactive);
                        $doc->exportField($this->cdate);
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
        if ($fldparm == 'image_profile') {
            $fldName = "image_profile";
            $fileNameFld = "image_profile";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->member_id->CurrentValue = $ar[0];
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
