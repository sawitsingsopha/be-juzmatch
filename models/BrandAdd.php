<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class BrandAdd extends Brand
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'brand';

    // Page object name
    public $PageObjName = "BrandAdd";

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

        // Table object (brand)
        if (!isset($GLOBALS["brand"]) || get_class($GLOBALS["brand"]) == PROJECT_NAMESPACE . "brand") {
            $GLOBALS["brand"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'brand');
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
                $tbl = Container("brand");
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
                    if ($pageName == "brandview") {
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
            $key .= @$ar['brand_id'];
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
            $this->brand_id->Visible = false;
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
        $this->brand_id->Visible = false;
        $this->brand_name->setVisibility();
        $this->brand_name_en->setVisibility();
        $this->company_name->setVisibility();
        $this->company_name_en->setVisibility();
        $this->icon->Visible = false;
        $this->order_by->setVisibility();
        $this->isactive->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->udate->setVisibility();
        $this->uip->setVisibility();
        $this->uuser->setVisibility();
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
        $this->setupLookupOptions($this->isactive);

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
            if (($keyValue = Get("brand_id") ?? Route("brand_id")) !== null) {
                $this->brand_id->setQueryStringValue($keyValue);
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
                    $this->terminate("brandlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "brandlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "brandview") {
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
        $this->brand_id->CurrentValue = null;
        $this->brand_id->OldValue = $this->brand_id->CurrentValue;
        $this->brand_name->CurrentValue = null;
        $this->brand_name->OldValue = $this->brand_name->CurrentValue;
        $this->brand_name_en->CurrentValue = null;
        $this->brand_name_en->OldValue = $this->brand_name_en->CurrentValue;
        $this->company_name->CurrentValue = null;
        $this->company_name->OldValue = $this->company_name->CurrentValue;
        $this->company_name_en->CurrentValue = null;
        $this->company_name_en->OldValue = $this->company_name_en->CurrentValue;
        $this->icon->CurrentValue = null;
        $this->icon->OldValue = $this->icon->CurrentValue;
        $this->order_by->CurrentValue = null;
        $this->order_by->OldValue = $this->order_by->CurrentValue;
        $this->isactive->CurrentValue = null;
        $this->isactive->OldValue = $this->isactive->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'brand_name' first before field var 'x_brand_name'
        $val = $CurrentForm->hasValue("brand_name") ? $CurrentForm->getValue("brand_name") : $CurrentForm->getValue("x_brand_name");
        if (!$this->brand_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->brand_name->Visible = false; // Disable update for API request
            } else {
                $this->brand_name->setFormValue($val);
            }
        }

        // Check field name 'brand_name_en' first before field var 'x_brand_name_en'
        $val = $CurrentForm->hasValue("brand_name_en") ? $CurrentForm->getValue("brand_name_en") : $CurrentForm->getValue("x_brand_name_en");
        if (!$this->brand_name_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->brand_name_en->Visible = false; // Disable update for API request
            } else {
                $this->brand_name_en->setFormValue($val);
            }
        }

        // Check field name 'company_name' first before field var 'x_company_name'
        $val = $CurrentForm->hasValue("company_name") ? $CurrentForm->getValue("company_name") : $CurrentForm->getValue("x_company_name");
        if (!$this->company_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_name->Visible = false; // Disable update for API request
            } else {
                $this->company_name->setFormValue($val);
            }
        }

        // Check field name 'company_name_en' first before field var 'x_company_name_en'
        $val = $CurrentForm->hasValue("company_name_en") ? $CurrentForm->getValue("company_name_en") : $CurrentForm->getValue("x_company_name_en");
        if (!$this->company_name_en->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_name_en->Visible = false; // Disable update for API request
            } else {
                $this->company_name_en->setFormValue($val);
            }
        }

        // Check field name 'order_by' first before field var 'x_order_by'
        $val = $CurrentForm->hasValue("order_by") ? $CurrentForm->getValue("order_by") : $CurrentForm->getValue("x_order_by");
        if (!$this->order_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->order_by->Visible = false; // Disable update for API request
            } else {
                $this->order_by->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'isactive' first before field var 'x_isactive'
        $val = $CurrentForm->hasValue("isactive") ? $CurrentForm->getValue("isactive") : $CurrentForm->getValue("x_isactive");
        if (!$this->isactive->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isactive->Visible = false; // Disable update for API request
            } else {
                $this->isactive->setFormValue($val);
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

        // Check field name 'uip' first before field var 'x_uip'
        $val = $CurrentForm->hasValue("uip") ? $CurrentForm->getValue("uip") : $CurrentForm->getValue("x_uip");
        if (!$this->uip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uip->Visible = false; // Disable update for API request
            } else {
                $this->uip->setFormValue($val);
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

        // Check field name 'brand_id' first before field var 'x_brand_id'
        $val = $CurrentForm->hasValue("brand_id") ? $CurrentForm->getValue("brand_id") : $CurrentForm->getValue("x_brand_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->brand_name->CurrentValue = $this->brand_name->FormValue;
        $this->brand_name_en->CurrentValue = $this->brand_name_en->FormValue;
        $this->company_name->CurrentValue = $this->company_name->FormValue;
        $this->company_name_en->CurrentValue = $this->company_name_en->FormValue;
        $this->order_by->CurrentValue = $this->order_by->FormValue;
        $this->isactive->CurrentValue = $this->isactive->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->uuser->CurrentValue = $this->uuser->FormValue;
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
        $this->brand_id->setDbValue($row['brand_id']);
        $this->brand_name->setDbValue($row['brand_name']);
        $this->brand_name_en->setDbValue($row['brand_name_en']);
        $this->company_name->setDbValue($row['company_name']);
        $this->company_name_en->setDbValue($row['company_name_en']);
        $this->icon->setDbValue($row['icon']);
        $this->order_by->setDbValue($row['order_by']);
        $this->isactive->setDbValue($row['isactive']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uip->setDbValue($row['uip']);
        $this->uuser->setDbValue($row['uuser']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['brand_id'] = $this->brand_id->CurrentValue;
        $row['brand_name'] = $this->brand_name->CurrentValue;
        $row['brand_name_en'] = $this->brand_name_en->CurrentValue;
        $row['company_name'] = $this->company_name->CurrentValue;
        $row['company_name_en'] = $this->company_name_en->CurrentValue;
        $row['icon'] = $this->icon->CurrentValue;
        $row['order_by'] = $this->order_by->CurrentValue;
        $row['isactive'] = $this->isactive->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
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

        // brand_id
        $this->brand_id->RowCssClass = "row";

        // brand_name
        $this->brand_name->RowCssClass = "row";

        // brand_name_en
        $this->brand_name_en->RowCssClass = "row";

        // company_name
        $this->company_name->RowCssClass = "row";

        // company_name_en
        $this->company_name_en->RowCssClass = "row";

        // icon
        $this->icon->RowCssClass = "row";

        // order_by
        $this->order_by->RowCssClass = "row";

        // isactive
        $this->isactive->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // brand_name
            $this->brand_name->ViewValue = $this->brand_name->CurrentValue;
            $this->brand_name->ViewCustomAttributes = "";

            // brand_name_en
            $this->brand_name_en->ViewValue = $this->brand_name_en->CurrentValue;
            $this->brand_name_en->ViewCustomAttributes = "";

            // company_name
            $this->company_name->ViewValue = $this->company_name->CurrentValue;
            $this->company_name->ViewCustomAttributes = "";

            // company_name_en
            $this->company_name_en->ViewValue = $this->company_name_en->CurrentValue;
            $this->company_name_en->ViewCustomAttributes = "";

            // order_by
            $this->order_by->ViewValue = $this->order_by->CurrentValue;
            $this->order_by->ViewValue = FormatNumber($this->order_by->ViewValue, $this->order_by->formatPattern());
            $this->order_by->ViewCustomAttributes = "";

            // isactive
            if (strval($this->isactive->CurrentValue) != "") {
                $this->isactive->ViewValue = $this->isactive->optionCaption($this->isactive->CurrentValue);
            } else {
                $this->isactive->ViewValue = null;
            }
            $this->isactive->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
            $this->cuser->ViewValue = FormatNumber($this->cuser->ViewValue, $this->cuser->formatPattern());
            $this->cuser->ViewCustomAttributes = "";

            // cip
            $this->cip->ViewValue = $this->cip->CurrentValue;
            $this->cip->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
            $this->uuser->ViewCustomAttributes = "";

            // brand_name
            $this->brand_name->LinkCustomAttributes = "";
            $this->brand_name->HrefValue = "";

            // brand_name_en
            $this->brand_name_en->LinkCustomAttributes = "";
            $this->brand_name_en->HrefValue = "";

            // company_name
            $this->company_name->LinkCustomAttributes = "";
            $this->company_name->HrefValue = "";

            // company_name_en
            $this->company_name_en->LinkCustomAttributes = "";
            $this->company_name_en->HrefValue = "";

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // brand_name
            $this->brand_name->setupEditAttributes();
            $this->brand_name->EditCustomAttributes = "";
            if (!$this->brand_name->Raw) {
                $this->brand_name->CurrentValue = HtmlDecode($this->brand_name->CurrentValue);
            }
            $this->brand_name->EditValue = HtmlEncode($this->brand_name->CurrentValue);
            $this->brand_name->PlaceHolder = RemoveHtml($this->brand_name->caption());

            // brand_name_en
            $this->brand_name_en->setupEditAttributes();
            $this->brand_name_en->EditCustomAttributes = "";
            if (!$this->brand_name_en->Raw) {
                $this->brand_name_en->CurrentValue = HtmlDecode($this->brand_name_en->CurrentValue);
            }
            $this->brand_name_en->EditValue = HtmlEncode($this->brand_name_en->CurrentValue);
            $this->brand_name_en->PlaceHolder = RemoveHtml($this->brand_name_en->caption());

            // company_name
            $this->company_name->setupEditAttributes();
            $this->company_name->EditCustomAttributes = "";
            if (!$this->company_name->Raw) {
                $this->company_name->CurrentValue = HtmlDecode($this->company_name->CurrentValue);
            }
            $this->company_name->EditValue = HtmlEncode($this->company_name->CurrentValue);
            $this->company_name->PlaceHolder = RemoveHtml($this->company_name->caption());

            // company_name_en
            $this->company_name_en->setupEditAttributes();
            $this->company_name_en->EditCustomAttributes = "";
            if (!$this->company_name_en->Raw) {
                $this->company_name_en->CurrentValue = HtmlDecode($this->company_name_en->CurrentValue);
            }
            $this->company_name_en->EditValue = HtmlEncode($this->company_name_en->CurrentValue);
            $this->company_name_en->PlaceHolder = RemoveHtml($this->company_name_en->caption());

            // order_by
            $this->order_by->setupEditAttributes();
            $this->order_by->EditCustomAttributes = "";
            $this->order_by->EditValue = HtmlEncode($this->order_by->CurrentValue);
            $this->order_by->PlaceHolder = RemoveHtml($this->order_by->caption());
            if (strval($this->order_by->EditValue) != "" && is_numeric($this->order_by->EditValue)) {
                $this->order_by->EditValue = FormatNumber($this->order_by->EditValue, null);
            }

            // isactive
            $this->isactive->EditCustomAttributes = "";
            $this->isactive->EditValue = $this->isactive->options(false);
            $this->isactive->PlaceHolder = RemoveHtml($this->isactive->caption());

            // cdate

            // cuser

            // cip

            // udate

            // uip

            // uuser

            // Add refer script

            // brand_name
            $this->brand_name->LinkCustomAttributes = "";
            $this->brand_name->HrefValue = "";

            // brand_name_en
            $this->brand_name_en->LinkCustomAttributes = "";
            $this->brand_name_en->HrefValue = "";

            // company_name
            $this->company_name->LinkCustomAttributes = "";
            $this->company_name->HrefValue = "";

            // company_name_en
            $this->company_name_en->LinkCustomAttributes = "";
            $this->company_name_en->HrefValue = "";

            // order_by
            $this->order_by->LinkCustomAttributes = "";
            $this->order_by->HrefValue = "";

            // isactive
            $this->isactive->LinkCustomAttributes = "";
            $this->isactive->HrefValue = "";

            // cdate
            $this->cdate->LinkCustomAttributes = "";
            $this->cdate->HrefValue = "";

            // cuser
            $this->cuser->LinkCustomAttributes = "";
            $this->cuser->HrefValue = "";

            // cip
            $this->cip->LinkCustomAttributes = "";
            $this->cip->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";
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
        if ($this->brand_name->Required) {
            if (!$this->brand_name->IsDetailKey && EmptyValue($this->brand_name->FormValue)) {
                $this->brand_name->addErrorMessage(str_replace("%s", $this->brand_name->caption(), $this->brand_name->RequiredErrorMessage));
            }
        }
        if ($this->brand_name_en->Required) {
            if (!$this->brand_name_en->IsDetailKey && EmptyValue($this->brand_name_en->FormValue)) {
                $this->brand_name_en->addErrorMessage(str_replace("%s", $this->brand_name_en->caption(), $this->brand_name_en->RequiredErrorMessage));
            }
        }
        if ($this->company_name->Required) {
            if (!$this->company_name->IsDetailKey && EmptyValue($this->company_name->FormValue)) {
                $this->company_name->addErrorMessage(str_replace("%s", $this->company_name->caption(), $this->company_name->RequiredErrorMessage));
            }
        }
        if ($this->company_name_en->Required) {
            if (!$this->company_name_en->IsDetailKey && EmptyValue($this->company_name_en->FormValue)) {
                $this->company_name_en->addErrorMessage(str_replace("%s", $this->company_name_en->caption(), $this->company_name_en->RequiredErrorMessage));
            }
        }
        if ($this->order_by->Required) {
            if (!$this->order_by->IsDetailKey && EmptyValue($this->order_by->FormValue)) {
                $this->order_by->addErrorMessage(str_replace("%s", $this->order_by->caption(), $this->order_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->order_by->FormValue)) {
            $this->order_by->addErrorMessage($this->order_by->getErrorMessage(false));
        }
        if ($this->isactive->Required) {
            if ($this->isactive->FormValue == "") {
                $this->isactive->addErrorMessage(str_replace("%s", $this->isactive->caption(), $this->isactive->RequiredErrorMessage));
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
        if ($this->udate->Required) {
            if (!$this->udate->IsDetailKey && EmptyValue($this->udate->FormValue)) {
                $this->udate->addErrorMessage(str_replace("%s", $this->udate->caption(), $this->udate->RequiredErrorMessage));
            }
        }
        if ($this->uip->Required) {
            if (!$this->uip->IsDetailKey && EmptyValue($this->uip->FormValue)) {
                $this->uip->addErrorMessage(str_replace("%s", $this->uip->caption(), $this->uip->RequiredErrorMessage));
            }
        }
        if ($this->uuser->Required) {
            if (!$this->uuser->IsDetailKey && EmptyValue($this->uuser->FormValue)) {
                $this->uuser->addErrorMessage(str_replace("%s", $this->uuser->caption(), $this->uuser->RequiredErrorMessage));
            }
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

        // brand_name
        $this->brand_name->setDbValueDef($rsnew, $this->brand_name->CurrentValue, "", false);

        // brand_name_en
        $this->brand_name_en->setDbValueDef($rsnew, $this->brand_name_en->CurrentValue, null, false);

        // company_name
        $this->company_name->setDbValueDef($rsnew, $this->company_name->CurrentValue, null, false);

        // company_name_en
        $this->company_name_en->setDbValueDef($rsnew, $this->company_name_en->CurrentValue, null, false);

        // order_by
        $this->order_by->setDbValueDef($rsnew, $this->order_by->CurrentValue, null, false);

        // isactive
        $this->isactive->setDbValueDef($rsnew, $this->isactive->CurrentValue, null, false);

        // cdate
        $this->cdate->CurrentValue = CurrentDateTime();
        $this->cdate->setDbValueDef($rsnew, $this->cdate->CurrentValue, null);

        // cuser
        $this->cuser->CurrentValue = CurrentUserID();
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null);

        // cip
        $this->cip->CurrentValue = CurrentUserIP();
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null);

        // udate
        $this->udate->CurrentValue = CurrentDateTime();
        $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("brandlist"), "", $this->TableVar, true);
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
                case "x_isactive":
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
