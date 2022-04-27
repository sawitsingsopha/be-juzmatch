<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for peak_contact
 */
class PeakContact extends DbTable
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
    public $contact_id;
    public $contact_code;
    public $contact_name;
    public $contact_type;
    public $contact_taxnumber;
    public $contact_branchcode;
    public $contact_address;
    public $contact_subdistrict;
    public $contact_district;
    public $contact_province;
    public $contact_country;
    public $contact_postcode;
    public $contact_callcenternumber;
    public $contact_faxnumber;
    public $contact_email;
    public $contact_website;
    public $contact_contactfirstname;
    public $contact_contactlastname;
    public $contact_contactnickname;
    public $contact_contactpostition;
    public $contact_contactphonenumber;
    public $contact_contactcontactemail;
    public $contact_purchaseaccount;
    public $contact_sellaccount;
    public $member_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'peak_contact';
        $this->TableName = 'peak_contact';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`peak_contact`";
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
            'peak_contact',
            'peak_contact',
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
            'peak_contact',
            'peak_contact',
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
            'peak_contact',
            'peak_contact',
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
            'peak_contact',
            'peak_contact',
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
            'peak_contact',
            'peak_contact',
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

        // contact_id
        $this->contact_id = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_id',
            'contact_id',
            '`contact_id`',
            '`contact_id`',
            200,
            250,
            -1,
            false,
            '`contact_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_id->InputTextType = "text";
        $this->Fields['contact_id'] = &$this->contact_id;

        // contact_code
        $this->contact_code = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_code',
            'contact_code',
            '`contact_code`',
            '`contact_code`',
            200,
            250,
            -1,
            false,
            '`contact_code`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_code->InputTextType = "text";
        $this->Fields['contact_code'] = &$this->contact_code;

        // contact_name
        $this->contact_name = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_name',
            'contact_name',
            '`contact_name`',
            '`contact_name`',
            200,
            250,
            -1,
            false,
            '`contact_name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_name->InputTextType = "text";
        $this->Fields['contact_name'] = &$this->contact_name;

        // contact_type
        $this->contact_type = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_type',
            'contact_type',
            '`contact_type`',
            '`contact_type`',
            3,
            11,
            -1,
            false,
            '`contact_type`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_type->InputTextType = "text";
        $this->contact_type->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['contact_type'] = &$this->contact_type;

        // contact_taxnumber
        $this->contact_taxnumber = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_taxnumber',
            'contact_taxnumber',
            '`contact_taxnumber`',
            '`contact_taxnumber`',
            200,
            250,
            -1,
            false,
            '`contact_taxnumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_taxnumber->InputTextType = "text";
        $this->Fields['contact_taxnumber'] = &$this->contact_taxnumber;

        // contact_branchcode
        $this->contact_branchcode = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_branchcode',
            'contact_branchcode',
            '`contact_branchcode`',
            '`contact_branchcode`',
            200,
            250,
            -1,
            false,
            '`contact_branchcode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_branchcode->InputTextType = "text";
        $this->Fields['contact_branchcode'] = &$this->contact_branchcode;

        // contact_address
        $this->contact_address = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_address',
            'contact_address',
            '`contact_address`',
            '`contact_address`',
            200,
            250,
            -1,
            false,
            '`contact_address`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_address->InputTextType = "text";
        $this->Fields['contact_address'] = &$this->contact_address;

        // contact_subdistrict
        $this->contact_subdistrict = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_subdistrict',
            'contact_subdistrict',
            '`contact_subdistrict`',
            '`contact_subdistrict`',
            200,
            250,
            -1,
            false,
            '`contact_subdistrict`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_subdistrict->InputTextType = "text";
        $this->Fields['contact_subdistrict'] = &$this->contact_subdistrict;

        // contact_district
        $this->contact_district = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_district',
            'contact_district',
            '`contact_district`',
            '`contact_district`',
            200,
            250,
            -1,
            false,
            '`contact_district`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_district->InputTextType = "text";
        $this->Fields['contact_district'] = &$this->contact_district;

        // contact_province
        $this->contact_province = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_province',
            'contact_province',
            '`contact_province`',
            '`contact_province`',
            200,
            250,
            -1,
            false,
            '`contact_province`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_province->InputTextType = "text";
        $this->Fields['contact_province'] = &$this->contact_province;

        // contact_country
        $this->contact_country = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_country',
            'contact_country',
            '`contact_country`',
            '`contact_country`',
            200,
            250,
            -1,
            false,
            '`contact_country`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_country->InputTextType = "text";
        $this->Fields['contact_country'] = &$this->contact_country;

        // contact_postcode
        $this->contact_postcode = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_postcode',
            'contact_postcode',
            '`contact_postcode`',
            '`contact_postcode`',
            200,
            250,
            -1,
            false,
            '`contact_postcode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_postcode->InputTextType = "text";
        $this->Fields['contact_postcode'] = &$this->contact_postcode;

        // contact_callcenternumber
        $this->contact_callcenternumber = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_callcenternumber',
            'contact_callcenternumber',
            '`contact_callcenternumber`',
            '`contact_callcenternumber`',
            200,
            250,
            -1,
            false,
            '`contact_callcenternumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_callcenternumber->InputTextType = "text";
        $this->Fields['contact_callcenternumber'] = &$this->contact_callcenternumber;

        // contact_faxnumber
        $this->contact_faxnumber = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_faxnumber',
            'contact_faxnumber',
            '`contact_faxnumber`',
            '`contact_faxnumber`',
            200,
            250,
            -1,
            false,
            '`contact_faxnumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_faxnumber->InputTextType = "text";
        $this->Fields['contact_faxnumber'] = &$this->contact_faxnumber;

        // contact_email
        $this->contact_email = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_email',
            'contact_email',
            '`contact_email`',
            '`contact_email`',
            200,
            250,
            -1,
            false,
            '`contact_email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_email->InputTextType = "text";
        $this->Fields['contact_email'] = &$this->contact_email;

        // contact_website
        $this->contact_website = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_website',
            'contact_website',
            '`contact_website`',
            '`contact_website`',
            200,
            250,
            -1,
            false,
            '`contact_website`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_website->InputTextType = "text";
        $this->Fields['contact_website'] = &$this->contact_website;

        // contact_contactfirstname
        $this->contact_contactfirstname = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_contactfirstname',
            'contact_contactfirstname',
            '`contact_contactfirstname`',
            '`contact_contactfirstname`',
            200,
            250,
            -1,
            false,
            '`contact_contactfirstname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_contactfirstname->InputTextType = "text";
        $this->Fields['contact_contactfirstname'] = &$this->contact_contactfirstname;

        // contact_contactlastname
        $this->contact_contactlastname = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_contactlastname',
            'contact_contactlastname',
            '`contact_contactlastname`',
            '`contact_contactlastname`',
            200,
            250,
            -1,
            false,
            '`contact_contactlastname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_contactlastname->InputTextType = "text";
        $this->Fields['contact_contactlastname'] = &$this->contact_contactlastname;

        // contact_contactnickname
        $this->contact_contactnickname = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_contactnickname',
            'contact_contactnickname',
            '`contact_contactnickname`',
            '`contact_contactnickname`',
            200,
            250,
            -1,
            false,
            '`contact_contactnickname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_contactnickname->InputTextType = "text";
        $this->Fields['contact_contactnickname'] = &$this->contact_contactnickname;

        // contact_contactpostition
        $this->contact_contactpostition = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_contactpostition',
            'contact_contactpostition',
            '`contact_contactpostition`',
            '`contact_contactpostition`',
            200,
            250,
            -1,
            false,
            '`contact_contactpostition`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_contactpostition->InputTextType = "text";
        $this->Fields['contact_contactpostition'] = &$this->contact_contactpostition;

        // contact_contactphonenumber
        $this->contact_contactphonenumber = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_contactphonenumber',
            'contact_contactphonenumber',
            '`contact_contactphonenumber`',
            '`contact_contactphonenumber`',
            200,
            250,
            -1,
            false,
            '`contact_contactphonenumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_contactphonenumber->InputTextType = "text";
        $this->Fields['contact_contactphonenumber'] = &$this->contact_contactphonenumber;

        // contact_contactcontactemail
        $this->contact_contactcontactemail = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_contactcontactemail',
            'contact_contactcontactemail',
            '`contact_contactcontactemail`',
            '`contact_contactcontactemail`',
            200,
            250,
            -1,
            false,
            '`contact_contactcontactemail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_contactcontactemail->InputTextType = "text";
        $this->Fields['contact_contactcontactemail'] = &$this->contact_contactcontactemail;

        // contact_purchaseaccount
        $this->contact_purchaseaccount = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_purchaseaccount',
            'contact_purchaseaccount',
            '`contact_purchaseaccount`',
            '`contact_purchaseaccount`',
            200,
            250,
            -1,
            false,
            '`contact_purchaseaccount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_purchaseaccount->InputTextType = "text";
        $this->Fields['contact_purchaseaccount'] = &$this->contact_purchaseaccount;

        // contact_sellaccount
        $this->contact_sellaccount = new DbField(
            'peak_contact',
            'peak_contact',
            'x_contact_sellaccount',
            'contact_sellaccount',
            '`contact_sellaccount`',
            '`contact_sellaccount`',
            200,
            250,
            -1,
            false,
            '`contact_sellaccount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contact_sellaccount->InputTextType = "text";
        $this->Fields['contact_sellaccount'] = &$this->contact_sellaccount;

        // member_id
        $this->member_id = new DbField(
            'peak_contact',
            'peak_contact',
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
        $this->member_id->Nullable = false; // NOT NULL field
        $this->member_id->Required = true; // Required field
        $this->member_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['member_id'] = &$this->member_id;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`peak_contact`";
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
        $this->contact_id->DbValue = $row['contact_id'];
        $this->contact_code->DbValue = $row['contact_code'];
        $this->contact_name->DbValue = $row['contact_name'];
        $this->contact_type->DbValue = $row['contact_type'];
        $this->contact_taxnumber->DbValue = $row['contact_taxnumber'];
        $this->contact_branchcode->DbValue = $row['contact_branchcode'];
        $this->contact_address->DbValue = $row['contact_address'];
        $this->contact_subdistrict->DbValue = $row['contact_subdistrict'];
        $this->contact_district->DbValue = $row['contact_district'];
        $this->contact_province->DbValue = $row['contact_province'];
        $this->contact_country->DbValue = $row['contact_country'];
        $this->contact_postcode->DbValue = $row['contact_postcode'];
        $this->contact_callcenternumber->DbValue = $row['contact_callcenternumber'];
        $this->contact_faxnumber->DbValue = $row['contact_faxnumber'];
        $this->contact_email->DbValue = $row['contact_email'];
        $this->contact_website->DbValue = $row['contact_website'];
        $this->contact_contactfirstname->DbValue = $row['contact_contactfirstname'];
        $this->contact_contactlastname->DbValue = $row['contact_contactlastname'];
        $this->contact_contactnickname->DbValue = $row['contact_contactnickname'];
        $this->contact_contactpostition->DbValue = $row['contact_contactpostition'];
        $this->contact_contactphonenumber->DbValue = $row['contact_contactphonenumber'];
        $this->contact_contactcontactemail->DbValue = $row['contact_contactcontactemail'];
        $this->contact_purchaseaccount->DbValue = $row['contact_purchaseaccount'];
        $this->contact_sellaccount->DbValue = $row['contact_sellaccount'];
        $this->member_id->DbValue = $row['member_id'];
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
        return $_SESSION[$name] ?? GetUrl("peakcontactlist");
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
        if ($pageName == "peakcontactview") {
            return $Language->phrase("View");
        } elseif ($pageName == "peakcontactedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "peakcontactadd") {
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
                return "PeakContactView";
            case Config("API_ADD_ACTION"):
                return "PeakContactAdd";
            case Config("API_EDIT_ACTION"):
                return "PeakContactEdit";
            case Config("API_DELETE_ACTION"):
                return "PeakContactDelete";
            case Config("API_LIST_ACTION"):
                return "PeakContactList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "peakcontactlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("peakcontactview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("peakcontactview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "peakcontactadd?" . $this->getUrlParm($parm);
        } else {
            $url = "peakcontactadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("peakcontactedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("peakcontactadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("peakcontactdelete", $this->getUrlParm());
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
        $this->contact_id->setDbValue($row['contact_id']);
        $this->contact_code->setDbValue($row['contact_code']);
        $this->contact_name->setDbValue($row['contact_name']);
        $this->contact_type->setDbValue($row['contact_type']);
        $this->contact_taxnumber->setDbValue($row['contact_taxnumber']);
        $this->contact_branchcode->setDbValue($row['contact_branchcode']);
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_subdistrict->setDbValue($row['contact_subdistrict']);
        $this->contact_district->setDbValue($row['contact_district']);
        $this->contact_province->setDbValue($row['contact_province']);
        $this->contact_country->setDbValue($row['contact_country']);
        $this->contact_postcode->setDbValue($row['contact_postcode']);
        $this->contact_callcenternumber->setDbValue($row['contact_callcenternumber']);
        $this->contact_faxnumber->setDbValue($row['contact_faxnumber']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_website->setDbValue($row['contact_website']);
        $this->contact_contactfirstname->setDbValue($row['contact_contactfirstname']);
        $this->contact_contactlastname->setDbValue($row['contact_contactlastname']);
        $this->contact_contactnickname->setDbValue($row['contact_contactnickname']);
        $this->contact_contactpostition->setDbValue($row['contact_contactpostition']);
        $this->contact_contactphonenumber->setDbValue($row['contact_contactphonenumber']);
        $this->contact_contactcontactemail->setDbValue($row['contact_contactcontactemail']);
        $this->contact_purchaseaccount->setDbValue($row['contact_purchaseaccount']);
        $this->contact_sellaccount->setDbValue($row['contact_sellaccount']);
        $this->member_id->setDbValue($row['member_id']);
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

        // contact_id

        // contact_code

        // contact_name

        // contact_type

        // contact_taxnumber

        // contact_branchcode

        // contact_address

        // contact_subdistrict

        // contact_district

        // contact_province

        // contact_country

        // contact_postcode

        // contact_callcenternumber

        // contact_faxnumber

        // contact_email

        // contact_website

        // contact_contactfirstname

        // contact_contactlastname

        // contact_contactnickname

        // contact_contactpostition

        // contact_contactphonenumber

        // contact_contactcontactemail

        // contact_purchaseaccount

        // contact_sellaccount

        // member_id

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

        // contact_id
        $this->contact_id->ViewValue = $this->contact_id->CurrentValue;
        $this->contact_id->ViewCustomAttributes = "";

        // contact_code
        $this->contact_code->ViewValue = $this->contact_code->CurrentValue;
        $this->contact_code->ViewCustomAttributes = "";

        // contact_name
        $this->contact_name->ViewValue = $this->contact_name->CurrentValue;
        $this->contact_name->ViewCustomAttributes = "";

        // contact_type
        $this->contact_type->ViewValue = $this->contact_type->CurrentValue;
        $this->contact_type->ViewValue = FormatNumber($this->contact_type->ViewValue, $this->contact_type->formatPattern());
        $this->contact_type->ViewCustomAttributes = "";

        // contact_taxnumber
        $this->contact_taxnumber->ViewValue = $this->contact_taxnumber->CurrentValue;
        $this->contact_taxnumber->ViewCustomAttributes = "";

        // contact_branchcode
        $this->contact_branchcode->ViewValue = $this->contact_branchcode->CurrentValue;
        $this->contact_branchcode->ViewCustomAttributes = "";

        // contact_address
        $this->contact_address->ViewValue = $this->contact_address->CurrentValue;
        $this->contact_address->ViewCustomAttributes = "";

        // contact_subdistrict
        $this->contact_subdistrict->ViewValue = $this->contact_subdistrict->CurrentValue;
        $this->contact_subdistrict->ViewCustomAttributes = "";

        // contact_district
        $this->contact_district->ViewValue = $this->contact_district->CurrentValue;
        $this->contact_district->ViewCustomAttributes = "";

        // contact_province
        $this->contact_province->ViewValue = $this->contact_province->CurrentValue;
        $this->contact_province->ViewCustomAttributes = "";

        // contact_country
        $this->contact_country->ViewValue = $this->contact_country->CurrentValue;
        $this->contact_country->ViewCustomAttributes = "";

        // contact_postcode
        $this->contact_postcode->ViewValue = $this->contact_postcode->CurrentValue;
        $this->contact_postcode->ViewCustomAttributes = "";

        // contact_callcenternumber
        $this->contact_callcenternumber->ViewValue = $this->contact_callcenternumber->CurrentValue;
        $this->contact_callcenternumber->ViewCustomAttributes = "";

        // contact_faxnumber
        $this->contact_faxnumber->ViewValue = $this->contact_faxnumber->CurrentValue;
        $this->contact_faxnumber->ViewCustomAttributes = "";

        // contact_email
        $this->contact_email->ViewValue = $this->contact_email->CurrentValue;
        $this->contact_email->ViewCustomAttributes = "";

        // contact_website
        $this->contact_website->ViewValue = $this->contact_website->CurrentValue;
        $this->contact_website->ViewCustomAttributes = "";

        // contact_contactfirstname
        $this->contact_contactfirstname->ViewValue = $this->contact_contactfirstname->CurrentValue;
        $this->contact_contactfirstname->ViewCustomAttributes = "";

        // contact_contactlastname
        $this->contact_contactlastname->ViewValue = $this->contact_contactlastname->CurrentValue;
        $this->contact_contactlastname->ViewCustomAttributes = "";

        // contact_contactnickname
        $this->contact_contactnickname->ViewValue = $this->contact_contactnickname->CurrentValue;
        $this->contact_contactnickname->ViewCustomAttributes = "";

        // contact_contactpostition
        $this->contact_contactpostition->ViewValue = $this->contact_contactpostition->CurrentValue;
        $this->contact_contactpostition->ViewCustomAttributes = "";

        // contact_contactphonenumber
        $this->contact_contactphonenumber->ViewValue = $this->contact_contactphonenumber->CurrentValue;
        $this->contact_contactphonenumber->ViewCustomAttributes = "";

        // contact_contactcontactemail
        $this->contact_contactcontactemail->ViewValue = $this->contact_contactcontactemail->CurrentValue;
        $this->contact_contactcontactemail->ViewCustomAttributes = "";

        // contact_purchaseaccount
        $this->contact_purchaseaccount->ViewValue = $this->contact_purchaseaccount->CurrentValue;
        $this->contact_purchaseaccount->ViewCustomAttributes = "";

        // contact_sellaccount
        $this->contact_sellaccount->ViewValue = $this->contact_sellaccount->CurrentValue;
        $this->contact_sellaccount->ViewCustomAttributes = "";

        // member_id
        $this->member_id->ViewValue = $this->member_id->CurrentValue;
        $this->member_id->ViewValue = FormatNumber($this->member_id->ViewValue, $this->member_id->formatPattern());
        $this->member_id->ViewCustomAttributes = "";

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

        // contact_id
        $this->contact_id->LinkCustomAttributes = "";
        $this->contact_id->HrefValue = "";
        $this->contact_id->TooltipValue = "";

        // contact_code
        $this->contact_code->LinkCustomAttributes = "";
        $this->contact_code->HrefValue = "";
        $this->contact_code->TooltipValue = "";

        // contact_name
        $this->contact_name->LinkCustomAttributes = "";
        $this->contact_name->HrefValue = "";
        $this->contact_name->TooltipValue = "";

        // contact_type
        $this->contact_type->LinkCustomAttributes = "";
        $this->contact_type->HrefValue = "";
        $this->contact_type->TooltipValue = "";

        // contact_taxnumber
        $this->contact_taxnumber->LinkCustomAttributes = "";
        $this->contact_taxnumber->HrefValue = "";
        $this->contact_taxnumber->TooltipValue = "";

        // contact_branchcode
        $this->contact_branchcode->LinkCustomAttributes = "";
        $this->contact_branchcode->HrefValue = "";
        $this->contact_branchcode->TooltipValue = "";

        // contact_address
        $this->contact_address->LinkCustomAttributes = "";
        $this->contact_address->HrefValue = "";
        $this->contact_address->TooltipValue = "";

        // contact_subdistrict
        $this->contact_subdistrict->LinkCustomAttributes = "";
        $this->contact_subdistrict->HrefValue = "";
        $this->contact_subdistrict->TooltipValue = "";

        // contact_district
        $this->contact_district->LinkCustomAttributes = "";
        $this->contact_district->HrefValue = "";
        $this->contact_district->TooltipValue = "";

        // contact_province
        $this->contact_province->LinkCustomAttributes = "";
        $this->contact_province->HrefValue = "";
        $this->contact_province->TooltipValue = "";

        // contact_country
        $this->contact_country->LinkCustomAttributes = "";
        $this->contact_country->HrefValue = "";
        $this->contact_country->TooltipValue = "";

        // contact_postcode
        $this->contact_postcode->LinkCustomAttributes = "";
        $this->contact_postcode->HrefValue = "";
        $this->contact_postcode->TooltipValue = "";

        // contact_callcenternumber
        $this->contact_callcenternumber->LinkCustomAttributes = "";
        $this->contact_callcenternumber->HrefValue = "";
        $this->contact_callcenternumber->TooltipValue = "";

        // contact_faxnumber
        $this->contact_faxnumber->LinkCustomAttributes = "";
        $this->contact_faxnumber->HrefValue = "";
        $this->contact_faxnumber->TooltipValue = "";

        // contact_email
        $this->contact_email->LinkCustomAttributes = "";
        $this->contact_email->HrefValue = "";
        $this->contact_email->TooltipValue = "";

        // contact_website
        $this->contact_website->LinkCustomAttributes = "";
        $this->contact_website->HrefValue = "";
        $this->contact_website->TooltipValue = "";

        // contact_contactfirstname
        $this->contact_contactfirstname->LinkCustomAttributes = "";
        $this->contact_contactfirstname->HrefValue = "";
        $this->contact_contactfirstname->TooltipValue = "";

        // contact_contactlastname
        $this->contact_contactlastname->LinkCustomAttributes = "";
        $this->contact_contactlastname->HrefValue = "";
        $this->contact_contactlastname->TooltipValue = "";

        // contact_contactnickname
        $this->contact_contactnickname->LinkCustomAttributes = "";
        $this->contact_contactnickname->HrefValue = "";
        $this->contact_contactnickname->TooltipValue = "";

        // contact_contactpostition
        $this->contact_contactpostition->LinkCustomAttributes = "";
        $this->contact_contactpostition->HrefValue = "";
        $this->contact_contactpostition->TooltipValue = "";

        // contact_contactphonenumber
        $this->contact_contactphonenumber->LinkCustomAttributes = "";
        $this->contact_contactphonenumber->HrefValue = "";
        $this->contact_contactphonenumber->TooltipValue = "";

        // contact_contactcontactemail
        $this->contact_contactcontactemail->LinkCustomAttributes = "";
        $this->contact_contactcontactemail->HrefValue = "";
        $this->contact_contactcontactemail->TooltipValue = "";

        // contact_purchaseaccount
        $this->contact_purchaseaccount->LinkCustomAttributes = "";
        $this->contact_purchaseaccount->HrefValue = "";
        $this->contact_purchaseaccount->TooltipValue = "";

        // contact_sellaccount
        $this->contact_sellaccount->LinkCustomAttributes = "";
        $this->contact_sellaccount->HrefValue = "";
        $this->contact_sellaccount->TooltipValue = "";

        // member_id
        $this->member_id->LinkCustomAttributes = "";
        $this->member_id->HrefValue = "";
        $this->member_id->TooltipValue = "";

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

        // contact_id
        $this->contact_id->setupEditAttributes();
        $this->contact_id->EditCustomAttributes = "";
        if (!$this->contact_id->Raw) {
            $this->contact_id->CurrentValue = HtmlDecode($this->contact_id->CurrentValue);
        }
        $this->contact_id->EditValue = $this->contact_id->CurrentValue;
        $this->contact_id->PlaceHolder = RemoveHtml($this->contact_id->caption());

        // contact_code
        $this->contact_code->setupEditAttributes();
        $this->contact_code->EditCustomAttributes = "";
        if (!$this->contact_code->Raw) {
            $this->contact_code->CurrentValue = HtmlDecode($this->contact_code->CurrentValue);
        }
        $this->contact_code->EditValue = $this->contact_code->CurrentValue;
        $this->contact_code->PlaceHolder = RemoveHtml($this->contact_code->caption());

        // contact_name
        $this->contact_name->setupEditAttributes();
        $this->contact_name->EditCustomAttributes = "";
        if (!$this->contact_name->Raw) {
            $this->contact_name->CurrentValue = HtmlDecode($this->contact_name->CurrentValue);
        }
        $this->contact_name->EditValue = $this->contact_name->CurrentValue;
        $this->contact_name->PlaceHolder = RemoveHtml($this->contact_name->caption());

        // contact_type
        $this->contact_type->setupEditAttributes();
        $this->contact_type->EditCustomAttributes = "";
        $this->contact_type->EditValue = $this->contact_type->CurrentValue;
        $this->contact_type->PlaceHolder = RemoveHtml($this->contact_type->caption());
        if (strval($this->contact_type->EditValue) != "" && is_numeric($this->contact_type->EditValue)) {
            $this->contact_type->EditValue = FormatNumber($this->contact_type->EditValue, null);
        }

        // contact_taxnumber
        $this->contact_taxnumber->setupEditAttributes();
        $this->contact_taxnumber->EditCustomAttributes = "";
        if (!$this->contact_taxnumber->Raw) {
            $this->contact_taxnumber->CurrentValue = HtmlDecode($this->contact_taxnumber->CurrentValue);
        }
        $this->contact_taxnumber->EditValue = $this->contact_taxnumber->CurrentValue;
        $this->contact_taxnumber->PlaceHolder = RemoveHtml($this->contact_taxnumber->caption());

        // contact_branchcode
        $this->contact_branchcode->setupEditAttributes();
        $this->contact_branchcode->EditCustomAttributes = "";
        if (!$this->contact_branchcode->Raw) {
            $this->contact_branchcode->CurrentValue = HtmlDecode($this->contact_branchcode->CurrentValue);
        }
        $this->contact_branchcode->EditValue = $this->contact_branchcode->CurrentValue;
        $this->contact_branchcode->PlaceHolder = RemoveHtml($this->contact_branchcode->caption());

        // contact_address
        $this->contact_address->setupEditAttributes();
        $this->contact_address->EditCustomAttributes = "";
        if (!$this->contact_address->Raw) {
            $this->contact_address->CurrentValue = HtmlDecode($this->contact_address->CurrentValue);
        }
        $this->contact_address->EditValue = $this->contact_address->CurrentValue;
        $this->contact_address->PlaceHolder = RemoveHtml($this->contact_address->caption());

        // contact_subdistrict
        $this->contact_subdistrict->setupEditAttributes();
        $this->contact_subdistrict->EditCustomAttributes = "";
        if (!$this->contact_subdistrict->Raw) {
            $this->contact_subdistrict->CurrentValue = HtmlDecode($this->contact_subdistrict->CurrentValue);
        }
        $this->contact_subdistrict->EditValue = $this->contact_subdistrict->CurrentValue;
        $this->contact_subdistrict->PlaceHolder = RemoveHtml($this->contact_subdistrict->caption());

        // contact_district
        $this->contact_district->setupEditAttributes();
        $this->contact_district->EditCustomAttributes = "";
        if (!$this->contact_district->Raw) {
            $this->contact_district->CurrentValue = HtmlDecode($this->contact_district->CurrentValue);
        }
        $this->contact_district->EditValue = $this->contact_district->CurrentValue;
        $this->contact_district->PlaceHolder = RemoveHtml($this->contact_district->caption());

        // contact_province
        $this->contact_province->setupEditAttributes();
        $this->contact_province->EditCustomAttributes = "";
        if (!$this->contact_province->Raw) {
            $this->contact_province->CurrentValue = HtmlDecode($this->contact_province->CurrentValue);
        }
        $this->contact_province->EditValue = $this->contact_province->CurrentValue;
        $this->contact_province->PlaceHolder = RemoveHtml($this->contact_province->caption());

        // contact_country
        $this->contact_country->setupEditAttributes();
        $this->contact_country->EditCustomAttributes = "";
        if (!$this->contact_country->Raw) {
            $this->contact_country->CurrentValue = HtmlDecode($this->contact_country->CurrentValue);
        }
        $this->contact_country->EditValue = $this->contact_country->CurrentValue;
        $this->contact_country->PlaceHolder = RemoveHtml($this->contact_country->caption());

        // contact_postcode
        $this->contact_postcode->setupEditAttributes();
        $this->contact_postcode->EditCustomAttributes = "";
        if (!$this->contact_postcode->Raw) {
            $this->contact_postcode->CurrentValue = HtmlDecode($this->contact_postcode->CurrentValue);
        }
        $this->contact_postcode->EditValue = $this->contact_postcode->CurrentValue;
        $this->contact_postcode->PlaceHolder = RemoveHtml($this->contact_postcode->caption());

        // contact_callcenternumber
        $this->contact_callcenternumber->setupEditAttributes();
        $this->contact_callcenternumber->EditCustomAttributes = "";
        if (!$this->contact_callcenternumber->Raw) {
            $this->contact_callcenternumber->CurrentValue = HtmlDecode($this->contact_callcenternumber->CurrentValue);
        }
        $this->contact_callcenternumber->EditValue = $this->contact_callcenternumber->CurrentValue;
        $this->contact_callcenternumber->PlaceHolder = RemoveHtml($this->contact_callcenternumber->caption());

        // contact_faxnumber
        $this->contact_faxnumber->setupEditAttributes();
        $this->contact_faxnumber->EditCustomAttributes = "";
        if (!$this->contact_faxnumber->Raw) {
            $this->contact_faxnumber->CurrentValue = HtmlDecode($this->contact_faxnumber->CurrentValue);
        }
        $this->contact_faxnumber->EditValue = $this->contact_faxnumber->CurrentValue;
        $this->contact_faxnumber->PlaceHolder = RemoveHtml($this->contact_faxnumber->caption());

        // contact_email
        $this->contact_email->setupEditAttributes();
        $this->contact_email->EditCustomAttributes = "";
        if (!$this->contact_email->Raw) {
            $this->contact_email->CurrentValue = HtmlDecode($this->contact_email->CurrentValue);
        }
        $this->contact_email->EditValue = $this->contact_email->CurrentValue;
        $this->contact_email->PlaceHolder = RemoveHtml($this->contact_email->caption());

        // contact_website
        $this->contact_website->setupEditAttributes();
        $this->contact_website->EditCustomAttributes = "";
        if (!$this->contact_website->Raw) {
            $this->contact_website->CurrentValue = HtmlDecode($this->contact_website->CurrentValue);
        }
        $this->contact_website->EditValue = $this->contact_website->CurrentValue;
        $this->contact_website->PlaceHolder = RemoveHtml($this->contact_website->caption());

        // contact_contactfirstname
        $this->contact_contactfirstname->setupEditAttributes();
        $this->contact_contactfirstname->EditCustomAttributes = "";
        if (!$this->contact_contactfirstname->Raw) {
            $this->contact_contactfirstname->CurrentValue = HtmlDecode($this->contact_contactfirstname->CurrentValue);
        }
        $this->contact_contactfirstname->EditValue = $this->contact_contactfirstname->CurrentValue;
        $this->contact_contactfirstname->PlaceHolder = RemoveHtml($this->contact_contactfirstname->caption());

        // contact_contactlastname
        $this->contact_contactlastname->setupEditAttributes();
        $this->contact_contactlastname->EditCustomAttributes = "";
        if (!$this->contact_contactlastname->Raw) {
            $this->contact_contactlastname->CurrentValue = HtmlDecode($this->contact_contactlastname->CurrentValue);
        }
        $this->contact_contactlastname->EditValue = $this->contact_contactlastname->CurrentValue;
        $this->contact_contactlastname->PlaceHolder = RemoveHtml($this->contact_contactlastname->caption());

        // contact_contactnickname
        $this->contact_contactnickname->setupEditAttributes();
        $this->contact_contactnickname->EditCustomAttributes = "";
        if (!$this->contact_contactnickname->Raw) {
            $this->contact_contactnickname->CurrentValue = HtmlDecode($this->contact_contactnickname->CurrentValue);
        }
        $this->contact_contactnickname->EditValue = $this->contact_contactnickname->CurrentValue;
        $this->contact_contactnickname->PlaceHolder = RemoveHtml($this->contact_contactnickname->caption());

        // contact_contactpostition
        $this->contact_contactpostition->setupEditAttributes();
        $this->contact_contactpostition->EditCustomAttributes = "";
        if (!$this->contact_contactpostition->Raw) {
            $this->contact_contactpostition->CurrentValue = HtmlDecode($this->contact_contactpostition->CurrentValue);
        }
        $this->contact_contactpostition->EditValue = $this->contact_contactpostition->CurrentValue;
        $this->contact_contactpostition->PlaceHolder = RemoveHtml($this->contact_contactpostition->caption());

        // contact_contactphonenumber
        $this->contact_contactphonenumber->setupEditAttributes();
        $this->contact_contactphonenumber->EditCustomAttributes = "";
        if (!$this->contact_contactphonenumber->Raw) {
            $this->contact_contactphonenumber->CurrentValue = HtmlDecode($this->contact_contactphonenumber->CurrentValue);
        }
        $this->contact_contactphonenumber->EditValue = $this->contact_contactphonenumber->CurrentValue;
        $this->contact_contactphonenumber->PlaceHolder = RemoveHtml($this->contact_contactphonenumber->caption());

        // contact_contactcontactemail
        $this->contact_contactcontactemail->setupEditAttributes();
        $this->contact_contactcontactemail->EditCustomAttributes = "";
        if (!$this->contact_contactcontactemail->Raw) {
            $this->contact_contactcontactemail->CurrentValue = HtmlDecode($this->contact_contactcontactemail->CurrentValue);
        }
        $this->contact_contactcontactemail->EditValue = $this->contact_contactcontactemail->CurrentValue;
        $this->contact_contactcontactemail->PlaceHolder = RemoveHtml($this->contact_contactcontactemail->caption());

        // contact_purchaseaccount
        $this->contact_purchaseaccount->setupEditAttributes();
        $this->contact_purchaseaccount->EditCustomAttributes = "";
        if (!$this->contact_purchaseaccount->Raw) {
            $this->contact_purchaseaccount->CurrentValue = HtmlDecode($this->contact_purchaseaccount->CurrentValue);
        }
        $this->contact_purchaseaccount->EditValue = $this->contact_purchaseaccount->CurrentValue;
        $this->contact_purchaseaccount->PlaceHolder = RemoveHtml($this->contact_purchaseaccount->caption());

        // contact_sellaccount
        $this->contact_sellaccount->setupEditAttributes();
        $this->contact_sellaccount->EditCustomAttributes = "";
        if (!$this->contact_sellaccount->Raw) {
            $this->contact_sellaccount->CurrentValue = HtmlDecode($this->contact_sellaccount->CurrentValue);
        }
        $this->contact_sellaccount->EditValue = $this->contact_sellaccount->CurrentValue;
        $this->contact_sellaccount->PlaceHolder = RemoveHtml($this->contact_sellaccount->caption());

        // member_id
        $this->member_id->setupEditAttributes();
        $this->member_id->EditCustomAttributes = "";
        $this->member_id->EditValue = $this->member_id->CurrentValue;
        $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
        if (strval($this->member_id->EditValue) != "" && is_numeric($this->member_id->EditValue)) {
            $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, null);
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
                    $doc->exportCaption($this->contact_id);
                    $doc->exportCaption($this->contact_code);
                    $doc->exportCaption($this->contact_name);
                    $doc->exportCaption($this->contact_type);
                    $doc->exportCaption($this->contact_taxnumber);
                    $doc->exportCaption($this->contact_branchcode);
                    $doc->exportCaption($this->contact_address);
                    $doc->exportCaption($this->contact_subdistrict);
                    $doc->exportCaption($this->contact_district);
                    $doc->exportCaption($this->contact_province);
                    $doc->exportCaption($this->contact_country);
                    $doc->exportCaption($this->contact_postcode);
                    $doc->exportCaption($this->contact_callcenternumber);
                    $doc->exportCaption($this->contact_faxnumber);
                    $doc->exportCaption($this->contact_email);
                    $doc->exportCaption($this->contact_website);
                    $doc->exportCaption($this->contact_contactfirstname);
                    $doc->exportCaption($this->contact_contactlastname);
                    $doc->exportCaption($this->contact_contactnickname);
                    $doc->exportCaption($this->contact_contactpostition);
                    $doc->exportCaption($this->contact_contactphonenumber);
                    $doc->exportCaption($this->contact_contactcontactemail);
                    $doc->exportCaption($this->contact_purchaseaccount);
                    $doc->exportCaption($this->contact_sellaccount);
                    $doc->exportCaption($this->member_id);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->create_date);
                    $doc->exportCaption($this->request_status);
                    $doc->exportCaption($this->request_date);
                    $doc->exportCaption($this->contact_id);
                    $doc->exportCaption($this->contact_code);
                    $doc->exportCaption($this->contact_name);
                    $doc->exportCaption($this->contact_type);
                    $doc->exportCaption($this->contact_taxnumber);
                    $doc->exportCaption($this->contact_branchcode);
                    $doc->exportCaption($this->contact_address);
                    $doc->exportCaption($this->contact_subdistrict);
                    $doc->exportCaption($this->contact_district);
                    $doc->exportCaption($this->contact_province);
                    $doc->exportCaption($this->contact_country);
                    $doc->exportCaption($this->contact_postcode);
                    $doc->exportCaption($this->contact_callcenternumber);
                    $doc->exportCaption($this->contact_faxnumber);
                    $doc->exportCaption($this->contact_email);
                    $doc->exportCaption($this->contact_website);
                    $doc->exportCaption($this->contact_contactfirstname);
                    $doc->exportCaption($this->contact_contactlastname);
                    $doc->exportCaption($this->contact_contactnickname);
                    $doc->exportCaption($this->contact_contactpostition);
                    $doc->exportCaption($this->contact_contactphonenumber);
                    $doc->exportCaption($this->contact_contactcontactemail);
                    $doc->exportCaption($this->contact_purchaseaccount);
                    $doc->exportCaption($this->contact_sellaccount);
                    $doc->exportCaption($this->member_id);
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
                        $doc->exportField($this->contact_id);
                        $doc->exportField($this->contact_code);
                        $doc->exportField($this->contact_name);
                        $doc->exportField($this->contact_type);
                        $doc->exportField($this->contact_taxnumber);
                        $doc->exportField($this->contact_branchcode);
                        $doc->exportField($this->contact_address);
                        $doc->exportField($this->contact_subdistrict);
                        $doc->exportField($this->contact_district);
                        $doc->exportField($this->contact_province);
                        $doc->exportField($this->contact_country);
                        $doc->exportField($this->contact_postcode);
                        $doc->exportField($this->contact_callcenternumber);
                        $doc->exportField($this->contact_faxnumber);
                        $doc->exportField($this->contact_email);
                        $doc->exportField($this->contact_website);
                        $doc->exportField($this->contact_contactfirstname);
                        $doc->exportField($this->contact_contactlastname);
                        $doc->exportField($this->contact_contactnickname);
                        $doc->exportField($this->contact_contactpostition);
                        $doc->exportField($this->contact_contactphonenumber);
                        $doc->exportField($this->contact_contactcontactemail);
                        $doc->exportField($this->contact_purchaseaccount);
                        $doc->exportField($this->contact_sellaccount);
                        $doc->exportField($this->member_id);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->create_date);
                        $doc->exportField($this->request_status);
                        $doc->exportField($this->request_date);
                        $doc->exportField($this->contact_id);
                        $doc->exportField($this->contact_code);
                        $doc->exportField($this->contact_name);
                        $doc->exportField($this->contact_type);
                        $doc->exportField($this->contact_taxnumber);
                        $doc->exportField($this->contact_branchcode);
                        $doc->exportField($this->contact_address);
                        $doc->exportField($this->contact_subdistrict);
                        $doc->exportField($this->contact_district);
                        $doc->exportField($this->contact_province);
                        $doc->exportField($this->contact_country);
                        $doc->exportField($this->contact_postcode);
                        $doc->exportField($this->contact_callcenternumber);
                        $doc->exportField($this->contact_faxnumber);
                        $doc->exportField($this->contact_email);
                        $doc->exportField($this->contact_website);
                        $doc->exportField($this->contact_contactfirstname);
                        $doc->exportField($this->contact_contactlastname);
                        $doc->exportField($this->contact_contactnickname);
                        $doc->exportField($this->contact_contactpostition);
                        $doc->exportField($this->contact_contactphonenumber);
                        $doc->exportField($this->contact_contactcontactemail);
                        $doc->exportField($this->contact_purchaseaccount);
                        $doc->exportField($this->contact_sellaccount);
                        $doc->exportField($this->member_id);
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
