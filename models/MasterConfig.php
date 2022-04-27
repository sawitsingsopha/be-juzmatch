<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for master_config
 */
class MasterConfig extends DbTable
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
    public $master_config_id;
    public $price_booking_invertor;
    public $price_booking_buyer;
    public $down_payment_buyer;
    public $code_asset_seller;
    public $code_asset_buyer;
    public $code_asset_juzmatch;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'master_config';
        $this->TableName = 'master_config';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`master_config`";
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

        // master_config_id
        $this->master_config_id = new DbField(
            'master_config',
            'master_config',
            'x_master_config_id',
            'master_config_id',
            '`master_config_id`',
            '`master_config_id`',
            3,
            11,
            -1,
            false,
            '`master_config_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->master_config_id->InputTextType = "text";
        $this->master_config_id->IsAutoIncrement = true; // Autoincrement field
        $this->master_config_id->IsPrimaryKey = true; // Primary key field
        $this->master_config_id->Sortable = false; // Allow sort
        $this->master_config_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['master_config_id'] = &$this->master_config_id;

        // price_booking_invertor
        $this->price_booking_invertor = new DbField(
            'master_config',
            'master_config',
            'x_price_booking_invertor',
            'price_booking_invertor',
            '`price_booking_invertor`',
            '`price_booking_invertor`',
            4,
            12,
            -1,
            false,
            '`price_booking_invertor`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_booking_invertor->InputTextType = "text";
        $this->price_booking_invertor->Nullable = false; // NOT NULL field
        $this->price_booking_invertor->Required = true; // Required field
        $this->price_booking_invertor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_booking_invertor'] = &$this->price_booking_invertor;

        // price_booking_buyer
        $this->price_booking_buyer = new DbField(
            'master_config',
            'master_config',
            'x_price_booking_buyer',
            'price_booking_buyer',
            '`price_booking_buyer`',
            '`price_booking_buyer`',
            4,
            12,
            -1,
            false,
            '`price_booking_buyer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->price_booking_buyer->InputTextType = "text";
        $this->price_booking_buyer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['price_booking_buyer'] = &$this->price_booking_buyer;

        // down_payment_buyer
        $this->down_payment_buyer = new DbField(
            'master_config',
            'master_config',
            'x_down_payment_buyer',
            'down_payment_buyer',
            '`down_payment_buyer`',
            '`down_payment_buyer`',
            4,
            12,
            -1,
            false,
            '`down_payment_buyer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_payment_buyer->InputTextType = "text";
        $this->down_payment_buyer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_payment_buyer'] = &$this->down_payment_buyer;

        // code_asset_seller
        $this->code_asset_seller = new DbField(
            'master_config',
            'master_config',
            'x_code_asset_seller',
            'code_asset_seller',
            '`code_asset_seller`',
            '`code_asset_seller`',
            200,
            10,
            -1,
            false,
            '`code_asset_seller`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->code_asset_seller->InputTextType = "text";
        $this->code_asset_seller->Nullable = false; // NOT NULL field
        $this->code_asset_seller->Required = true; // Required field
        $this->Fields['code_asset_seller'] = &$this->code_asset_seller;

        // code_asset_buyer
        $this->code_asset_buyer = new DbField(
            'master_config',
            'master_config',
            'x_code_asset_buyer',
            'code_asset_buyer',
            '`code_asset_buyer`',
            '`code_asset_buyer`',
            200,
            10,
            -1,
            false,
            '`code_asset_buyer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->code_asset_buyer->InputTextType = "text";
        $this->code_asset_buyer->Nullable = false; // NOT NULL field
        $this->code_asset_buyer->Required = true; // Required field
        $this->Fields['code_asset_buyer'] = &$this->code_asset_buyer;

        // code_asset_juzmatch
        $this->code_asset_juzmatch = new DbField(
            'master_config',
            'master_config',
            'x_code_asset_juzmatch',
            'code_asset_juzmatch',
            '`code_asset_juzmatch`',
            '`code_asset_juzmatch`',
            200,
            10,
            -1,
            false,
            '`code_asset_juzmatch`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->code_asset_juzmatch->InputTextType = "text";
        $this->code_asset_juzmatch->Nullable = false; // NOT NULL field
        $this->code_asset_juzmatch->Required = true; // Required field
        $this->Fields['code_asset_juzmatch'] = &$this->code_asset_juzmatch;

        // cdate
        $this->cdate = new DbField(
            'master_config',
            'master_config',
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
        $this->cdate->Sortable = false; // Allow sort
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(111), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'master_config',
            'master_config',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            200,
            50,
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
        $this->cuser->Sortable = false; // Allow sort
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'master_config',
            'master_config',
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
        $this->cip->Sortable = false; // Allow sort
        $this->Fields['cip'] = &$this->cip;

        // udate
        $this->udate = new DbField(
            'master_config',
            'master_config',
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
        $this->udate->Sortable = false; // Allow sort
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // uuser
        $this->uuser = new DbField(
            'master_config',
            'master_config',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            200,
            50,
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
        $this->uuser->Sortable = false; // Allow sort
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'master_config',
            'master_config',
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
        $this->uip->Sortable = false; // Allow sort
        $this->Fields['uip'] = &$this->uip;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`master_config`";
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
            $this->master_config_id->setDbValue($conn->lastInsertId());
            $rs['master_config_id'] = $this->master_config_id->DbValue;
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
            if (array_key_exists('master_config_id', $rs)) {
                AddFilter($where, QuotedName('master_config_id', $this->Dbid) . '=' . QuotedValue($rs['master_config_id'], $this->master_config_id->DataType, $this->Dbid));
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
        $this->master_config_id->DbValue = $row['master_config_id'];
        $this->price_booking_invertor->DbValue = $row['price_booking_invertor'];
        $this->price_booking_buyer->DbValue = $row['price_booking_buyer'];
        $this->down_payment_buyer->DbValue = $row['down_payment_buyer'];
        $this->code_asset_seller->DbValue = $row['code_asset_seller'];
        $this->code_asset_buyer->DbValue = $row['code_asset_buyer'];
        $this->code_asset_juzmatch->DbValue = $row['code_asset_juzmatch'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`master_config_id` = @master_config_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->master_config_id->CurrentValue : $this->master_config_id->OldValue;
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
                $this->master_config_id->CurrentValue = $keys[0];
            } else {
                $this->master_config_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('master_config_id', $row) ? $row['master_config_id'] : null;
        } else {
            $val = $this->master_config_id->OldValue !== null ? $this->master_config_id->OldValue : $this->master_config_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@master_config_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("masterconfiglist");
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
        if ($pageName == "masterconfigview") {
            return $Language->phrase("View");
        } elseif ($pageName == "masterconfigedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "masterconfigadd") {
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
                return "MasterConfigView";
            case Config("API_ADD_ACTION"):
                return "MasterConfigAdd";
            case Config("API_EDIT_ACTION"):
                return "MasterConfigEdit";
            case Config("API_DELETE_ACTION"):
                return "MasterConfigDelete";
            case Config("API_LIST_ACTION"):
                return "MasterConfigList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "masterconfiglist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("masterconfigview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("masterconfigview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "masterconfigadd?" . $this->getUrlParm($parm);
        } else {
            $url = "masterconfigadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("masterconfigedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("masterconfigadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("masterconfigdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"master_config_id\":" . JsonEncode($this->master_config_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->master_config_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->master_config_id->CurrentValue);
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
            if (($keyValue = Param("master_config_id") ?? Route("master_config_id")) !== null) {
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
                $this->master_config_id->CurrentValue = $key;
            } else {
                $this->master_config_id->OldValue = $key;
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
        $this->master_config_id->setDbValue($row['master_config_id']);
        $this->price_booking_invertor->setDbValue($row['price_booking_invertor']);
        $this->price_booking_buyer->setDbValue($row['price_booking_buyer']);
        $this->down_payment_buyer->setDbValue($row['down_payment_buyer']);
        $this->code_asset_seller->setDbValue($row['code_asset_seller']);
        $this->code_asset_buyer->setDbValue($row['code_asset_buyer']);
        $this->code_asset_juzmatch->setDbValue($row['code_asset_juzmatch']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // master_config_id
        $this->master_config_id->CellCssStyle = "white-space: nowrap;";

        // price_booking_invertor

        // price_booking_buyer

        // down_payment_buyer

        // code_asset_seller

        // code_asset_buyer

        // code_asset_juzmatch

        // cdate
        $this->cdate->CellCssStyle = "white-space: nowrap;";

        // cuser
        $this->cuser->CellCssStyle = "white-space: nowrap;";

        // cip
        $this->cip->CellCssStyle = "white-space: nowrap;";

        // udate

        // uuser
        $this->uuser->CellCssStyle = "white-space: nowrap;";

        // uip
        $this->uip->CellCssStyle = "white-space: nowrap;";

        // master_config_id
        $this->master_config_id->ViewValue = $this->master_config_id->CurrentValue;
        $this->master_config_id->ViewCustomAttributes = "";

        // price_booking_invertor
        $this->price_booking_invertor->ViewValue = $this->price_booking_invertor->CurrentValue;
        $this->price_booking_invertor->ViewValue = FormatNumber($this->price_booking_invertor->ViewValue, $this->price_booking_invertor->formatPattern());
        $this->price_booking_invertor->ViewCustomAttributes = "";

        // price_booking_buyer
        $this->price_booking_buyer->ViewValue = $this->price_booking_buyer->CurrentValue;
        $this->price_booking_buyer->ViewValue = FormatNumber($this->price_booking_buyer->ViewValue, $this->price_booking_buyer->formatPattern());
        $this->price_booking_buyer->ViewCustomAttributes = "";

        // down_payment_buyer
        $this->down_payment_buyer->ViewValue = $this->down_payment_buyer->CurrentValue;
        $this->down_payment_buyer->ViewValue = FormatNumber($this->down_payment_buyer->ViewValue, $this->down_payment_buyer->formatPattern());
        $this->down_payment_buyer->ViewCustomAttributes = "";

        // code_asset_seller
        $this->code_asset_seller->ViewValue = $this->code_asset_seller->CurrentValue;
        $this->code_asset_seller->ViewCustomAttributes = "";

        // code_asset_buyer
        $this->code_asset_buyer->ViewValue = $this->code_asset_buyer->CurrentValue;
        $this->code_asset_buyer->ViewCustomAttributes = "";

        // code_asset_juzmatch
        $this->code_asset_juzmatch->ViewValue = $this->code_asset_juzmatch->CurrentValue;
        $this->code_asset_juzmatch->ViewCustomAttributes = "";

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
        $this->uuser->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // master_config_id
        $this->master_config_id->LinkCustomAttributes = "";
        $this->master_config_id->HrefValue = "";
        $this->master_config_id->TooltipValue = "";

        // price_booking_invertor
        $this->price_booking_invertor->LinkCustomAttributes = "";
        $this->price_booking_invertor->HrefValue = "";
        $this->price_booking_invertor->TooltipValue = "";

        // price_booking_buyer
        $this->price_booking_buyer->LinkCustomAttributes = "";
        $this->price_booking_buyer->HrefValue = "";
        $this->price_booking_buyer->TooltipValue = "";

        // down_payment_buyer
        $this->down_payment_buyer->LinkCustomAttributes = "";
        $this->down_payment_buyer->HrefValue = "";
        $this->down_payment_buyer->TooltipValue = "";

        // code_asset_seller
        $this->code_asset_seller->LinkCustomAttributes = "";
        $this->code_asset_seller->HrefValue = "";
        $this->code_asset_seller->TooltipValue = "";

        // code_asset_buyer
        $this->code_asset_buyer->LinkCustomAttributes = "";
        $this->code_asset_buyer->HrefValue = "";
        $this->code_asset_buyer->TooltipValue = "";

        // code_asset_juzmatch
        $this->code_asset_juzmatch->LinkCustomAttributes = "";
        $this->code_asset_juzmatch->HrefValue = "";
        $this->code_asset_juzmatch->TooltipValue = "";

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

        // master_config_id
        $this->master_config_id->setupEditAttributes();
        $this->master_config_id->EditCustomAttributes = "";
        $this->master_config_id->EditValue = $this->master_config_id->CurrentValue;
        $this->master_config_id->ViewCustomAttributes = "";

        // price_booking_invertor
        $this->price_booking_invertor->setupEditAttributes();
        $this->price_booking_invertor->EditCustomAttributes = "";
        $this->price_booking_invertor->EditValue = $this->price_booking_invertor->CurrentValue;
        $this->price_booking_invertor->PlaceHolder = RemoveHtml($this->price_booking_invertor->caption());
        if (strval($this->price_booking_invertor->EditValue) != "" && is_numeric($this->price_booking_invertor->EditValue)) {
            $this->price_booking_invertor->EditValue = FormatNumber($this->price_booking_invertor->EditValue, null);
        }

        // price_booking_buyer
        $this->price_booking_buyer->setupEditAttributes();
        $this->price_booking_buyer->EditCustomAttributes = "";
        $this->price_booking_buyer->EditValue = $this->price_booking_buyer->CurrentValue;
        $this->price_booking_buyer->PlaceHolder = RemoveHtml($this->price_booking_buyer->caption());
        if (strval($this->price_booking_buyer->EditValue) != "" && is_numeric($this->price_booking_buyer->EditValue)) {
            $this->price_booking_buyer->EditValue = FormatNumber($this->price_booking_buyer->EditValue, null);
        }

        // down_payment_buyer
        $this->down_payment_buyer->setupEditAttributes();
        $this->down_payment_buyer->EditCustomAttributes = "";
        $this->down_payment_buyer->EditValue = $this->down_payment_buyer->CurrentValue;
        $this->down_payment_buyer->PlaceHolder = RemoveHtml($this->down_payment_buyer->caption());
        if (strval($this->down_payment_buyer->EditValue) != "" && is_numeric($this->down_payment_buyer->EditValue)) {
            $this->down_payment_buyer->EditValue = FormatNumber($this->down_payment_buyer->EditValue, null);
        }

        // code_asset_seller
        $this->code_asset_seller->setupEditAttributes();
        $this->code_asset_seller->EditCustomAttributes = "";
        if (!$this->code_asset_seller->Raw) {
            $this->code_asset_seller->CurrentValue = HtmlDecode($this->code_asset_seller->CurrentValue);
        }
        $this->code_asset_seller->EditValue = $this->code_asset_seller->CurrentValue;
        $this->code_asset_seller->PlaceHolder = RemoveHtml($this->code_asset_seller->caption());

        // code_asset_buyer
        $this->code_asset_buyer->setupEditAttributes();
        $this->code_asset_buyer->EditCustomAttributes = "";
        if (!$this->code_asset_buyer->Raw) {
            $this->code_asset_buyer->CurrentValue = HtmlDecode($this->code_asset_buyer->CurrentValue);
        }
        $this->code_asset_buyer->EditValue = $this->code_asset_buyer->CurrentValue;
        $this->code_asset_buyer->PlaceHolder = RemoveHtml($this->code_asset_buyer->caption());

        // code_asset_juzmatch
        $this->code_asset_juzmatch->setupEditAttributes();
        $this->code_asset_juzmatch->EditCustomAttributes = "";
        if (!$this->code_asset_juzmatch->Raw) {
            $this->code_asset_juzmatch->CurrentValue = HtmlDecode($this->code_asset_juzmatch->CurrentValue);
        }
        $this->code_asset_juzmatch->EditValue = $this->code_asset_juzmatch->CurrentValue;
        $this->code_asset_juzmatch->PlaceHolder = RemoveHtml($this->code_asset_juzmatch->caption());

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

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
                    $doc->exportCaption($this->price_booking_invertor);
                    $doc->exportCaption($this->price_booking_buyer);
                    $doc->exportCaption($this->down_payment_buyer);
                    $doc->exportCaption($this->code_asset_seller);
                    $doc->exportCaption($this->code_asset_buyer);
                    $doc->exportCaption($this->code_asset_juzmatch);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                } else {
                    $doc->exportCaption($this->price_booking_invertor);
                    $doc->exportCaption($this->price_booking_buyer);
                    $doc->exportCaption($this->down_payment_buyer);
                    $doc->exportCaption($this->code_asset_seller);
                    $doc->exportCaption($this->code_asset_buyer);
                    $doc->exportCaption($this->code_asset_juzmatch);
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
                        $doc->exportField($this->price_booking_invertor);
                        $doc->exportField($this->price_booking_buyer);
                        $doc->exportField($this->down_payment_buyer);
                        $doc->exportField($this->code_asset_seller);
                        $doc->exportField($this->code_asset_buyer);
                        $doc->exportField($this->code_asset_juzmatch);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                    } else {
                        $doc->exportField($this->price_booking_invertor);
                        $doc->exportField($this->price_booking_buyer);
                        $doc->exportField($this->down_payment_buyer);
                        $doc->exportField($this->code_asset_seller);
                        $doc->exportField($this->code_asset_buyer);
                        $doc->exportField($this->code_asset_juzmatch);
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
