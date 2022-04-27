<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for payment_inverter_booking
 */
class PaymentInverterBooking extends DbTable
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
    public $payment_inverter_booking_id;
    public $member_id;
    public $asset_id;
    public $payment;
    public $type;
    public $payment_number;
    public $status;
    public $status_expire;
    public $status_expire_reason;
    public $transaction_datetime;
    public $payment_scheme;
    public $transaction_ref;
    public $channel_response_desc;
    public $res_status;
    public $res_referenceNo;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;
    public $res_paidAgent;
    public $res_paidChannel;
    public $res_maskedPan;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'payment_inverter_booking';
        $this->TableName = 'payment_inverter_booking';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`payment_inverter_booking`";
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

        // payment_inverter_booking_id
        $this->payment_inverter_booking_id = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
            'x_payment_inverter_booking_id',
            'payment_inverter_booking_id',
            '`payment_inverter_booking_id`',
            '`payment_inverter_booking_id`',
            3,
            11,
            -1,
            false,
            '`payment_inverter_booking_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->payment_inverter_booking_id->InputTextType = "text";
        $this->payment_inverter_booking_id->IsAutoIncrement = true; // Autoincrement field
        $this->payment_inverter_booking_id->IsPrimaryKey = true; // Primary key field
        $this->payment_inverter_booking_id->Sortable = false; // Allow sort
        $this->payment_inverter_booking_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['payment_inverter_booking_id'] = &$this->payment_inverter_booking_id;

        // member_id
        $this->member_id = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '`first_name` ASC', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // asset_id
        $this->asset_id = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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

        // payment
        $this->payment = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
            'x_payment',
            'payment',
            '`payment`',
            '`payment`',
            4,
            12,
            -1,
            false,
            '`payment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->payment->InputTextType = "text";
        $this->payment->Nullable = false; // NOT NULL field
        $this->payment->Required = true; // Required field
        $this->payment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['payment'] = &$this->payment;

        // type
        $this->type = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
            'TEXT'
        );
        $this->type->InputTextType = "text";
        $this->type->Nullable = false; // NOT NULL field
        $this->type->Required = true; // Required field
        $this->type->Sortable = false; // Allow sort
        $this->type->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type'] = &$this->type;

        // payment_number
        $this->payment_number = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
            'x_payment_number',
            'payment_number',
            '`payment_number`',
            '`payment_number`',
            200,
            50,
            -1,
            false,
            '`payment_number`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->payment_number->InputTextType = "text";
        $this->payment_number->Nullable = false; // NOT NULL field
        $this->payment_number->Required = true; // Required field
        $this->Fields['payment_number'] = &$this->payment_number;

        // status
        $this->status = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
            'x_status',
            'status',
            '`status`',
            '`status`',
            3,
            11,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->status->InputTextType = "text";
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status->Lookup = new Lookup('status', 'payment_inverter_booking', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // status_expire
        $this->status_expire = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
            'x_status_expire',
            'status_expire',
            '`status_expire`',
            '`status_expire`',
            3,
            11,
            -1,
            false,
            '`status_expire`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->status_expire->InputTextType = "text";
        $this->status_expire->Nullable = false; // NOT NULL field
        $this->status_expire->Lookup = new Lookup('status_expire', 'payment_inverter_booking', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_expire->OptionCount = 2;
        $this->status_expire->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_expire'] = &$this->status_expire;

        // status_expire_reason
        $this->status_expire_reason = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
            'x_status_expire_reason',
            'status_expire_reason',
            '`status_expire_reason`',
            '`status_expire_reason`',
            200,
            255,
            -1,
            false,
            '`status_expire_reason`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->status_expire_reason->InputTextType = "text";
        $this->Fields['status_expire_reason'] = &$this->status_expire_reason;

        // transaction_datetime
        $this->transaction_datetime = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->transaction_datetime->Nullable = false; // NOT NULL field
        $this->transaction_datetime->Required = true; // Required field
        $this->transaction_datetime->Sortable = false; // Allow sort
        $this->transaction_datetime->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['transaction_datetime'] = &$this->transaction_datetime;

        // payment_scheme
        $this->payment_scheme = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->payment_scheme->Nullable = false; // NOT NULL field
        $this->payment_scheme->Required = true; // Required field
        $this->payment_scheme->Sortable = false; // Allow sort
        $this->Fields['payment_scheme'] = &$this->payment_scheme;

        // transaction_ref
        $this->transaction_ref = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->transaction_ref->Nullable = false; // NOT NULL field
        $this->transaction_ref->Required = true; // Required field
        $this->transaction_ref->Sortable = false; // Allow sort
        $this->Fields['transaction_ref'] = &$this->transaction_ref;

        // channel_response_desc
        $this->channel_response_desc = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->channel_response_desc->Nullable = false; // NOT NULL field
        $this->channel_response_desc->Required = true; // Required field
        $this->channel_response_desc->Sortable = false; // Allow sort
        $this->Fields['channel_response_desc'] = &$this->channel_response_desc;

        // res_status
        $this->res_status = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->res_status->Nullable = false; // NOT NULL field
        $this->res_status->Required = true; // Required field
        $this->res_status->Sortable = false; // Allow sort
        $this->Fields['res_status'] = &$this->res_status;

        // res_referenceNo
        $this->res_referenceNo = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->res_referenceNo->Nullable = false; // NOT NULL field
        $this->res_referenceNo->Required = true; // Required field
        $this->res_referenceNo->Sortable = false; // Allow sort
        $this->Fields['res_referenceNo'] = &$this->res_referenceNo;

        // cdate
        $this->cdate = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->cdate->Nullable = false; // NOT NULL field
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->cuser->Nullable = false; // NOT NULL field
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->cip->Nullable = false; // NOT NULL field
        $this->Fields['cip'] = &$this->cip;

        // udate
        $this->udate = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->udate->Nullable = false; // NOT NULL field
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uuser
        $this->uuser = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->uuser->Nullable = false; // NOT NULL field
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        $this->uip->Nullable = false; // NOT NULL field
        $this->Fields['uip'] = &$this->uip;

        // res_paidAgent
        $this->res_paidAgent = new DbField(
            'payment_inverter_booking',
            'payment_inverter_booking',
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
            'payment_inverter_booking',
            'payment_inverter_booking',
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
            'payment_inverter_booking',
            'payment_inverter_booking',
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
        if ($this->getCurrentMasterTable() == "invertor_booking") {
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
        if ($this->getCurrentMasterTable() == "invertor_all_booking") {
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
        if ($this->getCurrentMasterTable() == "invertor_booking") {
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
        if ($this->getCurrentMasterTable() == "invertor_all_booking") {
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
            case "invertor_booking":
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
            case "invertor_all_booking":
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
            case "invertor_booking":
                return "`member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid) . " AND `asset_id`=" . QuotedValue($masterTable->asset_id->DbValue, $this->asset_id->DataType, $this->Dbid);
            case "invertor_all_booking":
                return "`asset_id`=" . QuotedValue($masterTable->asset_id->DbValue, $this->asset_id->DataType, $this->Dbid) . " AND `member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`payment_inverter_booking`";
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
            $this->payment_inverter_booking_id->setDbValue($conn->lastInsertId());
            $rs['payment_inverter_booking_id'] = $this->payment_inverter_booking_id->DbValue;
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
            $fldname = 'payment_inverter_booking_id';
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
            if (array_key_exists('payment_inverter_booking_id', $rs)) {
                AddFilter($where, QuotedName('payment_inverter_booking_id', $this->Dbid) . '=' . QuotedValue($rs['payment_inverter_booking_id'], $this->payment_inverter_booking_id->DataType, $this->Dbid));
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
        $this->payment_inverter_booking_id->DbValue = $row['payment_inverter_booking_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->payment->DbValue = $row['payment'];
        $this->type->DbValue = $row['type'];
        $this->payment_number->DbValue = $row['payment_number'];
        $this->status->DbValue = $row['status'];
        $this->status_expire->DbValue = $row['status_expire'];
        $this->status_expire_reason->DbValue = $row['status_expire_reason'];
        $this->transaction_datetime->DbValue = $row['transaction_datetime'];
        $this->payment_scheme->DbValue = $row['payment_scheme'];
        $this->transaction_ref->DbValue = $row['transaction_ref'];
        $this->channel_response_desc->DbValue = $row['channel_response_desc'];
        $this->res_status->DbValue = $row['res_status'];
        $this->res_referenceNo->DbValue = $row['res_referenceNo'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->res_paidAgent->DbValue = $row['res_paidAgent'];
        $this->res_paidChannel->DbValue = $row['res_paidChannel'];
        $this->res_maskedPan->DbValue = $row['res_maskedPan'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`payment_inverter_booking_id` = @payment_inverter_booking_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->payment_inverter_booking_id->CurrentValue : $this->payment_inverter_booking_id->OldValue;
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
                $this->payment_inverter_booking_id->CurrentValue = $keys[0];
            } else {
                $this->payment_inverter_booking_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('payment_inverter_booking_id', $row) ? $row['payment_inverter_booking_id'] : null;
        } else {
            $val = $this->payment_inverter_booking_id->OldValue !== null ? $this->payment_inverter_booking_id->OldValue : $this->payment_inverter_booking_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@payment_inverter_booking_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("paymentinverterbookinglist");
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
        if ($pageName == "paymentinverterbookingview") {
            return $Language->phrase("View");
        } elseif ($pageName == "paymentinverterbookingedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "paymentinverterbookingadd") {
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
                return "PaymentInverterBookingView";
            case Config("API_ADD_ACTION"):
                return "PaymentInverterBookingAdd";
            case Config("API_EDIT_ACTION"):
                return "PaymentInverterBookingEdit";
            case Config("API_DELETE_ACTION"):
                return "PaymentInverterBookingDelete";
            case Config("API_LIST_ACTION"):
                return "PaymentInverterBookingList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "paymentinverterbookinglist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("paymentinverterbookingview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("paymentinverterbookingview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "paymentinverterbookingadd?" . $this->getUrlParm($parm);
        } else {
            $url = "paymentinverterbookingadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("paymentinverterbookingedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("paymentinverterbookingadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("paymentinverterbookingdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "invertor_booking" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "invertor_all_booking" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"payment_inverter_booking_id\":" . JsonEncode($this->payment_inverter_booking_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->payment_inverter_booking_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->payment_inverter_booking_id->CurrentValue);
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
            if (($keyValue = Param("payment_inverter_booking_id") ?? Route("payment_inverter_booking_id")) !== null) {
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
                $this->payment_inverter_booking_id->CurrentValue = $key;
            } else {
                $this->payment_inverter_booking_id->OldValue = $key;
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
        $this->payment_inverter_booking_id->setDbValue($row['payment_inverter_booking_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->payment->setDbValue($row['payment']);
        $this->type->setDbValue($row['type']);
        $this->payment_number->setDbValue($row['payment_number']);
        $this->status->setDbValue($row['status']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->res_paidAgent->setDbValue($row['res_paidAgent']);
        $this->res_paidChannel->setDbValue($row['res_paidChannel']);
        $this->res_maskedPan->setDbValue($row['res_maskedPan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // payment_inverter_booking_id
        $this->payment_inverter_booking_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // asset_id

        // payment

        // type
        $this->type->CellCssStyle = "white-space: nowrap;";

        // payment_number

        // status

        // status_expire

        // status_expire_reason

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

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // res_paidAgent
        $this->res_paidAgent->CellCssStyle = "white-space: nowrap;";

        // res_paidChannel
        $this->res_paidChannel->CellCssStyle = "white-space: nowrap;";

        // res_maskedPan
        $this->res_maskedPan->CellCssStyle = "white-space: nowrap;";

        // payment_inverter_booking_id
        $this->payment_inverter_booking_id->ViewValue = $this->payment_inverter_booking_id->CurrentValue;
        $this->payment_inverter_booking_id->ViewCustomAttributes = "";

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

        // payment
        $this->payment->ViewValue = $this->payment->CurrentValue;
        $this->payment->ViewValue = FormatNumber($this->payment->ViewValue, $this->payment->formatPattern());
        $this->payment->ViewCustomAttributes = "";

        // type
        $this->type->ViewValue = $this->type->CurrentValue;
        $this->type->ViewValue = FormatNumber($this->type->ViewValue, $this->type->formatPattern());
        $this->type->ViewCustomAttributes = "";

        // payment_number
        $this->payment_number->ViewValue = $this->payment_number->CurrentValue;
        $this->payment_number->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // status_expire
        if (strval($this->status_expire->CurrentValue) != "") {
            $this->status_expire->ViewValue = $this->status_expire->optionCaption($this->status_expire->CurrentValue);
        } else {
            $this->status_expire->ViewValue = null;
        }
        $this->status_expire->ViewCustomAttributes = "";

        // status_expire_reason
        $this->status_expire_reason->ViewValue = $this->status_expire_reason->CurrentValue;
        $this->status_expire_reason->ViewCustomAttributes = "";

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

        // res_paidAgent
        $this->res_paidAgent->ViewValue = $this->res_paidAgent->CurrentValue;
        $this->res_paidAgent->ViewCustomAttributes = "";

        // res_paidChannel
        $this->res_paidChannel->ViewValue = $this->res_paidChannel->CurrentValue;
        $this->res_paidChannel->ViewCustomAttributes = "";

        // res_maskedPan
        $this->res_maskedPan->ViewValue = $this->res_maskedPan->CurrentValue;
        $this->res_maskedPan->ViewCustomAttributes = "";

        // payment_inverter_booking_id
        $this->payment_inverter_booking_id->LinkCustomAttributes = "";
        $this->payment_inverter_booking_id->HrefValue = "";
        $this->payment_inverter_booking_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // payment
        $this->payment->LinkCustomAttributes = "";
        $this->payment->HrefValue = "";
        $this->payment->TooltipValue = "";

        // type
        $this->type->LinkCustomAttributes = "";
        $this->type->HrefValue = "";
        $this->type->TooltipValue = "";

        // payment_number
        $this->payment_number->LinkCustomAttributes = "";
        $this->payment_number->HrefValue = "";
        $this->payment_number->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // status_expire
        $this->status_expire->LinkCustomAttributes = "";
        $this->status_expire->HrefValue = "";
        $this->status_expire->TooltipValue = "";

        // status_expire_reason
        $this->status_expire_reason->LinkCustomAttributes = "";
        $this->status_expire_reason->HrefValue = "";
        $this->status_expire_reason->TooltipValue = "";

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

        // payment_inverter_booking_id
        $this->payment_inverter_booking_id->setupEditAttributes();
        $this->payment_inverter_booking_id->EditCustomAttributes = "";
        $this->payment_inverter_booking_id->EditValue = $this->payment_inverter_booking_id->CurrentValue;
        $this->payment_inverter_booking_id->ViewCustomAttributes = "";

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

        // payment
        $this->payment->setupEditAttributes();
        $this->payment->EditCustomAttributes = "";
        $this->payment->EditValue = $this->payment->CurrentValue;
        $this->payment->EditValue = FormatNumber($this->payment->EditValue, $this->payment->formatPattern());
        $this->payment->ViewCustomAttributes = "";

        // type
        $this->type->setupEditAttributes();
        $this->type->EditCustomAttributes = "";
        $this->type->EditValue = $this->type->CurrentValue;
        $this->type->PlaceHolder = RemoveHtml($this->type->caption());
        if (strval($this->type->EditValue) != "" && is_numeric($this->type->EditValue)) {
            $this->type->EditValue = FormatNumber($this->type->EditValue, null);
        }

        // payment_number
        $this->payment_number->setupEditAttributes();
        $this->payment_number->EditCustomAttributes = "";
        $this->payment_number->EditValue = $this->payment_number->CurrentValue;
        $this->payment_number->ViewCustomAttributes = "";

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        if (strval($this->status->CurrentValue) != "") {
            $this->status->EditValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->EditValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // status_expire
        $this->status_expire->EditCustomAttributes = "";
        $this->status_expire->EditValue = $this->status_expire->options(false);
        $this->status_expire->PlaceHolder = RemoveHtml($this->status_expire->caption());

        // status_expire_reason
        $this->status_expire_reason->setupEditAttributes();
        $this->status_expire_reason->EditCustomAttributes = "";
        if (!$this->status_expire_reason->Raw) {
            $this->status_expire_reason->CurrentValue = HtmlDecode($this->status_expire_reason->CurrentValue);
        }
        $this->status_expire_reason->EditValue = $this->status_expire_reason->CurrentValue;
        $this->status_expire_reason->PlaceHolder = RemoveHtml($this->status_expire_reason->caption());

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

        // cdate

        // cuser

        // cip

        // udate

        // uuser

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
                    $doc->exportCaption($this->payment);
                    $doc->exportCaption($this->payment_number);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->status_expire);
                    $doc->exportCaption($this->status_expire_reason);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                } else {
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->payment);
                    $doc->exportCaption($this->payment_number);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->status_expire);
                    $doc->exportCaption($this->status_expire_reason);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
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
                        $doc->exportField($this->payment);
                        $doc->exportField($this->payment_number);
                        $doc->exportField($this->status);
                        $doc->exportField($this->status_expire);
                        $doc->exportField($this->status_expire_reason);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                    } else {
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->payment);
                        $doc->exportField($this->payment_number);
                        $doc->exportField($this->status);
                        $doc->exportField($this->status_expire);
                        $doc->exportField($this->status_expire_reason);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
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
        $table = 'payment_inverter_booking';
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
        $table = 'payment_inverter_booking';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['payment_inverter_booking_id'];

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
        $table = 'payment_inverter_booking';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['payment_inverter_booking_id'];

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
        $table = 'payment_inverter_booking';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['payment_inverter_booking_id'];

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
