<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DocCredenSignerEdit extends DocCredenSigner
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'doc_creden_signer';

    // Page object name
    public $PageObjName = "DocCredenSignerEdit";

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

        // Table object (doc_creden_signer)
        if (!isset($GLOBALS["doc_creden_signer"]) || get_class($GLOBALS["doc_creden_signer"]) == PROJECT_NAMESPACE . "doc_creden_signer") {
            $GLOBALS["doc_creden_signer"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'doc_creden_signer');
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
                $tbl = Container("doc_creden_signer");
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
                    if ($pageName == "doccredensignerview") {
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
            $key .= @$ar['doc_creden_signer_id'];
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
            $this->doc_creden_signer_id->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->doc_creden_signer_id->setVisibility();
        $this->doc_creden_id->setVisibility();
        $this->doc_creden_signer_no->setVisibility();
        $this->doc_creden_signer_link->setVisibility();
        $this->doc_creden_signer_session->setVisibility();
        $this->doc_creden_signer_name->setVisibility();
        $this->doc_creden_signer_email->setVisibility();
        $this->status->setVisibility();
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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("doc_creden_signer_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->doc_creden_signer_id->setQueryStringValue($keyValue);
                $this->doc_creden_signer_id->setOldValue($this->doc_creden_signer_id->QueryStringValue);
            } elseif (Post("doc_creden_signer_id") !== null) {
                $this->doc_creden_signer_id->setFormValue(Post("doc_creden_signer_id"));
                $this->doc_creden_signer_id->setOldValue($this->doc_creden_signer_id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("doc_creden_signer_id") ?? Route("doc_creden_signer_id")) !== null) {
                    $this->doc_creden_signer_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->doc_creden_signer_id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("doccredensignerlist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "doccredensignerlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'doc_creden_signer_id' first before field var 'x_doc_creden_signer_id'
        $val = $CurrentForm->hasValue("doc_creden_signer_id") ? $CurrentForm->getValue("doc_creden_signer_id") : $CurrentForm->getValue("x_doc_creden_signer_id");
        if (!$this->doc_creden_signer_id->IsDetailKey) {
            $this->doc_creden_signer_id->setFormValue($val);
        }

        // Check field name 'doc_creden_id' first before field var 'x_doc_creden_id'
        $val = $CurrentForm->hasValue("doc_creden_id") ? $CurrentForm->getValue("doc_creden_id") : $CurrentForm->getValue("x_doc_creden_id");
        if (!$this->doc_creden_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_creden_id->Visible = false; // Disable update for API request
            } else {
                $this->doc_creden_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'doc_creden_signer_no' first before field var 'x_doc_creden_signer_no'
        $val = $CurrentForm->hasValue("doc_creden_signer_no") ? $CurrentForm->getValue("doc_creden_signer_no") : $CurrentForm->getValue("x_doc_creden_signer_no");
        if (!$this->doc_creden_signer_no->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_creden_signer_no->Visible = false; // Disable update for API request
            } else {
                $this->doc_creden_signer_no->setFormValue($val);
            }
        }

        // Check field name 'doc_creden_signer_link' first before field var 'x_doc_creden_signer_link'
        $val = $CurrentForm->hasValue("doc_creden_signer_link") ? $CurrentForm->getValue("doc_creden_signer_link") : $CurrentForm->getValue("x_doc_creden_signer_link");
        if (!$this->doc_creden_signer_link->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_creden_signer_link->Visible = false; // Disable update for API request
            } else {
                $this->doc_creden_signer_link->setFormValue($val);
            }
        }

        // Check field name 'doc_creden_signer_session' first before field var 'x_doc_creden_signer_session'
        $val = $CurrentForm->hasValue("doc_creden_signer_session") ? $CurrentForm->getValue("doc_creden_signer_session") : $CurrentForm->getValue("x_doc_creden_signer_session");
        if (!$this->doc_creden_signer_session->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_creden_signer_session->Visible = false; // Disable update for API request
            } else {
                $this->doc_creden_signer_session->setFormValue($val);
            }
        }

        // Check field name 'doc_creden_signer_name' first before field var 'x_doc_creden_signer_name'
        $val = $CurrentForm->hasValue("doc_creden_signer_name") ? $CurrentForm->getValue("doc_creden_signer_name") : $CurrentForm->getValue("x_doc_creden_signer_name");
        if (!$this->doc_creden_signer_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_creden_signer_name->Visible = false; // Disable update for API request
            } else {
                $this->doc_creden_signer_name->setFormValue($val);
            }
        }

        // Check field name 'doc_creden_signer_email' first before field var 'x_doc_creden_signer_email'
        $val = $CurrentForm->hasValue("doc_creden_signer_email") ? $CurrentForm->getValue("doc_creden_signer_email") : $CurrentForm->getValue("x_doc_creden_signer_email");
        if (!$this->doc_creden_signer_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->doc_creden_signer_email->Visible = false; // Disable update for API request
            } else {
                $this->doc_creden_signer_email->setFormValue($val);
            }
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'cdate' first before field var 'x_cdate'
        $val = $CurrentForm->hasValue("cdate") ? $CurrentForm->getValue("cdate") : $CurrentForm->getValue("x_cdate");
        if (!$this->cdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cdate->Visible = false; // Disable update for API request
            } else {
                $this->cdate->setFormValue($val, true, $validate);
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
                $this->udate->setFormValue($val, true, $validate);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->doc_creden_signer_id->CurrentValue = $this->doc_creden_signer_id->FormValue;
        $this->doc_creden_id->CurrentValue = $this->doc_creden_id->FormValue;
        $this->doc_creden_signer_no->CurrentValue = $this->doc_creden_signer_no->FormValue;
        $this->doc_creden_signer_link->CurrentValue = $this->doc_creden_signer_link->FormValue;
        $this->doc_creden_signer_session->CurrentValue = $this->doc_creden_signer_session->FormValue;
        $this->doc_creden_signer_name->CurrentValue = $this->doc_creden_signer_name->FormValue;
        $this->doc_creden_signer_email->CurrentValue = $this->doc_creden_signer_email->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
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
        $this->doc_creden_signer_id->setDbValue($row['doc_creden_signer_id']);
        $this->doc_creden_id->setDbValue($row['doc_creden_id']);
        $this->doc_creden_signer_no->setDbValue($row['doc_creden_signer_no']);
        $this->doc_creden_signer_link->setDbValue($row['doc_creden_signer_link']);
        $this->doc_creden_signer_session->setDbValue($row['doc_creden_signer_session']);
        $this->doc_creden_signer_name->setDbValue($row['doc_creden_signer_name']);
        $this->doc_creden_signer_email->setDbValue($row['doc_creden_signer_email']);
        $this->status->setDbValue($row['status']);
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
        $row = [];
        $row['doc_creden_signer_id'] = null;
        $row['doc_creden_id'] = null;
        $row['doc_creden_signer_no'] = null;
        $row['doc_creden_signer_link'] = null;
        $row['doc_creden_signer_session'] = null;
        $row['doc_creden_signer_name'] = null;
        $row['doc_creden_signer_email'] = null;
        $row['status'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['cip'] = null;
        $row['udate'] = null;
        $row['uuser'] = null;
        $row['uip'] = null;
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

        // doc_creden_signer_id
        $this->doc_creden_signer_id->RowCssClass = "row";

        // doc_creden_id
        $this->doc_creden_id->RowCssClass = "row";

        // doc_creden_signer_no
        $this->doc_creden_signer_no->RowCssClass = "row";

        // doc_creden_signer_link
        $this->doc_creden_signer_link->RowCssClass = "row";

        // doc_creden_signer_session
        $this->doc_creden_signer_session->RowCssClass = "row";

        // doc_creden_signer_name
        $this->doc_creden_signer_name->RowCssClass = "row";

        // doc_creden_signer_email
        $this->doc_creden_signer_email->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

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
            // doc_creden_signer_id
            $this->doc_creden_signer_id->ViewValue = $this->doc_creden_signer_id->CurrentValue;
            $this->doc_creden_signer_id->ViewCustomAttributes = "";

            // doc_creden_id
            $this->doc_creden_id->ViewValue = $this->doc_creden_id->CurrentValue;
            $this->doc_creden_id->ViewValue = FormatNumber($this->doc_creden_id->ViewValue, $this->doc_creden_id->formatPattern());
            $this->doc_creden_id->ViewCustomAttributes = "";

            // doc_creden_signer_no
            $this->doc_creden_signer_no->ViewValue = $this->doc_creden_signer_no->CurrentValue;
            $this->doc_creden_signer_no->ViewCustomAttributes = "";

            // doc_creden_signer_link
            $this->doc_creden_signer_link->ViewValue = $this->doc_creden_signer_link->CurrentValue;
            $this->doc_creden_signer_link->ViewCustomAttributes = "";

            // doc_creden_signer_session
            $this->doc_creden_signer_session->ViewValue = $this->doc_creden_signer_session->CurrentValue;
            $this->doc_creden_signer_session->ViewCustomAttributes = "";

            // doc_creden_signer_name
            $this->doc_creden_signer_name->ViewValue = $this->doc_creden_signer_name->CurrentValue;
            $this->doc_creden_signer_name->ViewCustomAttributes = "";

            // doc_creden_signer_email
            $this->doc_creden_signer_email->ViewValue = $this->doc_creden_signer_email->CurrentValue;
            $this->doc_creden_signer_email->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewValue = FormatNumber($this->status->ViewValue, $this->status->formatPattern());
            $this->status->ViewCustomAttributes = "";

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

            // doc_creden_signer_id
            $this->doc_creden_signer_id->LinkCustomAttributes = "";
            $this->doc_creden_signer_id->HrefValue = "";

            // doc_creden_id
            $this->doc_creden_id->LinkCustomAttributes = "";
            $this->doc_creden_id->HrefValue = "";

            // doc_creden_signer_no
            $this->doc_creden_signer_no->LinkCustomAttributes = "";
            $this->doc_creden_signer_no->HrefValue = "";

            // doc_creden_signer_link
            $this->doc_creden_signer_link->LinkCustomAttributes = "";
            $this->doc_creden_signer_link->HrefValue = "";

            // doc_creden_signer_session
            $this->doc_creden_signer_session->LinkCustomAttributes = "";
            $this->doc_creden_signer_session->HrefValue = "";

            // doc_creden_signer_name
            $this->doc_creden_signer_name->LinkCustomAttributes = "";
            $this->doc_creden_signer_name->HrefValue = "";

            // doc_creden_signer_email
            $this->doc_creden_signer_email->LinkCustomAttributes = "";
            $this->doc_creden_signer_email->HrefValue = "";

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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // doc_creden_signer_id
            $this->doc_creden_signer_id->setupEditAttributes();
            $this->doc_creden_signer_id->EditCustomAttributes = "";
            $this->doc_creden_signer_id->EditValue = $this->doc_creden_signer_id->CurrentValue;
            $this->doc_creden_signer_id->ViewCustomAttributes = "";

            // doc_creden_id
            $this->doc_creden_id->setupEditAttributes();
            $this->doc_creden_id->EditCustomAttributes = "";
            $this->doc_creden_id->EditValue = HtmlEncode($this->doc_creden_id->CurrentValue);
            $this->doc_creden_id->PlaceHolder = RemoveHtml($this->doc_creden_id->caption());
            if (strval($this->doc_creden_id->EditValue) != "" && is_numeric($this->doc_creden_id->EditValue)) {
                $this->doc_creden_id->EditValue = FormatNumber($this->doc_creden_id->EditValue, null);
            }

            // doc_creden_signer_no
            $this->doc_creden_signer_no->setupEditAttributes();
            $this->doc_creden_signer_no->EditCustomAttributes = "";
            if (!$this->doc_creden_signer_no->Raw) {
                $this->doc_creden_signer_no->CurrentValue = HtmlDecode($this->doc_creden_signer_no->CurrentValue);
            }
            $this->doc_creden_signer_no->EditValue = HtmlEncode($this->doc_creden_signer_no->CurrentValue);
            $this->doc_creden_signer_no->PlaceHolder = RemoveHtml($this->doc_creden_signer_no->caption());

            // doc_creden_signer_link
            $this->doc_creden_signer_link->setupEditAttributes();
            $this->doc_creden_signer_link->EditCustomAttributes = "";
            if (!$this->doc_creden_signer_link->Raw) {
                $this->doc_creden_signer_link->CurrentValue = HtmlDecode($this->doc_creden_signer_link->CurrentValue);
            }
            $this->doc_creden_signer_link->EditValue = HtmlEncode($this->doc_creden_signer_link->CurrentValue);
            $this->doc_creden_signer_link->PlaceHolder = RemoveHtml($this->doc_creden_signer_link->caption());

            // doc_creden_signer_session
            $this->doc_creden_signer_session->setupEditAttributes();
            $this->doc_creden_signer_session->EditCustomAttributes = "";
            if (!$this->doc_creden_signer_session->Raw) {
                $this->doc_creden_signer_session->CurrentValue = HtmlDecode($this->doc_creden_signer_session->CurrentValue);
            }
            $this->doc_creden_signer_session->EditValue = HtmlEncode($this->doc_creden_signer_session->CurrentValue);
            $this->doc_creden_signer_session->PlaceHolder = RemoveHtml($this->doc_creden_signer_session->caption());

            // doc_creden_signer_name
            $this->doc_creden_signer_name->setupEditAttributes();
            $this->doc_creden_signer_name->EditCustomAttributes = "";
            if (!$this->doc_creden_signer_name->Raw) {
                $this->doc_creden_signer_name->CurrentValue = HtmlDecode($this->doc_creden_signer_name->CurrentValue);
            }
            $this->doc_creden_signer_name->EditValue = HtmlEncode($this->doc_creden_signer_name->CurrentValue);
            $this->doc_creden_signer_name->PlaceHolder = RemoveHtml($this->doc_creden_signer_name->caption());

            // doc_creden_signer_email
            $this->doc_creden_signer_email->setupEditAttributes();
            $this->doc_creden_signer_email->EditCustomAttributes = "";
            if (!$this->doc_creden_signer_email->Raw) {
                $this->doc_creden_signer_email->CurrentValue = HtmlDecode($this->doc_creden_signer_email->CurrentValue);
            }
            $this->doc_creden_signer_email->EditValue = HtmlEncode($this->doc_creden_signer_email->CurrentValue);
            $this->doc_creden_signer_email->PlaceHolder = RemoveHtml($this->doc_creden_signer_email->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());
            if (strval($this->status->EditValue) != "" && is_numeric($this->status->EditValue)) {
                $this->status->EditValue = FormatNumber($this->status->EditValue, null);
            }

            // cdate
            $this->cdate->setupEditAttributes();
            $this->cdate->EditCustomAttributes = "";
            $this->cdate->EditValue = HtmlEncode(FormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()));
            $this->cdate->PlaceHolder = RemoveHtml($this->cdate->caption());

            // cuser
            $this->cuser->setupEditAttributes();
            $this->cuser->EditCustomAttributes = "";
            if (!$this->cuser->Raw) {
                $this->cuser->CurrentValue = HtmlDecode($this->cuser->CurrentValue);
            }
            $this->cuser->EditValue = HtmlEncode($this->cuser->CurrentValue);
            $this->cuser->PlaceHolder = RemoveHtml($this->cuser->caption());

            // cip
            $this->cip->setupEditAttributes();
            $this->cip->EditCustomAttributes = "";
            if (!$this->cip->Raw) {
                $this->cip->CurrentValue = HtmlDecode($this->cip->CurrentValue);
            }
            $this->cip->EditValue = HtmlEncode($this->cip->CurrentValue);
            $this->cip->PlaceHolder = RemoveHtml($this->cip->caption());

            // udate
            $this->udate->setupEditAttributes();
            $this->udate->EditCustomAttributes = "";
            $this->udate->EditValue = HtmlEncode(FormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern()));
            $this->udate->PlaceHolder = RemoveHtml($this->udate->caption());

            // uuser
            $this->uuser->setupEditAttributes();
            $this->uuser->EditCustomAttributes = "";
            if (!$this->uuser->Raw) {
                $this->uuser->CurrentValue = HtmlDecode($this->uuser->CurrentValue);
            }
            $this->uuser->EditValue = HtmlEncode($this->uuser->CurrentValue);
            $this->uuser->PlaceHolder = RemoveHtml($this->uuser->caption());

            // uip
            $this->uip->setupEditAttributes();
            $this->uip->EditCustomAttributes = "";
            if (!$this->uip->Raw) {
                $this->uip->CurrentValue = HtmlDecode($this->uip->CurrentValue);
            }
            $this->uip->EditValue = HtmlEncode($this->uip->CurrentValue);
            $this->uip->PlaceHolder = RemoveHtml($this->uip->caption());

            // Edit refer script

            // doc_creden_signer_id
            $this->doc_creden_signer_id->LinkCustomAttributes = "";
            $this->doc_creden_signer_id->HrefValue = "";

            // doc_creden_id
            $this->doc_creden_id->LinkCustomAttributes = "";
            $this->doc_creden_id->HrefValue = "";

            // doc_creden_signer_no
            $this->doc_creden_signer_no->LinkCustomAttributes = "";
            $this->doc_creden_signer_no->HrefValue = "";

            // doc_creden_signer_link
            $this->doc_creden_signer_link->LinkCustomAttributes = "";
            $this->doc_creden_signer_link->HrefValue = "";

            // doc_creden_signer_session
            $this->doc_creden_signer_session->LinkCustomAttributes = "";
            $this->doc_creden_signer_session->HrefValue = "";

            // doc_creden_signer_name
            $this->doc_creden_signer_name->LinkCustomAttributes = "";
            $this->doc_creden_signer_name->HrefValue = "";

            // doc_creden_signer_email
            $this->doc_creden_signer_email->LinkCustomAttributes = "";
            $this->doc_creden_signer_email->HrefValue = "";

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
        if ($this->doc_creden_signer_id->Required) {
            if (!$this->doc_creden_signer_id->IsDetailKey && EmptyValue($this->doc_creden_signer_id->FormValue)) {
                $this->doc_creden_signer_id->addErrorMessage(str_replace("%s", $this->doc_creden_signer_id->caption(), $this->doc_creden_signer_id->RequiredErrorMessage));
            }
        }
        if ($this->doc_creden_id->Required) {
            if (!$this->doc_creden_id->IsDetailKey && EmptyValue($this->doc_creden_id->FormValue)) {
                $this->doc_creden_id->addErrorMessage(str_replace("%s", $this->doc_creden_id->caption(), $this->doc_creden_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->doc_creden_id->FormValue)) {
            $this->doc_creden_id->addErrorMessage($this->doc_creden_id->getErrorMessage(false));
        }
        if ($this->doc_creden_signer_no->Required) {
            if (!$this->doc_creden_signer_no->IsDetailKey && EmptyValue($this->doc_creden_signer_no->FormValue)) {
                $this->doc_creden_signer_no->addErrorMessage(str_replace("%s", $this->doc_creden_signer_no->caption(), $this->doc_creden_signer_no->RequiredErrorMessage));
            }
        }
        if ($this->doc_creden_signer_link->Required) {
            if (!$this->doc_creden_signer_link->IsDetailKey && EmptyValue($this->doc_creden_signer_link->FormValue)) {
                $this->doc_creden_signer_link->addErrorMessage(str_replace("%s", $this->doc_creden_signer_link->caption(), $this->doc_creden_signer_link->RequiredErrorMessage));
            }
        }
        if ($this->doc_creden_signer_session->Required) {
            if (!$this->doc_creden_signer_session->IsDetailKey && EmptyValue($this->doc_creden_signer_session->FormValue)) {
                $this->doc_creden_signer_session->addErrorMessage(str_replace("%s", $this->doc_creden_signer_session->caption(), $this->doc_creden_signer_session->RequiredErrorMessage));
            }
        }
        if ($this->doc_creden_signer_name->Required) {
            if (!$this->doc_creden_signer_name->IsDetailKey && EmptyValue($this->doc_creden_signer_name->FormValue)) {
                $this->doc_creden_signer_name->addErrorMessage(str_replace("%s", $this->doc_creden_signer_name->caption(), $this->doc_creden_signer_name->RequiredErrorMessage));
            }
        }
        if ($this->doc_creden_signer_email->Required) {
            if (!$this->doc_creden_signer_email->IsDetailKey && EmptyValue($this->doc_creden_signer_email->FormValue)) {
                $this->doc_creden_signer_email->addErrorMessage(str_replace("%s", $this->doc_creden_signer_email->caption(), $this->doc_creden_signer_email->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->status->FormValue)) {
            $this->status->addErrorMessage($this->status->getErrorMessage(false));
        }
        if ($this->cdate->Required) {
            if (!$this->cdate->IsDetailKey && EmptyValue($this->cdate->FormValue)) {
                $this->cdate->addErrorMessage(str_replace("%s", $this->cdate->caption(), $this->cdate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->cdate->FormValue, $this->cdate->formatPattern())) {
            $this->cdate->addErrorMessage($this->cdate->getErrorMessage(false));
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
        if (!CheckDate($this->udate->FormValue, $this->udate->formatPattern())) {
            $this->udate->addErrorMessage($this->udate->getErrorMessage(false));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // doc_creden_id
            $this->doc_creden_id->setDbValueDef($rsnew, $this->doc_creden_id->CurrentValue, null, $this->doc_creden_id->ReadOnly);

            // doc_creden_signer_no
            $this->doc_creden_signer_no->setDbValueDef($rsnew, $this->doc_creden_signer_no->CurrentValue, null, $this->doc_creden_signer_no->ReadOnly);

            // doc_creden_signer_link
            $this->doc_creden_signer_link->setDbValueDef($rsnew, $this->doc_creden_signer_link->CurrentValue, null, $this->doc_creden_signer_link->ReadOnly);

            // doc_creden_signer_session
            $this->doc_creden_signer_session->setDbValueDef($rsnew, $this->doc_creden_signer_session->CurrentValue, null, $this->doc_creden_signer_session->ReadOnly);

            // doc_creden_signer_name
            $this->doc_creden_signer_name->setDbValueDef($rsnew, $this->doc_creden_signer_name->CurrentValue, null, $this->doc_creden_signer_name->ReadOnly);

            // doc_creden_signer_email
            $this->doc_creden_signer_email->setDbValueDef($rsnew, $this->doc_creden_signer_email->CurrentValue, null, $this->doc_creden_signer_email->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // cdate
            $this->cdate->setDbValueDef($rsnew, UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()), null, $this->cdate->ReadOnly);

            // cuser
            $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null, $this->cuser->ReadOnly);

            // cip
            $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null, $this->cip->ReadOnly);

            // udate
            $this->udate->setDbValueDef($rsnew, UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern()), null, $this->udate->ReadOnly);

            // uuser
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null, $this->uuser->ReadOnly);

            // uip
            $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null, $this->uip->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    $editRow = $this->update($rsnew, "", $rsold);
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("doccredensignerlist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                $pageNo = ParseInteger($pageNo);
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
