<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for brand
 */
class Brand extends DbTable
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
    public $brand_id;
    public $brand_name;
    public $brand_name_en;
    public $company_name;
    public $company_name_en;
    public $icon;
    public $order_by;
    public $isactive;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uip;
    public $uuser;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'brand';
        $this->TableName = 'brand';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`brand`";
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

        // brand_id
        $this->brand_id = new DbField(
            'brand',
            'brand',
            'x_brand_id',
            'brand_id',
            '`brand_id`',
            '`brand_id`',
            3,
            11,
            -1,
            false,
            '`brand_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->brand_id->InputTextType = "text";
        $this->brand_id->IsAutoIncrement = true; // Autoincrement field
        $this->brand_id->IsPrimaryKey = true; // Primary key field
        $this->brand_id->Sortable = false; // Allow sort
        $this->brand_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['brand_id'] = &$this->brand_id;

        // brand_name
        $this->brand_name = new DbField(
            'brand',
            'brand',
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
        $this->brand_name->Nullable = false; // NOT NULL field
        $this->brand_name->Required = true; // Required field
        $this->Fields['brand_name'] = &$this->brand_name;

        // brand_name_en
        $this->brand_name_en = new DbField(
            'brand',
            'brand',
            'x_brand_name_en',
            'brand_name_en',
            '`brand_name_en`',
            '`brand_name_en`',
            200,
            255,
            -1,
            false,
            '`brand_name_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->brand_name_en->InputTextType = "text";
        $this->Fields['brand_name_en'] = &$this->brand_name_en;

        // company_name
        $this->company_name = new DbField(
            'brand',
            'brand',
            'x_company_name',
            'company_name',
            '`company_name`',
            '`company_name`',
            200,
            255,
            -1,
            false,
            '`company_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->company_name->InputTextType = "text";
        $this->company_name->Required = true; // Required field
        $this->Fields['company_name'] = &$this->company_name;

        // company_name_en
        $this->company_name_en = new DbField(
            'brand',
            'brand',
            'x_company_name_en',
            'company_name_en',
            '`company_name_en`',
            '`company_name_en`',
            200,
            255,
            -1,
            false,
            '`company_name_en`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->company_name_en->InputTextType = "text";
        $this->company_name_en->Required = true; // Required field
        $this->Fields['company_name_en'] = &$this->company_name_en;

        // icon
        $this->icon = new DbField(
            'brand',
            'brand',
            'x_icon',
            'icon',
            '`icon`',
            '`icon`',
            200,
            255,
            -1,
            false,
            '`icon`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->icon->InputTextType = "text";
        $this->icon->Required = true; // Required field
        $this->icon->Sortable = false; // Allow sort
        $this->Fields['icon'] = &$this->icon;

        // order_by
        $this->order_by = new DbField(
            'brand',
            'brand',
            'x_order_by',
            'order_by',
            '`order_by`',
            '`order_by`',
            3,
            11,
            -1,
            false,
            '`order_by`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->order_by->InputTextType = "text";
        $this->order_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['order_by'] = &$this->order_by;

        // isactive
        $this->isactive = new DbField(
            'brand',
            'brand',
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
        $this->isactive->Lookup = new Lookup('isactive', 'brand', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->isactive->OptionCount = 2;
        $this->isactive->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isactive'] = &$this->isactive;

        // cdate
        $this->cdate = new DbField(
            'brand',
            'brand',
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
            'brand',
            'brand',
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
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'brand',
            'brand',
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
        $this->Fields['cip'] = &$this->cip;

        // udate
        $this->udate = new DbField(
            'brand',
            'brand',
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
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uip
        $this->uip = new DbField(
            'brand',
            'brand',
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
        $this->Fields['uip'] = &$this->uip;

        // uuser
        $this->uuser = new DbField(
            'brand',
            'brand',
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
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`brand`";
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
            $this->brand_id->setDbValue($conn->lastInsertId());
            $rs['brand_id'] = $this->brand_id->DbValue;
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
            $fldname = 'brand_id';
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
            if (array_key_exists('brand_id', $rs)) {
                AddFilter($where, QuotedName('brand_id', $this->Dbid) . '=' . QuotedValue($rs['brand_id'], $this->brand_id->DataType, $this->Dbid));
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
        $this->brand_id->DbValue = $row['brand_id'];
        $this->brand_name->DbValue = $row['brand_name'];
        $this->brand_name_en->DbValue = $row['brand_name_en'];
        $this->company_name->DbValue = $row['company_name'];
        $this->company_name_en->DbValue = $row['company_name_en'];
        $this->icon->DbValue = $row['icon'];
        $this->order_by->DbValue = $row['order_by'];
        $this->isactive->DbValue = $row['isactive'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uip->DbValue = $row['uip'];
        $this->uuser->DbValue = $row['uuser'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`brand_id` = @brand_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->brand_id->CurrentValue : $this->brand_id->OldValue;
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
                $this->brand_id->CurrentValue = $keys[0];
            } else {
                $this->brand_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('brand_id', $row) ? $row['brand_id'] : null;
        } else {
            $val = $this->brand_id->OldValue !== null ? $this->brand_id->OldValue : $this->brand_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@brand_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("brandlist");
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
        if ($pageName == "brandview") {
            return $Language->phrase("View");
        } elseif ($pageName == "brandedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "brandadd") {
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
                return "BrandView";
            case Config("API_ADD_ACTION"):
                return "BrandAdd";
            case Config("API_EDIT_ACTION"):
                return "BrandEdit";
            case Config("API_DELETE_ACTION"):
                return "BrandDelete";
            case Config("API_LIST_ACTION"):
                return "BrandList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "brandlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("brandview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("brandview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "brandadd?" . $this->getUrlParm($parm);
        } else {
            $url = "brandadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("brandedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("brandadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("branddelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"brand_id\":" . JsonEncode($this->brand_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->brand_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->brand_id->CurrentValue);
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
            if (($keyValue = Param("brand_id") ?? Route("brand_id")) !== null) {
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
                $this->brand_id->CurrentValue = $key;
            } else {
                $this->brand_id->OldValue = $key;
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
        $this->brand_id->setDbValue($row['brand_id']);
        $this->brand_name->setDbValue($row['brand_name']);
        $this->brand_name_en->setDbValue($row['brand_name_en']);
        $this->company_name->setDbValue($row['company_name']);
        $this->company_name_en->setDbValue($row['company_name_en']);
        $this->icon->setDbValue($row['icon']);
        $this->order_by->setDbValue($row['order_by']);
        $this->isactive->setDbValue($row['isactive']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uip->setDbValue($row['uip']);
        $this->uuser->setDbValue($row['uuser']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // brand_id
        $this->brand_id->CellCssStyle = "white-space: nowrap;";

        // brand_name

        // brand_name_en

        // company_name

        // company_name_en

        // icon
        $this->icon->CellCssStyle = "white-space: nowrap;";

        // order_by

        // isactive

        // cdate

        // cuser

        // cip

        // udate

        // uip

        // uuser

        // brand_id
        $this->brand_id->ViewValue = $this->brand_id->CurrentValue;
        $this->brand_id->ViewCustomAttributes = "";

        // brand_name
        $this->brand_name->ViewValue = $this->brand_name->CurrentValue;
        $this->brand_name->ViewCustomAttributes = "";

        // brand_name_en
        $this->brand_name_en->ViewValue = $this->brand_name_en->CurrentValue;
        $this->brand_name_en->ViewCustomAttributes = "";

        // company_name
        $this->company_name->ViewValue = $this->company_name->CurrentValue;
        $this->company_name->ViewCustomAttributes = "";

        // company_name_en
        $this->company_name_en->ViewValue = $this->company_name_en->CurrentValue;
        $this->company_name_en->ViewCustomAttributes = "";

        // icon
        $this->icon->ViewValue = $this->icon->CurrentValue;
        $this->icon->ViewCustomAttributes = "";

        // order_by
        $this->order_by->ViewValue = $this->order_by->CurrentValue;
        $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
        $this->order_by->ViewCustomAttributes = "";

        // isactive
        if (strval($this->isactive->CurrentValue) != "") {
            $this->isactive->ViewValue = $this->isactive->optionCaption($this->isactive->CurrentValue);
        } else {
            $this->isactive->ViewValue = null;
        }
        $this->isactive->ViewCustomAttributes = "";

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

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
        $this->uuser->ViewCustomAttributes = "";

        // brand_id
        $this->brand_id->LinkCustomAttributes = "";
        $this->brand_id->HrefValue = "";
        $this->brand_id->TooltipValue = "";

        // brand_name
        $this->brand_name->LinkCustomAttributes = "";
        $this->brand_name->HrefValue = "";
        $this->brand_name->TooltipValue = "";

        // brand_name_en
        $this->brand_name_en->LinkCustomAttributes = "";
        $this->brand_name_en->HrefValue = "";
        $this->brand_name_en->TooltipValue = "";

        // company_name
        $this->company_name->LinkCustomAttributes = "";
        $this->company_name->HrefValue = "";
        $this->company_name->TooltipValue = "";

        // company_name_en
        $this->company_name_en->LinkCustomAttributes = "";
        $this->company_name_en->HrefValue = "";
        $this->company_name_en->TooltipValue = "";

        // icon
        $this->icon->LinkCustomAttributes = "";
        $this->icon->HrefValue = "";
        $this->icon->TooltipValue = "";

        // order_by
        $this->order_by->LinkCustomAttributes = "";
        $this->order_by->HrefValue = "";
        $this->order_by->TooltipValue = "";

        // isactive
        $this->isactive->LinkCustomAttributes = "";
        $this->isactive->HrefValue = "";
        $this->isactive->TooltipValue = "";

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

        // uip
        $this->uip->LinkCustomAttributes = "";
        $this->uip->HrefValue = "";
        $this->uip->TooltipValue = "";

        // uuser
        $this->uuser->LinkCustomAttributes = "";
        $this->uuser->HrefValue = "";
        $this->uuser->TooltipValue = "";

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

        // brand_id
        $this->brand_id->setupEditAttributes();
        $this->brand_id->EditCustomAttributes = "";
        $this->brand_id->EditValue = $this->brand_id->CurrentValue;
        $this->brand_id->ViewCustomAttributes = "";

        // brand_name
        $this->brand_name->setupEditAttributes();
        $this->brand_name->EditCustomAttributes = "";
        if (!$this->brand_name->Raw) {
            $this->brand_name->CurrentValue = HtmlDecode($this->brand_name->CurrentValue);
        }
        $this->brand_name->EditValue = $this->brand_name->CurrentValue;
        $this->brand_name->PlaceHolder = RemoveHtml($this->brand_name->caption());

        // brand_name_en
        $this->brand_name_en->setupEditAttributes();
        $this->brand_name_en->EditCustomAttributes = "";
        if (!$this->brand_name_en->Raw) {
            $this->brand_name_en->CurrentValue = HtmlDecode($this->brand_name_en->CurrentValue);
        }
        $this->brand_name_en->EditValue = $this->brand_name_en->CurrentValue;
        $this->brand_name_en->PlaceHolder = RemoveHtml($this->brand_name_en->caption());

        // company_name
        $this->company_name->setupEditAttributes();
        $this->company_name->EditCustomAttributes = "";
        if (!$this->company_name->Raw) {
            $this->company_name->CurrentValue = HtmlDecode($this->company_name->CurrentValue);
        }
        $this->company_name->EditValue = $this->company_name->CurrentValue;
        $this->company_name->PlaceHolder = RemoveHtml($this->company_name->caption());

        // company_name_en
        $this->company_name_en->setupEditAttributes();
        $this->company_name_en->EditCustomAttributes = "";
        if (!$this->company_name_en->Raw) {
            $this->company_name_en->CurrentValue = HtmlDecode($this->company_name_en->CurrentValue);
        }
        $this->company_name_en->EditValue = $this->company_name_en->CurrentValue;
        $this->company_name_en->PlaceHolder = RemoveHtml($this->company_name_en->caption());

        // icon
        $this->icon->setupEditAttributes();
        $this->icon->EditCustomAttributes = "";
        if (!$this->icon->Raw) {
            $this->icon->CurrentValue = HtmlDecode($this->icon->CurrentValue);
        }
        $this->icon->EditValue = $this->icon->CurrentValue;
        $this->icon->PlaceHolder = RemoveHtml($this->icon->caption());

        // order_by
        $this->order_by->setupEditAttributes();
        $this->order_by->EditCustomAttributes = "";
        $this->order_by->EditValue = $this->order_by->CurrentValue;
        $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());
        if (strval($this->order_by->EditValue) != "" && is_numeric($this->order_by->EditValue)) {
            $this->order_by->EditValue = FormatNumber($this->order_by->EditValue, null);
        }

        // isactive
        $this->isactive->EditCustomAttributes = "";
        $this->isactive->EditValue = $this->isactive->options(false);
        $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

        // cdate

        // cuser

        // cip

        // udate

        // uip

        // uuser

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
                    $doc->exportCaption($this->brand_name);
                    $doc->exportCaption($this->brand_name_en);
                    $doc->exportCaption($this->company_name);
                    $doc->exportCaption($this->company_name_en);
                    $doc->exportCaption($this->order_by);
                    $doc->exportCaption($this->isactive);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->uuser);
                } else {
                    $doc->exportCaption($this->brand_name);
                    $doc->exportCaption($this->brand_name_en);
                    $doc->exportCaption($this->company_name);
                    $doc->exportCaption($this->company_name_en);
                    $doc->exportCaption($this->order_by);
                    $doc->exportCaption($this->isactive);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->uuser);
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
                        $doc->exportField($this->brand_name);
                        $doc->exportField($this->brand_name_en);
                        $doc->exportField($this->company_name);
                        $doc->exportField($this->company_name_en);
                        $doc->exportField($this->order_by);
                        $doc->exportField($this->isactive);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->uuser);
                    } else {
                        $doc->exportField($this->brand_name);
                        $doc->exportField($this->brand_name_en);
                        $doc->exportField($this->company_name);
                        $doc->exportField($this->company_name_en);
                        $doc->exportField($this->order_by);
                        $doc->exportField($this->isactive);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->uuser);
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
        $table = 'brand';
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
        $table = 'brand';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['brand_id'];

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
        $table = 'brand';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['brand_id'];

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
        $table = 'brand';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['brand_id'];

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
