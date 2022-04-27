<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class MasterInvertorCalculatorEdit extends MasterInvertorCalculator
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'master_invertor_calculator';

    // Page object name
    public $PageObjName = "MasterInvertorCalculatorEdit";

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

        // Table object (master_invertor_calculator)
        if (!isset($GLOBALS["master_invertor_calculator"]) || get_class($GLOBALS["master_invertor_calculator"]) == PROJECT_NAMESPACE . "master_invertor_calculator") {
            $GLOBALS["master_invertor_calculator"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'master_invertor_calculator');
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
                $tbl = Container("master_invertor_calculator");
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
                    if ($pageName == "masterinvertorcalculatorview") {
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
            $key .= @$ar['master_invertor_calculator_id'];
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
            $this->master_invertor_calculator_id->Visible = false;
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
        $this->master_invertor_calculator_id->Visible = false;
        $this->investor_contract_period->setVisibility();
        $this->investor_mortgage_without_house->setVisibility();
        $this->invertor_mortgage_with_house->setVisibility();
        $this->invertor_mortgage_cash_without->setVisibility();
        $this->invertor_mortgage_cash_with->setVisibility();
        $this->invertor_dsr_ratio->setVisibility();
        $this->invertor_monthly_payment->setVisibility();
        $this->cip->Visible = false;
        $this->cdate->Visible = false;
        $this->cuser->Visible = false;
        $this->uip->setVisibility();
        $this->uuser->setVisibility();
        $this->udate->setVisibility();
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
            if (($keyValue = Get("master_invertor_calculator_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->master_invertor_calculator_id->setQueryStringValue($keyValue);
                $this->master_invertor_calculator_id->setOldValue($this->master_invertor_calculator_id->QueryStringValue);
            } elseif (Post("master_invertor_calculator_id") !== null) {
                $this->master_invertor_calculator_id->setFormValue(Post("master_invertor_calculator_id"));
                $this->master_invertor_calculator_id->setOldValue($this->master_invertor_calculator_id->FormValue);
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
                if (($keyValue = Get("master_invertor_calculator_id") ?? Route("master_invertor_calculator_id")) !== null) {
                    $this->master_invertor_calculator_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->master_invertor_calculator_id->CurrentValue = null;
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
                        $this->terminate("masterinvertorcalculatorlist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "masterinvertorcalculatorlist") {
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

        // Check field name 'investor_contract_period' first before field var 'x_investor_contract_period'
        $val = $CurrentForm->hasValue("investor_contract_period") ? $CurrentForm->getValue("investor_contract_period") : $CurrentForm->getValue("x_investor_contract_period");
        if (!$this->investor_contract_period->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_contract_period->Visible = false; // Disable update for API request
            } else {
                $this->investor_contract_period->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'investor_mortgage_without_house' first before field var 'x_investor_mortgage_without_house'
        $val = $CurrentForm->hasValue("investor_mortgage_without_house") ? $CurrentForm->getValue("investor_mortgage_without_house") : $CurrentForm->getValue("x_investor_mortgage_without_house");
        if (!$this->investor_mortgage_without_house->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investor_mortgage_without_house->Visible = false; // Disable update for API request
            } else {
                $this->investor_mortgage_without_house->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invertor_mortgage_with_house' first before field var 'x_invertor_mortgage_with_house'
        $val = $CurrentForm->hasValue("invertor_mortgage_with_house") ? $CurrentForm->getValue("invertor_mortgage_with_house") : $CurrentForm->getValue("x_invertor_mortgage_with_house");
        if (!$this->invertor_mortgage_with_house->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invertor_mortgage_with_house->Visible = false; // Disable update for API request
            } else {
                $this->invertor_mortgage_with_house->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invertor_mortgage_cash_without' first before field var 'x_invertor_mortgage_cash_without'
        $val = $CurrentForm->hasValue("invertor_mortgage_cash_without") ? $CurrentForm->getValue("invertor_mortgage_cash_without") : $CurrentForm->getValue("x_invertor_mortgage_cash_without");
        if (!$this->invertor_mortgage_cash_without->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invertor_mortgage_cash_without->Visible = false; // Disable update for API request
            } else {
                $this->invertor_mortgage_cash_without->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invertor_mortgage_cash_with' first before field var 'x_invertor_mortgage_cash_with'
        $val = $CurrentForm->hasValue("invertor_mortgage_cash_with") ? $CurrentForm->getValue("invertor_mortgage_cash_with") : $CurrentForm->getValue("x_invertor_mortgage_cash_with");
        if (!$this->invertor_mortgage_cash_with->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invertor_mortgage_cash_with->Visible = false; // Disable update for API request
            } else {
                $this->invertor_mortgage_cash_with->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invertor_dsr_ratio' first before field var 'x_invertor_dsr_ratio'
        $val = $CurrentForm->hasValue("invertor_dsr_ratio") ? $CurrentForm->getValue("invertor_dsr_ratio") : $CurrentForm->getValue("x_invertor_dsr_ratio");
        if (!$this->invertor_dsr_ratio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invertor_dsr_ratio->Visible = false; // Disable update for API request
            } else {
                $this->invertor_dsr_ratio->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invertor_monthly_payment' first before field var 'x_invertor_monthly_payment'
        $val = $CurrentForm->hasValue("invertor_monthly_payment") ? $CurrentForm->getValue("invertor_monthly_payment") : $CurrentForm->getValue("x_invertor_monthly_payment");
        if (!$this->invertor_monthly_payment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invertor_monthly_payment->Visible = false; // Disable update for API request
            } else {
                $this->invertor_monthly_payment->setFormValue($val, true, $validate);
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

        // Check field name 'uuser' first before field var 'x_uuser'
        $val = $CurrentForm->hasValue("uuser") ? $CurrentForm->getValue("uuser") : $CurrentForm->getValue("x_uuser");
        if (!$this->uuser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uuser->Visible = false; // Disable update for API request
            } else {
                $this->uuser->setFormValue($val);
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

        // Check field name 'master_invertor_calculator_id' first before field var 'x_master_invertor_calculator_id'
        $val = $CurrentForm->hasValue("master_invertor_calculator_id") ? $CurrentForm->getValue("master_invertor_calculator_id") : $CurrentForm->getValue("x_master_invertor_calculator_id");
        if (!$this->master_invertor_calculator_id->IsDetailKey) {
            $this->master_invertor_calculator_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->master_invertor_calculator_id->CurrentValue = $this->master_invertor_calculator_id->FormValue;
        $this->investor_contract_period->CurrentValue = $this->investor_contract_period->FormValue;
        $this->investor_mortgage_without_house->CurrentValue = $this->investor_mortgage_without_house->FormValue;
        $this->invertor_mortgage_with_house->CurrentValue = $this->invertor_mortgage_with_house->FormValue;
        $this->invertor_mortgage_cash_without->CurrentValue = $this->invertor_mortgage_cash_without->FormValue;
        $this->invertor_mortgage_cash_with->CurrentValue = $this->invertor_mortgage_cash_with->FormValue;
        $this->invertor_dsr_ratio->CurrentValue = $this->invertor_dsr_ratio->FormValue;
        $this->invertor_monthly_payment->CurrentValue = $this->invertor_monthly_payment->FormValue;
        $this->uip->CurrentValue = $this->uip->FormValue;
        $this->uuser->CurrentValue = $this->uuser->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
        $this->udate->CurrentValue = UnFormatDateTime($this->udate->CurrentValue, $this->udate->formatPattern());
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
        $this->master_invertor_calculator_id->setDbValue($row['master_invertor_calculator_id']);
        $this->investor_contract_period->setDbValue($row['investor_contract_period']);
        $this->investor_mortgage_without_house->setDbValue($row['investor_mortgage_without_house']);
        $this->invertor_mortgage_with_house->setDbValue($row['invertor_mortgage_with_house']);
        $this->invertor_mortgage_cash_without->setDbValue($row['invertor_mortgage_cash_without']);
        $this->invertor_mortgage_cash_with->setDbValue($row['invertor_mortgage_cash_with']);
        $this->invertor_dsr_ratio->setDbValue($row['invertor_dsr_ratio']);
        $this->invertor_monthly_payment->setDbValue($row['invertor_monthly_payment']);
        $this->cip->setDbValue($row['cip']);
        $this->cdate->setDbValue($row['cdate']);
        $this->cuser->setDbValue($row['cuser']);
        $this->uip->setDbValue($row['uip']);
        $this->uuser->setDbValue($row['uuser']);
        $this->udate->setDbValue($row['udate']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['master_invertor_calculator_id'] = null;
        $row['investor_contract_period'] = null;
        $row['investor_mortgage_without_house'] = null;
        $row['invertor_mortgage_with_house'] = null;
        $row['invertor_mortgage_cash_without'] = null;
        $row['invertor_mortgage_cash_with'] = null;
        $row['invertor_dsr_ratio'] = null;
        $row['invertor_monthly_payment'] = null;
        $row['cip'] = null;
        $row['cdate'] = null;
        $row['cuser'] = null;
        $row['uip'] = null;
        $row['uuser'] = null;
        $row['udate'] = null;
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

        // master_invertor_calculator_id
        $this->master_invertor_calculator_id->RowCssClass = "row";

        // investor_contract_period
        $this->investor_contract_period->RowCssClass = "row";

        // investor_mortgage_without_house
        $this->investor_mortgage_without_house->RowCssClass = "row";

        // invertor_mortgage_with_house
        $this->invertor_mortgage_with_house->RowCssClass = "row";

        // invertor_mortgage_cash_without
        $this->invertor_mortgage_cash_without->RowCssClass = "row";

        // invertor_mortgage_cash_with
        $this->invertor_mortgage_cash_with->RowCssClass = "row";

        // invertor_dsr_ratio
        $this->invertor_dsr_ratio->RowCssClass = "row";

        // invertor_monthly_payment
        $this->invertor_monthly_payment->RowCssClass = "row";

        // cip
        $this->cip->RowCssClass = "row";

        // cdate
        $this->cdate->RowCssClass = "row";

        // cuser
        $this->cuser->RowCssClass = "row";

        // uip
        $this->uip->RowCssClass = "row";

        // uuser
        $this->uuser->RowCssClass = "row";

        // udate
        $this->udate->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // investor_contract_period
            $this->investor_contract_period->ViewValue = $this->investor_contract_period->CurrentValue;
            $this->investor_contract_period->ViewValue = FormatNumber($this->investor_contract_period->ViewValue, $this->investor_contract_period->formatPattern());
            $this->investor_contract_period->ViewCustomAttributes = "";

            // investor_mortgage_without_house
            $this->investor_mortgage_without_house->ViewValue = $this->investor_mortgage_without_house->CurrentValue;
            $this->investor_mortgage_without_house->ViewValue = FormatNumber($this->investor_mortgage_without_house->ViewValue, $this->investor_mortgage_without_house->formatPattern());
            $this->investor_mortgage_without_house->ViewCustomAttributes = "";

            // invertor_mortgage_with_house
            $this->invertor_mortgage_with_house->ViewValue = $this->invertor_mortgage_with_house->CurrentValue;
            $this->invertor_mortgage_with_house->ViewValue = FormatNumber($this->invertor_mortgage_with_house->ViewValue, $this->invertor_mortgage_with_house->formatPattern());
            $this->invertor_mortgage_with_house->ViewCustomAttributes = "";

            // invertor_mortgage_cash_without
            $this->invertor_mortgage_cash_without->ViewValue = $this->invertor_mortgage_cash_without->CurrentValue;
            $this->invertor_mortgage_cash_without->ViewValue = FormatNumber($this->invertor_mortgage_cash_without->ViewValue, $this->invertor_mortgage_cash_without->formatPattern());
            $this->invertor_mortgage_cash_without->ViewCustomAttributes = "";

            // invertor_mortgage_cash_with
            $this->invertor_mortgage_cash_with->ViewValue = $this->invertor_mortgage_cash_with->CurrentValue;
            $this->invertor_mortgage_cash_with->ViewValue = FormatNumber($this->invertor_mortgage_cash_with->ViewValue, $this->invertor_mortgage_cash_with->formatPattern());
            $this->invertor_mortgage_cash_with->ViewCustomAttributes = "";

            // invertor_dsr_ratio
            $this->invertor_dsr_ratio->ViewValue = $this->invertor_dsr_ratio->CurrentValue;
            $this->invertor_dsr_ratio->ViewValue = FormatNumber($this->invertor_dsr_ratio->ViewValue, $this->invertor_dsr_ratio->formatPattern());
            $this->invertor_dsr_ratio->ViewCustomAttributes = "";

            // invertor_monthly_payment
            $this->invertor_monthly_payment->ViewValue = $this->invertor_monthly_payment->CurrentValue;
            $this->invertor_monthly_payment->ViewValue = FormatNumber($this->invertor_monthly_payment->ViewValue, $this->invertor_monthly_payment->formatPattern());
            $this->invertor_monthly_payment->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewValue = FormatDateTime($this->cdate->ViewValue, $this->cdate->formatPattern());
            $this->cdate->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewValue = FormatDateTime($this->udate->ViewValue, $this->udate->formatPattern());
            $this->udate->ViewCustomAttributes = "";

            // investor_contract_period
            $this->investor_contract_period->LinkCustomAttributes = "";
            $this->investor_contract_period->HrefValue = "";

            // investor_mortgage_without_house
            $this->investor_mortgage_without_house->LinkCustomAttributes = "";
            $this->investor_mortgage_without_house->HrefValue = "";

            // invertor_mortgage_with_house
            $this->invertor_mortgage_with_house->LinkCustomAttributes = "";
            $this->invertor_mortgage_with_house->HrefValue = "";

            // invertor_mortgage_cash_without
            $this->invertor_mortgage_cash_without->LinkCustomAttributes = "";
            $this->invertor_mortgage_cash_without->HrefValue = "";

            // invertor_mortgage_cash_with
            $this->invertor_mortgage_cash_with->LinkCustomAttributes = "";
            $this->invertor_mortgage_cash_with->HrefValue = "";

            // invertor_dsr_ratio
            $this->invertor_dsr_ratio->LinkCustomAttributes = "";
            $this->invertor_dsr_ratio->HrefValue = "";

            // invertor_monthly_payment
            $this->invertor_monthly_payment->LinkCustomAttributes = "";
            $this->invertor_monthly_payment->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // investor_contract_period
            $this->investor_contract_period->setupEditAttributes();
            $this->investor_contract_period->EditCustomAttributes = "";
            $this->investor_contract_period->EditValue = HtmlEncode($this->investor_contract_period->CurrentValue);
            $this->investor_contract_period->PlaceHolder = RemoveHtml($this->investor_contract_period->caption());
            if (strval($this->investor_contract_period->EditValue) != "" && is_numeric($this->investor_contract_period->EditValue)) {
                $this->investor_contract_period->EditValue = FormatNumber($this->investor_contract_period->EditValue, null);
            }

            // investor_mortgage_without_house
            $this->investor_mortgage_without_house->setupEditAttributes();
            $this->investor_mortgage_without_house->EditCustomAttributes = "";
            $this->investor_mortgage_without_house->EditValue = HtmlEncode($this->investor_mortgage_without_house->CurrentValue);
            $this->investor_mortgage_without_house->PlaceHolder = RemoveHtml($this->investor_mortgage_without_house->caption());
            if (strval($this->investor_mortgage_without_house->EditValue) != "" && is_numeric($this->investor_mortgage_without_house->EditValue)) {
                $this->investor_mortgage_without_house->EditValue = FormatNumber($this->investor_mortgage_without_house->EditValue, null);
            }

            // invertor_mortgage_with_house
            $this->invertor_mortgage_with_house->setupEditAttributes();
            $this->invertor_mortgage_with_house->EditCustomAttributes = "";
            $this->invertor_mortgage_with_house->EditValue = HtmlEncode($this->invertor_mortgage_with_house->CurrentValue);
            $this->invertor_mortgage_with_house->PlaceHolder = RemoveHtml($this->invertor_mortgage_with_house->caption());
            if (strval($this->invertor_mortgage_with_house->EditValue) != "" && is_numeric($this->invertor_mortgage_with_house->EditValue)) {
                $this->invertor_mortgage_with_house->EditValue = FormatNumber($this->invertor_mortgage_with_house->EditValue, null);
            }

            // invertor_mortgage_cash_without
            $this->invertor_mortgage_cash_without->setupEditAttributes();
            $this->invertor_mortgage_cash_without->EditCustomAttributes = "";
            $this->invertor_mortgage_cash_without->EditValue = HtmlEncode($this->invertor_mortgage_cash_without->CurrentValue);
            $this->invertor_mortgage_cash_without->PlaceHolder = RemoveHtml($this->invertor_mortgage_cash_without->caption());
            if (strval($this->invertor_mortgage_cash_without->EditValue) != "" && is_numeric($this->invertor_mortgage_cash_without->EditValue)) {
                $this->invertor_mortgage_cash_without->EditValue = FormatNumber($this->invertor_mortgage_cash_without->EditValue, null);
            }

            // invertor_mortgage_cash_with
            $this->invertor_mortgage_cash_with->setupEditAttributes();
            $this->invertor_mortgage_cash_with->EditCustomAttributes = "";
            $this->invertor_mortgage_cash_with->EditValue = HtmlEncode($this->invertor_mortgage_cash_with->CurrentValue);
            $this->invertor_mortgage_cash_with->PlaceHolder = RemoveHtml($this->invertor_mortgage_cash_with->caption());
            if (strval($this->invertor_mortgage_cash_with->EditValue) != "" && is_numeric($this->invertor_mortgage_cash_with->EditValue)) {
                $this->invertor_mortgage_cash_with->EditValue = FormatNumber($this->invertor_mortgage_cash_with->EditValue, null);
            }

            // invertor_dsr_ratio
            $this->invertor_dsr_ratio->setupEditAttributes();
            $this->invertor_dsr_ratio->EditCustomAttributes = "";
            $this->invertor_dsr_ratio->EditValue = HtmlEncode($this->invertor_dsr_ratio->CurrentValue);
            $this->invertor_dsr_ratio->PlaceHolder = RemoveHtml($this->invertor_dsr_ratio->caption());
            if (strval($this->invertor_dsr_ratio->EditValue) != "" && is_numeric($this->invertor_dsr_ratio->EditValue)) {
                $this->invertor_dsr_ratio->EditValue = FormatNumber($this->invertor_dsr_ratio->EditValue, null);
            }

            // invertor_monthly_payment
            $this->invertor_monthly_payment->setupEditAttributes();
            $this->invertor_monthly_payment->EditCustomAttributes = "";
            $this->invertor_monthly_payment->EditValue = HtmlEncode($this->invertor_monthly_payment->CurrentValue);
            $this->invertor_monthly_payment->PlaceHolder = RemoveHtml($this->invertor_monthly_payment->caption());
            if (strval($this->invertor_monthly_payment->EditValue) != "" && is_numeric($this->invertor_monthly_payment->EditValue)) {
                $this->invertor_monthly_payment->EditValue = FormatNumber($this->invertor_monthly_payment->EditValue, null);
            }

            // uip

            // uuser

            // udate

            // Edit refer script

            // investor_contract_period
            $this->investor_contract_period->LinkCustomAttributes = "";
            $this->investor_contract_period->HrefValue = "";

            // investor_mortgage_without_house
            $this->investor_mortgage_without_house->LinkCustomAttributes = "";
            $this->investor_mortgage_without_house->HrefValue = "";

            // invertor_mortgage_with_house
            $this->invertor_mortgage_with_house->LinkCustomAttributes = "";
            $this->invertor_mortgage_with_house->HrefValue = "";

            // invertor_mortgage_cash_without
            $this->invertor_mortgage_cash_without->LinkCustomAttributes = "";
            $this->invertor_mortgage_cash_without->HrefValue = "";

            // invertor_mortgage_cash_with
            $this->invertor_mortgage_cash_with->LinkCustomAttributes = "";
            $this->invertor_mortgage_cash_with->HrefValue = "";

            // invertor_dsr_ratio
            $this->invertor_dsr_ratio->LinkCustomAttributes = "";
            $this->invertor_dsr_ratio->HrefValue = "";

            // invertor_monthly_payment
            $this->invertor_monthly_payment->LinkCustomAttributes = "";
            $this->invertor_monthly_payment->HrefValue = "";

            // uip
            $this->uip->LinkCustomAttributes = "";
            $this->uip->HrefValue = "";

            // uuser
            $this->uuser->LinkCustomAttributes = "";
            $this->uuser->HrefValue = "";

            // udate
            $this->udate->LinkCustomAttributes = "";
            $this->udate->HrefValue = "";
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
        if ($this->investor_contract_period->Required) {
            if (!$this->investor_contract_period->IsDetailKey && EmptyValue($this->investor_contract_period->FormValue)) {
                $this->investor_contract_period->addErrorMessage(str_replace("%s", $this->investor_contract_period->caption(), $this->investor_contract_period->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->investor_contract_period->FormValue)) {
            $this->investor_contract_period->addErrorMessage($this->investor_contract_period->getErrorMessage(false));
        }
        if ($this->investor_mortgage_without_house->Required) {
            if (!$this->investor_mortgage_without_house->IsDetailKey && EmptyValue($this->investor_mortgage_without_house->FormValue)) {
                $this->investor_mortgage_without_house->addErrorMessage(str_replace("%s", $this->investor_mortgage_without_house->caption(), $this->investor_mortgage_without_house->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->investor_mortgage_without_house->FormValue)) {
            $this->investor_mortgage_without_house->addErrorMessage($this->investor_mortgage_without_house->getErrorMessage(false));
        }
        if ($this->invertor_mortgage_with_house->Required) {
            if (!$this->invertor_mortgage_with_house->IsDetailKey && EmptyValue($this->invertor_mortgage_with_house->FormValue)) {
                $this->invertor_mortgage_with_house->addErrorMessage(str_replace("%s", $this->invertor_mortgage_with_house->caption(), $this->invertor_mortgage_with_house->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invertor_mortgage_with_house->FormValue)) {
            $this->invertor_mortgage_with_house->addErrorMessage($this->invertor_mortgage_with_house->getErrorMessage(false));
        }
        if ($this->invertor_mortgage_cash_without->Required) {
            if (!$this->invertor_mortgage_cash_without->IsDetailKey && EmptyValue($this->invertor_mortgage_cash_without->FormValue)) {
                $this->invertor_mortgage_cash_without->addErrorMessage(str_replace("%s", $this->invertor_mortgage_cash_without->caption(), $this->invertor_mortgage_cash_without->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invertor_mortgage_cash_without->FormValue)) {
            $this->invertor_mortgage_cash_without->addErrorMessage($this->invertor_mortgage_cash_without->getErrorMessage(false));
        }
        if ($this->invertor_mortgage_cash_with->Required) {
            if (!$this->invertor_mortgage_cash_with->IsDetailKey && EmptyValue($this->invertor_mortgage_cash_with->FormValue)) {
                $this->invertor_mortgage_cash_with->addErrorMessage(str_replace("%s", $this->invertor_mortgage_cash_with->caption(), $this->invertor_mortgage_cash_with->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invertor_mortgage_cash_with->FormValue)) {
            $this->invertor_mortgage_cash_with->addErrorMessage($this->invertor_mortgage_cash_with->getErrorMessage(false));
        }
        if ($this->invertor_dsr_ratio->Required) {
            if (!$this->invertor_dsr_ratio->IsDetailKey && EmptyValue($this->invertor_dsr_ratio->FormValue)) {
                $this->invertor_dsr_ratio->addErrorMessage(str_replace("%s", $this->invertor_dsr_ratio->caption(), $this->invertor_dsr_ratio->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invertor_dsr_ratio->FormValue)) {
            $this->invertor_dsr_ratio->addErrorMessage($this->invertor_dsr_ratio->getErrorMessage(false));
        }
        if ($this->invertor_monthly_payment->Required) {
            if (!$this->invertor_monthly_payment->IsDetailKey && EmptyValue($this->invertor_monthly_payment->FormValue)) {
                $this->invertor_monthly_payment->addErrorMessage(str_replace("%s", $this->invertor_monthly_payment->caption(), $this->invertor_monthly_payment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invertor_monthly_payment->FormValue)) {
            $this->invertor_monthly_payment->addErrorMessage($this->invertor_monthly_payment->getErrorMessage(false));
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
        if ($this->udate->Required) {
            if (!$this->udate->IsDetailKey && EmptyValue($this->udate->FormValue)) {
                $this->udate->addErrorMessage(str_replace("%s", $this->udate->caption(), $this->udate->RequiredErrorMessage));
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

            // investor_contract_period
            $this->investor_contract_period->setDbValueDef($rsnew, $this->investor_contract_period->CurrentValue, 0, $this->investor_contract_period->ReadOnly);

            // investor_mortgage_without_house
            $this->investor_mortgage_without_house->setDbValueDef($rsnew, $this->investor_mortgage_without_house->CurrentValue, 0, $this->investor_mortgage_without_house->ReadOnly);

            // invertor_mortgage_with_house
            $this->invertor_mortgage_with_house->setDbValueDef($rsnew, $this->invertor_mortgage_with_house->CurrentValue, 0, $this->invertor_mortgage_with_house->ReadOnly);

            // invertor_mortgage_cash_without
            $this->invertor_mortgage_cash_without->setDbValueDef($rsnew, $this->invertor_mortgage_cash_without->CurrentValue, 0, $this->invertor_mortgage_cash_without->ReadOnly);

            // invertor_mortgage_cash_with
            $this->invertor_mortgage_cash_with->setDbValueDef($rsnew, $this->invertor_mortgage_cash_with->CurrentValue, 0, $this->invertor_mortgage_cash_with->ReadOnly);

            // invertor_dsr_ratio
            $this->invertor_dsr_ratio->setDbValueDef($rsnew, $this->invertor_dsr_ratio->CurrentValue, 0, $this->invertor_dsr_ratio->ReadOnly);

            // invertor_monthly_payment
            $this->invertor_monthly_payment->setDbValueDef($rsnew, $this->invertor_monthly_payment->CurrentValue, 0, $this->invertor_monthly_payment->ReadOnly);

            // uip
            $this->uip->CurrentValue = CurrentUserIP();
            $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, "");

            // uuser
            $this->uuser->CurrentValue = CurrentUserID();
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, "");

            // udate
            $this->udate->CurrentValue = CurrentDateTime();
            $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, CurrentDate());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("masterinvertorcalculatorlist"), "", $this->TableVar, true);
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
