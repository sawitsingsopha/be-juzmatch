<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for asset_all_facilities_view
 */
class AssetAllFacilitiesView extends DbTable
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
    public $master_facilities_group_id;
    public $group_title;
    public $group_title_en;
    public $master_facilities_id;
    public $_title;
    public $title_en;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'asset_all_facilities_view';
        $this->TableName = 'asset_all_facilities_view';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`asset_all_facilities_view`";
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

        // master_facilities_group_id
        $this->master_facilities_group_id = new DbField(
            'asset_all_facilities_view',
            'asset_all_facilities_view',
            'x_master_facilities_group_id',
            'master_facilities_group_id',
            '`master_facilities_group_id`',
            '`master_facilities_group_id`',
            3,
            11,
            -1,
            false,
            '`master_facilities_group_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->master_facilities_group_id->InputTextType = "text";
        $this->master_facilities_group_id->IsAutoIncrement = true; // Autoincrement field
        $this->master_facilities_group_id->IsPrimaryKey = true; // Primary key field
        $this->master_facilities_group_id->Sortable = false; // Allow sort
        $this->master_facilities_group_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->master_facilities_group_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->master_facilities_group_id->Lookup = new Lookup('master_facilities_group_id', 'master_facilities_group', false, 'master_facilities_group_id', ["title","","",""], [], [], [], [], [], [], '`title` ASC', '', "`title`");
        $this->master_facilities_group_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['master_facilities_group_id'] = &$this->master_facilities_group_id;

        // group_title
        $this->group_title = new DbField(
            'asset_all_facilities_view',
            'asset_all_facilities_view',
            'x_group_title',
            'group_title',
            '`group_title`',
            '`group_title`',
            200,
            100,
            -1,
            false,
            '`group_title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->group_title->InputTextType = "text";
        $this->group_title->Nullable = false; // NOT NULL field
        $this->group_title->Required = true; // Required field
        $this->Fields['group_title'] = &$this->group_title;

        // group_title_en
        $this->group_title_en = new DbField(
            'asset_all_facilities_view',
            'asset_all_facilities_view',
            'x_group_title_en',
            'group_title_en',
            '`group_title_en`',
            '`group_title_en`',
            200,
            100,
            -1,
            false,
            '`group_title_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->group_title_en->InputTextType = "text";
        $this->group_title_en->Nullable = false; // NOT NULL field
        $this->group_title_en->Required = true; // Required field
        $this->Fields['group_title_en'] = &$this->group_title_en;

        // master_facilities_id
        $this->master_facilities_id = new DbField(
            'asset_all_facilities_view',
            'asset_all_facilities_view',
            'x_master_facilities_id',
            'master_facilities_id',
            '`master_facilities_id`',
            '`master_facilities_id`',
            3,
            11,
            -1,
            false,
            '`master_facilities_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->master_facilities_id->InputTextType = "text";
        $this->master_facilities_id->IsAutoIncrement = true; // Autoincrement field
        $this->master_facilities_id->IsPrimaryKey = true; // Primary key field
        $this->master_facilities_id->Sortable = false; // Allow sort
        $this->master_facilities_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['master_facilities_id'] = &$this->master_facilities_id;

        // title
        $this->_title = new DbField(
            'asset_all_facilities_view',
            'asset_all_facilities_view',
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
            'asset_all_facilities_view',
            'asset_all_facilities_view',
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
        $this->title_en->Nullable = false; // NOT NULL field
        $this->title_en->Required = true; // Required field
        $this->Fields['title_en'] = &$this->title_en;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`asset_all_facilities_view`";
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
            $this->master_facilities_group_id->setDbValue($conn->lastInsertId());
            $rs['master_facilities_group_id'] = $this->master_facilities_group_id->DbValue;

            // Get insert id if necessary
            $this->master_facilities_id->setDbValue($conn->lastInsertId());
            $rs['master_facilities_id'] = $this->master_facilities_id->DbValue;
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
            if (array_key_exists('master_facilities_group_id', $rs)) {
                AddFilter($where, QuotedName('master_facilities_group_id', $this->Dbid) . '=' . QuotedValue($rs['master_facilities_group_id'], $this->master_facilities_group_id->DataType, $this->Dbid));
            }
            if (array_key_exists('master_facilities_id', $rs)) {
                AddFilter($where, QuotedName('master_facilities_id', $this->Dbid) . '=' . QuotedValue($rs['master_facilities_id'], $this->master_facilities_id->DataType, $this->Dbid));
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
        $this->master_facilities_group_id->DbValue = $row['master_facilities_group_id'];
        $this->group_title->DbValue = $row['group_title'];
        $this->group_title_en->DbValue = $row['group_title_en'];
        $this->master_facilities_id->DbValue = $row['master_facilities_id'];
        $this->_title->DbValue = $row['title'];
        $this->title_en->DbValue = $row['title_en'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`master_facilities_group_id` = @master_facilities_group_id@ AND `master_facilities_id` = @master_facilities_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->master_facilities_group_id->CurrentValue : $this->master_facilities_group_id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->master_facilities_id->CurrentValue : $this->master_facilities_id->OldValue;
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
        if (count($keys) == 2) {
            if ($current) {
                $this->master_facilities_group_id->CurrentValue = $keys[0];
            } else {
                $this->master_facilities_group_id->OldValue = $keys[0];
            }
            if ($current) {
                $this->master_facilities_id->CurrentValue = $keys[1];
            } else {
                $this->master_facilities_id->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('master_facilities_group_id', $row) ? $row['master_facilities_group_id'] : null;
        } else {
            $val = $this->master_facilities_group_id->OldValue !== null ? $this->master_facilities_group_id->OldValue : $this->master_facilities_group_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@master_facilities_group_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('master_facilities_id', $row) ? $row['master_facilities_id'] : null;
        } else {
            $val = $this->master_facilities_id->OldValue !== null ? $this->master_facilities_id->OldValue : $this->master_facilities_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@master_facilities_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("assetallfacilitiesviewlist");
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
        if ($pageName == "assetallfacilitiesviewview") {
            return $Language->phrase("View");
        } elseif ($pageName == "assetallfacilitiesviewedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "assetallfacilitiesviewadd") {
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
                return "AssetAllFacilitiesViewView";
            case Config("API_ADD_ACTION"):
                return "AssetAllFacilitiesViewAdd";
            case Config("API_EDIT_ACTION"):
                return "AssetAllFacilitiesViewEdit";
            case Config("API_DELETE_ACTION"):
                return "AssetAllFacilitiesViewDelete";
            case Config("API_LIST_ACTION"):
                return "AssetAllFacilitiesViewList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "assetallfacilitiesviewlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("assetallfacilitiesviewview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("assetallfacilitiesviewview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "assetallfacilitiesviewadd?" . $this->getUrlParm($parm);
        } else {
            $url = "assetallfacilitiesviewadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("assetallfacilitiesviewedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("assetallfacilitiesviewadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("assetallfacilitiesviewdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"master_facilities_group_id\":" . JsonEncode($this->master_facilities_group_id->CurrentValue, "number");
        $json .= ",\"master_facilities_id\":" . JsonEncode($this->master_facilities_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->master_facilities_group_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->master_facilities_group_id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->master_facilities_id->CurrentValue !== null) {
            $url .= $this->RouteCompositeKeySeparator . $this->encodeKeyValue($this->master_facilities_id->CurrentValue);
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("master_facilities_group_id") ?? Route("master_facilities_group_id")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("master_facilities_id") ?? Route("master_facilities_id")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
                }
                if (!is_numeric($key[0])) { // master_facilities_group_id
                    continue;
                }
                if (!is_numeric($key[1])) { // master_facilities_id
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
                $this->master_facilities_group_id->CurrentValue = $key[0];
            } else {
                $this->master_facilities_group_id->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->master_facilities_id->CurrentValue = $key[1];
            } else {
                $this->master_facilities_id->OldValue = $key[1];
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
        $this->master_facilities_group_id->setDbValue($row['master_facilities_group_id']);
        $this->group_title->setDbValue($row['group_title']);
        $this->group_title_en->setDbValue($row['group_title_en']);
        $this->master_facilities_id->setDbValue($row['master_facilities_id']);
        $this->_title->setDbValue($row['title']);
        $this->title_en->setDbValue($row['title_en']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // master_facilities_group_id
        $this->master_facilities_group_id->CellCssStyle = "white-space: nowrap;";

        // group_title

        // group_title_en

        // master_facilities_id
        $this->master_facilities_id->CellCssStyle = "white-space: nowrap;";

        // title

        // title_en

        // master_facilities_group_id
        $curVal = strval($this->master_facilities_group_id->CurrentValue);
        if ($curVal != "") {
            $this->master_facilities_group_id->ViewValue = $this->master_facilities_group_id->lookupCacheOption($curVal);
            if ($this->master_facilities_group_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`master_facilities_group_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->master_facilities_group_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->master_facilities_group_id->Lookup->renderViewRow($rswrk[0]);
                    $this->master_facilities_group_id->ViewValue = $this->master_facilities_group_id->displayValue($arwrk);
                } else {
                    $this->master_facilities_group_id->ViewValue = FormatNumber($this->master_facilities_group_id->CurrentValue, $this->master_facilities_group_id->formatPattern());
                }
            }
        } else {
            $this->master_facilities_group_id->ViewValue = null;
        }
        $this->master_facilities_group_id->ViewCustomAttributes = "";

        // group_title
        $this->group_title->ViewValue = $this->group_title->CurrentValue;
        $this->group_title->ViewCustomAttributes = "";

        // group_title_en
        $this->group_title_en->ViewValue = $this->group_title_en->CurrentValue;
        $this->group_title_en->ViewCustomAttributes = "";

        // master_facilities_id
        $this->master_facilities_id->ViewValue = $this->master_facilities_id->CurrentValue;
        $this->master_facilities_id->ViewCustomAttributes = "";

        // title
        $this->_title->ViewValue = $this->_title->CurrentValue;
        $this->_title->ViewCustomAttributes = "";

        // title_en
        $this->title_en->ViewValue = $this->title_en->CurrentValue;
        $this->title_en->ViewCustomAttributes = "";

        // master_facilities_group_id
        $this->master_facilities_group_id->LinkCustomAttributes = "";
        $this->master_facilities_group_id->HrefValue = "";
        $this->master_facilities_group_id->TooltipValue = "";

        // group_title
        $this->group_title->LinkCustomAttributes = "";
        $this->group_title->HrefValue = "";
        $this->group_title->TooltipValue = "";

        // group_title_en
        $this->group_title_en->LinkCustomAttributes = "";
        $this->group_title_en->HrefValue = "";
        $this->group_title_en->TooltipValue = "";

        // master_facilities_id
        $this->master_facilities_id->LinkCustomAttributes = "";
        $this->master_facilities_id->HrefValue = "";
        $this->master_facilities_id->TooltipValue = "";

        // title
        $this->_title->LinkCustomAttributes = "";
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // title_en
        $this->title_en->LinkCustomAttributes = "";
        $this->title_en->HrefValue = "";
        $this->title_en->TooltipValue = "";

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

        // master_facilities_group_id
        $this->master_facilities_group_id->setupEditAttributes();
        $this->master_facilities_group_id->EditCustomAttributes = "";
        $curVal = strval($this->master_facilities_group_id->CurrentValue);
        if ($curVal != "") {
            $this->master_facilities_group_id->EditValue = $this->master_facilities_group_id->lookupCacheOption($curVal);
            if ($this->master_facilities_group_id->EditValue === null) { // Lookup from database
                $filterWrk = "`master_facilities_group_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->master_facilities_group_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->master_facilities_group_id->Lookup->renderViewRow($rswrk[0]);
                    $this->master_facilities_group_id->EditValue = $this->master_facilities_group_id->displayValue($arwrk);
                } else {
                    $this->master_facilities_group_id->EditValue = FormatNumber($this->master_facilities_group_id->CurrentValue, $this->master_facilities_group_id->formatPattern());
                }
            }
        } else {
            $this->master_facilities_group_id->EditValue = null;
        }
        $this->master_facilities_group_id->ViewCustomAttributes = "";

        // group_title
        $this->group_title->setupEditAttributes();
        $this->group_title->EditCustomAttributes = "";
        if (!$this->group_title->Raw) {
            $this->group_title->CurrentValue = HtmlDecode($this->group_title->CurrentValue);
        }
        $this->group_title->EditValue = $this->group_title->CurrentValue;
        $this->group_title->PlaceHolder = RemoveHtml($this->group_title->caption());

        // group_title_en
        $this->group_title_en->setupEditAttributes();
        $this->group_title_en->EditCustomAttributes = "";
        if (!$this->group_title_en->Raw) {
            $this->group_title_en->CurrentValue = HtmlDecode($this->group_title_en->CurrentValue);
        }
        $this->group_title_en->EditValue = $this->group_title_en->CurrentValue;
        $this->group_title_en->PlaceHolder = RemoveHtml($this->group_title_en->caption());

        // master_facilities_id
        $this->master_facilities_id->setupEditAttributes();
        $this->master_facilities_id->EditCustomAttributes = "";
        $this->master_facilities_id->EditValue = $this->master_facilities_id->CurrentValue;
        $this->master_facilities_id->ViewCustomAttributes = "";

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
                    $doc->exportCaption($this->group_title);
                    $doc->exportCaption($this->group_title_en);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->title_en);
                } else {
                    $doc->exportCaption($this->group_title);
                    $doc->exportCaption($this->group_title_en);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->title_en);
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
                        $doc->exportField($this->group_title);
                        $doc->exportField($this->group_title_en);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->title_en);
                    } else {
                        $doc->exportField($this->group_title);
                        $doc->exportField($this->group_title_en);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->title_en);
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
