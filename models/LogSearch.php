<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for log_search
 */
class LogSearch extends DbTable
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
    public $log_search_id;
    public $attribute_detail_id;
    public $member_id;
    public $category_id;
    public $search_text;
    public $brand_id;
    public $sort_id;
    public $min_price;
    public $max_price;
    public $min_size;
    public $max_size;
    public $cdate;
    public $cuser;
    public $cip;
    public $uuser;
    public $uip;
    public $udate;
    public $min_down;
    public $max_down;
    public $yer_installment_max;
    public $latitude;
    public $longitude;
    public $min_installment;
    public $max_installment;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'log_search';
        $this->TableName = 'log_search';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`log_search`";
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

        // log_search_id
        $this->log_search_id = new DbField(
            'log_search',
            'log_search',
            'x_log_search_id',
            'log_search_id',
            '`log_search_id`',
            '`log_search_id`',
            3,
            11,
            -1,
            false,
            '`log_search_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->log_search_id->InputTextType = "text";
        $this->log_search_id->IsAutoIncrement = true; // Autoincrement field
        $this->log_search_id->IsPrimaryKey = true; // Primary key field
        $this->log_search_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['log_search_id'] = &$this->log_search_id;

        // attribute_detail_id
        $this->attribute_detail_id = new DbField(
            'log_search',
            'log_search',
            'x_attribute_detail_id',
            'attribute_detail_id',
            '`attribute_detail_id`',
            '`attribute_detail_id`',
            3,
            11,
            -1,
            false,
            '`attribute_detail_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->attribute_detail_id->InputTextType = "text";
        $this->attribute_detail_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['attribute_detail_id'] = &$this->attribute_detail_id;

        // member_id
        $this->member_id = new DbField(
            'log_search',
            'log_search',
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
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // category_id
        $this->category_id = new DbField(
            'log_search',
            'log_search',
            'x_category_id',
            'category_id',
            '`category_id`',
            '`category_id`',
            3,
            11,
            -1,
            false,
            '`category_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->category_id->InputTextType = "text";
        $this->category_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['category_id'] = &$this->category_id;

        // search_text
        $this->search_text = new DbField(
            'log_search',
            'log_search',
            'x_search_text',
            'search_text',
            '`search_text`',
            '`search_text`',
            201,
            16777215,
            -1,
            false,
            '`search_text`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->search_text->InputTextType = "text";
        $this->Fields['search_text'] = &$this->search_text;

        // brand_id
        $this->brand_id = new DbField(
            'log_search',
            'log_search',
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
            'TEXT'
        );
        $this->brand_id->InputTextType = "text";
        $this->brand_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['brand_id'] = &$this->brand_id;

        // sort_id
        $this->sort_id = new DbField(
            'log_search',
            'log_search',
            'x_sort_id',
            'sort_id',
            '`sort_id`',
            '`sort_id`',
            3,
            11,
            -1,
            false,
            '`sort_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->sort_id->InputTextType = "text";
        $this->sort_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['sort_id'] = &$this->sort_id;

        // min_price
        $this->min_price = new DbField(
            'log_search',
            'log_search',
            'x_min_price',
            'min_price',
            '`min_price`',
            '`min_price`',
            4,
            12,
            -1,
            false,
            '`min_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->min_price->InputTextType = "text";
        $this->min_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['min_price'] = &$this->min_price;

        // max_price
        $this->max_price = new DbField(
            'log_search',
            'log_search',
            'x_max_price',
            'max_price',
            '`max_price`',
            '`max_price`',
            4,
            12,
            -1,
            false,
            '`max_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->max_price->InputTextType = "text";
        $this->max_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['max_price'] = &$this->max_price;

        // min_size
        $this->min_size = new DbField(
            'log_search',
            'log_search',
            'x_min_size',
            'min_size',
            '`min_size`',
            '`min_size`',
            4,
            12,
            -1,
            false,
            '`min_size`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->min_size->InputTextType = "text";
        $this->min_size->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['min_size'] = &$this->min_size;

        // max_size
        $this->max_size = new DbField(
            'log_search',
            'log_search',
            'x_max_size',
            'max_size',
            '`max_size`',
            '`max_size`',
            4,
            12,
            -1,
            false,
            '`max_size`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->max_size->InputTextType = "text";
        $this->max_size->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['max_size'] = &$this->max_size;

        // cdate
        $this->cdate = new DbField(
            'log_search',
            'log_search',
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
        $this->cdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'log_search',
            'log_search',
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
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'log_search',
            'log_search',
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

        // uuser
        $this->uuser = new DbField(
            'log_search',
            'log_search',
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
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'log_search',
            'log_search',
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

        // udate
        $this->udate = new DbField(
            'log_search',
            'log_search',
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

        // min_down
        $this->min_down = new DbField(
            'log_search',
            'log_search',
            'x_min_down',
            'min_down',
            '`min_down`',
            '`min_down`',
            4,
            12,
            -1,
            false,
            '`min_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->min_down->InputTextType = "text";
        $this->min_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['min_down'] = &$this->min_down;

        // max_down
        $this->max_down = new DbField(
            'log_search',
            'log_search',
            'x_max_down',
            'max_down',
            '`max_down`',
            '`max_down`',
            4,
            12,
            -1,
            false,
            '`max_down`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->max_down->InputTextType = "text";
        $this->max_down->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['max_down'] = &$this->max_down;

        // yer_installment_max
        $this->yer_installment_max = new DbField(
            'log_search',
            'log_search',
            'x_yer_installment_max',
            'yer_installment_max',
            '`yer_installment_max`',
            '`yer_installment_max`',
            3,
            11,
            -1,
            false,
            '`yer_installment_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->yer_installment_max->InputTextType = "text";
        $this->yer_installment_max->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['yer_installment_max'] = &$this->yer_installment_max;

        // latitude
        $this->latitude = new DbField(
            'log_search',
            'log_search',
            'x_latitude',
            'latitude',
            '`latitude`',
            '`latitude`',
            4,
            12,
            -1,
            false,
            '`latitude`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->latitude->InputTextType = "text";
        $this->latitude->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['latitude'] = &$this->latitude;

        // longitude
        $this->longitude = new DbField(
            'log_search',
            'log_search',
            'x_longitude',
            'longitude',
            '`longitude`',
            '`longitude`',
            4,
            12,
            -1,
            false,
            '`longitude`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->longitude->InputTextType = "text";
        $this->longitude->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['longitude'] = &$this->longitude;

        // min_installment
        $this->min_installment = new DbField(
            'log_search',
            'log_search',
            'x_min_installment',
            'min_installment',
            '`min_installment`',
            '`min_installment`',
            4,
            12,
            -1,
            false,
            '`min_installment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->min_installment->InputTextType = "text";
        $this->min_installment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['min_installment'] = &$this->min_installment;

        // max_installment
        $this->max_installment = new DbField(
            'log_search',
            'log_search',
            'x_max_installment',
            'max_installment',
            '`max_installment`',
            '`max_installment`',
            4,
            12,
            -1,
            false,
            '`max_installment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->max_installment->InputTextType = "text";
        $this->max_installment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['max_installment'] = &$this->max_installment;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`log_search`";
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
            $this->log_search_id->setDbValue($conn->lastInsertId());
            $rs['log_search_id'] = $this->log_search_id->DbValue;
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
            if (array_key_exists('log_search_id', $rs)) {
                AddFilter($where, QuotedName('log_search_id', $this->Dbid) . '=' . QuotedValue($rs['log_search_id'], $this->log_search_id->DataType, $this->Dbid));
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
        $this->log_search_id->DbValue = $row['log_search_id'];
        $this->attribute_detail_id->DbValue = $row['attribute_detail_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->category_id->DbValue = $row['category_id'];
        $this->search_text->DbValue = $row['search_text'];
        $this->brand_id->DbValue = $row['brand_id'];
        $this->sort_id->DbValue = $row['sort_id'];
        $this->min_price->DbValue = $row['min_price'];
        $this->max_price->DbValue = $row['max_price'];
        $this->min_size->DbValue = $row['min_size'];
        $this->max_size->DbValue = $row['max_size'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->udate->DbValue = $row['udate'];
        $this->min_down->DbValue = $row['min_down'];
        $this->max_down->DbValue = $row['max_down'];
        $this->yer_installment_max->DbValue = $row['yer_installment_max'];
        $this->latitude->DbValue = $row['latitude'];
        $this->longitude->DbValue = $row['longitude'];
        $this->min_installment->DbValue = $row['min_installment'];
        $this->max_installment->DbValue = $row['max_installment'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`log_search_id` = @log_search_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->log_search_id->CurrentValue : $this->log_search_id->OldValue;
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
                $this->log_search_id->CurrentValue = $keys[0];
            } else {
                $this->log_search_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('log_search_id', $row) ? $row['log_search_id'] : null;
        } else {
            $val = $this->log_search_id->OldValue !== null ? $this->log_search_id->OldValue : $this->log_search_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@log_search_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("logsearchlist");
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
        if ($pageName == "logsearchview") {
            return $Language->phrase("View");
        } elseif ($pageName == "logsearchedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "logsearchadd") {
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
                return "LogSearchView";
            case Config("API_ADD_ACTION"):
                return "LogSearchAdd";
            case Config("API_EDIT_ACTION"):
                return "LogSearchEdit";
            case Config("API_DELETE_ACTION"):
                return "LogSearchDelete";
            case Config("API_LIST_ACTION"):
                return "LogSearchList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "logsearchlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("logsearchview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("logsearchview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "logsearchadd?" . $this->getUrlParm($parm);
        } else {
            $url = "logsearchadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("logsearchedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("logsearchadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("logsearchdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"log_search_id\":" . JsonEncode($this->log_search_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->log_search_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->log_search_id->CurrentValue);
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
            if (($keyValue = Param("log_search_id") ?? Route("log_search_id")) !== null) {
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
                $this->log_search_id->CurrentValue = $key;
            } else {
                $this->log_search_id->OldValue = $key;
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
        $this->log_search_id->setDbValue($row['log_search_id']);
        $this->attribute_detail_id->setDbValue($row['attribute_detail_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->category_id->setDbValue($row['category_id']);
        $this->search_text->setDbValue($row['search_text']);
        $this->brand_id->setDbValue($row['brand_id']);
        $this->sort_id->setDbValue($row['sort_id']);
        $this->min_price->setDbValue($row['min_price']);
        $this->max_price->setDbValue($row['max_price']);
        $this->min_size->setDbValue($row['min_size']);
        $this->max_size->setDbValue($row['max_size']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->min_down->setDbValue($row['min_down']);
        $this->max_down->setDbValue($row['max_down']);
        $this->yer_installment_max->setDbValue($row['yer_installment_max']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->min_installment->setDbValue($row['min_installment']);
        $this->max_installment->setDbValue($row['max_installment']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // log_search_id

        // attribute_detail_id

        // member_id

        // category_id

        // search_text

        // brand_id

        // sort_id

        // min_price

        // max_price

        // min_size

        // max_size

        // cdate

        // cuser

        // cip

        // uuser

        // uip

        // udate

        // min_down

        // max_down

        // yer_installment_max

        // latitude

        // longitude

        // min_installment

        // max_installment

        // log_search_id
        $this->log_search_id->ViewValue = $this->log_search_id->CurrentValue;
        $this->log_search_id->ViewCustomAttributes = "";

        // attribute_detail_id
        $this->attribute_detail_id->ViewValue = $this->attribute_detail_id->CurrentValue;
        $this->attribute_detail_id->ViewValue = FormatNumber($this->attribute_detail_id->ViewValue, $this->attribute_detail_id->formatPattern());
        $this->attribute_detail_id->ViewCustomAttributes = "";

        // member_id
        $this->member_id->ViewValue = $this->member_id->CurrentValue;
        $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
        $this->member_id->ViewCustomAttributes = "";

        // category_id
        $this->category_id->ViewValue = $this->category_id->CurrentValue;
        $this->category_id->ViewValue = FormatNumber($this->category_id->ViewValue, $this->category_id->formatPattern());
        $this->category_id->ViewCustomAttributes = "";

        // search_text
        $this->search_text->ViewValue = $this->search_text->CurrentValue;
        $this->search_text->ViewCustomAttributes = "";

        // brand_id
        $this->brand_id->ViewValue = $this->brand_id->CurrentValue;
        $this->brand_id->ViewValue = FormatNumber($this->brand_id->ViewValue, $this->brand_id->formatPattern());
        $this->brand_id->ViewCustomAttributes = "";

        // sort_id
        $this->sort_id->ViewValue = $this->sort_id->CurrentValue;
        $this->sort_id->ViewValue = FormatNumber($this->sort_id->ViewValue, $this->sort_id->formatPattern());
        $this->sort_id->ViewCustomAttributes = "";

        // min_price
        $this->min_price->ViewValue = $this->min_price->CurrentValue;
        $this->min_price->ViewValue = FormatNumber($this->min_price->ViewValue, $this->min_price->formatPattern());
        $this->min_price->ViewCustomAttributes = "";

        // max_price
        $this->max_price->ViewValue = $this->max_price->CurrentValue;
        $this->max_price->ViewValue = FormatNumber($this->max_price->ViewValue, $this->max_price->formatPattern());
        $this->max_price->ViewCustomAttributes = "";

        // min_size
        $this->min_size->ViewValue = $this->min_size->CurrentValue;
        $this->min_size->ViewValue = FormatNumber($this->min_size->ViewValue, $this->min_size->formatPattern());
        $this->min_size->ViewCustomAttributes = "";

        // max_size
        $this->max_size->ViewValue = $this->max_size->CurrentValue;
        $this->max_size->ViewValue = FormatNumber($this->max_size->ViewValue, $this->max_size->formatPattern());
        $this->max_size->ViewCustomAttributes = "";

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

        // min_down
        $this->min_down->ViewValue = $this->min_down->CurrentValue;
        $this->min_down->ViewValue = FormatNumber($this->min_down->ViewValue, $this->min_down->formatPattern());
        $this->min_down->ViewCustomAttributes = "";

        // max_down
        $this->max_down->ViewValue = $this->max_down->CurrentValue;
        $this->max_down->ViewValue = FormatNumber($this->max_down->ViewValue, $this->max_down->formatPattern());
        $this->max_down->ViewCustomAttributes = "";

        // yer_installment_max
        $this->yer_installment_max->ViewValue = $this->yer_installment_max->CurrentValue;
        $this->yer_installment_max->ViewValue = FormatNumber($this->yer_installment_max->ViewValue, $this->yer_installment_max->formatPattern());
        $this->yer_installment_max->ViewCustomAttributes = "";

        // latitude
        $this->latitude->ViewValue = $this->latitude->CurrentValue;
        $this->latitude->ViewValue = FormatNumber($this->latitude->ViewValue, $this->latitude->formatPattern());
        $this->latitude->ViewCustomAttributes = "";

        // longitude
        $this->longitude->ViewValue = $this->longitude->CurrentValue;
        $this->longitude->ViewValue = FormatNumber($this->longitude->ViewValue, $this->longitude->formatPattern());
        $this->longitude->ViewCustomAttributes = "";

        // min_installment
        $this->min_installment->ViewValue = $this->min_installment->CurrentValue;
        $this->min_installment->ViewValue = FormatNumber($this->min_installment->ViewValue, $this->min_installment->formatPattern());
        $this->min_installment->ViewCustomAttributes = "";

        // max_installment
        $this->max_installment->ViewValue = $this->max_installment->CurrentValue;
        $this->max_installment->ViewValue = FormatNumber($this->max_installment->ViewValue, $this->max_installment->formatPattern());
        $this->max_installment->ViewCustomAttributes = "";

        // log_search_id
        $this->log_search_id->LinkCustomAttributes = "";
        $this->log_search_id->HrefValue = "";
        $this->log_search_id->TooltipValue = "";

        // attribute_detail_id
        $this->attribute_detail_id->LinkCustomAttributes = "";
        $this->attribute_detail_id->HrefValue = "";
        $this->attribute_detail_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // category_id
        $this->category_id->LinkCustomAttributes = "";
        $this->category_id->HrefValue = "";
        $this->category_id->TooltipValue = "";

        // search_text
        $this->search_text->LinkCustomAttributes = "";
        $this->search_text->HrefValue = "";
        $this->search_text->TooltipValue = "";

        // brand_id
        $this->brand_id->LinkCustomAttributes = "";
        $this->brand_id->HrefValue = "";
        $this->brand_id->TooltipValue = "";

        // sort_id
        $this->sort_id->LinkCustomAttributes = "";
        $this->sort_id->HrefValue = "";
        $this->sort_id->TooltipValue = "";

        // min_price
        $this->min_price->LinkCustomAttributes = "";
        $this->min_price->HrefValue = "";
        $this->min_price->TooltipValue = "";

        // max_price
        $this->max_price->LinkCustomAttributes = "";
        $this->max_price->HrefValue = "";
        $this->max_price->TooltipValue = "";

        // min_size
        $this->min_size->LinkCustomAttributes = "";
        $this->min_size->HrefValue = "";
        $this->min_size->TooltipValue = "";

        // max_size
        $this->max_size->LinkCustomAttributes = "";
        $this->max_size->HrefValue = "";
        $this->max_size->TooltipValue = "";

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

        // min_down
        $this->min_down->LinkCustomAttributes = "";
        $this->min_down->HrefValue = "";
        $this->min_down->TooltipValue = "";

        // max_down
        $this->max_down->LinkCustomAttributes = "";
        $this->max_down->HrefValue = "";
        $this->max_down->TooltipValue = "";

        // yer_installment_max
        $this->yer_installment_max->LinkCustomAttributes = "";
        $this->yer_installment_max->HrefValue = "";
        $this->yer_installment_max->TooltipValue = "";

        // latitude
        $this->latitude->LinkCustomAttributes = "";
        $this->latitude->HrefValue = "";
        $this->latitude->TooltipValue = "";

        // longitude
        $this->longitude->LinkCustomAttributes = "";
        $this->longitude->HrefValue = "";
        $this->longitude->TooltipValue = "";

        // min_installment
        $this->min_installment->LinkCustomAttributes = "";
        $this->min_installment->HrefValue = "";
        $this->min_installment->TooltipValue = "";

        // max_installment
        $this->max_installment->LinkCustomAttributes = "";
        $this->max_installment->HrefValue = "";
        $this->max_installment->TooltipValue = "";

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

        // log_search_id
        $this->log_search_id->setupEditAttributes();
        $this->log_search_id->EditCustomAttributes = "";
        $this->log_search_id->EditValue = $this->log_search_id->CurrentValue;
        $this->log_search_id->ViewCustomAttributes = "";

        // attribute_detail_id
        $this->attribute_detail_id->setupEditAttributes();
        $this->attribute_detail_id->EditCustomAttributes = "";
        $this->attribute_detail_id->EditValue = $this->attribute_detail_id->CurrentValue;
        $this->attribute_detail_id->PlaceHolder = RemoveHtml($this->attribute_detail_id->caption());
        if (strval($this->attribute_detail_id->EditValue) != "" && is_numeric($this->attribute_detail_id->EditValue)) {
            $this->attribute_detail_id->EditValue = FormatNumber($this->attribute_detail_id->EditValue, null);
        }

        // member_id
        $this->member_id->setupEditAttributes();
        $this->member_id->EditCustomAttributes = "";
        $this->member_id->EditValue = $this->member_id->CurrentValue;
        $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
        if (strval($this->member_id->EditValue) != "" && is_numeric($this->member_id->EditValue)) {
            $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, null);
        }

        // category_id
        $this->category_id->setupEditAttributes();
        $this->category_id->EditCustomAttributes = "";
        $this->category_id->EditValue = $this->category_id->CurrentValue;
        $this->category_id->PlaceHolder = RemoveHtml($this->category_id->caption());
        if (strval($this->category_id->EditValue) != "" && is_numeric($this->category_id->EditValue)) {
            $this->category_id->EditValue = FormatNumber($this->category_id->EditValue, null);
        }

        // search_text
        $this->search_text->setupEditAttributes();
        $this->search_text->EditCustomAttributes = "";
        $this->search_text->EditValue = $this->search_text->CurrentValue;
        $this->search_text->PlaceHolder = RemoveHtml($this->search_text->caption());

        // brand_id
        $this->brand_id->setupEditAttributes();
        $this->brand_id->EditCustomAttributes = "";
        $this->brand_id->EditValue = $this->brand_id->CurrentValue;
        $this->brand_id->PlaceHolder = RemoveHtml($this->brand_id->caption());
        if (strval($this->brand_id->EditValue) != "" && is_numeric($this->brand_id->EditValue)) {
            $this->brand_id->EditValue = FormatNumber($this->brand_id->EditValue, null);
        }

        // sort_id
        $this->sort_id->setupEditAttributes();
        $this->sort_id->EditCustomAttributes = "";
        $this->sort_id->EditValue = $this->sort_id->CurrentValue;
        $this->sort_id->PlaceHolder = RemoveHtml($this->sort_id->caption());
        if (strval($this->sort_id->EditValue) != "" && is_numeric($this->sort_id->EditValue)) {
            $this->sort_id->EditValue = FormatNumber($this->sort_id->EditValue, null);
        }

        // min_price
        $this->min_price->setupEditAttributes();
        $this->min_price->EditCustomAttributes = "";
        $this->min_price->EditValue = $this->min_price->CurrentValue;
        $this->min_price->PlaceHolder = RemoveHtml($this->min_price->caption());
        if (strval($this->min_price->EditValue) != "" && is_numeric($this->min_price->EditValue)) {
            $this->min_price->EditValue = FormatNumber($this->min_price->EditValue, null);
        }

        // max_price
        $this->max_price->setupEditAttributes();
        $this->max_price->EditCustomAttributes = "";
        $this->max_price->EditValue = $this->max_price->CurrentValue;
        $this->max_price->PlaceHolder = RemoveHtml($this->max_price->caption());
        if (strval($this->max_price->EditValue) != "" && is_numeric($this->max_price->EditValue)) {
            $this->max_price->EditValue = FormatNumber($this->max_price->EditValue, null);
        }

        // min_size
        $this->min_size->setupEditAttributes();
        $this->min_size->EditCustomAttributes = "";
        $this->min_size->EditValue = $this->min_size->CurrentValue;
        $this->min_size->PlaceHolder = RemoveHtml($this->min_size->caption());
        if (strval($this->min_size->EditValue) != "" && is_numeric($this->min_size->EditValue)) {
            $this->min_size->EditValue = FormatNumber($this->min_size->EditValue, null);
        }

        // max_size
        $this->max_size->setupEditAttributes();
        $this->max_size->EditCustomAttributes = "";
        $this->max_size->EditValue = $this->max_size->CurrentValue;
        $this->max_size->PlaceHolder = RemoveHtml($this->max_size->caption());
        if (strval($this->max_size->EditValue) != "" && is_numeric($this->max_size->EditValue)) {
            $this->max_size->EditValue = FormatNumber($this->max_size->EditValue, null);
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

        // uuser
        $this->uuser->setupEditAttributes();
        $this->uuser->EditCustomAttributes = "";
        if (!$this->uuser->Raw) {
            $this->uuser->CurrentValue = HtmlDecode($this->uuser->CurrentValue);
        }
        $this->uuser->EditValue = $this->uuser->CurrentValue;
        $this->uuser->PlaceHolder = RemoveHtml($this->uuser->caption());

        // uip
        $this->uip->setupEditAttributes();
        $this->uip->EditCustomAttributes = "";
        if (!$this->uip->Raw) {
            $this->uip->CurrentValue = HtmlDecode($this->uip->CurrentValue);
        }
        $this->uip->EditValue = $this->uip->CurrentValue;
        $this->uip->PlaceHolder = RemoveHtml($this->uip->caption());

        // udate
        $this->udate->setupEditAttributes();
        $this->udate->EditCustomAttributes = "";
        $this->udate->EditValue = FormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->udate->PlaceHolder = RemoveHtml($this->udate->caption());

        // min_down
        $this->min_down->setupEditAttributes();
        $this->min_down->EditCustomAttributes = "";
        $this->min_down->EditValue = $this->min_down->CurrentValue;
        $this->min_down->PlaceHolder = RemoveHtml($this->min_down->caption());
        if (strval($this->min_down->EditValue) != "" && is_numeric($this->min_down->EditValue)) {
            $this->min_down->EditValue = FormatNumber($this->min_down->EditValue, null);
        }

        // max_down
        $this->max_down->setupEditAttributes();
        $this->max_down->EditCustomAttributes = "";
        $this->max_down->EditValue = $this->max_down->CurrentValue;
        $this->max_down->PlaceHolder = RemoveHtml($this->max_down->caption());
        if (strval($this->max_down->EditValue) != "" && is_numeric($this->max_down->EditValue)) {
            $this->max_down->EditValue = FormatNumber($this->max_down->EditValue, null);
        }

        // yer_installment_max
        $this->yer_installment_max->setupEditAttributes();
        $this->yer_installment_max->EditCustomAttributes = "";
        $this->yer_installment_max->EditValue = $this->yer_installment_max->CurrentValue;
        $this->yer_installment_max->PlaceHolder = RemoveHtml($this->yer_installment_max->caption());
        if (strval($this->yer_installment_max->EditValue) != "" && is_numeric($this->yer_installment_max->EditValue)) {
            $this->yer_installment_max->EditValue = FormatNumber($this->yer_installment_max->EditValue, null);
        }

        // latitude
        $this->latitude->setupEditAttributes();
        $this->latitude->EditCustomAttributes = "";
        $this->latitude->EditValue = $this->latitude->CurrentValue;
        $this->latitude->PlaceHolder = RemoveHtml($this->latitude->caption());
        if (strval($this->latitude->EditValue) != "" && is_numeric($this->latitude->EditValue)) {
            $this->latitude->EditValue = FormatNumber($this->latitude->EditValue, null);
        }

        // longitude
        $this->longitude->setupEditAttributes();
        $this->longitude->EditCustomAttributes = "";
        $this->longitude->EditValue = $this->longitude->CurrentValue;
        $this->longitude->PlaceHolder = RemoveHtml($this->longitude->caption());
        if (strval($this->longitude->EditValue) != "" && is_numeric($this->longitude->EditValue)) {
            $this->longitude->EditValue = FormatNumber($this->longitude->EditValue, null);
        }

        // min_installment
        $this->min_installment->setupEditAttributes();
        $this->min_installment->EditCustomAttributes = "";
        $this->min_installment->EditValue = $this->min_installment->CurrentValue;
        $this->min_installment->PlaceHolder = RemoveHtml($this->min_installment->caption());
        if (strval($this->min_installment->EditValue) != "" && is_numeric($this->min_installment->EditValue)) {
            $this->min_installment->EditValue = FormatNumber($this->min_installment->EditValue, null);
        }

        // max_installment
        $this->max_installment->setupEditAttributes();
        $this->max_installment->EditCustomAttributes = "";
        $this->max_installment->EditValue = $this->max_installment->CurrentValue;
        $this->max_installment->PlaceHolder = RemoveHtml($this->max_installment->caption());
        if (strval($this->max_installment->EditValue) != "" && is_numeric($this->max_installment->EditValue)) {
            $this->max_installment->EditValue = FormatNumber($this->max_installment->EditValue, null);
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
                    $doc->exportCaption($this->log_search_id);
                    $doc->exportCaption($this->attribute_detail_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->category_id);
                    $doc->exportCaption($this->search_text);
                    $doc->exportCaption($this->brand_id);
                    $doc->exportCaption($this->sort_id);
                    $doc->exportCaption($this->min_price);
                    $doc->exportCaption($this->max_price);
                    $doc->exportCaption($this->min_size);
                    $doc->exportCaption($this->max_size);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->min_down);
                    $doc->exportCaption($this->max_down);
                    $doc->exportCaption($this->yer_installment_max);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->min_installment);
                    $doc->exportCaption($this->max_installment);
                } else {
                    $doc->exportCaption($this->log_search_id);
                    $doc->exportCaption($this->attribute_detail_id);
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->category_id);
                    $doc->exportCaption($this->brand_id);
                    $doc->exportCaption($this->sort_id);
                    $doc->exportCaption($this->min_price);
                    $doc->exportCaption($this->max_price);
                    $doc->exportCaption($this->min_size);
                    $doc->exportCaption($this->max_size);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->min_down);
                    $doc->exportCaption($this->max_down);
                    $doc->exportCaption($this->yer_installment_max);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->min_installment);
                    $doc->exportCaption($this->max_installment);
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
                        $doc->exportField($this->log_search_id);
                        $doc->exportField($this->attribute_detail_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->category_id);
                        $doc->exportField($this->search_text);
                        $doc->exportField($this->brand_id);
                        $doc->exportField($this->sort_id);
                        $doc->exportField($this->min_price);
                        $doc->exportField($this->max_price);
                        $doc->exportField($this->min_size);
                        $doc->exportField($this->max_size);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->min_down);
                        $doc->exportField($this->max_down);
                        $doc->exportField($this->yer_installment_max);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->min_installment);
                        $doc->exportField($this->max_installment);
                    } else {
                        $doc->exportField($this->log_search_id);
                        $doc->exportField($this->attribute_detail_id);
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->category_id);
                        $doc->exportField($this->brand_id);
                        $doc->exportField($this->sort_id);
                        $doc->exportField($this->min_price);
                        $doc->exportField($this->max_price);
                        $doc->exportField($this->min_size);
                        $doc->exportField($this->max_size);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->min_down);
                        $doc->exportField($this->max_down);
                        $doc->exportField($this->yer_installment_max);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->min_installment);
                        $doc->exportField($this->max_installment);
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
