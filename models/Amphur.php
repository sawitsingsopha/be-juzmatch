<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for amphur
 */
class Amphur extends DbTable
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
    public $amphur_id;
    public $amphur_code;
    public $amphur_name;
    public $amphur_name_en;
    public $geo_id;
    public $province_id;
    public $postcode;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'amphur';
        $this->TableName = 'amphur';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`amphur`";
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

        // amphur_id
        $this->amphur_id = new DbField(
            'amphur',
            'amphur',
            'x_amphur_id',
            'amphur_id',
            '`amphur_id`',
            '`amphur_id`',
            3,
            5,
            -1,
            false,
            '`amphur_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->amphur_id->InputTextType = "text";
        $this->amphur_id->IsAutoIncrement = true; // Autoincrement field
        $this->amphur_id->IsPrimaryKey = true; // Primary key field
        $this->amphur_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['amphur_id'] = &$this->amphur_id;

        // amphur_code
        $this->amphur_code = new DbField(
            'amphur',
            'amphur',
            'x_amphur_code',
            'amphur_code',
            '`amphur_code`',
            '`amphur_code`',
            200,
            4,
            -1,
            false,
            '`amphur_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->amphur_code->InputTextType = "text";
        $this->amphur_code->Nullable = false; // NOT NULL field
        $this->amphur_code->Required = true; // Required field
        $this->Fields['amphur_code'] = &$this->amphur_code;

        // amphur_name
        $this->amphur_name = new DbField(
            'amphur',
            'amphur',
            'x_amphur_name',
            'amphur_name',
            '`amphur_name`',
            '`amphur_name`',
            200,
            150,
            -1,
            false,
            '`amphur_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->amphur_name->InputTextType = "text";
        $this->amphur_name->Nullable = false; // NOT NULL field
        $this->amphur_name->Required = true; // Required field
        $this->Fields['amphur_name'] = &$this->amphur_name;

        // amphur_name_en
        $this->amphur_name_en = new DbField(
            'amphur',
            'amphur',
            'x_amphur_name_en',
            'amphur_name_en',
            '`amphur_name_en`',
            '`amphur_name_en`',
            200,
            150,
            -1,
            false,
            '`amphur_name_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->amphur_name_en->InputTextType = "text";
        $this->amphur_name_en->Nullable = false; // NOT NULL field
        $this->amphur_name_en->Required = true; // Required field
        $this->Fields['amphur_name_en'] = &$this->amphur_name_en;

        // geo_id
        $this->geo_id = new DbField(
            'amphur',
            'amphur',
            'x_geo_id',
            'geo_id',
            '`geo_id`',
            '`geo_id`',
            3,
            5,
            -1,
            false,
            '`geo_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->geo_id->InputTextType = "text";
        $this->geo_id->Nullable = false; // NOT NULL field
        $this->geo_id->Required = true; // Required field
        $this->geo_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['geo_id'] = &$this->geo_id;

        // province_id
        $this->province_id = new DbField(
            'amphur',
            'amphur',
            'x_province_id',
            'province_id',
            '`province_id`',
            '`province_id`',
            3,
            5,
            -1,
            false,
            '`province_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->province_id->InputTextType = "text";
        $this->province_id->Nullable = false; // NOT NULL field
        $this->province_id->Required = true; // Required field
        $this->province_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['province_id'] = &$this->province_id;

        // postcode
        $this->postcode = new DbField(
            'amphur',
            'amphur',
            'x_postcode',
            'postcode',
            '`postcode`',
            '`postcode`',
            3,
            11,
            -1,
            false,
            '`postcode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->postcode->InputTextType = "text";
        $this->postcode->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['postcode'] = &$this->postcode;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`amphur`";
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
            $this->amphur_id->setDbValue($conn->lastInsertId());
            $rs['amphur_id'] = $this->amphur_id->DbValue;
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
            if (array_key_exists('amphur_id', $rs)) {
                AddFilter($where, QuotedName('amphur_id', $this->Dbid) . '=' . QuotedValue($rs['amphur_id'], $this->amphur_id->DataType, $this->Dbid));
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
        $this->amphur_id->DbValue = $row['amphur_id'];
        $this->amphur_code->DbValue = $row['amphur_code'];
        $this->amphur_name->DbValue = $row['amphur_name'];
        $this->amphur_name_en->DbValue = $row['amphur_name_en'];
        $this->geo_id->DbValue = $row['geo_id'];
        $this->province_id->DbValue = $row['province_id'];
        $this->postcode->DbValue = $row['postcode'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`amphur_id` = @amphur_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->amphur_id->CurrentValue : $this->amphur_id->OldValue;
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
                $this->amphur_id->CurrentValue = $keys[0];
            } else {
                $this->amphur_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('amphur_id', $row) ? $row['amphur_id'] : null;
        } else {
            $val = $this->amphur_id->OldValue !== null ? $this->amphur_id->OldValue : $this->amphur_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@amphur_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("amphurlist");
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
        if ($pageName == "amphurview") {
            return $Language->phrase("View");
        } elseif ($pageName == "amphuredit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "amphuradd") {
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
                return "AmphurView";
            case Config("API_ADD_ACTION"):
                return "AmphurAdd";
            case Config("API_EDIT_ACTION"):
                return "AmphurEdit";
            case Config("API_DELETE_ACTION"):
                return "AmphurDelete";
            case Config("API_LIST_ACTION"):
                return "AmphurList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "amphurlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("amphurview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("amphurview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "amphuradd?" . $this->getUrlParm($parm);
        } else {
            $url = "amphuradd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("amphuredit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("amphuradd", $this->getUrlParm($parm));
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
        return $this->keyUrl("amphurdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"amphur_id\":" . JsonEncode($this->amphur_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->amphur_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->amphur_id->CurrentValue);
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
            if (($keyValue = Param("amphur_id") ?? Route("amphur_id")) !== null) {
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
                $this->amphur_id->CurrentValue = $key;
            } else {
                $this->amphur_id->OldValue = $key;
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
        $this->amphur_id->setDbValue($row['amphur_id']);
        $this->amphur_code->setDbValue($row['amphur_code']);
        $this->amphur_name->setDbValue($row['amphur_name']);
        $this->amphur_name_en->setDbValue($row['amphur_name_en']);
        $this->geo_id->setDbValue($row['geo_id']);
        $this->province_id->setDbValue($row['province_id']);
        $this->postcode->setDbValue($row['postcode']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // amphur_id

        // amphur_code

        // amphur_name

        // amphur_name_en

        // geo_id

        // province_id

        // postcode

        // amphur_id
        $this->amphur_id->ViewValue = $this->amphur_id->CurrentValue;
        $this->amphur_id->ViewCustomAttributes = "";

        // amphur_code
        $this->amphur_code->ViewValue = $this->amphur_code->CurrentValue;
        $this->amphur_code->ViewCustomAttributes = "";

        // amphur_name
        $this->amphur_name->ViewValue = $this->amphur_name->CurrentValue;
        $this->amphur_name->ViewCustomAttributes = "";

        // amphur_name_en
        $this->amphur_name_en->ViewValue = $this->amphur_name_en->CurrentValue;
        $this->amphur_name_en->ViewCustomAttributes = "";

        // geo_id
        $this->geo_id->ViewValue = $this->geo_id->CurrentValue;
        $this->geo_id->ViewValue = FormatNumber($this->geo_id->ViewValue, $this->geo_id->formatPattern());
        $this->geo_id->ViewCustomAttributes = "";

        // province_id
        $this->province_id->ViewValue = $this->province_id->CurrentValue;
        $this->province_id->ViewValue = FormatNumber($this->province_id->ViewValue, $this->province_id->formatPattern());
        $this->province_id->ViewCustomAttributes = "";

        // postcode
        $this->postcode->ViewValue = $this->postcode->CurrentValue;
        $this->postcode->ViewValue = FormatNumber($this->postcode->ViewValue, $this->postcode->formatPattern());
        $this->postcode->ViewCustomAttributes = "";

        // amphur_id
        $this->amphur_id->LinkCustomAttributes = "";
        $this->amphur_id->HrefValue = "";
        $this->amphur_id->TooltipValue = "";

        // amphur_code
        $this->amphur_code->LinkCustomAttributes = "";
        $this->amphur_code->HrefValue = "";
        $this->amphur_code->TooltipValue = "";

        // amphur_name
        $this->amphur_name->LinkCustomAttributes = "";
        $this->amphur_name->HrefValue = "";
        $this->amphur_name->TooltipValue = "";

        // amphur_name_en
        $this->amphur_name_en->LinkCustomAttributes = "";
        $this->amphur_name_en->HrefValue = "";
        $this->amphur_name_en->TooltipValue = "";

        // geo_id
        $this->geo_id->LinkCustomAttributes = "";
        $this->geo_id->HrefValue = "";
        $this->geo_id->TooltipValue = "";

        // province_id
        $this->province_id->LinkCustomAttributes = "";
        $this->province_id->HrefValue = "";
        $this->province_id->TooltipValue = "";

        // postcode
        $this->postcode->LinkCustomAttributes = "";
        $this->postcode->HrefValue = "";
        $this->postcode->TooltipValue = "";

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

        // amphur_id
        $this->amphur_id->setupEditAttributes();
        $this->amphur_id->EditCustomAttributes = "";
        $this->amphur_id->EditValue = $this->amphur_id->CurrentValue;
        $this->amphur_id->ViewCustomAttributes = "";

        // amphur_code
        $this->amphur_code->setupEditAttributes();
        $this->amphur_code->EditCustomAttributes = "";
        if (!$this->amphur_code->Raw) {
            $this->amphur_code->CurrentValue = HtmlDecode($this->amphur_code->CurrentValue);
        }
        $this->amphur_code->EditValue = $this->amphur_code->CurrentValue;
        $this->amphur_code->PlaceHolder = RemoveHtml($this->amphur_code->caption());

        // amphur_name
        $this->amphur_name->setupEditAttributes();
        $this->amphur_name->EditCustomAttributes = "";
        if (!$this->amphur_name->Raw) {
            $this->amphur_name->CurrentValue = HtmlDecode($this->amphur_name->CurrentValue);
        }
        $this->amphur_name->EditValue = $this->amphur_name->CurrentValue;
        $this->amphur_name->PlaceHolder = RemoveHtml($this->amphur_name->caption());

        // amphur_name_en
        $this->amphur_name_en->setupEditAttributes();
        $this->amphur_name_en->EditCustomAttributes = "";
        if (!$this->amphur_name_en->Raw) {
            $this->amphur_name_en->CurrentValue = HtmlDecode($this->amphur_name_en->CurrentValue);
        }
        $this->amphur_name_en->EditValue = $this->amphur_name_en->CurrentValue;
        $this->amphur_name_en->PlaceHolder = RemoveHtml($this->amphur_name_en->caption());

        // geo_id
        $this->geo_id->setupEditAttributes();
        $this->geo_id->EditCustomAttributes = "";
        $this->geo_id->EditValue = $this->geo_id->CurrentValue;
        $this->geo_id->PlaceHolder = RemoveHtml($this->geo_id->caption());
        if (strval($this->geo_id->EditValue) != "" && is_numeric($this->geo_id->EditValue)) {
            $this->geo_id->EditValue = FormatNumber($this->geo_id->EditValue, null);
        }

        // province_id
        $this->province_id->setupEditAttributes();
        $this->province_id->EditCustomAttributes = "";
        $this->province_id->EditValue = $this->province_id->CurrentValue;
        $this->province_id->PlaceHolder = RemoveHtml($this->province_id->caption());
        if (strval($this->province_id->EditValue) != "" && is_numeric($this->province_id->EditValue)) {
            $this->province_id->EditValue = FormatNumber($this->province_id->EditValue, null);
        }

        // postcode
        $this->postcode->setupEditAttributes();
        $this->postcode->EditCustomAttributes = "";
        $this->postcode->EditValue = $this->postcode->CurrentValue;
        $this->postcode->PlaceHolder = RemoveHtml($this->postcode->caption());
        if (strval($this->postcode->EditValue) != "" && is_numeric($this->postcode->EditValue)) {
            $this->postcode->EditValue = FormatNumber($this->postcode->EditValue, null);
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
                    $doc->exportCaption($this->amphur_id);
                    $doc->exportCaption($this->amphur_code);
                    $doc->exportCaption($this->amphur_name);
                    $doc->exportCaption($this->amphur_name_en);
                    $doc->exportCaption($this->geo_id);
                    $doc->exportCaption($this->province_id);
                    $doc->exportCaption($this->postcode);
                } else {
                    $doc->exportCaption($this->amphur_id);
                    $doc->exportCaption($this->amphur_code);
                    $doc->exportCaption($this->amphur_name);
                    $doc->exportCaption($this->amphur_name_en);
                    $doc->exportCaption($this->geo_id);
                    $doc->exportCaption($this->province_id);
                    $doc->exportCaption($this->postcode);
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
                        $doc->exportField($this->amphur_id);
                        $doc->exportField($this->amphur_code);
                        $doc->exportField($this->amphur_name);
                        $doc->exportField($this->amphur_name_en);
                        $doc->exportField($this->geo_id);
                        $doc->exportField($this->province_id);
                        $doc->exportField($this->postcode);
                    } else {
                        $doc->exportField($this->amphur_id);
                        $doc->exportField($this->amphur_code);
                        $doc->exportField($this->amphur_name);
                        $doc->exportField($this->amphur_name_en);
                        $doc->exportField($this->geo_id);
                        $doc->exportField($this->province_id);
                        $doc->exportField($this->postcode);
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
