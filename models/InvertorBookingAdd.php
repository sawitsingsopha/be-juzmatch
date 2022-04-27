<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class InvertorBookingAdd extends InvertorBooking
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'invertor_booking';

    // Page object name
    public $PageObjName = "InvertorBookingAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Audit Trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

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

        // Table object (invertor_booking)
        if (!isset($GLOBALS["invertor_booking"]) || get_class($GLOBALS["invertor_booking"]) == PROJECT_NAMESPACE . "invertor_booking") {
            $GLOBALS["invertor_booking"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'invertor_booking');
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
                $tbl = Container("invertor_booking");
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
                    if ($pageName == "invertorbookingview") {
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
            $key .= @$ar['invertor_booking_id'];
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
            $this->invertor_booking_id->Visible = false;
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
        $this->invertor_booking_id->Visible = false;
        $this->member_id->setVisibility();
        $this->asset_id->setVisibility();
        $this->date_booking->setVisibility();
        $this->status_expire->setVisibility();
        $this->status_expire_reason->setVisibility();
        $this->payment_status->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->udate->setVisibility();
        $this->is_email->setVisibility();
        $this->receipt_status->setVisibility();
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
        $this->setupLookupOptions($this->member_id);
        $this->setupLookupOptions($this->asset_id);
        $this->setupLookupOptions($this->status_expire);
        $this->setupLookupOptions($this->payment_status);

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
            if (($keyValue = Get("invertor_booking_id") ?? Route("invertor_booking_id")) !== null) {
                $this->invertor_booking_id->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("invertorbookinglist"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "invertorbookinglist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "invertorbookingview") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->invertor_booking_id->CurrentValue = null;
        $this->invertor_booking_id->OldValue = $this->invertor_booking_id->CurrentValue;
        $this->member_id->CurrentValue = null;
        $this->member_id->OldValue = $this->member_id->CurrentValue;
        $this->asset_id->CurrentValue = null;
        $this->asset_id->OldValue = $this->asset_id->CurrentValue;
        $this->date_booking->CurrentValue = null;
        $this->date_booking->OldValue = $this->date_booking->CurrentValue;
        $this->status_expire->CurrentValue = 0;
        $this->status_expire_reason->CurrentValue = null;
        $this->status_expire_reason->OldValue = $this->status_expire_reason->CurrentValue;
        $this->payment_status->CurrentValue = null;
        $this->payment_status->OldValue = $this->payment_status->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->is_email->CurrentValue = null;
        $this->is_email->OldValue = $this->is_email->CurrentValue;
        $this->receipt_status->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'member_id' first before field var 'x_member_id'
        $val = $CurrentForm->hasValue("member_id") ? $CurrentForm->getValue("member_id") : $CurrentForm->getValue("x_member_id");
        if (!$this->member_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->member_id->Visible = false; // Disable update for API request
            } else {
                $this->member_id->setFormValue($val);
            }
        }

        // Check field name 'asset_id' first before field var 'x_asset_id'
        $val = $CurrentForm->hasValue("asset_id") ? $CurrentForm->getValue("asset_id") : $CurrentForm->getValue("x_asset_id");
        if (!$this->asset_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_id->Visible = false; // Disable update for API request
            } else {
                $this->asset_id->setFormValue($val);
            }
        }

        // Check field name 'date_booking' first before field var 'x_date_booking'
        $val = $CurrentForm->hasValue("date_booking") ? $CurrentForm->getValue("date_booking") : $CurrentForm->getValue("x_date_booking");
        if (!$this->date_booking->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date_booking->Visible = false; // Disable update for API request
            } else {
                $this->date_booking->setFormValue($val, true, $validate);
            }
            $this->date_booking->CurrentValue = UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        }

        // Check field name 'status_expire' first before field var 'x_status_expire'
        $val = $CurrentForm->hasValue("status_expire") ? $CurrentForm->getValue("status_expire") : $CurrentForm->getValue("x_status_expire");
        if (!$this->status_expire->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_expire->Visible = false; // Disable update for API request
            } else {
                $this->status_expire->setFormValue($val);
            }
        }

        // Check field name 'status_expire_reason' first before field var 'x_status_expire_reason'
        $val = $CurrentForm->hasValue("status_expire_reason") ? $CurrentForm->getValue("status_expire_reason") : $CurrentForm->getValue("x_status_expire_reason");
        if (!$this->status_expire_reason->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_expire_reason->Visible = false; // Disable update for API request
            } else {
                $this->status_expire_reason->setFormValue($val);
            }
        }

        // Check field name 'payment_status' first before field var 'x_payment_status'
        $val = $CurrentForm->hasValue("payment_status") ? $CurrentForm->getValue("payment_status") : $CurrentForm->getValue("x_payment_status");
        if (!$this->payment_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->payment_status->Visible = false; // Disable update for API request
            } else {
                $this->payment_status->setFormValue($val);
            }
        }

        // Check field name 'cdate' first before field var 'x_cdate'
        $val = $CurrentForm->hasValue("cdate") ? $CurrentForm->getValue("cdate") : $CurrentForm->getValue("x_cdate");
        if (!$this->cdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cdate->Visible = false; // Disable update for API request
            } else {
                $this->cdate->setFormValue($val);
            }
            $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        }

        // Check field name 'cuser' first before field var 'x_cuser'
        $val = $CurrentForm->hasValue("cuser") ? $CurrentForm->getValue("cuser") : $CurrentForm->getValue("x_cuser");
        if (!$this->cuser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cuser->Visible = false; // Disable update for API request
            } else {
                $this->cuser->setFormValue($val);
            }
        }

        // Check field name 'cip' first before field var 'x_cip'
        $val = $CurrentForm->hasValue("cip") ? $CurrentForm->getValue("cip") : $CurrentForm->getValue("x_cip");
        if (!$this->cip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cip->Visible = false; // Disable update for API request
            } else {
                $this->cip->setFormValue($val);
            }
        }

        // Check field name 'uuser' first before field var 'x_uuser'
        $val = $CurrentForm->hasValue("uuser") ? $CurrentForm->getValue("uuser") : $CurrentForm->getValue("x_uuser");
        if (!$this->uuser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uuser->Visible = false; // Disable update for API request
            } else {
                $this->uuser->setFormValue($val);
            }
        }

        // Check field name 'uip' first before field var 'x_uip'
        $val = $CurrentForm->hasValue("uip") ? $CurrentForm->getValue("uip") : $CurrentForm->getValue("x_uip");
        if (!$this->uip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uip->Visible = false; // Disable update for API request
            } else {
                $this->uip->setFormValue($val);
            }
        }

        // Check field name 'udate' first before field var 'x_udate'
        $val = $CurrentForm->hasValue("udate") ? $CurrentForm->getValue("udate") : $CurrentForm->getValue("x_udate");
        if (!$this->udate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->udate->Visible = false; // Disable update for API request
            } else {
                $this->udate->setFormValue($val);
            }
            $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        }

        // Check field name 'is_email' first before field var 'x_is_email'
        $val = $CurrentForm->hasValue("is_email") ? $CurrentForm->getValue("is_email") : $CurrentForm->getValue("x_is_email");
        if (!$this->is_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_email->Visible = false; // Disable update for API request
            } else {
                $this->is_email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'receipt_status' first before field var 'x_receipt_status'
        $val = $CurrentForm->hasValue("receipt_status") ? $CurrentForm->getValue("receipt_status") : $CurrentForm->getValue("x_receipt_status");
        if (!$this->receipt_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receipt_status->Visible = false; // Disable update for API request
            } else {
                $this->receipt_status->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invertor_booking_id' first before field var 'x_invertor_booking_id'
        $val = $CurrentForm->hasValue("invertor_booking_id") ? $CurrentForm->getValue("invertor_booking_id") : $CurrentForm->getValue("x_invertor_booking_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->asset_id->CurrentValue = $this->asset_id->FormValue;
        $this->date_booking->CurrentValue = $this->date_booking->FormValue;
        $this->date_booking->CurrentValue = UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern());
        $this->status_expire->CurrentValue = $this->status_expire->FormValue;
        $this->status_expire_reason->CurrentValue = $this->status_expire_reason->FormValue;
        $this->payment_status->CurrentValue = $this->payment_status->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->is_email->CurrentValue = $this->is_email->FormValue;
        $this->receipt_status->CurrentValue = $this->receipt_status->FormValue;
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
        $this->invertor_booking_id->setDbValue($row['invertor_booking_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->asset_id->setDbValue($row['asset_id']);
        $this->date_booking->setDbValue($row['date_booking']);
        $this->status_expire->setDbValue($row['status_expire']);
        $this->status_expire_reason->setDbValue($row['status_expire_reason']);
        $this->payment_status->setDbValue($row['payment_status']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->udate->setDbValue($row['udate']);
        $this->is_email->setDbValue($row['is_email']);
        $this->receipt_status->setDbValue($row['receipt_status']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['invertor_booking_id'] = $this->invertor_booking_id->CurrentValue;
        $row['member_id'] = $this->member_id->CurrentValue;
        $row['asset_id'] = $this->asset_id->CurrentValue;
        $row['date_booking'] = $this->date_booking->CurrentValue;
        $row['status_expire'] = $this->status_expire->CurrentValue;
        $row['status_expire_reason'] = $this->status_expire_reason->CurrentValue;
        $row['payment_status'] = $this->payment_status->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['is_email'] = $this->is_email->CurrentValue;
        $row['receipt_status'] = $this->receipt_status->CurrentValue;
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

        // invertor_booking_id
        $this->invertor_booking_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // asset_id
        $this->asset_id->RowCssClass = "row";

        // date_booking
        $this->date_booking->RowCssClass = "row";

        // status_expire
        $this->status_expire->RowCssClass = "row";

        // status_expire_reason
        $this->status_expire_reason->RowCssClass = "row";

        // payment_status
        $this->payment_status->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // is_email
        $this->is_email->RowCssClass = "row";

        // receipt_status
        $this->receipt_status->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // member_id
            $curVal = strval($this->member_id->CurrentValue);
            if ($curVal != "") {
                $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
                if ($this->member_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // date_booking
            $this->date_booking->ViewValue = $this->date_booking->CurrentValue;
            $this->date_booking->ViewValue = FormatDateTime($this->date_booking->ViewValue, $this->date_booking->formatPattern());
            $this->date_booking->ViewCustomAttributes = "";

            // status_expire
            if (strval($this->status_expire->CurrentValue) != "") {
                $this->status_expire->ViewValue = $this->status_expire->optionCaption($this->status_expire->CurrentValue);
            } else {
                $this->status_expire->ViewValue = null;
            }
            $this->status_expire->ViewCustomAttributes = "";

            // status_expire_reason
            $this->status_expire_reason->ViewValue = $this->status_expire_reason->CurrentValue;
            $this->status_expire_reason->ViewCustomAttributes = "";

            // payment_status
            if (strval($this->payment_status->CurrentValue) != "") {
                $this->payment_status->ViewValue = $this->payment_status->optionCaption($this->payment_status->CurrentValue);
            } else {
                $this->payment_status->ViewValue = null;
            }
            $this->payment_status->ViewCustomAttributes = "";

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

            // is_email
            $this->is_email->ViewValue = $this->is_email->CurrentValue;
            $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
            $this->is_email->ViewCustomAttributes = "";

            // receipt_status
            $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
            $this->receipt_status->ViewValue = FormatNumber($this->receipt_status->ViewValue, $this->receipt_status->formatPattern());
            $this->receipt_status->ViewCustomAttributes = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";
            $this->asset_id->TooltipValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";

            // payment_status
            $this->payment_status->LinkCustomAttributes = "";
            $this->payment_status->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // is_email
            $this->is_email->LinkCustomAttributes = "";
            $this->is_email->HrefValue = "";

            // receipt_status
            $this->receipt_status->LinkCustomAttributes = "";
            $this->receipt_status->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            if ($this->member_id->getSessionValue() != "") {
                $this->member_id->CurrentValue = GetForeignKeyValue($this->member_id->getSessionValue());
                $curVal = strval($this->member_id->CurrentValue);
                if ($curVal != "") {
                    $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
                    if ($this->member_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return "`isactive` = 1";
                        };
                        $lookupFilter = $lookupFilter->bindTo($this);
                        $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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
            } else {
                $curVal = trim(strval($this->member_id->CurrentValue));
                if ($curVal != "") {
                    $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
                } else {
                    $this->member_id->ViewValue = $this->member_id->Lookup !== null && is_array($this->member_id->lookupOptions()) ? $curVal : null;
                }
                if ($this->member_id->ViewValue !== null) { // Load from cache
                    $this->member_id->EditValue = array_values($this->member_id->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`member_id`" . SearchString("=", $this->member_id->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->member_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->member_id->EditValue = $arwrk;
                }
                $this->member_id->PlaceHolder = RemoveHtml($this->member_id->caption());
            }

            // asset_id
            $this->asset_id->setupEditAttributes();
            $this->asset_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->asset_id->CurrentValue));
            if ($curVal != "") {
                $this->asset_id->ViewValue = $this->asset_id->lookupCacheOption($curVal);
            } else {
                $this->asset_id->ViewValue = $this->asset_id->Lookup !== null && is_array($this->asset_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->asset_id->ViewValue !== null) { // Load from cache
                $this->asset_id->EditValue = array_values($this->asset_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`asset_id`" . SearchString("=", $this->asset_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->asset_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->asset_id->EditValue = $arwrk;
            }
            $this->asset_id->PlaceHolder = RemoveHtml($this->asset_id->caption());

            // date_booking
            $this->date_booking->setupEditAttributes();
            $this->date_booking->EditCustomAttributes = "";
            $this->date_booking->EditValue = HtmlEncode(FormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern()));
            $this->date_booking->PlaceHolder = RemoveHtml($this->date_booking->caption());

            // status_expire
            $this->status_expire->EditCustomAttributes = "";
            $this->status_expire->EditValue = $this->status_expire->options(false);
            $this->status_expire->PlaceHolder = RemoveHtml($this->status_expire->caption());

            // status_expire_reason
            $this->status_expire_reason->setupEditAttributes();
            $this->status_expire_reason->EditCustomAttributes = "";
            if (!$this->status_expire_reason->Raw) {
                $this->status_expire_reason->CurrentValue = HtmlDecode($this->status_expire_reason->CurrentValue);
            }
            $this->status_expire_reason->EditValue = HtmlEncode($this->status_expire_reason->CurrentValue);
            $this->status_expire_reason->PlaceHolder = RemoveHtml($this->status_expire_reason->caption());

            // payment_status
            $this->payment_status->EditCustomAttributes = "";
            $this->payment_status->EditValue = $this->payment_status->options(false);
            $this->payment_status->PlaceHolder = RemoveHtml($this->payment_status->caption());

            // cdate

            // cuser

            // cip

            // uuser

            // uip

            // udate

            // is_email
            $this->is_email->setupEditAttributes();
            $this->is_email->EditCustomAttributes = "";
            $this->is_email->EditValue = HtmlEncode($this->is_email->CurrentValue);
            $this->is_email->PlaceHolder = RemoveHtml($this->is_email->caption());
            if (strval($this->is_email->EditValue) != "" && is_numeric($this->is_email->EditValue)) {
                $this->is_email->EditValue = FormatNumber($this->is_email->EditValue, null);
            }

            // receipt_status
            $this->receipt_status->setupEditAttributes();
            $this->receipt_status->EditCustomAttributes = "";
            $this->receipt_status->EditValue = HtmlEncode($this->receipt_status->CurrentValue);
            $this->receipt_status->PlaceHolder = RemoveHtml($this->receipt_status->caption());
            if (strval($this->receipt_status->EditValue) != "" && is_numeric($this->receipt_status->EditValue)) {
                $this->receipt_status->EditValue = FormatNumber($this->receipt_status->EditValue, null);
            }

            // Add refer script

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";

            // asset_id
            $this->asset_id->LinkCustomAttributes = "";
            $this->asset_id->HrefValue = "";

            // date_booking
            $this->date_booking->LinkCustomAttributes = "";
            $this->date_booking->HrefValue = "";

            // status_expire
            $this->status_expire->LinkCustomAttributes = "";
            $this->status_expire->HrefValue = "";

            // status_expire_reason
            $this->status_expire_reason->LinkCustomAttributes = "";
            $this->status_expire_reason->HrefValue = "";

            // payment_status
            $this->payment_status->LinkCustomAttributes = "";
            $this->payment_status->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // is_email
            $this->is_email->LinkCustomAttributes = "";
            $this->is_email->HrefValue = "";

            // receipt_status
            $this->receipt_status->LinkCustomAttributes = "";
            $this->receipt_status->HrefValue = "";
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
        if ($this->member_id->Required) {
            if (!$this->member_id->IsDetailKey && EmptyValue($this->member_id->FormValue)) {
                $this->member_id->addErrorMessage(str_replace("%s", $this->member_id->caption(), $this->member_id->RequiredErrorMessage));
            }
        }
        if ($this->asset_id->Required) {
            if (!$this->asset_id->IsDetailKey && EmptyValue($this->asset_id->FormValue)) {
                $this->asset_id->addErrorMessage(str_replace("%s", $this->asset_id->caption(), $this->asset_id->RequiredErrorMessage));
            }
        }
        if ($this->date_booking->Required) {
            if (!$this->date_booking->IsDetailKey && EmptyValue($this->date_booking->FormValue)) {
                $this->date_booking->addErrorMessage(str_replace("%s", $this->date_booking->caption(), $this->date_booking->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date_booking->FormValue, $this->date_booking->formatPattern())) {
            $this->date_booking->addErrorMessage($this->date_booking->getErrorMessage(false));
        }
        if ($this->status_expire->Required) {
            if ($this->status_expire->FormValue == "") {
                $this->status_expire->addErrorMessage(str_replace("%s", $this->status_expire->caption(), $this->status_expire->RequiredErrorMessage));
            }
        }
        if ($this->status_expire_reason->Required) {
            if (!$this->status_expire_reason->IsDetailKey && EmptyValue($this->status_expire_reason->FormValue)) {
                $this->status_expire_reason->addErrorMessage(str_replace("%s", $this->status_expire_reason->caption(), $this->status_expire_reason->RequiredErrorMessage));
            }
        }
        if ($this->payment_status->Required) {
            if ($this->payment_status->FormValue == "") {
                $this->payment_status->addErrorMessage(str_replace("%s", $this->payment_status->caption(), $this->payment_status->RequiredErrorMessage));
            }
        }
        if ($this->cdate->Required) {
            if (!$this->cdate->IsDetailKey && EmptyValue($this->cdate->FormValue)) {
                $this->cdate->addErrorMessage(str_replace("%s", $this->cdate->caption(), $this->cdate->RequiredErrorMessage));
            }
        }
        if ($this->cuser->Required) {
            if (!$this->cuser->IsDetailKey && EmptyValue($this->cuser->FormValue)) {
                $this->cuser->addErrorMessage(str_replace("%s", $this->cuser->caption(), $this->cuser->RequiredErrorMessage));
            }
        }
        if ($this->cip->Required) {
            if (!$this->cip->IsDetailKey && EmptyValue($this->cip->FormValue)) {
                $this->cip->addErrorMessage(str_replace("%s", $this->cip->caption(), $this->cip->RequiredErrorMessage));
            }
        }
        if ($this->uuser->Required) {
            if (!$this->uuser->IsDetailKey && EmptyValue($this->uuser->FormValue)) {
                $this->uuser->addErrorMessage(str_replace("%s", $this->uuser->caption(), $this->uuser->RequiredErrorMessage));
            }
        }
        if ($this->uip->Required) {
            if (!$this->uip->IsDetailKey && EmptyValue($this->uip->FormValue)) {
                $this->uip->addErrorMessage(str_replace("%s", $this->uip->caption(), $this->uip->RequiredErrorMessage));
            }
        }
        if ($this->udate->Required) {
            if (!$this->udate->IsDetailKey && EmptyValue($this->udate->FormValue)) {
                $this->udate->addErrorMessage(str_replace("%s", $this->udate->caption(), $this->udate->RequiredErrorMessage));
            }
        }
        if ($this->is_email->Required) {
            if (!$this->is_email->IsDetailKey && EmptyValue($this->is_email->FormValue)) {
                $this->is_email->addErrorMessage(str_replace("%s", $this->is_email->caption(), $this->is_email->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->is_email->FormValue)) {
            $this->is_email->addErrorMessage($this->is_email->getErrorMessage(false));
        }
        if ($this->receipt_status->Required) {
            if (!$this->receipt_status->IsDetailKey && EmptyValue($this->receipt_status->FormValue)) {
                $this->receipt_status->addErrorMessage(str_replace("%s", $this->receipt_status->caption(), $this->receipt_status->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->receipt_status->FormValue)) {
            $this->receipt_status->addErrorMessage($this->receipt_status->getErrorMessage(false));
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("PaymentInverterBookingGrid");
        if (in_array("payment_inverter_booking", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // Check referential integrity for master table 'invertor_booking'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["member_id"] = $this->member_id->CurrentValue;
        $masterTable = Container("investor");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "investor", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // member_id
        $this->member_id->setDbValueDef($rsnew, $this->member_id->CurrentValue, 0, false);

        // asset_id
        $this->asset_id->setDbValueDef($rsnew, $this->asset_id->CurrentValue, 0, false);

        // date_booking
        $this->date_booking->setDbValueDef($rsnew, UnFormatDateTime($this->date_booking->CurrentValue, $this->date_booking->formatPattern()), null, false);

        // status_expire
        $this->status_expire->setDbValueDef($rsnew, $this->status_expire->CurrentValue, 0, strval($this->status_expire->CurrentValue) == "");

        // status_expire_reason
        $this->status_expire_reason->setDbValueDef($rsnew, $this->status_expire_reason->CurrentValue, null, false);

        // payment_status
        $this->payment_status->setDbValueDef($rsnew, $this->payment_status->CurrentValue, 0, strval($this->payment_status->CurrentValue) == "");

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // cuser
        $this->cuser->CurrentValue = CurrentUserID();
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null);

        // cip
        $this->cip->CurrentValue = CurrentUserIP();
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null);

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

        // udate
        $this->udate->CurrentValue = CurrentDateTime();
        $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

        // is_email
        $this->is_email->setDbValueDef($rsnew, $this->is_email->CurrentValue, 0, strval($this->is_email->CurrentValue) == "");

        // receipt_status
        $this->receipt_status->setDbValueDef($rsnew, $this->receipt_status->CurrentValue, 0, strval($this->receipt_status->CurrentValue) == "");

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("PaymentInverterBookingGrid");
            if (in_array("payment_inverter_booking", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->member_id->setSessionValue($this->member_id->CurrentValue); // Set master key
                $detailPage->asset_id->setSessionValue($this->asset_id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "payment_inverter_booking"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->member_id->setSessionValue(""); // Clear master key if insert failed
                $detailPage->asset_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    $conn->commit();
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    $conn->rollback();
                }
            }
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "investor") {
                $validMaster = true;
                $masterTbl = Container("investor");
                if (($parm = Get("fk_member_id", Get("member_id"))) !== null) {
                    $masterTbl->member_id->setQueryStringValue($parm);
                    $this->member_id->setQueryStringValue($masterTbl->member_id->QueryStringValue);
                    $this->member_id->setSessionValue($this->member_id->QueryStringValue);
                    if (!is_numeric($masterTbl->member_id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "investor") {
                $validMaster = true;
                $masterTbl = Container("investor");
                if (($parm = Post("fk_member_id", Post("member_id"))) !== null) {
                    $masterTbl->member_id->setFormValue($parm);
                    $this->member_id->setFormValue($masterTbl->member_id->FormValue);
                    $this->member_id->setSessionValue($this->member_id->FormValue);
                    if (!is_numeric($masterTbl->member_id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "investor") {
                if ($this->member_id->CurrentValue == "") {
                    $this->member_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("payment_inverter_booking", $detailTblVar)) {
                $detailPageObj = Container("PaymentInverterBookingGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->member_id->IsDetailKey = true;
                    $detailPageObj->member_id->CurrentValue = $this->member_id->CurrentValue;
                    $detailPageObj->member_id->setSessionValue($detailPageObj->member_id->CurrentValue);
                    $detailPageObj->asset_id->IsDetailKey = true;
                    $detailPageObj->asset_id->CurrentValue = $this->asset_id->CurrentValue;
                    $detailPageObj->asset_id->setSessionValue($detailPageObj->asset_id->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("invertorbookinglist"), "", $this->TableVar, true);
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
                case "x_member_id":
                    $lookupFilter = function () {
                        return "`isactive` = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_asset_id":
                    break;
                case "x_status_expire":
                    break;
                case "x_payment_status":
                    break;
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
