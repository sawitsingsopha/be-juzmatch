<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for buyer_config_asset_schedule
 */
class BuyerConfigAssetSchedule extends DbTable
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
    public $buyer_config_asset_schedule_id;
    public $member_id;
    public $asset_id;
    public $installment_all;
    public $installment_price_per;
    public $date_start_installment;
    public $status_approve;
    public $asset_price;
    public $booking_price;
    public $down_price;
    public $move_in_on_20th;
    public $number_days_pay_first_month;
    public $number_days_in_first_month;
    public $cdate;
    public $cuser;
    public $cip;
    public $uuser;
    public $uip;
    public $udate;
    public $annual_interest;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'buyer_config_asset_schedule';
        $this->TableName = 'buyer_config_asset_schedule';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`buyer_config_asset_schedule`";
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

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_buyer_config_asset_schedule_id',
            'buyer_config_asset_schedule_id',
            '`buyer_config_asset_schedule_id`',
            '`buyer_config_asset_schedule_id`',
            3,
            11,
            -1,
            false,
            '`buyer_config_asset_schedule_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->buyer_config_asset_schedule_id->InputTextType = "text";
        $this->buyer_config_asset_schedule_id->IsAutoIncrement = true; // Autoincrement field
        $this->buyer_config_asset_schedule_id->IsPrimaryKey = true; // Primary key field
        $this->buyer_config_asset_schedule_id->Sortable = false; // Allow sort
        $this->buyer_config_asset_schedule_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['buyer_config_asset_schedule_id'] = &$this->buyer_config_asset_schedule_id;

        // member_id
        $this->member_id = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->member_id->Required = true; // Required field
        $this->member_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->member_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // asset_id
        $this->asset_id = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_asset_id',
            'asset_id',
            '`asset_id`',
            '`asset_id`',
            3,
            11,
            -1,
            false,
            '`asset_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->asset_id->InputTextType = "text";
        $this->asset_id->IsForeignKey = true; // Foreign key field
        $this->asset_id->Nullable = false; // NOT NULL field
        $this->asset_id->Required = true; // Required field
        $this->asset_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->asset_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->asset_id->Lookup = new Lookup('asset_id', 'asset', false, 'asset_id', ["title","asset_code","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`title`, ''),'" . ValueSeparator(1, $this->asset_id) . "',COALESCE(`asset_code`,''))");
        $this->asset_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['asset_id'] = &$this->asset_id;

        // installment_all
        $this->installment_all = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_installment_all',
            'installment_all',
            '`installment_all`',
            '`installment_all`',
            3,
            11,
            -1,
            false,
            '`installment_all`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment_all->InputTextType = "text";
        $this->installment_all->Required = true; // Required field
        $this->installment_all->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['installment_all'] = &$this->installment_all;

        // installment_price_per
        $this->installment_price_per = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_installment_price_per',
            'installment_price_per',
            '`installment_price_per`',
            '`installment_price_per`',
            4,
            12,
            -1,
            false,
            '`installment_price_per`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment_price_per->InputTextType = "text";
        $this->installment_price_per->Required = true; // Required field
        $this->installment_price_per->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['installment_price_per'] = &$this->installment_price_per;

        // date_start_installment
        $this->date_start_installment = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_date_start_installment',
            'date_start_installment',
            '`date_start_installment`',
            CastDateFieldForLike("`date_start_installment`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`date_start_installment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date_start_installment->InputTextType = "text";
        $this->date_start_installment->Required = true; // Required field
        $this->date_start_installment->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->Fields['date_start_installment'] = &$this->date_start_installment;

        // status_approve
        $this->status_approve = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_status_approve',
            'status_approve',
            '`status_approve`',
            '`status_approve`',
            3,
            11,
            -1,
            false,
            '`status_approve`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->status_approve->InputTextType = "text";
        $this->status_approve->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status_approve->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status_approve->Lookup = new Lookup('status_approve', 'buyer_config_asset_schedule', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->status_approve->OptionCount = 2;
        $this->status_approve->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status_approve'] = &$this->status_approve;

        // asset_price
        $this->asset_price = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->asset_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['asset_price'] = &$this->asset_price;

        // booking_price
        $this->booking_price = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_booking_price',
            'booking_price',
            '`booking_price`',
            '`booking_price`',
            4,
            12,
            -1,
            false,
            '`booking_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->booking_price->InputTextType = "text";
        $this->booking_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['booking_price'] = &$this->booking_price;

        // down_price
        $this->down_price = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_down_price',
            'down_price',
            '`down_price`',
            '`down_price`',
            4,
            12,
            -1,
            false,
            '`down_price`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->down_price->InputTextType = "text";
        $this->down_price->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['down_price'] = &$this->down_price;

        // move_in_on_20th
        $this->move_in_on_20th = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_move_in_on_20th',
            'move_in_on_20th',
            '`move_in_on_20th`',
            '`move_in_on_20th`',
            16,
            1,
            -1,
            false,
            '`move_in_on_20th`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->move_in_on_20th->InputTextType = "text";
        $this->move_in_on_20th->Nullable = false; // NOT NULL field
        $this->move_in_on_20th->DataType = DATATYPE_BOOLEAN;
        $this->move_in_on_20th->Lookup = new Lookup('move_in_on_20th', 'buyer_config_asset_schedule', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->move_in_on_20th->OptionCount = 2;
        $this->move_in_on_20th->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['move_in_on_20th'] = &$this->move_in_on_20th;

        // number_days_pay_first_month
        $this->number_days_pay_first_month = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_number_days_pay_first_month',
            'number_days_pay_first_month',
            '`number_days_pay_first_month`',
            '`number_days_pay_first_month`',
            3,
            11,
            -1,
            false,
            '`number_days_pay_first_month`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->number_days_pay_first_month->InputTextType = "text";
        $this->number_days_pay_first_month->Nullable = false; // NOT NULL field
        $this->number_days_pay_first_month->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['number_days_pay_first_month'] = &$this->number_days_pay_first_month;

        // number_days_in_first_month
        $this->number_days_in_first_month = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_number_days_in_first_month',
            'number_days_in_first_month',
            '`number_days_in_first_month`',
            '`number_days_in_first_month`',
            3,
            11,
            -1,
            false,
            '`number_days_in_first_month`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->number_days_in_first_month->InputTextType = "text";
        $this->number_days_in_first_month->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['number_days_in_first_month'] = &$this->number_days_in_first_month;

        // cdate
        $this->cdate = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->cuser->Sortable = false; // Allow sort
        $this->cuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cuser'] = &$this->cuser;

        // cip
        $this->cip = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->cip->Sortable = false; // Allow sort
        $this->Fields['cip'] = &$this->cip;

        // uuser
        $this->uuser = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->uuser->Sortable = false; // Allow sort
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->uip->Sortable = false; // Allow sort
        $this->Fields['uip'] = &$this->uip;

        // udate
        $this->udate = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
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
        $this->udate->Sortable = false; // Allow sort
        $this->udate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['udate'] = &$this->udate;

        // annual_interest
        $this->annual_interest = new DbField(
            'buyer_config_asset_schedule',
            'buyer_config_asset_schedule',
            'x_annual_interest',
            'annual_interest',
            '`annual_interest`',
            '`annual_interest`',
            4,
            12,
            -1,
            false,
            '`annual_interest`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->annual_interest->InputTextType = "text";
        $this->annual_interest->Sortable = false; // Allow sort
        $this->annual_interest->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['annual_interest'] = &$this->annual_interest;

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
        if ($this->getCurrentMasterTable() == "buyer_asset") {
            if ($this->asset_id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
            if ($this->member_id->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
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
        if ($this->getCurrentMasterTable() == "buyer_asset") {
            if ($this->asset_id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`asset_id`", $this->asset_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
            } else {
                return "";
            }
            if ($this->member_id->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("`member_id`", $this->member_id->getSessionValue(), DATATYPE_NUMBER, "juzmatch1");
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
            case "buyer_asset":
                $key = $keys["asset_id"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->asset_id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
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
                    return "`asset_id`=" . QuotedValue($keys["asset_id"], $masterTable->asset_id->DataType, $masterTable->Dbid) . " AND `member_id`=" . QuotedValue($keys["member_id"], $masterTable->member_id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "buyer_asset":
                return "`asset_id`=" . QuotedValue($masterTable->asset_id->DbValue, $this->asset_id->DataType, $this->Dbid) . " AND `member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "buyer_asset_schedule") {
            $detailUrl = Container("buyer_asset_schedule")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "buyerconfigassetschedulelist";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`buyer_config_asset_schedule`";
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
            $this->buyer_config_asset_schedule_id->setDbValue($conn->lastInsertId());
            $rs['buyer_config_asset_schedule_id'] = $this->buyer_config_asset_schedule_id->DbValue;
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
        // Cascade Update detail table 'buyer_asset_schedule'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['member_id']) && $rsold['member_id'] != $rs['member_id'])) { // Update detail field 'member_id'
            $cascadeUpdate = true;
            $rscascade['member_id'] = $rs['member_id'];
        }
        if ($rsold && (isset($rs['asset_id']) && $rsold['asset_id'] != $rs['asset_id'])) { // Update detail field 'asset_id'
            $cascadeUpdate = true;
            $rscascade['asset_id'] = $rs['asset_id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("buyer_asset_schedule")->loadRs("`member_id` = " . QuotedValue($rsold['member_id'], DATATYPE_NUMBER, 'DB') . " AND " . "`asset_id` = " . QuotedValue($rsold['asset_id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'buyer_asset_schedule_id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("buyer_asset_schedule")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("buyer_asset_schedule")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("buyer_asset_schedule")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'buyer_config_asset_schedule_id';
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
            if (array_key_exists('buyer_config_asset_schedule_id', $rs)) {
                AddFilter($where, QuotedName('buyer_config_asset_schedule_id', $this->Dbid) . '=' . QuotedValue($rs['buyer_config_asset_schedule_id'], $this->buyer_config_asset_schedule_id->DataType, $this->Dbid));
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

        // Cascade delete detail table 'buyer_asset_schedule'
        $dtlrows = Container("buyer_asset_schedule")->loadRs("`member_id` = " . QuotedValue($rs['member_id'], DATATYPE_NUMBER, "DB") . " AND " . "`asset_id` = " . QuotedValue($rs['asset_id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("buyer_asset_schedule")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("buyer_asset_schedule")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("buyer_asset_schedule")->rowDeleted($dtlrow);
            }
        }
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
        $this->buyer_config_asset_schedule_id->DbValue = $row['buyer_config_asset_schedule_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->asset_id->DbValue = $row['asset_id'];
        $this->installment_all->DbValue = $row['installment_all'];
        $this->installment_price_per->DbValue = $row['installment_price_per'];
        $this->date_start_installment->DbValue = $row['date_start_installment'];
        $this->status_approve->DbValue = $row['status_approve'];
        $this->asset_price->DbValue = $row['asset_price'];
        $this->booking_price->DbValue = $row['booking_price'];
        $this->down_price->DbValue = $row['down_price'];
        $this->move_in_on_20th->DbValue = $row['move_in_on_20th'];
        $this->number_days_pay_first_month->DbValue = $row['number_days_pay_first_month'];
        $this->number_days_in_first_month->DbValue = $row['number_days_in_first_month'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->udate->DbValue = $row['udate'];
        $this->annual_interest->DbValue = $row['annual_interest'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`buyer_config_asset_schedule_id` = @buyer_config_asset_schedule_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->buyer_config_asset_schedule_id->CurrentValue : $this->buyer_config_asset_schedule_id->OldValue;
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
                $this->buyer_config_asset_schedule_id->CurrentValue = $keys[0];
            } else {
                $this->buyer_config_asset_schedule_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('buyer_config_asset_schedule_id', $row) ? $row['buyer_config_asset_schedule_id'] : null;
        } else {
            $val = $this->buyer_config_asset_schedule_id->OldValue !== null ? $this->buyer_config_asset_schedule_id->OldValue : $this->buyer_config_asset_schedule_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@buyer_config_asset_schedule_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("buyerconfigassetschedulelist");
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
        if ($pageName == "buyerconfigassetscheduleview") {
            return $Language->phrase("View");
        } elseif ($pageName == "buyerconfigassetscheduleedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "buyerconfigassetscheduleadd") {
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
                return "BuyerConfigAssetScheduleView";
            case Config("API_ADD_ACTION"):
                return "BuyerConfigAssetScheduleAdd";
            case Config("API_EDIT_ACTION"):
                return "BuyerConfigAssetScheduleEdit";
            case Config("API_DELETE_ACTION"):
                return "BuyerConfigAssetScheduleDelete";
            case Config("API_LIST_ACTION"):
                return "BuyerConfigAssetScheduleList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "buyerconfigassetschedulelist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("buyerconfigassetscheduleview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyerconfigassetscheduleview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "buyerconfigassetscheduleadd?" . $this->getUrlParm($parm);
        } else {
            $url = "buyerconfigassetscheduleadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("buyerconfigassetscheduleedit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyerconfigassetscheduleedit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        if ($parm != "") {
            $url = $this->keyUrl("buyerconfigassetscheduleadd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("buyerconfigassetscheduleadd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        return $this->keyUrl("buyerconfigassetscheduledelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "buyer_asset" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_asset_id", $this->asset_id->CurrentValue);
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"buyer_config_asset_schedule_id\":" . JsonEncode($this->buyer_config_asset_schedule_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->buyer_config_asset_schedule_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->buyer_config_asset_schedule_id->CurrentValue);
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
            if (($keyValue = Param("buyer_config_asset_schedule_id") ?? Route("buyer_config_asset_schedule_id")) !== null) {
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
                $this->buyer_config_asset_schedule_id->CurrentValue = $key;
            } else {
                $this->buyer_config_asset_schedule_id->OldValue = $key;
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
        $this->buyer_config_asset_schedule_id->setDbValue($row['buyer_config_asset_schedule_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->installment_all->setDbValue($row['installment_all']);
        $this->installment_price_per->setDbValue($row['installment_price_per']);
        $this->date_start_installment->setDbValue($row['date_start_installment']);
        $this->status_approve->setDbValue($row['status_approve']);
        $this->asset_price->setDbValue($row['asset_price']);
        $this->booking_price->setDbValue($row['booking_price']);
        $this->down_price->setDbValue($row['down_price']);
        $this->move_in_on_20th->setDbValue($row['move_in_on_20th']);
        $this->number_days_pay_first_month->setDbValue($row['number_days_pay_first_month']);
        $this->number_days_in_first_month->setDbValue($row['number_days_in_first_month']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->annual_interest->setDbValue($row['annual_interest']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // asset_id

        // installment_all

        // installment_price_per

        // date_start_installment

        // status_approve
        $this->status_approve->CellCssStyle = "white-space: nowrap;";

        // asset_price

        // booking_price

        // down_price

        // move_in_on_20th

        // number_days_pay_first_month

        // number_days_in_first_month

        // cdate

        // cuser
        $this->cuser->CellCssStyle = "white-space: nowrap;";

        // cip
        $this->cip->CellCssStyle = "white-space: nowrap;";

        // uuser
        $this->uuser->CellCssStyle = "white-space: nowrap;";

        // uip
        $this->uip->CellCssStyle = "white-space: nowrap;";

        // udate
        $this->udate->CellCssStyle = "white-space: nowrap;";

        // annual_interest
        $this->annual_interest->CellCssStyle = "white-space: nowrap;";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->ViewValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->ViewCustomAttributes = "";

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

        // asset_id
        $curVal = strval($this->asset_id->CurrentValue);
        if ($curVal != "") {
            $this->asset_id->ViewValue = $this->asset_id->lookupCacheOption($curVal);
            if ($this->asset_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`asset_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->asset_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                    $this->asset_id->ViewValue = $this->asset_id->displayValue($arwrk);
                } else {
                    $this->asset_id->ViewValue = FormatNumber($this->asset_id->CurrentValue, $this->asset_id->formatPattern());
                }
            }
        } else {
            $this->asset_id->ViewValue = null;
        }
        $this->asset_id->ViewCustomAttributes = "";

        // installment_all
        $this->installment_all->ViewValue = $this->installment_all->CurrentValue;
        $this->installment_all->ViewValue = FormatNumber($this->installment_all->ViewValue, $this->installment_all->formatPattern());
        $this->installment_all->ViewCustomAttributes = "";

        // installment_price_per
        $this->installment_price_per->ViewValue = $this->installment_price_per->CurrentValue;
        $this->installment_price_per->ViewValue = FormatCurrency($this->installment_price_per->ViewValue, $this->installment_price_per->formatPattern());
        $this->installment_price_per->ViewCustomAttributes = "";

        // date_start_installment
        $this->date_start_installment->ViewValue = $this->date_start_installment->CurrentValue;
        $this->date_start_installment->ViewValue = FormatDateTime($this->date_start_installment->ViewValue, $this->date_start_installment->formatPattern());
        $this->date_start_installment->ViewCustomAttributes = "";

        // status_approve
        if (strval($this->status_approve->CurrentValue) != "") {
            $this->status_approve->ViewValue = $this->status_approve->optionCaption($this->status_approve->CurrentValue);
        } else {
            $this->status_approve->ViewValue = null;
        }
        $this->status_approve->ViewCustomAttributes = "";

        // asset_price
        $this->asset_price->ViewValue = $this->asset_price->CurrentValue;
        $this->asset_price->ViewValue = FormatNumber($this->asset_price->ViewValue, $this->asset_price->formatPattern());
        $this->asset_price->ViewCustomAttributes = "";

        // booking_price
        $this->booking_price->ViewValue = $this->booking_price->CurrentValue;
        $this->booking_price->ViewValue = FormatNumber($this->booking_price->ViewValue, $this->booking_price->formatPattern());
        $this->booking_price->ViewCustomAttributes = "";

        // down_price
        $this->down_price->ViewValue = $this->down_price->CurrentValue;
        $this->down_price->ViewValue = FormatNumber($this->down_price->ViewValue, $this->down_price->formatPattern());
        $this->down_price->ViewCustomAttributes = "";

        // move_in_on_20th
        if (ConvertToBool($this->move_in_on_20th->CurrentValue)) {
            $this->move_in_on_20th->ViewValue = $this->move_in_on_20th->tagCaption(1) != "" ? $this->move_in_on_20th->tagCaption(1) : "Yes";
        } else {
            $this->move_in_on_20th->ViewValue = $this->move_in_on_20th->tagCaption(2) != "" ? $this->move_in_on_20th->tagCaption(2) : "No";
        }
        $this->move_in_on_20th->ViewCustomAttributes = "";

        // number_days_pay_first_month
        $this->number_days_pay_first_month->ViewValue = $this->number_days_pay_first_month->CurrentValue;
        $this->number_days_pay_first_month->ViewValue = FormatNumber($this->number_days_pay_first_month->ViewValue, $this->number_days_pay_first_month->formatPattern());
        $this->number_days_pay_first_month->ViewCustomAttributes = "";

        // number_days_in_first_month
        $this->number_days_in_first_month->ViewValue = $this->number_days_in_first_month->CurrentValue;
        $this->number_days_in_first_month->ViewValue = FormatNumber($this->number_days_in_first_month->ViewValue, $this->number_days_in_first_month->formatPattern());
        $this->number_days_in_first_month->ViewCustomAttributes = "";

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

        // annual_interest
        $this->annual_interest->ViewValue = $this->annual_interest->CurrentValue;
        $this->annual_interest->ViewValue = FormatNumber($this->annual_interest->ViewValue, $this->annual_interest->formatPattern());
        $this->annual_interest->ViewCustomAttributes = "";

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->LinkCustomAttributes = "";
        $this->buyer_config_asset_schedule_id->HrefValue = "";
        $this->buyer_config_asset_schedule_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // asset_id
        $this->asset_id->LinkCustomAttributes = "";
        $this->asset_id->HrefValue = "";
        $this->asset_id->TooltipValue = "";

        // installment_all
        $this->installment_all->LinkCustomAttributes = "";
        $this->installment_all->HrefValue = "";
        $this->installment_all->TooltipValue = "";

        // installment_price_per
        $this->installment_price_per->LinkCustomAttributes = "";
        $this->installment_price_per->HrefValue = "";
        $this->installment_price_per->TooltipValue = "";

        // date_start_installment
        $this->date_start_installment->LinkCustomAttributes = "";
        $this->date_start_installment->HrefValue = "";
        $this->date_start_installment->TooltipValue = "";

        // status_approve
        $this->status_approve->LinkCustomAttributes = "";
        $this->status_approve->HrefValue = "";
        $this->status_approve->TooltipValue = "";

        // asset_price
        $this->asset_price->LinkCustomAttributes = "";
        $this->asset_price->HrefValue = "";
        $this->asset_price->TooltipValue = "";

        // booking_price
        $this->booking_price->LinkCustomAttributes = "";
        $this->booking_price->HrefValue = "";
        $this->booking_price->TooltipValue = "";

        // down_price
        $this->down_price->LinkCustomAttributes = "";
        $this->down_price->HrefValue = "";
        $this->down_price->TooltipValue = "";

        // move_in_on_20th
        $this->move_in_on_20th->LinkCustomAttributes = "";
        $this->move_in_on_20th->HrefValue = "";
        $this->move_in_on_20th->TooltipValue = "";

        // number_days_pay_first_month
        $this->number_days_pay_first_month->LinkCustomAttributes = "";
        $this->number_days_pay_first_month->HrefValue = "";
        $this->number_days_pay_first_month->TooltipValue = "";

        // number_days_in_first_month
        $this->number_days_in_first_month->LinkCustomAttributes = "";
        $this->number_days_in_first_month->HrefValue = "";
        $this->number_days_in_first_month->TooltipValue = "";

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

        // annual_interest
        $this->annual_interest->LinkCustomAttributes = "";
        $this->annual_interest->HrefValue = "";
        $this->annual_interest->TooltipValue = "";

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

        // buyer_config_asset_schedule_id
        $this->buyer_config_asset_schedule_id->setupEditAttributes();
        $this->buyer_config_asset_schedule_id->EditCustomAttributes = "";
        $this->buyer_config_asset_schedule_id->EditValue = $this->buyer_config_asset_schedule_id->CurrentValue;
        $this->buyer_config_asset_schedule_id->ViewCustomAttributes = "";

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

        // asset_id
        $this->asset_id->setupEditAttributes();
        $this->asset_id->EditCustomAttributes = "";
        $curVal = strval($this->asset_id->CurrentValue);
        if ($curVal != "") {
            $this->asset_id->EditValue = $this->asset_id->lookupCacheOption($curVal);
            if ($this->asset_id->EditValue === null) { // Lookup from database
                $filterWrk = "`asset_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->asset_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->asset_id->Lookup->renderViewRow($rswrk[0]);
                    $this->asset_id->EditValue = $this->asset_id->displayValue($arwrk);
                } else {
                    $this->asset_id->EditValue = FormatNumber($this->asset_id->CurrentValue, $this->asset_id->formatPattern());
                }
            }
        } else {
            $this->asset_id->EditValue = null;
        }
        $this->asset_id->ViewCustomAttributes = "";

        // installment_all
        $this->installment_all->setupEditAttributes();
        $this->installment_all->EditCustomAttributes = "";
        $this->installment_all->EditValue = $this->installment_all->CurrentValue;
        $this->installment_all->PlaceHolder = RemoveHtml($this->installment_all->caption());
        if (strval($this->installment_all->EditValue) != "" && is_numeric($this->installment_all->EditValue)) {
            $this->installment_all->EditValue = FormatNumber($this->installment_all->EditValue, null);
        }

        // installment_price_per
        $this->installment_price_per->setupEditAttributes();
        $this->installment_price_per->EditCustomAttributes = "";
        $this->installment_price_per->EditValue = $this->installment_price_per->CurrentValue;
        $this->installment_price_per->PlaceHolder = RemoveHtml($this->installment_price_per->caption());
        if (strval($this->installment_price_per->EditValue) != "" && is_numeric($this->installment_price_per->EditValue)) {
            $this->installment_price_per->EditValue = FormatNumber($this->installment_price_per->EditValue, null);
        }

        // date_start_installment
        $this->date_start_installment->setupEditAttributes();
        $this->date_start_installment->EditCustomAttributes = "";
        $this->date_start_installment->EditValue = FormatDateTime($this->date_start_installment->CurrentValue, $this->date_start_installment->formatPattern());
        $this->date_start_installment->PlaceHolder = RemoveHtml($this->date_start_installment->caption());

        // status_approve
        $this->status_approve->setupEditAttributes();
        $this->status_approve->EditCustomAttributes = "";
        $this->status_approve->EditValue = $this->status_approve->options(true);
        $this->status_approve->PlaceHolder = RemoveHtml($this->status_approve->caption());

        // asset_price
        $this->asset_price->setupEditAttributes();
        $this->asset_price->EditCustomAttributes = "";
        $this->asset_price->EditValue = $this->asset_price->CurrentValue;
        $this->asset_price->PlaceHolder = RemoveHtml($this->asset_price->caption());
        if (strval($this->asset_price->EditValue) != "" && is_numeric($this->asset_price->EditValue)) {
            $this->asset_price->EditValue = FormatNumber($this->asset_price->EditValue, null);
        }

        // booking_price
        $this->booking_price->setupEditAttributes();
        $this->booking_price->EditCustomAttributes = "";
        $this->booking_price->EditValue = $this->booking_price->CurrentValue;
        $this->booking_price->PlaceHolder = RemoveHtml($this->booking_price->caption());
        if (strval($this->booking_price->EditValue) != "" && is_numeric($this->booking_price->EditValue)) {
            $this->booking_price->EditValue = FormatNumber($this->booking_price->EditValue, null);
        }

        // down_price
        $this->down_price->setupEditAttributes();
        $this->down_price->EditCustomAttributes = "";
        $this->down_price->EditValue = $this->down_price->CurrentValue;
        $this->down_price->PlaceHolder = RemoveHtml($this->down_price->caption());
        if (strval($this->down_price->EditValue) != "" && is_numeric($this->down_price->EditValue)) {
            $this->down_price->EditValue = FormatNumber($this->down_price->EditValue, null);
        }

        // move_in_on_20th
        $this->move_in_on_20th->EditCustomAttributes = "";
        $this->move_in_on_20th->EditValue = $this->move_in_on_20th->options(false);
        $this->move_in_on_20th->PlaceHolder = RemoveHtml($this->move_in_on_20th->caption());

        // number_days_pay_first_month
        $this->number_days_pay_first_month->setupEditAttributes();
        $this->number_days_pay_first_month->EditCustomAttributes = "";
        $this->number_days_pay_first_month->EditValue = $this->number_days_pay_first_month->CurrentValue;
        $this->number_days_pay_first_month->PlaceHolder = RemoveHtml($this->number_days_pay_first_month->caption());
        if (strval($this->number_days_pay_first_month->EditValue) != "" && is_numeric($this->number_days_pay_first_month->EditValue)) {
            $this->number_days_pay_first_month->EditValue = FormatNumber($this->number_days_pay_first_month->EditValue, null);
        }

        // number_days_in_first_month
        $this->number_days_in_first_month->setupEditAttributes();
        $this->number_days_in_first_month->EditCustomAttributes = "";
        $this->number_days_in_first_month->EditValue = $this->number_days_in_first_month->CurrentValue;
        $this->number_days_in_first_month->PlaceHolder = RemoveHtml($this->number_days_in_first_month->caption());
        if (strval($this->number_days_in_first_month->EditValue) != "" && is_numeric($this->number_days_in_first_month->EditValue)) {
            $this->number_days_in_first_month->EditValue = FormatNumber($this->number_days_in_first_month->EditValue, null);
        }

        // cdate

        // cuser

        // cip

        // uuser

        // uip

        // udate

        // annual_interest
        $this->annual_interest->setupEditAttributes();
        $this->annual_interest->EditCustomAttributes = "";
        $this->annual_interest->EditValue = $this->annual_interest->CurrentValue;
        $this->annual_interest->PlaceHolder = RemoveHtml($this->annual_interest->caption());
        if (strval($this->annual_interest->EditValue) != "" && is_numeric($this->annual_interest->EditValue)) {
            $this->annual_interest->EditValue = FormatNumber($this->annual_interest->EditValue, null);
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
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->installment_all);
                    $doc->exportCaption($this->installment_price_per);
                    $doc->exportCaption($this->date_start_installment);
                    $doc->exportCaption($this->asset_price);
                    $doc->exportCaption($this->booking_price);
                    $doc->exportCaption($this->down_price);
                    $doc->exportCaption($this->move_in_on_20th);
                    $doc->exportCaption($this->number_days_pay_first_month);
                    $doc->exportCaption($this->number_days_in_first_month);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->asset_id);
                    $doc->exportCaption($this->installment_all);
                    $doc->exportCaption($this->installment_price_per);
                    $doc->exportCaption($this->date_start_installment);
                    $doc->exportCaption($this->status_approve);
                    $doc->exportCaption($this->asset_price);
                    $doc->exportCaption($this->booking_price);
                    $doc->exportCaption($this->down_price);
                    $doc->exportCaption($this->move_in_on_20th);
                    $doc->exportCaption($this->number_days_pay_first_month);
                    $doc->exportCaption($this->number_days_in_first_month);
                    $doc->exportCaption($this->cdate);
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
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->installment_all);
                        $doc->exportField($this->installment_price_per);
                        $doc->exportField($this->date_start_installment);
                        $doc->exportField($this->asset_price);
                        $doc->exportField($this->booking_price);
                        $doc->exportField($this->down_price);
                        $doc->exportField($this->move_in_on_20th);
                        $doc->exportField($this->number_days_pay_first_month);
                        $doc->exportField($this->number_days_in_first_month);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->asset_id);
                        $doc->exportField($this->installment_all);
                        $doc->exportField($this->installment_price_per);
                        $doc->exportField($this->date_start_installment);
                        $doc->exportField($this->status_approve);
                        $doc->exportField($this->asset_price);
                        $doc->exportField($this->booking_price);
                        $doc->exportField($this->down_price);
                        $doc->exportField($this->move_in_on_20th);
                        $doc->exportField($this->number_days_pay_first_month);
                        $doc->exportField($this->number_days_in_first_month);
                        $doc->exportField($this->cdate);
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
        $table = 'buyer_config_asset_schedule';
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
        $table = 'buyer_config_asset_schedule';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['buyer_config_asset_schedule_id'];

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
        $table = 'buyer_config_asset_schedule';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['buyer_config_asset_schedule_id'];

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
        $table = 'buyer_config_asset_schedule';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['buyer_config_asset_schedule_id'];

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
