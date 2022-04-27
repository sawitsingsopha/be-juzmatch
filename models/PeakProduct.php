<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for peak_product
 */
class PeakProduct extends DbTable
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
    public $id;
    public $productid;
    public $name;
    public $code;
    public $type;
    public $purchaseValue;
    public $purchaseVatType;
    public $purchaseAccount;
    public $sellValue;
    public $sellVatType;
    public $sellAccount;
    public $description;
    public $carryingBalanceValue;
    public $carryingBalanceAmount;
    public $remainingBalanceAmount;
    public $create_date;
    public $update_date;
    public $post_message;
    public $post_try_cnt;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'peak_product';
        $this->TableName = 'peak_product';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`peak_product`";
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

        // id
        $this->id = new DbField(
            'peak_product',
            'peak_product',
            'x_id',
            'id',
            '`id`',
            '`id`',
            3,
            11,
            -1,
            false,
            '`id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->id->InputTextType = "text";
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // productid
        $this->productid = new DbField(
            'peak_product',
            'peak_product',
            'x_productid',
            'productid',
            '`productid`',
            '`productid`',
            200,
            250,
            -1,
            false,
            '`productid`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->productid->InputTextType = "text";
        $this->Fields['productid'] = &$this->productid;

        // name
        $this->name = new DbField(
            'peak_product',
            'peak_product',
            'x_name',
            'name',
            '`name`',
            '`name`',
            200,
            250,
            -1,
            false,
            '`name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->name->InputTextType = "text";
        $this->Fields['name'] = &$this->name;

        // code
        $this->code = new DbField(
            'peak_product',
            'peak_product',
            'x_code',
            'code',
            '`code`',
            '`code`',
            200,
            250,
            -1,
            false,
            '`code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->code->InputTextType = "text";
        $this->Fields['code'] = &$this->code;

        // type
        $this->type = new DbField(
            'peak_product',
            'peak_product',
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
        $this->type->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type'] = &$this->type;

        // purchaseValue
        $this->purchaseValue = new DbField(
            'peak_product',
            'peak_product',
            'x_purchaseValue',
            'purchaseValue',
            '`purchaseValue`',
            '`purchaseValue`',
            5,
            22,
            -1,
            false,
            '`purchaseValue`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->purchaseValue->InputTextType = "text";
        $this->purchaseValue->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['purchaseValue'] = &$this->purchaseValue;

        // purchaseVatType
        $this->purchaseVatType = new DbField(
            'peak_product',
            'peak_product',
            'x_purchaseVatType',
            'purchaseVatType',
            '`purchaseVatType`',
            '`purchaseVatType`',
            3,
            11,
            -1,
            false,
            '`purchaseVatType`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->purchaseVatType->InputTextType = "text";
        $this->purchaseVatType->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['purchaseVatType'] = &$this->purchaseVatType;

        // purchaseAccount
        $this->purchaseAccount = new DbField(
            'peak_product',
            'peak_product',
            'x_purchaseAccount',
            'purchaseAccount',
            '`purchaseAccount`',
            '`purchaseAccount`',
            200,
            250,
            -1,
            false,
            '`purchaseAccount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->purchaseAccount->InputTextType = "text";
        $this->Fields['purchaseAccount'] = &$this->purchaseAccount;

        // sellValue
        $this->sellValue = new DbField(
            'peak_product',
            'peak_product',
            'x_sellValue',
            'sellValue',
            '`sellValue`',
            '`sellValue`',
            5,
            22,
            -1,
            false,
            '`sellValue`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->sellValue->InputTextType = "text";
        $this->sellValue->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['sellValue'] = &$this->sellValue;

        // sellVatType
        $this->sellVatType = new DbField(
            'peak_product',
            'peak_product',
            'x_sellVatType',
            'sellVatType',
            '`sellVatType`',
            '`sellVatType`',
            3,
            11,
            -1,
            false,
            '`sellVatType`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->sellVatType->InputTextType = "text";
        $this->sellVatType->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['sellVatType'] = &$this->sellVatType;

        // sellAccount
        $this->sellAccount = new DbField(
            'peak_product',
            'peak_product',
            'x_sellAccount',
            'sellAccount',
            '`sellAccount`',
            '`sellAccount`',
            200,
            250,
            -1,
            false,
            '`sellAccount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->sellAccount->InputTextType = "text";
        $this->Fields['sellAccount'] = &$this->sellAccount;

        // description
        $this->description = new DbField(
            'peak_product',
            'peak_product',
            'x_description',
            'description',
            '`description`',
            '`description`',
            201,
            65535,
            -1,
            false,
            '`description`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->description->InputTextType = "text";
        $this->Fields['description'] = &$this->description;

        // carryingBalanceValue
        $this->carryingBalanceValue = new DbField(
            'peak_product',
            'peak_product',
            'x_carryingBalanceValue',
            'carryingBalanceValue',
            '`carryingBalanceValue`',
            '`carryingBalanceValue`',
            5,
            22,
            -1,
            false,
            '`carryingBalanceValue`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->carryingBalanceValue->InputTextType = "text";
        $this->carryingBalanceValue->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['carryingBalanceValue'] = &$this->carryingBalanceValue;

        // carryingBalanceAmount
        $this->carryingBalanceAmount = new DbField(
            'peak_product',
            'peak_product',
            'x_carryingBalanceAmount',
            'carryingBalanceAmount',
            '`carryingBalanceAmount`',
            '`carryingBalanceAmount`',
            5,
            22,
            -1,
            false,
            '`carryingBalanceAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->carryingBalanceAmount->InputTextType = "text";
        $this->carryingBalanceAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['carryingBalanceAmount'] = &$this->carryingBalanceAmount;

        // remainingBalanceAmount
        $this->remainingBalanceAmount = new DbField(
            'peak_product',
            'peak_product',
            'x_remainingBalanceAmount',
            'remainingBalanceAmount',
            '`remainingBalanceAmount`',
            '`remainingBalanceAmount`',
            5,
            22,
            -1,
            false,
            '`remainingBalanceAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remainingBalanceAmount->InputTextType = "text";
        $this->remainingBalanceAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remainingBalanceAmount'] = &$this->remainingBalanceAmount;

        // create_date
        $this->create_date = new DbField(
            'peak_product',
            'peak_product',
            'x_create_date',
            'create_date',
            '`create_date`',
            CastDateFieldForLike("`create_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`create_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->create_date->InputTextType = "text";
        $this->create_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['create_date'] = &$this->create_date;

        // update_date
        $this->update_date = new DbField(
            'peak_product',
            'peak_product',
            'x_update_date',
            'update_date',
            '`update_date`',
            CastDateFieldForLike("`update_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`update_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->update_date->InputTextType = "text";
        $this->update_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['update_date'] = &$this->update_date;

        // post_message
        $this->post_message = new DbField(
            'peak_product',
            'peak_product',
            'x_post_message',
            'post_message',
            '`post_message`',
            '`post_message`',
            3,
            11,
            -1,
            false,
            '`post_message`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->post_message->InputTextType = "text";
        $this->post_message->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['post_message'] = &$this->post_message;

        // post_try_cnt
        $this->post_try_cnt = new DbField(
            'peak_product',
            'peak_product',
            'x_post_try_cnt',
            'post_try_cnt',
            '`post_try_cnt`',
            '`post_try_cnt`',
            3,
            11,
            -1,
            false,
            '`post_try_cnt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->post_try_cnt->InputTextType = "text";
        $this->post_try_cnt->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['post_try_cnt'] = &$this->post_try_cnt;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`peak_product`";
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
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
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
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
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
        $this->id->DbValue = $row['id'];
        $this->productid->DbValue = $row['productid'];
        $this->name->DbValue = $row['name'];
        $this->code->DbValue = $row['code'];
        $this->type->DbValue = $row['type'];
        $this->purchaseValue->DbValue = $row['purchaseValue'];
        $this->purchaseVatType->DbValue = $row['purchaseVatType'];
        $this->purchaseAccount->DbValue = $row['purchaseAccount'];
        $this->sellValue->DbValue = $row['sellValue'];
        $this->sellVatType->DbValue = $row['sellVatType'];
        $this->sellAccount->DbValue = $row['sellAccount'];
        $this->description->DbValue = $row['description'];
        $this->carryingBalanceValue->DbValue = $row['carryingBalanceValue'];
        $this->carryingBalanceAmount->DbValue = $row['carryingBalanceAmount'];
        $this->remainingBalanceAmount->DbValue = $row['remainingBalanceAmount'];
        $this->create_date->DbValue = $row['create_date'];
        $this->update_date->DbValue = $row['update_date'];
        $this->post_message->DbValue = $row['post_message'];
        $this->post_try_cnt->DbValue = $row['post_try_cnt'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
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
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("peakproductlist");
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
        if ($pageName == "peakproductview") {
            return $Language->phrase("View");
        } elseif ($pageName == "peakproductedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "peakproductadd") {
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
                return "PeakProductView";
            case Config("API_ADD_ACTION"):
                return "PeakProductAdd";
            case Config("API_EDIT_ACTION"):
                return "PeakProductEdit";
            case Config("API_DELETE_ACTION"):
                return "PeakProductDelete";
            case Config("API_LIST_ACTION"):
                return "PeakProductList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "peakproductlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("peakproductview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("peakproductview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "peakproductadd?" . $this->getUrlParm($parm);
        } else {
            $url = "peakproductadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("peakproductedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("peakproductadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("peakproductdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
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
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
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
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
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
        $this->id->setDbValue($row['id']);
        $this->productid->setDbValue($row['productid']);
        $this->name->setDbValue($row['name']);
        $this->code->setDbValue($row['code']);
        $this->type->setDbValue($row['type']);
        $this->purchaseValue->setDbValue($row['purchaseValue']);
        $this->purchaseVatType->setDbValue($row['purchaseVatType']);
        $this->purchaseAccount->setDbValue($row['purchaseAccount']);
        $this->sellValue->setDbValue($row['sellValue']);
        $this->sellVatType->setDbValue($row['sellVatType']);
        $this->sellAccount->setDbValue($row['sellAccount']);
        $this->description->setDbValue($row['description']);
        $this->carryingBalanceValue->setDbValue($row['carryingBalanceValue']);
        $this->carryingBalanceAmount->setDbValue($row['carryingBalanceAmount']);
        $this->remainingBalanceAmount->setDbValue($row['remainingBalanceAmount']);
        $this->create_date->setDbValue($row['create_date']);
        $this->update_date->setDbValue($row['update_date']);
        $this->post_message->setDbValue($row['post_message']);
        $this->post_try_cnt->setDbValue($row['post_try_cnt']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // productid

        // name

        // code

        // type

        // purchaseValue

        // purchaseVatType

        // purchaseAccount

        // sellValue

        // sellVatType

        // sellAccount

        // description

        // carryingBalanceValue

        // carryingBalanceAmount

        // remainingBalanceAmount

        // create_date

        // update_date

        // post_message

        // post_try_cnt

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // productid
        $this->productid->ViewValue = $this->productid->CurrentValue;
        $this->productid->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $this->name->ViewCustomAttributes = "";

        // code
        $this->code->ViewValue = $this->code->CurrentValue;
        $this->code->ViewCustomAttributes = "";

        // type
        $this->type->ViewValue = $this->type->CurrentValue;
        $this->type->ViewValue = FormatNumber($this->type->ViewValue, $this->type->formatPattern());
        $this->type->ViewCustomAttributes = "";

        // purchaseValue
        $this->purchaseValue->ViewValue = $this->purchaseValue->CurrentValue;
        $this->purchaseValue->ViewValue = FormatNumber($this->purchaseValue->ViewValue, $this->purchaseValue->formatPattern());
        $this->purchaseValue->ViewCustomAttributes = "";

        // purchaseVatType
        $this->purchaseVatType->ViewValue = $this->purchaseVatType->CurrentValue;
        $this->purchaseVatType->ViewValue = FormatNumber($this->purchaseVatType->ViewValue, $this->purchaseVatType->formatPattern());
        $this->purchaseVatType->ViewCustomAttributes = "";

        // purchaseAccount
        $this->purchaseAccount->ViewValue = $this->purchaseAccount->CurrentValue;
        $this->purchaseAccount->ViewCustomAttributes = "";

        // sellValue
        $this->sellValue->ViewValue = $this->sellValue->CurrentValue;
        $this->sellValue->ViewValue = FormatNumber($this->sellValue->ViewValue, $this->sellValue->formatPattern());
        $this->sellValue->ViewCustomAttributes = "";

        // sellVatType
        $this->sellVatType->ViewValue = $this->sellVatType->CurrentValue;
        $this->sellVatType->ViewValue = FormatNumber($this->sellVatType->ViewValue, $this->sellVatType->formatPattern());
        $this->sellVatType->ViewCustomAttributes = "";

        // sellAccount
        $this->sellAccount->ViewValue = $this->sellAccount->CurrentValue;
        $this->sellAccount->ViewCustomAttributes = "";

        // description
        $this->description->ViewValue = $this->description->CurrentValue;
        $this->description->ViewCustomAttributes = "";

        // carryingBalanceValue
        $this->carryingBalanceValue->ViewValue = $this->carryingBalanceValue->CurrentValue;
        $this->carryingBalanceValue->ViewValue = FormatNumber($this->carryingBalanceValue->ViewValue, $this->carryingBalanceValue->formatPattern());
        $this->carryingBalanceValue->ViewCustomAttributes = "";

        // carryingBalanceAmount
        $this->carryingBalanceAmount->ViewValue = $this->carryingBalanceAmount->CurrentValue;
        $this->carryingBalanceAmount->ViewValue = FormatNumber($this->carryingBalanceAmount->ViewValue, $this->carryingBalanceAmount->formatPattern());
        $this->carryingBalanceAmount->ViewCustomAttributes = "";

        // remainingBalanceAmount
        $this->remainingBalanceAmount->ViewValue = $this->remainingBalanceAmount->CurrentValue;
        $this->remainingBalanceAmount->ViewValue = FormatNumber($this->remainingBalanceAmount->ViewValue, $this->remainingBalanceAmount->formatPattern());
        $this->remainingBalanceAmount->ViewCustomAttributes = "";

        // create_date
        $this->create_date->ViewValue = $this->create_date->CurrentValue;
        $this->create_date->ViewValue = FormatDateTime($this->create_date->ViewValue, $this->create_date->formatPattern());
        $this->create_date->ViewCustomAttributes = "";

        // update_date
        $this->update_date->ViewValue = $this->update_date->CurrentValue;
        $this->update_date->ViewValue = FormatDateTime($this->update_date->ViewValue, $this->update_date->formatPattern());
        $this->update_date->ViewCustomAttributes = "";

        // post_message
        $this->post_message->ViewValue = $this->post_message->CurrentValue;
        $this->post_message->ViewValue = FormatNumber($this->post_message->ViewValue, $this->post_message->formatPattern());
        $this->post_message->ViewCustomAttributes = "";

        // post_try_cnt
        $this->post_try_cnt->ViewValue = $this->post_try_cnt->CurrentValue;
        $this->post_try_cnt->ViewValue = FormatNumber($this->post_try_cnt->ViewValue, $this->post_try_cnt->formatPattern());
        $this->post_try_cnt->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // productid
        $this->productid->LinkCustomAttributes = "";
        $this->productid->HrefValue = "";
        $this->productid->TooltipValue = "";

        // name
        $this->name->LinkCustomAttributes = "";
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // code
        $this->code->LinkCustomAttributes = "";
        $this->code->HrefValue = "";
        $this->code->TooltipValue = "";

        // type
        $this->type->LinkCustomAttributes = "";
        $this->type->HrefValue = "";
        $this->type->TooltipValue = "";

        // purchaseValue
        $this->purchaseValue->LinkCustomAttributes = "";
        $this->purchaseValue->HrefValue = "";
        $this->purchaseValue->TooltipValue = "";

        // purchaseVatType
        $this->purchaseVatType->LinkCustomAttributes = "";
        $this->purchaseVatType->HrefValue = "";
        $this->purchaseVatType->TooltipValue = "";

        // purchaseAccount
        $this->purchaseAccount->LinkCustomAttributes = "";
        $this->purchaseAccount->HrefValue = "";
        $this->purchaseAccount->TooltipValue = "";

        // sellValue
        $this->sellValue->LinkCustomAttributes = "";
        $this->sellValue->HrefValue = "";
        $this->sellValue->TooltipValue = "";

        // sellVatType
        $this->sellVatType->LinkCustomAttributes = "";
        $this->sellVatType->HrefValue = "";
        $this->sellVatType->TooltipValue = "";

        // sellAccount
        $this->sellAccount->LinkCustomAttributes = "";
        $this->sellAccount->HrefValue = "";
        $this->sellAccount->TooltipValue = "";

        // description
        $this->description->LinkCustomAttributes = "";
        $this->description->HrefValue = "";
        $this->description->TooltipValue = "";

        // carryingBalanceValue
        $this->carryingBalanceValue->LinkCustomAttributes = "";
        $this->carryingBalanceValue->HrefValue = "";
        $this->carryingBalanceValue->TooltipValue = "";

        // carryingBalanceAmount
        $this->carryingBalanceAmount->LinkCustomAttributes = "";
        $this->carryingBalanceAmount->HrefValue = "";
        $this->carryingBalanceAmount->TooltipValue = "";

        // remainingBalanceAmount
        $this->remainingBalanceAmount->LinkCustomAttributes = "";
        $this->remainingBalanceAmount->HrefValue = "";
        $this->remainingBalanceAmount->TooltipValue = "";

        // create_date
        $this->create_date->LinkCustomAttributes = "";
        $this->create_date->HrefValue = "";
        $this->create_date->TooltipValue = "";

        // update_date
        $this->update_date->LinkCustomAttributes = "";
        $this->update_date->HrefValue = "";
        $this->update_date->TooltipValue = "";

        // post_message
        $this->post_message->LinkCustomAttributes = "";
        $this->post_message->HrefValue = "";
        $this->post_message->TooltipValue = "";

        // post_try_cnt
        $this->post_try_cnt->LinkCustomAttributes = "";
        $this->post_try_cnt->HrefValue = "";
        $this->post_try_cnt->TooltipValue = "";

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

        // id
        $this->id->setupEditAttributes();
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // productid
        $this->productid->setupEditAttributes();
        $this->productid->EditCustomAttributes = "";
        if (!$this->productid->Raw) {
            $this->productid->CurrentValue = HtmlDecode($this->productid->CurrentValue);
        }
        $this->productid->EditValue = $this->productid->CurrentValue;
        $this->productid->PlaceHolder = RemoveHtml($this->productid->caption());

        // name
        $this->name->setupEditAttributes();
        $this->name->EditCustomAttributes = "";
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // code
        $this->code->setupEditAttributes();
        $this->code->EditCustomAttributes = "";
        if (!$this->code->Raw) {
            $this->code->CurrentValue = HtmlDecode($this->code->CurrentValue);
        }
        $this->code->EditValue = $this->code->CurrentValue;
        $this->code->PlaceHolder = RemoveHtml($this->code->caption());

        // type
        $this->type->setupEditAttributes();
        $this->type->EditCustomAttributes = "";
        $this->type->EditValue = $this->type->CurrentValue;
        $this->type->PlaceHolder = RemoveHtml($this->type->caption());
        if (strval($this->type->EditValue) != "" && is_numeric($this->type->EditValue)) {
            $this->type->EditValue = FormatNumber($this->type->EditValue, null);
        }

        // purchaseValue
        $this->purchaseValue->setupEditAttributes();
        $this->purchaseValue->EditCustomAttributes = "";
        $this->purchaseValue->EditValue = $this->purchaseValue->CurrentValue;
        $this->purchaseValue->PlaceHolder = RemoveHtml($this->purchaseValue->caption());
        if (strval($this->purchaseValue->EditValue) != "" && is_numeric($this->purchaseValue->EditValue)) {
            $this->purchaseValue->EditValue = FormatNumber($this->purchaseValue->EditValue, null);
        }

        // purchaseVatType
        $this->purchaseVatType->setupEditAttributes();
        $this->purchaseVatType->EditCustomAttributes = "";
        $this->purchaseVatType->EditValue = $this->purchaseVatType->CurrentValue;
        $this->purchaseVatType->PlaceHolder = RemoveHtml($this->purchaseVatType->caption());
        if (strval($this->purchaseVatType->EditValue) != "" && is_numeric($this->purchaseVatType->EditValue)) {
            $this->purchaseVatType->EditValue = FormatNumber($this->purchaseVatType->EditValue, null);
        }

        // purchaseAccount
        $this->purchaseAccount->setupEditAttributes();
        $this->purchaseAccount->EditCustomAttributes = "";
        if (!$this->purchaseAccount->Raw) {
            $this->purchaseAccount->CurrentValue = HtmlDecode($this->purchaseAccount->CurrentValue);
        }
        $this->purchaseAccount->EditValue = $this->purchaseAccount->CurrentValue;
        $this->purchaseAccount->PlaceHolder = RemoveHtml($this->purchaseAccount->caption());

        // sellValue
        $this->sellValue->setupEditAttributes();
        $this->sellValue->EditCustomAttributes = "";
        $this->sellValue->EditValue = $this->sellValue->CurrentValue;
        $this->sellValue->PlaceHolder = RemoveHtml($this->sellValue->caption());
        if (strval($this->sellValue->EditValue) != "" && is_numeric($this->sellValue->EditValue)) {
            $this->sellValue->EditValue = FormatNumber($this->sellValue->EditValue, null);
        }

        // sellVatType
        $this->sellVatType->setupEditAttributes();
        $this->sellVatType->EditCustomAttributes = "";
        $this->sellVatType->EditValue = $this->sellVatType->CurrentValue;
        $this->sellVatType->PlaceHolder = RemoveHtml($this->sellVatType->caption());
        if (strval($this->sellVatType->EditValue) != "" && is_numeric($this->sellVatType->EditValue)) {
            $this->sellVatType->EditValue = FormatNumber($this->sellVatType->EditValue, null);
        }

        // sellAccount
        $this->sellAccount->setupEditAttributes();
        $this->sellAccount->EditCustomAttributes = "";
        if (!$this->sellAccount->Raw) {
            $this->sellAccount->CurrentValue = HtmlDecode($this->sellAccount->CurrentValue);
        }
        $this->sellAccount->EditValue = $this->sellAccount->CurrentValue;
        $this->sellAccount->PlaceHolder = RemoveHtml($this->sellAccount->caption());

        // description
        $this->description->setupEditAttributes();
        $this->description->EditCustomAttributes = "";
        $this->description->EditValue = $this->description->CurrentValue;
        $this->description->PlaceHolder = RemoveHtml($this->description->caption());

        // carryingBalanceValue
        $this->carryingBalanceValue->setupEditAttributes();
        $this->carryingBalanceValue->EditCustomAttributes = "";
        $this->carryingBalanceValue->EditValue = $this->carryingBalanceValue->CurrentValue;
        $this->carryingBalanceValue->PlaceHolder = RemoveHtml($this->carryingBalanceValue->caption());
        if (strval($this->carryingBalanceValue->EditValue) != "" && is_numeric($this->carryingBalanceValue->EditValue)) {
            $this->carryingBalanceValue->EditValue = FormatNumber($this->carryingBalanceValue->EditValue, null);
        }

        // carryingBalanceAmount
        $this->carryingBalanceAmount->setupEditAttributes();
        $this->carryingBalanceAmount->EditCustomAttributes = "";
        $this->carryingBalanceAmount->EditValue = $this->carryingBalanceAmount->CurrentValue;
        $this->carryingBalanceAmount->PlaceHolder = RemoveHtml($this->carryingBalanceAmount->caption());
        if (strval($this->carryingBalanceAmount->EditValue) != "" && is_numeric($this->carryingBalanceAmount->EditValue)) {
            $this->carryingBalanceAmount->EditValue = FormatNumber($this->carryingBalanceAmount->EditValue, null);
        }

        // remainingBalanceAmount
        $this->remainingBalanceAmount->setupEditAttributes();
        $this->remainingBalanceAmount->EditCustomAttributes = "";
        $this->remainingBalanceAmount->EditValue = $this->remainingBalanceAmount->CurrentValue;
        $this->remainingBalanceAmount->PlaceHolder = RemoveHtml($this->remainingBalanceAmount->caption());
        if (strval($this->remainingBalanceAmount->EditValue) != "" && is_numeric($this->remainingBalanceAmount->EditValue)) {
            $this->remainingBalanceAmount->EditValue = FormatNumber($this->remainingBalanceAmount->EditValue, null);
        }

        // create_date
        $this->create_date->setupEditAttributes();
        $this->create_date->EditCustomAttributes = "";
        $this->create_date->EditValue = FormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern());
        $this->create_date->PlaceHolder = RemoveHtml($this->create_date->caption());

        // update_date
        $this->update_date->setupEditAttributes();
        $this->update_date->EditCustomAttributes = "";
        $this->update_date->EditValue = FormatDateTime($this->update_date->CurrentValue, $this->update_date->formatPattern());
        $this->update_date->PlaceHolder = RemoveHtml($this->update_date->caption());

        // post_message
        $this->post_message->setupEditAttributes();
        $this->post_message->EditCustomAttributes = "";
        $this->post_message->EditValue = $this->post_message->CurrentValue;
        $this->post_message->PlaceHolder = RemoveHtml($this->post_message->caption());
        if (strval($this->post_message->EditValue) != "" && is_numeric($this->post_message->EditValue)) {
            $this->post_message->EditValue = FormatNumber($this->post_message->EditValue, null);
        }

        // post_try_cnt
        $this->post_try_cnt->setupEditAttributes();
        $this->post_try_cnt->EditCustomAttributes = "";
        $this->post_try_cnt->EditValue = $this->post_try_cnt->CurrentValue;
        $this->post_try_cnt->PlaceHolder = RemoveHtml($this->post_try_cnt->caption());
        if (strval($this->post_try_cnt->EditValue) != "" && is_numeric($this->post_try_cnt->EditValue)) {
            $this->post_try_cnt->EditValue = FormatNumber($this->post_try_cnt->EditValue, null);
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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->productid);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->code);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->purchaseValue);
                    $doc->exportCaption($this->purchaseVatType);
                    $doc->exportCaption($this->purchaseAccount);
                    $doc->exportCaption($this->sellValue);
                    $doc->exportCaption($this->sellVatType);
                    $doc->exportCaption($this->sellAccount);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->carryingBalanceValue);
                    $doc->exportCaption($this->carryingBalanceAmount);
                    $doc->exportCaption($this->remainingBalanceAmount);
                    $doc->exportCaption($this->create_date);
                    $doc->exportCaption($this->update_date);
                    $doc->exportCaption($this->post_message);
                    $doc->exportCaption($this->post_try_cnt);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->productid);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->code);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->purchaseValue);
                    $doc->exportCaption($this->purchaseVatType);
                    $doc->exportCaption($this->purchaseAccount);
                    $doc->exportCaption($this->sellValue);
                    $doc->exportCaption($this->sellVatType);
                    $doc->exportCaption($this->sellAccount);
                    $doc->exportCaption($this->carryingBalanceValue);
                    $doc->exportCaption($this->carryingBalanceAmount);
                    $doc->exportCaption($this->remainingBalanceAmount);
                    $doc->exportCaption($this->create_date);
                    $doc->exportCaption($this->update_date);
                    $doc->exportCaption($this->post_message);
                    $doc->exportCaption($this->post_try_cnt);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->productid);
                        $doc->exportField($this->name);
                        $doc->exportField($this->code);
                        $doc->exportField($this->type);
                        $doc->exportField($this->purchaseValue);
                        $doc->exportField($this->purchaseVatType);
                        $doc->exportField($this->purchaseAccount);
                        $doc->exportField($this->sellValue);
                        $doc->exportField($this->sellVatType);
                        $doc->exportField($this->sellAccount);
                        $doc->exportField($this->description);
                        $doc->exportField($this->carryingBalanceValue);
                        $doc->exportField($this->carryingBalanceAmount);
                        $doc->exportField($this->remainingBalanceAmount);
                        $doc->exportField($this->create_date);
                        $doc->exportField($this->update_date);
                        $doc->exportField($this->post_message);
                        $doc->exportField($this->post_try_cnt);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->productid);
                        $doc->exportField($this->name);
                        $doc->exportField($this->code);
                        $doc->exportField($this->type);
                        $doc->exportField($this->purchaseValue);
                        $doc->exportField($this->purchaseVatType);
                        $doc->exportField($this->purchaseAccount);
                        $doc->exportField($this->sellValue);
                        $doc->exportField($this->sellVatType);
                        $doc->exportField($this->sellAccount);
                        $doc->exportField($this->carryingBalanceValue);
                        $doc->exportField($this->carryingBalanceAmount);
                        $doc->exportField($this->remainingBalanceAmount);
                        $doc->exportField($this->create_date);
                        $doc->exportField($this->update_date);
                        $doc->exportField($this->post_message);
                        $doc->exportField($this->post_try_cnt);
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
