<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakContactDelete extends PeakContact
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_contact';

    // Page object name
    public $PageObjName = "PeakContactDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = $route->getArguments();
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (peak_contact)
        if (!isset($GLOBALS["peak_contact"]) || get_class($GLOBALS["peak_contact"]) == PROJECT_NAMESPACE . "peak_contact") {
            $GLOBALS["peak_contact"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_contact');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("peak_contact");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Update last accessed time
        if (!IsSysAdmin() && !$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            Write($Language->phrase("UserProfileCorrupted"));
            $this->terminate();
            return;
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->create_date->setVisibility();
        $this->request_status->setVisibility();
        $this->request_date->setVisibility();
        $this->request_message->Visible = false;
        $this->contact_id->setVisibility();
        $this->contact_code->setVisibility();
        $this->contact_name->setVisibility();
        $this->contact_type->setVisibility();
        $this->contact_taxnumber->setVisibility();
        $this->contact_branchcode->setVisibility();
        $this->contact_address->setVisibility();
        $this->contact_subdistrict->setVisibility();
        $this->contact_district->setVisibility();
        $this->contact_province->setVisibility();
        $this->contact_country->setVisibility();
        $this->contact_postcode->setVisibility();
        $this->contact_callcenternumber->setVisibility();
        $this->contact_faxnumber->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_website->setVisibility();
        $this->contact_contactfirstname->setVisibility();
        $this->contact_contactlastname->setVisibility();
        $this->contact_contactnickname->setVisibility();
        $this->contact_contactpostition->setVisibility();
        $this->contact_contactphonenumber->setVisibility();
        $this->contact_contactcontactemail->setVisibility();
        $this->contact_purchaseaccount->setVisibility();
        $this->contact_sellaccount->setVisibility();
        $this->member_id->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("peakcontactlist"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("peakcontactlist"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAll(FetchMode::ASSOCIATIVE);
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['create_date'] = null;
        $row['request_status'] = null;
        $row['request_date'] = null;
        $row['request_message'] = null;
        $row['contact_id'] = null;
        $row['contact_code'] = null;
        $row['contact_name'] = null;
        $row['contact_type'] = null;
        $row['contact_taxnumber'] = null;
        $row['contact_branchcode'] = null;
        $row['contact_address'] = null;
        $row['contact_subdistrict'] = null;
        $row['contact_district'] = null;
        $row['contact_province'] = null;
        $row['contact_country'] = null;
        $row['contact_postcode'] = null;
        $row['contact_callcenternumber'] = null;
        $row['contact_faxnumber'] = null;
        $row['contact_email'] = null;
        $row['contact_website'] = null;
        $row['contact_contactfirstname'] = null;
        $row['contact_contactlastname'] = null;
        $row['contact_contactnickname'] = null;
        $row['contact_contactpostition'] = null;
        $row['contact_contactphonenumber'] = null;
        $row['contact_contactcontactemail'] = null;
        $row['contact_purchaseaccount'] = null;
        $row['contact_sellaccount'] = null;
        $row['member_id'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteSomeRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakcontactlist"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }
}
