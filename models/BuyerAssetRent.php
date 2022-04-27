<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for buyer_asset_rent
 */
class BuyerAssetRent extends DbTable
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
    public $buyer_asset_rent_id;
    public $asset_id;
    public $member_id;
    public $one_time_status;
    public $half_price_1;
    public $status_pay_half_price_1;
    public $pay_number_half_price_1;
    public $date_pay_half_price_1;
    public $due_date_pay_half_price_1;
    public $half_price_2;
    public $status_pay_half_price_2;
    public $pay_number_half_price_2;
    public $date_pay_half_price_2;
    public $due_date_pay_half_price_2;
    public $transaction_datetime1;
    public $payment_scheme1;
    public $transaction_ref1;
    public $channel_response_desc1;
    public $res_status1;
    public $res_referenceNo1;
    public $transaction_datetime2;
    public $payment_scheme2;
    public $transaction_ref2;
    public $channel_response_desc2;
    public $res_status2;
    public $res_referenceNo2;
    public $status_approve;
    public $cdate;
    public $cip;
    public $cuser;
    public $uuser;
    public $uip;
    public $udate;
    public $res_paidAgent1;
    public $res_paidChannel1;
    public $res_maskedPan1;
    public $res_paidAgent2;
    public $res_paidChannel2;
    public $res_maskedPan2;
    public $is_email1;
    public $is_email2;
    public $receipt_status1;
    public $receipt_status2;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'buyer_asset_rent';
        $this->TableName = 'buyer_asset_rent';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`buyer_asset_rent`";
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

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_buyer_asset_rent_id',
            'buyer_asset_rent_id',
            '`buyer_asset_rent_id`',
            '`buyer_asset_rent_id`',
            3,
            11,
            -1,
            false,
            '`buyer_asset_rent_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->buyer_asset_rent_id->InputTextType = "text";
        $this->buyer_asset_rent_id->IsAutoIncrement = true; // Autoincrement field
        $this->buyer_asset_rent_id->IsPrimaryKey = true; // Primary key field
        $this->buyer_asset_rent_id->Sortable = false; // Allow sort
        $this->buyer_asset_rent_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buyer_asset_rent_id'] = &$this->buyer_asset_rent_id;

        // asset_id
        $this->asset_id = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
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
        $this->asset_id->IsForeignKey = true; // Foreign key field
        $this->asset_id->Nullable = false; // NOT NULL field
        $this->asset_id->Required = true; // Required field
        $this->asset_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->asset_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->asset_id->Lookup = new Lookup('asset_id', 'asset', false, 'asset_id', ["title","asset_code","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`title`, ''),'" . ValueSeparator(1, $this->asset_id) . "',COALESCE(`asset_code`,''))");
        $this->asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_id'] = &$this->asset_id;

        // member_id
        $this->member_id = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
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
        $this->member_id->IsForeignKey = true; // Foreign key field
        $this->member_id->Nullable = false; // NOT NULL field
        $this->member_id->Required = true; // Required field
        $this->member_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->member_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // one_time_status
        $this->one_time_status = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_one_time_status',
            'one_time_status',
            '`one_time_status`',
            '`one_time_status`',
            16,
            1,
            -1,
            false,
            '`one_time_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->one_time_status->InputTextType = "text";
        $this->one_time_status->Nullable = false; // NOT NULL field
        $this->one_time_status->DataType = DATATYPE_BOOLEAN;
        $this->one_time_status->Lookup = new Lookup('one_time_status', 'buyer_asset_rent', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->one_time_status->OptionCount = 2;
        $this->one_time_status->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['one_time_status'] = &$this->one_time_status;

        // half_price_1
        $this->half_price_1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_half_price_1',
            'half_price_1',
            '`half_price_1`',
            '`half_price_1`',
            4,
            12,
            -1,
            false,
            '`half_price_1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->half_price_1->InputTextType = "text";
        $this->half_price_1->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['half_price_1'] = &$this->half_price_1;

        // status_pay_half_price_1
        $this->status_pay_half_price_1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_status_pay_half_price_1',
            'status_pay_half_price_1',
            '`status_pay_half_price_1`',
            '`status_pay_half_price_1`',
            3,
            11,
            -1,
            false,
            '`status_pay_half_price_1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->status_pay_half_price_1->InputTextType = "text";
        $this->status_pay_half_price_1->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_pay_half_price_1->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_pay_half_price_1->Lookup = new Lookup('status_pay_half_price_1', 'buyer_asset_rent', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_pay_half_price_1->OptionCount = 3;
        $this->status_pay_half_price_1->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_pay_half_price_1'] = &$this->status_pay_half_price_1;

        // pay_number_half_price_1
        $this->pay_number_half_price_1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_pay_number_half_price_1',
            'pay_number_half_price_1',
            '`pay_number_half_price_1`',
            '`pay_number_half_price_1`',
            200,
            255,
            -1,
            false,
            '`pay_number_half_price_1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->pay_number_half_price_1->InputTextType = "text";
        $this->Fields['pay_number_half_price_1'] = &$this->pay_number_half_price_1;

        // date_pay_half_price_1
        $this->date_pay_half_price_1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_date_pay_half_price_1',
            'date_pay_half_price_1',
            '`date_pay_half_price_1`',
            CastDateFieldForLike("`date_pay_half_price_1`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`date_pay_half_price_1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date_pay_half_price_1->InputTextType = "text";
        $this->date_pay_half_price_1->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['date_pay_half_price_1'] = &$this->date_pay_half_price_1;

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_due_date_pay_half_price_1',
            'due_date_pay_half_price_1',
            '`due_date_pay_half_price_1`',
            CastDateFieldForLike("`due_date_pay_half_price_1`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`due_date_pay_half_price_1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->due_date_pay_half_price_1->InputTextType = "text";
        $this->due_date_pay_half_price_1->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['due_date_pay_half_price_1'] = &$this->due_date_pay_half_price_1;

        // half_price_2
        $this->half_price_2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_half_price_2',
            'half_price_2',
            '`half_price_2`',
            '`half_price_2`',
            4,
            12,
            -1,
            false,
            '`half_price_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->half_price_2->InputTextType = "text";
        $this->half_price_2->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['half_price_2'] = &$this->half_price_2;

        // status_pay_half_price_2
        $this->status_pay_half_price_2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_status_pay_half_price_2',
            'status_pay_half_price_2',
            '`status_pay_half_price_2`',
            '`status_pay_half_price_2`',
            3,
            11,
            -1,
            false,
            '`status_pay_half_price_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->status_pay_half_price_2->InputTextType = "text";
        $this->status_pay_half_price_2->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_pay_half_price_2->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_pay_half_price_2->Lookup = new Lookup('status_pay_half_price_2', 'buyer_asset_rent', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_pay_half_price_2->OptionCount = 3;
        $this->status_pay_half_price_2->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_pay_half_price_2'] = &$this->status_pay_half_price_2;

        // pay_number_half_price_2
        $this->pay_number_half_price_2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_pay_number_half_price_2',
            'pay_number_half_price_2',
            '`pay_number_half_price_2`',
            '`pay_number_half_price_2`',
            200,
            255,
            -1,
            false,
            '`pay_number_half_price_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->pay_number_half_price_2->InputTextType = "text";
        $this->Fields['pay_number_half_price_2'] = &$this->pay_number_half_price_2;

        // date_pay_half_price_2
        $this->date_pay_half_price_2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_date_pay_half_price_2',
            'date_pay_half_price_2',
            '`date_pay_half_price_2`',
            CastDateFieldForLike("`date_pay_half_price_2`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`date_pay_half_price_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date_pay_half_price_2->InputTextType = "text";
        $this->date_pay_half_price_2->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['date_pay_half_price_2'] = &$this->date_pay_half_price_2;

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_due_date_pay_half_price_2',
            'due_date_pay_half_price_2',
            '`due_date_pay_half_price_2`',
            CastDateFieldForLike("`due_date_pay_half_price_2`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`due_date_pay_half_price_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->due_date_pay_half_price_2->InputTextType = "text";
        $this->due_date_pay_half_price_2->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['due_date_pay_half_price_2'] = &$this->due_date_pay_half_price_2;

        // transaction_datetime1
        $this->transaction_datetime1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_transaction_datetime1',
            'transaction_datetime1',
            '`transaction_datetime1`',
            CastDateFieldForLike("`transaction_datetime1`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`transaction_datetime1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transaction_datetime1->InputTextType = "text";
        $this->transaction_datetime1->Sortable = false; // Allow sort
        $this->transaction_datetime1->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['transaction_datetime1'] = &$this->transaction_datetime1;

        // payment_scheme1
        $this->payment_scheme1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_payment_scheme1',
            'payment_scheme1',
            '`payment_scheme1`',
            '`payment_scheme1`',
            200,
            50,
            -1,
            false,
            '`payment_scheme1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->payment_scheme1->InputTextType = "text";
        $this->payment_scheme1->Sortable = false; // Allow sort
        $this->Fields['payment_scheme1'] = &$this->payment_scheme1;

        // transaction_ref1
        $this->transaction_ref1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_transaction_ref1',
            'transaction_ref1',
            '`transaction_ref1`',
            '`transaction_ref1`',
            200,
            255,
            -1,
            false,
            '`transaction_ref1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transaction_ref1->InputTextType = "text";
        $this->transaction_ref1->Sortable = false; // Allow sort
        $this->Fields['transaction_ref1'] = &$this->transaction_ref1;

        // channel_response_desc1
        $this->channel_response_desc1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_channel_response_desc1',
            'channel_response_desc1',
            '`channel_response_desc1`',
            '`channel_response_desc1`',
            200,
            255,
            -1,
            false,
            '`channel_response_desc1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->channel_response_desc1->InputTextType = "text";
        $this->channel_response_desc1->Sortable = false; // Allow sort
        $this->Fields['channel_response_desc1'] = &$this->channel_response_desc1;

        // res_status1
        $this->res_status1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_status1',
            'res_status1',
            '`res_status1`',
            '`res_status1`',
            200,
            50,
            -1,
            false,
            '`res_status1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_status1->InputTextType = "text";
        $this->res_status1->Sortable = false; // Allow sort
        $this->Fields['res_status1'] = &$this->res_status1;

        // res_referenceNo1
        $this->res_referenceNo1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_referenceNo1',
            'res_referenceNo1',
            '`res_referenceNo1`',
            '`res_referenceNo1`',
            200,
            255,
            -1,
            false,
            '`res_referenceNo1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_referenceNo1->InputTextType = "text";
        $this->res_referenceNo1->Sortable = false; // Allow sort
        $this->Fields['res_referenceNo1'] = &$this->res_referenceNo1;

        // transaction_datetime2
        $this->transaction_datetime2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_transaction_datetime2',
            'transaction_datetime2',
            '`transaction_datetime2`',
            CastDateFieldForLike("`transaction_datetime2`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`transaction_datetime2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transaction_datetime2->InputTextType = "text";
        $this->transaction_datetime2->Sortable = false; // Allow sort
        $this->transaction_datetime2->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['transaction_datetime2'] = &$this->transaction_datetime2;

        // payment_scheme2
        $this->payment_scheme2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_payment_scheme2',
            'payment_scheme2',
            '`payment_scheme2`',
            '`payment_scheme2`',
            200,
            50,
            -1,
            false,
            '`payment_scheme2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->payment_scheme2->InputTextType = "text";
        $this->payment_scheme2->Sortable = false; // Allow sort
        $this->Fields['payment_scheme2'] = &$this->payment_scheme2;

        // transaction_ref2
        $this->transaction_ref2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_transaction_ref2',
            'transaction_ref2',
            '`transaction_ref2`',
            '`transaction_ref2`',
            200,
            255,
            -1,
            false,
            '`transaction_ref2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transaction_ref2->InputTextType = "text";
        $this->transaction_ref2->Sortable = false; // Allow sort
        $this->Fields['transaction_ref2'] = &$this->transaction_ref2;

        // channel_response_desc2
        $this->channel_response_desc2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_channel_response_desc2',
            'channel_response_desc2',
            '`channel_response_desc2`',
            '`channel_response_desc2`',
            200,
            255,
            -1,
            false,
            '`channel_response_desc2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->channel_response_desc2->InputTextType = "text";
        $this->channel_response_desc2->Sortable = false; // Allow sort
        $this->Fields['channel_response_desc2'] = &$this->channel_response_desc2;

        // res_status2
        $this->res_status2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_status2',
            'res_status2',
            '`res_status2`',
            '`res_status2`',
            200,
            50,
            -1,
            false,
            '`res_status2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_status2->InputTextType = "text";
        $this->res_status2->Sortable = false; // Allow sort
        $this->Fields['res_status2'] = &$this->res_status2;

        // res_referenceNo2
        $this->res_referenceNo2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_referenceNo2',
            'res_referenceNo2',
            '`res_referenceNo2`',
            '`res_referenceNo2`',
            200,
            255,
            -1,
            false,
            '`res_referenceNo2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_referenceNo2->InputTextType = "text";
        $this->res_referenceNo2->Sortable = false; // Allow sort
        $this->Fields['res_referenceNo2'] = &$this->res_referenceNo2;

        // status_approve
        $this->status_approve = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_status_approve',
            'status_approve',
            '`status_approve`',
            '`status_approve`',
            3,
            11,
            -1,
            false,
            '`status_approve`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->status_approve->InputTextType = "text";
        $this->status_approve->Sortable = false; // Allow sort
        $this->status_approve->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_approve'] = &$this->status_approve;

        // cdate
        $this->cdate = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
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

        // cip
        $this->cip = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
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
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            200,
            45,
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

        // uuser
        $this->uuser = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            200,
            45,
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

        // uip
        $this->uip = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
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

        // udate
        $this->udate = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
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
        $this->udate->Sortable = false; // Allow sort
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // res_paidAgent1
        $this->res_paidAgent1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_paidAgent1',
            'res_paidAgent1',
            '`res_paidAgent1`',
            '`res_paidAgent1`',
            200,
            100,
            -1,
            false,
            '`res_paidAgent1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_paidAgent1->InputTextType = "text";
        $this->res_paidAgent1->Sortable = false; // Allow sort
        $this->Fields['res_paidAgent1'] = &$this->res_paidAgent1;

        // res_paidChannel1
        $this->res_paidChannel1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_paidChannel1',
            'res_paidChannel1',
            '`res_paidChannel1`',
            '`res_paidChannel1`',
            200,
            100,
            -1,
            false,
            '`res_paidChannel1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_paidChannel1->InputTextType = "text";
        $this->res_paidChannel1->Sortable = false; // Allow sort
        $this->Fields['res_paidChannel1'] = &$this->res_paidChannel1;

        // res_maskedPan1
        $this->res_maskedPan1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_maskedPan1',
            'res_maskedPan1',
            '`res_maskedPan1`',
            '`res_maskedPan1`',
            200,
            100,
            -1,
            false,
            '`res_maskedPan1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_maskedPan1->InputTextType = "text";
        $this->res_maskedPan1->Sortable = false; // Allow sort
        $this->Fields['res_maskedPan1'] = &$this->res_maskedPan1;

        // res_paidAgent2
        $this->res_paidAgent2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_paidAgent2',
            'res_paidAgent2',
            '`res_paidAgent2`',
            '`res_paidAgent2`',
            200,
            100,
            -1,
            false,
            '`res_paidAgent2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_paidAgent2->InputTextType = "text";
        $this->res_paidAgent2->Sortable = false; // Allow sort
        $this->Fields['res_paidAgent2'] = &$this->res_paidAgent2;

        // res_paidChannel2
        $this->res_paidChannel2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_paidChannel2',
            'res_paidChannel2',
            '`res_paidChannel2`',
            '`res_paidChannel2`',
            200,
            100,
            -1,
            false,
            '`res_paidChannel2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_paidChannel2->InputTextType = "text";
        $this->res_paidChannel2->Sortable = false; // Allow sort
        $this->Fields['res_paidChannel2'] = &$this->res_paidChannel2;

        // res_maskedPan2
        $this->res_maskedPan2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_res_maskedPan2',
            'res_maskedPan2',
            '`res_maskedPan2`',
            '`res_maskedPan2`',
            200,
            100,
            -1,
            false,
            '`res_maskedPan2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_maskedPan2->InputTextType = "text";
        $this->res_maskedPan2->Sortable = false; // Allow sort
        $this->Fields['res_maskedPan2'] = &$this->res_maskedPan2;

        // is_email1
        $this->is_email1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_is_email1',
            'is_email1',
            '`is_email1`',
            '`is_email1`',
            3,
            11,
            -1,
            false,
            '`is_email1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->is_email1->InputTextType = "text";
        $this->is_email1->Nullable = false; // NOT NULL field
        $this->is_email1->Sortable = false; // Allow sort
        $this->is_email1->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['is_email1'] = &$this->is_email1;

        // is_email2
        $this->is_email2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_is_email2',
            'is_email2',
            '`is_email2`',
            '`is_email2`',
            3,
            11,
            -1,
            false,
            '`is_email2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->is_email2->InputTextType = "text";
        $this->is_email2->Nullable = false; // NOT NULL field
        $this->is_email2->Sortable = false; // Allow sort
        $this->is_email2->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['is_email2'] = &$this->is_email2;

        // receipt_status1
        $this->receipt_status1 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_receipt_status1',
            'receipt_status1',
            '`receipt_status1`',
            '`receipt_status1`',
            3,
            11,
            -1,
            false,
            '`receipt_status1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receipt_status1->InputTextType = "text";
        $this->receipt_status1->Nullable = false; // NOT NULL field
        $this->receipt_status1->Sortable = false; // Allow sort
        $this->receipt_status1->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receipt_status1'] = &$this->receipt_status1;

        // receipt_status2
        $this->receipt_status2 = new DbField(
            'buyer_asset_rent',
            'buyer_asset_rent',
            'x_receipt_status2',
            'receipt_status2',
            '`receipt_status2`',
            '`receipt_status2`',
            3,
            11,
            -1,
            false,
            '`receipt_status2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receipt_status2->InputTextType = "text";
        $this->receipt_status2->Nullable = false; // NOT NULL field
        $this->receipt_status2->Sortable = false; // Allow sort
        $this->receipt_status2->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receipt_status2'] = &$this->receipt_status2;

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
        if ($this->getCurrentMasterTable() == "buyer_asset") {
            if ($this->asset_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
            if ($this->member_id->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
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
        if ($this->getCurrentMasterTable() == "buyer_asset") {
            if ($this->asset_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
            if ($this->member_id->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
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
            case "buyer_asset":
                $key = $keys["asset_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->asset_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                $key = $keys["member_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->member_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`asset_id`=" . QuotedValue($keys["asset_id"], $masterTable->asset_id->DataType, $masterTable->Dbid) . " AND `member_id`=" . QuotedValue($keys["member_id"], $masterTable->member_id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "buyer_asset":
                return "`asset_id`=" . QuotedValue($masterTable->asset_id->DbValue, $this->asset_id->DataType, $this->Dbid) . " AND `member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`buyer_asset_rent`";
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
            $this->buyer_asset_rent_id->setDbValue($conn->lastInsertId());
            $rs['buyer_asset_rent_id'] = $this->buyer_asset_rent_id->DbValue;
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
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'buyer_asset_rent_id';
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
            if (array_key_exists('buyer_asset_rent_id', $rs)) {
                AddFilter($where, QuotedName('buyer_asset_rent_id', $this->Dbid) . '=' . QuotedValue($rs['buyer_asset_rent_id'], $this->buyer_asset_rent_id->DataType, $this->Dbid));
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
        $this->buyer_asset_rent_id->DbValue = $row['buyer_asset_rent_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->one_time_status->DbValue = $row['one_time_status'];
        $this->half_price_1->DbValue = $row['half_price_1'];
        $this->status_pay_half_price_1->DbValue = $row['status_pay_half_price_1'];
        $this->pay_number_half_price_1->DbValue = $row['pay_number_half_price_1'];
        $this->date_pay_half_price_1->DbValue = $row['date_pay_half_price_1'];
        $this->due_date_pay_half_price_1->DbValue = $row['due_date_pay_half_price_1'];
        $this->half_price_2->DbValue = $row['half_price_2'];
        $this->status_pay_half_price_2->DbValue = $row['status_pay_half_price_2'];
        $this->pay_number_half_price_2->DbValue = $row['pay_number_half_price_2'];
        $this->date_pay_half_price_2->DbValue = $row['date_pay_half_price_2'];
        $this->due_date_pay_half_price_2->DbValue = $row['due_date_pay_half_price_2'];
        $this->transaction_datetime1->DbValue = $row['transaction_datetime1'];
        $this->payment_scheme1->DbValue = $row['payment_scheme1'];
        $this->transaction_ref1->DbValue = $row['transaction_ref1'];
        $this->channel_response_desc1->DbValue = $row['channel_response_desc1'];
        $this->res_status1->DbValue = $row['res_status1'];
        $this->res_referenceNo1->DbValue = $row['res_referenceNo1'];
        $this->transaction_datetime2->DbValue = $row['transaction_datetime2'];
        $this->payment_scheme2->DbValue = $row['payment_scheme2'];
        $this->transaction_ref2->DbValue = $row['transaction_ref2'];
        $this->channel_response_desc2->DbValue = $row['channel_response_desc2'];
        $this->res_status2->DbValue = $row['res_status2'];
        $this->res_referenceNo2->DbValue = $row['res_referenceNo2'];
        $this->status_approve->DbValue = $row['status_approve'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cip->DbValue = $row['cip'];
        $this->cuser->DbValue = $row['cuser'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->udate->DbValue = $row['udate'];
        $this->res_paidAgent1->DbValue = $row['res_paidAgent1'];
        $this->res_paidChannel1->DbValue = $row['res_paidChannel1'];
        $this->res_maskedPan1->DbValue = $row['res_maskedPan1'];
        $this->res_paidAgent2->DbValue = $row['res_paidAgent2'];
        $this->res_paidChannel2->DbValue = $row['res_paidChannel2'];
        $this->res_maskedPan2->DbValue = $row['res_maskedPan2'];
        $this->is_email1->DbValue = $row['is_email1'];
        $this->is_email2->DbValue = $row['is_email2'];
        $this->receipt_status1->DbValue = $row['receipt_status1'];
        $this->receipt_status2->DbValue = $row['receipt_status2'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`buyer_asset_rent_id` = @buyer_asset_rent_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->buyer_asset_rent_id->CurrentValue : $this->buyer_asset_rent_id->OldValue;
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
                $this->buyer_asset_rent_id->CurrentValue = $keys[0];
            } else {
                $this->buyer_asset_rent_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('buyer_asset_rent_id', $row) ? $row['buyer_asset_rent_id'] : null;
        } else {
            $val = $this->buyer_asset_rent_id->OldValue !== null ? $this->buyer_asset_rent_id->OldValue : $this->buyer_asset_rent_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@buyer_asset_rent_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("buyerassetrentlist");
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
        if ($pageName == "buyerassetrentview") {
            return $Language->phrase("View");
        } elseif ($pageName == "buyerassetrentedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "buyerassetrentadd") {
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
                return "BuyerAssetRentView";
            case Config("API_ADD_ACTION"):
                return "BuyerAssetRentAdd";
            case Config("API_EDIT_ACTION"):
                return "BuyerAssetRentEdit";
            case Config("API_DELETE_ACTION"):
                return "BuyerAssetRentDelete";
            case Config("API_LIST_ACTION"):
                return "BuyerAssetRentList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "buyerassetrentlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("buyerassetrentview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyerassetrentview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "buyerassetrentadd?" . $this->getUrlParm($parm);
        } else {
            $url = "buyerassetrentadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("buyerassetrentedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("buyerassetrentadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("buyerassetrentdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "buyer_asset" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"buyer_asset_rent_id\":" . JsonEncode($this->buyer_asset_rent_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->buyer_asset_rent_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->buyer_asset_rent_id->CurrentValue);
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
            if (($keyValue = Param("buyer_asset_rent_id") ?? Route("buyer_asset_rent_id")) !== null) {
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
                $this->buyer_asset_rent_id->CurrentValue = $key;
            } else {
                $this->buyer_asset_rent_id->OldValue = $key;
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
        $this->buyer_asset_rent_id->setDbValue($row['buyer_asset_rent_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->one_time_status->setDbValue($row['one_time_status']);
        $this->half_price_1->setDbValue($row['half_price_1']);
        $this->status_pay_half_price_1->setDbValue($row['status_pay_half_price_1']);
        $this->pay_number_half_price_1->setDbValue($row['pay_number_half_price_1']);
        $this->date_pay_half_price_1->setDbValue($row['date_pay_half_price_1']);
        $this->due_date_pay_half_price_1->setDbValue($row['due_date_pay_half_price_1']);
        $this->half_price_2->setDbValue($row['half_price_2']);
        $this->status_pay_half_price_2->setDbValue($row['status_pay_half_price_2']);
        $this->pay_number_half_price_2->setDbValue($row['pay_number_half_price_2']);
        $this->date_pay_half_price_2->setDbValue($row['date_pay_half_price_2']);
        $this->due_date_pay_half_price_2->setDbValue($row['due_date_pay_half_price_2']);
        $this->transaction_datetime1->setDbValue($row['transaction_datetime1']);
        $this->payment_scheme1->setDbValue($row['payment_scheme1']);
        $this->transaction_ref1->setDbValue($row['transaction_ref1']);
        $this->channel_response_desc1->setDbValue($row['channel_response_desc1']);
        $this->res_status1->setDbValue($row['res_status1']);
        $this->res_referenceNo1->setDbValue($row['res_referenceNo1']);
        $this->transaction_datetime2->setDbValue($row['transaction_datetime2']);
        $this->payment_scheme2->setDbValue($row['payment_scheme2']);
        $this->transaction_ref2->setDbValue($row['transaction_ref2']);
        $this->channel_response_desc2->setDbValue($row['channel_response_desc2']);
        $this->res_status2->setDbValue($row['res_status2']);
        $this->res_referenceNo2->setDbValue($row['res_referenceNo2']);
        $this->status_approve->setDbValue($row['status_approve']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cip->setDbValue($row['cip']);
        $this->cuser->setDbValue($row['cuser']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->res_paidAgent1->setDbValue($row['res_paidAgent1']);
        $this->res_paidChannel1->setDbValue($row['res_paidChannel1']);
        $this->res_maskedPan1->setDbValue($row['res_maskedPan1']);
        $this->res_paidAgent2->setDbValue($row['res_paidAgent2']);
        $this->res_paidChannel2->setDbValue($row['res_paidChannel2']);
        $this->res_maskedPan2->setDbValue($row['res_maskedPan2']);
        $this->is_email1->setDbValue($row['is_email1']);
        $this->is_email2->setDbValue($row['is_email2']);
        $this->receipt_status1->setDbValue($row['receipt_status1']);
        $this->receipt_status2->setDbValue($row['receipt_status2']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id->CellCssStyle = "white-space: nowrap;";

        // asset_id

        // member_id

        // one_time_status

        // half_price_1

        // status_pay_half_price_1

        // pay_number_half_price_1

        // date_pay_half_price_1

        // due_date_pay_half_price_1

        // half_price_2

        // status_pay_half_price_2

        // pay_number_half_price_2

        // date_pay_half_price_2

        // due_date_pay_half_price_2

        // transaction_datetime1
        $this->transaction_datetime1->CellCssStyle = "white-space: nowrap;";

        // payment_scheme1
        $this->payment_scheme1->CellCssStyle = "white-space: nowrap;";

        // transaction_ref1
        $this->transaction_ref1->CellCssStyle = "white-space: nowrap;";

        // channel_response_desc1
        $this->channel_response_desc1->CellCssStyle = "white-space: nowrap;";

        // res_status1
        $this->res_status1->CellCssStyle = "white-space: nowrap;";

        // res_referenceNo1
        $this->res_referenceNo1->CellCssStyle = "white-space: nowrap;";

        // transaction_datetime2
        $this->transaction_datetime2->CellCssStyle = "white-space: nowrap;";

        // payment_scheme2
        $this->payment_scheme2->CellCssStyle = "white-space: nowrap;";

        // transaction_ref2
        $this->transaction_ref2->CellCssStyle = "white-space: nowrap;";

        // channel_response_desc2
        $this->channel_response_desc2->CellCssStyle = "white-space: nowrap;";

        // res_status2
        $this->res_status2->CellCssStyle = "white-space: nowrap;";

        // res_referenceNo2
        $this->res_referenceNo2->CellCssStyle = "white-space: nowrap;";

        // status_approve
        $this->status_approve->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cip

        // cuser

        // uuser

        // uip

        // udate

        // res_paidAgent1
        $this->res_paidAgent1->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel1
        $this->res_paidChannel1->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan1
        $this->res_maskedPan1->CellCssStyle = "white-space: nowrap;";

        // res_paidAgent2
        $this->res_paidAgent2->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel2
        $this->res_paidChannel2->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan2
        $this->res_maskedPan2->CellCssStyle = "white-space: nowrap;";

        // is_email1
        $this->is_email1->CellCssStyle = "white-space: nowrap;";

        // is_email2
        $this->is_email2->CellCssStyle = "white-space: nowrap;";

        // receipt_status1
        $this->receipt_status1->CellCssStyle = "white-space: nowrap;";

        // receipt_status2
        $this->receipt_status2->CellCssStyle = "white-space: nowrap;";

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id->ViewValue = $this->buyer_asset_rent_id->CurrentValue;
        $this->buyer_asset_rent_id->ViewCustomAttributes = "";

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

        // member_id
        $curVal = strval($this->member_id->CurrentValue);
        if ($curVal != "") {
            $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
            if ($this->member_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

        // one_time_status
        if (ConvertToBool($this->one_time_status->CurrentValue)) {
            $this->one_time_status->ViewValue = $this->one_time_status->tagCaption(1) != "" ? $this->one_time_status->tagCaption(1) : "Yes";
        } else {
            $this->one_time_status->ViewValue = $this->one_time_status->tagCaption(2) != "" ? $this->one_time_status->tagCaption(2) : "No";
        }
        $this->one_time_status->ViewCustomAttributes = "";

        // half_price_1
        $this->half_price_1->ViewValue = $this->half_price_1->CurrentValue;
        $this->half_price_1->ViewValue = FormatCurrency($this->half_price_1->ViewValue, $this->half_price_1->formatPattern());
        $this->half_price_1->ViewCustomAttributes = "";

        // status_pay_half_price_1
        if (strval($this->status_pay_half_price_1->CurrentValue) != "") {
            $this->status_pay_half_price_1->ViewValue = $this->status_pay_half_price_1->optionCaption($this->status_pay_half_price_1->CurrentValue);
        } else {
            $this->status_pay_half_price_1->ViewValue = null;
        }
        $this->status_pay_half_price_1->ViewCustomAttributes = "";

        // pay_number_half_price_1
        $this->pay_number_half_price_1->ViewValue = $this->pay_number_half_price_1->CurrentValue;
        $this->pay_number_half_price_1->ViewCustomAttributes = "";

        // date_pay_half_price_1
        $this->date_pay_half_price_1->ViewValue = $this->date_pay_half_price_1->CurrentValue;
        $this->date_pay_half_price_1->ViewValue = FormatDateTime($this->date_pay_half_price_1->ViewValue, $this->date_pay_half_price_1->formatPattern());
        $this->date_pay_half_price_1->ViewCustomAttributes = "";

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1->ViewValue = $this->due_date_pay_half_price_1->CurrentValue;
        $this->due_date_pay_half_price_1->ViewValue = FormatDateTime($this->due_date_pay_half_price_1->ViewValue, $this->due_date_pay_half_price_1->formatPattern());
        $this->due_date_pay_half_price_1->ViewCustomAttributes = "";

        // half_price_2
        $this->half_price_2->ViewValue = $this->half_price_2->CurrentValue;
        $this->half_price_2->ViewValue = FormatCurrency($this->half_price_2->ViewValue, $this->half_price_2->formatPattern());
        $this->half_price_2->ViewCustomAttributes = "";

        // status_pay_half_price_2
        if (strval($this->status_pay_half_price_2->CurrentValue) != "") {
            $this->status_pay_half_price_2->ViewValue = $this->status_pay_half_price_2->optionCaption($this->status_pay_half_price_2->CurrentValue);
        } else {
            $this->status_pay_half_price_2->ViewValue = null;
        }
        $this->status_pay_half_price_2->ViewCustomAttributes = "";

        // pay_number_half_price_2
        $this->pay_number_half_price_2->ViewValue = $this->pay_number_half_price_2->CurrentValue;
        $this->pay_number_half_price_2->ViewCustomAttributes = "";

        // date_pay_half_price_2
        $this->date_pay_half_price_2->ViewValue = $this->date_pay_half_price_2->CurrentValue;
        $this->date_pay_half_price_2->ViewValue = FormatDateTime($this->date_pay_half_price_2->ViewValue, $this->date_pay_half_price_2->formatPattern());
        $this->date_pay_half_price_2->ViewCustomAttributes = "";

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2->ViewValue = $this->due_date_pay_half_price_2->CurrentValue;
        $this->due_date_pay_half_price_2->ViewValue = FormatDateTime($this->due_date_pay_half_price_2->ViewValue, $this->due_date_pay_half_price_2->formatPattern());
        $this->due_date_pay_half_price_2->ViewCustomAttributes = "";

        // transaction_datetime1
        $this->transaction_datetime1->ViewValue = $this->transaction_datetime1->CurrentValue;
        $this->transaction_datetime1->ViewValue = FormatDateTime($this->transaction_datetime1->ViewValue, $this->transaction_datetime1->formatPattern());
        $this->transaction_datetime1->ViewCustomAttributes = "";

        // payment_scheme1
        $this->payment_scheme1->ViewValue = $this->payment_scheme1->CurrentValue;
        $this->payment_scheme1->ViewCustomAttributes = "";

        // transaction_ref1
        $this->transaction_ref1->ViewValue = $this->transaction_ref1->CurrentValue;
        $this->transaction_ref1->ViewCustomAttributes = "";

        // channel_response_desc1
        $this->channel_response_desc1->ViewValue = $this->channel_response_desc1->CurrentValue;
        $this->channel_response_desc1->ViewCustomAttributes = "";

        // res_status1
        $this->res_status1->ViewValue = $this->res_status1->CurrentValue;
        $this->res_status1->ViewCustomAttributes = "";

        // res_referenceNo1
        $this->res_referenceNo1->ViewValue = $this->res_referenceNo1->CurrentValue;
        $this->res_referenceNo1->ViewCustomAttributes = "";

        // transaction_datetime2
        $this->transaction_datetime2->ViewValue = $this->transaction_datetime2->CurrentValue;
        $this->transaction_datetime2->ViewValue = FormatDateTime($this->transaction_datetime2->ViewValue, $this->transaction_datetime2->formatPattern());
        $this->transaction_datetime2->ViewCustomAttributes = "";

        // payment_scheme2
        $this->payment_scheme2->ViewValue = $this->payment_scheme2->CurrentValue;
        $this->payment_scheme2->ViewCustomAttributes = "";

        // transaction_ref2
        $this->transaction_ref2->ViewValue = $this->transaction_ref2->CurrentValue;
        $this->transaction_ref2->ViewCustomAttributes = "";

        // channel_response_desc2
        $this->channel_response_desc2->ViewValue = $this->channel_response_desc2->CurrentValue;
        $this->channel_response_desc2->ViewCustomAttributes = "";

        // res_status2
        $this->res_status2->ViewValue = $this->res_status2->CurrentValue;
        $this->res_status2->ViewCustomAttributes = "";

        // res_referenceNo2
        $this->res_referenceNo2->ViewValue = $this->res_referenceNo2->CurrentValue;
        $this->res_referenceNo2->ViewCustomAttributes = "";

        // status_approve
        $this->status_approve->ViewValue = $this->status_approve->CurrentValue;
        $this->status_approve->ViewValue = FormatNumber($this->status_approve->ViewValue, $this->status_approve->formatPattern());
        $this->status_approve->ViewCustomAttributes = "";

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

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // res_paidAgent1
        $this->res_paidAgent1->ViewValue = $this->res_paidAgent1->CurrentValue;
        $this->res_paidAgent1->ViewCustomAttributes = "";

        // res_paidChannel1
        $this->res_paidChannel1->ViewValue = $this->res_paidChannel1->CurrentValue;
        $this->res_paidChannel1->ViewCustomAttributes = "";

        // res_maskedPan1
        $this->res_maskedPan1->ViewValue = $this->res_maskedPan1->CurrentValue;
        $this->res_maskedPan1->ViewCustomAttributes = "";

        // res_paidAgent2
        $this->res_paidAgent2->ViewValue = $this->res_paidAgent2->CurrentValue;
        $this->res_paidAgent2->ViewCustomAttributes = "";

        // res_paidChannel2
        $this->res_paidChannel2->ViewValue = $this->res_paidChannel2->CurrentValue;
        $this->res_paidChannel2->ViewCustomAttributes = "";

        // res_maskedPan2
        $this->res_maskedPan2->ViewValue = $this->res_maskedPan2->CurrentValue;
        $this->res_maskedPan2->ViewCustomAttributes = "";

        // is_email1
        $this->is_email1->ViewValue = $this->is_email1->CurrentValue;
        $this->is_email1->ViewValue = FormatNumber($this->is_email1->ViewValue, $this->is_email1->formatPattern());
        $this->is_email1->ViewCustomAttributes = "";

        // is_email2
        $this->is_email2->ViewValue = $this->is_email2->CurrentValue;
        $this->is_email2->ViewValue = FormatNumber($this->is_email2->ViewValue, $this->is_email2->formatPattern());
        $this->is_email2->ViewCustomAttributes = "";

        // receipt_status1
        $this->receipt_status1->ViewValue = $this->receipt_status1->CurrentValue;
        $this->receipt_status1->ViewValue = FormatNumber($this->receipt_status1->ViewValue, $this->receipt_status1->formatPattern());
        $this->receipt_status1->ViewCustomAttributes = "";

        // receipt_status2
        $this->receipt_status2->ViewValue = $this->receipt_status2->CurrentValue;
        $this->receipt_status2->ViewValue = FormatNumber($this->receipt_status2->ViewValue, $this->receipt_status2->formatPattern());
        $this->receipt_status2->ViewCustomAttributes = "";

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id->LinkCustomAttributes = "";
        $this->buyer_asset_rent_id->HrefValue = "";
        $this->buyer_asset_rent_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // one_time_status
        $this->one_time_status->LinkCustomAttributes = "";
        $this->one_time_status->HrefValue = "";
        $this->one_time_status->TooltipValue = "";

        // half_price_1
        $this->half_price_1->LinkCustomAttributes = "";
        $this->half_price_1->HrefValue = "";
        $this->half_price_1->TooltipValue = "";

        // status_pay_half_price_1
        $this->status_pay_half_price_1->LinkCustomAttributes = "";
        $this->status_pay_half_price_1->HrefValue = "";
        $this->status_pay_half_price_1->TooltipValue = "";

        // pay_number_half_price_1
        $this->pay_number_half_price_1->LinkCustomAttributes = "";
        $this->pay_number_half_price_1->HrefValue = "";
        $this->pay_number_half_price_1->TooltipValue = "";

        // date_pay_half_price_1
        $this->date_pay_half_price_1->LinkCustomAttributes = "";
        $this->date_pay_half_price_1->HrefValue = "";
        $this->date_pay_half_price_1->TooltipValue = "";

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1->LinkCustomAttributes = "";
        $this->due_date_pay_half_price_1->HrefValue = "";
        $this->due_date_pay_half_price_1->TooltipValue = "";

        // half_price_2
        $this->half_price_2->LinkCustomAttributes = "";
        $this->half_price_2->HrefValue = "";
        $this->half_price_2->TooltipValue = "";

        // status_pay_half_price_2
        $this->status_pay_half_price_2->LinkCustomAttributes = "";
        $this->status_pay_half_price_2->HrefValue = "";
        $this->status_pay_half_price_2->TooltipValue = "";

        // pay_number_half_price_2
        $this->pay_number_half_price_2->LinkCustomAttributes = "";
        $this->pay_number_half_price_2->HrefValue = "";
        $this->pay_number_half_price_2->TooltipValue = "";

        // date_pay_half_price_2
        $this->date_pay_half_price_2->LinkCustomAttributes = "";
        $this->date_pay_half_price_2->HrefValue = "";
        $this->date_pay_half_price_2->TooltipValue = "";

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2->LinkCustomAttributes = "";
        $this->due_date_pay_half_price_2->HrefValue = "";
        $this->due_date_pay_half_price_2->TooltipValue = "";

        // transaction_datetime1
        $this->transaction_datetime1->LinkCustomAttributes = "";
        $this->transaction_datetime1->HrefValue = "";
        $this->transaction_datetime1->TooltipValue = "";

        // payment_scheme1
        $this->payment_scheme1->LinkCustomAttributes = "";
        $this->payment_scheme1->HrefValue = "";
        $this->payment_scheme1->TooltipValue = "";

        // transaction_ref1
        $this->transaction_ref1->LinkCustomAttributes = "";
        $this->transaction_ref1->HrefValue = "";
        $this->transaction_ref1->TooltipValue = "";

        // channel_response_desc1
        $this->channel_response_desc1->LinkCustomAttributes = "";
        $this->channel_response_desc1->HrefValue = "";
        $this->channel_response_desc1->TooltipValue = "";

        // res_status1
        $this->res_status1->LinkCustomAttributes = "";
        $this->res_status1->HrefValue = "";
        $this->res_status1->TooltipValue = "";

        // res_referenceNo1
        $this->res_referenceNo1->LinkCustomAttributes = "";
        $this->res_referenceNo1->HrefValue = "";
        $this->res_referenceNo1->TooltipValue = "";

        // transaction_datetime2
        $this->transaction_datetime2->LinkCustomAttributes = "";
        $this->transaction_datetime2->HrefValue = "";
        $this->transaction_datetime2->TooltipValue = "";

        // payment_scheme2
        $this->payment_scheme2->LinkCustomAttributes = "";
        $this->payment_scheme2->HrefValue = "";
        $this->payment_scheme2->TooltipValue = "";

        // transaction_ref2
        $this->transaction_ref2->LinkCustomAttributes = "";
        $this->transaction_ref2->HrefValue = "";
        $this->transaction_ref2->TooltipValue = "";

        // channel_response_desc2
        $this->channel_response_desc2->LinkCustomAttributes = "";
        $this->channel_response_desc2->HrefValue = "";
        $this->channel_response_desc2->TooltipValue = "";

        // res_status2
        $this->res_status2->LinkCustomAttributes = "";
        $this->res_status2->HrefValue = "";
        $this->res_status2->TooltipValue = "";

        // res_referenceNo2
        $this->res_referenceNo2->LinkCustomAttributes = "";
        $this->res_referenceNo2->HrefValue = "";
        $this->res_referenceNo2->TooltipValue = "";

        // status_approve
        $this->status_approve->LinkCustomAttributes = "";
        $this->status_approve->HrefValue = "";
        $this->status_approve->TooltipValue = "";

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

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

        // res_paidAgent1
        $this->res_paidAgent1->LinkCustomAttributes = "";
        $this->res_paidAgent1->HrefValue = "";
        $this->res_paidAgent1->TooltipValue = "";

        // res_paidChannel1
        $this->res_paidChannel1->LinkCustomAttributes = "";
        $this->res_paidChannel1->HrefValue = "";
        $this->res_paidChannel1->TooltipValue = "";

        // res_maskedPan1
        $this->res_maskedPan1->LinkCustomAttributes = "";
        $this->res_maskedPan1->HrefValue = "";
        $this->res_maskedPan1->TooltipValue = "";

        // res_paidAgent2
        $this->res_paidAgent2->LinkCustomAttributes = "";
        $this->res_paidAgent2->HrefValue = "";
        $this->res_paidAgent2->TooltipValue = "";

        // res_paidChannel2
        $this->res_paidChannel2->LinkCustomAttributes = "";
        $this->res_paidChannel2->HrefValue = "";
        $this->res_paidChannel2->TooltipValue = "";

        // res_maskedPan2
        $this->res_maskedPan2->LinkCustomAttributes = "";
        $this->res_maskedPan2->HrefValue = "";
        $this->res_maskedPan2->TooltipValue = "";

        // is_email1
        $this->is_email1->LinkCustomAttributes = "";
        $this->is_email1->HrefValue = "";
        $this->is_email1->TooltipValue = "";

        // is_email2
        $this->is_email2->LinkCustomAttributes = "";
        $this->is_email2->HrefValue = "";
        $this->is_email2->TooltipValue = "";

        // receipt_status1
        $this->receipt_status1->LinkCustomAttributes = "";
        $this->receipt_status1->HrefValue = "";
        $this->receipt_status1->TooltipValue = "";

        // receipt_status2
        $this->receipt_status2->LinkCustomAttributes = "";
        $this->receipt_status2->HrefValue = "";
        $this->receipt_status2->TooltipValue = "";

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

        // buyer_asset_rent_id
        $this->buyer_asset_rent_id->setupEditAttributes();
        $this->buyer_asset_rent_id->EditCustomAttributes = "";
        $this->buyer_asset_rent_id->EditValue = $this->buyer_asset_rent_id->CurrentValue;
        $this->buyer_asset_rent_id->ViewCustomAttributes = "";

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

        // member_id
        $this->member_id->setupEditAttributes();
        $this->member_id->EditCustomAttributes = "";
        $curVal = strval($this->member_id->CurrentValue);
        if ($curVal != "") {
            $this->member_id->EditValue = $this->member_id->lookupCacheOption($curVal);
            if ($this->member_id->EditValue === null) { // Lookup from database
                $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

        // one_time_status
        $this->one_time_status->EditCustomAttributes = "";
        $this->one_time_status->EditValue = $this->one_time_status->options(false);
        $this->one_time_status->PlaceHolder = RemoveHtml($this->one_time_status->caption());

        // half_price_1
        $this->half_price_1->setupEditAttributes();
        $this->half_price_1->EditCustomAttributes = "";
        $this->half_price_1->EditValue = $this->half_price_1->CurrentValue;
        $this->half_price_1->PlaceHolder = RemoveHtml($this->half_price_1->caption());
        if (strval($this->half_price_1->EditValue) != "" && is_numeric($this->half_price_1->EditValue)) {
            $this->half_price_1->EditValue = FormatNumber($this->half_price_1->EditValue, null);
        }

        // status_pay_half_price_1
        $this->status_pay_half_price_1->setupEditAttributes();
        $this->status_pay_half_price_1->EditCustomAttributes = "";
        $this->status_pay_half_price_1->EditValue = $this->status_pay_half_price_1->options(true);
        $this->status_pay_half_price_1->PlaceHolder = RemoveHtml($this->status_pay_half_price_1->caption());

        // pay_number_half_price_1
        $this->pay_number_half_price_1->setupEditAttributes();
        $this->pay_number_half_price_1->EditCustomAttributes = "";
        if (!$this->pay_number_half_price_1->Raw) {
            $this->pay_number_half_price_1->CurrentValue = HtmlDecode($this->pay_number_half_price_1->CurrentValue);
        }
        $this->pay_number_half_price_1->EditValue = $this->pay_number_half_price_1->CurrentValue;
        $this->pay_number_half_price_1->PlaceHolder = RemoveHtml($this->pay_number_half_price_1->caption());

        // date_pay_half_price_1
        $this->date_pay_half_price_1->setupEditAttributes();
        $this->date_pay_half_price_1->EditCustomAttributes = "";
        $this->date_pay_half_price_1->EditValue = FormatDateTime($this->date_pay_half_price_1->CurrentValue, $this->date_pay_half_price_1->formatPattern());
        $this->date_pay_half_price_1->PlaceHolder = RemoveHtml($this->date_pay_half_price_1->caption());

        // due_date_pay_half_price_1
        $this->due_date_pay_half_price_1->setupEditAttributes();
        $this->due_date_pay_half_price_1->EditCustomAttributes = "";
        $this->due_date_pay_half_price_1->EditValue = FormatDateTime($this->due_date_pay_half_price_1->CurrentValue, $this->due_date_pay_half_price_1->formatPattern());
        $this->due_date_pay_half_price_1->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_1->caption());

        // half_price_2
        $this->half_price_2->setupEditAttributes();
        $this->half_price_2->EditCustomAttributes = "";
        $this->half_price_2->EditValue = $this->half_price_2->CurrentValue;
        $this->half_price_2->PlaceHolder = RemoveHtml($this->half_price_2->caption());
        if (strval($this->half_price_2->EditValue) != "" && is_numeric($this->half_price_2->EditValue)) {
            $this->half_price_2->EditValue = FormatNumber($this->half_price_2->EditValue, null);
        }

        // status_pay_half_price_2
        $this->status_pay_half_price_2->setupEditAttributes();
        $this->status_pay_half_price_2->EditCustomAttributes = "";
        $this->status_pay_half_price_2->EditValue = $this->status_pay_half_price_2->options(true);
        $this->status_pay_half_price_2->PlaceHolder = RemoveHtml($this->status_pay_half_price_2->caption());

        // pay_number_half_price_2
        $this->pay_number_half_price_2->setupEditAttributes();
        $this->pay_number_half_price_2->EditCustomAttributes = "";
        if (!$this->pay_number_half_price_2->Raw) {
            $this->pay_number_half_price_2->CurrentValue = HtmlDecode($this->pay_number_half_price_2->CurrentValue);
        }
        $this->pay_number_half_price_2->EditValue = $this->pay_number_half_price_2->CurrentValue;
        $this->pay_number_half_price_2->PlaceHolder = RemoveHtml($this->pay_number_half_price_2->caption());

        // date_pay_half_price_2
        $this->date_pay_half_price_2->setupEditAttributes();
        $this->date_pay_half_price_2->EditCustomAttributes = "";
        $this->date_pay_half_price_2->EditValue = FormatDateTime($this->date_pay_half_price_2->CurrentValue, $this->date_pay_half_price_2->formatPattern());
        $this->date_pay_half_price_2->PlaceHolder = RemoveHtml($this->date_pay_half_price_2->caption());

        // due_date_pay_half_price_2
        $this->due_date_pay_half_price_2->setupEditAttributes();
        $this->due_date_pay_half_price_2->EditCustomAttributes = "";
        $this->due_date_pay_half_price_2->EditValue = FormatDateTime($this->due_date_pay_half_price_2->CurrentValue, $this->due_date_pay_half_price_2->formatPattern());
        $this->due_date_pay_half_price_2->PlaceHolder = RemoveHtml($this->due_date_pay_half_price_2->caption());

        // transaction_datetime1
        $this->transaction_datetime1->setupEditAttributes();
        $this->transaction_datetime1->EditCustomAttributes = "";
        $this->transaction_datetime1->EditValue = FormatDateTime($this->transaction_datetime1->CurrentValue, $this->transaction_datetime1->formatPattern());
        $this->transaction_datetime1->PlaceHolder = RemoveHtml($this->transaction_datetime1->caption());

        // payment_scheme1
        $this->payment_scheme1->setupEditAttributes();
        $this->payment_scheme1->EditCustomAttributes = "";
        if (!$this->payment_scheme1->Raw) {
            $this->payment_scheme1->CurrentValue = HtmlDecode($this->payment_scheme1->CurrentValue);
        }
        $this->payment_scheme1->EditValue = $this->payment_scheme1->CurrentValue;
        $this->payment_scheme1->PlaceHolder = RemoveHtml($this->payment_scheme1->caption());

        // transaction_ref1
        $this->transaction_ref1->setupEditAttributes();
        $this->transaction_ref1->EditCustomAttributes = "";
        if (!$this->transaction_ref1->Raw) {
            $this->transaction_ref1->CurrentValue = HtmlDecode($this->transaction_ref1->CurrentValue);
        }
        $this->transaction_ref1->EditValue = $this->transaction_ref1->CurrentValue;
        $this->transaction_ref1->PlaceHolder = RemoveHtml($this->transaction_ref1->caption());

        // channel_response_desc1
        $this->channel_response_desc1->setupEditAttributes();
        $this->channel_response_desc1->EditCustomAttributes = "";
        if (!$this->channel_response_desc1->Raw) {
            $this->channel_response_desc1->CurrentValue = HtmlDecode($this->channel_response_desc1->CurrentValue);
        }
        $this->channel_response_desc1->EditValue = $this->channel_response_desc1->CurrentValue;
        $this->channel_response_desc1->PlaceHolder = RemoveHtml($this->channel_response_desc1->caption());

        // res_status1
        $this->res_status1->setupEditAttributes();
        $this->res_status1->EditCustomAttributes = "";
        if (!$this->res_status1->Raw) {
            $this->res_status1->CurrentValue = HtmlDecode($this->res_status1->CurrentValue);
        }
        $this->res_status1->EditValue = $this->res_status1->CurrentValue;
        $this->res_status1->PlaceHolder = RemoveHtml($this->res_status1->caption());

        // res_referenceNo1
        $this->res_referenceNo1->setupEditAttributes();
        $this->res_referenceNo1->EditCustomAttributes = "";
        if (!$this->res_referenceNo1->Raw) {
            $this->res_referenceNo1->CurrentValue = HtmlDecode($this->res_referenceNo1->CurrentValue);
        }
        $this->res_referenceNo1->EditValue = $this->res_referenceNo1->CurrentValue;
        $this->res_referenceNo1->PlaceHolder = RemoveHtml($this->res_referenceNo1->caption());

        // transaction_datetime2
        $this->transaction_datetime2->setupEditAttributes();
        $this->transaction_datetime2->EditCustomAttributes = "";
        $this->transaction_datetime2->EditValue = FormatDateTime($this->transaction_datetime2->CurrentValue, $this->transaction_datetime2->formatPattern());
        $this->transaction_datetime2->PlaceHolder = RemoveHtml($this->transaction_datetime2->caption());

        // payment_scheme2
        $this->payment_scheme2->setupEditAttributes();
        $this->payment_scheme2->EditCustomAttributes = "";
        if (!$this->payment_scheme2->Raw) {
            $this->payment_scheme2->CurrentValue = HtmlDecode($this->payment_scheme2->CurrentValue);
        }
        $this->payment_scheme2->EditValue = $this->payment_scheme2->CurrentValue;
        $this->payment_scheme2->PlaceHolder = RemoveHtml($this->payment_scheme2->caption());

        // transaction_ref2
        $this->transaction_ref2->setupEditAttributes();
        $this->transaction_ref2->EditCustomAttributes = "";
        if (!$this->transaction_ref2->Raw) {
            $this->transaction_ref2->CurrentValue = HtmlDecode($this->transaction_ref2->CurrentValue);
        }
        $this->transaction_ref2->EditValue = $this->transaction_ref2->CurrentValue;
        $this->transaction_ref2->PlaceHolder = RemoveHtml($this->transaction_ref2->caption());

        // channel_response_desc2
        $this->channel_response_desc2->setupEditAttributes();
        $this->channel_response_desc2->EditCustomAttributes = "";
        if (!$this->channel_response_desc2->Raw) {
            $this->channel_response_desc2->CurrentValue = HtmlDecode($this->channel_response_desc2->CurrentValue);
        }
        $this->channel_response_desc2->EditValue = $this->channel_response_desc2->CurrentValue;
        $this->channel_response_desc2->PlaceHolder = RemoveHtml($this->channel_response_desc2->caption());

        // res_status2
        $this->res_status2->setupEditAttributes();
        $this->res_status2->EditCustomAttributes = "";
        if (!$this->res_status2->Raw) {
            $this->res_status2->CurrentValue = HtmlDecode($this->res_status2->CurrentValue);
        }
        $this->res_status2->EditValue = $this->res_status2->CurrentValue;
        $this->res_status2->PlaceHolder = RemoveHtml($this->res_status2->caption());

        // res_referenceNo2
        $this->res_referenceNo2->setupEditAttributes();
        $this->res_referenceNo2->EditCustomAttributes = "";
        if (!$this->res_referenceNo2->Raw) {
            $this->res_referenceNo2->CurrentValue = HtmlDecode($this->res_referenceNo2->CurrentValue);
        }
        $this->res_referenceNo2->EditValue = $this->res_referenceNo2->CurrentValue;
        $this->res_referenceNo2->PlaceHolder = RemoveHtml($this->res_referenceNo2->caption());

        // status_approve
        $this->status_approve->setupEditAttributes();
        $this->status_approve->EditCustomAttributes = "";
        $this->status_approve->EditValue = $this->status_approve->CurrentValue;
        $this->status_approve->PlaceHolder = RemoveHtml($this->status_approve->caption());
        if (strval($this->status_approve->EditValue) != "" && is_numeric($this->status_approve->EditValue)) {
            $this->status_approve->EditValue = FormatNumber($this->status_approve->EditValue, null);
        }

        // cdate

        // cip

        // cuser

        // uuser

        // uip

        // udate

        // res_paidAgent1
        $this->res_paidAgent1->setupEditAttributes();
        $this->res_paidAgent1->EditCustomAttributes = "";
        if (!$this->res_paidAgent1->Raw) {
            $this->res_paidAgent1->CurrentValue = HtmlDecode($this->res_paidAgent1->CurrentValue);
        }
        $this->res_paidAgent1->EditValue = $this->res_paidAgent1->CurrentValue;
        $this->res_paidAgent1->PlaceHolder = RemoveHtml($this->res_paidAgent1->caption());

        // res_paidChannel1
        $this->res_paidChannel1->setupEditAttributes();
        $this->res_paidChannel1->EditCustomAttributes = "";
        if (!$this->res_paidChannel1->Raw) {
            $this->res_paidChannel1->CurrentValue = HtmlDecode($this->res_paidChannel1->CurrentValue);
        }
        $this->res_paidChannel1->EditValue = $this->res_paidChannel1->CurrentValue;
        $this->res_paidChannel1->PlaceHolder = RemoveHtml($this->res_paidChannel1->caption());

        // res_maskedPan1
        $this->res_maskedPan1->setupEditAttributes();
        $this->res_maskedPan1->EditCustomAttributes = "";
        if (!$this->res_maskedPan1->Raw) {
            $this->res_maskedPan1->CurrentValue = HtmlDecode($this->res_maskedPan1->CurrentValue);
        }
        $this->res_maskedPan1->EditValue = $this->res_maskedPan1->CurrentValue;
        $this->res_maskedPan1->PlaceHolder = RemoveHtml($this->res_maskedPan1->caption());

        // res_paidAgent2
        $this->res_paidAgent2->setupEditAttributes();
        $this->res_paidAgent2->EditCustomAttributes = "";
        if (!$this->res_paidAgent2->Raw) {
            $this->res_paidAgent2->CurrentValue = HtmlDecode($this->res_paidAgent2->CurrentValue);
        }
        $this->res_paidAgent2->EditValue = $this->res_paidAgent2->CurrentValue;
        $this->res_paidAgent2->PlaceHolder = RemoveHtml($this->res_paidAgent2->caption());

        // res_paidChannel2
        $this->res_paidChannel2->setupEditAttributes();
        $this->res_paidChannel2->EditCustomAttributes = "";
        if (!$this->res_paidChannel2->Raw) {
            $this->res_paidChannel2->CurrentValue = HtmlDecode($this->res_paidChannel2->CurrentValue);
        }
        $this->res_paidChannel2->EditValue = $this->res_paidChannel2->CurrentValue;
        $this->res_paidChannel2->PlaceHolder = RemoveHtml($this->res_paidChannel2->caption());

        // res_maskedPan2
        $this->res_maskedPan2->setupEditAttributes();
        $this->res_maskedPan2->EditCustomAttributes = "";
        if (!$this->res_maskedPan2->Raw) {
            $this->res_maskedPan2->CurrentValue = HtmlDecode($this->res_maskedPan2->CurrentValue);
        }
        $this->res_maskedPan2->EditValue = $this->res_maskedPan2->CurrentValue;
        $this->res_maskedPan2->PlaceHolder = RemoveHtml($this->res_maskedPan2->caption());

        // is_email1
        $this->is_email1->setupEditAttributes();
        $this->is_email1->EditCustomAttributes = "";
        $this->is_email1->EditValue = $this->is_email1->CurrentValue;
        $this->is_email1->PlaceHolder = RemoveHtml($this->is_email1->caption());
        if (strval($this->is_email1->EditValue) != "" && is_numeric($this->is_email1->EditValue)) {
            $this->is_email1->EditValue = FormatNumber($this->is_email1->EditValue, null);
        }

        // is_email2
        $this->is_email2->setupEditAttributes();
        $this->is_email2->EditCustomAttributes = "";
        $this->is_email2->EditValue = $this->is_email2->CurrentValue;
        $this->is_email2->PlaceHolder = RemoveHtml($this->is_email2->caption());
        if (strval($this->is_email2->EditValue) != "" && is_numeric($this->is_email2->EditValue)) {
            $this->is_email2->EditValue = FormatNumber($this->is_email2->EditValue, null);
        }

        // receipt_status1
        $this->receipt_status1->setupEditAttributes();
        $this->receipt_status1->EditCustomAttributes = "";
        $this->receipt_status1->EditValue = $this->receipt_status1->CurrentValue;
        $this->receipt_status1->PlaceHolder = RemoveHtml($this->receipt_status1->caption());
        if (strval($this->receipt_status1->EditValue) != "" && is_numeric($this->receipt_status1->EditValue)) {
            $this->receipt_status1->EditValue = FormatNumber($this->receipt_status1->EditValue, null);
        }

        // receipt_status2
        $this->receipt_status2->setupEditAttributes();
        $this->receipt_status2->EditCustomAttributes = "";
        $this->receipt_status2->EditValue = $this->receipt_status2->CurrentValue;
        $this->receipt_status2->PlaceHolder = RemoveHtml($this->receipt_status2->caption());
        if (strval($this->receipt_status2->EditValue) != "" && is_numeric($this->receipt_status2->EditValue)) {
            $this->receipt_status2->EditValue = FormatNumber($this->receipt_status2->EditValue, null);
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
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->one_time_status);
                    $doc->exportCaption($this->half_price_1);
                    $doc->exportCaption($this->status_pay_half_price_1);
                    $doc->exportCaption($this->pay_number_half_price_1);
                    $doc->exportCaption($this->date_pay_half_price_1);
                    $doc->exportCaption($this->due_date_pay_half_price_1);
                    $doc->exportCaption($this->half_price_2);
                    $doc->exportCaption($this->status_pay_half_price_2);
                    $doc->exportCaption($this->pay_number_half_price_2);
                    $doc->exportCaption($this->date_pay_half_price_2);
                    $doc->exportCaption($this->due_date_pay_half_price_2);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->one_time_status);
                    $doc->exportCaption($this->half_price_1);
                    $doc->exportCaption($this->status_pay_half_price_1);
                    $doc->exportCaption($this->pay_number_half_price_1);
                    $doc->exportCaption($this->date_pay_half_price_1);
                    $doc->exportCaption($this->due_date_pay_half_price_1);
                    $doc->exportCaption($this->half_price_2);
                    $doc->exportCaption($this->status_pay_half_price_2);
                    $doc->exportCaption($this->pay_number_half_price_2);
                    $doc->exportCaption($this->date_pay_half_price_2);
                    $doc->exportCaption($this->due_date_pay_half_price_2);
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
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->one_time_status);
                        $doc->exportField($this->half_price_1);
                        $doc->exportField($this->status_pay_half_price_1);
                        $doc->exportField($this->pay_number_half_price_1);
                        $doc->exportField($this->date_pay_half_price_1);
                        $doc->exportField($this->due_date_pay_half_price_1);
                        $doc->exportField($this->half_price_2);
                        $doc->exportField($this->status_pay_half_price_2);
                        $doc->exportField($this->pay_number_half_price_2);
                        $doc->exportField($this->date_pay_half_price_2);
                        $doc->exportField($this->due_date_pay_half_price_2);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->one_time_status);
                        $doc->exportField($this->half_price_1);
                        $doc->exportField($this->status_pay_half_price_1);
                        $doc->exportField($this->pay_number_half_price_1);
                        $doc->exportField($this->date_pay_half_price_1);
                        $doc->exportField($this->due_date_pay_half_price_1);
                        $doc->exportField($this->half_price_2);
                        $doc->exportField($this->status_pay_half_price_2);
                        $doc->exportField($this->pay_number_half_price_2);
                        $doc->exportField($this->date_pay_half_price_2);
                        $doc->exportField($this->due_date_pay_half_price_2);
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
        // No binary fields
        return false;
    }

    // Write Audit Trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        $table = 'buyer_asset_rent';
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
        $table = 'buyer_asset_rent';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['buyer_asset_rent_id'];

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
        $table = 'buyer_asset_rent';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['buyer_asset_rent_id'];

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
        $table = 'buyer_asset_rent';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['buyer_asset_rent_id'];

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
