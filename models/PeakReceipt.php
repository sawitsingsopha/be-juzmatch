<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for peak_receipt
 */
class PeakReceipt extends DbTable
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
    public $create_date;
    public $request_status;
    public $request_date;
    public $request_message;
    public $issueddate;
    public $duedate;
    public $contactcode;
    public $tag;
    public $istaxinvoice;
    public $taxstatus;
    public $paymentdate;
    public $paymentmethodid;
    public $paymentMethodCode;
    public $amount;
    public $remark;
    public $receipt_id;
    public $receipt_code;
    public $receipt_status;
    public $preTaxAmount;
    public $vatAmount;
    public $netAmount;
    public $whtAmount;
    public $paymentAmount;
    public $remainAmount;
    public $remainWhtAmount;
    public $onlineViewLink;
    public $isPartialReceipt;
    public $journals_id;
    public $journals_code;
    public $refid;
    public $transition_type;
    public $is_email;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'peak_receipt';
        $this->TableName = 'peak_receipt';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`peak_receipt`";
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
            'peak_receipt',
            'peak_receipt',
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

        // create_date
        $this->create_date = new DbField(
            'peak_receipt',
            'peak_receipt',
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

        // request_status
        $this->request_status = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_request_status',
            'request_status',
            '`request_status`',
            '`request_status`',
            3,
            11,
            -1,
            false,
            '`request_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->request_status->InputTextType = "text";
        $this->request_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['request_status'] = &$this->request_status;

        // request_date
        $this->request_date = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_request_date',
            'request_date',
            '`request_date`',
            CastDateFieldForLike("`request_date`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`request_date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->request_date->InputTextType = "text";
        $this->request_date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['request_date'] = &$this->request_date;

        // request_message
        $this->request_message = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_request_message',
            'request_message',
            '`request_message`',
            '`request_message`',
            201,
            65535,
            -1,
            false,
            '`request_message`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->request_message->InputTextType = "text";
        $this->Fields['request_message'] = &$this->request_message;

        // issueddate
        $this->issueddate = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_issueddate',
            'issueddate',
            '`issueddate`',
            CastDateFieldForLike("`issueddate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`issueddate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->issueddate->InputTextType = "text";
        $this->issueddate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['issueddate'] = &$this->issueddate;

        // duedate
        $this->duedate = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_duedate',
            'duedate',
            '`duedate`',
            CastDateFieldForLike("`duedate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`duedate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->duedate->InputTextType = "text";
        $this->duedate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['duedate'] = &$this->duedate;

        // contactcode
        $this->contactcode = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_contactcode',
            'contactcode',
            '`contactcode`',
            '`contactcode`',
            200,
            250,
            -1,
            false,
            '`contactcode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contactcode->InputTextType = "text";
        $this->Fields['contactcode'] = &$this->contactcode;

        // tag
        $this->tag = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_tag',
            'tag',
            '`tag`',
            '`tag`',
            201,
            500,
            -1,
            false,
            '`tag`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->tag->InputTextType = "text";
        $this->Fields['tag'] = &$this->tag;

        // istaxinvoice
        $this->istaxinvoice = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_istaxinvoice',
            'istaxinvoice',
            '`istaxinvoice`',
            '`istaxinvoice`',
            3,
            11,
            -1,
            false,
            '`istaxinvoice`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->istaxinvoice->InputTextType = "text";
        $this->istaxinvoice->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['istaxinvoice'] = &$this->istaxinvoice;

        // taxstatus
        $this->taxstatus = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_taxstatus',
            'taxstatus',
            '`taxstatus`',
            '`taxstatus`',
            3,
            11,
            -1,
            false,
            '`taxstatus`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->taxstatus->InputTextType = "text";
        $this->taxstatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['taxstatus'] = &$this->taxstatus;

        // paymentdate
        $this->paymentdate = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_paymentdate',
            'paymentdate',
            '`paymentdate`',
            CastDateFieldForLike("`paymentdate`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`paymentdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentdate->InputTextType = "text";
        $this->paymentdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['paymentdate'] = &$this->paymentdate;

        // paymentmethodid
        $this->paymentmethodid = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_paymentmethodid',
            'paymentmethodid',
            '`paymentmethodid`',
            '`paymentmethodid`',
            200,
            250,
            -1,
            false,
            '`paymentmethodid`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentmethodid->InputTextType = "text";
        $this->Fields['paymentmethodid'] = &$this->paymentmethodid;

        // paymentMethodCode
        $this->paymentMethodCode = new DbField(
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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

        // remark
        $this->remark = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_remark',
            'remark',
            '`remark`',
            '`remark`',
            200,
            250,
            -1,
            false,
            '`remark`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remark->InputTextType = "text";
        $this->Fields['remark'] = &$this->remark;

        // receipt_id
        $this->receipt_id = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_receipt_id',
            'receipt_id',
            '`receipt_id`',
            '`receipt_id`',
            200,
            250,
            -1,
            false,
            '`receipt_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receipt_id->InputTextType = "text";
        $this->Fields['receipt_id'] = &$this->receipt_id;

        // receipt_code
        $this->receipt_code = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_receipt_code',
            'receipt_code',
            '`receipt_code`',
            '`receipt_code`',
            200,
            250,
            -1,
            false,
            '`receipt_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receipt_code->InputTextType = "text";
        $this->Fields['receipt_code'] = &$this->receipt_code;

        // receipt_status
        $this->receipt_status = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_receipt_status',
            'receipt_status',
            '`receipt_status`',
            '`receipt_status`',
            200,
            250,
            -1,
            false,
            '`receipt_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receipt_status->InputTextType = "text";
        $this->Fields['receipt_status'] = &$this->receipt_status;

        // preTaxAmount
        $this->preTaxAmount = new DbField(
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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

        // remainWhtAmount
        $this->remainWhtAmount = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_remainWhtAmount',
            'remainWhtAmount',
            '`remainWhtAmount`',
            '`remainWhtAmount`',
            5,
            22,
            -1,
            false,
            '`remainWhtAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->remainWhtAmount->InputTextType = "text";
        $this->remainWhtAmount->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['remainWhtAmount'] = &$this->remainWhtAmount;

        // onlineViewLink
        $this->onlineViewLink = new DbField(
            'peak_receipt',
            'peak_receipt',
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

        // isPartialReceipt
        $this->isPartialReceipt = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_isPartialReceipt',
            'isPartialReceipt',
            '`isPartialReceipt`',
            '`isPartialReceipt`',
            3,
            11,
            -1,
            false,
            '`isPartialReceipt`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->isPartialReceipt->InputTextType = "text";
        $this->isPartialReceipt->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['isPartialReceipt'] = &$this->isPartialReceipt;

        // journals_id
        $this->journals_id = new DbField(
            'peak_receipt',
            'peak_receipt',
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
            'peak_receipt',
            'peak_receipt',
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

        // refid
        $this->refid = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_refid',
            'refid',
            '`refid`',
            '`refid`',
            3,
            11,
            -1,
            false,
            '`refid`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->refid->InputTextType = "text";
        $this->refid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['refid'] = &$this->refid;

        // transition_type
        $this->transition_type = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_transition_type',
            'transition_type',
            '`transition_type`',
            '`transition_type`',
            16,
            4,
            -1,
            false,
            '`transition_type`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->transition_type->InputTextType = "text";
        $this->transition_type->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['transition_type'] = &$this->transition_type;

        // is_email
        $this->is_email = new DbField(
            'peak_receipt',
            'peak_receipt',
            'x_is_email',
            'is_email',
            '`is_email`',
            '`is_email`',
            17,
            3,
            -1,
            false,
            '`is_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->is_email->InputTextType = "text";
        $this->is_email->Nullable = false; // NOT NULL field
        $this->is_email->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['is_email'] = &$this->is_email;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`peak_receipt`";
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
        $this->create_date->DbValue = $row['create_date'];
        $this->request_status->DbValue = $row['request_status'];
        $this->request_date->DbValue = $row['request_date'];
        $this->request_message->DbValue = $row['request_message'];
        $this->issueddate->DbValue = $row['issueddate'];
        $this->duedate->DbValue = $row['duedate'];
        $this->contactcode->DbValue = $row['contactcode'];
        $this->tag->DbValue = $row['tag'];
        $this->istaxinvoice->DbValue = $row['istaxinvoice'];
        $this->taxstatus->DbValue = $row['taxstatus'];
        $this->paymentdate->DbValue = $row['paymentdate'];
        $this->paymentmethodid->DbValue = $row['paymentmethodid'];
        $this->paymentMethodCode->DbValue = $row['paymentMethodCode'];
        $this->amount->DbValue = $row['amount'];
        $this->remark->DbValue = $row['remark'];
        $this->receipt_id->DbValue = $row['receipt_id'];
        $this->receipt_code->DbValue = $row['receipt_code'];
        $this->receipt_status->DbValue = $row['receipt_status'];
        $this->preTaxAmount->DbValue = $row['preTaxAmount'];
        $this->vatAmount->DbValue = $row['vatAmount'];
        $this->netAmount->DbValue = $row['netAmount'];
        $this->whtAmount->DbValue = $row['whtAmount'];
        $this->paymentAmount->DbValue = $row['paymentAmount'];
        $this->remainAmount->DbValue = $row['remainAmount'];
        $this->remainWhtAmount->DbValue = $row['remainWhtAmount'];
        $this->onlineViewLink->DbValue = $row['onlineViewLink'];
        $this->isPartialReceipt->DbValue = $row['isPartialReceipt'];
        $this->journals_id->DbValue = $row['journals_id'];
        $this->journals_code->DbValue = $row['journals_code'];
        $this->refid->DbValue = $row['refid'];
        $this->transition_type->DbValue = $row['transition_type'];
        $this->is_email->DbValue = $row['is_email'];
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
        return $_SESSION[$name] ?? GetUrl("peakreceiptlist");
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
        if ($pageName == "peakreceiptview") {
            return $Language->phrase("View");
        } elseif ($pageName == "peakreceiptedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "peakreceiptadd") {
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
                return "PeakReceiptView";
            case Config("API_ADD_ACTION"):
                return "PeakReceiptAdd";
            case Config("API_EDIT_ACTION"):
                return "PeakReceiptEdit";
            case Config("API_DELETE_ACTION"):
                return "PeakReceiptDelete";
            case Config("API_LIST_ACTION"):
                return "PeakReceiptList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "peakreceiptlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("peakreceiptview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("peakreceiptview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "peakreceiptadd?" . $this->getUrlParm($parm);
        } else {
            $url = "peakreceiptadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("peakreceiptedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("peakreceiptadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("peakreceiptdelete", $this->getUrlParm());
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
        $this->create_date->setDbValue($row['create_date']);
        $this->request_status->setDbValue($row['request_status']);
        $this->request_date->setDbValue($row['request_date']);
        $this->request_message->setDbValue($row['request_message']);
        $this->issueddate->setDbValue($row['issueddate']);
        $this->duedate->setDbValue($row['duedate']);
        $this->contactcode->setDbValue($row['contactcode']);
        $this->tag->setDbValue($row['tag']);
        $this->istaxinvoice->setDbValue($row['istaxinvoice']);
        $this->taxstatus->setDbValue($row['taxstatus']);
        $this->paymentdate->setDbValue($row['paymentdate']);
        $this->paymentmethodid->setDbValue($row['paymentmethodid']);
        $this->paymentMethodCode->setDbValue($row['paymentMethodCode']);
        $this->amount->setDbValue($row['amount']);
        $this->remark->setDbValue($row['remark']);
        $this->receipt_id->setDbValue($row['receipt_id']);
        $this->receipt_code->setDbValue($row['receipt_code']);
        $this->receipt_status->setDbValue($row['receipt_status']);
        $this->preTaxAmount->setDbValue($row['preTaxAmount']);
        $this->vatAmount->setDbValue($row['vatAmount']);
        $this->netAmount->setDbValue($row['netAmount']);
        $this->whtAmount->setDbValue($row['whtAmount']);
        $this->paymentAmount->setDbValue($row['paymentAmount']);
        $this->remainAmount->setDbValue($row['remainAmount']);
        $this->remainWhtAmount->setDbValue($row['remainWhtAmount']);
        $this->onlineViewLink->setDbValue($row['onlineViewLink']);
        $this->isPartialReceipt->setDbValue($row['isPartialReceipt']);
        $this->journals_id->setDbValue($row['journals_id']);
        $this->journals_code->setDbValue($row['journals_code']);
        $this->refid->setDbValue($row['refid']);
        $this->transition_type->setDbValue($row['transition_type']);
        $this->is_email->setDbValue($row['is_email']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // create_date

        // request_status

        // request_date

        // request_message

        // issueddate

        // duedate

        // contactcode

        // tag

        // istaxinvoice

        // taxstatus

        // paymentdate

        // paymentmethodid

        // paymentMethodCode

        // amount

        // remark

        // receipt_id

        // receipt_code

        // receipt_status

        // preTaxAmount

        // vatAmount

        // netAmount

        // whtAmount

        // paymentAmount

        // remainAmount

        // remainWhtAmount

        // onlineViewLink

        // isPartialReceipt

        // journals_id

        // journals_code

        // refid

        // transition_type

        // is_email

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // create_date
        $this->create_date->ViewValue = $this->create_date->CurrentValue;
        $this->create_date->ViewValue = FormatDateTime($this->create_date->ViewValue, $this->create_date->formatPattern());
        $this->create_date->ViewCustomAttributes = "";

        // request_status
        $this->request_status->ViewValue = $this->request_status->CurrentValue;
        $this->request_status->ViewValue = FormatNumber($this->request_status->ViewValue, $this->request_status->formatPattern());
        $this->request_status->ViewCustomAttributes = "";

        // request_date
        $this->request_date->ViewValue = $this->request_date->CurrentValue;
        $this->request_date->ViewValue = FormatDateTime($this->request_date->ViewValue, $this->request_date->formatPattern());
        $this->request_date->ViewCustomAttributes = "";

        // request_message
        $this->request_message->ViewValue = $this->request_message->CurrentValue;
        $this->request_message->ViewCustomAttributes = "";

        // issueddate
        $this->issueddate->ViewValue = $this->issueddate->CurrentValue;
        $this->issueddate->ViewValue = FormatDateTime($this->issueddate->ViewValue, $this->issueddate->formatPattern());
        $this->issueddate->ViewCustomAttributes = "";

        // duedate
        $this->duedate->ViewValue = $this->duedate->CurrentValue;
        $this->duedate->ViewValue = FormatDateTime($this->duedate->ViewValue, $this->duedate->formatPattern());
        $this->duedate->ViewCustomAttributes = "";

        // contactcode
        $this->contactcode->ViewValue = $this->contactcode->CurrentValue;
        $this->contactcode->ViewCustomAttributes = "";

        // tag
        $this->tag->ViewValue = $this->tag->CurrentValue;
        $this->tag->ViewCustomAttributes = "";

        // istaxinvoice
        $this->istaxinvoice->ViewValue = $this->istaxinvoice->CurrentValue;
        $this->istaxinvoice->ViewValue = FormatNumber($this->istaxinvoice->ViewValue, $this->istaxinvoice->formatPattern());
        $this->istaxinvoice->ViewCustomAttributes = "";

        // taxstatus
        $this->taxstatus->ViewValue = $this->taxstatus->CurrentValue;
        $this->taxstatus->ViewValue = FormatNumber($this->taxstatus->ViewValue, $this->taxstatus->formatPattern());
        $this->taxstatus->ViewCustomAttributes = "";

        // paymentdate
        $this->paymentdate->ViewValue = $this->paymentdate->CurrentValue;
        $this->paymentdate->ViewValue = FormatDateTime($this->paymentdate->ViewValue, $this->paymentdate->formatPattern());
        $this->paymentdate->ViewCustomAttributes = "";

        // paymentmethodid
        $this->paymentmethodid->ViewValue = $this->paymentmethodid->CurrentValue;
        $this->paymentmethodid->ViewCustomAttributes = "";

        // paymentMethodCode
        $this->paymentMethodCode->ViewValue = $this->paymentMethodCode->CurrentValue;
        $this->paymentMethodCode->ViewCustomAttributes = "";

        // amount
        $this->amount->ViewValue = $this->amount->CurrentValue;
        $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
        $this->amount->ViewCustomAttributes = "";

        // remark
        $this->remark->ViewValue = $this->remark->CurrentValue;
        $this->remark->ViewCustomAttributes = "";

        // receipt_id
        $this->receipt_id->ViewValue = $this->receipt_id->CurrentValue;
        $this->receipt_id->ViewCustomAttributes = "";

        // receipt_code
        $this->receipt_code->ViewValue = $this->receipt_code->CurrentValue;
        $this->receipt_code->ViewCustomAttributes = "";

        // receipt_status
        $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
        $this->receipt_status->ViewCustomAttributes = "";

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

        // remainWhtAmount
        $this->remainWhtAmount->ViewValue = $this->remainWhtAmount->CurrentValue;
        $this->remainWhtAmount->ViewValue = FormatNumber($this->remainWhtAmount->ViewValue, $this->remainWhtAmount->formatPattern());
        $this->remainWhtAmount->ViewCustomAttributes = "";

        // onlineViewLink
        $this->onlineViewLink->ViewValue = $this->onlineViewLink->CurrentValue;
        $this->onlineViewLink->ViewCustomAttributes = "";

        // isPartialReceipt
        $this->isPartialReceipt->ViewValue = $this->isPartialReceipt->CurrentValue;
        $this->isPartialReceipt->ViewValue = FormatNumber($this->isPartialReceipt->ViewValue, $this->isPartialReceipt->formatPattern());
        $this->isPartialReceipt->ViewCustomAttributes = "";

        // journals_id
        $this->journals_id->ViewValue = $this->journals_id->CurrentValue;
        $this->journals_id->ViewCustomAttributes = "";

        // journals_code
        $this->journals_code->ViewValue = $this->journals_code->CurrentValue;
        $this->journals_code->ViewCustomAttributes = "";

        // refid
        $this->refid->ViewValue = $this->refid->CurrentValue;
        $this->refid->ViewValue = FormatNumber($this->refid->ViewValue, $this->refid->formatPattern());
        $this->refid->ViewCustomAttributes = "";

        // transition_type
        $this->transition_type->ViewValue = $this->transition_type->CurrentValue;
        $this->transition_type->ViewValue = FormatNumber($this->transition_type->ViewValue, $this->transition_type->formatPattern());
        $this->transition_type->ViewCustomAttributes = "";

        // is_email
        $this->is_email->ViewValue = $this->is_email->CurrentValue;
        $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
        $this->is_email->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // create_date
        $this->create_date->LinkCustomAttributes = "";
        $this->create_date->HrefValue = "";
        $this->create_date->TooltipValue = "";

        // request_status
        $this->request_status->LinkCustomAttributes = "";
        $this->request_status->HrefValue = "";
        $this->request_status->TooltipValue = "";

        // request_date
        $this->request_date->LinkCustomAttributes = "";
        $this->request_date->HrefValue = "";
        $this->request_date->TooltipValue = "";

        // request_message
        $this->request_message->LinkCustomAttributes = "";
        $this->request_message->HrefValue = "";
        $this->request_message->TooltipValue = "";

        // issueddate
        $this->issueddate->LinkCustomAttributes = "";
        $this->issueddate->HrefValue = "";
        $this->issueddate->TooltipValue = "";

        // duedate
        $this->duedate->LinkCustomAttributes = "";
        $this->duedate->HrefValue = "";
        $this->duedate->TooltipValue = "";

        // contactcode
        $this->contactcode->LinkCustomAttributes = "";
        $this->contactcode->HrefValue = "";
        $this->contactcode->TooltipValue = "";

        // tag
        $this->tag->LinkCustomAttributes = "";
        $this->tag->HrefValue = "";
        $this->tag->TooltipValue = "";

        // istaxinvoice
        $this->istaxinvoice->LinkCustomAttributes = "";
        $this->istaxinvoice->HrefValue = "";
        $this->istaxinvoice->TooltipValue = "";

        // taxstatus
        $this->taxstatus->LinkCustomAttributes = "";
        $this->taxstatus->HrefValue = "";
        $this->taxstatus->TooltipValue = "";

        // paymentdate
        $this->paymentdate->LinkCustomAttributes = "";
        $this->paymentdate->HrefValue = "";
        $this->paymentdate->TooltipValue = "";

        // paymentmethodid
        $this->paymentmethodid->LinkCustomAttributes = "";
        $this->paymentmethodid->HrefValue = "";
        $this->paymentmethodid->TooltipValue = "";

        // paymentMethodCode
        $this->paymentMethodCode->LinkCustomAttributes = "";
        $this->paymentMethodCode->HrefValue = "";
        $this->paymentMethodCode->TooltipValue = "";

        // amount
        $this->amount->LinkCustomAttributes = "";
        $this->amount->HrefValue = "";
        $this->amount->TooltipValue = "";

        // remark
        $this->remark->LinkCustomAttributes = "";
        $this->remark->HrefValue = "";
        $this->remark->TooltipValue = "";

        // receipt_id
        $this->receipt_id->LinkCustomAttributes = "";
        $this->receipt_id->HrefValue = "";
        $this->receipt_id->TooltipValue = "";

        // receipt_code
        $this->receipt_code->LinkCustomAttributes = "";
        $this->receipt_code->HrefValue = "";
        $this->receipt_code->TooltipValue = "";

        // receipt_status
        $this->receipt_status->LinkCustomAttributes = "";
        $this->receipt_status->HrefValue = "";
        $this->receipt_status->TooltipValue = "";

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

        // remainWhtAmount
        $this->remainWhtAmount->LinkCustomAttributes = "";
        $this->remainWhtAmount->HrefValue = "";
        $this->remainWhtAmount->TooltipValue = "";

        // onlineViewLink
        $this->onlineViewLink->LinkCustomAttributes = "";
        $this->onlineViewLink->HrefValue = "";
        $this->onlineViewLink->TooltipValue = "";

        // isPartialReceipt
        $this->isPartialReceipt->LinkCustomAttributes = "";
        $this->isPartialReceipt->HrefValue = "";
        $this->isPartialReceipt->TooltipValue = "";

        // journals_id
        $this->journals_id->LinkCustomAttributes = "";
        $this->journals_id->HrefValue = "";
        $this->journals_id->TooltipValue = "";

        // journals_code
        $this->journals_code->LinkCustomAttributes = "";
        $this->journals_code->HrefValue = "";
        $this->journals_code->TooltipValue = "";

        // refid
        $this->refid->LinkCustomAttributes = "";
        $this->refid->HrefValue = "";
        $this->refid->TooltipValue = "";

        // transition_type
        $this->transition_type->LinkCustomAttributes = "";
        $this->transition_type->HrefValue = "";
        $this->transition_type->TooltipValue = "";

        // is_email
        $this->is_email->LinkCustomAttributes = "";
        $this->is_email->HrefValue = "";
        $this->is_email->TooltipValue = "";

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

        // create_date
        $this->create_date->setupEditAttributes();
        $this->create_date->EditCustomAttributes = "";
        $this->create_date->EditValue = FormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern());
        $this->create_date->PlaceHolder = RemoveHtml($this->create_date->caption());

        // request_status
        $this->request_status->setupEditAttributes();
        $this->request_status->EditCustomAttributes = "";
        $this->request_status->EditValue = $this->request_status->CurrentValue;
        $this->request_status->PlaceHolder = RemoveHtml($this->request_status->caption());
        if (strval($this->request_status->EditValue) != "" && is_numeric($this->request_status->EditValue)) {
            $this->request_status->EditValue = FormatNumber($this->request_status->EditValue, null);
        }

        // request_date
        $this->request_date->setupEditAttributes();
        $this->request_date->EditCustomAttributes = "";
        $this->request_date->EditValue = FormatDateTime($this->request_date->CurrentValue, $this->request_date->formatPattern());
        $this->request_date->PlaceHolder = RemoveHtml($this->request_date->caption());

        // request_message
        $this->request_message->setupEditAttributes();
        $this->request_message->EditCustomAttributes = "";
        $this->request_message->EditValue = $this->request_message->CurrentValue;
        $this->request_message->PlaceHolder = RemoveHtml($this->request_message->caption());

        // issueddate
        $this->issueddate->setupEditAttributes();
        $this->issueddate->EditCustomAttributes = "";
        $this->issueddate->EditValue = FormatDateTime($this->issueddate->CurrentValue, $this->issueddate->formatPattern());
        $this->issueddate->PlaceHolder = RemoveHtml($this->issueddate->caption());

        // duedate
        $this->duedate->setupEditAttributes();
        $this->duedate->EditCustomAttributes = "";
        $this->duedate->EditValue = FormatDateTime($this->duedate->CurrentValue, $this->duedate->formatPattern());
        $this->duedate->PlaceHolder = RemoveHtml($this->duedate->caption());

        // contactcode
        $this->contactcode->setupEditAttributes();
        $this->contactcode->EditCustomAttributes = "";
        if (!$this->contactcode->Raw) {
            $this->contactcode->CurrentValue = HtmlDecode($this->contactcode->CurrentValue);
        }
        $this->contactcode->EditValue = $this->contactcode->CurrentValue;
        $this->contactcode->PlaceHolder = RemoveHtml($this->contactcode->caption());

        // tag
        $this->tag->setupEditAttributes();
        $this->tag->EditCustomAttributes = "";
        $this->tag->EditValue = $this->tag->CurrentValue;
        $this->tag->PlaceHolder = RemoveHtml($this->tag->caption());

        // istaxinvoice
        $this->istaxinvoice->setupEditAttributes();
        $this->istaxinvoice->EditCustomAttributes = "";
        $this->istaxinvoice->EditValue = $this->istaxinvoice->CurrentValue;
        $this->istaxinvoice->PlaceHolder = RemoveHtml($this->istaxinvoice->caption());
        if (strval($this->istaxinvoice->EditValue) != "" && is_numeric($this->istaxinvoice->EditValue)) {
            $this->istaxinvoice->EditValue = FormatNumber($this->istaxinvoice->EditValue, null);
        }

        // taxstatus
        $this->taxstatus->setupEditAttributes();
        $this->taxstatus->EditCustomAttributes = "";
        $this->taxstatus->EditValue = $this->taxstatus->CurrentValue;
        $this->taxstatus->PlaceHolder = RemoveHtml($this->taxstatus->caption());
        if (strval($this->taxstatus->EditValue) != "" && is_numeric($this->taxstatus->EditValue)) {
            $this->taxstatus->EditValue = FormatNumber($this->taxstatus->EditValue, null);
        }

        // paymentdate
        $this->paymentdate->setupEditAttributes();
        $this->paymentdate->EditCustomAttributes = "";
        $this->paymentdate->EditValue = FormatDateTime($this->paymentdate->CurrentValue, $this->paymentdate->formatPattern());
        $this->paymentdate->PlaceHolder = RemoveHtml($this->paymentdate->caption());

        // paymentmethodid
        $this->paymentmethodid->setupEditAttributes();
        $this->paymentmethodid->EditCustomAttributes = "";
        if (!$this->paymentmethodid->Raw) {
            $this->paymentmethodid->CurrentValue = HtmlDecode($this->paymentmethodid->CurrentValue);
        }
        $this->paymentmethodid->EditValue = $this->paymentmethodid->CurrentValue;
        $this->paymentmethodid->PlaceHolder = RemoveHtml($this->paymentmethodid->caption());

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

        // remark
        $this->remark->setupEditAttributes();
        $this->remark->EditCustomAttributes = "";
        if (!$this->remark->Raw) {
            $this->remark->CurrentValue = HtmlDecode($this->remark->CurrentValue);
        }
        $this->remark->EditValue = $this->remark->CurrentValue;
        $this->remark->PlaceHolder = RemoveHtml($this->remark->caption());

        // receipt_id
        $this->receipt_id->setupEditAttributes();
        $this->receipt_id->EditCustomAttributes = "";
        if (!$this->receipt_id->Raw) {
            $this->receipt_id->CurrentValue = HtmlDecode($this->receipt_id->CurrentValue);
        }
        $this->receipt_id->EditValue = $this->receipt_id->CurrentValue;
        $this->receipt_id->PlaceHolder = RemoveHtml($this->receipt_id->caption());

        // receipt_code
        $this->receipt_code->setupEditAttributes();
        $this->receipt_code->EditCustomAttributes = "";
        if (!$this->receipt_code->Raw) {
            $this->receipt_code->CurrentValue = HtmlDecode($this->receipt_code->CurrentValue);
        }
        $this->receipt_code->EditValue = $this->receipt_code->CurrentValue;
        $this->receipt_code->PlaceHolder = RemoveHtml($this->receipt_code->caption());

        // receipt_status
        $this->receipt_status->setupEditAttributes();
        $this->receipt_status->EditCustomAttributes = "";
        if (!$this->receipt_status->Raw) {
            $this->receipt_status->CurrentValue = HtmlDecode($this->receipt_status->CurrentValue);
        }
        $this->receipt_status->EditValue = $this->receipt_status->CurrentValue;
        $this->receipt_status->PlaceHolder = RemoveHtml($this->receipt_status->caption());

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

        // remainWhtAmount
        $this->remainWhtAmount->setupEditAttributes();
        $this->remainWhtAmount->EditCustomAttributes = "";
        $this->remainWhtAmount->EditValue = $this->remainWhtAmount->CurrentValue;
        $this->remainWhtAmount->PlaceHolder = RemoveHtml($this->remainWhtAmount->caption());
        if (strval($this->remainWhtAmount->EditValue) != "" && is_numeric($this->remainWhtAmount->EditValue)) {
            $this->remainWhtAmount->EditValue = FormatNumber($this->remainWhtAmount->EditValue, null);
        }

        // onlineViewLink
        $this->onlineViewLink->setupEditAttributes();
        $this->onlineViewLink->EditCustomAttributes = "";
        $this->onlineViewLink->EditValue = $this->onlineViewLink->CurrentValue;
        $this->onlineViewLink->PlaceHolder = RemoveHtml($this->onlineViewLink->caption());

        // isPartialReceipt
        $this->isPartialReceipt->setupEditAttributes();
        $this->isPartialReceipt->EditCustomAttributes = "";
        $this->isPartialReceipt->EditValue = $this->isPartialReceipt->CurrentValue;
        $this->isPartialReceipt->PlaceHolder = RemoveHtml($this->isPartialReceipt->caption());
        if (strval($this->isPartialReceipt->EditValue) != "" && is_numeric($this->isPartialReceipt->EditValue)) {
            $this->isPartialReceipt->EditValue = FormatNumber($this->isPartialReceipt->EditValue, null);
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

        // refid
        $this->refid->setupEditAttributes();
        $this->refid->EditCustomAttributes = "";
        $this->refid->EditValue = $this->refid->CurrentValue;
        $this->refid->PlaceHolder = RemoveHtml($this->refid->caption());
        if (strval($this->refid->EditValue) != "" && is_numeric($this->refid->EditValue)) {
            $this->refid->EditValue = FormatNumber($this->refid->EditValue, null);
        }

        // transition_type
        $this->transition_type->setupEditAttributes();
        $this->transition_type->EditCustomAttributes = "";
        $this->transition_type->EditValue = $this->transition_type->CurrentValue;
        $this->transition_type->PlaceHolder = RemoveHtml($this->transition_type->caption());
        if (strval($this->transition_type->EditValue) != "" && is_numeric($this->transition_type->EditValue)) {
            $this->transition_type->EditValue = FormatNumber($this->transition_type->EditValue, null);
        }

        // is_email
        $this->is_email->setupEditAttributes();
        $this->is_email->EditCustomAttributes = "";
        $this->is_email->EditValue = $this->is_email->CurrentValue;
        $this->is_email->PlaceHolder = RemoveHtml($this->is_email->caption());
        if (strval($this->is_email->EditValue) != "" && is_numeric($this->is_email->EditValue)) {
            $this->is_email->EditValue = FormatNumber($this->is_email->EditValue, null);
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
                    $doc->exportCaption($this->create_date);
                    $doc->exportCaption($this->request_status);
                    $doc->exportCaption($this->request_date);
                    $doc->exportCaption($this->request_message);
                    $doc->exportCaption($this->issueddate);
                    $doc->exportCaption($this->duedate);
                    $doc->exportCaption($this->contactcode);
                    $doc->exportCaption($this->tag);
                    $doc->exportCaption($this->istaxinvoice);
                    $doc->exportCaption($this->taxstatus);
                    $doc->exportCaption($this->paymentdate);
                    $doc->exportCaption($this->paymentmethodid);
                    $doc->exportCaption($this->paymentMethodCode);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->remark);
                    $doc->exportCaption($this->receipt_id);
                    $doc->exportCaption($this->receipt_code);
                    $doc->exportCaption($this->receipt_status);
                    $doc->exportCaption($this->preTaxAmount);
                    $doc->exportCaption($this->vatAmount);
                    $doc->exportCaption($this->netAmount);
                    $doc->exportCaption($this->whtAmount);
                    $doc->exportCaption($this->paymentAmount);
                    $doc->exportCaption($this->remainAmount);
                    $doc->exportCaption($this->remainWhtAmount);
                    $doc->exportCaption($this->onlineViewLink);
                    $doc->exportCaption($this->isPartialReceipt);
                    $doc->exportCaption($this->journals_id);
                    $doc->exportCaption($this->journals_code);
                    $doc->exportCaption($this->refid);
                    $doc->exportCaption($this->transition_type);
                    $doc->exportCaption($this->is_email);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->create_date);
                    $doc->exportCaption($this->request_status);
                    $doc->exportCaption($this->request_date);
                    $doc->exportCaption($this->issueddate);
                    $doc->exportCaption($this->duedate);
                    $doc->exportCaption($this->contactcode);
                    $doc->exportCaption($this->istaxinvoice);
                    $doc->exportCaption($this->taxstatus);
                    $doc->exportCaption($this->paymentdate);
                    $doc->exportCaption($this->paymentmethodid);
                    $doc->exportCaption($this->paymentMethodCode);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->remark);
                    $doc->exportCaption($this->receipt_id);
                    $doc->exportCaption($this->receipt_code);
                    $doc->exportCaption($this->receipt_status);
                    $doc->exportCaption($this->preTaxAmount);
                    $doc->exportCaption($this->vatAmount);
                    $doc->exportCaption($this->netAmount);
                    $doc->exportCaption($this->whtAmount);
                    $doc->exportCaption($this->paymentAmount);
                    $doc->exportCaption($this->remainAmount);
                    $doc->exportCaption($this->remainWhtAmount);
                    $doc->exportCaption($this->isPartialReceipt);
                    $doc->exportCaption($this->journals_id);
                    $doc->exportCaption($this->journals_code);
                    $doc->exportCaption($this->refid);
                    $doc->exportCaption($this->transition_type);
                    $doc->exportCaption($this->is_email);
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
                        $doc->exportField($this->create_date);
                        $doc->exportField($this->request_status);
                        $doc->exportField($this->request_date);
                        $doc->exportField($this->request_message);
                        $doc->exportField($this->issueddate);
                        $doc->exportField($this->duedate);
                        $doc->exportField($this->contactcode);
                        $doc->exportField($this->tag);
                        $doc->exportField($this->istaxinvoice);
                        $doc->exportField($this->taxstatus);
                        $doc->exportField($this->paymentdate);
                        $doc->exportField($this->paymentmethodid);
                        $doc->exportField($this->paymentMethodCode);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->remark);
                        $doc->exportField($this->receipt_id);
                        $doc->exportField($this->receipt_code);
                        $doc->exportField($this->receipt_status);
                        $doc->exportField($this->preTaxAmount);
                        $doc->exportField($this->vatAmount);
                        $doc->exportField($this->netAmount);
                        $doc->exportField($this->whtAmount);
                        $doc->exportField($this->paymentAmount);
                        $doc->exportField($this->remainAmount);
                        $doc->exportField($this->remainWhtAmount);
                        $doc->exportField($this->onlineViewLink);
                        $doc->exportField($this->isPartialReceipt);
                        $doc->exportField($this->journals_id);
                        $doc->exportField($this->journals_code);
                        $doc->exportField($this->refid);
                        $doc->exportField($this->transition_type);
                        $doc->exportField($this->is_email);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->create_date);
                        $doc->exportField($this->request_status);
                        $doc->exportField($this->request_date);
                        $doc->exportField($this->issueddate);
                        $doc->exportField($this->duedate);
                        $doc->exportField($this->contactcode);
                        $doc->exportField($this->istaxinvoice);
                        $doc->exportField($this->taxstatus);
                        $doc->exportField($this->paymentdate);
                        $doc->exportField($this->paymentmethodid);
                        $doc->exportField($this->paymentMethodCode);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->remark);
                        $doc->exportField($this->receipt_id);
                        $doc->exportField($this->receipt_code);
                        $doc->exportField($this->receipt_status);
                        $doc->exportField($this->preTaxAmount);
                        $doc->exportField($this->vatAmount);
                        $doc->exportField($this->netAmount);
                        $doc->exportField($this->whtAmount);
                        $doc->exportField($this->paymentAmount);
                        $doc->exportField($this->remainAmount);
                        $doc->exportField($this->remainWhtAmount);
                        $doc->exportField($this->isPartialReceipt);
                        $doc->exportField($this->journals_id);
                        $doc->exportField($this->journals_code);
                        $doc->exportField($this->refid);
                        $doc->exportField($this->transition_type);
                        $doc->exportField($this->is_email);
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
