<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for invertor_all_booking
 */
class InvertorAllBooking extends DbTable
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
    public $invertor_booking_id;
    public $asset_id;
    public $member_id;
    public $date_booking;
    public $status_expire;
    public $status_expire_reason;
    public $payment_status;
    public $cdate;
    public $cuser;
    public $cip;
    public $uuser;
    public $uip;
    public $udate;
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
        $this->TableVar = 'invertor_all_booking';
        $this->TableName = 'invertor_all_booking';
        $this->TableType = 'LINKTABLE';

        // Update Table
        $this->UpdateTable = "`invertor_booking`";
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

        // invertor_booking_id
        $this->invertor_booking_id = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
            'x_invertor_booking_id',
            'invertor_booking_id',
            '`invertor_booking_id`',
            '`invertor_booking_id`',
            3,
            11,
            -1,
            false,
            '`invertor_booking_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->invertor_booking_id->InputTextType = "text";
        $this->invertor_booking_id->IsAutoIncrement = true; // Autoincrement field
        $this->invertor_booking_id->IsPrimaryKey = true; // Primary key field
        $this->invertor_booking_id->IsForeignKey = true; // Foreign key field
        $this->invertor_booking_id->Sortable = false; // Allow sort
        $this->invertor_booking_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['invertor_booking_id'] = &$this->invertor_booking_id;

        // asset_id
        $this->asset_id = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
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
            'invertor_all_booking',
            'invertor_all_booking',
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

        // date_booking
        $this->date_booking = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
            'x_date_booking',
            'date_booking',
            '`date_booking`',
            CastDateFieldForLike("`date_booking`", 7, "juzmatch1"),
            135,
            19,
            7,
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
        $this->date_booking->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['date_booking'] = &$this->date_booking;

        // status_expire
        $this->status_expire = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
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
        $this->status_expire->Lookup = new Lookup('status_expire', 'invertor_all_booking', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_expire->OptionCount = 2;
        $this->status_expire->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_expire'] = &$this->status_expire;

        // status_expire_reason
        $this->status_expire_reason = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
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

        // payment_status
        $this->payment_status = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
            'x_payment_status',
            'payment_status',
            '`payment_status`',
            '`payment_status`',
            16,
            4,
            -1,
            false,
            '`payment_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->payment_status->InputTextType = "text";
        $this->payment_status->Nullable = false; // NOT NULL field
        $this->payment_status->Lookup = new Lookup('payment_status', 'invertor_all_booking', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->payment_status->OptionCount = 2;
        $this->payment_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['payment_status'] = &$this->payment_status;

        // cdate
        $this->cdate = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
            'x_cdate',
            'cdate',
            '`cdate`',
            CastDateFieldForLike("`cdate`", 111, "juzmatch1"),
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
        $this->cdate->Sortable = false; // Allow sort
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
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
            'invertor_all_booking',
            'invertor_all_booking',
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
            'invertor_all_booking',
            'invertor_all_booking',
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
            'invertor_all_booking',
            'invertor_all_booking',
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
            'invertor_all_booking',
            'invertor_all_booking',
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

        // is_email
        $this->is_email = new DbField(
            'invertor_all_booking',
            'invertor_all_booking',
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
            'invertor_all_booking',
            'invertor_all_booking',
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
        if ($this->getCurrentDetailTable() == "payment_inverter_booking") {
            $detailUrl = Container("payment_inverter_booking")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "all_asset_config_schedule") {
            $detailUrl = Container("all_asset_config_schedule")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "all_asset_schedule") {
            $detailUrl = Container("all_asset_schedule")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "doc_juzmatch2") {
            $detailUrl = Container("doc_juzmatch2")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_invertor_booking_id", $this->invertor_booking_id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "invertorallbookinglist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`invertor_booking`";
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
            $this->invertor_booking_id->setDbValue($conn->lastInsertId());
            $rs['invertor_booking_id'] = $this->invertor_booking_id->DbValue;
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
            if (array_key_exists('invertor_booking_id', $rs)) {
                AddFilter($where, QuotedName('invertor_booking_id', $this->Dbid) . '=' . QuotedValue($rs['invertor_booking_id'], $this->invertor_booking_id->DataType, $this->Dbid));
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
        $this->invertor_booking_id->DbValue = $row['invertor_booking_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->date_booking->DbValue = $row['date_booking'];
        $this->status_expire->DbValue = $row['status_expire'];
        $this->status_expire_reason->DbValue = $row['status_expire_reason'];
        $this->payment_status->DbValue = $row['payment_status'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->udate->DbValue = $row['udate'];
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
        return "`invertor_booking_id` = @invertor_booking_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->invertor_booking_id->CurrentValue : $this->invertor_booking_id->OldValue;
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
                $this->invertor_booking_id->CurrentValue = $keys[0];
            } else {
                $this->invertor_booking_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('invertor_booking_id', $row) ? $row['invertor_booking_id'] : null;
        } else {
            $val = $this->invertor_booking_id->OldValue !== null ? $this->invertor_booking_id->OldValue : $this->invertor_booking_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@invertor_booking_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("invertorallbookinglist");
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
        if ($pageName == "invertorallbookingview") {
            return $Language->phrase("View");
        } elseif ($pageName == "invertorallbookingedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "invertorallbookingadd") {
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
                return "InvertorAllBookingView";
            case Config("API_ADD_ACTION"):
                return "InvertorAllBookingAdd";
            case Config("API_EDIT_ACTION"):
                return "InvertorAllBookingEdit";
            case Config("API_DELETE_ACTION"):
                return "InvertorAllBookingDelete";
            case Config("API_LIST_ACTION"):
                return "InvertorAllBookingList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "invertorallbookinglist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("invertorallbookingview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("invertorallbookingview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "invertorallbookingadd?" . $this->getUrlParm($parm);
        } else {
            $url = "invertorallbookingadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("invertorallbookingedit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("invertorallbookingedit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("invertorallbookingadd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("invertorallbookingadd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("invertorallbookingdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"invertor_booking_id\":" . JsonEncode($this->invertor_booking_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->invertor_booking_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->invertor_booking_id->CurrentValue);
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
            if (($keyValue = Param("invertor_booking_id") ?? Route("invertor_booking_id")) !== null) {
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
                $this->invertor_booking_id->CurrentValue = $key;
            } else {
                $this->invertor_booking_id->OldValue = $key;
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
        $this->invertor_booking_id->setDbValue($row['invertor_booking_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
        $this->payment_status->setDbValue($row['payment_status']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
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

        // invertor_booking_id
        $this->invertor_booking_id->CellCssStyle = "white-space: nowrap;";

        // asset_id

        // member_id

        // date_booking

        // status_expire

        // status_expire_reason

        // payment_status

        // cdate
        $this->cdate->CellCssStyle = "white-space: nowrap;";

        // cuser
        $this->cuser->CellCssStyle = "white-space: nowrap;";

        // cip
        $this->cip->CellCssStyle = "white-space: nowrap;";

        // uuser
        $this->uuser->CellCssStyle = "white-space: nowrap;";

        // uip
        $this->uip->CellCssStyle = "white-space: nowrap;";

        // udate
        $this->udate->CellCssStyle = "white-space: nowrap;";

        // is_email
        $this->is_email->CellCssStyle = "white-space: nowrap;";

        // receipt_status
        $this->receipt_status->CellCssStyle = "white-space: nowrap;";

        // invertor_booking_id
        $this->invertor_booking_id->ViewValue = $this->invertor_booking_id->CurrentValue;
        $this->invertor_booking_id->ViewCustomAttributes = "";

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

        // date_booking
        $this->date_booking->ViewValue = $this->date_booking->CurrentValue;
        $this->date_booking->ViewValue = FormatDateTime($this->date_booking->ViewValue, $this->date_booking->formatPattern());
        $this->date_booking->ViewCustomAttributes = "";

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

        // payment_status
        if (strval($this->payment_status->CurrentValue) != "") {
            $this->payment_status->ViewValue = $this->payment_status->optionCaption($this->payment_status->CurrentValue);
        } else {
            $this->payment_status->ViewValue = null;
        }
        $this->payment_status->ViewCustomAttributes = "";

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

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
        $this->udate->ViewCustomAttributes = "";

        // is_email
        $this->is_email->ViewValue = $this->is_email->CurrentValue;
        $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
        $this->is_email->ViewCustomAttributes = "";

        // receipt_status
        $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
        $this->receipt_status->ViewValue = FormatNumber($this->receipt_status->ViewValue, $this->receipt_status->formatPattern());
        $this->receipt_status->ViewCustomAttributes = "";

        // invertor_booking_id
        $this->invertor_booking_id->LinkCustomAttributes = "";
        $this->invertor_booking_id->HrefValue = "";
        $this->invertor_booking_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // date_booking
        $this->date_booking->LinkCustomAttributes = "";
        $this->date_booking->HrefValue = "";
        $this->date_booking->TooltipValue = "";

        // status_expire
        $this->status_expire->LinkCustomAttributes = "";
        $this->status_expire->HrefValue = "";
        $this->status_expire->TooltipValue = "";

        // status_expire_reason
        $this->status_expire_reason->LinkCustomAttributes = "";
        $this->status_expire_reason->HrefValue = "";
        $this->status_expire_reason->TooltipValue = "";

        // payment_status
        $this->payment_status->LinkCustomAttributes = "";
        $this->payment_status->HrefValue = "";
        $this->payment_status->TooltipValue = "";

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

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // udate
        $this->udate->LinkCustomAttributes = "";
        $this->udate->HrefValue = "";
        $this->udate->TooltipValue = "";

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

        // invertor_booking_id
        $this->invertor_booking_id->setupEditAttributes();
        $this->invertor_booking_id->EditCustomAttributes = "";
        $this->invertor_booking_id->EditValue = $this->invertor_booking_id->CurrentValue;
        $this->invertor_booking_id->ViewCustomAttributes = "";

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

        // date_booking
        $this->date_booking->setupEditAttributes();
        $this->date_booking->EditCustomAttributes = "";
        $this->date_booking->EditValue = FormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        $this->date_booking->PlaceHolder = RemoveHtml($this->date_booking->caption());

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

        // payment_status
        $this->payment_status->EditCustomAttributes = "";
        $this->payment_status->EditValue = $this->payment_status->options(false);
        $this->payment_status->PlaceHolder = RemoveHtml($this->payment_status->caption());

        // cdate

        // cuser

        // cip

        // uuser

        // uip

        // udate

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
                    $doc->exportCaption($this->invertor_booking_id);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->date_booking);
                    $doc->exportCaption($this->status_expire);
                    $doc->exportCaption($this->status_expire_reason);
                    $doc->exportCaption($this->payment_status);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->date_booking);
                    $doc->exportCaption($this->status_expire);
                    $doc->exportCaption($this->status_expire_reason);
                    $doc->exportCaption($this->payment_status);
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
                        $doc->exportField($this->invertor_booking_id);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->date_booking);
                        $doc->exportField($this->status_expire);
                        $doc->exportField($this->status_expire_reason);
                        $doc->exportField($this->payment_status);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->date_booking);
                        $doc->exportField($this->status_expire);
                        $doc->exportField($this->status_expire_reason);
                        $doc->exportField($this->payment_status);
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
