<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakReceiptAdd extends PeakReceipt
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_receipt';

    // Page object name
    public $PageObjName = "PeakReceiptAdd";

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

        // Table object (peak_receipt)
        if (!isset($GLOBALS["peak_receipt"]) || get_class($GLOBALS["peak_receipt"]) == PROJECT_NAMESPACE . "peak_receipt") {
            $GLOBALS["peak_receipt"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_receipt');
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
                $tbl = Container("peak_receipt");
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
                    if ($pageName == "peakreceiptview") {
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
        $this->issueddate->setVisibility();
        $this->duedate->setVisibility();
        $this->contactcode->setVisibility();
        $this->tag->setVisibility();
        $this->istaxinvoice->setVisibility();
        $this->taxstatus->setVisibility();
        $this->paymentdate->setVisibility();
        $this->paymentmethodid->setVisibility();
        $this->paymentMethodCode->setVisibility();
        $this->amount->setVisibility();
        $this->remark->setVisibility();
        $this->receipt_id->setVisibility();
        $this->receipt_code->setVisibility();
        $this->receipt_status->setVisibility();
        $this->preTaxAmount->setVisibility();
        $this->vatAmount->setVisibility();
        $this->netAmount->setVisibility();
        $this->whtAmount->setVisibility();
        $this->paymentAmount->setVisibility();
        $this->remainAmount->setVisibility();
        $this->remainWhtAmount->setVisibility();
        $this->onlineViewLink->setVisibility();
        $this->isPartialReceipt->setVisibility();
        $this->journals_id->setVisibility();
        $this->journals_code->setVisibility();
        $this->refid->setVisibility();
        $this->transition_type->setVisibility();
        $this->is_email->setVisibility();
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
                    $this->terminate("peakreceiptlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "peakreceiptlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "peakreceiptview") {
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
        $this->issueddate->CurrentValue = null;
        $this->issueddate->OldValue = $this->issueddate->CurrentValue;
        $this->duedate->CurrentValue = null;
        $this->duedate->OldValue = $this->duedate->CurrentValue;
        $this->contactcode->CurrentValue = null;
        $this->contactcode->OldValue = $this->contactcode->CurrentValue;
        $this->tag->CurrentValue = null;
        $this->tag->OldValue = $this->tag->CurrentValue;
        $this->istaxinvoice->CurrentValue = null;
        $this->istaxinvoice->OldValue = $this->istaxinvoice->CurrentValue;
        $this->taxstatus->CurrentValue = null;
        $this->taxstatus->OldValue = $this->taxstatus->CurrentValue;
        $this->paymentdate->CurrentValue = null;
        $this->paymentdate->OldValue = $this->paymentdate->CurrentValue;
        $this->paymentmethodid->CurrentValue = null;
        $this->paymentmethodid->OldValue = $this->paymentmethodid->CurrentValue;
        $this->paymentMethodCode->CurrentValue = null;
        $this->paymentMethodCode->OldValue = $this->paymentMethodCode->CurrentValue;
        $this->amount->CurrentValue = null;
        $this->amount->OldValue = $this->amount->CurrentValue;
        $this->remark->CurrentValue = null;
        $this->remark->OldValue = $this->remark->CurrentValue;
        $this->receipt_id->CurrentValue = null;
        $this->receipt_id->OldValue = $this->receipt_id->CurrentValue;
        $this->receipt_code->CurrentValue = null;
        $this->receipt_code->OldValue = $this->receipt_code->CurrentValue;
        $this->receipt_status->CurrentValue = null;
        $this->receipt_status->OldValue = $this->receipt_status->CurrentValue;
        $this->preTaxAmount->CurrentValue = null;
        $this->preTaxAmount->OldValue = $this->preTaxAmount->CurrentValue;
        $this->vatAmount->CurrentValue = null;
        $this->vatAmount->OldValue = $this->vatAmount->CurrentValue;
        $this->netAmount->CurrentValue = null;
        $this->netAmount->OldValue = $this->netAmount->CurrentValue;
        $this->whtAmount->CurrentValue = null;
        $this->whtAmount->OldValue = $this->whtAmount->CurrentValue;
        $this->paymentAmount->CurrentValue = null;
        $this->paymentAmount->OldValue = $this->paymentAmount->CurrentValue;
        $this->remainAmount->CurrentValue = null;
        $this->remainAmount->OldValue = $this->remainAmount->CurrentValue;
        $this->remainWhtAmount->CurrentValue = null;
        $this->remainWhtAmount->OldValue = $this->remainWhtAmount->CurrentValue;
        $this->onlineViewLink->CurrentValue = null;
        $this->onlineViewLink->OldValue = $this->onlineViewLink->CurrentValue;
        $this->isPartialReceipt->CurrentValue = null;
        $this->isPartialReceipt->OldValue = $this->isPartialReceipt->CurrentValue;
        $this->journals_id->CurrentValue = null;
        $this->journals_id->OldValue = $this->journals_id->CurrentValue;
        $this->journals_code->CurrentValue = null;
        $this->journals_code->OldValue = $this->journals_code->CurrentValue;
        $this->refid->CurrentValue = null;
        $this->refid->OldValue = $this->refid->CurrentValue;
        $this->transition_type->CurrentValue = null;
        $this->transition_type->OldValue = $this->transition_type->CurrentValue;
        $this->is_email->CurrentValue = 0;
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

        // Check field name 'issueddate' first before field var 'x_issueddate'
        $val = $CurrentForm->hasValue("issueddate") ? $CurrentForm->getValue("issueddate") : $CurrentForm->getValue("x_issueddate");
        if (!$this->issueddate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->issueddate->Visible = false; // Disable update for API request
            } else {
                $this->issueddate->setFormValue($val, true, $validate);
            }
            $this->issueddate->CurrentValue = UnFormatDateTime($this->issueddate->CurrentValue, $this->issueddate->formatPattern());
        }

        // Check field name 'duedate' first before field var 'x_duedate'
        $val = $CurrentForm->hasValue("duedate") ? $CurrentForm->getValue("duedate") : $CurrentForm->getValue("x_duedate");
        if (!$this->duedate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->duedate->Visible = false; // Disable update for API request
            } else {
                $this->duedate->setFormValue($val, true, $validate);
            }
            $this->duedate->CurrentValue = UnFormatDateTime($this->duedate->CurrentValue, $this->duedate->formatPattern());
        }

        // Check field name 'contactcode' first before field var 'x_contactcode'
        $val = $CurrentForm->hasValue("contactcode") ? $CurrentForm->getValue("contactcode") : $CurrentForm->getValue("x_contactcode");
        if (!$this->contactcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contactcode->Visible = false; // Disable update for API request
            } else {
                $this->contactcode->setFormValue($val);
            }
        }

        // Check field name 'tag' first before field var 'x_tag'
        $val = $CurrentForm->hasValue("tag") ? $CurrentForm->getValue("tag") : $CurrentForm->getValue("x_tag");
        if (!$this->tag->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tag->Visible = false; // Disable update for API request
            } else {
                $this->tag->setFormValue($val);
            }
        }

        // Check field name 'istaxinvoice' first before field var 'x_istaxinvoice'
        $val = $CurrentForm->hasValue("istaxinvoice") ? $CurrentForm->getValue("istaxinvoice") : $CurrentForm->getValue("x_istaxinvoice");
        if (!$this->istaxinvoice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->istaxinvoice->Visible = false; // Disable update for API request
            } else {
                $this->istaxinvoice->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'taxstatus' first before field var 'x_taxstatus'
        $val = $CurrentForm->hasValue("taxstatus") ? $CurrentForm->getValue("taxstatus") : $CurrentForm->getValue("x_taxstatus");
        if (!$this->taxstatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->taxstatus->Visible = false; // Disable update for API request
            } else {
                $this->taxstatus->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'paymentdate' first before field var 'x_paymentdate'
        $val = $CurrentForm->hasValue("paymentdate") ? $CurrentForm->getValue("paymentdate") : $CurrentForm->getValue("x_paymentdate");
        if (!$this->paymentdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentdate->Visible = false; // Disable update for API request
            } else {
                $this->paymentdate->setFormValue($val, true, $validate);
            }
            $this->paymentdate->CurrentValue = UnFormatDateTime($this->paymentdate->CurrentValue, $this->paymentdate->formatPattern());
        }

        // Check field name 'paymentmethodid' first before field var 'x_paymentmethodid'
        $val = $CurrentForm->hasValue("paymentmethodid") ? $CurrentForm->getValue("paymentmethodid") : $CurrentForm->getValue("x_paymentmethodid");
        if (!$this->paymentmethodid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentmethodid->Visible = false; // Disable update for API request
            } else {
                $this->paymentmethodid->setFormValue($val);
            }
        }

        // Check field name 'paymentMethodCode' first before field var 'x_paymentMethodCode'
        $val = $CurrentForm->hasValue("paymentMethodCode") ? $CurrentForm->getValue("paymentMethodCode") : $CurrentForm->getValue("x_paymentMethodCode");
        if (!$this->paymentMethodCode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentMethodCode->Visible = false; // Disable update for API request
            } else {
                $this->paymentMethodCode->setFormValue($val);
            }
        }

        // Check field name 'amount' first before field var 'x_amount'
        $val = $CurrentForm->hasValue("amount") ? $CurrentForm->getValue("amount") : $CurrentForm->getValue("x_amount");
        if (!$this->amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->amount->Visible = false; // Disable update for API request
            } else {
                $this->amount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remark' first before field var 'x_remark'
        $val = $CurrentForm->hasValue("remark") ? $CurrentForm->getValue("remark") : $CurrentForm->getValue("x_remark");
        if (!$this->remark->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remark->Visible = false; // Disable update for API request
            } else {
                $this->remark->setFormValue($val);
            }
        }

        // Check field name 'receipt_id' first before field var 'x_receipt_id'
        $val = $CurrentForm->hasValue("receipt_id") ? $CurrentForm->getValue("receipt_id") : $CurrentForm->getValue("x_receipt_id");
        if (!$this->receipt_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receipt_id->Visible = false; // Disable update for API request
            } else {
                $this->receipt_id->setFormValue($val);
            }
        }

        // Check field name 'receipt_code' first before field var 'x_receipt_code'
        $val = $CurrentForm->hasValue("receipt_code") ? $CurrentForm->getValue("receipt_code") : $CurrentForm->getValue("x_receipt_code");
        if (!$this->receipt_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receipt_code->Visible = false; // Disable update for API request
            } else {
                $this->receipt_code->setFormValue($val);
            }
        }

        // Check field name 'receipt_status' first before field var 'x_receipt_status'
        $val = $CurrentForm->hasValue("receipt_status") ? $CurrentForm->getValue("receipt_status") : $CurrentForm->getValue("x_receipt_status");
        if (!$this->receipt_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receipt_status->Visible = false; // Disable update for API request
            } else {
                $this->receipt_status->setFormValue($val);
            }
        }

        // Check field name 'preTaxAmount' first before field var 'x_preTaxAmount'
        $val = $CurrentForm->hasValue("preTaxAmount") ? $CurrentForm->getValue("preTaxAmount") : $CurrentForm->getValue("x_preTaxAmount");
        if (!$this->preTaxAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->preTaxAmount->Visible = false; // Disable update for API request
            } else {
                $this->preTaxAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'vatAmount' first before field var 'x_vatAmount'
        $val = $CurrentForm->hasValue("vatAmount") ? $CurrentForm->getValue("vatAmount") : $CurrentForm->getValue("x_vatAmount");
        if (!$this->vatAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vatAmount->Visible = false; // Disable update for API request
            } else {
                $this->vatAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'netAmount' first before field var 'x_netAmount'
        $val = $CurrentForm->hasValue("netAmount") ? $CurrentForm->getValue("netAmount") : $CurrentForm->getValue("x_netAmount");
        if (!$this->netAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->netAmount->Visible = false; // Disable update for API request
            } else {
                $this->netAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'whtAmount' first before field var 'x_whtAmount'
        $val = $CurrentForm->hasValue("whtAmount") ? $CurrentForm->getValue("whtAmount") : $CurrentForm->getValue("x_whtAmount");
        if (!$this->whtAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->whtAmount->Visible = false; // Disable update for API request
            } else {
                $this->whtAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'paymentAmount' first before field var 'x_paymentAmount'
        $val = $CurrentForm->hasValue("paymentAmount") ? $CurrentForm->getValue("paymentAmount") : $CurrentForm->getValue("x_paymentAmount");
        if (!$this->paymentAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentAmount->Visible = false; // Disable update for API request
            } else {
                $this->paymentAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remainAmount' first before field var 'x_remainAmount'
        $val = $CurrentForm->hasValue("remainAmount") ? $CurrentForm->getValue("remainAmount") : $CurrentForm->getValue("x_remainAmount");
        if (!$this->remainAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remainAmount->Visible = false; // Disable update for API request
            } else {
                $this->remainAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'remainWhtAmount' first before field var 'x_remainWhtAmount'
        $val = $CurrentForm->hasValue("remainWhtAmount") ? $CurrentForm->getValue("remainWhtAmount") : $CurrentForm->getValue("x_remainWhtAmount");
        if (!$this->remainWhtAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remainWhtAmount->Visible = false; // Disable update for API request
            } else {
                $this->remainWhtAmount->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'onlineViewLink' first before field var 'x_onlineViewLink'
        $val = $CurrentForm->hasValue("onlineViewLink") ? $CurrentForm->getValue("onlineViewLink") : $CurrentForm->getValue("x_onlineViewLink");
        if (!$this->onlineViewLink->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->onlineViewLink->Visible = false; // Disable update for API request
            } else {
                $this->onlineViewLink->setFormValue($val);
            }
        }

        // Check field name 'isPartialReceipt' first before field var 'x_isPartialReceipt'
        $val = $CurrentForm->hasValue("isPartialReceipt") ? $CurrentForm->getValue("isPartialReceipt") : $CurrentForm->getValue("x_isPartialReceipt");
        if (!$this->isPartialReceipt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isPartialReceipt->Visible = false; // Disable update for API request
            } else {
                $this->isPartialReceipt->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'journals_id' first before field var 'x_journals_id'
        $val = $CurrentForm->hasValue("journals_id") ? $CurrentForm->getValue("journals_id") : $CurrentForm->getValue("x_journals_id");
        if (!$this->journals_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->journals_id->Visible = false; // Disable update for API request
            } else {
                $this->journals_id->setFormValue($val);
            }
        }

        // Check field name 'journals_code' first before field var 'x_journals_code'
        $val = $CurrentForm->hasValue("journals_code") ? $CurrentForm->getValue("journals_code") : $CurrentForm->getValue("x_journals_code");
        if (!$this->journals_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->journals_code->Visible = false; // Disable update for API request
            } else {
                $this->journals_code->setFormValue($val);
            }
        }

        // Check field name 'refid' first before field var 'x_refid'
        $val = $CurrentForm->hasValue("refid") ? $CurrentForm->getValue("refid") : $CurrentForm->getValue("x_refid");
        if (!$this->refid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->refid->Visible = false; // Disable update for API request
            } else {
                $this->refid->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transition_type' first before field var 'x_transition_type'
        $val = $CurrentForm->hasValue("transition_type") ? $CurrentForm->getValue("transition_type") : $CurrentForm->getValue("x_transition_type");
        if (!$this->transition_type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transition_type->Visible = false; // Disable update for API request
            } else {
                $this->transition_type->setFormValue($val, true, $validate);
            }
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
        $this->issueddate->CurrentValue = $this->issueddate->FormValue;
        $this->issueddate->CurrentValue = UnFormatDateTime($this->issueddate->CurrentValue, $this->issueddate->formatPattern());
        $this->duedate->CurrentValue = $this->duedate->FormValue;
        $this->duedate->CurrentValue = UnFormatDateTime($this->duedate->CurrentValue, $this->duedate->formatPattern());
        $this->contactcode->CurrentValue = $this->contactcode->FormValue;
        $this->tag->CurrentValue = $this->tag->FormValue;
        $this->istaxinvoice->CurrentValue = $this->istaxinvoice->FormValue;
        $this->taxstatus->CurrentValue = $this->taxstatus->FormValue;
        $this->paymentdate->CurrentValue = $this->paymentdate->FormValue;
        $this->paymentdate->CurrentValue = UnFormatDateTime($this->paymentdate->CurrentValue, $this->paymentdate->formatPattern());
        $this->paymentmethodid->CurrentValue = $this->paymentmethodid->FormValue;
        $this->paymentMethodCode->CurrentValue = $this->paymentMethodCode->FormValue;
        $this->amount->CurrentValue = $this->amount->FormValue;
        $this->remark->CurrentValue = $this->remark->FormValue;
        $this->receipt_id->CurrentValue = $this->receipt_id->FormValue;
        $this->receipt_code->CurrentValue = $this->receipt_code->FormValue;
        $this->receipt_status->CurrentValue = $this->receipt_status->FormValue;
        $this->preTaxAmount->CurrentValue = $this->preTaxAmount->FormValue;
        $this->vatAmount->CurrentValue = $this->vatAmount->FormValue;
        $this->netAmount->CurrentValue = $this->netAmount->FormValue;
        $this->whtAmount->CurrentValue = $this->whtAmount->FormValue;
        $this->paymentAmount->CurrentValue = $this->paymentAmount->FormValue;
        $this->remainAmount->CurrentValue = $this->remainAmount->FormValue;
        $this->remainWhtAmount->CurrentValue = $this->remainWhtAmount->FormValue;
        $this->onlineViewLink->CurrentValue = $this->onlineViewLink->FormValue;
        $this->isPartialReceipt->CurrentValue = $this->isPartialReceipt->FormValue;
        $this->journals_id->CurrentValue = $this->journals_id->FormValue;
        $this->journals_code->CurrentValue = $this->journals_code->FormValue;
        $this->refid->CurrentValue = $this->refid->FormValue;
        $this->transition_type->CurrentValue = $this->transition_type->FormValue;
        $this->is_email->CurrentValue = $this->is_email->FormValue;
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
        $this->issueddate->setDbValue($row['issueddate']);
        $this->duedate->setDbValue($row['duedate']);
        $this->contactcode->setDbValue($row['contactcode']);
        $this->tag->setDbValue($row['tag']);
        $this->istaxinvoice->setDbValue($row['istaxinvoice']);
        $this->taxstatus->setDbValue($row['taxstatus']);
        $this->paymentdate->setDbValue($row['paymentdate']);
        $this->paymentmethodid->setDbValue($row['paymentmethodid']);
        $this->paymentMethodCode->setDbValue($row['paymentMethodCode']);
        $this->amount->setDbValue($row['amount']);
        $this->remark->setDbValue($row['remark']);
        $this->receipt_id->setDbValue($row['receipt_id']);
        $this->receipt_code->setDbValue($row['receipt_code']);
        $this->receipt_status->setDbValue($row['receipt_status']);
        $this->preTaxAmount->setDbValue($row['preTaxAmount']);
        $this->vatAmount->setDbValue($row['vatAmount']);
        $this->netAmount->setDbValue($row['netAmount']);
        $this->whtAmount->setDbValue($row['whtAmount']);
        $this->paymentAmount->setDbValue($row['paymentAmount']);
        $this->remainAmount->setDbValue($row['remainAmount']);
        $this->remainWhtAmount->setDbValue($row['remainWhtAmount']);
        $this->onlineViewLink->setDbValue($row['onlineViewLink']);
        $this->isPartialReceipt->setDbValue($row['isPartialReceipt']);
        $this->journals_id->setDbValue($row['journals_id']);
        $this->journals_code->setDbValue($row['journals_code']);
        $this->refid->setDbValue($row['refid']);
        $this->transition_type->setDbValue($row['transition_type']);
        $this->is_email->setDbValue($row['is_email']);
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
        $row['issueddate'] = $this->issueddate->CurrentValue;
        $row['duedate'] = $this->duedate->CurrentValue;
        $row['contactcode'] = $this->contactcode->CurrentValue;
        $row['tag'] = $this->tag->CurrentValue;
        $row['istaxinvoice'] = $this->istaxinvoice->CurrentValue;
        $row['taxstatus'] = $this->taxstatus->CurrentValue;
        $row['paymentdate'] = $this->paymentdate->CurrentValue;
        $row['paymentmethodid'] = $this->paymentmethodid->CurrentValue;
        $row['paymentMethodCode'] = $this->paymentMethodCode->CurrentValue;
        $row['amount'] = $this->amount->CurrentValue;
        $row['remark'] = $this->remark->CurrentValue;
        $row['receipt_id'] = $this->receipt_id->CurrentValue;
        $row['receipt_code'] = $this->receipt_code->CurrentValue;
        $row['receipt_status'] = $this->receipt_status->CurrentValue;
        $row['preTaxAmount'] = $this->preTaxAmount->CurrentValue;
        $row['vatAmount'] = $this->vatAmount->CurrentValue;
        $row['netAmount'] = $this->netAmount->CurrentValue;
        $row['whtAmount'] = $this->whtAmount->CurrentValue;
        $row['paymentAmount'] = $this->paymentAmount->CurrentValue;
        $row['remainAmount'] = $this->remainAmount->CurrentValue;
        $row['remainWhtAmount'] = $this->remainWhtAmount->CurrentValue;
        $row['onlineViewLink'] = $this->onlineViewLink->CurrentValue;
        $row['isPartialReceipt'] = $this->isPartialReceipt->CurrentValue;
        $row['journals_id'] = $this->journals_id->CurrentValue;
        $row['journals_code'] = $this->journals_code->CurrentValue;
        $row['refid'] = $this->refid->CurrentValue;
        $row['transition_type'] = $this->transition_type->CurrentValue;
        $row['is_email'] = $this->is_email->CurrentValue;
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

        // issueddate
        $this->issueddate->RowCssClass = "row";

        // duedate
        $this->duedate->RowCssClass = "row";

        // contactcode
        $this->contactcode->RowCssClass = "row";

        // tag
        $this->tag->RowCssClass = "row";

        // istaxinvoice
        $this->istaxinvoice->RowCssClass = "row";

        // taxstatus
        $this->taxstatus->RowCssClass = "row";

        // paymentdate
        $this->paymentdate->RowCssClass = "row";

        // paymentmethodid
        $this->paymentmethodid->RowCssClass = "row";

        // paymentMethodCode
        $this->paymentMethodCode->RowCssClass = "row";

        // amount
        $this->amount->RowCssClass = "row";

        // remark
        $this->remark->RowCssClass = "row";

        // receipt_id
        $this->receipt_id->RowCssClass = "row";

        // receipt_code
        $this->receipt_code->RowCssClass = "row";

        // receipt_status
        $this->receipt_status->RowCssClass = "row";

        // preTaxAmount
        $this->preTaxAmount->RowCssClass = "row";

        // vatAmount
        $this->vatAmount->RowCssClass = "row";

        // netAmount
        $this->netAmount->RowCssClass = "row";

        // whtAmount
        $this->whtAmount->RowCssClass = "row";

        // paymentAmount
        $this->paymentAmount->RowCssClass = "row";

        // remainAmount
        $this->remainAmount->RowCssClass = "row";

        // remainWhtAmount
        $this->remainWhtAmount->RowCssClass = "row";

        // onlineViewLink
        $this->onlineViewLink->RowCssClass = "row";

        // isPartialReceipt
        $this->isPartialReceipt->RowCssClass = "row";

        // journals_id
        $this->journals_id->RowCssClass = "row";

        // journals_code
        $this->journals_code->RowCssClass = "row";

        // refid
        $this->refid->RowCssClass = "row";

        // transition_type
        $this->transition_type->RowCssClass = "row";

        // is_email
        $this->is_email->RowCssClass = "row";

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

            // issueddate
            $this->issueddate->ViewValue = $this->issueddate->CurrentValue;
            $this->issueddate->ViewValue = FormatDateTime($this->issueddate->ViewValue, $this->issueddate->formatPattern());
            $this->issueddate->ViewCustomAttributes = "";

            // duedate
            $this->duedate->ViewValue = $this->duedate->CurrentValue;
            $this->duedate->ViewValue = FormatDateTime($this->duedate->ViewValue, $this->duedate->formatPattern());
            $this->duedate->ViewCustomAttributes = "";

            // contactcode
            $this->contactcode->ViewValue = $this->contactcode->CurrentValue;
            $this->contactcode->ViewCustomAttributes = "";

            // tag
            $this->tag->ViewValue = $this->tag->CurrentValue;
            $this->tag->ViewCustomAttributes = "";

            // istaxinvoice
            $this->istaxinvoice->ViewValue = $this->istaxinvoice->CurrentValue;
            $this->istaxinvoice->ViewValue = FormatNumber($this->istaxinvoice->ViewValue, $this->istaxinvoice->formatPattern());
            $this->istaxinvoice->ViewCustomAttributes = "";

            // taxstatus
            $this->taxstatus->ViewValue = $this->taxstatus->CurrentValue;
            $this->taxstatus->ViewValue = FormatNumber($this->taxstatus->ViewValue, $this->taxstatus->formatPattern());
            $this->taxstatus->ViewCustomAttributes = "";

            // paymentdate
            $this->paymentdate->ViewValue = $this->paymentdate->CurrentValue;
            $this->paymentdate->ViewValue = FormatDateTime($this->paymentdate->ViewValue, $this->paymentdate->formatPattern());
            $this->paymentdate->ViewCustomAttributes = "";

            // paymentmethodid
            $this->paymentmethodid->ViewValue = $this->paymentmethodid->CurrentValue;
            $this->paymentmethodid->ViewCustomAttributes = "";

            // paymentMethodCode
            $this->paymentMethodCode->ViewValue = $this->paymentMethodCode->CurrentValue;
            $this->paymentMethodCode->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

            // remark
            $this->remark->ViewValue = $this->remark->CurrentValue;
            $this->remark->ViewCustomAttributes = "";

            // receipt_id
            $this->receipt_id->ViewValue = $this->receipt_id->CurrentValue;
            $this->receipt_id->ViewCustomAttributes = "";

            // receipt_code
            $this->receipt_code->ViewValue = $this->receipt_code->CurrentValue;
            $this->receipt_code->ViewCustomAttributes = "";

            // receipt_status
            $this->receipt_status->ViewValue = $this->receipt_status->CurrentValue;
            $this->receipt_status->ViewCustomAttributes = "";

            // preTaxAmount
            $this->preTaxAmount->ViewValue = $this->preTaxAmount->CurrentValue;
            $this->preTaxAmount->ViewValue = FormatNumber($this->preTaxAmount->ViewValue, $this->preTaxAmount->formatPattern());
            $this->preTaxAmount->ViewCustomAttributes = "";

            // vatAmount
            $this->vatAmount->ViewValue = $this->vatAmount->CurrentValue;
            $this->vatAmount->ViewValue = FormatNumber($this->vatAmount->ViewValue, $this->vatAmount->formatPattern());
            $this->vatAmount->ViewCustomAttributes = "";

            // netAmount
            $this->netAmount->ViewValue = $this->netAmount->CurrentValue;
            $this->netAmount->ViewValue = FormatNumber($this->netAmount->ViewValue, $this->netAmount->formatPattern());
            $this->netAmount->ViewCustomAttributes = "";

            // whtAmount
            $this->whtAmount->ViewValue = $this->whtAmount->CurrentValue;
            $this->whtAmount->ViewValue = FormatNumber($this->whtAmount->ViewValue, $this->whtAmount->formatPattern());
            $this->whtAmount->ViewCustomAttributes = "";

            // paymentAmount
            $this->paymentAmount->ViewValue = $this->paymentAmount->CurrentValue;
            $this->paymentAmount->ViewValue = FormatNumber($this->paymentAmount->ViewValue, $this->paymentAmount->formatPattern());
            $this->paymentAmount->ViewCustomAttributes = "";

            // remainAmount
            $this->remainAmount->ViewValue = $this->remainAmount->CurrentValue;
            $this->remainAmount->ViewValue = FormatNumber($this->remainAmount->ViewValue, $this->remainAmount->formatPattern());
            $this->remainAmount->ViewCustomAttributes = "";

            // remainWhtAmount
            $this->remainWhtAmount->ViewValue = $this->remainWhtAmount->CurrentValue;
            $this->remainWhtAmount->ViewValue = FormatNumber($this->remainWhtAmount->ViewValue, $this->remainWhtAmount->formatPattern());
            $this->remainWhtAmount->ViewCustomAttributes = "";

            // onlineViewLink
            $this->onlineViewLink->ViewValue = $this->onlineViewLink->CurrentValue;
            $this->onlineViewLink->ViewCustomAttributes = "";

            // isPartialReceipt
            $this->isPartialReceipt->ViewValue = $this->isPartialReceipt->CurrentValue;
            $this->isPartialReceipt->ViewValue = FormatNumber($this->isPartialReceipt->ViewValue, $this->isPartialReceipt->formatPattern());
            $this->isPartialReceipt->ViewCustomAttributes = "";

            // journals_id
            $this->journals_id->ViewValue = $this->journals_id->CurrentValue;
            $this->journals_id->ViewCustomAttributes = "";

            // journals_code
            $this->journals_code->ViewValue = $this->journals_code->CurrentValue;
            $this->journals_code->ViewCustomAttributes = "";

            // refid
            $this->refid->ViewValue = $this->refid->CurrentValue;
            $this->refid->ViewValue = FormatNumber($this->refid->ViewValue, $this->refid->formatPattern());
            $this->refid->ViewCustomAttributes = "";

            // transition_type
            $this->transition_type->ViewValue = $this->transition_type->CurrentValue;
            $this->transition_type->ViewValue = FormatNumber($this->transition_type->ViewValue, $this->transition_type->formatPattern());
            $this->transition_type->ViewCustomAttributes = "";

            // is_email
            $this->is_email->ViewValue = $this->is_email->CurrentValue;
            $this->is_email->ViewValue = FormatNumber($this->is_email->ViewValue, $this->is_email->formatPattern());
            $this->is_email->ViewCustomAttributes = "";

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

            // issueddate
            $this->issueddate->LinkCustomAttributes = "";
            $this->issueddate->HrefValue = "";

            // duedate
            $this->duedate->LinkCustomAttributes = "";
            $this->duedate->HrefValue = "";

            // contactcode
            $this->contactcode->LinkCustomAttributes = "";
            $this->contactcode->HrefValue = "";

            // tag
            $this->tag->LinkCustomAttributes = "";
            $this->tag->HrefValue = "";

            // istaxinvoice
            $this->istaxinvoice->LinkCustomAttributes = "";
            $this->istaxinvoice->HrefValue = "";

            // taxstatus
            $this->taxstatus->LinkCustomAttributes = "";
            $this->taxstatus->HrefValue = "";

            // paymentdate
            $this->paymentdate->LinkCustomAttributes = "";
            $this->paymentdate->HrefValue = "";

            // paymentmethodid
            $this->paymentmethodid->LinkCustomAttributes = "";
            $this->paymentmethodid->HrefValue = "";

            // paymentMethodCode
            $this->paymentMethodCode->LinkCustomAttributes = "";
            $this->paymentMethodCode->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

            // remark
            $this->remark->LinkCustomAttributes = "";
            $this->remark->HrefValue = "";

            // receipt_id
            $this->receipt_id->LinkCustomAttributes = "";
            $this->receipt_id->HrefValue = "";

            // receipt_code
            $this->receipt_code->LinkCustomAttributes = "";
            $this->receipt_code->HrefValue = "";

            // receipt_status
            $this->receipt_status->LinkCustomAttributes = "";
            $this->receipt_status->HrefValue = "";

            // preTaxAmount
            $this->preTaxAmount->LinkCustomAttributes = "";
            $this->preTaxAmount->HrefValue = "";

            // vatAmount
            $this->vatAmount->LinkCustomAttributes = "";
            $this->vatAmount->HrefValue = "";

            // netAmount
            $this->netAmount->LinkCustomAttributes = "";
            $this->netAmount->HrefValue = "";

            // whtAmount
            $this->whtAmount->LinkCustomAttributes = "";
            $this->whtAmount->HrefValue = "";

            // paymentAmount
            $this->paymentAmount->LinkCustomAttributes = "";
            $this->paymentAmount->HrefValue = "";

            // remainAmount
            $this->remainAmount->LinkCustomAttributes = "";
            $this->remainAmount->HrefValue = "";

            // remainWhtAmount
            $this->remainWhtAmount->LinkCustomAttributes = "";
            $this->remainWhtAmount->HrefValue = "";

            // onlineViewLink
            $this->onlineViewLink->LinkCustomAttributes = "";
            $this->onlineViewLink->HrefValue = "";

            // isPartialReceipt
            $this->isPartialReceipt->LinkCustomAttributes = "";
            $this->isPartialReceipt->HrefValue = "";

            // journals_id
            $this->journals_id->LinkCustomAttributes = "";
            $this->journals_id->HrefValue = "";

            // journals_code
            $this->journals_code->LinkCustomAttributes = "";
            $this->journals_code->HrefValue = "";

            // refid
            $this->refid->LinkCustomAttributes = "";
            $this->refid->HrefValue = "";

            // transition_type
            $this->transition_type->LinkCustomAttributes = "";
            $this->transition_type->HrefValue = "";

            // is_email
            $this->is_email->LinkCustomAttributes = "";
            $this->is_email->HrefValue = "";
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

            // issueddate
            $this->issueddate->setupEditAttributes();
            $this->issueddate->EditCustomAttributes = "";
            $this->issueddate->EditValue = HtmlEncode(FormatDateTime($this->issueddate->CurrentValue, $this->issueddate->formatPattern()));
            $this->issueddate->PlaceHolder = RemoveHtml($this->issueddate->caption());

            // duedate
            $this->duedate->setupEditAttributes();
            $this->duedate->EditCustomAttributes = "";
            $this->duedate->EditValue = HtmlEncode(FormatDateTime($this->duedate->CurrentValue, $this->duedate->formatPattern()));
            $this->duedate->PlaceHolder = RemoveHtml($this->duedate->caption());

            // contactcode
            $this->contactcode->setupEditAttributes();
            $this->contactcode->EditCustomAttributes = "";
            if (!$this->contactcode->Raw) {
                $this->contactcode->CurrentValue = HtmlDecode($this->contactcode->CurrentValue);
            }
            $this->contactcode->EditValue = HtmlEncode($this->contactcode->CurrentValue);
            $this->contactcode->PlaceHolder = RemoveHtml($this->contactcode->caption());

            // tag
            $this->tag->setupEditAttributes();
            $this->tag->EditCustomAttributes = "";
            $this->tag->EditValue = HtmlEncode($this->tag->CurrentValue);
            $this->tag->PlaceHolder = RemoveHtml($this->tag->caption());

            // istaxinvoice
            $this->istaxinvoice->setupEditAttributes();
            $this->istaxinvoice->EditCustomAttributes = "";
            $this->istaxinvoice->EditValue = HtmlEncode($this->istaxinvoice->CurrentValue);
            $this->istaxinvoice->PlaceHolder = RemoveHtml($this->istaxinvoice->caption());
            if (strval($this->istaxinvoice->EditValue) != "" && is_numeric($this->istaxinvoice->EditValue)) {
                $this->istaxinvoice->EditValue = FormatNumber($this->istaxinvoice->EditValue, null);
            }

            // taxstatus
            $this->taxstatus->setupEditAttributes();
            $this->taxstatus->EditCustomAttributes = "";
            $this->taxstatus->EditValue = HtmlEncode($this->taxstatus->CurrentValue);
            $this->taxstatus->PlaceHolder = RemoveHtml($this->taxstatus->caption());
            if (strval($this->taxstatus->EditValue) != "" && is_numeric($this->taxstatus->EditValue)) {
                $this->taxstatus->EditValue = FormatNumber($this->taxstatus->EditValue, null);
            }

            // paymentdate
            $this->paymentdate->setupEditAttributes();
            $this->paymentdate->EditCustomAttributes = "";
            $this->paymentdate->EditValue = HtmlEncode(FormatDateTime($this->paymentdate->CurrentValue, $this->paymentdate->formatPattern()));
            $this->paymentdate->PlaceHolder = RemoveHtml($this->paymentdate->caption());

            // paymentmethodid
            $this->paymentmethodid->setupEditAttributes();
            $this->paymentmethodid->EditCustomAttributes = "";
            if (!$this->paymentmethodid->Raw) {
                $this->paymentmethodid->CurrentValue = HtmlDecode($this->paymentmethodid->CurrentValue);
            }
            $this->paymentmethodid->EditValue = HtmlEncode($this->paymentmethodid->CurrentValue);
            $this->paymentmethodid->PlaceHolder = RemoveHtml($this->paymentmethodid->caption());

            // paymentMethodCode
            $this->paymentMethodCode->setupEditAttributes();
            $this->paymentMethodCode->EditCustomAttributes = "";
            if (!$this->paymentMethodCode->Raw) {
                $this->paymentMethodCode->CurrentValue = HtmlDecode($this->paymentMethodCode->CurrentValue);
            }
            $this->paymentMethodCode->EditValue = HtmlEncode($this->paymentMethodCode->CurrentValue);
            $this->paymentMethodCode->PlaceHolder = RemoveHtml($this->paymentMethodCode->caption());

            // amount
            $this->amount->setupEditAttributes();
            $this->amount->EditCustomAttributes = "";
            $this->amount->EditValue = HtmlEncode($this->amount->CurrentValue);
            $this->amount->PlaceHolder = RemoveHtml($this->amount->caption());
            if (strval($this->amount->EditValue) != "" && is_numeric($this->amount->EditValue)) {
                $this->amount->EditValue = FormatNumber($this->amount->EditValue, null);
            }

            // remark
            $this->remark->setupEditAttributes();
            $this->remark->EditCustomAttributes = "";
            if (!$this->remark->Raw) {
                $this->remark->CurrentValue = HtmlDecode($this->remark->CurrentValue);
            }
            $this->remark->EditValue = HtmlEncode($this->remark->CurrentValue);
            $this->remark->PlaceHolder = RemoveHtml($this->remark->caption());

            // receipt_id
            $this->receipt_id->setupEditAttributes();
            $this->receipt_id->EditCustomAttributes = "";
            if (!$this->receipt_id->Raw) {
                $this->receipt_id->CurrentValue = HtmlDecode($this->receipt_id->CurrentValue);
            }
            $this->receipt_id->EditValue = HtmlEncode($this->receipt_id->CurrentValue);
            $this->receipt_id->PlaceHolder = RemoveHtml($this->receipt_id->caption());

            // receipt_code
            $this->receipt_code->setupEditAttributes();
            $this->receipt_code->EditCustomAttributes = "";
            if (!$this->receipt_code->Raw) {
                $this->receipt_code->CurrentValue = HtmlDecode($this->receipt_code->CurrentValue);
            }
            $this->receipt_code->EditValue = HtmlEncode($this->receipt_code->CurrentValue);
            $this->receipt_code->PlaceHolder = RemoveHtml($this->receipt_code->caption());

            // receipt_status
            $this->receipt_status->setupEditAttributes();
            $this->receipt_status->EditCustomAttributes = "";
            if (!$this->receipt_status->Raw) {
                $this->receipt_status->CurrentValue = HtmlDecode($this->receipt_status->CurrentValue);
            }
            $this->receipt_status->EditValue = HtmlEncode($this->receipt_status->CurrentValue);
            $this->receipt_status->PlaceHolder = RemoveHtml($this->receipt_status->caption());

            // preTaxAmount
            $this->preTaxAmount->setupEditAttributes();
            $this->preTaxAmount->EditCustomAttributes = "";
            $this->preTaxAmount->EditValue = HtmlEncode($this->preTaxAmount->CurrentValue);
            $this->preTaxAmount->PlaceHolder = RemoveHtml($this->preTaxAmount->caption());
            if (strval($this->preTaxAmount->EditValue) != "" && is_numeric($this->preTaxAmount->EditValue)) {
                $this->preTaxAmount->EditValue = FormatNumber($this->preTaxAmount->EditValue, null);
            }

            // vatAmount
            $this->vatAmount->setupEditAttributes();
            $this->vatAmount->EditCustomAttributes = "";
            $this->vatAmount->EditValue = HtmlEncode($this->vatAmount->CurrentValue);
            $this->vatAmount->PlaceHolder = RemoveHtml($this->vatAmount->caption());
            if (strval($this->vatAmount->EditValue) != "" && is_numeric($this->vatAmount->EditValue)) {
                $this->vatAmount->EditValue = FormatNumber($this->vatAmount->EditValue, null);
            }

            // netAmount
            $this->netAmount->setupEditAttributes();
            $this->netAmount->EditCustomAttributes = "";
            $this->netAmount->EditValue = HtmlEncode($this->netAmount->CurrentValue);
            $this->netAmount->PlaceHolder = RemoveHtml($this->netAmount->caption());
            if (strval($this->netAmount->EditValue) != "" && is_numeric($this->netAmount->EditValue)) {
                $this->netAmount->EditValue = FormatNumber($this->netAmount->EditValue, null);
            }

            // whtAmount
            $this->whtAmount->setupEditAttributes();
            $this->whtAmount->EditCustomAttributes = "";
            $this->whtAmount->EditValue = HtmlEncode($this->whtAmount->CurrentValue);
            $this->whtAmount->PlaceHolder = RemoveHtml($this->whtAmount->caption());
            if (strval($this->whtAmount->EditValue) != "" && is_numeric($this->whtAmount->EditValue)) {
                $this->whtAmount->EditValue = FormatNumber($this->whtAmount->EditValue, null);
            }

            // paymentAmount
            $this->paymentAmount->setupEditAttributes();
            $this->paymentAmount->EditCustomAttributes = "";
            $this->paymentAmount->EditValue = HtmlEncode($this->paymentAmount->CurrentValue);
            $this->paymentAmount->PlaceHolder = RemoveHtml($this->paymentAmount->caption());
            if (strval($this->paymentAmount->EditValue) != "" && is_numeric($this->paymentAmount->EditValue)) {
                $this->paymentAmount->EditValue = FormatNumber($this->paymentAmount->EditValue, null);
            }

            // remainAmount
            $this->remainAmount->setupEditAttributes();
            $this->remainAmount->EditCustomAttributes = "";
            $this->remainAmount->EditValue = HtmlEncode($this->remainAmount->CurrentValue);
            $this->remainAmount->PlaceHolder = RemoveHtml($this->remainAmount->caption());
            if (strval($this->remainAmount->EditValue) != "" && is_numeric($this->remainAmount->EditValue)) {
                $this->remainAmount->EditValue = FormatNumber($this->remainAmount->EditValue, null);
            }

            // remainWhtAmount
            $this->remainWhtAmount->setupEditAttributes();
            $this->remainWhtAmount->EditCustomAttributes = "";
            $this->remainWhtAmount->EditValue = HtmlEncode($this->remainWhtAmount->CurrentValue);
            $this->remainWhtAmount->PlaceHolder = RemoveHtml($this->remainWhtAmount->caption());
            if (strval($this->remainWhtAmount->EditValue) != "" && is_numeric($this->remainWhtAmount->EditValue)) {
                $this->remainWhtAmount->EditValue = FormatNumber($this->remainWhtAmount->EditValue, null);
            }

            // onlineViewLink
            $this->onlineViewLink->setupEditAttributes();
            $this->onlineViewLink->EditCustomAttributes = "";
            $this->onlineViewLink->EditValue = HtmlEncode($this->onlineViewLink->CurrentValue);
            $this->onlineViewLink->PlaceHolder = RemoveHtml($this->onlineViewLink->caption());

            // isPartialReceipt
            $this->isPartialReceipt->setupEditAttributes();
            $this->isPartialReceipt->EditCustomAttributes = "";
            $this->isPartialReceipt->EditValue = HtmlEncode($this->isPartialReceipt->CurrentValue);
            $this->isPartialReceipt->PlaceHolder = RemoveHtml($this->isPartialReceipt->caption());
            if (strval($this->isPartialReceipt->EditValue) != "" && is_numeric($this->isPartialReceipt->EditValue)) {
                $this->isPartialReceipt->EditValue = FormatNumber($this->isPartialReceipt->EditValue, null);
            }

            // journals_id
            $this->journals_id->setupEditAttributes();
            $this->journals_id->EditCustomAttributes = "";
            if (!$this->journals_id->Raw) {
                $this->journals_id->CurrentValue = HtmlDecode($this->journals_id->CurrentValue);
            }
            $this->journals_id->EditValue = HtmlEncode($this->journals_id->CurrentValue);
            $this->journals_id->PlaceHolder = RemoveHtml($this->journals_id->caption());

            // journals_code
            $this->journals_code->setupEditAttributes();
            $this->journals_code->EditCustomAttributes = "";
            if (!$this->journals_code->Raw) {
                $this->journals_code->CurrentValue = HtmlDecode($this->journals_code->CurrentValue);
            }
            $this->journals_code->EditValue = HtmlEncode($this->journals_code->CurrentValue);
            $this->journals_code->PlaceHolder = RemoveHtml($this->journals_code->caption());

            // refid
            $this->refid->setupEditAttributes();
            $this->refid->EditCustomAttributes = "";
            $this->refid->EditValue = HtmlEncode($this->refid->CurrentValue);
            $this->refid->PlaceHolder = RemoveHtml($this->refid->caption());
            if (strval($this->refid->EditValue) != "" && is_numeric($this->refid->EditValue)) {
                $this->refid->EditValue = FormatNumber($this->refid->EditValue, null);
            }

            // transition_type
            $this->transition_type->setupEditAttributes();
            $this->transition_type->EditCustomAttributes = "";
            $this->transition_type->EditValue = HtmlEncode($this->transition_type->CurrentValue);
            $this->transition_type->PlaceHolder = RemoveHtml($this->transition_type->caption());
            if (strval($this->transition_type->EditValue) != "" && is_numeric($this->transition_type->EditValue)) {
                $this->transition_type->EditValue = FormatNumber($this->transition_type->EditValue, null);
            }

            // is_email
            $this->is_email->setupEditAttributes();
            $this->is_email->EditCustomAttributes = "";
            $this->is_email->EditValue = HtmlEncode($this->is_email->CurrentValue);
            $this->is_email->PlaceHolder = RemoveHtml($this->is_email->caption());
            if (strval($this->is_email->EditValue) != "" && is_numeric($this->is_email->EditValue)) {
                $this->is_email->EditValue = FormatNumber($this->is_email->EditValue, null);
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

            // issueddate
            $this->issueddate->LinkCustomAttributes = "";
            $this->issueddate->HrefValue = "";

            // duedate
            $this->duedate->LinkCustomAttributes = "";
            $this->duedate->HrefValue = "";

            // contactcode
            $this->contactcode->LinkCustomAttributes = "";
            $this->contactcode->HrefValue = "";

            // tag
            $this->tag->LinkCustomAttributes = "";
            $this->tag->HrefValue = "";

            // istaxinvoice
            $this->istaxinvoice->LinkCustomAttributes = "";
            $this->istaxinvoice->HrefValue = "";

            // taxstatus
            $this->taxstatus->LinkCustomAttributes = "";
            $this->taxstatus->HrefValue = "";

            // paymentdate
            $this->paymentdate->LinkCustomAttributes = "";
            $this->paymentdate->HrefValue = "";

            // paymentmethodid
            $this->paymentmethodid->LinkCustomAttributes = "";
            $this->paymentmethodid->HrefValue = "";

            // paymentMethodCode
            $this->paymentMethodCode->LinkCustomAttributes = "";
            $this->paymentMethodCode->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

            // remark
            $this->remark->LinkCustomAttributes = "";
            $this->remark->HrefValue = "";

            // receipt_id
            $this->receipt_id->LinkCustomAttributes = "";
            $this->receipt_id->HrefValue = "";

            // receipt_code
            $this->receipt_code->LinkCustomAttributes = "";
            $this->receipt_code->HrefValue = "";

            // receipt_status
            $this->receipt_status->LinkCustomAttributes = "";
            $this->receipt_status->HrefValue = "";

            // preTaxAmount
            $this->preTaxAmount->LinkCustomAttributes = "";
            $this->preTaxAmount->HrefValue = "";

            // vatAmount
            $this->vatAmount->LinkCustomAttributes = "";
            $this->vatAmount->HrefValue = "";

            // netAmount
            $this->netAmount->LinkCustomAttributes = "";
            $this->netAmount->HrefValue = "";

            // whtAmount
            $this->whtAmount->LinkCustomAttributes = "";
            $this->whtAmount->HrefValue = "";

            // paymentAmount
            $this->paymentAmount->LinkCustomAttributes = "";
            $this->paymentAmount->HrefValue = "";

            // remainAmount
            $this->remainAmount->LinkCustomAttributes = "";
            $this->remainAmount->HrefValue = "";

            // remainWhtAmount
            $this->remainWhtAmount->LinkCustomAttributes = "";
            $this->remainWhtAmount->HrefValue = "";

            // onlineViewLink
            $this->onlineViewLink->LinkCustomAttributes = "";
            $this->onlineViewLink->HrefValue = "";

            // isPartialReceipt
            $this->isPartialReceipt->LinkCustomAttributes = "";
            $this->isPartialReceipt->HrefValue = "";

            // journals_id
            $this->journals_id->LinkCustomAttributes = "";
            $this->journals_id->HrefValue = "";

            // journals_code
            $this->journals_code->LinkCustomAttributes = "";
            $this->journals_code->HrefValue = "";

            // refid
            $this->refid->LinkCustomAttributes = "";
            $this->refid->HrefValue = "";

            // transition_type
            $this->transition_type->LinkCustomAttributes = "";
            $this->transition_type->HrefValue = "";

            // is_email
            $this->is_email->LinkCustomAttributes = "";
            $this->is_email->HrefValue = "";
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
        if ($this->issueddate->Required) {
            if (!$this->issueddate->IsDetailKey && EmptyValue($this->issueddate->FormValue)) {
                $this->issueddate->addErrorMessage(str_replace("%s", $this->issueddate->caption(), $this->issueddate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->issueddate->FormValue, $this->issueddate->formatPattern())) {
            $this->issueddate->addErrorMessage($this->issueddate->getErrorMessage(false));
        }
        if ($this->duedate->Required) {
            if (!$this->duedate->IsDetailKey && EmptyValue($this->duedate->FormValue)) {
                $this->duedate->addErrorMessage(str_replace("%s", $this->duedate->caption(), $this->duedate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->duedate->FormValue, $this->duedate->formatPattern())) {
            $this->duedate->addErrorMessage($this->duedate->getErrorMessage(false));
        }
        if ($this->contactcode->Required) {
            if (!$this->contactcode->IsDetailKey && EmptyValue($this->contactcode->FormValue)) {
                $this->contactcode->addErrorMessage(str_replace("%s", $this->contactcode->caption(), $this->contactcode->RequiredErrorMessage));
            }
        }
        if ($this->tag->Required) {
            if (!$this->tag->IsDetailKey && EmptyValue($this->tag->FormValue)) {
                $this->tag->addErrorMessage(str_replace("%s", $this->tag->caption(), $this->tag->RequiredErrorMessage));
            }
        }
        if ($this->istaxinvoice->Required) {
            if (!$this->istaxinvoice->IsDetailKey && EmptyValue($this->istaxinvoice->FormValue)) {
                $this->istaxinvoice->addErrorMessage(str_replace("%s", $this->istaxinvoice->caption(), $this->istaxinvoice->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->istaxinvoice->FormValue)) {
            $this->istaxinvoice->addErrorMessage($this->istaxinvoice->getErrorMessage(false));
        }
        if ($this->taxstatus->Required) {
            if (!$this->taxstatus->IsDetailKey && EmptyValue($this->taxstatus->FormValue)) {
                $this->taxstatus->addErrorMessage(str_replace("%s", $this->taxstatus->caption(), $this->taxstatus->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->taxstatus->FormValue)) {
            $this->taxstatus->addErrorMessage($this->taxstatus->getErrorMessage(false));
        }
        if ($this->paymentdate->Required) {
            if (!$this->paymentdate->IsDetailKey && EmptyValue($this->paymentdate->FormValue)) {
                $this->paymentdate->addErrorMessage(str_replace("%s", $this->paymentdate->caption(), $this->paymentdate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->paymentdate->FormValue, $this->paymentdate->formatPattern())) {
            $this->paymentdate->addErrorMessage($this->paymentdate->getErrorMessage(false));
        }
        if ($this->paymentmethodid->Required) {
            if (!$this->paymentmethodid->IsDetailKey && EmptyValue($this->paymentmethodid->FormValue)) {
                $this->paymentmethodid->addErrorMessage(str_replace("%s", $this->paymentmethodid->caption(), $this->paymentmethodid->RequiredErrorMessage));
            }
        }
        if ($this->paymentMethodCode->Required) {
            if (!$this->paymentMethodCode->IsDetailKey && EmptyValue($this->paymentMethodCode->FormValue)) {
                $this->paymentMethodCode->addErrorMessage(str_replace("%s", $this->paymentMethodCode->caption(), $this->paymentMethodCode->RequiredErrorMessage));
            }
        }
        if ($this->amount->Required) {
            if (!$this->amount->IsDetailKey && EmptyValue($this->amount->FormValue)) {
                $this->amount->addErrorMessage(str_replace("%s", $this->amount->caption(), $this->amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->amount->FormValue)) {
            $this->amount->addErrorMessage($this->amount->getErrorMessage(false));
        }
        if ($this->remark->Required) {
            if (!$this->remark->IsDetailKey && EmptyValue($this->remark->FormValue)) {
                $this->remark->addErrorMessage(str_replace("%s", $this->remark->caption(), $this->remark->RequiredErrorMessage));
            }
        }
        if ($this->receipt_id->Required) {
            if (!$this->receipt_id->IsDetailKey && EmptyValue($this->receipt_id->FormValue)) {
                $this->receipt_id->addErrorMessage(str_replace("%s", $this->receipt_id->caption(), $this->receipt_id->RequiredErrorMessage));
            }
        }
        if ($this->receipt_code->Required) {
            if (!$this->receipt_code->IsDetailKey && EmptyValue($this->receipt_code->FormValue)) {
                $this->receipt_code->addErrorMessage(str_replace("%s", $this->receipt_code->caption(), $this->receipt_code->RequiredErrorMessage));
            }
        }
        if ($this->receipt_status->Required) {
            if (!$this->receipt_status->IsDetailKey && EmptyValue($this->receipt_status->FormValue)) {
                $this->receipt_status->addErrorMessage(str_replace("%s", $this->receipt_status->caption(), $this->receipt_status->RequiredErrorMessage));
            }
        }
        if ($this->preTaxAmount->Required) {
            if (!$this->preTaxAmount->IsDetailKey && EmptyValue($this->preTaxAmount->FormValue)) {
                $this->preTaxAmount->addErrorMessage(str_replace("%s", $this->preTaxAmount->caption(), $this->preTaxAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->preTaxAmount->FormValue)) {
            $this->preTaxAmount->addErrorMessage($this->preTaxAmount->getErrorMessage(false));
        }
        if ($this->vatAmount->Required) {
            if (!$this->vatAmount->IsDetailKey && EmptyValue($this->vatAmount->FormValue)) {
                $this->vatAmount->addErrorMessage(str_replace("%s", $this->vatAmount->caption(), $this->vatAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->vatAmount->FormValue)) {
            $this->vatAmount->addErrorMessage($this->vatAmount->getErrorMessage(false));
        }
        if ($this->netAmount->Required) {
            if (!$this->netAmount->IsDetailKey && EmptyValue($this->netAmount->FormValue)) {
                $this->netAmount->addErrorMessage(str_replace("%s", $this->netAmount->caption(), $this->netAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->netAmount->FormValue)) {
            $this->netAmount->addErrorMessage($this->netAmount->getErrorMessage(false));
        }
        if ($this->whtAmount->Required) {
            if (!$this->whtAmount->IsDetailKey && EmptyValue($this->whtAmount->FormValue)) {
                $this->whtAmount->addErrorMessage(str_replace("%s", $this->whtAmount->caption(), $this->whtAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->whtAmount->FormValue)) {
            $this->whtAmount->addErrorMessage($this->whtAmount->getErrorMessage(false));
        }
        if ($this->paymentAmount->Required) {
            if (!$this->paymentAmount->IsDetailKey && EmptyValue($this->paymentAmount->FormValue)) {
                $this->paymentAmount->addErrorMessage(str_replace("%s", $this->paymentAmount->caption(), $this->paymentAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->paymentAmount->FormValue)) {
            $this->paymentAmount->addErrorMessage($this->paymentAmount->getErrorMessage(false));
        }
        if ($this->remainAmount->Required) {
            if (!$this->remainAmount->IsDetailKey && EmptyValue($this->remainAmount->FormValue)) {
                $this->remainAmount->addErrorMessage(str_replace("%s", $this->remainAmount->caption(), $this->remainAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->remainAmount->FormValue)) {
            $this->remainAmount->addErrorMessage($this->remainAmount->getErrorMessage(false));
        }
        if ($this->remainWhtAmount->Required) {
            if (!$this->remainWhtAmount->IsDetailKey && EmptyValue($this->remainWhtAmount->FormValue)) {
                $this->remainWhtAmount->addErrorMessage(str_replace("%s", $this->remainWhtAmount->caption(), $this->remainWhtAmount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->remainWhtAmount->FormValue)) {
            $this->remainWhtAmount->addErrorMessage($this->remainWhtAmount->getErrorMessage(false));
        }
        if ($this->onlineViewLink->Required) {
            if (!$this->onlineViewLink->IsDetailKey && EmptyValue($this->onlineViewLink->FormValue)) {
                $this->onlineViewLink->addErrorMessage(str_replace("%s", $this->onlineViewLink->caption(), $this->onlineViewLink->RequiredErrorMessage));
            }
        }
        if ($this->isPartialReceipt->Required) {
            if (!$this->isPartialReceipt->IsDetailKey && EmptyValue($this->isPartialReceipt->FormValue)) {
                $this->isPartialReceipt->addErrorMessage(str_replace("%s", $this->isPartialReceipt->caption(), $this->isPartialReceipt->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->isPartialReceipt->FormValue)) {
            $this->isPartialReceipt->addErrorMessage($this->isPartialReceipt->getErrorMessage(false));
        }
        if ($this->journals_id->Required) {
            if (!$this->journals_id->IsDetailKey && EmptyValue($this->journals_id->FormValue)) {
                $this->journals_id->addErrorMessage(str_replace("%s", $this->journals_id->caption(), $this->journals_id->RequiredErrorMessage));
            }
        }
        if ($this->journals_code->Required) {
            if (!$this->journals_code->IsDetailKey && EmptyValue($this->journals_code->FormValue)) {
                $this->journals_code->addErrorMessage(str_replace("%s", $this->journals_code->caption(), $this->journals_code->RequiredErrorMessage));
            }
        }
        if ($this->refid->Required) {
            if (!$this->refid->IsDetailKey && EmptyValue($this->refid->FormValue)) {
                $this->refid->addErrorMessage(str_replace("%s", $this->refid->caption(), $this->refid->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->refid->FormValue)) {
            $this->refid->addErrorMessage($this->refid->getErrorMessage(false));
        }
        if ($this->transition_type->Required) {
            if (!$this->transition_type->IsDetailKey && EmptyValue($this->transition_type->FormValue)) {
                $this->transition_type->addErrorMessage(str_replace("%s", $this->transition_type->caption(), $this->transition_type->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->transition_type->FormValue)) {
            $this->transition_type->addErrorMessage($this->transition_type->getErrorMessage(false));
        }
        if ($this->is_email->Required) {
            if (!$this->is_email->IsDetailKey && EmptyValue($this->is_email->FormValue)) {
                $this->is_email->addErrorMessage(str_replace("%s", $this->is_email->caption(), $this->is_email->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->is_email->FormValue)) {
            $this->is_email->addErrorMessage($this->is_email->getErrorMessage(false));
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

        // issueddate
        $this->issueddate->setDbValueDef($rsnew, UnFormatDateTime($this->issueddate->CurrentValue, $this->issueddate->formatPattern()), null, false);

        // duedate
        $this->duedate->setDbValueDef($rsnew, UnFormatDateTime($this->duedate->CurrentValue, $this->duedate->formatPattern()), null, false);

        // contactcode
        $this->contactcode->setDbValueDef($rsnew, $this->contactcode->CurrentValue, null, false);

        // tag
        $this->tag->setDbValueDef($rsnew, $this->tag->CurrentValue, null, false);

        // istaxinvoice
        $this->istaxinvoice->setDbValueDef($rsnew, $this->istaxinvoice->CurrentValue, null, false);

        // taxstatus
        $this->taxstatus->setDbValueDef($rsnew, $this->taxstatus->CurrentValue, null, false);

        // paymentdate
        $this->paymentdate->setDbValueDef($rsnew, UnFormatDateTime($this->paymentdate->CurrentValue, $this->paymentdate->formatPattern()), null, false);

        // paymentmethodid
        $this->paymentmethodid->setDbValueDef($rsnew, $this->paymentmethodid->CurrentValue, null, false);

        // paymentMethodCode
        $this->paymentMethodCode->setDbValueDef($rsnew, $this->paymentMethodCode->CurrentValue, null, false);

        // amount
        $this->amount->setDbValueDef($rsnew, $this->amount->CurrentValue, null, false);

        // remark
        $this->remark->setDbValueDef($rsnew, $this->remark->CurrentValue, null, false);

        // receipt_id
        $this->receipt_id->setDbValueDef($rsnew, $this->receipt_id->CurrentValue, null, false);

        // receipt_code
        $this->receipt_code->setDbValueDef($rsnew, $this->receipt_code->CurrentValue, null, false);

        // receipt_status
        $this->receipt_status->setDbValueDef($rsnew, $this->receipt_status->CurrentValue, null, false);

        // preTaxAmount
        $this->preTaxAmount->setDbValueDef($rsnew, $this->preTaxAmount->CurrentValue, null, false);

        // vatAmount
        $this->vatAmount->setDbValueDef($rsnew, $this->vatAmount->CurrentValue, null, false);

        // netAmount
        $this->netAmount->setDbValueDef($rsnew, $this->netAmount->CurrentValue, null, false);

        // whtAmount
        $this->whtAmount->setDbValueDef($rsnew, $this->whtAmount->CurrentValue, null, false);

        // paymentAmount
        $this->paymentAmount->setDbValueDef($rsnew, $this->paymentAmount->CurrentValue, null, false);

        // remainAmount
        $this->remainAmount->setDbValueDef($rsnew, $this->remainAmount->CurrentValue, null, false);

        // remainWhtAmount
        $this->remainWhtAmount->setDbValueDef($rsnew, $this->remainWhtAmount->CurrentValue, null, false);

        // onlineViewLink
        $this->onlineViewLink->setDbValueDef($rsnew, $this->onlineViewLink->CurrentValue, null, false);

        // isPartialReceipt
        $this->isPartialReceipt->setDbValueDef($rsnew, $this->isPartialReceipt->CurrentValue, null, false);

        // journals_id
        $this->journals_id->setDbValueDef($rsnew, $this->journals_id->CurrentValue, null, false);

        // journals_code
        $this->journals_code->setDbValueDef($rsnew, $this->journals_code->CurrentValue, null, false);

        // refid
        $this->refid->setDbValueDef($rsnew, $this->refid->CurrentValue, null, false);

        // transition_type
        $this->transition_type->setDbValueDef($rsnew, $this->transition_type->CurrentValue, null, false);

        // is_email
        $this->is_email->setDbValueDef($rsnew, $this->is_email->CurrentValue, 0, strval($this->is_email->CurrentValue) == "");

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakreceiptlist"), "", $this->TableVar, true);
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
