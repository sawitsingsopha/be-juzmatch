<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocTempAdd extends DocTemp
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_temp';

    // Page object name
    public $PageObjName = "DocTempAdd";

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

        // Table object (doc_temp)
        if (!isset($GLOBALS["doc_temp"]) || get_class($GLOBALS["doc_temp"]) == PROJECT_NAMESPACE . "doc_temp") {
            $GLOBALS["doc_temp"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_temp');
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
                $tbl = Container("doc_temp");
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
                    if ($pageName == "doctempview") {
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
		        $this->doc_temp_file->OldUploadPath = "/upload/Doc_temp/";
		        $this->doc_temp_file->UploadPath = $this->doc_temp_file->OldUploadPath;
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
            $key .= @$ar['doc_temp_id'];
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
            $this->doc_temp_id->Visible = false;
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
        $this->doc_temp_id->Visible = false;
        $this->doc_temp_type->setVisibility();
        $this->doc_temp_name->setVisibility();
        $this->doc_temp_file->setVisibility();
        $this->active_status->setVisibility();
        $this->esign_page1->setVisibility();
        $this->esign_page2->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
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
        $this->setupLookupOptions($this->doc_temp_type);
        $this->setupLookupOptions($this->active_status);

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
            if (($keyValue = Get("doc_temp_id") ?? Route("doc_temp_id")) !== null) {
                $this->doc_temp_id->setQueryStringValue($keyValue);
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
                    $this->terminate("doctemplist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = "doctemplist";
                    if (GetPageName($returnUrl) == "doctemplist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "doctempview") {
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
        $this->doc_temp_file->Upload->Index = $CurrentForm->Index;
        $this->doc_temp_file->Upload->uploadFile();
        $this->doc_temp_file->CurrentValue = $this->doc_temp_file->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->doc_temp_id->CurrentValue = null;
        $this->doc_temp_id->OldValue = $this->doc_temp_id->CurrentValue;
        $this->doc_temp_type->CurrentValue = null;
        $this->doc_temp_type->OldValue = $this->doc_temp_type->CurrentValue;
        $this->doc_temp_name->CurrentValue = null;
        $this->doc_temp_name->OldValue = $this->doc_temp_name->CurrentValue;
        $this->doc_temp_file->Upload->DbValue = null;
        $this->doc_temp_file->OldValue = $this->doc_temp_file->Upload->DbValue;
        $this->doc_temp_file->CurrentValue = null; // Clear file related field
        $this->active_status->CurrentValue = 1;
        $this->esign_page1->CurrentValue = null;
        $this->esign_page1->OldValue = $this->esign_page1->CurrentValue;
        $this->esign_page2->CurrentValue = null;
        $this->esign_page2->OldValue = $this->esign_page2->CurrentValue;
        $this->cdate->CurrentValue = null;
        $this->cdate->OldValue = $this->cdate->CurrentValue;
        $this->cuser->CurrentValue = null;
        $this->cuser->OldValue = $this->cuser->CurrentValue;
        $this->cip->CurrentValue = null;
        $this->cip->OldValue = $this->cip->CurrentValue;
        $this->udate->CurrentValue = null;
        $this->udate->OldValue = $this->udate->CurrentValue;
        $this->uuser->CurrentValue = null;
        $this->uuser->OldValue = $this->uuser->CurrentValue;
        $this->uip->CurrentValue = null;
        $this->uip->OldValue = $this->uip->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'doc_temp_type' first before field var 'x_doc_temp_type'
        $val = $CurrentForm->hasValue("doc_temp_type") ? $CurrentForm->getValue("doc_temp_type") : $CurrentForm->getValue("x_doc_temp_type");
        if (!$this->doc_temp_type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_temp_type->Visible = false; // Disable update for API request
            } else {
                $this->doc_temp_type->setFormValue($val);
            }
        }

        // Check field name 'doc_temp_name' first before field var 'x_doc_temp_name'
        $val = $CurrentForm->hasValue("doc_temp_name") ? $CurrentForm->getValue("doc_temp_name") : $CurrentForm->getValue("x_doc_temp_name");
        if (!$this->doc_temp_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_temp_name->Visible = false; // Disable update for API request
            } else {
                $this->doc_temp_name->setFormValue($val);
            }
        }

        // Check field name 'active_status' first before field var 'x_active_status'
        $val = $CurrentForm->hasValue("active_status") ? $CurrentForm->getValue("active_status") : $CurrentForm->getValue("x_active_status");
        if (!$this->active_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->active_status->Visible = false; // Disable update for API request
            } else {
                $this->active_status->setFormValue($val);
            }
        }

        // Check field name 'esign_page1' first before field var 'x_esign_page1'
        $val = $CurrentForm->hasValue("esign_page1") ? $CurrentForm->getValue("esign_page1") : $CurrentForm->getValue("x_esign_page1");
        if (!$this->esign_page1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->esign_page1->Visible = false; // Disable update for API request
            } else {
                $this->esign_page1->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'esign_page2' first before field var 'x_esign_page2'
        $val = $CurrentForm->hasValue("esign_page2") ? $CurrentForm->getValue("esign_page2") : $CurrentForm->getValue("x_esign_page2");
        if (!$this->esign_page2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->esign_page2->Visible = false; // Disable update for API request
            } else {
                $this->esign_page2->setFormValue($val, true, $validate);
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

        // Check field name 'doc_temp_id' first before field var 'x_doc_temp_id'
        $val = $CurrentForm->hasValue("doc_temp_id") ? $CurrentForm->getValue("doc_temp_id") : $CurrentForm->getValue("x_doc_temp_id");
		$this->doc_temp_file->OldUploadPath = "/upload/Doc_temp/";
		$this->doc_temp_file->UploadPath = $this->doc_temp_file->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->doc_temp_type->CurrentValue = $this->doc_temp_type->FormValue;
        $this->doc_temp_name->CurrentValue = $this->doc_temp_name->FormValue;
        $this->active_status->CurrentValue = $this->active_status->FormValue;
        $this->esign_page1->CurrentValue = $this->esign_page1->FormValue;
        $this->esign_page2->CurrentValue = $this->esign_page2->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
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
        $this->doc_temp_id->setDbValue($row['doc_temp_id']);
        $this->doc_temp_type->setDbValue($row['doc_temp_type']);
        $this->doc_temp_name->setDbValue($row['doc_temp_name']);
        $this->doc_temp_file->Upload->DbValue = $row['doc_temp_file'];
        $this->doc_temp_file->setDbValue($this->doc_temp_file->Upload->DbValue);
        $this->active_status->setDbValue($row['active_status']);
        $this->esign_page1->setDbValue($row['esign_page1']);
        $this->esign_page2->setDbValue($row['esign_page2']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['doc_temp_id'] = $this->doc_temp_id->CurrentValue;
        $row['doc_temp_type'] = $this->doc_temp_type->CurrentValue;
        $row['doc_temp_name'] = $this->doc_temp_name->CurrentValue;
        $row['doc_temp_file'] = $this->doc_temp_file->Upload->DbValue;
        $row['active_status'] = $this->active_status->CurrentValue;
        $row['esign_page1'] = $this->esign_page1->CurrentValue;
        $row['esign_page2'] = $this->esign_page2->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
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

        // doc_temp_id
        $this->doc_temp_id->RowCssClass = "row";

        // doc_temp_type
        $this->doc_temp_type->RowCssClass = "row";

        // doc_temp_name
        $this->doc_temp_name->RowCssClass = "row";

        // doc_temp_file
        $this->doc_temp_file->RowCssClass = "row";

        // active_status
        $this->active_status->RowCssClass = "row";

        // esign_page1
        $this->esign_page1->RowCssClass = "row";

        // esign_page2
        $this->esign_page2->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // doc_temp_type
            if (strval($this->doc_temp_type->CurrentValue) != "") {
                $this->doc_temp_type->ViewValue = $this->doc_temp_type->optionCaption($this->doc_temp_type->CurrentValue);
            } else {
                $this->doc_temp_type->ViewValue = null;
            }
            $this->doc_temp_type->ViewCustomAttributes = "";

            // doc_temp_name
            $this->doc_temp_name->ViewValue = $this->doc_temp_name->CurrentValue;
            $this->doc_temp_name->ViewCustomAttributes = "";

            // doc_temp_file
            $this->doc_temp_file->UploadPath = "/upload/Doc_temp/";
            if (!EmptyValue($this->doc_temp_file->Upload->DbValue)) {
                $this->doc_temp_file->ViewValue = $this->doc_temp_file->Upload->DbValue;
            } else {
                $this->doc_temp_file->ViewValue = "";
            }
            $this->doc_temp_file->ViewCustomAttributes = "";

            // active_status
            if (strval($this->active_status->CurrentValue) != "") {
                $this->active_status->ViewValue = $this->active_status->optionCaption($this->active_status->CurrentValue);
            } else {
                $this->active_status->ViewValue = null;
            }
            $this->active_status->ViewCustomAttributes = "";

            // esign_page1
            $this->esign_page1->ViewValue = $this->esign_page1->CurrentValue;
            $this->esign_page1->ViewValue = FormatNumber($this->esign_page1->ViewValue, $this->esign_page1->formatPattern());
            $this->esign_page1->ViewCustomAttributes = "";

            // esign_page2
            $this->esign_page2->ViewValue = $this->esign_page2->CurrentValue;
            $this->esign_page2->ViewValue = FormatNumber($this->esign_page2->ViewValue, $this->esign_page2->formatPattern());
            $this->esign_page2->ViewCustomAttributes = "";

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

            // doc_temp_type
            $this->doc_temp_type->LinkCustomAttributes = "";
            $this->doc_temp_type->HrefValue = "";

            // doc_temp_name
            $this->doc_temp_name->LinkCustomAttributes = "";
            $this->doc_temp_name->HrefValue = "";

            // doc_temp_file
            $this->doc_temp_file->LinkCustomAttributes = "";
            $this->doc_temp_file->HrefValue = "";
            $this->doc_temp_file->ExportHrefValue = $this->doc_temp_file->UploadPath . $this->doc_temp_file->Upload->DbValue;

            // active_status
            $this->active_status->LinkCustomAttributes = "";
            $this->active_status->HrefValue = "";

            // esign_page1
            $this->esign_page1->LinkCustomAttributes = "";
            $this->esign_page1->HrefValue = "";

            // esign_page2
            $this->esign_page2->LinkCustomAttributes = "";
            $this->esign_page2->HrefValue = "";

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

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // doc_temp_type
            $this->doc_temp_type->setupEditAttributes();
            $this->doc_temp_type->EditCustomAttributes = "";
            $this->doc_temp_type->EditValue = $this->doc_temp_type->options(true);
            $this->doc_temp_type->PlaceHolder = RemoveHtml($this->doc_temp_type->caption());

            // doc_temp_name
            $this->doc_temp_name->setupEditAttributes();
            $this->doc_temp_name->EditCustomAttributes = "";
            if (!$this->doc_temp_name->Raw) {
                $this->doc_temp_name->CurrentValue = HtmlDecode($this->doc_temp_name->CurrentValue);
            }
            $this->doc_temp_name->EditValue = HtmlEncode($this->doc_temp_name->CurrentValue);
            $this->doc_temp_name->PlaceHolder = RemoveHtml($this->doc_temp_name->caption());

            // doc_temp_file
            $this->doc_temp_file->setupEditAttributes();
            $this->doc_temp_file->EditCustomAttributes = "";
            $this->doc_temp_file->UploadPath = "/upload/Doc_temp/";
            if (!EmptyValue($this->doc_temp_file->Upload->DbValue)) {
                $this->doc_temp_file->EditValue = $this->doc_temp_file->Upload->DbValue;
            } else {
                $this->doc_temp_file->EditValue = "";
            }
            if (!EmptyValue($this->doc_temp_file->CurrentValue)) {
                $this->doc_temp_file->Upload->FileName = $this->doc_temp_file->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->doc_temp_file);
            }

            // active_status
            $this->active_status->EditCustomAttributes = "";
            $this->active_status->EditValue = $this->active_status->options(false);
            $this->active_status->PlaceHolder = RemoveHtml($this->active_status->caption());

            // esign_page1
            $this->esign_page1->setupEditAttributes();
            $this->esign_page1->EditCustomAttributes = "";
            $this->esign_page1->EditValue = HtmlEncode($this->esign_page1->CurrentValue);
            $this->esign_page1->PlaceHolder = RemoveHtml($this->esign_page1->caption());
            if (strval($this->esign_page1->EditValue) != "" && is_numeric($this->esign_page1->EditValue)) {
                $this->esign_page1->EditValue = FormatNumber($this->esign_page1->EditValue, null);
            }

            // esign_page2
            $this->esign_page2->setupEditAttributes();
            $this->esign_page2->EditCustomAttributes = "";
            $this->esign_page2->EditValue = HtmlEncode($this->esign_page2->CurrentValue);
            $this->esign_page2->PlaceHolder = RemoveHtml($this->esign_page2->caption());
            if (strval($this->esign_page2->EditValue) != "" && is_numeric($this->esign_page2->EditValue)) {
                $this->esign_page2->EditValue = FormatNumber($this->esign_page2->EditValue, null);
            }

            // cdate

            // cuser

            // cip

            // udate

            // uuser

            // uip

            // Add refer script

            // doc_temp_type
            $this->doc_temp_type->LinkCustomAttributes = "";
            $this->doc_temp_type->HrefValue = "";

            // doc_temp_name
            $this->doc_temp_name->LinkCustomAttributes = "";
            $this->doc_temp_name->HrefValue = "";

            // doc_temp_file
            $this->doc_temp_file->LinkCustomAttributes = "";
            $this->doc_temp_file->HrefValue = "";
            $this->doc_temp_file->ExportHrefValue = $this->doc_temp_file->UploadPath . $this->doc_temp_file->Upload->DbValue;

            // active_status
            $this->active_status->LinkCustomAttributes = "";
            $this->active_status->HrefValue = "";

            // esign_page1
            $this->esign_page1->LinkCustomAttributes = "";
            $this->esign_page1->HrefValue = "";

            // esign_page2
            $this->esign_page2->LinkCustomAttributes = "";
            $this->esign_page2->HrefValue = "";

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

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";
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
        if ($this->doc_temp_type->Required) {
            if (!$this->doc_temp_type->IsDetailKey && EmptyValue($this->doc_temp_type->FormValue)) {
                $this->doc_temp_type->addErrorMessage(str_replace("%s", $this->doc_temp_type->caption(), $this->doc_temp_type->RequiredErrorMessage));
            }
        }
        if ($this->doc_temp_name->Required) {
            if (!$this->doc_temp_name->IsDetailKey && EmptyValue($this->doc_temp_name->FormValue)) {
                $this->doc_temp_name->addErrorMessage(str_replace("%s", $this->doc_temp_name->caption(), $this->doc_temp_name->RequiredErrorMessage));
            }
        }
        if ($this->doc_temp_file->Required) {
            if ($this->doc_temp_file->Upload->FileName == "" && !$this->doc_temp_file->Upload->KeepFile) {
                $this->doc_temp_file->addErrorMessage(str_replace("%s", $this->doc_temp_file->caption(), $this->doc_temp_file->RequiredErrorMessage));
            }
        }
        if ($this->active_status->Required) {
            if ($this->active_status->FormValue == "") {
                $this->active_status->addErrorMessage(str_replace("%s", $this->active_status->caption(), $this->active_status->RequiredErrorMessage));
            }
        }
        if ($this->esign_page1->Required) {
            if (!$this->esign_page1->IsDetailKey && EmptyValue($this->esign_page1->FormValue)) {
                $this->esign_page1->addErrorMessage(str_replace("%s", $this->esign_page1->caption(), $this->esign_page1->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->esign_page1->FormValue)) {
            $this->esign_page1->addErrorMessage($this->esign_page1->getErrorMessage(false));
        }
        if ($this->esign_page2->Required) {
            if (!$this->esign_page2->IsDetailKey && EmptyValue($this->esign_page2->FormValue)) {
                $this->esign_page2->addErrorMessage(str_replace("%s", $this->esign_page2->caption(), $this->esign_page2->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->esign_page2->FormValue)) {
            $this->esign_page2->addErrorMessage($this->esign_page2->getErrorMessage(false));
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
            $this->doc_temp_file->OldUploadPath = "/upload/Doc_temp/";
            $this->doc_temp_file->UploadPath = $this->doc_temp_file->OldUploadPath;
        }
        $rsnew = [];

        // doc_temp_type
        $this->doc_temp_type->setDbValueDef($rsnew, $this->doc_temp_type->CurrentValue, null, false);

        // doc_temp_name
        $this->doc_temp_name->setDbValueDef($rsnew, $this->doc_temp_name->CurrentValue, null, false);

        // doc_temp_file
        if ($this->doc_temp_file->Visible && !$this->doc_temp_file->Upload->KeepFile) {
            $this->doc_temp_file->Upload->DbValue = ""; // No need to delete old file
            if ($this->doc_temp_file->Upload->FileName == "") {
                $rsnew['doc_temp_file'] = null;
            } else {
                $rsnew['doc_temp_file'] = $this->doc_temp_file->Upload->FileName;
            }
        }

        // active_status
        $this->active_status->setDbValueDef($rsnew, $this->active_status->CurrentValue, null, false);

        // esign_page1
        $this->esign_page1->setDbValueDef($rsnew, $this->esign_page1->CurrentValue, null, false);

        // esign_page2
        $this->esign_page2->setDbValueDef($rsnew, $this->esign_page2->CurrentValue, null, false);

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

        // uuser
        $this->uuser->CurrentValue = CurrentUserID();
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

        // uip
        $this->uip->CurrentValue = CurrentUserIP();
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);
        if ($this->doc_temp_file->Visible && !$this->doc_temp_file->Upload->KeepFile) {
            $this->doc_temp_file->UploadPath = "/upload/Doc_temp/";
            $oldFiles = EmptyValue($this->doc_temp_file->Upload->DbValue) ? [] : [$this->doc_temp_file->htmlDecode($this->doc_temp_file->Upload->DbValue)];
            if (!EmptyValue($this->doc_temp_file->Upload->FileName)) {
                $newFiles = [$this->doc_temp_file->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->doc_temp_file, $this->doc_temp_file->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->doc_temp_file->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->doc_temp_file->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->doc_temp_file->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->doc_temp_file->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->doc_temp_file->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->doc_temp_file->setDbValueDef($rsnew, $this->doc_temp_file->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->doc_temp_file->Visible && !$this->doc_temp_file->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->doc_temp_file->Upload->DbValue) ? [] : [$this->doc_temp_file->htmlDecode($this->doc_temp_file->Upload->DbValue)];
                    if (!EmptyValue($this->doc_temp_file->Upload->FileName)) {
                        $newFiles = [$this->doc_temp_file->Upload->FileName];
                        $newFiles2 = [$this->doc_temp_file->htmlDecode($rsnew['doc_temp_file'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->doc_temp_file, $this->doc_temp_file->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->doc_temp_file->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->doc_temp_file->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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
            // doc_temp_file
            CleanUploadTempPath($this->doc_temp_file, $this->doc_temp_file->Upload->Index);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("doctemplist"), "", $this->TableVar, true);
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
                case "x_doc_temp_type":
                    break;
                case "x_active_status":
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
