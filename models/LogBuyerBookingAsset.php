<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for log_buyer_booking_asset
 */
class LogBuyerBookingAsset extends DbTable
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
    public $log_buyer_booking_asset_id;
    public $member_id;
    public $booking_price;
    public $type;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;
    public $pay_number;
    public $status_payment;
    public $asset_id;
    public $transaction_datetime;
    public $payment_scheme;
    public $transaction_ref;
    public $channel_response_desc;
    public $res_status;
    public $res_referenceNo;
    public $date_booking;
    public $date_payment;
    public $due_date;
    public $status_expire;
    public $status_expire_reason;
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
        $this->TableVar = 'log_buyer_booking_asset';
        $this->TableName = 'log_buyer_booking_asset';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`log_buyer_booking_asset`";
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

        // log_buyer_booking_asset_id
        $this->log_buyer_booking_asset_id = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_log_buyer_booking_asset_id',
            'log_buyer_booking_asset_id',
            '`log_buyer_booking_asset_id`',
            '`log_buyer_booking_asset_id`',
            3,
            11,
            -1,
            false,
            '`log_buyer_booking_asset_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->log_buyer_booking_asset_id->InputTextType = "text";
        $this->log_buyer_booking_asset_id->IsAutoIncrement = true; // Autoincrement field
        $this->log_buyer_booking_asset_id->IsPrimaryKey = true; // Primary key field
        $this->log_buyer_booking_asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['log_buyer_booking_asset_id'] = &$this->log_buyer_booking_asset_id;

        // member_id
        $this->member_id = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->member_id->Required = true; // Required field
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // booking_price
        $this->booking_price = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_booking_price',
            'booking_price',
            '`booking_price`',
            '`booking_price`',
            4,
            12,
            -1,
            false,
            '`booking_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->booking_price->InputTextType = "text";
        $this->booking_price->Required = true; // Required field
        $this->booking_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['booking_price'] = &$this->booking_price;

        // type
        $this->type = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->type->Required = true; // Required field
        $this->type->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type'] = &$this->type;

        // cdate
        $this->cdate = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_cdate',
            'cdate',
            '`cdate`',
            CastDateFieldForLike("`cdate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`cdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cdate->InputTextType = "text";
        $this->cdate->Required = true; // Required field
        $this->cdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            200,
            100,
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
        $this->cuser->Required = true; // Required field
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->cip->Required = true; // Required field
        $this->Fields['cip'] = &$this->cip;

        // udate
        $this->udate = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->udate->Required = true; // Required field
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uuser
        $this->uuser = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->uuser->Required = true; // Required field
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->uip->Required = true; // Required field
        $this->Fields['uip'] = &$this->uip;

        // pay_number
        $this->pay_number = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_pay_number',
            'pay_number',
            '`pay_number`',
            '`pay_number`',
            200,
            50,
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
        $this->pay_number->Required = true; // Required field
        $this->Fields['pay_number'] = &$this->pay_number;

        // status_payment
        $this->status_payment = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
            'TEXT'
        );
        $this->status_payment->InputTextType = "text";
        $this->status_payment->Required = true; // Required field
        $this->status_payment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_payment'] = &$this->status_payment;

        // asset_id
        $this->asset_id = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
            'TEXT'
        );
        $this->asset_id->InputTextType = "text";
        $this->asset_id->Required = true; // Required field
        $this->asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_id'] = &$this->asset_id;

        // transaction_datetime
        $this->transaction_datetime = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->transaction_datetime->Required = true; // Required field
        $this->transaction_datetime->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['transaction_datetime'] = &$this->transaction_datetime;

        // payment_scheme
        $this->payment_scheme = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->payment_scheme->Required = true; // Required field
        $this->Fields['payment_scheme'] = &$this->payment_scheme;

        // transaction_ref
        $this->transaction_ref = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->transaction_ref->Required = true; // Required field
        $this->Fields['transaction_ref'] = &$this->transaction_ref;

        // channel_response_desc
        $this->channel_response_desc = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->channel_response_desc->Required = true; // Required field
        $this->Fields['channel_response_desc'] = &$this->channel_response_desc;

        // res_status
        $this->res_status = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->res_status->Required = true; // Required field
        $this->Fields['res_status'] = &$this->res_status;

        // res_referenceNo
        $this->res_referenceNo = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->res_referenceNo->Required = true; // Required field
        $this->Fields['res_referenceNo'] = &$this->res_referenceNo;

        // date_booking
        $this->date_booking = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_date_booking',
            'date_booking',
            '`date_booking`',
            CastDateFieldForLike("`date_booking`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`date_booking`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date_booking->InputTextType = "text";
        $this->date_booking->Required = true; // Required field
        $this->date_booking->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['date_booking'] = &$this->date_booking;

        // date_payment
        $this->date_payment = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
            'x_date_payment',
            'date_payment',
            '`date_payment`',
            CastDateFieldForLike("`date_payment`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`date_payment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date_payment->InputTextType = "text";
        $this->date_payment->Required = true; // Required field
        $this->date_payment->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['date_payment'] = &$this->date_payment;

        // due_date
        $this->due_date = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->due_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['due_date'] = &$this->due_date;

        // status_expire
        $this->status_expire = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
            'TEXT'
        );
        $this->status_expire->InputTextType = "text";
        $this->status_expire->Nullable = false; // NOT NULL field
        $this->status_expire->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_expire'] = &$this->status_expire;

        // status_expire_reason
        $this->status_expire_reason = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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

        // res_paidAgent
        $this->res_paidAgent = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->Fields['res_paidAgent'] = &$this->res_paidAgent;

        // res_paidChannel
        $this->res_paidChannel = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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
        $this->Fields['res_paidChannel'] = &$this->res_paidChannel;

        // res_maskedPan
        $this->res_maskedPan = new DbField(
            'log_buyer_booking_asset',
            'log_buyer_booking_asset',
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`log_buyer_booking_asset`";
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
            $this->log_buyer_booking_asset_id->setDbValue($conn->lastInsertId());
            $rs['log_buyer_booking_asset_id'] = $this->log_buyer_booking_asset_id->DbValue;
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
            if (array_key_exists('log_buyer_booking_asset_id', $rs)) {
                AddFilter($where, QuotedName('log_buyer_booking_asset_id', $this->Dbid) . '=' . QuotedValue($rs['log_buyer_booking_asset_id'], $this->log_buyer_booking_asset_id->DataType, $this->Dbid));
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
        $this->log_buyer_booking_asset_id->DbValue = $row['log_buyer_booking_asset_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->booking_price->DbValue = $row['booking_price'];
        $this->type->DbValue = $row['type'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->pay_number->DbValue = $row['pay_number'];
        $this->status_payment->DbValue = $row['status_payment'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->transaction_datetime->DbValue = $row['transaction_datetime'];
        $this->payment_scheme->DbValue = $row['payment_scheme'];
        $this->transaction_ref->DbValue = $row['transaction_ref'];
        $this->channel_response_desc->DbValue = $row['channel_response_desc'];
        $this->res_status->DbValue = $row['res_status'];
        $this->res_referenceNo->DbValue = $row['res_referenceNo'];
        $this->date_booking->DbValue = $row['date_booking'];
        $this->date_payment->DbValue = $row['date_payment'];
        $this->due_date->DbValue = $row['due_date'];
        $this->status_expire->DbValue = $row['status_expire'];
        $this->status_expire_reason->DbValue = $row['status_expire_reason'];
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
        return "`log_buyer_booking_asset_id` = @log_buyer_booking_asset_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->log_buyer_booking_asset_id->CurrentValue : $this->log_buyer_booking_asset_id->OldValue;
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
                $this->log_buyer_booking_asset_id->CurrentValue = $keys[0];
            } else {
                $this->log_buyer_booking_asset_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('log_buyer_booking_asset_id', $row) ? $row['log_buyer_booking_asset_id'] : null;
        } else {
            $val = $this->log_buyer_booking_asset_id->OldValue !== null ? $this->log_buyer_booking_asset_id->OldValue : $this->log_buyer_booking_asset_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@log_buyer_booking_asset_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("logbuyerbookingassetlist");
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
        if ($pageName == "logbuyerbookingassetview") {
            return $Language->phrase("View");
        } elseif ($pageName == "logbuyerbookingassetedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "logbuyerbookingassetadd") {
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
                return "LogBuyerBookingAssetView";
            case Config("API_ADD_ACTION"):
                return "LogBuyerBookingAssetAdd";
            case Config("API_EDIT_ACTION"):
                return "LogBuyerBookingAssetEdit";
            case Config("API_DELETE_ACTION"):
                return "LogBuyerBookingAssetDelete";
            case Config("API_LIST_ACTION"):
                return "LogBuyerBookingAssetList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "logbuyerbookingassetlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("logbuyerbookingassetview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("logbuyerbookingassetview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "logbuyerbookingassetadd?" . $this->getUrlParm($parm);
        } else {
            $url = "logbuyerbookingassetadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("logbuyerbookingassetedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("logbuyerbookingassetadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("logbuyerbookingassetdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"log_buyer_booking_asset_id\":" . JsonEncode($this->log_buyer_booking_asset_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->log_buyer_booking_asset_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->log_buyer_booking_asset_id->CurrentValue);
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
            if (($keyValue = Param("log_buyer_booking_asset_id") ?? Route("log_buyer_booking_asset_id")) !== null) {
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
                $this->log_buyer_booking_asset_id->CurrentValue = $key;
            } else {
                $this->log_buyer_booking_asset_id->OldValue = $key;
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
        $this->log_buyer_booking_asset_id->setDbValue($row['log_buyer_booking_asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->type->setDbValue($row['type']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->pay_number->setDbValue($row['pay_number']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->transaction_datetime->setDbValue($row['transaction_datetime']);
        $this->payment_scheme->setDbValue($row['payment_scheme']);
        $this->transaction_ref->setDbValue($row['transaction_ref']);
        $this->channel_response_desc->setDbValue($row['channel_response_desc']);
        $this->res_status->setDbValue($row['res_status']);
        $this->res_referenceNo->setDbValue($row['res_referenceNo']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->date_payment->setDbValue($row['date_payment']);
        $this->due_date->setDbValue($row['due_date']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
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

        // log_buyer_booking_asset_id

        // member_id

        // booking_price

        // type

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // pay_number

        // status_payment

        // asset_id

        // transaction_datetime

        // payment_scheme

        // transaction_ref

        // channel_response_desc

        // res_status

        // res_referenceNo

        // date_booking

        // date_payment

        // due_date

        // status_expire

        // status_expire_reason

        // res_paidAgent

        // res_paidChannel

        // res_maskedPan

        // log_buyer_booking_asset_id
        $this->log_buyer_booking_asset_id->ViewValue = $this->log_buyer_booking_asset_id->CurrentValue;
        $this->log_buyer_booking_asset_id->ViewCustomAttributes = "";

        // member_id
        $this->member_id->ViewValue = $this->member_id->CurrentValue;
        $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
        $this->member_id->ViewCustomAttributes = "";

        // booking_price
        $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
        $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
        $this->booking_price->ViewCustomAttributes = "";

        // type
        $this->type->ViewValue = $this->type->CurrentValue;
        $this->type->ViewValue = FormatNumber($this->type->ViewValue, $this->type->formatPattern());
        $this->type->ViewCustomAttributes = "";

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

        // pay_number
        $this->pay_number->ViewValue = $this->pay_number->CurrentValue;
        $this->pay_number->ViewCustomAttributes = "";

        // status_payment
        $this->status_payment->ViewValue = $this->status_payment->CurrentValue;
        $this->status_payment->ViewValue = FormatNumber($this->status_payment->ViewValue, $this->status_payment->formatPattern());
        $this->status_payment->ViewCustomAttributes = "";

        // asset_id
        $this->asset_id->ViewValue = $this->asset_id->CurrentValue;
        $this->asset_id->ViewValue = FormatNumber($this->asset_id->ViewValue, $this->asset_id->formatPattern());
        $this->asset_id->ViewCustomAttributes = "";

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

        // date_booking
        $this->date_booking->ViewValue = $this->date_booking->CurrentValue;
        $this->date_booking->ViewValue = FormatDateTime($this->date_booking->ViewValue, $this->date_booking->formatPattern());
        $this->date_booking->ViewCustomAttributes = "";

        // date_payment
        $this->date_payment->ViewValue = $this->date_payment->CurrentValue;
        $this->date_payment->ViewValue = FormatDateTime($this->date_payment->ViewValue, $this->date_payment->formatPattern());
        $this->date_payment->ViewCustomAttributes = "";

        // due_date
        $this->due_date->ViewValue = $this->due_date->CurrentValue;
        $this->due_date->ViewValue = FormatDateTime($this->due_date->ViewValue, $this->due_date->formatPattern());
        $this->due_date->ViewCustomAttributes = "";

        // status_expire
        $this->status_expire->ViewValue = $this->status_expire->CurrentValue;
        $this->status_expire->ViewValue = FormatNumber($this->status_expire->ViewValue, $this->status_expire->formatPattern());
        $this->status_expire->ViewCustomAttributes = "";

        // status_expire_reason
        $this->status_expire_reason->ViewValue = $this->status_expire_reason->CurrentValue;
        $this->status_expire_reason->ViewCustomAttributes = "";

        // res_paidAgent
        $this->res_paidAgent->ViewValue = $this->res_paidAgent->CurrentValue;
        $this->res_paidAgent->ViewCustomAttributes = "";

        // res_paidChannel
        $this->res_paidChannel->ViewValue = $this->res_paidChannel->CurrentValue;
        $this->res_paidChannel->ViewCustomAttributes = "";

        // res_maskedPan
        $this->res_maskedPan->ViewValue = $this->res_maskedPan->CurrentValue;
        $this->res_maskedPan->ViewCustomAttributes = "";

        // log_buyer_booking_asset_id
        $this->log_buyer_booking_asset_id->LinkCustomAttributes = "";
        $this->log_buyer_booking_asset_id->HrefValue = "";
        $this->log_buyer_booking_asset_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // booking_price
        $this->booking_price->LinkCustomAttributes = "";
        $this->booking_price->HrefValue = "";
        $this->booking_price->TooltipValue = "";

        // type
        $this->type->LinkCustomAttributes = "";
        $this->type->HrefValue = "";
        $this->type->TooltipValue = "";

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

        // pay_number
        $this->pay_number->LinkCustomAttributes = "";
        $this->pay_number->HrefValue = "";
        $this->pay_number->TooltipValue = "";

        // status_payment
        $this->status_payment->LinkCustomAttributes = "";
        $this->status_payment->HrefValue = "";
        $this->status_payment->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

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

        // date_booking
        $this->date_booking->LinkCustomAttributes = "";
        $this->date_booking->HrefValue = "";
        $this->date_booking->TooltipValue = "";

        // date_payment
        $this->date_payment->LinkCustomAttributes = "";
        $this->date_payment->HrefValue = "";
        $this->date_payment->TooltipValue = "";

        // due_date
        $this->due_date->LinkCustomAttributes = "";
        $this->due_date->HrefValue = "";
        $this->due_date->TooltipValue = "";

        // status_expire
        $this->status_expire->LinkCustomAttributes = "";
        $this->status_expire->HrefValue = "";
        $this->status_expire->TooltipValue = "";

        // status_expire_reason
        $this->status_expire_reason->LinkCustomAttributes = "";
        $this->status_expire_reason->HrefValue = "";
        $this->status_expire_reason->TooltipValue = "";

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

        // log_buyer_booking_asset_id
        $this->log_buyer_booking_asset_id->setupEditAttributes();
        $this->log_buyer_booking_asset_id->EditCustomAttributes = "";
        $this->log_buyer_booking_asset_id->EditValue = $this->log_buyer_booking_asset_id->CurrentValue;
        $this->log_buyer_booking_asset_id->ViewCustomAttributes = "";

        // member_id
        $this->member_id->setupEditAttributes();
        $this->member_id->EditCustomAttributes = "";
        $this->member_id->EditValue = $this->member_id->CurrentValue;
        $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
        if (strval($this->member_id->EditValue) != "" && is_numeric($this->member_id->EditValue)) {
            $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, null);
        }

        // booking_price
        $this->booking_price->setupEditAttributes();
        $this->booking_price->EditCustomAttributes = "";
        $this->booking_price->EditValue = $this->booking_price->CurrentValue;
        $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
        if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
            $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
        }

        // type
        $this->type->setupEditAttributes();
        $this->type->EditCustomAttributes = "";
        $this->type->EditValue = $this->type->CurrentValue;
        $this->type->PlaceHolder = RemoveHtml($this->type->caption());
        if (strval($this->type->EditValue) != "" && is_numeric($this->type->EditValue)) {
            $this->type->EditValue = FormatNumber($this->type->EditValue, null);
        }

        // cdate
        $this->cdate->setupEditAttributes();
        $this->cdate->EditCustomAttributes = "";
        $this->cdate->EditValue = FormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());

        // cuser
        $this->cuser->setupEditAttributes();
        $this->cuser->EditCustomAttributes = "";
        if (!$this->cuser->Raw) {
            $this->cuser->CurrentValue = HtmlDecode($this->cuser->CurrentValue);
        }
        $this->cuser->EditValue = $this->cuser->CurrentValue;
        $this->cuser->PlaceHolder = RemoveHtml($this->cuser->caption());

        // cip
        $this->cip->setupEditAttributes();
        $this->cip->EditCustomAttributes = "";
        if (!$this->cip->Raw) {
            $this->cip->CurrentValue = HtmlDecode($this->cip->CurrentValue);
        }
        $this->cip->EditValue = $this->cip->CurrentValue;
        $this->cip->PlaceHolder = RemoveHtml($this->cip->caption());

        // udate
        $this->udate->setupEditAttributes();
        $this->udate->EditCustomAttributes = "";
        $this->udate->EditValue = FormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->udate->PlaceHolder = RemoveHtml($this->udate->caption());

        // uuser
        $this->uuser->setupEditAttributes();
        $this->uuser->EditCustomAttributes = "";
        $this->uuser->EditValue = $this->uuser->CurrentValue;
        $this->uuser->PlaceHolder = RemoveHtml($this->uuser->caption());
        if (strval($this->uuser->EditValue) != "" && is_numeric($this->uuser->EditValue)) {
            $this->uuser->EditValue = FormatNumber($this->uuser->EditValue, null);
        }

        // uip
        $this->uip->setupEditAttributes();
        $this->uip->EditCustomAttributes = "";
        if (!$this->uip->Raw) {
            $this->uip->CurrentValue = HtmlDecode($this->uip->CurrentValue);
        }
        $this->uip->EditValue = $this->uip->CurrentValue;
        $this->uip->PlaceHolder = RemoveHtml($this->uip->caption());

        // pay_number
        $this->pay_number->setupEditAttributes();
        $this->pay_number->EditCustomAttributes = "";
        if (!$this->pay_number->Raw) {
            $this->pay_number->CurrentValue = HtmlDecode($this->pay_number->CurrentValue);
        }
        $this->pay_number->EditValue = $this->pay_number->CurrentValue;
        $this->pay_number->PlaceHolder = RemoveHtml($this->pay_number->caption());

        // status_payment
        $this->status_payment->setupEditAttributes();
        $this->status_payment->EditCustomAttributes = "";
        $this->status_payment->EditValue = $this->status_payment->CurrentValue;
        $this->status_payment->PlaceHolder = RemoveHtml($this->status_payment->caption());
        if (strval($this->status_payment->EditValue) != "" && is_numeric($this->status_payment->EditValue)) {
            $this->status_payment->EditValue = FormatNumber($this->status_payment->EditValue, null);
        }

        // asset_id
        $this->asset_id->setupEditAttributes();
        $this->asset_id->EditCustomAttributes = "";
        $this->asset_id->EditValue = $this->asset_id->CurrentValue;
        $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());
        if (strval($this->asset_id->EditValue) != "" && is_numeric($this->asset_id->EditValue)) {
            $this->asset_id->EditValue = FormatNumber($this->asset_id->EditValue, null);
        }

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

        // date_booking
        $this->date_booking->setupEditAttributes();
        $this->date_booking->EditCustomAttributes = "";
        $this->date_booking->EditValue = FormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        $this->date_booking->PlaceHolder = RemoveHtml($this->date_booking->caption());

        // date_payment
        $this->date_payment->setupEditAttributes();
        $this->date_payment->EditCustomAttributes = "";
        $this->date_payment->EditValue = FormatDateTime($this->date_payment->CurrentValue, $this->date_payment->formatPattern());
        $this->date_payment->PlaceHolder = RemoveHtml($this->date_payment->caption());

        // due_date
        $this->due_date->setupEditAttributes();
        $this->due_date->EditCustomAttributes = "";
        $this->due_date->EditValue = FormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern());
        $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());

        // status_expire
        $this->status_expire->setupEditAttributes();
        $this->status_expire->EditCustomAttributes = "";
        $this->status_expire->EditValue = $this->status_expire->CurrentValue;
        $this->status_expire->PlaceHolder = RemoveHtml($this->status_expire->caption());
        if (strval($this->status_expire->EditValue) != "" && is_numeric($this->status_expire->EditValue)) {
            $this->status_expire->EditValue = FormatNumber($this->status_expire->EditValue, null);
        }

        // status_expire_reason
        $this->status_expire_reason->setupEditAttributes();
        $this->status_expire_reason->EditCustomAttributes = "";
        if (!$this->status_expire_reason->Raw) {
            $this->status_expire_reason->CurrentValue = HtmlDecode($this->status_expire_reason->CurrentValue);
        }
        $this->status_expire_reason->EditValue = $this->status_expire_reason->CurrentValue;
        $this->status_expire_reason->PlaceHolder = RemoveHtml($this->status_expire_reason->caption());

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
                    $doc->exportCaption($this->log_buyer_booking_asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->booking_price);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->pay_number);
                    $doc->exportCaption($this->status_payment);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->transaction_datetime);
                    $doc->exportCaption($this->payment_scheme);
                    $doc->exportCaption($this->transaction_ref);
                    $doc->exportCaption($this->channel_response_desc);
                    $doc->exportCaption($this->res_status);
                    $doc->exportCaption($this->res_referenceNo);
                    $doc->exportCaption($this->date_booking);
                    $doc->exportCaption($this->date_payment);
                    $doc->exportCaption($this->due_date);
                    $doc->exportCaption($this->status_expire);
                    $doc->exportCaption($this->status_expire_reason);
                    $doc->exportCaption($this->res_paidAgent);
                    $doc->exportCaption($this->res_paidChannel);
                    $doc->exportCaption($this->res_maskedPan);
                } else {
                    $doc->exportCaption($this->log_buyer_booking_asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->booking_price);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->pay_number);
                    $doc->exportCaption($this->status_payment);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->transaction_datetime);
                    $doc->exportCaption($this->payment_scheme);
                    $doc->exportCaption($this->transaction_ref);
                    $doc->exportCaption($this->channel_response_desc);
                    $doc->exportCaption($this->res_status);
                    $doc->exportCaption($this->res_referenceNo);
                    $doc->exportCaption($this->date_booking);
                    $doc->exportCaption($this->date_payment);
                    $doc->exportCaption($this->due_date);
                    $doc->exportCaption($this->status_expire);
                    $doc->exportCaption($this->status_expire_reason);
                    $doc->exportCaption($this->res_paidAgent);
                    $doc->exportCaption($this->res_paidChannel);
                    $doc->exportCaption($this->res_maskedPan);
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
                        $doc->exportField($this->log_buyer_booking_asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->booking_price);
                        $doc->exportField($this->type);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->pay_number);
                        $doc->exportField($this->status_payment);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->transaction_datetime);
                        $doc->exportField($this->payment_scheme);
                        $doc->exportField($this->transaction_ref);
                        $doc->exportField($this->channel_response_desc);
                        $doc->exportField($this->res_status);
                        $doc->exportField($this->res_referenceNo);
                        $doc->exportField($this->date_booking);
                        $doc->exportField($this->date_payment);
                        $doc->exportField($this->due_date);
                        $doc->exportField($this->status_expire);
                        $doc->exportField($this->status_expire_reason);
                        $doc->exportField($this->res_paidAgent);
                        $doc->exportField($this->res_paidChannel);
                        $doc->exportField($this->res_maskedPan);
                    } else {
                        $doc->exportField($this->log_buyer_booking_asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->booking_price);
                        $doc->exportField($this->type);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->pay_number);
                        $doc->exportField($this->status_payment);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->transaction_datetime);
                        $doc->exportField($this->payment_scheme);
                        $doc->exportField($this->transaction_ref);
                        $doc->exportField($this->channel_response_desc);
                        $doc->exportField($this->res_status);
                        $doc->exportField($this->res_referenceNo);
                        $doc->exportField($this->date_booking);
                        $doc->exportField($this->date_payment);
                        $doc->exportField($this->due_date);
                        $doc->exportField($this->status_expire);
                        $doc->exportField($this->status_expire_reason);
                        $doc->exportField($this->res_paidAgent);
                        $doc->exportField($this->res_paidChannel);
                        $doc->exportField($this->res_maskedPan);
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
