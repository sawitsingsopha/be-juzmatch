<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocJuzmatch3Add extends DocJuzmatch3
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_juzmatch3';

    // Page object name
    public $PageObjName = "DocJuzmatch3Add";

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

        // Table object (doc_juzmatch3)
        if (!isset($GLOBALS["doc_juzmatch3"]) || get_class($GLOBALS["doc_juzmatch3"]) == PROJECT_NAMESPACE . "doc_juzmatch3") {
            $GLOBALS["doc_juzmatch3"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_juzmatch3');
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
                $tbl = Container("doc_juzmatch3");
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
                    if ($pageName == "docjuzmatch3view") {
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
		        $this->file_idcard->OldUploadPath = "/upload/";
		        $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
		        $this->file_house_regis->OldUploadPath = "/upload/";
		        $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
		        $this->file_titledeed->OldUploadPath = "/upload/";
		        $this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
		        $this->file_other->OldUploadPath = "/upload/";
		        $this->file_other->UploadPath = $this->file_other->OldUploadPath;
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
        $this->document_date->setVisibility();
        $this->years->setVisibility();
        $this->start_date->setVisibility();
        $this->end_date->setVisibility();
        $this->asset_code->setVisibility();
        $this->asset_project->setVisibility();
        $this->asset_deed->setVisibility();
        $this->asset_area->setVisibility();
        $this->appoint_agent_date->setVisibility();
        $this->buyer_name->setVisibility();
        $this->buyer_lname->setVisibility();
        $this->buyer_email->setVisibility();
        $this->buyer_idcard->setVisibility();
        $this->buyer_homeno->setVisibility();
        $this->buyer_witness_name->setVisibility();
        $this->buyer_witness_lname->setVisibility();
        $this->buyer_witness_email->setVisibility();
        $this->investor_name->setVisibility();
        $this->investor_lname->setVisibility();
        $this->investor_email->setVisibility();
        $this->juzmatch_authority_name->setVisibility();
        $this->juzmatch_authority_lname->setVisibility();
        $this->juzmatch_authority_email->setVisibility();
        $this->juzmatch_authority_witness_name->setVisibility();
        $this->juzmatch_authority_witness_lname->setVisibility();
        $this->juzmatch_authority_witness_email->setVisibility();
        $this->juzmatch_authority2_name->setVisibility();
        $this->juzmatch_authority2_lname->setVisibility();
        $this->juzmatch_authority2_email->setVisibility();
        $this->company_seal_name->setVisibility();
        $this->company_seal_email->setVisibility();
        $this->total->setVisibility();
        $this->total_txt->setVisibility();
        $this->next_pay_date->setVisibility();
        $this->next_pay_date_txt->setVisibility();
        $this->service_price->setVisibility();
        $this->service_price_txt->setVisibility();
        $this->provide_service_date->setVisibility();
        $this->contact_address->setVisibility();
        $this->contact_address2->setVisibility();
        $this->contact_email->setVisibility();
        $this->contact_lineid->setVisibility();
        $this->contact_phone->setVisibility();
        $this->file_idcard->setVisibility();
        $this->file_house_regis->setVisibility();
        $this->file_titledeed->setVisibility();
        $this->file_other->setVisibility();
        $this->attach_file->setVisibility();
        $this->status->setVisibility();
        $this->doc_creden_id->Visible = false;
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->doc_date->setVisibility();
        $this->buyer_booking_asset_id->Visible = false;
        $this->first_down->Visible = false;
        $this->first_down_txt->Visible = false;
        $this->second_down->Visible = false;
        $this->second_down_txt->Visible = false;
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
        $this->setupLookupOptions($this->status);

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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

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
                    $this->terminate("docjuzmatch3list"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->GetEditUrl();
                    if (GetPageName($returnUrl) == "docjuzmatch3list") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "docjuzmatch3view") {
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
        $this->file_idcard->Upload->Index = $CurrentForm->Index;
        $this->file_idcard->Upload->uploadFile();
        $this->file_idcard->CurrentValue = $this->file_idcard->Upload->FileName;
        $this->file_house_regis->Upload->Index = $CurrentForm->Index;
        $this->file_house_regis->Upload->uploadFile();
        $this->file_house_regis->CurrentValue = $this->file_house_regis->Upload->FileName;
        $this->file_titledeed->Upload->Index = $CurrentForm->Index;
        $this->file_titledeed->Upload->uploadFile();
        $this->file_titledeed->CurrentValue = $this->file_titledeed->Upload->FileName;
        $this->file_other->Upload->Index = $CurrentForm->Index;
        $this->file_other->Upload->uploadFile();
        $this->file_other->CurrentValue = $this->file_other->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->document_date->CurrentValue = null;
        $this->document_date->OldValue = $this->document_date->CurrentValue;
        $this->years->CurrentValue = null;
        $this->years->OldValue = $this->years->CurrentValue;
        $this->start_date->CurrentValue = null;
        $this->start_date->OldValue = $this->start_date->CurrentValue;
        $this->end_date->CurrentValue = null;
        $this->end_date->OldValue = $this->end_date->CurrentValue;
        $this->asset_code->CurrentValue = null;
        $this->asset_code->OldValue = $this->asset_code->CurrentValue;
        $this->asset_project->CurrentValue = null;
        $this->asset_project->OldValue = $this->asset_project->CurrentValue;
        $this->asset_deed->CurrentValue = null;
        $this->asset_deed->OldValue = $this->asset_deed->CurrentValue;
        $this->asset_area->CurrentValue = null;
        $this->asset_area->OldValue = $this->asset_area->CurrentValue;
        $this->appoint_agent_date->CurrentValue = null;
        $this->appoint_agent_date->OldValue = $this->appoint_agent_date->CurrentValue;
        $this->buyer_name->CurrentValue = null;
        $this->buyer_name->OldValue = $this->buyer_name->CurrentValue;
        $this->buyer_lname->CurrentValue = null;
        $this->buyer_lname->OldValue = $this->buyer_lname->CurrentValue;
        $this->buyer_email->CurrentValue = null;
        $this->buyer_email->OldValue = $this->buyer_email->CurrentValue;
        $this->buyer_idcard->CurrentValue = null;
        $this->buyer_idcard->OldValue = $this->buyer_idcard->CurrentValue;
        $this->buyer_homeno->CurrentValue = null;
        $this->buyer_homeno->OldValue = $this->buyer_homeno->CurrentValue;
        $this->buyer_witness_name->CurrentValue = null;
        $this->buyer_witness_name->OldValue = $this->buyer_witness_name->CurrentValue;
        $this->buyer_witness_lname->CurrentValue = null;
        $this->buyer_witness_lname->OldValue = $this->buyer_witness_lname->CurrentValue;
        $this->buyer_witness_email->CurrentValue = null;
        $this->buyer_witness_email->OldValue = $this->buyer_witness_email->CurrentValue;
        $this->investor_name->CurrentValue = null;
        $this->investor_name->OldValue = $this->investor_name->CurrentValue;
        $this->investor_lname->CurrentValue = null;
        $this->investor_lname->OldValue = $this->investor_lname->CurrentValue;
        $this->investor_email->CurrentValue = null;
        $this->investor_email->OldValue = $this->investor_email->CurrentValue;
        $this->juzmatch_authority_name->CurrentValue = null;
        $this->juzmatch_authority_name->OldValue = $this->juzmatch_authority_name->CurrentValue;
        $this->juzmatch_authority_lname->CurrentValue = null;
        $this->juzmatch_authority_lname->OldValue = $this->juzmatch_authority_lname->CurrentValue;
        $this->juzmatch_authority_email->CurrentValue = null;
        $this->juzmatch_authority_email->OldValue = $this->juzmatch_authority_email->CurrentValue;
        $this->juzmatch_authority_witness_name->CurrentValue = null;
        $this->juzmatch_authority_witness_name->OldValue = $this->juzmatch_authority_witness_name->CurrentValue;
        $this->juzmatch_authority_witness_lname->CurrentValue = null;
        $this->juzmatch_authority_witness_lname->OldValue = $this->juzmatch_authority_witness_lname->CurrentValue;
        $this->juzmatch_authority_witness_email->CurrentValue = null;
        $this->juzmatch_authority_witness_email->OldValue = $this->juzmatch_authority_witness_email->CurrentValue;
        $this->juzmatch_authority2_name->CurrentValue = null;
        $this->juzmatch_authority2_name->OldValue = $this->juzmatch_authority2_name->CurrentValue;
        $this->juzmatch_authority2_lname->CurrentValue = null;
        $this->juzmatch_authority2_lname->OldValue = $this->juzmatch_authority2_lname->CurrentValue;
        $this->juzmatch_authority2_email->CurrentValue = null;
        $this->juzmatch_authority2_email->OldValue = $this->juzmatch_authority2_email->CurrentValue;
        $this->company_seal_name->CurrentValue = null;
        $this->company_seal_name->OldValue = $this->company_seal_name->CurrentValue;
        $this->company_seal_email->CurrentValue = null;
        $this->company_seal_email->OldValue = $this->company_seal_email->CurrentValue;
        $this->total->CurrentValue = null;
        $this->total->OldValue = $this->total->CurrentValue;
        $this->total_txt->CurrentValue = null;
        $this->total_txt->OldValue = $this->total_txt->CurrentValue;
        $this->next_pay_date->CurrentValue = null;
        $this->next_pay_date->OldValue = $this->next_pay_date->CurrentValue;
        $this->next_pay_date_txt->CurrentValue = null;
        $this->next_pay_date_txt->OldValue = $this->next_pay_date_txt->CurrentValue;
        $this->service_price->CurrentValue = null;
        $this->service_price->OldValue = $this->service_price->CurrentValue;
        $this->service_price_txt->CurrentValue = null;
        $this->service_price_txt->OldValue = $this->service_price_txt->CurrentValue;
        $this->provide_service_date->CurrentValue = null;
        $this->provide_service_date->OldValue = $this->provide_service_date->CurrentValue;
        $this->contact_address->CurrentValue = null;
        $this->contact_address->OldValue = $this->contact_address->CurrentValue;
        $this->contact_address2->CurrentValue = null;
        $this->contact_address2->OldValue = $this->contact_address2->CurrentValue;
        $this->contact_email->CurrentValue = null;
        $this->contact_email->OldValue = $this->contact_email->CurrentValue;
        $this->contact_lineid->CurrentValue = null;
        $this->contact_lineid->OldValue = $this->contact_lineid->CurrentValue;
        $this->contact_phone->CurrentValue = null;
        $this->contact_phone->OldValue = $this->contact_phone->CurrentValue;
        $this->file_idcard->Upload->DbValue = null;
        $this->file_idcard->OldValue = $this->file_idcard->Upload->DbValue;
        $this->file_idcard->CurrentValue = null; // Clear file related field
        $this->file_house_regis->Upload->DbValue = null;
        $this->file_house_regis->OldValue = $this->file_house_regis->Upload->DbValue;
        $this->file_house_regis->CurrentValue = null; // Clear file related field
        $this->file_titledeed->Upload->DbValue = null;
        $this->file_titledeed->OldValue = $this->file_titledeed->Upload->DbValue;
        $this->file_titledeed->CurrentValue = null; // Clear file related field
        $this->file_other->Upload->DbValue = null;
        $this->file_other->OldValue = $this->file_other->Upload->DbValue;
        $this->file_other->CurrentValue = null; // Clear file related field
        $this->attach_file->CurrentValue = null;
        $this->attach_file->OldValue = $this->attach_file->CurrentValue;
        $this->status->CurrentValue = 0;
        $this->doc_creden_id->CurrentValue = null;
        $this->doc_creden_id->OldValue = $this->doc_creden_id->CurrentValue;
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
        $this->doc_date->CurrentValue = null;
        $this->doc_date->OldValue = $this->doc_date->CurrentValue;
        $this->buyer_booking_asset_id->CurrentValue = null;
        $this->buyer_booking_asset_id->OldValue = $this->buyer_booking_asset_id->CurrentValue;
        $this->first_down->CurrentValue = null;
        $this->first_down->OldValue = $this->first_down->CurrentValue;
        $this->first_down_txt->CurrentValue = null;
        $this->first_down_txt->OldValue = $this->first_down_txt->CurrentValue;
        $this->second_down->CurrentValue = null;
        $this->second_down->OldValue = $this->second_down->CurrentValue;
        $this->second_down_txt->CurrentValue = null;
        $this->second_down_txt->OldValue = $this->second_down_txt->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'document_date' first before field var 'x_document_date'
        $val = $CurrentForm->hasValue("document_date") ? $CurrentForm->getValue("document_date") : $CurrentForm->getValue("x_document_date");
        if (!$this->document_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->document_date->Visible = false; // Disable update for API request
            } else {
                $this->document_date->setFormValue($val);
            }
            $this->document_date->CurrentValue = UnFormatDateTime($this->document_date->CurrentValue, $this->document_date->formatPattern());
        }

        // Check field name 'years' first before field var 'x_years'
        $val = $CurrentForm->hasValue("years") ? $CurrentForm->getValue("years") : $CurrentForm->getValue("x_years");
        if (!$this->years->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->years->Visible = false; // Disable update for API request
            } else {
                $this->years->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'start_date' first before field var 'x_start_date'
        $val = $CurrentForm->hasValue("start_date") ? $CurrentForm->getValue("start_date") : $CurrentForm->getValue("x_start_date");
        if (!$this->start_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->start_date->Visible = false; // Disable update for API request
            } else {
                $this->start_date->setFormValue($val, true, $validate);
            }
            $this->start_date->CurrentValue = UnFormatDateTime($this->start_date->CurrentValue, $this->start_date->formatPattern());
        }

        // Check field name 'end_date' first before field var 'x_end_date'
        $val = $CurrentForm->hasValue("end_date") ? $CurrentForm->getValue("end_date") : $CurrentForm->getValue("x_end_date");
        if (!$this->end_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->end_date->Visible = false; // Disable update for API request
            } else {
                $this->end_date->setFormValue($val, true, $validate);
            }
            $this->end_date->CurrentValue = UnFormatDateTime($this->end_date->CurrentValue, $this->end_date->formatPattern());
        }

        // Check field name 'asset_code' first before field var 'x_asset_code'
        $val = $CurrentForm->hasValue("asset_code") ? $CurrentForm->getValue("asset_code") : $CurrentForm->getValue("x_asset_code");
        if (!$this->asset_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_code->Visible = false; // Disable update for API request
            } else {
                $this->asset_code->setFormValue($val);
            }
        }

        // Check field name 'asset_project' first before field var 'x_asset_project'
        $val = $CurrentForm->hasValue("asset_project") ? $CurrentForm->getValue("asset_project") : $CurrentForm->getValue("x_asset_project");
        if (!$this->asset_project->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_project->Visible = false; // Disable update for API request
            } else {
                $this->asset_project->setFormValue($val);
            }
        }

        // Check field name 'asset_deed' first before field var 'x_asset_deed'
        $val = $CurrentForm->hasValue("asset_deed") ? $CurrentForm->getValue("asset_deed") : $CurrentForm->getValue("x_asset_deed");
        if (!$this->asset_deed->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_deed->Visible = false; // Disable update for API request
            } else {
                $this->asset_deed->setFormValue($val);
            }
        }

        // Check field name 'asset_area' first before field var 'x_asset_area'
        $val = $CurrentForm->hasValue("asset_area") ? $CurrentForm->getValue("asset_area") : $CurrentForm->getValue("x_asset_area");
        if (!$this->asset_area->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asset_area->Visible = false; // Disable update for API request
            } else {
                $this->asset_area->setFormValue($val);
            }
        }

        // Check field name 'appoint_agent_date' first before field var 'x_appoint_agent_date'
        $val = $CurrentForm->hasValue("appoint_agent_date") ? $CurrentForm->getValue("appoint_agent_date") : $CurrentForm->getValue("x_appoint_agent_date");
        if (!$this->appoint_agent_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->appoint_agent_date->Visible = false; // Disable update for API request
            } else {
                $this->appoint_agent_date->setFormValue($val, true, $validate);
            }
            $this->appoint_agent_date->CurrentValue = UnFormatDateTime($this->appoint_agent_date->CurrentValue, $this->appoint_agent_date->formatPattern());
        }

        // Check field name 'buyer_name' first before field var 'x_buyer_name'
        $val = $CurrentForm->hasValue("buyer_name") ? $CurrentForm->getValue("buyer_name") : $CurrentForm->getValue("x_buyer_name");
        if (!$this->buyer_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_name->Visible = false; // Disable update for API request
            } else {
                $this->buyer_name->setFormValue($val);
            }
        }

        // Check field name 'buyer_lname' first before field var 'x_buyer_lname'
        $val = $CurrentForm->hasValue("buyer_lname") ? $CurrentForm->getValue("buyer_lname") : $CurrentForm->getValue("x_buyer_lname");
        if (!$this->buyer_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_lname->Visible = false; // Disable update for API request
            } else {
                $this->buyer_lname->setFormValue($val);
            }
        }

        // Check field name 'buyer_email' first before field var 'x_buyer_email'
        $val = $CurrentForm->hasValue("buyer_email") ? $CurrentForm->getValue("buyer_email") : $CurrentForm->getValue("x_buyer_email");
        if (!$this->buyer_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_email->Visible = false; // Disable update for API request
            } else {
                $this->buyer_email->setFormValue($val);
            }
        }

        // Check field name 'buyer_idcard' first before field var 'x_buyer_idcard'
        $val = $CurrentForm->hasValue("buyer_idcard") ? $CurrentForm->getValue("buyer_idcard") : $CurrentForm->getValue("x_buyer_idcard");
        if (!$this->buyer_idcard->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_idcard->Visible = false; // Disable update for API request
            } else {
                $this->buyer_idcard->setFormValue($val);
            }
        }

        // Check field name 'buyer_homeno' first before field var 'x_buyer_homeno'
        $val = $CurrentForm->hasValue("buyer_homeno") ? $CurrentForm->getValue("buyer_homeno") : $CurrentForm->getValue("x_buyer_homeno");
        if (!$this->buyer_homeno->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_homeno->Visible = false; // Disable update for API request
            } else {
                $this->buyer_homeno->setFormValue($val);
            }
        }

        // Check field name 'buyer_witness_name' first before field var 'x_buyer_witness_name'
        $val = $CurrentForm->hasValue("buyer_witness_name") ? $CurrentForm->getValue("buyer_witness_name") : $CurrentForm->getValue("x_buyer_witness_name");
        if (!$this->buyer_witness_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_witness_name->Visible = false; // Disable update for API request
            } else {
                $this->buyer_witness_name->setFormValue($val);
            }
        }

        // Check field name 'buyer_witness_lname' first before field var 'x_buyer_witness_lname'
        $val = $CurrentForm->hasValue("buyer_witness_lname") ? $CurrentForm->getValue("buyer_witness_lname") : $CurrentForm->getValue("x_buyer_witness_lname");
        if (!$this->buyer_witness_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_witness_lname->Visible = false; // Disable update for API request
            } else {
                $this->buyer_witness_lname->setFormValue($val);
            }
        }

        // Check field name 'buyer_witness_email' first before field var 'x_buyer_witness_email'
        $val = $CurrentForm->hasValue("buyer_witness_email") ? $CurrentForm->getValue("buyer_witness_email") : $CurrentForm->getValue("x_buyer_witness_email");
        if (!$this->buyer_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->buyer_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->buyer_witness_email->setFormValue($val);
            }
        }

        // Check field name 'investor_name' first before field var 'x_investor_name'
        $val = $CurrentForm->hasValue("investor_name") ? $CurrentForm->getValue("investor_name") : $CurrentForm->getValue("x_investor_name");
        if (!$this->investor_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_name->Visible = false; // Disable update for API request
            } else {
                $this->investor_name->setFormValue($val);
            }
        }

        // Check field name 'investor_lname' first before field var 'x_investor_lname'
        $val = $CurrentForm->hasValue("investor_lname") ? $CurrentForm->getValue("investor_lname") : $CurrentForm->getValue("x_investor_lname");
        if (!$this->investor_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_lname->Visible = false; // Disable update for API request
            } else {
                $this->investor_lname->setFormValue($val);
            }
        }

        // Check field name 'investor_email' first before field var 'x_investor_email'
        $val = $CurrentForm->hasValue("investor_email") ? $CurrentForm->getValue("investor_email") : $CurrentForm->getValue("x_investor_email");
        if (!$this->investor_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_email->Visible = false; // Disable update for API request
            } else {
                $this->investor_email->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_name' first before field var 'x_juzmatch_authority_name'
        $val = $CurrentForm->hasValue("juzmatch_authority_name") ? $CurrentForm->getValue("juzmatch_authority_name") : $CurrentForm->getValue("x_juzmatch_authority_name");
        if (!$this->juzmatch_authority_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_name->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_name->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_lname' first before field var 'x_juzmatch_authority_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority_lname") ? $CurrentForm->getValue("juzmatch_authority_lname") : $CurrentForm->getValue("x_juzmatch_authority_lname");
        if (!$this->juzmatch_authority_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_lname->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_email' first before field var 'x_juzmatch_authority_email'
        $val = $CurrentForm->hasValue("juzmatch_authority_email") ? $CurrentForm->getValue("juzmatch_authority_email") : $CurrentForm->getValue("x_juzmatch_authority_email");
        if (!$this->juzmatch_authority_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_email->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_witness_name' first before field var 'x_juzmatch_authority_witness_name'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_name") ? $CurrentForm->getValue("juzmatch_authority_witness_name") : $CurrentForm->getValue("x_juzmatch_authority_witness_name");
        if (!$this->juzmatch_authority_witness_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_name->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_name->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_witness_lname' first before field var 'x_juzmatch_authority_witness_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_lname") ? $CurrentForm->getValue("juzmatch_authority_witness_lname") : $CurrentForm->getValue("x_juzmatch_authority_witness_lname");
        if (!$this->juzmatch_authority_witness_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_lname->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority_witness_email' first before field var 'x_juzmatch_authority_witness_email'
        $val = $CurrentForm->hasValue("juzmatch_authority_witness_email") ? $CurrentForm->getValue("juzmatch_authority_witness_email") : $CurrentForm->getValue("x_juzmatch_authority_witness_email");
        if (!$this->juzmatch_authority_witness_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority_witness_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority_witness_email->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority2_name' first before field var 'x_juzmatch_authority2_name'
        $val = $CurrentForm->hasValue("juzmatch_authority2_name") ? $CurrentForm->getValue("juzmatch_authority2_name") : $CurrentForm->getValue("x_juzmatch_authority2_name");
        if (!$this->juzmatch_authority2_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_name->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_name->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority2_lname' first before field var 'x_juzmatch_authority2_lname'
        $val = $CurrentForm->hasValue("juzmatch_authority2_lname") ? $CurrentForm->getValue("juzmatch_authority2_lname") : $CurrentForm->getValue("x_juzmatch_authority2_lname");
        if (!$this->juzmatch_authority2_lname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_lname->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_lname->setFormValue($val);
            }
        }

        // Check field name 'juzmatch_authority2_email' first before field var 'x_juzmatch_authority2_email'
        $val = $CurrentForm->hasValue("juzmatch_authority2_email") ? $CurrentForm->getValue("juzmatch_authority2_email") : $CurrentForm->getValue("x_juzmatch_authority2_email");
        if (!$this->juzmatch_authority2_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->juzmatch_authority2_email->Visible = false; // Disable update for API request
            } else {
                $this->juzmatch_authority2_email->setFormValue($val);
            }
        }

        // Check field name 'company_seal_name' first before field var 'x_company_seal_name'
        $val = $CurrentForm->hasValue("company_seal_name") ? $CurrentForm->getValue("company_seal_name") : $CurrentForm->getValue("x_company_seal_name");
        if (!$this->company_seal_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_seal_name->Visible = false; // Disable update for API request
            } else {
                $this->company_seal_name->setFormValue($val);
            }
        }

        // Check field name 'company_seal_email' first before field var 'x_company_seal_email'
        $val = $CurrentForm->hasValue("company_seal_email") ? $CurrentForm->getValue("company_seal_email") : $CurrentForm->getValue("x_company_seal_email");
        if (!$this->company_seal_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->company_seal_email->Visible = false; // Disable update for API request
            } else {
                $this->company_seal_email->setFormValue($val);
            }
        }

        // Check field name 'total' first before field var 'x_total'
        $val = $CurrentForm->hasValue("total") ? $CurrentForm->getValue("total") : $CurrentForm->getValue("x_total");
        if (!$this->total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total->Visible = false; // Disable update for API request
            } else {
                $this->total->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'total_txt' first before field var 'x_total_txt'
        $val = $CurrentForm->hasValue("total_txt") ? $CurrentForm->getValue("total_txt") : $CurrentForm->getValue("x_total_txt");
        if (!$this->total_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total_txt->Visible = false; // Disable update for API request
            } else {
                $this->total_txt->setFormValue($val);
            }
        }

        // Check field name 'next_pay_date' first before field var 'x_next_pay_date'
        $val = $CurrentForm->hasValue("next_pay_date") ? $CurrentForm->getValue("next_pay_date") : $CurrentForm->getValue("x_next_pay_date");
        if (!$this->next_pay_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->next_pay_date->Visible = false; // Disable update for API request
            } else {
                $this->next_pay_date->setFormValue($val, true, $validate);
            }
            $this->next_pay_date->CurrentValue = UnFormatDateTime($this->next_pay_date->CurrentValue, $this->next_pay_date->formatPattern());
        }

        // Check field name 'next_pay_date_txt' first before field var 'x_next_pay_date_txt'
        $val = $CurrentForm->hasValue("next_pay_date_txt") ? $CurrentForm->getValue("next_pay_date_txt") : $CurrentForm->getValue("x_next_pay_date_txt");
        if (!$this->next_pay_date_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->next_pay_date_txt->Visible = false; // Disable update for API request
            } else {
                $this->next_pay_date_txt->setFormValue($val);
            }
        }

        // Check field name 'service_price' first before field var 'x_service_price'
        $val = $CurrentForm->hasValue("service_price") ? $CurrentForm->getValue("service_price") : $CurrentForm->getValue("x_service_price");
        if (!$this->service_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->service_price->Visible = false; // Disable update for API request
            } else {
                $this->service_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'service_price_txt' first before field var 'x_service_price_txt'
        $val = $CurrentForm->hasValue("service_price_txt") ? $CurrentForm->getValue("service_price_txt") : $CurrentForm->getValue("x_service_price_txt");
        if (!$this->service_price_txt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->service_price_txt->Visible = false; // Disable update for API request
            } else {
                $this->service_price_txt->setFormValue($val);
            }
        }

        // Check field name 'provide_service_date' first before field var 'x_provide_service_date'
        $val = $CurrentForm->hasValue("provide_service_date") ? $CurrentForm->getValue("provide_service_date") : $CurrentForm->getValue("x_provide_service_date");
        if (!$this->provide_service_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->provide_service_date->Visible = false; // Disable update for API request
            } else {
                $this->provide_service_date->setFormValue($val, true, $validate);
            }
            $this->provide_service_date->CurrentValue = UnFormatDateTime($this->provide_service_date->CurrentValue, $this->provide_service_date->formatPattern());
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

        // Check field name 'contact_address2' first before field var 'x_contact_address2'
        $val = $CurrentForm->hasValue("contact_address2") ? $CurrentForm->getValue("contact_address2") : $CurrentForm->getValue("x_contact_address2");
        if (!$this->contact_address2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_address2->Visible = false; // Disable update for API request
            } else {
                $this->contact_address2->setFormValue($val);
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

        // Check field name 'contact_lineid' first before field var 'x_contact_lineid'
        $val = $CurrentForm->hasValue("contact_lineid") ? $CurrentForm->getValue("contact_lineid") : $CurrentForm->getValue("x_contact_lineid");
        if (!$this->contact_lineid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_lineid->Visible = false; // Disable update for API request
            } else {
                $this->contact_lineid->setFormValue($val);
            }
        }

        // Check field name 'contact_phone' first before field var 'x_contact_phone'
        $val = $CurrentForm->hasValue("contact_phone") ? $CurrentForm->getValue("contact_phone") : $CurrentForm->getValue("x_contact_phone");
        if (!$this->contact_phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contact_phone->Visible = false; // Disable update for API request
            } else {
                $this->contact_phone->setFormValue($val);
            }
        }

        // Check field name 'attach_file' first before field var 'x_attach_file'
        $val = $CurrentForm->hasValue("attach_file") ? $CurrentForm->getValue("attach_file") : $CurrentForm->getValue("x_attach_file");
        if (!$this->attach_file->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->attach_file->Visible = false; // Disable update for API request
            } else {
                $this->attach_file->setFormValue($val);
            }
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
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

        // Check field name 'doc_date' first before field var 'x_doc_date'
        $val = $CurrentForm->hasValue("doc_date") ? $CurrentForm->getValue("doc_date") : $CurrentForm->getValue("x_doc_date");
        if (!$this->doc_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_date->Visible = false; // Disable update for API request
            } else {
                $this->doc_date->setFormValue($val);
            }
            $this->doc_date->CurrentValue = UnFormatDateTime($this->doc_date->CurrentValue, $this->doc_date->formatPattern());
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
		$this->file_idcard->OldUploadPath = "/upload/";
		$this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
		$this->file_house_regis->OldUploadPath = "/upload/";
		$this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
		$this->file_titledeed->OldUploadPath = "/upload/";
		$this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
		$this->file_other->OldUploadPath = "/upload/";
		$this->file_other->UploadPath = $this->file_other->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->document_date->CurrentValue = $this->document_date->FormValue;
        $this->document_date->CurrentValue = UnFormatDateTime($this->document_date->CurrentValue, $this->document_date->formatPattern());
        $this->years->CurrentValue = $this->years->FormValue;
        $this->start_date->CurrentValue = $this->start_date->FormValue;
        $this->start_date->CurrentValue = UnFormatDateTime($this->start_date->CurrentValue, $this->start_date->formatPattern());
        $this->end_date->CurrentValue = $this->end_date->FormValue;
        $this->end_date->CurrentValue = UnFormatDateTime($this->end_date->CurrentValue, $this->end_date->formatPattern());
        $this->asset_code->CurrentValue = $this->asset_code->FormValue;
        $this->asset_project->CurrentValue = $this->asset_project->FormValue;
        $this->asset_deed->CurrentValue = $this->asset_deed->FormValue;
        $this->asset_area->CurrentValue = $this->asset_area->FormValue;
        $this->appoint_agent_date->CurrentValue = $this->appoint_agent_date->FormValue;
        $this->appoint_agent_date->CurrentValue = UnFormatDateTime($this->appoint_agent_date->CurrentValue, $this->appoint_agent_date->formatPattern());
        $this->buyer_name->CurrentValue = $this->buyer_name->FormValue;
        $this->buyer_lname->CurrentValue = $this->buyer_lname->FormValue;
        $this->buyer_email->CurrentValue = $this->buyer_email->FormValue;
        $this->buyer_idcard->CurrentValue = $this->buyer_idcard->FormValue;
        $this->buyer_homeno->CurrentValue = $this->buyer_homeno->FormValue;
        $this->buyer_witness_name->CurrentValue = $this->buyer_witness_name->FormValue;
        $this->buyer_witness_lname->CurrentValue = $this->buyer_witness_lname->FormValue;
        $this->buyer_witness_email->CurrentValue = $this->buyer_witness_email->FormValue;
        $this->investor_name->CurrentValue = $this->investor_name->FormValue;
        $this->investor_lname->CurrentValue = $this->investor_lname->FormValue;
        $this->investor_email->CurrentValue = $this->investor_email->FormValue;
        $this->juzmatch_authority_name->CurrentValue = $this->juzmatch_authority_name->FormValue;
        $this->juzmatch_authority_lname->CurrentValue = $this->juzmatch_authority_lname->FormValue;
        $this->juzmatch_authority_email->CurrentValue = $this->juzmatch_authority_email->FormValue;
        $this->juzmatch_authority_witness_name->CurrentValue = $this->juzmatch_authority_witness_name->FormValue;
        $this->juzmatch_authority_witness_lname->CurrentValue = $this->juzmatch_authority_witness_lname->FormValue;
        $this->juzmatch_authority_witness_email->CurrentValue = $this->juzmatch_authority_witness_email->FormValue;
        $this->juzmatch_authority2_name->CurrentValue = $this->juzmatch_authority2_name->FormValue;
        $this->juzmatch_authority2_lname->CurrentValue = $this->juzmatch_authority2_lname->FormValue;
        $this->juzmatch_authority2_email->CurrentValue = $this->juzmatch_authority2_email->FormValue;
        $this->company_seal_name->CurrentValue = $this->company_seal_name->FormValue;
        $this->company_seal_email->CurrentValue = $this->company_seal_email->FormValue;
        $this->total->CurrentValue = $this->total->FormValue;
        $this->total_txt->CurrentValue = $this->total_txt->FormValue;
        $this->next_pay_date->CurrentValue = $this->next_pay_date->FormValue;
        $this->next_pay_date->CurrentValue = UnFormatDateTime($this->next_pay_date->CurrentValue, $this->next_pay_date->formatPattern());
        $this->next_pay_date_txt->CurrentValue = $this->next_pay_date_txt->FormValue;
        $this->service_price->CurrentValue = $this->service_price->FormValue;
        $this->service_price_txt->CurrentValue = $this->service_price_txt->FormValue;
        $this->provide_service_date->CurrentValue = $this->provide_service_date->FormValue;
        $this->provide_service_date->CurrentValue = UnFormatDateTime($this->provide_service_date->CurrentValue, $this->provide_service_date->formatPattern());
        $this->contact_address->CurrentValue = $this->contact_address->FormValue;
        $this->contact_address2->CurrentValue = $this->contact_address2->FormValue;
        $this->contact_email->CurrentValue = $this->contact_email->FormValue;
        $this->contact_lineid->CurrentValue = $this->contact_lineid->FormValue;
        $this->contact_phone->CurrentValue = $this->contact_phone->FormValue;
        $this->attach_file->CurrentValue = $this->attach_file->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->doc_date->CurrentValue = $this->doc_date->FormValue;
        $this->doc_date->CurrentValue = UnFormatDateTime($this->doc_date->CurrentValue, $this->doc_date->formatPattern());
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
        $this->document_date->setDbValue($row['document_date']);
        $this->years->setDbValue($row['years']);
        $this->start_date->setDbValue($row['start_date']);
        $this->end_date->setDbValue($row['end_date']);
        $this->asset_code->setDbValue($row['asset_code']);
        $this->asset_project->setDbValue($row['asset_project']);
        $this->asset_deed->setDbValue($row['asset_deed']);
        $this->asset_area->setDbValue($row['asset_area']);
        $this->appoint_agent_date->setDbValue($row['appoint_agent_date']);
        $this->buyer_name->setDbValue($row['buyer_name']);
        $this->buyer_lname->setDbValue($row['buyer_lname']);
        $this->buyer_email->setDbValue($row['buyer_email']);
        $this->buyer_idcard->setDbValue($row['buyer_idcard']);
        $this->buyer_homeno->setDbValue($row['buyer_homeno']);
        $this->buyer_witness_name->setDbValue($row['buyer_witness_name']);
        $this->buyer_witness_lname->setDbValue($row['buyer_witness_lname']);
        $this->buyer_witness_email->setDbValue($row['buyer_witness_email']);
        $this->investor_name->setDbValue($row['investor_name']);
        $this->investor_lname->setDbValue($row['investor_lname']);
        $this->investor_email->setDbValue($row['investor_email']);
        $this->juzmatch_authority_name->setDbValue($row['juzmatch_authority_name']);
        $this->juzmatch_authority_lname->setDbValue($row['juzmatch_authority_lname']);
        $this->juzmatch_authority_email->setDbValue($row['juzmatch_authority_email']);
        $this->juzmatch_authority_witness_name->setDbValue($row['juzmatch_authority_witness_name']);
        $this->juzmatch_authority_witness_lname->setDbValue($row['juzmatch_authority_witness_lname']);
        $this->juzmatch_authority_witness_email->setDbValue($row['juzmatch_authority_witness_email']);
        $this->juzmatch_authority2_name->setDbValue($row['juzmatch_authority2_name']);
        $this->juzmatch_authority2_lname->setDbValue($row['juzmatch_authority2_lname']);
        $this->juzmatch_authority2_email->setDbValue($row['juzmatch_authority2_email']);
        $this->company_seal_name->setDbValue($row['company_seal_name']);
        $this->company_seal_email->setDbValue($row['company_seal_email']);
        $this->total->setDbValue($row['total']);
        $this->total_txt->setDbValue($row['total_txt']);
        $this->next_pay_date->setDbValue($row['next_pay_date']);
        $this->next_pay_date_txt->setDbValue($row['next_pay_date_txt']);
        $this->service_price->setDbValue($row['service_price']);
        $this->service_price_txt->setDbValue($row['service_price_txt']);
        $this->provide_service_date->setDbValue($row['provide_service_date']);
        $this->contact_address->setDbValue($row['contact_address']);
        $this->contact_address2->setDbValue($row['contact_address2']);
        $this->contact_email->setDbValue($row['contact_email']);
        $this->contact_lineid->setDbValue($row['contact_lineid']);
        $this->contact_phone->setDbValue($row['contact_phone']);
        $this->file_idcard->Upload->DbValue = $row['file_idcard'];
        $this->file_idcard->setDbValue($this->file_idcard->Upload->DbValue);
        $this->file_house_regis->Upload->DbValue = $row['file_house_regis'];
        $this->file_house_regis->setDbValue($this->file_house_regis->Upload->DbValue);
        $this->file_titledeed->Upload->DbValue = $row['file_titledeed'];
        $this->file_titledeed->setDbValue($this->file_titledeed->Upload->DbValue);
        $this->file_other->Upload->DbValue = $row['file_other'];
        $this->file_other->setDbValue($this->file_other->Upload->DbValue);
        $this->attach_file->setDbValue($row['attach_file']);
        $this->status->setDbValue($row['status']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->doc_date->setDbValue($row['doc_date']);
        $this->buyer_booking_asset_id->setDbValue($row['buyer_booking_asset_id']);
        $this->first_down->setDbValue($row['first_down']);
        $this->first_down_txt->setDbValue($row['first_down_txt']);
        $this->second_down->setDbValue($row['second_down']);
        $this->second_down_txt->setDbValue($row['second_down_txt']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['document_date'] = $this->document_date->CurrentValue;
        $row['years'] = $this->years->CurrentValue;
        $row['start_date'] = $this->start_date->CurrentValue;
        $row['end_date'] = $this->end_date->CurrentValue;
        $row['asset_code'] = $this->asset_code->CurrentValue;
        $row['asset_project'] = $this->asset_project->CurrentValue;
        $row['asset_deed'] = $this->asset_deed->CurrentValue;
        $row['asset_area'] = $this->asset_area->CurrentValue;
        $row['appoint_agent_date'] = $this->appoint_agent_date->CurrentValue;
        $row['buyer_name'] = $this->buyer_name->CurrentValue;
        $row['buyer_lname'] = $this->buyer_lname->CurrentValue;
        $row['buyer_email'] = $this->buyer_email->CurrentValue;
        $row['buyer_idcard'] = $this->buyer_idcard->CurrentValue;
        $row['buyer_homeno'] = $this->buyer_homeno->CurrentValue;
        $row['buyer_witness_name'] = $this->buyer_witness_name->CurrentValue;
        $row['buyer_witness_lname'] = $this->buyer_witness_lname->CurrentValue;
        $row['buyer_witness_email'] = $this->buyer_witness_email->CurrentValue;
        $row['investor_name'] = $this->investor_name->CurrentValue;
        $row['investor_lname'] = $this->investor_lname->CurrentValue;
        $row['investor_email'] = $this->investor_email->CurrentValue;
        $row['juzmatch_authority_name'] = $this->juzmatch_authority_name->CurrentValue;
        $row['juzmatch_authority_lname'] = $this->juzmatch_authority_lname->CurrentValue;
        $row['juzmatch_authority_email'] = $this->juzmatch_authority_email->CurrentValue;
        $row['juzmatch_authority_witness_name'] = $this->juzmatch_authority_witness_name->CurrentValue;
        $row['juzmatch_authority_witness_lname'] = $this->juzmatch_authority_witness_lname->CurrentValue;
        $row['juzmatch_authority_witness_email'] = $this->juzmatch_authority_witness_email->CurrentValue;
        $row['juzmatch_authority2_name'] = $this->juzmatch_authority2_name->CurrentValue;
        $row['juzmatch_authority2_lname'] = $this->juzmatch_authority2_lname->CurrentValue;
        $row['juzmatch_authority2_email'] = $this->juzmatch_authority2_email->CurrentValue;
        $row['company_seal_name'] = $this->company_seal_name->CurrentValue;
        $row['company_seal_email'] = $this->company_seal_email->CurrentValue;
        $row['total'] = $this->total->CurrentValue;
        $row['total_txt'] = $this->total_txt->CurrentValue;
        $row['next_pay_date'] = $this->next_pay_date->CurrentValue;
        $row['next_pay_date_txt'] = $this->next_pay_date_txt->CurrentValue;
        $row['service_price'] = $this->service_price->CurrentValue;
        $row['service_price_txt'] = $this->service_price_txt->CurrentValue;
        $row['provide_service_date'] = $this->provide_service_date->CurrentValue;
        $row['contact_address'] = $this->contact_address->CurrentValue;
        $row['contact_address2'] = $this->contact_address2->CurrentValue;
        $row['contact_email'] = $this->contact_email->CurrentValue;
        $row['contact_lineid'] = $this->contact_lineid->CurrentValue;
        $row['contact_phone'] = $this->contact_phone->CurrentValue;
        $row['file_idcard'] = $this->file_idcard->Upload->DbValue;
        $row['file_house_regis'] = $this->file_house_regis->Upload->DbValue;
        $row['file_titledeed'] = $this->file_titledeed->Upload->DbValue;
        $row['file_other'] = $this->file_other->Upload->DbValue;
        $row['attach_file'] = $this->attach_file->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['doc_creden_id'] = $this->doc_creden_id->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['doc_date'] = $this->doc_date->CurrentValue;
        $row['buyer_booking_asset_id'] = $this->buyer_booking_asset_id->CurrentValue;
        $row['first_down'] = $this->first_down->CurrentValue;
        $row['first_down_txt'] = $this->first_down_txt->CurrentValue;
        $row['second_down'] = $this->second_down->CurrentValue;
        $row['second_down_txt'] = $this->second_down_txt->CurrentValue;
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

        // document_date
        $this->document_date->RowCssClass = "row";

        // years
        $this->years->RowCssClass = "row";

        // start_date
        $this->start_date->RowCssClass = "row";

        // end_date
        $this->end_date->RowCssClass = "row";

        // asset_code
        $this->asset_code->RowCssClass = "row";

        // asset_project
        $this->asset_project->RowCssClass = "row";

        // asset_deed
        $this->asset_deed->RowCssClass = "row";

        // asset_area
        $this->asset_area->RowCssClass = "row";

        // appoint_agent_date
        $this->appoint_agent_date->RowCssClass = "row";

        // buyer_name
        $this->buyer_name->RowCssClass = "row";

        // buyer_lname
        $this->buyer_lname->RowCssClass = "row";

        // buyer_email
        $this->buyer_email->RowCssClass = "row";

        // buyer_idcard
        $this->buyer_idcard->RowCssClass = "row";

        // buyer_homeno
        $this->buyer_homeno->RowCssClass = "row";

        // buyer_witness_name
        $this->buyer_witness_name->RowCssClass = "row";

        // buyer_witness_lname
        $this->buyer_witness_lname->RowCssClass = "row";

        // buyer_witness_email
        $this->buyer_witness_email->RowCssClass = "row";

        // investor_name
        $this->investor_name->RowCssClass = "row";

        // investor_lname
        $this->investor_lname->RowCssClass = "row";

        // investor_email
        $this->investor_email->RowCssClass = "row";

        // juzmatch_authority_name
        $this->juzmatch_authority_name->RowCssClass = "row";

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->RowCssClass = "row";

        // juzmatch_authority_email
        $this->juzmatch_authority_email->RowCssClass = "row";

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name->RowCssClass = "row";

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->RowCssClass = "row";

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->RowCssClass = "row";

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->RowCssClass = "row";

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->RowCssClass = "row";

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->RowCssClass = "row";

        // company_seal_name
        $this->company_seal_name->RowCssClass = "row";

        // company_seal_email
        $this->company_seal_email->RowCssClass = "row";

        // total
        $this->total->RowCssClass = "row";

        // total_txt
        $this->total_txt->RowCssClass = "row";

        // next_pay_date
        $this->next_pay_date->RowCssClass = "row";

        // next_pay_date_txt
        $this->next_pay_date_txt->RowCssClass = "row";

        // service_price
        $this->service_price->RowCssClass = "row";

        // service_price_txt
        $this->service_price_txt->RowCssClass = "row";

        // provide_service_date
        $this->provide_service_date->RowCssClass = "row";

        // contact_address
        $this->contact_address->RowCssClass = "row";

        // contact_address2
        $this->contact_address2->RowCssClass = "row";

        // contact_email
        $this->contact_email->RowCssClass = "row";

        // contact_lineid
        $this->contact_lineid->RowCssClass = "row";

        // contact_phone
        $this->contact_phone->RowCssClass = "row";

        // file_idcard
        $this->file_idcard->RowCssClass = "row";

        // file_house_regis
        $this->file_house_regis->RowCssClass = "row";

        // file_titledeed
        $this->file_titledeed->RowCssClass = "row";

        // file_other
        $this->file_other->RowCssClass = "row";

        // attach_file
        $this->attach_file->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // doc_creden_id
        $this->doc_creden_id->RowCssClass = "row";

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

        // doc_date
        $this->doc_date->RowCssClass = "row";

        // buyer_booking_asset_id
        $this->buyer_booking_asset_id->RowCssClass = "row";

        // first_down
        $this->first_down->RowCssClass = "row";

        // first_down_txt
        $this->first_down_txt->RowCssClass = "row";

        // second_down
        $this->second_down->RowCssClass = "row";

        // second_down_txt
        $this->second_down_txt->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // document_date
            $this->document_date->ViewValue = $this->document_date->CurrentValue;
            $this->document_date->ViewValue = FormatDateTime($this->document_date->ViewValue, $this->document_date->formatPattern());
            $this->document_date->ViewCustomAttributes = "";

            // years
            $this->years->ViewValue = $this->years->CurrentValue;
            $this->years->ViewValue = FormatNumber($this->years->ViewValue, $this->years->formatPattern());
            $this->years->ViewCustomAttributes = "";

            // start_date
            $this->start_date->ViewValue = $this->start_date->CurrentValue;
            $this->start_date->ViewValue = FormatDateTime($this->start_date->ViewValue, $this->start_date->formatPattern());
            $this->start_date->ViewCustomAttributes = "";

            // end_date
            $this->end_date->ViewValue = $this->end_date->CurrentValue;
            $this->end_date->ViewValue = FormatDateTime($this->end_date->ViewValue, $this->end_date->formatPattern());
            $this->end_date->ViewCustomAttributes = "";

            // asset_code
            $this->asset_code->ViewValue = $this->asset_code->CurrentValue;
            $this->asset_code->ViewCustomAttributes = "";

            // asset_project
            $this->asset_project->ViewValue = $this->asset_project->CurrentValue;
            $this->asset_project->ViewCustomAttributes = "";

            // asset_deed
            $this->asset_deed->ViewValue = $this->asset_deed->CurrentValue;
            $this->asset_deed->ViewCustomAttributes = "";

            // asset_area
            $this->asset_area->ViewValue = $this->asset_area->CurrentValue;
            $this->asset_area->ViewCustomAttributes = "";

            // appoint_agent_date
            $this->appoint_agent_date->ViewValue = $this->appoint_agent_date->CurrentValue;
            $this->appoint_agent_date->ViewValue = FormatDateTime($this->appoint_agent_date->ViewValue, $this->appoint_agent_date->formatPattern());
            $this->appoint_agent_date->ViewCustomAttributes = "";

            // buyer_name
            $this->buyer_name->ViewValue = $this->buyer_name->CurrentValue;
            $this->buyer_name->ViewCustomAttributes = "";

            // buyer_lname
            $this->buyer_lname->ViewValue = $this->buyer_lname->CurrentValue;
            $this->buyer_lname->ViewCustomAttributes = "";

            // buyer_email
            $this->buyer_email->ViewValue = $this->buyer_email->CurrentValue;
            $this->buyer_email->ViewCustomAttributes = "";

            // buyer_idcard
            $this->buyer_idcard->ViewValue = $this->buyer_idcard->CurrentValue;
            $this->buyer_idcard->ViewCustomAttributes = "";

            // buyer_homeno
            $this->buyer_homeno->ViewValue = $this->buyer_homeno->CurrentValue;
            $this->buyer_homeno->ViewCustomAttributes = "";

            // buyer_witness_name
            $this->buyer_witness_name->ViewValue = $this->buyer_witness_name->CurrentValue;
            $this->buyer_witness_name->ViewCustomAttributes = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->ViewValue = $this->buyer_witness_lname->CurrentValue;
            $this->buyer_witness_lname->ViewCustomAttributes = "";

            // buyer_witness_email
            $this->buyer_witness_email->ViewValue = $this->buyer_witness_email->CurrentValue;
            $this->buyer_witness_email->ViewCustomAttributes = "";

            // investor_name
            $this->investor_name->ViewValue = $this->investor_name->CurrentValue;
            $this->investor_name->ViewCustomAttributes = "";

            // investor_lname
            $this->investor_lname->ViewValue = $this->investor_lname->CurrentValue;
            $this->investor_lname->ViewCustomAttributes = "";

            // investor_email
            $this->investor_email->ViewValue = $this->investor_email->CurrentValue;
            $this->investor_email->ViewCustomAttributes = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->ViewValue = $this->juzmatch_authority_name->CurrentValue;
            $this->juzmatch_authority_name->ViewCustomAttributes = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->ViewValue = $this->juzmatch_authority_lname->CurrentValue;
            $this->juzmatch_authority_lname->ViewCustomAttributes = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->ViewValue = $this->juzmatch_authority_email->CurrentValue;
            $this->juzmatch_authority_email->ViewCustomAttributes = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->ViewValue = $this->juzmatch_authority_witness_name->CurrentValue;
            $this->juzmatch_authority_witness_name->ViewCustomAttributes = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->ViewValue = $this->juzmatch_authority_witness_lname->CurrentValue;
            $this->juzmatch_authority_witness_lname->ViewCustomAttributes = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->ViewValue = $this->juzmatch_authority_witness_email->CurrentValue;
            $this->juzmatch_authority_witness_email->ViewCustomAttributes = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->ViewValue = $this->juzmatch_authority2_name->CurrentValue;
            $this->juzmatch_authority2_name->ViewCustomAttributes = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->ViewValue = $this->juzmatch_authority2_lname->CurrentValue;
            $this->juzmatch_authority2_lname->ViewCustomAttributes = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->ViewValue = $this->juzmatch_authority2_email->CurrentValue;
            $this->juzmatch_authority2_email->ViewCustomAttributes = "";

            // company_seal_name
            $this->company_seal_name->ViewValue = $this->company_seal_name->CurrentValue;
            $this->company_seal_name->ViewCustomAttributes = "";

            // company_seal_email
            $this->company_seal_email->ViewValue = $this->company_seal_email->CurrentValue;
            $this->company_seal_email->ViewCustomAttributes = "";

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, $this->total->formatPattern());
            $this->total->ViewCustomAttributes = "";

            // total_txt
            $this->total_txt->ViewValue = $this->total_txt->CurrentValue;
            $this->total_txt->ViewCustomAttributes = "";

            // next_pay_date
            $this->next_pay_date->ViewValue = $this->next_pay_date->CurrentValue;
            $this->next_pay_date->ViewValue = FormatDateTime($this->next_pay_date->ViewValue, $this->next_pay_date->formatPattern());
            $this->next_pay_date->ViewCustomAttributes = "";

            // next_pay_date_txt
            $this->next_pay_date_txt->ViewValue = $this->next_pay_date_txt->CurrentValue;
            $this->next_pay_date_txt->ViewCustomAttributes = "";

            // service_price
            $this->service_price->ViewValue = $this->service_price->CurrentValue;
            $this->service_price->ViewValue = FormatNumber($this->service_price->ViewValue, $this->service_price->formatPattern());
            $this->service_price->ViewCustomAttributes = "";

            // service_price_txt
            $this->service_price_txt->ViewValue = $this->service_price_txt->CurrentValue;
            $this->service_price_txt->ViewCustomAttributes = "";

            // provide_service_date
            $this->provide_service_date->ViewValue = $this->provide_service_date->CurrentValue;
            $this->provide_service_date->ViewValue = FormatDateTime($this->provide_service_date->ViewValue, $this->provide_service_date->formatPattern());
            $this->provide_service_date->ViewCustomAttributes = "";

            // contact_address
            $this->contact_address->ViewValue = $this->contact_address->CurrentValue;
            $this->contact_address->ViewCustomAttributes = "";

            // contact_address2
            $this->contact_address2->ViewValue = $this->contact_address2->CurrentValue;
            $this->contact_address2->ViewCustomAttributes = "";

            // contact_email
            $this->contact_email->ViewValue = $this->contact_email->CurrentValue;
            $this->contact_email->ViewCustomAttributes = "";

            // contact_lineid
            $this->contact_lineid->ViewValue = $this->contact_lineid->CurrentValue;
            $this->contact_lineid->ViewCustomAttributes = "";

            // contact_phone
            $this->contact_phone->ViewValue = $this->contact_phone->CurrentValue;
            $this->contact_phone->ViewCustomAttributes = "";

            // file_idcard
            $this->file_idcard->UploadPath = "/upload/";
            if (!EmptyValue($this->file_idcard->Upload->DbValue)) {
                $this->file_idcard->ViewValue = $this->file_idcard->Upload->DbValue;
            } else {
                $this->file_idcard->ViewValue = "";
            }
            $this->file_idcard->ViewCustomAttributes = "";

            // file_house_regis
            $this->file_house_regis->UploadPath = "/upload/";
            if (!EmptyValue($this->file_house_regis->Upload->DbValue)) {
                $this->file_house_regis->ViewValue = $this->file_house_regis->Upload->DbValue;
            } else {
                $this->file_house_regis->ViewValue = "";
            }
            $this->file_house_regis->ViewCustomAttributes = "";

            // file_titledeed
            $this->file_titledeed->UploadPath = "/upload/";
            if (!EmptyValue($this->file_titledeed->Upload->DbValue)) {
                $this->file_titledeed->ViewValue = $this->file_titledeed->Upload->DbValue;
            } else {
                $this->file_titledeed->ViewValue = "";
            }
            $this->file_titledeed->ViewCustomAttributes = "";

            // file_other
            $this->file_other->UploadPath = "/upload/";
            if (!EmptyValue($this->file_other->Upload->DbValue)) {
                $this->file_other->ViewValue = $this->file_other->Upload->DbValue;
            } else {
                $this->file_other->ViewValue = "";
            }
            $this->file_other->ViewCustomAttributes = "";

            // attach_file
            $this->attach_file->ViewValue = $this->attach_file->CurrentValue;
            $this->attach_file->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

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

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewValue = FormatNumber($this->uuser->ViewValue, $this->uuser->formatPattern());
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // doc_date
            $this->doc_date->ViewValue = $this->doc_date->CurrentValue;
            $this->doc_date->ViewValue = FormatDateTime($this->doc_date->ViewValue, $this->doc_date->formatPattern());
            $this->doc_date->ViewCustomAttributes = "";

            // document_date
            $this->document_date->LinkCustomAttributes = "";
            $this->document_date->HrefValue = "";

            // years
            $this->years->LinkCustomAttributes = "";
            $this->years->HrefValue = "";

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";

            // appoint_agent_date
            $this->appoint_agent_date->LinkCustomAttributes = "";
            $this->appoint_agent_date->HrefValue = "";

            // buyer_name
            $this->buyer_name->LinkCustomAttributes = "";
            $this->buyer_name->HrefValue = "";

            // buyer_lname
            $this->buyer_lname->LinkCustomAttributes = "";
            $this->buyer_lname->HrefValue = "";

            // buyer_email
            $this->buyer_email->LinkCustomAttributes = "";
            $this->buyer_email->HrefValue = "";

            // buyer_idcard
            $this->buyer_idcard->LinkCustomAttributes = "";
            $this->buyer_idcard->HrefValue = "";

            // buyer_homeno
            $this->buyer_homeno->LinkCustomAttributes = "";
            $this->buyer_homeno->HrefValue = "";

            // buyer_witness_name
            $this->buyer_witness_name->LinkCustomAttributes = "";
            $this->buyer_witness_name->HrefValue = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->LinkCustomAttributes = "";
            $this->buyer_witness_lname->HrefValue = "";

            // buyer_witness_email
            $this->buyer_witness_email->LinkCustomAttributes = "";
            $this->buyer_witness_email->HrefValue = "";

            // investor_name
            $this->investor_name->LinkCustomAttributes = "";
            $this->investor_name->HrefValue = "";

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_name->HrefValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_name->HrefValue = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_lname->HrefValue = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_email->HrefValue = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->LinkCustomAttributes = "";
            $this->juzmatch_authority2_name->HrefValue = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority2_lname->HrefValue = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->LinkCustomAttributes = "";
            $this->juzmatch_authority2_email->HrefValue = "";

            // company_seal_name
            $this->company_seal_name->LinkCustomAttributes = "";
            $this->company_seal_name->HrefValue = "";

            // company_seal_email
            $this->company_seal_email->LinkCustomAttributes = "";
            $this->company_seal_email->HrefValue = "";

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";

            // total_txt
            $this->total_txt->LinkCustomAttributes = "";
            $this->total_txt->HrefValue = "";

            // next_pay_date
            $this->next_pay_date->LinkCustomAttributes = "";
            $this->next_pay_date->HrefValue = "";

            // next_pay_date_txt
            $this->next_pay_date_txt->LinkCustomAttributes = "";
            $this->next_pay_date_txt->HrefValue = "";

            // service_price
            $this->service_price->LinkCustomAttributes = "";
            $this->service_price->HrefValue = "";

            // service_price_txt
            $this->service_price_txt->LinkCustomAttributes = "";
            $this->service_price_txt->HrefValue = "";

            // provide_service_date
            $this->provide_service_date->LinkCustomAttributes = "";
            $this->provide_service_date->HrefValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";

            // contact_address2
            $this->contact_address2->LinkCustomAttributes = "";
            $this->contact_address2->HrefValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";

            // contact_lineid
            $this->contact_lineid->LinkCustomAttributes = "";
            $this->contact_lineid->HrefValue = "";

            // contact_phone
            $this->contact_phone->LinkCustomAttributes = "";
            $this->contact_phone->HrefValue = "";

            // file_idcard
            $this->file_idcard->LinkCustomAttributes = "";
            $this->file_idcard->HrefValue = "";
            $this->file_idcard->ExportHrefValue = $this->file_idcard->UploadPath . $this->file_idcard->Upload->DbValue;

            // file_house_regis
            $this->file_house_regis->LinkCustomAttributes = "";
            $this->file_house_regis->HrefValue = "";
            $this->file_house_regis->ExportHrefValue = $this->file_house_regis->UploadPath . $this->file_house_regis->Upload->DbValue;

            // file_titledeed
            $this->file_titledeed->LinkCustomAttributes = "";
            $this->file_titledeed->HrefValue = "";
            $this->file_titledeed->ExportHrefValue = $this->file_titledeed->UploadPath . $this->file_titledeed->Upload->DbValue;

            // file_other
            $this->file_other->LinkCustomAttributes = "";
            $this->file_other->HrefValue = "";
            $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;

            // attach_file
            $this->attach_file->LinkCustomAttributes = "";
            $this->attach_file->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

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

            // doc_date
            $this->doc_date->LinkCustomAttributes = "";
            $this->doc_date->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // document_date

            // years
            $this->years->setupEditAttributes();
            $this->years->EditCustomAttributes = "";
            $this->years->EditValue = HtmlEncode($this->years->CurrentValue);
            $this->years->PlaceHolder = RemoveHtml($this->years->caption());
            if (strval($this->years->EditValue) != "" && is_numeric($this->years->EditValue)) {
                $this->years->EditValue = FormatNumber($this->years->EditValue, null);
            }

            // start_date
            $this->start_date->setupEditAttributes();
            $this->start_date->EditCustomAttributes = "";
            $this->start_date->EditValue = HtmlEncode(FormatDateTime($this->start_date->CurrentValue, $this->start_date->formatPattern()));
            $this->start_date->PlaceHolder = RemoveHtml($this->start_date->caption());

            // end_date
            $this->end_date->setupEditAttributes();
            $this->end_date->EditCustomAttributes = "";
            $this->end_date->EditValue = HtmlEncode(FormatDateTime($this->end_date->CurrentValue, $this->end_date->formatPattern()));
            $this->end_date->PlaceHolder = RemoveHtml($this->end_date->caption());

            // asset_code
            $this->asset_code->setupEditAttributes();
            $this->asset_code->EditCustomAttributes = "";
            if (!$this->asset_code->Raw) {
                $this->asset_code->CurrentValue = HtmlDecode($this->asset_code->CurrentValue);
            }
            $this->asset_code->EditValue = HtmlEncode($this->asset_code->CurrentValue);
            $this->asset_code->PlaceHolder = RemoveHtml($this->asset_code->caption());

            // asset_project
            $this->asset_project->setupEditAttributes();
            $this->asset_project->EditCustomAttributes = "";
            if (!$this->asset_project->Raw) {
                $this->asset_project->CurrentValue = HtmlDecode($this->asset_project->CurrentValue);
            }
            $this->asset_project->EditValue = HtmlEncode($this->asset_project->CurrentValue);
            $this->asset_project->PlaceHolder = RemoveHtml($this->asset_project->caption());

            // asset_deed
            $this->asset_deed->setupEditAttributes();
            $this->asset_deed->EditCustomAttributes = "";
            if (!$this->asset_deed->Raw) {
                $this->asset_deed->CurrentValue = HtmlDecode($this->asset_deed->CurrentValue);
            }
            $this->asset_deed->EditValue = HtmlEncode($this->asset_deed->CurrentValue);
            $this->asset_deed->PlaceHolder = RemoveHtml($this->asset_deed->caption());

            // asset_area
            $this->asset_area->setupEditAttributes();
            $this->asset_area->EditCustomAttributes = "";
            if (!$this->asset_area->Raw) {
                $this->asset_area->CurrentValue = HtmlDecode($this->asset_area->CurrentValue);
            }
            $this->asset_area->EditValue = HtmlEncode($this->asset_area->CurrentValue);
            $this->asset_area->PlaceHolder = RemoveHtml($this->asset_area->caption());

            // appoint_agent_date
            $this->appoint_agent_date->setupEditAttributes();
            $this->appoint_agent_date->EditCustomAttributes = "";
            $this->appoint_agent_date->EditValue = HtmlEncode(FormatDateTime($this->appoint_agent_date->CurrentValue, $this->appoint_agent_date->formatPattern()));
            $this->appoint_agent_date->PlaceHolder = RemoveHtml($this->appoint_agent_date->caption());

            // buyer_name
            $this->buyer_name->setupEditAttributes();
            $this->buyer_name->EditCustomAttributes = "";
            if (!$this->buyer_name->Raw) {
                $this->buyer_name->CurrentValue = HtmlDecode($this->buyer_name->CurrentValue);
            }
            $this->buyer_name->EditValue = HtmlEncode($this->buyer_name->CurrentValue);
            $this->buyer_name->PlaceHolder = RemoveHtml($this->buyer_name->caption());

            // buyer_lname
            $this->buyer_lname->setupEditAttributes();
            $this->buyer_lname->EditCustomAttributes = "";
            if (!$this->buyer_lname->Raw) {
                $this->buyer_lname->CurrentValue = HtmlDecode($this->buyer_lname->CurrentValue);
            }
            $this->buyer_lname->EditValue = HtmlEncode($this->buyer_lname->CurrentValue);
            $this->buyer_lname->PlaceHolder = RemoveHtml($this->buyer_lname->caption());

            // buyer_email
            $this->buyer_email->setupEditAttributes();
            $this->buyer_email->EditCustomAttributes = "";
            if (!$this->buyer_email->Raw) {
                $this->buyer_email->CurrentValue = HtmlDecode($this->buyer_email->CurrentValue);
            }
            $this->buyer_email->EditValue = HtmlEncode($this->buyer_email->CurrentValue);
            $this->buyer_email->PlaceHolder = RemoveHtml($this->buyer_email->caption());

            // buyer_idcard
            $this->buyer_idcard->setupEditAttributes();
            $this->buyer_idcard->EditCustomAttributes = "";
            if (!$this->buyer_idcard->Raw) {
                $this->buyer_idcard->CurrentValue = HtmlDecode($this->buyer_idcard->CurrentValue);
            }
            $this->buyer_idcard->EditValue = HtmlEncode($this->buyer_idcard->CurrentValue);
            $this->buyer_idcard->PlaceHolder = RemoveHtml($this->buyer_idcard->caption());

            // buyer_homeno
            $this->buyer_homeno->setupEditAttributes();
            $this->buyer_homeno->EditCustomAttributes = "";
            if (!$this->buyer_homeno->Raw) {
                $this->buyer_homeno->CurrentValue = HtmlDecode($this->buyer_homeno->CurrentValue);
            }
            $this->buyer_homeno->EditValue = HtmlEncode($this->buyer_homeno->CurrentValue);
            $this->buyer_homeno->PlaceHolder = RemoveHtml($this->buyer_homeno->caption());

            // buyer_witness_name
            $this->buyer_witness_name->setupEditAttributes();
            $this->buyer_witness_name->EditCustomAttributes = "";
            if (!$this->buyer_witness_name->Raw) {
                $this->buyer_witness_name->CurrentValue = HtmlDecode($this->buyer_witness_name->CurrentValue);
            }
            $this->buyer_witness_name->EditValue = HtmlEncode($this->buyer_witness_name->CurrentValue);
            $this->buyer_witness_name->PlaceHolder = RemoveHtml($this->buyer_witness_name->caption());

            // buyer_witness_lname
            $this->buyer_witness_lname->setupEditAttributes();
            $this->buyer_witness_lname->EditCustomAttributes = "";
            if (!$this->buyer_witness_lname->Raw) {
                $this->buyer_witness_lname->CurrentValue = HtmlDecode($this->buyer_witness_lname->CurrentValue);
            }
            $this->buyer_witness_lname->EditValue = HtmlEncode($this->buyer_witness_lname->CurrentValue);
            $this->buyer_witness_lname->PlaceHolder = RemoveHtml($this->buyer_witness_lname->caption());

            // buyer_witness_email
            $this->buyer_witness_email->setupEditAttributes();
            $this->buyer_witness_email->EditCustomAttributes = "";
            if (!$this->buyer_witness_email->Raw) {
                $this->buyer_witness_email->CurrentValue = HtmlDecode($this->buyer_witness_email->CurrentValue);
            }
            $this->buyer_witness_email->EditValue = HtmlEncode($this->buyer_witness_email->CurrentValue);
            $this->buyer_witness_email->PlaceHolder = RemoveHtml($this->buyer_witness_email->caption());

            // investor_name
            $this->investor_name->setupEditAttributes();
            $this->investor_name->EditCustomAttributes = "";
            if (!$this->investor_name->Raw) {
                $this->investor_name->CurrentValue = HtmlDecode($this->investor_name->CurrentValue);
            }
            $this->investor_name->EditValue = HtmlEncode($this->investor_name->CurrentValue);
            $this->investor_name->PlaceHolder = RemoveHtml($this->investor_name->caption());

            // investor_lname
            $this->investor_lname->setupEditAttributes();
            $this->investor_lname->EditCustomAttributes = "";
            if (!$this->investor_lname->Raw) {
                $this->investor_lname->CurrentValue = HtmlDecode($this->investor_lname->CurrentValue);
            }
            $this->investor_lname->EditValue = HtmlEncode($this->investor_lname->CurrentValue);
            $this->investor_lname->PlaceHolder = RemoveHtml($this->investor_lname->caption());

            // investor_email
            $this->investor_email->setupEditAttributes();
            $this->investor_email->EditCustomAttributes = "";
            if (!$this->investor_email->Raw) {
                $this->investor_email->CurrentValue = HtmlDecode($this->investor_email->CurrentValue);
            }
            $this->investor_email->EditValue = HtmlEncode($this->investor_email->CurrentValue);
            $this->investor_email->PlaceHolder = RemoveHtml($this->investor_email->caption());

            // juzmatch_authority_name
            $this->juzmatch_authority_name->setupEditAttributes();
            $this->juzmatch_authority_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_name->Raw) {
                $this->juzmatch_authority_name->CurrentValue = HtmlDecode($this->juzmatch_authority_name->CurrentValue);
            }
            $this->juzmatch_authority_name->EditValue = HtmlEncode($this->juzmatch_authority_name->CurrentValue);
            $this->juzmatch_authority_name->PlaceHolder = RemoveHtml($this->juzmatch_authority_name->caption());

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->setupEditAttributes();
            $this->juzmatch_authority_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_lname->Raw) {
                $this->juzmatch_authority_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_lname->CurrentValue);
            }
            $this->juzmatch_authority_lname->EditValue = HtmlEncode($this->juzmatch_authority_lname->CurrentValue);
            $this->juzmatch_authority_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_lname->caption());

            // juzmatch_authority_email
            $this->juzmatch_authority_email->setupEditAttributes();
            $this->juzmatch_authority_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_email->Raw) {
                $this->juzmatch_authority_email->CurrentValue = HtmlDecode($this->juzmatch_authority_email->CurrentValue);
            }
            $this->juzmatch_authority_email->EditValue = HtmlEncode($this->juzmatch_authority_email->CurrentValue);
            $this->juzmatch_authority_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_email->caption());

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->setupEditAttributes();
            $this->juzmatch_authority_witness_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_name->Raw) {
                $this->juzmatch_authority_witness_name->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_name->CurrentValue);
            }
            $this->juzmatch_authority_witness_name->EditValue = HtmlEncode($this->juzmatch_authority_witness_name->CurrentValue);
            $this->juzmatch_authority_witness_name->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_name->caption());

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->setupEditAttributes();
            $this->juzmatch_authority_witness_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_lname->Raw) {
                $this->juzmatch_authority_witness_lname->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_lname->CurrentValue);
            }
            $this->juzmatch_authority_witness_lname->EditValue = HtmlEncode($this->juzmatch_authority_witness_lname->CurrentValue);
            $this->juzmatch_authority_witness_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_lname->caption());

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->setupEditAttributes();
            $this->juzmatch_authority_witness_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority_witness_email->Raw) {
                $this->juzmatch_authority_witness_email->CurrentValue = HtmlDecode($this->juzmatch_authority_witness_email->CurrentValue);
            }
            $this->juzmatch_authority_witness_email->EditValue = HtmlEncode($this->juzmatch_authority_witness_email->CurrentValue);
            $this->juzmatch_authority_witness_email->PlaceHolder = RemoveHtml($this->juzmatch_authority_witness_email->caption());

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->setupEditAttributes();
            $this->juzmatch_authority2_name->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_name->Raw) {
                $this->juzmatch_authority2_name->CurrentValue = HtmlDecode($this->juzmatch_authority2_name->CurrentValue);
            }
            $this->juzmatch_authority2_name->EditValue = HtmlEncode($this->juzmatch_authority2_name->CurrentValue);
            $this->juzmatch_authority2_name->PlaceHolder = RemoveHtml($this->juzmatch_authority2_name->caption());

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->setupEditAttributes();
            $this->juzmatch_authority2_lname->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_lname->Raw) {
                $this->juzmatch_authority2_lname->CurrentValue = HtmlDecode($this->juzmatch_authority2_lname->CurrentValue);
            }
            $this->juzmatch_authority2_lname->EditValue = HtmlEncode($this->juzmatch_authority2_lname->CurrentValue);
            $this->juzmatch_authority2_lname->PlaceHolder = RemoveHtml($this->juzmatch_authority2_lname->caption());

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->setupEditAttributes();
            $this->juzmatch_authority2_email->EditCustomAttributes = "";
            if (!$this->juzmatch_authority2_email->Raw) {
                $this->juzmatch_authority2_email->CurrentValue = HtmlDecode($this->juzmatch_authority2_email->CurrentValue);
            }
            $this->juzmatch_authority2_email->EditValue = HtmlEncode($this->juzmatch_authority2_email->CurrentValue);
            $this->juzmatch_authority2_email->PlaceHolder = RemoveHtml($this->juzmatch_authority2_email->caption());

            // company_seal_name
            $this->company_seal_name->setupEditAttributes();
            $this->company_seal_name->EditCustomAttributes = "";
            if (!$this->company_seal_name->Raw) {
                $this->company_seal_name->CurrentValue = HtmlDecode($this->company_seal_name->CurrentValue);
            }
            $this->company_seal_name->EditValue = HtmlEncode($this->company_seal_name->CurrentValue);
            $this->company_seal_name->PlaceHolder = RemoveHtml($this->company_seal_name->caption());

            // company_seal_email
            $this->company_seal_email->setupEditAttributes();
            $this->company_seal_email->EditCustomAttributes = "";
            if (!$this->company_seal_email->Raw) {
                $this->company_seal_email->CurrentValue = HtmlDecode($this->company_seal_email->CurrentValue);
            }
            $this->company_seal_email->EditValue = HtmlEncode($this->company_seal_email->CurrentValue);
            $this->company_seal_email->PlaceHolder = RemoveHtml($this->company_seal_email->caption());

            // total
            $this->total->setupEditAttributes();
            $this->total->EditCustomAttributes = "";
            $this->total->EditValue = HtmlEncode($this->total->CurrentValue);
            $this->total->PlaceHolder = RemoveHtml($this->total->caption());
            if (strval($this->total->EditValue) != "" && is_numeric($this->total->EditValue)) {
                $this->total->EditValue = FormatNumber($this->total->EditValue, null);
            }

            // total_txt
            $this->total_txt->setupEditAttributes();
            $this->total_txt->EditCustomAttributes = "";
            if (!$this->total_txt->Raw) {
                $this->total_txt->CurrentValue = HtmlDecode($this->total_txt->CurrentValue);
            }
            $this->total_txt->EditValue = HtmlEncode($this->total_txt->CurrentValue);
            $this->total_txt->PlaceHolder = RemoveHtml($this->total_txt->caption());

            // next_pay_date
            $this->next_pay_date->setupEditAttributes();
            $this->next_pay_date->EditCustomAttributes = "";
            $this->next_pay_date->EditValue = HtmlEncode(FormatDateTime($this->next_pay_date->CurrentValue, $this->next_pay_date->formatPattern()));
            $this->next_pay_date->PlaceHolder = RemoveHtml($this->next_pay_date->caption());

            // next_pay_date_txt
            $this->next_pay_date_txt->setupEditAttributes();
            $this->next_pay_date_txt->EditCustomAttributes = "";
            if (!$this->next_pay_date_txt->Raw) {
                $this->next_pay_date_txt->CurrentValue = HtmlDecode($this->next_pay_date_txt->CurrentValue);
            }
            $this->next_pay_date_txt->EditValue = HtmlEncode($this->next_pay_date_txt->CurrentValue);
            $this->next_pay_date_txt->PlaceHolder = RemoveHtml($this->next_pay_date_txt->caption());

            // service_price
            $this->service_price->setupEditAttributes();
            $this->service_price->EditCustomAttributes = "";
            $this->service_price->EditValue = HtmlEncode($this->service_price->CurrentValue);
            $this->service_price->PlaceHolder = RemoveHtml($this->service_price->caption());
            if (strval($this->service_price->EditValue) != "" && is_numeric($this->service_price->EditValue)) {
                $this->service_price->EditValue = FormatNumber($this->service_price->EditValue, null);
            }

            // service_price_txt
            $this->service_price_txt->setupEditAttributes();
            $this->service_price_txt->EditCustomAttributes = "";
            if (!$this->service_price_txt->Raw) {
                $this->service_price_txt->CurrentValue = HtmlDecode($this->service_price_txt->CurrentValue);
            }
            $this->service_price_txt->EditValue = HtmlEncode($this->service_price_txt->CurrentValue);
            $this->service_price_txt->PlaceHolder = RemoveHtml($this->service_price_txt->caption());

            // provide_service_date
            $this->provide_service_date->setupEditAttributes();
            $this->provide_service_date->EditCustomAttributes = "";
            $this->provide_service_date->EditValue = HtmlEncode(FormatDateTime($this->provide_service_date->CurrentValue, $this->provide_service_date->formatPattern()));
            $this->provide_service_date->PlaceHolder = RemoveHtml($this->provide_service_date->caption());

            // contact_address
            $this->contact_address->setupEditAttributes();
            $this->contact_address->EditCustomAttributes = "";
            if (!$this->contact_address->Raw) {
                $this->contact_address->CurrentValue = HtmlDecode($this->contact_address->CurrentValue);
            }
            $this->contact_address->EditValue = HtmlEncode($this->contact_address->CurrentValue);
            $this->contact_address->PlaceHolder = RemoveHtml($this->contact_address->caption());

            // contact_address2
            $this->contact_address2->setupEditAttributes();
            $this->contact_address2->EditCustomAttributes = "";
            if (!$this->contact_address2->Raw) {
                $this->contact_address2->CurrentValue = HtmlDecode($this->contact_address2->CurrentValue);
            }
            $this->contact_address2->EditValue = HtmlEncode($this->contact_address2->CurrentValue);
            $this->contact_address2->PlaceHolder = RemoveHtml($this->contact_address2->caption());

            // contact_email
            $this->contact_email->setupEditAttributes();
            $this->contact_email->EditCustomAttributes = "";
            if (!$this->contact_email->Raw) {
                $this->contact_email->CurrentValue = HtmlDecode($this->contact_email->CurrentValue);
            }
            $this->contact_email->EditValue = HtmlEncode($this->contact_email->CurrentValue);
            $this->contact_email->PlaceHolder = RemoveHtml($this->contact_email->caption());

            // contact_lineid
            $this->contact_lineid->setupEditAttributes();
            $this->contact_lineid->EditCustomAttributes = "";
            if (!$this->contact_lineid->Raw) {
                $this->contact_lineid->CurrentValue = HtmlDecode($this->contact_lineid->CurrentValue);
            }
            $this->contact_lineid->EditValue = HtmlEncode($this->contact_lineid->CurrentValue);
            $this->contact_lineid->PlaceHolder = RemoveHtml($this->contact_lineid->caption());

            // contact_phone
            $this->contact_phone->setupEditAttributes();
            $this->contact_phone->EditCustomAttributes = "";
            if (!$this->contact_phone->Raw) {
                $this->contact_phone->CurrentValue = HtmlDecode($this->contact_phone->CurrentValue);
            }
            $this->contact_phone->EditValue = HtmlEncode($this->contact_phone->CurrentValue);
            $this->contact_phone->PlaceHolder = RemoveHtml($this->contact_phone->caption());

            // file_idcard
            $this->file_idcard->setupEditAttributes();
            $this->file_idcard->EditCustomAttributes = "";
            $this->file_idcard->UploadPath = "/upload/";
            if (!EmptyValue($this->file_idcard->Upload->DbValue)) {
                $this->file_idcard->EditValue = $this->file_idcard->Upload->DbValue;
            } else {
                $this->file_idcard->EditValue = "";
            }
            if (!EmptyValue($this->file_idcard->CurrentValue)) {
                $this->file_idcard->Upload->FileName = $this->file_idcard->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->file_idcard);
            }

            // file_house_regis
            $this->file_house_regis->setupEditAttributes();
            $this->file_house_regis->EditCustomAttributes = "";
            $this->file_house_regis->UploadPath = "/upload/";
            if (!EmptyValue($this->file_house_regis->Upload->DbValue)) {
                $this->file_house_regis->EditValue = $this->file_house_regis->Upload->DbValue;
            } else {
                $this->file_house_regis->EditValue = "";
            }
            if (!EmptyValue($this->file_house_regis->CurrentValue)) {
                $this->file_house_regis->Upload->FileName = $this->file_house_regis->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->file_house_regis);
            }

            // file_titledeed
            $this->file_titledeed->setupEditAttributes();
            $this->file_titledeed->EditCustomAttributes = "";
            $this->file_titledeed->UploadPath = "/upload/";
            if (!EmptyValue($this->file_titledeed->Upload->DbValue)) {
                $this->file_titledeed->EditValue = $this->file_titledeed->Upload->DbValue;
            } else {
                $this->file_titledeed->EditValue = "";
            }
            if (!EmptyValue($this->file_titledeed->CurrentValue)) {
                $this->file_titledeed->Upload->FileName = $this->file_titledeed->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->file_titledeed);
            }

            // file_other
            $this->file_other->setupEditAttributes();
            $this->file_other->EditCustomAttributes = "";
            $this->file_other->UploadPath = "/upload/";
            if (!EmptyValue($this->file_other->Upload->DbValue)) {
                $this->file_other->EditValue = $this->file_other->Upload->DbValue;
            } else {
                $this->file_other->EditValue = "";
            }
            if (!EmptyValue($this->file_other->CurrentValue)) {
                $this->file_other->Upload->FileName = $this->file_other->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->file_other);
            }

            // attach_file
            $this->attach_file->setupEditAttributes();
            $this->attach_file->EditCustomAttributes = "";
            if (!$this->attach_file->Raw) {
                $this->attach_file->CurrentValue = HtmlDecode($this->attach_file->CurrentValue);
            }
            $this->attach_file->EditValue = HtmlEncode($this->attach_file->CurrentValue);
            $this->attach_file->PlaceHolder = RemoveHtml($this->attach_file->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // cdate

            // cuser

            // cip

            // udate

            // uuser

            // uip

            // doc_date

            // Add refer script

            // document_date
            $this->document_date->LinkCustomAttributes = "";
            $this->document_date->HrefValue = "";

            // years
            $this->years->LinkCustomAttributes = "";
            $this->years->HrefValue = "";

            // start_date
            $this->start_date->LinkCustomAttributes = "";
            $this->start_date->HrefValue = "";

            // end_date
            $this->end_date->LinkCustomAttributes = "";
            $this->end_date->HrefValue = "";

            // asset_code
            $this->asset_code->LinkCustomAttributes = "";
            $this->asset_code->HrefValue = "";

            // asset_project
            $this->asset_project->LinkCustomAttributes = "";
            $this->asset_project->HrefValue = "";

            // asset_deed
            $this->asset_deed->LinkCustomAttributes = "";
            $this->asset_deed->HrefValue = "";

            // asset_area
            $this->asset_area->LinkCustomAttributes = "";
            $this->asset_area->HrefValue = "";

            // appoint_agent_date
            $this->appoint_agent_date->LinkCustomAttributes = "";
            $this->appoint_agent_date->HrefValue = "";

            // buyer_name
            $this->buyer_name->LinkCustomAttributes = "";
            $this->buyer_name->HrefValue = "";

            // buyer_lname
            $this->buyer_lname->LinkCustomAttributes = "";
            $this->buyer_lname->HrefValue = "";

            // buyer_email
            $this->buyer_email->LinkCustomAttributes = "";
            $this->buyer_email->HrefValue = "";

            // buyer_idcard
            $this->buyer_idcard->LinkCustomAttributes = "";
            $this->buyer_idcard->HrefValue = "";

            // buyer_homeno
            $this->buyer_homeno->LinkCustomAttributes = "";
            $this->buyer_homeno->HrefValue = "";

            // buyer_witness_name
            $this->buyer_witness_name->LinkCustomAttributes = "";
            $this->buyer_witness_name->HrefValue = "";

            // buyer_witness_lname
            $this->buyer_witness_lname->LinkCustomAttributes = "";
            $this->buyer_witness_lname->HrefValue = "";

            // buyer_witness_email
            $this->buyer_witness_email->LinkCustomAttributes = "";
            $this->buyer_witness_email->HrefValue = "";

            // investor_name
            $this->investor_name->LinkCustomAttributes = "";
            $this->investor_name->HrefValue = "";

            // investor_lname
            $this->investor_lname->LinkCustomAttributes = "";
            $this->investor_lname->HrefValue = "";

            // investor_email
            $this->investor_email->LinkCustomAttributes = "";
            $this->investor_email->HrefValue = "";

            // juzmatch_authority_name
            $this->juzmatch_authority_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_name->HrefValue = "";

            // juzmatch_authority_lname
            $this->juzmatch_authority_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_lname->HrefValue = "";

            // juzmatch_authority_email
            $this->juzmatch_authority_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_email->HrefValue = "";

            // juzmatch_authority_witness_name
            $this->juzmatch_authority_witness_name->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_name->HrefValue = "";

            // juzmatch_authority_witness_lname
            $this->juzmatch_authority_witness_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_lname->HrefValue = "";

            // juzmatch_authority_witness_email
            $this->juzmatch_authority_witness_email->LinkCustomAttributes = "";
            $this->juzmatch_authority_witness_email->HrefValue = "";

            // juzmatch_authority2_name
            $this->juzmatch_authority2_name->LinkCustomAttributes = "";
            $this->juzmatch_authority2_name->HrefValue = "";

            // juzmatch_authority2_lname
            $this->juzmatch_authority2_lname->LinkCustomAttributes = "";
            $this->juzmatch_authority2_lname->HrefValue = "";

            // juzmatch_authority2_email
            $this->juzmatch_authority2_email->LinkCustomAttributes = "";
            $this->juzmatch_authority2_email->HrefValue = "";

            // company_seal_name
            $this->company_seal_name->LinkCustomAttributes = "";
            $this->company_seal_name->HrefValue = "";

            // company_seal_email
            $this->company_seal_email->LinkCustomAttributes = "";
            $this->company_seal_email->HrefValue = "";

            // total
            $this->total->LinkCustomAttributes = "";
            $this->total->HrefValue = "";

            // total_txt
            $this->total_txt->LinkCustomAttributes = "";
            $this->total_txt->HrefValue = "";

            // next_pay_date
            $this->next_pay_date->LinkCustomAttributes = "";
            $this->next_pay_date->HrefValue = "";

            // next_pay_date_txt
            $this->next_pay_date_txt->LinkCustomAttributes = "";
            $this->next_pay_date_txt->HrefValue = "";

            // service_price
            $this->service_price->LinkCustomAttributes = "";
            $this->service_price->HrefValue = "";

            // service_price_txt
            $this->service_price_txt->LinkCustomAttributes = "";
            $this->service_price_txt->HrefValue = "";

            // provide_service_date
            $this->provide_service_date->LinkCustomAttributes = "";
            $this->provide_service_date->HrefValue = "";

            // contact_address
            $this->contact_address->LinkCustomAttributes = "";
            $this->contact_address->HrefValue = "";

            // contact_address2
            $this->contact_address2->LinkCustomAttributes = "";
            $this->contact_address2->HrefValue = "";

            // contact_email
            $this->contact_email->LinkCustomAttributes = "";
            $this->contact_email->HrefValue = "";

            // contact_lineid
            $this->contact_lineid->LinkCustomAttributes = "";
            $this->contact_lineid->HrefValue = "";

            // contact_phone
            $this->contact_phone->LinkCustomAttributes = "";
            $this->contact_phone->HrefValue = "";

            // file_idcard
            $this->file_idcard->LinkCustomAttributes = "";
            $this->file_idcard->HrefValue = "";
            $this->file_idcard->ExportHrefValue = $this->file_idcard->UploadPath . $this->file_idcard->Upload->DbValue;

            // file_house_regis
            $this->file_house_regis->LinkCustomAttributes = "";
            $this->file_house_regis->HrefValue = "";
            $this->file_house_regis->ExportHrefValue = $this->file_house_regis->UploadPath . $this->file_house_regis->Upload->DbValue;

            // file_titledeed
            $this->file_titledeed->LinkCustomAttributes = "";
            $this->file_titledeed->HrefValue = "";
            $this->file_titledeed->ExportHrefValue = $this->file_titledeed->UploadPath . $this->file_titledeed->Upload->DbValue;

            // file_other
            $this->file_other->LinkCustomAttributes = "";
            $this->file_other->HrefValue = "";
            $this->file_other->ExportHrefValue = $this->file_other->UploadPath . $this->file_other->Upload->DbValue;

            // attach_file
            $this->attach_file->LinkCustomAttributes = "";
            $this->attach_file->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

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

            // doc_date
            $this->doc_date->LinkCustomAttributes = "";
            $this->doc_date->HrefValue = "";
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
        if ($this->document_date->Required) {
            if (!$this->document_date->IsDetailKey && EmptyValue($this->document_date->FormValue)) {
                $this->document_date->addErrorMessage(str_replace("%s", $this->document_date->caption(), $this->document_date->RequiredErrorMessage));
            }
        }
        if ($this->years->Required) {
            if (!$this->years->IsDetailKey && EmptyValue($this->years->FormValue)) {
                $this->years->addErrorMessage(str_replace("%s", $this->years->caption(), $this->years->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->years->FormValue)) {
            $this->years->addErrorMessage($this->years->getErrorMessage(false));
        }
        if ($this->start_date->Required) {
            if (!$this->start_date->IsDetailKey && EmptyValue($this->start_date->FormValue)) {
                $this->start_date->addErrorMessage(str_replace("%s", $this->start_date->caption(), $this->start_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->start_date->FormValue, $this->start_date->formatPattern())) {
            $this->start_date->addErrorMessage($this->start_date->getErrorMessage(false));
        }
        if ($this->end_date->Required) {
            if (!$this->end_date->IsDetailKey && EmptyValue($this->end_date->FormValue)) {
                $this->end_date->addErrorMessage(str_replace("%s", $this->end_date->caption(), $this->end_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->end_date->FormValue, $this->end_date->formatPattern())) {
            $this->end_date->addErrorMessage($this->end_date->getErrorMessage(false));
        }
        if ($this->asset_code->Required) {
            if (!$this->asset_code->IsDetailKey && EmptyValue($this->asset_code->FormValue)) {
                $this->asset_code->addErrorMessage(str_replace("%s", $this->asset_code->caption(), $this->asset_code->RequiredErrorMessage));
            }
        }
        if ($this->asset_project->Required) {
            if (!$this->asset_project->IsDetailKey && EmptyValue($this->asset_project->FormValue)) {
                $this->asset_project->addErrorMessage(str_replace("%s", $this->asset_project->caption(), $this->asset_project->RequiredErrorMessage));
            }
        }
        if ($this->asset_deed->Required) {
            if (!$this->asset_deed->IsDetailKey && EmptyValue($this->asset_deed->FormValue)) {
                $this->asset_deed->addErrorMessage(str_replace("%s", $this->asset_deed->caption(), $this->asset_deed->RequiredErrorMessage));
            }
        }
        if ($this->asset_area->Required) {
            if (!$this->asset_area->IsDetailKey && EmptyValue($this->asset_area->FormValue)) {
                $this->asset_area->addErrorMessage(str_replace("%s", $this->asset_area->caption(), $this->asset_area->RequiredErrorMessage));
            }
        }
        if ($this->appoint_agent_date->Required) {
            if (!$this->appoint_agent_date->IsDetailKey && EmptyValue($this->appoint_agent_date->FormValue)) {
                $this->appoint_agent_date->addErrorMessage(str_replace("%s", $this->appoint_agent_date->caption(), $this->appoint_agent_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->appoint_agent_date->FormValue, $this->appoint_agent_date->formatPattern())) {
            $this->appoint_agent_date->addErrorMessage($this->appoint_agent_date->getErrorMessage(false));
        }
        if ($this->buyer_name->Required) {
            if (!$this->buyer_name->IsDetailKey && EmptyValue($this->buyer_name->FormValue)) {
                $this->buyer_name->addErrorMessage(str_replace("%s", $this->buyer_name->caption(), $this->buyer_name->RequiredErrorMessage));
            }
        }
        if ($this->buyer_lname->Required) {
            if (!$this->buyer_lname->IsDetailKey && EmptyValue($this->buyer_lname->FormValue)) {
                $this->buyer_lname->addErrorMessage(str_replace("%s", $this->buyer_lname->caption(), $this->buyer_lname->RequiredErrorMessage));
            }
        }
        if ($this->buyer_email->Required) {
            if (!$this->buyer_email->IsDetailKey && EmptyValue($this->buyer_email->FormValue)) {
                $this->buyer_email->addErrorMessage(str_replace("%s", $this->buyer_email->caption(), $this->buyer_email->RequiredErrorMessage));
            }
        }
        if ($this->buyer_idcard->Required) {
            if (!$this->buyer_idcard->IsDetailKey && EmptyValue($this->buyer_idcard->FormValue)) {
                $this->buyer_idcard->addErrorMessage(str_replace("%s", $this->buyer_idcard->caption(), $this->buyer_idcard->RequiredErrorMessage));
            }
        }
        if ($this->buyer_homeno->Required) {
            if (!$this->buyer_homeno->IsDetailKey && EmptyValue($this->buyer_homeno->FormValue)) {
                $this->buyer_homeno->addErrorMessage(str_replace("%s", $this->buyer_homeno->caption(), $this->buyer_homeno->RequiredErrorMessage));
            }
        }
        if ($this->buyer_witness_name->Required) {
            if (!$this->buyer_witness_name->IsDetailKey && EmptyValue($this->buyer_witness_name->FormValue)) {
                $this->buyer_witness_name->addErrorMessage(str_replace("%s", $this->buyer_witness_name->caption(), $this->buyer_witness_name->RequiredErrorMessage));
            }
        }
        if ($this->buyer_witness_lname->Required) {
            if (!$this->buyer_witness_lname->IsDetailKey && EmptyValue($this->buyer_witness_lname->FormValue)) {
                $this->buyer_witness_lname->addErrorMessage(str_replace("%s", $this->buyer_witness_lname->caption(), $this->buyer_witness_lname->RequiredErrorMessage));
            }
        }
        if ($this->buyer_witness_email->Required) {
            if (!$this->buyer_witness_email->IsDetailKey && EmptyValue($this->buyer_witness_email->FormValue)) {
                $this->buyer_witness_email->addErrorMessage(str_replace("%s", $this->buyer_witness_email->caption(), $this->buyer_witness_email->RequiredErrorMessage));
            }
        }
        if ($this->investor_name->Required) {
            if (!$this->investor_name->IsDetailKey && EmptyValue($this->investor_name->FormValue)) {
                $this->investor_name->addErrorMessage(str_replace("%s", $this->investor_name->caption(), $this->investor_name->RequiredErrorMessage));
            }
        }
        if ($this->investor_lname->Required) {
            if (!$this->investor_lname->IsDetailKey && EmptyValue($this->investor_lname->FormValue)) {
                $this->investor_lname->addErrorMessage(str_replace("%s", $this->investor_lname->caption(), $this->investor_lname->RequiredErrorMessage));
            }
        }
        if ($this->investor_email->Required) {
            if (!$this->investor_email->IsDetailKey && EmptyValue($this->investor_email->FormValue)) {
                $this->investor_email->addErrorMessage(str_replace("%s", $this->investor_email->caption(), $this->investor_email->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_name->Required) {
            if (!$this->juzmatch_authority_name->IsDetailKey && EmptyValue($this->juzmatch_authority_name->FormValue)) {
                $this->juzmatch_authority_name->addErrorMessage(str_replace("%s", $this->juzmatch_authority_name->caption(), $this->juzmatch_authority_name->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_lname->Required) {
            if (!$this->juzmatch_authority_lname->IsDetailKey && EmptyValue($this->juzmatch_authority_lname->FormValue)) {
                $this->juzmatch_authority_lname->addErrorMessage(str_replace("%s", $this->juzmatch_authority_lname->caption(), $this->juzmatch_authority_lname->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_email->Required) {
            if (!$this->juzmatch_authority_email->IsDetailKey && EmptyValue($this->juzmatch_authority_email->FormValue)) {
                $this->juzmatch_authority_email->addErrorMessage(str_replace("%s", $this->juzmatch_authority_email->caption(), $this->juzmatch_authority_email->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_witness_name->Required) {
            if (!$this->juzmatch_authority_witness_name->IsDetailKey && EmptyValue($this->juzmatch_authority_witness_name->FormValue)) {
                $this->juzmatch_authority_witness_name->addErrorMessage(str_replace("%s", $this->juzmatch_authority_witness_name->caption(), $this->juzmatch_authority_witness_name->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_witness_lname->Required) {
            if (!$this->juzmatch_authority_witness_lname->IsDetailKey && EmptyValue($this->juzmatch_authority_witness_lname->FormValue)) {
                $this->juzmatch_authority_witness_lname->addErrorMessage(str_replace("%s", $this->juzmatch_authority_witness_lname->caption(), $this->juzmatch_authority_witness_lname->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority_witness_email->Required) {
            if (!$this->juzmatch_authority_witness_email->IsDetailKey && EmptyValue($this->juzmatch_authority_witness_email->FormValue)) {
                $this->juzmatch_authority_witness_email->addErrorMessage(str_replace("%s", $this->juzmatch_authority_witness_email->caption(), $this->juzmatch_authority_witness_email->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority2_name->Required) {
            if (!$this->juzmatch_authority2_name->IsDetailKey && EmptyValue($this->juzmatch_authority2_name->FormValue)) {
                $this->juzmatch_authority2_name->addErrorMessage(str_replace("%s", $this->juzmatch_authority2_name->caption(), $this->juzmatch_authority2_name->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority2_lname->Required) {
            if (!$this->juzmatch_authority2_lname->IsDetailKey && EmptyValue($this->juzmatch_authority2_lname->FormValue)) {
                $this->juzmatch_authority2_lname->addErrorMessage(str_replace("%s", $this->juzmatch_authority2_lname->caption(), $this->juzmatch_authority2_lname->RequiredErrorMessage));
            }
        }
        if ($this->juzmatch_authority2_email->Required) {
            if (!$this->juzmatch_authority2_email->IsDetailKey && EmptyValue($this->juzmatch_authority2_email->FormValue)) {
                $this->juzmatch_authority2_email->addErrorMessage(str_replace("%s", $this->juzmatch_authority2_email->caption(), $this->juzmatch_authority2_email->RequiredErrorMessage));
            }
        }
        if ($this->company_seal_name->Required) {
            if (!$this->company_seal_name->IsDetailKey && EmptyValue($this->company_seal_name->FormValue)) {
                $this->company_seal_name->addErrorMessage(str_replace("%s", $this->company_seal_name->caption(), $this->company_seal_name->RequiredErrorMessage));
            }
        }
        if ($this->company_seal_email->Required) {
            if (!$this->company_seal_email->IsDetailKey && EmptyValue($this->company_seal_email->FormValue)) {
                $this->company_seal_email->addErrorMessage(str_replace("%s", $this->company_seal_email->caption(), $this->company_seal_email->RequiredErrorMessage));
            }
        }
        if ($this->total->Required) {
            if (!$this->total->IsDetailKey && EmptyValue($this->total->FormValue)) {
                $this->total->addErrorMessage(str_replace("%s", $this->total->caption(), $this->total->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->total->FormValue)) {
            $this->total->addErrorMessage($this->total->getErrorMessage(false));
        }
        if ($this->total_txt->Required) {
            if (!$this->total_txt->IsDetailKey && EmptyValue($this->total_txt->FormValue)) {
                $this->total_txt->addErrorMessage(str_replace("%s", $this->total_txt->caption(), $this->total_txt->RequiredErrorMessage));
            }
        }
        if ($this->next_pay_date->Required) {
            if (!$this->next_pay_date->IsDetailKey && EmptyValue($this->next_pay_date->FormValue)) {
                $this->next_pay_date->addErrorMessage(str_replace("%s", $this->next_pay_date->caption(), $this->next_pay_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->next_pay_date->FormValue, $this->next_pay_date->formatPattern())) {
            $this->next_pay_date->addErrorMessage($this->next_pay_date->getErrorMessage(false));
        }
        if ($this->next_pay_date_txt->Required) {
            if (!$this->next_pay_date_txt->IsDetailKey && EmptyValue($this->next_pay_date_txt->FormValue)) {
                $this->next_pay_date_txt->addErrorMessage(str_replace("%s", $this->next_pay_date_txt->caption(), $this->next_pay_date_txt->RequiredErrorMessage));
            }
        }
        if ($this->service_price->Required) {
            if (!$this->service_price->IsDetailKey && EmptyValue($this->service_price->FormValue)) {
                $this->service_price->addErrorMessage(str_replace("%s", $this->service_price->caption(), $this->service_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->service_price->FormValue)) {
            $this->service_price->addErrorMessage($this->service_price->getErrorMessage(false));
        }
        if ($this->service_price_txt->Required) {
            if (!$this->service_price_txt->IsDetailKey && EmptyValue($this->service_price_txt->FormValue)) {
                $this->service_price_txt->addErrorMessage(str_replace("%s", $this->service_price_txt->caption(), $this->service_price_txt->RequiredErrorMessage));
            }
        }
        if ($this->provide_service_date->Required) {
            if (!$this->provide_service_date->IsDetailKey && EmptyValue($this->provide_service_date->FormValue)) {
                $this->provide_service_date->addErrorMessage(str_replace("%s", $this->provide_service_date->caption(), $this->provide_service_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->provide_service_date->FormValue, $this->provide_service_date->formatPattern())) {
            $this->provide_service_date->addErrorMessage($this->provide_service_date->getErrorMessage(false));
        }
        if ($this->contact_address->Required) {
            if (!$this->contact_address->IsDetailKey && EmptyValue($this->contact_address->FormValue)) {
                $this->contact_address->addErrorMessage(str_replace("%s", $this->contact_address->caption(), $this->contact_address->RequiredErrorMessage));
            }
        }
        if ($this->contact_address2->Required) {
            if (!$this->contact_address2->IsDetailKey && EmptyValue($this->contact_address2->FormValue)) {
                $this->contact_address2->addErrorMessage(str_replace("%s", $this->contact_address2->caption(), $this->contact_address2->RequiredErrorMessage));
            }
        }
        if ($this->contact_email->Required) {
            if (!$this->contact_email->IsDetailKey && EmptyValue($this->contact_email->FormValue)) {
                $this->contact_email->addErrorMessage(str_replace("%s", $this->contact_email->caption(), $this->contact_email->RequiredErrorMessage));
            }
        }
        if ($this->contact_lineid->Required) {
            if (!$this->contact_lineid->IsDetailKey && EmptyValue($this->contact_lineid->FormValue)) {
                $this->contact_lineid->addErrorMessage(str_replace("%s", $this->contact_lineid->caption(), $this->contact_lineid->RequiredErrorMessage));
            }
        }
        if ($this->contact_phone->Required) {
            if (!$this->contact_phone->IsDetailKey && EmptyValue($this->contact_phone->FormValue)) {
                $this->contact_phone->addErrorMessage(str_replace("%s", $this->contact_phone->caption(), $this->contact_phone->RequiredErrorMessage));
            }
        }
        if ($this->file_idcard->Required) {
            if ($this->file_idcard->Upload->FileName == "" && !$this->file_idcard->Upload->KeepFile) {
                $this->file_idcard->addErrorMessage(str_replace("%s", $this->file_idcard->caption(), $this->file_idcard->RequiredErrorMessage));
            }
        }
        if ($this->file_house_regis->Required) {
            if ($this->file_house_regis->Upload->FileName == "" && !$this->file_house_regis->Upload->KeepFile) {
                $this->file_house_regis->addErrorMessage(str_replace("%s", $this->file_house_regis->caption(), $this->file_house_regis->RequiredErrorMessage));
            }
        }
        if ($this->file_titledeed->Required) {
            if ($this->file_titledeed->Upload->FileName == "" && !$this->file_titledeed->Upload->KeepFile) {
                $this->file_titledeed->addErrorMessage(str_replace("%s", $this->file_titledeed->caption(), $this->file_titledeed->RequiredErrorMessage));
            }
        }
        if ($this->file_other->Required) {
            if ($this->file_other->Upload->FileName == "" && !$this->file_other->Upload->KeepFile) {
                $this->file_other->addErrorMessage(str_replace("%s", $this->file_other->caption(), $this->file_other->RequiredErrorMessage));
            }
        }
        if ($this->attach_file->Required) {
            if (!$this->attach_file->IsDetailKey && EmptyValue($this->attach_file->FormValue)) {
                $this->attach_file->addErrorMessage(str_replace("%s", $this->attach_file->caption(), $this->attach_file->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
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
        if ($this->doc_date->Required) {
            if (!$this->doc_date->IsDetailKey && EmptyValue($this->doc_date->FormValue)) {
                $this->doc_date->addErrorMessage(str_replace("%s", $this->doc_date->caption(), $this->doc_date->RequiredErrorMessage));
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

        // Check referential integrity for master table 'doc_juzmatch3'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["buyer_booking_asset_id"] = $this->buyer_booking_asset_id->getSessionValue();
        $masterTable = Container("buyer_all_booking_asset");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "buyer_all_booking_asset", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->file_idcard->OldUploadPath = "/upload/";
            $this->file_idcard->UploadPath = $this->file_idcard->OldUploadPath;
            $this->file_house_regis->OldUploadPath = "/upload/";
            $this->file_house_regis->UploadPath = $this->file_house_regis->OldUploadPath;
            $this->file_titledeed->OldUploadPath = "/upload/";
            $this->file_titledeed->UploadPath = $this->file_titledeed->OldUploadPath;
            $this->file_other->OldUploadPath = "/upload/";
            $this->file_other->UploadPath = $this->file_other->OldUploadPath;
        }
        $rsnew = [];

        // document_date
        $this->document_date->CurrentValue = CurrentDateTime();
        $this->document_date->setDbValueDef($rsnew, $this->document_date->CurrentValue, null);

        // years
        $this->years->setDbValueDef($rsnew, $this->years->CurrentValue, null, false);

        // start_date
        $this->start_date->setDbValueDef($rsnew, UnFormatDateTime($this->start_date->CurrentValue, $this->start_date->formatPattern()), null, false);

        // end_date
        $this->end_date->setDbValueDef($rsnew, UnFormatDateTime($this->end_date->CurrentValue, $this->end_date->formatPattern()), null, false);

        // asset_code
        $this->asset_code->setDbValueDef($rsnew, $this->asset_code->CurrentValue, null, false);

        // asset_project
        $this->asset_project->setDbValueDef($rsnew, $this->asset_project->CurrentValue, null, false);

        // asset_deed
        $this->asset_deed->setDbValueDef($rsnew, $this->asset_deed->CurrentValue, null, false);

        // asset_area
        $this->asset_area->setDbValueDef($rsnew, $this->asset_area->CurrentValue, null, false);

        // appoint_agent_date
        $this->appoint_agent_date->setDbValueDef($rsnew, UnFormatDateTime($this->appoint_agent_date->CurrentValue, $this->appoint_agent_date->formatPattern()), null, false);

        // buyer_name
        $this->buyer_name->setDbValueDef($rsnew, $this->buyer_name->CurrentValue, null, false);

        // buyer_lname
        $this->buyer_lname->setDbValueDef($rsnew, $this->buyer_lname->CurrentValue, null, false);

        // buyer_email
        $this->buyer_email->setDbValueDef($rsnew, $this->buyer_email->CurrentValue, null, false);

        // buyer_idcard
        $this->buyer_idcard->setDbValueDef($rsnew, $this->buyer_idcard->CurrentValue, null, false);

        // buyer_homeno
        $this->buyer_homeno->setDbValueDef($rsnew, $this->buyer_homeno->CurrentValue, null, false);

        // buyer_witness_name
        $this->buyer_witness_name->setDbValueDef($rsnew, $this->buyer_witness_name->CurrentValue, null, false);

        // buyer_witness_lname
        $this->buyer_witness_lname->setDbValueDef($rsnew, $this->buyer_witness_lname->CurrentValue, null, false);

        // buyer_witness_email
        $this->buyer_witness_email->setDbValueDef($rsnew, $this->buyer_witness_email->CurrentValue, null, false);

        // investor_name
        $this->investor_name->setDbValueDef($rsnew, $this->investor_name->CurrentValue, null, false);

        // investor_lname
        $this->investor_lname->setDbValueDef($rsnew, $this->investor_lname->CurrentValue, null, false);

        // investor_email
        $this->investor_email->setDbValueDef($rsnew, $this->investor_email->CurrentValue, null, false);

        // juzmatch_authority_name
        $this->juzmatch_authority_name->setDbValueDef($rsnew, $this->juzmatch_authority_name->CurrentValue, null, false);

        // juzmatch_authority_lname
        $this->juzmatch_authority_lname->setDbValueDef($rsnew, $this->juzmatch_authority_lname->CurrentValue, null, false);

        // juzmatch_authority_email
        $this->juzmatch_authority_email->setDbValueDef($rsnew, $this->juzmatch_authority_email->CurrentValue, null, false);

        // juzmatch_authority_witness_name
        $this->juzmatch_authority_witness_name->setDbValueDef($rsnew, $this->juzmatch_authority_witness_name->CurrentValue, null, false);

        // juzmatch_authority_witness_lname
        $this->juzmatch_authority_witness_lname->setDbValueDef($rsnew, $this->juzmatch_authority_witness_lname->CurrentValue, null, false);

        // juzmatch_authority_witness_email
        $this->juzmatch_authority_witness_email->setDbValueDef($rsnew, $this->juzmatch_authority_witness_email->CurrentValue, null, false);

        // juzmatch_authority2_name
        $this->juzmatch_authority2_name->setDbValueDef($rsnew, $this->juzmatch_authority2_name->CurrentValue, null, false);

        // juzmatch_authority2_lname
        $this->juzmatch_authority2_lname->setDbValueDef($rsnew, $this->juzmatch_authority2_lname->CurrentValue, null, false);

        // juzmatch_authority2_email
        $this->juzmatch_authority2_email->setDbValueDef($rsnew, $this->juzmatch_authority2_email->CurrentValue, null, false);

        // company_seal_name
        $this->company_seal_name->setDbValueDef($rsnew, $this->company_seal_name->CurrentValue, null, false);

        // company_seal_email
        $this->company_seal_email->setDbValueDef($rsnew, $this->company_seal_email->CurrentValue, null, false);

        // total
        $this->total->setDbValueDef($rsnew, $this->total->CurrentValue, null, false);

        // total_txt
        $this->total_txt->setDbValueDef($rsnew, $this->total_txt->CurrentValue, null, false);

        // next_pay_date
        $this->next_pay_date->setDbValueDef($rsnew, UnFormatDateTime($this->next_pay_date->CurrentValue, $this->next_pay_date->formatPattern()), null, false);

        // next_pay_date_txt
        $this->next_pay_date_txt->setDbValueDef($rsnew, $this->next_pay_date_txt->CurrentValue, null, false);

        // service_price
        $this->service_price->setDbValueDef($rsnew, $this->service_price->CurrentValue, null, false);

        // service_price_txt
        $this->service_price_txt->setDbValueDef($rsnew, $this->service_price_txt->CurrentValue, null, false);

        // provide_service_date
        $this->provide_service_date->setDbValueDef($rsnew, UnFormatDateTime($this->provide_service_date->CurrentValue, $this->provide_service_date->formatPattern()), null, false);

        // contact_address
        $this->contact_address->setDbValueDef($rsnew, $this->contact_address->CurrentValue, null, false);

        // contact_address2
        $this->contact_address2->setDbValueDef($rsnew, $this->contact_address2->CurrentValue, null, false);

        // contact_email
        $this->contact_email->setDbValueDef($rsnew, $this->contact_email->CurrentValue, null, false);

        // contact_lineid
        $this->contact_lineid->setDbValueDef($rsnew, $this->contact_lineid->CurrentValue, null, false);

        // contact_phone
        $this->contact_phone->setDbValueDef($rsnew, $this->contact_phone->CurrentValue, null, false);

        // file_idcard
        if ($this->file_idcard->Visible && !$this->file_idcard->Upload->KeepFile) {
            $this->file_idcard->Upload->DbValue = ""; // No need to delete old file
            if ($this->file_idcard->Upload->FileName == "") {
                $rsnew['file_idcard'] = null;
            } else {
                $rsnew['file_idcard'] = $this->file_idcard->Upload->FileName;
            }
        }

        // file_house_regis
        if ($this->file_house_regis->Visible && !$this->file_house_regis->Upload->KeepFile) {
            $this->file_house_regis->Upload->DbValue = ""; // No need to delete old file
            if ($this->file_house_regis->Upload->FileName == "") {
                $rsnew['file_house_regis'] = null;
            } else {
                $rsnew['file_house_regis'] = $this->file_house_regis->Upload->FileName;
            }
        }

        // file_titledeed
        if ($this->file_titledeed->Visible && !$this->file_titledeed->Upload->KeepFile) {
            $this->file_titledeed->Upload->DbValue = ""; // No need to delete old file
            if ($this->file_titledeed->Upload->FileName == "") {
                $rsnew['file_titledeed'] = null;
            } else {
                $rsnew['file_titledeed'] = $this->file_titledeed->Upload->FileName;
            }
        }

        // file_other
        if ($this->file_other->Visible && !$this->file_other->Upload->KeepFile) {
            $this->file_other->Upload->DbValue = ""; // No need to delete old file
            if ($this->file_other->Upload->FileName == "") {
                $rsnew['file_other'] = null;
            } else {
                $rsnew['file_other'] = $this->file_other->Upload->FileName;
            }
        }

        // attach_file
        $this->attach_file->setDbValueDef($rsnew, $this->attach_file->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

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

        // doc_date
        $this->doc_date->CurrentValue = CurrentDateTime();
        $this->doc_date->setDbValueDef($rsnew, $this->doc_date->CurrentValue, null);

        // buyer_booking_asset_id
        if ($this->buyer_booking_asset_id->getSessionValue() != "") {
            $rsnew['buyer_booking_asset_id'] = $this->buyer_booking_asset_id->getSessionValue();
        }
        if ($this->file_idcard->Visible && !$this->file_idcard->Upload->KeepFile) {
            $this->file_idcard->UploadPath = "/upload/";
            $oldFiles = EmptyValue($this->file_idcard->Upload->DbValue) ? [] : [$this->file_idcard->htmlDecode($this->file_idcard->Upload->DbValue)];
            if (!EmptyValue($this->file_idcard->Upload->FileName)) {
                $newFiles = [$this->file_idcard->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->file_idcard, $this->file_idcard->Upload->Index);
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
                            $file1 = UniqueFilename($this->file_idcard->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->file_idcard->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->file_idcard->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->file_idcard->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->file_idcard->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->file_idcard->setDbValueDef($rsnew, $this->file_idcard->Upload->FileName, null, false);
            }
        }
        if ($this->file_house_regis->Visible && !$this->file_house_regis->Upload->KeepFile) {
            $this->file_house_regis->UploadPath = "/upload/";
            $oldFiles = EmptyValue($this->file_house_regis->Upload->DbValue) ? [] : [$this->file_house_regis->htmlDecode($this->file_house_regis->Upload->DbValue)];
            if (!EmptyValue($this->file_house_regis->Upload->FileName)) {
                $newFiles = [$this->file_house_regis->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->file_house_regis, $this->file_house_regis->Upload->Index);
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
                            $file1 = UniqueFilename($this->file_house_regis->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->file_house_regis->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->file_house_regis->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->file_house_regis->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->file_house_regis->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->file_house_regis->setDbValueDef($rsnew, $this->file_house_regis->Upload->FileName, null, false);
            }
        }
        if ($this->file_titledeed->Visible && !$this->file_titledeed->Upload->KeepFile) {
            $this->file_titledeed->UploadPath = "/upload/";
            $oldFiles = EmptyValue($this->file_titledeed->Upload->DbValue) ? [] : [$this->file_titledeed->htmlDecode($this->file_titledeed->Upload->DbValue)];
            if (!EmptyValue($this->file_titledeed->Upload->FileName)) {
                $newFiles = [$this->file_titledeed->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->file_titledeed, $this->file_titledeed->Upload->Index);
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
                            $file1 = UniqueFilename($this->file_titledeed->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->file_titledeed->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->file_titledeed->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->file_titledeed->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->file_titledeed->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->file_titledeed->setDbValueDef($rsnew, $this->file_titledeed->Upload->FileName, null, false);
            }
        }
        if ($this->file_other->Visible && !$this->file_other->Upload->KeepFile) {
            $this->file_other->UploadPath = "/upload/";
            $oldFiles = EmptyValue($this->file_other->Upload->DbValue) ? [] : [$this->file_other->htmlDecode($this->file_other->Upload->DbValue)];
            if (!EmptyValue($this->file_other->Upload->FileName)) {
                $newFiles = [$this->file_other->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->file_other, $this->file_other->Upload->Index);
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
                            $file1 = UniqueFilename($this->file_other->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->file_other->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->file_other->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->file_other->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->file_other->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->file_other->setDbValueDef($rsnew, $this->file_other->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->file_idcard->Visible && !$this->file_idcard->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->file_idcard->Upload->DbValue) ? [] : [$this->file_idcard->htmlDecode($this->file_idcard->Upload->DbValue)];
                    if (!EmptyValue($this->file_idcard->Upload->FileName)) {
                        $newFiles = [$this->file_idcard->Upload->FileName];
                        $newFiles2 = [$this->file_idcard->htmlDecode($rsnew['file_idcard'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->file_idcard, $this->file_idcard->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->file_idcard->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->file_idcard->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->file_house_regis->Visible && !$this->file_house_regis->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->file_house_regis->Upload->DbValue) ? [] : [$this->file_house_regis->htmlDecode($this->file_house_regis->Upload->DbValue)];
                    if (!EmptyValue($this->file_house_regis->Upload->FileName)) {
                        $newFiles = [$this->file_house_regis->Upload->FileName];
                        $newFiles2 = [$this->file_house_regis->htmlDecode($rsnew['file_house_regis'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->file_house_regis, $this->file_house_regis->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->file_house_regis->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->file_house_regis->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->file_titledeed->Visible && !$this->file_titledeed->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->file_titledeed->Upload->DbValue) ? [] : [$this->file_titledeed->htmlDecode($this->file_titledeed->Upload->DbValue)];
                    if (!EmptyValue($this->file_titledeed->Upload->FileName)) {
                        $newFiles = [$this->file_titledeed->Upload->FileName];
                        $newFiles2 = [$this->file_titledeed->htmlDecode($rsnew['file_titledeed'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->file_titledeed, $this->file_titledeed->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->file_titledeed->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->file_titledeed->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->file_other->Visible && !$this->file_other->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->file_other->Upload->DbValue) ? [] : [$this->file_other->htmlDecode($this->file_other->Upload->DbValue)];
                    if (!EmptyValue($this->file_other->Upload->FileName)) {
                        $newFiles = [$this->file_other->Upload->FileName];
                        $newFiles2 = [$this->file_other->htmlDecode($rsnew['file_other'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->file_other, $this->file_other->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->file_other->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->file_other->oldPhysicalUploadPath() . $oldFile);
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
            // file_idcard
            CleanUploadTempPath($this->file_idcard, $this->file_idcard->Upload->Index);

            // file_house_regis
            CleanUploadTempPath($this->file_house_regis, $this->file_house_regis->Upload->Index);

            // file_titledeed
            CleanUploadTempPath($this->file_titledeed, $this->file_titledeed->Upload->Index);

            // file_other
            CleanUploadTempPath($this->file_other, $this->file_other->Upload->Index);
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
            if ($masterTblVar == "buyer_all_booking_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_all_booking_asset");
                if (($parm = Get("fk_buyer_booking_asset_id", Get("buyer_booking_asset_id"))) !== null) {
                    $masterTbl->buyer_booking_asset_id->setQueryStringValue($parm);
                    $this->buyer_booking_asset_id->setQueryStringValue($masterTbl->buyer_booking_asset_id->QueryStringValue);
                    $this->buyer_booking_asset_id->setSessionValue($this->buyer_booking_asset_id->QueryStringValue);
                    if (!is_numeric($masterTbl->buyer_booking_asset_id->QueryStringValue)) {
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
            if ($masterTblVar == "buyer_all_booking_asset") {
                $validMaster = true;
                $masterTbl = Container("buyer_all_booking_asset");
                if (($parm = Post("fk_buyer_booking_asset_id", Post("buyer_booking_asset_id"))) !== null) {
                    $masterTbl->buyer_booking_asset_id->setFormValue($parm);
                    $this->buyer_booking_asset_id->setFormValue($masterTbl->buyer_booking_asset_id->FormValue);
                    $this->buyer_booking_asset_id->setSessionValue($this->buyer_booking_asset_id->FormValue);
                    if (!is_numeric($masterTbl->buyer_booking_asset_id->FormValue)) {
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
            if ($masterTblVar != "buyer_all_booking_asset") {
                if ($this->buyer_booking_asset_id->CurrentValue == "") {
                    $this->buyer_booking_asset_id->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("docjuzmatch3list"), "", $this->TableVar, true);
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
                case "x_status":
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
