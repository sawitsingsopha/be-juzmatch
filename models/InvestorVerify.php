<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for investor_verify
 */
class InvestorVerify extends DbTable
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
    public $juzcalculator_id;
    public $member_id;
    public $firstname;
    public $lastname;
    public $phone;
    public $_email;
    public $status;
    public $income_all;
    public $outcome_all;
    public $investment;
    public $credit_limit;
    public $monthly_payments;
    public $highest_rental_price;
    public $transfer;
    public $total_invertor_year;
    public $invert_payoff_day;
    public $type_invertor;
    public $invest_amount;
    public $rent_price;
    public $asset_price;
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
        $this->TableVar = 'investor_verify';
        $this->TableName = 'investor_verify';
        $this->TableType = 'LINKTABLE';

        // Update Table
        $this->UpdateTable = "`juzcalculator`";
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

        // juzcalculator_id
        $this->juzcalculator_id = new DbField(
            'investor_verify',
            'investor_verify',
            'x_juzcalculator_id',
            'juzcalculator_id',
            '`juzcalculator_id`',
            '`juzcalculator_id`',
            3,
            11,
            -1,
            false,
            '`juzcalculator_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->juzcalculator_id->InputTextType = "text";
        $this->juzcalculator_id->IsAutoIncrement = true; // Autoincrement field
        $this->juzcalculator_id->IsPrimaryKey = true; // Primary key field
        $this->juzcalculator_id->Sortable = false; // Allow sort
        $this->juzcalculator_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['juzcalculator_id'] = &$this->juzcalculator_id;

        // member_id
        $this->member_id = new DbField(
            'investor_verify',
            'investor_verify',
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
        $this->member_id->Sortable = false; // Allow sort
        $this->member_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->member_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // firstname
        $this->firstname = new DbField(
            'investor_verify',
            'investor_verify',
            'x_firstname',
            'firstname',
            '`firstname`',
            '`firstname`',
            200,
            255,
            -1,
            false,
            '`firstname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->firstname->InputTextType = "text";
        $this->firstname->Sortable = false; // Allow sort
        $this->Fields['firstname'] = &$this->firstname;

        // lastname
        $this->lastname = new DbField(
            'investor_verify',
            'investor_verify',
            'x_lastname',
            'lastname',
            '`lastname`',
            '`lastname`',
            200,
            255,
            -1,
            false,
            '`lastname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastname->InputTextType = "text";
        $this->lastname->Sortable = false; // Allow sort
        $this->Fields['lastname'] = &$this->lastname;

        // phone
        $this->phone = new DbField(
            'investor_verify',
            'investor_verify',
            'x_phone',
            'phone',
            '`phone`',
            '`phone`',
            200,
            255,
            -1,
            false,
            '`phone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->phone->InputTextType = "text";
        $this->phone->Required = true; // Required field
        $this->phone->Sortable = false; // Allow sort
        $this->Fields['phone'] = &$this->phone;

        // email
        $this->_email = new DbField(
            'investor_verify',
            'investor_verify',
            'x__email',
            'email',
            '`email`',
            '`email`',
            200,
            255,
            -1,
            false,
            '`email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_email->InputTextType = "text";
        $this->_email->Required = true; // Required field
        $this->_email->Sortable = false; // Allow sort
        $this->Fields['email'] = &$this->_email;

        // status
        $this->status = new DbField(
            'investor_verify',
            'investor_verify',
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
            'SELECT'
        );
        $this->status->InputTextType = "text";
        $this->status->Sortable = false; // Allow sort
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status->Lookup = new Lookup('status', 'investor_verify', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status->OptionCount = 2;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // income_all
        $this->income_all = new DbField(
            'investor_verify',
            'investor_verify',
            'x_income_all',
            'income_all',
            '`income_all`',
            '`income_all`',
            4,
            12,
            -1,
            false,
            '`income_all`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->income_all->InputTextType = "text";
        $this->income_all->Required = true; // Required field
        $this->income_all->Sortable = false; // Allow sort
        $this->income_all->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['income_all'] = &$this->income_all;

        // outcome_all
        $this->outcome_all = new DbField(
            'investor_verify',
            'investor_verify',
            'x_outcome_all',
            'outcome_all',
            '`outcome_all`',
            '`outcome_all`',
            4,
            12,
            -1,
            false,
            '`outcome_all`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->outcome_all->InputTextType = "text";
        $this->outcome_all->Sortable = false; // Allow sort
        $this->outcome_all->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['outcome_all'] = &$this->outcome_all;

        // investment
        $this->investment = new DbField(
            'investor_verify',
            'investor_verify',
            'x_investment',
            'investment',
            '`investment`',
            '`investment`',
            4,
            12,
            -1,
            false,
            '`investment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->investment->InputTextType = "text";
        $this->investment->Sortable = false; // Allow sort
        $this->investment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['investment'] = &$this->investment;

        // credit_limit
        $this->credit_limit = new DbField(
            'investor_verify',
            'investor_verify',
            'x_credit_limit',
            'credit_limit',
            '`credit_limit`',
            '`credit_limit`',
            4,
            12,
            -1,
            false,
            '`credit_limit`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->credit_limit->InputTextType = "text";
        $this->credit_limit->Sortable = false; // Allow sort
        $this->credit_limit->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['credit_limit'] = &$this->credit_limit;

        // monthly_payments
        $this->monthly_payments = new DbField(
            'investor_verify',
            'investor_verify',
            'x_monthly_payments',
            'monthly_payments',
            '`monthly_payments`',
            '`monthly_payments`',
            4,
            12,
            -1,
            false,
            '`monthly_payments`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->monthly_payments->InputTextType = "text";
        $this->monthly_payments->Required = true; // Required field
        $this->monthly_payments->Sortable = false; // Allow sort
        $this->monthly_payments->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['monthly_payments'] = &$this->monthly_payments;

        // highest_rental_price
        $this->highest_rental_price = new DbField(
            'investor_verify',
            'investor_verify',
            'x_highest_rental_price',
            'highest_rental_price',
            '`highest_rental_price`',
            '`highest_rental_price`',
            4,
            12,
            -1,
            false,
            '`highest_rental_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->highest_rental_price->InputTextType = "text";
        $this->highest_rental_price->Required = true; // Required field
        $this->highest_rental_price->Sortable = false; // Allow sort
        $this->highest_rental_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['highest_rental_price'] = &$this->highest_rental_price;

        // transfer
        $this->transfer = new DbField(
            'investor_verify',
            'investor_verify',
            'x_transfer',
            'transfer',
            '`transfer`',
            '`transfer`',
            3,
            11,
            -1,
            false,
            '`transfer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->transfer->InputTextType = "text";
        $this->transfer->Sortable = false; // Allow sort
        $this->transfer->Lookup = new Lookup('transfer', 'investor_verify', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->transfer->OptionCount = 2;
        $this->transfer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['transfer'] = &$this->transfer;

        // total_invertor_year
        $this->total_invertor_year = new DbField(
            'investor_verify',
            'investor_verify',
            'x_total_invertor_year',
            'total_invertor_year',
            '`total_invertor_year`',
            '`total_invertor_year`',
            4,
            12,
            -1,
            false,
            '`total_invertor_year`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->total_invertor_year->InputTextType = "text";
        $this->total_invertor_year->Sortable = false; // Allow sort
        $this->total_invertor_year->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['total_invertor_year'] = &$this->total_invertor_year;

        // invert_payoff_day
        $this->invert_payoff_day = new DbField(
            'investor_verify',
            'investor_verify',
            'x_invert_payoff_day',
            'invert_payoff_day',
            '`invert_payoff_day`',
            '`invert_payoff_day`',
            4,
            12,
            -1,
            false,
            '`invert_payoff_day`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->invert_payoff_day->InputTextType = "text";
        $this->invert_payoff_day->Sortable = false; // Allow sort
        $this->invert_payoff_day->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['invert_payoff_day'] = &$this->invert_payoff_day;

        // type_invertor
        $this->type_invertor = new DbField(
            'investor_verify',
            'investor_verify',
            'x_type_invertor',
            'type_invertor',
            '`type_invertor`',
            '`type_invertor`',
            3,
            11,
            -1,
            false,
            '`type_invertor`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->type_invertor->InputTextType = "text";
        $this->type_invertor->Sortable = false; // Allow sort
        $this->type_invertor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->type_invertor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->type_invertor->Lookup = new Lookup('type_invertor', 'investor_verify', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->type_invertor->OptionCount = 3;
        $this->type_invertor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['type_invertor'] = &$this->type_invertor;

        // invest_amount
        $this->invest_amount = new DbField(
            'investor_verify',
            'investor_verify',
            'x_invest_amount',
            'invest_amount',
            '`invest_amount`',
            '`invest_amount`',
            4,
            12,
            -1,
            false,
            '`invest_amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->invest_amount->InputTextType = "text";
        $this->invest_amount->Sortable = false; // Allow sort
        $this->invest_amount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['invest_amount'] = &$this->invest_amount;

        // rent_price
        $this->rent_price = new DbField(
            'investor_verify',
            'investor_verify',
            'x_rent_price',
            'rent_price',
            '`rent_price`',
            '`rent_price`',
            4,
            12,
            -1,
            false,
            '`rent_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->rent_price->InputTextType = "text";
        $this->rent_price->Sortable = false; // Allow sort
        $this->rent_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['rent_price'] = &$this->rent_price;

        // asset_price
        $this->asset_price = new DbField(
            'investor_verify',
            'investor_verify',
            'x_asset_price',
            'asset_price',
            '`asset_price`',
            '`asset_price`',
            4,
            12,
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
        $this->asset_price->Sortable = false; // Allow sort
        $this->asset_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['asset_price'] = &$this->asset_price;

        // cdate
        $this->cdate = new DbField(
            'investor_verify',
            'investor_verify',
            'x_cdate',
            'cdate',
            '`cdate`',
            '`cdate`',
            200,
            45,
            117,
            false,
            '`cdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cdate->InputTextType = "text";
        $this->cdate->DefaultErrorMessage = str_replace("%s", DateFormat(117), $Language->phrase("IncorrectDate"));
        $this->Fields['cdate'] = &$this->cdate;

        // cuser
        $this->cuser = new DbField(
            'investor_verify',
            'investor_verify',
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
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'investor_verify',
            'investor_verify',
            'x_cip',
            'cip',
            '`cip`',
            '`cip`',
            200,
            45,
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
            'investor_verify',
            'investor_verify',
            'x_udate',
            'udate',
            '`udate`',
            '`udate`',
            200,
            255,
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
            'investor_verify',
            'investor_verify',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            200,
            255,
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

        // uip
        $this->uip = new DbField(
            'investor_verify',
            'investor_verify',
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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "investor") {
            if ($this->member_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "investor") {
            if ($this->member_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "investor":
                $key = $keys["member_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->member_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`member_id`=" . QuotedValue($keys["member_id"], $masterTable->member_id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "investor":
                return "`member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`juzcalculator`";
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
            $this->juzcalculator_id->setDbValue($conn->lastInsertId());
            $rs['juzcalculator_id'] = $this->juzcalculator_id->DbValue;
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
            if (array_key_exists('juzcalculator_id', $rs)) {
                AddFilter($where, QuotedName('juzcalculator_id', $this->Dbid) . '=' . QuotedValue($rs['juzcalculator_id'], $this->juzcalculator_id->DataType, $this->Dbid));
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
        $this->juzcalculator_id->DbValue = $row['juzcalculator_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->firstname->DbValue = $row['firstname'];
        $this->lastname->DbValue = $row['lastname'];
        $this->phone->DbValue = $row['phone'];
        $this->_email->DbValue = $row['email'];
        $this->status->DbValue = $row['status'];
        $this->income_all->DbValue = $row['income_all'];
        $this->outcome_all->DbValue = $row['outcome_all'];
        $this->investment->DbValue = $row['investment'];
        $this->credit_limit->DbValue = $row['credit_limit'];
        $this->monthly_payments->DbValue = $row['monthly_payments'];
        $this->highest_rental_price->DbValue = $row['highest_rental_price'];
        $this->transfer->DbValue = $row['transfer'];
        $this->total_invertor_year->DbValue = $row['total_invertor_year'];
        $this->invert_payoff_day->DbValue = $row['invert_payoff_day'];
        $this->type_invertor->DbValue = $row['type_invertor'];
        $this->invest_amount->DbValue = $row['invest_amount'];
        $this->rent_price->DbValue = $row['rent_price'];
        $this->asset_price->DbValue = $row['asset_price'];
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
        return "`juzcalculator_id` = @juzcalculator_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->juzcalculator_id->CurrentValue : $this->juzcalculator_id->OldValue;
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
                $this->juzcalculator_id->CurrentValue = $keys[0];
            } else {
                $this->juzcalculator_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('juzcalculator_id', $row) ? $row['juzcalculator_id'] : null;
        } else {
            $val = $this->juzcalculator_id->OldValue !== null ? $this->juzcalculator_id->OldValue : $this->juzcalculator_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@juzcalculator_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("investorverifylist");
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
        if ($pageName == "investorverifyview") {
            return $Language->phrase("View");
        } elseif ($pageName == "investorverifyedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "investorverifyadd") {
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
                return "InvestorVerifyView";
            case Config("API_ADD_ACTION"):
                return "InvestorVerifyAdd";
            case Config("API_EDIT_ACTION"):
                return "InvestorVerifyEdit";
            case Config("API_DELETE_ACTION"):
                return "InvestorVerifyDelete";
            case Config("API_LIST_ACTION"):
                return "InvestorVerifyList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "investorverifylist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("investorverifyview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("investorverifyview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "investorverifyadd?" . $this->getUrlParm($parm);
        } else {
            $url = "investorverifyadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("investorverifyedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("investorverifyadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("investorverifydelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "investor" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"juzcalculator_id\":" . JsonEncode($this->juzcalculator_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->juzcalculator_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->juzcalculator_id->CurrentValue);
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
            if (($keyValue = Param("juzcalculator_id") ?? Route("juzcalculator_id")) !== null) {
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
                $this->juzcalculator_id->CurrentValue = $key;
            } else {
                $this->juzcalculator_id->OldValue = $key;
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
        $this->juzcalculator_id->setDbValue($row['juzcalculator_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->firstname->setDbValue($row['firstname']);
        $this->lastname->setDbValue($row['lastname']);
        $this->phone->setDbValue($row['phone']);
        $this->_email->setDbValue($row['email']);
        $this->status->setDbValue($row['status']);
        $this->income_all->setDbValue($row['income_all']);
        $this->outcome_all->setDbValue($row['outcome_all']);
        $this->investment->setDbValue($row['investment']);
        $this->credit_limit->setDbValue($row['credit_limit']);
        $this->monthly_payments->setDbValue($row['monthly_payments']);
        $this->highest_rental_price->setDbValue($row['highest_rental_price']);
        $this->transfer->setDbValue($row['transfer']);
        $this->total_invertor_year->setDbValue($row['total_invertor_year']);
        $this->invert_payoff_day->setDbValue($row['invert_payoff_day']);
        $this->type_invertor->setDbValue($row['type_invertor']);
        $this->invest_amount->setDbValue($row['invest_amount']);
        $this->rent_price->setDbValue($row['rent_price']);
        $this->asset_price->setDbValue($row['asset_price']);
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

        // juzcalculator_id
        $this->juzcalculator_id->CellCssStyle = "white-space: nowrap;";

        // member_id
        $this->member_id->CellCssStyle = "white-space: nowrap;";

        // firstname
        $this->firstname->CellCssStyle = "white-space: nowrap;";

        // lastname
        $this->lastname->CellCssStyle = "white-space: nowrap;";

        // phone
        $this->phone->CellCssStyle = "white-space: nowrap;";

        // email
        $this->_email->CellCssStyle = "white-space: nowrap;";

        // status
        $this->status->CellCssStyle = "white-space: nowrap;";

        // income_all
        $this->income_all->CellCssStyle = "white-space: nowrap;";

        // outcome_all
        $this->outcome_all->CellCssStyle = "white-space: nowrap;";

        // investment
        $this->investment->CellCssStyle = "white-space: nowrap;";

        // credit_limit
        $this->credit_limit->CellCssStyle = "white-space: nowrap;";

        // monthly_payments
        $this->monthly_payments->CellCssStyle = "white-space: nowrap;";

        // highest_rental_price
        $this->highest_rental_price->CellCssStyle = "white-space: nowrap;";

        // transfer
        $this->transfer->CellCssStyle = "white-space: nowrap;";

        // total_invertor_year
        $this->total_invertor_year->CellCssStyle = "white-space: nowrap;";

        // invert_payoff_day
        $this->invert_payoff_day->CellCssStyle = "white-space: nowrap;";

        // type_invertor
        $this->type_invertor->CellCssStyle = "white-space: nowrap;";

        // invest_amount
        $this->invest_amount->CellCssStyle = "white-space: nowrap;";

        // rent_price
        $this->rent_price->CellCssStyle = "white-space: nowrap;";

        // asset_price
        $this->asset_price->CellCssStyle = "white-space: nowrap;";

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // juzcalculator_id
        $this->juzcalculator_id->ViewValue = $this->juzcalculator_id->CurrentValue;
        $this->juzcalculator_id->ViewCustomAttributes = "";

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

        // firstname
        $this->firstname->ViewValue = $this->firstname->CurrentValue;
        $this->firstname->ViewCustomAttributes = "";

        // lastname
        $this->lastname->ViewValue = $this->lastname->CurrentValue;
        $this->lastname->ViewCustomAttributes = "";

        // phone
        $this->phone->ViewValue = $this->phone->CurrentValue;
        $this->phone->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // income_all
        $this->income_all->ViewValue = $this->income_all->CurrentValue;
        $this->income_all->ViewValue = FormatNumber($this->income_all->ViewValue, $this->income_all->formatPattern());
        $this->income_all->ViewCustomAttributes = "";

        // outcome_all
        $this->outcome_all->ViewValue = $this->outcome_all->CurrentValue;
        $this->outcome_all->ViewValue = FormatNumber($this->outcome_all->ViewValue, $this->outcome_all->formatPattern());
        $this->outcome_all->ViewCustomAttributes = "";

        // investment
        $this->investment->ViewValue = $this->investment->CurrentValue;
        $this->investment->ViewValue = FormatNumber($this->investment->ViewValue, $this->investment->formatPattern());
        $this->investment->ViewCustomAttributes = "";

        // credit_limit
        $this->credit_limit->ViewValue = $this->credit_limit->CurrentValue;
        $this->credit_limit->ViewValue = FormatNumber($this->credit_limit->ViewValue, $this->credit_limit->formatPattern());
        $this->credit_limit->ViewCustomAttributes = "";

        // monthly_payments
        $this->monthly_payments->ViewValue = $this->monthly_payments->CurrentValue;
        $this->monthly_payments->ViewValue = FormatNumber($this->monthly_payments->ViewValue, $this->monthly_payments->formatPattern());
        $this->monthly_payments->ViewCustomAttributes = "";

        // highest_rental_price
        $this->highest_rental_price->ViewValue = $this->highest_rental_price->CurrentValue;
        $this->highest_rental_price->ViewValue = FormatNumber($this->highest_rental_price->ViewValue, $this->highest_rental_price->formatPattern());
        $this->highest_rental_price->ViewCustomAttributes = "";

        // transfer
        if (strval($this->transfer->CurrentValue) != "") {
            $this->transfer->ViewValue = $this->transfer->optionCaption($this->transfer->CurrentValue);
        } else {
            $this->transfer->ViewValue = null;
        }
        $this->transfer->ViewCustomAttributes = "";

        // total_invertor_year
        $this->total_invertor_year->ViewValue = $this->total_invertor_year->CurrentValue;
        $this->total_invertor_year->ViewValue = FormatNumber($this->total_invertor_year->ViewValue, $this->total_invertor_year->formatPattern());
        $this->total_invertor_year->ViewCustomAttributes = "";

        // invert_payoff_day
        $this->invert_payoff_day->ViewValue = $this->invert_payoff_day->CurrentValue;
        $this->invert_payoff_day->ViewValue = FormatNumber($this->invert_payoff_day->ViewValue, $this->invert_payoff_day->formatPattern());
        $this->invert_payoff_day->ViewCustomAttributes = "";

        // type_invertor
        if (strval($this->type_invertor->CurrentValue) != "") {
            $this->type_invertor->ViewValue = $this->type_invertor->optionCaption($this->type_invertor->CurrentValue);
        } else {
            $this->type_invertor->ViewValue = null;
        }
        $this->type_invertor->ViewCustomAttributes = "";

        // invest_amount
        $this->invest_amount->ViewValue = $this->invest_amount->CurrentValue;
        $this->invest_amount->ViewValue = FormatNumber($this->invest_amount->ViewValue, $this->invest_amount->formatPattern());
        $this->invest_amount->ViewCustomAttributes = "";

        // rent_price
        $this->rent_price->ViewValue = $this->rent_price->CurrentValue;
        $this->rent_price->ViewValue = FormatNumber($this->rent_price->ViewValue, $this->rent_price->formatPattern());
        $this->rent_price->ViewCustomAttributes = "";

        // asset_price
        $this->asset_price->ViewValue = $this->asset_price->CurrentValue;
        $this->asset_price->ViewValue = FormatNumber($this->asset_price->ViewValue, $this->asset_price->formatPattern());
        $this->asset_price->ViewCustomAttributes = "";

        // cdate
        $this->cdate->ViewValue = $this->cdate->CurrentValue;
        $this->cdate->ViewCustomAttributes = "";

        // cuser
        $this->cuser->ViewValue = $this->cuser->CurrentValue;
        $this->cuser->ViewCustomAttributes = "";

        // cip
        $this->cip->ViewValue = $this->cip->CurrentValue;
        $this->cip->ViewCustomAttributes = "";

        // udate
        $this->udate->ViewValue = $this->udate->CurrentValue;
        $this->udate->ViewCustomAttributes = "";

        // uuser
        $this->uuser->ViewValue = $this->uuser->CurrentValue;
        $this->uuser->ViewCustomAttributes = "";

        // uip
        $this->uip->ViewValue = $this->uip->CurrentValue;
        $this->uip->ViewCustomAttributes = "";

        // juzcalculator_id
        $this->juzcalculator_id->LinkCustomAttributes = "";
        $this->juzcalculator_id->HrefValue = "";
        $this->juzcalculator_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // firstname
        $this->firstname->LinkCustomAttributes = "";
        $this->firstname->HrefValue = "";
        $this->firstname->TooltipValue = "";

        // lastname
        $this->lastname->LinkCustomAttributes = "";
        $this->lastname->HrefValue = "";
        $this->lastname->TooltipValue = "";

        // phone
        $this->phone->LinkCustomAttributes = "";
        $this->phone->HrefValue = "";
        $this->phone->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // income_all
        $this->income_all->LinkCustomAttributes = "";
        $this->income_all->HrefValue = "";
        $this->income_all->TooltipValue = "";

        // outcome_all
        $this->outcome_all->LinkCustomAttributes = "";
        $this->outcome_all->HrefValue = "";
        $this->outcome_all->TooltipValue = "";

        // investment
        $this->investment->LinkCustomAttributes = "";
        $this->investment->HrefValue = "";
        $this->investment->TooltipValue = "";

        // credit_limit
        $this->credit_limit->LinkCustomAttributes = "";
        $this->credit_limit->HrefValue = "";
        $this->credit_limit->TooltipValue = "";

        // monthly_payments
        $this->monthly_payments->LinkCustomAttributes = "";
        $this->monthly_payments->HrefValue = "";
        $this->monthly_payments->TooltipValue = "";

        // highest_rental_price
        $this->highest_rental_price->LinkCustomAttributes = "";
        $this->highest_rental_price->HrefValue = "";
        $this->highest_rental_price->TooltipValue = "";

        // transfer
        $this->transfer->LinkCustomAttributes = "";
        $this->transfer->HrefValue = "";
        $this->transfer->TooltipValue = "";

        // total_invertor_year
        $this->total_invertor_year->LinkCustomAttributes = "";
        $this->total_invertor_year->HrefValue = "";
        $this->total_invertor_year->TooltipValue = "";

        // invert_payoff_day
        $this->invert_payoff_day->LinkCustomAttributes = "";
        $this->invert_payoff_day->HrefValue = "";
        $this->invert_payoff_day->TooltipValue = "";

        // type_invertor
        $this->type_invertor->LinkCustomAttributes = "";
        $this->type_invertor->HrefValue = "";
        $this->type_invertor->TooltipValue = "";

        // invest_amount
        $this->invest_amount->LinkCustomAttributes = "";
        $this->invest_amount->HrefValue = "";
        $this->invest_amount->TooltipValue = "";

        // rent_price
        $this->rent_price->LinkCustomAttributes = "";
        $this->rent_price->HrefValue = "";
        $this->rent_price->TooltipValue = "";

        // asset_price
        $this->asset_price->LinkCustomAttributes = "";
        $this->asset_price->HrefValue = "";
        $this->asset_price->TooltipValue = "";

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

        // juzcalculator_id
        $this->juzcalculator_id->setupEditAttributes();
        $this->juzcalculator_id->EditCustomAttributes = "";
        $this->juzcalculator_id->EditValue = $this->juzcalculator_id->CurrentValue;
        $this->juzcalculator_id->ViewCustomAttributes = "";

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

        // firstname
        $this->firstname->setupEditAttributes();
        $this->firstname->EditCustomAttributes = "";
        if (!$this->firstname->Raw) {
            $this->firstname->CurrentValue = HtmlDecode($this->firstname->CurrentValue);
        }
        $this->firstname->EditValue = $this->firstname->CurrentValue;
        $this->firstname->PlaceHolder = RemoveHtml($this->firstname->caption());

        // lastname
        $this->lastname->setupEditAttributes();
        $this->lastname->EditCustomAttributes = "";
        if (!$this->lastname->Raw) {
            $this->lastname->CurrentValue = HtmlDecode($this->lastname->CurrentValue);
        }
        $this->lastname->EditValue = $this->lastname->CurrentValue;
        $this->lastname->PlaceHolder = RemoveHtml($this->lastname->caption());

        // phone
        $this->phone->setupEditAttributes();
        $this->phone->EditCustomAttributes = "";
        if (!$this->phone->Raw) {
            $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
        }
        $this->phone->EditValue = $this->phone->CurrentValue;
        $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

        // email
        $this->_email->setupEditAttributes();
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(true);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // income_all
        $this->income_all->setupEditAttributes();
        $this->income_all->EditCustomAttributes = "";
        $this->income_all->EditValue = $this->income_all->CurrentValue;
        $this->income_all->PlaceHolder = RemoveHtml($this->income_all->caption());
        if (strval($this->income_all->EditValue) != "" && is_numeric($this->income_all->EditValue)) {
            $this->income_all->EditValue = FormatNumber($this->income_all->EditValue, null);
        }

        // outcome_all
        $this->outcome_all->setupEditAttributes();
        $this->outcome_all->EditCustomAttributes = "";
        $this->outcome_all->EditValue = $this->outcome_all->CurrentValue;
        $this->outcome_all->PlaceHolder = RemoveHtml($this->outcome_all->caption());
        if (strval($this->outcome_all->EditValue) != "" && is_numeric($this->outcome_all->EditValue)) {
            $this->outcome_all->EditValue = FormatNumber($this->outcome_all->EditValue, null);
        }

        // investment
        $this->investment->setupEditAttributes();
        $this->investment->EditCustomAttributes = "";
        $this->investment->EditValue = $this->investment->CurrentValue;
        $this->investment->PlaceHolder = RemoveHtml($this->investment->caption());
        if (strval($this->investment->EditValue) != "" && is_numeric($this->investment->EditValue)) {
            $this->investment->EditValue = FormatNumber($this->investment->EditValue, null);
        }

        // credit_limit
        $this->credit_limit->setupEditAttributes();
        $this->credit_limit->EditCustomAttributes = "";
        $this->credit_limit->EditValue = $this->credit_limit->CurrentValue;
        $this->credit_limit->PlaceHolder = RemoveHtml($this->credit_limit->caption());
        if (strval($this->credit_limit->EditValue) != "" && is_numeric($this->credit_limit->EditValue)) {
            $this->credit_limit->EditValue = FormatNumber($this->credit_limit->EditValue, null);
        }

        // monthly_payments
        $this->monthly_payments->setupEditAttributes();
        $this->monthly_payments->EditCustomAttributes = "";
        $this->monthly_payments->EditValue = $this->monthly_payments->CurrentValue;
        $this->monthly_payments->PlaceHolder = RemoveHtml($this->monthly_payments->caption());
        if (strval($this->monthly_payments->EditValue) != "" && is_numeric($this->monthly_payments->EditValue)) {
            $this->monthly_payments->EditValue = FormatNumber($this->monthly_payments->EditValue, null);
        }

        // highest_rental_price
        $this->highest_rental_price->setupEditAttributes();
        $this->highest_rental_price->EditCustomAttributes = "";
        $this->highest_rental_price->EditValue = $this->highest_rental_price->CurrentValue;
        $this->highest_rental_price->PlaceHolder = RemoveHtml($this->highest_rental_price->caption());
        if (strval($this->highest_rental_price->EditValue) != "" && is_numeric($this->highest_rental_price->EditValue)) {
            $this->highest_rental_price->EditValue = FormatNumber($this->highest_rental_price->EditValue, null);
        }

        // transfer
        $this->transfer->EditCustomAttributes = "";
        $this->transfer->EditValue = $this->transfer->options(false);
        $this->transfer->PlaceHolder = RemoveHtml($this->transfer->caption());

        // total_invertor_year
        $this->total_invertor_year->setupEditAttributes();
        $this->total_invertor_year->EditCustomAttributes = "";
        $this->total_invertor_year->EditValue = $this->total_invertor_year->CurrentValue;
        $this->total_invertor_year->PlaceHolder = RemoveHtml($this->total_invertor_year->caption());
        if (strval($this->total_invertor_year->EditValue) != "" && is_numeric($this->total_invertor_year->EditValue)) {
            $this->total_invertor_year->EditValue = FormatNumber($this->total_invertor_year->EditValue, null);
        }

        // invert_payoff_day
        $this->invert_payoff_day->setupEditAttributes();
        $this->invert_payoff_day->EditCustomAttributes = "";
        $this->invert_payoff_day->EditValue = $this->invert_payoff_day->CurrentValue;
        $this->invert_payoff_day->PlaceHolder = RemoveHtml($this->invert_payoff_day->caption());
        if (strval($this->invert_payoff_day->EditValue) != "" && is_numeric($this->invert_payoff_day->EditValue)) {
            $this->invert_payoff_day->EditValue = FormatNumber($this->invert_payoff_day->EditValue, null);
        }

        // type_invertor
        $this->type_invertor->setupEditAttributes();
        $this->type_invertor->EditCustomAttributes = "";
        $this->type_invertor->EditValue = $this->type_invertor->options(true);
        $this->type_invertor->PlaceHolder = RemoveHtml($this->type_invertor->caption());

        // invest_amount
        $this->invest_amount->setupEditAttributes();
        $this->invest_amount->EditCustomAttributes = "";
        $this->invest_amount->EditValue = $this->invest_amount->CurrentValue;
        $this->invest_amount->PlaceHolder = RemoveHtml($this->invest_amount->caption());
        if (strval($this->invest_amount->EditValue) != "" && is_numeric($this->invest_amount->EditValue)) {
            $this->invest_amount->EditValue = FormatNumber($this->invest_amount->EditValue, null);
        }

        // rent_price
        $this->rent_price->setupEditAttributes();
        $this->rent_price->EditCustomAttributes = "";
        $this->rent_price->EditValue = $this->rent_price->CurrentValue;
        $this->rent_price->PlaceHolder = RemoveHtml($this->rent_price->caption());
        if (strval($this->rent_price->EditValue) != "" && is_numeric($this->rent_price->EditValue)) {
            $this->rent_price->EditValue = FormatNumber($this->rent_price->EditValue, null);
        }

        // asset_price
        $this->asset_price->setupEditAttributes();
        $this->asset_price->EditCustomAttributes = "";
        $this->asset_price->EditValue = $this->asset_price->CurrentValue;
        $this->asset_price->PlaceHolder = RemoveHtml($this->asset_price->caption());
        if (strval($this->asset_price->EditValue) != "" && is_numeric($this->asset_price->EditValue)) {
            $this->asset_price->EditValue = FormatNumber($this->asset_price->EditValue, null);
        }

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
                    $doc->exportCaption($this->investment);
                    $doc->exportCaption($this->credit_limit);
                    $doc->exportCaption($this->monthly_payments);
                    $doc->exportCaption($this->highest_rental_price);
                    $doc->exportCaption($this->transfer);
                    $doc->exportCaption($this->total_invertor_year);
                    $doc->exportCaption($this->invert_payoff_day);
                    $doc->exportCaption($this->type_invertor);
                    $doc->exportCaption($this->invest_amount);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                } else {
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
                        $doc->exportField($this->investment);
                        $doc->exportField($this->credit_limit);
                        $doc->exportField($this->monthly_payments);
                        $doc->exportField($this->highest_rental_price);
                        $doc->exportField($this->transfer);
                        $doc->exportField($this->total_invertor_year);
                        $doc->exportField($this->invert_payoff_day);
                        $doc->exportField($this->type_invertor);
                        $doc->exportField($this->invest_amount);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                    } else {
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
