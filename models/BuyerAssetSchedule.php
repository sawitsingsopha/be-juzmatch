<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for buyer_asset_schedule
 */
class BuyerAssetSchedule extends DbTable
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
    public $buyer_asset_schedule_id;
    public $asset_id;
    public $member_id;
    public $num_installment;
    public $installment_per_price;
    public $receive_per_installment;
    public $receive_per_installment_invertor;
    public $pay_number;
    public $expired_date;
    public $date_payment;
    public $status_payment;
    public $transaction_datetime;
    public $payment_scheme;
    public $transaction_ref;
    public $channel_response_desc;
    public $res_status;
    public $res_referenceNo;
    public $installment_all;
    public $cdate;
    public $cuser;
    public $cip;
    public $uuser;
    public $udate;
    public $uip;
    public $res_paidAgent;
    public $res_paidChannel;
    public $res_maskedPan;
    public $buyer_config_asset_schedule_id;
    public $interest;
    public $principal;
    public $remaining_principal;
    public $is_email;
    public $receipt_status;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'buyer_asset_schedule';
        $this->TableName = 'buyer_asset_schedule';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`buyer_asset_schedule`";
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

        // buyer_asset_schedule_id
        $this->buyer_asset_schedule_id = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_buyer_asset_schedule_id',
            'buyer_asset_schedule_id',
            '`buyer_asset_schedule_id`',
            '`buyer_asset_schedule_id`',
            3,
            11,
            -1,
            false,
            '`buyer_asset_schedule_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->buyer_asset_schedule_id->InputTextType = "text";
        $this->buyer_asset_schedule_id->IsAutoIncrement = true; // Autoincrement field
        $this->buyer_asset_schedule_id->IsPrimaryKey = true; // Primary key field
        $this->buyer_asset_schedule_id->Sortable = false; // Allow sort
        $this->buyer_asset_schedule_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buyer_asset_schedule_id'] = &$this->buyer_asset_schedule_id;

        // asset_id
        $this->asset_id = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // num_installment
        $this->num_installment = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_num_installment',
            'num_installment',
            '`num_installment`',
            '`num_installment`',
            3,
            11,
            -1,
            false,
            '`num_installment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->num_installment->InputTextType = "text";
        $this->num_installment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['num_installment'] = &$this->num_installment;

        // installment_per_price
        $this->installment_per_price = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_installment_per_price',
            'installment_per_price',
            '`installment_per_price`',
            '`installment_per_price`',
            4,
            12,
            -1,
            false,
            '`installment_per_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment_per_price->InputTextType = "text";
        $this->installment_per_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['installment_per_price'] = &$this->installment_per_price;

        // receive_per_installment
        $this->receive_per_installment = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_receive_per_installment',
            'receive_per_installment',
            '`receive_per_installment`',
            '`receive_per_installment`',
            4,
            12,
            -1,
            false,
            '`receive_per_installment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receive_per_installment->InputTextType = "text";
        $this->receive_per_installment->Sortable = false; // Allow sort
        $this->receive_per_installment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['receive_per_installment'] = &$this->receive_per_installment;

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_receive_per_installment_invertor',
            'receive_per_installment_invertor',
            '`receive_per_installment_invertor`',
            '`receive_per_installment_invertor`',
            4,
            12,
            -1,
            false,
            '`receive_per_installment_invertor`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receive_per_installment_invertor->InputTextType = "text";
        $this->receive_per_installment_invertor->Sortable = false; // Allow sort
        $this->receive_per_installment_invertor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['receive_per_installment_invertor'] = &$this->receive_per_installment_invertor;

        // pay_number
        $this->pay_number = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_pay_number',
            'pay_number',
            '`pay_number`',
            '`pay_number`',
            200,
            255,
            -1,
            false,
            '`pay_number`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->pay_number->InputTextType = "text";
        $this->Fields['pay_number'] = &$this->pay_number;

        // expired_date
        $this->expired_date = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_expired_date',
            'expired_date',
            '`expired_date`',
            CastDateFieldForLike("`expired_date`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`expired_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->expired_date->InputTextType = "text";
        $this->expired_date->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['expired_date'] = &$this->expired_date;

        // date_payment
        $this->date_payment = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_date_payment',
            'date_payment',
            '`date_payment`',
            CastDateFieldForLike("`date_payment`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`date_payment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date_payment->InputTextType = "text";
        $this->date_payment->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['date_payment'] = &$this->date_payment;

        // status_payment
        $this->status_payment = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_status_payment',
            'status_payment',
            '`status_payment`',
            '`status_payment`',
            3,
            11,
            -1,
            false,
            '`status_payment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->status_payment->InputTextType = "text";
        $this->status_payment->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_payment->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_payment->Lookup = new Lookup('status_payment', 'buyer_asset_schedule', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_payment->OptionCount = 3;
        $this->status_payment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_payment'] = &$this->status_payment;

        // transaction_datetime
        $this->transaction_datetime = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_transaction_datetime',
            'transaction_datetime',
            '`transaction_datetime`',
            CastDateFieldForLike("`transaction_datetime`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`transaction_datetime`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transaction_datetime->InputTextType = "text";
        $this->transaction_datetime->Sortable = false; // Allow sort
        $this->transaction_datetime->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['transaction_datetime'] = &$this->transaction_datetime;

        // payment_scheme
        $this->payment_scheme = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_payment_scheme',
            'payment_scheme',
            '`payment_scheme`',
            '`payment_scheme`',
            200,
            50,
            -1,
            false,
            '`payment_scheme`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->payment_scheme->InputTextType = "text";
        $this->payment_scheme->Sortable = false; // Allow sort
        $this->Fields['payment_scheme'] = &$this->payment_scheme;

        // transaction_ref
        $this->transaction_ref = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_transaction_ref',
            'transaction_ref',
            '`transaction_ref`',
            '`transaction_ref`',
            200,
            255,
            -1,
            false,
            '`transaction_ref`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transaction_ref->InputTextType = "text";
        $this->transaction_ref->Sortable = false; // Allow sort
        $this->Fields['transaction_ref'] = &$this->transaction_ref;

        // channel_response_desc
        $this->channel_response_desc = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_channel_response_desc',
            'channel_response_desc',
            '`channel_response_desc`',
            '`channel_response_desc`',
            200,
            255,
            -1,
            false,
            '`channel_response_desc`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->channel_response_desc->InputTextType = "text";
        $this->channel_response_desc->Sortable = false; // Allow sort
        $this->Fields['channel_response_desc'] = &$this->channel_response_desc;

        // res_status
        $this->res_status = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_res_status',
            'res_status',
            '`res_status`',
            '`res_status`',
            200,
            50,
            -1,
            false,
            '`res_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_status->InputTextType = "text";
        $this->res_status->Sortable = false; // Allow sort
        $this->Fields['res_status'] = &$this->res_status;

        // res_referenceNo
        $this->res_referenceNo = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_res_referenceNo',
            'res_referenceNo',
            '`res_referenceNo`',
            '`res_referenceNo`',
            200,
            255,
            -1,
            false,
            '`res_referenceNo`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_referenceNo->InputTextType = "text";
        $this->res_referenceNo->Sortable = false; // Allow sort
        $this->Fields['res_referenceNo'] = &$this->res_referenceNo;

        // installment_all
        $this->installment_all = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // cdate
        $this->cdate = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // cip
        $this->cip = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // uuser
        $this->uuser = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // udate
        $this->udate = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // uip
        $this->uip = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
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

        // res_paidAgent
        $this->res_paidAgent = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_res_paidAgent',
            'res_paidAgent',
            '`res_paidAgent`',
            '`res_paidAgent`',
            200,
            100,
            -1,
            false,
            '`res_paidAgent`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_paidAgent->InputTextType = "text";
        $this->res_paidAgent->Sortable = false; // Allow sort
        $this->Fields['res_paidAgent'] = &$this->res_paidAgent;

        // res_paidChannel
        $this->res_paidChannel = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_res_paidChannel',
            'res_paidChannel',
            '`res_paidChannel`',
            '`res_paidChannel`',
            200,
            100,
            -1,
            false,
            '`res_paidChannel`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_paidChannel->InputTextType = "text";
        $this->res_paidChannel->Sortable = false; // Allow sort
        $this->Fields['res_paidChannel'] = &$this->res_paidChannel;

        // res_maskedPan
        $this->res_maskedPan = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_res_maskedPan',
            'res_maskedPan',
            '`res_maskedPan`',
            '`res_maskedPan`',
            200,
            100,
            -1,
            false,
            '`res_maskedPan`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->res_maskedPan->InputTextType = "text";
        $this->res_maskedPan->Sortable = false; // Allow sort
        $this->Fields['res_maskedPan'] = &$this->res_maskedPan;

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_buyer_config_asset_schedule_id',
            'buyer_config_asset_schedule_id',
            '`buyer_config_asset_schedule_id`',
            '`buyer_config_asset_schedule_id`',
            3,
            11,
            -1,
            false,
            '`buyer_config_asset_schedule_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->buyer_config_asset_schedule_id->InputTextType = "text";
        $this->buyer_config_asset_schedule_id->Sortable = false; // Allow sort
        $this->buyer_config_asset_schedule_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buyer_config_asset_schedule_id'] = &$this->buyer_config_asset_schedule_id;

        // interest
        $this->interest = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_interest',
            'interest',
            '`interest`',
            '`interest`',
            4,
            12,
            -1,
            false,
            '`interest`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->interest->InputTextType = "text";
        $this->interest->Sortable = false; // Allow sort
        $this->interest->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['interest'] = &$this->interest;

        // principal
        $this->principal = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_principal',
            'principal',
            '`principal`',
            '`principal`',
            4,
            12,
            -1,
            false,
            '`principal`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->principal->InputTextType = "text";
        $this->principal->Sortable = false; // Allow sort
        $this->principal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['principal'] = &$this->principal;

        // remaining_principal
        $this->remaining_principal = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_remaining_principal',
            'remaining_principal',
            '`remaining_principal`',
            '`remaining_principal`',
            5,
            22,
            -1,
            false,
            '`remaining_principal`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remaining_principal->InputTextType = "text";
        $this->remaining_principal->Sortable = false; // Allow sort
        $this->remaining_principal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remaining_principal'] = &$this->remaining_principal;

        // is_email
        $this->is_email = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_is_email',
            'is_email',
            '`is_email`',
            '`is_email`',
            3,
            11,
            -1,
            false,
            '`is_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->is_email->InputTextType = "text";
        $this->is_email->Nullable = false; // NOT NULL field
        $this->is_email->Sortable = false; // Allow sort
        $this->is_email->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['is_email'] = &$this->is_email;

        // receipt_status
        $this->receipt_status = new DbField(
            'buyer_asset_schedule',
            'buyer_asset_schedule',
            'x_receipt_status',
            'receipt_status',
            '`receipt_status`',
            '`receipt_status`',
            3,
            11,
            -1,
            false,
            '`receipt_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receipt_status->InputTextType = "text";
        $this->receipt_status->Nullable = false; // NOT NULL field
        $this->receipt_status->Sortable = false; // Allow sort
        $this->receipt_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receipt_status'] = &$this->receipt_status;

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
        if ($this->getCurrentMasterTable() == "buyer_config_asset_schedule") {
            if ($this->member_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
            if ($this->asset_id->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "buyer_config_asset_schedule") {
            if ($this->member_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
            if ($this->asset_id->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "DB");
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
            case "buyer_config_asset_schedule":
                $key = $keys["member_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->member_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
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
                    return "`member_id`=" . QuotedValue($keys["member_id"], $masterTable->member_id->DataType, $masterTable->Dbid) . " AND `asset_id`=" . QuotedValue($keys["asset_id"], $masterTable->asset_id->DataType, $masterTable->Dbid);
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
            case "buyer_config_asset_schedule":
                return "`member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid) . " AND `asset_id`=" . QuotedValue($masterTable->asset_id->DbValue, $this->asset_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`buyer_asset_schedule`";
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
            $this->buyer_asset_schedule_id->setDbValue($conn->lastInsertId());
            $rs['buyer_asset_schedule_id'] = $this->buyer_asset_schedule_id->DbValue;
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
            $fldname = 'buyer_asset_schedule_id';
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
            if (array_key_exists('buyer_asset_schedule_id', $rs)) {
                AddFilter($where, QuotedName('buyer_asset_schedule_id', $this->Dbid) . '=' . QuotedValue($rs['buyer_asset_schedule_id'], $this->buyer_asset_schedule_id->DataType, $this->Dbid));
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
        $this->buyer_asset_schedule_id->DbValue = $row['buyer_asset_schedule_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->num_installment->DbValue = $row['num_installment'];
        $this->installment_per_price->DbValue = $row['installment_per_price'];
        $this->receive_per_installment->DbValue = $row['receive_per_installment'];
        $this->receive_per_installment_invertor->DbValue = $row['receive_per_installment_invertor'];
        $this->pay_number->DbValue = $row['pay_number'];
        $this->expired_date->DbValue = $row['expired_date'];
        $this->date_payment->DbValue = $row['date_payment'];
        $this->status_payment->DbValue = $row['status_payment'];
        $this->transaction_datetime->DbValue = $row['transaction_datetime'];
        $this->payment_scheme->DbValue = $row['payment_scheme'];
        $this->transaction_ref->DbValue = $row['transaction_ref'];
        $this->channel_response_desc->DbValue = $row['channel_response_desc'];
        $this->res_status->DbValue = $row['res_status'];
        $this->res_referenceNo->DbValue = $row['res_referenceNo'];
        $this->installment_all->DbValue = $row['installment_all'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->uuser->DbValue = $row['uuser'];
        $this->udate->DbValue = $row['udate'];
        $this->uip->DbValue = $row['uip'];
        $this->res_paidAgent->DbValue = $row['res_paidAgent'];
        $this->res_paidChannel->DbValue = $row['res_paidChannel'];
        $this->res_maskedPan->DbValue = $row['res_maskedPan'];
        $this->buyer_config_asset_schedule_id->DbValue = $row['buyer_config_asset_schedule_id'];
        $this->interest->DbValue = $row['interest'];
        $this->principal->DbValue = $row['principal'];
        $this->remaining_principal->DbValue = $row['remaining_principal'];
        $this->is_email->DbValue = $row['is_email'];
        $this->receipt_status->DbValue = $row['receipt_status'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`buyer_asset_schedule_id` = @buyer_asset_schedule_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->buyer_asset_schedule_id->CurrentValue : $this->buyer_asset_schedule_id->OldValue;
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
                $this->buyer_asset_schedule_id->CurrentValue = $keys[0];
            } else {
                $this->buyer_asset_schedule_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('buyer_asset_schedule_id', $row) ? $row['buyer_asset_schedule_id'] : null;
        } else {
            $val = $this->buyer_asset_schedule_id->OldValue !== null ? $this->buyer_asset_schedule_id->OldValue : $this->buyer_asset_schedule_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@buyer_asset_schedule_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("buyerassetschedulelist");
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
        if ($pageName == "buyerassetscheduleview") {
            return $Language->phrase("View");
        } elseif ($pageName == "buyerassetscheduleedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "buyerassetscheduleadd") {
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
                return "BuyerAssetScheduleView";
            case Config("API_ADD_ACTION"):
                return "BuyerAssetScheduleAdd";
            case Config("API_EDIT_ACTION"):
                return "BuyerAssetScheduleEdit";
            case Config("API_DELETE_ACTION"):
                return "BuyerAssetScheduleDelete";
            case Config("API_LIST_ACTION"):
                return "BuyerAssetScheduleList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "buyerassetschedulelist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("buyerassetscheduleview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyerassetscheduleview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "buyerassetscheduleadd?" . $this->getUrlParm($parm);
        } else {
            $url = "buyerassetscheduleadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("buyerassetscheduleedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("buyerassetscheduleadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("buyerassetscheduledelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "buyer_asset" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "buyer_config_asset_schedule" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"buyer_asset_schedule_id\":" . JsonEncode($this->buyer_asset_schedule_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->buyer_asset_schedule_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->buyer_asset_schedule_id->CurrentValue);
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
            if (($keyValue = Param("buyer_asset_schedule_id") ?? Route("buyer_asset_schedule_id")) !== null) {
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
                $this->buyer_asset_schedule_id->CurrentValue = $key;
            } else {
                $this->buyer_asset_schedule_id->OldValue = $key;
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
        $this->buyer_asset_schedule_id->setDbValue($row['buyer_asset_schedule_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->num_installment->setDbValue($row['num_installment']);
        $this->installment_per_price->setDbValue($row['installment_per_price']);
        $this->receive_per_installment->setDbValue($row['receive_per_installment']);
        $this->receive_per_installment_invertor->setDbValue($row['receive_per_installment_invertor']);
        $this->pay_number->setDbValue($row['pay_number']);
        $this->expired_date->setDbValue($row['expired_date']);
        $this->date_payment->setDbValue($row['date_payment']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->udate->setDbValue($row['udate']);
        $this->uip->setDbValue($row['uip']);
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
        $this->buyer_config_asset_schedule_id->setDbValue($row['buyer_config_asset_schedule_id']);
        $this->interest->setDbValue($row['interest']);
        $this->principal->setDbValue($row['principal']);
        $this->remaining_principal->setDbValue($row['remaining_principal']);
        $this->is_email->setDbValue($row['is_email']);
        $this->receipt_status->setDbValue($row['receipt_status']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // buyer_asset_schedule_id
        $this->buyer_asset_schedule_id->CellCssStyle = "white-space: nowrap;";

        // asset_id

        // member_id

        // num_installment

        // installment_per_price

        // receive_per_installment
        $this->receive_per_installment->CellCssStyle = "white-space: nowrap;";

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor->CellCssStyle = "white-space: nowrap;";

        // pay_number

        // expired_date

        // date_payment

        // status_payment

        // transaction_datetime
        $this->transaction_datetime->CellCssStyle = "white-space: nowrap;";

        // payment_scheme
        $this->payment_scheme->CellCssStyle = "white-space: nowrap;";

        // transaction_ref
        $this->transaction_ref->CellCssStyle = "white-space: nowrap;";

        // channel_response_desc
        $this->channel_response_desc->CellCssStyle = "white-space: nowrap;";

        // res_status
        $this->res_status->CellCssStyle = "white-space: nowrap;";

        // res_referenceNo
        $this->res_referenceNo->CellCssStyle = "white-space: nowrap;";

        // installment_all

        // cdate

        // cuser

        // cip

        // uuser

        // udate

        // uip

        // res_paidAgent
        $this->res_paidAgent->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel
        $this->res_paidChannel->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan
        $this->res_maskedPan->CellCssStyle = "white-space: nowrap;";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->CellCssStyle = "white-space: nowrap;";

        // interest
        $this->interest->CellCssStyle = "white-space: nowrap;";

        // principal
        $this->principal->CellCssStyle = "white-space: nowrap;";

        // remaining_principal
        $this->remaining_principal->CellCssStyle = "white-space: nowrap;";

        // is_email
        $this->is_email->CellCssStyle = "white-space: nowrap;";

        // receipt_status
        $this->receipt_status->CellCssStyle = "white-space: nowrap;";

        // buyer_asset_schedule_id
        $this->buyer_asset_schedule_id->ViewValue = $this->buyer_asset_schedule_id->CurrentValue;
        $this->buyer_asset_schedule_id->ViewCustomAttributes = "";

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

        // num_installment
        $this->num_installment->ViewValue = $this->num_installment->CurrentValue;
        $this->num_installment->ViewValue = FormatNumber($this->num_installment->ViewValue, $this->num_installment->formatPattern());
        $this->num_installment->ViewCustomAttributes = "";

        // installment_per_price
        $this->installment_per_price->ViewValue = $this->installment_per_price->CurrentValue;
        $this->installment_per_price->ViewValue = FormatCurrency($this->installment_per_price->ViewValue, $this->installment_per_price->formatPattern());
        $this->installment_per_price->ViewCustomAttributes = "";

        // receive_per_installment
        $this->receive_per_installment->ViewValue = $this->receive_per_installment->CurrentValue;
        $this->receive_per_installment->ViewValue = FormatNumber($this->receive_per_installment->ViewValue, $this->receive_per_installment->formatPattern());
        $this->receive_per_installment->ViewCustomAttributes = "";

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor->ViewValue = $this->receive_per_installment_invertor->CurrentValue;
        $this->receive_per_installment_invertor->ViewValue = FormatNumber($this->receive_per_installment_invertor->ViewValue, $this->receive_per_installment_invertor->formatPattern());
        $this->receive_per_installment_invertor->ViewCustomAttributes = "";

        // pay_number
        $this->pay_number->ViewValue = $this->pay_number->CurrentValue;
        $this->pay_number->ViewCustomAttributes = "";

        // expired_date
        $this->expired_date->ViewValue = $this->expired_date->CurrentValue;
        $this->expired_date->ViewValue = FormatDateTime($this->expired_date->ViewValue, $this->expired_date->formatPattern());
        $this->expired_date->ViewCustomAttributes = "";

        // date_payment
        $this->date_payment->ViewValue = $this->date_payment->CurrentValue;
        $this->date_payment->ViewValue = FormatDateTime($this->date_payment->ViewValue, $this->date_payment->formatPattern());
        $this->date_payment->ViewCustomAttributes = "";

        // status_payment
        if (strval($this->status_payment->CurrentValue) != "") {
            $this->status_payment->ViewValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
        } else {
            $this->status_payment->ViewValue = null;
        }
        $this->status_payment->ViewCustomAttributes = "";

        // transaction_datetime
        $this->transaction_datetime->ViewValue = $this->transaction_datetime->CurrentValue;
        $this->transaction_datetime->ViewValue = FormatDateTime($this->transaction_datetime->ViewValue, $this->transaction_datetime->formatPattern());
        $this->transaction_datetime->ViewCustomAttributes = "";

        // payment_scheme
        $this->payment_scheme->ViewValue = $this->payment_scheme->CurrentValue;
        $this->payment_scheme->ViewCustomAttributes = "";

        // transaction_ref
        $this->transaction_ref->ViewValue = $this->transaction_ref->CurrentValue;
        $this->transaction_ref->ViewCustomAttributes = "";

        // channel_response_desc
        $this->channel_response_desc->ViewValue = $this->channel_response_desc->CurrentValue;
        $this->channel_response_desc->ViewCustomAttributes = "";

        // res_status
        $this->res_status->ViewValue = $this->res_status->CurrentValue;
        $this->res_status->ViewCustomAttributes = "";

        // res_referenceNo
        $this->res_referenceNo->ViewValue = $this->res_referenceNo->CurrentValue;
        $this->res_referenceNo->ViewCustomAttributes = "";

        // installment_all
        $this->installment_all->ViewValue = $this->installment_all->CurrentValue;
        $this->installment_all->ViewValue = FormatNumber($this->installment_all->ViewValue, $this->installment_all->formatPattern());
        $this->installment_all->ViewCustomAttributes = "";

        // cdate
        $this->cdate->ViewValue = $this->cdate->CurrentValue;
        $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
        $this->cdate->ViewCustomAttributes = "";

        // cuser
        $this->cuser->ViewValue = $this->cuser->CurrentValue;
        $this->cuser->ViewCustomAttributes = "";

        // cip
        $this->cip->ViewValue = $this->cip->CurrentValue;
        $this->cip->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewCustomAttributes = "";

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // res_paidAgent
        $this->res_paidAgent->ViewValue = $this->res_paidAgent->CurrentValue;
        $this->res_paidAgent->ViewCustomAttributes = "";

        // res_paidChannel
        $this->res_paidChannel->ViewValue = $this->res_paidChannel->CurrentValue;
        $this->res_paidChannel->ViewCustomAttributes = "";

        // res_maskedPan
        $this->res_maskedPan->ViewValue = $this->res_maskedPan->CurrentValue;
        $this->res_maskedPan->ViewCustomAttributes = "";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->ViewValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->ViewValue = FormatNumber($this->buyer_config_asset_schedule_id->ViewValue, $this->buyer_config_asset_schedule_id->formatPattern());
        $this->buyer_config_asset_schedule_id->ViewCustomAttributes = "";

        // interest
        $this->interest->ViewValue = $this->interest->CurrentValue;
        $this->interest->ViewValue = FormatNumber($this->interest->ViewValue, $this->interest->formatPattern());
        $this->interest->ViewCustomAttributes = "";

        // principal
        $this->principal->ViewValue = $this->principal->CurrentValue;
        $this->principal->ViewValue = FormatNumber($this->principal->ViewValue, $this->principal->formatPattern());
        $this->principal->ViewCustomAttributes = "";

        // remaining_principal
        $this->remaining_principal->ViewValue = $this->remaining_principal->CurrentValue;
        $this->remaining_principal->ViewValue = FormatNumber($this->remaining_principal->ViewValue, $this->remaining_principal->formatPattern());
        $this->remaining_principal->ViewCustomAttributes = "";

        // is_email
        $this->is_email->ViewValue = $this->is_email->CurrentValue;
        $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
        $this->is_email->ViewCustomAttributes = "";

        // receipt_status
        $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
        $this->receipt_status->ViewValue = FormatNumber($this->receipt_status->ViewValue, $this->receipt_status->formatPattern());
        $this->receipt_status->ViewCustomAttributes = "";

        // buyer_asset_schedule_id
        $this->buyer_asset_schedule_id->LinkCustomAttributes = "";
        $this->buyer_asset_schedule_id->HrefValue = "";
        $this->buyer_asset_schedule_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // num_installment
        $this->num_installment->LinkCustomAttributes = "";
        $this->num_installment->HrefValue = "";
        $this->num_installment->TooltipValue = "";

        // installment_per_price
        $this->installment_per_price->LinkCustomAttributes = "";
        $this->installment_per_price->HrefValue = "";
        $this->installment_per_price->TooltipValue = "";

        // receive_per_installment
        $this->receive_per_installment->LinkCustomAttributes = "";
        $this->receive_per_installment->HrefValue = "";
        $this->receive_per_installment->TooltipValue = "";

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor->LinkCustomAttributes = "";
        $this->receive_per_installment_invertor->HrefValue = "";
        $this->receive_per_installment_invertor->TooltipValue = "";

        // pay_number
        $this->pay_number->LinkCustomAttributes = "";
        $this->pay_number->HrefValue = "";
        $this->pay_number->TooltipValue = "";

        // expired_date
        $this->expired_date->LinkCustomAttributes = "";
        $this->expired_date->HrefValue = "";
        $this->expired_date->TooltipValue = "";

        // date_payment
        $this->date_payment->LinkCustomAttributes = "";
        $this->date_payment->HrefValue = "";
        $this->date_payment->TooltipValue = "";

        // status_payment
        $this->status_payment->LinkCustomAttributes = "";
        $this->status_payment->HrefValue = "";
        $this->status_payment->TooltipValue = "";

        // transaction_datetime
        $this->transaction_datetime->LinkCustomAttributes = "";
        $this->transaction_datetime->HrefValue = "";
        $this->transaction_datetime->TooltipValue = "";

        // payment_scheme
        $this->payment_scheme->LinkCustomAttributes = "";
        $this->payment_scheme->HrefValue = "";
        $this->payment_scheme->TooltipValue = "";

        // transaction_ref
        $this->transaction_ref->LinkCustomAttributes = "";
        $this->transaction_ref->HrefValue = "";
        $this->transaction_ref->TooltipValue = "";

        // channel_response_desc
        $this->channel_response_desc->LinkCustomAttributes = "";
        $this->channel_response_desc->HrefValue = "";
        $this->channel_response_desc->TooltipValue = "";

        // res_status
        $this->res_status->LinkCustomAttributes = "";
        $this->res_status->HrefValue = "";
        $this->res_status->TooltipValue = "";

        // res_referenceNo
        $this->res_referenceNo->LinkCustomAttributes = "";
        $this->res_referenceNo->HrefValue = "";
        $this->res_referenceNo->TooltipValue = "";

        // installment_all
        $this->installment_all->LinkCustomAttributes = "";
        $this->installment_all->HrefValue = "";
        $this->installment_all->TooltipValue = "";

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

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // res_paidAgent
        $this->res_paidAgent->LinkCustomAttributes = "";
        $this->res_paidAgent->HrefValue = "";
        $this->res_paidAgent->TooltipValue = "";

        // res_paidChannel
        $this->res_paidChannel->LinkCustomAttributes = "";
        $this->res_paidChannel->HrefValue = "";
        $this->res_paidChannel->TooltipValue = "";

        // res_maskedPan
        $this->res_maskedPan->LinkCustomAttributes = "";
        $this->res_maskedPan->HrefValue = "";
        $this->res_maskedPan->TooltipValue = "";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->LinkCustomAttributes = "";
        $this->buyer_config_asset_schedule_id->HrefValue = "";
        $this->buyer_config_asset_schedule_id->TooltipValue = "";

        // interest
        $this->interest->LinkCustomAttributes = "";
        $this->interest->HrefValue = "";
        $this->interest->TooltipValue = "";

        // principal
        $this->principal->LinkCustomAttributes = "";
        $this->principal->HrefValue = "";
        $this->principal->TooltipValue = "";

        // remaining_principal
        $this->remaining_principal->LinkCustomAttributes = "";
        $this->remaining_principal->HrefValue = "";
        $this->remaining_principal->TooltipValue = "";

        // is_email
        $this->is_email->LinkCustomAttributes = "";
        $this->is_email->HrefValue = "";
        $this->is_email->TooltipValue = "";

        // receipt_status
        $this->receipt_status->LinkCustomAttributes = "";
        $this->receipt_status->HrefValue = "";
        $this->receipt_status->TooltipValue = "";

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

        // buyer_asset_schedule_id
        $this->buyer_asset_schedule_id->setupEditAttributes();
        $this->buyer_asset_schedule_id->EditCustomAttributes = "";
        $this->buyer_asset_schedule_id->EditValue = $this->buyer_asset_schedule_id->CurrentValue;
        $this->buyer_asset_schedule_id->ViewCustomAttributes = "";

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

        // num_installment
        $this->num_installment->setupEditAttributes();
        $this->num_installment->EditCustomAttributes = "";
        $this->num_installment->EditValue = $this->num_installment->CurrentValue;
        $this->num_installment->PlaceHolder = RemoveHtml($this->num_installment->caption());
        if (strval($this->num_installment->EditValue) != "" && is_numeric($this->num_installment->EditValue)) {
            $this->num_installment->EditValue = FormatNumber($this->num_installment->EditValue, null);
        }

        // installment_per_price
        $this->installment_per_price->setupEditAttributes();
        $this->installment_per_price->EditCustomAttributes = "";
        $this->installment_per_price->EditValue = $this->installment_per_price->CurrentValue;
        $this->installment_per_price->PlaceHolder = RemoveHtml($this->installment_per_price->caption());
        if (strval($this->installment_per_price->EditValue) != "" && is_numeric($this->installment_per_price->EditValue)) {
            $this->installment_per_price->EditValue = FormatNumber($this->installment_per_price->EditValue, null);
        }

        // receive_per_installment
        $this->receive_per_installment->setupEditAttributes();
        $this->receive_per_installment->EditCustomAttributes = "";
        $this->receive_per_installment->EditValue = $this->receive_per_installment->CurrentValue;
        $this->receive_per_installment->PlaceHolder = RemoveHtml($this->receive_per_installment->caption());
        if (strval($this->receive_per_installment->EditValue) != "" && is_numeric($this->receive_per_installment->EditValue)) {
            $this->receive_per_installment->EditValue = FormatNumber($this->receive_per_installment->EditValue, null);
        }

        // receive_per_installment_invertor
        $this->receive_per_installment_invertor->setupEditAttributes();
        $this->receive_per_installment_invertor->EditCustomAttributes = "";
        $this->receive_per_installment_invertor->EditValue = $this->receive_per_installment_invertor->CurrentValue;
        $this->receive_per_installment_invertor->PlaceHolder = RemoveHtml($this->receive_per_installment_invertor->caption());
        if (strval($this->receive_per_installment_invertor->EditValue) != "" && is_numeric($this->receive_per_installment_invertor->EditValue)) {
            $this->receive_per_installment_invertor->EditValue = FormatNumber($this->receive_per_installment_invertor->EditValue, null);
        }

        // pay_number
        $this->pay_number->setupEditAttributes();
        $this->pay_number->EditCustomAttributes = "";
        if (!$this->pay_number->Raw) {
            $this->pay_number->CurrentValue = HtmlDecode($this->pay_number->CurrentValue);
        }
        $this->pay_number->EditValue = $this->pay_number->CurrentValue;
        $this->pay_number->PlaceHolder = RemoveHtml($this->pay_number->caption());

        // expired_date
        $this->expired_date->setupEditAttributes();
        $this->expired_date->EditCustomAttributes = "";
        $this->expired_date->EditValue = FormatDateTime($this->expired_date->CurrentValue, $this->expired_date->formatPattern());
        $this->expired_date->PlaceHolder = RemoveHtml($this->expired_date->caption());

        // date_payment
        $this->date_payment->setupEditAttributes();
        $this->date_payment->EditCustomAttributes = "";
        $this->date_payment->EditValue = FormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        $this->date_payment->PlaceHolder = RemoveHtml($this->date_payment->caption());

        // status_payment
        $this->status_payment->setupEditAttributes();
        $this->status_payment->EditCustomAttributes = "";
        $this->status_payment->EditValue = $this->status_payment->options(true);
        $this->status_payment->PlaceHolder = RemoveHtml($this->status_payment->caption());

        // transaction_datetime
        $this->transaction_datetime->setupEditAttributes();
        $this->transaction_datetime->EditCustomAttributes = "";
        $this->transaction_datetime->EditValue = FormatDateTime($this->transaction_datetime->CurrentValue, $this->transaction_datetime->formatPattern());
        $this->transaction_datetime->PlaceHolder = RemoveHtml($this->transaction_datetime->caption());

        // payment_scheme
        $this->payment_scheme->setupEditAttributes();
        $this->payment_scheme->EditCustomAttributes = "";
        if (!$this->payment_scheme->Raw) {
            $this->payment_scheme->CurrentValue = HtmlDecode($this->payment_scheme->CurrentValue);
        }
        $this->payment_scheme->EditValue = $this->payment_scheme->CurrentValue;
        $this->payment_scheme->PlaceHolder = RemoveHtml($this->payment_scheme->caption());

        // transaction_ref
        $this->transaction_ref->setupEditAttributes();
        $this->transaction_ref->EditCustomAttributes = "";
        if (!$this->transaction_ref->Raw) {
            $this->transaction_ref->CurrentValue = HtmlDecode($this->transaction_ref->CurrentValue);
        }
        $this->transaction_ref->EditValue = $this->transaction_ref->CurrentValue;
        $this->transaction_ref->PlaceHolder = RemoveHtml($this->transaction_ref->caption());

        // channel_response_desc
        $this->channel_response_desc->setupEditAttributes();
        $this->channel_response_desc->EditCustomAttributes = "";
        if (!$this->channel_response_desc->Raw) {
            $this->channel_response_desc->CurrentValue = HtmlDecode($this->channel_response_desc->CurrentValue);
        }
        $this->channel_response_desc->EditValue = $this->channel_response_desc->CurrentValue;
        $this->channel_response_desc->PlaceHolder = RemoveHtml($this->channel_response_desc->caption());

        // res_status
        $this->res_status->setupEditAttributes();
        $this->res_status->EditCustomAttributes = "";
        if (!$this->res_status->Raw) {
            $this->res_status->CurrentValue = HtmlDecode($this->res_status->CurrentValue);
        }
        $this->res_status->EditValue = $this->res_status->CurrentValue;
        $this->res_status->PlaceHolder = RemoveHtml($this->res_status->caption());

        // res_referenceNo
        $this->res_referenceNo->setupEditAttributes();
        $this->res_referenceNo->EditCustomAttributes = "";
        if (!$this->res_referenceNo->Raw) {
            $this->res_referenceNo->CurrentValue = HtmlDecode($this->res_referenceNo->CurrentValue);
        }
        $this->res_referenceNo->EditValue = $this->res_referenceNo->CurrentValue;
        $this->res_referenceNo->PlaceHolder = RemoveHtml($this->res_referenceNo->caption());

        // installment_all
        $this->installment_all->setupEditAttributes();
        $this->installment_all->EditCustomAttributes = "";
        $this->installment_all->EditValue = $this->installment_all->CurrentValue;
        $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
        if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
            $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
        }

        // cdate

        // cuser

        // cip

        // uuser

        // udate

        // uip

        // res_paidAgent
        $this->res_paidAgent->setupEditAttributes();
        $this->res_paidAgent->EditCustomAttributes = "";
        if (!$this->res_paidAgent->Raw) {
            $this->res_paidAgent->CurrentValue = HtmlDecode($this->res_paidAgent->CurrentValue);
        }
        $this->res_paidAgent->EditValue = $this->res_paidAgent->CurrentValue;
        $this->res_paidAgent->PlaceHolder = RemoveHtml($this->res_paidAgent->caption());

        // res_paidChannel
        $this->res_paidChannel->setupEditAttributes();
        $this->res_paidChannel->EditCustomAttributes = "";
        if (!$this->res_paidChannel->Raw) {
            $this->res_paidChannel->CurrentValue = HtmlDecode($this->res_paidChannel->CurrentValue);
        }
        $this->res_paidChannel->EditValue = $this->res_paidChannel->CurrentValue;
        $this->res_paidChannel->PlaceHolder = RemoveHtml($this->res_paidChannel->caption());

        // res_maskedPan
        $this->res_maskedPan->setupEditAttributes();
        $this->res_maskedPan->EditCustomAttributes = "";
        if (!$this->res_maskedPan->Raw) {
            $this->res_maskedPan->CurrentValue = HtmlDecode($this->res_maskedPan->CurrentValue);
        }
        $this->res_maskedPan->EditValue = $this->res_maskedPan->CurrentValue;
        $this->res_maskedPan->PlaceHolder = RemoveHtml($this->res_maskedPan->caption());

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->setupEditAttributes();
        $this->buyer_config_asset_schedule_id->EditCustomAttributes = "";
        $this->buyer_config_asset_schedule_id->EditValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->PlaceHolder = RemoveHtml($this->buyer_config_asset_schedule_id->caption());
        if (strval($this->buyer_config_asset_schedule_id->EditValue) != "" && is_numeric($this->buyer_config_asset_schedule_id->EditValue)) {
            $this->buyer_config_asset_schedule_id->EditValue = FormatNumber($this->buyer_config_asset_schedule_id->EditValue, null);
        }

        // interest
        $this->interest->setupEditAttributes();
        $this->interest->EditCustomAttributes = "";
        $this->interest->EditValue = $this->interest->CurrentValue;
        $this->interest->PlaceHolder = RemoveHtml($this->interest->caption());
        if (strval($this->interest->EditValue) != "" && is_numeric($this->interest->EditValue)) {
            $this->interest->EditValue = FormatNumber($this->interest->EditValue, null);
        }

        // principal
        $this->principal->setupEditAttributes();
        $this->principal->EditCustomAttributes = "";
        $this->principal->EditValue = $this->principal->CurrentValue;
        $this->principal->PlaceHolder = RemoveHtml($this->principal->caption());
        if (strval($this->principal->EditValue) != "" && is_numeric($this->principal->EditValue)) {
            $this->principal->EditValue = FormatNumber($this->principal->EditValue, null);
        }

        // remaining_principal
        $this->remaining_principal->setupEditAttributes();
        $this->remaining_principal->EditCustomAttributes = "";
        $this->remaining_principal->EditValue = $this->remaining_principal->CurrentValue;
        $this->remaining_principal->PlaceHolder = RemoveHtml($this->remaining_principal->caption());
        if (strval($this->remaining_principal->EditValue) != "" && is_numeric($this->remaining_principal->EditValue)) {
            $this->remaining_principal->EditValue = FormatNumber($this->remaining_principal->EditValue, null);
        }

        // is_email
        $this->is_email->setupEditAttributes();
        $this->is_email->EditCustomAttributes = "";
        $this->is_email->EditValue = $this->is_email->CurrentValue;
        $this->is_email->PlaceHolder = RemoveHtml($this->is_email->caption());
        if (strval($this->is_email->EditValue) != "" && is_numeric($this->is_email->EditValue)) {
            $this->is_email->EditValue = FormatNumber($this->is_email->EditValue, null);
        }

        // receipt_status
        $this->receipt_status->setupEditAttributes();
        $this->receipt_status->EditCustomAttributes = "";
        $this->receipt_status->EditValue = $this->receipt_status->CurrentValue;
        $this->receipt_status->PlaceHolder = RemoveHtml($this->receipt_status->caption());
        if (strval($this->receipt_status->EditValue) != "" && is_numeric($this->receipt_status->EditValue)) {
            $this->receipt_status->EditValue = FormatNumber($this->receipt_status->EditValue, null);
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
                    $doc->exportCaption($this->num_installment);
                    $doc->exportCaption($this->installment_per_price);
                    $doc->exportCaption($this->pay_number);
                    $doc->exportCaption($this->expired_date);
                    $doc->exportCaption($this->date_payment);
                    $doc->exportCaption($this->status_payment);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->num_installment);
                    $doc->exportCaption($this->installment_per_price);
                    $doc->exportCaption($this->pay_number);
                    $doc->exportCaption($this->expired_date);
                    $doc->exportCaption($this->date_payment);
                    $doc->exportCaption($this->status_payment);
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
                        $doc->exportField($this->num_installment);
                        $doc->exportField($this->installment_per_price);
                        $doc->exportField($this->pay_number);
                        $doc->exportField($this->expired_date);
                        $doc->exportField($this->date_payment);
                        $doc->exportField($this->status_payment);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->num_installment);
                        $doc->exportField($this->installment_per_price);
                        $doc->exportField($this->pay_number);
                        $doc->exportField($this->expired_date);
                        $doc->exportField($this->date_payment);
                        $doc->exportField($this->status_payment);
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
        $table = 'buyer_asset_schedule';
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
        $table = 'buyer_asset_schedule';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['buyer_asset_schedule_id'];

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
        $table = 'buyer_asset_schedule';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['buyer_asset_schedule_id'];

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
        $table = 'buyer_asset_schedule';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['buyer_asset_schedule_id'];

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
