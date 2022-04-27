<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for assetReport
 */
class AssetReport extends DbTable
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
    public $asset_code;
    public $_title;
    public $brand_name;
    public $full_address;
    public $asset_status;
    public $price;
    public $booking_name;
    public $date_booking;
    public $booking_price;
    public $due_date;
    public $status_payment;
    public $date_payment;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'assetReport';
        $this->TableName = 'assetReport';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`assetReport`";
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

        // asset_code
        $this->asset_code = new DbField(
            'assetReport',
            'assetReport',
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

        // title
        $this->_title = new DbField(
            'assetReport',
            'assetReport',
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

        // brand_name
        $this->brand_name = new DbField(
            'assetReport',
            'assetReport',
            'x_brand_name',
            'brand_name',
            '`brand_name`',
            '`brand_name`',
            200,
            255,
            -1,
            false,
            '`brand_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->brand_name->InputTextType = "text";
        $this->brand_name->Required = true; // Required field
        $this->Fields['brand_name'] = &$this->brand_name;

        // full_address
        $this->full_address = new DbField(
            'assetReport',
            'assetReport',
            'x_full_address',
            'full_address',
            '`full_address`',
            '`full_address`',
            201,
            16777215,
            -1,
            false,
            '`full_address`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->full_address->InputTextType = "text";
        $this->Fields['full_address'] = &$this->full_address;

        // asset_status
        $this->asset_status = new DbField(
            'assetReport',
            'assetReport',
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
        $this->asset_status->Lookup = new Lookup('asset_status', 'assetReport', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->asset_status->OptionCount = 8;
        $this->asset_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_status'] = &$this->asset_status;

        // price
        $this->price = new DbField(
            'assetReport',
            'assetReport',
            'x_price',
            'price',
            '`price`',
            '`price`',
            200,
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
        $this->Fields['price'] = &$this->price;

        // booking_name
        $this->booking_name = new DbField(
            'assetReport',
            'assetReport',
            'x_booking_name',
            'booking_name',
            '`booking_name`',
            '`booking_name`',
            200,
            201,
            -1,
            false,
            '`booking_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->booking_name->InputTextType = "text";
        $this->Fields['booking_name'] = &$this->booking_name;

        // date_booking
        $this->date_booking = new DbField(
            'assetReport',
            'assetReport',
            'x_date_booking',
            'date_booking',
            '`date_booking`',
            CastDateFieldForLike("`date_booking`", 7, "DB"),
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

        // booking_price
        $this->booking_price = new DbField(
            'assetReport',
            'assetReport',
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

        // due_date
        $this->due_date = new DbField(
            'assetReport',
            'assetReport',
            'x_due_date',
            'due_date',
            '`due_date`',
            CastDateFieldForLike("`due_date`", 7, "DB"),
            135,
            19,
            7,
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
        $this->due_date->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['due_date'] = &$this->due_date;

        // status_payment
        $this->status_payment = new DbField(
            'assetReport',
            'assetReport',
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
        $this->status_payment->Lookup = new Lookup('status_payment', 'assetReport', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_payment->OptionCount = 3;
        $this->status_payment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_payment'] = &$this->status_payment;

        // date_payment
        $this->date_payment = new DbField(
            'assetReport',
            'assetReport',
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
        $this->date_payment->Required = true; // Required field
        $this->date_payment->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['date_payment'] = &$this->date_payment;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`assetReport`";
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
        $this->asset_code->DbValue = $row['asset_code'];
        $this->_title->DbValue = $row['title'];
        $this->brand_name->DbValue = $row['brand_name'];
        $this->full_address->DbValue = $row['full_address'];
        $this->asset_status->DbValue = $row['asset_status'];
        $this->price->DbValue = $row['price'];
        $this->booking_name->DbValue = $row['booking_name'];
        $this->date_booking->DbValue = $row['date_booking'];
        $this->booking_price->DbValue = $row['booking_price'];
        $this->due_date->DbValue = $row['due_date'];
        $this->status_payment->DbValue = $row['status_payment'];
        $this->date_payment->DbValue = $row['date_payment'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 0) {
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
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
        return $_SESSION[$name] ?? GetUrl("assetreportlist");
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
        if ($pageName == "assetreportview") {
            return $Language->phrase("View");
        } elseif ($pageName == "assetreportedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "assetreportadd") {
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
                return "AssetReportView";
            case Config("API_ADD_ACTION"):
                return "AssetReportAdd";
            case Config("API_EDIT_ACTION"):
                return "AssetReportEdit";
            case Config("API_DELETE_ACTION"):
                return "AssetReportDelete";
            case Config("API_LIST_ACTION"):
                return "AssetReportList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "assetreportlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("assetreportview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("assetreportview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "assetreportadd?" . $this->getUrlParm($parm);
        } else {
            $url = "assetreportadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("assetreportedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("assetreportadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("assetreportdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
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
            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
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
        $this->asset_code->setDbValue($row['asset_code']);
        $this->_title->setDbValue($row['title']);
        $this->brand_name->setDbValue($row['brand_name']);
        $this->full_address->setDbValue($row['full_address']);
        $this->asset_status->setDbValue($row['asset_status']);
        $this->price->setDbValue($row['price']);
        $this->booking_name->setDbValue($row['booking_name']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->due_date->setDbValue($row['due_date']);
        $this->status_payment->setDbValue($row['status_payment']);
        $this->date_payment->setDbValue($row['date_payment']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // asset_code

        // title

        // brand_name

        // full_address

        // asset_status

        // price

        // booking_name

        // date_booking

        // booking_price

        // due_date

        // status_payment

        // date_payment

        // asset_code
        $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
        $this->asset_code->ViewCustomAttributes = "";

        // title
        $this->_title->ViewValue = $this->_title->CurrentValue;
        $this->_title->ViewCustomAttributes = "";

        // brand_name
        $this->brand_name->ViewValue = $this->brand_name->CurrentValue;
        $this->brand_name->ViewCustomAttributes = "";

        // full_address
        $this->full_address->ViewValue = $this->full_address->CurrentValue;
        $this->full_address->ViewCustomAttributes = "";

        // asset_status
        if (strval($this->asset_status->CurrentValue) != "") {
            $this->asset_status->ViewValue = $this->asset_status->optionCaption($this->asset_status->CurrentValue);
        } else {
            $this->asset_status->ViewValue = null;
        }
        $this->asset_status->ViewCustomAttributes = "";

        // price
        $this->price->ViewValue = $this->price->CurrentValue;
        $this->price->ViewCustomAttributes = "";

        // booking_name
        $this->booking_name->ViewValue = $this->booking_name->CurrentValue;
        $this->booking_name->ViewCustomAttributes = "";

        // date_booking
        $this->date_booking->ViewValue = $this->date_booking->CurrentValue;
        $this->date_booking->ViewValue = FormatDateTime($this->date_booking->ViewValue, $this->date_booking->formatPattern());
        $this->date_booking->ViewCustomAttributes = "";

        // booking_price
        $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
        $this->booking_price->ViewValue = FormatCurrency($this->booking_price->ViewValue, $this->booking_price->formatPattern());
        $this->booking_price->ViewCustomAttributes = "";

        // due_date
        $this->due_date->ViewValue = $this->due_date->CurrentValue;
        $this->due_date->ViewValue = FormatDateTime($this->due_date->ViewValue, $this->due_date->formatPattern());
        $this->due_date->ViewCustomAttributes = "";

        // status_payment
        if (strval($this->status_payment->CurrentValue) != "") {
            $this->status_payment->ViewValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
        } else {
            $this->status_payment->ViewValue = null;
        }
        $this->status_payment->ViewCustomAttributes = "";

        // date_payment
        $this->date_payment->ViewValue = $this->date_payment->CurrentValue;
        $this->date_payment->ViewValue = FormatDateTime($this->date_payment->ViewValue, $this->date_payment->formatPattern());
        $this->date_payment->ViewCustomAttributes = "";

        // asset_code
        $this->asset_code->LinkCustomAttributes = "";
        $this->asset_code->HrefValue = "";
        $this->asset_code->TooltipValue = "";

        // title
        $this->_title->LinkCustomAttributes = "";
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // brand_name
        $this->brand_name->LinkCustomAttributes = "";
        $this->brand_name->HrefValue = "";
        $this->brand_name->TooltipValue = "";

        // full_address
        $this->full_address->LinkCustomAttributes = "";
        $this->full_address->HrefValue = "";
        $this->full_address->TooltipValue = "";

        // asset_status
        $this->asset_status->LinkCustomAttributes = "";
        $this->asset_status->HrefValue = "";
        $this->asset_status->TooltipValue = "";

        // price
        $this->price->LinkCustomAttributes = "";
        $this->price->HrefValue = "";
        $this->price->TooltipValue = "";

        // booking_name
        $this->booking_name->LinkCustomAttributes = "";
        $this->booking_name->HrefValue = "";
        $this->booking_name->TooltipValue = "";

        // date_booking
        $this->date_booking->LinkCustomAttributes = "";
        $this->date_booking->HrefValue = "";
        $this->date_booking->TooltipValue = "";

        // booking_price
        $this->booking_price->LinkCustomAttributes = "";
        $this->booking_price->HrefValue = "";
        $this->booking_price->TooltipValue = "";

        // due_date
        $this->due_date->LinkCustomAttributes = "";
        $this->due_date->HrefValue = "";
        $this->due_date->TooltipValue = "";

        // status_payment
        $this->status_payment->LinkCustomAttributes = "";
        $this->status_payment->HrefValue = "";
        $this->status_payment->TooltipValue = "";

        // date_payment
        $this->date_payment->LinkCustomAttributes = "";
        $this->date_payment->HrefValue = "";
        $this->date_payment->TooltipValue = "";

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

        // asset_code
        $this->asset_code->setupEditAttributes();
        $this->asset_code->EditCustomAttributes = "";
        $this->asset_code->EditValue = $this->asset_code->CurrentValue;
        $this->asset_code->ViewCustomAttributes = "";

        // title
        $this->_title->setupEditAttributes();
        $this->_title->EditCustomAttributes = "";
        if (!$this->_title->Raw) {
            $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
        }
        $this->_title->EditValue = $this->_title->CurrentValue;
        $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

        // brand_name
        $this->brand_name->setupEditAttributes();
        $this->brand_name->EditCustomAttributes = "";
        if (!$this->brand_name->Raw) {
            $this->brand_name->CurrentValue = HtmlDecode($this->brand_name->CurrentValue);
        }
        $this->brand_name->EditValue = $this->brand_name->CurrentValue;
        $this->brand_name->PlaceHolder = RemoveHtml($this->brand_name->caption());

        // full_address
        $this->full_address->setupEditAttributes();
        $this->full_address->EditCustomAttributes = "";
        $this->full_address->EditValue = $this->full_address->CurrentValue;
        $this->full_address->PlaceHolder = RemoveHtml($this->full_address->caption());

        // asset_status
        $this->asset_status->setupEditAttributes();
        $this->asset_status->EditCustomAttributes = "";
        $this->asset_status->EditValue = $this->asset_status->options(true);
        $this->asset_status->PlaceHolder = RemoveHtml($this->asset_status->caption());

        // price
        $this->price->setupEditAttributes();
        $this->price->EditCustomAttributes = "";
        if (!$this->price->Raw) {
            $this->price->CurrentValue = HtmlDecode($this->price->CurrentValue);
        }
        $this->price->EditValue = $this->price->CurrentValue;
        $this->price->PlaceHolder = RemoveHtml($this->price->caption());

        // booking_name
        $this->booking_name->setupEditAttributes();
        $this->booking_name->EditCustomAttributes = "";
        if (!$this->booking_name->Raw) {
            $this->booking_name->CurrentValue = HtmlDecode($this->booking_name->CurrentValue);
        }
        $this->booking_name->EditValue = $this->booking_name->CurrentValue;
        $this->booking_name->PlaceHolder = RemoveHtml($this->booking_name->caption());

        // date_booking
        $this->date_booking->setupEditAttributes();
        $this->date_booking->EditCustomAttributes = "";
        $this->date_booking->EditValue = $this->date_booking->CurrentValue;
        $this->date_booking->EditValue = FormatDateTime($this->date_booking->EditValue, $this->date_booking->formatPattern());
        $this->date_booking->ViewCustomAttributes = "";

        // booking_price
        $this->booking_price->setupEditAttributes();
        $this->booking_price->EditCustomAttributes = "";
        $this->booking_price->EditValue = $this->booking_price->CurrentValue;
        $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
        if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
            $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
        }

        // due_date
        $this->due_date->setupEditAttributes();
        $this->due_date->EditCustomAttributes = "";
        $this->due_date->EditValue = FormatDateTime($this->due_date->CurrentValue, $this->due_date->formatPattern());
        $this->due_date->PlaceHolder = RemoveHtml($this->due_date->caption());

        // status_payment
        $this->status_payment->setupEditAttributes();
        $this->status_payment->EditCustomAttributes = "";
        if (strval($this->status_payment->CurrentValue) != "") {
            $this->status_payment->EditValue = $this->status_payment->optionCaption($this->status_payment->CurrentValue);
        } else {
            $this->status_payment->EditValue = null;
        }
        $this->status_payment->ViewCustomAttributes = "";

        // date_payment
        $this->date_payment->setupEditAttributes();
        $this->date_payment->EditCustomAttributes = "";
        $this->date_payment->EditValue = $this->date_payment->CurrentValue;
        $this->date_payment->EditValue = FormatDateTime($this->date_payment->EditValue, $this->date_payment->formatPattern());
        $this->date_payment->ViewCustomAttributes = "";

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
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->brand_name);
                    $doc->exportCaption($this->full_address);
                    $doc->exportCaption($this->asset_status);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->booking_name);
                    $doc->exportCaption($this->date_booking);
                    $doc->exportCaption($this->booking_price);
                    $doc->exportCaption($this->due_date);
                    $doc->exportCaption($this->status_payment);
                    $doc->exportCaption($this->date_payment);
                } else {
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->brand_name);
                    $doc->exportCaption($this->full_address);
                    $doc->exportCaption($this->asset_status);
                    $doc->exportCaption($this->price);
                    $doc->exportCaption($this->booking_name);
                    $doc->exportCaption($this->date_booking);
                    $doc->exportCaption($this->booking_price);
                    $doc->exportCaption($this->due_date);
                    $doc->exportCaption($this->status_payment);
                    $doc->exportCaption($this->date_payment);
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
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->brand_name);
                        $doc->exportField($this->full_address);
                        $doc->exportField($this->asset_status);
                        $doc->exportField($this->price);
                        $doc->exportField($this->booking_name);
                        $doc->exportField($this->date_booking);
                        $doc->exportField($this->booking_price);
                        $doc->exportField($this->due_date);
                        $doc->exportField($this->status_payment);
                        $doc->exportField($this->date_payment);
                    } else {
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->brand_name);
                        $doc->exportField($this->full_address);
                        $doc->exportField($this->asset_status);
                        $doc->exportField($this->price);
                        $doc->exportField($this->booking_name);
                        $doc->exportField($this->date_booking);
                        $doc->exportField($this->booking_price);
                        $doc->exportField($this->due_date);
                        $doc->exportField($this->status_payment);
                        $doc->exportField($this->date_payment);
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
