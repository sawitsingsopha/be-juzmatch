<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for number_of_unpaid_units
 */
class NumberOfUnpaidUnits extends DbTable
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
    public $buyer_config_asset_schedule_id;
    public $member_id;
    public $asset_id;
    public $asset_code;
    public $_title;
    public $asset_price;
    public $price_paid;
    public $remaining_price;
    public $expiration_date;
    public $accrued_period_diff;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'number_of_unpaid_units';
        $this->TableName = 'number_of_unpaid_units';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`number_of_unpaid_units`";
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

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
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
            'NO'
        );
        $this->buyer_config_asset_schedule_id->InputTextType = "text";
        $this->buyer_config_asset_schedule_id->IsForeignKey = true; // Foreign key field
        $this->buyer_config_asset_schedule_id->Nullable = false; // NOT NULL field
        $this->buyer_config_asset_schedule_id->Sortable = false; // Allow sort
        $this->buyer_config_asset_schedule_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buyer_config_asset_schedule_id'] = &$this->buyer_config_asset_schedule_id;

        // member_id
        $this->member_id = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
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
        $this->member_id->Sortable = false; // Allow sort
        $this->member_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->member_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // asset_id
        $this->asset_id = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
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
        $this->asset_id->Sortable = false; // Allow sort
        $this->asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_id'] = &$this->asset_id;

        // asset_code
        $this->asset_code = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
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
            'number_of_unpaid_units',
            'number_of_unpaid_units',
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
        $this->_title->Required = true; // Required field
        $this->Fields['title'] = &$this->_title;

        // asset_price
        $this->asset_price = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
            'x_asset_price',
            'asset_price',
            '`asset_price`',
            '`asset_price`',
            5,
            23,
            -1,
            false,
            '`asset_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->asset_price->InputTextType = "text";
        $this->asset_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['asset_price'] = &$this->asset_price;

        // price_paid
        $this->price_paid = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
            'x_price_paid',
            'price_paid',
            '`price_paid`',
            '`price_paid`',
            5,
            23,
            -1,
            false,
            '`price_paid`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_paid->InputTextType = "text";
        $this->price_paid->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_paid'] = &$this->price_paid;

        // remaining_price
        $this->remaining_price = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
            'x_remaining_price',
            'remaining_price',
            '`remaining_price`',
            '`remaining_price`',
            5,
            23,
            -1,
            false,
            '`remaining_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remaining_price->InputTextType = "text";
        $this->remaining_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remaining_price'] = &$this->remaining_price;

        // expiration_date
        $this->expiration_date = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
            'x_expiration_date',
            'expiration_date',
            '`expiration_date`',
            CastDateFieldForLike("`expiration_date`", 111, "DB"),
            135,
            19,
            111,
            false,
            '`expiration_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->expiration_date->InputTextType = "text";
        $this->expiration_date->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['expiration_date'] = &$this->expiration_date;

        // accrued_period_diff
        $this->accrued_period_diff = new DbField(
            'number_of_unpaid_units',
            'number_of_unpaid_units',
            'x_accrued_period_diff',
            'accrued_period_diff',
            '`accrued_period_diff`',
            '`accrued_period_diff`',
            3,
            7,
            -1,
            false,
            '`accrued_period_diff`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->accrued_period_diff->InputTextType = "text";
        $this->accrued_period_diff->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['accrued_period_diff'] = &$this->accrued_period_diff;

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
        if ($this->getCurrentDetailTable() == "all_buyer_asset_schedule") {
            $detailUrl = Container("all_buyer_asset_schedule")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_buyer_config_asset_schedule_id", $this->buyer_config_asset_schedule_id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "numberofunpaidunitslist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`number_of_unpaid_units`";
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
        $this->buyer_config_asset_schedule_id->DbValue = $row['buyer_config_asset_schedule_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->asset_code->DbValue = $row['asset_code'];
        $this->_title->DbValue = $row['title'];
        $this->asset_price->DbValue = $row['asset_price'];
        $this->price_paid->DbValue = $row['price_paid'];
        $this->remaining_price->DbValue = $row['remaining_price'];
        $this->expiration_date->DbValue = $row['expiration_date'];
        $this->accrued_period_diff->DbValue = $row['accrued_period_diff'];
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
        return $_SESSION[$name] ?? GetUrl("numberofunpaidunitslist");
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
        if ($pageName == "numberofunpaidunitsview") {
            return $Language->phrase("View");
        } elseif ($pageName == "numberofunpaidunitsedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "numberofunpaidunitsadd") {
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
                return "NumberOfUnpaidUnitsView";
            case Config("API_ADD_ACTION"):
                return "NumberOfUnpaidUnitsAdd";
            case Config("API_EDIT_ACTION"):
                return "NumberOfUnpaidUnitsEdit";
            case Config("API_DELETE_ACTION"):
                return "NumberOfUnpaidUnitsDelete";
            case Config("API_LIST_ACTION"):
                return "NumberOfUnpaidUnitsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "numberofunpaidunitslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("numberofunpaidunitsview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("numberofunpaidunitsview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "numberofunpaidunitsadd?" . $this->getUrlParm($parm);
        } else {
            $url = "numberofunpaidunitsadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("numberofunpaidunitsedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("numberofunpaidunitsadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("numberofunpaidunitsdelete", $this->getUrlParm());
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
        $this->buyer_config_asset_schedule_id->setDbValue($row['buyer_config_asset_schedule_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->_title->setDbValue($row['title']);
        $this->asset_price->setDbValue($row['asset_price']);
        $this->price_paid->setDbValue($row['price_paid']);
        $this->remaining_price->setDbValue($row['remaining_price']);
        $this->expiration_date->setDbValue($row['expiration_date']);
        $this->accrued_period_diff->setDbValue($row['accrued_period_diff']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // asset_id

        // asset_code

        // title

        // asset_price

        // price_paid

        // remaining_price

        // expiration_date

        // accrued_period_diff

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->ViewValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->ViewCustomAttributes = "";

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

        // asset_id
        $this->asset_id->ViewValue = $this->asset_id->CurrentValue;
        $this->asset_id->ViewCustomAttributes = "";

        // asset_code
        $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
        $this->asset_code->ViewCustomAttributes = "";

        // title
        $this->_title->ViewValue = $this->_title->CurrentValue;
        $this->_title->ViewCustomAttributes = "";

        // asset_price
        $this->asset_price->ViewValue = $this->asset_price->CurrentValue;
        $this->asset_price->ViewValue = FormatCurrency($this->asset_price->ViewValue, $this->asset_price->formatPattern());
        $this->asset_price->ViewCustomAttributes = "";

        // price_paid
        $this->price_paid->ViewValue = $this->price_paid->CurrentValue;
        $this->price_paid->ViewValue = FormatCurrency($this->price_paid->ViewValue, $this->price_paid->formatPattern());
        $this->price_paid->ViewCustomAttributes = "";

        // remaining_price
        $this->remaining_price->ViewValue = $this->remaining_price->CurrentValue;
        $this->remaining_price->ViewValue = FormatCurrency($this->remaining_price->ViewValue, $this->remaining_price->formatPattern());
        $this->remaining_price->ViewCustomAttributes = "";

        // expiration_date
        $this->expiration_date->ViewValue = $this->expiration_date->CurrentValue;
        $this->expiration_date->ViewValue = FormatDateTime($this->expiration_date->ViewValue, $this->expiration_date->formatPattern());
        $this->expiration_date->ViewCustomAttributes = "";

        // accrued_period_diff
        $this->accrued_period_diff->ViewValue = $this->accrued_period_diff->CurrentValue;
        $this->accrued_period_diff->ViewValue = FormatNumber($this->accrued_period_diff->ViewValue, $this->accrued_period_diff->formatPattern());
        $this->accrued_period_diff->ViewCustomAttributes = "";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->LinkCustomAttributes = "";
        $this->buyer_config_asset_schedule_id->HrefValue = "";
        $this->buyer_config_asset_schedule_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // asset_code
        $this->asset_code->LinkCustomAttributes = "";
        $this->asset_code->HrefValue = "";
        $this->asset_code->TooltipValue = "";

        // title
        $this->_title->LinkCustomAttributes = "";
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // asset_price
        $this->asset_price->LinkCustomAttributes = "";
        $this->asset_price->HrefValue = "";
        $this->asset_price->TooltipValue = "";

        // price_paid
        $this->price_paid->LinkCustomAttributes = "";
        $this->price_paid->HrefValue = "";
        $this->price_paid->TooltipValue = "";

        // remaining_price
        $this->remaining_price->LinkCustomAttributes = "";
        $this->remaining_price->HrefValue = "";
        $this->remaining_price->TooltipValue = "";

        // expiration_date
        $this->expiration_date->LinkCustomAttributes = "";
        $this->expiration_date->HrefValue = "";
        $this->expiration_date->TooltipValue = "";

        // accrued_period_diff
        $this->accrued_period_diff->LinkCustomAttributes = "";
        $this->accrued_period_diff->HrefValue = "";
        $this->accrued_period_diff->TooltipValue = "";

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

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->setupEditAttributes();
        $this->buyer_config_asset_schedule_id->EditCustomAttributes = "";
        $this->buyer_config_asset_schedule_id->EditValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->PlaceHolder = RemoveHtml($this->buyer_config_asset_schedule_id->caption());
        if (strval($this->buyer_config_asset_schedule_id->EditValue) != "" && is_numeric($this->buyer_config_asset_schedule_id->EditValue)) {
            $this->buyer_config_asset_schedule_id->EditValue = $this->buyer_config_asset_schedule_id->EditValue;
        }

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

        // asset_id
        $this->asset_id->setupEditAttributes();
        $this->asset_id->EditCustomAttributes = "";
        $this->asset_id->EditValue = $this->asset_id->CurrentValue;
        $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());
        if (strval($this->asset_id->EditValue) != "" && is_numeric($this->asset_id->EditValue)) {
            $this->asset_id->EditValue = $this->asset_id->EditValue;
        }

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

        // asset_price
        $this->asset_price->setupEditAttributes();
        $this->asset_price->EditCustomAttributes = "";
        $this->asset_price->EditValue = $this->asset_price->CurrentValue;
        $this->asset_price->PlaceHolder = RemoveHtml($this->asset_price->caption());
        if (strval($this->asset_price->EditValue) != "" && is_numeric($this->asset_price->EditValue)) {
            $this->asset_price->EditValue = FormatNumber($this->asset_price->EditValue, null);
        }

        // price_paid
        $this->price_paid->setupEditAttributes();
        $this->price_paid->EditCustomAttributes = "";
        $this->price_paid->EditValue = $this->price_paid->CurrentValue;
        $this->price_paid->PlaceHolder = RemoveHtml($this->price_paid->caption());
        if (strval($this->price_paid->EditValue) != "" && is_numeric($this->price_paid->EditValue)) {
            $this->price_paid->EditValue = FormatNumber($this->price_paid->EditValue, null);
        }

        // remaining_price
        $this->remaining_price->setupEditAttributes();
        $this->remaining_price->EditCustomAttributes = "";
        $this->remaining_price->EditValue = $this->remaining_price->CurrentValue;
        $this->remaining_price->PlaceHolder = RemoveHtml($this->remaining_price->caption());
        if (strval($this->remaining_price->EditValue) != "" && is_numeric($this->remaining_price->EditValue)) {
            $this->remaining_price->EditValue = FormatNumber($this->remaining_price->EditValue, null);
        }

        // expiration_date
        $this->expiration_date->setupEditAttributes();
        $this->expiration_date->EditCustomAttributes = "";
        $this->expiration_date->EditValue = FormatDateTime($this->expiration_date->CurrentValue, $this->expiration_date->formatPattern());
        $this->expiration_date->PlaceHolder = RemoveHtml($this->expiration_date->caption());

        // accrued_period_diff
        $this->accrued_period_diff->setupEditAttributes();
        $this->accrued_period_diff->EditCustomAttributes = "";
        $this->accrued_period_diff->EditValue = $this->accrued_period_diff->CurrentValue;
        $this->accrued_period_diff->PlaceHolder = RemoveHtml($this->accrued_period_diff->caption());
        if (strval($this->accrued_period_diff->EditValue) != "" && is_numeric($this->accrued_period_diff->EditValue)) {
            $this->accrued_period_diff->EditValue = FormatNumber($this->accrued_period_diff->EditValue, null);
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
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->asset_price);
                    $doc->exportCaption($this->price_paid);
                    $doc->exportCaption($this->remaining_price);
                    $doc->exportCaption($this->expiration_date);
                    $doc->exportCaption($this->accrued_period_diff);
                } else {
                    $doc->exportCaption($this->asset_code);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->asset_price);
                    $doc->exportCaption($this->price_paid);
                    $doc->exportCaption($this->remaining_price);
                    $doc->exportCaption($this->expiration_date);
                    $doc->exportCaption($this->accrued_period_diff);
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
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->asset_price);
                        $doc->exportField($this->price_paid);
                        $doc->exportField($this->remaining_price);
                        $doc->exportField($this->expiration_date);
                        $doc->exportField($this->accrued_period_diff);
                    } else {
                        $doc->exportField($this->asset_code);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->asset_price);
                        $doc->exportField($this->price_paid);
                        $doc->exportField($this->remaining_price);
                        $doc->exportField($this->expiration_date);
                        $doc->exportField($this->accrued_period_diff);
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
