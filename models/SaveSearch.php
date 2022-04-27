<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for save_search
 */
class SaveSearch extends DbTable
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
    public $save_search_id;
    public $member_id;
    public $search_text;
    public $category_id;
    public $brand_id;
    public $min_installment;
    public $max_installment;
    public $min_down;
    public $max_down;
    public $min_price;
    public $max_price;
    public $min_size;
    public $max_size;
    public $usable_area_min;
    public $usable_area_max;
    public $land_size_area_min;
    public $land_size_area_max;
    public $yer_installment_max;
    public $bedroom;
    public $latitude;
    public $longitude;
    public $group_type;
    public $sort_id;
    public $cdate;
    public $cuser;
    public $cip;
    public $uuser;
    public $uip;
    public $udate;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'save_search';
        $this->TableName = 'save_search';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`save_search`";
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

        // save_search_id
        $this->save_search_id = new DbField(
            'save_search',
            'save_search',
            'x_save_search_id',
            'save_search_id',
            '`save_search_id`',
            '`save_search_id`',
            3,
            11,
            -1,
            false,
            '`save_search_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->save_search_id->InputTextType = "text";
        $this->save_search_id->IsAutoIncrement = true; // Autoincrement field
        $this->save_search_id->IsPrimaryKey = true; // Primary key field
        $this->save_search_id->Sortable = false; // Allow sort
        $this->save_search_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['save_search_id'] = &$this->save_search_id;

        // member_id
        $this->member_id = new DbField(
            'save_search',
            'save_search',
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
        $this->member_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->member_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->member_id->Lookup = new Lookup('member_id', 'member', false, 'member_id', ["first_name","last_name","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`first_name`, ''),'" . ValueSeparator(1, $this->member_id) . "',COALESCE(`last_name`,''))");
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

        // search_text
        $this->search_text = new DbField(
            'save_search',
            'save_search',
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

        // category_id
        $this->category_id = new DbField(
            'save_search',
            'save_search',
            'x_category_id',
            'category_id',
            '`category_id`',
            '`category_id`',
            200,
            100,
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
        $this->category_id->Lookup = new Lookup('category_id', 'category', false, 'category_id', ["category_name","","",""], [], [], [], [], [], [], '`category_name` ASC', '', "`category_name`");
        $this->Fields['category_id'] = &$this->category_id;

        // brand_id
        $this->brand_id = new DbField(
            'save_search',
            'save_search',
            'x_brand_id',
            'brand_id',
            '`brand_id`',
            '`brand_id`',
            200,
            50,
            -1,
            false,
            '`brand_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->brand_id->InputTextType = "text";
        $this->brand_id->Lookup = new Lookup('brand_id', 'brand', false, 'brand_id', ["brand_name","","",""], [], [], [], [], [], [], '', '', "`brand_name`");
        $this->Fields['brand_id'] = &$this->brand_id;

        // min_installment
        $this->min_installment = new DbField(
            'save_search',
            'save_search',
            'x_min_installment',
            'min_installment',
            '`min_installment`',
            '`min_installment`',
            200,
            50,
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
        $this->Fields['min_installment'] = &$this->min_installment;

        // max_installment
        $this->max_installment = new DbField(
            'save_search',
            'save_search',
            'x_max_installment',
            'max_installment',
            '`max_installment`',
            '`max_installment`',
            200,
            50,
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
        $this->Fields['max_installment'] = &$this->max_installment;

        // min_down
        $this->min_down = new DbField(
            'save_search',
            'save_search',
            'x_min_down',
            'min_down',
            '`min_down`',
            '`min_down`',
            200,
            50,
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
        $this->Fields['min_down'] = &$this->min_down;

        // max_down
        $this->max_down = new DbField(
            'save_search',
            'save_search',
            'x_max_down',
            'max_down',
            '`max_down`',
            '`max_down`',
            200,
            50,
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
        $this->Fields['max_down'] = &$this->max_down;

        // min_price
        $this->min_price = new DbField(
            'save_search',
            'save_search',
            'x_min_price',
            'min_price',
            '`min_price`',
            '`min_price`',
            200,
            50,
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
        $this->Fields['min_price'] = &$this->min_price;

        // max_price
        $this->max_price = new DbField(
            'save_search',
            'save_search',
            'x_max_price',
            'max_price',
            '`max_price`',
            '`max_price`',
            200,
            50,
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
        $this->Fields['max_price'] = &$this->max_price;

        // min_size
        $this->min_size = new DbField(
            'save_search',
            'save_search',
            'x_min_size',
            'min_size',
            '`min_size`',
            '`min_size`',
            200,
            50,
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
        $this->min_size->Sortable = false; // Allow sort
        $this->Fields['min_size'] = &$this->min_size;

        // max_size
        $this->max_size = new DbField(
            'save_search',
            'save_search',
            'x_max_size',
            'max_size',
            '`max_size`',
            '`max_size`',
            200,
            50,
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
        $this->max_size->Sortable = false; // Allow sort
        $this->Fields['max_size'] = &$this->max_size;

        // usable_area_min
        $this->usable_area_min = new DbField(
            'save_search',
            'save_search',
            'x_usable_area_min',
            'usable_area_min',
            '`usable_area_min`',
            '`usable_area_min`',
            200,
            50,
            -1,
            false,
            '`usable_area_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->usable_area_min->InputTextType = "text";
        $this->Fields['usable_area_min'] = &$this->usable_area_min;

        // usable_area_max
        $this->usable_area_max = new DbField(
            'save_search',
            'save_search',
            'x_usable_area_max',
            'usable_area_max',
            '`usable_area_max`',
            '`usable_area_max`',
            200,
            100,
            -1,
            false,
            '`usable_area_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->usable_area_max->InputTextType = "text";
        $this->Fields['usable_area_max'] = &$this->usable_area_max;

        // land_size_area_min
        $this->land_size_area_min = new DbField(
            'save_search',
            'save_search',
            'x_land_size_area_min',
            'land_size_area_min',
            '`land_size_area_min`',
            '`land_size_area_min`',
            200,
            50,
            -1,
            false,
            '`land_size_area_min`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->land_size_area_min->InputTextType = "text";
        $this->Fields['land_size_area_min'] = &$this->land_size_area_min;

        // land_size_area_max
        $this->land_size_area_max = new DbField(
            'save_search',
            'save_search',
            'x_land_size_area_max',
            'land_size_area_max',
            '`land_size_area_max`',
            '`land_size_area_max`',
            200,
            100,
            -1,
            false,
            '`land_size_area_max`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->land_size_area_max->InputTextType = "text";
        $this->Fields['land_size_area_max'] = &$this->land_size_area_max;

        // yer_installment_max
        $this->yer_installment_max = new DbField(
            'save_search',
            'save_search',
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
        $this->yer_installment_max->Sortable = false; // Allow sort
        $this->yer_installment_max->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['yer_installment_max'] = &$this->yer_installment_max;

        // bedroom
        $this->bedroom = new DbField(
            'save_search',
            'save_search',
            'x_bedroom',
            'bedroom',
            '`bedroom`',
            '`bedroom`',
            3,
            11,
            -1,
            false,
            '`bedroom`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->bedroom->InputTextType = "text";
        $this->bedroom->Lookup = new Lookup('bedroom', 'save_search', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->bedroom->OptionCount = 4;
        $this->bedroom->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['bedroom'] = &$this->bedroom;

        // latitude
        $this->latitude = new DbField(
            'save_search',
            'save_search',
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
            'save_search',
            'save_search',
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

        // group_type
        $this->group_type = new DbField(
            'save_search',
            'save_search',
            'x_group_type',
            'group_type',
            '`group_type`',
            '`group_type`',
            200,
            50,
            -1,
            false,
            '`group_type`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->group_type->InputTextType = "text";
        $this->group_type->Nullable = false; // NOT NULL field
        $this->group_type->Required = true; // Required field
        $this->group_type->Sortable = false; // Allow sort
        $this->Fields['group_type'] = &$this->group_type;

        // sort_id
        $this->sort_id = new DbField(
            'save_search',
            'save_search',
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
        $this->sort_id->Sortable = false; // Allow sort
        $this->sort_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['sort_id'] = &$this->sort_id;

        // cdate
        $this->cdate = new DbField(
            'save_search',
            'save_search',
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
            'save_search',
            'save_search',
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
            'save_search',
            'save_search',
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
            'save_search',
            'save_search',
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
        $this->uuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['uuser'] = &$this->uuser;

        // uip
        $this->uip = new DbField(
            'save_search',
            'save_search',
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
            'save_search',
            'save_search',
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
        if ($this->getCurrentMasterTable() == "buyer") {
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
        if ($this->getCurrentMasterTable() == "buyer") {
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
            case "buyer":
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
            case "buyer":
                return "`member_id`=" . QuotedValue($masterTable->member_id->DbValue, $this->member_id->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`save_search`";
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
            $this->save_search_id->setDbValue($conn->lastInsertId());
            $rs['save_search_id'] = $this->save_search_id->DbValue;
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
            $fldname = 'save_search_id';
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
            if (array_key_exists('save_search_id', $rs)) {
                AddFilter($where, QuotedName('save_search_id', $this->Dbid) . '=' . QuotedValue($rs['save_search_id'], $this->save_search_id->DataType, $this->Dbid));
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
        $this->save_search_id->DbValue = $row['save_search_id'];
        $this->member_id->DbValue = $row['member_id'];
        $this->search_text->DbValue = $row['search_text'];
        $this->category_id->DbValue = $row['category_id'];
        $this->brand_id->DbValue = $row['brand_id'];
        $this->min_installment->DbValue = $row['min_installment'];
        $this->max_installment->DbValue = $row['max_installment'];
        $this->min_down->DbValue = $row['min_down'];
        $this->max_down->DbValue = $row['max_down'];
        $this->min_price->DbValue = $row['min_price'];
        $this->max_price->DbValue = $row['max_price'];
        $this->min_size->DbValue = $row['min_size'];
        $this->max_size->DbValue = $row['max_size'];
        $this->usable_area_min->DbValue = $row['usable_area_min'];
        $this->usable_area_max->DbValue = $row['usable_area_max'];
        $this->land_size_area_min->DbValue = $row['land_size_area_min'];
        $this->land_size_area_max->DbValue = $row['land_size_area_max'];
        $this->yer_installment_max->DbValue = $row['yer_installment_max'];
        $this->bedroom->DbValue = $row['bedroom'];
        $this->latitude->DbValue = $row['latitude'];
        $this->longitude->DbValue = $row['longitude'];
        $this->group_type->DbValue = $row['group_type'];
        $this->sort_id->DbValue = $row['sort_id'];
        $this->cdate->DbValue = $row['cdate'];
        $this->cuser->DbValue = $row['cuser'];
        $this->cip->DbValue = $row['cip'];
        $this->uuser->DbValue = $row['uuser'];
        $this->uip->DbValue = $row['uip'];
        $this->udate->DbValue = $row['udate'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`save_search_id` = @save_search_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->save_search_id->CurrentValue : $this->save_search_id->OldValue;
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
                $this->save_search_id->CurrentValue = $keys[0];
            } else {
                $this->save_search_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('save_search_id', $row) ? $row['save_search_id'] : null;
        } else {
            $val = $this->save_search_id->OldValue !== null ? $this->save_search_id->OldValue : $this->save_search_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@save_search_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("savesearchlist");
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
        if ($pageName == "savesearchview") {
            return $Language->phrase("View");
        } elseif ($pageName == "savesearchedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "savesearchadd") {
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
                return "SaveSearchView";
            case Config("API_ADD_ACTION"):
                return "SaveSearchAdd";
            case Config("API_EDIT_ACTION"):
                return "SaveSearchEdit";
            case Config("API_DELETE_ACTION"):
                return "SaveSearchDelete";
            case Config("API_LIST_ACTION"):
                return "SaveSearchList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "savesearchlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("savesearchview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("savesearchview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "savesearchadd?" . $this->getUrlParm($parm);
        } else {
            $url = "savesearchadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("savesearchedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("savesearchadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("savesearchdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "buyer" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_member_id", $this->member_id->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"save_search_id\":" . JsonEncode($this->save_search_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->save_search_id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->save_search_id->CurrentValue);
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
            if (($keyValue = Param("save_search_id") ?? Route("save_search_id")) !== null) {
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
                $this->save_search_id->CurrentValue = $key;
            } else {
                $this->save_search_id->OldValue = $key;
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
        $this->save_search_id->setDbValue($row['save_search_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->search_text->setDbValue($row['search_text']);
        $this->category_id->setDbValue($row['category_id']);
        $this->brand_id->setDbValue($row['brand_id']);
        $this->min_installment->setDbValue($row['min_installment']);
        $this->max_installment->setDbValue($row['max_installment']);
        $this->min_down->setDbValue($row['min_down']);
        $this->max_down->setDbValue($row['max_down']);
        $this->min_price->setDbValue($row['min_price']);
        $this->max_price->setDbValue($row['max_price']);
        $this->min_size->setDbValue($row['min_size']);
        $this->max_size->setDbValue($row['max_size']);
        $this->usable_area_min->setDbValue($row['usable_area_min']);
        $this->usable_area_max->setDbValue($row['usable_area_max']);
        $this->land_size_area_min->setDbValue($row['land_size_area_min']);
        $this->land_size_area_max->setDbValue($row['land_size_area_max']);
        $this->yer_installment_max->setDbValue($row['yer_installment_max']);
        $this->bedroom->setDbValue($row['bedroom']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->group_type->setDbValue($row['group_type']);
        $this->sort_id->setDbValue($row['sort_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // save_search_id
        $this->save_search_id->CellCssStyle = "white-space: nowrap;";

        // member_id

        // search_text

        // category_id

        // brand_id

        // min_installment

        // max_installment

        // min_down

        // max_down

        // min_price

        // max_price

        // min_size
        $this->min_size->CellCssStyle = "white-space: nowrap;";

        // max_size
        $this->max_size->CellCssStyle = "white-space: nowrap;";

        // usable_area_min

        // usable_area_max

        // land_size_area_min

        // land_size_area_max

        // yer_installment_max
        $this->yer_installment_max->CellCssStyle = "white-space: nowrap;";

        // bedroom

        // latitude

        // longitude

        // group_type
        $this->group_type->CellCssStyle = "white-space: nowrap;";

        // sort_id

        // cdate

        // cuser

        // cip

        // uuser

        // uip

        // udate

        // save_search_id
        $this->save_search_id->ViewValue = $this->save_search_id->CurrentValue;
        $this->save_search_id->ViewCustomAttributes = "";

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

        // search_text
        $this->search_text->ViewValue = $this->search_text->CurrentValue;
        $this->search_text->ViewCustomAttributes = "";

        // category_id
        $this->category_id->ViewValue = $this->category_id->CurrentValue;
        $curVal = strval($this->category_id->CurrentValue);
        if ($curVal != "") {
            $this->category_id->ViewValue = $this->category_id->lookupCacheOption($curVal);
            if ($this->category_id->ViewValue === null) { // Lookup from database
                $filterWrk = "`category_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`isactive`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->category_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->category_id->Lookup->renderViewRow($rswrk[0]);
                    $this->category_id->ViewValue = $this->category_id->displayValue($arwrk);
                } else {
                    $this->category_id->ViewValue = $this->category_id->CurrentValue;
                }
            }
        } else {
            $this->category_id->ViewValue = null;
        }
        $this->category_id->ViewCustomAttributes = "";

        // brand_id
        $curVal = strval($this->brand_id->CurrentValue);
        if ($curVal != "") {
            $this->brand_id->ViewValue = $this->brand_id->lookupCacheOption($curVal);
            if ($this->brand_id->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`brand_id`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`isactive`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->brand_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->brand_id->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->brand_id->Lookup->renderViewRow($row);
                        $this->brand_id->ViewValue->add($this->brand_id->displayValue($arwrk));
                    }
                } else {
                    $this->brand_id->ViewValue = $this->brand_id->CurrentValue;
                }
            }
        } else {
            $this->brand_id->ViewValue = null;
        }
        $this->brand_id->ViewCustomAttributes = "";

        // min_installment
        $this->min_installment->ViewValue = $this->min_installment->CurrentValue;
        $this->min_installment->ViewCustomAttributes = "";

        // max_installment
        $this->max_installment->ViewValue = $this->max_installment->CurrentValue;
        $this->max_installment->ViewCustomAttributes = "";

        // min_down
        $this->min_down->ViewValue = $this->min_down->CurrentValue;
        $this->min_down->ViewCustomAttributes = "";

        // max_down
        $this->max_down->ViewValue = $this->max_down->CurrentValue;
        $this->max_down->ViewCustomAttributes = "";

        // min_price
        $this->min_price->ViewValue = $this->min_price->CurrentValue;
        $this->min_price->ViewCustomAttributes = "";

        // max_price
        $this->max_price->ViewValue = $this->max_price->CurrentValue;
        $this->max_price->ViewCustomAttributes = "";

        // min_size
        $this->min_size->ViewValue = $this->min_size->CurrentValue;
        $this->min_size->ViewCustomAttributes = "";

        // max_size
        $this->max_size->ViewValue = $this->max_size->CurrentValue;
        $this->max_size->ViewCustomAttributes = "";

        // usable_area_min
        $this->usable_area_min->ViewValue = $this->usable_area_min->CurrentValue;
        $this->usable_area_min->ViewCustomAttributes = "";

        // usable_area_max
        $this->usable_area_max->ViewValue = $this->usable_area_max->CurrentValue;
        $this->usable_area_max->ViewCustomAttributes = "";

        // land_size_area_min
        $this->land_size_area_min->ViewValue = $this->land_size_area_min->CurrentValue;
        $this->land_size_area_min->ViewCustomAttributes = "";

        // land_size_area_max
        $this->land_size_area_max->ViewValue = $this->land_size_area_max->CurrentValue;
        $this->land_size_area_max->ViewCustomAttributes = "";

        // yer_installment_max
        $this->yer_installment_max->ViewValue = $this->yer_installment_max->CurrentValue;
        $this->yer_installment_max->ViewValue = FormatNumber($this->yer_installment_max->ViewValue, $this->yer_installment_max->formatPattern());
        $this->yer_installment_max->ViewCustomAttributes = "";

        // bedroom
        if (strval($this->bedroom->CurrentValue) != "") {
            $this->bedroom->ViewValue = new OptionValues();
            $arwrk = explode(",", strval($this->bedroom->CurrentValue));
            $cnt = count($arwrk);
            for ($ari = 0; $ari < $cnt; $ari++)
                $this->bedroom->ViewValue->add($this->bedroom->optionCaption(trim($arwrk[$ari])));
        } else {
            $this->bedroom->ViewValue = null;
        }
        $this->bedroom->ViewCustomAttributes = "";

        // latitude
        $this->latitude->ViewValue = $this->latitude->CurrentValue;
        $this->latitude->ViewValue = FormatNumber($this->latitude->ViewValue, $this->latitude->formatPattern());
        $this->latitude->ViewCustomAttributes = "";

        // longitude
        $this->longitude->ViewValue = $this->longitude->CurrentValue;
        $this->longitude->ViewValue = FormatNumber($this->longitude->ViewValue, $this->longitude->formatPattern());
        $this->longitude->ViewCustomAttributes = "";

        // group_type
        $this->group_type->ViewValue = $this->group_type->CurrentValue;
        $this->group_type->ViewCustomAttributes = "";

        // sort_id
        $this->sort_id->ViewValue = $this->sort_id->CurrentValue;
        $this->sort_id->ViewValue = FormatNumber($this->sort_id->ViewValue, $this->sort_id->formatPattern());
        $this->sort_id->ViewCustomAttributes = "";

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

        // save_search_id
        $this->save_search_id->LinkCustomAttributes = "";
        $this->save_search_id->HrefValue = "";
        $this->save_search_id->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

        // search_text
        $this->search_text->LinkCustomAttributes = "";
        $this->search_text->HrefValue = "";
        $this->search_text->TooltipValue = "";

        // category_id
        $this->category_id->LinkCustomAttributes = "";
        $this->category_id->HrefValue = "";
        $this->category_id->TooltipValue = "";

        // brand_id
        $this->brand_id->LinkCustomAttributes = "";
        $this->brand_id->HrefValue = "";
        $this->brand_id->TooltipValue = "";

        // min_installment
        $this->min_installment->LinkCustomAttributes = "";
        $this->min_installment->HrefValue = "";
        $this->min_installment->TooltipValue = "";

        // max_installment
        $this->max_installment->LinkCustomAttributes = "";
        $this->max_installment->HrefValue = "";
        $this->max_installment->TooltipValue = "";

        // min_down
        $this->min_down->LinkCustomAttributes = "";
        $this->min_down->HrefValue = "";
        $this->min_down->TooltipValue = "";

        // max_down
        $this->max_down->LinkCustomAttributes = "";
        $this->max_down->HrefValue = "";
        $this->max_down->TooltipValue = "";

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

        // usable_area_min
        $this->usable_area_min->LinkCustomAttributes = "";
        $this->usable_area_min->HrefValue = "";
        $this->usable_area_min->TooltipValue = "";

        // usable_area_max
        $this->usable_area_max->LinkCustomAttributes = "";
        $this->usable_area_max->HrefValue = "";
        $this->usable_area_max->TooltipValue = "";

        // land_size_area_min
        $this->land_size_area_min->LinkCustomAttributes = "";
        $this->land_size_area_min->HrefValue = "";
        $this->land_size_area_min->TooltipValue = "";

        // land_size_area_max
        $this->land_size_area_max->LinkCustomAttributes = "";
        $this->land_size_area_max->HrefValue = "";
        $this->land_size_area_max->TooltipValue = "";

        // yer_installment_max
        $this->yer_installment_max->LinkCustomAttributes = "";
        $this->yer_installment_max->HrefValue = "";
        $this->yer_installment_max->TooltipValue = "";

        // bedroom
        $this->bedroom->LinkCustomAttributes = "";
        $this->bedroom->HrefValue = "";
        $this->bedroom->TooltipValue = "";

        // latitude
        $this->latitude->LinkCustomAttributes = "";
        $this->latitude->HrefValue = "";
        $this->latitude->TooltipValue = "";

        // longitude
        $this->longitude->LinkCustomAttributes = "";
        $this->longitude->HrefValue = "";
        $this->longitude->TooltipValue = "";

        // group_type
        $this->group_type->LinkCustomAttributes = "";
        $this->group_type->HrefValue = "";
        $this->group_type->TooltipValue = "";

        // sort_id
        $this->sort_id->LinkCustomAttributes = "";
        $this->sort_id->HrefValue = "";
        $this->sort_id->TooltipValue = "";

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

        // save_search_id
        $this->save_search_id->setupEditAttributes();
        $this->save_search_id->EditCustomAttributes = "";
        $this->save_search_id->EditValue = $this->save_search_id->CurrentValue;
        $this->save_search_id->ViewCustomAttributes = "";

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

        // search_text
        $this->search_text->setupEditAttributes();
        $this->search_text->EditCustomAttributes = "";
        $this->search_text->EditValue = $this->search_text->CurrentValue;
        $this->search_text->PlaceHolder = RemoveHtml($this->search_text->caption());

        // category_id
        $this->category_id->setupEditAttributes();
        $this->category_id->EditCustomAttributes = "";
        if (!$this->category_id->Raw) {
            $this->category_id->CurrentValue = HtmlDecode($this->category_id->CurrentValue);
        }
        $this->category_id->EditValue = $this->category_id->CurrentValue;
        $this->category_id->PlaceHolder = RemoveHtml($this->category_id->caption());

        // brand_id
        $this->brand_id->EditCustomAttributes = "";
        $this->brand_id->PlaceHolder = RemoveHtml($this->brand_id->caption());

        // min_installment
        $this->min_installment->setupEditAttributes();
        $this->min_installment->EditCustomAttributes = "";
        if (!$this->min_installment->Raw) {
            $this->min_installment->CurrentValue = HtmlDecode($this->min_installment->CurrentValue);
        }
        $this->min_installment->EditValue = $this->min_installment->CurrentValue;
        $this->min_installment->PlaceHolder = RemoveHtml($this->min_installment->caption());

        // max_installment
        $this->max_installment->setupEditAttributes();
        $this->max_installment->EditCustomAttributes = "";
        if (!$this->max_installment->Raw) {
            $this->max_installment->CurrentValue = HtmlDecode($this->max_installment->CurrentValue);
        }
        $this->max_installment->EditValue = $this->max_installment->CurrentValue;
        $this->max_installment->PlaceHolder = RemoveHtml($this->max_installment->caption());

        // min_down
        $this->min_down->setupEditAttributes();
        $this->min_down->EditCustomAttributes = "";
        if (!$this->min_down->Raw) {
            $this->min_down->CurrentValue = HtmlDecode($this->min_down->CurrentValue);
        }
        $this->min_down->EditValue = $this->min_down->CurrentValue;
        $this->min_down->PlaceHolder = RemoveHtml($this->min_down->caption());

        // max_down
        $this->max_down->setupEditAttributes();
        $this->max_down->EditCustomAttributes = "";
        if (!$this->max_down->Raw) {
            $this->max_down->CurrentValue = HtmlDecode($this->max_down->CurrentValue);
        }
        $this->max_down->EditValue = $this->max_down->CurrentValue;
        $this->max_down->PlaceHolder = RemoveHtml($this->max_down->caption());

        // min_price
        $this->min_price->setupEditAttributes();
        $this->min_price->EditCustomAttributes = "";
        if (!$this->min_price->Raw) {
            $this->min_price->CurrentValue = HtmlDecode($this->min_price->CurrentValue);
        }
        $this->min_price->EditValue = $this->min_price->CurrentValue;
        $this->min_price->PlaceHolder = RemoveHtml($this->min_price->caption());

        // max_price
        $this->max_price->setupEditAttributes();
        $this->max_price->EditCustomAttributes = "";
        if (!$this->max_price->Raw) {
            $this->max_price->CurrentValue = HtmlDecode($this->max_price->CurrentValue);
        }
        $this->max_price->EditValue = $this->max_price->CurrentValue;
        $this->max_price->PlaceHolder = RemoveHtml($this->max_price->caption());

        // min_size
        $this->min_size->setupEditAttributes();
        $this->min_size->EditCustomAttributes = "";
        if (!$this->min_size->Raw) {
            $this->min_size->CurrentValue = HtmlDecode($this->min_size->CurrentValue);
        }
        $this->min_size->EditValue = $this->min_size->CurrentValue;
        $this->min_size->PlaceHolder = RemoveHtml($this->min_size->caption());

        // max_size
        $this->max_size->setupEditAttributes();
        $this->max_size->EditCustomAttributes = "";
        if (!$this->max_size->Raw) {
            $this->max_size->CurrentValue = HtmlDecode($this->max_size->CurrentValue);
        }
        $this->max_size->EditValue = $this->max_size->CurrentValue;
        $this->max_size->PlaceHolder = RemoveHtml($this->max_size->caption());

        // usable_area_min
        $this->usable_area_min->setupEditAttributes();
        $this->usable_area_min->EditCustomAttributes = "";
        if (!$this->usable_area_min->Raw) {
            $this->usable_area_min->CurrentValue = HtmlDecode($this->usable_area_min->CurrentValue);
        }
        $this->usable_area_min->EditValue = $this->usable_area_min->CurrentValue;
        $this->usable_area_min->PlaceHolder = RemoveHtml($this->usable_area_min->caption());

        // usable_area_max
        $this->usable_area_max->setupEditAttributes();
        $this->usable_area_max->EditCustomAttributes = "";
        if (!$this->usable_area_max->Raw) {
            $this->usable_area_max->CurrentValue = HtmlDecode($this->usable_area_max->CurrentValue);
        }
        $this->usable_area_max->EditValue = $this->usable_area_max->CurrentValue;
        $this->usable_area_max->PlaceHolder = RemoveHtml($this->usable_area_max->caption());

        // land_size_area_min
        $this->land_size_area_min->setupEditAttributes();
        $this->land_size_area_min->EditCustomAttributes = "";
        if (!$this->land_size_area_min->Raw) {
            $this->land_size_area_min->CurrentValue = HtmlDecode($this->land_size_area_min->CurrentValue);
        }
        $this->land_size_area_min->EditValue = $this->land_size_area_min->CurrentValue;
        $this->land_size_area_min->PlaceHolder = RemoveHtml($this->land_size_area_min->caption());

        // land_size_area_max
        $this->land_size_area_max->setupEditAttributes();
        $this->land_size_area_max->EditCustomAttributes = "";
        if (!$this->land_size_area_max->Raw) {
            $this->land_size_area_max->CurrentValue = HtmlDecode($this->land_size_area_max->CurrentValue);
        }
        $this->land_size_area_max->EditValue = $this->land_size_area_max->CurrentValue;
        $this->land_size_area_max->PlaceHolder = RemoveHtml($this->land_size_area_max->caption());

        // yer_installment_max
        $this->yer_installment_max->setupEditAttributes();
        $this->yer_installment_max->EditCustomAttributes = "";
        $this->yer_installment_max->EditValue = $this->yer_installment_max->CurrentValue;
        $this->yer_installment_max->PlaceHolder = RemoveHtml($this->yer_installment_max->caption());
        if (strval($this->yer_installment_max->EditValue) != "" && is_numeric($this->yer_installment_max->EditValue)) {
            $this->yer_installment_max->EditValue = FormatNumber($this->yer_installment_max->EditValue, null);
        }

        // bedroom
        $this->bedroom->EditCustomAttributes = "";
        $this->bedroom->EditValue = $this->bedroom->options(false);
        $this->bedroom->PlaceHolder = RemoveHtml($this->bedroom->caption());

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

        // group_type
        $this->group_type->setupEditAttributes();
        $this->group_type->EditCustomAttributes = "";
        if (!$this->group_type->Raw) {
            $this->group_type->CurrentValue = HtmlDecode($this->group_type->CurrentValue);
        }
        $this->group_type->EditValue = $this->group_type->CurrentValue;
        $this->group_type->PlaceHolder = RemoveHtml($this->group_type->caption());

        // sort_id
        $this->sort_id->setupEditAttributes();
        $this->sort_id->EditCustomAttributes = "";
        $this->sort_id->EditValue = $this->sort_id->CurrentValue;
        $this->sort_id->PlaceHolder = RemoveHtml($this->sort_id->caption());
        if (strval($this->sort_id->EditValue) != "" && is_numeric($this->sort_id->EditValue)) {
            $this->sort_id->EditValue = FormatNumber($this->sort_id->EditValue, null);
        }

        // cdate

        // cuser

        // cip

        // uuser

        // uip

        // udate

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
                    $doc->exportCaption($this->search_text);
                    $doc->exportCaption($this->category_id);
                    $doc->exportCaption($this->brand_id);
                    $doc->exportCaption($this->min_installment);
                    $doc->exportCaption($this->max_installment);
                    $doc->exportCaption($this->min_down);
                    $doc->exportCaption($this->max_down);
                    $doc->exportCaption($this->min_price);
                    $doc->exportCaption($this->max_price);
                    $doc->exportCaption($this->usable_area_min);
                    $doc->exportCaption($this->usable_area_max);
                    $doc->exportCaption($this->land_size_area_min);
                    $doc->exportCaption($this->land_size_area_max);
                    $doc->exportCaption($this->bedroom);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->cdate);
                } else {
                    $doc->exportCaption($this->member_id);
                    $doc->exportCaption($this->category_id);
                    $doc->exportCaption($this->brand_id);
                    $doc->exportCaption($this->min_installment);
                    $doc->exportCaption($this->max_installment);
                    $doc->exportCaption($this->min_down);
                    $doc->exportCaption($this->max_down);
                    $doc->exportCaption($this->min_price);
                    $doc->exportCaption($this->max_price);
                    $doc->exportCaption($this->usable_area_min);
                    $doc->exportCaption($this->usable_area_max);
                    $doc->exportCaption($this->land_size_area_min);
                    $doc->exportCaption($this->land_size_area_max);
                    $doc->exportCaption($this->bedroom);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->cdate);
                    $doc->exportCaption($this->cuser);
                    $doc->exportCaption($this->cip);
                    $doc->exportCaption($this->uuser);
                    $doc->exportCaption($this->uip);
                    $doc->exportCaption($this->udate);
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
                        $doc->exportField($this->search_text);
                        $doc->exportField($this->category_id);
                        $doc->exportField($this->brand_id);
                        $doc->exportField($this->min_installment);
                        $doc->exportField($this->max_installment);
                        $doc->exportField($this->min_down);
                        $doc->exportField($this->max_down);
                        $doc->exportField($this->min_price);
                        $doc->exportField($this->max_price);
                        $doc->exportField($this->usable_area_min);
                        $doc->exportField($this->usable_area_max);
                        $doc->exportField($this->land_size_area_min);
                        $doc->exportField($this->land_size_area_max);
                        $doc->exportField($this->bedroom);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->cdate);
                    } else {
                        $doc->exportField($this->member_id);
                        $doc->exportField($this->category_id);
                        $doc->exportField($this->brand_id);
                        $doc->exportField($this->min_installment);
                        $doc->exportField($this->max_installment);
                        $doc->exportField($this->min_down);
                        $doc->exportField($this->max_down);
                        $doc->exportField($this->min_price);
                        $doc->exportField($this->max_price);
                        $doc->exportField($this->usable_area_min);
                        $doc->exportField($this->usable_area_max);
                        $doc->exportField($this->land_size_area_min);
                        $doc->exportField($this->land_size_area_max);
                        $doc->exportField($this->bedroom);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->cdate);
                        $doc->exportField($this->cuser);
                        $doc->exportField($this->cip);
                        $doc->exportField($this->uuser);
                        $doc->exportField($this->uip);
                        $doc->exportField($this->udate);
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
        $table = 'save_search';
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
        $table = 'save_search';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['save_search_id'];

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
        $table = 'save_search';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['save_search_id'];

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
        $table = 'save_search';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['save_search_id'];

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
