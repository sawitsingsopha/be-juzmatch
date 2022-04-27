<?php

namespace PHPMaker2022\juzmatch;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class InvestorVerifyEdit extends InvestorVerify
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'investor_verify';

    // Page object name
    public $PageObjName = "InvestorVerifyEdit";

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

        // Table object (investor_verify)
        if (!isset($GLOBALS["investor_verify"]) || get_class($GLOBALS["investor_verify"]) == PROJECT_NAMESPACE . "investor_verify") {
            $GLOBALS["investor_verify"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'investor_verify');
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
                $tbl = Container("investor_verify");
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
                    if ($pageName == "investorverifyview") {
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
            $key .= @$ar['juzcalculator_id'];
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
            $this->juzcalculator_id->Visible = false;
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
        $this->juzcalculator_id->Visible = false;
        $this->member_id->setVisibility();
        $this->firstname->setVisibility();
        $this->lastname->setVisibility();
        $this->phone->setVisibility();
        $this->_email->setVisibility();
        $this->status->Visible = false;
        $this->income_all->Visible = false;
        $this->outcome_all->Visible = false;
        $this->investment->setVisibility();
        $this->credit_limit->setVisibility();
        $this->monthly_payments->setVisibility();
        $this->highest_rental_price->setVisibility();
        $this->transfer->setVisibility();
        $this->total_invertor_year->setVisibility();
        $this->invert_payoff_day->setVisibility();
        $this->type_invertor->setVisibility();
        $this->invest_amount->setVisibility();
        $this->rent_price->Visible = false;
        $this->asset_price->Visible = false;
        $this->cdate->Visible = false;
        $this->cuser->Visible = false;
        $this->cip->Visible = false;
        $this->udate->setVisibility();
        $this->uuser->setVisibility();
        $this->uip->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->member_id->Required = false;

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
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->transfer);
        $this->setupLookupOptions($this->type_invertor);

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
            if (($keyValue = Get("juzcalculator_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->juzcalculator_id->setQueryStringValue($keyValue);
                $this->juzcalculator_id->setOldValue($this->juzcalculator_id->QueryStringValue);
            } elseif (Post("juzcalculator_id") !== null) {
                $this->juzcalculator_id->setFormValue(Post("juzcalculator_id"));
                $this->juzcalculator_id->setOldValue($this->juzcalculator_id->FormValue);
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
                if (($keyValue = Get("juzcalculator_id") ?? Route("juzcalculator_id")) !== null) {
                    $this->juzcalculator_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->juzcalculator_id->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

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
                        $this->terminate("investorverifylist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "investorverifylist") {
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

        // Check field name 'member_id' first before field var 'x_member_id'
        $val = $CurrentForm->hasValue("member_id") ? $CurrentForm->getValue("member_id") : $CurrentForm->getValue("x_member_id");
        if (!$this->member_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->member_id->Visible = false; // Disable update for API request
            } else {
                $this->member_id->setFormValue($val);
            }
        }

        // Check field name 'firstname' first before field var 'x_firstname'
        $val = $CurrentForm->hasValue("firstname") ? $CurrentForm->getValue("firstname") : $CurrentForm->getValue("x_firstname");
        if (!$this->firstname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->firstname->Visible = false; // Disable update for API request
            } else {
                $this->firstname->setFormValue($val);
            }
        }

        // Check field name 'lastname' first before field var 'x_lastname'
        $val = $CurrentForm->hasValue("lastname") ? $CurrentForm->getValue("lastname") : $CurrentForm->getValue("x_lastname");
        if (!$this->lastname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastname->Visible = false; // Disable update for API request
            } else {
                $this->lastname->setFormValue($val);
            }
        }

        // Check field name 'phone' first before field var 'x_phone'
        $val = $CurrentForm->hasValue("phone") ? $CurrentForm->getValue("phone") : $CurrentForm->getValue("x_phone");
        if (!$this->phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone->Visible = false; // Disable update for API request
            } else {
                $this->phone->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'investment' first before field var 'x_investment'
        $val = $CurrentForm->hasValue("investment") ? $CurrentForm->getValue("investment") : $CurrentForm->getValue("x_investment");
        if (!$this->investment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->investment->Visible = false; // Disable update for API request
            } else {
                $this->investment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'credit_limit' first before field var 'x_credit_limit'
        $val = $CurrentForm->hasValue("credit_limit") ? $CurrentForm->getValue("credit_limit") : $CurrentForm->getValue("x_credit_limit");
        if (!$this->credit_limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->credit_limit->Visible = false; // Disable update for API request
            } else {
                $this->credit_limit->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monthly_payments' first before field var 'x_monthly_payments'
        $val = $CurrentForm->hasValue("monthly_payments") ? $CurrentForm->getValue("monthly_payments") : $CurrentForm->getValue("x_monthly_payments");
        if (!$this->monthly_payments->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monthly_payments->Visible = false; // Disable update for API request
            } else {
                $this->monthly_payments->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'highest_rental_price' first before field var 'x_highest_rental_price'
        $val = $CurrentForm->hasValue("highest_rental_price") ? $CurrentForm->getValue("highest_rental_price") : $CurrentForm->getValue("x_highest_rental_price");
        if (!$this->highest_rental_price->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->highest_rental_price->Visible = false; // Disable update for API request
            } else {
                $this->highest_rental_price->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'transfer' first before field var 'x_transfer'
        $val = $CurrentForm->hasValue("transfer") ? $CurrentForm->getValue("transfer") : $CurrentForm->getValue("x_transfer");
        if (!$this->transfer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->transfer->Visible = false; // Disable update for API request
            } else {
                $this->transfer->setFormValue($val);
            }
        }

        // Check field name 'total_invertor_year' first before field var 'x_total_invertor_year'
        $val = $CurrentForm->hasValue("total_invertor_year") ? $CurrentForm->getValue("total_invertor_year") : $CurrentForm->getValue("x_total_invertor_year");
        if (!$this->total_invertor_year->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total_invertor_year->Visible = false; // Disable update for API request
            } else {
                $this->total_invertor_year->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'invert_payoff_day' first before field var 'x_invert_payoff_day'
        $val = $CurrentForm->hasValue("invert_payoff_day") ? $CurrentForm->getValue("invert_payoff_day") : $CurrentForm->getValue("x_invert_payoff_day");
        if (!$this->invert_payoff_day->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invert_payoff_day->Visible = false; // Disable update for API request
            } else {
                $this->invert_payoff_day->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'type_invertor' first before field var 'x_type_invertor'
        $val = $CurrentForm->hasValue("type_invertor") ? $CurrentForm->getValue("type_invertor") : $CurrentForm->getValue("x_type_invertor");
        if (!$this->type_invertor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type_invertor->Visible = false; // Disable update for API request
            } else {
                $this->type_invertor->setFormValue($val);
            }
        }

        // Check field name 'invest_amount' first before field var 'x_invest_amount'
        $val = $CurrentForm->hasValue("invest_amount") ? $CurrentForm->getValue("invest_amount") : $CurrentForm->getValue("x_invest_amount");
        if (!$this->invest_amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->invest_amount->Visible = false; // Disable update for API request
            } else {
                $this->invest_amount->setFormValue($val, true, $validate);
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

        // Check field name 'juzcalculator_id' first before field var 'x_juzcalculator_id'
        $val = $CurrentForm->hasValue("juzcalculator_id") ? $CurrentForm->getValue("juzcalculator_id") : $CurrentForm->getValue("x_juzcalculator_id");
        if (!$this->juzcalculator_id->IsDetailKey) {
            $this->juzcalculator_id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->juzcalculator_id->CurrentValue = $this->juzcalculator_id->FormValue;
        $this->member_id->CurrentValue = $this->member_id->FormValue;
        $this->firstname->CurrentValue = $this->firstname->FormValue;
        $this->lastname->CurrentValue = $this->lastname->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->investment->CurrentValue = $this->investment->FormValue;
        $this->credit_limit->CurrentValue = $this->credit_limit->FormValue;
        $this->monthly_payments->CurrentValue = $this->monthly_payments->FormValue;
        $this->highest_rental_price->CurrentValue = $this->highest_rental_price->FormValue;
        $this->transfer->CurrentValue = $this->transfer->FormValue;
        $this->total_invertor_year->CurrentValue = $this->total_invertor_year->FormValue;
        $this->invert_payoff_day->CurrentValue = $this->invert_payoff_day->FormValue;
        $this->type_invertor->CurrentValue = $this->type_invertor->FormValue;
        $this->invest_amount->CurrentValue = $this->invest_amount->FormValue;
        $this->udate->CurrentValue = $this->udate->FormValue;
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
        $this->juzcalculator_id->setDbValue($row['juzcalculator_id']);
        $this->member_id->setDbValue($row['member_id']);
        $this->firstname->setDbValue($row['firstname']);
        $this->lastname->setDbValue($row['lastname']);
        $this->phone->setDbValue($row['phone']);
        $this->_email->setDbValue($row['email']);
        $this->status->setDbValue($row['status']);
        $this->income_all->setDbValue($row['income_all']);
        $this->outcome_all->setDbValue($row['outcome_all']);
        $this->investment->setDbValue($row['investment']);
        $this->credit_limit->setDbValue($row['credit_limit']);
        $this->monthly_payments->setDbValue($row['monthly_payments']);
        $this->highest_rental_price->setDbValue($row['highest_rental_price']);
        $this->transfer->setDbValue($row['transfer']);
        $this->total_invertor_year->setDbValue($row['total_invertor_year']);
        $this->invert_payoff_day->setDbValue($row['invert_payoff_day']);
        $this->type_invertor->setDbValue($row['type_invertor']);
        $this->invest_amount->setDbValue($row['invest_amount']);
        $this->rent_price->setDbValue($row['rent_price']);
        $this->asset_price->setDbValue($row['asset_price']);
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
        $row['juzcalculator_id'] = null;
        $row['member_id'] = null;
        $row['firstname'] = null;
        $row['lastname'] = null;
        $row['phone'] = null;
        $row['email'] = null;
        $row['status'] = null;
        $row['income_all'] = null;
        $row['outcome_all'] = null;
        $row['investment'] = null;
        $row['credit_limit'] = null;
        $row['monthly_payments'] = null;
        $row['highest_rental_price'] = null;
        $row['transfer'] = null;
        $row['total_invertor_year'] = null;
        $row['invert_payoff_day'] = null;
        $row['type_invertor'] = null;
        $row['invest_amount'] = null;
        $row['rent_price'] = null;
        $row['asset_price'] = null;
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

        // juzcalculator_id
        $this->juzcalculator_id->RowCssClass = "row";

        // member_id
        $this->member_id->RowCssClass = "row";

        // firstname
        $this->firstname->RowCssClass = "row";

        // lastname
        $this->lastname->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // income_all
        $this->income_all->RowCssClass = "row";

        // outcome_all
        $this->outcome_all->RowCssClass = "row";

        // investment
        $this->investment->RowCssClass = "row";

        // credit_limit
        $this->credit_limit->RowCssClass = "row";

        // monthly_payments
        $this->monthly_payments->RowCssClass = "row";

        // highest_rental_price
        $this->highest_rental_price->RowCssClass = "row";

        // transfer
        $this->transfer->RowCssClass = "row";

        // total_invertor_year
        $this->total_invertor_year->RowCssClass = "row";

        // invert_payoff_day
        $this->invert_payoff_day->RowCssClass = "row";

        // type_invertor
        $this->type_invertor->RowCssClass = "row";

        // invest_amount
        $this->invest_amount->RowCssClass = "row";

        // rent_price
        $this->rent_price->RowCssClass = "row";

        // asset_price
        $this->asset_price->RowCssClass = "row";

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
            // member_id
            $curVal = strval($this->member_id->CurrentValue);
            if ($curVal != "") {
                $this->member_id->ViewValue = $this->member_id->lookupCacheOption($curVal);
                if ($this->member_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // firstname
            $this->firstname->ViewValue = $this->firstname->CurrentValue;
            $this->firstname->ViewCustomAttributes = "";

            // lastname
            $this->lastname->ViewValue = $this->lastname->CurrentValue;
            $this->lastname->ViewCustomAttributes = "";

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;
            $this->phone->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // investment
            $this->investment->ViewValue = $this->investment->CurrentValue;
            $this->investment->ViewValue = FormatNumber($this->investment->ViewValue, $this->investment->formatPattern());
            $this->investment->ViewCustomAttributes = "";

            // credit_limit
            $this->credit_limit->ViewValue = $this->credit_limit->CurrentValue;
            $this->credit_limit->ViewValue = FormatNumber($this->credit_limit->ViewValue, $this->credit_limit->formatPattern());
            $this->credit_limit->ViewCustomAttributes = "";

            // monthly_payments
            $this->monthly_payments->ViewValue = $this->monthly_payments->CurrentValue;
            $this->monthly_payments->ViewValue = FormatNumber($this->monthly_payments->ViewValue, $this->monthly_payments->formatPattern());
            $this->monthly_payments->ViewCustomAttributes = "";

            // highest_rental_price
            $this->highest_rental_price->ViewValue = $this->highest_rental_price->CurrentValue;
            $this->highest_rental_price->ViewValue = FormatNumber($this->highest_rental_price->ViewValue, $this->highest_rental_price->formatPattern());
            $this->highest_rental_price->ViewCustomAttributes = "";

            // transfer
            if (strval($this->transfer->CurrentValue) != "") {
                $this->transfer->ViewValue = $this->transfer->optionCaption($this->transfer->CurrentValue);
            } else {
                $this->transfer->ViewValue = null;
            }
            $this->transfer->ViewCustomAttributes = "";

            // total_invertor_year
            $this->total_invertor_year->ViewValue = $this->total_invertor_year->CurrentValue;
            $this->total_invertor_year->ViewValue = FormatNumber($this->total_invertor_year->ViewValue, $this->total_invertor_year->formatPattern());
            $this->total_invertor_year->ViewCustomAttributes = "";

            // invert_payoff_day
            $this->invert_payoff_day->ViewValue = $this->invert_payoff_day->CurrentValue;
            $this->invert_payoff_day->ViewValue = FormatNumber($this->invert_payoff_day->ViewValue, $this->invert_payoff_day->formatPattern());
            $this->invert_payoff_day->ViewCustomAttributes = "";

            // type_invertor
            if (strval($this->type_invertor->CurrentValue) != "") {
                $this->type_invertor->ViewValue = $this->type_invertor->optionCaption($this->type_invertor->CurrentValue);
            } else {
                $this->type_invertor->ViewValue = null;
            }
            $this->type_invertor->ViewCustomAttributes = "";

            // invest_amount
            $this->invest_amount->ViewValue = $this->invest_amount->CurrentValue;
            $this->invest_amount->ViewValue = FormatNumber($this->invest_amount->ViewValue, $this->invest_amount->formatPattern());
            $this->invest_amount->ViewCustomAttributes = "";

            // cdate
            $this->cdate->ViewValue = $this->cdate->CurrentValue;
            $this->cdate->ViewCustomAttributes = "";

            // cuser
            $this->cuser->ViewValue = $this->cuser->CurrentValue;
            $this->cuser->ViewCustomAttributes = "";

            // cip
            $this->cip->ViewValue = $this->cip->CurrentValue;
            $this->cip->ViewCustomAttributes = "";

            // udate
            $this->udate->ViewValue = $this->udate->CurrentValue;
            $this->udate->ViewCustomAttributes = "";

            // uuser
            $this->uuser->ViewValue = $this->uuser->CurrentValue;
            $this->uuser->ViewCustomAttributes = "";

            // uip
            $this->uip->ViewValue = $this->uip->CurrentValue;
            $this->uip->ViewCustomAttributes = "";

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // firstname
            $this->firstname->LinkCustomAttributes = "";
            $this->firstname->HrefValue = "";

            // lastname
            $this->lastname->LinkCustomAttributes = "";
            $this->lastname->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // investment
            $this->investment->LinkCustomAttributes = "";
            $this->investment->HrefValue = "";

            // credit_limit
            $this->credit_limit->LinkCustomAttributes = "";
            $this->credit_limit->HrefValue = "";

            // monthly_payments
            $this->monthly_payments->LinkCustomAttributes = "";
            $this->monthly_payments->HrefValue = "";

            // highest_rental_price
            $this->highest_rental_price->LinkCustomAttributes = "";
            $this->highest_rental_price->HrefValue = "";

            // transfer
            $this->transfer->LinkCustomAttributes = "";
            $this->transfer->HrefValue = "";

            // total_invertor_year
            $this->total_invertor_year->LinkCustomAttributes = "";
            $this->total_invertor_year->HrefValue = "";

            // invert_payoff_day
            $this->invert_payoff_day->LinkCustomAttributes = "";
            $this->invert_payoff_day->HrefValue = "";

            // type_invertor
            $this->type_invertor->LinkCustomAttributes = "";
            $this->type_invertor->HrefValue = "";

            // invest_amount
            $this->invest_amount->LinkCustomAttributes = "";
            $this->invest_amount->HrefValue = "";

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
            // member_id
            $this->member_id->setupEditAttributes();
            $this->member_id->EditCustomAttributes = "";
            $curVal = strval($this->member_id->CurrentValue);
            if ($curVal != "") {
                $this->member_id->EditValue = $this->member_id->lookupCacheOption($curVal);
                if ($this->member_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`member_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->member_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->member_id->Lookup->renderViewRow($rswrk[0]);
                        $this->member_id->EditValue = $this->member_id->displayValue($arwrk);
                    } else {
                        $this->member_id->EditValue = FormatNumber($this->member_id->CurrentValue, $this->member_id->formatPattern());
                    }
                }
            } else {
                $this->member_id->EditValue = null;
            }
            $this->member_id->ViewCustomAttributes = "";

            // firstname
            $this->firstname->setupEditAttributes();
            $this->firstname->EditCustomAttributes = "";
            if (!$this->firstname->Raw) {
                $this->firstname->CurrentValue = HtmlDecode($this->firstname->CurrentValue);
            }
            $this->firstname->EditValue = HtmlEncode($this->firstname->CurrentValue);
            $this->firstname->PlaceHolder = RemoveHtml($this->firstname->caption());

            // lastname
            $this->lastname->setupEditAttributes();
            $this->lastname->EditCustomAttributes = "";
            if (!$this->lastname->Raw) {
                $this->lastname->CurrentValue = HtmlDecode($this->lastname->CurrentValue);
            }
            $this->lastname->EditValue = HtmlEncode($this->lastname->CurrentValue);
            $this->lastname->PlaceHolder = RemoveHtml($this->lastname->caption());

            // phone
            $this->phone->setupEditAttributes();
            $this->phone->EditCustomAttributes = "";
            if (!$this->phone->Raw) {
                $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->CurrentValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // investment
            $this->investment->setupEditAttributes();
            $this->investment->EditCustomAttributes = "";
            $this->investment->EditValue = HtmlEncode($this->investment->CurrentValue);
            $this->investment->PlaceHolder = RemoveHtml($this->investment->caption());
            if (strval($this->investment->EditValue) != "" && is_numeric($this->investment->EditValue)) {
                $this->investment->EditValue = FormatNumber($this->investment->EditValue, null);
            }

            // credit_limit
            $this->credit_limit->setupEditAttributes();
            $this->credit_limit->EditCustomAttributes = "";
            $this->credit_limit->EditValue = HtmlEncode($this->credit_limit->CurrentValue);
            $this->credit_limit->PlaceHolder = RemoveHtml($this->credit_limit->caption());
            if (strval($this->credit_limit->EditValue) != "" && is_numeric($this->credit_limit->EditValue)) {
                $this->credit_limit->EditValue = FormatNumber($this->credit_limit->EditValue, null);
            }

            // monthly_payments
            $this->monthly_payments->setupEditAttributes();
            $this->monthly_payments->EditCustomAttributes = "";
            $this->monthly_payments->EditValue = HtmlEncode($this->monthly_payments->CurrentValue);
            $this->monthly_payments->PlaceHolder = RemoveHtml($this->monthly_payments->caption());
            if (strval($this->monthly_payments->EditValue) != "" && is_numeric($this->monthly_payments->EditValue)) {
                $this->monthly_payments->EditValue = FormatNumber($this->monthly_payments->EditValue, null);
            }

            // highest_rental_price
            $this->highest_rental_price->setupEditAttributes();
            $this->highest_rental_price->EditCustomAttributes = "";
            $this->highest_rental_price->EditValue = HtmlEncode($this->highest_rental_price->CurrentValue);
            $this->highest_rental_price->PlaceHolder = RemoveHtml($this->highest_rental_price->caption());
            if (strval($this->highest_rental_price->EditValue) != "" && is_numeric($this->highest_rental_price->EditValue)) {
                $this->highest_rental_price->EditValue = FormatNumber($this->highest_rental_price->EditValue, null);
            }

            // transfer
            $this->transfer->EditCustomAttributes = "";
            $this->transfer->EditValue = $this->transfer->options(false);
            $this->transfer->PlaceHolder = RemoveHtml($this->transfer->caption());

            // total_invertor_year
            $this->total_invertor_year->setupEditAttributes();
            $this->total_invertor_year->EditCustomAttributes = "";
            $this->total_invertor_year->EditValue = HtmlEncode($this->total_invertor_year->CurrentValue);
            $this->total_invertor_year->PlaceHolder = RemoveHtml($this->total_invertor_year->caption());
            if (strval($this->total_invertor_year->EditValue) != "" && is_numeric($this->total_invertor_year->EditValue)) {
                $this->total_invertor_year->EditValue = FormatNumber($this->total_invertor_year->EditValue, null);
            }

            // invert_payoff_day
            $this->invert_payoff_day->setupEditAttributes();
            $this->invert_payoff_day->EditCustomAttributes = "";
            $this->invert_payoff_day->EditValue = HtmlEncode($this->invert_payoff_day->CurrentValue);
            $this->invert_payoff_day->PlaceHolder = RemoveHtml($this->invert_payoff_day->caption());
            if (strval($this->invert_payoff_day->EditValue) != "" && is_numeric($this->invert_payoff_day->EditValue)) {
                $this->invert_payoff_day->EditValue = FormatNumber($this->invert_payoff_day->EditValue, null);
            }

            // type_invertor
            $this->type_invertor->setupEditAttributes();
            $this->type_invertor->EditCustomAttributes = "";
            $this->type_invertor->EditValue = $this->type_invertor->options(true);
            $this->type_invertor->PlaceHolder = RemoveHtml($this->type_invertor->caption());

            // invest_amount
            $this->invest_amount->setupEditAttributes();
            $this->invest_amount->EditCustomAttributes = "";
            $this->invest_amount->EditValue = HtmlEncode($this->invest_amount->CurrentValue);
            $this->invest_amount->PlaceHolder = RemoveHtml($this->invest_amount->caption());
            if (strval($this->invest_amount->EditValue) != "" && is_numeric($this->invest_amount->EditValue)) {
                $this->invest_amount->EditValue = FormatNumber($this->invest_amount->EditValue, null);
            }

            // udate

            // uuser

            // uip

            // Edit refer script

            // member_id
            $this->member_id->LinkCustomAttributes = "";
            $this->member_id->HrefValue = "";
            $this->member_id->TooltipValue = "";

            // firstname
            $this->firstname->LinkCustomAttributes = "";
            $this->firstname->HrefValue = "";

            // lastname
            $this->lastname->LinkCustomAttributes = "";
            $this->lastname->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // investment
            $this->investment->LinkCustomAttributes = "";
            $this->investment->HrefValue = "";

            // credit_limit
            $this->credit_limit->LinkCustomAttributes = "";
            $this->credit_limit->HrefValue = "";

            // monthly_payments
            $this->monthly_payments->LinkCustomAttributes = "";
            $this->monthly_payments->HrefValue = "";

            // highest_rental_price
            $this->highest_rental_price->LinkCustomAttributes = "";
            $this->highest_rental_price->HrefValue = "";

            // transfer
            $this->transfer->LinkCustomAttributes = "";
            $this->transfer->HrefValue = "";

            // total_invertor_year
            $this->total_invertor_year->LinkCustomAttributes = "";
            $this->total_invertor_year->HrefValue = "";

            // invert_payoff_day
            $this->invert_payoff_day->LinkCustomAttributes = "";
            $this->invert_payoff_day->HrefValue = "";

            // type_invertor
            $this->type_invertor->LinkCustomAttributes = "";
            $this->type_invertor->HrefValue = "";

            // invest_amount
            $this->invest_amount->LinkCustomAttributes = "";
            $this->invest_amount->HrefValue = "";

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
        if ($this->member_id->Required) {
            if (!$this->member_id->IsDetailKey && EmptyValue($this->member_id->FormValue)) {
                $this->member_id->addErrorMessage(str_replace("%s", $this->member_id->caption(), $this->member_id->RequiredErrorMessage));
            }
        }
        if ($this->firstname->Required) {
            if (!$this->firstname->IsDetailKey && EmptyValue($this->firstname->FormValue)) {
                $this->firstname->addErrorMessage(str_replace("%s", $this->firstname->caption(), $this->firstname->RequiredErrorMessage));
            }
        }
        if ($this->lastname->Required) {
            if (!$this->lastname->IsDetailKey && EmptyValue($this->lastname->FormValue)) {
                $this->lastname->addErrorMessage(str_replace("%s", $this->lastname->caption(), $this->lastname->RequiredErrorMessage));
            }
        }
        if ($this->phone->Required) {
            if (!$this->phone->IsDetailKey && EmptyValue($this->phone->FormValue)) {
                $this->phone->addErrorMessage(str_replace("%s", $this->phone->caption(), $this->phone->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->investment->Required) {
            if (!$this->investment->IsDetailKey && EmptyValue($this->investment->FormValue)) {
                $this->investment->addErrorMessage(str_replace("%s", $this->investment->caption(), $this->investment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->investment->FormValue)) {
            $this->investment->addErrorMessage($this->investment->getErrorMessage(false));
        }
        if ($this->credit_limit->Required) {
            if (!$this->credit_limit->IsDetailKey && EmptyValue($this->credit_limit->FormValue)) {
                $this->credit_limit->addErrorMessage(str_replace("%s", $this->credit_limit->caption(), $this->credit_limit->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->credit_limit->FormValue)) {
            $this->credit_limit->addErrorMessage($this->credit_limit->getErrorMessage(false));
        }
        if ($this->monthly_payments->Required) {
            if (!$this->monthly_payments->IsDetailKey && EmptyValue($this->monthly_payments->FormValue)) {
                $this->monthly_payments->addErrorMessage(str_replace("%s", $this->monthly_payments->caption(), $this->monthly_payments->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->monthly_payments->FormValue)) {
            $this->monthly_payments->addErrorMessage($this->monthly_payments->getErrorMessage(false));
        }
        if ($this->highest_rental_price->Required) {
            if (!$this->highest_rental_price->IsDetailKey && EmptyValue($this->highest_rental_price->FormValue)) {
                $this->highest_rental_price->addErrorMessage(str_replace("%s", $this->highest_rental_price->caption(), $this->highest_rental_price->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->highest_rental_price->FormValue)) {
            $this->highest_rental_price->addErrorMessage($this->highest_rental_price->getErrorMessage(false));
        }
        if ($this->transfer->Required) {
            if ($this->transfer->FormValue == "") {
                $this->transfer->addErrorMessage(str_replace("%s", $this->transfer->caption(), $this->transfer->RequiredErrorMessage));
            }
        }
        if ($this->total_invertor_year->Required) {
            if (!$this->total_invertor_year->IsDetailKey && EmptyValue($this->total_invertor_year->FormValue)) {
                $this->total_invertor_year->addErrorMessage(str_replace("%s", $this->total_invertor_year->caption(), $this->total_invertor_year->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->total_invertor_year->FormValue)) {
            $this->total_invertor_year->addErrorMessage($this->total_invertor_year->getErrorMessage(false));
        }
        if ($this->invert_payoff_day->Required) {
            if (!$this->invert_payoff_day->IsDetailKey && EmptyValue($this->invert_payoff_day->FormValue)) {
                $this->invert_payoff_day->addErrorMessage(str_replace("%s", $this->invert_payoff_day->caption(), $this->invert_payoff_day->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invert_payoff_day->FormValue)) {
            $this->invert_payoff_day->addErrorMessage($this->invert_payoff_day->getErrorMessage(false));
        }
        if ($this->type_invertor->Required) {
            if (!$this->type_invertor->IsDetailKey && EmptyValue($this->type_invertor->FormValue)) {
                $this->type_invertor->addErrorMessage(str_replace("%s", $this->type_invertor->caption(), $this->type_invertor->RequiredErrorMessage));
            }
        }
        if ($this->invest_amount->Required) {
            if (!$this->invest_amount->IsDetailKey && EmptyValue($this->invest_amount->FormValue)) {
                $this->invest_amount->addErrorMessage(str_replace("%s", $this->invest_amount->caption(), $this->invest_amount->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->invest_amount->FormValue)) {
            $this->invest_amount->addErrorMessage($this->invest_amount->getErrorMessage(false));
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

            // firstname
            $this->firstname->setDbValueDef($rsnew, $this->firstname->CurrentValue, null, $this->firstname->ReadOnly);

            // lastname
            $this->lastname->setDbValueDef($rsnew, $this->lastname->CurrentValue, null, $this->lastname->ReadOnly);

            // phone
            $this->phone->setDbValueDef($rsnew, $this->phone->CurrentValue, null, $this->phone->ReadOnly);

            // email
            $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

            // investment
            $this->investment->setDbValueDef($rsnew, $this->investment->CurrentValue, null, $this->investment->ReadOnly);

            // credit_limit
            $this->credit_limit->setDbValueDef($rsnew, $this->credit_limit->CurrentValue, null, $this->credit_limit->ReadOnly);

            // monthly_payments
            $this->monthly_payments->setDbValueDef($rsnew, $this->monthly_payments->CurrentValue, null, $this->monthly_payments->ReadOnly);

            // highest_rental_price
            $this->highest_rental_price->setDbValueDef($rsnew, $this->highest_rental_price->CurrentValue, null, $this->highest_rental_price->ReadOnly);

            // transfer
            $this->transfer->setDbValueDef($rsnew, $this->transfer->CurrentValue, null, $this->transfer->ReadOnly);

            // total_invertor_year
            $this->total_invertor_year->setDbValueDef($rsnew, $this->total_invertor_year->CurrentValue, null, $this->total_invertor_year->ReadOnly);

            // invert_payoff_day
            $this->invert_payoff_day->setDbValueDef($rsnew, $this->invert_payoff_day->CurrentValue, null, $this->invert_payoff_day->ReadOnly);

            // type_invertor
            $this->type_invertor->setDbValueDef($rsnew, $this->type_invertor->CurrentValue, null, $this->type_invertor->ReadOnly);

            // invest_amount
            $this->invest_amount->setDbValueDef($rsnew, $this->invest_amount->CurrentValue, null, $this->invest_amount->ReadOnly);

            // udate
            $this->udate->CurrentValue = CurrentDateTime();
            $this->udate->setDbValueDef($rsnew, $this->udate->CurrentValue, null);

            // uuser
            $this->uuser->CurrentValue = CurrentUserID();
            $this->uuser->setDbValueDef($rsnew, $this->uuser->CurrentValue, null);

            // uip
            $this->uip->CurrentValue = CurrentUserIP();
            $this->uip->setDbValueDef($rsnew, $this->uip->CurrentValue, null);

            // Check referential integrity for master table 'investor'
            $detailKeys = [];
            $keyValue = $rsnew['member_id'] ?? $rsold['member_id'];
            $detailKeys['member_id'] = $keyValue;
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("investorverifylist"), "", $this->TableVar, true);
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
                case "x_member_id":
                    $conn = Conn("DB");
                    break;
                case "x_status":
                    break;
                case "x_transfer":
                    break;
                case "x_type_invertor":
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
