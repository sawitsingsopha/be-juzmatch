<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakContactAdd extends PeakContact
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_contact';

    // Page object name
    public $PageObjName = "PeakContactAdd";

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "peakcontactview") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Update last accessed time
        if (!IsSysAdmin() && !$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            Write($Language->phrase("UserProfileCorrupted"));
            $this->terminate();
            return;
        }

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->create_date->setVisibility();
        $this->request_status->setVisibility();
        $this->request_date->setVisibility();
        $this->request_message->setVisibility();
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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("peakcontactlist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "peakcontactlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "peakcontactview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->create_date->CurrentValue = null;
        $this->create_date->OldValue = $this->create_date->CurrentValue;
        $this->request_status->CurrentValue = null;
        $this->request_status->OldValue = $this->request_status->CurrentValue;
        $this->request_date->CurrentValue = null;
        $this->request_date->OldValue = $this->request_date->CurrentValue;
        $this->request_message->CurrentValue = null;
        $this->request_message->OldValue = $this->request_message->CurrentValue;
        $this->contact_id->CurrentValue = null;
        $this->contact_id->OldValue = $this->contact_id->CurrentValue;
        $this->contact_code->CurrentValue = null;
        $this->contact_code->OldValue = $this->contact_code->CurrentValue;
        $this->contact_name->CurrentValue = null;
        $this->contact_name->OldValue = $this->contact_name->CurrentValue;
        $this->contact_type->CurrentValue = null;
        $this->contact_type->OldValue = $this->contact_type->CurrentValue;
        $this->contact_taxnumber->CurrentValue = null;
        $this->contact_taxnumber->OldValue = $this->contact_taxnumber->CurrentValue;
        $this->contact_branchcode->CurrentValue = null;
        $this->contact_branchcode->OldValue = $this->contact_branchcode->CurrentValue;
        $this->contact_address->CurrentValue = null;
        $this->contact_address->OldValue = $this->contact_address->CurrentValue;
        $this->contact_subdistrict->CurrentValue = null;
        $this->contact_subdistrict->OldValue = $this->contact_subdistrict->CurrentValue;
        $this->contact_district->CurrentValue = null;
        $this->contact_district->OldValue = $this->contact_district->CurrentValue;
        $this->contact_province->CurrentValue = null;
        $this->contact_province->OldValue = $this->contact_province->CurrentValue;
        $this->contact_country->CurrentValue = null;
        $this->contact_country->OldValue = $this->contact_country->CurrentValue;
        $this->contact_postcode->CurrentValue = null;
        $this->contact_postcode->OldValue = $this->contact_postcode->CurrentValue;
        $this->contact_callcenternumber->CurrentValue = null;
        $this->contact_callcenternumber->OldValue = $this->contact_callcenternumber->CurrentValue;
        $this->contact_faxnumber->CurrentValue = null;
        $this->contact_faxnumber->OldValue = $this->contact_faxnumber->CurrentValue;
        $this->contact_email->CurrentValue = null;
        $this->contact_email->OldValue = $this->contact_email->CurrentValue;
        $this->contact_website->CurrentValue = null;
        $this->contact_website->OldValue = $this->contact_website->CurrentValue;
        $this->contact_contactfirstname->CurrentValue = null;
        $this->contact_contactfirstname->OldValue = $this->contact_contactfirstname->CurrentValue;
        $this->contact_contactlastname->CurrentValue = null;
        $this->contact_contactlastname->OldValue = $this->contact_contactlastname->CurrentValue;
        $this->contact_contactnickname->CurrentValue = null;
        $this->contact_contactnickname->OldValue = $this->contact_contactnickname->CurrentValue;
        $this->contact_contactpostition->CurrentValue = null;
        $this->contact_contactpostition->OldValue = $this->contact_contactpostition->CurrentValue;
        $this->contact_contactphonenumber->CurrentValue = null;
        $this->contact_contactphonenumber->OldValue = $this->contact_contactphonenumber->CurrentValue;
        $this->contact_contactcontactemail->CurrentValue = null;
        $this->contact_contactcontactemail->OldValue = $this->contact_contactcontactemail->CurrentValue;
        $this->contact_purchaseaccount->CurrentValue = null;
        $this->contact_purchaseaccount->OldValue = $this->contact_purchaseaccount->CurrentValue;
        $this->contact_sellaccount->CurrentValue = null;
        $this->contact_sellaccount->OldValue = $this->contact_sellaccount->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'create_date' first before field var 'x_create_date'
        $val = $CurrentForm->hasValue("create_date") ? $CurrentForm->getValue("create_date") : $CurrentForm->getValue("x_create_date");
        if (!$this->create_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->create_date->Visible = false; // Disable update for API request
            } else {
                $this->create_date->setFormValue($val, true, $validate);
            }
            $this->create_date->CurrentValue = UnFormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern());
        }

        // Check field name 'request_status' first before field var 'x_request_status'
        $val = $CurrentForm->hasValue("request_status") ? $CurrentForm->getValue("request_status") : $CurrentForm->getValue("x_request_status");
        if (!$this->request_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->request_status->Visible = false; // Disable update for API request
            } else {
                $this->request_status->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'request_date' first before field var 'x_request_date'
        $val = $CurrentForm->hasValue("request_date") ? $CurrentForm->getValue("request_date") : $CurrentForm->getValue("x_request_date");
        if (!$this->request_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->request_date->Visible = false; // Disable update for API request
            } else {
                $this->request_date->setFormValue($val, true, $validate);
            }
            $this->request_date->CurrentValue = UnFormatDateTime($this->request_date->CurrentValue, $this->request_date->formatPattern());
        }

        // Check field name 'request_message' first before field var 'x_request_message'
        $val = $CurrentForm->hasValue("request_message") ? $CurrentForm->getValue("request_message") : $CurrentForm->getValue("x_request_message");
        if (!$this->request_message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->request_message->Visible = false; // Disable update for API request
            } else {
                $this->request_message->setFormValue($val);
            }
        }

        // Check field name 'contact_id' first before field var 'x_contact_id'
        $val = $CurrentForm->hasValue("contact_id") ? $CurrentForm->getValue("contact_id") : $CurrentForm->getValue("x_contact_id");
        if (!$this->contact_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_id->Visible = false; // Disable update for API request
            } else {
                $this->contact_id->setFormValue($val);
            }
        }

        // Check field name 'contact_code' first before field var 'x_contact_code'
        $val = $CurrentForm->hasValue("contact_code") ? $CurrentForm->getValue("contact_code") : $CurrentForm->getValue("x_contact_code");
        if (!$this->contact_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_code->Visible = false; // Disable update for API request
            } else {
                $this->contact_code->setFormValue($val);
            }
        }

        // Check field name 'contact_name' first before field var 'x_contact_name'
        $val = $CurrentForm->hasValue("contact_name") ? $CurrentForm->getValue("contact_name") : $CurrentForm->getValue("x_contact_name");
        if (!$this->contact_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_name->Visible = false; // Disable update for API request
            } else {
                $this->contact_name->setFormValue($val);
            }
        }

        // Check field name 'contact_type' first before field var 'x_contact_type'
        $val = $CurrentForm->hasValue("contact_type") ? $CurrentForm->getValue("contact_type") : $CurrentForm->getValue("x_contact_type");
        if (!$this->contact_type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_type->Visible = false; // Disable update for API request
            } else {
                $this->contact_type->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'contact_taxnumber' first before field var 'x_contact_taxnumber'
        $val = $CurrentForm->hasValue("contact_taxnumber") ? $CurrentForm->getValue("contact_taxnumber") : $CurrentForm->getValue("x_contact_taxnumber");
        if (!$this->contact_taxnumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_taxnumber->Visible = false; // Disable update for API request
            } else {
                $this->contact_taxnumber->setFormValue($val);
            }
        }

        // Check field name 'contact_branchcode' first before field var 'x_contact_branchcode'
        $val = $CurrentForm->hasValue("contact_branchcode") ? $CurrentForm->getValue("contact_branchcode") : $CurrentForm->getValue("x_contact_branchcode");
        if (!$this->contact_branchcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_branchcode->Visible = false; // Disable update for API request
            } else {
                $this->contact_branchcode->setFormValue($val);
            }
        }

        // Check field name 'contact_address' first before field var 'x_contact_address'
        $val = $CurrentForm->hasValue("contact_address") ? $CurrentForm->getValue("contact_address") : $CurrentForm->getValue("x_contact_address");
        if (!$this->contact_address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_address->Visible = false; // Disable update for API request
            } else {
                $this->contact_address->setFormValue($val);
            }
        }

        // Check field name 'contact_subdistrict' first before field var 'x_contact_subdistrict'
        $val = $CurrentForm->hasValue("contact_subdistrict") ? $CurrentForm->getValue("contact_subdistrict") : $CurrentForm->getValue("x_contact_subdistrict");
        if (!$this->contact_subdistrict->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_subdistrict->Visible = false; // Disable update for API request
            } else {
                $this->contact_subdistrict->setFormValue($val);
            }
        }

        // Check field name 'contact_district' first before field var 'x_contact_district'
        $val = $CurrentForm->hasValue("contact_district") ? $CurrentForm->getValue("contact_district") : $CurrentForm->getValue("x_contact_district");
        if (!$this->contact_district->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_district->Visible = false; // Disable update for API request
            } else {
                $this->contact_district->setFormValue($val);
            }
        }

        // Check field name 'contact_province' first before field var 'x_contact_province'
        $val = $CurrentForm->hasValue("contact_province") ? $CurrentForm->getValue("contact_province") : $CurrentForm->getValue("x_contact_province");
        if (!$this->contact_province->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_province->Visible = false; // Disable update for API request
            } else {
                $this->contact_province->setFormValue($val);
            }
        }

        // Check field name 'contact_country' first before field var 'x_contact_country'
        $val = $CurrentForm->hasValue("contact_country") ? $CurrentForm->getValue("contact_country") : $CurrentForm->getValue("x_contact_country");
        if (!$this->contact_country->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_country->Visible = false; // Disable update for API request
            } else {
                $this->contact_country->setFormValue($val);
            }
        }

        // Check field name 'contact_postcode' first before field var 'x_contact_postcode'
        $val = $CurrentForm->hasValue("contact_postcode") ? $CurrentForm->getValue("contact_postcode") : $CurrentForm->getValue("x_contact_postcode");
        if (!$this->contact_postcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_postcode->Visible = false; // Disable update for API request
            } else {
                $this->contact_postcode->setFormValue($val);
            }
        }

        // Check field name 'contact_callcenternumber' first before field var 'x_contact_callcenternumber'
        $val = $CurrentForm->hasValue("contact_callcenternumber") ? $CurrentForm->getValue("contact_callcenternumber") : $CurrentForm->getValue("x_contact_callcenternumber");
        if (!$this->contact_callcenternumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_callcenternumber->Visible = false; // Disable update for API request
            } else {
                $this->contact_callcenternumber->setFormValue($val);
            }
        }

        // Check field name 'contact_faxnumber' first before field var 'x_contact_faxnumber'
        $val = $CurrentForm->hasValue("contact_faxnumber") ? $CurrentForm->getValue("contact_faxnumber") : $CurrentForm->getValue("x_contact_faxnumber");
        if (!$this->contact_faxnumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_faxnumber->Visible = false; // Disable update for API request
            } else {
                $this->contact_faxnumber->setFormValue($val);
            }
        }

        // Check field name 'contact_email' first before field var 'x_contact_email'
        $val = $CurrentForm->hasValue("contact_email") ? $CurrentForm->getValue("contact_email") : $CurrentForm->getValue("x_contact_email");
        if (!$this->contact_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_email->Visible = false; // Disable update for API request
            } else {
                $this->contact_email->setFormValue($val);
            }
        }

        // Check field name 'contact_website' first before field var 'x_contact_website'
        $val = $CurrentForm->hasValue("contact_website") ? $CurrentForm->getValue("contact_website") : $CurrentForm->getValue("x_contact_website");
        if (!$this->contact_website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_website->Visible = false; // Disable update for API request
            } else {
                $this->contact_website->setFormValue($val);
            }
        }

        // Check field name 'contact_contactfirstname' first before field var 'x_contact_contactfirstname'
        $val = $CurrentForm->hasValue("contact_contactfirstname") ? $CurrentForm->getValue("contact_contactfirstname") : $CurrentForm->getValue("x_contact_contactfirstname");
        if (!$this->contact_contactfirstname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_contactfirstname->Visible = false; // Disable update for API request
            } else {
                $this->contact_contactfirstname->setFormValue($val);
            }
        }

        // Check field name 'contact_contactlastname' first before field var 'x_contact_contactlastname'
        $val = $CurrentForm->hasValue("contact_contactlastname") ? $CurrentForm->getValue("contact_contactlastname") : $CurrentForm->getValue("x_contact_contactlastname");
        if (!$this->contact_contactlastname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_contactlastname->Visible = false; // Disable update for API request
            } else {
                $this->contact_contactlastname->setFormValue($val);
            }
        }

        // Check field name 'contact_contactnickname' first before field var 'x_contact_contactnickname'
        $val = $CurrentForm->hasValue("contact_contactnickname") ? $CurrentForm->getValue("contact_contactnickname") : $CurrentForm->getValue("x_contact_contactnickname");
        if (!$this->contact_contactnickname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_contactnickname->Visible = false; // Disable update for API request
            } else {
                $this->contact_contactnickname->setFormValue($val);
            }
        }

        // Check field name 'contact_contactpostition' first before field var 'x_contact_contactpostition'
        $val = $CurrentForm->hasValue("contact_contactpostition") ? $CurrentForm->getValue("contact_contactpostition") : $CurrentForm->getValue("x_contact_contactpostition");
        if (!$this->contact_contactpostition->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_contactpostition->Visible = false; // Disable update for API request
            } else {
                $this->contact_contactpostition->setFormValue($val);
            }
        }

        // Check field name 'contact_contactphonenumber' first before field var 'x_contact_contactphonenumber'
        $val = $CurrentForm->hasValue("contact_contactphonenumber") ? $CurrentForm->getValue("contact_contactphonenumber") : $CurrentForm->getValue("x_contact_contactphonenumber");
        if (!$this->contact_contactphonenumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_contactphonenumber->Visible = false; // Disable update for API request
            } else {
                $this->contact_contactphonenumber->setFormValue($val);
            }
        }

        // Check field name 'contact_contactcontactemail' first before field var 'x_contact_contactcontactemail'
        $val = $CurrentForm->hasValue("contact_contactcontactemail") ? $CurrentForm->getValue("contact_contactcontactemail") : $CurrentForm->getValue("x_contact_contactcontactemail");
        if (!$this->contact_contactcontactemail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_contactcontactemail->Visible = false; // Disable update for API request
            } else {
                $this->contact_contactcontactemail->setFormValue($val);
            }
        }

        // Check field name 'contact_purchaseaccount' first before field var 'x_contact_purchaseaccount'
        $val = $CurrentForm->hasValue("contact_purchaseaccount") ? $CurrentForm->getValue("contact_purchaseaccount") : $CurrentForm->getValue("x_contact_purchaseaccount");
        if (!$this->contact_purchaseaccount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_purchaseaccount->Visible = false; // Disable update for API request
            } else {
                $this->contact_purchaseaccount->setFormValue($val);
            }
        }

        // Check field name 'contact_sellaccount' first before field var 'x_contact_sellaccount'
        $val = $CurrentForm->hasValue("contact_sellaccount") ? $CurrentForm->getValue("contact_sellaccount") : $CurrentForm->getValue("x_contact_sellaccount");
        if (!$this->contact_sellaccount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_sellaccount->Visible = false; // Disable update for API request
            } else {
                $this->contact_sellaccount->setFormValue($val);
            }
        }

        // Check field name 'member_id' first before field var 'x_member_id'
        $val = $CurrentForm->hasValue("member_id") ? $CurrentForm->getValue("member_id") : $CurrentForm->getValue("x_member_id");
        if (!$this->member_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->member_id->Visible = false; // Disable update for API request
            } else {
                $this->member_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->create_date->CurrentValue = $this->create_date->FormValue;
        $this->create_date->CurrentValue = UnFormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern());
        $this->request_status->CurrentValue = $this->request_status->FormValue;
        $this->request_date->CurrentValue = $this->request_date->FormValue;
        $this->request_date->CurrentValue = UnFormatDateTime($this->request_date->CurrentValue, $this->request_date->formatPattern());
        $this->request_message->CurrentValue = $this->request_message->FormValue;
        $this->contact_id->CurrentValue = $this->contact_id->FormValue;
        $this->contact_code->CurrentValue = $this->contact_code->FormValue;
        $this->contact_name->CurrentValue = $this->contact_name->FormValue;
        $this->contact_type->CurrentValue = $this->contact_type->FormValue;
        $this->contact_taxnumber->CurrentValue = $this->contact_taxnumber->FormValue;
        $this->contact_branchcode->CurrentValue = $this->contact_branchcode->FormValue;
        $this->contact_address->CurrentValue = $this->contact_address->FormValue;
        $this->contact_subdistrict->CurrentValue = $this->contact_subdistrict->FormValue;
        $this->contact_district->CurrentValue = $this->contact_district->FormValue;
        $this->contact_province->CurrentValue = $this->contact_province->FormValue;
        $this->contact_country->CurrentValue = $this->contact_country->FormValue;
        $this->contact_postcode->CurrentValue = $this->contact_postcode->FormValue;
        $this->contact_callcenternumber->CurrentValue = $this->contact_callcenternumber->FormValue;
        $this->contact_faxnumber->CurrentValue = $this->contact_faxnumber->FormValue;
        $this->contact_email->CurrentValue = $this->contact_email->FormValue;
        $this->contact_website->CurrentValue = $this->contact_website->FormValue;
        $this->contact_contactfirstname->CurrentValue = $this->contact_contactfirstname->FormValue;
        $this->contact_contactlastname->CurrentValue = $this->contact_contactlastname->FormValue;
        $this->contact_contactnickname->CurrentValue = $this->contact_contactnickname->FormValue;
        $this->contact_contactpostition->CurrentValue = $this->contact_contactpostition->FormValue;
        $this->contact_contactphonenumber->CurrentValue = $this->contact_contactphonenumber->FormValue;
        $this->contact_contactcontactemail->CurrentValue = $this->contact_contactcontactemail->FormValue;
        $this->contact_purchaseaccount->CurrentValue = $this->contact_purchaseaccount->FormValue;
        $this->contact_sellaccount->CurrentValue = $this->contact_sellaccount->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['create_date'] = $this->create_date->CurrentValue;
        $row['request_status'] = $this->request_status->CurrentValue;
        $row['request_date'] = $this->request_date->CurrentValue;
        $row['request_message'] = $this->request_message->CurrentValue;
        $row['contact_id'] = $this->contact_id->CurrentValue;
        $row['contact_code'] = $this->contact_code->CurrentValue;
        $row['contact_name'] = $this->contact_name->CurrentValue;
        $row['contact_type'] = $this->contact_type->CurrentValue;
        $row['contact_taxnumber'] = $this->contact_taxnumber->CurrentValue;
        $row['contact_branchcode'] = $this->contact_branchcode->CurrentValue;
        $row['contact_address'] = $this->contact_address->CurrentValue;
        $row['contact_subdistrict'] = $this->contact_subdistrict->CurrentValue;
        $row['contact_district'] = $this->contact_district->CurrentValue;
        $row['contact_province'] = $this->contact_province->CurrentValue;
        $row['contact_country'] = $this->contact_country->CurrentValue;
        $row['contact_postcode'] = $this->contact_postcode->CurrentValue;
        $row['contact_callcenternumber'] = $this->contact_callcenternumber->CurrentValue;
        $row['contact_faxnumber'] = $this->contact_faxnumber->CurrentValue;
        $row['contact_email'] = $this->contact_email->CurrentValue;
        $row['contact_website'] = $this->contact_website->CurrentValue;
        $row['contact_contactfirstname'] = $this->contact_contactfirstname->CurrentValue;
        $row['contact_contactlastname'] = $this->contact_contactlastname->CurrentValue;
        $row['contact_contactnickname'] = $this->contact_contactnickname->CurrentValue;
        $row['contact_contactpostition'] = $this->contact_contactpostition->CurrentValue;
        $row['contact_contactphonenumber'] = $this->contact_contactphonenumber->CurrentValue;
        $row['contact_contactcontactemail'] = $this->contact_contactcontactemail->CurrentValue;
        $row['contact_purchaseaccount'] = $this->contact_purchaseaccount->CurrentValue;
        $row['contact_sellaccount'] = $this->contact_sellaccount->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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
        $this->id->RowCssClass = "row";

        // create_date
        $this->create_date->RowCssClass = "row";

        // request_status
        $this->request_status->RowCssClass = "row";

        // request_date
        $this->request_date->RowCssClass = "row";

        // request_message
        $this->request_message->RowCssClass = "row";

        // contact_id
        $this->contact_id->RowCssClass = "row";

        // contact_code
        $this->contact_code->RowCssClass = "row";

        // contact_name
        $this->contact_name->RowCssClass = "row";

        // contact_type
        $this->contact_type->RowCssClass = "row";

        // contact_taxnumber
        $this->contact_taxnumber->RowCssClass = "row";

        // contact_branchcode
        $this->contact_branchcode->RowCssClass = "row";

        // contact_address
        $this->contact_address->RowCssClass = "row";

        // contact_subdistrict
        $this->contact_subdistrict->RowCssClass = "row";

        // contact_district
        $this->contact_district->RowCssClass = "row";

        // contact_province
        $this->contact_province->RowCssClass = "row";

        // contact_country
        $this->contact_country->RowCssClass = "row";

        // contact_postcode
        $this->contact_postcode->RowCssClass = "row";

        // contact_callcenternumber
        $this->contact_callcenternumber->RowCssClass = "row";

        // contact_faxnumber
        $this->contact_faxnumber->RowCssClass = "row";

        // contact_email
        $this->contact_email->RowCssClass = "row";

        // contact_website
        $this->contact_website->RowCssClass = "row";

        // contact_contactfirstname
        $this->contact_contactfirstname->RowCssClass = "row";

        // contact_contactlastname
        $this->contact_contactlastname->RowCssClass = "row";

        // contact_contactnickname
        $this->contact_contactnickname->RowCssClass = "row";

        // contact_contactpostition
        $this->contact_contactpostition->RowCssClass = "row";

        // contact_contactphonenumber
        $this->contact_contactphonenumber->RowCssClass = "row";

        // contact_contactcontactemail
        $this->contact_contactcontactemail->RowCssClass = "row";

        // contact_purchaseaccount
        $this->contact_purchaseaccount->RowCssClass = "row";

        // contact_sellaccount
        $this->contact_sellaccount->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

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

            // create_date
            $this->create_date->LinkCustomAttributes = "";
            $this->create_date->HrefValue = "";

            // request_status
            $this->request_status->LinkCustomAttributes = "";
            $this->request_status->HrefValue = "";

            // request_date
            $this->request_date->LinkCustomAttributes = "";
            $this->request_date->HrefValue = "";

            // request_message
            $this->request_message->LinkCustomAttributes = "";
            $this->request_message->HrefValue = "";

            // contact_id
            $this->contact_id->LinkCustomAttributes = "";
            $this->contact_id->HrefValue = "";

            // contact_code
            $this->contact_code->LinkCustomAttributes = "";
            $this->contact_code->HrefValue = "";

            // contact_name
            $this->contact_name->LinkCustomAttributes = "";
            $this->contact_name->HrefValue = "";

            // contact_type
            $this->contact_type->LinkCustomAttributes = "";
            $this->contact_type->HrefValue = "";

            // contact_taxnumber
            $this->contact_taxnumber->LinkCustomAttributes = "";
            $this->contact_taxnumber->HrefValue = "";

            // contact_branchcode
            $this->contact_branchcode->LinkCustomAttributes = "";
            $this->contact_branchcode->HrefValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";

            // contact_subdistrict
            $this->contact_subdistrict->LinkCustomAttributes = "";
            $this->contact_subdistrict->HrefValue = "";

            // contact_district
            $this->contact_district->LinkCustomAttributes = "";
            $this->contact_district->HrefValue = "";

            // contact_province
            $this->contact_province->LinkCustomAttributes = "";
            $this->contact_province->HrefValue = "";

            // contact_country
            $this->contact_country->LinkCustomAttributes = "";
            $this->contact_country->HrefValue = "";

            // contact_postcode
            $this->contact_postcode->LinkCustomAttributes = "";
            $this->contact_postcode->HrefValue = "";

            // contact_callcenternumber
            $this->contact_callcenternumber->LinkCustomAttributes = "";
            $this->contact_callcenternumber->HrefValue = "";

            // contact_faxnumber
            $this->contact_faxnumber->LinkCustomAttributes = "";
            $this->contact_faxnumber->HrefValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";

            // contact_website
            $this->contact_website->LinkCustomAttributes = "";
            $this->contact_website->HrefValue = "";

            // contact_contactfirstname
            $this->contact_contactfirstname->LinkCustomAttributes = "";
            $this->contact_contactfirstname->HrefValue = "";

            // contact_contactlastname
            $this->contact_contactlastname->LinkCustomAttributes = "";
            $this->contact_contactlastname->HrefValue = "";

            // contact_contactnickname
            $this->contact_contactnickname->LinkCustomAttributes = "";
            $this->contact_contactnickname->HrefValue = "";

            // contact_contactpostition
            $this->contact_contactpostition->LinkCustomAttributes = "";
            $this->contact_contactpostition->HrefValue = "";

            // contact_contactphonenumber
            $this->contact_contactphonenumber->LinkCustomAttributes = "";
            $this->contact_contactphonenumber->HrefValue = "";

            // contact_contactcontactemail
            $this->contact_contactcontactemail->LinkCustomAttributes = "";
            $this->contact_contactcontactemail->HrefValue = "";

            // contact_purchaseaccount
            $this->contact_purchaseaccount->LinkCustomAttributes = "";
            $this->contact_purchaseaccount->HrefValue = "";

            // contact_sellaccount
            $this->contact_sellaccount->LinkCustomAttributes = "";
            $this->contact_sellaccount->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // create_date
            $this->create_date->setupEditAttributes();
            $this->create_date->EditCustomAttributes = "";
            $this->create_date->EditValue = HtmlEncode(FormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern()));
            $this->create_date->PlaceHolder = RemoveHtml($this->create_date->caption());

            // request_status
            $this->request_status->setupEditAttributes();
            $this->request_status->EditCustomAttributes = "";
            $this->request_status->EditValue = HtmlEncode($this->request_status->CurrentValue);
            $this->request_status->PlaceHolder = RemoveHtml($this->request_status->caption());
            if (strval($this->request_status->EditValue) != "" && is_numeric($this->request_status->EditValue)) {
                $this->request_status->EditValue = FormatNumber($this->request_status->EditValue, null);
            }

            // request_date
            $this->request_date->setupEditAttributes();
            $this->request_date->EditCustomAttributes = "";
            $this->request_date->EditValue = HtmlEncode(FormatDateTime($this->request_date->CurrentValue, $this->request_date->formatPattern()));
            $this->request_date->PlaceHolder = RemoveHtml($this->request_date->caption());

            // request_message
            $this->request_message->setupEditAttributes();
            $this->request_message->EditCustomAttributes = "";
            $this->request_message->EditValue = HtmlEncode($this->request_message->CurrentValue);
            $this->request_message->PlaceHolder = RemoveHtml($this->request_message->caption());

            // contact_id
            $this->contact_id->setupEditAttributes();
            $this->contact_id->EditCustomAttributes = "";
            if (!$this->contact_id->Raw) {
                $this->contact_id->CurrentValue = HtmlDecode($this->contact_id->CurrentValue);
            }
            $this->contact_id->EditValue = HtmlEncode($this->contact_id->CurrentValue);
            $this->contact_id->PlaceHolder = RemoveHtml($this->contact_id->caption());

            // contact_code
            $this->contact_code->setupEditAttributes();
            $this->contact_code->EditCustomAttributes = "";
            if (!$this->contact_code->Raw) {
                $this->contact_code->CurrentValue = HtmlDecode($this->contact_code->CurrentValue);
            }
            $this->contact_code->EditValue = HtmlEncode($this->contact_code->CurrentValue);
            $this->contact_code->PlaceHolder = RemoveHtml($this->contact_code->caption());

            // contact_name
            $this->contact_name->setupEditAttributes();
            $this->contact_name->EditCustomAttributes = "";
            if (!$this->contact_name->Raw) {
                $this->contact_name->CurrentValue = HtmlDecode($this->contact_name->CurrentValue);
            }
            $this->contact_name->EditValue = HtmlEncode($this->contact_name->CurrentValue);
            $this->contact_name->PlaceHolder = RemoveHtml($this->contact_name->caption());

            // contact_type
            $this->contact_type->setupEditAttributes();
            $this->contact_type->EditCustomAttributes = "";
            $this->contact_type->EditValue = HtmlEncode($this->contact_type->CurrentValue);
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
            $this->contact_taxnumber->EditValue = HtmlEncode($this->contact_taxnumber->CurrentValue);
            $this->contact_taxnumber->PlaceHolder = RemoveHtml($this->contact_taxnumber->caption());

            // contact_branchcode
            $this->contact_branchcode->setupEditAttributes();
            $this->contact_branchcode->EditCustomAttributes = "";
            if (!$this->contact_branchcode->Raw) {
                $this->contact_branchcode->CurrentValue = HtmlDecode($this->contact_branchcode->CurrentValue);
            }
            $this->contact_branchcode->EditValue = HtmlEncode($this->contact_branchcode->CurrentValue);
            $this->contact_branchcode->PlaceHolder = RemoveHtml($this->contact_branchcode->caption());

            // contact_address
            $this->contact_address->setupEditAttributes();
            $this->contact_address->EditCustomAttributes = "";
            if (!$this->contact_address->Raw) {
                $this->contact_address->CurrentValue = HtmlDecode($this->contact_address->CurrentValue);
            }
            $this->contact_address->EditValue = HtmlEncode($this->contact_address->CurrentValue);
            $this->contact_address->PlaceHolder = RemoveHtml($this->contact_address->caption());

            // contact_subdistrict
            $this->contact_subdistrict->setupEditAttributes();
            $this->contact_subdistrict->EditCustomAttributes = "";
            if (!$this->contact_subdistrict->Raw) {
                $this->contact_subdistrict->CurrentValue = HtmlDecode($this->contact_subdistrict->CurrentValue);
            }
            $this->contact_subdistrict->EditValue = HtmlEncode($this->contact_subdistrict->CurrentValue);
            $this->contact_subdistrict->PlaceHolder = RemoveHtml($this->contact_subdistrict->caption());

            // contact_district
            $this->contact_district->setupEditAttributes();
            $this->contact_district->EditCustomAttributes = "";
            if (!$this->contact_district->Raw) {
                $this->contact_district->CurrentValue = HtmlDecode($this->contact_district->CurrentValue);
            }
            $this->contact_district->EditValue = HtmlEncode($this->contact_district->CurrentValue);
            $this->contact_district->PlaceHolder = RemoveHtml($this->contact_district->caption());

            // contact_province
            $this->contact_province->setupEditAttributes();
            $this->contact_province->EditCustomAttributes = "";
            if (!$this->contact_province->Raw) {
                $this->contact_province->CurrentValue = HtmlDecode($this->contact_province->CurrentValue);
            }
            $this->contact_province->EditValue = HtmlEncode($this->contact_province->CurrentValue);
            $this->contact_province->PlaceHolder = RemoveHtml($this->contact_province->caption());

            // contact_country
            $this->contact_country->setupEditAttributes();
            $this->contact_country->EditCustomAttributes = "";
            if (!$this->contact_country->Raw) {
                $this->contact_country->CurrentValue = HtmlDecode($this->contact_country->CurrentValue);
            }
            $this->contact_country->EditValue = HtmlEncode($this->contact_country->CurrentValue);
            $this->contact_country->PlaceHolder = RemoveHtml($this->contact_country->caption());

            // contact_postcode
            $this->contact_postcode->setupEditAttributes();
            $this->contact_postcode->EditCustomAttributes = "";
            if (!$this->contact_postcode->Raw) {
                $this->contact_postcode->CurrentValue = HtmlDecode($this->contact_postcode->CurrentValue);
            }
            $this->contact_postcode->EditValue = HtmlEncode($this->contact_postcode->CurrentValue);
            $this->contact_postcode->PlaceHolder = RemoveHtml($this->contact_postcode->caption());

            // contact_callcenternumber
            $this->contact_callcenternumber->setupEditAttributes();
            $this->contact_callcenternumber->EditCustomAttributes = "";
            if (!$this->contact_callcenternumber->Raw) {
                $this->contact_callcenternumber->CurrentValue = HtmlDecode($this->contact_callcenternumber->CurrentValue);
            }
            $this->contact_callcenternumber->EditValue = HtmlEncode($this->contact_callcenternumber->CurrentValue);
            $this->contact_callcenternumber->PlaceHolder = RemoveHtml($this->contact_callcenternumber->caption());

            // contact_faxnumber
            $this->contact_faxnumber->setupEditAttributes();
            $this->contact_faxnumber->EditCustomAttributes = "";
            if (!$this->contact_faxnumber->Raw) {
                $this->contact_faxnumber->CurrentValue = HtmlDecode($this->contact_faxnumber->CurrentValue);
            }
            $this->contact_faxnumber->EditValue = HtmlEncode($this->contact_faxnumber->CurrentValue);
            $this->contact_faxnumber->PlaceHolder = RemoveHtml($this->contact_faxnumber->caption());

            // contact_email
            $this->contact_email->setupEditAttributes();
            $this->contact_email->EditCustomAttributes = "";
            if (!$this->contact_email->Raw) {
                $this->contact_email->CurrentValue = HtmlDecode($this->contact_email->CurrentValue);
            }
            $this->contact_email->EditValue = HtmlEncode($this->contact_email->CurrentValue);
            $this->contact_email->PlaceHolder = RemoveHtml($this->contact_email->caption());

            // contact_website
            $this->contact_website->setupEditAttributes();
            $this->contact_website->EditCustomAttributes = "";
            if (!$this->contact_website->Raw) {
                $this->contact_website->CurrentValue = HtmlDecode($this->contact_website->CurrentValue);
            }
            $this->contact_website->EditValue = HtmlEncode($this->contact_website->CurrentValue);
            $this->contact_website->PlaceHolder = RemoveHtml($this->contact_website->caption());

            // contact_contactfirstname
            $this->contact_contactfirstname->setupEditAttributes();
            $this->contact_contactfirstname->EditCustomAttributes = "";
            if (!$this->contact_contactfirstname->Raw) {
                $this->contact_contactfirstname->CurrentValue = HtmlDecode($this->contact_contactfirstname->CurrentValue);
            }
            $this->contact_contactfirstname->EditValue = HtmlEncode($this->contact_contactfirstname->CurrentValue);
            $this->contact_contactfirstname->PlaceHolder = RemoveHtml($this->contact_contactfirstname->caption());

            // contact_contactlastname
            $this->contact_contactlastname->setupEditAttributes();
            $this->contact_contactlastname->EditCustomAttributes = "";
            if (!$this->contact_contactlastname->Raw) {
                $this->contact_contactlastname->CurrentValue = HtmlDecode($this->contact_contactlastname->CurrentValue);
            }
            $this->contact_contactlastname->EditValue = HtmlEncode($this->contact_contactlastname->CurrentValue);
            $this->contact_contactlastname->PlaceHolder = RemoveHtml($this->contact_contactlastname->caption());

            // contact_contactnickname
            $this->contact_contactnickname->setupEditAttributes();
            $this->contact_contactnickname->EditCustomAttributes = "";
            if (!$this->contact_contactnickname->Raw) {
                $this->contact_contactnickname->CurrentValue = HtmlDecode($this->contact_contactnickname->CurrentValue);
            }
            $this->contact_contactnickname->EditValue = HtmlEncode($this->contact_contactnickname->CurrentValue);
            $this->contact_contactnickname->PlaceHolder = RemoveHtml($this->contact_contactnickname->caption());

            // contact_contactpostition
            $this->contact_contactpostition->setupEditAttributes();
            $this->contact_contactpostition->EditCustomAttributes = "";
            if (!$this->contact_contactpostition->Raw) {
                $this->contact_contactpostition->CurrentValue = HtmlDecode($this->contact_contactpostition->CurrentValue);
            }
            $this->contact_contactpostition->EditValue = HtmlEncode($this->contact_contactpostition->CurrentValue);
            $this->contact_contactpostition->PlaceHolder = RemoveHtml($this->contact_contactpostition->caption());

            // contact_contactphonenumber
            $this->contact_contactphonenumber->setupEditAttributes();
            $this->contact_contactphonenumber->EditCustomAttributes = "";
            if (!$this->contact_contactphonenumber->Raw) {
                $this->contact_contactphonenumber->CurrentValue = HtmlDecode($this->contact_contactphonenumber->CurrentValue);
            }
            $this->contact_contactphonenumber->EditValue = HtmlEncode($this->contact_contactphonenumber->CurrentValue);
            $this->contact_contactphonenumber->PlaceHolder = RemoveHtml($this->contact_contactphonenumber->caption());

            // contact_contactcontactemail
            $this->contact_contactcontactemail->setupEditAttributes();
            $this->contact_contactcontactemail->EditCustomAttributes = "";
            if (!$this->contact_contactcontactemail->Raw) {
                $this->contact_contactcontactemail->CurrentValue = HtmlDecode($this->contact_contactcontactemail->CurrentValue);
            }
            $this->contact_contactcontactemail->EditValue = HtmlEncode($this->contact_contactcontactemail->CurrentValue);
            $this->contact_contactcontactemail->PlaceHolder = RemoveHtml($this->contact_contactcontactemail->caption());

            // contact_purchaseaccount
            $this->contact_purchaseaccount->setupEditAttributes();
            $this->contact_purchaseaccount->EditCustomAttributes = "";
            if (!$this->contact_purchaseaccount->Raw) {
                $this->contact_purchaseaccount->CurrentValue = HtmlDecode($this->contact_purchaseaccount->CurrentValue);
            }
            $this->contact_purchaseaccount->EditValue = HtmlEncode($this->contact_purchaseaccount->CurrentValue);
            $this->contact_purchaseaccount->PlaceHolder = RemoveHtml($this->contact_purchaseaccount->caption());

            // contact_sellaccount
            $this->contact_sellaccount->setupEditAttributes();
            $this->contact_sellaccount->EditCustomAttributes = "";
            if (!$this->contact_sellaccount->Raw) {
                $this->contact_sellaccount->CurrentValue = HtmlDecode($this->contact_sellaccount->CurrentValue);
            }
            $this->contact_sellaccount->EditValue = HtmlEncode($this->contact_sellaccount->CurrentValue);
            $this->contact_sellaccount->PlaceHolder = RemoveHtml($this->contact_sellaccount->caption());

            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $this->member_id->EditValue = HtmlEncode($this->member_id->CurrentValue);
            $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
            if (strval($this->member_id->EditValue) != "" && is_numeric($this->member_id->EditValue)) {
                $this->member_id->EditValue = FormatNumber($this->member_id->EditValue, null);
            }

            // Add refer script

            // create_date
            $this->create_date->LinkCustomAttributes = "";
            $this->create_date->HrefValue = "";

            // request_status
            $this->request_status->LinkCustomAttributes = "";
            $this->request_status->HrefValue = "";

            // request_date
            $this->request_date->LinkCustomAttributes = "";
            $this->request_date->HrefValue = "";

            // request_message
            $this->request_message->LinkCustomAttributes = "";
            $this->request_message->HrefValue = "";

            // contact_id
            $this->contact_id->LinkCustomAttributes = "";
            $this->contact_id->HrefValue = "";

            // contact_code
            $this->contact_code->LinkCustomAttributes = "";
            $this->contact_code->HrefValue = "";

            // contact_name
            $this->contact_name->LinkCustomAttributes = "";
            $this->contact_name->HrefValue = "";

            // contact_type
            $this->contact_type->LinkCustomAttributes = "";
            $this->contact_type->HrefValue = "";

            // contact_taxnumber
            $this->contact_taxnumber->LinkCustomAttributes = "";
            $this->contact_taxnumber->HrefValue = "";

            // contact_branchcode
            $this->contact_branchcode->LinkCustomAttributes = "";
            $this->contact_branchcode->HrefValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";

            // contact_subdistrict
            $this->contact_subdistrict->LinkCustomAttributes = "";
            $this->contact_subdistrict->HrefValue = "";

            // contact_district
            $this->contact_district->LinkCustomAttributes = "";
            $this->contact_district->HrefValue = "";

            // contact_province
            $this->contact_province->LinkCustomAttributes = "";
            $this->contact_province->HrefValue = "";

            // contact_country
            $this->contact_country->LinkCustomAttributes = "";
            $this->contact_country->HrefValue = "";

            // contact_postcode
            $this->contact_postcode->LinkCustomAttributes = "";
            $this->contact_postcode->HrefValue = "";

            // contact_callcenternumber
            $this->contact_callcenternumber->LinkCustomAttributes = "";
            $this->contact_callcenternumber->HrefValue = "";

            // contact_faxnumber
            $this->contact_faxnumber->LinkCustomAttributes = "";
            $this->contact_faxnumber->HrefValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";

            // contact_website
            $this->contact_website->LinkCustomAttributes = "";
            $this->contact_website->HrefValue = "";

            // contact_contactfirstname
            $this->contact_contactfirstname->LinkCustomAttributes = "";
            $this->contact_contactfirstname->HrefValue = "";

            // contact_contactlastname
            $this->contact_contactlastname->LinkCustomAttributes = "";
            $this->contact_contactlastname->HrefValue = "";

            // contact_contactnickname
            $this->contact_contactnickname->LinkCustomAttributes = "";
            $this->contact_contactnickname->HrefValue = "";

            // contact_contactpostition
            $this->contact_contactpostition->LinkCustomAttributes = "";
            $this->contact_contactpostition->HrefValue = "";

            // contact_contactphonenumber
            $this->contact_contactphonenumber->LinkCustomAttributes = "";
            $this->contact_contactphonenumber->HrefValue = "";

            // contact_contactcontactemail
            $this->contact_contactcontactemail->LinkCustomAttributes = "";
            $this->contact_contactcontactemail->HrefValue = "";

            // contact_purchaseaccount
            $this->contact_purchaseaccount->LinkCustomAttributes = "";
            $this->contact_purchaseaccount->HrefValue = "";

            // contact_sellaccount
            $this->contact_sellaccount->LinkCustomAttributes = "";
            $this->contact_sellaccount->HrefValue = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->create_date->Required) {
            if (!$this->create_date->IsDetailKey && EmptyValue($this->create_date->FormValue)) {
                $this->create_date->addErrorMessage(str_replace("%s", $this->create_date->caption(), $this->create_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->create_date->FormValue, $this->create_date->formatPattern())) {
            $this->create_date->addErrorMessage($this->create_date->getErrorMessage(false));
        }
        if ($this->request_status->Required) {
            if (!$this->request_status->IsDetailKey && EmptyValue($this->request_status->FormValue)) {
                $this->request_status->addErrorMessage(str_replace("%s", $this->request_status->caption(), $this->request_status->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->request_status->FormValue)) {
            $this->request_status->addErrorMessage($this->request_status->getErrorMessage(false));
        }
        if ($this->request_date->Required) {
            if (!$this->request_date->IsDetailKey && EmptyValue($this->request_date->FormValue)) {
                $this->request_date->addErrorMessage(str_replace("%s", $this->request_date->caption(), $this->request_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->request_date->FormValue, $this->request_date->formatPattern())) {
            $this->request_date->addErrorMessage($this->request_date->getErrorMessage(false));
        }
        if ($this->request_message->Required) {
            if (!$this->request_message->IsDetailKey && EmptyValue($this->request_message->FormValue)) {
                $this->request_message->addErrorMessage(str_replace("%s", $this->request_message->caption(), $this->request_message->RequiredErrorMessage));
            }
        }
        if ($this->contact_id->Required) {
            if (!$this->contact_id->IsDetailKey && EmptyValue($this->contact_id->FormValue)) {
                $this->contact_id->addErrorMessage(str_replace("%s", $this->contact_id->caption(), $this->contact_id->RequiredErrorMessage));
            }
        }
        if ($this->contact_code->Required) {
            if (!$this->contact_code->IsDetailKey && EmptyValue($this->contact_code->FormValue)) {
                $this->contact_code->addErrorMessage(str_replace("%s", $this->contact_code->caption(), $this->contact_code->RequiredErrorMessage));
            }
        }
        if ($this->contact_name->Required) {
            if (!$this->contact_name->IsDetailKey && EmptyValue($this->contact_name->FormValue)) {
                $this->contact_name->addErrorMessage(str_replace("%s", $this->contact_name->caption(), $this->contact_name->RequiredErrorMessage));
            }
        }
        if ($this->contact_type->Required) {
            if (!$this->contact_type->IsDetailKey && EmptyValue($this->contact_type->FormValue)) {
                $this->contact_type->addErrorMessage(str_replace("%s", $this->contact_type->caption(), $this->contact_type->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->contact_type->FormValue)) {
            $this->contact_type->addErrorMessage($this->contact_type->getErrorMessage(false));
        }
        if ($this->contact_taxnumber->Required) {
            if (!$this->contact_taxnumber->IsDetailKey && EmptyValue($this->contact_taxnumber->FormValue)) {
                $this->contact_taxnumber->addErrorMessage(str_replace("%s", $this->contact_taxnumber->caption(), $this->contact_taxnumber->RequiredErrorMessage));
            }
        }
        if ($this->contact_branchcode->Required) {
            if (!$this->contact_branchcode->IsDetailKey && EmptyValue($this->contact_branchcode->FormValue)) {
                $this->contact_branchcode->addErrorMessage(str_replace("%s", $this->contact_branchcode->caption(), $this->contact_branchcode->RequiredErrorMessage));
            }
        }
        if ($this->contact_address->Required) {
            if (!$this->contact_address->IsDetailKey && EmptyValue($this->contact_address->FormValue)) {
                $this->contact_address->addErrorMessage(str_replace("%s", $this->contact_address->caption(), $this->contact_address->RequiredErrorMessage));
            }
        }
        if ($this->contact_subdistrict->Required) {
            if (!$this->contact_subdistrict->IsDetailKey && EmptyValue($this->contact_subdistrict->FormValue)) {
                $this->contact_subdistrict->addErrorMessage(str_replace("%s", $this->contact_subdistrict->caption(), $this->contact_subdistrict->RequiredErrorMessage));
            }
        }
        if ($this->contact_district->Required) {
            if (!$this->contact_district->IsDetailKey && EmptyValue($this->contact_district->FormValue)) {
                $this->contact_district->addErrorMessage(str_replace("%s", $this->contact_district->caption(), $this->contact_district->RequiredErrorMessage));
            }
        }
        if ($this->contact_province->Required) {
            if (!$this->contact_province->IsDetailKey && EmptyValue($this->contact_province->FormValue)) {
                $this->contact_province->addErrorMessage(str_replace("%s", $this->contact_province->caption(), $this->contact_province->RequiredErrorMessage));
            }
        }
        if ($this->contact_country->Required) {
            if (!$this->contact_country->IsDetailKey && EmptyValue($this->contact_country->FormValue)) {
                $this->contact_country->addErrorMessage(str_replace("%s", $this->contact_country->caption(), $this->contact_country->RequiredErrorMessage));
            }
        }
        if ($this->contact_postcode->Required) {
            if (!$this->contact_postcode->IsDetailKey && EmptyValue($this->contact_postcode->FormValue)) {
                $this->contact_postcode->addErrorMessage(str_replace("%s", $this->contact_postcode->caption(), $this->contact_postcode->RequiredErrorMessage));
            }
        }
        if ($this->contact_callcenternumber->Required) {
            if (!$this->contact_callcenternumber->IsDetailKey && EmptyValue($this->contact_callcenternumber->FormValue)) {
                $this->contact_callcenternumber->addErrorMessage(str_replace("%s", $this->contact_callcenternumber->caption(), $this->contact_callcenternumber->RequiredErrorMessage));
            }
        }
        if ($this->contact_faxnumber->Required) {
            if (!$this->contact_faxnumber->IsDetailKey && EmptyValue($this->contact_faxnumber->FormValue)) {
                $this->contact_faxnumber->addErrorMessage(str_replace("%s", $this->contact_faxnumber->caption(), $this->contact_faxnumber->RequiredErrorMessage));
            }
        }
        if ($this->contact_email->Required) {
            if (!$this->contact_email->IsDetailKey && EmptyValue($this->contact_email->FormValue)) {
                $this->contact_email->addErrorMessage(str_replace("%s", $this->contact_email->caption(), $this->contact_email->RequiredErrorMessage));
            }
        }
        if ($this->contact_website->Required) {
            if (!$this->contact_website->IsDetailKey && EmptyValue($this->contact_website->FormValue)) {
                $this->contact_website->addErrorMessage(str_replace("%s", $this->contact_website->caption(), $this->contact_website->RequiredErrorMessage));
            }
        }
        if ($this->contact_contactfirstname->Required) {
            if (!$this->contact_contactfirstname->IsDetailKey && EmptyValue($this->contact_contactfirstname->FormValue)) {
                $this->contact_contactfirstname->addErrorMessage(str_replace("%s", $this->contact_contactfirstname->caption(), $this->contact_contactfirstname->RequiredErrorMessage));
            }
        }
        if ($this->contact_contactlastname->Required) {
            if (!$this->contact_contactlastname->IsDetailKey && EmptyValue($this->contact_contactlastname->FormValue)) {
                $this->contact_contactlastname->addErrorMessage(str_replace("%s", $this->contact_contactlastname->caption(), $this->contact_contactlastname->RequiredErrorMessage));
            }
        }
        if ($this->contact_contactnickname->Required) {
            if (!$this->contact_contactnickname->IsDetailKey && EmptyValue($this->contact_contactnickname->FormValue)) {
                $this->contact_contactnickname->addErrorMessage(str_replace("%s", $this->contact_contactnickname->caption(), $this->contact_contactnickname->RequiredErrorMessage));
            }
        }
        if ($this->contact_contactpostition->Required) {
            if (!$this->contact_contactpostition->IsDetailKey && EmptyValue($this->contact_contactpostition->FormValue)) {
                $this->contact_contactpostition->addErrorMessage(str_replace("%s", $this->contact_contactpostition->caption(), $this->contact_contactpostition->RequiredErrorMessage));
            }
        }
        if ($this->contact_contactphonenumber->Required) {
            if (!$this->contact_contactphonenumber->IsDetailKey && EmptyValue($this->contact_contactphonenumber->FormValue)) {
                $this->contact_contactphonenumber->addErrorMessage(str_replace("%s", $this->contact_contactphonenumber->caption(), $this->contact_contactphonenumber->RequiredErrorMessage));
            }
        }
        if ($this->contact_contactcontactemail->Required) {
            if (!$this->contact_contactcontactemail->IsDetailKey && EmptyValue($this->contact_contactcontactemail->FormValue)) {
                $this->contact_contactcontactemail->addErrorMessage(str_replace("%s", $this->contact_contactcontactemail->caption(), $this->contact_contactcontactemail->RequiredErrorMessage));
            }
        }
        if ($this->contact_purchaseaccount->Required) {
            if (!$this->contact_purchaseaccount->IsDetailKey && EmptyValue($this->contact_purchaseaccount->FormValue)) {
                $this->contact_purchaseaccount->addErrorMessage(str_replace("%s", $this->contact_purchaseaccount->caption(), $this->contact_purchaseaccount->RequiredErrorMessage));
            }
        }
        if ($this->contact_sellaccount->Required) {
            if (!$this->contact_sellaccount->IsDetailKey && EmptyValue($this->contact_sellaccount->FormValue)) {
                $this->contact_sellaccount->addErrorMessage(str_replace("%s", $this->contact_sellaccount->caption(), $this->contact_sellaccount->RequiredErrorMessage));
            }
        }
        if ($this->member_id->Required) {
            if (!$this->member_id->IsDetailKey && EmptyValue($this->member_id->FormValue)) {
                $this->member_id->addErrorMessage(str_replace("%s", $this->member_id->caption(), $this->member_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->member_id->FormValue)) {
            $this->member_id->addErrorMessage($this->member_id->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // create_date
        $this->create_date->setDbValueDef($rsnew, UnFormatDateTime($this->create_date->CurrentValue, $this->create_date->formatPattern()), null, false);

        // request_status
        $this->request_status->setDbValueDef($rsnew, $this->request_status->CurrentValue, null, false);

        // request_date
        $this->request_date->setDbValueDef($rsnew, UnFormatDateTime($this->request_date->CurrentValue, $this->request_date->formatPattern()), null, false);

        // request_message
        $this->request_message->setDbValueDef($rsnew, $this->request_message->CurrentValue, null, false);

        // contact_id
        $this->contact_id->setDbValueDef($rsnew, $this->contact_id->CurrentValue, null, false);

        // contact_code
        $this->contact_code->setDbValueDef($rsnew, $this->contact_code->CurrentValue, null, false);

        // contact_name
        $this->contact_name->setDbValueDef($rsnew, $this->contact_name->CurrentValue, null, false);

        // contact_type
        $this->contact_type->setDbValueDef($rsnew, $this->contact_type->CurrentValue, null, false);

        // contact_taxnumber
        $this->contact_taxnumber->setDbValueDef($rsnew, $this->contact_taxnumber->CurrentValue, null, false);

        // contact_branchcode
        $this->contact_branchcode->setDbValueDef($rsnew, $this->contact_branchcode->CurrentValue, null, false);

        // contact_address
        $this->contact_address->setDbValueDef($rsnew, $this->contact_address->CurrentValue, null, false);

        // contact_subdistrict
        $this->contact_subdistrict->setDbValueDef($rsnew, $this->contact_subdistrict->CurrentValue, null, false);

        // contact_district
        $this->contact_district->setDbValueDef($rsnew, $this->contact_district->CurrentValue, null, false);

        // contact_province
        $this->contact_province->setDbValueDef($rsnew, $this->contact_province->CurrentValue, null, false);

        // contact_country
        $this->contact_country->setDbValueDef($rsnew, $this->contact_country->CurrentValue, null, false);

        // contact_postcode
        $this->contact_postcode->setDbValueDef($rsnew, $this->contact_postcode->CurrentValue, null, false);

        // contact_callcenternumber
        $this->contact_callcenternumber->setDbValueDef($rsnew, $this->contact_callcenternumber->CurrentValue, null, false);

        // contact_faxnumber
        $this->contact_faxnumber->setDbValueDef($rsnew, $this->contact_faxnumber->CurrentValue, null, false);

        // contact_email
        $this->contact_email->setDbValueDef($rsnew, $this->contact_email->CurrentValue, null, false);

        // contact_website
        $this->contact_website->setDbValueDef($rsnew, $this->contact_website->CurrentValue, null, false);

        // contact_contactfirstname
        $this->contact_contactfirstname->setDbValueDef($rsnew, $this->contact_contactfirstname->CurrentValue, null, false);

        // contact_contactlastname
        $this->contact_contactlastname->setDbValueDef($rsnew, $this->contact_contactlastname->CurrentValue, null, false);

        // contact_contactnickname
        $this->contact_contactnickname->setDbValueDef($rsnew, $this->contact_contactnickname->CurrentValue, null, false);

        // contact_contactpostition
        $this->contact_contactpostition->setDbValueDef($rsnew, $this->contact_contactpostition->CurrentValue, null, false);

        // contact_contactphonenumber
        $this->contact_contactphonenumber->setDbValueDef($rsnew, $this->contact_contactphonenumber->CurrentValue, null, false);

        // contact_contactcontactemail
        $this->contact_contactcontactemail->setDbValueDef($rsnew, $this->contact_contactcontactemail->CurrentValue, null, false);

        // contact_purchaseaccount
        $this->contact_purchaseaccount->setDbValueDef($rsnew, $this->contact_purchaseaccount->CurrentValue, null, false);

        // contact_sellaccount
        $this->contact_sellaccount->setDbValueDef($rsnew, $this->contact_sellaccount->CurrentValue, null, false);

        // member_id
        $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, 0, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakcontactlist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
