<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for peak_expense
 */
class PeakExpense extends DbTable
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
    public $peak_expense_id;
    public $id;
    public $code;
    public $issuedDate;
    public $dueDate;
    public $contactId;
    public $contactCode;
    public $status;
    public $isTaxInvoice;
    public $preTaxAmount;
    public $vatAmount;
    public $netAmount;
    public $whtAmount;
    public $paymentAmount;
    public $remainAmount;
    public $onlineViewLink;
    public $taxStatus;
    public $paymentDate;
    public $withHoldingTaxAmount;
    public $paymentGroupId;
    public $paymentTotal;
    public $paymentMethodId;
    public $paymentMethodCode;
    public $amount;
    public $journals_id;
    public $journals_code;
    public $cdate;
    public $cuser;
    public $cip;
    public $udate;
    public $uuser;
    public $uip;
    public $sync_detail_date;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'peak_expense';
        $this->TableName = 'peak_expense';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`peak_expense`";
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

        // peak_expense_id
        $this->peak_expense_id = new DbField(
            'peak_expense',
            'peak_expense',
            'x_peak_expense_id',
            'peak_expense_id',
            '`peak_expense_id`',
            '`peak_expense_id`',
            3,
            11,
            -1,
            false,
            '`peak_expense_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->peak_expense_id->InputTextType = "text";
        $this->peak_expense_id->IsAutoIncrement = true; // Autoincrement field
        $this->peak_expense_id->IsPrimaryKey = true; // Primary key field
        $this->peak_expense_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['peak_expense_id'] = &$this->peak_expense_id;

        // id
        $this->id = new DbField(
            'peak_expense',
            'peak_expense',
            'x_id',
            'id',
            '`id`',
            '`id`',
            200,
            250,
            -1,
            false,
            '`id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->id->InputTextType = "text";
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Required = true; // Required field
        $this->Fields['id'] = &$this->id;

        // code
        $this->code = new DbField(
            'peak_expense',
            'peak_expense',
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
        $this->code->Nullable = false; // NOT NULL field
        $this->code->Required = true; // Required field
        $this->Fields['code'] = &$this->code;

        // issuedDate
        $this->issuedDate = new DbField(
            'peak_expense',
            'peak_expense',
            'x_issuedDate',
            'issuedDate',
            '`issuedDate`',
            CastDateFieldForLike("`issuedDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`issuedDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->issuedDate->InputTextType = "text";
        $this->issuedDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['issuedDate'] = &$this->issuedDate;

        // dueDate
        $this->dueDate = new DbField(
            'peak_expense',
            'peak_expense',
            'x_dueDate',
            'dueDate',
            '`dueDate`',
            CastDateFieldForLike("`dueDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dueDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dueDate->InputTextType = "text";
        $this->dueDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dueDate'] = &$this->dueDate;

        // contactId
        $this->contactId = new DbField(
            'peak_expense',
            'peak_expense',
            'x_contactId',
            'contactId',
            '`contactId`',
            '`contactId`',
            200,
            250,
            -1,
            false,
            '`contactId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contactId->InputTextType = "text";
        $this->Fields['contactId'] = &$this->contactId;

        // contactCode
        $this->contactCode = new DbField(
            'peak_expense',
            'peak_expense',
            'x_contactCode',
            'contactCode',
            '`contactCode`',
            '`contactCode`',
            200,
            250,
            -1,
            false,
            '`contactCode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contactCode->InputTextType = "text";
        $this->Fields['contactCode'] = &$this->contactCode;

        // status
        $this->status = new DbField(
            'peak_expense',
            'peak_expense',
            'x_status',
            'status',
            '`status`',
            '`status`',
            200,
            250,
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
        $this->Fields['status'] = &$this->status;

        // isTaxInvoice
        $this->isTaxInvoice = new DbField(
            'peak_expense',
            'peak_expense',
            'x_isTaxInvoice',
            'isTaxInvoice',
            '`isTaxInvoice`',
            '`isTaxInvoice`',
            3,
            11,
            -1,
            false,
            '`isTaxInvoice`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->isTaxInvoice->InputTextType = "text";
        $this->isTaxInvoice->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isTaxInvoice'] = &$this->isTaxInvoice;

        // preTaxAmount
        $this->preTaxAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_preTaxAmount',
            'preTaxAmount',
            '`preTaxAmount`',
            '`preTaxAmount`',
            5,
            22,
            -1,
            false,
            '`preTaxAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->preTaxAmount->InputTextType = "text";
        $this->preTaxAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['preTaxAmount'] = &$this->preTaxAmount;

        // vatAmount
        $this->vatAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_vatAmount',
            'vatAmount',
            '`vatAmount`',
            '`vatAmount`',
            5,
            22,
            -1,
            false,
            '`vatAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->vatAmount->InputTextType = "text";
        $this->vatAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['vatAmount'] = &$this->vatAmount;

        // netAmount
        $this->netAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_netAmount',
            'netAmount',
            '`netAmount`',
            '`netAmount`',
            5,
            22,
            -1,
            false,
            '`netAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->netAmount->InputTextType = "text";
        $this->netAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['netAmount'] = &$this->netAmount;

        // whtAmount
        $this->whtAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_whtAmount',
            'whtAmount',
            '`whtAmount`',
            '`whtAmount`',
            5,
            22,
            -1,
            false,
            '`whtAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->whtAmount->InputTextType = "text";
        $this->whtAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['whtAmount'] = &$this->whtAmount;

        // paymentAmount
        $this->paymentAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_paymentAmount',
            'paymentAmount',
            '`paymentAmount`',
            '`paymentAmount`',
            5,
            22,
            -1,
            false,
            '`paymentAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentAmount->InputTextType = "text";
        $this->paymentAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['paymentAmount'] = &$this->paymentAmount;

        // remainAmount
        $this->remainAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_remainAmount',
            'remainAmount',
            '`remainAmount`',
            '`remainAmount`',
            5,
            22,
            -1,
            false,
            '`remainAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remainAmount->InputTextType = "text";
        $this->remainAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remainAmount'] = &$this->remainAmount;

        // onlineViewLink
        $this->onlineViewLink = new DbField(
            'peak_expense',
            'peak_expense',
            'x_onlineViewLink',
            'onlineViewLink',
            '`onlineViewLink`',
            '`onlineViewLink`',
            201,
            500,
            -1,
            false,
            '`onlineViewLink`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->onlineViewLink->InputTextType = "text";
        $this->Fields['onlineViewLink'] = &$this->onlineViewLink;

        // taxStatus
        $this->taxStatus = new DbField(
            'peak_expense',
            'peak_expense',
            'x_taxStatus',
            'taxStatus',
            '`taxStatus`',
            '`taxStatus`',
            3,
            11,
            -1,
            false,
            '`taxStatus`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->taxStatus->InputTextType = "text";
        $this->taxStatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['taxStatus'] = &$this->taxStatus;

        // paymentDate
        $this->paymentDate = new DbField(
            'peak_expense',
            'peak_expense',
            'x_paymentDate',
            'paymentDate',
            '`paymentDate`',
            CastDateFieldForLike("`paymentDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`paymentDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentDate->InputTextType = "text";
        $this->paymentDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['paymentDate'] = &$this->paymentDate;

        // withHoldingTaxAmount
        $this->withHoldingTaxAmount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_withHoldingTaxAmount',
            'withHoldingTaxAmount',
            '`withHoldingTaxAmount`',
            '`withHoldingTaxAmount`',
            200,
            250,
            -1,
            false,
            '`withHoldingTaxAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->withHoldingTaxAmount->InputTextType = "text";
        $this->Fields['withHoldingTaxAmount'] = &$this->withHoldingTaxAmount;

        // paymentGroupId
        $this->paymentGroupId = new DbField(
            'peak_expense',
            'peak_expense',
            'x_paymentGroupId',
            'paymentGroupId',
            '`paymentGroupId`',
            '`paymentGroupId`',
            3,
            11,
            -1,
            false,
            '`paymentGroupId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentGroupId->InputTextType = "text";
        $this->paymentGroupId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['paymentGroupId'] = &$this->paymentGroupId;

        // paymentTotal
        $this->paymentTotal = new DbField(
            'peak_expense',
            'peak_expense',
            'x_paymentTotal',
            'paymentTotal',
            '`paymentTotal`',
            '`paymentTotal`',
            5,
            22,
            -1,
            false,
            '`paymentTotal`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentTotal->InputTextType = "text";
        $this->paymentTotal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['paymentTotal'] = &$this->paymentTotal;

        // paymentMethodId
        $this->paymentMethodId = new DbField(
            'peak_expense',
            'peak_expense',
            'x_paymentMethodId',
            'paymentMethodId',
            '`paymentMethodId`',
            '`paymentMethodId`',
            200,
            250,
            -1,
            false,
            '`paymentMethodId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentMethodId->InputTextType = "text";
        $this->Fields['paymentMethodId'] = &$this->paymentMethodId;

        // paymentMethodCode
        $this->paymentMethodCode = new DbField(
            'peak_expense',
            'peak_expense',
            'x_paymentMethodCode',
            'paymentMethodCode',
            '`paymentMethodCode`',
            '`paymentMethodCode`',
            200,
            250,
            -1,
            false,
            '`paymentMethodCode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentMethodCode->InputTextType = "text";
        $this->Fields['paymentMethodCode'] = &$this->paymentMethodCode;

        // amount
        $this->amount = new DbField(
            'peak_expense',
            'peak_expense',
            'x_amount',
            'amount',
            '`amount`',
            '`amount`',
            5,
            22,
            -1,
            false,
            '`amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->amount->InputTextType = "text";
        $this->amount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['amount'] = &$this->amount;

        // journals_id
        $this->journals_id = new DbField(
            'peak_expense',
            'peak_expense',
            'x_journals_id',
            'journals_id',
            '`journals_id`',
            '`journals_id`',
            200,
            250,
            -1,
            false,
            '`journals_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->journals_id->InputTextType = "text";
        $this->Fields['journals_id'] = &$this->journals_id;

        // journals_code
        $this->journals_code = new DbField(
            'peak_expense',
            'peak_expense',
            'x_journals_code',
            'journals_code',
            '`journals_code`',
            '`journals_code`',
            200,
            250,
            -1,
            false,
            '`journals_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->journals_code->InputTextType = "text";
        $this->Fields['journals_code'] = &$this->journals_code;

        // cdate
        $this->cdate = new DbField(
            'peak_expense',
            'peak_expense',
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
            'peak_expense',
            'peak_expense',
            'x_cuser',
            'cuser',
            '`cuser`',
            '`cuser`',
            200,
            250,
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
            'peak_expense',
            'peak_expense',
            'x_cip',
            'cip',
            '`cip`',
            '`cip`',
            200,
            250,
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
            'peak_expense',
            'peak_expense',
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
            'peak_expense',
            'peak_expense',
            'x_uuser',
            'uuser',
            '`uuser`',
            '`uuser`',
            200,
            250,
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
            'peak_expense',
            'peak_expense',
            'x_uip',
            'uip',
            '`uip`',
            '`uip`',
            200,
            250,
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

        // sync_detail_date
        $this->sync_detail_date = new DbField(
            'peak_expense',
            'peak_expense',
            'x_sync_detail_date',
            'sync_detail_date',
            '`sync_detail_date`',
            CastDateFieldForLike("`sync_detail_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`sync_detail_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->sync_detail_date->InputTextType = "text";
        $this->sync_detail_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['sync_detail_date'] = &$this->sync_detail_date;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`peak_expense`";
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
            $this->peak_expense_id->setDbValue($conn->lastInsertId());
            $rs['peak_expense_id'] = $this->peak_expense_id->DbValue;
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
            if (array_key_exists('peak_expense_id', $rs)) {
                AddFilter($where, QuotedName('peak_expense_id', $this->Dbid) . '=' . QuotedValue($rs['peak_expense_id'], $this->peak_expense_id->DataType, $this->Dbid));
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
        $this->peak_expense_id->DbValue = $row['peak_expense_id'];
        $this->id->DbValue = $row['id'];
        $this->code->DbValue = $row['code'];
        $this->issuedDate->DbValue = $row['issuedDate'];
        $this->dueDate->DbValue = $row['dueDate'];
        $this->contactId->DbValue = $row['contactId'];
        $this->contactCode->DbValue = $row['contactCode'];
        $this->status->DbValue = $row['status'];
        $this->isTaxInvoice->DbValue = $row['isTaxInvoice'];
        $this->preTaxAmount->DbValue = $row['preTaxAmount'];
        $this->vatAmount->DbValue = $row['vatAmount'];
        $this->netAmount->DbValue = $row['netAmount'];
        $this->whtAmount->DbValue = $row['whtAmount'];
        $this->paymentAmount->DbValue = $row['paymentAmount'];
        $this->remainAmount->DbValue = $row['remainAmount'];
        $this->onlineViewLink->DbValue = $row['onlineViewLink'];
        $this->taxStatus->DbValue = $row['taxStatus'];
        $this->paymentDate->DbValue = $row['paymentDate'];
        $this->withHoldingTaxAmount->DbValue = $row['withHoldingTaxAmount'];
        $this->paymentGroupId->DbValue = $row['paymentGroupId'];
        $this->paymentTotal->DbValue = $row['paymentTotal'];
        $this->paymentMethodId->DbValue = $row['paymentMethodId'];
        $this->paymentMethodCode->DbValue = $row['paymentMethodCode'];
        $this->amount->DbValue = $row['amount'];
        $this->journals_id->DbValue = $row['journals_id'];
        $this->journals_code->DbValue = $row['journals_code'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->udate->DbValue = $row['udate'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->sync_detail_date->DbValue = $row['sync_detail_date'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`peak_expense_id` = @peak_expense_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->peak_expense_id->CurrentValue : $this->peak_expense_id->OldValue;
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
                $this->peak_expense_id->CurrentValue = $keys[0];
            } else {
                $this->peak_expense_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('peak_expense_id', $row) ? $row['peak_expense_id'] : null;
        } else {
            $val = $this->peak_expense_id->OldValue !== null ? $this->peak_expense_id->OldValue : $this->peak_expense_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@peak_expense_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("peakexpenselist");
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
        if ($pageName == "peakexpenseview") {
            return $Language->phrase("View");
        } elseif ($pageName == "peakexpenseedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "peakexpenseadd") {
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
                return "PeakExpenseView";
            case Config("API_ADD_ACTION"):
                return "PeakExpenseAdd";
            case Config("API_EDIT_ACTION"):
                return "PeakExpenseEdit";
            case Config("API_DELETE_ACTION"):
                return "PeakExpenseDelete";
            case Config("API_LIST_ACTION"):
                return "PeakExpenseList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "peakexpenselist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("peakexpenseview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("peakexpenseview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "peakexpenseadd?" . $this->getUrlParm($parm);
        } else {
            $url = "peakexpenseadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("peakexpenseedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("peakexpenseadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("peakexpensedelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"peak_expense_id\":" . JsonEncode($this->peak_expense_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->peak_expense_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->peak_expense_id->CurrentValue);
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
            if (($keyValue = Param("peak_expense_id") ?? Route("peak_expense_id")) !== null) {
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
                $this->peak_expense_id->CurrentValue = $key;
            } else {
                $this->peak_expense_id->OldValue = $key;
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
        $this->peak_expense_id->setDbValue($row['peak_expense_id']);
        $this->id->setDbValue($row['id']);
        $this->code->setDbValue($row['code']);
        $this->issuedDate->setDbValue($row['issuedDate']);
        $this->dueDate->setDbValue($row['dueDate']);
        $this->contactId->setDbValue($row['contactId']);
        $this->contactCode->setDbValue($row['contactCode']);
        $this->status->setDbValue($row['status']);
        $this->isTaxInvoice->setDbValue($row['isTaxInvoice']);
        $this->preTaxAmount->setDbValue($row['preTaxAmount']);
        $this->vatAmount->setDbValue($row['vatAmount']);
        $this->netAmount->setDbValue($row['netAmount']);
        $this->whtAmount->setDbValue($row['whtAmount']);
        $this->paymentAmount->setDbValue($row['paymentAmount']);
        $this->remainAmount->setDbValue($row['remainAmount']);
        $this->onlineViewLink->setDbValue($row['onlineViewLink']);
        $this->taxStatus->setDbValue($row['taxStatus']);
        $this->paymentDate->setDbValue($row['paymentDate']);
        $this->withHoldingTaxAmount->setDbValue($row['withHoldingTaxAmount']);
        $this->paymentGroupId->setDbValue($row['paymentGroupId']);
        $this->paymentTotal->setDbValue($row['paymentTotal']);
        $this->paymentMethodId->setDbValue($row['paymentMethodId']);
        $this->paymentMethodCode->setDbValue($row['paymentMethodCode']);
        $this->amount->setDbValue($row['amount']);
        $this->journals_id->setDbValue($row['journals_id']);
        $this->journals_code->setDbValue($row['journals_code']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->sync_detail_date->setDbValue($row['sync_detail_date']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // peak_expense_id

        // id

        // code

        // issuedDate

        // dueDate

        // contactId

        // contactCode

        // status

        // isTaxInvoice

        // preTaxAmount

        // vatAmount

        // netAmount

        // whtAmount

        // paymentAmount

        // remainAmount

        // onlineViewLink

        // taxStatus

        // paymentDate

        // withHoldingTaxAmount

        // paymentGroupId

        // paymentTotal

        // paymentMethodId

        // paymentMethodCode

        // amount

        // journals_id

        // journals_code

        // cdate

        // cuser

        // cip

        // udate

        // uuser

        // uip

        // sync_detail_date

        // peak_expense_id
        $this->peak_expense_id->ViewValue = $this->peak_expense_id->CurrentValue;
        $this->peak_expense_id->ViewCustomAttributes = "";

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // code
        $this->code->ViewValue = $this->code->CurrentValue;
        $this->code->ViewCustomAttributes = "";

        // issuedDate
        $this->issuedDate->ViewValue = $this->issuedDate->CurrentValue;
        $this->issuedDate->ViewValue = FormatDateTime($this->issuedDate->ViewValue, $this->issuedDate->formatPattern());
        $this->issuedDate->ViewCustomAttributes = "";

        // dueDate
        $this->dueDate->ViewValue = $this->dueDate->CurrentValue;
        $this->dueDate->ViewValue = FormatDateTime($this->dueDate->ViewValue, $this->dueDate->formatPattern());
        $this->dueDate->ViewCustomAttributes = "";

        // contactId
        $this->contactId->ViewValue = $this->contactId->CurrentValue;
        $this->contactId->ViewCustomAttributes = "";

        // contactCode
        $this->contactCode->ViewValue = $this->contactCode->CurrentValue;
        $this->contactCode->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // isTaxInvoice
        $this->isTaxInvoice->ViewValue = $this->isTaxInvoice->CurrentValue;
        $this->isTaxInvoice->ViewValue = FormatNumber($this->isTaxInvoice->ViewValue, $this->isTaxInvoice->formatPattern());
        $this->isTaxInvoice->ViewCustomAttributes = "";

        // preTaxAmount
        $this->preTaxAmount->ViewValue = $this->preTaxAmount->CurrentValue;
        $this->preTaxAmount->ViewValue = FormatNumber($this->preTaxAmount->ViewValue, $this->preTaxAmount->formatPattern());
        $this->preTaxAmount->ViewCustomAttributes = "";

        // vatAmount
        $this->vatAmount->ViewValue = $this->vatAmount->CurrentValue;
        $this->vatAmount->ViewValue = FormatNumber($this->vatAmount->ViewValue, $this->vatAmount->formatPattern());
        $this->vatAmount->ViewCustomAttributes = "";

        // netAmount
        $this->netAmount->ViewValue = $this->netAmount->CurrentValue;
        $this->netAmount->ViewValue = FormatNumber($this->netAmount->ViewValue, $this->netAmount->formatPattern());
        $this->netAmount->ViewCustomAttributes = "";

        // whtAmount
        $this->whtAmount->ViewValue = $this->whtAmount->CurrentValue;
        $this->whtAmount->ViewValue = FormatNumber($this->whtAmount->ViewValue, $this->whtAmount->formatPattern());
        $this->whtAmount->ViewCustomAttributes = "";

        // paymentAmount
        $this->paymentAmount->ViewValue = $this->paymentAmount->CurrentValue;
        $this->paymentAmount->ViewValue = FormatNumber($this->paymentAmount->ViewValue, $this->paymentAmount->formatPattern());
        $this->paymentAmount->ViewCustomAttributes = "";

        // remainAmount
        $this->remainAmount->ViewValue = $this->remainAmount->CurrentValue;
        $this->remainAmount->ViewValue = FormatNumber($this->remainAmount->ViewValue, $this->remainAmount->formatPattern());
        $this->remainAmount->ViewCustomAttributes = "";

        // onlineViewLink
        $this->onlineViewLink->ViewValue = $this->onlineViewLink->CurrentValue;
        $this->onlineViewLink->ViewCustomAttributes = "";

        // taxStatus
        $this->taxStatus->ViewValue = $this->taxStatus->CurrentValue;
        $this->taxStatus->ViewValue = FormatNumber($this->taxStatus->ViewValue, $this->taxStatus->formatPattern());
        $this->taxStatus->ViewCustomAttributes = "";

        // paymentDate
        $this->paymentDate->ViewValue = $this->paymentDate->CurrentValue;
        $this->paymentDate->ViewValue = FormatDateTime($this->paymentDate->ViewValue, $this->paymentDate->formatPattern());
        $this->paymentDate->ViewCustomAttributes = "";

        // withHoldingTaxAmount
        $this->withHoldingTaxAmount->ViewValue = $this->withHoldingTaxAmount->CurrentValue;
        $this->withHoldingTaxAmount->ViewCustomAttributes = "";

        // paymentGroupId
        $this->paymentGroupId->ViewValue = $this->paymentGroupId->CurrentValue;
        $this->paymentGroupId->ViewValue = FormatNumber($this->paymentGroupId->ViewValue, $this->paymentGroupId->formatPattern());
        $this->paymentGroupId->ViewCustomAttributes = "";

        // paymentTotal
        $this->paymentTotal->ViewValue = $this->paymentTotal->CurrentValue;
        $this->paymentTotal->ViewValue = FormatNumber($this->paymentTotal->ViewValue, $this->paymentTotal->formatPattern());
        $this->paymentTotal->ViewCustomAttributes = "";

        // paymentMethodId
        $this->paymentMethodId->ViewValue = $this->paymentMethodId->CurrentValue;
        $this->paymentMethodId->ViewCustomAttributes = "";

        // paymentMethodCode
        $this->paymentMethodCode->ViewValue = $this->paymentMethodCode->CurrentValue;
        $this->paymentMethodCode->ViewCustomAttributes = "";

        // amount
        $this->amount->ViewValue = $this->amount->CurrentValue;
        $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
        $this->amount->ViewCustomAttributes = "";

        // journals_id
        $this->journals_id->ViewValue = $this->journals_id->CurrentValue;
        $this->journals_id->ViewCustomAttributes = "";

        // journals_code
        $this->journals_code->ViewValue = $this->journals_code->CurrentValue;
        $this->journals_code->ViewCustomAttributes = "";

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

        // sync_detail_date
        $this->sync_detail_date->ViewValue = $this->sync_detail_date->CurrentValue;
        $this->sync_detail_date->ViewValue = FormatDateTime($this->sync_detail_date->ViewValue, $this->sync_detail_date->formatPattern());
        $this->sync_detail_date->ViewCustomAttributes = "";

        // peak_expense_id
        $this->peak_expense_id->LinkCustomAttributes = "";
        $this->peak_expense_id->HrefValue = "";
        $this->peak_expense_id->TooltipValue = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // code
        $this->code->LinkCustomAttributes = "";
        $this->code->HrefValue = "";
        $this->code->TooltipValue = "";

        // issuedDate
        $this->issuedDate->LinkCustomAttributes = "";
        $this->issuedDate->HrefValue = "";
        $this->issuedDate->TooltipValue = "";

        // dueDate
        $this->dueDate->LinkCustomAttributes = "";
        $this->dueDate->HrefValue = "";
        $this->dueDate->TooltipValue = "";

        // contactId
        $this->contactId->LinkCustomAttributes = "";
        $this->contactId->HrefValue = "";
        $this->contactId->TooltipValue = "";

        // contactCode
        $this->contactCode->LinkCustomAttributes = "";
        $this->contactCode->HrefValue = "";
        $this->contactCode->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // isTaxInvoice
        $this->isTaxInvoice->LinkCustomAttributes = "";
        $this->isTaxInvoice->HrefValue = "";
        $this->isTaxInvoice->TooltipValue = "";

        // preTaxAmount
        $this->preTaxAmount->LinkCustomAttributes = "";
        $this->preTaxAmount->HrefValue = "";
        $this->preTaxAmount->TooltipValue = "";

        // vatAmount
        $this->vatAmount->LinkCustomAttributes = "";
        $this->vatAmount->HrefValue = "";
        $this->vatAmount->TooltipValue = "";

        // netAmount
        $this->netAmount->LinkCustomAttributes = "";
        $this->netAmount->HrefValue = "";
        $this->netAmount->TooltipValue = "";

        // whtAmount
        $this->whtAmount->LinkCustomAttributes = "";
        $this->whtAmount->HrefValue = "";
        $this->whtAmount->TooltipValue = "";

        // paymentAmount
        $this->paymentAmount->LinkCustomAttributes = "";
        $this->paymentAmount->HrefValue = "";
        $this->paymentAmount->TooltipValue = "";

        // remainAmount
        $this->remainAmount->LinkCustomAttributes = "";
        $this->remainAmount->HrefValue = "";
        $this->remainAmount->TooltipValue = "";

        // onlineViewLink
        $this->onlineViewLink->LinkCustomAttributes = "";
        $this->onlineViewLink->HrefValue = "";
        $this->onlineViewLink->TooltipValue = "";

        // taxStatus
        $this->taxStatus->LinkCustomAttributes = "";
        $this->taxStatus->HrefValue = "";
        $this->taxStatus->TooltipValue = "";

        // paymentDate
        $this->paymentDate->LinkCustomAttributes = "";
        $this->paymentDate->HrefValue = "";
        $this->paymentDate->TooltipValue = "";

        // withHoldingTaxAmount
        $this->withHoldingTaxAmount->LinkCustomAttributes = "";
        $this->withHoldingTaxAmount->HrefValue = "";
        $this->withHoldingTaxAmount->TooltipValue = "";

        // paymentGroupId
        $this->paymentGroupId->LinkCustomAttributes = "";
        $this->paymentGroupId->HrefValue = "";
        $this->paymentGroupId->TooltipValue = "";

        // paymentTotal
        $this->paymentTotal->LinkCustomAttributes = "";
        $this->paymentTotal->HrefValue = "";
        $this->paymentTotal->TooltipValue = "";

        // paymentMethodId
        $this->paymentMethodId->LinkCustomAttributes = "";
        $this->paymentMethodId->HrefValue = "";
        $this->paymentMethodId->TooltipValue = "";

        // paymentMethodCode
        $this->paymentMethodCode->LinkCustomAttributes = "";
        $this->paymentMethodCode->HrefValue = "";
        $this->paymentMethodCode->TooltipValue = "";

        // amount
        $this->amount->LinkCustomAttributes = "";
        $this->amount->HrefValue = "";
        $this->amount->TooltipValue = "";

        // journals_id
        $this->journals_id->LinkCustomAttributes = "";
        $this->journals_id->HrefValue = "";
        $this->journals_id->TooltipValue = "";

        // journals_code
        $this->journals_code->LinkCustomAttributes = "";
        $this->journals_code->HrefValue = "";
        $this->journals_code->TooltipValue = "";

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

        // sync_detail_date
        $this->sync_detail_date->LinkCustomAttributes = "";
        $this->sync_detail_date->HrefValue = "";
        $this->sync_detail_date->TooltipValue = "";

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

        // peak_expense_id
        $this->peak_expense_id->setupEditAttributes();
        $this->peak_expense_id->EditCustomAttributes = "";
        $this->peak_expense_id->EditValue = $this->peak_expense_id->CurrentValue;
        $this->peak_expense_id->ViewCustomAttributes = "";

        // id
        $this->id->setupEditAttributes();
        $this->id->EditCustomAttributes = "";
        if (!$this->id->Raw) {
            $this->id->CurrentValue = HtmlDecode($this->id->CurrentValue);
        }
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->PlaceHolder = RemoveHtml($this->id->caption());

        // code
        $this->code->setupEditAttributes();
        $this->code->EditCustomAttributes = "";
        if (!$this->code->Raw) {
            $this->code->CurrentValue = HtmlDecode($this->code->CurrentValue);
        }
        $this->code->EditValue = $this->code->CurrentValue;
        $this->code->PlaceHolder = RemoveHtml($this->code->caption());

        // issuedDate
        $this->issuedDate->setupEditAttributes();
        $this->issuedDate->EditCustomAttributes = "";
        $this->issuedDate->EditValue = FormatDateTime($this->issuedDate->CurrentValue, $this->issuedDate->formatPattern());
        $this->issuedDate->PlaceHolder = RemoveHtml($this->issuedDate->caption());

        // dueDate
        $this->dueDate->setupEditAttributes();
        $this->dueDate->EditCustomAttributes = "";
        $this->dueDate->EditValue = FormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern());
        $this->dueDate->PlaceHolder = RemoveHtml($this->dueDate->caption());

        // contactId
        $this->contactId->setupEditAttributes();
        $this->contactId->EditCustomAttributes = "";
        if (!$this->contactId->Raw) {
            $this->contactId->CurrentValue = HtmlDecode($this->contactId->CurrentValue);
        }
        $this->contactId->EditValue = $this->contactId->CurrentValue;
        $this->contactId->PlaceHolder = RemoveHtml($this->contactId->caption());

        // contactCode
        $this->contactCode->setupEditAttributes();
        $this->contactCode->EditCustomAttributes = "";
        if (!$this->contactCode->Raw) {
            $this->contactCode->CurrentValue = HtmlDecode($this->contactCode->CurrentValue);
        }
        $this->contactCode->EditValue = $this->contactCode->CurrentValue;
        $this->contactCode->PlaceHolder = RemoveHtml($this->contactCode->caption());

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // isTaxInvoice
        $this->isTaxInvoice->setupEditAttributes();
        $this->isTaxInvoice->EditCustomAttributes = "";
        $this->isTaxInvoice->EditValue = $this->isTaxInvoice->CurrentValue;
        $this->isTaxInvoice->PlaceHolder = RemoveHtml($this->isTaxInvoice->caption());
        if (strval($this->isTaxInvoice->EditValue) != "" && is_numeric($this->isTaxInvoice->EditValue)) {
            $this->isTaxInvoice->EditValue = FormatNumber($this->isTaxInvoice->EditValue, null);
        }

        // preTaxAmount
        $this->preTaxAmount->setupEditAttributes();
        $this->preTaxAmount->EditCustomAttributes = "";
        $this->preTaxAmount->EditValue = $this->preTaxAmount->CurrentValue;
        $this->preTaxAmount->PlaceHolder = RemoveHtml($this->preTaxAmount->caption());
        if (strval($this->preTaxAmount->EditValue) != "" && is_numeric($this->preTaxAmount->EditValue)) {
            $this->preTaxAmount->EditValue = FormatNumber($this->preTaxAmount->EditValue, null);
        }

        // vatAmount
        $this->vatAmount->setupEditAttributes();
        $this->vatAmount->EditCustomAttributes = "";
        $this->vatAmount->EditValue = $this->vatAmount->CurrentValue;
        $this->vatAmount->PlaceHolder = RemoveHtml($this->vatAmount->caption());
        if (strval($this->vatAmount->EditValue) != "" && is_numeric($this->vatAmount->EditValue)) {
            $this->vatAmount->EditValue = FormatNumber($this->vatAmount->EditValue, null);
        }

        // netAmount
        $this->netAmount->setupEditAttributes();
        $this->netAmount->EditCustomAttributes = "";
        $this->netAmount->EditValue = $this->netAmount->CurrentValue;
        $this->netAmount->PlaceHolder = RemoveHtml($this->netAmount->caption());
        if (strval($this->netAmount->EditValue) != "" && is_numeric($this->netAmount->EditValue)) {
            $this->netAmount->EditValue = FormatNumber($this->netAmount->EditValue, null);
        }

        // whtAmount
        $this->whtAmount->setupEditAttributes();
        $this->whtAmount->EditCustomAttributes = "";
        $this->whtAmount->EditValue = $this->whtAmount->CurrentValue;
        $this->whtAmount->PlaceHolder = RemoveHtml($this->whtAmount->caption());
        if (strval($this->whtAmount->EditValue) != "" && is_numeric($this->whtAmount->EditValue)) {
            $this->whtAmount->EditValue = FormatNumber($this->whtAmount->EditValue, null);
        }

        // paymentAmount
        $this->paymentAmount->setupEditAttributes();
        $this->paymentAmount->EditCustomAttributes = "";
        $this->paymentAmount->EditValue = $this->paymentAmount->CurrentValue;
        $this->paymentAmount->PlaceHolder = RemoveHtml($this->paymentAmount->caption());
        if (strval($this->paymentAmount->EditValue) != "" && is_numeric($this->paymentAmount->EditValue)) {
            $this->paymentAmount->EditValue = FormatNumber($this->paymentAmount->EditValue, null);
        }

        // remainAmount
        $this->remainAmount->setupEditAttributes();
        $this->remainAmount->EditCustomAttributes = "";
        $this->remainAmount->EditValue = $this->remainAmount->CurrentValue;
        $this->remainAmount->PlaceHolder = RemoveHtml($this->remainAmount->caption());
        if (strval($this->remainAmount->EditValue) != "" && is_numeric($this->remainAmount->EditValue)) {
            $this->remainAmount->EditValue = FormatNumber($this->remainAmount->EditValue, null);
        }

        // onlineViewLink
        $this->onlineViewLink->setupEditAttributes();
        $this->onlineViewLink->EditCustomAttributes = "";
        $this->onlineViewLink->EditValue = $this->onlineViewLink->CurrentValue;
        $this->onlineViewLink->PlaceHolder = RemoveHtml($this->onlineViewLink->caption());

        // taxStatus
        $this->taxStatus->setupEditAttributes();
        $this->taxStatus->EditCustomAttributes = "";
        $this->taxStatus->EditValue = $this->taxStatus->CurrentValue;
        $this->taxStatus->PlaceHolder = RemoveHtml($this->taxStatus->caption());
        if (strval($this->taxStatus->EditValue) != "" && is_numeric($this->taxStatus->EditValue)) {
            $this->taxStatus->EditValue = FormatNumber($this->taxStatus->EditValue, null);
        }

        // paymentDate
        $this->paymentDate->setupEditAttributes();
        $this->paymentDate->EditCustomAttributes = "";
        $this->paymentDate->EditValue = FormatDateTime($this->paymentDate->CurrentValue, $this->paymentDate->formatPattern());
        $this->paymentDate->PlaceHolder = RemoveHtml($this->paymentDate->caption());

        // withHoldingTaxAmount
        $this->withHoldingTaxAmount->setupEditAttributes();
        $this->withHoldingTaxAmount->EditCustomAttributes = "";
        if (!$this->withHoldingTaxAmount->Raw) {
            $this->withHoldingTaxAmount->CurrentValue = HtmlDecode($this->withHoldingTaxAmount->CurrentValue);
        }
        $this->withHoldingTaxAmount->EditValue = $this->withHoldingTaxAmount->CurrentValue;
        $this->withHoldingTaxAmount->PlaceHolder = RemoveHtml($this->withHoldingTaxAmount->caption());

        // paymentGroupId
        $this->paymentGroupId->setupEditAttributes();
        $this->paymentGroupId->EditCustomAttributes = "";
        $this->paymentGroupId->EditValue = $this->paymentGroupId->CurrentValue;
        $this->paymentGroupId->PlaceHolder = RemoveHtml($this->paymentGroupId->caption());
        if (strval($this->paymentGroupId->EditValue) != "" && is_numeric($this->paymentGroupId->EditValue)) {
            $this->paymentGroupId->EditValue = FormatNumber($this->paymentGroupId->EditValue, null);
        }

        // paymentTotal
        $this->paymentTotal->setupEditAttributes();
        $this->paymentTotal->EditCustomAttributes = "";
        $this->paymentTotal->EditValue = $this->paymentTotal->CurrentValue;
        $this->paymentTotal->PlaceHolder = RemoveHtml($this->paymentTotal->caption());
        if (strval($this->paymentTotal->EditValue) != "" && is_numeric($this->paymentTotal->EditValue)) {
            $this->paymentTotal->EditValue = FormatNumber($this->paymentTotal->EditValue, null);
        }

        // paymentMethodId
        $this->paymentMethodId->setupEditAttributes();
        $this->paymentMethodId->EditCustomAttributes = "";
        if (!$this->paymentMethodId->Raw) {
            $this->paymentMethodId->CurrentValue = HtmlDecode($this->paymentMethodId->CurrentValue);
        }
        $this->paymentMethodId->EditValue = $this->paymentMethodId->CurrentValue;
        $this->paymentMethodId->PlaceHolder = RemoveHtml($this->paymentMethodId->caption());

        // paymentMethodCode
        $this->paymentMethodCode->setupEditAttributes();
        $this->paymentMethodCode->EditCustomAttributes = "";
        if (!$this->paymentMethodCode->Raw) {
            $this->paymentMethodCode->CurrentValue = HtmlDecode($this->paymentMethodCode->CurrentValue);
        }
        $this->paymentMethodCode->EditValue = $this->paymentMethodCode->CurrentValue;
        $this->paymentMethodCode->PlaceHolder = RemoveHtml($this->paymentMethodCode->caption());

        // amount
        $this->amount->setupEditAttributes();
        $this->amount->EditCustomAttributes = "";
        $this->amount->EditValue = $this->amount->CurrentValue;
        $this->amount->PlaceHolder = RemoveHtml($this->amount->caption());
        if (strval($this->amount->EditValue) != "" && is_numeric($this->amount->EditValue)) {
            $this->amount->EditValue = FormatNumber($this->amount->EditValue, null);
        }

        // journals_id
        $this->journals_id->setupEditAttributes();
        $this->journals_id->EditCustomAttributes = "";
        if (!$this->journals_id->Raw) {
            $this->journals_id->CurrentValue = HtmlDecode($this->journals_id->CurrentValue);
        }
        $this->journals_id->EditValue = $this->journals_id->CurrentValue;
        $this->journals_id->PlaceHolder = RemoveHtml($this->journals_id->caption());

        // journals_code
        $this->journals_code->setupEditAttributes();
        $this->journals_code->EditCustomAttributes = "";
        if (!$this->journals_code->Raw) {
            $this->journals_code->CurrentValue = HtmlDecode($this->journals_code->CurrentValue);
        }
        $this->journals_code->EditValue = $this->journals_code->CurrentValue;
        $this->journals_code->PlaceHolder = RemoveHtml($this->journals_code->caption());

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

        // sync_detail_date
        $this->sync_detail_date->setupEditAttributes();
        $this->sync_detail_date->EditCustomAttributes = "";
        $this->sync_detail_date->EditValue = FormatDateTime($this->sync_detail_date->CurrentValue, $this->sync_detail_date->formatPattern());
        $this->sync_detail_date->PlaceHolder = RemoveHtml($this->sync_detail_date->caption());

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
                    $doc->exportCaption($this->peak_expense_id);
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->code);
                    $doc->exportCaption($this->issuedDate);
                    $doc->exportCaption($this->dueDate);
                    $doc->exportCaption($this->contactId);
                    $doc->exportCaption($this->contactCode);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->isTaxInvoice);
                    $doc->exportCaption($this->preTaxAmount);
                    $doc->exportCaption($this->vatAmount);
                    $doc->exportCaption($this->netAmount);
                    $doc->exportCaption($this->whtAmount);
                    $doc->exportCaption($this->paymentAmount);
                    $doc->exportCaption($this->remainAmount);
                    $doc->exportCaption($this->onlineViewLink);
                    $doc->exportCaption($this->taxStatus);
                    $doc->exportCaption($this->paymentDate);
                    $doc->exportCaption($this->withHoldingTaxAmount);
                    $doc->exportCaption($this->paymentGroupId);
                    $doc->exportCaption($this->paymentTotal);
                    $doc->exportCaption($this->paymentMethodId);
                    $doc->exportCaption($this->paymentMethodCode);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->journals_id);
                    $doc->exportCaption($this->journals_code);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->sync_detail_date);
                } else {
                    $doc->exportCaption($this->peak_expense_id);
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->code);
                    $doc->exportCaption($this->issuedDate);
                    $doc->exportCaption($this->dueDate);
                    $doc->exportCaption($this->contactId);
                    $doc->exportCaption($this->contactCode);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->isTaxInvoice);
                    $doc->exportCaption($this->preTaxAmount);
                    $doc->exportCaption($this->vatAmount);
                    $doc->exportCaption($this->netAmount);
                    $doc->exportCaption($this->whtAmount);
                    $doc->exportCaption($this->paymentAmount);
                    $doc->exportCaption($this->remainAmount);
                    $doc->exportCaption($this->taxStatus);
                    $doc->exportCaption($this->paymentDate);
                    $doc->exportCaption($this->withHoldingTaxAmount);
                    $doc->exportCaption($this->paymentGroupId);
                    $doc->exportCaption($this->paymentTotal);
                    $doc->exportCaption($this->paymentMethodId);
                    $doc->exportCaption($this->paymentMethodCode);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->journals_id);
                    $doc->exportCaption($this->journals_code);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->udate);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->sync_detail_date);
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
                        $doc->exportField($this->peak_expense_id);
                        $doc->exportField($this->id);
                        $doc->exportField($this->code);
                        $doc->exportField($this->issuedDate);
                        $doc->exportField($this->dueDate);
                        $doc->exportField($this->contactId);
                        $doc->exportField($this->contactCode);
                        $doc->exportField($this->status);
                        $doc->exportField($this->isTaxInvoice);
                        $doc->exportField($this->preTaxAmount);
                        $doc->exportField($this->vatAmount);
                        $doc->exportField($this->netAmount);
                        $doc->exportField($this->whtAmount);
                        $doc->exportField($this->paymentAmount);
                        $doc->exportField($this->remainAmount);
                        $doc->exportField($this->onlineViewLink);
                        $doc->exportField($this->taxStatus);
                        $doc->exportField($this->paymentDate);
                        $doc->exportField($this->withHoldingTaxAmount);
                        $doc->exportField($this->paymentGroupId);
                        $doc->exportField($this->paymentTotal);
                        $doc->exportField($this->paymentMethodId);
                        $doc->exportField($this->paymentMethodCode);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->journals_id);
                        $doc->exportField($this->journals_code);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->sync_detail_date);
                    } else {
                        $doc->exportField($this->peak_expense_id);
                        $doc->exportField($this->id);
                        $doc->exportField($this->code);
                        $doc->exportField($this->issuedDate);
                        $doc->exportField($this->dueDate);
                        $doc->exportField($this->contactId);
                        $doc->exportField($this->contactCode);
                        $doc->exportField($this->status);
                        $doc->exportField($this->isTaxInvoice);
                        $doc->exportField($this->preTaxAmount);
                        $doc->exportField($this->vatAmount);
                        $doc->exportField($this->netAmount);
                        $doc->exportField($this->whtAmount);
                        $doc->exportField($this->paymentAmount);
                        $doc->exportField($this->remainAmount);
                        $doc->exportField($this->taxStatus);
                        $doc->exportField($this->paymentDate);
                        $doc->exportField($this->withHoldingTaxAmount);
                        $doc->exportField($this->paymentGroupId);
                        $doc->exportField($this->paymentTotal);
                        $doc->exportField($this->paymentMethodId);
                        $doc->exportField($this->paymentMethodCode);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->journals_id);
                        $doc->exportField($this->journals_code);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->udate);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->sync_detail_date);
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
