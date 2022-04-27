<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for doc_creden_signer
 */
class DocCredenSigner extends DbTable
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
    public $doc_creden_signer_id;
    public $doc_creden_id;
    public $doc_creden_signer_no;
    public $doc_creden_signer_link;
    public $doc_creden_signer_session;
    public $doc_creden_signer_name;
    public $doc_creden_signer_email;
    public $status;
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
        $this->TableVar = 'doc_creden_signer';
        $this->TableName = 'doc_creden_signer';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`doc_creden_signer`";
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

        // doc_creden_signer_id
        $this->doc_creden_signer_id = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_signer_id',
            'doc_creden_signer_id',
            '`doc_creden_signer_id`',
            '`doc_creden_signer_id`',
            3,
            11,
            -1,
            false,
            '`doc_creden_signer_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->doc_creden_signer_id->InputTextType = "text";
        $this->doc_creden_signer_id->IsAutoIncrement = true; // Autoincrement field
        $this->doc_creden_signer_id->IsPrimaryKey = true; // Primary key field
        $this->doc_creden_signer_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['doc_creden_signer_id'] = &$this->doc_creden_signer_id;

        // doc_creden_id
        $this->doc_creden_id = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_id',
            'doc_creden_id',
            '`doc_creden_id`',
            '`doc_creden_id`',
            3,
            11,
            -1,
            false,
            '`doc_creden_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_id->InputTextType = "text";
        $this->doc_creden_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['doc_creden_id'] = &$this->doc_creden_id;

        // doc_creden_signer_no
        $this->doc_creden_signer_no = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_signer_no',
            'doc_creden_signer_no',
            '`doc_creden_signer_no`',
            '`doc_creden_signer_no`',
            200,
            250,
            -1,
            false,
            '`doc_creden_signer_no`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_signer_no->InputTextType = "text";
        $this->Fields['doc_creden_signer_no'] = &$this->doc_creden_signer_no;

        // doc_creden_signer_link
        $this->doc_creden_signer_link = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_signer_link',
            'doc_creden_signer_link',
            '`doc_creden_signer_link`',
            '`doc_creden_signer_link`',
            201,
            500,
            -1,
            false,
            '`doc_creden_signer_link`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_signer_link->InputTextType = "text";
        $this->Fields['doc_creden_signer_link'] = &$this->doc_creden_signer_link;

        // doc_creden_signer_session
        $this->doc_creden_signer_session = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_signer_session',
            'doc_creden_signer_session',
            '`doc_creden_signer_session`',
            '`doc_creden_signer_session`',
            200,
            250,
            -1,
            false,
            '`doc_creden_signer_session`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_signer_session->InputTextType = "text";
        $this->Fields['doc_creden_signer_session'] = &$this->doc_creden_signer_session;

        // doc_creden_signer_name
        $this->doc_creden_signer_name = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_signer_name',
            'doc_creden_signer_name',
            '`doc_creden_signer_name`',
            '`doc_creden_signer_name`',
            201,
            500,
            -1,
            false,
            '`doc_creden_signer_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_signer_name->InputTextType = "text";
        $this->Fields['doc_creden_signer_name'] = &$this->doc_creden_signer_name;

        // doc_creden_signer_email
        $this->doc_creden_signer_email = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_doc_creden_signer_email',
            'doc_creden_signer_email',
            '`doc_creden_signer_email`',
            '`doc_creden_signer_email`',
            200,
            250,
            -1,
            false,
            '`doc_creden_signer_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->doc_creden_signer_email->InputTextType = "text";
        $this->Fields['doc_creden_signer_email'] = &$this->doc_creden_signer_email;

        // status
        $this->status = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_status',
            'status',
            '`status`',
            '`status`',
            3,
            11,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->status->InputTextType = "text";
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // cdate
        $this->cdate = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
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
            'doc_creden_signer',
            'doc_creden_signer',
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
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_cip',
            'cip',
            '`cip`',
            '`cip`',
            200,
            50,
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
            'doc_creden_signer',
            'doc_creden_signer',
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

        // uuser
        $this->uuser = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
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
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'doc_creden_signer',
            'doc_creden_signer',
            'x_uip',
            'uip',
            '`uip`',
            '`uip`',
            200,
            50,
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`doc_creden_signer`";
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
            $this->doc_creden_signer_id->setDbValue($conn->lastInsertId());
            $rs['doc_creden_signer_id'] = $this->doc_creden_signer_id->DbValue;
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
            if (array_key_exists('doc_creden_signer_id', $rs)) {
                AddFilter($where, QuotedName('doc_creden_signer_id', $this->Dbid) . '=' . QuotedValue($rs['doc_creden_signer_id'], $this->doc_creden_signer_id->DataType, $this->Dbid));
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
        $this->doc_creden_signer_id->DbValue = $row['doc_creden_signer_id'];
        $this->doc_creden_id->DbValue = $row['doc_creden_id'];
        $this->doc_creden_signer_no->DbValue = $row['doc_creden_signer_no'];
        $this->doc_creden_signer_link->DbValue = $row['doc_creden_signer_link'];
        $this->doc_creden_signer_session->DbValue = $row['doc_creden_signer_session'];
        $this->doc_creden_signer_name->DbValue = $row['doc_creden_signer_name'];
        $this->doc_creden_signer_email->DbValue = $row['doc_creden_signer_email'];
        $this->status->DbValue = $row['status'];
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
        return "`doc_creden_signer_id` = @doc_creden_signer_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->doc_creden_signer_id->CurrentValue : $this->doc_creden_signer_id->OldValue;
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
                $this->doc_creden_signer_id->CurrentValue = $keys[0];
            } else {
                $this->doc_creden_signer_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('doc_creden_signer_id', $row) ? $row['doc_creden_signer_id'] : null;
        } else {
            $val = $this->doc_creden_signer_id->OldValue !== null ? $this->doc_creden_signer_id->OldValue : $this->doc_creden_signer_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@doc_creden_signer_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("doccredensignerlist");
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
        if ($pageName == "doccredensignerview") {
            return $Language->phrase("View");
        } elseif ($pageName == "doccredensigneredit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "doccredensigneradd") {
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
                return "DocCredenSignerView";
            case Config("API_ADD_ACTION"):
                return "DocCredenSignerAdd";
            case Config("API_EDIT_ACTION"):
                return "DocCredenSignerEdit";
            case Config("API_DELETE_ACTION"):
                return "DocCredenSignerDelete";
            case Config("API_LIST_ACTION"):
                return "DocCredenSignerList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "doccredensignerlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("doccredensignerview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("doccredensignerview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "doccredensigneradd?" . $this->getUrlParm($parm);
        } else {
            $url = "doccredensigneradd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("doccredensigneredit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("doccredensigneradd", $this->getUrlParm($parm));
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
        return $this->keyUrl("doccredensignerdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"doc_creden_signer_id\":" . JsonEncode($this->doc_creden_signer_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->doc_creden_signer_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->doc_creden_signer_id->CurrentValue);
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
            if (($keyValue = Param("doc_creden_signer_id") ?? Route("doc_creden_signer_id")) !== null) {
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
                $this->doc_creden_signer_id->CurrentValue = $key;
            } else {
                $this->doc_creden_signer_id->OldValue = $key;
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
        $this->doc_creden_signer_id->setDbValue($row['doc_creden_signer_id']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
        $this->doc_creden_signer_no->setDbValue($row['doc_creden_signer_no']);
        $this->doc_creden_signer_link->setDbValue($row['doc_creden_signer_link']);
        $this->doc_creden_signer_session->setDbValue($row['doc_creden_signer_session']);
        $this->doc_creden_signer_name->setDbValue($row['doc_creden_signer_name']);
        $this->doc_creden_signer_email->setDbValue($row['doc_creden_signer_email']);
        $this->status->setDbValue($row['status']);
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

        // doc_creden_signer_id

        // doc_creden_id

        // doc_creden_signer_no

        // doc_creden_signer_link

        // doc_creden_signer_session

        // doc_creden_signer_name

        // doc_creden_signer_email

        // status

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // doc_creden_signer_id
        $this->doc_creden_signer_id->ViewValue = $this->doc_creden_signer_id->CurrentValue;
        $this->doc_creden_signer_id->ViewCustomAttributes = "";

        // doc_creden_id
        $this->doc_creden_id->ViewValue = $this->doc_creden_id->CurrentValue;
        $this->doc_creden_id->ViewValue = FormatNumber($this->doc_creden_id->ViewValue, $this->doc_creden_id->formatPattern());
        $this->doc_creden_id->ViewCustomAttributes = "";

        // doc_creden_signer_no
        $this->doc_creden_signer_no->ViewValue = $this->doc_creden_signer_no->CurrentValue;
        $this->doc_creden_signer_no->ViewCustomAttributes = "";

        // doc_creden_signer_link
        $this->doc_creden_signer_link->ViewValue = $this->doc_creden_signer_link->CurrentValue;
        $this->doc_creden_signer_link->ViewCustomAttributes = "";

        // doc_creden_signer_session
        $this->doc_creden_signer_session->ViewValue = $this->doc_creden_signer_session->CurrentValue;
        $this->doc_creden_signer_session->ViewCustomAttributes = "";

        // doc_creden_signer_name
        $this->doc_creden_signer_name->ViewValue = $this->doc_creden_signer_name->CurrentValue;
        $this->doc_creden_signer_name->ViewCustomAttributes = "";

        // doc_creden_signer_email
        $this->doc_creden_signer_email->ViewValue = $this->doc_creden_signer_email->CurrentValue;
        $this->doc_creden_signer_email->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewValue = FormatNumber($this->status->ViewValue, $this->status->formatPattern());
        $this->status->ViewCustomAttributes = "";

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

        // doc_creden_signer_id
        $this->doc_creden_signer_id->LinkCustomAttributes = "";
        $this->doc_creden_signer_id->HrefValue = "";
        $this->doc_creden_signer_id->TooltipValue = "";

        // doc_creden_id
        $this->doc_creden_id->LinkCustomAttributes = "";
        $this->doc_creden_id->HrefValue = "";
        $this->doc_creden_id->TooltipValue = "";

        // doc_creden_signer_no
        $this->doc_creden_signer_no->LinkCustomAttributes = "";
        $this->doc_creden_signer_no->HrefValue = "";
        $this->doc_creden_signer_no->TooltipValue = "";

        // doc_creden_signer_link
        $this->doc_creden_signer_link->LinkCustomAttributes = "";
        $this->doc_creden_signer_link->HrefValue = "";
        $this->doc_creden_signer_link->TooltipValue = "";

        // doc_creden_signer_session
        $this->doc_creden_signer_session->LinkCustomAttributes = "";
        $this->doc_creden_signer_session->HrefValue = "";
        $this->doc_creden_signer_session->TooltipValue = "";

        // doc_creden_signer_name
        $this->doc_creden_signer_name->LinkCustomAttributes = "";
        $this->doc_creden_signer_name->HrefValue = "";
        $this->doc_creden_signer_name->TooltipValue = "";

        // doc_creden_signer_email
        $this->doc_creden_signer_email->LinkCustomAttributes = "";
        $this->doc_creden_signer_email->HrefValue = "";
        $this->doc_creden_signer_email->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

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

        // doc_creden_signer_id
        $this->doc_creden_signer_id->setupEditAttributes();
        $this->doc_creden_signer_id->EditCustomAttributes = "";
        $this->doc_creden_signer_id->EditValue = $this->doc_creden_signer_id->CurrentValue;
        $this->doc_creden_signer_id->ViewCustomAttributes = "";

        // doc_creden_id
        $this->doc_creden_id->setupEditAttributes();
        $this->doc_creden_id->EditCustomAttributes = "";
        $this->doc_creden_id->EditValue = $this->doc_creden_id->CurrentValue;
        $this->doc_creden_id->PlaceHolder = RemoveHtml($this->doc_creden_id->caption());
        if (strval($this->doc_creden_id->EditValue) != "" && is_numeric($this->doc_creden_id->EditValue)) {
            $this->doc_creden_id->EditValue = FormatNumber($this->doc_creden_id->EditValue, null);
        }

        // doc_creden_signer_no
        $this->doc_creden_signer_no->setupEditAttributes();
        $this->doc_creden_signer_no->EditCustomAttributes = "";
        if (!$this->doc_creden_signer_no->Raw) {
            $this->doc_creden_signer_no->CurrentValue = HtmlDecode($this->doc_creden_signer_no->CurrentValue);
        }
        $this->doc_creden_signer_no->EditValue = $this->doc_creden_signer_no->CurrentValue;
        $this->doc_creden_signer_no->PlaceHolder = RemoveHtml($this->doc_creden_signer_no->caption());

        // doc_creden_signer_link
        $this->doc_creden_signer_link->setupEditAttributes();
        $this->doc_creden_signer_link->EditCustomAttributes = "";
        if (!$this->doc_creden_signer_link->Raw) {
            $this->doc_creden_signer_link->CurrentValue = HtmlDecode($this->doc_creden_signer_link->CurrentValue);
        }
        $this->doc_creden_signer_link->EditValue = $this->doc_creden_signer_link->CurrentValue;
        $this->doc_creden_signer_link->PlaceHolder = RemoveHtml($this->doc_creden_signer_link->caption());

        // doc_creden_signer_session
        $this->doc_creden_signer_session->setupEditAttributes();
        $this->doc_creden_signer_session->EditCustomAttributes = "";
        if (!$this->doc_creden_signer_session->Raw) {
            $this->doc_creden_signer_session->CurrentValue = HtmlDecode($this->doc_creden_signer_session->CurrentValue);
        }
        $this->doc_creden_signer_session->EditValue = $this->doc_creden_signer_session->CurrentValue;
        $this->doc_creden_signer_session->PlaceHolder = RemoveHtml($this->doc_creden_signer_session->caption());

        // doc_creden_signer_name
        $this->doc_creden_signer_name->setupEditAttributes();
        $this->doc_creden_signer_name->EditCustomAttributes = "";
        if (!$this->doc_creden_signer_name->Raw) {
            $this->doc_creden_signer_name->CurrentValue = HtmlDecode($this->doc_creden_signer_name->CurrentValue);
        }
        $this->doc_creden_signer_name->EditValue = $this->doc_creden_signer_name->CurrentValue;
        $this->doc_creden_signer_name->PlaceHolder = RemoveHtml($this->doc_creden_signer_name->caption());

        // doc_creden_signer_email
        $this->doc_creden_signer_email->setupEditAttributes();
        $this->doc_creden_signer_email->EditCustomAttributes = "";
        if (!$this->doc_creden_signer_email->Raw) {
            $this->doc_creden_signer_email->CurrentValue = HtmlDecode($this->doc_creden_signer_email->CurrentValue);
        }
        $this->doc_creden_signer_email->EditValue = $this->doc_creden_signer_email->CurrentValue;
        $this->doc_creden_signer_email->PlaceHolder = RemoveHtml($this->doc_creden_signer_email->caption());

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());
        if (strval($this->status->EditValue) != "" && is_numeric($this->status->EditValue)) {
            $this->status->EditValue = FormatNumber($this->status->EditValue, null);
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
                    $doc->exportCaption($this->doc_creden_signer_id);
                    $doc->exportCaption($this->doc_creden_id);
                    $doc->exportCaption($this->doc_creden_signer_no);
                    $doc->exportCaption($this->doc_creden_signer_link);
                    $doc->exportCaption($this->doc_creden_signer_session);
                    $doc->exportCaption($this->doc_creden_signer_name);
                    $doc->exportCaption($this->doc_creden_signer_email);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                } else {
                    $doc->exportCaption($this->doc_creden_signer_id);
                    $doc->exportCaption($this->doc_creden_id);
                    $doc->exportCaption($this->doc_creden_signer_no);
                    $doc->exportCaption($this->doc_creden_signer_link);
                    $doc->exportCaption($this->doc_creden_signer_session);
                    $doc->exportCaption($this->doc_creden_signer_name);
                    $doc->exportCaption($this->doc_creden_signer_email);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
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
                        $doc->exportField($this->doc_creden_signer_id);
                        $doc->exportField($this->doc_creden_id);
                        $doc->exportField($this->doc_creden_signer_no);
                        $doc->exportField($this->doc_creden_signer_link);
                        $doc->exportField($this->doc_creden_signer_session);
                        $doc->exportField($this->doc_creden_signer_name);
                        $doc->exportField($this->doc_creden_signer_email);
                        $doc->exportField($this->status);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                    } else {
                        $doc->exportField($this->doc_creden_signer_id);
                        $doc->exportField($this->doc_creden_id);
                        $doc->exportField($this->doc_creden_signer_no);
                        $doc->exportField($this->doc_creden_signer_link);
                        $doc->exportField($this->doc_creden_signer_session);
                        $doc->exportField($this->doc_creden_signer_name);
                        $doc->exportField($this->doc_creden_signer_email);
                        $doc->exportField($this->status);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
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
