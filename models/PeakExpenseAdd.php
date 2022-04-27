<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PeakExpenseAdd extends PeakExpense
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'peak_expense';

    // Page object name
    public $PageObjName = "PeakExpenseAdd";

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

        // Table object (peak_expense)
        if (!isset($GLOBALS["peak_expense"]) || get_class($GLOBALS["peak_expense"]) == PROJECT_NAMESPACE . "peak_expense") {
            $GLOBALS["peak_expense"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'peak_expense');
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
                $tbl = Container("peak_expense");
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
                    if ($pageName == "peakexpenseview") {
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
            $key .= @$ar['peak_expense_id'];
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
            $this->peak_expense_id->Visible = false;
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
        $this->peak_expense_id->Visible = false;
        $this->id->setVisibility();
        $this->code->setVisibility();
        $this->issuedDate->setVisibility();
        $this->dueDate->setVisibility();
        $this->contactId->setVisibility();
        $this->contactCode->setVisibility();
        $this->status->setVisibility();
        $this->isTaxInvoice->setVisibility();
        $this->preTaxAmount->setVisibility();
        $this->vatAmount->setVisibility();
        $this->netAmount->setVisibility();
        $this->whtAmount->setVisibility();
        $this->paymentAmount->setVisibility();
        $this->remainAmount->setVisibility();
        $this->onlineViewLink->setVisibility();
        $this->taxStatus->setVisibility();
        $this->paymentDate->setVisibility();
        $this->withHoldingTaxAmount->setVisibility();
        $this->paymentGroupId->setVisibility();
        $this->paymentTotal->setVisibility();
        $this->paymentMethodId->setVisibility();
        $this->paymentMethodCode->setVisibility();
        $this->amount->setVisibility();
        $this->journals_id->setVisibility();
        $this->journals_code->setVisibility();
        $this->cdate->setVisibility();
        $this->cuser->setVisibility();
        $this->cip->setVisibility();
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->sync_detail_date->setVisibility();
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
            if (($keyValue = Get("peak_expense_id") ?? Route("peak_expense_id")) !== null) {
                $this->peak_expense_id->setQueryStringValue($keyValue);
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
                    $this->terminate("peakexpenselist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "peakexpenselist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "peakexpenseview") {
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
        $this->peak_expense_id->CurrentValue = null;
        $this->peak_expense_id->OldValue = $this->peak_expense_id->CurrentValue;
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->code->CurrentValue = null;
        $this->code->OldValue = $this->code->CurrentValue;
        $this->issuedDate->CurrentValue = null;
        $this->issuedDate->OldValue = $this->issuedDate->CurrentValue;
        $this->dueDate->CurrentValue = null;
        $this->dueDate->OldValue = $this->dueDate->CurrentValue;
        $this->contactId->CurrentValue = null;
        $this->contactId->OldValue = $this->contactId->CurrentValue;
        $this->contactCode->CurrentValue = null;
        $this->contactCode->OldValue = $this->contactCode->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->isTaxInvoice->CurrentValue = null;
        $this->isTaxInvoice->OldValue = $this->isTaxInvoice->CurrentValue;
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
        $this->onlineViewLink->CurrentValue = null;
        $this->onlineViewLink->OldValue = $this->onlineViewLink->CurrentValue;
        $this->taxStatus->CurrentValue = null;
        $this->taxStatus->OldValue = $this->taxStatus->CurrentValue;
        $this->paymentDate->CurrentValue = null;
        $this->paymentDate->OldValue = $this->paymentDate->CurrentValue;
        $this->withHoldingTaxAmount->CurrentValue = null;
        $this->withHoldingTaxAmount->OldValue = $this->withHoldingTaxAmount->CurrentValue;
        $this->paymentGroupId->CurrentValue = null;
        $this->paymentGroupId->OldValue = $this->paymentGroupId->CurrentValue;
        $this->paymentTotal->CurrentValue = null;
        $this->paymentTotal->OldValue = $this->paymentTotal->CurrentValue;
        $this->paymentMethodId->CurrentValue = null;
        $this->paymentMethodId->OldValue = $this->paymentMethodId->CurrentValue;
        $this->paymentMethodCode->CurrentValue = null;
        $this->paymentMethodCode->OldValue = $this->paymentMethodCode->CurrentValue;
        $this->amount->CurrentValue = null;
        $this->amount->OldValue = $this->amount->CurrentValue;
        $this->journals_id->CurrentValue = null;
        $this->journals_id->OldValue = $this->journals_id->CurrentValue;
        $this->journals_code->CurrentValue = null;
        $this->journals_code->OldValue = $this->journals_code->CurrentValue;
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
        $this->sync_detail_date->CurrentValue = null;
        $this->sync_detail_date->OldValue = $this->sync_detail_date->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id->Visible = false; // Disable update for API request
            } else {
                $this->id->setFormValue($val);
            }
        }

        // Check field name 'code' first before field var 'x_code'
        $val = $CurrentForm->hasValue("code") ? $CurrentForm->getValue("code") : $CurrentForm->getValue("x_code");
        if (!$this->code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->code->Visible = false; // Disable update for API request
            } else {
                $this->code->setFormValue($val);
            }
        }

        // Check field name 'issuedDate' first before field var 'x_issuedDate'
        $val = $CurrentForm->hasValue("issuedDate") ? $CurrentForm->getValue("issuedDate") : $CurrentForm->getValue("x_issuedDate");
        if (!$this->issuedDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->issuedDate->Visible = false; // Disable update for API request
            } else {
                $this->issuedDate->setFormValue($val, true, $validate);
            }
            $this->issuedDate->CurrentValue = UnFormatDateTime($this->issuedDate->CurrentValue, $this->issuedDate->formatPattern());
        }

        // Check field name 'dueDate' first before field var 'x_dueDate'
        $val = $CurrentForm->hasValue("dueDate") ? $CurrentForm->getValue("dueDate") : $CurrentForm->getValue("x_dueDate");
        if (!$this->dueDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dueDate->Visible = false; // Disable update for API request
            } else {
                $this->dueDate->setFormValue($val, true, $validate);
            }
            $this->dueDate->CurrentValue = UnFormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern());
        }

        // Check field name 'contactId' first before field var 'x_contactId'
        $val = $CurrentForm->hasValue("contactId") ? $CurrentForm->getValue("contactId") : $CurrentForm->getValue("x_contactId");
        if (!$this->contactId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contactId->Visible = false; // Disable update for API request
            } else {
                $this->contactId->setFormValue($val);
            }
        }

        // Check field name 'contactCode' first before field var 'x_contactCode'
        $val = $CurrentForm->hasValue("contactCode") ? $CurrentForm->getValue("contactCode") : $CurrentForm->getValue("x_contactCode");
        if (!$this->contactCode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contactCode->Visible = false; // Disable update for API request
            } else {
                $this->contactCode->setFormValue($val);
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

        // Check field name 'isTaxInvoice' first before field var 'x_isTaxInvoice'
        $val = $CurrentForm->hasValue("isTaxInvoice") ? $CurrentForm->getValue("isTaxInvoice") : $CurrentForm->getValue("x_isTaxInvoice");
        if (!$this->isTaxInvoice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isTaxInvoice->Visible = false; // Disable update for API request
            } else {
                $this->isTaxInvoice->setFormValue($val, true, $validate);
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

        // Check field name 'onlineViewLink' first before field var 'x_onlineViewLink'
        $val = $CurrentForm->hasValue("onlineViewLink") ? $CurrentForm->getValue("onlineViewLink") : $CurrentForm->getValue("x_onlineViewLink");
        if (!$this->onlineViewLink->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->onlineViewLink->Visible = false; // Disable update for API request
            } else {
                $this->onlineViewLink->setFormValue($val);
            }
        }

        // Check field name 'taxStatus' first before field var 'x_taxStatus'
        $val = $CurrentForm->hasValue("taxStatus") ? $CurrentForm->getValue("taxStatus") : $CurrentForm->getValue("x_taxStatus");
        if (!$this->taxStatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->taxStatus->Visible = false; // Disable update for API request
            } else {
                $this->taxStatus->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'paymentDate' first before field var 'x_paymentDate'
        $val = $CurrentForm->hasValue("paymentDate") ? $CurrentForm->getValue("paymentDate") : $CurrentForm->getValue("x_paymentDate");
        if (!$this->paymentDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentDate->Visible = false; // Disable update for API request
            } else {
                $this->paymentDate->setFormValue($val, true, $validate);
            }
            $this->paymentDate->CurrentValue = UnFormatDateTime($this->paymentDate->CurrentValue, $this->paymentDate->formatPattern());
        }

        // Check field name 'withHoldingTaxAmount' first before field var 'x_withHoldingTaxAmount'
        $val = $CurrentForm->hasValue("withHoldingTaxAmount") ? $CurrentForm->getValue("withHoldingTaxAmount") : $CurrentForm->getValue("x_withHoldingTaxAmount");
        if (!$this->withHoldingTaxAmount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->withHoldingTaxAmount->Visible = false; // Disable update for API request
            } else {
                $this->withHoldingTaxAmount->setFormValue($val);
            }
        }

        // Check field name 'paymentGroupId' first before field var 'x_paymentGroupId'
        $val = $CurrentForm->hasValue("paymentGroupId") ? $CurrentForm->getValue("paymentGroupId") : $CurrentForm->getValue("x_paymentGroupId");
        if (!$this->paymentGroupId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentGroupId->Visible = false; // Disable update for API request
            } else {
                $this->paymentGroupId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'paymentTotal' first before field var 'x_paymentTotal'
        $val = $CurrentForm->hasValue("paymentTotal") ? $CurrentForm->getValue("paymentTotal") : $CurrentForm->getValue("x_paymentTotal");
        if (!$this->paymentTotal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentTotal->Visible = false; // Disable update for API request
            } else {
                $this->paymentTotal->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'paymentMethodId' first before field var 'x_paymentMethodId'
        $val = $CurrentForm->hasValue("paymentMethodId") ? $CurrentForm->getValue("paymentMethodId") : $CurrentForm->getValue("x_paymentMethodId");
        if (!$this->paymentMethodId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentMethodId->Visible = false; // Disable update for API request
            } else {
                $this->paymentMethodId->setFormValue($val);
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

        // Check field name 'sync_detail_date' first before field var 'x_sync_detail_date'
        $val = $CurrentForm->hasValue("sync_detail_date") ? $CurrentForm->getValue("sync_detail_date") : $CurrentForm->getValue("x_sync_detail_date");
        if (!$this->sync_detail_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sync_detail_date->Visible = false; // Disable update for API request
            } else {
                $this->sync_detail_date->setFormValue($val, true, $validate);
            }
            $this->sync_detail_date->CurrentValue = UnFormatDateTime($this->sync_detail_date->CurrentValue, $this->sync_detail_date->formatPattern());
        }

        // Check field name 'peak_expense_id' first before field var 'x_peak_expense_id'
        $val = $CurrentForm->hasValue("peak_expense_id") ? $CurrentForm->getValue("peak_expense_id") : $CurrentForm->getValue("x_peak_expense_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->code->CurrentValue = $this->code->FormValue;
        $this->issuedDate->CurrentValue = $this->issuedDate->FormValue;
        $this->issuedDate->CurrentValue = UnFormatDateTime($this->issuedDate->CurrentValue, $this->issuedDate->formatPattern());
        $this->dueDate->CurrentValue = $this->dueDate->FormValue;
        $this->dueDate->CurrentValue = UnFormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern());
        $this->contactId->CurrentValue = $this->contactId->FormValue;
        $this->contactCode->CurrentValue = $this->contactCode->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->isTaxInvoice->CurrentValue = $this->isTaxInvoice->FormValue;
        $this->preTaxAmount->CurrentValue = $this->preTaxAmount->FormValue;
        $this->vatAmount->CurrentValue = $this->vatAmount->FormValue;
        $this->netAmount->CurrentValue = $this->netAmount->FormValue;
        $this->whtAmount->CurrentValue = $this->whtAmount->FormValue;
        $this->paymentAmount->CurrentValue = $this->paymentAmount->FormValue;
        $this->remainAmount->CurrentValue = $this->remainAmount->FormValue;
        $this->onlineViewLink->CurrentValue = $this->onlineViewLink->FormValue;
        $this->taxStatus->CurrentValue = $this->taxStatus->FormValue;
        $this->paymentDate->CurrentValue = $this->paymentDate->FormValue;
        $this->paymentDate->CurrentValue = UnFormatDateTime($this->paymentDate->CurrentValue, $this->paymentDate->formatPattern());
        $this->withHoldingTaxAmount->CurrentValue = $this->withHoldingTaxAmount->FormValue;
        $this->paymentGroupId->CurrentValue = $this->paymentGroupId->FormValue;
        $this->paymentTotal->CurrentValue = $this->paymentTotal->FormValue;
        $this->paymentMethodId->CurrentValue = $this->paymentMethodId->FormValue;
        $this->paymentMethodCode->CurrentValue = $this->paymentMethodCode->FormValue;
        $this->amount->CurrentValue = $this->amount->FormValue;
        $this->journals_id->CurrentValue = $this->journals_id->FormValue;
        $this->journals_code->CurrentValue = $this->journals_code->FormValue;
        $this->cdate->CurrentValue = $this->cdate->FormValue;
        $this->cdate->CurrentValue = UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern());
        $this->cuser->CurrentValue = $this->cuser->FormValue;
        $this->cip->CurrentValue = $this->cip->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->sync_detail_date->CurrentValue = $this->sync_detail_date->FormValue;
        $this->sync_detail_date->CurrentValue = UnFormatDateTime($this->sync_detail_date->CurrentValue, $this->sync_detail_date->formatPattern());
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
        $this->peak_expense_id->setDbValue($row['peak_expense_id']);
        $this->id->setDbValue($row['id']);
        $this->code->setDbValue($row['code']);
        $this->issuedDate->setDbValue($row['issuedDate']);
        $this->dueDate->setDbValue($row['dueDate']);
        $this->contactId->setDbValue($row['contactId']);
        $this->contactCode->setDbValue($row['contactCode']);
        $this->status->setDbValue($row['status']);
        $this->isTaxInvoice->setDbValue($row['isTaxInvoice']);
        $this->preTaxAmount->setDbValue($row['preTaxAmount']);
        $this->vatAmount->setDbValue($row['vatAmount']);
        $this->netAmount->setDbValue($row['netAmount']);
        $this->whtAmount->setDbValue($row['whtAmount']);
        $this->paymentAmount->setDbValue($row['paymentAmount']);
        $this->remainAmount->setDbValue($row['remainAmount']);
        $this->onlineViewLink->setDbValue($row['onlineViewLink']);
        $this->taxStatus->setDbValue($row['taxStatus']);
        $this->paymentDate->setDbValue($row['paymentDate']);
        $this->withHoldingTaxAmount->setDbValue($row['withHoldingTaxAmount']);
        $this->paymentGroupId->setDbValue($row['paymentGroupId']);
        $this->paymentTotal->setDbValue($row['paymentTotal']);
        $this->paymentMethodId->setDbValue($row['paymentMethodId']);
        $this->paymentMethodCode->setDbValue($row['paymentMethodCode']);
        $this->amount->setDbValue($row['amount']);
        $this->journals_id->setDbValue($row['journals_id']);
        $this->journals_code->setDbValue($row['journals_code']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->cip->setDbValue($row['cip']);
        $this->udate->setDbValue($row['udate']);
        $this->uuser->setDbValue($row['uuser']);
        $this->uip->setDbValue($row['uip']);
        $this->sync_detail_date->setDbValue($row['sync_detail_date']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['peak_expense_id'] = $this->peak_expense_id->CurrentValue;
        $row['id'] = $this->id->CurrentValue;
        $row['code'] = $this->code->CurrentValue;
        $row['issuedDate'] = $this->issuedDate->CurrentValue;
        $row['dueDate'] = $this->dueDate->CurrentValue;
        $row['contactId'] = $this->contactId->CurrentValue;
        $row['contactCode'] = $this->contactCode->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['isTaxInvoice'] = $this->isTaxInvoice->CurrentValue;
        $row['preTaxAmount'] = $this->preTaxAmount->CurrentValue;
        $row['vatAmount'] = $this->vatAmount->CurrentValue;
        $row['netAmount'] = $this->netAmount->CurrentValue;
        $row['whtAmount'] = $this->whtAmount->CurrentValue;
        $row['paymentAmount'] = $this->paymentAmount->CurrentValue;
        $row['remainAmount'] = $this->remainAmount->CurrentValue;
        $row['onlineViewLink'] = $this->onlineViewLink->CurrentValue;
        $row['taxStatus'] = $this->taxStatus->CurrentValue;
        $row['paymentDate'] = $this->paymentDate->CurrentValue;
        $row['withHoldingTaxAmount'] = $this->withHoldingTaxAmount->CurrentValue;
        $row['paymentGroupId'] = $this->paymentGroupId->CurrentValue;
        $row['paymentTotal'] = $this->paymentTotal->CurrentValue;
        $row['paymentMethodId'] = $this->paymentMethodId->CurrentValue;
        $row['paymentMethodCode'] = $this->paymentMethodCode->CurrentValue;
        $row['amount'] = $this->amount->CurrentValue;
        $row['journals_id'] = $this->journals_id->CurrentValue;
        $row['journals_code'] = $this->journals_code->CurrentValue;
        $row['cdate'] = $this->cdate->CurrentValue;
        $row['cuser'] = $this->cuser->CurrentValue;
        $row['cip'] = $this->cip->CurrentValue;
        $row['udate'] = $this->udate->CurrentValue;
        $row['uuser'] = $this->uuser->CurrentValue;
        $row['uip'] = $this->uip->CurrentValue;
        $row['sync_detail_date'] = $this->sync_detail_date->CurrentValue;
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

        // peak_expense_id
        $this->peak_expense_id->RowCssClass = "row";

        // id
        $this->id->RowCssClass = "row";

        // code
        $this->code->RowCssClass = "row";

        // issuedDate
        $this->issuedDate->RowCssClass = "row";

        // dueDate
        $this->dueDate->RowCssClass = "row";

        // contactId
        $this->contactId->RowCssClass = "row";

        // contactCode
        $this->contactCode->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // isTaxInvoice
        $this->isTaxInvoice->RowCssClass = "row";

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

        // onlineViewLink
        $this->onlineViewLink->RowCssClass = "row";

        // taxStatus
        $this->taxStatus->RowCssClass = "row";

        // paymentDate
        $this->paymentDate->RowCssClass = "row";

        // withHoldingTaxAmount
        $this->withHoldingTaxAmount->RowCssClass = "row";

        // paymentGroupId
        $this->paymentGroupId->RowCssClass = "row";

        // paymentTotal
        $this->paymentTotal->RowCssClass = "row";

        // paymentMethodId
        $this->paymentMethodId->RowCssClass = "row";

        // paymentMethodCode
        $this->paymentMethodCode->RowCssClass = "row";

        // amount
        $this->amount->RowCssClass = "row";

        // journals_id
        $this->journals_id->RowCssClass = "row";

        // journals_code
        $this->journals_code->RowCssClass = "row";

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

        // sync_detail_date
        $this->sync_detail_date->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // peak_expense_id
            $this->peak_expense_id->ViewValue = $this->peak_expense_id->CurrentValue;
            $this->peak_expense_id->ViewCustomAttributes = "";

            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // code
            $this->code->ViewValue = $this->code->CurrentValue;
            $this->code->ViewCustomAttributes = "";

            // issuedDate
            $this->issuedDate->ViewValue = $this->issuedDate->CurrentValue;
            $this->issuedDate->ViewValue = FormatDateTime($this->issuedDate->ViewValue, $this->issuedDate->formatPattern());
            $this->issuedDate->ViewCustomAttributes = "";

            // dueDate
            $this->dueDate->ViewValue = $this->dueDate->CurrentValue;
            $this->dueDate->ViewValue = FormatDateTime($this->dueDate->ViewValue, $this->dueDate->formatPattern());
            $this->dueDate->ViewCustomAttributes = "";

            // contactId
            $this->contactId->ViewValue = $this->contactId->CurrentValue;
            $this->contactId->ViewCustomAttributes = "";

            // contactCode
            $this->contactCode->ViewValue = $this->contactCode->CurrentValue;
            $this->contactCode->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // isTaxInvoice
            $this->isTaxInvoice->ViewValue = $this->isTaxInvoice->CurrentValue;
            $this->isTaxInvoice->ViewValue = FormatNumber($this->isTaxInvoice->ViewValue, $this->isTaxInvoice->formatPattern());
            $this->isTaxInvoice->ViewCustomAttributes = "";

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

            // onlineViewLink
            $this->onlineViewLink->ViewValue = $this->onlineViewLink->CurrentValue;
            $this->onlineViewLink->ViewCustomAttributes = "";

            // taxStatus
            $this->taxStatus->ViewValue = $this->taxStatus->CurrentValue;
            $this->taxStatus->ViewValue = FormatNumber($this->taxStatus->ViewValue, $this->taxStatus->formatPattern());
            $this->taxStatus->ViewCustomAttributes = "";

            // paymentDate
            $this->paymentDate->ViewValue = $this->paymentDate->CurrentValue;
            $this->paymentDate->ViewValue = FormatDateTime($this->paymentDate->ViewValue, $this->paymentDate->formatPattern());
            $this->paymentDate->ViewCustomAttributes = "";

            // withHoldingTaxAmount
            $this->withHoldingTaxAmount->ViewValue = $this->withHoldingTaxAmount->CurrentValue;
            $this->withHoldingTaxAmount->ViewCustomAttributes = "";

            // paymentGroupId
            $this->paymentGroupId->ViewValue = $this->paymentGroupId->CurrentValue;
            $this->paymentGroupId->ViewValue = FormatNumber($this->paymentGroupId->ViewValue, $this->paymentGroupId->formatPattern());
            $this->paymentGroupId->ViewCustomAttributes = "";

            // paymentTotal
            $this->paymentTotal->ViewValue = $this->paymentTotal->CurrentValue;
            $this->paymentTotal->ViewValue = FormatNumber($this->paymentTotal->ViewValue, $this->paymentTotal->formatPattern());
            $this->paymentTotal->ViewCustomAttributes = "";

            // paymentMethodId
            $this->paymentMethodId->ViewValue = $this->paymentMethodId->CurrentValue;
            $this->paymentMethodId->ViewCustomAttributes = "";

            // paymentMethodCode
            $this->paymentMethodCode->ViewValue = $this->paymentMethodCode->CurrentValue;
            $this->paymentMethodCode->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

            // journals_id
            $this->journals_id->ViewValue = $this->journals_id->CurrentValue;
            $this->journals_id->ViewCustomAttributes = "";

            // journals_code
            $this->journals_code->ViewValue = $this->journals_code->CurrentValue;
            $this->journals_code->ViewCustomAttributes = "";

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

            // sync_detail_date
            $this->sync_detail_date->ViewValue = $this->sync_detail_date->CurrentValue;
            $this->sync_detail_date->ViewValue = FormatDateTime($this->sync_detail_date->ViewValue, $this->sync_detail_date->formatPattern());
            $this->sync_detail_date->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // code
            $this->code->LinkCustomAttributes = "";
            $this->code->HrefValue = "";

            // issuedDate
            $this->issuedDate->LinkCustomAttributes = "";
            $this->issuedDate->HrefValue = "";

            // dueDate
            $this->dueDate->LinkCustomAttributes = "";
            $this->dueDate->HrefValue = "";

            // contactId
            $this->contactId->LinkCustomAttributes = "";
            $this->contactId->HrefValue = "";

            // contactCode
            $this->contactCode->LinkCustomAttributes = "";
            $this->contactCode->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // isTaxInvoice
            $this->isTaxInvoice->LinkCustomAttributes = "";
            $this->isTaxInvoice->HrefValue = "";

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

            // onlineViewLink
            $this->onlineViewLink->LinkCustomAttributes = "";
            $this->onlineViewLink->HrefValue = "";

            // taxStatus
            $this->taxStatus->LinkCustomAttributes = "";
            $this->taxStatus->HrefValue = "";

            // paymentDate
            $this->paymentDate->LinkCustomAttributes = "";
            $this->paymentDate->HrefValue = "";

            // withHoldingTaxAmount
            $this->withHoldingTaxAmount->LinkCustomAttributes = "";
            $this->withHoldingTaxAmount->HrefValue = "";

            // paymentGroupId
            $this->paymentGroupId->LinkCustomAttributes = "";
            $this->paymentGroupId->HrefValue = "";

            // paymentTotal
            $this->paymentTotal->LinkCustomAttributes = "";
            $this->paymentTotal->HrefValue = "";

            // paymentMethodId
            $this->paymentMethodId->LinkCustomAttributes = "";
            $this->paymentMethodId->HrefValue = "";

            // paymentMethodCode
            $this->paymentMethodCode->LinkCustomAttributes = "";
            $this->paymentMethodCode->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

            // journals_id
            $this->journals_id->LinkCustomAttributes = "";
            $this->journals_id->HrefValue = "";

            // journals_code
            $this->journals_code->LinkCustomAttributes = "";
            $this->journals_code->HrefValue = "";

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

            // sync_detail_date
            $this->sync_detail_date->LinkCustomAttributes = "";
            $this->sync_detail_date->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            if (!$this->id->Raw) {
                $this->id->CurrentValue = HtmlDecode($this->id->CurrentValue);
            }
            $this->id->EditValue = HtmlEncode($this->id->CurrentValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // code
            $this->code->setupEditAttributes();
            $this->code->EditCustomAttributes = "";
            if (!$this->code->Raw) {
                $this->code->CurrentValue = HtmlDecode($this->code->CurrentValue);
            }
            $this->code->EditValue = HtmlEncode($this->code->CurrentValue);
            $this->code->PlaceHolder = RemoveHtml($this->code->caption());

            // issuedDate
            $this->issuedDate->setupEditAttributes();
            $this->issuedDate->EditCustomAttributes = "";
            $this->issuedDate->EditValue = HtmlEncode(FormatDateTime($this->issuedDate->CurrentValue, $this->issuedDate->formatPattern()));
            $this->issuedDate->PlaceHolder = RemoveHtml($this->issuedDate->caption());

            // dueDate
            $this->dueDate->setupEditAttributes();
            $this->dueDate->EditCustomAttributes = "";
            $this->dueDate->EditValue = HtmlEncode(FormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern()));
            $this->dueDate->PlaceHolder = RemoveHtml($this->dueDate->caption());

            // contactId
            $this->contactId->setupEditAttributes();
            $this->contactId->EditCustomAttributes = "";
            if (!$this->contactId->Raw) {
                $this->contactId->CurrentValue = HtmlDecode($this->contactId->CurrentValue);
            }
            $this->contactId->EditValue = HtmlEncode($this->contactId->CurrentValue);
            $this->contactId->PlaceHolder = RemoveHtml($this->contactId->caption());

            // contactCode
            $this->contactCode->setupEditAttributes();
            $this->contactCode->EditCustomAttributes = "";
            if (!$this->contactCode->Raw) {
                $this->contactCode->CurrentValue = HtmlDecode($this->contactCode->CurrentValue);
            }
            $this->contactCode->EditValue = HtmlEncode($this->contactCode->CurrentValue);
            $this->contactCode->PlaceHolder = RemoveHtml($this->contactCode->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // isTaxInvoice
            $this->isTaxInvoice->setupEditAttributes();
            $this->isTaxInvoice->EditCustomAttributes = "";
            $this->isTaxInvoice->EditValue = HtmlEncode($this->isTaxInvoice->CurrentValue);
            $this->isTaxInvoice->PlaceHolder = RemoveHtml($this->isTaxInvoice->caption());
            if (strval($this->isTaxInvoice->EditValue) != "" && is_numeric($this->isTaxInvoice->EditValue)) {
                $this->isTaxInvoice->EditValue = FormatNumber($this->isTaxInvoice->EditValue, null);
            }

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

            // onlineViewLink
            $this->onlineViewLink->setupEditAttributes();
            $this->onlineViewLink->EditCustomAttributes = "";
            $this->onlineViewLink->EditValue = HtmlEncode($this->onlineViewLink->CurrentValue);
            $this->onlineViewLink->PlaceHolder = RemoveHtml($this->onlineViewLink->caption());

            // taxStatus
            $this->taxStatus->setupEditAttributes();
            $this->taxStatus->EditCustomAttributes = "";
            $this->taxStatus->EditValue = HtmlEncode($this->taxStatus->CurrentValue);
            $this->taxStatus->PlaceHolder = RemoveHtml($this->taxStatus->caption());
            if (strval($this->taxStatus->EditValue) != "" && is_numeric($this->taxStatus->EditValue)) {
                $this->taxStatus->EditValue = FormatNumber($this->taxStatus->EditValue, null);
            }

            // paymentDate
            $this->paymentDate->setupEditAttributes();
            $this->paymentDate->EditCustomAttributes = "";
            $this->paymentDate->EditValue = HtmlEncode(FormatDateTime($this->paymentDate->CurrentValue, $this->paymentDate->formatPattern()));
            $this->paymentDate->PlaceHolder = RemoveHtml($this->paymentDate->caption());

            // withHoldingTaxAmount
            $this->withHoldingTaxAmount->setupEditAttributes();
            $this->withHoldingTaxAmount->EditCustomAttributes = "";
            if (!$this->withHoldingTaxAmount->Raw) {
                $this->withHoldingTaxAmount->CurrentValue = HtmlDecode($this->withHoldingTaxAmount->CurrentValue);
            }
            $this->withHoldingTaxAmount->EditValue = HtmlEncode($this->withHoldingTaxAmount->CurrentValue);
            $this->withHoldingTaxAmount->PlaceHolder = RemoveHtml($this->withHoldingTaxAmount->caption());

            // paymentGroupId
            $this->paymentGroupId->setupEditAttributes();
            $this->paymentGroupId->EditCustomAttributes = "";
            $this->paymentGroupId->EditValue = HtmlEncode($this->paymentGroupId->CurrentValue);
            $this->paymentGroupId->PlaceHolder = RemoveHtml($this->paymentGroupId->caption());
            if (strval($this->paymentGroupId->EditValue) != "" && is_numeric($this->paymentGroupId->EditValue)) {
                $this->paymentGroupId->EditValue = FormatNumber($this->paymentGroupId->EditValue, null);
            }

            // paymentTotal
            $this->paymentTotal->setupEditAttributes();
            $this->paymentTotal->EditCustomAttributes = "";
            $this->paymentTotal->EditValue = HtmlEncode($this->paymentTotal->CurrentValue);
            $this->paymentTotal->PlaceHolder = RemoveHtml($this->paymentTotal->caption());
            if (strval($this->paymentTotal->EditValue) != "" && is_numeric($this->paymentTotal->EditValue)) {
                $this->paymentTotal->EditValue = FormatNumber($this->paymentTotal->EditValue, null);
            }

            // paymentMethodId
            $this->paymentMethodId->setupEditAttributes();
            $this->paymentMethodId->EditCustomAttributes = "";
            if (!$this->paymentMethodId->Raw) {
                $this->paymentMethodId->CurrentValue = HtmlDecode($this->paymentMethodId->CurrentValue);
            }
            $this->paymentMethodId->EditValue = HtmlEncode($this->paymentMethodId->CurrentValue);
            $this->paymentMethodId->PlaceHolder = RemoveHtml($this->paymentMethodId->caption());

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

            // sync_detail_date
            $this->sync_detail_date->setupEditAttributes();
            $this->sync_detail_date->EditCustomAttributes = "";
            $this->sync_detail_date->EditValue = HtmlEncode(FormatDateTime($this->sync_detail_date->CurrentValue, $this->sync_detail_date->formatPattern()));
            $this->sync_detail_date->PlaceHolder = RemoveHtml($this->sync_detail_date->caption());

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // code
            $this->code->LinkCustomAttributes = "";
            $this->code->HrefValue = "";

            // issuedDate
            $this->issuedDate->LinkCustomAttributes = "";
            $this->issuedDate->HrefValue = "";

            // dueDate
            $this->dueDate->LinkCustomAttributes = "";
            $this->dueDate->HrefValue = "";

            // contactId
            $this->contactId->LinkCustomAttributes = "";
            $this->contactId->HrefValue = "";

            // contactCode
            $this->contactCode->LinkCustomAttributes = "";
            $this->contactCode->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // isTaxInvoice
            $this->isTaxInvoice->LinkCustomAttributes = "";
            $this->isTaxInvoice->HrefValue = "";

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

            // onlineViewLink
            $this->onlineViewLink->LinkCustomAttributes = "";
            $this->onlineViewLink->HrefValue = "";

            // taxStatus
            $this->taxStatus->LinkCustomAttributes = "";
            $this->taxStatus->HrefValue = "";

            // paymentDate
            $this->paymentDate->LinkCustomAttributes = "";
            $this->paymentDate->HrefValue = "";

            // withHoldingTaxAmount
            $this->withHoldingTaxAmount->LinkCustomAttributes = "";
            $this->withHoldingTaxAmount->HrefValue = "";

            // paymentGroupId
            $this->paymentGroupId->LinkCustomAttributes = "";
            $this->paymentGroupId->HrefValue = "";

            // paymentTotal
            $this->paymentTotal->LinkCustomAttributes = "";
            $this->paymentTotal->HrefValue = "";

            // paymentMethodId
            $this->paymentMethodId->LinkCustomAttributes = "";
            $this->paymentMethodId->HrefValue = "";

            // paymentMethodCode
            $this->paymentMethodCode->LinkCustomAttributes = "";
            $this->paymentMethodCode->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

            // journals_id
            $this->journals_id->LinkCustomAttributes = "";
            $this->journals_id->HrefValue = "";

            // journals_code
            $this->journals_code->LinkCustomAttributes = "";
            $this->journals_code->HrefValue = "";

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

            // sync_detail_date
            $this->sync_detail_date->LinkCustomAttributes = "";
            $this->sync_detail_date->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->code->Required) {
            if (!$this->code->IsDetailKey && EmptyValue($this->code->FormValue)) {
                $this->code->addErrorMessage(str_replace("%s", $this->code->caption(), $this->code->RequiredErrorMessage));
            }
        }
        if ($this->issuedDate->Required) {
            if (!$this->issuedDate->IsDetailKey && EmptyValue($this->issuedDate->FormValue)) {
                $this->issuedDate->addErrorMessage(str_replace("%s", $this->issuedDate->caption(), $this->issuedDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->issuedDate->FormValue, $this->issuedDate->formatPattern())) {
            $this->issuedDate->addErrorMessage($this->issuedDate->getErrorMessage(false));
        }
        if ($this->dueDate->Required) {
            if (!$this->dueDate->IsDetailKey && EmptyValue($this->dueDate->FormValue)) {
                $this->dueDate->addErrorMessage(str_replace("%s", $this->dueDate->caption(), $this->dueDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dueDate->FormValue, $this->dueDate->formatPattern())) {
            $this->dueDate->addErrorMessage($this->dueDate->getErrorMessage(false));
        }
        if ($this->contactId->Required) {
            if (!$this->contactId->IsDetailKey && EmptyValue($this->contactId->FormValue)) {
                $this->contactId->addErrorMessage(str_replace("%s", $this->contactId->caption(), $this->contactId->RequiredErrorMessage));
            }
        }
        if ($this->contactCode->Required) {
            if (!$this->contactCode->IsDetailKey && EmptyValue($this->contactCode->FormValue)) {
                $this->contactCode->addErrorMessage(str_replace("%s", $this->contactCode->caption(), $this->contactCode->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->isTaxInvoice->Required) {
            if (!$this->isTaxInvoice->IsDetailKey && EmptyValue($this->isTaxInvoice->FormValue)) {
                $this->isTaxInvoice->addErrorMessage(str_replace("%s", $this->isTaxInvoice->caption(), $this->isTaxInvoice->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->isTaxInvoice->FormValue)) {
            $this->isTaxInvoice->addErrorMessage($this->isTaxInvoice->getErrorMessage(false));
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
        if ($this->onlineViewLink->Required) {
            if (!$this->onlineViewLink->IsDetailKey && EmptyValue($this->onlineViewLink->FormValue)) {
                $this->onlineViewLink->addErrorMessage(str_replace("%s", $this->onlineViewLink->caption(), $this->onlineViewLink->RequiredErrorMessage));
            }
        }
        if ($this->taxStatus->Required) {
            if (!$this->taxStatus->IsDetailKey && EmptyValue($this->taxStatus->FormValue)) {
                $this->taxStatus->addErrorMessage(str_replace("%s", $this->taxStatus->caption(), $this->taxStatus->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->taxStatus->FormValue)) {
            $this->taxStatus->addErrorMessage($this->taxStatus->getErrorMessage(false));
        }
        if ($this->paymentDate->Required) {
            if (!$this->paymentDate->IsDetailKey && EmptyValue($this->paymentDate->FormValue)) {
                $this->paymentDate->addErrorMessage(str_replace("%s", $this->paymentDate->caption(), $this->paymentDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->paymentDate->FormValue, $this->paymentDate->formatPattern())) {
            $this->paymentDate->addErrorMessage($this->paymentDate->getErrorMessage(false));
        }
        if ($this->withHoldingTaxAmount->Required) {
            if (!$this->withHoldingTaxAmount->IsDetailKey && EmptyValue($this->withHoldingTaxAmount->FormValue)) {
                $this->withHoldingTaxAmount->addErrorMessage(str_replace("%s", $this->withHoldingTaxAmount->caption(), $this->withHoldingTaxAmount->RequiredErrorMessage));
            }
        }
        if ($this->paymentGroupId->Required) {
            if (!$this->paymentGroupId->IsDetailKey && EmptyValue($this->paymentGroupId->FormValue)) {
                $this->paymentGroupId->addErrorMessage(str_replace("%s", $this->paymentGroupId->caption(), $this->paymentGroupId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->paymentGroupId->FormValue)) {
            $this->paymentGroupId->addErrorMessage($this->paymentGroupId->getErrorMessage(false));
        }
        if ($this->paymentTotal->Required) {
            if (!$this->paymentTotal->IsDetailKey && EmptyValue($this->paymentTotal->FormValue)) {
                $this->paymentTotal->addErrorMessage(str_replace("%s", $this->paymentTotal->caption(), $this->paymentTotal->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->paymentTotal->FormValue)) {
            $this->paymentTotal->addErrorMessage($this->paymentTotal->getErrorMessage(false));
        }
        if ($this->paymentMethodId->Required) {
            if (!$this->paymentMethodId->IsDetailKey && EmptyValue($this->paymentMethodId->FormValue)) {
                $this->paymentMethodId->addErrorMessage(str_replace("%s", $this->paymentMethodId->caption(), $this->paymentMethodId->RequiredErrorMessage));
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
        if ($this->sync_detail_date->Required) {
            if (!$this->sync_detail_date->IsDetailKey && EmptyValue($this->sync_detail_date->FormValue)) {
                $this->sync_detail_date->addErrorMessage(str_replace("%s", $this->sync_detail_date->caption(), $this->sync_detail_date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->sync_detail_date->FormValue, $this->sync_detail_date->formatPattern())) {
            $this->sync_detail_date->addErrorMessage($this->sync_detail_date->getErrorMessage(false));
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

        // id
        $this->id->setDbValueDef($rsnew, $this->id->CurrentValue, "", false);

        // code
        $this->code->setDbValueDef($rsnew, $this->code->CurrentValue, "", false);

        // issuedDate
        $this->issuedDate->setDbValueDef($rsnew, UnFormatDateTime($this->issuedDate->CurrentValue, $this->issuedDate->formatPattern()), null, false);

        // dueDate
        $this->dueDate->setDbValueDef($rsnew, UnFormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern()), null, false);

        // contactId
        $this->contactId->setDbValueDef($rsnew, $this->contactId->CurrentValue, null, false);

        // contactCode
        $this->contactCode->setDbValueDef($rsnew, $this->contactCode->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

        // isTaxInvoice
        $this->isTaxInvoice->setDbValueDef($rsnew, $this->isTaxInvoice->CurrentValue, null, false);

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

        // onlineViewLink
        $this->onlineViewLink->setDbValueDef($rsnew, $this->onlineViewLink->CurrentValue, null, false);

        // taxStatus
        $this->taxStatus->setDbValueDef($rsnew, $this->taxStatus->CurrentValue, null, false);

        // paymentDate
        $this->paymentDate->setDbValueDef($rsnew, UnFormatDateTime($this->paymentDate->CurrentValue, $this->paymentDate->formatPattern()), null, false);

        // withHoldingTaxAmount
        $this->withHoldingTaxAmount->setDbValueDef($rsnew, $this->withHoldingTaxAmount->CurrentValue, null, false);

        // paymentGroupId
        $this->paymentGroupId->setDbValueDef($rsnew, $this->paymentGroupId->CurrentValue, null, false);

        // paymentTotal
        $this->paymentTotal->setDbValueDef($rsnew, $this->paymentTotal->CurrentValue, null, false);

        // paymentMethodId
        $this->paymentMethodId->setDbValueDef($rsnew, $this->paymentMethodId->CurrentValue, null, false);

        // paymentMethodCode
        $this->paymentMethodCode->setDbValueDef($rsnew, $this->paymentMethodCode->CurrentValue, null, false);

        // amount
        $this->amount->setDbValueDef($rsnew, $this->amount->CurrentValue, null, false);

        // journals_id
        $this->journals_id->setDbValueDef($rsnew, $this->journals_id->CurrentValue, null, false);

        // journals_code
        $this->journals_code->setDbValueDef($rsnew, $this->journals_code->CurrentValue, null, false);

        // cdate
        $this->cdate->setDbValueDef($rsnew, UnFormatDateTime($this->cdate->CurrentValue, $this->cdate->formatPattern()), null, false);

        // cuser
        $this->cuser->setDbValueDef($rsnew, $this->cuser->CurrentValue, null, false);

        // cip
        $this->cip->setDbValueDef($rsnew, $this->cip->CurrentValue, null, false);

        // udate
        $this->udate->setDbValueDef($rsnew, UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern()), null, false);

        // uuser
        $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null, false);

        // uip
        $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null, false);

        // sync_detail_date
        $this->sync_detail_date->setDbValueDef($rsnew, UnFormatDateTime($this->sync_detail_date->CurrentValue, $this->sync_detail_date->formatPattern()), null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("peakexpenselist"), "", $this->TableVar, true);
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
